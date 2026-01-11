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

      if(empty($body['password'])){
        throw new Exception('密码不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(strlen($body['password']) !== 32){
        throw new Exception('密码不完整', ErrorCode::INVALID_PARAMS);
      }

      $this -> _checkForRequired($body);

      if(!($body['status'] === 0 || $body['status'] === 1)){
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
            throw new Exception('所选角色中存在被禁用的角色', ErrorCode::INVALID_PARAMS);
          }
        }
        foreach($roleIds as $value){
          $this -> _sysUserLib -> setUserRole($userId, $value);
        }
      }
    }

    private function _checkForRequired($body){
      if(!(isset($body['username']) && strlen($body['username']))){
        throw new Exception('用户名不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!empty($body['phone'])){
        if(!preg_match('/^1[3-9]\d{9}$/', $body['phone'])){
          throw new Exception('手机号格式不正确', ErrorCode::INVALID_PARAMS);
        }
      }

      if(!is_array($body['role_ids'])){
        throw new Exception('角色参数必须为数组', ErrorCode::INVALID_PARAMS);
      }

      if(empty($body['role_ids'])){
        throw new Exception('角色不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!empty($body['email'])){
        if(!preg_match('/^(([^<>()\[\]\\\\.,;:\s@"]+(\.[^<>()\[\]\\\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9\x{00A0}-\x{D7FF}\x{F900}-\x{FDCF}\x{FDF0}-\x{FFEF}]+\.)+[a-zA-Z\x{00A0}-\x{D7FF}\x{F900}-\x{FDCF}\x{FDF0}-\x{FFEF}]{2,}))$/uD', $body['email'])){
          throw new Exception('邮箱格式不正确', ErrorCode::INVALID_PARAMS);
        }
      }

      $userId = empty($body['user_id']) ? 0 : $body['user_id'];

      $existedUsernameCount = $this -> _sysUserLib -> getExistedCount('username', $body['username'], $userId);
      if($existedUsernameCount > 0){
        throw new Exception('用户名已被使用', ErrorCode::INVALID_PARAMS);
      }

      if(!empty($body['nickname'])){
        $existedUsernameCount = $this -> _sysUserLib -> getExistedCount('nickname', $body['nickname'], $userId);
        if($existedUsernameCount > 0){
          throw new Exception('昵称已被使用', ErrorCode::INVALID_PARAMS);
        }
      }
    }

    private function _handleUpdateSysUser(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['user_id'])){
        throw new Exception('用户ID不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!isset($body['status'])){
        throw new Exception('用户状态不能为空', ErrorCode::INVALID_PARAMS);
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
      $userInfo = $this -> _sysUserLib -> getUserInfo($body['user_id']);
      if($userInfo['username'] === 'admin'){
        $roleList = $this -> _sysUserLib -> getUserRoleIds($body['user_id']);
        $userInfo['role_ids'] = array_reduce($roleList, function($result, $value){
          return array_merge($result, array_values($value));
        }, array());
        if($body['username'] != $userInfo['username']){
          throw new Exception('超级管理员用户名不允许被修改', ErrorCode::UPDATE_FAILED);
        }
        if($body['nickname'] != $userInfo['nickname']){
          throw new Exception('超级管理员昵称不允许被修改', ErrorCode::UPDATE_FAILED);
        }
        if($body['status'] != $userInfo['status']){
          throw new Exception('超级管理员状态不允许被修改', ErrorCode::UPDATE_FAILED);
        }
        if(json_encode($body['role_ids']) != json_encode($userInfo['role_ids'])){
          throw new Exception('超级管理员角色不允许被修改', ErrorCode::UPDATE_FAILED);
        }
      }
    }

    private function _handleDeleteSysUser(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['user_id'])){
        throw new Exception('用户ID不能为空', ErrorCode::INVALID_PARAMS);
      }

      $this -> _handlePreventDelete($body['user_id']);
      $this -> _sysUserLib -> deleteUser($body['user_id']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handlePreventDelete($userId){
      $userInfo = $this -> _sysUserLib -> getUserInfo($userId);
      if($userInfo['username'] === 'admin'){
        throw new Exception('超级管理员用户不能被删除', ErrorCode::DELETE_FAILED);
      }
    }

    private function _handleResetPassword(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['user_id'])){
        throw new Exception('用户ID不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(empty($body['new_password'])){
        throw new Exception('新密码不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(strlen($body['new_password']) !== 32){
        throw new Exception('新密码不完整', ErrorCode::INVALID_PARAMS);
      }

      $userInfo = $this -> _sysUserLib -> getUserInfo($body['user_id']);
      if($userInfo['username'] === 'admin'){
        throw new Exception('超级管理员密码不允许被重置', ErrorCode::UPDATE_FAILED);
      }

      $body['new_password'] = $this -> _jwt -> hashPassword($body['new_password']);
      $this -> _sysUserLib -> resetPassword($body);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }
  }
