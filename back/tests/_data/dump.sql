-- MySQL dump 10.13  Distrib 8.0.15, for Linux (x86_64)
--
-- Host: localhost    Database: rouzig
-- ------------------------------------------------------
-- Server version	8.0.15

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `example`
--

DROP TABLE IF EXISTS `example`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `example` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_language` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_language` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `example`
--

LOCK TABLES `example` WRITE;
/*!40000 ALTER TABLE `example` DISABLE KEYS */;
/*!40000 ALTER TABLE `example` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_access_token`
--

DROP TABLE IF EXISTS `oauth2_access_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `oauth2_access_token` (
  `identifier` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_identifier` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:oauth2_scope)',
  `revoked` tinyint(1) NOT NULL,
  PRIMARY KEY (`identifier`),
  KEY `IDX_454D9673C7440455` (`client`),
  CONSTRAINT `FK_454D9673C7440455` FOREIGN KEY (`client`) REFERENCES `oauth2_client` (`identifier`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_access_token`
--

LOCK TABLES `oauth2_access_token` WRITE;
/*!40000 ALTER TABLE `oauth2_access_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_access_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_authorization_code`
--

DROP TABLE IF EXISTS `oauth2_authorization_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `oauth2_authorization_code` (
  `identifier` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_identifier` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:oauth2_scope)',
  `revoked` tinyint(1) NOT NULL,
  PRIMARY KEY (`identifier`),
  KEY `IDX_509FEF5FC7440455` (`client`),
  CONSTRAINT `FK_509FEF5FC7440455` FOREIGN KEY (`client`) REFERENCES `oauth2_client` (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_authorization_code`
--

LOCK TABLES `oauth2_authorization_code` WRITE;
/*!40000 ALTER TABLE `oauth2_authorization_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_authorization_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_client`
--

DROP TABLE IF EXISTS `oauth2_client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `oauth2_client` (
  `identifier` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_uris` text COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:oauth2_redirect_uri)',
  `grants` text COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:oauth2_grant)',
  `scopes` text COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:oauth2_scope)',
  `active` tinyint(1) NOT NULL,
  `allow_plain_text_pkce` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_client`
--

LOCK TABLES `oauth2_client` WRITE;
/*!40000 ALTER TABLE `oauth2_client` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_refresh_token`
--

DROP TABLE IF EXISTS `oauth2_refresh_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `oauth2_refresh_token` (
  `identifier` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` char(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `revoked` tinyint(1) NOT NULL,
  PRIMARY KEY (`identifier`),
  KEY `IDX_4DD90732B6A2DD68` (`access_token`),
  CONSTRAINT `FK_4DD90732B6A2DD68` FOREIGN KEY (`access_token`) REFERENCES `oauth2_access_token` (`identifier`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_refresh_token`
--

LOCK TABLES `oauth2_refresh_token` WRITE;
/*!40000 ALTER TABLE `oauth2_refresh_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_refresh_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `search`
--

DROP TABLE IF EXISTS `search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count` int(11) NOT NULL,
  `from_language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `search`
--

LOCK TABLES `search` WRITE;
/*!40000 ALTER TABLE `search` DISABLE KEYS */;
/*!40000 ALTER TABLE `search` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translation`
--

DROP TABLE IF EXISTS `translation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translation`
--

LOCK TABLES `translation` WRITE;
/*!40000 ALTER TABLE `translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `translation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translation_examples`
--

DROP TABLE IF EXISTS `translation_examples`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `translation_examples` (
  `translations_id` int(11) NOT NULL,
  `example_id` int(11) NOT NULL,
  PRIMARY KEY (`translations_id`,`example_id`),
  UNIQUE KEY `UNIQ_28C2328CAB07C711` (`example_id`),
  KEY `IDX_28C2328CACE9C349` (`translations_id`),
  CONSTRAINT `FK_28C2328CAB07C711` FOREIGN KEY (`example_id`) REFERENCES `example` (`id`),
  CONSTRAINT `FK_28C2328CACE9C349` FOREIGN KEY (`translations_id`) REFERENCES `translation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translation_examples`
--

LOCK TABLES `translation_examples` WRITE;
/*!40000 ALTER TABLE `translation_examples` DISABLE KEYS */;
/*!40000 ALTER TABLE `translation_examples` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `word_object`
--

DROP TABLE IF EXISTS `word_object`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `word_object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DA747F62F675F31B` (`author_id`),
  CONSTRAINT `FK_DA747F62F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `word_object`
--

LOCK TABLES `word_object` WRITE;
/*!40000 ALTER TABLE `word_object` DISABLE KEYS */;
/*!40000 ALTER TABLE `word_object` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `word_translations`
--

DROP TABLE IF EXISTS `word_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `word_translations` (
  `word_id` int(11) NOT NULL,
  `translation_id` int(11) NOT NULL,
  PRIMARY KEY (`word_id`,`translation_id`),
  UNIQUE KEY `UNIQ_92513C9B9CAA2B25` (`translation_id`),
  KEY `IDX_92513C9BE357438D` (`word_id`),
  CONSTRAINT `FK_92513C9B9CAA2B25` FOREIGN KEY (`translation_id`) REFERENCES `translation` (`id`),
  CONSTRAINT `FK_92513C9BE357438D` FOREIGN KEY (`word_id`) REFERENCES `word_object` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `word_translations`
--

LOCK TABLES `word_translations` WRITE;
/*!40000 ALTER TABLE `word_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `word_translations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-12 21:40:37