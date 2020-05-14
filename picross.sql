-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 14 mai 2020 à 09:23
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `picross`
--

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE `comptes` (
  `Name` varchar(255) NOT NULL DEFAULT 'TBD',
  `email` varchar(255) NOT NULL DEFAULT 'TBD',
  `password` varchar(255) NOT NULL DEFAULT 'TBD',
  `ProfilePic` varchar(255) NOT NULL DEFAULT 'TBD'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`Name`, `email`, `password`, `ProfilePic`) VALUES
('TBD', 'corentin@dessenne', 'TBD', 'TBD'),
('TBD', 'Nathanlebg@test', 'mdp1', 'TBD');

-- --------------------------------------------------------

--
-- Structure de la table `connexion`
--

CREATE TABLE `connexion` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `connexion`
--

INSERT INTO `connexion` (`email`, `password`) VALUES
('admin@host', '1234'),
('corentin@dessenne', '1234'),
('Nathanlebg@test', '1234');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Picross` varchar(4000) NOT NULL,
  `Score` int(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `picross`
--

CREATE TABLE `picross` (
  `FileIndex` int(20) NOT NULL,
  `File` int(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Author` varchar(255) NOT NULL,
  `Difficulty` varchar(255) NOT NULL,
  `BestPlayer` varchar(255) NOT NULL,
  `Visibility` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `picross`
--

INSERT INTO `picross` (`FileIndex`, `File`, `Name`, `Author`, `Difficulty`, `BestPlayer`, `Visibility`) VALUES
(1, 1, 'Test', 'BEAU', '2', '123', 1),
(11, 12, 'Je suis trop beau ', 'Alexis', '2', '12', 1),
(13, 10, 'Je me suis fais tatouer', 'Ugo', '3', '12', 1),
(4, 15, 'Je suis un genie', 'Maxime', '12', '32', 0),
(9, 34, 'passion->C', 'Nathan', '23', '12', 0);

-- --------------------------------------------------------

--
-- Structure de la table `sauvegarde`
--

CREATE TABLE `sauvegarde` (
  `email` varchar(255) NOT NULL,
  `time` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lien vers tab` varchar(4000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `connexion`
--
ALTER TABLE `connexion`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `picross`
--
ALTER TABLE `picross`
  ADD PRIMARY KEY (`FileIndex`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
