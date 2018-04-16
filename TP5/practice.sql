/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : practice

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-01-24 10:05:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pr_goods
-- ----------------------------
DROP TABLE IF EXISTS `pr_goods`;
CREATE TABLE `pr_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(300) DEFAULT NULL COMMENT '封面图',
  `name` varchar(60) DEFAULT NULL COMMENT '商品名称',
  `simple_desc` varchar(120) DEFAULT NULL COMMENT '简介',
  `desc` text COMMENT '详情',
  `info_img` text COMMENT '商品详情图片',
  `ctime` int(11) DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(3) DEFAULT '0' COMMENT '状态：0 正常 1 禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pr_goods
-- ----------------------------

-- ----------------------------
-- Table structure for pr_menu
-- ----------------------------
DROP TABLE IF EXISTS `pr_menu`;
CREATE TABLE `pr_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL COMMENT '板块名称',
  `parent_id` int(11) DEFAULT '0' COMMENT '父级id 0则为一级',
  `route` varchar(60) DEFAULT NULL COMMENT '地址',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) DEFAULT '0' COMMENT '状态：0 正常 1禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pr_menu
-- ----------------------------
INSERT INTO `pr_menu` VALUES ('1', '个人中心', '0', 'user/index', '0', '0');
INSERT INTO `pr_menu` VALUES ('2', '商品管理', '0', null, '1', '0');
INSERT INTO `pr_menu` VALUES ('3', '商品列表', '2', 'goods/goods_list', '1', '0');
INSERT INTO `pr_menu` VALUES ('4', '添加商品', '2', 'goods/goods_add', '2', '0');
INSERT INTO `pr_menu` VALUES ('7', '成员列表', '0', 'member/index', '0', '0');

-- ----------------------------
-- Table structure for pr_user
-- ----------------------------
DROP TABLE IF EXISTS `pr_user`;
CREATE TABLE `pr_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) DEFAULT NULL COMMENT '用户名',
  `password` varchar(120) DEFAULT NULL COMMENT '密码',
  `head` varchar(300) DEFAULT NULL COMMENT '头像地址',
  `sex` tinyint(3) DEFAULT '0' COMMENT '性别：0 未知 1 男 2 女',
  `age` int(10) DEFAULT NULL COMMENT '年龄',
  `telphone` varchar(30) DEFAULT NULL COMMENT '手机号',
  `desc` text COMMENT '个人描述',
  `address` text COMMENT '居住地址',
  `ctime` int(11) DEFAULT NULL COMMENT '创建时间',
  `ltime` int(11) DEFAULT NULL COMMENT '最后一次登录时间',
  `type` tinyint(3) DEFAULT '0' COMMENT '用户等级：0 普通用户 1二级权限 2一级权限 3超级管理员',
  `p_id` int(11) DEFAULT '0' COMMENT '上一级id',
  `status` tinyint(3) DEFAULT '0' COMMENT '状态：0 正常 1禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of pr_user
-- ----------------------------
INSERT INTO `pr_user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'c29e62b9/c29e62b93f81c91c25b5b954df885e3a.jpg', '0', '10', '18382457909', '<p>666</p>', '', '1516160182', '1516758607', '3', '0', '0');
INSERT INTO `pr_user` VALUES ('29', '5', 'e10adc3949ba59abbe56e057f20f883e', '9d564db4/9d564db4f3637f1e77ed6534852b36d2.jpg', '0', null, null, null, null, '1516674278', null, '0', '22', '0');
INSERT INTO `pr_user` VALUES ('30', '6', 'e10adc3949ba59abbe56e057f20f883e', '9d564db4/9d564db4f3637f1e77ed6534852b36d2.jpg', '2', null, null, null, null, '1516674278', null, '0', '22', '0');
INSERT INTO `pr_user` VALUES ('31', '7', 'e10adc3949ba59abbe56e057f20f883e', '9d564db4/9d564db4f3637f1e77ed6534852b36d2.jpg', '0', null, null, null, null, '1516674278', null, '0', '22', '0');
INSERT INTO `pr_user` VALUES ('32', '8', 'e10adc3949ba59abbe56e057f20f883e', '9d564db4/9d564db4f3637f1e77ed6534852b36d2.jpg', '0', null, null, null, null, '1516674278', null, '0', '22', '0');
INSERT INTO `pr_user` VALUES ('33', '9', 'e10adc3949ba59abbe56e057f20f883e', '9d564db4/9d564db4f3637f1e77ed6534852b36d2.jpg', '2', null, null, null, null, '1516674278', null, '0', '22', '0');
INSERT INTO `pr_user` VALUES ('34', '第十个用户', 'e10adc3949ba59abbe56e057f20f883e', 'aca3421f/aca3421f10f3bfa8851a69c08b20c11b.jpg', '0', '10', '', '', '', '1516674278', null, '0', '22', '0');
INSERT INTO `pr_user` VALUES ('22', '二级权限', 'e10adc3949ba59abbe56e057f20f883e', 'efac154b/efac154b0f3bd4b1a2cf764b5e3ae31f.jpg', '0', null, null, null, null, '1516674268', null, '1', '0', '0');
INSERT INTO `pr_user` VALUES ('23', '一级权限', 'e10adc3949ba59abbe56e057f20f883e', 'efac154b/efac154b0f3bd4b1a2cf764b5e3ae31f.jpg', '0', '0', '', '', '', '1516674278', '1516674287', '2', '0', '0');
INSERT INTO `pr_user` VALUES ('24', '普通用户', 'e10adc3949ba59abbe56e057f20f883e', '9d564db4/9d564db4f3637f1e77ed6534852b36d2.jpg', '0', null, null, null, null, '1516674278', null, '0', '22', '0');
INSERT INTO `pr_user` VALUES ('26', '2', 'e10adc3949ba59abbe56e057f20f883e', '9d564db4/9d564db4f3637f1e77ed6534852b36d2.jpg', '1', null, null, null, null, '1516674278', null, '0', '22', '0');
INSERT INTO `pr_user` VALUES ('27', '3', 'e10adc3949ba59abbe56e057f20f883e', '9d564db4/9d564db4f3637f1e77ed6534852b36d2.jpg', '0', null, null, null, null, '1516674278', null, '0', '22', '0');
INSERT INTO `pr_user` VALUES ('28', '4', 'e10adc3949ba59abbe56e057f20f883e', 'efac154b/efac154b0f3bd4b1a2cf764b5e3ae31f.jpg', '1', null, null, null, null, '1516674278', null, '0', '22', '0');
INSERT INTO `pr_user` VALUES ('25', '1', 'e10adc3949ba59abbe56e057f20f883e', 'efac154b/efac154b0f3bd4b1a2cf764b5e3ae31f.jpg', '0', null, null, null, null, '1516674278', null, '0', '22', '0');
INSERT INTO `pr_user` VALUES ('36', '新建的用户', 'e10adc3949ba59abbe56e057f20f883e', '281eb124/281eb124112c94887e57768726077fd7.jpg', '1', '18', '', '<p><strong>6666</strong><br/></p>', '', '1516759461', null, '0', '1', '0');
