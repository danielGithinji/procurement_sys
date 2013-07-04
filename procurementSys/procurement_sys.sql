-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 04, 2013 at 05:01 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `procurement_sys`
--
CREATE DATABASE `procurement_sys` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `procurement_sys`;

-- --------------------------------------------------------

--
-- Table structure for table `approv_mat_req`
--

CREATE TABLE IF NOT EXISTS `approv_mat_req` (
  `mat_approvalID` int(6) NOT NULL AUTO_INCREMENT,
  `materialReqID` int(6) NOT NULL,
  `date_mat_approvd` date NOT NULL,
  PRIMARY KEY (`mat_approvalID`),
  UNIQUE KEY `FK_approv_mat_req` (`materialReqID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `approv_mat_req`
--

INSERT INTO `approv_mat_req` (`mat_approvalID`, `materialReqID`, `date_mat_approvd`) VALUES
(10, 10, '2013-03-29'),
(11, 16, '2013-04-03');

-- --------------------------------------------------------

--
-- Table structure for table `approv_purch_req`
--

CREATE TABLE IF NOT EXISTS `approv_purch_req` (
  `purch_approvID` int(6) NOT NULL AUTO_INCREMENT,
  `date_purch_approvd` date NOT NULL,
  `purchaseReqID` int(6) NOT NULL,
  PRIMARY KEY (`purch_approvID`),
  UNIQUE KEY `FK_approv_purch_req` (`purchaseReqID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `approv_purch_req`
--

INSERT INTO `approv_purch_req` (`purch_approvID`, `date_purch_approvd`, `purchaseReqID`) VALUES
(5, '2013-03-03', 13),
(6, '2013-03-03', 12),
(7, '2013-03-03', 11),
(8, '2013-03-30', 27),
(9, '2013-03-30', 28),
(10, '2013-03-30', 24),
(11, '2013-03-30', 26),
(12, '2013-03-30', 25),
(13, '2013-03-30', 23);

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `cal_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(10) NOT NULL,
  `data` text NOT NULL,
  `user_id` int(7) NOT NULL,
  PRIMARY KEY (`cal_id`),
  KEY `FK_calendar` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`cal_id`, `date`, `data`, `user_id`) VALUES
(10, '2013-04-3', 'early meet', 1002),
(11, '2013-04-17', '', 1002),
(12, '2013-04-10', 'here i am', 1002),
(13, '2013-04-11', 'yep', 1002),
(14, '2013-04-12', 'no', 1002),
(15, '2013-04-16', 'here i went to ', 1002),
(16, '2013-04-18', 'wololo', 1002),
(17, '2013-04-10', 'meeting', 1000),
(18, '2013-04-11', 'you think that''s what it means', 1000),
(19, '2013-04-17', 'meeting', 1000),
(20, '2013-04-15', 'tomorrow morning', 1000),
(21, '2013-04-22', 'yes that''s what am talking about', 1000),
(22, '2013-05-16', 'Meeting', 1002),
(23, '2013-05-17', 'Lunch time', 1002);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `itemID` int(10) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(20) NOT NULL,
  `itemDescription` varchar(30) NOT NULL,
  `pricePerUnit` double NOT NULL,
  `quantity` int(6) NOT NULL,
  `quantity_limit` int(6) NOT NULL,
  `categoryID` int(20) NOT NULL COMMENT 'foreign key from the material category table',
  PRIMARY KEY (`itemID`),
  UNIQUE KEY `NewIndex1` (`itemName`),
  KEY `categoryID` (`categoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `itemName`, `itemDescription`, `pricePerUnit`, `quantity`, `quantity_limit`, `categoryID`) VALUES
(1, 'chalk', 'packet', 30, 230, 10, 1),
(2, 'beans', 'bags', 200, 5, 10, 6),
(3, 'printing paper', 'bail', 400, 50, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_transaction`
--

CREATE TABLE IF NOT EXISTS `item_transaction` (
  `transactionID` int(5) NOT NULL AUTO_INCREMENT,
  `userID` int(4) NOT NULL COMMENT 'foreignKey from user''s table',
  `itemID` int(10) NOT NULL COMMENT 'foreign key from items table',
  `date` date NOT NULL,
  PRIMARY KEY (`transactionID`),
  KEY `FK_item_transaction` (`userID`),
  KEY `FK_item_transaction1` (`itemID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `item_transaction`
--

INSERT INTO `item_transaction` (`transactionID`, `userID`, `itemID`, `date`) VALUES
(22, 1002, 1, '2013-03-02'),
(23, 1003, 1, '2013-03-03'),
(24, 1003, 1, '2013-03-03'),
(25, 1003, 1, '2013-03-04'),
(26, 1003, 1, '2013-03-06'),
(27, 1003, 1, '2013-03-07'),
(32, 1001, 1, '2013-03-15'),
(42, 1002, 2, '2013-03-16'),
(43, 1002, 2, '1970-01-01'),
(44, 1002, 2, '2013-03-20'),
(45, 1002, 2, '2013-03-20'),
(46, 1002, 2, '2013-03-22'),
(47, 1002, 2, '2013-03-29'),
(48, 1002, 2, '2013-03-28'),
(49, 1002, 2, '2013-03-01'),
(50, 1002, 1, '2013-03-29'),
(51, 1002, 1, '2013-03-22'),
(52, 1002, 1, '2013-03-30'),
(53, 1001, 2, '2013-03-30'),
(54, 1001, 1, '2013-03-30'),
(55, 1001, 1, '2013-03-27'),
(56, 1001, 1, '2013-03-27'),
(57, 1001, 1, '2013-03-16'),
(58, 1001, 1, '2013-03-26'),
(59, 1001, 2, '2013-03-06'),
(60, 1001, 2, '2013-03-27'),
(61, 1002, 2, '2013-03-02'),
(62, 1001, 3, '2013-04-23'),
(63, 1002, 1, '2013-04-27'),
(64, 1002, 1, '2013-04-13');

-- --------------------------------------------------------

--
-- Table structure for table `material_category`
--

CREATE TABLE IF NOT EXISTS `material_category` (
  `categoryID` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(45) NOT NULL,
  PRIMARY KEY (`categoryID`),
  UNIQUE KEY `NewIndex1` (`categoryName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `material_category`
--

INSERT INTO `material_category` (`categoryID`, `categoryName`) VALUES
(8, 'building materials'),
(6, 'catering'),
(1, 'stationery'),
(9, 'tools');

-- --------------------------------------------------------

--
-- Table structure for table `material_requisition`
--

CREATE TABLE IF NOT EXISTS `material_requisition` (
  `materialReqID` int(11) NOT NULL AUTO_INCREMENT,
  `mat_quantity` varchar(30) NOT NULL,
  `department` text NOT NULL,
  `transactionID` int(5) NOT NULL COMMENT 'foreign key from transaction table',
  PRIMARY KEY (`materialReqID`),
  UNIQUE KEY `FK_material_requisition` (`transactionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `material_requisition`
--

INSERT INTO `material_requisition` (`materialReqID`, `mat_quantity`, `department`, `transactionID`) VALUES
(9, '21', 'maths and informatics', 32),
(10, '3', 'maths and informatics', 53),
(11, '20', 'maths and informatics', 54),
(12, '20', 'maths and informatics', 55),
(13, '20', 'maths and informatics', 56),
(14, '10', 'maths and informatics', 57),
(15, '12', 'maths and informatics', 58),
(16, '3', 'maths and informatics', 59),
(17, '500', 'maths and informatics', 62);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requisition`
--

CREATE TABLE IF NOT EXISTS `purchase_requisition` (
  `purchaseReqID` int(10) NOT NULL AUTO_INCREMENT,
  `quantity_ordered` varchar(20) NOT NULL,
  `supplierID` int(11) NOT NULL,
  `transactionID` int(5) NOT NULL,
  `order_no` int(6) NOT NULL,
  PRIMARY KEY (`purchaseReqID`),
  UNIQUE KEY `FK_purchase_requisition` (`transactionID`),
  KEY `FK_purchase_requisition1` (`supplierID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `purchase_requisition`
--

INSERT INTO `purchase_requisition` (`purchaseReqID`, `quantity_ordered`, `supplierID`, `transactionID`, `order_no`) VALUES
(8, '100', 3, 22, 2984),
(9, '200', 4, 23, 6729),
(10, '200', 4, 24, 7682),
(11, '300', 4, 25, 4664),
(12, '400', 3, 26, 2494),
(13, '600', 4, 27, 3858),
(23, '50', 4, 42, 7544),
(24, '300', 7, 44, 3267),
(25, '200', 4, 45, 4229),
(26, '45', 8, 46, 422),
(27, '40', 4, 47, 799),
(28, '300', 3, 48, 7661),
(29, '200', 3, 49, 6363),
(30, '50', 7, 61, 2110),
(31, '20', 3, 63, 1560),
(32, '20', 3, 64, 1956);

-- --------------------------------------------------------

--
-- Table structure for table `receive_note`
--

CREATE TABLE IF NOT EXISTS `receive_note` (
  `receiveID` int(10) NOT NULL AUTO_INCREMENT,
  `quantity_received` varchar(30) NOT NULL,
  `date_received` date NOT NULL,
  `purch_approvID` int(6) NOT NULL COMMENT 'foreign key from approve_purch table',
  PRIMARY KEY (`receiveID`),
  UNIQUE KEY `FK_receive_note` (`purch_approvID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=126 ;

--
-- Dumping data for table `receive_note`
--

INSERT INTO `receive_note` (`receiveID`, `quantity_received`, `date_received`, `purch_approvID`) VALUES
(119, '30', '2013-03-30', 5),
(120, '40', '2013-03-23', 7),
(123, '30', '2013-03-20', 6),
(125, '20', '2013-03-16', 8);

-- --------------------------------------------------------

--
-- Table structure for table `rejectd_mat_req`
--

CREATE TABLE IF NOT EXISTS `rejectd_mat_req` (
  `mat_rejectionID` int(6) NOT NULL AUTO_INCREMENT,
  `materialReqID` int(6) NOT NULL,
  `date_mat_rejectd` date DEFAULT NULL,
  PRIMARY KEY (`mat_rejectionID`),
  UNIQUE KEY `FK_rejectd_mat_req` (`materialReqID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `rejectd_mat_req`
--

INSERT INTO `rejectd_mat_req` (`mat_rejectionID`, `materialReqID`, `date_mat_rejectd`) VALUES
(18, 13, '2013-03-29'),
(19, 14, '2013-03-29');

-- --------------------------------------------------------

--
-- Table structure for table `rejectd_purch_req`
--

CREATE TABLE IF NOT EXISTS `rejectd_purch_req` (
  `purch_rejectdID` int(6) NOT NULL AUTO_INCREMENT,
  `purchaseReqID` int(6) NOT NULL,
  `date_purch_rejectd` date NOT NULL,
  PRIMARY KEY (`purch_rejectdID`),
  UNIQUE KEY `FK_rejectd_purch_req` (`purchaseReqID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `return_note`
--

CREATE TABLE IF NOT EXISTS `return_note` (
  `returnID` int(11) NOT NULL AUTO_INCREMENT,
  `receiveID` int(10) NOT NULL COMMENT 'foreign key from receive_note',
  PRIMARY KEY (`returnID`),
  UNIQUE KEY `foreign_key` (`receiveID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `return_note`
--

INSERT INTO `return_note` (`returnID`, `receiveID`) VALUES
(1, 125);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `supplierID` int(11) NOT NULL AUTO_INCREMENT,
  `supplierName` text NOT NULL,
  `supplierLocation` varchar(40) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `itemsSupplied` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`supplierID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplierID`, `supplierName`, `supplierLocation`, `phone_no`, `email`, `itemsSupplied`, `date`, `status`) VALUES
(3, 'Stationery King', 'Nairobi ', '0733456564', 'geedaniel2@gmail.com', 'stationery', '2013-05-01', 'available'),
(4, 'Mwaniki and Sons', 'Voi', '0721345678', 'geedaniel2@gmail.com', 'fresh produce', '2013-02-02', 'available'),
(7, 'Macdonalds', 'Mom', '0722334466', 'dani0g@yah.com', 'bread', '2013-01-03', 'available'),
(8, 'Njuguna Suppliers', 'Kiambu', '0733333333', 'dani0g@yahoo.com', 'statonery', '2013-07-01', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `department` text NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `secondName` varchar(20) NOT NULL,
  `national_id` varchar(11) NOT NULL,
  `gender` tinytext NOT NULL,
  `email` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `status` tinytext NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`),
  KEY `username_2` (`username`),
  KEY `username_3` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1009 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `role`, `department`, `firstName`, `secondName`, `national_id`, `gender`, `email`, `dob`, `status`) VALUES
(1000, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'administrator', 'selected', 'Administrator', 'administrator', '27456789', 'male', 'admin@admin.com', '1970-01-01', 'active'),
(1001, 'jane', '8a8deed44623d4c44268c26652d80945851c4f7f', 'secretary', 'maths and informatics', 'Jane', 'Kamau', '27072749', 'female', 'jane@procurement.com', '1987-03-01', 'active'),
(1002, 'demo', '89e495e7941cf9e40e6980d14a16bf023ccd4c91', 'procurement officer', 'procurement', 'Kenneth', 'Njuguna', '28394923', 'male', 'ken@procurement.com', '1970-01-01', 'active'),
(1003, 'davi', 'a02bf04bbb18a4f43b21f4f64c342a6586da7a0b', 'finance officer', 'finance', 'David', 'Ochieng', '20948731', 'male', 'david@procurement.com', '1987-10-01', 'active'),
(1008, 'dan', '2591e5f46f28d303f9dc027d475a5c60d8dea17a', 'sec', 'maths and informatics', 'daniel', 'gee', '123', 'male', 'daniel@procurement.com', '2013-04-05', 'active');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approv_mat_req`
--
ALTER TABLE `approv_mat_req`
  ADD CONSTRAINT `FK_approv_mat_req` FOREIGN KEY (`materialReqID`) REFERENCES `material_requisition` (`materialReqID`);

--
-- Constraints for table `approv_purch_req`
--
ALTER TABLE `approv_purch_req`
  ADD CONSTRAINT `FK_approv_purch_req` FOREIGN KEY (`purchaseReqID`) REFERENCES `purchase_requisition` (`purchaseReqID`);

--
-- Constraints for table `calendar`
--
ALTER TABLE `calendar`
  ADD CONSTRAINT `FK_calendar` FOREIGN KEY (`user_id`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `categoryID` FOREIGN KEY (`categoryID`) REFERENCES `material_category` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_transaction`
--
ALTER TABLE `item_transaction`
  ADD CONSTRAINT `FK_item_transaction` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_item_transaction1` FOREIGN KEY (`itemID`) REFERENCES `items` (`itemID`);

--
-- Constraints for table `material_requisition`
--
ALTER TABLE `material_requisition`
  ADD CONSTRAINT `FK_material_requisition` FOREIGN KEY (`transactionID`) REFERENCES `item_transaction` (`transactionID`);

--
-- Constraints for table `purchase_requisition`
--
ALTER TABLE `purchase_requisition`
  ADD CONSTRAINT `FK_purchase_requisition` FOREIGN KEY (`transactionID`) REFERENCES `item_transaction` (`transactionID`),
  ADD CONSTRAINT `FK_purchase_requisition1` FOREIGN KEY (`supplierID`) REFERENCES `supplier` (`supplierID`);

--
-- Constraints for table `receive_note`
--
ALTER TABLE `receive_note`
  ADD CONSTRAINT `FK_receive_note` FOREIGN KEY (`purch_approvID`) REFERENCES `approv_purch_req` (`purch_approvID`);

--
-- Constraints for table `rejectd_mat_req`
--
ALTER TABLE `rejectd_mat_req`
  ADD CONSTRAINT `FK_rejectd_mat_req` FOREIGN KEY (`materialReqID`) REFERENCES `material_requisition` (`materialReqID`);

--
-- Constraints for table `rejectd_purch_req`
--
ALTER TABLE `rejectd_purch_req`
  ADD CONSTRAINT `FK_rejectd_purch_req` FOREIGN KEY (`purchaseReqID`) REFERENCES `purchase_requisition` (`purchaseReqID`);

--
-- Constraints for table `return_note`
--
ALTER TABLE `return_note`
  ADD CONSTRAINT `FK_return_note` FOREIGN KEY (`receiveID`) REFERENCES `receive_note` (`receiveID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
