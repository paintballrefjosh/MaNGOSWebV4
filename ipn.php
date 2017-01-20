<?php

// === Include the scripts to make this IPN works === //
include('core/class.config.php');
include('core/class.database.php');
include('core/lib/class.paypal.php');
// =====================================//

// Initiate the classes, and establish a DB conection
$Config = new Config;
$Paypal = new Paypal;
$DB = new Database(
	$Config->getDbInfo('db_host'), 
	$Config->getDbInfo('db_port'), 
	$Config->getDbInfo('db_username'), 
	$Config->getDbInfo('db_password'), 
	$Config->getDbInfo('db_name')
);

// Set test mode features (TRUE or FALSE)
$Paypal->testMode(FALSE);

// Lets check to see if we are valid or not
$Paypal->setLogFile('core/logs/ipn_log.txt');

// Check the payment status
$check = $Paypal->checkPayment($_POST);
if($check == TRUE)
{
	// We must break down all the fancy stuff to get the account ID
	// Format: Item info --- Account: (Account name) (# (account number))
	// ex: Item: 5 Shortswords --- Account: wilson212(#6)
	$account = explode(" --- ", $_POST['item_name']);
	$pre_accountid = $account['1'];
	$pre_accountid = str_replace("Account: ", "", $pre_accountid);
	$pre_accountid = explode("(#", $pre_accountid);
	$accountid = str_replace(")", "", $pre_accountid['1']);
	
	if(isset($_POST['pending_reason']))
	{
		$pending_reason = $_POST['pending_reason'];
	}
	else
	{
		$pending_reason = NULL;
	}
	
	if(isset($_POST['reason_code']))
	{
		$reason_code = $_POST['reason_code'];
	}
	else
	{
		$reason_code = NULL;
	}
	
	
	// Do the DB injection here
	$DB->query("INSERT INTO `mw_donate_transactions`(
		`trans_id`,
		`account`,
		`item_number`,
		`buyer_email`,
		`payment_type`,
		`payment_status`,
		`pending_reason`,
		`reason_code`,
		`amount`,
		`item_given`)
	   VALUES(
		'".$_POST['txn_id']."',
		'".$accountid."',
		'".$_POST['item_number']."',
		'".$_POST['payer_email']."',
		'".$_POST['payment_type']."',
		'".$_POST['payment_status']."',
		'".$pending_reason."',
		'".$reason_code."',
		'".$_POST['mc_gross']."',
		'0'
		)
	");
}
?>