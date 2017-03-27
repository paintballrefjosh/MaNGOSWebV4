<div style="margin-left: -29px;">
	<style media="screen" title="currentStyle" type="text/css">
		@import url("<?php echo $Template['path']; ?>/css/additional_fp.css");

	</style>
	<div id="module-container">
		<?php 
		// Load the banner display type. 1 = internal flash, 2 = external flash (wow.com), 3 is banner
		$banner = (int)$mwe_config['flash_display_type'];
		if ($banner == 1)
		{ ?>
			<div id="flashcontainer">
				<embed type="application/x-shockwave-flash" src="modules/flash/loader2.swf" id="flashbanner" name="flashbanner" quality="high" wmode="transparent" base="modules/flash/<?php echo $GLOBALS['user_cur_lang']; ?>" flashvars="xmlname=news.xmls" height="340" width="500">
			</div>
				<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<?php 
		}
		elseif($banner == 2) 
		{ ?>
			<div id="flashcontainer">
				<embed type="application/x-shockwave-flash" src="http://www.worldofwarcraft.com/new-hp/flash/loader2.swf" id="flashbanner" name="flashbanner" quality="high" wmode="transparent" base="http://www.worldofwarcraft.com/new-hp/flash/" flashvars="news.xmls" height="340" width="500">
			</div>
			<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<?php
		}
		else
		{ ?>
			<div id="flashcontainer">
				<br /><br /><br /><br />
				<center><img src="<?php echo $Template['path']; ?>/images/banner.jpg" alt="" width="470"/></center>
			</div>
			<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<?php 
		} ?>
	</div>
	<div class="module-container" style="position: relative;">
	<?php
		if($alltopics != FALSE)
		{
			foreach($alltopics as $topic)
			{ 
				$postnum++;
				if($hl=='alt')
				{
					$hl='';
				}
				else 
				{
					$hl='alt';
				}
				
				if($topic['posted_by'] == 0)
				{
					$posted_by['username'] = "Mistvale.com Dev Team";
				}
				else
				{
					$posted_by = $RDB->selectRow("SELECT username FROM account WHERE id = '".$topic['posted_by']."'");
				}
?>                                                              
				<script type="text/javascript">
					var postId<?php echo $postnum; ?>="<?php echo $topic['id'];?>";
				</script>
				<div class="news-expand" id="news<?php echo $topic['id'];?>">
					<div class="news-border-left"></div>
					<div class="news-border-right"></div>
					<div class="news-listing">
						<div onclick="javascript:toggleEntry('<?php echo $topic['id'];?>','<?php echo $hl;?>')" onmouseout="javascript:this.style.background='none'" onmouseover="javascript:this.style.background='#EEDB99'" class="hoverContainer">
							<div>
								<div class="news-top">
									<ul>
										<li class="item-icon">
											<img border="0" alt="new-post" src="<?php echo $Template['path']; ?>/images/news-contests.gif"/>
										</li>
										<li class="news-entry">
											<h1>
												<a href="javascript:dummyFunction();"><?php echo $topic['title'];?></a>
											</h1>
											<span class="user">Posted by: <b><?php echo ucwords(strtolower($posted_by['username']));?></b>|</span>&nbsp;<span class="posted-date">
												<?php echo date('d-m-Y',$topic['post_time']);?>
											</span>
										</li>
										<li class="news-entry-date">
											<span><strong><?php echo date('d-m-Y',$topic['post_time']);?> </strong></span>
										</li>
										<li class="news-toggle">
											<a href="javascript:toggleEntry('<?php echo $topic['id'];?>','<?php echo$hl;?>')">
												<img src="<?php echo $Template['path']; ?>/images/pixel001.gif" alt=""/>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="news-item">
						<blockquote>
							<dl>
								<dd>
									<ul>
										<li>
											<div class="letter-box0"></div>
											<div class="blog-post">
												<?php echo $topic['message'];?>
												<div align="right"></div>                
											</div>                
										</li>
									</ul>
								</dd>
							</dl>
						</blockquote>
					</div>
				</div>

				<script type="text/javascript"><!--
				var position = <?php echo $postnum;?>;
				var localId = postId<?php echo $postnum;?>;
				var cookieState = getcookie("news"+localId);
				var defaultOpen = "<?php echo $mwe_config['module_news_open'];?>";
				if ((cookieState == 1) || (position==1 && cookieState!='0') || (defaultOpen == 1 && cookieState!='0')) {
				} else {
					document.getElementById("news"+localId).className = "news-collapse"+"<?php echo $hl;?>";       
				}
				--></script>
		<?php 
			}
			unset($alltopics, $hl, $postnum);
		}
	?>                                                                
	</div>
	<div class="news-archive-link" <?php if ($banner==1) echo 'style="position: relative;"';?>>
		<div class="news-archive-button">
			<a href="<?php echo $mwe_config['site_forums']; ?>"><span><?php echo $lang['view_news_archives'];?></span></a>
		</div>
	</div>
	<div>
		<div id="container-community">
			<div class="phatlootbox-top">
				<h2 class="community">
					<span class="hide">General</span>
				</h2>
					<span class="phatlootbox-visual comm"></span>
			</div>
			<div class="phatlootbox-wrapper">
				<div style="background: url(<?php echo $Template['path']; ?>/images/phatlootbox-top-parchment.jpg) repeat-y top right; height: 7px; width: 456px; margin-left: 6px; font-size: 1px;"></div>
				<div class="community-cnt"><font size="-1"><?php echo $lang['community_header1'];?></font>
					<br /><br />
					<font size="-1">
					<center>
						<a href="http://thottbot.com/">
							<img src="<?php echo $Template['path']; ?>/images/thottbot.png" width="100" height="75" longdesc="http://thottbot.com/" />
						</a>
						<a href="http://www.wowhead.com/">
							<img src="<?php echo $Template['path']; ?>/images/wowhead.png" width="120" height="78" />
						</a>
						<a href="http://www.wowwiki.com/Portal:Main">
							<img src="<?php echo $Template['path']; ?>/images/wowwiki.png" width="152" height="35" /></a><a href="http://www.wowhead.com/">
						</a>
					</center>
					<br /><?php echo $lang['community_header2'];?>
					</font>
				</div>
				<div class="phatlootbox-bottom"></div>
			</div>
		</div>
	</div>
	<div class="phatlootbox-top2" align="right">
		<div align="right">
			<div align="center" style="position:relative; top:-16px; left:-100px">
				<img src="<?php echo $Template['path']; ?>/images/chains-long.gif" />
			</div>
			<div align="center" style="position:relative; top:-32px; left:100px">
				<img src="<?php echo $Template['path']; ?>/images/chains-long.gif" />
			</div>
			<div style="position:relative; top:-38px; left:0px">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="postContainerPlain"	>
					<tr>
						<td width="50%">
							<div align="center" style="position:relative; top:1px; left:0px;">
								<a href="<?php echo $mwe_config['site_forums']; ?>">
									<img src="<?php echo $Template['path']; ?>/images/box-support.gif" width="226" height="93" />
								</a>
							</div>
						</td>
						<td width="50%">
							<div align="center">
								<a href="<?php echo $mwe_config['site_forums']; ?>">
									<img src="<?php echo $Template['path']; ?>/images/box-jobs.gif" width="226" height="93" />
								</a>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
