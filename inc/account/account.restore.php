<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => 'Retrieve Password', 'link' => '');
// ==================== //

// Tell the cache system not to cache this page
define('CACHE_FILE', FALSE);

//	************************************************************
// Logged in users cannot access this page ;)

if($Account->isLoggedIn() == TRUE)
{
	redirect('?p=account&sub=manage',1);
}

// Initiate the page description
$PAGE_DESC = $lang['account_restore_desc'];

// Load secret Questions
$sc_q = $Account->getSecretQuestions();

//	************************************************************
// If user has requested his password be reset

function process()
{
	global $lang, $DB, $Account;
	
	if($_POST['retr_login'] && $_POST['retr_email'] && $_POST['secretq1'] && $_POST['secretq2'] && $_POST['secreta1'] && $_POST['secreta2']) 
	{
	  
		//set return as true - we will make false if something is wrong
		$return = TRUE;
	  
		/*Check 1*/
		$username = strip_if_magic_quotes($_POST['retr_login']);
		if(check_for_symbols($username,1) == TRUE)
		{
			$return = FALSE;
		}
		else if ($DB->selectRow("SELECT * FROM `account` WHERE username='".$username."'") == false)
		{
			$username == FALSE;
			$return = FALSE;
		}
		else
		{
			$d = $DB->selectRow("SELECT * FROM `account` WHERE username='".$username."'");
			$username =& $d['id'];
			$username_name =& $d['username'];
			$email =& $d['email'];
			
			$posted_email =& $_POST['retr_email'];
			
			/*Check 2*/
			if($email != $posted_email)
			{
				$return = FALSE;
			}
		}

		$secreta1 =& $_POST['secreta1'];
		$secreta2 =& $_POST['secreta2'];  
		/*Check 3*/
		if (check_for_symbols($_POST['secreta1']) || check_for_symbols($_POST['secreta2'])) 
		{
			$return = FALSE;
		}
		  
		if ($return == FALSE)
		{
			output_message('error', $lang['restore_pass_fail'].'<meta http-equiv=refresh content="3;url=index.php?p=account&sub=restore">');
		}
		elseif ($return == TRUE) 
		{
			$rp_sq1 = strip_if_magic_quotes($_POST['secretq1']);
			$rp_sq2 = strip_if_magic_quotes($_POST['secretq2']);
			$rp_sa1 = strip_if_magic_quotes($_POST['secreta1']);
			$rp_sa2 = strip_if_magic_quotes($_POST['secreta2']);
			$we = $DB->selectRow("SELECT account_id FROM `mw_account_extend` WHERE account_id='".$username."' AND secret_q1='".$rp_sq1."' AND secret_q2='".$rp_sq2."' AND secret_a1='".$rp_sa1."' AND secret_a2='".$rp_sa2."'");
			if($we !== FALSE)
			{
				$pas = random_string(7);
				$c_pas = $Account->sha_password($username_name,$pas);
				$DB->query("UPDATE `account` SET sha_pass_hash='".$c_pas."' WHERE id='".$username."'");
				$DB->query("UPDATE `account` SET sessionkey=NULL WHERE id='".$username."'");
				output_message('success', $lang['restore_pass_success'].'<br /> New password: '.$pas);
			}
			else
			{
				output_message('error', $lang['restore_pass_fail'].'<meta http-equiv=refresh content="3;url=index.php?n=account&sub=restore">');
			}
		}
	}
	else
	{
		output_message('error', $lang['restore_pass_fail'].'<meta http-equiv=refresh content="3;url=index.php?p=account&sub=restore">');
		echo "<br />";
	}
}
?>
