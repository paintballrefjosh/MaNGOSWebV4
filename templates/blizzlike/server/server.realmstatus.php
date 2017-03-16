<style type = "text/css">
    td.serverStatus1 { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
    td.serverStatus2 { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
    td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>

<img src="<?php echo $Template['path']; ?>/images/realmstatus_header-left.jpg" border="0" width="50%" height="135" /><img src="<?php echo $Template['path']; ?>/images/realmstatus_background.jpg" border="0" width="50%" height="135" />
<br />

<!--  Build the top div -->
<?php builddiv_start(0); ?>

<!-- Page Desc as well as some template related php -->
<div style="padding:10px 20px 10px 20px;">
	<?php
		// Define the online image and offline image paths
		$online_image = '<img src="'.$Template['path'].'/images/icons/uparrow2.gif" style="vertical-align: bottom;" height="19" width="18" alt=""/>';
		$offline_image = '<img src="'.$Template['path'].'/images/icons/downarrow2.gif" style="vertical-align: bottom;" height="19" width="18" alt=""/>';
		
		// $up and $down are used to place the images into the description later on.
		$up = $online_image.'<b style="color: rgb(35, 67, 3);">' . $lang['up'] . '</b>';
		$down = $offline_image.'<b style="color: rgb(102, 13, 2);">' . $lang['down'] . '</b>';

		// === Here we replace a few words in the page description with images and links === //
		
		// Start by defining the realm status forum link from the config file
		$realm_status_forum = '<a href="'.$mwe_config['site_forums'].'">' . $lang['realm_status_forum'] . '</a>';
		$desc = $PAGE_DESC;
		
		// Now we replace [up] with the $up image and description, [down] with the $down image and desc,
		// and finally, replace the [realm_status_forum] with the forum link ($realm_status_forum)
		$desc = str_replace('[up]', $up, $desc);
		$desc = str_replace('[down]', $down, $desc);
		$desc = str_replace('[realm_status_forum]', $realm_status_forum, $desc);
		
		// Echo the new page description with all the replaced values
		echo $desc;
	?>
</div>
<br/>
<br/>
<?php 
write_subheader($lang['realm_status']);
write_metalborder_header(); ?>
    <table cellpadding="3" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <td class="rankingHeader" align="left" nowrap="nowrap" width="53"><center><?php echo $lang['status'];?></center></td>
            <td align="left" nowrap="nowrap" class="rankingHeader" width="120"><center><?php echo $lang['uptime'];?></center></td>
            <td align="left" nowrap="nowrap" class="rankingHeader"><?php echo $lang['realm_name'];?></td>
            <td class="rankingHeader" align="center" nowrap="nowrap" width="120"><?php echo $lang['Type'];?></td>
            <td class="rankingHeader" align="center" nowrap="nowrap" width="120"><?php echo $lang['Population'];?></td>
        </tr>
        <tr>
            <td colspan="6" style="background: url('<?php echo $Template['path']; ?>/images/shadow.gif');">
                <img src="<?php echo $Template['path']; ?>/images/pixel.gif" height="1" width="1" alt=""/>
            </td>
        </tr>
<?php 
		foreach($realm_list as $item) 
		{
			// If the satus is online, dispaly the online image, else, display offline image
			if($item['status'] == 'Online')
			{
				$status = $online_image;
			}
			else
			{
				$status = $offline_image;
			} ?>
			<tr>
				<td class="serverStatus<?php echo $item['res_color'] ?>" align="center"><?php echo $status; ?></td>
				<td width="168" class="serverStatus<?php echo $item['res_color'] ?>"><center><?php echo $item['uptime']; ?></center></td>
				<td width="802" class="serverStatus<?php echo $item['res_color'] ?>"><b style='color: rgb(35, 67, 3);'><?php echo $item['name']; ?></b></td>
				<td class="serverStatus<?php echo $item['res_color'] ?>" align="center"><b style='color: rgb(102, 13, 2);'><?php echo $item['type']; ?></b></td>
				<td class="serverStatus<?php echo $item['res_color'] ?>" align="center">
					<b style='color: rgb(35, 67, 3);'><?php echo $item['population']." (".population_view($item['population']).")"; ?></b>
				</td>
			</tr>
<?php 
		} ?>
        </tbody>
    </table>
<?php write_metalborder_footer(); ?>
<?php builddiv_end() ?>
