<?php
if(isset($_GET['id']))
{
?>
	<!-- EDITING ITEM -->
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=shop">Shop Items</a> / Edit</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<?php
				if(isset($_POST['action']))
				{
					if($_POST['action'] == 'edit')
					{
						if(isset($_POST['delete']))
						{
							deleteItem();
						}
						else
						{
							editItem();
						}
					}
				}
			?>
			<form method="POST" action="?p=admin&sub=shop&id=<?php echo $_GET['id']; ?>" class="form label-inline">
			<input type="hidden" name="action" value="edit">
			<?php
				$edit_info = $DB->selectRow("SELECT * FROM `mw_shop_items` WHERE `id`='".$_GET['id']."'");
			?>
			
			<!-- Item Number -->
			<div class="field">
				<label for="ItemNumber"><?php echo $lang['item_number']; ?>: </label>
				<input id="ItemNumber" name="item_number" size="20" type="text" class="medium" value="<?php echo $edit_info['item_number']; ?>" />
				<p class="field_help"><?php echo $lang['item_number_desc']; ?></p>
			</div>
			
			<!-- Itemset -->
			<div class="field">
				<label for="Itemset"><?php echo $lang['itemset']; ?>: </label>
				<input id="Itemset" name="itemset" size="20" type="text" class="medium" value="<?php echo $edit_info['itemset']; ?>" />
				<p class="field_help"><?php echo $lang['itemset_desc']; ?></p>
			</div>
			
			<!-- Gold -->
			<div class="field">
				<label for="Gold"><?php echo $lang['gold']; ?>: </label>
				<input id="Gold" name="gold" size="20" type="text" class="medium" value="<?php echo $edit_info['gold']; ?>" />
				<p class="field_help"><?php echo $lang['gold_desc']; ?></p>
			</div>
			
			<!-- Desc -->
			<div class="field">
				<label for="Itemdesc"><?php echo $lang['description']; ?>: </label>
				<input id="Itemdesc" name="desc" size="20" type="text" class="large" value="<?php echo $edit_info['desc']; ?>" />
				<p class="field_help"><?php echo $lang['shop_item_desc']; ?></p>
			</div>
			
			<!-- Quantity -->
			<div class="field">
				<label for="q"><?php echo $lang['quantity']; ?>: </label>
				<input id="q" name="quanity" size="20" type="text" class="tiny" value="<?php echo $edit_info['quanity']; ?>" />
				<p class="field_help"><?php echo $lang['quantity_desc']; ?></p>
			</div>
			
			<!-- Web Point Cost -->
			<div class="field">
				<label for="Cost"><?php echo $lang['web_point_cost']; ?>: </label>
				<input id="Cost" name="wp_cost" size="20" type="text" class="tiny" value="<?php echo $edit_info['wp_cost']; ?>" />
				<p class="field_help"><?php echo $lang['web_point_cost_desc']; ?></p>
			</div>
			
			<!-- Realms -->
			<div class="field">
				<label for="realms"><?php echo $lang['realm']; ?>: </label>
				<select id="type" class="small" name="realms">
					<option value="0"><?php echo $lang['all_realms']; ?></option>
					<?php echo $realmzlist; ?>
				</select>
				<p class="field_help"><?php echo $lang['realms_desc']; ?></p>
			</div>
			
			<div class="buttonrow-border">								
				<center>
					<button><span>Update Shop Item</span></button>
					<button class="btn-sec" name="delete"><span>DELETE Shop Item</span></button>
				</center>					
			</div>
			
			</form>
		</div>
	</div>
<?php
}
elseif(isset($_GET['additem']))
{
?>

<!-- ADDING LINK -->
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=shop">Shop Items</a> / ADD</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">	
		<?php
				if(isset($_POST['action']))
				{
					if($_POST['action'] == 'add')
					{
						addItem();
					}
				}
			?>
			<form method="POST" action="?p=admin&sub=shop&additem=true" class="form label-inline">
			<input type="hidden" name="action" value="add">
			
			<!-- Item Number -->
			<div class="field">
				<label for="ItemNumber"><?php echo $lang['item_number']; ?>: </label>
				<input id="ItemNumber" name="item_number" size="20" type="text" class="medium" />
				<p class="field_help"><?php echo $lang['item_number_desc']; ?></p>
			</div>
			
			<!-- Itemset -->
			<div class="field">
				<label for="Itemset"><?php echo $lang['itemset']; ?>: </label>
				<input id="Itemset" name="itemset" size="20" type="text" class="medium" />
				<p class="field_help"><?php echo $lang['itemset_desc']; ?></p>
			</div>
			
			<!-- Gold -->
			<div class="field">
				<label for="Gold"><?php echo $lang['gold']; ?>: </label>
				<input id="Gold" name="gold" size="20" type="text" class="medium"  />
				<p class="field_help"><?php echo $lang['gold_desc']; ?></p>
			</div>
			
			<!-- Desc -->
			<div class="field">
				<label for="Itemdesc"><?php echo $lang['description']; ?>: </label>
				<input id="Itemdesc" name="desc" size="20" type="text" class="large" />
				<p class="field_help"><?php echo $lang['shop_item_desc']; ?></p>
			</div>
			
			<!-- Quantity -->
			<div class="field">
				<label for="q"><?php echo $lang['quantity']; ?>: </label>
				<input id="q" name="quanity" size="20" type="text" class="tiny"  />
				<p class="field_help"><?php echo $lang['quantity_desc']; ?></p>
			</div>
			
			<!-- Web Point Cost -->
			<div class="field">
				<label for="Cost"><?php echo $lang['web_point_cost']; ?>: </label>
				<input id="Cost" name="wp_cost" size="20" type="text" class="tiny" />
				<p class="field_help"><?php echo $lang['web_point_cost_desc']; ?></p>
			</div>
			
			<div class="field">
				<label for="realms"><?php echo $lang['realm']; ?>: </label>
				<select id="type" class="small" name="realms">
					<option value="0"><?php echo $lang['all_realms']; ?></option>
					<?php echo $realmzlist; ?>
				</select>
				<p class="field_help"><?php echo $lang['realms_desc']; ?></p>
			</div>
			
			<div class="buttonrow-border">								
				<center><button><span>Add Shop Item</span></button></center>			
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
			<h4><a href="?p=admin">Main Menu</a> / Shop Items</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<form method="POST" action="?p=admin&sub=shop&additem=true" class="form label-inline">
				<h5><center><?php echo $lang['list_shop_items']; ?></center></h5><br />
				<table>
					<thead>
						<th><center><b>ID</center></b></th>
						<th><center><b><?php echo $lang['reward']; ?></center></b></th>
						<th><center><b><?php echo $lang['quantity']; ?></center></b></th>
						<th><center><b><?php echo $lang['cost']; ?></center></b></th>
						<th><center><b><?php echo $lang['realm']; ?></center></b></th>
						<th><center><b><?php echo $lang['action']; ?></center></b></th>
					</thead>
				<?php
					if($getitems != FALSE)
					{
						foreach($getitems as $row)
						{
							echo "
								<tr>
									<td width='10%' align='center'>".$row['id']."</td>
									<td width='40% align='center'><center>";
									if($row['item_number'] != 0)
									{
										$item_name = $WDB->selectCell("SELECT `name` FROM `item_template` WHERE entry='".$row['item_number']."'");
										if($item_name == FALSE) 
										{ 
											echo "<font color='red'> INVALID ITEM ID!</font>"; 
										}
										else
										{ 
											echo "<a href='http://www.wowhead.com/?item=".$row['item_number']."' target='_blank'>".$item_name."</a>"; 
										}
									}
									else
									{
										echo "No Item";
									}
									if($row['itemset'] != 0) 
									{ 
										echo "<br /><a href='http://www.wowhead.com/?itemset=".$row['itemset']."' target='_blank'>ItemSet # ".$row['itemset']."</a>"; 
									}
									if($row['gold'] != 0) 
									{ 
										echo "<br />Gold: "; print_gold($row['gold']); 
									}
							echo"	</center></td>								
									<td width='10%' align='center'>".$row['quanity']."</td>
									<td width='10%' align='center'>".$row['wp_cost']."</a></td>
									<td width='15%' align='center'>
									";
									if ($row['realms'] == 0) 
									{ 
										echo "All"; 
									}
									else
									{ 
										echo $row['realms']; 
									}
							echo"
									<td width='15%' align='center'><a href='?p=admin&sub=shop&id=".$row['id']."'>Edit / Del</a></td>
									</td>
								</tr>
							";
						}
					}
				?>
				</table>
				<div id="pg">
				<?php
					// If there is going to be more then 1 page, then show page nav at the bottom
					if($totalrows > $limit)
					{
						admin_paginate($totalrows, $limit, $page, '?p=admin&sub=shop');
					}
				?>
				</div>
			<br />
			<div class="buttonrow-border">								
				<center><button><span><?php echo $lang['add_new_shop_package']; ?></span></button></center>			
			</div>
			</form>
		</div>
	</div>
<?php
} ?>