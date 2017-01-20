<img src='<?php echo $Template['path']; ?>/images/banner-cc.jpg' border="0" width="659" />
<?php 
builddiv_start();

// First check to see if the admin has the module enabled.
if($Config->get('module_charcustomize') == 1)
{
?>
<table width = "550" align='center'>
	<tr>
		<td>
			<?php
			write_subheader($lang['char_recustomize']);
			?>
			<table width = "550" style = "border-width: 1px; border-style: dotted; border-color: #928058;">
				<tr>
					<td>
						<table width='545' style="border-width: 1px; border-style: solid; border-color: black; background-image: url('<?php echo $Template['path']; ?>/images/light3.jpg');">
						<tr>
							<td>
								<form method='POST' action='<?php echo mw_url('account', 'customize'); ?>'>
								<table border='0' cellspacing='0' cellpadding='4' width='540'>
								<?php
									if(isset($_POST['id']))
									{
										if($_POST['id'] != 0)
										{
											reCustomize();
										}
										else
										{
											output_message('error', $lang['account_has_no_characters']);
										}
									}
									if($Config->get('module_charcustomize') == 0)
									{
										output_message('error', $lang['disabled']);
										echo "<br />";
									}
									else
									{
								?>
										<tr>
											<td colspan='2'><?php echo add_pictureletter($PAGE_DESC); ?><br /></td>
										</tr>
										<tr>
											<td align='right' valign = "top" width='50%'><b>Character: </b></td>
											<td align='left' valign = "top" width='50%'>
												<select name='id'>
													<?php
														if($character_list == FALSE)
														{
															echo "<option value='0'>No Characters Found!</option>";
														}
														else
														{
															foreach($character_list as $character)
															{
																echo "<option value='".$character['guid']."'>".$character['name']."</option>";
															}
														}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan='2' align='center'>
												<br />
												<input type="image" src="<?php echo $Template['path']; ?>/images/buttons/continue-button.gif" class="button" style="font-size:12px;" value="<?php echo $lang['change'];?>">
											</td>
										</tr>
								<?php 
									}
								?>
								</table>
								</form>
							</td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php
}
else
{
	output_message('info' , $lang['disabled']);
}
builddiv_end(); 
?>
