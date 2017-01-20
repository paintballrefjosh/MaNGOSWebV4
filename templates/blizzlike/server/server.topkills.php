<style type="text/css">
	#header        { COLOR: white; FONT-WEIGHT: bold; FONT-VARIANT: small-caps; TEXT-DECORATION: none; LETTER-SPACING: 4px;}
	input.button  { background-color: transparent; border-style: none; }
	.calendarDayHeading { width: 110px; height: 30px; color: FFFFFF; text-align: center; font-family: tahoma; font-weight: bold; background-image:url('/shared/wow-com/images/basics/raidcalendar/images/day.jpg');}
	.calendarCell { width: 110px; height: 100px; vertical-align: top; color: dddddd; font-family: tahoma; font-weight: bold; }
	.navigation{
		position: absolute;
		top:91px;
	}
	.button{
		color:#FFFFFF;
		font-size:9px;
		letter-spacing:-1px;
	}
	a.nav:link{   
		font-family: arial,verdana, sans-serif;
		color: CBA300;
		font-size: 11px;
		font-weight:normal;
	}   
	a.nav:visited{
		font-family: arial,verdana, sans-serif;
		color: CBA300;
		font-size: 11px;
		font-weight:normal;
	}
	a.nav:hover{ 
		font-family: arial,verdana, sans-serif;
		color: FFFFFF;
		font-size: 11px;
		font-weight:normal;
	}
	a.nav:active{ 
		font-family: arial,verdana, sans-serif;
		color: CBA300;
		font-size: 11px;
		font-weight:normal;
	}
</style>
<center>
<div class="blogbody" style="background-image:url('<?php echo $Template['path']; ?>/images/light.jpg');">
	<style media="screen" title="currentStyle" type="text/css">
	#main { background: url('<?php echo $Template['path']; ?>/images/forum-bg.jpg') repeat-y; }
	#main-top { background: none; }
	#main-top div { background: none; }
	#main-top div div { background: none; }
	#main-content-wrapper { background: none; }
	#main-content { background: none; }
	#main-bottom { background: none; }
	#main-bottom div { background: none; }
	#main-bottom div div { background: none; }
	#content {width: 716px; margin-left: -13px;}
		#compcont, 
		#cnt-wrapper{ padding-right:0px !important; padding-left:0px !important; }
		#honorbody select {background-color: #101010; color: #ffd200; font-family: tahoma, Arial,Helvetica,Sans-Serif; font-size: 11pt; font-weight: bold;}
		#honorbody a:visited { color: #ffba16; text-decoration: underline; font-weight: bold;}
		#honorbody a:hover { color: #ffffff; text-decoration: underline; font-weight: bold;}
		#honorbody span { font-family: tahoma, Arial,Helvetica,Sans-Serif; color: #ffffff; font-size: 9pt; }
		#honorbody td { font-family: tahoma, Arial,Helvetica,Sans-Serif; color: #ffffff; font-size: 7pt; }
	</style>
	
	<table border="0" cellpadding="0" cellspacing="0" width="100%" id="honorbody">
		<tbody>
			<tr>
				<td colspan="3">
					<table background="<?php echo $Template['path']; ?>/images/ss-border-top-bg.gif" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody>
							<tr>
								<td align="left"><img src="<?php echo $Template['path']; ?>/images/ss-border-top-left.gif" height="14" width="113"></td>
								<td align="right"><img src="<?php echo $Template['path']; ?>/images/ss-border-top-right.gif" height="14" width="113"></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td background="<?php echo $Template['path']; ?>/images/ss-border-left.gif">
					<img src="<?php echo $Template['path']; ?>/images/pixel_002.gif" height="1" width="21">
				</td>
				
				<!-- Main Content --> 
				<td style="padding-left: 6px; padding-right: 6px;" bgcolor="#000000">
					<span class="lite">
						<p>
							<b><font color="#ffe400" size="3"><?php echo "Honor Ranking"; ?></font></b><br/>
							<?php echo "Top "; echo $limit; echo " Fighters of each faction"; ?>
						</p>
					</span>
					<table border="0" cellpadding="5" cellspacing="0" width="100%" align="center">
					<tr>
						<td align="center" width="50%" valign="top">
							<img src="<?php echo $Template['path']; ?>/images/banners/alliance2.png">
							<div>
								<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
									<tr>
										<td align="right" width="20"><b>#</b></td>
										<td width="20">Rank</td>
										<td width="20">Race</td>
										<td width="20">Class</td>
										<td>Name</td>
										<td align="center"><b>Lvl</b></td>
										<td align="center"><b>Kills</b></td>
									</tr>
							<?php 	
									if(isset($allhonor[1]))
									{
										$pos = 0; 
										foreach($allhonor[1] as $item)
										{
											$pos++;
							?>
											<tr>
												<td align="right" width="20" style="font-size:14px;"><b><?php echo $pos; ?></b></td>
												<td width="20" align="center"><img src="<?php echo $item['rank_icon']; ?>" onmouseover="ddrivetip('<?php echo $item['rank']; ?>','#ffffff')"; onmouseout="hideddrivetip()"></td>
												<td width="20" align="center"><img src="<?php echo $item['race_icon']; ?>" onmouseover="ddrivetip('<?php echo $item['race']; ?>','#ffffff')"; onmouseout="hideddrivetip()"></td>
												<td width="20" align="center"><img src="<?php echo $item['class_icon']; ?>" onmouseover="ddrivetip('<?php echo $item['class']; ?>','#ffffff')"; onmouseout="hideddrivetip()"></td>
												<td style="font-size:14px;"><b><?php echo $item['name']; ?></b></td>
												<td width="20" align="center" style="font-size:12px;"><b><?php echo $item['level']; ?></b></td>
												<td align="center" style="font-size:12px;"><font color="red"><b><?php echo $item['honorable_kills']; ?></b></font></td>
											</tr>
							<?php 	 
										}
									}
									
							?>
								</table>
							</div>
							<br/>
						</td>
						<td align="center" valign="top">
							<img src="<?php echo $Template['path']; ?>/images/banners/horde2.png">
							<div>
								<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
									<tr>
										<td align="right" width="20"><b>#</b></td>
										<td width="20">Rank</td>
										<td width="20">Race</td>
										<td width="20">Class</td>
										<td>Name</td>
										<td align="center"><b>Lvl</b></td>
										<td align="center"><b>Kills</b></td>
									</tr>
							<?php 	
									if(isset($allhonor[0]))
									{
										$pos = 0;
										foreach($allhonor[0] as $item)
										{ 
											$pos++; 
							?>
											<tr>
												<td align="right" width="20" style="font-size:14px;"><b><?php echo $pos; ?></b></td>
												<td width="20" align="center"><img src="<?php echo $item['rank_icon']; ?>" onmouseover="ddrivetip('<?php echo $item['rank']; ?>','#ffffff')"; onmouseout="hideddrivetip()"></td>
												<td width="20" align="center"><img src="<?php echo $item['race_icon']; ?>" onmouseover="ddrivetip('<?php echo $item['race']; ?>','#ffffff')"; onmouseout="hideddrivetip()"></td>
												<td width="20" align="center"><img src="<?php echo $item['class_icon']; ?>" onmouseover="ddrivetip('<?php echo $item['class']; ?>','#ffffff')"; onmouseout="hideddrivetip()"></td>
												<td style="font-size:14px;"><b><?php echo $item['name']; ?></b></td>
												<td width="20" align="center" style="font-size:12px;"><b><?php echo $item['level']; ?></b></td>
												<td align="center" style="font-size:12px;"><font color="red"><b><?php echo $item['honorable_kills']; ?></b></font></td>
											</tr>
							<?php 		}
									}
									unset($item,$pos, $allhonor); 
							?>
								</table>
							</div>
							<br/>
						</td>
					</tr>
					</table>
				</td>
				<!-- End Main Content -->
				
				<td background="<?php echo $Template['path']; ?>/images/ss-border-right.gif" width="10">
					<img src="<?php echo $Template['path']; ?>/images/pixel_002.gif" height="1" width="21">
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<table background="<?php echo $Template['path']; ?>/images/ss-border-bot-bg.gif" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody>
							<tr>
								<td valign="top"></td>
								<td align="center"><br/><br/></td>
								<td align="right" valign="top"></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</center>