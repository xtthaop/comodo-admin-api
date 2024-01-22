<?php
  class ErrorCode{
    const INVALID_PARAMS = 4002; // 参数错误
    const DICT_NAME_EXISTED = 4003; // 字典名称已存在
    const DICT_TYPE_EXISTED = 4004; // 字典类型已存在
    const API_TITLE_EXISTED = 4005; // 接口名称已存在
    const ROUTE_NAME_EXISTED = 4006; // 路由名称已存在
    const ROUTE_PATH_EXISTED = 4007; // 路由地址已存在
    const PERMISSION_EXISTED = 4008; // 权限标识已存在
    const MENU_CANT_DELETE = 4009; // 菜单不允许被删除
    const MENU_CANT_UPDATE = 4010; // 菜单不允许被编辑
    const ROLE_NAME_EXISTED = 4011; // 角色名称已存在
    const ROLE_KEY_EXISTED = 4012; // 角色标识已存在
    const ROLE_CANT_UPDATE = 4013; // 角色不允许被修改
    const ROLE_CANT_DELETE = 4014; // 角色不允许被删除
    const USER_NAME_EXISTED = 4015; // 用户名称已存在
    const USER_CANT_DELETE = 4016; // 用户不能被删除
    const USER_CANT_UPDATE = 4017; // 用户不可以被修改
    const CAPTCHA_VERIFY_FAILED = 4018; // 拼图验证失败
    const USERNAME_CANNOT_EMPTY = 4019; // 用户名不能为空
    const PASSWOED_CANNOT_EMPTY = 4020; // 密码不能为空
    const USER_VERIFY_FAILED = 4021; // 用户名和密码不匹配
    const OLD_PASSWORD_VERIFY_FAILED = 4022; // 旧密码验证失败
    const USER_ROLE_UNACTIVED = 4023; // 角色被禁用
  }
