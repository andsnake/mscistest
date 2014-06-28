/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : eshop

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-06-28 11:39:21
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
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', null, 'Genres');
INSERT INTO `category` VALUES ('2', '1', 'Action ');
INSERT INTO `category` VALUES ('3', '1', 'Horror');
INSERT INTO `category` VALUES ('4', '1', 'Comedy');
INSERT INTO `category` VALUES ('6', null, 'Action Figures');
INSERT INTO `category` VALUES ('7', '6', 'Plastic');

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
-- Records of image
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('36', '2014-06-27 17:07:47', '0000-00-00 00:00:00', '1', '10100', '0', '53ada4e3b86c9');
INSERT INTO `order` VALUES ('37', '2014-06-27 17:08:33', '0000-00-00 00:00:00', '1', '10100', '0', '53ada511d2ba8');
INSERT INTO `order` VALUES ('38', '2014-06-27 17:08:36', '0000-00-00 00:00:00', '1', '10100', '0', '53ada5144c861');
INSERT INTO `order` VALUES ('39', '2014-06-27 17:08:37', '0000-00-00 00:00:00', '1', '10100', '0', '53ada5158c816');
INSERT INTO `order` VALUES ('40', '2014-06-27 17:08:39', '0000-00-00 00:00:00', '1', '10100', '0', '53ada51703d0d');
INSERT INTO `order` VALUES ('41', '2014-06-27 17:08:46', '0000-00-00 00:00:00', '1', '9090', '0', '53ada51ecad8b');

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
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('123456789AAA', 'Lorem Ipsum is simply dummy text of the printing and typesetting', '5000', '100', null, 'test addition');
INSERT INTO `product` VALUES ('2234242wss23', 'Lorem Ipsum is simply dummy text of the printing and typesetting', '50', '10', null, 'test addition');
INSERT INTO `product` VALUES ('aaaaaaaaaaaf8950', 'Lorem Ipsum is simply dummy text of the printing and typesetting', '50', '10', null, 'test addition');
INSERT INTO `product` VALUES ('aasdadadadadada2', 'Lorem Ipsum is simply dummy text of the printing and typesetting', '50', '10', null, 'test addition');
INSERT INTO `product` VALUES ('aasefasr43432', 'Lorem Ipsum is simply dummy text of the printing and typesetting', '50', '10', null, 'test addition');
INSERT INTO `product` VALUES ('thisisanothertestREST', 'Lorem Ipsum is simply dummy text of the printing and typesetting', '5000', '100', null, 'test addition');
INSERT INTO `product` VALUES ('thisisanothertestREST2', 'Lorem Ipsum is simply dummy text of the printing and typesetting', '5000', '100', '2014-06-24 16:25:55', 'test addition');

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
-- Records of products_categories
-- ----------------------------
INSERT INTO `products_categories` VALUES ('123456789AAA', '1');
INSERT INTO `products_categories` VALUES ('aasdadadadadada2', '1');
INSERT INTO `products_categories` VALUES ('2234242wss23', '1');
INSERT INTO `products_categories` VALUES ('thisisanothertestREST', '2');
INSERT INTO `products_categories` VALUES ('aasefasr43432', '2');

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
-- Records of products_images
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of products_orders
-- ----------------------------
INSERT INTO `products_orders` VALUES ('36', 'thisisanothertestREST2', '8', '2');
INSERT INTO `products_orders` VALUES ('36', '2234242wss23', '9', '2');
INSERT INTO `products_orders` VALUES ('37', 'thisisanothertestREST2', '10', '2');
INSERT INTO `products_orders` VALUES ('37', '2234242wss23', '11', '2');
INSERT INTO `products_orders` VALUES ('38', 'thisisanothertestREST2', '12', '2');
INSERT INTO `products_orders` VALUES ('38', '2234242wss23', '13', '2');
INSERT INTO `products_orders` VALUES ('39', 'thisisanothertestREST2', '14', '2');
INSERT INTO `products_orders` VALUES ('39', '2234242wss23', '15', '2');
INSERT INTO `products_orders` VALUES ('40', 'thisisanothertestREST2', '16', '2');
INSERT INTO `products_orders` VALUES ('40', '2234242wss23', '17', '2');
INSERT INTO `products_orders` VALUES ('41', 'thisisanothertestREST2', '18', '2');
INSERT INTO `products_orders` VALUES ('41', '2234242wss23', '19', '2');

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

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'andsnake', '0a97f3ccfbd8095e0eccb023d180312e', '161146351153a6cff01c4516.51321635', 'antoniougeo@gmail.com', 'george', 'antoniou', '6947343012', '1', '0');
INSERT INTO `user` VALUES ('7', 'dokimastis', '124673d06d0dd4a8948a4045ba9bf6fc', '65950209853ad7341139cc1.59869642', 'john@server.department.company.com', 'asdasdads', 'asdadasd', '1234567890', '0', '0');
INSERT INTO `user` VALUES ('8', 'andsnake2', '7074333871095338eb391cf40ec58f38', '189858028653ade4b24e1fe8.16526209', 'antoniougeocy@gmail.com', 'asdasdads', 'asdadasd', '1234567890', '0', '0');
