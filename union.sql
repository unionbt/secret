-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-10-05 18:03:24
-- 服务器版本： 5.6.21
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `union`
--

-- --------------------------------------------------------

--
-- 表的结构 `acc`
--

CREATE TABLE `acc` (
  `uid` int(20) NOT NULL COMMENT '谁的帐户信息',
  `acid` int(20) NOT NULL COMMENT '帐户的数据库唯一编码',
  `ac_moeny` double DEFAULT NULL COMMENT '余额',
  `ac_red` double DEFAULT NULL COMMENT '红包',
  `ac_juan` float DEFAULT NULL COMMENT '优惠券',
  `ac_bank` tinytext COMMENT '绑定的银行卡编码',
  `ac_tra` tinytext COMMENT '交易信息编码，用第一个字符、最高位表示交易类型是购物还是转帐'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `add`
--

CREATE TABLE `add` (
  `uid` int(20) NOT NULL COMMENT '谁的地址',
  `aid` int(20) NOT NULL COMMENT '地址的数据库唯一编码',
  `a_country` char(64) DEFAULT NULL COMMENT '国家',
  `a_pro` char(64) DEFAULT NULL COMMENT '省份',
  `a_city` char(64) DEFAULT NULL COMMENT '城市',
  `a_county` char(64) DEFAULT NULL COMMENT '县、区',
  `a_street` char(64) DEFAULT NULL COMMENT '街道',
  `a_post` int(8) DEFAULT NULL COMMENT '邮政编码',
  `a_name` char(64) DEFAULT NULL COMMENT '本地址联系人',
  `a_phone` int(16) DEFAULT NULL COMMENT '本地址联系电话'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(20) NOT NULL COMMENT '超级用户 iD',
  `admin_pass` char(32) NOT NULL COMMENT '超级用户密码',
  `admin_name` char(32) NOT NULL COMMENT '用户姓名',
  `admin_team` int(4) NOT NULL COMMENT '用户组，级别权限',
  `admin_pos` varchar(16) DEFAULT NULL COMMENT '用户职位',
  `admin_email` char(32) DEFAULT NULL COMMENT 'email',
  `admin_time` datetime NOT NULL COMMENT ' 创建时间',
  `admin_logoin_time` text COMMENT '每一次的登陆时间',
  `admin_logoin_ip` text COMMENT '每一次的登陆 ip',
  `admin_create` int(20) NOT NULL COMMENT '创建者admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `admin_moeny`
--

CREATE TABLE `admin_moeny` (
  `amid` int(30) NOT NULL COMMENT '总帐信息唯一编码',
  `am_type` int(20) DEFAULT NULL COMMENT '总帐发生类型，收入，支出佣金，用户提现，其它',
  `am_out` int(20) NOT NULL COMMENT '流出帐户',
  `am_in` int(20) NOT NULL COMMENT '流入帐户',
  `am_moeny` double NOT NULL COMMENT '发生金额',
  `am_ba` double NOT NULL COMMENT '总帐余额',
  `am_zhusi` text COMMENT '发生的摘要，也可以称为科目',
  `am_time` datetime NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bank`
--

CREATE TABLE `bank` (
  `uid` int(16) DEFAULT NULL COMMENT '谁创建了这张卡的银行信息',
  `bid` int(20) DEFAULT NULL COMMENT '这张卡的数据库编码',
  `bank` varchar(32) DEFAULT NULL COMMENT '开户银行',
  `bank_user` varchar(64) DEFAULT NULL COMMENT '户名',
  `bank_num` int(20) DEFAULT NULL COMMENT '卡号',
  `zhusi` text COMMENT '注释'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `db_id`
--

CREATE TABLE `db_id` (
  `id` int(16) DEFAULT NULL COMMENT '全局唯一自增 id',
  `num` int(16) DEFAULT NULL COMMENT '创建的随机数字帐号，它将会成为 uid,pid,bid,seid等数据库编码',
  `TYPE` varchar(256) DEFAULT NULL COMMENT '帐户类型',
  `make` text COMMENT '创建者',
  `TIME` datetime DEFAULT NULL COMMENT '创建时间',
  `zhusi` text COMMENT '注释'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `express`
--

CREATE TABLE `express` (
  `uid` int(20) NOT NULL COMMENT '谁创建了快递物流信息',
  `eid` int(20) DEFAULT NULL COMMENT '物流信息的数据库唯一编码',
  `o_no` int(32) NOT NULL COMMENT '订单编码',
  `e_name` varchar(64) NOT NULL COMMENT '快递公司名称',
  `e_num` int(16) NOT NULL COMMENT '物流单号',
  `e_time` datetime NOT NULL COMMENT '快递发货时间',
  `e_text` text NOT NULL COMMENT '快递跟进明细',
  `e_shop` varchar(64) DEFAULT NULL COMMENT '收货店家，也就是消费者提货点',
  `e_qr` varchar(64) DEFAULT NULL COMMENT '提货服务商家的 QR 二维码存放路径',
  `e_type` int(2) DEFAULT NULL COMMENT '真或假判断是快递到家还是服务商处提货',
  `e_ok` datetime DEFAULT NULL COMMENT '提货时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `image`
--

CREATE TABLE `image` (
  `uid` int(20) NOT NULL COMMENT '谁创建了图片信息',
  `iid` int(20) NOT NULL COMMENT '图片的数据库唯一编码',
  `i_one` varchar(64) DEFAULT NULL COMMENT '主图',
  `i_two` varchar(64) DEFAULT NULL COMMENT '图 2',
  `i_thr` varchar(64) DEFAULT NULL COMMENT '图 3',
  `i_fou` varchar(64) DEFAULT NULL COMMENT '图 4',
  `i_fir` varchar(64) DEFAULT NULL COMMENT '图 5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mission`
--

CREATE TABLE `mission` (
  `uid` int(20) NOT NULL COMMENT '谁的佣金',
  `mid` int(20) NOT NULL COMMENT '佣金的数据库唯一编码',
  `m_prod` char(64) DEFAULT NULL COMMENT '产品名称',
  `m_sum` float DEFAULT NULL COMMENT '订单金额',
  `m_ratio` float DEFAULT NULL COMMENT '佣金比率',
  `m_mission` float DEFAULT NULL COMMENT '佣金',
  `m_from` char(64) DEFAULT NULL COMMENT '支付方',
  `m_state` int(4) DEFAULT NULL COMMENT '佣金状态',
  `m_time` datetime NOT NULL COMMENT '时间节点'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `prod`
--

CREATE TABLE `prod` (
  `uid` int(20) NOT NULL COMMENT '谁创建了产品信息',
  `pid` int(20) DEFAULT NULL COMMENT '产品的数据库唯一编码',
  `p_name` varchar(64) NOT NULL COMMENT '产品名称',
  `p_pics` float NOT NULL COMMENT '产品价格',
  `p_mossion` float NOT NULL COMMENT '产品佣金比例',
  `p_type` int(4) NOT NULL COMMENT '产品类型',
  `p_img` text COMMENT '产品图片集，保存图片数据库唯一编码',
  `p_state` int(4) NOT NULL COMMENT '产品状态，库存？出售？审核？'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `real`
--

CREATE TABLE `real` (
  `uid` int(20) NOT NULL COMMENT '实名认证的帐户主体',
  `rid` int(20) NOT NULL COMMENT '实名认证的数据库唯一编码',
  `r_name` char(64) DEFAULT NULL COMMENT '真实姓名',
  `r_card_id` int(20) DEFAULT NULL COMMENT '身份证号',
  `r_card_img` char(64) DEFAULT NULL COMMENT '身份证图片正面',
  `r_card_img_2` char(64) DEFAULT NULL COMMENT '身份证图片反面',
  `r_time` datetime DEFAULT NULL COMMENT '提交认证时间',
  `r_check` char(32) NOT NULL COMMENT '审核人员',
  `r_ok` datetime DEFAULT NULL COMMENT '通过认证时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `real_shop`
--

CREATE TABLE `real_shop` (
  `uid` int(20) NOT NULL COMMENT '实名认证的帐户主体',
  `rid` int(20) NOT NULL COMMENT '实名认证的数据库唯一编码',
  `re_name` char(64) DEFAULT NULL COMMENT '认证的组织机构名称',
  `re_id` int(20) DEFAULT NULL COMMENT '营业执照号码',
  `re_team_id` char(20) DEFAULT NULL COMMENT '组织机构代码',
  `re_id_img` char(64) DEFAULT NULL COMMENT '营业执照照片',
  `re_team_img` char(64) DEFAULT NULL COMMENT '营业执照照片编码',
  `re_bank` int(20) DEFAULT NULL COMMENT '认证银行基本信息，存银行表编码',
  `re_check` char(32) NOT NULL COMMENT '审核人员',
  `re_ok` datetime DEFAULT NULL COMMENT '通过认证时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `service`
--

CREATE TABLE `service` (
  `uid` int(20) NOT NULL COMMENT '谁是服务商家的主体责任人',
  `seid` int(20) DEFAULT NULL COMMENT '服务商的的数据库唯一编码',
  `se_name` varchar(64) NOT NULL COMMENT '服务商家名称',
  `se_lev` int(4) DEFAULT NULL COMMENT '服务商级别，通过好评率累加',
  `se_add` tinytext NOT NULL COMMENT '服务商地址信息',
  `se_tel` int(16) NOT NULL COMMENT '电话',
  `se_phone` int(4) DEFAULT NULL COMMENT '手机',
  `se_sign` varchar(64) DEFAULT NULL COMMENT '服务商招牌图片存储路径',
  `se_img` text COMMENT '服务商图片集存储路径',
  `se_pro` tinytext COMMENT '产品状态，库存？出售？审核？',
  `se_long` float DEFAULT NULL COMMENT '地理位置坐标经度',
  `se_lati` float DEFAULT NULL COMMENT '地理位置坐标纬度'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `shop`
--

CREATE TABLE `shop` (
  `uid` int(20) NOT NULL COMMENT '谁的店铺',
  `sid` int(20) NOT NULL COMMENT '店铺的数据库唯一编码',
  `s_name` varchar(64) DEFAULT NULL COMMENT '店铺名称',
  `s_img` varchar(64) DEFAULT NULL COMMENT '店铺 logo 图标路径',
  `s_say` tinytext COMMENT '店铺说明',
  `s_type` tinytext COMMENT '店铺类目',
  `s_in_type` tinytext COMMENT '店内类目结构',
  `s_prod` text COMMENT '店内产品编码地址',
  `s_oid` mediumtext COMMENT '店铺产生的订单数据库编码',
  `s_lev` char(4) NOT NULL COMMENT '店铺级别',
  `s_time` datetime NOT NULL COMMENT '店铺创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `size`
--

CREATE TABLE `size` (
  `uid` int(20) NOT NULL COMMENT '谁的身材信息信息',
  `si_id` int(20) NOT NULL COMMENT '身材信息的数据库唯一编码',
  `si_zg` int(8) DEFAULT NULL COMMENT '总高',
  `si_sg` int(8) DEFAULT NULL COMMENT '身高',
  `si_xw` int(8) DEFAULT NULL COMMENT '胸围',
  `si_yw` int(8) DEFAULT NULL COMMENT '腰围',
  `si_tz` int(8) DEFAULT NULL COMMENT '体重',
  `si_bw` int(8) DEFAULT NULL COMMENT '脖围',
  `si_tw` int(8) DEFAULT NULL COMMENT '臀围',
  `si_zyw` int(8) DEFAULT NULL COMMENT '中腰围',
  `si_tgw` int(8) DEFAULT NULL COMMENT '臀根围',
  `si_qjk` int(8) DEFAULT NULL COMMENT '全肩宽',
  `si_bc` int(8) DEFAULT NULL COMMENT '背长',
  `si_bk` int(8) DEFAULT NULL COMMENT '背宽',
  `si_xc` int(8) DEFAULT NULL COMMENT ' 袖长',
  `si_bpk` int(8) DEFAULT NULL COMMENT 'bp宽',
  `si_bpg` int(8) DEFAULT NULL COMMENT 'bp高',
  `si_xk` int(8) DEFAULT NULL COMMENT '胸宽',
  `si_qsc` int(8) DEFAULT NULL COMMENT '前身长',
  `si_hsc` int(8) DEFAULT NULL COMMENT '后身长',
  `si_tt` tinytext COMMENT '体态',
  `si_who` int(20) NOT NULL COMMENT '量尺寸的服务商数据库编码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `team`
--

CREATE TABLE `team` (
  `uid` int(20) NOT NULL COMMENT '谁的组成员信息',
  `te_id` int(20) NOT NULL COMMENT '组成员信息数据库唯一编码',
  `t_uid` bigint(20) DEFAULT NULL COMMENT '小伙伴组成员的 uid 数据集，同时后面跟一个时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `trad`
--

CREATE TABLE `trad` (
  `uid` int(20) NOT NULL COMMENT '谁的帐的帐户交易信息',
  `tid` int(20) NOT NULL COMMENT '交易信息的数据库唯一编码',
  `t_type` tinytext COMMENT '交易类型：充值、收入、支出、提现',
  `t_from` int(16) DEFAULT NULL COMMENT '支出的帐户数据库编码',
  `t_to` int(16) DEFAULT NULL COMMENT '收入的帐户编码',
  `t_moeny` double DEFAULT NULL COMMENT '交易金额',
  `t_moeny_to` double DEFAULT NULL COMMENT '实际到帐',
  `t_time` datetime NOT NULL COMMENT '交易时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `un_order`
--

CREATE TABLE `un_order` (
  `un_id` int(32) NOT NULL COMMENT '订单数据库编码',
  `un_order_no` int(32) NOT NULL COMMENT '订单编号',
  `uid` int(16) NOT NULL COMMENT '买家信息',
  `un_prod` int(32) NOT NULL COMMENT '产品的数据库编码',
  `un_num` int(20) NOT NULL COMMENT '订单中产品的数量',
  `un_moeny` float NOT NULL COMMENT '订单金额总和',
  `un_red` float DEFAULT NULL COMMENT '订单使用红包',
  `un_juan` float DEFAULT NULL COMMENT '使用的券',
  `un_send` int(2) DEFAULT NULL COMMENT '物流方式',
  `un_send_no` varchar(32) DEFAULT NULL COMMENT '物流编号',
  `un_if` int(2) NOT NULL COMMENT '订单状态',
  `un_shop` int(32) NOT NULL COMMENT '卖家uid',
  `un_share` int(32) DEFAULT NULL COMMENT '推广员id',
  `un_ser_id` int(32) DEFAULT NULL COMMENT '订单服务商家id',
  `un_time` datetime NOT NULL COMMENT '订单创建时间',
  `un_zhusi` text COMMENT '注释'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `u_user`
--

CREATE TABLE `u_user` (
  `uid` int(32) NOT NULL COMMENT '用户数字帐号',
  `u_img` int(32) DEFAULT NULL COMMENT '用户头像数据库id',
  `u_name` tinytext COMMENT '用户昵称',
  `u_phone` int(11) DEFAULT NULL COMMENT '用户手机号码',
  `u_wechat` int(32) DEFAULT NULL COMMENT '数据库中微信信息编码地址',
  `u_qr` int(32) DEFAULT NULL COMMENT '用户推广二维码存放的图片数据库id',
  `u_size_qr` int(32) NOT NULL COMMENT '用户身材测量出示的二维码,确认二维码在图片数据库中的id',
  `u_pass` varchar(32) NOT NULL COMMENT '用户密码',
  `level` int(2) NOT NULL COMMENT '用户级别',
  `u_team` int(2) NOT NULL COMMENT '用户组 0，粉丝，消费者  1 推广员 2 服务商家 3 服装工作室 4 客服 5 主管 6 总监 7 root',
  `u_sex` int(1) NOT NULL COMMENT '性别',
  `u_real` int(1) NOT NULL COMMENT '认证与否情况',
  `u_regsiter` datetime NOT NULL COMMENT '用户注册时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `wechat`
--

CREATE TABLE `wechat` (
  `uid` int(20) NOT NULL COMMENT '谁创建了微信信息',
  `wid` int(20) DEFAULT NULL COMMENT '微信信息的数据库唯一编码',
  `w_unionid` varchar(32) DEFAULT NULL COMMENT '微信 union id',
  `w_openid` varchar(32) NOT NULL COMMENT '微信 openid',
  `w_name` varchar(16) NOT NULL COMMENT '微信昵称',
  `w_sex` int(2) NOT NULL COMMENT '微信中的性别',
  `w_add` text COMMENT '微信中的地址',
  `w_time` datetime NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acc`
--
ALTER TABLE `acc`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `add`
--
ALTER TABLE `add`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `admin_moeny`
--
ALTER TABLE `admin_moeny`
  ADD PRIMARY KEY (`amid`);

--
-- Indexes for table `express`
--
ALTER TABLE `express`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`iid`);

--
-- Indexes for table `mission`
--
ALTER TABLE `mission`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `prod`
--
ALTER TABLE `prod`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `real`
--
ALTER TABLE `real`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `real_shop`
--
ALTER TABLE `real_shop`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `trad`
--
ALTER TABLE `trad`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `un_order`
--
ALTER TABLE `un_order`
  ADD PRIMARY KEY (`un_order_no`);

--
-- Indexes for table `u_user`
--
ALTER TABLE `u_user`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `wechat`
--
ALTER TABLE `wechat`
  ADD PRIMARY KEY (`uid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
