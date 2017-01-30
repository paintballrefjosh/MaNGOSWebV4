<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//

if(isset($_GET['action']))
{
	// jquery / ajax character name lookup
	if($_GET['action'] == "search")
	{
		$characters = $CDB->select("SELECT guid, name FROM characters WHERE name LIKE '%".$_GET['term']."%'");
		foreach($characters as $row)
		{
			$json[]=array(
			'value' => $row['name'],
			'id' => $row['guid']
			);
		}

		die(json_encode($json));
	}
}

function sendCharacterMail()
{
	include('core/SDL/class.rasocket.php');
	$RA = new RA;

	$command = "send mail ".$_POST['mail_to']." \"".$_POST['subject']."\" \"".$_POST['msg']."\"";

	$response = $RA->send($command, $GLOBALS['cur_selected_realm']);
	if($response == 1)
	{
		output_message('error', 'Error: Unable to connect to server via remote access / SOAP.');
	}
	elseif($response == 2)
	{
		output_message('error', 'Error: You are not authorized to perform this command.');
	}
	else
	{
		output_message('success', 'Success: Your in game message has been sent to '.$_POST['mail_to'].'.');
	}
	
	$RA = null;
}

?>