SET FOREIGN_KEY_CHECKS=0;
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

DROP TABLE IF EXISTS `mw_voting`;
CREATE TABLE `mw_voting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_ip` varchar(30) NOT NULL,
  `site` int(10) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

DROP TABLE IF EXISTS `mw_db_version`;
CREATE TABLE `mw_db_version` (
  `dbver` varchar(20) NOT NULL DEFAULT '',
  `dbdate` int(10) unsigned NOT NULL DEFAULT '0',
  `entry` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`entry`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `mw_db_version` VALUES ('1.0a', '1292781212', '1');