<style type="text/css">
	.attribute { font-family: "Arial", "Helvetica", "Sans-Serif"; color: #000000; font-weight: bold; font-size: 12;}
	#icon { position: absolute;	top: -145px; left: 47px; z-index: 99; _top: -145px}
	#text { position: relative;	top: 52px;	left: 10px;	z-index: 99; }
	#wrapper { position: relative; z-index: 99; }
	#wrapper99 { position: relative; z-index: 98; }
	.title	{
		font-family: palatino, georgia, times new roman, serif;
		font-size: 13pt;
		color: #640909;
	}
</style>

<!-- START OF PAGE BANNER -->
<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
	<tr>
		<td width = "100%" align = "center">
			<table width = "100%" cellspacing = "0" cellpadding = "0" border="0" background="<?php echo $Template['path']; ?>/images/account/tbc-background.jpg">
			<tr>
				<td>
					<div id="wrapper"><div id="icon"><img src="<?php echo $Template['path']; ?>/images/account/draenei-top.gif"></div></div>
				</td>
				<td >
					<div id = "wrapper"><div id = "text"><img src="<?php echo $Template['path']; ?>/images/account/title_acc_man.gif"></div></div>
				</td>
				<td>
					<img src="<?php echo $Template['path']; ?>/images/pixel.gif" border="0" height="161" width="90">
				</td>
			</tr>
			</table>
			<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
			<tr>
				<td background = "<?php echo $Template['path']; ?>/images/account/bottom.gif" width = "100%" >
					<img src ="<?php echo $Template['path']; ?>/images/pixel.gif" height = "18" width = "200">
				</td>
			</tr>
			</table>
		</td>
		<td width = "10%"></td>
	</tr>
	<tr>
		<td colspan="3">
			<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
				<tr>
					  <td background = "<?php echo $Template['path']; ?>/images/bottom.gif" width = "100%" >
						<img src ="<?php echo $Template['path']; ?>/images/pixel.gif" height = "18" width = "200">
					  </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- END PAGE BANNER -->

<?php 
builddiv_start();
// Here we want to see if the user has posted anything, and if so, then assign the functions to them to get em done //
if(isset($_GET['action']))
{		
	// CHANGE BASICS
	if($_GET['action'] == 'change')
	{
		changeDetails();
	}
	
	// CHANGE SECRET Q's
	elseif($_GET['action'] == 'changesecretq')
	{
		changeSQ();
	}
}
else
{
?>
	<center>
	<!--Shadow Top-->
	<?php 
		// Build the top shadow, this is a blizzlike function located in body_functions.php
		buildShadowTop(); 
	?>
	<!--Shadow Top-->
		<table cellspacing = "0" cellpadding = "4" border = "0">
			<tr>
				<td>
					<h3 class="title"><font color="white"><?php echo $lang['change_your_info'];?></font></h3>
					<p><center>
					<form name="mainform" method="post" action="?p=account&sub=manage&action=change" enctype="multipart/form-data" onsubmit="return validateforms(this)">
					<table width = "510" cellspacing = "0" cellpadding = "0" border = "0">
						<tr>
							<td>
								<span><?php echo add_pictureletter($PAGE_DESC); ?></span>
							</td>
						</tr>
					</table>
					</center>
					<br />
					<?php write_subheader($lang['general_info']); ?>
					<table width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;">
						<tr>
							<td>
								<table width='510' style="border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $Template['path']; ?>/images/light3.jpg');">
								<tr>
									<td>
										<table border='0' cellspacing='0' cellpadding='4'>
											<tr>
												<td align='right' valign = "top" width="40%">
													<font face="arial,helvetica" size='-1'><span><b><?php echo $lang['username'];?></b></span></font>
												</td>
												<td align='left'>
													<table border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td>
																<input type="text" name="username" size="30" disabled="disabled" value="<?= $profile['username'];?>">
															</td>
															<td valign="top"></td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td align='right' valign = "top">
													<font face="arial,helvetica" size='-1'><span><b><?php echo $lang['email'];?></b></span></font>
												</td>
												<td align='left'>
													<table border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td>
																<input type='text' name='email' size='30' value='<?php echo $profile['email'];?>' <?php if(!(int)$mwe_config['allow_user_email_change']) echo 'disabled="disabled"';?>>
															</td>
															<td valign="top"></td>
														</tr>
													</table>
												</td>
											</tr>
								<?php 
									if((int)$mwe_config['allow_user_pass_change']) 
									{
								?>
										<tr>
											<td align='right' valign = "top">
												<font face="arial,helvetica" size='-1'><span><b><?php echo $lang['newpass']; ?></b></span></font>
											</td>
											<td align='left'>
												<table border='0' cellspacing='0' cellpadding='0'>
													<tr>
														<td>
															<input type="password" size="30" name="new_pass">
														</td>
														<td valign = "top"></td>
													</tr>
												</table>
											</td>
										</tr>
								<?php
									}
								?>
										<!-- EXPANSION -->
										<tr>
											<td align='right' valign = "top">
												<font face="arial,helvetica" size='-1'><span><b><?php echo $lang['expansion']; ?></b></span></font>
											</td>
											<td align='left'>
												<table border='0' cellspacing='0' cellpadding='0'>
													<tr>
														<td>
															<select name="exp">
															<?php
																if($profile['expansion'] == 2)
																{
																	echo "<option value='2' selected='selected'>WotLK</option><option value='1'>TBC</option><option value='0'>Classic</option>";
																}
																elseif($profile['expansion'] == 1)
																{
																	echo "<option value='2'>WotLK</option><option value='1' selected='selected'>TBC</option><option value='0'>Classic</option>";
																}
																else
																{
																	echo "<option value='2'>WotLK</option><option value='1'>TBC</option><option value='0' selected='selected'>Classic</option>";
																}
															?>
														</select>
														</td>
														<td valign = "top"></td>
													</tr>
												</table>
											</td>
										</tr>
										</table>
										<br />
										<!-- END "change your info" TABLE -->
										<div align="center">
											<input type="image" src="<?php echo $Template['path']; ?>/images/buttons/button-update.gif" class="button" style="font-size:12px;" value="<?php echo $lang['change'];?>">
										</div>
									</td>
								</tr>
							</td>
						</tr>
					</table>
					</form>
			<?php	
				if((int)$mwe_config['reg_require_secret_questions'])
				{
			?>
					<br />
					<br />
					<?php write_subheader($lang['Other_Info']); ?>
					<table width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;">
						<tr>
							<td>
								<table width='510' style="border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $Template['path']; ?>/images/light3.jpg');">
								<tr>
									<td>
										<table border='0' cellspacing='0' cellpadding='4'>
										
										<!--Secret QUESTION-->
									<?php
										// We must check to see if they are set. If so then we need to
										// show a success message. Secret questions are NOT meant to be changed
										// If they arent set, then show the form to set them
										if($profile['secret_q1'] == '' || $profile['secret_q1'] == 'Disabled')
										{
											echo '<center><span style="color: red">'.$lang['secretq_not_set'].'</span></center><br />';
										?>
											<form method="post" action="?p=account&sub=manage&action=changesecretq">
											<tr>
												<td align='right'>
													<font face="arial,helvetica" size='-1'><span><b><?php echo $lang['secretq'];?> 1
													<img src="<?php echo $Template['path']; ?>/images/icons/warning.gif" width="15" height="15"
													onmouseover="ddrivetip('<?php echo $lang['secretq_info']; ?>: <ul><li><?php echo $lang['secretq_info_mincharacters']; ?>.</li><li><?php echo $lang['secretq_info_nosymbols']; ?>.</li><li><?php echo $lang['secretq_info_bothfields']; ?>.</li></ul>','#ffffff')";
													onmouseout="hideddrivetip()">
													<br />
													</b></span></font>
												</td>
												<td align='left'>
													<table border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td>
																<select name="secretq1">
																	<option <?php if($profile['secret_q1'] == '')echo "selected"; ?> value="0">None</option>
																	  <?php
																	  foreach ($secret_questions as $question)
																	  {
																	  ?>
																		<option value="<?php echo htmlspecialchars($question['question']); ?>" <?php if ($profile['secret_q1'] == htmlspecialchars($question['question'])){ echo "selected"; } ?>><?php echo $question['question']; ?></option>
																	  <?php
																	  }
																	  ?>
																</select>
																<input type="name" name="secreta1" style="margin:1px;">
															</td>
															<td valign = "top"></td>
														</tr>
													</table>
												</td>
											</tr>

											<tr>
												<td align="right" width='30%'>
													<font face="arial,helvetica" size=-1><span><b><?php echo $lang['secretq'];?> 2
													<img src="<?php echo $Template['path']; ?>/images/icons/warning.gif" width="15" height="15"
													onmouseover="ddrivetip('<?php echo $lang['secretq_info']; ?>: <ul><li><?php echo $lang['secretq_info_mincharacters']; ?>.</li><li><?php echo $lang['secretq_info_nosymbols']; ?>.</li><li><?php echo $lang['secretq_info_bothfields']; ?>.</li></ul>','#ffffff')";
													onmouseout="hideddrivetip()">
													<br />
													</b></span></font>
												</td>
												<td align="left" colspan='2'>
													<table border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td>
																<select name="secretq2">
																	<option <?php if($profile['secret_q2'] == '')echo "selected"; ?> value="0">None</option>
																	<?php
																	foreach ($secret_questions as $question)
																	{
																	?>
																		<option value="<?php echo htmlspecialchars($question['question']); ?>" <?php if ($profile['secret_q2'] == htmlspecialchars($question['question'])){ echo "selected"; } ?>><?php echo $question['question']; ?></option>
																	<?php
																	}
																	?>
																</select>
																<input type="name" name="secreta2" style="margin:1px;">
															</td>
															<td valign = "top"></td>
														</tr>
													</table>
												</td>
											</tr>

											<tr>
												<td align="center" colspan='2'>
													<table border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td>
																<input type="image" src="<?php echo $Template['path']; ?>/images/buttons/button-update.gif" class="button" style="font-size:12px;" value="<?php echo $lang['change'];?>">
															</td>
														</tr>
													</table>
												</td>
											</tr>		
											</form>
										<!--Secret QUESTION END-->
									<?php
										}
									?>
										</table>
									</td>
								</tr>
								</table>
							</td>
						</tr>
					</table>
			<?php
				}
			?>
				</td>
			</tr>
		</table>
		<br />
		<br />				
	<!--Shadow Bottom-->
	<?php 
	// Build the bottom shadow, this is a blizzlike function located in body_functions.php
	buildShadowBottom(); 
	?>
	<!--Shadow Bottom-->

	</center>
<?php 
}
builddiv_end();
?>