-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3308
-- Létrehozás ideje: 2020. Feb 10. 20:01
-- Kiszolgáló verziója: 5.7.28
-- PHP verzió: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `fireflies`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hotel`
--

DROP TABLE IF EXISTS `hotel`;
CREATE TABLE IF NOT EXISTS `hotel`
(
    `id`               int(10) NOT NULL,
    `name_search_id`   int(10)        DEFAULT NULL,
    `hotelcode`        varchar(16)    DEFAULT NULL,
    `name`             varchar(256)   DEFAULT NULL,
    `country`          varchar(128)   DEFAULT NULL,
    `city`             varchar(128)   DEFAULT NULL,
    `address`          varchar(256)   DEFAULT NULL,
    `lat`              decimal(10, 7) DEFAULT NULL,
    `lon`              decimal(10, 7) DEFAULT NULL,
    `stars`            tinyint(1)     DEFAULT NULL,
    `is_searched_city` tinyint(1)     DEFAULT NULL,
    `distance`         varchar(45)    DEFAULT NULL,
    `source`           varchar(16)    DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `hotelcode_idx` (`hotelcode`),
    KEY `namesearch_id` (`name_search_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- A nézet helyettes szerkezete `hotel_crud`
-- (Lásd alább az aktuális nézetet)
--
DROP VIEW IF EXISTS `hotel_crud`;
CREATE TABLE IF NOT EXISTS `hotel_crud`
(
    `id`               int(10),
    `name_search_id`   int(10),
    `hotelcode`        varchar(16),
    `name`             varchar(256),
    `country`          varchar(128),
    `city`             varchar(128),
    `address`          varchar(256),
    `lat`              decimal(10, 7),
    `lon`              decimal(10, 7),
    `stars`            tinyint(1),
    `is_searched_city` tinyint(1),
    `distance`         varchar(45),
    `source`           varchar(16),
    `min_price`        double,
    `max_price`        double
);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `roompacks`
--

DROP TABLE IF EXISTS `roompacks`;
CREATE TABLE IF NOT EXISTS `roompacks`
(
    `board`        varchar(128) NOT NULL,
    `cancelable`   tinyint(1)  DEFAULT NULL,
    `hotelCode`    varchar(16)  NOT NULL,
    `pprice`       double      DEFAULT NULL,
    `price`        double      DEFAULT NULL,
    `market_price` double      DEFAULT NULL,
    `processId`    varchar(32) DEFAULT NULL,
    `source`       varchar(16) DEFAULT NULL,
    `supply`       varchar(32) DEFAULT NULL,
    PRIMARY KEY (`board`, `hotelCode`),
    KEY `hotelcode_idx` (`hotelCode`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tripadvisor`
--

DROP TABLE IF EXISTS `tripadvisor`;
CREATE TABLE IF NOT EXISTS `tripadvisor`
(
    `id`          int(10) NOT NULL,
    `hotel_id`    int(10)      DEFAULT NULL,
    `avgrating`   tinyint(1)   DEFAULT NULL,
    `ranking`     int(10)      DEFAULT NULL,
    `ratingimage` varchar(256) DEFAULT NULL,
    `reviewcnt`   int(10)      DEFAULT NULL,
    `url`         varchar(256) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `tripadvisor_hotel_idx` (`hotel_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Nézet szerkezete `hotel_crud`
--
DROP TABLE IF EXISTS `hotel_crud`;

CREATE OR REPLACE VIEW `hotel_crud` AS
select `a`.`id`               AS `id`,
       `a`.`name_search_id`   AS `name_search_id`,
       `a`.`hotelcode`        AS `hotelcode`,
       `a`.`name`             AS `name`,
       `a`.`country`          AS `country`,
       `a`.`city`             AS `city`,
       `a`.`address`          AS `address`,
       `a`.`lat`              AS `lat`,
       `a`.`lon`              AS `lon`,
       `a`.`stars`            AS `stars`,
       `a`.`is_searched_city` AS `is_searched_city`,
       `a`.`distance`         AS `distance`,
       `a`.`source`           AS `source`,
       min(`b`.`price`)       AS `min_price`,
       max(`b`.`price`)       AS `max_price`
from (`hotel` `a`
         join `roompacks` `b` on ((`a`.`hotelcode` = `b`.`hotelCode`)))
group by `a`.`hotelcode`;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `roompacks`
--
ALTER TABLE `roompacks`
    ADD CONSTRAINT `hotelcode_fkn` FOREIGN KEY (`hotelCode`) REFERENCES `hotel` (`hotelcode`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Megkötések a táblához `tripadvisor`
--
ALTER TABLE `tripadvisor`
    ADD CONSTRAINT `tripadvisor_hotel_fkn` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
