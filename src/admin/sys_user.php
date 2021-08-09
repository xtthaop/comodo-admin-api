<?php
  class SysUser {
    private $_sysUserLib;

    public function __construct(SysUserLib $sysUserLib){
      $this -> _sysUserLib = $sysUserLib;
    }

    public function handleSysUser(){
      $requestMethod = $_SERVER['REQUEST_METHOD'];
      $path = $_SERVER['PATH_INFO'];
      $params = explode('/', $path);
      switch($requestMethod){
        case 'POST':
          return $this -> _handleAddSysUser();
        case 'GET':
          return $this -> _handleGetSysUser();
        case 'PUT':
          switch($params[2]){
            case 'update_user':
              return $this -> _handleUpdateSysUser();
            case 'change_user_status':
              return $this -> _handleChangeUserStatus();
            case 'reset_password':
              return $this -> _handleResetPassword();
            default:
              throw new Exception('请求的资源不存在', 404);
          }
        case 'DELETE':
          return $this -> _handleDeleteSysUser();
        default:
          throw new Exception('请求方法不被允许', 405);
      }
    }

    private function _handleGetSysUser(){
      $params = $_GET;
      $res = $this -> _sysUserLib -> getSysUserList($params);

      foreach($res['data'] as &$value){
        $roleList = $this -> _sysUserLib -> getUserRole($value['user_id']);
        $value['role_list'] = $roleList;
        unset($value['password']);
      }

      return [
        'code' => 0,
        'message' => 'success',
        'data' => [
          'total' => $res['total'],
          'sys_user_list' => $res['data'],
        ],
      ];
    }

    private function _handleAddSysUser(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(!(isset($body['password']) && strlen($body['password']))){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _checkForRequired($body);

      $body['password'] = $this -> _md5($body['password']);
      $userId = $this -> _sysUserLib -> addUser($body);
      $this -> _handleSetUserRole($userId, $body['role_ids']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _md5($string, $key = 'CmDo@oo!19@96#'){
      return md5($string . $key);
    }

    private function _handleSetUserRole($userId, $roleIds){
      $this -> _sysUserLib -> clearUserRole($userId);
      if(empty($roleIds)){
        return;
      }else{
        foreach($roleIds as $value){
          $this -> _sysUserLib -> setUserRole($userId, $value);
        }
      }
    }

    private function _checkForRequired($body){
      if(
        !(isset($body['username']) && strlen($body['username'])) ||
        !(isset($body['phone']) && strlen($body['phone'])) ||
        !(isset($body['email']) && strlen($body['email']))
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $userId = empty($body['user_id']) ? '' : $body['user_id'];

      $username = !(isset($body['username']) && strlen($body['username'])) ? null : $body['username'];
      $existedUsernameCount = $this -> _sysUserLib -> getExistedCount('username', $username, $userId);
      if($existedUsernameCount > 0){
        throw new Exception('用户名称已被使用', ErrorCode::USER_NAME_EXISTED);
      }
    }

    private function _handleUpdateSysUser(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['user_id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _checkForRequired($body);
      $this -> _handlePreventUpdate($body);

      $this -> _sysUserLib -> updateUser($body);
      $this -> _handleSetUserRole($body['user_id'], $body['role_ids']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handlePreventUpdate($body){
      $isAdmin = $this -> _sysUserLib -> checkUserIsAdmin($body['user_id']);
      if(!$isAdmin){
        return;
      }else{
        $adminUser = $this -> _sysUserLib -> getAdminUser();
        if(count($adminUser) === 1 && $adminUser[0]['user_id'] === $body['user_id']){
          $userInfo = $this -> _sysUserLib -> getUserInfo($body['user_id']);
          if(
            empty($body['role_ids']) ||
            !($this -> _sysUserLib -> checkForAdmin($body['role_ids'])) ||
            $body['status'] != $userInfo['status']
          ){
            throw new Exception('修改失败（包含不允许被修改的用户）', ErrorCode::USER_CANT_UPDATE);
          }
        }
      }
    }

    private function _handlePreventChangeStatus($body){
      $isAdmin = $this -> _sysUserLib -> checkUserIsAdmin($body['user_id']);
      if(!$isAdmin){
        return;
      }else{
        $adminUser = $this -> _sysUserLib -> getAdminUser();
        if(count($adminUser) === 1 && $adminUser[0]['user_id'] === $body['user_id']){
          $userInfo = $this -> _sysUserLib -> getUserInfo($body['user_id']);
          if($body['status'] != $userInfo['status']){
            throw new Exception('修改失败（包含不允许被修改的用户）', ErrorCode::USER_CANT_UPDATE);
          }
        }
      }
    }

    private function _handleChangeUserStatus(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(
        !(isset($body['status']) && strlen($body['status'])) || 
        empty($body['user_id'])
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _handlePreventChangeStatus($body);
      $this -> _sysUserLib -> changeRoleStatus($body);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handleDeleteSysUser(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['user_id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _handlePreventDelete($body['user_id']);
      $this -> _sysUserLib -> deleteUser($body['user_id']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handlePreventDelete($userId){
      $isAdmin = $this -> _sysUserLib -> checkUserIsAdmin($userId);
      if(!$isAdmin){
        return;
      }else{
        $adminUser = $this -> _sysUserLib -> getAdminUser();
        if(count($adminUser) === 1 && $adminUser[0]['user_id'] === $userId){
          throw new Exception('用户不能被删除', ErrorCode::USER_CANT_DELETE);
        }
      }
    }

    private function _handleResetPassword(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(
        !(isset($body['new_password']) && strlen($body['new_password'])) || 
        empty($body['user_id']))
      {
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $body['new_password'] = $this -> _md5($body['new_password']);
      $this -> _sysUserLib -> resetPassword($body);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }
  }
