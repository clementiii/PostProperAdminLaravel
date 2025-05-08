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
	(1, 'Rannie Camba', 'rannie', '$2y$12$TCA6Q9wgT7OCs62A7W4q5ef1QPPEBXsz7WRan8zv8/y8v01u8vr/e', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744287281/admin_profile_pictures/admin_1_1744287281.png', NULL, '2025-04-10 20:14:42'),
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.barangay_announcements: ~4 rows (approximately)
INSERT IGNORE INTO `barangay_announcements` (`id`, `announcement_title`, `description_text`, `announcement_images`, `created_at`, `posted_at`) VALUES
	(10, 'CLEAN-UP DRIVE at Maricaban Creek', 'As we approach EARTH DAY with the theme: OUR POWER, OUR PLANET, the Metropolitan Environmental Office- MEO West under the Department of Environment and Natural Resources -DENR in cooperation with Post Proper Southside headed by Punong Barangay Quirino Sarono and Council, led by Committee in charge Kagawad Elmer Baldonado together with Environmental Police were organizing a CLEARING and CLEAN-UP Activity along the water ways at Maricaban Creek to enhance the preservation and protection of our natural resources.\r\n.\r\n#KapQS\r\n#SERBISYONG SARONO\r\n#IHEARTSOUTHSIDE\r\n#SOUTHSIDE2025\r\nONE DREAM....ONE GOAL...ONE COMMUNITY', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339817\\/announcement_images\\/announcement_1744339817_67f8836933ed3.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339817\\/announcement_images\\/announcement_1744339817_67f88369b2ea6.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339818\\/announcement_images\\/announcement_1744339818_67f8836a31f33.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339818\\/announcement_images\\/announcement_1744339818_67f8836ac14fc.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744339819\\/announcement_images\\/announcement_1744339819_67f8836b4bb7d.jpg"]', '2025-04-11 10:50:19', '2025-04-11 10:50:19'),
	(11, 'Fire Incident  4/8/25', 'Southside B.E.R.T Responded at a reported fire Incident at A.Mabini St, Brgy. Tuktukan Taguig City that involves a residential area.\r\nKeep safe everyone 🙏\r\nReminder from Punong Barangay Quirino Sarono  and Council.', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342261\\/announcement_images\\/announcement_1744342261_67f88cf57ad76.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342262\\/announcement_images\\/announcement_1744342262_67f88cf621d0d.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342263\\/announcement_images\\/announcement_1744342263_67f88cf715963.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342263\\/announcement_images\\/announcement_1744342263_67f88cf7c007d.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744342264\\/announcement_images\\/announcement_1744342264_67f88cf843b62.jpg"]', '2025-04-11 11:31:06', '2025-04-11 11:31:06'),
	(14, '04/11/2025', 'Southside BERT conducted a flashing operation for an oil spill at Buting Brgy. East Rembo, Taguig City.', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391161\\/announcement_images\\/announcement_1744391160_67f94bf8f1ed4.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391161\\/announcement_images\\/announcement_1744391161_67f94bf9983cf.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391162\\/announcement_images\\/announcement_1744391162_67f94bfa2757e.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391163\\/announcement_images\\/announcement_1744391163_67f94bfb0fdbf.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744391163\\/announcement_images\\/announcement_1744391163_67f94bfbba560.jpg"]', '2025-04-12 01:06:04', '2025-04-12 01:06:04'),
	(17, 'Test', 'Test Description', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1745633610\\/announcement_images\\/announcement_1745633610_680c414a81cf9.jpg","https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1745633611\\/announcement_images\\/announcement_1745633610_680c414ad6e58.jpg"]', '2025-04-26 10:13:31', '2025-04-26 10:13:31');

-- Dumping structure for table fvb1sp63uzi8xp6g.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.cache: ~198 rows (approximately)
INSERT IGNORE INTO `cache` (`key`, `value`, `expiration`) VALUES
	('barangay_management_system_cache_005a9b7644ed65d9c322d570e18d7bad', 'i:1;', 1745857904),
	('barangay_management_system_cache_005a9b7644ed65d9c322d570e18d7bad:timer', 'i:1745857904;', 1745857904),
	('barangay_management_system_cache_0078688bc9c722775d928f1d5948348e', 'i:1;', 1744514042),
	('barangay_management_system_cache_0078688bc9c722775d928f1d5948348e:timer', 'i:1744514042;', 1744514042),
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
	('barangay_management_system_cache_293c1abc3454cf456f196f0e1d158d93', 'i:1;', 1745631855),
	('barangay_management_system_cache_293c1abc3454cf456f196f0e1d158d93:timer', 'i:1745631855;', 1745631855),
	('barangay_management_system_cache_305bfdf0b2a4ba0dea2c3168ab6dd094', 'i:1;', 1744543555),
	('barangay_management_system_cache_305bfdf0b2a4ba0dea2c3168ab6dd094:timer', 'i:1744543555;', 1744543555),
	('barangay_management_system_cache_3189907242e2fc415da16336d901bbb4', 'i:1;', 1744543595),
	('barangay_management_system_cache_3189907242e2fc415da16336d901bbb4:timer', 'i:1744543595;', 1744543595),
	('barangay_management_system_cache_3312c4d1bb2650d2d9fc7a4455e7a395', 'i:1;', 1746164357),
	('barangay_management_system_cache_3312c4d1bb2650d2d9fc7a4455e7a395:timer', 'i:1746164357;', 1746164357),
	('barangay_management_system_cache_370cb812f333c3b677798166b0f5b3e3', 'i:1;', 1744814462),
	('barangay_management_system_cache_370cb812f333c3b677798166b0f5b3e3:timer', 'i:1744814462;', 1744814462),
	('barangay_management_system_cache_3d3eb0fee2e8ac22199f0f395c28f99a', 'i:1;', 1745239150),
	('barangay_management_system_cache_3d3eb0fee2e8ac22199f0f395c28f99a:timer', 'i:1745239150;', 1745239150),
	('barangay_management_system_cache_3ead8462859aef23607ae26f4e843e4c', 'i:1;', 1744418190),
	('barangay_management_system_cache_3ead8462859aef23607ae26f4e843e4c:timer', 'i:1744418190;', 1744418190),
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
	('barangay_management_system_cache_7260056b391e58d8457f76336ba3ae75', 'i:1;', 1744303404),
	('barangay_management_system_cache_7260056b391e58d8457f76336ba3ae75:timer', 'i:1744303404;', 1744303404),
	('barangay_management_system_cache_74556341a18970c89a2621475047b288', 'i:1;', 1745804209),
	('barangay_management_system_cache_74556341a18970c89a2621475047b288:timer', 'i:1745804209;', 1745804209),
	('barangay_management_system_cache_74b42a84b530dd3a1f5a85274d5395ae', 'i:1;', 1745074211),
	('barangay_management_system_cache_74b42a84b530dd3a1f5a85274d5395ae:timer', 'i:1745074211;', 1745074211),
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
	('barangay_management_system_cache_84063fddd121580d2633f5ee76b16ccd', 'i:1;', 1745505898),
	('barangay_management_system_cache_84063fddd121580d2633f5ee76b16ccd:timer', 'i:1745505898;', 1745505898),
	('barangay_management_system_cache_90cac04b54f47199d3fbecf27cefdabe', 'i:1;', 1744278023),
	('barangay_management_system_cache_90cac04b54f47199d3fbecf27cefdabe:timer', 'i:1744278023;', 1744278023),
	('barangay_management_system_cache_939fea01959f44a59cc629af27af099e', 'i:1;', 1744373996),
	('barangay_management_system_cache_939fea01959f44a59cc629af27af099e:timer', 'i:1744373996;', 1744373996),
	('barangay_management_system_cache_9fdaf3d8cf52a797b1fa4f23c5b27415', 'i:1;', 1744873627),
	('barangay_management_system_cache_9fdaf3d8cf52a797b1fa4f23c5b27415:timer', 'i:1744873627;', 1744873627),
	('barangay_management_system_cache_a27578afa9c35c7a147d4cdc4f98d273', 'i:1;', 1744389938),
	('barangay_management_system_cache_a27578afa9c35c7a147d4cdc4f98d273:timer', 'i:1744389938;', 1744389938),
	('barangay_management_system_cache_a5472241912702c8451e213b9026e6e0', 'i:1;', 1745932477),
	('barangay_management_system_cache_a5472241912702c8451e213b9026e6e0:timer', 'i:1745932477;', 1745932477),
	('barangay_management_system_cache_a5b63fd1af204d60d71dc2720618a0fe', 'i:1;', 1745487660),
	('barangay_management_system_cache_a5b63fd1af204d60d71dc2720618a0fe:timer', 'i:1745487660;', 1745487660),
	('barangay_management_system_cache_a839739e32d735d1e274a0727d0d3526', 'i:1;', 1744380804),
	('barangay_management_system_cache_a839739e32d735d1e274a0727d0d3526:timer', 'i:1744380804;', 1744380804),
	('barangay_management_system_cache_a8c17b62921d93570477ced159c9a729', 'i:1;', 1745979906),
	('barangay_management_system_cache_a8c17b62921d93570477ced159c9a729:timer', 'i:1745979906;', 1745979906),
	('barangay_management_system_cache_a959dbf730e494ba316e1e16772550d6', 'i:1;', 1746625808),
	('barangay_management_system_cache_a959dbf730e494ba316e1e16772550d6:timer', 'i:1746625808;', 1746625808),
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
	('barangay_management_system_cache_b1fa0729d6c8ab952788345b6f02543e', 'i:1;', 1744270270),
	('barangay_management_system_cache_b1fa0729d6c8ab952788345b6f02543e:timer', 'i:1744270270;', 1744270270),
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
	('barangay_management_system_cache_cb77a03b70f6ec890d48ae250fefc63c', 'i:1;', 1746374914),
	('barangay_management_system_cache_cb77a03b70f6ec890d48ae250fefc63c:timer', 'i:1746374914;', 1746374914),
	('barangay_management_system_cache_cba730c79fb0bd1768e679df3db6984e', 'i:1;', 1746348168),
	('barangay_management_system_cache_cba730c79fb0bd1768e679df3db6984e:timer', 'i:1746348168;', 1746348168),
	('barangay_management_system_cache_cbe87f5425c68c23f67b0c8d1130d707', 'i:1;', 1746206907),
	('barangay_management_system_cache_cbe87f5425c68c23f67b0c8d1130d707:timer', 'i:1746206907;', 1746206907),
	('barangay_management_system_cache_cc51cac703b7ba72a5dc794ad82fdc87', 'i:1;', 1745209901),
	('barangay_management_system_cache_cc51cac703b7ba72a5dc794ad82fdc87:timer', 'i:1745209901;', 1745209901),
	('barangay_management_system_cache_cffa08a72f58581a0b0c61f57b0bc680', 'i:1;', 1746024354),
	('barangay_management_system_cache_cffa08a72f58581a0b0c61f57b0bc680:timer', 'i:1746024354;', 1746024354),
	('barangay_management_system_cache_d42883fb5485d3c93a24ce82b447270f', 'i:1;', 1746530737),
	('barangay_management_system_cache_d42883fb5485d3c93a24ce82b447270f:timer', 'i:1746530737;', 1746530737),
	('barangay_management_system_cache_d7bc32c24e54a0cc6c5db4d93d0c5e63', 'i:1;', 1746097004),
	('barangay_management_system_cache_d7bc32c24e54a0cc6c5db4d93d0c5e63:timer', 'i:1746097004;', 1746097004),
	('barangay_management_system_cache_dbec43877e78c382a331704e3ff3c4a4', 'i:1;', 1745802981),
	('barangay_management_system_cache_dbec43877e78c382a331704e3ff3c4a4:timer', 'i:1745802981;', 1745802981),
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
	('barangay_management_system_cache_e5614c91eb3c5dab94476db367e9067e', 'i:1;', 1746176534),
	('barangay_management_system_cache_e5614c91eb3c5dab94476db367e9067e:timer', 'i:1746176534;', 1746176534),
	('barangay_management_system_cache_e56c0ce53ea3b404bc400d179b7a95a1', 'i:1;', 1746161128),
	('barangay_management_system_cache_e56c0ce53ea3b404bc400d179b7a95a1:timer', 'i:1746161128;', 1746161128),
	('barangay_management_system_cache_e5fa6ba3d7ec923d7c4fc7986051b36e', 'i:1;', 1745932469),
	('barangay_management_system_cache_e5fa6ba3d7ec923d7c4fc7986051b36e:timer', 'i:1745932469;', 1745932469),
	('barangay_management_system_cache_eb56b1dc7c9659624afbf5f9b710a460', 'i:1;', 1744543575),
	('barangay_management_system_cache_eb56b1dc7c9659624afbf5f9b710a460:timer', 'i:1744543575;', 1744543575),
	('barangay_management_system_cache_f24a1c12ff4591cce5dc62f6f70b3983', 'i:1;', 1745074280),
	('barangay_management_system_cache_f24a1c12ff4591cce5dc62f6f70b3983:timer', 'i:1745074280;', 1745074280),
	('barangay_management_system_cache_f29e83d982589460fd2ac0f69fa12b11', 'i:1;', 1745897731),
	('barangay_management_system_cache_f29e83d982589460fd2ac0f69fa12b11:timer', 'i:1745897731;', 1745897731),
	('barangay_management_system_cache_f76f5b2252ca4afcbdda142d0a655dac', 'i:1;', 1746110914),
	('barangay_management_system_cache_f76f5b2252ca4afcbdda142d0a655dac:timer', 'i:1746110914;', 1746110914),
	('barangay_management_system_cache_f84ed1a5970b55d4bba037653ebe4008', 'i:1;', 1745856946),
	('barangay_management_system_cache_f84ed1a5970b55d4bba037653ebe4008:timer', 'i:1745856946;', 1745856946),
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
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `archived_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `idx_archived` (`archived`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.document_requests: ~12 rows (approximately)
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
	(23, 58, 'Certificate of Indigency', 'Lucas TheDig', '123 Kalaw Zone Polar Village', '000123456789', '000123456789', 'asdfas', 24, '10-17-00', 'waqdsfas', 'asdfasd', 6, 'asdfasd', 'Male', 'Single', 'asdfasdfa', 'approved', 1, '2025-05-05 12:12:42', '', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746418371/valid_ids/valid_id_1746418371_front_68183ac3b1ddf.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746418372/valid_ids/valid_id_1746418372_back_68183ac430be2.jpg', '', '', NULL, 'pending', '2025-05-05 12:16:12', NULL, NULL, 0, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.document_signatures: ~12 rows (approximately)
INSERT IGNORE INTO `document_signatures` (`id`, `document_request_id`, `signature_data`, `signature_hash`, `created_at`, `updated_at`, `public_key`, `signed_data`, `expiry_date`) VALUES
	(1, 8, 'al3jrEj7+K2JbqH2KDOP61I2xHrIZA4FAEtv9/t0LO5g75rDWPVHGfbuZ6oJ+orOYCBVx0uMOC0aZuzBGK2u9t0oeTwLjWPKgwJ4hGzE8OoTKGZJxT44FAmxJ6BXGVpMSpjGOBwBZVjervwTCen+tJ9bmwGCzyHz32AEKelWWHT57T/QmGtARW3DQ5d/CN1NQ6IPNbUeoRQxPHBTl2cJ5EvfEQ5nmdqBzwvXsyIA/R1ovIsSvqihg3LKjVbofrUW2fRqA6LJPEiMk5wcnEXiPnCk9AUmOGI54Q5xPIYvEsUWSjDXf9nRVobDu27ls0qkh6Q8kCqcTh8QRKhfMCKmvA==', 'ad5ee2f74b7a00ec734ad06afeafa61633760fa2d2717dad156098852721ded1', '2025-04-19 00:11:16', '2025-04-19 00:11:16', NULL, NULL, NULL),
	(2, 8, 'kcbGckDRC8Jq6Lv5crPG6HmPLRlUGv+wVbWlhdGcpraBstc4RfIBEldqmVxkwItPG49a7Uw8nASEu94vSjXRFgrPcgfTaEYko8tDbSCOnJS+H7hAePZSOxmk4irb6m3d+xsLep9eXdyF2g1djN/YdzUAogNbm7oqlDvDiHf8Zxq3pTUaKuso96RPHgKmWPZdE1URhZynf0+6JgLTfZnaKIX9VNMXgOQnU5bhcHZJ8LLcVGJDX0LkeciVw+ErrSbCzH7gr2xswepqWr87gR8gdSFb/Lx6IlfBTDuAYGtpDs5V96/Ofbidn/YfrhBr1RmmPRH4oDLsOBap5DlBJ+ruLQ==', 'e9c314a1dde208b525aa708511ef029503c877319b428140cbb0604a9f3cfe66', '2025-04-19 00:25:54', '2025-04-19 00:25:54', NULL, NULL, NULL),
	(3, 1, 'kVQazeOl8Y0efd9U6wMAA+c82FYxG1Sh2w6efto9dtOYfNcZ0b+WweKAa7Qlsrpl7/WGxsJB+Ms2BiL4QhhcGWELAWUfmBtJ2j0+68cR+fw6vidlFa4rPHfxUaMQ+ujNaNgoMAdTuvIXY0U46VeCAzfJzfMOD1bIiq0QBCXfigsVtMWqBBEHSoSTEVRaf8+2M8x3p1wWYwjJgRq38nI7pilBxqEyPnvH06KfHq5Qh+FA0P9t26fbBh/4PtvCPNpA+4/WcbbNVPnOHqd6RRSL9/QTeb1GBRoVV8Nhg9pa0B4gDlDoXmtnbkSf6Rnh9Rj3nvTcF0wKdtLWBkRaccGnVA==', 'ec92ce6a1f26e7dc2229d96017adfb354570d9da855d64a5e543c565ed252ded', '2025-04-19 22:51:05', '2025-04-19 22:51:05', NULL, NULL, NULL),
	(4, 7, 'Dihi+TxzpgOAmLTv6QOqAcfM5w48DVAEKTjIfAjnknOvabrAvu8lkFyCBYSmcB5ebaJoj5pwkqN5pWQZwrbRJ/wTzNCvaHcZEQ5S6nBmR6PgTcBQyJXIMjOq8wi1AYcfz2HbRCP3Jfr+IcZ8vOr1BRNPDYwZMhbz4GBDhYYAJ6dDz/yq8sbAWRfyl0VV4ciDZWSJ6M+jU8WubN7M+bV1ssQlhurKiRgbi7E/AzgOXu6TGQ749qTOX8mUIJLtEXvRQaqiB7yHv1E+OA+EnJ3vrty9EL6Sk1UiLkoe7qfng+zaWwUhfc48KhWsz1vMR3R2MS1e8ULkYce6hnJtPLhsfg==', 'c96cfe66a89be98dfc78dd8c3ae1f493d0310fa2d0c351ec2f1392e5ed4bc072', '2025-04-20 12:48:58', '2025-04-20 12:48:58', NULL, NULL, NULL),
	(5, 8, 'bmswM1bfLyM+SkhRCCur2QORbqBYsKrXoghAW2eXF6MSR/jg3Ww3Ia+g1z6enW3crHpfWp1erK94ertZxZHyXLI5LGclmRnAySQ1iE8sRIzkpWLdxtsilFMRQVu9O72d4UQNVr8+BiS9ezSExk6ODL/WvxkLAKsx6epW5E2Keh+ZgH5zrWSjpM6rYfbXe75nVtdX9Jaufl8ssf/8XQ0x0kBi1R+MtaRoKX3g7d4MRX2/2+eSxT9abCoEgUo0OOcu5UOG4ihnEWVxbQ5Do9c4q89A3BYIVbLhsrlWF38w+WHBLSivNVNYTj3tRtekvAmRYhcbse4pWa0rGNS0+yKUfg==', '85a5fc2b45ea73f0721c4853920d056b381eedbed82d55ea8bba96ff9aa9b42a', '2025-04-21 12:31:47', '2025-04-21 12:31:47', NULL, NULL, NULL),
	(6, 7, 's6kkz4bTkankqhteZrcAC7ja1SWDDOu1k1JNAgsX/iwo3hktQHjifIyzP+6HYsvcdnk9FCPHuOkoHzSB7+XHFu4izPgmDGMPYLHtUpllaEbrCo7jIKFBUiYQfKQ3ogRmtJo5ldZ3XK6EFvesp11aazWsWVQ99tamxc6UyloAehml127JwG0HZ9hXV15Lx8dJuSgoxwFYHxyeuNWzrbytzu4noP6bHVN0sezKCm89a8r3IL7bpVkBjlb9yiC7ui+jncHx62lcEAogUtJSVzOVvIGugDo/jcbUghubGWExC6xLd0ElsfM5Ne5sgPs/cC65f0h2wJGws9r0SHFqJLlfJw==', 'fc217589005dc605782a2e6a73069d13f70b36ab02cd8107f3e3d695fb8d32c7', '2025-04-21 20:39:16', '2025-04-21 20:39:16', NULL, NULL, NULL),
	(7, 5, 'Nhe9KJFFTSx6IwUKww40NXCIYgmSXaxWcCF41AJ5UtlVc5Kx7HwdR/lE7HEsx8cdp+B2wac6Q/kOpTZuHaoAjN7PRHPmvMjnQKui0AiONjxri3GhC7tBJjsTl6CdFORNQygJ3e+n+tyr4vZAKDR552j/rt3nvmf6pdtrdacWUGNE3JEwT32rJdmGwzV5MEQrXZmGA4ch0tHklFUuYdhVIVxlH7dhWECpS2uCqwIrI2mI57asMnFXZTG4G8KFxMG9yzuTnBlYxKe96/hloitzynpKGLdVg/Zp8A1ssodEnry9Cm7+XouyVPcmc3Y8IVokHbl4MVhKg42EoJtxCi6D7g==', 'd9029a14cc1800eb278ff3d77322f7bceb40eb3cf12dcd260aa2b4dba2a17b3d', '2025-04-26 11:26:18', '2025-04-26 11:26:18', NULL, NULL, NULL),
	(8, 3, 'ITxjbAO5GlohZkAQrA6q0Hr2k5Zvt0ZGYYwpO0JC81QC27huvV1ZEsWgsdplmGVDSXdogD+ly59NoudQ4t38bfHyGmgW1jbGSfLyFsMeb3zk0tLe3D+0O6aLOtapJynh1F8zcyv9VXfgC/7c401HmeVieilmUMNpQ80QXDL4R2hUj4HlO4n2gZIxTesvJq3ih9bsm0rcBppua2rAS1VB+VoueblfzmkJRNDz52HHbokzKQkQdOGAV1arrjyHQ1QHOsPiW1I9V/mOl+3vi2dTXPWtW6yhecBSZ9KOQY8SBLk06u4ANqC/Ma10L6OdqIO3ndC5iuRWg2axuSxsuSbvvQ==', '8238b0324454fcc493931b3e3dbdc759e62aa5273eb387d5058aeb9e3415501a', '2025-04-26 11:46:14', '2025-04-26 11:46:14', NULL, NULL, NULL),
	(9, 3, 'A433bskNd7nhw/l/pHbbMXz+lTDsATdh5oUCJV050m8ZfQimVHnVbfvxPOETpguMcix+mNKFwQWP0zSXsg3+z5GIYF49QMxHOzBZKYXRBi17VC4TaBHNd0nsEo0deVEBkxoNokyszuYBe8jTH3btZOx55jf7ViGUM/AWpDch0WXmQpMj8YYFtGBPa4DWjseuEBHpk4n1sEhYR0CcJbsb4tiiF6fQZzJsKSi3yYn6giact2SNnAeA3pYVnSFIqJFWBkHCFZmxaMQkOt/Dh989utMc2OOsMT+P+70udn6x8yAl3FAlKlI2hg6x0Vle7Ia3FvqyaeWH4oBnI3cnIfyHZQ==', '4532befb0f9a635bf7511bbc6efa7585538994d32e4db977553a8e950538e0f4', '2025-04-26 11:46:35', '2025-04-26 11:46:35', NULL, NULL, NULL),
	(10, 9, 'N4wj4b0ZNw4LpM6eojG0ovdga09/9zUmci3W+DlUryd1LfxD5mKg5YI01JOjfA9dS58i2XnFF2YK/M4Gx6Vjr6NehCc5ZclgrrETpGhXfAYDbvuk+wZiNv3Y3XNsEz16IUb0+5lmSBi8fcfBTl6dPXF1+95PeK2JGg3RXLanHROImyh4WMPrPAZoyVOf2Hg9D/s4crdA8Gn+UhCmbzErCuHTLEYHZh34AiONBw1AFRMJgSLvX9bjOZ9j+Nx18B/kfOoCP1wxHVAdZcMkD29N9UL9QVcxfOoNCXSRc+/oUENaleHXvb3GMaYEs/2+8JelFXNBd5PnvNUeQyVVjQn95g==', '33b475407dc01122b8bae4c40bf27f7140014aaa4140316c944613679efbfb21', '2025-04-29 11:49:13', '2025-04-29 11:49:13', NULL, NULL, NULL),
	(11, 10, 'R+tyAOFqBrWGbG/q8EEuQuvT4Hw9YhRk/NF/QgVJWk7haED4GkeH5DacS8RoXSshpXg4uunv9PRfJsQnY1ITJHiYniABsWCZUZG+BOIf+6RgUMJGmjDncpYpQvGZRRwIyHSoUalImb97M5QzOMmPXtvGg5J7qlYk4X3nLP0SIkB+zcX4qZ+C7oJnhQ0pUXewH3Bbyzf5t1U8Vpn6GUFgyqpiR8LNt0qE8c/0lPH/Q6rwY5SHZvrg/JA+h/pvcv7SyMUk8hHlCrQ29VnpfQPoQv9oR/T54vSUgP6Sref+aAGnFI9txHp8QpEIyedK6m3Fn3ZDeSoYkwuIxSMVxiM1lA==', 'a0ee053f4d87363b263b3e3e6a4d608c1e32a738bfec5e01fd814869885bb81a', '2025-05-02 13:39:38', '2025-05-02 13:39:38', NULL, NULL, NULL),
	(12, 1, 'hUyhlkO/gCJX8ojSZ2g0WPKBZ+vlLwPUWJ+a9Lqd2tK+VdI60jZAjr0dpVSYxi59B5aeoOrwxRydyE3Kdsw16TnD1DjT3Ijctye1fzQDtZi85lla61RoDxck8u9nUyMnjLTm4BPN0iZBJ8sIeD49+wIGgqRz4zXMYLKDhcjrtZrQfxkRcPSwMY2emoYnJbJ1116EHzXqR01pkghnWy3f2yuVOGD6cuyjJ7B7l9FyB9SA9deX3ryb09u7dqT4YGsZsTdwMya/XkKOGxHemsBIDNCBEtMJmYjbhETxo+BiTufAFVbjX0skh9DSzGOKnliFToBgMg7RCWBKJolgPUXlzQ==', '14f0e8a54b032660bbbe274136e80d0cf9e60641f60fccbb383cbae15ceb2b4c', '2025-05-07 23:44:57', '2025-05-07 23:44:57', NULL, NULL, NULL),
	(13, 8, 'WzcuMw8f5JCS6Y225cfOfhIj7dJGielz9t2hSZBFWUIg/cCmbNn2+mNl25os5Ddtqr/iqfrVjJSECbHb6CkG62dCLzLRFsxuwFXK4fRSE9+UzsNAWq6DJ6fSA7Tn1hilaveGDCmIdO52WWsaXhBiW1GNW4XZ0ZYWjTa9aAv4odweNJX9zcaOnQ+0vbiyfoXQTM7yFB4Lbm8s4Rs0qxo4cv7hQr8mM+A2CQAVkObmFsnNNTzJfErOHjIR7+4kUQ3OGdrTMRCzXE/KvbVnf+8hahl3A8iIKi5h7P4A6CsSZ/cGjZjbevtRxDiWdlRMVFTUoPBldeBKOwUoPEUNGS6Nug==', '8268701da07a88e7b504d5a7a4caddddb854d5daa10f789cba0c4cdf3a85ceb9', '2025-05-07 23:53:14', '2025-05-07 23:53:14', NULL, NULL, NULL),
	(14, 23, 'BSbee1/yvslr8vyskJd4lyqc0/tsXap1TnGHYibnWgwDOb+GJsT0V7lPZLnO2xvfhiDAua0llk6kY/EwK4fzM4ZBFQPs+1U0cor9zUE90FG2r/XlxUbvqhgCjtduH3fRqxRs+cR5hZgkikA24PKK0oYWuDQLEQClX+aQa7KEZmo/IJ8jNDfrL/TDoE8tdfMqDMR1aC3afDA4zkIZOHZ3WJzLQcqrvhuxF3tGeRCj+CnLY4x6MewqJhwje4NuiHrCHxX30NaqNaFNe7CyW6yofwbZ+bFyOwnXu9IAjuHgUPERkk+SD3FBAncD85Mxh+6zSvrZla9Q8EgJ2r7FWo1gQg==', '86be9ef6da51608fad9fe7145c577b219097a7a07613e9b20d16edffe5d47971', '2025-05-08 00:25:48', '2025-05-08 00:25:48', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiDZLqPW32JlBpHF02rAC\r\ntmZXBTA4wJZTo+6SyKEzrPZRfI3sBvv1qIYc8NjjeoclMq6vxk70bxIYkPfpCwRC\r\nLjU0gnsyksc5lK/k+QzYAcYMGS0nx8BoJdkyACMtFLcKeRTpZEjyQtkmxz61EMnG\r\nxIMTZ+ooVxP8vrF0E7lxJ+i0TvS+DcnDbGYn8gx5tAFprap0AbFxwGRLikDr83M6\r\nKqdjBuLje1yBfMFS/2qMbrYejpSdzmLEN6KmgkucXvHnEd0WrZhT244gkSJBr4V0\r\n7y078/T5FBXwKSvhQKWjHMbiye//yAbBHsyGATOPrkP/Emt4Ijf50P2oHsOlICrc\r\n0QIDAQAB\r\n-----END PUBLIC KEY-----', '{"id":23,"name":"Lucas TheDig","address":"123 Kalaw Zone Polar Village","birthday":"10-17-00","document_type":"Certificate of Indigency","issued_on":"2025-05-08 00:25:48","expires_on":"2026-05-08 00:25:48","document_id":"23"}', '2026-05-08 00:25:48');

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.incident_reports: ~20 rows (approximately)
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
	(13, 'David Olerio', 'Other', 'hellppppp', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1744595462\\/incident_reports\\/incident_1744595462_db1122292a421b23.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744595458/incident_videos/incident_video_1744595445_xir6hyvn.mp4', '2025-04-14 09:51:02', 'pending', '2025-04-14 01:51:02', '2025-04-14 01:51:02', NULL, 0, NULL),
	(14, 'David Olerio', 'Accident', 'heieiw', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744595508/incident_videos/incident_video_1744595487_87zrb0ts.mp4', '2025-04-14 09:51:55', 'pending', '2025-04-14 01:51:55', '2025-04-14 01:51:55', NULL, 0, NULL),
	(15, 'David Olerio', 'Accident', 'test', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744859699/incident_videos/incident_video_1744859688_c3736utu.mp4', '2025-04-17 11:15:01', 'resolved', '2025-04-17 03:15:01', '2025-04-26 11:10:02', '2025-04-26 11:10:02', 0, NULL),
	(16, 'David Olerio', 'Accident', 'bruh', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1744862396/incident_videos/incident_video_1744862384_te5e7zgs.mp4', '2025-04-17 12:00:00', 'resolved', '2025-04-17 04:00:00', '2025-04-17 15:24:14', '2025-04-17 15:24:14', 0, NULL),
	(17, 'Harry Houdini', 'Fire', 'sunoggg', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1746025459\\/incident_reports\\/incident_1746025459_384125e77b0280c6.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1746025454/incident_videos/incident_video_1746025448_fc69i55c.mp4', '2025-04-30 23:04:19', 'pending', '2025-04-30 15:04:20', '2025-04-30 15:04:20', NULL, 0, NULL),
	(18, 'Harry Houdini', 'Accident', 'inangkas ko si miguel, binigyan kami ticket bawal daw nutshell aray koooooo', '[]', NULL, '2025-04-30 23:32:26', 'pending', '2025-04-30 15:32:26', '2025-04-30 15:32:26', NULL, 0, NULL),
	(19, 'Clement Harold Miguel Cabus', 'Accident', 'awdawd', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1746028036\\/incident_reports\\/incident_1746028036_d327926708d75322.jpg"]', NULL, '2025-04-30 23:47:16', 'pending', '2025-04-30 15:47:16', '2025-04-30 15:47:16', NULL, 0, NULL),
	(20, 'Harry Houdini', 'Accident', 'ugug', '[]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1746028139/incident_videos/incident_video_1746028134_gpng3t67.mp4', '2025-04-30 23:49:01', 'pending', '2025-04-30 15:49:01', '2025-04-30 15:49:01', NULL, 0, NULL),
	(21, 'Crazy Nigga', 'Injury', 'inatake ss puso', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1746111958\\/incident_reports\\/incident_1746111958_297ebbd044ec2793.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1746111956/incident_videos/incident_video_1746111951_z8uxd3z2.mp4', '2025-05-01 23:05:58', 'resolved', '2025-05-01 15:05:59', '2025-05-01 23:06:24', '2025-05-01 23:06:24', 0, NULL),
	(22, 'James Padilla', 'Accident', 'May aksidente sa mangga st.', '["https:\\/\\/res.cloudinary.com\\/hwovp9krt\\/image\\/upload\\/v1746166226\\/incident_reports\\/incident_1746166226_e637d0f1222596f1.jpg"]', 'https://res.cloudinary.com/hwovp9krt/video/upload/v1746166224/incident_videos/incident_video_1746166220_ma6ugk1s.mp4', '2025-05-02 14:10:26', 'resolved', '2025-05-02 06:10:27', '2025-05-03 01:27:52', '2025-05-03 01:27:52', 0, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.messages: ~38 rows (approximately)
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
	(39, 50, NULL, 'hello', '2025-05-06 22:07:57', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.notifications: ~0 rows (approximately)

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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fvb1sp63uzi8xp6g.user_accounts: ~11 rows (approximately)
INSERT IGNORE INTO `user_accounts` (`id`, `firstName`, `lastName`, `username`, `age`, `gender`, `adrHouseNo`, `adrZone`, `adrStreet`, `birthday`, `password`, `user_profile_picture`, `last_active`, `status`, `user_valid_id`, `user_valid_id_back`, `verified_at`, `rejected_at`, `created_at`, `updated_at`, `archived`, `archived_at`) VALUES
	(47, 'Kat', 'Arina', 'kat', 31, 'male', '123', '123', '123', '1994-04-01', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744346430/user_profile_pictures/user_profile_1744346430_67f89d3ed6e69.jpg', '2025-04-29 13:07:00', 'verified', '/storage/uploads/valid_ids/67ebb65c6aa5a_front_valid_id_2389568226844613097.jpg', '/storage/uploads/valid_ids/67ebb65c6b224_back_valid_id_back_2207045255775656039.jpg', '2025-04-10 20:54:20', '2025-04-10 20:54:12', '2025-04-01 17:48:12', '2025-04-10 20:54:20', 0, NULL),
	(48, 'David', 'Olerio', 'davis', 21, 'male', '497', 'ISU', 'Kalaw', '2003-12-22', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744341668/user_profile_pictures/user_profile_1744341668_67f88aa40e6b1.jpg', '2025-05-08 01:05:16', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744340946/user_valid_ids/user_id_1744340946_front_valid_id_67f887d26cad0.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744340947/user_valid_ids/user_id_1744340946_back_valid_id_back_67f887d2e9c2a.jpg', '2025-04-11 11:20:18', NULL, '2025-04-11 11:09:07', '2025-04-11 11:20:18', 0, NULL),
	(50, 'Clement Harold Miguel', 'Cabus', 'clement', 21, 'male', '678-b', 'Panam village', 'Hinar street', '2003-12-22', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746040095/user_profile_pictures/user_profile_1746040095_6812751f6240b.jpg', '2025-05-08 01:15:45', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745127796/user_valid_ids/user_id_1745127796_front_valid_id_680489743c61b.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745127796/user_valid_ids/user_id_1745127796_back_valid_id_back_68048974ac313.jpg', '2025-04-20 13:47:57', NULL, '2025-04-20 13:43:17', '2025-04-20 13:47:57', 0, NULL),
	(53, 'Joshua', 'Fernandez', 'joshfern12', 22, 'male', '123', 'Zone 3', 'Mangga St.', '2003-04-28', 'CKBpWa1yuo7rA/bGaJ2xGC8bHgHegi1VLoN1vQjPo4c=', 'default.jpg', '2025-04-28 09:37:43', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745804148/user_valid_ids/user_id_1745804148_front_valid_id_680edb74be809.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745804149/user_valid_ids/user_id_1745804149_back_valid_id_back_680edb7547937.jpg', '2025-04-28 09:36:09', NULL, '2025-04-28 09:35:50', '2025-04-28 09:36:09', 0, NULL),
	(54, 'Cleofe Maria', 'Cabus', 'cleofe', 57, 'female', '497', 'ISU Village', 'Village Kalaw', '1967-11-15', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745903599/user_profile_pictures/user_profile_1745903599_68105fef577d0.jpg', '2025-04-29 22:58:09', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745903455/user_valid_ids/user_id_1745903455_front_valid_id_68105f5f36caa.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1745903455/user_valid_ids/user_id_1745903455_back_valid_id_back_68105f5fbdadf.jpg', '2025-04-29 13:11:10', NULL, '2025-04-29 13:10:56', '2025-04-29 13:11:10', 0, NULL),
	(55, 'Harry', 'Houdini', 'harry', 32, 'male', '763-c', 'Panam Village', 'Lawin street', '1992-04-30', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746040914/user_profile_pictures/user_profile_1746040914_681278528f106.jpg', '2025-05-02 14:45:35', 'rejected', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746025045/user_valid_ids/user_id_1746025045_front_valid_id_68123a55bc321.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746025046/user_valid_ids/user_id_1746025046_back_valid_id_back_68123a56ac1d0.jpg', '2025-04-30 22:58:49', NULL, '2025-04-30 22:57:27', '2025-05-07 23:14:51', 1, '2025-05-07 23:14:51'),
	(56, 'James', 'Padilla', 'jamespadilla321', 25, 'male', '321', '123', 'Mangga', '2000-01-12', '1dyXO1Hqp9P3b+wVt48enk+BPL4AgxesK9hyy6V/jRY=', 'default.jpg', '2025-05-02 14:28:00', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746098324/user_valid_ids/user_id_1746098323_front_valid_id_68135893d9b16.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746098324/user_valid_ids/user_id_1746098324_back_valid_id_back_681358945bc66.jpg', '2025-05-01 19:23:38', NULL, '2025-05-01 19:18:44', '2025-05-01 19:23:38', 0, NULL),
	(57, 'Crazy', 'Nigga', 'hola', 20, 'male', '25', 'Alley 16', 'P. Rosales', '2004-10-01', 'pCclRjq3jfFzy0FaXVNgRFfQ5Y6AL3huAcGCcn3eALA=', 'default.jpg', '2025-05-01 23:08:43', 'rejected', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746111644/user_valid_ids/user_id_1746111644_front_valid_id_68138c9ca09d8.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746111645/user_valid_ids/user_id_1746111645_back_valid_id_back_68138c9d46c67.jpg', '2025-05-01 23:02:10', NULL, '2025-05-01 23:00:46', '2025-05-07 21:49:17', 1, '2025-05-07 21:49:17'),
	(58, 'Lucas', 'TheDig', 'LucasTheDig', 24, 'male', '123', 'Polar Village', 'Kalaw', '2000-10-17', 'kj1OCLK/cXIGeqTFeV1o0pz2hjm8WUCyFUG86ZzJjDQ=', 'default.jpg', '2025-05-05 13:06:02', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746163786/user_valid_ids/user_id_1746163786_front_valid_id_6814584ac08c6.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746163787/user_valid_ids/user_id_1746163787_back_valid_id_back_6814584b6e287.jpg', '2025-05-02 13:30:36', NULL, '2025-05-02 13:29:47', '2025-05-02 13:30:36', 0, NULL),
	(59, 'John', 'Doe', 'JohnDoe', 8, 'male', '123', 'Polar Village', 'Kalaw', '2016-05-19', 'kj1OCLK/cXIGeqTFeV1o0pz2hjm8WUCyFUG86ZzJjDQ=', 'default.jpg', '2025-05-02 15:01:10', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746167872/user_valid_ids/user_id_1746167872_front_valid_id_6814684087b81.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746167873/user_valid_ids/user_id_1746167873_back_valid_id_back_6814684112174.jpg', '2025-05-02 14:38:15', NULL, '2025-05-02 14:37:53', '2025-05-02 14:38:15', 0, NULL),
	(60, 'Chris', 'Redfield', 'chris', 0, 'male', '760', 'Louisiana', 'Baker Estate', '2025-05-06', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'default.jpg', '2025-05-06 20:38:26', 'verified', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746530668/user_valid_ids/user_id_1746530668_front_valid_id_6819f16c9f4b5.jpg', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1746530669/user_valid_ids/user_id_1746530669_back_valid_id_back_6819f16d3139a.jpg', '2025-05-06 19:24:51', NULL, '2025-05-06 19:24:29', '2025-05-06 19:24:51', 0, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
