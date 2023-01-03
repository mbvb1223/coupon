-- MySQL dump 10.13  Distrib 8.0.31, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: coupon
-- ------------------------------------------------------
-- Server version	8.0.31-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `coupon_categories`
--

DROP TABLE IF EXISTS `coupon_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupon_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint unsigned NOT NULL,
  `quota` bigint unsigned NOT NULL DEFAULT '0',
  `required_point` bigint unsigned NOT NULL DEFAULT '0',
  `price` bigint unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupon_categories`
--

LOCK TABLES `coupon_categories` WRITE;
/*!40000 ALTER TABLE `coupon_categories` DISABLE KEYS */;
INSERT INTO `coupon_categories` VALUES (1,'test',1,11242,50,500,'2023-01-03 05:55:51','2023-01-03 06:05:03',NULL),(2,'New Year 2023',1,100,1,10,'2023-01-03 05:55:51','2023-01-03 05:55:51',NULL);
/*!40000 ALTER TABLE `coupon_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint unsigned NOT NULL,
  `quota` bigint unsigned NOT NULL DEFAULT '0',
  `qr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint unsigned NOT NULL,
  `type` tinyint unsigned NOT NULL,
  `coupon_category_id` bigint unsigned DEFAULT NULL,
  `redemption_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_key_unique` (`key`),
  KEY `coupons_coupon_category_id_foreign` (`coupon_category_id`),
  KEY `coupons_redemption_id_foreign` (`redemption_id`),
  CONSTRAINT `coupons_coupon_category_id_foreign` FOREIGN KEY (`coupon_category_id`) REFERENCES `coupon_categories` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `coupons_redemption_id_foreign` FOREIGN KEY (`redemption_id`) REFERENCES `redemptions` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,'5c57620bd4313bdb34f7940a32d1789f656f2bb2485b01cf9f11f3147dca76e4',1,1,'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',500,1,NULL,1,'2023-01-03 05:58:27','2023-01-03 05:58:27',NULL),(2,'ce2eb1ddf2643b5b4a293be98b5744550cab9827bf5580b0cca9f4cff395ae7b',1,1,'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',500,1,NULL,2,'2023-01-03 06:05:02','2023-01-03 06:05:02',NULL),(3,'64ca749f88f0c9a9e070c8488513bf58ce6e06fc02fc92389d5479e2734928a4',1,1,'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',500,1,NULL,3,'2023-01-03 06:05:03','2023-01-03 06:05:03',NULL);
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (8,'2014_10_12_000000_create_users_table',1),(9,'2019_12_14_000001_create_personal_access_tokens_table',1),(10,'2023_01_02_073105_create_points_table',1),(11,'2023_01_02_073342_create_point_histories_table',1),(12,'2023_01_02_131238_create_coupon_categories_table',1),(13,'2023_01_02_131844_create_redemptions_table',1),(14,'2023_01_02_131845_create_coupons_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'tester','0cd1ae315f5b294e478d6d7de7839fa735efeb1181f5f8782eed58f48de1c716','[\"*\"]','2023-01-03 06:10:17','2023-01-03 05:55:51','2023-01-03 06:10:17'),(2,'App\\Models\\User',1,'231','764e12bea5908b0c0d161dad4fe7d32ec16fc36005012cde065b4e74b44c29a2','[\"*\"]',NULL,'2023-01-03 05:55:54','2023-01-03 05:55:54'),(3,'App\\Models\\User',1,'231','bcfe42b6140ca7148bd31082a33d14db2e603f10e5dd111ac00fd1b3ec8f66b7','[\"*\"]','2023-01-03 06:09:16','2023-01-03 06:08:52','2023-01-03 06:09:16');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `point_histories`
--

DROP TABLE IF EXISTS `point_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `point_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `point_id` bigint unsigned NOT NULL,
  `point_value` bigint NOT NULL,
  `type` tinyint unsigned NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `point_histories_point_id_foreign` (`point_id`),
  CONSTRAINT `point_histories_point_id_foreign` FOREIGN KEY (`point_id`) REFERENCES `points` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `point_histories`
--

LOCK TABLES `point_histories` WRITE;
/*!40000 ALTER TABLE `point_histories` DISABLE KEYS */;
INSERT INTO `point_histories` VALUES (1,1,72,1,NULL,'2023-01-03 05:56:30','2023-01-03 05:56:30',NULL),(2,1,-50,2,NULL,'2023-01-03 05:58:27','2023-01-03 05:58:27',NULL),(3,1,38,1,NULL,'2023-01-03 06:04:57','2023-01-03 06:04:57',NULL),(4,1,33,1,NULL,'2023-01-03 06:04:59','2023-01-03 06:04:59',NULL),(5,1,16,1,NULL,'2023-01-03 06:04:59','2023-01-03 06:04:59',NULL),(6,1,-50,2,NULL,'2023-01-03 06:05:02','2023-01-03 06:05:02',NULL),(7,1,-50,2,NULL,'2023-01-03 06:05:03','2023-01-03 06:05:03',NULL);
/*!40000 ALTER TABLE `point_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `points`
--

DROP TABLE IF EXISTS `points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `points` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `point_value` bigint unsigned NOT NULL DEFAULT '0',
  `status` tinyint unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `points_user_id_foreign` (`user_id`),
  CONSTRAINT `points_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `points`
--

LOCK TABLES `points` WRITE;
/*!40000 ALTER TABLE `points` DISABLE KEYS */;
INSERT INTO `points` VALUES (1,1,9,1,'2023-01-03 05:56:30','2023-01-03 06:05:03',NULL);
/*!40000 ALTER TABLE `points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `redemptions`
--

DROP TABLE IF EXISTS `redemptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `redemptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `coupon_category_id` bigint unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `redemptions_user_id_foreign` (`user_id`),
  KEY `redemptions_coupon_category_id_foreign` (`coupon_category_id`),
  CONSTRAINT `redemptions_coupon_category_id_foreign` FOREIGN KEY (`coupon_category_id`) REFERENCES `coupon_categories` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `redemptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `redemptions`
--

LOCK TABLES `redemptions` WRITE;
/*!40000 ALTER TABLE `redemptions` DISABLE KEYS */;
INSERT INTO `redemptions` VALUES (1,1,1,'2023-01-03 05:58:27','2023-01-03 05:58:27',NULL),(2,1,1,'2023-01-03 06:05:02','2023-01-03 06:05:02',NULL),(3,1,1,'2023-01-03 06:05:03','2023-01-03 06:05:03',NULL);
/*!40000 ALTER TABLE `redemptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Khien Pham','phamkhien@hotmail.com',NULL,'$2y$10$A31UjoEpC/MCHRtvcGgPQeVKqHRdo.LBGLtA/RzDtUNijxNM37/0i',NULL,'2023-01-03 05:55:51','2023-01-03 05:55:51',NULL),(2,'Khien','test1@gmail.com',NULL,'$2y$10$7Nkwa/kg7mQ1wGwJNXZ2/.BB05dwpCvGR86NCIQ43uQiSL9oe6lU6',NULL,'2023-01-03 06:08:36','2023-01-03 06:08:36',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-03 20:26:31
