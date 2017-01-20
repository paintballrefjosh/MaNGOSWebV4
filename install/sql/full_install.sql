SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `mw_acc_creation_captcha`
-- ----------------------------
DROP TABLE IF EXISTS `mw_acc_creation_captcha`;
CREATE TABLE `mw_acc_creation_captcha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(200) NOT NULL DEFAULT '',
  `key` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_acc_creation_captcha
-- ----------------------------

-- ----------------------------
-- Table structure for `mw_account_extend`
-- ----------------------------
DROP TABLE IF EXISTS `mw_account_extend`;
CREATE TABLE `mw_account_extend` (
  `account_id` int(10) unsigned NOT NULL,
  `account_level` smallint(3) NOT NULL DEFAULT '1',
  `theme` smallint(3) NOT NULL DEFAULT '0',
  `last_visit` int(25) DEFAULT NULL,
  `registration_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `activation_code` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `secret_q1` text,
  `secret_a1` text,
  `secret_q2` text,
  `secret_a2` text,
  `web_points` int(3) NOT NULL DEFAULT '0',
  `points_earned` int(11) NOT NULL DEFAULT '0',
  `points_spent` int(11) NOT NULL DEFAULT '0',
  `date_points` varchar(100) NOT NULL DEFAULT '0',
  `points_today` int(11) NOT NULL DEFAULT '0',
  `total_donations` varchar(5) NOT NULL DEFAULT '0.00',
  `total_votes` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_account_extend
-- ----------------------------

-- ----------------------------
-- Table structure for `mw_account_groups`
-- ----------------------------
DROP TABLE IF EXISTS `mw_account_groups`;
CREATE TABLE `mw_account_groups` (
  `account_level` smallint(2) NOT NULL DEFAULT '1',
  `title` text,
  PRIMARY KEY (`account_level`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_account_groups
-- ----------------------------
INSERT INTO `mw_account_groups` VALUES ('1', 'Guest');
INSERT INTO `mw_account_groups` VALUES ('2', 'Member');
INSERT INTO `mw_account_groups` VALUES ('3', 'Admin');
INSERT INTO `mw_account_groups` VALUES ('4', 'Super Admin');
INSERT INTO `mw_account_groups` VALUES ('5', 'Banned');

-- ----------------------------
-- Table structure for `mw_account_keys`
-- ----------------------------
DROP TABLE IF EXISTS `mw_account_keys`;
CREATE TABLE `mw_account_keys` (
  `id` int(11) unsigned NOT NULL,
  `key` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `assign_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Records of mw_account_keys
-- ----------------------------

-- ----------------------------
-- Table structure for `mw_db_version`
-- ----------------------------
DROP TABLE IF EXISTS `mw_db_version`;
CREATE TABLE `mw_db_version` (
  `dbver` varchar(20) NOT NULL DEFAULT '',
  `dbdate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`dbver`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `mw_db_version`
-- ----------------------------
DROP TABLE IF EXISTS `mw_db_version`;
CREATE TABLE `mw_db_version` (
  `dbver` varchar(20) NOT NULL DEFAULT '',
  `dbdate` int(10) unsigned NOT NULL DEFAULT '0',
  `entry` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`entry`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_db_version
-- ----------------------------
INSERT INTO `mw_db_version` VALUES ('1.0a', '1292781212', '1');

-- ----------------------------
-- Table structure for `mw_donate_packages`
-- ----------------------------
DROP TABLE IF EXISTS `mw_donate_packages`;
CREATE TABLE `mw_donate_packages` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `desc` varchar(255) DEFAULT NULL,
  `cost` varchar(11) NOT NULL DEFAULT '1.00',
  `points` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_donate_packages
-- ----------------------------

-- ----------------------------
-- Table structure for `mw_donate_transactions`
-- ----------------------------
DROP TABLE IF EXISTS `mw_donate_transactions`;
CREATE TABLE `mw_donate_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_id` varchar(255) DEFAULT NULL,
  `account` int(8) DEFAULT NULL,
  `item_number` int(11) DEFAULT NULL,
  `buyer_email` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `pending_reason` varchar(255) DEFAULT NULL,
  `reason_code` varchar(255) DEFAULT NULL,
  `amount` varchar(10) DEFAULT NULL,
  `item_given` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_donate_transactions
-- ----------------------------

-- ----------------------------
-- Table structure for `mw_faq`
-- ----------------------------
DROP TABLE IF EXISTS `mw_faq`;
CREATE TABLE `mw_faq` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_faq
-- ----------------------------

-- ----------------------------
-- Table structure for `mw_gallery`
-- ----------------------------
DROP TABLE IF EXISTS `mw_gallery`;
CREATE TABLE `mw_gallery` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `img` text NOT NULL,
  `comment` text NOT NULL,
  `autor` text NOT NULL,
  `date` date NOT NULL,
  `cat` varchar(255) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of mw_gallery
-- ----------------------------
INSERT INTO `mw_gallery` VALUES ('1', 'Mangosweb_wall.jpg', 'Test Wallpaper', 'MangosWeb', '0000-00-00', 'wallpaper');
INSERT INTO `mw_gallery` VALUES ('2', 'Mangosweb_scr.jpg', 'Test Screenshot', 'MangosWeb', '0000-00-00', 'screenshot');

-- ----------------------------
-- Table structure for `mw_gallery_ssotd`
-- ----------------------------
DROP TABLE IF EXISTS `mw_gallery_ssotd`;
CREATE TABLE `mw_gallery_ssotd` (
  `image` varchar(50) NOT NULL,
  `date` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mw_gallery_ssotd
-- ----------------------------
INSERT INTO `mw_gallery_ssotd` VALUES ('Mangosweb_scr.jpg', '10.10.19');

-- ----------------------------
-- Table structure for `mw_menu_items`
-- ----------------------------
DROP TABLE IF EXISTS `mw_menu_items`;
CREATE TABLE `mw_menu_items` (
  `menu_id` int(3) NOT NULL DEFAULT '1',
  `link_title` varchar(100) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `order` int(3) NOT NULL DEFAULT '1',
  `account_level` int(3) NOT NULL DEFAULT '1',
  `guest_only` int(3) NOT NULL DEFAULT '0',
  `id` int(3) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_menu_items
-- ----------------------------
INSERT INTO `mw_menu_items` VALUES ('1', 'News', './', '1', '1', '0', '1');
INSERT INTO `mw_menu_items` VALUES ('1', 'RSS', 'rss.php', '2', '1', '0', '2');
INSERT INTO `mw_menu_items` VALUES ('2', 'Register', '?p=account&sub=register', '1', '1', '1', '3');
INSERT INTO `mw_menu_items` VALUES ('2', 'Admin Panel', '?p=admin', '1', '3', '0', '4');
INSERT INTO `mw_menu_items` VALUES ('7', 'Vote', '?p=vote', '1', '2', '0', '5');
INSERT INTO `mw_menu_items` VALUES ('7', 'Shop', '?p=shop', '3', '2', '0', '6');
INSERT INTO `mw_menu_items` VALUES ('2', 'Manage Account', '?p=account', '2', '2', '0', '7');
INSERT INTO `mw_menu_items` VALUES ('4', 'Server Characters', '?p=server&sub=chars', '2', '1', '0', '8');
INSERT INTO `mw_menu_items` VALUES ('4', 'Players Online', '?p=server&sub=playersonline', '3', '1', '0', '9');
INSERT INTO `mw_menu_items` VALUES ('8', 'FAQ', '?p=support&sub=faq', '1', '1', '0', '10');
INSERT INTO `mw_menu_items` VALUES ('7', 'Donate', '?p=donate', '2', '2', '0', '11');
INSERT INTO `mw_menu_items` VALUES ('4', 'Realm Status', '?p=server&sub=realmstatus', '1', '1', '0', '12');
INSERT INTO `mw_menu_items` VALUES ('2', 'Account Restore', '?p=account&sub=restore', '2', '1', '1', '13');
INSERT INTO `mw_menu_items` VALUES ('4', 'Top Kills', '?p=server&sub=topkills', '1', '1', '0', '14');

-- ----------------------------
-- Table structure for `mw_news`
-- ----------------------------
DROP TABLE IF EXISTS `mw_news`;
CREATE TABLE `mw_news` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `title` text,
  `message` longtext,
  `posted_by` text,
  `post_time` int(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_news
-- ----------------------------
INSERT INTO `mw_news` VALUES ('1', 'Welcome!', '<center><b><p>Thank you for installing MangosWeb v3!</p></b> <p>Please login with your Admin account username and password to configure the CMS further.</p></center>', 'Wilson212', '1288727884');


-- ----------------------------
-- Table structure for `mw_online`
-- ----------------------------
DROP TABLE IF EXISTS `mw_online`;
CREATE TABLE `mw_online` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `user_name` varchar(200) NOT NULL DEFAULT 'Guest',
  `user_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `logged` int(10) NOT NULL DEFAULT '0',
  `currenturl` varchar(255) NOT NULL DEFAULT './',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mw_online
-- ----------------------------

-- ----------------------------
-- Table structure for `mw_pms`
-- ----------------------------
DROP TABLE IF EXISTS `mw_pms`;
CREATE TABLE `mw_pms` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(8) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `message` text,
  `sender_id` int(8) unsigned NOT NULL DEFAULT '0',
  `posted` int(10) unsigned NOT NULL DEFAULT '0',
  `sender_ip` varchar(15) DEFAULT '0.0.0.0',
  `showed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mw_pms
-- ----------------------------

-- ----------------------------
-- Table structure for `mw_regkeys`
-- ----------------------------
DROP TABLE IF EXISTS `mw_regkeys`;
CREATE TABLE `mw_regkeys` (
  `id` smallint(9) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL DEFAULT '0',
  `used` smallint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_regkeys
-- ----------------------------

-- ----------------------------
-- Table structure for `mw_secret_questions`
-- ----------------------------
DROP TABLE IF EXISTS `mw_secret_questions`;
CREATE TABLE `mw_secret_questions` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `question` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_secret_questions
-- ----------------------------
INSERT INTO `mw_secret_questions` VALUES ('1', 'What is your mothers maiden name?');
INSERT INTO `mw_secret_questions` VALUES ('2', 'What is your favorite color?');
INSERT INTO `mw_secret_questions` VALUES ('3', 'What street did you grow up on?');
INSERT INTO `mw_secret_questions` VALUES ('4', 'What is your fathers middle name?');
INSERT INTO `mw_secret_questions` VALUES ('5', 'What is the name of your first pet?');

-- ----------------------------
-- Table structure for `mw_shop_items`
-- ----------------------------
DROP TABLE IF EXISTS `mw_shop_items`;
CREATE TABLE `mw_shop_items` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `item_number` varchar(255) NOT NULL DEFAULT '0',
  `itemset` int(10) NOT NULL DEFAULT '0',
  `gold` int(25) NOT NULL DEFAULT '0',
  `quanity` int(25) NOT NULL DEFAULT '1',
  `desc` varchar(255) DEFAULT NULL,
  `wp_cost` varchar(5) NOT NULL DEFAULT '0',
  `realms` int(100) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_shop_items
-- ----------------------------

-- ----------------------------
-- Table structure for `mw_vote_sites`
-- ----------------------------
DROP TABLE IF EXISTS `mw_vote_sites`;
CREATE TABLE `mw_vote_sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `votelink` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `reset_time` int(16) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mw_vote_sites
-- ----------------------------

-- ----------------------------
-- Table structure for `mw_voting`
-- ----------------------------
DROP TABLE IF EXISTS `mw_voting`;
CREATE TABLE `mw_voting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_ip` varchar(30) NOT NULL,
  `site` int(10) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mw_voting
-- ----------------------------

-- ----------------------------
-- Insert account data from "account" table
-- ----------------------------
INSERT INTO `mw_account_extend` (`account_id`) SELECT account.id FROM account;

-- ----------------------------
-- Instead of rebuilding this file, we will just alter the tables for utf-8
-- ----------------------------
ALTER TABLE `mw_account_groups` DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';
ALTER TABLE `mw_account_extend` DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';
ALTER TABLE `mw_donate_packages` DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';
ALTER TABLE `mw_donate_transactions` DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';
ALTER TABLE `mw_faq` DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';
ALTER TABLE `mw_donate_packages` DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';
ALTER TABLE `mw_menu_items` DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';
ALTER TABLE `mw_news` DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';
ALTER TABLE `mw_online` DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';
ALTER TABLE `mw_shop_items` DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';

--
-- Add dbinfo to realmlist table
-- Very important that this is in the end, along with ADD ALTERS. Because if
-- file gets applied again, it gets an error here.
--
ALTER TABLE `realmlist`
ADD `site_enabled` int(3) NOT NULL default '0';

ALTER TABLE `realmlist`
ADD `ra_info` VARCHAR( 355 ) NOT NULL default 'type;port;username;password';

ALTER TABLE `realmlist`
ADD `dbinfo` VARCHAR( 355 ) NOT NULL default '127.0.0.1;3306;username;password;DBCharacter;127.0.0.1;3306;username;password;DBWorld' COMMENT 'Database info to THIS row';