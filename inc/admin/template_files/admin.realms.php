<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/


if(isset($_POST['edit_realm'])) 
{
	updateRealm();
}

if(isset($_GET['id'])) 
{
	$rlm = $RDB->selectRow("SELECT * FROM `realmlist` WHERE `id`='".$_GET['id']."'");
	$rlm_ext = $DB->selectRow("SELECT * FROM `mw_realm` WHERE `realm_id` = '".$_GET['id']."'");

?>

<!-- EDITING A REALM -->
<div class="content">	
	<div class="content-header">
		<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&amp;sub=realms">Manage Realms</a> / Edit</h4>
	</div> <!-- .content-header -->	
	<div class="main-content">
	
	<form method="POST" name="adminform" class="form label-inline">
	<input type="hidden" name="edit_realm">
		<table>
			<thead>
				<tr>
					<th><center><?php echo $lang['editing_realm']; ?>: <?php echo $rlm['name']; ?></center></th>
				</tr>
			</thead>
		</table>
		<br />
		
		<!-- Realm Name -->
		<div class="field">
			<label for="dbh"><?php echo $lang['realm_name']; ?>: </label>
			<input id="dbh" name="realm_name" size="20" type="text" class="medium" value="<?php echo $rlm['name']; ?>" />
			<p class="field_help"><?php echo $lang['realm_name_desc']; ?></p>
		</div>
		
		<!-- Realm Address -->
		<div class="field">
			<label for="dbh"><?php echo $lang['realm_address']; ?>: </label>
			<input id="dbh" name="realm_address" size="20" type="text" class="medium" value="<?php echo $rlm['address']; ?>" />
			<p class="field_help"><?php echo $lang['realm_address_desc']; ?>.</p>
		</div>
		
		<!-- Realm Port -->
		<div class="field">
			<label for="dbh"><?php echo $lang['realm_port']; ?>: </label>
			<input id="dbh" name="realm_port" size="20" type="text" class="medium" value="<?php echo $rlm['port']; ?>" />
			<p class="field_help"><?php echo $lang['realm_port_desc']; ?>.</p>
		</div>
		
		<!-- Type -->
		<div class="field">
			<label for="type"><?php echo $lang['type']; ?>: </label>
			<select id="type" class="small" name="icon">
			<?php
				foreach($realm_type_def as $tmpr_id => $tmpr_name) 
				{
					if($tmpr_id == $rlm['icon']) 
					{
						$seltype = "selected=\"selected\"";
					}
					else
					{
						$seltype = "";
					}
					echo "<option value=\"".$tmpr_id."\" ".$seltype.">".$tmpr_name."</option>"; 
				} 
			?>
			</select>
		</div>
		
		<!-- Timezone -->
		<div class="field">
			<label for="timezone"><?php echo $lang['timezone']; ?>: </label>
			<select id="type" class="medium" name="timezone">
			<?php
				foreach($realm_timezone_def as $tmptz_id => $tmptz_name) 
				{
					if($tmptz_id == $rlm['timezone']) 
					{
						$seldtype = "selected=\"selected\"";
					}
					else
					{
						$seldtype = "";
					}
					echo "<option value=\"".$tmptz_id."\" ".$seldtype.">".$tmptz_name."</option>"; 
				}  
			?>
			</select>
		</div>
		
		<!-- Site enabled -->
		<div class="field">
			<label for="Site Emu"><?php echo $lang['site_enabled']; ?>: </label>
			<select id="site_enabled" class="medium" name="site_enabled">
			<?php
				if($rlm_ext['site_enabled'] == 1) 
				{
					echo "<option value=\"1\" selected='selected'>Enabled</option><option value=\"0\">Disabled</option>"; 
				}
				else
				{ 
					echo "<option value=\"0\" selected='selected'>Disabled</option><option value=\"1\">Enabled</option>"; 
				}
			?>
			</select>
		</div>
		
		<table>
			<thead>
				<tr>
					<th><center><?php echo $lang['char_db_settings']; ?></center></th>
				</tr>
			</thead>
		</table>
		<br />
		
		<!-- Char DB Host -->
		<div class="field">
			<label for="dbh"><?php echo $lang['char_db_host']; ?>: </label>
			<input id="dbh" name="db_char_host" size="20" type="text" class="medium" value="<?php echo $rlm_ext['db_char_host']; ?>" />
			<p class="field_help"><?php echo $lang['char_db_host_desc']; ?></p>
		</div>
		
		<!-- Char DB Port -->
		<div class="field">
			<label for="dbh"><?php echo $lang['char_db_port']; ?>: </label>
			<input id="dbh" name="db_char_port" size="20" type="text" class="medium" value="<?php echo $rlm_ext['db_char_port']; ?>" />
			<p class="field_help"><?php echo $lang['char_db_port']; ?>.</p>
		</div>
		
		<!-- Char DB Username -->
		<div class="field">
			<label for="dbh"><?php echo $lang['char_db_user']; ?>: </label>
			<input id="dbh" name="db_char_user" size="20" type="text" class="medium" value="<?php echo $rlm_ext['db_char_user']; ?>" />
			<p class="field_help"><?php echo $lang['char_db_user_desc']; ?></p>
		</div>
	
		<!-- Char DB Password -->
		<div class="field">
			<label for="dbh"><?php echo $lang['char_db_pass']; ?>: </label>
			<input id="dbh" name="db_char_pass" size="20" type="password" class="medium" value="<?php echo $rlm_ext['db_char_pass']; ?>" />
			<p class="field_help"><?php echo $lang['char_db_pass_desc']; ?></p>
		</div>
		
		<!-- Char DB Name -->
		<div class="field">
			<label for="dbh"><?php echo $lang['char_db_name']; ?>: </label>
			<input id="dbh" name="db_char_name" size="20" type="text" class="medium" value="<?php echo $rlm_ext['db_char_name']; ?>" />
			<p class="field_help"><?php echo $lang['char_db_name_desc']; ?></p>
		</div>
		
		<!-- World DB Settings -->
		<table>
			<thead>
				<tr>
					<th><center><?php echo $lang['world_db_settings']; ?></center></th>
				</tr>
			</thead>
		</table>
		<br />
		
		<!-- World DB Host -->
		<div class="field">
			<label for="dbh"><?php echo $lang['world_db_host']; ?>: </label>
			<input id="dbh" name="db_world_host" size="20" type="text" class="medium" value="<?php echo $rlm_ext['db_world_host']; ?>" />
			<p class="field_help"><?php echo $lang['world_db_host_desc']; ?></p>
		</div>
		
		<!-- World DB Port -->
		<div class="field">
			<label for="dbh"><?php echo $lang['world_db_port']; ?>: </label>
			<input id="dbh" name="db_world_port" size="20" type="text" class="medium" value="<?php echo $rlm_ext['db_world_port']; ?>" />
			<p class="field_help"><?php echo $lang['world_db_port_desc']; ?></p>
		</div>
		
		<!-- World DB Username -->
		<div class="field">
			<label for="dbh"><?php echo $lang['world_db_user']; ?>: </label>
			<input id="dbh" name="db_world_user" size="20" type="text" class="medium" value="<?php echo $rlm_ext['db_world_user']; ?>" />
			<p class="field_help"><?php echo $lang['world_db_user_desc']; ?></p>
		</div>
	
		<!-- World DB Password -->
		<div class="field">
			<label for="dbh"><?php echo $lang['world_db_pass']; ?>: </label>
			<input id="dbh" name="db_world_pass" size="20" type="password" class="medium" value="<?php echo $rlm_ext['db_world_pass']; ?>" />
			<p class="field_help"><?php echo $lang['world_db_pass_desc']; ?></p>
		</div>
		
		<!-- World DB Name -->
		<div class="field">
			<label for="dbh"><?php echo $lang['world_db_name']; ?>: </label>
			<input id="dbh" name="db_world_name" size="20" type="text" class="medium" value="<?php echo $rlm_ext['db_world_name']; ?>" />
			<p class="field_help"><?php echo $lang['world_db_name_desc']; ?></p>
		</div>
		
		<table>
			<thead>
				<tr>
					<th><center><?php echo $lang['remote_access_settings']; ?></center></th>
				</tr>
			</thead>
		</table>
		<br />
		
		<!-- RA Type -->
		<div class="field">
			<label for="ra_type"><?php echo $lang['type']; ?>: </label>
			<select id="type" class="small" name="ra_type">
			<?php
				if($rlm_ext['ra_type'] == 0) 
				{
					echo "<option value=\"0\">Telnet</option><option value=\"1\">SOAP</option>"; 
				}
				else
				{ 
					echo "<option value=\"1\">SOAP</option><option value=\"0\">Telnet</option>"; 
				}
			?>
			</select>
		</div>
		
		<!-- Ra Port -->
		<div class="field">
			<label for="ra_port"><?php echo $lang['remote_access_port']; ?>: </label>
			<input id="ra_port" name="ra_port" size="20" type="text" class="xsmall" value="<?php echo $rlm_ext['ra_port']; ?>" />
			<p class="field_help"><?php echo $lang['remote_access_port_desc']; ?>.</p>
		</div>
		
		<!-- Ra Username -->
		<div class="field">
			<label for="ra_user"><?php echo $lang['remote_access_user']; ?>: </label>
			<input id="ra_user" name="ra_user" size="20" type="text" class="medium" value="<?php echo $rlm_ext['ra_user']; ?>" />
			<p class="field_help"><?php echo $lang['remote_access_user_desc']; ?>.</p>
		</div>
		
		<!-- Ra Password -->
		<div class="field">
			<label for="dbh"><?php echo $lang['remote_access_pass']; ?>: </label>
			<input id="dbh" name="ra_pass" size="20" type="password" class="medium" value="<?php echo $rlm_ext['ra_pass']; ?>" />
			<p class="field_help"><?php echo $lang['remote_access_pass_desc']; ?>.</p>
		</div>
		
		<div class="buttonrow-border">								
			<center><button><span><?php echo $lang['update']; ?></span></button></center>			
		</div>
		</form>
	</div>
</div>
<?php
}
else
{
?>

<!-- VIEWING REALMLIST -->
<div class="content">	
	<div class="content-header">
		<h4><a href="?p=admin">Main Menu</a> / Manage Realms</h4>
	</div> <!-- .content-header -->	
	<div class="main-content">
		<table>
			<thead>
				<th><center><b>Id</b></center></th>
				<th><center><b><?php echo $lang['name']; ?></b></center></th>
				<th><center><b><?php echo $lang['address']; ?></b></center></th>
				<th><center><b><?php echo $lang['port']; ?></b></center></th>
				<th><center><b><?php echo $lang['type']; ?></b></center></th>
				<th><center><b><?php echo $lang['timezone']; ?></b></center></th>
				<th><center><b>Enabled</b></center></th>
			</thead>
<?php
			foreach($getrealms as $row)
			{
				$enabled = $DB->selectCell("SELECT `site_enabled` FROM `mw_realm` WHERE `realm_id` = '".$row['id']."'");
				if($enabled == 1)
					$enabled = "Yes";
				else
					$enabled = "No";
?>
			<tr>
				<td align="center"><?php echo $row['id']; ?></td>
				<td align="center"><a href="?p=admin&sub=realms&id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
				<td align="center"><?php echo $row['address']; ?></td>
				<td align="center"><?php echo $row['port']; ?></td>
				<td align="center"><?php echo $realm_type_def[$row['icon']]; ?></td>
				<td align="center"><?php echo $realm_timezone_def[$row['timezone']]; ?></td>
				<td align="center"><?= $enabled; ?></td>
			</tr>
<?php
			}
?>
		</table>
	</div>
</div> <!-- .content -->	
<?php 
} ?>