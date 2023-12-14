-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Nov 26. 17:54
-- Kiszolgáló verziója: 10.4.27-MariaDB
-- PHP verzió: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `munkakozvetito`
--
CREATE DATABASE IF NOT EXISTS `munkakozvetito` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `munkakozvetito`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `allasajanlatok`
--

CREATE TABLE `allasajanlatok` (
  `allas_id` int(11) NOT NULL,
  `munkakori_pozicio` varchar(50) NOT NULL,
  `elvart_eletkor` tinyint(4) NOT NULL,
  `kapcsolattarto_email` varchar(50) NOT NULL,
  `aktualis` tinyint(1) NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `telephely_id` int(11) NOT NULL,
  `ceg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `allasajanlatok`
--

INSERT INTO `allasajanlatok` (`allas_id`, `munkakori_pozicio`, `elvart_eletkor`, `kapcsolattarto_email`, `aktualis`, `felhasznalo_id`, `telephely_id`, `ceg_id`) VALUES
(133, 'Fejlesztő', 25, 'fejleszto@ceg1.com', 1, 26, 1, 1),
(134, 'Fejlesztő', 29, 'fejleszto@ceg1.com', 1, 26, 1, 1),
(135, 'Ügyfélszolgálati munkatárs', 22, 'ugyfel@ceg1.com', 1, 26, 1, 1),
(136, 'Grafikus tervező', 28, 'grafikus@ceg2.com', 1, 26, 2, 2),
(137, 'Marketing szakember', 32, 'marketing@ceg2.com', 0, 26, 2, 2),
(138, 'HR asszisztens', 24, 'hr@ceg2.com', 1, 26, 3, 3),
(139, 'Tesztmérnök', 27, 'teszt@ceg3.com', 1, 26, 3, 3),
(140, 'Üzletfejlesztési vezető', 35, 'uzletfejleszto@ceg3.com', 0, 26, 3, 3),
(141, 'IT tanácsadó', 30, 'tanacsado@ceg3.com', 1, 26, 3, 3),
(142, 'Pénzügyi elemző', 28, 'penzugyi@ceg4.com', 1, 26, 4, 4),
(143, 'Ügyvédi asszisztens', 26, 'ugyvedi@ceg4.com', 1, 26, 4, 4),
(144, 'HR szakértő', 32, 'hr@ceg4.com', 1, 26, 4, 4),
(146, 'Marketing', 24, 'd@gmail.com', 1, 26, 28, 27),
(148, 'Takarító', 50, 'd@gmail.com', 0, 26, 28, 27),
(149, 'Bartender', 20, 'mcdonalds@gmail.com', 1, 26, 29, 28),
(150, 'Help Desk', 25, 'display@gmail.com', 1, 26, 28, 27),
(151, 'Éttermi alkalmazott', 18, 'mcdonalds@gmail.com', 1, 26, 30, 28),
(152, 'Grafikus tervező', 25, 'dynamicdr@gmail.com', 1, 26, 19, 19),
(153, 'Takarító', 20, 'mcdonalds@gmail.com', 1, 26, 29, 28),
(154, 'Help Desk', 20, 'innovin@technology.org', 1, 26, 3, 3);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cegek`
--

CREATE TABLE `cegek` (
  `ceg_id` int(11) NOT NULL,
  `cegnev` varchar(100) NOT NULL,
  `kapcsolattarto_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `cegek`
--

INSERT INTO `cegek` (`ceg_id`, `cegnev`, `kapcsolattarto_email`) VALUES
(13, 'AlphaOmega Dynamics', 'info@alphaomega.com'),
(11, 'BlueSky Solutions', 'info@bluesky.com'),
(2, 'Creative Minds Co.', 'contact@creativeminds.com'),
(27, 'Display Computer Kft.', 'it@displaycomputer.hu'),
(9, 'DreamCraft Studios', 'info@dreamcraft.com'),
(5, 'Dynamic Designs Ltd.', 'info@dynamicdesigns.com'),
(19, 'Dynamic Dreamworks', 'info@dynamicdreamworks.com'),
(4, 'EcoGreen Solutions', 'contact@ecogreen.com'),
(10, 'Epic Ventures Inc.', 'contact@epicventures.com'),
(12, 'Fusion Innovators', 'contact@fusion.com'),
(16, 'GlobalTech Solutions', 'contact@globaltech.com'),
(17, 'Infinite Creations Co.', 'info@infinitecreations.com'),
(3, 'Innovate Innovations', 'info@innovate.com'),
(25, 'Mazda', 'masmd@sdmfm.com'),
(28, 'McDonald\'s', 'justabigmac@gmail.com'),
(15, 'NexGen Innovations', 'info@nexgen.com'),
(8, 'Pinnacle Innovations', 'contact@pinnacle.com'),
(6, 'Quantum Leap Enterprises', 'contact@quantumleap.com'),
(26, 'sdf', 'sdf'),
(7, 'Starlight Technologies', 'info@starlighttech.com'),
(20, 'Stratosphere Solutions', 'contact@stratosphere.com'),
(14, 'Synergy Systems Ltd.', 'contact@synergysystems.com'),
(1, 'TechWizard Solutions', 'info@techwizard.com'),
(18, 'Vortex Ventures Ltd.', 'contact@vortexventures.com');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `felhasznalo_id` int(11) NOT NULL,
  `jelszo` varchar(255) NOT NULL,
  `elotag` varchar(50) DEFAULT NULL,
  `nev` varchar(150) NOT NULL,
  `email_cim` varchar(150) NOT NULL,
  `szerepkor` int(11) NOT NULL,
  `regisztracio_datuma` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`felhasznalo_id`, `jelszo`, `elotag`, `nev`, `email_cim`, `szerepkor`, `regisztracio_datuma`) VALUES
(24, '$2y$10$bl/GFyQNljYCvx7088B50.uZ1nS6Tq1DzYqQxQDleWnidapf3Fgjm', 'Dr', 'Sandor Tibor', 'sandor.tibix@gmail.com', 2, '2023-11-11'),
(25, '$2y$10$5H/7W2JUh2EGhL9LZw0hYOEEhgWkLeXUq4kB0HYkLLt8XfxaVbscq', NULL, 'Gyuris Mónika', 'sandor.monika49@gmail.com', 2, '2023-11-11'),
(26, '$2y$10$MswYxoJRNcG5aXqvfGdGKOzh0KofUCUqFCV.9DCWOlLFPgYbjukJy', NULL, 'Admin János', 'admin@gmail.com', 1, '2023-11-16'),
(27, '$2y$10$jLyrSd6UjSjn08UlXyPc8.TUr57AWJrw6cws8UShyLGTZPfpfLv5.', 'Dr', 'Bondor Dávid', 'bondordavid@gmail.com', 2, '2023-11-18'),
(28, '$2y$10$WnLE/E0A06xh/y.Z30b9BeGV8CxYm4KOvg4UPe1ehyigSQJ/GQkSG', NULL, 'Elon Musk', 'elon@gmail.com', 2, '2023-11-26'),
(29, '$2y$10$VoSzrSPZOngCPExXCaOqR.G0KXZojQYlgtG6kYptUw2r9VV8AJgbW', NULL, 'quentin tarantino', 'pulpfiction@gmail.com', 2, '2023-11-26'),
(30, '$2y$10$D0tOK/gSv./RN2czO4vjZ.4cGexCxv.eZhKM1FoETrrBk3xdYDImW', NULL, 'Freddie Mercury', 'queen@gmail.com', 2, '2023-11-26');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kepesseg`
--

CREATE TABLE `kepesseg` (
  `kepesseg_id` int(11) NOT NULL,
  `nev` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `kepesseg`
--

INSERT INTO `kepesseg` (`kepesseg_id`, `nev`) VALUES
(1, 'Kommunikációs készség'),
(2, 'Projektmenedzsment'),
(3, 'Programozás'),
(4, 'Kreativitás'),
(5, 'Adatelemzés'),
(6, 'Ügyfélkezelés'),
(7, 'Angol nyelvtudás'),
(8, 'Adaptabilitás'),
(9, 'Csapatmunka'),
(10, 'Prezentációs készség'),
(11, 'Problémamegoldás'),
(12, 'Időmenedzsment'),
(13, 'Kutatási képesség'),
(14, 'Stressztűrés'),
(15, 'Analitikus gondolkodás'),
(16, 'Stratégiai tervezés'),
(17, 'Közösségi média ismeretek'),
(18, 'Üzleti intelligencia'),
(19, 'Adatbázis kezelés');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kepessegek`
--

CREATE TABLE `kepessegek` (
  `allas_id` int(11) NOT NULL,
  `kepesseg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `kepessegek`
--

INSERT INTO `kepessegek` (`allas_id`, `kepesseg_id`) VALUES
(133, 1),
(133, 2),
(133, 3),
(134, 9),
(135, 1),
(135, 2),
(135, 3),
(136, 2),
(136, 4),
(136, 10),
(137, 1),
(138, 1),
(138, 2),
(138, 5),
(138, 6),
(138, 7),
(139, 2),
(139, 3),
(139, 5),
(140, 1),
(141, 2),
(141, 3),
(141, 5),
(142, 5),
(142, 13),
(142, 16),
(142, 18),
(143, 5),
(143, 6),
(143, 13),
(143, 16),
(143, 19),
(144, 1),
(144, 2),
(144, 5),
(144, 6),
(146, 10),
(148, 5),
(148, 6),
(149, 1),
(149, 8),
(149, 9),
(149, 10),
(149, 14),
(150, 1),
(150, 11),
(150, 19),
(151, 1),
(151, 9),
(151, 11),
(151, 14),
(152, 2),
(152, 4),
(152, 10),
(153, 8),
(153, 12),
(154, 1),
(154, 8),
(154, 11),
(154, 19);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kepzes`
--

CREATE TABLE `kepzes` (
  `kepzes_id` int(11) NOT NULL,
  `nev` varchar(50) NOT NULL,
  `szint` varchar(30) NOT NULL,
  `megnevezes` varchar(80) NOT NULL,
  `ar` int(11) NOT NULL,
  `kezdes_datuma` date NOT NULL,
  `befejezes_datuma` date NOT NULL,
  `max_letszam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `kepzes`
--

INSERT INTO `kepzes` (`kepzes_id`, `nev`, `szint`, `megnevezes`, `ar`, `kezdes_datuma`, `befejezes_datuma`, `max_letszam`) VALUES
(1, 'Programozás Alapok', 'Alap', 'Programozás alapjai', 5000, '2023-01-01', '2023-06-30', 2),
(2, 'Adatbázisok Kezelése', 'Haladó', 'Adatbázis-kezelés gyakorlatban', 6000, '2023-02-01', '2023-07-31', 143),
(3, 'Webfejlesztés Kezdőknek', 'Kezdő', 'Webfejlesztés alapjai', 4500, '2023-03-01', '2023-08-31', 141),
(4, 'Grafikai Design Alapok', 'Alap', 'Alapok a grafikai tervezésből', 5500, '2023-04-01', '2023-09-30', 122),
(5, 'E-commerce Stratégiák', 'Haladó', 'E-commerce üzleti stratégiák', 7000, '2023-05-01', '2023-10-31', 38),
(6, 'Mobilalkalmazás Fejlesztés', 'Haladó', 'Mobilalkalmazások készítése', 6500, '2023-06-01', '2023-11-30', 98),
(7, 'Big Data Analitika', 'Haladó', 'Nagy adatok elemzése', 8000, '2023-07-01', '2023-12-31', 83),
(8, 'UI/UX Design Workshop', 'Haladó', 'UI/UX tervezési gyakorlat', 7500, '2023-08-01', '2024-01-31', 110),
(9, 'Machine Learning Alapok', 'Alap', 'Gépi tanulás alapjai', 6000, '2023-09-01', '2024-02-28', 12),
(10, 'Szoftvertervezési Módszertanok', 'Haladó', 'Szoftvertervezési elvek és módszertanok', 7000, '2023-10-01', '2024-03-31', 142),
(11, 'IoT Megoldások Fejlesztése', 'Haladó', 'Internet of Things alkalmazások fejlesztése', 7500, '2023-11-01', '2024-04-30', 102),
(12, 'Projektmenedzsment Kurzus', 'Alap', 'Projektmenedzsment alapjai', 5500, '2023-12-01', '2024-05-31', 72),
(13, 'Kreatív Írás Workshop', 'Kezdő', 'Kreatív írás alapjai', 5000, '2024-01-01', '2024-06-30', 47),
(14, 'Blockchain Technológiák', 'Haladó', 'Blockchain alapok és alkalmazások', 8000, '2024-02-01', '2024-07-31', 10),
(15, 'IT Biztonság Alapok', 'Alap', 'IT biztonság alapelvei', 6000, '2024-03-01', '2024-08-31', 38),
(16, 'Social Media Marketing', 'Haladó', 'Social Media marketing taktikák', 7000, '2024-04-01', '2024-09-30', 150),
(17, '3D Modellezés Alapok', 'Alap', '3D modellezés alapjai', 5500, '2024-05-01', '2024-10-31', 63),
(18, 'Data Science Workshop', 'Haladó', 'Data Science alkalmazások', 7500, '2024-06-01', '2024-11-30', 137),
(19, 'UX Research és Tesztelés', 'Haladó', 'UX kutatás és tesztelési módszerek', 7000, '2024-07-01', '2024-12-31', 63),
(20, 'Grafika haladóknak', 'kezdő', 'grafikus', 200000, '2024-01-04', '2024-04-30', 150);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `resztvevok`
--

CREATE TABLE `resztvevok` (
  `kepzes_id` int(11) NOT NULL,
  `felhasznalo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `resztvevok`
--

INSERT INTO `resztvevok` (`kepzes_id`, `felhasznalo_id`) VALUES
(1, 24),
(1, 25),
(8, 24),
(17, 24),
(17, 25),
(18, 24),
(19, 27);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `telephely`
--

CREATE TABLE `telephely` (
  `telephely_id` int(11) NOT NULL,
  `ceg_id` int(11) NOT NULL,
  `iranyitoszam` int(11) NOT NULL,
  `telepules_nev` varchar(80) NOT NULL,
  `kozterulet_neve` varchar(80) NOT NULL,
  `hazszam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `telephely`
--

INSERT INTO `telephely` (`telephely_id`, `ceg_id`, `iranyitoszam`, `telepules_nev`, `kozterulet_neve`, `hazszam`) VALUES
(1, 1, 12345, 'Budapest', 'Kossuth utca', 1),
(2, 2, 23456, 'Debrecen', 'Piac utca', 2),
(3, 3, 34567, 'Szeged', 'Dugonics utca', 3),
(4, 4, 45678, 'Pécs', 'Szechenyi utca', 4),
(5, 5, 56789, 'Győr', 'Baross utca', 5),
(6, 6, 67890, 'Miskolc', 'Arany János utca', 6),
(7, 7, 78901, 'Eger', 'Bartók Béla utca', 7),
(8, 8, 89012, 'Szombathely', 'Petőfi Sándor utca', 8),
(9, 9, 90123, 'Veszprém', 'Ady Endre utca', 9),
(10, 10, 1234, 'Nyíregyháza', 'Bessenyei utca', 10),
(11, 11, 12345, 'Budapest', 'József Attila utca', 11),
(12, 12, 23456, 'Debrecen', 'Vörösmarty utca', 12),
(13, 13, 34567, 'Szeged', 'Dózsa György utca', 13),
(14, 14, 45678, 'Pécs', 'Berzsenyi utca', 14),
(15, 15, 56789, 'Győr', 'Hunyadi utca', 15),
(16, 16, 67890, 'Miskolc', 'Madách utca', 16),
(17, 17, 78901, 'Eger', 'Kisfaludy utca', 17),
(18, 18, 89012, 'Szombathely', 'Vadász utca', 18),
(19, 19, 90123, 'Veszprém', 'Fő utca', 19),
(20, 20, 1234, 'Nyíregyháza', 'Klapka utca', 20),
(26, 25, 4234, 'asfsdf', 'sdfsdf', 12),
(27, 25, 2323, 'sdfsdf', 'sdfsdf', 2),
(28, 27, 6726, 'Szeged', 'Szent-Györgyi Albert u.', 2),
(29, 28, 6724, 'Szeged', 'Rókusi krt.', 27),
(30, 28, 6720, 'Szeged', 'Kárász u.', 11);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `allasajanlatok`
--
ALTER TABLE `allasajanlatok`
  ADD PRIMARY KEY (`allas_id`),
  ADD UNIQUE KEY `munkakori_pozicio` (`munkakori_pozicio`,`elvart_eletkor`,`kapcsolattarto_email`,`telephely_id`,`ceg_id`),
  ADD KEY `ceg_id` (`ceg_id`),
  ADD KEY `telephely_id` (`telephely_id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`);

--
-- A tábla indexei `cegek`
--
ALTER TABLE `cegek`
  ADD PRIMARY KEY (`ceg_id`),
  ADD UNIQUE KEY `cegnev` (`cegnev`,`kapcsolattarto_email`);

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`felhasznalo_id`);

--
-- A tábla indexei `kepesseg`
--
ALTER TABLE `kepesseg`
  ADD PRIMARY KEY (`kepesseg_id`);

--
-- A tábla indexei `kepessegek`
--
ALTER TABLE `kepessegek`
  ADD PRIMARY KEY (`allas_id`,`kepesseg_id`);

--
-- A tábla indexei `kepzes`
--
ALTER TABLE `kepzes`
  ADD PRIMARY KEY (`kepzes_id`),
  ADD UNIQUE KEY `nev` (`nev`,`szint`,`megnevezes`,`ar`);

--
-- A tábla indexei `resztvevok`
--
ALTER TABLE `resztvevok`
  ADD PRIMARY KEY (`kepzes_id`,`felhasznalo_id`);

--
-- A tábla indexei `telephely`
--
ALTER TABLE `telephely`
  ADD PRIMARY KEY (`telephely_id`),
  ADD KEY `telephely_ibfk_1` (`ceg_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `allasajanlatok`
--
ALTER TABLE `allasajanlatok`
  MODIFY `allas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT a táblához `cegek`
--
ALTER TABLE `cegek`
  MODIFY `ceg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `felhasznalo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT a táblához `kepesseg`
--
ALTER TABLE `kepesseg`
  MODIFY `kepesseg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT a táblához `kepzes`
--
ALTER TABLE `kepzes`
  MODIFY `kepzes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT a táblához `telephely`
--
ALTER TABLE `telephely`
  MODIFY `telephely_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `allasajanlatok`
--
ALTER TABLE `allasajanlatok`
  ADD CONSTRAINT `allasajanlatok_ibfk_6` FOREIGN KEY (`telephely_id`) REFERENCES `telephely` (`telephely_id`),
  ADD CONSTRAINT `allasajanlatok_ibfk_7` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalok` (`felhasznalo_id`),
  ADD CONSTRAINT `allasajanlatok_ibfk_8` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`ceg_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `kepessegek`
--
ALTER TABLE `kepessegek`
  ADD CONSTRAINT `kepessegek_ibfk_1` FOREIGN KEY (`kepesseg_id`) REFERENCES `kepesseg` (`kepesseg_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kepessegek_ibfk_2` FOREIGN KEY (`allas_id`) REFERENCES `allasajanlatok` (`allas_id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `resztvevok`
--
ALTER TABLE `resztvevok`
  ADD CONSTRAINT `resztvevok_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalok` (`felhasznalo_id`),
  ADD CONSTRAINT `resztvevok_ibfk_2` FOREIGN KEY (`kepzes_id`) REFERENCES `kepzes` (`kepzes_id`);

--
-- Megkötések a táblához `telephely`
--
ALTER TABLE `telephely`
  ADD CONSTRAINT `telephely_ibfk_1` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`ceg_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
