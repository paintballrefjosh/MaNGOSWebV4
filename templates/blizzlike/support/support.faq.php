<br>
<?php builddiv_start(1, "FAQ") ?>
<style media="screen" title="currentStyle" type="text/css">
    .postContainerPlain {
        font-family:arial,palatino, georgia, verdana, arial, sans-serif;
        color:#000000;
        padding:5px;
        margin-bottom: 4px;
        font-size: x-small;
        font-weight: normal;
        background-color: #E7CFA3;
        background-image: url('<?php echo $Template['path']; ?>/images/light.jpg');
        border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:0px;
        line-height:140%;
  }
    .postBody {
        padding:10px;
        line-height:140%;
        font-size: small;
  }
    .title {
        font-family: palatino, georgia, times new roman, serif;
        font-size: 14pt;
        color: #640909;
    }
</style>
<center><img src="<?php echo $Template['path'] ?>/images/confusedorc.jpg" width="153" height="200" /></center><br />
<?php echo $lang['faq_desc']; ?><br /><br />
<table align="center" width="100%">
	<tr>
		<td align="center">
			<?php 
			if($alltopics != FALSE)
			{
				foreach($alltopics as $topic)
				{
				$cc1++
				?>
				<div style="margin-right: 0pt;" class="postContainerPlain" align="left">
					<h3 class="title"><?php echo $cc1 ?>. <?php echo $topic['question'];?><br/></h3>
					<div class="postBody"><b style="color: rgb(35, 67, 3);">Answer: </b><?php echo $topic['answer'];?></div>
				</div>
				<?php 
				}
			}
			else
			{
				echo "<b style='color: rgb(35, 67, 3);'>No FAQ in the database!</b>";
			}?>
		</td>
	</tr>
</table>
<?php builddiv_end() ?>