<style media="screen" title="currentStyle" type="text/css">
    .postContainerPlain {
        font-family:arial,palatino, georgia, verdana, arial, sans-serif;
        color:#000000;
        padding:5px;
        margin-bottom: 4px;
        font-size: x-small;
        font-weight: normal;
        background-color: #E7CFA3;
        background-image: url('<?php echo $Template['path']; ?>/images/light.jpg');
        border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px;
        line-height:140%;
  }
    .postBody {
        padding:10px;
        line-height:140%;
        font-size: small;
  }
    .title {
        font-family: palatino, georgia, times new roman, serif;
        font-size: 13pt;
        color: #640909;
    }
</style>

<style type="text/css">
	small 	{font-family: verdana, arial, sans-serif; font-size:8pt; font-weight:normal;}

	.smallBold {font-family:verdana, arial, sans-serif; font-size:11px; font-weight:bold;}

   	   #text { position: absolute;
			top: 128px;
			left: 0px;

       }

		#char { position: absolute;
			top: -103px;
			left: -20px;

       }

		#wrapper { position: relative;
			z-index: 100;
       }

		#wrapper99 { position: relative;
			z-index: 99;
       }
	   
	a.server { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; font-weight: bold; }
    td.serverStatus1 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
    td.serverStatus2 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
    td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; 
	border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>

<!-- START OF DONATION BANNER -->
<table cellspacing="0" cellpadding="0" border="0" width = "100%" background = "<?php echo $Template['path']; ?>/images/donation/bg.jpg">
<tr>
	<td width = "80%" align = "center">
		<table width = "100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td>
					<div id = "wrapper">
						<div id = "char">
							<img src="<?php echo $Template['path']; ?>/images/donation/body.gif" width="83" height="177" alt="">
						</div>
					</div>
				</td>
				<td valign = "top">
					<img src="<?php echo $Template['path']; ?>/images/donation/left.jpg" width="343" height="179" alt="">
				</td>
				<!-------Box Start--->
				<td align="right" style="padding-right: 15px; padding-bottom: 15px">
					<!--PlainBox Top Start-->
					<table cellspacing="0" cellpadding="0" border="0"  border="1">
						<tr>
							<td width = "3">
								<img src = "<?php echo $Template['path']; ?>/images/donation/plainbox-top-left.gif" width = "3" height = "3" border = "0">
							</td>
							<td background = "<?php echo $Template['path']; ?>/images/donation/plainbox-top.gif"></td>
							<td width = "3">
								<img src = "<?php echo $Template['path']; ?>/images/plainbox/plainbox-top-right.gif" width = "3" height = "3" border = "0">
							</td>
						</tr>
						<tr>
							<td background = "<?php echo $Template['path']; ?>/images/donation/plainbox-left.gif"></td>
							<td style = "background-image: url('<?php echo $Template['path']; ?>/images/parchment/plain/light3.jpg');" NOWRAP>
							<!--PlainBox Top End-->
							
							<!--PlainBox Bottom-->
							</td>
							<td background = "<?php echo $Template['path']; ?>/images/donation/plainbox-right.gif"></td>
						</tr>
						<tr>
							<td>
								<img src = "<?php echo $Template['path']; ?>/images/donation/plainbox-bot-left.gif" width = "3"height = "3" border = "0">
							</td>
							<td background = "<?php echo $Template['path']; ?>/images/donation/plainbox-bot.gif"></td>
							<td>
								<img src = "<?php echo $Template['path']; ?>/images/donation/plainbox-bot-right.gif" width = "3" height = "3" border = "0">
							</td>
						</tr>
					</table>
					<!--PlainBox Bottom End-->
				</td>
			</tr>
		</table>
	</td>
</tr>
</table>
<!-- END DONATION BANNER -->

<?php
builddiv_start(0, $lang['donate']);

// First we need to check if the request is &pay=finish
if(isset($_GET['pay']))
{
	if($_GET['pay'] == 'finish')
	{
		confirmPayment();
	}
}
else # We start the page
{
	// Echo the page description from the language file
	echo $PAGE_DESC."<br /><br />";
	?>
	<ul>
		<li>Already donated? <a href='?p=donate&amp;pay=finish'>Redeem your points!</a> (You need to buy an item below first)</li>
	</ul>
	<br />
	<?php
	if($donate_packages != FALSE)
	{
		foreach($donate_packages as $package)
		{
			write_metalborder_header();
			echo "
				<table cellpadding='3' cellspacing='0' width='100%'>
					<tbody>
						<tr> 
							<td class='rankingHeader' align='center' colspan='2' nowrap='nowrap'>
								Donate Package #".$package['id']." :: <font color='green'>".$package['desc']."</font>
							</td>
						</tr>
						<tr>
							<td class='rankingHeader' align='center' nowrap='nowrap'>Reward</td>
							<td class='rankingHeader' align='center' nowrap='nowrap'>Choose&nbsp;</td>
						</tr>
						<tr>
							<td width='60%' class='serverStatus1' style='text-align: center;'><font size='-1'>
								<b>".$package['points']." ".$lang['web_points']."</b>
							</td>
							<td class='serverStatus1' style='text-align: center;'><font size='-1'>";
								$Paypal->addVar('business', $Config->get('paypal_email'));	// Payment Email
								$Paypal->addVar('notify_url', $Config->get('site_base_href').'ipn.php');
								$Paypal->addVar('return', $Config->get('site_base_href').'?p=donate');
								$Paypal->addVar('cmd', '_donations');
								$Paypal->addVar('amount', $package['cost']);
								$Paypal->addVar('item_name', $package['points'].' '.$lang['web_points'].' --- Account: '.$user['username'].'(#'.$user['id'].')');
								$Paypal->addVar('item_number', $package['id']);
								$Paypal->addVar('quantity', '1');
								$Paypal->addVar('currency_code', 'USD');
								$Paypal->addVar('no_shipping', '0');		// No shipping address needed
								$Paypal->addVar('rm', '2');			// Return method must be POST (2) for this class
								$Paypal->setButtonType('1'); // Donate button
								$Paypal->showForm();
					echo "  </td>
						</tr>
					</tbody>
				</table>";
			write_metalborder_footer();
			echo "<br /><br />";
		}
	}
}
builddiv_end(); 
?>