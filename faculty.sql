-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 12, 2016 at 01:46 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `faculty`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `ClassId` int(11) NOT NULL AUTO_INCREMENT,
  `ClassInitials` varchar(50) NOT NULL,
  `ClassFullName` varchar(100) NOT NULL,
  `ClassStrength` int(10) NOT NULL,
  `DeptId` int(11) NOT NULL,
  PRIMARY KEY (`ClassId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`ClassId`, `ClassInitials`, `ClassFullName`, `ClassStrength`, `DeptId`) VALUES
(1, 'FY-BCA', 'First Year BCA', 55, 2),
(2, 'SY-BCA', 'Second Year BCA', 58, 2),
(3, 'TY-BCA', 'Third Year BCA', 50, 2),
(5, 'FY-BCOM', 'First Year BCOM', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `DeptId` int(10) NOT NULL AUTO_INCREMENT,
  `DeptInitials` varchar(50) NOT NULL,
  `DeptFullName` varchar(100) NOT NULL,
  PRIMARY KEY (`DeptId`),
  UNIQUE KEY `DeptInitials` (`DeptInitials`),
  UNIQUE KEY `DeptInitials_2` (`DeptInitials`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`DeptId`, `DeptInitials`, `DeptFullName`) VALUES
(1, 'BCOM', 'Bachelor of Commerce'),
(2, 'BCA', 'Bachelor of Computer Applications');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `EventId` int(11) NOT NULL AUTO_INCREMENT,
  `EventName` varchar(100) NOT NULL,
  `EventDesc` varchar(500) NOT NULL,
  `EventDate` varchar(50) NOT NULL,
  PRIMARY KEY (`EventId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventId`, `EventName`, `EventDesc`, `EventDate`) VALUES
(1, 'Event1', 'Event will b e soon started.', '12/04/2016'),
(2, 'Another Event Symphasis', 'bla bla bla', '11/04/2016'),
(3, 'test event', 'bla bla bla', '10/05/2016'),
(4, 'we event', 'on comming saturday', '13/04/2016');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `NewsId` int(11) NOT NULL AUTO_INCREMENT,
  `NewsDetails` varchar(600) NOT NULL,
  PRIMARY KEY (`NewsId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`NewsId`, `NewsDetails`) VALUES
(1, 'All classes will leave early tomorrow on account of Gudi Padwa!'),
(6, 'spactra is won by rosary'),
(3, 'marquee and text on same line'),
(4, 'Hi hello marquee and text on same line'),
(5, 'tomorrow is holiday');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `ProjectId` int(11) NOT NULL AUTO_INCREMENT,
  `ProjectTitle` varchar(100) NOT NULL,
  `ProjectFileName` varchar(100) NOT NULL,
  `DeptId` int(11) NOT NULL,
  `SemesterId` int(11) NOT NULL,
  `ClassId` int(11) NOT NULL,
  PRIMARY KEY (`ProjectId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`ProjectId`, `ProjectTitle`, `ProjectFileName`, `DeptId`, `SemesterId`, `ClassId`) VALUES
(1, 'Dummy Projects', '18e75d0dd392b7fe7adb8b8b8484918c.pdf', 1, 7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `ReportId` int(11) NOT NULL AUTO_INCREMENT,
  `SRollNum` varchar(10) NOT NULL,
  `ReportFileName` varchar(50) NOT NULL,
  `DeptId` int(11) NOT NULL,
  `SemesterId` int(11) NOT NULL,
  `ClassId` int(11) NOT NULL,
  PRIMARY KEY (`ReportId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`ReportId`, `SRollNum`, `ReportFileName`, `DeptId`, `SemesterId`, `ClassId`) VALUES
(1, 'FYBCA-43', '8e90df99bea1f642b7bf0171acf1a875.pdf', 2, 1, 1),
(2, 'fybca-43', '20b881efe2aa5a16a432841c3449ebb1.pdf', 2, 1, 1),
(3, 'fy-bca-23', '817915b063a107f5bfffd807116af23e.pdf', 2, 2, 1),
(4, 'fy-bca-3', '6d73b9fa300169e13a05393589ef0781.pdf', 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE IF NOT EXISTS `semesters` (
  `SemesterId` int(11) NOT NULL AUTO_INCREMENT,
  `SemesterName` varchar(50) NOT NULL,
  `DeptId` int(11) NOT NULL,
  PRIMARY KEY (`SemesterId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`SemesterId`, `SemesterName`, `DeptId`) VALUES
(1, 'Semester 1', 2),
(2, 'Semester 2', 2),
(3, 'Semester 3', 2),
(4, 'Semester 4', 2),
(5, 'Semester 5', 2),
(6, 'Semester 6', 2),
(7, 'Semester 1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staffdetails`
--

CREATE TABLE IF NOT EXISTS `staffdetails` (
  `StaffId` int(11) NOT NULL AUTO_INCREMENT,
  `StaffName` varchar(100) NOT NULL,
  `StaffCategory` varchar(50) NOT NULL,
  `StaffMobile` varchar(10) NOT NULL,
  `StaffEmail` varchar(50) NOT NULL,
  PRIMARY KEY (`StaffId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `staffdetails`
--

INSERT INTO `staffdetails` (`StaffId`, `StaffName`, `StaffCategory`, `StaffMobile`, `StaffEmail`) VALUES
(1, 'Rajesh Dalvi', 'Teaching', '9876543210', 'abc@yahoo.com'),
(2, 'Raju Chawal', 'Non-Teaching', '1111111111', 'aqw@qs.com'),
(3, 'Tanisha naik', 'Teaching', '9823457189', 'werq@ert.com'),
(4, 'blassia montaro', 'Teaching', '9876432134', 'qwe@wer.com');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `SubjectId` int(11) NOT NULL AUTO_INCREMENT,
  `SubjectName` varchar(100) NOT NULL,
  `SubjectUploadFileName` varchar(100) NOT NULL,
  `DeptId` int(11) NOT NULL,
  `SemesterId` int(11) NOT NULL,
  PRIMARY KEY (`SubjectId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`SubjectId`, `SubjectName`, `SubjectUploadFileName`, `DeptId`, `SemesterId`) VALUES
(1, 'Information Techoology Project Management', 'ff4acf1d79ffad4e91125a62f0579e25.pdf', 2, 1),
(2, 'COMPUTER ORGANIZZATION AND ARCHITECTURES ', '4b033e6252ea61d42ea37e248ce977d1.pdf', 2, 1),
(3, 'Maths', '530d231cf4c08a4917a67298f479acf3.pdf', 2, 2),
(4, 'IT COOS', '04a185f91e0dc9b189d531ac78b263b5.pdf', 2, 2),
(5, 'Maths', 'a1e74b62f55f9ca6ed7f481a0019ec68.pdf', 1, 7),
(6, 'English', 'b3cd3eebaf046a3fe6d50f1ae4f90b73.pdf', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE IF NOT EXISTS `timetables` (
  `TimetableId` int(11) NOT NULL AUTO_INCREMENT,
  `TimetableNote` varchar(200) NOT NULL,
  `TimetableFileName` varchar(100) NOT NULL,
  `DeptId` int(11) NOT NULL,
  `SemesterId` int(11) NOT NULL,
  `ClassId` int(11) NOT NULL,
  PRIMARY KEY (`TimetableId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`TimetableId`, `TimetableNote`, `TimetableFileName`, `DeptId`, `SemesterId`, `ClassId`) VALUES
(1, 'No Note', '4275889da76045b91890132727a6e3cf.pdf', 2, 1, 1),
(2, 'no note', '914e89258345fb6a0af599cc448f47fa.pdf', 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int(10) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Mobile` varchar(10) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `DepartmentId` varchar(50) NOT NULL,
  `UserRole` varchar(10) NOT NULL,
  `UserStatus` varchar(10) NOT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `FullName`, `Email`, `Mobile`, `Password`, `DepartmentId`, `UserRole`, `UserStatus`) VALUES
(1, 'Raj Naik', 'om@om.com', '9823181816', 'qwertyy', '["2"]', 'user', 'active'),
(2, 'Mr.Admin', 'admin@admin.com', '9876543210', 'qwerty', 'NO', 'admin', 'active'),
(3, 'Rajesh', 'dummy@test.com', '1234567890', 'qwerty', '["1","2"]', 'user', 'active'),
(4, 'swetlana', 'swetlana13843@gmail.com', '9860108433', 'sweta13843', '["2"]', 'user', 'active'),
(5, 'blassia monteiro', 'blassia11@gmail.com', '8007845552', 'qwerty', '["2"]', 'user', 'active'),
(6, 'Gleena Rodrigues', 'gleenarodrigues@yahoo.in', '8390943677', 'gleena', '["2"]', 'user', 'active'),
(7, 'snokia', 'snokia11@gmail.com', '2134872309', 'qwerty12', '["2"]', 'user', 'inactive');
