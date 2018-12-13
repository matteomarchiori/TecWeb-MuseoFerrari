-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Creato il: Dic 12, 2018 alle 05:07
-- Versione del server: 5.7.23-0ubuntu0.16.04.1
-- Versione PHP: 7.2.11-2+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `museo-ferrari`
--
-- --------------------------------------------------------

DROP DATABASE IF EXISTS museoFerrari;
CREATE DATABASE IF NOT EXISTS museoFerrari;
USE museoFerrari;
--
-- Struttura della tabella `AutoEsposte`
--

CREATE TABLE `AutoEsposte` (
  `ID` int(11) NOT NULL,
  `Modello` varchar(60) NOT NULL,
  `Anno` int(4) NOT NULL,
  `StatoConservazione` int(2) NOT NULL,
  `Esposta` tinyint(1) NOT NULL,
  `TipoMotore` varchar(6) NOT NULL,
  `Cilindrata` int(4) NOT NULL,
  `PotenzaCv` int(3) NOT NULL,
  `VelocitaMax` int(3) NOT NULL,
  `percorsoFoto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `AutoEsposte`
--

INSERT INTO `AutoEsposte` (`ID`, `Modello`, `Anno`, `StatoConservazione`, `Esposta`, `TipoMotore`, `Cilindrata`, `PotenzaCv`, `VelocitaMax`, `percorsoFoto`) VALUES
(1, 'F 430', 2004, 7, 0, 'V8', 5748, 490, 315, '../../img/fotoAuto/f430.jpg'),
(2, '208 Turbo', 1982, 9, 0, 'V8', 1990, 220, 242, '../../img/fotoAuto/208_Turbo.jpg'),
(3, '288 GTO', 1984, 8, 1, 'V8', 2855, 400, 306, '../../img/fotoAuto/288_GTO.jpg'),
(4, 'Testarossa', 1984, 10, 0, 'V8', 4943, 390, 290, '../../img/fotoAuto/testarossa.png'),
(5, '412', 1985, 6, 1, 'V12', 4953, 270, 250, '../../img/fotoAuto/412.jpg'),
(7, '408 Integrale', 1987, 9, 0, 'V8', 3985, 300, 290, '../../img/fotoAuto/408_integrale.jpg'),
(8, 'F40 LM', 1989, 7, 1, 'V8', 2936, 750, 320, '../../img/fotoAuto/F40_LM.jpg'),
(9, 'MYTHOS', 1990, 7, 0, 'V12', 4942, 390, 290, '../../img/fotoAuto/pinifarinia_mythos.jpg'),
(10, '512 TR', 1992, 10, 1, 'V12', 4943, 428, 314, '../../img/fotoAuto/512_TR.jpg'),
(11, '348 Spider', 1993, 10, 0, 'V8', 3405, 300, 275, '../../img/fotoAuto/348_spider.jpg'),
(12, 'F50', 1995, 9, 0, 'V12', 4700, 520, 325, '../../img/fotoAuto/ferrari_f50.jpg'),
(13, 'F355 Spider', 1995, 8, 0, 'V8', 3496, 380, 295, '../../img/fotoAuto/F355_spider.jpg'),
(14, '550 Maranello', 1996, 5, 1, 'V12', 5474, 485, 320, '../../img/fotoAuto/550_maranello.jpg'),
(15, '456 M GTA', 1997, 8, 0, 'V12', 5476, 442, 302, '../../img/fotoAuto/ferrari_456_M_GTA.jpg'),
(16, '360 Modena', 1999, 10, 0, 'V8', 3586, 400, 295, '../../img/fotoAuto/360_modena.jpg'),
(17, '550 Barchetta Pininfarina', 2000, 8, 0, 'V12', 5474, 475, 300, '../../img/fotoAuto/550_barchetta_pininfarina.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `Evento`
--

CREATE TABLE `Evento` (
  `ID` int(11) NOT NULL,
  `Titolo` varchar(60) NOT NULL,
  `BreveDescrizione` text NOT NULL,
  `LungaDescrizione` text NOT NULL,
  `percorsoFoto1` varchar(100) DEFAULT NULL,
  `Tipo` enum('corrente','futuro') NOT NULL DEFAULT 'futuro',
  `DataInizio` date NOT NULL,
  `DataFine` date NOT NULL,
  `altFoto1` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `Evento`
--

INSERT INTO `Evento` (`ID`, `Titolo`, `BreveDescrizione`, `LungaDescrizione`, `percorsoFoto1`, `Tipo`, `DataInizio`, `DataFine`, `altFoto1`) VALUES
(1, 'Il cavallino degli anni \'50', 'Il nostro salone ospiterà una mostra dedicata a tutti i modelli Ferrari degli anni \'50. Vistando questa esposizione avrete la possibilità di fare un vero e proprio tuffo nel passato ammirando le linee eleganti delle vetture dell\'epoca. La mostra è accompagnata da un reportage fotografico curato da Antonio Chiaravalle, il quale grazie ad accurate ricerche ha potuto portare alla luce scatti inediti relativi alla produzione Ferrari di quei tempi.', 'Il nostro salone ospiterà una mostra dedicata a tutti i modelli Ferrari degli anni \'50. Vistando questa esposizione avrete la possibilità di fare un vero e proprio tuffo nel passato ammirando le linee eleganti delle vetture dell\'epoca. La mostra è accompagnata da un reportage fotografico curato da Antonio Chiaravalle, il quale grazie ad accurate ricerche ha potuto portare alla luce scatti inediti relativi alla produzione Ferrari di quei tempi.', './img/eventi/250_Testa_Rossa.jpg', 'corrente', '2018-11-12', '2019-03-18', 'Ferrari 250 Testa Rossa'),
(2, 'Ferrari Monza SP', 'A partire da Gennaio 2019 potrete ammirare le nuove icone Ferrari SP1 e SP2.', '', './img/eventi/monza_sp1.jpg', 'futuro', '2019-01-01', '2019-06-30', 'Ferrari Monza SP1'),
(3, 'F1 dal 2000 al 2008', 'Per tutto l\'inverno 2019 ospiteremo una collezione di monoposto F1 dagli anni 2000 fino alla F2008.', '', './img/eventi/f1_ferrari_f2008.jpg', 'futuro', '2019-09-01', '2020-03-31', 'Ferrari F1 2008'),
(4, 'Primavera d\'epoca', 'In primavera verrà presentata la nuova collezione di auto d\'epoca del museo.', '', './img/eventi/evento_maggio_2019.jpg', 'futuro', '2019-03-21', '2019-06-30', 'Ferrari  d\'epoca');

-- --------------------------------------------------------

--
-- Struttura della tabella `Utente`
--

CREATE TABLE `Utente` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(16) NOT NULL,
  `Cognome` varchar(16) NOT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Email` varchar(30) NOT NULL,
  `Indirizzo` varchar(50) DEFAULT NULL,
  `Citta` varchar(20) DEFAULT NULL,
  `Stato` varchar(20) DEFAULT NULL,
  `CAP` int(10) DEFAULT NULL,
  `NewsLetter` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `AutoEsposte`
--
ALTER TABLE `AutoEsposte`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `Utente`
--
ALTER TABLE `Utente`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `AutoEsposte`
--
ALTER TABLE `AutoEsposte`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT per la tabella `Utente`
--
ALTER TABLE `Utente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
