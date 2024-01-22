<?php
  class SysUserLib {
    private $_db;

    public function __construct($db){
      $this -> _db = $db;
    }

    public function getSysUserList($params){
      $countSql = 'SELECT COUNT(*) from `sys_user` WHERE 1=1';
      $dataSql = 'SELECT * from `sys_user` WHERE 1=1';
      $arr = array();

      if(isset($params['username']) && strlen($params['username'])){
        $countSql .= ' AND `username` LIKE :username';
        $dataSql .= ' AND `username` LIKE :username';
        $arr[':username'] = '%' . $params['username'] . '%';
      }

      if(isset($params['phone']) && strlen($params['phone'])){
        $countSql .= ' AND `phone` LIKE :phone';
        $dataSql .= ' AND `phone` LIKE :phone';
        $arr[':phone'] = '%' . $params['phone'] . '%';
      }

      if(isset($params['status']) && strlen($params['status'])){
        $countSql .= ' AND `status`=:status';
        $dataSql .= ' AND `status`=:status';
        $arr[':status'] = $params['status'];
      }

      $stml = $this -> _db -> prepare($countSql);
      $stml -> execute($arr);
      $total = $stml -> fetch()[0];

      $dataSql .= ' LIMIT :limit OFFSET :offset';
      $arr[':limit'] = $pageSize = empty($params['page_size']) ? 10 : $params['page_size'];
      $arr[':offset'] = empty($params['page']) ? 0 : ((int)$params['page'] - 1) * (int)$pageSize;

      $stml = $this -> _db -> prepare($dataSql);
      $stml -> execute($arr);
      $data = $stml -> fetchAll(PDO::FETCH_ASSOC);
      
      return [
        'data' => $data,
        'total' => $total
      ];
    }

    public function getUserRoleIds($userId){
      $sql = 'SELECT `role_id` FROM `sys_role` WHERE `role_id` IN (SELECT `role_id` FROM `sys_user_role_rule` 
              WHERE `user_id`=:user_id)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $userId);
      $stml -> execute();
      $result = $stml -> fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    public function addUser($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'INSERT INTO `sys_user` (`username`, `password`, `nickname`, `phone`, `email`, `sex`, `remark`, 
             `status`, `create_by`, `created_at`) VALUES (:username, :password, :nickname, :phone, :email, :sex, 
             :remark, :status, :create_by, :created_at)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':username', $body['username']);
      $stml -> bindParam(':password', $body['password']);
      $stml -> bindParam(':nickname', $body['nickname']);
      $stml -> bindParam(':phone', $body['phone']);
      $stml -> bindParam(':email', $body['email']);
      $stml -> bindParam(':sex', $body['sex']);
      $stml -> bindParam(':remark', $body['remark']);
      $stml -> bindParam(':status', $body['status']);
      $stml -> bindParam(':create_by', $gUserId);
      $stml -> bindParam(':created_at', $currentTime);
      $stml -> execute();
      return $this -> _db -> lastInsertId();
    }

    public function clearUserRole($userId){
      $sql = 'DELETE FROM `sys_user_role_rule` WHERE `user_id`=:user_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $userId);
      $stml -> execute();
    }

    public function setUserRole($userId, $roleId){
      $sql = 'INSERT INTO `sys_user_role_rule` (`user_id`, `role_id`) 
              VALUES (:user_id, :role_id)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':role_id', $roleId);
      $stml -> bindParam(':user_id', $userId);
      $stml -> execute();
    }

    public function updateUser($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'UPDATE `sys_user` SET `username`=:username, `phone`=:phone, `nickname`=:nickname, `email`=:email, `sex`=:sex, 
             `status`=:status, `remark`=:remark, `update_by`=:update_by, `updated_at`=:updated_at WHERE 
             `user_id`=:user_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $body['user_id']);
      $stml -> bindParam(':username', $body['username']);
      $stml -> bindParam(':phone', $body['phone']);
      $stml -> bindParam(':nickname', $body['nickname']);
      $stml -> bindParam(':email', $body['email']);
      $stml -> bindParam(':sex', $body['sex']);
      $stml -> bindParam(':remark', $body['remark']);
      $stml -> bindParam(':status', $body['status']);
      $stml -> bindParam(':update_by', $gUserId);
      $stml -> bindParam(':updated_at', $currentTime);
      $stml -> execute();
    }

    public function resetPassword($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'UPDATE `sys_user` SET `password`=:password, `update_by`=:update_by, `updated_at`=:updated_at WHERE 
             `user_id`=:user_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $body['user_id']);
      $stml -> bindParam(':password', $body['new_password']);
      $stml -> bindParam(':update_by', $gUserId);
      $stml -> bindParam(':updated_at', $currentTime);
      $stml -> execute();
    }

    public function deleteUser($id){
      $sql = 'DELETE FROM `sys_user` WHERE `user_id`=:user_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $id);
      $stml -> execute();
    }

    public function getExistedCount($column, $value, $id){
      $sql = 'SELECT COUNT(*) FROM `sys_user` WHERE ' . $column . '=:' . $column . ' AND `user_id`!=:user_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':' . $column, $value);
      $stml -> bindParam(':user_id', $id);
      $stml -> execute();
      $result = $stml -> fetch();
      return $result[0];
    }

    public function checkUserIsAdminRole($userId){
      $sql = 'SELECT COUNT(*) FROM `sys_user_role_rule` WHERE `user_id`=:user_id AND `role_id` IN 
             (SELECT `role_id` FROM `sys_role` WHERE `role_key`="admin")';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $userId);
      $stml -> execute();
      $result = $stml -> fetch();
      return $result[0];
    }

    public function getUserInfo($userId){
      $sql = 'SELECT * FROM `sys_user` WHERE `user_id`=:user_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':user_id', $userId);
      $stml -> execute();
      $result = $stml -> fetch();
      return $result;
    }
  }