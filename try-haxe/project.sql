-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015 年 7 朁E08 日 16:08
-- サーバのバージョン： 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `haxeon`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `projectID` char(255) NOT NULL,
  `projectName` varchar(255) NOT NULL,
  `ownerUserID` char(255) NOT NULL,
  `pv` int(11) NOT NULL,
  `url` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `project`
--

INSERT INTO `project` (`projectID`, `projectName`, `ownerUserID`, `pv`, `url`) VALUES
('cBCd5', 'HelloWorld', 'user1', 100, 'http://localhost/try-haxe/index.html#cBCd5'),
('fd38D', 'HelloWorld2', 'user2', 200, 'http://localhost/try-haxe/index.html#fd38D'),
('D9B57', 'sampleProject', '__unknown__', 10, 'http://localhost/try-haxe/index.html#D9B57'),
('b193b', 'sampleProject', '__unknown__', 10, 'http://localhost/try-haxe/index.html#b193b'),
('c6270', 'sampleProject', '__unknown__', 10, 'http://localhost/try-haxe/index.html#c6270'),
('cBCd5', 'sampleProject', '__unknown__', 10, 'http://localhost/try-haxe/index.html#cBCd5');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
