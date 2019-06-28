-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Oct 14, 2016 at 10:16 AM
-- Server version: 5.6.33
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cp4724_slimshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cartitems`
--

CREATE TABLE IF NOT EXISTS `cartitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `sessionID` varchar(50) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `createdTS` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `sessionID_2` (`sessionID`,`productID`),
  KEY `sessionID` (`sessionID`),
  KEY `productID` (`productID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `cartitems`
--

INSERT INTO `cartitems` (`ID`, `sessionID`, `productID`, `quantity`, `createdTS`) VALUES
(10, 'k8llv4n7bs464jbqcmp2s02435', 4, 3, '2016-10-14 14:38:36'),
(11, 'k8llv4n7bs464jbqcmp2s02435', 1, 1, '2016-10-14 14:38:48'),
(12, 'k8llv4n7bs464jbqcmp2s02435', 2, 1, '2016-10-14 14:38:54'),
(13, '5s7nc3l15l5qbpu5t1id8u7ra4', 1, 1, '2016-10-14 16:35:09');

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE IF NOT EXISTS `orderitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `orderID` int(11) NOT NULL,
  `origProductID` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `origProductID` (`origProductID`),
  KEY `orderID` (`orderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`ID`, `orderID`, `origProductID`, `price`, `quantity`) VALUES
(1, 2, 1, '5.57', 3),
(2, 2, 3, '17.79', 2),
(3, 2, 4, '55.44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `postalCode` varchar(6) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `totalBeforeTax` decimal(10,2) NOT NULL,
  `shippingBeforeTax` decimal(10,2) NOT NULL,
  `taxes` decimal(10,2) NOT NULL,
  `totalWithShippingAndTaxes` decimal(10,2) NOT NULL,
  `dateTimePlaced` datetime NOT NULL,
  `dateTimeShipped` datetime DEFAULT NULL,
  `status` enum('placed','shipped','cancelled','delivered') NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ID`, `userID`, `name`, `address`, `postalCode`, `email`, `phoneNumber`, `totalBeforeTax`, `shippingBeforeTax`, `taxes`, `totalWithShippingAndTaxes`, `dateTimePlaced`, `dateTimeShipped`, `status`) VALUES
(2, NULL, 'Jerry J', '1234 some st.', 'H8U1R3', 'jerry@jerry.com', '514-555-12', '107.73', '15.00', '18.41', '141.14', '2016-10-13 18:54:16', NULL, 'placed');

-- --------------------------------------------------------

--
-- Table structure for table `passresets`
--

CREATE TABLE IF NOT EXISTS `passresets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `secretToken` varchar(50) NOT NULL,
  `expiryDateTime` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `passresets`
--

INSERT INTO `passresets` (`ID`, `userID`, `secretToken`, `expiryDateTime`) VALUES
(1, 4, 'Q902wxtkCtidrCYHbmrJVzElFdm0t4FkeGnKeQ4Qkm3LZ2sboU', '2016-10-14 16:26:59'),
(4, 5, '35xI3z5lmE8es7M4NiRqk2PZ6jdzNT3QYBz1aEnxjvLMCyQpQI', '2016-10-14 19:55:31'),
(11, 6, 'AaYQHYX36Hed3txYdGS9sFJgt5rxXz2yJ0pqZnu64Ij7bR6pxY', '2016-10-14 16:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `imagePath` varchar(250) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `name`, `description`, `imagePath`, `price`) VALUES
(1, 'Cat one', 'This is a cat number one. lakjdfklaj kldfj akldfj aklsj faklsj fdaskljdflakjldfkaj df', 'cat1.jpg', '5.57'),
(2, 'Another cat it is 2222', 'Two klj23 4lk2j 4kl23j l4kj 23lk4j 32klj 2lkj4 32klj 4kl2j 34klj 2l34kj 2lkj4 23lkj ', 'cat2.jpg', '22.45'),
(3, 'Third poster of a cat 3333', 'jkljlk23j 234kl 234klj3 4lk2j 34klj 234klj 2kl34j kl23j 4lk23j 4kl23j 4kl23j 423lj 234lk3', 'cat3.jpg', '17.79'),
(4, 'Quarter cat 444', 'klaj dlaskf jklj 23l4kj 423klj 423klj 4l23kj 4lk23j 4kl23j 4lk23j 4lk23j 4lk23j lkj 234kjl 234klj l', 'cat4.jpg', '55.44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FBID` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `securityRole` enum('user','admin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `FBID`, `name`, `email`, `password`, `securityRole`) VALUES
(1, NULL, 'Jerry', 'jerry@jerry.com', 'ABCabc123', 'user'),
(2, NULL, 'Patty P', 'patty@p.com', 'ec5f6aee63bb96a3a2d88662fc215328', 'user'),
(3, NULL, 'Terry P', 'terry@terry.com', '60d82e060ad50da2c287d6680cd6111adcb56aededd9e1f4681328f30f1b88b7', 'user'),
(4, NULL, 'GregP', 'greg@greg.com', '$2y$10$9PTpSl1AhXGOGt7a8lSB1eTRyuKO5FPZdWZq8GeoSafWsPq8MUD1.', 'user'),
(5, NULL, 'quan', 'xingquan6@gmail.com', '$2y$10$G0hnIW./pAesM4eBkYjef.s3glbwVqq6Npsa.zMVpgimROZFJIrYi', 'user'),
(6, NULL, 'SendIt Away', 'senditaway@hotmail.com', '$2y$10$iHn5mIzlYTmhrBDNP8Joc.ILiNnrAMMvTGyAt5IBu9/mWiNUM7t0q', 'user');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`ID`);

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`ID`),
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`origProductID`) REFERENCES `products` (`ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `passresets`
--
ALTER TABLE `passresets`
  ADD CONSTRAINT `passresets_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
