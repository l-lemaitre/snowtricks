# ************************************************************
# Sequel Ace SQL dump
# Version 20046
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 8.0.31)
# Database: snowtricks
# Generation Time: 2023-01-15 11:38:30 +0000
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
	(1,'grab','grab','2022-10-16 16:37:53'),
	(2,'other','other','2022-10-23 11:30:52');

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
	('DoctrineMigrations\\Version20230115105302','2023-01-15 11:37:52',52);

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
  CONSTRAINT `FK_C53D045FB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id_trick`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;

INSERT INTO `image` (`id_image`, `trick_id`, `url`)
VALUES
	(1,1,'/img/Picswiss-VD-44-23-6361257049384.jpg'),
	(2,2,'/img/snowboard-neige-figure-saut-shutterstock-3516624621-63612cd79e80c.jpg'),
	(3,3,'/img/snowboard-neige-figure-saut-shutterstock-636530a905259.jpg'),
	(4,4,'/img/Picswiss-VD-44-23-636539f048adc.jpg'),
	(5,4,'/img/snowboard-neige-figure-saut-shutterstock-636539f048eec.jpg'),
	(6,5,'/img/Picswiss-VD-44-23-6365440404c6f.jpg'),
	(7,5,'/img/snowboard-neige-figure-saut-shutterstock-6365440404fd8.jpg'),
	(8,4,'/img/Picswiss-VD-44-23-636544730bb5e.jpg'),
	(10,7,'/img/Picswiss-VD-44-23-636581b36312d.jpg'),
	(11,8,'/img/28-winters-nitro-knut-eliassen-carving-636fcd9456243.avif'),
	(12,8,'/img/AgAAAB0Avp62vmokNkONBFidgXn3JQ-636fcd945660f.avif'),
	(13,4,'/img/JessPressWeb-1400x-636fd71b9355a.webp'),
	(14,4,'/img/KellyClark-TrickTips-Blotto-9-2e16d0ba-fill-1000x800-c75-636fd7b3c6812.jpg'),
	(15,4,'/img/merlin-186346947-e4e67564-bede-49ac-97fb-c7df58c0b62c-videoSixteenByNine3000-636fd7b3c6c95.jpg'),
	(16,4,'/img/28-winters-nitro-knut-eliassen-carving-6370d54dbd916.avif'),
	(17,4,'/img/AgAAAB0Avp62vmokNkONBFidgXn3JQ-6370d54dbe187.avif');

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
  `contents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;

INSERT INTO `message` (`id_message`, `user_id`, `trick_id`, `status_id`, `contents`, `date_add`, `date_updated`)
VALUES
	(1,1,4,2,'Test mentorat commentaire.','2022-12-23 12:15:03','2022-12-23 12:15:03'),
	(2,1,4,1,'Test mentorat commentaire.','2022-12-23 12:18:46','2022-12-23 12:18:46'),
	(3,1,4,2,'Test mentorat commentaire 2.','2022-12-23 12:23:30','2022-12-23 12:23:30'),
	(4,1,4,2,'Test mentorat commentaire 3.','2022-12-23 12:31:42','2022-12-23 12:31:42'),
	(5,1,4,2,'Test mentorat commentaire 4.','2022-12-23 12:44:05','2022-12-23 12:44:05'),
	(6,1,4,2,'Test mentorat commentaire 5.','2022-12-23 12:45:49','2022-12-23 12:45:49'),
	(7,1,4,2,'Test mentorat commentaire 6.','2022-12-23 12:50:25','2022-12-23 12:50:25');

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



# Dump of table status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id_status` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_status`),
  UNIQUE KEY `UNIQ_7B00651C5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;

INSERT INTO `status` (`id_status`, `name`)
VALUES
	(1,'En attente'),
	(2,'Publié');

/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;


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
  `deleted` smallint NOT NULL,
  `date_add` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id_trick`),
  UNIQUE KEY `UNIQ_D8F0A91E2B36786B` (`title`),
  UNIQUE KEY `UNIQ_D8F0A91E989D9B62` (`slug`),
  KEY `IDX_D8F0A91E12469DE2` (`category_id`),
  KEY `IDX_D8F0A91EA76ED395` (`user_id`),
  KEY `IDX_D8F0A91E3DA5256D` (`image_id`),
  CONSTRAINT `FK_D8F0A91E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_D8F0A91E3DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id_image`),
  CONSTRAINT `FK_D8F0A91EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `trick` WRITE;
/*!40000 ALTER TABLE `trick` DISABLE KEYS */;

INSERT INTO `trick` (`id_trick`, `category_id`, `user_id`, `image_id`, `title`, `contents`, `slug`, `published`, `deleted`, `date_add`, `date_updated`)
VALUES
	(1,1,1,1,'mute','Test mute.','mute',1,0,'2022-11-01 13:56:00','2022-11-01 13:56:00'),
	(2,1,1,2,'sad','Test sad.','sad',1,0,'2022-11-01 14:27:35','2022-11-01 14:27:35'),
	(3,1,1,3,'test','Test.','test',1,1,'2022-11-04 15:42:04','2022-11-04 15:42:04'),
	(4,1,1,17,'Test mentorat','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec in elementum lacus. Nam luctus consequat suscipit. Integer interdum justo non elit eleifend maximus ut in urna. Sed erat felis, suscipit ac convallis in, euismod at purus. Praesent lacus velit, condimentum sollicitudin viverra at, commodo nec dolor. Suspendisse facilisis fermentum nibh, eu rhoncus nisi porttitor sit amet. Maecenas eu maximus magna. Etiam vitae auctor sapien, nec condimentum ex. Donec gravida metus ac erat pellentesque, ac elementum turpis sodales. Donec vehicula porta maximus.\r\n\r\nDonec in enim eget purus mattis luctus eget eu ante. Aliquam erat volutpat. Proin malesuada nisi non orci volutpat, eu venenatis ex bibendum. Morbi iaculis lorem vitae dignissim aliquam. Proin luctus purus nisl, ac faucibus orci ultricies eu. Nulla facilisi. Sed ut dolor a mauris posuere commodo. Quisque rhoncus feugiat mi et posuere. Curabitur condimentum non neque nec pretium. Nulla scelerisque aliquam libero, nec bibendum felis hendrerit eget. Nam viverra vel elit in ornare. Nulla ornare justo faucibus, mattis purus non, efficitur metus. Praesent faucibus vel nulla vitae eleifend. Vestibulum in pretium erat, non pulvinar ante. Sed nec augue est. Pellentesque venenatis congue tellus quis vulputate.\r\n\r\nCras molestie vulputate leo, nec ultricies nunc ornare eget. Nunc tempor mattis hendrerit. Morbi cursus ut ipsum eu dignissim. Quisque pulvinar massa vitae semper scelerisque. In dictum leo neque, non blandit dui luctus nec. Donec pellentesque aliquam libero, vel dictum neque faucibus sit amet. Aenean volutpat orci neque, id tempus odio posuere at.','testmentorat',1,0,'2022-11-04 16:57:23','2022-11-27 18:54:02'),
	(5,1,1,7,'test3','Test 3.','test3',1,0,'2022-11-04 16:55:32','2022-11-04 16:55:32'),
	(7,1,1,10,'test4','Test 4.','test4',1,0,'2022-11-04 21:19:45','2022-11-04 21:19:45'),
	(8,2,1,12,'Test5','Test 5.','test5',1,0,'2022-11-12 16:45:08','2022-11-12 16:45:08'),
	(9,1,1,NULL,'Test6','Test 6.','test6',1,0,'2022-12-03 15:40:49','2022-12-03 15:40:49'),
	(10,1,1,NULL,'Test7','Nam quis fringilla lectus. Donec sit amet risus eu arcu tincidunt pharetra. Vestibulum fringilla congue erat ac mollis. Mauris commodo laoreet sollicitudin. Etiam fermentum eros vitae tempor blandit. Curabitur blandit ligula molestie pellentesque dignissim. Aliquam et quam ut turpis cursus suscipit blandit nec nibh. Ut lacinia dapibus nibh, sit amet vestibulum odio bibendum convallis. Vestibulum rhoncus vel neque nec ornare. Ut ut odio lectus. Curabitur in vulputate mauris. Vestibulum placerat, nisl at consequat congue, nisi leo consequat nulla, in dignissim erat ipsum non arcu. Nulla fringilla tellus est, id facilisis orci tempor sit amet.','test7',1,0,'2022-12-10 10:46:46','2022-12-10 10:46:46'),
	(11,1,1,NULL,'Test soutenance','Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Duis elementum tellus eget libero maximus, eu vulputate ex elementum. Suspendisse id placerat urna. Sed eu risus auctor, ultrices nibh sed, varius tellus. Nullam ac est mollis libero commodo aliquet ac vel dolor. Sed sed turpis urna. Maecenas nisl nunc, congue quis porta et, rutrum eget magna. Proin accumsan eleifend odio, sit amet aliquam diam aliquet ac. In id odio eu nisl feugiat semper et non mauris. Sed malesuada libero at urna tristique gravida. Vestibulum viverra imperdiet urna, quis faucibus ipsum tincidunt in. Aliquam feugiat pellentesque convallis. Curabitur pretium tempor condimentum. In vel dignissim ligula.','testsoutenance',1,0,'2023-01-11 08:16:17','2023-01-11 09:03:09');

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
  `deleted` smallint NOT NULL,
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
	(1,'Nerofaust','ludoviclemaitre@orange.fr','$2y$13$itkkltUjK3e75HxEl/9BYuTB3Rl9vN9807OqStIHEO9He8sIMv76i','Lemaître','Ludovic','/img/ludovic-63bafa7be0bb7.png',0,'2022-10-16 16:17:12',NULL,1,'[\"ROLE_USER\"]',NULL),
	(2,'Test','contact@llemaitre.com','$2y$13$7kN5yAS34/mQoSytzhGVKeyO25HjxfRpyQJUJwxp4ect0VdwfOP/a',NULL,NULL,NULL,0,'2022-12-22 13:04:04',NULL,0,'[\"ROLE_USER\"]',NULL);

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
	(1,2,'https://www.youtube.com/embed/oLnvs5IdPFg'),
	(9,4,'https://www.youtube.com/embed/M2gSx16vmno'),
	(4,4,'https://www.youtube.com/embed/rHMDRN6E9CE'),
	(2,4,'https://www.youtube.com/embed/XqTq53lQhKU'),
	(3,4,'https://www.youtube.com/embed/zqNXN-CG0kI'),
	(6,10,'https://www.dailymotion.com/embed/video/x8ci1yx'),
	(5,10,'https://www.youtube.com/embed/Fxp6K-I4-VY'),
	(7,10,'https://www.youtube.com/embed/ULY6RQ50Eg4');

/*!40000 ALTER TABLE `video` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
