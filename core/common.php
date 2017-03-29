<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

//======= SITE VARIABLES =======//

// Define realm types
$realm_type_def = array(
    0 => 'Normal',
    1 => 'PVP',
    4 => 'Normal',
    6 => 'RP',
    8 => 'RPPVP',
    16 => 'FFA_PVP'
);

// Define realm timezones
$realm_timezone_def = array(
     0 => 'Unknown',
     1 => 'Development',
     2 => 'United States',
     3 => 'Oceanic',
     4 => 'Latin America',
     5 => 'Tournament',
     6 => 'Korea',
     7 => 'Tournament',
     8 => 'English',
     9 => 'German',
    10 => 'French',
    11 => 'Spanish',
    12 => 'Russian',
    13 => 'Tournament',
    14 => 'Taiwan',
    15 => 'Tournament',
    16 => 'China',
    17 => 'CN1',
    18 => 'CN2',
    19 => 'CN3',
    20 => 'CN4',
    21 => 'CN5',
    22 => 'CN6',
    23 => 'CN7',
    24 => 'CN8',
    25 => 'Tournament',
    26 => 'Test Server',
    27 => 'Tournament',
    28 => 'QA Server',
    29 => 'CN9',
);

//======= SITE FUNCTIONS =======//

//	************************************************************	
// Set up out messages like error and success boxes

function output_message($type, $text, $file='', $line='')
{
    if($file)$text .= "\n<br>in file: $file";
    if($line)$text .= "\n<br>on line: $line";
    echo "<div class=\"".$type."\"><b>".$text."</b></div>";
}

//	************************************************************	
// Custom Error Handler

function customError($errno, $errstr)
{
	echo "<div class=\"error\">";
	echo "<b>Error:</b> [$errno] $errstr<br />";
	echo "</div>";
}

// ======== Realm Functions ======== //

//	************************************************************	
// Gets the realmlist from realm DB. Enabled is whether the realm
// has been enabled for view by users in the ACP.

function getRealmlist()
{
	global $DB;
    
    $realms = $DB->select("SELECT * FROM `mw_realm` WHERE `site_enabled` = 1 ORDER BY `realm_id` ASC");
    
	return $realms;
}

//	************************************************************	
// Gets all Columns on the table for the selected realm

function get_realm_byid($id)
{
    global $RDB;
    $search_q = $RDB->selectRow("SELECT * FROM `realmlist` WHERE `id`='".$id."' LIMIT 0,1");
    return $search_q;
}

//	************************************************************	
/* 
	Used for checking whether a realm is online of not
	returns TRUE if realm is Online
	returns FALSE if realm is Offline
*/

function check_port_status($ip, $port, $timeout = 1)
{
	$fp1 = @fsockopen($ip, $port, $ERROR_NO, $ERROR_STR, $timeout);
    if($fp1)
	{
        fclose($fp1);
		return TRUE;
    }
	else
	{
        return FALSE;
    }
}

//	************************************************************	
// Returns poulation rating of a server. Ex: Low, Medium, High. 
// $n = server population

function population_view($n) 
{
    global $lang;
    $maxlow = 100;
    $maxmedium = 500;
    if($n <= $maxlow)
	{
        return '<font color="green">' . $lang['low'] . '</font>';
    }
	elseif($n > $maxlow && $n <= $maxmedium)
	{
        return '<font color="orange">' . $lang['medium'] . '</font>';
    }
	else
	{
        return '<font color="red">' . $lang['high'] . '</font>';
    }
}

// ======== Print Gold Functions ======== //

//	************************************************************
// Gets the fractions to figure how much gold, silver, and copper
	
function parse_gold($varnumber) 
{

	$gold = array();
	$gold['gold'] = intval($varnumber/10000);
	$gold['silver'] = intval(($varnumber % 10000)/100);
	$gold['copper'] = (($varnumber % 10000) % 100);

	return $gold;
}

//	************************************************************	
// Adds the images to the print gold function

function get_print_gold($gold_array) 
{
	if($gold_array['gold'] > 0) 
	{
		echo $gold_array['gold'];
		echo "<img src='inc/admin/images/icons/gold.GIF' border='0'>&nbsp;";
	}
	if($gold_array['silver'] > 0) 
	{
		echo $gold_array['silver'];
		echo "<img src='inc/admin/images/icons/silver.GIF' border='0'>&nbsp;";
	}
	if($gold_array['copper'] > 0) 
	{
		echo $gold_array['copper'];
		echo "<img src='inc/admin/images/icons/copper.GIF' border='0'>&nbsp;";
	}
}

//	************************************************************	
// Main function for actually "printing" the gold
// Use this function to get the gold print out

function print_gold($gvar) 
{
	if($gvar == '---') 
	{
		echo $gvar;
	}
	else 
	{
		get_print_gold(parse_gold($gvar));
	}
}

//===== MAIL FUNCTIONS =====//

// Send Mail
function send_email($email_to, $email_subject, $email_message, $notice = true) 
{
	global $mwe_config;

    if($mwe_config['email_use_secure'] == 1)
    {
        $smtp_encryption = $mwe_config['email_smtp_secure'];
    }
    else
    {
        $smtp_encryption = false;
    }

    require("core/mail/PHPMailerAutoload.php");

    $mail = new PHPMailer;

    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->isSMTP();                                        // Set mailer to use SMTP
    $mail->Host = $mwe_config['email_smtp_host'];           // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                                 // Enable SMTP authentication
    $mail->Username = $mwe_config['email_smtp_user'];       // SMTP username
    $mail->Password = $mwe_config['email_smtp_pass'];       // SMTP password
    $mail->SMTPSecure = $smtp_encryption;                   // 'tls', 'ssl' or false
    $mail->Port = $mwe_config['email_smtp_port'];           // TCP port to connect to
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    
    $mail->setFrom($mwe_config['site_email'], $mwe_config['site_title']);
    $mail->addAddress($email_to);     // Add a recipient

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $email_subject;
    $mail->Body    = $email_message;

    if(!$mail->send())
    {
        output_message("error", '<b>Error!</b> Message could not be sent.<br />Mailer Error: ' . $mail->ErrorInfo);
    }
    elseif($notice)
    {
        output_message("success", "Your message has been sent successfully.");
    }
}

//	************************************************************	
// Loads all the smilies in the smily directory and returns it
// in an array

function load_smiles($dir='images/smiles/')
{
    $allfiles = scandir($dir);
    $smiles = array_diff($allfiles, array(".", "..", ".svn", "Thumbs.db", "index.html"));
    return $smiles;
}

// ======== Misc functions ======= // 

//	************************************************************	
/* 
	A redirect function.
	$linkto is the destination
	$type 0 = <meta>, 1 = header
	$wait_sec is used only in <meta>
*/

function redirect($linkto,$type=0,$wait_sec=0)
{
    if($linkto)
	{
        if($type==0)
		{
            echo '<meta http-equiv=refresh content="'.$wait_sec.';url='.$linkto.'">';
        }
		else
		{
            header("Location: ".$linkto);
        }
    }
}

//	************************************************************	
// Does a PHP operator compare ( & ). Example: does 2 fit into
// 3? 1 + 2 = 3 so yes. How about 8? 1 + 2 + 4 = 7 so NO.
// The numbers have to double, EX: 1, 2, 4, 8, 16, 32, 64 etc etc.

function bitCompare($bit, $key)
{
    if(($bit & $key) == TRUE)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

//	************************************************************	
// Builds a cache file name using the template number an language

function cacheString($title)
{
	global $Template;
	return $Template['number']. $title . $GLOBALS['user_cur_lang'];
}

//	************************************************************	
// Checks a string for illegal symbols

function check_for_symbols($string, $space_check = 0)
{
    //$space_check=1 means space is not allowed
    $len=strlen($string);
    $allowed_chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    if(!$space_check) 
	{
        $allowed_chars .= " ";
    }
    for($i=0;$i<$len;$i++)
        if(strstr($allowed_chars,$string[$i]) == FALSE)
            return TRUE;
    return FALSE;
}

//	************************************************************	
// a basic stripslashes function using get if magic quotes

function strip_if_magic_quotes($value)
{
    if (get_magic_quotes_gpc()) 
	{
        $value = stripslashes($value);
    }
    return $value;
}

//	************************************************************	
// Replaces the first letter of the text with an image letter

function add_pictureletter($text)
{
	global $Template;
    $letter = substr($text, 0, 1);
    $imageletter = strtr(strtolower($letter),"���������������������������������������������������������������������",
                                             "sozsozyyuaaaaaaaceeeeiiiidnoooooouuuuysaaaaaaaceeeeiiiionoooooouuuuyy");
    if (strpos("abcdefghijklmnopqrstuvwxyz", $imageletter) === false)
	{
        return $text;
	}
    $img = '<img src="'.$Template['path'].'/images/letters/'.$imageletter.'.gif" alt="'.$letter.'" align="left"/>';
    $output = $img . substr($text, 1);
    return $output;
}

//	************************************************************	
// Used to generate a random password for the password revocery script.

function random_string($counts)
{
    $str = "abcdefghijklmnopqrstuvwxyz"; //Count 0-25
    $o = 0;
	$output = '';
	
    for($i=0; $i < $counts; $i++)
	{
        if($o == 1)
		{
            $output .= rand(0,9);
            $o = 0;
        }
		else
		{
            $o++;
            $output .= $str[rand(0,25)];
        }
    }
    return $output;
}

// ========== BB code -> HTML / HTML -> BBcode functions =========== //

//	************************************************************	
// my_preview switches from BBcode to HTML

function my_preview($text,$userlevel=0) 
{
    if($userlevel < 1)
	{
		$text = htmlspecialchars($text);
		if(get_magic_quotes_gpc())
		{
			$text = stripslashes($text);
		}
	}
    $text = nl2br($text);
    $text = preg_replace("/\\[b\\](.*?)\\[\\/b\\]/s","<b>$1</b>",$text);
    $text = preg_replace("/\\[i\\](.*?)\\[\\/i\\]/s","<i>$1</i>",$text);
    $text = preg_replace("/\\[u\\](.*?)\\[\\/u\\]/s","<u>$1</u>",$text);
    $text = preg_replace("/\\[s\\](.*?)\\[\\/s\\]/s","<s>$1</s>",$text);
    $text = preg_replace("/\\[hr\\]/s","<hr>",$text);
    $text = preg_replace("/\\[code\\](.*?)\\[\\/code\\]/s","<code>$1</code>",$text);
    if (strpos($text, 'blockquote') !== false)
    {
        if(substr_count($text, '[blockquote') == substr_count($text, '[/blockquote]')){
            $text = str_replace('[blockquote]', '<blockquote><div>', $text);
            $text = preg_replace('#\[blockquote=(&quot;|"|\'|)(.*)\\1\]#sU', '<blockquote><span class="bhead">Quote: $2</span><div>', $text);
            $text = preg_replace('#\[\/blockquote\]\s*#', '</div></blockquote>', $text);
        }
    }
    $text = preg_replace("/\\[img\\](.*?)\\[\\/img\\]/s","<img src=\"$1\" align=\"absmiddle\">",$text);
    $text = preg_replace("/\\[attach=(\\d+)\\]/se","check_attach('\\1')",$text);
    $text = preg_replace("/\\[url=(.*?)\\](.*?)\\[\\/url\\]/s","<a href=\"$1\" target=\"_blank\">$2</a>",$text);
    $text = preg_replace("/\\[size=(.*?)\\](.*?)\\[\\/size\\]/s","<font class='$1'>$2</font>",$text);
    $text = preg_replace("/\\[align=(.*?)\\](.*?)\\[\\/align\\]/s","<p align='$1'>$2</p>",$text);
    $text = preg_replace("/\\[color=(.*?)\\](.*?)\\[\\/color\\]/s","<font color=\"$1\">$2</font>",$text);
    $text = preg_replace("/[^\\'\"\\=\\]\\[<>\\w]([\\w]+:\\/\\/[^\n\r\t\\s\\[\\]\\>\\<\\'\"]+)/s"," <a href=\"$1\" target=\"_blank\">$1</a>",$text);
    return $text;
}

//	************************************************************	
// my_previewreverse switches from HTML to BBcode

function my_previewreverse($text)
{
    $text = str_replace('<br />','',$text);
    $text = preg_replace("/<b>(.*?)<\\/b>/s","[b]$1[/b]",$text);
    $text = preg_replace("/<i>(.*?)<\\/i>/s","[i]$1[/i]",$text);
    $text = preg_replace("/<u>(.*?)<\\/u>/s","[u]$1[/u]",$text);
    $text = preg_replace("/<s>(.*?)<\\/s>/s","[s]$1[/s]",$text);
    $text = preg_replace("/<hr>/s","[hr]",$text);
    $text = preg_replace("/<code>(.*?)<\\/code>/s","[code]$1[/code]",$text);
    if (strpos($text, 'blockquote') !== false)
    {
        if(substr_count($text, '<blockquote>') == substr_count($text, '</blockquote>'))
		{
            $text = str_replace('<blockquote><div>', '[blockquote]', $text);
            $text = preg_replace('#\<blockquote><span class="bhead">\w+: (&quot;|"|\'|)(.*)\\1\<\/span><div>#sU', '[blockquote="$2"]', $text);
            $text = preg_replace('#<\/div><\/blockquote>\s*#', '[/blockquote]', $text);
        }
    }
    $text = preg_replace("/<img src=.([^'\"<>]+). align=.absmiddle.>/s","[img]$1[/img]",$text);
    $text = preg_replace("/(<a href=.*?<\\/a>)/se","check_url_reverse('\\1')",$text);
    $text = preg_replace("/<font color=.([^'\"<>]+).>([^<>]*?)<\\/font>/s","[color=$1]$2[/color]",$text);
    $text = preg_replace("/<font class=.([^'\"<>]+).>([^<>]*?)<\\/font>/s","[size=$1]$2[/size]",$text);
    $text = preg_replace("/<p align=.([^'\"<>]+).>([^<>]*?)<\\/p>/s","[align=$1]$2[/align]",$text);
    return $text;
}

//	************************************************************	
// Makes a MangosWeb URL

function mw_url($page, $subpage = NULL, $params = NULL, $encodeentities = TRUE) 
{
	global $mwe_config;
	if($subpage != NULL)
	{
		$url = "?p=$page&sub=$subpage";
	}
	else
	{
		if($page == 'home' || $page == 'main')
		{
			$url = $mwe_config['site_base_href'] . $mwe_config['site_href'];
		}
		else
		{
			$url = "?p=$page";
		}
	}
    if(is_array($params)) 
	{
        foreach($params as $key=>$value) 
		{
            $url .= "&$key=$value";
        }
    }
    return $encodeentities ? htmlentities($url) : $url;
}

//	************************************************************
// A basic paginate code.

function paginate($num_pages, $cur_page, $link_to)
{
	$pages = array();
    $link_to_all = false;
    if($cur_page == -1)
    {
        $cur_page = 1;
        $link_to_all = true;
    }
    if($num_pages <= 1)
	{
        $pages = array('1');
	}
    else
    {
        $tens = floor($num_pages/10);
        for ($i=1; $i <= $tens; $i++)
        {
            $tp = $i*10;
            $pages[$tp] = "<a href='$link_to&page=$tp'>$tp</a>";
        }
        if($cur_page > 3)
        {
            $pages[1] = "<a href='$link_to&p=1'>1</a>";
        }
        for($current = $cur_page - 2, $stop = $cur_page + 3; $current < $stop; $current++)
        {
            if($current < 1 || $current > $num_pages) 
			{
                continue;
            } 
			elseif($current != $cur_page || $link_to_all) 
			{
                $pages[$current] = "<a href='$link_to&page=$current'>$current</a>";
            } 
			else 
			{
                $pages[$current] = '['.$current.']';
            }
        }
        if($cur_page <= ($num_pages-3))
        {
            $pages[$num_pages] = "<a href='$link_to&page=$num_pages'>$num_pages</a>";
        }
    }
    $pages = array_unique($pages);
    ksort($pages);
    $pp = implode(' ', $pages);
    return $pp;
}
?>
