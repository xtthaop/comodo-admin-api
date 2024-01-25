<?php
  session_start();
  date_default_timezone_set('PRC');
  require './src/ErrorCode.php';
  $pdo = require './lib/db.php';

  require './src/admin/dict_type.php';
  require './src/admin/dict_data.php';
  require './src/admin/sys_api.php';
  require './src/admin/sys_menu.php';
  require './src/admin/sys_role.php';
  require './src/admin/sys_user.php';
  require './src/user.php';
  require './src/permission.php';
  require './src/admin/sys_log.php';

  require './lib/admin/DictType.php';
  require './lib/admin/DictData.php';
  require './lib/admin/SysApi.php';
  require './lib/admin/SysMenu.php';
  require './lib/admin/SysRole.php';
  require './lib/admin/SysUser.php';
  require './lib/User.php';
  require './lib/Permission.php';
  require './lib/admin/SysLog.php';

  require './utils/captcha.php';
  require './utils/jwt.php';
  require './utils/client.php';

  class Restful{
    private $_dictType;
    private $_dictData;
    private $_sysApi;
    private $_sysMenu;
    private $_sysRole;
    private $_sysUser;
    private $_user;
    private $_permission;
    private $_sysLog;

    private $_requestMethod;
    private $_resourceName;
    private $_allowResource = [
      'dict_type', 
      'dict_data', 
      'sys_api', 
      'sys_menu', 
      'sys_role', 
      'sys_user', 
      'user',
      'permission',
      'sys_log'
    ];
    private $_allowRequestMethod = ['GET', 'PUT', 'POST', 'DELETE', 'OPTIONS'];
    private $_statusCode = [
      200 => 'OK',
      204 => 'No Content',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      403 => 'Forbidden',
      404 => 'Not Found',
      405 => 'Method Not Allowed',
      500 => 'Server Internal Error',
    ];
    private $_whiteListWithoutToken = ['/user/login', '/user/get_jigsaw'];
    private $_operationStartTime;

    public function __construct(
      DictType $dictType, 
      DictData $dictData, 
      SysApi $sysApi, 
      SysMenu $sysMenu, 
      SysRole $sysRole,
      SysUser $sysUser,
      User $user,
      JwtAuth $jwt,
      Permission $permission,
      SysLog $sysLog
    ){
      $this -> _dictType = $dictType;
      $this -> _dictData = $dictData;
      $this -> _sysApi = $sysApi;
      $this -> _sysMenu = $sysMenu;
      $this -> _sysRole = $sysRole;
      $this -> _sysUser = $sysUser;
      $this -> _user = $user;
      $this -> _jwt = $jwt;
      $this -> _permission = $permission;
      $this -> _sysLog = $sysLog;
    }

    private function _setupRequestMethod(){
      $this -> _requestMethod = $_SERVER['REQUEST_METHOD'];
      if(!in_array($this -> _requestMethod, $this -> _allowRequestMethod)){
        throw new Exception("请求方法不被允许", 405);
      }
    }

    private function _setupResource(){
      $path = $_SERVER['PATH_INFO'];
      $params = explode('/', $path);
      $this -> _resourceName = $params[1];
      if(!in_array($this -> _resourceName, $this -> _allowResource)){
        throw new Exception("请求的资源不存在", 400);
      }
    }

    private function _handleVerifyToken(){
      global $gUserId;
      global $gUserName;
      $path = $_SERVER['PATH_INFO'];

      if(empty($_SERVER['HTTP_X_TOKEN'])){
        if(!in_array($path, $this -> _whiteListWithoutToken)){
          throw new Exception("权限验证失败，请重新登录", 401);
        }
      }else{
        if(in_array($path, $this -> _whiteListWithoutToken)){
          return;
        }

        $tokenInBlack = $this -> _jwt -> checkTokenInBlack($_SERVER['HTTP_X_TOKEN']);
        if($tokenInBlack){
          throw new Exception("权限验证失败，请重新登录", 401);
        }

        $res = $this -> _jwt -> verifyToken($_SERVER['HTTP_X_TOKEN']);

        if(!empty($res)){
          $gUserId = $res['uid'];
          $gUserName = $res['unm'];
          if(empty($this -> _permission -> handleCheckUserEnabled())){
            $this -> _jwt -> addTokenToBlack($_SERVER['HTTP_X_TOKEN']);
            throw new Exception("您的账户已被禁用", ErrorCode::USER_HAS_UNENABLED);
          }
          if(!($this -> _permission -> checkApiPermission())){
            throw new Exception("访问被拒绝", 403);
          }
        }else{
          throw new Exception("权限验证失败，请重新登录", 401);
        }
      }
    }

    private function _handleRecordOperationLog(){
      global $gUserName;
      $path = $_SERVER['PATH_INFO'];
      if(
        !in_array($path, $this -> _whiteListWithoutToken) &&
        !in_array($path, $this -> _permission -> _whiteListWithoutPermission)
      ){
        $operationTime = $this -> _operationStartTime;
        $latencyTime = (string)(round((microtime(true) - $operationTime)*1000, 2)) . 'ms';
        $operationTime = date('Y-m-d H:i:s', $this -> _operationStartTime);
        $this -> _sysLog -> recordOperationLog($gUserName, $operationTime, $latencyTime);
      }
    }

    private function _json($array){
      $this -> _handleRecordOperationLog();
      $code = $array['code'];
      if($code > 0 && $code < 2000 && $code != 200 && $code != 204){
        header('HTTP/1.1 ' . $code . ' ' . $this -> _statusCode[$code]);
      }
      header('Content-Type:application/json;charset=utf-8');
      echo json_encode($array, JSON_UNESCAPED_UNICODE);
      exit();
    }

    public function run(){
      try{
        $this -> _operationStartTime = microtime(true);
        $this -> _setupRequestMethod();
        $this -> _setupResource();
        $this -> _handleVerifyToken();
        if($this -> _resourceName == 'dict_type'){
          $this -> _json($this -> _dictType -> handleDictType());
        }
        if($this -> _resourceName == 'dict_data'){
          $this -> _json($this -> _dictData -> handleDictData());
        }
        if($this -> _resourceName == 'sys_api'){
          $this -> _json($this -> _sysApi -> handleSysApi());
        }
        if($this -> _resourceName == 'sys_menu'){
          $this -> _json($this -> _sysMenu -> handleSysMenu());
        }
        if($this -> _resourceName == 'sys_role'){
          $this -> _json($this -> _sysRole -> handleSysRole());
        }
        if($this -> _resourceName == 'sys_user'){
          $this -> _json($this -> _sysUser -> handleSysUser());
        }
        if($this -> _resourceName == 'user'){
          $this -> _json($this -> _user -> handleUser());
        }
        if($this -> _resourceName == 'permission'){
          $this -> _json($this -> _permission -> handlePermission());
        }
        if($this -> _resourceName == 'sys_log'){
          $this -> _json($this -> _sysLog -> handleSysLog());
        }
      }catch(Exception $e){
        $this -> _json(['message' => $e -> getMessage(), 'code' => $e -> getCode()]);
      }
    }
  }

  $captcha = new Captcha();
  $jwt = new JwtAuth();
  $client = new Client();

  $dictTypeLib = new DictTypeLib($pdo);
  $dictDataLib = new DictDataLib($pdo);
  $sysApiLib = new SysApiLib($pdo);
  $sysMenuLib = new SysMenuLib($pdo);
  $sysRoleLib = new SysRoleLib($pdo);
  $sysUserLib = new SysUserLib($pdo);
  $userLib = new UserLib($pdo);
  $permissionLib = new PermissionLib($pdo);
  $sysLogLib = new SysLogLib($pdo);

  $dictType = new DictType($dictTypeLib);
  $dictData = new DictData($dictDataLib);
  $sysApi = new SysApi($sysApiLib);
  $sysMenu = new SysMenu($sysMenuLib);
  $sysRole = new SysRole($sysRoleLib);
  $sysUser = new SysUser($sysUserLib, $sysRoleLib, $jwt);
  $user = new User($userLib, $captcha, $jwt, $sysUserLib, $sysLogLib, $client);
  $permission = new Permission($permissionLib, $sysUserLib, $sysMenuLib);
  $sysLog = new SysLog($sysLogLib, $client);

  $restful = new Restful(
    $dictType, 
    $dictData, 
    $sysApi, 
    $sysMenu, 
    $sysRole, 
    $sysUser, 
    $user, 
    $jwt, 
    $permission,
    $sysLog
  );
  $restful -> run();
