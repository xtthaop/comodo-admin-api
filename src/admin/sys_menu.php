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

      if(!($body['visible'] === 0 || $body['visible'] === 1)){
        $body['visible'] = 1;
      }

      if(!($body['is_link'] === 0 || $body['is_link'] === 1)){
        $body['is_link'] = 0;
      }

      if(!($body['cache'] === 0 || $body['cache'] === 1)){
        $body['cache'] = 0;
      }

      if(!($body['layout'] === 0 || $body['layout'] === 1)){
        $body['layout'] = 1;
      }

      if(!isset($body['sort'])){
        $body['sort'] = 0;
      }

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
      $menuId = $body['menu_id'];

      if(!(isset($body['parent_id']))){
        throw new Exception('父级菜单不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!(isset($body['title']) && strlen($body['title']))){
        throw new Exception('菜单名称不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!(isset($body['menu_type']) && strlen($body['menu_type']))){
        throw new Exception('菜单类型不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!in_array($body['menu_type'], ['F', 'P', 'B'])){
        throw new Exception('菜单类型错误', ErrorCode::INVALID_PARAMS);
      }

      $parentMenuType = 'F';
      if($body['parent_id'] !== 0){
        $parent = $this -> _sysMenuLib -> getMenuInfo($body['parent_id']);
        $parentMenuType = $parent['menu_type'];
      }
      $menuType = $body['menu_type'];

      if($parentMenuType === 'B'){
        throw new Exception('父级菜单不能是按钮', ErrorCode::INVALID_PARAMS);
      }

      if($parentMenuType === 'P' && $parent['is_link'] === 1){
        throw new Exception('父级菜单不能是外部链接页面', ErrorCode::INVALID_PARAMS);
      }

      if($parentMenuType === 'P' && $menuType === 'F'){
        throw new Exception('页面夹的父级菜单不能是页面', ErrorCode::INVALID_PARAMS);
      }

      if($parentMenuType === 'P' && $menuType === 'P'){
        if(isset($body['is_link']) && $body['is_link']){
          throw new Exception('父级菜单为页面时不支持创建外部链接页面菜单', ErrorCode::INVALID_PARAMS);
        }
        if(isset($body['visible']) && $body['visible']){
          throw new Exception('父级菜单为页面时不支持创建可显示页面菜单', ErrorCode::INVALID_PARAMS);
        }
      }

      if(($parentMenuType === 'F' && $menuType === 'P') || ($parentMenuType === 'P' && $menuType === 'P')){
        if(isset($body['is_link']) && !$body['is_link']){
          if(!(isset($body['component']) && strlen($body['component']))){
            throw new Exception('组件路径不能为空', ErrorCode::INVALID_PARAMS);
          }
          if(!(isset($body['path']) && strlen($body['path']))){
            throw new Exception('路由地址不能为空', ErrorCode::INVALID_PARAMS);
          }
          if(!str_starts_with($body['component'], '/')){
            throw new Exception('组件路径必须以 "/" 开头', ErrorCode::INVALID_PARAMS);
          }
          if(!str_starts_with($body['path'], '/')){
            throw new Exception('路由地址必须以 "/" 开头', ErrorCode::INVALID_PARAMS);
          }
          if(isset($body['cache']) && $body['cache'] && !(isset($body['route_name']) && strlen($body['route_name']))){
            throw new Exception('路由名称不能为空', ErrorCode::INVALID_PARAMS);
          }
          
          $existedRoutePathCount = $this -> _sysMenuLib -> getExistedCount('path', $body['path'], $menuId);
          if($existedRoutePathCount > 0){
            throw new Exception('路由地址已被使用', ErrorCode::INVALID_PARAMS);
          }

          if((isset($body['route_name']) && strlen($body['route_name']))){
            $existedRouteNameCount = $this -> _sysMenuLib -> getExistedCount('route_name', $body['route_name'], $menuId);
            if($existedRouteNameCount > 0){
              throw new Exception('路由名称已被使用', ErrorCode::INVALID_PARAMS);
            }
          }
        }

        if(isset($body['is_link']) && $body['is_link']){
          if(!(isset($body['path']) && strlen($body['path']))){
            throw new Exception('外部链接地址不能为空', ErrorCode::INVALID_PARAMS);
          }
          if(!preg_match('/^(https?:|mailto:|tel:)/', $body['path'])){
            throw new Exception('外部链接地址格式错误', ErrorCode::INVALID_PARAMS);
          }
        }
      }

      if((isset($body['permission']) && strlen($body['permission']))){
        $existedPermissionCount = $this -> _sysMenuLib -> getExistedCount('permission', $body['permission'], $menuId);
        if($existedPermissionCount > 0){
          throw new Exception('权限标识已被使用', ErrorCode::INVALID_PARAMS);
        }
      }
    }

    private function _convertBodyContent($body){
      ['parent_id' => $parentId, 'menu_id' => $menuId, 'title' => $title, 'sort' => $sort, 'menu_type' => $menuType] = $body;
      $baseObj = ['parent_id' => $parentId, 'menu_id' => $menuId, 'title' => $title, 'sort' => $sort, 'menu_type' => $menuType];
      switch($menuType){
        case 'F': {
          ['icon' => $icon, 'visible' => $visible, 'permission' => $permission] = $body;
          return array_merge($baseObj, ['icon' => $icon, 'visible' => $visible, 'permission' => $permission]);
        }
        case 'P': {
          if($isLink){
            ['icon' => $icon, 'visible' => $visible, 'is_link' => $isLink] = $body;
            ['path' => $path, 'permission' => $permission] = $body;
            return array_merge($baseObj, ['icon' => $icon, 'visible' => $visible, 'is_link' => $isLink, 'path' => $path, 'permission' => $permission]);
          }else{
            $parent = $this -> _sysMenuLib -> getMenuInfo($parentId);
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
          throw new Exception('菜单类型不存在', ErrorCode::INVALID_PARAMS);
        }
      }
    }

    private function _handleUpdateSysMenu(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(!isset($body['menu_id'])){
        throw new Exception('菜单ID不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!(isset($body['parent_id']))){
        throw new Exception('父级菜单不能为空', ErrorCode::INVALID_PARAMS);
      }

      $menuInfo = $this -> _sysMenuLib -> getMenuInfo($body['menu_id']);
      $parentMenuInfo = $this -> _sysMenuLib -> getMenuInfo($body['parent_id']);

      if(empty($menuInfo)){
        throw new Exception('菜单ID不存在', ErrorCode::INVALID_PARAMS);
      }

      if($body['parent_id'] == $menuInfo['menu_id']){
        throw new Exception('父菜单不能选自身', ErrorCode::INVALID_PARAMS);
      }

      if(!(isset($body['menu_type']) && strlen($body['menu_type']))){
        throw new Exception('菜单类型不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!in_array($body['menu_type'], ['F', 'P', 'B'])){
        throw new Exception('菜单类型错误', ErrorCode::INVALID_PARAMS);
      }

      if($body['menu_type'] !== $menuInfo['menu_type']){
        throw new Exception('禁止修改菜单类型', ErrorCode::INVALID_PARAMS);
      }

      if($body['menu_type'] === 'F'){
        if(!($body['parent_id'] === 0 || $parentMenuInfo['menu_type'] === 'F')){
          throw new Exception('页面夹的父级菜单只能是页面夹', ErrorCode::INVALID_PARAMS);
        }
      }

      if($body['menu_type'] === 'F' || $body['menu_type'] === 'P'){
        if(!isset($body['visible'])){
          throw new Exception('是否隐藏不能为空', ErrorCode::INVALID_PARAMS);
        }
        if($this -> _checkSuperNodeIdEqualMenuId($body['parent_id'], $menuInfo['menu_id'])){
          throw new Exception('父级菜单不能选择自身的子菜单', ErrorCode::INVALID_PARAMS);
        }
      }

      if($body['menu_type'] === 'P'){
        if(!isset($body['is_link'])){
          throw new Exception('是否为外部链接不能为空', ErrorCode::INVALID_PARAMS);
        }

        if($body['is_link'] != $menuInfo['is_link']){
          throw new Exception('页面是否为外链不支持修改', ErrorCode::UPDATE_FAILED);
        }

        if($body['is_link'] === 0){
          if(!isset($body['cache'])){
            throw new Exception('是否缓存不能为空', ErrorCode::INVALID_PARAMS);
          }
          if(!isset($body['layout'])){
            throw new Exception('是否显示布局不能为空', ErrorCode::INVALID_PARAMS);
          }
        }
      }

      if($menuInfo['permission'] === 'admin:sysmenu'){
        if($body['permission'] != $menuInfo['permission']){
          throw new Exception('菜单管理页面不允许修改权限标识', ErrorCode::UPDATE_FAILED);
        }
      }

      if(!isset($body['sort'])){
        $body['sort'] = 0;
      }

      $this -> _checkForRequired($body);
      $data = $this -> _convertBodyContent($body);

      $this -> _sysMenuLib -> updateMenu($data);
      $this -> _handleSetMenuApi($data['menu_id'], $data['apis']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _checkSuperNodeIdEqualMenuId($parentId, $menuId){
      $parent = $this -> _sysMenuLib -> getMenuInfo($parentId);
      if(empty($parent) || $parent['parent_id'] == 0){
        return false;
      }
      if($parent['parent_id'] === $menuId){
        return true;
      }
      return $this -> _checkSuperNodeIdEqualMenuId($parent['parent_id'], $menuId);
    }

    private function _handleDeleteSysMenu(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['menu_id'])){
        throw new Exception('菜单ID不能为空', ErrorCode::INVALID_PARAMS);
      }

      $permission = $this -> _sysMenuLib -> getMenuInfo($body['menu_id'])['permission'];
      $this -> _handlePreventDelete($body['menu_id'], $permission);
      $this -> _handleDeleteMenuByPid($body['menu_id']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handlePreventDelete($id, $permission){
      if($permission === 'admin:sysmenu'){
        throw new Exception('此菜单不允许被删除或者其子菜单中包含不允许被删除的菜单', ErrorCode::DELETE_FAILED);
      }

      $res = $this -> _sysMenuLib -> getSysMenuListByPid($id);

      if(!empty($res)){
        foreach($res as &$value){
          $this -> _handlePreventDelete($value['menu_id'], $value['permission']);
        }
      }
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
