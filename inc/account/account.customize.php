<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => $lang['account'], 'link' => '?p=account');
$pathway_info[] = array('title' => $lang['char_recustomize'], 'link' => '');
// ==================== //
//	************************************************************
// Redirect users who arent logged in ;)

if($Account->isLoggedIn() == FALSE)
{
	redirect('?p=account&sub=login',1);
}

// Load the accounts character list
$character_list = $Account->getCharacterList($user['id']);

// Initiate the page description
$Page_Desc = $lang['char_recustomize_desc'];
$PAGE_DESC = str_replace('[COST]', '<font color="blue">'.$Config->get('module_charcustomize_pts').'</font>', $Page_Desc);

/* 
	Buffer function for the SDL
	we only need to do 1 check before setting the flag
	Check to see of the user has enough points
	subtract the web points :)
*/
function reCustomize()
{
	global $Config, $DB, $lang, $user;
	include('core/SDL/class.character.php');
	$Character = new Character;
	
	if($Config->get('module_charcustomize') == 0)
	{
		output_message('error', 'Nice try hacking, but not good enough.');
		return FALSE;
	}
	
	// Check to see the user has enough points
	if($user['web_points'] >= $Config->get('module_charcustomize_pts'))
	{
		if($Character->setCustomize($_POST['id']) == TRUE)
		{
			$DB->query("UPDATE `mw_account_extend` SET 
				`web_points`=(`web_points` - ".$Config->get('module_charcustomize_pts')."), 
				`points_spent`=(`points_spent` + ".$Config->get('module_charcustomize_pts').")  
			   WHERE `account_id` = ".$user['id']." LIMIT 1"
			);
			output_message('success', $lang['char_recustomize_success']);
			echo "<br /><br />";
		}
		else
		{
			output_message('warning', $lang['char_recustomize_already_set']);
			echo "<br /><br />";
		}
	}
	else
	{
		output_message('validation', $lang['not_enough_points']);
	}
}
?>