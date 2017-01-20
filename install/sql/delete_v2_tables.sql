SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `acc_creation_captcha`;
DROP TABLE IF EXISTS `account_extend`;
DROP TABLE IF EXISTS `account_groups`;
DROP TABLE IF EXISTS `account_keys`;
DROP TABLE IF EXISTS `donations_template`;
DROP TABLE IF EXISTS `f_attachs`;
DROP TABLE IF EXISTS `f_categories`;
DROP TABLE IF EXISTS `f_forums`;
DROP TABLE IF EXISTS `f_markread`;
DROP TABLE IF EXISTS `f_posts`;
DROP TABLE IF EXISTS `f_topics`;
DROP TABLE IF EXISTS `gallery`;
DROP TABLE IF EXISTS `gallery_ssotd`;
DROP TABLE IF EXISTS `online`;
DROP TABLE IF EXISTS `paypal_cart_info`;
DROP TABLE IF EXISTS `paypal_payment_info`;
DROP TABLE IF EXISTS `paypal_subscription_info`;
DROP TABLE IF EXISTS `pms`;
DROP TABLE IF EXISTS `site_faq`;
DROP TABLE IF EXISTS `site_regkeys`;
DROP TABLE IF EXISTS `voting`;
DROP TABLE IF EXISTS `voting_points`;
DROP TABLE IF EXISTS `voting_rewards`;
DROP TABLE IF EXISTS `voting_sites`;
DROP TABLE IF EXISTS `world_entrys`;

ALTER TABLE `realmlist`
DROP COLUMN `dbinfo`,
DROP COLUMN `ra_address`,
DROP COLUMN `ra_port`,
DROP COLUMN `ra_user`,
DROP COLUMN `ra_pass`;