/*
Navicat MySQL Data Transfer

Source Server         : 阿里云
Source Server Version : 50724
Source Host           : 119.23.239.189:3306
Source Database       : gule

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2019-07-30 10:02:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(50) NOT NULL COMMENT '管理员名称',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `nickname` varchar(50) DEFAULT NULL COMMENT '昵称',
  `admin_code` varchar(255) NOT NULL DEFAULT 'gl00015788' COMMENT '上级code',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户类型(0:内部用户 1:渠道)',
  `admin_tel` varchar(20) DEFAULT NULL COMMENT '管理员手机',
  `status` smallint(6) NOT NULL DEFAULT '0' COMMENT '1、启用  0、停用',
  `admin_pid` int(11) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`),
  KEY `admin_id` (`admin_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', 'a66abb5684c45962d887564f08346e8d', 'admin', 'gl00015788', '0', '', '1', '0', '2018-10-30 11:41:50', '2019-07-23 17:05:10', '2019-07-23 17:05:10');
INSERT INTO `admin` VALUES ('18', 'jn', 'b9fa69cdd5535e0cbfb38bc779f8f911', 'jn', 'gl00015788', '0', '', '1', '1', '2019-03-27 16:38:00', '2019-07-16 10:14:11', '2019-07-16 10:14:10');

-- ----------------------------
-- Table structure for banner
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '幻灯片id',
  `pic_name` varchar(50) DEFAULT '' COMMENT '标题名称',
  `pic_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'APP图片地址URL',
  `jump_type` tinyint(1) DEFAULT '1' COMMENT '跳转类型：0 不跳转 1 跳转软文 2 跳转链接',
  `jump_title` varchar(50) DEFAULT '' COMMENT '跳转链接头部标题',
  `jump_url` varchar(255) DEFAULT '' COMMENT '跳转URL',
  `content` longtext COMMENT '文章内容',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '适用于：1:购彩页面',
  `status` tinyint(4) DEFAULT '2' COMMENT '使用状态:1->在线 2->下线',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `opt_id` int(11) DEFAULT NULL COMMENT '操作人',
  `praise_num` int(11) NOT NULL DEFAULT '0' COMMENT '点赞数',
  `comment_num` int(11) NOT NULL DEFAULT '0' COMMENT '评论数',
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES ('1', '助力扶贫，与爱同行', 'http://114.115.148.102/img/bananer/181126042625_90.jpg', '2', '助力扶贫，与爱同行', 'http://hgame.lottery.gov.cn/1805zhuantigy/', '', '1', '1', '2018-11-26 16:26:25', '2018-11-26 16:28:17', '4', '0', '0');
INSERT INTO `banner` VALUES ('2', '他的未来，因你出彩', 'http://114.115.148.102/img/bananer/181126042808_62.jpg', '2', '他的未来，因你出彩', 'http://www.lottery.gov.cn/zt_201810ywl/index.html', '', '1', '2', '2018-11-26 16:28:08', '2019-01-14 16:40:36', '4', '0', '0');
INSERT INTO `banner` VALUES ('7', '谷乐风采', 'http://114.115.148.102/img/bananer/190114043420_13.jpg', '1', '', '', '1', '1', '1', '2019-01-14 16:34:16', '2019-01-14 16:35:41', '1', '0', '0');
INSERT INTO `banner` VALUES ('8', '谷乐风采（二）', 'http://114.115.148.102/img/bananer/190114043849_84.jpg', '1', '', '', '2', '1', '1', '2019-01-14 16:34:55', '2019-01-14 16:38:44', '1', '0', '0');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '类别ID',
  `name` varchar(100) DEFAULT '' COMMENT '名称',
  `p_id` int(11) DEFAULT '0' COMMENT '父级ID',
  `sort` tinyint(2) DEFAULT '99' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 0 禁用 1 启用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '创业咨询服务', '0', '99', '1', '2019-01-24 15:01:50');
INSERT INTO `category` VALUES ('2', '财务顾问服务', '0', '99', '1', '2019-01-24 15:06:38');
INSERT INTO `category` VALUES ('3', '法律顾问服务', '0', '99', '1', '2019-01-24 15:06:50');
INSERT INTO `category` VALUES ('4', '预算绩效管理服务', '0', '99', '1', '2019-01-24 15:07:06');
INSERT INTO `category` VALUES ('5', '工商代理服务', '1', '1', '1', '2019-01-24 15:07:38');
INSERT INTO `category` VALUES ('6', '财税咨询服务', '1', '2', '1', '2019-01-24 15:08:16');
INSERT INTO `category` VALUES ('7', '知识产权服务', '1', '3', '1', '2019-01-24 15:08:32');
INSERT INTO `category` VALUES ('8', '政策咨询服务', '1', '99', '1', '2019-01-24 15:08:45');
INSERT INTO `category` VALUES ('9', '资质培育服务', '1', '99', '1', '2019-01-24 15:09:00');
INSERT INTO `category` VALUES ('10', '成长期私募融资', '2', '99', '1', '2019-01-24 15:09:33');
INSERT INTO `category` VALUES ('11', '科创板财务顾问', '2', '99', '1', '2019-01-24 15:09:42');
INSERT INTO `category` VALUES ('12', '新三板财务顾问', '2', '99', '1', '2019-01-24 15:09:52');
INSERT INTO `category` VALUES ('13', '成熟期并购顾问', '2', '99', '1', '2019-01-24 15:10:36');
INSERT INTO `category` VALUES ('14', '财务尽职调查', '2', '99', '1', '2019-01-24 15:10:46');
INSERT INTO `category` VALUES ('15', '协议起草审核', '3', '99', '1', '2019-01-24 15:10:58');
INSERT INTO `category` VALUES ('16', '法律风险评估', '3', '99', '1', '2019-01-24 15:11:06');
INSERT INTO `category` VALUES ('17', '常年法律顾问', '3', '99', '1', '2019-01-24 15:11:14');
INSERT INTO `category` VALUES ('18', '基金运营合规顾问', '3', '99', '1', '2019-01-24 15:11:31');
INSERT INTO `category` VALUES ('19', '咨询服务', '4', '99', '1', '2019-01-24 15:11:44');
INSERT INTO `category` VALUES ('20', '技术服务', '4', '99', '1', '2019-01-24 15:11:52');
INSERT INTO `category` VALUES ('21', '研究服务', '4', '99', '1', '2019-01-24 15:12:00');
INSERT INTO `category` VALUES ('22', '培训服务', '4', '99', '1', '2019-01-24 15:12:14');

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '产品ID',
  `product_name` varchar(150) DEFAULT '' COMMENT '产品名称',
  `description` varchar(255) DEFAULT '' COMMENT '产品描述',
  `category` int(11) DEFAULT NULL COMMENT '所属类别',
  `product_pic` varchar(255) DEFAULT '' COMMENT '商品图片',
  `product_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品价格',
  `product_detail` text COMMENT '简介',
  `is_hot` tinyint(1) DEFAULT '0' COMMENT '是否推荐 0 否 1 是',
  `status` tinyint(1) DEFAULT '0' COMMENT '上架状态 1 上架 0 下架',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', '企业设立、 变更', '根据企业提供公司设立或变更的 的资料整理符合工商部门要求， 办理企业的工商设立或变更工作 事宜。', '5', 'http://114.115.148.102/img/productImg/190124045113_190124165105.jpg', '0.01', '<section data-role=\"outer\" label=\"Powered by 135editor.com\" style=\"font-size:16px;\"><section data-role=\"paragraph\" class=\"_135editor\" style=\"border:0px none;box-sizing:border-box;\"><section class=\"\" data-tools=\"135编辑器\" data-id=\"89233\" data-width=\"95%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;width:95%;border:0px none;box-sizing:border-box;\"><section style=\"max-width:100%;\"><span data-ratio=\"1.7058823529411764\" id=\"js_tx_video_container_0.8125846039038152\" class=\"js_tx_video_container\" style=\"max-width:100%;display:block;width:446px !important;height:250.875px !important;\">\n<iframe frameborder=\"0\" width=\"446\" height=\"250.875\" allowfullscreen=\"true\" src=\"https://v.qq.com/txp/iframe/player.html?origin=https%3A%2F%2Fmp.weixin.qq.com&amp;vid=x1338zoawyq&amp;autoplay=false&amp;full=true&amp;show1080p=false\" style=\"max-width:100%;\">\n</iframe>\n</span><br style=\"max-width:100%;\" />\n</section></section><section data-role=\"paragraph\" class=\"\" data-width=\"93%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;font-size:medium;line-height:25.6px;white-space:normal;widows:1;border:0px none;width:93%;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<span style=\"max-width:100%;color:#595959;font-size:13px;\">&nbsp; &nbsp; &nbsp; 2018年4月27日，由福建省体彩管理中心携手厦门市咕啦电子商务有限责任公司举办的首届“公益杯”中国体育彩票五人制足球邀请赛圆满结束所有赛程，伴随着闭幕式暨颁奖典礼的顺利进行，本届赛事也已正式落下帷幕。</span>\n</p>\n</section><section class=\"\" data-tools=\"135编辑器\" data-id=\"19527\" data-width=\"95%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;width:95%;box-sizing:border-box;\"><section style=\"margin-top:0.8em;margin-bottom:0.3em;max-width:100%;border:0px none #000000;box-sizing:border-box;\"><section style=\"max-width:100%;line-height:0;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img border=\"0\" class=\"\" data-ratio=\"0.555\" data-type=\"jpeg\" data-w=\"800\" data-width=\"100%\" opacity=\"\" title=\"IMG_1176_副本.jpg\" width=\"100%\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQw34CGp6R86dxRflmTHchwabjmqVlXEbOjyCotvXYrCU6Y4GoOHqicdeQ/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;border-bottom:5px solid #433d37;display:inline-block;width:100%;visibility:visible !important;\" />\n</p>\n</section><section style=\"max-width:100%;line-height:0;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img border=\"0\" class=\"\" data-ratio=\"0.555\" data-type=\"jpeg\" data-w=\"800\" data-width=\"100%\" opacity=\"\" title=\"IMG_1594_副本.jpg\" width=\"100%\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwiaUfDc9sVS4MjZUrhkV2DBxIbtHSqVYzsAp0bNKaTaWmYNVsZs1GqAw/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;border-bottom:5px solid #433d37;display:inline-block;width:100%;visibility:visible !important;\" />\n</p>\n</section><section style=\"max-width:100%;line-height:0;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img border=\"0\" class=\"\" data-ratio=\"0.555\" data-type=\"jpeg\" data-w=\"800\" data-width=\"100%\" opacity=\"\" title=\"升旗_副本.jpg\" width=\"100%\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwibYHXHz48HgFBia5aJibk3IMtia8ZL2oaic7W78Ic2iakdPH9UTLzGCONf8w/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;border-bottom:5px solid #433d37;display:inline-block;width:100%;visibility:visible !important;\" />\n</p>\n</section></section></section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;font-size:medium;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"93%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;width:93%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<span style=\"max-width:100%;color:#595959;font-size:13px;\">&nbsp; &nbsp; &nbsp; 本届赛事由福建省体育彩票管理中心主办，厦门市咕啦电子商务有限责任公司承办。经过近一个多月的筹备，</span><span style=\"max-width:100%;font-size:13px;color:#ff0000;\">邀请了安徽、山东、江苏、浙江、江西等华东六省16支体彩代表队，</span><span style=\"max-width:100%;color:#595959;font-size:13px;\">共160人参加。分A、B、C、D共4小组单循环6轮排位赛+第二阶段淘汰赛，计32场比赛。</span>\n</p>\n</section><section class=\"\" data-tools=\"135编辑器\" data-id=\"87544\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\"><section data-width=\"90%\" style=\"margin:30px auto;padding-right:15px;padding-left:15px;max-width:100%;width:90%;vertical-align:top;line-height:0.5;box-sizing:border-box;\"><section style=\"max-width:100%;transform:rotateZ(4.6deg);-webkit-transform:rotateZ(4.6deg);-moz-transform:rotateZ(4.6deg);-ms-transform:rotateZ(4.6deg);-o-transform:rotateZ(4.6deg);\"><section style=\"margin-top:0.5em;margin-bottom:0.5em;max-width:100%;font-size:4.8px;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<img border=\"0\" class=\"\" data-ratio=\"0.555\" data-type=\"jpeg\" data-w=\"800\" data-width=\"100%\" undefined\"=\"\" width=\"100%\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQw2HLzJNynibL15WHmajpG9M3NVAhEODI99GcekcXZyV6xEYqpeEkPS8g/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;border-width:0.8em;border-style:solid;border-color:white;box-shadow:#666666 0.2em 0.2em 0.5em;vertical-align:middle;width:100%;visibility:visible !important;\" />\n</p>\n</section></section><section style=\"max-width:100%;transform:rotateZ(352.25deg);-webkit-transform:rotateZ(352.25deg);-moz-transform:rotateZ(352.25deg);-ms-transform:rotateZ(352.25deg);-o-transform:rotateZ(352.25deg);\"><section style=\"margin-top:0.5em;margin-bottom:0.5em;max-width:100%;font-size:4.8px;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<img border=\"0\" class=\"\" data-ratio=\"0.555\" data-type=\"jpeg\" data-w=\"800\" data-width=\"100%\" undefined\"=\"\" width=\"100%\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwXLASicibfYdvicWF9IywLIxicaaiaUc3X6Sg1fM5qicHATgPxGSmNpvxf5nQ/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;border-width:0.8em;border-style:solid;border-color:white;box-shadow:#666666 0.2em 0.2em 0.5em;vertical-align:middle;width:100%;visibility:visible !important;\" />\n</p>\n</section></section><section style=\"max-width:100%;transform:rotateZ(4.58deg);-webkit-transform:rotateZ(4.58deg);-moz-transform:rotateZ(4.58deg);-ms-transform:rotateZ(4.58deg);-o-transform:rotateZ(4.58deg);\"><section style=\"margin-top:0.5em;margin-bottom:0.5em;max-width:100%;font-size:4.8px;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img border=\"0\" class=\"\" data-ratio=\"0.555\" data-type=\"jpeg\" data-w=\"800\" data-width=\"100%\" 3.jpg\"=\"\" width=\"100%\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQw7Uheiawp1S0XoxxXSSZ3vFf63VpMu3WTfyKkNXsmZBGKzGQprjcIErw/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;max-width:100%;border-width:0.8em;border-style:solid;border-color:white;box-shadow:#666666 0.2em 0.2em 0.5em;vertical-align:middle;width:100%;visibility:visible !important;\">\n</p>\n</section></section><section style=\"max-width:100%;transform:rotateZ(352.35deg);-webkit-transform:rotateZ(352.35deg);-moz-transform:rotateZ(352.35deg);-ms-transform:rotateZ(352.35deg);-o-transform:rotateZ(352.35deg);\"><section style=\"margin-top:0.5em;margin-bottom:0.5em;max-width:100%;font-size:4.8px;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img class=\"\" data-ratio=\"0.555\" data-type=\"jpeg\" data-w=\"800\" data-width=\"100%\" title=\"4.jpg\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwBOK8WCKFCUQ8uGIYOm0eYKVBl9YMNCUbnqQrbbfAHe3ZGMRVjFWfIg/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;border-width:0.8em;border-style:solid;border-color:white;box-shadow:#666666 0.2em 0.2em 0.5em;vertical-align:middle;width:100%;visibility:visible !important;\" />\n</p>\n</section></section></section></section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"16%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;width:16%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;text-align:right;margin:5px 0px;margin:5px 0px;\">\n	<img class=\" __bg_gif\" data-copyright=\"0\" data-cropselx1=\"0\" data-cropselx2=\"89\" data-cropsely1=\"0\" data-cropsely2=\"78\" data-ratio=\"0.8714285714285714\" data-type=\"gif\" data-w=\"140\" _width=\"90px\" src=\"http://mpt.135editor.com/mmbiz_gif/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwgLIBicwhAAyTteUpaTrd74ywhWNSBxia8N4ibXiaVw4sREm9wHkeJYyljA/640?wx_fmt=gif\" data-order=\"0\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;width:90px !important;visibility:visible !important;\" />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"93%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;width:93%;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<span style=\"max-width:100%;color:#595959;font-size:13px;\">&nbsp; &nbsp; &nbsp; 经过了为期2天的激烈角逐。最终，由<span style=\"max-width:100%;color:#ff0000;\">厦门市代表队摘得桂冠</span>，捧起了总决赛的冠军奖杯；泉州市代表队和山东省代表队紧随其后，分别获得第二名和第三名的好成绩。此外，来自厦门市代表队的<span style=\"max-width:100%;color:#ff0000;\">孙掷旭以10个进球</span><span style=\"max-width:100%;color:#ff0000;\">获得本届赛事“最佳射手”称号。</span></span>\n</p>\n</section><section class=\"\" data-tools=\"135编辑器\" data-id=\"87544\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\"><section data-width=\"90%\" style=\"margin:30px auto;padding-right:15px;padding-left:15px;max-width:100%;width:90%;vertical-align:top;line-height:0.5;box-sizing:border-box;\"><section style=\"max-width:100%;transform:rotateZ(4.6deg);-webkit-transform:rotateZ(4.6deg);-moz-transform:rotateZ(4.6deg);-ms-transform:rotateZ(4.6deg);-o-transform:rotateZ(4.6deg);\"><section style=\"margin-top:0.5em;margin-bottom:0.5em;max-width:100%;font-size:4.8px;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img border=\"0\" class=\"\" data-copyright=\"0\" data-cropselx1=\"0\" data-cropselx2=\"454\" data-cropsely1=\"0\" data-cropsely2=\"263\" data-type=\"jpeg\" data-width=\"100%\" title=\"微信图片_20180427143641_副本.jpg\" data-ratio=\"0.5555555555555556\" data-w=\"900\" _width=\"473px\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwc0pja8Q7tYE123gviaDGxlY4Sw8nvKGsNZLiatD8jJy0FOMWYcjEiafpw/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;border-width:0.8em;border-style:solid;border-color:white;box-shadow:#666666 0.2em 0.2em 0.5em;vertical-align:middle;width:100%;visibility:visible !important;\" />\n</p>\n</section></section><section style=\"max-width:100%;transform:rotateZ(352.25deg);-webkit-transform:rotateZ(352.25deg);-moz-transform:rotateZ(352.25deg);-ms-transform:rotateZ(352.25deg);-o-transform:rotateZ(352.25deg);\"><section style=\"margin-top:0.5em;margin-bottom:0.5em;max-width:100%;font-size:4.8px;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img border=\"0\" class=\"\" data-ratio=\"0.555\" data-type=\"jpeg\" data-w=\"800\" data-width=\"100%\" 泉州.jpg\"=\"\" width=\"100%\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQw875nGOkib6WpYCZZrtJubm2jcvwCWycG1gH7Prr0nTbibFSH3ldClnqA/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;max-width:100%;border-width:0.8em;border-style:solid;border-color:white;box-shadow:#666666 0.2em 0.2em 0.5em;vertical-align:middle;width:100%;visibility:visible !important;\">\n</p>\n</section></section><section style=\"max-width:100%;transform:rotateZ(4.58deg);-webkit-transform:rotateZ(4.58deg);-moz-transform:rotateZ(4.58deg);-ms-transform:rotateZ(4.58deg);-o-transform:rotateZ(4.58deg);\"><section style=\"margin-top:0.5em;margin-bottom:0.5em;max-width:100%;font-size:4.8px;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img border=\"0\" class=\"\" data-ratio=\"0.555\" data-type=\"jpeg\" data-w=\"800\" data-width=\"100%\" 山东.jpg\"=\"\" width=\"100%\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwEwrwTDq1ItiaIlZfWYPcna3f1681oHfSlt0MicaesniaTKSQ8pS5dSPxg/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;max-width:100%;border-width:0.8em;border-style:solid;border-color:white;box-shadow:#666666 0.2em 0.2em 0.5em;vertical-align:middle;width:100%;visibility:visible !important;\">\n</p>\n</section></section><section style=\"max-width:100%;transform:rotateZ(352.35deg);-webkit-transform:rotateZ(352.35deg);-moz-transform:rotateZ(352.35deg);-ms-transform:rotateZ(352.35deg);-o-transform:rotateZ(352.35deg);\"><section style=\"margin-top:0.5em;margin-bottom:0.5em;max-width:100%;font-size:4.8px;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img class=\"\" data-copyright=\"0\" data-cropselx1=\"0\" data-cropselx2=\"454\" data-cropsely1=\"0\" data-cropsely2=\"252\" data-ratio=\"0.5555555555555556\" data-type=\"jpeg\" data-w=\"900\" data-width=\"100%\" title=\"最佳射手.jpg\" _width=\"454px\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwA6UWfcmvfj2mNpxvXSMq7diaGeUue4ydmpQHPgY7570C7p2dp4f7xMQ/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;border-width:0.8em;border-style:solid;border-color:white;box-shadow:#666666 0.2em 0.2em 0.5em;vertical-align:middle;width:100%;visibility:visible !important;\" />\n</p>\n</section></section></section></section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"16%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;width:16%;box-sizing:border-box;\"></section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"95%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;font-size:medium;line-height:25.6px;white-space:normal;widows:1;width:95%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img class=\"\" data-ratio=\"0.66625\" data-type=\"jpeg\" data-w=\"800\" title=\"IMG_3706_副本.jpg\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwFTkrhfly941AmCfJyCQ19DgE7H1nMcPiaslyLlAdRmBlljPf5h98U3g/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;width:auto !important;visibility:visible !important;\" />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;font-size:medium;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"93%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;font-size:medium;line-height:25.6px;white-space:normal;widows:1;width:93%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<span style=\"max-width:100%;color:#595959;font-size:13px;\">&nbsp; &nbsp; &nbsp; 仪式上，福建省体彩管理中心主任刘奉利先生发表了重要讲话，比赛深入学习贯彻党的十九大和十九届三中全会精神，以习近平新时代中国特色社会主义思想为指导，以习近平体育思想为引领，牢固树立公益体彩、民生体彩、责任体彩、诚信体彩的理念，牢记使命、开拓创新，<span style=\"max-width:100%;color:#ff0000;\">开启体育彩票事业高质量发展新征程。</span></span>\n</p>\n</section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"95%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;font-size:medium;line-height:25.6px;white-space:normal;widows:1;width:95%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img class=\"\" data-ratio=\"0.66625\" data-type=\"jpeg\" data-w=\"800\" title=\"微信图片_20180427183756.jpg\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwjSAsfNXjiaLl3IicGt5FkFoAH6BBOAj6Micicw9uRp8zOGbDZVZTvEZZEQ/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;width:auto !important;visibility:visible !important;\" />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"93%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;font-size:medium;line-height:25.6px;white-space:normal;widows:1;width:93%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<span style=\"max-width:100%;color:#595959;font-size:13px;\">&nbsp; &nbsp; &nbsp; 同时，咕啦副总裁许亚东先生采访后说到，咕啦一直很关注、参与和支持各项公益事业，希望通过自身的努力，让更多有责任感的有识之士参与进来。此次邀请赛，<span style=\"max-width:100%;color:#ff0000;\">咕啦作为唯一的承办单位，积极配合体彩公益事业，打破常规，多渠道、多元化发展，将中国烟草、运动品牌贵人鸟集团、沙县公会等优质渠道，结合新零售概念，将体彩精神深耕细作。</span>在增加彩票销量的同时，弘扬传播大爱、践行公益力量，让每一个体育彩票购买者，都通过自己的随手公益行为，传播“乐善人生”的公益理念，为公益事业奉献点滴之爱。</span>\n</p>\n</section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"95%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;font-size:medium;line-height:25.6px;white-space:normal;widows:1;width:95%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img class=\"\" data-ratio=\"0.66625\" data-type=\"jpeg\" data-w=\"800\" title=\"微信图片_20180427190416_副本.jpg\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwhAAo8vRcEgyY6p57DEEPevicWKp1icOsxtTDu2sn2LicDXRIgZEUoMejg/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;width:auto !important;visibility:visible !important;\" />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"93%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;font-size:medium;line-height:25.6px;white-space:normal;widows:1;width:93%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<span style=\"max-width:100%;color:#595959;font-size:13px;\">&nbsp; &nbsp; &nbsp; 此次邀请赛，体彩携手咕啦<span style=\"max-width:100%;color:#ff0000;\">将“做公益”与“足球运动”相结合</span>，并希望以此为开端，增进与新老彩民的互动沟通，倡导绿色公益、健康公益和快乐公益，传播体彩大爱。<span style=\"max-width:100%;color:#ff0000;\">以球会友、共倡公益。</span></span>\n</p>\n</section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section class=\"\" data-tools=\"135编辑器\" data-id=\"91874\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\"><section data-role=\"paragraph\" class=\"\" data-width=\"95%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;border:0px none;width:95%;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<img class=\"\" data-ratio=\"0.555\" data-type=\"jpeg\" data-w=\"800\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwMhetW11lRhEDWPibl1Rib8OkFiaKYDbrticY6iaG7J5kAIiaItpwW0MUpWuA/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;width:auto !important;visibility:visible !important;\" />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"93%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;border:0px none;width:93%;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<span style=\"max-width:100%;color:#595959;font-size:13px;\">&nbsp; &nbsp; &nbsp; 通过此次比赛，六个省份的体彩人用足球比赛促进感情，各地体彩中心相互交流，探讨行业内部发展的新方向及异业合作的可能性，以公益事业为先，<span style=\"max-width:100%;color:#ff0000;\">共同将公益事业践行下去。</span></span>\n</p>\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;border:0px none;box-sizing:border-box;\"></section><section class=\"\" data-tools=\"135编辑器\" data-id=\"92418\" style=\"max-width:100%;border:0px none;box-sizing:border-box;\"><section class=\"\" data-width=\"95%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;border:0px none;width:95%;box-sizing:border-box;\"><section data-width=\"100%\" style=\"max-width:100%;width:100%;\"><section style=\"margin-right:auto;margin-left:auto;max-width:100%;text-align:center;transform:translateZ(10px);-webkit-transform:translateZ(10px);-moz-transform:translateZ(10px);-ms-transform:translateZ(10px);-o-transform:translateZ(10px);\"><section style=\"padding-right:6px;padding-left:6px;max-width:100%;width:auto;display:inline-block;background-color:#FEFEFE;box-sizing:border-box;\"><section style=\"max-width:100%;display:flex;\"><section style=\"padding-right:15px;padding-left:15px;max-width:100%;border-radius:8px;height:35px;color:#fefefe;line-height:35px;font-size:18px;background-color:#fdc010;transform:translateZ(10px);-webkit-transform:translateZ(10px);-moz-transform:translateZ(10px);-ms-transform:translateZ(10px);-o-transform:translateZ(10px);\">\n<p style=\"max-width:100%;min-height:1em;white-space:nowrap;margin:5px 0px;margin:5px 0px;\">\n	<strong class=\"\" data-brushtype=\"text\" style=\"max-width:100%;\">特别鸣谢</strong>\n</p>\n</section><section style=\"margin-top:-14px;margin-left:3px;max-width:100%;width:20px;height:25px;background-image:url(\'http://mpt.135editor.com/mmbiz_png/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwIiac9e7fcAqC3YHLb9Ff8v57uPbJB13b0j9BnhqVkUl4rMxfVS0ySdQ/640?wx_fmt=png\');background-color:#fdc010;background-size:100% 100%;background-position:50% 50%;background-repeat:no-repeat;\"><br style=\"max-width:100%;\" />\n</section></section></section></section><section style=\"margin-top:-18px;padding:15px;max-width:100%;border:1px solid #FDC010;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<span style=\"max-width:100%;font-size:10px;color:#ffffff;\">.</span>\n</p>\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img class=\"\" data-copyright=\"0\" data-cropselx1=\"0\" data-cropselx2=\"391\" data-cropsely1=\"0\" data-cropsely2=\"528\" data-ratio=\"1.35\" data-s=\"300,640\" data-type=\"png\" data-w=\"900\" _width=\"391px\" src=\"http://mpt.135editor.com/mmbiz_png/iblmM7c3LR1oEbqGUpD3oDUicoswSqFDEFEibtTv0J7LvQ9r7xbwGvUAubUZDtiaSqR9yRxvExGcoia42StegqYIWww/640?wx_fmt=png\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;width:100%;visibility:visible !important;\" />\n</p>\n<p style=\"max-width:100%;min-height:1em;letter-spacing:0.5px;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<span style=\"max-width:100%;font-family:&quot;\"><strong style=\"max-width:100%;\"><span style=\"max-width:100%;font-size:15px;color:#ff0000;\">对本次赛事提供的赞助支持！</span></strong></span>\n</p>\n</section></section></section></section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section class=\"\" data-width=\"95%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;width:95%;border:0px none;box-sizing:border-box;\"><section data-width=\"100%\" style=\"max-width:100%;width:100%;text-align:center;\"></section></section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"93%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;border:0px none;width:93%;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<span style=\"max-width:100%;font-family:&quot;\"><strong style=\"max-width:100%;\"><span style=\"max-width:100%;font-size:15px;color:#ff0000;\">上期H5中奖名单如下：</span></strong></span>\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"95%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;border:0px none;width:95%;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img class=\"\" data-copyright=\"0\" data-cropselx1=\"0\" data-cropselx2=\"530\" data-cropsely1=\"0\" data-cropsely2=\"1393\" data-ratio=\"2.6266666666666665\" data-type=\"jpeg\" data-w=\"900\" title=\"3333.jpg\" _width=\"530px\" src=\"http://mpt.135editor.com/mmbiz_jpg/iblmM7c3LR1oEbqGUpD3oDUicoswSqFDEFP6eGicMDheUUWu6MaNCicNZnt6NEZ1HjlqwoJJBs0gp91vJ8zXfGAGicg/640?wx_fmt=jpeg\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;width:100%;visibility:visible !important;\" />\n</p>\n</section></section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;font-size:medium;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" data-width=\"95%\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;font-size:medium;line-height:25.6px;white-space:normal;widows:1;width:95%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img class=\"__bg_gif\" data-ratio=\"1\" data-type=\"gif\" data-w=\"400\" width=\"30px\" _width=\"30px\" src=\"http://mpt.135editor.com/mmbiz_gif/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwB42z5wZIfW77otJu5ahffPYZbKygJoIAylzSKYkHvutibfd1vU5S4gA/640?wx_fmt=gif\" data-order=\"2\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;margin-right:auto;margin-left:auto;display:inline-block;vertical-align:middle;width:30px !important;visibility:visible !important;\" /><span style=\"max-width:100%;\">&nbsp;</span><span style=\"max-width:100%;color:#797979;font-size:12px;\">尝试更多购彩体验，那就关注一下呗☺</span>\n</p>\n</section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;font-size:medium;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;margin:5px 0px;margin:5px 0px;\">\n	<br />\n</p>\n</section><section class=\"\" data-tools=\"135编辑器\" data-id=\"89428\" data-width=\"95%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;width:95%;border:0px none;box-sizing:border-box;\"><section style=\"max-width:100%;text-align:center;height:50px;\"><section style=\"margin-right:auto;margin-left:auto;max-width:100%;width:48px;height:48px;color:#ffffff;line-height:48px;display:inline-block;background-image:url(\'http://mpt.135editor.com/mmbiz_gif/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQww3euXKZSAZ4IariaTcBzpAoFpYiamHbUhywQ0SmvRxPKhRm2yKYXHDow/640?wx_fmt=gif\');background-size:100%;background-position:0px 50%;background-repeat:no-repeat;\">\n<p style=\"max-width:100%;min-height:1em;font-weight:bold;margin:5px 0px;margin:5px 0px;\">\n	完\n</p>\n</section><section style=\"margin-top:-26px;max-width:100%;height:2px;background-color:#222121;\"></section></section></section><section data-role=\"paragraph\" class=\"\" data-width=\"95%\" style=\"margin-right:auto;margin-left:auto;max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;width:95%;border:0px none;box-sizing:border-box;\">\n<p style=\"max-width:100%;min-height:1em;text-align:center;margin:5px 0px;margin:5px 0px;\">\n	<img class=\" __bg_gif\" data-ratio=\"0.49921875\" data-type=\"gif\" data-w=\"1280\" title=\"咕啦体育微信二维码新版.gif\" src=\"http://mpt.135editor.com/mmbiz_gif/iblmM7c3LR1qV9QRia539lnwNXibw3oPxQwdRyUU9DGsiaVlVAaABeibZxgjISC4vU1owuC3CFrqPVzlxkekGKPb7icQ/640?wx_fmt=gif\" data-order=\"3\" data-fail=\"0\" style=\"max-width:100%;max-width:100%;width:auto !important;visibility:visible !important;\" />\n</p>\n</section><section data-role=\"paragraph\" class=\"\" style=\"max-width:100%;color:#3E3E3E;font-family:&quot;line-height:25.6px;white-space:normal;widows:1;border:0px none;box-sizing:border-box;\"></section>\n<p>\n	<br />\n</p>\n</section></section>', '0', '1', '2019-01-24 16:51:29', '2019-07-16 16:10:39');
INSERT INTO `product` VALUES ('2', '工商年检 工商许可', '根据国家有关规定完成公司年度 公司年检；根据国家有关规定和 公司实际经营需求完成公司工商 许可办理和行政审批工作。', '5', 'http://119.23.239.189:8082/productImg/190125073112_190125153115.jpg', '0.08', '根据国家有关规定完成公司年度 公司年检；根据国家有关规定和 公司实际经营需求完成公司工商 许可办理和行政审批工作。', '1', '1', '2019-01-24 17:08:31', '2019-01-28 17:52:27');
INSERT INTO `product` VALUES ('3', '公司注销', '根据企业提供公司设立或变更的 的资料整理符合工商部门要求， 办理企业的工商设立或变更工作 事宜。', '5', 'http://119.23.239.189:8082/productImg/190125022544_190125102547.jpg', '0.02', '<div style=\"text-align:center;\">\n	根据企业提供公司设立或变更的 的资料整理符合工商部门要求， 办理企业的工商设立或变更工作 事宜。\n</div>', '1', '1', '2019-01-25 10:26:16', '2019-01-25 10:32:57');
INSERT INTO `product` VALUES ('4', '代理记账', '代理记帐作为一种新颖的会计解决方案和新 的社会性会计服务项目，主要为客户提供审 核原始凭证、填制证账凭证、登记会计账簿、 编制会计报表。', '6', 'http://119.23.239.189:8082/productImg/190129073342_190129153342.jpg', '300.00', '<div style=\"text-align:center;\">\n	代理记帐作为一种新颖的会计解决方案和新 的社会性会计服务项目，主要为客户提供审 核原始凭证、填制证账凭证、登记会计账簿、 编制会计报表。<br />\n</div>', '0', '1', '2019-01-25 10:27:18', '2019-07-16 16:10:23');
INSERT INTO `product` VALUES ('5', '财税顾问', '财税顾问服务主要为企业提供财务咨询、高 新企业账务指导、税务风险诊断、税收筹划、 税务会计处理。', '6', 'http://119.23.239.189:8082/productImg/190128090907_190128170908.jpg', '1.00', '<div style=\"text-align:center;\">\n	财税顾问服务主要为企业提供财务咨询、高 新企业账务指导、税务风险诊断、税收筹划、 税务会计处理。<br />\n</div>', '0', '1', '2019-01-28 17:09:18', '2019-01-30 11:30:08');
INSERT INTO `product` VALUES ('6', '纳税申报', '完成企业的月度或季度增值税申报、季 度企业所得税申报、月度个人所得税申 报、年度企业所得税汇算清缴、年度个 人所得税申报 。', '6', 'http://119.23.239.189:8082/productImg/190128091145_190128171145.jpg', '1.00', '<div style=\"text-align:center;\">\n	<h4 style=\"text-align:justify;\">\n		&nbsp;&nbsp;&nbsp;&nbsp;完成企业的月度或季度增值税申报、季 度企业所得税申报、月度个人所得税申 报、年度企业所得税汇算清缴、年度个 人所得税申报 。<span style=\"text-align:left;\"></span>\n	</h4>\n</div>', '1', '1', '2019-01-28 17:11:49', '2019-01-29 22:09:11');
INSERT INTO `product` VALUES ('7', '出口退税申报', '出口退税申报服务主要为企业办理出口货 物退（免）税认定、确认出口销售收入、 出口退（免）税申报。', '6', 'http://119.23.239.189:8082/productImg/190128091224_190128171224.jpg', '1.00', '<div style=\"text-align:center;\">\n	出口退税申报服务主要为企业办理出口货 物退（免）税认定、确认出口销售收入、 出口退（免）税申报。\n</div>', '1', '1', '2019-01-28 17:12:28', '2019-01-29 22:09:22');
INSERT INTO `product` VALUES ('8', '专利代理服务', '发明专利 实用新型专利 外观设计专利', '7', 'http://119.23.239.189:8082/productImg/190128091302_190128171302.jpg', '1.00', '<div style=\"text-align:center;\">\n	发明专利 实用新型专利 外观设计专利\n</div>', '1', '1', '2019-01-28 17:13:05', '2019-01-29 22:10:15');
INSERT INTO `product` VALUES ('9', '商标代理服务', '商标注册、商标变更、商标转让、 商标续展、商标宽展、商标变更、 商标注销、商标许可备案、商标 文书代领、商标注册疑难。', '7', 'http://119.23.239.189:8082/productImg/190128091650_190128171650.jpg', '1.00', '<div style=\"text-align:left;\">\n	商标注册、商标变更、商标转让、 商标续展、商标宽展、商标变更、 商标注销、商标许可备案、商标 文书代领、商标注册疑难。<br />\n</div>', '1', '1', '2019-01-28 17:17:10', '2019-01-29 22:10:38');

-- ----------------------------
-- Table structure for shop_car
-- ----------------------------
DROP TABLE IF EXISTS `shop_car`;
CREATE TABLE `shop_car` (
  `car_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `nums` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`car_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of shop_car
-- ----------------------------
INSERT INTO `shop_car` VALUES ('37', '1', '7', '1', '2019-02-25 11:05:49', null, '2019-02-25 11:05:49');
INSERT INTO `shop_car` VALUES ('39', '1', '6', '1', '2019-06-06 11:06:23', null, '2019-06-06 11:06:23');
INSERT INTO `shop_car` VALUES ('40', '1', '9', '1', '2019-06-06 11:08:28', null, '2019-06-06 11:08:28');
INSERT INTO `shop_car` VALUES ('41', '2', '9', '1', '2019-06-13 13:48:54', null, '2019-06-13 13:48:54');
INSERT INTO `shop_car` VALUES ('42', '1', '2', '1', '2019-07-17 14:44:50', null, '2019-07-17 14:44:50');
INSERT INTO `shop_car` VALUES ('43', '1', '3', '1', '2019-07-17 14:44:56', null, '2019-07-17 14:44:56');
INSERT INTO `shop_car` VALUES ('44', '7', '7', '1', '2019-07-17 14:51:32', null, '2019-07-17 14:51:32');
INSERT INTO `shop_car` VALUES ('45', '1', '4', '1', '2019-07-17 14:52:59', null, '2019-07-17 14:52:59');

-- ----------------------------
-- Table structure for shop_orders
-- ----------------------------
DROP TABLE IF EXISTS `shop_orders`;
CREATE TABLE `shop_orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_code` varchar(45) NOT NULL COMMENT '订单编号',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `order_num` int(11) DEFAULT NULL COMMENT '商品总数',
  `order_money` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '订单总金额',
  `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态 0：待付款 1：待发货 2：待收货 3:退款、售后 4:已完成 5:取消',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 0 未支付 1 已支付 2 订单取消',
  `address` varchar(255) DEFAULT NULL COMMENT '收货地址',
  `remark` varchar(500) DEFAULT NULL COMMENT '用户备注',
  `touser_remark` varchar(500) DEFAULT NULL COMMENT '商家备注',
  `order_time` datetime NOT NULL COMMENT '下单时间',
  `pay_time` datetime DEFAULT NULL COMMENT '支付时间',
  `send_time` datetime DEFAULT NULL COMMENT '发货时间',
  `receive_time` datetime DEFAULT NULL COMMENT '收货时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `wxpay_data` text COMMENT '微信支付数据包',
  `add_status` tinyint(1) DEFAULT '0' COMMENT '收货地址修改状态 0 未修改 1 已修改',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of shop_orders
-- ----------------------------
INSERT INTO `shop_orders` VALUES ('1', 'GLSBUY19012811B0001', '2', '2', '0.09', '3', '1', null, null, null, '2019-01-28 11:30:29', '2019-01-29 15:18:10', null, null, '2019-01-29 15:18:11', null, '0');
INSERT INTO `shop_orders` VALUES ('2', 'GLSBUY19012811B0002', '2', '1', '0.08', '0', '0', null, null, null, '2019-01-28 11:34:46', null, null, null, '2019-01-28 11:34:46', null, '0');
INSERT INTO `shop_orders` VALUES ('3', 'GLSBUY19012811B0003', '2', '1', '0.02', '4', '1', null, null, null, '2019-01-28 11:36:29', '2019-01-29 15:09:36', '2019-01-29 15:09:39', '2019-01-29 15:09:42', '2019-01-29 15:12:21', null, '0');
INSERT INTO `shop_orders` VALUES ('4', 'GLSBUY19012811B0004', '2', '2', '0.13', '2', '1', null, null, null, '2019-01-28 11:37:35', '2019-01-29 14:38:11', '2019-01-29 14:50:42', null, '2019-01-29 14:51:03', null, '0');
INSERT INTO `shop_orders` VALUES ('5', 'GLSBUY19012811B0005', '2', '2', '0.03', '1', '1', null, null, null, '2019-01-28 11:50:45', '2019-01-29 14:28:15', null, null, '2019-01-29 14:28:17', null, '0');
INSERT INTO `shop_orders` VALUES ('6', 'GLSBUY19012817B0001', '1', '2', '2.00', '0', '0', null, null, null, '2019-01-28 17:46:56', null, null, null, '2019-01-28 17:46:56', null, '0');
INSERT INTO `shop_orders` VALUES ('7', 'GLSBUY19012817B0002', '1', '1', '0.08', '0', '0', null, null, null, '2019-01-28 17:52:42', null, null, null, '2019-01-28 17:52:42', null, '0');
INSERT INTO `shop_orders` VALUES ('8', 'GLSBUY19012910B0001', '1', '3', '2.08', '0', '0', null, null, null, '2019-01-29 10:23:55', null, null, null, '2019-01-29 10:23:55', null, '0');
INSERT INTO `shop_orders` VALUES ('9', 'GLSBUY19012915B0001', '2', '2', '301.00', '0', '0', null, null, null, '2019-01-29 15:56:04', null, null, null, '2019-01-29 15:56:04', null, '0');
INSERT INTO `shop_orders` VALUES ('10', 'GLSBUY19012916B0001', '2', '1', '0.02', '0', '0', null, null, null, '2019-01-29 16:13:09', null, null, null, '2019-01-29 16:13:09', null, '0');
INSERT INTO `shop_orders` VALUES ('11', 'GLSBUY19012916B0002', '2', '1', '1.00', '0', '0', null, null, null, '2019-01-29 16:13:18', null, null, null, '2019-01-29 16:13:18', null, '0');
INSERT INTO `shop_orders` VALUES ('12', 'GLSBUY19012916B0003', '2', '1', '1.00', '0', '0', null, null, null, '2019-01-29 16:13:38', null, null, null, '2019-01-29 16:13:38', null, '0');
INSERT INTO `shop_orders` VALUES ('13', 'GLSBUY19013009B0001', '1', '1', '1.00', '0', '0', null, null, null, '2019-01-30 09:21:25', null, null, null, '2019-01-30 09:21:25', null, '0');
INSERT INTO `shop_orders` VALUES ('14', 'GLSBUY19013009B0002', '1', '2', '1.08', '0', '0', null, null, null, '2019-01-30 09:45:47', null, null, null, '2019-01-30 09:45:47', null, '0');
INSERT INTO `shop_orders` VALUES ('15', 'GLSBUY19013022B0001', '1', '1', '1.00', '0', '0', null, null, null, '2019-01-30 22:33:43', null, null, null, '2019-01-30 22:33:43', null, '0');
INSERT INTO `shop_orders` VALUES ('16', 'GLSBUY19013108B0001', '5', '1', '300.00', '0', '0', null, null, null, '2019-01-31 08:48:47', null, null, null, '2019-01-31 08:48:47', null, '0');
INSERT INTO `shop_orders` VALUES ('17', 'GLSBUY19020313B0001', '2', '1', '1.00', '0', '0', null, null, null, '2019-02-03 13:05:05', null, null, null, '2019-02-03 13:05:05', null, '0');
INSERT INTO `shop_orders` VALUES ('18', 'GLSBUY19022214B0001', '1', '1', '1.00', '0', '0', null, null, null, '2019-02-22 14:31:37', null, null, null, '2019-02-22 14:31:37', null, '0');
INSERT INTO `shop_orders` VALUES ('19', 'GLSBUY19022216B0001', '1', '1', '0.01', '0', '0', null, null, null, '2019-02-22 16:00:11', null, null, null, '2019-02-22 16:00:11', null, '0');
INSERT INTO `shop_orders` VALUES ('20', 'GLSBUY19022216B0002', '1', '3', '2.02', '0', '0', null, null, null, '2019-02-22 16:19:03', null, null, null, '2019-02-22 16:19:03', null, '0');
INSERT INTO `shop_orders` VALUES ('21', 'GLSBUY19022216B0003', '1', '1', '0.02', '0', '0', null, null, null, '2019-02-22 16:48:38', null, null, null, '2019-02-22 16:48:38', null, '0');
INSERT INTO `shop_orders` VALUES ('22', 'GLSBUY19060611B0001', '1', '2', '2.00', '0', '0', null, null, null, '2019-06-06 11:06:27', null, null, null, '2019-06-06 11:06:27', null, '0');
INSERT INTO `shop_orders` VALUES ('23', 'GLSBUY19071714B0001', '1', '1', '1.00', '0', '0', null, null, null, '2019-07-17 14:05:47', null, null, null, '2019-07-17 14:05:47', null, '0');
INSERT INTO `shop_orders` VALUES ('24', 'GLSBUY19071715B0001', '1', '1', '0.01', '0', '0', null, null, null, '2019-07-17 15:01:52', null, null, null, '2019-07-17 15:01:52', null, '0');

-- ----------------------------
-- Table structure for shop_orders_detail
-- ----------------------------
DROP TABLE IF EXISTS `shop_orders_detail`;
CREATE TABLE `shop_orders_detail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '所属订单',
  `product_id` int(11) NOT NULL COMMENT '商品id',
  `product_price` decimal(12,2) DEFAULT NULL COMMENT '单价',
  `num` int(11) DEFAULT NULL COMMENT '购买数量',
  `is_gift` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否参与优惠',
  `total_money` decimal(12,2) DEFAULT NULL COMMENT '总金额',
  `is_comment` tinyint(1) DEFAULT '0' COMMENT '是否已评价 0 未评价 1已评价',
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of shop_orders_detail
-- ----------------------------
INSERT INTO `shop_orders_detail` VALUES ('1', '1', '1', '0.01', '1', '0', '0.01', '0');
INSERT INTO `shop_orders_detail` VALUES ('2', '1', '2', '0.08', '1', '0', '0.08', '0');
INSERT INTO `shop_orders_detail` VALUES ('3', '2', '2', '0.08', '1', '0', '0.08', '0');
INSERT INTO `shop_orders_detail` VALUES ('4', '3', '3', '0.02', '1', '0', '0.02', '0');
INSERT INTO `shop_orders_detail` VALUES ('5', '4', '2', '0.08', '1', '0', '0.08', '0');
INSERT INTO `shop_orders_detail` VALUES ('6', '4', '4', '0.05', '1', '0', '0.05', '0');
INSERT INTO `shop_orders_detail` VALUES ('7', '5', '1', '0.01', '1', '0', '0.01', '0');
INSERT INTO `shop_orders_detail` VALUES ('8', '5', '3', '0.02', '1', '0', '0.02', '0');
INSERT INTO `shop_orders_detail` VALUES ('9', '6', '8', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('10', '6', '9', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('11', '7', '2', '0.08', '1', '0', '0.08', '0');
INSERT INTO `shop_orders_detail` VALUES ('12', '8', '7', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('13', '8', '2', '0.08', '1', '0', '0.08', '0');
INSERT INTO `shop_orders_detail` VALUES ('14', '8', '5', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('15', '9', '5', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('16', '9', '4', '300.00', '1', '0', '300.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('17', '10', '3', '0.02', '1', '0', '0.02', '0');
INSERT INTO `shop_orders_detail` VALUES ('18', '11', '5', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('19', '12', '6', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('20', '13', '9', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('21', '14', '6', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('22', '14', '2', '0.08', '1', '0', '0.08', '0');
INSERT INTO `shop_orders_detail` VALUES ('23', '15', '8', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('24', '16', '4', '300.00', '1', '0', '300.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('25', '17', '8', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('26', '18', '8', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('27', '19', '1', '0.01', '1', '0', '0.01', '0');
INSERT INTO `shop_orders_detail` VALUES ('28', '20', '3', '0.02', '1', '0', '0.02', '0');
INSERT INTO `shop_orders_detail` VALUES ('29', '20', '6', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('30', '20', '7', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('31', '21', '3', '0.02', '1', '0', '0.02', '0');
INSERT INTO `shop_orders_detail` VALUES ('32', '22', '6', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('33', '22', '7', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('34', '23', '9', '1.00', '1', '0', '1.00', '0');
INSERT INTO `shop_orders_detail` VALUES ('35', '24', '1', '0.01', '1', '0', '0.01', '0');

-- ----------------------------
-- Table structure for shop_pay_record
-- ----------------------------
DROP TABLE IF EXISTS `shop_pay_record`;
CREATE TABLE `shop_pay_record` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商城交易记录主键ID',
  `record_code` varchar(50) DEFAULT NULL COMMENT '交易记录编号',
  `order_id` int(11) DEFAULT NULL COMMENT '订单主键ID',
  `order_code` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `user_id` int(11) DEFAULT NULL COMMENT '支付人ID',
  `cust_no` varchar(25) DEFAULT NULL COMMENT '支付人编号',
  `outer_code` varchar(200) DEFAULT NULL COMMENT '第三方支付编号',
  `refund_code` varchar(50) DEFAULT NULL COMMENT '退款编号',
  `third_refund_code` varchar(200) DEFAULT '' COMMENT '第三方退款编号',
  `pay_type` tinyint(4) DEFAULT NULL COMMENT '支付类型 1：购买 2：退款',
  `pay_way` tinyint(4) DEFAULT NULL COMMENT '支付渠道 1 支付宝  2微信支付 3余额 4 合支付 5 钱包H5',
  `pre_money` decimal(18,2) DEFAULT '0.00' COMMENT '预支付金额',
  `pay_money` decimal(18,2) DEFAULT '0.00' COMMENT '实付金额',
  `balance` decimal(18,2) DEFAULT '0.00' COMMENT '余额',
  `status` tinyint(4) DEFAULT '0' COMMENT '订单状态 0：未支付 1：已支付  2:退款成功',
  `pay_time` datetime DEFAULT NULL COMMENT '支付时间',
  `create_time` datetime DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of shop_pay_record
-- ----------------------------
INSERT INTO `shop_pay_record` VALUES ('1', 'GLSPAY19012811P0001', '1', 'GLSBUY19012811B0001', '2', 'gl100002', null, null, '', '1', '2', '0.09', '0.00', '0.00', '0', null, '2019-01-28 11:30:29', '2019-01-28 11:30:29', '2019-01-28 11:30:29');
INSERT INTO `shop_pay_record` VALUES ('2', 'GLSPAY19012811P0002', '2', 'GLSBUY19012811B0002', '2', 'gl100002', null, null, '', '1', '2', '0.08', '0.00', '0.00', '0', null, '2019-01-28 11:34:46', '2019-01-28 11:34:46', '2019-01-28 11:34:46');
INSERT INTO `shop_pay_record` VALUES ('3', 'GLSPAY19012811P0003', '3', 'GLSBUY19012811B0003', '2', 'gl100002', null, null, '', '1', '2', '0.02', '0.00', '0.00', '0', null, '2019-01-28 11:36:29', '2019-01-28 11:36:29', '2019-01-28 11:36:29');
INSERT INTO `shop_pay_record` VALUES ('4', 'GLSPAY19012811P0004', '4', 'GLSBUY19012811B0004', '2', 'gl100002', null, null, '', '1', '2', '0.13', '0.00', '0.00', '0', null, '2019-01-28 11:37:35', '2019-01-28 11:37:35', '2019-01-28 11:37:35');
INSERT INTO `shop_pay_record` VALUES ('5', 'GLSPAY19012811P0005', '5', 'GLSBUY19012811B0005', '2', 'gl100002', null, null, '', '1', '2', '0.03', '0.00', '0.00', '0', null, '2019-01-28 11:50:45', '2019-01-28 11:50:45', '2019-01-28 11:50:45');
INSERT INTO `shop_pay_record` VALUES ('6', 'GLSPAY19012817P0001', '6', 'GLSBUY19012817B0001', '1', 'gl100001', null, null, '', '1', '2', '2.00', '0.00', '0.00', '0', null, '2019-01-28 17:46:56', '2019-01-28 17:46:56', '2019-01-28 17:46:56');
INSERT INTO `shop_pay_record` VALUES ('7', 'GLSPAY19012817P0002', '7', 'GLSBUY19012817B0002', '1', 'gl100001', null, null, '', '1', '2', '0.08', '0.00', '0.00', '0', null, '2019-01-28 17:52:42', '2019-01-28 17:52:42', '2019-01-28 17:52:42');
INSERT INTO `shop_pay_record` VALUES ('8', 'GLSPAY19012910P0001', '8', 'GLSBUY19012910B0001', '1', 'gl100001', null, null, '', '1', '2', '2.08', '0.00', '0.00', '0', null, '2019-01-29 10:23:55', '2019-01-29 10:23:55', '2019-01-29 10:23:55');
INSERT INTO `shop_pay_record` VALUES ('9', 'GLSPAY19012915P0001', '9', 'GLSBUY19012915B0001', '2', 'gl100002', null, null, '', '1', '2', '301.00', '0.00', '0.00', '0', null, '2019-01-29 15:56:04', '2019-01-29 15:56:04', '2019-01-29 15:56:04');
INSERT INTO `shop_pay_record` VALUES ('10', 'GLSPAY19012916P0001', '10', 'GLSBUY19012916B0001', '2', 'gl100002', null, null, '', '1', '2', '0.02', '0.00', '0.00', '0', null, '2019-01-29 16:13:09', '2019-01-29 16:13:09', '2019-01-29 16:13:09');
INSERT INTO `shop_pay_record` VALUES ('11', 'GLSPAY19012916P0002', '11', 'GLSBUY19012916B0002', '2', 'gl100002', null, null, '', '1', '2', '1.00', '0.00', '0.00', '0', null, '2019-01-29 16:13:18', '2019-01-29 16:13:18', '2019-01-29 16:13:18');
INSERT INTO `shop_pay_record` VALUES ('12', 'GLSPAY19012916P0003', '12', 'GLSBUY19012916B0003', '2', 'gl100002', null, null, '', '1', '2', '1.00', '0.00', '0.00', '0', null, '2019-01-29 16:13:38', '2019-01-29 16:13:38', '2019-01-29 16:13:38');
INSERT INTO `shop_pay_record` VALUES ('13', 'GLSPAY19013009P0001', '13', 'GLSBUY19013009B0001', '1', 'gl100001', null, null, '', '1', '2', '1.00', '0.00', '0.00', '0', null, '2019-01-30 09:21:25', '2019-01-30 09:21:25', '2019-01-30 09:21:25');
INSERT INTO `shop_pay_record` VALUES ('14', 'GLSPAY19013009P0002', '14', 'GLSBUY19013009B0002', '1', 'gl100001', null, null, '', '1', '2', '1.08', '0.00', '0.00', '0', null, '2019-01-30 09:45:47', '2019-01-30 09:45:47', '2019-01-30 09:45:47');
INSERT INTO `shop_pay_record` VALUES ('15', 'GLSPAY19013022P0001', '15', 'GLSBUY19013022B0001', '1', 'gl100001', null, null, '', '1', '2', '1.00', '0.00', '0.00', '0', null, '2019-01-30 22:33:43', '2019-01-30 22:33:43', '2019-01-30 22:33:43');
INSERT INTO `shop_pay_record` VALUES ('16', 'GLSPAY19013108P0001', '16', 'GLSBUY19013108B0001', '5', 'gl100005', null, null, '', '1', '2', '300.00', '0.00', '0.00', '0', null, '2019-01-31 08:48:47', '2019-01-31 08:48:47', '2019-01-31 08:48:47');
INSERT INTO `shop_pay_record` VALUES ('17', 'GLSPAY19020313P0001', '17', 'GLSBUY19020313B0001', '2', 'gl100002', null, null, '', '1', '2', '1.00', '0.00', '0.00', '0', null, '2019-02-03 13:05:05', '2019-02-03 13:05:05', '2019-02-03 13:05:05');
INSERT INTO `shop_pay_record` VALUES ('18', 'GLSPAY19022214P0001', '18', 'GLSBUY19022214B0001', '1', 'gl100001', null, null, '', '1', '2', '1.00', '0.00', '0.00', '0', null, '2019-02-22 14:31:37', '2019-02-22 14:31:37', '2019-02-22 14:31:37');
INSERT INTO `shop_pay_record` VALUES ('19', 'GLSPAY19022216P0001', '19', 'GLSBUY19022216B0001', '1', 'gl100001', null, null, '', '1', '2', '0.01', '0.00', '0.00', '0', null, '2019-02-22 16:00:11', '2019-02-22 16:00:11', '2019-02-22 16:00:11');
INSERT INTO `shop_pay_record` VALUES ('20', 'GLSPAY19022216P0002', '20', 'GLSBUY19022216B0002', '1', 'gl100001', null, null, '', '1', '2', '2.02', '0.00', '0.00', '0', null, '2019-02-22 16:19:03', '2019-02-22 16:19:03', '2019-02-22 16:19:03');
INSERT INTO `shop_pay_record` VALUES ('21', 'GLSPAY19022216P0003', '21', 'GLSBUY19022216B0003', '1', 'gl100001', null, null, '', '1', '2', '0.02', '0.00', '0.00', '0', null, '2019-02-22 16:48:38', '2019-02-22 16:48:38', '2019-02-22 16:48:38');
INSERT INTO `shop_pay_record` VALUES ('22', 'GLSPAY19060611P0001', '22', 'GLSBUY19060611B0001', '1', 'gl100001', null, null, '', '1', '2', '2.00', '0.00', '0.00', '0', null, '2019-06-06 11:06:27', '2019-06-06 11:06:27', '2019-06-06 11:06:27');
INSERT INTO `shop_pay_record` VALUES ('23', 'GLSPAY19071714P0001', '23', 'GLSBUY19071714B0001', '1', 'gl100001', null, null, '', '1', '2', '1.00', '0.00', '0.00', '0', null, '2019-07-17 14:05:47', '2019-07-17 14:05:47', '2019-07-17 14:05:47');
INSERT INTO `shop_pay_record` VALUES ('24', 'GLSPAY19071715P0001', '24', 'GLSBUY19071715B0001', '1', 'gl100001', null, null, '', '1', '2', '0.01', '0.00', '0.00', '0', null, '2019-07-17 15:01:52', '2019-07-17 15:01:52', '2019-07-17 15:01:52');

-- ----------------------------
-- Table structure for sys_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `sys_admin_role`;
CREATE TABLE `sys_admin_role` (
  `admin_role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户角色关系ID',
  `admin_id` int(11) NOT NULL COMMENT '后台用户ID',
  `role_id` int(11) DEFAULT NULL COMMENT '角色ID',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_admin_role
-- ----------------------------
INSERT INTO `sys_admin_role` VALUES ('12', '6', '4', '2018-11-06 14:31:22');
INSERT INTO `sys_admin_role` VALUES ('36', '1', '3', '2018-11-09 13:57:04');
INSERT INTO `sys_admin_role` VALUES ('39', '18', '12', '2019-03-27 16:37:58');

-- ----------------------------
-- Table structure for sys_auth
-- ----------------------------
DROP TABLE IF EXISTS `sys_auth`;
CREATE TABLE `sys_auth` (
  `auth_id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_name` varchar(50) NOT NULL COMMENT '权限名称',
  `auth_url` varchar(127) DEFAULT NULL COMMENT '权限URL',
  `auth_create_at` datetime NOT NULL COMMENT '创建时间',
  `auth_update_at` datetime NOT NULL COMMENT '更新时间',
  `auth_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1 开始 2关闭',
  `auth_pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级权限ID',
  `auth_level` int(11) NOT NULL DEFAULT '1',
  `auth_sort` int(11) NOT NULL DEFAULT '0' COMMENT '权限排序',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `auth_type` tinyint(1) DEFAULT '1' COMMENT '权限类型 1 页面 2 功能',
  PRIMARY KEY (`auth_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_auth
-- ----------------------------
INSERT INTO `sys_auth` VALUES ('1', '用户管理', '', '2018-10-30 16:23:42', '2018-11-06 18:11:15', '1', '22', '1', '0', '2018-11-06 18:11:28', '1');
INSERT INTO `sys_auth` VALUES ('2', '用户列表', '/adminmod/views/to-admin-list', '2018-10-30 16:26:27', '2018-11-05 09:30:10', '1', '1', '1', '0', '2018-12-20 10:09:31', '1');
INSERT INTO `sys_auth` VALUES ('3', '权限列表', '/adminmod/views/to-auth-list', '2018-10-30 16:27:16', '2018-11-05 09:30:16', '1', '1', '1', '0', '2018-11-05 09:30:26', '1');
INSERT INTO `sys_auth` VALUES ('5', '角色列表', '/adminmod/views/to-role-list', '2018-10-30 17:14:00', '2018-11-05 09:30:21', '1', '1', '1', '0', '2018-11-05 09:30:32', '1');
INSERT INTO `sys_auth` VALUES ('6', '服务管理', '', '2018-10-30 17:58:29', '2019-01-24 14:35:11', '1', '0', '1', '0', '2019-01-24 14:35:08', '1');
INSERT INTO `sys_auth` VALUES ('8', '订单列表', '/ordersmod/views/to-orders-list', '2018-10-30 18:00:12', '2019-06-03 09:15:02', '1', '70', '1', '0', '2019-06-03 09:15:02', '1');
INSERT INTO `sys_auth` VALUES ('10', '类别列表', '/productmod/views/to-category-list', '2018-10-30 18:40:36', '2019-01-24 14:36:48', '1', '6', '1', '90', '2019-01-24 14:36:46', '1');
INSERT INTO `sys_auth` VALUES ('11', '订购记录', '/ordersmod/views/to-order-list', '2018-10-30 18:41:42', '2018-11-06 18:20:57', '1', '6', '1', '0', '2018-11-06 18:21:10', '1');
INSERT INTO `sys_auth` VALUES ('12', '产品列表', '/productmod/views/to-product-list', '2018-10-30 19:34:36', '2019-01-24 15:49:16', '1', '6', '1', '22', '2019-01-24 15:49:13', '1');
INSERT INTO `sys_auth` VALUES ('14', '彩种列表', '/usermod/views/to-lottery-list', '2018-10-30 20:27:20', '2018-11-06 18:13:55', '1', '23', '1', '0', '2018-11-06 18:14:08', '1');
INSERT INTO `sys_auth` VALUES ('18', '销售明细', '/usermod/views/to-payrecord-list', '2018-11-02 15:58:36', '2018-11-06 18:17:02', '1', '6', '1', '0', '2018-11-06 18:17:15', '1');
INSERT INTO `sys_auth` VALUES ('19', '网站管理', '', '2018-11-05 17:58:48', '2019-06-03 09:18:13', '1', '0', '1', '-98', '2019-06-03 09:18:13', '1');
INSERT INTO `sys_auth` VALUES ('20', '广告管理', null, '2018-11-05 17:59:16', '2018-11-05 17:59:16', '1', '19', '1', '0', '2018-11-05 17:59:36', '1');
INSERT INTO `sys_auth` VALUES ('21', '购彩页面广告管理', '/websitemod/views/to-banner-list', '2018-11-06 09:34:45', '2018-11-06 09:34:45', '1', '20', '1', '0', '2018-11-06 09:35:04', '1');
INSERT INTO `sys_auth` VALUES ('22', '系统管理', '', '2018-11-06 18:11:01', '2019-06-03 09:15:59', '1', '0', '1', '-99', '2019-06-03 09:15:59', '1');
INSERT INTO `sys_auth` VALUES ('23', '基础资料', '', '2018-11-06 18:13:22', '2018-11-06 18:22:55', '1', '22', '1', '22', '2018-11-06 18:23:07', '1');
INSERT INTO `sys_auth` VALUES ('24', '销售统计', '/usermod/views/to-store-statistics', '2018-11-15 15:10:34', '2018-11-21 13:52:11', '1', '6', '1', '0', '2018-11-21 13:52:04', '1');
INSERT INTO `sys_auth` VALUES ('25', '查询网点', 'usermodStoreSearch', '2018-11-21 14:07:04', '2018-11-21 14:07:04', '1', '10', '1', '0', '2018-11-21 14:10:48', '2');
INSERT INTO `sys_auth` VALUES ('26', '查看网点', 'usermodStoreRead', '2018-11-21 14:07:30', '2018-11-21 14:07:30', '1', '10', '1', '0', '2018-11-21 14:10:55', '2');
INSERT INTO `sys_auth` VALUES ('27', '更改网点状态', 'usermodStoreChangeStatus', '2018-11-21 14:08:05', '2018-11-21 14:08:05', '1', '10', '1', '0', '2018-11-21 14:11:01', '2');
INSERT INTO `sys_auth` VALUES ('28', '查询权限', 'adminmodAuthSearch', '2018-11-21 14:09:18', '2018-11-21 14:09:18', '1', '3', '1', '0', '2018-11-21 14:24:34', '2');
INSERT INTO `sys_auth` VALUES ('29', '编辑权限', 'adminmodAuthEdit', '2018-11-21 14:12:27', '2018-11-21 14:12:27', '1', '3', '1', '0', '2018-11-21 14:12:20', '2');
INSERT INTO `sys_auth` VALUES ('30', '删除权限', 'adminmodAuthDelete', '2018-11-21 14:12:52', '2018-11-21 14:12:52', '1', '3', '1', '0', '2018-11-21 14:12:46', '2');
INSERT INTO `sys_auth` VALUES ('31', '新增权限', 'adminmodAuthAdd', '2018-11-21 14:13:10', '2018-11-21 14:13:10', '1', '3', '1', '0', '2018-11-21 14:24:37', '2');
INSERT INTO `sys_auth` VALUES ('32', '更改权限状态', 'adminmodAuthChangeStatus', '2018-11-21 14:13:48', '2018-11-21 14:13:48', '1', '3', '1', '0', '2018-11-21 14:13:41', '2');
INSERT INTO `sys_auth` VALUES ('33', '查询角色', 'adminmodRoleSearch', '2018-11-21 14:15:27', '2018-11-21 14:15:27', '1', '5', '1', '0', '2018-11-21 14:15:20', '2');
INSERT INTO `sys_auth` VALUES ('34', '新增角色', 'adminmodRoleAdd', '2018-11-21 14:16:06', '2018-11-21 14:16:06', '1', '5', '1', '0', '2018-11-21 14:15:59', '2');
INSERT INTO `sys_auth` VALUES ('35', '修改角色', 'adminmodRoleEdit', '2018-11-21 14:16:21', '2018-11-21 14:16:21', '1', '5', '1', '0', '2018-11-21 14:16:14', '2');
INSERT INTO `sys_auth` VALUES ('36', '删除角色', 'adminmodRoleDelete', '2018-11-21 14:16:35', '2018-11-21 14:16:35', '1', '5', '1', '0', '2018-11-21 14:16:28', '2');
INSERT INTO `sys_auth` VALUES ('37', '更改角色状态', 'adminmodRoleChangeStatus', '2018-11-21 14:16:56', '2018-11-21 14:16:56', '1', '5', '1', '0', '2018-11-21 14:16:49', '2');
INSERT INTO `sys_auth` VALUES ('38', '分配角色权限', 'adminmodRoleAuth', '2018-11-21 14:17:12', '2018-11-21 14:17:12', '1', '5', '1', '0', '2018-11-21 14:17:06', '2');
INSERT INTO `sys_auth` VALUES ('39', '查询用户', 'adminmodAdminSearch', '2018-11-21 14:31:18', '2018-11-21 14:31:18', '1', '2', '1', '0', '2018-11-21 14:31:11', '2');
INSERT INTO `sys_auth` VALUES ('40', '新增用户', 'adminmodAdminAdd', '2018-11-21 14:31:33', '2018-11-21 14:31:33', '1', '2', '1', '0', '2018-11-21 14:31:26', '2');
INSERT INTO `sys_auth` VALUES ('41', '编辑用户', 'adminmodAdminEdit', '2018-11-21 14:31:54', '2018-11-21 14:31:54', '1', '2', '1', '0', '2018-11-21 14:31:48', '2');
INSERT INTO `sys_auth` VALUES ('42', '删除用户', 'adminmodAdminDelete', '2018-11-21 14:32:07', '2018-11-21 14:32:07', '1', '2', '1', '0', '2018-11-21 14:32:01', '2');
INSERT INTO `sys_auth` VALUES ('43', '修改用户状态', 'adminmodAdminChangeStatus', '2018-11-21 14:32:28', '2018-11-21 14:32:28', '1', '2', '1', '0', '2018-11-21 14:32:21', '2');
INSERT INTO `sys_auth` VALUES ('44', '查询机器', 'usermodMachineSearch', '2018-11-21 15:04:08', '2018-11-21 15:04:08', '1', '12', '1', '0', '2018-11-21 15:04:07', '2');
INSERT INTO `sys_auth` VALUES ('45', '修改机器状态', 'usermodMachineChangeStatus', '2018-11-21 15:05:36', '2018-11-21 15:05:36', '1', '12', '1', '0', '2018-11-21 15:05:35', '2');
INSERT INTO `sys_auth` VALUES ('46', '修改机器售票状态', 'usermodMachineChangeSaleStatus', '2018-11-21 15:06:08', '2018-11-21 15:06:08', '1', '12', '1', '0', '2018-11-21 15:06:07', '2');
INSERT INTO `sys_auth` VALUES ('47', '解绑机器', 'usermodMachineRelieve', '2018-11-21 15:06:40', '2018-11-21 15:06:40', '1', '12', '1', '0', '2018-11-21 15:06:39', '2');
INSERT INTO `sys_auth` VALUES ('48', '查询订购记录', 'ordersmodOrdersSearch', '2018-11-21 15:12:01', '2018-11-21 15:12:01', '1', '11', '1', '0', '2018-11-21 15:12:01', '2');
INSERT INTO `sys_auth` VALUES ('49', '新增订单', 'ordersmodOrdersAdd', '2018-11-21 15:13:28', '2018-11-21 15:13:28', '1', '11', '1', '0', '2018-11-21 15:13:28', '2');
INSERT INTO `sys_auth` VALUES ('50', '订单发货', 'ordersmodOrdersSend', '2018-11-21 15:13:51', '2018-11-21 15:13:51', '1', '11', '1', '0', '2018-11-21 15:13:50', '2');
INSERT INTO `sys_auth` VALUES ('51', '查看订单详情', 'ordersmodOrdersRead', '2018-11-21 15:14:14', '2018-11-21 15:14:14', '1', '11', '1', '0', '2018-11-21 15:14:13', '2');
INSERT INTO `sys_auth` VALUES ('52', '查询销售明细', 'usermodPayrecordSearch', '2018-11-21 15:17:31', '2018-11-21 15:17:31', '1', '18', '1', '0', '2018-11-21 15:17:30', '2');
INSERT INTO `sys_auth` VALUES ('53', '查询销售统计', 'usermodPayrecordSearch1', '2018-11-21 15:21:31', '2018-11-21 15:21:31', '1', '24', '1', '0', '2018-11-21 15:21:30', '2');
INSERT INTO `sys_auth` VALUES ('54', '查询页面广告', 'websitemodBannerSearch', '2018-11-21 15:25:27', '2018-11-21 15:25:27', '1', '21', '1', '0', '2018-11-21 15:25:26', '2');
INSERT INTO `sys_auth` VALUES ('55', '新增广告', 'websitemodBannerAdd', '2018-11-21 15:25:44', '2018-11-21 15:27:07', '1', '21', '1', '0', '2018-11-21 15:27:06', '2');
INSERT INTO `sys_auth` VALUES ('56', '修改广告', 'websitemodBannerEdit', '2018-11-21 15:26:27', '2018-11-21 15:27:16', '1', '21', '1', '0', '2018-11-21 15:27:15', '2');
INSERT INTO `sys_auth` VALUES ('57', '删除广告', 'websitemodBannerDelete', '2018-11-21 15:27:30', '2018-11-21 15:27:30', '1', '21', '1', '0', '2018-11-21 15:27:29', '2');
INSERT INTO `sys_auth` VALUES ('58', '修改广告状态', 'websitemodBannerChangeStatus', '2018-11-21 15:27:50', '2018-11-21 15:27:50', '1', '21', '1', '0', '2018-11-21 15:27:49', '2');
INSERT INTO `sys_auth` VALUES ('59', '查询终端号', 'usermodTerminalSearch', '2018-11-21 15:30:58', '2018-11-21 15:30:58', '1', '8', '1', '0', '2018-11-21 15:30:57', '2');
INSERT INTO `sys_auth` VALUES ('60', '新增终端号', 'usermodTerminalAdd', '2018-11-21 15:31:19', '2018-11-21 15:31:19', '1', '8', '1', '0', '2018-11-21 15:31:18', '2');
INSERT INTO `sys_auth` VALUES ('61', '终端号发送', 'usermodTerminalSend', '2018-11-21 15:32:01', '2018-11-21 15:32:01', '1', '8', '1', '0', '2018-11-21 15:32:00', '2');
INSERT INTO `sys_auth` VALUES ('62', '修改终端号状态', 'usermodTerminalChangeStatus', '2018-11-21 15:32:32', '2018-11-21 15:32:32', '1', '8', '1', '0', '2018-11-21 15:32:31', '2');
INSERT INTO `sys_auth` VALUES ('63', '查看终端号二维码', 'usermodTerminalQrcode', '2018-11-21 15:33:03', '2018-11-21 15:33:03', '1', '8', '1', '0', '2018-11-21 15:33:03', '2');
INSERT INTO `sys_auth` VALUES ('64', '查询彩种', 'usermodLotterySearch', '2018-11-21 15:35:14', '2018-11-21 15:35:14', '1', '14', '1', '0', '2018-11-21 15:35:13', '2');
INSERT INTO `sys_auth` VALUES ('65', '新增彩种', 'usermodLotteryAdd', '2018-11-21 15:35:33', '2018-11-21 15:35:33', '1', '14', '1', '0', '2018-11-21 15:35:32', '2');
INSERT INTO `sys_auth` VALUES ('66', '修改彩种', 'usermodLotteryEdit', '2018-11-21 15:35:49', '2018-11-21 15:35:49', '1', '14', '1', '0', '2018-11-21 15:35:48', '2');
INSERT INTO `sys_auth` VALUES ('67', '删除彩种', 'usermodLotteryDelete', '2018-11-21 15:36:09', '2018-11-21 15:36:09', '1', '14', '1', '0', '2018-11-21 15:36:08', '2');
INSERT INTO `sys_auth` VALUES ('68', '修改彩种状态', 'usermodLotteryChangeStatus', '2018-11-21 15:36:31', '2018-11-21 15:36:31', '1', '14', '1', '0', '2018-11-21 15:36:30', '2');
INSERT INTO `sys_auth` VALUES ('69', '视频管理', '/websitemod/views/to-video-list', '2019-03-27 16:35:40', '2019-03-27 16:39:19', '1', '19', '1', '0', '2019-03-27 16:39:17', '1');
INSERT INTO `sys_auth` VALUES ('70', '订单管理', null, '2019-06-03 09:13:44', '2019-06-03 09:13:44', '1', '0', '1', '0', '2019-06-03 09:13:44', '1');

-- ----------------------------
-- Table structure for sys_role
-- ----------------------------
DROP TABLE IF EXISTS `sys_role`;
CREATE TABLE `sys_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `admin_pid` int(11) DEFAULT NULL COMMENT '创建者（所属者）ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login_port` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_role
-- ----------------------------
INSERT INTO `sys_role` VALUES ('3', '超级管理员', '1', '1', '2018-10-30 17:09:49', '2018-10-30 17:10:03', null);
INSERT INTO `sys_role` VALUES ('4', '渠道商', '1', '1', '2018-11-01 17:24:27', '2018-11-01 17:24:39', null);
INSERT INTO `sys_role` VALUES ('12', '视频管理员', '1', '1', '2019-03-27 16:37:16', '2019-03-27 16:37:14', null);

-- ----------------------------
-- Table structure for sys_role_auth
-- ----------------------------
DROP TABLE IF EXISTS `sys_role_auth`;
CREATE TABLE `sys_role_auth` (
  `role_auth_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `auth_id` int(11) NOT NULL COMMENT '权限ID',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_auth_id`)
) ENGINE=InnoDB AUTO_INCREMENT=532 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_role_auth
-- ----------------------------
INSERT INTO `sys_role_auth` VALUES ('316', '6', '22', '2018-11-08 16:20:33');
INSERT INTO `sys_role_auth` VALUES ('317', '6', '1', '2018-11-08 16:20:33');
INSERT INTO `sys_role_auth` VALUES ('318', '6', '2', '2018-11-08 16:20:33');
INSERT INTO `sys_role_auth` VALUES ('319', '6', '3', '2018-11-08 16:20:33');
INSERT INTO `sys_role_auth` VALUES ('320', '6', '5', '2018-11-08 16:20:33');
INSERT INTO `sys_role_auth` VALUES ('321', '11', '22', '2018-11-09 09:18:54');
INSERT INTO `sys_role_auth` VALUES ('322', '11', '1', '2018-11-09 09:18:54');
INSERT INTO `sys_role_auth` VALUES ('323', '11', '2', '2018-11-09 09:18:54');
INSERT INTO `sys_role_auth` VALUES ('324', '11', '5', '2018-11-09 09:18:54');
INSERT INTO `sys_role_auth` VALUES ('416', '4', '6', '2018-11-21 15:40:07');
INSERT INTO `sys_role_auth` VALUES ('417', '4', '10', '2018-11-21 15:40:07');
INSERT INTO `sys_role_auth` VALUES ('418', '4', '25', '2018-11-21 15:40:07');
INSERT INTO `sys_role_auth` VALUES ('419', '4', '26', '2018-11-21 15:40:07');
INSERT INTO `sys_role_auth` VALUES ('420', '4', '27', '2018-11-21 15:40:07');
INSERT INTO `sys_role_auth` VALUES ('421', '4', '11', '2018-11-21 15:40:07');
INSERT INTO `sys_role_auth` VALUES ('422', '4', '48', '2018-11-21 15:40:07');
INSERT INTO `sys_role_auth` VALUES ('423', '4', '49', '2018-11-21 15:40:07');
INSERT INTO `sys_role_auth` VALUES ('424', '4', '50', '2018-11-21 15:40:07');
INSERT INTO `sys_role_auth` VALUES ('425', '4', '51', '2018-11-21 15:40:07');
INSERT INTO `sys_role_auth` VALUES ('457', '12', '19', '2019-03-27 16:37:30');
INSERT INTO `sys_role_auth` VALUES ('458', '12', '69', '2019-03-27 16:37:30');
INSERT INTO `sys_role_auth` VALUES ('492', '3', '6', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('493', '3', '10', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('494', '3', '25', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('495', '3', '26', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('496', '3', '27', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('497', '3', '12', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('498', '3', '44', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('499', '3', '45', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('500', '3', '46', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('501', '3', '47', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('502', '3', '19', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('503', '3', '69', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('504', '3', '22', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('505', '3', '1', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('506', '3', '2', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('507', '3', '39', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('508', '3', '40', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('509', '3', '41', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('510', '3', '42', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('511', '3', '43', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('512', '3', '3', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('513', '3', '28', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('514', '3', '29', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('515', '3', '30', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('516', '3', '31', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('517', '3', '32', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('518', '3', '5', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('519', '3', '33', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('520', '3', '34', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('521', '3', '35', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('522', '3', '36', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('523', '3', '37', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('524', '3', '38', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('525', '3', '70', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('526', '3', '8', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('527', '3', '59', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('528', '3', '60', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('529', '3', '61', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('530', '3', '62', '2019-06-03 09:15:30');
INSERT INTO `sys_role_auth` VALUES ('531', '3', '63', '2019-06-03 09:15:30');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `cust_no` varchar(50) DEFAULT '' COMMENT '谷乐编号',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `pic` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `phone` varchar(20) DEFAULT '' COMMENT '手机号',
  `pwd` varchar(255) DEFAULT '' COMMENT '密码',
  `agent_code` varchar(50) DEFAULT '' COMMENT '上级编号',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1 正常 2 禁用',
  `real_name` varchar(50) DEFAULT '' COMMENT '真实姓名',
  `id_card_num` varchar(50) DEFAULT '' COMMENT '身份证号码',
  `e_mail` varchar(100) DEFAULT '' COMMENT '电子邮箱',
  `address` varchar(255) DEFAULT '' COMMENT '居住地址',
  `account_name` varchar(50) DEFAULT '' COMMENT '开户姓名',
  `bank_name` varchar(255) DEFAULT '' COMMENT '银行名称',
  `bank_card_num` varchar(100) DEFAULT '' COMMENT '银行卡号',
  `real_status` tinyint(1) DEFAULT '0' COMMENT '实名状态 0 未认证 1 审核中 2 已通过 3 未通过',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'gl100001', 'fkLee', 'https://imglottery.goodluckchina.net/img/user/user_pic/gl00017532/180226141142-jiuzaigou1.jpg', '15805963038', '96e79218965eb72c92a549dd5a330112', '', '1', '李家能', '35042419941011410', '1028617248@qq.com', '福建省厦门市湖里区金山街道高林社461号', '李家能', '中国建设银行宁化支行', '64203256325658541110', '1', '2019-01-10 17:16:44', '2019-05-08 15:54:41');
INSERT INTO `user` VALUES ('2', 'gl100002', '不愿将就', '', '15805963030', 'e10adc3949ba59abbe56e057f20f883e', '', '1', '李大大', '35656554541289', '1454487@qq.com', '测试地址', '李家能', '中国建设银行宁化支行', '6423556595464564', '1', '2019-01-10 17:37:22', '2019-01-24 10:11:41');
INSERT INTO `user` VALUES ('3', 'gl100003', '18250538930', 'https://imglottery.goodluckchina.net/img/user/user_pic/gl00017532/180226141142-jiuzaigou1.jpg', '18250538930', '202cb962ac59075b964b07152d234b70', '', '1', '', '', '', '', '', '', '', '0', '2019-01-17 17:00:20', '2019-01-18 14:42:13');
INSERT INTO `user` VALUES ('4', 'gl100004', '18250538960', 'https://imglottery.goodluckchina.net/img/user/user_pic/gl00017532/180226141142-jiuzaigou1.jpg', '18250538960', '202cb962ac59075b964b07152d234b70', '', '1', '', '', '', '', '', '', '', '0', '2019-01-17 17:04:45', '2019-01-18 14:42:13');
INSERT INTO `user` VALUES ('5', 'gl100005', '18685569889', null, '18685569889', '38f9143754d03f502fb1b303f31f01e9', '', '1', '', '', '', '', '', '', '', '0', '2019-01-31 08:40:04', '2019-01-31 08:40:04');
INSERT INTO `user` VALUES ('6', 'gl100006', '18030390525', null, '18030390525', 'c133dfbb77835810058037b04568b637', '', '1', '', '', '', '', '', '', '', '0', '2019-06-13 09:44:29', '2019-06-13 09:44:29');
INSERT INTO `user` VALUES ('7', 'gl100007', '15800000000', null, '15800000000', '96e79218965eb72c92a549dd5a330112', '', '1', '', '', '', '', '', '', '', '0', '2019-07-17 14:49:54', '2019-07-17 14:49:54');

-- ----------------------------
-- Table structure for video
-- ----------------------------
DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT '' COMMENT '路径',
  `type` tinyint(1) DEFAULT '1' COMMENT '类型 1 普通 2 私密',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`video_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of video
-- ----------------------------
INSERT INTO `video` VALUES ('14', 'http://119.23.239.189:8082/video/190328081853_53.mp4', '2', '2019-03-28 16:18:38', '2019-03-28 16:32:40');
INSERT INTO `video` VALUES ('15', 'http://119.23.239.189:8082/video/190328082255_43.mp4', '2', '2019-03-28 16:22:40', '2019-03-28 16:32:38');
INSERT INTO `video` VALUES ('16', 'http://119.23.239.189:8082/video/190328043127_82.mp4', '2', '2019-03-28 16:31:15', '2019-03-28 16:31:27');
INSERT INTO `video` VALUES ('17', 'http://119.23.239.189:8082/video/190328051930_97.mp4', '1', '2019-03-28 17:19:19', '2019-03-28 17:19:30');
