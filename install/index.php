<?php
// Change the FALSE to TRUE to disable installer, and vise-versa.
$disabled = FALSE;

if($disabled == TRUE)
{
	echo "Installer Disabled. Please edit you install/index.php file to re-enable the installer";
	die();
}

function output_message($type, $text)
{
    echo "<div class=\"".$type."\">$text</div>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>MaNGOS Web Enhanced V4 Installer</title>
	<link rel="stylesheet" href="css/main.css" type="text/css"/>
</head>
<body>
	<div id="header">					
		<h1 id="title"><center><img src="images/MangosWeb.png" /></center></h1>
	</div>
	<div class="page">
		<div class="content">				
			<div class="content-header">
			<?php
				
				if(isset($_GET['step']))
				{
					$step = htmlspecialchars($_GET['step']);
				}
				else
				{
					$step = 1;
				}
				echo "<h4><center>Step ".$step."</center></h4>";
				echo "</div> <!-- .content-header -->";
				if($step == 1)
				{
			?>		
					<!-- STEP 1 -->
					<form method="POST" action="index.php?step=2" class="form label-inline">
					<div class="main-content">		
						<p>
							Welcome to the MaNGOS Web V4 Installer!. Before we start the installation proccess, we need to make sure your
							web server is compatible with MaNGOS Web. Please click the start at the bottom to begin.
						</p>
						<div class="buttonrow-border">								
							<center><button><span>Start</span></button></center>			
						</div>
						<div class="clear"></div>
					</div> <!-- .main-content -->
					</form>
			<?php
				} 
				elseif($step == 2)
				{
					// Initialize the no good tracker
					$nogood = 0;
					if(phpversion() < 5.2)
					{
						$phpver = "<img src='images/x.png' height='18px' width='18px' />";
						$nogood++;
					}
					else
					{
						$phpver = "<img src='images/check.png' height='18px' width='18px' />";
					}
					if(ini_get('allow_url_fopen') == '1')
					{
						$allow_url_fopen = "<img src='images/check.png' height='18px' width='18px' />";
					}
					else
					{
						$allow_url_fopen = "<img src='images/x.png' height='18px' width='18px' />";
						$nogood++;
					}
					if(function_exists("fsockopen")) 
					{
						$fsock = "<img src='images/check.png' height='18px' width='18px' />";
					}
					else
					{
						$fsock = "<img src='images/x.png' height='18px' width='18px' />";
						$nogood++;
					}
				?>
					<!-- STEP 2 -->
					<form method="POST" action="index.php?step=3" class="form label-inline">
					<div class="main-content">		
						<p>
							If you see any red X's here, then your server will not run MangosWeb v4.<br /><br />
							PHP Version:  <?php echo phpversion()." ".$phpver; ?><br />
							Allow URL Open (Fopen)  <?php echo $allow_url_fopen; ?><br />
							Fsockopen Enabled  <?php echo $fsock; ?><br />
						</p>
						<div class="buttonrow-border">
							<?php
								if($nogood == 0)
								{ 
									echo "<center><button><span>Continue to step 3</span></button></center>";
								}
								else
								{
									echo "<center><font color='red'> Sorry, You cannot Go To Step 3. </font></center>";
								}
							?>
						</div>
						<div class="clear"></div>
					</div> <!-- .main-content -->
					</form>
			<?php
				}
				elseif($step == 3)
				{
			?>
					<!-- STEP 3 -->
					<form method="POST" action="index.php?step=4" class="form label-inline">
					<div class="main-content">		
						
						<div class="field">
							<label for="db user">Realm Database Host: </label>
							<input id="Site Title" name="db_host" size="20" type="text" class="medium" value="localhost" />
							<p class="field_help">Enter the realm database host.</p>
						</div>
						
						<div class="field">
							<label for="db user">Realm Database port: </label>
							<input id="Site Title" name="db_port" size="20" type="text" class="medium" value="3306" />
							<p class="field_help">Enter the realm port number of the database.</p>
						</div>
						
						<div class="field">
							<label for="db user">Realm Database Username: </label>
							<input id="Site Title" name="db_username" size="20" type="text" class="medium" value="mangos" />
							<p class="field_help">Enter the realm database username.</p>
						</div>
						
						<div class="field">
							<label for="db user">Realm Database Password: </label>
							<input id="Site Title" name="db_password" size="20" type="password" class="medium" value="mangos" />
							<p class="field_help">Enter the realm database Password.</p>
						</div>
						
						<div class="field">
							<label for="db user">Realm Database Name: </label>
							<input id="Site Title" name="db_name" size="20" type="text" class="medium" value="realmd" />
							<p class="field_help">Enter the realm database name.</p>
						</div>
						
						<div class="buttonrow-border">								
							<center><button><span>Install Database</span></button></center><br />
						</div>
						<div class="clear"></div>
					</div> <!-- .main-content -->
					</form>				
			<?php
				}
				elseif($step == 4)
				{
					// Check database connection
					include("../config/config-protected.php");
					$link = @mysqli_connect($dbconf['db_host'], $dbconf['db_username'], $dbconf['db_password'], $dbconf['db_name'], $dbconf['db_port']) 
						or die('<div class="error">Couldn\'t connect to MySQL Database. Please edit config/config-protected.php with the correct info.<br /><br />MySql error log:<br />
							'.mysqli_connect_error().'</div');
					
					output_message('success', 'Successfully Connected to the MaNGOS Web DB.');
					
					$realm_link = @mysqli_connect($_POST['db_host'], $_POST['db_username'], $_POST['db_password'], $_POST['db_name'], $_POST['db_port']) 
						or die('<div class="error">Couldn\'t connect to MySQL Database. Please edit config/config-protected.php with the correct info.<br /><br />MySql error log:<br />
							'.mysqli_connect_error().'</div');

					output_message('success', 'Successfully Connected to the Realm DB.');
					

					// Check if "account" table exsists, so we make (almost) sure mangos is actually installed (which is necesarry for this whole thing to work)
					@mysqli_query($realm_link, "SELECT * FROM `account` LIMIT 1") or die('<div class="error">Error!<br /><br />Account table not found! Cannot continue with the installation without an Account
						table!  Ensure your MaNGOS database is installed properly. <br /><br />MySql error log:<br />'.mysqli_error().'</div>');
												
					// Preparing for sql injection... (prashing, etc...)
					$checker = @mysqli_query($link, "SELECT * FROM `account_extend` LIMIT 1");

					if(!file_exists("sql/full_install.sql"))
					{
						output_message('error', "Couldn't open file full_install.sql. Check if it's presented in sql/ and if it's readable by webserver!");
						$errmsg = error_get_last();
						die("<br /><br />PHP error log:<br />".$errmsg['message']);
					}

					$sql = file_get_contents("sql/full_install.sql");
					if(!mysqli_multi_query($link, $sql))
					{
						die('<div class="error">Error!<br /><br />Could not run the sql/full_install.sql file.<br /><br />MySql error log:<br />'.mysqli_error().'</div>');
					}

					$get_name = mysqli_query($realm_link, "SELECT `name` FROM `realmlist` WHERE `id`=1 LIMIT 1") or die('<div class="error">'.mysqli_error().'</div>');
					$DB_name = mysqli_fetch_assoc($get_name);
				?>
				<!-- STEP 4 -->
					<form method="POST" action="index.php?step=5" class="form label-inline">
						<input type="hidden" name="db_host" value="<?php echo $_POST['db_host']; ?>">
						<input type="hidden" name="db_port" value="<?php echo $_POST['db_port']; ?>">
						<input type="hidden" name="db_name" value="<?php echo $_POST['db_name']; ?>">
						<input type="hidden" name="db_username" value="<?php echo $_POST['db_username']; ?>">
						<input type="hidden" name="db_password" value="<?php echo $_POST['db_password']; ?>">					
					<div class="main-content">
						<div>
							In order for MaNGOS Web to function properly, we need at least 1 realm to have its information stored in the DB correctly.
							Please fill out the information for the realm "<u><b><?php echo $DB_name['name']; ?></b></u>"
						</div>
						<table>
							<thead>
								<th><center>Character Database Info (<?php echo $DB_name; ?>)</center></th>
							</thead>
						</table>
						<br />
						
						<!-- Character DB Info -->
						
						<div class="field">
							<label for="db user">Character Database Host: </label>
							<input id="Site Title" name="char_db_host" size="20" type="text" class="medium" value="localhost" />
							<p class="field_help">Enter the character database host.</p>
						</div>
						
						<div class="field">
							<label for="db user">Character Database port: </label>
							<input id="Site Title" name="char_db_port" size="20" type="text" class="medium" value="3306" />
							<p class="field_help">Enter the port number of your database.</p>
						</div>
						
						<div class="field">
							<label for="db user">Character Database Username: </label>
							<input id="Site Title" name="char_db_username" size="20" type="text" class="medium" value="mangos" />
							<p class="field_help">Enter the character database username.</p>
						</div>
						
						<div class="field">
							<label for="db user">Character Database Password: </label>
							<input id="Site Title" name="char_db_password" size="20" type="password" class="medium" value="mangos"/>
							<p class="field_help">Enter the character database Password.</p>
						</div>
						
						<div class="field">
							<label for="db user">Character Database Name: </label>
							<input id="Site Title" name="char_db_name" size="20" type="text" class="medium" value="characters" />
							<p class="field_help">Enter the Character DB name.</p>
						</div>
						
						<table>
							<thead>
								<th><center>World Database Info (<?php echo $DB_name; ?>)</center></th>
							</thead>
						</table>
						<br />
						
						<!-- WORLD DB Info -->
						
						<div class="field">
							<label for="db user">World Database Host: </label>
							<input id="Site Title" name="w_db_host" size="20" type="text" class="medium" value="localhost" />
							<p class="field_help">Enter the world database host.</p>
						</div>
						
						<div class="field">
							<label for="db user">World Database port: </label>
							<input id="Site Title" name="w_db_port" size="20" type="text" class="medium" value="3306" />
							<p class="field_help">Enter the port number of the world database.</p>
						</div>
						
						<div class="field">
							<label for="db user">World Database Username: </label>
							<input id="Site Title" name="w_db_username" size="20" type="text" class="medium" value="mangos" />
							<p class="field_help">Enter the World database username.</p>
						</div>
						
						<div class="field">
							<label for="db user">World Database Password: </label>
							<input id="Site Title" name="w_db_password" size="20" type="password" class="medium" value="mangos"/>
							<p class="field_help">Enter the world database Password.</p>
						</div>
						
						<div class="field">
							<label for="db user">World Database Name: </label>
							<input id="Site Title" name="w_db_name" size="20" type="text" class="medium" value="world" />
							<p class="field_help">Enter the World DB name.</p>
						</div>
						
						<div class="buttonrow-border">								
							<center><button><span>Submit</span></button></center><br />							
						</div>
						<div class="clear"></div>
						
					</div>
					</form>
				
				<!-- STEP 5 -->
				<?php
				}
				elseif($step == 5)
				{
					$char_link = @mysqli_connect($_POST['char_db_host'], $_POST['char_db_username'], $_POST['char_db_password'], $_POST['char_db_name'], $_POST['char_db_port']) 
						or die('<div class="error">Couldn\'t connect to the character MySQL Database. Please <a href="javascript: history.go(-1)">Go Back</a> and re-enter MySQL Database Information.</div>');
					
					$world_link = @mysqli_connect($_POST['w_db_host'], $_POST['w_db_username'], $_POST['w_db_password'], $_POST['w_db_name'], $_POST['w_db_port']) 
						or die('<div class="error">Couldn\'t connect to the world MySQL Database. Please <a href="javascript: history.go(-1)">Go Back</a> and re-enter MySQL Database Information.</div>');
					
					$realm_link = @mysqli_connect($_POST['db_host'], $_POST['db_username'], $_POST['db_password'], $_POST['db_name'], $_POST['db_port']);
					
					include("../config/config-protected.php");
					$link = @mysqli_connect($dbconf['db_host'], $dbconf['db_username'], $dbconf['db_password'], $dbconf['db_name'], $dbconf['db_port']);

					$sql = "INSERT INTO `mw_realm` SET
						realm_id = 1,
						site_enabled = 1,
						db_world_host = '".$_POST['w_db_host']."',
						db_world_port = '".$_POST['w_db_port']."',
						db_world_name = '".$_POST['w_db_name']."',
						db_world_user = '".$_POST['w_db_username']."',
						db_world_pass = '".$_POST['w_db_password']."',
						db_char_host = '".$_POST['char_db_host']."',
						db_char_port = '".$_POST['char_db_port']."',
						db_char_name = '".$_POST['char_db_name']."',
						db_char_user = '".$_POST['char_db_username']."',
						db_char_pass = '".$_POST['char_db_password']."'
						";

					mysqli_query($link, $sql) or die('<div class="error">'.mysqli_error($link).'</div>');
					
					output_message('success', 'Successfully saved Character and World DB info.');
				?>
					<form method="POST" action="index.php?step=6" class="form label-inline">
					<input type="hidden" name="db_host" value="<?php echo $_POST['db_host']; ?>">
					<input type="hidden" name="db_port" value="<?php echo $_POST['db_port']; ?>">
					<input type="hidden" name="db_name" value="<?php echo $_POST['db_name']; ?>">
					<input type="hidden" name="db_username" value="<?php echo $_POST['db_username']; ?>">
					<input type="hidden" name="db_password" value="<?php echo $_POST['db_password']; ?>">
					
					<div class="main-content">		
						<p>
							Please create an admin account. If you already have an account, then type in your info to log in, so 
							you can be added as a site admin.
						</p>
						
						<div class="field">
							<label for="user">Username: </label>
							<input id="user" name="account" size="20" type="text" class="medium"/>
						</div>
						
						<div class="field">
							<label for="pass">Password: </label>
							<input id="pass" name="pass" size="20" type="password" class="medium"/>
						</div>
						
						<div class="field">
							<label for="pass2">Repeat Password: </label>
							<input id="pass2" name="pass2" size="20" type="password" class="medium"/>
						</div>
						
						<div class="buttonrow-border">								
							<center><button><span>Submit</span></button></center>			
						</div>
						<div class="clear"></div>
					</div> <!-- .main-content -->
					</form>
			<?php 
				}
				elseif($step == 6)
				{
					if($_POST['pass'] != $_POST['pass2'])
					{
						die('<div class="error">Passwords dont match!. Please <a href="javascript: history.go(-1)">go back</a> and correct it.</div>');
					}
					if (!$_POST['account']) 
					{
						die('<div class="error">No account name was given. Please <a href="javascript: history.go(-1)">go back</a> and correct it.</div>');
					}
					//Password hash generator
					function sha_password($user, $pass)
					{
						$user = strtoupper($user);
						$pass = strtoupper($pass);
						return SHA1($user.':'.$pass);
					}
					$realm_link = mysqli_connect($_POST['db_host'], $_POST['db_username'], $_POST['db_password'], $_POST['db_name'], $_POST['db_port']);

					include("../config/config-protected.php");
					$link = mysqli_connect($dbconf['db_host'], $dbconf['db_username'], $dbconf['db_password'], $dbconf['db_name'], $dbconf['db_port']);

					$sql = "UPDATE `mw_config` SET 
						`db_logon_host` = '".$_POST['db_host']."',
						`db_logon_port` = '".$_POST['db_port']."',
						`db_logon_name` = '".$_POST['db_name']."',
						`db_logon_user` = '".$_POST['db_username']."',
						`db_logon_pass` = '".$_POST['db_password']."'
						";
					mysqli_query($link, $sql);

					$accountid = mysqli_query($realm_link, "SELECT `id` FROM `account` WHERE `username` = '".$_POST['account']."'");
					$checkacc = mysqli_num_rows($accountid);
					if ($checkacc == 1) 
					{
						// Account exsist
						$row = mysqli_fetch_assoc($accountid);
						mysqli_query($link, "INSERT INTO `mw_account_extend` (`account_id`, `account_level`) VALUES ('".$row['id']."', '4')");
						$return = 1;
					}
					else 
					{
						// No such account, creating one, in this case pwd is needed, so checking whether it's provided...
						$password = sha_password($_POST['account'], $_POST['pass']);
						mysqli_query($realm_link, "INSERT INTO `account` (`username`, `sha_pass_hash`) VALUES ('".$_POST['account']."', '".$password."' );");
						$accountid = mysqli_query("SELECT `id` FROM `account` WHERE `username` LIKE '".$_POST['account']."'");
						$acct = mysqli_fetch_assoc($accountid);
						mysqli_query($link, "INSERT INTO `mw_account_extend` (`account_id`, `account_level`) VALUES ('".$acct['id']."', '4')");
						$return = 2;
					}
				?>
				<div class="main-content">		
					<p>
						<?php if($return > 0)
						{ ?>
							Congradulations! MaNGOS Web v4 is installed and ready for use! Please delete the install/ directory from your webserver. 
							Once deleted you can log in and visit the admin panel to further configure the site!
							<br /><br /><a href="../index.php">Click Here</a> To go to your MaNGOS Web home page.</a>
						<?php
						} ?>
					</p>
				</div>
			<?php
				} ?>				
		</div> <!-- .content -->
		<div id="footer">
			<center>
			<p>
				Template originally designed by <a href="http://rodcreative.com/">Rod Creative</a>, Modified by Wilson212 for MangosWeb.<br /> 
			</p>
			</center>
		</div>
	</div>
</body>
</html>
