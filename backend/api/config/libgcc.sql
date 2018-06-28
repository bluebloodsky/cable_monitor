/*
 Navicat MySQL Data Transfer

 Source Server         : 93
 Source Server Type    : MySQL
 Source Server Version : 50622
 Source Host           : 172.17.11.93:3306
 Source Schema         : libgcc

 Target Server Type    : MySQL
 Target Server Version : 50622
 File Encoding         : 65001

 Date: 28/06/2018 11:57:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for boolhisdata
-- ----------------------------
DROP TABLE IF EXISTS `boolhisdata`;
CREATE TABLE `boolhisdata`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `measId` int(11) NULL DEFAULT NULL,
  `val` int(11) NULL DEFAULT NULL,
  `tm` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for boolrealdata
-- ----------------------------
DROP TABLE IF EXISTS `boolrealdata`;
CREATE TABLE `boolrealdata`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `measId` int(11) NULL DEFAULT NULL,
  `tag` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `val` int(11) NULL DEFAULT NULL,
  `tm` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of boolrealdata
-- ----------------------------
INSERT INTO `boolrealdata` VALUES (4, 5, '环境监测仪.通讯状态', 1, '2018-06-28 18:46:18');
INSERT INTO `boolrealdata` VALUES (5, 6, '环境监测仪.烟感1', 1, '2018-06-28 18:46:18');

-- ----------------------------
-- Table structure for floathisdata
-- ----------------------------
DROP TABLE IF EXISTS `floathisdata`;
CREATE TABLE `floathisdata`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `measId` int(11) NULL DEFAULT NULL,
  `val` float NULL DEFAULT NULL,
  `tm` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for floatrealdata
-- ----------------------------
DROP TABLE IF EXISTS `floatrealdata`;
CREATE TABLE `floatrealdata`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `measId` int(11) NULL DEFAULT NULL,
  `tag` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `val` float NULL DEFAULT NULL,
  `tm` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of floatrealdata
-- ----------------------------
INSERT INTO `floatrealdata` VALUES (7, 4, '环境监测仪.温度1', 30.1, '2018-06-28 18:46:18');
INSERT INTO `floatrealdata` VALUES (8, 5, '环境监测仪.湿度1', 56.2, '2018-06-28 18:46:18');

-- ----------------------------
-- Table structure for tbl_monitor_device
-- ----------------------------
DROP TABLE IF EXISTS `tbl_monitor_device`;
CREATE TABLE `tbl_monitor_device`  (
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name_cn` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `monitor_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `wire` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `section` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phase` int(2) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_monitor_device
-- ----------------------------
INSERT INTO `tbl_monitor_device` VALUES ('gil1', 'GIL监测点1', 'GILC', 'xiafeng1', 'fangqu1', 1);

-- ----------------------------
-- Table structure for tbl_monitor_param
-- ----------------------------
DROP TABLE IF EXISTS `tbl_monitor_param`;
CREATE TABLE `tbl_monitor_param`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name_cn` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `unit` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `show_type` int(255) NULL DEFAULT NULL,
  `monitor_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_monitor_param
-- ----------------------------
INSERT INTO `tbl_monitor_param` VALUES (1, 'AppPaDsch', '局放幅值', 'mV', 1, 'SPDC');
INSERT INTO `tbl_monitor_param` VALUES (2, 'AppPaDsch', '视在局放放电量', 'V', 2, 'SPDC');
INSERT INTO `tbl_monitor_param` VALUES (3, 'TotCurrent', '护层环流电流', 'A', 2, 'SPTR');
INSERT INTO `tbl_monitor_param` VALUES (4, 'LosFact', '介质损耗因素', '%', 2, 'SSBH');
INSERT INTO `tbl_monitor_param` VALUES (5, 'Temp', '温度', '℃', 3, 'STMP');
INSERT INTO `tbl_monitor_param` VALUES (6, 'gasTmp', '空气温度', '℃', 3, 'ENVR');
INSERT INTO `tbl_monitor_param` VALUES (7, 'humity', '空气湿度', '%', 3, 'ENVR');
INSERT INTO `tbl_monitor_param` VALUES (8, 'waterLevel', '水位', 'mm', 3, 'ENVR');

-- ----------------------------
-- Table structure for tbl_monitor_type
-- ----------------------------
DROP TABLE IF EXISTS `tbl_monitor_type`;
CREATE TABLE `tbl_monitor_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name_cn` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `icon` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_monitor_type
-- ----------------------------
INSERT INTO `tbl_monitor_type` VALUES (1, 'GILC', 'GIL电弧定位', 'GIL_MONITOR', 'icon-flag');
INSERT INTO `tbl_monitor_type` VALUES (2, 'SPDC', '局部放电监测', 'WIRE_MONITOR', 'icon-flashlight');
INSERT INTO `tbl_monitor_type` VALUES (3, 'SPTR', '载流量及护层电流监测', 'WIRE_MONITOR', 'icon-tailor');
INSERT INTO `tbl_monitor_type` VALUES (4, 'SSBH', '绝缘介损监测', 'WIRE_MONITOR', 'icon-integral');
INSERT INTO `tbl_monitor_type` VALUES (5, 'STMP', '光纤测温监测', 'WIRE_MONITOR', 'icon-accessory');
INSERT INTO `tbl_monitor_type` VALUES (6, 'ENVR', '环境监测', 'SECTION_MONITOR', 'icon-workbench');
INSERT INTO `tbl_monitor_type` VALUES (7, 'GAUR', '安防监测', 'SECTION_MONITOR', 'icon-live');
INSERT INTO `tbl_monitor_type` VALUES (8, 'CAMR', '视频监控', 'CAMR_MONITOR', 'icon-camera');

-- ----------------------------
-- Table structure for tbl_section
-- ----------------------------
DROP TABLE IF EXISTS `tbl_section`;
CREATE TABLE `tbl_section`  (
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name_cn` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `img_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_tunnel
-- ----------------------------
DROP TABLE IF EXISTS `tbl_tunnel`;
CREATE TABLE `tbl_tunnel`  (
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name_cn` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_tunnel
-- ----------------------------
INSERT INTO `tbl_tunnel` VALUES ('xf', '下凤电缆隧道');

-- ----------------------------
-- Table structure for tbl_wire
-- ----------------------------
DROP TABLE IF EXISTS `tbl_wire`;
CREATE TABLE `tbl_wire`  (
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name_cn` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_wire
-- ----------------------------
INSERT INTO `tbl_wire` VALUES ('xiafeng1', '500kV下凤1回', 'GIL');
INSERT INTO `tbl_wire` VALUES ('xiafeng2', '500kV下凤2回', 'GIL');
INSERT INTO `tbl_wire` VALUES ('xiafeng3', '220kV下凤1回', 'WIRE');
INSERT INTO `tbl_wire` VALUES ('xiafeng4', '220kV下凤1回', 'WIRE');

SET FOREIGN_KEY_CHECKS = 1;
