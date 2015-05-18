-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Tid vid skapande: 18 maj 2015 kl 18:46
-- Serverversion: 5.6.16
-- PHP-version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `projekt`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `idAnswer` int(11) NOT NULL AUTO_INCREMENT,
  `answer` varchar(500) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idAnswer`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `answer`
--

INSERT INTO `answer` (`idAnswer`, `answer`, `created`, `user_id`, `question_id`) VALUES
(4, '<p>hej</p>\n', '2015-05-17 20:17:28', 3, 18);

-- --------------------------------------------------------

--
-- Tabellstruktur `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `idComment` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(500) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idComment`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumpning av Data i tabell `comment`
--

INSERT INTO `comment` (`idComment`, `comment`, `created`, `user_id`, `question_id`, `answer_id`) VALUES
(8, '<p>hej</p>\n', '2015-05-17 20:17:33', 3, 18, NULL),
(9, '<p>hej</p>\n', '2015-05-17 20:22:14', 3, NULL, 4);

-- --------------------------------------------------------

--
-- Tabellstruktur `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(41) DEFAULT NULL,
  `question` varchar(500) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumpning av Data i tabell `question`
--

INSERT INTO `question` (`id`, `title`, `question`, `created`, `user_id`) VALUES
(18, 'hej', '<p>hej</p>\n', '2015-05-17 20:12:38', 3);

-- --------------------------------------------------------

--
-- Tabellstruktur `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `idTag` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(100) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idTag`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumpning av Data i tabell `tag`
--

INSERT INTO `tag` (`idTag`, `tag`, `question_id`) VALUES
(29, 'hej', 18);

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acronym` varchar(20) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `active` datetime DEFAULT NULL,
  `timesLoggedOn` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acronym` (`acronym`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`id`, `acronym`, `email`, `name`, `password`, `created`, `updated`, `deleted`, `active`, `timesLoggedOn`) VALUES
(1, 'admin', 'admin@dbwebb.se', 'Administrator', '$2y$10$7Iyuq1gDx.jnHSM2Uj.jHO3p.m2Y98jwLVnj28XMnNFdHj00yXY1a', '2015-05-15 15:38:05', NULL, NULL, '2015-05-15 15:38:05', 3),
(2, 'doe', 'doe@dbwebb.se', 'John/Jane Doe', '$2y$10$GwttdsLnSlQAaJiTbx4Eu.vkvEnCnpLwWMf1ORA4Hg37K.aryUuNO', '2015-05-15 15:38:05', NULL, NULL, '2015-05-15 15:38:05', 1),
(3, 'dave', 'dave@gmail.com', 'dave', '$2y$10$0PEzsV0jeOz2y4P3P5.B1eTSpUTMyIHqhQc8EHt32xIotZTSb8VnG', '2015-05-15 21:11:32', NULL, NULL, '2015-05-15 21:11:32', 14),
(4, 'base', 'base@gmail.com', 'base', '$2y$10$X6zFOY8uVIzQsrzkVAjXF.fLOlrtIipKH3DONjvBRMCHzY6EIrgXO', '2015-05-17 18:46:45', NULL, NULL, '2015-05-17 18:46:45', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
