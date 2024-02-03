<p align="center">
  <img src="https://github.com/xtthaop/image-lib/blob/master/comodo-admin/logo.png?raw=true" width="50px" />
</p>

<p align="center">
  本软件基于 <a href="https://github.com/PanJiaChen/vue-element-admin">vue-element-admin</a>、参考 <a href="https://github.com/go-admin-team/go-admin">go-admin</a> 开发
</p>

## 简介

Comodo Admin 是一款极简的 RBAC（基于角色的访问控制） 后台管理系统，前端基于 Vue 3 开发，后端基于 PHP 8.1 开发。它提供了一种 RBAC 后台管理系统的具体实现思路和运行框架。如果你具备 JS、CSS、HTML、Vue 3 和 PHP 的基础知识，即使你从来没有接触过 RBAC 后台管理系统，你也能快速上手。

前端 [comodo-admin-web](https://github.com/xtthaop/comodo-admin-web) 使用了 Vue 3 的选项式 API，将来可能会推出 Vue 3 组合式 API 加上 TypeScript 改进的版本。相比于其他类似项目，本项目在菜单管理上配置更灵活、使用体验更好。为了提升代码质量和团队协作效率，推荐安装 ESLint 和 Prettier，ESLint 可以使代码风格更加一致并且避免一些错误，Prettier 可以帮你格式化代码让团队无需争论代码格式问题。

因为我本人主要精力还是在前端，后端能力有限，开发过程中是持着学习的心态，所以并没有使用流行的后端开发框架。如果有后端开发者对 [comodo-admin-api](https://github.com/xtthaop/comodo-admin-api) 有兴趣并且期望共同建设的话，请参考 comodo-admin-api 源码实现一个更稳定更适用于生产的版本，我会把你的项目地址列到这里。

**预览地址**：[Comodo Admin](https://zxctb.top:8081)

## 功能

### 登录页面
登录页面提供用户名密码及**滑块验证码登录**。

### 系统布局
<img src="https://github.com/xtthaop/image-lib/blob/master/comodo-admin/layout.png?raw=true" width="60%" />

#### 系统标识：
显示系统 Logo 及系统名称，系统名称可通过**配置文件**修改，修改后登录页面及浏览器显示标题同步生效。

#### 菜单栏：
显示根据当前**用户权限**生成的**多级菜单**。

#### 顶部导航栏
显示页面路径并支持点击**快速跳转回之前的任意页面**；

#### 菜单标签栏
显示所有打开过的菜单标签，**可拖动标签移动位置**，右键点击标签可执行关闭所有标签等**快捷操作**，对于存在正则匹配参数或使用查询字符串的路由，不同参数的路由都是**独立的标签页**可以互相切换。

### 系统管理
#### 接口管理
支持录入所有系统接口，并可在菜单管理中将接口与菜单做绑定，从而实现**精确到接口的权限控制**。

#### 菜单管理
菜单类型的新增分为**页面夹、页面、按钮**三种，并**与 Vue Router 的路由模式**进行组合，支持动态路由、动态参数、缓存。可指定某些路由**不显示页面布局**。通过为按钮设置权限标识，配合 Vue 的自定义指令实现**精确到按钮的权限控制**。可**为菜单绑定接口**。菜单图标**支持自定义 SVG 及 Element Plus 内置图标**。菜单管理自身**禁止删除**。

#### 角色管理
可**为角色绑定菜单**。角色标识为 admin 的角色默认拥有所有菜单且不可修改，同时**禁止删除**。

#### 用户管理
可**为用户绑定角色**。登录名为 admin 的用户默认拥有角色标识为 admin 的角色且不可修改，同时**禁止删除**。

#### 字典管理
每个字典对应唯一的字典类型，根据字典类型查找字典数据，后期**不用更改代码**即可灵活修改字典数据。

#### 系统日志
可记录登录日志、操作日志，登录日志可具体到**登录者 IP 及设备信息**，操作日志可具体到**操作人 IP 及操作耗时**。

## 快速开始
### [comodo-admin-web](https://github.com/xtthaop/comodo-admin-web) 
#### 初始化
```
pnpm install
```
#### 开发环境
```
pnpm run dev
```
#### 生产环境
```
pnpm run build
```

### [comodo-admin-api](https://github.com/xtthaop/comodo-admin-api)
**[接口文档](https://apifox.com/apidoc/shared-b140bb25-d2d9-469b-a53b-161fac393622/api-140743481)**
#### server ubuntu 22.04.1 LTS
#### 安装 apache(2.4.52)
```
apt install apache2
```
##### 修改 apache 配置文件
```
# comodo-admin-open-api
<VirtualHost *:8892>
    ServerAdmin 961116034@qq.com
    DocumentRoot "/var/www/comodo-admin-open/comodo-admin-api"
    <Directory "/var/www/comodo-admin-open/comodo-admin-api">
      AllowOverride All
    </Directory>
    ErrorLog "${APACHE_LOG_DIR}/comodo-admin-open/comodo-admin-api-error.log"
    CustomLog "${APACHE_LOG_DIR}/comodo-admin-open/comodo-admin-api-access.log" combined
</VirtualHost>

# comodo-admin-open-web
<VirtualHost *:3095>
    ServerAdmin 961116034@qq.com
    DocumentRoot "/var/www/comodo-admin-open/comodo-admin-web"
    <Directory "/var/www/comodo-admin-open/comodo-admin-web">
     <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteBase /
        RewriteRule ^index\.html$ - [L]
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule . /index.html [L]
      </IfModule>
    </Directory>
    ErrorLog "${APACHE_LOG_DIR}/comodo-admin-open/comodo-admin-web-error.log"
    CustomLog "${APACHE_LOG_DIR}/comodo-admin-open/comodo-admin-web-access.log" combined
</VirtualHost>
```
将 comodo-admin-web 打包后的代码和 comodo-admin-api 的代码拷贝到正确的位置并创建日志目录

#### 安装 mysql(8.0.33)
```
apt install mysql-server 
```
##### 初始化数据库
```
source comodo-admin-api/assets/mysql/comodo_admin.sql;
```
#### 安装 redis(6.0.16)
```
apt install redis-server
```

#### 安装 php(8.1.2)
```
apt install php
```
##### php 安装 PDO 扩展
```
apt install php-mysql
```
##### php 生成验证码图片安装 GD 模块
```
apt install php8.1-gd
```
##### php 安装 redis 扩展
```
apt install php-redis
```
##### 在 comodo-admin-api/lib/db.php 中修改连接数据库及密码

##### 添加定时清除 redis 黑名单 token 操作
```
crontab -e
```
在文件中写入
```
0 3 * * * bash comodo-admin-api/assets/bash/comodo-admin-clear-expired-token.sh/backup.sh > /dev/null 2>&1 &
```

##### 初始化账户信息
用户名：admin   
密码：123456

用户名：user1    
密码：123456

## 关于作者
Comodo Admin 的作者是一名前端小学生，水平不高，文档或者代码中如有不当之处还请指正。

## 成为赞助者
<img src="https://github.com/xtthaop/image-lib/blob/master/comodo-admin/sponsor.png?raw=true" width="300px" />

维护这个项目需要一定的服务器费用用作项目预览，还需要消耗我本人一定的精力，所以如果这个项目帮助到你的话，请多多予以支持！感谢！

## 许可证
[MIT](https://github.com/xtthaop/comodo-admin-api/blob/main/LICENSE.md)
