-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-01-02 08:09:59
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `education`
--

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_title` varchar(20) NOT NULL,
  `article_content` varchar(3000) NOT NULL,
  `article_type` int(11) NOT NULL,
  `img` varchar(300) DEFAULT NULL,
  `key_word` varchar(100) DEFAULT NULL,
  `click_num` int(11) NOT NULL DEFAULT '0',
  `hot` tinyint(4) DEFAULT NULL,
  `create_time` timestamp NOT NULL,
  `user` int(11) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`id`),
  KEY `article_type` (`article_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`id`, `article_title`, `article_content`, `article_type`, `img`, `key_word`, `click_num`, `hot`, `create_time`, `user`) VALUES
(7, '测试', '测试测试测试测试测试测试测试测试', 1, '/home/images/1.jpg', '测试测试测试测试测试', 6, 1, '2016-12-29 10:59:44', 1),
(8, '测试2', '测试测试测试测试测试测试测试测试22222222', 1, '/home/images/1.jpg', '测试测试测试测试测试222222', 2, 1, '2016-12-29 11:03:00', 1),
(9, '世界和你', '其实啥都没有', 1, NULL, NULL, 1, 1, '2016-12-30 02:40:30', 1),
(11, '芝麻与绿豆，还有糖', '就是绿豆糖水咯', 2, 'images/1.jgp', NULL, 0, 1, '2016-12-30 02:47:22', 1);

-- --------------------------------------------------------

--
-- 表的结构 `article_type`
--

CREATE TABLE IF NOT EXISTS `article_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `article_type`
--

INSERT INTO `article_type` (`id`, `type_name`) VALUES
(1, '创新与科技'),
(2, '生活与艺术');

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `comment_content` varchar(300) NOT NULL,
  `comment_type` int(11) NOT NULL DEFAULT '0',
  `src_id` int(11) NOT NULL,
  `create_time` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `comment_content`, `comment_type`, `src_id`, `create_time`) VALUES
(1, 2, 'asfs', 2, 1, '2016-12-31 14:51:07'),
(2, 2, 'sdsdga', 2, 1, '2016-12-31 14:51:48'),
(3, 2, 'sdfds', 2, 1, '2016-12-31 14:52:52'),
(4, 2, 'caccc', 2, 1, '2016-12-31 14:53:55'),
(5, 2, 'saddg', 2, 1, '2016-12-31 14:57:45'),
(6, 2, ' sdfa', 2, 1, '2016-12-31 14:58:03'),
(7, 2, ' sdfsdf', 2, 1, '2016-12-31 14:58:40'),
(8, 2, 'sdfsdfsdfa', 2, 0, '2016-12-31 15:02:37'),
(9, 2, 'sdfadffd', 2, 0, '2016-12-31 15:04:52'),
(10, 2, ' sdfs', 2, 1, '2016-12-31 15:12:37'),
(11, 2, 'fsdfg', 2, 1, '2016-12-31 15:14:23');

-- --------------------------------------------------------

--
-- 表的结构 `community`
--

CREATE TABLE IF NOT EXISTS `community` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comm_name` varchar(20) NOT NULL,
  `comm_type` int(11) NOT NULL,
  `comm_icon` varchar(300) DEFAULT NULL,
  `comm_info` varchar(500) NOT NULL,
  `create_user` int(11) NOT NULL,
  `create_time` timestamp NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `hot` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `create_user` (`create_user`),
  KEY `comm_type` (`comm_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `community`
--

INSERT INTO `community` (`id`, `comm_name`, `comm_type`, `comm_icon`, `comm_info`, `create_user`, `create_time`, `status`, `hot`) VALUES
(2, '芝麻与绿豆', 1, 'images/1.jpg', '随便说说', 1, '2016-12-30 01:13:19', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `community_type`
--

CREATE TABLE IF NOT EXISTS `community_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `community_type`
--

INSERT INTO `community_type` (`id`, `type_name`) VALUES
(1, '创新与科技'),
(2, '生活与艺术');

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(20) NOT NULL,
  `course_info` varchar(500) DEFAULT NULL,
  `course_icon` varchar(300) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `video_url` varchar(200) DEFAULT NULL,
  `create_user` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `student_num` int(11) NOT NULL DEFAULT '0',
  `click_num` int(11) NOT NULL DEFAULT '0',
  `score` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `create_user` (`create_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `course_chapter`
--

CREATE TABLE IF NOT EXISTS `course_chapter` (
  `course_id` int(11) NOT NULL,
  `chapter_no` int(11) NOT NULL,
  `start_no` int(11) NOT NULL,
  PRIMARY KEY (`course_id`,`chapter_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `course_content`
--

CREATE TABLE IF NOT EXISTS `course_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `course_no` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `content_info` varchar(500) NOT NULL,
  `video_url` varchar(300) NOT NULL,
  `create_user` int(11) NOT NULL,
  `create_time` timestamp NOT NULL,
  `click_num` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `create_user` (`create_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `course_type`
--

CREATE TABLE IF NOT EXISTS `course_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL,
  `has_sub` tinyint(4) NOT NULL DEFAULT '0',
  `father_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sys`
--

CREATE TABLE IF NOT EXISTS `sys` (
  `key` varchar(20) NOT NULL,
  `value` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_title` varchar(20) NOT NULL,
  `comm_id` int(11) NOT NULL,
  `article_content` varchar(3000) NOT NULL,
  `click_num` int(11) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comm_id` (`comm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `topic`
--

INSERT INTO `topic` (`id`, `topic_title`, `comm_id`, `article_content`, `click_num`, `create_time`, `user_id`) VALUES
(1, '测试测试', 2, '测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试', 49, '2016-12-31 07:06:05', 1),
(2, '这是话题', 2, '这是话题这是话题这是话题这是话题这是话题这是话题这是话题这是话题这是话题这是话题这是话题这是话题', 2, '2016-12-31 07:06:05', 1),
(3, '测试测试', 2, '测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试', 1, '2016-12-31 07:07:14', 1);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `user_pwd` varchar(32) NOT NULL,
  `user_icon` varchar(300) DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `power` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `user_name`, `user_pwd`, `user_icon`, `phone`, `email`, `power`) VALUES
(1, 'xcps', '1', 'images/1.jpg', '10086', 'admin@admin.com', 1),
(2, 'CHEN', 'e10adc3949ba59abbe56e057f20f883e', 'default.jpg', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `user_community`
--

CREATE TABLE IF NOT EXISTS `user_community` (
  `user_id` int(11) NOT NULL,
  `commid` int(11) NOT NULL,
  `create_time` timestamp NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `power` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`commid`),
  KEY `commid` (`commid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_community`
--

INSERT INTO `user_community` (`user_id`, `commid`, `create_time`, `status`, `power`) VALUES
(2, 2, '0000-00-00 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user_course`
--

CREATE TABLE IF NOT EXISTS `user_course` (
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `create_time` timestamp NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `power` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`course_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 表的结构 `index_banner`
--

CREATE TABLE `index_banner` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `img_url` varchar(200) NOT NULL,
   `link` varchar(200) DEFAULT NULL,
   PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 限制导出的表
--

--
-- 限制表 `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`article_type`) REFERENCES `article_type` (`id`);

--
-- 限制表 `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- 限制表 `community`
--
ALTER TABLE `community`
  ADD CONSTRAINT `community_ibfk_1` FOREIGN KEY (`create_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `community_ibfk_2` FOREIGN KEY (`comm_type`) REFERENCES `community_type` (`id`);

--
-- 限制表 `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `course_type` (`id`),
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`create_user`) REFERENCES `user` (`id`);

--
-- 限制表 `course_chapter`
--
ALTER TABLE `course_chapter`
  ADD CONSTRAINT `course_chapter_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);

--
-- 限制表 `course_content`
--
ALTER TABLE `course_content`
  ADD CONSTRAINT `course_content_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `course_content_ibfk_2` FOREIGN KEY (`create_user`) REFERENCES `user` (`id`);

--
-- 限制表 `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`comm_id`) REFERENCES `community` (`id`);

--
-- 限制表 `user_community`
--
ALTER TABLE `user_community`
  ADD CONSTRAINT `user_community_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_community_ibfk_2` FOREIGN KEY (`commid`) REFERENCES `community` (`id`);

--
-- 限制表 `user_course`
--
ALTER TABLE `user_course`
  ADD CONSTRAINT `user_course_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_course_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
