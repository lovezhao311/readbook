/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50716
Source Host           : localhost:3306
Source Database       : book

Target Server Type    : MYSQL
Target Server Version : 50716
File Encoding         : 65001

Date: 2017-04-17 17:10:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for handle_log
-- ----------------------------
DROP TABLE IF EXISTS `handle_log`;
CREATE TABLE `handle_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '操作用户',
  `route` varchar(50) NOT NULL COMMENT '路由地址',
  `msg` varchar(255) NOT NULL COMMENT '操作说明',
  `params` text COMMENT '请求参数',
  `create_time` datetime DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL COMMENT '日志表',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='操作日志表';

-- ----------------------------
-- Records of handle_log
-- ----------------------------
INSERT INTO `handle_log` VALUES ('1', '1', 'role/add', '添加用户组[id:12]', '{\"data\":{\"name\":\"\\u5929\\u5929\\u5206\\u949f\",\"remark\":\"\\u5929\\u5929\\u5206\\u949f\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"5\":\"\",\"11\":\"1\",\"12\":\"1\",\"13\":\"1\",\"2\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"1\",\"9\":\"1\",\"10\":\"1\"}}}', '2017-04-08 13:47:41', '2017-04-08 13:47:41');
INSERT INTO `handle_log` VALUES ('2', '1', 'role/destroy', '删除用户组[id:12]', '{\"id\":\"12\"}', '2017-04-08 13:47:57', '2017-04-08 13:47:57');
INSERT INTO `handle_log` VALUES ('3', '1', 'role/destroy', '删除用户组[id:11]', '{\"id\":\"11\"}', '2017-04-08 13:48:04', '2017-04-08 13:48:04');
INSERT INTO `handle_log` VALUES ('4', '1', 'role/destroy', '删除用户组[id:10]', '{\"id\":\"10\"}', '2017-04-08 13:48:10', '2017-04-08 13:48:10');
INSERT INTO `handle_log` VALUES ('5', '1', 'role/destroy', '删除用户组[id:9]', '{\"id\":\"9\"}', '2017-04-08 13:48:45', '2017-04-08 13:48:45');
INSERT INTO `handle_log` VALUES ('6', '1', 'role/destroy', '删除用户组[id:8]', '{\"id\":\"8\"}', '2017-04-08 13:49:45', '2017-04-08 13:49:45');
INSERT INTO `handle_log` VALUES ('7', '1', 'role/destroy', '删除用户组[id:7]', '{\"id\":\"7\"}', '2017-04-08 13:49:50', '2017-04-08 13:49:50');
INSERT INTO `handle_log` VALUES ('8', '1', 'role/destroy', '删除用户组[id:6]', '{\"id\":\"6\"}', '2017-04-08 13:49:56', '2017-04-08 13:49:56');
INSERT INTO `handle_log` VALUES ('9', '1', 'role/destroy', '删除用户组[id:5]', '{\"id\":\"5\"}', '2017-04-08 13:50:04', '2017-04-08 13:50:04');
INSERT INTO `handle_log` VALUES ('10', '1', 'user/edit', '修改用户[id:2]', '{\"data\":{\"name\":\"\\u4ed3\\u4e95\\u7a7a\\u4ed3\\u4e95\\u7a7a\\u4ed3\\u4e95\\u7a7a\",\"email\":\"canglaoshi@admin.com\",\"password\":\"\",\"confirm\":\"\",\"role\":\"2\",\"manager\":\"1\",\"status\":\"1\"},\"id\":\"2\"}', '2017-04-12 16:47:39', '2017-04-12 16:47:39');
INSERT INTO `handle_log` VALUES ('11', '1', 'rule/add', '权限菜单添加[id:18]', '{\"data\":{\"parent_id\":\"8\",\"title\":\"\\u64cd\\u4f5c\\u65e5\\u5fd7\",\"name\":\"index\\/log\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"1\",\"isadmin\":\"\",\"isverify\":\"1\"}}', '2017-04-12 17:40:07', '2017-04-12 17:40:07');
INSERT INTO `handle_log` VALUES ('12', '1', 'role/edit', '用户组修改[id:4]', '{\"data\":{\"name\":\"\\u5929\\u5929\\u5206\\u949f\",\"remark\":\"\\u5929\\u5929\\u5206\\u949f\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"5\":\"\",\"11\":\"1\",\"12\":\"1\",\"13\":\"1\",\"2\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"1\",\"9\":\"1\",\"10\":\"1\",\"18\":\"1\"}},\"id\":\"4\"}', '2017-04-12 17:40:19', '2017-04-12 17:40:19');
INSERT INTO `handle_log` VALUES ('13', '1', 'role/edit', '用户组修改[id:3]', '{\"data\":{\"name\":\"\\u9ec4\\u91d1\\u65e0\\u654c\\u7ec4\",\"remark\":\"\\u8fd9\\u7fa4\\u4eba\\u6709\\u5f88\\u591a\\u9ec4\\u91d1\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"\",\"15\":\"\",\"16\":\"\",\"14\":\"\",\"17\":\"\",\"5\":\"\",\"11\":\"\",\"12\":\"\",\"13\":\"\",\"2\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"1\",\"9\":\"1\",\"10\":\"1\",\"18\":\"1\"}},\"id\":\"3\"}', '2017-04-12 17:40:28', '2017-04-12 17:40:28');
INSERT INTO `handle_log` VALUES ('14', '1', 'role/edit', '用户组修改[id:2]', '{\"data\":{\"name\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"remark\":\"\\u7ba1\\u7406\\u540e\\u53f0\\u7528\\u6237\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"5\":\"\",\"11\":\"\",\"12\":\"\",\"13\":\"\",\"2\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"1\",\"9\":\"1\",\"10\":\"1\",\"18\":\"1\"}},\"id\":\"2\"}', '2017-04-12 17:40:37', '2017-04-12 17:40:37');
INSERT INTO `handle_log` VALUES ('15', '1', 'rule/edit', '修改权限菜单[id:18]', '{\"data\":{\"parent_id\":\"8\",\"title\":\"\\u64cd\\u4f5c\\u65e5\\u5fd7\",\"name\":\"index\\/log\",\"icon\":\"\",\"sort\":\"2\",\"islink\":\"1\",\"isadmin\":\"\",\"isverify\":\"1\"},\"id\":\"18\"}', '2017-04-12 17:40:56', '2017-04-12 17:40:56');
INSERT INTO `handle_log` VALUES ('16', '1', 'rule/edit', '修改权限菜单[id:10]', '{\"data\":{\"parent_id\":\"8\",\"title\":\"\\u9000\\u51fa\",\"name\":\"index\\/logout\",\"icon\":\"\",\"sort\":\"3\",\"islink\":\"1\",\"isadmin\":\"\",\"isverify\":\"\"},\"id\":\"10\"}', '2017-04-12 17:41:09', '2017-04-12 17:41:09');
INSERT INTO `handle_log` VALUES ('17', '1', 'rule/edit', '修改权限菜单[id:18]', '{\"data\":{\"parent_id\":\"8\",\"title\":\"\\u64cd\\u4f5c\\u65e5\\u5fd7\",\"name\":\"index\\/log\",\"icon\":\"\",\"sort\":\"2\",\"islink\":\"1\",\"isadmin\":\"\",\"isverify\":\"\"},\"id\":\"18\"}', '2017-04-12 17:41:26', '2017-04-12 17:41:26');
INSERT INTO `handle_log` VALUES ('18', '1', 'index/logout', '退出登录', '[]', '2017-04-12 17:57:28', '2017-04-12 17:57:28');
INSERT INTO `handle_log` VALUES ('19', '1', 'index/login', '用户登录', '{\"data\":{\"email\":\"admin@admin.com\",\"password\":\"1234567\",\"captcha\":\"cjvd\"}}', '2017-04-12 17:57:50', '2017-04-12 17:57:50');
INSERT INTO `handle_log` VALUES ('20', '1', 'index/login', '用户登录', '{\"data\":{\"email\":\"admin@admin.com\",\"password\":\"1234567\",\"captcha\":\"ezyv\"}}', '2017-04-14 14:02:42', '2017-04-14 14:02:42');
INSERT INTO `handle_log` VALUES ('21', '1', 'user/edit', '修改用户[id:2]', '{\"data\":{\"name\":\"\\u4ed3\\u4e95\\u7a7a\\u4ed3\\u4e95\\u7a7a\\u4ed3\\u4e95\\u7a7a\",\"email\":\"canglaoshi@admin.com\",\"password\":\"\",\"confirm\":\"\",\"role\":\"2\",\"manager\":\"\",\"status\":\"1\"},\"id\":\"2\"}', '2017-04-14 14:14:06', '2017-04-14 14:14:06');
INSERT INTO `handle_log` VALUES ('22', '1', 'user/edit', '修改用户[id:2]', '{\"data\":{\"name\":\"\\u4ed3\\u4e95\\u7a7a\\u4ed3\\u4e95\\u7a7a\\u4ed3\\u4e95\\u7a7a\",\"email\":\"canglaoshi@admin.com\",\"password\":\"000000\",\"confirm\":\"000000\",\"role\":\"2\",\"manager\":\"\",\"status\":\"1\"},\"id\":\"2\"}', '2017-04-14 14:14:25', '2017-04-14 14:14:25');
INSERT INTO `handle_log` VALUES ('23', '1', 'user/edit', '修改用户[id:2]', '{\"data\":{\"name\":\"\\u4ed3\\u4e95\\u7a7a\\u4ed3\\u4e95\\u7a7a\\u4ed3\\u4e95\\u7a7a\",\"email\":\"canglaoshi@admin.com\",\"password\":\"\",\"confirm\":\"\",\"role\":\"2\",\"manager\":\"\",\"status\":\"1\"},\"id\":\"2\"}', '2017-04-14 14:14:34', '2017-04-14 14:14:34');
INSERT INTO `handle_log` VALUES ('24', '1', 'user/add', '添加用户[id:4]', '{\"data\":{\"name\":\"\\u9ec4\\u80b2\\u4f73\",\"email\":\"sb112@admin.com\",\"password\":\"123123\",\"confirm\":\"123123\",\"role\":\"3\",\"manager\":\"1\",\"status\":\"1\"}}', '2017-04-14 15:07:47', '2017-04-14 15:07:47');
INSERT INTO `handle_log` VALUES ('25', '1', 'user/edit', '修改用户[id:4]', '{\"data\":{\"name\":\"\\u9ec4\\u80b2\\u4f73\",\"email\":\"sb112@admin.com\",\"password\":\"\",\"confirm\":\"\",\"role\":\"3\",\"manager\":\"\",\"status\":\"1\"},\"id\":\"4\"}', '2017-04-14 15:08:11', '2017-04-14 15:08:11');
INSERT INTO `handle_log` VALUES ('26', '1', 'user/allot', '用户分配权限[id:4]', '{\"data\":{\"rule\":{\"3\":\"1\",\"8\":\"1\",\"9\":\"1\",\"10\":\"1\",\"18\":\"1\"}},\"id\":\"4\"}', '2017-04-14 15:10:48', '2017-04-14 15:10:48');
INSERT INTO `handle_log` VALUES ('27', '1', 'role/edit', '用户组修改[id:3]', '{\"data\":{\"name\":\"\\u9ec4\\u91d1\\u65e0\\u654c\\u7ec4\",\"remark\":\"\\u8fd9\\u7fa4\\u4eba\\u6709\\u5f88\\u591a\\u9ec4\\u91d1\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"\",\"16\":\"\",\"14\":\"\",\"17\":\"\",\"5\":\"1\",\"11\":\"\",\"12\":\"\",\"13\":\"\",\"2\":\"1\",\"6\":\"\",\"7\":\"\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}},\"id\":\"3\"}', '2017-04-14 15:21:17', '2017-04-14 15:21:17');
INSERT INTO `handle_log` VALUES ('28', '1', 'user/allot', '用户分配权限[id:3]', '{\"data\":{\"rule\":{\"3\":\"1\",\"8\":\"1\",\"9\":\"1\",\"10\":\"1\",\"18\":\"1\"}},\"id\":\"3\"}', '2017-04-14 15:21:50', '2017-04-14 15:21:50');
INSERT INTO `handle_log` VALUES ('29', '1', 'user/allot', '用户分配权限[id:4]', '{\"data\":{\"rule\":{\"3\":\"1\",\"8\":\"1\",\"9\":\"1\",\"10\":\"1\",\"18\":\"1\"}},\"id\":\"4\"}', '2017-04-14 15:22:33', '2017-04-14 15:22:33');
INSERT INTO `handle_log` VALUES ('30', '1', 'role/edit', '用户组修改[id:3]', '{\"data\":{\"name\":\"\\u9ec4\\u91d1\\u65e0\\u654c\\u7ec4\",\"remark\":\"\\u8fd9\\u7fa4\\u4eba\\u6709\\u5f88\\u591a\\u9ec4\\u91d1\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"\",\"16\":\"\",\"14\":\"\",\"17\":\"\",\"5\":\"1\",\"11\":\"\",\"12\":\"\",\"13\":\"\",\"2\":\"1\",\"6\":\"\",\"7\":\"\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}},\"id\":\"3\"}', '2017-04-14 15:22:40', '2017-04-14 15:22:40');
INSERT INTO `handle_log` VALUES ('31', '1', 'role/edit', '用户组修改[id:2]', '{\"data\":{\"name\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"remark\":\"\\u7ba1\\u7406\\u540e\\u53f0\\u7528\\u6237\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"5\":\"\",\"11\":\"\",\"12\":\"\",\"13\":\"\",\"2\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}},\"id\":\"2\"}', '2017-04-14 15:23:58', '2017-04-14 15:23:58');
INSERT INTO `handle_log` VALUES ('32', '1', 'role/add', '添加用户组[id:13]', '{\"data\":{\"name\":\"\\u5987\\u5973\\u8054\\u76df\",\"remark\":\"\\u5987\\u5973\\u8054\\u76df\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"5\":\"\",\"11\":\"1\",\"12\":\"1\",\"13\":\"1\",\"2\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}}}', '2017-04-14 15:36:27', '2017-04-14 15:36:27');
INSERT INTO `handle_log` VALUES ('33', '1', 'role/edit', '用户组修改[id:13]', '{\"data\":{\"name\":\"\\u5987\\u5973\\u8054\\u76df\",\"remark\":\"\\u5987\\u5973\\u8054\\u76df\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"5\":\"\",\"11\":\"1\",\"12\":\"1\",\"13\":\"1\",\"2\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}},\"id\":\"13\"}', '2017-04-14 15:41:48', '2017-04-14 15:41:48');
INSERT INTO `handle_log` VALUES ('34', '1', 'role/edit', '用户组修改[id:2]', '{\"data\":{\"name\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"remark\":\"\\u7ba1\\u7406\\u540e\\u53f0\\u7528\\u6237\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"\",\"5\":\"1\",\"11\":\"1\",\"12\":\"\",\"13\":\"\",\"2\":\"1\",\"6\":\"1\",\"7\":\"\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}},\"id\":\"2\"}', '2017-04-14 15:51:01', '2017-04-14 15:51:01');
INSERT INTO `handle_log` VALUES ('35', '1', 'index/logout', '退出登录', '[]', '2017-04-14 17:41:12', '2017-04-14 17:41:12');
INSERT INTO `handle_log` VALUES ('36', '1', 'index/login', '用户登录', '{\"data\":{\"email\":\"admin@admin.com\",\"password\":\"1234567\",\"captcha\":\"ns67\"}}', '2017-04-14 17:46:33', '2017-04-14 17:46:33');
INSERT INTO `handle_log` VALUES ('37', '1', 'index/logout', '退出登录', '[]', '2017-04-14 17:46:39', '2017-04-14 17:46:39');
INSERT INTO `handle_log` VALUES ('38', '1', 'index/login', '用户登录', '{\"data\":{\"email\":\"admin@admin.com\",\"password\":\"1234567\",\"captcha\":\"ax7c\"}}', '2017-04-14 17:47:06', '2017-04-14 17:47:06');
INSERT INTO `handle_log` VALUES ('39', '1', 'index/login', '用户登录', '{\"data\":{\"email\":\"admin@admin.com\",\"password\":\"1234567\",\"captcha\":\"ece5\"}}', '2017-04-14 17:48:07', '2017-04-14 17:48:07');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '部门名称',
  `remark` varchar(255) DEFAULT '' COMMENT '简单说明',
  `create_time` datetime NOT NULL,
  `modify_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='部门表';

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('2', '用户管理', '管理后台用户', '2017-04-05 14:04:38', '2017-04-14 15:51:01');
INSERT INTO `role` VALUES ('3', '黄金无敌组', '这群人有很多黄金', '2017-04-05 16:39:50', '2017-04-14 15:22:40');
INSERT INTO `role` VALUES ('4', '天天分钟', '天天分钟', '2017-04-08 12:28:23', '2017-04-12 17:40:18');
INSERT INTO `role` VALUES ('13', '妇女联盟', '妇女联盟', '2017-04-14 15:36:27', '2017-04-14 15:41:48');

-- ----------------------------
-- Table structure for role_rule
-- ----------------------------
DROP TABLE IF EXISTS `role_rule`;
CREATE TABLE `role_rule` (
  `role_id` int(11) NOT NULL,
  `rule_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部门权限菜单表';

-- ----------------------------
-- Records of role_rule
-- ----------------------------
INSERT INTO `role_rule` VALUES ('2', '1');
INSERT INTO `role_rule` VALUES ('2', '2');
INSERT INTO `role_rule` VALUES ('2', '3');
INSERT INTO `role_rule` VALUES ('2', '4');
INSERT INTO `role_rule` VALUES ('2', '5');
INSERT INTO `role_rule` VALUES ('2', '6');
INSERT INTO `role_rule` VALUES ('2', '8');
INSERT INTO `role_rule` VALUES ('2', '9');
INSERT INTO `role_rule` VALUES ('2', '10');
INSERT INTO `role_rule` VALUES ('2', '11');
INSERT INTO `role_rule` VALUES ('2', '14');
INSERT INTO `role_rule` VALUES ('2', '15');
INSERT INTO `role_rule` VALUES ('2', '16');
INSERT INTO `role_rule` VALUES ('2', '18');
INSERT INTO `role_rule` VALUES ('3', '1');
INSERT INTO `role_rule` VALUES ('3', '2');
INSERT INTO `role_rule` VALUES ('3', '3');
INSERT INTO `role_rule` VALUES ('3', '4');
INSERT INTO `role_rule` VALUES ('3', '5');
INSERT INTO `role_rule` VALUES ('3', '8');
INSERT INTO `role_rule` VALUES ('3', '9');
INSERT INTO `role_rule` VALUES ('3', '10');
INSERT INTO `role_rule` VALUES ('3', '18');
INSERT INTO `role_rule` VALUES ('4', '1');
INSERT INTO `role_rule` VALUES ('4', '3');
INSERT INTO `role_rule` VALUES ('4', '4');
INSERT INTO `role_rule` VALUES ('4', '8');
INSERT INTO `role_rule` VALUES ('4', '9');
INSERT INTO `role_rule` VALUES ('4', '10');
INSERT INTO `role_rule` VALUES ('4', '11');
INSERT INTO `role_rule` VALUES ('4', '12');
INSERT INTO `role_rule` VALUES ('4', '13');
INSERT INTO `role_rule` VALUES ('4', '14');
INSERT INTO `role_rule` VALUES ('4', '15');
INSERT INTO `role_rule` VALUES ('4', '16');
INSERT INTO `role_rule` VALUES ('4', '17');
INSERT INTO `role_rule` VALUES ('4', '18');
INSERT INTO `role_rule` VALUES ('13', '1');
INSERT INTO `role_rule` VALUES ('13', '3');
INSERT INTO `role_rule` VALUES ('13', '4');
INSERT INTO `role_rule` VALUES ('13', '8');
INSERT INTO `role_rule` VALUES ('13', '9');
INSERT INTO `role_rule` VALUES ('13', '10');
INSERT INTO `role_rule` VALUES ('13', '11');
INSERT INTO `role_rule` VALUES ('13', '12');
INSERT INTO `role_rule` VALUES ('13', '13');
INSERT INTO `role_rule` VALUES ('13', '14');
INSERT INTO `role_rule` VALUES ('13', '15');
INSERT INTO `role_rule` VALUES ('13', '16');
INSERT INTO `role_rule` VALUES ('13', '17');
INSERT INTO `role_rule` VALUES ('13', '18');

-- ----------------------------
-- Table structure for rule
-- ----------------------------
DROP TABLE IF EXISTS `rule`;
CREATE TABLE `rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父菜单',
  `name` varchar(100) NOT NULL COMMENT 'url地址 c+a',
  `title` varchar(100) NOT NULL COMMENT '菜单名称',
  `islink` tinyint(5) NOT NULL DEFAULT '0' COMMENT '是否菜单',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否管理员才有的权限 0 不是 1 是',
  `icon` varchar(100) DEFAULT NULL COMMENT '图标',
  `sort` int(3) NOT NULL DEFAULT '255' COMMENT '排序',
  `isverify` tinyint(1) NOT NULL DEFAULT '1' COMMENT '需要验证: 0 不需要 1需要',
  `level` tinyint(2) DEFAULT NULL COMMENT '级别',
  `create_time` datetime NOT NULL,
  `modify_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rulename` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='权限&菜单表';

-- ----------------------------
-- Records of rule
-- ----------------------------
INSERT INTO `rule` VALUES ('1', '0', 'user', '用户管理', '1', '1', null, '6', '0', '1', '2017-03-31 16:04:04', '2017-03-31 16:04:06');
INSERT INTO `rule` VALUES ('2', '1', 'rule/index', '菜单权限', '1', '1', '', '3', '1', '2', '2017-04-01 15:35:35', '2017-04-01 15:35:35');
INSERT INTO `rule` VALUES ('3', '0', 'index/main', '首页面板', '1', '0', '', '1', '0', '1', '2017-04-01 15:48:18', '2017-04-01 17:41:22');
INSERT INTO `rule` VALUES ('4', '1', 'user/index', '用户列表', '1', '1', '', '1', '0', '2', '2017-04-01 15:59:42', '2017-04-01 15:59:42');
INSERT INTO `rule` VALUES ('5', '1', 'role/index', '用户分组', '1', '1', '', '2', '1', '2', '2017-04-01 16:03:43', '2017-04-01 16:03:43');
INSERT INTO `rule` VALUES ('6', '2', 'rule/add', '菜单添加', '0', '1', '', '1', '1', '3', '2017-04-01 16:31:52', '2017-04-01 17:04:11');
INSERT INTO `rule` VALUES ('7', '2', 'rule/edit', '修改菜单', '0', '1', '', '2', '1', '3', '2017-04-01 16:42:20', '2017-04-01 17:06:00');
INSERT INTO `rule` VALUES ('8', '0', 'personal', '个人中心', '1', '0', '', '7', '0', '1', '2017-04-01 17:07:00', '2017-04-01 17:41:39');
INSERT INTO `rule` VALUES ('9', '8', 'index/personal', '个人中心', '1', '0', '', '1', '0', '2', '2017-04-01 17:35:30', '2017-04-08 10:05:03');
INSERT INTO `rule` VALUES ('10', '8', 'index/logout', '退出', '1', '0', '', '3', '0', '2', '2017-04-01 17:36:31', '2017-04-12 17:41:09');
INSERT INTO `rule` VALUES ('11', '5', 'role/add', '添加分组', '0', '1', '', '1', '0', '3', '2017-04-06 09:59:33', '2017-04-06 10:54:05');
INSERT INTO `rule` VALUES ('12', '5', 'role/edit', '修改分组', '0', '1', '', '2', '0', '3', '2017-04-06 10:53:43', '2017-04-06 10:53:56');
INSERT INTO `rule` VALUES ('13', '5', 'role/destroy', '删除分组', '0', '1', '', '3', '0', '3', '2017-04-06 10:54:41', '2017-04-06 10:54:41');
INSERT INTO `rule` VALUES ('14', '4', 'user/allot', '分配用户权限', '0', '1', '', '5', '0', '3', '2017-04-08 09:49:49', '2017-04-08 09:49:49');
INSERT INTO `rule` VALUES ('15', '4', 'user/add', '添加用户', '0', '1', '', '2', '0', '3', '2017-04-08 09:51:40', '2017-04-08 09:51:40');
INSERT INTO `rule` VALUES ('16', '4', 'user/edit', '修改用户', '0', '1', '', '3', '0', '3', '2017-04-08 09:52:04', '2017-04-08 09:52:31');
INSERT INTO `rule` VALUES ('17', '4', 'user/status', '禁用用户', '0', '1', '', '5', '0', '3', '2017-04-08 09:55:44', '2017-04-08 09:55:44');
INSERT INTO `rule` VALUES ('18', '8', 'index/log', '操作日志', '1', '0', '', '2', '0', '2', '2017-04-12 17:40:07', '2017-04-12 17:41:26');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL COMMENT '登录邮箱',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `role` int(10) NOT NULL DEFAULT '0' COMMENT '角色 ：0为超级管理员，只能有一个超级管理员，并且超级管理员不可禁用',
  `manager` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否部门管理者 0 否 1是',
  `name` varchar(255) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(100) DEFAULT NULL COMMENT '电话',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态 1 开启 0 关闭',
  `last_ip` varchar(255) DEFAULT NULL,
  `last_time` datetime DEFAULT NULL COMMENT '最后一次登录时间',
  `create_time` datetime DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin@admin.com', 'fcea920f7412b5da7be0cf42b8c93759', '0', '0', '超管', '18526232020', '1', '127.0.0.1', '2017-04-14 17:48:07', '2017-03-22 10:35:17', '2017-04-14 17:48:07');
INSERT INTO `user` VALUES ('2', 'canglaoshi@admin.com', '670b14728ad9902aecba32e22fa4f6bd', '2', '0', '仓井空仓井空仓井空', null, '1', null, null, '2017-04-06 12:03:12', '2017-04-14 14:14:34');
INSERT INTO `user` VALUES ('3', 'xixi@admin.com', 'e10adc3949ba59abbe56e057f20f883e', '2', '0', '纱纱相', null, '1', null, null, '2017-04-06 17:20:17', '2017-04-06 17:30:52');
INSERT INTO `user` VALUES ('4', 'sb112@admin.com', '4297f44b13955235245b2497399d7a93', '3', '0', '黄育佳', null, '1', null, null, '2017-04-14 15:07:47', '2017-04-14 15:08:11');

-- ----------------------------
-- Table structure for user_rule
-- ----------------------------
DROP TABLE IF EXISTS `user_rule`;
CREATE TABLE `user_rule` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `rule_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户权限菜单表';

-- ----------------------------
-- Records of user_rule
-- ----------------------------
INSERT INTO `user_rule` VALUES ('3', '2', '3');
INSERT INTO `user_rule` VALUES ('3', '2', '8');
INSERT INTO `user_rule` VALUES ('3', '2', '9');
INSERT INTO `user_rule` VALUES ('3', '2', '10');
INSERT INTO `user_rule` VALUES ('3', '2', '18');
INSERT INTO `user_rule` VALUES ('4', '3', '3');
INSERT INTO `user_rule` VALUES ('4', '3', '8');
INSERT INTO `user_rule` VALUES ('4', '3', '9');
INSERT INTO `user_rule` VALUES ('4', '3', '10');
INSERT INTO `user_rule` VALUES ('4', '3', '18');
