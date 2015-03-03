<?php echo form_open_multipart('packages_city/add_packages_city');?>
<div style="clear:both;"></div>
<div id="hotel-content-info" class="stylebox">
<?php if($this->session->flashdata('flashMsge_warning')){ ?>
<div class="alert alert-alert fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert">
    	<span aria-hidden="true">&times;</span>
    </button>
	<img src="<?php echo base_url(); ?>asset/images/icon/error.png" /><span>&nbsp;&nbsp;<?php echo $this->session->flashdata('flashMsge_warning'); ?></span>
</div>
<?php } ?>
<h2>&nbsp; </h2>
<fieldset class="fieldset">
<legend class="legend">General Information</legend>
<table class="form">   
	<tr class="form-row">
		<td >Country	:	</td>
		<td class="field">
		<?php echo form_error('country_iso', '<div class="alert alert-warning" role="alert" style="padding:5px;font-size:12px;margin:0px;vertical-align:middle;"> ', '</div>'); ?>	
		<select id="country_id" title="Select Country" size="1" name="country_iso" style="width:30%">
		<?php
		$qry = $this->db->get_where('packages_country', array('country_iso !=' => ''));
		foreach($qry->result() as $row){
			$cntryCde = $row->country_iso;
			if($cntryCde == 'ID'){
				$slctd = 'selected="selected"';
			}
			else{
				$slctd = '';
			}
		?>		
			<option value="<?php echo $row->country_iso; ?>" <?php echo $slctd; ?> ><?php echo $row->country_name; ?></option>
		<?php } ?>	
		</select> 
		<!--
		<select id="country_id" title="Select Country" size="1" name="country_iso" style="width:30%">
			<option value="">Select Country</option>
			<?php foreach($ar_country as $row) : ?>
				<option value="<?php echo $row->country_iso3; ?>" <?php if($row->country_iso == "ID"){echo'selected="selected"';} ?>> <?php echo $row->country_name; ?></option>
			<?php endforeach; ?>
		</select> 
		-->
		</td>
	</tr>
	<tr class="form-row">
        <td >City Iso	:
            <span class="required">*</span>
        </td>
        <td class="field">
        	<?php echo form_error('city_iso', '<div class="alert alert-warning" role="alert" style="padding:5px;font-size:12px;margin:0px;vertical-align:middle;"> ', '</div>'); ?>
            <input id="city_iso" type="text" title="Enter Content of city Iso." size="50" value="" name="city_iso" style="width:30%; height:auto;"></input>
		</td>
	</tr>
	<tr class="form-row">
        <td >City Name	:
            <span class="required">*</span>
        </td>
        <td class="field">
        	<?php echo form_error('city_name', '<div class="alert alert-warning" role="alert" style="padding:5px;font-size:12px;margin:0px;vertical-align:middle;"> ', '</div>'); ?>
            <input id="city_name" type="text" title="Enter Name of city." size="50" value="" name="city_name" style="width:30%; height:auto;"></input>
		</td>
	</tr>
	<tr class="form-row">
		<td >Picture	: <br /><span style="font-size:11px;">*</span>
        </td>
		<td class="field">
			<?php echo form_error('gambar', '<div class="alert alert-warning" role="alert" style="padding:5px;font-size:12px;margin:0px;vertical-align:middle;"> ', '</div>'); ?>
			<input id="Picture" type="file" multiple="multiple" title="Enter gambar of packages." size="50" value="" name="gambar"></input>
		</td>
	</tr> 		
</table>
	<div class="button-container" style="float:right;"><input type="submit" name="Save" value="Save"/>&nbsp;<input type="reset" name="Cancel"/>&nbsp;<input type="button" onClick="history.go(-1)" value="Back" />&nbsp;</div>
</div>
</fieldset>
	<br><br>
<?php echo form_close(); ?>