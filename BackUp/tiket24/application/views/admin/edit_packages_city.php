<?php echo form_open_multipart('packages_city/edit/'.$isi->idy);?>
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
				<option value="<?php echo $row->country_iso; ?>" <?php if($row->country_iso == $isi->country_iso){echo'selected="selected"';} ?>> <?php echo $row->country_name; ?></option>
			<?php endforeach; ?>
		</select> 
		</td>
	</tr>
	<tr class="form-row">
        <td >City Iso	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="city_iso" type="text" title="Enter Content of city Iso." size="50" value="<?php echo $isi->city_iso; ?>" name="city_iso" style="width:30%; height:auto;"></input>
		</td>
	</tr>
	<tr class="form-row">
        <td >City Name	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="city_name" type="text" title="Enter Name of city." size="50" value="<?php echo $isi->city_name; ?>" name="city_name" style="width:30%; height:auto;"></input>
		</td>
	</tr>
	<tr class="form-row">
		<td>Picture	: 
        </td>
		<td class="field">
			<input id="Picture" type="file" multiple="multiple" title="Enter gambar of packages." size="50" value="" name="gambar" style="width:50%"></input>
			<input id="Picture" type="hidden" multiple="multiple" title="Enter gambar of packages." size="50" value="<?php echo $isi->gambar; ?>" name="gambar_lama" style="width:50%"></input>
		</td>
	</tr>		
</table>
	<div class="button-container" style="float:right;"><input type="submit" name="Save" value="Save"/>&nbsp;<input type="reset" name="Cancel"/>&nbsp;<input type="button" onClick="history.go(-1)" value="Back" />&nbsp;</div>
</div>
</fieldset>
	<br><br>
<?php echo form_close(); ?>