<?php
  class SysMenu {
    private $_sysMenuLib;

    public function __construct(SysMenuLib $_sysMenuLib){
      $this -> _sysMenuLib = $_sysMenuLib;
    }

    public function handleSysMenu(){
      $requestMethod = $_SERVER['REQUEST_METHOD'];
      $path = $_SERVER['PATH_INFO'];
      $params = explode('/', $path);
      switch($requestMethod){
        case 'POST':
          return $this -> _handleAddSysMenu();
        case 'GET':
          switch($params[2]){
            case 'get_menu_list':
              return $this -> _handleGetSysMenuList();
            case 'get_menu_tree':
              return $this -> _handleGetSysMenuTree();
            default:
              throw new Exception('请求的资源不存在', 404);
          }
        case 'PUT':
          return $this -> _handleUpdateSysMenu();
        case 'DELETE':
          return $this -> _handleDeleteSysMenu();
        default:
          throw new Exception('请求方法不被允许', 405);
      }
    }

    private function _handleGetSysMenuList(){
      $params = $_GET;
      $res = $this -> _sysMenuLib -> getSysMenuList($params);

      foreach($res as &$value){
        $apiList = $this -> _sysMenuLib -> getMenuApi($value['menu_id']);
        $value['api_list'] = $apiList;
      }

      return [
        'code' => 0,
        'message' => 'success',
        'data' => [
          'sys_menu_list' => $res,
        ],
      ];
    }

    private function _handleGetSysMenuTree(){
      $res = $this -> _handleGetSysMenuListByPid(0);
      return [
        'code' => 0,
        'message' => 'success',
        'data' => [
          'sys_menu_tree' => $res,
        ],
      ];
    }

    private function _handleGetSysMenuListByPid($pid){
      $res = $this -> _sysMenuLib -> getSysMenuListByPid($pid);
      $tree = array();

      if(!empty($res)){
        foreach($res as &$value){
          $value['children'] = $this -> _handleGetSysMenuListByPid($value['menu_id']);
          $apiList = $this -> _sysMenuLib -> getMenuApi($value['menu_id']);
          $value['api_list'] = $apiList;
          $tree[] = $value;
        }
      }

      return $tree;
    }

    private function _handleAddSysMenu(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      $this -> _checkForRequired($body);
      $data = $this -> _convertBodyContent($body);

      $menuId = $this -> _sysMenuLib -> addMenu($data);
      $this -> _handleSetMenuApi($menuId, $data['apis']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handleSetMenuApi($menuId, $apis){
      $this -> _sysMenuLib -> clearMenuApi($menuId);
      if(empty($apis)){
        return;
      }else{
        foreach($apis as $value){
          $this -> _sysMenuLib -> setMenuApi($menuId, $value);
        }
      }
    }

    private function _checkForRequired($body){
      if(
        !(isset($body['title']) && strlen($body['title'])) ||
        !(isset($body['menu_type']) && strlen($body['menu_type'])) ||
        !(isset($body['parent_id']) && strlen($body['parent_id'])) ||
        !(isset($body['sort']) && strlen($body['sort']))
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      if(
        $body['menu_type'] === 'P' && !(isset($body['is_link']) && strlen($body['is_link']))
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      if(
        ($body['menu_type'] === 'P' && !$body['is_link']) &&
        (!(isset($body['component']) && strlen($body['component'])) ||
        !(isset($body['path']) && strlen($body['path'])))
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      if(
        ($body['menu_type'] === 'P' && !$body['is_link']) &&
        (isset($body['component']) && strlen($body['component'])) &&
        !str_starts_with($body['component'], '/')
      ){
        throw new Exception("组件路径必须以 '/' 开头", ErrorCode::START_WITH_SLASH);
      }

      if(
        ($body['menu_type'] === 'P' && !$body['is_link']) &&
        (isset($body['path']) && strlen($body['path'])) &&
        !str_starts_with($body['path'], '/')
      ){
        throw new Exception("路由地址必须以 '/' 开头", ErrorCode::START_WITH_SLASH);
      }

      if(
        ($body['menu_type'] === 'P' && $body['cache'] && !$body['is_link']) &&
        !(isset($body['route_name']) && strlen($body['route_name']))
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      if(
        ($body['menu_type'] === 'P' && $body['is_link']) &&
        !(isset($body['path']) && strlen($body['path']))
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $parent = $this -> _sysMenuLib -> getMenuInfo($body['parent_id']);
      $parentMenuType = $parent['menu_type'];
      $menuType = $body['menu_type'];
      if(
        ($parentMenuType === 'P' && $menuType === 'F') ||
        ($parentMenuType === 'B')
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $menuId = $body['menu_id'];
      if((isset($body['route_name']) && strlen($body['route_name']))){
        $existedRouteNameCount = $this -> _sysMenuLib -> getExistedCount('route_name', $body['route_name'], $menuId);
        if($existedRouteNameCount > 0){
          throw new Exception('路由名称已被使用', ErrorCode::ROUTE_NAME_EXISTED);
        }
      }

      if((isset($body['path']) && strlen($body['path']))){
        $existedRoutePathCount = $this -> _sysMenuLib -> getExistedCount('path', $body['path'], $menuId);
        if($existedRoutePathCount > 0){
          throw new Exception('路由地址已被使用', ErrorCode::ROUTE_PATH_EXISTED);
        }
      }

      if((isset($body['permission']) && strlen($body['permission']))){
        $existedPermissionCount = $this -> _sysMenuLib -> getExistedCount('permission', $body['permission'], $menuId);
        if($existedPermissionCount > 0){
          throw new Exception('权限标识已被使用', ErrorCode::PERMISSION_EXISTED);
        }
      }
    }

    private function _convertBodyContent($body){
      ['parent_id' => $parentId, 'menu_id' => $menuId, 'title' => $title, 'sort' => $sort, 'menu_type' => $menuType] = $body;
      $baseObj = ['parent_id' => $parentId, 'menu_id' => $menuId, 'title' => $title, 'sort' => $sort, 'menu_type' => $menuType];
      switch($menuType){
        case 'F': {
          ['icon' => $icon, 'visible' => $visible, 'permission' => $permission] = $body;
          $visible = (isset($visible) && strlen($visible)) ? $visible : 1;
          return array_merge($baseObj, ['icon' => $icon, 'visible' => $visible, 'permission' => $permission]);
        }
        case 'P': {
          if($isLink){
            ['icon' => $icon, 'visible' => $visible, 'is_link' => $isLink] = $body;
            ['path' => $path, 'permission' => $permission] = $body;
            $visible = (isset($visible) && strlen($visible)) ? $visible : 1;
            return array_merge($baseObj, ['icon' => $icon, 'visible' => $visible, 'is_link' => $isLink, 'path' => $path, 'permission' => $permission]);
          }else{
            $parent = $this -> _sysMenuLib -> getMenuInfo($parentId);
            $body['visible'] = (isset($body['visible']) && strlen($body['visible'])) ? $body['visible'] : 1;
            $body['cache'] = (isset($body['cache']) && strlen($body['cache'])) ? $body['cache'] : 0;
            $body['layout'] = (isset($body['layout']) && strlen($body['layout'])) ? $body['layout'] : 1;
            if($parent['menu_type'] !== 'P'){
              $body['active_menu'] = null;
            }
            return $body;
          }
        }
        case 'B': {
          ['permission' => $permission, 'apis' => $apis] = $body;
          return array_merge($baseObj, ['permission' => $permission, 'apis' => $apis]);
        }
        default: {
          throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
        }
      }
    }

    private function _handleUpdateSysMenu(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['menu_id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _checkForRequired($body);
      $data = $this -> _convertBodyContent($body);

      $menuInfo = $this -> _sysMenuLib -> getMenuInfo($data['menu_id']);

      if($data['parent_id'] == $menuInfo['menu_id']){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _sysMenuLib -> updateMenu($data);
      $this -> _handleSetMenuApi($data['menu_id'], $data['apis']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handleDeleteSysMenu(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['menu_id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $permission = $this -> _sysMenuLib -> getMenuInfo($body['menu_id'])['permission'];
      $this -> _handlePrevent($body['menu_id'], $permission);
      $this -> _handleDeleteMenuByPid($body['menu_id']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handlePrevent($id, $permission){
      if($permission === 'admin:sysmenu'){
        throw new Exception('删除失败（包含不允许被删除的菜单）', ErrorCode::MENU_CANT_DELETE);
      }

      $res = $this -> _sysMenuLib -> getSysMenuListByPid($id);

      if(!empty($res)){
        foreach($res as &$value){
          $this -> _handlePrevent($value['menu_id'], $value['permission']);
        }
      }

      return;
    }

    private function _handleDeleteMenuByPid($id){
      $this -> _sysMenuLib -> deleteMenu($id);
      $res = $this -> _sysMenuLib -> getSysMenuListByPid($id);

      if(!empty($res)){
        foreach($res as &$value){
          $this -> _handleDeleteMenuByPid($value['menu_id']);
        }
      }

      return;
    }
  }
