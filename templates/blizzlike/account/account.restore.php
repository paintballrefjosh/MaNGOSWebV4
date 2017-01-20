<br>
<?php 
builddiv_start(0, $lang['retrieve_pass']);
if($user['id'] < 1)
{ ?>
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
	<!--Shadow Top-->
	<?php 
		// Check to see if the user has posted stuff, if so then we show the message
		// otherwise show the form.
		if(isset($_POST['retr_login']))
		{
			process();
		}
		else
		{
			echo "<center>";
		
			// Build the top shadow, this is a blizzlike function located in body_functions.php
			buildShadowTop(); 
	?>
	<!--Shadow Top-->
			<form action="index.php?p=account&sub=restore" method="post">
			<table cellspacing = "0" cellpadding = "4" border = "0">
				<tr>
					<td>
						<h3 class="title"><font color="white"><?php echo $lang['have_you_forgot_pass'];?></font></h3>
						<p>
							<table width = "510" cellspacing = "0" cellpadding = "0" border = "0">
								<tr>
									<td>
										<img align="right" src="<?php echo $Template['path']; ?>/images/confusedorc.jpg">
										<?php  echo add_pictureletter($PAGE_DESC);?>
									</td>
								</tr>
								<tr>
									<td>
										<form action="index.php?p=account&sub=restore" method="post">
										<table width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;">
										<tr>
											<td>
												<table width = "100%" style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $Template['path']; ?>/images/light3.jpg');">
												<tr>
													<td align = "center">
														<table border='0' cellspacing='0' cellpadding='4'>
															<div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:center;width:70%;">
																<?php echo $lang['username'];?>:<br /> <input type="text" name="retr_login" size="26" maxlength="16" style="font-size:11px;"  style="width:120px;">
																<br />
																<?php echo $lang['email']?>:<br /> <input type="text" name="retr_email" size="26" maxlength="80" style="font-size:11px;"  style="width:120px;">
																<br /><br />
																<?php echo $lang['secretq'];?> 1:<br />
																<select name="secretq1" style="width:120px;">
																	<option <?php if(isset($profile['secretq2']) && $profile['secretq2'] == 0)echo "selected"; ?> value="0">None</option>
															<?php
																	foreach ($sc_q as $question)
																	{
															?>
																		<option value="<?php echo htmlspecialchars($question['question']); ?>"><?php echo $question['question']; ?></option>
															<?php
																	}
															?>
																</select>
																<br />
																<input type="text" name="secreta1" size="26" maxlength="80" style="font-size:11px;"  style="width:120px;">
																<br /><br />
																<?php echo $lang['secretq'];?> 2:<br />
																<select name="secretq2" style="width:120px;">
																	<option <?php if(isset($profile['secretq2']) && $profile['secretq2'] == 0)echo "selected"; ?> value="0">None</option>
															<?php
																	foreach ($sc_q as $question)
																	{
															?>
																		<option value="<?php echo htmlspecialchars($question['question']); ?>"><?php echo $question['question']; ?></option>
															<?php
																	}
															?>
																</select><br />
																<input type="text" name="secreta2" size="26" maxlength="80" style="font-size:11px;"  style="width:120px;">
																<br />
															</div>
														</table>
													</td>
												</tr>
												<tr>
													<td>
														<center>
														<br />
														<input type="image" src="<?php echo $Template['path']; ?>/images/buttons/continue-button.gif" size="16" class="button" style="font-size:12px;" value="<?php echo $lang['retrieve_pass'] ?>">
														</center>
													</td>
												</tr>
												</table>
											</td>
										</tr>
										</table>
										</form>
									</td>
								</tr>
						</p>
					</td>
				</tr>
			</table>
			</form>
		<!--Shadow Bottom-->
		<?php 
			// Build the bottom shadow, this is a blizzlike function located in body_functions.php
			buildShadowBottom();
			
			echo "</center>";
		}
		?>
	<!--Shadow Bottom-->
<?php
}
else
{
  echo "You are logged In!";
}
builddiv_end() ?>