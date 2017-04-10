<br>
<?php
builddiv_start(0, $lang['commands']); 
?>

<center>
<div class="module-container">
<?php

$postnum = 0;
$hl = '';

foreach($alltopics as $postanum => $topic)
{
    $postnum++;
    if($hl=='alt')$hl=''; else $hl='alt';
	$topic_permission = $RDB->selectCell("SELECT `name` FROM `rbac_permissions` WHERE id IN (SELECT `id` FROM `rbac_linked_permissions` WHERE linkedId = ".$topic['permission'].")");
?>
    <script type="text/javascript">
        var postId<?php echo $postnum;?>="<?php echo $postnum;?>";
    </script>
    <div class="news-expand" id="news<?php echo $postnum;?>">
		<div class="news-border-left"></div>
		<div class="news-border-right"></div>
		<div class="news-listing">
			<div onclick="javascript:toggleEntry('<?php echo $postnum;?>','<?php echo $hl;?>')" onmouseout="javascript:this.style.background='none'" onmouseover="javascript:this.style.background='#EEDB99'" class="hoverContainer">
				<div>
					<div class="news-top">
						<ul>
							<li class="item-icon">
								<img border="0" alt="new-post" src="<?php echo $Template['path']; ?>/images/news-contests.gif">
							</li>
							<li class="news-entry">
								<h1>
									<a href="javascript:dummyFunction();"><?php echo $topic['name'];?></a>
								</h1>
							</li>
							<li class="news-toggle">
								<a href="javascript:toggleEntry('<?php echo $postnum;?>','<?php echo $hl;?>')"><img alt="" src="<?php echo $Template['path']; ?>/images/pixel001.gif"></a>
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
									<playerlevel><?= $topic_permission; ?><br/></playerlevel>
									<description><?php echo str_replace("\r",'<br/>',$topic['help']);?></description>
								</div>
							</li>
						</ul>
					</dd>
				</dl>
			</blockquote>
		</div>
    </div>
    <script type="text/javascript">
    var position = <?php echo$postnum;?>;
    var localId = postId<?php echo$postnum;?>;
    var cookieState = getcookie("news"+localId);
    document.getElementById("news"+localId).className = "news-collapse"+"<?php echo $hl;?>";
    </script>
<?php 
} ?>
</div>
</center>
<?php builddiv_end() ?>