
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'administrators', '网站管理员', '网站管理员', '0000-00-00 00:00:00', '0000-00-00 00:00:00');


DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`),
  KEY `permissions_pid_index` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('7', '0', 'login_user', '后台登录', '后台登录', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('8', '0', 'navigation', '后台导航管理', '后台导航管理', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('9', '8', 'admin.rbac.navigation.index', '后台导航列表', '查看所有后台导航控制器', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('10', '8', 'admin.rbac.navigation.create', '添加后台导航页面', '添加后台导航页面', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('11', '8', 'admin.rbac.navigation.store', '添加后台导航', '添加后台导航', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('12', '8', 'admin.rbac.navigation.edit', '修改后台导航页面', '修改后台导航页面', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('13', '8', 'admin.rbac.navigation.update', '修改后台导航', '提交修改后台导航', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('14', '8', 'admin.rbac.navigation.destroy', '删除后台导航', '删除后台导航', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('15', '0', 'roles', '角色管理', '角色管理', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('16', '15', 'admin.rbac.roles.index', '角色列表', '查看所有角色控制器', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('17', '15', 'admin.rbac.roles.create', '添加角色页面', '添加角色页面', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('18', '15', 'admin.rbac.roles.store', '添加角色', '添加角色', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('19', '15', 'admin.rbac.roles.edit', '修改角色页面', '修改角色页面', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('20', '15', 'admin.rbac.roles.update', '修改角色', '提交修改角色', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('21', '15', 'admin.rbac.roles.destroy', '删除角色', '删除角色', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('22', '0', 'manage', '管理员', '管理员', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('23', '22', 'admin.rbac.manage.index', '管理员列表', '查看所有管理员控制器', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('24', '22', 'admin.rbac.manage.create', '添加管理员页面', '添加管理员页面', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('25', '22', 'admin.rbac.manage.store', '添加管理员', '添加管理员', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('26', '22', 'admin.rbac.manage.edit', '修改管理员页面', '修改管理员页面', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('27', '22', 'admin.rbac.manage.update', '修改管理员', '提交修改管理员', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('28', '22', 'admin.rbac.manage.destroy', '删除管理员', '删除管理员', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('29', '0', 'permission', '权限资源', '权限资源', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('30', '29', 'admin.rbac.permission.index', '权限列表', '查看所有权限控制器', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('31', '29', 'admin.rbac.permission.create', '添加权限页面', '添加权限页面', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('32', '29', 'admin.rbac.permission.store', '添加权限', '添加权限', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('33', '29', 'admin.rbac.permission.edit', '修改权限页面', '修改权限页面', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('34', '29', 'admin.rbac.permission.update', '修改权限', '提交修改权限', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('35', '29', 'admin.rbac.permission.destroy', '删除权限', '删除权限', '0000-00-00 00:00:00', '0000-00-00 00:00:00');


-- ----------------------------
-- Table structure for manages
-- ----------------------------
DROP TABLE IF EXISTS `manages`;
CREATE TABLE `manages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `manages_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of manages
-- ----------------------------
INSERT INTO `manages` VALUES ('1', 'admin', 'luffyzhao@vip.126.com', '$2y$10$eGKdEUHLhJ/Z3DUhpvUWQ.RHzbmWcweZ90jAgbox1xSMeIB7WBM/S', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');


-- ----------------------------
-- Table structure for navigation
-- ----------------------------
DROP TABLE IF EXISTS `navigation`;
CREATE TABLE `navigation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` tinyint(4) NOT NULL,
  `roles` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `navigation_pid_index` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of navigation
-- ----------------------------
INSERT INTO `navigation` VALUES ('1', '0', '系统设置', '#', '0', '');
INSERT INTO `navigation` VALUES ('2', '1', '权限管理', '#', '0', '');
INSERT INTO `navigation` VALUES ('3', '2', '导航管理', '/admin/rbac/navigation', '0', '');
INSERT INTO `navigation` VALUES ('4', '2', '管理员', '/admin/rbac/manage', '0', '');
INSERT INTO `navigation` VALUES ('5', '2', '角色', '/admin/rbac/roles', '0', '');
INSERT INTO `navigation` VALUES ('6', '2', '权限资源', '/admin/rbac/permission', '0', '');


-- ----------------------------
-- Table structure for roles_navigation
-- ----------------------------
DROP TABLE IF EXISTS `roles_navigation`;
CREATE TABLE `roles_navigation` (
  `role_id` int(10) unsigned NOT NULL,
  `navigation_id` int(10) unsigned NOT NULL,
  KEY `roles_navigation_role_id_foreign` (`role_id`),
  KEY `roles_navigation_navigation_id_foreign` (`navigation_id`),
  CONSTRAINT `roles_navigation_navigation_id_foreign` FOREIGN KEY (`navigation_id`) REFERENCES `navigation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `roles_navigation_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles_navigation
-- ----------------------------
INSERT INTO `roles_navigation` VALUES ('1', '1');
INSERT INTO `roles_navigation` VALUES ('1', '2');
INSERT INTO `roles_navigation` VALUES ('1', '4');
INSERT INTO `roles_navigation` VALUES ('1', '5');
INSERT INTO `roles_navigation` VALUES ('1', '6');
INSERT INTO `roles_navigation` VALUES ('1', '3');

-- ----------------------------
-- Table structure for role_manages
-- ----------------------------
DROP TABLE IF EXISTS `role_manages`;
CREATE TABLE `role_manages` (
  `manage_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`manage_id`,`role_id`),
  KEY `role_manages_role_id_foreign` (`role_id`),
  CONSTRAINT `role_manages_manage_id_foreign` FOREIGN KEY (`manage_id`) REFERENCES `manages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_manages_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of role_manages
-- ----------------------------
INSERT INTO `role_manages` VALUES ('1', '1');

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('7', '1');
INSERT INTO `permission_role` VALUES ('9', '1');
INSERT INTO `permission_role` VALUES ('10', '1');
INSERT INTO `permission_role` VALUES ('11', '1');
INSERT INTO `permission_role` VALUES ('12', '1');
INSERT INTO `permission_role` VALUES ('13', '1');
INSERT INTO `permission_role` VALUES ('14', '1');
INSERT INTO `permission_role` VALUES ('16', '1');
INSERT INTO `permission_role` VALUES ('17', '1');
INSERT INTO `permission_role` VALUES ('18', '1');
INSERT INTO `permission_role` VALUES ('19', '1');
INSERT INTO `permission_role` VALUES ('20', '1');
INSERT INTO `permission_role` VALUES ('21', '1');
INSERT INTO `permission_role` VALUES ('23', '1');
INSERT INTO `permission_role` VALUES ('24', '1');
INSERT INTO `permission_role` VALUES ('25', '1');
INSERT INTO `permission_role` VALUES ('26', '1');
INSERT INTO `permission_role` VALUES ('27', '1');
INSERT INTO `permission_role` VALUES ('28', '1');
INSERT INTO `permission_role` VALUES ('30', '1');
INSERT INTO `permission_role` VALUES ('31', '1');
INSERT INTO `permission_role` VALUES ('32', '1');
INSERT INTO `permission_role` VALUES ('33', '1');
INSERT INTO `permission_role` VALUES ('34', '1');
INSERT INTO `permission_role` VALUES ('35', '1');
