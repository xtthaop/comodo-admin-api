<?php
  class SysUser {
    private $_sysUserLib;
    private $_sysRoleLib;
    private $_jwt;

    public function __construct(SysUserLib $sysUserLib, SysRoleLib $sysRoleLib, JwtAuth $jwt){
      $this -> _sysUserLib = $sysUserLib;
      $this -> _sysRoleLib = $sysRoleLib;
      $this -> _jwt = $jwt;
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
        $roleList = $this -> _sysUserLib -> getUserRoleIds($value['user_id']);
        $value['role_ids'] = array_reduce($roleList, function($result, $value){
          return array_merge($result, array_values($value));
        }, array());
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

      if (!(isset($body['status']) && strlen($body['status']))) {
        $body['status'] = 1;
      }

      $body['password'] = $this -> _jwt -> hashPassword($body['password']);
      $userId = $this -> _sysUserLib -> addUser($body);
      $this -> _handleSetUserRole($userId, $body['role_ids']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handleSetUserRole($userId, $roleIds){
      $this -> _sysUserLib -> clearUserRole($userId);
      if(empty($roleIds)){
        return;
      }else{
        foreach($roleIds as $value){
          $isUnactived = $this -> _sysRoleLib -> getRoleInfo($value)['status'];
          if($isUnactived === 0){
            throw new Exception('所选角色中存在被禁用的角色', ErrorCode::USER_ROLE_UNACTIVED);
          }
        }
        foreach($roleIds as $value){
          $this -> _sysUserLib -> setUserRole($userId, $value);
        }
      }
    }

    private function _checkForRequired($body){
      if(
        !(isset($body['username']) && strlen($body['username'])) ||
        !(isset($body['phone']) && strlen($body['phone'])) ||
        !(isset($body['nickname']) && strlen($body['nickname'])) ||
        empty($body['role_ids'])
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $userId = empty($body['user_id']) ? '' : $body['user_id'];

      $username = !(isset($body['username']) && strlen($body['username'])) ? null : $body['username'];
      $existedUsernameCount = $this -> _sysUserLib -> getExistedCount('username', $username, $userId);
      if($existedUsernameCount > 0){
        throw new Exception('用户名已被使用', ErrorCode::USER_NAME_EXISTED);
      }
    }

    private function _handleUpdateSysUser(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(
        empty($body['user_id']) ||
        !(isset($body['status']) && strlen($body['status']))
      ){
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
      $isAdmin = $this -> _sysUserLib -> checkUserIsAdminRole($body['user_id']);
      if(!$isAdmin){
        return;
      }else{
        $userInfo = $this -> _sysUserLib -> getUserInfo($body['user_id']);
        if($userInfo['username'] === 'admin'){
          $roleList = $this -> _sysUserLib -> getUserRoleIds($body['user_id']);
          $userInfo['role_ids'] = array_reduce($roleList, function($result, $value){
            return array_merge($result, array_values($value));
          }, array());
          if(
            $body['username'] != $userInfo['username'] ||
            $body['status'] != $userInfo['status'] ||
            json_encode($body['role_ids']) != json_encode($userInfo['role_ids'])
          ){
            throw new Exception('修改失败（不允许被修改的用户）', ErrorCode::USER_CANT_UPDATE);
          }
        }
      }
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
      $isAdmin = $this -> _sysUserLib -> checkUserIsAdminRole($userId);
      if(!$isAdmin){
        return;
      }else{
        $userInfo = $this -> _sysUserLib -> getUserInfo($userId);
        if($userInfo['username'] === 'admin'){
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

      $body['new_password'] = $this -> _jwt -> hashPassword($body['new_password']);
      $this -> _sysUserLib -> resetPassword($body);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }
  }
