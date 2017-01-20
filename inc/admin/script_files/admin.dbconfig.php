<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//

if($user['account_level'] != 4)
{
	echo "You do not have sufficiant rights to view this page!";
	die();
}

function saveConfig() 
{
	global $lang;
	
	$conffile = "config/config-protected.php";
	$build = '';
	$build .= "<?php\n";
	$build .= "\$db = array(\n";
	$build .= "'db_host'         => '".$_POST['db_host']."',\n";
	$build .= "'db_port'         => '".$_POST['db_port']."',\n";
	$build .= "'db_username'     => '".$_POST['db_username']."',\n";
	$build .= "'db_password'     => '".$_POST['db_password']."',\n";
	$build .= "'db_name'         => '".$_POST['db_name']."',\n";
	$build .= "'db_encoding'     => 'utf8',\n";
	$build .= ");\n";
	$build .= "?>";
		
	if (is_writeable($conffile))
	{
        $openconf = fopen($conffile, 'w+');
        fwrite($openconf, $build);
        fclose($openconf);
		output_message('success', $lang['config_updated_successfully']);
	}
	else
	{ 
		output_message('error', 'Couldn\'t open main-config.php for editing, it must be writable by webserver! <br /><a href="javascript: history.go(-1)">Go back, and try again.</a>');
	}
}
?>