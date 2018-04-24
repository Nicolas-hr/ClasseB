-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 10 Janvier 2018 à 16:41
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `squelch`
--

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

CREATE TABLE IF NOT EXISTS `mission` (
  `idmission` int(11) NOT NULL AUTO_INCREMENT,
  `codemission` varchar(15) NOT NULL,
  `descriptionmission` text NOT NULL,
  PRIMARY KEY (`idmission`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=10 ;

--
-- Contenu de la table `mission`
--

INSERT INTO `mission` (`idmission`, `codemission`, `descriptionmission`) VALUES
(1, 'Entrainement', 'Soldat, en tant que nouvelle recrue, vous devez vous familiariser avec vos nouvelles armes. \n\nRendez vous au terrain d''entrainement, vous y trouverez votre arme et des munitions. \n\nTouchez les cibles le plus rapidement possible, et marquez le plus de points. \n\nBon courage soldat!\n'),
(2, 'Extraction', 'Soldat, pour votre premiere mission, vous devez abattre les differentes cibles le plus vite possible. \n<br>\nSoyez precis et efficace.\n<br>\n Nous ne souhaitons pas de degats collateraux. \n<br>\n<br>\nBon courage soldat.'),
(3, 'Vagues', 'Soldat, <br> nous vous informons que de nombreuses vagues de soldats ennemis se dirigent vers votre position.<br> Abattez les, et rentrez sain et sauf au bercail.<br> Bon courage soldat! '),
(4, 'Survie', 'Soldat, dans cette mission vous devrez survivre le plus longtemps a de nombreux ennemis arrivant sur votre position. <br>Ne les laissez pas vous toucher! <br>Bon courage Soldat!'),
(5, 'test5', ''),
(6, 'test6', 'sdwdsdasdasd'),
(7, 'test7', 'kekekekekeke'),
(8, 'test8', '161616161661616'),
(9, 'test0', 'asdasdsadsad');

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `idPlayer` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(15) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  PRIMARY KEY (`idPlayer`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=6 ;

--
-- Contenu de la table `player`
--

INSERT INTO `player` (`idPlayer`, `pseudo`, `motdepasse`) VALUES
(1, 'test', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(2, 'test', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(3, 'a', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8'),
(4, 'Nicochon', '5f61f15bee26cddec466fdd09e3c818a8fe6d27c'),
(5, 'Kadar', '3fae037cde61457defff66668073476d38742c3a');

-- --------------------------------------------------------

--
-- Structure de la table `progression`
--

CREATE TABLE IF NOT EXISTS `progression` (
  `idJoueur` int(11) NOT NULL AUTO_INCREMENT,
  `mission1Score` int(11) NOT NULL,
  `mission2Score` int(11) NOT NULL,
  `mission3Score` int(11) NOT NULL,
  `mission4Score` int(11) NOT NULL,
  `mission5Score` int(11) NOT NULL,
  `mission6Score` int(11) NOT NULL,
  `mission7Score` int(11) NOT NULL,
  `mission8Score` int(11) NOT NULL,
  `mission9Score` int(11) NOT NULL,
  `progression` int(11) NOT NULL,
  PRIMARY KEY (`idJoueur`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=6 ;

--
-- Contenu de la table `progression`
--

INSERT INTO `progression` (`idJoueur`, `mission1Score`, `mission2Score`, `mission3Score`, `mission4Score`, `mission5Score`, `mission6Score`, `mission7Score`, `mission8Score`, `mission9Score`, `progression`) VALUES
(1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 98, 122, 0, 0, 0, 0, 0, 0, 0, 3),
(4, 61, 116, 0, 0, 0, 0, 0, 0, 0, 3),
(5, 143, 0, 0, 0, 0, 0, 0, 0, 0, 2);

-- --------------------------------------------------------

--
-- Structure de la table `reglages`
--

CREATE TABLE IF NOT EXISTS `reglages` (
  `idPlayer` int(11) NOT NULL AUTO_INCREMENT,
  `Son` int(3) NOT NULL,
  PRIMARY KEY (`idPlayer`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `reglages`
--

INSERT INTO `reglages` (`idPlayer`, `Son`) VALUES
(1, 50),
(2, 50),
(3, 41),
(4, 50),
(5, 50);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
