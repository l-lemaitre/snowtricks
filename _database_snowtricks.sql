# ************************************************************
# Sequel Ace SQL dump
# Version 20039
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 8.0.31)
# Database: snowtricks
# Generation Time: 2022-11-01 14:29:08 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_category`),
  UNIQUE KEY `UNIQ_64C19C12B36786B` (`title`),
  UNIQUE KEY `UNIQ_64C19C1989D9B62` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` (`id_category`, `title`, `slug`, `date_add`)
VALUES
	(1,'grab','grab','2022-10-16 16:37:53'),
	(2,'other','other','2022-10-23 11:30:52');

/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table doctrine_migration_versions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `doctrine_migration_versions`;

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`)
VALUES
	('DoctrineMigrations\\Version20221016161456','2022-11-01 12:38:11',178),
	('DoctrineMigrations\\Version20221023125511','2022-11-01 12:38:12',16),
	('DoctrineMigrations\\Version20221101110621','2022-11-01 12:38:12',31);

/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table image
# ------------------------------------------------------------

DROP TABLE IF EXISTS `image`;

CREATE TABLE `image` (
  `id_image` int NOT NULL AUTO_INCREMENT,
  `trick_id` int DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_image`),
  UNIQUE KEY `UNIQ_C53D045FF47645AE` (`url`),
  KEY `IDX_C53D045FB281BE2E` (`trick_id`),
  CONSTRAINT `FK_C53D045FB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id_trick`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;

INSERT INTO `image` (`id_image`, `trick_id`, `url`)
VALUES
	(1,1,'/img/Picswiss-VD-44-23-6361257049384.jpg'),
	(2,2,'/img/snowboard-neige-figure-saut-shutterstock-3516624621-63612cd79e80c.jpg');

/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table message
# ------------------------------------------------------------

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `trick_id` int NOT NULL,
  `status_id` int NOT NULL,
  `contents` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_add` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `IDX_B6BD307FA76ED395` (`user_id`),
  KEY `IDX_B6BD307FB281BE2E` (`trick_id`),
  KEY `IDX_B6BD307F6BF700BD` (`status_id`),
  CONSTRAINT `FK_B6BD307F6BF700BD` FOREIGN KEY (`status_id`) REFERENCES `status` (`id_status`),
  CONSTRAINT `FK_B6BD307FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`),
  CONSTRAINT `FK_B6BD307FB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id_trick`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table messenger_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messenger_messages`;

CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id_status` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_status`),
  UNIQUE KEY `UNIQ_7B00651C5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table trick
# ------------------------------------------------------------

DROP TABLE IF EXISTS `trick`;

CREATE TABLE `trick` (
  `id_trick` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `user_id` int NOT NULL,
  `image_id` int NOT NULL,
  `video_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contents` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` smallint NOT NULL,
  `deleted` smallint NOT NULL,
  `date_add` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id_trick`),
  UNIQUE KEY `UNIQ_D8F0A91E2B36786B` (`title`),
  UNIQUE KEY `UNIQ_D8F0A91E989D9B62` (`slug`),
  KEY `IDX_D8F0A91E12469DE2` (`category_id`),
  KEY `IDX_D8F0A91EA76ED395` (`user_id`),
  KEY `IDX_D8F0A91E3DA5256D` (`image_id`),
  KEY `IDX_D8F0A91E29C1004E` (`video_id`),
  CONSTRAINT `FK_D8F0A91E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_D8F0A91E29C1004E` FOREIGN KEY (`video_id`) REFERENCES `video` (`id_video`),
  CONSTRAINT `FK_D8F0A91E3DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id_image`),
  CONSTRAINT `FK_D8F0A91EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `trick` WRITE;
/*!40000 ALTER TABLE `trick` DISABLE KEYS */;

INSERT INTO `trick` (`id_trick`, `category_id`, `user_id`, `image_id`, `video_id`, `title`, `contents`, `slug`, `published`, `deleted`, `date_add`, `date_updated`)
VALUES
	(1,1,1,1,NULL,'mute','Test mute.','mute',1,0,'2022-11-01 13:56:00','2022-11-01 13:56:00'),
	(2,1,1,2,1,'sad','Test sad.','sad',1,0,'2022-11-01 14:27:35','2022-11-01 14:27:35');

/*!40000 ALTER TABLE `trick` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` smallint NOT NULL,
  `registration_date` datetime NOT NULL,
  `unsubscribe_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `lastname`, `firstname`, `profile_picture`, `deleted`, `registration_date`, `unsubscribe_date`)
VALUES
	(1,'Nerofaust','ludoviclemaitre@orange.fr','Test','Lemaître','Ludovic',NULL,0,'2022-10-16 16:17:12',NULL);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table video
# ------------------------------------------------------------

DROP TABLE IF EXISTS `video`;

CREATE TABLE `video` (
  `id_video` int NOT NULL AUTO_INCREMENT,
  `trick_id` int DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_video`),
  UNIQUE KEY `UNIQ_7CC7DA2CF47645AE` (`url`),
  KEY `IDX_7CC7DA2CB281BE2E` (`trick_id`),
  CONSTRAINT `FK_7CC7DA2CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id_trick`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `video` WRITE;
/*!40000 ALTER TABLE `video` DISABLE KEYS */;

INSERT INTO `video` (`id_video`, `trick_id`, `url`)
VALUES
	(1,2,'https://www.youtube.com/embed/oLnvs5IdPFg');

/*!40000 ALTER TABLE `video` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
