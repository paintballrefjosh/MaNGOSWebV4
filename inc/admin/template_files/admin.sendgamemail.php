<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

?>
<script type="text/javascript"> 
	$(document).ready(function(){$("#mail_to").autocomplete({source:'?p=admin&sub=sendgamemail&action=search', minLength:2});});        
</script>

<div class="content">
	<div class="content-header">
		<h4><a href="?p=admin">Main Menu</a> / Send In Game Mail</h4>
	</div> <!-- .content-header -->				
	<div class="main-content">	
	<?php 
		if(isset($_POST['msg']))
		{
			sendCharacterMail();
		}
	?>			
		<form method="POST" class="form label-inline">
		<input type="hidden" name="send_ingamemail">
			<h2><center>Send In Game Mail</center></h2>
			<table>
			<tr>
				<td align='center'><b><?php echo $lang['realm']; ?>:</b><br />
				<?php
					$Realms = getRealmlist('0');
					$x = 0;
					foreach($Realms as $Rlm)
					{
						$Rlm_ext = $RDB->selectRow("SELECT `name` FROM `realmlist` WHERE `id` = '".$Rlm['realm_id']."'");

						if($x == 1)
						{
							$separator = " | ";
						}
						else
						{
							$separator = "";
							$x = 1;
						}

						echo $separator . "<a href=\"javascript:setcookie('cur_selected_realm', '". $Rlm['realm_id'] ."'); window.location.reload();\">";
						if($user['cur_selected_realm'] == $Rlm['realm_id'])
						{
							echo "<b><font color=green>".$Rlm_ext['name']."</font></b>"; 
						}
						else
						{
							echo $Rlm_ext['name'];
						}
						echo "</a>";
					}
				?>
				</td>
			<tr>
			</table>
		<?php
				if(!isset($_POST['mail_to']))
					$_POST['mail_to'] = "";
				if(!isset($_POST['subject']))
					$_POST['subject'] = "";
				if(!isset($_POST['msg']))
					$_POST['msg'] = "";
		?>
			<div class="field">
				<label for="mail_to">Mail To: </label>
				<input id="mail_to" name="mail_to" size="20" type="text" class="medium" value="<?= $_POST['mail_to'];?>" />
			</div>
			<div class="field">
				<label for="subject">Mail Subject: </label>
				<input id="subject" name="subject" size="20" type="text" class="medium" value="<?= $_POST['subject'];?>" />
			</div>
			<div class="field">
				<label for="msg">Message: </label>
				<textarea id="msg" name="msg" rows="15" cols="78" class="large"><?= $_POST['msg'];?></textarea>
			</div>
			<br />		
			<div class="buttonrow-border">								
				<center><button><span>Send Message</span></button></center>			
			</div>
		</form>
	</div>
</div>