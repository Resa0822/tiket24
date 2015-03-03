<?php echo form_open_multipart('packages_country/edit/'.$isi->idx);?>
<div id="hotel-content-info" class="stylebox">
<h2>&nbsp; </h2>
<fieldset class="fieldset">
<legend class="legend">General Information</legend>
<table class="form">   
	<tr class="form-row">
        <td >Country Iso	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="country_iso" type="text" title="Enter Content of Country Iso." size="50" value="<?php echo $isi->country_iso; ?>" name="country_iso" style="width:30%; height:auto;"></input>
		</td>
	</tr>
	<tr class="form-row">
        <td >Country Name	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="country_name" type="text" title="Enter Name of Country." size="50" value="<?php echo $isi->country_name; ?>" name="country_name" style="width:30%; height:auto;"></input>
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