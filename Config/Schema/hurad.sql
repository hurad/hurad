

DROP TABLE IF EXISTS `hr_categories`;
DROP TABLE IF EXISTS `hr_categories_posts`;
DROP TABLE IF EXISTS `hr_comments`;
DROP TABLE IF EXISTS `hr_links`;
DROP TABLE IF EXISTS `hr_menus`;
DROP TABLE IF EXISTS `hr_options`;
DROP TABLE IF EXISTS `hr_post_metas`;
DROP TABLE IF EXISTS `hr_posts`;
DROP TABLE IF EXISTS `hr_posts_tags`;
DROP TABLE IF EXISTS `hr_tags`;
DROP TABLE IF EXISTS `hr_user_metas`;
DROP TABLE IF EXISTS `hr_users`;


CREATE TABLE `hr_categories` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) DEFAULT NULL,
	`name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`slug` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`lft` int(11) NOT NULL,
	`rght` int(11) NOT NULL,
	`description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`post_count` int(11) NOT NULL,
	`path` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `slug` (`slug`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `hr_categories_posts` (
	`category_id` int(11) NOT NULL,
	`post_id` int(11) NOT NULL,	PRIMARY KEY  (`category_id`, `post_id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `hr_comments` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) DEFAULT NULL,
	`post_id` bigint(20) NOT NULL,
	`user_id` bigint(20) DEFAULT 0 NOT NULL,
	`author` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`author_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`author_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`author_ip` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`approved` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`lft` int(11) NOT NULL,
	`rght` int(11) NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `hr_links` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`parent_id` int(11) DEFAULT NULL,
	`menu_id` int(11) NOT NULL,
	`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`target` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`rel` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`visible` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`rating` int(11) NOT NULL,
	`lft` int(11) NOT NULL,
	`rght` int(11) NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `hr_menus` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`link_count` int(11) NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `slug` (`slug`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `hr_options` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `name` (`name`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `hr_post_metas` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`post_id` bigint(20) DEFAULT 0 NOT NULL,
	`meta_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`meta_value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `hr_posts` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) DEFAULT NULL,
	`user_id` bigint(20) NOT NULL,
	`title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`slug` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`excerpt` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`status` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`comment_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`comment_count` int(11) NOT NULL,
	`type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`lft` int(11) NOT NULL,
	`rght` int(11) NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `hr_posts_tags` (
	`post_id` int(11) NOT NULL,
	`tag_id` int(11) NOT NULL,	PRIMARY KEY  (`post_id`, `tag_id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `hr_tags` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`slug` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`post_count` int(11) NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `slug` (`slug`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `hr_user_metas` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) DEFAULT 0 NOT NULL,
	`meta_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`meta_value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `hr_users` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`username` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`nicename` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`role` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`status` int(11) NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

