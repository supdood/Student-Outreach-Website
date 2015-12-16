-- phpMyAdmin SQL Dump
-- version 4.0.10.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 16, 2015 at 11:05 AM
-- Server version: 5.1.73
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nelson8_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_CLASS_CREATENEWCLASS`(IN `className` VARCHAR(50), IN `classDescription` TEXT)
INSERT INTO  `nelson8_db`.`K12_CLASS` (`ID` ,`Name` ,`Description`) VALUES (NULL ,  className, classDescription)$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_CLASS_GETALL`()
SELECT * FROM `K12_CLASS`$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_EVENTS_GETEVENTS`()
select * From K12_EVENTS$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_EVENTS_INSERTEVENT`(IN `title` VARCHAR(50), IN `startDate` VARCHAR(19), IN `endDate` VARCHAR(19), IN `teacherID` INT(15), IN `eventID` VARCHAR(25), IN `description` TEXT)
insert into K12_EVENTS values(title, startDate, endDate, teacherID, eventID, description)$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_LICHERT_ANSWERS_GETANSWERS`()
SELECT Description FROM K12_LICHERT_ANSWERS ORDER BY K12_LICHERT_ANSWERS.ID ASC$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_POSTSURVEY_QUESTIONS_GETQUESTIONAT`(IN qIndex INT(5))
SELECT Question FROM K12_POSTSURVEY_QUESTIONS WHERE ID = qIndex$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_POSTSURVEY_QUESTIONS_GETQUESTIONCOUNT`()
SELECT count(*) as c FROM K12_POSTSURVEY_QUESTIONS$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_POSTSURVEY_QUESTIONS_GETQUESTIONS`()
SELECT Question FROM K12_POSTSURVEY_QUESTIONS$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_PRESURVEY_QUESTIONS_GETQUESTIONAT`(IN qIndex INT(5))
SELECT Question FROM K12_PRESURVEY_QUESTIONS WHERE ID = qIndex$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_PRESURVEY_QUESTIONS_GETQUESTIONCOUNT`()
SELECT count(*) as c FROM K12_PRESURVEY_QUESTIONS$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_SURVEY_ANSWERS_INSERT_SURVEY`(IN surveyID INT(15), IN questionID INT(15), IN answerID INT(15))
insert into K12_SURVEY_ANSWERS values (surveyID, questionID, answerID)$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_SURVEY_GETSURVEYTYPE`(IN surveyID INT(15))
SELECT t.Description
FROM K12_SURVEY as s, K12_SURVEYTYPE as t
WHERE s.ID = surveyID AND s.SurveyTypeID = t.ID$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_SURVEY_INSERTNEWSURVEY`(IN `teacherID` INT(15), IN `classID` INT(15), IN `completed` VARCHAR(3), IN `surveyTypeID` INT(1))
INSERT INTO `nelson8_db`.`K12_SURVEY` (`ID`, `TeacherID`, `ClassID`, `StartTime`, `EndTime`, `LastQuestionAnswered`, `Completed`, `SurveyTypeID`) VALUES (NULL, teacherID, classID, CURRENT_TIMESTAMP , NULL, 1, completed, surveyTypeID)$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_SURVEY_TEACHER_INCOMPLETESURVEY`(IN email VARCHAR(50))
Select s.ClassID
From K12_SURVEY as s, K12_TEACHER as t
Where s.ID = t.ID AND s.Completed ="no" AND t.Email = email$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_AUTHENTICATE`(IN userName VARCHAR(50), IN regCode VARCHAR(50))
UPDATE K12_TEACHER SET Authenticated = 'yes' WHERE Email = userName and RegistrationCode = regCode$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_AUTHENTICATED`(IN userName VARCHAR(50))
select Authenticated From K12_TEACHER WHERE Email = userName$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_COUNTFORREGISTRATION`(IN userName VARCHAR(50))
select count(*) as c from K12_TEACHER where Email = userName$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_DEMOTETEACHERACCESS`(IN email VARCHAR(50))
UPDATE K12_TEACHER SET AccessLevel = 3 WHERE Email = email$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_GETALLTEACHERS`()
SELECT `ID`, `Email`, `FirstName`, `LastName`, `School`, `Education`, `CSBackground`, `Authenticated`,`RegistrationCode`, `AccessLevel` FROM `K12_TEACHER`$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_GETAUTHENTICATED_USERNAME_PASSWORD`(IN userName VARCHAR(50), IN pwd VARCHAR(30))
select Authenticated From K12_TEACHER WHERE Email = userName and Password = pwd$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_GETCOUNTAUTHENTICATED`(IN userName VARCHAR(50), IN pwd VARCHAR(30))
select count(*) as c from K12_TEACHER where Email = userName and Password = pwd$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_GETFIRSTNAME`(IN userName VARCHAR(50), OUT firstName VARCHAR(50))
select FirstName from K12_TEACHER where UserName = userName$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_GETFULLNAME`(IN userName VARCHAR(50))
select FirstName, LastName from K12_TEACHER where Email = userName$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_GETLASTNAME`(IN userName VARCHAR(50), OUT lastName VARCHAR(50))
select LastName from K12_TEACHER where UserName = userName$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_GETPASSWORD`(IN `userName` VARCHAR(50))
select Password from K12_TEACHER where Email = userName$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_GETSCHOOLEDUBACK`(IN `em` VARCHAR(50))
    NO SQL
select School, Education, CSBackground from K12_TEACHER where Email = em$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_INSERTNEWTEACHER`(IN `email` VARCHAR(50), IN `firstName` VARCHAR(30), IN `lastName` VARCHAR(30), IN `school` VARCHAR(40), IN `education` TEXT, IN `csBackground` TEXT, IN `pwd` VARCHAR(100), IN `authenticated` VARCHAR(30), IN `regCode` VARCHAR(50))
insert into K12_TEACHER values(null, email, firstName, lastName, school, education, csBackground, pwd, authenticated, regCode, 3)$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_PROMOTETEACHERACCESS`(IN email VARCHAR(50))
UPDATE K12_TEACHER SET AccessLevel = 2 WHERE Email = email$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_UPDATEFULLNAME`(IN userName VARCHAR(50), IN newFirstName VARCHAR(30), IN newLastName VARCHAR(30))
UPDATE K12_TEACHER SET FirstName = newFirstName, LastName = newLastName WHERE Email = userName$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `K12_TEACHER_VERIFYREGISTRATIONCODE`(IN userName VARCHAR(50), IN regCode VARCHAR(50))
select count(*) as c from K12_TEACHER where Email = userName and RegistrationCode = regCode$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `p1`()
SELECT * FROM t$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `p2`()
SELECT CURRENT_DATE, RAND() FROM t$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `p8`()
BEGIN
 DECLARE a INT;
 DECLARE b INT;
 SET a = 5;
 SET b = 5;
 SELECT a;
END$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `p9`()
BEGIN
 DECLARE a INT /* there is no DEFAULT clause */;
 DECLARE b INT /* there is no DEFAULT clause */;
 SET a = 5; /* there is a SET statement */
 SET b = 5; /* there is a SET statement */
 SELECT a;
 SELECT b;
END$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `SP_COUNT_USER`(IN uname VARCHAR(50), IN pwd VARCHAR(60), OUT count INT)
Select count(*) into count from REGISTRATION where username = uname and password = pwd$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `SP_CREATE_SAMPLE_DATA`()
BEGIN
 DECLARE v INT;
 SET v = 0;
 WHILE v < 201 DO
 IF MOD(v,2) = 0 THEN
 INSERT INTO REGISTRATION VALUES (null, concat('test', v, '@test.com'), '12345abcde', concat('Test First ', v), concat('Test Last ', v),  'Male', 'IN', concat('19', (FLOOR( 1 + RAND( ) *50 )+49)));
 ELSE
 INSERT INTO REGISTRATION VALUES (null, concat('test', v, '@test.com'), '12345abcde', concat('Test First ', v), concat('Test Last ', v),  'Female', 'IN', concat('19', (FLOOR( 1 + RAND( ) *50 )+49)));
 END IF;
 SET v = v + 1;
 END WHILE;
END$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `SP_FIND_USER_ID`(IN uname VARCHAR(50), IN pwd VARCHAR(60), OUT UID INT)
Select ID into UID from REGISTRATION where username = uname and password = pwd$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `SP_GET_POSTS_BY_EMAIL`(IN uname VARCHAR(50))
select Category, Title, Description, PostDate, PostID  from VW_ALL_POSTS where UserName = uname$$

CREATE DEFINER=`nelson8`@`localhost` PROCEDURE `SP_INSERT_USER`(IN uname VARCHAR(50), IN pwd VARCHAR(60), IN registrationcode VARCHAR(50), IN authenticated BOOLEAN, IN salt CHAR(21), IN fn VARCHAR(50), IN ln VARCHAR(50), IN gender VARCHAR(5), IN state VARCHAR(20), IN byear CHAR(4))
insert into REGISTRATION values (null, uname, pwd, registrationcode, authenticated, salt, fn, ln, gender, state, byear)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `K12_CLASS`
--

CREATE TABLE IF NOT EXISTS `K12_CLASS` (
  `ID` int(15) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=87 ;

--
-- Dumping data for table `K12_CLASS`
--

INSERT INTO `K12_CLASS` (`ID`, `Name`, `Description`) VALUES
(1, 'FunClass', 'This is the greatest class in the world. No joke.'),
(8, 'Ms.Frizzle''s Fall Comp Sci Class', 'Hop on the magic school bus'),
(9, 'Ms.Frizzle''s Fall Comp Sci Class', 'Hop on the magic school bus'),
(10, 'newClass1', 'We gonna be poppin'' collas'),
(11, 'newClass2', ';lkajsdfoija'),
(12, 'so much good funs', 'lkajsf'),
(13, 'dance party class', 'dance dance'),
(14, 'blim blam', 'm. night in the house'),
(15, 'run dmc', 'word'),
(16, 'Benny The Jet Rodriquez', 'Learning about the Great Bambino'),
(17, 'Tupac', 'street poetics'),
(18, 'Angus Beef Class', 'This course is taught be Moolissa'),
(19, ';lkajsdf', 'lkjaskjljaksdf aslkjdf alaiewhj;asdf md'),
(20, 'Grumpy Old Men', 'humbug'),
(21, 'Wonka Vision', 'is it raining, is it pouring, is the hurricane a blowing'),
(22, 'Rumplestilskin', 'Rumplestilskin''s a good man'),
(23, 'monkey', 'monkey'),
(24, 'mop', 'mipo'),
(25, 'rumble in the bronx', 'jackie chan'),
(26, 'crumb', 'crumb'),
(27, 'bam bam', 'wam wam'),
(28, 'junk', 'junk'),
(29, 'trambles', 'schrangus'),
(30, 'bumblebee tuna', 'pet detective'),
(31, 'Benny The Jet Rodriguez', 'The Great Bambino'),
(32, 'lkjasdf', 'jdoinawb'),
(33, 'asdfasdf', 'asdfasdf'),
(34, 'zxcvzxcv', 'zxcvzxcvzxcv'),
(35, 'lkjasdf;oijea', 'l;kjasd a;dkjnb ad''fpouiweafsad as91u23elkqwjdf'),
(36, 'bb', 'bb'),
(37, 'Wilfred', ';lkajsdf'),
(38, 'kljasdfo;ijsdf', 'lkjsdf;oiajsdf'),
(39, 'wonka vision', 'Rumplestilskin''s a good man'),
(40, 'whatever class', 'fun things'),
(41, 'Test', 'Sdjfslkdf'),
(42, 'Rum', 'rumplestilskin'),
(43, 'blom', 'blom'),
(44, 'monkey', 'uncle'),
(45, 'asdfasdf', 'sasdadf'),
(46, '', ''),
(47, 'scringle', 'this is a good class'),
(48, 'rumble', 'in the bronx'),
(49, 'lk;ajsd;fkjas;oidfj', 'lkjasd,nvlkzjd;lkfjaowief lkj a;osj'),
(50, 'brumple', ';aijsd;ofij  alsdjkf ;aoiejs fa'),
(51, 'brump', ';lkajsdf;oisjdf;oijwe;ofiajseoifjasdijf'),
(52, 'lkjaso;ijweflkjasdfoiuasio l,mmvcm,vcxm,cvxz', 'm,xcvm,vcxm,vcxx,mvxcxm,cvxm,.cvxz'),
(53, 'Choonch 101', 'Pheasant toy chewing basics for the chewing enthusiast'),
(54, 'Bob''s Class', 'Description of Bob''s class.'),
(55, 'Resident Sleeper', 'Twitch.tv'),
(56, 'lkjasd;oifjsiejals', 'ljasdlkfja;lkjvzxmvlzkxjv sf;l asdjl j42135256'),
(57, 'safdsaf', 'asdfsadfdsaf'),
(58, 'Dan''s Game', 'Resident Sleeper'),
(59, 'shimble', 'This is a shimbling course -- you''ll learn to shimble'),
(60, 'No Yelling on the Bus', 'That''ll end your preciously little field trip pretty damn quick'),
(61, 'Computer Class', 'Learn how to program.'),
(62, 'Twitch Survey', 'Kappa'),
(63, 'Ethan''s Survey', 'Yep'),
(64, 'abc', 'dfg'),
(65, 'presentation 4', 'demo demo demo'),
(66, 'This Class', 'My description'),
(67, 'AAAAAAAAAAAAAAAAAAAAAAA', 'BBBBBBBBBBBBB'),
(68, 'newest test', 'new new new new new'),
(69, 'New Survey Test', 'This Survey Should Hopefully Work'),
(70, 'Now it should work', 'please'),
(71, 'PLease', 'Just work'),
(72, 'Final Survey', 'Hopefully'),
(73, 'Test', 'Test'),
(74, 'n342', 'serve side programming'),
(75, 'n342', 'server side programming'),
(76, 'n342', 'des'),
(77, 'test', 'test'),
(78, 'test', 'test'),
(79, 'test', 'test'),
(80, 'hello', 'hello'),
(81, 'econ', 'money money money'),
(82, 'superEcon', 'awesome economic stuff'),
(83, 'hey', 'hello'),
(84, 'New Class', 'Nope'),
(85, 'Presentation 4 class', 'this is fun'),
(86, 'Test Class/Survey ID', 'This');

-- --------------------------------------------------------

--
-- Table structure for table `K12_DEMOGRAPHIC`
--

CREATE TABLE IF NOT EXISTS `K12_DEMOGRAPHIC` (
  `ID` int(15) NOT NULL AUTO_INCREMENT,
  `Age` int(3) NOT NULL,
  `Sex` varchar(6) DEFAULT NULL,
  `Ethnicity` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `K12_EVENTS`
--

CREATE TABLE IF NOT EXISTS `K12_EVENTS` (
  `Title` varchar(50) NOT NULL,
  `StartDate` varchar(19) NOT NULL,
  `EndDate` varchar(19) DEFAULT NULL,
  `TeacherID` int(15) NOT NULL,
  `EventID` varchar(25) DEFAULT NULL,
  `Description` text,
  UNIQUE KEY `EventID` (`EventID`),
  KEY `TeacherID` (`TeacherID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `K12_EVENTS`
--

INSERT INTO `K12_EVENTS` (`Title`, `StartDate`, `EndDate`, `TeacherID`, `EventID`, `Description`) VALUES
('New Event', '2016-01-05T01:00:00', '2016-01-05T20:00:00', 3, 'J64IZ2TBJI4N52E6W8JH2CHCQ', 'This is a new event description.'),
('Ethan''s Event', '2015-01-01T01:00:00', '2015-01-01T01:00:00', 4, '71W265ASLZZYWF6SF2UWOF39X', 'My new event.'),
('"" Ethan', '2016-01-01T01:00:00', '2016-01-01T01:00:00', 4, 'P1YMCYJ3BGSP2VTUKFAXYLSFQ', ''),
('URF Event', '2015-12-25T05:00:00', '2015-12-25T22:00:00', 30, 'Y12N51Q5WXHCIPRBRAKQ5W6BA', '');

-- --------------------------------------------------------

--
-- Table structure for table `K12_LICHERT_ANSWERS`
--

CREATE TABLE IF NOT EXISTS `K12_LICHERT_ANSWERS` (
  `ID` int(15) NOT NULL AUTO_INCREMENT,
  `Description` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Description` (`Description`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `K12_LICHERT_ANSWERS`
--

INSERT INTO `K12_LICHERT_ANSWERS` (`ID`, `Description`) VALUES
(2, 'Agree'),
(4, 'Disagree'),
(3, 'Neutral'),
(6, 'None'),
(1, 'Strongly Agree'),
(5, 'Strongly Disagree');

-- --------------------------------------------------------

--
-- Table structure for table `K12_POSTSURVEY_ANSWERS`
--

CREATE TABLE IF NOT EXISTS `K12_POSTSURVEY_ANSWERS` (
  `ID` int(15) NOT NULL AUTO_INCREMENT,
  `Answer1` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `K12_POSTSURVEY_QUESTIONS`
--

CREATE TABLE IF NOT EXISTS `K12_POSTSURVEY_QUESTIONS` (
  `ID` int(15) NOT NULL AUTO_INCREMENT,
  `Question` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `K12_POSTSURVEY_QUESTIONS`
--

INSERT INTO `K12_POSTSURVEY_QUESTIONS` (`ID`, `Question`) VALUES
(1, 'This is a post survey question. Do you agree?'),
(2, 'This is the 2nd post survey question. Do you disagree?'),
(3, 'How many chickens does it take to screw in a lightbulb? This much more difficult when you can only answer using the Lichert Scale. Do you agree?');

-- --------------------------------------------------------

--
-- Table structure for table `K12_PRESURVEY_ANSWERS`
--

CREATE TABLE IF NOT EXISTS `K12_PRESURVEY_ANSWERS` (
  `ID` int(15) NOT NULL AUTO_INCREMENT,
  `Answer1` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `K12_PRESURVEY_QUESTIONS`
--

CREATE TABLE IF NOT EXISTS `K12_PRESURVEY_QUESTIONS` (
  `ID` int(15) NOT NULL AUTO_INCREMENT,
  `Question` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `K12_PRESURVEY_QUESTIONS`
--

INSERT INTO `K12_PRESURVEY_QUESTIONS` (`ID`, `Question`) VALUES
(1, 'This is the first question. Do you agree?'),
(2, 'This is the second question. Do you disagree?'),
(3, 'Communicating to a database can be annoying at times. Do you agree?'),
(4, 'This is another question. What do you think?');

-- --------------------------------------------------------

--
-- Table structure for table `K12_STUDENT`
--

CREATE TABLE IF NOT EXISTS `K12_STUDENT` (
  `ID` int(15) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `School` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `K12_STUDENT_CLASS`
--

CREATE TABLE IF NOT EXISTS `K12_STUDENT_CLASS` (
  `StudentID` int(15) NOT NULL,
  `ClassID` int(15) NOT NULL,
  KEY `StudentID` (`StudentID`,`ClassID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `K12_STUDENT_DEMOGRAPHIC`
--

CREATE TABLE IF NOT EXISTS `K12_STUDENT_DEMOGRAPHIC` (
  `StudentID` int(15) NOT NULL,
  `DemographicID` int(15) NOT NULL,
  KEY `StudentID` (`StudentID`,`DemographicID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `K12_STUDENT_EDUCATION`
--

CREATE TABLE IF NOT EXISTS `K12_STUDENT_EDUCATION` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Level` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `K12_STUDENT_EDUCATION`
--

INSERT INTO `K12_STUDENT_EDUCATION` (`ID`, `Level`) VALUES
(1, 'Kindergarten'),
(2, 'Elementary'),
(4, 'Secondary'),
(5, 'Post-Secondary');

-- --------------------------------------------------------

--
-- Table structure for table `K12_SURVEY`
--

CREATE TABLE IF NOT EXISTS `K12_SURVEY` (
  `ID` int(15) NOT NULL AUTO_INCREMENT,
  `TeacherID` int(15) NOT NULL,
  `ClassID` int(15) NOT NULL,
  `StartTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `EndTime` timestamp NULL DEFAULT NULL,
  `LastQuestionAnswered` int(3) NOT NULL,
  `Completed` varchar(3) NOT NULL,
  `SurveyTypeID` int(1) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `TeacherID` (`TeacherID`),
  KEY `ID` (`ID`),
  KEY `SurveyTypeID` (`SurveyTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `K12_SURVEY`
--

INSERT INTO `K12_SURVEY` (`ID`, `TeacherID`, `ClassID`, `StartTime`, `EndTime`, `LastQuestionAnswered`, `Completed`, `SurveyTypeID`) VALUES
(4, 5, 1, '2015-11-12 09:22:01', '2015-11-19 05:39:19', 5, 'yes', 1),
(5, 5, 8, '2015-11-17 18:24:03', '2015-11-19 19:15:09', 6, 'yes', 1),
(6, 5, 18, '2015-11-17 18:24:48', '2015-11-19 19:48:38', 6, 'yes', 1),
(12, 5, 52, '2015-11-19 03:22:16', '2015-11-19 19:50:54', 4, 'yes', 1),
(13, 5, 52, '2015-11-19 03:23:28', '2015-11-19 05:40:35', 4, 'yes', 1),
(14, 5, 52, '2015-11-19 03:24:11', '2015-12-11 19:15:44', 5, 'yes', 1),
(15, 5, 52, '2015-11-19 03:30:40', '2015-11-19 05:43:14', 1, 'yes', 1),
(16, 5, 51, '2015-11-19 03:37:47', '2015-11-19 18:38:32', 5, 'yes', 1),
(17, 5, 1, '2015-11-19 03:46:31', '2015-11-19 05:42:34', 4, 'yes', 1),
(18, 5, 53, '2015-11-19 03:57:52', '2015-11-19 06:21:30', 5, 'yes', 1),
(19, 5, 56, '2015-11-19 04:49:36', '2015-11-19 05:42:08', 1, 'yes', 1),
(20, 5, 58, '2015-11-19 04:53:45', '2015-11-19 06:09:54', 3, 'yes', 1),
(21, 5, 49, '2015-11-19 05:08:38', '2015-11-19 06:21:23', 1, 'yes', 1),
(22, 5, 49, '2015-11-19 05:09:02', '2015-11-19 06:24:47', 5, 'yes', 1),
(23, 5, 51, '2015-11-19 06:07:12', '2015-11-19 20:57:29', 4, 'yes', 2),
(24, 5, 51, '2015-11-19 06:08:18', '2015-11-19 18:38:55', 4, 'yes', 2),
(25, 5, 1, '2015-11-19 06:11:43', '2015-11-19 06:26:56', 3, 'yes', 2),
(26, 5, 51, '2015-11-19 06:21:38', '2015-12-11 19:15:36', 4, 'yes', 2),
(27, 5, 52, '2015-11-19 06:26:12', '2015-11-19 06:26:20', 4, 'yes', 2),
(28, 5, 60, '2015-11-19 06:28:38', '2015-11-19 06:29:12', 4, 'yes', 1),
(29, 5, 60, '2015-11-19 06:30:14', '2015-11-19 06:31:19', 2, 'yes', 2),
(30, 5, 60, '2015-11-19 06:33:18', NULL, 1, 'no', 2),
(31, 5, 56, '2015-11-19 07:08:51', '2015-11-19 07:08:59', 4, 'yes', 2),
(33, 4, 62, '2015-11-19 08:01:44', NULL, 5, 'no', 1),
(34, 4, 63, '2015-11-19 08:02:43', '2015-12-10 16:28:54', 5, 'yes', 1),
(35, 5, 60, '2015-11-19 14:21:43', NULL, 3, 'no', 2),
(36, 18, 65, '2015-11-19 16:07:13', '2015-11-19 16:07:25', 5, 'yes', 1),
(37, 5, 51, '2015-11-19 18:31:22', '2015-12-11 19:15:22', 4, 'yes', 2),
(38, 5, 51, '2015-11-19 18:35:06', '2015-11-19 19:15:49', 4, 'yes', 2),
(39, 5, 51, '2015-11-19 18:37:46', NULL, 1, 'no', 1),
(40, 5, 58, '2015-11-19 18:46:43', '2015-12-09 23:48:02', 5, 'yes', 1),
(41, 5, 54, '2015-11-19 19:53:59', NULL, 2, 'no', 1),
(42, 4, 66, '2015-11-19 20:22:34', '2015-11-19 20:22:43', 5, 'yes', 1),
(43, 4, 67, '2015-11-19 20:29:28', '2015-11-19 20:29:36', 5, 'yes', 1),
(44, 5, 68, '2015-11-19 20:31:27', '2015-11-19 20:36:26', 5, 'yes', 1),
(45, 4, 69, '2015-11-19 20:35:22', '2015-11-19 20:35:28', 5, 'yes', 1),
(46, 5, 68, '2015-11-19 20:36:54', '2015-11-19 20:37:25', 4, 'yes', 2),
(47, 5, 51, '2015-11-19 20:42:53', NULL, 3, 'no', 1),
(48, 4, 70, '2015-11-19 20:42:56', '2015-11-19 20:43:16', 5, 'yes', 1),
(49, 5, 51, '2015-11-19 20:44:10', NULL, 1, 'no', 1),
(50, 5, 51, '2015-11-19 20:44:45', NULL, 1, 'no', 2),
(51, 4, 71, '2015-11-19 20:45:48', '2015-11-19 20:46:02', 5, 'yes', 1),
(52, 5, 51, '2015-11-19 20:46:15', NULL, 1, 'no', 2),
(53, 5, 51, '2015-11-19 20:47:12', NULL, 2, 'no', 2),
(54, 5, 51, '2015-11-19 20:47:50', '2015-12-11 19:14:47', 4, 'yes', 2),
(55, 5, 51, '2015-11-19 20:48:43', NULL, 1, 'no', 2),
(56, 5, 51, '2015-11-19 20:50:40', NULL, 1, 'no', 2),
(57, 5, 51, '2015-11-19 20:52:09', NULL, 1, 'no', 2),
(58, 5, 51, '2015-11-19 20:52:28', '2015-12-11 19:16:07', 4, 'yes', 2),
(59, 5, 51, '2015-11-19 20:54:27', '2015-12-11 19:15:05', 4, 'yes', 2),
(60, 4, 72, '2015-11-19 21:16:23', '2015-11-19 21:16:34', 5, 'yes', 1),
(61, 21, 41, '2015-11-24 17:41:32', '2015-11-30 16:52:01', 3, 'yes', 1),
(62, 22, 74, '2015-11-25 20:47:47', '2015-11-25 20:48:05', 5, 'yes', 1),
(63, 22, 74, '2015-11-25 20:48:46', '2015-11-25 20:49:05', 4, 'yes', 2),
(64, 21, 74, '2015-11-26 18:24:53', '2015-11-30 16:51:35', 5, 'yes', 1),
(65, 21, 41, '2015-11-27 18:43:51', '2015-11-27 18:44:31', 3, 'yes', 2),
(66, 21, 41, '2015-11-27 18:44:31', '2015-11-30 16:51:45', 4, 'yes', 2),
(67, 21, 41, '2015-11-27 18:44:37', NULL, 1, 'no', 1),
(68, 19, 0, '2015-11-29 19:32:00', '2015-11-29 19:32:04', 5, 'yes', 1),
(69, 21, 74, '2015-11-30 16:51:24', NULL, 1, 'no', 1),
(70, 21, 41, '2015-11-30 16:51:55', NULL, 1, 'no', 1),
(71, 21, 41, '2015-11-30 16:52:13', NULL, 1, 'no', 1),
(72, 26, 41, '2015-11-30 16:55:55', '2015-11-30 16:56:05', 4, 'yes', 1),
(73, 26, 41, '2015-11-30 16:56:29', '2015-11-30 16:56:55', 5, 'yes', 1),
(74, 26, 41, '2015-11-30 17:00:45', NULL, 1, 'no', 1),
(75, 26, 41, '2015-11-30 17:01:04', '2015-11-30 17:01:37', 4, 'yes', 1),
(76, 26, 80, '2015-11-30 17:01:56', '2015-11-30 17:02:21', 5, 'yes', 1),
(77, 19, 81, '2015-12-01 04:06:08', '2015-12-01 04:06:51', 5, 'yes', 1),
(78, 19, 81, '2015-12-01 04:07:28', '2015-12-01 04:07:39', 4, 'yes', 2),
(79, 19, 82, '2015-12-01 04:18:49', '2015-12-01 04:19:13', 5, 'yes', 1),
(80, 19, 82, '2015-12-01 04:20:53', NULL, 1, 'no', 2),
(81, 27, 83, '2015-12-01 04:21:29', '2015-12-01 04:21:37', 5, 'yes', 1),
(82, 19, 82, '2015-12-01 15:28:10', NULL, 1, 'no', 1),
(83, 4, 63, '2015-12-10 07:45:10', '2015-12-10 07:45:17', 4, 'yes', 2),
(84, 3, 84, '2015-12-10 07:48:40', '2015-12-10 07:48:48', 5, 'yes', 1),
(85, 5, 60, '2015-12-10 14:23:06', NULL, 1, 'no', 2),
(86, 5, 60, '2015-12-10 14:23:23', '2015-12-11 19:16:24', 5, 'yes', 1),
(87, 4, 85, '2015-12-10 16:28:19', '2015-12-10 16:28:32', 5, 'yes', 1),
(88, 4, 86, '2015-12-15 02:46:28', '2015-12-15 02:46:37', 5, 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `K12_SURVEYTYPE`
--

CREATE TABLE IF NOT EXISTS `K12_SURVEYTYPE` (
  `ID` int(1) NOT NULL AUTO_INCREMENT,
  `Description` varchar(4) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Description` (`Description`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `K12_SURVEYTYPE`
--

INSERT INTO `K12_SURVEYTYPE` (`ID`, `Description`) VALUES
(2, 'post'),
(1, 'pre');

-- --------------------------------------------------------

--
-- Table structure for table `K12_SURVEY_ANSWERS`
--

CREATE TABLE IF NOT EXISTS `K12_SURVEY_ANSWERS` (
  `SurveyID` int(15) NOT NULL,
  `QuestionID` int(15) NOT NULL,
  `AnswerID` int(15) NOT NULL,
  KEY `SurveyID` (`QuestionID`,`AnswerID`),
  KEY `QuestionID` (`QuestionID`),
  KEY `AnswerID` (`AnswerID`),
  KEY `SurveyID_2` (`SurveyID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `K12_SURVEY_ANSWERS`
--

INSERT INTO `K12_SURVEY_ANSWERS` (`SurveyID`, `QuestionID`, `AnswerID`) VALUES
(4, 2, 2),
(5, 2, 2),
(5, 1, 4),
(5, 2, 1),
(5, 3, 4),
(5, 4, 5),
(5, 5, 5),
(12, 1, 2),
(14, 1, 3),
(14, 2, 2),
(14, 3, 4),
(14, 4, 5),
(6, 1, 2),
(6, 2, 3),
(6, 3, 1),
(6, 4, 3),
(6, 5, 2),
(16, 2, 1),
(16, 3, 2),
(16, 4, 4),
(16, 5, 2),
(16, 1, 2),
(16, 2, 4),
(16, 3, 2),
(4, 4, 2),
(18, 1, 1),
(18, 2, 1),
(18, 3, 1),
(18, 4, 1),
(17, 1, 2),
(17, 2, 4),
(17, 3, 1),
(17, 4, 2),
(17, 1, 1),
(17, 2, 2),
(17, 3, 1),
(20, 1, 1),
(20, 2, 5),
(20, 3, 3),
(20, 4, 1),
(13, 1, 2),
(13, 2, 3),
(13, 3, 4),
(33, 1, 1),
(33, 2, 2),
(33, 3, 3),
(33, 4, 4),
(34, 1, 5),
(34, 2, 5),
(34, 3, 5),
(34, 4, 4),
(16, 1, 1),
(16, 2, 4),
(16, 3, 1),
(16, 4, 2),
(24, 2, 1),
(20, 1, 1),
(20, 2, 1),
(40, 1, 1),
(40, 2, 2),
(37, 1, 1),
(38, 1, 2),
(38, 3, 1),
(12, 2, 1),
(42, 3, 3),
(42, 4, 2),
(43, 2, 1),
(43, 3, 2),
(43, 4, 3),
(44, 3, 1),
(45, 2, 1),
(45, 3, 2),
(45, 4, 3),
(46, 1, 1),
(46, 2, 4),
(46, 3, 5),
(48, 1, 2),
(48, 2, 3),
(48, 3, 6),
(48, 4, 4),
(51, 1, 1),
(51, 2, 1),
(51, 3, 5),
(51, 4, 5),
(23, 1, 6),
(23, 2, 2),
(23, 3, 6),
(53, 1, 6),
(60, 1, 5),
(60, 2, 5),
(60, 3, 2),
(60, 4, 1),
(61, 1, 1),
(62, 1, 1),
(62, 2, 1),
(62, 3, 1),
(62, 4, 1),
(63, 1, 2),
(63, 2, 6),
(63, 3, 6),
(64, 1, 6),
(64, 2, 6),
(64, 3, 6),
(64, 4, 6),
(61, 2, 6),
(61, 3, 6),
(61, 4, 6),
(65, 1, 1),
(65, 2, 1),
(61, 3, 2),
(68, 1, 6),
(68, 2, 6),
(68, 3, 6),
(68, 4, 6),
(64, 1, 6),
(64, 2, 6),
(64, 3, 6),
(64, 4, 6),
(66, 1, 6),
(66, 2, 6),
(66, 3, 6),
(61, 1, 6),
(61, 2, 6),
(61, 3, 6),
(61, 4, 6),
(61, 1, 6),
(61, 2, 6),
(72, 1, 4),
(72, 2, 2),
(72, 3, 3),
(72, 4, 4),
(72, 1, 2),
(73, 1, 6),
(73, 2, 2),
(73, 3, 6),
(73, 4, 6),
(72, 1, 6),
(72, 2, 2),
(72, 1, 6),
(72, 2, 6),
(72, 3, 2),
(75, 1, 6),
(75, 2, 6),
(75, 3, 1),
(76, 1, 3),
(76, 2, 4),
(76, 3, 5),
(76, 4, 1),
(77, 1, 1),
(77, 2, 1),
(77, 3, 2),
(77, 4, 3),
(78, 1, 6),
(78, 2, 6),
(78, 3, 6),
(79, 1, 1),
(79, 2, 1),
(79, 3, 1),
(79, 4, 1),
(81, 1, 6),
(81, 2, 6),
(81, 3, 6),
(81, 4, 6),
(58, 1, 3),
(40, 3, 3),
(40, 4, 3),
(47, 1, 2),
(47, 2, 3),
(83, 1, 3),
(83, 2, 1),
(83, 3, 6),
(84, 1, 5),
(84, 2, 1),
(84, 3, 3),
(84, 4, 2),
(29, 1, 2),
(87, 1, 2),
(87, 2, 2),
(87, 3, 3),
(87, 4, 2),
(54, 1, 2),
(54, 2, 2),
(54, 3, 2),
(59, 1, 2),
(59, 2, 3),
(59, 3, 1),
(37, 2, 2),
(37, 3, 5),
(26, 1, 2),
(26, 2, 1),
(26, 3, 3),
(58, 2, 3),
(58, 3, 4),
(86, 1, 2),
(86, 2, 3),
(86, 3, 4),
(86, 4, 5),
(88, 1, 3),
(88, 2, 3),
(88, 3, 3),
(88, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `K12_TEACHER`
--

CREATE TABLE IF NOT EXISTS `K12_TEACHER` (
  `ID` int(15) NOT NULL AUTO_INCREMENT,
  `Email` varchar(50) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `School` varchar(40) DEFAULT NULL,
  `Education` text NOT NULL,
  `CSBackground` text NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Authenticated` varchar(3) NOT NULL,
  `RegistrationCode` varchar(50) DEFAULT NULL,
  `AccessLevel` int(1) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Password` (`Password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `K12_TEACHER`
--

INSERT INTO `K12_TEACHER` (`ID`, `Email`, `FirstName`, `LastName`, `School`, `Education`, `CSBackground`, `Password`, `Authenticated`, `RegistrationCode`, `AccessLevel`) VALUES
(3, 'efetsko@umail.iu.edu', 'Cassandra', 'White', 'MIT', 'bs', 'dsafds', '$2y$10$WUNC6OpwdLcVPCesYCWLmOpkvnwtN6EMTuJnf4Xj3DhjdmyMnF8Gm', 'yes', '9J73XKG5WQF392MKVWKDHJ9MW8CV3S78SNRJQJF8KRMHRWN43K', 3),
(4, 'edfetsko@gmail.com', 'Ethan', 'Fetsko', 'IUPUI', 'bs', '', '$2y$10$SNBNiLUR3gjh4dXyNKWZkOay7dvggibWR7FBaAYs30pTXVR4/Tz6i', 'yes', '3QXCV6TCD5INNDHOW47S9QKN1C9MI2R3JPJJ5EQ4QC23PU33MF', 1),
(5, 'jasonnelson101@gmail.com', 'Jason', 'Nelson', 'IUPUI', 'bs', 'a;lksdf', '$2y$10$xrWmTR.KtpDNT7lvCdMpGewTr6kVLNV7CdBW4cvgdx.uQmRl5u5.C', 'yes', '3CKO7AHGCRXMDSWPYGMA3SVWLBZDGFC1CVGWL4RD99C4UCDL9N', 3),
(17, 'supdood2013@gmail.com', 'Joe', 'Tran', 'Pure', 'bs', '', '$2y$10$YLipabRWmUImdT4gkRTIA.CEjK8.g9qWg.mu.Tcykd94lWJD9L0bC', 'yes', 'ZGLRW6KZI6RDDMYMUW8O2ZVNWBGQQ1WP5BUVPK2KYOHIGKBU9C', 3),
(18, 'pondercreekphoto@gmail.com', 'john do', 'Smith', 'IUPUI', 'ms', 'k;ajsdifojajf', '$2y$10$9sVRClqQ0lvylgn5t/eaMOAj/BXDBN38qGzM4M0nBiTtfVlf93HmC', 'yes', 'PCJHMWJWWL3Y2LV2RVRDCCGTSX3JG1ILCRTHV2N3HRQIJJAZA3', 3),
(19, 'superAdmin@admin.com', 'Super', 'Admin', 'IUPUI', 'ms', 'rumplestilskin', '$2y$10$AdnbTTizOiPaW7oyudMd4eutxn4LK7Qw.gGdMyFr4y.PzzTsxXama', 'yes', 'KJASKHFINASKJDNFHIUAHSDFBASDF', 1),
(20, 'admin@admin.com', 'Regular', 'Admin', 'IUPUI', 'bs', 'regular admin', '$2y$10$XZEaYcH47UF74Mo7N5XxN.MTQAAoPeGDR.RqMWdOvEOzEWQm6B0Qe', 'yes', 'KJAHSDIFNWEKBVUIACSDNCIKUHSKJBC', 2),
(21, 'teacher@teacher.com', 'Teacher', 'StandardUser', 'IUPUI', 'bs', 'regular user', '$2y$10$0bjqnjTDqA45SFlwJyFxSu7UfIPDITqR0/J0JWGX0FuuC9zegcM0m', 'yes', 'KJHSADIUBVIUNCIUNZKJHXGZUYXGUYGWEQ', 3),
(22, 'mbhammer@iupui.edu', 'Mary', 'Hammer', 'IUPUI', 'bs', 'Lots of stuff', '$2y$10$4OKj.JHm2PSsjGHNr5Q2SeLZ1xlJoCXf99U.YhXRmQqym0qTuXS8u', 'yes', 'OIWOASLE7PK2QO7DBBLBIMP2TJJ5AEQLHJ5D6DV2APMWIIPXYO', 3),
(23, 'n342@mailinator.com', 'Denver', 'Huynh', 'IUS', 'bs', 'BG', '$2y$10$ZWLJFmL3M/1F3Kp8wdEFkeknZQb0t/tlEzzmlhUxFOOgDLQ2lufW2', 'yes', '8T7NVLYGDLVNWUCJDA7N5N28NMWWUFQ89QJ1F1SCUPCIVHPEW7', 3),
(24, 'abc@def.com', 'abc', 'def', 'lol', 'bs', '1', '$2y$10$eORab3nTThlOvNF5uCcDeeXXbp1yow6GF3USxrg9bIbokF7bat0dq', 'no', 'ETCOMLBWF824JIVPQD9KJJNJ9XKDL5TYTA8KSODCLT2FZDEMSU', 3),
(25, 'djantoc@gmail.com', 'Chris', 'Antolin', 'Butler', 'bs', 'CSCI', '$2y$10$bPLyaLZgOuiwHsRE.hKor.jaKTetuO.0fJ.8ibytADJAPOR14e0l2', 'yes', 'YR51P7YIFZCQ9R9DDUTEQHE99IIBFJEDKHI75JY1LQ19FVS1DV', 3),
(26, 'kylefetterman@gmail.com', 'Kyle1', 'Fetterman', 'iupui-i', 'bs', 'iupui', '$2y$10$8Y6toPzLrFo7j.4OYzyUoOnxC/iGa8BSQyR/IIcJQ/x80DnWE/ZEm', 'yes', '6V8N3CEP2EZ5PKAUJVLK2AGUT6LJ48BGGNSYEWNB21AJI5FRXA', 3),
(27, 'b@b.com', 'b', 'b', 'b', 'bs', '', '$2y$10$4BNFOSWwrjfG9GOjlh9JcOfqmeXF/0aXh3iHUggP.ET8eEQ0WM0IK', 'no', '2LHWCZWL3CNKU6PDDWO5EWG8J9M99JQPC3KVZMW7722BHJLJ4S', 3),
(28, 'wxmcyndi@gmail.com', 'XINGMIN', 'WU', 'IUPUI', 'bs', '', '$2y$10$2yVnJSNv2TZXZa6DVZ7bdu.UjMs9.QvXF9PwY3nz.2QI2q1PzE7bu', 'yes', 'KROV9KUMT1FS2BANE1N6ZVQDYMSUCV7LXSBWAKVXBTM1GZ1DKR', 3),
(31, 'friendsofurf@gmail.com', 'Turf', 'Manateee', 'League', 'bs', 'Nonee', '$2y$10$Fza9q3zcOpAflyQ941s8dOavPOWKIoV39DGRAzd7PehNgwcbzJy52', 'yes', 'F7N8J8IKCM2MXLP1KMEIIBFFPK73M5JJ9B3J7UNFVXI5AULGJ2', 3);

-- --------------------------------------------------------

--
-- Table structure for table `K12_TEACHER_CLASS`
--

CREATE TABLE IF NOT EXISTS `K12_TEACHER_CLASS` (
  `TeacherID` int(15) NOT NULL,
  `ClassID` int(15) NOT NULL,
  KEY `TeacherID` (`TeacherID`,`ClassID`),
  KEY `ClassID` (`ClassID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `K12_TEACHER_CLASS`
--

INSERT INTO `K12_TEACHER_CLASS` (`TeacherID`, `ClassID`) VALUES
(3, 84),
(4, 61),
(4, 62),
(4, 63),
(4, 64),
(4, 66),
(4, 67),
(4, 69),
(4, 70),
(4, 71),
(4, 72),
(4, 85),
(4, 86),
(5, 1),
(5, 49),
(5, 50),
(5, 51),
(5, 52),
(5, 53),
(5, 54),
(5, 55),
(5, 56),
(5, 57),
(5, 58),
(5, 59),
(5, 60),
(5, 68),
(18, 65),
(19, 81),
(19, 82),
(21, 41),
(21, 41),
(21, 74),
(22, 74),
(22, 74),
(26, 41),
(26, 41),
(26, 80),
(27, 83);

-- --------------------------------------------------------

--
-- Table structure for table `K12_TEACHER_STUDENT`
--

CREATE TABLE IF NOT EXISTS `K12_TEACHER_STUDENT` (
  `TeacherID` int(15) NOT NULL,
  `StudentID` int(15) NOT NULL,
  KEY `TeacherID` (`TeacherID`,`StudentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `K12_SURVEY`
--
ALTER TABLE `K12_SURVEY`
  ADD CONSTRAINT `K12_SURVEY_ibfk_1` FOREIGN KEY (`SurveyTypeID`) REFERENCES `K12_SURVEYTYPE` (`ID`) ON UPDATE CASCADE;

--
-- Constraints for table `K12_SURVEY_ANSWERS`
--
ALTER TABLE `K12_SURVEY_ANSWERS`
  ADD CONSTRAINT `K12_SURVEY_ANSWERS_ibfk_1` FOREIGN KEY (`SurveyID`) REFERENCES `K12_SURVEY` (`ID`) ON UPDATE CASCADE;

--
-- Constraints for table `K12_TEACHER_CLASS`
--
ALTER TABLE `K12_TEACHER_CLASS`
  ADD CONSTRAINT `K12_TEACHER_CLASS_ibfk_1` FOREIGN KEY (`TeacherID`) REFERENCES `K12_TEACHER` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `K12_TEACHER_CLASS_ibfk_2` FOREIGN KEY (`ClassID`) REFERENCES `K12_CLASS` (`ID`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
