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
CREATE DATABASE IF NOT EXISTS `sudoku_master` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sudoku_master`;

-- Listage de la structure de table sudoku_master. classer
CREATE TABLE IF NOT EXISTS `classer` (
  `id_classer` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `id_mode` int NOT NULL,
  `score_global` int NOT NULL,
  `grilles_jouees` int NOT NULL,
  `grilles_resolues` int NOT NULL,
  `temps_moyen` time NOT NULL,
  `meilleur_temps` time NOT NULL,
  `serie_victoires` int NOT NULL,
  PRIMARY KEY (`id_classer`) USING BTREE,
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_mode` (`id_mode`),
  CONSTRAINT `classer_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`),
  CONSTRAINT `classer_ibfk_2` FOREIGN KEY (`id_mode`) REFERENCES `mode` (`id_mode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table sudoku_master.classer : ~0 rows (environ)

-- Listage de la structure de table sudoku_master. difficulte
CREATE TABLE IF NOT EXISTS `difficulte` (
  `id_difficulte` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id_difficulte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table sudoku_master.difficulte : ~0 rows (environ)

-- Listage de la structure de table sudoku_master. mode
CREATE TABLE IF NOT EXISTS `mode` (
  `id_mode` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id_mode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table sudoku_master.mode : ~0 rows (environ)

-- Listage de la structure de table sudoku_master. participer
CREATE TABLE IF NOT EXISTS `participer` (
  `id_participer` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `id_partie` int NOT NULL,
  `numero_salle` varchar(10) NOT NULL,
  PRIMARY KEY (`id_participer`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_partie` (`id_partie`),
  CONSTRAINT `participer_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`),
  CONSTRAINT `participer_ibfk_2` FOREIGN KEY (`id_partie`) REFERENCES `partie` (`id_partie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table sudoku_master.participer : ~0 rows (environ)

-- Listage de la structure de table sudoku_master. partie
CREATE TABLE IF NOT EXISTS `partie` (
  `id_partie` int NOT NULL AUTO_INCREMENT,
  `id_mode` int NOT NULL,
  `id_difficulte` int NOT NULL,
  `duree` time DEFAULT NULL,
  `gagnant` int DEFAULT NULL,
  PRIMARY KEY (`id_partie`),
  KEY `id_mode` (`id_mode`),
  KEY `id_difficulte` (`id_difficulte`),
  CONSTRAINT `partie_ibfk_1` FOREIGN KEY (`id_mode`) REFERENCES `mode` (`id_mode`),
  CONSTRAINT `partie_ibfk_2` FOREIGN KEY (`id_difficulte`) REFERENCES `difficulte` (`id_difficulte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table sudoku_master.partie : ~0 rows (environ)

-- Listage de la structure de table sudoku_master. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table sudoku_master.role : ~2 rows (environ)
INSERT INTO `role` (`id_role`, `libelle`) VALUES
	(1, 'Administrateur'),
	(2, 'Utilisateur');

-- Listage de la structure de table sudoku_master. utilisateur
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `id_role` int NOT NULL DEFAULT '2',
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `inactif` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_utilisateur`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
