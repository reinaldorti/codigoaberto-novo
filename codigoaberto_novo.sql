# ************************************************************
# Sequel Ace SQL dump
# Version 2104
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.4.14-MariaDB)
# Database: codigoaberto_novo
# Generation Time: 2020-11-07 18:00:55 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table about
# ------------------------------------------------------------

DROP TABLE IF EXISTS `about`;

CREATE TABLE `about` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(11) DEFAULT 1 COMMENT '1 ativo, 2 inativo',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `content` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `address`;

CREATE TABLE `address` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `zipcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `complement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `address_user_id_foreign` (`user_id`),
  FULLTEXT KEY `street` (`street`,`district`,`city`,`state`,`zipcode`),
  CONSTRAINT `address_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title`,`content`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `author` bigint(20) unsigned DEFAULT NULL,
  `category` bigint(20) unsigned DEFAULT NULL,
  `post_order` int(11) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT '1' COMMENT '1 ativo, 2 inativo',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `views` decimal(10,0) DEFAULT 0,
  `post_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `posts_category_foreign` (`category`),
  KEY `posts_author_foreign` (`author`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `title_2` (`title`,`subtitle`,`content`),
  FULLTEXT KEY `title_3` (`title`,`subtitle`,`content`),
  FULLTEXT KEY `title_4` (`title`,`subtitle`,`content`),
  FULLTEXT KEY `title_5` (`title`,`subtitle`,`content`),
  FULLTEXT KEY `tag` (`tag`),
  CONSTRAINT `posts_author_foreign` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `posts_category_foreign` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table posts_images
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts_images`;

CREATE TABLE `posts_images` (
  `post_id` bigint(20) unsigned DEFAULT NULL,
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `images` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `posts_images_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table slides
# ------------------------------------------------------------

DROP TABLE IF EXISTS `slides`;

CREATE TABLE `slides` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(11) COLLATE utf8_unicode_ci DEFAULT '1' COMMENT '1 ativo, 2 inativo',
  `slide_order` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slide_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `title_2` (`title`,`subtitle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `slides` WRITE;
/*!40000 ALTER TABLE `slides` DISABLE KEYS */;

INSERT INTO `slides` (`id`, `status`, `slide_order`, `title`, `subtitle`, `uri`, `cover`, `slide_at`, `created_at`, `updated_at`)
VALUES
	(1,'1',1,'Big Deal','Burger Bachelor',NULL,'slides/2020/11/banner.png',NULL,'2020-11-05 08:10:13','2020-11-05 08:21:30'),
	(2,'1',2,'Big Deal','Burger Bachelor',NULL,'slides/2020/11/banner2.png',NULL,'2020-11-05 08:10:46','2020-11-05 08:21:31');

/*!40000 ALTER TABLE `slides` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table testimonys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `testimonys`;

CREATE TABLE `testimonys` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `author` bigint(20) unsigned DEFAULT NULL,
  `status` int(11) DEFAULT 1 COMMENT '1 ativo, 2 inativo',
  `testimony_order` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `cover` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `posts_author_foreign` (`author`),
  FULLTEXT KEY `title` (`name`),
  FULLTEXT KEY `name` (`name`,`content`),
  CONSTRAINT `testimonys_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `logged` int(11) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `genre` int(11) DEFAULT NULL COMMENT '1 male, 2 female',
  `status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '1 ativo 2 inativo',
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `document` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cell` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forget` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_login` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_cookie` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastaccess` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datebirth` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  FULLTEXT KEY `first_name` (`first_name`,`last_name`,`email`),
  FULLTEXT KEY `first_name_2` (`first_name`,`last_name`,`email`),
  FULLTEXT KEY `first_name_3` (`first_name`),
  FULLTEXT KEY `first_name_4` (`first_name`,`last_name`,`email`,`telephone`,`cell`,`document`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
