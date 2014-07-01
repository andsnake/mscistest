/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : eshop

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-07-01 17:21:27
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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('36', '2014-06-27 17:07:47', '0000-00-00 00:00:00', '1', '10100', '0', '53ada4e3b86c9');
INSERT INTO `order` VALUES ('37', '2014-06-27 17:08:33', '0000-00-00 00:00:00', '1', '10100', '0', '53ada511d2ba8');
INSERT INTO `order` VALUES ('38', '2014-06-27 17:08:36', '0000-00-00 00:00:00', '1', '10100', '0', '53ada5144c861');
INSERT INTO `order` VALUES ('39', '2014-06-27 17:08:37', '0000-00-00 00:00:00', '1', '10100', '0', '53ada5158c816');
INSERT INTO `order` VALUES ('40', '2014-06-27 17:08:39', '0000-00-00 00:00:00', '1', '10100', '0', '53ada51703d0d');
INSERT INTO `order` VALUES ('41', '2014-06-27 17:08:46', '0000-00-00 00:00:00', '1', '9090', '0', '53ada51ecad8b');
INSERT INTO `order` VALUES ('42', '2014-06-28 17:10:10', '0000-00-00 00:00:00', '1', '45', '0', '53aef6f2e76b5');
INSERT INTO `order` VALUES ('43', '2014-06-28 17:10:34', '0000-00-00 00:00:00', '1', '45', '0', '53aef70ae4ec1');
INSERT INTO `order` VALUES ('44', '2014-06-28 17:12:16', '0000-00-00 00:00:00', '1', '4545', '0', '53aef77033129');
INSERT INTO `order` VALUES ('45', '2014-06-28 17:14:21', '0000-00-00 00:00:00', '1', '4545', '0', '53aef7ee0dc05');
INSERT INTO `order` VALUES ('46', '2014-06-28 17:15:38', '0000-00-00 00:00:00', '1', '4545', '0', '53aef83a9e2b9');
INSERT INTO `order` VALUES ('47', '2014-06-28 17:15:43', '0000-00-00 00:00:00', '1', '4545', '0', '53aef83f79b01');
INSERT INTO `order` VALUES ('48', '2014-06-28 17:19:31', '0000-00-00 00:00:00', '1', '4545', '0', '53aef923926d1');
INSERT INTO `order` VALUES ('49', '2014-06-28 17:20:35', '0000-00-00 00:00:00', '1', '4545', '0', '53aef96354f7a');
INSERT INTO `order` VALUES ('50', '2014-06-28 17:21:06', '0000-00-00 00:00:00', '1', '4545', '0', '53aef982aeb19');
INSERT INTO `order` VALUES ('51', '2014-06-29 13:14:56', '0000-00-00 00:00:00', '1', '13635', '0', '53b0115076476');
INSERT INTO `order` VALUES ('52', '2014-06-30 17:24:26', '0000-00-00 00:00:00', '8', '5000', '0', '53b19d4a6086c');
INSERT INTO `order` VALUES ('53', '2014-06-30 17:25:08', '0000-00-00 00:00:00', '8', '10050', '0', '53b19d748abe1');
INSERT INTO `order` VALUES ('54', '2014-06-30 17:25:32', '0000-00-00 00:00:00', '8', '10050', '0', '53b19d8c19f28');
INSERT INTO `order` VALUES ('55', '2014-06-30 17:25:45', '0000-00-00 00:00:00', '8', '5050', '0', '53b19d99c4a92');
INSERT INTO `order` VALUES ('56', '2014-06-30 17:25:51', '0000-00-00 00:00:00', '8', '5050', '0', '53b19d9f6e98e');
INSERT INTO `order` VALUES ('57', '2014-06-30 17:26:29', '0000-00-00 00:00:00', '8', '4545', '0', '53b19dc5a1c2d');
INSERT INTO `order` VALUES ('58', '2014-06-30 17:32:02', '0000-00-00 00:00:00', '8', '4545', '0', '53b19f1240617');
INSERT INTO `order` VALUES ('59', '2014-06-30 18:09:49', '0000-00-00 00:00:00', '7', '5050', '0', '53b1a7ed4021a');
INSERT INTO `order` VALUES ('60', '2014-06-30 18:10:09', '0000-00-00 00:00:00', '7', '20250', '0', '53b1a8015206f');
INSERT INTO `order` VALUES ('61', '2014-06-30 18:10:13', '0000-00-00 00:00:00', '7', '20250', '0', '53b1a805cbd66');
INSERT INTO `order` VALUES ('62', '2014-06-30 18:10:18', '0000-00-00 00:00:00', '7', '20250', '0', '53b1a80aa2ff6');
INSERT INTO `order` VALUES ('63', '2014-06-30 18:10:23', '0000-00-00 00:00:00', '7', '20250', '0', '53b1a80f95030');
INSERT INTO `order` VALUES ('64', '2014-06-30 18:11:52', '0000-00-00 00:00:00', '7', '18225', '0', '53b1a86879e9e');
INSERT INTO `order` VALUES ('65', '2014-07-01 13:09:17', '0000-00-00 00:00:00', '1', '4545', '0', '53b2b2fd1d805');
INSERT INTO `order` VALUES ('66', '2014-07-01 13:11:15', '0000-00-00 00:00:00', '1', '45', '0', '53b2b3730deaf');
INSERT INTO `order` VALUES ('67', '2014-07-01 13:12:53', '0000-00-00 00:00:00', '1', '45', '0', '53b2b3d5e102f');
INSERT INTO `order` VALUES ('68', '2014-07-01 13:37:25', '0000-00-00 00:00:00', '1', 'sJMAGh8bct3Pg2dRRTKRRMCGC7n2kagT9diG7CnvPCM=', '0', '53b2b99553a59');
INSERT INTO `order` VALUES ('69', '2014-07-01 13:39:34', '0000-00-00 00:00:00', '1', 'np34GLFDc5r+2Ax3fBUMUUj+k/U8pFerP7et5NeMJKM=', '0', '53b2ba1652f00');

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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

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
INSERT INTO `products_orders` VALUES ('42', '2234242wss23', '20', '1');
INSERT INTO `products_orders` VALUES ('43', '2234242wss23', '21', '1');
INSERT INTO `products_orders` VALUES ('44', '2234242wss23', '22', '1');
INSERT INTO `products_orders` VALUES ('44', '123456789AAA', '23', '1');
INSERT INTO `products_orders` VALUES ('45', '2234242wss23', '24', '1');
INSERT INTO `products_orders` VALUES ('45', '123456789AAA', '25', '1');
INSERT INTO `products_orders` VALUES ('46', '2234242wss23', '26', '1');
INSERT INTO `products_orders` VALUES ('46', '123456789AAA', '27', '1');
INSERT INTO `products_orders` VALUES ('47', '2234242wss23', '28', '1');
INSERT INTO `products_orders` VALUES ('47', '123456789AAA', '29', '1');
INSERT INTO `products_orders` VALUES ('48', '2234242wss23', '30', '1');
INSERT INTO `products_orders` VALUES ('48', '123456789AAA', '31', '1');
INSERT INTO `products_orders` VALUES ('49', '2234242wss23', '32', '1');
INSERT INTO `products_orders` VALUES ('49', '123456789AAA', '33', '1');
INSERT INTO `products_orders` VALUES ('50', '2234242wss23', '34', '1');
INSERT INTO `products_orders` VALUES ('50', '123456789AAA', '35', '1');
INSERT INTO `products_orders` VALUES ('51', '123456789AAA', '36', '1');
INSERT INTO `products_orders` VALUES ('51', '2234242wss23', '37', '1');
INSERT INTO `products_orders` VALUES ('51', 'aaaaaaaaaaaf8950', '38', '1');
INSERT INTO `products_orders` VALUES ('51', 'thisisanothertestREST', '39', '1');
INSERT INTO `products_orders` VALUES ('51', 'aasefasr43432', '40', '1');
INSERT INTO `products_orders` VALUES ('51', 'thisisanothertestREST2', '41', '1');
INSERT INTO `products_orders` VALUES ('52', '123456789AAA', '42', '1');
INSERT INTO `products_orders` VALUES ('53', 'thisisanothertestREST2', '43', '1');
INSERT INTO `products_orders` VALUES ('53', 'thisisanothertestREST', '44', '1');
INSERT INTO `products_orders` VALUES ('53', 'aasefasr43432', '45', '1');
INSERT INTO `products_orders` VALUES ('54', 'thisisanothertestREST2', '46', '1');
INSERT INTO `products_orders` VALUES ('54', 'thisisanothertestREST', '47', '1');
INSERT INTO `products_orders` VALUES ('54', 'aasefasr43432', '48', '1');
INSERT INTO `products_orders` VALUES ('55', 'thisisanothertestREST', '49', '1');
INSERT INTO `products_orders` VALUES ('55', 'aasefasr43432', '50', '1');
INSERT INTO `products_orders` VALUES ('56', 'thisisanothertestREST', '51', '1');
INSERT INTO `products_orders` VALUES ('56', 'aasefasr43432', '52', '1');
INSERT INTO `products_orders` VALUES ('57', 'thisisanothertestREST', '53', '1');
INSERT INTO `products_orders` VALUES ('57', 'aasefasr43432', '54', '1');
INSERT INTO `products_orders` VALUES ('58', 'thisisanothertestREST', '55', '1');
INSERT INTO `products_orders` VALUES ('58', 'aasefasr43432', '56', '1');
INSERT INTO `products_orders` VALUES ('59', 'thisisanothertestREST', '57', '1');
INSERT INTO `products_orders` VALUES ('59', 'aasefasr43432', '58', '1');
INSERT INTO `products_orders` VALUES ('60', '123456789AAA', '59', '1');
INSERT INTO `products_orders` VALUES ('60', '2234242wss23', '60', '1');
INSERT INTO `products_orders` VALUES ('60', 'aaaaaaaaaaaf8950', '61', '1');
INSERT INTO `products_orders` VALUES ('60', 'aasdadadadadada2', '62', '1');
INSERT INTO `products_orders` VALUES ('60', 'aasefasr43432', '63', '2');
INSERT INTO `products_orders` VALUES ('60', 'thisisanothertestREST', '64', '2');
INSERT INTO `products_orders` VALUES ('60', 'thisisanothertestREST2', '65', '1');
INSERT INTO `products_orders` VALUES ('61', '123456789AAA', '66', '1');
INSERT INTO `products_orders` VALUES ('61', '2234242wss23', '67', '1');
INSERT INTO `products_orders` VALUES ('61', 'aaaaaaaaaaaf8950', '68', '1');
INSERT INTO `products_orders` VALUES ('61', 'aasdadadadadada2', '69', '1');
INSERT INTO `products_orders` VALUES ('61', 'aasefasr43432', '70', '2');
INSERT INTO `products_orders` VALUES ('61', 'thisisanothertestREST', '71', '2');
INSERT INTO `products_orders` VALUES ('61', 'thisisanothertestREST2', '72', '1');
INSERT INTO `products_orders` VALUES ('62', '123456789AAA', '73', '1');
INSERT INTO `products_orders` VALUES ('62', '2234242wss23', '74', '1');
INSERT INTO `products_orders` VALUES ('62', 'aaaaaaaaaaaf8950', '75', '1');
INSERT INTO `products_orders` VALUES ('62', 'aasdadadadadada2', '76', '1');
INSERT INTO `products_orders` VALUES ('62', 'aasefasr43432', '77', '2');
INSERT INTO `products_orders` VALUES ('62', 'thisisanothertestREST', '78', '2');
INSERT INTO `products_orders` VALUES ('62', 'thisisanothertestREST2', '79', '1');
INSERT INTO `products_orders` VALUES ('63', '123456789AAA', '80', '1');
INSERT INTO `products_orders` VALUES ('63', '2234242wss23', '81', '1');
INSERT INTO `products_orders` VALUES ('63', 'aaaaaaaaaaaf8950', '82', '1');
INSERT INTO `products_orders` VALUES ('63', 'aasdadadadadada2', '83', '1');
INSERT INTO `products_orders` VALUES ('63', 'aasefasr43432', '84', '2');
INSERT INTO `products_orders` VALUES ('63', 'thisisanothertestREST', '85', '2');
INSERT INTO `products_orders` VALUES ('63', 'thisisanothertestREST2', '86', '1');
INSERT INTO `products_orders` VALUES ('64', '123456789AAA', '87', '1');
INSERT INTO `products_orders` VALUES ('64', '2234242wss23', '88', '1');
INSERT INTO `products_orders` VALUES ('64', 'aaaaaaaaaaaf8950', '89', '1');
INSERT INTO `products_orders` VALUES ('64', 'aasdadadadadada2', '90', '1');
INSERT INTO `products_orders` VALUES ('64', 'aasefasr43432', '91', '2');
INSERT INTO `products_orders` VALUES ('64', 'thisisanothertestREST', '92', '2');
INSERT INTO `products_orders` VALUES ('64', 'thisisanothertestREST2', '93', '1');
INSERT INTO `products_orders` VALUES ('65', 'aaaaaaaaaaaf8950', '94', '1');
INSERT INTO `products_orders` VALUES ('65', 'thisisanothertestREST', '95', '1');
INSERT INTO `products_orders` VALUES ('66', '2234242wss23', '96', '1');
INSERT INTO `products_orders` VALUES ('67', '2234242wss23', '97', '1');
INSERT INTO `products_orders` VALUES ('69', '123456789AAA', '98', '1');

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
INSERT INTO `user` VALUES ('7', 'dokimastis', '124673d06d0dd4a8948a4045ba9bf6fc', '65950209853ad7341139cc1.59869642', 'john@server.department.company.com', 'asdasdads', 'asdadasd', '1234567890', '1', '0');
INSERT INTO `user` VALUES ('8', 'andsnake2', '7074333871095338eb391cf40ec58f38', '189858028653ade4b24e1fe8.16526209', 'antoniougeocy@gmail.com', 'asdasdads', 'asdadasd', '1234567890', '1', '0');
