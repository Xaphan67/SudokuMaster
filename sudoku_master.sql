-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour sudoku_master
DROP DATABASE IF EXISTS `sudoku_master`;
CREATE DATABASE IF NOT EXISTS `sudoku_master` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sudoku_master`;

-- Listage de la structure de table sudoku_master. role
DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `libelle_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table sudoku_master.role : ~2 rows (environ)
INSERT INTO `role` (`id_role`, `libelle_role`) VALUES
	(1, 'Administrateur'),
	(2, 'Utilisateur');

-- Listage de la structure de table sudoku_master. utilisateur
DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `Id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `date_inscription_utilisateur` date NOT NULL DEFAULT (curdate()),
  `pseudo_utilisateur` varchar(50) NOT NULL,
  `email_utilisateur` varchar(100) NOT NULL,
  `mdp_utilisateur` varchar(255) NOT NULL,
  `inactif` tinyint NOT NULL DEFAULT '0',
  `id_role` int NOT NULL DEFAULT '2',
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_date_expiration` datetime DEFAULT NULL,
  PRIMARY KEY (`Id_utilisateur`),
  UNIQUE KEY `reset_token` (`reset_token_hash`) USING BTREE,
  KEY `id_role` (`id_role`),
  CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table sudoku_master.utilisateur : ~1 rows (environ)
INSERT INTO `utilisateur` (`Id_utilisateur`, `pseudo_utilisateur`, `email_utilisateur`, `mdp_utilisateur`, `inactif`, `id_role`, `reset_token_hash`, `reset_token_date_expiration`) VALUES
	(1, 'Admin', 'admin@sudokumaster.com', '$2y$10$udYnbRxrFHxXHHNo1IYp9uOuhekF7PDn6K95T07LaIpewn4CulsiK', 0, 1, NULL, NULL);

-- Listage de la structure de table sudoku_master. mode_de_jeu
DROP TABLE IF EXISTS `mode_de_jeu`;
CREATE TABLE IF NOT EXISTS `mode_de_jeu` (
  `id_mode_de_jeu` int NOT NULL,
  `libelle_mode_de_jeu` varchar(50) NOT NULL,
  PRIMARY KEY (`id_mode_de_jeu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table sudoku_master.mode_de_jeu : ~3 rows (environ)
INSERT INTO `mode_de_jeu` (`id_mode_de_jeu`, `libelle_mode_de_jeu`) VALUES
	(1, 'Solo'),
	(2, 'Coopératif'),
	(3, 'Compétitif');

-- Listage de la structure de table sudoku_master. classer
DROP TABLE IF EXISTS `classer`;
CREATE TABLE IF NOT EXISTS `classer` (
  `Id_utilisateur` int NOT NULL,
  `id_mode_de_jeu` int NOT NULL,
  `score_global` int NOT NULL,
  `grilles_jouees` int NOT NULL,
  `grilles_resolues` int NOT NULL,
  `temps_moyen` time NOT NULL,
  `meilleur_temps` time NOT NULL,
  `serie_victoires` int NOT NULL,
  PRIMARY KEY (`Id_utilisateur`,`id_mode_de_jeu`),
  KEY `id_mode_de_jeu` (`id_mode_de_jeu`),
  CONSTRAINT `classer_ibfk_1` FOREIGN KEY (`Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`),
  CONSTRAINT `classer_ibfk_2` FOREIGN KEY (`id_mode_de_jeu`) REFERENCES `mode_de_jeu` (`id_mode_de_jeu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table sudoku_master.classer : ~3 rows (environ)
INSERT INTO `classer` (`Id_utilisateur`, `id_mode_de_jeu`, `score_global`, `grilles_jouees`, `grilles_resolues`, `temps_moyen`, `meilleur_temps`, `serie_victoires`) VALUES
	(1, 1, 1000, 0, 0, '00:15:00', '00:15:00', 0),
	(1, 2, 1000, 0, 0, '00:15:00', '00:15:00', 0),
	(1, 3, 1000, 0, 0, '00:15:00', '00:15:00', 0);

-- Listage de la structure de table sudoku_master. difficulte
DROP TABLE IF EXISTS `difficulte`;
CREATE TABLE IF NOT EXISTS `difficulte` (
  `id_difficulte` int NOT NULL AUTO_INCREMENT,
  `libelle_difficulte` varchar(50) NOT NULL,
  PRIMARY KEY (`id_difficulte`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table sudoku_master.difficulte : ~3 rows (environ)
INSERT INTO `difficulte` (`id_difficulte`, `libelle_difficulte`) VALUES
	(1, 'Facile'),
	(2, 'Moyen'),
	(3, 'Difficile');

-- Listage de la structure de table sudoku_master. partie
DROP TABLE IF EXISTS `partie`;
CREATE TABLE IF NOT EXISTS `partie` (
  `id_partie` int NOT NULL AUTO_INCREMENT,
  `date_partie` date DEFAULT NULL,
  `duree_partie` time DEFAULT NULL,
  `id_mode_de_jeu` int NOT NULL,
  `id_difficulte` int NOT NULL,
  PRIMARY KEY (`id_partie`),
  KEY `id_mode_de_jeu` (`id_mode_de_jeu`),
  KEY `id_difficulte` (`id_difficulte`),
  CONSTRAINT `partie_ibfk_1` FOREIGN KEY (`id_mode_de_jeu`) REFERENCES `mode_de_jeu` (`id_mode_de_jeu`),
  CONSTRAINT `partie_ibfk_2` FOREIGN KEY (`id_difficulte`) REFERENCES `difficulte` (`id_difficulte`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table sudoku_master.partie : ~0 rows (environ)

-- Listage de la structure de table sudoku_master. participer
DROP TABLE IF EXISTS `participer`;
CREATE TABLE IF NOT EXISTS `participer` (
  `Id_utilisateur` int NOT NULL,
  `id_partie` int NOT NULL,
  `gagnant` tinyint NOT NULL DEFAULT '0',
  `score` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id_utilisateur`,`id_partie`),
  KEY `id_partie` (`id_partie`),
  CONSTRAINT `participer_ibfk_1` FOREIGN KEY (`Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`),
  CONSTRAINT `participer_ibfk_2` FOREIGN KEY (`id_partie`) REFERENCES `partie` (`id_partie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table sudoku_master.participer : ~0 rows (environ)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
