<style type="text/css">
	a.server { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; font-weight: bold; }
    td.serverStatus1 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
    td.serverStatus2 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
    td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; 
	border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>
<br />
<?php
builddiv_start(1, 'Shop');
echo $lang['shop_desc']."<br /><br />";

if($shop_items != FALSE)
{
	foreach($shop_items as $package)
	{
		write_metalborder_header();
		echo "
			<form action='". mw_url('shop', 'checkout') ."' method='POST'>
			<input type='hidden' name='action' value='step2'>
			<input type='hidden' name='id' value='".$package['id']."'>
			<table cellpadding='3' cellspacing='0' width='100%'>
				<tbody>
					<tr> 
						<td class='rankingHeader' align='center' colspan='3' nowrap='nowrap'>
							Shop Package #".$package['id']." :: <font color='green'>".$package['desc']."</font>
						</td>
					</tr>
					<tr>
						<td class='rankingHeader' align='center' nowrap='nowrap'>Rewards</td>
						<td class='rankingHeader' align='center' nowrap='nowrap'>Cost</td>
						<td class='rankingHeader' align='center' nowrap='nowrap'>Action&nbsp;</td>
					</tr>
					<tr>
						<td width='60%' class='serverStatus1' style='text-align: center;'><font size='-1'>";
							if($package['item_number'] != 0)
							{
								$items = explode(',', $package['item_number']);
								foreach($items as $pack)
								{
									$item_name = $WDB->selectCell("SELECT `name` FROM `item_template` WHERE entry='".$pack."'");
									echo "<a href='http://www.wowhead.com/?item=".$pack."' target='_blank'>".$item_name."</a><br />";
								}
							}
							if($package['itemset'] != 0) 
							{ 
								echo "<a href='http://www.wowhead.com/?itemset=".$package['itemset']."' target='_blank'>ItemSet # ".$package['itemset']."</a><br />"; 
							}
							if($package['gold'] != 0) 
							{ 
								echo "<font color='darkgreen'><b>Gold</b>: </font>"; print_gold($package['gold']); 
							}
				echo"		</font>
						</td>
						<td class='serverStatus1' style='text-align: center; font-size: 12px;'>
							<font color='darkred'><u>".$package['wp_cost']."</u></font> Web Points<br />
						</td>
						<td class='serverStatus1' style='text-align: center;'><font size='-1'>
							<input type='submit' value='Select'>
						</td>
					</tr>
				</tbody>
			</table>
			</form>";
		write_metalborder_footer();
		echo "<br /><br />";
	}
}
builddiv_end();
?>