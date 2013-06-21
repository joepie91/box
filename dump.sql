SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `UserId` bigint(20) unsigned NOT NULL,
  `PostId` bigint(20) unsigned NOT NULL,
  `ParentId` bigint(20) unsigned NOT NULL,
  `Posted` timestamp NULL DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL,
  `GuestPost` tinyint(1) NOT NULL,
  `Body` text NOT NULL,
  `Name` varchar(50) NOT NULL,
  `EmailAddress` varchar(256) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Views` bigint(20) unsigned NOT NULL,
  `UserId` bigint(20) unsigned NOT NULL,
  `Title` varchar(350) NOT NULL,
  `Body` mediumtext NOT NULL,
  `Posted` timestamp NULL DEFAULT NULL,
  `LastEdited` timestamp NULL DEFAULT NULL,
  `Slug` varchar(350) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `blog_tags` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `PostId` bigint(20) unsigned NOT NULL,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `forum_categories` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `forum_posts` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `AuthorId` bigint(20) unsigned NOT NULL,
  `ThreadId` bigint(20) unsigned NOT NULL,
  `Revision` int(10) unsigned NOT NULL,
  `Body` text NOT NULL,
  `Visible` tinyint(1) NOT NULL,
  `LatestRevision` tinyint(1) NOT NULL,
  `PostedDate` timestamp NULL DEFAULT NULL,
  `LastEditedDate` timestamp NULL DEFAULT NULL,
  `EditExpiry` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `forum_tags` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ThreadId` bigint(20) unsigned NOT NULL,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `forum_threads` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CreatorId` bigint(20) unsigned NOT NULL,
  `CategoryId` bigint(20) unsigned NOT NULL,
  `PostCount` int(10) unsigned NOT NULL,
  `Topic` varchar(200) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT NULL,
  `LastReplyDate` timestamp NULL DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL,
  `Slug` varchar(200) NOT NULL,
  `Locked` tinyint(1) NOT NULL,
  `Pinned` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Username` varchar(24) NOT NULL,
  `EmailAddress` varchar(256) NOT NULL,
  `Hash` varchar(43) NOT NULL,
  `Salt` varchar(10) NOT NULL,
  `ActivationKey` varchar(32) NOT NULL,
  `Signature` varchar(384) NOT NULL,
  `Admin` tinyint(1) NOT NULL,
  `Activated` tinyint(1) NOT NULL,
  `Banned` tinyint(1) NOT NULL,
  `RegistrationDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
