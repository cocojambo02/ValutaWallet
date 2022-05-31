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
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `uid` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `USD` int(11) DEFAULT 0,
  `EUR` int(11) DEFAULT 0,
  `GBP` int(11) DEFAULT NULL,
  `admin` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `mobile`, `password`, `USD`, `EUR`, `GBP`, `admin`) VALUES
(1, 'mircea bravo', 'a.a@outlook.com', '+40721264977', '40f5888b67c748df7efba008e7c2f9d2', 30, 20, 3, 'admin@admin'),
(14, 'unu', 'cosmin.neamtiu@outlook.com', '+40721264977', '698d51a19d8a121ce581499d7b701668', 111, 111, 111, 'admin@admin'),
(7, 'john bon jovi', '1@1.com', '+40721264977', '14e1b600b1fd579f47433b88e8d85291', 32, 32, 23, 'admin@admin'),
(8, 'Cosmin Neamtiu', 'cosmin.neamtiu@outlook.com', '+40721264977', '0cc175b9c0f1b6a831c399e269772661', 1, 1, 1, 'admin@admin'),
(11, 'unu', 'cosmin.neamtiu@outlook.com', '+40721264977', '900150983cd24fb0d6963f7d28e17f72', 2, 2, 2, 'admin@admin'),
(13, 'Cosmin Neamtiu', 'cosmin.neamtiu@outlook.com', '+40721264977', '827ccb0eea8a706c4c34a16891f84e7b', 100, 2, 471, 'admin@admin'),
(12, 'b', 'b@b.com', '+1234567890', 'ab56b4d92b40713acc5af89985d4b786', 1, 1, 1, 'admin@admin'),
(15, 'unu', 'cosmin.neamtiu@outlook.com', '+40721264977', '202cb962ac59075b964b07152d234b70', 222, 222, 222, 'admin@admin');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `uid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
