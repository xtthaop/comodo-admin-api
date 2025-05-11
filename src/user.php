<?php
  class User {
    private $_userLib;
    private $_captcha;
    private $_jwt;
    private $_sysUserLib;
    private $_sysLogLib;
    private $_client;

    public function __construct(
      UserLib $userLib, 
      Captcha $captcha, 
      JwtAuth $jwt, 
      SysUserLib $sysUserLib, 
      SysLogLib $sysLogLib,
      Client $client
    ){
      $this -> _userLib = $userLib;
      $this -> _captcha = $captcha;
      $this -> _jwt = $jwt;
      $this -> _sysUserLib = $sysUserLib;
      $this -> _sysLogLib = $sysLogLib;
      $this -> _client = $client;
    }

    public function handleUser(){
      $requestMethod = $_SERVER['REQUEST_METHOD'];
      $path = $_SERVER['PATH_INFO'];
      $params = explode('/', $path);
      switch($requestMethod){
        case 'POST':
          switch($params[2]){
            case 'login':
              return $this -> _handleUserLogin();
            case 'logout':
              return $this -> _handleUserLogout();
            default:
              throw new Exception('请求的资源不存在', 404);
          }
        case 'GET':
          switch($params[2]){
            case 'get_user_info':
              return $this -> _handleGetUserInfo();
            case 'get_jigsaw':
              return $this -> _handleGetJigsaw();
            default:
              throw new Exception('请求的资源不存在', 404);
          }
        case 'PUT':
          switch($params[2]){
            case 'change_password':
              return $this -> _handleChangePassword();
            default:
              throw new Exception('请求的资源不存在', 404);
          }
        default:
          throw new Exception('请求方法不被允许', 405);
      }
    }

    private function _handleGetJigsaw(){
      $res = $this -> _captcha -> makeCaptcha();
      $_SESSION['captcha_x'] = $res['x'];
      unset($res['x']);
      return [
        'code' => 0,
        'message' => 'success',
        'data' => $res,
      ];
    }

    private function _handleUserLogin(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(!$_SESSION['captcha_x']){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $xMax = $_SESSION['captcha_x'] + 6;
      $xMin = $_SESSION['captcha_x'] - 6;

      if(empty($body['x'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      if($body['x'] > $xMax || $body['x'] < $xMin){
        throw new Exception('拼图验证失败', ErrorCode::CAPTCHA_VERIFY_FAILED);
      }
  
      if(!(isset($body['username']) && strlen($body['username']))){
        throw new Exception("用户名不能为空", ErrorCode::USERNAME_CANNOT_EMPTY);
      }
  
      if(!(isset($body['password']) && strlen($body['password']))){
        throw new Exception("密码不能为空", ErrorCode::PASSWOED_CANNOT_EMPTY);
      }

      $password = $this -> _jwt -> md5Password($body['password']);
      $res = $this -> _userLib -> login($body['username'], $password);
  
      if(!empty($res)){
        $payload = $this -> _jwt -> generatePayload($res);
        $token = $this -> _jwt -> getToken($payload);
        $this -> _handleRecordLoginLog($body['username']);
  
        return [
          'code' => 0,
          'message' => 'success',
          'data' => [
            'token' => $token,
          ],
        ];
      }else{
        throw new Exception("用户名与密码不匹配", ErrorCode::USER_VERIFY_FAILED);
      }
    }

    private function _handleRecordLoginLog($username){
      $ipaddr = $this -> _client -> getIpAddress();
      $browser = $this -> _client -> getBrowser();
      $os = $this -> _client -> getOs();
      $id = $this -> _sysLogLib -> recordLoginLog($username, $ipaddr, $browser, $os);
    }

    private function _handleGetUserInfo(){
      global $gUserId;

      $res = $this -> _userLib -> getUserInfo($gUserId);
      $res['roles'] = $this -> _userLib -> getUserRoles($gUserId);

      if(empty($res['roles'])){
        $res['roles'] = array('');
      }

      if($this -> _sysUserLib -> checkUserIsAdminRole($gUserId)){
        $res['action_permission'] = array('*:*:*');
      }else{
        $res['action_permission'] = $this -> _userLib -> getUserActionPermission($gUserId);
      }

      if(empty($res['action_permission'])){
        $res['action_permission'] = array();
      }

      return [
        'code' => 0,
        'message' => 'success',
        'data' => $res,
      ];
    }

    private function _handleUserLogout(){
      $this -> _jwt -> addTokenToBlack($_SERVER['HTTP_X_TOKEN']);

      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handleChangePassword(){
      global $gUserId;
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(
        !(isset($body['old_password']) && strlen($body['old_password'])) ||
        !(isset($body['new_password']) && strlen($body['new_password'])) ||
        $body['confirm_password'] !== $body['new_password']
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $oldPassword = $this -> _jwt -> md5Password($body['old_password']);
      $res = $this -> _userLib -> verifyOldPassword($gUserId, $oldPassword);

      if(!empty($res)){
        $body['new_password'] = $this -> _jwt -> md5Password($body['new_password']);
        $this -> _userLib -> changePassword($gUserId, $body);
      }else{
        throw new Exception('旧密码验证失败', ErrorCode::OLD_PASSWORD_VERIFY_FAILED);
      }

      return [
        'code' => 0,
        'message' => 'success',
      ];
    }
  }
