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

if(isset($_POST['reset']))
{
	redirect('?p=admin&sub=cache&action=reset',1);
}

function clearCache()
{
	global $Core, $lang;
	$Core->clearCache();
	output_message('success', $lang['cache_clear_success'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=cache">');
}

function saveConfig() 
{
	global $Config, $lang;

	foreach ($_POST as $item => $val) 
	{
		$key = explode('__', $item);
		if ($key[0] == 'cfg') 
		{
			$Config->set($key[1],$val);
		}
	}
	$Config->Save();
	
	output_message('success', $lang['cache_settings_saved'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=cache">');
}
?>