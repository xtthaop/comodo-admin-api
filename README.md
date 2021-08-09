# comodo-admin-api

## front end
[comodo-admin-web](https://github.com/xtthaop/comodo-admin-web.git)

![截图](https://github.com/xtthaop/image-lib/blob/master/image/screenshot.png?raw=true)

### software environment
Apache/2.4.46 (Unix)
PHP/7.3.24
mysql/8.0.22

### create your database
```sql
create database comodo_admin;
use comodo_admin;
source assets/mysql/comodo_admin.sql;
```

### change to your db config
```php
// lib/db.php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=comodo_admin', 'root', 'root');
```

### chang to your apache vhost config
```conf
listen 56890
<VirtualHost *:56890>
  DocumentRoot "/comodo-admin-api"
  <Directory />
    AllowOverride All
    Options All
    allow from all
    Require all granted
  </Directory>
</VirtualHost>
```

### account information
管理员账号
用户名：admin
密码：123456

普通用户账号
用户名：user
密码：123456
