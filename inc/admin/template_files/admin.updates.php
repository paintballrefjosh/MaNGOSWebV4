
<div class="content">	
	<div class="content-header">
		<h4><a href="?p=admin">Main Menu</a> / Updates</h4>
	</div> <!-- .content-header -->				
	<div class="main-content">
		<table width="100%">
			<thead>
				<th><center>Update Info</center></th>
			</thead>
		</table>
		<br />
		<table>
			<tr>
				<?php 
					if(isset($_GET['update']))
					{
						if($_GET['update'] == 'db')
						{
							runDatabaseSql();
						}
					}
					else
					{
						if(isset($_POST['action']))
						{
							if($_POST['action'] == 'update')
							{
								runUpdate();
							}
						}
						else
						{ 
							checkUpdates();
						}
					}
				?>
			</tr>
		</table>		
	</div>
</div>
