<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => $lang['login'], 'link' => '');
// ==================== //

/*
	When posting to this page, It MUST be in this format:
	name='action' value='value'
	
	Values:
	'login' = logs the user in
		POST Values:
		login = username;
		pass = password;
	'logout' = logs the user out
	'profile' = redirects user to account screen
*/


// Tell the cache system not to cache this page
define('CACHE_FILE', FALSE);


// Lets check to see if the user has posted something
if(isset($_POST['action']))
{
	// If posted action was login
	if($_POST['action'] == 'login')
	{
		$login = $_POST['login'];
		$pass = $Account->sha_password($login, $_POST['pass']);
		$EMAIL = $DB->selectCell("SELECT `email` FROM `account` WHERE `username` LIKE '".$_POST['login']."' LIMIT 1");
		
		// initiate the login array, and send it in
		$params = array('username' => $login, 'sha_pass_hash' => $pass);
		$Login = $Account->login($params);
		
		// If account login was successful
		if($Login == 1)
		{	
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
