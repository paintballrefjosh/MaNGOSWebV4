<?php
if(isset($_GET['id']))
{
?>
	<!-- EDITING LINK -->
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=vote">Vote Links</a> / Edit</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<?php
				if(isset($_POST['action']))
				{
					if($_POST['action'] == 'edit')
					{
						if(isset($_POST['delete']))
						{
							deleteSite();
						}
						else
						{
							editSite();
						}
					}
				}
			?>
			<form method="POST" action="?p=admin&sub=vote&id=<?php echo $_GET['id']; ?>" class="form label-inline">
			<input type="hidden" name="action" value="edit">
			<?php
				$edit_info = $DB->selectRow("SELECT * FROM `mw_vote_sites` WHERE `id`='".$_GET['id']."'");
			?>
			
			<!-- Hostname -->
			<div class="field">
				<label for="Link_Title"><?php echo $lang['hostname']; ?>: </label>
				<input id="Link_Title" name="hostname" size="20" type="text" class="medium" value="<?php echo $edit_info['hostname']; ?>" />
				<p class="field_help"><?php echo $lang['hostname_desc']; ?></p>
			</div>
			
			<!-- Vote Link -->
			<div class="field">
				<label for="vote_link"><?php echo $lang['vote_link']; ?>: </label>
				<input id="vote_link" name="votelink" size="20" type="text" class="medium" value="<?php echo $edit_info['votelink']; ?>"  />
				<p class="field_help"><?php echo $lang['vote_link']; ?></p>
			</div>
			
			<!-- Image Url -->
			<div class="field">
				<label for="image"><?php echo $lang['image_url']; ?>: </label>
				<input id="image" name="image_url" size="20" type="text" class="medium" value="<?php echo $edit_info['image_url']; ?>"  />
				<p class="field_help"><?php echo $lang['image_url_desc']; ?></p>
			</div>
			
			<!-- Points -->
			<div class="field">
				<label for="points"><?php echo $lang['points']; ?>: </label>
				<input id="points" name="points" size="20" type="text" class="tiny" value="<?php echo $edit_info['points']; ?>" />
				<p class="field_help"><?php echo $lang['points_desc']; ?></p>
			</div>
			
			<!-- Reset Time -->
			<div class="field">
				<label for="reset_time"><?php echo $lang['reset_time']; ?>: </label>
				<select id="type" class="small" name="reset_time">
					<option value="43200">12 Hours</option>
					<option value="86400">24 Hours</option>
				</select>
				<p class="field_help"><?php echo $lang['reset_time_desc']; ?></p>
			</div>
			
			<div class="buttonrow-border">								
				<center>
					<button><span>Update Site</span></button>
					<button class="btn-sec" name="delete"><span>DELETE Site</span></button>
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
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=vote">Vote Links</a> / ADD</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<form method="POST" action="?p=admin&sub=vote" class="form label-inline">
			<input type="hidden" name="action" value="addSite">
			
			<!-- Hostname -->
			<div class="field">
				<label for="Link_Title"><?php echo $lang['hostname']; ?>: </label>
				<input id="Link_Title" name="link_host" size="20" type="text" class="medium" />
				<p class="field_help"><?php echo $lang['hostname_desc']; ?></p>
			</div>
			
			<!-- Vote Link -->
			<div class="field">
				<label for="vote_link"><?php echo $lang['vote_link']; ?>: </label>
				<input id="vote_link" name="link" size="20" type="text" class="medium" />
				<p class="field_help"><?php echo $lang['vote_link']; ?></p>
			</div>
			
			<!-- Image Url -->
			<div class="field">
				<label for="image"><?php echo $lang['image_url']; ?>: </label>
				<input id="image" name="link_image" size="20" type="text" class="medium" />
				<p class="field_help"><?php echo $lang['image_url_desc']; ?></p>
			</div>
			
			<!-- Points -->
			<div class="field">
				<label for="points"><?php echo $lang['points']; ?>: </label>
				<input id="points" name="link_points" size="20" type="text" class="tiny" />
				<p class="field_help"><?php echo $lang['points_desc']; ?></p>
			</div>
			
			<!-- Reset Time -->
			<div class="field">
				<label for="reset_time"><?php echo $lang['reset_time']; ?>: </label>
				<select id="type" class="small" name="reset_time">
					<option value="43200">12 Hours</option>
					<option value="86400">24 Hours</option>
				</select>
				<p class="field_help"><?php echo $lang['reset_time_desc']; ?></p>
			</div>
			
			<div class="buttonrow-border">								
				<center><button><span><?php echo $lang['add_votesite']; ?></span></button></center>			
			</div>		
			</form>
		</div>
	</div>

<?php
}
else
{
?>
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / Vote Links</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<?php
				if(isset($_POST['action']))
				{
					if($_POST['action'] == 'addSite')
					{
						addSite();
					}
				}
			?>
			<form method="POST" action="?p=admin&sub=vote&addlink=true" class="form label-inline">
			<input type="hidden" name="action" value="update">
				<h5><center>List of Vote Sites</center></h5><br />
				<table>
					<thead>
						<th><center><b><?php echo $lang['hostname']; ?></center></b></th>
						<th><center><b><?php echo $lang['image']; ?></center></b></th>
						<th><center><b><?php echo $lang['vote_link']; ?></center></b></th>
						<th><center><b><?php echo $lang['points']; ?></center></b></th>
					</thead>
				<?php
					if($get_sites != FALSE)
					{
						foreach($get_sites as $site)
						{
							echo "
								<tr>
									<td width='25%' align='center'><a href='?p=admin&sub=vote&id=".$site['id']."'>".$site['hostname']."</a></td>
									<td width='35%' align='center'>".$site['image_url']."</td>
									<td width='25%' align='center'><a href='".$site['votelink']."'>".$site['votelink']."</a></td>
									<td width='15%' align='center'>".$site['points']."</td>
								</tr>
							";
						}
					}
				?>
				</table>
			<br />
			<div class="buttonrow-border">								
				<center><button><span>Add New Link</span></button></center>			
			</div>
			</form>
		</div>
	</div>
<?php
} ?>