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
        !(isset($body['menu_type']) && strlen($body['menu_type']))
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
        ($body['menu_type'] === 'P' && $body['cache'] && !$body['is_link']) &&
        !(isset($body['route_name']) && strlen($body['route_name']))
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
      $sort = $sort ? $sort : 0;
      $parentId = $parentId ? $parentId : 0;
      $baseObj = ['parent_id' => $parentId, 'menu_id' => $menuId, 'title' => $title, 'sort' => $sort, 'menu_type' => $menuType];
      switch($menuType){
        case 'F': {
          ['icon' => $icon, 'visible' => $visible] = $body;
          return array_merge($baseObj, ['icon' => $icon, 'visible' => $visible]);
        }
        case 'P': {
          ['icon' => $icon, 'visible' => $visible, 'is_link' => $isLink] = $body;
          if($isLink){
            ['path' => $path, 'permission' => $permission] = $body;
            return array_merge($baseObj, ['icon' => $icon, 'visible' => $visible, 'is_link' => $isLink, 'path' => $path, 'permission' => $permission]);
          }else{
            $parent = $this -> _sysMenuLib -> getMenuInfo($parentId);
            if($parent['menu_type'] !== 'P'){
              $body['active_menu'] = null;
            }
            if($parent['menu_type'] === 'P' && $body['menu_type'] === 'P'){
              $body['visible'] = 0;
              $body['is_link'] = 0;
            }
            return $body;
          }
        }
        case 'B': {
          ['permission' => $permission, 'apis' => $apis] = $body;
          return array_merge($baseObj, ['visible' => 2, 'permission' => $permission, 'apis' => $apis]);
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
      $parent = $this -> _sysMenuLib -> getMenuInfo($data['parent_id']);
      if($menuInfo['permission'] === 'admin:sysmenu'){
        if(
          $parent['menu_type'] === 'P' ||
          $data['permission'] != $menuInfo['permission'] ||
          $data['path'] !== $menuInfo['path'] ||
          $data['component'] != $menuInfo['component'] ||
          $data['route_name'] != $menuInfo['route_name'] ||
          $data['visible'] != $menuInfo['visible'] ||
          $data['is_link'] != $menuInfo['is_link'] ||
          $data['menu_type'] != $menuInfo['menu_type'] ||
          $data['layout'] != $menuInfo['layout'] ||
          $data['cache'] != $menuInfo['cache']
        ){
          throw new Exception('修改失败（包含不允许被修改的菜单）', ErrorCode::MENU_CANT_UPDATE);
        }
      }

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
