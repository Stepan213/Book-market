-- phpMyAdmin SQL Dump
-- version 3.5.FORPSI
-- http://www.phpmyadmin.net
--
-- Počítač: 81.2.194.100
-- Vygenerováno: Stř 04. zář 2019, 20:29
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
-- Struktura tabulky `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `Base` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `BaseD` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `Longer` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `LongerD` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Short` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `ShortD` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `Other` varchar(30) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `subjects`
--

INSERT INTO `subjects` (`Base`, `BaseD`, `Longer`, `LongerD`, `Short`, `ShortD`, `Other`) VALUES
('aj', '', 'anglictina', 'angličtina', 'ajina', 'ájina', 'anglic'),
('cj', 'čj', 'cestina', 'čeština', 'cesky', 'český', 'literatura'),
('nj', '', 'nemcina', 'němčina', '', '', 'němec'),
('fy', '', 'fyzika', '', '', '', 'fyzik'),
('ma', '', 'matematika', '', 'matika', '', 'matematic'),
('ch', '', 'chemie', '', '', '', 'chemic'),
('de', 'dě', 'dejepis', 'dějepis', 'dejak', 'děják', ''),
('ze', 'atlas', 'zemepis', 'zeměpis', 'zemak', 'zemák', 'geografie'),
('zsv', '', 'zaklady spolecenskych ved', 'základy společenských věd', 'zaklady spol. ved', 'základy spol. věd', ''),
('bi', '', 'biologie', '', 'bizule', 'bižule', ''),
('fj', 'fr', 'francouzstina', 'francouzština', 'frajina', 'frájina', 'franc');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
