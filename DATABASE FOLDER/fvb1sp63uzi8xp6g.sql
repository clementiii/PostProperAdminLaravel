-- --------------------------------------------------------
-- Host:                         tuy8t6uuvh43khkk.cbetxkdyhwsb.us-east-1.rds.amazonaws.com
-- Server version:               8.0.35 - Source distribution
-- Server OS:                    Linux
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for fvb1sp63uzi8xp6g
CREATE DATABASE IF NOT EXISTS `fvb1sp63uzi8xp6g` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `fvb1sp63uzi8xp6g`;

-- Dumping structure for table fvb1sp63uzi8xp6g.admin_accounts
CREATE TABLE IF NOT EXISTS `admin_accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.admin_accounts: ~5 rows (approximately)
INSERT IGNORE INTO `admin_accounts` (`id`, `name`, `username`, `password`, `profile_picture`, `created_at`, `updated_at`) VALUES
	(1, 'Rannie Camba', 'rannie', '$2y$12$TCA6Q9wgT7OCs62A7W4q5ef1QPPEBXsz7WRan8zv8/y8v01u8vr/e', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744287281/admin_profile_pictures/admin_1_1744287281.png', NULL, '2025-04-10 20:14:42'),
	(2, 'Diosdado Tempra', 'djtempra', '$2y$12$TCA6Q9wgT7OCs62A7W4q5ef1QPPEBXsz7WRan8zv8/y8v01u8vr/e', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744381830/admin_profile_pictures/admin_2_1744381830.jpg', NULL, '2025-04-11 22:30:31'),
	(3, 'Gabrielle Maglaya', 'gab', '$2y$12$TCA6Q9wgT7OCs62A7W4q5ef1QPPEBXsz7WRan8zv8/y8v01u8vr/e', '', NULL, NULL),
	(4, 'Quirino Saruno', 'saruno', '$2y$12$TCA6Q9wgT7OCs62A7W4q5ef1QPPEBXsz7WRan8zv8/y8v01u8vr/e', 'assets/admin_profile_pictures/1733971040_a79b3e17-90b7-49d0-98ea-e3208f8dd1ef.png', NULL, NULL),
	(5, 'Joshua Fernandez', 'josh', '$2y$12$TCA6Q9wgT7OCs62A7W4q5ef1QPPEBXsz7WRan8zv8/y8v01u8vr/e', '', NULL, NULL);

-- Dumping structure for table fvb1sp63uzi8xp6g.barangay_announcements
CREATE TABLE IF NOT EXISTS `barangay_announcements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `announcement_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description_text` text COLLATE utf8mb4_general_ci NOT NULL,
  `announcement_images` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `posted_at` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.barangay_announcements: ~4 rows (approximately)
INSERT IGNORE INTO `barangay_announcements` (`id`, `announcement_title`, `description_text`, `announcement_images`, `created_at`, `posted_at`) VALUES
	(10, 'CLEAN-UP DRIVE at Maricaban Creek', 'As we approach EARTH DAY with the theme: OUR POWER, OUR PLANET, the Metropolitan Environmental Office- MEO West under the Department of Environment and Natural Resources -DENR in cooperation with Post Proper Southside headed by Punong Barangay Quirino Sarono and Council, led by Committee in charge Kagawad Elmer Baldonado together with Environmental Police were organizing a CLEARING and CLEAN-UP Activity along the water ways at Maricaban Creek to enhance the preservation and protection of our natural resources.\r\n.\r\n#KapQS\r\n#SERBISYONG SARONO\r\n#IHEARTSOUTHSIDE\r\n#SOUTHSIDE2025\r\nONE DREAM....ONE GOAL...ONE COMMUNITY', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339817\\/announcement_images\\/announcement_1744339817_67f8836933ed3.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339817\\/announcement_images\\/announcement_1744339817_67f88369b2ea6.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339818\\/announcement_images\\/announcement_1744339818_67f8836a31f33.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339818\\/announcement_images\\/announcement_1744339818_67f8836ac14fc.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339819\\/announcement_images\\/announcement_1744339819_67f8836b4bb7d.jpg"]', '2025-04-11 10:50:19', '2025-04-11 10:50:19'),
	(11, 'Fire Incident  4/8/25', 'Southside B.E.R.T Responded at a reported fire Incident at A.Mabini St, Brgy. Tuktukan Taguig City that involves a residential area.\r\nKeep safe everyone 🙏\r\nReminder from Punong Barangay Quirino Sarono  and Council.', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342261\\/announcement_images\\/announcement_1744342261_67f88cf57ad76.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342262\\/announcement_images\\/announcement_1744342262_67f88cf621d0d.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342263\\/announcement_images\\/announcement_1744342263_67f88cf715963.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342263\\/announcement_images\\/announcement_1744342263_67f88cf7c007d.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342264\\/announcement_images\\/announcement_1744342264_67f88cf843b62.jpg"]', '2025-04-11 11:31:06', '2025-04-11 11:31:06'),
	(14, '04/11/2025', 'Southside BERT conducted a flashing operation for an oil spill at Buting Brgy. East Rembo, Taguig City.', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391161\\/announcement_images\\/announcement_1744391160_67f94bf8f1ed4.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391161\\/announcement_images\\/announcement_1744391161_67f94bf9983cf.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391162\\/announcement_images\\/announcement_1744391162_67f94bfa2757e.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391163\\/announcement_images\\/announcement_1744391163_67f94bfb0fdbf.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391163\\/announcement_images\\/announcement_1744391163_67f94bfbba560.jpg"]', '2025-04-12 01:06:04', '2025-04-12 01:06:04'),
	(16, 'JADIZON CHESTER MONMSYTER', 'RAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744544003\\/announcement_images\\/announcement_1744544003_67fba10380daa.png","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744544004\\/announcement_images\\/announcement_1744544004_67fba104165c6.png","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744544004\\/announcement_images\\/announcement_1744544004_67fba1048be6d.png","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744544005\\/announcement_images\\/announcement_1744544005_67fba10526a98.png"]', '2025-04-13 19:33:25', '2025-04-13 19:33:25');

-- Dumping structure for table fvb1sp63uzi8xp6g.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.cache: ~94 rows (approximately)
INSERT IGNORE INTO `cache` (`key`, `value`, `expiration`) VALUES
	('barangay_management_system_cache_0078688bc9c722775d928f1d5948348e', 'i:1;', 1744514042),
	('barangay_management_system_cache_0078688bc9c722775d928f1d5948348e:timer', 'i:1744514042;', 1744514042),
	('barangay_management_system_cache_08847be4f3d1acca85dbc75e26f27c83', 'i:1;', 1744380848),
	('barangay_management_system_cache_08847be4f3d1acca85dbc75e26f27c83:timer', 'i:1744380848;', 1744380848),
	('barangay_management_system_cache_08ce9dce8170e964e09c32545695f727', 'i:1;', 1744279545),
	('barangay_management_system_cache_08ce9dce8170e964e09c32545695f727:timer', 'i:1744279545;', 1744279545),
	('barangay_management_system_cache_0e0de308602396d9e2f5084d8b59e614', 'i:2;', 1744389948),
	('barangay_management_system_cache_0e0de308602396d9e2f5084d8b59e614:timer', 'i:1744389948;', 1744389948),
	('barangay_management_system_cache_0f341b60aca14793d1a0ee630f21bcca', 'i:2;', 1744385258),
	('barangay_management_system_cache_0f341b60aca14793d1a0ee630f21bcca:timer', 'i:1744385258;', 1744385258),
	('barangay_management_system_cache_305bfdf0b2a4ba0dea2c3168ab6dd094', 'i:1;', 1744543555),
	('barangay_management_system_cache_305bfdf0b2a4ba0dea2c3168ab6dd094:timer', 'i:1744543555;', 1744543555),
	('barangay_management_system_cache_3189907242e2fc415da16336d901bbb4', 'i:1;', 1744543595),
	('barangay_management_system_cache_3189907242e2fc415da16336d901bbb4:timer', 'i:1744543595;', 1744543595),
	('barangay_management_system_cache_370cb812f333c3b677798166b0f5b3e3', 'i:1;', 1744814462),
	('barangay_management_system_cache_370cb812f333c3b677798166b0f5b3e3:timer', 'i:1744814462;', 1744814462),
	('barangay_management_system_cache_3ead8462859aef23607ae26f4e843e4c', 'i:1;', 1744418190),
	('barangay_management_system_cache_3ead8462859aef23607ae26f4e843e4c:timer', 'i:1744418190;', 1744418190),
	('barangay_management_system_cache_4598494d1f16c362fb8c10be25f84f40', 'i:1;', 1744515074),
	('barangay_management_system_cache_4598494d1f16c362fb8c10be25f84f40:timer', 'i:1744515074;', 1744515074),
	('barangay_management_system_cache_4efff9fd1edb0b2ebcd75cdc0263bff5', 'i:1;', 1744260657),
	('barangay_management_system_cache_4efff9fd1edb0b2ebcd75cdc0263bff5:timer', 'i:1744260657;', 1744260657),
	('barangay_management_system_cache_4f10d5e163f884cb68b25edc95d7b970', 'i:1;', 1744515087),
	('barangay_management_system_cache_4f10d5e163f884cb68b25edc95d7b970:timer', 'i:1744515087;', 1744515087),
	('barangay_management_system_cache_57695924bea1b6962c67eb36106ce575', 'i:1;', 1744380857),
	('barangay_management_system_cache_57695924bea1b6962c67eb36106ce575:timer', 'i:1744380857;', 1744380857),
	('barangay_management_system_cache_58b7f5712aaa1862a011a41e2bdfaf70', 'i:1;', 1744338523),
	('barangay_management_system_cache_58b7f5712aaa1862a011a41e2bdfaf70:timer', 'i:1744338523;', 1744338523),
	('barangay_management_system_cache_5986bdd1d9eda0d1178844aecb5766f7', 'i:1;', 1744762131),
	('barangay_management_system_cache_5986bdd1d9eda0d1178844aecb5766f7:timer', 'i:1744762131;', 1744762131),
	('barangay_management_system_cache_600937079dfbb14b447493fba4638dd4', 'i:1;', 1744570661),
	('barangay_management_system_cache_600937079dfbb14b447493fba4638dd4:timer', 'i:1744570661;', 1744570661),
	('barangay_management_system_cache_60b236a4f0e6f9f4b493ac2bf7e1ca43', 'i:1;', 1744595336),
	('barangay_management_system_cache_60b236a4f0e6f9f4b493ac2bf7e1ca43:timer', 'i:1744595336;', 1744595336),
	('barangay_management_system_cache_640c346fb4d1da5ecd55efe772ca44ef', 'i:1;', 1744548402),
	('barangay_management_system_cache_640c346fb4d1da5ecd55efe772ca44ef:timer', 'i:1744548402;', 1744548402),
	('barangay_management_system_cache_6acc119dd58b1a6a8ffbc97c71d50d9b', 'i:1;', 1744274439),
	('barangay_management_system_cache_6acc119dd58b1a6a8ffbc97c71d50d9b:timer', 'i:1744274439;', 1744274439),
	('barangay_management_system_cache_6c81b851f940c286a0834aaad68b50d5', 'i:1;', 1744381875),
	('barangay_management_system_cache_6c81b851f940c286a0834aaad68b50d5:timer', 'i:1744381875;', 1744381875),
	('barangay_management_system_cache_6e44331b4e63509763c5bd8e8a33643b', 'i:1;', 1744285235),
	('barangay_management_system_cache_6e44331b4e63509763c5bd8e8a33643b:timer', 'i:1744285235;', 1744285235),
	('barangay_management_system_cache_7260056b391e58d8457f76336ba3ae75', 'i:1;', 1744303404),
	('barangay_management_system_cache_7260056b391e58d8457f76336ba3ae75:timer', 'i:1744303404;', 1744303404),
	('barangay_management_system_cache_761b621353885863fec64591dc194d88', 'i:1;', 1744379741),
	('barangay_management_system_cache_761b621353885863fec64591dc194d88:timer', 'i:1744379741;', 1744379741),
	('barangay_management_system_cache_766634463381f4012f34e2f2bb729478', 'i:1;', 1744859777),
	('barangay_management_system_cache_766634463381f4012f34e2f2bb729478:timer', 'i:1744859777;', 1744859777),
	('barangay_management_system_cache_77ed66684c3d47d0ac25812d2619c724', 'i:1;', 1744278029),
	('barangay_management_system_cache_77ed66684c3d47d0ac25812d2619c724:timer', 'i:1744278029;', 1744278029),
	('barangay_management_system_cache_7a7c114be63e3ce303a4f3a4ba8efe3a', 'i:1;', 1744352566),
	('barangay_management_system_cache_7a7c114be63e3ce303a4f3a4ba8efe3a:timer', 'i:1744352566;', 1744352566),
	('barangay_management_system_cache_7f0da50b3b590e6e006c1fb73da35e12', 'i:1;', 1744421157),
	('barangay_management_system_cache_7f0da50b3b590e6e006c1fb73da35e12:timer', 'i:1744421157;', 1744421157),
	('barangay_management_system_cache_7f129c1b3a3a2ad934ea9e3e93c87f36', 'i:1;', 1744287193),
	('barangay_management_system_cache_7f129c1b3a3a2ad934ea9e3e93c87f36:timer', 'i:1744287193;', 1744287193),
	('barangay_management_system_cache_90cac04b54f47199d3fbecf27cefdabe', 'i:1;', 1744278023),
	('barangay_management_system_cache_90cac04b54f47199d3fbecf27cefdabe:timer', 'i:1744278023;', 1744278023),
	('barangay_management_system_cache_939fea01959f44a59cc629af27af099e', 'i:1;', 1744373996),
	('barangay_management_system_cache_939fea01959f44a59cc629af27af099e:timer', 'i:1744373996;', 1744373996),
	('barangay_management_system_cache_9fdaf3d8cf52a797b1fa4f23c5b27415', 'i:1;', 1744873627),
	('barangay_management_system_cache_9fdaf3d8cf52a797b1fa4f23c5b27415:timer', 'i:1744873627;', 1744873627),
	('barangay_management_system_cache_a27578afa9c35c7a147d4cdc4f98d273', 'i:1;', 1744389938),
	('barangay_management_system_cache_a27578afa9c35c7a147d4cdc4f98d273:timer', 'i:1744389938;', 1744389938),
	('barangay_management_system_cache_a839739e32d735d1e274a0727d0d3526', 'i:1;', 1744380804),
	('barangay_management_system_cache_a839739e32d735d1e274a0727d0d3526:timer', 'i:1744380804;', 1744380804),
	('barangay_management_system_cache_a9830df68d025d5770554865424301cd', 'i:1;', 1744385281),
	('barangay_management_system_cache_a9830df68d025d5770554865424301cd:timer', 'i:1744385281;', 1744385281),
	('barangay_management_system_cache_admin|10.1.14.110', 'i:1;', 1744515069),
	('barangay_management_system_cache_admin|10.1.14.110:timer', 'i:1744515069;', 1744515069),
	('barangay_management_system_cache_admin|10.1.90.219', 'i:1;', 1744515074),
	('barangay_management_system_cache_admin|10.1.90.219:timer', 'i:1744515074;', 1744515074),
	('barangay_management_system_cache_b1fa0729d6c8ab952788345b6f02543e', 'i:1;', 1744270270),
	('barangay_management_system_cache_b1fa0729d6c8ab952788345b6f02543e:timer', 'i:1744270270;', 1744270270),
	('barangay_management_system_cache_b5a560aba3f5149d4b71533a2b605fb3', 'i:1;', 1744385535),
	('barangay_management_system_cache_b5a560aba3f5149d4b71533a2b605fb3:timer', 'i:1744385535;', 1744385535),
	('barangay_management_system_cache_bc93efd58e1fce253e1c172ecbcd7357', 'i:1;', 1744515069),
	('barangay_management_system_cache_bc93efd58e1fce253e1c172ecbcd7357:timer', 'i:1744515069;', 1744515069),
	('barangay_management_system_cache_df1acd42dd0b5e8d7cfb99b5ac279703', 'i:1;', 1744453920),
	('barangay_management_system_cache_df1acd42dd0b5e8d7cfb99b5ac279703:timer', 'i:1744453920;', 1744453920),
	('barangay_management_system_cache_eb56b1dc7c9659624afbf5f9b710a460', 'i:1;', 1744543575),
	('barangay_management_system_cache_eb56b1dc7c9659624afbf5f9b710a460:timer', 'i:1744543575;', 1744543575),
	('barangay_management_system_cache_fc0eab601af9abd16650155c3b0baab8', 'i:1;', 1744287251),
	('barangay_management_system_cache_fc0eab601af9abd16650155c3b0baab8:timer', 'i:1744287251;', 1744287251),
	('barangay_management_system_cache_hahahhaha|10.1.47.121', 'i:1;', 1744515087),
	('barangay_management_system_cache_hahahhaha|10.1.47.121:timer', 'i:1744515087;', 1744515087),
	('barangay_management_system_cache_josh|10.1.39.216', 'i:1;', 1744380848),
	('barangay_management_system_cache_josh|10.1.39.216:timer', 'i:1744380848;', 1744380848),
	('barangay_management_system_cache_rannie|10.1.26.229', 'i:1;', 1744278023),
	('barangay_management_system_cache_rannie|10.1.26.229:timer', 'i:1744278023;', 1744278023),
	('barangay_management_system_cache_testadmin|10.1.4.203', 'i:2;', 1744385259),
	('barangay_management_system_cache_testadmin|10.1.4.203:timer', 'i:1744385259;', 1744385259),
	('fb2a2903c4eeb01175b519bf509ed7aa', 'i:1;', 1744373088),
	('fb2a2903c4eeb01175b519bf509ed7aa:timer', 'i:1744373086;', 1744373087);

-- Dumping structure for table fvb1sp63uzi8xp6g.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.cache_locks: ~0 rows (approximately)

-- Dumping structure for table fvb1sp63uzi8xp6g.document_requests
CREATE TABLE IF NOT EXISTS `document_requests` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `userId` int DEFAULT NULL,
  `DocumentType` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Barangay Clearance',
  `Name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `TIN_No` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CTC_No` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Alias` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Age` int DEFAULT NULL,
  `birthday` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PlaceOfBirth` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Occupation` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LengthOfStay` int DEFAULT NULL,
  `Citizenship` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Gender` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CivilStatus` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Purpose` text COLLATE utf8mb4_general_ci,
  `Status` enum('pending','approved','rejected','cancelled','OVERDUE') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `Quantity` int DEFAULT NULL,
  `DateRequested` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `valid_id` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `valid_id_front` longtext COLLATE utf8mb4_general_ci,
  `valid_id_back` longtext COLLATE utf8mb4_general_ci,
  `request_picture` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `rejection_reason` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cancellation_reason` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pickup_status` enum('pending','picked_up') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `date_approved` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.document_requests: ~5 rows (approximately)
INSERT IGNORE INTO `document_requests` (`Id`, `userId`, `DocumentType`, `Name`, `Address`, `TIN_No`, `CTC_No`, `Alias`, `Age`, `birthday`, `PlaceOfBirth`, `Occupation`, `LengthOfStay`, `Citizenship`, `Gender`, `CivilStatus`, `Purpose`, `Status`, `Quantity`, `DateRequested`, `valid_id`, `valid_id_front`, `valid_id_back`, `request_picture`, `rejection_reason`, `cancellation_reason`, `pickup_status`, `date_approved`, `created_at`, `updated_at`) VALUES
	(1, 48, 'Barangay Clearance', 'David Olerio', '497  Street Zone', '123456789012', '123456789012', 'Dave', 21, '12-22-03', 'Makati City', 'Student', 12, 'Filipino', 'Male', 'Single', 'For Scholarship', 'rejected', 1, '2025-04-11 11:35:24', '', NULL, NULL, '', 'Not enough images', NULL, 'pending', '2025-04-12 00:36:41', NULL, NULL),
	(2, 48, 'Barangay Clearance', 'David Olerio', '497  Street Zone', '123456789012', '123456789012', 'adawd', 21, '12-22-03', 'awdawdawd', 'awdawda', 12, 'awdawdawd', 'Male', 'Single', 'awdawdawdawdwda', 'approved', 1, '2025-04-11 20:31:58', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744374729/valid_ids/valid_id_1744374729_front_67f90bc9a0969.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744374730/valid_ids/valid_id_1744374730_back_67f90bca480c6.jpg', '', '', NULL, 'picked_up', '2025-04-11 21:46:46', NULL, NULL),
	(3, 48, 'Certificate of Indigency', 'David Olerio', '497  Street Zone', '653497856217', '645239780489', 'Cleo', 21, '12-22-03', 'Julita Leyte', 'Housewife', 17, 'Filipino', 'Female', 'Single', 'financial', 'approved', 4, '2025-04-11 22:24:11', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744381481/valid_ids/valid_id_1744381480_front_67f92628e8daa.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744381481/valid_ids/valid_id_1744381481_back_67f926299b6c9.jpg', '', '', NULL, 'pending', '2025-04-11 23:13:15', NULL, NULL),
	(4, 48, 'Barangay Certification', 'David Olerio', '497  Street Zone', '123456789012', '123456789012', 'dave', 21, '12-22-03', 'makati med', 'student', 12, 'filipino', 'Male', 'Single', 'for scholarship', 'pending', 2, '2025-04-14 09:53:27', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744595634/valid_ids/valid_id_1744595634_front_67fc6ab217998.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744595634/valid_ids/valid_id_1744595634_back_67fc6ab29579c.jpg', '', '', NULL, 'pending', NULL, NULL, NULL),
	(5, 48, 'First Time Job Certificate', 'David Olerio', '497  Street Zone', '123456789012', '123456789012', 'popo', 21, '12-22-03', 'hghgf', 'kargas', 23, 'jhggfgghj', 'Male', 'Single', 'help', 'pending', 2, '2025-04-17 15:05:15', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744873547/valid_ids/valid_id_1744873546_front_6800a84ad748e.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744873548/valid_ids/valid_id_1744873548_back_6800a84c2d791.jpg', '', '', NULL, 'pending', NULL, NULL, NULL);

-- Dumping structure for table fvb1sp63uzi8xp6g.incident_reports
CREATE TABLE IF NOT EXISTS `incident_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `incident_picture` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `incident_video` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `date_submitted` datetime NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `resolved_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.incident_reports: ~14 rows (approximately)
INSERT IGNORE INTO `incident_reports` (`id`, `name`, `title`, `description`, `incident_picture`, `incident_video`, `date_submitted`, `status`, `created_at`, `updated_at`, `resolved_at`) VALUES
	(1, 'David Olerio', 'Theft', 'GRAND THEFT AUTO BRO', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744343818\\/incident_reports\\/incident_1744343817_06548afc7da14065.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744343818\\/incident_reports\\/incident_1744343818_4f0fedd06433bcec.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744343818\\/incident_reports\\/incident_1744343818_6d68a05539463769.jpg"]', NULL, '2025-04-11 11:56:57', 'resolved', '2025-04-11 03:56:59', '2025-04-11 12:18:01', '2025-04-11 12:18:01'),
	(2, 'David Olerio', 'Theft', 'nanakawan po kami dito sa kalaw 497a', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744381579\\/incident_reports\\/incident_1744381579_b7b8c16eedfbf5d7.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744381580\\/incident_reports\\/incident_1744381580_546d4d998df21012.jpg"]', NULL, '2025-04-11 22:26:19', 'resolved', '2025-04-11 14:26:20', '2025-04-12 00:09:42', '2025-04-12 00:09:42'),
	(3, 'David Olerio', 'Accident', 'hello', '[]', NULL, '2025-04-12 00:53:42', 'resolved', '2025-04-11 16:53:42', '2025-04-12 00:57:43', '2025-04-12 00:57:43'),
	(4, 'David Olerio', 'Theft', 'dwadawd', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744469149\\/incident_reports\\/incident_1744469148_be656a3b29d5f488.jpg"]', NULL, '2025-04-12 22:45:48', 'pending', '2025-04-12 14:45:49', '2025-04-12 14:45:49', NULL),
	(7, 'David Olerio', 'Accident', 'dixie normous.... they got my ass', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744472221/incident_videos/incident_video_1744472218_3nc9oadr.mp4', '2025-04-12 23:37:02', 'pending', '2025-04-12 15:37:02', '2025-04-12 15:37:02', NULL),
	(8, 'David Olerio', 'Accident', 'dixie normous they got me', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744472298\\/incident_reports\\/incident_1744472298_966d3e2f879c17af.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744472297/incident_videos/incident_video_1744472297_ywx1kna3.mp4', '2025-04-12 23:38:18', 'resolved', '2025-04-12 15:38:19', '2025-04-13 00:51:23', '2025-04-13 00:51:23'),
	(9, 'David Olerio', 'Accident', 'justinecase', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744472919/incident_videos/incident_video_1744472906_qcp1nrmk.mp4', '2025-04-12 23:48:41', 'pending', '2025-04-12 15:48:41', '2025-04-12 15:48:41', NULL),
	(10, 'David Olerio', 'Accident', 'djdjj', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744521168\\/incident_reports\\/incident_1744521168_a1b978bcd9be5054.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744521165/incident_videos/incident_video_1744521151_54j635m9.mp4', '2025-04-13 13:12:48', 'pending', '2025-04-13 05:12:48', '2025-04-13 05:12:48', NULL),
	(11, 'David Olerio', 'Accident', 'ryru', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744553256/incident_videos/incident_video_1744553252_m7jwnshv.mp4', '2025-04-13 22:07:38', 'resolved', '2025-04-13 14:07:38', '2025-04-13 22:17:31', '2025-04-13 22:17:31'),
	(12, 'David Olerio', 'Accident', 'one rhinonpill no headache please', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744553782\\/incident_reports\\/incident_1744553782_791e928798bbabd9.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744553783\\/incident_reports\\/incident_1744553783_3db8b7930c1e7020.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744553783\\/incident_reports\\/incident_1744553783_5ab37f147eeed286.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744553778/incident_videos/incident_video_1744553769_dpsq2l9i.mp4', '2025-04-13 22:16:22', 'pending', '2025-04-13 14:16:24', '2025-04-13 14:16:24', NULL),
	(13, 'David Olerio', 'Other', 'hellppppp', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744595462\\/incident_reports\\/incident_1744595462_db1122292a421b23.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744595458/incident_videos/incident_video_1744595445_xir6hyvn.mp4', '2025-04-14 09:51:02', 'pending', '2025-04-14 01:51:02', '2025-04-14 01:51:02', NULL),
	(14, 'David Olerio', 'Accident', 'heieiw', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744595508/incident_videos/incident_video_1744595487_87zrb0ts.mp4', '2025-04-14 09:51:55', 'pending', '2025-04-14 01:51:55', '2025-04-14 01:51:55', NULL),
	(15, 'David Olerio', 'Accident', 'test', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744859699/incident_videos/incident_video_1744859688_c3736utu.mp4', '2025-04-17 11:15:01', 'pending', '2025-04-17 03:15:01', '2025-04-17 03:15:01', NULL),
	(16, 'David Olerio', 'Accident', 'bruh', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744862396/incident_videos/incident_video_1744862384_te5e7zgs.mp4', '2025-04-17 12:00:00', 'resolved', '2025-04-17 04:00:00', '2025-04-17 15:24:14', '2025-04-17 15:24:14');

-- Dumping structure for table fvb1sp63uzi8xp6g.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `admin_id` int DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_sender_timestamp` (`sender_id`,`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.messages: ~0 rows (approximately)

-- Dumping structure for table fvb1sp63uzi8xp6g.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.migrations: ~0 rows (approximately)

-- Dumping structure for table fvb1sp63uzi8xp6g.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table fvb1sp63uzi8xp6g.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table fvb1sp63uzi8xp6g.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `payload` text COLLATE utf8mb4_general_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.sessions: ~21 rows (approximately)
INSERT IGNORE INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('0K8yftr593lz8WNT54tVSqJmLxIUl0hlrd9awLJl', NULL, '10.1.28.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSTlDelBTbm11QXFtbFNnUEdmWEdJWXNsMVN5NWFyMzlHa2dmVmE3ayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744269654),
	('0OM1Ct0OfnkOaS80FIAWQBYawf1bQNU2XkNcVCQy', NULL, '10.1.31.72', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTUZDOHhxRjVZOWJQbVF3c2x2akJBTkhoczhPZ055S0dHT3BzZ0hHUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744258060),
	('1XyyTmZRUGRDhpZ3vYhFNBcEW8BnKmnBeIXYBpia', NULL, '10.1.30.206', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmg1Mk5BM0ppenZtR3BjS3QzVGw3VFpPaXcxMEZMUXRzZFNSS0ZVZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL2xvZ2luIjt9fQ==', 1744257879),
	('2ukCQW2rEILEmJIdDZFyr43KD5PIs2LVEnCO21rd', NULL, '10.1.87.177', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTGs4eGJGTlBMWUdiZ2d6S2FvWnAzUVdhRVNEZ3NrWFFZZUg1M2JBTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744268653),
	('3jXnzEFJSBN6u2SUh4voBZpau8LGxzh2WlSH1r3A', NULL, '10.1.38.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZ2FBc284TVNhNU9pZHdpTk95NDZyWHZ5UlEyTU9qVE5WSTJZNUd1ZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744257666),
	('8Kuo9BgMiAu71sdzVrSDSz0FMb7bdmqjyzqL8pCB', NULL, '10.1.12.133', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTkZYck42eElXamJyckJxcWJpdHIwWkVEenl6MUJUWmF5RFlrcmpjcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL2xvZ2luIjt9fQ==', 1744269648),
	('9iL1mKNbXPSnTGoEqzwjCDBXXibHTsRNS6WE7lAQ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSENtM3BtRWM3YkdsQmx5aHN4THlXU0paOUVuVjZvUGJCMzBsbUtRUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEyJFRDQTZROXdnVDdPQ3M2MkE3VzRxNWVmMVFQUEVCWHN6N1dSYW44enY4L3k4djAxdTh2ci9lIjt9', 1744378754),
	('9JMZGqUbxmRPKoUTmDLb7m2T9Q6FMooehpapDuKD', NULL, '10.1.87.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ3VESnIwamR5MDBOSm9xbHRwZzZpR3ZwOVFuZjh4MHNJblc0ODF0TyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744261429),
	('9Ub6kQ9ar2vPbUO3PIfjEFrsoJILz8wxdCGNU842', NULL, '10.1.12.133', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTUUzekRTQkFaek5XM0hldFNjTTVPYWFkOEROSGY2bm5lYVFkTXlIbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744258293),
	('axH4J9sY5w6o0DErdxxCXNolSUe341yUJnslhO41', NULL, '10.1.16.153', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVjZJTmlxdjRkSTl0dEpYSEhidjFvdXY3MWRTV0h5cVlweG1ubWpwZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL2xvZ2luIjt9fQ==', 1744269315),
	('Cn7Ga1KEf74UYj2v0uI6usAhee7uOS9VkqnByJXB', 1, '10.1.26.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMlVib3c0N2pNTUNHZXA3M051bkNaSW9lSXZIdlpqMndsQ05WM1pHRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL3VzZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMiRUQ0E2UTl3Z1Q3T0NzNjJBN1c0cTVlZjFRUFBFQlhzejdXUmFuOHp2OC95OHYwMXU4dnIvZSI7fQ==', 1744260627),
	('dAVd2zGXTN0wCQhVHpCq4uyOi4orC57fZNwsgNoq', NULL, '10.1.12.133', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiNFhzanJKaWFrM2kyVzdUWFRuTU90a1M2eFQ2YjlTa29rd0lIMlBlciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744258269),
	('DmMEQ6ypEO0wqg5rnsNFVjvbHCJcdS2XOejfMmmb', NULL, '10.1.28.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUmhsZFVuNGg3c2txTmJQbHB0SjJXU1lKeE5YVnpOaE0wMk9kQ2JEVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744257642),
	('Jqps9oHr5f40mRNYhpJWJx2YBb52KbpTeTWaPPO6', NULL, '10.1.38.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiOXJ3bzdlVDhqbElzVmtIeVpmdm1kZU4yd0tNYUlTNVk2S25DeTJEdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744257682),
	('LcAUPm1JUSU2D55mej6Tg9g6yyDPrOqlOYUGPc9Z', NULL, '10.1.2.164', 'Mozilla/5.0 (compatible; Discordbot/2.0; +https://discordapp.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZnBHWmJYOFlERkZ0akhOWmo5N2thRDFNSUtUVXQyZFhSc05PQkhabCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744258162),
	('li7BnAJ4HRkCIwX71Prl9LP1MaxqiB5oGr8bBNOg', NULL, '10.1.26.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiREdub3hoZms5UTlraGQ4QnJjZXYwNTF5MTNBMDFkb0I5OEFFTG5nRyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL2xvZ2luIjt9fQ==', 1744268639),
	('lnQSv60a5WtzhgWzZBJurKMlPpgOadL5YsQKqYPR', NULL, '10.1.9.182', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMUpWS3B0QXJTNjV6UW8ySDdVV2JiVXhPeVQ3R3ltb3VFTHRlQ2pXTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744258175),
	('sRnUlqdlnva6NhJ2MnouyZcXmtCmLVwUnrDvnFY0', NULL, '10.1.28.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVjNBUTdndVNwSDRiSUxOeHZkbk80YzFkZTJ5YUhkcEJnS2pmelczSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744258235),
	('v9KNwl76AjZnEdnslrO3vmDEXzG8gwOuspuXhLnh', NULL, '10.1.28.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTE1MTUt0enNRWkpMTjc5bm10NE41Um9jQUZyYmFGNGxPVjJiY0VaUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744268907),
	('W0jFMGOksHJjnnmpm8nuUL0Z3ZdQwFkorjxHAShm', NULL, '10.1.30.206', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWkQwT2NQYVdqRXhreDVIak9kcE5XT1FGSXBEVjlJREszZWZuWnIxQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL2xvZ2luIjt9fQ==', 1744269473),
	('XMiHXyfWT0Y6Oo7AJtAxX1j25cZ6acHdl2zraMpV', NULL, '10.1.14.62', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmozSkRwZ2hVTmtDbVFIV2FjVEM2elBaVng1ZmdiVFBSOEx1VVpvTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL2xvZ2luIjt9fQ==', 1744258051);

-- Dumping structure for table fvb1sp63uzi8xp6g.status_change_logs
CREATE TABLE IF NOT EXISTS `status_change_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `document_id` int NOT NULL,
  `old_status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `new_status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `change_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remarks` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`),
  CONSTRAINT `status_change_logs_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `document_requests` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.status_change_logs: ~0 rows (approximately)

-- Dumping structure for table fvb1sp63uzi8xp6g.user_accounts
CREATE TABLE IF NOT EXISTS `user_accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `age` int DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_general_ci NOT NULL,
  `adrHouseNo` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adrZone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adrStreet` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birthday` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_profile_picture` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'default.jpg',
  `last_active` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci GENERATED ALWAYS AS (concat(`firstName`,_utf8mb4' ',`lastName`)) STORED,
  `status` enum('pending','verified','rejected') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `user_valid_id` longtext COLLATE utf8mb4_general_ci,
  `user_valid_id_back` longtext COLLATE utf8mb4_general_ci,
  `verified_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `idx_full_name` (`full_name`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.user_accounts: ~3 rows (approximately)
INSERT IGNORE INTO `user_accounts` (`id`, `firstName`, `lastName`, `username`, `age`, `gender`, `adrHouseNo`, `adrZone`, `adrStreet`, `birthday`, `password`, `user_profile_picture`, `last_active`, `status`, `user_valid_id`, `user_valid_id_back`, `verified_at`, `rejected_at`, `created_at`, `updated_at`) VALUES
	(47, 'Kat', 'Arina', 'kat', 31, 'male', '123', '123', '123', '1994-04-01', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744346430/user_profile_pictures/user_profile_1744346430_67f89d3ed6e69.jpg', '2025-04-12 22:36:13', 'verified', '/storage/uploads/valid_ids/67ebb65c6aa5a_front_valid_id_2389568226844613097.jpg', '/storage/uploads/valid_ids/67ebb65c6b224_back_valid_id_back_2207045255775656039.jpg', '2025-04-10 20:54:20', '2025-04-10 20:54:12', '2025-04-01 17:48:12', '2025-04-10 20:54:20'),
	(48, 'David', 'Olerio', 'davis', 21, 'male', '497', 'ISU', 'Kalaw', '2003-12-22', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744341668/user_profile_pictures/user_profile_1744341668_67f88aa40e6b1.jpg', '2025-04-17 15:17:30', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744340946/user_valid_ids/user_id_1744340946_front_valid_id_67f887d26cad0.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744340947/user_valid_ids/user_id_1744340946_back_valid_id_back_67f887d2e9c2a.jpg', '2025-04-11 11:20:18', NULL, '2025-04-11 11:09:07', '2025-04-11 11:20:18'),
	(49, 'John', 'Doe', 'JohnDoe', 20, 'male', '123', 'Polar Village', 'Kalaw', '2004-04-13', 'kj1OCLK/cXIGeqTFeV1o0pz2hjm8WUCyFUG86ZzJjDQ=', 'default.jpg', '2025-04-18 12:10:16', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744581861/user_valid_ids/user_id_1744581861_front_valid_id_67fc34e5294cf.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744581862/user_valid_ids/user_id_1744581862_back_valid_id_back_67fc34e60293d.jpg', '2025-04-14 06:04:51', NULL, '2025-04-14 06:04:22', '2025-04-14 06:04:51');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
