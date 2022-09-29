-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forummvc
CREATE DATABASE IF NOT EXISTS `forummvc` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `forummvc`;

-- Listage de la structure de la table forummvc. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `datePost` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `post_user` (`user_id`),
  KEY `post_topic` (`topic_id`),
  CONSTRAINT `post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Listage des données de la table forummvc.post : ~7 rows (environ)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` (`id_post`, `text`, `datePost`, `user_id`, `topic_id`) VALUES
	(7, 'Post 1', '2022-09-22 15:38:41', 4, 5),
	(8, 'Post 2', '2022-09-22 15:38:51', 5, 5),
	(9, 'Post 3', '2022-09-26 10:36:26', 5, 6),
	(10, 'aaa', '2022-09-28 11:10:53', 4, 12),
	(11, 'hello', '2022-09-28 11:24:51', 4, 12),
	(12, 'Autre test de post', '2022-09-28 11:26:59', 6, 12),
	(13, 'Mon premier message', '2022-09-28 11:36:01', 6, 13),
	(16, 'Exemple Symfony ', '2022-09-28 16:22:34', 4, 14);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

-- Listage de la structure de la table forummvc. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `dateTopic` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `locked` tinyint(4) DEFAULT '0',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `topic_user` (`user_id`),
  CONSTRAINT `topic_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Listage des données de la table forummvc.topic : ~5 rows (environ)
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` (`id_topic`, `title`, `dateTopic`, `locked`, `user_id`) VALUES
	(5, 'First topic', '2022-09-22 15:38:31', 0, 6),
	(6, 'Second topic', '2022-09-22 16:10:43', 1, 5),
	(12, 'Test topic', '2022-09-28 11:10:53', 0, 4),
	(13, 'Test CSS', '2022-09-28 11:36:01', 0, 6),
	(14, 'Symfony', '2022-09-28 15:04:44', 0, 4);
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;

-- Listage de la structure de la table forummvc. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Listage des données de la table forummvc.user : ~0 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `nickname`, `email`, `password`, `creationDate`, `role`, `status`) VALUES
	(4, 'micka', 'mickael@exemple.com', '$2y$10$rYDxWOlkZWvSfGKCeIAtveuSUfyYueM3GW7M0fJdpRe7hq5fa65QG', '2022-09-22 15:38:03', '["ROLE_USER"}', 1),
	(5, 'quentin', 'quentin@exemple.com', '$2y$10$rYDxWOlkZWvSfGKCeIAtveuSUfyYueM3GW7M0fJdpRe7hq5fa65QG', '2022-09-26 14:47:34', '["ROLE_USER"]', 1),
	(6, 'stephane', 'stephane@exemple.com', '$2y$10$rYDxWOlkZWvSfGKCeIAtveuSUfyYueM3GW7M0fJdpRe7hq5fa65QG', '2022-09-26 16:04:16', '["ROLE_USER"]', 1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
