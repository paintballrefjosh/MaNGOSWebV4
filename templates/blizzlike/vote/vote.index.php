<br>
<?php builddiv_start(1, $lang['vote_system']);

// Initiate refresh, 20 seconds default
echo '<meta http-equiv=refresh content="20;url=?p=vote">';

if(isset($_POST["site"]))
{
	vote($_POST["site"]);
}

echo $PAGE_DESC; 
?>

<div class="contentdiv">
<style type="text/css">
  div.noErrorMsg { width: 80%; height: 30px; line-height: 30px; font-size: 10pt; border: 2px solid #00ff24; background: #afffa9;}
  div.errorMsg { width: 80%; height: 30px; line-height: 30px; font-size: 10pt; border: 2px solid #e03131; background: #ff9090;}
  td.serverStatus1 { font-weight: bold; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus2 { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus3 { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>

<?php write_metalborder_header(); ?>
    <table width="100%" cellpadding="3" cellspacing="0">
    <tbody>
        <tr>
            <td class="rankingHeader" colspan="3" align="center" nowrap="nowrap"><?php echo $lang['vote_acct_details'] ?></td>
        </tr>

		<tr>
            <td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['vote_curacct']; ?></td>
            <td class="rankingHeader" align="center" nowrap="nowrap">Vote Count</td> 
            <td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['vote_points']; ?></td> 
        </tr>

        <tr>
            <td class="serverStatus1" align="center" nowrap="nowrap"><?php echo $user['username']; ?></td>
            <td class="serverStatus1" align="center" nowrap="nowrap"><?php echo $user['total_votes']; ?></td>
            <td class="serverStatus1" align="left" nowrap="nowrap"><?php echo $lang['vote_balance'] ?> <?php echo $user['web_points']; ?>
				<br /><?php echo $lang['vote_acct_points_today'] ?> <?php echo $user['points_today']; ?></td>
        </tr>
        <tr>
            <td colspan="3" align="left"><br><b><center><?php echo $lang['vote_keep'] ?></center></b>
                <ul>
                    <li>
						You can click each link <b>once every 12 to 24 hours</b> due to vote site limits. 
					</li>			  
                    <li>
						<span style="color: red; font-weight: bold;"><?php echo $lang['vote_hack'] ?></span><br><br>
                    </li>
				</ul>
            </td>
        </tr> 
    </table>
<?php write_metalborder_footer(); ?>
<br />
<br />
<center>
<?php

// Start Loading of vote sites
if($vote_sites != FALSE)
{
	write_metalborder_header(); 
?>
	<table cellpadding='3' cellspacing='0' width='100%'>
    <tbody>
		<tr> 
			<td class="rankingHeader" align="center" colspan='6' nowrap="nowrap">Choose a Votesite</td>          
		</tr>
		<tr>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['voting_sites'];?>&nbsp;</td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['voted'];?>&nbsp;</td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['resets'];?>&nbsp;</td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['points'];?>&nbsp;</td>
			<td class="rankingHeader" align="center" nowrap="nowrap"><?php echo $lang['choose'];?>&nbsp;</td>
		</tr>
		<?php
			foreach($vote_sites as $value)
			{
				$key = $value['id'];
				$disabled ='';
				$Voted = $Voting[$key]['voted'];
				
				echo "
				<form action=\"?p=vote\" method=\"post\" target=\"_blank\">
				<input type=\"hidden\" name=\"site\" value=\"".$key."\" />
				<tr>
					<td class=\"serverStatus1\" align=\"center\" width=\"30%\">
						<img src=\"".$value['image_url']."\" border=\"0\" alt=\"".$value['hostname']."\" />
					</td>
					<td class=\"serverStatus1\" align=\"center\">";
						if($Voted == TRUE)
						{
							echo "<center><b style=\"color: rgb(102, 13, 2);\">".$lang["yes"]."</b></center>";
							$disabled = " disabled=\"disabled\"";
						}
						else
						{
							echo "<center><b style=\"color: rgb(35, 67, 3);\">".$lang["no"]."</b></center>";
						}
			echo "	</td>
					<td class=\"serverStatus1\" align=\"center\">".$Voting[$key]['reset']."</td>
					<td class=\"serverStatus1\" align=\"center\">
						<center>".$value['points']."</center>
					</td>
					<td class=\"serverStatus1\" align=\"center\">
						<center><input type=\"submit\" name=\"submit\" target=\"_blank\" value=\"".$lang['vote']."\"".$disabled." /></center>
					</td>
				</tr>
				</form>";
			}
		?>
	</tbody>
	</table>
<?php 
	write_metalborder_footer();
}
?>
</center>
<?php builddiv_end() ?>