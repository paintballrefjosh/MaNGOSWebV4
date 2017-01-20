<?php
//  **************************************************
//	Required by all Official MangosWeb v3 Templates
// 	2 Functions are required for module integration 
//	Content_Div_Start() - Used for the starting Div's of the template
// 	Content_Div_End() - Closes the Div_Start Div tags.
//  **************************************************

// Main Div function
function Content_Div_Start() 
{
	global $Template;
	echo '<div style="width: 659px; height: 29px; background: url(\''.$Template['path'].'/images/content-parting.jpg\') no-repeat;"><div style="padding: 2px 0px 0px 23px;"><font style="font-family: \'Times New Roman\', Times, serif; color: #640909;"><h2>'.$_GET['module'].'</h2></font></div></div>';
	echo '<div style="background: url(\''.$Template['path'].'/images/light.jpg\') repeat; border-width: 1px; border-color: #000000; border-bottom-style: solid; margin: 0px 0px 5px 0px">';
	echo '<div class="contentdiv">';
}


function Content_Div_End() 
{
	echo '</div></div>';
}
 
 /***************************************************************
 * Body Functions for the blizzlike template
 ***************************************************************/

// Builds the menu items for 1 catagory (Account or News)
function build_menu_items($links_arr)
{
    global $user;
    $r = "\n";
    foreach($links_arr as $menu_item)
	{
        $ignore_item = 0;
        if($menu_item['link_title'] != '' && $menu_item['link'] != '') 
		{
            if($menu_item['account_level'] > $user['account_level']) 
			{
                $ignore_item++;
            }
			if($menu_item['guest_only'] == 1 && $user['id'] > 0)
			{
			    $ignore_item++;
            }
        }
        if($ignore_item == 0)
		{
            $r .= '<div><a class="menufiller" href="'.$menu_item['link'].'">'.$menu_item['link_title'].'</a></div>'."\n";
		}
    }
    return $r;
}

// Main function used for building menu items
// Pulls the links out of the database, and foreach catagory,
// calls build_menu_items();
function build_main_menu()
{
	global $DB, $user, $Core;
    $mainnav_links = array(
		'1-menuNews', 
		'2-menuAccount', 
		'3-menuGameGuide', 
		'4-menuInteractive', 
		'5-menuMedia', 
		'6-menuForums', 
		'7-menuCommunity',
		'8-menuSupport'
		);
    foreach($mainnav_links as $menuname)
	{
        $menunamev = explode('-',strtolower($menuname));
		if($user['id'] > 0)
		{
			$menuquery = "SELECT * FROM `mw_menu_items` WHERE `menu_id`='".$menunamev[0]."' AND `account_level` <= ".$user['account_level']." ORDER BY `order` ASC";
		}
		else
		{
			$menuquery = "SELECT * FROM `mw_menu_items` WHERE `menu_id`='".$menunamev[0]."' AND `account_level` <= ".$user['account_level']." ORDER BY `order` ASC";
		}
		$menuitems = $DB->select($menuquery);
        if($menuitems != FALSE)// && $menuitems[0][0])
        {
            static $index = 0;
            $index++;
			echo '
                <div id="'.$menunamev[1].'"  style="position: relative; z-index: 11;"> 
					<div onclick="javascript:toggleNewMenu('.$menunamev[0].'-1);" class="menu-button-off" id="'.$menunamev[1].'-button">
						<span class="'.$menunamev[1].'-icon-off" id="'.$menunamev[1].'-icon">&nbsp;</span><a class="'.$menunamev[1].'-header-off" id="'.$menunamev[1].'-header"><em>Menu item</em></a><a id="'.$menunamev[1].'-collapse"></a><span class="menuentry-rightborder"></span>
                    </div>
                    <div id="'.$menunamev[1].'-inner">
                        <script type="text/javascript">
                        if (menuCookie['.$menunamev[0].'-1] == 0) 
						{
                            document.getElementById("'.$menunamev[1].'-inner").style.display = "none";
                            document.getElementById("'.$menunamev[1].'-button").className = "menu-button-off";
                            document.getElementById("'.$menunamev[1].'-collapse").className = "leftmenu-pluslink";
                            document.getElementById("'.$menunamev[1].'-icon").className = "'.$menunamev[1].'-icon-off";
                            document.getElementById("'.$menunamev[1].'-header").className = "'.$menunamev[1].'-header-off";
                        } 
						else
						{
                            document.getElementById("'.$menunamev[1].'-inner").style.display = "block";
                            document.getElementById("'.$menunamev[1].'-button").className = "menu-button-on";
                            document.getElementById("'.$menunamev[1].'-collapse").className = "leftmenu-minuslink";
                            document.getElementById("'.$menunamev[1].'-icon").className = "'.$menunamev[1].'-icon-on";
                            document.getElementById("'.$menunamev[1].'-header").className = "'.$menunamev[1].'-header-on";
                        }
                        </script>
                        <div class="leftmenu-cont-top"></div>
                        <div class="leftmenu-cont-mid">
                            <div class="m-left">
                                <div class="m-right">
                                    <div class="leftmenu-cnt" id="menucontainer'.$index.'">
                                        <ul class="mainnav">
                                            <li style="position:relative;" id="menufiller'.$index.'">
                                                '.build_menu_items($menuitems).'
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="leftmenu-cont-bot"></div>
                    </div>
                </div>
			';
        }
    }
	unset($menuquery);
}

// Builds the blue subheader bar. Ex: ?p=account
// $subheader = Title of the subheader
function write_subheader($subheader)
{
	global $Template;
    echo '
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
			<tr>
				<td width="24"><img src="'.$Template['path'].'/images/subheader/subheader-left-sword.gif" height="20" width="24" alt=""/></td>
				<td bgcolor="#05374a" width="100%"><b style="color:white;">'.$subheader.':</b></td>
				<td width="10"><img src="'.$Template['path'].'/images/subheader/subheader-right.gif" height="20" width="10" alt=""/></td>
			</tr>
		</tbody>
	</table>';
}

// Builds the metal border above a table
// Example of this is the vote page
function write_metalborder_header()
{
	global $Template;
    echo '
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
			<tr>
				<td width="12"><img src="'.$Template['path'].'/images/metalborder-top-left.gif" height="12" width="12" alt=""/></td>
				<td style="background:url(\''.$Template['path'].'/images/metalborder-top.gif\');"></td>
				<td width="12"><img src="'.$Template['path'].'/images/metalborder-top-right.gif" height="12" width="12" alt=""/></td>
			</tr>
			<tr>
				<td style="background:url(\''.$Template['path'].'/images/metalborder-left.gif\');"></td>
				<td>
';
}

// If you use the write_metalborder_header();
// Use this to close all the table tags
function write_metalborder_footer()
{
	global $Template;
	echo '      </td>
				<td style="background:url(\''.$Template['path'].'/images/metalborder-right.gif\');"></td>
			</tr>
			<tr>
				<td><img src="'.$Template['path'].'/images/metalborder-bot-left.gif" height="11" width="12" alt=""/></td>
				<td style="background:url(\''.$Template['path'].'/images/metalborder-bot.gif\');"></td>
				<td><img src="'.$Template['path'].'/images/metalborder-bot-right.gif" height="11" width="12" alt=""/></td>
			</tr>
		</tbody>
	</table>
';
}

// Builds the community box header.
function build_CommBox_Header()
{
	global $Template;
	echo "<br />
	<table align='center' width='60%' style='font-size:0.8em;'>
	<tr>
		<td align='left'>
			<div id='container-community'>
				<div class='phatlootbox-top'>
					<h2 class='community'><span class='hide'>Registration</span></h2>
					<span class='phatlootbox-visual comm'></span>
					</div>
					<div class='phatlootbox-wrapper'>
						<div style='background: url(".$Template['path']."/images/phatlootbox-top-parchment.jpg) repeat-y top right; height: 7px; width: 456px; margin-left: 6px; font-size: 1px;'></div>
						<div class='community-cnt'>
	";
}

// Builds the community box footer
function build_CommBox_Footer()
{
	echo "
					<br/>
				</div>
			</div>
		<div class='phatlootbox-bottom'></div>
		</div>
	</td>
	</tr>
	</table>
	";
}

function buildShadowTop()
{
	global $Template;
?>
	<table cellspacing = "0" cellpadding = "0" border = "0" >
		<tr>
			<td>
				<img src = "<?php echo $Template['path']; ?>/images/shadow-top-left.gif" width = "5" height = "4">
			</td>
			<td background = "<?php echo $Template['path']; ?>/images/shadow-top.gif">
				<img src = "<?php echo $Template['path']; ?>/images/shadow-top-left-left.gif" width = "12" height = "4">
			</td>
			<td align = "right" background = "<?php echo $Template['path']; ?>/images/shadow-top.gif">
				<img src = "<?php echo $Template['path']; ?>/images/shadow-top-right-right.gif" width = "12" height = "4">
			</td>
			<td>
				<img src = "<?php echo $Template['path']; ?>/images/shadow-top-right.gif" width = "9" height = "4">
			</td>
		</tr>
		<tr>
			<td valign = "top" background = "<?php echo $Template['path']; ?>/images/shadow-left.gif">
				<img src = "<?php echo $Template['path']; ?>/images/shadow-left-top.gif" width = "5" height = "12">
			</td>
			<td colspan = "2" rowspan = "2" style="background-image:url('<?php echo $Template['path']; ?>/images/header-left2.jpg'); background-repeat: no-repeat;">
<?php
}

function buildShadowBottom()
{
	global $Template;
?>
			</td>
		</tr>
	</table>
	</td>
		<td valign = "top" background = "<?php echo $Template['path']; ?>/images/shadow-right.gif">
			<img src = "<?php echo $Template['path']; ?>/images/shadow-right-top.gif" width = "9" height = "12">
		</td>
		</tr>
			<tr>
				<td valign = "bottom" background = "<?php echo $Template['path']; ?>/images/shadow-left.gif">
					<img src = "<?php echo $Template['path']; ?>/images/shadow-left-bot.gif" width = "5" height = "12">
				</td>
				<td valign = "bottom" background = "<?php echo $Template['path']; ?>/images/shadow-right.gif">
					<img src = "<?php echo $Template['path']; ?>/images/shadow-right-bot.gif" width = "9" height = "12">
				</td>
			</tr>
			<tr>
				<td>
					<img src = "<?php echo $Template['path']; ?>/images/shadow-bot-left.gif" width = "5" height = "10">
				</td>
				<td background = "<?php echo $Template['path']; ?>/images/shadow-bot.gif">
					<img src = "<?php echo $Template['path']; ?>/images/shadow-bot-left-left.gif" width = "12" height = "10">
				</td>
				<td align = "right" background = "<?php echo $Template['path']; ?>/images/shadow-bot.gif">
					<img src = "<?php echo $Template['path']; ?>/images/shadow-bot-right-right.gif" width = "12" height = "10">
				</td>
				<td>
					<img src = "<?php echo $Template['path']; ?>/images/shadow-bot-right.gif" width = "9" height = "10">
				</td>
			</tr>
		</table>
<?php
}

// Selects a random screenshot from the screenshot folder
// Function is not used, rather a mysql random function
function random_screenshot()
{
	$fa = array();
	if ($handle = opendir('images/screenshots/thumbs/')) 
	{
		while (false !== ($file = readdir($handle))) 
		{
			if ($file != "." && $file != ".." && $file != "Thumbs.db" && $file != "index.html") 
			{
				$fa[] = $file;
			}
		}
		closedir($handle);
	}
	$fnum = count($fa);
	$fpos = rand(0, $fnum-1);
	return $fa[$fpos];
}

// Builds the breadcrum pathway
function build_pathway()
{
    global $lang;
    global $pathway_info;
    global $title_str,$pathway_str;
    $path_c = count($pathway_info);
    $pathway_info[$path_c-1]['link'] = '';
    $pathway_str = '';
	$pathway_str .= '<a href="./">Main</a>';
    if(is_array($pathway_info))
	{
        foreach($pathway_info as $newpath)
		{
            if(isset($newpath['title']))
			{
                if(empty($newpath['link']))
				{
					$pathway_str .= ' &raquo; '.$newpath['title'].'';
				}
                else
				{
					$pathway_str .= ' &raquo; <a href="'.$newpath['link'].'">'.$newpath['title'].'</a>';
				}
                $title_str .= ' &raquo; '.$newpath['title'];
            }
        }
    }
    $pathway_str .= '';
}
// !!!!!!!!!!!!!!!! //
build_pathway();

// Main Div function
function builddiv_start($type = 0, $title = "No title set") 
{
	global $Template;
	if ($type == 1) 
	{
		echo '<div style="width: 659px; height: 29px; background: url(\''.$Template['path'].'/images/content-parting.jpg\') no-repeat;"><div style="padding: 2px 0px 0px 23px;"><font style="font-family: \'Times New Roman\', Times, serif; color: #640909;"><h2>'.$title.'</h2></font></div></div>';
		echo '<div style="background: url(\''.$Template['path'].'/images/light.jpg\') repeat; border-width: 1px; border-color: #000000; border-bottom-style: solid; margin: 0px 0px 5px 0px">';
		echo '<div class="contentdiv">';
	}
	else 
	{
		if ($title != "No title set") 
		{
			echo '<div style="width: 659px; height: 29px; background: url(\''.$Template['path'].'/images/content-parting2.jpg\') no-repeat;"><div style="padding: 2px 0px 0px 23px;"><font style="font-family: \'Times New Roman\', Times, serif; color: #640909;"><h2>'.$title.'</h2></font></div></div>';
			echo '<div style="background: url(\''.$Template['path'].'/images/light.jpg\') repeat; border-width: 1px; border-color: #000000; border-bottom-style: solid; margin: 0px 0px 5px 0px">';
			echo '<div class="contentdiv">';
		}
		else 
		{
			echo '<div style="background: url(\''.$Template['path'].'/images/light.jpg\') repeat; border-width: 1px; border-color: #000000; border-top-style: solid; border-bottom-style: solid; margin: 4px 0px 5px 0px">';
			echo '<div class="contentdiv">';
		}
	}
}


function builddiv_end() 
{
	echo '</div></div>';
}
?>