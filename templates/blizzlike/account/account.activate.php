<br>
<?php builddiv_start(1, $lang['account_activate']) ?>
<table align="center" width="100%" style="font-size:0.8em;">
	<tr>
		<td align="center">
		<?php
			if(empty($_GET['key']))
			{
		?>		
			<form action="?p=account&sub=activate" method="post">
				<div style="background:none; margin:4px; padding:6px 9px 6px 9px; text-align: center; width:80%;">
					<b>Activation Key:</b> <input type="text" size="45" maxlength='50' class="addbutton2" style="font-size:11px;" name="key">					
				</div>
				<div style="background:none; margin:4px; padding:6px 9px 6px 9px; text-align: center; width:80%;">
					<b>Account Username:</b> <input type="text" size="25" maxlength='50' class="addbutton2" style="font-size:11px;" name="user">					
				</div>			
				<div style="background:none; margin:4px; padding:6px 9px 6px 9px; text-align:center; width:80%;">
					<input type="submit" size="16" class="button" style="font-size:12px;" value="<?php echo $lang['account_activate']; ?>">
				</div>
			</form>	
		<?php
			}
			else
			{
				CheckKey();
			}
		?>                          
		</td>
	</tr>
</table>
<?php builddiv_end() ?>