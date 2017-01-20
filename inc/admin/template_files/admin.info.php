<div class="content">
	<br />
	<table>
		<thead>
			<th colspan="2"><center>Core Details</center></th>
		</thead>
		<tr>
			<td width="50%" align="right" valign="middle" class="form-text">MangosWeb Core Version:</td>
			<td width="50%" align="left" valign="middle" class="form-text"><?php echo $Core->version; ?></td>
		</tr>
		<tr>
			<td width="50%" align="right" valign="middle" class="form-text">Core Version Release Date:</td>
			<td width="50%" align="left" valign="middle" class="form-text"><?php echo $Core->version_date; ?></td>
		</tr>
		<tr>
			<td width="50%" align="right" valign="middle" class="form-text">Core Expected Database Version:</td>
			<td width="50%" align="left" valign="middle" class="form-text"><?php echo $Core->exp_dbversion; ?></td>
		</tr>
		<tr>
			<td width="50%" align="right" valign="middle" class="form-text">MangosWeb Database Version:</td>
			<td width="50%" align="left" valign="middle" class="form-text"><?php echo $db_act_ver; ?></td>
		</tr>
		<tr>
			<td width="50%" align="right" valign="middle" class="form-text">Database Version Release Date:</td>
			<td width="50%" align="left" valign="middle" class="form-text"><?php echo $db_date; ?></td>
		</tr>
	</table>
	<br />
	<table>
		<thead>
			<th colspan="2"><center>SDL Details</center></th>
		</thead>
		<tr>
			<td width="50%" align="right" valign="middle" class="form-text">SDL Version:</td>
			<td width="50%" align="left" valign="middle" class="form-text"><?php echo $Lib->version; ?></td>
		</tr>
		<tr>
			<td width="50%" align="right" valign="middle" class="form-text">SDL Revision:</td>
			<td width="50%" align="left" valign="middle" class="form-text"><?php echo $Lib->revision; ?></td>
		</tr>
		<tr>
			<td width="50%" align="right" valign="middle" class="form-text">SDL Core Support:</td>
			<td width="50%" align="left" valign="middle" class="form-text"><?php echo $Lib->core; ?></td>
		</tr>
		<tr>
			<td width="50%" align="right" valign="middle" class="form-text">SDL Revision Date:</td>
			<td width="50%" align="left" valign="middle" class="form-text"><?php echo $Lib->revisionDate; ?></td>
		</tr>
	</table>
	<br /><br />
</div>