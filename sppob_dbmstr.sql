/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : sppob_dbmstr

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-07-10 16:28:33
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `cache`
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cache_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for `clients`
-- ----------------------------
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_source` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of clients
-- ----------------------------
INSERT INTO `clients` VALUES ('1', 'Bank BCA', 'bankbca', 'YjRuazhjNA==', '172.0.0.1', 'active', '2020-07-07 09:17:44', '2020-07-07 09:17:44', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `clients` VALUES ('2', 'Bank BRI', 'bankbri', 'YjRuazhyMQ==', '172.0.0.1', 'active', '2020-07-07 09:17:44', '2020-07-07 09:17:44', 'Administrator - admin.sppob@sprintasia.co.id');

-- ----------------------------
-- Table structure for `failed_jobs`
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2019_08_19_000000_create_failed_jobs_table', '1');
INSERT INTO `migrations` VALUES ('4', '2019_11_09_024842_laratrust_setup_tables', '1');
INSERT INTO `migrations` VALUES ('5', '2019_11_09_031904_create_product_types_table', '1');
INSERT INTO `migrations` VALUES ('6', '2019_11_09_031920_create_product_categories_table', '1');
INSERT INTO `migrations` VALUES ('7', '2019_11_09_031936_create_product_vendors_table', '1');
INSERT INTO `migrations` VALUES ('8', '2019_11_09_031949_create_products_table', '1');
INSERT INTO `migrations` VALUES ('9', '2019_12_12_155825_create_clients_table', '1');
INSERT INTO `migrations` VALUES ('10', '2019_12_16_160621_update_role_users', '1');
INSERT INTO `migrations` VALUES ('11', '2019_12_16_160638_update_roles', '1');
INSERT INTO `migrations` VALUES ('12', '2020_02_19_112852_create_caches_table', '1');
INSERT INTO `migrations` VALUES ('13', '2020_02_28_155701_create_response_table', '1');

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------

-- ----------------------------
-- Table structure for `permission_role`
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permission_role
-- ----------------------------

-- ----------------------------
-- Table structure for `permission_user`
-- ----------------------------
DROP TABLE IF EXISTS `permission_user`;
CREATE TABLE `permission_user` (
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  KEY `permission_user_permission_id_foreign` (`permission_id`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permission_user
-- ----------------------------

-- ----------------------------
-- Table structure for `products`
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_type` bigint(20) unsigned NOT NULL,
  `id_category` bigint(20) unsigned NOT NULL,
  `id_vendor` bigint(20) unsigned NOT NULL,
  `product_code` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_product_code` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `denomination` double NOT NULL,
  `product_price` double NOT NULL,
  `vendor_product_price` double NOT NULL,
  `discount_type` enum('none','discount','price cut','cashback') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `discount_value` bigint(20) NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_product_code_vendor_product_code_unique` (`product_code`,`vendor_product_code`),
  KEY `products_id_type_foreign` (`id_type`),
  KEY `products_id_category_foreign` (`id_category`),
  KEY `products_id_vendor_foreign` (`id_vendor`),
  CONSTRAINT `products_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `products_id_type_foreign` FOREIGN KEY (`id_type`) REFERENCES `product_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `products_id_vendor_foreign` FOREIGN KEY (`id_vendor`) REFERENCES `product_vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', '1', '1', '1', '1', '1', 'TSEL5', '1', '1', '1', 'none', '1', 'active', '2020-07-07 09:17:43', '2020-07-07 09:17:43', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `products` VALUES ('2', '1', '1', '1', '1', '2', 'TSEL10', '1', '1', '1', 'none', '1', 'active', '2020-07-07 09:17:43', '2020-07-07 09:17:43', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `products` VALUES ('3', '1', '1', '1', '1', '3', 'TSEL20', '1', '1', '1', 'none', '1', 'active', '2020-07-07 09:17:43', '2020-07-07 09:17:43', 'Administrator - admin.sppob@sprintasia.co.id');

-- ----------------------------
-- Table structure for `product_category`
-- ----------------------------
DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_type_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_category_product_type_id_foreign` (`product_type_id`),
  CONSTRAINT `product_category_product_type_id_foreign` FOREIGN KEY (`product_type_id`) REFERENCES `product_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product_category
-- ----------------------------
INSERT INTO `product_category` VALUES ('1', '1', 'Telkomsel 5000', 'active', '2020-07-07 09:17:41', '2020-07-07 09:17:41', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_category` VALUES ('2', '1', 'Telkomsel 10000', 'active', '2020-07-07 09:17:42', '2020-07-07 09:17:42', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_category` VALUES ('3', '1', 'Telkomsel 25000', 'active', '2020-07-07 09:17:42', '2020-07-07 09:17:42', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_category` VALUES ('4', '1', 'Telkomsel 50000', 'active', '2020-07-07 09:17:42', '2020-07-07 09:17:42', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_category` VALUES ('5', '1', 'Indosat 5000', 'active', '2020-07-07 09:17:42', '2020-07-07 09:17:42', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_category` VALUES ('6', '1', 'Indosat 10000', 'active', '2020-07-07 09:17:42', '2020-07-07 09:17:42', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_category` VALUES ('7', '1', 'Indosat 25000', 'active', '2020-07-07 09:17:42', '2020-07-07 09:17:42', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_category` VALUES ('8', '1', 'Indosat 50000', 'active', '2020-07-07 09:17:42', '2020-07-07 09:17:42', 'Administrator - admin.sppob@sprintasia.co.id');

-- ----------------------------
-- Table structure for `product_type`
-- ----------------------------
DROP TABLE IF EXISTS `product_type`;
CREATE TABLE `product_type` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product_type
-- ----------------------------
INSERT INTO `product_type` VALUES ('1', 'Pembelian Pulsa Prepaid', 'active', '2020-07-07 09:17:41', '2020-07-07 09:17:41', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_type` VALUES ('2', 'Pembelian PLN Prepaid', 'active', '2020-07-07 09:17:41', '2020-07-07 09:17:41', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_type` VALUES ('3', 'Pembelian Paket Data', 'active', '2020-07-07 09:17:41', '2020-07-07 09:17:41', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_type` VALUES ('4', 'Pembelian Voucher Game', 'active', '2020-07-07 09:17:41', '2020-07-07 09:17:41', 'Administrator - admin.sppob@sprintasia.co.id');

-- ----------------------------
-- Table structure for `product_vendor`
-- ----------------------------
DROP TABLE IF EXISTS `product_vendor`;
CREATE TABLE `product_vendor` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `protocol` enum('http','https') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'http',
  `method` enum('get','post','put','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'get',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_type` enum('form','formencode','raw') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'form',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorization` enum('basic','key','token') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `params_auth` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `header` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'inactive',
  `contype` enum('close','alive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `timeout` int(11) NOT NULL DEFAULT 30,
  `separator` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `success_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product_vendor
-- ----------------------------
INSERT INTO `product_vendor` VALUES ('1', 'Butraco1', 'http', 'post', 'http://localhost', 'formencode', 'u=@u@&p=@p@', 'basic', 'u=@u@&p=@p@', 'active', 'close', '30', ';', '0,1', '2,3', '400', 'active', '2020-07-07 09:17:42', '2020-07-07 09:17:42', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_vendor` VALUES ('2', 'Butraco2', 'http', 'post', 'http://localhost', 'formencode', 'u=@u@&p=@p@', 'basic', 'u=@u@&p=@p@', 'active', 'close', '30', ';', '0,1', '2,3', '300', 'active', '2020-07-07 09:17:42', '2020-07-07 09:17:42', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_vendor` VALUES ('3', 'Butraco3', 'http', 'post', 'http://localhost', 'formencode', 'u=@u@&p=@p@', 'basic', 'u=@u@&p=@p@', 'active', 'close', '30', ';', '0,1', '2,3', '400', 'active', '2020-07-07 09:17:43', '2020-07-07 09:17:43', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `product_vendor` VALUES ('4', 'Butraco4', 'http', 'post', 'http://localhost', 'formencode', 'u=@u@&p=@p@', 'basic', 'u=@u@&p=@p@', 'active', 'close', '30', ';', '0,1', '2,3', '100', 'active', '2020-07-07 09:17:43', '2020-07-07 09:17:43', 'Administrator - admin.sppob@sprintasia.co.id');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'Administrator', 'Administrator', null, 'active', '2020-07-07 09:17:38', '2020-07-07 09:17:38', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `roles` VALUES ('2', 'Approver', 'Approver', null, 'active', '2020-07-07 09:17:39', '2020-07-07 09:17:39', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `roles` VALUES ('3', 'Checker', 'Checker', null, 'active', '2020-07-07 09:17:39', '2020-07-07 09:17:39', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `roles` VALUES ('4', 'Maker', 'Maker', null, 'active', '2020-07-07 09:17:39', '2020-07-07 09:17:39', 'Administrator - admin.sppob@sprintasia.co.id');

-- ----------------------------
-- Table structure for `role_user`
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_user_role_id_user_id_unique` (`role_id`,`user_id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_user
-- ----------------------------
INSERT INTO `role_user` VALUES ('1', '1', '1', 'App\\User', 'active', '2020-07-07 09:17:44', '2020-07-07 09:17:44', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `role_user` VALUES ('2', '2', '2', 'App\\User', 'active', '2020-07-07 09:17:44', '2020-07-07 09:17:44', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `role_user` VALUES ('3', '3', '3', 'App\\User', 'active', '2020-07-07 09:17:44', '2020-07-07 09:17:44', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `role_user` VALUES ('4', '4', '4', 'App\\User', 'active', '2020-07-07 09:17:44', '2020-07-07 09:17:44', 'Administrator - admin.sppob@sprintasia.co.id');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Administrator', 'admin.sppob@sprintasia.co.id', null, '$2y$10$SXXnidE6HiD.y3OWp2Vm4.aDPVQ8.eXM73po3bykR3YIX9IuJ1sgK', null, 'active', '2020-07-07 09:17:40', '2020-07-07 09:17:40', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `users` VALUES ('2', 'Approver', 'approve.sppob@sprintasia.co.id', null, '$2y$10$fPsf1SKdGmV/kHwel3Sh9.k56Hxcp5blmXiBjZm3ipnbwV55.UC5m', null, 'active', '2020-07-07 09:17:40', '2020-07-07 09:17:40', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `users` VALUES ('3', 'Checker', 'check.sppob@sprintasia.co.id', null, '$2y$10$AMdzmXHGUGkYrLBfu6MdHuw7IakK3aBtEahBiduu6q6u4Aha408Ei', null, 'active', '2020-07-07 09:17:40', '2020-07-07 09:17:40', 'Administrator - admin.sppob@sprintasia.co.id');
INSERT INTO `users` VALUES ('4', 'Maker', 'make.sppob@sprintasia.co.id', null, '$2y$10$TzeLatn7y92avR5Ch.7uJOA24VwOy0bv2KR8MdQbhWYcQqJLvRlcS', null, 'active', '2020-07-07 09:17:40', '2020-07-07 09:17:40', 'Administrator - admin.sppob@sprintasia.co.id');

-- ----------------------------
-- Table structure for `vendor_response`
-- ----------------------------
DROP TABLE IF EXISTS `vendor_response`;
CREATE TABLE `vendor_response` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_vendor_id` int(11) NOT NULL,
  `response_code` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of vendor_response
-- ----------------------------
sppob_dbmstr