<?php
  class SysRole {
    private $_sysRoleLib;

    public function __construct(SysRoleLib $_sysRoleLib){
      $this -> _sysRoleLib = $_sysRoleLib;
    }

    public function handleSysRole(){
      $requestMethod = $_SERVER['REQUEST_METHOD'];
      $path = $_SERVER['PATH_INFO'];
      $params = explode('/', $path);
      switch($requestMethod){
        case 'POST':
          return $this -> _handleAddSysRole();
        case 'GET':
          return $this -> _handleGetSysRole();
        case 'PUT':
          return $this -> _handleUpdateSysRole();
        case 'DELETE':
          return $this -> _handleDeleteSysRole();
        default:
          throw new Exception('请求方法不被允许', 405);
      }
    }

    private function _handleGetSysRole(){
      $params = $_GET;
      $res = $this -> _sysRoleLib -> getSysRoleList($params);

      foreach($res['data'] as &$value){
        $menuList = $this -> _sysRoleLib -> getRoleMenuIds($value['role_id']);
        $value['menu_ids'] = array_reduce($menuList, function($result, $value){
          return array_merge($result, array_values($value));
        }, array());
      }

      return [
        'code' => 0,
        'message' => 'success',
        'data' => [
          'total' => $res['total'],
          'sys_role_list' => $res['data'],
        ],
      ];
    }

    private function _handleAddSysRole(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      $this -> _checkForRequired($body);

      $roleId = $this -> _sysRoleLib -> addRole($body);
      $this -> _handleSetRoleMenu($roleId, $body['menu_ids']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handleSetRoleMenu($roleId, $menuIds){
      $this -> _sysRoleLib -> clearRoleMenu($roleId);
      if(empty($menuIds)){
        return;
      }else{
        foreach($menuIds as $value){
          $this -> _sysRoleLib -> setRoleMenu($roleId, $value);
        }
      }
    }

    private function _checkForRequired($body){
      if(
        !(isset($body['role_name']) && strlen($body['role_name'])) ||
        !(isset($body['role_key']) && strlen($body['role_key'])) ||
        !(isset($body['role_sort']) && strlen($body['role_sort'])) ||
        !(isset($body['status']) && strlen($body['status']))
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $roleId = empty($body['role_id']) ? '' : $body['role_id'];

      $roleName = !(isset($body['role_name']) && strlen($body['role_name'])) ? null : $body['role_name'];
      $existedRoleNameCount = $this -> _sysRoleLib -> getExistedCount('role_name', $roleName, $roleId);
      if($existedRoleNameCount > 0){
        throw new Exception('角色名称已被使用', ErrorCode::ROLE_NAME_EXISTED);
      }

      $routeKey = !(isset($body['role_key']) && strlen($body['role_key'])) ? null : $body['role_key'];
      $existedRoleKeyCount = $this -> _sysRoleLib -> getExistedCount('role_key', $routeKey, $roleId);
      if($existedRoleKeyCount > 0){
        throw new Exception('角色标识已被使用', ErrorCode::ROLE_KEY_EXISTED);
      }
    }

    private function _handleUpdateSysRole(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['role_id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _checkForRequired($body);

      $roleInfo = $this -> _sysRoleLib -> getRoleInfo($body['role_id']);
      if($roleInfo['role_key'] === 'admin'){
        if(
          $body['role_key'] != $roleInfo['role_key'] ||
          $body['status'] != $roleInfo['status']
        ){
          throw new Exception('修改失败（包含不允许被修改的角色）', ErrorCode::ROLE_CANT_UPDATE);
        }
      }

      $this -> _sysRoleLib -> updateRole($body);
      $this -> _handleSetRoleMenu($body['role_id'], $body['menu_ids']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handleDeleteSysRole(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['role_id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $roleInfo = $this -> _sysRoleLib -> getRoleInfo($body['role_id']);
      if($roleInfo['role_key'] === 'admin'){
        throw new Exception('删除失败（包含不允许被删除的角色）', ErrorCode::ROLE_CANT_DELETE);
      }

      $this -> _sysRoleLib -> deleteRole($body['role_id']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }
  }