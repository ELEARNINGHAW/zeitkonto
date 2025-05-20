-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Mai 2025 um 23:18
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `zeitkonto`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `auslastungsgrund`
--

CREATE TABLE `auslastungsgrund` (
  `Grund` varchar(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'q',
  `Text` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Kappung` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Kappungsgrenze'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `auslastungsgrund`
--

INSERT INTO `auslastungsgrund` (`Grund`, `Text`, `Kappung`) VALUES
('B', 'Betreuung von Bachelor- oder Masterarbeiten', 4),
('D', 'Betreuung von Diplomarbeiten', 4),
('E', 'Funktionsentlastung (Fakultät)', 0),
('F', 'Forschungsentlastung', 0),
('H', 'Betreuung von Hauptpraktika', 0),
('L', 'Betreuung von Staatsexamina', 0),
('M', 'genehmigte Mehrarbeit', 0),
('P', 'Betreuung von Studienprojekten', 0),
('S', 'sonstiges', 0),
('U', 'Umwidmung der Forschungsentlastung', 0),
('X', 'Lehrexport', 0),
('Z', 'Funktionsentlastung (Funktionspool)', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `auslastungsgrund`
--
ALTER TABLE `auslastungsgrund`
  ADD PRIMARY KEY (`Grund`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
