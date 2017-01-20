<div class="content">	
	<div class="content-header">
		<h4><a href="?p=admin">Main Menu</a> / Cache Settings</h4>
	</div> <!-- .content-header -->	
	<div class="main-content">
		<?php
			if(isset($_GET['action']))
			{
				if($_GET['action'] == 'reset')
				{
					clearCache();
				}
			}
			if(isset($_POST['task']))
			{
				saveConfig();
			}
		?>
		<form method="POST" action="?p=admin&sub=cache" name="adminform" class="form label-inline">
		<input type="hidden" name="task" value="update">
			<table>
				<thead>
					<tr>
						<th><center><?php echo $lang['cache_settings']; ?></center></th>
					</tr>
				</thead>
			</table>
			<br />
			
			<div class="field">
				<label for="Site Enable Cache"><?php echo $lang['cache_system']; ?>: </label>
				<select id="type" class="small" name="cfg__enable_cache">
					<?php 
						if($Config->get('enable_cache') == 1)
						{ $e_cc = 'selected="selected"'; $e_cc2 = ''; }else{ $e_cc2 = 'selected="selected"'; $e_cc = ''; }
					?>
					<option value="1" <?php echo $e_cc; ?>><?php echo $lang['enabled']; ?></option>
					<option value="0" <?php echo $e_cc2; ?>><?php echo $lang['disabled']; ?></option>
				</select>																											
				<p class="field_help"><?php echo $lang['cache_system_desc']; ?></p>
			</div>
			
			<div class="field">
				<label for="Site cache_expire_time"><?php echo $lang['cache_expire_time']; ?>: </label>
				<input id="Site cache_expire_time" name="cfg__cache_expire_time" size="10" type="text" class="xsmall" value="<?php echo $Config->get('cache_expire_time'); ?>" />
				<p class="field_help"><?php echo $lang['cache_expire_desc']; ?></p>
			</div>
			
			<div class="buttonrow-border">								
				<center>
					<button><span><?php echo $lang['cache_update']; ?></span></button>
					<button class="btn-sec" name="reset"><span><?php echo $lang['cache_clear']; ?></span></button>
				</center>	
			</div>
		</form>
	</div>
</div>