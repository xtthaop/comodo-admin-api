<?php
  class ErrorCode{
    const INVALID_PARAMS = 4002; // 参数错误
    const UPDATE_FAILED = 4017; // 修改失败
    const DELETE_FAILED = 4016; // 删除失败
    const DICT_NAME_EXISTED = 4003; // 字典名称已存在
    const DICT_TYPE_EXISTED = 4004; // 字典类型已存在
    const API_TITLE_EXISTED = 4005; // 接口名称已存在
    const MENU_CANT_DELETE = 4009; // 菜单不允许被删除
    const MENU_CANT_UPDATE = 4010; // 菜单不允许被编辑
    const ROLE_CANT_DELETE = 4014; // 角色不允许被删除
    const CAPTCHA_VERIFY_FAILED = 4018; // 拼图验证失败
    const USERNAME_CANNOT_EMPTY = 4019; // 用户名不能为空
    const PASSWOED_CANNOT_EMPTY = 4020; // 密码不能为空
    const USER_VERIFY_FAILED = 4021; // 用户名和密码不匹配
    const OLD_PASSWORD_VERIFY_FAILED = 4022; // 旧密码验证失败
    const USER_HAS_UNENABLED = 4024; // 账户被禁用
    const DICT_DATA_LABEL_EXISTED = 4025; // 字典数据标签已存在
    const DICT_DATA_VALUE_EXISTED = 4026; // 字典数据值已存在
  }
