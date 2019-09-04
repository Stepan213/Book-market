-- phpMyAdmin SQL Dump
-- version 3.5.FORPSI
-- http://www.phpmyadmin.net
--
-- Počítač: 81.2.194.100
-- Vygenerováno: Stř 04. zář 2019, 20:38
-- Verze MySQL: 5.6.43-84.3-log
-- Verze PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Struktura tabulky `main`
--

CREATE TABLE IF NOT EXISTS `main` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `URL` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  `BookName` varchar(240) COLLATE utf8_czech_ci NOT NULL,
  `Subject` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  `SchoolYear` int(11) NOT NULL,
  `PhotoURL` varchar(240) COLLATE utf8_czech_ci NOT NULL,
  `Price` int(11) NOT NULL,
  `Note` text COLLATE utf8_czech_ci NOT NULL,
  `UserName` varchar(120) COLLATE utf8_czech_ci NOT NULL,
  `Mail` varchar(120) COLLATE utf8_czech_ci NOT NULL,
  `OtherContact` varchar(360) COLLATE utf8_czech_ci NOT NULL,
  `Password` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  `IsGroup` int(11) NOT NULL DEFAULT '0',
  `Code` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=56 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
