<?php
  class SysLogLib {
    private $_db;

    public function __construct($db){
      $this -> _db = $db;
    }

    public function recordLoginLog($username, $ipaddr, $location, $browser, $os){
      $currentTime = date('Y-m-d H:i:s');

      $sql = 'INSERT INTO `sys_login_log` (`username`, `ipaddr`, `location`, `browser`, `os`, `login_time`)
             VALUES (:username, :ipaddr, :location, :browser, :os, :login_time)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':username', $username);
      $stml -> bindParam(':ipaddr', $ipaddr);
      $stml -> bindParam(':location', $location);
      $stml -> bindParam(':browser', $browser);
      $stml -> bindParam(':os', $os);
      $stml -> bindParam(':login_time', $currentTime);
      $stml -> execute();
    }

    public function getLoginLogList($params){
      $countSql = 'SELECT COUNT(*) from `sys_login_log` WHERE 1=1';
      $dataSql = 'SELECT * from `sys_login_log` WHERE 1=1';
      $arr = array();

      if(isset($params['username']) && strlen($params['username'])){
        $countSql .= ' AND `username` LIKE :username';
        $dataSql .= ' AND `username` LIKE :username';
        $arr[':username'] = '%' . $params['username'] . '%';
      }

      if(isset($params['ipaddr']) && strlen($params['ipaddr'])){
        $countSql .= ' AND `ipaddr` LIKE :ipaddr';
        $dataSql .= ' AND `ipaddr` LIKE :ipaddr';
        $arr[':ipaddr'] = '%' . $params['ipaddr'] . '%';
      }

      $stml = $this -> _db -> prepare($countSql);
      $stml -> execute($arr);
      $total = $stml -> fetch()[0];

      $dataSql .= ' ORDER BY `login_time` DESC';
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

    public function deleteLoginLog($id){
      $sql = 'DELETE FROM `sys_login_log` WHERE `id`=:id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':id', $id);
      $stml -> execute();
    }

    public function recordOperationLog($operator, $ipaddr, $type, $path, $latencyTime, $operationTime){
      $sql = 'INSERT INTO `sys_operation_log` (`operator`, `ipaddr`, `type`, `path`, `latency_time`, `operation_time`)
             VALUES (:operator, :ipaddr, :type, :path, :latency_time, :operation_time)';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':operator', $operator);
      $stml -> bindParam(':ipaddr', $ipaddr);
      $stml -> bindParam(':type', $type);
      $stml -> bindParam(':path', $path);
      $stml -> bindParam(':latency_time', $latencyTime);
      $stml -> bindParam(':operation_time', $operationTime);
      $stml -> execute();
    }

    public function getOperationLogList($params){
      $countSql = 'SELECT COUNT(*) from `sys_operation_log` WHERE 1=1';
      $dataSql = 'SELECT * from `sys_operation_log` WHERE 1=1';
      $arr = array();

      if(!empty($params['date_range'])){
        $countSql .= ' AND `operation_time` BETWEEN :start_time AND :end_time';
        $dataSql .= ' AND `operation_time` BETWEEN :start_time AND :end_time';
        $arr[':start_time'] = $params['date_range'][0];
        $arr[':end_time'] = $params['date_range'][1];
      }

      $stml = $this -> _db -> prepare($countSql);
      $stml -> execute($arr);
      $total = $stml -> fetch()[0];

      $dataSql .= ' ORDER BY `operation_time` DESC';
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

    public function deleteOperationLog($id){
      $sql = 'DELETE FROM `sys_operation_log` WHERE `id`=:id';
      $stml = $this -> _db -> prepare($sql);
      $stml -> bindParam(':id', $id);
      $stml -> execute();
    }
  }