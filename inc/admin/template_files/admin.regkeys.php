<div class="content">	
	<div class="content-header">
		<h4><a href="?p=admin">Main Menu</a> / Register Keys</h4>
	</div> <!-- .content-header -->	
	<div class="main-content">
		<table style="border-bottom: 1px solid #E5E2E2;">
			<thead>
				<th><i><?php echo $lang['description']; ?></i></th>
			</thead>
			<tr>
				<td>
					<?php echo $lang['reg_keys_desc']; ?>
				</td>
			</tr>
		</table>
		<br />
		
		<?php
			if(isset($_GET['action']))
			{
				if($_GET['action'] == 'create')
				{
					createKeys();
				}
				elseif($_GET['action'] == 'delete')
				{
					deleteKey();
				}
				elseif($_GET['action'] == 'setused')
				{
					setUsed();
				}
				elseif($_GET['action'] == 'deleteall')
				{
					$DB->query("TRUNCATE TABLE mw_regkeys");
				}
			}
		$allkeys = $DB->select("SELECT * FROM `mw_regkeys`");
		$num_keys = $DB->count("SELECT COUNT(*) FROM mw_regkeys");
		?>
		
		<p>
			<a href="?p=admin&sub=regkeys&action=deleteall" onclick="return confirm('Are you sure?');">
				<b>[ <font color="red"><?php echo $lang['delete_all_keys']; ?></font> ]</b>
			</a>
			<br/>
			<form method="post" action="?p=admin&sub=regkeys&action=create" class="form label-inline">
				<?php echo $lang['enter_num_keys']; ?>: <input type="text" name="num" size="4"> 
				&nbsp; &nbsp; <button><span>Create</span></button>
			</form>
		</p>
		<ul style="font-weight:bold;list-style:none;">
			<?php
				if($allkeys != FALSE)
				{
					foreach($allkeys as $key)
					{
						if($key['used'] == 0)
						{
							echo'<li><a href="?p=admin&sub=regkeys&action=delete&keyid='.$key['id'].'" title="Delete">[Delete]</a>
								&nbsp; '.$key['id'].') <a href="?p=admin&sub=regkeys&action=setused&keyid='.$key['id'].'" title="Mark as used">'.$key['key'].'</a></li>'."\n";
						}
						else 
						{
							echo'<li><a href="?p=admin&sub=regkeys&action=delete&keyid='.$key['id'].'" title="Delete">[Delete]</a>
							&nbsp; <s>'.$key['id'].') '.$key['key'].'</s></li>'."\n";
						}
					} 
				}
			?>
		</ul>	
	</div>
</div>