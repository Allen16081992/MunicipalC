-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 14 jan 2024 om 22:00
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
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `ID` int(11) NOT NULL,
  `Gebruikersnaam` varchar(50) NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Salt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`ID`, `Gebruikersnaam`, `Wachtwoord`, `Email`, `Salt`) VALUES
(5, 'Stanislav', '$2y$12$Ui/fhjq2zWcODXtnFoJQkeG2nqZcGxV.u3cXkNuxdCLUNHe4BRp6u', 'stanislav43@hotmail.com', '4fc89d35711d9af4b8b3bae842a6d8ee');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klachten`
--

CREATE TABLE `klachten` (
  `ID` int(11) NOT NULL,
  `Naam` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Klacht` varchar(50) NOT NULL,
  `Beschrijving` text NOT NULL,
  `Breedtegraad` double NOT NULL,
  `Lengtegraad` double NOT NULL,
  `Datum` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `klachten`
--

INSERT INTO `klachten` (`ID`, `Naam`, `Email`, `Klacht`, `Beschrijving`, `Breedtegraad`, `Lengtegraad`, `Datum`) VALUES
(1, 'Michelle Richters', 'm.richters24@hotmail.com', 'Portiek nog steeds ravage', 'Waarom is onze portiek nog steeds niet gemaakt van afgelopen explosie?', 51.55853884141291, 3.6865677899662113, '2024-01-09 19:27:55'),
(2, 'Danisha Suo', 'dani_s29@yahoo.com', 'Vervelende Jongen', 'Een jongen roept en flirt wanneer ik naar buiten ga. Kan hij contactverbod krijgen?', 51.58670535608454, 3.7477607863188305, '2024-01-10 12:53:20'),
(3, 'Hans Breuker', 'h.b45@gmail.com', 'Een boom gevallen op auto\'s.', 'Hier is een boom gevallen tussen twee auto\'s in de straat.', 51.57433842309158, 3.7872425286431186, '2023-12-13 19:30:33'),
(4, 'Arnold Adeland', 'arnold.v.adeland@gmail.com', 'Aanval met Hond', 'Een moeder en kind van 7 zijn aangevallen door een hond. Beide zijn naar het ziekenhuis met verwondingen. Ze maken het goed.', 51.560433160161516, 3.796156474896169, '2024-01-01 19:30:40'),
(5, 'Hoi', 'dave.kat@yahoo.com', 'Zekers', 'Natuurlijk', 51.594704024093055, 3.848720700025448, '2023-12-31 19:30:46'),
(6, 'Niemand Anders', 'nima@yahoo.com', 'Meisje 27 Aangevallen', 'In Kats is voor de kerk een meisje vreselijk mishandeld, haar kleren afgescheurd, en de man ging vulgair te werk.', 51.56744323256543, 3.8845886074599183, '2024-01-05 19:30:53'),
(22, 'Stefanie Volt', 'steffy.v.hartje98@hotmail.com', 'Kapotte Vuilnisbak', 'In de straat is er met vuurwerk geknoeid. De enigste vuilnisbak is kapot nu.', 51.56913889751355, 3.8854133245849907, '2013-12-31 19:32:28');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `klachten`
--
ALTER TABLE `klachten`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `klachten`
--
ALTER TABLE `klachten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
