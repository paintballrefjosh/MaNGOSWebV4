<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

?>
<div class="content">	
	<div class="content-header">
		<h4><a href="?p=admin">Main Menu</a> / Banlist</h4>
	</div> <!-- .content-header -->				
	<div class="main-content">
		<table>
			<thead>
				<th><center><b>Account Bans</center></b></th>
			</thead>
		</table>
		<table width="95%">
		<thead>
			<tr>
				<th width="15%"><b><center>Username</center></b></th>
				<th width="20%"><b><center>Ban Date</center></b></th>
				<th width="15%"><b><center>Banned By</center></b></th>
				<th width="50%"><b>Ban Reason</b></th>
			</tr>
		</thead>
		<?php
		$ban_list = $RDB->select("SELECT account.id, username, bandate, bannedby, banreason FROM account_banned JOIN account ON account.id = account_banned.id WHERE active='1' ORDER BY bandate DESC");
		if($ban_list)
		{
			foreach($ban_list as $row)
			{
		?>
			<tr class="content">
				<td align="center"><a href="?p=admin&sub=users&id=<?= $row['id'];?>"><?php echo $row['username']; ?></a></td>
				<td align="center"><?php echo date("Y-m-d @ G:i", $row['bandate']); ?></td>
				<td align="center"><?php echo $row['bannedby']; ?></td>
				<td align="left"><?php echo $row['banreason']; ?></td>
			</tr>
		<?php
			}
		}
		?>
		</table>
		<br />
		<br />
		<table>
			<thead>
				<th><center><b>IP Address Bans</center></b></th>
			</thead>
		</table>
		<table width="95%">
		<thead>
			<tr>
				<th width="15%"><b><center>IP Address</center></b></th>
				<th width="20%"><b><center>Ban Date</center></b></th>
				<th width="15%"><b><center>Banned By</center></b></th>
				<th width="50%"><b>Ban Reason</b></th>
			</tr>
		</thead>
		<?php
		$ban_list = $RDB->select("SELECT ip, bandate, bannedby, banreason FROM ip_banned ORDER BY bandate DESC");
		if($ban_list)
		{
			foreach($ban_list as $row)
			{
		?>
			<tr class="content">
				<td align="center"><?php echo $row['ip']; ?></td>
				<td align="center"><?php echo date("Y-m-d @ G:i", $row['bandate']); ?></td>
				<td align="center"><?php echo $row['bannedby']; ?></td>
				<td align="left"><?php echo $row['banreason']; ?></td>
			</tr>
		<?php
			}
		}
		?>
		</table>
	</div>
</div>