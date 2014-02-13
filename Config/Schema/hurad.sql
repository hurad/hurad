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
  `id`          BIGINT(20) UNSIGNED     NOT NULL AUTO_INCREMENT,
  `parent_id`   BIGINT(20) UNSIGNED DEFAULT NULL,
  `name`        VARCHAR(200)
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `slug`        VARCHAR(200)
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `lft`         BIGINT(20) UNSIGNED     NOT NULL,
  `rght`        BIGINT(20) UNSIGNED     NOT NULL,
  `description` LONGTEXT
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `post_count`  INT(11) UNSIGNED        NOT NULL,
  `path`        VARCHAR(250)
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `created`     DATETIME                NOT NULL,
  `modified`    DATETIME                NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `CATEGORIES_SLUG_UNIQUE` (`slug`))
  DEFAULT CHARSET =utf8,
  COLLATE =utf8_general_ci,
  ENGINE =InnoDB;

CREATE TABLE `$[prefix]categories_posts` (
  `category_id` BIGINT(20) UNSIGNED NOT NULL,
  `post_id`     BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`category_id`, `post_id`))
  DEFAULT CHARSET =utf8,
  COLLATE =utf8_general_ci,
  ENGINE =InnoDB;

CREATE TABLE `$[prefix]comments` (
  `id`           BIGINT(20) UNSIGNED           NOT NULL AUTO_INCREMENT,
  `parent_id`    BIGINT(20) UNSIGNED DEFAULT NULL,
  `post_id`      BIGINT(20) UNSIGNED           NOT NULL,
  `user_id`      BIGINT(20) UNSIGNED DEFAULT 0 NOT NULL,
  `author`       VARCHAR(255)
                 CHARACTER SET utf8
                 COLLATE utf8_general_ci       NOT NULL,
  `author_email` VARCHAR(100)
                 CHARACTER SET utf8
                 COLLATE utf8_general_ci       NOT NULL,
  `author_url`   VARCHAR(200)
                 CHARACTER SET utf8
                 COLLATE utf8_general_ci       NOT NULL,
  `author_ip`    VARCHAR(100)
                 CHARACTER SET utf8
                 COLLATE utf8_general_ci       NOT NULL,
  `content`      LONGTEXT
                 CHARACTER SET utf8
                 COLLATE utf8_general_ci       NOT NULL,
  `status`       TINYINT(2) UNSIGNED           NOT NULL DEFAULT '2'
  COMMENT 'trash, spam, pending, approved',
  `agent`        TEXT
                 CHARACTER SET utf8
                 COLLATE utf8_general_ci       NOT NULL,
  `lft`          BIGINT(20) UNSIGNED           NOT NULL,
  `rght`         BIGINT(20) UNSIGNED           NOT NULL,
  `created`      DATETIME                      NOT NULL,
  `modified`     DATETIME                      NOT NULL,
  PRIMARY KEY (`id`))
  DEFAULT CHARSET =utf8,
  COLLATE =utf8_general_ci,
  ENGINE =InnoDB;

CREATE TABLE `$[prefix]links` (
  `id`          BIGINT(20) UNSIGNED     NOT NULL AUTO_INCREMENT,
  `parent_id`   BIGINT(20) UNSIGNED DEFAULT NULL,
  `menu_id`     BIGINT(20) UNSIGNED     NOT NULL,
  `name`        VARCHAR(255)
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `description` LONGTEXT
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `url`         TEXT
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `target`      VARCHAR(255)
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `rel`         VARCHAR(255)
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `visible`     TINYINT(1) UNSIGNED     NOT NULL DEFAULT '1',
  `rating`      INT(11) UNSIGNED        NULL DEFAULT NULL,
  `lft`         BIGINT(20) UNSIGNED     NOT NULL,
  `rght`        BIGINT(20) UNSIGNED     NOT NULL,
  `created`     DATETIME                NOT NULL,
  `modified`    DATETIME                NOT NULL,
  PRIMARY KEY (`id`))
  DEFAULT CHARSET =utf8,
  COLLATE =utf8_general_ci,
  ENGINE =InnoDB;

CREATE TABLE IF NOT EXISTS `$[prefix]media` (
  `id`            BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`       BIGINT(20) UNSIGNED NOT NULL,
  `title`         VARCHAR(255)        NOT NULL,
  `description`   LONGTEXT            NOT NULL,
  `name`          VARCHAR(255)        NOT NULL
  COMMENT 'Generated name with extension',
  `original_name` VARCHAR(255)        NOT NULL
  COMMENT 'Original name with extension',
  `mime_type`     VARCHAR(255)        NOT NULL,
  `size`          BIGINT(20) UNSIGNED NOT NULL,
  `extension`     VARCHAR(5)          NOT NULL,
  `path`          VARCHAR(12)         NOT NULL,
  `web_path`      TEXT                NOT NULL,
  `created`       DATETIME            NOT NULL,
  `modified`      DATETIME            NOT NULL,
  PRIMARY KEY (`id`))
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE `$[prefix]menus` (
  `id`          BIGINT(20) UNSIGNED     NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(255)
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `slug`        VARCHAR(255)
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `description` TEXT
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `type`        VARCHAR(50)
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `link_count`  INT(11) UNSIGNED        NOT NULL,
  `created`     DATETIME                NOT NULL,
  `modified`    DATETIME                NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `MENUS_SLUG_UNIQUE` (`slug`))
  DEFAULT CHARSET =utf8,
  COLLATE =utf8_general_ci,
  ENGINE =InnoDB;

CREATE TABLE `$[prefix]options` (
  `id`    BIGINT(20) UNSIGNED     NOT NULL AUTO_INCREMENT,
  `name`  VARCHAR(255)
          CHARACTER SET utf8
          COLLATE utf8_general_ci NOT NULL,
  `value` LONGTEXT
          CHARACTER SET utf8
          COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `OPTIONS_NAME_UNIQUE` (`name`))
  DEFAULT CHARSET =utf8,
  COLLATE =utf8_general_ci,
  ENGINE =InnoDB;

CREATE TABLE `$[prefix]post_meta` (
  `id`         BIGINT(20) UNSIGNED           NOT NULL AUTO_INCREMENT,
  `post_id`    BIGINT(20) UNSIGNED DEFAULT 0 NOT NULL,
  `meta_key`   VARCHAR(255)
               CHARACTER SET utf8
               COLLATE utf8_general_ci       NOT NULL,
  `meta_value` LONGTEXT
               CHARACTER SET utf8
               COLLATE utf8_general_ci       NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `POST_META_POST_ID_META_KEY_UNIQUE` (`post_id`, `meta_key`))
  DEFAULT CHARSET =utf8,
  COLLATE =utf8_general_ci,
  ENGINE =InnoDB;

CREATE TABLE `$[prefix]posts` (
  `id`             BIGINT(20) UNSIGNED     NOT NULL AUTO_INCREMENT,
  `parent_id`      BIGINT(20) UNSIGNED DEFAULT NULL,
  `user_id`        BIGINT(20)              NOT NULL,
  `title`          VARCHAR(255)
                   CHARACTER SET utf8
                   COLLATE utf8_general_ci NOT NULL,
  `slug`           VARCHAR(100)
                   CHARACTER SET utf8
                   COLLATE utf8_general_ci NOT NULL,
  `content`        LONGTEXT
                   CHARACTER SET utf8
                   COLLATE utf8_general_ci NOT NULL,
  `excerpt`        LONGTEXT
                   CHARACTER SET utf8
                   COLLATE utf8_general_ci NOT NULL,
  `status`         TINYINT(2) UNSIGNED     NOT NULL DEFAULT '3'
  COMMENT 'trash, draft, pending, publish',
  `comment_status` TINYINT(2) UNSIGNED     NOT NULL DEFAULT '2'
  COMMENT 'disable, close, open',
  `comment_count`  INT(11) UNSIGNED        NOT NULL,
  `type`           VARCHAR(20)
                   CHARACTER SET utf8
                   COLLATE utf8_general_ci NOT NULL,
  `sticky`         TINYINT(1) UNSIGNED     NOT NULL DEFAULT '0',
  `lft`            BIGINT(20) UNSIGNED     NOT NULL,
  `rght`           BIGINT(20) UNSIGNED     NOT NULL,
  `created`        DATETIME                NOT NULL,
  `modified`       DATETIME                NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `POSTS_SLUG_UNIQUE` (`slug`))
  DEFAULT CHARSET =utf8,
  COLLATE =utf8_general_ci,
  ENGINE =InnoDB;

CREATE TABLE `$[prefix]posts_tags` (
  `post_id` BIGINT(20) UNSIGNED NOT NULL,
  `tag_id`  BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`post_id`, `tag_id`))
  DEFAULT CHARSET =utf8,
  COLLATE =utf8_general_ci,
  ENGINE =InnoDB;

CREATE TABLE `$[prefix]tags` (
  `id`          BIGINT(20) UNSIGNED     NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(255)
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `slug`        VARCHAR(100)
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `description` LONGTEXT
                CHARACTER SET utf8
                COLLATE utf8_general_ci NOT NULL,
  `post_count`  INT(11) UNSIGNED        NOT NULL,
  `created`     DATETIME                NOT NULL,
  `modified`    DATETIME                NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `TAGS_SLUG_UNIQUE` (`slug`))
  DEFAULT CHARSET =utf8,
  COLLATE =utf8_general_ci,
  ENGINE =InnoDB;

CREATE TABLE `$[prefix]user_meta` (
  `id`         BIGINT(20) UNSIGNED           NOT NULL AUTO_INCREMENT,
  `user_id`    BIGINT(20) UNSIGNED DEFAULT 0 NOT NULL,
  `meta_key`   VARCHAR(255)
               CHARACTER SET utf8
               COLLATE utf8_general_ci       NOT NULL,
  `meta_value` LONGTEXT
               CHARACTER SET utf8
               COLLATE utf8_general_ci       NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `USER_META_USER_ID_META_KEY_UNIQUE` (`user_id`, `meta_key`))
  DEFAULT CHARSET =utf8,
  COLLATE =utf8_general_ci,
  ENGINE = InnoDB;

CREATE TABLE `$[prefix]users` (
  `id`       BIGINT(20) UNSIGNED     NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(60)
             CHARACTER SET utf8
             COLLATE utf8_general_ci NOT NULL,
  `password` VARCHAR(64)
             CHARACTER SET utf8
             COLLATE utf8_general_ci NOT NULL,
  `email`    VARCHAR(100)
             CHARACTER SET utf8
             COLLATE utf8_general_ci NOT NULL,
  `url`      VARCHAR(100)
             CHARACTER SET utf8
             COLLATE utf8_general_ci NOT NULL,
  `role`     VARCHAR(20)
             CHARACTER SET utf8
             COLLATE utf8_general_ci NOT NULL,
  `status`   INT(11) UNSIGNED        NOT NULL,
  `created`  DATETIME                NOT NULL,
  `modified` DATETIME                NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `USERS_USERNAME_UNIQUE` (`username`),
  UNIQUE KEY `USERS_EMAIL_UNIQUE` (`email`))
  DEFAULT CHARSET =utf8,
  COLLATE =utf8_general_ci,
  ENGINE =InnoDB;
