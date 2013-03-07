-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 23, 2012 at 03:26 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pas`
--

-- --------------------------------------------------------

--
-- Table structure for table `adm`
--

DROP TABLE IF EXISTS `adm`;
CREATE TABLE `adm` (
  `admDetailsAdmId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ptInfoUniqueId` int(10) unsigned NOT NULL,
  `ptInfoConfidential` varchar(255) NOT NULL,
  `ptInfoCurrentIns` varchar(255) NOT NULL,
  `ptInfoDiagnosis` varchar(255) NOT NULL,
  `ptInfoAdmNum` varchar(255) NOT NULL,
  `admDetailsAdmType` varchar(255) NOT NULL,
  `admDetailsDate` varchar(255) NOT NULL,
  `admDetailsTime` varchar(255) NOT NULL,
  `admDetailsLength` varchar(255) NOT NULL,
  `mdAdmitting` varchar(255) NOT NULL,
  `mdAttending` varchar(255) NOT NULL,
  `mdSurgical` varchar(255) NOT NULL,
  `mdPrimary` varchar(255) NOT NULL,
  `locationSpecialty` varchar(255) NOT NULL,
  `locationWard` varchar(255) NOT NULL,
  `locationRoomNumber` varchar(255) NOT NULL,
  `locationBedNumber` varchar(255) NOT NULL,
  `statusPtStatus` varchar(255) NOT NULL,
  `statusAdmDate` varchar(255) NOT NULL,
  `statusAdmTime` varchar(255) NOT NULL,
  `statusDcDate` varchar(255) NOT NULL,
  `statusDcTime` varchar(255) NOT NULL,
  `statusDcNotes` varchar(255) NOT NULL,
  `notesAuthorization` varchar(255) NOT NULL,
  `notesReminderNotes` varchar(255) NOT NULL,
  `notesEquipment` varchar(255) NOT NULL,
  `notesFacility` varchar(255) NOT NULL,
  `notesStaff` varchar(255) NOT NULL,
  PRIMARY KEY (`admDetailsAdmId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `apt`
--

DROP TABLE IF EXISTS `apt`;
CREATE TABLE `apt` (
  `aptDetailsAptId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ptInfoUniqueId` int(10) unsigned NOT NULL,
  `ptInfoNewPt` varchar(255) NOT NULL,
  `ptInfoCurrentIns` varchar(255) NOT NULL,
  `ptInfoAptNum` varchar(255) NOT NULL,
  `clinicServiceLocation` varchar(255) NOT NULL,
  `clinicMd` varchar(255) NOT NULL,
  `aptDetailsStartDate` varchar(255) NOT NULL,
  `aptDetailsStartTime` varchar(255) NOT NULL,
  `aptDetailsLength` varchar(255) NOT NULL,
  `aptDetailsAptType` varchar(255) NOT NULL,
  `aptDetailsReason` varchar(255) NOT NULL,
  `statusPtStatus` varchar(255) NOT NULL,
  `statusCheckInDate` varchar(255) NOT NULL,
  `statusCheckInTime` varchar(255) NOT NULL,
  `statusCheckOutDate` varchar(255) NOT NULL,
  `statusCheckOutTime` varchar(255) NOT NULL,
  `statusStatusNotes` varchar(255) NOT NULL,
  `notesAuthorization` varchar(255) NOT NULL,
  `notesReminderNotes` varchar(255) NOT NULL,
  `notesEquipment` varchar(255) NOT NULL,
  `notesFacility` varchar(255) NOT NULL,
  `notesStaff` varchar(255) NOT NULL,
  PRIMARY KEY (`aptDetailsAptId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `insurance`
--

DROP TABLE IF EXISTS `insurance`;
CREATE TABLE `insurance` (
  `insurance_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `insurance_name` varchar(50) NOT NULL,
  PRIMARY KEY (`insurance_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `insurance`
--

INSERT INTO `insurance` (`insurance_id`, `insurance_name`) VALUES
(1, 'CIGNA'),
(2, 'Blue Cross Blue Shield Association'),
(3, 'AETNA'),
(4, 'AARP'),
(5, 'American National Insurance Company'),
(6, 'Coventry Health Care'),
(7, 'Fortis'),
(8, 'Health Net'),
(9, 'HealthPartners'),
(10, 'Humana'),
(11, 'Highmark'),
(12, 'Kaiser Permanente'),
(13, 'Molina Healthcare'),
(14, 'Medical Mutual of Ohio'),
(15, 'Golden Rule Insurance Company'),
(16, 'Assurant'),
(17, 'Unitrin'),
(18, 'UnitedHealth Group'),
(19, 'WellPoint');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `location_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_desc` varchar(50) NOT NULL,
  `location_abbr` varchar(6) NOT NULL,
  `location_type` varchar(1) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location_desc`, `location_abbr`, `location_type`) VALUES
(1, 'Family Clinic', 'FC', 'C'),
(2, 'Emergency', 'ER', 'W'),
(3, 'Cardiac', 'CAR', 'W'),
(4, 'Mental Health', 'MHC', 'C'),
(5, 'Women''s Health', 'WHC', 'C'),
(6, 'General Medicine', 'GMC', 'C'),
(7, 'Med-Surg', 'SUR', 'W'),
(8, 'Icu', 'ICU', 'W'),
(9, 'Neuro', 'NEU', 'W'),
(10, 'Ob/Gyn', 'OB', 'W'),
(11, 'Oncology', 'ONC', 'W'),
(12, 'Orthopaedic', 'ORT', 'W'),
(13, 'Pediatric', 'PED', 'W'),
(14, 'Home Care', 'HCC', 'C'),
(15, 'Pediatric', 'PC', 'C'),
(16, 'Urgent Care/Er', 'UER', 'C'),
(17, 'Specialty Care', 'SCC', 'C'),
(18, 'Psychiatric', 'PSY', 'W'),
(19, 'Nicu', 'NIC', 'W'),
(20, 'Rehab', 'REH', 'W'),
(21, 'Long Term Care', 'LTC', 'W'),
(22, 'Palliative Care', 'PAL', 'W'),
(23, 'Inpatient Unit', 'INP', 'W'),
(24, 'Sandbox Inpt', 'SAN', 'W'),
(25, 'Restricted Inpt', 'RES', 'W'),
(26, 'Portfolio Inpt', 'POR', 'W'),
(27, 'Physical Therapy', 'PT', 'C'),
(28, 'Occupational Therapy', 'OT', 'C'),
(29, 'Radiology', 'RAD', 'C'),
(30, 'Outpatient Clinic', 'OUT', 'C'),
(31, 'Morgue', 'MOR', 'C'),
(32, 'Sandbox Outpt', 'OSA', 'C'),
(33, 'Restricted Outpt', 'ORE', 'C'),
(34, 'Portfolio Outpt', 'OPO', 'C');

-- --------------------------------------------------------

--
-- Table structure for table `marital_status`
--

DROP TABLE IF EXISTS `marital_status`;
CREATE TABLE `marital_status` (
  `marital_status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `marital_status_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`marital_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `marital_status`
--

INSERT INTO `marital_status` (`marital_status_id`, `marital_status_desc`) VALUES
(1, 'Divorced'),
(2, 'Married'),
(3, 'Widow/Widower'),
(4, 'Separated'),
(5, 'Never Married'),
(6, 'Unknown');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE `patient` (
  `patient_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `sex_id` int(10) unsigned NOT NULL,
  `ssn` varchar(9) NOT NULL,
  `address1` varchar(100) NOT NULL,
  `address2` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` varchar(9) NOT NULL,
  `hphone` varchar(10) NOT NULL,
  `wphone` varchar(10) NOT NULL,
  `cphone` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `marital_status_id` int(10) unsigned NOT NULL,
  `comments` text NOT NULL,
  `ec_fullname` varchar(100) NOT NULL,
  `ec_mphone` varchar(10) NOT NULL,
  `ec_full_address` varchar(255) NOT NULL,
  `primary_care_provider_id` int(10) unsigned NOT NULL,
  `referring_provider_id` int(10) unsigned NOT NULL,
  `rendering_provider_id` int(10) unsigned NOT NULL,
  `service_location_id` int(10) unsigned NOT NULL,
  `guarantor_name` varchar(100) NOT NULL,
  `guarantor_relationship_id` int(10) unsigned NOT NULL,
  `guarantor_address1` varchar(100) NOT NULL,
  `guarantor_address2` varchar(100) NOT NULL,
  `guarantor_city` varchar(50) NOT NULL,
  `guarantor_state` varchar(2) NOT NULL,
  `guarantor_zip` varchar(9) NOT NULL,
  `insurance1_id` int(10) unsigned NOT NULL,
  `insurance1_relationship_id` int(10) unsigned NOT NULL,
  `insurance1_group_number` varchar(50) NOT NULL,
  `insurance1_effective_date` date NOT NULL,
  `insurance1_expiration_date` date NOT NULL,
  `insurance1_policy_number` varchar(50) NOT NULL,
  `insurance1_plan_name` varchar(50) NOT NULL,
  `insurance1_active` int(10) unsigned NOT NULL,
  `insurance1_verified` int(10) unsigned NOT NULL,
  `insurance1_fname` varchar(50) NOT NULL,
  `insurance1_lname` varchar(50) NOT NULL,
  `insurance1_sex_id` int(10) unsigned NOT NULL,
  `insurance1_dob` date NOT NULL,
  `insurance1_ssn` varchar(9) NOT NULL,
  `insurance1_hphone` varchar(9) NOT NULL,
  `insurance1_address1` varchar(100) NOT NULL,
  `insurance1_address2` varchar(100) NOT NULL,
  `insurance1_city` varchar(50) NOT NULL,
  `insurance1_state` varchar(2) NOT NULL,
  `insurance1_zip` varchar(9) NOT NULL,
  `insurance2_id` int(10) unsigned NOT NULL,
  `insurance2_relationship_id` int(10) unsigned NOT NULL,
  `insurance2_group_number` varchar(50) NOT NULL,
  `insurance2_effective_date` date NOT NULL,
  `insurance2_expiration_date` date NOT NULL,
  `insurance2_policy_number` varchar(50) NOT NULL,
  `insurance2_plan_name` varchar(50) NOT NULL,
  `insurance2_active` int(10) unsigned NOT NULL,
  `insurance2_verified` int(10) unsigned NOT NULL,
  `insurance2_fname` varchar(50) NOT NULL,
  `insurance2_lname` varchar(50) NOT NULL,
  `insurance2_sex_id` int(10) unsigned NOT NULL,
  `insurance2_dob` date NOT NULL,
  `insurance2_ssn` varchar(9) NOT NULL,
  `insurance2_hphone` varchar(9) NOT NULL,
  `insurance2_address1` varchar(100) NOT NULL,
  `insurance2_address2` varchar(100) NOT NULL,
  `insurance2_city` varchar(50) NOT NULL,
  `insurance2_state` varchar(2) NOT NULL,
  `insurance2_zip` varchar(9) NOT NULL,
  `insurance3_id` int(10) unsigned NOT NULL,
  `insurance3_relationship_id` int(10) unsigned NOT NULL,
  `insurance3_group_number` varchar(50) NOT NULL,
  `insurance3_effective_date` date NOT NULL,
  `insurance3_expiration_date` date NOT NULL,
  `insurance3_policy_number` varchar(50) NOT NULL,
  `insurance3_plan_name` varchar(50) NOT NULL,
  `insurance3_active` int(10) unsigned NOT NULL,
  `insurance3_verified` int(10) unsigned NOT NULL,
  `insurance3_fname` varchar(50) NOT NULL,
  `insurance3_lname` varchar(50) NOT NULL,
  `insurance3_sex_id` int(10) unsigned NOT NULL,
  `insurance3_dob` date NOT NULL,
  `insurance3_ssn` varchar(9) NOT NULL,
  `insurance3_hphone` varchar(9) NOT NULL,
  `insurance3_address1` varchar(100) NOT NULL,
  `insurance3_address2` varchar(100) NOT NULL,
  `insurance3_city` varchar(50) NOT NULL,
  `insurance3_state` varchar(2) NOT NULL,
  `insurance3_zip` varchar(9) NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(10) unsigned NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `fname`, `lname`, `mname`, `dob`, `sex_id`, `ssn`, `address1`, `address2`, `city`, `state`, `zip`, `hphone`, `wphone`, `cphone`, `email`, `nationality`, `marital_status_id`, `comments`, `ec_fullname`, `ec_mphone`, `ec_full_address`, `primary_care_provider_id`, `referring_provider_id`, `rendering_provider_id`, `service_location_id`, `guarantor_name`, `guarantor_relationship_id`, `guarantor_address1`, `guarantor_address2`, `guarantor_city`, `guarantor_state`, `guarantor_zip`, `insurance1_id`, `insurance1_relationship_id`, `insurance1_group_number`, `insurance1_effective_date`, `insurance1_expiration_date`, `insurance1_policy_number`, `insurance1_plan_name`, `insurance1_active`, `insurance1_verified`, `insurance1_fname`, `insurance1_lname`, `insurance1_sex_id`, `insurance1_dob`, `insurance1_ssn`, `insurance1_hphone`, `insurance1_address1`, `insurance1_address2`, `insurance1_city`, `insurance1_state`, `insurance1_zip`, `insurance2_id`, `insurance2_relationship_id`, `insurance2_group_number`, `insurance2_effective_date`, `insurance2_expiration_date`, `insurance2_policy_number`, `insurance2_plan_name`, `insurance2_active`, `insurance2_verified`, `insurance2_fname`, `insurance2_lname`, `insurance2_sex_id`, `insurance2_dob`, `insurance2_ssn`, `insurance2_hphone`, `insurance2_address1`, `insurance2_address2`, `insurance2_city`, `insurance2_state`, `insurance2_zip`, `insurance3_id`, `insurance3_relationship_id`, `insurance3_group_number`, `insurance3_effective_date`, `insurance3_expiration_date`, `insurance3_policy_number`, `insurance3_plan_name`, `insurance3_active`, `insurance3_verified`, `insurance3_fname`, `insurance3_lname`, `insurance3_sex_id`, `insurance3_dob`, `insurance3_ssn`, `insurance3_hphone`, `insurance3_address1`, `insurance3_address2`, `insurance3_city`, `insurance3_state`, `insurance3_zip`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 'Johnny', 'Appleseed', '', '1994-03-04', 2, '999999999', '123 Main Street', 'Suite 200', 'Hopkins', 'MN', '55426', '9525551212', '', '', '', '', 2, '', '', '', '', 0, 0, 0, 0, '', 0, '', '', '', '', '', 0, 0, '', '1969-12-31', '1969-12-31', '', '', 0, 0, '', '', 0, '1969-12-31', '', '', '', '', '', '', '', 0, 0, '', '1969-12-31', '1969-12-31', '', '', 0, 0, '', '', 0, '1969-12-31', '', '', '', '', '', '', '', 0, 0, '', '1969-12-31', '1969-12-31', '', '', 0, 0, '', '', 0, '1969-12-31', '', '', '', '', '', '', '', 1, '2012-03-22 11:03:30', 1, '2012-03-22 11:04:18'),
(2, 'Jimmy', 'John', '', '1976-03-20', 2, '999999998', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', 0, 0, 0, 0, '', 0, '', '', '', '', '', 0, 0, '', '0000-00-00', '0000-00-00', '', '', 0, 0, '', '', 0, '0000-00-00', '', '', '', '', '', '', '', 0, 0, '', '0000-00-00', '0000-00-00', '', '', 0, 0, '', '', 0, '0000-00-00', '', '', '', '', '', '', '', 0, 0, '', '0000-00-00', '0000-00-00', '', '', 0, 0, '', '', 0, '0000-00-00', '', '', '', '', '', '', '', 18846, '2012-03-24 21:33:48', 18846, '2012-03-24 21:33:48'),
(3, 'Adam', 'Smith', '', '2001-05-05', 3, '999999997', '4701 Wedgewood Drive', '', 'Minnetonka', 'MA', '55345', '6125551212', '', '', '', '', 2, '', '', '', '', 0, 0, 0, 0, '', 0, '', '', '', '', '', 0, 0, '', '1969-12-31', '1969-12-31', '', '', 0, 0, '', '', 0, '1969-12-31', '', '', '', '', '', '', '', 0, 0, '', '1969-12-31', '1969-12-31', '', '', 0, 0, '', '', 0, '1969-12-31', '', '', '', '', '', '', '', 0, 0, '', '1969-12-31', '1969-12-31', '', '', 0, 0, '', '', 0, '1969-12-31', '', '', '', '', '', '', '', 18846, '2012-03-25 15:00:44', 18846, '2012-03-26 11:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `patient_submission`
--

DROP TABLE IF EXISTS `patient_submission`;
CREATE TABLE `patient_submission` (
  `patient_submission_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` int(10) unsigned NOT NULL,
  `patient_id` int(10) unsigned NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `sex_id` int(10) unsigned NOT NULL,
  `ssn` varchar(9) NOT NULL,
  `address1` varchar(100) NOT NULL,
  `address2` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` varchar(9) NOT NULL,
  `hphone` varchar(10) NOT NULL,
  `wphone` varchar(10) NOT NULL,
  `cphone` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `marital_status_id` int(10) unsigned NOT NULL,
  `comments` text NOT NULL,
  `ec_fullname` varchar(100) NOT NULL,
  `ec_mphone` varchar(10) NOT NULL,
  `ec_full_address` varchar(255) NOT NULL,
  `primary_care_provider_id` int(10) unsigned NOT NULL,
  `referring_provider_id` int(10) unsigned NOT NULL,
  `rendering_provider_id` int(10) unsigned NOT NULL,
  `service_location_id` int(10) unsigned NOT NULL,
  `guarantor_name` varchar(100) NOT NULL,
  `guarantor_relationship_id` int(10) unsigned NOT NULL,
  `guarantor_address1` varchar(100) NOT NULL,
  `guarantor_address2` varchar(100) NOT NULL,
  `guarantor_city` varchar(50) NOT NULL,
  `guarantor_state` varchar(2) NOT NULL,
  `guarantor_zip` varchar(9) NOT NULL,
  `insurance1_id` int(10) unsigned NOT NULL,
  `insurance1_relationship_id` int(10) unsigned NOT NULL,
  `insurance1_group_number` varchar(50) NOT NULL,
  `insurance1_effective_date` date NOT NULL,
  `insurance1_expiration_date` date NOT NULL,
  `insurance1_policy_number` varchar(50) NOT NULL,
  `insurance1_plan_name` varchar(50) NOT NULL,
  `insurance1_active` int(10) unsigned NOT NULL,
  `insurance1_verified` int(10) unsigned NOT NULL,
  `insurance1_fname` varchar(50) NOT NULL,
  `insurance1_lname` varchar(50) NOT NULL,
  `insurance1_sex_id` int(10) unsigned NOT NULL,
  `insurance1_dob` date NOT NULL,
  `insurance1_ssn` varchar(9) NOT NULL,
  `insurance1_hphone` varchar(9) NOT NULL,
  `insurance1_address1` varchar(100) NOT NULL,
  `insurance1_address2` varchar(100) NOT NULL,
  `insurance1_city` varchar(50) NOT NULL,
  `insurance1_state` varchar(2) NOT NULL,
  `insurance1_zip` varchar(9) NOT NULL,
  `insurance2_id` int(10) unsigned NOT NULL,
  `insurance2_relationship_id` int(10) unsigned NOT NULL,
  `insurance2_group_number` varchar(50) NOT NULL,
  `insurance2_effective_date` date NOT NULL,
  `insurance2_expiration_date` date NOT NULL,
  `insurance2_policy_number` varchar(50) NOT NULL,
  `insurance2_plan_name` varchar(50) NOT NULL,
  `insurance2_active` int(10) unsigned NOT NULL,
  `insurance2_verified` int(10) unsigned NOT NULL,
  `insurance2_fname` varchar(50) NOT NULL,
  `insurance2_lname` varchar(50) NOT NULL,
  `insurance2_sex_id` int(10) unsigned NOT NULL,
  `insurance2_dob` date NOT NULL,
  `insurance2_ssn` varchar(9) NOT NULL,
  `insurance2_hphone` varchar(9) NOT NULL,
  `insurance2_address1` varchar(100) NOT NULL,
  `insurance2_address2` varchar(100) NOT NULL,
  `insurance2_city` varchar(50) NOT NULL,
  `insurance2_state` varchar(2) NOT NULL,
  `insurance2_zip` varchar(9) NOT NULL,
  `insurance3_id` int(10) unsigned NOT NULL,
  `insurance3_relationship_id` int(10) unsigned NOT NULL,
  `insurance3_group_number` varchar(50) NOT NULL,
  `insurance3_effective_date` date NOT NULL,
  `insurance3_expiration_date` date NOT NULL,
  `insurance3_policy_number` varchar(50) NOT NULL,
  `insurance3_plan_name` varchar(50) NOT NULL,
  `insurance3_active` int(10) unsigned NOT NULL,
  `insurance3_verified` int(10) unsigned NOT NULL,
  `insurance3_fname` varchar(50) NOT NULL,
  `insurance3_lname` varchar(50) NOT NULL,
  `insurance3_sex_id` int(10) unsigned NOT NULL,
  `insurance3_dob` date NOT NULL,
  `insurance3_ssn` varchar(9) NOT NULL,
  `insurance3_hphone` varchar(9) NOT NULL,
  `insurance3_address1` varchar(100) NOT NULL,
  `insurance3_address2` varchar(100) NOT NULL,
  `insurance3_city` varchar(50) NOT NULL,
  `insurance3_state` varchar(2) NOT NULL,
  `insurance3_zip` varchar(9) NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(10) unsigned NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`patient_submission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `patient_submission`
--

INSERT INTO `patient_submission` (`patient_submission_id`, `submission_id`, `patient_id`, `fname`, `lname`, `mname`, `dob`, `sex_id`, `ssn`, `address1`, `address2`, `city`, `state`, `zip`, `hphone`, `wphone`, `cphone`, `email`, `nationality`, `marital_status_id`, `comments`, `ec_fullname`, `ec_mphone`, `ec_full_address`, `primary_care_provider_id`, `referring_provider_id`, `rendering_provider_id`, `service_location_id`, `guarantor_name`, `guarantor_relationship_id`, `guarantor_address1`, `guarantor_address2`, `guarantor_city`, `guarantor_state`, `guarantor_zip`, `insurance1_id`, `insurance1_relationship_id`, `insurance1_group_number`, `insurance1_effective_date`, `insurance1_expiration_date`, `insurance1_policy_number`, `insurance1_plan_name`, `insurance1_active`, `insurance1_verified`, `insurance1_fname`, `insurance1_lname`, `insurance1_sex_id`, `insurance1_dob`, `insurance1_ssn`, `insurance1_hphone`, `insurance1_address1`, `insurance1_address2`, `insurance1_city`, `insurance1_state`, `insurance1_zip`, `insurance2_id`, `insurance2_relationship_id`, `insurance2_group_number`, `insurance2_effective_date`, `insurance2_expiration_date`, `insurance2_policy_number`, `insurance2_plan_name`, `insurance2_active`, `insurance2_verified`, `insurance2_fname`, `insurance2_lname`, `insurance2_sex_id`, `insurance2_dob`, `insurance2_ssn`, `insurance2_hphone`, `insurance2_address1`, `insurance2_address2`, `insurance2_city`, `insurance2_state`, `insurance2_zip`, `insurance3_id`, `insurance3_relationship_id`, `insurance3_group_number`, `insurance3_effective_date`, `insurance3_expiration_date`, `insurance3_policy_number`, `insurance3_plan_name`, `insurance3_active`, `insurance3_verified`, `insurance3_fname`, `insurance3_lname`, `insurance3_sex_id`, `insurance3_dob`, `insurance3_ssn`, `insurance3_hphone`, `insurance3_address1`, `insurance3_address2`, `insurance3_city`, `insurance3_state`, `insurance3_zip`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 1, 2, 'Jimmy', 'John', '', '1976-03-20', 2, '999999998', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', 0, 0, 0, 0, '', 0, '', '', '', '', '', 0, 0, '', '0000-00-00', '0000-00-00', '', '', 0, 0, '', '', 0, '0000-00-00', '', '', '', '', '', '', '', 0, 0, '', '0000-00-00', '0000-00-00', '', '', 0, 0, '', '', 0, '0000-00-00', '', '', '', '', '', '', '', 0, 0, '', '0000-00-00', '0000-00-00', '', '', 0, 0, '', '', 0, '0000-00-00', '', '', '', '', '', '', '', 18846, '2012-03-24 21:33:48', 18846, '2012-03-24 21:33:48'),
(2, 2, 3, 'Adam', 'Smith', '', '2001-05-05', 2, '999999997', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', 0, 0, 0, 0, '', 0, '', '', '', '', '', 0, 0, '', '0000-00-00', '0000-00-00', '', '', 0, 0, '', '', 0, '0000-00-00', '', '', '', '', '', '', '', 0, 0, '', '0000-00-00', '0000-00-00', '', '', 0, 0, '', '', 0, '0000-00-00', '', '', '', '', '', '', '', 0, 0, '', '0000-00-00', '0000-00-00', '', '', 0, 0, '', '', 0, '0000-00-00', '', '', '', '', '', '', '', 18846, '2012-03-25 15:00:44', 18846, '2012-03-25 15:00:44'),
(3, 3, 3, 'Adam', 'Smith', '', '2001-05-05', 3, '999999997', '4701 Wedgewood Drive', '', 'Minnetonka', 'MA', '55345', '6125551212', '', '', '', '', 2, '', '', '', '', 0, 0, 0, 0, '', 0, '', '', '', '', '', 0, 0, '', '1969-12-31', '1969-12-31', '', '', 0, 0, '', '', 0, '1969-12-31', '', '', '', '', '', '', '', 0, 0, '', '1969-12-31', '1969-12-31', '', '', 0, 0, '', '', 0, '1969-12-31', '', '', '', '', '', '', '', 0, 0, '', '1969-12-31', '1969-12-31', '', '', 0, 0, '', '', 0, '1969-12-31', '', '', '', '', '', '', '', 18846, '2012-03-25 15:00:44', 18846, '2012-03-26 11:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `pt`
--

DROP TABLE IF EXISTS `pt`;
CREATE TABLE `pt` (
  `ptUniqueId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ptFirstName` varchar(255) NOT NULL,
  `ptLastName` varchar(255) NOT NULL,
  `ptMiddleName` varchar(255) NOT NULL,
  `ptSuffix` varchar(255) NOT NULL,
  `ptDateOfBirth` varchar(255) NOT NULL,
  `ptAge` varchar(255) NOT NULL,
  `ptSex` varchar(255) NOT NULL,
  `ptAliases` varchar(255) NOT NULL,
  `ptSocialSecurity` varchar(255) NOT NULL,
  `ptMaritalStatus` varchar(255) NOT NULL,
  `ptNationality` varchar(255) NOT NULL,
  `ptStreetAddress` varchar(255) NOT NULL,
  `ptApptNum` varchar(255) NOT NULL,
  `ptCity` varchar(255) NOT NULL,
  `ptState` varchar(255) NOT NULL,
  `ptZip` varchar(255) NOT NULL,
  `ptHomePhone` varchar(255) NOT NULL,
  `ptWorkPhone` varchar(255) NOT NULL,
  `ptCellPhone` varchar(255) NOT NULL,
  `ptEmail` varchar(255) NOT NULL,
  `ptOccupation` varchar(255) NOT NULL,
  `ptEmployer` varchar(255) NOT NULL,
  `ptEmployerPhone` varchar(255) NOT NULL,
  `ptComment` varchar(255) NOT NULL,
  `ptEContactUniqueId` varchar(255) NOT NULL,
  `ptEContactFirstName` varchar(255) NOT NULL,
  `ptEContactLastName` varchar(255) NOT NULL,
  `ptEContactSuffix` varchar(255) NOT NULL,
  `ptEContactPhoneNumber` varchar(255) NOT NULL,
  `ptEContactAddress` varchar(255) NOT NULL,
  `pgP1UniqueId` varchar(255) NOT NULL,
  `pgP1FirstName` varchar(255) NOT NULL,
  `pgP1LastName` varchar(255) NOT NULL,
  `pgP1Suffix` varchar(255) NOT NULL,
  `pgP1Relationship` varchar(255) NOT NULL,
  `pgP1StreetAddress` varchar(255) NOT NULL,
  `pgP1ApptNum` varchar(255) NOT NULL,
  `pgP1City` varchar(255) NOT NULL,
  `pgP1State` varchar(255) NOT NULL,
  `pgP1Zip` varchar(255) NOT NULL,
  `pgP2UniqueId` varchar(255) NOT NULL,
  `pgP2FirstName` varchar(255) NOT NULL,
  `pgP2LastName` varchar(255) NOT NULL,
  `pgP2Suffix` varchar(255) NOT NULL,
  `pgP2Relationship` varchar(255) NOT NULL,
  `pgP2StreetAddress` varchar(255) NOT NULL,
  `pgP2ApptNum` varchar(255) NOT NULL,
  `pgP2City` varchar(255) NOT NULL,
  `pgP2State` varchar(255) NOT NULL,
  `pgP2Zip` varchar(255) NOT NULL,
  `mdPrimary` varchar(255) NOT NULL,
  `mdReferring` varchar(255) NOT NULL,
  `mdRendering` varchar(255) NOT NULL,
  `mdServiceLocation` varchar(255) NOT NULL,
  `mdProviderSocSec` varchar(255) NOT NULL,
  `grRelationship` varchar(255) NOT NULL,
  `grUniqueId` varchar(255) NOT NULL,
  `grFirstName` varchar(255) NOT NULL,
  `grLastName` varchar(255) NOT NULL,
  `grSuffix` varchar(255) NOT NULL,
  `grStreetAddress` varchar(255) NOT NULL,
  `grApptNum` varchar(255) NOT NULL,
  `grCity` varchar(255) NOT NULL,
  `grState` varchar(255) NOT NULL,
  `grZip` varchar(255) NOT NULL,
  `insPrimaryComp` varchar(255) NOT NULL,
  `insPrimaryRelationship` varchar(255) NOT NULL,
  `insPrimaryGroupNumber` varchar(255) NOT NULL,
  `insPrimaryPolicyNumber` varchar(255) NOT NULL,
  `insPrimaryPlanName` varchar(255) NOT NULL,
  `insPrimaryEffectiveDate` varchar(255) NOT NULL,
  `insPrimaryEffYearDeviation` varchar(255) NOT NULL,
  `insPrimaryExpirationDate` varchar(255) NOT NULL,
  `insPrimaryExpYearDeviation` varchar(255) NOT NULL,
  `insPrimaryActive` varchar(255) NOT NULL,
  `insPrimaryVerified` varchar(255) NOT NULL,
  `insPrimaryNotSelfUniqueId` varchar(255) NOT NULL,
  `insPrimaryNotSelfFirstName` varchar(255) NOT NULL,
  `insPrimaryNotSelfLastName` varchar(255) NOT NULL,
  `insPrimaryNotSelfSuffix` varchar(255) NOT NULL,
  `insPrimaryNotSelfSex` varchar(255) NOT NULL,
  `insPrimaryNotSelfDateOfBirth` varchar(255) NOT NULL,
  `insPrimaryNotSelfSocialSecNumb` varchar(255) NOT NULL,
  `insPrimaryNotSelfHomePhone` varchar(255) NOT NULL,
  `insPrimaryNotSelfStreetAddress` varchar(255) NOT NULL,
  `insPrimaryNotSelfApptNum` varchar(255) NOT NULL,
  `insPrimaryNotSelfCity` varchar(255) NOT NULL,
  `insPrimaryNotSelfState` varchar(255) NOT NULL,
  `insPrimaryNotSelfZip` varchar(255) NOT NULL,
  `insSecondaryComp` varchar(255) NOT NULL,
  `insSecondaryRelationship` varchar(255) NOT NULL,
  `insSecondaryGroupNumber` varchar(255) NOT NULL,
  `insSecondaryPolicyNumber` varchar(255) NOT NULL,
  `insSecondaryPlanName` varchar(255) NOT NULL,
  `insSecondaryEffectiveDate` varchar(255) NOT NULL,
  `insSecondaryEffYearDeviation` varchar(255) NOT NULL,
  `insSecondaryExpirationDate` varchar(255) NOT NULL,
  `insSecondaryExpYearDeviation` varchar(255) NOT NULL,
  `insSecondaryActive` varchar(255) NOT NULL,
  `insSecondaryVerified` varchar(255) NOT NULL,
  `insSecondaryNotSelfUniqueId` varchar(255) NOT NULL,
  `insSecondaryNotSelfFirstName` varchar(255) NOT NULL,
  `insSecondaryNotSelfLastName` varchar(255) NOT NULL,
  `insSecondaryNotSelfSuffix` varchar(255) NOT NULL,
  `insSecondaryNotSelfSex` varchar(255) NOT NULL,
  `insSecondaryNotSelfDateOfBirth` varchar(255) NOT NULL,
  `insSecondaryNotSelfSocialSecNumb` varchar(255) NOT NULL,
  `insSecondaryNotSelfHomePhone` varchar(255) NOT NULL,
  `insSecondaryNotSelfStreetAddress` varchar(255) NOT NULL,
  `insSecondaryNotSelfApptNum` varchar(255) NOT NULL,
  `insSecondaryNotSelfCity` varchar(255) NOT NULL,
  `insSecondaryNotSelfState` varchar(255) NOT NULL,
  `insSecondaryNotSelfZip` varchar(255) NOT NULL,
  `insTertiaryComp` varchar(255) NOT NULL,
  `insTertiaryRelationship` varchar(255) NOT NULL,
  `insTertiaryGroupNumber` varchar(255) NOT NULL,
  `insTertiaryPolicyNumber` varchar(255) NOT NULL,
  `insTertiaryPlanName` varchar(255) NOT NULL,
  `insTertiaryEffectiveDate` varchar(255) NOT NULL,
  `insTertiaryEffYearDeviation` varchar(255) NOT NULL,
  `insTertiaryExpirationDate` varchar(255) NOT NULL,
  `insTertiaryExpYearDeviation` varchar(255) NOT NULL,
  `insTertiaryActive` varchar(255) NOT NULL,
  `insTertiaryVerified` varchar(255) NOT NULL,
  `insTertiaryNotSelfUniqueId` varchar(255) NOT NULL,
  `insTertiaryNotSelfFirstName` varchar(255) NOT NULL,
  `insTertiaryNotSelfLastName` varchar(255) NOT NULL,
  `insTertiaryNotSelfSuffix` varchar(255) NOT NULL,
  `insTertiaryNotSelfSex` varchar(255) NOT NULL,
  `insTertiaryNotSelfDateOfBirth` varchar(255) NOT NULL,
  `insTertiaryNotSelfSocialSecNumb` varchar(255) NOT NULL,
  `insTertiaryNotSelfHomePhone` varchar(255) NOT NULL,
  `insTertiaryNotSelfStreetAddress` varchar(255) NOT NULL,
  `insTertiaryNotSelfApptNum` varchar(255) NOT NULL,
  `insTertiaryNotSelfCity` varchar(255) NOT NULL,
  `insTertiaryNotSelfState` varchar(255) NOT NULL,
  `insTertiaryNotSelfZip` varchar(255) NOT NULL,
  `createdBy` int(10) unsigned NOT NULL,
  `createdDate` datetime NOT NULL,
  `modifiedBy` int(10) unsigned NOT NULL,
  `modifiedDate` datetime NOT NULL,
  PRIMARY KEY (`ptUniqueId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pt_submission`
--

DROP TABLE IF EXISTS `pt_submission`;
CREATE TABLE `pt_submission` (
  `ptSubmissionId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ptUniqueId` int(10) unsigned NOT NULL,
  `ptFirstName` varchar(255) NOT NULL,
  `ptLastName` varchar(255) NOT NULL,
  `ptMiddleName` varchar(255) NOT NULL,
  `ptSuffix` varchar(255) NOT NULL,
  `ptDateOfBirth` varchar(255) NOT NULL,
  `ptAge` varchar(255) NOT NULL,
  `ptSex` varchar(255) NOT NULL,
  `ptAliases` varchar(255) NOT NULL,
  `ptSocialSecurity` varchar(255) NOT NULL,
  `ptMaritalStatus` varchar(255) NOT NULL,
  `ptNationality` varchar(255) NOT NULL,
  `ptStreetAddress` varchar(255) NOT NULL,
  `ptApptNum` varchar(255) NOT NULL,
  `ptCity` varchar(255) NOT NULL,
  `ptState` varchar(255) NOT NULL,
  `ptZip` varchar(255) NOT NULL,
  `ptHomePhone` varchar(255) NOT NULL,
  `ptWorkPhone` varchar(255) NOT NULL,
  `ptCellPhone` varchar(255) NOT NULL,
  `ptEmail` varchar(255) NOT NULL,
  `ptOccupation` varchar(255) NOT NULL,
  `ptEmployer` varchar(255) NOT NULL,
  `ptEmployerPhone` varchar(255) NOT NULL,
  `ptComment` varchar(255) NOT NULL,
  `ptEContactUniqueId` varchar(255) NOT NULL,
  `ptEContactFirstName` varchar(255) NOT NULL,
  `ptEContactLastName` varchar(255) NOT NULL,
  `ptEContactSuffix` varchar(255) NOT NULL,
  `ptEContactPhoneNumber` varchar(255) NOT NULL,
  `ptEContactAddress` varchar(255) NOT NULL,
  `pgP1UniqueId` varchar(255) NOT NULL,
  `pgP1FirstName` varchar(255) NOT NULL,
  `pgP1LastName` varchar(255) NOT NULL,
  `pgP1Suffix` varchar(255) NOT NULL,
  `pgP1Relationship` varchar(255) NOT NULL,
  `pgP1StreetAddress` varchar(255) NOT NULL,
  `pgP1ApptNum` varchar(255) NOT NULL,
  `pgP1City` varchar(255) NOT NULL,
  `pgP1State` varchar(255) NOT NULL,
  `pgP1Zip` varchar(255) NOT NULL,
  `pgP2UniqueId` varchar(255) NOT NULL,
  `pgP2FirstName` varchar(255) NOT NULL,
  `pgP2LastName` varchar(255) NOT NULL,
  `pgP2Suffix` varchar(255) NOT NULL,
  `pgP2Relationship` varchar(255) NOT NULL,
  `pgP2StreetAddress` varchar(255) NOT NULL,
  `pgP2ApptNum` varchar(255) NOT NULL,
  `pgP2City` varchar(255) NOT NULL,
  `pgP2State` varchar(255) NOT NULL,
  `pgP2Zip` varchar(255) NOT NULL,
  `mdPrimary` varchar(255) NOT NULL,
  `mdReferring` varchar(255) NOT NULL,
  `mdRendering` varchar(255) NOT NULL,
  `mdServiceLocation` varchar(255) NOT NULL,
  `mdProviderSocSec` varchar(255) NOT NULL,
  `grRelationship` varchar(255) NOT NULL,
  `grUniqueId` varchar(255) NOT NULL,
  `grFirstName` varchar(255) NOT NULL,
  `grLastName` varchar(255) NOT NULL,
  `grSuffix` varchar(255) NOT NULL,
  `grStreetAddress` varchar(255) NOT NULL,
  `grApptNum` varchar(255) NOT NULL,
  `grCity` varchar(255) NOT NULL,
  `grState` varchar(255) NOT NULL,
  `grZip` varchar(255) NOT NULL,
  `insPrimaryComp` varchar(255) NOT NULL,
  `insPrimaryRelationship` varchar(255) NOT NULL,
  `insPrimaryGroupNumber` varchar(255) NOT NULL,
  `insPrimaryPolicyNumber` varchar(255) NOT NULL,
  `insPrimaryPlanName` varchar(255) NOT NULL,
  `insPrimaryEffectiveDate` varchar(255) NOT NULL,
  `insPrimaryEffYearDeviation` varchar(255) NOT NULL,
  `insPrimaryExpirationDate` varchar(255) NOT NULL,
  `insPrimaryExpYearDeviation` varchar(255) NOT NULL,
  `insPrimaryActive` varchar(255) NOT NULL,
  `insPrimaryVerified` varchar(255) NOT NULL,
  `insPrimaryNotSelfUniqueId` varchar(255) NOT NULL,
  `insPrimaryNotSelfFirstName` varchar(255) NOT NULL,
  `insPrimaryNotSelfLastName` varchar(255) NOT NULL,
  `insPrimaryNotSelfSuffix` varchar(255) NOT NULL,
  `insPrimaryNotSelfSex` varchar(255) NOT NULL,
  `insPrimaryNotSelfDateOfBirth` varchar(255) NOT NULL,
  `insPrimaryNotSelfSocialSecNumb` varchar(255) NOT NULL,
  `insPrimaryNotSelfHomePhone` varchar(255) NOT NULL,
  `insPrimaryNotSelfStreetAddress` varchar(255) NOT NULL,
  `insPrimaryNotSelfApptNum` varchar(255) NOT NULL,
  `insPrimaryNotSelfCity` varchar(255) NOT NULL,
  `insPrimaryNotSelfState` varchar(255) NOT NULL,
  `insPrimaryNotSelfZip` varchar(255) NOT NULL,
  `insSecondaryComp` varchar(255) NOT NULL,
  `insSecondaryRelationship` varchar(255) NOT NULL,
  `insSecondaryGroupNumber` varchar(255) NOT NULL,
  `insSecondaryPolicyNumber` varchar(255) NOT NULL,
  `insSecondaryPlanName` varchar(255) NOT NULL,
  `insSecondaryEffectiveDate` varchar(255) NOT NULL,
  `insSecondaryEffYearDeviation` varchar(255) NOT NULL,
  `insSecondaryExpirationDate` varchar(255) NOT NULL,
  `insSecondaryExpYearDeviation` varchar(255) NOT NULL,
  `insSecondaryActive` varchar(255) NOT NULL,
  `insSecondaryVerified` varchar(255) NOT NULL,
  `insSecondaryNotSelfUniqueId` varchar(255) NOT NULL,
  `insSecondaryNotSelfFirstName` varchar(255) NOT NULL,
  `insSecondaryNotSelfLastName` varchar(255) NOT NULL,
  `insSecondaryNotSelfSuffix` varchar(255) NOT NULL,
  `insSecondaryNotSelfSex` varchar(255) NOT NULL,
  `insSecondaryNotSelfDateOfBirth` varchar(255) NOT NULL,
  `insSecondaryNotSelfSocialSecNumb` varchar(255) NOT NULL,
  `insSecondaryNotSelfHomePhone` varchar(255) NOT NULL,
  `insSecondaryNotSelfStreetAddress` varchar(255) NOT NULL,
  `insSecondaryNotSelfApptNum` varchar(255) NOT NULL,
  `insSecondaryNotSelfCity` varchar(255) NOT NULL,
  `insSecondaryNotSelfState` varchar(255) NOT NULL,
  `insSecondaryNotSelfZip` varchar(255) NOT NULL,
  `insTertiaryComp` varchar(255) NOT NULL,
  `insTertiaryRelationship` varchar(255) NOT NULL,
  `insTertiaryGroupNumber` varchar(255) NOT NULL,
  `insTertiaryPolicyNumber` varchar(255) NOT NULL,
  `insTertiaryPlanName` varchar(255) NOT NULL,
  `insTertiaryEffectiveDate` varchar(255) NOT NULL,
  `insTertiaryEffYearDeviation` varchar(255) NOT NULL,
  `insTertiaryExpirationDate` varchar(255) NOT NULL,
  `insTertiaryExpYearDeviation` varchar(255) NOT NULL,
  `insTertiaryActive` varchar(255) NOT NULL,
  `insTertiaryVerified` varchar(255) NOT NULL,
  `insTertiaryNotSelfUniqueId` varchar(255) NOT NULL,
  `insTertiaryNotSelfFirstName` varchar(255) NOT NULL,
  `insTertiaryNotSelfLastName` varchar(255) NOT NULL,
  `insTertiaryNotSelfSuffix` varchar(255) NOT NULL,
  `insTertiaryNotSelfSex` varchar(255) NOT NULL,
  `insTertiaryNotSelfDateOfBirth` varchar(255) NOT NULL,
  `insTertiaryNotSelfSocialSecNumb` varchar(255) NOT NULL,
  `insTertiaryNotSelfHomePhone` varchar(255) NOT NULL,
  `insTertiaryNotSelfStreetAddress` varchar(255) NOT NULL,
  `insTertiaryNotSelfApptNum` varchar(255) NOT NULL,
  `insTertiaryNotSelfCity` varchar(255) NOT NULL,
  `insTertiaryNotSelfState` varchar(255) NOT NULL,
  `insTertiaryNotSelfZip` varchar(255) NOT NULL,
  `createdBy` int(10) unsigned NOT NULL,
  `createdDate` datetime NOT NULL,
  `modifiedBy` int(10) unsigned NOT NULL,
  `modifiedDate` datetime NOT NULL,
  PRIMARY KEY (`ptSubmissionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pt_working`
--

DROP TABLE IF EXISTS `pt_working`;
CREATE TABLE `pt_working` (
  `ptWorkingId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ptUniqueId` int(10) unsigned NOT NULL,
  `ptFirstName` varchar(255) NOT NULL,
  `ptLastName` varchar(255) NOT NULL,
  `ptMiddleName` varchar(255) NOT NULL,
  `ptSuffix` varchar(255) NOT NULL,
  `ptDateOfBirth` varchar(255) NOT NULL,
  `ptAge` varchar(255) NOT NULL,
  `ptSex` varchar(255) NOT NULL,
  `ptAliases` varchar(255) NOT NULL,
  `ptSocialSecurity` varchar(255) NOT NULL,
  `ptMaritalStatus` varchar(255) NOT NULL,
  `ptNationality` varchar(255) NOT NULL,
  `ptStreetAddress` varchar(255) NOT NULL,
  `ptApptNum` varchar(255) NOT NULL,
  `ptCity` varchar(255) NOT NULL,
  `ptState` varchar(255) NOT NULL,
  `ptZip` varchar(255) NOT NULL,
  `ptHomePhone` varchar(255) NOT NULL,
  `ptWorkPhone` varchar(255) NOT NULL,
  `ptCellPhone` varchar(255) NOT NULL,
  `ptEmail` varchar(255) NOT NULL,
  `ptOccupation` varchar(255) NOT NULL,
  `ptEmployer` varchar(255) NOT NULL,
  `ptEmployerPhone` varchar(255) NOT NULL,
  `ptComment` varchar(255) NOT NULL,
  `ptEContactUniqueId` varchar(255) NOT NULL,
  `ptEContactFirstName` varchar(255) NOT NULL,
  `ptEContactLastName` varchar(255) NOT NULL,
  `ptEContactSuffix` varchar(255) NOT NULL,
  `ptEContactPhoneNumber` varchar(255) NOT NULL,
  `ptEContactAddress` varchar(255) NOT NULL,
  `pgP1UniqueId` varchar(255) NOT NULL,
  `pgP1FirstName` varchar(255) NOT NULL,
  `pgP1LastName` varchar(255) NOT NULL,
  `pgP1Suffix` varchar(255) NOT NULL,
  `pgP1Relationship` varchar(255) NOT NULL,
  `pgP1StreetAddress` varchar(255) NOT NULL,
  `pgP1ApptNum` varchar(255) NOT NULL,
  `pgP1City` varchar(255) NOT NULL,
  `pgP1State` varchar(255) NOT NULL,
  `pgP1Zip` varchar(255) NOT NULL,
  `pgP2UniqueId` varchar(255) NOT NULL,
  `pgP2FirstName` varchar(255) NOT NULL,
  `pgP2LastName` varchar(255) NOT NULL,
  `pgP2Suffix` varchar(255) NOT NULL,
  `pgP2Relationship` varchar(255) NOT NULL,
  `pgP2StreetAddress` varchar(255) NOT NULL,
  `pgP2ApptNum` varchar(255) NOT NULL,
  `pgP2City` varchar(255) NOT NULL,
  `pgP2State` varchar(255) NOT NULL,
  `pgP2Zip` varchar(255) NOT NULL,
  `mdPrimary` varchar(255) NOT NULL,
  `mdReferring` varchar(255) NOT NULL,
  `mdRendering` varchar(255) NOT NULL,
  `mdServiceLocation` varchar(255) NOT NULL,
  `mdProviderSocSec` varchar(255) NOT NULL,
  `grRelationship` varchar(255) NOT NULL,
  `grUniqueId` varchar(255) NOT NULL,
  `grFirstName` varchar(255) NOT NULL,
  `grLastName` varchar(255) NOT NULL,
  `grSuffix` varchar(255) NOT NULL,
  `grStreetAddress` varchar(255) NOT NULL,
  `grApptNum` varchar(255) NOT NULL,
  `grCity` varchar(255) NOT NULL,
  `grState` varchar(255) NOT NULL,
  `grZip` varchar(255) NOT NULL,
  `insPrimaryComp` varchar(255) NOT NULL,
  `insPrimaryRelationship` varchar(255) NOT NULL,
  `insPrimaryGroupNumber` varchar(255) NOT NULL,
  `insPrimaryPolicyNumber` varchar(255) NOT NULL,
  `insPrimaryPlanName` varchar(255) NOT NULL,
  `insPrimaryEffectiveDate` varchar(255) NOT NULL,
  `insPrimaryEffYearDeviation` varchar(255) NOT NULL,
  `insPrimaryExpirationDate` varchar(255) NOT NULL,
  `insPrimaryExpYearDeviation` varchar(255) NOT NULL,
  `insPrimaryActive` varchar(255) NOT NULL,
  `insPrimaryVerified` varchar(255) NOT NULL,
  `insPrimaryNotSelfUniqueId` varchar(255) NOT NULL,
  `insPrimaryNotSelfFirstName` varchar(255) NOT NULL,
  `insPrimaryNotSelfLastName` varchar(255) NOT NULL,
  `insPrimaryNotSelfSuffix` varchar(255) NOT NULL,
  `insPrimaryNotSelfSex` varchar(255) NOT NULL,
  `insPrimaryNotSelfDateOfBirth` varchar(255) NOT NULL,
  `insPrimaryNotSelfSocialSecNumb` varchar(255) NOT NULL,
  `insPrimaryNotSelfHomePhone` varchar(255) NOT NULL,
  `insPrimaryNotSelfStreetAddress` varchar(255) NOT NULL,
  `insPrimaryNotSelfApptNum` varchar(255) NOT NULL,
  `insPrimaryNotSelfCity` varchar(255) NOT NULL,
  `insPrimaryNotSelfState` varchar(255) NOT NULL,
  `insPrimaryNotSelfZip` varchar(255) NOT NULL,
  `insSecondaryComp` varchar(255) NOT NULL,
  `insSecondaryRelationship` varchar(255) NOT NULL,
  `insSecondaryGroupNumber` varchar(255) NOT NULL,
  `insSecondaryPolicyNumber` varchar(255) NOT NULL,
  `insSecondaryPlanName` varchar(255) NOT NULL,
  `insSecondaryEffectiveDate` varchar(255) NOT NULL,
  `insSecondaryEffYearDeviation` varchar(255) NOT NULL,
  `insSecondaryExpirationDate` varchar(255) NOT NULL,
  `insSecondaryExpYearDeviation` varchar(255) NOT NULL,
  `insSecondaryActive` varchar(255) NOT NULL,
  `insSecondaryVerified` varchar(255) NOT NULL,
  `insSecondaryNotSelfUniqueId` varchar(255) NOT NULL,
  `insSecondaryNotSelfFirstName` varchar(255) NOT NULL,
  `insSecondaryNotSelfLastName` varchar(255) NOT NULL,
  `insSecondaryNotSelfSuffix` varchar(255) NOT NULL,
  `insSecondaryNotSelfSex` varchar(255) NOT NULL,
  `insSecondaryNotSelfDateOfBirth` varchar(255) NOT NULL,
  `insSecondaryNotSelfSocialSecNumb` varchar(255) NOT NULL,
  `insSecondaryNotSelfHomePhone` varchar(255) NOT NULL,
  `insSecondaryNotSelfStreetAddress` varchar(255) NOT NULL,
  `insSecondaryNotSelfApptNum` varchar(255) NOT NULL,
  `insSecondaryNotSelfCity` varchar(255) NOT NULL,
  `insSecondaryNotSelfState` varchar(255) NOT NULL,
  `insSecondaryNotSelfZip` varchar(255) NOT NULL,
  `insTertiaryComp` varchar(255) NOT NULL,
  `insTertiaryRelationship` varchar(255) NOT NULL,
  `insTertiaryGroupNumber` varchar(255) NOT NULL,
  `insTertiaryPolicyNumber` varchar(255) NOT NULL,
  `insTertiaryPlanName` varchar(255) NOT NULL,
  `insTertiaryEffectiveDate` varchar(255) NOT NULL,
  `insTertiaryEffYearDeviation` varchar(255) NOT NULL,
  `insTertiaryExpirationDate` varchar(255) NOT NULL,
  `insTertiaryExpYearDeviation` varchar(255) NOT NULL,
  `insTertiaryActive` varchar(255) NOT NULL,
  `insTertiaryVerified` varchar(255) NOT NULL,
  `insTertiaryNotSelfUniqueId` varchar(255) NOT NULL,
  `insTertiaryNotSelfFirstName` varchar(255) NOT NULL,
  `insTertiaryNotSelfLastName` varchar(255) NOT NULL,
  `insTertiaryNotSelfSuffix` varchar(255) NOT NULL,
  `insTertiaryNotSelfSex` varchar(255) NOT NULL,
  `insTertiaryNotSelfDateOfBirth` varchar(255) NOT NULL,
  `insTertiaryNotSelfSocialSecNumb` varchar(255) NOT NULL,
  `insTertiaryNotSelfHomePhone` varchar(255) NOT NULL,
  `insTertiaryNotSelfStreetAddress` varchar(255) NOT NULL,
  `insTertiaryNotSelfApptNum` varchar(255) NOT NULL,
  `insTertiaryNotSelfCity` varchar(255) NOT NULL,
  `insTertiaryNotSelfState` varchar(255) NOT NULL,
  `insTertiaryNotSelfZip` varchar(255) NOT NULL,
  `createdBy` int(10) unsigned NOT NULL,
  `createdDate` datetime NOT NULL,
  `modifiedBy` int(10) unsigned NOT NULL,
  `modifiedDate` datetime NOT NULL,
  PRIMARY KEY (`ptWorkingId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

DROP TABLE IF EXISTS `relationship`;
CREATE TABLE `relationship` (
  `relationship_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `relationship_desc` varchar(50) NOT NULL,
  `relationship_type` varchar(1) NOT NULL,
  PRIMARY KEY (`relationship_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `relationship`
--

INSERT INTO `relationship` (`relationship_id`, `relationship_desc`, `relationship_type`) VALUES
(1, 'Spouse', 'H'),
(2, 'Self', 'H'),
(3, 'Child', 'H'),
(4, 'Employee', 'H'),
(5, 'Significant Other', 'H'),
(6, 'Mother', 'H'),
(7, 'Father', 'H'),
(8, 'Organ Donor', 'H'),
(9, 'Injured Plaintiff', 'H'),
(10, 'Life Partner', 'H'),
(11, 'Other Relationship', 'H');

-- --------------------------------------------------------

--
-- Table structure for table `sex`
--

DROP TABLE IF EXISTS `sex`;
CREATE TABLE `sex` (
  `sex_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sex_abbr` varchar(1) NOT NULL,
  `sex_desc` varchar(255) NOT NULL,
  PRIMARY KEY (`sex_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sex`
--

INSERT INTO `sex` (`sex_id`, `sex_abbr`, `sex_desc`) VALUES
(1, 'F', 'Female'),
(2, 'M', 'Male'),
(3, 'T', 'Transgender');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
CREATE TABLE `state` (
  `state` varchar(2) NOT NULL,
  `desc` varchar(50) NOT NULL,
  PRIMARY KEY (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`state`, `desc`) VALUES
('AK', 'Alaska'),
('AL', 'Alabama'),
('AR', 'Arkansas'),
('AZ', 'Arizona'),
('CA', 'California'),
('CO', 'Colorado'),
('CT', 'Connecticut'),
('DC', 'District Of Columbia'),
('DE', 'Delaware'),
('FL', 'Florida'),
('GA', 'Georgia'),
('HI', 'Hawaii'),
('IA', 'Iowa'),
('ID', 'Idaho'),
('IL', 'Illinois'),
('IN', 'Indiana'),
('KS', 'Kansas'),
('KY', 'Kentucky'),
('LA', 'Louisiana'),
('MA', 'Massachusetts'),
('MD', 'Maryland'),
('ME', 'Maine'),
('MI', 'Michigan'),
('MN', 'Minnesota'),
('MO', 'Missouri'),
('MS', 'Mississippi'),
('MT', 'Montana'),
('NC', 'North Carolina'),
('ND', 'North Dakota'),
('NE', 'Nebraska'),
('NH', 'New Hampshire'),
('NJ', 'New Jersey'),
('NM', 'New Mexico'),
('NV', 'Nevada'),
('NY', 'New York'),
('OH', 'Ohio'),
('OK', 'Oklahoma'),
('OR', 'Oregon'),
('PA', 'Pennsylvania'),
('RI', 'Rhode Island'),
('SC', 'South Carolina'),
('SD', 'South Dakota'),
('TN', 'Tennessee'),
('TX', 'Texas'),
('UT', 'Utah'),
('VA', 'Virginia'),
('VT', 'Vermont'),
('WA', 'Washington'),
('WI', 'Wisconsin'),
('WV', 'West Virginia'),
('WY', 'Wyoming');

-- --------------------------------------------------------

--
-- Table structure for table `submission`
--

DROP TABLE IF EXISTS `submission`;
CREATE TABLE `submission` (
  `submission_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `submission_type_id` int(10) unsigned NOT NULL,
  `patient_id` int(10) unsigned NOT NULL,
  `submission_to` int(10) unsigned NOT NULL,
  `submission_status_id` int(10) unsigned NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(10) unsigned NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`submission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `submission`
--

INSERT INTO `submission` (`submission_id`, `submission_type_id`, `patient_id`, `submission_to`, `submission_status_id`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 1, 2, 1, 2, 18846, '2012-03-25 04:46:04', 18846, '2012-03-25 04:46:04'),
(2, 1, 3, 1, 2, 18846, '2012-03-25 15:01:02', 18846, '2012-03-25 15:01:02'),
(3, 1, 3, 1, 2, 18846, '2012-03-26 12:00:31', 18846, '2012-03-26 12:00:31');

-- --------------------------------------------------------

--
-- Table structure for table `submission_comment`
--

DROP TABLE IF EXISTS `submission_comment`;
CREATE TABLE `submission_comment` (
  `submission_comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` int(10) unsigned NOT NULL,
  `comment` text NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(10) unsigned NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`submission_comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `submission_comment`
--

INSERT INTO `submission_comment` (`submission_comment_id`, `submission_id`, `comment`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 1, 'This is my initial comment', 18846, '2012-03-25 04:46:04', 18846, '2012-03-25 04:46:04'),
(2, 1, 'Great work, Shad Student', 1, '2012-03-25 04:46:38', 1, '2012-03-25 04:46:38'),
(3, 2, 'Hello Facutly Shad', 18846, '2012-03-25 15:01:02', 18846, '2012-03-25 15:01:02'),
(4, 2, 'hello student shad', 1, '2012-03-25 15:06:26', 1, '2012-03-25 15:06:26'),
(5, 1, 'Hi Geoff', 1, '2012-03-26 11:56:49', 1, '2012-03-26 11:56:49'),
(6, 3, 'Hello Shad, I made corrections, sorry for being late with this assignment.', 18846, '2012-03-26 12:00:31', 18846, '2012-03-26 12:00:31'),
(7, 3, 'Looks great!  Like the additional fields', 1, '2012-03-26 12:01:31', 1, '2012-03-26 12:01:31'),
(8, 1, 'Yo Tim!', 1, '2012-03-26 14:25:21', 1, '2012-03-26 14:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `submission_history`
--

DROP TABLE IF EXISTS `submission_history`;
CREATE TABLE `submission_history` (
  `submission_history_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` int(10) unsigned NOT NULL,
  `submission_status_id` int(10) unsigned NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(10) unsigned NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`submission_history_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `submission_history`
--

INSERT INTO `submission_history` (`submission_history_id`, `submission_id`, `submission_status_id`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 1, 1, 18846, '2012-03-25 04:46:04', 18846, '2012-03-25 04:46:04'),
(2, 2, 1, 18846, '2012-03-25 15:01:02', 18846, '2012-03-25 15:01:02'),
(3, 3, 1, 18846, '2012-03-26 12:00:31', 18846, '2012-03-26 12:00:31');

-- --------------------------------------------------------

--
-- Table structure for table `submission_status`
--

DROP TABLE IF EXISTS `submission_status`;
CREATE TABLE `submission_status` (
  `submission_status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `submission_status_name` varchar(50) NOT NULL,
  PRIMARY KEY (`submission_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `submission_status`
--

INSERT INTO `submission_status` (`submission_status_id`, `submission_status_name`) VALUES
(1, 'Unreviewed'),
(2, 'Reviewed'),
(3, 'Archived'),
(4, 'Geoff');

-- --------------------------------------------------------

--
-- Table structure for table `submission_type`
--

DROP TABLE IF EXISTS `submission_type`;
CREATE TABLE `submission_type` (
  `submission_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `submission_type_name` varchar(50) NOT NULL,
  PRIMARY KEY (`submission_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `submission_type`
--

INSERT INTO `submission_type` (`submission_type_id`, `submission_type_name`) VALUES
(1, 'Patient');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
