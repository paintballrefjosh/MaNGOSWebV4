<?php 
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

if(isset($_GET['id']))
{
?>
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=chartools">Character tools</a> / <?php echo $Character->getName($_GET['id']); ?></h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
		<?php
			if($_GET['id'] > 0) 
			{
				if(isset($_GET['action'])) 	
				{
					if($_GET['action'] == 'delete') 
					{
						deleteCharacter($_GET['id']);
					}
					else
					{
						die("Invalid Action");
					}
				}
				elseif(isset($_POST['action']))
				{
					if($_POST['action'] == 'change')
					{
						updateChar();
					}
					elseif($_POST['action'] == 'rename') 
					{
						flagRename();
					}
					elseif($_POST['action'] == 'customize') 
					{
						flagCustomize();
					}
					elseif($_POST['action'] == 'talents') 
					{
						flagTalentReset();
					}
					elseif($_POST['action'] == 'reset') 
					{
						resetFlags();
					}
				}
				else
				{
					$character = $CDB->selectRow("SELECT * FROM `characters` WHERE `guid`='".$_GET['id']."'");
		?>


		
					<table style="border-bottom: 1px solid #E5E2E2; width: 500px; margin-left: auto; margin-right: auto;">
						<thead>
							<th colspan="4"><center><b><?php echo $lang['general_info']; ?></center></b></th>
						</thead>
						<tbody>
							<tr>
								<td width="25%" align="right"><?php echo $lang['class']; ?>: </td>
								<td width="25%" align="left"><?php echo $Character->charInfo['class'][$character['class']]; ?></td>
								<td width="25%" align="right"><?php echo $lang['account']; ?>: </td>
								<td width="25%" align="left"><?php echo $Account->getLogin($character['account']); ?></td>
							</tr>
							<tr>
								<td width="25%" align="right"><?php echo $lang['race']; ?>: </td>
								<td width="25%" align="left"><?php echo $Character->charInfo['race'][$character['race']]; ?></td>
								<td width="25%" align="right"><?php echo $lang['gold']; ?>: </td>
								<td width="25%" align="left"><?php echo print_gold($character['money']); ?></td>
							</tr>
							<tr>
								<td width="25%" align="right"><?php echo $lang['level']; ?>: </td>
								<td width="25%" align="left"><?php echo $character['level']; ?></td>
								<td width="25%" align="right"><?php echo $lang['status']; ?>: </td>
								<td width="25%" align="left">
								<?php 
									if($character['online'] == 1)
									{
										echo "<font color='green'>Online</font>";
									}
									else
									{
										echo "<font color='red'>Offline</font>";
									}
								?>
								</td>
							</tr>						
						</tbody>
					</table>
					<table>
						<tr>
							<td align="center" style="padding: 5px 5px 5px 5px;">
							<a href="?p=admin&sub=chartools&id=<?php echo htmlspecialchars($_GET['id']); ?>&action=delete" onclick="return confirm('Are you sure? This is Un-reversable!');">
								<b><font color="red"><?php echo $lang['delete_character']; ?></font></b></a> ||
								<a href="?p=admin&sub=users&id=<?php echo $character['account']; ?>&action=ban"><b><font color="red">
									<?php echo $lang['ban_char_account']; ?></font></b>
								</a>
							</td>
						</tr>
					</table>
					<br />
					<br />
					<table>
						<thead>
							<th><center><b><?php echo $lang['char_tools']; ?></center></b></th>
						</thead>
					</table>
					<form method="POST" action="?p=admin&sub=chartools&id=<?php echo $_GET['id']; ?>" class="form label-inline">
						<input type="hidden" name="action" value="change">
						
						<!-- Level -->
						<div class="field">
							<label for="level"><?php echo $lang['level']; ?>: </label>
							<input id="level" name="level" size="2" type="text" class="xsmall" value="<?php echo $character['level']; ?>"/>
							<p class="field_help"><?php echo $lang['char_level_desc']; ?></p>
						</div>
						
						<!-- Exp -->
						<div class="field">
							<label for="exp"><?php echo $lang['exp']; ?>: </label>
							<input id="exp" name="xp" size="2" type="text" class="medium" value="<?php echo $character['xp']; ?>"/>
							<p class="field_help"><?php echo $lang['char_exp_desc']; ?></p>
						</div>
						
						<!-- Gold -->
						<div class="field">
							<label for="gold"><?php echo $lang['gold']; ?>: </label>
							<input id="gold" name="money" size="2" type="text" class="medium" value="<?php echo $character['money']; ?>"/>
							<p class="field_help"><?php echo $lang['char_gold_desc']; ?></p>
						</div>
						
						<!-- Update button -->
						<div class="buttonrow-border">								
							<center><button><span><?php echo $lang['update']; ?></span></button></center>			
						</div>
					</form>
					<br />
					
					<!-- At Login Table -->
					<table>
						<form method="POST" class="form label-inline">
							<input type="hidden" name="action" value="flag">
							<thead>
								<th colspan='2'><center><b><?php echo $lang['char_at_login']; ?></center></b></th>
							</thead>
							<tbody>
							
								<!-- Change Name -->
								<tr>
									<td width='30%' align='center'><button name='action' value='rename'><span><?php echo $lang['change_name']; ?></span></button></td>
									<td><?php echo $lang['char_name_change_desc']; ?></td>
								</tr>
								
								<!-- Re-Customize -->
								<tr>
									<td width='30%' align='center'><button name='action' value='customize'><span><?php echo $lang['char_recustomize']; ?></span></button></td>
									<td><?php echo $lang['char_recustomize_desc']; ?>.</td>
								</tr>
								
								<!-- Reset talents -->
								<tr>
									<td width='30%' align='center'><button name='action' value='talents'><span><?php echo $lang['char_reset_talents']; ?></span></button></td>
									<td><?php echo $lang['char_reset_talents_desc']; ?></td>
								</tr>
								<tr>
									<td width='30%' align='center'><button  name='action' value='reset' class='btn-sec'><span><?php echo $lang['reset_flags']; ?></span></button></td>
									<td><?php echo $lang['reset_flags_desc']; ?></td>
								</tr>
							</tbody>
						</form>
					</table>
			<?php
				}
			}
			else
			{
				echo "Invalid Character ID";
			}
			?>
		</div>
	</div>
<?php
}
else
{ ?>
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / Character tools</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<center><h2><?php echo $lang['char_list']; ?></h2></center>
		<table>
			<tr>
				<td align='center'> <b><?php echo $lang['realm']; ?>:</b><br />
					<?php
					$x = 0;
					foreach($Realms as $Rlm)
					{
						$Rlm_ext = $RDB->selectRow("SELECT * FROM `realmlist` WHERE `id` = '".$Rlm['realm_id']."'");
						
						if($x == 1)
						{
							$separator = " | ";
						}
						else
						{
							$separator = "";
							$x = 1;
						}

						echo $separator . "<a href=\"javascript:setcookie('cur_selected_realm', '". $Rlm['realm_id'] ."'); window.location.reload();\">";
						if($user['cur_selected_realm'] == $Rlm['realm_id'])
						{
							echo "<b><font color=green>".$Rlm_ext['name']."</font></b>"; 
						}
						else
						{
							echo $Rlm_ext['name'];
						}
						echo "</a>";
					}
					?>
				</td>
			<tr>
				<td>
					<form method="POST" action="?p=admin&sub=chartools" name="adminform" class="form label-inline">
					<input type='hidden' name='action' value='sort'>
						<div class="field">
							<center>
								<b><font size='2'><?php echo $lang['search_by_name']; ?>: </font></b> <input name="sortby" size="20" type="text" class="medium">
								<button><span><?php echo $lang['search']; ?></span></button>
							</center>
						</div>
					</form>
				</td>
			</tr>
		</table>
		<form method="POST" action="?p=admin&sub=chartools" name="adminform" class="form label-inline">
			<table width="95%">
				<thead>
					<tr>
						<th width="30%"><a href="?p=admin&amp;sub=chartools&amp;sortby=name&amp;sortdir=<?= $sortdir;?>" class="sort-by"><?php echo $lang['name']; ?></a></th>
						<th width="10%"><a href="?p=admin&amp;sub=chartools&amp;sortby=level&amp;sortdir=<?= $sortdir;?>" class="sort-by"><?php echo $lang['level']; ?></a></th>
						<th width="20%"><a href="?p=admin&amp;sub=chartools&amp;sortby=race&amp;sortdir=<?= $sortdir;?>" class="sort-by"><?php echo $lang['race']; ?></a></th>
						<th width="20%"><a href="?p=admin&amp;sub=chartools&amp;sortby=class&amp;sortdir=<?= $sortdir;?>" class="sort-by"><?php echo $lang['class']; ?></a></th>
						<th width="20%"><a href="?p=admin&amp;sub=chartools&amp;sortby=zone&amp;sortdir=<?= $sortdir;?>" class="sort-by"><?php echo $lang['location']; ?></a></th>
					</tr>
				</thead>
			<?php
				foreach($characters as $row) 
				{ 
			?>
					<tr class="content">
						<td><a href="?p=admin&sub=chartools&id=<?php echo $row['guid']; ?>"><?php echo $row['name']; ?></a></td>
						<td><?php echo $row['level']; ?></td>
						<td><?php echo $Character->charInfo['race'][$row['race']]; ?></td>
						<td><?php echo $Character->charInfo['class'][$row['class']]; ?></td>
						<td><?php echo $Zone->getZoneName($row['zone']); ?></td>
					</tr>
			<?php 
				}
			?>
			</table>
			<div id="pg">
			<?php
				// If there is going to be more then 1 page, then show page nav at the bottom
				if($totalrows > $limit)
				{
					if(isset($_GET['sort']))
					{
						admin_paginate($totalrows, $limit, $page, '?p=admin&sub=chartools&sort='.htmlspecialchars($_GET['sort']));
					}
					else
					{
						admin_paginate($totalrows, $limit, $page, '?p=admin&sub=chartools');
					}
				}
			?>
			</div>
		</form>
		</div>
	</div>
<?php } ?>
