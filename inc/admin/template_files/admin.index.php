<!-- Start #main -->
		<div id="main">			
			<div class="content">	
				<div class="content-header">
					<h4><center><?php echo $lang['welcome_message']; ?></center></h4>
				</div> <!-- .content-header -->				
				<div class="main-content">				
					<table style="border-bottom: 1px solid #E5E2E2">
						<thead>
							<th colspan='5'><center><?php echo $lang['cp_options']; ?></center></th>
						</thead>
						<tr>
							<td height="80px" width="130px" align="center">
								<a href="?p=admin&sub=news"><img src="inc/admin/images/icons/news-icon.png" border="0" /></a><br />
								<a href="?p=admin&sub=news"><?php echo $lang['manage_news']; ?></a>
							</td>
							<td height="80px" width="130px" align="center">
								<a href="?p=admin&sub=users"><img src="inc/admin/images/icons/ManageUsers-icon.png" border="0" /></a><br />
								<a href="?p=admin&sub=users"><?php echo $lang['manage_users']; ?></a>
							</td>
							<td height="80px" width="130px" align="center">
								<a href="?p=admin&sub=siteconfig"><img src="inc/admin/images/icons/settings.png" border="0" /></a><br />
								<a href="?p=admin&sub=siteconfig"><?php echo $lang['site_config']; ?></a>
							</td>
							<td height="80px" width="130px" align="center">
								<a href="?p=admin&sub=dbconfig"><img src="inc/admin/images/icons/db_settings.png" border="0" /></a><br />
								<a href="?p=admin&sub=dbconfig"><?php echo $lang['database_config']; ?></a>
							</td>
							<td height="80px" width="130px" align="center">
								<a href="?p=admin&sub=realms"><img src="inc/admin/images/icons/realm-icon.png" border="0" /></a><br />
								<a href="?p=admin&sub=realms"><?php echo $lang['manage_realms']; ?></a>
							</td>
						</tr>
						
					<!-- ROW 2 -->
						<tr>
							<td height="80px" width="130" align="center">
								<a href="?p=admin&sub=fplinks"><img src="inc/admin/images/icons/menu-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=fplinks"><?php echo $lang['fp_links']; ?></a>
							</td>
							<td height="80px" width="130" align="center">
								<a href="?p=admin&sub=vote"><img src="inc/admin/images/icons/vote-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=vote"><?php echo $lang['vote_links']; ?></a>
							</td>							
							<td height="80px" width="130"align="center">
								<a href="?p=admin&sub=shop"><img src="inc/admin/images/icons/shop-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=shop"><?php echo $lang['manage_shop']; ?></a>
							</td>
							<td height="80px" width="130"align="center">
								<a href="?p=admin&sub=donate"><img src="inc/admin/images/icons/donate-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=donate"><?php echo $lang['donate_admin']; ?></a>
							</td>
							<td height="80px" width="130" align="center">
								<a href="?p=admin&sub=faq"><img src="inc/admin/images/icons/faq-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=faq"><?php echo $lang['faq_admin']; ?></a>
							</td> 
						</tr>
						
					<!-- ROW 3 -->
						<tr>
							<td height="80px" width="130" align="center">
								<a href="?p=admin&sub=cache"><img src="inc/admin/images/icons/cache-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=cache"><?php echo $lang['cache_settings']; ?></a>
							</td>
							<td height="80px" width="130" align="center">
								<a href="?p=admin&sub=regkeys"><img src="inc/admin/images/icons/keys-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=regkeys"><?php echo $lang['reg_keys']; ?></a>
							</td>
							<td height="80px" width="130" align="center">
								<a href="?p=admin&sub=banlist"><img src="inc/admin/images/icons/Delete-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=banlist"><?php echo $lang['ban_list']; ?></a>
							</td>
							<td height="80px" width="130" align="center">
								<a href="?p=admin&sub=chartools"><img src="inc/admin/images/icons/char-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=chartools"><?php echo $lang['char_tools']; ?></a>
							</td>
							<td height="80px" width="130"align="center">
								<a href="?p=admin&sub=sendgamemail"><img src="inc/admin/images/icons/ingame-mail-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=sendgamemail"><?php echo $lang['send_ingame_mail']; ?></a>
							</td>
						</tr>
						
					<!-- ROW 4 -->
						<tr>
							<td height="80px" width="130"align="center">
								<a href="?p=admin&sub=stats"><img src="inc/admin/images/icons/Statistics-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=stats"><?php echo $lang['statistics']; ?></a>
							</td>
							<td height="80px" width="130" align="center">
								<a href="?p=admin&sub=email"><img src="inc/admin/images/icons/mailbox-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=email"><?php echo $lang['send_email']; ?></a>
							</td>
							<td height="80px" width="130"align="center">
								<a href="?p=admin&sub=info"><img src="inc/admin/images/icons/info-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=info"><?php echo $lang['cms_info']; ?></a>
							</td>
							<td height="80px" width="130" align="center">
								<a href="?p=admin&sub=updates"><img src="inc/admin/images/icons/Download-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=updates"><?php echo $lang['check_updates']; ?></a>
							</td>
							<td height="80px" width="130"align="center">
								<a href="?p=admin&sub=errorlog"><img src="inc/admin/images/icons/alerts-icon.png" width="48" height="48" border="0" /></a><br />
								<a href="?p=admin&sub=errorlog"><?php echo $lang['error_logs']; ?></a>
							</td>
						</tr>
					</table>
					<table>
						<tr>
							<td align='right'>
							<?php
								$Languages = explode(",", $Config->get('available_lang'));
								echo "Language: | ";
								foreach($Languages as $Lang)
								{
									echo "<a href=\"javascript:setcookie('Language', '". $Lang ."'); window.location.reload();\">";
									if($GLOBALS['user_cur_lang'] == $Lang)
									{
										echo "<b>".$Lang."</b>"; 
									}
									else
									{
										echo $Lang;
									}
									echo "</a> | ";
								}
							?>
							</td>
						</tr>
					</table>
				</div> <!-- .main-content -->	
			</div> <!-- .content -->		
		</div> <!-- #main -->