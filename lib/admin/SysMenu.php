<?php
  class SysMenuLib {
    private $_db;

    public function __construct($db){
      $this -> _db = $db;
    }

    public function getSysMenuList($params){
      $sql = 'SELECT * from `sys_menu` WHERE 1=1';
      $arr = array();

      if(isset($params['title']) && strlen($params['title'])){
        $sql .= ' AND `title` LIKE :title';
        $arr[':title'] = '%' . $params['title'] . '%';
      }

      if(isset($params['visible']) && strlen($params['visible'])){
        $sql .= ' AND `visible`=:visible';
        $arr[':visible'] = $params['visible'];
      }

      $sql .= ' ORDER BY `created_at` DESC';

      $stml = $this -> _db -> prepare($sql);
      $stml -> execute($arr);
      $result = $stml -> fetchAll(PDO::FETCH_ASSOC);
      
      return $result;
    }

    public function getSysMenuListByPid($pid){
      $sql = 'SELECT * FROM `sys_menu` WHERE `parent_id`=:parent_id ORDER BY `sort`, `created_at` DESC';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':parent_id', $pid);
      $stml -> execute();
      $result = $stml -> fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    public function getMenuApi($menuId){
      $sql = 'SELECT * FROM `sys_api` WHERE `id` IN (SELECT `sys_api_id` FROM `sys_menu_api_rule` 
              WHERE `sys_menu_id`=:sys_menu_id)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':sys_menu_id', $menuId);
      $stml -> execute();
      $result = $stml -> fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    public function addMenu($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'INSERT INTO `sys_menu` (`title`, `route_name`, `component`, `sort`, `path`, 
             `parent_id`, `icon`, `menu_type`, `is_link`, `visible`, `permission`, `layout`, `cache`, `active_menu`, `create_by`, `created_at`) 
             VALUES (:title, :route_name, :component, :sort, :path, :parent_id, :icon, :menu_type, :is_link, 
             :visible, :permission, :layout, :cache, :active_menu, :create_by, :created_at)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':title', $body['title']);
      $stml -> bindParam(':route_name', $body['route_name']);
      $stml -> bindParam(':component', $body['component']);
      $stml -> bindParam(':sort', $body['sort']);
      $stml -> bindParam(':menu_type', $body['menu_type']);
      $stml -> bindParam(':path', $body['path']);
      $stml -> bindParam(':parent_id', $body['parent_id']);
      $stml -> bindParam(':icon', $body['icon']);
      $stml -> bindParam(':is_link', $body['is_link']);
      $stml -> bindParam(':visible', $body['visible']);
      $stml -> bindParam(':permission', $body['permission']);
      $stml -> bindParam(':layout', $body['layout']);
      $stml -> bindParam(':cache', $body['cache']);
      $stml -> bindParam(':active_menu', $body['active_menu']);
      $stml -> bindParam(':create_by', $gUserId);
      $stml -> bindParam(':created_at', $currentTime);
      $stml -> execute();
      return $this -> _db -> lastInsertId();
    }

    public function clearMenuApi($menuId){
      $sql = 'DELETE FROM `sys_menu_api_rule` WHERE `sys_menu_id`=:sys_menu_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':sys_menu_id', $menuId);
      $stml -> execute();
    }

    public function setMenuApi($menuId, $apiId){
      $sql = 'INSERT INTO `sys_menu_api_rule` (`sys_menu_id`, `sys_api_id`) 
              VALUES (:sys_menu_id, :sys_api_id)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':sys_menu_id', $menuId);
      $stml -> bindParam(':sys_api_id', $apiId);
      $stml -> execute();
    }

    public function getExistedCount($column, $value, $id){
      $id = $id ? $id : 0;
      $sql = 'SELECT COUNT(*) FROM `sys_menu` WHERE ' . $column . '=:' . $column . ' AND `menu_id`!=:menu_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':' . $column, $value);
      $stml -> bindParam(':menu_id', $id);
      $stml -> execute();
      $result = $stml -> fetch();
      return $result[0];
    }

    public function updateMenu($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'UPDATE `sys_menu` SET `title`=:title, `route_name`=:route_name, `component`=:component, 
             `sort`=:sort, `path`=:path, `parent_id`=:parent_id, `icon`=:icon, `menu_type`=:menu_type, 
             `is_link`=:is_link, `visible`=:visible, `permission`=:permission, `layout`=:layout, `cache`=:cache, `active_menu`=:active_menu, 
             `update_by`=:update_by, `updated_at`=:updated_at WHERE `menu_id`=:menu_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':menu_id', $body['menu_id']);
      $stml -> bindParam(':title', $body['title']);
      $stml -> bindParam(':route_name', $body['route_name']);
      $stml -> bindParam(':component', $body['component']);
      $stml -> bindParam(':sort', $body['sort']);
      $stml -> bindParam(':menu_type', $body['menu_type']);
      $stml -> bindParam(':path', $body['path']);
      $stml -> bindParam(':parent_id', $body['parent_id']);
      $stml -> bindParam(':icon', $body['icon']);
      $stml -> bindParam(':is_link', $body['is_link']);
      $stml -> bindParam(':visible', $body['visible']);
      $stml -> bindParam(':permission', $body['permission']);
      $stml -> bindParam(':layout', $body['layout']);
      $stml -> bindParam(':cache', $body['cache']);
      $stml -> bindParam(':active_menu', $body['active_menu']);
      $stml -> bindParam(':update_by', $gUserId);
      $stml -> bindParam(':updated_at', $currentTime);
      $stml -> execute();
    }

    public function deleteMenu($id){
      $sql = 'DELETE FROM `sys_menu` WHERE `menu_id`=:menu_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':menu_id', $id);
      $stml -> execute();
    }

    public function getMenuInfo($id){
      $sql = 'SELECT * FROM `sys_menu` WHERE `menu_id`=:menu_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':menu_id', $id);
      $stml -> execute();
      $result = $stml -> fetch();
      return $result;
    }

    public function getAllSysMenuPath(){
      $sql = 'SELECT DISTINCT `path` FROM `sys_menu` WHERE `path` IS NOT NULL';
      $stml = $this -> _db -> prepare($sql);
      $stml -> execute();
      $result = $stml -> fetchAll(PDO::FETCH_NUM);
      return $result;
    }
  }