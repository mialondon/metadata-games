-- phpMyAdmin SQL Dump
-- version 2.11.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 03, 2010 at 12:13 AM
-- Server version: 5.0.41
-- PHP Version: 5.2.6
--
-- Export for saving back to git
--

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wordpress_mu`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_mmg_objects`
--

CREATE TABLE IF NOT EXISTS `wp_mmg_objects` (
  `object_id` int(11) NOT NULL auto_increment,
  `name` varchar(200) collate utf8_unicode_ci NOT NULL,
  `accession_number` varchar(200) collate utf8_unicode_ci NOT NULL,
  `institution` varchar(200) collate utf8_unicode_ci NOT NULL,
  `data_source_url` varchar(500) collate utf8_unicode_ci NOT NULL,
  `source_display_url` varchar(500) collate utf8_unicode_ci NOT NULL,
  `interpretative_date` varchar(50) collate utf8_unicode_ci NOT NULL,
  `interpretative_place` varchar(200) collate utf8_unicode_ci NOT NULL,
  `image_url` varchar(200) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`object_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Generic object table for filling from different sources' AUTO_INCREMENT=101 ;

--
-- Dumping data for table `wp_mmg_objects`
--

INSERT INTO `wp_mmg_objects` VALUES(1, 'Telescope%20by%20Galileo%20%28replica%29', '1923-668', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1923-668', '', 'Original%20c.%201610', 'Florence', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11722&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(2, 'Sidereus%20nuncius', 'E2009.44.2', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2009.44.2', '', '1610', 'Venice', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11730&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(3, 'Isaac%20Newton%E2%80%99s%20reflecting%20telescope%20%28replica%29', '1924-209', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1924-209', '', 'Original%201668-71', 'Cambridge', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11727&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(4, 'Representation%20of%20E-ELT%20mirror%20segment', 'E2009.124.1', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2009.124.1', '', '2009', 'Science%20Museum', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11841&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(5, 'Stjerneborg%20Observatory', '1937-615', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1937-615', '', '1634', 'Amsterdam', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11725&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(6, 'Islamic%20astrolabe%20%28shown%20in%20parts%29', '1981-1380', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1981-1380', '', '901-1100', 'Syria', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11845&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(7, 'European%20astrolabe', '1878-11', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1878-11', '', '1607-18', 'Antwerp%2C%20Belgium', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11844&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(8, 'Norman%20Lockyer%E2%80%99s%20seven-prism%20spectroscope', '1987-1162', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1987-1162', '', '1868', 'London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11787&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(9, 'Long-wavelength%20spectrometer%20from%20the%20Infrared%20Space%20Observatory%20%28identical%20spare%20model%29', 'L2009-4033', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4033', '', '1990s%20', 'Rutherford%20Appleton%20Laboratory', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11733&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(10, 'Tenmon%20Bun%E2%80%99ya%20no%20zu%20%28map%20showing%20divisions%20of%20the%20heavens%20and%20regions%20they%20govern%29', '2007-1', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F2007-1', '', '1677', 'Japan', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11776&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(11, 'Glass%20positive%20of%20Hubble%E2%80%99s%20classification%20of%20%E2%80%98nebulae%E2%80%99', '1930-682', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1930-682', '', '1930', 'London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11772&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(12, 'Scale%20model%20%281%3A6%29%20of%20the%20Hipparcos%20%28High%20Precision%20Parallax%20Collecting%20Satellite%29%20astrometry%20spacecraft', '1986-850', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1986-850', '', 'c.%201985', 'Netherlands', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11728&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(13, 'Aluminium%20spectroscopic%20plate%20from%20the%20Sloan%20Digital%20Sky%20Survey%20%28SDSS%29', 'E2008.173.1', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2008.173.1', '', 'c.%202000', 'University%20of%20Washington%2C%20USA', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11783&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(14, 'Parts%20from%20the%20Cambridge%20Interplanetary%20Scintillation%20Array', '2009-43', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F2009-43', '', '1967', 'Cambridge', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11840&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(15, 'Model%20of%20a%20pulsar', 'L2009-4026', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4026', '', 'c.%201969', 'Cambridge', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11784&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(16, 'Kew%20Photoheliograph', '1927-124', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1927-124', '', '1857', 'Clerkenwell%2C%20London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11661&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(17, 'Photographs%20of%20sunspots%20taken%20with%20the%20Kew%20Photoheliograph', '1982-684', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1982-684', '', 'September%201870', 'Kew%2C%20London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11775&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(18, 'Diapositives%20of%20photographs%20taken%20with%20the%20Kew%20Photoheliograph', '1862-122', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1862-122', '', '1860-62', 'Kew%2C%20London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11839&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(19, 'William%20Herschel%E2%80%99s%20%E2%80%98infrared%E2%80%99%20prism', '1876-951', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1876-951', '', '1795-1805', 'London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11770&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(20, 'Model%20%28scale%201%3A200%29%20of%20the%20Jodrell%20Bank%20Lovell%20Telescope', '1961-159', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1961-159', '', '1961', 'Scunthorpe', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11729&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(21, 'XMM-Newton%20grazing%20mirror%20%28flight%20spare%29', 'L2009-4035', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4035', '', 'Mid%201990s', 'Bosiso%20Parini%2C%20Italy', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11731&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(22, 'Mirror%20segment%20for%20FUSE%20%28Far%20Ultraviolet%20Spectroscopic%20Explorer%29%20satellite', 'L2009-4028', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4028', '', 'Mid%201990s', 'New%20York%20State', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11734&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(23, 'Scale%20model%20%281%3A30%29%20of%20a%20single%20telescope%20from%20the%20High%20Energy%20Stereoscopic%20System%20%28HESS%29', '2009-60', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F2009-60', '', '2009', 'France', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11778&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(24, 'Spare%20mirror%20segment%20for%20the%20High%20Energy%20Stereoscopic%20System%20%28HESS%29', '2009-44', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F2009-44', '', 'c.%202002', 'Armenia', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11777&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(25, 'Scale%20model%20%281%3A10%29%20of%20Swift%20gamma-ray%20burst%20satellite', 'L2009-4034', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4034', '', 'c.%202000', 'University%20of%20Leicester', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11785&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(26, 'European%20celestial%20globe', '1878-10', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1878-10', '', '1878', 'Paris', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11741&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(27, 'Clock-driven%20Chinese%20celestial%20globe', '1988-1422%2F1', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1988-1422%2F1', '', '1830', 'Wuyuan%2C%20China', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11751&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(28, 'Arabic%20celestial%20globe', '1914-597', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1914-597', '', '1601-1700', 'Middle%20East', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11740&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(29, 'Epitome%20of%20the%20Almagest', 'E2009.44.4', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2009.44.4', '', '1496', 'Venice', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11756&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(30, 'De%20revolutionibus%20celestium%20orbium%20%28On%20the%20Revolutions%20of%20the%20Heavenly%20Spheres%29', 'E2009.44.1', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2009.44.1', '', '1543', 'Nuremberg', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11739&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(31, 'Dialogo%20sopra%20i%20due%20massimi%20sistemi%20del%20mondo%20%28Dialogue%20Concerning%20the%20Two%20Chief%20World%20Systems%29', 'E2009.44.9', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2009.44.9', '', '1632', 'Florence', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11767&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(32, 'Astronomia%20nova%20%28New%20Astronomy%29', 'E2009.44.3', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2009.44.3', '', '1609', 'Prague', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11794&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(33, 'Philosophi%C3%A6%20naturalis%20principia%20mathematica', 'E2009.44.5', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2009.44.5', '', '1687', 'Cambridge', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11768&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(34, 'Ptolemaic%20armillary%20sphere', '1880-47', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1880-47', '', '1500%E2%80%9399', 'Germany', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11742&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(35, 'Copernican%20armillary%20sphere', '1982-967%2F2', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1982-967%2F2', '', '1807-46', 'Paris', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11748&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(36, 'Seven-foot%20telescope%20made%20by%20William%20Herschel', 'L2009-4029', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4029', '', 'c.1780', 'Bath', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11796&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(37, 'Speculum%20mirror%20made%20by%20William%20Herschel', '1971-465%2F2', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1971-465%2F2', '', '1770-1820', 'Slough', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11723&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(38, '%E2%80%98Epitome%20of%20Astronomy%E2%80%99%20or%20%E2%80%98A%20Compendius%20View%20of%20Our%20Solar%20System%E2%80%99', '1985-1135', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1985-1135', '', 'c.%201781-1800', 'Theobald%27s%20Road%2C%20London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11749&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(39, 'Mean%20motion%20orrery', '1950-55%20Pt2', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1950-55%20Pt2', '', '1813-22', 'London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11704&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(40, 'Poster%20for%20a%20concert%20performance%20of%20Handel%E2%80%99s%20Messiah%20conducted%20by%20William%20Herschel', 'L2009-4030', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4030', '', '1778', 'Bath', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11846&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(41, 'Salary%20letter%20from%20King%20George%20III%20to%20William%20and%20Caroline%20Herschel', 'L2009-4031', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4031', '', '1800', 'Windsor', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11761&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(42, 'Glass%20positive%20of%20Pluto%20discovery', '1930-680', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1930-680', '', '1930', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11801&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(43, 'Mars%20globe', '2001-320', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F2001-320', '', '1896-99', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11754&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(44, 'Arecibo%20message%20illustration', 'E2009.123.1', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2009.123.1', '', '1974', 'London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(45, 'Camera%20from%20the%20Super%20Wide%20Angle%20Search%20for%20Planets%20%28SuperWASP%29', 'L2009-4037', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4037', '', '2001%E2%80%932009', 'La%20Palma', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11764&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(46, 'Print%20of%20New%20Discoveries%20on%20the%20Moon', '1995-249', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1995-249', '', '1835', 'France', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11706&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(47, 'Moon%20Machine%20from%20A%20Grand%20Day%20Out', 'L2009-4032', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4032', '', 'Mid%201980s', 'United%20Kingdom', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11763&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(48, 'Mirror%20mechanism%20of%20COBE%20spacecraft%E2%80%99s%20FIRAS%20instrument%20%28engineering%20prototype%29', 'L2009-4043', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4043', '', '1980s', 'Goddard%20Space%20Flight%20Center%2C%20Maryland%2C%20USA', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11736&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(49, 'Glass%20positive%20photograph%20of%20total%20solar%20eclipse', '1920-18', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1920-18', '', '1919', 'Sobral%2C%20Brazil', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11709&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(50, 'Gravity%20Probe%20B%20gyroscope%20rotor%20and%20housing', '2005-75', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F2005-75', '', '1995', 'Stanford%20University%2C%20California%2C%20USA', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11837&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(51, 'Prototype%20test%20mass%20from%20the%20GEO-600%20gravitational%20wave%20detector', 'L2009-4036', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4036', '', '2003', 'USA', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11716&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(52, 'Prototype%20beam%20splitter%20for%20the%20Advanced%20Laser%20Interferometer%20Gravitational%20Wave%20Observatory%20%28LIGO%29', 'L2009-4054', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4054', '', '2008', 'Rutherford%20Appleton%20Laboratory%2C%20Didcot%2C%20UK', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11759&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(53, 'DRIFT%20I%20dark%20matter%20detector', '2009-59', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F2009-59', '', '2001', 'University%20of%20Sheffield%2C%20UK', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11843&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(54, 'Pluto%20bumper%20stickers', '2006-213', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F2006-213', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11660&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(55, 'Pluto%20bumper%20stickers', '2006-214', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F2006-214', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11660&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(56, 'Astounding%20Science%20Fiction%20magazine', 'L2009-4049', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4049', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(57, 'Astounding%20Science%20Fiction%20magazine', 'L2009-4050', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4050', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(58, 'Science%20fiction%20paperbacks', 'L2009-4045', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4045', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(59, 'Science%20fiction%20paperbacks', 'L2009-4046', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4046', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(60, 'Science%20fiction%20paperbacks', 'L2009-4047', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4047', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(61, 'Science%20fiction%20paperbacks', 'L2009-4048', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4048', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(62, 'Early%20popular%20science%20books', 'E2009.44.10', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2009.44.10', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11718&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(63, 'Early%20popular%20science%20books', 'E2005.322.2', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2005.322.2', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(64, 'Small%20Zeiss%20planetarium%20projector%2C%20model%20number%2030', '1946-172%20Pt1', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1946-172%20Pt1', '', '1930%E2%80%9345', 'Jena%2C%20Germany', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11746&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(65, '%E2%80%99etu%20iti%20%28Little%20Stars%29%20by%20Ani%20O%E2%80%99Neill', 'L2009-4044', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4044', '', '2006', 'Cambridge', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11803&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(66, 'Egyptian%20merkhet', '1929-585', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1929-585', '', 'c.%20600%20BCE', 'Egypt', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11715&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(67, 'Hindu%20astrolabe', '1987-541', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1987-541', '', '1870', 'Rajasthan%2C%20India', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11750&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(68, '1%3A24%20scale%20model%20of%20the%20zodiacal%20dials%20%28Rashivalaya%20Yantra%29%20at%20the%20Jaipur%20Observatory%2C%20India', '1887-2', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1887-2', '', '1884%E2%80%9386', 'Unknown', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11708&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(69, 'Islamic%20horary%20quadrant', '1918-261%20Pt2', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1918-261%20Pt2', '', '1700-99', 'Iran', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11717&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(70, 'Nocturnal', '1903-80', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1903-80', '', '1702', 'Bristol', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11791&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(71, 'Cambridge%20Observatory%20eight-foot%20mural%20circle', '1937-599', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1937-599', '', '1832', 'Cambridge', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11719&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(72, 'Electrotype%20replica%20of%20a%2016th-century%20mariner%E2%80%99s%20astrolabe', '1930-262', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1930-262', '', '1580-88', 'Spain', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11745&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(73, 'Lunar%20longitude%20calculator', '1999-851', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1999-851', '', '1880-85', 'Paris', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11793&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(74, 'Sextant', '1928-924%20Pt2', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1928-924%20Pt2', '', '1770-80', 'London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11744&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(75, 'Divination%20plate', 'A658137', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FA658137', '', '1800-99', 'Middle%20East%20and%2For%20Central%20Asia', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11758&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(76, 'Ivory%20Buddhist%20Tibetan%20talisman', 'A635141', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FA635141', '', 'Unknown', 'Tibet', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11757&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(77, 'Embroidered%20illustration%20of%20an%20astrologer%27s%20prediction%2C%20England%2C%201780-1820', 'A681631', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FA681631', '', '1870-1930', 'England', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11795&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(78, 'Mechanical%20lantern%20slide%20of%20the%20Solar%20System', '1902-104', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1902-104', '', '1838', 'Wales', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11743&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(79, 'Magic%20lantern%20slides', '1986-1392', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1986-1392', '', '1811-25', 'Unknown', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11711&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(80, 'Handbill%20for%20an%20astronomy%20lecture%20by%20Mr%20Bartley%20on%2030%20March%201827', '1980-930%2F6', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1980-930%2F6', '', '1827', 'Unknown', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11747&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(81, 'The%20Story%20of%20the%20Solar%20System%2C%20by%20G%20F%20Chambers', 'E2009.44.6', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2009.44.6', '', '1895', 'London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11797&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(82, 'Time%20magazine%20%E2%80%98When%20did%20the%20universe%20begin%3F%E2%80%99%20issue%2C%20American%2C%201995', '2009-57', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F2009-57', '', '1995', 'United%20States', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(83, 'Custom-made%20speech%20synthesiser%20for%20Professor%20Stephen%20Hawking', 'L2000-4378', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2000-4378', '', '1985-95', 'Cambridge', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11798&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(84, 'A%20Brief%20History%20of%20Time', 'E2009.44.8', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FE2009.44.8', '', '1988', 'London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11762&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(85, 'The%20Astroglobe', '1992-585', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1992-585', '', 'c.1934', 'London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11752&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(86, 'Astronomical%20playing%20cards', '1979-351', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1979-351', '', '1829-31', 'London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11705&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(87, 'MONOPOLY%C2%AE%3A%20Astronomy%20Edition', '2009-13', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F2009-13', '', '2001', 'USA', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(88, 'Pocket%20terrestrial%20and%20celestial%20globe', '1936-53', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1936-53', '', '1824', 'London', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11807&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(89, 'French%20folding%20fan%20with%20a%20satirical%20scene%20of%20the%20comet%20of%201811', '2000-1230', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F2000-1230', '', '1811-15', 'France', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11707&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(90, 'Porter%20Garden%20Telescope', 'L2009-4038', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4038', '', '1920s', 'Springfield%2C%20Vermont%2C%20United%20States', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11765&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(91, 'Folding%20telescope%20designed%20by%20Horace%20Dall', '1987-528%2F8', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1987-528%2F8', '', '1960-75', 'Luton%2C%20England', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11712&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(92, 'Phil%20Shepherdson%E2%80%99s%20home-made%20nine-inch%20reflecting%20telescope', 'L2009-4027', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FL2009-4027', '', '1968', 'Yorkshire', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11788&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(93, 'Ecliptoglass%20eclipse%20viewer', '1999-1011', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1999-1011', '', 'c.%201927', 'Britain', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11713&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(94, '1999%20eclipse%20viewer', '1999-1176', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1999-1176', '', '1999', 'Guernsey', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11714&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(95, '1999%20Eclipse%20tea%20towel', '1999-1221', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1999-1221', '', 'c.1999', 'Britain', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11753&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(96, '1999%20Eclipse%20postcard', '1999-1223', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2F1999-1223', '', '1999', 'Britain', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11802&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(97, 'Casts%20of%20Chinese%20zodiac%20figures%20%28Tang%20dynasty%29', 'A39028', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FA39028', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11634&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(98, 'Casts%20of%20Chinese%20zodiac%20figures%20%28Tang%20dynasty%29', 'A657792', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FA657792', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11634&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(99, 'Casts%20of%20Chinese%20zodiac%20figures%20%28Tang%20dynasty%29', 'A657793', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FA657793', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11634&size=Small');
INSERT INTO `wp_mmg_objects` VALUES(100, 'Casts%20of%20Chinese%20zodiac%20figures%20%28Tang%20dynasty%29', 'A658110', 'Science Museum', 'http://www.sciencemuseum.org.uk%2Fobjectapi%2Fcosmosculturepublic.svc%2FMuseumObjects%2FAccessionNumber%2FA658110', '', '', '', 'http://www.sciencemuseum.org.uk/hommedia.ashx?id=11634&size=Small');

-- --------------------------------------------------------

--
-- Table structure for table `wp_mmg_turns`
--

CREATE TABLE IF NOT EXISTS `wp_mmg_turns` (
  `turn_id` int(11) NOT NULL auto_increment,
  `object_id` int(11) NOT NULL,
  `game_code` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT 'from shortcode',
  `game_version` varchar(11) collate utf8_unicode_ci default NULL COMMENT 'from shortcode',
  `tags` varchar(2000) collate utf8_unicode_ci NOT NULL,
  `datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`turn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `wp_mmg_turns`
--

INSERT INTO `wp_mmg_turns` VALUES(1, 42, 'simpletagging', NULL, 'black, white, stars, arrows', '2010-10-31 20:12:07');
INSERT INTO `wp_mmg_turns` VALUES(2, 62, 'simpletagging', NULL, 'book, globes, terres de ciel', '2010-10-31 20:12:28');

-- --------------------------------------------------------

--
-- Table structure for table `wp_mmg_turn_facts`
--

CREATE TABLE IF NOT EXISTS `wp_mmg_turn_facts` (
  `turn_fact_id` int(11) NOT NULL auto_increment,
  `turn_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `fact_summary` varchar(2000) collate utf8_unicode_ci NOT NULL,
  `fact_headline` varchar(100) collate utf8_unicode_ci default NULL,
  `fact_source` varchar(1000) collate utf8_unicode_ci NOT NULL,
  `source_type` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`turn_fact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `wp_mmg_turn_facts`
--


-- --------------------------------------------------------

--
-- Table structure for table `wp_mmg_turn_stories`
--

CREATE TABLE IF NOT EXISTS `wp_mmg_turn_stories` (
  `turn_story_id` int(11) NOT NULL auto_increment,
  `turn_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `story` varchar(2000) collate utf8_unicode_ci NOT NULL,
  `story_headline` varchar(100) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`turn_story_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `wp_mmg_turn_stories`
--


-- --------------------------------------------------------

--
-- Table structure for table `wp_mmg_turn_tags`
--

CREATE TABLE IF NOT EXISTS `wp_mmg_turn_tags` (
  `turn_tag_id` int(11) NOT NULL auto_increment,
  `turn_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `tag` varchar(2000) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`turn_tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `wp_mmg_turn_tags`
--

