<!-- QuickLinks -->
<div id="q-links">
	<h3><?php echo $lang['quicklinks'];?></h3>
	<ul>
		<li>
			<a href="<?php echo mw_url('account', 'manage'); ?>"><?php echo $lang['account_manage']; ?></a>
		</li>
		<li class="e">
			<a href="<?php echo mw_url('account', 'register'); ?>"><?php echo $lang['account_create']; ?></a>
		</li>
		<li>
			<a href="<?php echo mw_url('server', 'realmstatus'); ?>"><?php echo $lang['realmstatus']; ?></a>
		</li>
		<li class="e">
			<a href="<?php echo mw_url('support', 'faq'); ?>"><?php echo $lang['faq']; ?></a>
		</li>
		<li>
			<a href="<?php echo mw_url('support', 'howtoplay'); ?>"><?php echo $lang['howtoplay']; ?></a>
		</li>
		<li class="e">
			<a href="<?php echo mw_url('server', 'commands'); ?>"><?php echo $lang['ingame_commands']; ?></a>
		</li>
	</ul>
</div>
<span class="gfxhook"></span>
<hr>

<!-- VoteLinks  -->

<?php 
// If the fronpage vote banner is enabled
if($Config->get('fp_vote_banner') == 1) 
{ 
?>
	<div id="box3">
		<h3><?php echo $lang['vote_system'];?></h3>
		<ul>
			<li>
				<div>
					<center>
						<a href="<?php echo mw_url('vote'); ?>"><img src="<?php echo $Template['path']; ?>/images/vote.png" width="264" height="247" /></a>
						<?php echo $lang['fp_vote_desc'];?>
					</center>
				</div>
			</li>
		</ul>
	</div>
	<span class="gfxhook"></span>
	<hr>
<?php 
} 
?>

<!-- Screenshot of the Momment -->
<?php
if ($Config->get('module_fp_ssotd') == 1) 
{
	$date_ssotd = $DB->selectCell("SELECT `date` FROM `mw_gallery_ssotd` LIMIT 1");
	$today_ssotd = date("y.m.d");
	if ($date_ssotd != $today_ssotd) 
	{
		$rand_ssotd = $DB->selectCell("SELECT `img` FROM `mw_gallery` WHERE cat ='screenshot' ORDER BY RAND() LIMIT 1");
		$DB->query("UPDATE mw_gallery_ssotd SET image = '$rand_ssotd', date = '$today_ssotd'");
	}
	$screen_otd = $DB->selectCell("SELECT `img` FROM `mw_gallery` WHERE cat ='screenshot' ORDER BY RAND() LIMIT 1");
?>
	<div id="rightbox">
	<h3 style="height: 20px; color: #eff0ef; font-size: 12px; letter-spacing: 1px; font-weight: bold; width: 308px; padding: 1px 0 0 8px; font-family: 'Trebuchet MS', Verdana, Arial, sans-serif;"><?php echo $lang['random_screen']; ?></h3>
	<div id="innerrightbox">
<?php

	if ($screen_otd)
	{ ?>
		<a href="images/screenshots/<?php echo $screen_otd; ?>" target="_blank"><img src="modules/ssotd/show_picture.php?filename=<?php echo $screen_otd; ?>&amp;gallery=screen&amp;width=282" width="282" alt="" style="border: 1px solid #333333"/></a>
		<select onchange="window.location = options[this.selectedIndex].value" style="width: 284px;">
			<option value=""><?php echo $lang['screenshot_galleries']; ?> -&gt;</option>
			<option value="<?php echo mw_url('media', 'screen'); ?>"><?php echo $lang['screenshot_gallery']; ?></option>
			<option value="<?php echo mw_url('media', 'wallp'); ?>"><?php echo $lang['wallpaper_gallery']; ?></option>
		</select>
<?php
	}
	else
	{
		echo "No Screenshots in database";
	}
	unset($screen_otd); // Free up memory.
	echo "</div></div>";
} ?>
<!-- END SSOTD Module! -->

<!-- Newcomers section -->
<?php 
if ($Config->get('fp_newbie_guide') == 1)
{ ?>
	<div id="rightbox">
		<div class="newcommer">
			<h4><?php echo $lang['newcomers']; ?></h4>
			<p style="margin-bottom: -1px;">
				<?php echo $lang['newcomers2']; ?>
			</p>
			<ul>
				<li>&nbsp; <a href="<?php echo mw_url('support', 'howtoplay'); ?>"><?php echo $lang['newcomers']; ?></a></li>
				<li>&nbsp; <a href="<?php echo mw_url('support', 'faq'); ?>"><?php echo $lang['faq']; ?></a></li>
			</ul>
		</div>
	</div>
<?php 
} 
if(isset($usersonhomepage) || isset($hits))
{ 
?>
<!-- usersonhomepage -->
	<div id="box2">
		<h3><?php echo $lang['useronhp'];?></h3>
		<ul>
			<li>&nbsp;</li>

			<?php 
			if(isset($usersonhomepage))
			{
			?>
				<li>
					<a href="<?php echo mw_url('whoisonline'); ?>">&nbsp;<?php echo $usersonhomepage;?>&nbsp;</a>
					<?php 
						echo ($usersonhomepage == 1) ? $lang['user_online'] : $lang['users_online']; 
					?>           
				</li>
				<li>&nbsp;</li>
			<?php 
			} 
			if(isset($hits))
			{ ?>
				<li>
					<p  style="padding-left:19px; margin-top:-8px"><?php echo $lang['website_hits']; ?>: <?php echo $hits; ?></p>
				</li>
				<li>&nbsp;</li>
			<?php 
			} ?>
		</ul>
	</div>
	<span class="gfxhook"></span>
	<hr>
<?php 
}
if(isset($servers))
{
	if (count($servers) > 0)
	{
		foreach($servers as $server)
		{
?>
			<div id="box3">
				<h3><?php echo $lang['serverinfo'];?></h3>
					<ul>
						<li>
							<div>&nbsp;</div>
						</li>
						<li>
							<div><?php echo $lang['realm_name']; ?>:&nbsp;<b><?php echo $server['name'];?></b></div>
						</li>
					<?php 
						if(isset($server['realm_status']))
						{
					?>
							<li>
								<div><?php echo $lang['realm_status']; ?>:&nbsp;
								<?php 
									if ($server['realm_status'])
									{ 
								?>
										<img src="<?php echo $Template['path']; ?>/images/icons/uparrow2.gif" height="15" alt="Online" /> 
										<b style="color: rgb(35, 67, 3);">Online</b>
								<?php 
									}
									else
									{
								?>
										<img src="<?php echo $Template['path']; ?>/images/icons/downarrow2.gif" height="15" alt="Offline" /> 
										<b style="color: rgb(102, 13, 2);">Offline</b>
								<?php 
									}?>
								</div>
							</li>
					<?php 
						}
						if(isset($server['onlineurl']))
						{
					?>
							<li>
								<div>
									<?php echo $lang['Online']; ?>:&nbsp;
									<a href="<?php echo $server['onlineurl'] ?>"><?php echo $server['playersonline']; ?></a>
								</div>
							</li>

					<?php 
						}
						if(isset($server['server_ip']))
						{
					?>
							<li>
								<div>
									<?php echo $lang['server_ip']; ?>:&nbsp;<b><?php echo $server['server_ip']; ?></b>
								</div>
							</li>
					<?php 
						}
						if(isset($server['type']))
						{
					?>
							<li>
								<div>
									<?php echo $lang['Type']; ?>:&nbsp;<b><?php echo $server['type'];?></b>
								</div>
							</li>
					<?php 
						}
						if(isset($server['language']))
						{
					?>
							<li>
								<div>
									<?php echo $lang['Language']; ?>:&nbsp;<b><?php echo $server['language']; ?></b>
								</div>
							</li>
					<?php 
						}
						if (isset($server['population']))
						{
					?>
							<li>
								<div>
									<?php echo $lang['Population']; ?>:&nbsp;<b><?php echo population_view($server['population']);?></b>
								</div>
							</li>
					<?php 
						}
						if (isset($server['accounts']))
						{
					?>
							<li>
								<div>
									<?php echo $lang['Accounts']; ?>:&nbsp;<b><?php echo $server['accounts'];
									if(isset($server['active_accounts']))
									{
										echo sprintf($lang['active_accounts'], $server['active_accounts']);
									} ?></b>
								</div>
							</li>

					<?php 
						}
						if(isset($server['characters']))
						{
					?>
							<li>
								<div>
									<?php echo $lang['Characters']; ?>:&nbsp;<b><?php echo $server['characters'];?></b>
								</div>
							</li>
					<?php 
						}
						if ($server['moreinfo'])
						{
					?>
							<li>
								<div>
									<a href="<?php echo mw_url('server', 'info'); ?>"><?php echo $lang['more_info']; ?></a>
								</div>
							</li>

					<?php 
						} 
					?>
						<li>
							<div>&nbsp;</div>
						</li>
					</ul>
			</div>
			<span class="gfxhook"></span>
			<hr>
<?php 	} 
	}
}?>
