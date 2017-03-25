<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

?>
<div class="content">	
	<div class="content-header">
		<h4><a href="?p=admin">Main Menu</a> / Updates</h4>
	</div>		
	<div class="main-content">
<?php 
			if(!isset($_GET['update']))
			{
?>
		<table width="100%">
			<thead>
				<th>Core Update Info</th>
			</thead>
		</table>
		<br />
		<table>
			<tr>
<?php
				checkCoreUpdates();
?>
			</tr>
		</table>
		<br /><br />
<?php
			}
?>
		<table width="100%">
			<thead>
				<th>Database Update Info</th>
			</thead>
		</table>
		<br />
		<table>
			<tr>
<?php
			if(isset($_GET['update']) && $_GET['update'] == "db")
			{
				updateDatabase();
			}
			else
			{
				checkDatabaseUpdates();
			}
?>
			</tr>
		</table>		
	</div>
</div>
