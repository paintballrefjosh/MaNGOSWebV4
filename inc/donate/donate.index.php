<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => $lang['donate'], 'link' => '');
// ==================== //

// We define not to cache the page
define("CACHE_FILE", FALSE);

//	************************************************************
// Users must be logged in

if($Account->isLoggedIn() == FALSE)
{
	redirect('?p=account&sub=login',1);
}

// Enter the page descrition
$PAGE_DESC = $lang['donate_desc'];

// Include the paypal class
include('core/lib/class.paypal.php');
$Paypal = new Paypal;

// Get an array of all donate packages
$donate_packages = $DB->select("SELECT * FROM `mw_donate_packages`");

function confirmPayment()
{
	global $DB, $user, $lang;
	$pay = $DB->selectRow("SELECT * FROM `mw_donate_transactions` WHERE `account`='".$user['id']."' AND `item_given`='0' LIMIT 1");
	if($pay == FALSE)
	{
		output_message('validation', $lang['donate_no_trans']);
		echo '<br /><br /><center><b><u>Redirecting...</u></b></center> <meta http-equiv=refresh content="8;url=?p=donate">';
	}
	else
	{
		if($pay['payment_status'] == 'Completed')
		{
			$item = $DB->selectRow("SELECT * FROM `mw_donate_packages` WHERE `id`='".$pay['item_number']."'");
			if($item['cost'] > $pay['amount'])
			{
				output_message('error', $lang['donate_not_face_value']);
			}
			else
			{
				$DB->query("UPDATE `mw_donate_transactions` SET `item_given`='1' WHERE `account`='".$user['id']."' AND `id`='".$pay['id']."' LIMIT 1");
				$DB->query("UPDATE `mw_account_extend` SET 
					`web_points` = (`web_points` + ".$item['points']."),
					`points_earned` = (`points_earned` + ".$item['points']."),
					`total_donations` = (`total_donations` + ".$pay['amount'].")
				  WHERE `account_id`='".$user['id']."'");
				output_message('success', $lang['donate_points_given']);
			}
		}
		else
		{
			output_message('warning', $lang['donate_status_not_complete']);
		}
	}
}
?>
