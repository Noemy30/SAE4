-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 18 jan. 2024 à 18:46
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `club_tennis`
--

-- --------------------------------------------------------

--
-- Structure de la table `adherents`
--

DROP TABLE IF EXISTS `adherents`;
CREATE TABLE IF NOT EXISTS `adherents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `competition_id` int DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `niveau_pratique` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_competition` (`competition_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `ID` varchar(50) NOT NULL,
  `mdp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`ID`, `mdp`) VALUES
('Admin', 'MotDePasseAdmin88100');

-- --------------------------------------------------------

--
-- Structure de la table `competitions`
--

DROP TABLE IF EXISTS `competitions`;
CREATE TABLE IF NOT EXISTS `competitions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lieu` varchar(255) NOT NULL,
  `horaire` datetime NOT NULL,
  `joueurs_necessaires` int NOT NULL,
  `places_disponibles` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `competitions`
--

INSERT INTO `competitions` (`id`, `lieu`, `horaire`, `joueurs_necessaires`, `places_disponibles`) VALUES
(6, 'Saint-dié', '2024-04-12 14:00:00', 12, 12),
(5, 'Saint-dié', '2024-01-15 10:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `demandes_inscription`
--

DROP TABLE IF EXISTS `demandes_inscription`;
CREATE TABLE IF NOT EXISTS `demandes_inscription` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `niveau_pratique` varchar(50) NOT NULL,
  `etat` varchar(20) DEFAULT 'en_attente',
  `date_demande` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `id_img` int NOT NULL AUTO_INCREMENT,
  `img_nom` varchar(255) NOT NULL,
  `img_chemin` varchar(255) NOT NULL,
  PRIMARY KEY (`id_img`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `document_administratif`
--

DROP TABLE IF EXISTS `document_administratif`;
CREATE TABLE IF NOT EXISTS `document_administratif` (
  `id_fichier` int NOT NULL AUTO_INCREMENT,
  `nom_fich` varchar(255) NOT NULL,
  `chemin_fich` varchar(255) NOT NULL,
  PRIMARY KEY (`id_fichier`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `document_administratif`
--

INSERT INTO `document_administratif` (`id_fichier`, `nom_fich`, `chemin_fich`) VALUES
(13, 'Formulaire_dinscription.pdf', 'documentAdmin/Formulaire_dinscription.pdf'),
(12, 'Calendrier.pdf', 'documentAdmin/Calendrier.pdf'),
(11, 'Programme_Hebdomadaire.pdf', 'documentAdmin/Programme_Hebdomadaire.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `galerie`
--

DROP TABLE IF EXISTS `galerie`;
CREATE TABLE IF NOT EXISTS `galerie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_img` varchar(255) NOT NULL,
  `chemin_img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `galerie`
--

INSERT INTO `galerie` (`id`, `nom_img`, `chemin_img`) VALUES
(13, 'cours4.jpeg', 'image/cours4.jpeg'),
(12, 'cours3.jpeg', 'image/cours3.jpeg'),
(11, 'cours2.jpeg', 'image/cours2.jpeg'),
(10, 'cours1.jpeg', 'image/cours1.jpeg'),
(14, 'cours5.jpeg', 'image/cours5.jpeg'),
(15, 'cours6.jpeg', 'image/cours6.jpeg'),
(16, 'logo.png', 'image/logo.png');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `ID` int NOT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Age` int DEFAULT NULL,
  `Niveau` varchar(20) DEFAULT NULL,
  `Ville` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`ID`, `Nom`, `Prenom`, `Age`, `Niveau`, `Ville`, `password`) VALUES
(1, 'Dupontssssss', 'Jean', 25, 'Débutant', 'Paris', 'pass1'),
(2, 'Martin', 'Sophie', 30, 'Intermédiaire', 'Paris', 'pass2'),
(0, 'Doe', 'John', 25, 'Débutant', 'VilleA', 'motdepasse1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
