/*
Navicat MySQL Data Transfer

Source Server         : 10.10.197.2
Source Server Version : 50505
Source Host           : 10.10.197.2:3306
Source Database       : ds.Lotto.FFC.Periods

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-06-23 11:33:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ds_kaijiang_14`
-- ----------------------------
DROP TABLE IF EXISTS `ds_kaijiang_14`;
CREATE TABLE `ds_kaijiang_14` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` smallint(6) NOT NULL COMMENT '彩种ID',
  `ds_time` datetime NOT NULL COMMENT '开奖时间',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  `ds_is_hide` bit(1) NOT NULL COMMENT '是否隐藏',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取肖',
  PRIMARY KEY (`ds_qishu`),
  KEY `IX_ds_status_ds_kaijiang_14` (`ds_is_pay`,`ds_is_finish`,`ds_is_result`),
  KEY `IX_ds_time_cancel_ds_kaijiang_14` (`ds_time`,`ds_is_cancel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_kaijiang_14
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_kaijiang_2`
-- ----------------------------
DROP TABLE IF EXISTS `ds_kaijiang_2`;
CREATE TABLE `ds_kaijiang_2` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` smallint(6) NOT NULL COMMENT '彩种ID',
  `ds_time` datetime NOT NULL COMMENT '开奖时间',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  `ds_is_hide` bit(1) NOT NULL COMMENT '是否隐藏',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取肖',
  PRIMARY KEY (`ds_qishu`),
  KEY `IX_ds_status_ds_kaijiang_2` (`ds_is_pay`,`ds_is_finish`,`ds_is_result`),
  KEY `IX_ds_time_cancel_ds_kaijiang_2` (`ds_time`,`ds_is_cancel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_kaijiang_2
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_kaijiang_24`
-- ----------------------------
DROP TABLE IF EXISTS `ds_kaijiang_24`;
CREATE TABLE `ds_kaijiang_24` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` smallint(6) NOT NULL COMMENT '彩种ID',
  `ds_time` datetime NOT NULL COMMENT '开奖时间',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  `ds_is_hide` bit(1) NOT NULL COMMENT '是否隐藏',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取肖',
  PRIMARY KEY (`ds_qishu`),
  KEY `IX_ds_status_ds_kaijiang_24` (`ds_is_pay`,`ds_is_finish`,`ds_is_result`),
  KEY `IX_ds_time_cancel_ds_kaijiang_24` (`ds_time`,`ds_is_cancel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_kaijiang_24
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_kaijiang_26`
-- ----------------------------
DROP TABLE IF EXISTS `ds_kaijiang_26`;
CREATE TABLE `ds_kaijiang_26` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` smallint(6) NOT NULL COMMENT '彩种ID',
  `ds_time` datetime NOT NULL COMMENT '开奖时间',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  `ds_is_hide` bit(1) NOT NULL COMMENT '是否隐藏',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取肖',
  PRIMARY KEY (`ds_qishu`),
  KEY `IX_ds_status_ds_kaijiang_26` (`ds_is_pay`,`ds_is_finish`,`ds_is_result`),
  KEY `IX_ds_time_cancel_ds_kaijiang_26` (`ds_time`,`ds_is_cancel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_kaijiang_26
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_kaijiang_27`
-- ----------------------------
DROP TABLE IF EXISTS `ds_kaijiang_27`;
CREATE TABLE `ds_kaijiang_27` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` smallint(6) NOT NULL COMMENT '彩种ID',
  `ds_time` datetime NOT NULL COMMENT '开奖时间',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  `ds_is_hide` bit(1) NOT NULL COMMENT '是否隐藏',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取肖',
  PRIMARY KEY (`ds_qishu`),
  KEY `IX_ds_status_ds_kaijiang_27` (`ds_is_pay`,`ds_is_finish`,`ds_is_result`),
  KEY `IX_ds_time_cancel_ds_kaijiang_27` (`ds_time`,`ds_is_cancel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_kaijiang_27
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_kaijiang_28`
-- ----------------------------
DROP TABLE IF EXISTS `ds_kaijiang_28`;
CREATE TABLE `ds_kaijiang_28` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` smallint(6) NOT NULL COMMENT '彩种ID',
  `ds_time` datetime NOT NULL COMMENT '开奖时间',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  `ds_is_hide` bit(1) NOT NULL COMMENT '是否隐藏',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取肖',
  PRIMARY KEY (`ds_qishu`),
  KEY `IX_ds_status_ds_kaijiang_28` (`ds_is_pay`,`ds_is_finish`,`ds_is_result`),
  KEY `IX_ds_time_cancel_ds_kaijiang_28` (`ds_time`,`ds_is_cancel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_kaijiang_28
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_kaijiang_29`
-- ----------------------------
DROP TABLE IF EXISTS `ds_kaijiang_29`;
CREATE TABLE `ds_kaijiang_29` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` smallint(6) NOT NULL COMMENT '彩种ID',
  `ds_time` datetime NOT NULL COMMENT '开奖时间',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  `ds_is_hide` bit(1) NOT NULL COMMENT '是否隐藏',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取肖',
  PRIMARY KEY (`ds_qishu`),
  KEY `IX_ds_status_ds_kaijiang_29` (`ds_is_pay`,`ds_is_finish`,`ds_is_result`),
  KEY `IX_ds_time_cancel_ds_kaijiang_29` (`ds_time`,`ds_is_cancel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_kaijiang_29
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_kaijiang_30`
-- ----------------------------
DROP TABLE IF EXISTS `ds_kaijiang_30`;
CREATE TABLE `ds_kaijiang_30` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` smallint(6) NOT NULL COMMENT '彩种ID',
  `ds_time` datetime NOT NULL COMMENT '开奖时间',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  `ds_is_hide` bit(1) NOT NULL COMMENT '是否隐藏',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取肖',
  PRIMARY KEY (`ds_qishu`),
  KEY `IX_ds_status_ds_kaijiang_30` (`ds_is_pay`,`ds_is_finish`,`ds_is_result`),
  KEY `IX_ds_time_cancel_ds_kaijiang_30` (`ds_time`,`ds_is_cancel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_kaijiang_30
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_kaijiang_6`
-- ----------------------------
DROP TABLE IF EXISTS `ds_kaijiang_6`;
CREATE TABLE `ds_kaijiang_6` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` smallint(6) NOT NULL COMMENT '彩种ID',
  `ds_time` datetime NOT NULL COMMENT '开奖时间',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  `ds_is_hide` bit(1) NOT NULL COMMENT '是否隐藏',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取肖',
  PRIMARY KEY (`ds_qishu`),
  KEY `IX_ds_status_ds_kaijiang_6` (`ds_is_pay`,`ds_is_finish`,`ds_is_result`),
  KEY `IX_ds_time_cancel_ds_kaijiang_6` (`ds_time`,`ds_is_cancel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_kaijiang_6
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_kaijiang_8`
-- ----------------------------
DROP TABLE IF EXISTS `ds_kaijiang_8`;
CREATE TABLE `ds_kaijiang_8` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` smallint(6) NOT NULL COMMENT '彩种ID',
  `ds_time` datetime NOT NULL COMMENT '开奖时间',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  `ds_is_hide` bit(1) NOT NULL COMMENT '是否隐藏',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取肖',
  PRIMARY KEY (`ds_qishu`),
  KEY `IX_ds_status_ds_kaijiang_8` (`ds_is_pay`,`ds_is_finish`,`ds_is_result`),
  KEY `IX_ds_time_cancel_ds_kaijiang_8` (`ds_time`,`ds_is_cancel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_kaijiang_8
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_kaijiang_9`
-- ----------------------------
DROP TABLE IF EXISTS `ds_kaijiang_9`;
CREATE TABLE `ds_kaijiang_9` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` smallint(6) NOT NULL COMMENT '彩种ID',
  `ds_time` datetime NOT NULL COMMENT '开奖时间',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  `ds_is_hide` bit(1) NOT NULL COMMENT '是否隐藏',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取肖',
  PRIMARY KEY (`ds_qishu`),
  KEY `IX_ds_status_ds_kaijiang_9` (`ds_is_pay`,`ds_is_finish`,`ds_is_result`),
  KEY `IX_ds_time_cancel_ds_kaijiang_9` (`ds_time`,`ds_is_cancel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_kaijiang_9
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_log_14`
-- ----------------------------
DROP TABLE IF EXISTS `ds_log_14`;
CREATE TABLE `ds_log_14` (
  `ds_id` int(11) NOT NULL COMMENT 'ID号',
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lotto_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '彩种',
  `ds_time` datetime NOT NULL COMMENT '记录时间',
  `ds_operate_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作类型',
  `ds_account_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '帐户名称',
  `ds_ip` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作IP',
  `ds_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作地址',
  `ds_type` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作名称',
  `ds_old_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作前',
  `ds_new_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作后',
  PRIMARY KEY (`ds_id`),
  KEY `IX_ds_log_14_Time_User` (`ds_time`,`ds_account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_log_14
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_log_2`
-- ----------------------------
DROP TABLE IF EXISTS `ds_log_2`;
CREATE TABLE `ds_log_2` (
  `ds_id` int(11) NOT NULL COMMENT 'ID号',
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lotto_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '彩种',
  `ds_time` datetime NOT NULL COMMENT '记录时间',
  `ds_operate_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作类型',
  `ds_account_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '帐户名称',
  `ds_ip` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作IP',
  `ds_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作地址',
  `ds_type` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作名称',
  `ds_old_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作前',
  `ds_new_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作后',
  PRIMARY KEY (`ds_id`),
  KEY `IX_ds_log_2_Time_User` (`ds_time`,`ds_account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_log_2
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_log_24`
-- ----------------------------
DROP TABLE IF EXISTS `ds_log_24`;
CREATE TABLE `ds_log_24` (
  `ds_id` int(11) NOT NULL COMMENT 'ID号',
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lotto_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '彩种',
  `ds_time` datetime NOT NULL COMMENT '记录时间',
  `ds_operate_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作类型',
  `ds_account_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '帐户名称',
  `ds_ip` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作IP',
  `ds_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作地址',
  `ds_type` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作名称',
  `ds_old_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作前',
  `ds_new_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作后',
  PRIMARY KEY (`ds_id`),
  KEY `IX_ds_log_24_Time_User` (`ds_time`,`ds_account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_log_24
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_log_26`
-- ----------------------------
DROP TABLE IF EXISTS `ds_log_26`;
CREATE TABLE `ds_log_26` (
  `ds_id` int(11) NOT NULL COMMENT 'ID号',
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lotto_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '彩种',
  `ds_time` datetime NOT NULL COMMENT '记录时间',
  `ds_operate_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作类型',
  `ds_account_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '帐户名称',
  `ds_ip` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作IP',
  `ds_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作地址',
  `ds_type` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作名称',
  `ds_old_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作前',
  `ds_new_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作后',
  PRIMARY KEY (`ds_id`),
  KEY `IX_ds_log_26_Time_User` (`ds_time`,`ds_account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_log_26
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_log_27`
-- ----------------------------
DROP TABLE IF EXISTS `ds_log_27`;
CREATE TABLE `ds_log_27` (
  `ds_id` int(11) NOT NULL COMMENT 'ID号',
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lotto_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '彩种',
  `ds_time` datetime NOT NULL COMMENT '记录时间',
  `ds_operate_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作类型',
  `ds_account_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '帐户名称',
  `ds_ip` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作IP',
  `ds_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作地址',
  `ds_type` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作名称',
  `ds_old_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作前',
  `ds_new_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作后',
  PRIMARY KEY (`ds_id`),
  KEY `IX_ds_log_27_Time_User` (`ds_time`,`ds_account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_log_27
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_log_28`
-- ----------------------------
DROP TABLE IF EXISTS `ds_log_28`;
CREATE TABLE `ds_log_28` (
  `ds_id` int(11) NOT NULL COMMENT 'ID号',
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lotto_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '彩种',
  `ds_time` datetime NOT NULL COMMENT '记录时间',
  `ds_operate_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作类型',
  `ds_account_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '帐户名称',
  `ds_ip` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作IP',
  `ds_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作地址',
  `ds_type` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作名称',
  `ds_old_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作前',
  `ds_new_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作后',
  PRIMARY KEY (`ds_id`),
  KEY `IX_ds_log_28_Time_User` (`ds_time`,`ds_account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_log_28
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_log_29`
-- ----------------------------
DROP TABLE IF EXISTS `ds_log_29`;
CREATE TABLE `ds_log_29` (
  `ds_id` int(11) NOT NULL COMMENT 'ID号',
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lotto_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '彩种',
  `ds_time` datetime NOT NULL COMMENT '记录时间',
  `ds_operate_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作类型',
  `ds_account_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '帐户名称',
  `ds_ip` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作IP',
  `ds_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作地址',
  `ds_type` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作名称',
  `ds_old_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作前',
  `ds_new_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作后',
  PRIMARY KEY (`ds_id`),
  KEY `IX_ds_log_29_Time_User` (`ds_time`,`ds_account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_log_29
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_log_30`
-- ----------------------------
DROP TABLE IF EXISTS `ds_log_30`;
CREATE TABLE `ds_log_30` (
  `ds_id` int(11) NOT NULL COMMENT 'ID号',
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lotto_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '彩种',
  `ds_time` datetime NOT NULL COMMENT '记录时间',
  `ds_operate_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作类型',
  `ds_account_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '帐户名称',
  `ds_ip` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作IP',
  `ds_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作地址',
  `ds_type` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作名称',
  `ds_old_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作前',
  `ds_new_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作后',
  PRIMARY KEY (`ds_id`),
  KEY `IX_ds_log_30_Time_User` (`ds_time`,`ds_account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_log_30
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_log_6`
-- ----------------------------
DROP TABLE IF EXISTS `ds_log_6`;
CREATE TABLE `ds_log_6` (
  `ds_id` int(11) NOT NULL COMMENT 'ID号',
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lotto_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '彩种',
  `ds_time` datetime NOT NULL COMMENT '记录时间',
  `ds_operate_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作类型',
  `ds_account_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '帐户名称',
  `ds_ip` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作IP',
  `ds_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作地址',
  `ds_type` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作名称',
  `ds_old_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作前',
  `ds_new_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作后',
  PRIMARY KEY (`ds_id`),
  KEY `IX_ds_log_6_Time_User` (`ds_time`,`ds_account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_log_6
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_log_8`
-- ----------------------------
DROP TABLE IF EXISTS `ds_log_8`;
CREATE TABLE `ds_log_8` (
  `ds_id` int(11) NOT NULL COMMENT 'ID号',
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lotto_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '彩种',
  `ds_time` datetime NOT NULL COMMENT '记录时间',
  `ds_operate_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作类型',
  `ds_account_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '帐户名称',
  `ds_ip` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作IP',
  `ds_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作地址',
  `ds_type` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作名称',
  `ds_old_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作前',
  `ds_new_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作后',
  PRIMARY KEY (`ds_id`),
  KEY `IX_ds_log_8_Time_User` (`ds_time`,`ds_account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_log_8
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_log_9`
-- ----------------------------
DROP TABLE IF EXISTS `ds_log_9`;
CREATE TABLE `ds_log_9` (
  `ds_id` int(11) NOT NULL COMMENT 'ID号',
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lotto_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '彩种',
  `ds_time` datetime NOT NULL COMMENT '记录时间',
  `ds_operate_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作类型',
  `ds_account_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '帐户名称',
  `ds_ip` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作IP',
  `ds_address` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作地址',
  `ds_type` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '操作名称',
  `ds_old_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作前',
  `ds_new_data` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作后',
  PRIMARY KEY (`ds_id`),
  KEY `IX_ds_log_9_Time_User` (`ds_time`,`ds_account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_log_9
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_pankou_14`
-- ----------------------------
DROP TABLE IF EXISTS `ds_pankou_14`;
CREATE TABLE `ds_pankou_14` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` tinyint(4) NOT NULL COMMENT '彩种ID',
  `ds_time_open` datetime NOT NULL COMMENT '开盘时间',
  `ds_time_stop` datetime NOT NULL COMMENT '封盘时间',
  `ds_time_draw` datetime NOT NULL COMMENT '开奖时间',
  `ds_state` tinyint(4) NOT NULL COMMENT '盘口状态',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取消',
  `ds_is_task` bit(1) NOT NULL COMMENT '是否自动任务',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  PRIMARY KEY (`ds_qishu`),
  KEY `ds_qishu` (`ds_qishu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_pankou_14
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_pankou_2`
-- ----------------------------
DROP TABLE IF EXISTS `ds_pankou_2`;
CREATE TABLE `ds_pankou_2` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` tinyint(4) NOT NULL COMMENT '彩种ID',
  `ds_time_open` datetime NOT NULL COMMENT '开盘时间',
  `ds_time_stop` datetime NOT NULL COMMENT '封盘时间',
  `ds_time_draw` datetime NOT NULL COMMENT '开奖时间',
  `ds_state` tinyint(4) NOT NULL COMMENT '盘口状态',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取消',
  `ds_is_task` bit(1) NOT NULL COMMENT '是否自动任务',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  PRIMARY KEY (`ds_qishu`),
  KEY `ds_qishu` (`ds_qishu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_pankou_2
-- ----------------------------
INSERT INTO `ds_pankou_2` VALUES ('20170518062', '2', '2017-05-18 16:10:00', '2017-05-18 16:19:00', '2017-05-18 16:20:00', '2', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170518063', '2', '2017-05-18 16:20:00', '2017-05-18 16:29:00', '2017-05-18 16:30:00', '2', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170607023', '2', '2017-06-07 01:50:00', '2017-06-07 01:54:00', '2017-06-07 01:55:00', '2', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170607024', '2', '2017-06-07 09:50:00', '2017-06-07 09:59:00', '2017-06-07 10:00:00', '2', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621023', '2', '2017-06-21 01:50:00', '2017-06-21 01:54:00', '2017-06-21 01:55:00', '3', '', '', '', '', '', '3,5,2,1,1');
INSERT INTO `ds_pankou_2` VALUES ('20170621024', '2', '2017-06-21 09:50:00', '2017-06-21 09:59:00', '2017-06-21 10:00:00', '3', '', '', '', '', '', '3,5,8,9,3');
INSERT INTO `ds_pankou_2` VALUES ('20170621025', '2', '2017-06-21 10:00:00', '2017-06-21 10:09:00', '2017-06-21 10:10:00', '3', '', '', '', '', '', '1,9,2,5,8');
INSERT INTO `ds_pankou_2` VALUES ('20170621026', '2', '2017-06-21 10:10:00', '2017-06-21 10:19:00', '2017-06-21 10:20:00', '3', '', '', '', '', '', '4,3,1,9,5');
INSERT INTO `ds_pankou_2` VALUES ('20170621028', '2', '2017-06-21 10:30:00', '2017-06-21 10:39:00', '2017-06-21 10:40:00', '3', '', '', '', '', '', '9,5,6,6,7');
INSERT INTO `ds_pankou_2` VALUES ('20170621029', '2', '2017-06-21 10:40:00', '2017-06-21 10:49:00', '2017-06-21 10:50:00', '3', '', '', '', '', '', '7,8,3,3,7');
INSERT INTO `ds_pankou_2` VALUES ('20170621030', '2', '2017-06-21 10:50:00', '2017-06-21 10:59:00', '2017-06-21 11:00:00', '3', '', '', '', '', '', '7,3,0,1,6');
INSERT INTO `ds_pankou_2` VALUES ('20170621031', '2', '2017-06-21 11:00:00', '2017-06-21 11:09:00', '2017-06-21 11:10:00', '3', '', '', '', '', '', '2,5,0,3,7');
INSERT INTO `ds_pankou_2` VALUES ('20170621032', '2', '2017-06-21 11:10:00', '2017-06-21 11:19:00', '2017-06-21 11:20:00', '3', '', '', '', '', '', '9,2,8,7,9');
INSERT INTO `ds_pankou_2` VALUES ('20170621033', '2', '2017-06-21 11:20:00', '2017-06-21 11:29:00', '2017-06-21 11:30:00', '3', '', '', '', '', '', '7,9,9,4,2');
INSERT INTO `ds_pankou_2` VALUES ('20170621034', '2', '2017-06-21 11:30:00', '2017-06-21 11:39:00', '2017-06-21 11:40:00', '3', '', '', '', '', '', '9,0,5,2,1');
INSERT INTO `ds_pankou_2` VALUES ('20170621035', '2', '2017-06-21 11:40:00', '2017-06-21 11:49:00', '2017-06-21 11:50:00', '3', '', '', '', '', '', '3,9,9,6,9');
INSERT INTO `ds_pankou_2` VALUES ('20170621036', '2', '2017-06-21 11:50:00', '2017-06-21 11:59:00', '2017-06-21 12:00:00', '3', '', '', '', '', '', '5,8,0,6,2');
INSERT INTO `ds_pankou_2` VALUES ('20170621037', '2', '2017-06-21 12:00:00', '2017-06-21 12:09:00', '2017-06-21 12:10:00', '3', '', '', '', '', '', '4,6,2,0,0');
INSERT INTO `ds_pankou_2` VALUES ('20170621038', '2', '2017-06-21 12:10:00', '2017-06-21 12:19:00', '2017-06-21 12:20:00', '3', '', '', '', '', '', '1,6,6,8,3');
INSERT INTO `ds_pankou_2` VALUES ('20170621039', '2', '2017-06-21 12:20:00', '2017-06-21 12:29:00', '2017-06-21 12:30:00', '3', '', '', '', '', '', '0,4,1,9,0');
INSERT INTO `ds_pankou_2` VALUES ('20170621040', '2', '2017-06-21 12:30:00', '2017-06-21 12:39:00', '2017-06-21 12:40:00', '3', '', '', '', '', '', '1,4,0,7,6');
INSERT INTO `ds_pankou_2` VALUES ('20170621041', '2', '2017-06-21 12:40:00', '2017-06-21 12:49:00', '2017-06-21 12:50:00', '3', '', '', '', '', '', '1,8,2,1,2');
INSERT INTO `ds_pankou_2` VALUES ('20170621042', '2', '2017-06-21 12:50:00', '2017-06-21 12:59:00', '2017-06-21 13:00:00', '3', '', '', '', '', '', '2,5,9,3,1');
INSERT INTO `ds_pankou_2` VALUES ('20170621043', '2', '2017-06-21 13:00:00', '2017-06-21 13:09:00', '2017-06-21 13:10:00', '3', '', '', '', '', '', '0,7,9,7,5');
INSERT INTO `ds_pankou_2` VALUES ('20170621044', '2', '2017-06-21 13:10:00', '2017-06-21 13:19:00', '2017-06-21 13:20:00', '3', '', '', '', '', '', '1,7,4,5,7');
INSERT INTO `ds_pankou_2` VALUES ('20170621045', '2', '2017-06-21 13:20:00', '2017-06-21 13:29:00', '2017-06-21 13:30:00', '3', '', '', '', '', '', '7,1,8,3,1');
INSERT INTO `ds_pankou_2` VALUES ('20170621046', '2', '2017-06-21 13:30:00', '2017-06-21 13:39:00', '2017-06-21 13:40:00', '3', '', '', '', '', '', '5,6,3,5,0');
INSERT INTO `ds_pankou_2` VALUES ('20170621047', '2', '2017-06-21 13:40:00', '2017-06-21 13:49:00', '2017-06-21 13:50:00', '3', '', '', '', '', '', '5,8,0,1,7');
INSERT INTO `ds_pankou_2` VALUES ('20170621048', '2', '2017-06-21 13:50:00', '2017-06-21 13:59:00', '2017-06-21 14:00:00', '3', '', '', '', '', '', '5,8,0,7,7');
INSERT INTO `ds_pankou_2` VALUES ('20170621049', '2', '2017-06-21 14:00:00', '2017-06-21 14:09:00', '2017-06-21 14:10:00', '3', '', '', '', '', '', '2,9,8,2,4');
INSERT INTO `ds_pankou_2` VALUES ('20170621050', '2', '2017-06-21 14:10:00', '2017-06-21 14:19:00', '2017-06-21 14:20:00', '3', '', '', '', '', '', '5,2,0,4,0');
INSERT INTO `ds_pankou_2` VALUES ('20170621051', '2', '2017-06-21 14:20:00', '2017-06-21 14:29:00', '2017-06-21 14:30:00', '3', '', '', '', '', '', '9,8,9,8,8');
INSERT INTO `ds_pankou_2` VALUES ('20170621052', '2', '2017-06-21 14:30:00', '2017-06-21 14:39:00', '2017-06-21 14:40:00', '3', '', '', '', '', '', '7,6,6,5,7');
INSERT INTO `ds_pankou_2` VALUES ('20170621053', '2', '2017-06-21 14:40:00', '2017-06-21 14:49:00', '2017-06-21 14:50:00', '3', '', '', '', '', '', '6,3,4,6,2');
INSERT INTO `ds_pankou_2` VALUES ('20170621054', '2', '2017-06-21 14:50:00', '2017-06-21 14:59:00', '2017-06-21 15:00:00', '3', '', '', '', '', '', '5,1,9,1,5');
INSERT INTO `ds_pankou_2` VALUES ('20170621055', '2', '2017-06-21 15:00:00', '2017-06-21 15:09:00', '2017-06-21 15:10:00', '3', '', '', '', '', '', '0,2,7,3,0');
INSERT INTO `ds_pankou_2` VALUES ('20170621056', '2', '2017-06-21 15:10:00', '2017-06-21 15:19:00', '2017-06-21 15:20:00', '3', '', '', '', '', '', '3,6,8,2,5');
INSERT INTO `ds_pankou_2` VALUES ('20170621057', '2', '2017-06-21 15:20:00', '2017-06-21 15:29:00', '2017-06-21 15:30:00', '3', '', '', '', '', '', '6,6,8,3,7');
INSERT INTO `ds_pankou_2` VALUES ('20170621058', '2', '2017-06-21 15:30:00', '2017-06-21 15:39:00', '2017-06-21 15:40:00', '3', '', '', '', '', '', '0,4,4,6,5');
INSERT INTO `ds_pankou_2` VALUES ('20170621059', '2', '2017-06-21 15:40:00', '2017-06-21 15:49:00', '2017-06-21 15:50:00', '3', '', '', '', '', '', '3,5,8,5,8');
INSERT INTO `ds_pankou_2` VALUES ('20170621060', '2', '2017-06-21 15:50:00', '2017-06-21 15:59:00', '2017-06-21 16:00:00', '3', '', '', '', '', '', '0,9,4,0,6');
INSERT INTO `ds_pankou_2` VALUES ('20170621061', '2', '2017-06-21 16:00:00', '2017-06-21 16:09:00', '2017-06-21 16:10:00', '3', '', '', '', '', '', '9,4,2,8,6');
INSERT INTO `ds_pankou_2` VALUES ('20170621062', '2', '2017-06-21 16:10:00', '2017-06-21 16:19:00', '2017-06-21 16:20:00', '3', '', '', '', '', '', '0,1,9,5,6');
INSERT INTO `ds_pankou_2` VALUES ('20170621063', '2', '2017-06-21 16:20:00', '2017-06-21 16:29:00', '2017-06-21 16:30:00', '3', '', '', '', '', '', '9,1,0,5,9');
INSERT INTO `ds_pankou_2` VALUES ('20170621064', '2', '2017-06-21 16:30:00', '2017-06-21 16:39:00', '2017-06-21 16:40:00', '3', '', '', '', '', '', '0,1,9,6,3');
INSERT INTO `ds_pankou_2` VALUES ('20170621065', '2', '2017-06-21 16:40:00', '2017-06-21 16:49:00', '2017-06-21 16:50:00', '3', '', '', '', '', '', '2,9,3,7,1');
INSERT INTO `ds_pankou_2` VALUES ('20170621066', '2', '2017-06-21 16:50:00', '2017-06-21 16:59:00', '2017-06-21 17:00:00', '3', '', '', '', '', '', '9,8,5,2,6');
INSERT INTO `ds_pankou_2` VALUES ('20170621067', '2', '2017-06-21 17:00:00', '2017-06-21 17:09:00', '2017-06-21 17:10:00', '3', '', '', '', '', '', '2,3,4,0,6');
INSERT INTO `ds_pankou_2` VALUES ('20170621068', '2', '2017-06-21 17:10:00', '2017-06-21 17:19:00', '2017-06-21 17:20:00', '3', '', '', '', '', '', '5,9,6,2,0');
INSERT INTO `ds_pankou_2` VALUES ('20170621069', '2', '2017-06-21 17:20:00', '2017-06-21 17:29:00', '2017-06-21 17:30:00', '3', '', '', '', '', '', '1,0,0,1,8');
INSERT INTO `ds_pankou_2` VALUES ('20170621070', '2', '2017-06-21 17:30:00', '2017-06-21 17:39:00', '2017-06-21 17:40:00', '3', '', '', '', '', '', '1,4,1,9,3');
INSERT INTO `ds_pankou_2` VALUES ('20170621071', '2', '2017-06-21 17:40:00', '2017-06-21 17:49:00', '2017-06-21 17:50:00', '3', '', '', '', '', '', '7,7,5,5,9');
INSERT INTO `ds_pankou_2` VALUES ('20170621072', '2', '2017-06-21 17:50:00', '2017-06-21 17:59:00', '2017-06-21 18:00:00', '3', '', '', '', '', '', '6,4,7,5,5');
INSERT INTO `ds_pankou_2` VALUES ('20170621073', '2', '2017-06-21 18:00:00', '2017-06-21 18:09:00', '2017-06-21 18:10:00', '3', '', '', '', '', '', '0,3,7,5,3');
INSERT INTO `ds_pankou_2` VALUES ('20170621074', '2', '2017-06-21 18:10:00', '2017-06-21 18:19:00', '2017-06-21 18:20:00', '3', '', '', '', '', '', '6,0,4,3,7');
INSERT INTO `ds_pankou_2` VALUES ('20170621076', '2', '2017-06-21 18:30:00', '2017-06-21 18:39:00', '2017-06-21 18:40:00', '3', '', '', '', '', '', '4,3,8,0,6');
INSERT INTO `ds_pankou_2` VALUES ('20170621077', '2', '2017-06-21 18:40:00', '2017-06-21 18:49:00', '2017-06-21 18:50:00', '3', '', '', '', '', '', '9,6,4,2,6');
INSERT INTO `ds_pankou_2` VALUES ('20170621078', '2', '2017-06-21 18:50:00', '2017-06-21 18:59:00', '2017-06-21 19:00:00', '3', '', '', '', '', '', '4,9,3,3,5');
INSERT INTO `ds_pankou_2` VALUES ('20170621079', '2', '2017-06-21 19:00:00', '2017-06-21 19:09:00', '2017-06-21 19:10:00', '1', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621080', '2', '2017-06-21 19:10:00', '2017-06-21 19:19:00', '2017-06-21 19:20:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621081', '2', '2017-06-21 19:20:00', '2017-06-21 19:29:00', '2017-06-21 19:30:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621082', '2', '2017-06-21 19:30:00', '2017-06-21 19:39:00', '2017-06-21 19:40:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621083', '2', '2017-06-21 19:40:00', '2017-06-21 19:49:00', '2017-06-21 19:50:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621084', '2', '2017-06-21 19:50:00', '2017-06-21 19:59:00', '2017-06-21 20:00:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621085', '2', '2017-06-21 20:00:00', '2017-06-21 20:09:00', '2017-06-21 20:10:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621086', '2', '2017-06-21 20:10:00', '2017-06-21 20:19:00', '2017-06-21 20:20:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621087', '2', '2017-06-21 20:20:00', '2017-06-21 20:29:00', '2017-06-21 20:30:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621088', '2', '2017-06-21 20:30:00', '2017-06-21 20:39:00', '2017-06-21 20:40:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621089', '2', '2017-06-21 20:40:00', '2017-06-21 20:49:00', '2017-06-21 20:50:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621090', '2', '2017-06-21 20:50:00', '2017-06-21 20:59:00', '2017-06-21 21:00:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621091', '2', '2017-06-21 21:00:00', '2017-06-21 21:09:00', '2017-06-21 21:10:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621092', '2', '2017-06-21 21:10:00', '2017-06-21 21:19:00', '2017-06-21 21:20:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621093', '2', '2017-06-21 21:20:00', '2017-06-21 21:29:00', '2017-06-21 21:30:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621094', '2', '2017-06-21 21:30:00', '2017-06-21 21:39:00', '2017-06-21 21:40:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621095', '2', '2017-06-21 21:40:00', '2017-06-21 21:49:00', '2017-06-21 21:50:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621096', '2', '2017-06-21 21:50:00', '2017-06-21 21:59:00', '2017-06-21 22:00:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621097', '2', '2017-06-21 22:00:00', '2017-06-21 22:04:00', '2017-06-21 22:05:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621098', '2', '2017-06-21 22:05:00', '2017-06-21 22:09:00', '2017-06-21 22:10:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621099', '2', '2017-06-21 22:10:00', '2017-06-21 22:14:00', '2017-06-21 22:15:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621100', '2', '2017-06-21 22:15:00', '2017-06-21 22:19:00', '2017-06-21 22:20:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621101', '2', '2017-06-21 22:20:00', '2017-06-21 22:24:00', '2017-06-21 22:25:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621102', '2', '2017-06-21 22:25:00', '2017-06-21 22:29:00', '2017-06-21 22:30:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621103', '2', '2017-06-21 22:30:00', '2017-06-21 22:34:00', '2017-06-21 22:35:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621104', '2', '2017-06-21 22:35:00', '2017-06-21 22:39:00', '2017-06-21 22:40:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621105', '2', '2017-06-21 22:40:00', '2017-06-21 22:44:00', '2017-06-21 22:45:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621106', '2', '2017-06-21 22:45:00', '2017-06-21 22:49:00', '2017-06-21 22:50:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621107', '2', '2017-06-21 22:50:00', '2017-06-21 22:54:00', '2017-06-21 22:55:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621108', '2', '2017-06-21 22:55:00', '2017-06-21 22:59:00', '2017-06-21 23:00:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621109', '2', '2017-06-21 23:00:00', '2017-06-21 23:04:00', '2017-06-21 23:05:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621110', '2', '2017-06-21 23:05:00', '2017-06-21 23:09:00', '2017-06-21 23:10:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621111', '2', '2017-06-21 23:10:00', '2017-06-21 23:14:00', '2017-06-21 23:15:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621112', '2', '2017-06-21 23:15:00', '2017-06-21 23:19:00', '2017-06-21 23:20:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621113', '2', '2017-06-21 23:20:00', '2017-06-21 23:24:00', '2017-06-21 23:25:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621114', '2', '2017-06-21 23:25:00', '2017-06-21 23:29:00', '2017-06-21 23:30:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621115', '2', '2017-06-21 23:30:00', '2017-06-21 23:34:00', '2017-06-21 23:35:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621116', '2', '2017-06-21 23:35:00', '2017-06-21 23:39:00', '2017-06-21 23:40:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621117', '2', '2017-06-21 23:40:00', '2017-06-21 23:44:00', '2017-06-21 23:45:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621118', '2', '2017-06-21 23:45:00', '2017-06-21 23:49:00', '2017-06-21 23:50:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621119', '2', '2017-06-21 23:50:00', '2017-06-21 23:54:00', '2017-06-21 23:55:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170621120', '2', '2017-06-21 23:55:00', '2017-06-21 23:59:00', '2017-06-22 00:00:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622001', '2', '2017-06-22 00:00:00', '2017-06-22 00:04:00', '2017-06-22 00:05:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622002', '2', '2017-06-22 00:05:00', '2017-06-22 00:09:00', '2017-06-22 00:10:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622003', '2', '2017-06-22 00:10:00', '2017-06-22 00:14:00', '2017-06-22 00:15:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622004', '2', '2017-06-22 00:15:00', '2017-06-22 00:19:00', '2017-06-22 00:20:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622005', '2', '2017-06-22 00:20:00', '2017-06-22 00:24:00', '2017-06-22 00:25:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622006', '2', '2017-06-22 00:25:00', '2017-06-22 00:29:00', '2017-06-22 00:30:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622007', '2', '2017-06-22 00:30:00', '2017-06-22 00:34:00', '2017-06-22 00:35:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622008', '2', '2017-06-22 00:35:00', '2017-06-22 00:39:00', '2017-06-22 00:40:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622009', '2', '2017-06-22 00:40:00', '2017-06-22 00:44:00', '2017-06-22 00:45:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622010', '2', '2017-06-22 00:45:00', '2017-06-22 00:49:00', '2017-06-22 00:50:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622011', '2', '2017-06-22 00:50:00', '2017-06-22 00:54:00', '2017-06-22 00:55:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622012', '2', '2017-06-22 00:55:00', '2017-06-22 00:59:00', '2017-06-22 01:00:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622013', '2', '2017-06-22 01:00:00', '2017-06-22 01:04:00', '2017-06-22 01:05:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622014', '2', '2017-06-22 01:05:00', '2017-06-22 01:09:00', '2017-06-22 01:10:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622015', '2', '2017-06-22 01:10:00', '2017-06-22 01:14:00', '2017-06-22 01:15:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622016', '2', '2017-06-22 01:15:00', '2017-06-22 01:19:00', '2017-06-22 01:20:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622017', '2', '2017-06-22 01:20:00', '2017-06-22 01:24:00', '2017-06-22 01:25:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622018', '2', '2017-06-22 01:25:00', '2017-06-22 01:29:00', '2017-06-22 01:30:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622019', '2', '2017-06-22 01:30:00', '2017-06-22 01:34:00', '2017-06-22 01:35:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622020', '2', '2017-06-22 01:35:00', '2017-06-22 01:39:00', '2017-06-22 01:40:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622021', '2', '2017-06-22 01:40:00', '2017-06-22 01:44:00', '2017-06-22 01:45:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622022', '2', '2017-06-22 01:45:00', '2017-06-22 01:49:00', '2017-06-22 01:50:00', '0', '', '', '', '', '', '');
INSERT INTO `ds_pankou_2` VALUES ('20170622023', '2', '2017-06-22 01:50:00', '2017-06-22 01:54:00', '2017-06-22 01:55:00', '0', '', '', '', '', '', '');

-- ----------------------------
-- Table structure for `ds_pankou_24`
-- ----------------------------
DROP TABLE IF EXISTS `ds_pankou_24`;
CREATE TABLE `ds_pankou_24` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` tinyint(4) NOT NULL COMMENT '彩种ID',
  `ds_time_open` datetime NOT NULL COMMENT '开盘时间',
  `ds_time_stop` datetime NOT NULL COMMENT '封盘时间',
  `ds_time_draw` datetime NOT NULL COMMENT '开奖时间',
  `ds_state` tinyint(4) NOT NULL COMMENT '盘口状态',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取消',
  `ds_is_task` bit(1) NOT NULL COMMENT '是否自动任务',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  PRIMARY KEY (`ds_qishu`),
  KEY `ds_qishu` (`ds_qishu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_pankou_24
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_pankou_26`
-- ----------------------------
DROP TABLE IF EXISTS `ds_pankou_26`;
CREATE TABLE `ds_pankou_26` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` tinyint(4) NOT NULL COMMENT '彩种ID',
  `ds_time_open` datetime NOT NULL COMMENT '开盘时间',
  `ds_time_stop` datetime NOT NULL COMMENT '封盘时间',
  `ds_time_draw` datetime NOT NULL COMMENT '开奖时间',
  `ds_state` tinyint(4) NOT NULL COMMENT '盘口状态',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取消',
  `ds_is_task` bit(1) NOT NULL COMMENT '是否自动任务',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  PRIMARY KEY (`ds_qishu`),
  KEY `ds_qishu` (`ds_qishu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_pankou_26
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_pankou_27`
-- ----------------------------
DROP TABLE IF EXISTS `ds_pankou_27`;
CREATE TABLE `ds_pankou_27` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` tinyint(4) NOT NULL COMMENT '彩种ID',
  `ds_time_open` datetime NOT NULL COMMENT '开盘时间',
  `ds_time_stop` datetime NOT NULL COMMENT '封盘时间',
  `ds_time_draw` datetime NOT NULL COMMENT '开奖时间',
  `ds_state` tinyint(4) NOT NULL COMMENT '盘口状态',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取消',
  `ds_is_task` bit(1) NOT NULL COMMENT '是否自动任务',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  PRIMARY KEY (`ds_qishu`),
  KEY `ds_qishu` (`ds_qishu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_pankou_27
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_pankou_28`
-- ----------------------------
DROP TABLE IF EXISTS `ds_pankou_28`;
CREATE TABLE `ds_pankou_28` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` tinyint(4) NOT NULL COMMENT '彩种ID',
  `ds_time_open` datetime NOT NULL COMMENT '开盘时间',
  `ds_time_stop` datetime NOT NULL COMMENT '封盘时间',
  `ds_time_draw` datetime NOT NULL COMMENT '开奖时间',
  `ds_state` tinyint(4) NOT NULL COMMENT '盘口状态',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取消',
  `ds_is_task` bit(1) NOT NULL COMMENT '是否自动任务',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  PRIMARY KEY (`ds_qishu`),
  KEY `ds_qishu` (`ds_qishu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_pankou_28
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_pankou_29`
-- ----------------------------
DROP TABLE IF EXISTS `ds_pankou_29`;
CREATE TABLE `ds_pankou_29` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` tinyint(4) NOT NULL COMMENT '彩种ID',
  `ds_time_open` datetime NOT NULL COMMENT '开盘时间',
  `ds_time_stop` datetime NOT NULL COMMENT '封盘时间',
  `ds_time_draw` datetime NOT NULL COMMENT '开奖时间',
  `ds_state` tinyint(4) NOT NULL COMMENT '盘口状态',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取消',
  `ds_is_task` bit(1) NOT NULL COMMENT '是否自动任务',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  PRIMARY KEY (`ds_qishu`),
  KEY `ds_qishu` (`ds_qishu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_pankou_29
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_pankou_30`
-- ----------------------------
DROP TABLE IF EXISTS `ds_pankou_30`;
CREATE TABLE `ds_pankou_30` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` tinyint(4) NOT NULL COMMENT '彩种ID',
  `ds_time_open` datetime NOT NULL COMMENT '开盘时间',
  `ds_time_stop` datetime NOT NULL COMMENT '封盘时间',
  `ds_time_draw` datetime NOT NULL COMMENT '开奖时间',
  `ds_state` tinyint(4) NOT NULL COMMENT '盘口状态',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取消',
  `ds_is_task` bit(1) NOT NULL COMMENT '是否自动任务',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  PRIMARY KEY (`ds_qishu`),
  KEY `ds_qishu` (`ds_qishu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_pankou_30
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_pankou_6`
-- ----------------------------
DROP TABLE IF EXISTS `ds_pankou_6`;
CREATE TABLE `ds_pankou_6` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` tinyint(4) NOT NULL COMMENT '彩种ID',
  `ds_time_open` datetime NOT NULL COMMENT '开盘时间',
  `ds_time_stop` datetime NOT NULL COMMENT '封盘时间',
  `ds_time_draw` datetime NOT NULL COMMENT '开奖时间',
  `ds_state` tinyint(4) NOT NULL COMMENT '盘口状态',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取消',
  `ds_is_task` bit(1) NOT NULL COMMENT '是否自动任务',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  PRIMARY KEY (`ds_qishu`),
  KEY `ds_qishu` (`ds_qishu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_pankou_6
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_pankou_8`
-- ----------------------------
DROP TABLE IF EXISTS `ds_pankou_8`;
CREATE TABLE `ds_pankou_8` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` tinyint(4) NOT NULL COMMENT '彩种ID',
  `ds_time_open` datetime NOT NULL COMMENT '开盘时间',
  `ds_time_stop` datetime NOT NULL COMMENT '封盘时间',
  `ds_time_draw` datetime NOT NULL COMMENT '开奖时间',
  `ds_state` tinyint(4) NOT NULL COMMENT '盘口状态',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取消',
  `ds_is_task` bit(1) NOT NULL COMMENT '是否自动任务',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  PRIMARY KEY (`ds_qishu`),
  KEY `ds_qishu` (`ds_qishu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_pankou_8
-- ----------------------------

-- ----------------------------
-- Table structure for `ds_pankou_9`
-- ----------------------------
DROP TABLE IF EXISTS `ds_pankou_9`;
CREATE TABLE `ds_pankou_9` (
  `ds_qishu` bigint(20) NOT NULL COMMENT '期数',
  `ds_lid` tinyint(4) NOT NULL COMMENT '彩种ID',
  `ds_time_open` datetime NOT NULL COMMENT '开盘时间',
  `ds_time_stop` datetime NOT NULL COMMENT '封盘时间',
  `ds_time_draw` datetime NOT NULL COMMENT '开奖时间',
  `ds_state` tinyint(4) NOT NULL COMMENT '盘口状态',
  `ds_is_result` bit(1) NOT NULL COMMENT '是否开奖',
  `ds_is_finish` bit(1) NOT NULL COMMENT '是否结算',
  `ds_is_pay` bit(1) NOT NULL COMMENT '是否派彩',
  `ds_is_cancel` bit(1) NOT NULL COMMENT '是否取消',
  `ds_is_task` bit(1) NOT NULL COMMENT '是否自动任务',
  `ds_balls` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '开奖号码',
  PRIMARY KEY (`ds_qishu`),
  KEY `ds_qishu` (`ds_qishu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ds_pankou_9
-- ----------------------------
