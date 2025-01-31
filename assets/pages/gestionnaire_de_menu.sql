-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 31 jan. 2025 à 08:57
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionnaire_de_menu`
--

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `categorie` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`id`, `nom`, `description`, `prix`, `categorie`) VALUES
(1, 'Menu Napolitaine', 'Pizza Napolitaine avec dessert et boisson au choix', 20, 'Menu'),
(2, 'Menu Savoyard', 'Pizza Champignons avec dessert et boisson au choix', 22, 'Menu'),
(3, 'Menu Calzone', 'Pizza Calzone avec dessert et boisson au choix', 23, 'Menu'),
(4, 'Menu Végétarien', 'Pizza Végétarienne avec dessert et boisson au choix', 25, 'Menu'),
(5, 'Menu Exception', 'Pizza à la Truffe avec dessert et boisson au choix', 29, 'Menu');

-- --------------------------------------------------------

--
-- Structure de la table `plat`
--

DROP TABLE IF EXISTS `plat`;
CREATE TABLE IF NOT EXISTS `plat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `categorie` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `plat`
--

INSERT INTO `plat` (`id`, `nom`, `description`, `prix`, `categorie`) VALUES
(1, 'Napolitaine', 'Sauce tomate, Mozzarella, Chorizo, Basilic frais', 14, 'Pizza'),
(2, 'Champignons', 'Crème fraîche, Mozzarella, Champignons, Filet de sauce tomate, Basilic', 15, 'Pizza'),
(3, 'Hawaïenne', 'Base crème, ananas, etc...', 12, 'Pizza'),
(15, 'La Truffe', 'Crème fraîche, Mozzarella, Truffes noires, Champignons, Basilic', 18.5, 'Pizza');

-- --------------------------------------------------------

--
-- Structure de la table `plat_menu`
--

DROP TABLE IF EXISTS `plat_menu`;
CREATE TABLE IF NOT EXISTS `plat_menu` (
  `id_plat` int NOT NULL,
  `id_menu` int NOT NULL,
  KEY `id_plat` (`id_plat`,`id_menu`),
  KEY `id_menu` (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`) VALUES
(1, '', 0),
(2, '', 0),
(3, '', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `plat_menu`
--
ALTER TABLE `plat_menu`
  ADD CONSTRAINT `plat_menu_ibfk_1` FOREIGN KEY (`id_plat`) REFERENCES `plat` (`id`),
  ADD CONSTRAINT `plat_menu_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
