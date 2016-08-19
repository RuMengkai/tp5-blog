drop database if exists vueblog;

create database vueblog;

use vueblog;

grant select, insert, update, delete on vueblog.* to "www-data"@"localhost" identified by "www-data";

CREATE TABLE `lauth` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(6) UNSIGNED NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `create_time` int(11) UNSIGNED NOT NULL,
  `update_time` int(11) UNSIGNED NOT NULL,
  unique key `idx_username` (`username`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `oauth` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(6) UNSIGNED NOT NULL,
  `oauth_name` varchar(25) NOT NULL,
  `oauth_id` varchar(50) NOT NULL,
  `oauth_access_token` varchar(50) NOT NULL,
  `oauth_expires` varchar(50) NOT NULL,
  `create_time` int(11) UNSIGNED NOT NULL,
  `update_time` int(11) UNSIGNED NOT NULL,
  unique key `idx_oauth_id` (`oauth_id`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nickname` varchar(25) NOT NULL,
  `birthday` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `create_time` int(11) UNSIGNED NOT NULL,
  `update_time` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `blog` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) not null,
  `content` mediumtext not null,
  `user_id` int(6) UNSIGNED NOT NULL,
  `create_time` int(11) UNSIGNED NOT NULL,
  `update_time` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `comment` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` mediumtext not null,
  `user_id` int(6) UNSIGNED NOT NULL,
  `blog_id` int(6) UNSIGNED NOT NULL,
  `create_time` int(11) UNSIGNED NOT NULL,
  `update_time` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
