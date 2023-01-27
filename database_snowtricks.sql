# ************************************************************
# Sequel Ace SQL dump
# Version 20046
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 8.0.32)
# Database: snowtricks
# Generation Time: 2023-01-27 21:31:41 +0000
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
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_category`),
  UNIQUE KEY `UNIQ_64C19C12B36786B` (`title`),
  UNIQUE KEY `UNIQ_64C19C1989D9B62` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` (`id_category`, `title`, `slug`, `date_add`)
VALUES
	(1,'Grabs','grabs','2023-01-27 21:35:32'),
	(2,'Rotations','rotations','2023-01-27 21:35:32');

/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table doctrine_migration_versions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `doctrine_migration_versions`;

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
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
	('DoctrineMigrations\\Version20221101110621','2022-11-01 12:38:12',31),
	('DoctrineMigrations\\Version20221113161125','2022-11-13 17:14:57',59),
	('DoctrineMigrations\\Version20221113173017','2022-11-13 17:33:34',52),
	('DoctrineMigrations\\Version20221204171243','2022-12-10 10:45:28',45),
	('DoctrineMigrations\\Version20221211162849','2022-12-11 16:29:29',50),
	('DoctrineMigrations\\Version20221231145514','2022-12-31 18:27:29',48),
	('DoctrineMigrations\\Version20230113144154','2023-01-15 10:52:06',45),
	('DoctrineMigrations\\Version20230115105302','2023-01-15 11:37:52',52),
	('DoctrineMigrations\\Version20230115204308','2023-01-15 20:44:34',91),
	('DoctrineMigrations\\Version20230122140425','2023-01-22 14:04:56',57);

/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table image
# ------------------------------------------------------------

DROP TABLE IF EXISTS `image`;

CREATE TABLE `image` (
  `id_image` int NOT NULL AUTO_INCREMENT,
  `trick_id` int DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_image`),
  UNIQUE KEY `UNIQ_C53D045FF47645AE` (`url`),
  KEY `IDX_C53D045FB281BE2E` (`trick_id`),
  CONSTRAINT `FK_C53D045FB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id_trick`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;

INSERT INTO `image` (`id_image`, `trick_id`, `url`)
VALUES
	(1,1,'/img/Tous-les-mots-quil-faut-connaitre-lorsque-lon-aime-le-surf-71-63d4408437ada.jpg'),
	(2,1,'/img/AgAAAB0Avp62vmokNkONBFidgXn3JQ-63d44084380be.avif'),
	(3,1,'/img/KellyClark-TrickTips-Blotto-9-2e16d0ba-fill-1000x800-c75-63d4408438203.jpg'),
	(4,1,'/img/mute-air-on-snowboard-1438217-63d44084382d9.jpg'),
	(5,1,'/img/snowboard-lexique-63d44084383a3.avif'),
	(6,1,'/img/c0b199d73b-120515-lexique-snowboard-63d440843849f.jpg');

/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table message
# ------------------------------------------------------------

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `trick_id` int NOT NULL,
  `contents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_add` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `IDX_B6BD307FA76ED395` (`user_id`),
  KEY `IDX_B6BD307FB281BE2E` (`trick_id`),
  CONSTRAINT `FK_B6BD307FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`),
  CONSTRAINT `FK_B6BD307FB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id_trick`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;

INSERT INTO `message` (`id_message`, `user_id`, `trick_id`, `contents`, `date_add`, `date_updated`)
VALUES
	(1,1,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis posuere venenatis vehicula. Praesent imperdiet augue a massa tincidunt, ac vehicula tortor luctus.','2023-01-27 22:25:22','2023-01-27 22:25:22'),
	(2,1,1,'Suspendisse hendrerit nisi at massa posuere rhoncus. Vivamus maximus volutpat nibh in sodales. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.','2023-01-27 22:25:39','2023-01-27 22:25:39'),
	(3,1,1,'Nunc lacinia metus sit amet hendrerit porttitor.','2023-01-27 22:26:07','2023-01-27 22:26:07'),
	(4,1,1,'Vivamus non nisi magna.','2023-01-27 22:26:39','2023-01-27 22:26:39'),
	(5,1,1,'Aenean risus nulla, molestie sed scelerisque et, finibus non sapien.','2023-01-27 22:26:56','2023-01-27 22:26:56'),
	(6,1,1,'Etiam in mattis massa. Maecenas at magna mauris. Morbi eu orci molestie, malesuada ante ac, aliquet ligula. Nulla iaculis lacinia mi, quis scelerisque quam ultricies eu.','2023-01-27 22:27:26','2023-01-27 22:27:26'),
	(7,1,1,'Nulla at lacus sollicitudin, varius eros et, ultrices sapien. Praesent accumsan mattis finibus.','2023-01-27 22:27:40','2023-01-27 22:27:40'),
	(8,1,1,'Mauris mollis sagittis purus. Pellentesque et condimentum lorem. Phasellus vitae turpis euismod elit hendrerit tempus ac id enim.','2023-01-27 22:28:12','2023-01-27 22:28:12'),
	(9,1,1,'Mauris accumsan interdum justo. Suspendisse malesuada lacus ac erat fermentum, id blandit magna lobortis. Maecenas lectus elit, ullamcorper a massa accumsan, malesuada dapibus libero.','2023-01-27 22:28:30','2023-01-27 22:28:30'),
	(10,1,1,'Curabitur eget neque feugiat, commodo dolor ac, tempus augue. Praesent eget lacus metus. Nulla eu porta leo, in blandit justo.','2023-01-27 22:28:44','2023-01-27 22:28:44'),
	(11,1,1,'Quisque condimentum tincidunt nulla sed finibus. Nam sollicitudin velit nec magna congue, vel commodo tortor tempor. In eu massa volutpat, laoreet nisl nec, gravida lacus.','2023-01-27 22:29:09','2023-01-27 22:29:09');

/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table messenger_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messenger_messages`;

CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table trick
# ------------------------------------------------------------

DROP TABLE IF EXISTS `trick`;

CREATE TABLE `trick` (
  `id_trick` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `user_id` int NOT NULL,
  `image_id` int DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` smallint NOT NULL,
  `deleted` smallint NOT NULL DEFAULT '0',
  `date_add` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id_trick`),
  UNIQUE KEY `UNIQ_D8F0A91E2B36786B` (`title`),
  UNIQUE KEY `UNIQ_D8F0A91E989D9B62` (`slug`),
  KEY `IDX_D8F0A91E12469DE2` (`category_id`),
  KEY `IDX_D8F0A91EA76ED395` (`user_id`),
  KEY `IDX_D8F0A91E3DA5256D` (`image_id`),
  CONSTRAINT `FK_D8F0A91E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_D8F0A91E3DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id_image`) ON DELETE SET NULL,
  CONSTRAINT `FK_D8F0A91EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `trick` WRITE;
/*!40000 ALTER TABLE `trick` DISABLE KEYS */;

INSERT INTO `trick` (`id_trick`, `category_id`, `user_id`, `image_id`, `title`, `contents`, `slug`, `published`, `deleted`, `date_add`, `date_updated`)
VALUES
	(1,1,1,6,'mute','Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam malesuada, urna sed pharetra sollicitudin, nunc eros aliquet augue, et mollis ante lacus vitae felis. Fusce finibus posuere rutrum. Nullam sed dictum mi. Vivamus dignissim leo odio, ac sodales felis posuere rhoncus. In malesuada felis sed mauris blandit porttitor. Donec bibendum at augue ac dictum. Etiam eget sagittis eros. Integer fringilla eros dolor, porta pharetra arcu finibus at. Curabitur ornare fermentum nunc, eu efficitur orci aliquet eu.\r\n\r\nMorbi fringilla ante magna, non eleifend magna ornare a. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada rutrum enim, et ultrices diam feugiat eu. Vivamus et eleifend risus. Sed sit amet arcu eget leo porttitor fermentum. Mauris semper gravida ligula, non mollis ipsum malesuada vitae. Fusce consectetur vitae nunc id scelerisque. Curabitur iaculis suscipit diam, sed laoreet odio sollicitudin et. Morbi metus velit, egestas sit amet lectus nec, cursus dignissim lacus. \r\n\r\n Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam malesuada, urna sed pharetra sollicitudin, nunc eros aliquet augue, et mollis ante lacus vitae felis. Fusce finibus posuere rutrum. Nullam sed dictum mi. Vivamus dignissim leo odio, ac sodales felis posuere rhoncus. In malesuada felis sed mauris blandit porttitor. Donec bibendum at augue ac dictum. Etiam eget sagittis eros. Integer fringilla eros dolor, porta pharetra arcu finibus at. Curabitur ornare fermentum nunc, eu efficitur orci aliquet eu.\r\n\r\nMorbi fringilla ante magna, non eleifend magna ornare a. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada rutrum enim, et ultrices diam feugiat eu. Vivamus et eleifend risus. Sed sit amet arcu eget leo porttitor fermentum. Mauris semper gravida ligula, non mollis ipsum malesuada vitae. Fusce consectetur vitae nunc id scelerisque. Curabitur iaculis suscipit diam, sed laoreet odio sollicitudin et. Morbi metus velit, egestas sit amet lectus nec, cursus dignissim lacus.','mute',1,0,'2023-01-27 21:35:32','2023-01-27 22:16:56'),
	(2,1,1,NULL,'sad','Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant.','sad',1,0,'2023-01-27 21:35:32','2023-01-27 21:35:32'),
	(3,1,1,NULL,'indy','Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.','indy',1,0,'2023-01-27 21:35:32','2023-01-27 21:35:32'),
	(4,1,1,NULL,'stalefish','Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.','stalefish',1,0,'2023-01-27 21:35:32','2023-01-27 21:35:32'),
	(5,1,1,NULL,'tail grab','Saisie de la partie arrière de la planche, avec la main arrière.','tail%20grab',1,0,'2023-01-27 21:35:32','2023-01-27 21:35:32'),
	(6,1,1,NULL,'nose grab','Saisie de la partie avant de la planche, avec la main avant.','nose%20grab',1,0,'2023-01-27 21:35:32','2023-01-27 21:35:32'),
	(7,1,1,NULL,'japan','Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.','japan',1,0,'2023-01-27 21:35:32','2023-01-27 21:35:32'),
	(8,1,1,NULL,'seat belt','Saisie du carre frontside à l\'arrière avec la main avant.','seat%20belt',1,0,'2023-01-27 21:35:32','2023-01-27 21:35:32'),
	(9,1,1,NULL,'truck driver','Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture).','truck%20driver',1,0,'2023-01-27 21:35:32','2023-01-27 21:35:32'),
	(10,2,1,NULL,'180','Un 180 désigne un demi-tour, soit 180 degrés d\'angle.','180',1,0,'2023-01-27 21:35:32','2023-01-27 21:35:32');

/*!40000 ALTER TABLE `trick` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` smallint NOT NULL DEFAULT '0',
  `registration_date` datetime NOT NULL,
  `unsubscribe_date` datetime DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `roles` json NOT NULL,
  `reset_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `lastname`, `firstname`, `profile_picture`, `deleted`, `registration_date`, `unsubscribe_date`, `is_verified`, `roles`, `reset_token`)
VALUES
	(1,'Nerofaust','contact@llemaitre.com','$2y$13$VNspw1VgW.bNTLJJdSG7RuYwVHIecsp2nCK9YH.iW6F8kAsQnMNiO','Lemaître','Ludovic','/img/ludovic-63d43cc810385.png',0,'2023-01-27 21:35:32',NULL,1,'[\"ROLE_USER\"]',NULL);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table video
# ------------------------------------------------------------

DROP TABLE IF EXISTS `video`;

CREATE TABLE `video` (
  `id_video` int NOT NULL AUTO_INCREMENT,
  `trick_id` int DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_video`),
  UNIQUE KEY `UNIQ_7CC7DA2CB281BE2EF47645AE` (`trick_id`,`url`),
  KEY `IDX_7CC7DA2CB281BE2E` (`trick_id`),
  CONSTRAINT `FK_7CC7DA2CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id_trick`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `video` WRITE;
/*!40000 ALTER TABLE `video` DISABLE KEYS */;

INSERT INTO `video` (`id_video`, `trick_id`, `url`)
VALUES
	(3,1,'https://www.youtube.com/embed/CA5bURVJ5zk'),
	(2,1,'https://www.youtube.com/embed/M5NTCfdObfs'),
	(4,1,'https://www.youtube.com/embed/NnnsXEBwTHc'),
	(1,1,'https://www.youtube.com/embed/wWgCIEpE0Ug');

/*!40000 ALTER TABLE `video` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
