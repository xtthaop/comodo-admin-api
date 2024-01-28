<?php
  class DictData {
    private $_dictDataLib;

    public function __construct(DictDataLib $dictDataLib){
      $this -> _dictDataLib = $dictDataLib;
    }

    public function handleDictData(){
      $requestMethod = $_SERVER['REQUEST_METHOD'];
      $path = $_SERVER['PATH_INFO'];
      $params = explode('/', $path);
      switch($requestMethod){
        case 'POST':
          return $this -> _handleAddDictData();
        case 'GET':
          switch($params[2]){
            case 'get_list':
              return $this -> _handleGetDictData();
            case 'option_select':
              return $this -> _handleGetDictDataByType();
            default:
              throw new Exception('请求的资源不存在', 404);
          }
        case 'PUT':
          return $this -> _handleUpdateDictData();
        case 'DELETE':
          return $this -> _handleDeleteDictData();
        default:
          throw new Exception('请求方法不被允许', 405);
      }
    }

    private function _handleAddDictData(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      $this -> _checkForRequired($body);

      $this -> _dictDataLib -> addDictData($body);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _checkForRequired($body){
      if(
        !(isset($body['dict_data_label']) && strlen($body['dict_data_label'])) || 
        !(isset($body['dict_data_value']) && strlen($body['dict_data_value'])) ||
        !(isset($body['dict_data_sort']) && strlen($body['dict_data_sort'])) ||
        !(isset($body['status']) && strlen($body['status'])) ||
        empty($body['dict_id'])
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $dictDataId = $body['dict_data_id'] ? $body['dict_data_id'] : '';

      $existedNameCount = $this -> _dictDataLib -> getExistedCount('dict_data_label', $body['dict_data_label'], $dictDataId, $body['dict_id']);
      if($existedNameCount > 0){
        throw new Exception('标签名称已存在', ErrorCode::DICT_DATA_LABEL_EXISTED);
      }

      $existedTypeCount = $this -> _dictDataLib -> getExistedCount('dict_data_value', $body['dict_data_value'], $dictDataId, $body['dict_id']);
      if($existedTypeCount > 0){
        throw new Exception('键值已存在', ErrorCode::DICT_DATA_VALUE_EXISTED);
      }
    }

    private function _handleGetDictData(){
      $params = $_GET;

      if(empty($params['dict_id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $res = $this -> _dictDataLib -> getDictDataList($params);
      return [
        'code' => 0,
        'message' => 'success',
        'data' => [
          'total' => $res['total'],
          'dict_data_list' => $res['data'],
        ],
      ];
    }

    private function _handleUpdateDictData(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['dict_data_id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _checkForRequired($body);

      $this -> _dictDataLib -> updateDictData($body);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handleDeleteDictData(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['dict_data_id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _dictDataLib -> deleteDictData($body['dict_data_id']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handleGetDictDataByType(){
      $params = $_GET;

      if(!(isset($params['dict_type']) && strlen($params['dict_type']))){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $res = $this -> _dictDataLib -> getDictDataByType($params['dict_type']);
      return [
        'code' => 0,
        'message' => 'success',
        'data' => $res,
      ];
    }
  }

