<?php
  class SysRoleLib {
    private $_db;

    public function __construct($db){
      $this -> _db = $db;
    }

    public function getSysRoleList($params){
      $countSql = 'SELECT COUNT(*) from `sys_role` WHERE 1=1';
      $dataSql = 'SELECT * from `sys_role` WHERE 1=1';
      $arr = array();

      if(isset($params['role_name']) && strlen($params['role_name'])){
        $countSql .= ' AND `role_name` LIKE :role_name';
        $dataSql .= ' AND `role_name` LIKE :role_name';
        $arr[':role_name'] = '%' . $params['role_name'] . '%';
      }

      if(isset($params['role_key']) && strlen($params['role_key'])){
        $countSql .= ' AND `role_key` LIKE :role_key';
        $dataSql .= ' AND `role_key` LIKE :role_key';
        $arr[':role_key'] = '%' . $params['role_key'] . '%';
      }

      if(isset($params['status']) && strlen($params['status'])){
        $countSql .= ' AND `status`=:status';
        $dataSql .= ' AND `status`=:status';
        $arr[':status'] = $params['status'];
      }

      $stml = $this -> _db -> prepare($countSql);
      $stml -> execute($arr);
      $total = $stml -> fetch()[0];

      $dataSql .= ' ORDER BY `role_sort`, `created_at` DESC LIMIT :limit OFFSET :offset';
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

    public function getRoleMenuIds($roleId){
      $sql = 'SELECT `menu_id` FROM `sys_menu` WHERE `menu_id` IN (SELECT `menu_id` FROM `sys_role_menu_rule` 
              WHERE `role_id`=:role_id)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':role_id', $roleId);
      $stml -> execute();
      $result = $stml -> fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    public function addRole($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'INSERT INTO `sys_role` (`role_name`, `role_key`, `role_sort`, `status`, `check_strictly`, `remark`, `create_by`, 
             `created_at`) VALUES (:role_name, :role_key, :role_sort, :status, :check_strictly, :remark, :create_by, :created_at)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':role_name', $body['role_name']);
      $stml -> bindParam(':role_key', $body['role_key']);
      $stml -> bindParam(':role_sort', $body['role_sort']);
      $stml -> bindParam(':status', $body['status']);
      $stml -> bindParam(':check_strictly', $body['check_strictly']);
      $stml -> bindParam(':remark', $body['remark']);
      $stml -> bindParam(':create_by', $gUserId);
      $stml -> bindParam(':created_at', $currentTime);
      $stml -> execute();
      return $this -> _db -> lastInsertId();
    }

    public function clearRoleMenu($roleId){
      $sql = 'DELETE FROM `sys_role_menu_rule` WHERE `role_id`=:role_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':role_id', $roleId);
      $stml -> execute();
    }

    public function setRoleMenu($roleId, $menuId){
      $sql = 'INSERT INTO `sys_role_menu_rule` (`role_id`, `menu_id`) 
              VALUES (:role_id, :menu_id)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':menu_id', $menuId);
      $stml -> bindParam(':role_id', $roleId);
      $stml -> execute();
    }

    public function updateRole($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'UPDATE `sys_role` SET `role_name`=:role_name, `role_key`=:role_key, `role_sort`=:role_sort, 
             `status`=:status, `check_strictly`=:check_strictly, `remark`=:remark, `update_by`=:update_by, `updated_at`=:updated_at WHERE 
             `role_id`=:role_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':role_id', $body['role_id']);
      $stml -> bindParam(':role_name', $body['role_name']);
      $stml -> bindParam(':role_key', $body['role_key']);
      $stml -> bindParam(':role_sort', $body['role_sort']);
      $stml -> bindParam(':status', $body['status']);
      $stml -> bindParam(':check_strictly', $body['check_strictly']);
      $stml -> bindParam(':remark', $body['remark']);
      $stml -> bindParam(':update_by', $gUserId);
      $stml -> bindParam(':updated_at', $currentTime);
      $stml -> execute();
    }

    public function getExistedCount($column, $value, $id){
      $sql = 'SELECT COUNT(*) FROM `sys_role` WHERE ' . $column . '=:' . $column . ' AND `role_id`!=:role_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':' . $column, $value);
      $stml -> bindParam(':role_id', $id);
      $stml -> execute();
      $result = $stml -> fetch();
      return $result[0];
    }

    public function deleteRole($id){
      $sql = 'DELETE FROM `sys_role_menu_rule` WHERE `role_id` = :role_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':role_id', $id);
      $stml -> execute();

      $sql = 'DELETE FROM `sys_role` WHERE `role_id`=:role_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':role_id', $id);
      $stml -> execute();
    }

    public function getRoleInfo($id){
      $sql = 'SELECT * FROM `sys_role` WHERE `role_id`=:role_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':role_id', $id);
      $stml -> execute();
      $result = $stml -> fetch();
      return $result;
    }
  }