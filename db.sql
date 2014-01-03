-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 03, 2014 at 08:39 AM
-- Server version: 5.1.60
-- PHP Version: 5.5.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_violations`
--

CREATE TABLE IF NOT EXISTS `access_violations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(55) NOT NULL,
  `ip` text NOT NULL,
  `user_agent` varchar(55) NOT NULL,
  `time` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `bad_logins`
--

CREATE TABLE IF NOT EXISTS `bad_logins` (
  `number_logins` int(11) NOT NULL,
  `ip_address` varchar(60) NOT NULL,
  `user` varchar(55) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `useragent` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE IF NOT EXISTS `balances` (
  `User_ID` int(11) NOT NULL,
  `Amount` text NOT NULL,
  `Coin` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Pending` int(11) NOT NULL,
  `Wallet_ID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

--
-- Table structure for table `bantables_ip`
--

CREATE TABLE IF NOT EXISTS `bantables_ip` (
  `date` text NOT NULL,
  `ip` varchar(55) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `setting` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE IF NOT EXISTS `deposits` (
  `Transaction_Id` text NOT NULL,
  `Amount` text NOT NULL,
  `Coin` text NOT NULL,
  `Paid` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Account` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL,
  `username` varchar(55) NOT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `color` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `Servers`
--

CREATE TABLE IF NOT EXISTS `Servers` (
  `Server_Owner` int(12) NOT NULL,
  `Server_Name` text NOT NULL,
  `Server_Id` int(3) NOT NULL AUTO_INCREMENT,
  `Server_Ip` text NOT NULL,
  `Server_Type` int(1) NOT NULL,
  `Server_User` text NOT NULL,
  `Server_Password` text NOT NULL,
  PRIMARY KEY (`Server_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TicketReplies`
--

CREATE TABLE IF NOT EXISTS `TicketReplies` (
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` longtext NOT NULL,
  `posted` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `Tickets`
--

CREATE TABLE IF NOT EXISTS `Tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `posted` text NOT NULL,
  `opened` int(11) DEFAULT '1',
  `body` longblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `trades`
--

CREATE TABLE IF NOT EXISTS `trades` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `To` text NOT NULL,
  `From` text NOT NULL,
  `Amount` text NOT NULL,
  `Value` text NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Type` text NOT NULL,
  `Finished` int(11) NOT NULL DEFAULT '0',
  `Fee` text NOT NULL,
  `Total` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=97 ;

-- --------------------------------------------------------

--
-- Table structure for table `Trade_History`
--

CREATE TABLE IF NOT EXISTS `Trade_History` (
  `Market_Id` text NOT NULL,
  `Price` text NOT NULL,
  `Quantity` text NOT NULL,
  `Timestamp` text NOT NULL,
  `trade_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`trade_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userCake_Groups`
--

CREATE TABLE IF NOT EXISTS `userCake_Groups` (
  `Group_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Group_Name` varchar(225) NOT NULL,
  `Color` text NOT NULL,
  PRIMARY KEY (`Group_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `userCake_Users`
--

CREATE TABLE IF NOT EXISTS `userCake_Users` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(150) NOT NULL,
  `Username_Clean` varchar(150) NOT NULL,
  `Password` varchar(225) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `ActivationToken` varchar(225) NOT NULL,
  `LastActivationRequest` int(11) NOT NULL,
  `LostPasswordRequest` int(1) NOT NULL DEFAULT '0',
  `Active` int(1) NOT NULL,
  `Group_ID` int(11) NOT NULL,
  `SignUpDate` int(11) NOT NULL,
  `LastSignIn` int(11) NOT NULL,
  `ChatBanned` int(11) DEFAULT '0',
  `BannedBy` varchar(55) DEFAULT NULL,
  `Shares` int(11) DEFAULT NULL,
  `Banned` int(11) DEFAULT NULL,
  `api_key` text,
  PRIMARY KEY (`User_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `Wallets`
--

CREATE TABLE IF NOT EXISTS `Wallets` (
  `Name` text NOT NULL,
  `Acronymn` text NOT NULL,
  `Market_Id` int(6) NOT NULL,
  `Wallet_IP` text NOT NULL,
  `Wallet_Username` text NOT NULL,
  `Wallet_Password` text NOT NULL,
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Last_Trade` text NOT NULL,
  `Wallet_Port` int(11) NOT NULL,
  `disabled` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

-- --------------------------------------------------------

--
-- Table structure for table `Withdraw_History`
--

CREATE TABLE IF NOT EXISTS `Withdraw_History` (
  `Timestamp` int(11) NOT NULL,
  `User` int(11) NOT NULL,
  `Amount` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Withdraw_Requests`
--

CREATE TABLE IF NOT EXISTS `Withdraw_Requests` (
  `Amount` text NOT NULL,
  `Address` text NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Wallet_Id` int(11) NOT NULL,
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
