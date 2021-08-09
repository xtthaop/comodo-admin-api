<?php
  class DictType {
    private $_dictTypeLib;

    public function __construct(DictTypeLib $dictTypeLib){
      $this -> _dictTypeLib = $dictTypeLib;
    }

    public function handleDictType(){
      $requestMethod = $_SERVER['REQUEST_METHOD'];
      switch($requestMethod){
        case 'POST':
          return $this -> _handleAddDictType();
        case 'GET':
          return $this -> _handleGetDictType();
        case 'PUT':
          return $this -> _handleUpdateDictType();
        case 'DELETE':
          return $this -> _handleDeleteDictType();
        default:
          throw new Exception('请求方法不被允许', 405);
      }
    }

    private function _handleAddDictType(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      $this -> _checkForRequired($body['dict_name'], $body['dict_type'], '');

      $this -> _dictTypeLib -> addDictType($body);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _handleUpdateDictType(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['dict_id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _checkForRequired($body['dict_name'], $body['dict_type'], $body['dict_id']);

      $this -> _dictTypeLib -> updateDictType($body);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }

    private function _checkForRequired($dictName, $dictType, $dictId){
      if(
        !(isset($dictName) && strlen($dictName)) ||
        !(isset($dictType) && strlen($dictType))
      ){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $existedNameCount = $this -> _dictTypeLib -> getExistedCount('dict_name', $dictName, $dictId);
      if($existedNameCount > 0){
        throw new Exception('字典名称已存在', ErrorCode::DICT_NAME_EXISTED);
      }

      $existedTypeCount = $this -> _dictTypeLib -> getExistedCount('dict_type', $dictType, $dictId);
      if($existedTypeCount > 0){
        throw new Exception('字典类型已存在', ErrorCode::DICT_TYPE_EXISTED);
      }
    }

    private function _handleGetDictType(){
      $params = $_GET;
      $res = $this -> _dictTypeLib -> getDictTypeList($params);
      return [
        'code' => 0,
        'message' => 'success',
        'data' => [
          'dict_type_list' => $res['data'],
          'total' => $res['total'],
        ],
      ];
    }

    private function _handleDeleteDictType(){
      $raw = file_get_contents('php://input');
      $body = json_decode($raw, true);

      if(empty($body['dict_id'])){
        throw new Exception('参数错误', ErrorCode::INVALID_PARAMS);
      }

      $this -> _dictTypeLib -> deleteDictType($body['dict_id']);
      return [
        'code' => 0,
        'message' => 'success',
      ];
    }
  }
