<!-- Start #main -->
<div id="main">			
	<div class="content">	
	<?php
		if(isset($_GET['action'])) 
		{
			if($_GET['action'] == 'add')
			{ 
				if(isset($_POST['subject'])) 
				{
					addNews($_POST['subject'],$_POST['message'],$user['username']);
				}
	?>
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=news">News</a> / Add News</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<form method="POST" action="?p=admin&sub=news&action=add" class="form label-inline">
			<input type="hidden" name="task" value="addnews">
			
				<table>
					<thead>
						<tr>
							<th><center><?php echo $lang['add_news']; ?></center></th>
						</tr>
					</thead>
				</table>
				<br />
				
				<!-- Subject -->
				<div class="field">
					<label for="Subject"><?php echo $lang['subject']; ?>: </label>
					<input id="Subject" name="subject" size="20" type="text" class="medium" />
					<p class="field_help"><?php echo $lang['news_sub_desc']; ?></p>
				</div>
				
				<div class="field">
					<label for="Message"><?php echo $lang['message']; ?>: </label><br />
					<textarea id="Message" name="message" rows="15" cols="78" class="inputbox"></textarea>
				</div>
				<br />		
				<div class="buttonrow-border">								
					<center><button><span><?php echo $lang['submit']; ?></span></button></center>			
				</div>
			</form>
		</div>

<?php 
	// Otherwise, editing
	}
	elseif($_GET['action'] == 'edit')
	{ 
		if(isset($_GET['id'])) 
		{
			$content = $DB->selectRow("SELECT * FROM `mw_news` WHERE `id`='".$_GET['id']."'");
			if(isset($_POST['delete'])) 
			{
				delNews($_POST['id']);
			}
			elseif(isset($_POST['editmessage'])) 
			{
				editNews($_POST['id'],$_POST['editmessage']);
			}
?>
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=news">News</a> / Edit News</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<form method="POST" action="?p=admin&sub=news&action=edit&id=<?php echo $_GET['id']; ?>" class="form label-inline">
			<input type="hidden" name="task" value="editnews">
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">			
				<table>
					<thead>
						<tr>
							<th><center><?php echo $lang['edit_news']; ?></center></th>
						</tr>
					</thead>
				</table>
				<br />
				
				<div class="field">
					<label for="Subject"><?php echo $lang['subject']; ?>: </label>
					<input id="Subject" name="subject" size="20" type="text" class="medium" disabled="disabled" value="<?php echo $content['title']; ?>" />
					<p class="field_help"><?php echo $lang['news_sub_desc']; ?></p>
				</div>
				
				<div class="field">
					<label for="Message"><?php echo $lang['message']; ?>: </label><br />
					<textarea id="Message" name="editmessage" rows="15" cols="78" class="inputbox"><?php echo $content['message']; ?></textarea>
				</div>
				<br />		
				<div class="buttonrow-border">								
					<center>
						<button><span><?php echo $lang['save_changes']; ?></span></button>
						<button name="delete" class="btn-sec"><span><?php echo $lang['delete']; ?></span></button>
					</center>
				</div>
			</form>
		</div>
<?php 
		}
		else
		{ ?>		
			<b><u><center>No Id Specified!</center></u></b><br /><br />

	<?php	}
	}
	else
	{ ?>
You arent suppossed to be here :p
<?php 
	} 
}
else
{
?>
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / News</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<form method="POST" action="?p=admin&sub=news&action=add" class="form label-inline">
				<h2><center><?php echo $lang['news_list']; ?></center></h2>
				<table>
					<tbody>
						<thead>
							<tr>
								<th width="40%"><center><?php echo $lang['news_title']; ?></center></th>
								<th width="30%"><center><?php echo $lang['posted_by']; ?></center></th>
								<th width="30%"><center><?php echo $lang['post_time']; ?></center></th>
							</tr>
						</thead>
						<?php
						if($gettopics != FALSE)
						{
							foreach($gettopics as $row) 
							{
								$date_n = date("Y-m-d, g:i a", $row['post_time']);
						?>
								<tr>
									<td align="center"><a href="?p=admin&sub=news&action=edit&id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></td>
									<td align="center"><?php echo $row['posted_by']; ?></td>
									<td align="center"><?php echo $date_n; ?></td>
								</tr>
						<?php } // END FOR EACH NEWS
						} // END IF ?>
					</tbody>
				</table>
				<div class="buttonrow-border">								
					<center><button><span><?php echo $lang['add_news']; ?></span></button></center>			
				</div>
			</form>
		</div>
<?php }
?>
	</div>
</div>