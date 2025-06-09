### 判断接收的参数不能为空
1. 参数为**非空字符串**用

```php
isset($body['param']) && strlen($body['param'])
```

2. 

```php
isset()
```

- 未初始化的变量
- NULL

会返回 `false`

参数有值如 `0`、`""`、`false` 还是会返回 `true`

3. 

```php
empty()
```

- ""（空字符串）
- 0（整数 0）
- "0"（字符串 0）
- 0.0（浮点数 0）
- NULL
- FALSE
- array()（空数组）
- 未初始化的变量

都会返回 `true`
