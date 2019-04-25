/*
MySQL Database Backup Tools
Server:127.0.0.1:
Database:zcms
Data:2019-04-23 17:22:57
*/
SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for lz_article
-- ----------------------------
DROP TABLE IF EXISTS `lz_article`;
CREATE TABLE `lz_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT '50',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `keywords` varchar(200) DEFAULT NULL COMMENT '关键字',
  `desc` varchar(255) DEFAULT NULL COMMENT '描述',
  `attr` varchar(50) DEFAULT NULL COMMENT '属性',
  `cate_id` mediumint(9) NOT NULL COMMENT '所属栏目',
  `picture` varchar(250) DEFAULT NULL COMMENT '封面图',
  `reviewed` tinyint(1) NOT NULL DEFAULT '1' COMMENT '审核',
  `click` mediumint(9) NOT NULL COMMENT '点击',
  `content` longtext NOT NULL COMMENT '内容',
  `pattern_id` varchar(255) DEFAULT NULL,
  `photos` tinyint(1) DEFAULT '0',
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=304 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_article
-- ----------------------------
INSERT INTO `lz_article` (`id`,`sort`,`title`,`keywords`,`desc`,`attr`,`cate_id`,`picture`,`reviewed`,`click`,`content`,`pattern_id`,`photos`,`create_time`) VALUES ('295','50','测试标题','测试标题','测试标题测试标题测试标题测试标题测试标题测试标题','h,s,r','51','','1','149',' ','3','0','1555664617');
INSERT INTO `lz_article` (`id`,`sort`,`title`,`keywords`,`desc`,`attr`,`cate_id`,`picture`,`reviewed`,`click`,`content`,`pattern_id`,`photos`,`create_time`) VALUES ('293','50','权利的游戏','权利的游戏','','s','50','','1','178',' ','2','0','1555634212');
INSERT INTO `lz_article` (`id`,`sort`,`title`,`keywords`,`desc`,`attr`,`cate_id`,`picture`,`reviewed`,`click`,`content`,`pattern_id`,`photos`,`create_time`) VALUES ('296','50','新闻标题','新闻标题','新闻标题','s','52','','1','78','<p>新闻标题新闻标题新闻标题</p>','1','0','1554887721');
INSERT INTO `lz_article` (`id`,`sort`,`title`,`keywords`,`desc`,`attr`,`cate_id`,`picture`,`reviewed`,`click`,`content`,`pattern_id`,`photos`,`create_time`) VALUES ('300','50','测试数据2222','测试数据2222','测试数据2222','h,s','50','','1','182',' ','2','0','1555895305');
INSERT INTO `lz_article` (`id`,`sort`,`title`,`keywords`,`desc`,`attr`,`cate_id`,`picture`,`reviewed`,`click`,`content`,`pattern_id`,`photos`,`create_time`) VALUES ('301','50','新闻测试','新闻测试','新闻测试','h','52','','1','60',' ','1','0','1555901073');
INSERT INTO `lz_article` (`id`,`sort`,`title`,`keywords`,`desc`,`attr`,`cate_id`,`picture`,`reviewed`,`click`,`content`,`pattern_id`,`photos`,`create_time`) VALUES ('302','50','测试新闻','测试新闻','测试新闻','h,s','52','','1','170',' ','1','0','1555895412');
INSERT INTO `lz_article` (`id`,`sort`,`title`,`keywords`,`desc`,`attr`,`cate_id`,`picture`,`reviewed`,`click`,`content`,`pattern_id`,`photos`,`create_time`) VALUES ('303','50','阿达','阿达阿达阿达阿达阿达阿达','','','52','','1','180',' ','1','0','1555915541');

-- ----------------------------
-- Table structure for lz_attr
-- ----------------------------
DROP TABLE IF EXISTS `lz_attr`;
CREATE TABLE `lz_attr` (
  `attr_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(10) NOT NULL,
  `attr_value` varchar(5) NOT NULL,
  PRIMARY KEY (`attr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_attr
-- ----------------------------
INSERT INTO `lz_attr` (`attr_id`,`attr_name`,`attr_value`) VALUES ('1','推荐','r');
INSERT INTO `lz_attr` (`attr_id`,`attr_name`,`attr_value`) VALUES ('2','热门','h');
INSERT INTO `lz_attr` (`attr_id`,`attr_name`,`attr_value`) VALUES ('3','头条','t');
INSERT INTO `lz_attr` (`attr_id`,`attr_name`,`attr_value`) VALUES ('4','置顶','s');

-- ----------------------------
-- Table structure for lz_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `lz_auth_group`;
CREATE TABLE `lz_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_auth_group
-- ----------------------------
INSERT INTO `lz_auth_group` (`id`,`title`,`status`,`rules`) VALUES ('1','管理员权限组','1','1,10,9');

-- ----------------------------
-- Table structure for lz_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `lz_auth_group_access`;
CREATE TABLE `lz_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_auth_group_access
-- ----------------------------
INSERT INTO `lz_auth_group_access` (`uid`,`group_id`) VALUES ('100','1');

-- ----------------------------
-- Table structure for lz_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `lz_auth_rule`;
CREATE TABLE `lz_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_auth_rule
-- ----------------------------
INSERT INTO `lz_auth_rule` (`id`,`name`,`title`,`status`,`condition`) VALUES ('1','admin/User/index','管理员','1','');
INSERT INTO `lz_auth_rule` (`id`,`name`,`title`,`status`,`condition`) VALUES ('10','admin/Rulers/index','权限表','1','');
INSERT INTO `lz_auth_rule` (`id`,`name`,`title`,`status`,`condition`) VALUES ('9','admin/Group/index','权限组','1','');

-- ----------------------------
-- Table structure for lz_cate
-- ----------------------------
DROP TABLE IF EXISTS `lz_cate`;
CREATE TABLE `lz_cate` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(50) NOT NULL COMMENT '栏目名称',
  `seo_cate` varchar(50) DEFAULT NULL COMMENT 'seo标题',
  `cate_keywords` varchar(150) DEFAULT NULL COMMENT '栏目关键词',
  `cate_desc` varchar(255) DEFAULT NULL COMMENT '栏目描述',
  `cate_img` varchar(200) DEFAULT NULL COMMENT '栏目图片',
  `pattern_id` mediumint(9) unsigned DEFAULT NULL,
  `cate_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `cate_pid` mediumint(9) NOT NULL DEFAULT '0' COMMENT '父栏目id',
  `cate_sort` int(5) NOT NULL DEFAULT '50' COMMENT '排序',
  `temp_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '栏目类型1.列表2单页3连接',
  `out_url` varchar(100) DEFAULT NULL,
  `index_temp` varchar(50) NOT NULL COMMENT '单页模板',
  `list_temp` varchar(50) NOT NULL COMMENT '列表模板',
  `article_temp` varchar(50) NOT NULL COMMENT '类别内容模板',
  `page` tinyint(2) DEFAULT '12' COMMENT '分页',
  `list_order` tinyint(1) unsigned DEFAULT '1' COMMENT '1.id 2.时间3.sort',
  `order_by` tinyint(1) unsigned DEFAULT '1' COMMENT '1 升序 2 降序',
  `cate_content` longtext NOT NULL COMMENT '单页内容',
  `copy` mediumint(9) DEFAULT '0' COMMENT '复制栏目次数',
  `create_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `update_time` int(10) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `cate_pid` (`cate_pid`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_cate
-- ----------------------------
INSERT INTO `lz_cate` (`id`,`cate_name`,`seo_cate`,`cate_keywords`,`cate_desc`,`cate_img`,`pattern_id`,`cate_status`,`cate_pid`,`cate_sort`,`temp_type`,`out_url`,`index_temp`,`list_temp`,`article_temp`,`page`,`list_order`,`order_by`,`cate_content`,`copy`,`create_time`,`update_time`) VALUES ('50','电影栏目','','','','','2','1','0','50','1','','index_article.html','list_article.html','article_article.html','12','2','1',' ','0','1555634165','1555901258');
INSERT INTO `lz_cate` (`id`,`cate_name`,`seo_cate`,`cate_keywords`,`cate_desc`,`cate_img`,`pattern_id`,`cate_status`,`cate_pid`,`cate_sort`,`temp_type`,`out_url`,`index_temp`,`list_temp`,`article_temp`,`page`,`list_order`,`order_by`,`cate_content`,`copy`,`create_time`,`update_time`) VALUES ('51','商城栏目','','','','','3','1','0','50','1','','index_article.html','list_article.html','article_article.html','12','2','1',' ','0','1555634733','1555634733');
INSERT INTO `lz_cate` (`id`,`cate_name`,`seo_cate`,`cate_keywords`,`cate_desc`,`cate_img`,`pattern_id`,`cate_status`,`cate_pid`,`cate_sort`,`temp_type`,`out_url`,`index_temp`,`list_temp`,`article_temp`,`page`,`list_order`,`order_by`,`cate_content`,`copy`,`create_time`,`update_time`) VALUES ('52','新闻栏目','新闻栏目','新闻栏目','','','1','1','0','50','1','','index_article.html','list_article.html','article_article.html','12','2','1',' ','0','1555664696','1555664696');

-- ----------------------------
-- Table structure for lz_config_field
-- ----------------------------
DROP TABLE IF EXISTS `lz_config_field`;
CREATE TABLE `lz_config_field` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cn_name` varchar(30) DEFAULT NULL COMMENT '中文名',
  `en_name` varchar(30) DEFAULT NULL COMMENT '英文名',
  `value` varchar(200) DEFAULT NULL COMMENT '默认值',
  `values` varchar(255) NOT NULL COMMENT '可选值 用于select checkbox',
  `field_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1.输入框2.单选3.复选4.下拉菜单5.文本域6.文件',
  `flexd` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1.可删除，0.不可删除',
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `field_type` (`field_type`),
  KEY `en_name` (`en_name`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_config_field
-- ----------------------------
INSERT INTO `lz_config_field` (`id`,`cn_name`,`en_name`,`value`,`values`,`field_type`,`flexd`,`create_time`) VALUES ('55','网站名称','web_name','网站名称','','1','1','1555310574');
INSERT INTO `lz_config_field` (`id`,`cn_name`,`en_name`,`value`,`values`,`field_type`,`flexd`,`create_time`) VALUES ('65','关键字','keywords','','','1','1','1555319975');
INSERT INTO `lz_config_field` (`id`,`cn_name`,`en_name`,`value`,`values`,`field_type`,`flexd`,`create_time`) VALUES ('66','描述','desc','','','5','1','1555319992');
INSERT INTO `lz_config_field` (`id`,`cn_name`,`en_name`,`value`,`values`,`field_type`,`flexd`,`create_time`) VALUES ('67','网站logo','logo','','','6','1','1555320009');
INSERT INTO `lz_config_field` (`id`,`cn_name`,`en_name`,`value`,`values`,`field_type`,`flexd`,`create_time`) VALUES ('68','备案号','beian','','','1','1','1555320043');
INSERT INTO `lz_config_field` (`id`,`cn_name`,`en_name`,`value`,`values`,`field_type`,`flexd`,`create_time`) VALUES ('69','版权','copy_right','','','1','1','1555320062');
INSERT INTO `lz_config_field` (`id`,`cn_name`,`en_name`,`value`,`values`,`field_type`,`flexd`,`create_time`) VALUES ('70','电话','phone','','','1','1','1555320074');
INSERT INTO `lz_config_field` (`id`,`cn_name`,`en_name`,`value`,`values`,`field_type`,`flexd`,`create_time`) VALUES ('71','地址','address','','','1','1','1555320084');

-- ----------------------------
-- Table structure for lz_movie
-- ----------------------------
DROP TABLE IF EXISTS `lz_movie`;
CREATE TABLE `lz_movie` (
  `art_id` mediumint(9) DEFAULT NULL,
  `movieType` varchar(250) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `cptime` varchar(250) DEFAULT NULL,
  `longtime` varchar(10) DEFAULT NULL,
  `xcbanner` varchar(250) DEFAULT NULL,
  `downpath` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_movie
-- ----------------------------
INSERT INTO `lz_movie` (`art_id`,`movieType`,`company`,`cptime`,`longtime`,`xcbanner`,`downpath`) VALUES ('293','欧美','英国','2019-04-19 08:36:31','50','','www.junxiwangluo.com');
INSERT INTO `lz_movie` (`art_id`,`movieType`,`company`,`cptime`,`longtime`,`xcbanner`,`downpath`) VALUES ('300','大陆','测试数据2222','2019-04-22 09:08:35','80','','');

-- ----------------------------
-- Table structure for lz_movie_field
-- ----------------------------
DROP TABLE IF EXISTS `lz_movie_field`;
CREATE TABLE `lz_movie_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `en_name` varchar(20) DEFAULT NULL,
  `cn_name` varchar(20) DEFAULT NULL,
  `value` text,
  `values` text,
  `length` smallint(6) DEFAULT NULL,
  `sort` mediumint(6) DEFAULT '12',
  `create_time` int(10) DEFAULT NULL,
  `field_type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_movie_field
-- ----------------------------
INSERT INTO `lz_movie_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('1','movieType','影片类型','大陆','大陆,港台,日韩,欧美','250','12','1555573431','2');
INSERT INTO `lz_movie_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('2','company','出品公司','','','100','12','1555573458','1');
INSERT INTO `lz_movie_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('3','cptime','出品时间','','','250','12','1555573478','8');
INSERT INTO `lz_movie_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('4','longtime','影片时长','','','10','12','1555573505','1');
INSERT INTO `lz_movie_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('5','xcbanner','宣传海报','','','250','12','1555573536','6');
INSERT INTO `lz_movie_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('6','downpath','下载地址','','','300','12','1555573581','1');

-- ----------------------------
-- Table structure for lz_news
-- ----------------------------
DROP TABLE IF EXISTS `lz_news`;
CREATE TABLE `lz_news` (
  `art_id` mediumint(9) DEFAULT NULL,
  `auth` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_news
-- ----------------------------
INSERT INTO `lz_news` (`art_id`,`auth`) VALUES ('296','admin');
INSERT INTO `lz_news` (`art_id`,`auth`) VALUES ('302','admin');
INSERT INTO `lz_news` (`art_id`,`auth`) VALUES ('301','admin');
INSERT INTO `lz_news` (`art_id`,`auth`) VALUES ('303','admin');

-- ----------------------------
-- Table structure for lz_news_field
-- ----------------------------
DROP TABLE IF EXISTS `lz_news_field`;
CREATE TABLE `lz_news_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `en_name` varchar(20) DEFAULT NULL,
  `cn_name` varchar(20) DEFAULT NULL,
  `value` text,
  `values` text,
  `length` smallint(6) DEFAULT NULL,
  `sort` mediumint(6) DEFAULT '12',
  `create_time` int(10) DEFAULT NULL,
  `field_type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_news_field
-- ----------------------------
INSERT INTO `lz_news_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('1','auth','作者','admin','','50','12','1555573224','1');

-- ----------------------------
-- Table structure for lz_pattern
-- ----------------------------
DROP TABLE IF EXISTS `lz_pattern`;
CREATE TABLE `lz_pattern` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `table_name` varchar(20) DEFAULT NULL,
  `add_table` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `selected` tinyint(3) DEFAULT '0' COMMENT '1 默认 2 非默认',
  `create_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_pattern
-- ----------------------------
INSERT INTO `lz_pattern` (`id`,`name`,`table_name`,`add_table`,`status`,`selected`,`create_time`) VALUES ('1','新闻模型','news','news_field','1','1','1555573131');
INSERT INTO `lz_pattern` (`id`,`name`,`table_name`,`add_table`,`status`,`selected`,`create_time`) VALUES ('2','电影模型','movie','movie_field','1','0','1555573192');
INSERT INTO `lz_pattern` (`id`,`name`,`table_name`,`add_table`,`status`,`selected`,`create_time`) VALUES ('3','商城模型','shop','shop_field','1','0','1555573723');

-- ----------------------------
-- Table structure for lz_photos
-- ----------------------------
DROP TABLE IF EXISTS `lz_photos`;
CREATE TABLE `lz_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(255) DEFAULT NULL,
  `art_id` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_photos
-- ----------------------------

-- ----------------------------
-- Table structure for lz_shop
-- ----------------------------
DROP TABLE IF EXISTS `lz_shop`;
CREATE TABLE `lz_shop` (
  `art_id` mediumint(9) DEFAULT NULL,
  `productno` varchar(50) DEFAULT NULL,
  `brand` varchar(20) DEFAULT NULL,
  `unit` varchar(250) DEFAULT NULL,
  `weight` varchar(10) DEFAULT NULL,
  `marketprice` varchar(10) DEFAULT NULL,
  `shopprice` varchar(10) DEFAULT NULL,
  `psalenum` varchar(10) DEFAULT NULL,
  `pay` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_shop
-- ----------------------------
INSERT INTO `lz_shop` (`art_id`,`productno`,`brand`,`unit`,`weight`,`marketprice`,`shopprice`,`psalenum`,`pay`) VALUES ('295','asdadasdad123','ash','kg','200','500','800','10000','微信,支付宝,银联,汇款,线下');

-- ----------------------------
-- Table structure for lz_shop_field
-- ----------------------------
DROP TABLE IF EXISTS `lz_shop_field`;
CREATE TABLE `lz_shop_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `en_name` varchar(20) DEFAULT NULL,
  `cn_name` varchar(20) DEFAULT NULL,
  `value` text,
  `values` text,
  `length` smallint(6) DEFAULT NULL,
  `sort` mediumint(6) DEFAULT '12',
  `create_time` int(10) DEFAULT NULL,
  `field_type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_shop_field
-- ----------------------------
INSERT INTO `lz_shop_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('1','productno','商品编号','','','50','12','1555573755','1');
INSERT INTO `lz_shop_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('2','brand','品牌','','','20','12','1555573780','1');
INSERT INTO `lz_shop_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('3','unit','计量单位','kg','k,kg','250','12','1555634989','4');
INSERT INTO `lz_shop_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('4','weight','单位重量','','','10','12','1555573848','1');
INSERT INTO `lz_shop_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('5','marketprice','市场价','','','10','12','1555573921','1');
INSERT INTO `lz_shop_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('6','shopprice','商城价','','','10','12','1555573914','1');
INSERT INTO `lz_shop_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('7','psalenum','销售量','','','10','12','1555573948','1');
INSERT INTO `lz_shop_field` (`id`,`en_name`,`cn_name`,`value`,`values`,`length`,`sort`,`create_time`,`field_type`) VALUES ('8','pay','支付方式','','微信,支付宝,银联,汇款,线下','50','12','1555574017','3');

-- ----------------------------
-- Table structure for lz_system
-- ----------------------------
DROP TABLE IF EXISTS `lz_system`;
CREATE TABLE `lz_system` (
  `id` smallint(6) NOT NULL,
  `image_type` varchar(100) NOT NULL DEFAULT '' COMMENT '图片类型',
  `image_size` int(11) NOT NULL DEFAULT '0' COMMENT '文件大小',
  `file_type` varchar(100) DEFAULT NULL COMMENT '文件类型',
  `file_size` int(11) DEFAULT NULL COMMENT '文件大小',
  `is_code` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0.关闭1.图片水印 2文字水印 ',
  `image_code` varchar(200) NOT NULL COMMENT '图片水印地址',
  `text_code` varchar(50) NOT NULL COMMENT '文字水印信息',
  `code_south` tinyint(4) NOT NULL DEFAULT '1' COMMENT '水印方位',
  `image_issue` int(11) NOT NULL DEFAULT '100' COMMENT '水印透明度',
  `text_color` varchar(20) NOT NULL COMMENT '文字水印颜色',
  `text_size` mediumint(9) NOT NULL COMMENT '文字水印大小',
  `article_order` tinyint(1) DEFAULT '1' COMMENT '1.时间排序 2.自定义排序',
  `order_by` tinyint(1) DEFAULT '1' COMMENT '1.升序2.降序',
  `baidu` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_system
-- ----------------------------
INSERT INTO `lz_system` (`id`,`image_type`,`image_size`,`file_type`,`file_size`,`is_code`,`image_code`,`text_code`,`code_south`,`image_issue`,`text_color`,`text_size`,`article_order`,`order_by`,`baidu`) VALUES ('1','jpg,png,gif','10000000','pdf,docx','5000000','0','uploads/water/20190416/53ef9b047316331a8c0d5094dbd4b7cd.png','Z-CMS','5','100','#7c8d99','15','1','1','Uh3bPqonA9eApDQv');

-- ----------------------------
-- Table structure for lz_user
-- ----------------------------
DROP TABLE IF EXISTS `lz_user`;
CREATE TABLE `lz_user` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `pass` varchar(40) DEFAULT NULL,
  `login_ip` varchar(20) DEFAULT NULL,
  `login_count` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '1' COMMENT '1 正常 0 禁用',
  `create_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of lz_user
-- ----------------------------
INSERT INTO `lz_user` (`id`,`username`,`pass`,`login_ip`,`login_count`,`status`,`create_time`) VALUES ('100','admin','e10adc3949ba59abbe56e057f20f883e','0.0.0.0','0','1','1555049421');

