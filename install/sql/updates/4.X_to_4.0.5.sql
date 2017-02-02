-- Drop unused table mw_gallery_ssotd
DROP TABLE `mw_gallery_ssotd`;

-- Modify `mw_gallery` to use a unix timestamp instead of date and preserve existing data
ALTER TABLE `mw_gallery` ADD COLUMN `date_2` INT(11) unsigned NOT NULL;
UPDATE `mw_gallery` SET `date_2` = UNIX_TIMESTAMP(`date`);
ALTER TABLE `mw_gallery` DROP COLUMN `date`;
ALTER TABLE `mw_gallery` CHANGE `date_2` `date` INT(11) unsigned NOT NULL;