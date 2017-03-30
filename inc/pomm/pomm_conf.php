<?php
/*
    POMM  v1.3
    Player Online Map for MangOs

    Show online players position on map. Update without refresh.
    Show tooltip with location, race, class and level of player.
    Show realm status.

    16.09.2006      http://pomm.da.ru/

    Created by mirage666 (c) (mailto:mirage666@pisem.net icq# 152263154)
    2006-2009 Modified by killdozer.
*/


//require_once("inc/pomm/func.php");
//require("../../config/config-protected.php");

// GM online options
$map_gm_show_online_only_gmoff     = 1; // show GM point only if in '.gm off' [1/0]
$map_gm_show_online_only_gmvisible = 1; // show GM point only if in '.gm visible on' [1/0]
$map_gm_add_suffix                 = 1; // add '{GM}' to name [1/0]
$map_status_gm_include_all         = 1; // include 'all GMs in game'/'who on map' [1/0]

// status window options:
$map_show_status =  1;                  // show server status window [1/0]
$map_show_time   =  1;                  // Show autoupdate timer 1 - on, 0 - off
$map_time        = 10;                  // Map autoupdate time (seconds), 0 - not update.

// all times set in msec (do not set time < 1500 for show), 0 to disable.
$map_time_to_show_uptime    = 3000;     // time to show uptime string
$map_time_to_show_maxonline = 3000;     // time to show max online
$map_time_to_show_gmonline  = 3000;     // time to show GM online

$developer_test_mode =  false;

$multi_realm_mode    =  true;
require_once(realpath(dirname(__FILE__)."/libs/data_lib.php"));


$realm_id = intval( $_COOKIE['cur_selected_realm'] );

$row = $DB->selectRow("SELECT db_logon_host, db_logon_name, db_logon_user, db_logon_pass FROM `mw_config` LIMIT 1");

$realm_data = $RDB->selectRow("SELECT * FROM `realmlist` WHERE `id` = ".$realm_id);

$realm_name = $realm_data['name'];
$server = $realm_data['address'];
$port = $realm_data['port'];

$realm_data_ext = $DB->selectRow("SELECT * FROM `mw_realm` WHERE `realm_id` = ".$realm_id);

$host = $realm_data_ext['db_char_host'];
$user = $realm_data_ext['db_char_user'];
$password = $realm_data_ext['db_char_pass'];
$db = $realm_data_ext['db_char_name'];

$hostr = $row['db_logon_host'];
$userr = $row['db_logon_user'];
$passwordr = $row['db_logon_pass'];
$dbr = $row['db_logon_name'];

$gm_show_online = 1;
$gm_show_online_only_gmoff = $map_gm_show_online_only_gmoff;
$gm_show_online_only_gmvisible = $map_gm_show_online_only_gmvisible;
$gm_add_suffix = $map_gm_add_suffix;
$gm_include_online = 1;
$show_status = $map_show_status;
$time_to_show_uptime = $map_time_to_show_uptime;
$time_to_show_maxonline = $map_time_to_show_maxonline;
$time_to_show_gmonline = $map_time_to_show_gmonline;
$status_gm_include_all = $map_status_gm_include_all;
$time = $map_time;
$show_time = $map_show_time;

// points located on these maps(do not modify it)
$maps_for_points = "0,1,530,571,609";

$img_base = "inc/pomm/img/map/";
$img_base2 = "inc/pomm/img/c_icons/";

$PLAYER_FLAGS       = CHAR_DATA_OFFSET_FLAGS;

?>
