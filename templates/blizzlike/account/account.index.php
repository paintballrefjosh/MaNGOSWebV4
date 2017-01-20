<br>
<?php 
builddiv_start(0, $lang['account']);
?>
<table width = "550" align='center'>
	<tr>
		<td>
			<?php
			write_subheader($lang['account_info']);
			?>
			<table width = "550" style = "border-width: 1px; border-style: dotted; border-color: #928058;">
				<tr>
					<td>
						<table width='545' style="border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $Template['path']; ?>/images/light3.jpg');">
						<tr>
							<td>
								<table border='0' cellspacing='0' cellpadding='4' width='540'>
								<tr>
									<td align='right' valign = "top" width='25%'><b>Account Status:</b></td>
									<td align='left' valign = "top" width='25%'><font color='green'><b>Active</b></font></td>
									<td align='right' valign = "top" width='25%'><b>Vote Count:<b></td>
									<td align='left' valign = "top" width='25%'><?php echo $user['total_votes']; ?></td>
								</tr>
								<tr>
									<td align='right' valign = "top" width='25%'><b>Registration Date:</b></td>
									<td align='left' valign = "top" width='25%'><?php echo $joindate; ?></td>
									<td align='right' valign = "top" width='25%'><b>Webpoint Balance:<b></td>
									<td align='left' valign = "top" width='25%'><?php echo $user['web_points']; ?></td>
								</tr>
								<tr>
									<?php 
										if($Config->get('emulator') == 'arcemu')
										{
											echo "<td align='right' valign = 'top' width='25%'><b>Last IP:</b></td>";
										}
										else
										{
											echo "<td align='right' valign = 'top' width='25%'><b>Registration IP:</b></td>";
										}
									?>
									<td align='left' valign = "top" width='25%'><?php echo $regiseter_ip; ?></td>
									<td align='right' valign = "top" width='25%'><b>Earned/Spent:<b></td>
									<td align='left' valign = "top" width='25%'><?php echo $user['points_earned']." / ".$user['points_spent']; ?></td>
								</tr>
								<tr>
									<td align='right' valign = "top" width='25%'><b>Account Level:</b></td>
									<td align='left' valign = "top" width='25%'><?php echo $user['title']; ?></td>
									<td align='right' valign = "top" width='25%'><b>Total Donations:<b></td>
									<td align='left' valign = "top" width='25%'>$<?php echo $user['total_donations']; ?></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />
<br />

<table width='550' align='center'>
	<tr>
		<td>
			<?php write_subheader($lang['account_options']); ?>
			<table width = "550" align='center' style = "border-width: 1px; border-style: dotted; border-color: #928058;">
				<tr>
					<td>
						<table width='545' style="border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $Template['path']; ?>/images/light3.jpg');">
						<tr>
							<td>

								<table width='540' align='center'>
									<tr>
										<td width='36'><img src='<?php echo $Template['path']; ?>/images/account/icon-5.png' /></td>
										<td><a href='?p=account&sub=manage'><?php echo $lang['account_manage']; ?></a></td>
										
										<td width='36'><img src='<?php echo $Template['path']; ?>/images/account/icon-1.png' /></td>
										<td><a href='?p=account&sub=customize'><?php echo $lang['char_recustomize']; ?></a></td>
									</tr>
									<tr>
										<td width='36'><img src='<?php echo $Template['path']; ?>/images/account/icon-6.png' /></td>
										<td><a href='?p=account&sub=mytransactions'>My Donate Transactions</a></td>
										<td width='36'><img src='<?php echo $Template['path']; ?>/images/account/icon-2.png' /></td>
										<td><a href='?p=account&sub=racechange'><?php echo $lang['char_racechange']; ?></a></td>
									</tr>
									<tr>
										<td width='36'><img src='<?php echo $Template['path']; ?>/images/account/icon-3.png' /></td>
										<td><a href='?p=account&sub=rename'><?php echo $lang['char_rename']; ?></a></td>
										<td width='36'><img src='<?php echo $Template['path']; ?>/images/account/icon-4.png' /></td>
										<td><a href='?p=account&sub=factionchange'><?php echo $lang['char_faction_change']; ?></a></td>
									</tr>
								</table>
							</td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
builddiv_end(); 
?>