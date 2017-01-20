<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => $lang['vote_system'], 'link' => '');
// ==================== //

// We define not to cache the page, because of the buttons disabling after the user votes.
define("CACHE_FILE", FALSE);

// Setup the page description
$PAGE_DESC = $lang['vote_desc']."<br />";

// Here we chack to see if user is logged in, if not, then redirect to account login screen
if($Account->isLoggedIn() == FALSE)
{
    redirect('?p=account&sub=login',1);
}

// If the vote system is disabled, redirect
if($Config->get("module_vote_system") == 0)
{
    redirect('?p=account',1);
}

// Check to see what realm we are using
$realm_info_new = get_realm_byid($user['cur_selected_realmd']);
$rid = $realm_info_new['id'];


// Here we get the sites and rewards from the database
$vote_sites = $DB->select("SELECT * FROM mw_vote_sites");

// This get the vote system started, we need to initiate the user
function initUser()
{
	global $vote_sites, $DB, $user;
	
	$return = array();

	// Start the loop. foreach voting site, we need to check if/when the user last voted
	// and if the vote timer is up, and the user can vote on that site again
	foreach($vote_sites as $site)
	{
		$id = $site['id'];
		$get_voting = $DB->selectRow("SELECT * FROM `mw_voting` WHERE `user_ip` LIKE '".$_SERVER["REMOTE_ADDR"]."' AND `site`='".$id."' LIMIT 1");
		if($get_voting != FALSE)
		{
			// Here we find the reset time for the vote site
			$reset_time = ($get_voting['time'] + $site['reset_time']);
			$cur_reset = ($reset_time - time()) / 3600;
			
			// If the reset time is less then 1, but higher then 0, then its less that an hour
			// and the time need to be formated in minutes
			if($cur_reset < 1 && $cur_reset > 0)
			{
				$reset = ($reset_time - time()) / 60;
				$reset = round($reset)." M";
			}
			
			// If the reset time is a negative number, then you are able to vote
			elseif($cur_reset < 0)
			{
				$reset = "N/A";
			}
			
			// If higher then 1, then its that number of hours. EX: 3 = 3 hours
			else
			{
				$reset = round($cur_reset)." H";
			}
			
			// If the current time, minus the vote time is greater then the 
			// reset time, then the timer is reset
			if((time() - $get_voting['time']) > $site['reset_time'])
			{
				$return[$id] = array(
					'time' => $get_voting['time'], 
					'voted' => FALSE,
					'reset' => 'N/A'
				);
			}
			else
			{
				$return[$id] = array(
					'time' => $get_voting['time'], 
					'voted' => TRUE,
					'reset' => $reset
				);
			}
		}
		else
		{
			$DB->query("INSERT INTO `mw_voting` (`site`, `user_ip`) VALUES ('".$id."','".$_SERVER["REMOTE_ADDR"]."')");
			$return[$id] = array(
				'time' => 0, 
				'voted' => FALSE,
				'reset' => 'N/A'
			);
		}
	}
	return $return;
}

// ****************************************
// Main voting function
// @$site = the site id number

function vote($site)
{
	global $Config, $DB, $user;
	$tab_sites = $DB->selectRow("SELECT * FROM mw_vote_sites WHERE `id`='$site'");
	
	// First we check to see the users hasnt clicked vote twice
	$get_voting = $DB->selectRow("SELECT * FROM `mw_voting` WHERE `user_ip` LIKE '".$_SERVER["REMOTE_ADDR"]."' AND `site`='".$site."' LIMIT 1");
	if((time() - $get_voting['time']) < $tab_sites['reset_time'])
	{
		output_message('validation', 'You have already voted for this site in the last 24 hours! Redirecting...
			<meta http-equiv=refresh content="4;url=?p=vote">');
		echo "<br /><br />";
	}
	else
	{
		if($tab_sites != FALSE)
		{
			if($Config->get('module_vote_onlinecheck') == 1)
			{
				$fp = @fsockopen($tab_sites['hostname'], 80, $errno, $errstr, 3);
			}
			else
			{
				$fp = True;
			}
			if($fp)
			{
				if($Config->get('module_vote_onlinecheck') == 1)
				{
					fclose($fp);
				}
				
				$DB->query("UPDATE `mw_voting` SET 
					`time`='".time()."' 
				  WHERE `user_ip` LIKE '".$_SERVER["REMOTE_ADDR"]."' AND `site`='".$site."' LIMIT 1"
				);
				
				$DB->query("UPDATE `mw_account_extend` SET 
					`web_points`=(`web_points` + ".$tab_sites['points']."), 
					`date_points`=(`date_points` + ".$tab_sites['points']."),
					`total_votes`=(`total_votes` + 1), 
					`points_earned`=(`points_earned` + ".$tab_sites['points'].")  
				   WHERE `account_id` = ".$user['id']." LIMIT 1"
				);
				output_message('info', 'Redirecting to vote site...');
				echo "<script type=\"text/javascript\">setTimeout(window.open('".$tab_sites['votelink']."', '_self'),0);</script>";
			}
			else
			{
				output_message('error', 'Unable to connect to votesite. Please try again later.');
			}
		}
		else
		{
			output_message('error', 'There is no vote site with this unique ID.');

		}
	}
}

// We need to initiate the user everytime!
$Voting = initUser();
?>