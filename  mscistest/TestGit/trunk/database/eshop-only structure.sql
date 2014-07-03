/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : eshop

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-07-01 17:21:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `CATID` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `cat_name` varchar(50) NOT NULL,
  PRIMARY KEY (`CATID`),
  KEY `FK_perent` (`parent`),
  CONSTRAINT `FK_perent` FOREIGN KEY (`parent`) REFERENCES `category` (`CATID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for image
-- ----------------------------
DROP TABLE IF EXISTS `image`;
CREATE TABLE `image` (
  `IMGID` int(11) NOT NULL AUTO_INCREMENT,
  `File` longblob NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IMGID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `OID` int(11) NOT NULL AUTO_INCREMENT,
  `date_made` datetime DEFAULT NULL,
  `date_due` datetime DEFAULT NULL,
  `UID` int(11) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`OID`),
  KEY `UID_FK` (`UID`),
  CONSTRAINT `UID_FK` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `SKU` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`SKU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for products_categories
-- ----------------------------
DROP TABLE IF EXISTS `products_categories`;
CREATE TABLE `products_categories` (
  `SKU` varchar(255) DEFAULT NULL,
  `CATID` int(11) DEFAULT NULL,
  KEY `SKU_PR_FK` (`SKU`),
  KEY `CATID_FK` (`CATID`),
  CONSTRAINT `CATID_FK` FOREIGN KEY (`CATID`) REFERENCES `category` (`CATID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `SKU_PR_FK` FOREIGN KEY (`SKU`) REFERENCES `product` (`SKU`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for products_images
-- ----------------------------
DROP TABLE IF EXISTS `products_images`;
CREATE TABLE `products_images` (
  `SKU` varchar(255) DEFAULT NULL,
  `IMGID` int(11) DEFAULT NULL,
  KEY `SKU_PR` (`SKU`),
  KEY `IMGID_FK` (`IMGID`),
  CONSTRAINT `IMGID_FK` FOREIGN KEY (`IMGID`) REFERENCES `image` (`IMGID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `SKU_PR` FOREIGN KEY (`SKU`) REFERENCES `product` (`SKU`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for products_orders
-- ----------------------------
DROP TABLE IF EXISTS `products_orders`;
CREATE TABLE `products_orders` (
  `OID` int(11) NOT NULL,
  `SKU` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_OID_PR` (`OID`),
  KEY `FK_SKU_O` (`SKU`),
  CONSTRAINT `FK_OID_PR` FOREIGN KEY (`OID`) REFERENCES `order` (`OID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_SKU_O` FOREIGN KEY (`SKU`) REFERENCES `product` (`SKU`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `level` tinyint(4) DEFAULT NULL COMMENT '0=normal byer, 1=gold buyer',
  `access` tinyint(4) NOT NULL COMMENT '0= normal user, 1= super user(admin)',
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
