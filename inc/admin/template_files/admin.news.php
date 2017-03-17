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
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "style,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,|,insertdate,inserttime,preview,|,forecolor",
		theme_advanced_buttons3 : "hr,|,charmap,emotions,iespell,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
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
					addNews($_POST['subject'],$_POST['message'],$user['id']);
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
			if(isset($_POST['delete'])) 
			{
				delNews($_POST['id']);
			}
			elseif(isset($_POST['editmessage'])) 
			{
				editNews($_POST['id'],$_POST['editmessage']);
			}
		
			$content = $DB->selectRow("SELECT * FROM `mw_news` WHERE `id`='".$_GET['id']."'");

?>
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=news">News</a> / Edit News</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<form method="POST" class="form label-inline">
			<input type="hidden" name="task" value="editnews">
			<input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">			
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