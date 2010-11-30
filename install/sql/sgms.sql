-- MySQL dump 10.11
--
-- Host: localhost    Database: sgms
-- ------------------------------------------------------
-- Server version	5.0.86

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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `confirmed` tinyint(4) NOT NULL default '0',
  `regip` int(11) default NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `lastip` int(11) default NULL,
  `valstr` varchar(100) default NULL,
  `role` varchar(50) NOT NULL default 'guest',
  `newsletter` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (28,'Vass','sir.lagalot.thegreat@gmail.com','9946394433099a697b4d26b047891af4',1,983868517,'2010-05-31 11:09:49',NULL,'1234567890','user',0),(29,'Taylor','ding.vendor@gmail.com','9946394433099a697b4d26b047891af4',1,1375984610,'2010-05-31 11:33:24',NULL,'1234567890','admin',0),(26,'Bob','bob@bob.bob','9946394433099a697b4d26b047891af4',1,NULL,'2010-05-29 00:04:58',NULL,NULL,'user',0);
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crew`
--

DROP TABLE IF EXISTS `crew`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crew` (
  `id` int(11) NOT NULL auto_increment,
  `bio` text NOT NULL,
  `deleted` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crew`
--

LOCK TABLES `crew` WRITE;
/*!40000 ALTER TABLE `crew` DISABLE KEYS */;
/*!40000 ALTER TABLE `crew` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `flavour` text,
  `image` varchar(100) default NULL,
  `url` varchar(150) NOT NULL,
  `gm` varchar(255) NOT NULL,
  `simtype` enum('PBeM','PBB','Chat','Fiction') NOT NULL,
  `shiptype` int(11) NOT NULL,
  `sorder` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game`
--

LOCK TABLES `game` WRITE;
/*!40000 ALTER TABLE `game` DISABLE KEYS */;
INSERT INTO `game` VALUES (1,'USS Chimera','USS Chimera is a Nebula Class Starship under the command of Captain Darren Hoon, tasked with diplomatic missions near the Breen border. \r\n\r\nDarren and his crew find themselves under intense pressure to avoid the on coming storm of open combat.','TF93Chimera.png','http://www.usschimera.org/','','PBeM',2,1),(2,'USS Excalibur',NULL,'TF93Excalibur.png','http://www.ussexcalibur.org/','','PBeM',1,2);
/*!40000 ALTER TABLE `game` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `summary` varchar(300) NOT NULL,
  `author` int(11) NOT NULL,
  `postdate` datetime NOT NULL,
  `status` enum('draft','pending','published') NOT NULL default 'draft',
  `logo` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'New beginnings','As of May 10th 2010 Task Force 93 came in to existence, formed by mutual agreement the task force exists to provide a home to those who just want to write. The group itself has no formal leader; instead there is a coalition of friends who direct the group at large where necessary.\r\n\r\nThe staff list at the current time stands as follows:\r\n\r\n* Forum Admin: Flying Gremlin and Vass\r\n* Wiki Admin: Boomer\r\n* Website Development: Taylor and Vass\r\n* Public Relations Director/Recruitment: Shaded_elf_assassin\r\n* Awards: Shawn Mclaughlin\r\n* Specs Review: boblmartens\r\n* Canon and History: Denton\r\n* Graphics: Steve/Shawn Mclaughlin\r\n* News: Taylor\r\n\r\nAs time goes by this list will change, so please check out the wiki for the latest version.\r\n','Task Force 93 comes to life May 10th 2010',1,'2010-06-01 19:36:43','published','logo.png'),(2,'One','One','',1,'2010-06-01 19:46:20','draft',''),(3,'Two','Two','',1,'2010-06-01 19:46:20','draft','');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registry_class`
--

DROP TABLE IF EXISTS `registry_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registry_class` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(150) NOT NULL,
  `sorder` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registry_class`
--

LOCK TABLES `registry_class` WRITE;
/*!40000 ALTER TABLE `registry_class` DISABLE KEYS */;
INSERT INTO `registry_class` VALUES (1,'Defiant Class',1),(2,'Nebula Class',2);
/*!40000 ALTER TABLE `registry_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(32) NOT NULL,
  `save_path` varchar(32) NOT NULL default '',
  `name` varchar(32) NOT NULL default '',
  `modified` int(11) default NULL,
  `lifetime` int(11) default NULL,
  `data` text,
  PRIMARY KEY  (`id`,`save_path`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('dbvfkmlcb4rfu6lplhf5tk9lu0','','',1274885157,2592000,'Zend_Auth|a:1:{s:7:\"storage\";s:6:\"Taylor\";}'),('tcviaig0begur4q288o34o0km0','','',1274900486,2592000,''),('mj59eqrbfpl5a4nesq4d9redi0','','',1274893861,2592000,''),('ptk8gd7t1j4i3ai89r2uloqng4','','',1274898707,2592000,''),('c5am97pmjo2t138env6ppsnm55','','',1274883931,2592000,''),('3gksttic2tocrqqoku2jivcjf5','','',1275488363,2592000,''),('6aui40qr13lb216hpifq8mds52','','',1274877767,2592000,''),('heqmqnnb3ruidnqjcardnucsd7','','',1274877764,2592000,''),('k2lu25ptgk6jtu284hlesvahg0','','',1274870652,2592000,''),('0msh22806ekagfjvq7gktnbk63','','',1274870646,2592000,''),('ood4dhroritohbkh34d9tt4696','','',1274869077,2592000,''),('cd3220ei39abjvkic19sd4a7m6','','',1274872202,2592000,''),('7gb7hmdlbl5k1a1er02pu55nl5','','',1274867582,2592000,''),('3s812nr8p5paploii6q1dqfqm3','','',1274864922,2592000,''),('n90mcu9hed9u0tqcll1s40s8u3','','',1274864922,2592000,''),('ig4evstorv1hfd61ugc5a0uhu4','','',1274849297,2592000,''),('bm9kng9782stssji8osdruunb3','','',1274847871,2592000,''),('k03nuerj70i0l48c087r78gtu4','','',1274847870,2592000,''),('sgvcbs9cuj64qsmcp22576js61','','',1274839608,2592000,''),('lulvivvbo4c0uftihc5h3deme1','','',1274839608,2592000,''),('lkp6s507ca7rrr4tlpr02gb7k5','','',1274839291,2592000,''),('db2s4dhiiifspi9kd8t4m34lt5','','',1274839089,2592000,''),('d4qcecn62ib5ij0cnuenlidat6','','',1274838521,2592000,''),('cvsd25psfcs64hlpv3fbc0svs7','','',1274832113,2592000,''),('de1q6rknb812lkh4e6nagu1ue4','','',1274831686,2592000,''),('pebjm6ji7m29n71p53qrrqgit3','','',1274825267,2592000,''),('me2u7io07mungv9flvsipjqhd7','','',1274824379,2592000,''),('2uqg7tnfvcr1mul20679833ps5','','',1274818495,2592000,''),('evp05m0v4u976ousgl3utuhhn3','','',1274811374,2592000,''),('1vlcnd38hq30tmcqkrd9435sh0','','',1274803769,2592000,''),('dulqv9cdsiq7lv1ne97j5vnf67','','',1274802905,2592000,''),('i5n84msa05ajqstvha415jgks4','','',1274802898,2592000,''),('8nubuihq0oa7tpellujeuvne41','','',1274801787,2592000,''),('85t77kftouvoheop11h5vg1bh4','','',1274797478,2592000,''),('2a0vt08j6sp35rrm9coc39orl0','','',1274797478,2592000,''),('8b2qs9g6sqr3vgiqcmafso4086','','',1274796587,2592000,''),('9aiqf0ab96sm9mj8ih8k7mnpk3','','',1274796325,2592000,''),('tc6cr72e08i4jqjoidkopk5lv0','','',1274796042,2592000,''),('f02uc53t101ma6jcdi4j5vggp6','','',1274796042,2592000,''),('a94gasgagtkhf4ohfr257lisr4','','',1274795277,2592000,''),('kah7j2pp1bl8o2mk60js2nfcr3','','',1274795273,2592000,''),('ltqa0kh5dlpfqcoc62jfnhm2g0','','',1274795319,2592000,''),('ik843q3enlir1d8fn43bbqf321','','',1274795268,2592000,''),('hfmqgjifkcbe27456r774e5fp0','','',1274793393,2592000,''),('aug05s0sq4uf403e3po5pfkfc5','','',1274793393,2592000,''),('omgimci14pe8bg8csqkg9c0v53','','',1274789373,2592000,''),('s2k35e6mvub2hsgeuiemeijcv3','','',1274789373,2592000,''),('vsil946vk1n7c6o3uqbdnqjjj2','','',1274782362,2592000,''),('49stransoqeo2e9esa5jkt57q0','','',1274781415,2592000,''),('v35mqifmu5o0bvo7on8a5g9i30','','',1274781126,2592000,''),('pd4hi78okajmf20kddbppa0u13','','',1274878435,2592000,''),('1gt2h03d1p6hhdefhi4l18i401','','',1274767048,2592000,''),('vf77bancl0h07laek9ui8hjnn2','','',1274767048,2592000,''),('qto0v2r4214l3ju3jtttb8f677','','',1274767048,2592000,''),('hm6fnfirf72osimtm3j4v4qa71','','',1274767048,2592000,''),('s96s08kisfsr1po82ritf1kou6','','',1274744361,2592000,''),('m4k2a958qpsiq4pv02lgggm2p1','','',1274742209,2592000,''),('hgsluuj0nhs5mm64d1h8o7qeq1','','',1274742209,2592000,''),('i0ulg0ovfjous8mpjqfmf565m2','','',1274740370,2592000,''),('rvga6e2pblap6617agld6kpgm4','','',1274740370,2592000,''),('pvlljokmm7hj9ul8flqcpmie04','','',1274740369,2592000,''),('q78navjisqieqkp7r9nq8t77h0','','',1274740369,2592000,''),('spsaslfa1s09vmjth7c227jkh3','','',1274740369,2592000,''),('nabj468rpqkr5d3jqrqdif4q80','','',1274740369,2592000,''),('5lp4ojbm5mv1k7dkl0alk16fa7','','',1274740369,2592000,''),('nd0i4ki4n7lgg27hl134eupql7','','',1274740369,2592000,''),('biujh46csr5ds9gdu9doqgfnb6','','',1274740369,2592000,''),('r6oh8ja88seppl2n1sdt8dcs26','','',1274740368,2592000,''),('6c53gtsm8mibanks9mkv19tc65','','',1274740368,2592000,''),('niq80r03nioo27ud2tr0ve3jj7','','',1274740367,2592000,''),('roi8d8n1m75uouf833ovt86np0','','',1274740367,2592000,''),('rpdcp3d9sd2il7qheepitn1o85','','',1274740367,2592000,''),('neh3p53pkv066vmiaf6sch73d5','','',1274740367,2592000,''),('9pud2rinle67p6uvc8tdqp15k1','','',1274740367,2592000,''),('p8a6ja3ffjbm7pjn9pcqqdcdo6','','',1274740367,2592000,''),('9ivq45uvf731t9lppevhjuaq34','','',1274740367,2592000,''),('rbv3jr1sn621bta8f8lsf0qpu4','','',1274740367,2592000,''),('c735v8gdidcku0thkksgsvlbf7','','',1274740367,2592000,''),('o0h2iofskq7km4uu0ci6h8eid3','','',1274771741,2592000,'');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `template_email`
--

DROP TABLE IF EXISTS `template_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `template_email` (
  `id` int(11) NOT NULL auto_increment,
  `html` text NOT NULL,
  `text` text NOT NULL,
  `subject` varchar(150) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `template_email`
--

LOCK TABLES `template_email` WRITE;
/*!40000 ALTER TABLE `template_email` DISABLE KEYS */;
INSERT INTO `template_email` VALUES (1,'<p>Someone, we assume you, tried to register for an account on <a href=\"http://www.arkroyal.org\">http://www.arkroyal.org/</a> from IP Address {regip}</p>\r\n\r\n<p>If you wish to validate your email and continue the registration process please click on the following link or alternatively copy and paste the link to a new browser.</p>\r\n\r\n<p><a href=\"http://www.arkroyal.org{valurl}\">http://www.arkroyal.org{valurl}</a></p>\r\n\r\n<p>If you did not request this registration please contact the site administrator via email at <a href=\"mailto:chimera@usschimera.org\">chimera@usschimera.org</a> and we will investigate further.</p>','Someone, we assume you, tried to register for an account on http://www.arkroyal.org/ from IP Address {regip}\r\n\r\nIf you wish to validate your email and continue the registration process please click on the following link or alternatively copy and paste the link to a new browser.\r\n\r\nhttp://www.arkroyal.org{valurl}\r\n\r\nIf you did not request this registration please contact the site administrator via email at chimera@usschimera.org and we will investigate further.','Your Task Force 93 Account'),(2,'<p>Your password has been reset to {password}</p>\r\n\r\n<p>You can log in by visiting <a href=\"http://www.arkroyal.org/account/login\">http://www.arkroyal.org/account/login</a>','Your password has been reset to {password}\r\n\r\nYou can log in by visiting http://www.arkroyal.org/account/login','Your password has been reset');
/*!40000 ALTER TABLE `template_email` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-06-02 10:59:44
