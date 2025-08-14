<?php
  class ErrorCode{
    const INVALID_PARAMS = 4002; // 参数错误
    const UPDATE_FAILED = 4017; // 修改失败
    const DELETE_FAILED = 4016; // 删除失败
    const CAPTCHA_VERIFY_FAILED = 4018; // 拼图验证失败
    const USERNAME_CANNOT_EMPTY = 4019; // 用户名不能为空
    const PASSWOED_CANNOT_EMPTY = 4020; // 密码不能为空
    const USER_VERIFY_FAILED = 4021; // 用户名和密码不匹配
    const OLD_PASSWORD_VERIFY_FAILED = 4022; // 旧密码验证失败
    const USER_HAS_UNENABLED = 4024; // 账户被禁用
  }
