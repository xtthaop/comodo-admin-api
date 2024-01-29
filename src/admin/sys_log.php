<?php
  class SysLog {
    private $_sysLogLib;
    private $_sysApiLib;
    private $_client;

    public function __construct(SysLogLib $sysLogLib, SysApiLib $sysApiLib, Client $client){
      $this -> _sysLogLib = $sysLogLib;
      $this -> _sysApiLib = $sysApiLib;
      $this -> _client = $client;
    }

    public function handleSysLog(){
      $requestMethod = $_SERVER['REQUEST_METHOD'];
      $path = $_SERVER['PATH_INFO'];
      $params = explode('/', $path);
      switch($requestMethod){
        case 'GET':
          switch($params[2]){
            case 'get_login_log':
              return $this -> _handleGetLoginLog();
            case 'get_operation_log':
              return $this -> _handleGetOperationLog();
            default:
              throw new Exception('请求的资源不存在', 404);
          }
        case 'DELETE':
          switch($params[2]){
            case 'delete_login_log':
              return $this -> _handleDeleteLoginLog();
            case 'delete_operation_log':
              return $this -> _handleDeleteOperationLog();
            default:
              throw new Exception('请求的资源不存在', 404);
          }
        default:
          throw new Exception('请求方法不被允许', 405);
      }
    }

    public function recordOperationLog($operator, $operationTime, $latencyTime){
      $ipaddr = $this -> _client -> getIpAddress();
      $type = $_SERVER['REQUEST_METHOD'];
      $path = $_SERVER['PATH_INFO'];
      $operation = $this -> _sysApiLib -> getApiTitle($path, $type);
      $this -> _sysLogLib -> recordOperationLog($operator, $operation, $ipaddr, $type, $path, $latencyTime, $operationTime);
    }

    private function _handleGetLoginLog(){
      $params = $_GET;
      $res = $this -> _sysLogLib -> getLoginLogList($params);
      return [
        'code' => 0,
        'message' => 'success',
        'data' => [
          'sys_login_log_list' => $res['data'],
          'total' => $res['total'],
        ],
      ];
    }

    private function _handleDeleteLoginLog(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['ids'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }
      
      foreach($body['ids'] as $value){
        $this -> _sysLogLib -> deleteLoginLog($value);
      }

      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handleGetOperationLog(){
      $params = $_GET;
      $res = $this -> _sysLogLib -> getOperationLogList($params);
      return [
        'code' => 0,
        'message' => 'success',
        'data' => [
          'sys_operation_log_list' => $res['data'],
          'total' => $res['total'],
        ],
      ];
    }

    private function _handleDeleteOperationLog(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['ids'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }
      
      foreach($body['ids'] as $value){
        $this -> _sysLogLib -> deleteOperationLog($value);
      }

      return [
        'code' => 0,
        'message' => 'success',
      ];
    }
  }
