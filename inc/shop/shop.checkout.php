<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => 'Shop', 'link' => '');
// ==================== //

define("CACHE_FILE", FALSE);

// Lets check to see the user is logged in
if($user['id'] <= 0)
{
    redirect('?p=account&sub=login',1);
}

// There must always be a "name='action'" post to this page
if(!isset($_POST['action']))
{
	redirect('?p=shop',1);
}

$package = $DB->selectRow("SELECT * FROM `mw_shop_items` WHERE `id`='".$_POST['id']."'");
$character_list = $Account->getCharacterList($user['id']);

// Include the RA Socket class
include('core/SDL/class.rasocket.php');
$RA = new RA;

//	************************************************************
// Main sending function

function completeOrder()
{
	global $RA, $user, $DB, $WDB, $package, $lang;
	
	// Lets check to see if the realm is online before starting
	$realm = get_realm_byid($GLOBALS['cur_selected_realm']);
	if(!check_port_status($realm['address'], $realm['port'], 3))
	{
		output_message('error', $lang['shop_realm_offline']);
		return FALSE;
	}
	
	// Second check to see if the user has enough points
	if($package['wp_cost'] > $user['web_points'])
	{
		output_message('validation', $lang['not_enough_points']);
		return FALSE;
	}
	
	// Initiate the command array
	$command = array();
	
	// If there is an item number for the selected package
	if($package['item_number'] != 0) 
	{
		$item_array = '';
		$package_array = explode(',', $package['item_number']);
		foreach($package_array as $a)
		{
			$item_array .= $a.":".$package['quanity']." ";
		}
		$command[] = "send items ".$_POST['char']." \"".$lang["shop_mail_subject"]."\" \"".
			$lang["shop_mail_message"]."\" ".$item_array;
	}
	
	// If there is an itemset for this package, we need to make a command for that as well
	if($package['itemset'] != 0) 
	{
		$qray = $WDB->select("SELECT `entry` FROM `item_template` WHERE `itemset`='".$package['itemset']."'");
		$items = '';
		foreach($qray as $d)
		{
			$items .= $d['entry'].":1 ";
		}
		$command[] = "send items ".$_POST['char']." \"".$lang["shop_mail_subject"]."\" \"".
				$lang["shop_mail_message"]."\" ".$items;
	}
	
	// If there is gold in this package, make a command for that
	if($package['gold'] != 0) 
	{
		$command[] = "send money ".$_POST['char']." \"".$lang["shop_mail_subject"]."\" \"".
			$lang["shop_mail_message"]."\" ".$package['gold'];
	}
	
	// === Send the command to the RA Class === //
	$send = $RA->send($command, $GLOBALS['cur_selected_realm']);
	
	// Catch the result of send. If its a 1 or 2, then the send wasnt successful
	if($send == 1 || $send == 2)
	{
		output_message('error', $lang['shop_send_error']);
		return FALSE;
	}
	else # Command was sent successfully
	{
		// Initiate our counts
		$success = 0;
		$total_commands = count($command);
		
		// Return will be in an array, so foreach array variable, we need the result
		foreach($send as $report)
		{
			// If in the string, the characters name is listed, then its a success
			if(strpos($report, $_POST['char']))
			{
				$success++;
			}				
		}

		// If the success count is equal to the total amount of commands sent
		// Then all was successful
		if($success == $total_commands)
		{
			output_message('success', 'Items Sent Successfully!');
			
			// Update the DB, subtracting the cost of the package
			$DB->query("UPDATE `mw_account_extend` SET
				`web_points`=(`web_points` - ".$package['wp_cost']."),  
				`points_spent`=(`points_spent` + ".$package['wp_cost'].")  
			   WHERE `account_id` = ".$user['id']." LIMIT 1"
			);
		}
		else
		{
			output_message('validation', $lang['shop_error']);
		}
	}
}
?>