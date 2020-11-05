# ************************************************************
# Sequel Ace SQL dump
# Version 2104
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.4.14-MariaDB)
# Database: codigoaberto_novo
# Generation Time: 2020-11-05 23:24:17 +0000
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

LOCK TABLES `about` WRITE;
/*!40000 ALTER TABLE `about` DISABLE KEYS */;

INSERT INTO `about` (`id`, `status`, `title`, `content`, `created_at`, `updated_at`)
VALUES
	(8,1,'Dólar dispara e fecha cotado a R$ 5,76; turismo chega a R$ 6','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris laoreet feugiat nisi, vel vestibulum ipsum fringilla vel. Vivamus at dui vel tortor cursus accumsan vel vitae odio. Morbi suscipit, lacus eget tincidunt mollis, nisi nisi pharetra felis, ut mattis lorem felis vitae leo. Donec dictum, enim a dignissim vehicula, nunc ante vulputate turpis, imperdiet venenatis orci ligula vel nisl. Pellentesque maximus mauris ante, in dignissim nisl vulputate vel. Aenean non vestibulum mi. Morbi finibus lectus a neque sollicitudin pellentesque.</p>\n<p>Phasellus at interdum quam. Nunc faucibus fermentum lectus vitae mattis. Aenean imperdiet eu mauris eu egestas. Donec tellus erat, vestibulum quis sapien id, commodo pretium nunc. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus commodo libero nibh, et vehicula ex convallis non. Pellentesque venenatis sagittis gravida. Aliquam neque purus, facilisis vitae rutrum id, luctus eget urna. Sed eu augue rhoncus, dignissim enim at, bibendum orci. Sed faucibus a ligula in consectetur. Nunc quis libero eu est mattis congue vitae ut sapien. Cras consequat mollis turpis, dictum pretium turpis vestibulum in. Sed a tortor id ipsum interdum auctor. Duis rhoncus urna ac mi aliquam, a placerat nunc ultricies. Sed lacinia fringilla lectus dictum scelerisque. Nulla sodales blandit sapien in volutpat.</p>\n<p>Ut velit nisi, auctor ac tortor vitae, mollis dictum turpis. Integer fermentum, quam quis finibus luctus, arcu enim egestas ligula, eget fermentum purus turpis eget massa. Vivamus a faucibus sem. Donec pulvinar libero felis, nec bibendum ipsum fermentum et. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis tempus magna id lectus vehicula dignissim. Nunc feugiat a magna at lacinia. Nulla eget massa eget elit laoreet ornare. Proin consequat placerat feugiat. Pellentesque consequat eros at enim vehicula euismod. Mauris tincidunt sed dolor ut egestas. Morbi ultricies nunc sit amet mi feugiat ultrices. Maecenas tincidunt finibus dolor quis facilisis. Nulla sit amet accumsan lectus, a pulvinar ex.</p>\n<p>Sed venenatis fermentum tellus, non sagittis tortor sodales id. Sed vel posuere eros. Curabitur purus magna, blandit ut vestibulum ut, rutrum vitae quam. Nam congue cursus libero, eu elementum magna porta nec. Mauris eget blandit ipsum. Nunc non molestie purus, at aliquam eros. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla fringilla ultricies ante, sit amet fringilla neque accumsan et. Etiam efficitur nunc vitae imperdiet eleifend. Cras a magna vel augue lacinia faucibus. Nam placerat, nulla eu euismod congue, purus enim dapibus dolor, et dapibus ipsum ante sed risus. Curabitur fermentum erat imperdiet ex auctor, eu pulvinar mauris molestie. Nam pulvinar sem non interdum aliquam. Donec maximus pretium vulputate. Duis faucibus lacus est, ut vestibulum ante varius eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>\n<p>Mauris mauris nulla, malesuada sed dictum eu, lobortis vel nulla. Sed vehicula egestas ex, quis venenatis neque sodales quis. Nunc nisl urna, accumsan non libero eu, aliquet rutrum nisl. Nulla facilisi. Vivamus tellus erat, iaculis ut condimentum nec, volutpat ultrices magna. Cras sed cursus quam. Pellentesque et tellus a ligula scelerisque volutpat. Sed neque elit, molestie eleifend tincidunt id, tristique ac turpis. Mauris id nulla metus. Morbi luctus dignissim dui sed interdum. Curabitur ut porta ipsum, quis vulputate ante. Ut suscipit blandit mi nec ornare. Vestibulum id turpis vel libero malesuada elementum hendrerit a magna. Maecenas iaculis nunc diam, quis tristique est pharetra id. Aliquam vulputate leo vel felis pretium, ac faucibus risus finibus.</p>\n<p>Pellentesque egestas scelerisque pulvinar. Donec quis elementum diam. Suspendisse blandit ut urna nec scelerisque. Donec a pretium purus, eu eleifend dui. Sed eget semper erat, eu dapibus nulla. Maecenas et nulla sagittis, pellentesque nulla sit amet, eleifend mauris. Curabitur sodales iaculis est eget egestas. Phasellus quis libero varius, elementum arcu non, efficitur nisi. Praesent posuere est justo, in commodo lacus sodales nec. Quisque vel dui vitae odio imperdiet ultrices iaculis ultricies elit. Aliquam massa orci, consequat id quam sed, congue consequat magna. Nulla malesuada tristique neque nec interdum. Vivamus maximus venenatis diam, ac volutpat tortor rhoncus non. Etiam mattis, odio in rutrum imperdiet, metus tortor auctor mauris, scelerisque semper libero ligula sit amet risus. Pellentesque venenatis imperdiet magna.</p>\n<p>Proin commodo, felis id dapibus hendrerit, ex lacus efficitur libero, a feugiat lorem massa quis sem. Morbi sollicitudin lobortis pulvinar. In hac habitasse platea dictumst. Quisque aliquet dolor condimentum, faucibus nunc non, tincidunt dolor. Sed vitae ipsum id mi gravida rutrum. Praesent convallis fringilla leo at tincidunt. Donec vitae libero pulvinar, facilisis purus et, sagittis odio. Curabitur eget massa ultrices, faucibus sapien porttitor, porttitor risus. Sed pulvinar porta leo, eu commodo est imperdiet quis. Maecenas justo dolor, ornare convallis tincidunt quis, sollicitudin nec massa. Nullam placerat lacus a sagittis tempor. Phasellus feugiat eget risus quis molestie. Mauris id ex nec arcu posuere malesuada.</p>\n<p>Nulla eleifend metus eros, ac dignissim nisi semper sit amet. Etiam lorem massa, maximus ac lectus vitae, mollis finibus dolor. Nam aliquet dui vel sapien aliquam congue. Ut tristique lacus interdum odio pharetra vulputate. Donec ut leo finibus, efficitur sem et, tempus tortor. Mauris justo magna, ultricies et pellentesque mollis, viverra quis ipsum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed ac ultricies justo. Aenean quis orci sollicitudin massa tincidunt consectetur. In aliquam nulla eu lectus accumsan aliquam. Morbi lacus nunc, vulputate et malesuada non, vehicula eu lacus. Pellentesque ut leo et lacus molestie euismod.</p>\n<p>In quis luctus arcu. Nulla luctus aliquet finibus. In consectetur efficitur euismod. Ut a nulla eget nunc pretium rutrum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Aenean dignissim, velit consectetur semper cursus, metus tellus rhoncus velit, vel rhoncus magna lacus quis ex. Nulla id varius nisl.</p>\n<p>Morbi vitae enim leo. Morbi cursus eget mi sit amet malesuada. Sed arcu metus, pharetra quis rutrum porttitor, venenatis eu libero. Suspendisse metus nisi, posuere in justo ac, pulvinar varius neque. Praesent pellentesque nulla et molestie pellentesque. Integer libero elit, maximus a placerat ut, cursus vitae dui. Maecenas quis ligula fermentum, efficitur nibh et, efficitur nibh. Sed mauris eros, interdum quis euismod vel, dapibus in felis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;</p>','2020-11-05 20:15:50','2020-11-05 20:15:50');

/*!40000 ALTER TABLE `about` ENABLE KEYS */;
UNLOCK TABLES;


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
