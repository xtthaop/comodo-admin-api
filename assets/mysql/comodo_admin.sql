-- MySQL dump 10.13  Distrib 8.0.22, for osx10.16 (x86_64)
--
-- Host: localhost    Database: comodo_admin
-- ------------------------------------------------------
-- Server version	8.0.22

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `sys_api`
--

DROP TABLE IF EXISTS `sys_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_api` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `path` varchar(128) DEFAULT NULL,
  `type` varchar(16) DEFAULT NULL COMMENT '请求类型',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  `create_by` bigint DEFAULT NULL COMMENT '创建者',
  `update_by` bigint DEFAULT NULL COMMENT '更新者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_api`
--

LOCK TABLES `sys_api` WRITE;
/*!40000 ALTER TABLE `sys_api` DISABLE KEYS */;
INSERT INTO `sys_api` VALUES (1,'获取菜单列表','/sys_menu/get_menu_list','GET','2021-08-09 13:21:17',NULL,1,NULL),(2,'获取菜单列表树','/sys_menu/get_menu_tree','GET','2021-08-09 13:21:51',NULL,1,NULL),(3,'添加菜单','/sys_menu','POST','2021-08-09 13:22:08',NULL,1,NULL),(4,'更新菜单','/sys_menu','PUT','2021-08-09 13:22:30',NULL,1,NULL),(5,'删除菜单','/sys_menu','DELETE','2021-08-09 13:22:48',NULL,1,NULL),(6,'获取接口列表','/sys_api','GET','2021-08-09 13:26:01',NULL,1,NULL),(7,'添加接口','/sys_api','POST','2021-08-09 13:26:16',NULL,1,NULL),(8,'更新接口','/sys_api','PUT','2021-08-09 13:26:42',NULL,1,NULL),(9,'删除接口','/sys_api','DELETE','2021-08-09 13:26:53',NULL,1,NULL),(10,'查询角色列表','/sys_role','GET','2021-08-09 13:27:21',NULL,1,NULL),(11,'添加角色','/sys_role','POST','2021-08-09 13:28:18',NULL,1,NULL),(12,'更新角色信息','/sys_role/update_role','PUT','2021-08-09 13:28:49',NULL,1,NULL),(13,'修改角色状态','/sys_role/change_role_status','PUT','2021-08-09 13:30:19',NULL,1,NULL),(14,'删除角色','/sys_role','DELETE','2021-08-09 13:30:48',NULL,1,NULL),(15,'获取用户列表','/sys_user','GET','2021-08-09 13:31:12',NULL,1,NULL),(16,'添加新用户','/sys_user','POST','2021-08-09 13:31:26',NULL,1,NULL),(17,'删除用户','/sys_user','DELETE','2021-08-09 13:31:40',NULL,1,NULL),(18,'修改用户信息','/sys_user/update_user','PUT','2021-08-09 13:32:01',NULL,1,NULL),(19,'修改用户状态','/sys_user/change_user_status','PUT','2021-08-09 13:32:19',NULL,1,NULL),(20,'重置用户密码','/sys_user/reset_password','PUT','2021-08-09 13:32:41',NULL,1,NULL),(21,'获取字典类型列表','/dict_type','GET','2021-08-09 13:33:16',NULL,1,NULL),(22,'添加字典类型','/dict_type','POST','2021-08-09 13:33:28',NULL,1,NULL),(23,'修改字典类型','/dict_type','PUT','2021-08-09 13:33:44',NULL,1,NULL),(24,'删除字典类型','/dict_type','DELETE','2021-08-09 13:33:56',NULL,1,NULL),(25,'获取字典数据列表','/dict_data/get_list','GET','2021-08-09 13:34:16',NULL,1,NULL),(26,'添加字典数据','/dict_data','POST','2021-08-09 13:35:11',NULL,1,NULL),(27,'修改字典数据','/dict_data','PUT','2021-08-09 13:35:30',NULL,1,NULL),(28,'删除字典数据','/dict_data','DELETE','2021-08-09 13:35:42',NULL,1,NULL),(29,'查询登录日志列表','/sys_log/get_login_log','GET','2021-08-09 13:36:09',NULL,1,NULL),(30,'删除登录日志','/sys_log/delete_login_log','DELETE','2021-08-09 13:36:38',NULL,1,NULL),(31,'查询操作日志列表','/sys_log/get_operation_log','GET','2021-08-09 13:36:57',NULL,1,NULL),(32,'删除操作日志','/sys_log/delete_operation_log','DELETE','2021-08-09 13:37:15',NULL,1,NULL);
/*!40000 ALTER TABLE `sys_api` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_dict_data`
--

DROP TABLE IF EXISTS `sys_dict_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_dict_data` (
  `dict_data_id` bigint NOT NULL AUTO_INCREMENT,
  `dict_data_sort` bigint DEFAULT NULL,
  `dict_data_label` varchar(128) DEFAULT NULL,
  `dict_data_value` varchar(255) DEFAULT NULL,
  `dict_id` bigint DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `create_by` bigint DEFAULT NULL COMMENT '创建者',
  `update_by` bigint DEFAULT NULL COMMENT '更新者',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`dict_data_id`),
  KEY `dict_id` (`dict_id`),
  CONSTRAINT `sys_dict_data_ibfk_1` FOREIGN KEY (`dict_id`) REFERENCES `sys_dict_type` (`dict_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_dict_data`
--

LOCK TABLES `sys_dict_data` WRITE;
/*!40000 ALTER TABLE `sys_dict_data` DISABLE KEYS */;
INSERT INTO `sys_dict_data` VALUES (1,0,'正常','1',1,1,NULL,1,NULL,'2021-08-05 11:44:32',NULL),(2,1,'停用','0',1,1,NULL,1,NULL,'2021-08-05 11:44:43',NULL),(3,0,'男','male',2,1,NULL,1,NULL,'2021-08-05 11:45:41',NULL),(4,1,'女','female',2,1,NULL,1,NULL,'2021-08-05 11:45:50',NULL),(5,0,'显示','1',3,1,NULL,1,NULL,'2021-08-05 11:46:30',NULL),(6,1,'隐藏','0',3,1,NULL,1,NULL,'2021-08-05 11:46:39',NULL);
/*!40000 ALTER TABLE `sys_dict_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_dict_type`
--

DROP TABLE IF EXISTS `sys_dict_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_dict_type` (
  `dict_id` bigint NOT NULL AUTO_INCREMENT,
  `dict_name` varchar(128) DEFAULT NULL,
  `dict_type` varchar(128) DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `create_by` bigint DEFAULT NULL COMMENT '创建者',
  `update_by` bigint DEFAULT NULL COMMENT '更新者',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`dict_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_dict_type`
--

LOCK TABLES `sys_dict_type` WRITE;
/*!40000 ALTER TABLE `sys_dict_type` DISABLE KEYS */;
INSERT INTO `sys_dict_type` VALUES (1,'系统开关','sys_normal_disable',1,NULL,1,NULL,'2021-08-05 11:39:05',NULL),(2,'用户性别','sys_user_sex',1,NULL,1,NULL,'2021-08-05 11:45:23',NULL),(3,'菜单状态','sys_show_hide',1,NULL,1,NULL,'2021-08-05 11:46:19',NULL);
/*!40000 ALTER TABLE `sys_dict_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_login_log`
--

DROP TABLE IF EXISTS `sys_login_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_login_log` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL COMMENT '用户名',
  `ipaddr` varchar(255) DEFAULT NULL COMMENT 'ip地址',
  `location` varchar(255) DEFAULT NULL COMMENT '归属地',
  `browser` varchar(255) DEFAULT NULL COMMENT '浏览器',
  `os` varchar(255) DEFAULT NULL COMMENT '系统',
  `login_time` datetime DEFAULT NULL COMMENT '登录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_login_log`
--

LOCK TABLES `sys_login_log` WRITE;
/*!40000 ALTER TABLE `sys_login_log` DISABLE KEYS */;
INSERT INTO `sys_login_log` VALUES (1,'admin','1.202.114.142','北京市北京市 电信','Chrome(92.0.4515.107)','MAC','2021-08-05 11:32:24'),(2,'admin','1.202.114.142','北京市北京市 电信','Chrome(92.0.4515.107)','MAC','2021-08-05 16:03:11'),(3,'admin','1.202.114.142','北京市北京市 电信','Chrome(92.0.4515.107)','MAC','2021-08-05 16:48:12'),(4,'user','1.202.114.142','北京市北京市 电信','Chrome(92.0.4515.107)','MAC','2021-08-09 13:46:37'),(5,'admin','1.202.114.142','北京市北京市 电信','Chrome(92.0.4515.107)','MAC','2021-08-09 13:47:32'),(6,'user','1.202.114.142','北京市北京市 电信','Firefox(90.0)','MAC','2021-08-09 13:48:38'),(7,'admin','127.0.0.1','','Chrome(92.0.4515.107)','MAC','2021-08-09 14:32:25'),(8,'admin','127.0.0.1','','Chrome(92.0.4515.107)','MAC','2021-08-09 14:33:32');
/*!40000 ALTER TABLE `sys_login_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_menu`
--

DROP TABLE IF EXISTS `sys_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_menu` (
  `menu_id` bigint NOT NULL AUTO_INCREMENT,
  `route_name` varchar(128) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `icon` varchar(128) DEFAULT NULL,
  `path` varchar(128) DEFAULT NULL,
  `menu_type` varchar(1) DEFAULT NULL,
  `permission` varchar(255) DEFAULT NULL,
  `parent_id` bigint DEFAULT NULL,
  `component` varchar(255) DEFAULT NULL,
  `sort` bigint DEFAULT NULL,
  `visible` tinyint DEFAULT NULL,
  `is_frame` tinyint DEFAULT '0',
  `layout` tinyint DEFAULT '1',
  `cache` tinyint DEFAULT '0',
  `create_by` bigint DEFAULT NULL COMMENT '创建者',
  `update_by` bigint DEFAULT NULL COMMENT '更新者',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_menu`
--

LOCK TABLES `sys_menu` WRITE;
/*!40000 ALTER TABLE `sys_menu` DISABLE KEYS */;
INSERT INTO `sys_menu` VALUES (1,'SysMenu','菜单管理',NULL,'/admin/sys-menu','C','admin:sysmenu',2,'/admin/sys-menu',2,1,0,1,0,NULL,1,'2021-08-05 11:05:32','2021-08-09 14:12:08'),(2,NULL,'系统管理','setting',NULL,'M',NULL,0,NULL,199,1,0,1,0,1,NULL,'2021-08-05 11:36:08',NULL),(3,'SysDict','字典管理',NULL,'/admin/sys-dict','C','admin:sysdict',2,'/admin/sys-dict',4,1,0,1,0,1,1,'2021-08-05 11:37:34','2021-08-09 14:16:31'),(4,'SysDictData','字典数据管理',NULL,'/admin/sys-dict/data/:dictId','C','admin:sysdictdata',2,'/admin/sys-dict/data',4,0,0,1,0,1,1,'2021-08-05 11:40:54','2021-08-09 14:19:19'),(5,'SysUser','用户管理',NULL,'/admin/sys-user','C','admin:sysuser',2,'/admin/sys-user',0,1,0,1,0,1,1,'2021-08-05 11:48:47','2021-08-09 13:47:51'),(6,'SysRole','角色管理',NULL,'/admin/sys-role','C','admin:sysrole',2,'/admin/sys-role',1,1,0,1,0,1,1,'2021-08-05 11:49:40','2021-08-09 14:05:38'),(7,'SysApi','接口管理',NULL,'/admin/sys-api','C','admin:sysapi',2,'/admin/sys-api',3,1,0,1,0,1,1,'2021-08-05 11:51:29','2021-08-09 14:12:53'),(8,NULL,'系统日志',NULL,NULL,'M',NULL,2,NULL,5,1,0,1,0,1,1,'2021-08-05 11:52:24','2021-08-05 11:52:31'),(9,'SysLoginLog','登录日志',NULL,'/admin/sys-login-log','C','admin:sysloginlog',8,'/admin/sys-login-log',0,1,0,1,0,1,1,'2021-08-05 11:53:18','2021-08-09 14:21:49'),(10,'SysOperationLog','操作日志',NULL,'/admin/sys-operation-log','C','admin:sysoperationlog',8,'/admin/sys-operation-log',1,1,0,1,0,1,1,'2021-08-05 11:54:06','2021-08-09 14:22:45'),(11,NULL,'新增用户',NULL,NULL,'F','admin:sysuser:add',5,NULL,1,1,0,1,0,1,NULL,'2021-08-09 13:40:48',NULL),(12,NULL,'修改用户',NULL,NULL,'F','admin:sysuser:edit',5,NULL,2,1,0,1,0,1,1,'2021-08-09 13:41:28','2021-08-09 13:42:24'),(13,NULL,'删除用户',NULL,NULL,'F','admin:sysuser:remove',5,NULL,3,1,0,1,0,1,1,'2021-08-09 13:42:02','2021-08-09 13:42:08'),(14,NULL,'重置密码',NULL,NULL,'F','admin:sysuser:resetpassword',5,NULL,4,1,0,1,0,1,1,'2021-08-09 13:42:40','2021-08-09 13:44:05'),(15,NULL,'修改状态',NULL,NULL,'F','admin:sysuser:status',5,NULL,5,1,0,1,0,1,1,'2021-08-09 13:43:46','2021-08-09 13:43:58'),(16,NULL,'新增角色',NULL,NULL,'F','admin:sysrole:add',6,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:01:28',NULL),(17,NULL,'修改角色',NULL,NULL,'F','admin:sysrole:update',6,NULL,0,1,0,1,0,1,1,'2021-08-09 14:02:28','2021-08-09 14:03:15'),(18,NULL,'删除角色',NULL,NULL,'F','admin:sysrole:remove',6,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:03:09',NULL),(19,NULL,'修改状态',NULL,NULL,'F','admin:sysrole:status',6,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:03:58',NULL),(20,NULL,'新增菜单',NULL,NULL,'F','admin:sysmenu:add',1,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:09:36',NULL),(21,NULL,'修改菜单',NULL,NULL,'F','admin:sysmenu:edit',1,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:10:18',NULL),(22,NULL,'删除菜单',NULL,NULL,'F','admin:sysmenu:remove',1,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:10:42',NULL),(23,NULL,'新增接口',NULL,NULL,'F','admin:sysapi:add',7,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:13:30',NULL),(24,NULL,'修改接口',NULL,NULL,'F','admin:sysapi:edit',7,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:13:56',NULL),(25,NULL,'删除接口',NULL,NULL,'F','admin:sysapi:remove',7,NULL,0,1,0,1,0,1,1,'2021-08-09 14:14:27','2021-08-09 14:17:45'),(26,NULL,'添加字典类型',NULL,NULL,'F','admin:sysdicttype:add',3,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:17:05',NULL),(27,NULL,'修改字典类型',NULL,NULL,'F','admin:sysdicttype:edit',3,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:17:32',NULL),(28,NULL,'删除字典类型',NULL,NULL,'F','admin:sysdicttype:remove',3,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:18:30',NULL),(29,NULL,'添加字典数据',NULL,NULL,'F','admin:sysdictdata:add',4,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:19:51',NULL),(30,NULL,'修改字典数据',NULL,NULL,'F','admin:sysdictdata:edit',4,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:20:15',NULL),(31,NULL,'删除字典数据',NULL,NULL,'F','admin:sysdictdata:remove',4,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:20:37',NULL),(32,NULL,'删除登录日志',NULL,NULL,'F','admin:sysloginlog:remove',9,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:22:13',NULL),(33,NULL,'删除操作日志',NULL,NULL,'F','admin:sysoperationlog:remove',10,NULL,0,1,0,1,0,1,NULL,'2021-08-09 14:22:38',NULL);
/*!40000 ALTER TABLE `sys_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_menu_api_rule`
--

DROP TABLE IF EXISTS `sys_menu_api_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_menu_api_rule` (
  `sys_menu_id` bigint NOT NULL,
  `sys_api_id` bigint NOT NULL,
  PRIMARY KEY (`sys_menu_id`,`sys_api_id`),
  KEY `sys_api_id` (`sys_api_id`),
  CONSTRAINT `sys_menu_api_rule_ibfk_1` FOREIGN KEY (`sys_api_id`) REFERENCES `sys_api` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sys_menu_api_rule_ibfk_2` FOREIGN KEY (`sys_menu_id`) REFERENCES `sys_menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_menu_api_rule`
--

LOCK TABLES `sys_menu_api_rule` WRITE;
/*!40000 ALTER TABLE `sys_menu_api_rule` DISABLE KEYS */;
INSERT INTO `sys_menu_api_rule` VALUES (1,1),(1,2),(6,2),(20,3),(21,4),(22,5),(1,6),(7,6),(23,7),(24,8),(25,9),(5,10),(6,10),(16,11),(17,12),(19,13),(18,14),(5,15),(11,16),(13,17),(12,18),(15,19),(14,20),(3,21),(26,22),(27,23),(28,24),(4,25),(29,26),(30,27),(31,28),(9,29),(32,30),(10,31),(33,32);
/*!40000 ALTER TABLE `sys_menu_api_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_operation_log`
--

DROP TABLE IF EXISTS `sys_operation_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_operation_log` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `type` varchar(128) DEFAULT NULL COMMENT '请求类型',
  `operator` varchar(128) DEFAULT NULL COMMENT '操作人员',
  `path` varchar(255) DEFAULT NULL COMMENT '访问地址',
  `ipaddr` varchar(128) DEFAULT NULL COMMENT '客户端ip',
  `latency_time` varchar(128) DEFAULT NULL COMMENT '耗时',
  `operation_time` datetime DEFAULT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=524 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_operation_log`
--

LOCK TABLES `sys_operation_log` WRITE;
/*!40000 ALTER TABLE `sys_operation_log` DISABLE KEYS */;
INSERT INTO `sys_operation_log` VALUES (1,'GET',NULL,'/public/captcha/dst.png','1.202.114.142','0.06ms','2021-08-05 11:25:45'),(2,'GET',NULL,'/public/captcha/jigsaw.png','1.202.114.142','0.08ms','2021-08-05 11:25:45'),(3,'GET',NULL,'/public/captcha/dst.png','1.202.114.142','0.03ms','2021-08-05 11:25:48'),(4,'GET',NULL,'/public/captcha/jigsaw.png','1.202.114.142','0.09ms','2021-08-05 11:25:48'),(5,'GET',NULL,'/public/captcha/dst.png','1.202.114.142','0.03ms','2021-08-05 11:27:16'),(6,'GET',NULL,'/public/captcha/jigsaw.png','1.202.114.142','0.1ms','2021-08-05 11:27:16'),(7,'GET',NULL,'/public/captcha/dst.png','1.202.114.142','0.03ms','2021-08-05 11:27:59'),(8,'GET',NULL,'/public/captcha/jigsaw.png','1.202.114.142','0.03ms','2021-08-05 11:27:59'),(9,'GET',NULL,'/public/captcha/dst.png','1.202.114.142','0.02ms','2021-08-05 11:28:27'),(10,'GET',NULL,'/public/captcha/jigsaw.png','1.202.114.142','0.03ms','2021-08-05 11:28:27'),(11,'GET',NULL,'/public/captcha/dst.png','1.202.114.142','0.03ms','2021-08-05 11:28:40'),(12,'GET',NULL,'/public/captcha/jigsaw.png','1.202.114.142','0.02ms','2021-08-05 11:28:40'),(13,'GET',NULL,'/public/captcha/dst.png','1.202.114.142','0.06ms','2021-08-05 11:31:03'),(14,'GET',NULL,'/public/captcha/jigsaw.png','1.202.114.142','0.08ms','2021-08-05 11:31:03'),(15,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','1.72ms','2021-08-05 11:34:51'),(16,'GET','admin','/sys_api','1.202.114.142','1.33ms','2021-08-05 11:34:51'),(17,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','1.57ms','2021-08-05 11:34:57'),(18,'POST','admin','/sys_menu','1.202.114.142','6.72ms','2021-08-05 11:36:08'),(19,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','2.23ms','2021-08-05 11:36:08'),(20,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','1.98ms','2021-08-05 11:36:13'),(21,'PUT','admin','/sys_menu','1.202.114.142','7.15ms','2021-08-05 11:36:23'),(22,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','2.15ms','2021-08-05 11:36:23'),(23,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.09ms','2021-08-05 11:36:27'),(24,'GET','admin','/sys_api','1.202.114.142','1.57ms','2021-08-05 11:36:27'),(25,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.43ms','2021-08-05 11:36:33'),(26,'POST','admin','/sys_menu','1.202.114.142','6.65ms','2021-08-05 11:37:34'),(27,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','2.49ms','2021-08-05 11:37:34'),(28,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.61ms','2021-08-05 11:37:43'),(29,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.59ms','2021-08-05 11:37:50'),(30,'GET','admin','/sys_api','1.202.114.142','1.23ms','2021-08-05 11:37:50'),(31,'GET','admin','/dict_type','1.202.114.142','1.23ms','2021-08-05 11:37:53'),(32,'POST','admin','/dict_type','1.202.114.142','6.41ms','2021-08-05 11:39:05'),(33,'GET','admin','/dict_type','1.202.114.142','1.38ms','2021-08-05 11:39:05'),(34,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','2.42ms','2021-08-05 11:39:11'),(35,'GET','admin','/sys_api','1.202.114.142','1.27ms','2021-08-05 11:39:11'),(36,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','2.61ms','2021-08-05 11:39:16'),(37,'GET','admin','/dict_type','1.202.114.142','3.72ms','2021-08-05 11:40:03'),(38,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.48ms','2021-08-05 11:40:06'),(39,'GET','admin','/sys_api','1.202.114.142','1.33ms','2021-08-05 11:40:06'),(40,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','2.64ms','2021-08-05 11:40:11'),(41,'POST','admin','/sys_menu','1.202.114.142','5.58ms','2021-08-05 11:40:54'),(42,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','2.8ms','2021-08-05 11:40:54'),(43,'GET','admin','/dict_type','1.202.114.142','1.33ms','2021-08-05 11:41:06'),(44,'GET','admin','/dict_type','1.202.114.142','1.23ms','2021-08-05 11:41:18'),(45,'GET','admin','/dict_type','1.202.114.142','1.4ms','2021-08-05 11:42:15'),(46,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.17ms','2021-08-05 11:42:22'),(47,'GET','admin','/sys_api','1.202.114.142','1.2ms','2021-08-05 11:42:22'),(48,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.06ms','2021-08-05 11:42:57'),(49,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.34ms','2021-08-05 11:43:13'),(50,'GET','admin','/sys_api','1.202.114.142','1.25ms','2021-08-05 11:43:13'),(51,'GET','admin','/dict_type','1.202.114.142','1.21ms','2021-08-05 11:43:16'),(52,'GET','admin','/dict_data/get_list','1.202.114.142','4.35ms','2021-08-05 11:43:18'),(53,'GET','admin','/dict_data/get_list','1.202.114.142','2.65ms','2021-08-05 11:43:41'),(54,'GET','admin','/dict_type','1.202.114.142','1.25ms','2021-08-05 11:43:57'),(55,'GET','admin','/dict_data/get_list','1.202.114.142','1.88ms','2021-08-05 11:44:01'),(56,'POST','admin','/dict_data','1.202.114.142','3.91ms','2021-08-05 11:44:32'),(57,'GET','admin','/dict_data/get_list','1.202.114.142','1.56ms','2021-08-05 11:44:32'),(58,'POST','admin','/dict_data','1.202.114.142','5ms','2021-08-05 11:44:43'),(59,'GET','admin','/dict_data/get_list','1.202.114.142','1.33ms','2021-08-05 11:44:43'),(60,'GET','admin','/dict_data/get_list','1.202.114.142','1.54ms','2021-08-05 11:44:47'),(61,'GET','admin','/dict_type','1.202.114.142','1.28ms','2021-08-05 11:44:57'),(62,'POST','admin','/dict_type','1.202.114.142','6.1ms','2021-08-05 11:45:23'),(63,'GET','admin','/dict_type','1.202.114.142','1.31ms','2021-08-05 11:45:23'),(64,'GET','admin','/dict_data/get_list','1.202.114.142','1.65ms','2021-08-05 11:45:26'),(65,'POST','admin','/dict_data','1.202.114.142','5.2ms','2021-08-05 11:45:41'),(66,'GET','admin','/dict_data/get_list','1.202.114.142','1.47ms','2021-08-05 11:45:41'),(67,'POST','admin','/dict_data','1.202.114.142','5.15ms','2021-08-05 11:45:50'),(68,'GET','admin','/dict_data/get_list','1.202.114.142','1.51ms','2021-08-05 11:45:50'),(69,'GET','admin','/dict_type','1.202.114.142','1.36ms','2021-08-05 11:45:54'),(70,'POST','admin','/dict_type','1.202.114.142','5.12ms','2021-08-05 11:46:19'),(71,'GET','admin','/dict_type','1.202.114.142','1.42ms','2021-08-05 11:46:19'),(72,'GET','admin','/dict_data/get_list','1.202.114.142','1.25ms','2021-08-05 11:46:21'),(73,'POST','admin','/dict_data','1.202.114.142','5.18ms','2021-08-05 11:46:30'),(74,'GET','admin','/dict_data/get_list','1.202.114.142','1.38ms','2021-08-05 11:46:30'),(75,'POST','admin','/dict_data','1.202.114.142','5.94ms','2021-08-05 11:46:39'),(76,'GET','admin','/dict_data/get_list','1.202.114.142','1.36ms','2021-08-05 11:46:39'),(77,'GET','admin','/dict_data/get_list','1.202.114.142','1.43ms','2021-08-05 11:46:43'),(78,'GET','admin','/dict_type','1.202.114.142','1.29ms','2021-08-05 11:46:44'),(79,'GET','admin','/dict_data/get_list','1.202.114.142','2.58ms','2021-08-05 11:46:45'),(80,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.21ms','2021-08-05 11:46:51'),(81,'GET','admin','/sys_api','1.202.114.142','1.26ms','2021-08-05 11:46:51'),(82,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.04ms','2021-08-05 11:46:58'),(83,'PUT','admin','/sys_menu','1.202.114.142','6.05ms','2021-08-05 11:47:02'),(84,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.19ms','2021-08-05 11:47:02'),(85,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.28ms','2021-08-05 11:47:12'),(86,'GET','admin','/sys_api','1.202.114.142','1.5ms','2021-08-05 11:47:12'),(87,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.53ms','2021-08-05 11:48:11'),(88,'POST','admin','/sys_menu','1.202.114.142','6.71ms','2021-08-05 11:48:47'),(89,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.29ms','2021-08-05 11:48:47'),(90,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.4ms','2021-08-05 11:48:50'),(91,'PUT','admin','/sys_menu','1.202.114.142','5.97ms','2021-08-05 11:48:55'),(92,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.22ms','2021-08-05 11:48:55'),(93,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.28ms','2021-08-05 11:49:06'),(94,'POST','admin','/sys_menu','1.202.114.142','7.86ms','2021-08-05 11:49:40'),(95,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.01ms','2021-08-05 11:49:40'),(96,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.15ms','2021-08-05 11:49:48'),(97,'PUT','admin','/sys_menu','1.202.114.142','5.07ms','2021-08-05 11:49:50'),(98,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.17ms','2021-08-05 11:49:50'),(99,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.73ms','2021-08-05 11:49:52'),(100,'PUT','admin','/sys_menu','1.202.114.142','5.55ms','2021-08-05 11:49:55'),(101,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.49ms','2021-08-05 11:49:55'),(102,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.95ms','2021-08-05 11:50:09'),(103,'GET','admin','/sys_api','1.202.114.142','1.22ms','2021-08-05 11:50:09'),(104,'GET','admin','/sys_user','1.202.114.142','7.26ms','2021-08-05 11:50:14'),(105,'GET','admin','/sys_role','1.202.114.142','1.94ms','2021-08-05 11:50:14'),(106,'PUT','admin','/sys_user/change_user_status','1.202.114.142','1.79ms','2021-08-05 11:50:18'),(107,'GET','admin','/sys_role','1.202.114.142','1.66ms','2021-08-05 11:50:24'),(108,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','3.89ms','2021-08-05 11:50:24'),(109,'GET','admin','/sys_user','1.202.114.142','1.48ms','2021-08-05 11:50:39'),(110,'GET','admin','/sys_role','1.202.114.142','1.5ms','2021-08-05 11:50:39'),(111,'GET','admin','/sys_api','1.202.114.142','1.46ms','2021-08-05 11:50:47'),(112,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.08ms','2021-08-05 11:50:47'),(113,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.06ms','2021-08-05 11:51:00'),(114,'POST','admin','/sys_menu','1.202.114.142','5.39ms','2021-08-05 11:51:29'),(115,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.42ms','2021-08-05 11:51:29'),(116,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.11ms','2021-08-05 11:51:35'),(117,'PUT','admin','/sys_menu','1.202.114.142','6.1ms','2021-08-05 11:51:50'),(118,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.03ms','2021-08-05 11:51:50'),(119,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.6ms','2021-08-05 11:51:54'),(120,'PUT','admin','/sys_menu','1.202.114.142','6.05ms','2021-08-05 11:51:57'),(121,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.4ms','2021-08-05 11:51:57'),(122,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.13ms','2021-08-05 11:52:10'),(123,'POST','admin','/sys_menu','1.202.114.142','6.97ms','2021-08-05 11:52:24'),(124,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.01ms','2021-08-05 11:52:24'),(125,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.76ms','2021-08-05 11:52:28'),(126,'PUT','admin','/sys_menu','1.202.114.142','6.12ms','2021-08-05 11:52:31'),(127,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.82ms','2021-08-05 11:52:32'),(128,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','4.98ms','2021-08-05 11:52:34'),(129,'POST','admin','/sys_menu','1.202.114.142','5.92ms','2021-08-05 11:53:18'),(130,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6.11ms','2021-08-05 11:53:18'),(131,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.82ms','2021-08-05 11:53:21'),(132,'POST','admin','/sys_menu','1.202.114.142','4.72ms','2021-08-05 11:54:06'),(133,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.96ms','2021-08-05 11:54:06'),(134,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6.6ms','2021-08-05 11:54:14'),(135,'GET','admin','/sys_api','1.202.114.142','1.28ms','2021-08-05 11:54:14'),(136,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.71ms','2021-08-05 11:54:28'),(137,'GET','admin','/sys_api','1.202.114.142','1.16ms','2021-08-05 11:54:28'),(138,'GET','admin','/sys_log/get_operation_log','1.202.114.142','1.61ms','2021-08-05 11:54:38'),(139,'GET','admin','/sys_log/get_operation_log','1.202.114.142','1.57ms','2021-08-05 11:54:42'),(140,'GET','admin','/sys_log/get_operation_log','1.202.114.142','1.51ms','2021-08-05 11:54:44'),(141,'GET','admin','/sys_log/get_operation_log','1.202.114.142','1.48ms','2021-08-05 11:54:46'),(142,'GET','admin','/sys_log/get_operation_log','1.202.114.142','1.34ms','2021-08-05 11:54:49'),(143,'GET','admin','/sys_log/get_operation_log','1.202.114.142','1.4ms','2021-08-05 11:55:38'),(144,'GET','admin','/sys_log/get_login_log','1.202.114.142','1.42ms','2021-08-05 11:55:50'),(145,'GET','admin','/sys_user','1.202.114.142','2ms','2021-08-05 11:56:06'),(146,'GET','admin','/sys_role','1.202.114.142','1.52ms','2021-08-05 11:56:06'),(147,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6ms','2021-08-05 11:56:10'),(148,'GET','admin','/sys_api','1.202.114.142','1.35ms','2021-08-05 11:56:10'),(149,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.4ms','2021-08-05 11:56:12'),(150,'GET','admin','/sys_api','1.202.114.142','1.2ms','2021-08-05 11:56:12'),(151,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.78ms','2021-08-05 11:56:19'),(152,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.85ms','2021-08-05 11:56:30'),(153,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.64ms','2021-08-05 11:56:36'),(154,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.11ms','2021-08-05 11:59:13'),(155,'GET','admin','/sys_api','1.202.114.142','1.27ms','2021-08-05 11:59:13'),(156,'GET','admin','/sys_log/get_login_log','1.202.114.142','1.39ms','2021-08-05 15:47:42'),(157,'GET','admin','/sys_log/get_operation_log','1.202.114.142','1.47ms','2021-08-05 15:50:05'),(158,'GET','admin','/sys_user','1.202.114.142','1.65ms','2021-08-05 15:50:13'),(159,'GET','admin','/sys_role','1.202.114.142','1.47ms','2021-08-05 15:50:13'),(160,'DELETE','admin','/sys_user','1.202.114.142','1.61ms','2021-08-05 15:50:16'),(161,'GET','admin','/sys_log/get_operation_log','1.202.114.142','1.51ms','2021-08-05 15:50:32'),(162,'GET','admin','/sys_log/get_operation_log','1.202.114.142','1.48ms','2021-08-05 16:02:45'),(163,'GET','admin','/sys_log/get_operation_log','1.202.114.142','1.63ms','2021-08-05 16:03:11'),(164,'GET','admin','/sys_user','1.202.114.142','1.56ms','2021-08-05 16:04:08'),(165,'GET','admin','/sys_role','1.202.114.142','1.46ms','2021-08-05 16:04:08'),(166,'GET','admin','/sys_log/get_operation_log','1.202.114.142','1.52ms','2021-08-05 16:32:00'),(167,'GET','admin','/sys_log/get_login_log','1.202.114.142','1.31ms','2021-08-05 16:48:23'),(168,'GET','admin','/sys_user','1.202.114.142','1.56ms','2021-08-05 16:51:33'),(169,'GET','admin','/sys_role','1.202.114.142','1.55ms','2021-08-05 16:51:33'),(170,'GET','admin','/sys_role','1.202.114.142','2.48ms','2021-08-05 16:51:34'),(171,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.18ms','2021-08-05 16:51:34'),(172,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.84ms','2021-08-05 16:51:36'),(173,'GET','admin','/sys_api','1.202.114.142','1.24ms','2021-08-05 16:51:36'),(174,'GET','admin','/sys_api','1.202.114.142','1.33ms','2021-08-05 16:51:50'),(175,'GET','admin','/dict_type','1.202.114.142','1.44ms','2021-08-05 16:51:53'),(176,'GET','admin','/sys_log/get_login_log','1.202.114.142','1.21ms','2021-08-05 16:59:42'),(177,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','9.29ms','2021-08-09 12:34:36'),(178,'GET','admin','/sys_api','1.202.114.142','1.28ms','2021-08-09 12:34:36'),(179,'GET','admin','/sys_api','1.202.114.142','1.3ms','2021-08-09 13:20:57'),(180,'POST','admin','/sys_api','1.202.114.142','5.03ms','2021-08-09 13:21:17'),(181,'GET','admin','/sys_api','1.202.114.142','1.35ms','2021-08-09 13:21:17'),(182,'POST','admin','/sys_api','1.202.114.142','5.47ms','2021-08-09 13:21:51'),(183,'GET','admin','/sys_api','1.202.114.142','1.43ms','2021-08-09 13:21:51'),(184,'POST','admin','/sys_api','1.202.114.142','5.32ms','2021-08-09 13:22:08'),(185,'GET','admin','/sys_api','1.202.114.142','1.2ms','2021-08-09 13:22:08'),(186,'POST','admin','/sys_api','1.202.114.142','5.09ms','2021-08-09 13:22:30'),(187,'GET','admin','/sys_api','1.202.114.142','1.33ms','2021-08-09 13:22:30'),(188,'POST','admin','/sys_api','1.202.114.142','3.17ms','2021-08-09 13:22:48'),(189,'GET','admin','/sys_api','1.202.114.142','1.24ms','2021-08-09 13:22:48'),(190,'GET','admin','/sys_api','1.202.114.142','1.34ms','2021-08-09 13:25:30'),(191,'POST','admin','/sys_api','1.202.114.142','6ms','2021-08-09 13:26:01'),(192,'GET','admin','/sys_api','1.202.114.142','1.45ms','2021-08-09 13:26:01'),(193,'POST','admin','/sys_api','1.202.114.142','4.5ms','2021-08-09 13:26:16'),(194,'GET','admin','/sys_api','1.202.114.142','1.41ms','2021-08-09 13:26:16'),(195,'POST','admin','/sys_api','1.202.114.142','5.01ms','2021-08-09 13:26:42'),(196,'GET','admin','/sys_api','1.202.114.142','1.7ms','2021-08-09 13:26:42'),(197,'POST','admin','/sys_api','1.202.114.142','4.57ms','2021-08-09 13:26:53'),(198,'GET','admin','/sys_api','1.202.114.142','1.68ms','2021-08-09 13:26:53'),(199,'POST','admin','/sys_api','1.202.114.142','6.92ms','2021-08-09 13:27:21'),(200,'GET','admin','/sys_api','1.202.114.142','1.27ms','2021-08-09 13:27:21'),(201,'POST','admin','/sys_api','1.202.114.142','3.89ms','2021-08-09 13:28:18'),(202,'GET','admin','/sys_api','1.202.114.142','1.43ms','2021-08-09 13:28:18'),(203,'POST','admin','/sys_api','1.202.114.142','4.75ms','2021-08-09 13:28:49'),(204,'GET','admin','/sys_api','1.202.114.142','1.34ms','2021-08-09 13:28:49'),(205,'POST','admin','/sys_api','1.202.114.142','28.09ms','2021-08-09 13:30:19'),(206,'GET','admin','/sys_api','1.202.114.142','1.39ms','2021-08-09 13:30:19'),(207,'POST','admin','/sys_api','1.202.114.142','4.88ms','2021-08-09 13:30:48'),(208,'GET','admin','/sys_api','1.202.114.142','1.45ms','2021-08-09 13:30:48'),(209,'POST','admin','/sys_api','1.202.114.142','6.27ms','2021-08-09 13:31:12'),(210,'GET','admin','/sys_api','1.202.114.142','1.3ms','2021-08-09 13:31:12'),(211,'POST','admin','/sys_api','1.202.114.142','5.74ms','2021-08-09 13:31:26'),(212,'GET','admin','/sys_api','1.202.114.142','1.28ms','2021-08-09 13:31:26'),(213,'POST','admin','/sys_api','1.202.114.142','6.13ms','2021-08-09 13:31:40'),(214,'GET','admin','/sys_api','1.202.114.142','1.41ms','2021-08-09 13:31:40'),(215,'POST','admin','/sys_api','1.202.114.142','9.39ms','2021-08-09 13:32:01'),(216,'GET','admin','/sys_api','1.202.114.142','2.06ms','2021-08-09 13:32:02'),(217,'POST','admin','/sys_api','1.202.114.142','4.8ms','2021-08-09 13:32:19'),(218,'GET','admin','/sys_api','1.202.114.142','1.39ms','2021-08-09 13:32:19'),(219,'POST','admin','/sys_api','1.202.114.142','6.36ms','2021-08-09 13:32:41'),(220,'GET','admin','/sys_api','1.202.114.142','1.45ms','2021-08-09 13:32:41'),(221,'POST','admin','/sys_api','1.202.114.142','3.53ms','2021-08-09 13:33:16'),(222,'GET','admin','/sys_api','1.202.114.142','1.37ms','2021-08-09 13:33:16'),(223,'POST','admin','/sys_api','1.202.114.142','5.16ms','2021-08-09 13:33:28'),(224,'GET','admin','/sys_api','1.202.114.142','1.35ms','2021-08-09 13:33:28'),(225,'POST','admin','/sys_api','1.202.114.142','5.06ms','2021-08-09 13:33:44'),(226,'GET','admin','/sys_api','1.202.114.142','1.39ms','2021-08-09 13:33:44'),(227,'POST','admin','/sys_api','1.202.114.142','5.04ms','2021-08-09 13:33:56'),(228,'GET','admin','/sys_api','1.202.114.142','1.55ms','2021-08-09 13:33:56'),(229,'POST','admin','/sys_api','1.202.114.142','5.18ms','2021-08-09 13:34:16'),(230,'GET','admin','/sys_api','1.202.114.142','1.35ms','2021-08-09 13:34:16'),(231,'POST','admin','/sys_api','1.202.114.142','6.14ms','2021-08-09 13:35:11'),(232,'GET','admin','/sys_api','1.202.114.142','1.56ms','2021-08-09 13:35:11'),(233,'POST','admin','/sys_api','1.202.114.142','5.3ms','2021-08-09 13:35:30'),(234,'GET','admin','/sys_api','1.202.114.142','1.47ms','2021-08-09 13:35:30'),(235,'POST','admin','/sys_api','1.202.114.142','5.26ms','2021-08-09 13:35:42'),(236,'GET','admin','/sys_api','1.202.114.142','1.44ms','2021-08-09 13:35:42'),(237,'POST','admin','/sys_api','1.202.114.142','3.4ms','2021-08-09 13:36:09'),(238,'GET','admin','/sys_api','1.202.114.142','1.36ms','2021-08-09 13:36:09'),(239,'POST','admin','/sys_api','1.202.114.142','6.09ms','2021-08-09 13:36:38'),(240,'GET','admin','/sys_api','1.202.114.142','1.42ms','2021-08-09 13:36:38'),(241,'POST','admin','/sys_api','1.202.114.142','4.96ms','2021-08-09 13:36:57'),(242,'GET','admin','/sys_api','1.202.114.142','1.29ms','2021-08-09 13:36:57'),(243,'POST','admin','/sys_api','1.202.114.142','4.95ms','2021-08-09 13:37:15'),(244,'GET','admin','/sys_api','1.202.114.142','1.31ms','2021-08-09 13:37:15'),(245,'GET','admin','/sys_api','1.202.114.142','1.48ms','2021-08-09 13:37:49'),(246,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.76ms','2021-08-09 13:37:49'),(247,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.87ms','2021-08-09 13:38:08'),(248,'PUT','admin','/sys_menu','1.202.114.142','44.39ms','2021-08-09 13:38:52'),(249,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6.06ms','2021-08-09 13:38:53'),(250,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.85ms','2021-08-09 13:39:02'),(251,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6.85ms','2021-08-09 13:39:07'),(252,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6.15ms','2021-08-09 13:39:58'),(253,'PUT','admin','/sys_menu','1.202.114.142','9.69ms','2021-08-09 13:40:02'),(254,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6.02ms','2021-08-09 13:40:02'),(255,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.85ms','2021-08-09 13:40:05'),(256,'PUT','admin','/sys_menu','1.202.114.142','10.95ms','2021-08-09 13:40:12'),(257,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6.02ms','2021-08-09 13:40:12'),(258,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','5.93ms','2021-08-09 13:40:16'),(259,'POST','admin','/sys_menu','1.202.114.142','19.1ms','2021-08-09 13:40:48'),(260,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6.47ms','2021-08-09 13:40:48'),(261,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6.36ms','2021-08-09 13:40:55'),(262,'POST','admin','/sys_menu','1.202.114.142','12.62ms','2021-08-09 13:41:28'),(263,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6.35ms','2021-08-09 13:41:28'),(264,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6.26ms','2021-08-09 13:41:35'),(265,'POST','admin','/sys_menu','1.202.114.142','10.31ms','2021-08-09 13:42:02'),(266,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.59ms','2021-08-09 13:42:02'),(267,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.3ms','2021-08-09 13:42:05'),(268,'PUT','admin','/sys_menu','1.202.114.142','14.03ms','2021-08-09 13:42:08'),(269,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','6.8ms','2021-08-09 13:42:09'),(270,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.5ms','2021-08-09 13:42:22'),(271,'PUT','admin','/sys_menu','1.202.114.142','15.06ms','2021-08-09 13:42:24'),(272,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.1ms','2021-08-09 13:42:24'),(273,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.09ms','2021-08-09 13:42:26'),(274,'POST','admin','/sys_menu','1.202.114.142','5.65ms','2021-08-09 13:42:40'),(275,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.32ms','2021-08-09 13:42:40'),(276,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.27ms','2021-08-09 13:42:44'),(277,'PUT','admin','/sys_menu','1.202.114.142','10.77ms','2021-08-09 13:42:48'),(278,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.37ms','2021-08-09 13:42:48'),(279,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.74ms','2021-08-09 13:43:12'),(280,'POST','admin','/sys_menu','1.202.114.142','11.69ms','2021-08-09 13:43:46'),(281,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.12ms','2021-08-09 13:43:46'),(282,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.15ms','2021-08-09 13:43:50'),(283,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.76ms','2021-08-09 13:43:54'),(284,'PUT','admin','/sys_menu','1.202.114.142','14.69ms','2021-08-09 13:43:58'),(285,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.98ms','2021-08-09 13:43:58'),(286,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.85ms','2021-08-09 13:44:02'),(287,'PUT','admin','/sys_menu','1.202.114.142','11.74ms','2021-08-09 13:44:05'),(288,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.36ms','2021-08-09 13:44:05'),(289,'GET','admin','/sys_user','1.202.114.142','1.46ms','2021-08-09 13:44:37'),(290,'GET','admin','/sys_role','1.202.114.142','1.42ms','2021-08-09 13:44:37'),(291,'POST','admin','/sys_user','1.202.114.142','5.1ms','2021-08-09 13:45:13'),(292,'GET','admin','/sys_user','1.202.114.142','2.01ms','2021-08-09 13:45:13'),(293,'PUT','admin','/sys_user/update_user','1.202.114.142','24.84ms','2021-08-09 13:45:30'),(294,'GET','admin','/sys_user','1.202.114.142','3.89ms','2021-08-09 13:45:31'),(295,'GET','admin','/sys_role','1.202.114.142','2.26ms','2021-08-09 13:45:40'),(296,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.75ms','2021-08-09 13:45:40'),(297,'POST','admin','/sys_role','1.202.114.142','55.24ms','2021-08-09 13:46:11'),(298,'GET','admin','/sys_role','1.202.114.142','1.87ms','2021-08-09 13:46:11'),(299,'GET','admin','/sys_user','1.202.114.142','1.8ms','2021-08-09 13:46:17'),(300,'GET','admin','/sys_role','1.202.114.142','1.91ms','2021-08-09 13:46:17'),(301,'PUT','admin','/sys_user/update_user','1.202.114.142','11.05ms','2021-08-09 13:46:22'),(302,'GET','admin','/sys_user','1.202.114.142','2.01ms','2021-08-09 13:46:22'),(303,'GET','user','/sys_user','1.202.114.142','6.61ms','2021-08-09 13:46:37'),(304,'GET','user','/sys_role','1.202.114.142','1.3ms','2021-08-09 13:46:37'),(305,'GET','user','/sys_user','1.202.114.142','3.59ms','2021-08-09 13:46:53'),(306,'GET','user','/sys_role','1.202.114.142','1.21ms','2021-08-09 13:46:53'),(307,'GET','admin','/sys_user','1.202.114.142','2.92ms','2021-08-09 13:47:32'),(308,'GET','admin','/sys_role','1.202.114.142','4.16ms','2021-08-09 13:47:32'),(309,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','11.97ms','2021-08-09 13:47:37'),(310,'GET','admin','/sys_api','1.202.114.142','1.45ms','2021-08-09 13:47:37'),(311,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.85ms','2021-08-09 13:47:42'),(312,'PUT','admin','/sys_menu','1.202.114.142','30.24ms','2021-08-09 13:47:51'),(313,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.27ms','2021-08-09 13:47:51'),(314,'GET','user','/sys_user','1.202.114.142','2.89ms','2021-08-09 13:48:42'),(315,'GET','user','/sys_role','1.202.114.142','2.53ms','2021-08-09 13:48:42'),(316,'GET','admin','/sys_role','1.202.114.142','2.55ms','2021-08-09 13:49:02'),(317,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.01ms','2021-08-09 13:49:02'),(318,'PUT','admin','/sys_role/update_role','1.202.114.142','47.75ms','2021-08-09 13:49:09'),(319,'GET','admin','/sys_role','1.202.114.142','2.08ms','2021-08-09 13:49:09'),(320,'GET','user','/sys_user','1.202.114.142','17.35ms','2021-08-09 13:49:14'),(321,'GET','user','/sys_role','1.202.114.142','2.28ms','2021-08-09 13:49:14'),(322,'PUT','admin','/sys_role/update_role','1.202.114.142','45.6ms','2021-08-09 13:49:30'),(323,'GET','admin','/sys_role','1.202.114.142','2.04ms','2021-08-09 13:49:30'),(324,'GET','user','/sys_user','1.202.114.142','5.1ms','2021-08-09 13:49:38'),(325,'GET','user','/sys_role','1.202.114.142','2.22ms','2021-08-09 13:49:38'),(326,'PUT','admin','/sys_role/update_role','1.202.114.142','33.74ms','2021-08-09 13:49:48'),(327,'GET','admin','/sys_role','1.202.114.142','1.97ms','2021-08-09 13:49:48'),(328,'GET','user','/sys_user','1.202.114.142','5.17ms','2021-08-09 13:49:58'),(329,'GET','user','/sys_role','1.202.114.142','2.54ms','2021-08-09 13:49:58'),(330,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.59ms','2021-08-09 13:50:18'),(331,'GET','admin','/sys_api','1.202.114.142','1.5ms','2021-08-09 13:50:18'),(332,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.26ms','2021-08-09 14:00:27'),(333,'GET','admin','/sys_api','1.202.114.142','1.32ms','2021-08-09 14:00:27'),(334,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','7.82ms','2021-08-09 14:00:37'),(335,'PUT','admin','/sys_menu','1.202.114.142','9.11ms','2021-08-09 14:00:48'),(336,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','11.05ms','2021-08-09 14:00:48'),(337,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.05ms','2021-08-09 14:00:53'),(338,'POST','admin','/sys_menu','1.202.114.142','10.76ms','2021-08-09 14:01:28'),(339,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.92ms','2021-08-09 14:01:28'),(340,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.37ms','2021-08-09 14:01:33'),(341,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','9.37ms','2021-08-09 14:01:43'),(342,'PUT','admin','/sys_menu','1.202.114.142','29.11ms','2021-08-09 14:01:50'),(343,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.18ms','2021-08-09 14:01:50'),(344,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','8.09ms','2021-08-09 14:01:51'),(345,'POST','admin','/sys_menu','1.202.114.142','18.92ms','2021-08-09 14:02:28'),(346,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','9.46ms','2021-08-09 14:02:28'),(347,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','9.08ms','2021-08-09 14:02:33'),(348,'PUT','admin','/sys_menu','1.202.114.142','22.36ms','2021-08-09 14:02:38'),(349,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','9.27ms','2021-08-09 14:02:38'),(350,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','9.41ms','2021-08-09 14:02:40'),(351,'POST','admin','/sys_menu','1.202.114.142','12.59ms','2021-08-09 14:03:09'),(352,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','9.69ms','2021-08-09 14:03:09'),(353,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','9.86ms','2021-08-09 14:03:12'),(354,'PUT','admin','/sys_menu','1.202.114.142','25.94ms','2021-08-09 14:03:15'),(355,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','10.53ms','2021-08-09 14:03:15'),(356,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','10.41ms','2021-08-09 14:03:21'),(357,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','9.51ms','2021-08-09 14:03:25'),(358,'POST','admin','/sys_menu','1.202.114.142','9.16ms','2021-08-09 14:03:58'),(359,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','10.38ms','2021-08-09 14:03:59'),(360,'GET','admin','/sys_user','1.202.114.142','1.98ms','2021-08-09 14:04:17'),(361,'GET','admin','/sys_role','1.202.114.142','1.66ms','2021-08-09 14:04:17'),(362,'GET','admin','/sys_role','1.202.114.142','1.99ms','2021-08-09 14:04:25'),(363,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','10.93ms','2021-08-09 14:04:25'),(364,'PUT','admin','/sys_role/update_role','1.202.114.142','44.77ms','2021-08-09 14:04:42'),(365,'GET','admin','/sys_role','1.202.114.142','2.07ms','2021-08-09 14:04:42'),(366,'GET','user','/sys_role','1.202.114.142','2.14ms','2021-08-09 14:04:54'),(367,'GET','user','/sys_menu/get_menu_tree','1.202.114.142','1.24ms','2021-08-09 14:04:54'),(368,'GET','user','/sys_role','1.202.114.142','5.16ms','2021-08-09 14:05:09'),(369,'GET','user','/sys_menu/get_menu_tree','1.202.114.142','3.7ms','2021-08-09 14:05:09'),(370,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','13.87ms','2021-08-09 14:05:21'),(371,'GET','admin','/sys_api','1.202.114.142','1.57ms','2021-08-09 14:05:21'),(372,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','10.16ms','2021-08-09 14:05:26'),(373,'PUT','admin','/sys_menu','1.202.114.142','25.87ms','2021-08-09 14:05:38'),(374,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','10.97ms','2021-08-09 14:05:38'),(375,'GET','user','/sys_role','1.202.114.142','3.92ms','2021-08-09 14:05:44'),(376,'GET','user','/sys_menu/get_menu_tree','1.202.114.142','11.04ms','2021-08-09 14:05:44'),(377,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','10.38ms','2021-08-09 14:06:07'),(378,'PUT','admin','/sys_menu','1.202.114.142','26.59ms','2021-08-09 14:06:23'),(379,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','9.51ms','2021-08-09 14:06:23'),(380,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','9.67ms','2021-08-09 14:08:41'),(381,'GET','admin','/sys_role','1.202.114.142','2.23ms','2021-08-09 14:08:41'),(382,'PUT','admin','/sys_role/update_role','1.202.114.142','44.62ms','2021-08-09 14:08:51'),(383,'GET','admin','/sys_role','1.202.114.142','1.82ms','2021-08-09 14:08:51'),(384,'GET','user','/sys_role','1.202.114.142','2.48ms','2021-08-09 14:08:57'),(385,'GET','user','/sys_menu/get_menu_tree','1.202.114.142','10.04ms','2021-08-09 14:08:57'),(386,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','10.82ms','2021-08-09 14:09:04'),(387,'GET','admin','/sys_api','1.202.114.142','1.35ms','2021-08-09 14:09:04'),(388,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','9.82ms','2021-08-09 14:09:08'),(389,'POST','admin','/sys_menu','1.202.114.142','9.62ms','2021-08-09 14:09:36'),(390,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','11.08ms','2021-08-09 14:09:36'),(391,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','10.4ms','2021-08-09 14:09:58'),(392,'POST','admin','/sys_menu','1.202.114.142','20.72ms','2021-08-09 14:10:18'),(393,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','10.65ms','2021-08-09 14:10:18'),(394,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','12.74ms','2021-08-09 14:10:21'),(395,'POST','admin','/sys_menu','1.202.114.142','10.8ms','2021-08-09 14:10:42'),(396,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','11.92ms','2021-08-09 14:10:42'),(397,'GET','admin','/sys_user','1.202.114.142','1.83ms','2021-08-09 14:11:15'),(398,'GET','admin','/sys_role','1.202.114.142','1.64ms','2021-08-09 14:11:15'),(399,'GET','admin','/sys_role','1.202.114.142','1.91ms','2021-08-09 14:11:16'),(400,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','14.55ms','2021-08-09 14:11:16'),(401,'PUT','admin','/sys_role/update_role','1.202.114.142','42.41ms','2021-08-09 14:11:24'),(402,'GET','admin','/sys_role','1.202.114.142','1.74ms','2021-08-09 14:11:24'),(403,'GET','user','/sys_menu/get_menu_tree','1.202.114.142','12.76ms','2021-08-09 14:11:35'),(404,'GET','user','/sys_api','1.202.114.142','1.43ms','2021-08-09 14:11:35'),(405,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','12.55ms','2021-08-09 14:11:45'),(406,'GET','admin','/sys_api','1.202.114.142','1.56ms','2021-08-09 14:11:45'),(407,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','12.37ms','2021-08-09 14:11:54'),(408,'PUT','admin','/sys_menu','1.202.114.142','17.11ms','2021-08-09 14:12:08'),(409,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','11.49ms','2021-08-09 14:12:08'),(410,'GET','user','/sys_api','1.202.114.142','1.89ms','2021-08-09 14:12:13'),(411,'GET','user','/sys_menu/get_menu_tree','1.202.114.142','14.33ms','2021-08-09 14:12:13'),(412,'GET','admin','/sys_role','1.202.114.142','1.93ms','2021-08-09 14:12:21'),(413,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','11.49ms','2021-08-09 14:12:21'),(414,'PUT','admin','/sys_role/update_role','1.202.114.142','37.39ms','2021-08-09 14:12:28'),(415,'GET','admin','/sys_role','1.202.114.142','1.78ms','2021-08-09 14:12:28'),(416,'GET','user','/sys_menu/get_menu_tree','1.202.114.142','13.31ms','2021-08-09 14:12:33'),(417,'GET','user','/sys_api','1.202.114.142','3.4ms','2021-08-09 14:12:33'),(418,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','11.69ms','2021-08-09 14:12:40'),(419,'GET','admin','/sys_api','1.202.114.142','1.86ms','2021-08-09 14:12:40'),(420,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','20.87ms','2021-08-09 14:12:46'),(421,'PUT','admin','/sys_menu','1.202.114.142','10.37ms','2021-08-09 14:12:53'),(422,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','11.73ms','2021-08-09 14:12:53'),(423,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','11.08ms','2021-08-09 14:12:56'),(424,'POST','admin','/sys_menu','1.202.114.142','10.45ms','2021-08-09 14:13:29'),(425,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','12.53ms','2021-08-09 14:13:30'),(426,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','12.12ms','2021-08-09 14:13:32'),(427,'POST','admin','/sys_menu','1.202.114.142','11.6ms','2021-08-09 14:13:56'),(428,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','12.09ms','2021-08-09 14:13:56'),(429,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','11.79ms','2021-08-09 14:14:15'),(430,'POST','admin','/sys_menu','1.202.114.142','19.22ms','2021-08-09 14:14:27'),(431,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','13.8ms','2021-08-09 14:14:27'),(432,'GET','admin','/sys_role','1.202.114.142','4.13ms','2021-08-09 14:14:58'),(433,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','12.59ms','2021-08-09 14:14:58'),(434,'PUT','admin','/sys_role/update_role','1.202.114.142','42.5ms','2021-08-09 14:15:07'),(435,'GET','admin','/sys_role','1.202.114.142','1.76ms','2021-08-09 14:15:07'),(436,'GET','user','/sys_api','1.202.114.142','1.77ms','2021-08-09 14:15:17'),(437,'PUT','admin','/sys_role/update_role','1.202.114.142','36.69ms','2021-08-09 14:15:30'),(438,'GET','admin','/sys_role','1.202.114.142','1.79ms','2021-08-09 14:15:30'),(439,'GET','user','/sys_api','1.202.114.142','2.23ms','2021-08-09 14:15:35'),(440,'PUT','admin','/sys_role/update_role','1.202.114.142','26.39ms','2021-08-09 14:15:51'),(441,'GET','admin','/sys_role','1.202.114.142','1.92ms','2021-08-09 14:15:51'),(442,'GET','user','/sys_api','1.202.114.142','1.79ms','2021-08-09 14:15:56'),(443,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','13.71ms','2021-08-09 14:16:05'),(444,'GET','admin','/sys_api','1.202.114.142','1.33ms','2021-08-09 14:16:05'),(445,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','12.6ms','2021-08-09 14:16:16'),(446,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','12.45ms','2021-08-09 14:16:21'),(447,'PUT','admin','/sys_menu','1.202.114.142','10.74ms','2021-08-09 14:16:31'),(448,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','12.76ms','2021-08-09 14:16:31'),(449,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','13.58ms','2021-08-09 14:16:34'),(450,'POST','admin','/sys_menu','1.202.114.142','12.08ms','2021-08-09 14:17:05'),(451,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','13.68ms','2021-08-09 14:17:05'),(452,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','13.01ms','2021-08-09 14:17:07'),(453,'POST','admin','/sys_menu','1.202.114.142','10.71ms','2021-08-09 14:17:32'),(454,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','13.76ms','2021-08-09 14:17:32'),(455,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','14.11ms','2021-08-09 14:17:38'),(456,'PUT','admin','/sys_menu','1.202.114.142','22.86ms','2021-08-09 14:17:45'),(457,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','13.93ms','2021-08-09 14:17:45'),(458,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','14.54ms','2021-08-09 14:18:18'),(459,'POST','admin','/sys_menu','1.202.114.142','8.61ms','2021-08-09 14:18:30'),(460,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','13.93ms','2021-08-09 14:18:30'),(461,'GET','admin','/sys_role','1.202.114.142','1.77ms','2021-08-09 14:18:38'),(462,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','13.97ms','2021-08-09 14:18:38'),(463,'PUT','admin','/sys_role/update_role','1.202.114.142','37.7ms','2021-08-09 14:18:46'),(464,'GET','admin','/sys_role','1.202.114.142','1.95ms','2021-08-09 14:18:46'),(465,'GET','user','/dict_type','1.202.114.142','3.02ms','2021-08-09 14:18:57'),(466,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','18.45ms','2021-08-09 14:19:05'),(467,'GET','admin','/sys_api','1.202.114.142','1.33ms','2021-08-09 14:19:05'),(468,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','14.38ms','2021-08-09 14:19:10'),(469,'PUT','admin','/sys_menu','1.202.114.142','10.5ms','2021-08-09 14:19:19'),(470,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','14.08ms','2021-08-09 14:19:19'),(471,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','17.22ms','2021-08-09 14:19:21'),(472,'POST','admin','/sys_menu','1.202.114.142','19.39ms','2021-08-09 14:19:51'),(473,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','14.91ms','2021-08-09 14:19:51'),(474,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','15.99ms','2021-08-09 14:19:54'),(475,'POST','admin','/sys_menu','1.202.114.142','14.97ms','2021-08-09 14:20:15'),(476,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','14.81ms','2021-08-09 14:20:15'),(477,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','21.58ms','2021-08-09 14:20:27'),(478,'POST','admin','/sys_menu','1.202.114.142','10.97ms','2021-08-09 14:20:37'),(479,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','16.82ms','2021-08-09 14:20:37'),(480,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','17.1ms','2021-08-09 14:20:47'),(481,'GET','admin','/sys_role','1.202.114.142','2.06ms','2021-08-09 14:20:47'),(482,'PUT','admin','/sys_role/update_role','1.202.114.142','61.22ms','2021-08-09 14:20:53'),(483,'GET','admin','/sys_role','1.202.114.142','2.04ms','2021-08-09 14:20:53'),(484,'GET','user','/dict_type','1.202.114.142','3.35ms','2021-08-09 14:20:59'),(485,'GET','user','/dict_data/get_list','1.202.114.142','3.06ms','2021-08-09 14:21:01'),(486,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','16.14ms','2021-08-09 14:21:07'),(487,'GET','admin','/sys_api','1.202.114.142','1.15ms','2021-08-09 14:21:07'),(488,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','16.09ms','2021-08-09 14:21:22'),(489,'PUT','admin','/sys_menu','1.202.114.142','11.63ms','2021-08-09 14:21:49'),(490,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','15.37ms','2021-08-09 14:21:49'),(491,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','17.38ms','2021-08-09 14:21:51'),(492,'POST','admin','/sys_menu','1.202.114.142','11.79ms','2021-08-09 14:22:13'),(493,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','16.86ms','2021-08-09 14:22:13'),(494,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','15.39ms','2021-08-09 14:22:17'),(495,'POST','admin','/sys_menu','1.202.114.142','10.6ms','2021-08-09 14:22:38'),(496,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','15.96ms','2021-08-09 14:22:38'),(497,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','17.24ms','2021-08-09 14:22:40'),(498,'PUT','admin','/sys_menu','1.202.114.142','11.55ms','2021-08-09 14:22:45'),(499,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','17.15ms','2021-08-09 14:22:45'),(500,'GET','user','/dict_data/get_list','1.202.114.142','3.61ms','2021-08-09 14:22:51'),(501,'GET','admin','/sys_role','1.202.114.142','4.7ms','2021-08-09 14:22:56'),(502,'GET','admin','/sys_menu/get_menu_tree','1.202.114.142','18.31ms','2021-08-09 14:22:56'),(503,'PUT','admin','/sys_role/update_role','1.202.114.142','47.51ms','2021-08-09 14:23:01'),(504,'GET','admin','/sys_role','1.202.114.142','2.38ms','2021-08-09 14:23:02'),(505,'GET','user','/sys_log/get_login_log','1.202.114.142','1.95ms','2021-08-09 14:23:11'),(506,'GET','user','/sys_log/get_operation_log','1.202.114.142','2.19ms','2021-08-09 14:23:13'),(507,'PUT','admin','/sys_role/change_role_status','1.202.114.142','6.19ms','2021-08-09 14:23:42'),(508,'PUT','admin','/sys_role/change_role_status','1.202.114.142','5.14ms','2021-08-09 14:23:58'),(509,'PUT','admin','/sys_role/update_role','1.202.114.142','45.77ms','2021-08-09 14:24:45'),(510,'GET','admin','/sys_role','1.202.114.142','1.77ms','2021-08-09 14:24:45'),(511,'PUT','admin','/sys_role/update_role','1.202.114.142','39.84ms','2021-08-09 14:25:04'),(512,'GET','admin','/sys_role','1.202.114.142','1.79ms','2021-08-09 14:25:04'),(513,'GET','admin','/sys_user','1.202.114.142','1.71ms','2021-08-09 14:25:06'),(514,'GET','admin','/sys_role','1.202.114.142','1.83ms','2021-08-09 14:25:06'),(515,'GET','admin','/sys_api','127.0.0.1','13.39ms','2021-08-09 14:32:25'),(516,'GET','admin','/sys_user','127.0.0.1','7.61ms','2021-08-09 14:32:52'),(517,'GET','admin','/sys_role','127.0.0.1','13.81ms','2021-08-09 14:32:52'),(518,'PUT','admin','/sys_user/reset_password','127.0.0.1','14.23ms','2021-08-09 14:33:00'),(519,'PUT','admin','/sys_user/reset_password','127.0.0.1','10.19ms','2021-08-09 14:33:06'),(520,'GET','admin','/sys_user','127.0.0.1','5.91ms','2021-08-09 14:33:18'),(521,'GET','admin','/sys_role','127.0.0.1','7.18ms','2021-08-09 14:33:18'),(522,'GET','admin','/sys_user','127.0.0.1','20.28ms','2021-08-09 14:33:33'),(523,'GET','admin','/sys_role','127.0.0.1','26.73ms','2021-08-09 14:33:33');
/*!40000 ALTER TABLE `sys_operation_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_role`
--

DROP TABLE IF EXISTS `sys_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_role` (
  `role_id` bigint NOT NULL AUTO_INCREMENT,
  `role_name` varchar(128) DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `role_key` varchar(128) DEFAULT NULL,
  `role_sort` bigint DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `create_by` bigint DEFAULT NULL COMMENT '创建者',
  `update_by` bigint DEFAULT NULL COMMENT '更新者',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_role`
--

LOCK TABLES `sys_role` WRITE;
/*!40000 ALTER TABLE `sys_role` DISABLE KEYS */;
INSERT INTO `sys_role` VALUES (1,'超级管理员',1,'admin',0,NULL,NULL,NULL,'2021-08-05 11:00:25',NULL),(2,'测试角色',1,'test',1,NULL,1,1,'2021-08-09 13:46:11','2021-08-09 14:25:04');
/*!40000 ALTER TABLE `sys_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_role_menu_rule`
--

DROP TABLE IF EXISTS `sys_role_menu_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_role_menu_rule` (
  `role_id` bigint NOT NULL,
  `menu_id` bigint NOT NULL,
  PRIMARY KEY (`role_id`,`menu_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `sys_role_menu_rule_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `sys_menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sys_role_menu_rule_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `sys_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_role_menu_rule`
--

LOCK TABLES `sys_role_menu_rule` WRITE;
/*!40000 ALTER TABLE `sys_role_menu_rule` DISABLE KEYS */;
INSERT INTO `sys_role_menu_rule` VALUES (2,2),(2,8),(2,9),(2,10),(2,32),(2,33);
/*!40000 ALTER TABLE `sys_role_menu_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_user`
--

DROP TABLE IF EXISTS `sys_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_user` (
  `user_id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(64) DEFAULT NULL COMMENT '用户名',
  `password` varchar(128) DEFAULT NULL COMMENT '密码',
  `phone` varchar(11) DEFAULT NULL COMMENT '手机号',
  `sex` varchar(255) DEFAULT NULL COMMENT '性别',
  `email` varchar(128) DEFAULT NULL COMMENT '邮箱',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` tinyint DEFAULT NULL COMMENT '状态',
  `create_by` bigint DEFAULT NULL COMMENT '创建者',
  `update_by` bigint DEFAULT NULL COMMENT '更新者',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_user`
--

LOCK TABLES `sys_user` WRITE;
/*!40000 ALTER TABLE `sys_user` DISABLE KEYS */;
INSERT INTO `sys_user` VALUES (1,'admin','ffefc60233bc8b0f9896799bfb21e23d','17987652378','male','961116034@qq.com',NULL,1,NULL,1,'2021-08-05 10:58:07','2021-08-09 14:33:00'),(2,'user','ffefc60233bc8b0f9896799bfb21e23d','17898767890','male','comodo@qq.com',NULL,1,1,1,'2021-08-09 13:45:13','2021-08-09 14:33:06');
/*!40000 ALTER TABLE `sys_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_user_role_rule`
--

DROP TABLE IF EXISTS `sys_user_role_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_user_role_rule` (
  `role_id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `sys_user_role_rule_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `sys_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sys_user_role_rule_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `sys_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_user_role_rule`
--

LOCK TABLES `sys_user_role_rule` WRITE;
/*!40000 ALTER TABLE `sys_user_role_rule` DISABLE KEYS */;
INSERT INTO `sys_user_role_rule` VALUES (1,1),(2,2);
/*!40000 ALTER TABLE `sys_user_role_rule` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-08-09 14:34:22
