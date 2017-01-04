-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 04, 2017 at 07:52 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_blogg`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(255) NOT NULL,
  `cat_name` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(14, 'Festival'),
(15, 'Rock'),
(16, 'Pop'),
(17, 'Indie-pop'),
(18, 'Jazz'),
(19, 'KÃ¤ndisar'),
(20, 'Rykten');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(255) NOT NULL,
  `name` text COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `create_time` datetime(6) NOT NULL,
  `text` text COLLATE utf8_swedish_ci NOT NULL,
  `fk_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`com_id`, `name`, `email`, `create_time`, `text`, `fk_post_id`) VALUES
(108, 'Sana Karlsson', 'sara@hotmail.com', '2017-01-04 19:37:16.000000', 'Neeeeej! <br>\r\nDet kÃ¤nns sÃ¥ himla trÃ¥kigt att inte fÃ¥ se spelningen som jag har lÃ¤ngtat sÃ¥ mycket efter. Jag hoppas att bandet mÃ¥r bra och att inget allvarligt har hÃ¤nt. <br>\r\nVi ses nÃ¤sta gÃ¥ng! ', 222),
(109, 'Lucas', 'Lucas@gmail.com', '2017-01-04 19:38:12.000000', 'Men fÃ¶r i helvete grabbar!! <br>\r\nStÃ¤ll upp pÃ¥ en jÃ¤vla spelning i Sverige. Jag har ju redan kÃ¶pt tÃ¥gbiljetter och betalt fÃ¶r hotell. TrÃ¥kigt....', 222),
(110, 'Lucie', 'lucie@gmail.com', '2017-01-04 19:39:24.000000', 'Jag Ã¶nskar att jag var en rysk rik miljardÃ¤r som har rÃ¥d att boka in dessa stjÃ¤rnor', 228),
(111, 'Nora', 'nora.h@hotmail.com', '2017-01-04 19:40:10.000000', 'OMG, herregud, wow <br>\r\nKolla in videon, sÃ¥ himla coolt!', 228),
(112, 'Eva Norrsken', 'eva.norrsken@gaffa.se', '2017-01-04 19:41:16.000000', 'Jag hÃ¥ller verkligen med. <br>\r\nThe Crams omslag Ã¤r grymt snygga!!', 226),
(113, 'Bellaroush', 'bellaroush@hotmail.com', '2017-01-04 19:44:01.000000', 'Kolla in vÃ¥r video <a href="https://www.youtube.com/watch?v=1-65SE7Dhlk&feature=youtu.be" target="_blank" style="color: #F00;">hÃ¤r</a> <br> \r\n/ Bellaroush\r\n', 225),
(114, 'Felix', 'felix.b@hotmail.com', '2017-01-04 19:44:56.000000', 'Skitsnyggt gjort bandet och bra budskap!', 225),
(115, 'Agneta ', 'agneta@hotmail.com', '2017-01-04 19:46:00.000000', 'Jag tycker dock att "Dancing Queen" Ã¤r den bÃ¤sta lÃ¥ten med ABBA', 224);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
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
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `create_time`, `edit_time`, `title`, `text`, `is_published`, `user_id`, `cat_id`) VALUES
(222, '2016-11-14 19:12:06.000000', '0000-00-00 00:00:00.000000', 'Bon Iver stÃ¤ller in sina Sverigespelningar â€“ lÃ¤s det officiella uttalandet', 'Det Ã¤r med sorg vi fÃ¥r till oss nyheten att Bon Iver stÃ¤ller in hela sin EuropaturnÃ©, inklusive de tvÃ¥ spelningarna i Stockholm, 30 och 31 januari.\r\n\r\nPÃ¥ sin officiella Facebook lÃ¤mnar han fÃ¶ljande meddelande:\r\n\r\n"Det Ã¤r med stor sorg som vi mÃ¥ste meddela annullering av vÃ¥ra kommande european tour och justin Ã¤r planerade utseende pÃ¥ A Prairie Home Companion denna mÃ¥nad."', 1, 34, 14),
(223, '2016-11-25 19:14:40.000000', '0000-00-00 00:00:00.000000', 'HÃ¶r ny house-version av Kents "Du & Jag DÃ¶den"-klassiker', 'Kent lÃ¤mnade oss fÃ¶r nÃ¥gra veckor sedan. Det har vÃ¤l ingen missat. FÃ¶rmodligen inte heller producenten Axel E som idag skickar ut nedanstÃ¥ende deep house-version av Du & Jag DÃ¶den-klassikern 400 Slag.\r\n\r\nPÃ¥ sin Soundcloud-sida lÃ¤gger han till ett "I do not intend to make any money or infringe any copyrights with this remix. For promotional purposes only."\r\n\r\nMen visst har den potential att bli en Summerburst-hit?', 1, 36, 16),
(224, '2016-12-31 18:15:45.000000', '0000-00-00 00:00:00.000000', 'HÃ¤r Ã¤r nyÃ¥rsaftons mest spelade lÃ¥tar', 'Idag gÃ¥r Spotify ut med vilka lÃ¥tar som var mest spelade under nyÃ¥rsafton i Sverige och globalt. Och nej, hÃ¤r finns ingen Happy New Year med ABBA. Varken i den inhemska eller den internationella. Men vÃ¤l nÃ¥gra riktiga house-dÃ¤ngor och givetvis en av 2016 Ã¥rs bÃ¤sta och mest lyssnade lÃ¥t, Starboy, med The Weeknd.', 1, 36, 17),
(225, '2017-01-03 12:16:40.000000', '0000-00-00 00:00:00.000000', 'VIDEOPREMIÃ„R: Bellaroush uppmÃ¤rksammar vÃ¥r skuld till klimatet', 'Singeln Insecticides Ã¤r en dramatisk skildring av skuld. Videon fÃ¶rstÃ¤rker det mÃ¶rker som texten mÃ¥lande beskriver: om hur vi pÃ¥ planeten accelererar klimatfÃ¶rÃ¤ndring och hur tilltron till individuella val snarare konserverar istÃ¤llet fÃ¶r att fÃ¶rÃ¤ndra.\r\n\r\nKlippen till Insecticides har filmats i GÃ¶teborg av Rickard Olausson. Samma person stÃ¥r ocksÃ¥ fÃ¶r regi tillsammans med Magnus HagstrÃ¶m frÃ¥n Bellaroush. Dessutom spelar Nelly Daltrey frÃ¥n bandet Pale Honey huvudrollen i videon som vi premiÃ¤rvisar hÃ¤r ovanfÃ¶r.\r\n\r\nBellaroush jobbar just nu med nytt material som Ã¤r planerat att slÃ¤ppas under vÃ¥ren 2017. 2016 har varit bandets mest intensiva Ã¥r hittills och kickade igÃ¥ng med gruppens andra IndienturnÃ©. Den fÃ¶ljdes upp av en omfattande kontinentturnÃ© i Tyskland, Holland, Spanien och Portugal. DÃ¤refter gjordes festivalspelningar pÃ¥ bland annat danska Thy Lejren och Ã–land Roots, dÃ¤r Bellaroush kallades fÃ¶r Sveriges mest jÃ¤mstÃ¤llda band.', 1, 35, 16),
(226, '2017-01-03 19:18:07.000000', '0000-00-00 00:00:00.000000', '"Alla The Cramps omslag Ã¤r ju genialiska"', 'Rome Is Not A Town tog oss med storm 2016. Mer given rÃ¥ rock med ett smutsigt gitarrsound som hÃ¤mtat frÃ¥n 90-talets altrock-scen fÃ¥r man leta efter. Gruppen slÃ¤ppte en EP i slutet pÃ¥ Ã¥ret och vi tyckte det var lÃ¤ge att kolla av hur omslaget till slÃ¤ppet kom till. Bandmedlemmen Kajsa Poidnak svarar pÃ¥ vÃ¥ra frÃ¥gor och levererar Ã¤ven fem favoritomslag. \r\n\r\nNÃ¤r det gÃ¤ller omslag gillar Rome Is Not A Town idÃ©n Ã¶verlÃ¥ta det visuella till nÃ¥gon de beundrar.\r\n\r\nâ€“ Vi skickade Ã¶ver vÃ¥r EP till Ylva Holmdahl (frÃ¥n Wildhart) tillsammans med texten â€tÃ¤nker att kÃ¤nslan Ã¤r lite som den tÃ¶ntiga kompisen som vill vara med och leka med the cool kids. Ã„r du pÃ¥?" Hon sa ja och sÃ¥ blev det snuskigt bra. \r\n\r\nâ€“ EP:n har fÃ¶rresten tvÃ¥ framsidor! Bara en sÃ¥n sak. Det Ã¤r en split med oss sjÃ¤lva frÃ¥n ett tidigare slÃ¤pp. Framsida nummer tvÃ¥ Ã¤r gjord av Sannah Kvist aka Rostiga NÃ¥len. Ett tatueringsproffs och visuellt geni.\r\n\r\nÃ„r det viktigt att designen pÃ¥ omslaget hÃ¤nger ihop med hur skivan lÃ¥ter?\r\n\r\nâ€“ NjeaaÃ¤. Det Ã¤r viktigt att omslaget ger nÃ¥gon slags kÃ¤nsla till musiken eller tvÃ¤rtom men det kan ju vara sÃ¥ mycket mer Ã¤n hur skivan just â€lÃ¥terâ€. Jag vill ju av nÃ¥gon anledning bli nyfiken nÃ¤r jag ser ett omslag eller hÃ¶r musik. Ibland Ã¤r det bara dÃ¶trÃ¥kigt nÃ¤r allt hÃ¤nger ihop fÃ¶r bra.\r\n\r\nHur kan en lÃ¤nka ihop ert omslag till sjÃ¤lva musiken?\r\n\r\nâ€“ Rent konkret alltsÃ¥ ... det Ã¤r pixligt, gult och fult och sÃ¥ satans vackert.', 1, 34, 16),
(228, '2017-01-04 19:22:40.000000', '2017-01-04 19:24:23.000000', 'HÃ¤r mÃ¶ts Paul McCartney och The Killers i ett privatgig fÃ¶r rysk miljardÃ¤r', 'Ã„r det nyÃ¥rsfest sÃ¥ Ã¤r det, tÃ¤nkte fÃ¶rmodligen den ryske miljardÃ¤ren Roman Abramovich nÃ¤r han ordnade party pÃ¥ den karibiska Ã¶n Saint-BarthÃ©lemy. The Killers stod fÃ¶r underhÃ¥llningen, men det rÃ¤ckte liksom inte med det. PlÃ¶tsligt dÃ¶k The Beatles-ikonen Paul McCartney upp pÃ¥ scen och tillsammans drog de av The Beatles-klassikern Helter Skelter. Detta uppmÃ¤rksammar bland annat Consequence Of Sound.\r\n\r\nTur fÃ¶r oss vanliga dÃ¶dliga att mobilkameror finns. Kolla in klippet ovanfÃ¶r och det hÃ¤r som The Killers har delat:\r\n<br>\r\n<br>\r\n<a href="https://www.youtube.com/watch?v=3PgsC-GaWZs" target="_blank">Tryck hÃ¤r!</a>', 1, 34, 15);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `firstname` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `profilepic` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci COMMENT='Användardatabasen';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `password`, `profilepic`, `role`) VALUES
(19, 'superuser', 'superuser', 'superuser@loop.x', '$2y$10$qh3s.SLdgyKv3J/diabPK.ZZWmuc.mabbJ6Dxlyiwm18f2huJmAve', '', 'admin'),
(34, 'Patty', 'Smith', 'smith@loop.x', '$2y$10$l508nEapRKqmTH3ZaVkjmuSIscdyxAnjpxHxSWu.5UApsKo1owB0G', '', 'user'),
(35, 'Deborah', 'Harry ', 'harry@loop.x', '$2y$10$AK/W1J.k/YVgw.bjo2YB9eN5bPCDlUjMZqm6QPl51ZXL4Xtdtuf.W', '', 'user'),
(36, 'Joan', 'Jett', 'jett@loop.x', '$2y$10$Vz56sY6bCXvtJPBFrRMfQObu.SMgxUO9.V47pbz5ymF1McXGK0NMm', '', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
