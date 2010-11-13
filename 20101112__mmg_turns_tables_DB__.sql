-- phpMyAdmin SQL Dump
-- version 2.11.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 12, 2010 at 07:12 PM
-- Server version: 5.0.41
-- PHP Version: 5.2.6

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

CREATE TABLE `wp_mmg_objects` (
  `object_id` int(11) NOT NULL auto_increment,
  `name` varchar(200) collate utf8_unicode_ci NOT NULL,
  `accession_number` varchar(200) collate utf8_unicode_ci NOT NULL,
  `institution` varchar(200) collate utf8_unicode_ci NOT NULL,
  `data_source_url` varchar(500) collate utf8_unicode_ci NOT NULL,
  `source_display_url` varchar(500) collate utf8_unicode_ci NOT NULL,
  `source_subject` varchar(100) collate utf8_unicode_ci default NULL,
  `description` longtext collate utf8_unicode_ci,
  `date_earliest` varchar(50) collate utf8_unicode_ci default NULL,
  `date_latest` varchar(50) collate utf8_unicode_ci default NULL,
  `interpretative_date` varchar(50) collate utf8_unicode_ci NOT NULL,
  `interpretative_place` varchar(200) collate utf8_unicode_ci NOT NULL,
  `image_url` varchar(200) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`object_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Generic object table for filling from different sources' AUTO_INCREMENT=501 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_mmg_turns`
--

CREATE TABLE `wp_mmg_turns` (
  `turn_id` int(11) NOT NULL auto_increment,
  `object_id` int(11) NOT NULL,
  `game_code` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT 'from shortcode',
  `game_version` varchar(11) collate utf8_unicode_ci default NULL COMMENT 'from shortcode',
  `session_id` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT 'From session manager',
  `ip_address` varchar(20) collate utf8_unicode_ci NOT NULL,
  `wp_username` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT 'WordPress user name (if it''s in the session cookie)',
  `datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`turn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_mmg_turn_facts`
--

CREATE TABLE `wp_mmg_turn_facts` (
  `turn_fact_id` int(11) NOT NULL auto_increment,
  `turn_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `fact_summary` varchar(2000) collate utf8_unicode_ci NOT NULL,
  `fact_headline` varchar(100) collate utf8_unicode_ci default NULL,
  `fact_source` varchar(1000) collate utf8_unicode_ci NOT NULL,
  `source_type` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`turn_fact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_mmg_turn_stories`
--

CREATE TABLE `wp_mmg_turn_stories` (
  `turn_story_id` int(11) NOT NULL auto_increment,
  `turn_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `story` varchar(2000) collate utf8_unicode_ci NOT NULL,
  `story_headline` varchar(100) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`turn_story_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_mmg_turn_tags`
--

CREATE TABLE `wp_mmg_turn_tags` (
  `turn_tag_id` int(11) NOT NULL auto_increment,
  `turn_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `tag` varchar(2000) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`turn_tag_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_session_manager`
--

CREATE TABLE `wp_session_manager` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(254) collate utf8_unicode_ci NOT NULL,
  `url` text collate utf8_unicode_ci NOT NULL,
  `ip_address` varchar(18) collate utf8_unicode_ci NOT NULL,
  `user_agent` varchar(255) collate utf8_unicode_ci NOT NULL,
  `unixtime` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=492 ;
