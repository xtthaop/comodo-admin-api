<?php
  class SysApi {
    private $_sysApiLib;

    public function __construct(SysApiLib $sysApiLib){
      $this -> _sysApiLib = $sysApiLib;
    }

    public function handleSysApi(){
      $requestMethod = $_SERVER['REQUEST_METHOD'];
      switch($requestMethod){
        case 'POST':
          return $this -> _handleAddSysApi();
        case 'GET':
          return $this -> _handleGetSysApi();
        case 'PUT':
          return $this -> _handleUpdateSysApi();
        case 'DELETE':
          return $this -> _handleDeleteSysApi();
        default:
          throw new Exception('请求方法不被允许', 405);
      }
    }

    private function _handleAddSysApi(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      $this -> _checkForRequired($body);

      $this -> _sysApiLib -> addApi($body);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _checkForRequired($body){
      if(!(isset($body['title']) && strlen($body['title']))){
        throw new Exception('接口名称不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!(isset($body['path']) && strlen($body['path']))){
        throw new Exception('接口路径不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!(isset($body['type']) && strlen($body['type']))){
        throw new Exception('请求类型不能为空', ErrorCode::INVALID_PARAMS);
      }

      $apiId = empty($body['id']) ? 0 : $body['id'];
      $existedTitleCount = $this -> _sysApiLib -> getExistedCount('title', $body['title'], $apiId);
      if($existedTitleCount > 0){
        throw new Exception('接口名称已被使用', ErrorCode::API_TITLE_EXISTED);
      }
    }

    private function _handleGetSysApi(){
      $params = $_GET;
      $res = $this -> _sysApiLib -> getSysApiList($params);
      return [
        'code' => 0,
        'message' => 'success',
        'data' => [
          'sys_api_list' => $res['data'],
          'total' => $res['total'],
        ],
      ];
    }

    private function _handleUpdateSysApi(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _checkForRequired($body);

      $this -> _sysApiLib -> updateApi($body);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handleDeleteSysApi(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _sysApiLib -> deleteApi($body['id']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }
  }