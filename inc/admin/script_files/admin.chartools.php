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

// For the search bar
if(isset($_POST['action']))
{
	if($_POST['action'] == 'sort')
	{
		redirect('?p=admin&sub=chartools&sort='.$_POST['sortby'],1);
	}
}

// Get the realm name
$Realm = get_realm_byid($GLOBALS['cur_selected_realm']);
$Realms = getRealmlist();

// Include the SDL files
include('core/SDL/class.character.php');
include('core/SDL/class.zone.php');
$Character = new Character;
$Zone = new Zone;

//====== Pagination Code ======/
$limit = 50; // Sets how many results shown per page	
if(!isset($_GET['page']) || (!is_numeric($_GET['page'])))
{
    $page = 1;
} 
else 
{
	$page = $_GET['page'];
}
$limitvalue = $page * $limit - ($limit);	// Ex: (2 * 25) - 25 = 25 <- data starts at 25

//===== Filter ==========// 
if(!isset($_GET['sortdir']))
{
	$sortdir = "asc";
}
else
{
	$sortdir = $_GET['sortdir'];
}

if(isset($_GET['sortby']))
{
	$filter = "ORDER BY ".$_GET['sortby']." ".$_GET['sortdir'];
}
else
{
	$filter = "ORDER BY name ASC";
}

if($sortdir == "asc")
{
	$sortdir = "desc";
}
else
{
	$sortdir = "asc";
}

// Get all characters
$characters = $CDB->select("SELECT * FROM `characters` $filter LIMIT $limitvalue, $limit;");
$totalrows = $CDB->count("SELECT COUNT(*) FROM `characters` $filter");
$totalrows = $totalrows['COUNT(*)'];

//===== Start of functions =====/

function deleteCharacter($character_id)
{
	global $CDB;

	$CDB->query("DELETE FROM `characters` WHERE `guid`='$character_id'");

	output_message('success', 'Success: Character successfully deleted.<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools">');
}

function updateChar()
{
	global $Character, $lang;
	if($Character->isOnline($_GET['id']) == FALSE)
	{
		if($Character->setLevel($_GET['id'], $_POST['level'])  == TRUE)
		{
			if($Character->setXp($_GET['id'], $_POST['xp'])  == TRUE)
			{
				if($Character->setMoney($_GET['id'], $_POST['money'])  == TRUE)
				{
					output_message('success', $lang['char_update_success'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
				}
				else
				{
					output_message('error', $lang['char_adjust_money_fail'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
				}
			}
			else
			{
				output_message('error', $lang['char_adjust_xp_fail'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
			}
		}
		else
		{
			output_message('error', $lang['char_set_name_fail'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
		}
	}
	else
	{
		output_message('warning', $lang['char_update_fail_online'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
	}				
}

function flagRename()
{
	global $Character, $lang;
	if($Character->setRename($_GET['id']) == TRUE)
	{
		output_message('success', $lang['char_rename_flag_set'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
	}
	else
	{
		output_message('warning', $lang['char_rename_flag_fail'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
	}
	
}

function flagCustomize()
{
	global $Character, $lang;
	if($Character->setCustomize($_GET['id']) == TRUE)
	{
		output_message('success', $lang['char_recustomize_flag_set'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
	}
	else
	{
		output_message('warning', $lang['char_recustomize_flag_fail'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
	}
}

function flagTalentReset()
{
	global $Character, $lang;
	if($Character->setResetTalents($_GET['id']) == TRUE)
	{
		output_message('success', $lang['char_talent_flag_fail'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
	}
	else
	{
		output_message('warning', $lang['char_talent_flag_fail'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
	}
}

function resetFlags()
{
	global $Character;
	if($Character->resetAtLogin($_GET['id']) == TRUE)
	{
		output_message('success', 'Character Flags Reset. Redirecting...
			<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
	}
	else
	{
		output_message('error', 'Unable to reset flags. Redirecting...
			<meta http-equiv=refresh content="3;url=?p=admin&sub=chartools&id='.htmlspecialchars($_GET['id']).'">');
	}
}
?>
