<br>
<?php builddiv_start(1, $lang['UScreen']) ?>
<?php if($user['id']<=0){ ?>
<center><div style="background-color:#FF0033;border:groove 4px;margin:4px;padding:6px 9px 6px 9px;"><strong>  
 <?php echo $lang['access_denied'];
}else{ ?>
<?php
if (isset($user['character_name'])) { ?>
<html>
<body>	
<center>
  <font color="red"><b><?php echo $lang['Filesizes'];?> <?php echo $screensize;?><?php echo Mb ;?></b></font>
</center><br/>
<form method="post" action="index.php?n=media&sub=screen" enctype="multipart/form-data">
	<?php echo $lang['author'];?>: <b><?php echo $user['character_name']; ?></b><br/>
        <?php echo $lang['comment'];?>:<br/>
	     <textarea name="message" cols="5" rows="5" id="textarea" style="width: 95%; height: 70px;"></textarea><br/>
	     <?php echo $lang['file'];?>:<br/>
	     <input type="hidden" name="postnewfile" value="POST">
       <input type="file" name="filename"><br/> 
       <center><input type="submit" value="<?php echo $lang['UScreen']; ?>" name="doadd"><br/></center>
<form>

</body>
</html>

<?php } else {echo '<br><br><p align="center" style="color:red; font-size: 15px; font-weight:bold; ">'.$lang['no_char_gal'].'</p><br><br>';} ?>
<?php } ?>
<?php builddiv_end() ?>