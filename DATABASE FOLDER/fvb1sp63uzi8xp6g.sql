-- --------------------------------------------------------
-- Host:                         tuy8t6uuvh43khkk.cbetxkdyhwsb.us-east-1.rds.amazonaws.com
-- Server version:               8.0.40 - Source distribution
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
	(1, 'Rannie Camba', 'rannie', '$2y$12$GZAiJDOzsPKNr2BjBe7N4.P1klOBv3RHmX5xM.DTjLPq0WOsQptO6', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747321203/admin_profile_pictures/admin_1_1747321203.png', NULL, '2025-05-21 21:03:43'),
	(2, 'Diosdado Tempra', 'deejaytempra123', '$2y$12$BXgSxfDDIcGcy6YL5GbFx.1DTWBuVl/vD0MYWAZZcZYB0Z7.gsGC6', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744381830/admin_profile_pictures/admin_2_1744381830.jpg', NULL, '2025-04-26 09:41:15'),
	(3, 'Gabrielle Maglaya', 'gab', '$2y$12$TCA6Q9wgT7OCs62A7W4q5ef1QPPEBXsz7WRan8zv8/y8v01u8vr/e', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745979869/admin_profile_pictures/admin_3_1745979869.jpg', NULL, '2025-04-30 10:24:29'),
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.barangay_announcements: ~6 rows (approximately)
INSERT IGNORE INTO `barangay_announcements` (`id`, `announcement_title`, `description_text`, `announcement_images`, `created_at`, `posted_at`) VALUES
	(10, 'CLEAN-UP DRIVE at Maricaban Creek', 'As we approach EARTH DAY with the theme: OUR POWER, OUR PLANET, the Metropolitan Environmental Office- MEO West under the Department of Environment and Natural Resources -DENR in cooperation with Post Proper Southside headed by Punong Barangay Quirino Sarono and Council, led by Committee in charge Kagawad Elmer Baldonado together with Environmental Police were organizing a CLEARING and CLEAN-UP Activity along the water ways at Maricaban Creek to enhance the preservation and protection of our natural resources.\r\n.\r\n#KapQS\r\n#SERBISYONG SARONO\r\n#IHEARTSOUTHSIDE\r\n#SOUTHSIDE2025\r\nONE DREAM....ONE GOAL...ONE COMMUNITY', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339817\\/announcement_images\\/announcement_1744339817_67f8836933ed3.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339817\\/announcement_images\\/announcement_1744339817_67f88369b2ea6.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339818\\/announcement_images\\/announcement_1744339818_67f8836a31f33.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339818\\/announcement_images\\/announcement_1744339818_67f8836ac14fc.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339819\\/announcement_images\\/announcement_1744339819_67f8836b4bb7d.jpg"]', '2025-04-11 10:50:19', '2025-04-11 10:50:19'),
	(11, 'Fire Incident  4/8/25', 'Southside B.E.R.T Responded at a reported fire Incident at A.Mabini St, Brgy. Tuktukan Taguig City that involves a residential area.\r\nKeep safe everyone 🙏\r\nReminder from Punong Barangay Quirino Sarono  and Council.', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342261\\/announcement_images\\/announcement_1744342261_67f88cf57ad76.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342262\\/announcement_images\\/announcement_1744342262_67f88cf621d0d.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342263\\/announcement_images\\/announcement_1744342263_67f88cf715963.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342263\\/announcement_images\\/announcement_1744342263_67f88cf7c007d.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342264\\/announcement_images\\/announcement_1744342264_67f88cf843b62.jpg"]', '2025-04-11 11:31:06', '2025-04-11 11:31:06'),
	(14, '04/11/2025', 'Southside BERT conducted a flashing operation for an oil spill at Buting Brgy. East Rembo, Taguig City.', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391161\\/announcement_images\\/announcement_1744391160_67f94bf8f1ed4.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391161\\/announcement_images\\/announcement_1744391161_67f94bf9983cf.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391162\\/announcement_images\\/announcement_1744391162_67f94bfa2757e.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391163\\/announcement_images\\/announcement_1744391163_67f94bfb0fdbf.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391163\\/announcement_images\\/announcement_1744391163_67f94bfbba560.jpg"]', '2025-04-12 01:06:04', '2025-04-12 01:06:04'),
	(25, 'awddsgfasd', 'asdfsafdg', NULL, '2025-05-24 12:04:00', '2025-05-24 12:04:00'),
	(26, 'asdfasd', 'asdfasdf', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1748059461\\/announcement_images\\/announcement_1748059461_68314545d2540.jpg"]', '2025-05-24 12:04:22', '2025-05-24 12:04:22'),
	(27, 'gfhjghjkgfjhk', 'hjkfhjk', NULL, '2025-05-24 12:04:34', '2025-05-24 12:04:34');

-- Dumping structure for table fvb1sp63uzi8xp6g.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.cache: ~265 rows (approximately)
INSERT IGNORE INTO `cache` (`key`, `value`, `expiration`) VALUES
	('barangay_management_system_cache_005a9b7644ed65d9c322d570e18d7bad', 'i:1;', 1745857904),
	('barangay_management_system_cache_005a9b7644ed65d9c322d570e18d7bad:timer', 'i:1745857904;', 1745857904),
	('barangay_management_system_cache_0078688bc9c722775d928f1d5948348e', 'i:1;', 1744514042),
	('barangay_management_system_cache_0078688bc9c722775d928f1d5948348e:timer', 'i:1744514042;', 1744514042),
	('barangay_management_system_cache_015730a663b3171f618d69212b1d532b', 'i:1;', 1747746054),
	('barangay_management_system_cache_015730a663b3171f618d69212b1d532b:timer', 'i:1747746054;', 1747746054),
	('barangay_management_system_cache_05900a516dc000ce21a668313e6230b6', 'i:1;', 1745124589),
	('barangay_management_system_cache_05900a516dc000ce21a668313e6230b6:timer', 'i:1745124589;', 1745124589),
	('barangay_management_system_cache_08847be4f3d1acca85dbc75e26f27c83', 'i:1;', 1744380848),
	('barangay_management_system_cache_08847be4f3d1acca85dbc75e26f27c83:timer', 'i:1744380848;', 1744380848),
	('barangay_management_system_cache_08ce9dce8170e964e09c32545695f727', 'i:1;', 1744279545),
	('barangay_management_system_cache_08ce9dce8170e964e09c32545695f727:timer', 'i:1744279545;', 1744279545),
	('barangay_management_system_cache_0ab72bb598711da99a80a6c4e6610750', 'i:1;', 1745670211),
	('barangay_management_system_cache_0ab72bb598711da99a80a6c4e6610750:timer', 'i:1745670211;', 1745670211),
	('barangay_management_system_cache_0e0de308602396d9e2f5084d8b59e614', 'i:2;', 1744389948),
	('barangay_management_system_cache_0e0de308602396d9e2f5084d8b59e614:timer', 'i:1744389948;', 1744389948),
	('barangay_management_system_cache_0f341b60aca14793d1a0ee630f21bcca', 'i:2;', 1744385258),
	('barangay_management_system_cache_0f341b60aca14793d1a0ee630f21bcca:timer', 'i:1744385258;', 1744385258),
	('barangay_management_system_cache_15f4e6502202c511adc9da0132b2a50b', 'i:1;', 1746550040),
	('barangay_management_system_cache_15f4e6502202c511adc9da0132b2a50b:timer', 'i:1746550040;', 1746550040),
	('barangay_management_system_cache_2392574368ab3cb3686acec118c7cacf', 'i:1;', 1746550033),
	('barangay_management_system_cache_2392574368ab3cb3686acec118c7cacf:timer', 'i:1746550033;', 1746550033),
	('barangay_management_system_cache_29202cc02a1b89f36f4be161a15665c6', 'i:1;', 1747285391),
	('barangay_management_system_cache_29202cc02a1b89f36f4be161a15665c6:timer', 'i:1747285391;', 1747285391),
	('barangay_management_system_cache_293c1abc3454cf456f196f0e1d158d93', 'i:1;', 1745631855),
	('barangay_management_system_cache_293c1abc3454cf456f196f0e1d158d93:timer', 'i:1745631855;', 1745631855),
	('barangay_management_system_cache_2bdf2b77e0f753419a964a07d3fbf5a0', 'i:1;', 1747225942),
	('barangay_management_system_cache_2bdf2b77e0f753419a964a07d3fbf5a0:timer', 'i:1747225942;', 1747225942),
	('barangay_management_system_cache_305bfdf0b2a4ba0dea2c3168ab6dd094', 'i:1;', 1744543555),
	('barangay_management_system_cache_305bfdf0b2a4ba0dea2c3168ab6dd094:timer', 'i:1744543555;', 1744543555),
	('barangay_management_system_cache_3189907242e2fc415da16336d901bbb4', 'i:1;', 1744543595),
	('barangay_management_system_cache_3189907242e2fc415da16336d901bbb4:timer', 'i:1744543595;', 1744543595),
	('barangay_management_system_cache_3312c4d1bb2650d2d9fc7a4455e7a395', 'i:1;', 1746164357),
	('barangay_management_system_cache_3312c4d1bb2650d2d9fc7a4455e7a395:timer', 'i:1746164357;', 1746164357),
	('barangay_management_system_cache_35ccc45a0541dc730a80e7e01cb6c68b', 'i:1;', 1747834654),
	('barangay_management_system_cache_35ccc45a0541dc730a80e7e01cb6c68b:timer', 'i:1747834654;', 1747834654),
	('barangay_management_system_cache_370cb812f333c3b677798166b0f5b3e3', 'i:1;', 1744814462),
	('barangay_management_system_cache_370cb812f333c3b677798166b0f5b3e3:timer', 'i:1744814462;', 1744814462),
	('barangay_management_system_cache_394d4f8f5dca2aa8942b0b363c7959f8', 'i:1;', 1747841790),
	('barangay_management_system_cache_394d4f8f5dca2aa8942b0b363c7959f8:timer', 'i:1747841790;', 1747841790),
	('barangay_management_system_cache_3d3eb0fee2e8ac22199f0f395c28f99a', 'i:1;', 1745239150),
	('barangay_management_system_cache_3d3eb0fee2e8ac22199f0f395c28f99a:timer', 'i:1745239150;', 1745239150),
	('barangay_management_system_cache_3ead8462859aef23607ae26f4e843e4c', 'i:1;', 1744418190),
	('barangay_management_system_cache_3ead8462859aef23607ae26f4e843e4c:timer', 'i:1744418190;', 1744418190),
	('barangay_management_system_cache_42f50d03da40bca9e67087aafb3c4b1e', 'i:1;', 1747321247),
	('barangay_management_system_cache_42f50d03da40bca9e67087aafb3c4b1e:timer', 'i:1747321247;', 1747321247),
	('barangay_management_system_cache_4598494d1f16c362fb8c10be25f84f40', 'i:1;', 1744515074),
	('barangay_management_system_cache_4598494d1f16c362fb8c10be25f84f40:timer', 'i:1744515074;', 1744515074),
	('barangay_management_system_cache_4d014eb32245038252699e93fc73171c', 'i:1;', 1744987687),
	('barangay_management_system_cache_4d014eb32245038252699e93fc73171c:timer', 'i:1744987687;', 1744987687),
	('barangay_management_system_cache_4efff9fd1edb0b2ebcd75cdc0263bff5', 'i:1;', 1744260657),
	('barangay_management_system_cache_4efff9fd1edb0b2ebcd75cdc0263bff5:timer', 'i:1744260657;', 1744260657),
	('barangay_management_system_cache_4f10d5e163f884cb68b25edc95d7b970', 'i:1;', 1744515087),
	('barangay_management_system_cache_4f10d5e163f884cb68b25edc95d7b970:timer', 'i:1744515087;', 1744515087),
	('barangay_management_system_cache_531a9b50cb08565a2da58bcab84bbb8e', 'i:1;', 1746124763),
	('barangay_management_system_cache_531a9b50cb08565a2da58bcab84bbb8e:timer', 'i:1746124763;', 1746124763),
	('barangay_management_system_cache_57695924bea1b6962c67eb36106ce575', 'i:1;', 1744380857),
	('barangay_management_system_cache_57695924bea1b6962c67eb36106ce575:timer', 'i:1744380857;', 1744380857),
	('barangay_management_system_cache_583cc051979b474c79fe5ef6cfbaedf0', 'i:1;', 1745631846),
	('barangay_management_system_cache_583cc051979b474c79fe5ef6cfbaedf0:timer', 'i:1745631846;', 1745631846),
	('barangay_management_system_cache_58b7f5712aaa1862a011a41e2bdfaf70', 'i:1;', 1744338523),
	('barangay_management_system_cache_58b7f5712aaa1862a011a41e2bdfaf70:timer', 'i:1744338523;', 1744338523),
	('barangay_management_system_cache_5986bdd1d9eda0d1178844aecb5766f7', 'i:1;', 1744762131),
	('barangay_management_system_cache_5986bdd1d9eda0d1178844aecb5766f7:timer', 'i:1744762131;', 1744762131),
	('barangay_management_system_cache_5cfe04ad4cd55dbd85e44e13add8d6fc', 'i:1;', 1747827848),
	('barangay_management_system_cache_5cfe04ad4cd55dbd85e44e13add8d6fc:timer', 'i:1747827848;', 1747827848),
	('barangay_management_system_cache_5ee0a28aacda039309504c8dddbf5904', 'i:1;', 1746411830),
	('barangay_management_system_cache_5ee0a28aacda039309504c8dddbf5904:timer', 'i:1746411830;', 1746411830),
	('barangay_management_system_cache_600937079dfbb14b447493fba4638dd4', 'i:1;', 1744570661),
	('barangay_management_system_cache_600937079dfbb14b447493fba4638dd4:timer', 'i:1744570661;', 1744570661),
	('barangay_management_system_cache_60b236a4f0e6f9f4b493ac2bf7e1ca43', 'i:1;', 1744595336),
	('barangay_management_system_cache_60b236a4f0e6f9f4b493ac2bf7e1ca43:timer', 'i:1744595336;', 1744595336),
	('barangay_management_system_cache_640c346fb4d1da5ecd55efe772ca44ef', 'i:1;', 1744548402),
	('barangay_management_system_cache_640c346fb4d1da5ecd55efe772ca44ef:timer', 'i:1744548402;', 1744548402),
	('barangay_management_system_cache_663057c1c622380dca57676ee313533d', 'i:1;', 1745631224),
	('barangay_management_system_cache_663057c1c622380dca57676ee313533d:timer', 'i:1745631224;', 1745631224),
	('barangay_management_system_cache_6acc119dd58b1a6a8ffbc97c71d50d9b', 'i:1;', 1744274439),
	('barangay_management_system_cache_6acc119dd58b1a6a8ffbc97c71d50d9b:timer', 'i:1744274439;', 1744274439),
	('barangay_management_system_cache_6c81b851f940c286a0834aaad68b50d5', 'i:1;', 1744381875),
	('barangay_management_system_cache_6c81b851f940c286a0834aaad68b50d5:timer', 'i:1744381875;', 1744381875),
	('barangay_management_system_cache_6d95469a2ed887f954ae03439f49ab2d', 'i:1;', 1745552871),
	('barangay_management_system_cache_6d95469a2ed887f954ae03439f49ab2d:timer', 'i:1745552871;', 1745552871),
	('barangay_management_system_cache_6e44331b4e63509763c5bd8e8a33643b', 'i:1;', 1744285235),
	('barangay_management_system_cache_6e44331b4e63509763c5bd8e8a33643b:timer', 'i:1744285235;', 1744285235),
	('barangay_management_system_cache_71dbe8c5b319450e4894bc6533525ecb', 'i:1;', 1748144172),
	('barangay_management_system_cache_71dbe8c5b319450e4894bc6533525ecb:timer', 'i:1748144172;', 1748144172),
	('barangay_management_system_cache_7260056b391e58d8457f76336ba3ae75', 'i:1;', 1744303404),
	('barangay_management_system_cache_7260056b391e58d8457f76336ba3ae75:timer', 'i:1744303404;', 1744303404),
	('barangay_management_system_cache_74556341a18970c89a2621475047b288', 'i:1;', 1745804209),
	('barangay_management_system_cache_74556341a18970c89a2621475047b288:timer', 'i:1745804209;', 1745804209),
	('barangay_management_system_cache_74b42a84b530dd3a1f5a85274d5395ae', 'i:1;', 1745074211),
	('barangay_management_system_cache_74b42a84b530dd3a1f5a85274d5395ae:timer', 'i:1745074211;', 1745074211),
	('barangay_management_system_cache_75e7196c76246b91a4667542a81525ed', 'i:1;', 1747891820),
	('barangay_management_system_cache_75e7196c76246b91a4667542a81525ed:timer', 'i:1747891820;', 1747891820),
	('barangay_management_system_cache_761b621353885863fec64591dc194d88', 'i:1;', 1744379741),
	('barangay_management_system_cache_761b621353885863fec64591dc194d88:timer', 'i:1744379741;', 1744379741),
	('barangay_management_system_cache_766634463381f4012f34e2f2bb729478', 'i:1;', 1744859777),
	('barangay_management_system_cache_766634463381f4012f34e2f2bb729478:timer', 'i:1744859777;', 1744859777),
	('barangay_management_system_cache_77ed66684c3d47d0ac25812d2619c724', 'i:1;', 1744278029),
	('barangay_management_system_cache_77ed66684c3d47d0ac25812d2619c724:timer', 'i:1744278029;', 1744278029),
	('barangay_management_system_cache_7a7c114be63e3ce303a4f3a4ba8efe3a', 'i:1;', 1744352566),
	('barangay_management_system_cache_7a7c114be63e3ce303a4f3a4ba8efe3a:timer', 'i:1744352566;', 1744352566),
	('barangay_management_system_cache_7cc3df17648e4539edf205e544143dc0', 'i:1;', 1745632086),
	('barangay_management_system_cache_7cc3df17648e4539edf205e544143dc0:timer', 'i:1745632086;', 1745632086),
	('barangay_management_system_cache_7eaac21daffb57284d6f85e2152b9a25', 'i:1;', 1744953220),
	('barangay_management_system_cache_7eaac21daffb57284d6f85e2152b9a25:timer', 'i:1744953220;', 1744953220),
	('barangay_management_system_cache_7ec3c7ae5aa3eeefd919065bc0927a41', 'i:1;', 1745857899),
	('barangay_management_system_cache_7ec3c7ae5aa3eeefd919065bc0927a41:timer', 'i:1745857899;', 1745857899),
	('barangay_management_system_cache_7f0da50b3b590e6e006c1fb73da35e12', 'i:1;', 1744421157),
	('barangay_management_system_cache_7f0da50b3b590e6e006c1fb73da35e12:timer', 'i:1744421157;', 1744421157),
	('barangay_management_system_cache_7f129c1b3a3a2ad934ea9e3e93c87f36', 'i:1;', 1744287193),
	('barangay_management_system_cache_7f129c1b3a3a2ad934ea9e3e93c87f36:timer', 'i:1744287193;', 1744287193),
	('barangay_management_system_cache_8077ff0cafa1da9e2c1e09c10f41d9e7', 'i:1;', 1745631838),
	('barangay_management_system_cache_8077ff0cafa1da9e2c1e09c10f41d9e7:timer', 'i:1745631838;', 1745631838),
	('barangay_management_system_cache_82d7a3ac868cb362500cef10c0aa952a', 'i:1;', 1747324679),
	('barangay_management_system_cache_82d7a3ac868cb362500cef10c0aa952a:timer', 'i:1747324679;', 1747324679),
	('barangay_management_system_cache_84063fddd121580d2633f5ee76b16ccd', 'i:1;', 1745505898),
	('barangay_management_system_cache_84063fddd121580d2633f5ee76b16ccd:timer', 'i:1745505898;', 1745505898),
	('barangay_management_system_cache_87559ae568ad8ad9caae0440612224af', 'i:1;', 1748050764),
	('barangay_management_system_cache_87559ae568ad8ad9caae0440612224af:timer', 'i:1748050763;', 1748050764),
	('barangay_management_system_cache_87a8c9e79018abbf8e4e7935e5def232', 'i:1;', 1747285441),
	('barangay_management_system_cache_87a8c9e79018abbf8e4e7935e5def232:timer', 'i:1747285441;', 1747285441),
	('barangay_management_system_cache_90cac04b54f47199d3fbecf27cefdabe', 'i:1;', 1744278023),
	('barangay_management_system_cache_90cac04b54f47199d3fbecf27cefdabe:timer', 'i:1744278023;', 1744278023),
	('barangay_management_system_cache_939fea01959f44a59cc629af27af099e', 'i:1;', 1744373996),
	('barangay_management_system_cache_939fea01959f44a59cc629af27af099e:timer', 'i:1744373996;', 1744373996),
	('barangay_management_system_cache_99a254f768ff5dc4ca6f65b8f86ba86f', 'i:1;', 1748147946),
	('barangay_management_system_cache_99a254f768ff5dc4ca6f65b8f86ba86f:timer', 'i:1748147946;', 1748147946),
	('barangay_management_system_cache_9fdaf3d8cf52a797b1fa4f23c5b27415', 'i:1;', 1744873627),
	('barangay_management_system_cache_9fdaf3d8cf52a797b1fa4f23c5b27415:timer', 'i:1744873627;', 1744873627),
	('barangay_management_system_cache_a27578afa9c35c7a147d4cdc4f98d273', 'i:1;', 1744389938),
	('barangay_management_system_cache_a27578afa9c35c7a147d4cdc4f98d273:timer', 'i:1744389938;', 1744389938),
	('barangay_management_system_cache_a5472241912702c8451e213b9026e6e0', 'i:1;', 1745932477),
	('barangay_management_system_cache_a5472241912702c8451e213b9026e6e0:timer', 'i:1745932477;', 1745932477),
	('barangay_management_system_cache_a5b63fd1af204d60d71dc2720618a0fe', 'i:1;', 1745487660),
	('barangay_management_system_cache_a5b63fd1af204d60d71dc2720618a0fe:timer', 'i:1745487660;', 1745487660),
	('barangay_management_system_cache_a80fd803200e90d615d83947bead358c', 'i:1;', 1748037741),
	('barangay_management_system_cache_a80fd803200e90d615d83947bead358c:timer', 'i:1748037741;', 1748037741),
	('barangay_management_system_cache_a839739e32d735d1e274a0727d0d3526', 'i:1;', 1744380804),
	('barangay_management_system_cache_a839739e32d735d1e274a0727d0d3526:timer', 'i:1744380804;', 1744380804),
	('barangay_management_system_cache_a8c17b62921d93570477ced159c9a729', 'i:1;', 1745979906),
	('barangay_management_system_cache_a8c17b62921d93570477ced159c9a729:timer', 'i:1745979906;', 1745979906),
	('barangay_management_system_cache_a959dbf730e494ba316e1e16772550d6', 'i:1;', 1746625808),
	('barangay_management_system_cache_a959dbf730e494ba316e1e16772550d6:timer', 'i:1746625808;', 1746625808),
	('barangay_management_system_cache_a96fc96abd272a0a7da4a7ec5bf52c0f', 'i:1;', 1747832662),
	('barangay_management_system_cache_a96fc96abd272a0a7da4a7ec5bf52c0f:timer', 'i:1747832662;', 1747832662),
	('barangay_management_system_cache_a9830df68d025d5770554865424301cd', 'i:1;', 1744385281),
	('barangay_management_system_cache_a9830df68d025d5770554865424301cd:timer', 'i:1744385281;', 1744385281),
	('barangay_management_system_cache_aa2255f14e2e18b80439bb0e2326dcde', 'i:1;', 1745105302),
	('barangay_management_system_cache_aa2255f14e2e18b80439bb0e2326dcde:timer', 'i:1745105302;', 1745105302),
	('barangay_management_system_cache_admin|10.1.14.110', 'i:1;', 1744515069),
	('barangay_management_system_cache_admin|10.1.14.110:timer', 'i:1744515069;', 1744515069),
	('barangay_management_system_cache_admin|10.1.90.219', 'i:1;', 1744515074),
	('barangay_management_system_cache_admin|10.1.90.219:timer', 'i:1744515074;', 1744515074),
	('barangay_management_system_cache_adw|10.1.11.165', 'i:1;', 1745856039),
	('barangay_management_system_cache_adw|10.1.11.165:timer', 'i:1745856039;', 1745856039),
	('barangay_management_system_cache_ae0c44bb5d3f185ee1aec366accd3106', 'i:1;', 1747842720),
	('barangay_management_system_cache_ae0c44bb5d3f185ee1aec366accd3106:timer', 'i:1747842720;', 1747842720),
	('barangay_management_system_cache_b1fa0729d6c8ab952788345b6f02543e', 'i:1;', 1744270270),
	('barangay_management_system_cache_b1fa0729d6c8ab952788345b6f02543e:timer', 'i:1744270270;', 1744270270),
	('barangay_management_system_cache_b2720943e942888201428a3fd3fdfa90', 'i:1;', 1748011483),
	('barangay_management_system_cache_b2720943e942888201428a3fd3fdfa90:timer', 'i:1748011483;', 1748011483),
	('barangay_management_system_cache_b5a560aba3f5149d4b71533a2b605fb3', 'i:1;', 1744385535),
	('barangay_management_system_cache_b5a560aba3f5149d4b71533a2b605fb3:timer', 'i:1744385535;', 1744385535),
	('barangay_management_system_cache_b86e8abcc7394c6a930f65d07d1367bb', 'i:1;', 1745856039),
	('barangay_management_system_cache_b86e8abcc7394c6a930f65d07d1367bb:timer', 'i:1745856039;', 1745856039),
	('barangay_management_system_cache_ba82ba31fabf3401e92c302e4a49b0e1', 'i:1;', 1745612889),
	('barangay_management_system_cache_ba82ba31fabf3401e92c302e4a49b0e1:timer', 'i:1745612889;', 1745612889),
	('barangay_management_system_cache_bb1d88dcf3dc85b7c3ded4d01e66d74e', 'i:1;', 1745152750),
	('barangay_management_system_cache_bb1d88dcf3dc85b7c3ded4d01e66d74e:timer', 'i:1745152750;', 1745152750),
	('barangay_management_system_cache_bc93efd58e1fce253e1c172ecbcd7357', 'i:1;', 1744515069),
	('barangay_management_system_cache_bc93efd58e1fce253e1c172ecbcd7357:timer', 'i:1744515069;', 1744515069),
	('barangay_management_system_cache_be5d06688aa00c62f75a27d1d5efc54f', 'i:1;', 1745632945),
	('barangay_management_system_cache_be5d06688aa00c62f75a27d1d5efc54f:timer', 'i:1745632945;', 1745632945),
	('barangay_management_system_cache_bf3616f54adab99cc982dddbcd59f309', 'i:1;', 1746372412),
	('barangay_management_system_cache_bf3616f54adab99cc982dddbcd59f309:timer', 'i:1746372412;', 1746372412),
	('barangay_management_system_cache_c31ad8b9cb9be9b7184913ff5272ab32', 'i:1;', 1745544193),
	('barangay_management_system_cache_c31ad8b9cb9be9b7184913ff5272ab32:timer', 'i:1745544193;', 1745544193),
	('barangay_management_system_cache_c6326998039eae46f6dac7ba8e7bc3c0', 'i:1;', 1747295451),
	('barangay_management_system_cache_c6326998039eae46f6dac7ba8e7bc3c0:timer', 'i:1747295451;', 1747295451),
	('barangay_management_system_cache_cb4853c637f574fc0ee6f47c967b94a7', 'i:1;', 1747998549),
	('barangay_management_system_cache_cb4853c637f574fc0ee6f47c967b94a7:timer', 'i:1747998549;', 1747998549),
	('barangay_management_system_cache_cb77a03b70f6ec890d48ae250fefc63c', 'i:1;', 1746374914),
	('barangay_management_system_cache_cb77a03b70f6ec890d48ae250fefc63c:timer', 'i:1746374914;', 1746374914),
	('barangay_management_system_cache_cba730c79fb0bd1768e679df3db6984e', 'i:1;', 1746348168),
	('barangay_management_system_cache_cba730c79fb0bd1768e679df3db6984e:timer', 'i:1746348168;', 1746348168),
	('barangay_management_system_cache_cbb427eb8274bce19f1b0720d0a2da65', 'i:2;', 1747834539),
	('barangay_management_system_cache_cbb427eb8274bce19f1b0720d0a2da65:timer', 'i:1747834539;', 1747834539),
	('barangay_management_system_cache_cbe87f5425c68c23f67b0c8d1130d707', 'i:1;', 1746206907),
	('barangay_management_system_cache_cbe87f5425c68c23f67b0c8d1130d707:timer', 'i:1746206907;', 1746206907),
	('barangay_management_system_cache_cc14d382614cb6ef4a91738b6ea5906a', 'i:1;', 1748011693),
	('barangay_management_system_cache_cc14d382614cb6ef4a91738b6ea5906a:timer', 'i:1748011693;', 1748011693),
	('barangay_management_system_cache_cc51cac703b7ba72a5dc794ad82fdc87', 'i:1;', 1745209901),
	('barangay_management_system_cache_cc51cac703b7ba72a5dc794ad82fdc87:timer', 'i:1745209901;', 1745209901),
	('barangay_management_system_cache_cffa08a72f58581a0b0c61f57b0bc680', 'i:1;', 1746024354),
	('barangay_management_system_cache_cffa08a72f58581a0b0c61f57b0bc680:timer', 'i:1746024354;', 1746024354),
	('barangay_management_system_cache_d42883fb5485d3c93a24ce82b447270f', 'i:1;', 1746530737),
	('barangay_management_system_cache_d42883fb5485d3c93a24ce82b447270f:timer', 'i:1746530737;', 1746530737),
	('barangay_management_system_cache_d4a5ce729f59167dd03339053cbcd7cd', 'i:1;', 1747295740),
	('barangay_management_system_cache_d4a5ce729f59167dd03339053cbcd7cd:timer', 'i:1747295740;', 1747295740),
	('barangay_management_system_cache_d536e19f2d9ce905f9268351699fc67f', 'i:1;', 1747278087),
	('barangay_management_system_cache_d536e19f2d9ce905f9268351699fc67f:timer', 'i:1747278087;', 1747278087),
	('barangay_management_system_cache_d5f814493aa88ae39b2e36378b8117ba', 'i:1;', 1748011655),
	('barangay_management_system_cache_d5f814493aa88ae39b2e36378b8117ba:timer', 'i:1748011655;', 1748011655),
	('barangay_management_system_cache_d7bc32c24e54a0cc6c5db4d93d0c5e63', 'i:1;', 1746097004),
	('barangay_management_system_cache_d7bc32c24e54a0cc6c5db4d93d0c5e63:timer', 'i:1746097004;', 1746097004),
	('barangay_management_system_cache_dashboard_stats', 'a:3:{s:19:"registeredResidents";i:10;s:16:"pendingDocuments";i:9;s:15:"incidentReports";i:11;}', 1748154843),
	('barangay_management_system_cache_db5ed4c297735df0a17870924beca0c1', 'i:1;', 1746863967),
	('barangay_management_system_cache_db5ed4c297735df0a17870924beca0c1:timer', 'i:1746863967;', 1746863967),
	('barangay_management_system_cache_dbec43877e78c382a331704e3ff3c4a4', 'i:1;', 1745802981),
	('barangay_management_system_cache_dbec43877e78c382a331704e3ff3c4a4:timer', 'i:1745802981;', 1745802981),
	('barangay_management_system_cache_dd76d6e3e01e4686f914d8d7ef237b6f', 'i:1;', 1747295467),
	('barangay_management_system_cache_dd76d6e3e01e4686f914d8d7ef237b6f:timer', 'i:1747295467;', 1747295467),
	('barangay_management_system_cache_de6506d52d8374b880b959cac1a46277', 'i:1;', 1746096935),
	('barangay_management_system_cache_de6506d52d8374b880b959cac1a46277:timer', 'i:1746096935;', 1746096935),
	('barangay_management_system_cache_deejaytempra|10.1.0.208', 'i:1;', 1745631846),
	('barangay_management_system_cache_deejaytempra|10.1.0.208:timer', 'i:1745631846;', 1745631846),
	('barangay_management_system_cache_deejaytempra|10.1.84.240', 'i:1;', 1745631838),
	('barangay_management_system_cache_deejaytempra|10.1.84.240:timer', 'i:1745631838;', 1745631838),
	('barangay_management_system_cache_df1acd42dd0b5e8d7cfb99b5ac279703', 'i:1;', 1744453920),
	('barangay_management_system_cache_df1acd42dd0b5e8d7cfb99b5ac279703:timer', 'i:1744453920;', 1744453920),
	('barangay_management_system_cache_e10b3d0290703ea241c431d4f400bec0', 'i:1;', 1746163348),
	('barangay_management_system_cache_e10b3d0290703ea241c431d4f400bec0:timer', 'i:1746163348;', 1746163348),
	('barangay_management_system_cache_e496b0f77f096dc941263e5d8c295ca0', 'i:1;', 1747832782),
	('barangay_management_system_cache_e496b0f77f096dc941263e5d8c295ca0:timer', 'i:1747832782;', 1747832782),
	('barangay_management_system_cache_e4a09e5154a55b9df2ddfee8d8db71b0', 'i:1;', 1746936883),
	('barangay_management_system_cache_e4a09e5154a55b9df2ddfee8d8db71b0:timer', 'i:1746936883;', 1746936883),
	('barangay_management_system_cache_e5614c91eb3c5dab94476db367e9067e', 'i:1;', 1746176534),
	('barangay_management_system_cache_e5614c91eb3c5dab94476db367e9067e:timer', 'i:1746176534;', 1746176534),
	('barangay_management_system_cache_e56c0ce53ea3b404bc400d179b7a95a1', 'i:1;', 1746161128),
	('barangay_management_system_cache_e56c0ce53ea3b404bc400d179b7a95a1:timer', 'i:1746161128;', 1746161128),
	('barangay_management_system_cache_e5fa6ba3d7ec923d7c4fc7986051b36e', 'i:1;', 1745932469),
	('barangay_management_system_cache_e5fa6ba3d7ec923d7c4fc7986051b36e:timer', 'i:1745932469;', 1745932469),
	('barangay_management_system_cache_eb56b1dc7c9659624afbf5f9b710a460', 'i:1;', 1744543575),
	('barangay_management_system_cache_eb56b1dc7c9659624afbf5f9b710a460:timer', 'i:1744543575;', 1744543575),
	('barangay_management_system_cache_ec8442e4a829d8e3fdaaa3bcecaf8384', 'i:1;', 1746718985),
	('barangay_management_system_cache_ec8442e4a829d8e3fdaaa3bcecaf8384:timer', 'i:1746718985;', 1746718985),
	('barangay_management_system_cache_eff1d325155b347fc32ee1ecfafe797e', 'i:1;', 1747834632),
	('barangay_management_system_cache_eff1d325155b347fc32ee1ecfafe797e:timer', 'i:1747834632;', 1747834632),
	('barangay_management_system_cache_effe82cae54113fdcf4f33a5831e8708', 'i:3;', 1747295408),
	('barangay_management_system_cache_effe82cae54113fdcf4f33a5831e8708:timer', 'i:1747295408;', 1747295408),
	('barangay_management_system_cache_f0001928308f4a6543afda4348e3b7be', 'i:1;', 1748002858),
	('barangay_management_system_cache_f0001928308f4a6543afda4348e3b7be:timer', 'i:1748002858;', 1748002858),
	('barangay_management_system_cache_f24a1c12ff4591cce5dc62f6f70b3983', 'i:1;', 1745074280),
	('barangay_management_system_cache_f24a1c12ff4591cce5dc62f6f70b3983:timer', 'i:1745074280;', 1745074280),
	('barangay_management_system_cache_f29e83d982589460fd2ac0f69fa12b11', 'i:1;', 1745897731),
	('barangay_management_system_cache_f29e83d982589460fd2ac0f69fa12b11:timer', 'i:1745897731;', 1745897731),
	('barangay_management_system_cache_f7204f6a47846c283d9cc78ada1d7585', 'i:1;', 1747882419),
	('barangay_management_system_cache_f7204f6a47846c283d9cc78ada1d7585:timer', 'i:1747882419;', 1747882419),
	('barangay_management_system_cache_f76f5b2252ca4afcbdda142d0a655dac', 'i:1;', 1746110914),
	('barangay_management_system_cache_f76f5b2252ca4afcbdda142d0a655dac:timer', 'i:1746110914;', 1746110914),
	('barangay_management_system_cache_f84ed1a5970b55d4bba037653ebe4008', 'i:1;', 1745856946),
	('barangay_management_system_cache_f84ed1a5970b55d4bba037653ebe4008:timer', 'i:1745856946;', 1745856946),
	('barangay_management_system_cache_fc0eab601af9abd16650155c3b0baab8', 'i:1;', 1744287251),
	('barangay_management_system_cache_fc0eab601af9abd16650155c3b0baab8:timer', 'i:1744287251;', 1744287251),
	('barangay_management_system_cache_ffa0aefbd0a06910687c21a9c04abbae', 'i:1;', 1747834610),
	('barangay_management_system_cache_ffa0aefbd0a06910687c21a9c04abbae:timer', 'i:1747834610;', 1747834610),
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
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `archived_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `idx_archived` (`archived`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.document_requests: ~31 rows (approximately)
INSERT IGNORE INTO `document_requests` (`Id`, `userId`, `DocumentType`, `Name`, `Address`, `TIN_No`, `CTC_No`, `Alias`, `Age`, `birthday`, `PlaceOfBirth`, `Occupation`, `LengthOfStay`, `Citizenship`, `Gender`, `CivilStatus`, `Purpose`, `Status`, `Quantity`, `DateRequested`, `valid_id`, `valid_id_front`, `valid_id_back`, `request_picture`, `rejection_reason`, `cancellation_reason`, `pickup_status`, `date_approved`, `created_at`, `updated_at`, `archived`, `archived_at`) VALUES
	(1, 48, 'Barangay Clearance', 'David Olerio', '497  Street Zone', '123456789012', '123456789012', 'Dave', 21, '12-22-03', 'Makati City', 'Student', 12, 'Filipino', 'Male', 'Single', 'For Scholarship', 'rejected', 1, '2025-04-11 11:35:24', '', NULL, NULL, '', 'Not enough images', NULL, 'pending', '2025-04-12 00:36:41', NULL, NULL, 0, NULL),
	(2, 48, 'Barangay Clearance', 'David Olerio', '497  Street Zone', '123456789012', '123456789012', 'adawd', 21, '12-22-03', 'awdawdawd', 'awdawda', 12, 'awdawdawd', 'Male', 'Single', 'awdawdawdawdwda', 'approved', 1, '2025-04-11 20:31:58', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744374729/valid_ids/valid_id_1744374729_front_67f90bc9a0969.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744374730/valid_ids/valid_id_1744374730_back_67f90bca480c6.jpg', '', '', NULL, 'picked_up', '2025-04-11 21:46:46', NULL, NULL, 0, NULL),
	(3, 48, 'Certificate of Indigency', 'David Olerio', '497  Street Zone', '653497856217', '645239780489', 'Cleo', 21, '12-22-03', 'Julita Leyte', 'Housewife', 17, 'Filipino', 'Female', 'Single', 'financial', 'approved', 4, '2025-04-11 22:24:11', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744381481/valid_ids/valid_id_1744381480_front_67f92628e8daa.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744381481/valid_ids/valid_id_1744381481_back_67f926299b6c9.jpg', '', '', NULL, 'pending', '2025-04-11 23:13:15', NULL, NULL, 0, NULL),
	(4, 48, 'Barangay Certification', 'David Olerio', '497  Street Zone', '123456789012', '123456789012', 'dave', 21, '12-22-03', 'makati med', 'student', 12, 'filipino', 'Male', 'Single', 'for scholarship', 'rejected', 2, '2025-04-14 09:53:27', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744595634/valid_ids/valid_id_1744595634_front_67fc6ab217998.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744595634/valid_ids/valid_id_1744595634_back_67fc6ab29579c.jpg', '', 'Inappropriate image for ID', NULL, 'pending', NULL, NULL, NULL, 0, NULL),
	(5, 48, 'First Time Job Certificate', 'David Olerio', '497  Street Zone', '123456789012', '123456789012', 'popo', 21, '12-22-03', 'hghgf', 'kargas', 23, 'jhggfgghj', 'Male', 'Single', 'help', 'approved', 2, '2025-04-17 15:05:15', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744873547/valid_ids/valid_id_1744873546_front_6800a84ad748e.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744873548/valid_ids/valid_id_1744873548_back_6800a84c2d791.jpg', '', '', NULL, 'picked_up', '2025-04-26 11:23:42', NULL, NULL, 0, NULL),
	(6, 48, 'Barangay Clearance', 'David Olerio', '497  Street Zone', '123456789012', '123456789012', 'DAVID', 21, '12-22-03', 'MAKATI MEDICAL CENTER', 'student', 12, 'FILIPINO', 'Male', 'Single', 'scholarship', 'pending', 1, '2025-04-18 14:03:59', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744956252/valid_ids/valid_id_1744956252_front_6801eb5c1327e.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744956252/valid_ids/valid_id_1744956252_back_6801eb5c98ba2.jpg', '', '', NULL, 'pending', NULL, NULL, NULL, 0, NULL),
	(7, 47, 'Barangay Clearance', 'Kat Arina', '123  Street Zone', '123456789012', '123456789012', 'HELLO', 31, '04-01-94', 'hell', 'father', 13, 'filipino', 'Male', 'Single', 'house', 'pending', 1, '2025-04-18 14:32:18', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744957948/valid_ids/valid_id_1744957948_front_6801f1fc655fd.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744957948/valid_ids/valid_id_1744957948_back_6801f1fcd4cb1.jpg', '', '', NULL, 'pending', NULL, NULL, NULL, 0, NULL),
	(8, 47, 'Certificate of Indigency', 'Kat Arina', '123  Street Zone', '123456789012', '123456789012', 'ten', 31, '04-01-94', 'hdieieejh', 'builder', 13, 'eiirifgnj', 'Male', 'Single', 'kil', 'pending', 1, '2025-04-18 14:42:51', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744958591/valid_ids/valid_id_1744958590_front_6801f47ed938f.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744958591/valid_ids/valid_id_1744958591_back_6801f47f8a3e7.jpg', '', '', NULL, 'pending', NULL, NULL, NULL, 0, NULL),
	(9, 50, 'Barangay Clearance', 'Clement Harold Miguel Cabus', '497-A ISU Village Kalaw Street', '123456789012', '123456789012', 'Chummy', 21, '12-22-03', 'Makati Medical Center', 'Student', 17, 'Filipino', 'Male', 'Single', 'Scholarship', 'approved', 1, '2025-04-29 11:48:41', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745898531/valid_ids/valid_id_1745898530_front_68104c22eba2d.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745898531/valid_ids/valid_id_1745898531_back_68104c236dc7d.jpg', '', '', NULL, 'pending', '2025-05-02 14:51:31', NULL, NULL, 0, NULL),
	(10, 56, 'Barangay Clearance', 'James Padilla', '321 Mangga Zone 123', '001234567890', '000987654321', 'James', 25, '01-12-00', 'Southside', 'Construction Worker', 20, 'Filipino', 'Male', 'Single', 'Requirement', 'approved', 1, '2025-05-02 12:53:58', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746162951/valid_ids/valid_id_1746162951_front_6814550714efb.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746162951/valid_ids/valid_id_1746162951_back_6814550794331.jpg', '', '', NULL, 'picked_up', '2025-05-02 13:37:49', NULL, NULL, 0, NULL),
	(18, 50, 'Barangay Certification', 'Clement Harold Miguel Cabus', '678-b Hinar street Zone Panam village', '123456789012', '123456789012', 'chummy', 21, '12-22-03', 'Makati Medical Center', 'student', 17, 'Filipino', 'Male', 'Single', 'scholarship', 'approved', 3, '2025-05-02 14:49:21', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746168576/valid_ids/valid_id_1746168576_front_68146b00d7349.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746168577/valid_ids/valid_id_1746168577_back_68146b0144f6a.jpg', '', '', NULL, 'pending', '2025-05-02 14:50:12', NULL, NULL, 0, NULL),
	(27, 50, 'First Time Job Certificate', 'Clement Harold Miguel Cabus', '678-b Hinar street Zone Panam village', '123456789012', '123456789012', 'Chummy', 21, '12-22-03', 'Makati Medical Center', 'Student', 17, 'Filipino', 'Male', 'Single', 'Scholarship', 'approved', 3, '2025-05-15 12:44:07', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747284309/valid_ids/valid_id_1747284309_front_682571550737a.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747284309/valid_ids/valid_id_1747284309_back_6825715591fd9.jpg', '', '', NULL, 'pending', '2025-05-15 13:12:17', NULL, NULL, 0, NULL),
	(28, 63, 'Barangay Clearance', 'mark mark', '34 mangga Zone 5', '111111111111', '000000000000', 'mark', 22, '05-22-03', 'Taguig', 'call center', 21, 'Filipino', 'Male', 'Single', 'barangay clearance', 'approved', 1, '2025-05-22 10:19:59', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747881029/valid_ids/valid_id_1747881029_front_682e8c45b3e8c.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747881030/valid_ids/valid_id_1747881030_back_682e8c46352b0.jpg', '', '', NULL, 'picked_up', '2025-05-22 10:53:41', NULL, NULL, 0, NULL),
	(29, 63, 'Barangay Clearance', 'mark mark', '34 mangga Zone 5', '999999999999', '999999999999', 'hshsj', 22, '05-22-03', 'bsjsj', 'bsjsjj', 8, 'nnjk', 'Male', 'Single', 'bsjsjaja', 'pending', 1, '2025-05-22 11:00:09', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747882841/valid_ids/valid_id_1747882841_front_682e935995eb3.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747882842/valid_ids/valid_id_1747882842_back_682e935a3c465.jpg', '', '', NULL, 'pending', NULL, NULL, NULL, 0, NULL),
	(30, 50, 'Cedula', 'Clement Harold Miguel Cabus', '678-b Hinar street Zone Panam village', '123456789012', '123456789012', 'clem', 21, '12-22-03', 'Makati Medical Center', 'student', 12, 'Filipino', 'Male', 'Single', 'scholarship', 'approved', 3, '2025-05-22 15:09:29', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747897780/valid_ids/valid_id_1747897780_front_682ecdb436a45.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747897780/valid_ids/valid_id_1747897780_back_682ecdb4adc7f.jpg', '', '', NULL, 'pending', '2025-05-24 12:04:52', NULL, NULL, 0, NULL),
	(31, 50, 'Barangay Clearance', 'Clement Harold Miguel Cabus', '678-b Hinar street Zone Panam village', '123456789012', '123456789012', 'cheue', 21, '12-22-03', 'makati med', 'cjeieij', 12, 'djsu', 'Male', 'Single', 'djsisi', 'approved', 1, '2025-05-22 15:32:06', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747899135/valid_ids/valid_id_1747899135_front_682ed2ff9e7f1.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747899136/valid_ids/valid_id_1747899136_back_682ed30024505.jpg', '', '', NULL, 'pending', '2025-05-24 12:24:21', NULL, NULL, 0, NULL),
	(32, 50, 'Certificate of Indigency', 'Clement Harold Miguel Cabus', '678-b Hinar street Zone Panam village', '123456789012', '123456789012', 'clemb', 21, '12-22-03', 'fuuddu', 'hdid', 12, 'dhdhd', 'Male', 'Single', 'e7eud', 'approved', 1, '2025-05-22 15:32:52', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747899181/valid_ids/valid_id_1747899181_front_682ed32d1ba43.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747899181/valid_ids/valid_id_1747899181_back_682ed32d8870a.jpg', '', '', NULL, 'pending', '2025-05-24 11:46:15', NULL, NULL, 0, NULL),
	(33, 50, 'First Time Job Certificate', 'Clement Harold Miguel Cabus', '678-b Hinar street Zone Panam village', '123456789012', '123456789012', 'uubusin', 21, '12-22-03', 'djdjjd', 'dudhdj', 15, 'jdjdjdid', 'Male', 'Single', 'jcjcjdjd', 'approved', 1, '2025-05-22 15:34:13', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747899265/valid_ids/valid_id_1747899265_front_682ed38111d8b.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747899265/valid_ids/valid_id_1747899265_back_682ed381848cd.jpg', '', '', NULL, 'pending', '2025-05-24 09:39:09', NULL, NULL, 0, NULL),
	(34, 48, 'Barangay Certification', 'David Olerio', '497 Kalaw Zone ISU', '123456789012', '123456789012', 'Davisd', 21, '12-22-03', 'Makati medical center', 'student', 12, 'filipino', 'Male', 'Single', 'scholarship', 'pending', 1, '2025-05-22 16:18:36', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747901933/valid_ids/valid_id_1747901933_front_682eddedb5df6.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747901934/valid_ids/valid_id_1747901934_back_682eddee2608d.jpg', '', '', NULL, 'pending', NULL, NULL, NULL, 0, NULL),
	(35, 48, 'Certificate of Indigency', 'David Olerio', '497 Kalaw Zone ISU', '123456789012', '123456789012', 'clement', 21, '12-22-03', 'Makati medical center', 'student', 14, 'filipino', 'Male', 'Single', 'scholarship', 'pending', 1, '2025-05-22 16:20:20', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747902029/valid_ids/valid_id_1747902029_front_682ede4d8c3ce.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747902030/valid_ids/valid_id_1747902030_back_682ede4e67d2f.jpg', '', '', NULL, 'pending', NULL, NULL, NULL, 0, NULL),
	(36, 48, 'Barangay Certification', 'David Olerio', '497 Kalaw Zone ISU', '123456789012', '123456789012', 'awawd', 21, '12-22-03', 'awdawd', 'dawdad', 12, 'awdawd', 'Male', 'Single', 'dawdawd', 'pending', 1, '2025-05-22 16:32:52', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747902785/valid_ids/valid_id_1747902785_front_682ee14191ca6.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747902786/valid_ids/valid_id_1747902786_back_682ee14234662.jpg', '', '', NULL, 'pending', NULL, NULL, NULL, 0, NULL),
	(37, 48, 'Barangay Clearance', 'David Olerio', '497 Kalaw Zone ISU', '123456789012', '123456789012', 'dawdawd', 21, '12-22-03', 'dawd', 'awdawd', 23, 'awdawd', 'Male', 'Single', 'awdawda', 'pending', 1, '2025-05-22 16:41:33', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747903302/valid_ids/valid_id_1747903302_front_682ee34675f99.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747903303/valid_ids/valid_id_1747903302_back_682ee346e0bfa.jpg', '', '', NULL, 'pending', NULL, NULL, NULL, 0, NULL),
	(38, 47, 'First Time Job Certificate', 'Kat Arina', '123 123 Zone 123', '123456789012', '123456789012', 'kat', 31, '04-01-94', 'awdfgsdf', 'awdawd', 12, 'awddfa', 'Male', 'Single', 'ahfkjhadsf', 'approved', 1, '2025-05-22 16:45:54', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747903563/valid_ids/valid_id_1747903562_front_682ee44aec89d.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747903563/valid_ids/valid_id_1747903563_back_682ee44b587a9.jpg', '', '', NULL, 'pending', '2025-05-24 10:41:54', NULL, NULL, 0, NULL),
	(40, 58, 'Barangay Clearance', 'Lucas TheDig', '123 Kalaw Zone Polar Village', '000123456789', '000123456789', 'asdfas', 24, '10-17-00', 'asdfas', 'asdfasd', 6, 'asdfas', 'Male', 'Single', 'asdfasd', 'approved', 1, '2025-05-24 06:09:30', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748038180/valid_ids/valid_id_1748038180_front_6830f22416330.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748038180/valid_ids/valid_id_1748038180_back_6830f2248c9db.jpg', '', '', NULL, 'pending', '2025-05-24 06:10:08', NULL, NULL, 0, NULL),
	(41, 58, 'Barangay Clearance', 'Lucas TheDig', '123 Kalaw Zone Polar Village', '000123456789', '000123456789', 'fgasdfa', 24, '10-17-00', 'asdfasd', 'asdfasd', 14, 'asdfasdfasd', 'Male', 'Single', 'asdfasdfasd', 'approved', 1, '2025-05-24 07:07:50', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748041680/valid_ids/valid_id_1748041679_front_6830ffcfcbc4e.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748041680/valid_ids/valid_id_1748041680_back_6830ffd053a7d.jpg', '', '', NULL, 'pending', '2025-05-24 07:08:38', NULL, NULL, 0, NULL),
	(42, 58, 'Barangay Clearance', 'Lucas TheDig', '123 Kalaw Zone Polar Village', '000123456789', '000123456789', 'sdfgsad', 24, '10-17-00', 'asdfasd', 'asdfas', 6, 'asdfasd', 'Male', 'Single', 'asdfasd', 'approved', 1, '2025-05-24 07:23:46', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748042636/valid_ids/valid_id_1748042636_front_6831038c3deae.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748042637/valid_ids/valid_id_1748042637_back_6831038d2d537.jpg', '', '', NULL, 'pending', '2025-05-24 07:24:19', NULL, NULL, 0, NULL),
	(43, 59, 'First Time Job Certificate', 'John Doe', '123 Kalaw Zone Polar Village', '000123456789', '000123456789', 'asdfasdf', 8, '05-19-16', 'asdfasd', 'asdfasdfas', 7, 'asdfasd', 'Male', 'Single', 'asdfasdf', 'approved', 1, '2025-05-24 07:25:51', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748042764/valid_ids/valid_id_1748042764_front_6831040ccb8e3.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748042765/valid_ids/valid_id_1748042765_back_6831040d579f9.jpg', '', '', NULL, 'pending', '2025-05-24 07:26:22', NULL, NULL, 0, NULL),
	(44, 58, 'Certificate of Indigency', 'Lucas TheDig', '123 Kalaw Zone Polar Village', '000123456789', '000123456789', 'afasdfa', 24, '10-17-00', 'asdfas', 'asdfasdfa', 7, 'asdfasd', 'Male', 'Single', 'asdfasdfa', 'approved', 1, '2025-05-24 07:49:08', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748044159/valid_ids/valid_id_1748044159_front_6831097fcd45d.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748044160/valid_ids/valid_id_1748044160_back_6831098047fa2.jpg', '', '', NULL, 'pending', '2025-05-24 07:49:44', NULL, NULL, 0, NULL),
	(45, 50, 'Barangay Clearance', 'Clement Harold Miguel Cabus', '678-b Hinar street Zone Panam village', '123456789012', '123456789012', 'aawdawd', 21, '12-22-03', 'awdawd', 'adwadf', 16, 'awdawd', 'Male', 'Single', 'awdawdd', 'approved', 1, '2025-05-24 12:07:08', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748059640/valid_ids/valid_id_1748059640_front_683145f83f61f.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748059641/valid_ids/valid_id_1748059641_back_683145f933d21.jpg', '', '', NULL, 'pending', '2025-05-24 12:21:31', NULL, NULL, 0, NULL),
	(46, 50, 'Barangay Certification', 'Clement Harold Miguel Cabus', '678-b Hinar street Zone Panam village', '123456789012', '123456789012', 'awda', 21, '12-22-03', 'wdawd', 'awda', 14, 'awdawd', 'Male', 'Single', 'awdawd', 'approved', 3, '2025-05-24 12:09:29', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748059781/valid_ids/valid_id_1748059781_front_683146851ca2b.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748059781/valid_ids/valid_id_1748059781_back_68314685bd754.jpg', '', '', NULL, 'pending', '2025-05-24 12:21:49', NULL, NULL, 0, NULL),
	(47, 50, 'Barangay Clearance', 'Clement Harold Miguel Cabus', '678-b Hinar street Zone Panam village', '123456789012', '123456789012', 'dawdaw', 21, '12-22-03', 'awdad', 'rawdawd', 15, 'awdawd', 'Male', 'Single', 'awdawd', 'pending', 2, '2025-05-24 12:12:53', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748059987/valid_ids/valid_id_1748059987_front_683147531de88.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1748059987/valid_ids/valid_id_1748059987_back_68314753c69a7.jpg', '', '', NULL, 'pending', '2025-05-24 12:21:19', NULL, NULL, 0, NULL);

-- Dumping structure for table fvb1sp63uzi8xp6g.document_signatures
CREATE TABLE IF NOT EXISTS `document_signatures` (
  `id` int NOT NULL AUTO_INCREMENT,
  `document_request_id` int NOT NULL,
  `signature_data` text NOT NULL COMMENT 'Original signature data',
  `signature_hash` varchar(64) NOT NULL COMMENT 'SHA256 hash of the signature for faster lookups',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `public_key` text COMMENT 'Public key used for verification',
  `signed_data` text COMMENT 'Original data that was signed',
  `expiry_date` timestamp NULL DEFAULT NULL COMMENT 'When the document signature expires',
  PRIMARY KEY (`id`),
  UNIQUE KEY `signature_hash` (`signature_hash`),
  KEY `signature_hash_2` (`signature_hash`),
  KEY `document_request_id` (`document_request_id`),
  CONSTRAINT `document_signatures_ibfk_1` FOREIGN KEY (`document_request_id`) REFERENCES `document_requests` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.document_signatures: ~16 rows (approximately)
INSERT IGNORE INTO `document_signatures` (`id`, `document_request_id`, `signature_data`, `signature_hash`, `created_at`, `updated_at`, `public_key`, `signed_data`, `expiry_date`) VALUES
	(17, 18, 'IWlxRUF4qPIyMddYKLERCo2iWlvehvlKcSCBRQd3JjqeafPMuP2MBO5ifPGBEGFM3BT1k6PMssyITv1/BYBfHba7jgBuRLS9u8gVD0F11/eZeshO59sLbPjtz+Zsi72QHWE1/jcPebYYhBqZRvCM8nyjlnelhbE3pEJm0z3/22lupuROYzISyycW5qtiNTnRO0WfaXazInItvEYueq/+5dfMFBL45jrzGCqHTitdytzTWULwjgoxGw4xL1vk6jvviU9XKgvil3ctdi3845HBj/+3wCG0o+alYt9XoLzDb6VqMq1i5pfa5O2SC+2ttUSBrnXqMyYyycVq7s7/5tbY7w==', 'c95e1e549cc56372987d9974be2362c0f4eb630a209243f41eac3dcb4cb08684', '2025-05-08 23:44:13', '2025-05-08 23:44:13', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3FhmMkWAa/PO/L+75UqW\r\n+wLFjQBOCeKuK7UWUSNOsasirO1FpEmkgdEAzHoqUVAfgaJPwxICeQJBWrg0Ok+i\r\nJgPtHW8vicxKD9+QvtrgLocotNoxBV6hZfm2ZQ4P9X6UaK7XfaTwfMqoeQrt1jUd\r\nPVFrMvmSy545/OfU5qfqMIq+CBhymEkFEaojcnpP6SfkHKDAhEdT7gcBkl+6C5V2\r\npPWC/KgcwgCKb3MXKJERPNTgZrkLV7yzbmzX0EJlraOEnMF2gyEq7vIeUW5H6GFf\r\nt+6Yl96/8+rBl3diPpi1jbq+0l0XkvdH5NmfIME9q+WrYeGtXBrX7nriSnNGGrXo\r\nDwIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":18,"name":"Clement Harold Miguel Cabus","address":"678-b Hinar street Zone Panam village","birthday":"12-22-03","document_type":"Barangay Certification","issued_on":"2025-05-08 23:44:13","expires_on":"2026-05-08 23:44:13","document_id":"18"}', '2026-05-08 23:44:13'),
	(18, 10, 'uGyAz+EHOkiMJD03ZXtkHfT0hGu5V632swPhuphqVkucY8mYYODDh10DN2ru4lt/bcwL7z5yQLIIXoqy+ifwjBCC5JRiQLgGaqJxSRc7rh93HdyvUrVpzctONyUYz8mydvEBiGp33tu0MzUCa91/SZsUtg3wtbS/jwznNSvqVvldGcqVPZ5ZdbkUzk+I4jELaE2TxrNxnsYNcyrVSXApMlKSZgllOgkfdOWCnB9zRgyYSK0PCf1Bgg1SV2yMVEfbTAkNbrj/tqjdL68GlXzWCWo0ABdnC3gn0jCskEtklB8sBYH2T+PWAXJ1O8XExhHm4JiFG1CpJjo9bhJ6E4bOOg==', '4a43aac5591b77dab3ba49b2470bc4a72f4920e5593b65bf22bd5f8de6dda5f8', '2025-05-08 23:58:04', '2025-05-08 23:58:04', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyvDlgQeAzVgGtWiu3I6k\r\nO8zBogpl72TeY6On7USJytm5jkkSenqRF0QE90hS6zFUamsJ/cFYlrsvlzNZivXa\r\nfPDaLGj39zb5fNjnnRmVrlCq8jHt72OeoLFg6E8owhs74Zj7Z6CFLy3zxhGX6so7\r\nLJpg+iO1ebF34Sfafcyqe0ecZG/6t53XWGjPJOz2KEFiw3PkuP/kEBOVBLUeg12K\r\nuJNnXWNbwKaYuTHZi4+yyVtNX1PjsUBmXWeFuskuRJLmfA640jnkmttRw6gRWtB/\r\nmK17+t0brY8rH8JAOMrNJ5w99wPQyebPrVnzUY2vo6TZZ2WQYHqCY0g36FIasP2I\r\n7QIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":10,"name":"James Padilla","address":"321 Mangga Zone 123","birthday":"01-12-00","document_type":"Barangay Clearance","issued_on":"2025-05-08 23:58:04","expires_on":"2026-05-08 23:58:04","document_id":"10"}', '2026-05-08 23:58:04'),
	(19, 4, 'ZfVNrjkxyywO8T+rM85arh/CrlFgnKYv8FvLUMQlR2kwfR3GLu4AXZT5hdpbxr4HuXSgATEqbxy2UxxXN6eWSNM9vAYBTnJ3wzTgLYgzY01b/xSb39i4NxyiJHdZYdOeKm/6GRVqy7cPPgVzH1Hj29x2qKTf6OQPeMujRcLosd77RsKnCL0F/rCMZBqtL7V1Ma2KtLMg2iUptr90BuGP8TV7Aayugpb2L3/E69pZkXWqKn2XvaDXwwVAjt5CTaiF5gBUwNuWdTDYCvs0deiD2MgPkKfguF+H1sBQzabZdi+PUlGErPmxuyINKqumfAKCnlt4rndJfLv24xjdVGHhMg==', '8801162fe62de5dcb3a0735e18a535fe6b20406c5bab85cfb0a1ce2dcbef2384', '2025-05-09 00:09:34', '2025-05-09 00:09:34', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAo31yKIjR6QAaNa9AEsP6\r\noxo2M8J8ukJGvxN48FujArRWo+GfCZH5g8MATn7u0C5Zi8K/5o2ltL+iDnGjsYK/\r\nYxplN2H/FhkrdXk1xGOMumpoRg19xuloSlOxY24U+ZU3s/SS4nIBxbLIZClyKfzq\r\ncy2NkKzixA+FyjDODQ34uiTxRs/RCJiClDcgSrRATwZeq95i/RX6GRQdhD+W/NY+\r\n2Xicy2pNApatVaX33LWGaAlxVMqGfsEYNemmx6GO+jcc4j5oc4UtftwdUvb+d1Wk\r\nUZUQtiLKnCT3b91XLmQkMOcONjkhTn4/mYW47skr7ph2Oa1Eou2ZHVY7FB+XzNu/\r\nMQIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":4,"name":"David Olerio","address":"497  Street Zone","birthday":"12-22-03","document_type":"Barangay Certification","issued_on":"2025-05-09 00:09:33","expires_on":"2025-08-07 00:09:33","document_id":"4"}', '2025-08-07 00:09:33'),
	(20, 27, 'BfL1xUVbmTQfoGBZKQQNuhbI14TuCCcIXH6ScnFdAohwjlpcYYWuicsuDw9KoL5aUYhBcgqQptwyrQCcZCGI++7s1hNY6ANu/mwiVET2K8WWSHPVhQ64gEqUxrPbRZfp3wKoy5QJ2/h9g9tlVkxrlGR+VSd/b0gCTO5Gxc6S3d6Xra8cRXwXjpMUHGMqGnB0kz1hz2hmyw5bgcwjENworRfiNdBgWbAT9mJJoxzIO/pI5uGB3SkiwaGXQGqeJ6Gcgl3ErRWfBD8q40VpoNeA0FaZKqt7ZtfVAyJnawUXfw3ebdYg0GpyWM4cPRpItAFMKCvFKx3kY7vg8lfr8BYUxg==', '8e78ea0dc755c7ae849143cbb4510a10da288f608eca5a039ac1af4859a716ba', '2025-05-15 13:12:36', '2025-05-15 13:12:36', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArTp6LPE4RQ8+7Y0XXJWB\r\nnJpyz9QRvsE18EtPaJPFgw0REvQYoPXUDwe/WLmahmH/nAGa6uu5XZYA5G62Th2a\r\nf1jqQh5VIO2hYmY6dDXYCYxLjVRjbmE5OI2SPtEUHyGdNaNjiqX5HySrc3As/f+c\r\neNFA0hsT/fnXF0G0chBnEe3IuDkcoNQF+2zUAfPRmCBIgVRje2u9avJjw0+R1IUF\r\nVpMdjtdCt1k9xrHgheG1P8DX/aWj+mBz0z+ygFF3clp+aw9ZKW9lqaM+p6V99xP4\r\nkLOAfJ1DW+tMZ/0k9JaQRroUMw2/H2OYOCppoRMu3cYs56yyXZ0ELZwkrcYAE9Pp\r\nXwIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":27,"name":"Clement Harold Miguel Cabus","address":"678-b Hinar street Zone Panam village","birthday":"12-22-03","document_type":"First Time Job Certificate","issued_on":"2025-05-15 13:12:36","expires_on":"2025-08-13 13:12:36","document_id":"27"}', '2025-08-13 13:12:36'),
	(21, 8, 'Kmzvm7b2bqFVttW6LSoSHek8J4qJokwLBpH6A0o72pQD05LJNLt+e+mSvL0/4Sx45OXC8XxbnqhsTQdvIzcP+Wm02pRhEVtzmz+echQei8OAMNcrh0O4MutGkUqS1nbuIe9yGmLnLZC1kScifJ6N+wMRdkxuNTBmr/udHEHIdDredsabQguW+gIqXYHNLXWT61Rqo6oZJNM5qgUWUxO+mEu5axI+p8PsU+AV0DCDLvk5NA65AlJ6pUORR0JdHQa6i+RiJvIoxxwpYZLh68354QBphVw8/0Elm5nNtC+kd1jY4bnSREO5dG11pRHA0rYFSscxmmDE/Z59bliGG0lJug==', '691c8c41b73bab05149f2bf367c36d2e822f0fc6190a097c6897218721417505', '2025-05-21 23:21:03', '2025-05-21 23:21:03', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwX/eisR5Cl1L845gTKVB\r\nogcryuVkVAJG8oTwGkOWtx6WiTg3hRAW0aE9b8LtO2VUh/fr1YPF477x8JJIf5Ix\r\nptqTaZFFj8+HuyEp43b3IpkbIAfx0O+8FiiOrwuCcW9OM140qKkBxks7nD9+47A1\r\n5AzxTm7KTwiynmWFTzP5okK4haFJhrMZhhj4HnsGFq9aPa2ogX+nottHxw9+djwC\r\npqNbF2cvI5a7dOhzVwViobKE13i5FHilWrxVTVNBK4uCgDbwkWrmz6XzbyQkCToD\r\niaNyWMQ8N0bBb+mCorIlMzSG2HBCJ2cQbtZb4Ux/ROVXOaNTcIZH6KepDdy0sFDl\r\nmwIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":8,"name":"Kat Arina","address":"123  Street Zone","birthday":"04-01-94","document_type":"Certificate of Indigency","issued_on":"2025-05-21 23:21:03","expires_on":"2025-08-19 23:21:03","document_id":"8"}', '2025-08-19 23:21:03'),
	(22, 10, 'BkueMlFnngredwxEDEBUvm1Z6Akaj8kIJ30ajaQk8A4CaSA8aoGLhZDMBfN9NTFT2gmqVrohK0BBWEyJouaPaF0zHZA5+JjidIMIlC/KCNOflQ7C7qojwqzV6R567VlM8BEdtm1CzpjE7ZHAW+VVV17d4rlcSU6/Q+P7enRO1VqXOXIXr9ko+y4Cfe24VwQjL3aqgo0dm4janvJ4Vh9LKKOceAV7Bp2dqjRgCgibDXJbKl4Zo7YbltYgEu4nG50zAUek5Hn/Y8w6k12D0+Zd2pyCCy6Nt0MQ1JRFEBM3FFmfHz35V39kWK4BESYdmokhfumix0VaPerd9W/pHFRxaQ==', '08f8d01ac3caff9723d427af2a74faf74ef984018043e7d168f6395bcdb04c7d', '2025-05-21 23:21:06', '2025-05-21 23:21:06', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmZKMx8ZKqfK84lVTLJIK\r\ndDfgQOWnYBrihiF5EGvmtoNUSF2mflazBFVOg5Y41yOqe+pHoY/lSyphZSdfyHQF\r\nKAF744QZgEinCc2ZqQDxLMz1xSYUXa7yfz7QBRVky1cxIgsKDu8Fp39oM9HIhzmH\r\nsq/4UkrmQP+yUb4zfHxDyG+8aakLpOEipe9jjhJf2gmH0ifOI+x0LSQlBncQ+qAD\r\nQLwI9UpqVJNE54e3Qcs6ZsqBHhS+2ULJf5+xQKbTi1bAm4a/8IceiaQ6qtHzIsWb\r\nV7K7fm96bVf+yKmXOT3bUk8z0BR+tsG6ewm+nytd4w3/K+huJDhId28e0e8fEAiK\r\nBQIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":10,"name":"James Padilla","address":"321 Mangga Zone 123","birthday":"01-12-00","document_type":"Barangay Clearance","issued_on":"2025-05-21 23:21:06","expires_on":"2025-08-19 23:21:06","document_id":"10"}', '2025-08-19 23:21:06'),
	(23, 18, 'cjXxrAA5esA2+pCSIcekWK8q2AFVHfD2ap+m6TbAiqzY2QEWio3jpcY+HiKk1emj1pI7xSErIeYRVfVyW8MUKSfsBz+wNDXA7DXG5JA/FcUZEGY51Ao4Vag4ochYoc3Y4zArwsF69l9KJ4CdF/VKwSO7KDWcaTBjm5VODg5Q1vpLYZklhnz5p2agxjV3jEN8it4whlx/Wg87uGgDNPCjfgiOs8OuRXBHZcG6WfMWguSGxQSyHkFSInlmDpGiZLpGgVQyKX3WAzkdw9yIR9Ck+k60XyXkW6947LGgOzsSJ06mk/HCoM8ftSkee3HDIuVebEzQYX7jijqArF5ijOmE5g==', 'a32d86362c9a0ac35af9bfa28320a68054231b7887294d6eb99f6929a455b910', '2025-05-21 23:21:08', '2025-05-21 23:21:08', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAw+w/F+zvchkoW/MOhf8x\r\nC4FTHf0zB14LvTFd2/QUObUM7/hMj7rrACn8f7Mk1VcZChc2UHm5ErV6qJeFN6lP\r\nCjF5ORPWP6LQC147xKmkkAa8M4Svmwd3tMVZUX6RlIdpooVOKaLvIBtnpTfhC4Ew\r\nsqX7kn20qtL5DhHAkv/eEhWECwJrlABf2Xp//FF5Fs2zuYs1tqh/cdcJWZJq5afD\r\nlhoLtr5j+yt5rHieiigf26zJBrY5e1bYedGXFJILjeX1sD844zDCT4bPJPBaVI/I\r\nrJQBtJUwx3kv0jHMHjHgriT/twYJLM+Ga9grCP6mVjcrqsEOI3y0QWZXk2BjgIMY\r\nxwIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":18,"name":"Clement Harold Miguel Cabus","address":"678-b Hinar street Zone Panam village","birthday":"12-22-03","document_type":"Barangay Certification","issued_on":"2025-05-21 23:21:08","expires_on":"2025-08-19 23:21:08","document_id":"18"}', '2025-08-19 23:21:08'),
	(25, 28, 'NtYCqeOz+PJyUKjyBDFxscXrW3iZKFshns+yBc6/9Iewr2LzroB75hJJdqA04/UKhrkPfvhP4gWiPcu4E7TrM+oOztPRY5/pmb5w41xtmnETxgkdzcwwmMeV7SNgf/80sdhnat1JRzmHkamJ3klddEyB3JzaLzlQThRCR5r+XaKRIFO2YovdHnrwe4GBZ+7M2OP1ukXbu+uCBvVjUAS/SkrO/x888K4jd1ItIkTGS7WEQNthHKsvmwnFUvtvzTrILlvpg429FPgSSVToVXr8zIIeTjz/vbwgL2HJRJTntZj7J1pDto5VKbnVIUKZVVGMwO9Jq2msN07Lyp8vt4pkXg==', '39079ae72c3d5dcac35d09bde43ab16d1b4f860b0a48b99f38684d94a3c2c317', '2025-05-22 14:04:49', '2025-05-22 14:04:49', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA8dFV1f4yBgqX++8ObNxL\r\n7rfjuVU85uTOkF0VC1OIIPZKpbXztKieGLzOFdNbq3tBIZRdGwcqBjpq8D8K0rok\r\n91PabWEFncqmd9fMVcqzy7amY+ar6PxBJSutuMaIY4a8IaGYGfTBxNbh+BFIB4W8\r\nvWpSCyY1peV2aSngJPWYHJCLOUPntdlCmlny/PZwH4wEsLPZzZ0N+xCi+moVs8bL\r\nIq8pG8zUTzUxgFGldnlTQFxbp5U+wRBfyzSQc4ShEZh+o16bWeLOjJBaKE1vZi6K\r\nS6xdZQvpOIyakDC0OJK0CuZtKa93DKlrD2m/74MtNpzV/OHvnAPPOVaF9sSZwmQW\r\njwIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":28,"name":"mark mark","address":"34 mangga Zone 5","birthday":"05-22-03","document_type":"Barangay Clearance","issued_on":"2025-05-22 14:04:49","expires_on":"2025-08-20 14:04:49","document_id":"28"}', '2025-08-20 14:04:49'),
	(26, 30, 'AATiz80N61xX0jB593evtJrfa4+tIbnVaKBMmZ66hGkgI9ji/xYKgMnUcS8ipxr+Yyebj2HqjAJjHz1zBvNl+qBKoipQV/qa/W6mZXhcA6AKZJZipNiqqlE6cuXjUQX3CclQwO4H6RacI5pghNwrB7hj+5rr+Qih64XMEaVh0GlXpKciJLxVlksW3mkdKy3tLWfkww1NMPgBCCa/fXvZPl0gZyO9pOT6dm9cEu1lgIEm2bylVvs84fTRuAT25jFsX8Dl1jzgjepqneHhH6k9MtwFpdKthpQzX3VEwzkZsjITOQ5zZrhWDfW/OKAf0VWjMDJMFL7HSs8Gnb28qdrgvA==', 'e0119bbfa8b9f9ea390ee86b5d6cab89eb9fe67aa979bec7765735dd523081b1', '2025-05-22 15:10:19', '2025-05-22 15:10:19', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsIJJbJ55DdHsilk4uREa\r\n1m/95sxxmgPXBTauttWrOI7N/gJqZ4HUde2Ah1D6S8w8W4FULJ+UpJTbssmKP+Nb\r\nbT/gW166uLLwSA0cb3WC2e6jXNWhQuUbLawUCHznkXQmeihXbFU3PssVMo6jR/E6\r\nAPt3ed2ua1Diqcrhkno+kBH6rDEEi4K4dmG3HgVl8JQ4rmyJH+svursjc0sXSYV6\r\n7fm2XG0/cKNKtnrJCDoClyQBxuYrf5qO2EylYWO3GSgD34ekMYSuiplUze6Refep\r\nCJb/kM6LtsRVjanzeIh2YIRnFo/lYObOGe57SsQ34PV0+YfTPmO7q32SFbZaHrSk\r\nYwIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":30,"name":"Clement Harold Miguel Cabus","address":"678-b Hinar street Zone Panam village","birthday":"12-22-03","document_type":"Cedula","issued_on":"2025-05-22 15:10:19","expires_on":"2025-08-20 15:10:19","document_id":"30"}', '2025-08-20 15:10:19'),
	(27, 31, 'l/nUTY4CcHh8Ebi252ppd6k2132tgMdN3ra0weMgsm6RH0JXMhNuyjxLDYPDwZ/Y7bcS5FBnjPGHYJAbOfk7L9unKtW79xd3c9ZoMV2ANDylQjfsEEmUWejiTxmvlR9wvp58qZqPBit+4PRip0oQAPR1gFErZZsvXjQe9SQqh1OHhnxmzskswO+EHOTqPh5Qfe8niYmY1DIJYdpL/QYKsna5z2SMpsRKyyCKI9UFW2ly1DffkK3cnfg+LqjkNcpAUGtQU1XrVNnv3OI1qjcTAAIUz1GPL5WdPBWGn+7ZAbXWWUf9VcTpALnJJaEmJ3OywrZT9UX872iIg4p0N2rBsA==', 'aaa867278317cfb0f2728d4562ca86bae7f2ed7657453e27f4ead563f3a4d4f6', '2025-05-22 17:06:21', '2025-05-22 17:06:21', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtU6YQF0RmMGVy2dPdmFK\r\nGK1twg8vBKRFYv8wN7wH3t5z+RYOZ6bgfdXIwUjbTeUCQSZXEWK0L7o8vV1PBelf\r\ntU3yBlt3/RXxCmsY3lKJYRUV9f7rcBjeqRyGHYmiMl1OkRt9yB5NW/Axw1y8lSZx\r\nhEFOecKVyZSoIgQHraFT0TwqYeiSkGl5hQ7t36eXehkvs/kpWW7SZYQVxIQGmx3J\r\n7YME+Z7G5lV/C0hXgU/3r0MZpaLZ5fH46t4e5f2RoId7w96v7+Q1iWLybLO2X0vc\r\nDSP9MF2Sz2HRZdUw1E5WAJSFPYZGG8ENLBy/ge2PGiqscytg3mZtbY8YI39Mpi5J\r\nxwIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":31,"name":"Clement Harold Miguel Cabus","address":"678-b Hinar street Zone Panam village","birthday":"12-22-03","document_type":"Barangay Clearance","issued_on":"2025-05-22 17:06:21","expires_on":"2025-08-20 17:06:21","document_id":"31"}', '2025-08-20 17:06:21'),
	(28, 31, 'Wbwz9+2JFY+7FRmmyHMhb9a284yWzHxQctcd2ku8rusWVeM8eVYFpaQ9Z/H8dePs+k5pbgbuGTPqk88mfUTX3uUZqHRPG/+vAXQuh91Se8JTf2Ys73JohiumiB7UaMB/rvVeQbpWBO7EBG+CQ4wxKnK0z1klKPr5pXfNbtcDzL2WzB84qXjhb52Ch6yhWcNichnudrBznn/97LvcwAs+eMVTMHmGwBhSUjbq4GOT0yG5+LwTOd59G3WtFhmmdoiyk2q8YAqyjjeQjSLre1kKW3JMnDX4cgLTjWvi9wNUCOPIbuo+KZ4ipsbGXdQ4NE1TDFM+T2A5u58Z+fVY+prBDQ==', '92ef1d2cbbfbb33b5e6f55a4a7f1b9b93fc356df1383c9f334c4b87d9281fa17', '2025-05-22 17:09:18', '2025-05-22 17:09:18', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjRg0jKFQInrnNFerE2XP\r\n9lLktRKdN069V7RU7Oyi1rJcm3IBWF+PvwMCMrJ9UwBKv3oCL7SNNzhQTKB7yxG1\r\n7w1XEC40OVEZYuR4Qka1LaZ3+B1eqx9nbSK1VuYVvtZeFCCnO60lr5kfIryZG/BU\r\nyvUEPfu+5KVjhSXNrix3vurOTJaq4/wPDaFacLesqsnwB/zaVRbVs9Xg4pIozOwp\r\nMgNsTFTkP9UnFk96mZtaI5Y8ylj0lJyybXWdJi5kylOtAorEsmF2Jd7XTN5lWq4Z\r\nOo/2qLpvY5GT1UhYZ1xrBZQMrqoeE/aBSEpgnXmpoB2AS1zc7PcKEXVVZpGO6Pv9\r\nrwIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":31,"name":"Clement Harold Miguel Cabus","address":"678-b Hinar street Zone Panam village","birthday":"12-22-03","document_type":"Barangay Clearance","issued_on":"2025-05-22 17:09:18","expires_on":"2025-08-20 17:09:18","document_id":"31"}', '2025-08-20 17:09:18'),
	(29, 31, 'ElDL7/fZYCn5we5So6cirdPPcrO2NxIgLkiyDAyFzReJpRr5Vba44VUb51RWCMGzElRVYiNLhrF7gH90A9TZwVn2QrO9swuxcEhZq6+tzF0OUwSBpJgOXGf2BHEakRvBrYGrN6Rk7lXZv049d4dx0+WmExqLbkd/RpiRfUcuge0cxCJjfI/aQypRvAAdT/JFk2qmMSj1P67LMJhTtxqmGOkgN6gJTjx+JAX0/iKpw+ilWvL5GtWBF8x5W9VkyS5pyHHFnGq++fpPSF/VPfe87M9ZDD+8u+tGuzJ0rf0S2G5lskl2nk8maSUYO/dBHa0ftFvDPj7BJR0U8cI+85ka3Q==', '41c9c24c69ff6d5225c5dcbe7b395383fe092d897ebfdd71f3a0fe0edca64bf7', '2025-05-22 17:09:58', '2025-05-22 17:09:58', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAs7zUuNpUQl5hGAjIcTnd\r\n7+H9VBam0a+6KAxpW1TsyHtmI6E9R6xMwPtDS2a0WOyryPLmNrrUTCIP7z4vSe3B\r\nQtsWI/DwFAEPYqO4fi3+Lrhyx/IXRW0D+uJ7dk/87KokKUvLhbY8arfjqu+DI0nB\r\ntqTnUiHWfrq9IbXrHzRG0WPzPAUET0LtgCOmtWZrCf9YvCeKnWQ4LJ/NhbLotVNv\r\naxVZmdd8IZQtwJdNuIKEmLwZ0TDweLjzeVX7qEtWZddO05uyRTEQpA2ssrod6S2Y\r\ncBeunT8djgoANotMIkPnO4NdUZJCHC0Wv6idkfQK3HPpaz0oOh1nG0bEqWvJKZBt\r\nawIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":31,"name":"Clement Harold Miguel Cabus","address":"678-b Hinar street Zone Panam village","birthday":"12-22-03","document_type":"Barangay Clearance","issued_on":"2025-05-22 17:09:58","expires_on":"2025-08-20 17:09:58","document_id":"31"}', '2025-08-20 17:09:58'),
	(30, 29, 'o6FLB2ELippjB3z+ZSwkKN23EJhgAxYQzMzYJ2UOfOoaX8FUvK2HxzQwXRQ+W/LmDuIKq9CueJJaxzw/repQYNVgl4OzBoSY/hkz3K6xUZ+V5iNLm7FLLZqI7aIBAAVHytZpLwvptDlF5P+Z4Ce8flNgJUhw5E5n8Y0ArlizK6iFBAcwwkfPMBFV4H7TyqbpVzOQ+dNdpbJSElKINp7VK2LuM55mwrbfxyyK+/l5bMhd6evw6RN6BPvBtjyIgUgvwzCIJ+SBqUvU8e+p8CMlNq9s/e0tDtGqYwLxEppQbxi8DAOLhAsD4skOvP79i1m61IKZsPsKYRkhIrTlwdncQQ==', 'ae6f18a2663617ac7b30a448278701109bce1ec251746bba025d51d2d0af8094', '2025-05-22 17:10:24', '2025-05-22 17:10:24', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyFAn1oHuV7Y7p5T6zC2l\r\nRtyUkV1O+FMIcOPCXqbxeq8KvqpB4rj/v+o8zOZnD4zUSMnMd2+7ZLLy5f99UGht\r\nrzVVuUemfwEKd7fiuKtPw69ieSoW4v/LbwgLN1/0+xXXH+N0TyZ4zvJ2qBWAoUzY\r\nFOudWa9d3JRwjEUkh4YswBvWg3tlb0ldUzxGQBS2QbricEVftv5ZpGyypx+1RgOy\r\nKXxAWwMQsPVaF3QWb2roNNNBa5TSPGfhcB9LEARCAD+widRCUWDKFUObQ0DmBbap\r\nWJib7jE5ZsaahWRyp954m0IX1gcH/ndwM8J2l32ecAyE8MLkSvJJ2qYlB/o34suJ\r\nbQIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":29,"name":"mark mark","address":"34 mangga Zone 5","birthday":"05-22-03","document_type":"Barangay Clearance","issued_on":"2025-05-22 17:10:24","expires_on":"2025-08-20 17:10:24","document_id":"29"}', '2025-08-20 17:10:24'),
	(31, 29, 'GjCiovShHkCsgwMi3UVbSpTduMbKzCXgoBGbeW7kgcmBu0DtyeAmLcJEkXhsd71F7WWETxWodrcJ9d9z+JkmDLRWZqFRqg8IQlMx3Bwueo754x/NQQY2ogFHMmV8qSNqoM4onw0iDR1uZ2uCbk0+1Br9Q1oAX1vv+5of5qk4XWJyY/GS2kLNsrB6yEgIfvO8VqWeLlAJSa+7s26APaJJkuu9JETDdKJOESzK3nioXpOUwE7j4VjA9++iEFOB3JCoVjxpc+d0CJ6Q/dKHBs2sYi+2LFdEVErexRIkwfL7fUNxUEE635LsM+xMoZsAIedP+2EbTzgQa64ZNQQwGowutg==', 'a65eeab1dcf73af30c81765ac6a6d8337d256b62d31b87207eb075beb14318c6', '2025-05-22 17:13:55', '2025-05-22 17:13:55', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAygpiaRTGBiN11hjFmCui\r\nyX4cVGhxwchueW0hoELmlFLhYKz/Fp9B4xzCwYXKJfmO3MdKBKmBF1m5+fSzqd1B\r\nT50fRD1kpz5mUAmya5lZdMTIsPe4JXM/M9wWvc/3N3KxoWnLJxdYzUMEFXTFCU1P\r\nWfJ/fXCSGGIW0xdK2tXmjO6mndax4o+jCLgxP6rUEpT3B2N+ejnbGFZfeqm4f6E1\r\n/jkVlDlGjLuR0BlG5r6JRvGkGEn6P326JM2Sqx3Nuehav3liSPZqEnKmGoxYDjWP\r\n5eH4iQ//c+N1rmwPjFSH1QQQhKfHy1Nglg28XyeEFAuTHnunLzjX/To+Ch7EqRvx\r\nQwIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":29,"name":"mark mark","address":"34 mangga Zone 5","birthday":"05-22-03","document_type":"Barangay Clearance","issued_on":"2025-05-22 17:13:55","expires_on":"2025-08-20 17:13:55","document_id":"29"}', '2025-08-20 17:13:55'),
	(32, 37, 'ctK8n970UHIwX/rquozRynX9xjBc06Ad+FvswemNTB6mUV69sQySqVp47hGgXSiJeRGJ1se9ilHBvjCNTQ7lZyo9jg8yx4/mZHDBKEFS/8Grko4/MsbjaYbpOr+vhlpfvE9fyp9nrhc0AYqzwBU+1ez+NOSL6j5il5LBTSiIhJVPaaqsHRsxxDIN/b/E74RxV1CjcskaWj+SejxVoFejaECMEQ44Xcgtxv05jv6O4ACIB4MVUNCoY1r+sSwLy0AFOZ+SCZQqh2vlriiT224gyEYsJkq9rbIPKgTO5tOkCvlqmW/p5TdJB0bvNF1rIIiTSfWq8eUZaMpOZXlqcyjm1Q==', 'fa7a09b3ce5f88375aab3714a80de09c57e087ae3f8897813e43b07198cf331c', '2025-05-22 17:14:17', '2025-05-22 17:14:17', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlf9R0DUXePnEKUimIWFm\r\nEb5hVt5KKTGi9lNUJ1++jRs9Tn6QzPjlm8x1EPJ9EFrqSXsqyuxlD5nM6tmAwZJT\r\nxAYHDdE8lXgHU4d8yHDSneZhM75yJwHA+vgh0Wr3ncIrfvjKLZ3sr27l1eFDeHlp\r\nJ7GO5W9R/yYCWxL+8ArnmzkkC9ifajY2c12sD8fRTg7zq/yLx+5j02/AzVHzZ/ub\r\ncnjEvoXtL4JVwA+d3FY63AY5Rc6DKZrMUF7rToYdgEWAvPno4xYMjIT4J9CEPpRc\r\nKk4vwt7MQmoto7C81swc46ltq5MhKG8INl6M1YBT2GlJtYpAQw1BWBlvXIEr1x9G\r\nXwIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":37,"name":"David Olerio","address":"497 Kalaw Zone ISU","birthday":"12-22-03","document_type":"Barangay Clearance","issued_on":"2025-05-22 17:14:17","expires_on":"2025-08-20 17:14:17","document_id":"37"}', '2025-08-20 17:14:17'),
	(33, 33, 'hC4hH/pEz4dD0GCD/Kxms+PTb1G5MwGpHR9/iI/Z8uaw3pZRCriHgap2MFFqrA2X43B8c0EjCpoOin3kAZOOELisX8RyxLRZa7Tge8V8XM9iye9UbbLLttCeecx/JoB4Hcp4p3OD3wr2gHR0HA/QRWUF7dFf+fiwYl7IXgbFmxvGxYiQMG8utHcysrzi7I88D6Ly0eYIwfRYlQkCCaEgD6UypxqYODnZ6mea8VmFEQ1h7jNCWcRDO88QjmWIBle3gynVe5uc8F//KYdPZPsljUa7+C/xYUqONzQRJ+hu0xct06BJqEb44rC8P/5v3wU089MPea+/GgGLsM8FbQJNuA==', '6a68166f1bde77afd0837ddf1a595cea7f61f74fcc0820e7dd3b6df311d610d8', '2025-05-24 09:38:53', '2025-05-24 09:38:53', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoWrlUk3g92Cp2+T60vrT\r\n+JEgAzB3lDfxdT49YU4Hz11mg6MNUKg0J6P7dXDvNYRJSWDVMPsOZiy8T4weMfOE\r\ne9DKW8TJEJ+RAgh8bdo9dbihVN2bTwYIJf5FQbochez5jr/3vCBVjxPbXCcaplNy\r\nnzXBe16EeWNV6DhmfSyniHKRK6Aqh3DQqoYtqZeIlzH2gDaNCcsX62hHYUvl+Sfz\r\nt8mt1HH+CqmqBUtF+/WIDUQ4cDJe5fqU97aU8TBobjxn+uEqSah8SP44iQiskvlz\r\nHNoGxOMXQLq4l9yvMxbLPpFBEzk7ufkG0Bltns/3Qo8lrsKA3AkIcLOoMjcoS1iH\r\nQQIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":33,"name":"Clement Harold Miguel Cabus","address":"678-b Hinar street Zone Panam village","birthday":"12-22-03","document_type":"First Time Job Certificate","issued_on":"2025-05-24 09:38:53","expires_on":"2025-08-22 09:38:53","document_id":"33"}', '2025-08-22 09:38:53');

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
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `archived_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_status` (`status`),
  KEY `idx_archived` (`archived`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.incident_reports: ~23 rows (approximately)
INSERT IGNORE INTO `incident_reports` (`id`, `name`, `title`, `description`, `incident_picture`, `incident_video`, `date_submitted`, `status`, `created_at`, `updated_at`, `resolved_at`, `archived`, `archived_at`) VALUES
	(1, 'David Olerio', 'Theft', 'GRAND THEFT AUTO BRO', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744343818\\/incident_reports\\/incident_1744343817_06548afc7da14065.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744343818\\/incident_reports\\/incident_1744343818_4f0fedd06433bcec.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744343818\\/incident_reports\\/incident_1744343818_6d68a05539463769.jpg"]', NULL, '2025-04-11 11:56:57', 'resolved', '2025-04-11 03:56:59', '2025-04-11 12:18:01', '2025-04-11 12:18:01', 0, NULL),
	(2, 'David Olerio', 'Theft', 'nanakawan po kami dito sa kalaw 497a', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744381579\\/incident_reports\\/incident_1744381579_b7b8c16eedfbf5d7.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744381580\\/incident_reports\\/incident_1744381580_546d4d998df21012.jpg"]', NULL, '2025-04-11 22:26:19', 'resolved', '2025-04-11 14:26:20', '2025-04-12 00:09:42', '2025-04-12 00:09:42', 0, NULL),
	(3, 'David Olerio', 'Accident', 'hello', '[]', NULL, '2025-04-12 00:53:42', 'resolved', '2025-04-11 16:53:42', '2025-04-12 00:57:43', '2025-04-12 00:57:43', 0, NULL),
	(4, 'David Olerio', 'Theft', 'dwadawd', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744469149\\/incident_reports\\/incident_1744469148_be656a3b29d5f488.jpg"]', NULL, '2025-04-12 22:45:48', 'pending', '2025-04-12 14:45:49', '2025-04-12 14:45:49', NULL, 0, NULL),
	(7, 'David Olerio', 'Accident', 'dixie normous.... they got my ass', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744472221/incident_videos/incident_video_1744472218_3nc9oadr.mp4', '2025-04-12 23:37:02', 'pending', '2025-04-12 15:37:02', '2025-04-12 15:37:02', NULL, 0, NULL),
	(8, 'David Olerio', 'Accident', 'dixie normous they got me', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744472298\\/incident_reports\\/incident_1744472298_966d3e2f879c17af.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744472297/incident_videos/incident_video_1744472297_ywx1kna3.mp4', '2025-04-12 23:38:18', 'resolved', '2025-04-12 15:38:19', '2025-04-13 00:51:23', '2025-04-13 00:51:23', 0, NULL),
	(9, 'David Olerio', 'Accident', 'justinecase', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744472919/incident_videos/incident_video_1744472906_qcp1nrmk.mp4', '2025-04-12 23:48:41', 'pending', '2025-04-12 15:48:41', '2025-04-12 15:48:41', NULL, 0, NULL),
	(10, 'David Olerio', 'Accident', 'djdjj', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744521168\\/incident_reports\\/incident_1744521168_a1b978bcd9be5054.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744521165/incident_videos/incident_video_1744521151_54j635m9.mp4', '2025-04-13 13:12:48', 'pending', '2025-04-13 05:12:48', '2025-04-13 05:12:48', NULL, 0, NULL),
	(11, 'David Olerio', 'Accident', 'ryru', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744553256/incident_videos/incident_video_1744553252_m7jwnshv.mp4', '2025-04-13 22:07:38', 'resolved', '2025-04-13 14:07:38', '2025-04-13 22:17:31', '2025-04-13 22:17:31', 0, NULL),
	(12, 'David Olerio', 'Accident', 'one rhinonpill no headache please', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744553782\\/incident_reports\\/incident_1744553782_791e928798bbabd9.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744553783\\/incident_reports\\/incident_1744553783_3db8b7930c1e7020.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744553783\\/incident_reports\\/incident_1744553783_5ab37f147eeed286.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744553778/incident_videos/incident_video_1744553769_dpsq2l9i.mp4', '2025-04-13 22:16:22', 'pending', '2025-04-13 14:16:24', '2025-04-13 14:16:24', NULL, 0, NULL),
	(13, 'David Olerio', 'Other', 'hellppppp', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744595462\\/incident_reports\\/incident_1744595462_db1122292a421b23.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744595458/incident_videos/incident_video_1744595445_xir6hyvn.mp4', '2025-04-14 09:51:02', 'resolved', '2025-04-14 01:51:02', '2025-05-25 12:38:34', '2025-05-25 12:38:34', 0, NULL),
	(14, 'David Olerio', 'Accident', 'heieiw', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744595508/incident_videos/incident_video_1744595487_87zrb0ts.mp4', '2025-04-14 09:51:55', 'pending', '2025-04-14 01:51:55', '2025-04-14 01:51:55', NULL, 0, NULL),
	(15, 'David Olerio', 'Accident', 'test', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744859699/incident_videos/incident_video_1744859688_c3736utu.mp4', '2025-04-17 11:15:01', 'resolved', '2025-04-17 03:15:01', '2025-04-26 11:10:02', '2025-04-26 11:10:02', 0, NULL),
	(16, 'David Olerio', 'Accident', 'bruh', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744862396/incident_videos/incident_video_1744862384_te5e7zgs.mp4', '2025-04-17 12:00:00', 'resolved', '2025-04-17 04:00:00', '2025-04-17 15:24:14', '2025-04-17 15:24:14', 0, NULL),
	(17, 'Harry Houdini', 'Fire', 'sunoggg', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1746025459\\/incident_reports\\/incident_1746025459_384125e77b0280c6.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1746025454/incident_videos/incident_video_1746025448_fc69i55c.mp4', '2025-04-30 23:04:19', 'pending', '2025-04-30 15:04:20', '2025-04-30 15:04:20', NULL, 0, NULL),
	(18, 'Harry Houdini', 'Accident', 'inangkas ko si miguel, binigyan kami ticket bawal daw nutshell aray koooooo', '[]', NULL, '2025-04-30 23:32:26', 'pending', '2025-04-30 15:32:26', '2025-04-30 15:32:26', NULL, 0, NULL),
	(19, 'Clement Harold Miguel Cabus', 'Accident', 'awdawd', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1746028036\\/incident_reports\\/incident_1746028036_d327926708d75322.jpg"]', NULL, '2025-04-30 23:47:16', 'resolved', '2025-04-30 15:47:16', '2025-05-25 12:38:56', '2025-05-25 12:38:56', 0, NULL),
	(20, 'Harry Houdini', 'Accident', 'ugug', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1746028139/incident_videos/incident_video_1746028134_gpng3t67.mp4', '2025-04-30 23:49:01', 'pending', '2025-04-30 15:49:01', '2025-04-30 15:49:01', NULL, 0, NULL),
	(21, 'Crazy Nigga', 'Injury', 'inatake ss puso', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1746111958\\/incident_reports\\/incident_1746111958_297ebbd044ec2793.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1746111956/incident_videos/incident_video_1746111951_z8uxd3z2.mp4', '2025-05-01 23:05:58', 'resolved', '2025-05-01 15:05:59', '2025-05-01 23:06:24', '2025-05-01 23:06:24', 0, NULL),
	(22, 'James Padilla', 'Accident', 'May aksidente sa mangga st.', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1746166226\\/incident_reports\\/incident_1746166226_e637d0f1222596f1.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1746166224/incident_videos/incident_video_1746166220_ma6ugk1s.mp4', '2025-05-02 14:10:26', 'resolved', '2025-05-02 06:10:27', '2025-05-03 01:27:52', '2025-05-03 01:27:52', 0, NULL),
	(23, 'Clement Harold Miguel Cabus', 'Theft', 'theft at kalaw street', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1747285017\\/incident_reports\\/incident_1747285017_214a0746a779f020.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1747285018\\/incident_reports\\/incident_1747285018_3697c8eebe82ac8a.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1747285019\\/incident_reports\\/incident_1747285018_5b4961a981e01900.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1747285014/incident_videos/incident_video_1747285007_oi8objnz.mp4', '2025-05-15 12:56:57', 'resolved', '2025-05-15 04:56:59', '2025-05-24 09:40:53', '2025-05-24 09:40:53', 0, NULL),
	(24, 'mark mark', 'Accident', 'hsjsjaakk', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1747875134\\/incident_reports\\/incident_1747875133_1fae779f7944611f.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1747875131/incident_videos/incident_video_1747875126_c5rd2bzz.mp4', '2025-05-22 08:52:13', 'pending', '2025-05-22 00:52:14', '2025-05-22 00:52:14', NULL, 0, NULL),
	(25, 'mark mark', 'Accident', 'dxxfg', '[]', NULL, '2025-05-22 13:22:17', 'resolved', '2025-05-22 05:22:17', '2025-05-22 13:41:41', '2025-05-22 13:41:41', 0, NULL),
	(26, 'Clement Harold Miguel Cabus', 'Theft', 'notif test', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1748148145\\/incident_reports\\/incident_1748148145_4429e49a2b18f303.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1748148141/incident_videos/incident_video_1748148138_70q4imbf.mp4', '2025-05-25 12:42:25', 'resolved', '2025-05-25 04:42:26', '2025-05-25 13:51:29', '2025-05-25 13:51:29', 0, NULL),
	(27, 'Clement Harold Miguel Cabus', 'Accident', 'notif test 2', '[]', NULL, '2025-05-25 12:43:04', 'resolved', '2025-05-25 04:43:04', '2025-05-25 13:57:27', '2025-05-25 13:57:27', 0, NULL),
	(28, 'Clement Harold Miguel Cabus', 'Accident', 't7g', '[]', NULL, '2025-05-25 14:10:01', 'resolved', '2025-05-25 06:10:01', '2025-05-25 14:10:35', '2025-05-25 14:10:35', 0, NULL),
	(29, 'Clement Harold Miguel Cabus', 'Accident', 'fxydy', '[]', NULL, '2025-05-25 14:10:07', 'pending', '2025-05-25 06:10:07', '2025-05-25 06:10:07', NULL, 0, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.messages: ~44 rows (approximately)
INSERT IGNORE INTO `messages` (`id`, `sender_id`, `admin_id`, `message`, `timestamp`, `is_admin`) VALUES
	(2, 47, 1, 'sup', '2025-04-20 15:09:53', 1),
	(3, 47, 1, 'hello kat', '2025-04-20 15:12:55', 1),
	(4, 47, 1, 'sup', '2025-04-20 15:25:21', 1),
	(5, 48, NULL, 'hj', '2025-04-20 07:35:56', 0),
	(6, 48, 1, 'hello', '2025-04-20 15:36:10', 1),
	(7, 47, NULL, 'sup', '2025-04-20 07:37:21', 0),
	(8, 47, NULL, 'haha', '2025-04-20 07:37:34', 0),
	(9, 47, NULL, 'LOL', '2025-04-20 07:37:39', 0),
	(10, 47, NULL, 'sup', '2025-04-21 04:14:56', 0),
	(11, 51, NULL, '.', '2025-04-25 06:14:49', 0),
	(12, 51, NULL, 'sasdf', '2025-04-25 06:26:52', 0),
	(13, 52, NULL, 'Hello', '2025-04-25 06:38:12', 0),
	(14, 52, 3, 'hello', '2025-04-25 14:39:12', 1),
	(15, 52, NULL, 'hello?', '2025-04-25 06:45:30', 0),
	(16, 52, NULL, 'asdfas', '2025-04-25 06:50:30', 0),
	(17, 52, NULL, 'asdfas', '2025-04-25 06:52:44', 0),
	(18, 52, NULL, 'hello', '2025-04-25 06:53:04', 0),
	(19, 52, 3, 'asdfasdfa', '2025-04-25 14:53:38', 1),
	(20, 52, NULL, 'asdfaaa', '2025-04-25 06:59:00', 0),
	(21, 48, 1, 'test', '2025-04-26 20:25:55', 1),
	(22, 48, NULL, 'test', '2025-04-26 12:26:04', 0),
	(23, 48, NULL, 'kj', '2025-04-26 12:27:23', 0),
	(24, 48, 1, 'khgjh', '2025-04-26 20:27:41', 1),
	(25, 50, NULL, 'wdawd', '2025-04-26 21:46:45', 0),
	(26, 53, 1, 'HELLO JOSH', '2025-04-29 00:33:46', 1),
	(27, 50, NULL, 'xcv', '2025-04-30 16:19:37', 0),
	(28, 50, NULL, 's', '2025-04-30 17:17:21', 0),
	(29, 55, NULL, 'sup', '2025-04-30 23:02:05', 0),
	(30, 55, 1, 'zzup', '2025-04-30 23:02:17', 1),
	(31, 55, NULL, 'chat', '2025-04-30 23:31:06', 0),
	(32, 55, NULL, 'nigrow', '2025-04-30 23:31:11', 0),
	(33, 57, NULL, 'hello', '2025-05-01 23:03:57', 0),
	(34, 57, 1, 'HI DAVID', '2025-05-01 23:04:07', 1),
	(35, 57, NULL, 'YOWW', '2025-05-01 23:04:13', 0),
	(36, 48, NULL, 'awdaw', '2025-05-06 20:00:07', 0),
	(37, 48, NULL, 'hello', '2025-05-06 21:02:34', 0),
	(38, 48, NULL, 'test', '2025-05-06 21:03:09', 0),
	(39, 50, NULL, 'hello', '2025-05-06 22:07:57', 0),
	(40, 54, 1, 'hey', '2025-05-15 18:00:55', 1),
	(41, 50, NULL, 'gjo', '2025-05-16 17:59:11', 0),
	(42, 63, NULL, 'hello', '2025-05-22 14:03:27', 0),
	(43, 63, 1, 'hi', '2025-05-22 15:40:56', 1),
	(44, 63, 1, 'how may i help you today? 1+1 ay magellan', '2025-05-22 15:43:12', 1),
	(45, 47, 5, 'sup', '2025-05-23 22:46:50', 1);

-- Dumping structure for table fvb1sp63uzi8xp6g.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.migrations: ~0 rows (approximately)

-- Dumping structure for table fvb1sp63uzi8xp6g.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'document_status, announcement, etc',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `related_id` int DEFAULT NULL COMMENT 'document request id or other related entity',
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.notifications: ~19 rows (approximately)
INSERT IGNORE INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `related_id`, `is_read`, `created_at`) VALUES
	(14, 58, 'document_status', 'Document Approved', 'Your Barangay Clearance request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 42, 0, '2025-05-24 07:24:19'),
	(15, 59, 'document_status', 'Document Approved', 'Your First Time Job Certificate request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 43, 0, '2025-05-24 07:26:22'),
	(16, 58, 'document_status', 'Document Approved', 'Your Certificate of Indigency request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 44, 0, '2025-05-24 07:49:44'),
	(17, 50, 'document_status', 'Document Approved', 'Your First Time Job Certificate request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 33, 0, '2025-05-24 09:39:09'),
	(18, 47, 'document_status', 'Document Approved', 'Your First Time Job Certificate request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 38, 0, '2025-05-24 10:41:54'),
	(19, 50, 'document_status', 'Document Approved', 'Your Certificate of Indigency request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 32, 0, '2025-05-24 11:46:15'),
	(20, 50, 'document_status', 'Document Approved', 'Your Barangay Clearance request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 31, 0, '2025-05-24 11:58:13'),
	(21, 50, 'document_status', 'Document Approved', 'Your Cedula request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 30, 0, '2025-05-24 12:04:52'),
	(22, 50, 'document_status', 'Document Approved', 'Your Barangay Clearance request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 45, 0, '2025-05-24 12:08:03'),
	(23, 50, 'document_status', 'Document Approved', 'Your Barangay Certification request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 46, 0, '2025-05-24 12:10:13'),
	(24, 50, 'document_status', 'Document Approved', 'Your Barangay Clearance request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 47, 0, '2025-05-24 12:13:30'),
	(25, 50, 'document_status', 'Document Approved', 'Your Barangay Clearance request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 47, 0, '2025-05-24 12:15:13'),
	(26, 50, 'document_status', 'Document Approved', 'Your Barangay Clearance request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 45, 0, '2025-05-24 12:16:30'),
	(27, 50, 'document_status', 'Document Approved', 'Your Barangay Certification request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 46, 0, '2025-05-24 12:16:42'),
	(28, 50, 'document_status', 'Document Approved', 'Your Barangay Clearance request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 47, 0, '2025-05-24 12:16:58'),
	(29, 50, 'document_status', 'Document Approved', 'Your Barangay Clearance request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 47, 0, '2025-05-24 12:21:19'),
	(30, 50, 'document_status', 'Document Approved', 'Your Barangay Clearance request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 45, 0, '2025-05-24 12:21:31'),
	(31, 50, 'document_status', 'Document Approved', 'Your Barangay Certification request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 46, 0, '2025-05-24 12:21:49'),
	(32, 50, 'document_status', 'Document Approved', 'Your Barangay Clearance request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).', 31, 0, '2025-05-24 12:24:21'),
	(33, 50, 'incident_status', 'Incident Report Update', 'Your incident report regarding \'Theft\' has been reviewed and marked as resolved.', 26, 0, '2025-05-25 13:51:29'),
	(34, 50, 'incident_status', 'Incident Report Update', 'Your incident report regarding \'Accident\' has been reviewed and marked as resolved.', 27, 0, '2025-05-25 13:57:27'),
	(35, 50, 'incident_status', 'Incident Report Update', 'Your incident report regarding \'Accident\' has been reviewed and marked as resolved.', 28, 0, '2025-05-25 14:10:36');

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

-- Dumping data for table fvb1sp63uzi8xp6g.sessions: ~20 rows (approximately)
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
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `archived_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `idx_full_name` (`full_name`),
  KEY `idx_archived` (`archived`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.user_accounts: ~12 rows (approximately)
INSERT IGNORE INTO `user_accounts` (`id`, `firstName`, `lastName`, `username`, `age`, `gender`, `adrHouseNo`, `adrZone`, `adrStreet`, `birthday`, `password`, `user_profile_picture`, `last_active`, `status`, `user_valid_id`, `user_valid_id_back`, `verified_at`, `rejected_at`, `created_at`, `updated_at`, `archived`, `archived_at`) VALUES
	(47, 'Kat', 'Arina', 'kat', 31, 'male', '123', '123', '123', '1994-04-01', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744346430/user_profile_pictures/user_profile_1744346430_67f89d3ed6e69.jpg', '2025-05-24 11:45:25', 'verified', '/storage/uploads/valid_ids/67ebb65c6aa5a_front_valid_id_2389568226844613097.jpg', '/storage/uploads/valid_ids/67ebb65c6b224_back_valid_id_back_2207045255775656039.jpg', '2025-04-10 20:54:20', '2025-04-10 20:54:12', '2025-04-01 17:48:12', '2025-04-10 20:54:20', 0, NULL),
	(48, 'David', 'Olerio', 'davis', 21, 'male', '497', 'ISU', 'Kalaw', '2003-12-22', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744341668/user_profile_pictures/user_profile_1744341668_67f88aa40e6b1.jpg', '2025-05-25 12:39:55', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744340946/user_valid_ids/user_id_1744340946_front_valid_id_67f887d26cad0.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744340947/user_valid_ids/user_id_1744340946_back_valid_id_back_67f887d2e9c2a.jpg', '2025-04-11 11:20:18', NULL, '2025-04-11 11:09:07', '2025-04-11 11:20:18', 0, NULL),
	(50, 'Clement Harold Miguel', 'Cabus', 'clement', 21, 'male', '678-b', 'Panam village', 'Hinar street', '2003-12-22', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746040095/user_profile_pictures/user_profile_1746040095_6812751f6240b.jpg', '2025-05-25 14:20:23', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745127796/user_valid_ids/user_id_1745127796_front_valid_id_680489743c61b.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745127796/user_valid_ids/user_id_1745127796_back_valid_id_back_68048974ac313.jpg', '2025-04-20 13:47:57', NULL, '2025-04-20 13:43:17', '2025-04-20 13:47:57', 0, NULL),
	(53, 'Joshua', 'Fernandez', 'joshfern12', 22, 'male', '123', 'Zone 3', 'Mangga St.', '2003-04-28', 'CKBpWa1yuo7rA/bGaJ2xGC8bHgHegi1VLoN1vQjPo4c=', 'default.jpg', '2025-04-28 09:37:43', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745804148/user_valid_ids/user_id_1745804148_front_valid_id_680edb74be809.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745804149/user_valid_ids/user_id_1745804149_back_valid_id_back_680edb7547937.jpg', '2025-04-28 09:36:09', NULL, '2025-04-28 09:35:50', '2025-04-28 09:36:09', 0, NULL),
	(54, 'Cleofe Maria', 'Cabus', 'cleofe', 57, 'female', '497', 'ISU Village', 'Village Kalaw', '1967-11-15', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745903599/user_profile_pictures/user_profile_1745903599_68105fef577d0.jpg', '2025-04-29 22:58:09', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745903455/user_valid_ids/user_id_1745903455_front_valid_id_68105f5f36caa.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745903455/user_valid_ids/user_id_1745903455_back_valid_id_back_68105f5fbdadf.jpg', '2025-04-29 13:11:10', NULL, '2025-04-29 13:10:56', '2025-04-29 13:11:10', 0, NULL),
	(55, 'Harry', 'Houdini', 'harry', 32, 'male', '763-c', 'Panam Village', 'Lawin street', '1992-04-30', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746040914/user_profile_pictures/user_profile_1746040914_681278528f106.jpg', '2025-05-02 14:45:35', 'rejected', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746025045/user_valid_ids/user_id_1746025045_front_valid_id_68123a55bc321.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746025046/user_valid_ids/user_id_1746025046_back_valid_id_back_68123a56ac1d0.jpg', '2025-04-30 22:58:49', NULL, '2025-04-30 22:57:27', '2025-05-07 23:14:51', 1, '2025-05-07 23:14:51'),
	(56, 'James', 'Padilla', 'jamespadilla321', 25, 'male', '321', '123', 'Mangga', '2000-01-12', '1dyXO1Hqp9P3b+wVt48enk+BPL4AgxesK9hyy6V/jRY=', 'default.jpg', '2025-05-21 20:22:38', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746098324/user_valid_ids/user_id_1746098323_front_valid_id_68135893d9b16.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746098324/user_valid_ids/user_id_1746098324_back_valid_id_back_681358945bc66.jpg', '2025-05-01 19:23:38', NULL, '2025-05-01 19:18:44', '2025-05-01 19:23:38', 0, NULL),
	(57, 'Crazy', 'Nigga', 'hola', 20, 'male', '25', 'Alley 16', 'P. Rosales', '2004-10-01', 'pCclRjq3jfFzy0FaXVNgRFfQ5Y6AL3huAcGCcn3eALA=', 'default.jpg', '2025-05-01 23:08:43', 'rejected', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746111644/user_valid_ids/user_id_1746111644_front_valid_id_68138c9ca09d8.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746111645/user_valid_ids/user_id_1746111645_back_valid_id_back_68138c9d46c67.jpg', '2025-05-01 23:02:10', NULL, '2025-05-01 23:00:46', '2025-05-07 21:49:17', 1, '2025-05-07 21:49:17'),
	(58, 'Lucas', 'TheDig', 'LucasTheDig', 24, 'male', '123', 'Polar Village', 'Kalaw', '2000-10-17', 'kj1OCLK/cXIGeqTFeV1o0pz2hjm8WUCyFUG86ZzJjDQ=', 'default.jpg', '2025-05-24 08:10:24', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746163786/user_valid_ids/user_id_1746163786_front_valid_id_6814584ac08c6.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746163787/user_valid_ids/user_id_1746163787_back_valid_id_back_6814584b6e287.jpg', '2025-05-02 13:30:36', NULL, '2025-05-02 13:29:47', '2025-05-02 13:30:36', 0, NULL),
	(59, 'John', 'Doe', 'JohnDoe', 8, 'male', '123', 'Polar Village', 'Kalaw', '2016-05-19', 'kj1OCLK/cXIGeqTFeV1o0pz2hjm8WUCyFUG86ZzJjDQ=', 'default.jpg', '2025-05-24 08:10:04', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746167872/user_valid_ids/user_id_1746167872_front_valid_id_6814684087b81.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746167873/user_valid_ids/user_id_1746167873_back_valid_id_back_6814684112174.jpg', '2025-05-02 14:38:15', NULL, '2025-05-02 14:37:53', '2025-05-02 14:38:15', 0, NULL),
	(60, 'Chris', 'Redfield', 'chris', 0, 'male', '760', 'Louisiana', 'Baker Estate', '2025-05-06', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'default.jpg', '2025-05-06 20:38:26', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746530668/user_valid_ids/user_id_1746530668_front_valid_id_6819f16c9f4b5.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746530669/user_valid_ids/user_id_1746530669_back_valid_id_back_6819f16d3139a.jpg', '2025-05-06 19:24:51', NULL, '2025-05-06 19:24:29', '2025-05-06 19:24:51', 0, NULL),
	(63, 'mark', 'mark', 'mark123', 22, 'male', '34', '5', 'mangga', '2003-05-22', 'zMfeLnQC9dRHC+5mhJWZc2l/NQdcY2G6b4TZC1JB0W8=', 'default.jpg', '2025-05-22 16:00:36', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747843404/user_valid_ids/user_id_1747843403_front_valid_id_682df94bebf45.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1747843404/user_valid_ids/user_id_1747843404_back_valid_id_back_682df94c62072.jpg', '2025-05-22 00:03:42', NULL, '2025-05-22 00:03:24', '2025-05-22 00:03:42', 0, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
