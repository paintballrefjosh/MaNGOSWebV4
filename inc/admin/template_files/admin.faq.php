<?php
if(isset($_GET['id']))
{
?>
	<!-- EDITING LINK -->
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=faq">Faq's</a> / Edit</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<?php
				if(isset($_POST['action']))
				{
					if($_POST['action'] == 'edit')
					{
						if(isset($_POST['delete']))
						{
							deleteFaq();
						}
						else
						{
							editFaq();
						}
					}
				}
			?>
			<form method="POST" action="?p=admin&sub=faq&id=<?php echo $_GET['id']; ?>" class="form label-inline">
			<input type="hidden" name="action" value="edit">
			<?php
				$edit_info = $DB->selectRow("SELECT * FROM `mw_faq` WHERE `id`='".$_GET['id']."'");
			?>
			<div class="field">
				<label for="question"><?php echo $lang['question']; ?>: </label>
				<input id="question" name="question" size="20" type="text" class="large" value="<?php echo $edit_info['question']; ?>" />
				<p class="field_help">The <?php echo $lang['question']; ?></p>
			</div>
			
			<div class="field">
				<label for="faq"><?php echo $lang['answer']; ?>: </label>
				<input id="faq" name="answer" size="20" type="text" class="large" value="<?php echo $edit_info['answer']; ?>"  />
				<p class="field_help">The <?php echo $lang['answer']; ?></p>
			</div>
			
			<div class="buttonrow-border">								
				<center>
					<button><span><?php echo $lang['submit']; ?></span></button>
					<button class="btn-sec" name="delete"><span><?php echo $lang['delete']; ?></span></button>
				</center>			
			</div>
			
			</form>
		</div>
	</div>
<?php
}
elseif(isset($_GET['add']))
{
?>

<!-- ADDING LINK -->
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / <a href="?p=admin&sub=faq">Faq's</a> / ADD</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<form method="POST" action="?p=admin&sub=faq&add=true" class="form label-inline">
			<input type="hidden" name="action" value="addFaq">		
			<?php
				if(isset($_POST['action']))
				{
					if($_POST['action'] == 'addFaq')
					{
						addFaq();
					}
				}
			?>			
			<div class="field">
				<label for="question"><?php echo $lang['question']; ?>: </label>
				<input id="question" name="question" size="20" type="text" class="large" />
				<p class="field_help">The <?php echo $lang['question']; ?></p>
			</div>
			
			<div class="field">
				<label for="faq"><?php echo $lang['answer']; ?>: </label>
				<input id="faq" name="answer" size="20" type="text" class="large"  />
				<p class="field_help">The <?php echo $lang['answer']; ?></p>
			</div>
			
			<div class="buttonrow-border">								
				<center><button><span><?php echo $lang['add_new_faq']; ?></span></button></center>			
			</div>
			
			</form>
		</div>
	</div>

<?php
}
else # No ID Set
{
?>
	<!-- List of FAQ -->
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / Faq's</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">
			<form method="POST" action="?p=admin&sub=faq&add=true" class="form label-inline">
				<h5><center><?php echo $lang['list_of_faq']; ?></center></h5><br />
				<table>
					<thead>
						<th><center><b><?php echo $lang['question']; ?></center></b></th>
						<th><center><b><?php echo $lang['answer']; ?></center></b></th>
					</thead>
				<?php
					if($get_faq != FALSE)
					{
						foreach($get_faq as $faq)
						{
							echo "
								<tr>
									<td width='40%' align='center'><a href='?p=admin&sub=faq&id=".$faq['id']."'>".$faq['question']."</a></td>
									<td width='60%' align='center'>".$faq['answer']."</td>
								</tr>
							";
						}
					}
				?>
				</table>
			<br />
			<div class="buttonrow-border">								
				<center><button><span><?php echo $lang['add_new_faq']; ?></span></button></center>			
			</div>
			</form>
		</div>
	</div>
<?php
} ?>