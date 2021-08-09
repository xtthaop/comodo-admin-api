<?php
  class DictTypeLib {
    private $_db;

    public function __construct($db){
      $this -> _db = $db;
    }

    public function getDictTypeList($params){
      $countSql = 'SELECT COUNT(*) from `sys_dict_type` WHERE 1=1';
      $dataSql = 'SELECT * from `sys_dict_type` WHERE 1=1';
      $arr = array();

      if(isset($params['dict_name']) && strlen($params['dict_name'])){
        $countSql .= ' AND `dict_name` LIKE :dict_name';
        $dataSql .= ' AND `dict_name` LIKE :dict_name';
        $arr[':dict_name'] = '%' . $params['dict_name'] . '%';
      }

      if(isset($params['dict_type']) && strlen($params['dict_type'])){
        $countSql .= ' AND `dict_type` LIKE :dict_type';
        $dataSql .= ' AND `dict_type` LIKE :dict_type';
        $arr[':dict_type'] = '%' . $params['dict_type'] . '%';
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
      $arr[':limit'] = empty($params['page_size']) ? 10 : $params['page_size'];
      $arr[':offset'] = empty($params['page']) ? 0 : ($params['page'] - 1) * $params['page_size'];

      $stml = $this -> _db -> prepare($dataSql);
      $stml -> execute($arr);
      $data = $stml -> fetchAll(PDO::FETCH_ASSOC);

      return [
        'data' => $data,
        'total' => $total
      ];
    }

    public function getExistedCount($column, $value, $id){
      $sql = 'SELECT COUNT(*) FROM `sys_dict_type` WHERE ' . $column . '=:' . $column . ' AND `dict_id`!=:dict_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':' . $column, $value);
      $stml -> bindParam(':dict_id', $id);
      $stml -> execute();
      $result = $stml -> fetch();
      return $result[0];
    }

    public function addDictType($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'INSERT INTO `sys_dict_type` 
             (`dict_name`, `dict_type`, `status`, `remark`, `create_by`, `created_at`) 
             VALUES (:dict_name, :dict_type, :status, :remark, :create_by, :created_at)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':dict_name', $body['dict_name']);
      $stml -> bindParam(':dict_type', $body['dict_type']);
      $stml -> bindParam(':status', $body['status']);
      $stml -> bindParam(':remark', $body['remark']);
      $stml -> bindParam(':create_by', $gUserId);
      $stml -> bindParam(':created_at', $currentTime);
      $stml -> execute();
    }

    public function updateDictType($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'UPDATE `sys_dict_type` SET `dict_name`=:dict_name, `dict_type`=:dict_type, `status`=:status, 
             `remark`=:remark, `update_by`=:update_by, `updated_at`=:updated_at WHERE `dict_id`=:dict_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':dict_name', $body['dict_name']);
      $stml -> bindParam(':dict_type', $body['dict_type']);
      $stml -> bindParam(':status', $body['status']);
      $stml -> bindParam(':remark', $body['remark']);
      $stml -> bindParam(':dict_id', $body['dict_id']);
      $stml -> bindParam(':update_by', $gUserId);
      $stml -> bindParam(':updated_at', $currentTime);
      $stml -> execute();
    }

    public function deleteDictType($id){
      $sql = 'DELETE FROM `sys_dict_type` WHERE `dict_id`=:dict_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':dict_id', $id);
      $stml -> execute();
    }
  }
