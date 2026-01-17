<?php
  class Permission {
    private $_permissionLib;
    private $_sysUserLib;
    private $_sysMenuLib;
    public $_whiteListWithoutPermission = [
      '/user/get_user_info', 
      '/dict_data/option_select',
      '/user/logout',
      '/user/change_password',
      '/permission/get_dynamic_routes'
    ];

    public function __construct(PermissionLib $permissionLib, SysUserLib $sysUserLib, SysMenuLib $sysMenuLib){
      $this -> _permissionLib = $permissionLib;
      $this -> _sysUserLib = $sysUserLib;
      $this -> _sysMenuLib = $sysMenuLib;
    }

    public function handlePermission(){
      $requestMethod = $_SERVER['REQUEST_METHOD'];
      $path = $_SERVER['PATH_INFO'];
      $params = explode('/', $path);
      switch($requestMethod){
        case 'GET':
          switch($params[2]){
            case 'get_dynamic_routes':
              return $this -> _handleGetDynamicRoutes();
            default:
              throw new Exception('请求的资源不存在', 404);
          }
        default:
          throw new Exception('请求方法不被允许', 405);
      }
    }

    public function handleCheckUserEnabled(){
      global $gUserId;
      $user = $this -> _permissionLib -> checkUserEnabled($gUserId);
      return $user;
    }

    public function checkApiPermission(){
      global $gUserId;
      $path = $_SERVER['PATH_INFO'];
      $method = $_SERVER['REQUEST_METHOD'];

      if(in_array($path, $this -> _whiteListWithoutPermission)){
        return true;
      }

      if($this -> _sysUserLib -> checkUserIsAdminRole($gUserId)){
        return true;
      }

      $userApi = $this -> _permissionLib -> getUserApi($gUserId, $method);
      if(!empty($userApi) && in_array($path, $userApi)){
        return true;
      }

      return false;
    }

    private function _handleGetDynamicRoutes(){
      global $gUserId;

      if($this -> _sysUserLib -> checkUserIsAdminRole($gUserId)){
        $dynamicRoutes = $this -> _generateAllRoutes();
      }else{
        $dynamicRoutes = $this -> _generatePermissionRoutes();
      }

      $allPath = $this -> _sysMenuLib -> getAllSysMenuPath();
      $allPath = array_reduce($allPath, function($result, $value){
        return array_merge($result, array_values($value));
      }, array());
      
      return [
        'code' => 0,
        'message' => 'success',
        'data' => [
          'dynamic_routes' => $dynamicRoutes,
          'all_path' => $allPath,
        ],
      ];
    }

    private function _generateAllRoutes($pid = 0){
      $res = $this -> _sysMenuLib -> getSysMenuListByPid($pid);
      $tree = array();
      if(!empty($res)){
        foreach($res as &$value){
          if($value['menu_type'] !== 'B'){
            $value['children'] = $this -> _generateAllRoutes($value['menu_id']);
            $tree[] = $value;
          }
        }
      }
      return $tree;
    }

    private function _generatePermissionRoutes($pid = 0){
      global $gUserId;
      $res = $this -> _permissionLib -> getPermissionMenuByPid($pid, $gUserId);
      $tree = array();
      if(!empty($res)){
        foreach($res as &$value){
          if($value['menu_type'] !== 'B'){
            $value['children'] = $this -> _generatePermissionRoutes($value['menu_id']);
            $tree[] = $value;
          }
        }
      }
      return $tree;
    }
  }