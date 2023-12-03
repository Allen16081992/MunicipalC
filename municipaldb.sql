-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 29 nov 2023 om 22:17
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `municipaldb`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `complaints`
--

CREATE TABLE `klachten` (
  `ID` int(11) NOT NULL,
  `Naam` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Klacht` varchar(50) NOT NULL,
  `Beschrijving` text NOT NULL,
  `Breedtegraad` double NOT NULL,
  `Lengtegraad` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `complaints`
--

INSERT INTO `klachten` (`ID`, `Naam`, `Email`, `Klacht`, `Beschrijving`, `Breedtegraad`, `Lengtegraad`) VALUES
(1, 'asdf', 'abc@gmail.com', 'asdfg', 'asdfghsfdgh', 51.58532322347901, 3.775747312019298);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `gebruikers` (
  `ID` int(11) NOT NULL,
  `Gebruikersnaam` varchar(50) NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Salt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `gebruikers` (`ID`, `Gebruikersnaam`, `Wachtwoord`, `Email`, `Salt`) VALUES
(1, 'Stan', '$2y$10$.gszBG0kRMGaMLze4RhO2./pFsRcnVr4RXYzZOl9Ciw.XQ/G2q7LK', 'stan@gmail.com', '');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `complaints`
--
ALTER TABLE `klachten`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `complaints`
--
ALTER TABLE `klachten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `gebruikers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
