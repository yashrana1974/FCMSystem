-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: fcms
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cus_assigned_users`
--

DROP TABLE IF EXISTS `cus_assigned_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cus_assigned_users` (
  `asid` int(11) NOT NULL AUTO_INCREMENT,
  `prid` varchar(250) NOT NULL,
  `buid` varchar(250) NOT NULL,
  PRIMARY KEY (`asid`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cus_assigned_users`
--

LOCK TABLES `cus_assigned_users` WRITE;
/*!40000 ALTER TABLE `cus_assigned_users` DISABLE KEYS */;
INSERT INTO `cus_assigned_users` VALUES (22,'12','26'),(25,'4','26'),(35,'4','28'),(39,'27','26'),(40,'27','28'),(72,'32','9'),(73,'32','15'),(74,'32','31'),(76,'35','53'),(78,'37','31');
/*!40000 ALTER TABLE `cus_assigned_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cus_business_users`
--

DROP TABLE IF EXISTS `cus_business_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cus_business_users` (
  `buid` int(11) NOT NULL AUTO_INCREMENT,
  `buname` varchar(100) NOT NULL,
  `bupassword` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `bumobile` varchar(10) NOT NULL,
  `buemail` varchar(100) NOT NULL,
  `bucompanyname` varchar(100) NOT NULL,
  `bucompanyaddress` varchar(255) NOT NULL,
  `butype` varchar(100) NOT NULL,
  `buunderadmin` bigint(11) NOT NULL,
  `bustatus` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`buid`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cus_business_users`
--

LOCK TABLES `cus_business_users` WRITE;
/*!40000 ALTER TABLE `cus_business_users` DISABLE KEYS */;
INSERT INTO `cus_business_users` VALUES (9,'Kuldeep Parekh','Kuldeep@1234','5555555555','kuldeep@gmail.com','arth counsultancy service','above baby hug','staff',17,0),(15,'Aaditya Bisht','Aditya@1234','8888888888','a@gmail.com','Arth Consaltancy','Above Baby Hug','staff',17,0),(17,'Adarsh Patel Sir','Adarsh@1234','7777777777','adarsh@gmail.com','Arth Consaltancy','Above Baby Hug','admin',0,1),(30,'Rushabh Shah','Rushabh@1234','1111111111','rushabh@gmail.com','Arth','Above Baby Hug','admin',0,1),(31,'Helvi Patel','Helvi@1234','2323232323','helvi@gmail.com','Arth Consaltancy','Above baby hug','staff',17,1),(32,'Hariom Giri','Hariom@1234','1212121212','hariom@gmail.com','Arth Consaltancy','Above Baby Hug','staff',17,1),(36,'William','William@1234','1231231231','william@gmail.com','Startup','Demo','admin',0,1),(53,'Kashyap Shah','Kashyap@1234','9898989898','kashyap@gmail.com','Arth Consaltancy','Above Baby Hug','staff',17,1),(55,'Het N Shah','Het@1234','3636363637','het2@gmail.com','Digital Marketing','Balaji Flats, Waghodia, Vadodara','admin',0,1);
/*!40000 ALTER TABLE `cus_business_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `res_hashtag_db`
--

DROP TABLE IF EXISTS `res_hashtag_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `res_hashtag_db` (
  `htid` int(11) NOT NULL AUTO_INCREMENT,
  `prid` bigint(20) NOT NULL,
  `httitle` varchar(100) NOT NULL,
  `htcontent` varchar(1000) NOT NULL,
  `hthashtag` varchar(255) NOT NULL,
  PRIMARY KEY (`htid`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `res_hashtag_db`
--

LOCK TABLES `res_hashtag_db` WRITE;
/*!40000 ALTER TABLE `res_hashtag_db` DISABLE KEYS */;
INSERT INTO `res_hashtag_db` VALUES (13,37,'#FileCMS','#DataStorageChanger#Innovation#SocialMediaDataStorage',''),(14,35,'#Arth_Training_Institute','#Technology#SoftwareCompany#CounsultancyServices',''),(15,35,'#Food','#TastyFood#DeliveredDoorStep','');
/*!40000 ALTER TABLE `res_hashtag_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `res_image_db`
--

DROP TABLE IF EXISTS `res_image_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `res_image_db` (
  `imid` int(11) NOT NULL AUTO_INCREMENT,
  `prid` int(11) NOT NULL,
  `imtitle` varchar(100) NOT NULL,
  `imfilename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `imhashtag` varchar(255) NOT NULL,
  PRIMARY KEY (`imid`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `res_image_db`
--

LOCK TABLES `res_image_db` WRITE;
/*!40000 ALTER TABLE `res_image_db` DISABLE KEYS */;
INSERT INTO `res_image_db` VALUES (23,8,'sun rise','image1.avif',''),(25,30,'beach view','q3rq3 (2).png',''),(27,8,'Random','dashboardimagetransparent.png',''),(33,33,'test','content-management (1).png_33.png',''),(40,35,'Logo for application','VirtuSpy (1).png_40.png','');
/*!40000 ALTER TABLE `res_image_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `res_inquiry_db`
--

DROP TABLE IF EXISTS `res_inquiry_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `res_inquiry_db` (
  `inqid` int(11) NOT NULL AUTO_INCREMENT,
  `inqdate` varchar(50) NOT NULL,
  `inqname` varchar(255) NOT NULL,
  `inqemail` varchar(255) NOT NULL,
  `inqmobile` text NOT NULL,
  `inqsubject` varchar(255) NOT NULL,
  `inqmessage` varchar(255) NOT NULL,
  PRIMARY KEY (`inqid`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `res_inquiry_db`
--

LOCK TABLES `res_inquiry_db` WRITE;
/*!40000 ALTER TABLE `res_inquiry_db` DISABLE KEYS */;
/*!40000 ALTER TABLE `res_inquiry_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `res_project_db`
--

DROP TABLE IF EXISTS `res_project_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `res_project_db` (
  `prid` int(11) NOT NULL AUTO_INCREMENT,
  `prname` varchar(250) NOT NULL,
  `buid` bigint(11) NOT NULL,
  PRIMARY KEY (`prid`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `res_project_db`
--

LOCK TABLES `res_project_db` WRITE;
/*!40000 ALTER TABLE `res_project_db` DISABLE KEYS */;
INSERT INTO `res_project_db` VALUES (4,'Project 7',5),(12,'Project',5),(27,'Rough 9',5),(32,'Classified Website',17),(34,'ouhdlquh;oconce',34),(35,'Food Ordering Website',17),(37,'Campus Food Ordering System',17);
/*!40000 ALTER TABLE `res_project_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `res_report_db`
--

DROP TABLE IF EXISTS `res_report_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `res_report_db` (
  `rpid` int(11) NOT NULL AUTO_INCREMENT,
  `rpdate` varchar(50) NOT NULL,
  `rpsubject` varchar(255) NOT NULL,
  `rpdescription` varchar(255) NOT NULL,
  `buid` int(11) NOT NULL,
  PRIMARY KEY (`rpid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `res_report_db`
--

LOCK TABLES `res_report_db` WRITE;
/*!40000 ALTER TABLE `res_report_db` DISABLE KEYS */;
INSERT INTO `res_report_db` VALUES (9,'2024-03-28','Testing Report Functionality','Testing functionality............',17);
/*!40000 ALTER TABLE `res_report_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `res_super_admin`
--

DROP TABLE IF EXISTS `res_super_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `res_super_admin` (
  `spid` int(11) NOT NULL AUTO_INCREMENT,
  `spmobileadmin` varchar(10) NOT NULL,
  `sppasswordadmin` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `spname` varchar(100) NOT NULL,
  PRIMARY KEY (`spid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `res_super_admin`
--

LOCK TABLES `res_super_admin` WRITE;
/*!40000 ALTER TABLE `res_super_admin` DISABLE KEYS */;
INSERT INTO `res_super_admin` VALUES (1,'9725478874','yash@1234','yash');
/*!40000 ALTER TABLE `res_super_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `res_taskreport_db`
--

DROP TABLE IF EXISTS `res_taskreport_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `res_taskreport_db` (
  `trpid` int(11) NOT NULL AUTO_INCREMENT,
  `trpdate` varchar(50) NOT NULL,
  `trpsubject` varchar(255) NOT NULL,
  `trpdescription` varchar(255) NOT NULL,
  `buid` bigint(20) NOT NULL,
  `buunderadmin` bigint(11) NOT NULL,
  PRIMARY KEY (`trpid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `res_taskreport_db`
--

LOCK TABLES `res_taskreport_db` WRITE;
/*!40000 ALTER TABLE `res_taskreport_db` DISABLE KEYS */;
INSERT INTO `res_taskreport_db` VALUES (6,'2024-02-22','Test case','Testing the report functionality',29,0);
/*!40000 ALTER TABLE `res_taskreport_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `res_text_db`
--

DROP TABLE IF EXISTS `res_text_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `res_text_db` (
  `txid` int(11) NOT NULL AUTO_INCREMENT,
  `prid` bigint(20) NOT NULL,
  `txtitle` varchar(100) NOT NULL,
  `txcontent` varchar(500) NOT NULL,
  `txhashtag` varchar(255) NOT NULL,
  PRIMARY KEY (`txid`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `res_text_db`
--

LOCK TABLES `res_text_db` WRITE;
/*!40000 ALTER TABLE `res_text_db` DISABLE KEYS */;
INSERT INTO `res_text_db` VALUES (17,4,'wwdn','poejoaepjf',''),(18,27,'Testing','aem;fl',''),(35,34,'dedec','awded',''),(37,37,'New Functionality','Trying to add header based redirection in the message section.',''),(38,35,'Room Service','In Room services our delivery person will come to your room wither it is hostel or house.',''),(39,32,'Detailed Location','Showing the precise location of the shop to ease the travel of the users. And also add google maps to guide their travel route.',''),(40,35,'Plans','Expanding the coverage of delivery to gain more customers and hire more delivery persons.',''),(41,35,'Rough','Rough','');
/*!40000 ALTER TABLE `res_text_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `res_video_db`
--

DROP TABLE IF EXISTS `res_video_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `res_video_db` (
  `viid` int(11) NOT NULL AUTO_INCREMENT,
  `prid` bigint(20) NOT NULL,
  `vititle` varchar(100) NOT NULL,
  `vifilename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `vihashtag` varchar(255) NOT NULL,
  PRIMARY KEY (`viid`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `res_video_db`
--

LOCK TABLES `res_video_db` WRITE;
/*!40000 ALTER TABLE `res_video_db` DISABLE KEYS */;
INSERT INTO `res_video_db` VALUES (3,30,'Random cars','22.mp4',''),(32,32,'Rotating Earth','file_example_MP4_480_1_5MG.mp4_32.mp4',''),(34,35,'Forest','Free_Test_Data_2MB_MP4.mp4_34.mp4','');
/*!40000 ALTER TABLE `res_video_db` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-29 10:09:48
