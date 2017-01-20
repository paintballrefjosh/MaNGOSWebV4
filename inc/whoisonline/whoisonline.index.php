<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
 $pathway_info[] = array('title'=>$lang['who_is_online'],'link'=>'');
// ==================== //

// Initiate the People array and get whois online
$People = array();
$result = $DB->select("SELECT * FROM `mw_online` ORDER BY `user_name`");

// Foreach result, we need to filter out the users who havent been seen in the
// last 5 minutes, and add them to the People array
foreach($result as $result_row )
{
	parse_str(parse_url($result_row['currenturl'], PHP_URL_QUERY), $tmpurl_arr);
	if(!$result_row['user_name'])
	{
		$result_row['user_name'] = 'Guest';
	}
	$result_row['currenturl_name'] = substr($result_row['currenturl'],0,50);
	
	// If the url is 'admin'
	if($tmpurl_arr['p']=='admin')
	{
		$result_row['currenturl'] = '#';
		$result_row['currenturl_name'] = 'Admin panel';
	}
  
  $People[] = $result_row;
}
?>