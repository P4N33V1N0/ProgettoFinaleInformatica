-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 24, 2024 alle 13:45
-- Versione del server: 10.4.25-MariaDB
-- Versione PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biblioteca`
--
CREATE DATABASE IF NOT EXISTS `biblioteca` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `biblioteca`;

-- --------------------------------------------------------

--
-- Struttura della tabella `autore`
--

CREATE TABLE `autore` (
  `Codice` int(11) NOT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Cognome` varchar(255) DEFAULT NULL,
  `DataNascita` date DEFAULT NULL,
  `Nazionalita` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `copialibro`
--

CREATE TABLE `copialibro` (
  `Codice` int(11) NOT NULL,
  `Codizioni` varchar(255) DEFAULT NULL,
  `Stato` varchar(50) DEFAULT NULL,
  `CodiceLibro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `libro`
--

CREATE TABLE `libro` (
  `Codice` int(11) NOT NULL,
  `NumPagine` int(11) DEFAULT NULL,
  `Genere` varchar(100) DEFAULT NULL,
  `AnnoPubbl` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `prestito`
--

CREATE TABLE `prestito` (
  `Codice` int(11) NOT NULL,
  `DataInizio` date DEFAULT NULL,
  `DataScadenza` date DEFAULT NULL,
  `DataRestituzione` date DEFAULT NULL,
  `CodUtente` int(11) DEFAULT NULL,
  `CodCopiaLibro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `scrive`
--

CREATE TABLE `scrive` (
  `CodiceLibro` int(11) NOT NULL,
  `CodiceAutore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `Codice` int(11) NOT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Cognome` varchar(255) DEFAULT NULL,
  `DataNascita` date DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Tel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `autore`
--
ALTER TABLE `autore`
  ADD PRIMARY KEY (`Codice`);

--
-- Indici per le tabelle `copialibro`
--
ALTER TABLE `copialibro`
  ADD PRIMARY KEY (`Codice`),
  ADD KEY `CodiceLibro` (`CodiceLibro`);

--
-- Indici per le tabelle `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`Codice`);

--
-- Indici per le tabelle `prestito`
--
ALTER TABLE `prestito`
  ADD PRIMARY KEY (`Codice`),
  ADD KEY `CodUtente` (`CodUtente`),
  ADD KEY `CodCopiaLibro` (`CodCopiaLibro`);

--
-- Indici per le tabelle `scrive`
--
ALTER TABLE `scrive`
  ADD PRIMARY KEY (`CodiceLibro`,`CodiceAutore`),
  ADD KEY `CodiceAutore` (`CodiceAutore`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`Codice`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `autore`
--
ALTER TABLE `autore`
  MODIFY `Codice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `copialibro`
--
ALTER TABLE `copialibro`
  MODIFY `Codice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `libro`
--
ALTER TABLE `libro`
  MODIFY `Codice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `prestito`
--
ALTER TABLE `prestito`
  MODIFY `Codice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `Codice` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `copialibro`
--
ALTER TABLE `copialibro`
  ADD CONSTRAINT `copialibro_ibfk_1` FOREIGN KEY (`CodiceLibro`) REFERENCES `libro` (`Codice`);

--
-- Limiti per la tabella `prestito`
--
ALTER TABLE `prestito`
  ADD CONSTRAINT `prestito_ibfk_1` FOREIGN KEY (`CodUtente`) REFERENCES `utente` (`Codice`),
  ADD CONSTRAINT `prestito_ibfk_2` FOREIGN KEY (`CodCopiaLibro`) REFERENCES `copialibro` (`Codice`);

--
-- Limiti per la tabella `scrive`
--
ALTER TABLE `scrive`
  ADD CONSTRAINT `scrive_ibfk_1` FOREIGN KEY (`CodiceLibro`) REFERENCES `libro` (`Codice`),
  ADD CONSTRAINT `scrive_ibfk_2` FOREIGN KEY (`CodiceAutore`) REFERENCES `autore` (`Codice`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
