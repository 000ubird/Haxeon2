-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015 年 8 朁E21 日 14:37
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
  `projectName` varchar(255) DEFAULT NULL,
  `ownerUserID` char(255) NOT NULL,
  `pv` int(11) NOT NULL,
  `fork` int(11) NOT NULL DEFAULT '0',
  `url` char(255) NOT NULL,
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `project`
--

INSERT INTO `project` (`projectID`, `projectName`, `ownerUserID`, `pv`, `fork`, `url`, `createTime`, `modified`) VALUES
('85BA5', 'HelloWorld', 'user1', 0, 0, 'http://localhost/haxeon2/try-haxe/index.html#85BA5', '2015-08-21 05:36:52', '2015-08-21 05:36:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD KEY `projectID` (`projectID`), ADD KEY `pv` (`pv`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
