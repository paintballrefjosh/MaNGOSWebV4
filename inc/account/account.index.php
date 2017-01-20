<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => $lang['account'], 'link' => '');
// ==================== //

define("CACHE_FILE", FALSE);

// Lets check to see if the user is logged in
if($Account->isLoggedIn() == FALSE)
{
    redirect('?p=account&sub=login',1);
}

if($Config->get('emulator') == 'arcemu')
{
	$regiseter_ip = $user['lastip'];
	$joindate = '?';
}
else
{
	$regiseter_ip = $user['registration_ip'];
	$joindate = $user['joindate'];
}
?>