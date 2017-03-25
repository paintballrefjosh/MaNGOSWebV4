<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

// Block out all users who arent admins
if($user['account_level'] <= 2) 
{
	redirect('index.php',1);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>MangosWeb Enhanced Admin Panel</title>
	<link rel="stylesheet" href="inc/admin/css/main.css" type="text/css"/>
	<link rel="shortcut icon" href="<?php echo $Template['path']; ?>/images/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="<?php echo $Template['path']; ?>/images/favicon.ico" type="image/x-icon"> /

	<!--[if IE 8]>	
		<link rel="stylesheet" href="inc/admin/css/ie8.css" type="text/css" media="screen" title="ie8" charset="utf-8" />
	<![endif]-->
	
	<!--[if IE 7]>	
		<link rel="stylesheet" href="inc/admin/css/ie7.css" type="text/css" media="screen" title="ie8" charset="utf-8" />
	<![endif]-->
	
	<!-- TinyMCE Module -->
	<script type="text/javascript" src="modules/tiny_mce/tiny_mce.js"></script>
	
	<!-- Include the functions.js for cookie setting of realms etc etc -->
	<script type="text/javascript">
	<!--
		var SITE_HREF = '<?php echo $mwe_config['site_base_href'] . $mwe_config['site_href']; ?>';
		var DOMAIN_PATH = '<?php echo $_SERVER["HTTP_HOST"];?>';
		var SITE_PATH = '<?php echo $mwe_config['site_base_href'] . $mwe_config['site_href']; ?>';
	-->
	</script>
	<script src="inc/admin/js/functions.js" type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>

<body>
<div id="page">
	<!-- Start #header -->
	<div id="header">		
		<div class="pad">			
			<h1 id="title"><center><img src="inc/admin/images/MangosWeb.png" /></center></h1>
			<div id="subheader">
				<?php echo $lang['core_version']; ?>: <?= $Core->version; ?>
				&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
				<?php echo $lang['database_version']; ?>: <?php 
			$db_act_ver = $DB->selectCell("SELECT `dbver` FROM `mw_db_version` ORDER BY `dbdate` DESC LIMIT 0,1");
			if($db_act_ver < $Core->db_version) 
			{ 
?>
				<font color='red'><?= $db_act_ver; ?> (<a href="?p=admin&amp;sub=updates" /><small>Update Required</small></a>)</font>
<?php
			}
			elseif($db_act_ver > $Core->db_version) 
			{
?>
				 <font color='red'><?= $db_act_ver; ?> (<small>Database ahead of the core!</small>)</font>
<?php
			}
			else
			{ 
				echo $db_act_ver; 
			} ?> 
			</div>
		</div> <!-- .pad -->		
	</div> <!-- #header -->
	
	<!-- Start #nav -->
	<div id="nav" class="clearfix">		
		<ul>
			<li>
				<center><a href="?p=admin"><?php echo $lang['admin_home']; ?></a> | <a href="<?php echo mw_url('home'); ?>">
					<?php echo $lang['site_index']; ?></a></center>
			</li>
		</ul>		
	</div> <!-- #nav -->
	
	<!-- Start #body -->
	<div id="body">	
	<!-- Start #sidebar -->
		<div id="sidebar">			
			<div class="content">				
				<div class="content-header">
					<h4><?php echo $lang['server_info']; ?></h4> 					
				</div> <!-- .content-header -->						
				<div class="main-content">		
					<p>
						<?php echo $lang['php_ver']; ?>: <?php echo phpversion(); ?><br />
						<?php echo $lang['mysql_ver']; ?>: <?php echo $DB->get_server_info(); ?><br /><br />
						<?php echo $lang['allow_url_open']; ?>: <?php echo $allowfopen; ?><br />
						<?php echo $lang['allow_fsockopen']; ?>: <?php echo $fsock; ?><br />
					</p>						
					<div class="clear"></div>
				</div> <!-- .main-content -->	
			</div> <!-- .content -->
		</div> <!-- #sidebar -->
		
		<!-- Start #main -->
		<div id="main">
