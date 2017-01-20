<?php 
if(isset($_GET['id']))
{
	if($_GET['id'] > 0) 
	{
		$gid = $_GET['id'];
		if(isset($_GET['action'])) 	
		{
			if($_GET['action'] == 'ban') 
			{
				showBanForm($gid);
			}
			elseif($_GET['action'] == 'unban') 
			{
				unBan($gid);
			}
			elseif($_GET['action'] == 'delete') 
			{
				deleteUser($gid);
			}
			else
			{
				echo "Invalid Action";
			}
		}
		else
		{
			$profile = $Account->getProfile($_GET['id']);
			$lastvisit = date("Y-m-d, g:i a", $profile['last_visit']);
			$seebanned = $DB->count("SELECT COUNT(*) FROM account_banned WHERE id='".$_GET['id']."' AND `active`=1");
			if($seebanned > 0) 
			{
				$bann = 1;
			}
			else
			{
				$bann = 0;
			}
?>

	<!-- Viewing an account -->
		<div class="content">	
			<div class="content-header">
				<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=users">Manage Users</a> / <?php echo $profile['username']; ?></h4>
			</div> <!-- .content-header -->				
			<div class="main-content">
			
				<?php
					if(isset($_POST['action']))
					{
						if($user['account_level'] <= $profile['account_level'] && $user['account_level'] != '4')
						{
							output_message('error', 'You cannot edit this infomation. Not enough Privilages!');
						}
						else
						{
							if($_POST['action'] == 'editProfile')
							{
								changeDetails();
							}
							elseif($_POST['action'] == 'changePass')
							{
								changePass();
							}
							elseif($_POST['action'] == 'editWeb')
							{
								editUser();
							}
						}
					}
				?>
				
				<!-- Table for general account details -->
				<table style="border-bottom: 1px solid #E5E2E2;">
					<thead>
						<th colspan="4"><center><b><?php echo $lang['general_stats']; ?></center></b></th>
					</thead>
					<tbody>
						<tr>
							<!-- Register Date -->
							<td width="25%" align="right"><?php echo $lang['reg_date']; ?>: </td>
							<td width="25%" align="left"><?php echo $profile['joindate']; ?></td>
							<!-- Vote Count -->
							<td width="25%" align="right"><?php echo $lang['vote_count']; ?>: </td>
							<td width="25%" align="left"><?php echo $profile['total_votes']; ?></td>
						</tr>
						<tr>
							<!-- Register IP -->
							<td width="25%" align="right"><?php echo $lang['reg_ip']; ?>: </td>
							<td width="25%" align="left"><?php echo $profile['registration_ip']; ?></td>
							<!-- Web Point Balance -->
							<td width="25%" align="right"><?php echo $lang['web_point_balance']; ?>: </td>
							<td width="25%" align="left"><?php echo $profile['web_points']; ?></td>
						</tr>
						<tr>
							<!-- Last game activity -->
							<td width="25%" align="right"><?php echo $lang['last_act_game']; ?>: </td>
							<td width="25%" align="left"><?php echo $profile['last_login']; ?></td>
							<!-- Points earned/spent -->
							<td width="25%" align="right"><?php echo $lang['points_earned_spent']; ?>: </td>
							<td width="25%" align="left"><?php echo $profile['points_earned']." / ".$profile['points_spent']; ?></td>
						</tr>
						<tr>
							<!-- Last site activity -->
							<td width="25%" align="right"><?php echo $lang['last_act_site']; ?>: </td>
							<td width="25%" align="left"><?php echo $lastvisit; ?></td>
							<!-- Total Donations -->
							<td width="25%" align="right"><?php echo $lang['total_donations']; ?>: </td>
							<td width="25%" align="left">$<?php echo $profile['total_donations']; ?></td>
						</tr>
						
					</tbody>
				</table>
				<table>
					<tr>
						<td align="center" style="padding: 5px 5px 5px 5px;">
						<a href="?p=admin&sub=users&id=<?php echo $_GET['id']; ?>&action=delete" onclick="return confirm('Are you sure? This is Un-reversable!');">
							<b><font color="red"><?php echo $lang['delete_account']; ?></font></b></a> ||
						<?php
							if($bann == 1) 
							{
								echo "<a href=\"?p=admin&sub=users&id=".$_GET['id']."&action=unban\"><b><font color=\"red\">Unban</font></b></a>";
							}
							elseif($bann == 0) 
							{ 
								echo "<a href=\"?p=admin&sub=users&id=".$_GET['id']."&action=ban\"><b><font color=\"red\">Ban Account</font></b></a>";
							}
						?>
						</td>
					</tr>
				</table>
				
				<!-- EDIT PROFILE -->
				<br />
				<table>
					<thead>
						<th><center><b><?php echo $lang['edit_profile']; ?></center></b></th>
					</thead>
				</table>
				<form method="POST" action="?p=admin&sub=users&id=<?php echo $_GET['id']; ?>" class="form label-inline">
					<input type="hidden" name="action" value="editProfile">
					
					<div class="field">
						<label for="Username"><?php echo $lang['username']; ?>: </label>
						<input id="Username" name="username" size="20" type="text" class="medium" disabled="disbled" value="<?php echo $profile['username']; ?>"/>
					</div>
					
					<div class="field">
						<label for="Email"><?php echo $lang['email']; ?>: </label>
						<input id="Email" name="email" size="20" type="text" class="medium" value="<?php echo $profile['email']; ?>"/>
					</div>
					
					<div class="field">
						<label for="Locked"><?php echo $lang['locked']; ?>: </label>
						<select name="locked" class='xsmall'>
							<?php
								if($profile['locked'] == 1)
								{
									echo "<option value='1' selected='selected'>". $lang['yes'] ."</option><option value='0'>". $lang['no'] ."</option>";
								}
								else
								{
									echo "<option value='1'>". $lang['yes'] ."</option><option value='0' selected='selected'>". $lang['no'] ."</option>";
								}
							?>
						</select>
					</div>
					
					<div class="field">
						<label for="Exp"><?php echo $lang['expansion']; ?>: </label>
						<select name="expansion" class='small'>
							<?php
								if($profile['expansion'] == 2)
								{
									echo "<option value='2' selected='selected'>WotLK</option><option value='1'>TBC</option><option value='0'>Classic</option>";
								}
								elseif($profile['expansion'] == 1)
								{
									echo "<option value='2'>WotLK</option><option value='1' selected='selected'>TBC</option><option value='0'>Classic</option>";
								}
								else
								{
									echo "<option value='2'>WotLK</option><option value='1'>TBC</option><option value='0' selected='selected'>Classic</option>";
								}
							?>
						</select>
					</div>
					
					<div class="buttonrow-border">								
						<center><button><span><?php echo $lang['update_profile']; ?></span></button></center>			
					</div>
				</form>
				
				<!-- CHANGE PASSWORD -->
				<br />
				<br />
				<table>
					<thead>
						<th><center><b><?php echo $lang['change_pass']; ?></center></b></th>
					</thead>
				</table>
				<form method="POST" action="?p=admin&sub=users&id=<?php echo $_GET['id']; ?>" class="form label-inline">
					<input type="hidden" name="action" value="changePass">
					
					<!-- New Password -->
					<div class="field">
						<label for="Password"><?php echo $lang['new_pass']; ?>: </label>
						<input id="Password" name="password" size="20" type="text" class="medium" />
					</div>
					
					<div class="buttonrow-border">								
						<center><button><span><?php echo $lang['set_pass']; ?></span></button></center>			
					</div>
				</form>
				
				<!-- EDIT WEBSITE DETAILS -->
				<br />
				<br />
				<table>
					<thead>
						<th><center><b><?php echo $lang['edit_webacct_details']; ?></center></b></th>
					</thead>
				</table>
				<form method="POST" action="?p=admin&sub=users&id=<?php echo $_GET['id']; ?>" class="form label-inline">
					<input type="hidden" name="action" value="editWeb">
				
					<!-- Account Level -->
					<div class="field">
						<label for="account_level"><?php echo $lang['account_level']; ?>: </label>
						<select name="account_level" class='small'>
							<?php
								if($profile['account_level'] == 5)
								{
									echo "<option value='5' selected='selected'>Banned</option>";
								}
								elseif($profile['account_level'] == 4)
								{
									echo "<option value='4' selected='selected'>Super Admin</option>
										  <option value='3'>Admin</option>
										  <option value='2'>Member</option>
									"; 
								}
								elseif($profile['account_level'] == 3)
								{
									echo "<option value='4'>Super Admin</option>
										  <option value='3' selected='selected'>Admin</option>
										  <option value='2'>Member</option>
									"; 
								}
								else
								{
									echo "<option value='4'>Super Admin</option>
										  <option value='3' selected='selected'>Admin</option>
										  <option value='2' selected='selected'>Member</option>
									"; 
								}
							?>
						</select>
					</div>
					
					<!-- Theme -->
					<div class="field">
						<label for="theme"><?php echo $lang['theme']; ?>: </label>
						<select name="theme" class='medium'>
							<?php
								$alltmpl = explode(",", $Config->get('templates'));
								$key = 0;
								foreach($alltmpl as $tmpls) 
								{
									echo '<option value="'.$key.'"';
									if ($profile['theme'] == $key) 
									{
										echo ' selected="selected"';
									}
									echo '>'.$tmpls.'</option>';
									$key++;
								}
							?>
						</select>
					</div>
					
					<!-- Web Points -->
					<div class="field">
						<label for="Web_Points"><?php echo $lang['web_points']; ?>: </label>
						<input id="Web_Points" name="web_points" size="2" type="text" class="xsmall" value="<?php echo $profile['web_points']; ?>"/>
					</div>
					
					<!-- Total Donations -->
					<div class="field">
						<label for="Web Points"><?php echo $lang['total_donations']; ?>: </label>
						<input id="Web Points" name="total_donations" size="2" type="text" class="xsmall" value="<?php echo $profile['total_donations']; ?>"/>
					</div>
					
					<div class="buttonrow-border">								
						<center><button><span><?php echo $lang['update']; ?></span></button></center>			
					</div>
				</form>
			
			</div> <!-- Main Content -->
		</div> <!-- Content -->

<?php
		}
	}
	else
	{
		echo "Invalid Request";
	}
}
else
{ ?>
<!-- Start #main -->
<div id="main">			
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / Manage Users</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">	
		<center><h2><?php echo $lang['user_list']; ?></h2></center>
		<table>
			<tr>
				<td colspan="4" align="center">
					<b><?php echo $lang['sort_by_letter']; ?>:</b>&nbsp;&nbsp;
					<small>
					<a href="?p=admin&sub=users">All</a> | 
					<a href="?p=admin&sub=users&sortby=1">#</a> 
					<a href="?p=admin&sub=users&sortby=a">A</a> 
					<a href="?p=admin&sub=users&sortby=b">B</a> 
					<a href="?p=admin&sub=users&sortby=c">C</a> 
					<a href="?p=admin&sub=users&sortby=d">D</a> 
					<a href="?p=admin&sub=users&sortby=e">E</a> 
					<a href="?p=admin&sub=users&sortby=f">F</a> 
					<a href="?p=admin&sub=users&sortby=g">G</a> 
					<a href="?p=admin&sub=users&sortby=h">H</a> 
					<a href="?p=admin&sub=users&sortby=i">I</a> 
					<a href="?p=admin&sub=users&sortby=j">J</a> 
					<a href="?p=admin&sub=users&sortby=k">K</a> 
					<a href="?p=admin&sub=users&sortby=l">L</a> 
					<a href="?p=admin&sub=users&sortby=m">M</a> 
					<a href="?p=admin&sub=users&sortby=n">N</a> 
					<a href="?p=admin&sub=users&sortby=o">O</a> 
					<a href="?p=admin&sub=users&sortby=p">P</a> 
					<a href="?p=admin&sub=users&sortby=q">Q</a> 
					<a href="?p=admin&sub=users&sortby=r">R</a> 
					<a href="?p=admin&sub=users&sortby=s">S</a> 
					<a href="?p=admin&sub=users&sortby=t">T</a> 
					<a href="?p=admin&sub=users&sortby=u">U</a> 
					<a href="?p=admin&sub=users&sortby=v">V</a> 
					<a href="?p=admin&sub=users&sortby=w">W</a> 
					<a href="?p=admin&sub=users&sortby=x">X</a> 
					<a href="?p=admin&sub=users&sortby=y">Y</a> 
					<a href="?p=admin&sub=users&sortby=z">Z</a>              
					</small>           
				</td>
			</tr>
			<tr>
				<td>
					<form method="POST" action="?p=admin&sub=users" name="adminform" class="form label-inline">
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
		<form method="POST" action="?p=admin&sub=users" name="adminform" class="form label-inline">
			<table width="95%">
				<thead>
					<tr>
						<th width="120"><b><center><?php echo $lang['username']; ?></center></b></th>
						<th width="140"><b><center><?php echo $lang['email']; ?></center></b></th>
						<th width="120"><b><center><?php echo $lang['reg_date']; ?></center></b></th>
						<th width="40"><b><center>Active/Ban</center></b></th>
					</tr>
				</thead>
				<?php
				foreach($getusers as $row) { 
				?>
				<tr class="content">
					<td align="center"><a href="?p=admin&sub=users&id=<?php echo $row['id']; ?>"><?php echo $row['username']; ?></a></td>
					<td align="center"><?php echo $row['email']; ?></td>
					<td align="center"><?php echo $row['joindate']; ?></td>
					<td align="center"><?php echo $row['locked']; ?></td>
				</tr><?php } ?>
			</table>
			<div id="pg">
			<?php
				// If there is going to be more then 1 page, then show page nav at the bottom
				if($totalrows > $limit)
				{
					if(isset($_GET['sortby']))
					{
						admin_paginate($totalrows, $limit, $page, '?p=admin&sub=users&sortby='.$_GET['sortby']);
					}
					else
					{
						admin_paginate($totalrows, $limit, $page, '?p=admin&sub=users');
					}
				}
			?>
			</div>
		</form>
		</div>
	</div>
<?php } ?>