<div class="content">	
	<div class="content-header">
		<h4><a href="?p=admin">Main Menu</a> / Database Config</h4>
	</div> <!-- .content-header -->	
	<div class="main-content">
		<?php 
			if(isset($_POST['task'])) 
			{
				saveConfig();
			} 
		?>
		<form method="POST" action="?p=admin&sub=dbconfig" name="adminform" class="form label-inline">
		<input type="hidden" name="task" value="saveconfig">
			
			<table>
				<thead>
					<tr>
						<th><center><?php echo $lang['database_config']; ?></center></th>
					</tr>
				</thead>
			</table>
			<br />
			
			<!-- Database Host -->
			<div class="field">
				<label for="dbh"><?php echo $lang['database_host']; ?>: </label>
				<input id="dbh" name="db_host" size="20" type="text" class="medium" value="<?php echo $Config->getDbInfo('db_host'); ?>" />
				<p class="field_help"><?php echo $lang['database_host_desc']; ?></p>
			</div>
			
			<!-- Database Port -->
			<div class="field">
				<label for="dbp"><?php echo $lang['database_port']; ?>: </label>
				<input id="dbp" name="db_port" size="20" type="text" class="medium" value="<?php echo $Config->getDbInfo('db_port'); ?>" />
				<p class="field_help"><?php echo $lang['database_port_desc']; ?></p>
			</div>
			
			<div class="field">
				<label for="dbuser"><?php echo $lang['database_user']; ?>: </label>
				<input id="dbuser" name="db_username" size="20" type="text" class="medium" value="<?php echo $Config->getDbInfo('db_username'); ?>" />
				<p class="field_help"><?php echo $lang['database_user_desc']; ?></p>
			</div>
			
			<div class="field">
				<label for="dbpass"><?php echo $lang['database_pass']; ?>: </label>
				<input id="dbpass" name="db_password" size="20" type="text" class="medium" value="<?php echo $Config->getDbInfo('db_password'); ?>" />
				<p class="field_help"><?php echo $lang['database_pass_desc']; ?></p>
			</div>
			
			<div class="field">
				<label for="dbh"><?php echo $lang['database_name']; ?>: </label>
				<input id="dbh" name="db_name" size="20" type="text" class="medium" value="<?php echo $Config->getDbInfo('db_name'); ?>" />
				<p class="field_help"><?php echo $lang['database_name_desc']; ?></p>
			</div>
			
			<div class="buttonrow-border">								
				<center><button><span><?php echo $lang['update']; ?></span></button></center>			
			</div>
		</form>
	</div>
</div> <!-- .content -->	