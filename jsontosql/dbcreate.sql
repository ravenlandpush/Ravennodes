CREATE DATABASE ravenstatus;
USE DATABASE ravenstatus;
CREATE TABLE `nodes` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `ip` varchar(32) NOT NULL,
  `port` int(7) NOT NULL,
  `codeversion` int(12) NOT NULL,
  `ravenrelease` varchar(48) NOT NULL,
  `timefound` int(48) NOT NULL,
  `unknown` int(12) NOT NULL,
  `block` int(20) NOT NULL,
  `rdns` varchar(254) NOT NULL,
  `city` varchar(127) NOT NULL,
  `countrycode` varchar(4) NOT NULL,
  `latitude` varchar(54) NOT NULL,
  `longitude` varchar(54) NOT NULL,
  `locality` varchar(54) NOT NULL,
  `ASnumber` varchar(12) NOT NULL,
  `ISP` varchar(254) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
