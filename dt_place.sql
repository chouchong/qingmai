/*
Navicat MySQL Data Transfer

Source Server         : phpstudy
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : qingmai

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-04-26 11:16:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dt_place
-- ----------------------------
DROP TABLE IF EXISTS `dt_place`;
CREATE TABLE `dt_place` (
  `placeId` int(11) NOT NULL AUTO_INCREMENT,
  `placeName` varchar(50) DEFAULT NULL,
  `placePhone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`placeId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dt_place
-- ----------------------------
INSERT INTO `dt_place` VALUES ('1', '昆明市穿金路白字路白字路白字小区11-3栋', '0871-65096386');
INSERT INTO `dt_place` VALUES ('2', '昆明市穿金路白字路白字路白字小区', '0871-65096386');
INSERT INTO `dt_place` VALUES ('3', '昆明市穿金路白字路白字路白字小区11-3栋', '0871-65096386');
