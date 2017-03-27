/*Table structure for table `mw_account_extend` */

DROP TABLE IF EXISTS `mw_account_extend`;

CREATE TABLE `mw_account_extend` (
  `account_id` INT(10) UNSIGNED NOT NULL,
  `account_level` SMALLINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `theme` SMALLINT(3) UNSIGNED NOT NULL DEFAULT '0',
  `last_visit` INT(25) DEFAULT NULL,
  `registration_ip` VARCHAR(15) CHARACTER SET latin1 NOT NULL DEFAULT '0.0.0.0',
  `activation_code` VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL,
  `avatar` VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL,
  `secret_q1` TEXT CHARACTER SET latin1,
  `secret_a1` TEXT CHARACTER SET latin1,
  `secret_q2` TEXT CHARACTER SET latin1,
  `secret_a2` TEXT CHARACTER SET latin1,
  `web_points` INT(3) NOT NULL DEFAULT '0',
  `points_earned` INT(11) NOT NULL DEFAULT '0',
  `points_spent` INT(11) NOT NULL DEFAULT '0',
  `date_points` VARCHAR(100) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `points_today` INT(11) NOT NULL DEFAULT '0',
  `total_donations` VARCHAR(5) CHARACTER SET latin1 NOT NULL DEFAULT '0.00',
  `total_votes` SMALLINT(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mw_account_groups` */

DROP TABLE IF EXISTS `mw_account_groups`;

CREATE TABLE `mw_account_groups` (
  `account_level` SMALLINT(2) UNSIGNED NOT NULL DEFAULT '1',
  `title` TEXT CHARACTER SET latin1,
  PRIMARY KEY (`account_level`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `mw_account_groups` */

INSERT  INTO `mw_account_groups`(`account_level`,`title`) VALUES 

(1,'Guest'),

(2,'Member'),

(3,'Admin'),

(4,'Super Admin'),

(5,'Banned');

/*Table structure for table `mw_account_keys` */

DROP TABLE IF EXISTS `mw_account_keys`;

CREATE TABLE `mw_account_keys` (
  `id` INT(11) UNSIGNED NOT NULL,
  `key` VARCHAR(40) CHARACTER SET utf8 DEFAULT NULL,
  `assign_time` INT(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mw_config` */

DROP TABLE IF EXISTS `mw_config`;

CREATE TABLE `mw_config` (
  `site_title` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT 'MaNGOS Web V4',
  `site_email` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT 'admin@mistvale.com',
  `site_cookie` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT 'MaNGOSWebV4',
  `site_href` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT '/',
  `site_base_href` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT 'http://www.mistvale.com',
  `site_armory` VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT 'http://realmplayers.com',
  `site_forums` VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT '/forum/',
  `emulator` VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT 'mangos',
  `templates` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT 'WotLK,Cataclysm_1,illidan,sunwell,Mists_of_Pandaria_v1.0,Burning_Crusade',
  `default_lang` VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT 'English',
  `available_lang` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT 'English',
  `reg_allow` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `reg_require_activation` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `reg_require_invite` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  `reg_require_recaptcha` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  `reg_recaptcha_private_key` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reg_recaptcha_public_key` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reg_require_secret_questions` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  `allow_user_pass_change` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `allow_user_email_change` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  `max_account_per_ip` TINYINT(3) UNSIGNED NOT NULL DEFAULT '10',
  `default_component` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT 'frontpage',
  `flash_display_type` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_vote_banner` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_newbie_guide` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_hitcounter` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_server_info` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_realm_status` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_players_online` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_server_ip` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_server_type` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_server_pop` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_server_lang` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_server_act` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_server_active_act` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_server_chars` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `fp_server_more_info` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `email_type` TINYINT(3) UNSIGNED NOT NULL DEFAULT '2',
  `email_smtp_host` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT 'smtp.gmail.com',
  `email_smtp_port` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '465',
  `email_use_secure` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `email_smtp_secure` VARCHAR(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'SSL',
  `email_smtp_user` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_smtp_pass` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_email` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT 'admin@mistvale.com',
  `site_notice_enable` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `module_online_list` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `module_fp_ssotd` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `module_vote_system` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `module_vote_online_check` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `module_news_items` TINYINT(3) UNSIGNED NOT NULL DEFAULT '10',
  `module_news_open` TINYINT(3) UNSIGNED NOT NULL DEFAULT '3',
  `module_char_rename` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `module_char_rename_pts` TINYINT(3) UNSIGNED NOT NULL DEFAULT '2',
  `module_char_customize` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `module_char_customize_pts` TINYINT(3) UNSIGNED NOT NULL DEFAULT '5',
  `module_char_faction_change` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `module_char_faction_change_pts` TINYINT(3) UNSIGNED NOT NULL DEFAULT '15',
  `module_char_race_change` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `module_char_race_change_pts` TINYINT(3) UNSIGNED NOT NULL DEFAULT '10',
  `enable_debugging` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `default_realm_id` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
  `db_logon_host` VARCHAR(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '127.0.0.1',
  `db_logon_port` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '3306',
  `db_logon_name` VARCHAR(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `db_logon_user` VARCHAR(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `db_logon_pass` VARCHAR(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `mw_config` */

INSERT  INTO `mw_config`() VALUES ();

/*Table structure for table `mw_db_version` */

DROP TABLE IF EXISTS `mw_db_version`;

CREATE TABLE `mw_db_version` (
  `dbver` VARCHAR(20) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `dbdate` INT(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `mw_db_version` */

INSERT  INTO `mw_db_version`(`dbver`,`dbdate`) VALUES ('4.1.0',1490069033);

/*Table structure for table `mw_donate_packages` */

DROP TABLE IF EXISTS `mw_donate_packages`;

CREATE TABLE `mw_donate_packages` (
  `id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `desc` VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL,
  `cost` VARCHAR(11) CHARACTER SET latin1 NOT NULL DEFAULT '1.00',
  `points` INT(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MYISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mw_donate_transactions` */

DROP TABLE IF EXISTS `mw_donate_transactions`;

CREATE TABLE `mw_donate_transactions` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `trans_id` VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL,
  `account` INT(8) UNSIGNED DEFAULT NULL,
  `item_number` INT(11) UNSIGNED DEFAULT NULL,
  `buyer_email` VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL,
  `payment_type` VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL,
  `payment_status` VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL,
  `pending_reason` VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL,
  `reason_code` VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL,
  `amount` VARCHAR(10) CHARACTER SET latin1 DEFAULT NULL,
  `item_given` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MYISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mw_faq` */

DROP TABLE IF EXISTS `mw_faq`;

CREATE TABLE `mw_faq` (
  `id` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` TEXT CHARACTER SET latin1 NOT NULL,
  `answer` TEXT CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mw_gallery` */

DROP TABLE IF EXISTS `mw_gallery`;

CREATE TABLE `mw_gallery` (
  `id` INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `img` TEXT CHARACTER SET cp1251 NOT NULL,
  `comment` TEXT CHARACTER SET cp1251 NOT NULL,
  `autor` TEXT CHARACTER SET cp1251 NOT NULL,
  `date` INT(11) UNSIGNED NOT NULL,
  `cat` VARCHAR(255) CHARACTER SET cp1251 NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MYISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `mw_gallery` */

INSERT  INTO `mw_gallery`(`id`,`img`,`comment`,`autor`,`date`,`cat`) VALUES 

(1,'Mangosweb_wall.jpg','Test Wallpaper','MangosWeb',1485927282,'wallpaper'),

(2,'Mangosweb_scr.jpg','Test Screenshot','MangosWeb',1485927282,'screenshot');

/*Table structure for table `mw_menu_items` */

DROP TABLE IF EXISTS `mw_menu_items`;

CREATE TABLE `mw_menu_items` (
  `menu_id` INT(3) UNSIGNED NOT NULL DEFAULT '1',
  `link_title` VARCHAR(100) CHARACTER SET latin1 DEFAULT NULL,
  `link` VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL,
  `order` INT(3) UNSIGNED NOT NULL DEFAULT '1',
  `account_level` INT(3) NOT NULL DEFAULT '1',
  `guest_only` INT(3) NOT NULL DEFAULT '0',
  `id` INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MYISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `mw_menu_items` */

INSERT  INTO `mw_menu_items`(`menu_id`,`link_title`,`link`,`order`,`account_level`,`guest_only`,`id`) VALUES 

(1,'News','./',1,1,0,1),

(1,'RSS','rss.php',2,1,0,2),

(2,'Admin Panel','?p=admin',1,3,0,3),

(2,'Manage Account','?p=account',2,2,0,4),

(2,'Register','?p=account&sub=register',3,1,1,5),

(2,'Account Restore','?p=account&sub=restore',4,1,1,6),

(4,'Top Kills','?p=server&sub=topkills',1,1,0,7),

(4,'Characters','?p=server&sub=chars',2,1,0,8),

(4,'Players Online','?p=server&sub=playersonline',3,1,0,9),

(4,'Realm Status','?p=server&sub=realmstatus',4,1,0,10),

(4,'Server Statistics','?p=server&sub=statistic',5,1,0,11),

(7,'Donate','?p=donate',1,2,0,12),

(7,'Vote','?p=vote',2,2,0,13),

(7,'Shop','?p=shop',3,2,0,14),

(8,'FAQ','?p=support&sub=faq',1,1,0,15);

/*Table structure for table `mw_news` */

DROP TABLE IF EXISTS `mw_news`;

CREATE TABLE `mw_news` (
  `id` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` TEXT CHARACTER SET latin1,
  `message` LONGTEXT CHARACTER SET latin1,
  `posted_by` TEXT CHARACTER SET latin1,
  `post_time` INT(15) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MYISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `mw_news` */

INSERT  INTO `mw_news`(`id`,`title`,`message`,`posted_by`,`post_time`) VALUES 

(1,'Welcome!','<center><b><p>Thank you for installing MaNGOS Web V4!</p></b> <p>Please login with your Admin account username and password to configure the CMS further.</p></center>','Mistvale.com Dev',1485753669);

/*Table structure for table `mw_online` */

DROP TABLE IF EXISTS `mw_online`;

CREATE TABLE `mw_online` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_name` VARCHAR(200) CHARACTER SET utf8 NOT NULL DEFAULT 'Guest',
  `user_ip` VARCHAR(15) CHARACTER SET utf8 NOT NULL DEFAULT '0.0.0.0',
  `logged` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `currenturl` VARCHAR(255) CHARACTER SET utf8 NOT NULL DEFAULT './',
  PRIMARY KEY (`id`)
) ENGINE=MYISAM AUTO_INCREMENT=1191 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mw_pms` */

DROP TABLE IF EXISTS `mw_pms`;

CREATE TABLE `mw_pms` (
  `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner_id` INT(8) UNSIGNED NOT NULL DEFAULT '0',
  `subject` VARCHAR(255) CHARACTER SET utf8 NOT NULL,
  `message` TEXT CHARACTER SET utf8,
  `sender_id` INT(8) UNSIGNED NOT NULL DEFAULT '0',
  `posted` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `sender_ip` VARCHAR(15) CHARACTER SET utf8 DEFAULT '0.0.0.0',
  `showed` TINYINT(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mw_realm` */

DROP TABLE IF EXISTS `mw_realm`;

CREATE TABLE `mw_realm` (
  `realm_id` INT(10) UNSIGNED NOT NULL,
  `site_enabled` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  `db_world_host` VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT '127.0.0.1',
  `db_world_port` SMALLINT(5) UNSIGNED DEFAULT '3306',
  `db_world_name` VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT '',
  `db_world_user` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT '',
  `db_world_pass` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT '',
  `db_char_host` VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT '127.0.0.1',
  `db_char_port` SMALLINT(5) UNSIGNED DEFAULT '3306',
  `db_char_name` VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT '',
  `db_char_user` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT '',
  `db_char_pass` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT '',
  `ra_type` TINYINT(3) UNSIGNED DEFAULT '0',
  `ra_port` SMALLINT(5) UNSIGNED DEFAULT '3443',
  `ra_user` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT '',
  `ra_pass` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`realm_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mw_regkeys` */

DROP TABLE IF EXISTS `mw_regkeys`;

CREATE TABLE `mw_regkeys` (
  `id` SMALLINT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` VARCHAR(255) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `used` SMALLINT(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MYISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mw_secret_questions` */

DROP TABLE IF EXISTS `mw_secret_questions`;

CREATE TABLE `mw_secret_questions` (
  `id` INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` VARCHAR(60) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MYISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `mw_secret_questions` */

INSERT  INTO `mw_secret_questions`(`id`,`question`) VALUES 

(1,'What is your mothers maiden name?'),

(2,'What is your favorite color?'),

(3,'What street did you grow up on?'),

(4,'What is your fathers middle name?'),

(5,'What is the name of your first pet?');

/*Table structure for table `mw_shop_items` */

DROP TABLE IF EXISTS `mw_shop_items`;

CREATE TABLE `mw_shop_items` (
  `id` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_number` VARCHAR(255) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `itemset` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `gold` INT(25) NOT NULL DEFAULT '0',
  `quanity` INT(25) UNSIGNED NOT NULL DEFAULT '1',
  `desc` VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL,
  `wp_cost` VARCHAR(5) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `realms` INT(100) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MYISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mw_vote_sites` */

DROP TABLE IF EXISTS `mw_vote_sites`;

CREATE TABLE `mw_vote_sites` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hostname` VARCHAR(255) CHARACTER SET latin1 NOT NULL,
  `votelink` VARCHAR(255) CHARACTER SET latin1 NOT NULL,
  `image_url` VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL,
  `points` INT(11) DEFAULT NULL,
  `reset_time` INT(16) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mw_voting` */

DROP TABLE IF EXISTS `mw_voting`;

CREATE TABLE `mw_voting` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_ip` VARCHAR(30) CHARACTER SET utf8 NOT NULL,
  `site` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `time` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `mw_voting` */