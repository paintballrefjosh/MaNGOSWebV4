<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//

// ==================== //
$pathway_info[] = array('title'=>$lang['regkeys_manage'],'link'=>'');
// ==================== //

function createKeys()
{
	global $Account, $DB;
    if($_POST['num'] < 300)
	{
        $keys_arr = $Account->generate_keys($_POST['num']);
        foreach ($keys_arr as $key) 
		{
            $DB->query("INSERT INTO mw_regkeys (`key`) VALUES('$key')");
        }
    }
    output_message('success', $_POST['num'].' Keys added to the database! Please wait to be re-directed...
		<meta http-equiv=refresh content="3;url=?p=admin&sub=regkeys">');
}

function deleteKey()
{
	global $DB;
    if($_POST['keyid'] || $_GET['keyid'])
	{
        $_GET['keyid'] ? $keyid = $_GET['keyid'] : $keyid = $_POST['keyid'];
        $DB->query("DELETE FROM mw_regkeys WHERE `id`='".$keyid."'");
    }
	elseif($_POST['keyname'])
	{
        $DB->query("DELETE FROM mw_regkeys WHERE `key`='".$_POST['keyname']."'");
    }
    output_message('success', 'Key Deleted! Please wait to be re-directed...
		<meta http-equiv=refresh content="3;url=?p=admin&sub=regkeys">');
}

function setUsed()
{
	global $DB;
    $DB->query("UPDATE mw_regkeys SET used=1 WHERE `id`='".$_GET['keyid']."'");
    output_message('success', 'Key set as Used!');
}
?>