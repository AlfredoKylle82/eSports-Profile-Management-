--
-- Database: `assignment2` and php web application user
CREATE DATABASE assignment2;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON demo.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE assignment2;
--
-- Table structure for table `eSports`
--

CREATE TABLE IF NOT EXISTS `eSports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PlayerName` varchar(100) NOT NULL,
  `EsportsTeam` varchar(255) NOT NULL,
  `NetWorth` int(20) NOT NULL,
  `BirthDate` DATE NOT NULL,
  `ImagePath` varchar(255) DEFAULT NULL, 
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `eSports`
--

INSERT INTO `eSports` (`id`, `PlayerName`, `EsportsTeam`, `NetWorth`, `BirthDate` ) VALUES
(1, 'TenZ', 'Sentinels', 1500000, '2001-05-05'),
(2, 'Wardell', 'Cloud 9', 1400000, '1998-05-07'),
(3, 'Zekken', 'Sentinels', 41810, '2005-03-19'); 
