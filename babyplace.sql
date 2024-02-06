-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: babyplace
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `babyplace`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `babyplace` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `babyplace`;

--
-- Table structure for table `administration`
--

DROP TABLE IF EXISTS `administration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL,
  `family_income` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_return` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caf_number` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residency_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banking_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discharge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family_record` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `divorce_decree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9FDD0D18727ACA70` (`parent_id`),
  CONSTRAINT `FK_9FDD0D18727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `family` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administration`
--

LOCK TABLES `administration` WRITE;
/*!40000 ALTER TABLE `administration` DISABLE KEYS */;
/*!40000 ALTER TABLE `administration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administration_creche`
--

DROP TABLE IF EXISTS `administration_creche`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administration_creche` (
  `administration_id` int NOT NULL,
  `creche_id` int NOT NULL,
  PRIMARY KEY (`administration_id`,`creche_id`),
  KEY `IDX_EFFF052639B8E743` (`administration_id`),
  KEY `IDX_EFFF05266C6060B` (`creche_id`),
  CONSTRAINT `FK_EFFF052639B8E743` FOREIGN KEY (`administration_id`) REFERENCES `administration` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_EFFF05266C6060B` FOREIGN KEY (`creche_id`) REFERENCES `creche` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administration_creche`
--

LOCK TABLES `administration_creche` WRITE;
/*!40000 ALTER TABLE `administration_creche` DISABLE KEYS */;
/*!40000 ALTER TABLE `administration_creche` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calendar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `creche_id` int DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `all_day` tinyint(1) DEFAULT NULL,
  `background_color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6EA9A1466C6060B` (`creche_id`),
  CONSTRAINT `FK_6EA9A1466C6060B` FOREIGN KEY (`creche_id`) REFERENCES `creche` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar`
--

LOCK TABLES `calendar` WRITE;
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
INSERT INTO `calendar` VALUES (1,1,'Magni porro cupiditate eveniet error odio delectus nulla.','2024-01-30 09:45:09','2024-02-01 14:04:55','Dolor sint rerum et repellendus ex ea voluptates. Possimus fugiat pariatur rerum id et eius aliquid. Illo aperiam molestias labore mollitia. Voluptatibus et facilis aut et est ad.',0,'#96ecca','#4dc2ae'),(2,1,'Ducimus facilis assumenda cumque voluptas.','2024-01-24 19:26:45','2024-01-25 14:02:42','Asperiores enim et et. Aut autem asperiores accusantium consequuntur dicta et. Sunt culpa esse porro minus a quia. Perferendis autem qui molestiae quia itaque quas.',1,'#5da447','#bf3000'),(3,1,'Velit cumque non quis et sapiente et praesentium.','2024-02-04 23:10:18','2024-02-08 14:26:48','Cumque est provident qui autem quasi. Sint nesciunt libero ex. Ipsam aut ad molestiae et consequuntur quo nulla. Expedita enim repellat et quo nisi iure doloribus.',1,'#db47bd','#9ad2da'),(4,1,'Aut fuga ad modi aut pariatur deserunt voluptas.','2024-02-04 23:13:37','2024-02-06 20:07:30','Minima adipisci illo quo tempora dolor aut accusantium. Nemo aut et dolores sit est molestiae dolorum. Magni blanditiis nemo praesentium et dolorum suscipit. Atque doloremque provident iste deserunt.',0,'#6b4bcd','#b38089'),(5,1,'Nisi illum iste id.','2024-01-12 23:50:42','2024-01-19 01:17:05','Quisquam iste excepturi officia. Impedit eaque soluta commodi voluptas qui debitis. Sunt sed rerum enim. Molestiae veniam ut et.',0,'#a1ad78','#1eb98f'),(6,1,'Quaerat optio quis architecto est unde.','2024-01-29 20:28:51','2024-01-31 01:31:57','Magnam laborum accusamus facilis pariatur amet sequi. Accusamus laborum nihil asperiores id ut qui. Recusandae velit doloribus dolorem ex deserunt.',1,'#7e358d','#df44f1'),(7,1,'Sapiente necessitatibus vel doloremque.','2024-01-22 06:20:42','2024-01-28 02:20:54','Earum libero aliquam ratione id non cupiditate. Accusantium cumque placeat impedit et aliquid qui qui. Ullam cumque quis unde qui temporibus voluptatem similique est.',1,'#402701','#d22ee1'),(8,1,'Est error accusantium et est iure.','2024-01-10 01:02:41','2024-01-16 16:53:44','Inventore voluptates neque inventore tempore quaerat expedita et. Ut voluptatem id facilis. At nihil at laudantium esse quia voluptate. Dolore quidem sit et iure ut.',1,'#b20f0c','#988d2d'),(9,1,'Aut iure in dolores autem tempore omnis quis.','2024-01-07 14:45:19','2024-01-07 22:38:48','Impedit quo qui expedita similique eveniet dolor tempora dignissimos. Est aspernatur autem expedita aut. Exercitationem nostrum nisi sit quam maxime.',0,'#1f45fd','#80007e'),(10,1,'Officiis tempora maxime sapiente.','2024-01-17 11:07:24','2024-01-18 16:11:52','Vero quod occaecati voluptatum voluptatum. Molestiae et totam non dolorum. Et non corporis quis vitae ut ut. Ab facilis ad inventore dolorem omnis odit.',0,'#cf5366','#3d64bb');
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `child`
--

DROP TABLE IF EXISTS `child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `child` (
  `id` int NOT NULL AUTO_INCREMENT,
  `family_id` int NOT NULL,
  `child_firstname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_lastname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` date DEFAULT NULL,
  `is_walking` tinyint(1) NOT NULL,
  `allergy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_disabled` tinyint(1) NOT NULL,
  `disability` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_certificate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vaccine` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insurance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_22B35429C35E566A` (`family_id`),
  CONSTRAINT `FK_22B35429C35E566A` FOREIGN KEY (`family_id`) REFERENCES `family` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `child`
--

LOCK TABLES `child` WRITE;
/*!40000 ALTER TABLE `child` DISABLE KEYS */;
INSERT INTO `child` VALUES (1,2,'Mathilde','Besson','2021-07-16',1,'Aucune',1,'Aucun','null','Dr. Dupont','null','null',NULL),(2,1,'Alexandre','Laporte','2021-11-27',1,'Aucune',1,'Aucun','null','Dr. Dupont','null','null',NULL),(3,1,'Étienne','Bazin','2021-11-03',1,'Aucune',1,'Aucun','null','Dr. Dupont','null','null',NULL),(4,2,'Agnès','Imbert','2021-03-10',1,'Aucune',1,'Aucun','null','Dr. Dupont','null','null',NULL),(5,1,'Alex','Lopes','2021-12-06',1,'Aucune',1,'Aucun','null','Dr. Dupont','null','null',NULL);
/*!40000 ALTER TABLE `child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `child_creche`
--

DROP TABLE IF EXISTS `child_creche`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `child_creche` (
  `child_id` int NOT NULL,
  `creche_id` int NOT NULL,
  PRIMARY KEY (`child_id`,`creche_id`),
  KEY `IDX_370AD94DD62C21B` (`child_id`),
  KEY `IDX_370AD946C6060B` (`creche_id`),
  CONSTRAINT `FK_370AD946C6060B` FOREIGN KEY (`creche_id`) REFERENCES `creche` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_370AD94DD62C21B` FOREIGN KEY (`child_id`) REFERENCES `child` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `child_creche`
--

LOCK TABLES `child_creche` WRITE;
/*!40000 ALTER TABLE `child_creche` DISABLE KEYS */;
/*!40000 ALTER TABLE `child_creche` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `creche`
--

DROP TABLE IF EXISTS `creche`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `creche` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `introduction` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `localisation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_code` int NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insurance_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `legal_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rules` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6A2569C8A76ED395` (`user_id`),
  CONSTRAINT `FK_6A2569C8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `creche`
--

LOCK TABLES `creche` WRITE;
/*!40000 ALTER TABLE `creche` DISABLE KEYS */;
INSERT INTO `creche` VALUES (1,1,'Rerum quos consequuntur quas dolor. Qui rerum consequuntur velit at. Unde recusandae est dolor accusamus aut rem.','Crèche des petits','1 rue de la crèche',75000,'Paris','0123456789','123456789','SARL','Lorem ipsum dolor sit amet, consectetur');
/*!40000 ALTER TABLE `creche` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20240206084823','2024-02-06 08:48:24',394);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emergency_contact`
--

DROP TABLE IF EXISTS `emergency_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emergency_contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `family_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_contact` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FE1C6190C35E566A` (`family_id`),
  CONSTRAINT `FK_FE1C6190C35E566A` FOREIGN KEY (`family_id`) REFERENCES `family` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emergency_contact`
--

LOCK TABLES `emergency_contact` WRITE;
/*!40000 ALTER TABLE `emergency_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `emergency_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `family`
--

DROP TABLE IF EXISTS `family`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `family` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A5E6215BA76ED395` (`user_id`),
  CONSTRAINT `FK_A5E6215BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `family`
--

LOCK TABLES `family` WRITE;
/*!40000 ALTER TABLE `family` DISABLE KEYS */;
INSERT INTO `family` VALUES (1,2,'Morel','Gabriel','79, impasse de Rousset','24919','Perret','0666666666'),(2,3,'Diallo','David','76, rue Capucine Dias','27037','Besnard','0666666666');
/*!40000 ALTER TABLE `family` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo`
--

DROP TABLE IF EXISTS `photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `creche_id` int DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_14B784186C6060B` (`creche_id`),
  CONSTRAINT `FK_14B784186C6060B` FOREIGN KEY (`creche_id`) REFERENCES `creche` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo`
--

LOCK TABLES `photo` WRITE;
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `creche_id` int NOT NULL,
  `family_id` int NOT NULL,
  `calendar_id` int DEFAULT NULL,
  `child_id` int DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_42C84955A40A2C8` (`calendar_id`),
  KEY `IDX_42C849556C6060B` (`creche_id`),
  KEY `IDX_42C84955C35E566A` (`family_id`),
  KEY `IDX_42C84955DD62C21B` (`child_id`),
  CONSTRAINT `FK_42C849556C6060B` FOREIGN KEY (`creche_id`) REFERENCES `creche` (`id`),
  CONSTRAINT `FK_42C84955A40A2C8` FOREIGN KEY (`calendar_id`) REFERENCES `calendar` (`id`),
  CONSTRAINT `FK_42C84955C35E566A` FOREIGN KEY (`family_id`) REFERENCES `family` (`id`),
  CONSTRAINT `FK_42C84955DD62C21B` FOREIGN KEY (`child_id`) REFERENCES `child` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
INSERT INTO `reservation` VALUES (1,1,2,1,2,'en attente'),(2,1,1,2,1,'accepté'),(3,1,1,3,4,'refusé'),(4,1,1,4,5,'refusé'),(5,1,2,5,4,'refusé'),(6,1,1,6,1,'refusé'),(7,1,1,7,3,'annulé'),(8,1,1,8,2,'accepté'),(9,1,1,9,2,'annulé'),(10,1,2,10,4,'accepté');
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_password_request`
--

LOCK TABLES `reset_password_request` WRITE;
/*!40000 ALTER TABLE `reset_password_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `reset_password_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `creche_id` int NOT NULL,
  `weekdays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opening_hours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `closing_hours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A3811FB6C6060B` (`creche_id`),
  CONSTRAINT `FK_5A3811FB6C6060B` FOREIGN KEY (`creche_id`) REFERENCES `creche` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
INSERT INTO `schedule` VALUES (1,1,'Lundi','08:00','18:00');
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `id` int NOT NULL AUTO_INCREMENT,
  `creche_id` int NOT NULL,
  `service_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E19D9AD26C6060B` (`creche_id`),
  CONSTRAINT `FK_E19D9AD26C6060B` FOREIGN KEY (`creche_id`) REFERENCES `creche` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team` (
  `id` int NOT NULL AUTO_INCREMENT,
  `creche_id` int NOT NULL,
  `team_firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fonction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C4E0A61F6C6060B` (`creche_id`),
  CONSTRAINT `FK_C4E0A61F6C6060B` FOREIGN KEY (`creche_id`) REFERENCES `creche` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` VALUES (1,1,'Jean','Dupont','Directeur','photo.jpg',NULL);
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'creche@creche.com','[\"ROLE_CRECHE\"]','$2y$13$yryHr97Jv.ptkMkjUJKI3.eGowxCsPuqXPW2UcYTcOo//mQX7GKgO','null','2024-02-06 08:48:24',0),(2,'parent@parent.com','[\"ROLE_PARENT\"]','$2y$13$4qy/dD1M5KfBrXcQMyX/UeWy/qbO6kMS3YX1fZ2PH2cbawBOI2cNO','null','2024-02-06 08:48:25',0),(3,'test@test.com','[\"ROLE_PARENT\"]','$2y$13$Uu7l8.SzH2V3hNbA8HnNQ.HmQVdNG8BhV6Bi9rfAn9kWVv7vsEFVC','null','2024-02-06 08:48:25',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-06 10:52:10
