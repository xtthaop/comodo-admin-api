<?php
  class SysApiLib {
    private $_db;

    public function __construct($db){
      $this -> _db = $db;
    }

    public function getSysApiList($params){
      $countSql = 'SELECT COUNT(*) from `sys_api` WHERE 1=1';
      $dataSql = 'SELECT * from `sys_api` WHERE 1=1';
      $arr = array();

      if(isset($params['title']) && strlen($params['title'])){
        $countSql .= ' AND `title` LIKE :title';
        $dataSql .= ' AND `title` LIKE :title';
        $arr[':title'] = '%' . $params['title'] . '%';
      }

      if(isset($params['path']) && strlen($params['path'])){
        $countSql .= ' AND `path` LIKE :path';
        $dataSql .= ' AND `path` LIKE :path';
        $arr[':path'] = '%' . $params['path'] . '%';
      }

      if(isset($params['type']) && strlen($params['type'])){
        $countSql .= ' AND `type`=:type';
        $dataSql .= ' AND `type`=:type';
        $arr[':type'] = $params['type'];
      }

      $stml = $this -> _db -> prepare($countSql);
      $stml -> execute($arr);
      $total = $stml -> fetch()[0];

      $dataSql .= ' ORDER BY `created_at` DESC LIMIT :limit OFFSET :offset';
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

    public function addApi($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'INSERT INTO `sys_api` 
             (`title`, `type`, `path`, `create_by`, `created_at`) 
             VALUES (:title, :type, :path, :create_by, :created_at)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':title', $body['title']);
      $stml -> bindParam(':type', $body['type']);
      $stml -> bindParam(':path', $body['path']);
      $stml -> bindParam(':create_by', $gUserId);
      $stml -> bindParam(':created_at', $currentTime);
      $stml -> execute();
    }

    public function updateApi($body){
      global $gUserId;
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'UPDATE `sys_api` SET `title`=:title, `type`=:type, `path`=:path, 
             `update_by`=:update_by, `updated_at`=:updated_at WHERE `id`=:id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':title', $body['title']);
      $stml -> bindParam(':type', $body['type']);
      $stml -> bindParam(':path', $body['path']);
      $stml -> bindParam(':id', $body['id']);
      $stml -> bindParam(':update_by', $gUserId);
      $stml -> bindParam(':updated_at', $currentTime);
      $stml -> execute();
    }

    public function getExistedCount($column, $value, $id){
      $sql = 'SELECT COUNT(*) FROM `sys_api` WHERE ' . $column . '=:' . $column . ' AND `id`!=:id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':' . $column, $value);
      $stml -> bindParam(':id', $id);
      $stml -> execute();
      $result = $stml -> fetch();
      return $result[0];
    }

    public function deleteApi($id){
      $sql = 'DELETE FROM `sys_api` WHERE `id`=:id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':id', $id);
      $stml -> execute();
    }
  }