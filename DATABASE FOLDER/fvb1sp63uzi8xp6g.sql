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

-- Dumping data for table fvb1sp63uzi8xp6g.admin_accounts: ~3 rows (approximately)
INSERT IGNORE INTO `admin_accounts` (`id`, `name`, `username`, `password`, `profile_picture`, `created_at`, `updated_at`) VALUES
	(1, 'Rannie Camba', 'rannie', '$2y$12$TCA6Q9wgT7OCs62A7W4q5ef1QPPEBXsz7WRan8zv8/y8v01u8vr/e', 'https://res.cloudinary.com/hwovp9krt/image/upload/v1744287281/admin_profile_pictures/admin_1_1744287281.png', NULL, '2025-04-10 20:14:42'),
	(4, 'Quirino Saruno', 'saruno', 'Password@', 'assets/admin_profile_pictures/1733971040_a79b3e17-90b7-49d0-98ea-e3208f8dd1ef.png', NULL, NULL),
	(15, 'Admin 3', 'admin3', '$2y$12$TCA6Q9wgT7OCs62A7W4q5ef1QPPEBXsz7WRan8zv8/y8v01u8vr/e', '', NULL, NULL);

-- Dumping data for table fvb1sp63uzi8xp6g.barangay_announcements: ~0 rows (approximately)

-- Dumping data for table fvb1sp63uzi8xp6g.cache: ~0 rows (approximately)
INSERT IGNORE INTO `cache` (`key`, `value`, `expiration`) VALUES
	('barangay_management_system_cache_08ce9dce8170e964e09c32545695f727', 'i:1;', 1744279545),
	('barangay_management_system_cache_08ce9dce8170e964e09c32545695f727:timer', 'i:1744279545;', 1744279545),
	('barangay_management_system_cache_4efff9fd1edb0b2ebcd75cdc0263bff5', 'i:1;', 1744260657),
	('barangay_management_system_cache_4efff9fd1edb0b2ebcd75cdc0263bff5:timer', 'i:1744260657;', 1744260657),
	('barangay_management_system_cache_58b7f5712aaa1862a011a41e2bdfaf70', 'i:1;', 1744336218),
	('barangay_management_system_cache_58b7f5712aaa1862a011a41e2bdfaf70:timer', 'i:1744336218;', 1744336218),
	('barangay_management_system_cache_6acc119dd58b1a6a8ffbc97c71d50d9b', 'i:1;', 1744274439),
	('barangay_management_system_cache_6acc119dd58b1a6a8ffbc97c71d50d9b:timer', 'i:1744274439;', 1744274439),
	('barangay_management_system_cache_6e44331b4e63509763c5bd8e8a33643b', 'i:1;', 1744285235),
	('barangay_management_system_cache_6e44331b4e63509763c5bd8e8a33643b:timer', 'i:1744285235;', 1744285235),
	('barangay_management_system_cache_7260056b391e58d8457f76336ba3ae75', 'i:1;', 1744303404),
	('barangay_management_system_cache_7260056b391e58d8457f76336ba3ae75:timer', 'i:1744303404;', 1744303404),
	('barangay_management_system_cache_77ed66684c3d47d0ac25812d2619c724', 'i:1;', 1744278029),
	('barangay_management_system_cache_77ed66684c3d47d0ac25812d2619c724:timer', 'i:1744278029;', 1744278029),
	('barangay_management_system_cache_7f129c1b3a3a2ad934ea9e3e93c87f36', 'i:1;', 1744287193),
	('barangay_management_system_cache_7f129c1b3a3a2ad934ea9e3e93c87f36:timer', 'i:1744287193;', 1744287193),
	('barangay_management_system_cache_90cac04b54f47199d3fbecf27cefdabe', 'i:1;', 1744278023),
	('barangay_management_system_cache_90cac04b54f47199d3fbecf27cefdabe:timer', 'i:1744278023;', 1744278023),
	('barangay_management_system_cache_b1fa0729d6c8ab952788345b6f02543e', 'i:1;', 1744270270),
	('barangay_management_system_cache_b1fa0729d6c8ab952788345b6f02543e:timer', 'i:1744270270;', 1744270270),
	('barangay_management_system_cache_fc0eab601af9abd16650155c3b0baab8', 'i:1;', 1744287251),
	('barangay_management_system_cache_fc0eab601af9abd16650155c3b0baab8:timer', 'i:1744287251;', 1744287251),
	('barangay_management_system_cache_rannie|10.1.26.229', 'i:1;', 1744278023),
	('barangay_management_system_cache_rannie|10.1.26.229:timer', 'i:1744278023;', 1744278023);

-- Dumping data for table fvb1sp63uzi8xp6g.cache_locks: ~0 rows (approximately)

-- Dumping data for table fvb1sp63uzi8xp6g.document_requests: ~0 rows (approximately)

-- Dumping data for table fvb1sp63uzi8xp6g.incident_reports: ~0 rows (approximately)

-- Dumping data for table fvb1sp63uzi8xp6g.messages: ~0 rows (approximately)

-- Dumping data for table fvb1sp63uzi8xp6g.migrations: ~0 rows (approximately)

-- Dumping data for table fvb1sp63uzi8xp6g.password_reset_tokens: ~0 rows (approximately)

-- Dumping data for table fvb1sp63uzi8xp6g.personal_access_tokens: ~0 rows (approximately)

-- Dumping data for table fvb1sp63uzi8xp6g.sessions: ~0 rows (approximately)
INSERT IGNORE INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('0K8yftr593lz8WNT54tVSqJmLxIUl0hlrd9awLJl', NULL, '10.1.28.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSTlDelBTbm11QXFtbFNnUEdmWEdJWXNsMVN5NWFyMzlHa2dmVmE3ayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744269654),
	('0OM1Ct0OfnkOaS80FIAWQBYawf1bQNU2XkNcVCQy', NULL, '10.1.31.72', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTUZDOHhxRjVZOWJQbVF3c2x2akJBTkhoczhPZ055S0dHT3BzZ0hHUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744258060),
	('1XyyTmZRUGRDhpZ3vYhFNBcEW8BnKmnBeIXYBpia', NULL, '10.1.30.206', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmg1Mk5BM0ppenZtR3BjS3QzVGw3VFpPaXcxMEZMUXRzZFNSS0ZVZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL2xvZ2luIjt9fQ==', 1744257879),
	('2ukCQW2rEILEmJIdDZFyr43KD5PIs2LVEnCO21rd', NULL, '10.1.87.177', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTGs4eGJGTlBMWUdiZ2d6S2FvWnAzUVdhRVNEZ3NrWFFZZUg1M2JBTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744268653),
	('3jXnzEFJSBN6u2SUh4voBZpau8LGxzh2WlSH1r3A', NULL, '10.1.38.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZ2FBc284TVNhNU9pZHdpTk95NDZyWHZ5UlEyTU9qVE5WSTJZNUd1ZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744257666),
	('8Kuo9BgMiAu71sdzVrSDSz0FMb7bdmqjyzqL8pCB', NULL, '10.1.12.133', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTkZYck42eElXamJyckJxcWJpdHIwWkVEenl6MUJUWmF5RFlrcmpjcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wb3N0cHJvcGVyYWRtaW5sYXJhdmVsLWEzYzczNTI5YzZiNi5oZXJva3VhcHAuY29tL2xvZ2luIjt9fQ==', 1744269648),
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

-- Dumping data for table fvb1sp63uzi8xp6g.status_change_logs: ~0 rows (approximately)

-- Dumping data for table fvb1sp63uzi8xp6g.user_accounts: ~0 rows (approximately)
INSERT IGNORE INTO `user_accounts` (`id`, `firstName`, `lastName`, `username`, `age`, `gender`, `adrHouseNo`, `adrZone`, `adrStreet`, `birthday`, `password`, `user_profile_picture`, `last_active`, `status`, `user_valid_id`, `user_valid_id_back`, `verified_at`, `rejected_at`, `created_at`, `updated_at`) VALUES
	(47, 'Kat', 'Arina', 'kat', 31, 'male', '123', '123', '123', '1994-04-01', '1IdXOTyMch/yApTuQoriJvEFXv01l0HTxEPvvwk6w0g=', 'storage/uploads/user_profile_pictures/1743525635_67ec170325c66.jpg', '2025-04-10 21:03:51', 'verified', '/storage/uploads/valid_ids/67ebb65c6aa5a_front_valid_id_2389568226844613097.jpg', '/storage/uploads/valid_ids/67ebb65c6b224_back_valid_id_back_2207045255775656039.jpg', '2025-04-10 20:54:20', '2025-04-10 20:54:12', '2025-04-01 17:48:12', '2025-04-10 20:54:20');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
