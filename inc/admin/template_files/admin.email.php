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

<div class="content">	
	<div class="content-header">
		<h4><a href="?p=admin">Main Menu</a> / Send Email</h4>
	</div> <!-- .content-header -->				
	<div class="main-content">	
	<?php 
		if(isset($_POST['send_email'])) 
		{
			send_email($_POST['reciever'], $_POST['subject'], $_POST['message']);
		}
	?>			
		<form method="POST" action="?p=admin&sub=email" class="form label-inline">
		<input type="hidden" name="send_email">
		
			<table>
				<thead>
					<tr>
						<th><center><?php echo $lang['send_email']; ?></center></th>
					</tr>
				</thead>
			</table>
			<br />
			
			<div class="field">
				<label for="Subject"><?php echo $lang['send_to']; ?>: </label>
				<input id="Subject" name="reciever" size="20" type="text" class="medium" />
				<p class="field_help"><?php echo $lang['send_to_desc']; ?></p>
			</div>
			
			<div class="field">
				<label for="Subject"><?php echo $lang['subject']; ?>: </label>
				<input id="Subject" name="subject" size="20" type="text" class="medium" />
				<p class="field_help"><?php echo $lang['subject_desc']; ?></p>
			</div>
			
			<div class="field">
				<textarea id="Message" name="message" rows="15" cols="78" class="inputbox"></textarea>
			</div>
			<br />		
			<div class="buttonrow-border">								
				<center><button><span><?php echo $lang['send_email']; ?></span></button></center>			
			</div>
		</form>
	</div>
</div>