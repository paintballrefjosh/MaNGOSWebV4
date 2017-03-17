<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

// Use our own DATE format constant because the PHP one seems to be bugged in some PHP versions
define('DATE_RFC822_FIXED', 'D, d M Y H:i:s O');

include('config/config-protected.php');
include('core/class.database.php');
$DB = new Database(
	$dbconf['db_host'], 
	$dbconf['db_port'], 
	$dbconf['db_username'], 
	$dbconf['db_password'], 
	$dbconf['db_name']
	);

// Get the last time someone added a post (used to determine wheter we should write a new xml or not)
$last_posted_time = $DB->selectCell("SELECT `post_time` FROM `mw_news` ORDER BY post_time DESC LIMIT 0,1");

// Switch for wanted xml document.

$xml_path = "core/cache/rss/news.xml";
$write_new_file = (!file_exists($xml_path)) || ($last_posted_time > filemtime($xml_path)) || (filesize($xml_path)==0);

// IF we need to write a new xml, compose a new one
if($write_new_file)
{
	$news_posts = $DB->select("SELECT * FROM `mw_news`");

	$write_file = array();
	$write_file[] = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
	$write_file[] = "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">";
	$write_file[] = "    <channel>";
	$write_file[] = "        <title>".$mwe_config['site_title']." RSS News Feed</title>";
	$write_file[] = "        <description>".$mwe_config['site_title']." RSS News Feed</description>";
	$write_file[] = "        <atom:link href=\"http://".(str_replace('rss.php','index.php',($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])))."\" rel=\"self\" type=\"application/rss+xml\" />";
	$write_file[] = "        <link>http://".(str_replace('rss.php','index.php',($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])))."</link>";
	$write_file[] = "        <lastBuildDate>".date(DATE_RFC822_FIXED)."</lastBuildDate>";
	$write_file[] = "        <language>en-us</language>";

	foreach($news_posts as $topic)
	{

		$write_file[] = "        <item>";
		$write_file[] = "            <guid isPermaLink=\"false\">".$_SERVER['HTTP_HOST']."-".$topic['id']."</guid>";
		$write_file[] = "            <title>".htmlspecialchars($topic['title'])."</title>";
		$write_file[] = "            <pubDate>".(date(DATE_RFC822_FIXED, $topic['post_time']))."</pubDate>";
		$write_file[] = "            <description>Posted by ".htmlspecialchars($topic['posted_by']).": \n".htmlspecialchars($topic['message'])."</description>";
		$write_file[] = "        </item>";
	}
	$write_file[] = "    </channel>";
	$write_file[] = "</rss>";
	
	$output = implode("\n", $write_file);
    if (!$handle = fopen($xml_path, 'w'))
	{
        echo "Cannot open file ($xml_path)";
        exit;
    }
    fwrite($handle, $output);
    fclose($handle);
}
else
{
    $output = file_get_contents($xml_path);
}

// Make this document XML and send it to the browser
header("Content-Type: text/xml");
echo $output;
?>