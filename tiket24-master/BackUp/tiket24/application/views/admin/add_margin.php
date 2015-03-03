<?php echo form_open_multipart('margin/add_margin');?>
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
		<select id="role_id" title="Select Role"  size="1" name="role_id" style="width:30%">
			<option value="">Select Role</option>
			<?php foreach($ar_role as $row) : ?>
				<option value="<?php echo $row->role_id; ?>" > <?php echo $row->role; ?></option>
			<?php endforeach; ?>
		</select> 
		</td>
	</tr>
	<tr class="form-row">
        <td >Margin(%)	:</td>
        <td class="field">
            <input id="margin_pr" type="text" maxlength="3" title="Enter Margin of Country." size="50" value="" name="margin_pr" style="width:30%; height:30%;"></input>
		</td>
	</tr>
	<tr class="form-row">
        <td >Margin(Rp)	:</td>
        <td class="field">
            <input id="margin_rp" type="text" title="Enter Margin of Country." size="50" value="" name="margin_rp" style="width:30%; height:30%;"></input>
		</td>
	</tr>	
<!--	<tr class="form-row">
        <td >Currencies:
            <span class="required">*</span>
        </td>
        <td class="field"><select name="currency" style="width:20%; height:30%;" >
			<?php foreach($ar_currencies as $row) : ?>
				<option value="<?php echo $row->currency; ?>"> <?php echo $row->currency; ?></option>
			<?php endforeach; ?>
	</tr>  -->
</table>
	<div class="button-container" style="float:right;"><input type="submit" name="Save" value="Save"/>&nbsp;<input type="reset" name="Cancel"/>&nbsp;<input type="button" onClick="history.go(-1)" value="Back" />&nbsp;</div>
</div>
</fieldset>
	<br><br>
<?php echo form_close(); ?>