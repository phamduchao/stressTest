/*
 Navicat Premium Data Transfer

 Source Server         : Tivi
 Source Server Type    : MySQL
 Source Server Version : 50542
 Source Host           : localhost:3306
 Source Schema         : stressTest

 Target Server Type    : MySQL
 Target Server Version : 50542
 File Encoding         : 65001

 Date: 13/01/2020 11:53:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for api_data
-- ----------------------------
DROP TABLE IF EXISTS `api_data`;
CREATE TABLE `api_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jsonText` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
