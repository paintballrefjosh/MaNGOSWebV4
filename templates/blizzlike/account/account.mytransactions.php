<style type="text/css">
  div.noErrorMsg { width: 80%; height: 30px; line-height: 30px; font-size: 10pt; border: 2px solid #00ff24; background: #afffa9;}
  div.errorMsg { width: 80%; height: 30px; line-height: 30px; font-size: 10pt; border: 2px solid #e03131; background: #ff9090;}
  td.serverStatus1 { font-weight: bold; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus2 { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus3 { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>
<br />
<?php 
builddiv_start(1, $lang['my_donate_transactions']);

// Start Loading of vote sites
if($transactions != FALSE)
{
	write_metalborder_header(); 
?>
	<table cellpadding='3' cellspacing='0' width='100%'>
    <tbody>
		<tr> 
			<td class="rankingHeader" align="center" colspan='5' nowrap="nowrap"><?php echo $lang['my_donate_transactions']; ?></td>          
		</tr>
		<tr>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['transaction_id'];?>&nbsp;</td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['payment_type'];?>&nbsp;</td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['payment_status'];?>&nbsp;</td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['amount'];?>&nbsp;</td>
		</tr>
<?php
		foreach($transactions as $donate)
		{
?>
			<tr>
				<td class="serverStatus1" align="center"><?php echo $donate['trans_id']; ?></td>
				<td class="serverStatus1" align="center"><?php echo $donate['payment_type']; ?></td>
				<td class="serverStatus1" align="center"><?php echo $donate['payment_status']; ?></td>
				<td class="serverStatus1" align="center">$<?php echo $donate['amount']; ?></td>
			</tr>
<?php
		}
?>
	</tbody>
	</table>
<?php
	write_metalborder_footer();
}
else
{
	output_message('info', $lang['no_donate_transactions']);
}
builddiv_end(); 
?>