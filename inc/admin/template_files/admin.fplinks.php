<?php
if(isset($_GET['linkid']))
{
?>
	<!-- EDITING LINK -->
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=fplinks">Frontpage Links</a> / Edit</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<?php
				if(isset($_POST['action']))
				{
					if($_POST['action'] == 'edit')
					{
						if(isset($_POST['delete']))
						{
							deleteLink();
						}
						else
						{
							editLink();
						}
					}
				}
			?>
			<form method="POST" action="?p=admin&sub=fplinks&linkid=<?php echo $_GET['linkid']; ?>" class="form label-inline">
			<input type="hidden" name="action" value="edit">
			<?php
				$edit_info = $DB->selectRow("SELECT * FROM `mw_menu_items` WHERE `id`='".$_GET['linkid']."'");
			?>
			
			<!-- Link Title -->
			<div class="field">
				<label for="Link Title"><?php echo $lang['link_title']; ?>: </label>
				<input id="Link Title" name="link_title" size="20" type="text" class="medium" value="<?php echo $edit_info['link_title']; ?>" />
				<p class="field_help"><?php echo $lang['link_title']; ?></p>
			</div>
			
			<!-- URL -->
			<div class="field">
				<label for="Link H"><?php echo $lang['link_to']; ?>: </label>
				<input id="Link H" name="link" size="20" type="text" class="medium" value="<?php echo $edit_info['link']; ?>" />
				<p class="field_help"><?php echo $lang['link_to_desc']; ?></p>
			</div>
			
			<!-- Menu -->
			<div class="field">
				<label for="Link M"><?php echo $lang['menu']; ?>: </label>
				<select id="type" class="medium" name="menu_id">
					<?php 
						foreach($mainnav_links as $pre_nav)
						{
							$sub_links = explode("-", $pre_nav);
							if($edit_info['menu_id'] == $sub_links['0'])
							{ $e_rs = 'selected="selected"'; }else{ $e_rs = ''; }
							echo "<option value=".$sub_links['0']." ".$e_rs.">".$sub_links['1']."</option>";
						}
					?>
				</select>
				<p class="field_help"><?php echo $lang['menu_desc']; ?></p>
			</div>
			
			<!-- Guest Option -->
			<div class="field">
				<label for="Link GO"><?php echo $lang['guest_only']; ?>: </label>
				<select id="type" class="xsmall" name="guest_only">
					<?php 
						if($edit_info['guest_only'] == 1)
						{ $e_s = 'selected="selected"'; $e_s2 = ''; }else{ $e_s2 = 'selected="selected"'; $e_s = ''; }
					?>
					<option value="1" <?php echo $e_s; ?>><?php echo $lang['yes']; ?></option>
					<option value="0" <?php echo $e_s2; ?>><?php echo $lang['no']; ?></option>
				</select>
				<p class="field_help"><?php echo $lang['guest_only_desc']; ?></p>
			</div>
			
			<!-- Account Level -->
			<div class="field">
				<label for="Link AO"><?php echo $lang['account_level']; ?>: </label>
				<select id="type" class="small" name="account_level">
					<option value="1" selected="selected">Guests</option>
					<option value="2">Members</option>
					<option value="3">Admins</option>
					<option value="4">Super Admins</option>
				</select>
				<p class="field_help"><?php echo $lang['account_level_desc']; ?></p>
			</div>
			
			<div class="buttonrow-border">								
				<center>
					<button><span><?php echo $lang['update']; ?></span></button>
					<button class="btn-sec" name="delete"><span><?php echo $lang['delete']; ?></span></button>
				</center>					
			</div>
			
			</form>
		</div>
	</div>
<?php
}
elseif(isset($_GET['addlink']))
{
?>

<!-- ADDING LINK -->
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=fplinks">Frontpage Links</a> / ADD</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<form method="POST" action="?p=admin&sub=fplinks" class="form label-inline">
			<input type="hidden" name="action" value="addlink">
			
			<!-- Link Title -->
			<div class="field">
				<label for="Link Title"><?php echo $lang['link_title']; ?>: </label>
				<input id="Link Title" name="link_title" size="20" type="text" class="medium" />
				<p class="field_help"><?php echo $lang['link_title']; ?></p>
			</div>
			
			<!-- URL -->
			<div class="field">
				<label for="Link H"><?php echo $lang['link_to']; ?>: </label>
				<input id="Link H" name="link" size="20" type="text" class="medium" />
				<p class="field_help"><?php echo $lang['link_to_desc']; ?></p>
			</div>
			
			<div class="field">
				<label for="Link M"><?php echo $lang['menu']; ?>: </label>
				<select id="type" class="medium" name="menu_id">
					<?php 
						foreach($mainnav_links as $pre_nav2)
						{
							$sub_links2 = explode("-", $pre_nav2);
							echo "<option value=".$sub_links2['0'].">".$sub_links2['1']."</option>";
						}
					?>
				</select>
				<p class="field_help"><?php echo $lang['menu_desc']; ?></p>
			</div>
			
			<!-- Guest Option -->
			<div class="field">
				<label for="Link GO"><?php echo $lang['guest_only']; ?>: </label>
				<select id="type" class="xsmall" name="guest_only">
					<option value="1"><?php echo $lang['yes']; ?></option>
					<option value="0" selected='selected'><?php echo $lang['no']; ?></option>
				</select>
				<p class="field_help"><?php echo $lang['guest_only_desc']; ?></p>
			</div>
			
			<div class="field">
				<label for="Link GO"><?php echo $lang['account_level']; ?>: </label>
				<select id="type" class="medium" name="account_level">
					<option value="1" selected="selected">Guests</option>
					<option value="2">Members</option>
					<option value="3">Admins</option>
					<option value="4">Super Admins</option>
				</select>
				<p class="field_help"><?php echo $lang['account_level_desc']; ?></p>
			</div>
			
			<div class="buttonrow-border">								
				<center><button><span><?php echo $lang['add_link']; ?></span></button></center>			
			</div>		
			</form>
		</div>
	</div>

<?php
}
else
{
?>
	<!-- Link List -->
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / Frontpage Links</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<?php
				if(isset($_POST['action']))
				{
					if($_POST['action'] == 'update')
					{
						updateOrder();
					}
					elseif($_POST['action'] == 'addlink')
					{
						addLink();
					}
				}
			?>
			<h4><center><b><u>
				<a href="?p=admin&sub=fplinks&addlink=true" style="text-decoration: none;"> 
					<button><span><?php echo $lang['add_link']; ?></span></button>
				</a></u></b></center>
			</h4>
			<form method="POST" action="?p=admin&sub=fplinks" class="form label-inline">
			<input type="hidden" name="action" value="update">
			<?php
				foreach($mainnav_links as $menuname)
				{
					$menunamev = explode('-',$menuname);
					$load_links = $DB->select("SELECT * FROM `mw_menu_items` WHERE `menu_id`='$menunamev[0]' ORDER BY `order`");
					if($load_links != FALSE)
					{
						echo "<h5><center>". $lang['menu'] ." ".$menunamev['0'].", ".$menunamev['1']."</center></h5><br />";
						echo "<table style='border-bottom: 1px solid #E5E2E2;'>
								<thead>
									<th>". $lang['link_title'] ."</th>
									<th>". $lang['account_level'] ."</th>
									<th>". $lang['guest_only'] ."</th>
									<th>Order</th>
								</thead>";
						foreach($load_links as $link)
						{
							echo "<tr>
									<div class='field'>
									<td>
										<a href='?p=admin&sub=fplinks&linkid=".$link['id']."'>".$link['link_title']."</a>
									</td>
									<td>";
										if($link['account_level'] == 1)
										{
											echo "Guests";
										}
										elseif($link['account_level'] == 2)
										{
											echo "Members";
										}
										elseif($link['account_level'] == 3)
										{
											echo "Admins";
										}
										elseif($link['account_level'] == 4)
										{
											echo "Super Admins";
										}
							echo"   </td>
									<td>";
										if($link['guest_only'] == 1)
										{
											echo "Yes";
										}
										else
										{
											echo "No";
										}
							echo"	</td>
									<td>
										Order: <input name=".$link['id']." type='text' size='2' type='text' class='xsmall' value=".$link['order']."><br />
									</td>
									</div>
								</tr>";
								
							
						}
						echo "</table><br /><br />";
					}
				}
			?>
			<br />
			<div class="buttonrow-border">								
				<center><button><span><?php echo $lang['update_menu_order']; ?></span></button></center>			
			</div>
			</form>
		</div>
	</div>
<?php
} ?>