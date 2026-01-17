<?php
  class PermissionLib {
    private $_db;

    public function __construct($db){
      $this -> _db = $db;
    }

    public function checkUserEnabled($userId){
      $sql = 'SELECT `user_id` from `sys_user` WHERE `user_id`=:user_id AND `status`=1';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $userId);
      $stml -> execute();
      $result = $stml -> fetch();
      return $result;
    }

    public function getUserApi($userId, $method){
      $sql = 'SELECT DISTINCT `path` from `sys_api` WHERE `id` IN 
             (SELECT DISTINCT `sys_api_id` FROM `sys_menu_api_rule` WHERE `sys_menu_id` IN 
             (SELECT `menu_id` FROM `sys_role_menu_rule` WHERE `role_id` IN 
             (SELECT ur.role_id FROM `sys_user_role_rule` as `ur` INNER JOIN `sys_role` as r ON ur.role_id=r.role_id
             WHERE `user_id`=:user_id AND `status`=1))) AND `type`=:type';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $userId);
      $stml -> bindParam(':type', $method);
      $stml -> execute();
      $result = $stml -> fetchAll(PDO::FETCH_COLUMN, 0);
      return $result;
    }

    public function getPermissionMenuByPid($pid, $userId){
      $sql = 'SELECT * FROM `sys_menu` WHERE `parent_id`=:parent_id AND `menu_id` IN 
             (SELECT `menu_id` FROM `sys_role_menu_rule` WHERE `role_id` IN 
             (SELECT ur.role_id FROM `sys_user_role_rule` as `ur` INNER JOIN `sys_role` as r ON ur.role_id=r.role_id
             WHERE `user_id`=:user_id AND `status`=1)) ORDER BY `sort`, `created_at` DESC';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':parent_id', $pid);
      $stml -> bindParam(':user_id', $userId);
      $stml -> execute();
      $result = $stml -> fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }
  }