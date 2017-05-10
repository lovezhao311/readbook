/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50716
Source Host           : localhost:3306
Source Database       : book

Target Server Type    : MYSQL
Target Server Version : 50716
File Encoding         : 65001

Date: 2017-05-10 18:02:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for author
-- ----------------------------
DROP TABLE IF EXISTS `author`;
CREATE TABLE `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '作者姓名',
  `remark` varchar(255) NOT NULL COMMENT '简单',
  `create_time` datetime DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `author_name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='作者';

-- ----------------------------
-- Records of author
-- ----------------------------
INSERT INTO `author` VALUES ('4', '唐三少爷', '唐三少爷', '2017-05-10 12:08:46', '2017-05-10 12:08:46');

-- ----------------------------
-- Table structure for book
-- ----------------------------
DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '书籍名称',
  `alias` varchar(100) NOT NULL COMMENT '别名',
  `last_chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '最新更新章节',
  `end_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：1 连载; 2 完结',
  `image` varchar(255) DEFAULT NULL COMMENT '封面图片',
  `isbn` varchar(20) DEFAULT NULL COMMENT 'isbn书号',
  `author_id` int(11) DEFAULT NULL COMMENT '书籍作者',
  `source_id` int(11) DEFAULT NULL COMMENT '书籍来源',
  `remark` varchar(255) DEFAULT NULL COMMENT '说明',
  `gather` text COMMENT '采集配置',
  `create_time` datetime DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `book_name` (`name`),
  KEY `book_author_id` (`author_id`),
  KEY `book_source_id` (`source_id`),
  CONSTRAINT `book_author_id` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE SET NULL,
  CONSTRAINT `book_source_id` FOREIGN KEY (`source_id`) REFERENCES `source` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='书籍表';

-- ----------------------------
-- Records of book
-- ----------------------------
INSERT INTO `book` VALUES ('18', '三民主同', '同志', '0', '1', '/uploads/20170510\\497b182087e1c3206bc7f000cd430497.jpg', 'sdfsd342342', '4', '2', 'sdfasdfasdf', '{\"2\":{\"gather_id\":\"2\",\"list_url\":\"2312312\",\"sort\":\"\"},\"3\":{\"gather_id\":\"3\",\"list_url\":\"2312313\",\"sort\":\"\"}}', '2017-05-10 16:37:00', '2017-05-10 17:10:51');

-- ----------------------------
-- Table structure for book_chapter
-- ----------------------------
DROP TABLE IF EXISTS `book_chapter`;
CREATE TABLE `book_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned NOT NULL COMMENT '书籍ID',
  `name` varchar(50) NOT NULL COMMENT '章节名',
  `content` text NOT NULL COMMENT '章节内容',
  `create_time` datetime DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chapter_book_id` (`book_id`),
  CONSTRAINT `chapter_book_id` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='书籍章节';

-- ----------------------------
-- Records of book_chapter
-- ----------------------------

-- ----------------------------
-- Table structure for book_tags
-- ----------------------------
DROP TABLE IF EXISTS `book_tags`;
CREATE TABLE `book_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tags_id` int(11) NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `book_tags_id` (`tags_id`,`book_id`),
  KEY `book_tags_book_id` (`book_id`),
  CONSTRAINT `book_tags_book_id` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_tags_tags_id` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of book_tags
-- ----------------------------
INSERT INTO `book_tags` VALUES ('12', '1', '18');

-- ----------------------------
-- Table structure for gather
-- ----------------------------
DROP TABLE IF EXISTS `gather`;
CREATE TABLE `gather` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '采集站点名称',
  `url` varchar(255) NOT NULL COMMENT '采集网址（搜索页面）',
  `search` varchar(255) NOT NULL COMMENT '搜索页面正则(获取书籍列表页面）',
  `list` varchar(255) NOT NULL COMMENT '列表页面正则（获取章节url+章节名）',
  `content` varchar(255) NOT NULL COMMENT '章节内容正则（获取章节内容）',
  `replace` text COMMENT '内容替换（采集点内容替换）',
  `remark` varchar(255) DEFAULT NULL COMMENT '采集点简单说明',
  `create_time` datetime DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gather_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='采集源';

-- ----------------------------
-- Records of gather
-- ----------------------------
INSERT INTO `gather` VALUES ('2', '笔趣阁', 'http://zhannei.baidu.com/cse/search?s=10048850760735184192&entry=1&ie=utf8&q={$bookname}', 'dd', 'dd', 'dd', '[{\"search\":\"a\",\"replace\":\"\"}]', 'dd', '2017-05-09 17:44:55', '2017-05-09 17:47:41');
INSERT INTO `gather` VALUES ('3', '顶点小说', 'http://zhannei.baidu.com/cse/search?s=8253726671271885340&entry=1&q={$bookname}', 'dd', 'dd', 'dd', '[]', '', '2017-05-09 17:48:36', '2017-05-09 17:48:36');

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
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8 COMMENT='操作日志表';

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
INSERT INTO `handle_log` VALUES ('40', '1', 'index/login', '用户登录', '{\"data\":{\"email\":\"admin@admin.com\",\"password\":\"1234567\",\"captcha\":\"n7l3\"}}', '2017-04-18 09:23:32', '2017-04-18 09:23:32');
INSERT INTO `handle_log` VALUES ('41', '1', 'index/login', '用户登录', '{\"data\":{\"email\":\"admin@admin.com\",\"password\":\"123456\",\"captcha\":\"ntdd\"}}', '2017-05-08 12:23:18', '2017-05-08 12:23:18');
INSERT INTO `handle_log` VALUES ('42', '1', 'user/edit', '修改用户[id:2]', '{\"data\":{\"name\":\"\\u4ed3\\u4e95\\u7a7a\",\"email\":\"canglaoshi@admin.com\",\"password\":\"\",\"confirm\":\"\",\"role\":\"2\",\"manager\":\"0\",\"status\":\"0\"},\"id\":\"2\"}', '2017-05-08 14:14:45', '2017-05-08 14:14:45');
INSERT INTO `handle_log` VALUES ('43', '1', 'user/edit', '修改用户[id:2]', '{\"data\":{\"name\":\"\\u4ed3\\u4e95\\u7a7a\",\"email\":\"canglaoshi@admin.com\",\"password\":\"\",\"confirm\":\"\",\"role\":\"2\",\"manager\":\"0\",\"status\":\"1\"},\"id\":\"2\"}', '2017-05-08 14:16:25', '2017-05-08 14:16:25');
INSERT INTO `handle_log` VALUES ('44', '1', 'user/edit', '修改用户[id:2]', '{\"data\":{\"name\":\"\\u4ed3\\u4e95\\u7a7a\",\"email\":\"canglaoshi@admin.com\",\"password\":\"\",\"confirm\":\"\",\"role\":\"2\",\"manager\":\"1\",\"status\":\"1\"},\"id\":\"2\"}', '2017-05-08 14:16:32', '2017-05-08 14:16:32');
INSERT INTO `handle_log` VALUES ('45', '1', 'user/edit', '修改用户[id:2]', '{\"data\":{\"name\":\"\\u4ed3\\u4e95\\u7a7a\",\"email\":\"canglaoshi@admin.com\",\"password\":\"\",\"confirm\":\"\",\"role\":\"2\",\"manager\":\"0\",\"status\":\"1\"},\"id\":\"2\"}', '2017-05-08 14:16:39', '2017-05-08 14:16:39');
INSERT INTO `handle_log` VALUES ('46', '1', 'user/add', '添加用户[id:5]', '{\"data\":{\"name\":\"\\u6b66\\u85e4\\u5170\",\"email\":\"wutenglang@11.com\",\"password\":\"123456\",\"confirm\":\"123456\",\"role\":\"13\",\"manager\":\"0\",\"status\":\"1\"}}', '2017-05-08 14:17:22', '2017-05-08 14:17:22');
INSERT INTO `handle_log` VALUES ('47', '1', 'role/edit', '用户组修改[id:4]', '{\"data\":{\"name\":\"\\u5929\\u5929\\u4e00\\u5206\\u949f\",\"remark\":\"\\u5929\\u5929\\u5206\\u949f\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"5\":\"1\",\"11\":\"1\",\"12\":\"1\",\"13\":\"1\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}},\"id\":\"4\"}', '2017-05-08 14:18:26', '2017-05-08 14:18:26');
INSERT INTO `handle_log` VALUES ('48', '1', 'role/edit', '用户组修改[id:4]', '{\"data\":{\"name\":\"\\u5929\\u5929\\u4e00\\u5206\\u949f\",\"remark\":\"\\u5929\\u5929\\u5206\\u949f\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}},\"id\":\"4\"}', '2017-05-08 14:18:36', '2017-05-08 14:18:36');
INSERT INTO `handle_log` VALUES ('49', '1', 'role/destroy', '删除用户组[id:4]', '{\"id\":\"4\"}', '2017-05-08 14:18:51', '2017-05-08 14:18:51');
INSERT INTO `handle_log` VALUES ('50', '1', 'role/add', '添加用户组[id:14]', '{\"data\":{\"name\":\"\\u5c0f\\u4fbf\\u5341\\u5206\\u949f\\u7b97\",\"remark\":\"\\u5c0f\\u4fbf\\u5341\\u5206\\u949f\\u7b97\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}}}', '2017-05-08 14:19:10', '2017-05-08 14:19:10');
INSERT INTO `handle_log` VALUES ('51', '1', 'rule/edit', '修改权限菜单[id:13]', '{\"data\":{\"parent_id\":\"5\",\"title\":\"\\u5220\\u9664\\u5206\\u7ec4\",\"name\":\"role\\/destroy\",\"icon\":\"\",\"sort\":\"3\",\"islink\":\"0\",\"isadmin\":\"1\",\"isverify\":\"1\"},\"id\":\"13\"}', '2017-05-08 14:19:27', '2017-05-08 14:19:27');
INSERT INTO `handle_log` VALUES ('52', '1', 'rule/edit', '修改权限菜单[id:12]', '{\"data\":{\"parent_id\":\"5\",\"title\":\"\\u4fee\\u6539\\u5206\\u7ec4\",\"name\":\"role\\/edit\",\"icon\":\"\",\"sort\":\"2\",\"islink\":\"0\",\"isadmin\":\"1\",\"isverify\":\"1\"},\"id\":\"12\"}', '2017-05-08 14:19:36', '2017-05-08 14:19:36');
INSERT INTO `handle_log` VALUES ('53', '1', 'rule/edit', '修改权限菜单[id:11]', '{\"data\":{\"parent_id\":\"5\",\"title\":\"\\u6dfb\\u52a0\\u5206\\u7ec4\",\"name\":\"role\\/add\",\"icon\":\"\",\"sort\":\"1\",\"islink\":\"0\",\"isadmin\":\"1\",\"isverify\":\"1\"},\"id\":\"11\"}', '2017-05-08 14:19:47', '2017-05-08 14:19:47');
INSERT INTO `handle_log` VALUES ('54', '1', 'rule/add', '权限菜单添加[id:19]', '{\"data\":{\"parent_id\":\"0\",\"title\":\"\\u4e66\\u7c4d\\u7ba1\\u7406\",\"name\":\"book\",\"icon\":\"\",\"sort\":\"2\",\"islink\":\"1\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:03:04', '2017-05-08 17:03:04');
INSERT INTO `handle_log` VALUES ('55', '1', 'rule/add', '权限菜单添加[id:20]', '{\"data\":{\"parent_id\":\"19\",\"title\":\"\\u4e66\\u7c4d\\u5217\\u8868\",\"name\":\"book\\/index\",\"icon\":\"\",\"sort\":\"1\",\"islink\":\"1\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:03:29', '2017-05-08 17:03:29');
INSERT INTO `handle_log` VALUES ('56', '1', 'rule/add', '权限菜单添加[id:21]', '{\"data\":{\"parent_id\":\"20\",\"title\":\"\\u6dfb\\u52a0\\u4e66\\u7c4d\",\"name\":\"book\\/add\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"0\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:05:51', '2017-05-08 17:05:51');
INSERT INTO `handle_log` VALUES ('57', '1', 'rule/add', '权限菜单添加[id:22]', '{\"data\":{\"parent_id\":\"19\",\"title\":\"\\u4fee\\u6539\\u4e66\\u7c4d\",\"name\":\"book\\/edit\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"0\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:06:12', '2017-05-08 17:06:12');
INSERT INTO `handle_log` VALUES ('58', '1', 'rule/add', '权限菜单添加[id:23]', '{\"data\":{\"parent_id\":\"20\",\"title\":\"\\u5220\\u9664\\u4e66\\u7c4d\",\"name\":\"book\\/destroy\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"0\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:07:01', '2017-05-08 17:07:01');
INSERT INTO `handle_log` VALUES ('59', '1', 'rule/edit', '修改权限菜单[id:22]', '{\"data\":{\"parent_id\":\"20\",\"title\":\"\\u4fee\\u6539\\u4e66\\u7c4d\",\"name\":\"book\\/edit\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"0\",\"isadmin\":\"0\",\"isverify\":\"1\"},\"id\":\"22\"}', '2017-05-08 17:16:33', '2017-05-08 17:16:33');
INSERT INTO `handle_log` VALUES ('60', '1', 'rule/edit', '修改权限菜单[id:22]', '{\"data\":{\"parent_id\":\"20\",\"title\":\"\\u4fee\\u6539\\u4e66\\u7c4d\",\"name\":\"book\\/edit\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"0\",\"isadmin\":\"0\",\"isverify\":\"1\"},\"id\":\"22\"}', '2017-05-08 17:17:40', '2017-05-08 17:17:40');
INSERT INTO `handle_log` VALUES ('61', '1', 'rule/add', '权限菜单添加[id:24]', '{\"data\":{\"parent_id\":\"19\",\"title\":\"\\u4e66\\u7c4d\\u6807\\u7b7e\",\"name\":\"booktags\\/index\",\"icon\":\"\",\"sort\":\"2\",\"islink\":\"1\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:19:53', '2017-05-08 17:19:53');
INSERT INTO `handle_log` VALUES ('62', '1', 'rule/add', '权限菜单添加[id:25]', '{\"data\":{\"parent_id\":\"24\",\"title\":\"\\u6dfb\\u52a0\\u4e66\\u7c4d\\u6807\\u7b7e\",\"name\":\"booktags\\/add\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"0\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:20:20', '2017-05-08 17:20:20');
INSERT INTO `handle_log` VALUES ('63', '1', 'rule/add', '权限菜单添加[id:26]', '{\"data\":{\"parent_id\":\"24\",\"title\":\"\\u4fee\\u6539\\u4e66\\u7c4d\\u6807\\u7b7e\",\"name\":\"booktags\\/edit\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"0\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:20:59', '2017-05-08 17:20:59');
INSERT INTO `handle_log` VALUES ('64', '1', 'rule/add', '权限菜单添加[id:27]', '{\"data\":{\"parent_id\":\"24\",\"title\":\"\\u5220\\u9664\\u4e66\\u7c4d\\u6807\\u7b7e\",\"name\":\"booktags\\/destroy\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"0\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:21:22', '2017-05-08 17:21:22');
INSERT INTO `handle_log` VALUES ('65', '1', 'rule/add', '权限菜单添加[id:28]', '{\"data\":{\"parent_id\":\"19\",\"title\":\"\\u4e66\\u7c4d\\u4f5c\\u8005\",\"name\":\"bookauthor\\/add\",\"icon\":\"\",\"sort\":\"3\",\"islink\":\"1\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:21:54', '2017-05-08 17:21:54');
INSERT INTO `handle_log` VALUES ('66', '1', 'rule/add', '权限菜单添加[id:30]', '{\"data\":{\"parent_id\":\"28\",\"title\":\"\\u4fee\\u6539\\u4e66\\u7c4d\\u4f5c\\u8005\",\"name\":\"bookauthor\\/edit\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"0\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:23:13', '2017-05-08 17:23:13');
INSERT INTO `handle_log` VALUES ('67', '1', 'rule/edit', '修改权限菜单[id:28]', '{\"data\":{\"parent_id\":\"19\",\"title\":\"\\u4e66\\u7c4d\\u4f5c\\u8005\",\"name\":\"bookauthor\",\"icon\":\"\",\"sort\":\"3\",\"islink\":\"1\",\"isadmin\":\"0\",\"isverify\":\"1\"},\"id\":\"28\"}', '2017-05-08 17:23:28', '2017-05-08 17:23:28');
INSERT INTO `handle_log` VALUES ('68', '1', 'rule/add', '权限菜单添加[id:31]', '{\"data\":{\"parent_id\":\"28\",\"title\":\"\\u6dfb\\u52a0\\u4e66\\u7c4d\\u4f5c\\u8005\",\"name\":\"bookauthor\\/add\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"0\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:24:00', '2017-05-08 17:24:00');
INSERT INTO `handle_log` VALUES ('69', '1', 'rule/add', '权限菜单添加[id:32]', '{\"data\":{\"parent_id\":\"28\",\"title\":\"\\u5220\\u9664\\u4e66\\u7c4d\\u4f5c\\u8005\",\"name\":\"bookauthor\\/destroy\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"0\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:29:27', '2017-05-08 17:29:27');
INSERT INTO `handle_log` VALUES ('70', '1', 'rule/add', '权限菜单添加[id:33]', '{\"data\":{\"parent_id\":\"19\",\"title\":\"\\u4e66\\u7c4d\\u6765\\u6e90\",\"name\":\"source\",\"icon\":\"\",\"sort\":\"4\",\"islink\":\"1\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:31:59', '2017-05-08 17:31:59');
INSERT INTO `handle_log` VALUES ('71', '1', 'rule/add', '权限菜单添加[id:37]', '{\"data\":{\"parent_id\":\"19\",\"title\":\"\\u91c7\\u96c6\\u5217\\u8868\",\"name\":\"gather\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"1\",\"isadmin\":\"0\",\"isverify\":\"1\"}}', '2017-05-08 17:35:25', '2017-05-08 17:35:25');
INSERT INTO `handle_log` VALUES ('72', '1', 'index/login', '用户登录', '{\"data\":{\"email\":\"admin@admin.com\",\"password\":\"1234567\",\"captcha\":\"3vvv\"}}', '2017-05-09 10:17:10', '2017-05-09 10:17:10');
INSERT INTO `handle_log` VALUES ('73', '1', 'rule/edit', '修改权限菜单[id:37]', '{\"data\":{\"parent_id\":\"19\",\"title\":\"\\u91c7\\u96c6\\u5217\\u8868\",\"name\":\"gather\\/index\",\"icon\":\"\",\"sort\":\"255\",\"islink\":\"1\",\"isadmin\":\"0\",\"isverify\":\"1\"},\"id\":\"37\"}', '2017-05-09 10:22:23', '2017-05-09 10:22:23');
INSERT INTO `handle_log` VALUES ('74', '1', 'rule/edit', '修改权限菜单[id:33]', '{\"data\":{\"parent_id\":\"19\",\"title\":\"\\u4e66\\u7c4d\\u6765\\u6e90\",\"name\":\"source\\/index\",\"icon\":\"\",\"sort\":\"4\",\"islink\":\"1\",\"isadmin\":\"0\",\"isverify\":\"1\"},\"id\":\"33\"}', '2017-05-09 10:22:40', '2017-05-09 10:22:40');
INSERT INTO `handle_log` VALUES ('75', '1', 'rule/edit', '修改权限菜单[id:28]', '{\"data\":{\"parent_id\":\"19\",\"title\":\"\\u4e66\\u7c4d\\u4f5c\\u8005\",\"name\":\"author\\/index\",\"icon\":\"\",\"sort\":\"3\",\"islink\":\"1\",\"isadmin\":\"0\",\"isverify\":\"1\"},\"id\":\"28\"}', '2017-05-09 10:23:02', '2017-05-09 10:23:02');
INSERT INTO `handle_log` VALUES ('76', '1', 'gather/add', '添加采集[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"replace\":{\"search\":[\"\"],\"replace\":[\"\"]},\"remark\":\"\"},\"entry\":\"1\",\"ie\":\"gbk\",\"q\":\"{$bookname}\"}', '2017-05-09 11:22:47', '2017-05-09 11:22:47');
INSERT INTO `handle_log` VALUES ('77', '1', 'gather/edit', '修改采集源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"replace\":{\"search\":[\"<br>\"],\"replace\":[\"<\\/p><p>\"]},\"remark\":\"\\u91c7\\u96c6\\u6e90\\u4e3b\\u9875\\uff1awww.biquge.com.tw\\n\"},\"entry\":\"1\",\"ie\":\"utf8\",\"q\":\" {$bookname}\",\"id\":\"1\"}', '2017-05-09 11:40:14', '2017-05-09 11:40:14');
INSERT INTO `handle_log` VALUES ('78', '1', 'gather/edit', '修改采集源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"replace\":{\"search\":[\"\"],\"replace\":[\"\"]},\"remark\":\"\\u91c7\\u96c6\\u6e90\\u4e3b\\u9875\\uff1awww.biquge.com.tw\\n\"},\"id\":\"1\"}', '2017-05-09 11:44:04', '2017-05-09 11:44:04');
INSERT INTO `handle_log` VALUES ('79', '1', 'gather/edit', '修改采集源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"replace\":{\"search\":[\"<br>\",\"<br\\/>\"],\"replace\":[\"<\\/p><p>\",\"<\\/p><p>\"]},\"remark\":\"\\u91c7\\u96c6\\u6e90\\u4e3b\\u9875\\uff1awww.biquge.com.tw\\n\"},\"id\":\"1\"}', '2017-05-09 11:44:32', '2017-05-09 11:44:32');
INSERT INTO `handle_log` VALUES ('80', '1', 'gather/edit', '修改采集源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"replace\":{\"search\":[\"<br>\",\"<br\\/>\"],\"replace\":[\"<\\/p><p>\",\"<\\/p><p>\"]},\"remark\":\"\\u91c7\\u96c6\\u6e90\\u4e3b\\u9875\\uff1awww.biquge.com.tw\\n\"},\"id\":\"1\"}', '2017-05-09 11:44:42', '2017-05-09 11:44:42');
INSERT INTO `handle_log` VALUES ('81', '1', 'gather/edit', '修改采集源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"sort\":\"100\",\"status\":\"1\",\"replace\":{\"search\":[\"<br>\",\"<br\\/>\"],\"replace\":[\"<\\/p><p>\",\"<\\/p><p>\"]},\"remark\":\"\\u91c7\\u96c6\\u6e90\\u4e3b\\u9875\\uff1awww.biquge.com.tw\\n\"},\"id\":\"1\"}', '2017-05-09 14:19:31', '2017-05-09 14:19:31');
INSERT INTO `handle_log` VALUES ('82', '1', 'gather/status', '更改采集源状态[id:1]', '{\"data\":{\"status\":\"0\"},\"id\":\"1\"}', '2017-05-09 14:48:45', '2017-05-09 14:48:45');
INSERT INTO `handle_log` VALUES ('83', '1', 'user/status', '修改用户[id:2]', '{\"data\":{\"status\":\"0\"},\"id\":\"2\"}', '2017-05-09 14:49:21', '2017-05-09 14:49:21');
INSERT INTO `handle_log` VALUES ('84', '1', 'gather/status', '更改采集源状态[id:1]', '{\"data\":{\"status\":\"0\"},\"id\":\"1\"}', '2017-05-09 14:49:31', '2017-05-09 14:49:31');
INSERT INTO `handle_log` VALUES ('85', '1', 'gather/status', '更改采集源状态[id:1]', '{\"data\":{\"status\":\"0\"},\"id\":\"1\"}', '2017-05-09 14:50:04', '2017-05-09 14:50:04');
INSERT INTO `handle_log` VALUES ('86', '1', 'gather/status', '更改采集源状态[id:1]', '{\"data\":{\"status\":\"1\"},\"id\":\"1\"}', '2017-05-09 14:50:45', '2017-05-09 14:50:45');
INSERT INTO `handle_log` VALUES ('87', '1', 'gather/status', '更改采集源状态[id:1]', '{\"data\":{\"status\":\"0\"},\"id\":\"1\"}', '2017-05-09 14:50:51', '2017-05-09 14:50:51');
INSERT INTO `handle_log` VALUES ('88', '1', 'gather/edit', '修改采集源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"sort\":\"100\",\"status\":\"0\",\"replace\":{\"search\":[\"<br>\",\"<br\\/>\"],\"replace\":[\"<\\/p><p>\",\"<\\/p><p>\"]},\"remark\":\"\\u91c7\\u96c6\\u6e90\\u4e3b\\u9875\\uff1awww.biquge.com.tw\\n\"},\"entry\":\"1\",\"ie\":\"utf8\",\"q\":\"{$bookname}\",\"id\":\"1\"}', '2017-05-09 14:52:06', '2017-05-09 14:52:06');
INSERT INTO `handle_log` VALUES ('89', '1', 'gather/edit', '修改采集源[id:1]', '', '2017-05-09 14:58:42', '2017-05-09 14:58:42');
INSERT INTO `handle_log` VALUES ('90', '1', 'gather/edit', '修改采集源[id:1]', '', '2017-05-09 14:58:57', '2017-05-09 14:58:57');
INSERT INTO `handle_log` VALUES ('91', '1', 'gather/edit', '修改采集源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"sort\":\"100\",\"status\":\"0\",\"replace\":{\"search\":[\"<br>\",\"<br\\/>\"],\"replace\":[\"<\\/p><p>\",\"<\\/p><p>\"]},\"remark\":\"\\u91c7\\u96c6\\u6e90\\u4e3b\\u9875\\uff1awww.biquge.com.tw\\n\"},\"entry\":\"1\",\"ie\":\"utf8\",\"q\":\"{$bookname}\",\"id\":\"1\"}', '2017-05-09 14:59:42', '2017-05-09 14:59:42');
INSERT INTO `handle_log` VALUES ('92', '1', 'gather/edit', '修改采集源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"sort\":\"100\",\"status\":\"0\",\"replace\":{\"search\":[\"<br>\",\"<br\\/>\"],\"replace\":[\"<\\/p><p>\",\"<\\/p><p>\"]},\"remark\":\"\\u91c7\\u96c6\\u6e90\\u4e3b\\u9875\\uff1awww.biquge.com.tw\\n\"},\"entry\":\"1\",\"ie\":\"utf8\",\"q\":\"{$bookname}\",\"id\":\"1\"}', '2017-05-09 15:00:26', '2017-05-09 15:00:26');
INSERT INTO `handle_log` VALUES ('93', '1', 'gather/edit', '修改采集源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"sort\":\"100\",\"status\":\"1\",\"replace\":{\"search\":[\"<br>\",\"<br\\/>\"],\"replace\":[\"<\\/p><p>\",\"<\\/p><p>\"]},\"remark\":\"\\u91c7\\u96c6\\u6e90\\u4e3b\\u9875\\uff1awww.biquge.com.tw\\n\"},\"id\":\"1\"}', '2017-05-09 15:00:54', '2017-05-09 15:00:54');
INSERT INTO `handle_log` VALUES ('94', '1', 'gather/edit', '修改采集源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"sort\":\"100\",\"status\":\"1\",\"replace\":{\"search\":[\"<br>\",\"<br\\/>\"],\"replace\":[\"<\\/p><p>\",\"<\\/p><p>\"]},\"remark\":\"\\u91c7\\u96c6\\u6e90\\u4e3b\\u9875\\uff1awww.biquge.com.tw\\n\"},\"entry\":\"1\",\"ie\":\"utf8\",\"q\":\"{$bookname}\",\"id\":\"1\"}', '2017-05-09 15:03:12', '2017-05-09 15:03:12');
INSERT INTO `handle_log` VALUES ('95', '1', 'gather/edit', '修改采集源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"sort\":\"100\",\"status\":\"1\",\"replace\":{\"search\":[\"<br>\",\"<br\\/>\"],\"replace\":[\"<\\/p><p>\",\"<\\/p><p>\"]},\"remark\":\"\\u91c7\\u96c6\\u6e90\\u4e3b\\u9875\\uff1awww.biquge.com.tw\\n\"},\"entry\":\"1\",\"ie\":\"utf8\",\"q\":\"{$bookname}\",\"id\":\"1\"}', '2017-05-09 15:05:57', '2017-05-09 15:05:57');
INSERT INTO `handle_log` VALUES ('96', '1', 'gather/edit', '修改采集源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601tw\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192&entry=1&ie=utf8&q={$bookname}\",\"search\":\".result-game-item-detail .result-game-item-title a\",\"list\":\"#list dl dd a\",\"content\":\"#content\",\"sort\":\"100\",\"status\":\"1\",\"replace\":{\"search\":[\"<br>\",\"<br\\/>\"],\"replace\":[\"<\\/p><p>\",\"<\\/p><p>\"]},\"remark\":\"\\u91c7\\u96c6\\u6e90\\u4e3b\\u9875\\uff1awww.biquge.com.tw\\r\\n\"},\"id\":\"1\"}', '2017-05-09 15:17:12', '2017-05-09 15:17:12');
INSERT INTO `handle_log` VALUES ('97', '1', 'role/edit', '用户组修改[id:13]', '{\"data\":{\"name\":\"\\u5987\\u5973\\u8054\\u76df\",\"remark\":\"\\u5987\\u5973\\u8054\\u76df\",\"rule\":{\"3\":\"1\",\"19\":\"1\",\"20\":\"1\",\"21\":\"1\",\"22\":\"1\",\"23\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"11\":\"1\",\"12\":\"1\",\"13\":\"1\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}},\"id\":\"13\"}', '2017-05-09 15:21:12', '2017-05-09 15:21:12');
INSERT INTO `handle_log` VALUES ('98', '1', 'role/edit', '用户组修改[id:13]', '{\"data\":{\"name\":\"\\u5987\\u5973\\u8054\\u76df\",\"remark\":\"\\u5987\\u5973\\u8054\\u76df\",\"rule\":{\"3\":\"1\",\"19\":\"1\",\"20\":\"1\",\"21\":\"1\",\"22\":\"1\",\"23\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}},\"id\":\"13\"}', '2017-05-09 15:21:27', '2017-05-09 15:21:27');
INSERT INTO `handle_log` VALUES ('99', '1', 'source/add', '添加来源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601\",\"url\":\"http:\\/\\/www.biquge.com.tw\\/\",\"status\":\"1\",\"remark\":\"\\u7b14\\u8da3\\u9601\\u662f\\u5e7f\\u5927\\u4e66\\u53cb\\u6700\\u503c\\u5f97\\u6536\\u85cf\\u7684\\u7f51\\u7edc\\u5c0f\\u8bf4\\u9605\\u8bfb\\u7f51\\uff0c\\u7f51\\u7ad9\\u6536\\u5f55\\u4e86\\u5f53\\u524d\\u6700\\u706b\\u70ed\\u7684\\u7f51\\u7edc\\u5c0f\\u8bf4\\uff0c\\u514d\\u8d39\\u63d0\\u4f9b\\u9ad8\\u8d28\\u91cf\\u7684\\u5c0f\\u8bf4\\u6700\\u65b0\\u7ae0\\u8282\\uff0c\\u662f\\u5e7f\\u5927\\u7f51\\u7edc\\u5c0f\\u8bf4\\u7231\\u597d\\u8005\\u5fc5\\u5907\\u7684\\u5c0f\\u8bf4\\u9605\\u8bfb\\u7f51\\u3002\"}}', '2017-05-09 15:59:54', '2017-05-09 15:59:54');
INSERT INTO `handle_log` VALUES ('100', '1', 'source/edit', '添加来源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601\",\"url\":\"http:\\/\\/www.biquge.com.tw\\/\",\"status\":\"0\",\"remark\":\"\\u7b14\\u8da3\\u9601\\u662f\\u5e7f\\u5927\\u4e66\\u53cb\\u6700\\u503c\\u5f97\\u6536\\u85cf\\u7684\\u7f51\\u7edc\\u5c0f\\u8bf4\\u9605\\u8bfb\\u7f51\\uff0c\\u7f51\\u7ad9\\u6536\\u5f55\\u4e86\\u5f53\\u524d\\u6700\\u706b\\u70ed\\u7684\\u7f51\\u7edc\\u5c0f\\u8bf4\\uff0c\\u514d\\u8d39\\u63d0\\u4f9b\\u9ad8\\u8d28\\u91cf\\u7684\\u5c0f\\u8bf4\\u6700\\u65b0\\u7ae0\\u8282\\uff0c\\u662f\\u5e7f\\u5927\\u7f51\\u7edc\\u5c0f\\u8bf4\\u7231\\u597d\\u8005\\u5fc5\\u5907\\u7684\\u5c0f\\u8bf4\\u9605\\u8bfb\\u7f51\\u3002\"},\"id\":\"1\"}', '2017-05-09 16:06:58', '2017-05-09 16:06:58');
INSERT INTO `handle_log` VALUES ('101', '1', 'source/edit', '修改来源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601\",\"url\":\"http:\\/\\/www.biquge.com.tw\\/\",\"status\":\"0\",\"remark\":\"\\u7b14\\u8da3\\u9601\\u662f\\u5e7f\\u5927\\u4e66\\u53cb\\u6700\\u503c\\u5f97\\u6536\\u85cf\\u7684\\u7f51\\u7edc\\u5c0f\\u8bf4\\u9605\\u8bfb\\u7f51\\uff0c\\u7f51\\u7ad9\\u6536\\u5f55\\u4e86\\u5f53\\u524d\\u6700\\u706b\\u70ed\\u7684\\u7f51\\u7edc\\u5c0f\\u8bf4\\uff0c\\u514d\\u8d39\\u63d0\\u4f9b\\u9ad8\\u8d28\\u91cf\\u7684\\u5c0f\\u8bf4\\u6700\\u65b0\\u7ae0\\u8282\\uff0c\\u662f\\u5e7f\\u5927\\u7f51\\u7edc\\u5c0f\\u8bf4\\u7231\\u597d\\u8005\\u5fc5\\u5907\\u7684\\u5c0f\\u8bf4\\u9605\\u8bfb\\u7f51\"},\"id\":\"1\"}', '2017-05-09 16:07:28', '2017-05-09 16:07:28');
INSERT INTO `handle_log` VALUES ('102', '1', 'gather/status', '更改采集源状态[id:1]', '{\"data\":{\"status\":\"1\"},\"id\":\"1\"}', '2017-05-09 16:08:13', '2017-05-09 16:08:13');
INSERT INTO `handle_log` VALUES ('103', '1', 'gather/status', '更改采集源状态[id:1]', '{\"data\":{\"status\":\"1\"},\"id\":\"1\"}', '2017-05-09 16:08:43', '2017-05-09 16:08:43');
INSERT INTO `handle_log` VALUES ('104', '1', 'source/status', '更改来源状态[id:1]', '{\"data\":{\"status\":\"1\"},\"id\":\"1\"}', '2017-05-09 16:09:43', '2017-05-09 16:09:43');
INSERT INTO `handle_log` VALUES ('105', '1', 'author/add', '添加作者[id:1]', '{\"data\":{\"name\":\"\\u5510\\u5bb6\\u4e09\\u5c11\",\"remark\":\"\\u4f5c\\u8005\\u8bf4\\u660e\"}}', '2017-05-09 16:58:09', '2017-05-09 16:58:09');
INSERT INTO `handle_log` VALUES ('106', '1', 'author/edit', '修改作者[id:1]', '{\"data\":{\"name\":\"\\u5510\\u5bb6\\u4e09\\u5c11\",\"remark\":\"\\u4f5c\\u8005\\u8bf4\\u660e1\"},\"id\":\"1\"}', '2017-05-09 17:03:09', '2017-05-09 17:03:09');
INSERT INTO `handle_log` VALUES ('107', '1', 'author/destroy', '删除成功！', '{\"id\":\"1\"}', '2017-05-09 17:27:13', '2017-05-09 17:27:13');
INSERT INTO `handle_log` VALUES ('108', '1', 'author/add', '添加作者[id:2]', '{\"data\":{\"name\":\"\\u5510\\u5bb6\\u4e09\\u5c11\",\"remark\":\"\\u5510\\u5bb6\\u4e09\\u5c11\"}}', '2017-05-09 17:28:25', '2017-05-09 17:28:25');
INSERT INTO `handle_log` VALUES ('109', '1', 'author/destroy', '删除！', '{\"id\":\"2\"}', '2017-05-09 17:28:33', '2017-05-09 17:28:33');
INSERT INTO `handle_log` VALUES ('110', '1', 'gather/destroy', '删除', '{\"id\":\"1\"}', '2017-05-09 17:41:29', '2017-05-09 17:41:29');
INSERT INTO `handle_log` VALUES ('111', '1', 'gather/add', '添加采集源[id:2]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192&entry=1&ie=utf8&q={$bookname}\",\"search\":\"dd\",\"list\":\"dd\",\"content\":\"dd\",\"replace\":{\"search\":[\"\"],\"replace\":[\"\"]},\"remark\":\"dd\"}}', '2017-05-09 17:44:55', '2017-05-09 17:44:55');
INSERT INTO `handle_log` VALUES ('112', '1', 'gather/edit', '修改采集源[id:2]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=10048850760735184192&entry=1&ie=utf8&q={$bookname}\",\"search\":\"dd\",\"list\":\"dd\",\"content\":\"dd\",\"replace\":{\"search\":[\"a\"],\"replace\":[\"\"]},\"remark\":\"dd\"},\"id\":\"2\"}', '2017-05-09 17:47:41', '2017-05-09 17:47:41');
INSERT INTO `handle_log` VALUES ('113', '1', 'gather/add', '添加采集源[id:3]', '{\"data\":{\"name\":\"\\u9876\\u70b9\\u5c0f\\u8bf4\",\"url\":\"http:\\/\\/zhannei.baidu.com\\/cse\\/search?s=8253726671271885340&entry=1&q={$bookname}\",\"search\":\"dd\",\"list\":\"dd\",\"content\":\"dd\",\"replace\":{\"search\":[\"\"],\"replace\":[\"\"]},\"remark\":\"\"}}', '2017-05-09 17:48:36', '2017-05-09 17:48:36');
INSERT INTO `handle_log` VALUES ('114', '1', 'source/add', '添加来源[id:2]', '{\"data\":{\"name\":\"\\u9876\\u70b9\\u5c0f\\u8bf4\",\"url\":\"http:\\/\\/www.23us.com\\/\",\"remark\":\"\\u9876\\u70b9\\u5c0f\\u8bf4\\u81f4\\u529b\\u4e8e\\u6253\\u9020\\u65e0\\u5e7f\\u544a\\u65e0\\u5f39\\u7a97\\u7684\\u5728\\u7ebf\\u5c0f\\u8bf4\\u9605\\u8bfb\\u7f51\\u7ad9\\uff0c\\u63d0\\u4f9b\\u5c0f\\u8bf4\\u5728\\u7ebf\\u9605\\u8bfb\\uff0c\\u5c0f\\u8bf4TXT\\u4e0b\\u8f7d\\uff0c\\u7f51\\u7ad9\\u6ca1\\u6709\\u5f39\\u7a97\\u5e7f\\u544a\\u9875\\u9762\\u7b80\\u6d01\\u3002\"}}', '2017-05-09 17:49:32', '2017-05-09 17:49:32');
INSERT INTO `handle_log` VALUES ('115', '1', 'source/edit', '修改来源[id:1]', '{\"data\":{\"name\":\"\\u7b14\\u8da3\\u9601\",\"url\":\"http:\\/\\/www.biquge.com.tw\",\"remark\":\"\\u7b14\\u8da3\\u9601\\u662f\\u5e7f\\u5927\\u4e66\\u53cb\\u6700\\u503c\\u5f97\\u6536\\u85cf\\u7684\\u7f51\\u7edc\\u5c0f\\u8bf4\\u9605\\u8bfb\\u7f51\\uff0c\\u7f51\\u7ad9\\u6536\\u5f55\\u4e86\\u5f53\\u524d\\u6700\\u706b\\u70ed\\u7684\\u7f51\\u7edc\\u5c0f\\u8bf4\\uff0c\\u514d\\u8d39\\u63d0\\u4f9b\\u9ad8\\u8d28\\u91cf\\u7684\\u5c0f\\u8bf4\\u6700\\u65b0\\u7ae0\\u8282\\uff0c\\u662f\\u5e7f\\u5927\\u7f51\\u7edc\\u5c0f\\u8bf4\\u7231\\u597d\\u8005\\u5fc5\\u5907\\u7684\\u5c0f\\u8bf4\\u9605\\u8bfb\\u7f51\"},\"id\":\"1\"}', '2017-05-09 17:49:44', '2017-05-09 17:49:44');
INSERT INTO `handle_log` VALUES ('116', '1', 'source/destroy', '删除', '{\"id\":\"1\"}', '2017-05-09 17:49:51', '2017-05-09 17:49:51');
INSERT INTO `handle_log` VALUES ('117', '1', 'author/add', '添加作者[id:3]', '{\"data\":{\"name\":\"\\u674e\\u5bb6\\u4e09\\u5c11\",\"remark\":\"\\u674e\\u5bb6\\u7b2c\\u4e09\\u4e2a\\u5c11\\u7237\"}}', '2017-05-09 17:50:14', '2017-05-09 17:50:14');
INSERT INTO `handle_log` VALUES ('118', '1', 'author/edit', '修改作者[id:3]', '{\"data\":{\"name\":\"\\u674e\\u5bb6\\u4e09\\u5c11\",\"remark\":\"\\u674e\\u5bb6\\u7b2c\\u4e09\\u4e2a\\u5c11\\u72371\"},\"id\":\"3\"}', '2017-05-09 17:50:21', '2017-05-09 17:50:21');
INSERT INTO `handle_log` VALUES ('119', '1', 'author/destroy', '删除', '{\"id\":\"3\"}', '2017-05-09 17:50:27', '2017-05-09 17:50:27');
INSERT INTO `handle_log` VALUES ('120', '1', 'index/login', '用户登录', '{\"data\":{\"email\":\"admin@admin.com\",\"password\":\"1234567\",\"captcha\":\"m2st\"}}', '2017-05-10 09:31:05', '2017-05-10 09:31:05');
INSERT INTO `handle_log` VALUES ('121', '1', 'tags/add', '添加标签[id:1]', '{\"data\":{\"name\":\"\\u4ed9\\u4fa0\",\"en_name\":\"xianxia\"},\"desc\":\"\\u4ed9\\u4fa0\"}', '2017-05-10 10:21:26', '2017-05-10 10:21:26');
INSERT INTO `handle_log` VALUES ('122', '1', 'tags/edit', '修改书籍标签[id:1]', '{\"data\":{\"name\":\"\\u4ed9\\u4fa0\",\"en_name\":\"xianxia\",\"remark\":\"\\u4ed9\\u4fa0\\u662f\\u4e00\\u4e9b\\u4fee\\u4ed9\\u6210\\u795e\\u7684\\u5c0f\\u8bf4\"},\"id\":\"1\"}', '2017-05-10 10:27:22', '2017-05-10 10:27:22');
INSERT INTO `handle_log` VALUES ('123', '1', 'tags/edit', '修改书籍标签[id:1]', '{\"data\":{\"name\":\"\\u4ed9\\u4fa0\",\"en_name\":\"xianxia\",\"remark\":\"\\u4ed9\\u4fa0\\u662f\\u4e00\\u4e9b\\u4fee\\u4ed9\\u6210\\u795e\\u7684\\u5c0f\\u8bf4\"},\"id\":\"1\"}', '2017-05-10 10:27:30', '2017-05-10 10:27:30');
INSERT INTO `handle_log` VALUES ('124', '1', 'author/add', '添加书籍作者[id:4]', '{\"data\":{\"name\":\"\\u5510\\u4e09\\u5c11\\u7237\",\"remark\":\"\\u5510\\u4e09\\u5c11\\u7237\"}}', '2017-05-10 12:08:46', '2017-05-10 12:08:46');
INSERT INTO `handle_log` VALUES ('125', '1', 'book/add', '添加书籍[id:2]', '{\"data\":{\"name\":\"\\u4e09\\u5c11\\u7237\\u7684\\u5251\",\"alias\":\"\\u4e09\\u5c11\\u7237\",\"tags\":[\"1\"],\"isbn\":\"df345234\",\"gather\":{\"gather_id\":[\"\"],\"list_url\":[\"\"],\"sort\":[\"\"]}},\"search\":{\"author_id\":\"4\",\"source_id\":\"2\"}}', '2017-05-10 12:17:06', '2017-05-10 12:17:06');
INSERT INTO `handle_log` VALUES ('126', '1', 'role/add', '添加用户组[id:15]', '{\"data\":{\"name\":\"ddd\",\"remark\":\"dddd\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}}}', '2017-05-10 12:17:33', '2017-05-10 12:17:33');
INSERT INTO `handle_log` VALUES ('127', '1', 'role/add', '添加用户组[id:16]', '{\"data\":{\"name\":\"dfadsfa\",\"remark\":\"asdfasdf\",\"rule\":{\"3\":\"1\",\"1\":\"1\",\"4\":\"1\",\"15\":\"1\",\"16\":\"1\",\"14\":\"1\",\"17\":\"1\",\"8\":\"1\",\"9\":\"1\",\"18\":\"1\",\"10\":\"1\"}}}', '2017-05-10 12:24:54', '2017-05-10 12:24:54');
INSERT INTO `handle_log` VALUES ('128', '1', 'book/add', '添加书籍[id:11]', '{\"data\":{\"name\":\"\\u56db\\u5c11\\u7237\\u7684\\u5200\",\"alias\":\"\\u56db\\u5c11\\u7237\\u7684\\u5200\",\"tags\":[\"1\"],\"isbn\":\"23131\",\"gather\":{\"gather_id\":[\"\"],\"list_url\":[\"\"],\"sort\":[\"\"]}},\"search\":{\"author_id\":\"4\",\"source_id\":\"2\"}}', '2017-05-10 13:55:07', '2017-05-10 13:55:07');
INSERT INTO `handle_log` VALUES ('129', '1', 'book/add', '添加书籍[id:12]', '{\"data\":{\"name\":\"\\u56db\\u5c11\\u7237\\u7684\\u5200\",\"alias\":\"\\u5200\\u795e\",\"tags\":[\"1\"],\"isbn\":\"1121212\",\"gather\":{\"gather_id\":[\"2\"],\"list_url\":[\"\\u5954\\u5954a\"],\"sort\":[\"322\"]}},\"search\":{\"author_id\":\"4\",\"source_id\":\"2\"}}', '2017-05-10 14:00:12', '2017-05-10 14:00:12');
INSERT INTO `handle_log` VALUES ('130', '1', 'book/add', '添加书籍[id:13]', '{\"data\":{\"name\":\"\\u56db\\u5c11\\u7237\\u7684\\u5200\",\"alias\":\"\\u5200\\u795e\",\"tags\":[\"1\"],\"isbn\":\"1121212\",\"gather\":{\"gather_id\":[\"2\"],\"list_url\":[\"\\u5954\\u5954a\"],\"sort\":[\"322\"]}},\"search\":{\"author_id\":\"4\",\"source_id\":\"2\"}}', '2017-05-10 14:00:35', '2017-05-10 14:00:35');
INSERT INTO `handle_log` VALUES ('131', '1', 'book/add', '添加书籍[id:14]', '{\"data\":{\"name\":\"\\u56db\\u5c11\\u7237\\u7684\\u5200\",\"alias\":\"\\u5200\\u795e\",\"tags\":[\"1\"],\"isbn\":\"1121212\",\"gather\":{\"gather_id\":[\"2\"],\"list_url\":[\"\\u5954\\u5954a\"],\"sort\":[\"322\"]}},\"search\":{\"author_id\":\"4\",\"source_id\":\"2\"}}', '2017-05-10 14:01:00', '2017-05-10 14:01:00');
INSERT INTO `handle_log` VALUES ('132', '1', 'index/upload', '0', '[]', '2017-05-10 15:35:40', '2017-05-10 15:35:40');
INSERT INTO `handle_log` VALUES ('133', '1', 'index/upload', '0', '[]', '2017-05-10 15:37:35', '2017-05-10 15:37:35');
INSERT INTO `handle_log` VALUES ('134', '1', 'index/upload', '0', '[]', '2017-05-10 15:37:43', '2017-05-10 15:37:43');
INSERT INTO `handle_log` VALUES ('135', '1', 'index/upload', '0', '[]', '2017-05-10 15:38:13', '2017-05-10 15:38:13');
INSERT INTO `handle_log` VALUES ('136', '1', 'index/upload', '0', '[]', '2017-05-10 15:38:43', '2017-05-10 15:38:43');
INSERT INTO `handle_log` VALUES ('137', '1', 'index/upload', '0', '[]', '2017-05-10 15:39:18', '2017-05-10 15:39:18');
INSERT INTO `handle_log` VALUES ('138', '1', 'index/upload', '0', '[]', '2017-05-10 15:39:50', '2017-05-10 15:39:50');
INSERT INTO `handle_log` VALUES ('139', '1', 'book/add', '添加书籍[id:15]', '{\"data\":{\"name\":\"\\u4e09\\u5927\\u4e3b\\u4e49\",\"alias\":\"\\u5165\\u9879\\u4e3b\\u610f\",\"author_id\":\"4\",\"tags\":[\"1\"],\"isbn\":\"dd4232422\",\"source_id\":\"2\",\"end_status\":\"1\",\"image\":\"\",\"remark\":\"dfasdfasdfasdfasdfdfdf\",\"gather\":{\"gather_id\":[\"2\",\"2\"],\"list_url\":[\"dfasdfas\",\"dfasdfa\"],\"sort\":[\"231\",\"123\"]}}}', '2017-05-10 15:46:25', '2017-05-10 15:46:25');
INSERT INTO `handle_log` VALUES ('140', '1', 'book/add', '添加书籍[id:16]', '{\"data\":{\"name\":\"\\u56db\\u6c11\\u4e3b\\u4e49\",\"alias\":\"\\u56db\\u4e2a\\u5bb6\\u6c11\",\"author_id\":\"4\",\"tags\":[\"1\"],\"isbn\":\"\",\"source_id\":\"2\",\"end_status\":\"1\",\"image\":\"\",\"remark\":\"\\u5948\\u65affad\",\"gather\":{\"gather_id\":[\"3\",\"2\"],\"list_url\":[\"213dfasdfd\",\"dfasd\"],\"sort\":[\"232\",\"213123\"]}}}', '2017-05-10 16:01:38', '2017-05-10 16:01:38');
INSERT INTO `handle_log` VALUES ('141', '1', 'index/upload', '0', '[]', '2017-05-10 16:33:01', '2017-05-10 16:33:01');
INSERT INTO `handle_log` VALUES ('142', '1', 'book/add', '添加书籍[id:17]', '{\"data\":{\"name\":\"\\u4e94\\u82b1\\u5c40\\u5730\",\"alias\":\"\\u5c40\\u5730\",\"author_id\":\"4\",\"tags\":[\"1\"],\"isbn\":\"3324234d\",\"source_id\":\"2\",\"end_status\":\"1\",\"image\":\"\\/uploads\\/20170510\\\\7a57a4d907f9adeaa8f41b57e9689191.jpg\",\"remark\":\"dfsdfa\",\"gather\":{\"gather_id\":[\"3\",\"2\"],\"list_url\":[\"2323213\",\"123123\"],\"sort\":[\"12\",\"\"]}}}', '2017-05-10 16:33:10', '2017-05-10 16:33:10');
INSERT INTO `handle_log` VALUES ('143', '1', 'index/upload', '0', '[]', '2017-05-10 16:34:17', '2017-05-10 16:34:17');
INSERT INTO `handle_log` VALUES ('144', '1', 'book/add', '添加书籍[id:18]', '{\"data\":{\"name\":\"\\u4e09\\u6c11\\u4e3b\\u540c\",\"alias\":\"\\u540c\\u5fd7\",\"author_id\":\"4\",\"tags\":[\"1\"],\"isbn\":\"sdfsd342342\",\"source_id\":\"2\",\"end_status\":\"1\",\"image\":\"\\/uploads\\/20170510\\\\5c691bb24f4517d7ab7b0a2b219e8821.jpg\",\"remark\":\"sdfasdfasdf\",\"gather\":{\"gather_id\":[\"2\",\"3\"],\"list_url\":[\"rwerwerwr\",\"adfadsf\"],\"sort\":[\"3242134\",\"232\"]}}}', '2017-05-10 16:47:07', '2017-05-10 16:47:07');
INSERT INTO `handle_log` VALUES ('145', '1', 'index/upload', '0', '[]', '2017-05-10 16:48:06', '2017-05-10 16:48:06');
INSERT INTO `handle_log` VALUES ('146', '1', 'book/add', '添加书籍[id:19]', '{\"data\":{\"name\":\"\\u5929\\u5929\\u770b\\u4e66\",\"alias\":\"\\u770b\\u4e66\",\"author_id\":\"4\",\"tags\":[\"1\"],\"isbn\":\"23423423d\",\"source_id\":\"2\",\"end_status\":\"1\",\"image\":\"\\/uploads\\/20170510\\\\6f4a7f9b0194e05d4c00d360074da0dc.jpg\",\"remark\":\"\\u5948\\u65af\\u582a\",\"gather\":{\"gather_id\":[\"2\",\"3\"],\"list_url\":[\"213231dfdsfdsf\",\"dfsdfsd342342\"],\"sort\":[\"332\",\"2\"]}}}', '2017-05-10 16:48:17', '2017-05-10 16:48:17');
INSERT INTO `handle_log` VALUES ('147', '1', 'book/edit', '添加书籍[id:18]', '{\"data\":{\"name\":\"\\u4e09\\u6c11\\u4e3b\\u540c\",\"alias\":\"\\u540c\\u5fd7\",\"author_id\":\"4\",\"tags\":[\"1\"],\"isbn\":\"sdfsd342342\",\"source_id\":\"2\",\"end_status\":\"1\",\"image\":\"\",\"remark\":\"sdfasdfasdf\",\"gather\":{\"gather_id\":[\"2\",\"3\"],\"list_url\":[\"2312312\",\"2312313\"],\"sort\":[\"\",\"\"]}},\"id\":\"18\"}', '2017-05-10 16:55:45', '2017-05-10 16:55:45');
INSERT INTO `handle_log` VALUES ('148', '1', 'book/edit', '修改书籍[id:18]', '{\"data\":{\"name\":\"\\u4e09\\u6c11\\u4e3b\\u540c\",\"alias\":\"\\u540c\\u5fd7\",\"author_id\":\"4\",\"isbn\":\"sdfsd342342\",\"source_id\":\"2\",\"end_status\":\"1\",\"image\":\"\",\"remark\":\"sdfasdfasdf\",\"gather\":{\"gather_id\":[\"2\",\"3\"],\"list_url\":[\"2312312\",\"2312313\"],\"sort\":[\"\",\"\"]}},\"id\":\"18\"}', '2017-05-10 17:09:02', '2017-05-10 17:09:02');
INSERT INTO `handle_log` VALUES ('149', '1', 'index/upload', '0', '[]', '2017-05-10 17:10:49', '2017-05-10 17:10:49');
INSERT INTO `handle_log` VALUES ('150', '1', 'book/edit', '修改书籍[id:18]', '{\"data\":{\"name\":\"\\u4e09\\u6c11\\u4e3b\\u540c\",\"alias\":\"\\u540c\\u5fd7\",\"author_id\":\"4\",\"isbn\":\"sdfsd342342\",\"source_id\":\"2\",\"end_status\":\"1\",\"image\":\"\\/uploads\\/20170510\\\\497b182087e1c3206bc7f000cd430497.jpg\",\"remark\":\"sdfasdfasdf\",\"gather\":{\"gather_id\":[\"2\",\"3\"],\"list_url\":[\"2312312\",\"2312313\"],\"sort\":[\"\",\"\"]}},\"id\":\"18\"}', '2017-05-10 17:10:51', '2017-05-10 17:10:51');
INSERT INTO `handle_log` VALUES ('151', '1', 'book/edit', '修改书籍[id:18]', '{\"data\":{\"name\":\"\\u4e09\\u6c11\\u4e3b\\u540c\",\"alias\":\"\\u540c\\u5fd7\",\"author_id\":\"4\",\"tags\":[\"1\"],\"isbn\":\"sdfsd342342\",\"source_id\":\"2\",\"end_status\":\"1\",\"image\":\"\\/uploads\\/20170510\\\\497b182087e1c3206bc7f000cd430497.jpg\",\"remark\":\"sdfasdfasdf\",\"gather\":{\"gather_id\":[\"2\",\"3\"],\"list_url\":[\"2312312\",\"2312313\"],\"sort\":[\"\",\"\"]}},\"id\":\"18\"}', '2017-05-10 17:11:11', '2017-05-10 17:11:11');
INSERT INTO `handle_log` VALUES ('152', '1', 'book/destroy', '删除书籍[id:19]', '{\"id\":\"19\"}', '2017-05-10 17:28:58', '2017-05-10 17:28:58');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='部门表';

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('2', '用户管理', '管理后台用户', '2017-04-05 14:04:38', '2017-04-14 15:51:01');
INSERT INTO `role` VALUES ('3', '黄金无敌组', '这群人有很多黄金', '2017-04-05 16:39:50', '2017-04-14 15:22:40');
INSERT INTO `role` VALUES ('13', '妇女联盟', '妇女联盟', '2017-04-14 15:36:27', '2017-04-14 15:41:48');
INSERT INTO `role` VALUES ('14', '小便十分钟算', '小便十分钟算', '2017-05-08 14:19:10', '2017-05-08 14:19:10');
INSERT INTO `role` VALUES ('15', 'ddd', 'dddd', '2017-05-10 12:17:33', '2017-05-10 12:17:33');
INSERT INTO `role` VALUES ('16', 'dfadsfa', 'asdfasdf', '2017-05-10 12:24:54', '2017-05-10 12:24:54');

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
INSERT INTO `role_rule` VALUES ('13', '1');
INSERT INTO `role_rule` VALUES ('13', '3');
INSERT INTO `role_rule` VALUES ('13', '4');
INSERT INTO `role_rule` VALUES ('13', '8');
INSERT INTO `role_rule` VALUES ('13', '9');
INSERT INTO `role_rule` VALUES ('13', '10');
INSERT INTO `role_rule` VALUES ('13', '14');
INSERT INTO `role_rule` VALUES ('13', '15');
INSERT INTO `role_rule` VALUES ('13', '16');
INSERT INTO `role_rule` VALUES ('13', '17');
INSERT INTO `role_rule` VALUES ('13', '18');
INSERT INTO `role_rule` VALUES ('13', '19');
INSERT INTO `role_rule` VALUES ('13', '20');
INSERT INTO `role_rule` VALUES ('13', '21');
INSERT INTO `role_rule` VALUES ('13', '22');
INSERT INTO `role_rule` VALUES ('13', '23');
INSERT INTO `role_rule` VALUES ('14', '1');
INSERT INTO `role_rule` VALUES ('14', '3');
INSERT INTO `role_rule` VALUES ('14', '4');
INSERT INTO `role_rule` VALUES ('14', '8');
INSERT INTO `role_rule` VALUES ('14', '9');
INSERT INTO `role_rule` VALUES ('14', '10');
INSERT INTO `role_rule` VALUES ('14', '14');
INSERT INTO `role_rule` VALUES ('14', '15');
INSERT INTO `role_rule` VALUES ('14', '16');
INSERT INTO `role_rule` VALUES ('14', '17');
INSERT INTO `role_rule` VALUES ('14', '18');
INSERT INTO `role_rule` VALUES ('15', '1');
INSERT INTO `role_rule` VALUES ('15', '3');
INSERT INTO `role_rule` VALUES ('15', '4');
INSERT INTO `role_rule` VALUES ('15', '8');
INSERT INTO `role_rule` VALUES ('15', '9');
INSERT INTO `role_rule` VALUES ('15', '10');
INSERT INTO `role_rule` VALUES ('15', '14');
INSERT INTO `role_rule` VALUES ('15', '15');
INSERT INTO `role_rule` VALUES ('15', '16');
INSERT INTO `role_rule` VALUES ('15', '17');
INSERT INTO `role_rule` VALUES ('15', '18');
INSERT INTO `role_rule` VALUES ('16', '1');
INSERT INTO `role_rule` VALUES ('16', '3');
INSERT INTO `role_rule` VALUES ('16', '4');
INSERT INTO `role_rule` VALUES ('16', '8');
INSERT INTO `role_rule` VALUES ('16', '9');
INSERT INTO `role_rule` VALUES ('16', '10');
INSERT INTO `role_rule` VALUES ('16', '14');
INSERT INTO `role_rule` VALUES ('16', '15');
INSERT INTO `role_rule` VALUES ('16', '16');
INSERT INTO `role_rule` VALUES ('16', '17');
INSERT INTO `role_rule` VALUES ('16', '18');

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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='权限&菜单表';

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
INSERT INTO `rule` VALUES ('11', '5', 'role/add', '添加分组', '0', '1', '', '1', '1', '3', '2017-04-06 09:59:33', '2017-05-08 14:19:47');
INSERT INTO `rule` VALUES ('12', '5', 'role/edit', '修改分组', '0', '1', '', '2', '1', '3', '2017-04-06 10:53:43', '2017-05-08 14:19:36');
INSERT INTO `rule` VALUES ('13', '5', 'role/destroy', '删除分组', '0', '1', '', '3', '1', '3', '2017-04-06 10:54:41', '2017-05-08 14:19:27');
INSERT INTO `rule` VALUES ('14', '4', 'user/allot', '分配用户权限', '0', '1', '', '5', '0', '3', '2017-04-08 09:49:49', '2017-04-08 09:49:49');
INSERT INTO `rule` VALUES ('15', '4', 'user/add', '添加用户', '0', '1', '', '2', '0', '3', '2017-04-08 09:51:40', '2017-04-08 09:51:40');
INSERT INTO `rule` VALUES ('16', '4', 'user/edit', '修改用户', '0', '1', '', '3', '0', '3', '2017-04-08 09:52:04', '2017-04-08 09:52:31');
INSERT INTO `rule` VALUES ('17', '4', 'user/status', '禁用用户', '0', '1', '', '5', '0', '3', '2017-04-08 09:55:44', '2017-04-08 09:55:44');
INSERT INTO `rule` VALUES ('18', '8', 'index/log', '操作日志', '1', '0', '', '2', '0', '2', '2017-04-12 17:40:07', '2017-04-12 17:41:26');
INSERT INTO `rule` VALUES ('19', '0', 'book', '书籍管理', '1', '0', '', '2', '1', '1', '2017-05-08 17:03:04', '2017-05-08 17:03:04');
INSERT INTO `rule` VALUES ('20', '19', 'book/index', '书籍列表', '1', '0', '', '1', '1', '2', '2017-05-08 17:03:28', '2017-05-08 17:03:28');
INSERT INTO `rule` VALUES ('21', '20', 'book/add', '添加书籍', '0', '0', '', '255', '1', '3', '2017-05-08 17:05:51', '2017-05-08 17:05:51');
INSERT INTO `rule` VALUES ('22', '20', 'book/edit', '修改书籍', '0', '0', '', '255', '1', '3', '2017-05-08 17:06:12', '2017-05-08 17:17:39');
INSERT INTO `rule` VALUES ('23', '20', 'book/destroy', '删除书籍', '0', '0', '', '255', '1', '3', '2017-05-08 17:07:01', '2017-05-08 17:07:01');
INSERT INTO `rule` VALUES ('24', '19', 'tags/index', '书籍标签', '1', '0', '', '2', '1', '2', '2017-05-08 17:19:53', '2017-05-08 17:19:53');
INSERT INTO `rule` VALUES ('25', '24', 'tags/add', '添加标签', '0', '0', '', '255', '1', '3', '2017-05-08 17:20:20', '2017-05-08 17:20:20');
INSERT INTO `rule` VALUES ('26', '24', 'tags/edit', '修改标签', '0', '0', '', '255', '1', '3', '2017-05-08 17:20:59', '2017-05-08 17:20:59');
INSERT INTO `rule` VALUES ('27', '24', 'tags/status', '删除标签', '0', '0', '', '255', '1', '3', '2017-05-08 17:21:22', '2017-05-08 17:21:22');
INSERT INTO `rule` VALUES ('28', '19', 'author/index', '书籍作者', '1', '0', '', '3', '1', '2', '2017-05-08 17:21:54', '2017-05-09 10:23:02');
INSERT INTO `rule` VALUES ('30', '28', 'author/add', '添加作者', '0', '0', '', '255', '1', '3', '2017-05-08 17:24:00', '2017-05-08 17:24:00');
INSERT INTO `rule` VALUES ('31', '28', 'author/edit', '修改作者', '0', '0', '', '255', '1', '3', '2017-05-08 17:23:13', '2017-05-08 17:23:13');
INSERT INTO `rule` VALUES ('32', '28', 'author/destroy', '删除作者', '0', '0', '', '255', '1', '3', '2017-05-08 17:29:27', '2017-05-08 17:29:27');
INSERT INTO `rule` VALUES ('33', '19', 'source/index', '书籍来源', '1', '0', '', '4', '1', '2', '2017-05-08 17:31:59', '2017-05-09 10:22:40');
INSERT INTO `rule` VALUES ('34', '33', 'source/add', '添加来源', '0', '0', '', '255', '1', '3', '2017-05-08 17:24:00', '2017-05-08 17:24:00');
INSERT INTO `rule` VALUES ('35', '33', 'source/edit', '修改来源', '0', '0', '', '255', '1', '3', '2017-05-08 17:23:13', '2017-05-08 17:23:13');
INSERT INTO `rule` VALUES ('36', '33', 'source/destroy', '删除来源', '0', '0', '', '255', '1', '3', '2017-05-08 17:29:27', '2017-05-08 17:29:27');
INSERT INTO `rule` VALUES ('37', '19', 'gather/index', '采集列表', '1', '0', '', '255', '1', '2', '2017-05-08 17:35:25', '2017-05-09 10:22:23');
INSERT INTO `rule` VALUES ('38', '37', 'gather/add', '添加采集', '0', '0', '', '255', '1', '3', '2017-05-08 17:24:00', '2017-05-08 17:24:00');
INSERT INTO `rule` VALUES ('39', '37', 'gather/edit', '修改采集', '0', '0', '', '255', '1', '3', '2017-05-08 17:23:13', '2017-05-08 17:23:13');
INSERT INTO `rule` VALUES ('40', '37', 'gather/destroy', '删除采集', '0', '0', '', '255', '1', '3', '2017-05-08 17:29:27', '2017-05-08 17:29:27');

-- ----------------------------
-- Table structure for source
-- ----------------------------
DROP TABLE IF EXISTS `source`;
CREATE TABLE `source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '名称',
  `url` varchar(255) NOT NULL COMMENT '网址',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0关闭 1开启',
  `remark` varchar(255) DEFAULT NULL COMMENT '说明',
  `create_time` datetime DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `source_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='来源';

-- ----------------------------
-- Records of source
-- ----------------------------
INSERT INTO `source` VALUES ('2', '顶点小说', 'http://www.23us.com/', '1', '顶点小说致力于打造无广告无弹窗的在线小说阅读网站，提供小说在线阅读，小说TXT下载，网站没有弹窗广告页面简洁。', '2017-05-09 17:49:32', '2017-05-09 17:49:32');

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '标签名称',
  `en_name` varchar(50) NOT NULL COMMENT '英文名称（用于url）',
  `remark` varchar(255) DEFAULT NULL COMMENT '说明',
  `create_time` datetime DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='书籍标签表';

-- ----------------------------
-- Records of tags
-- ----------------------------
INSERT INTO `tags` VALUES ('1', '仙侠', 'xianxia', '仙侠是一些修仙成神的小说', '2017-05-10 10:21:26', '2017-05-10 10:27:22');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin@admin.com', 'fcea920f7412b5da7be0cf42b8c93759', '0', '0', '超管', '18526232020', '1', '127.0.0.1', '2017-05-10 09:31:05', '2017-03-22 10:35:17', '2017-05-10 09:31:05');
INSERT INTO `user` VALUES ('2', 'canglaoshi@admin.com', '670b14728ad9902aecba32e22fa4f6bd', '2', '0', '仓井空', null, '0', null, null, '2017-04-06 12:03:12', '2017-05-09 14:49:21');
INSERT INTO `user` VALUES ('3', 'xixi@admin.com', 'e10adc3949ba59abbe56e057f20f883e', '2', '0', '纱纱相', null, '1', null, null, '2017-04-06 17:20:17', '2017-04-06 17:30:52');
INSERT INTO `user` VALUES ('4', 'sb112@admin.com', '4297f44b13955235245b2497399d7a93', '3', '0', '黄育佳', null, '1', null, null, '2017-04-14 15:07:47', '2017-04-14 15:08:11');
INSERT INTO `user` VALUES ('5', 'wutenglang@11.com', 'e10adc3949ba59abbe56e057f20f883e', '13', '0', '武藤兰', null, '1', null, null, '2017-05-08 14:17:22', '2017-05-08 14:17:22');

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
