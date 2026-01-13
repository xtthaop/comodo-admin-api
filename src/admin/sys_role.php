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
          switch($params[2]){
            case 'page':
              return $this -> _handleGetSysRole();
            case 'list':
              return $this -> _handleGetSysAllRole();
            default:
              throw new Exception('请求的资源不存在', 404);
          }
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

    private function _handleGetSysAllRole(){
      $res = $this -> _sysRoleLib -> getSysAllRoleList();
      return [
        'code' => 0,
        'message' => 'success',
        'data' => [
          'sys_role_list' => $res,
        ],
      ];
    }

    private function _handleAddSysRole(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      $this -> _checkForRequired($body);

      if (!($body['status'] === 0 || $body['status'] === 1)) {
        $body['status'] = 1;
      }

      if(!isset($body['role_sort'])){
        $body['role_sort'] = 0;
      }

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
      if(!(isset($body['role_name']) && strlen($body['role_name']))){
        throw new Exception('角色名称不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!(isset($body['role_key']) && strlen($body['role_key']))){
        throw new Exception('角色标识不能为空', ErrorCode::INVALID_PARAMS);
      }

      if (!isset($body['check_strictly'])) {
        throw new Exception('菜单父子是否关联选择不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(isset($body['menu_ids']) && !is_array($body['menu_ids'])){
        throw new Exception('菜单参数必须为数组', ErrorCode::INVALID_PARAMS);
      }

      $roleId = empty($body['role_id']) ? 0 : $body['role_id'];

      $existedRoleNameCount = $this -> _sysRoleLib -> getExistedCount('role_name', $body['role_name'], $roleId);
      if($existedRoleNameCount > 0){
        throw new Exception('角色名称已被使用', ErrorCode::INVALID_PARAMS);
      }

      $existedRoleKeyCount = $this -> _sysRoleLib -> getExistedCount('role_key', $body['role_key'], $roleId);
      if($existedRoleKeyCount > 0){
        throw new Exception('角色标识已被使用', ErrorCode::INVALID_PARAMS);
      }
    }

    private function _handleUpdateSysRole(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['role_id'])){
        throw new Exception('角色ID不能为空', ErrorCode::INVALID_PARAMS);
      }

      if (!isset($body['status'])) {
        throw new Exception('角色状态不能为空', ErrorCode::INVALID_PARAMS);
      }

      $this -> _checkForRequired($body);

      $roleInfo = $this -> _sysRoleLib -> getRoleInfo($body['role_id']);
      if($roleInfo['role_key'] === 'admin'){
        if($body['role_name'] != $roleInfo['role_name']){
          throw new Exception('超级管理员角色名不允许被修改', ErrorCode::UPDATE_FAILED);
        }
        if($body['role_key'] != $roleInfo['role_key']){
          throw new Exception('超级管理员角色标识不允许被修改', ErrorCode::UPDATE_FAILED);
        }
        if($body['status'] != $roleInfo['status']){
          throw new Exception('超级管理员角色状态不允许被修改', ErrorCode::UPDATE_FAILED);
        }
        if(!empty($body['menu_ids'])){
          throw new Exception('超级管理员角色菜单不允许被修改', ErrorCode::UPDATE_FAILED);
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
        throw new Exception('角色ID不能为空', ErrorCode::INVALID_PARAMS);
      }

      $roleInfo = $this -> _sysRoleLib -> getRoleInfo($body['role_id']);
      if($roleInfo['role_key'] === 'admin'){
        throw new Exception('超级管理员角色不能被删除', ErrorCode::DELETE_FAILED);
      }

      $this -> _sysRoleLib -> deleteRole($body['role_id']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }
  }