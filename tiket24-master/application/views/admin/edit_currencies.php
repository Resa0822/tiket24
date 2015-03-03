<?php echo form_open_multipart('currencies/edit/'.$isi->id);?>
<div style="clear:both;"></div>
<div id="hotel-content-info" class="stylebox">
<h2>&nbsp; </h2>
<fieldset class="fieldset">
<legend class="legend">General Information</legend>
<table class="form">     
	<tr class="form-row">
		<td > Country	:	</td>
		<td class="field">
		<select id="country_id" title="Select Country" size="1" name="country_iso_from" style="width:30%">
			<option value="">Select Country</option>
			<?php 
			foreach($ar_country as $row){ 
			if($row->country_iso == $isi->country_iso_from){
				$html = 'selected="selected"';
			}
			else{
				$html = '';
			}
			?>
			<option value="<?php echo $row->country_iso; ?>" <?php echo $html; ?> > <?php echo $row->country_name; ?></option>
			<?php } ?>
		</select> 
		</td>
	</tr>
	<tr class="form-row">
        <td > Currency Iso	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="currencies_iso" type="text" title="Enter Content of currencies Iso." size="50" value="<?php echo $isi->currency_from; ?>" name="currency_from" style="width:30%; height:auto;"></input>
		</td>
	</tr>   
<!--	<tr class="form-row">
		<td >To Country	:	</td>
		<td class="field">
		<select id="country_id" title="Select Country" size="1" name="country_iso_to" style="width:30%">
			<option value="">Select Country</option>
			<?php 
			/* foreach($ar_country as $row){ 
			if($row->country_iso == $isi->country_iso_from){
				$html = 'selected="selected"';
			}
			else{
				$html = '';
			} */
			?>
			<option value="<?php //echo $row->country_iso; ?>" <?php //echo $html; ?> > <?php echo //$row->country_name; ?></option>
			<?php } ?>
		</select> 
		</td>
	</tr>
	<tr class="form-row">
        <td >To Currency Iso	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="currencies_iso" type="text" title="Enter Content of currencies Iso." size="50" value="<?php echo $isi->currency_from; ?>" name="currency_to" style="width:30%; height:auto;"></input>
		</td>
	</tr> -->
	<tr class="form-row">
        <td >Conversion 	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="currencies_iso" type="text" title="Enter Content of conversion Iso." size="50" value="<?php echo $isi->konversi; ?>" name="conversion" style="width:30%; height:auto;"></input>
		</td>
	</tr>	
</table>
	<div class="button-container" style="float:right;"><input type="submit" name="Save" value="Save"/>&nbsp;<input type="reset" name="Cancel" value="Retur to API"/>&nbsp;<input type="button" onClick="history.go(-1)" value="Back" />&nbsp;</div>
</div>
</fieldset>
	<br><br>
<?php echo form_close(); ?>