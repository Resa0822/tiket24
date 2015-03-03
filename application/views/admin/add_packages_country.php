<?php echo form_open_multipart('packages_country/add_packages_country');?>
<div style="clear:both;"></div>
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
            <input id="country_iso" type="text" title="Enter Content of Country Iso." size="50" value="" name="country_iso" style="width:30%; height:auto;"></input>
		</td>
	</tr>
	<tr class="form-row">
        <td >Country Name	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="country_name" type="text" title="Enter Name of Country." size="50" value="" name="country_name" style="width:30%; height:auto;"></input>
		</td>
	</tr>
	<tr class="form-row">
		<td >Picture	: *<br /><span style="font-size:11px;">( 1024x768 Res. & 1Mb max. file size )</span>
        </td>
		<td class="field">
			<input id="Picture" type="file" multiple="multiple" title="Enter gambar of packages." size="50" value="" name="gambar" style="width:50%"></input>
		</td>
	</tr> 		
</table>
	<div class="button-container" style="float:right;"><input type="submit" name="Save" value="Save"/>&nbsp;<input type="reset" name="Cancel"/>&nbsp;<input type="button" onClick="history.go(-1)" value="Back" />&nbsp;</div>
</div>
</fieldset>
	<br><br>
<?php echo form_close(); ?>