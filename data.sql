-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 06, 2013 at 06:26 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `dz_admin_menu`
--

CREATE TABLE IF NOT EXISTS `dz_admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(225) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `z_index` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `link` varchar(250) DEFAULT NULL,
  `showed` tinyint(1) NOT NULL DEFAULT '0',
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `icon` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=253 ;

--
-- Dumping data for table `dz_admin_menu`
--

INSERT INTO `dz_admin_menu` (`id`, `title`, `create_date`, `z_index`, `parent_id`, `link`, `showed`, `editable`, `icon`) VALUES
(2, 'Quáº£n trá»‹ TÃ i Khoáº£n', '2013-11-06 03:23:23', 99, 0, '', 1, 1, 'icon-user'),
(21, 'TÃ i Khoáº£n', '2013-11-06 03:23:59', 1, 2, 'amod%3Duser%26atask%3Duser', 1, 1, 'icon-user'),
(30, 'Quáº£n trá»‹ Module', '2013-09-26 19:17:52', 1, 211, 'amod%3Dsystem%26atask%3Dmodule', 1, 0, 'icon-code'),
(53, 'Thiáº¿t láº­p quyá»n quáº£n trá»‹', '2013-09-26 19:18:00', 2, 211, 'amod%3Dsystem%26atask%3Droll', 1, 0, 'icon-unlock'),
(55, 'Quáº£n lÃ½ ngÃ´n ngá»¯', '2013-11-06 03:00:28', 5, 246, 'amod%3Dsystem%26atask%3Dlanguage', 1, 1, 'icon-flag-alt'),
(118, 'NhÃ³m TÃ i Khoáº£n', '2013-11-06 03:23:48', 2, 2, 'amod%3Duser%26atask%3Dgroup', 1, 1, 'icon-group'),
(229, 'Quáº£n lÃ½ menu', '2013-11-06 02:58:35', 3, 246, 'amod%3Dsystem%26atask%3Dnav', 1, 1, 'icon-list-ol'),
(212, 'Quáº£n lÃ½ bÃ i viáº¿t', '2013-11-01 05:15:24', 2, 0, '', 1, 1, 'icon-file-text'),
(227, 'Quáº£n lÃ½ Media', '2013-11-06 02:58:49', 4, 246, 'amod%3Dpicture%26atask%3Dmanagermedia', 1, 1, 'icon-file'),
(220, 'Quáº£n lÃ½ cÃ¡ nhÃ¢n', '2013-09-20 20:05:24', 101, 0, '', 0, 1, 'icon-user'),
(215, 'Quáº£n lÃ½ tá»« khÃ³a', '2013-11-06 02:58:24', 2, 246, 'amod%3Dpost%26atask%3Dtags', 1, 1, 'icon-tags'),
(214, 'BÃ i viáº¿t', '2013-10-08 19:10:00', 2, 212, 'amod%3Dpost%26atask%3Dpost', 1, 1, ''),
(213, 'Danh má»¥c', '2013-10-11 19:34:14', 1, 212, 'amod%3Dpost%26atask%3Dcategory', 1, 1, ''),
(211, 'Dezhuber', '2013-09-19 21:14:13', 200, 0, '', 1, 1, 'icon-bug'),
(221, 'Äá»•i máº­t kháº©u', '2013-09-26 19:16:28', 1, 220, 'amod%3Dprofile%26atask%3Dprofile%26task%3Dchangepassword', 0, 1, 'icon-lock'),
(222, 'ThÃ´ng tin cÃ¡ nhÃ¢n', '2013-09-26 19:16:34', 2, 220, 'amod%3Dprofile%26ataskprofile%26task%3Dchangeprofile', 0, 1, 'icon-credit-card'),
(223, 'Há»‡ thá»‘ng', '2013-11-06 03:02:58', 6, 246, 'amod%3Dsystem%26atask%3Dvariable', 1, 1, 'icon-shield'),
(232, 'Quáº£n lÃ½ trang Ä‘Æ¡n', '2013-11-06 02:59:33', 3, 0, 'amod%3Dpage%26atask%3Dpage', 1, 1, 'icon-file'),
(246, 'Cáº¥u hÃ¬nh chung', '2013-11-06 02:57:55', 8, 0, '', 1, 1, 'icon-th'),
(240, 'Há»— trá»£ trá»±c tuyáº¿n', '2013-10-30 05:45:00', 1, 239, 'amod%3Dplugin%26atask%3Dsupport', 0, 1, ''),
(241, 'Slideshow', '2013-11-06 03:02:08', 1, 247, 'amod%3Dplugin%26atask%3Dslideshow', 1, 1, ''),
(247, 'Quáº£n lÃ½ addon', '2013-11-06 03:01:56', 4, 0, '', 1, 1, 'icon-plus');

-- --------------------------------------------------------

--
-- Table structure for table `dz_category`
--

CREATE TABLE IF NOT EXISTS `dz_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `lang_id` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `z_index` int(11) DEFAULT NULL,
  `keycode` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dz_category`
--

INSERT INTO `dz_category` (`id`, `name`, `active`, `parent_id`, `lang_id`, `type`, `z_index`, `keycode`) VALUES
(1, 'Uncategory', 1, 0, NULL, 'post', 1, 'uncategory'),
(2, 'keyword', NULL, 0, NULL, 'post_tag', NULL, 'keyword'),
(3, 'lorem', NULL, 0, NULL, 'post_tag', NULL, 'lorem');

-- --------------------------------------------------------

--
-- Table structure for table `dz_group_attribute`
--

CREATE TABLE IF NOT EXISTS `dz_group_attribute` (
  `group_id` int(11) DEFAULT NULL,
  `attribute_id` int(11) DEFAULT NULL,
  `post_type` varchar(20) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `z_index` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dz_group_attribute`
--

INSERT INTO `dz_group_attribute` (`group_id`, `attribute_id`, `post_type`, `parent_id`, `z_index`) VALUES
(1, 1, 'post', 0, 0),
(2, 1, 'post_tag', 0, 0),
(3, 1, 'post_tag', 0, 0),
(3, 2, 'page_tag', 0, 0),
(2, 2, 'page_tag', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `dz_lang`
--

CREATE TABLE IF NOT EXISTS `dz_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  `flag` varchar(225) DEFAULT NULL,
  `filename` varchar(225) NOT NULL,
  `isdefault` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `dz_lang`
--

INSERT INTO `dz_lang` (`id`, `name`, `flag`, `filename`, `isdefault`) VALUES
(2, 'Tiáº¿ng Viá»‡t', 'vn.jpg', 'vn.conf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dz_module_roll`
--

CREATE TABLE IF NOT EXISTS `dz_module_roll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `roll_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=522 ;

--
-- Dumping data for table `dz_module_roll`
--

INSERT INTO `dz_module_roll` (`id`, `module_id`, `roll_id`) VALUES
(477, 232, 6),
(476, 232, 5),
(475, 232, 4),
(474, 232, 3),
(473, 232, 2),
(472, 232, 1),
(465, 229, 4),
(480, 55, 3),
(479, 55, 2),
(478, 55, 1),
(247, 30, 4),
(246, 30, 2),
(245, 30, 1),
(250, 53, 4),
(249, 53, 2),
(248, 53, 1),
(314, 0, 6),
(313, 0, 5),
(312, 0, 4),
(332, 213, 4),
(331, 213, 2),
(330, 213, 1),
(311, 0, 3),
(310, 0, 2),
(309, 0, 1),
(461, 215, 4),
(460, 215, 2),
(459, 215, 1),
(205, 220, 2),
(491, 223, 2),
(243, 222, 2),
(464, 229, 3),
(463, 229, 2),
(462, 229, 1),
(471, 227, 6),
(470, 227, 5),
(469, 227, 4),
(468, 227, 3),
(467, 227, 2),
(466, 227, 1),
(452, 246, 6),
(451, 246, 5),
(450, 246, 4),
(449, 246, 3),
(448, 246, 2),
(447, 246, 1),
(393, 240, 1),
(394, 240, 2),
(395, 240, 3),
(396, 240, 4),
(397, 240, 5),
(398, 240, 6),
(489, 241, 6),
(488, 241, 5),
(487, 241, 4),
(486, 241, 3),
(485, 241, 2),
(484, 241, 1),
(483, 55, 6),
(482, 55, 5),
(481, 55, 4);

-- --------------------------------------------------------

--
-- Table structure for table `dz_post`
--

CREATE TABLE IF NOT EXISTS `dz_post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(255) DEFAULT NULL,
  `post_description` text,
  `post_content` text,
  `post_status` int(11) DEFAULT NULL,
  `post_lang_id` int(11) DEFAULT NULL,
  `post_createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_updatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_code` varchar(255) DEFAULT NULL,
  `post_photo` varchar(255) DEFAULT NULL,
  `post_gid` varchar(255) DEFAULT NULL,
  `post_uid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dz_post`
--

INSERT INTO `dz_post` (`post_id`, `post_title`, `post_description`, `post_content`, `post_status`, `post_lang_id`, `post_createtime`, `post_updatetime`, `post_type`, `post_code`, `post_photo`, `post_gid`, `post_uid`) VALUES
(1, 'Lorem link ipsum dolor sit amet', '', '<strong>LoremÂ <a href="#">link</a>Â ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Â </strong><br />\r\n<br />\r\n<img alt="" src="http://nhocconvn.local/public/upload/userfiles/c4ca4238a0b923820dcc509a6f75849b/images/dezhub_logo.png" style="width: 200px; height: 200px; float: left; margin: 5px; border-width: 0px; border-style: solid;" />Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Â <br />\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Â <br />\r\n<br />\r\n<em>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Â </em><br />\r\n<br />\r\nExcepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Â <br />\r\n<br />\r\nExcepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 1, NULL, '2013-11-06 03:03:06', '2013-11-06 03:03:06', 'post', 'lorem-link-ipsum-dolor-sit-amet', 'http://nhocconvn.local/public/upload/userfiles/c4ca4238a0b923820dcc509a6f75849b/images/dezhub_logo.png', NULL, 1),
(2, 'Lorem ipsum dolor sit amet', '', '<span style="line-height: 1.6em;">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Â </span><br />\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Â <br />\r\n<br />\r\nExcepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Â <br />\r\n<br />\r\n<strong>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Â </strong><br />\r\n<br />\r\nExcepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 1, NULL, '2013-11-06 03:04:17', '2013-11-06 03:04:17', 'page', 'lorem-ipsum-dolor-sit-amet', 'http://nhocconvn.local/public/upload/userfiles/c4ca4238a0b923820dcc509a6f75849b/images/dezhub_logo.png', NULL, 1),
(3, 'aaaaa', '1', NULL, 1, NULL, '2013-11-06 04:54:27', '2013-11-06 04:54:27', 'slideshow', NULL, 'http://nhocconvn.local/public/upload/userfiles/c4ca4238a0b923820dcc509a6f75849b/images/c70.png', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dz_roll`
--

CREATE TABLE IF NOT EXISTS `dz_roll` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `ordered` tinyint(4) DEFAULT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `dz_roll`
--

INSERT INTO `dz_roll` (`id`, `name`, `icon`, `ordered`, `editable`, `title`) VALUES
(1, 'add', 'icon-plus', 1, 1, 'ThÃªm má»›i'),
(2, 'edit', 'icon-pencil', 2, 1, 'Sá»­a dá»¯ liá»‡u'),
(3, 'delete', 'icon-remove', 3, 1, 'XÃ³a'),
(4, 'multi_delete', 'icon-remove', 4, 1, 'XÃ³a háº¿t'),
(5, 'publish', 'icon-ok', 6, 1, 'KÃ­ch hoáº¡t'),
(6, 'unpublish', 'icon-remove', 7, 1, 'Há»§y kÃ­ch hoáº¡t');

-- --------------------------------------------------------

--
-- Table structure for table `dz_system`
--

CREATE TABLE IF NOT EXISTS `dz_system` (
  `System_ID` int(11) NOT NULL AUTO_INCREMENT,
  `System_Name` varchar(100) DEFAULT NULL,
  `System_Value` text,
  `System_Code` varchar(100) DEFAULT NULL,
  `System_Type` varchar(225) NOT NULL DEFAULT 'text' COMMENT 'text|number|checkbox|radio|date',
  `System_LangID` int(11) DEFAULT NULL,
  PRIMARY KEY (`System_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dz_term_taxonomy`
--

CREATE TABLE IF NOT EXISTS `dz_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `dz_term_taxonomy`
--

INSERT INTO `dz_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'post_meta_title', 'Lorem link ipsum dolor sit amet', 0, 0),
(2, 1, 'post_meta_description', 'Lorem link ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ', 0, 0),
(3, 2, 'page_meta_title', 'Lorem ipsum dolor sit amet', 0, 0),
(4, 2, 'page_meta_description', 'Lorem ipsum dolor sit amet.', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `dz_user`
--

CREATE TABLE IF NOT EXISTS `dz_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(225) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fullname` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `interests` longtext,
  `facebook` varchar(200) DEFAULT NULL,
  `job` varchar(200) DEFAULT NULL,
  `birthday` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='dz_user' AUTO_INCREMENT=57 ;

--
-- Dumping data for table `dz_user`
--

INSERT INTO `dz_user` (`id`, `username`, `password`, `email`, `phone`, `gender`, `active`, `user_type_id`, `status`, `create_date`, `fullname`, `avatar`, `website`, `interests`, `facebook`, `job`, `birthday`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'dinhhungvn@gmail.com', '0988888888', 1, 1, 1, 1, '2009-01-07 01:47:26', 'Äinh VÄƒn HÆ°ng', 'http://nhocconvn.local/public/upload/userfiles/c4ca4238a0b923820dcc509a6f75849b/images/dezhub_logo.png', 'http%3A%2F%2Fdantri.com.vn', 'NÃ³i Ã­t lÃ m nhiá»u hÆ¡n..', 'https%3A%2F%2Ffacebook.com%2Fhungdv', 'BiÃªn táº­p viÃªn', '30/02/2000');

-- --------------------------------------------------------

--
-- Table structure for table `dz_useronline`
--

CREATE TABLE IF NOT EXISTS `dz_useronline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  `timestamp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dz_usertype_moduleroll`
--

CREATE TABLE IF NOT EXISTS `dz_usertype_moduleroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_id` int(11) NOT NULL,
  `module_roll_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=797 ;

--
-- Dumping data for table `dz_usertype_moduleroll`
--

INSERT INTO `dz_usertype_moduleroll` (`id`, `user_type_id`, `module_roll_id`) VALUES
(796, 11, 286),
(795, 11, 285),
(794, 11, 284),
(793, 11, 283),
(792, 11, 282),
(791, 11, 281),
(778, 11, 236),
(777, 11, 235),
(776, 11, 234),
(775, 11, 233),
(774, 11, 232),
(773, 11, 231);

-- --------------------------------------------------------

--
-- Table structure for table `dz_user_type`
--

CREATE TABLE IF NOT EXISTS `dz_user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `permission` text,
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `dz_user_type`
--

INSERT INTO `dz_user_type` (`id`, `name`, `permission`, `editable`) VALUES
(1, 'Quáº£n trá»‹ cao cáº¥p', 'NhÃ³m cÃ³ quyá»n cao nháº¥t, quáº£n lÃ½ má»i chá»©c nÄƒng há»‡ thá»‘ng...', 0),
(11, 'BiÃªn táº­p viÃªn', 'NhÃ³m chá»‰ cÃ³ quyá»n xuáº¥t báº£n bÃ i viáº¿t...', 1),
(12, 'Quáº£n trá»‹ sáº£n pháº©m', 'Chá»‰ Ä‘Æ°á»£c phÃ©p quáº£n trá»‹ cÃ¡c ná»™i dung liÃªn quan Ä‘áº¿n sáº£n pháº©m vÃ  Ä‘Æ¡n hÃ ng', 1),
(13, 'Demo', 'NhÃ³m demo xem cÃ¡c chá»©c nÄƒng', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
