-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Gen 04, 2019 alle 22:07
-- Versione del server: 5.7.24-0ubuntu0.16.04.1
-- Versione PHP: 7.2.12-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `museo-ferrari`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `AutoEsposte`
--

DROP TABLE IF EXISTS `AutoEsposte`;
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
  `percorsoFoto` varchar(100) NOT NULL,
  `alt` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Svuota la tabella prima dell'inserimento `AutoEsposte`
--

TRUNCATE TABLE `AutoEsposte`;
--
-- Dump dei dati per la tabella `AutoEsposte`
--

INSERT INTO `AutoEsposte` (`ID`, `Modello`, `Anno`, `StatoConservazione`, `Esposta`, `TipoMotore`, `Cilindrata`, `PotenzaCv`, `VelocitaMax`, `percorsoFoto`, `alt`) VALUES
(1, 'F 430', 2004, 7, 0, 'V8', 5748, 490, 315, './img/fotoAuto/f430.jpg', 'Ferrari F 430 in corsa in un autodromo'),
(2, '208 Turbo', 1982, 9, 0, 'V8', 1990, 220, 242, './img/fotoAuto/208_Turbo.jpg', 'Ferrari 208 Turbo su sfondo urbano in cemento. Evidente stile anni 90'),
(3, '288 GTO', 1984, 8, 1, 'V8', 2855, 400, 306, './img/fotoAuto/288_GTO.jpg', 'Ferrari 288 GTO parcheggiata in località collinare'),
(4, 'Testarossa', 1984, 10, 0, 'V8', 4943, 390, 290, './img/fotoAuto/testarossa.png', 'Ferrari Testarossa parcheggiata con alberi nello sfondo'),
(5, '412', 1985, 6, 1, 'V12', 4953, 270, 250, './img/fotoAuto/412.jpg', 'Ferrari 412 parcheggiata con alberi nello sfondo. Carrozzeria tipo berlina'),
(7, '408 Integrale', 1987, 9, 0, 'V8', 3985, 300, 290, './img/fotoAuto/408_integrale.jpg', 'Ferrari 408 Integrale in corsa in località montana'),
(8, 'F40 LM', 1989, 7, 1, 'V8', 2936, 750, 320, './img/fotoAuto/F40_LM.jpg', 'Ferrari F40 LM esposta nel museo. Auto da competizione utilizzata per le 24 ore di Le Mans'),
(9, 'MYTHOS', 1990, 7, 0, 'V12', 4942, 390, 290, './img/fotoAuto/pinifarinia_mythos.jpg', 'Ferrari Pininfarina Mythos, auto prototipale anni 90'),
(10, '512 TR', 1992, 10, 1, 'V12', 4943, 428, 314, './img/fotoAuto/512_TR.jpg', 'Ferrari 512 TM parcheggiata in ambiente urbano'),
(11, '348 Spider', 1993, 10, 0, 'V8', 3405, 300, 275, './img/fotoAuto/348_spider.jpg', 'Ferrari 348 Spider, auto con tetto apribile'),
(12, 'F50', 1995, 9, 0, 'V12', 4700, 520, 325, './img/fotoAuto/ferrari_f50.jpg', 'Ferrari F50 spider con tetto rigido asportabile. Costruita in serie limitata'),
(13, 'F355 Spider', 1995, 8, 0, 'V8', 3496, 380, 295, './img/fotoAuto/F355_spider.jpg', 'Ferrari F355 spider parcheggiata con alberi nello sfondo'),
(14, '550 Maranello', 1996, 5, 1, 'V12', 5474, 485, 320, './img/fotoAuto/550_maranello.jpg', 'Ferrari 550 Maranello parcheggiata con natura nello sfondo'),
(15, '456 M GTA', 1997, 8, 0, 'V12', 5476, 442, 302, './img/fotoAuto/ferrari_456_M_GTA.jpg', 'Ferrari 456 M GTA parcheggiata su una strada bianca'),
(16, '360 Modena', 1999, 10, 0, 'V8', 3586, 400, 295, './img/fotoAuto/360_modena.jpg', 'Ferrari 360 Modena, precede la F 430'),
(17, '550 Barchetta Pininfarina', 2000, 8, 0, 'V12', 5474, 475, 300, './img/fotoAuto/550_barchetta_pininfarina.jpg', 'Ferrari 550 Barchetta Pininfarina, con carrozzeria spider');

-- --------------------------------------------------------

--
-- Struttura della tabella `Biglietti`
--

DROP TABLE IF EXISTS `Biglietti`;
CREATE TABLE `Biglietti` (
  `ID` int(11) NOT NULL,
  `Utente` int(11) NOT NULL,
  `Evento` int(11) NOT NULL,
  `Data` date NOT NULL,
  `NrBiglietti` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Svuota la tabella prima dell'inserimento `Biglietti`
--

TRUNCATE TABLE `Biglietti`;
--
-- Dump dei dati per la tabella `Biglietti`
--

INSERT INTO `Biglietti` (`ID`, `Utente`, `Evento`, `Data`, `NrBiglietti`) VALUES
(1, 3, 1, '2019-01-16', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `Evento`
--

DROP TABLE IF EXISTS `Evento`;
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
-- Svuota la tabella prima dell'inserimento `Evento`
--

TRUNCATE TABLE `Evento`;
--
-- Dump dei dati per la tabella `Evento`
--

INSERT INTO `Evento` (`ID`, `Titolo`, `BreveDescrizione`, `LungaDescrizione`, `percorsoFoto1`, `Tipo`, `DataInizio`, `DataFine`, `altFoto1`) VALUES
(1, 'Il cavallino degli anni ''50', 'Il nostro salone ospiterà una mostra dedicata a tutti i modelli Ferrari degli anni ''50.', 'Il nostro salone ospiterà una mostra dedicata a tutti i modelli Ferrari degli anni ''50. Visitando questa esposizione avrete la possibilità di fare un vero e proprio tuffo nel passato ammirando le linee eleganti delle vetture dell''epoca. La mostra è accompagnata da un reportage fotografico curato da Antonio Chiaravalle, il quale grazie ad accurate ricerche ha potuto portare alla luce scatti inediti relativi alla produzione Ferrari di quei tempi.', './img/eventi/250_Testa_Rossa.jpg', 'corrente', '2018-11-12', '2019-03-18', 'Ferrari 250 Testa Rossa'),
(2, 'Ferrari Monza SP', 'A partire da Gennaio 2019 potrete ammirare le nuove icone Ferrari SP1 e SP2.', 'A partire da Gennaio 2019 potrete ammirare le nuove icone Ferrari SP1 e SP2. Le Ferrari Monza SP1 e SP2 fanno parte della nuova gamma Icona, composta da modelli ispirati a grandi Rosse del passato. Le prime supercar di queste nuova gamma si rifanno alle Monza 750 e 860 di metà Anni 50, auto da corsa senza il tetto e il parabrezza. Le SP1 e SP2 hanno di conseguenza un aspetto evocativo, grazie alle forme essenziali della carrozzeria e ad una serie di particolari ispirati ai modelli originali, come ad esempio le piccole portiere laterali o la “bolla” con funzione aerodinamica dietro il sedile.', './img/eventi/monza_sp1.jpg', 'futuro', '2019-03-04', '2019-06-30', 'Ferrari Monza SP1'),
(3, 'F1 dal 2000 al 2008', 'Per tutto l''inverno 2019 ospiteremo una collezione di monoposto F1 dagli anni 2000 fino alla F2008.', 'Per tutto l''inverno 2019 ospiteremo una collezione di monoposto F1 dagli anni 2000 fino alla F2008. Potrete ammirare tutte le monoposto con le quali la Ferrari vinse i suoi 6 titoli modiali più recenti. Ci saranno la F1-2000, F2001, F2002, F2003-GA, F2004, F2005 di Schumacher e Barrichello. La 248 F1 guidata nel 2006 da Schumacher e Massa. Infine saranno presenti la F2007 portata alla vittoria da Kimi Raikkonen e la F2008.', './img/eventi/f1_ferrari_f2008.jpg', 'futuro', '2019-09-01', '2020-03-31', 'Ferrari F1 2008'),
(4, 'Primavera d''epoca', 'In primavera verrà presentata la nuova collezione di auto d''epoca del museo.', 'A fine Marzo verrà presentata la nuova collezione di auto d''epoca del museo. Siamo lieti di annuciarvi che oltre alle classicisme 250 Testarossa, 250 GTO e molte altre, potrete ammirare ben 5 diversi concept realizzati per Ferrari da Pininfarina. Vieni a trovarci a primavera rimarrai estasiato da i modelli che abbiamo scelto!', './img/eventi/evento_maggio_2019.jpg', 'futuro', '2019-03-21', '2019-06-30', 'Ferrari  d''epoca');

-- --------------------------------------------------------

--
-- Struttura della tabella `Utente`
--

DROP TABLE IF EXISTS `Utente`;
CREATE TABLE `Utente` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(16) DEFAULT NULL,
  `Cognome` varchar(16) DEFAULT NULL,
  `DataNascita` date DEFAULT NULL,
  `ComuneNascita` varchar(20) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Email` varchar(30) NOT NULL,
  `Indirizzo` varchar(50) DEFAULT NULL,
  `Citta` varchar(20) DEFAULT NULL,
  `Stato` varchar(20) DEFAULT NULL,
  `NewsLetter` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Svuota la tabella prima dell'inserimento `Utente`
--

TRUNCATE TABLE `Utente`;
--
-- Dump dei dati per la tabella `Utente`
--

INSERT INTO `Utente` (`ID`, `Nome`, `Cognome`, `DataNascita`, `ComuneNascita`, `Telefono`, `Email`, `Indirizzo`, `Citta`, `Stato`, `NewsLetter`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 'a', NULL, NULL, NULL, 1),
(2, NULL, NULL, '1919-01-01', NULL, NULL, 'aaaa', NULL, NULL, NULL, 1),
(3, 'Matteo', 'Marchiori', '1919-01-01', 'Vigonza', '3473818358', 'matteo.marchiori97@gmail.com', 'Via campolino', 'Vigonza', 'it', 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `AutoEsposte`
--
ALTER TABLE `AutoEsposte`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `Biglietti`
--
ALTER TABLE `Biglietti`
  ADD PRIMARY KEY (`Utente`,`Evento`,`Data`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `Evento` (`Evento`);

--
-- Indici per le tabelle `Evento`
--
ALTER TABLE `Evento`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `Utente`
--
ALTER TABLE `Utente`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `AutoEsposte`
--
ALTER TABLE `AutoEsposte`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT per la tabella `Biglietti`
--
ALTER TABLE `Biglietti`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `Evento`
--
ALTER TABLE `Evento`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `Utente`
--
ALTER TABLE `Utente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Biglietti`
--
ALTER TABLE `Biglietti`
  ADD CONSTRAINT `Evento` FOREIGN KEY (`Evento`) REFERENCES `Evento` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Utente` FOREIGN KEY (`Utente`) REFERENCES `Utente` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
