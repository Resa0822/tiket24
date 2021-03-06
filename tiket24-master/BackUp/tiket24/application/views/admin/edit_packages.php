<?php echo form_open_multipart('packages/edit');?>
<div id="hotel-content-info" class="stylebox">
<h2>&nbsp;</h2>
	<script type="text/javascript" src="<?php echo base_url(); ?>editor/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>editor/ckeditor/adapters/jquery.js"></script>
	<script type="text/javascript">
	//<![CDATA[

$(function()
{
	var config = {
	/*   filebrowserBrowseUrl : '<?php echo base_url(); ?>editor/kcfinder/browse.php?type=files',
	   filebrowserImageBrowseUrl : '<?php echo base_url(); ?>editor/kcfinder/browse.php?type=images',
	   filebrowserFlashBrowseUrl : '<?php echo base_url(); ?>editor/kcfinder/browse.php?type=flash',
	   filebrowserUploadUrl : '<?php echo base_url(); ?>editor/kcfinder/upload.php?type=files',
	   filebrowserImageUploadUrl : '<?php echo base_url(); ?>editor/kcfinder/upload.php?type=images',
	   filebrowserFlashUploadUrl : '<?php echo base_url(); ?>editor/kcfinder/upload.php?type=flash'
	 */ 
	 }

	// Initialize the editor.
	// Callback function can be passed and executed after full instance creation.
	$('.ket').ckeditor(config.toolbarGroups);

});
	//]]>
	</script>
	<script>
		$(function() {
		$( "#begin" ).datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
		$( "#end" ).datepicker( "option", "minDate", selectedDate );
		}
		});
		$( "#end" ).datepicker({
		dateFormat: "yy-mm-dd",
		appendText: "(yyyy-mm-dd)",
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
		$( "#begin" ).datepicker( "option", "maxDate", selectedDate );
		}
		});
		});
	</script>
 <script type="text/javascript">// <![CDATA[
 $(document).ready(function(){
 $('#country').change(function(){ //any select change on the dropdown with id country trigger this code
 $("#cities > option").remove(); //first of all clear select items
 var country_id = $('#country').val(); // here we are taking country id of the selected one.
 $.ajax({
 type: "POST",
 url: "<?php echo base_url();?>index.php/packages/cities/"+country_id, //here we are calling our user controller and get_cities method with the country_id
 
 success: function(cities) //we're calling the response json array 'cities'
 {
 $.each(cities,function(id,city) //here we're doing a foeach loop round each city with id as the key and city as the value
 {
 var opt = $('<option />'); // here we're creating a new select option with for each city
 opt.val(id);
 opt.text(city);
 $('#cities').append(opt); //here we will append these new select options to a dropdown with the id 'cities'
 });
 }
 
 });
 
 });
 });
 // ]]>
</script>
<fieldset class="fieldset">
<legend class="legend">General Information</legend>
<table class="form">
    <input id="kode_packages" type="hidden" title="Enter Name of packages." size="50" value="<?php echo $isi->kode; ?>" name="kode"></input>
		<tr class="form-row">
		<td >Country	:	</td>
		<?php //var_dump($ar_countries);
		//echo $ar_countries[$isi->country].'<br/>'.$isi->country;
		if(!empty($ar_countries[$isi->country])) {
		$ar_countries['#'] = $ar_countries[$isi->country]; }
		else{
		$ar_countries['#'] = 'Please Select';
		}
		?>
		<td class="field">
			<?php echo form_dropdown('country', $ar_countries, '#', 'id="country"'); ?>
<!--		<select id="country_id" title="Select Country" size="1" name="negara" style="width:50%">
			<option value="">Select Country</option>
			<?php// foreach($ar_country as $row) : ?>
				<option value="<?php// echo $row->country_iso; ?>" <?php// if($row->country_iso == "ID"){echo'selected="selected"';} ?>> <?php// echo $row->country_name; ?></option>
			<?php// endforeach; ?>
		</select> -->
		</td>
	</tr>
	<tr class="form-row">
		<td >City	: 	</td>
		 <?php // $cities['#'] = $isi->city; ?>
		 <?php //var_dump($ar_cities);
		 //echo $ar_cities->city_iso.'<br/>'.$isi->city;
		 if(!empty($ar_cities[$isi->city])) {
		 $ar_cities['#'] = $ar_cities[$isi->city]; }
		 else{
	 	 $ar_cities['#'] = 'Please Select';
	 	 }?>
		<td class="field">
			<?php echo form_dropdown('city', $ar_cities, '#', 'id="cities"'); ?>
<!--		<select id="city_id" title="Select an Area of City under an available country" size="1" name="city" style="width:50%">
			<option value="">Select City</option>
			<?php //foreach($ar_city as $row) : ?>
				<option value="<?php// echo $row->city_iso; ?>" class="<?php// echo $row->country_iso; ?>"> <?php// echo $row->city_name; ?></option>
			<?php// endforeach; ?>		
		</select> -->
		</td>
<!--		
	<tr class="form-row">
		<td>Country	:	</td>
		<td class="field">
		<select id="country" class="country_id" title="Select Country" size="1" name="negara" style="width:50%">
			<?php foreach($ar_country as $row) : ?>
				<option value="<?php echo $row->country_iso; ?>" <?php if($row->country_iso == $isi->country){echo'selected="selected"';} ?>> <?php echo $row->country_name; ?></option>
			<?php endforeach; ?>
		</select>
		</td>
	</tr>
	<tr class="form-row">
		<td>City	: 	</td>
		<td class="field">
		<select id="cities" class="area_id" title="Select an Area of City under an available country" size="1" name="city" style="width:50%">
			<option value="<?php echo $row->city_iso; ?>" <?php if($row->city_iso == $isi->city){echo'selected="selected"';} ?>><?php echo $row->city_name; ?></option>
		</select>
		</td>
	</tr> 
-->
	<tr class="form-row">
		<td>Picture	: 
        </td>
		<td class="field">
			<input id="Picture" type="file" multiple="multiple" title="Enter gambar of packages." size="50" value="" name="gambar" style="width:50%"></input>
			<input id="Picture" type="hidden" multiple="multiple" title="Enter gambar of packages." size="50" value="<?php echo $isi->gambar; ?>" name="gambar_lama" style="width:50%"></input>
		</td>
	</tr>   
	<tr class="form-row">
        <td>Package Name	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="nama_packages" type="text" title="Enter Name of packages." size="50" value="<?php echo $isi->nama; ?>" name="nama" style="width:50%;height:auto;"></input>
		</td>
	</tr>
	<tr class="form-row">
        <td>Package	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="packages" type="text" title="Enter Content of packages." size="50" value="<?php echo $isi->package; ?>" name="package" style="width:50%; height:auto;"></input>
		</td>
	</tr>
	<tr class="form-row"> 
	    <td><?php echo form_label('Inclusive:', 'contents'); ?></td>
		<td class="field">
	    	<?php
			$data = array(
			              'name'        => 'ket',
			              'id'          => 'ket',
			              'value'       => set_value('ket',$isi->ket),
			              'cols'   		=> '30',
			              'rows'        => '3',
			              'class'		=> 'ket',
			            );
			?>    	
			<?php echo form_textarea($data); ?>
		</td>
	</tr>
	<tr class="form-row">
		<td >Periode Travel	: 
			<span class="required">*</span>
		</td>
		<td class="field">
			<input type="text" placeholder="Pickup Date" class="datepicker" id="from" font_end_label="Details" title="Enter a News." rows="15" cols="60" value="<?php echo $isi->periode_begin; ?>" name="periode_begin" style="width: 30%;height:auto;" />
			s/d
			<input type="text" placeholder="Pickup Date" class="datepicker" id="to" font_end_label="Details" title="Enter a News." rows="15" cols="60" value="<?php echo $isi->periode_end; ?>" name="periode_end" style="width: 30%;height:auto;" />
		</td>
	</tr>
	<tr class="form-row">
		<td >Booking Begin	: 
			<span class="required">*</span>
		</td>
		<td class="field">
			<input type="text" placeholder="Pickup Date" class="datepicker" id="begin" font_end_label="Details" title="Enter a News." rows="15" cols="60" value="<?php echo $isi->booking_begin; ?>" name="booking_begin" style="width: 30%;height:auto;" />
			s/d
			<input type="text" placeholder="Pickup Date" class="datepicker" id="end" font_end_label="Details" title="Enter a News." rows="15" cols="60" value="<?php echo $isi->booking_end; ?>" name="booking_end" style="width: 30%;height:auto;"/>
		</td>
	</tr>
	<tr class="form-row">
        <td>Currencies:
            <span class="required">*</span>
        </td>
        <td class="field"><select name="Currency" style="width:20%; height:auto;">
			<?php foreach($ar_currencies as $row) : ?>
				<option value="<?php echo $row->currency; ?>" <?php if($row->currency == $isi->currency){echo'selected="selected"';} ?>> <?php echo $row->currency; ?></option>
			<?php endforeach; ?>
		</select></td>
	</tr>
	<tr class="form-row">
        <td>Adult's Price	:
            <span class="required">*</span>
        </td>
        <td class="field">
			<input type="text" id="Price_Name" font_end_label="Details" title="Enter a News." rows="8" cols="60" value="<?php echo $isi->price_adult; ?>" name="price_adult" dir="rtl" style="width:30%; height:auto;"/>
		</td>
	</tr>
	<tr class="form-row">
        <td>Child's Price	:
            <span class="required">*</span>
        </td>
        <td class="field">
			<input type="text" id="Price_Name" font_end_label="Details" title="Enter a News." rows="8" cols="60" value="<?php echo $isi->price_child; ?>" name="price_child" dir="rtl" style="width:30%; height:auto;"/>
		</td>
	</tr>
	<tr class="form-row">
    <td>Discount(%)	:
        </td>
        <td class="field">
			<input type="text" id="Price_Name" font_end_label="Details" title="Enter a News." rows="8" cols="60" value="<?php echo $isi->discount; ?>" name="discount" style="width:50%; height:auto;"/>
		</td>
	</tr>
	<tr class="form-row">
		<td >Margin	:
        </td>
        <td class="field">
			<input type="text" id="Margin_pr" font_end_label="Details" title="Enter a News." rows="8" cols="60" value="<?php echo $isi->margin_pr; ?>" name="margin_pr" style="width:20%; height:auto;"/>
			% &nbsp;&nbsp; | &nbsp;&nbsp; Rp.
			<input type="text" id="Margin_rp" font_end_label="Details" title="Enter a News." rows="8" cols="60" value="<?php echo $isi->margin_rp; ?>" name="margin_rp" style="width:20%; height:auto;"/>
		</td>
	</tr>
	<tr class="form-row">
		<td>Description	: </td>
		<td class="field">
			<textarea id="packages_desc" font_end_label="Details" title="Enter a Details desctiption of Auto." rows="10" cols="60" value="<?php echo $isi->desc; ?>" name="desc" style="width:80%; height:auto;"><?php echo $isi->desc; ?></textarea>
		</td>
	</tr>
</table>
	<div class="button-container" style="float:right;"><input type="submit" name="Save" value="Save"/>&nbsp;<input type="reset" name="Cancel"/>&nbsp;<input type="button" onClick="history.go(-1)" value="Back" />&nbsp;</div>
</div>
</fieldset>
	<br><br>
<?php echo form_close(); ?>