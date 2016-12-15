-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 08, 2016 at 07:26 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

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
(1, 'Sport'),
(2, 'Mode'),
(3, 'Fotografi'),
(4, 'Annat');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `create_time` datetime(6) NOT NULL,
  `text` text COLLATE utf8_swedish_ci NOT NULL,
  `fk_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`com_id`, `name`, `email`, `create_time`, `text`, `fk_post_id`) VALUES
(1, 'Henrik', 'hans@hans.se', '2016-12-08 13:53:14.000000', 'DÃ¥lig blogg', 97),
(2, 'Torde', 'torde@torde.com', '2016-12-08 13:57:56.000000', 'Jag tycker den var bra!', 97);

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
(95, '2016-12-07 17:20:56.000000', '0000-00-00 00:00:00.000000', 'Test', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Hoc non est positum in nostra actione. At iste non dolendi status non vocatur voluptas. Varietates autem iniurasque fortunae facile veteres philosophorum praeceptis instituta vita superabat. </p>\r\n\r\n<ul>\r\n	<li>Frater et T.</li>\r\n	<li>Omnium enim rerum principia parva sunt, sed suis progressionibus usa augentur nec sine causa;</li>\r\n	<li>Facillimum id quidem est, inquam.</li>\r\n	<li>Sed tamen enitar et, si minus multa mihi occurrent, non fugiam ista popularia.</li>\r\n</ul>\r\n\r\n\r\n<p>Quid enim de amicitia statueris utilitatis causa expetenda vides. Istic sum, inquit. Aliter homines, aliter philosophos loqui putas oportere? <b>Sed quod proximum fuit non vidit.</b> Ut in geometria, prima si dederis, danda sunt omnia. Atqui iste locus est, Piso, tibi etiam atque etiam confirmandus, inquam; <i>Memini me adesse P.</i> </p>\r\n\r\n<p><b>Beatum, inquit.</b> Sed haec quidem liberius ab eo dicuntur et saepius. Ergo in gubernando nihil, in officio plurimum interest, quo in genere peccetur. </p>\r\n\r\n<p>Duo Reges: constructio interrete. Et ille ridens: Video, inquit, quid agas; Non quaeritur autem quid naturae tuae consentaneum sit, sed quid disciplinae. <b>Quod quidem iam fit etiam in Academia.</b> </p>\r\n\r\n<p>Atqui reperies, inquit, in hoc quidem pertinacem; Animi enim quoque dolores percipiet omnibus partibus maiores quam corporis. Vitae autem degendae ratio maxime quidem illis placuit quieta. Post enim Chrysippum eum non sane est disputatum. <b>An haec ab eo non dicuntur?</b> Summum enÃ­m bonum exposuit vacuitatem doloris; </p>\r\n\r\n', 1, 4, 1),
(96, '2016-12-07 20:42:28.000000', '0000-00-00 00:00:00.000000', 'Harry bloggar', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Equidem, sed audistine modo de Carneade? Ita prorsus, inquam; Duo Reges: constructio interrete. Hoc Hieronymus summum bonum esse dixit. Quonam, inquit, modo? Quid est, quod ab ea absolvi et perfici debeat? Quid me istud rogas? Quid de Platone aut de Democrito loquar? </p>\r\n\r\n<dl>\r\n	<dt><dfn>Quid Zeno?</dfn></dt>\r\n	<dd>Itaque rursus eadem ratione, qua sum paulo ante usus, haerebitis.</dd>\r\n	<dt><dfn>Quibusnam praeteritis?</dfn></dt>\r\n	<dd>Quid censes in Latino fore?</dd>\r\n	<dt><dfn>Magna laus.</dfn></dt>\r\n	<dd>Res enim se praeclare habebat, et quidem in utraque parte.</dd>\r\n	<dt><dfn>Easdemne res?</dfn></dt>\r\n	<dd>Itaque in rebus minime obscuris non multus est apud eos disserendi labor.</dd>\r\n</dl>\r\n\r\n\r\n<p>Ne in odium veniam, si amicum destitero tueri. Ut in geometria, prima si dederis, danda sunt omnia. </p>\r\n\r\n<p>Quantum Aristoxeni ingenium consumptum videmus in musicis? Sit hoc ultimum bonorum, quod nunc a me defenditur; Haec bene dicuntur, nec ego repugno, sed inter sese ipsa pugnant. Hic Speusippus, hic Xenocrates, hic eius auditor Polemo, cuius illa ipsa sessio fuit, quam videmus. </p>\r\n\r\n<p>Videamus animi partes, quarum est conspectus illustrior; Prodest, inquit, mihi eo esse animo. Nunc ita separantur, ut disiuncta sint, quo nihil potest esse perversius. Age nunc isti doceant, vel tu potius quis enim ista melius? Beatus sibi videtur esse moriens. At iste non dolendi status non vocatur voluptas. Aliter homines, aliter philosophos loqui putas oportere? </p>\r\n\r\n<ol>\r\n	<li>Nec enim, omnes avaritias si aeque avaritias esse dixerimus, sequetur ut etiam aequas esse dicamus.</li>\r\n	<li>Animum autem reliquis rebus ita perfecit, ut corpus;</li>\r\n</ol>\r\n\r\n\r\n<p>Quamquam ab iis philosophiam et omnes ingenuas disciplinas habemus; Quae est igitur causa istarum angustiarum? Sit sane ista voluptas. Urgent tamen et nihil remittunt. An nisi populari fama? Ab his oratores, ab his imperatores ac rerum publicarum principes extiterunt. </p>\r\n\r\n', 1, 5, 2),
(97, '2016-12-07 20:43:41.000000', '0000-00-00 00:00:00.000000', 'Mitt fÃ¶rsta inlÃ¤gg', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Si mala non sunt, iacet omnis ratio Peripateticorum. Quid de Platone aut de Democrito loquar? Cur fortior sit, si illud, quod tute concedis, asperum et vix ferendum putabit? </p>\r\n\r\n<ol>\r\n	<li>Audeo dicere, inquit.</li>\r\n	<li>Non potes ergo ista tueri, Torquate, mihi crede, si te ipse et tuas cogitationes et studia perspexeris;</li>\r\n	<li>Nosti, credo, illud: Nemo pius est, qui pietatem-;</li>\r\n	<li>Aliis esse maiora, illud dubium, ad id, quod summum bonum dicitis, ecquaenam possit fieri accessio.</li>\r\n	<li>Commoda autem et incommoda in eo genere sunt, quae praeposita et reiecta diximus;</li>\r\n	<li>Quamquam non negatis nos intellegere quid sit voluptas, sed quid ille dicat.</li>\r\n</ol>\r\n\r\n\r\n<p>Quae cum magnifice primo dici viderentur, considerata minus probabantur. Immo alio genere; Inde sermone vario sex illa a Dipylo stadia confecimus. Quid enim tanto opus est instrumento in optimis artibus comparandis? </p>\r\n\r\n<p>Mene ergo et Triarium dignos existimas, apud quos turpiter loquare? Eam tum adesse, cum dolor omnis absit; Non quam nostram quidem, inquit Pomponius iocans; Vide igitur ne non debeas verbis nostris uti, sententiis tuis. </p>\r\n\r\n<p>Duo Reges: constructio interrete. Hoc sic expositum dissimile est superiori. Tecum optime, deinde etiam cum mediocri amico. Nihil enim iam habes, quod ad corpus referas; Idem iste, inquam, de voluptate quid sentit? Atqui perspicuum est hominem e corpore animoque constare, cum primae sint animi partes, secundae corporis. Quae cum dixisset, finem ille. Et quidem, Cato, hanc totam copiam iam Lucullo nostro notam esse oportebit; A villa enim, credo, et: Si ibi te esse scissem, ad te ipse venissem. Ergo instituto veterum, quo etiam Stoici utuntur, hinc capiamus exordium. </p>\r\n\r\n<p>Quid ad utilitatem tantae pecuniae? Iam in altera philosophiae parte. Animi enim quoque dolores percipiet omnibus partibus maiores quam corporis. Quodsi ipsam honestatem undique pertectam atque absolutam. Apparet statim, quae sint officia, quae actiones. Quantum Aristoxeni ingenium consumptum videmus in musicis? Suo enim quisque studio maxime ducitur. </p>\r\n\r\n<dl>\r\n	<dt><dfn>Nihil sane.</dfn></dt>\r\n	<dd>Vitae autem degendae ratio maxime quidem illis placuit quieta.</dd>\r\n	<dt><dfn>Moriatur, inquit.</dfn></dt>\r\n	<dd>Sed id ne cogitari quidem potest quale sit, ut non repugnet ipsum sibi.</dd>\r\n	<dt><dfn>Numquam facies.</dfn></dt>\r\n	<dd>Videamus animi partes, quarum est conspectus illustrior;</dd>\r\n	<dt><dfn>Numquam facies.</dfn></dt>\r\n	<dd>Quae tamen a te agetur non melior, quam illae sunt, quas interdum optines.</dd>\r\n	<dt><dfn>Avaritiamne minuis?</dfn></dt>\r\n	<dd>Non minor, inquit, voluptas percipitur ex vilissimis rebus quam ex pretiosissimis.</dd>\r\n</dl>\r\n\r\n\r\n', 1, 6, 4),
(98, '2016-12-08 11:57:39.000000', '0000-00-00 00:00:00.000000', 'Utkast 1', '\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac magna non augue porttitor scelerisque ac id diam. Mauris elit velit, lobortis sed interdum at, vestibulum vitae libero. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque iaculis ligula ut ipsum mattis viverra. Nulla a libero metus. Integer gravida tempor metus eget condimentum. Integer eget iaculis tortor. Nunc sed ligula sed augue rutrum ultrices eget nec odio. Morbi rhoncus, sem laoreet tempus pulvinar, leo diam varius nisi, sed accumsan ligula urna sed felis. Mauris molestie augue sed nunc adipiscing et pharetra ligula suscipit. In euismod lectus ac sapien fringilla ut eleifend lacus venenatis.  </p>\r\n\r\n<p>Proin suscipit luctus orci placerat fringilla. Donec hendrerit laoreet risus eget adipiscing. Suspendisse in urna ligula, a volutpat mauris. Sed enim mi, bibendum eu pulvinar vel, sodales vitae dui. Pellentesque sed sapien lorem, at lacinia urna. In hac habitasse platea dictumst. Vivamus vel justo in leo laoreet ullamcorper non vitae lorem. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin bibendum ullamcorper rutrum.  </p>\r\n\r\n<p>In facilisis scelerisque dui vel dignissim. Sed nunc orci, ultricies congue vehicula quis, facilisis a orci. In aliquet facilisis condimentum. Donec at orci orci, a dictum justo. Sed a nunc non lectus fringilla suscipit. Vivamus pretium sapien sit amet mauris aliquet eleifend vel vitae arcu. Fusce pharetra dignissim nisl egestas pretium.  </p>\r\n\r\n<p>Nullam eros mi, mollis in sollicitudin non, tincidunt sed enim. Sed et felis metus, rhoncus ornare nibh. Ut at magna leo. Suspendisse egestas est ac dolor imperdiet pretium. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor, erat sit amet venenatis luctus, augue libero ultrices quam, ut congue nisi risus eu purus. Cras semper consectetur elementum. Nulla vel aliquet libero. Vestibulum eget felis nec purus commodo convallis. Aliquam erat volutpat.  </p>\r\n\r\n<p>Proin ornare ligula eu tellus tempus elementum. Aenean bibendum iaculis mi, nec blandit lacus interdum vitae. Vestibulum non nibh risus, a scelerisque purus. Ut vel arcu ac tortor adipiscing hendrerit vel sed massa. Fusce sem libero, lacinia vulputate interdum non, porttitor non quam. Aliquam sed felis ligula. Duis non nulla magna.  </p>', 0, 3, 2),
(99, '2016-12-08 12:20:54.000000', '0000-00-00 00:00:00.000000', 'Utkast 2', 'En vacker sommardag.', 0, 3, 1),
(100, '2016-12-08 12:21:04.000000', '0000-00-00 00:00:00.000000', 'Roliga timmen', 'eller?', 0, 3, 4),
(101, '2016-12-08 12:21:14.000000', '0000-00-00 00:00:00.000000', 'KrÃ¤ftor Ã¤r gott', 'Eller hur!', 0, 3, 3);

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
(3, 'superuser', 'superuser', 'superuser@loop.x', '$2y$10$xBRdo1uZS/5dSSGd1nuZgelONvVWB8hdLy/AYTv02V/AT85wd8NBy', '', 'admin'),
(4, 'Erik', 'Kers', 'erik.kers.ohrnell@gmail.com', '$2y$10$g60BFLDwTow2O2tjX6IOqOlVwcr3S2QDWREfvjnndiK4m/IdBdreK', '', 'user'),
(5, 'Harry', 'Hansson', 'hogsboharry@gbg.se', '$2y$10$Gw8vwMT5Q.RGlaTprU7/8.Vs89o49sAMpoPVgJKpkcPpvf1tzpHD2', '', 'user'),
(6, 'Gunde', 'Svan', 'gsvan@hotmail.com', '$2y$10$uxz04VT6b5FKGIp7P62V9OIuSjR.gwiisWLi/sITFUzgiyERcNKZO', '', 'user');

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
  MODIFY `cat_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
