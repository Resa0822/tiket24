<?php echo form_open_multipart('margin/edit/'.$isi->mid);?>
<div style="clear:both;"></div>
<div id="hotel-content-info" class="stylebox">
<h2>&nbsp; </h2>
<fieldset class="fieldset">
<legend class="legend">General Information</legend>
<table class="form">   
	<tr class="form-row">
        <td >Role	:
            <span class="required">*</span>
        </td>
        <td class="field">
	<!--	<select id="role_id" title="Select Role"  size="1" name="role_id" style="width:30%">
			<option value="">Select Role</option>
			<?php foreach($ar_role as $row) : ?>
				<option value="<?php echo $row->role_id; ?>" <?php if($row->role_id=$isi->role_id){ echo"selected = selected"; } ?> > <?php echo $row->role; ?></option>
			<?php endforeach; ?>
		</select> -->
			<?php 
			$qry= mysql_query("select role from roles where role_id = '$isi->role_id' ");
			if($qry === FALSE) { 
				die(mysql_error()); // TODO: better error handling
			}
		//	$query = mysql_fetch_array($qry);
			while ($row = mysql_fetch_array($qry)){
		//	while($row = mysql_result($query)) { ?>
				<input id="role_id" type="text" readonly title="Enter Content of Role." size="50" value="<?php echo $row[0];?>" name="role_id" style="width:30%; height:auto;"><?php //$isi->role_id; ?></input> 
			<?php } ?>
		</td>
	</tr>
	<tr class="form-row">
        <td >Margin(%)	:</td>
        <td class="field">
            <input id="margin_pr" type="text" title="Enter Margin of Country." size="50" value="<?php echo $isi->margin_pr; ?>" name="margin_pr" style="width:30%; height:auto;"></input>
		</td>
	</tr>
	<tr class="form-row">
        <td >Margin(Rp)	:</td>
        <td class="field">
            <input id="margin_rp" type="text" title="Enter Margin of Country." size="50" value="<?php echo $isi->margin_rp; ?>" name="margin_rp" style="width:30%; height:auto;"></input>
		</td>
	</tr>	
<!--	<tr class="form-row">
        <td>Currencies:
            <span class="required">*</span>
        </td>
        <td class="field"><select name="currency" style="width:20%; height:auto;">
			<?php foreach($ar_currencies as $row) : ?>
				<option value="<?php echo $row->currency_from; ?>" <?php if($row->currency_from == $isi->currency){echo'selected="selected"';} ?>> <?php echo $row->currency_from; ?></option>
			<?php endforeach; ?>
		</select></td>
	</tr> -->
</table>
	<div class="button-container" style="float:right;"><input type="submit" name="Save" value="Save"/>&nbsp;<input type="reset" name="Cancel"/>&nbsp;<input type="button" onClick="history.go(-1)" value="Back" />&nbsp;</div>
</div>
</fieldset>
	<br><br>
<?php echo form_close(); ?>