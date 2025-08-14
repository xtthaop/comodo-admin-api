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

      if(!($body['status'] === 0 || $body['status'] === 1)){
        $body['status'] = 1;
      }

      $this -> _dictDataLib -> addDictData($body);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _checkForRequired($body){
      if(empty($body['dict_id'])){
        throw new Exception('字典ID不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!(isset($body['dict_data_label']) && strlen($body['dict_data_label']))){
        throw new Exception('标签不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!(isset($body['dict_data_value']) && strlen($body['dict_data_value']))){
        throw new Exception('键值不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!isset($body['dict_data_sort'])){
        throw new Exception('显示排序不能为空', ErrorCode::INVALID_PARAMS);
      }

      $dictDataId = $body['dict_data_id'] ? $body['dict_data_id'] : 0;

      $existedNameCount = $this -> _dictDataLib -> getExistedCount('dict_data_label', $body['dict_data_label'], $dictDataId, $body['dict_id']);
      if($existedNameCount > 0){
        throw new Exception('标签已存在', ErrorCode::INVALID_PARAMS);
      }

      $existedTypeCount = $this -> _dictDataLib -> getExistedCount('dict_data_value', $body['dict_data_value'], $dictDataId, $body['dict_id']);
      if($existedTypeCount > 0){
        throw new Exception('键值已存在', ErrorCode::INVALID_PARAMS);
      }
    }

    private function _handleGetDictData(){
      $params = $_GET;

      if(empty($params['dict_id'])){
        throw new Exception('字典类型ID不能为空', ErrorCode::INVALID_PARAMS);
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
        throw new Exception('字典数据ID不能为空', ErrorCode::INVALID_PARAMS);
      }

      if(!isset($body['status'])){
        throw new Exception('字典数据状态不能为空', ErrorCode::INVALID_PARAMS);
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
        throw new Exception('字典数据ID不能为空', ErrorCode::INVALID_PARAMS);
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
        throw new Exception('字典类型不能为空', ErrorCode::INVALID_PARAMS);
      }

      $res = $this -> _dictDataLib -> getDictDataByType($params['dict_type']);
      return [
        'code' => 0,
        'message' => 'success',
        'data' => $res,
      ];
    }
  }

