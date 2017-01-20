<?php
// If a 'id' is in the URL, then access that package
if(isset($_GET['id']))
{
?>
	<!-- EDITING LINK -->
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=donate">Donate Admin</a> / Edit</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<?php
				if(isset($_POST['action']))
				{
					if($_POST['action'] == 'edit')
					{
						if(isset($_POST['delete']))
						{
							deletePkg();
						}
						else
						{
							editPkg();
						}
					}
				}
			?>
			<form method="POST" action="?p=admin&sub=donate&id=<?php echo $_GET['id']; ?>" class="form label-inline">
			<input type="hidden" name="action" value="edit">
			<?php
				$edit_info = $DB->selectRow("SELECT * FROM `mw_donate_packages` WHERE `id`='".$_GET['id']."'");
			?>
			
			<!-- Desc -->
			<div class="field">
				<label for="Link Title"><?php echo $lang['desc']; ?>: </label>
				<input id="Link Title" name="desc" size="20" type="text" class="large" value="<?php echo $edit_info['desc']; ?>" />
				<p class="field_help"><?php echo $lang['donate_desc']; ?></p>
			</div>
			
			<!-- Cost -->
			<div class="field">
				<label for="Link H"><?php echo $lang['cost']; ?>: $</label>
				<input id="Link H" name="cost" size="20" type="text" class="xsmall" value="<?php echo $edit_info['cost']; ?>" />
				<p class="field_help"><?php echo $lang['donate_cost_desc']; ?></p>
			</div>
			
			<!-- Point Reward -->
			<div class="field">
				<label for="Link H"><?php echo $lang['donate_point_reward']; ?>: </label>
				<input id="Link H" name="points" size="20" type="text" class="xsmall" value="<?php echo $edit_info['points']; ?>" />
				<p class="field_help"><?php echo $lang['donate_point_reward_desc']; ?></p>
			</div>
			
			<div class="buttonrow-border">								
				<center>
					<button><span><?php echo $lang['update_package']; ?></span></button>
					<button class="btn-sec" name="delete"><span><?php echo $lang['delete_package']; ?></span></button>
				</center>					
			</div>
			
			</form>
		</div>
	</div>
<?php
}
elseif(isset($_GET['add']))
{
?>

<!-- ADDING LINK -->
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=donate">Donate Admin</a> / ADD</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">		
			<?php
				if(isset($_POST['action']))
				{
					if($_POST['action'] == 'add')
					{
						addPkg();
					}
				}
			?>		
			<form method="POST" action="?p=admin&sub=donate&add=true" class="form label-inline">
			<input type="hidden" name="action" value="add">
			
			<!-- Desc -->
			<div class="field">
				<label for="Link Title"><?php echo $lang['desc']; ?>: </label>
				<input id="Link Title" name="desc" size="20" type="text" class="large" />
				<p class="field_help"><?php echo $lang['donate_desc']; ?></p>
			</div>
			
			<!-- Cost -->
			<div class="field">
				<label for="Link H"><?php echo $lang['cost']; ?>: $</label>
				<input id="Link H" name="cost" size="20" type="text" class="xsmall" />
				<p class="field_help"><?php echo $lang['donate_cost_desc']; ?></p>
			</div>
			
			<!-- Point reward -->
			<div class="field">
				<label for="Link H"><?php echo $lang['donate_point_reward']; ?>: </label>
				<input id="Link H" name="points" size="20" type="text" class="xsmall" />
				<p class="field_help"><?php echo $lang['donate_point_reward_desc']; ?></p>
			</div>

			<!-- Add Button -->
			<div class="buttonrow-border">								
				<center><button><span><?php echo $lang['add_package']; ?></span></button></center>			
			</div>		
			</form>
		</div>
	</div>

<?php
}
else # No Package Id Set
{
?>
	<!-- List of packages -->
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / Donate Admin</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<form method="POST" action="?p=admin&sub=donate&add=true" class="form label-inline">
				<h5><center><?php echo $lang['list_donate_packages']; ?></center></h5><br />
				<table>
					<thead>
						<th><center><b>ID</center></b></th>
						<th><center><b><?php echo $lang['description']; ?></center></b></th>
						<th><center><b><?php echo $lang['cost']; ?></center></b></th>
						<th><center><b><?php echo $lang['reward']; ?></center></b></th>
						<th><center><b><?php echo $lang['action']; ?></center></b></th>
					</thead>
				<?php
					if($get_pack != FALSE)
					{
						foreach($get_pack as $pack)
						{
							echo "
								<tr>
									<td width='10%' align='center'>".$pack['id']."</td>
									<td width='45%' align='center'>".$pack['desc']."</td>
									<td width='15%' align='center'>".$pack['cost']."</td>
									<td width='15%' align='center'>".$pack['points']."</td>
									<td width='15%' align='center'><a href='?p=admin&sub=donate&id=".$pack['id']."'>Edit / Del</a></td>
								</tr>
							";
						}
					}
				?>
				</table>
			<br />
			<div class="buttonrow-border">								
				<center><button><span><?php echo $lang['add_new_donation']; ?></span></button></center>			
			</div>
			</form>
		</div>
	</div>
<?php
} ?>