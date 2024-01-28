<?php
  class DictDataLib {
    private $_db;

    public function __construct($db){
      $this -> _db = $db;
    }

    public function getDictDataList($params){
      $countSql = 'SELECT COUNT(*) from `sys_dict_data` WHERE `dict_id`=:dict_id';
      $dataSql = 'SELECT * from `sys_dict_data` WHERE `dict_id`=:dict_id';

      $arr = array();
      $arr[':dict_id']=$params['dict_id'];

      if(isset($params['dict_data_label']) && strlen($params['dict_data_label'])){
        $countSql .= ' AND `dict_data_label` LIKE :dict_data_label';
        $dataSql .= ' AND `dict_data_label` LIKE :dict_data_label';
        $arr[':dict_data_label'] = '%' . $params['dict_data_label'] . '%';
      }

      if(isset($params['status']) && strlen($params['status'])){
        $countSql .= ' AND `status`=:status';
        $dataSql .= ' AND `status`=:status';
        $arr[':status'] = $params['status'];
      }

      $stml = $this -> _db -> prepare($countSql);
      $stml -> execute($arr);
      $total = $stml -> fetch()[0];

      $dataSql .= ' ORDER BY `dict_data_sort` LIMIT :limit OFFSET :offset';
      $arr[':limit'] = $pageSize = empty($params['page_size']) ? 10 : $params['page_size'];
      $arr[':offset'] = empty($params['page']) ? 0 : ((int)$params['page'] - 1) * (int)$pageSize;

      $stml = $this -> _db -> prepare($dataSql);
      $stml -> execute($arr);
      $data = $stml -> fetchAll(PDO::FETCH_ASSOC);

      return [
        'data' => $data,
        'total' => $total,
      ];
    }

    public function getExistedCount($column, $value, $id, $dictId){
      $sql = 'SELECT COUNT(*) FROM `sys_dict_data` WHERE ' . $column . '=:' . $column . ' AND `dict_data_id`!=:dict_data_id 
              AND `dict_id`=:dict_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':' . $column, $value);
      $stml -> bindParam(':dict_data_id', $id);
      $stml -> bindParam(':dict_id', $dictId);
      $stml -> execute();
      $result = $stml -> fetch();
      return $result[0];
    }

    public function addDictData($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'INSERT INTO `sys_dict_data` (`dict_data_label`, `dict_data_value`, `dict_data_sort`, `dict_id`, 
              `created_at`, `create_by`, `status`, `remark`) VALUES (:dict_data_label, :dict_data_value, 
              :dict_data_sort, :dict_id, :created_at, :create_by, :status, :remark)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':dict_data_label', $body['dict_data_label']);
      $stml -> bindParam(':dict_data_value', $body['dict_data_value']);
      $stml -> bindParam(':dict_data_sort', $body['dict_data_sort']);
      $stml -> bindParam(':dict_id', $body['dict_id']);
      $stml -> bindParam(':status', $body['status']);
      $stml -> bindParam(':remark', $body['remark']);
      $stml -> bindParam(':create_by', $gUserId);
      $stml -> bindParam(':created_at', $currentTime);
      $stml -> execute();
    }

    public function updateDictData($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'UPDATE `sys_dict_data` SET `dict_data_label`=:dict_data_label, `dict_data_value`=:dict_data_value, 
             `dict_data_sort`=:dict_data_sort, `updated_at`=:updated_at, `update_by`=:update_by, 
             `status`=:status, `remark`=:remark WHERE `dict_data_id`=:dict_data_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':dict_data_label', $body['dict_data_label']);
      $stml -> bindParam(':dict_data_value', $body['dict_data_value']);
      $stml -> bindParam(':dict_data_sort', $body['dict_data_sort']);
      $stml -> bindParam(':dict_data_id', $body['dict_data_id']);
      $stml -> bindParam(':status', $body['status']);
      $stml -> bindParam(':remark', $body['remark']);
      $stml -> bindParam(':update_by', $gUserId);
      $stml -> bindParam(':updated_at', $currentTime);
      $stml -> execute();
    }

    public function deleteDictData($id){
      $sql = 'DELETE FROM `sys_dict_data` WHERE `dict_data_id`=:dict_data_id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':dict_data_id', $id);
      $stml -> execute();
    }

    public function getDictDataByType($type){
      $sql = 'SELECT `dict_data_label` AS `dict_label`, `dict_data_value` AS `dict_value` FROM `sys_dict_data` 
      WHERE `dict_id` IN (SELECT `dict_id` FROM `sys_dict_type` WHERE `dict_type`=:dict_type AND `status`=1)
      AND `status`=1 ORDER BY `dict_data_sort`';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':dict_type', $type);
      $stml -> execute();
      $result = $stml -> fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }
  }
