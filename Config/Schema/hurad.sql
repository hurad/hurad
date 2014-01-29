

DROP TABLE IF EXISTS `$[prefix]categories`;
DROP TABLE IF EXISTS `$[prefix]categories_posts`;
DROP TABLE IF EXISTS `$[prefix]comments`;
DROP TABLE IF EXISTS `$[prefix]links`;
DROP TABLE IF EXISTS `$[prefix]media`;
DROP TABLE IF EXISTS `$[prefix]menus`;
DROP TABLE IF EXISTS `$[prefix]options`;
DROP TABLE IF EXISTS `$[prefix]post_meta`;
DROP TABLE IF EXISTS `$[prefix]posts`;
DROP TABLE IF EXISTS `$[prefix]posts_tags`;
DROP TABLE IF EXISTS `$[prefix]tags`;
DROP TABLE IF EXISTS `$[prefix]user_meta`;
DROP TABLE IF EXISTS `$[prefix]users`;


CREATE TABLE `$[prefix]categories` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) unsigned DEFAULT NULL,
	`name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`slug` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`lft` bigint(20) unsigned NOT NULL,
	`rght` bigint(20) unsigned NOT NULL,
	`description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`post_count` int(11) unsigned NOT NULL,
	`path` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `slug` (`slug`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `$[prefix]categories_posts` (
	`category_id` bigint(20) unsigned NOT NULL,
	`post_id` bigint(20) unsigned NOT NULL,	PRIMARY KEY  (`category_id`, `post_id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `$[prefix]comments` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) unsigned DEFAULT NULL,
	`post_id` bigint(20) unsigned NOT NULL,
	`user_id` bigint(20) unsigned DEFAULT 0 NOT NULL,
	`author` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`author_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`author_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`author_ip` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '2' COMMENT 'trash, spam, pending, approved',
	`agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`lft` bigint(20) unsigned NOT NULL,
	`rght` bigint(20) unsigned NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `$[prefix]links` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) unsigned DEFAULT NULL,
	`menu_id` bigint(20) unsigned NOT NULL,
	`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`target` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`rel` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`visible` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`rating` int(11) unsigned NULL DEFAULT NULL,
	`lft` bigint(20) unsigned NOT NULL,
	`rght` bigint(20) unsigned NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `$[prefix]media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Generated name with extension',
  `original_name` varchar(255) NOT NULL COMMENT 'Original name with extension',
  `mime_type` varchar(255) NOT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `extension` varchar(5) NOT NULL,
  `path` varchar(12) NOT NULL,
  `web_path` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `$[prefix]menus` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`link_count` int(11) unsigned NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `slug` (`slug`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `$[prefix]options` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `name` (`name`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `$[prefix]post_meta` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`post_id` bigint(20) unsigned DEFAULT 0 NOT NULL,
	`meta_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`meta_value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `$[prefix]posts` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) unsigned DEFAULT NULL,
	`user_id` bigint(20) NOT NULL,
	`title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`slug` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`excerpt` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`status` tinyint(2) unsigned NOT NULL DEFAULT '3' COMMENT 'trash, draft, pending, publish',
	`comment_status` tinyint(2) unsigned NOT NULL DEFAULT '2' COMMENT 'disable, close, open',
	`comment_count` int(11) unsigned NOT NULL,
	`type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`lft` bigint(20) unsigned NOT NULL,
	`rght` bigint(20) unsigned NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `$[prefix]posts_tags` (
	`post_id` bigint(20) unsigned NOT NULL,
	`tag_id` bigint(20) unsigned NOT NULL,	PRIMARY KEY  (`post_id`, `tag_id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `$[prefix]tags` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`slug` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`post_count` int(11) unsigned NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `slug` (`slug`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `$[prefix]user_meta` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) unsigned DEFAULT 0 NOT NULL,
	`meta_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`meta_value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `$[prefix]users` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`username` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`role` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`status` int(11) unsigned NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

