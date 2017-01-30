<style type="text/css">
  a.server { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; font-weight: bold; }
  td.serverStatus1 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus0 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>
<br />
<!--  Build the top div -->
<?php
builddiv_start(0, "Top Kills");
write_metalborder_header();
?>
<table cellpadding='3' cellspacing='0' width='100%'>
    <tbody>
		<tr> 
			<td align='center' colspan='7'><img src="<?php echo $Template['path']; ?>/images/banners/alliance.jpg"></td>
		</tr>
		<tr>
			<td class="rankingHeader" align="center" nowrap="nowrap">#</td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['name'];?></td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['race'];?></td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['class'];?></td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['level'];?></td>
			<td class="rankingHeader" align="center" nowrap="nowrap">PvP Rank</td>
			<td class="rankingHeader" align="center" nowrap="nowrap">Honorable Kills</td>
		</tr>
	<?php 
		if(isset($allhonor[1]))
		{
			$pos = 0; 
			foreach($allhonor[1] as $item)
			{
				$pos++;
	?>
			<tr>
				<td class="serverStatus<?php echo $pos % 2; ?>" align="center"><b style="color: rgb(102, 13, 2);"><?php echo $pos; ?></b></td>
				<td class="serverStatus<?php echo $pos % 2; ?>"><b style="color: rgb(35, 67, 3);"><center><?php echo $item['name']; ?></center></b></td>
				<td class="serverStatus<?php echo $pos % 2; ?>" align="center"><small style="color: rgb(102, 13, 2);">
					<img onmouseover="ddrivetip('<?php echo $item['race']; ?>','#ffffff')" onmouseout="hideddrivetip()"
					src="<?php echo $item['race_icon'];?>" height="18" width="18" alt=""/></small>
				</td>
				<td class="serverStatus<?php echo $pos % 2; ?>" align="center"><small style="color: (35, 67, 3);">
					<img onmouseover="ddrivetip('<?php echo $item['class']; ?>','#ffffff')" onmouseout="hideddrivetip()"
					src="<?php echo $item['class_icon'];?>" height="18" width="18" alt=""/></small>
				</td>
				<td class="serverStatus<?php echo $pos % 2; ?>" align="center"><b style="color: rgb(102, 13, 2);"><?php echo $item['level']; ?></b></td>
				<td class="serverStatus<?php echo $pos % 2; ?>" align="center"><img src="<?php echo $item['rank_icon']; ?>" onmouseover="ddrivetip('<?php echo $item['rank']; ?>','#ffffff')"; onmouseout="hideddrivetip()"></td>
				<td class="serverStatus<?php echo $pos % 2; ?>" align="center"><b style="color: rgb(35, 67, 3);"><?php echo $item['honorable_kills']; ?></b></td>
			</tr>
	<?php 
			}
		} 
	?>
    </tbody>
    </table>
<?php 
write_metalborder_footer(); 
?>
<br />
<?php
write_metalborder_header();
?>
<table cellpadding='3' cellspacing='0' width='100%'>
    <tbody>
		<tr> 
			<td align='center' colspan='7'><img src="<?php echo $Template['path']; ?>/images/banners/horde.jpg"></td>
		</tr>
		<tr>
			<td class="rankingHeader" align="center" nowrap="nowrap">#</td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['name'];?></td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['race'];?></td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['class'];?></td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['level'];?></td>
			<td class="rankingHeader" align="center" nowrap="nowrap">PvP Rank</td>
			<td class="rankingHeader" align="center" nowrap="nowrap">Honorable Kills</td>
		</tr>
	<?php 
		if(isset($allhonor[0]))
		{
			$pos = 0; 
			foreach($allhonor[0] as $item)
			{
				$pos++;
	?>
			<tr>
				<td class="serverStatus<?php echo $pos % 2; ?>" align="center"><b style="color: rgb(102, 13, 2);"><?php echo $pos; ?></b></td>
				<td class="serverStatus<?php echo $pos % 2; ?>"><b style="color: rgb(35, 67, 3);"><center><?php echo $item['name']; ?></center></b></td>
				<td class="serverStatus<?php echo $pos % 2; ?>" align="center"><small style="color: rgb(102, 13, 2);">
					<img onmouseover="ddrivetip('<?php echo $item['race']; ?>','#ffffff')" onmouseout="hideddrivetip()"
					src="<?php echo $item['race_icon'];?>" height="18" width="18" alt=""/></small>
				</td>
				<td class="serverStatus<?php echo $pos % 2; ?>" align="center"><small style="color: (35, 67, 3);">
					<img onmouseover="ddrivetip('<?php echo $item['class']; ?>','#ffffff')" onmouseout="hideddrivetip()"
					src="<?php echo $item['class_icon'];?>" height="18" width="18" alt=""/></small>
				</td>
				<td class="serverStatus<?php echo $pos % 2;; ?>" align="center"><b style="color: rgb(102, 13, 2);"><?php echo $item['level']; ?></b></td>
				<td class="serverStatus<?php echo $pos % 2;; ?>" align="center"><img src="<?php echo $item['rank_icon']; ?>" onmouseover="ddrivetip('<?php echo $item['rank']; ?>','#ffffff')"; onmouseout="hideddrivetip()"></td>
				<td class="serverStatus<?php echo $pos % 2;; ?>" align="center"><b style="color: rgb(35, 67, 3);"><?php echo $item['honorable_kills']; ?></b></td>
			</tr>
	<?php 
			}
		} 
	?>
    </tbody>
    </table>
<?php 
write_metalborder_footer(); 

builddiv_end(); 
?>