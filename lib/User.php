<?php
  class UserLib {
    private $_db;

    public function __construct($db){
      $this -> _db = $db;
    }

    public function login($username, $password){
      $sql = 'SELECT `user_id`, `username` FROM `sys_user` WHERE `username`=:username AND `password`=:password';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':username', $username);
      $stml -> bindParam(':password', $password);
      $stml -> execute();
      $result = $stml -> fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function getUserInfo($userId){
      $sql = 'SELECT `username` FROM `sys_user` WHERE `user_id`=:user_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $userId);
      $stml -> execute();
      $result = $stml -> fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function getUserRoles($userId){
      $sql = 'SELECT DISTINCT `role_key` FROM `sys_role` WHERE `role_id` IN 
             (SELECT `role_id` FROM `sys_user_role_rule` WHERE `user_id`=:user_id) AND `status`=1';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $userId);
      $stml -> execute();
      $result = $stml -> fetchAll(PDO::FETCH_COLUMN, 0);
      return $result;
    }

    public function getUserActionPermission($userId){
      $sql = 'SELECT DISTINCT `permission` FROM `sys_menu` WHERE `menu_id` IN 
             (SELECT `menu_id` FROM `sys_role_menu_rule` WHERE role_id IN 
             (SELECT ur.role_id FROM `sys_user_role_rule` as ur INNER JOIN `sys_role` as r ON ur.role_id=r.role_id
             WHERE `user_id`=:user_id AND `status`=1))';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $userId);
      $stml -> execute();
      $result = $stml -> fetchAll(PDO::FETCH_COLUMN, 0);
      return $result;
    }

    public function verifyOldPassword($userId, $oldPassword){
      $sql = 'SELECT `user_id`, `username` FROM `sys_user` WHERE `user_id`=:user_id AND `password`=:password';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $userId);
      $stml -> bindParam(':password', $oldPassword);
      $stml -> execute();
      $result = $stml -> fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function changePassword($userId, $body){
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'UPDATE `sys_user` SET `password`=:password, `update_by`=:update_by, `updated_at`=:updated_at WHERE 
             `user_id`=:user_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $userId);
      $stml -> bindParam(':password', $body['new_password']);
      $stml -> bindParam(':update_by', $userId);
      $stml -> bindParam(':updated_at', $currentTime);
      $stml -> execute();
    }
  }