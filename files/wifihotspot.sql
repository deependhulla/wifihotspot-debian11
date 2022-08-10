-- MySQL dump 10.15  Distrib 10.0.17-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: wifihotspot
-- ------------------------------------------------------
-- Server version	10.0.17-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `app_login_info`
--

DROP TABLE IF EXISTS `app_login_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_login_info` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) DEFAULT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `org_sname` varchar(250) NOT NULL,
  `login_name` varchar(250) NOT NULL,
  `login_pass` varchar(250) NOT NULL,
  `login_ip` varchar(250) NOT NULL,
  `login_fullname` varchar(250) NOT NULL,
  `login_contact` varchar(250) NOT NULL,
  `login_location` varchar(250) NOT NULL,
  `login_active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  AUTO_INCREMENT=141 DEFAULT CHARSET=latin1 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_login_info`
--

LOCK TABLES `app_login_info` WRITE;
/*!40000 ALTER TABLE `app_login_info` DISABLE KEYS */;
INSERT INTO `app_login_info` VALUES (1,NULL,'deepen','2014-08-08 14:33:43','','','wifiadmin','techno02srv','','WIFI Admin','9645121781','fort',1);
/*!40000 ALTER TABLE `app_login_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_module_access`
--

DROP TABLE IF EXISTS `app_module_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_module_access` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `org_sname` varchar(250) NOT NULL,
  `module_id` varchar(250) NOT NULL,
  `login_name` varchar(250) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  AUTO_INCREMENT=3730 DEFAULT CHARSET=latin1 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_module_access`
--

LOCK TABLES `app_module_access` WRITE;
/*!40000 ALTER TABLE `app_module_access` DISABLE KEYS */;
INSERT INTO `app_module_access` VALUES (3702,NULL,'','2015-05-04 10:33:30','','','1','1'),(3703,NULL,'','2015-05-04 10:33:30','','','10','1'),(3704,NULL,'','2015-05-04 10:33:30','','','11','1'),(3705,NULL,'','2015-05-04 10:33:30','','','16','1'),(3706,NULL,'','2015-05-04 10:33:30','','','18','1'),(3707,NULL,'','2015-05-04 10:33:30','','','19','1'),(3708,NULL,'','2015-05-04 10:33:30','','','20','1'),(3709,NULL,'','2015-05-04 10:33:30','','','21','1'),(3710,NULL,'','2015-05-04 10:33:30','','','22','1'),(3711,NULL,'','2015-05-04 10:33:30','','','23','1'),(3712,NULL,'','2015-05-04 10:33:30','','','24','1');
/*!40000 ALTER TABLE `app_module_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_module_info`
--

DROP TABLE IF EXISTS `app_module_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_module_info` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) DEFAULT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `org_sname` varchar(250) NOT NULL,
  `module_id` int(250) NOT NULL,
  `module_sname` varchar(250) NOT NULL,
  `module_fullname` varchar(250) NOT NULL,
  `module_phpuri` varchar(250) NOT NULL,
  `module_primary_id` int(11) NOT NULL,
  `module_dropdown` int(11) NOT NULL,
  `module_display_order_id` int(11) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_module_info`
--

LOCK TABLES `app_module_info` WRITE;
/*!40000 ALTER TABLE `app_module_info` DISABLE KEYS */;
INSERT INTO `app_module_info` VALUES (1,NULL,'','2014-11-19 00:38:36','','',1,'WIFI Registered','WIFI Registered Users','wifi_regi.php',10,0,1),(11,NULL,'','2014-11-20 08:33:12','','',10,'WIFI','WIFI','',0,1,2),(12,NULL,'','2014-11-19 00:38:36','','',11,'Access Plan','WIFI Access Plan','access_plan.php',10,0,2),(16,NULL,'','2014-11-20 23:12:05','','',15,'Admin','Admin','app_login_info.php',11,0,0),(17,NULL,'','2014-11-20 23:23:33','','',16,'Modem Info','Wifi Modem Info','wifi_modem_info.php',10,0,9),(20,NULL,'','2014-12-24 02:21:44','','',18,'Plan Activation','Plan Activation','plan_activation.php',10,0,4),(21,NULL,'','2014-12-26 05:04:32','','',19,'Today Code',' Wifi\'s Today-Access-Code','today_code_make.php',10,0,5),(22,NULL,'','2014-12-29 03:45:25','','',20,'Configuration','Configuration','system_message.php',10,0,10),(23,NULL,'','2014-12-30 00:50:19','','',21,'Admin Users','Admin Users','admin_users.php',10,0,7),(24,NULL,'','2014-12-30 00:50:19','','',22,'Plan Reports','Plan Reports','plan_reports.php',10,0,8),(25,NULL,'','2014-12-30 00:50:19','','',23,'Network Tools','Network Tools','network_tools.php',10,0,6),(26,NULL,'','2014-12-29 19:20:19','','',24,'Package Management','Package Management','package_mgmt.php',10,0,3);
/*!40000 ALTER TABLE `app_module_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_info`
--

DROP TABLE IF EXISTS `config_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_info` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `type_of_msg` varchar(250) NOT NULL DEFAULT '',
  `msg_in_config` varchar(255) NOT NULL,
  `msg_data` text NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `type_of_msg` (`type_of_msg`)
) ENGINE=InnoDB  AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_info`
--

LOCK TABLES `config_info` WRITE;
/*!40000 ALTER TABLE `config_info` DISABLE KEYS */;
INSERT INTO `config_info` VALUES (1,NULL,'','2014-12-26 07:54:49','','COMPANY_NAME','Company Name','TechnoInfotech'),(2,NULL,'','2014-12-26 07:35:23','','COMPANY_URL','Company Website URL','http://www.technoinfotech.com/'),(3,NULL,'','2014-12-26 07:35:43','','COMPANY_LOGO_PATH','Company Logo Path','images/1683615552company-logo.png'),(4,NULL,'','2014-12-26 07:36:05','','TERM_MSG','Terms & Condition Msg for Registration ','I agree to <a href=\"../wifilogin/terms.php\" target=\"_blank\">Terms & Condition</a> of company and would use for good purpose.'),(5,NULL,'','2014-12-26 08:00:33','','ENABLED_TITLE','Internet Activated Basic Msg','Your wifi internet package has been activated'),(6,NULL,'','2014-12-26 08:00:13','','EXPIRE_TITLE','Internet Expired Basic Msg','Your wifi Internet package has expired'),(7,NULL,'','2014-12-26 07:36:47','','RENEW_MSG','Renew Msg details','Please contact reception counter to get Internet package.'),(8,NULL,'','2014-12-26 07:34:47','','LOGIN_GLOBAL_MSG','Welcome Msg details (Like Merry Christmas)','Welcome to TechnoAir'),(9,NULL,'','2015-01-05 11:53:53','','INVOICE_EXTRA','Invoice Extra Header Information (VAT No ..etc)','Telephone: 022-2526 0505 Corporate Office: 022-66150505 Mobile: +91-91678-88900 E-mail: info@clubemerald.in'),(10,NULL,'','2015-01-05 11:53:53','','COMPANY_ADDRESS','Company Address','Swastik Park, Next to Shrushut & Mangal Anand Hospital, Chembur, Mumbai - 400071'),(11,NULL,'','2015-01-28 07:10:13','','MANAGEMENT_TYPE','Management Type','0'),(12,NULL,'','2015-01-28 07:10:13','','PACKAGE_VALUE_1_TEXT','Package Value 1 Text','Room Number'),(13,NULL,'','2015-01-28 07:10:13','','PACKAGE_VALUE_2_TEXT','Package Value 2 Text','Reg. Guest Last Name'),(14,NULL,'','2015-01-28 07:10:13','','DEFAULT_DOWNLOAD_IN_KBPS','Default Download in Kbps (eg: 512)','512'),(15,NULL,'','2015-01-28 07:10:13','','DEFAULT_UPLOAD_IN_KBPS','Default Upload in Kbps (eg: 512)','512'),(16,NULL,'','2015-01-28 07:10:13','','NETWORK_TYPE','Network Type','Direct ISP Terminated'),(17,NULL,'','2015-01-28 07:10:13','','UNLIMITED_DOWNLOAD_UPLOAD_SPEED_FOR_LOCAL_OFFICE_IP','Unlimited download/upload speed for local office IP (eg: 192.168.0.254,192.168.0.253 )','192.168.0.254'),(19,NULL,'','2015-05-06 22:15:54','','TERMS_CONDITION_PAGE','Terms & Condition Page','<table width=\"575\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr><td>This is a free Hotspot wireless internet Service (the <b>â€œServiceâ€</b>) provided by TechnoAir for use by customers of TechnoAir.  All users are required to log-in individually as an independent user.<br><br><b>1. Our agreement</b><br><br>1.1 This agreement applies from when we accept your request for Service. Please read the terms carefully before activating Service with us.<br><br>1.2 By using and/or activating Service with us and/or clicking the accept button on the login/registration page you agree to be bound by this agreement. If you do not agree to the terms of the agreement, do not use the Service.<br><br>1.3 We may modify the agreement at any time. In accordance with clause 1.2, use of the Service constitutes acceptance of the agreement current at that point in time.<br><br>1.4 These Terms and Conditions do not alter in any way the terms or conditions of any other agreement you may have with TechnoAir for products, services or otherwise.  This agreement contains disclaimers and other provisions that limit our liability to you.<br><br><b>2. Providing services</b><br><br>2.1 You are responsible for providing all hardware and other equipment required to access and use the Service (a â€˜â€˜Unitâ€™â€™).  We recommend an 802.11b or above-compatible computer, computer card, and/or device to access the Service.  You are responsible for ensuring the compatibility of your Unit with the Service.  The availability and performance of the Service is subject to all memory, storage and other Unit limitations.<br><br>2.2 Service is available to your Unit only when it is within the range of our Wireless LAN.<br><br>2.3 All services are provided on an â€œas isâ€ basis.  We do not warrant that the Service is fault free or fit for any particular purpose, or that our system is secure.  You assume all responsibility and risk for use of the Service.<br><br>2.4 We will always try to make the Service available, but it may be interrupted, limited or curtailed due to maintenance and repair work, transmission or equipment limitations/failures, collocation failures or due to an emergency. We are not responsible for data, messages or pages that you may lose or that become misdirected because of interruptions or performance issues with the Service.<br><br>2.5 We reserve the right to immediately and without notice, suspend your access to the Service if we suspect that you are transmitting a virus (or any other manipulating program capable of modifying other programs and replicating itself).<br><br>2.6 Network speed is no indication of the speed at which your Unit connected to the Service sends or receives data.  Actual network speed will vary based on Unit configuration, compression and network congestion.  The accuracy and timeliness of data sent or received is not guaranteed and you accept that delays or omissions may occur.<br><br>2.7 We do not warrant that any particular virtual private network will be compatible with the Service.<br><br>2.8 We will not supply any software to you in connection with the Service.  If you use software packages, applications or configurations then you accept the risk of any failure of the Service resulting from the use of such software packages, applications or configurations.<br><br><b>3. Use of the Service</b><br><br>3.1 The Service is made available provided:<br><br>(a) You do not use the Service for anything unlawful, immoral or improper;<br><br>(b) You do not use the Service to make offensive or nuisance communications in whatever form.  Such usage includes posting, transmitting, uploading, downloading or otherwise facilitating any content that is unlawful, defamatory, threatening, a nuisance, obscene, hateful, abusive, harmful (including but not limited to viruses, corrupted files, or any other similar software or programs), a breach of privacy, or which is otherwise objectionable;<br><br>(c) You do not use the Service to harm or attempt to harm minors in any way;<br><br>(d) You do not act nor knowingly permit others to act in such a way that the operation of the Service or our systems will be jeopardized or impaired;<br><br>(e) You do not use abusive or threatening behavior towards other users of the Service, members of our staff or any person in the vicinity of a Wireless LAN Hotspot;<br><br>(f) You do not use the Service to access or use content in a way that infringes the rights of others;<br><br>(g) The Service is used in accordance with any third party policies for acceptable use or any relevant internet standards (where applicable).<br><br>3.2 You agree not to resell or re-broadcast any aspect of the Service, whether for profit or otherwise.  You accept that your entitlement to use the Service is for your personal use only and that you shall not be entitled to transfer your entitlement to use the Service to any other person or allow any other person to make use of the Service or of any username or password or your TechnoAir FAMILY Card number or other entitlement supplied to you in connection with the Service.<br><br>3.3 You also agree not to modify the Unit or use the Service for any fraudulent purpose, or in such a way as to create damage or risk to our business, reputation, employees, subscribers, facilities, third parties or to the public generally.<br><br>3.4 You have no proprietary or ownership rights to any username or password or to a specific IP address, or e-mail address assigned to you or your Unit.  We may change such addresses at any time or deactivate or suspend Service to any address without prior notice to you if we suspect any unlawful or fraudulent use of the services.<br><br><b>4. Content disclaimer</b><br><br>4.1 TechnoAir does not control, nor is it in any way liable for, data or content that you access or receive via the Service.  The Internet contains unedited materials, some of which may be sexually explicit or offensive to you.  Whereas TechnoAir use efforts to restrict such content TechnoAir has no control over and accepts no responsibility for such materials.<br><br>4.2 TechnoAir is not a publisher of third-party content that can be accessed through the Service and is not responsible for any opinions, advice, statements, services or other information provided by third parties and accessible through the Service.  You are responsible for evaluating such content.<br><br>4.3 It is your responsibility to evaluate the value and integrity of goods and services offered by third parties accessible via the service.  TechnoAir will not be a party to nor in any way be responsible for any transaction concerning third party goods and services.  You are responsible for all consents, royalties and fees related to third party vendors whose sites, products or services you access, buy or use via the Service. <br><br>4.4 TechnoAir does not guarantee the accuracy, completeness or usefulness of information that is obtained through the Service.<br><br>4.5 If you choose to use the Service to access web sites or content provided by third parties or purchase products from third parties, then your personal information may be available to the third-party provider.  The way third parties handle and use your personal information related to the use of their services is governed by their policies and TechnoAir has no responsibility for their policies, or third partiesâ€™ compliance with them.<br><br>4.6 TechnoAir is providing this Service to customers free of charge, and is intended to support general web browsing activities. Due to limited bandwidth and to ensure a consistent experience for all customers, our Wi-Fi does not support high-bandwidth actions such as streaming music, streaming video or downloading large files. <br><br><b>5. Fair Usage</b><br><br>To ensure the provision of a quality of Service to all our customers and to ensure that the behavior of some does not disadvantage the majority of our customers, you agree to abide by any fair use policy which we may apply.<br><br><b>6. Security</b><br><br>6.1 The registration process requests that you provide a username and a password, or your TechnoAir FAMILY Card details which must be used in order to access the Service. As stated in sections 3.2 and 3.3 your username and password or your TechnoAir FAMILY Card number are personal to you and are not transferable. You must treat your username and password or TechnoAir FAMILY Card Number as confidential and you must not disclose such detail to a third party. All information provided to us by you during the registration process shall be true and accurate and will be relied upon by us for the provision of the Service.<br><br>6.2 You are solely responsible for all use of and for protecting the confidentiality of your username and password or your TechnoAir FAMILY Card number.  You are responsible for all activities that occur under your registration.  Any breach of security of a username and password or your TechnoAir FAMILY Card number should be notified to us immediately.  We have the right to disable your username and/or password or your TechnoAir FAMILY Card number at any time if in our opinion you have failed to comply with any of the provisions of these Terms and Conditions.<br><br><b>7. Privacy Policy</b><br><br>Personal data submitted by you in the registration process and certain other information about you is subject to our Privacy Policy.<br><br><b>8. Disclaimer of Warranties</b><br><br>THE SERVICE IS PROVIDED ON AN \"AS IS\" BASIS AND WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, WARRANTIES OF TITLE, MERCHANTABILITY, NON-INFRINGEMENT, OR FITNESS FOR A PARTICULAR PURPOSE WHICH ARE EXPRESSLY DISCLAIMED. YOU ASSUME ALL RESPONSIBILITY AND RISK FOR USE OF THE SERVICE.  TechnoAir DOES NOT AUTHORIZE ANYONE TO MAKE A WARRANTY OF ANY KIND ON OUR BEHALF AND YOU SHOULD NOT RELY ON ANY SUCH STATEMENT. NEITHER WE NOR OUR OFFICERS, DIRECTORS, EMPLOYEES, MANAGERS, AGENTS, DEALERS, SUPPLIERS, PARENTS, SUBSIDIARIES OR AFFILIATES WARRANT THAT THE INFORMATION, PRODUCTS, PROCESSES, AND/OR SERVICES AVAILABLE THROUGH THE SERVICE WILL BE UNINTERRUPTED, ALWAYS AVAILABLE, ACCURATE, COMPLETE, USEFUL, FUNCTIONAL OR ERROR FREE. <br><br><b>9. Limitation of Liability </b><br><br>EVEN IF TechnoAir HAS BEEN ADVISED OF THE POSSIBILITY OF DAMAGES, WE WILL NOT BE LIABLE TO YOU OR ANY THIRD PARTY FOR ANY DAMAGES ARISING FROM USE OF THE SERVICE, INCLUDING WITHOUT LIMITATION: PUNITIVE, EXEMPLARY, INCIDENTAL, SPECIAL OR CONSEQUENTIAL DAMAGES, LOSS OF PRIVACY OR SECURITY DAMAGES; PERSONAL INJURY OR PROPERTY DAMAGES; OR ANY DAMAGES WHATSOEVER RESULTING FROM INTERRUPTION OR FAILURE OF SERVICE, LOST PROFITS, LOSS OF BUSINESS, LOSS OF DATA, LOSS DUE TO UNAUTHORIZED ACCESS OR DUE TO VIRUSES OR OTHER HARMFUL COMPONENTS, COST OF REPLACEMENT PRODUCTS AND SERVICES, THE INABILITY TO USE THE SERVICE, THE CONTENT OF ANY DATA TRANSMISSION, COMMUNICATION OR MESSAGE TRANSMITTED TO OR RECEIVED BY YOUR DEVICE, ACCESS TO THE WORLD WIDE WEB, THE INTERCEPTION OR LOSS OF ANY DATA OR TRANSMISSION, OR LOSSES RESULTING FROM ANY GOODS OR SERVICES PURCHASED OR MESSAGES OR DATA RECEIVED OR TRANSACTIONS ENTERED INTO THROUGH THE SERVICE. <br><br><b>10. Class Action Waiver </b><br><br>WHETHER IN COURT, SMALL CLAIMS COURT, OR ARBITRATION, YOU AND WE MAY ONLY BRING CLAIMS AGAINST EACH OTHER IN AN INDIVIDUAL CAPACITY AND NOT AS A CLASS REPRESENTATIVE OR A CLASS MEMBER IN A CLASS OR REPRESENTATIVE ACTION. <br><br><b>11. Termination</b><br><br>We can cancel this agreement immediately if any of the following happens:<br><br>(a) You break an important condition of this agreement or a number of less important conditions as determined by TechnoAir.<br><br><b>12.  General</b><br><br>12.1 You agree to indemnify us against any claims, demands, actions liabilities, costs or damages arising out of your use of the Service including any material that you access or make available using the Service, or violation of the agreement, including but not limited to use of the Service by you (or permitted by you) involving offensive or illegal material or activities that constitute copyright infringement.  You furthermore agree to pay our reasonable legal fees and expertsâ€™ costs arising out from any actions or claims hereunder.<br><br>12.2 You agree to protect your username and password or your TechnoAir Family Card number. You are responsible for any usage of your account. If you become aware of any unauthorized or fraudulent usage of the Service via your account, you should notify us immediately.<br><br>12.3 You may not transfer or try to transfer any of your rights and responsibilities under this agreement without our consent. We may transfer our rights and responsibilities to any third party without your permission.<br><br>12.4 The laws applicable to the interpretation of these Terms and Conditions shall be the laws of the State of Delaware without reference to its conflict of law provisions.<br><br>12.5 This agreement shall not confer any benefit on a third party<br><br>12.6 If any provision of these Terms and Conditions shall be unlawful, void, or for any reason unenforceable, then that provision shall be deemed severable from this agreement and shall not affect the validity and enforceability of any remaining provisions. <br><br>12.7 We reserve the right to amend these terms and conditions at any time.<br><br>How to contact us<br>Write to us at:<br>Technoinfotech, Fort<br>Attention: WiFi Terms and Conditions<br>Mumbai<br>400001</td></tr></table>'),(20,NULL,'','2015-05-06 22:21:24','','PACKAGE_VALUE_3_TYPE','Package Value 3 Type','2'),(21,NULL,'','2015-05-06 22:21:36','','PACKAGE_VALUE_3_TEXT','Package Value 3 Text','Your Mob No.'),(22,NULL,'','2015-05-07 12:40:13','','SUPPORT_LICENSE_KEY','Support License Key','AKL67AS3423');
/*!40000 ALTER TABLE `config_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_code_info`
--

DROP TABLE IF EXISTS `mac_code_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_code_info` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `live_date` date NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `specialcode` varchar(250) NOT NULL DEFAULT '',
  `specialcodeactive` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_code_info`
--

LOCK TABLES `mac_code_info` WRITE;
/*!40000 ALTER TABLE `mac_code_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_code_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_user_info`
--

DROP TABLE IF EXISTS `mac_user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_user_info` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `user_mac_address` varchar(250) NOT NULL DEFAULT '',
  `user_full_name` varchar(250) NOT NULL DEFAULT '',
  `user_mobile` varchar(250) NOT NULL DEFAULT '',
  `user_email` varchar(250) NOT NULL DEFAULT '',
  `user_membership_no` varchar(250) NOT NULL DEFAULT '',
  `user_extra_office_info` varchar(250) NOT NULL,
  `user_access_plan` int(11) NOT NULL DEFAULT '0',
  `user_device_type` varchar(250) NOT NULL DEFAULT '',
  `user_reg_browser_full_info` varchar(250) NOT NULL DEFAULT '',
  `user_reg_browser` varchar(250) NOT NULL DEFAULT '',
  `user_reg_device` varchar(250) NOT NULL DEFAULT '',
  `user_reg_datetime` datetime NOT NULL,
  `user_reg_active` int(11) NOT NULL DEFAULT '0',
  `user_activaton_datetime` datetime NOT NULL,
  `user_mac_blocked` int(11) NOT NULL DEFAULT '0',
  `user_mobile_blocked` int(11) NOT NULL DEFAULT '0',
  `user_block_reason` varchar(250) NOT NULL DEFAULT '',
  `user_block_datetime` datetime NOT NULL,
  `user_internal_comments` varchar(250) NOT NULL DEFAULT '',
  `user_ip_address` varchar(55) NOT NULL,
  `full_access` int(11) NOT NULL,
  `message_og_the_day` text NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `user_mac_address` (`user_mac_address`),
  KEY `full_access` (`full_access`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_user_info`
--

LOCK TABLES `mac_user_info` WRITE;
/*!40000 ALTER TABLE `mac_user_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_user_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `today_code_info`
--

DROP TABLE IF EXISTS `today_code_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `today_code_info` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `code_date` date NOT NULL,
  `today_code` varchar(250) NOT NULL DEFAULT '',
  `code_for_event` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `code_date` (`code_date`),
  UNIQUE KEY `today_code` (`today_code`)
) ENGINE=InnoDB  AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `today_code_info`
--

LOCK TABLES `today_code_info` WRITE;
/*!40000 ALTER TABLE `today_code_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `today_code_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verify_type_details`
--

DROP TABLE IF EXISTS `verify_type_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verify_type_details` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `verify_type_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verify_type_details`
--

LOCK TABLES `verify_type_details` WRITE;
/*!40000 ALTER TABLE `verify_type_details` DISABLE KEYS */;
INSERT INTO `verify_type_details` VALUES (0,NULL,'','2014-12-29 09:10:39','','OTHER'),(1,NULL,'','2014-12-24 10:46:15','','PAN_CARD'),(2,NULL,'','2014-12-24 10:48:03','','AADHAAR_CARD'),(3,NULL,'','2014-12-24 10:48:03','','DRIVING_LICENSE '),(4,NULL,'','2014-12-24 10:48:25','','MEMBERSHIP_CARD'),(5,NULL,'','2014-12-24 10:48:25','','PASSPORT'),(6,NULL,'','2014-12-24 10:50:26','','EVENT_INVITATION_CARD'),(7,NULL,'','2015-01-09 06:49:31','','ENROLMENT NUMBER');
/*!40000 ALTER TABLE `verify_type_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wifi_access_plan`
--

DROP TABLE IF EXISTS `wifi_access_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi_access_plan` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `reset_daily` int(11) NOT NULL DEFAULT '0',
  `user_access_plan_name` varchar(250) NOT NULL DEFAULT '',
  `user_ip_notallowed_list` text NOT NULL,
  `validity_period_in_mins` int(11) NOT NULL DEFAULT '0',
  `traffic_limit_in_mb` int(11) NOT NULL DEFAULT '0',
  `basic_upload_max_speed_kbps` int(11) NOT NULL DEFAULT '0',
  `basic_download_max_speed_kbps` int(11) NOT NULL DEFAULT '0',
  `special_ip_list` text NOT NULL,
  `access_plan_active` int(11) NOT NULL DEFAULT '0',
  `internal_notes` varchar(250) NOT NULL DEFAULT '',
  `traffic_reset_limit_in_mb` int(11) NOT NULL DEFAULT '0',
  `traffic_reset_period` int(11) NOT NULL DEFAULT '0',
  `plan_price` decimal(16,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi_access_plan`
--

LOCK TABLES `wifi_access_plan` WRITE;
/*!40000 ALTER TABLE `wifi_access_plan` DISABLE KEYS */;
INSERT INTO `wifi_access_plan` VALUES (0,NULL,'','2014-12-12 07:35:07','',0,'Guest User - Default','192.168.1.0/24',1,0,0,0,'',1,'',0,0,0.00),(1,NULL,'','2014-12-24 10:21:26','',0,'30 Min Access','192.168.1.0/24',30,0,0,0,'',1,'',0,0,20.00),(2,NULL,'','2014-12-24 10:11:51','',0,'One Hour Access','192.168.1.0/24',60,0,256,512,'',1,'',0,0,25.00),(3,NULL,'','2014-12-24 10:11:40','',0,'Two Hour Access','192.168.1.0/24',120,0,0,0,'',1,'',0,0,100.00),(4,NULL,'','2014-12-24 10:13:17','',0,'Four Hour Access','192.168.1.0/24',240,0,0,0,'',1,'',0,0,222.00),(5,NULL,'','2014-12-24 10:15:50','',0,'24hr  Access','192.168.1.0/24',1440,0,0,0,'',1,'',0,0,400.00),(6,NULL,'','2014-12-24 10:23:40','',0,'Membership Users-1yr','192.168.1.0/24',525600,0,0,0,'',1,'',0,0,5000.00),(7,NULL,'','2014-12-24 10:14:50','',0,'Office Temporary Users-31days','',44640,0,0,0,'',1,'',0,0,0.00),(8,NULL,'','2014-12-08 09:24:14','',0,'Office Permanent Users-1yr','',525600,0,0,0,'',1,'',0,0,0.00),(9,NULL,'','2014-12-24 10:22:11','',0,'Top Management Access-25yrs','',13140000,0,0,0,'',1,'',0,0,0.00),(13,NULL,'','2014-12-24 10:38:00','',0,'Office Devices-10yrs','',5256000,0,0,0,'',1,'',0,0,0.00),(14,NULL,'','2015-01-23 09:54:21','',0,'3day70min','',4320,70,0,0,'',1,'3day',20,1,80.00),(15,NULL,'','2015-01-24 11:38:21','',0,'2Day40MB','',2880,40,0,0,'',1,'2Day40MB',15,1,20.00),(16,NULL,'','2015-05-04 13:21:39','',0,'demo','',2880,20000,1024,1024,'',1,'',10000,1,500.00),(17,NULL,'','2015-05-06 07:24:27','',0,'1Day100MBwith56kbps-dl','',1440,100,512,56,'',1,'',0,0,200.00),(18,NULL,'','2015-05-07 05:11:29','',0,'08MayTest','',1440,2048,0,512,'',1,'08 May 2015 test Access Plan',0,2,500.00);
/*!40000 ALTER TABLE `wifi_access_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wifi_daily_usage`
--

DROP TABLE IF EXISTS `wifi_daily_usage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi_daily_usage` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `user_live_date` date NOT NULL,
  `iptables_packets` bigint(11) NOT NULL DEFAULT '0',
  `iptables_bytes` bigint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `user_live_date` (`user_live_date`),
  KEY `iptables_packets` (`iptables_packets`),
  KEY `iptables_bytes` (`iptables_bytes`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi_daily_usage`
--

LOCK TABLES `wifi_daily_usage` WRITE;
/*!40000 ALTER TABLE `wifi_daily_usage` DISABLE KEYS */;
/*!40000 ALTER TABLE `wifi_daily_usage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wifi_daily_users`
--

DROP TABLE IF EXISTS `wifi_daily_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi_daily_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `user_live_date` date NOT NULL,
  `user_mac` varchar(250) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `user_live_date_2` (`user_live_date`,`user_mac`),
  KEY `user_mac` (`user_mac`),
  KEY `user_live_date` (`user_live_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi_daily_users`
--

LOCK TABLES `wifi_daily_users` WRITE;
/*!40000 ALTER TABLE `wifi_daily_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `wifi_daily_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wifi_live_plans`
--

DROP TABLE IF EXISTS `wifi_live_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi_live_plans` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `mac_uid` int(11) NOT NULL,
  `plan_uid` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `access_plan_live` int(11) NOT NULL DEFAULT '1',
  `verify_type` varchar(255) NOT NULL,
  `verify_info` varchar(255) NOT NULL,
  `additional_notes` text NOT NULL,
  `traffic_reset_limit_in_mb` int(11) NOT NULL DEFAULT '0',
  `basic_upload_max_speed_kbps` int(11) NOT NULL DEFAULT '512',
  `basic_download_max_speed_kbps` int(11) NOT NULL DEFAULT '512',
  `traffic_reset_period` int(11) NOT NULL DEFAULT '0',
  `traffic_limit_in_mb` int(11) NOT NULL DEFAULT '0',
  `plan_price` decimal(16,2) NOT NULL DEFAULT '0.00',
  `pvalue1` varchar(55) NOT NULL,
  `pvalue2` varchar(55) NOT NULL,
  `pvalue1_label` varchar(55) NOT NULL,
  `pvalue2_label` varchar(55) NOT NULL,
  `no_device_allowed` int(11) NOT NULL,
  `package_uid` int(11) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi_live_plans`
--

LOCK TABLES `wifi_live_plans` WRITE;
/*!40000 ALTER TABLE `wifi_live_plans` DISABLE KEYS */;
/*!40000 ALTER TABLE `wifi_live_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wifi_modem_info`
--

DROP TABLE IF EXISTS `wifi_modem_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi_modem_info` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `modem_location` varchar(250) NOT NULL DEFAULT '',
  `modem_ssid` varchar(250) NOT NULL DEFAULT '',
  `modem_mac` varchar(250) NOT NULL DEFAULT '',
  `modem_ip` varchar(250) NOT NULL DEFAULT '',
  `modem_port` varchar(250) NOT NULL DEFAULT '',
  `modem_make` varchar(250) NOT NULL DEFAULT '',
  `modem_model` varchar(250) NOT NULL DEFAULT '',
  `modem_username` varchar(250) NOT NULL DEFAULT '',
  `modem_password` varchar(250) NOT NULL DEFAULT '',
  `modem_active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `modem_ip` (`modem_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi_modem_info`
--

LOCK TABLES `wifi_modem_info` WRITE;
/*!40000 ALTER TABLE `wifi_modem_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `wifi_modem_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wifi_package_management`
--

DROP TABLE IF EXISTS `wifi_package_management`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wifi_package_management` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) NOT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `value1` varchar(250) NOT NULL,
  `value2` varchar(250) NOT NULL,
  `value3` varchar(55) NOT NULL,
  `access_plan_id` varchar(250) NOT NULL,
  `no_of_devices_allowed` int(11) NOT NULL,
  `package_active` int(11) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `value1` (`value1`,`value2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi_package_management`
--

LOCK TABLES `wifi_package_management` WRITE;
/*!40000 ALTER TABLE `wifi_package_management` DISABLE KEYS */;
/*!40000 ALTER TABLE `wifi_package_management` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-07 14:25:56


ALTER TABLE `wifi_live_plans` ADD `pvalue3` VARCHAR(255) NOT NULL AFTER `pvalue2`;
ALTER TABLE `wifi_live_plans` ADD `pvalue3_label` VARCHAR(255) NOT NULL AFTER `pvalue2_label`;

CREATE TABLE IF NOT EXISTS `internet_tools` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) NOT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `current_status` varchar(200) NOT NULL,
  `automatic_internet` varchar(200) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1  ;



INSERT INTO `internet_tools` (`uid`, `logid`, `create_by_user`, `create_on_date`, `current_status`, `automatic_internet`, `start_time`, `end_time`) VALUES
(1, 0, '', '2015-05-29 06:42:23', '0', '0', '2015-05-28 13:58:29', '2015-05-28 13:58:33');

ALTER TABLE `mac_user_info` ADD `user_todaycode_active` INT NOT NULL DEFAULT '0' AFTER `message_og_the_day`, ADD INDEX (`user_todaycode_active`);
ALTER TABLE `mac_user_info` CHANGE `full_access` `full_access` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `mac_user_info` CHANGE `message_og_the_day` `message_og_the_day` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '';

