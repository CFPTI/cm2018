-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 23 sep. 2021 à 14:07
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `escaperoomstat`
--

-- --------------------------------------------------------

--
-- Structure de la table `inscrits`
--

DROP TABLE IF EXISTS `inscrits`;
CREATE TABLE IF NOT EXISTS `inscrits` (
  `idInscrit` int(11) NOT NULL AUTO_INCREMENT,
  `nbPersonne` int(11) NOT NULL,
  `heureDebut` varchar(30) NOT NULL,
  `heureFIn` varchar(30) NOT NULL,
  `jour` varchar(30) NOT NULL,
  PRIMARY KEY (`idInscrit`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `inscrits`
--

INSERT INTO `inscrits` (`idInscrit`, `nbPersonne`, `heureDebut`, `heureFIn`, `jour`) VALUES
(1, 3, '13:00', '13:20', 'Vendredi'),
(2, 3, '13:55', '13:56', 'Vendredi'),
(3, 3, '13:55', '13:57', 'Vendredi'),
(4, 3, '13:55', '13:57', 'Vendredi'),
(5, 3, '13:55', '13:58', 'Vendredi'),
(6, 0, '13:58', '13:58', ''),
(7, 0, '13:58', '14:00', ''),
(8, 0, '13:58', '14:01', ''),
(9, 0, '13:58', '14:01', ''),
(10, 0, '13:58', '14:01', ''),
(11, 0, '13:58', '16:02', ''),
(12, 0, '16:02', '16:02', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
