-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Tid vid skapande: 15 nov 2016 kl 00:09
-- Serverversion: 10.1.16-MariaDB
-- PHP-version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `db_blogg`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(255) NOT NULL,
  `cat_name` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(1, '1'),
(2, '1'),
(3, '1'),
(4, '2'),
(5, '2');

-- --------------------------------------------------------

--
-- Tabellstruktur `comments`
--

CREATE TABLE `comments` (
  `com_id` int(255) NOT NULL,
  `create_time` datetime(6) NOT NULL,
  `edit_time` datetime(6) NOT NULL,
  `text` text COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `fk_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `posts`
--

CREATE TABLE `posts` (
  `post_id` int(255) NOT NULL,
  `create_time` datetime(6) NOT NULL,
  `edit_time` datetime(6) NOT NULL,
  `title` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `text` text COLLATE utf8_swedish_ci NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `fk_user_id` int(255) NOT NULL,
  `fk_cat_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `posts`
--

INSERT INTO `posts` (`post_id`, `create_time`, `edit_time`, `title`, `text`, `is_published`, `fk_user_id`, `fk_cat_id`) VALUES
(1, '2016-11-14 22:35:43.000000', '0000-00-00 00:00:00.000000', 'huuul', 'huuul', 1, 13, 0),
(2, '2016-11-14 22:35:55.000000', '0000-00-00 00:00:00.000000', 'Hej', 'Jag vill kÃ¶pa glass', 1, 13, 0),
(3, '2016-11-14 22:36:02.000000', '0000-00-00 00:00:00.000000', 'Hej', 'Jag vill kÃ¶pa glass', 1, 13, 0),
(4, '2016-11-14 22:36:49.000000', '0000-00-00 00:00:00.000000', 'GÃ¶r', 'nÃ¥t', 1, 13, 0),
(5, '2016-11-14 22:59:13.000000', '0000-00-00 00:00:00.000000', 'GÃ¶r', 'nÃ¥t', 1, 13, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `firstname` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `profilepic` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci COMMENT='Användardatabasen';

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `password`, `profilepic`) VALUES
(1, '', '$2y$10$jdEfU9KFHbBEu8aIplnCQeNTPKfi/wI5aZ8/QryDQE9X77WwTX/K.', '', '', ''),
(2, '', '$2y$10$bgsuTsqN67o4ovQb5xdLvuWFf7xwSe2ajcbn6bX.oXLJ8DfqCFDt.', '', '', ''),
(3, '', '$2y$10$RWsVVVx7elUhKO.XqiVt7eQudVL6OzlZIoUFwqE6HtMPBvLgFTzSq', '', '', ''),
(4, '', '$2y$10$IA5XcRX1OF3/2IQUZBaXbezusbG4msB0tNRWyPkE4hEWq77z5jQYq', '', '', ''),
(5, 'o@o.com', '$2y$10$tqVGBMIZFMjaJ92fsOnzHOScwZ2F0OavGG.3.g54KkY7U8zpnIcAG', 'o', 'o', ''),
(6, 'o@o.com', '$2y$10$/J/3ctI/JBxbycN/Lo6XJekex977xSjaCx0MOESm6BSfbPlY/tOii', 'o', 'o', ''),
(7, 'oh@oh.com', '$2y$10$363r.k4QxMeTticbS0/jMOoDebLJQWYgiGpVyiy464fEwc72xx1l6', 'oh', 'oh', ''),
(8, 'oh@oh.com', '$2y$10$yTC3yLiR.x2BKywuKQXtVOJJNr/gNNwH0kZ52FPU4h5i8fuiB32B.', 'oh', 'oh', ''),
(9, 'jo@jo.com', '$2y$10$r/uHKSWBjL6i2oMhYIHhs.vG8QlYb9GKUPzanWXQTrt7lDPCnhz6K', 'jo', 'jo', ''),
(10, 'joho@joho.com', '$2y$10$PopwRgxiBLuPkFuJkNAkcOMuPIdRHL2rv6SYOcfVxv7dI7F1Mi3k.', 'jo', 'jo@jo.com', ''),
(11, 'je', 'je', 'je@je.com', '$2y$10$.lhbSFLF4xMRaDuiPGLq5.kRJ13uc3ZxyDFM5sE0HeiOG4FK/VFIO', ''),
(12, 'test', 'test', 'test@test.com', '$2y$10$NF8iGWOkO186kHx71n/.6uwuBU3hNc28.aR3Wyq3olQM/obQtpiAy', ''),
(13, 'nyanvÃ¤ndare', 'nyanvÃ¤ndare', 'nyanvandare@hej.com', '$2y$10$jhdPVy9vv.AKnU1MPvZdAuFDEJn.aBfHqT43gAzIATJW.HD3aUR4O', '');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Index för tabell `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`);

--
-- Index för tabell `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT för tabell `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT för tabell `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
