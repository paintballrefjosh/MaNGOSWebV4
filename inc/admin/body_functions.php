<?php
// Setup the admin language file.
unset($lang);
include('lang/' . $GLOBALS["user_cur_lang"] . '/admincp.php');

if(ini_get('allow_url_fopen') == '1') 
{ 
	$allowfopen = "<font color='green'>Yes</font>"; 
}
else
{ 
	$allowfopen = "<font color='red'>No!</font>"; 
}

if(function_exists("fsockopen")) 
{
   $fsock = "<font color='green'>Yes</font>";
}
else
{
	$fsock = "<font color='red'>No!</font>";
}

function admin_paginate($totalrows, $limit, $page, $link_to)
{
	if($page != 1) 
	{ 
		$pageprev = $page-1;
		echo "<a href=\"".$link_to."&page=1\">&laquo; First</a>&nbsp;&nbsp;&nbsp;";  
		echo "<a href=\"".$link_to."&page=".$pageprev."\">&laquo; Previous</a>&nbsp;&nbsp;";  
	}
	else
	{
		echo "<span class='disabled'>&laquo; First </span>&nbsp;&nbsp;&nbsp;";
		echo "<span class='disabled'>&laquo; Previous</span>&nbsp;&nbsp;";
	}
	$numofpages = ceil($totalrows / $limit);

	// === START BUTTON LOADING === //
		// If the current page is higher then 5
		if($page > 5)
		{
			$start = $page - 5; # start at the current page, 5 back
		}
		else
		{
			$start = 1; # start at 1, because 5 back is a negative number
		}
		
		// If page is lower then 5, we have less then 5 previous, so we want more
		// Nexts to equal out to 10
		if($start < 5)
		{
			$end = (10 - $start);
		}
		else
		{
			$end = $page + 5; # End number is 5 plus our current page
		}
		
		// If the end number is greater then our number of pages, we want
		// more previous page number to equal 10 total
		if($numofpages <= $end)
		{
			$overpage = $end - $numofpages; # find out how many under 5 we have
			$start = $start - $overpage; # set the new start to (page -5) - how many over
		}
		if($start <= 0)
		{
			$start = 1;
		}
		
	// Now that we hae a start and finish, lets add out buttons
	for($j = $start; $j <= $end && $j <= $numofpages; $j++)
	{
		if($j == $page)
		{
			echo "<a  class='current'  href=\"".$link_to."&page=".$j."\">".$j."</a>&nbsp;&nbsp;";
		}
		else
		{
			echo "<a href=\"".$link_to."&page=".$j."\">$j</a>&nbsp;&nbsp;"; 
		}
	}
	if(($totalrows % $limit) != 0)
	{
		if($j == $page)
		{
			echo "<a  class='current'  href=\"".$link_to."&page=".$j."\">".$j."</a>&nbsp;&nbsp;";
		}
		else
		{
			echo "<a href=\"".$link_to."&page=".$j."\">$j</a>&nbsp;&nbsp;";
		}
	}	
	if(($totalrows - ($limit * $page)) > 0)
	{
		$pagenext   = $page + 1;
		echo "<a href=\"".$link_to."&page=".$pagenext."\">Next &raquo;</a>&nbsp;&nbsp;&nbsp;";
		echo "<a href=\"".$link_to."&page=".$numofpages."\">Last &raquo;</a>&nbsp;&nbsp;";
	}
	else
	{
		echo "<span class='disabled'>Next &raquo;</span>&nbsp;&nbsp;&nbsp;";
		echo "<span class='disabled'>Last &raquo;</span>"; 
	} 
}
?>