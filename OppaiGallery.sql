-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2016 at 12:33 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `OppaiGallery`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `latest_medias`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `latest_medias` (IN `_count` INT)  SELECT * FROM `medias` M INNER JOIN `users` U ON M.user_id = U.user_id INNER JOIN `media_types` MT ON M.media_type_short_name = MT.media_type_short_name ORDER BY M.media_id DESC LIMIT _count$$

DROP PROCEDURE IF EXISTS `medias_by_tag`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `medias_by_tag` (IN `tag` VARCHAR(16) CHARSET utf8)  SELECT *
	FROM `medias_tags` ST
		INNER JOIN `medias` S ON ST.media_id = S.media_id
		INNER JOIN `users` U ON S.user_id = U.user_id
		INNER JOIN `media_types` M ON S.media_type_short_name = M.media_type_short_name
	WHERE ST.tag_name = tag$$

DROP PROCEDURE IF EXISTS `random_medias`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `random_medias` (IN `_count` INT)  SELECT * FROM medias M INNER JOIN users U ON M.user_id = U.user_id INNER JOIN media_types MT ON M.media_type_short_name = MT.media_type_short_name ORDER BY RAND() LIMIT _count$$

DROP PROCEDURE IF EXISTS `tags_count`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `tags_count` ()  SELECT * FROM (
    SELECT *, (
        SELECT COUNT(*)
        FROM medias_tags
        WHERE tag_name = T.tag_name
    ) AS tag_count
    FROM `tags` T
    ORDER BY tag_count DESC
) AS T
WHERE T.tag_count > 0$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `medias`
--

DROP TABLE IF EXISTS `medias`;
CREATE TABLE IF NOT EXISTS `medias` (
  `media_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `media_title` varchar(64) NOT NULL,
  `media_comment` varchar(128) NOT NULL,
  `media_url` varchar(2048) NOT NULL,
  `media_type_short_name` varchar(2) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `insane` int(1) NOT NULL,
  PRIMARY KEY (`media_id`,`user_id`,`media_type_short_name`),
  KEY `fk_media_type` (`media_type_short_name`),
  KEY `fk_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8;

--
-- Triggers `medias`
--
DROP TRIGGER IF EXISTS `delete_media`;
DELIMITER $$
CREATE TRIGGER `delete_media` BEFORE DELETE ON `medias` FOR EACH ROW DELETE FROM medias_tags WHERE media_id = OLD.media_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `medias_tags`
--

DROP TABLE IF EXISTS `medias_tags`;
CREATE TABLE IF NOT EXISTS `medias_tags` (
  `media_id` bigint(20) NOT NULL,
  `tag_name` varchar(16) NOT NULL,
  UNIQUE KEY `media_id` (`media_id`,`tag_name`),
  KEY `fk_tag` (`tag_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `media_types`
--

DROP TABLE IF EXISTS `media_types`;
CREATE TABLE IF NOT EXISTS `media_types` (
  `media_type_short_name` varchar(2) NOT NULL,
  `media_type_name` varchar(16) NOT NULL,
  PRIMARY KEY (`media_type_short_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `media_types`
--
DROP TRIGGER IF EXISTS `delete_media_type`;
DELIMITER $$
CREATE TRIGGER `delete_media_type` BEFORE DELETE ON `media_types` FOR EACH ROW DELETE FROM medias WHERE media_type_short_name = OLD.media_type_short_name
$$
DELIMITER ;

--
-- Dumping data for table `media_types`
--

INSERT INTO `media_types` (`media_type_short_name`, `media_type_name`) VALUES
('am', 'Anime'),
('dj', 'Doujinshi'),
('gm', 'Games'),
('im', 'Image'),
('mg', 'Manga'),
('rl', 'Real Life'),
('rp', 'Real Life Photo');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `tag_name` varchar(16) NOT NULL,
  PRIMARY KEY (`tag_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `tags`
--
DROP TRIGGER IF EXISTS `delete_tag`;
DELIMITER $$
CREATE TRIGGER `delete_tag` BEFORE DELETE ON `tags` FOR EACH ROW DELETE FROM medias_tags WHERE tag_name = OLD.tag_name
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_tag`;
DELIMITER $$
CREATE TRIGGER `update_tag` BEFORE UPDATE ON `tags` FOR EACH ROW INSERT INTO tags (tag_name) VALUES (NEW.tag_name)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `delete_user`;
DELIMITER $$
CREATE TRIGGER `delete_user` BEFORE DELETE ON `users` FOR EACH ROW DELETE FROM medias WHERE user_id = OLD.user_id
$$
DELIMITER ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`) VALUES
(1, 'root');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medias`
--
ALTER TABLE `medias`
  ADD CONSTRAINT `fk_media_type` FOREIGN KEY (`media_type_short_name`) REFERENCES `media_types` (`media_type_short_name`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `medias_tags`
--
ALTER TABLE `medias_tags`
  ADD CONSTRAINT `fk_media` FOREIGN KEY (`media_id`) REFERENCES `medias` (`media_id`),
  ADD CONSTRAINT `fk_tag` FOREIGN KEY (`tag_name`) REFERENCES `tags` (`tag_name`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
