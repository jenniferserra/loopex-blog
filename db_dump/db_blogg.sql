-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Tid vid skapande: 17 nov 2016 kl 09:40
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
(1, 'Sport'),
(2, 'Mode'),
(3, 'Fotografi'),
(4, 'Annat');

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
  `user_id` int(255) NOT NULL,
  `cat_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `posts`
--

INSERT INTO `posts` (`post_id`, `create_time`, `edit_time`, `title`, `text`, `is_published`, `user_id`, `cat_id`) VALUES
(1, '2016-11-16 22:07:28.000000', '0000-00-00 00:00:00.000000', 'Nu kÃ¶r vi', 'Vi provar igen', 1, 14, 0),
(2, '2016-11-16 22:10:28.000000', '0000-00-00 00:00:00.000000', 'h', 'h', 1, 14, 0),
(3, '2016-11-16 22:17:13.000000', '0000-00-00 00:00:00.000000', 'fa', 'fa', 1, 14, 0),
(4, '2016-11-16 22:20:12.000000', '0000-00-00 00:00:00.000000', 'jjj', 'jjj', 1, 14, 0),
(5, '2016-11-16 22:20:19.000000', '0000-00-00 00:00:00.000000', 'kkkk', 'kkkk', 1, 14, 0),
(6, '2016-11-16 22:21:48.000000', '0000-00-00 00:00:00.000000', 'kkkk', 'kkkk', 1, 14, 2),
(7, '2016-11-16 22:21:55.000000', '0000-00-00 00:00:00.000000', 'jojojo', 'jojojo', 1, 14, 2),
(8, '2016-11-16 22:28:41.000000', '0000-00-00 00:00:00.000000', 'Hej, nu funkar det som det ska', 'HÃ„r kan vi till exempel kÃ¶ra kategori "annat"', 1, 14, 2),
(9, '2016-11-16 22:29:37.000000', '0000-00-00 00:00:00.000000', 'Hej, nu funkar det som det ska', 'HÃ„r kan vi till exempel kÃ¶ra kategori "annat"', 1, 14, 0),
(10, '2016-11-16 22:29:44.000000', '0000-00-00 00:00:00.000000', 's', 's', 1, 14, 0),
(11, '2016-11-16 22:30:48.000000', '0000-00-00 00:00:00.000000', 's', 's', 1, 14, 4),
(12, '2016-11-16 22:30:54.000000', '0000-00-00 00:00:00.000000', 'j', 'j', 1, 14, 4),
(13, '2016-11-16 22:31:07.000000', '0000-00-00 00:00:00.000000', 'i', 'i', 1, 14, 3),
(14, '2016-11-16 22:35:51.000000', '0000-00-00 00:00:00.000000', 'hehe', 'hehe', 1, 14, 2),
(15, '2016-11-16 22:41:14.000000', '0000-00-00 00:00:00.000000', 'hehe', 'hehe', 1, 14, 0),
(16, '2016-11-16 22:41:28.000000', '0000-00-00 00:00:00.000000', 'Hej Ã¥ hÃ¥', 'Nu ska vi prova', 1, 14, 3),
(17, '2016-11-16 22:43:58.000000', '0000-00-00 00:00:00.000000', 'Hej Ã¥ hÃ¥', 'Nu ska vi prova', 1, 14, 0),
(18, '2016-11-16 22:44:09.000000', '0000-00-00 00:00:00.000000', 'ghert', 'ghert', 1, 14, 3),
(19, '2016-11-16 22:44:54.000000', '0000-00-00 00:00:00.000000', 'ghert', 'ghert', 1, 14, 3),
(20, '2016-11-16 22:45:09.000000', '0000-00-00 00:00:00.000000', 'fas', 'asdf', 1, 14, 1),
(21, '2016-11-16 22:52:56.000000', '0000-00-00 00:00:00.000000', 'EH', 'EH', 1, 14, 1),
(22, '2016-11-16 22:53:08.000000', '0000-00-00 00:00:00.000000', 'EH', 'EH', 1, 14, 1),
(23, '2016-11-16 22:54:17.000000', '0000-00-00 00:00:00.000000', 'EH', 'EH', 1, 14, 1),
(24, '2016-11-16 22:54:25.000000', '0000-00-00 00:00:00.000000', 'EH', 'EH', 1, 14, 1),
(25, '2016-11-16 23:07:16.000000', '0000-00-00 00:00:00.000000', 'EH', 'EH', 1, 14, 1),
(26, '2016-11-16 23:10:43.000000', '0000-00-00 00:00:00.000000', 'EH', 'EH', 1, 14, 0),
(27, '2016-11-16 23:11:49.000000', '0000-00-00 00:00:00.000000', 'EH', 'EH', 1, 14, 1),
(28, '2016-11-16 23:12:07.000000', '0000-00-00 00:00:00.000000', 'EH', 'EH', 1, 14, 1),
(29, '2016-11-16 23:12:25.000000', '0000-00-00 00:00:00.000000', 'gggggg', 'gggggg', 1, 14, 2),
(30, '2016-11-16 23:14:22.000000', '0000-00-00 00:00:00.000000', 'gggggg', 'gggggg', 1, 14, 2),
(31, '2016-11-16 23:14:27.000000', '0000-00-00 00:00:00.000000', 'gggggg', 'gggggg', 1, 14, 2),
(32, '2016-11-16 23:14:45.000000', '0000-00-00 00:00:00.000000', 'Hej nu skriver vi ett nytt', 'Ett nytt inlÃ¤gg bÃ¶r man skirva', 1, 14, 3),
(33, '2016-11-16 23:15:29.000000', '0000-00-00 00:00:00.000000', 'Hej nu skriver vi ett nytt', 'Ett nytt inlÃ¤gg bÃ¶r man skirva', 1, 14, 3),
(34, '2016-11-16 23:15:32.000000', '0000-00-00 00:00:00.000000', 'Hej nu skriver vi ett nytt', 'Ett nytt inlÃ¤gg bÃ¶r man skirva', 1, 14, 3),
(35, '2016-11-16 23:15:42.000000', '0000-00-00 00:00:00.000000', 'HejjÃ¥', 'hejjpan', 1, 14, 1),
(36, '2016-11-16 23:15:45.000000', '0000-00-00 00:00:00.000000', 'HejjÃ¥', 'hejjpan', 1, 14, 1),
(37, '2016-11-16 23:16:56.000000', '0000-00-00 00:00:00.000000', 'HejjÃ¥', 'hejjpan', 1, 14, 1),
(38, '2016-11-16 23:17:05.000000', '0000-00-00 00:00:00.000000', 'HejjÃ¥', 'hejjpan', 1, 14, 1),
(39, '2016-11-16 23:18:15.000000', '0000-00-00 00:00:00.000000', 'tjosan', 'sportona', 1, 14, 1),
(40, '2016-11-16 23:20:35.000000', '0000-00-00 00:00:00.000000', 'tjosan', 'sportona', 1, 14, 1),
(41, '2016-11-16 23:20:37.000000', '0000-00-00 00:00:00.000000', 'tjosan', 'sportona', 1, 14, 1),
(42, '2016-11-16 23:20:58.000000', '0000-00-00 00:00:00.000000', 'nya saker', 'nya saker', 1, 14, 4),
(43, '2016-11-16 23:22:28.000000', '0000-00-00 00:00:00.000000', 'nya saker', 'nya saker', 1, 14, 4),
(44, '2016-11-16 23:23:02.000000', '0000-00-00 00:00:00.000000', 'nya saker', 'nya saker', 1, 14, 4),
(45, '2016-11-16 23:23:52.000000', '0000-00-00 00:00:00.000000', 'nya saker', 'nya saker', 1, 14, 4),
(46, '2016-11-16 23:23:59.000000', '0000-00-00 00:00:00.000000', 'nya saker', 'nya saker', 1, 14, 4),
(47, '2016-11-16 23:25:22.000000', '0000-00-00 00:00:00.000000', 'nya saker', 'nya saker', 1, 14, 4),
(48, '2016-11-16 23:25:31.000000', '0000-00-00 00:00:00.000000', 'jo', 'jo', 1, 14, 3),
(49, '2016-11-16 23:26:40.000000', '0000-00-00 00:00:00.000000', 'jo', 'jo', 1, 14, 3),
(50, '2016-11-16 23:29:46.000000', '0000-00-00 00:00:00.000000', 'jo', 'jo', 1, 14, 3),
(51, '2016-11-16 23:30:00.000000', '0000-00-00 00:00:00.000000', 'jo', 'jo', 1, 14, 3),
(52, '2016-11-16 23:31:05.000000', '0000-00-00 00:00:00.000000', 'jo', 'jo', 1, 14, 3),
(53, '2016-11-16 23:31:20.000000', '0000-00-00 00:00:00.000000', 'Nu ska vi lkÃ¶ra', 'hehe', 1, 14, 3),
(54, '2016-11-16 23:31:27.000000', '0000-00-00 00:00:00.000000', 'Nu ska vi lkÃ¶ra', 'hehe', 1, 14, 3),
(55, '2016-11-16 23:31:37.000000', '0000-00-00 00:00:00.000000', 'Nu ska vi lkÃ¶ra', 'hehe', 1, 14, 3),
(56, '2016-11-16 23:32:59.000000', '0000-00-00 00:00:00.000000', 'Nu ska vi lkÃ¶ra', 'hehe', 1, 14, 3),
(57, '2016-11-16 23:33:10.000000', '0000-00-00 00:00:00.000000', 'grymt', 'sa grisen', 1, 14, 4),
(58, '2016-11-16 23:33:13.000000', '0000-00-00 00:00:00.000000', 'grymt', 'sa grisen', 1, 14, 4),
(59, '2016-11-16 23:33:15.000000', '0000-00-00 00:00:00.000000', 'grymt', 'sa grisen', 1, 14, 4),
(60, '2016-11-16 23:34:35.000000', '0000-00-00 00:00:00.000000', 'grymt', 'sa grisen', 1, 14, 4),
(61, '2016-11-16 23:34:43.000000', '0000-00-00 00:00:00.000000', 'tjo', 'bra', 1, 14, 2),
(62, '2016-11-16 23:34:46.000000', '0000-00-00 00:00:00.000000', 'tjo', 'bra', 1, 14, 2),
(63, '2016-11-16 23:34:49.000000', '0000-00-00 00:00:00.000000', 'tjo', 'bra', 1, 14, 2),
(64, '2016-11-16 23:35:43.000000', '0000-00-00 00:00:00.000000', 'tjo', 'bra', 1, 14, 2),
(65, '2016-11-16 23:36:08.000000', '0000-00-00 00:00:00.000000', 'tjo', 'bra', 1, 14, 2),
(66, '2016-11-16 23:39:35.000000', '0000-00-00 00:00:00.000000', 'tjo', 'bra', 1, 14, 2),
(67, '2016-11-16 23:39:41.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 1, 14, 1),
(68, '2016-11-16 23:39:44.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 1, 14, 1),
(69, '2016-11-16 23:39:45.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 1, 14, 1),
(70, '2016-11-16 23:39:56.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 0, 14, 3),
(71, '2016-11-16 23:39:59.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 0, 14, 3),
(72, '2016-11-16 23:40:01.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 0, 14, 3),
(73, '2016-11-16 23:44:12.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 0, 14, 3),
(74, '2016-11-16 23:44:59.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 0, 14, 3),
(75, '2016-11-16 23:45:16.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 0, 14, 3),
(76, '2016-11-16 23:45:22.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 0, 14, 3),
(77, '2016-11-16 23:45:33.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 0, 14, 3),
(78, '2016-11-16 23:45:37.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 0, 14, 3),
(79, '2016-11-16 23:45:45.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 0, 14, 3),
(80, '2016-11-16 23:49:31.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 0, 14, 3),
(81, '2016-11-16 23:50:07.000000', '0000-00-00 00:00:00.000000', 'asdf', 'asdf', 0, 14, 3),
(82, '2016-11-16 23:50:23.000000', '0000-00-00 00:00:00.000000', 'Publicera', 'Publicera', 1, 14, 1),
(83, '2016-11-16 23:50:28.000000', '0000-00-00 00:00:00.000000', 'Publicera', 'Publicera', 1, 14, 1),
(84, '2016-11-16 23:50:33.000000', '0000-00-00 00:00:00.000000', 'Publicera', 'Publicera', 1, 14, 1),
(85, '2016-11-16 23:51:07.000000', '0000-00-00 00:00:00.000000', 'Publicera2', 'Publicera2', 1, 14, 1),
(86, '2016-11-16 23:51:12.000000', '0000-00-00 00:00:00.000000', 'Publicera2', 'Publicera2', 1, 14, 1),
(87, '2016-11-16 23:51:14.000000', '0000-00-00 00:00:00.000000', 'Publicera2', 'Publicera2', 1, 14, 1),
(88, '2016-11-16 23:51:24.000000', '0000-00-00 00:00:00.000000', 'Draft', 'Draft', 0, 14, 2),
(89, '2016-11-16 23:51:27.000000', '0000-00-00 00:00:00.000000', 'Draft', 'Draft', 0, 14, 2),
(90, '2016-11-16 23:51:28.000000', '0000-00-00 00:00:00.000000', 'Draft', 'Draft', 0, 14, 2),
(91, '2016-11-16 23:51:30.000000', '0000-00-00 00:00:00.000000', 'Draft', 'Draft', 0, 14, 2),
(92, '2016-11-16 23:55:48.000000', '0000-00-00 00:00:00.000000', 'Draft', 'Draft', 0, 14, 2),
(93, '2016-11-16 23:57:52.000000', '0000-00-00 00:00:00.000000', 'Draft', 'Draft', 0, 14, 2),
(94, '2016-11-17 00:00:36.000000', '0000-00-00 00:00:00.000000', 'Draft', 'Draft', 0, 14, 2);

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
(13, 'nyanvÃ¤ndare', 'nyanvÃ¤ndare', 'nyanvandare@hej.com', '$2y$10$jhdPVy9vv.AKnU1MPvZdAuFDEJn.aBfHqT43gAzIATJW.HD3aUR4O', ''),
(14, 'j', 'j', 'j@j.com', '$2y$10$08ihyCESRw2O/MDzKRkfP.k442yqukaa8fiHNKm8DQiDuZPWm6RDu', '');

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
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cat_id` (`cat_id`);

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
  MODIFY `cat_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT för tabell `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT för tabell `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;