-- MySQL dump 10.13  Distrib 8.0.44, for Linux (aarch64)
--
-- Host: localhost    Database: comodo_admin_open
-- ------------------------------------------------------
-- Server version	8.0.44-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `comodo_admin_open`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `comodo_admin_open` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `comodo_admin_open`;

--
-- Table structure for table `sys_api`
--

DROP TABLE IF EXISTS `sys_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_api` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '请求名称',
  `path` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '请求路径',
  `type` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '请求类型',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  `create_by` int unsigned DEFAULT NULL COMMENT '创建者',
  `update_by` int unsigned DEFAULT NULL COMMENT '更新者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_api`
--

LOCK TABLES `sys_api` WRITE;
/*!40000 ALTER TABLE `sys_api` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sys_api` VALUES (1,'获取菜单列表','/sys_menu/get_menu_list','GET','2021-08-09 13:21:17',NULL,1,NULL),(2,'获取菜单列表树','/sys_menu/get_menu_tree','GET','2021-08-09 13:21:51',NULL,1,NULL),(3,'添加菜单','/sys_menu','POST','2021-08-09 13:22:08',NULL,1,NULL),(4,'更新菜单','/sys_menu','PUT','2021-08-09 13:22:30',NULL,1,NULL),(5,'删除菜单','/sys_menu','DELETE','2021-08-09 13:22:48',NULL,1,NULL),(6,'分页接口列表','/sys_api/page','GET','2021-08-09 13:26:01','2026-01-17 20:24:40',1,12),(7,'添加接口','/sys_api','POST','2021-08-09 13:26:16',NULL,1,NULL),(8,'更新接口','/sys_api','PUT','2021-08-09 13:26:42',NULL,1,NULL),(9,'删除接口','/sys_api','DELETE','2021-08-09 13:26:53',NULL,1,NULL),(10,'分页角色列表','/sys_role/page','GET','2021-08-09 13:27:21','2026-01-17 20:20:29',1,12),(11,'添加角色','/sys_role','POST','2021-08-09 13:28:18',NULL,1,NULL),(12,'更新角色信息','/sys_role','PUT','2021-08-09 13:28:49','2026-01-17 20:20:00',1,12),(14,'删除角色','/sys_role','DELETE','2021-08-09 13:30:48',NULL,1,NULL),(15,'获取用户列表','/sys_user','GET','2021-08-09 13:31:12',NULL,1,NULL),(16,'添加新用户','/sys_user','POST','2021-08-09 13:31:26',NULL,1,NULL),(17,'删除用户','/sys_user','DELETE','2021-08-09 13:31:40',NULL,1,NULL),(18,'修改用户信息','/sys_user/update_user','PUT','2021-08-09 13:32:01',NULL,1,NULL),(20,'重置用户密码','/sys_user/reset_password','PUT','2021-08-09 13:32:41',NULL,1,NULL),(21,'获取字典类型列表','/dict_type','GET','2021-08-09 13:33:16',NULL,1,NULL),(22,'添加字典类型','/dict_type','POST','2021-08-09 13:33:28',NULL,1,NULL),(23,'修改字典类型','/dict_type','PUT','2021-08-09 13:33:44',NULL,1,NULL),(24,'删除字典类型','/dict_type','DELETE','2021-08-09 13:33:56',NULL,1,NULL),(25,'获取字典数据列表','/dict_data/get_list','GET','2021-08-09 13:34:16',NULL,1,NULL),(26,'添加字典数据','/dict_data','POST','2021-08-09 13:35:11',NULL,1,NULL),(27,'修改字典数据','/dict_data','PUT','2021-08-09 13:35:30',NULL,1,NULL),(28,'删除字典数据','/dict_data','DELETE','2021-08-09 13:35:42',NULL,1,NULL),(29,'查询登录日志列表','/sys_log/get_login_log','GET','2021-08-09 13:36:09',NULL,1,NULL),(30,'删除登录日志','/sys_log/delete_login_log','DELETE','2021-08-09 13:36:38',NULL,1,NULL),(31,'查询操作日志列表','/sys_log/get_operation_log','GET','2021-08-09 13:36:57',NULL,1,NULL),(32,'删除操作日志','/sys_log/delete_operation_log','DELETE','2021-08-09 13:37:15','2025-05-26 23:57:53',1,12),(49,'获取所有接口列表','/sys_api/list','GET','2026-01-17 20:18:26',NULL,12,NULL),(50,'获取所有角色列表','/sys_role/list','GET','2026-01-17 20:21:18',NULL,12,NULL);
/*!40000 ALTER TABLE `sys_api` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sys_dict_data`
--

DROP TABLE IF EXISTS `sys_dict_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_dict_data` (
  `dict_data_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `dict_data_sort` int unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dict_data_label` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '字典数据标签',
  `dict_data_value` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '字典数据值',
  `dict_id` int unsigned NOT NULL COMMENT '所属字典类型 id',
  `status` tinyint DEFAULT '1' COMMENT '状态，0：禁用；1：启用',
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '备注',
  `create_by` int unsigned DEFAULT NULL COMMENT '创建者',
  `update_by` int unsigned DEFAULT NULL COMMENT '更新者',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`dict_data_id`),
  KEY `dict_id` (`dict_id`),
  CONSTRAINT `sys_dict_data_ibfk_1` FOREIGN KEY (`dict_id`) REFERENCES `sys_dict_type` (`dict_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_dict_data`
--

LOCK TABLES `sys_dict_data` WRITE;
/*!40000 ALTER TABLE `sys_dict_data` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sys_dict_data` VALUES (1,0,'正常','1',1,1,'',1,1,'2021-08-05 11:44:32','2023-12-29 22:10:03'),(2,1,'停用','0',1,1,NULL,1,NULL,'2021-08-05 11:44:43',NULL),(3,0,'男','male',2,1,NULL,1,NULL,'2021-08-05 11:45:41',NULL),(4,1,'女','female',2,1,NULL,1,12,'2021-08-05 11:45:50','2026-01-20 15:34:34'),(5,0,'显示','1',3,1,NULL,1,12,'2021-08-05 11:46:30','2024-01-28 10:18:03'),(6,1,'隐藏','0',3,1,NULL,1,NULL,'2021-08-05 11:46:39',NULL),(12,0,'GET','GET',11,1,NULL,12,NULL,'2025-05-26 21:56:58',NULL),(13,1,'POST','POST',11,1,NULL,12,NULL,'2025-05-26 21:57:06',NULL),(14,2,'PUT','PUT',11,1,NULL,12,NULL,'2025-05-26 21:57:16',NULL),(15,3,'DELETE','DELETE',11,1,NULL,12,NULL,'2025-05-26 21:57:27',NULL);
/*!40000 ALTER TABLE `sys_dict_data` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sys_dict_type`
--

DROP TABLE IF EXISTS `sys_dict_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_dict_type` (
  `dict_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `dict_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '字典类型名称',
  `dict_type` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '字典类型',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '状态，0：禁用；1：启用',
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '备注',
  `create_by` int unsigned DEFAULT NULL COMMENT '创建者',
  `update_by` int unsigned DEFAULT NULL COMMENT '更新者',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`dict_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_dict_type`
--

LOCK TABLES `sys_dict_type` WRITE;
/*!40000 ALTER TABLE `sys_dict_type` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sys_dict_type` VALUES (1,'系统开关','sys_normal_disable',1,'',1,1,'2021-08-05 11:39:05','2023-12-29 22:06:36'),(2,'用户性别','sys_user_sex',1,NULL,1,NULL,'2021-08-05 11:45:23',NULL),(3,'菜单状态','sys_show_hide',1,NULL,1,12,'2021-08-05 11:46:19','2024-01-28 10:11:10'),(11,'接口请求类型','sys_api_type',1,NULL,12,NULL,'2025-05-26 21:56:27',NULL);
/*!40000 ALTER TABLE `sys_dict_type` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sys_login_log`
--

DROP TABLE IF EXISTS `sys_login_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_login_log` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '用户名',
  `ipaddr` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'ip地址',
  `location` varchar(255) DEFAULT NULL COMMENT '归属地',
  `browser` varchar(255) DEFAULT NULL COMMENT '浏览器',
  `os` varchar(255) DEFAULT NULL COMMENT '系统',
  `login_time` datetime NOT NULL COMMENT '登录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=473 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_login_log`
--

LOCK TABLES `sys_login_log` WRITE;
/*!40000 ALTER TABLE `sys_login_log` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `sys_login_log` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sys_menu`
--

DROP TABLE IF EXISTS `sys_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_menu` (
  `menu_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `route_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '路由名称（唯一）',
  `title` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '菜单名称',
  `icon` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '图标',
  `path` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '路由地址（唯一）',
  `menu_type` varchar(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '菜单类型，F：页面夹；P：页面；B：按钮',
  `permission` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '权限标识（唯一）',
  `parent_id` int unsigned NOT NULL DEFAULT '0' COMMENT '父菜单ID',
  `component` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '组件路径',
  `sort` bigint NOT NULL DEFAULT '0' COMMENT '排序',
  `visible` tinyint DEFAULT '1' COMMENT '是否显示，0：隐藏；1：显示',
  `is_link` tinyint DEFAULT NULL COMMENT '是否外链，0：否；1：是',
  `layout` tinyint DEFAULT NULL COMMENT '是否显示布局，0：否；1：是',
  `cache` tinyint DEFAULT NULL COMMENT '是否缓存，0：否；1：是',
  `create_by` int unsigned DEFAULT NULL COMMENT '创建者',
  `update_by` int unsigned DEFAULT NULL COMMENT '更新者',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  `active_menu` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '高亮菜单路由地址',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_menu`
--

LOCK TABLES `sys_menu` WRITE;
/*!40000 ALTER TABLE `sys_menu` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sys_menu` VALUES (1,'SysMenu','菜单管理',NULL,'/admin/sys-menu','P','admin:sysmenu',2,'/admin/sys-menu/index.vue',2,1,0,1,0,NULL,12,'2021-08-05 11:05:32','2026-01-17 20:31:31',NULL),(2,NULL,'系统管理','setting',NULL,'F','admin',0,NULL,199,1,NULL,NULL,NULL,1,12,'2021-08-05 11:36:08','2026-01-19 11:46:21',NULL),(3,'SysDict','字典管理',NULL,'/admin/sys-dict','P','admin:sysdict',2,'/admin/sys-dict/index.vue',4,1,0,1,0,1,1,'2021-08-05 11:37:34','2024-01-13 20:13:26',NULL),(4,'SysDictData','字典数据管理',NULL,'/admin/sys-dict/data/:dictId','P','admin:sysdictdata',3,'/admin/sys-dict/data.vue',0,0,0,1,0,1,12,'2021-08-05 11:40:54','2025-05-19 00:14:16','/admin/sys-dict'),(5,'SysUser','用户管理',NULL,'/admin/sys-user','P','admin:sysuser',2,'/admin/sys-user/index.vue',0,1,0,1,0,1,12,'2021-08-05 11:48:47','2026-01-20 15:28:52',NULL),(6,'SysRole','角色管理',NULL,'/admin/sys-role','P','admin:sysrole',2,'/admin/sys-role/index.vue',1,1,0,1,0,1,12,'2021-08-05 11:49:40','2026-01-20 14:42:29',NULL),(7,'SysApi','接口管理',NULL,'/admin/sys-api','P','admin:sysapi',2,'/admin/sys-api/index.vue',3,1,0,1,0,1,1,'2021-08-05 11:51:29','2024-01-07 22:50:11',NULL),(8,NULL,'系统日志',NULL,NULL,'F',NULL,2,NULL,5,1,NULL,NULL,NULL,1,12,'2021-08-05 11:52:24','2026-01-19 11:46:45',NULL),(9,'SysLoginLog','登录日志',NULL,'/admin/sys-login-log','P','admin:sysloginlog',8,'/admin/sys-login-log/index.vue',0,1,0,1,0,1,12,'2021-08-05 11:53:18','2026-01-19 16:17:39',NULL),(10,'SysOperationLog','操作日志',NULL,'/admin/sys-operation-log','P','admin:sysoperationlog',8,'/admin/sys-operation-log/index.vue',1,1,0,1,0,1,1,'2021-08-05 11:54:06','2024-01-07 22:52:39',NULL),(11,NULL,'新增用户',NULL,NULL,'B','admin:sysuser:add',5,NULL,1,NULL,NULL,NULL,NULL,1,1,'2021-08-09 13:40:48','2024-01-07 22:53:19',NULL),(12,NULL,'修改用户',NULL,NULL,'B','admin:sysuser:edit',5,NULL,2,NULL,NULL,NULL,NULL,1,1,'2021-08-09 13:41:28','2024-01-07 22:53:22',NULL),(13,NULL,'删除用户',NULL,NULL,'B','admin:sysuser:remove',5,NULL,3,NULL,NULL,NULL,NULL,1,1,'2021-08-09 13:42:02','2024-01-07 22:53:24',NULL),(14,NULL,'重置密码',NULL,NULL,'B','admin:sysuser:resetpassword',5,NULL,4,NULL,NULL,NULL,NULL,1,1,'2021-08-09 13:42:40','2024-01-07 22:53:27',NULL),(15,NULL,'修改状态',NULL,NULL,'B','admin:sysuser:status',5,NULL,5,NULL,NULL,NULL,NULL,1,12,'2021-08-09 13:43:46','2024-01-28 23:32:56',NULL),(16,NULL,'新增角色',NULL,NULL,'B','admin:sysrole:add',6,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:01:28','2024-01-07 22:53:31',NULL),(17,NULL,'修改角色',NULL,NULL,'B','admin:sysrole:update',6,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:02:28','2024-01-07 22:53:33',NULL),(18,NULL,'删除角色',NULL,NULL,'B','admin:sysrole:remove',6,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:03:09','2024-01-07 22:53:35',NULL),(19,NULL,'修改状态',NULL,NULL,'B','admin:sysrole:status',6,NULL,0,NULL,NULL,NULL,NULL,1,12,'2021-08-09 14:03:58','2024-01-29 23:10:23',NULL),(20,NULL,'新增菜单',NULL,NULL,'B','admin:sysmenu:add',1,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:09:36','2024-01-07 22:53:41',NULL),(21,NULL,'修改菜单',NULL,NULL,'B','admin:sysmenu:edit',1,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:10:18','2024-01-07 22:53:44',NULL),(22,NULL,'删除菜单',NULL,NULL,'B','admin:sysmenu:remove',1,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:10:42','2024-01-07 22:53:46',NULL),(23,NULL,'新增接口',NULL,NULL,'B','admin:sysapi:add',7,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:13:30','2024-01-07 22:53:49',NULL),(24,NULL,'修改接口',NULL,NULL,'B','admin:sysapi:edit',7,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:13:56','2024-01-07 22:53:51',NULL),(25,NULL,'删除接口',NULL,NULL,'B','admin:sysapi:remove',7,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:14:27','2024-01-07 22:53:52',NULL),(26,NULL,'添加字典类型',NULL,NULL,'B','admin:sysdicttype:add',3,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:17:05','2024-01-07 22:53:56',NULL),(27,NULL,'修改字典类型',NULL,NULL,'B','admin:sysdicttype:edit',3,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:17:32','2024-01-07 22:53:58',NULL),(28,NULL,'删除字典类型',NULL,NULL,'B','admin:sysdicttype:remove',3,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:18:30','2024-01-07 22:54:00',NULL),(29,NULL,'添加字典数据',NULL,NULL,'B','admin:sysdictdata:add',4,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:19:51','2024-01-07 22:54:01',NULL),(30,NULL,'修改字典数据',NULL,NULL,'B','admin:sysdictdata:edit',4,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:20:15','2024-01-07 22:54:03',NULL),(31,NULL,'删除字典数据',NULL,NULL,'B','admin:sysdictdata:remove',4,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:20:37','2024-01-07 22:54:06',NULL),(32,NULL,'删除登录日志',NULL,NULL,'B','admin:sysloginlog:remove',9,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:22:13','2024-01-07 22:54:07',NULL),(33,NULL,'删除操作日志',NULL,NULL,'B','admin:sysoperationlog:remove',10,NULL,0,NULL,NULL,NULL,NULL,1,1,'2021-08-09 14:22:38','2024-01-07 22:54:10',NULL),(158,NULL,'autopage',NULL,'/a15','P',NULL,115,'/a',1,1,0,1,0,12,NULL,'2026-01-16 10:21:57',NULL,NULL);
/*!40000 ALTER TABLE `sys_menu` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sys_menu_api_rule`
--

DROP TABLE IF EXISTS `sys_menu_api_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_menu_api_rule` (
  `sys_menu_id` int unsigned NOT NULL,
  `sys_api_id` int unsigned NOT NULL,
  PRIMARY KEY (`sys_menu_id`,`sys_api_id`),
  KEY `sys_api_id` (`sys_api_id`),
  CONSTRAINT `sys_menu_api_rule_ibfk_1` FOREIGN KEY (`sys_menu_id`) REFERENCES `sys_menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sys_menu_api_rule_ibfk_2` FOREIGN KEY (`sys_api_id`) REFERENCES `sys_api` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_menu_api_rule`
--

LOCK TABLES `sys_menu_api_rule` WRITE;
/*!40000 ALTER TABLE `sys_menu_api_rule` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sys_menu_api_rule` VALUES (1,1),(1,2),(6,2),(20,3),(21,4),(22,5),(7,6),(23,7),(24,8),(25,9),(6,10),(16,11),(17,12),(19,12),(18,14),(5,15),(11,16),(13,17),(12,18),(15,18),(14,20),(3,21),(26,22),(27,23),(28,24),(4,25),(29,26),(30,27),(31,28),(9,29),(32,30),(10,31),(33,32),(1,49),(5,50);
/*!40000 ALTER TABLE `sys_menu_api_rule` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sys_operation_log`
--

DROP TABLE IF EXISTS `sys_operation_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_operation_log` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '请求类型',
  `operator` varchar(128) DEFAULT NULL COMMENT '操作人员',
  `path` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '访问地址',
  `ipaddr` varchar(128) DEFAULT NULL COMMENT '客户端ip',
  `latency_time` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '耗时',
  `operation_time` datetime DEFAULT NULL COMMENT '操作时间',
  `operation` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '操作',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13074 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_operation_log`
--

LOCK TABLES `sys_operation_log` WRITE;
/*!40000 ALTER TABLE `sys_operation_log` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `sys_operation_log` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sys_role`
--

DROP TABLE IF EXISTS `sys_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_role` (
  `role_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `role_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '角色名称',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '状态',
  `role_key` varchar(128) NOT NULL COMMENT '角色标识',
  `role_sort` int unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '备注',
  `create_by` int unsigned DEFAULT NULL COMMENT '创建者',
  `update_by` int unsigned DEFAULT NULL COMMENT '更新者',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  `check_strictly` tinyint NOT NULL COMMENT '菜单父子是否关联',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_role`
--

LOCK TABLES `sys_role` WRITE;
/*!40000 ALTER TABLE `sys_role` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sys_role` VALUES (1,'超级管理员',1,'admin',0,'1',NULL,12,'2021-08-05 11:00:25','2026-01-15 18:21:09',1),(7,'测试角色',1,'test',1,NULL,12,12,'2024-01-23 22:08:03','2026-01-19 20:12:28',0);
/*!40000 ALTER TABLE `sys_role` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sys_role_menu_rule`
--

DROP TABLE IF EXISTS `sys_role_menu_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_role_menu_rule` (
  `role_id` int unsigned NOT NULL,
  `menu_id` int unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`menu_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `sys_role_menu_rule_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `sys_menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sys_role_menu_rule_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `sys_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_role_menu_rule`
--

LOCK TABLES `sys_role_menu_rule` WRITE;
/*!40000 ALTER TABLE `sys_role_menu_rule` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sys_role_menu_rule` VALUES (7,2),(7,3),(7,4),(7,5),(7,6),(7,8),(7,9),(7,10),(7,11),(7,13),(7,14),(7,16),(7,17),(7,18),(7,19),(7,26),(7,27),(7,28),(7,29),(7,30),(7,31),(7,33);
/*!40000 ALTER TABLE `sys_role_menu_rule` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sys_user`
--

DROP TABLE IF EXISTS `sys_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_user` (
  `user_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '密码',
  `phone` varchar(11) DEFAULT NULL COMMENT '手机号',
  `sex` varchar(255) DEFAULT NULL COMMENT '性别，male: 男；female：女',
  `email` varchar(128) DEFAULT NULL COMMENT '邮箱',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '状态',
  `create_by` int unsigned DEFAULT NULL COMMENT '创建者',
  `update_by` int unsigned DEFAULT NULL COMMENT '更新者',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  `nickname` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_user`
--

LOCK TABLES `sys_user` WRITE;
/*!40000 ALTER TABLE `sys_user` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sys_user` VALUES (12,'admin','$2y$10$iX7fkwyqL6NsiSmWSx24OuIapmm32e80jCbR7.KcsTtaiMtyniJ0e','17625664231','male','aaa@a.com','备注',1,NULL,12,'2024-01-21 22:36:02','2026-01-22 09:36:27','超级管理员'),(13,'user','$2y$10$vs/UnvZyeIC67P4/BnydAudxgva/OIETjRSj8nol8u/zrAyhmlx0y','19099999999',NULL,NULL,NULL,1,12,12,'2024-01-23 21:53:31','2026-01-22 09:36:12','测试用户');
/*!40000 ALTER TABLE `sys_user` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sys_user_role_rule`
--

DROP TABLE IF EXISTS `sys_user_role_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_user_role_rule` (
  `role_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `sys_user_role_rule_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `sys_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sys_user_role_rule_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `sys_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_user_role_rule`
--

LOCK TABLES `sys_user_role_rule` WRITE;
/*!40000 ALTER TABLE `sys_user_role_rule` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sys_user_role_rule` VALUES (1,12),(7,13);
/*!40000 ALTER TABLE `sys_user_role_rule` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping events for database 'comodo_admin_open'
--

--
-- Dumping routines for database 'comodo_admin_open'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-22  9:55:10
