/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50155
Source Host           : localhost:3306
Source Database       : libgcc

Target Server Type    : MYSQL
Target Server Version : 50155
File Encoding         : 65001

Date: 2018-06-29 01:03:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tbl_monitor_device`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_monitor_device`;
CREATE TABLE `tbl_monitor_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `name_cn` varchar(50) DEFAULT NULL,
  `monitor_type` varchar(20) DEFAULT NULL,
  `wire` varchar(20) DEFAULT NULL,
  `section` varchar(20) DEFAULT NULL,
  `phase` int(2) DEFAULT NULL,
  `positionX` int(2) DEFAULT NULL,
  `positionY` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tbl_monitor_device
-- ----------------------------
INSERT INTO `tbl_monitor_device` VALUES ('1', 'gil1', 'GIL监测点1', 'GILC', 'xiafeng1', 'fangqu1', '1', null, null);
INSERT INTO `tbl_monitor_device` VALUES ('2', 'gil2', 'GIL监测点2', 'GILC', 'xiafeng1', 'fangqu1', '1', null, null);
INSERT INTO `tbl_monitor_device` VALUES ('3', 'gil3', 'GIL监测点3', 'GILC', 'xiafeng1', 'fangqu1', '1', null, null);
INSERT INTO `tbl_monitor_device` VALUES ('4', 'gil4', 'GIL监测点4', 'GILC', 'xiafeng1', 'fangqu2', '1', null, null);
INSERT INTO `tbl_monitor_device` VALUES ('15', 'jf1', '局放监测点1', 'SPDC', 'xiafeng3', 'fangqu1', '1', '27', '50');
INSERT INTO `tbl_monitor_device` VALUES ('16', 'jf2', '局放监测点2', 'SPDC', 'xiafeng3', 'fangqu1', '2', '27', '58');
INSERT INTO `tbl_monitor_device` VALUES ('17', 'jf3', '局放监测点3', 'SPDC', 'xiafeng3', 'fangqu1', '3', '27', '66');
INSERT INTO `tbl_monitor_device` VALUES ('18', 'jf4', '局放监测点4', 'SPDC', 'xiafeng3', 'fangqu1', '1', '46', '50');
INSERT INTO `tbl_monitor_device` VALUES ('19', 'jf5', '局放监测点5', 'SPDC', 'xiafeng3', 'fangqu1', '2', '46', '58');
INSERT INTO `tbl_monitor_device` VALUES ('20', 'jf6', '局放监测点6', 'SPDC', 'xiafeng3', 'fangqu1', '3', '46', '66');
INSERT INTO `tbl_monitor_device` VALUES ('21', 'jf7', '局放监测点7', 'SPDC', 'xiafeng3', 'fangqu1', '1', '65', '50');
INSERT INTO `tbl_monitor_device` VALUES ('22', 'jf8', '局放监测点8', 'SPDC', 'xiafeng3', 'fangqu1', '2', '65', '58');
INSERT INTO `tbl_monitor_device` VALUES ('23', 'jf9', '局放监测点9', 'SPDC', 'xiafeng3', 'fangqu1', '3', '65', '66');
INSERT INTO `tbl_monitor_device` VALUES ('24', 'jf10', '局放监测点10', 'SPDC', 'xiafeng4', 'fangqu1', '1', '27', '50');
INSERT INTO `tbl_monitor_device` VALUES ('25', 'zll1', '载流量监测点1', 'SPTR', 'xiafeng3', 'fangqu1', '1', '27', '51');
INSERT INTO `tbl_monitor_device` VALUES ('26', 'zll2', '载流量监测点2', 'SPTR', 'xiafeng3', 'fangqu1', '2', '27', '58');
INSERT INTO `tbl_monitor_device` VALUES ('27', 'zll3', '载流量监测点3', 'SPTR', 'xiafeng3', 'fangqu1', '3', '27', '66');
INSERT INTO `tbl_monitor_device` VALUES ('28', 'jyjx1', '绝缘介损监测点1', 'SSBH', 'xiafeng3', 'fangqu1', '1', '27', '51');
INSERT INTO `tbl_monitor_device` VALUES ('29', 'jyjx2', '绝缘介损监测点2', 'SSBH', 'xiafeng3', 'fangqu1', '2', '27', '58');
INSERT INTO `tbl_monitor_device` VALUES ('30', 'jyjx3', '绝缘介损监测点3', 'SSBH', 'xiafeng3', 'fangqu1', '3', '27', '66');
INSERT INTO `tbl_monitor_device` VALUES ('31', 'gxcw1', '光纤测温监测点1', 'STMP', 'xiafeng3', 'fangqu1', '1', '46', '51');
INSERT INTO `tbl_monitor_device` VALUES ('32', 'gxcw2', '光纤测温监测点2', 'STMP', 'xiafeng3', 'fangqu1', '2', '46', '58');
INSERT INTO `tbl_monitor_device` VALUES ('33', 'gxcw3', '光纤测温监测点3', 'STMP', 'xiafeng3', 'fangqu1', '3', '46', '66');
INSERT INTO `tbl_monitor_device` VALUES ('34', 'hj1', '环境监测点1', 'ENVR', null, 'fangqu1', '3', '7', '13');

-- ----------------------------
-- Table structure for `tbl_monitor_param`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_monitor_param`;
CREATE TABLE `tbl_monitor_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `name_cn` varchar(50) DEFAULT NULL,
  `data_type` varchar(10) DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL,
  `show_type` int(255) DEFAULT NULL,
  `monitor_type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tbl_monitor_param
-- ----------------------------
INSERT INTO `tbl_monitor_param` VALUES ('1', 'AppPaDsch', '局放幅值', 'FLOAT', 'mV', '1', 'GILC');
INSERT INTO `tbl_monitor_param` VALUES ('2', 'AppPaDsch', '局放幅值', 'FLOAT', 'V', '2', 'SPDC');
INSERT INTO `tbl_monitor_param` VALUES ('3', 'TotCurrent', '护层环流电流', 'FLOAT', 'A', '2', 'SPTR');
INSERT INTO `tbl_monitor_param` VALUES ('4', 'LosFact', '介质损耗因素', 'FLOAT', '%', '2', 'SSBH');
INSERT INTO `tbl_monitor_param` VALUES ('5', 'Temp', '温度', 'FLOAT', '℃', '3', 'STMP');
INSERT INTO `tbl_monitor_param` VALUES ('6', 'gasTmp', '空气温度', 'FLOAT', '℃', '3', 'ENVR');
INSERT INTO `tbl_monitor_param` VALUES ('7', 'humity', '空气湿度', 'FLOAT', '%', '2', 'ENVR');
INSERT INTO `tbl_monitor_param` VALUES ('9', 'fog', '烟雾报警', 'BOOL', null, '4', 'ENVR');
INSERT INTO `tbl_monitor_param` VALUES ('10', 'MoDevConf', '通讯状态', null, null, null, 'COMMON');

-- ----------------------------
-- Table structure for `tbl_monitor_type`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_monitor_type`;
CREATE TABLE `tbl_monitor_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  `name_cn` varchar(50) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `icon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tbl_monitor_type
-- ----------------------------
INSERT INTO `tbl_monitor_type` VALUES ('1', 'GILC', 'GIL电弧定位', 'GIL_MONITOR', 'icon-flag');
INSERT INTO `tbl_monitor_type` VALUES ('2', 'SPDC', '局部放电监测', 'WIRE_MONITOR', 'icon-flashlight');
INSERT INTO `tbl_monitor_type` VALUES ('3', 'SPTR', '载流量及护层电流监测', 'WIRE_MONITOR', 'icon-tailor');
INSERT INTO `tbl_monitor_type` VALUES ('4', 'SSBH', '绝缘介损监测', 'WIRE_MONITOR', 'icon-integral');
INSERT INTO `tbl_monitor_type` VALUES ('5', 'STMP', '光纤测温监测', 'WIRE_MONITOR', 'icon-accessory');
INSERT INTO `tbl_monitor_type` VALUES ('6', 'ENVR', '环境监测', 'SECTION_MONITOR', 'icon-workbench');
INSERT INTO `tbl_monitor_type` VALUES ('7', 'GAUR', '安防监测', 'SECTION_MONITOR', 'icon-live');
INSERT INTO `tbl_monitor_type` VALUES ('8', 'CAMR', '视频监控', 'CAMR_MONITOR', 'icon-camera');

-- ----------------------------
-- Table structure for `tbl_rel_dev_data`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_rel_dev_data`;
CREATE TABLE `tbl_rel_dev_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `measId` int(11) DEFAULT NULL,
  `device_name` varchar(20) DEFAULT NULL,
  `param_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_rel_dev_data
-- ----------------------------
INSERT INTO `tbl_rel_dev_data` VALUES ('1', '4', 'hj1', 'gasTmp');
INSERT INTO `tbl_rel_dev_data` VALUES ('2', '5', 'hj1', 'humity');
INSERT INTO `tbl_rel_dev_data` VALUES ('3', '5', 'hj1', 'MoDevConf');
INSERT INTO `tbl_rel_dev_data` VALUES ('4', '6', 'hj1', 'fog');

-- ----------------------------
-- Table structure for `tbl_section`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_section`;
CREATE TABLE `tbl_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `name_cn` varchar(50) DEFAULT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tbl_section
-- ----------------------------
INSERT INTO `tbl_section` VALUES ('1', 'fangqu1', '1#防区', '/static/img/section.png');
INSERT INTO `tbl_section` VALUES ('3', 'fangqu2', '2#防区', '/static/img/section.png');
INSERT INTO `tbl_section` VALUES ('4', 'fangqu3', '3#防区', '/static/img/section.png');
INSERT INTO `tbl_section` VALUES ('5', 'fangqu4', '4#防区', '/static/img/section.png');
INSERT INTO `tbl_section` VALUES ('6', 'fangqu5', '5#防区', '/static/img/section.png');

-- ----------------------------
-- Table structure for `tbl_tunnel`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_tunnel`;
CREATE TABLE `tbl_tunnel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `name_cn` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tbl_tunnel
-- ----------------------------
INSERT INTO `tbl_tunnel` VALUES ('1', 'xf', '下凤电缆隧道');

-- ----------------------------
-- Table structure for `tbl_wire`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_wire`;
CREATE TABLE `tbl_wire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `name_cn` varchar(50) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tbl_wire
-- ----------------------------
INSERT INTO `tbl_wire` VALUES ('1', 'xiafeng1', '500kV下凤1回', 'GIL');
INSERT INTO `tbl_wire` VALUES ('2', 'xiafeng2', '500kV下凤2回', 'GIL');
INSERT INTO `tbl_wire` VALUES ('3', 'xiafeng3', '220kV下凤1回', 'WIRE');
INSERT INTO `tbl_wire` VALUES ('4', 'xiafeng4', '220kV下凤2回', 'WIRE');
