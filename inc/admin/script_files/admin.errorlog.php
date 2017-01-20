<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//

$getc = file_get_contents('core/logs/error_log.txt');

// If there are less then 5 characters in the error log...
if(strlen($getc) < 5)
{
	$are_errors = FALSE;
	$contents = "<center><font color='green'><b>No Errors in the error log!</b></font></center>";
}

// Otherwise, there are errors and we need to put them into an array
else
{
	$are_errors = TRUE;
	$start = explode("[", $getc);
	foreach($start as $key => $value)
	{
		$contents[$key] = $value;
	}
	
	// Unset the first error because there is no first error :p ... just a "["
	unset($contents['0']);
}

function clearLogFile()
{
	global $lang;
	$handle = fopen('core/logs/error_log.txt', 'w+');
	if($handle)
	{
		fclose($handle);
		output_message('success', $lang['error_log_cleared'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=errorlog">');
	}
	else
	{
		output_message('error', 'Unable to open the errorlog!');
	}
}
?>