-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-06-22 04:38:06
-- 服务器版本： 5.5.18
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `auth`
--
CREATE DATABASE IF NOT EXISTS `auth` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `auth`;

-- --------------------------------------------------------

--
-- 表的结构 `authdata`
--

DROP TABLE IF EXISTS `authdata`;
CREATE TABLE IF NOT EXISTS `authdata` (
  `auth_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `auth_moren` int(1) NOT NULL,
  `auth_name` varchar(80) CHARACTER SET utf8 NOT NULL COMMENT '安全令备注',
  `serial` varchar(20) CHARACTER SET utf8 NOT NULL,
  `region` varchar(10) CHARACTER SET utf8 NOT NULL,
  `secret` varchar(60) CHARACTER SET utf8 NOT NULL,
  `restore_code` varchar(20) NOT NULL,
  `auth_img` int(1) NOT NULL,
  PRIMARY KEY (`auth_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `cookiedata`
--

DROP TABLE IF EXISTS `cookiedata`;
CREATE TABLE IF NOT EXISTS `cookiedata` (
  `cookie_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_name` varchar(60) CHARACTER SET utf8 NOT NULL,
  `user_cookie` varchar(40) CHARACTER SET utf8 NOT NULL,
  `login_time` datetime NOT NULL,
  `user_login_ip` varchar(192) NOT NULL,
  PRIMARY KEY (`cookie_id`),
  KEY `cookie_id` (`cookie_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `synctime`
--

DROP TABLE IF EXISTS `synctime`;
CREATE TABLE IF NOT EXISTS `synctime` (
  `region` char(4) NOT NULL,
  `sync` bigint(20) NOT NULL,
  `last_sync` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `user_name` varchar(60) CHARACTER SET utf8 NOT NULL COMMENT '用户名',
  `user_pass` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '用户密码',
  `user_right` int(1) unsigned NOT NULL DEFAULT '0',
  `user_email` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '用户邮箱',
  `user_email_checked` int(1) NOT NULL,
  `user_registered` datetime NOT NULL COMMENT '用户注册时间',
  `user_question` bigint(20) NOT NULL,
  `user_answer` varchar(40) CHARACTER SET utf8 NOT NULL,
  `user_email_checkid` varchar(60) CHARACTER SET utf8 NOT NULL,
  `user_email_find_code` varchar(60) CHARACTER SET utf8 NOT NULL,
  `user_email_find_mode` int(1) NOT NULL,
  `user_psd_reset_token` varchar(80) NOT NULL,
  `user_psd_reset_token_used` int(1) NOT NULL,
  `user_lastlogin_ip` varchar(192) NOT NULL,
  `user_thistimelogin_ip` varchar(192) NOT NULL,
  `user_lastlogin_time` datetime NOT NULL,
  `user_thislogin_time` datetime NOT NULL,
  `lastused_session_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
