-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Host: db5006542823.hosting-data.io
-- Generation Time: Mar 28, 2022 at 01:52 AM
-- Server version: 5.7.36-log
-- PHP Version: 7.0.33-0+deb9u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbs5427968`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `type` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `name`, `type`) VALUES
(101, 'Set up API header pageLoad', 1),
(102, 'Send API request', 1),
(105, 'Verify API response contains', 1),
(106, 'Verify API response json Path-Values contains', 1),
(107, 'Verify API response json Path-Values NOT contains', 1),
(108, 'Verify API response code', 1),
(109, 'Verify API response NOT contains', 1),
(110, 'Verify API response json Path-Values match regrex', 1),
(201, 'Set Up DB Connection', 1),
(202, 'Execute SQL', 1),
(204, 'Verify SQL results row-col', 1),
(205, 'Verify SQL result at row-col(start by 0) contains', 1),
(300, 'Get Last log from file using regex', 1),
(301, 'Verify Last log contains', 1),
(302, 'Verify Last log NOT contains', 1),
(500, 'Get Text & Save to Variable', 0),
(501, 'Save API response json Key-Values to variable', 1),
(502, 'Save SQL result to variable', 1),
(503, 'Variable contains', 1),
(504, 'Variable NOT contains', 1),
(505, 'Set Variable Value', 1),
(600, 'NavigateTo', 1),
(601, 'SetText', 1),
(602, 'Select dropdown by Text', 1),
(603, 'Select dropdown by Index', 1),
(604, 'Click', 1),
(605, 'Click using Javascript', 1),
(606, 'Sleep', 1),
(607, 'Wait for Element Enable', 1),
(608, 'Wait for Element Disapeare', 0),
(609, 'Wait for URL Match', 0),
(610, 'Switch to Frame using id', 1),
(611, 'Switch to Default Frame', 1),
(612, 'Switch to a new tab', 1),
(613, 'Click OK in Alert', 0),
(614, 'Click Cancel in Alert', 0),
(615, 'Set Text in Alert', 0),
(616, 'Access Web using user_pass', 1),
(700, 'Verify Title contains', 1),
(701, 'Verify Text Contains', 1),
(702, 'Verify Element Enable', 1),
(703, 'Verify Element NOT Enable', 1),
(704, 'Verify Title NOT contains', 1),
(705, 'Verify Text NOT Contains', 1),
(706, 'Verify dropdown option contains', 1),
(707, 'Verify dropdown select value', 1),
(708, 'Verify Elements Enable', 0),
(709, 'Verify Elements NOT Enable', 0),
(710, 'Verify Number(INT) by comapre', 0),
(6101, 'Switch to iFrame using index(start by 0)', 1),
(6102, 'Switch to Frame using xpath', 1),
(6103, 'Switch to Frame using name', 1);

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` char(36) NOT NULL,
  `answer` mediumtext NOT NULL,
  `questionid` char(36) NOT NULL,
  `createdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastchange` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `answers_userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `answer`, `questionid`, `createdate`, `lastchange`, `answers_userid`) VALUES
('72e09028-a6f9-11ec-80ba-001a4a350220', 'Data in any audit table gets modified based on triggers. \r\nExample for Client_A\r\nWhen clients table will be updated by system API, trigger will be fired and update corresponding audit table.\r\nTriggers will also add new event into EventNotification table and that will end up creating events into PcEventStore table.\r\n', '3f946947-a6f9-11ec-80ba-001a4a350220', '2022-03-18 16:24:06', '2022-03-18 16:24:06', 2);

--
-- Triggers `answers`
--
DELIMITER $$
CREATE TRIGGER `before_insert_answer` BEFORE INSERT ON `answers` FOR EACH ROW BEGIN
  IF new.id IS NULL  OR new.id = ''  THEN
    SET new.id = uuid();
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` char(36) NOT NULL,
  `teamid` char(36) DEFAULT NULL,
  `application` varchar(200) NOT NULL,
  `createdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastchange` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `applications_userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `teamid`, `application`, `createdate`, `lastchange`, `applications_userid`) VALUES
('98bd2bb7-aa53-11ec-80ba-001a4a350220', '27604c5f-8896-11ec-8f7c-001a4a2500e0', 'Demo', '2022-03-22 22:47:36', NULL, 2),
('cfc7ee33-8b87-11ec-8f7c-001a4a2500e0', '27604c5f-8896-11ec-8f7c-001a4a2500e0', 'System Client API', '2022-02-11 17:13:16', NULL, 2);

--
-- Triggers `applications`
--
DELIMITER $$
CREATE TRIGGER `before_insert_applications` BEFORE INSERT ON `applications` FOR EACH ROW BEGIN
  IF new.id IS NULL  OR new.id = '' THEN
    SET new.id = uuid();
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `criterias`
--

CREATE TABLE `criterias` (
  `id` char(36) NOT NULL,
  `code` varchar(100) NOT NULL,
  `criteriadesc` text NOT NULL,
  `parent` char(36) NOT NULL,
  `criterias_userid` int(11) NOT NULL,
  `appid` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `criterias`
--

INSERT INTO `criterias` (`id`, `code`, `criteriadesc`, `parent`, `criterias_userid`, `appid`) VALUES
('a34e7179-aa53-11ec-80ba-001a4a350220', '1.0.0', 'Demo for API work well', '', 2, '98bd2bb7-aa53-11ec-80ba-001a4a350220'),
('af9aee35-aa53-11ec-80ba-001a4a350220', '2.0.0', 'Demo for DB work well', '', 2, '98bd2bb7-aa53-11ec-80ba-001a4a350220'),
('b765af0f-aa53-11ec-80ba-001a4a350220', '3.0.0', 'Demo for UI work well', '', 2, '98bd2bb7-aa53-11ec-80ba-001a4a350220'),
('d204cde7-aa53-11ec-80ba-001a4a350220', '4.0.0', 'Demo for variables work well', '', 2, '98bd2bb7-aa53-11ec-80ba-001a4a350220'),
('f43d1f42-8b87-11ec-8f7c-001a4a2500e0', '1.0', 'Verify Client Endpoint  POST \"api/clients\" work fine', '', 2, 'cfc7ee33-8b87-11ec-8f7c-001a4a2500e0');

--
-- Triggers `criterias`
--
DELIMITER $$
CREATE TRIGGER `before_insert_criterias` BEFORE INSERT ON `criterias` FOR EACH ROW BEGIN
  IF new.id IS NULL  OR new.id = '' THEN
    SET new.id = uuid();
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `criteria_testcase`
--

CREATE TABLE `criteria_testcase` (
  `id` int(11) NOT NULL,
  `criteriaid` char(36) NOT NULL,
  `testcaseid` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `criteria_testcase`
--

INSERT INTO `criteria_testcase` (`id`, `criteriaid`, `testcaseid`) VALUES
(1, 'f43d1f42-8b87-11ec-8f7c-001a4a2500e0', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0'),
(2, 'f43d1f42-8b87-11ec-8f7c-001a4a2500e0', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0');

-- --------------------------------------------------------

--
-- Table structure for table `elements`
--

CREATE TABLE `elements` (
  `id` char(36) NOT NULL,
  `name` varchar(500) NOT NULL,
  `xpathid` varchar(2000) NOT NULL,
  `elements_userid` int(11) NOT NULL,
  `teamid` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elements`
--

INSERT INTO `elements` (`id`, `name`, `xpathid`, `elements_userid`, `teamid`) VALUES
('05e40187-ab7c-11ec-80ba-001a4a350220', 'Ski1.AccountCreationForm.FPCodeTxt', 'nao_main_Rep_Code', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('0b8f4805-ab77-11ec-80ba-001a4a350220', 'Ski1.NewClientForm.LastNametxt', '//input[@name=\'lastName\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('107c05aa-ab7d-11ec-80ba-001a4a350220', 'Ski1.AccountCreateionForm.AccountPrefix.Firstresult', '//ul[@id=\'nao_main_Account_Prefixresults\']/li[1]', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('231c2d06-ab76-11ec-80ba-001a4a350220', 'Ski1.Homepage.NewBtn', '//a[@role=\'button\']/div[.=\'New\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('259154c6-ab85-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.Strategies.AmericanFunds', '(//div[.=\'American Funds\'])[0]', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('28268ab9-ab7f-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.planningobjective.skip', '//div[.=\'Skip\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('2895c328-aba9-11ec-80ba-001a4a350220', 'Ski1.AddFinancialaccounts.iFrame', '//iframe[@class=\'frameContainerEither\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('344f7dd2-ab86-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.FinalDetails.GenerateDocumentBtn', '//button[.=\'Generate Documents\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('39cb9b95-ab88-11ec-80ba-001a4a350220', 'Ski1.AccountCreationForm.PlanAndProposal.GreenMessage', '//div[contains(@style,\'color:green\')]', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('41e81447-ab7c-11ec-80ba-001a4a350220', 'Ski1.AccountCreationForm.FPcode.FirstResult', 'nao_main_Rep_Code_result0', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('45668e44-ab78-11ec-80ba-001a4a350220', 'Ski1.ClientPage.OpenNewAccountBtn', '//button[@name=\'Account.New_Account_Opening_CIR\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('463ac1d6-ab87-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.Finalize.Workflowtext', '(//div[@class=\'finalize__title\'])[0]', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('4e961d48-ab77-11ec-80ba-001a4a350220', 'Ski1.NewClientForm.SaveBtn', '//button[@name=\'SaveEdit\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('4ec47efe-ab75-11ec-80ba-001a4a350220', 'Sk1.SSO.Login.Email', 'signInName', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('5b28a9a5-ab85-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.Strategies.AmericanFunds.Moderate Growth and Income Model', '(//div[.=\'Moderate Growth and Income Model\'])[0]', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('5c035127-ab87-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.Finalize.CloseBtn', '//div[@class=\'journey__btn\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('5c0ccc0a-ab7e-11ec-80ba-001a4a350220', 'Ski1.AccountCreationForm.AddProposalBtn', '//button[.=\'Add\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('66b3a275-ab7d-11ec-80ba-001a4a350220', 'Ski1.AccountCreateForm.RegistrationType.FirstResult', '//ul[@id=\'nao_main_Account_Typeresults\']/li[1]', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('6791423a-ab7a-11ec-80ba-001a4a350220', 'Ski1.AccountCreateForm.RegistrationTypetxt', 'nao_main_Account_Type', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('71cdbcc9-ab86-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.Finalize.ContinueAccountOpenBtn', '//div[.=\'Continue Account Open\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('72474a8d-ab81-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.RiskTolerance.Continue', '//button[.=\'Continue\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('7c3a07b1-ab7d-11ec-80ba-001a4a350220', 'Ski1.AccountCreationForm.AccountManagementType.FristResult', '//ul[@id=\'nao_main_Account_Management_Typeresults\']/li[1]', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('82ca0c8d-ab75-11ec-80ba-001a4a350220', 'Sk1.SSO.Login.Password', 'password', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('83b400f7-ab81-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.Products.ExpectedAmountTxt', '//div[@class=\'currency-input\']/div/input', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('85b6b5af-ab7b-11ec-80ba-001a4a350220', 'Ski1.AccountCreationForm.AccountManagementTypeTxt', 'nao_main_Account_Management_Type', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('925fc84a-abaa-11ec-80ba-001a4a350220', 'Ski1.AddFinancialaccounts.iFrameChild', 'vueFrame', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('92c628af-ab80-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.RiskTolerance.SkipQuestionnaireBtn', '//div[.=\'Skip Questionnaire\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('a28b5b61-ab75-11ec-80ba-001a4a350220', 'Ski1.SSO.Login.Nextbtn', 'next', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('a4bf3519-ab7d-11ec-80ba-001a4a350220', 'Ski1.AccountCreationFrom.ProgramType.FristResult', '//ul[@id=\'nao_main_Program_Typeresults\']/li[1]', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('b6078927-ab84-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.Products.SelectStrategiesBtn', '//button[.=\'Select Strategies\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('c214fa29-ab80-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.RiskTolerance.ModerateRbtn', '//input[@name=\'Moderate\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('c4e05617-ab85-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.Strategies.SaveAccountBtn', '(//button[.=Save Account\'])[0]', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('d7358d53-ab76-11ec-80ba-001a4a350220', 'Ski1.NewClientForm.FirstNametxt', '//input[@name=\'firstName\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('d81f55d1-ab7b-11ec-80ba-001a4a350220', 'Ski1.AccountCreationFrom.ProgramTypeTxt', 'nao_main_Program_Type', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('e3ab6f0e-ab7c-11ec-80ba-001a4a350220', 'Ski1.AccountCreationForm.AccountPrefixTxt', 'nao_main_Account_Prefix', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('e4cbb86b-ab80-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.RiskTolerance.TwotofiveyearsRbtn', '//input[@name=\'Two to five years\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('eab32496-ab79-11ec-80ba-001a4a350220', 'Ski1.AddFinancialaccounts.NextBtn', '(\"//button[@id=\'btnFinish\']\")[0]', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
('f85ced34-ab85-11ec-80ba-001a4a350220', 'Ski1.Proposalpopup.Illustration.Skipbtn', '//div[.=\'Skip Illustration\']', 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0');

--
-- Triggers `elements`
--
DELIMITER $$
CREATE TRIGGER `before_insert_elements` BEFORE INSERT ON `elements` FOR EACH ROW BEGIN
  IF new.id IS NULL   OR new.id = '' THEN
    SET new.id = uuid();
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `environments`
--

CREATE TABLE `environments` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `environments`
--

INSERT INTO `environments` (`id`, `name`) VALUES
(1, 'TEST'),
(2, 'INTG'),
(3, 'UAT'),
(4, 'PROD');

-- --------------------------------------------------------

--
-- Table structure for table `phpgen_user_perms`
--

CREATE TABLE `phpgen_user_perms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `perm_name` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phpgen_user_perms`
--

INSERT INTO `phpgen_user_perms` (`id`, `user_id`, `page_name`, `perm_name`) VALUES
(1, 1, '', 'ADMIN'),
(2, 2, 'teams', 'SELECT'),
(3, 2, 'teams.applications', 'SELECT'),
(4, 2, 'teams.applications', 'UPDATE'),
(5, 2, 'teams.applications', 'INSERT'),
(6, 2, 'teams.applications', 'DELETE'),
(7, 2, 'teams.applications.criterias', 'SELECT'),
(8, 2, 'teams.applications.criterias', 'UPDATE'),
(9, 2, 'teams.applications.criterias', 'INSERT'),
(10, 2, 'teams.applications.criterias', 'DELETE'),
(11, 2, 'teams.applications.criterias.criteria_testcase', 'SELECT'),
(12, 2, 'teams.applications.criterias.criteria_testcase', 'UPDATE'),
(13, 2, 'teams.applications.criterias.criteria_testcase', 'INSERT'),
(14, 2, 'teams.applications.criterias.criteria_testcase', 'DELETE'),
(15, 2, 'teams.elements', 'SELECT'),
(16, 2, 'teams.elements', 'UPDATE'),
(17, 2, 'teams.elements', 'INSERT'),
(18, 2, 'teams.elements', 'DELETE'),
(19, 2, 'teams.testcases', 'SELECT'),
(20, 2, 'teams.testcases', 'UPDATE'),
(21, 2, 'teams.testcases', 'INSERT'),
(22, 2, 'teams.testcases', 'DELETE'),
(23, 2, 'teams.testcases.steps', 'SELECT'),
(24, 2, 'teams.testcases.steps', 'UPDATE'),
(25, 2, 'teams.testcases.steps', 'INSERT'),
(26, 2, 'teams.testcases.steps', 'DELETE'),
(27, 2, 'teams.testcases.criteria_testcase', 'SELECT'),
(28, 2, 'teams.testcases.criteria_testcase', 'UPDATE'),
(29, 2, 'teams.testcases.criteria_testcase', 'INSERT'),
(30, 2, 'teams.testcases.criteria_testcase', 'DELETE'),
(31, 2, 'teams.testcases.run', 'SELECT'),
(32, 2, 'teams.testcases.run', 'UPDATE'),
(33, 2, 'teams.testcases.run', 'INSERT'),
(34, 2, 'teams.testcases.run', 'DELETE'),
(39, 2, 'questions', 'SELECT'),
(40, 2, 'questions', 'UPDATE'),
(41, 2, 'questions', 'INSERT'),
(42, 2, 'questions', 'DELETE'),
(43, 2, 'questions.answers', 'SELECT'),
(44, 2, 'questions.answers', 'UPDATE'),
(45, 2, 'questions.answers', 'INSERT'),
(46, 2, 'questions.answers', 'DELETE'),
(47, 2, 'RTM', 'SELECT'),
(48, 2, 'RTM.RTMT', 'SELECT'),
(49, 2, 'RTM.RTMT.RTMD', 'SELECT');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` char(36) NOT NULL,
  `qteamid` char(36) DEFAULT NULL,
  `question` mediumtext NOT NULL,
  `createdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastchange` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `questions_userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `qteamid`, `question`, `createdate`, `lastchange`, `questions_userid`) VALUES
('3f946947-a6f9-11ec-80ba-001a4a350220', '27604c5f-8896-11ec-8f7c-001a4a2500e0', 'What is [table_name]_A or audit table used for?', '2022-03-18 16:22:42', '2022-03-18 16:22:42', 2);

--
-- Triggers `questions`
--
DELIMITER $$
CREATE TRIGGER `before_insert_question` BEFORE INSERT ON `questions` FOR EACH ROW BEGIN
  IF new.id IS NULL  OR new.id = ''  THEN
    SET new.id = uuid();
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `run`
--

CREATE TABLE `run` (
  `id` char(36) NOT NULL,
  `status` int(11) NOT NULL,
  `createdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `testcaseid` char(36) NOT NULL,
  `runby` int(11) NOT NULL,
  `env` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `run`
--

INSERT INTO `run` (`id`, `status`, `createdate`, `testcaseid`, `runby`, `env`) VALUES
('01a76ea7-aa2a-11ec-80ba-001a4a350220', 1, '2022-03-22 17:49:53', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('04a36c20-aa4b-11ec-80ba-001a4a350220', 1, '2022-03-22 21:46:11', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('05084340-aa15-11ec-80ba-001a4a350220', 1, '2022-03-22 15:19:39', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('079de740-aa56-11ec-80ba-001a4a350220', 1, '2022-03-22 23:05:01', '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('07d1502c-aa2a-11ec-80ba-001a4a350220', 1, '2022-03-22 17:50:03', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('07d5eaf0-aa1d-11ec-80ba-001a4a350220', 1, '2022-03-22 16:17:00', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('0d9c8b70-aa4d-11ec-80ba-001a4a350220', 1, '2022-03-22 22:00:45', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('0ddecc9c-a954-11ec-80ba-001a4a350220', 2, '2022-03-21 16:18:21', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('120b87d3-aa4a-11ec-80ba-001a4a350220', 1, '2022-03-22 21:39:24', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('18aed02d-a954-11ec-80ba-001a4a350220', 2, '2022-03-21 16:18:39', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('1a91b909-97cd-11ec-8f7c-001a4a2500e0', 1, '2022-02-27 07:59:31', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('1ae33e61-97cd-11ec-8f7c-001a4a2500e0', 1, '2022-02-27 07:59:31', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('1f91f397-a9f2-11ec-80ba-001a4a350220', 2, '2022-03-22 11:09:51', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('1ffd709c-aa4e-11ec-80ba-001a4a350220', 1, '2022-03-22 22:08:26', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('20ca6a53-aa15-11ec-80ba-001a4a350220', 1, '2022-03-22 15:20:26', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('229b485d-a9e9-11ec-80ba-001a4a350220', 2, '2022-03-22 10:05:31', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('26611d6a-aac8-11ec-80ba-001a4a350220', 1, '2022-03-23 12:41:55', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('2feb8e60-abb1-11ec-80ba-001a4a350220', 1, '2022-03-24 16:30:04', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 1),
('31b732ca-9788-11ec-8f7c-001a4a2500e0', 1, '2022-02-26 23:46:14', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('31f03290-9788-11ec-8f7c-001a4a2500e0', 1, '2022-02-26 23:46:15', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('32f4a6cb-aa4a-11ec-80ba-001a4a350220', 1, '2022-03-22 21:40:20', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('335d67c0-aa0d-11ec-80ba-001a4a350220', 1, '2022-03-22 14:23:41', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('366e763a-a9f2-11ec-80ba-001a4a350220', 2, '2022-03-22 11:10:30', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('382a71c0-aad9-11ec-80ba-001a4a350220', 2, '2022-03-23 14:44:06', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('39ec0613-9776-11ec-8f7c-001a4a2500e0', 1, '2022-02-26 21:37:37', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('3a237073-9776-11ec-8f7c-001a4a2500e0', 1, '2022-02-26 21:37:37', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('3a299c2d-aa4b-11ec-80ba-001a4a350220', 1, '2022-03-22 21:47:41', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('3bf67ec9-a953-11ec-80ba-001a4a350220', 1, '2022-03-21 16:12:29', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('3c6b7f3d-945d-11ec-8f7c-001a4a2500e0', 1, '2022-02-22 23:01:10', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 2),
('3d275d05-9785-11ec-8f7c-001a4a2500e0', 1, '2022-02-26 23:25:05', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('3d3bd72d-9b15-11ec-80ba-001a4a350220', 1, '2022-03-03 12:13:26', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('3dbb560f-9785-11ec-8f7c-001a4a2500e0', 1, '2022-02-26 23:25:06', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('3ff3d67a-aa51-11ec-80ba-001a4a350220', 1, '2022-03-22 22:30:48', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('40282d51-aa53-11ec-80ba-001a4a350220', 1, '2022-03-22 22:45:07', '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('407886b9-aa51-11ec-80ba-001a4a350220', 1, '2022-03-22 22:30:49', 'e09681f4-8b5e-11ec-8f7c-001a4a2500e0', 2, 1),
('42e27004-aa56-11ec-80ba-001a4a350220', 1, '2022-03-22 23:06:40', '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 2),
('4364322a-aa51-11ec-80ba-001a4a350220', 1, '2022-03-22 22:30:54', '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('4392863b-aa51-11ec-80ba-001a4a350220', 1, '2022-03-22 22:30:54', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('459c9ce8-a955-11ec-80ba-001a4a350220', 2, '2022-03-21 16:27:04', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('470605b2-abb2-11ec-80ba-001a4a350220', 1, '2022-03-24 16:37:52', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 1),
('47dd6767-9b15-11ec-80ba-001a4a350220', 1, '2022-03-03 12:13:44', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('4fe49db4-9787-11ec-8f7c-001a4a2500e0', 1, '2022-02-26 23:39:55', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('50258318-9787-11ec-8f7c-001a4a2500e0', 1, '2022-02-26 23:39:56', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('53acae1d-aba3-11ec-80ba-001a4a350220', 2, '2022-03-24 14:50:51', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 1),
('53ffc03c-aa50-11ec-80ba-001a4a350220', 1, '2022-03-22 22:24:12', '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('547fa632-aa4a-11ec-80ba-001a4a350220', 1, '2022-03-22 21:41:16', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('5974e5fa-aa4e-11ec-80ba-001a4a350220', 1, '2022-03-22 22:10:02', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('5a25271c-aaab-11ec-80ba-001a4a350220', 2, '2022-03-23 09:15:47', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('5a7e149f-aaab-11ec-80ba-001a4a350220', 1, '2022-03-23 09:15:47', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('5ba24cd7-aa23-11ec-80ba-001a4a350220', 1, '2022-03-22 17:02:17', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('5c7aa92a-a953-11ec-80ba-001a4a350220', 1, '2022-03-21 16:13:24', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('5cde581c-aa10-11ec-80ba-001a4a350220', 1, '2022-03-22 14:46:19', 'e09681f4-8b5e-11ec-8f7c-001a4a2500e0', 2, 1),
('5d485670-9775-11ec-8f7c-001a4a2500e0', 2, '2022-02-26 21:31:27', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('5d867521-9775-11ec-8f7c-001a4a2500e0', 2, '2022-02-26 21:31:27', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('617ddac5-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:36:10', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('626d55b1-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:36:11', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('63155dc6-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:36:12', 'e09681f4-8b5e-11ec-8f7c-001a4a2500e0', 2, 1),
('63ee19a7-a9ff-11ec-80ba-001a4a350220', 1, '2022-03-22 12:44:49', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('64e6e09a-a9e8-11ec-80ba-001a4a350220', 2, '2022-03-22 10:00:13', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('64f288c7-abac-11ec-80ba-001a4a350220', 1, '2022-03-24 15:55:45', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 1),
('65215c0c-aa5a-11ec-80ba-001a4a350220', 2, '2022-03-22 23:36:16', '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('65529994-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:36:16', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('65960ff1-aaab-11ec-80ba-001a4a350220', 2, '2022-03-23 09:16:06', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('6bd71c63-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:36:27', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('6bf995d7-97d0-11ec-8f7c-001a4a2500e0', 1, '2022-02-27 08:23:16', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('6f480525-aa15-11ec-80ba-001a4a350220', 1, '2022-03-22 15:22:37', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('6f556996-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:36:33', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('708b0389-aaab-11ec-80ba-001a4a350220', 2, '2022-03-23 09:16:24', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('70b9b9fb-a9f2-11ec-80ba-001a4a350220', 2, '2022-03-22 11:12:08', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('7103a187-aa5a-11ec-80ba-001a4a350220', 2, '2022-03-22 23:36:36', '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('7134079e-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:36:36', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('71b8c1e3-aa4d-11ec-80ba-001a4a350220', 1, '2022-03-22 22:03:33', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('747769b5-8f7b-11ec-8f7c-001a4a2500e0', 1, '2022-02-16 17:54:53', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 0, 1),
('74b5fafe-8f7b-11ec-8f7c-001a4a2500e0', 1, '2022-02-16 17:54:54', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 0, 1),
('76b2ad8c-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:36:45', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('787fcc1d-aa56-11ec-80ba-001a4a350220', 1, '2022-03-22 23:08:10', '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 3),
('795be059-98b0-11ec-8f7c-001a4a2500e0', 1, '2022-02-28 11:07:05', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('79978f3b-98b0-11ec-8f7c-001a4a2500e0', 1, '2022-02-28 11:07:06', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('79bc4e31-aab0-11ec-80ba-001a4a350220', 2, '2022-03-23 09:52:27', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('79ef3e60-aab0-11ec-80ba-001a4a350220', 1, '2022-03-23 09:52:27', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('7a738fa3-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:36:51', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('7b55bed3-aaab-11ec-80ba-001a4a350220', 2, '2022-03-23 09:16:42', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('7c1bbf77-aa5a-11ec-80ba-001a4a350220', 2, '2022-03-22 23:36:54', '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('7c23bd0f-aa53-11ec-80ba-001a4a350220', 1, '2022-03-22 22:46:48', '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('7c4b1d62-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:36:55', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('7d31cc78-aac8-11ec-80ba-001a4a350220', 2, '2022-03-23 12:44:21', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('819f7c33-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:37:04', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('8333af90-aab0-11ec-80ba-001a4a350220', 2, '2022-03-23 09:52:43', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('84a80a63-9458-11ec-8f7c-001a4a2500e0', 1, '2022-02-22 22:27:24', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 0, 2),
('863b11a9-aac8-11ec-80ba-001a4a350220', 2, '2022-03-23 12:44:36', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('888cd7a6-aab7-11ec-80ba-001a4a350220', 2, '2022-03-23 10:42:58', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('89266743-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:37:16', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('8ad055e9-aa5a-11ec-80ba-001a4a350220', 2, '2022-03-22 23:37:19', '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('8afd75e3-aa5a-11ec-80ba-001a4a350220', 1, '2022-03-22 23:37:19', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('8b4f6ead-aad8-11ec-80ba-001a4a350220', 2, '2022-03-23 14:39:16', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('8c147c66-aab0-11ec-80ba-001a4a350220', 2, '2022-03-23 09:52:58', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('8cea56fc-aa4d-11ec-80ba-001a4a350220', 1, '2022-03-22 22:04:19', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('8d0836ea-aad9-11ec-80ba-001a4a350220', 1, '2022-03-23 14:46:29', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('8dff9ab8-a9ea-11ec-80ba-001a4a350220', 2, '2022-03-22 10:15:41', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('8f8786f3-aa0d-11ec-80ba-001a4a350220', 1, '2022-03-22 14:26:16', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('8f9fee2a-aac8-11ec-80ba-001a4a350220', 2, '2022-03-23 12:44:52', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('91793f50-aab7-11ec-80ba-001a4a350220', 2, '2022-03-23 10:43:13', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('92e084f2-abaa-11ec-80ba-001a4a350220', 1, '2022-03-24 15:42:43', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 1),
('94d2efd7-aab0-11ec-80ba-001a4a350220', 2, '2022-03-23 09:53:12', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('95d55e12-aa4b-11ec-80ba-001a4a350220', 1, '2022-03-22 21:50:15', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('9863af5b-aac8-11ec-80ba-001a4a350220', 2, '2022-03-23 12:45:06', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('9a486c3d-aab7-11ec-80ba-001a4a350220', 2, '2022-03-23 10:43:28', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('9aaec1f1-a9f7-11ec-80ba-001a4a350220', 2, '2022-03-22 11:49:05', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('9cd5859e-abab-11ec-80ba-001a4a350220', 1, '2022-03-24 15:50:10', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 1),
('9e81ed0f-97d1-11ec-8f7c-001a4a2500e0', 1, '2022-02-27 08:31:50', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('9eaedbd6-97d1-11ec-8f7c-001a4a2500e0', 1, '2022-02-27 08:31:50', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('a00de696-a952-11ec-80ba-001a4a350220', 2, '2022-03-21 16:08:07', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('a12aaa90-a952-11ec-80ba-001a4a350220', 1, '2022-03-21 16:08:09', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('a339c530-aab7-11ec-80ba-001a4a350220', 2, '2022-03-23 10:43:43', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('a3e84364-abb3-11ec-80ba-001a4a350220', 1, '2022-03-24 16:47:37', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 1),
('a6bf0503-97ce-11ec-8f7c-001a4a2500e0', 1, '2022-02-27 08:10:35', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('a845cf4b-a9e9-11ec-80ba-001a4a350220', 1, '2022-03-22 10:09:15', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('afe9d888-aa4d-11ec-80ba-001a4a350220', 1, '2022-03-22 22:05:18', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('b8345ce9-aab2-11ec-80ba-001a4a350220', 2, '2022-03-23 10:08:31', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('b8ab8079-aab2-11ec-80ba-001a4a350220', 1, '2022-03-23 10:08:32', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('bd01d1ac-a952-11ec-80ba-001a4a350220', 2, '2022-03-21 16:08:56', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('bdbe38fd-a952-11ec-80ba-001a4a350220', 1, '2022-03-21 16:08:57', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('c114edac-a954-11ec-80ba-001a4a350220', 2, '2022-03-21 16:23:22', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('c2e61da6-aab2-11ec-80ba-001a4a350220', 2, '2022-03-23 10:08:49', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('c8e67a94-abb0-11ec-80ba-001a4a350220', 1, '2022-03-24 16:27:11', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 1),
('c91910cf-a954-11ec-80ba-001a4a350220', 1, '2022-03-21 16:23:35', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('ca64d006-aa51-11ec-80ba-001a4a350220', 1, '2022-03-22 22:34:40', '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('cc34a674-aab2-11ec-80ba-001a4a350220', 2, '2022-03-23 10:09:04', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('cc7656ef-aba5-11ec-80ba-001a4a350220', 1, '2022-03-24 15:08:32', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 1),
('cfbe2fa7-a953-11ec-80ba-001a4a350220', 1, '2022-03-21 16:16:37', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('d632eb25-a9e9-11ec-80ba-001a4a350220', 2, '2022-03-22 10:10:32', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('d6984b77-aab2-11ec-80ba-001a4a350220', 2, '2022-03-23 10:09:22', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('d8755a08-aa0d-11ec-80ba-001a4a350220', 2, '2022-03-22 14:28:18', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('da81debd-aa0d-11ec-80ba-001a4a350220', 1, '2022-03-22 14:28:21', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('db4b0bf5-aa0d-11ec-80ba-001a4a350220', 1, '2022-03-22 14:28:23', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('db837d3a-aa1a-11ec-80ba-001a4a350220', 1, '2022-03-22 16:01:27', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('dbd4347a-aa0f-11ec-80ba-001a4a350220', 2, '2022-03-22 14:42:43', 'e09681f4-8b5e-11ec-8f7c-001a4a2500e0', 2, 1),
('dd48b53a-a402-11ec-80ba-001a4a350220', 1, '2022-03-14 21:54:35', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 2),
('de6d0804-9775-11ec-8f7c-001a4a2500e0', 1, '2022-02-26 21:35:04', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('dea7ffe4-9775-11ec-8f7c-001a4a2500e0', 1, '2022-02-26 21:35:04', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 1),
('dfae0600-a953-11ec-80ba-001a4a350220', 1, '2022-03-21 16:17:04', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 1),
('e9852eaa-97d0-11ec-8f7c-001a4a2500e0', 1, '2022-02-27 08:26:46', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('ea337788-aba4-11ec-80ba-001a4a350220', 1, '2022-03-24 15:02:13', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 1),
('ed147bec-aa4d-11ec-80ba-001a4a350220', 1, '2022-03-22 22:07:00', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('f124790d-aa29-11ec-80ba-001a4a350220', 2, '2022-03-22 17:49:25', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1),
('f36a04f5-aa4a-11ec-80ba-001a4a350220', 1, '2022-03-22 21:45:42', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 1),
('fe86736a-a9f1-11ec-80ba-001a4a350220', 2, '2022-03-22 11:08:56', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 1);

--
-- Triggers `run`
--
DELIMITER $$
CREATE TRIGGER `before_insert_run` BEFORE INSERT ON `run` FOR EACH ROW BEGIN
  IF new.id IS NULL  OR new.id = ''  THEN
    SET new.id = uuid();
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `runstatus`
--

CREATE TABLE `runstatus` (
  `id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `runstatus`
--

INSERT INTO `runstatus` (`id`, `status`) VALUES
(0, 'NOT RUN'),
(1, 'PASSED'),
(2, 'INCOMPLETE'),
(3, 'FAILED');

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `id` char(36) NOT NULL,
  `desc` varchar(5000) NOT NULL,
  `steporder` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `element` char(36) DEFAULT NULL,
  `input1` mediumtext,
  `input2` mediumtext,
  `testcaseid` char(36) NOT NULL,
  `steps_userid` int(11) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `steps`
--

INSERT INTO `steps` (`id`, `desc`, `steporder`, `action`, `element`, `input1`, `input2`, `testcaseid`, `steps_userid`, `approved`) VALUES
('0824767b-ab86-11ec-80ba-001a4a350220', 'Click to Skip Illustration', 41, 604, 'f85ced34-ab85-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('0eab0ac4-8b66-11ec-8f7c-001a4a2500e0', 'verify variable NOT contains', 12, 504, NULL, '%NewClientID%', 'hello', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 0),
('0f1fa084-8b61-11ec-8f7c-001a4a2500e0', 'verify reponse did not contains error', 9, 109, NULL, 'error', NULL, 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 0),
('0f789b37-ab7c-11ec-80ba-001a4a350220', 'Enter FP code', 18, 601, '05e40187-ab7c-11ec-80ba-001a4a350220', '%FPCode%', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('1421e36f-8dd7-11ec-8f7c-001a4a2500e0', 'Verify response status 200', 3, 108, NULL, '200', NULL, 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 0),
('15ec3eda-88ea-11ec-8f7c-001a4a2500e0', 'send post API', 2, 102, NULL, 'POST', '%ClientAPIEndpoint%/clients', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 0),
('18575f0c-ab7d-11ec-80ba-001a4a350220', 'Click to First AccountPrefix found', 25, 604, '107c05aa-ab7d-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('1c1dc3f6-ab77-11ec-80ba-001a4a350220', 'Enter LastName using the same clientName', 10, 601, '0b8f4805-ab77-11ec-80ba-001a4a350220', '#clientName#', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('1e95e60c-8b61-11ec-8f7c-001a4a2500e0', 'Verify 12567894 exist in response', 10, 105, NULL, '125', NULL, 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 0),
('21d20104-8dcc-11ec-8f7c-001a4a2500e0', 'Set up header and pageload', 1, 101, NULL, 'client_id=%clientid%,client_secret=%client_secret%,Content-Type=application/json', '{\r\n	\"clientId\": null,\r\n	\"personName\": {\r\n		\"firstName\": \"25aaaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"lastName\": \"30aaaaaaaaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"middleInitial\": \"D\",\r\n		\"prefix\": \"10aaaaaaaa\",\r\n		\"suffix\": \"4aaa\"\r\n	},\r\n	\"financialProfessional\": [\r\n		{\r\n			\"code\": \"10aaaaaaaa\",\r\n			\"description\": \"financialProfessional description\",\r\n			\"isPrimary\": true\r\n		}\r\n	],\r\n	\"dateOfBirth\": \"1989-05-13\",\r\n	\"dateOfDeath\": \"2022-03-21\",\r\n	\"isDeceased\": true,\r\n	\"maritalStatus\": {\r\n		\"code\": \"1\",\r\n		\"description\": \"married\"\r\n	},\r\n	\"citizenship\": {\r\n		\"code\": \"1\",\r\n		\"description\": \"USA\"\r\n	},\r\n	\"countryOfCitizenship\": {\r\n		\"code\": \"1\",\r\n		\"description\": \"USA\"\r\n	},\r\n	\"ssnOrTin\": null,\r\n	\"ssnType\": \"S\",\r\n	\"companyName\": \"50aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\",\r\n	\"legalAddress\": {\r\n		\"street1\": \"40aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"street2\": \"40aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"city\": \"25aaaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"state\": \"IA\",\r\n		\"zip\": \"10aaaaaaaa\",\r\n		\"country\": {\r\n			\"code\": \"USA\",\r\n			\"description\": \"USA\"\r\n		}\r\n	},\r\n	\"mailingAddress\": {\r\n		\"street1\": \"40Maaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"street2\": \"40Maaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"city\": \"25Maaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"state\": \"IA\",\r\n		\"zip\": \"10Maaaaaaa\",\r\n		\"country\": {\r\n			\"code\": \"1\",\r\n			\"description\": \"USA\"\r\n		}\r\n	},\r\n	\"contactInformation\": {\r\n		\"homePhone\": \"25Paaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"workPhone\": \"25Paaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"email\": \"256aaaaaFEJYArOqpdV3sTIEUahN7L34Z7ZpQeB1nAZcRhLtPs91pnx2nJj7Br8NKVEGbCQylqENqGNRXTz8f4cSEJjJbZkRiZhGkcW1484qrCrB5ya0bxIeWYo5HhjeMCJFtKLo03vD0deVHBru0viYxvngiEBzGsSyTT58nsNpcJ3fGeJVnl8LOmkpedQW0fd089kEnZeRwHYfRmW0XRwwkLXAR570zMvlm9YYA7ZDo2ZrERc1ig0@cir2.com\"\r\n	},\r\n    \"employmentStatus\":{\r\n        \"code\":5,\r\n        \"description\":\"EMPLOYED\"\r\n    },\r\n	\"createdId\": \"8aaaaaaa\",\r\n	\"createdDate\": \"2022-03-21T00:00:00Z\",\r\n	\"externalPartner\": {\r\n		\"externalClientId\": \"50exaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"partnerName\": \"12aaaaaaaaaa\"\r\n	},\r\n	\"lastModifiedDate\": \"2022-03-21T00:00:00Z\",\r\n	\"lastModifiedById\": \"8aaaaaaa\",\r\n	\"affiliation\": {\r\n		\"brokerDealerOrMunicipalSecuritiesDealerIndicator\": false,\r\n		\"politicalAffiliationAuthority\": false,\r\n		\"politicalAffiliationHire\": false,\r\n		\"finraIndicator\": false,\r\n		\"foreignAffiliationCountry\": {\r\n			\"code\": \"1\",\r\n			\"description\": \"Mexico\"\r\n		},\r\n		\"foreignAffiliationIndicator\": \"0\",\r\n		\"firmAffiliationIndicator\": \"1\",\r\n		\"firmAffiliationName\": \"40Faaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"politicalAffiliationNone\": false,\r\n		\"politicalAffiliationIndicator\": \"1\",\r\n		\"directorAffiliationIndicator\": \"1\",\r\n		\"directorAffiliationName\": \"40Daaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"riaIndicator\": false,\r\n		\"securitiesRegulatorIndicator\": false\r\n	},\r\n	\"usaPatriotActInformation\": {\r\n		\"type\": {\r\n			\"code\": 0,\r\n			\"description\": \"m2PvEtVZrNIWiMkrtTQIkurd25BG8uQt1VQ9wCHL8jWtyGFLTs\"\r\n		},\r\n		\"alreadyOnFile\": false,\r\n		\"reason\": \"iCZYBF5jRTNqHA3VYI88MlS4brfIxAbJsK76ro6ZgOMAmLzRvt8uLZzT2w15bXYSCMXz3uFxVe09Vx6Zz76JnChT13cjW2lhgawE\",\r\n		\"documentApplicable\": false,\r\n		\"documentNumber\": \"15aaaaaaaaaaaaa\",\r\n		\"expirationDate\": \"2024-12-15\",\r\n		\"isNonDocumentaryTermsAccepted\": false,\r\n		\"issueDate\": \"2022-03-21\",\r\n		\"otherDocumentDescription\": \"50otaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"placeOfIssuance\": \"40Paaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\",\r\n		\"stateCode\": \"TX\"\r\n	},\r\n	\"suitability\": {\r\n		\"startDate\": \"2022-01-07T00:00:00Z\",\r\n		\"endDate\": \"2022-01-07T00:00:00Z\",\r\n		\"status\": {\r\n			\"code\": 0,\r\n			\"description\": \"\"\r\n		},\r\n		\"annualIncome\": {\r\n			\"code\": 0,\r\n			\"description\": \"\",\r\n			\"totalAnnualIncome\": 0\r\n		},\r\n		\"netWorth\": {\r\n			\"code\": 0,\r\n			\"description\": \"\"\r\n		},\r\n		\"taxBracket\": {\r\n			\"code\": 0,\r\n			\"description\": \"\"\r\n		},\r\n		\"knowYourCustomer\": {\r\n			\"noOutsideExperience\": false,\r\n			\"stocksCurrentHoldingsAmount\": 0,\r\n			\"bondsCurrentHoldingsAmount\": 0,\r\n			\"optionsCurrentHoldingsAmount\": 0,\r\n			\"commoditiesCurrentHoldingsAmount\": 0,\r\n			\"realEstateCurrentHoldingsAmount\": 0,\r\n			\"mutualFundsCurrentHoldingsAmount\": 0,\r\n			\"insAnnuitiesCurrentHoldingsAmount\": 0,\r\n			\"reit_Dpp_LpCurrentHoldingsAmount\": 0,\r\n			\"otherCurrentHoldingsAmount\": 0,\r\n			\"intervalFundsAmount\": 0,\r\n			\"unspecifiedAmount\": 0,\r\n			\"liquidityAnnualAmount\": 0,\r\n			\"liquiditySpecialAmount\": 0,\r\n			\"specialExpensesTimeFrame\": \"\"\r\n		},\r\n		\"outsideAssets\": false,\r\n		\"liquidNetWorth\": 125000,\r\n		\"cashBankProductsAmount\": 234500,\r\n		\"totalNetWorth\": 650000,\r\n		\"netWorthMinimumAmount\": 10000,\r\n		\"netWorthMaximumAmount\": 100000000,\r\n		\"stocks\": \"Stocks\",\r\n		\"bonds\": \"Bonds\",\r\n		\"options\": \"Options\",\r\n		\"commodities\": \"Commodities\",\r\n		\"realEstate\": \"Real Estate\",\r\n		\"mutualFunds\": \"Mutual Fund\",\r\n		\"insuranceAnnuities\": \"Annuity\",\r\n		\"other\": \"Google\",\r\n		\"otherName\": \"Bing\"\r\n	}\r\n}', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 0),
('223693dc-8b72-11ec-8f7c-001a4a2500e0', 'Save  value to variable', 4, 502, NULL, '0:4', '%middlename%', 'e09681f4-8b5e-11ec-8f7c-001a4a2500e0', 2, 0),
('2272a406-ab75-11ec-80ba-001a4a350220', 'Navigate to skienceone salesforce url', 1, 600, NULL, '%sk1SalesforceUrl%', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('2a0ddbec-ab76-11ec-80ba-001a4a350220', 'Create a new client by clicking new button', 7, 604, '231c2d06-ab76-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('31427a68-88ea-11ec-8f7c-001a4a2500e0', 'Verify API response status', 3, 108, NULL, '200', NULL, 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 0),
('379cde16-ab89-11ec-80ba-001a4a350220', 'Set up the connection string', 43, 201, NULL, '%Wealthportcnnstring%', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('3b26d028-ab91-11ec-80ba-001a4a350220', 'Execute query to verify ACS Request', 53, 202, NULL, '#Getacslogquery#=\'#requestId#\'', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('3eef674e-ab92-11ec-80ba-001a4a350220', 'Verify the response contains SuccessResult', 54, 205, NULL, '0:3', 'SuccessResult', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('45c15ef2-ab86-11ec-80ba-001a4a350220', 'Click to Generate Documents', 44, 604, '344f7dd2-ab86-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('48011485-ab7c-11ec-80ba-001a4a350220', 'Click to first FP found', 21, 604, '41e81447-ab7c-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('4b01eda5-aa14-11ec-80ba-001a4a350220', 'verify local variables testvalue contains 123', 3, 503, NULL, '#testvalue#', '123', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 0),
('4b5a388f-8f43-11ec-8f7c-001a4a2500e0', 'Verify response status 400', 3, 108, NULL, '400', NULL, '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 0),
('4b5a4165-8f43-11ec-8f7c-001a4a2500e0', 'Set up header and pageload', 1, 101, NULL, 'client_id=%clientid%,client_secret=%client_secret%,Content-Type=application/json', '{\r\n  \r\n} \r\n', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 0),
('4b5a4ff8-8f43-11ec-8f7c-001a4a2500e0', 'submit post api', 2, 102, NULL, 'POST', '%ClientAPIEndpoint%/clients', '4b597ce6-8f43-11ec-8f7c-001a4a2500e0', 2, 0),
('4dba220b-ab78-11ec-80ba-001a4a350220', 'Click Open New Account Button', 12, 604, '45668e44-ab78-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('50f6461b-ab84-11ec-80ba-001a4a350220', 'Click to Skip Risk tolerance', 29, 604, '92c628af-ab80-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('519fdfcb-ab77-11ec-80ba-001a4a350220', 'Click to Save button', 11, 604, '4e961d48-ab77-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('533ea932-ab80-11ec-80ba-001a4a350220', 'Click to Skip', 28, 604, '28268ab9-ab7f-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('55a553b2-ab90-11ec-80ba-001a4a350220', 'Verify dollarAmount', 49, 205, NULL, '0:2', '<dollarAmount>#expectedamount#</dollarAmount>', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('562893f4-aa14-11ec-80ba-001a4a350220', 'verify RM variables testvalue contains 123', 4, 503, NULL, '%testvalue%', '123', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 0),
('5f7961fd-ab7e-11ec-80ba-001a4a350220', 'Click to Add buton', 26, 604, '5c0ccc0a-ab7e-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('6062952e-aa53-11ec-80ba-001a4a350220', 'Verify title contains CAAP Database', 3, 700, NULL, 'CAAP Database', NULL, '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('60c27e42-ab8d-11ec-80ba-001a4a350220', 'Verify query results have validate = 1', 47, 205, NULL, '0:2', '<isValidateOnly>1</isValidateOnly>', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('61decfb2-ab84-11ec-80ba-001a4a350220', 'Click to Risk tolerance Moderate', 30, 604, 'c214fa29-ab80-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('63d668d7-abb0-11ec-80ba-001a4a350220', 'wait for Ski1.AddFinancialaccounts.NextBtn enable', 15, 607, 'eab32496-ab79-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('641bc77f-ab88-11ec-80ba-001a4a350220', 'Verify Green Message contains', 42, 701, '39cb9b95-ab88-11ec-80ba-001a4a350220', 'You have associated proposal', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('653f338c-ab89-11ec-80ba-001a4a350220', 'Execute query to find latest IPS Request', 45, 202, NULL, '#Getlatestipsquery#', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('673bc3a8-aa14-11ec-80ba-001a4a350220', 'verify local variables testvalue NOT contains 567', 5, 504, NULL, '#testvalue#', '567', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 0),
('6e26765c-ab75-11ec-80ba-001a4a350220', 'Enter email', 2, 601, '4ec47efe-ab75-11ec-80ba-001a4a350220', '%fpemail%', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('6fb2d1eb-aa14-11ec-80ba-001a4a350220', 'verify RM variables testvalue NOT contains 567', 6, 504, NULL, '%testvalue%', '567', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 0),
('72e46b39-ab7a-11ec-80ba-001a4a350220', 'Enter Registration Type', 16, 601, '6791423a-ab7a-11ec-80ba-001a4a350220', '#Regtype#', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('74f5c6eb-ab84-11ec-80ba-001a4a350220', 'Click to 2-5 years', 31, 604, 'e4cbb86b-ab80-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('7512d760-8ab8-11ec-8f7c-001a4a2500e0', 'Verify ClientId have no error', 4, 106, NULL, 'data.Identifier.clientId', '12567894', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 0),
('7d09b4a0-8b77-11ec-8f7c-001a4a2500e0', 'set var', 13, 505, NULL, '%var%', '%Randomi10%', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 0),
('809712fe-ab85-11ec-80ba-001a4a350220', 'Click to AmericanFunds', 35, 604, '259154c6-ab85-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('81300356-ab87-11ec-80ba-001a4a350220', 'Wait for the close button to enable', 36, 606, NULL, '10', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('8257d5cc-ab84-11ec-80ba-001a4a350220', 'Click to continue', 32, 604, '72474a8d-ab81-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('8a2eacde-ab75-11ec-80ba-001a4a350220', 'Enter password', 3, 601, '82ca0c8d-ab75-11ec-80ba-001a4a350220', '%fppassword%', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('8fbeb19f-ab7b-11ec-80ba-001a4a350220', 'Enter Account Management Type', 18, 601, '85b6b5af-ab7b-11ec-80ba-001a4a350220', '#AccountType#', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('92592c76-ab86-11ec-80ba-001a4a350220', 'Click Continue Account Open', 46, 604, '71cdbcc9-ab86-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('97d19f56-ab8f-11ec-80ba-001a4a350220', 'Verify Fristname', 48, 205, NULL, '0:2', '<lastName>#Clientname#</lastName>', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('9808aeaa-ab85-11ec-80ba-001a4a350220', 'Click to AmericanFunds - Moderate Growth and Income Model', 36, 604, '5b28a9a5-ab85-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('9e42ae18-ab84-11ec-80ba-001a4a350220', 'Enter Expected Ammount', 33, 601, '83b400f7-ab81-11ec-80ba-001a4a350220', '#Expectedamount#', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('a32f77ae-ab87-11ec-80ba-001a4a350220', 'Verify The workflow is locked', 36, 701, '463ac1d6-ab87-11ec-80ba-001a4a350220', 'This workflow is locked.', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('a712da02-ab75-11ec-80ba-001a4a350220', 'Click Next button', 4, 604, 'a28b5b61-ab75-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('b15c8b2d-ab87-11ec-80ba-001a4a350220', 'Click to Close button', 37, 604, '5c035127-ab87-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('c85620da-ab7d-11ec-80ba-001a4a350220', 'Click to Frist Reg Type result', 17, 604, '66b3a275-ab7d-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('cbc7f5a3-ab79-11ec-80ba-001a4a350220', 'Switch to iframe using id = vueFrame', 14, 610, NULL, 'vueFrame', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('cf9417eb-ab84-11ec-80ba-001a4a350220', 'Click to Select strategies btn', 34, 604, 'b6078927-ab84-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('d00d7462-8b60-11ec-8f7c-001a4a2500e0', 'Verify Json path regrex check', 7, 110, NULL, 'data.Identifier.clientId', '^[0-9]{8}$', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 0),
('d201a543-ab75-11ec-80ba-001a4a350220', 'Verify title home page', 5, 700, NULL, 'Home | Salesforce', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('d3994ba8-ab8f-11ec-80ba-001a4a350220', 'Verify Lastname', 50, 205, NULL, '0:2', '<lastName>#Clientname#</lastName>', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('d95233f3-ab7d-11ec-80ba-001a4a350220', 'Click to Account Management Type first result', 22, 604, '7c3a07b1-ab7d-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('dc2dc513-ab85-11ec-80ba-001a4a350220', 'Click to Save Account', 37, 604, 'c4e05617-ab85-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('dd6233af-aa13-11ec-80ba-001a4a350220', 'Assign a value to var RM testvalue', 2, 505, NULL, '%testvalue%', '123456', '71d0cec0-aa11-11ec-80ba-001a4a350220', 2, 0),
('e01825ad-ab76-11ec-80ba-001a4a350220', 'Enter Firstname using clientname variables', 9, 601, 'd7358d53-ab76-11ec-80ba-001a4a350220', '#clientName#', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('e0976109-8b5e-11ec-8f7c-001a4a2500e0', 'Verify Midle Name = A', 3, 204, NULL, '0:4', 'A', 'e09681f4-8b5e-11ec-8f7c-001a4a2500e0', 2, 0),
('e097721c-8b5e-11ec-8f7c-001a4a2500e0', 'Set up DB connection', 1, 201, NULL, '%DBConnection%', NULL, 'e09681f4-8b5e-11ec-8f7c-001a4a2500e0', 2, 0),
('e0981417-8b5e-11ec-8f7c-001a4a2500e0', 'Execute query', 2, 202, NULL, 'select * from Clients where ClientID = \'%ClientID2%\'', NULL, 'e09681f4-8b5e-11ec-8f7c-001a4a2500e0', 2, 0),
('e1424ad1-ab8f-11ec-80ba-001a4a350220', 'Verify registration', 51, 205, NULL, '0:2', '<registration>#Regtype#</registration>', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('e246812a-ab7b-11ec-80ba-001a4a350220', 'Enter ProgramType', 23, 601, 'd81f55d1-ab7b-11ec-80ba-001a4a350220', '#ProgramType#', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('e6831255-aa4e-11ec-80ba-001a4a350220', 'sleep 1 second', 2, 606, NULL, '1', NULL, '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('e6f728fe-ab7e-11ec-80ba-001a4a350220', 'Switch to Proposal iframe', 27, 6101, NULL, '0', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('e81f4911-8dd6-11ec-8f7c-001a4a2500e0', 'submit post api', 2, 102, NULL, 'POST', '%ClientAPIEndpoint%/clients', 'ffad1329-8dbc-11ec-8f7c-001a4a2500e0', 2, 0),
('e8e98cc4-ab7d-11ec-80ba-001a4a350220', 'Click to ProgramType first Result', 17, 604, 'a4bf3519-ab7d-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('ecabb95b-88e9-11ec-8f7c-001a4a2500e0', 'Set up page load and header', 1, 101, NULL, 'client_id=%clientid%,client_secret=%client_secret%,Content-Type=application/json', '{\r\n	\"clientId\": null,\r\n	\"personName\": {\r\n		\"firstName\": \"JohnSSND\",\r\n		\"lastName\": \"Smith\",\r\n		\"middleInitial\": \"\",\r\n		\"prefix\": \"Mr.\",\r\n		\"suffix\": \"Jr\"\r\n	},\r\n	\"financialProfessional\": [\r\n		{\r\n			\"code\": \"WAP\",\r\n			\"description\": \"financialProfessional description\",\r\n			\"isPrimary\": true\r\n		}\r\n	],\r\n	\"dateOfBirth\": \"1989-05-13\",\r\n	\"dateOfDeath\": \"2022-03-21\",\r\n	\"isDeceased\": true,\r\n	\"maritalStatus\": {\r\n		\"code\": \"1\",\r\n		\"description\": \"married\"\r\n	},\r\n	\"citizenship\": {\r\n		\"code\": \"1\",\r\n		\"description\": \"USA\"\r\n	},\r\n	\"countryOfCitizenship\": {\r\n		\"code\": \"1\",\r\n		\"description\": \"USA\"\r\n	},\r\n	\"ssnOrTin\": \"D23456789\",\r\n	\"ssnType\": \"S\",\r\n	\"companyName\": \"Abc Compagny\",\r\n	\"legalAddress\": {\r\n		\"street1\": \"1680 IA-1\",\r\n		\"street2\": \"null\",\r\n		\"city\": \"Fairfield\",\r\n		\"state\": \"IA\",\r\n		\"zip\": \"52556\",\r\n		\"country\": {\r\n			\"code\": \"1\",\r\n			\"description\": \"USA\"\r\n		}\r\n	},\r\n	\"mailingAddress\": {\r\n		\"street1\": \"1776 Pleasant Plain Road\",\r\n		\"street2\": \"null\",\r\n		\"city\": \"Fairfield\",\r\n		\"state\": \"IA\",\r\n		\"zip\": \"52556-8757\",\r\n		\"country\": {\r\n			\"code\": \"1\",\r\n			\"description\": \"USA\"\r\n		}\r\n	},\r\n	\"contactInformation\": {\r\n		\"homePhone\": \"8776882369\",\r\n		\"workPhone\": \"8007776080\",\r\n		\"email\": \"luat.do@cir2.com\"\r\n	},\r\n    \"employmentStatus\":{\r\n        \"code\":5,\r\n        \"description\":\"EMPLOYED\"\r\n    },\r\n	\"createdId\": \"WAP\",\r\n	\"createdDate\": \"2022-03-21T00:00:00Z\",\r\n	\"externalPartner\": {\r\n		\"externalClientId\": \"ski-1234\",\r\n		\"partnerName\": \"SkienceOne\"\r\n	},\r\n	\"lastModifiedDate\": \"2022-03-21T00:00:00Z\",\r\n	\"lastModifiedById\": \"WAP\",\r\n	\"affiliation\": {\r\n		\"brokerDealerOrMunicipalSecuritiesDealerIndicator\": false,\r\n		\"politicalAffiliationAuthority\": false,\r\n		\"politicalAffiliationHire\": false,\r\n		\"finraIndicator\": false,\r\n		\"foreignAffiliationCountry\": {\r\n			\"code\": \"1\",\r\n			\"description\": \"Mexico\"\r\n		},\r\n		\"foreignAffiliationIndicator\": \"0\",\r\n		\"firmAffiliationIndicator\": \"1\",\r\n		\"firmAffiliationName\": \"ABC TRUST\",\r\n		\"politicalAffiliationNone\": false,\r\n		\"politicalAffiliationIndicator\": \"1\",\r\n		\"directorAffiliationIndicator\": \"1\",\r\n		\"directorAffiliationName\": \"Director Nguyen\",\r\n		\"riaIndicator\": false,\r\n		\"securitiesRegulatorIndicator\": false\r\n	},\r\n	\"usaPatriotActInformation\": {\r\n		\"type\": {\r\n			\"code\": 0,\r\n			\"description\": \"description\"\r\n		},\r\n		\"alreadyOnFile\": false,\r\n		\"reason\": \"I do not know\",\r\n		\"documentApplicable\": false,\r\n		\"documentNumber\": \"123\",\r\n		\"expirationDate\": \"2024-12-15\",\r\n		\"isNonDocumentaryTermsAccepted\": false,\r\n		\"issueDate\": \"2022-03-21\",\r\n		\"otherDocumentDescription\": \"other description\",\r\n		\"placeOfIssuance\": \"who know\",\r\n		\"stateCode\": \"TX\"\r\n	},\r\n	\"suitability\": {\r\n		\"startDate\": \"2022-01-07T00:00:00Z\",\r\n		\"endDate\": \"2022-01-07T00:00:00Z\",\r\n		\"status\": {\r\n			\"code\": 0,\r\n			\"description\": \"\"\r\n		},\r\n		\"annualIncome\": {\r\n			\"code\": 0,\r\n			\"description\": \"\",\r\n			\"totalAnnualIncome\": 0\r\n		},\r\n		\"netWorth\": {\r\n			\"code\": 0,\r\n			\"description\": \"\"\r\n		},\r\n		\"taxBracket\": {\r\n			\"code\": 0,\r\n			\"description\": \"\"\r\n		},\r\n		\"knowYourCustomer\": {\r\n			\"noOutsideExperience\": false,\r\n			\"stocksCurrentHoldingsAmount\": 0,\r\n			\"bondsCurrentHoldingsAmount\": 0,\r\n			\"optionsCurrentHoldingsAmount\": 0,\r\n			\"commoditiesCurrentHoldingsAmount\": 0,\r\n			\"realEstateCurrentHoldingsAmount\": 0,\r\n			\"mutualFundsCurrentHoldingsAmount\": 0,\r\n			\"insAnnuitiesCurrentHoldingsAmount\": 0,\r\n			\"reit_Dpp_LpCurrentHoldingsAmount\": 0,\r\n			\"otherCurrentHoldingsAmount\": 0,\r\n			\"intervalFundsAmount\": 0,\r\n			\"unspecifiedAmount\": 0,\r\n			\"liquidityAnnualAmount\": 0,\r\n			\"liquiditySpecialAmount\": 0,\r\n			\"specialExpensesTimeFrame\": \"\"\r\n		},\r\n		\"outsideAssets\": false,\r\n		\"liquidNetWorth\": 125000,\r\n		\"cashBankProductsAmount\": 234500,\r\n		\"totalNetWorth\": 650000,\r\n		\"netWorthMinimumAmount\": 10000,\r\n		\"netWorthMaximumAmount\": 100000000,\r\n		\"stocks\": \"Stocks\",\r\n		\"bonds\": \"Bonds\",\r\n		\"options\": \"Options\",\r\n		\"commodities\": \"Commodities\",\r\n		\"realEstate\": \"Real Estate\",\r\n		\"mutualFunds\": \"Mutual Fund\",\r\n		\"insuranceAnnuities\": \"Annuity\",\r\n		\"other\": \"Google\",\r\n		\"otherName\": \"Bing\"\r\n	}\r\n}', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 0),
('ee5632f7-aba1-11ec-80ba-001a4a350220', 'Sleep', 6, 606, '231c2d06-ab76-11ec-80ba-001a4a350220', '5', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('ef095f27-ab7c-11ec-80ba-001a4a350220', 'Enter Account Prefix', 24, 601, 'e3ab6f0e-ab7c-11ec-80ba-001a4a350220', '#Accountprefix#', NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('ef756c38-ab79-11ec-80ba-001a4a350220', 'Click Next button', 16, 605, 'eab32496-ab79-11ec-80ba-001a4a350220', NULL, NULL, 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('efca4ffd-aa4b-11ec-80ba-001a4a350220', 'Navigate to DBCAAP using luat.do', 1, 616, NULL, 'http://luat.do:%luatpassword%@#dbcaap#/', NULL, '0a5f7304-aa49-11ec-80ba-001a4a350220', 2, 1),
('f161eb4d-ab91-11ec-80ba-001a4a350220', 'Verify Save IPS id to variables', 52, 502, NULL, '0:1', '#requestId#', 'fdae3080-ab74-11ec-80ba-001a4a350220', 2, 0),
('f6f501a7-8b5f-11ec-8f7c-001a4a2500e0', 'save response to variable', 5, 501, NULL, 'data.Identifier.clientId', '%NewClientID%', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 0),
('f710bd38-8b60-11ec-8f7c-001a4a2500e0', 'verify json not contains', 8, 107, NULL, 'data.Identifier.clientId', 'ABC', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 0),
('ff64548b-8b65-11ec-8f7c-001a4a2500e0', 'verify variable contains', 11, 503, NULL, '%NewClientID%', '8', 'b8505e36-88e9-11ec-8f7c-001a4a2500e0', 2, 0);

--
-- Triggers `steps`
--
DELIMITER $$
CREATE TRIGGER `before_insert_steps` BEFORE INSERT ON `steps` FOR EACH ROW BEGIN
  IF new.id IS NULL  OR new.id = ''  THEN
    SET new.id = uuid();
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tcstatus`
--

CREATE TABLE `tcstatus` (
  `id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tcstatus`
--

INSERT INTO `tcstatus` (`id`, `status`) VALUES
(1, 'New'),
(2, 'Ready'),
(3, 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `teamid` char(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `teams_userid` int(11) NOT NULL,
  `createdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastchange` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`teamid`, `name`, `teams_userid`, `createdate`, `lastchange`) VALUES
('27604c5f-8896-11ec-8f7c-001a4a2500e0', 'CAS', 1, '2022-02-07 23:18:22', NULL),
('a5b788ea-8b84-11ec-8f7c-001a4a2500e0', 'FPOM', 1, '2022-02-11 16:50:37', NULL);

--
-- Triggers `teams`
--
DELIMITER $$
CREATE TRIGGER `before_insert_teams` BEFORE INSERT ON `teams` FOR EACH ROW BEGIN
  IF new.teamid IS NULL  OR new.teamid = '' THEN
    SET new.teamid = uuid();
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `testcases`
--

CREATE TABLE `testcases` (
  `id` char(36) NOT NULL,
  `tfsid` varchar(10) NOT NULL,
  `name` varchar(500) NOT NULL,
  `teamid` char(36) NOT NULL,
  `status` int(11) NOT NULL,
  `testcases_userid` int(11) NOT NULL,
  `createdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastupdate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `ui` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `testcases`
--

INSERT INTO `testcases` (`id`, `tfsid`, `name`, `teamid`, `status`, `testcases_userid`, `createdate`, `lastupdate`, `ui`) VALUES
('0a5f7304-aa49-11ec-80ba-001a4a350220', '352791', 'Demo UI Test', '27604c5f-8896-11ec-8f7c-001a4a2500e0', 3, 2, '2022-03-22 21:31:46', '2022-03-22 23:06:17', b'1'),
('2eb7d570-8b85-11ec-8f7c-001a4a2500e0', '12345', 'APIRepv2WithOverallStatusFilter(\"Active\")', 'a5b788ea-8b84-11ec-8f7c-001a4a2500e0', 1, 3, '2022-02-11 16:53:17', '2022-02-11 16:53:17', b'0'),
('4b597ce6-8f43-11ec-8f7c-001a4a2500e0', '339204', 'Verify that the failure response is received and logs have proper log entries once api/clients POST API is sent using invalid payload.', '27604c5f-8896-11ec-8f7c-001a4a2500e0', 2, 2, '2022-02-14 12:38:37', '2022-03-22 10:07:29', b'0'),
('71d0cec0-aa11-11ec-80ba-001a4a350220', '352790', 'Demo test variables', '27604c5f-8896-11ec-8f7c-001a4a2500e0', 2, 2, '2022-03-22 14:53:12', '2022-03-22 22:37:18', b'0'),
('b8505e36-88e9-11ec-8f7c-001a4a2500e0', '352788', 'Demo test api', '27604c5f-8896-11ec-8f7c-001a4a2500e0', 2, 2, '2022-02-08 09:16:34', NULL, b'0'),
('e09681f4-8b5e-11ec-8f7c-001a4a2500e0', '352789', 'Demo test DB', '27604c5f-8896-11ec-8f7c-001a4a2500e0', 2, 2, '2022-02-08 09:16:34', NULL, b'0'),
('fdae3080-ab74-11ec-80ba-001a4a350220', '11111111', 'SkienceOne Integrate Horizon smoke test', '27604c5f-8896-11ec-8f7c-001a4a2500e0', 2, 2, '2022-03-24 09:18:38', '2022-03-24 14:34:24', b'1'),
('ffad1329-8dbc-11ec-8f7c-001a4a2500e0', '339203', 'Verify that the success response is received and logs have proper log entries once api/clients POST API is sent using proper valid payload.', '27604c5f-8896-11ec-8f7c-001a4a2500e0', 2, 2, '2022-02-14 12:38:37', '2022-03-22 10:10:13', b'0');

--
-- Triggers `testcases`
--
DELIMITER $$
CREATE TRIGGER `before_insert_testcases` BEFORE INSERT ON `testcases` FOR EACH ROW BEGIN
  IF new.id IS NULL  OR new.id = '' THEN
    SET new.id = uuid();
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_token` varchar(255) DEFAULT NULL COMMENT 'Token for user account verification or user password reset.',
  `user_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 = OK, 1 = Account verification required, 2 = Password reset requested.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_password`, `user_email`, `user_token`, `user_status`) VALUES
(0, 'TFS', '', '', NULL, 0),
(1, 'admin', 'd91780a9d8421159cc9825be0becca2a4fb1450bc708f42da81758d97b232a35', 'hello@luatsqa.com', 'ca19be17ac6d0f16a09087b86f2359f839fa9ee9', 0),
(2, 'luat.do', 'd91780a9d8421159cc9825be0becca2a4fb1450bc708f42da81758d97b232a35', 'doluat11@gmail.com', 'ca19be17ac6d0f16a09087b86f2359f839fa9ee9', 0),
(3, 'test_fpom', '6fec2a9601d5b3581c94f2150fc07fa3d6e45808079428354b868e412b76e6bb', 'nguyenvongochuy@gmail.com', NULL, 0),
(5, 'Bill.Bingham@cir2.com', '8c11bd7c7e2dafe4b8fa95b0555fc26aa017fe1d25dd9e6ed5f6db97ebf136ca', 'Bill.Bingham@cir2.com', '4f3551122db49aee8133f12cbf93fa2faf0c157f', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_teams`
--

CREATE TABLE `user_teams` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `teamid` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_teams`
--

INSERT INTO `user_teams` (`id`, `userid`, `teamid`) VALUES
(1, 2, '27604c5f-8896-11ec-8f7c-001a4a2500e0'),
(3, 3, 'a5b788ea-8b84-11ec-8f7c-001a4a2500e0');

--
-- Triggers `user_teams`
--
DELIMITER $$
CREATE TRIGGER `before_insert_user_product` AFTER INSERT ON `user_teams` FOR EACH ROW BEGIN
  INSERT INTO `phpgen_user_perms`( `page_name`, `perm_name`, `user_id`) select `page_name`, `perm_name`, new.userid from `phpgen_user_perms` where user_id = '2';
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `questionid` (`questionid`),
  ADD KEY `answers_userid` (`answers_userid`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `teamid` (`teamid`),
  ADD KEY `applications_userid` (`applications_userid`);

--
-- Indexes for table `criterias`
--
ALTER TABLE `criterias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `appid` (`appid`),
  ADD KEY `criterias_userid` (`criterias_userid`);

--
-- Indexes for table `criteria_testcase`
--
ALTER TABLE `criteria_testcase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `criteriaid` (`criteriaid`),
  ADD KEY `testcaseid` (`testcaseid`);

--
-- Indexes for table `elements`
--
ALTER TABLE `elements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `elements_userid` (`elements_userid`),
  ADD KEY `teamid` (`teamid`);

--
-- Indexes for table `environments`
--
ALTER TABLE `environments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phpgen_user_perms`
--
ALTER TABLE `phpgen_user_perms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `teamid` (`qteamid`),
  ADD KEY `questions_userid` (`questions_userid`);

--
-- Indexes for table `run`
--
ALTER TABLE `run`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `testcaseid` (`testcaseid`),
  ADD KEY `status` (`status`),
  ADD KEY `env` (`env`),
  ADD KEY `runby` (`runby`);

--
-- Indexes for table `runstatus`
--
ALTER TABLE `runstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `steps_userid` (`steps_userid`),
  ADD KEY `action` (`action`),
  ADD KEY `element` (`element`),
  ADD KEY `testcaseid` (`testcaseid`);

--
-- Indexes for table `tcstatus`
--
ALTER TABLE `tcstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`teamid`),
  ADD UNIQUE KEY `teamid` (`teamid`),
  ADD KEY `teams_userid` (`teams_userid`);

--
-- Indexes for table `testcases`
--
ALTER TABLE `testcases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `tfsid` (`tfsid`),
  ADD KEY `status` (`status`),
  ADD KEY `testcases_userid` (`testcases_userid`),
  ADD KEY `teamid` (`teamid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_teams`
--
ALTER TABLE `user_teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `teamid` (`teamid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `criteria_testcase`
--
ALTER TABLE `criteria_testcase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `environments`
--
ALTER TABLE `environments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `phpgen_user_perms`
--
ALTER TABLE `phpgen_user_perms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tcstatus`
--
ALTER TABLE `tcstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_teams`
--
ALTER TABLE `user_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`questionid`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`answers_userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`teamid`) REFERENCES `teams` (`teamid`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`applications_userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `criterias`
--
ALTER TABLE `criterias`
  ADD CONSTRAINT `criterias_ibfk_1` FOREIGN KEY (`appid`) REFERENCES `applications` (`id`),
  ADD CONSTRAINT `criterias_ibfk_2` FOREIGN KEY (`criterias_userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `criteria_testcase`
--
ALTER TABLE `criteria_testcase`
  ADD CONSTRAINT `criteria_testcase_ibfk_1` FOREIGN KEY (`criteriaid`) REFERENCES `criterias` (`id`),
  ADD CONSTRAINT `criteria_testcase_ibfk_2` FOREIGN KEY (`testcaseid`) REFERENCES `testcases` (`id`);

--
-- Constraints for table `elements`
--
ALTER TABLE `elements`
  ADD CONSTRAINT `elements_ibfk_1` FOREIGN KEY (`elements_userid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `elements_ibfk_2` FOREIGN KEY (`teamid`) REFERENCES `teams` (`teamid`);

--
-- Constraints for table `phpgen_user_perms`
--
ALTER TABLE `phpgen_user_perms`
  ADD CONSTRAINT `phpgen_user_perms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`qteamid`) REFERENCES `teams` (`teamid`),
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`questions_userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `run`
--
ALTER TABLE `run`
  ADD CONSTRAINT `run_ibfk_1` FOREIGN KEY (`testcaseid`) REFERENCES `testcases` (`id`),
  ADD CONSTRAINT `run_ibfk_2` FOREIGN KEY (`status`) REFERENCES `runstatus` (`id`),
  ADD CONSTRAINT `run_ibfk_3` FOREIGN KEY (`env`) REFERENCES `environments` (`id`),
  ADD CONSTRAINT `run_ibfk_4` FOREIGN KEY (`runby`) REFERENCES `users` (`id`);

--
-- Constraints for table `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `steps_ibfk_1` FOREIGN KEY (`steps_userid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `steps_ibfk_2` FOREIGN KEY (`action`) REFERENCES `actions` (`id`),
  ADD CONSTRAINT `steps_ibfk_3` FOREIGN KEY (`element`) REFERENCES `elements` (`id`),
  ADD CONSTRAINT `steps_ibfk_4` FOREIGN KEY (`testcaseid`) REFERENCES `testcases` (`id`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`teams_userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `testcases`
--
ALTER TABLE `testcases`
  ADD CONSTRAINT `testcases_ibfk_1` FOREIGN KEY (`status`) REFERENCES `tcstatus` (`id`),
  ADD CONSTRAINT `testcases_ibfk_2` FOREIGN KEY (`testcases_userid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `testcases_ibfk_3` FOREIGN KEY (`teamid`) REFERENCES `teams` (`teamid`);

--
-- Constraints for table `user_teams`
--
ALTER TABLE `user_teams`
  ADD CONSTRAINT `user_teams_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_teams_ibfk_2` FOREIGN KEY (`teamid`) REFERENCES `teams` (`teamid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
