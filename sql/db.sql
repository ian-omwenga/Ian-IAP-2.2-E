/*USE ics_e;

CREATE IF NOT EXISTS TABLE users(
  userId bigint(10) not null auto_increment,
  fullname varchar(50) not null default"",
  email varchar(50) not null default"",
  username varchar(50) not null default"",
  password varchar(60) not null default"",
  updated datetime not null default current_timestamp () on update current_timestamp(),
  created datetime not null default current_timestamp(),
  genderId tinyint(1) not null default "0",
  roleId tinyint(1) not null default "0",
  UNIQUE KEY ('username'),
  UNIQUE KEY ('email'),
  UNIQUE KEY ('userId'),
);
*/


DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` bigint(10) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(60) NOT NULL DEFAULT '',
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `genderId` tinyint(1) NOT NULL DEFAULT 0,
  `roleId` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `genderId` (`genderId`),
  KEY `roleId` (`roleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



DROP DATABASE IF EXISTS `ics_e`;
CREATE DATABASE IF NOT EXISTS `ics_e` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ics_e`;



DROP TABLE IF EXISTS `gender`;
CREATE TABLE IF NOT EXISTS `gender` (
  `genderId` tinyint(1) NOT NULL AUTO_INCREMENT,
  `gender` varchar(20) NOT NULL DEFAULT '',
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`genderId`),
  UNIQUE KEY `gender` (`gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `roleId` tinyint(1) NOT NULL AUTO_INCREMENT,
  `role` varchar(15) NOT NULL DEFAULT '',
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`roleId`),
  UNIQUE KEY `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



ALTER TABLE `gender`
  ADD CONSTRAINT `gender_ibfk_1` FOREIGN KEY (`genderId`) REFERENCES `users` (`genderId`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `users` (`roleId`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`genderId`) REFERENCES `gender` (`genderId`) ON DELETE NO ACTION,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`roleId`) REFERENCES `roles` (`roleId`) ON DELETE NO ACTION;
COMMIT;

