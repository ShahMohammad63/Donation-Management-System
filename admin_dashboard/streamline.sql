-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2025 at 02:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_information_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaign_profile`
--

CREATE TABLE `campaign_profile` (
  `Campaign_ID` int(4) NOT NULL,
  `Title` varchar(50) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Goal_Amount` decimal(10,2) DEFAULT NULL,
  `Raised_Amount` decimal(10,2) DEFAULT NULL,
  `Launch_Date` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campaign_profile`
--

INSERT INTO `campaign_profile` (`Campaign_ID`, `Title`, `Description`, `Goal_Amount`, `Raised_Amount`, `Launch_Date`) VALUES
(1101, 'Warm Hearts Winter Drive', 'Providing blankets and warm clothes to families in', 50000.00, 14000.00, '10-Jan-24'),
(1102, 'Feed the Future', 'Offering daily meals to hungry children in urban s', 25000.00, 12000.00, '10-Jan-24'),
(1103, 'Rebuild After the Storm', 'Helping disaster-affected families with shelter an', 30000.00, 10000.00, '10-Jan-24'),
(1104, 'Books for Bright Minds', 'Supplying books and school materials to rural stud', 23000.00, 11000.00, '10-Jan-24'),
(1105, 'Clean Water, Healthy Lives', 'Bringing safe drinking water to remote villages.', 35000.00, 12000.00, '10-Jan-24');

-- --------------------------------------------------------

--
-- Table structure for table `donor_profile`
--

CREATE TABLE `donor_profile` (
  `Donor_ID` varchar(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Date_of_Birth` varchar(9) DEFAULT NULL,
  `Gender` varchar(1) DEFAULT NULL,
  `Address` varchar(50) DEFAULT NULL,
  `Contributed_Amount` varchar(11) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Blood_Group` varchar(2) DEFAULT NULL,
  `Profession` varchar(50) DEFAULT NULL,
  `Registration_Date` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor_profile`
--

INSERT INTO `donor_profile` (`Donor_ID`, `Name`, `Date_of_Birth`, `Gender`, `Address`, `Contributed_Amount`, `Email`, `Blood_Group`, `Profession`, `Registration_Date`) VALUES
('105600005', 'Ramin Afroz', '19-Feb-96', 'M', ' 139/B, Senpara, Mirpur-1216', '2500', 'afrozramin1@gmail.com', 'O+', 'Teacher', '29-Oct-23'),
('105600006', 'Md. Rezaun Nabi', '02-Nov-79', 'M', '26, Topkhana Road, Segunbagicha, Dhaka-1000', '2500', 'rezaun_nabi@yahoo.com', 'B+', 'Service Holder', '04-Aug-07'),
('105600007', 'Mizanur Rahman', '07-Apr-75', 'M', '86/1, Nayapaltan, Dhaka-1000', '6500', 'mizan.milestone@gmail.com', 'A+', 'Businessman', '29-Aug-02'),
('105600008', 'Karuna Biswas', '16-Dec-92', 'F', '20, Central Road, Dhanmondi, Dhaka-1205', '3100', 'biswaskaruna98@gmail.com', 'B+', 'Lawyer', '12-Feb-19'),
('105600009', 'Md. Motiur Rahman', '20-Aug-75', 'M', 'House-06, Road-02, Sector-10, Uttara, Dhaka-1230', '1200', 'motiurrahman8164@gmail.com', 'A+', 'Doctor', '19-Jul-03'),
('105600010', 'Motahar Hossain', '11-Sep-94', 'M', ' Darussalam road, Section-1, Mirpur-1216', '15000', 'motaharh14@gmail.com	', 'A+', 'Banker', '30-Oct-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaign_profile`
--
ALTER TABLE `campaign_profile`
  ADD PRIMARY KEY (`Campaign_ID`);

--
-- Indexes for table `donor_profile`
--
ALTER TABLE `donor_profile`
  ADD PRIMARY KEY (`Donor_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
