-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: localhost    Database: laravel
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'2025_02_21_161456_tasks_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_by` bigint unsigned NOT NULL,
  `assigned_to` bigint unsigned DEFAULT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tasks_assigned_to_foreign` (`assigned_to`),
  KEY `tasks_created_by_status_index` (`created_by`,`status`),
  CONSTRAINT `tasks_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tasks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (70,107,108,'Aut quos iure mollitia veniam illum. Sapiente omnis reprehenderit fugit sunt. Earum expedita deserunt aut voluptates repellat. Repudiandae tenetur sed aut iste.','pending','2025-02-25 18:31:41','2025-02-25 18:31:41'),(71,107,109,'Enim enim officiis repellat voluptates quisquam ut. Occaecati molestiae ab est pariatur. Cum dolor qui beatae nam qui voluptas. Earum odio eos hic ipsam neque ullam est beatae.','in_progress','2025-02-25 18:31:41','2025-02-25 18:31:41'),(72,107,110,'Maiores occaecati exercitationem hic suscipit deleniti enim enim esse. Tempora possimus non et nulla rerum. Dignissimos sint modi aspernatur. A at provident distinctio dolor.','in_progress','2025-02-25 18:31:41','2025-02-25 18:31:41'),(73,111,107,'Debitis iure qui praesentium molestiae nihil voluptatibus. Error sequi quod qui et fugiat et maiores. Est harum omnis aut unde earum at natus esse. Accusamus optio eos aut soluta.','completed','2025-02-25 18:31:41','2025-02-25 18:31:41'),(74,112,107,'Neque perferendis voluptatem rerum dicta delectus officiis dolorem. Id natus ratione laboriosam aperiam ut et. Sed laboriosam enim consequatur. Quidem velit doloribus debitis amet quo.','pending','2025-02-25 18:31:41','2025-02-25 18:31:41'),(75,113,107,'Pariatur nihil molestias ut. Itaque porro est quis quidem earum. Autem eos in debitis illo dolor praesentium rerum ea. Repudiandae et ratione quidem adipisci qui est praesentium.','pending','2025-02-25 18:31:41','2025-02-25 18:31:41');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (99,'Chandler Bing','chandler@friends.com','2025-02-25 18:31:41','$2y$12$MnIt5djh5MsrlLyYdDfN8e2Cd/0HS9oWpezcxU2tWGVzpFuoZMJPy','8qrJ0NUC8U','2025-02-25 18:31:41','2025-02-25 18:31:41'),(107,'Maybell Robel','greg64@example.org','2025-02-25 18:31:41','$2y$12$MnIt5djh5MsrlLyYdDfN8e2Cd/0HS9oWpezcxU2tWGVzpFuoZMJPy','X7UkKwvvRa','2025-02-25 18:31:41','2025-02-25 18:31:41'),(108,'Briana Johnston','river72@example.net','2025-02-25 18:31:41','$2y$12$MnIt5djh5MsrlLyYdDfN8e2Cd/0HS9oWpezcxU2tWGVzpFuoZMJPy','reOncwnHlz','2025-02-25 18:31:41','2025-02-25 18:31:41'),(109,'Desiree Feil','jazmyn55@example.org','2025-02-25 18:31:41','$2y$12$MnIt5djh5MsrlLyYdDfN8e2Cd/0HS9oWpezcxU2tWGVzpFuoZMJPy','ouMf9xVV6o','2025-02-25 18:31:41','2025-02-25 18:31:41'),(110,'Anthony Cruickshank','jimmy62@example.org','2025-02-25 18:31:41','$2y$12$MnIt5djh5MsrlLyYdDfN8e2Cd/0HS9oWpezcxU2tWGVzpFuoZMJPy','8BavXMFAfs','2025-02-25 18:31:41','2025-02-25 18:31:41'),(111,'Lorna Ryan','imani38@example.net','2025-02-25 18:31:41','$2y$12$MnIt5djh5MsrlLyYdDfN8e2Cd/0HS9oWpezcxU2tWGVzpFuoZMJPy','12hzoyWvi3','2025-02-25 18:31:41','2025-02-25 18:31:41'),(112,'Morris Murazik','uabshire@example.net','2025-02-25 18:31:41','$2y$12$MnIt5djh5MsrlLyYdDfN8e2Cd/0HS9oWpezcxU2tWGVzpFuoZMJPy','0irH1pEIn9','2025-02-25 18:31:41','2025-02-25 18:31:41'),(113,'Douglas Herzog','kmann@example.org','2025-02-25 18:31:41','$2y$12$MnIt5djh5MsrlLyYdDfN8e2Cd/0HS9oWpezcxU2tWGVzpFuoZMJPy','EkQJ8zuFOC','2025-02-25 18:31:41','2025-02-25 18:31:41');
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

-- Dump completed on 2025-02-25 18:53:08
