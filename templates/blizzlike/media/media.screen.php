<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}

builddiv_start(1, $lang['screenshot_gallery']) ?>
<?php
    if (isset($_POST['doadd'])){
     $img=isset($_FILES["filename"]["name"]) ? $_FILES["filename"]["name"] : '';
     $comment=isset($_POST['message']) ? $_POST['message'] : '';
     $autor=$user['character_name'];
     $date=date("Y-m-d");
     if($_FILES["filename"]["size"] > (1024*$screensize*1024) ) {
     echo $lang['Filesizes'];
	 echo " ";
	 echo $screensize;
	 echo Mb;
     exit; }
     if(!in_array($_FILES["filename"]["type"], array("image/jpeg", "image/pjpeg", "image/jpg"))) {
     echo $lang['Filetype'];
     echo ("<br/>");
     exit;
     }
     if($DB->selectCell("SELECT COUNT(*) FROM `mw_gallery` WHERE img=? AND cat='screenshot'", $img)){
     echo $lang['ErrorFilename'];
     exit;
     }
     if(copy($_FILES["filename"]["tmp_name"],
     "./images/screenshots/".$_FILES["filename"]["name"])) {
     $DB->query("INSERT INTO `mw_gallery` (`img`,`comment`,`autor`,`date`,`cat`) VALUES(?,?,'$autor','$date','screenshot')",$img,$comment);
     } else {
     echo $lang['Uploaderror']; }
    }
?>
<?php
$gal_count = $DB->selectCell("SELECT COUNT(*) FROM `mw_gallery` WHERE `cat`='screenshot'");
?>


<table border = 0 width=100%>
<?php if($user['id']>=1){ ?>
<tr><td ><img src="<?= $Template['path']; ?>/images/icons/image_add.gif">&nbsp;<a href="?p=media&amp;sub=addgalscreen"><?php echo $lang['Addimage'];?></a></td>
<td align=right><?php echo $lang['Totalingallery'].":";?> <?php echo $gal_count; ?></td></tr>
</table>
<?php }else{ ?>
<td align=right><?php echo $lang['Totalingallery'].":";?> <?php echo $gal_count; ?></td></tr>
</table>
<style type = "text/css">
  td.serverStatus1 { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus2 { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>
<?php }
if ($gal_count) {
?>
<center>
<b>Page: 1</b>
<table border=0>
<tr>
<?php
$sql = $DB->select("SELECT * FROM `mw_gallery` WHERE `cat`='screenshot'");
foreach($sql as $tablerows){
?>

<TR>
<TD ROWSPAN=3 align="center">

<table style="margin: 7px;" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td><img src="<?= $Template['path']; ?>/images/gallery/lt.png" class="png" style="width: 9px; height: 9px;" border="0" height="9" width="9"></td>
<td background="<?= $Template['path']; ?>/images/gallery/_t.gif"><img src="<?= $Template['path']; ?>/images/gallery/_.gif" height="1" width="1"></td>
<td><img src="<?= $Template['path']; ?>/images/gallery/rt.png" class="png" style="width: 11px; height: 9px;" border="0" height="9" width="11"></td>
</tr>
<tr>
<td background="<?= $Template['path']; ?>/images/gallery/_l.gif"><img src="<?= $Template['path']; ?>/images/gallery/_.gif" height="1" width="1"></td>
<td>
<a href="modules/ssotd/show_picture.php?filename=<?php echo $tablerows['img'];?>&amp;gallery=screen" target="_blank"><img style="width: 235px; height: 175px;" alt="<?php echo  $tablerows['comment'];?>"
src="modules/ssotd/show_picture.php?filename=<?php echo $tablerows['img'];?>&amp;gallery=screen&amp;width=235&amp;height=175" border="0"></a>
</td>
<td background="<?= $Template['path']; ?>/images/gallery/_r.gif"><img src="<?= $Template['path']; ?>/images/gallery/_.gif" height="1" width="1"></td>
</tr>
<tr>
<td><img src="<?= $Template['path']; ?>/images/gallery/lb.png" class="png" style="width: 9px; height: 12px;" border="0" height="12" width="9"></td>
<td background="<?= $Template['path']; ?>/images/gallery/_b.gif"><img src="<?= $Template['path']; ?>/images/gallery/_.gif" height="1" width="1"></td>
<td><img src="<?= $Template['path']; ?>/images/gallery/rb.png" class="png" style="width: 11px; height: 12px;" border="0" height="12" width="11"></td>
</tr>
</tbody>
</table>

</TD>
<td><?php echo  $lang['comment'].": ".$tablerows['comment'];?></td>
</TR><TR>
<td><?php echo $lang['author'].": ".$tablerows['autor'];?></td>
</TR><TR>
<td><?php echo $lang['date'].": ".date("Y-m-d", $tablerows['date']);?></td>
</TR>
<TR>
<td colspan=2></td>
</TR>
<?php 
        unset($tablerows);
    }
    unset($sql);
}
else {
    echo "No Screenshots in gallery. Upload a screenshot.";
}
?>
</tr>
</table>
</center>
<?php builddiv_end() ?>
