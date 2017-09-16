-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generatie Tijd: 07 Jul 2009 om 14:55
-- Server versie: 5.0.67
-- PHP Versie: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hanzecontact`
--

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `DepartmentID` int(11) NOT NULL auto_increment,
  `DepartmentName` varchar(128) NOT NULL,
  `ManagerID` int(11) NOT NULL,
  `LocationID` int(11) NOT NULL,
  PRIMARY KEY  (`DepartmentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=191 ;

--
-- Gegevens worden uitgevoerd voor tabel `departments`
--

INSERT INTO `departments` (`DepartmentID`, `DepartmentName`, `ManagerID`, `LocationID`) VALUES
(10, 'Administration', 200, 1700),
(20, 'Marketing', 201, 1800),
(50, 'Shipping', 124, 1500),
(60, 'IT', 103, 1400),
(80, 'Sales', 149, 2500),
(90, 'Executive', 100, 1700),
(110, 'Accounting', 205, 1700),
(190, 'Contracting', 0, 1700);

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `EmployeeID` int(11) NOT NULL auto_increment,
  `FirstName` varchar(16) NOT NULL,
  `LastName` varchar(32) NOT NULL,
  `Email` varchar(32) NOT NULL,
  `PhoneNumber` varchar(16) NOT NULL,
  `HireDate` datetime NOT NULL,
  `JobID` int(11) NOT NULL,
  `Salary` float NOT NULL,
  `CommissionPCT` varchar(16) NOT NULL,
  `ManagerID` int(11) NOT NULL,
  `DepartmentID` int(11) NOT NULL,
  PRIMARY KEY  (`EmployeeID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=207 ;

--
-- Gegevens worden uitgevoerd voor tabel `employees`
--

INSERT INTO `employees` (`EmployeeID`, `FirstName`, `LastName`, `Email`, `PhoneNumber`, `HireDate`, `JobID`, `Salary`, `CommissionPCT`, `ManagerID`, `DepartmentID`) VALUES
(100, 'Steven', 'King', 'SKING', '515.123.4567', '0000-00-00 00:00:00', 0, 52800, '', 0, 90),
(101, 'Neena', 'Kochhar', 'NKOCHHAR', '515.123.4568', '0000-00-00 00:00:00', 0, 37400, '', 100, 90),
(102, 'Lex', 'De Haan', 'LDEHAAN', '515.123.4569', '0000-00-00 00:00:00', 0, 37400, '', 100, 90),
(200, 'Jennifer', 'Whalen', 'JWHALEN', '515.123.4444', '0000-00-00 00:00:00', 0, 10648, '', 101, 10),
(205, 'Shelley', 'Higgins', 'SHIGGINS', '515.123.8080', '0000-00-00 00:00:00', 0, 26400, '', 101, 110),
(206, 'William', 'Gietz', 'WGIETZ', '515.123.8181', '0000-00-00 00:00:00', 0, 20086, '', 205, 110),
(149, 'Eleni', 'Zlotkey', 'EZLOTKEY', '011.44.1344.4290', '2029-01-00 00:00:00', 0, 23100, ',2', 100, 80),
(174, 'Ellen', 'Abel', 'EABEL', '011.44.1644.4292', '0000-00-00 00:00:00', 0, 24200, ',3', 149, 80),
(176, 'Jonathon', 'Taylor', 'JTAYLOR', '011.44.1644.4292', '0000-00-00 00:00:00', 0, 18920, ',2', 149, 80),
(178, 'Kimberely', 'Grant', 'KGRANT', '011.44.1644.4292', '0000-00-00 00:00:00', 0, 15400, ',15', 149, 0),
(124, 'Kevin', 'Mourgos', 'KMOURGOS', '650.123.5234', '0000-00-00 00:00:00', 0, 12760, '', 100, 50),
(141, 'Trenna', 'Rajs', 'TRAJS', '650.121.8009', '0000-00-00 00:00:00', 0, 7700, '', 124, 50),
(142, 'Curtis', 'Davies', 'CDAVIES', '650.121.2994', '0000-00-00 00:00:00', 0, 6820, '', 124, 50),
(143, 'Randall', 'Matos', 'RMATOS', '650.121.2874', '0000-00-00 00:00:00', 0, 5720, '', 124, 50),
(144, 'Peter', 'Vargas', 'PVARGAS', '650.121.2004', '0000-00-00 00:00:00', 0, 5500, '', 124, 50),
(103, 'Alexander', 'Hunold', 'AHUNOLD', '590.423.4567', '0000-00-00 00:00:00', 0, 19800, '', 102, 60),
(104, 'Bruce', 'Ernst', 'BERNST', '590.423.4568', '0000-00-00 00:00:00', 0, 13200, '', 103, 60),
(107, 'Diana', 'Lorentz', 'DLORENTZ', '590.423.5567', '0000-00-00 00:00:00', 0, 9240, '', 103, 60),
(201, 'Michael', 'Hartstein', 'MHARTSTE', '515.123.5555', '0000-00-00 00:00:00', 0, 28600, '', 100, 20),
(202, 'Pat', 'Fay', 'PFAY', '603.123.6666', '0000-00-00 00:00:00', 0, 13200, '', 201, 20);

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `JobID` int(11) NOT NULL auto_increment,
  `JobTitle` varchar(16) NOT NULL,
  `MinSalary` float NOT NULL,
  `MaxSalary` float NOT NULL,
  PRIMARY KEY  (`JobID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Gegevens worden uitgevoerd voor tabel `jobs`
--

INSERT INTO `jobs` (`JobID`, `JobTitle`, `MinSalary`, `MaxSalary`) VALUES
(1, 'President', 20000, 40000),
(2, 'Administration V', 15000, 30000),
(3, 'Administration A', 3000, 6000),
(4, 'Accounting Manag', 8200, 16000),
(5, 'Public Accountan', 4200, 9000),
(6, 'Sales Manager', 10000, 20000),
(7, 'Sales Representa', 6000, 12000),
(8, 'Stock Manager', 5500, 8500),
(9, 'Stock Clerk', 2000, 5000),
(10, 'Programmer', 4000, 10000),
(11, 'Marketing Manage', 9000, 15000),
(12, 'Marketing Repres', 4000, 9000);

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `LocationID` int(11) NOT NULL auto_increment,
  `StreetAddress` varchar(32) NOT NULL,
  `PostalCode` varchar(8) NOT NULL,
  `City` varchar(16) NOT NULL,
  `StateProvince` varchar(16) NOT NULL,
  `CountryID` int(11) NOT NULL,
  PRIMARY KEY  (`LocationID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2501 ;

--
-- Gegevens worden uitgevoerd voor tabel `locations`
--

INSERT INTO `locations` (`LocationID`, `StreetAddress`, `PostalCode`, `City`, `StateProvince`, `CountryID`) VALUES
(1800, '460 Bloor St. W.', 'ON M5S 1', 'Toronto', 'Ontario', 0),
(2500, 'Magdalen Centre, The Oxford Scie', 'OX9 9ZB', 'Oxford', 'Oxford', 0),
(1400, '2014 Jabberwocky Rd', '26192', 'Southlake', 'Texas', 0),
(1500, '2011 Interiors Blvd', '99236', 'South San Franci', 'California', 0),
(1700, '2004 Charade Rd', '98199', 'Seattle', 'Washington', 0);
