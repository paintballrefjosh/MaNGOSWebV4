<div class="content">	
	<div class="content-header">
		<h4><a href="?p=admin">Main Menu</a> / Error logs</h4>
	</div> <!-- .content-header -->				
	<div class="main-content">
	<center><a href="?p=admin&sub=errorlog&action=clean"><font color='red'><b><?php echo $lang['clear_log']; ?></b></a></font></center>
	<?php
		if(isset($_GET['action']))
		{
			clearLogFile();
		}
	?>
	<br />
	<table align="center" style="border: 2px solid #999; width: 95%; margin-left: auto; margin-right: auto;">
		<?php 
			if($are_errors == TRUE)
			{
				foreach($contents as $error)
				{
					echo "<tr><td> [".$error."</td></tr>";
				}
			}
			else
			{
				echo $contents;
			}
		?>		
	</table>
</div>