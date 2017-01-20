<br>
<?php builddiv_start(1, $lang['who_is_online']);

// Check to see the admin has the online list enabled.
if($Config->get('module_onlinelist') == 1)
{
?>
	<table border="0" width="100%">
	<tr>
		<td width="20%" style="border-bottom:1px solid #cccccc;"><?php echo $lang['who'];?></td>
		<td style="border-bottom:1px solid #cccccc;"><?php echo $lang['where'];?></td>
		<td style="border-bottom:1px solid #cccccc;"><?php echo $lang['when'];?></td>
	  <?php 
		// If the users is an admin, show the IP address, else dont
		if($user['account_level'] == 3 || $user['account_level'] == 4)
		{ 
	  ?>
			<td style="border-bottom:1px solid #cccccc;">Ip</td>
	  <?php 
		} ?>
	</tr>
	<?php 
	foreach($People as $item)
	{ ?>
	<tr>
		<td><?php echo $item['user_name']; ?></td>
		<td><a href="<?php echo $item['currenturl']; ?>"><?php echo $item['currenturl_name']; ?></a></td>
		<td><?php echo date('d F Y, H:i',$item['logged']);?></td>
		<?php
		// If the users is an admin, show the IP address, else dont
		if($user['account_level'] == 3 || $user['account_level'] == 4)
		{ ?>
			<td><?php echo $item['user_ip']; ?></td>
		<?php 
		} ?>
	</tr>
	<?php 
	} ?>
	</table>
<?php 
}
else # Config says module disabled!
{
	output_message('info', $lang['disabled']);
}
builddiv_end(); ?>