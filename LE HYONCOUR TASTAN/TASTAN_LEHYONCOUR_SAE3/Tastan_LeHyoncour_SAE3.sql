-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 14 Juin 2024 à 18:59
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `club_tennis`
--
CREATE DATABASE IF NOT EXISTS `club_tennis` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `club_tennis`;

-- --------------------------------------------------------

--
-- Structure de la table `adherents`
--

CREATE TABLE `adherents` (
  `id` int(11) NOT NULL,
  `competition_id` int(11) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `niveau_pratique` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `adherents`
--

INSERT INTO `adherents` (`id`, `competition_id`, `nom`, `prenom`, `niveau_pratique`) VALUES
(31, 22, 'essai', 'essai', 'essai');

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `Nom` varchar(50) NOT NULL,
  `mdp` varchar(100) DEFAULT NULL,
  `salt` varchar(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`Nom`, `mdp`, `salt`) VALUES
('Admin', '$2y$10$B18o2iWYw1RKlrTugpyunOLxQgOFQR6PeeX8YCLLRItdBp5K0ovuG', '063c2f6b284abaf7f3998b07569184cd');

-- --------------------------------------------------------

--
-- Structure de la table `competitions`
--

CREATE TABLE `competitions` (
  `id` int(11) NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `horaire` datetime NOT NULL,
  `joueurs_necessaires` int(11) NOT NULL,
  `places_disponibles` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `competitions`
--

INSERT INTO `competitions` (`id`, `lieu`, `horaire`, `joueurs_necessaires`, `places_disponibles`) VALUES
(23, 'Saint-Die', '2024-06-22 10:00:00', 6, 1),
(22, 'Saint-Die', '2024-06-10 10:00:00', 18, 12);

-- --------------------------------------------------------

--
-- Structure de la table `demandes_inscription`
--

CREATE TABLE `demandes_inscription` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `niveau_pratique` varchar(50) NOT NULL,
  `etat` varchar(20) DEFAULT 'en_attente',
  `date_demande` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `demandes_inscription`
--

INSERT INTO `demandes_inscription` (`id`, `nom`, `prenom`, `niveau_pratique`, `etat`, `date_demande`) VALUES
(1, 'CHEVALIER', 'Noemy', 'Debutante', 'en_attente', '2024-06-11 06:59:20');

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

CREATE TABLE `document` (
  `id_img` int(11) NOT NULL,
  `img_nom` varchar(255) NOT NULL,
  `img_chemin` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `document_administratif`
--

CREATE TABLE `document_administratif` (
  `id_fichier` int(11) NOT NULL,
  `nom_fich` varchar(255) NOT NULL,
  `chemin_fich` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `document_administratif`
--

INSERT INTO `document_administratif` (`id_fichier`, `nom_fich`, `chemin_fich`) VALUES
(13, 'Formulaire_dinscription.pdf', 'documentAdmin/Formulaire_dinscription.pdf'),
(12, 'Calendrier.pdf', 'documentAdmin/Calendrier.pdf'),
(11, 'Programme_Hebdomadaire.pdf', 'documentAdmin/Programme_Hebdomadaire.pdf'),
(14, 'utilisateur.png', 'documentAdmin/utilisateur.png'),
(15, '1.2.jpg', 'documentAdmin/1.2.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `galerie`
--

CREATE TABLE `galerie` (
  `id` int(11) NOT NULL,
  `nom_img` varchar(255) NOT NULL,
  `chemin_img` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `galerie`
--

INSERT INTO `galerie` (`id`, `nom_img`, `chemin_img`) VALUES
(13, 'cours4.jpeg', 'img/cours4.jpeg'),
(12, 'cours3.jpeg', 'img/cours3.jpeg'),
(11, 'cours2.jpeg', 'img/cours2.jpeg'),
(10, 'cours1.jpeg', 'img/cours1.jpeg'),
(14, 'cours5.jpeg', 'img/cours5.jpeg'),
(15, 'cours6.jpeg', 'img/cours6.jpeg'),
(16, 'logo.png', 'img/logo.png');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `ID` int(11) NOT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Niveau` varchar(20) DEFAULT NULL,
  `Ville` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`ID`, `Nom`, `Prenom`, `Age`, `Niveau`, `Ville`, `password`, `salt`) VALUES
(10, 'lantz', 'Noemy', 20, NULL, 'Abreschviller', '$2y$10$ORx70LahWLoyOu4NQtnb1ORXxtgnR85lGK5SW4xOyvrhnBdPsjL56', NULL),
(11, 'januzi', 'rinor', 21, NULL, 'Colmar', '$2y$10$OBocj61BF2zRyaXZs0o.7Onqy.bI6MbAluAkriERUD1x7.d8Pv7MG', '0852c3af45420726b73ffc284d3a2aca'),
(12, 'tastan', 'fatih', 25, NULL, 'Sarrebourg', '$2y$10$DkFI1hz5TMjMsQGc/7diXeWZMzBHx8YhiTwJ0deaTSee0vGfoh0IK', '180114ead4485ad206b82427aeb183e5');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `adherents`
--
ALTER TABLE `adherents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_competition` (`competition_id`);

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Nom`);

--
-- Index pour la table `competitions`
--
ALTER TABLE `competitions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `demandes_inscription`
--
ALTER TABLE `demandes_inscription`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id_img`);

--
-- Index pour la table `document_administratif`
--
ALTER TABLE `document_administratif`
  ADD PRIMARY KEY (`id_fichier`);

--
-- Index pour la table `galerie`
--
ALTER TABLE `galerie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `adherents`
--
ALTER TABLE `adherents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `competitions`
--
ALTER TABLE `competitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT pour la table `demandes_inscription`
--
ALTER TABLE `demandes_inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `document`
--
ALTER TABLE `document`
  MODIFY `id_img` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `document_administratif`
--
ALTER TABLE `document_administratif`
  MODIFY `id_fichier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `galerie`
--
ALTER TABLE `galerie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
