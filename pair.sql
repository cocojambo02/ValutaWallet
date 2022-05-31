-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: mai 31, 2022 la 12:42 PM
-- Versiune server: 10.4.22-MariaDB
-- Versiune PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `login_system`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `pair`
--

CREATE TABLE `pair` (
  `from_valuta` varchar(5) NOT NULL,
  `to_valuta` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `pair`
--

INSERT INTO `pair` (`from_valuta`, `to_valuta`) VALUES
('EUR', 'GBP'),
('EUR', 'USD'),
('GBP', 'EUR'),
('GBP', 'USD'),
('USD', 'EUR'),
('USD', 'GBP');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `pair`
--
ALTER TABLE `pair`
  ADD PRIMARY KEY (`from_valuta`,`to_valuta`),
  ADD KEY `fk_to_valuta` (`to_valuta`);

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `pair`
--
ALTER TABLE `pair`
  ADD CONSTRAINT `fk_from_valuta` FOREIGN KEY (`from_valuta`) REFERENCES `valuta` (`name`),
  ADD CONSTRAINT `fk_to_valuta` FOREIGN KEY (`to_valuta`) REFERENCES `valuta` (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
