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
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => $lang['login'], 'link' => '');
// ==================== //

// Lets check to see if the user has posted something
if(isset($_POST['action']))
{
	// If posted action was login
	if($_POST['action'] == 'login')
	{
		$login = $_POST['login'];
		$pass = $Account->sha_password($login, $_POST['pass']);
		$account_id = $RDB->selectCell("SELECT `id` FROM `account` WHERE `username` = '".$_POST['login']."' LIMIT 1");
		
		// initiate the login array, and send it in
		$params = array('username' => $login, 'sha_pass_hash' => $pass);
		$Login = $Account->login($params);
		
		// If account login was successful
		if($Login == 1)
		{
			// Make sure account exists in mw_account_extend table, if not then insert one of type "member" aka registered user
			$mw_account = $DB->selectCell("SELECT account_id FROM mw_account_extend WHERE account_id = '".$account_id."'");
			if(!$mw_account)
			{
				$DB->query("INSERT INTO mw_account_extend (account_id, account_level) VALUES ($account_id, 2)");
			}
			// Once finished, redirect to the page we came from
			redirect($_SERVER['HTTP_REFERER'],1);
		}
	}
	
	// Else if the action is logout
	elseif($_POST['action'] == 'logout')
	{
		$Account->logout();
		redirect($_SERVER['HTTP_REFERER'],1);
	}
	
	// Otherwise redirect to profile
	elseif($_POST['action'] == 'profile')
	{
		redirect('?p=account',1);
	}
}
?>
