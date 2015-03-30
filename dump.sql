
--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `birthday` date NOT NULL,
  `phone` varchar(32) NOT NULL,
  `email` int(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` VALUES (1,'Machin','José','','0000-00-00','',0,'','','','0000-00-00 00:00:00'),(2,'Bidule','Martine','','0000-00-00','',0,'','','','0000-00-00 00:00:00');

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `address` text NOT NULL,
  `latitude` decimal(10,5) NOT NULL,
  `longitude` decimal(10,5) NOT NULL,
  `date_begin` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `picture` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `max_places` int(11) NOT NULL,
  `published` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

