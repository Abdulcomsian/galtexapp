-- MySQL dump 10.13  Distrib 5.6.42, for Linux (x86_64)
--
-- Host: localhost    Database: galtndqd_sorav
-- ------------------------------------------------------
-- Server version	5.5.60-MariaDB

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
-- Table structure for table `tbl_categories`
--

DROP TABLE IF EXISTS `tbl_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_guid` char(36) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_guid` (`category_guid`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_categories`
--

LOCK TABLES `tbl_categories` WRITE;
/*!40000 ALTER TABLE `tbl_categories` DISABLE KEYS */;
INSERT INTO `tbl_categories` VALUES (5,'aad2d107-2f6d-ae51-dfeb-209029f546a6','מתנות > גאדג\'טים','2021-12-22 10:24:56'),(7,'dcd7bd74-c7b8-0fb9-49c1-482de48b84c2','פנאי וספורט','2021-12-27 13:22:33'),(8,'7acc52c6-285c-3a67-d79a-a2438959bf1a','מוצרי פירסום','2021-12-27 13:22:33'),(9,'44652b3c-c869-f9a4-7d35-26150a54304b','מתנות','2021-12-27 13:22:38'),(11,'b4f2ba28-cc95-9146-3938-ad410de7e560','תיקים','2021-12-27 19:40:33'),(12,'af262e8a-1af5-88e7-e574-5f8faff353a6','שמיכות','2021-12-29 19:24:10');
/*!40000 ALTER TABLE `tbl_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_client_package_products`
--

DROP TABLE IF EXISTS `tbl_client_package_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_client_package_products` (
  `package_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  UNIQUE KEY `package_product_id` (`package_id`,`product_id`),
  KEY `package_id` (`package_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `tbl_client_package_products_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `tbl_client_packages` (`package_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_client_package_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_client_package_products`
--

LOCK TABLES `tbl_client_package_products` WRITE;
/*!40000 ALTER TABLE `tbl_client_package_products` DISABLE KEYS */;
INSERT INTO `tbl_client_package_products` VALUES (9,339),(9,340),(10,329),(10,331),(11,324),(11,326),(12,220),(12,241),(13,224),(13,226),(13,319),(14,221),(14,242),(15,236),(15,238),(15,239),(16,252),(16,320),(17,324),(17,327),(17,328),(18,322),(19,320),(19,336),(20,220),(20,241),(22,340),(22,349),(23,339),(23,349),(24,339),(24,349),(25,334),(25,335),(25,339);
/*!40000 ALTER TABLE `tbl_client_package_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_client_packages`
--

DROP TABLE IF EXISTS `tbl_client_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_client_packages` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_guid` char(36) NOT NULL,
  `client_id` int(11) NOT NULL,
  `package_name` varchar(250) NOT NULL,
  `no_of_products` smallint(6) NOT NULL,
  `quantity` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Total assigned quantity',
  `sold_quantity` smallint(6) NOT NULL DEFAULT '0',
  `client_status` enum('Review Pending','Liked','Deleted','Mutually Confirmed') NOT NULL DEFAULT 'Review Pending',
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`package_id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `tbl_client_packages_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_client_packages`
--

LOCK TABLES `tbl_client_packages` WRITE;
/*!40000 ALTER TABLE `tbl_client_packages` DISABLE KEYS */;
INSERT INTO `tbl_client_packages` VALUES (9,'d108221e-b7e8-8da1-75ca-8b1d823f9df6',43,'סט למטבח כלל קופסאות אחסון וסט קיטצ\'ן',2,100,0,'Liked','2021-12-28 11:35:23'),(10,'ad9e7f17-a4ca-746f-de13-eada03bb944c',43,'מטען נייד ורמקול שהוא גם מוט סלפי',2,10,0,'Liked','2021-12-28 11:36:29'),(11,'dad33938-0d85-fa88-4d28-1f1bc832db6f',43,'חבילת מגבות',2,50,0,'Liked','2021-12-28 11:37:03'),(12,'0a7ac589-d29c-061c-53d3-00fe8182d758',43,'מסיבת אוזניות',2,10,0,'Liked','2021-12-28 11:37:42'),(13,'1ba81cb0-36d3-00fa-bbcf-2d0ded553e7b',43,'סט קופסאות ושני בקבוקים טרמיים',3,100,0,'Liked','2021-12-28 11:38:32'),(14,'1b5238ea-7547-1852-6bae-b41ec82f9700',43,'רמקול ומטען נייד',2,200,0,'Liked','2021-12-28 11:39:04'),(15,'83250c65-3f49-1dc1-ca70-3e5282cdd9ea',43,'מעמד לרכב אוזניות ורמקול עמיד במים',3,300,0,'Liked','2021-12-28 11:39:44'),(16,'4e0bb03e-22cd-c639-79c6-7a9eab8c07e8',43,'תיק Swiss דגם ZUG ומטען נייד',2,200,0,'Liked','2021-12-28 11:40:44'),(17,'af1039cc-b607-f654-0152-43b1118cd4fe',43,'חבילת חורף',3,50,0,'Liked','2021-12-28 11:45:16'),(18,'0b9542bc-0dc6-2a49-1999-c47a4e1227ee',43,'תיק דגם דן Limited ומטען מייד',2,10,0,'Liked','2021-12-28 11:48:57'),(19,'50747e3e-71eb-b502-7cd8-6c3aee801803',43,'תיק Swiss ומטען נייד בריסל ',2,5,0,'Liked','2021-12-28 11:49:52'),(20,'750dfa09-5613-2d2f-3065-685dafc0a119',43,'מערכת שמע עוצמתית דגם U2 ואוזניות bluetooth',2,1,0,'Liked','2021-12-28 11:51:23'),(22,'3b155fce-32a8-5fa5-e7a3-900fdb7616f2',43,'12',2,12,0,'Review Pending','2022-01-16 13:05:07'),(23,'2ece3d47-c28c-a5ec-c462-8c1d71e5c4a7',163,'12',2,12,0,'Liked','2022-01-16 13:05:32'),(24,'f6ff6d21-0403-05fd-78eb-aeb59ff29c23',166,'package 1',2,20,0,'Liked','2022-01-17 10:26:32'),(25,'094f8acd-6b0b-12d5-b9d6-2e6b5b590197',166,'packkage 2',3,15,0,'Liked','2022-01-17 10:26:51');
/*!40000 ALTER TABLE `tbl_client_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_client_pickup_address`
--

DROP TABLE IF EXISTS `tbl_client_pickup_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_client_pickup_address` (
  `pickup_address_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `pickup_address` varchar(255) NOT NULL,
  PRIMARY KEY (`pickup_address_id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `tbl_client_pickup_address_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_client_pickup_address`
--

LOCK TABLES `tbl_client_pickup_address` WRITE;
/*!40000 ALTER TABLE `tbl_client_pickup_address` DISABLE KEYS */;
INSERT INTO `tbl_client_pickup_address` VALUES (3,166,'tel aviv'),(4,166,'jerusalem');
/*!40000 ALTER TABLE `tbl_client_pickup_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_client_shop_products`
--

DROP TABLE IF EXISTS `tbl_client_shop_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_client_shop_products` (
  `shop_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `shop_category` enum('Within Budget','Above Budget') NOT NULL,
  `above_budget_price` smallint(6) DEFAULT NULL COMMENT '(additional price in shekel)',
  `client_status` enum('Review Pending','Liked','Deleted','Mutually Confirmed') NOT NULL DEFAULT 'Review Pending',
  `quantity` smallint(6) NOT NULL DEFAULT '0' COMMENT '(Total assigned quantity)',
  `sold_quantity` smallint(6) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`shop_product_id`),
  KEY `client_id` (`client_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `tbl_client_shop_products_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_client_shop_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_client_shop_products`
--

LOCK TABLES `tbl_client_shop_products` WRITE;
/*!40000 ALTER TABLE `tbl_client_shop_products` DISABLE KEYS */;
INSERT INTO `tbl_client_shop_products` VALUES (117,43,338,'Within Budget',NULL,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(118,43,289,'Within Budget',NULL,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(119,43,287,'Within Budget',NULL,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(120,43,285,'Within Budget',NULL,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(121,43,284,'Within Budget',NULL,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(122,43,318,'Above Budget',1000,'Review Pending',100,0,'2021-12-30 13:56:24',NULL),(123,43,317,'Above Budget',1000,'Review Pending',100,0,'2021-12-30 13:56:24',NULL),(124,43,316,'Above Budget',800,'Review Pending',100,0,'2021-12-30 13:56:24',NULL),(125,43,315,'Above Budget',1000,'Review Pending',100,0,'2021-12-30 13:56:24',NULL),(126,43,314,'Above Budget',1200,'Review Pending',100,0,'2021-12-30 13:56:24',NULL),(127,43,313,'Above Budget',800,'Review Pending',1,0,'2021-12-30 13:56:24',NULL),(128,43,312,'Above Budget',500,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(129,43,311,'Above Budget',500,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(130,43,310,'Above Budget',500,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(131,43,308,'Above Budget',500,'Review Pending',200,0,'2021-12-30 13:56:24',NULL),(132,43,306,'Above Budget',600,'Review Pending',1,0,'2021-12-30 13:56:24',NULL),(133,43,305,'Above Budget',600,'Review Pending',10,0,'2021-12-30 13:56:24',NULL),(134,43,304,'Above Budget',1000,'Review Pending',200,0,'2021-12-30 13:56:24',NULL),(135,43,303,'Above Budget',1200,'Review Pending',50,0,'2021-12-30 13:56:24',NULL),(136,43,297,'Above Budget',600,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(137,43,296,'Above Budget',600,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(138,43,294,'Above Budget',800,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(139,43,293,'Above Budget',500,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(140,43,283,'Above Budget',400,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(141,43,279,'Above Budget',400,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(142,43,278,'Above Budget',100,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(143,43,273,'Above Budget',200,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(144,43,264,'Above Budget',300,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(145,43,259,'Above Budget',150,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(146,43,258,'Above Budget',300,'Review Pending',0,0,'2021-12-30 13:56:24',NULL),(151,163,340,'Within Budget',NULL,'Liked',5,0,'2022-01-16 13:06:02',NULL),(152,163,338,'Within Budget',NULL,'Deleted',1,0,'2022-01-16 13:06:02',NULL),(153,163,336,'Within Budget',NULL,'Liked',12,0,'2022-01-16 13:06:02',NULL),(154,163,333,'Within Budget',NULL,'Liked',12,0,'2022-01-16 13:06:02',NULL),(155,163,318,'Above Budget',23,'Liked',5,0,'2022-01-16 13:06:02',NULL),(156,163,317,'Above Budget',23,'Liked',15,0,'2022-01-16 13:06:02',NULL),(162,166,340,'Within Budget',NULL,'Liked',20,0,'2022-01-17 10:28:46',NULL),(163,166,338,'Within Budget',NULL,'Deleted',20,0,'2022-01-17 10:28:46',NULL),(164,166,336,'Within Budget',NULL,'Liked',5,0,'2022-01-17 10:28:46',NULL),(165,166,333,'Within Budget',NULL,'Liked',7,0,'2022-01-17 10:28:46',NULL),(166,166,331,'Within Budget',NULL,'Liked',2,0,'2022-01-17 10:28:46',NULL),(167,166,318,'Above Budget',50,'Liked',20,0,'2022-01-17 10:28:46',NULL),(168,166,317,'Above Budget',100,'Liked',15,0,'2022-01-17 10:28:46',NULL),(169,166,316,'Above Budget',50,'Liked',500,0,'2022-01-17 10:28:46',NULL);
/*!40000 ALTER TABLE `tbl_client_shop_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_details`
--

DROP TABLE IF EXISTS `tbl_order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_details` (
  `order_id` int(11) NOT NULL,
  `type` enum('Product','Package') NOT NULL,
  `product_package_id` int(11) NOT NULL,
  `product_package_name` varchar(200) NOT NULL,
  `quantity` smallint(6) NOT NULL DEFAULT '1',
  `amount` int(11) NOT NULL,
  KEY `order_id` (`order_id`),
  CONSTRAINT `tbl_order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tbl_orders` (`order_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_details`
--

LOCK TABLES `tbl_order_details` WRITE;
/*!40000 ALTER TABLE `tbl_order_details` DISABLE KEYS */;
INSERT INTO `tbl_order_details` VALUES (13,'Package',23,'12',1,0),(14,'Product',333,'אוזניות bluetooth',1,0);
/*!40000 ALTER TABLE `tbl_order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_orders`
--

DROP TABLE IF EXISTS `tbl_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_guid` char(36) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_amount` float(6,2) NOT NULL DEFAULT '0.00',
  `used_credits` int(11) NOT NULL DEFAULT '0',
  `credit_card_amount` int(11) NOT NULL DEFAULT '0',
  `address_mode` varchar(100) NOT NULL,
  `pickup_address` varchar(500) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `apartment` varchar(200) DEFAULT NULL,
  `street_house` varchar(200) DEFAULT NULL,
  `postal_code` varchar(200) DEFAULT NULL,
  `order_status` enum('Created','Cancelled') DEFAULT 'Created',
  `payment_id` text COMMENT '(Credit2000 Payment ID)',
  `payment_status` enum('Pending','Success','Failed') DEFAULT NULL,
  `payment_response` text,
  `created_date` datetime NOT NULL,
  `cancelled_date` datetime DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_orders`
--

LOCK TABLES `tbl_orders` WRITE;
/*!40000 ALTER TABLE `tbl_orders` DISABLE KEYS */;
INSERT INTO `tbl_orders` VALUES (13,'d0d41f03-7fa6-3f1c-baa3-e53b4292235c',164,0.00,0,0,'Door to Door',NULL,'תל אביב','7','שינקין 70','','Cancelled',NULL,'Success',NULL,'2022-01-16 13:08:22','2022-01-16 13:08:31'),(14,'e14e9939-0d8c-0c38-9c2b-87730cfb939a',165,0.00,0,0,'Door to Door',NULL,'תל אביב','7','שינקין 70','','Cancelled',NULL,'Success',NULL,'2022-01-16 13:11:28','2022-01-17 10:36:55');
/*!40000 ALTER TABLE `tbl_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_products`
--

DROP TABLE IF EXISTS `tbl_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_guid` char(36) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `product_descprition` text NOT NULL,
  `product_main_photo` text NOT NULL,
  `min_price` int(10) unsigned NOT NULL,
  `max_price` int(10) unsigned NOT NULL,
  `warranty` varchar(200) DEFAULT NULL,
  `product_gallery_images` text,
  `created_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=350 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_products`
--

LOCK TABLES `tbl_products` WRITE;
/*!40000 ALTER TABLE `tbl_products` DISABLE KEYS */;
INSERT INTO `tbl_products` VALUES (220,'c637a0a0-a65f-d6a2-7b3a-fede1c377977',7,'מערכת שמע WIFI דגם U2','מערכת שמע עוצמתית עם מסך מגע.\r\\n\r\\nחיבור ל- WIFI\r\\n\r\\nתאורת לד מובנית הנשלטת במכשיר.\r\\n\r\\nכניסת USB, AUDIO, כרטיס זיכרון\r\\n\r\\nאפשרות חיבור 2 מיקרופונים בו זמנית.\r\\n\r\\n&nbsp;\r\\n\r\\n&nbsp;\r\\n\r\\n&nbsp;\r\\n\r\\n&nbsp;\r\\n\r\\n&nbsp;','1640627714-5e276188-5714-2a8d-5943-6811a35dad84.jpg',50,100,'שנה','[\"1640627714-b97287f6-9c14-66ce-8d88-c5cfc2f8b714.jpg\"]','2021-12-27 19:55:14',NULL),(221,'0291ee29-abe6-7867-e8fa-c8bfee94ee56',7,'מיניספיקר BT דגם רדיוהד','מיניספיקר רמקול BT נייד \\nתצוגה דיגיטלית, ,תאורת לד מתחלפת\\nפלט 15W*2\\n3.7V 1200mA\\nמידות 4\"*2','1640627714-adc5d8b6-8bc3-22d7-12da-d7011565d0ca.jpg',50,100,'שנה','[\"1640627714-ab17774c-19a2-b9a2-6164-870a5fb0b277.jpg\"]','2021-12-27 19:55:14',NULL),(222,'bfcb9cbb-8c04-799c-90ce-28e20107e67e',7,'מערכת שמע עוצמתית דגם מטליק','','1640627714-b1cb082e-a79e-2b7f-cf1b-55a3998003b3.jpg',50,100,'שנה','[\"1640627714-b1bafdb3-f9e7-f8a5-ab11-240dae3627ce.jpg\"]','2021-12-27 19:55:14',NULL),(223,'d8262d33-fb5a-6ab9-038b-ca9bf624e2b2',8,'טרמוס נירוסטה HAMMER','תכולה 500 מ\"ל','1640627714-4e3bef7b-0695-b6a2-a46a-98e8fc4074aa.jpg',50,100,'שנה','[\"1640627714-94b99975-79d4-ab14-2fbc-4f0b8ab2e5c3.jpg\"]','2021-12-27 19:55:14',NULL),(224,'52d4f276-c945-3cf4-675b-3f3fb9281f86',8,'בקבוק טרמי ROCK','בקבוק ספורט טרמי דגם ROCK\\nתכולה: 600 מ\"ל','1640627714-55a0a76c-1514-4eec-a787-124d34b5e8dc.jpg',50,100,'שנה','[\"1640627714-97e77044-df57-c25c-d786-34f3a290a355.jpg\"]','2021-12-27 19:55:14',NULL),(225,'30917e25-0941-1f0c-d455-688ac74a69d8',8,'בקבוק ספורט','','1640627714-3adfdb0d-77b9-f419-f74e-5d2156df3dfa.jpg',50,100,'שנה','[\"1640627714-b1520cbd-b008-393c-420c-4ad992a946b6.jpg\"]','2021-12-27 19:55:14',NULL),(226,'12d7dd96-0b94-f9e8-1537-8ef31d6ac4a4',8,'בקבוק טרמי MILK','בקבוק טרמי מתכתי מעוצב כולל מכסה שהופך לספל שתיה\\n\\nתכולה 300 מ\"ל\\n\\nגוף הבקבוק - צבע לבן עם כיתוב - שחור וזהב\\n\\n&nbsp;\\n\\n&nbsp;\\n\\n&nbsp;','1640627715-f58b5c68-7adc-970e-8f57-5e3dadd72b76.jpg',50,100,'שנה','[\"1640627715-a369c2af-baca-674d-3bb3-858ace6dc7a3.jpg\"]','2021-12-27 19:55:15',NULL),(227,'2edb3c2f-99d9-69f0-5ab8-8b96d58e5ae1',8,'כוס שתייה עם כפית \'נאפולי\'','כוס שתייה אישית שקופה דופן כפולה עם סגירת סיליקון\r\\n\r\\nכולל כפית דגם נאפולי ורצועת סיליקון סביב הכוס לאחיזה\r\\n\r\\n&nbsp;','1640627715-bf8a9699-25bb-25ac-4d62-44e750e2799a.png',50,100,'שנה','[\"1640627715-61a0fc3f-236e-0f61-88ed-66c790ef2d01.jpg\"]','2021-12-27 19:55:15',NULL),(228,'b275689f-746b-ef96-58f3-05f62d9659b2',8,'גלגל כלי עבודה','','1640627715-dd6368bf-6f94-697e-0468-abf482d4777e.jpg',50,100,'שנה','[\"1640627715-f18b383e-2a0b-8c50-7101-eb546a68ab8f.jpg\"]','2021-12-27 19:55:15',NULL),(229,'46c4971b-bf91-6e64-0d92-a7f6ef81041f',8,'מטען נייד  2600MAH','דגם ליפסטיק','1640627715-753a607e-fd6f-1897-31ce-8b2600daa90a.jpg',50,100,'שנה','[\"1640627715-1294ffdb-f25f-9b5c-60ed-aa15f7e59d18.jpg\"]','2021-12-27 19:55:15',NULL),(230,'a47ca043-98e2-f5a0-dc63-a13187b256a3',8,'משטח לנייד כולל מנורה','משטח קשיח להנחת מחשב נייד עם מנורת לד נטען\\n\\n(סוללות פנימיות)','1640627715-e8f11db8-1213-9749-c50c-bf9ed2a416c9.jpg',50,100,'שנה','[\"1640627715-6f054688-da26-3b90-cb5c-8dd512bfa972.jpg\"]','2021-12-27 19:55:15',NULL),(231,'ef7dcbac-0767-9dfb-6128-9a4137fe8c43',8,'ערכת התנעה לרכב 16K MAh','ג\'אמפ סטארטר 16,000MAh\\n\\nבנק כוח וכבל טעינת טלפון עם מטען המתאם רכב קליפ וסוללה במכונית + אור + מחבר למחשב נייד והוראות הפעלה קלט 12V/2A/5V DC12V\\n\\nפלט 12V 2A 19V 3.5A\\n\\nFCC לתנע קפיצת מכונית , טלפון חכם , מתאים ל PSP MP4/MP3 וכו\'','1640627715-394cdb25-fe47-cf31-ff1a-377fa4ec983e.jpg',50,100,'שנה','[\"1640627715-8dfcf03c-d1f0-4847-45fa-e8ea74089f8f.jpg\"]','2021-12-27 19:55:15',NULL),(232,'7c736bad-3733-63aa-aa53-44be71526ab0',8,'תחתית אלחוטית לטעינת נייד דגם גינס','מהירות טעינה גבוהה - הספק עד 1.5A\r\\n\r\\nגודל: 100X9.5 מ\"מ\r\\n\r\\nמתאים למכשירי סמסונג גלקסי 6 ומעלה, אייפון 8/X ולמכשירי LG- G6.','1640627715-1a2bb191-01b4-ae32-f937-8ebc8af22092.png',150,250,'שנה','[\"1640627715-83b301da-1107-bdbd-bcc6-3a8d8deb0f54.jpg\"]','2021-12-27 19:55:15',NULL),(233,'2b24d47c-cf88-59e1-d3f4-30d88e49a98a',8,'מיניספיקר בלתי שביר דגם שמשון','מיניספיקר בעיצוב אלגנטי עשוי פלסטיק קשיח במיוחד למניעת שבר.\\nסאונד עוצמתי במיוחד.\\nצג עם תאורה מתחלפת.\\nסוללת ליתיום מובנית 3.7V\\nאפשרות חיבור מיקרופון, דיסק און קיי, כבל USB, כרטיס זיכרון','1640627715-b192a82a-d95d-a314-7d63-a28ec3f4ae6a.jpg',150,250,'שנה','[\"1640627716-51749749-31e9-5a76-561c-b4bafc0a2987.jpg\"]','2021-12-27 19:55:16',NULL),(234,'3ea951a5-3a1d-abac-8a62-da8791a76034',8,'רמקול Bluetooth עמיד במים דגם WATER','רמקול BLUETOOTH עמיד למים בעיצוב חדשני כולל וו סיליקון לתליה בואקום על קרמיקה / זכוכית או כל משטח חלק.\r\\nלהשמעת מוזיקה וקבלת שיחות טלפון,\r\\nמתאים לשימוש לאמבטיה, לים ולבריכה. צליל נקי ואיכותי.\r\\nמתאים לכל מכשיר בעל יכולת שידור Bluetooth.','1640627716-2e690b7d-2115-bc40-4d2e-386974aea259.jpg',150,250,'שנה','[\"1640627716-3a66e77a-cc22-a51d-26ec-c09abceab961.jpg\"]','2021-12-27 19:55:16',NULL),(235,'6e640863-4d20-0c03-5a73-162046cee59f',8,'מיניספיקר דגם ביט','מיני ספיקר Bluetooth בעיצוב ייחודי\r\\n\r\\nרדיו FM מובנה\r\\nאיכות ועוצמת שמע גבוהים במיוחד.','1640627716-ba29a110-9218-a6c1-8139-a9cdc8966514.jpg',150,250,'שנה','[\"1640627716-165aec8a-6a8a-ba29-2d48-efec4ea87592.jpg\"]','2021-12-27 19:55:16',NULL),(236,'e66971ae-b9f8-4530-1e99-62a445a735f1',8,'מיניספיקר עמיד במים דגם DIVING','רמקול BLUETOOTH מעוצב עמיד במים להשמעת מוזיקה וקבלת שיחות טלפון.\\nמתאים לשימוש לאמבטיה, לים ולבריכה. \\nאיכות שמע גבוהה.\\nעם צמדן ואקום, כולל סוללה נטענת, מתאים לתליה על כל משטח חלק.\\nצבע לבחירה: שחור / לבן','1640627716-28adbadb-c8a0-4d62-5888-4b1b2718d6da.jpg',150,250,'שנה','[\"1640627716-c3e6cd58-84d9-6fd5-c63a-9005b20cc7a0.jpg\"]','2021-12-27 19:55:16',NULL),(237,'0f9de49e-ed26-eaac-0741-438c0ee66a80',8,'מנורה שולחנית ורמקול BT','מנורת שולחן משולבת רמקול BT איכותי.\\nשעון דיגיטלי בבסיס המנורה.\\nצבע ראש המנורה מתחלף בנגיעה על הרמקול העליון.\\nשליטה במגע ודרך אפליקציה מהנייד.','1640627716-dd1fe4ab-40ae-528e-fac8-cab65f32e2e7.jpg',150,250,'שנה','[\"1640627716-faf3d9c8-5215-2249-228a-90f9843893d4.jpg\"]','2021-12-27 19:55:16',NULL),(238,'eb5e798e-e7a0-bed3-79b5-24997ca5de64',8,'אוזניות Bluetooth דגם GOLD','אוזניות רכות ונעימות לשימוש בעיצוב מודרני ומרשים המתקפלות לגודל מינימלי.\\nאוזניות BT מאפשרות הנאה והאזנה ממוזיקה באיכות דיגיטלית.\\nומעבר ממוסיקה לשיחה בנייד.\\nתומך בהתקן מוסיקה דרך מחשב נייד, טאבלט, טלפון נייד וכל מכשיר בעל התקן Bluetooth.\\nצבע לבחירה: שחור, אדום, כחול, חום.','1640627716-180e11ff-cde3-b737-70d2-afed97a351ce.jpg',150,250,'שנה','[\"1640627716-41e9aeff-faaf-f6f0-fd3d-508fc2996c38.jpg\"]','2021-12-27 19:55:16',NULL),(239,'b73493ae-5522-858d-c041-c93094e68537',8,'מעמד לפלאפון לרכב דגם Charge','מעמד ומטען לנייד לרכב\\nכולל כבל טעינה USB \\nקליפס לתלייה על סורגי מזגן הרכב\\nפתיחה וסגירה מכנית\\nכולל טעינה אלחוטית מובנית\\nמתח כניסה: 5V/2A & 9V/1.67A \\nקלט: (15W (max\\nפלט: (10W (max','1640627716-035421e0-b7f9-e16f-e14b-a2834e43db9e.jpg',150,250,'שנה','[\"1640627716-0d505ba3-2da3-978b-130e-336116ff6c35.jpg\"]','2021-12-27 19:55:16',NULL),(240,'f043491b-c825-f5d5-9ec4-d5c92184f012',8,'מאוורר ומנורת שולחן','מאוורר שולחני בעל זרוע מתכווננת ופנס עוצמתי במרכז המאוורר.\\nכפתור הפעלה מואר ומחליף צבעים.','1640627716-ec854394-3184-c97d-bf14-19a25c61483e.jpg',150,250,'שנה','[\"1640627716-0877ff98-83db-4a7f-5e2f-2ad00135b735.jpg\"]','2021-12-27 19:55:16',NULL),(241,'ee722b0b-dbdc-ed94-9b39-49b76482c083',8,'אוזניות BT  דגם ספיקר','אוזנייה BlueTooth שבסיבוב האוזנייה מאפשרת מעבר משמע אישי לשמיעה ברמקול.\r\\nאיכות שמע גבוהה\r\\nכניסות מיני SD\r\\nיציאות למכשירים חכמים, רדיו מובנה\r\\n\r\\nרמת שמע MP3','1640627716-94b35dd7-387b-f335-9ca5-2435da9b98f8.jpg',150,250,'שנה','[\"1640627717-94fef485-e235-2250-5f9f-dcd5d64c5dd5.jpg\"]','2021-12-27 19:55:17',NULL),(242,'cd221d51-89ea-df81-9f64-b307d159e86a',8,'מטען נייד שביט 10K MAH','איכות חומרים גבוהה , הזנה אלחוטית  1.5A\r\\n\r\\nINPUT :DC5V/2A\r\\n\r\\nOUTPUT1 :1A\r\\n\r\\nOUTPUT2:2A\r\\n\r\\n(2 יציאות הזנה באמצעות כבל 1A ו. 2A)\r\\n\r\\nכולל פנס לד\r\\n\r\\nאיכות הסוללות המובנות במכשיר מקנות למכשיר את תצורתו הדקה ואיכות ההזנה הגבוהה\r\\n\r\\n&nbsp;','1640627717-cd66bc60-0d5a-732d-72f9-bd1d0e652737.jpg',150,250,'שנה','[\"1640627717-392c396a-f5b7-825c-ed81-5066e7c288a1.jpg\"]','2021-12-27 19:55:17',NULL),(244,'266f7c43-57bf-71d1-7a19-b1bebb9668cd',8,'מיוזיק בוקס דגם דבלין','בלוטוס עם צג דיגיטלי\r\\nאיכות שמע גבוהה במיוחד ברמת MP3\r\\nרדיו FM מובנה\r\\nהספק יציאה: 5W\r\\nיחס קול :&gt;75DB\r\\nמתח סוללה: 3.7V\r\\nהספק כניסה: 5V\r\\nמפרט 2.1V +  EDR\r\\nפרוטוקול חיבור: A2DP1.2\r\\nמרחק שידור: 10M\r\\nחיבורים וכניסות לכל המכשירים החכמים הרלוונטים MS CARD , USB,  AUX וכו\'\r\\n\r\\n&nbsp;','1640627717-0c9785c3-3617-8ce2-45a2-bf6080ef43d1.jpg',100,200,'שנה','[\"1640627717-488d3983-38dc-4336-a100-e771b7e7635f.jpg\"]','2021-12-27 19:55:17',NULL),(246,'c45ce73f-10e9-a26d-7a25-e803a614bebb',8,'מיוזיק בוקס מנורה-הילה','מערכת שמע בלוטוס, הזנה ופוואר בנק  4000MAH\r\\n\r\\nכולל כניסת USB  וכרטיס זיכרון\r\\n\r\\nאפשרות ל 3 עוצמות תאורה בבסיס הנורה\r\\n\r\\nניתן להחליף את צבעי  הבסיס על ידי מגע בחיישן התאורה (הנמצא במרכז הנורה ) - טאץ\'\r\\n\r\\n35 נורות לד\r\\n\r\\n&nbsp;','1640627717-29339ab4-5683-67cd-60c5-fe6f1dce4aaa.jpg',100,200,'שנה','[\"1640627717-36155482-9a8a-244b-581e-6d1d84299b44.jpg\"]','2021-12-27 19:55:17',NULL),(248,'408c1952-3779-6019-4eb7-e2520faecf09',7,'מערכת שמע דגם U2','מערכת שמע עוצמתית עם מסך מגע.\r\\n\r\\nתאורת לד מובנית הנשלטת במכשיר.\r\\n\r\\nכניסת USB, AUDIO, כרטיס זיכרון\r\\n\r\\nאפשרות חיבור 2 מיקרופונים בו זמנית.\r\\n\r\\n&nbsp;\r\\n\r\\n&nbsp;\r\\n\r\\n&nbsp;\r\\n\r\\n&nbsp;\r\\n\r\\n&nbsp;','1640627717-b39cb56f-7982-0aea-f48a-cff40af48c63.jpg',100,200,'שנה','[\"1640627717-cb4cacb9-aea3-32c8-3c46-e66b12a4c4c2.jpg\"]','2021-12-27 19:55:17',NULL),(251,'d4a9ba03-de9d-3b3f-c145-3f8fee32ab70',8,'אוזניות רב שימושיות .DOM','משמשות להאזנה למוזיקה מנגני MP3, טלפון סלולרי או מחשב.\\nמאפשר האזנה רציפה לערוצי רדיו FM .','1640627718-a9532b77-19a2-03ad-96f2-368613fd6a1d.jpg',100,200,'שנה','[\"1640627718-24e79487-2909-7a5e-1536-e340f797fda6.jpg\"]','2021-12-27 19:55:18',NULL),(252,'2303cc00-6782-6fe4-eb61-5ef1db3783f9',8,'מטען נייד  MAH2400 Power Bank','','1640627718-43551716-d05a-f044-1a0c-a489f75cd882.jpg',100,200,'שנה','[\"1640627718-ccbb5974-369f-5391-2591-50c631fd8d06.jpg\"]','2021-12-27 19:55:18',NULL),(256,'e4f921b2-19be-5b70-40bd-a6f86d21e706',8,'מעמד מכני לנייד דגם מכניק','מעמד מכני לנייד דגם \'כנפיים\'\\nלתלייה על תריסי המזגן','1640627719-e84ea17d-45b4-5030-314e-33c546d6e9fc.jpg',400,600,'שנה','[\"1640627719-6344750c-a1f5-45da-8584-7b05a8f31be1.jpg\"]','2021-12-27 19:55:19',NULL),(257,'be6daad8-8863-1fb2-83cd-c840c3ca1744',8,'מעמד אוטומטי לנייד דגם \'אליגטור\'','מעמד אוטומטי לנייד לרכב\\nפתיחה וסגירת הכנפיים האוחזות בנייד בעזרת חיישן חכם המזהה את תנועת היד.\\nמידות: 24*65*132 (mm)\\nעיצוב מרהיב ויוקרתי\\nקלט DC5V 2A DC9V 1.6A\\nתדירות 110-205KHz','1640627719-4b4e8670-fc42-1a7b-a524-b3567cb27cfe.jpg',400,600,'שנה','[\"1640627719-b2cad202-cd7f-f5b5-b52b-a8724defeee1.jpg\"]','2021-12-27 19:55:19',NULL),(258,'4bba1d75-f43a-6af2-4c34-ef574a837e0d',8,'מיניספיקר אלחוטי דגם ג\'וניור','רמקול עוצמתי אלחוטי עם תאורה מתחלפת\r\\n\r\\nרדיו FM מובנה\r\\n\r\\nעם ידית לאחיזה נוחה\r\\n\r\\nקיבולת סוללה 1200mAh\r\\n\r\\nמשקל 0.5kg','1640627719-9b06f822-3063-aa49-49c4-59374b1535ef.jpg',400,600,'שנה','[\"1640627719-afc8c14c-a2a7-4a2f-959d-8f997e409a54.jpg\"]','2021-12-27 19:55:19',NULL),(259,'5f2fbd51-bb17-d679-1f28-2a739520adf3',8,'מערכת שמע עוצמתית דגם QUEEN','מערכת שמע עוצמתית אלחוטית BT \\nעם אפשרות לתוספת מקרופונים','1640627719-f0a3a405-c5c6-ccfc-3902-a3c54a760998.jpg',400,600,'שנה','[\"1640627719-b8f2aeb8-5812-89ad-ff7a-7dbd4dd33956.jpg\"]','2021-12-27 19:55:19',NULL),(260,'4e3f0fd2-44d4-a8d7-d409-21c24e56c950',8,'מיניספיקר BT דגם אלפא','רמקול עוצמתי אלחוטי נייד\r\\n\r\\nחיבור אלחוטי / כרטיס TF / כניסת USB / כניסת AUX\r\\n\r\\nתדירות תגובה: 100Hz - 16KHz\r\\n\r\\nסוללת ליתיום 3.7V 1200mAh\r\\n\r\\nזמן הפעלה: עד 5 שעות\r\\n\r\\nזמן טעינה: 2.5-3 שעות\r\\n\r\\nמתח כניסה: DC5V - 500mAh\r\\n\r\\n&nbsp;','1640627719-60cb459a-f8e4-3aa3-0228-c32e454dc269.jpg',400,600,'שנה','[\"1640627719-5b64aa0d-127e-4680-24eb-454b1b76ab69.jpg\"]','2021-12-27 19:55:19',NULL),(261,'a97f620a-cb28-2423-76a5-00a0c756d358',8,'מיניספיקר BT דגם רומאו','רמקול עוצמתי אלחוטי נייד\r\\n\r\\nחיבור אלחוטי / כרטיס TF / כניסת USB / כניסת AUX\r\\n\r\\nתדירות תגובה: 100Hz - 16KHz\r\\n\r\\nסוללת ליתיום 3.7V 1200mAh\r\\n\r\\nזמן הפעלה: עד 5 שעות\r\\n\r\\nזמן טעינה: 2.5-3 שעות\r\\n\r\\nמתח כניסה: DC5V - 500mAh\r\\n\r\\n&nbsp;','1640627720-857390be-7696-2324-602f-c5c0f4d70a22.jpg',400,600,'שנה','[\"1640627720-ed954e56-2adb-92f4-a824-a29e709bda08.jpg\"]','2021-12-27 19:55:20',NULL),(262,'568a59e7-f1b5-c303-3042-e3746f8392ea',8,'מיניספיקר BT דגם MOHAR','כולל תאורת לד\\nחיבורי FM / MIC / USB / TF / AUX\\nסוללה נטענת מובנית\\nסוללה: 3.7V 1500mAh','1640627720-8f8493eb-2665-90bb-e0e3-40f9efa59e38.jpg',400,600,'שנה','[\"1640627720-ae8fb6ef-844c-8aca-bffc-ff31627b8495.jpg\"]','2021-12-27 19:55:20',NULL),(263,'a46b324f-7e7d-91a8-1392-8869ad2f0a28',8,'אוזניות BT דגם i11','אוזניות אלחוטיות איכותיות הכוללות כיסוי לשמירה וטעינה.\r\\n\r\\nהאוזניות מתאימות לשמיעת מוזיקה ולשיחה במהלך ביצוע פעילות גופנית.','1640627720-15de56bd-88de-02b1-292e-f0a6baf1e94f.png',600,800,'שנה','[\"1640627720-00a9fd4a-60c7-1e9a-aa1b-c1e849fc7228.jpg\"]','2021-12-27 19:55:20',NULL),(264,'de79b962-4144-ddda-4ca4-f6a5bd63fa44',8,'דגל ישראל 1.1X0.8 מ\'','','1640627720-c7588b51-3c02-4d45-3de8-58dc996a1a93.jpg',600,800,'שנה','[\"1640627720-4872bb51-241d-d548-0df8-0da93a9fea16.jpg\"]','2021-12-27 19:55:20',NULL),(265,'1cf358fb-2599-1047-bc38-b7dc8b5062c1',9,'מארז 5 מגבות גוף דגם עדן','מידות 140*70\r\\n\r\\n550 גרם\r\\n\r\\n&nbsp;','1640627720-bc5b9857-4b2e-2188-9f05-99d8d31c9fd2.png',600,800,'שנה','[\"1640627720-03563389-8bc5-550f-06f3-b191f26d922a.jpg\"]','2021-12-27 19:55:20',NULL),(267,'f300db89-c08d-f55f-b225-be0435f91745',9,'חלוק מגבת 100% כותנה','','1640627720-dae72ecc-a8da-6121-1537-a4e54f4ed163.jpg',600,800,'שנה','[\"1640627720-e9942c70-fd42-f027-618e-9781b35ed142.jpg\"]','2021-12-27 19:55:20',NULL),(268,'fc6e1c93-486f-714f-5162-8c532d8c2249',9,'מארז 4 מגבות פנים דגם חרצית','מארז מהודר בצלופן\r\\n\r\\nמכיל 4 מגבות פנים איכותיות במידות 30X70','1640627720-9be49ff9-46d8-051a-b1ba-2ee669c92564.jpg',600,800,'שנה','[\"1640627720-7ec3472d-eb7a-ccdb-fc84-427ed562b4fe.jpg\"]','2021-12-27 19:55:20',NULL),(269,'ca87c856-2b74-5c85-a944-06dda05a329d',9,'מגבת ענקית דגם משי','מגבת מלטפת עם דוגמת פסים\\n\\nמידות 70X150\\n\\n100% כותנה\\n850 גרם / מ\"ר\\n\\nצפיפות ואריגה גבוהה','1640627721-d34baee3-bc1d-edb7-259e-19097ccca78a.jpg',600,800,'שנה','[\"1640627721-97917a51-11f8-481e-d0dc-04b106194499.jpg\"]','2021-12-27 19:55:21',NULL),(270,'3a65ae23-bd4e-7fae-714d-608dee54a632',9,'מפות שולחן מבד אל קמט','אלגנטית דוחה כתמים אל קמט (ללא גיהוץ)\\nגודל 150/250 ס\"מ','1640627721-077669dd-9f43-3923-f1c1-7541496399bb.jpg',600,800,'שנה','[\"1640627721-bfc0a628-4079-4dd0-ab51-bf5c3d92a3df.jpg\"]','2021-12-27 19:55:21',NULL),(273,'04567dc5-f5e4-6550-8f48-9d62527024e5',9,'מגבת גוף דגם שקד','מידות 140*70\r\\n\r\\n650 גרם\r\\n\r\\n100% כותנה\r\\nמגוון צבעים לבחירה','1640627721-7fe32db1-7818-0960-a0c5-73f155f58ed0.jpg',600,800,'שנה','[\"1640627721-711a9ac3-3cde-d9fd-b27d-41711891b57a.jpg\"]','2021-12-27 19:55:21',NULL),(275,'0988f397-9d45-451a-463f-bc348ebe818a',9,'מפת שולחן חגיגית לבנה','גודל 145/300 ס\"מ\\n\\nצבע לבן','1640627722-8cbfb630-3d61-ae45-4242-03b731203ddd.jpg',600,800,'שנה','[\"1640627722-e84eb7fa-71c8-7d12-1d9a-bfceaa961e84.jpg\"]','2021-12-27 19:55:22',NULL),(276,'70c7038b-157f-4e4b-7ea2-681d5b154525',9,'שמיכת מינק LUXURIOUS','שמיכת מינק דגםLUXURIOUS מפנקת ומהודרת\r\\n\r\\nמפרט טכני:\r\\n• חומר סינטטי משולב בחומרים טבעיים\r\\n• מילוי הולופייבר ואריג חיצוני עשוי מחומרים נושמים וסופגים השומרים ומבודדים מפני לחות!\r\\n• מיוצר בטכנולוגיה חדישה המפחיתה זיעה ומווסתת את טמפרטורת הגוף.\r\\n• דרגת חימום - דרגה 6 (הגבוהה ביותר)\r\\n• משקל השמיכה 2.5 ק\"ג','1640627722-5f6f07cb-fb53-be59-2cce-144dffd97f18.png',400,700,'שנה','[\"1640627722-0a144141-f1c5-e989-4e98-722f89761734.jpg\"]','2021-12-27 19:55:22',NULL),(278,'1a641f81-c217-a854-3546-94fd0cc6ebae',9,'סט איכותי לתינוק','','1640627722-f8deb87c-560a-e421-f0f6-a2447a1229f3.jpg',400,700,'שנה','[\"1640627722-8c1ba273-b373-afeb-2473-539c4af8ce46.jpg\"]','2021-12-27 19:55:22',NULL),(279,'0b1a6995-f9a2-25e0-9bd8-0de8609e0db3',9,'סט מצעים חדישים 100% כותנה דגם ניו-יורק','סט מצעי כותנה\r\\n\r\\nמידות:\r\\nסדין גומי – 250X250\r\\nציפה – 200X230\r\\nזוג ציפיות – 48X74','1640627722-c5ffb2b1-f690-89c4-338a-891c009c0dd1.jpg',400,700,'שנה','[\"1640627722-392c4ec1-026c-fb1e-f20a-000dda1136c0.jpg\"]','2021-12-27 19:55:22',NULL),(282,'6c40b66b-81da-7254-efb7-8fa5120e63ac',9,'קופסת אוכל דגם ביף','קופסת פלסטיק שקופה\r\\nגודל 1200 מ\"ל\r\\nBPA FREE - אישור מכון התקנים כולל אישור לשימוש במיקרוגל, סיליקון לאיטום.\r\\nאפשרות להדפסת לוגו על הקופסה\r\\nסוג נעילה LOCK. קומה אחת','1640627723-7b19fdd1-559f-d32d-7e77-17c8a8c19b2c.jpg',400,700,'שנה','[\"1640627723-71e047e8-a6a3-20d9-2947-0befc048c925.jpg\"]','2021-12-27 19:55:23',NULL),(283,'4bb675ce-23ff-9e02-60cc-b23c810a11c0',9,'סיר מטרון \"NON STICK 28','סיר אלומיניום יצוק לחימום מירבי 28 ס\"מ.\\nשומר על חלוקת חום מיטבית.','1640627723-0ade5e71-9437-6e87-d7ce-b4cb4c7e7a8a.jpg',400,700,'שנה','[\"1640627723-d8c4f157-733c-50b6-b486-4a41d18aecd5.jpg\"]','2021-12-27 19:55:23',NULL),(284,'89d08203-3bd0-b157-1456-f9b85b78a7d6',9,'סיר מטרון \"NON STICK  20','סיר אלומיניום יצוק לחימום מירבי 20 ס\"מ.\\nשומר על חלוקת חום מיטבית.','1640627723-2fc7de91-ead4-590e-f149-13eb044659b6.jpg',300,400,'שנה','[\"1640627723-90154a36-4a9f-f3f2-7f5e-6ca89e9d1b15.jpg\"]','2021-12-27 19:55:23',NULL),(285,'af2e622f-4e44-ef23-eb77-5a303ac7c263',9,'סיר מטרון \"NON STICK 24','סיר אלומיניום יצוק לחימום מירבי 24 ס\"מ.\\nשומר על חלוקת חום מיטבית.','1640627723-e7e70a9a-1942-2322-4ca4-d376dd354808.jpg',300,400,'שנה','[\"1640627723-2902856d-dd92-cefb-d2a8-c20a60f35612.jpg\"]','2021-12-27 19:55:23',NULL),(287,'2c84ca52-2dd4-788d-ed0a-271d191281d8',9,'סט סכו\"ם דגם MAZETI','24 חלקים עם עיטור עדין  - 6 כפות, 6 סכינים, 6 מזלגות, 6 כפיות\\n\\nנירוסטה אל-חלד 18/10\\n\\nהסט מגיע במזוודה מהודרת\\n\\n&nbsp;','1640627723-42800a5b-3614-deaf-9fe8-57b07c05f692.jpg',300,400,'שנה','[\"1640627723-fa9a8c54-37cd-f49d-a675-382108d3282a.jpg\"]','2021-12-27 19:55:23',NULL),(289,'ba564429-289a-9c58-f58c-c0629a268d8c',9,'סט 6 תבלינים - דגם קשת','סט 6 חלקים בצבעים שונים מנירוסטה למטבח.\\n\\nכולל בסיס מסתובב המאפשר גישה נוחה לכל החלקים.\\n\\nפטנט ייחודי לסגירה ואיטום לשמירה על טריות התבלינים.','1640627723-83d338ec-cf4f-00ff-e938-fd8c233e1be3.jpg',300,400,'שנה','[\"1640627724-3795c7af-8f4f-7e27-45d2-241668e81791.jpg\"]','2021-12-27 19:55:24',NULL),(290,'ffd75755-ba8b-746b-530b-f96cb876582d',9,'מחבת מטרון NON STICK 28','מחבת אלומיניום יצוק לחימום מירבי 28 ס\"מ.\\nשומר על חלוקת חום מיטבית.','1640627724-f929dabe-053d-2cf6-bcba-de420ae15599.jpg',300,400,'שנה','[\"1640627724-38972fd6-1a9b-493e-506d-d4bb152f3a97.jpg\"]','2021-12-27 19:55:24',NULL),(292,'6a531fcb-6ea8-c576-b4b5-23078437e50c',9,'מערכת סכו\"ם 24 חלקים דגם פירנצה','סט סכו\"ם יוקרתי מתכת נירוסטה מצופה - מוזהב - ידית מתכת צבועה לבן ל- 6 סועדים, למראה חגיגי בשולחן האוכל.\\n<ul>\\n 	<li>שטיפה ידנית בלבד</li>\\n</ul>\\n&nbsp;','1640627724-cf985b9b-0cf2-0cbe-cc0a-0e18fe15d7f4.jpg',600,800,'שנה','[\"1640627724-b2d1d195-1be6-7bc8-4f78-be344c15ad85.jpg\"]','2021-12-27 19:55:24',NULL),(293,'1590fc98-4529-3195-f819-ee619b8c53d8',9,'מערכת סכו\"ם 24 חלקים דגם ורונה','סט סכו\"ם יוקרתי מתכת נירוסטה מצופה - כחול - 6 סועדים, למראה חגיגי בשולחן האוכל.\\n<ul>\\n 	<li>שטיפה ידנית בלבד</li>\\n</ul>\\n&nbsp;','1640627724-61c6b49a-da62-2166-36ee-62d6ccea6180.jpg',600,800,'שנה','[\"1640627724-ccf0685f-8441-c415-ed98-955f768912df.jpg\"]','2021-12-27 19:55:24',NULL),(294,'2c39586d-2e68-01f5-e8c7-6723ba66c43f',9,'סט קופסאות דגם וואקום','סט 2 קופסאות ואקום לשמירה על טריות ומשאבה ידנית.\r\\n\r\\nהקופסאות עשויות פלסטיק חזק ועמיד במיוחד ושומרות על הסדר והטריות במטבח.\r\\n\r\\nתכולת הקופסאות: 1.1 ליטר, 2.2 ליטר.\r\\n\r\\nהקופסאות מתאימות להקפאה ולהדחה במדיח כלים.','1640627724-3dccd216-7d3d-0c9c-0dcf-c47c48f612d3.png',600,800,'שנה','[\"1640627724-09c87281-7418-bc35-2ed4-bb7637a3f919.jpg\"]','2021-12-27 19:55:24',NULL),(296,'69e9f2e7-6a94-deb3-7f66-d34acf21c18d',9,'חמישיית סכיני אל חלד על פס מגנט דגם מגנטו','חמישיית סכיני אל חלד על פס מגנטי\\nסכין שף\\nסכין לחיתוך בשר\\nסכין ארוכה לחיתוך ירקות\\nסכין לקיצוץ ירקות\\nסכין משוננת לחיתוך לחם\\n\\nגוון טורקיז','1640627724-aceec314-4282-3dee-5cfd-c08acebe96ae.jpg',600,800,'שנה','[\"1640627724-aea139b4-7602-27b4-b5ee-ffe131aab256.jpg\"]','2021-12-27 19:55:24',NULL),(297,'f9cd498e-2c2e-464d-111e-8e6c3f1b9f4f',9,'סט 3 קופסאות טרמיות \'טריו\'','3 קופסאות אחסון איכותיות פלדת אל-חלד כולל מכסים\r\\n\r\\nמתאים להקפאה','1640627724-7e8cef3d-38d8-72ea-0bc1-9175ab0021da.png',600,800,'שנה','[\"1640627725-9a3cec1d-b66c-79f3-5c6f-1437d80b49ea.jpg\"]','2021-12-27 19:55:25',NULL),(299,'18a54fba-2716-50df-ac05-373d1ebcb7c5',9,'קופסאות אוכל דגם Student','קופסת פלסטיק שקופה\r\\nגודל 18*10.5*10.5\r\\nBPA FREE, אישור מכון התקנים כולל אישור לשימוש במיקרוגל, סיליקון לאיטום.\r\\nאפשרות להדפסת לוגו על הקופסה\r\\nסוג נעיל LOCK קומותיים','1640627725-6c9b31c7-10b4-de82-a0b6-d9e7365f29f2.jpg',600,800,'שנה','[\"1640627725-6b536a0a-9911-c766-9b23-d5cd3a6d86e9.jpg\"]','2021-12-27 19:55:25',NULL),(301,'889b74d8-327a-12d0-69ed-89ea449e697c',9,'קרוסלת תבלינים','סט תבלינים במעמד מסתובב\\nנירוסטה /זכוכית עם ציפוי פולי פרופילן צבעוני','1640627725-0b9cab9d-c63d-4412-8357-9aac5732a258.jpg',600,800,'שנה','[\"1640627725-f1366235-d3d1-817b-28bd-f2d4c6a57173.jpg\"]','2021-12-27 19:55:25',NULL),(302,'e3c0958e-f017-4719-7795-6cbaf8f4773e',9,'בקבוק זכוכית שואב נוזל דגם קונפי','לבקבוק פטנט מדהים של שאיבת הנוזל על פי מידה ומזיגתו.\\nישנה הפרדה מוחלטת בין המיכל הגדול למיכל המדיד        (מתאים לחומץ / שמן / לימון וכו\')\\n<strong>עיצוב מרהיב וחדשני</strong>','1640627725-b25c8b0e-a116-3766-09b8-2bf4714261a3.jpg',1000,1200,'שנה','[\"1640627725-6234f81e-47b2-e087-b079-fcda25973d6b.jpg\"]','2021-12-27 19:55:25',NULL),(303,'0ea2b987-5352-6b1c-93af-836bacd8d9c0',9,'סט 4 סירי נירוסטה (18/10)','סט 8 חלקים מותאמים לאינדוקציה\\n\\nאיכות גבוהה ועיצוב מרהיב\\n\\nגדלים \"26,\"24, \"22, \"20','1640627725-a0fde618-eaa6-6969-05c9-44c76c6fe287.jpg',1000,1200,'שנה','[\"1640627725-acc53a1e-901d-980d-460b-b683162330e0.jpg\"]','2021-12-27 19:55:25',NULL),(304,'57d3ef39-ac73-019b-b3a4-ac19d1d593c7',9,'מגש מחולק דגם וירג\'יניה','מגש מנירוסטה לסלטים / פיצוחים בעל מכסה פלסטיק אטום, לשמירה על הטריות.\r\\n\r\\nמחולק ל-6 תאים.\r\\n\r\\nמתאים לאירוח ולטיולים.\r\\n\r\\n&nbsp;','1640627725-56b10ed3-5a48-a38f-d650-dc81e0c8998a.jpg',1000,1200,'שנה','[\"1640627725-33dc7ff6-2591-c25b-cf1c-223481673518.jpg\"]','2021-12-27 19:55:25',NULL),(305,'845d30bb-2e8b-ff2c-8918-30df792ca066',9,'סיר סוטאז\' שיש 24 ס\"מ \'רומא\'','<strong>סיר סוטאז\' מאלומיניום יצוק לחימום מירבי</strong>\r\\n\r\\nציפוי קרמי פנימי וחיצוני .\r\\n\r\\nעמיד בפני שריטות.\r\\n\r\\nקל לניקוי.\r\\n\r\\nPFOA free\r\\n\r\\n3.3 ליטר\r\\n\r\\n&nbsp;','1640627725-259f0c34-44cf-403f-0577-e567d5d69a42.png',1000,1200,'שנה','[\"1640627726-beb63a27-d207-b71d-af38-c5f7880bd482.jpg\"]','2021-12-27 19:55:26',NULL),(306,'711ef987-fe30-082e-d714-5476e07b0874',9,'מחבת סוטאז\' שיש 28 ס\"מ \'רומא\'','<strong>סיר אלומיניום יצוק לחימום מירבי</strong>\r\\n\r\\nציפוי קרמי פנימי וחיצוני .\r\\n\r\\nעמיד בפני שריטות.\r\\n\r\\nקל לניקוי.\r\\n\r\\nPFOA free\r\\n\r\\n2.88 ליטר\r\\n\r\\n&nbsp;','1640627726-5332348b-a429-3764-72ae-b9d32b6c92fc.png',1000,1200,'שנה','[\"1640627726-8bcfd567-1cf7-3d78-c5e4-42ace0c93492.jpg\"]','2021-12-27 19:55:26',NULL),(308,'ff81b763-f8d1-48ef-11a2-79d758804a99',9,'קרש חיתוך וסכין דגם מנו','קרש חיתוך איכותי עשוי במבוק\r\\n\r\\nמידות 35/24/1.5 ס\"מ\r\\n\r\\nסכין סנטוקו \"7','1640627726-db34e595-cfbb-e0ef-6871-3b4fe674ba3c.jpg',1000,1200,'שנה','[\"1640627726-d7ddc822-cb42-6573-7ee3-70ab164f4713.jpg\"]','2021-12-27 19:55:26',NULL),(310,'2eb02488-64ea-dd5d-d5d0-10fdc6eafe3c',9,'מערכת סכו\"ם 24 חלקים דגם ונציה','סט סכו\"ם יוקרתי מתכת נירוסטה מצופה - מוזהב - ידית מתכת צבועה שחור ל- 6 סועדים, למראה חגיגי בשולחן האוכל.\\n<ul>\\n 	<li>שטיפה ידנית בלבד</li>\\n</ul>\\n&nbsp;','1640627726-2b33783b-4fe5-c134-929f-c8dd9c82aa33.jpg',1000,1200,'שנה','[\"1640627726-ae445d90-bc8b-30ba-a50a-f58ecfe662c2.jpg\"]','2021-12-27 19:55:26',NULL),(311,'10f78a00-a3cc-50a3-0ff0-dd6911c1218d',9,'מערכת סכו\"ם 24 חלקים דגם טורינו','סט סכו\"ם יוקרתי מתכת נירוסטה מצופה - כחול - 6 סועדים, למראה חגיגי בשולחן האוכל.\\n<ul>\\n 	<li>שטיפה ידנית בלבד</li>\\n</ul>\\n&nbsp;','1640627726-89266c28-ed94-3a49-be48-e24fdae358a8.jpg',1000,1200,'שנה','[\"1640627726-dabb7ccd-8302-a223-79bf-5c6fdecdeea3.jpg\"]','2021-12-27 19:55:26',NULL),(312,'bb86b049-21cc-a3f9-80b3-3b94b96fbe10',9,'מערכת סכו\"ם 24 חלקים דגם בולוניה','סט סכו\"ם יוקרתי מתכת נירוסטה מצופה - כחול - 6 סועדים, למראה חגיגי בשולחן האוכל.\\n<ul>\\n 	<li>שטיפה ידנית בלבד</li>\\n</ul>\\n&nbsp;','1640627726-337fd43c-b0a1-5148-d45b-859efed88d2f.jpg',1000,1200,'שנה','[\"1640627726-9ae27a01-3b04-f43d-7f66-02212917258a.jpg\"]','2021-12-27 19:55:26',NULL),(313,'d9dc96e7-74d2-6029-316f-1d9eb88bc07a',9,'סכום 24 חלקים 18/10 דגם טורטליני','סט סכו\"ם 6 סועדים -24 חלקים 18/10\r\\n\r\\nבמארז מתנה מהודר','1640627726-ead340e3-85c1-e5b7-90df-5116ab4cbba7.png',1000,1200,'שנה','[\"1640627727-ef9027eb-8c52-e192-716c-cb71c9759fe7.jpg\"]','2021-12-27 19:55:27',NULL),(314,'709f086b-fdfe-9013-be95-42792273cdd6',9,'5 כלי ששת לבישול והגשה','סט 5 כלי ששת מתכת אל חלד לבישול והגשה\r\\n\r\\nכולל כף מסננת, מצקת, כף הגשה, תרוד וכף לפסטה.','1640627727-ec5869ec-f928-4182-1a81-89aead4fbd3b.png',1000,1200,'שנה','[\"1640627727-24d05b55-a637-625c-320f-4baa4d5ddf57.jpg\"]','2021-12-27 19:55:27',NULL),(315,'6abce49d-545c-f88d-2d91-cbf5faef3de2',9,'מחבת ווק עם תבנית אידוי דגם בנגקוק','מחבת ווק קוטר 36 ס\"מ כולל תבנית אידוי מבית המותג PERITO MORENO\r\n\\nציפוי NON STICK תלת שכבתי לבישול מהיר ומדוייק\r\n\\nתחתית אינדוקציה','1640627727-7a45ca2c-120c-7402-de76-7a280e27d062.jpg',300,400,'שנה','[\"1640627727-052e0234-006b-1817-e595-35d55e126350.jpg\"]','2021-12-27 19:55:27','2021-12-30 14:13:29'),(316,'a1022a77-fa9e-aa57-4b8c-1f190986294d',9,'כפות וקערת סלט, קעריות תואמות ומסחטים הדרים דגם שרי','סט דגם \'שרי\' עשוי פלסטיק קשיח הכולל:\r\\nקערת סלט, כפות הגשה, 4 קעריות סלט אישיות במגוון צבעים, מסחטת פירות הדר עם ראש מתחלף לסחיטת פירות גדולים.','1640627727-7380ea81-2a40-687d-f009-f30cf150fcc4.png',1000,1200,'שנה','[\"1640627727-9808f38e-5cf5-1697-5a1f-9f86e25cdc67.jpg\"]','2021-12-27 19:55:27',NULL),(317,'8b2ba2d5-6c05-eb5f-afd2-c016f9d5789e',9,'סט סכיני שף ומשחיז דגם מאסטר שף','סט 3 סכיני שף ומשחיז מבית PERITO MORENO\r\\nסכין שף - \"8 - 20 ס\"מ\r\\nסכין סנטוקו - \"7 - 17 ס\"מ\r\\nסכין ירקות \"5 - 13 ס\"מ','1640627727-31335b0f-ca88-073e-9dd8-f1f5c1e657f7.png',1000,1200,'שנה','[\"1640627727-68d5303c-8780-b6a7-3354-24f70adef831.jpg\"]','2021-12-27 19:55:27',NULL),(318,'7cdaea43-8118-26eb-c96b-685c811a3cff',9,'סיר מטרון  באריזה חגיגית','סיר אלומיניום יצוק לחימום מירבי ולשמירה על חלוקת חום מיטבית.\r\\n\r\\nנמכר במארז חגיגי עם תוספות עפ\"י מידת הסיר הרצוייה.','1640627727-e626770a-f76f-f220-a494-f51021b42bb8.jpg',1000,1200,'שנה','[\"1640627727-8a40747f-5ea4-74c8-ad28-e2b97df230dd.jpg\"]','2021-12-27 19:55:27',NULL),(319,'3366f553-f0ef-5f37-20ee-0e19f3c805ae',9,'סט קופסאות דגם וואקום','מארז 2 קופסאות וואקום איכותיות מבית Perito moreno, הכולל שתי קופסאות בגדלים שונים לשמירה על טריות המזון וערכיו התזונתיים.  הקופסאות מתאימות להקפאה ולשימוש במדיח כלים.\r\n\r\nקופסאות הוואקום מסייעות לשמירה על איכות המזון, מעקבות חמצון וקלקול מיקרוביאלי ותורמות להארכת חיי המדף פי 4 משימור רגיל.!\r\n\r\nמפרט טכני:\r\n\r\nקופסה בנפח: 2.2.\r\nקופסה בנפח: 1.1.\r\nמכיל משאבה ייעודית להוצאת האוויר, לשמירה על טריות המזון.\r\nמתאים מדיח.\r\nמתאים להקפאה.','1640628412-ba08da2f-5bfa-3382-2320-3ff2c5cd5f87.jpg',100,200,'שנה','[\"1640628400-59cc22ad-4319-6829-bab1-a711e2de5e74.jpg\",\"1640628407-e20d9ba2-d398-09e1-7f4a-d20e2cc2bb08.jpg\"]','2021-12-27 20:06:52',NULL),(320,'c8f093d8-0135-7cad-d3f2-b85176def5ed',11,'תיק swiss דגם zug','תיק גב אלגנטי דגם swiss ZUG מסדרת המותגים האיכותית של Swiss, תיק עשוי חומרים איכותיים בעל 4 תאים גדולים ונגישים המכילים תאי אחסון ואבטוח של מכשירים אלקטרונים. תא ראשי גדול בתוספת תא מרופד לאחסון מחשב נייד עם אפשרות התאמה לגודל הרצוי.\r\n\r\nתוספות מיוחדות: אפשרות לכניסת USB  לסוללה ניידת , תא נסתר בחלקו האחורי של התיק למניעת גנבות.','1640628502-e6b0cea5-a13c-7888-ac97-ab4876ace238.png',100,200,'שנה','[\"1640628488-b24de51e-0c57-d47f-5909-7d9346d3dc1d.png\"]','2021-12-27 20:08:22',NULL),(321,'82734c60-926b-7e61-fb17-97380db46b80',9,'קערה פורצלן דגם ולנסיה','קערת פורצלן דגם ולנסיה המהודר, היא קערת הגשה איכותית לבית שפשוט כל בית צריך. היא מתאימה למגוון שימושים, כמו אחסון פירות וירקות וכמובן סלטים. ','1640628792-abd956e0-6a60-46ec-96fe-277d9e506631.jpg',100,300,'אין','[\"1640628791-ef556116-4de7-4a89-769a-b8ca4c542b4e.png\"]','2021-12-27 20:13:12',NULL),(322,'07ddf643-6449-698c-062d-da4490606057',11,'תיק מנהלים דגם דן limited','תיק גב דגם דן  Limited, מסדרת התיקים האיכותיים של EAGLE EYE.  \r\n\r\nתיק גב בעל 3 תאים, מערכת גב ורפידות אורטופדיות, תא מרכזי גדול עם תא מרופד לנשיאת מחשב נייד.\r\n\r\nתוספות מיוחדות: כניסת USB ו AUX לטעינת מחשב/פלאפון נייד. בנוסף כניסת AUX  לשמיעת מוסיקה.\r\n\r\nרצועת נשיאה אחורית שמאפשרת תלייה של התיק על גבי מזוודה.\r\n\r\nתא נסתר נגד גניבות.','1640628970-dee2972d-9b14-bf64-9035-8ccdd2875b9b.jpg',50,150,'שנה','[\"1640628942-a8066000-cdca-5968-eafc-2fd82e8894a9.jpg\",\"1640628959-24b8b201-5c88-5d20-282e-7784ce04a274.jpg\"]','2021-12-27 20:16:10',NULL),(323,'3cfcd448-dbcb-c0db-186c-8b330b0c21f9',9,'סיר מחבת דגם cooper-chef','סיר בגודל 49.5 ס\"מ ציפוי NON STICK\r\nכולל מכסה עשוי זכוכית מחוסמת ,רשת שטוחה לאידוי וצלייה ורשת לטיגון עמוק.\r\n\r\nלסיר מבנה ייחודי בעל 5 שכבות:\r\n1 שכבה עליונה כפולה\r\nציפוי קרמי מוברש\r\nPFOA / PTFe free\r\n2 שכבת בסיס\r\nציפוי קרמי ללא הדבקות\r\n3 ליבת אלומיניום\r\nמספק מוליכות והפצת חום מעולה\r\n4 שכבה חיצונית\r\nציפוי חיצוני לטמפ\' גבוהה.\r\n5 בסיס אינדוקציה\r\nפלדת אל חלד אינדוקציה\r\nמתחמם במהירות ושומר על חום לאורך זמן','1640629116-ef8efd9b-8d05-a0f1-ee1d-5b9d1b1b3feb.jpg',150,300,'שנה','[\"1640629093-9cb416f9-e2bc-60ee-f330-b42c5095dad4.jpg\"]','2021-12-27 20:18:36',NULL),(324,'9c874687-1ce0-3e17-f1e1-e2d7835dd5e1',9,'מגבת ענקית דגם לילך','מידות  90X170\r\n\r\n100% כותנה\r\n850 גרם / מ\"ר\r\nצפיפות ואריגה גבוהה','1640629317-1da8e018-265c-4c9b-415c-2a9ecaedbae4.jpg',50,150,'שנה','[\"1640629294-35676415-5d71-f6a9-7450-9e2a985d516f.jpg\"]','2021-12-27 20:21:57',NULL),(325,'82dbf9ba-df97-e418-d401-5ec4ea9c2927',9,'שמיכת פוך שווצרית','שמיכה חורפית דו שכבתית מחממת במיוחד אל אלרגית\r\nמידות: 2.20X2.20 מ\'','1640629454-4bc7a3aa-a1de-aee6-61f0-b296fbb5b355.jpg',200,400,'שנה','[\"1640629667-5a611aab-49ed-c817-fb33-3cd3c5cf9bb0.jpg\"]','2021-12-27 20:24:14','2021-12-27 20:27:51'),(326,'e12a88f2-8df7-4cb4-109f-7d0667cb23fa',9,'מגבת תינוק רקומה','מגבת רחצה לילד / תינוק רקומה פיה / ברווז / ג\'ירפה\r\n\r\n100% כותנה\r\n\r\nארוז באריזה מהודרת','1640629810-e3febb2f-d015-3c48-6671-7785dd2d0c80.jpg',150,300,'שנה','[\"1640629784-e3b7a052-a2cd-fd10-b27c-7e3a4b224b2d.jpg\",\"1640629796-3d21a207-e3eb-7003-24cc-2fd70b9e9208.jpg\",\"1640629808-aea94171-3647-18c0-7b50-b426a1fe26e4.jpg\"]','2021-12-27 20:30:10',NULL),(327,'fd69f2ee-5797-af19-0563-e0be2e6938f3',9,'סט 5 מגבות פנים דגם תמר','מארז 5 מגבות פנים איכותיות במידות 30X70\r\n\r\nגוונים שונים לבחירה','1640629979-6c98cd9c-e3e0-3649-1621-9f057dd6fa00.jpg',100,200,'שנה','[\"1640629971-37f8a197-1cd2-1519-5de2-218a0f1ed16f.jpg\"]','2021-12-27 20:32:59',NULL),(328,'3f88141e-8ba3-403c-7823-585a4ba22d1a',8,'מטריה מתהפכת','מטרייה נפתחת בצורה הפוכה בכך מאפשרת קיפול  ללא הרטבת הסביבה\r\nדו שכבתית איכותית, חזקה במיוחד ועמידה בפני רוחות חזקות\r\nניתנת להעמדה או תלייה ביציבות מלאה כך מאפשרת קל ונוח לייבוש ואחסון\r\nידית ארגונומית בעיצוב גאוני מאפשרת אחיזה נוחה ומשחררת לנו את הידיים לפעולה נוספת\r\nמידות: מטריה 25 אינץ\', גובה 80 ס\"מ\r\nמשקל: 500 גר\' בלבד\r\nצבעים: כחול, שחור, לבן','1640630159-7a553af3-b038-2ca5-ea02-d654fadbc26e.jpg',50,100,'שנה','[\"1640630143-a7d65823-8ff1-3a6c-01a9-300c07ee6aa8.jpg\",\"1640630153-9f9194e2-48e7-a03b-397a-1fbdfcc8a76c.jpg\"]','2021-12-27 20:35:59',NULL),(329,'07d0c5ae-9e4f-91db-f4a7-71790434ebda',8,'מטען נייד 6000 mah','צג דיגיטלי (איכות חומרים וסוללה גבוהים במיוחד )\r\n\r\n2 יציאות הטענה להטענת  2 מכשירים בו זמנית\r\n\r\nכולל כבל מפצל, פנס לד חזק\r\n\r\nגוף מטען בצבע לבן','1640630333-a00dd413-ce3c-e83a-b348-1c274dbdf401.jpg',50,150,'שנה','[\"1640630323-9678a0bc-6f92-684b-b5ea-62ca23582fe3.jpg\"]','2021-12-27 20:38:53',NULL),(330,'81f112b1-c8fe-f2e4-5c8d-7c72441a00b3',8,'נוקר שמשות','מנפץ שמשות רכב וגם חותך חגורות בטיחות הניתן לבחירה מבין מגוון צבעים. מוצר שחייב להחזיק אותו ברכב למקרי חירום.','1640630559-8f99e01a-4b39-6ccc-13b8-5a99770b6965.jpg',50,100,'שנה','[\"1640630558-c51883ab-b4da-e159-e9bd-06a5c573e06a.jpg\"]','2021-12-27 20:42:39',NULL),(331,'5c57d590-3338-0394-2a1e-27e70e68c10f',5,'מיני ספיקר ומטען נייד גלקסי','מיני ספיקר בלוטוס, פוואר בנק 4000MAH\r\nכולל מוט סלפי באורך 50 ס\"מ\r\nמגוון צבעים לבחירה','1640630680-4a020375-b735-39ee-a987-8e4eae04c187.jpg',100,300,'שנה','[\"1640630668-f0ff34a2-f1de-7d32-414b-358cfa7fb0c6.jpg\",\"1640630676-de3536ca-6cf5-c9e3-846a-77205b375e4c.jpg\"]','2021-12-27 20:44:40',NULL),(332,'b378e8f6-85a6-152b-f38b-d86022c60615',9,'מראת סברובסקי','מראה נפתחת – 6X6 ס\"מ (בכל צד)\r\n\r\nחלק חיצוני מעוטר ומשובץ אבנים מבריקות.','1640631021-28b7af6e-4d7d-306e-ca3f-e5017ed92bc6.jpg',50,100,'שנה','[\"1640631018-d727f4c5-9563-c54b-2d96-56dda5a862b9.jpg\"]','2021-12-27 20:50:21',NULL),(333,'1db6f240-0ff9-c9ff-b793-68e6f473f67f',8,'אוזניות bluetooth','אוזנייה BlueTooth (תואם BIT)\r\nאיכות שמע גבוהה\r\nאטום לרעשים סביבתיים\r\nכניסות מיני SD\r\nיציאות למכשירים חכמים\r\nרדיו מובנה רמת שמע MP3.WMA\r\nאקולייזר\r\nמאפשר מענה לשיחות טלפון','1640631148-5f3435fa-edda-229c-3471-bc832747e052.jpg',150,300,'שנה','[\"1640631145-6e03ea60-de24-a971-be96-d34787a34684.jpg\"]','2021-12-27 20:52:28',NULL),(334,'0f11b6bf-5d00-e5f0-19d4-d6abbaa461b5',8,'מטען נייד דגם  vegas','POWER BANK דגם VEGAS\r\n10000MAH\r\nתאורה מתחלפת ידנית / אוטומטית\r\n2 יציאות הזנה + 2 כניסות הזנה\r\nמד הפעלה + מתג מצבי תאורה\r\nגודל: 15/7/1.5 ס\"מ\r\nניתן להזמין את לוגו החברה בהזמנה – מינימום הזמנה 500 יח\'','1640631252-64e09455-0ea0-ae34-060d-69ccb7332a70.jpg',100,200,'שנה','[\"1640631250-bce9a03a-883b-75b9-4a6f-dff7acad9d10.jpg\"]','2021-12-27 20:54:12',NULL),(335,'b4c8200e-8593-8525-c428-0e227e54e208',5,'מיני ספיקר שעון דגם big ban','בלוטוס , צג דיגיטלי, שעון מעורר\r\n\r\nכולל את כל הכניסות החכמות AUX, USB וכו\'\r\n\r\nרמת שמע MP3','1640631414-3981f064-2752-5cce-5a4a-4a4830bb3bda.jpg',50,150,'שנה','[\"1640631395-f709f323-9696-c00b-97ba-3b0816114610.jpg\",\"1640631405-cdbeebfe-4dd1-3fa5-f95d-13dbf1411f31.jpg\"]','2021-12-27 20:56:54',NULL),(336,'93491e9b-f9b8-3f0e-0c4f-4dbdd243255d',8,'מטען נייד דגם בריסל','איכות חומרים גבוהה , הזנה אלחוטית  1.5A\r\n\r\nINPUT :DC5V/2A\r\n\r\nOUTPUT1 :2A\r\n\r\nOUTPUT2 :2A\r\n\r\n(2 יציאות הזנה באמצעות כבל 1A ו. 2A)\r\n\r\nאיכות הסוללות המובנות במכשיר מקנות למכשיר את תצורתו הדקה ואיכות ההזנה הגבוהה','1640631496-1da5c847-0425-1d9f-bbc6-7c414d7647a8.jpg',150,300,'שנה','[\"1640631494-15097b25-07c7-0a5e-b7ab-b7db62c1ab9e.jpg\"]','2021-12-27 20:58:16',NULL),(338,'2de15477-f210-64fa-e18b-86946d87a46e',9,'מערכת סכום זהב 24 חלקים דגם מילאנו','סט סכו\"ם יוקרתי מתכת נירוסטה מצופה – מוזהב ל- 6 סועדים, למראה חגיגי בשולחן האוכל.\r\n\r\nשטיפה ידנית בלבד','1640631785-65f3f9d0-874d-617e-3a6e-f813c9f05626.jpg',200,400,'שנה','[\"1640631783-beddc085-7df4-d9bb-e95d-0467b0ed80d4.jpg\"]','2021-12-27 21:03:05',NULL),(339,'06bfd35b-8470-be6f-2ba9-beb35e99bad5',9,'סט קופסאות תרמיות 3 קומות','סט 4 חלקים מיועד לאחסון ושמירת קור/חום עם ידית נשיאה.\r\n\r\nאיכות חומרים גבוהה במיוחד (פנים עשוי נירוסטה)\r\n\r\nסה\"כ נפח 2.8 ליטר\r\n\r\nשומר חום/קור למשך 4-5 שעות','1640632034-b504d5b2-9840-9b5e-2d87-569a1ab1889c.jpg',50,100,'שנה','[\"1640632032-744ef36b-7cd8-1fad-7d8e-0882e9c38913.jpg\"]','2021-12-27 21:07:14',NULL),(340,'6be48e4d-4724-25f4-16ac-6c94712e1702',9,'סט מטבח דגם ','סט מטבח קומפקטי דגם Kitchen, מבית הכלים האיכותיים של Perito moreno. הסט כולל:\r\nפומפייה בעלת מכסה המאפשר שמירה על התוצר אחרי הגריסה, קולפן איכותי, פורס תפוחים, חותכן ארגונומי לפיצה, כף מדידה (לנוזלים / קמח) ומסננת סיליקון עם אפשרות קיפול יעילה לחיסכון במקום.','1640632146-299fdb35-89cd-fa8a-1c90-6b6aa31dcffd.jpg',100,300,'שנה','[\"1640632144-9c769d39-1f68-bcb8-4f1a-d94e9bc57ab5.jpg\"]','2021-12-27 21:09:06',NULL),(349,'2cf0595d-55a0-f24f-bc77-c876ce4d7a3e',13,'Test product','test descprition','1640886226-7f0acfc5-201d-9730-a8e9-6cc65a55a769.jpg',100,200,NULL,'[\"1640886227-e747b2ae-a5a7-a2f7-a02d-b5aff0d55b9f.jpg\",\"1640886229-84f43084-61be-1dad-3b25-eae443143793.jpg\"]','2021-12-30 19:43:49',NULL);
/*!40000 ALTER TABLE `tbl_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_types`
--

DROP TABLE IF EXISTS `tbl_user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_guid` char(36) NOT NULL,
  `user_type_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `is_admin` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `is_permitted` enum('No','Yes') NOT NULL DEFAULT 'Yes' COMMENT '(Yes will be only for Data Write option)',
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_type_name` (`user_type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_types`
--

LOCK TABLES `tbl_user_types` WRITE;
/*!40000 ALTER TABLE `tbl_user_types` DISABLE KEYS */;
INSERT INTO `tbl_user_types` VALUES (1,'','Super Admin','Yes','No','2020-07-20 08:15:00'),(2,'3a30e5e1-9ec3-11eb-94aa-74dfbfb4fcb7','Clients','Yes','Yes','2021-04-16 07:00:00'),(3,'3a30f346-9ec3-11eb-94aa-74dfbfb4fcb7','Employees','No','No','2021-04-16 07:00:00');
/*!40000 ALTER TABLE `tbl_user_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_guid` char(36) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `parent_user_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL COMMENT '(For employees)',
  `first_name` varchar(250) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(250) CHARACTER SET utf8 NOT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `employee_budget` int(11) DEFAULT NULL COMMENT '(For client)',
  `delivery_method` enum('Pickup','Door to Door','Both') DEFAULT NULL,
  `client_configs` text CHARACTER SET utf8,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `age` int(10) unsigned DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `login_session_key` varchar(255) DEFAULT NULL,
  `user_image` text,
  `user_token` varchar(500) DEFAULT NULL,
  `user_status` enum('Pending','Verified','Blocked','Order Placed') NOT NULL DEFAULT 'Pending',
  `created_date` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `total_credits` smallint(6) DEFAULT '0',
  `deadline` varchar(155) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `id` (`user_id`),
  KEY `country_id` (`country_id`),
  KEY `user_type_id` (`user_type_id`),
  KEY `user_type_id_2` (`user_type_id`),
  KEY `country_id_2` (`country_id`),
  KEY `state_id` (`state_id`),
  KEY `city_id` (`city_id`),
  KEY `city_id_2` (`city_id`),
  CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `tbl_user_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_users`
--

LOCK TABLES `tbl_users` WRITE;
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
INSERT INTO `tbl_users` VALUES (5,'453fa6aa-eed2-69fb-dea0-7d80ec88404e',1,NULL,NULL,'Galtex','App','admin@galtex.com','9090909091','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Male','55d6d618-d90c-de23-c543-611f760921e4',NULL,NULL,'Verified','2016-05-21 07:15:16','2022-01-17 11:53:00','2022-01-17 11:53:11',0,NULL),(43,'75b1523e-1ce0-0c3a-edb6-5638eac9d682',2,5,NULL,'אמיל','פרג\'ון','emile82@gmail.com',NULL,'e10adc3949ba59abbe56e057f20f883e',350,'Door to Door','{\"company_name\":\"\\u05dc\\u05d9\\u05de\\u05d0\\u05df\",\"contact_name\":\"\\u05d0\\u05de\\u05d9\\u05dc\",\"contact_number\":\"0536565683\",\"shop_title\":\"\\u05e8\\u05e7 \\u05d4\\u05d9\\u05d5\\u05dd \\u05de\\u05ea\\u05e0\\u05d5\\u05ea \\u05dc\\u05e2\\u05d5\\u05d1\\u05d3\\u05d9\\u05dd \\u05d1\\u05d7\\u05d9\\u05e0\\u05dd\",\"theme_color\":\"#f202ea\",\"company_logo\":\"1640605920-67deefc7-963e-33c8-c997-bd1875ee1357.jpg\"}',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-27 13:52:00','2021-12-29 13:56:04',NULL,0,'01/31/2022'),(140,'e9013a7c-003e-9f42-00ad-a27ec9de7f02',3,5,43,'שמשון','שהרבני','shimshonakis@gmail.com','536565681','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(141,'89183846-bfb1-4fed-bb23-b7a8bdaf37c4',3,5,43,'רני','כהן','Logo.rani@gmail.com','504092490','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(142,'b02a46fd-6c80-2223-532d-9c9f53bd4957',3,5,43,'אטסתי ','סמואלוב','Estysm2910@gmail.com','536565690','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(143,'a986be74-a82c-4a9d-c5ae-a65e5a313594',3,5,43,'עינב','נרקיס','einavnarkis12@gmail.com','524203369','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(144,'ab7c852e-909d-8c74-7e81-24e493c6f084',3,5,43,'רונן ','מלמד','ronen14564@gmail.com','542623550','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(145,'bf2b7ee4-2c58-aa23-a907-be54ce0dfb6f',3,5,43,'נעומי ','ורגה','Naomiv70@gmail.com','536565697','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(146,'523cc58b-4cfd-0497-1ff4-9c5de1fa9325',3,5,43,'נורית ','שהרבני','Nuritush299@gmail.com','556612643','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(147,'e0eded8c-2b98-9b6c-b52e-75d37b5df7cc',3,5,43,'אירנה ','ברקון','irabarkon222@gmail.com','545822870','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(148,'77eea6b5-e6b4-70e8-1513-07a4e1b36edd',3,5,43,'רבקה','יונס','rikingedaw@gmail.com','526560914','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(149,'32d88a1d-cc8f-f024-6cbf-6ce7009a1db9',3,5,43,'אסתר ','פרג\'ון','estherfargon@gmail.com','508424111','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(150,'d9e3f6b4-d271-56e2-53f2-c7c640a9a1bf',3,5,43,'אדיר','פרג\'ון','Adirfargeon@gmail.com','508424112','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(151,'2ad20bcf-f6e3-973c-bd7c-f72443bcef3b',3,5,43,'אופיר','פרג\'ון','Ofir.fargeon@gmail.com','509656558','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(152,'85a6752e-164f-5f19-dcc5-3954a24585a9',3,5,43,'שגיא ','מדניק','sagie.madnick@gmail.com','532294857','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-28 15:18:25',NULL,NULL,0,NULL),(153,'98ce9102-46e1-2c6b-5524-cc0676ce3638',3,5,43,'אסף ','פרג\'ון','assaf0704@gmail.com','508424113','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'07e6d736-fce6-857d-2d71-e704017d22cd',NULL,'923378','Verified','2021-12-28 15:18:25','2022-01-10 15:20:59','2022-01-10 15:21:13',0,NULL),(157,'71a68cb7-c322-908f-e438-de2e17ac4456',3,5,156,'גיא','שמואל','rondoy0@gmail.com','0546218486','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Male','9e146016-14f4-4796-24c5-1860296538f6',NULL,NULL,'Verified','2021-12-29 18:40:53','2022-01-02 09:15:14','2022-01-02 09:15:15',0,NULL),(159,'c29a8d65-fb92-e180-0ecb-de580f80f662',3,5,156,'עומר','שדה','Itay2@gmail.com','546948943','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Male','cc5a6ff6-3456-5fbe-1067-c5a0c89ffdf2',NULL,NULL,'Verified','2021-12-29 18:47:12','2021-12-30 20:16:29','2021-12-30 20:16:30',0,NULL),(160,'b09d950c-7213-74d0-20f5-ba613dd7fe76',3,5,156,'אורי','חיון','Itay3@gmail.com','544758345','202cb962ac59075b964b07152d234b70',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Male',NULL,NULL,NULL,'Verified','2021-12-29 18:47:12',NULL,NULL,0,NULL),(161,'af16d8df-30b5-620f-2d08-7538a0fda027',3,5,156,'עדי','ניגרי','Itay4@gmail.com','546218486','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2021-12-29 18:47:12',NULL,NULL,0,NULL),(162,'d9623ed5-9e80-bd5d-d350-7cf28259ede2',3,5,43,'תומר','ג\'יאן','tomer.gihan@gmail.com','0547949023','5ba578a48d1da9010de910512bc520ee',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'7c107419-91ba-6c4e-e815-7b680f0d9b56',NULL,'225331','Verified','2022-01-15 12:23:44','2022-01-15 12:38:04','2022-01-15 12:54:30',0,NULL),(163,'3234c609-e1a8-4263-3175-45b570c54cfb',2,5,NULL,'גיא','שמואל','tomer.gihan@yahoo.com',NULL,'e10adc3949ba59abbe56e057f20f883e',300,'Door to Door','{\"company_name\":\"\\u05e0\\u05d1\\u05d9 \\u05d9\\u05d5\\u05e0\\u05d4\",\"contact_name\":\"\\u05d2\\u05d9\\u05d0\",\"contact_number\":\"0544972064\",\"shop_title\":\"\\u05d1\\u05e8\\u05d5\\u05db\\u05d9\\u05dd \\u05d4\\u05d1\\u05d0\\u05d9\\u05dd\",\"theme_color\":\"#644fb0\",\"company_logo\":\"1642331015-3fd5c6a2-dc01-d167-70e5-9b248eb0bd43.jpg\"}',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2022-01-16 13:03:35','2022-01-16 13:06:35',NULL,0,'01/27/2022'),(164,'486f9ea1-0f25-29e0-a5bc-7e06d29459ab',3,5,163,'רועי','חי','roy.hai@gmail.com','549196096','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2022-01-16 13:04:25','2022-01-16 13:07:29',NULL,0,NULL),(165,'76a8d281-42dd-8332-a9a7-bcd1913617e4',3,164,163,'עמית','לוי','calaotlv.orders@gmail.com','547949023','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2022-01-16 13:10:00','2022-01-17 10:41:17',NULL,0,NULL),(166,'29a9356e-6666-a330-c3ff-4e7c5f24037d',2,5,NULL,'Abdul','John','calaotlv.service@gmail.com',NULL,'e10adc3949ba59abbe56e057f20f883e',300,'Both','{\"company_name\":\"google\",\"contact_name\":\"abdul\",\"contact_number\":\"0545949023\",\"shop_title\":\"happy holiday google family\",\"theme_color\":\"#d54d4d\",\"company_logo\":\"1642407663-a83d2c23-5fab-72b9-54c3-64dbc221d408.jpg\"}',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Verified','2022-01-17 10:21:03','2022-01-17 10:29:30',NULL,0,'NaN/NaN/NaN');
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-18  9:32:14
