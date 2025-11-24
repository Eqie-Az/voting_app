-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_voting.kandidat
CREATE TABLE IF NOT EXISTS `kandidat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_ketua` varchar(100) DEFAULT NULL,
  `nama_wakil` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `total_vote` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_voting.kandidat: ~2 rows (approximately)
INSERT INTO `kandidat` (`id`, `nama_ketua`, `nama_wakil`, `foto`, `total_vote`) VALUES
	(1, 'Rifqi Azhar Raditya', 'Mahsa Muhammad', '1762361694_690b815ed3664.png', 0),
	(2, 'Jovan Faizan Ardiyansyah', 'Muhammad Afifudin Zuhri', '1762361715_690b81733083b.png', 0);

-- Dumping structure for table db_voting.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `sudah_voting` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_voting.users: ~6 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `sudah_voting`) VALUES
	(2, 'Mahsa', 'mahsamuhammad@gmail.com', '$2y$10$Juc974vgtFf/Z7IPuxW3WOprrmB3ynVEUUG3Zf/W3SsLW7iOwkUwi', 'user', 0),
	(4, 'admin', 'admin@gmail.com', '$2y$10$MKE6D.vepdSYDYtQSwiUJOrvlCuwgHfmQ1IDhPD5v20OmdW6Ombjq', 'admin', 0),
	(5, 'Eqie', 'rifqiazharraditya@gmail.com', '$2y$10$OipXHyUun0lhNncsxu22P.rhkiMjc0G1OuzYEglTf.3TgOgS/q4Ki', 'user', 0),
	(6, 'Kayla', 'kaylahanifa@gmail.com', '$2y$10$Lq2nJY89t/ZSH2x0gTBEs.Dnfdsd7C7hR3aNWjbaH21XItiyJb9Z.', 'user', 0),
	(7, 'Jovan', 'jovan@gmail.com', '$2y$10$JfVxLBUWALguPfZrx0H7vONoS2NLdj/LWeUOUNGe.3WE8JlNqWodq', 'user', 0),
	(8, 'Apip', 'afif@gmail.com', '$2y$10$F.FLeiPJtUz46cFNuLq9Qugmju99lbuO2r37sQQO8JKworIHARoMi', 'user', 0),
	(9, 'Samid', 'dimas@gmail.com', '$2y$10$kUyF3NhsNZsyKQgRF5N/LOc1EfyRE5NU/IJ5Q04PX75o9/yZKdmmW', 'user', 0);

-- Dumping structure for table db_voting.voting
CREATE TABLE IF NOT EXISTS `voting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `kandidat_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `kandidat_id` (`kandidat_id`),
  CONSTRAINT `voting_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `voting_ibfk_2` FOREIGN KEY (`kandidat_id`) REFERENCES `kandidat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_voting.voting: ~4 rows (approximately)
INSERT INTO `voting` (`id`, `user_id`, `kandidat_id`) VALUES
	(3, 6, 1),
	(6, 7, 2),
	(9, 2, 1),
	(10, 8, 1),
	(13, 5, 1),
	(14, 9, 2);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
