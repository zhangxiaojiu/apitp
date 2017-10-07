# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.42)
# Database: thinkcmf5
# Generation Time: 2017-10-07 07:56:07 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table cmf_admin_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_admin_menu`;

CREATE TABLE `cmf_admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父菜单id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '菜单类型;1:有界面可访问菜单,2:无界面可访问菜单,0:只作为菜单',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态;1:显示,0:不显示',
  `list_order` float unsigned NOT NULL DEFAULT '10000' COMMENT '排序ID',
  `app` varchar(15) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '应用名',
  `controller` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '控制器名',
  `action` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '操作名称',
  `param` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '额外参数',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '菜单图标',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`parent_id`),
  KEY `model` (`controller`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';

LOCK TABLES `cmf_admin_menu` WRITE;
/*!40000 ALTER TABLE `cmf_admin_menu` DISABLE KEYS */;

INSERT INTO `cmf_admin_menu` (`id`, `parent_id`, `type`, `status`, `list_order`, `app`, `controller`, `action`, `param`, `name`, `icon`, `remark`)
VALUES
	(1,0,0,1,20,'admin','Plugin','default','','插件管理','cloud','插件管理'),
	(2,1,1,1,10000,'admin','Hook','index','','钩子管理','','钩子管理'),
	(3,2,1,0,10000,'admin','Hook','plugins','','钩子插件管理','','钩子插件管理'),
	(4,2,2,0,10000,'admin','Hook','pluginListOrder','','钩子插件排序','','钩子插件排序'),
	(5,0,0,1,0,'admin','Setting','default','','设置','cogs','系统设置入口'),
	(6,5,1,1,50,'admin','Link','index','','友情链接','','友情链接管理'),
	(7,6,1,0,10000,'admin','Link','add','','添加友情链接','','添加友情链接'),
	(8,6,2,0,10000,'admin','Link','addPost','','添加友情链接提交保存','','添加友情链接提交保存'),
	(9,6,1,0,10000,'admin','Link','edit','','编辑友情链接','','编辑友情链接'),
	(10,6,2,0,10000,'admin','Link','editPost','','编辑友情链接提交保存','','编辑友情链接提交保存'),
	(11,6,2,0,10000,'admin','Link','delete','','删除友情链接','','删除友情链接'),
	(12,6,2,0,10000,'admin','Link','listOrder','','友情链接排序','','友情链接排序'),
	(13,6,2,0,10000,'admin','Link','toggle','','友情链接显示隐藏','','友情链接显示隐藏'),
	(14,5,1,1,10,'admin','Mailer','index','','邮箱配置','','邮箱配置'),
	(15,14,2,0,10000,'admin','Mailer','indexPost','','邮箱配置提交保存','','邮箱配置提交保存'),
	(16,14,1,0,10000,'admin','Mailer','template','','邮件模板','','邮件模板'),
	(17,14,2,0,10000,'admin','Mailer','templatePost','','邮件模板提交','','邮件模板提交'),
	(18,14,1,0,10000,'admin','Mailer','test','','邮件发送测试','','邮件发送测试'),
	(19,5,1,0,10000,'admin','Menu','index','','后台菜单','','后台菜单管理'),
	(20,19,1,0,10000,'admin','Menu','lists','','所有菜单','','后台所有菜单列表'),
	(21,19,1,0,10000,'admin','Menu','add','','后台菜单添加','','后台菜单添加'),
	(22,19,2,0,10000,'admin','Menu','addPost','','后台菜单添加提交保存','','后台菜单添加提交保存'),
	(23,19,1,0,10000,'admin','Menu','edit','','后台菜单编辑','','后台菜单编辑'),
	(24,19,2,0,10000,'admin','Menu','editPost','','后台菜单编辑提交保存','','后台菜单编辑提交保存'),
	(25,19,2,0,10000,'admin','Menu','delete','','后台菜单删除','','后台菜单删除'),
	(26,19,2,0,10000,'admin','Menu','listOrder','','后台菜单排序','','后台菜单排序'),
	(27,19,1,0,10000,'admin','Menu','getActions','','导入新后台菜单','','导入新后台菜单'),
	(28,5,1,1,30,'admin','Nav','index','','导航管理','','导航管理'),
	(29,28,1,0,10000,'admin','Nav','add','','添加导航','','添加导航'),
	(30,28,2,0,10000,'admin','Nav','addPost','','添加导航提交保存','','添加导航提交保存'),
	(31,28,1,0,10000,'admin','Nav','edit','','编辑导航','','编辑导航'),
	(32,28,2,0,10000,'admin','Nav','editPost','','编辑导航提交保存','','编辑导航提交保存'),
	(33,28,2,0,10000,'admin','Nav','delete','','删除导航','','删除导航'),
	(34,28,1,0,10000,'admin','NavMenu','index','','导航菜单','','导航菜单'),
	(35,34,1,0,10000,'admin','NavMenu','add','','添加导航菜单','','添加导航菜单'),
	(36,34,2,0,10000,'admin','NavMenu','addPost','','添加导航菜单提交保存','','添加导航菜单提交保存'),
	(37,34,1,0,10000,'admin','NavMenu','edit','','编辑导航菜单','','编辑导航菜单'),
	(38,34,2,0,10000,'admin','NavMenu','editPost','','编辑导航菜单提交保存','','编辑导航菜单提交保存'),
	(39,34,2,0,10000,'admin','NavMenu','delete','','删除导航菜单','','删除导航菜单'),
	(40,34,2,0,10000,'admin','NavMenu','listOrder','','导航菜单排序','','导航菜单排序'),
	(41,1,1,1,10000,'admin','Plugin','index','','插件列表','','插件列表'),
	(42,41,2,0,10000,'admin','Plugin','toggle','','插件启用禁用','','插件启用禁用'),
	(43,41,1,0,10000,'admin','Plugin','setting','','插件设置','','插件设置'),
	(44,41,2,0,10000,'admin','Plugin','settingPost','','插件设置提交','','插件设置提交'),
	(45,41,2,0,10000,'admin','Plugin','install','','插件安装','','插件安装'),
	(46,41,2,0,10000,'admin','Plugin','update','','插件更新','','插件更新'),
	(47,41,2,0,10000,'admin','Plugin','uninstall','','卸载插件','','卸载插件'),
	(48,108,0,1,10000,'admin','User','default','','管理组','','管理组'),
	(49,48,1,1,10000,'admin','Rbac','index','','角色管理','','角色管理'),
	(50,49,1,0,10000,'admin','Rbac','roleAdd','','添加角色','','添加角色'),
	(51,49,2,0,10000,'admin','Rbac','roleAddPost','','添加角色提交','','添加角色提交'),
	(52,49,1,0,10000,'admin','Rbac','roleEdit','','编辑角色','','编辑角色'),
	(53,49,2,0,10000,'admin','Rbac','roleEditPost','','编辑角色提交','','编辑角色提交'),
	(54,49,2,0,10000,'admin','Rbac','roleDelete','','删除角色','','删除角色'),
	(55,49,1,0,10000,'admin','Rbac','authorize','','设置角色权限','','设置角色权限'),
	(56,49,2,0,10000,'admin','Rbac','authorizePost','','角色授权提交','','角色授权提交'),
	(57,0,1,0,10000,'admin','RecycleBin','index','','回收站','','回收站'),
	(58,57,2,0,10000,'admin','RecycleBin','restore','','回收站还原','','回收站还原'),
	(59,57,2,0,10000,'admin','RecycleBin','delete','','回收站彻底删除','','回收站彻底删除'),
	(60,5,1,1,10000,'admin','Route','index','','URL美化','','URL规则管理'),
	(61,60,1,0,10000,'admin','Route','add','','添加路由规则','','添加路由规则'),
	(62,60,2,0,10000,'admin','Route','addPost','','添加路由规则提交','','添加路由规则提交'),
	(63,60,1,0,10000,'admin','Route','edit','','路由规则编辑','','路由规则编辑'),
	(64,60,2,0,10000,'admin','Route','editPost','','路由规则编辑提交','','路由规则编辑提交'),
	(65,60,2,0,10000,'admin','Route','delete','','路由规则删除','','路由规则删除'),
	(66,60,2,0,10000,'admin','Route','ban','','路由规则禁用','','路由规则禁用'),
	(67,60,2,0,10000,'admin','Route','open','','路由规则启用','','路由规则启用'),
	(68,60,2,0,10000,'admin','Route','listOrder','','路由规则排序','','路由规则排序'),
	(69,60,1,0,10000,'admin','Route','select','','选择URL','','选择URL'),
	(70,5,1,1,0,'admin','Setting','site','','网站信息','','网站信息'),
	(71,70,2,0,10000,'admin','Setting','sitePost','','网站信息设置提交','','网站信息设置提交'),
	(72,5,1,0,10000,'admin','Setting','password','','密码修改','','密码修改'),
	(73,72,2,0,10000,'admin','Setting','passwordPost','','密码修改提交','','密码修改提交'),
	(74,5,1,1,10000,'admin','Setting','upload','','上传设置','','上传设置'),
	(75,74,2,0,10000,'admin','Setting','uploadPost','','上传设置提交','','上传设置提交'),
	(76,5,1,0,10000,'admin','Setting','clearCache','','清除缓存','','清除缓存'),
	(77,5,1,1,40,'admin','Slide','index','','幻灯片管理','','幻灯片管理'),
	(78,77,1,0,10000,'admin','Slide','add','','添加幻灯片','','添加幻灯片'),
	(79,77,2,0,10000,'admin','Slide','addPost','','添加幻灯片提交','','添加幻灯片提交'),
	(80,77,1,0,10000,'admin','Slide','edit','','编辑幻灯片','','编辑幻灯片'),
	(81,77,2,0,10000,'admin','Slide','editPost','','编辑幻灯片提交','','编辑幻灯片提交'),
	(82,77,2,0,10000,'admin','Slide','delete','','删除幻灯片','','删除幻灯片'),
	(83,77,1,0,10000,'admin','SlideItem','index','','幻灯片页面列表','','幻灯片页面列表'),
	(84,83,1,0,10000,'admin','SlideItem','add','','幻灯片页面添加','','幻灯片页面添加'),
	(85,83,2,0,10000,'admin','SlideItem','addPost','','幻灯片页面添加提交','','幻灯片页面添加提交'),
	(86,83,1,0,10000,'admin','SlideItem','edit','','幻灯片页面编辑','','幻灯片页面编辑'),
	(87,83,2,0,10000,'admin','SlideItem','editPost','','幻灯片页面编辑提交','','幻灯片页面编辑提交'),
	(88,83,2,0,10000,'admin','SlideItem','delete','','幻灯片页面删除','','幻灯片页面删除'),
	(89,83,2,0,10000,'admin','SlideItem','ban','','幻灯片页面隐藏','','幻灯片页面隐藏'),
	(90,83,2,0,10000,'admin','SlideItem','cancelBan','','幻灯片页面显示','','幻灯片页面显示'),
	(91,83,2,0,10000,'admin','SlideItem','listOrder','','幻灯片页面排序','','幻灯片页面排序'),
	(92,5,1,1,10000,'admin','Storage','index','','文件存储','','文件存储'),
	(93,92,2,0,10000,'admin','Storage','settingPost','','文件存储设置提交','','文件存储设置提交'),
	(94,5,1,1,20,'admin','Theme','index','','模板管理','','模板管理'),
	(95,94,1,0,10000,'admin','Theme','install','','安装模板','','安装模板'),
	(96,94,2,0,10000,'admin','Theme','uninstall','','卸载模板','','卸载模板'),
	(97,94,2,0,10000,'admin','Theme','installTheme','','模板安装','','模板安装'),
	(98,94,2,0,10000,'admin','Theme','update','','模板更新','','模板更新'),
	(99,94,2,0,10000,'admin','Theme','active','','启用模板','','启用模板'),
	(100,94,1,0,10000,'admin','Theme','files','','模板文件列表','','启用模板'),
	(101,94,1,0,10000,'admin','Theme','fileSetting','','模板文件设置','','模板文件设置'),
	(102,94,1,0,10000,'admin','Theme','fileArrayData','','模板文件数组数据列表','','模板文件数组数据列表'),
	(103,94,2,0,10000,'admin','Theme','fileArrayDataEdit','','模板文件数组数据添加编辑','','模板文件数组数据添加编辑'),
	(104,94,2,0,10000,'admin','Theme','fileArrayDataEditPost','','模板文件数组数据添加编辑提交保存','','模板文件数组数据添加编辑提交保存'),
	(105,94,2,0,10000,'admin','Theme','fileArrayDataDelete','','模板文件数组数据删除','','模板文件数组数据删除'),
	(106,94,2,0,10000,'admin','Theme','settingPost','','模板文件编辑提交保存','','模板文件编辑提交保存'),
	(107,94,1,0,10000,'admin','Theme','dataSource','','模板文件设置数据源','','模板文件设置数据源'),
	(108,0,0,1,10,'user','AdminIndex','default','','用户管理','group','用户管理'),
	(109,48,1,1,10000,'admin','User','index','','管理员','','代理商管理'),
	(110,109,1,0,10000,'admin','User','add','','管理员添加','','管理员添加'),
	(111,109,2,0,10000,'admin','User','addPost','','管理员添加提交','','管理员添加提交'),
	(112,109,1,0,10000,'admin','User','edit','','管理员编辑','','管理员编辑'),
	(113,109,2,0,10000,'admin','User','editPost','','管理员编辑提交','','管理员编辑提交'),
	(114,5,1,1,10000,'admin','User','userInfo','','个人信息','','管理员个人信息修改'),
	(115,5,1,0,10000,'admin','User','userInfoPost','','管理员个人信息修改提交','','管理员个人信息修改提交'),
	(116,109,2,0,10000,'admin','User','delete','','管理员删除','','管理员删除'),
	(117,109,2,0,10000,'admin','User','ban','','停用管理员','','停用管理员'),
	(118,109,2,0,10000,'admin','User','cancelBan','','启用管理员','','启用管理员'),
	(119,0,0,1,30,'portal','AdminIndex','default','','门户管理','th','门户管理'),
	(120,119,1,1,10000,'portal','AdminArticle','index','','文章管理','','文章列表'),
	(121,120,1,0,10000,'portal','AdminArticle','add','','添加文章','','添加文章'),
	(122,120,2,0,10000,'portal','AdminArticle','addPost','','添加文章提交','','添加文章提交'),
	(123,120,1,0,10000,'portal','AdminArticle','edit','','编辑文章','','编辑文章'),
	(124,120,2,0,10000,'portal','AdminArticle','editPost','','编辑文章提交','','编辑文章提交'),
	(125,120,2,0,10000,'portal','AdminArticle','delete','','文章删除','','文章删除'),
	(126,120,2,0,10000,'portal','AdminArticle','publish','','文章发布','','文章发布'),
	(127,120,2,0,10000,'portal','AdminArticle','top','','文章置顶','','文章置顶'),
	(128,120,2,0,10000,'portal','AdminArticle','recommend','','文章推荐','','文章推荐'),
	(129,120,2,0,10000,'portal','AdminArticle','listOrder','','文章排序','','文章排序'),
	(130,119,1,1,10000,'portal','AdminCategory','index','','分类管理','','文章分类列表'),
	(131,130,1,0,10000,'portal','AdminCategory','add','','添加文章分类','','添加文章分类'),
	(132,130,2,0,10000,'portal','AdminCategory','addPost','','添加文章分类提交','','添加文章分类提交'),
	(133,130,1,0,10000,'portal','AdminCategory','edit','','编辑文章分类','','编辑文章分类'),
	(134,130,2,0,10000,'portal','AdminCategory','editPost','','编辑文章分类提交','','编辑文章分类提交'),
	(135,130,1,0,10000,'portal','AdminCategory','select','','文章分类选择对话框','','文章分类选择对话框'),
	(136,130,2,0,10000,'portal','AdminCategory','listOrder','','文章分类排序','','文章分类排序'),
	(137,130,2,0,10000,'portal','AdminCategory','delete','','删除文章分类','','删除文章分类'),
	(138,119,1,1,10000,'portal','AdminPage','index','','页面管理','','页面管理'),
	(139,138,1,0,10000,'portal','AdminPage','add','','添加页面','','添加页面'),
	(140,138,2,0,10000,'portal','AdminPage','addPost','','添加页面提交','','添加页面提交'),
	(141,138,1,0,10000,'portal','AdminPage','edit','','编辑页面','','编辑页面'),
	(142,138,2,0,10000,'portal','AdminPage','editPost','','编辑页面提交','','编辑页面提交'),
	(143,138,2,0,10000,'portal','AdminPage','delete','','删除页面','','删除页面'),
	(144,119,1,1,10000,'portal','AdminTag','index','','文章标签','','文章标签'),
	(145,144,1,0,10000,'portal','AdminTag','add','','添加文章标签','','添加文章标签'),
	(146,144,2,0,10000,'portal','AdminTag','addPost','','添加文章标签提交','','添加文章标签提交'),
	(147,144,2,0,10000,'portal','AdminTag','upStatus','','更新标签状态','','更新标签状态'),
	(148,144,2,0,10000,'portal','AdminTag','delete','','删除文章标签','','删除文章标签'),
	(149,0,1,0,10000,'user','AdminAsset','index','','资源管理','file','资源管理列表'),
	(150,149,2,0,10000,'user','AdminAsset','delete','','删除文件','','删除文件'),
	(151,108,0,1,10000,'user','AdminIndex','default1','','用户组','','用户组'),
	(152,151,1,1,10000,'user','AdminIndex','index','','用户列表','','本站用户'),
	(153,152,2,0,10000,'user','AdminIndex','ban','','本站用户拉黑','','本站用户拉黑'),
	(154,152,2,0,10000,'user','AdminIndex','cancelBan','','本站用户启用','','本站用户启用'),
	(155,151,1,0,10000,'user','AdminOauth','index','','第三方用户','','第三方用户'),
	(156,155,2,0,10000,'user','AdminOauth','delete','','删除第三方用户绑定','','删除第三方用户绑定'),
	(157,119,1,1,10000,'admin','Contacts','index','','留言联系人','','留言联系人列表'),
	(158,5,1,1,10000,'user','AdminUserAction','index','','用户操作管理','','用户操作管理'),
	(159,157,1,0,10000,'admin','Contacts','delete','','删除留言联系人','',''),
	(160,151,1,1,10000,'user','AdminIndex','txList','','提现记录','',''),
	(161,0,0,1,10000,'user','AdminPos','default','','产品管理','',''),
	(162,161,1,1,10000,'user','AdminPos','index','','POS列表','',''),
	(163,161,1,1,9999,'user','AdminPos','posRequest','','申请列表','',''),
	(164,5,1,1,1,'admin','Setting','coin','','奖金设置','',''),
	(165,0,0,1,10000,'user','AdminDeal','default','','交易管理','bars',''),
	(166,165,1,1,10000,'user','AdminDeal','index','','交易记录','',''),
	(167,165,1,1,10000,'user','AdminDeal','add','','导入记录','',''),
	(168,165,1,1,10000,'user','AdminDeal','total','','交易统计','',''),
	(169,5,1,1,10000,'admin','User','coin','','余额信息','','');

/*!40000 ALTER TABLE `cmf_admin_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_asset
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_asset`;

CREATE TABLE `cmf_asset` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `file_size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小,单位B',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:可用,0:不可用',
  `download_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `file_key` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '文件惟一码',
  `filename` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件名',
  `file_path` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '文件路径,相对于upload目录,可以为url',
  `file_md5` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '文件md5值',
  `file_sha1` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `suffix` varchar(10) NOT NULL DEFAULT '' COMMENT '文件后缀名,不包括点',
  `more` text COMMENT '其它详细信息,JSON格式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='资源表';

LOCK TABLES `cmf_asset` WRITE;
/*!40000 ALTER TABLE `cmf_asset` DISABLE KEYS */;

INSERT INTO `cmf_asset` (`id`, `user_id`, `file_size`, `create_time`, `status`, `download_times`, `file_key`, `filename`, `file_path`, `file_md5`, `file_sha1`, `suffix`, `more`)
VALUES
	(5,1,91907,1500891373,1,0,'f3a9e8c73b9b78f9dfacc92bd037350bc2e5eb8e7c909a9001231d0584802162','WechatIMG58.jpeg','20170724/c5fb5e3cc9fd29aba9d71429e7786da4.jpeg','f3a9e8c73b9b78f9dfacc92bd037350b','697511977f49a1eafdd96d08fc11a58c0be3e923','jpeg',NULL),
	(6,1,84670,1500984042,1,0,'e80c44c9140b72d92bfb5ecba040676039f77ff1ceb45cd59d6dde283bbded37','proskb1.png','portal/20170725/a165af65bc5f159cac2dcbbe771d40b2.png','e80c44c9140b72d92bfb5ecba0406760','9d4bedecedd28f76a0376564925ff7f510aca166','png',NULL),
	(7,1,150948,1500984648,1,0,'96fe4e40288a0ca25eee6d1675cd9fa7b4566a2e010191b5e69d070d5a49702f','d+0text.jpg','portal/20170725/ee552e16d0fd2e21bfc4a47199f95011.jpg','96fe4e40288a0ca25eee6d1675cd9fa7','e3c14e905d2d31aa71cfaf5af471c80fe2aa1d2f','jpg',NULL),
	(8,1,92507,1500988044,1,0,'44da30546c04e4981bfc2b2eb610d6716bc1f3ba7f04c26aa92c78b8a24d8fb1','feilv.jpg','portal/20170725/4dd5a265c898176fd6f83c20f9aaff1e.jpg','44da30546c04e4981bfc2b2eb610d671','e96e54b83974947c86de8901ea2446807007710b','jpg',NULL),
	(9,1,11943,1500988939,1,0,'19f2ee4053f0587c7fb934599b8f32f6e7f429b42c99cb971742f77da986ce3a','logo.png','portal/20170725/2483bd4e937265b4d74a940415c36656.png','19f2ee4053f0587c7fb934599b8f32f6','8bc56eb510136ff8836ddac720e1f31daf39038f','png',NULL);

/*!40000 ALTER TABLE `cmf_asset` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_auth_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_auth_access`;

CREATE TABLE `cmf_auth_access` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL COMMENT '角色',
  `rule_name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '权限规则分类,请加应用前缀,如admin_',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `rule_name` (`rule_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限授权表';

LOCK TABLES `cmf_auth_access` WRITE;
/*!40000 ALTER TABLE `cmf_auth_access` DISABLE KEYS */;

INSERT INTO `cmf_auth_access` (`id`, `role_id`, `rule_name`, `type`)
VALUES
	(201,2,'admin/setting/default','admin_url'),
	(202,2,'admin/setting/password','admin_url'),
	(203,2,'admin/setting/passwordpost','admin_url'),
	(204,2,'admin/user/userinfo','admin_url'),
	(205,2,'admin/user/userinfopost','admin_url'),
	(206,2,'admin/user/coin','admin_url'),
	(207,2,'user/admindeal/default','admin_url'),
	(208,2,'user/admindeal/index','admin_url'),
	(209,2,'user/admindeal/total','admin_url');

/*!40000 ALTER TABLE `cmf_auth_access` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_auth_rule
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_auth_rule`;

CREATE TABLE `cmf_auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `app` varchar(15) NOT NULL COMMENT '规则所属module',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '权限规则分类，请加应用前缀,如admin_',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `param` varchar(100) NOT NULL DEFAULT '' COMMENT '额外url参数',
  `title` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规则描述',
  `condition` varchar(200) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `module` (`app`,`status`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限规则表';

LOCK TABLES `cmf_auth_rule` WRITE;
/*!40000 ALTER TABLE `cmf_auth_rule` DISABLE KEYS */;

INSERT INTO `cmf_auth_rule` (`id`, `status`, `app`, `type`, `name`, `param`, `title`, `condition`)
VALUES
	(1,1,'admin','admin_url','admin/Hook/index','','钩子管理',''),
	(2,1,'admin','admin_url','admin/Hook/plugins','','钩子插件管理',''),
	(3,1,'admin','admin_url','admin/Hook/pluginListOrder','','钩子插件排序',''),
	(4,1,'admin','admin_url','admin/Link/index','','友情链接',''),
	(5,1,'admin','admin_url','admin/Link/add','','添加友情链接',''),
	(6,1,'admin','admin_url','admin/Link/addPost','','添加友情链接提交保存',''),
	(7,1,'admin','admin_url','admin/Link/edit','','编辑友情链接',''),
	(8,1,'admin','admin_url','admin/Link/editPost','','编辑友情链接提交保存',''),
	(9,1,'admin','admin_url','admin/Link/delete','','删除友情链接',''),
	(10,1,'admin','admin_url','admin/Link/listOrder','','友情链接排序',''),
	(11,1,'admin','admin_url','admin/Link/toggle','','友情链接显示隐藏',''),
	(12,1,'admin','admin_url','admin/Mailer/index','','邮箱配置',''),
	(13,1,'admin','admin_url','admin/Mailer/indexPost','','邮箱配置提交保存',''),
	(14,1,'admin','admin_url','admin/Mailer/template','','邮件模板',''),
	(15,1,'admin','admin_url','admin/Mailer/templatePost','','邮件模板提交',''),
	(16,1,'admin','admin_url','admin/Mailer/test','','邮件发送测试',''),
	(17,1,'admin','admin_url','admin/Menu/index','','后台菜单',''),
	(18,1,'admin','admin_url','admin/Menu/lists','','所有菜单',''),
	(19,1,'admin','admin_url','admin/Menu/add','','后台菜单添加',''),
	(20,1,'admin','admin_url','admin/Menu/addPost','','后台菜单添加提交保存',''),
	(21,1,'admin','admin_url','admin/Menu/edit','','后台菜单编辑',''),
	(22,1,'admin','admin_url','admin/Menu/editPost','','后台菜单编辑提交保存',''),
	(23,1,'admin','admin_url','admin/Menu/delete','','后台菜单删除',''),
	(24,1,'admin','admin_url','admin/Menu/listOrder','','后台菜单排序',''),
	(25,1,'admin','admin_url','admin/Menu/getActions','','导入新后台菜单',''),
	(26,1,'admin','admin_url','admin/Nav/index','','导航管理',''),
	(27,1,'admin','admin_url','admin/Nav/add','','添加导航',''),
	(28,1,'admin','admin_url','admin/Nav/addPost','','添加导航提交保存',''),
	(29,1,'admin','admin_url','admin/Nav/edit','','编辑导航',''),
	(30,1,'admin','admin_url','admin/Nav/editPost','','编辑导航提交保存',''),
	(31,1,'admin','admin_url','admin/Nav/delete','','删除导航',''),
	(32,1,'admin','admin_url','admin/NavMenu/index','','导航菜单',''),
	(33,1,'admin','admin_url','admin/NavMenu/add','','添加导航菜单',''),
	(34,1,'admin','admin_url','admin/NavMenu/addPost','','添加导航菜单提交保存',''),
	(35,1,'admin','admin_url','admin/NavMenu/edit','','编辑导航菜单',''),
	(36,1,'admin','admin_url','admin/NavMenu/editPost','','编辑导航菜单提交保存',''),
	(37,1,'admin','admin_url','admin/NavMenu/delete','','删除导航菜单',''),
	(38,1,'admin','admin_url','admin/NavMenu/listOrder','','导航菜单排序',''),
	(39,1,'admin','admin_url','admin/Plugin/default','','插件管理',''),
	(40,1,'admin','admin_url','admin/Plugin/index','','插件列表',''),
	(41,1,'admin','admin_url','admin/Plugin/toggle','','插件启用禁用',''),
	(42,1,'admin','admin_url','admin/Plugin/setting','','插件设置',''),
	(43,1,'admin','admin_url','admin/Plugin/settingPost','','插件设置提交',''),
	(44,1,'admin','admin_url','admin/Plugin/install','','插件安装',''),
	(45,1,'admin','admin_url','admin/Plugin/update','','插件更新',''),
	(46,1,'admin','admin_url','admin/Plugin/uninstall','','卸载插件',''),
	(47,1,'admin','admin_url','admin/Rbac/index','','角色管理',''),
	(48,1,'admin','admin_url','admin/Rbac/roleAdd','','添加角色',''),
	(49,1,'admin','admin_url','admin/Rbac/roleAddPost','','添加角色提交',''),
	(50,1,'admin','admin_url','admin/Rbac/roleEdit','','编辑角色',''),
	(51,1,'admin','admin_url','admin/Rbac/roleEditPost','','编辑角色提交',''),
	(52,1,'admin','admin_url','admin/Rbac/roleDelete','','删除角色',''),
	(53,1,'admin','admin_url','admin/Rbac/authorize','','设置角色权限',''),
	(54,1,'admin','admin_url','admin/Rbac/authorizePost','','角色授权提交',''),
	(55,1,'admin','admin_url','admin/RecycleBin/index','','回收站',''),
	(56,1,'admin','admin_url','admin/RecycleBin/restore','','回收站还原',''),
	(57,1,'admin','admin_url','admin/RecycleBin/delete','','回收站彻底删除',''),
	(58,1,'admin','admin_url','admin/Route/index','','URL美化',''),
	(59,1,'admin','admin_url','admin/Route/add','','添加路由规则',''),
	(60,1,'admin','admin_url','admin/Route/addPost','','添加路由规则提交',''),
	(61,1,'admin','admin_url','admin/Route/edit','','路由规则编辑',''),
	(62,1,'admin','admin_url','admin/Route/editPost','','路由规则编辑提交',''),
	(63,1,'admin','admin_url','admin/Route/delete','','路由规则删除',''),
	(64,1,'admin','admin_url','admin/Route/ban','','路由规则禁用',''),
	(65,1,'admin','admin_url','admin/Route/open','','路由规则启用',''),
	(66,1,'admin','admin_url','admin/Route/listOrder','','路由规则排序',''),
	(67,1,'admin','admin_url','admin/Route/select','','选择URL',''),
	(68,1,'admin','admin_url','admin/Setting/default','','设置',''),
	(69,1,'admin','admin_url','admin/Setting/site','','网站信息',''),
	(70,1,'admin','admin_url','admin/Setting/sitePost','','网站信息设置提交',''),
	(71,1,'admin','admin_url','admin/Setting/password','','密码修改',''),
	(72,1,'admin','admin_url','admin/Setting/passwordPost','','密码修改提交',''),
	(73,1,'admin','admin_url','admin/Setting/upload','','上传设置',''),
	(74,1,'admin','admin_url','admin/Setting/uploadPost','','上传设置提交',''),
	(75,1,'admin','admin_url','admin/Setting/clearCache','','清除缓存',''),
	(76,1,'admin','admin_url','admin/Slide/index','','幻灯片管理',''),
	(77,1,'admin','admin_url','admin/Slide/add','','添加幻灯片',''),
	(78,1,'admin','admin_url','admin/Slide/addPost','','添加幻灯片提交',''),
	(79,1,'admin','admin_url','admin/Slide/edit','','编辑幻灯片',''),
	(80,1,'admin','admin_url','admin/Slide/editPost','','编辑幻灯片提交',''),
	(81,1,'admin','admin_url','admin/Slide/delete','','删除幻灯片',''),
	(82,1,'admin','admin_url','admin/SlideItem/index','','幻灯片页面列表',''),
	(83,1,'admin','admin_url','admin/SlideItem/add','','幻灯片页面添加',''),
	(84,1,'admin','admin_url','admin/SlideItem/addPost','','幻灯片页面添加提交',''),
	(85,1,'admin','admin_url','admin/SlideItem/edit','','幻灯片页面编辑',''),
	(86,1,'admin','admin_url','admin/SlideItem/editPost','','幻灯片页面编辑提交',''),
	(87,1,'admin','admin_url','admin/SlideItem/delete','','幻灯片页面删除',''),
	(88,1,'admin','admin_url','admin/SlideItem/ban','','幻灯片页面隐藏',''),
	(89,1,'admin','admin_url','admin/SlideItem/cancelBan','','幻灯片页面显示',''),
	(90,1,'admin','admin_url','admin/SlideItem/listOrder','','幻灯片页面排序',''),
	(91,1,'admin','admin_url','admin/Storage/index','','文件存储',''),
	(92,1,'admin','admin_url','admin/Storage/settingPost','','文件存储设置提交',''),
	(93,1,'admin','admin_url','admin/Theme/index','','模板管理',''),
	(94,1,'admin','admin_url','admin/Theme/install','','安装模板',''),
	(95,1,'admin','admin_url','admin/Theme/uninstall','','卸载模板',''),
	(96,1,'admin','admin_url','admin/Theme/installTheme','','模板安装',''),
	(97,1,'admin','admin_url','admin/Theme/update','','模板更新',''),
	(98,1,'admin','admin_url','admin/Theme/active','','启用模板',''),
	(99,1,'admin','admin_url','admin/Theme/files','','模板文件列表',''),
	(100,1,'admin','admin_url','admin/Theme/fileSetting','','模板文件设置',''),
	(101,1,'admin','admin_url','admin/Theme/fileArrayData','','模板文件数组数据列表',''),
	(102,1,'admin','admin_url','admin/Theme/fileArrayDataEdit','','模板文件数组数据添加编辑',''),
	(103,1,'admin','admin_url','admin/Theme/fileArrayDataEditPost','','模板文件数组数据添加编辑提交保存',''),
	(104,1,'admin','admin_url','admin/Theme/fileArrayDataDelete','','模板文件数组数据删除',''),
	(105,1,'admin','admin_url','admin/Theme/settingPost','','模板文件编辑提交保存',''),
	(106,1,'admin','admin_url','admin/Theme/dataSource','','模板文件设置数据源',''),
	(107,1,'admin','admin_url','admin/User/default','','管理组',''),
	(108,1,'admin','admin_url','admin/User/index','','管理员',''),
	(109,1,'admin','admin_url','admin/User/add','','管理员添加',''),
	(110,1,'admin','admin_url','admin/User/addPost','','管理员添加提交',''),
	(111,1,'admin','admin_url','admin/User/edit','','管理员编辑',''),
	(112,1,'admin','admin_url','admin/User/editPost','','管理员编辑提交',''),
	(113,1,'admin','admin_url','admin/User/userInfo','','个人信息',''),
	(114,1,'admin','admin_url','admin/User/userInfoPost','','管理员个人信息修改提交',''),
	(115,1,'admin','admin_url','admin/User/delete','','管理员删除',''),
	(116,1,'admin','admin_url','admin/User/ban','','停用管理员',''),
	(117,1,'admin','admin_url','admin/User/cancelBan','','启用管理员',''),
	(118,1,'portal','admin_url','portal/AdminArticle/index','','文章管理',''),
	(119,1,'portal','admin_url','portal/AdminArticle/add','','添加文章',''),
	(120,1,'portal','admin_url','portal/AdminArticle/addPost','','添加文章提交',''),
	(121,1,'portal','admin_url','portal/AdminArticle/edit','','编辑文章',''),
	(122,1,'portal','admin_url','portal/AdminArticle/editPost','','编辑文章提交',''),
	(123,1,'portal','admin_url','portal/AdminArticle/delete','','文章删除',''),
	(124,1,'portal','admin_url','portal/AdminArticle/publish','','文章发布',''),
	(125,1,'portal','admin_url','portal/AdminArticle/top','','文章置顶',''),
	(126,1,'portal','admin_url','portal/AdminArticle/recommend','','文章推荐',''),
	(127,1,'portal','admin_url','portal/AdminArticle/listOrder','','文章排序',''),
	(128,1,'portal','admin_url','portal/AdminCategory/index','','分类管理',''),
	(129,1,'portal','admin_url','portal/AdminCategory/add','','添加文章分类',''),
	(130,1,'portal','admin_url','portal/AdminCategory/addPost','','添加文章分类提交',''),
	(131,1,'portal','admin_url','portal/AdminCategory/edit','','编辑文章分类',''),
	(132,1,'portal','admin_url','portal/AdminCategory/editPost','','编辑文章分类提交',''),
	(133,1,'portal','admin_url','portal/AdminCategory/select','','文章分类选择对话框',''),
	(134,1,'portal','admin_url','portal/AdminCategory/listOrder','','文章分类排序',''),
	(135,1,'portal','admin_url','portal/AdminCategory/delete','','删除文章分类',''),
	(136,1,'portal','admin_url','portal/AdminIndex/default','','门户管理',''),
	(137,1,'portal','admin_url','portal/AdminPage/index','','页面管理',''),
	(138,1,'portal','admin_url','portal/AdminPage/add','','添加页面',''),
	(139,1,'portal','admin_url','portal/AdminPage/addPost','','添加页面提交',''),
	(140,1,'portal','admin_url','portal/AdminPage/edit','','编辑页面',''),
	(141,1,'portal','admin_url','portal/AdminPage/editPost','','编辑页面提交',''),
	(142,1,'portal','admin_url','portal/AdminPage/delete','','删除页面',''),
	(143,1,'portal','admin_url','portal/AdminTag/index','','文章标签',''),
	(144,1,'portal','admin_url','portal/AdminTag/add','','添加文章标签',''),
	(145,1,'portal','admin_url','portal/AdminTag/addPost','','添加文章标签提交',''),
	(146,1,'portal','admin_url','portal/AdminTag/upStatus','','更新标签状态',''),
	(147,1,'portal','admin_url','portal/AdminTag/delete','','删除文章标签',''),
	(148,1,'user','admin_url','user/AdminAsset/index','','资源管理',''),
	(149,1,'user','admin_url','user/AdminAsset/delete','','删除文件',''),
	(150,1,'user','admin_url','user/AdminIndex/default','','用户管理',''),
	(151,1,'user','admin_url','user/AdminIndex/default1','','用户组',''),
	(152,1,'user','admin_url','user/AdminIndex/index','','用户列表',''),
	(153,1,'user','admin_url','user/AdminIndex/ban','','本站用户拉黑',''),
	(154,1,'user','admin_url','user/AdminIndex/cancelBan','','本站用户启用',''),
	(155,1,'user','admin_url','user/AdminOauth/index','','第三方用户',''),
	(156,1,'user','admin_url','user/AdminOauth/delete','','删除第三方用户绑定',''),
	(157,1,'admin','admin_url','admin/Contacts/index','','留言联系人',''),
	(158,1,'user','admin_url','user/AdminUserAction/index','','用户操作管理',''),
	(159,1,'admin','admin_url','admin/Contacts/delete','','删除留言联系人',''),
	(160,1,'user','admin_url','user/AdminIndex/txList','','提现记录',''),
	(161,1,'user','admin_url','user/AdminPos/default','','产品管理',''),
	(162,1,'user','admin_url','user/AdminPos/index','','POS列表',''),
	(163,1,'user','admin_url','user/AdminPos/posRequest','','申请列表',''),
	(164,1,'admin','admin_url','admin/Setting/coin','','奖金设置',''),
	(165,1,'user','admin_url','user/AdminDeal/default','','交易管理',''),
	(166,1,'user','admin_url','user/AdminDeal/index','','交易记录',''),
	(167,1,'user','admin_url','user/AdminDeal/add','','导入记录',''),
	(168,1,'user','admin_url','user/AdminDeal/total','','交易统计',''),
	(169,1,'admin','admin_url','admin/User/coin','','余额信息','');

/*!40000 ALTER TABLE `cmf_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_coin_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_coin_log`;

CREATE TABLE `cmf_coin_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `coin` int(10) NOT NULL DEFAULT '0' COMMENT '金额',
  `type` char(15) NOT NULL DEFAULT '' COMMENT '类型',
  `detail` varchar(30) NOT NULL COMMENT '详情',
  `status` int(1) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='资金记录表';

LOCK TABLES `cmf_coin_log` WRITE;
/*!40000 ALTER TABLE `cmf_coin_log` DISABLE KEYS */;

INSERT INTO `cmf_coin_log` (`id`, `uid`, `coin`, `type`, `detail`, `status`, `create_time`)
VALUES
	(1,2,50,'team','下级id4团建奖励',1,1504001265),
	(2,1,20,'team','下下级id2团建奖励',1,1504001265),
	(3,2,50,'team','下级id4团建奖励',1,1504001668),
	(4,1,20,'team','下下级id4团建奖励',1,1504001668),
	(5,2,50,'team','下级id4团建奖励',1,1504010495),
	(6,1,20,'team','下下级id4团建奖励',1,1504010495),
	(7,4,100,'active','激活CBC3A3B203076216奖励',1,1504010654),
	(8,2,50,'active','下级激活CBC3A3B203076216奖励',1,1504010654),
	(9,1,20,'active','下下级激活CBC3A3B203076216奖励',1,1504010654),
	(10,4,-500,'zz','转账到13320990009',0,1504158499),
	(11,7,500,'tx','转账来自13320990009',0,1504158499),
	(12,4,-500,'tx','转账到13320990009',1,1504158538),
	(13,7,500,'tx','转账来自13320990009',1,1504158538),
	(14,1,-30,'tx','微信账号:13320992099',0,1506191367),
	(15,10,0,'tx','微信账号:1333',0,1506191448),
	(16,10,-30,'tx','微信账号:123',0,1506191554);

/*!40000 ALTER TABLE `cmf_coin_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_comment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_comment`;

CREATE TABLE `cmf_comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发表评论的用户id',
  `to_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被评论的用户id',
  `object_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论内容 id',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:已审核,0:未审核',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '评论类型；1实名评论',
  `table_name` varchar(64) NOT NULL DEFAULT '' COMMENT '评论内容所在表，不带表前缀',
  `full_name` varchar(50) NOT NULL DEFAULT '' COMMENT '评论者昵称',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '评论者邮箱',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '层级关系',
  `url` text COMMENT '原文地址',
  `content` text COMMENT '评论内容',
  `more` text COMMENT '扩展属性',
  PRIMARY KEY (`id`),
  KEY `comment_post_ID` (`object_id`),
  KEY `comment_approved_date_gmt` (`status`),
  KEY `comment_parent` (`parent_id`),
  KEY `table_id_status` (`table_name`,`object_id`,`status`),
  KEY `createtime` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论表';



# Dump of table cmf_contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_contacts`;

CREATE TABLE `cmf_contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(3) NOT NULL DEFAULT '0' COMMENT '留言类型',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  `tel` varchar(30) NOT NULL DEFAULT '' COMMENT '电话',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='首页留联系方式表';

LOCK TABLES `cmf_contacts` WRITE;
/*!40000 ALTER TABLE `cmf_contacts` DISABLE KEYS */;

INSERT INTO `cmf_contacts` (`id`, `type`, `name`, `tel`, `description`)
VALUES
	(1,'con','张建广','15281009455','我想代理'),
	(2,'con','阿斯蒂芬','15281009455','我要分润');

/*!40000 ALTER TABLE `cmf_contacts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_deal
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_deal`;

CREATE TABLE `cmf_deal` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lsid` char(20) DEFAULT NULL COMMENT '流水号',
  `qyjg` char(50) DEFAULT NULL COMMENT '签约机构',
  `shid` char(20) DEFAULT NULL COMMENT '商户号',
  `shname` char(100) DEFAULT NULL COMMENT '商户注册名',
  `zdid` char(20) DEFAULT NULL COMMENT '终端号',
  `dealtime` char(20) DEFAULT NULL COMMENT '交易日期',
  `dealcoin` float DEFAULT NULL COMMENT '交易金额',
  `dealfee` float DEFAULT NULL COMMENT '交易手续费',
  `cardtype` char(10) DEFAULT NULL COMMENT '用卡类型',
  `paytime` char(20) DEFAULT NULL COMMENT '支付时间',
  `postype` char(50) DEFAULT NULL COMMENT 'pos类型',
  `code` varchar(30) DEFAULT '' COMMENT '机具号',
  `state` tinyint(2) DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='交易表';

LOCK TABLES `cmf_deal` WRITE;
/*!40000 ALTER TABLE `cmf_deal` DISABLE KEYS */;

INSERT INTO `cmf_deal` (`id`, `lsid`, `qyjg`, `shid`, `shname`, `zdid`, `dealtime`, `dealcoin`, `dealfee`, `cardtype`, `paytime`, `postype`, `code`, `state`)
VALUES
	(1,'17090710249105','343044','822306459947939','重庆尚端智能家居系统集成有限公司','99669629','2017-09-07',368,2.21,'贷记卡','2017-09-07 13:43:03','手机收款宝-个人','CBC3A3B203076288',0),
	(2,'17090710247626','343044','822306459947939','重庆尚端智能家居系统集成有限公司','99669629','2017-09-07',1368,8.21,'贷记卡','2017-09-07 13:41:15','手机收款宝-个人','CBC3A3B203076288',0),
	(3,'17090710248228','343044','822306459947939','重庆尚端智能家居系统集成有限公司','99669629','2017-09-07',368,2.21,'贷记卡','2017-09-07 13:42:04','手机收款宝-个人','CBC3A3B203076288',0),
	(4,'17090710612289','343044','822306459947939','重庆尚端智能家居系统集成有限公司','99669629','2017-09-07',196,1.18,'贷记卡','2017-09-07 21:19:29','手机收款宝-个人','CBC3A3B203076288',0),
	(5,'17090710612602','343044','822306459947939','重庆尚端智能家居系统集成有限公司','99669629','2017-09-07',196,1.18,'贷记卡','2017-09-07 21:20:17','手机收款宝-个人','CBC3A3B203076288',0),
	(6,'17090710287077','353978','822311659948107','生御汽车美容装饰','28171208','2017-09-07',1398,8.39,'贷记卡','2017-09-07 14:30:41','手机收款宝-个人','CBC3A3B203681340',0),
	(7,'17090710289116','353978','822311659948107','生御汽车美容装饰','28171208','2017-09-07',5498,32.99,'贷记卡','2017-09-07 14:32:56','手机收款宝-个人','CBC3A3B203681340',0),
	(8,'17090710595283','388988','822308959948699','麦吉丽店铺','28513055','2017-09-07',2000,12,'贷记卡','2017-09-07 20:47:12','手机收款宝-个人','CBC3A3B203708660',0),
	(9,'17090610637101','388988','822309059947230','红高粱酒坊','28472438','2017-09-06',9345,56.07,'贷记卡','2017-09-06 23:02:03','手机收款宝-个人','CBC3A3B203708644',0),
	(10,'17090710097088','骏霖大代理KM','822302957222082','蒲阳蛋糕店','95201595','2017-09-07',3800,22.8,'贷记卡','2017-09-07 10:31:35','手机收款宝-个人','CBC3A3B202975460',0),
	(11,'17090710341981','338540','822301459940816','太阳圣火商贸有限公司','95496251','2017-09-07',6000,36,'贷记卡','2017-09-07 15:33:30','手机收款宝-个人','CBC3A3B204472986',0),
	(12,'17090710329314','338540','822301459940816','太阳圣火商贸有限公司','95496251','2017-09-07',3000,18,'贷记卡','2017-09-07 15:19:19','手机收款宝-个人','CBC3A3B204472986',0),
	(13,'17090710342958','338540','822301459940816','太阳圣火商贸有限公司','95496251','2017-09-07',2000,12,'贷记卡','2017-09-07 15:34:37','手机收款宝-个人','CBC3A3B204472986',0),
	(14,'17090710328207','338540','822301459940816','太阳圣火商贸有限公司','95496251','2017-09-07',15000,90,'贷记卡','2017-09-07 15:18:15','手机收款宝-个人','CBC3A3B204472986',0),
	(15,'17090710066866','359142','822307159946563','新车谱航汽车销售服务有限公司','28713176','2017-09-07',10000,60,'贷记卡','2017-09-07 09:54:08','手机收款宝-个人','CBC3A3B208221181',0),
	(16,'17090710528336','343405','822303959940596','永旺生活馆','99019752','2017-09-07',7520,45.12,'贷记卡','2017-09-07 19:06:16','手机收款宝-个人','CBC3A3B202976180',0),
	(17,'17090710227964','384015','822303459949405','稻香米餐厅','98978484','2017-09-07',1200,6,'借记卡','2017-09-07 13:15:53','手机收款宝-个人','CBC3A3B203076270',0),
	(18,'17090710507614','384015','822309659945343','金色好乐迪KTV','28311175','2017-09-07',2188,13.13,'贷记卡','2017-09-07 18:40:06','手机收款宝-个人','CBC3A3B203076245',0),
	(19,'17090710452898','384015','822303459949405','稻香米餐厅','98978484','2017-09-07',1000,5,'借记卡','2017-09-07 17:36:19','手机收款宝-个人','CBC3A3B203076270',0),
	(20,'17090710548804','418594','822308259947947','roikingstar','28617980','2017-09-07',999,5.99,'贷记卡','2017-09-07 19:35:16','手机收款宝-个人','CBC3A3B203750823',0),
	(21,'17090710552839','418594','822308259947947','roikingstar','28617980','2017-09-07',2299,13.79,'贷记卡','2017-09-07 19:41:01','手机收款宝-个人','CBC3A3B203750823',0),
	(22,'17090710552616','418594','822308259947947','roikingstar','28617980','2017-09-07',2299,13.79,'贷记卡','2017-09-07 19:40:20','手机收款宝-个人','CBC3A3B203750823',0),
	(23,'17090710500033','418594','822309959945813','兰姐麻将馆','28386793','2017-09-07',382,2.29,'贷记卡','2017-09-07 18:30:56','手机收款宝-个人','CBC3A3B208221241',0),
	(24,'17090710459022','385892','822306759944770','渠县富？宾馆','99697962','2017-09-07',5320,31.92,'贷记卡','2017-09-07 17:43:17','手机收款宝-个人','CBC3A3B203750853',0),
	(25,'17090710167266','356724','822310259941803','昌吉市壹玖壹陆酒吧','28214602','2017-09-07',16100,96.6,'贷记卡','2017-09-07 11:54:48','手机收款宝-个人','CBC3A3B204473021',0),
	(26,'17090710559627','333104','822309059948810','祥福珠宝店','28471847','2017-09-07',2000,12,'贷记卡','2017-09-07 19:51:04','手机收款宝-个人','CBC3A3B208221232',0),
	(27,'17090710582182','333104','822310059949917','诚诚烟酒行','28373959','2017-09-07',17005,102.03,'贷记卡','2017-09-07 20:25:35','手机收款宝-个人','CBC3A3B208221304',0),
	(28,'17090751636464','333104','822311059949766','宝宝贝贝酒水超市','28120029','2017-09-07',2399,14.39,'贷记卡','2017-09-07 15:52:09','手机收款宝-个人','CBC3A3B207057793',0),
	(29,'17090710078809','333104','822308259944698','天天小面馆','28604759','2017-09-07',276,1.66,'贷记卡','2017-09-07 10:09:45','手机收款宝-个人','CBC3A3B208221268',0),
	(30,'17090710069761','333104','822306259941544','同视眼镜店','99642047','2017-09-07',200,1.2,'贷记卡','2017-09-07 09:58:22','手机收款宝-个人','CBC3A3B203750822',0),
	(31,'17090710247722','333104','822310359949143','名媛丽人半永久','28364370','2017-09-07',2000,12,'贷记卡','2017-09-07 13:41:26','手机收款宝-个人','CBC3A3B203681346',0),
	(32,'17090751192162','333104','822311359945889','普联商贸烟酒','28128549','2017-09-07',2000,12,'贷记卡','2017-09-07 11:55:03','手机收款宝-个人','CBC3A3B203681352',0),
	(33,'17090752226059','333104','822311159944897','饕餮盛宴私房菜','28112221','2017-09-07',880,5.28,'贷记卡','2017-09-07 20:50:50','手机收款宝-个人','CBC3A3B207070520',0),
	(34,'17090752224575','333104','822311159944897','饕餮盛宴私房菜','28112221','2017-09-07',128,0.77,'贷记卡','2017-09-07 20:50:05','手机收款宝-个人','CBC3A3B207070520',0),
	(35,'17090752162987','333104','822311059945866','宏鑫酒水超市','28298026','2017-09-07',2018,12.11,'贷记卡','2017-09-07 20:16:32','手机收款宝-个人','CBC3A3B207057792',0),
	(36,'17090710070951','333104','822306259941544','同视眼镜店','99642047','2017-09-07',130,0.78,'贷记卡','2017-09-07 09:59:40','手机收款宝-个人','CBC3A3B203750822',0),
	(37,'17090710198586','333104','822311659947365','成都弘扬房产','28156671','2017-09-07',3000,18,'贷记卡','2017-09-07 12:37:11','手机收款宝-个人','CBC3A3B203750821',0),
	(38,'17090710081524','333104','822308259944698','天天小面馆','28604759','2017-09-07',45,0.27,'贷记卡','2017-09-07 10:12:59','手机收款宝-个人','CBC3A3B208221268',0),
	(39,'17090710540815','333104','822311559943383','量力钢材小卖部','28158496','2017-09-07',4000,24,'贷记卡','2017-09-07 19:24:07','手机收款宝-个人','CBC3A3B203681361',0),
	(40,'17090710533728','333104','822309859947432','牵手汽车有限公司','28343921','2017-09-07',3450,20.7,'贷记卡','2017-09-07 19:14:03','手机收款宝-个人','CBC3A3B208221297',0),
	(41,'17090710068564','333104','822307259945415','精睿有限公司','28727058','2017-09-07',16954,101.72,'贷记卡','2017-09-07 09:56:50','手机收款宝-个人','CBC3A3B203681384',0),
	(42,'17090710191532','333104','822301659944722','荷花池中国移动店','95520164','2017-09-07',7999,47.99,'贷记卡','2017-09-07 12:27:40','手机收款宝-个人','CBC3A3B203076314',0),
	(43,'17090710074789','333104','822307259945415','精睿有限公司','28727058','2017-09-07',29546,177.28,'贷记卡','2017-09-07 10:04:38','手机收款宝-个人','CBC3A3B203681384',0),
	(44,'17090710004164','333104','822311859940465','凌峰家用电器商店','28015889','2017-09-07',300,1.8,'贷记卡','2017-09-07 04:43:05','手机收款宝-个人','CBC3A3B203681354',0),
	(45,'17090710583657','333104','822310059949917','诚诚烟酒行','28373959','2017-09-07',906,5.44,'贷记卡','2017-09-07 20:28:09','手机收款宝-个人','CBC3A3B208221304',0),
	(46,'17090710210729','333104','822311459943851','龙泉区绿果超市','28137654','2017-09-07',500,3,'贷记卡','2017-09-07 12:53:19','手机收款宝-个人','CBC3A3B208221283',0),
	(47,'17090710001630','333104','822311659947365','成都弘扬房产','28156671','2017-09-07',4100,24.6,'贷记卡','2017-09-07 01:44:24','手机收款宝-个人','CBC3A3B203750821',0),
	(48,'17090751653342','333104','822311059949766','宝宝贝贝酒水超市','28120029','2017-09-07',69,0.41,'贷记卡','2017-09-07 16:00:00','手机收款宝-个人','CBC3A3B207057793',0),
	(49,'17090710512592','333104','822310559942325','文文时装店','28206906','2017-09-07',1135,6.81,'贷记卡','2017-09-07 18:46:07','手机收款宝-个人','CBC3A3B208221272',0),
	(50,'17090752228535','333104','822311159944897','饕餮盛宴私房菜','28112221','2017-09-07',992,5.95,'贷记卡','2017-09-07 20:52:12','手机收款宝-个人','CBC3A3B207070520',0),
	(51,'17090710543725','333104','822311559943383','量力钢材小卖部','28158496','2017-09-07',2000,12,'贷记卡','2017-09-07 19:28:14','手机收款宝-个人','CBC3A3B203681361',0),
	(52,'17090752087907','333104','822311259941278','成都宇辉电器','28250924','2017-09-07',2400,14.4,'贷记卡','2017-09-07 19:37:29','手机收款宝-个人','CBC3A3B207070479',0),
	(53,'17090610639898','333104','822309659942567','鸿泰调味品商贸公司','28305129','2017-09-06',18,0.11,'贷记卡','2017-09-06 23:22:44','手机收款宝-个人','CBC3A3B208221321',0);

/*!40000 ALTER TABLE `cmf_deal` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_hook
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_hook`;

CREATE TABLE `cmf_hook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '钩子类型(1:系统钩子;2:应用钩子;3:模板钩子;4:后台模板钩子)',
  `once` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否只允许一个插件运行(0:多个;1:一个)',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `hook` varchar(30) NOT NULL DEFAULT '' COMMENT '钩子',
  `app` varchar(15) NOT NULL DEFAULT '' COMMENT '应用名(只有应用钩子才用)',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统钩子表';

LOCK TABLES `cmf_hook` WRITE;
/*!40000 ALTER TABLE `cmf_hook` DISABLE KEYS */;

INSERT INTO `cmf_hook` (`id`, `type`, `once`, `name`, `hook`, `app`, `description`)
VALUES
	(1,1,0,'应用初始化','app_init','cmf','应用初始化'),
	(2,1,0,'应用开始','app_begin','cmf','应用开始'),
	(3,1,0,'模块初始化','module_init','cmf','模块初始化'),
	(4,1,0,'控制器开始','action_begin','cmf','控制器开始'),
	(5,1,0,'视图输出过滤','view_filter','cmf','视图输出过滤'),
	(6,1,0,'应用结束','app_end','cmf','应用结束'),
	(7,1,0,'日志write方法','log_write','cmf','日志write方法'),
	(8,1,0,'输出结束','response_end','cmf','输出结束'),
	(9,1,0,'后台控制器初始化','admin_init','cmf','后台控制器初始化'),
	(10,1,0,'前台控制器初始化','home_init','cmf','前台控制器初始化'),
	(11,1,1,'发送手机验证码','send_mobile_verification_code','cmf','发送手机验证码'),
	(12,3,0,'模板 body标签开始','body_start','','模板 body标签开始'),
	(13,3,0,'模板 head标签结束前','before_head_end','','模板 head标签结束前'),
	(14,3,0,'模板底部开始','footer_start','','模板底部开始'),
	(15,3,0,'模板底部开始之前','before_footer','','模板底部开始之前'),
	(16,3,0,'模板底部结束之前','before_footer_end','','模板底部结束之前'),
	(17,3,0,'模板 body 标签结束之前','before_body_end','','模板 body 标签结束之前'),
	(18,3,0,'模板左边栏开始','left_sidebar_start','','模板左边栏开始'),
	(19,3,0,'模板左边栏结束之前','before_left_sidebar_end','','模板左边栏结束之前'),
	(20,3,0,'模板右边栏开始','right_sidebar_start','','模板右边栏开始'),
	(21,3,0,'模板右边栏结束之前','before_right_sidebar_end','','模板右边栏结束之前'),
	(22,3,1,'评论区','comment','','评论区'),
	(23,3,1,'留言区','guestbook','','留言区'),
	(24,2,0,'后台首页仪表盘','admin_dashboard','admin','后台首页仪表盘'),
	(25,4,0,'后台模板 head标签结束前','admin_before_head_end','','后台模板 head标签结束前'),
	(26,4,0,'后台模板 body 标签结束之前','admin_before_body_end','','后台模板 body 标签结束之前'),
	(27,2,0,'后台登录页面','admin_login','admin','后台登录页面'),
	(28,1,1,'前台模板切换','switch_theme','cmf','前台模板切换');

/*!40000 ALTER TABLE `cmf_hook` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_hook_plugin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_hook_plugin`;

CREATE TABLE `cmf_hook_plugin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `hook` varchar(30) NOT NULL DEFAULT '' COMMENT '钩子名',
  `plugin` varchar(30) NOT NULL DEFAULT '' COMMENT '插件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统钩子插件表';

LOCK TABLES `cmf_hook_plugin` WRITE;
/*!40000 ALTER TABLE `cmf_hook_plugin` DISABLE KEYS */;

INSERT INTO `cmf_hook_plugin` (`id`, `list_order`, `status`, `hook`, `plugin`)
VALUES
	(3,10000,0,'footer_start','Demo'),
	(5,10000,1,'send_mobile_verification_code','MobileCodeDemo');

/*!40000 ALTER TABLE `cmf_hook_plugin` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_link
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_link`;

CREATE TABLE `cmf_link` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:显示;0:不显示',
  `rating` int(11) NOT NULL DEFAULT '0' COMMENT '友情链接评级',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '友情链接描述',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '友情链接地址',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '友情链接名称',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '友情链接图标',
  `target` varchar(10) NOT NULL DEFAULT '' COMMENT '友情链接打开方式',
  `rel` varchar(50) NOT NULL DEFAULT '' COMMENT '链接与网站的关系',
  PRIMARY KEY (`id`),
  KEY `link_visible` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='友情链接表';

LOCK TABLES `cmf_link` WRITE;
/*!40000 ALTER TABLE `cmf_link` DISABLE KEYS */;

INSERT INTO `cmf_link` (`id`, `status`, `rating`, `list_order`, `description`, `url`, `name`, `image`, `target`, `rel`)
VALUES
	(1,0,1,8,'四川科美诺官网','http://www.sckemeinuo.com','科美诺','','_blank','');

/*!40000 ALTER TABLE `cmf_link` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_nav
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_nav`;

CREATE TABLE `cmf_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_main` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否为主导航;1:是;0:不是',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '导航位置名称',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='前台导航位置表';

LOCK TABLES `cmf_nav` WRITE;
/*!40000 ALTER TABLE `cmf_nav` DISABLE KEYS */;

INSERT INTO `cmf_nav` (`id`, `is_main`, `name`, `remark`)
VALUES
	(1,1,'主导航','主导航'),
	(2,0,'底部导航','');

/*!40000 ALTER TABLE `cmf_nav` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_nav_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_nav_menu`;

CREATE TABLE `cmf_nav_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_id` int(11) NOT NULL COMMENT '导航 id',
  `parent_id` int(11) NOT NULL COMMENT '父 id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:显示;0:隐藏',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `target` varchar(10) NOT NULL DEFAULT '' COMMENT '打开方式',
  `href` varchar(100) NOT NULL DEFAULT '' COMMENT '链接',
  `icon` varchar(20) NOT NULL DEFAULT '' COMMENT '图标',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '层级关系',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='前台导航菜单表';

LOCK TABLES `cmf_nav_menu` WRITE;
/*!40000 ALTER TABLE `cmf_nav_menu` DISABLE KEYS */;

INSERT INTO `cmf_nav_menu` (`id`, `nav_id`, `parent_id`, `status`, `list_order`, `name`, `target`, `href`, `icon`, `path`)
VALUES
	(1,1,0,1,0,'首页','','home','','0-1'),
	(2,1,0,1,10000,'常见问题','','{\"action\":\"portal\\/List\\/index\",\"param\":{\"id\":8}}','',''),
	(3,1,0,0,10000,'联系我们','','amF2YXNjcmlwdDo7','',''),
	(4,1,3,0,10001,'订购热线','','dGVsOjEzMzIwOTkwMDA5','',''),
	(5,1,0,1,10000,'免费领取','_blank','https://weidian.com/item.html?itemID=2135521686','',''),
	(6,1,0,1,10000,'网站公告','','{\"action\":\"portal\\/List\\/index\",\"param\":{\"id\":9}}','','');

/*!40000 ALTER TABLE `cmf_nav_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_option
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_option`;

CREATE TABLE `cmf_option` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `autoload` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否自动加载;1:自动加载;0:不自动加载',
  `option_name` varchar(64) NOT NULL DEFAULT '' COMMENT '配置名',
  `option_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '配置值',
  PRIMARY KEY (`id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='全站配置表';

LOCK TABLES `cmf_option` WRITE;
/*!40000 ALTER TABLE `cmf_option` DISABLE KEYS */;

INSERT INTO `cmf_option` (`id`, `autoload`, `option_name`, `option_value`)
VALUES
	(7,1,'site_info','{\"site_name\":\"\\u62c9\\u5361\\u62c9\\u6536\\u6b3e\\u5b9d\",\"site_seo_title\":\"\",\"site_seo_keywords\":\"\\u62c9\\u5361\\u62c9 \\u6536\\u6b3e\\u5b9d pos \\u4fe1\\u7528\\u5361\\u8fd8\\u6b3e \\u8d37\\u6b3e \\u8fd8\\u6b3e \\u4ee3\\u8fd8\\u4fe1\\u7528\\u5361 \\u517b\\u5361 \\u5957\\u73b0 \\u62c9\\u5361\\u62c9\\u6536\\u6b3e\\u5b9d\\u53ef\\u4ee5\\u4fe1\\u7528\\u5361\\u5957\\u73b0\\u4e48 \\u624b\\u5237 \\u7b2c\\u4e09\\u65b9\\u652f\\u4ed8 \\u624b\\u673a\\u5237\\u5361\\u673a\\u53ef\\u4ee5\\u5237\\u81ea\\u5df1\\u7684\\u4fe1\\u7528\\u5361 \\u5237\\u81ea\\u5df1\\u7684\\u4fe1\\u7528\\u5361 \\u6ca1\\u94b1\\u8fd8\\u4fe1\\u7528\\u5361 pos\\u673a\\u5957\\u73b0 \\u4fe1\\u7528\\u5361\\u63d0\\u989d\",\"site_seo_description\":\"\\u62c9\\u5361\\u62c9 \\u6536\\u6b3e\\u5b9d pos \\u4fe1\\u7528\\u5361\\u8fd8\\u6b3e \\u8d37\\u6b3e \\u8fd8\\u6b3e \\u4ee3\\u8fd8\\u4fe1\\u7528\\u5361 \\u517b\\u5361 \\u5957\\u73b0 \\u62c9\\u5361\\u62c9\\u6536\\u6b3e\\u5b9d\\u53ef\\u4ee5\\u4fe1\\u7528\\u5361\\u5957\\u73b0\\u4e48 \\u624b\\u5237 \\u7b2c\\u4e09\\u65b9\\u652f\\u4ed8 \\u624b\\u673a\\u5237\\u5361\\u673a\\u53ef\\u4ee5\\u5237\\u81ea\\u5df1\\u7684\\u4fe1\\u7528\\u5361 \\u5237\\u81ea\\u5df1\\u7684\\u4fe1\\u7528\\u5361 \\u6ca1\\u94b1\\u8fd8\\u4fe1\\u7528\\u5361 pos\\u673a\\u5957\\u73b0 \\u4fe1\\u7528\\u5361\\u63d0\\u989d\",\"site_icp\":\"\",\"site_admin_email\":\"\",\"site_analytics\":\"\",\"urlmode\":\"1\",\"html_suffix\":\"\"}'),
	(8,1,'cmf_settings','{\"open_registration\":\"0\",\"banned_usernames\":\"\"}'),
	(9,1,'cdn_settings','{\"cdn_static_root\":\"\"}'),
	(10,1,'admin_settings','{\"admin_password\":\"\",\"admin_style\":\"flatadmin\"}'),
	(11,1,'smtp_setting','{\"from_name\":\"\\u62c9\\u5e03\\u62c9\\u5361\",\"from\":\"angorz@163.com\",\"host\":\"smtp.163.com\",\"smtp_secure\":\"\",\"port\":\"25\",\"username\":\"angorz@163.com\",\"password\":\"after1991\"}'),
	(12,1,'email_template_verification_code','{\"subject\":\"\\u62c9\\u5e03\\u62c9\\u5361\\u6ce8\\u518c \\u7535\\u5b50\\u90ae\\u4ef6\\u9a8c\\u8bc1 \\u2013 \\u5fc5\\u8981\\u64cd\\u4f5c\",\"template\":\"&lt;p style=&quot;color: rgb(187, 187, 187); font-family: &amp;quot;Open Sans&amp;quot;, Frutiger, &amp;quot;Frutiger Linotype&amp;quot;, Univers, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, &amp;quot;Gill Sans&amp;quot;, &amp;quot;Gill Sans MT&amp;quot;, &amp;quot;Myriad Pro&amp;quot;, Myriad, &amp;quot;DejaVu Sans Condensed&amp;quot;, &amp;quot;Liberation Sans&amp;quot;, &amp;quot;Nimbus Sans L&amp;quot;, &amp;quot;Malgun Gothic&amp;quot;, &amp;quot;Microsoft YaHei&amp;quot;, AppleSDGothicNeo, AppleGothic, Dotum, &amp;quot;Microsoft JhengHei&amp;quot;, &amp;quot;Hiragino Kaku Gothic Pro&amp;quot;, &amp;quot;Hiragino Kaku Gothic ProN W3&amp;quot;, Osaka, \\u30e1\\u30a4\\u30ea\\u30aa, Meiryo, &amp;quot;\\uff2d\\uff33 \\uff30\\u30b4\\u30b7\\u30c3\\u30af&amp;quot;, Calibri, Geneva, Display, Tahoma, Verdana, sans-serif; font-size: 14px; white-space: normal; text-size-adjust: auto;&quot;&gt;&lt;span style=&quot;color: rgb(255, 183, 82); font-family: &amp;quot;Source Sans Pro&amp;quot;, Calibri, Candara, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);&quot;&gt;{$username}&lt;\\/span&gt;\\u60a8\\u597d\\uff0c&lt;\\/p&gt;&lt;p style=&quot;color: rgb(187, 187, 187); font-family: &amp;quot;Open Sans&amp;quot;, Frutiger, &amp;quot;Frutiger Linotype&amp;quot;, Univers, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, &amp;quot;Gill Sans&amp;quot;, &amp;quot;Gill Sans MT&amp;quot;, &amp;quot;Myriad Pro&amp;quot;, Myriad, &amp;quot;DejaVu Sans Condensed&amp;quot;, &amp;quot;Liberation Sans&amp;quot;, &amp;quot;Nimbus Sans L&amp;quot;, &amp;quot;Malgun Gothic&amp;quot;, &amp;quot;Microsoft YaHei&amp;quot;, AppleSDGothicNeo, AppleGothic, Dotum, &amp;quot;Microsoft JhengHei&amp;quot;, &amp;quot;Hiragino Kaku Gothic Pro&amp;quot;, &amp;quot;Hiragino Kaku Gothic ProN W3&amp;quot;, Osaka, \\u30e1\\u30a4\\u30ea\\u30aa, Meiryo, &amp;quot;\\uff2d\\uff33 \\uff30\\u30b4\\u30b7\\u30c3\\u30af&amp;quot;, Calibri, Geneva, Display, Tahoma, Verdana, sans-serif; font-size: 14px; white-space: normal; text-size-adjust: auto;&quot;&gt;\\u672c\\u6b21\\u60a8\\u7684\\u90ae\\u7bb1\\u9a8c\\u8bc1\\u7801\\u4e3a\\uff1a&lt;br\\/&gt;&lt;span style=&quot;color: rgb(255, 183, 82); font-family: &amp;quot;Source Sans Pro&amp;quot;, Calibri, Candara, Arial, sans-serif; background-color: rgb(255, 255, 255); font-size: 36px;&quot;&gt;{$code}&lt;\\/span&gt;&lt;\\/p&gt;&lt;p style=&quot;color: rgb(187, 187, 187); font-family: &amp;quot;Open Sans&amp;quot;, Frutiger, &amp;quot;Frutiger Linotype&amp;quot;, Univers, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, &amp;quot;Gill Sans&amp;quot;, &amp;quot;Gill Sans MT&amp;quot;, &amp;quot;Myriad Pro&amp;quot;, Myriad, &amp;quot;DejaVu Sans Condensed&amp;quot;, &amp;quot;Liberation Sans&amp;quot;, &amp;quot;Nimbus Sans L&amp;quot;, &amp;quot;Malgun Gothic&amp;quot;, &amp;quot;Microsoft YaHei&amp;quot;, AppleSDGothicNeo, AppleGothic, Dotum, &amp;quot;Microsoft JhengHei&amp;quot;, &amp;quot;Hiragino Kaku Gothic Pro&amp;quot;, &amp;quot;Hiragino Kaku Gothic ProN W3&amp;quot;, Osaka, \\u30e1\\u30a4\\u30ea\\u30aa, Meiryo, &amp;quot;\\uff2d\\uff33 \\uff30\\u30b4\\u30b7\\u30c3\\u30af&amp;quot;, Calibri, Geneva, Display, Tahoma, Verdana, sans-serif; font-size: 14px; white-space: normal; text-size-adjust: auto;&quot;&gt;\\u8bf7\\u59a5\\u5584\\u4fdd\\u7ba1\\u597d\\u60a8\\u7684\\u9a8c\\u8bc1\\u7801\\uff0c\\u4e0d\\u8981\\u8f7b\\u6613\\u6cc4\\u9732\\u4ed6\\u4eba\\uff0c\\u5982\\u975e\\u672c\\u4eba\\u64cd\\u4f5c\\uff0c\\u8bf7\\u5ffd\\u7565\\u3002&lt;\\/p&gt;&lt;p style=&quot;color: rgb(187, 187, 187); font-family: &amp;quot;Open Sans&amp;quot;, Frutiger, &amp;quot;Frutiger Linotype&amp;quot;, Univers, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, &amp;quot;Gill Sans&amp;quot;, &amp;quot;Gill Sans MT&amp;quot;, &amp;quot;Myriad Pro&amp;quot;, Myriad, &amp;quot;DejaVu Sans Condensed&amp;quot;, &amp;quot;Liberation Sans&amp;quot;, &amp;quot;Nimbus Sans L&amp;quot;, &amp;quot;Malgun Gothic&amp;quot;, &amp;quot;Microsoft YaHei&amp;quot;, AppleSDGothicNeo, AppleGothic, Dotum, &amp;quot;Microsoft JhengHei&amp;quot;, &amp;quot;Hiragino Kaku Gothic Pro&amp;quot;, &amp;quot;Hiragino Kaku Gothic ProN W3&amp;quot;, Osaka, \\u30e1\\u30a4\\u30ea\\u30aa, Meiryo, &amp;quot;\\uff2d\\uff33 \\uff30\\u30b4\\u30b7\\u30c3\\u30af&amp;quot;, Calibri, Geneva, Display, Tahoma, Verdana, sans-serif; font-size: 14px; white-space: normal; text-size-adjust: auto;&quot;&gt;\\u9a8c\\u8bc1\\u60a8\\u7684\\u7535\\u5b50\\u90ae\\u7bb1\\u5730\\u5740\\u53ef\\u4ee5\\u8ba9\\u60a8\\u6210\\u4e3a\\u771f\\u6b63\\u7684\\u62c9\\u5e03\\u62c9\\u5361\\u4f1a\\u5458\\u3002\\u9a8c\\u8bc1\\u4e4b\\u540e\\u4e5f\\u53ef\\u4ee5\\u4e3a\\u60a8\\u7684\\u8d26\\u53f7\\u63d0\\u4f9b\\u66f4\\u591a\\u4e00\\u5c42\\u5b89\\u5168\\u4fdd\\u62a4\\u3002&lt;\\/p&gt;&lt;p style=&quot;color: rgb(187, 187, 187); font-family: &amp;quot;Open Sans&amp;quot;, Frutiger, &amp;quot;Frutiger Linotype&amp;quot;, Univers, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, &amp;quot;Gill Sans&amp;quot;, &amp;quot;Gill Sans MT&amp;quot;, &amp;quot;Myriad Pro&amp;quot;, Myriad, &amp;quot;DejaVu Sans Condensed&amp;quot;, &amp;quot;Liberation Sans&amp;quot;, &amp;quot;Nimbus Sans L&amp;quot;, &amp;quot;Malgun Gothic&amp;quot;, &amp;quot;Microsoft YaHei&amp;quot;, AppleSDGothicNeo, AppleGothic, Dotum, &amp;quot;Microsoft JhengHei&amp;quot;, &amp;quot;Hiragino Kaku Gothic Pro&amp;quot;, &amp;quot;Hiragino Kaku Gothic ProN W3&amp;quot;, Osaka, \\u30e1\\u30a4\\u30ea\\u30aa, Meiryo, &amp;quot;\\uff2d\\uff33 \\uff30\\u30b4\\u30b7\\u30c3\\u30af&amp;quot;, Calibri, Geneva, Display, Tahoma, Verdana, sans-serif; font-size: 14px; white-space: normal; text-size-adjust: auto;&quot;&gt;\\u60f3\\u8981\\u4e86\\u89e3\\u66f4\\u591a\\u4fe1\\u606f\\uff0c\\u8bf7\\u8bbf\\u95ee&lt;a href=&quot;http:\\/\\/www.mylabulaka.com&quot; target=&quot;_blank&quot;&gt;&lt;span class=&quot;Apple-converted-space&quot;&gt;&amp;nbsp;&lt;\\/span&gt;\\u70b9\\u51fb\\u6b64\\u5904&lt;span class=&quot;Apple-converted-space&quot;&gt;&amp;nbsp;&lt;\\/span&gt;&lt;\\/a&gt;\\u6765\\u67e5\\u770b&lt;\\/p&gt;&lt;p style=&quot;color: rgb(187, 187, 187); font-family: &amp;quot;Open Sans&amp;quot;, Frutiger, &amp;quot;Frutiger Linotype&amp;quot;, Univers, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, &amp;quot;Gill Sans&amp;quot;, &amp;quot;Gill Sans MT&amp;quot;, &amp;quot;Myriad Pro&amp;quot;, Myriad, &amp;quot;DejaVu Sans Condensed&amp;quot;, &amp;quot;Liberation Sans&amp;quot;, &amp;quot;Nimbus Sans L&amp;quot;, &amp;quot;Malgun Gothic&amp;quot;, &amp;quot;Microsoft YaHei&amp;quot;, AppleSDGothicNeo, AppleGothic, Dotum, &amp;quot;Microsoft JhengHei&amp;quot;, &amp;quot;Hiragino Kaku Gothic Pro&amp;quot;, &amp;quot;Hiragino Kaku Gothic ProN W3&amp;quot;, Osaka, \\u30e1\\u30a4\\u30ea\\u30aa, Meiryo, &amp;quot;\\uff2d\\uff33 \\uff30\\u30b4\\u30b7\\u30c3\\u30af&amp;quot;, Calibri, Geneva, Display, Tahoma, Verdana, sans-serif; font-size: 14px; white-space: normal; text-size-adjust: auto;&quot;&gt;\\u60a8\\u771f\\u8bda\\u7684\\uff0c&lt;br\\/&gt;\\u62c9\\u5e03\\u62c9\\u5361\\u8fd0\\u8425\\u56e2\\u961f&lt;\\/p&gt;&lt;p&gt;&lt;br\\/&gt;&lt;\\/p&gt;\"}'),
	(13,1,'ptuser_settings','{\"fx\":\"100\",\"pfx\":\"50\",\"ppfx\":\"20\",\"tx\":\"500\",\"ptj\":\"50\",\"pptj\":\"20\"}'),
	(14,1,'gjuser_settings','{\"fx\":\"0\",\"pfx\":\"0\",\"ppfx\":\"0\",\"tx\":\"100000000\",\"ptj\":\"0\",\"pptj\":\"0\"}');

/*!40000 ALTER TABLE `cmf_option` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_plugin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_plugin`;

CREATE TABLE `cmf_plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '插件类型;1:网站;8:微信',
  `has_admin` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台管理,0:没有;1:有',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:开启;0:禁用',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '插件安装时间',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '插件标识名,英文字母(惟一)',
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '插件名称',
  `demo_url` varchar(50) NOT NULL DEFAULT '' COMMENT '演示地址，带协议',
  `hooks` varchar(255) NOT NULL DEFAULT '' COMMENT '实现的钩子;以“,”分隔',
  `author` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '插件作者',
  `author_url` varchar(50) NOT NULL DEFAULT '' COMMENT '作者网站链接',
  `version` varchar(20) NOT NULL DEFAULT '' COMMENT '插件版本号',
  `description` varchar(255) NOT NULL COMMENT '插件描述',
  `config` text COMMENT '插件配置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='插件表';

LOCK TABLES `cmf_plugin` WRITE;
/*!40000 ALTER TABLE `cmf_plugin` DISABLE KEYS */;

INSERT INTO `cmf_plugin` (`id`, `type`, `has_admin`, `status`, `create_time`, `name`, `title`, `demo_url`, `hooks`, `author`, `author_url`, `version`, `description`, `config`)
VALUES
	(3,1,1,0,0,'Demo','插件演示','http://demo.thinkcmf.com','','ThinkCMF','http://www.thinkcmf.com','1.0','插件演示','{\"text\":\"hello,ThinkCMF!\",\"password\":\"\",\"number\":\"1.0\",\"select\":\"1\",\"checkbox\":1,\"radio\":\"1\",\"radio2\":\"1\",\"textarea\":\"\\u8fd9\\u91cc\\u662f\\u4f60\\u8981\\u586b\\u5199\\u7684\\u5185\\u5bb9\",\"date\":\"2017-05-20\",\"datetime\":\"2017-05-20\",\"color\":\"#103633\",\"image\":\"\",\"location\":\"\"}'),
	(5,1,0,1,0,'MobileCodeDemo','手机验证码演示插件','','','ThinkCMF','','1.0','手机验证码演示插件','{\"account_sid\":\"\",\"auth_token\":\"\",\"app_id\":\"\",\"template_id\":\"\",\"expire_minute\":\"30\"}');

/*!40000 ALTER TABLE `cmf_plugin` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_portal_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_portal_category`;

CREATE TABLE `cmf_portal_category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类父id',
  `post_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类文章数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `description` varchar(255) NOT NULL COMMENT '分类描述',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '分类层级关系路径',
  `seo_title` varchar(100) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `list_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类列表模板',
  `one_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类文章页模板',
  `more` text COMMENT '扩展属性',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章分类表';

LOCK TABLES `cmf_portal_category` WRITE;
/*!40000 ALTER TABLE `cmf_portal_category` DISABLE KEYS */;

INSERT INTO `cmf_portal_category` (`id`, `parent_id`, `post_count`, `status`, `delete_time`, `list_order`, `name`, `description`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `more`)
VALUES
	(8,0,0,1,0,10000,'常见问题','常见问题','0-8','','','','list','article','{\"thumbnail\":\"http:\\/\\/mpic.tiankong.com\\/e59\\/aa7\\/e59aa7356b01318b4daf099f7167a69a\\/640.jpg\"}'),
	(9,0,0,1,0,10000,'网站公告','','0-9','','','','list','article','{\"thumbnail\":\"\"}');

/*!40000 ALTER TABLE `cmf_portal_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_portal_category_post
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_portal_category_post`;

CREATE TABLE `cmf_portal_category_post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布',
  PRIMARY KEY (`id`),
  KEY `term_taxonomy_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 分类文章对应表';

LOCK TABLES `cmf_portal_category_post` WRITE;
/*!40000 ALTER TABLE `cmf_portal_category_post` DISABLE KEYS */;

INSERT INTO `cmf_portal_category_post` (`id`, `post_id`, `category_id`, `list_order`, `status`)
VALUES
	(117,32,8,10000,1),
	(118,33,8,10000,1),
	(119,34,8,10000,1),
	(120,35,8,10000,1),
	(121,44,9,10000,1),
	(122,45,9,10000,1),
	(123,33,9,10000,1);

/*!40000 ALTER TABLE `cmf_portal_category_post` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_portal_post
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_portal_post`;

CREATE TABLE `cmf_portal_post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `post_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '类型,1:文章;2:页面',
  `post_format` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '内容格式;1:html;2:md',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '发表者用户id',
  `post_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:已发布;0:未发布;',
  `comment_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '评论状态;1:允许;0:不允许',
  `is_top` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶;1:置顶;0:不置顶',
  `recommended` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐;1:推荐;0:不推荐',
  `post_hits` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '查看数',
  `post_like` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数',
  `comment_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `published_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `post_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'post标题',
  `post_keywords` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo keywords',
  `post_excerpt` varchar(500) NOT NULL COMMENT 'post摘要',
  `post_source` varchar(150) NOT NULL DEFAULT '' COMMENT '转载文章的来源',
  `post_content` text COMMENT '文章内容',
  `post_content_filtered` text COMMENT '处理过的文章内容',
  `more` text COMMENT '扩展属性,如缩略图;格式为json',
  PRIMARY KEY (`id`),
  KEY `type_status_date` (`post_type`,`post_status`,`create_time`,`id`),
  KEY `post_parent` (`parent_id`),
  KEY `post_author` (`user_id`),
  KEY `post_date` (`create_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='portal应用 文章表';

LOCK TABLES `cmf_portal_post` WRITE;
/*!40000 ALTER TABLE `cmf_portal_post` DISABLE KEYS */;

INSERT INTO `cmf_portal_post` (`id`, `parent_id`, `post_type`, `post_format`, `user_id`, `post_status`, `comment_status`, `is_top`, `recommended`, `post_hits`, `post_like`, `comment_count`, `create_time`, `update_time`, `published_time`, `delete_time`, `post_title`, `post_keywords`, `post_excerpt`, `post_source`, `post_content`, `post_content_filtered`, `more`)
VALUES
	(32,0,1,1,1,1,1,1,1,28,2,0,1500891592,1502173501,1500890880,0,'如何下载拉卡拉手机收款宝客户端','下载客户端,客户端,拉卡拉手机收款宝客户端,收款宝客户端','','','\n&lt;ol class=&quot; list-paddingleft-2&quot; style=&quot;list-style-type: decimal;&quot;&gt;\n&lt;li&gt;&lt;p&gt;苹果手机请打开 appstore 搜索 拉卡拉收款宝 即可获取&lt;img src=&quot;20170724/c5fb5e3cc9fd29aba9d71429e7786da4.jpeg&quot; title=&quot;WechatIMG58.jpeg&quot; alt=&quot;WechatIMG58.jpeg&quot;&gt;&lt;/p&gt;&lt;/li&gt;\n&lt;li&gt;&lt;p&gt;Android 手机可打开各大应用商店如 &lt;span style=\'color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, Verdana, Arial; background-color: rgb(255, 255, 255);\'&gt;360手机助手、百度手机助手、应用宝、豌豆荚 等 搜索 拉卡拉收款宝 即可获得&lt;/span&gt;&lt;/p&gt;&lt;/li&gt;\n&lt;li&gt;&lt;p&gt;&lt;span style=\'color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, Verdana, Arial; background-color: rgb(255, 255, 255);\'&gt;手机访问此网址自动获取 &lt;a href=&quot;http://spi.lakala.com/wechat/weixin/download/downloadClient.do&quot; target=&quot;_self&quot;&gt;http://spi.lakala.com/wechat/weixin/download/downloadClient.do&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;&lt;/li&gt;\n&lt;/ol&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n',NULL,'{\"thumbnail\":\"portal\\/20170725\\/a165af65bc5f159cac2dcbbe771d40b2.png\",\"template\":\"\"}'),
	(33,0,1,1,1,1,1,1,0,0,0,0,1501758736,1504938237,1501758720,1504938246,'test','t','','','&lt;p&gt;haha&lt;/p&gt;',NULL,'{\"thumbnail\":\"\",\"template\":\"\"}'),
	(35,0,1,1,1,1,1,0,0,4,0,0,1502173473,1502173486,1502173440,0,'2','','','','&lt;p&gt;2&lt;/p&gt;',NULL,'{\"thumbnail\":\"\",\"template\":\"\"}'),
	(44,0,1,1,1,1,1,0,0,12,0,0,1502173460,1504938220,1502173380,0,'拉布拉卡新手入门','','','','&lt;p&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;移动收款 有卡即付 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;支持带有银联标识的借记卡，信用卡，磁条卡 &lt;/span&gt;&lt;br style=&quot;box-sizing: border-box; color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(101, 101, 101); font-family: Lato, sans-serif; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);&quot;&gt;收款账户自主设定，直接进入个人储蓄账户&lt;/span&gt;&lt;/p&gt;',NULL,'{\"thumbnail\":\"\",\"template\":\"\"}'),
	(45,0,1,1,1,1,1,1,0,0,0,0,1504162949,1504162949,1504162935,1504937285,'test','','','','&lt;p&gt;asdf&lt;/p&gt;',NULL,'{\"thumbnail\":\"\",\"template\":\"\"}');

/*!40000 ALTER TABLE `cmf_portal_post` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_portal_tag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_portal_tag`;

CREATE TABLE `cmf_portal_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `recommended` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐;1:推荐;0:不推荐',
  `post_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '标签文章数',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标签名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章标签表';

LOCK TABLES `cmf_portal_tag` WRITE;
/*!40000 ALTER TABLE `cmf_portal_tag` DISABLE KEYS */;

INSERT INTO `cmf_portal_tag` (`id`, `status`, `recommended`, `post_count`, `name`)
VALUES
	(4,1,0,0,'下载客户端'),
	(5,1,0,0,'客户端'),
	(6,1,0,0,'拉卡拉手机收款宝客户端'),
	(7,1,0,0,'收款宝客户端'),
	(8,1,0,0,'t');

/*!40000 ALTER TABLE `cmf_portal_tag` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_portal_tag_post
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_portal_tag_post`;

CREATE TABLE `cmf_portal_tag_post` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tag_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '标签 id',
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文章 id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布',
  PRIMARY KEY (`id`),
  KEY `term_taxonomy_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 标签文章对应表';

LOCK TABLES `cmf_portal_tag_post` WRITE;
/*!40000 ALTER TABLE `cmf_portal_tag_post` DISABLE KEYS */;

INSERT INTO `cmf_portal_tag_post` (`id`, `tag_id`, `post_id`, `status`)
VALUES
	(1,4,32,1),
	(2,5,32,1),
	(3,6,32,1),
	(4,7,32,1),
	(5,8,33,1);

/*!40000 ALTER TABLE `cmf_portal_tag_post` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_pos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_pos`;

CREATE TABLE `cmf_pos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) NOT NULL COMMENT '机具号',
  `uid` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `cid` bigint(20) NOT NULL DEFAULT '0' COMMENT '下级id',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '机器状态:0无；1绑定商户；2激活',
  `detail` varchar(300) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='pos表';

LOCK TABLES `cmf_pos` WRITE;
/*!40000 ALTER TABLE `cmf_pos` DISABLE KEYS */;

INSERT INTO `cmf_pos` (`id`, `code`, `uid`, `cid`, `time`, `status`, `detail`)
VALUES
	(6,'CBC3A3B203076229',2,4,1502939785,2,NULL),
	(7,'CBC3A3B203076230',4,0,0,2,NULL),
	(8,'CBC3A3B203076231',5,0,1502881855,2,NULL),
	(9,'CBC3A3B203076215',5,0,0,2,NULL),
	(10,'CBC3A3B203076216',4,0,0,2,NULL),
	(11,'CBC3A3B203076217',0,0,1502939871,0,NULL),
	(12,'CBC3A3B203076218',0,0,0,0,NULL),
	(14,'CBC3A3B203076220',7,0,0,2,NULL),
	(15,'CBC3A3B203076221',0,0,0,0,NULL),
	(16,'CBC3A3B203076222',0,0,0,0,NULL),
	(17,'CBC3A3B203076223',0,0,0,0,NULL);

/*!40000 ALTER TABLE `cmf_pos` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_pos_request
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_pos_request`;

CREATE TABLE `cmf_pos_request` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) NOT NULL COMMENT '机具号',
  `uid` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `type` char(20) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '机器状态:0无；1开通商户；2激活',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='pos请求表';

LOCK TABLES `cmf_pos_request` WRITE;
/*!40000 ALTER TABLE `cmf_pos_request` DISABLE KEYS */;

INSERT INTO `cmf_pos_request` (`id`, `code`, `uid`, `type`, `time`, `status`)
VALUES
	(1,'CBC3A3B203076216',4,'active',1504010580,1);

/*!40000 ALTER TABLE `cmf_pos_request` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_recycle_bin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_recycle_bin`;

CREATE TABLE `cmf_recycle_bin` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(11) DEFAULT '0' COMMENT '删除内容 id',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  `table_name` varchar(60) DEFAULT '' COMMENT '删除内容所在表名',
  `name` varchar(255) DEFAULT '' COMMENT '删除内容名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT=' 回收站';

LOCK TABLES `cmf_recycle_bin` WRITE;
/*!40000 ALTER TABLE `cmf_recycle_bin` DISABLE KEYS */;

INSERT INTO `cmf_recycle_bin` (`id`, `object_id`, `create_time`, `table_name`, `name`)
VALUES
	(1,33,1501758751,'portal_post','test'),
	(2,45,1504937285,'portal_post','test'),
	(3,33,1504938246,'portal_post','test');

/*!40000 ALTER TABLE `cmf_recycle_bin` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_role`;

CREATE TABLE `cmf_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父角色ID',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态;0:禁用;1:正常',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `list_order` float NOT NULL DEFAULT '0' COMMENT '排序',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `parentId` (`parent_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

LOCK TABLES `cmf_role` WRITE;
/*!40000 ALTER TABLE `cmf_role` DISABLE KEYS */;

INSERT INTO `cmf_role` (`id`, `parent_id`, `status`, `create_time`, `update_time`, `list_order`, `name`, `remark`)
VALUES
	(1,0,1,1329633709,1329633709,0,'超级管理员','拥有网站最高管理员权限！'),
	(2,0,1,1329633709,1329633709,0,'代理商','非直签小代理'),
	(3,0,1,0,0,0,'大代理','直签大代理商');

/*!40000 ALTER TABLE `cmf_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_role_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_role_user`;

CREATE TABLE `cmf_role_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色 id',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  PRIMARY KEY (`id`),
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色对应表';

LOCK TABLES `cmf_role_user` WRITE;
/*!40000 ALTER TABLE `cmf_role_user` DISABLE KEYS */;

INSERT INTO `cmf_role_user` (`id`, `role_id`, `user_id`)
VALUES
	(2,2,3),
	(3,2,10),
	(4,2,11);

/*!40000 ALTER TABLE `cmf_role_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_route
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_route`;

CREATE TABLE `cmf_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '路由id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态;1:启用,0:不启用',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'URL规则类型;1:用户自定义;2:别名添加',
  `full_url` varchar(255) NOT NULL DEFAULT '' COMMENT '完整url',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '实际显示的url',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='url路由表';

LOCK TABLES `cmf_route` WRITE;
/*!40000 ALTER TABLE `cmf_route` DISABLE KEYS */;

INSERT INTO `cmf_route` (`id`, `list_order`, `status`, `type`, `full_url`, `url`)
VALUES
	(12,5000,1,2,'portal/List/index?id=8','faq'),
	(13,4999,1,2,'portal/Article/index?cid=8','faq/:id'),
	(14,5000,1,2,'portal/List/index?id=9','notice'),
	(15,4999,1,2,'portal/Article/index?cid=9','notice/:id');

/*!40000 ALTER TABLE `cmf_route` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_slide
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_slide`;

CREATE TABLE `cmf_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:显示,0不显示',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `name` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '幻灯片分类',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '分类备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='幻灯片表';



# Dump of table cmf_slide_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_slide_item`;

CREATE TABLE `cmf_slide_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slide_id` int(11) NOT NULL DEFAULT '0' COMMENT '幻灯片id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:显示;0:隐藏',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '幻灯片名称',
  `image` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '幻灯片图片',
  `url` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '幻灯片链接',
  `target` varchar(10) NOT NULL DEFAULT '' COMMENT '友情链接打开方式',
  `description` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '幻灯片描述',
  `content` text CHARACTER SET utf8 COMMENT '幻灯片内容',
  `more` text COMMENT '链接打开方式',
  PRIMARY KEY (`id`),
  KEY `slide_cid` (`slide_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='幻灯片子项表';



# Dump of table cmf_theme
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_theme`;

CREATE TABLE `cmf_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后升级时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '模板状态,1:正在使用;0:未使用',
  `is_compiled` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否为已编译模板',
  `theme` varchar(20) NOT NULL DEFAULT '' COMMENT '主题目录名，用于主题的维一标识',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '主题名称',
  `version` varchar(20) NOT NULL DEFAULT '' COMMENT '主题版本号',
  `demo_url` varchar(50) NOT NULL DEFAULT '' COMMENT '演示地址，带协议',
  `thumbnail` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `author` varchar(20) NOT NULL DEFAULT '' COMMENT '主题作者',
  `author_url` varchar(50) NOT NULL DEFAULT '' COMMENT '作者网站链接',
  `lang` varchar(10) NOT NULL DEFAULT '' COMMENT '支持语言',
  `keywords` varchar(50) NOT NULL DEFAULT '' COMMENT '主题关键字',
  `description` varchar(100) NOT NULL DEFAULT '' COMMENT '主题描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `cmf_theme` WRITE;
/*!40000 ALTER TABLE `cmf_theme` DISABLE KEYS */;

INSERT INTO `cmf_theme` (`id`, `create_time`, `update_time`, `status`, `is_compiled`, `theme`, `name`, `version`, `demo_url`, `thumbnail`, `author`, `author_url`, `lang`, `keywords`, `description`)
VALUES
	(19,0,0,0,0,'simpleboot3','simpleboot3','1.0.2','http://demo.thinkcmf.com','','ThinkCMF','http://www.thinkcmf.com','zh-cn','ThinkCMF模板','ThinkCMF默认模板');

/*!40000 ALTER TABLE `cmf_theme` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_theme_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_theme_file`;

CREATE TABLE `cmf_theme_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_public` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否公共的模板文件',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `theme` varchar(20) NOT NULL DEFAULT '' COMMENT '模板名称',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '模板文件名',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '操作',
  `file` varchar(50) NOT NULL DEFAULT '' COMMENT '模板文件，相对于模板根目录，如Portal/index.html',
  `description` varchar(100) NOT NULL DEFAULT '' COMMENT '模板文件描述',
  `more` text COMMENT '模板更多配置,用户自己后台设置的',
  `config_more` text COMMENT '模板更多配置,来源模板的配置文件',
  `draft_more` text COMMENT '模板更多配置,用户临时保存的配置',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `cmf_theme_file` WRITE;
/*!40000 ALTER TABLE `cmf_theme_file` DISABLE KEYS */;

INSERT INTO `cmf_theme_file` (`id`, `is_public`, `list_order`, `theme`, `name`, `action`, `file`, `description`, `more`, `config_more`, `draft_more`)
VALUES
	(105,0,10,'simpleboot3','文章页','portal/Article/index','portal/article','文章页模板文件','{\"vars\":{\"hot_articles_category_id\":{\"title\":\"Hot Articles\\u5206\\u7c7bID\",\"name\":\"hot_articles_category_id\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}','{\"vars\":{\"hot_articles_category_id\":{\"title\":\"Hot Articles\\u5206\\u7c7bID\",\"name\":\"hot_articles_category_id\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}',NULL),
	(106,0,10,'simpleboot3','联系我们页','portal/Page/index','portal/contact','联系我们页模板文件','{\"vars\":{\"baidu_map_info_window_text\":{\"title\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57\",\"name\":\"baidu_map_info_window_text\",\"value\":\"ThinkCMF<br\\/><span class=\'\'>\\u5730\\u5740\\uff1a\\u4e0a\\u6d77\\u5e02\\u5f90\\u6c47\\u533a\\u659c\\u571f\\u8def2601\\u53f7<\\/span>\",\"type\":\"text\",\"tip\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57,\\u652f\\u6301\\u7b80\\u5355html\\u4ee3\\u7801\",\"rule\":[]},\"company_location\":{\"title\":\"\\u516c\\u53f8\\u5750\\u6807\",\"value\":\"\",\"type\":\"location\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_cn\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\",\"value\":\"\\u4e0a\\u6d77\\u5e02\\u5f90\\u6c47\\u533a\\u659c\\u571f\\u8def0001\\u53f7\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_en\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"NO.0001 Xie Tu Road, Shanghai China\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"email\":{\"title\":\"\\u516c\\u53f8\\u90ae\\u7bb1\",\"value\":\"catman@thinkcmf.com\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_cn\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\",\"value\":\"021 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_en\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"+8621 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"qq\":{\"title\":\"\\u8054\\u7cfbQQ\",\"value\":\"478519726\",\"type\":\"text\",\"tip\":\"\\u591a\\u4e2a QQ\\u4ee5\\u82f1\\u6587\\u9017\\u53f7\\u9694\\u5f00\",\"rule\":{\"require\":true}}}}','{\"vars\":{\"baidu_map_info_window_text\":{\"title\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57\",\"name\":\"baidu_map_info_window_text\",\"value\":\"ThinkCMF<br\\/><span class=\'\'>\\u5730\\u5740\\uff1a\\u4e0a\\u6d77\\u5e02\\u5f90\\u6c47\\u533a\\u659c\\u571f\\u8def2601\\u53f7<\\/span>\",\"type\":\"text\",\"tip\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57,\\u652f\\u6301\\u7b80\\u5355html\\u4ee3\\u7801\",\"rule\":[]},\"company_location\":{\"title\":\"\\u516c\\u53f8\\u5750\\u6807\",\"value\":\"\",\"type\":\"location\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_cn\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\",\"value\":\"\\u4e0a\\u6d77\\u5e02\\u5f90\\u6c47\\u533a\\u659c\\u571f\\u8def0001\\u53f7\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_en\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"NO.0001 Xie Tu Road, Shanghai China\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"email\":{\"title\":\"\\u516c\\u53f8\\u90ae\\u7bb1\",\"value\":\"catman@thinkcmf.com\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_cn\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\",\"value\":\"021 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_en\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"+8621 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"qq\":{\"title\":\"\\u8054\\u7cfbQQ\",\"value\":\"478519726\",\"type\":\"text\",\"tip\":\"\\u591a\\u4e2a QQ\\u4ee5\\u82f1\\u6587\\u9017\\u53f7\\u9694\\u5f00\",\"rule\":{\"require\":true}}}}',NULL),
	(113,0,5,'simpleboot3','首页','portal/Index/index','portal/index','首页模板文件','{\"vars\":{\"top_slide\":{\"title\":\"\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"admin\\/Slide\\/index\",\"multi\":false},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"tip\":\"\",\"rule\":{\"require\":true}}},\"widgets\":{\"features\":{\"title\":\"\\u5feb\\u901f\\u4e86\\u89e3ThinkCMF\",\"display\":\"1\",\"vars\":{\"sub_title\":{\"title\":\"\\u526f\\u6807\\u9898\",\"value\":\"Quickly understand the ThinkCMF\",\"type\":\"text\",\"placeholder\":\"\\u8bf7\\u8f93\\u5165\\u526f\\u6807\\u9898\",\"tip\":\"\",\"rule\":{\"require\":true}},\"features\":{\"title\":\"\\u7279\\u6027\\u4ecb\\u7ecd\",\"value\":[{\"title\":\"MVC\\u5206\\u5c42\\u6a21\\u5f0f\",\"icon\":\"bars\",\"content\":\"\\u4f7f\\u7528MVC\\u5e94\\u7528\\u7a0b\\u5e8f\\u88ab\\u5206\\u6210\\u4e09\\u4e2a\\u6838\\u5fc3\\u90e8\\u4ef6\\uff1a\\u6a21\\u578b\\uff08M\\uff09\\u3001\\u89c6\\u56fe\\uff08V\\uff09\\u3001\\u63a7\\u5236\\u5668\\uff08C\\uff09\\uff0c\\u4ed6\\u4e0d\\u662f\\u4e00\\u4e2a\\u65b0\\u7684\\u6982\\u5ff5\\uff0c\\u53ea\\u662fThinkCMF\\u5c06\\u5176\\u53d1\\u6325\\u5230\\u4e86\\u6781\\u81f4\\u3002\"},{\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"icon\":\"group\",\"content\":\"ThinkCMF\\u5185\\u7f6e\\u4e86\\u7075\\u6d3b\\u7684\\u7528\\u6237\\u7ba1\\u7406\\u65b9\\u5f0f\\uff0c\\u5e76\\u53ef\\u76f4\\u63a5\\u4e0e\\u7b2c\\u4e09\\u65b9\\u7ad9\\u70b9\\u8fdb\\u884c\\u4e92\\u8054\\u4e92\\u901a\\uff0c\\u5982\\u679c\\u4f60\\u613f\\u610f\\u751a\\u81f3\\u53ef\\u4ee5\\u5bf9\\u5355\\u4e2a\\u7528\\u6237\\u6216\\u7fa4\\u4f53\\u7528\\u6237\\u7684\\u884c\\u4e3a\\u8fdb\\u884c\\u8bb0\\u5f55\\u53ca\\u5206\\u4eab\\uff0c\\u4e3a\\u60a8\\u7684\\u8fd0\\u8425\\u51b3\\u7b56\\u63d0\\u4f9b\\u6709\\u6548\\u53c2\\u8003\\u6570\\u636e\\u3002\"},{\"title\":\"\\u4e91\\u7aef\\u90e8\\u7f72\",\"icon\":\"cloud\",\"content\":\"\\u901a\\u8fc7\\u9a71\\u52a8\\u7684\\u65b9\\u5f0f\\u53ef\\u4ee5\\u8f7b\\u677e\\u652f\\u6301\\u4e91\\u5e73\\u53f0\\u7684\\u90e8\\u7f72\\uff0c\\u8ba9\\u4f60\\u7684\\u7f51\\u7ad9\\u65e0\\u7f1d\\u8fc1\\u79fb\\uff0c\\u5185\\u7f6e\\u5df2\\u7ecf\\u652f\\u6301SAE\\u3001BAE\\uff0c\\u6b63\\u5f0f\\u7248\\u5c06\\u5bf9\\u4e91\\u7aef\\u90e8\\u7f72\\u8fdb\\u884c\\u8fdb\\u4e00\\u6b65\\u4f18\\u5316\\u3002\"},{\"title\":\"\\u5b89\\u5168\\u7b56\\u7565\",\"icon\":\"heart\",\"content\":\"\\u63d0\\u4f9b\\u7684\\u7a33\\u5065\\u7684\\u5b89\\u5168\\u7b56\\u7565\\uff0c\\u5305\\u62ec\\u5907\\u4efd\\u6062\\u590d\\uff0c\\u5bb9\\u9519\\uff0c\\u9632\\u6cbb\\u6076\\u610f\\u653b\\u51fb\\u767b\\u9646\\uff0c\\u7f51\\u9875\\u9632\\u7be1\\u6539\\u7b49\\u591a\\u9879\\u5b89\\u5168\\u7ba1\\u7406\\u529f\\u80fd\\uff0c\\u4fdd\\u8bc1\\u7cfb\\u7edf\\u5b89\\u5168\\uff0c\\u53ef\\u9760\\uff0c\\u7a33\\u5b9a\\u7684\\u8fd0\\u884c\\u3002\"},{\"title\":\"\\u5e94\\u7528\\u6a21\\u5757\\u5316\",\"icon\":\"cubes\",\"content\":\"\\u63d0\\u51fa\\u5168\\u65b0\\u7684\\u5e94\\u7528\\u6a21\\u5f0f\\u8fdb\\u884c\\u6269\\u5c55\\uff0c\\u4e0d\\u7ba1\\u662f\\u4f60\\u5f00\\u53d1\\u4e00\\u4e2a\\u5c0f\\u529f\\u80fd\\u8fd8\\u662f\\u4e00\\u4e2a\\u5168\\u65b0\\u7684\\u7ad9\\u70b9\\uff0c\\u5728ThinkCMF\\u4e2d\\u4f60\\u53ea\\u662f\\u589e\\u52a0\\u4e86\\u4e00\\u4e2aAPP\\uff0c\\u6bcf\\u4e2a\\u72ec\\u7acb\\u8fd0\\u884c\\u4e92\\u4e0d\\u5f71\\u54cd\\uff0c\\u4fbf\\u4e8e\\u7075\\u6d3b\\u6269\\u5c55\\u548c\\u4e8c\\u6b21\\u5f00\\u53d1\\u3002\"},{\"title\":\"\\u514d\\u8d39\\u5f00\\u6e90\",\"icon\":\"certificate\",\"content\":\"\\u4ee3\\u7801\\u9075\\u5faaApache2\\u5f00\\u6e90\\u534f\\u8bae\\uff0c\\u514d\\u8d39\\u4f7f\\u7528\\uff0c\\u5bf9\\u5546\\u4e1a\\u7528\\u6237\\u4e5f\\u65e0\\u4efb\\u4f55\\u9650\\u5236\\u3002\"}],\"type\":\"array\",\"item\":{\"title\":{\"title\":\"\\u6807\\u9898\",\"value\":\"\",\"type\":\"text\",\"rule\":{\"require\":true}},\"icon\":{\"title\":\"\\u56fe\\u6807\",\"value\":\"\",\"type\":\"text\"},\"content\":{\"title\":\"\\u63cf\\u8ff0\",\"value\":\"\",\"type\":\"textarea\"}},\"tip\":\"\"}}},\"last_news\":{\"title\":\"\\u6700\\u65b0\\u8d44\\u8baf\",\"display\":\"1\",\"vars\":{\"last_news_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}','{\"vars\":{\"top_slide\":{\"title\":\"\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"admin\\/Slide\\/index\",\"multi\":false},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"tip\":\"\",\"rule\":{\"require\":true}}},\"widgets\":{\"features\":{\"title\":\"\\u5feb\\u901f\\u4e86\\u89e3ThinkCMF\",\"display\":\"1\",\"vars\":{\"sub_title\":{\"title\":\"\\u526f\\u6807\\u9898\",\"value\":\"Quickly understand the ThinkCMF\",\"type\":\"text\",\"placeholder\":\"\\u8bf7\\u8f93\\u5165\\u526f\\u6807\\u9898\",\"tip\":\"\",\"rule\":{\"require\":true}},\"features\":{\"title\":\"\\u7279\\u6027\\u4ecb\\u7ecd\",\"value\":[{\"title\":\"MVC\\u5206\\u5c42\\u6a21\\u5f0f\",\"icon\":\"bars\",\"content\":\"\\u4f7f\\u7528MVC\\u5e94\\u7528\\u7a0b\\u5e8f\\u88ab\\u5206\\u6210\\u4e09\\u4e2a\\u6838\\u5fc3\\u90e8\\u4ef6\\uff1a\\u6a21\\u578b\\uff08M\\uff09\\u3001\\u89c6\\u56fe\\uff08V\\uff09\\u3001\\u63a7\\u5236\\u5668\\uff08C\\uff09\\uff0c\\u4ed6\\u4e0d\\u662f\\u4e00\\u4e2a\\u65b0\\u7684\\u6982\\u5ff5\\uff0c\\u53ea\\u662fThinkCMF\\u5c06\\u5176\\u53d1\\u6325\\u5230\\u4e86\\u6781\\u81f4\\u3002\"},{\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"icon\":\"group\",\"content\":\"ThinkCMF\\u5185\\u7f6e\\u4e86\\u7075\\u6d3b\\u7684\\u7528\\u6237\\u7ba1\\u7406\\u65b9\\u5f0f\\uff0c\\u5e76\\u53ef\\u76f4\\u63a5\\u4e0e\\u7b2c\\u4e09\\u65b9\\u7ad9\\u70b9\\u8fdb\\u884c\\u4e92\\u8054\\u4e92\\u901a\\uff0c\\u5982\\u679c\\u4f60\\u613f\\u610f\\u751a\\u81f3\\u53ef\\u4ee5\\u5bf9\\u5355\\u4e2a\\u7528\\u6237\\u6216\\u7fa4\\u4f53\\u7528\\u6237\\u7684\\u884c\\u4e3a\\u8fdb\\u884c\\u8bb0\\u5f55\\u53ca\\u5206\\u4eab\\uff0c\\u4e3a\\u60a8\\u7684\\u8fd0\\u8425\\u51b3\\u7b56\\u63d0\\u4f9b\\u6709\\u6548\\u53c2\\u8003\\u6570\\u636e\\u3002\"},{\"title\":\"\\u4e91\\u7aef\\u90e8\\u7f72\",\"icon\":\"cloud\",\"content\":\"\\u901a\\u8fc7\\u9a71\\u52a8\\u7684\\u65b9\\u5f0f\\u53ef\\u4ee5\\u8f7b\\u677e\\u652f\\u6301\\u4e91\\u5e73\\u53f0\\u7684\\u90e8\\u7f72\\uff0c\\u8ba9\\u4f60\\u7684\\u7f51\\u7ad9\\u65e0\\u7f1d\\u8fc1\\u79fb\\uff0c\\u5185\\u7f6e\\u5df2\\u7ecf\\u652f\\u6301SAE\\u3001BAE\\uff0c\\u6b63\\u5f0f\\u7248\\u5c06\\u5bf9\\u4e91\\u7aef\\u90e8\\u7f72\\u8fdb\\u884c\\u8fdb\\u4e00\\u6b65\\u4f18\\u5316\\u3002\"},{\"title\":\"\\u5b89\\u5168\\u7b56\\u7565\",\"icon\":\"heart\",\"content\":\"\\u63d0\\u4f9b\\u7684\\u7a33\\u5065\\u7684\\u5b89\\u5168\\u7b56\\u7565\\uff0c\\u5305\\u62ec\\u5907\\u4efd\\u6062\\u590d\\uff0c\\u5bb9\\u9519\\uff0c\\u9632\\u6cbb\\u6076\\u610f\\u653b\\u51fb\\u767b\\u9646\\uff0c\\u7f51\\u9875\\u9632\\u7be1\\u6539\\u7b49\\u591a\\u9879\\u5b89\\u5168\\u7ba1\\u7406\\u529f\\u80fd\\uff0c\\u4fdd\\u8bc1\\u7cfb\\u7edf\\u5b89\\u5168\\uff0c\\u53ef\\u9760\\uff0c\\u7a33\\u5b9a\\u7684\\u8fd0\\u884c\\u3002\"},{\"title\":\"\\u5e94\\u7528\\u6a21\\u5757\\u5316\",\"icon\":\"cubes\",\"content\":\"\\u63d0\\u51fa\\u5168\\u65b0\\u7684\\u5e94\\u7528\\u6a21\\u5f0f\\u8fdb\\u884c\\u6269\\u5c55\\uff0c\\u4e0d\\u7ba1\\u662f\\u4f60\\u5f00\\u53d1\\u4e00\\u4e2a\\u5c0f\\u529f\\u80fd\\u8fd8\\u662f\\u4e00\\u4e2a\\u5168\\u65b0\\u7684\\u7ad9\\u70b9\\uff0c\\u5728ThinkCMF\\u4e2d\\u4f60\\u53ea\\u662f\\u589e\\u52a0\\u4e86\\u4e00\\u4e2aAPP\\uff0c\\u6bcf\\u4e2a\\u72ec\\u7acb\\u8fd0\\u884c\\u4e92\\u4e0d\\u5f71\\u54cd\\uff0c\\u4fbf\\u4e8e\\u7075\\u6d3b\\u6269\\u5c55\\u548c\\u4e8c\\u6b21\\u5f00\\u53d1\\u3002\"},{\"title\":\"\\u514d\\u8d39\\u5f00\\u6e90\",\"icon\":\"certificate\",\"content\":\"\\u4ee3\\u7801\\u9075\\u5faaApache2\\u5f00\\u6e90\\u534f\\u8bae\\uff0c\\u514d\\u8d39\\u4f7f\\u7528\\uff0c\\u5bf9\\u5546\\u4e1a\\u7528\\u6237\\u4e5f\\u65e0\\u4efb\\u4f55\\u9650\\u5236\\u3002\"}],\"type\":\"array\",\"item\":{\"title\":{\"title\":\"\\u6807\\u9898\",\"value\":\"\",\"type\":\"text\",\"rule\":{\"require\":true}},\"icon\":{\"title\":\"\\u56fe\\u6807\",\"value\":\"\",\"type\":\"text\"},\"content\":{\"title\":\"\\u63cf\\u8ff0\",\"value\":\"\",\"type\":\"textarea\"}},\"tip\":\"\"}}},\"last_news\":{\"title\":\"\\u6700\\u65b0\\u8d44\\u8baf\",\"display\":\"1\",\"vars\":{\"last_news_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}',NULL),
	(108,0,10,'simpleboot3','文章列表页','portal/List/index','portal/list','文章列表模板文件','{\"vars\":[],\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}','{\"vars\":[],\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}',NULL),
	(109,0,10,'simpleboot3','单页面','portal/Page/index','portal/page','单页面模板文件','{\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}','{\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}',NULL),
	(110,0,10,'simpleboot3','搜索页面','portal/search/index','portal/search','搜索模板文件','{\"vars\":{\"varName1\":{\"title\":\"\\u70ed\\u95e8\\u641c\\u7d22\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\\u8fd9\\u662f\\u4e00\\u4e2atext\",\"rule\":{\"require\":true}}}}','{\"vars\":{\"varName1\":{\"title\":\"\\u70ed\\u95e8\\u641c\\u7d22\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\\u8fd9\\u662f\\u4e00\\u4e2atext\",\"rule\":{\"require\":true}}}}',NULL),
	(111,1,0,'simpleboot3','模板全局配置','public/Config','public/config','模板全局配置文件','{\"vars\":{\"enable_mobile\":{\"title\":\"\\u624b\\u673a\\u6ce8\\u518c\",\"value\":\"1\",\"type\":\"select\",\"options\":{\"1\":\"\\u5f00\\u542f\",\"0\":\"\\u5173\\u95ed\"},\"tip\":\"\"}}}','{\"vars\":{\"enable_mobile\":{\"title\":\"\\u624b\\u673a\\u6ce8\\u518c\",\"value\":1,\"type\":\"select\",\"options\":{\"1\":\"\\u5f00\\u542f\",\"0\":\"\\u5173\\u95ed\"},\"tip\":\"\"}}}',NULL),
	(112,1,1,'simpleboot3','导航条','public/Nav','public/nav','导航条模板文件','{\"vars\":{\"company_name\":{\"title\":\"\\u516c\\u53f8\\u540d\\u79f0\",\"name\":\"company_name\",\"value\":\"\\u62c9\\u5e03\\u62c9\\u5361\\u4e91\\u9500\\u552e\\u7cfb\\u7edf\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}','{\"vars\":{\"company_name\":{\"title\":\"\\u516c\\u53f8\\u540d\\u79f0\",\"name\":\"company_name\",\"value\":\"ThinkCMF\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}',NULL);

/*!40000 ALTER TABLE `cmf_theme_file` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_third_party_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_third_party_user`;

CREATE TABLE `cmf_third_party_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '本站用户id',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'access_token过期时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '绑定时间',
  `login_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:正常;0:禁用',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `third_party` varchar(20) NOT NULL DEFAULT '' COMMENT '第三方惟一码',
  `app_id` varchar(64) NOT NULL DEFAULT '' COMMENT '第三方应用 id',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `access_token` varchar(512) NOT NULL DEFAULT '' COMMENT '第三方授权码',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '第三方用户id',
  `union_id` varchar(64) NOT NULL DEFAULT '' COMMENT '第三方用户多个产品中的惟一 id,(如:微信平台)',
  `more` text COMMENT '扩展信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='第三方用户表';



# Dump of table cmf_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_user`;

CREATE TABLE `cmf_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) DEFAULT '0',
  `user_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '用户类型;1:admin;2:会员;3:高级会员',
  `sex` tinyint(2) NOT NULL DEFAULT '0' COMMENT '性别;0:保密,1:男,2:女',
  `birthday` int(11) NOT NULL DEFAULT '0' COMMENT '生日',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `coin` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '金币',
  `user_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常,2:未验证',
  `mobile` varchar(20) NOT NULL COMMENT '用户手机号',
  `user_login` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `user_pass` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码;cmf_password加密',
  `user_nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `user_email` varchar(100) NOT NULL DEFAULT '' COMMENT '用户登录邮箱',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `user_url` varchar(100) NOT NULL DEFAULT '' COMMENT '用户个人网址',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `signature` varchar(255) NOT NULL DEFAULT '' COMMENT '个性签名',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '' COMMENT '激活码',
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

LOCK TABLES `cmf_user` WRITE;
/*!40000 ALTER TABLE `cmf_user` DISABLE KEYS */;

INSERT INTO `cmf_user` (`id`, `pid`, `user_type`, `sex`, `birthday`, `score`, `coin`, `user_status`, `mobile`, `user_login`, `user_pass`, `user_nickname`, `user_email`, `last_login_time`, `create_time`, `user_url`, `avatar`, `signature`, `last_login_ip`, `user_activation_key`)
VALUES
	(1,0,1,0,-28800,0,50,1,'13320992099','admin','###a5228ff421be4db098ec769126e82c18','大管理','1@1.com',1507359877,1500713300,'','avatar/20170729/6ca9ba50ab039a165ab065e635692fdf.jpg','','0.0.0.0',''),
	(2,1,2,1,683737200,0,200,1,'13320990002','0002','###e323638c8b8965878d4249dc94ae8ece','小九','27427615@qq.com',1502164272,1501315365,'http://www.wtfree.com','avatar/20170803/93046ab7cb4f100ee2ebddd581352211.png','睡在哪里都是睡在夜里','0.0.0.0',''),
	(3,0,1,0,0,0,0,1,'','test','###e323638c8b8965878d4249dc94ae8ece','','2@1.com',1502087719,0,'','','','0.0.0.0',''),
	(4,2,2,0,659721600,0,0,1,'15281009455','9455','###e323638c8b8965878d4249dc94ae8ece','张小九','274276153@qq.com',1506190865,1502350288,'','avatar/20170811/026a8f087131f3ae72031c4d8f494fc8.jpg','睡在哪里都是睡在夜里，听迷雾的声音','0.0.0.0',''),
	(5,4,2,0,0,0,0,1,'15281009454','','###a82cab46a7fe23e2be4734cb0999c306','','',1502370774,1502370495,'','','','0.0.0.0',''),
	(6,4,2,0,0,0,0,1,'13320990006','','###e323638c8b8965878d4249dc94ae8ece','','',1502682872,1502682872,'','','','0.0.0.0',''),
	(7,5,2,0,0,0,1000,1,'13320990009','','###e323638c8b8965878d4249dc94ae8ece','','',1503387702,1502683168,'','','','0.0.0.0',''),
	(8,5,2,0,0,0,0,1,'13320999999','','','','',0,0,'','','','',''),
	(9,6,2,0,0,0,0,1,'199999','','','','',0,0,'','','','',''),
	(10,0,1,0,-28800,0,70,1,'','343044','###e323638c8b8965878d4249dc94ae8ece','','',1506187127,0,'','','','0.0.0.0',''),
	(11,0,1,0,0,0,0,1,'','353978','###e323638c8b8965878d4249dc94ae8ece','','',1506231476,0,'','','','0.0.0.0','');

/*!40000 ALTER TABLE `cmf_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_user_action_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_user_action_log`;

CREATE TABLE `cmf_user_action_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `last_visit_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后访问时间',
  `object` varchar(100) NOT NULL DEFAULT '' COMMENT '访问对象的id,格式:不带前缀的表名+id;如posts1表示xx_posts表里id为1的记录',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '操作名称;格式:应用名+控制器+操作名,也可自己定义格式只要不发生冲突且惟一;',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '用户ip',
  PRIMARY KEY (`id`),
  KEY `user_object_action` (`user_id`,`object`,`action`),
  KEY `user_object_action_ip` (`user_id`,`object`,`action`,`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='访问记录表';

LOCK TABLES `cmf_user_action_log` WRITE;
/*!40000 ALTER TABLE `cmf_user_action_log` DISABLE KEYS */;

INSERT INTO `cmf_user_action_log` (`id`, `user_id`, `count`, `last_visit_time`, `object`, `action`, `ip`)
VALUES
	(1,1,2,1501312246,'posts32','portal/Article/dolike','0.0.0.0'),
	(2,2,2,1502175572,'posts32','portal/Article/dolike','0.0.0.0');

/*!40000 ALTER TABLE `cmf_user_action_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_user_favorite
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_user_favorite`;

CREATE TABLE `cmf_user_favorite` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户 id',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '收藏内容的标题',
  `url` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '收藏内容的原文地址，不带域名',
  `description` varchar(500) CHARACTER SET utf8 DEFAULT '' COMMENT '收藏内容的描述',
  `table_name` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '收藏实体以前所在表,不带前缀',
  `object_id` int(10) unsigned DEFAULT '0' COMMENT '收藏内容原来的主键id',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '收藏时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户收藏表';

LOCK TABLES `cmf_user_favorite` WRITE;
/*!40000 ALTER TABLE `cmf_user_favorite` DISABLE KEYS */;

INSERT INTO `cmf_user_favorite` (`id`, `user_id`, `title`, `url`, `description`, `table_name`, `object_id`, `create_time`)
VALUES
	(1,2,'如何下载拉卡拉手机收款宝客户端','{\"action\":\"portal\\/Article\\/index\",\"param\":{\"id\":32,\"cid\":8}}','如何下载拉卡拉手机收款宝客户端','portal_post',32,1502164744);

/*!40000 ALTER TABLE `cmf_user_favorite` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_user_login_attempt
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_user_login_attempt`;

CREATE TABLE `cmf_user_login_attempt` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `login_attempts` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '尝试次数',
  `attempt_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '尝试登录时间',
  `locked_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '锁定时间',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '用户 ip',
  `account` varchar(100) NOT NULL DEFAULT '' COMMENT '用户账号,手机号,邮箱或用户名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='用户登录尝试表';



# Dump of table cmf_user_token
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_user_token`;

CREATE TABLE `cmf_user_token` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT ' 过期时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `token` varchar(64) NOT NULL DEFAULT '' COMMENT 'token',
  `device_type` varchar(10) NOT NULL DEFAULT '' COMMENT '设备类型;mobile,android,iphone,ipad,web,pc,mac,wxapp',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户客户端登录 token 表';

LOCK TABLES `cmf_user_token` WRITE;
/*!40000 ALTER TABLE `cmf_user_token` DISABLE KEYS */;

INSERT INTO `cmf_user_token` (`id`, `user_id`, `expire_time`, `create_time`, `token`, `device_type`)
VALUES
	(3,1,1522911877,1507359877,'2cb5d0a26113d82c21d69a1346cfbd8d5dfd5f30ea81c7f5c989a51f76171ab6','web'),
	(4,3,1517639719,1502087719,'d2ed0faa3a03f510633d8747bfaaa272d53ef5e1adfed785e1329d98e293b555','web'),
	(5,10,1521739127,1506187127,'d141c08ba8ef951ccf9dac54a2899c2ae2854c6c116504e3a583a8f92b541fe3','web'),
	(6,11,1521780363,1506228363,'39d3b0ecd91c50866d7137185aecb86179ddfae643b55eb2e83d20faa2071c1e','web');

/*!40000 ALTER TABLE `cmf_user_token` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cmf_verification_code
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cmf_verification_code`;

CREATE TABLE `cmf_verification_code` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '表id',
  `count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当天已经发送成功的次数',
  `send_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后发送成功时间',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '验证码过期时间',
  `code` varchar(8) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '最后发送成功的验证码',
  `account` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '手机号或者邮箱',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='手机邮箱数字验证码表';

LOCK TABLES `cmf_verification_code` WRITE;
/*!40000 ALTER TABLE `cmf_verification_code` DISABLE KEYS */;

INSERT INTO `cmf_verification_code` (`id`, `count`, `send_time`, `expire_time`, `code`, `account`)
VALUES
	(1,1,1503374406,1503376206,'472245','274276153@qq.com'),
	(2,4,1502368921,1502378921,'937542','15281009454'),
	(3,1,1503374346,1503376146,'949862','15281009455'),
	(4,1,1502682816,1502684616,'131781','13320990009');

/*!40000 ALTER TABLE `cmf_verification_code` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
