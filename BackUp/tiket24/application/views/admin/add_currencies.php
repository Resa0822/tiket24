<?php echo form_open_multipart('currencies/add_currencies');?>
<div id="hotel-content-info" class="stylebox">
<h2>&nbsp; </h2>
<fieldset class="fieldset">
<legend class="legend">General Information</legend>
<table class="form">   
		<tr class="form-row">
		<td >Country	:	</td>
		<td class="field">
		<select id="country_id" title="Select Country" size="1" name="country_iso" style="width:30%">
			<option value="">Select Country</option>
			<?php foreach($ar_country as $row) : ?>
				<option value="<?php echo $row->country_iso; ?>" <?php if($row->country_iso == "ID"){echo'selected="selected"';} ?>> <?php echo $row->country_name; ?></option>
			<?php endforeach; ?>
		</select> 
		</td>
	</tr>
	<tr class="form-row">
        <td >Currencies Iso	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="currencies_iso" type="text" title="Enter Content of currencies Iso." size="50" value="" name="currencies_iso" style="width:30%; height:auto;"></input>
		</td>
	</tr>	   
	<tr class="form-row">
        <td >Conversion 	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="currencies_iso" type="text" title="Enter Content of conversion Iso." size="50" value="" name="conversion" style="width:30%; height:auto;"></input>
		</td>
	</tr>
</table>
	<div class="button-container" style="float:right;"><input type="submit" name="Save" value="Save"/>&nbsp;<input type="reset" name="Cancel"/>&nbsp;<input type="button" onClick="history.go(-1)" value="Back" />&nbsp;</div>
</div>
</fieldset>
	<br><br>
<?php echo form_close(); ?>