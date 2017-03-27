<br>
<?php builddiv_start(1, $lang['UWallp']) ?>
<?php

if($user['id'] <= "0")
{
?>
        <center><div style="background-color:#FF0033;border:groove 4px;margin:4px;padding:6px 9px 6px 9px;"><strong>
<?php 
        echo $lang['access_denied'];
}
else
{
        if(isset($user['character_name']))
        {

?>
<html>
<body>	
<center><font color="red"><b><?php echo $lang['Filesizew'];?></b></font></center><br/>
<form method="post" action="index.php?n=media&amp;sub=wallp" enctype="multipart/form-data">
<?php echo  $lang['author'];?>: <b><?php echo $user['character_name']; ?></b><br/>
<?php echo  $lang['file'];?>:<br/>
<input type="hidden" name="postnewfile" value="POST">
<input type="file" name="filename"><br/> 
<center><input type="submit" value="<?php echo $lang['UWallp']; ?>" name="doadd"><br/></center>
<form>

</body>
</html>
<?php
        }
        else
        {
                echo '<br><br><p align="center" style="color:red; font-size: 15px; font-weight:bold; ">'.$lang['no_char_gal'].'</p><br><br>';
        }

}
?>