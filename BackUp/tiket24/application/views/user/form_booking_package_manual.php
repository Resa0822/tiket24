
<?php 
/*
 $bkngUsid = $this->session->userdata('bookingUSID');
 $bkngPid = $this->session->userdata('bookingPID');
 */
 
 $bkngID = $this->session->userdata('bookingID');
 

/*
$uriUsid = $this->uri->uri_to_assoc(3);
$bkngUsid = $uriUsid['sid']; 
$uriPid = $this->uri->uri_to_assoc(5);
$bkngPid = $uriPid['pid']; 
*/
$qry = mysql_query("SELECT * FROM book_packages WHERE transaction_code='$bkngID' ");
$field = mysql_fetch_array($qry);
$bkngPid = $field['API_packages_id'];
$totAdult = $field['adult'];
$totChild = $field['child'];
$qry = $this->db->query("select * from tours where API_packages_id='$bkngPid' ");
foreach($qry->result() as $row ){ 
	$childAgeFrom = $row->child_age_from;
	$childAgeTo = $row->child_age_to;
}
$currentYear = date("Y");
$pssprtExpryYear = $currentYear + 6;
?>
<style>
.search_package .h2 {
	background: #1e5799; /* Old browsers */
	background: -moz-linear-gradient(top, #1e5799 0%, #2989d8 50%, #207cca 51%, #7db9e8 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#1e5799), color-stop(50%,#2989d8), color-stop(51%,#207cca), color-stop(100%,#7db9e8)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* IE10+ */
	background: linear-gradient(to bottom, #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e5799', endColorstr='#7db9e8',GradientType=0 ); /* IE6-9 */
	
}
.search_package h2{
	margin: 10px;
}
</style>
<!--<script src="<?php echo base_url(); ?>asset/js/jquery-1.10.2.js"></script>-->
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script type="text/javascript">
 
$(document).ready(function(){
    $('#txtDobTL').datepicker({
    onSelect: function(value, ui) {
        var todayAdult = new Date(),
            dobAdult = new Date(value),
            ageAdult = new Date(todayAdult - dobAdult).getFullYear() - 1969;

        $('#txtAgeTL').val(ageAdult);
    },
    maxDate: '+0d',
    yearRange: '1940:<?php echo $currentYear; ?>',
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd'
	});
	
    $( ".dateOfBirth" ).datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: "1940:2014"
	});
	$( ".cardexpiry" ).datepicker({
		dateFormat: 'yy-mm',
		changeMonth: true,
		changeYear: true,
		yearRange: "2014:2019"
	});
	$( ".passportexpiry" ).datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: "<?php echo $currentYear; ?>:<?php echo $pssprtExpryYear; ?>"
	});
	$( ".datepicker" ).datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: "2014:2020"
	});
	
	
	$('#creditCard').click(function(){
		$('#cardInfo').show("fold", 1000);
		$('#bcaAccInfo').hide("fold", 1000);
		$('#bniAccInfo').hide("fold", 1000);
		
	});
	$('#transferBCA').click(function(){
		$('#cardInfo').hide("fold", 1000);
		$('#bcaAccInfo').show("fold", 1000);
		$('#bniAccInfo').hide("fold", 1000);
	});
	$('#transferBNI').click(function(){
		$('#cardInfo').hide("fold", 1000);
		$('#bcaAccInfo').hide("fold", 1000);
		$('#bniAccInfo').show("fold", 1000);
	});
	
	/* ajax country city start */
		
	$('#txtCntryCodeTravCntc').change(function() {
	var cntryCode = $("#txtCntryCodeTravCntc").find(":selected").val();	
	$.ajax({   
	           url: "<?=base_url()?>index.php/ajaxHandler/countryLoadCity", 
	           async: false,
	           type: "POST", 
	           data: {"cntryCode": cntryCode}, 
	           dataType: "html", 
	           beforeSend: function () {
				 
	                       $('#city_loader').show();
							$('#city_loader').fadeIn(400).html('<img src="<?=base_url()?>asset/images/icon/ajax-loader.gif" style="display: block; margin-left: auto; margin-right: auto;width:30px" /> Please wait...');
		
	                        },
	                      
	          success: function(data) {
	                        $('#city_loader').hide();
	                        $('#txtCityCodeTravCntc').html(data);  
							//$('#txtCityCodeTravCntc').append(data);  
								
	                    }
	     })
		 
	});
	
	
	
	
	
});
</script>
<div class="search_package">

<h2>&nbsp;  </h2>
	<div id="hotel-content-description"  style="text-align:center;border:10px solid #25497d; margin:auto; padding:35px 35px 35px 35px; border-radius:15px 15px 15px 15px;margin-top: 40%;">
<!-- ======================================================== -->
<form action="<?php echo base_url();?>index.php/booking/userGuestBooking" method="post" />
<!-- =============traveler leader start==================== -->
<table border="0" style="width:100%;">
	<input type="hidden" name="trvlrTypeTL" value="32">
	
	<tr>
		<td colspan="2" style="background:#4682B4"><h2>Traveler Leader</h2></td>
	</tr>
	<tr>
	<td width="200">Salutation</td>
	<td><select name="salutationTL" name="salutationTL"   style="width:100px" >
	<option value="">&lt;Choose&gt;</option>
	<option value="Mr">Mr</option>
	<option value="Mrs">Mrs</option>
	<option value="Mdm">Mdm</option>
	<option value="Mdm">Mdm</option>
	<option value="Miss">Miss</option>
	<option value="Dr">Dr</option>
	</select></td>
	</tr>
	<tr>
	<td>First Name</td>
	<td><?php echo form_error('txtFirstNameTL', '<div style="color:red">', '</div>'); ?><input type="text" name="txtFirstNameTL" name="txtFirstNameTL"  /></td>
	</tr>
	<tr>
	<td>Last Name</td>
	<td><?php echo form_error('txtLastNameTL', '<div style="color:red">', '</div>'); ?><input type="text" name="txtLastNameTL" name="txtLastNameTL" /></td>
	</tr>
	<tr>
	<td>Day Of Birth</td>
	<td><?php echo form_error('txtDobTL', '<div style="color:red">', '</div>'); ?><input type="text" id="txtDobTL" name="txtDobTL"   /></td>
	</tr>
	<tr>
	<td>Age</td>
	<td><?php echo form_error('txtAgeTL', '<div style="color:red">', '</div>'); ?><input type="text" id="txtAgeTL" name="txtAgeTL" readonly="readonly" style="width:50px;" maxlength="2" /> Years Old</td>
	</tr>
	<tr>
	<td>Passport Number</td>
	<td><?php echo form_error('txtPssprtNmbrTL', '<div style="color:red">', '</div>'); ?><input type="text" name="txtPssprtNmbrTL" id="txtPssprtNmbrTL" /></td>
	</tr>
	
	<tr>
	<td>Passport Expiry Date</td>
	<td><?php echo form_error('txtPssprtExpryDteTL', '<div style="color:red">', '</div>'); ?><input type="text" name="txtPssprtExpryDteTL" id="txtPssprtExpryDteTL" class="passportexpiry" /></td>
	</tr>
	<tr>
	<td>Passport Issuance Country</td>
	<td><?php echo form_error('txtPssprtIssuanceCntryTL', '<div style="color:red">', '</div>'); ?>
		<select name="txtPssprtIssuanceCntryTL" id="txtPssprtIssuanceCntryTL" >
		<option value="">&lt;Choose Country&gt;</option>
		<?php
		$qryIssncCntryTL = mysql_query("SELECT * FROM country");
		while($pssprtIssCntryFldTL=mysql_fetch_array($qryIssncCntryTL)){
			if($pssprtIssCntryFldTL['country_iso'] == 'ID'){
				$slctdOptCntryTL = 'selected = "selected"';
			}else{
				$slctdOptCntryTL = '';
			}
		?>
		<option value="<?php echo $pssprtIssCntryFldTL['country_iso']; ?>" ><?php echo $pssprtIssCntryFldTL['country_name']; ?></option>
		<?php	
		}
		?>
		</select>
	</td>
	</tr>
	<tr>
	<td>Nationality</td>
	<td><?php echo form_error('nationalityIdTL', '<div style="color:red">', '</div>'); ?><select name="nationalityIdTL" id="nationalityIdTL" >
	<option value="">&lt;Choose Nationality&gt;</option>
	<?php
	$qryGetNtnltyTL = mysql_query("SELECT * FROM country");
	while($ntnltyFldTL=mysql_fetch_array($qryGetNtnltyTL)){
		if($ntnltyFldTL['country_iso'] == 'ID'){
			$slctdOpt = 'selected = "selected"';
		}else{
			$slctdOpt = '';
		}
	?>
	<option value="<?php echo $ntnltyFldTL['country_iso']; ?>"  ><?php echo $ntnltyFldTL['country_name']; ?></option>
	<?php	
	}
	?>
	</select></td>
	</tr>
</table>
<!-- =============traveler leader end==================== -->
<!-- ========================traveler contact info start================= -->
<table border="0" width=100%>
	<tr>
		<td colspan="2" style="background:#4682B4"><h2>Traveler Contact Info</h2></td>
	</tr>
	<tr>
	<td width="200">Salutation</td>
	<td><select name="salutationTravCntc" id="salutationTravCntc" style="width:100px">
	<option value="">&lt;Choose&gt;</option>
	<option value="Mr" >Mr</option>
	<option value="Mrs">Mrs</option>
	<option value="Mdm">Mdm</option>
	<option value="Mstr">Mstr</option>
	<option value="Miss">Miss</option>
	<option value="Dr">Dr</option>
	</select></td>
	</tr>
	<tr>
	<td>First Name</td>
	<td><?php echo form_error('txtFirstNameTravCntc', '<div style="color:red">', '</div>'); ?><input type="text" name="txtFirstNameTravCntc" id="txtFirstNameTravCntc" /></td>
	<tr>
	<tr>
	<td>Last Name</td>
	<td><?php echo form_error('txtLastNameTC', '<div style="color:red">', '</div>'); ?><input type="text" name="txtLastNameTC" id="txtLastNameTC" /></td>
	</tr>
	<tr>
	<td>Email</td>
	<td><?php echo form_error('txtEmailTravCntc_1', '<div style="color:red">', '</div>'); ?><input type="text"  name="txtEmailTravCntc_1" id="txtEmailTravCntc_1" /></td>
	</tr>
	<tr>
	<td>Alternate Email</td>
	<td><?php echo form_error('txtEmailTravCntc_2', '<div style="color:red">', '</div>'); ?><input type="text"  name="txtEmailTravCntc_2" id="txtEmailTravCntc_2" /></td>
	</tr>
	<tr>
	<tr>
	<td>Contact Number</td>
	<td><?php echo form_error('txtPhoneNumberTravCntc', '<div style="color:red">', '</div>'); ?><input type="text"  name="txtPhoneNumberTravCntc" id="txtPhoneNumberTravCntc" style="width:100px;" placeholder="Phone Number" />
	</td>
	</tr>
	<tr>
	<td>Mobile Number</td>
	<td><?php echo form_error('txtMobileNumberTravCntc', '<div style="color:red">', '</div>'); ?><input type="text" name="txtMobileNumberTravCntc" id="txtMobileNumberTravCntc" /></td>
	</tr>
	<tr>
	<td>Fax. Number</td>
	<td><?php echo form_error('txtFaxNumberTravCntc', '<div style="color:red">', '</div>'); ?><input type="text" name="txtFaxNumberTravCntc" id="txtFaxNumberTravCntc" /></td>
	</tr>
	<tr>
	<td>Address</td>
	<td><?php echo form_error('txtaddressTravCntc', '<div style="color:red">', '</div>'); ?><textarea rows="7" cols="25" name="txtaddressTravCntc" id="txtaddressTravCntc"></textarea></td>
	</tr>
	<tr>
	<td>Postal Code</td>
	<td><?php echo form_error('txtPostalCodeTravCntc', '<div style="color:red">', '</div>'); ?><input type="text" name="txtPostalCodeTravCntc" id="txtPostalCodeTravCntc" /></td>
	</tr>
	<tr>
	<td>Country Code</td>
	<td><?php echo form_error('txtCntryCodeTravCntc', '<div style="color:red">', '</div>'); ?>
	<select name="txtCntryCodeTravCntc" id="txtCntryCodeTravCntc"  >	
	<option value="">&lt;Choose Country&gt;</option>
	<?php
	$qryCntryTC = mysql_query("SELECT * FROM country");
	while($pssprtIssCntryFld=mysql_fetch_array($qryCntryTC)){
		if($pssprtIssCntryFld['country_iso'] == 'ID'){
			$slctdOpt = 'selected = "selected"';
		}else{
			$slctdOpt = '';
		}
	?>
	<option value="<?php echo $pssprtIssCntryFld['country_iso']; ?>" ><?php echo $pssprtIssCntryFld['country_name']; ?></option>
	<?php	
	}
	?>
	</select>
	</td>
	</tr>
	<tr>
	<td>City Code</td>
	<td><?php echo form_error('txtCityCodeTravCntc', '<div style="color:red">', '</div>'); ?>
		<select name="txtCityCodeTravCntc" id="txtCityCodeTravCntc">
			<option value="">&lt;Choose City&gt;</option>
		</select>
		<span id="city_loader"></span>
	</td>
	</tr>
	
	<tr>
	<td>Nationality ID</td>
	<td><?php echo form_error('nationalityIdTravCntc', '<div style="color:red">', '</div>'); ?><select name="nationalityIdTravCntc" id="nationalityIdTravCntc" >
	<option value="">&lt;Choose Nationality&gt;</option>
	<?php
	$qryNtnltyIdTC = mysql_query("SELECT * FROM country");
	while($ntnltyIdFldTC=mysql_fetch_array($qryNtnltyIdTC)){
		if($ntnltyIdFldTC['country_iso'] == 'ID'){
			$slctdOpt = 'selected = "selected"';
		}else{
			$slctdOpt = '';
		}
	?>
	<option value="<?php echo $ntnltyIdFldTC['country_iso']; ?>"  ><?php echo $ntnltyIdFldTC['country_name']; ?></option>
	<?php	
	}
	?>
	</select></td>
	</tr>
	
	<tr>
	<td>Nationality Code</td>
	<td><?php echo form_error('nationalityCodeTravCntc', '<div style="color:red">', '</div>'); ?><select name="nationalityCodeTravCntc" id="nationalityCodeTravCntc" >
	<option value="">&lt;Choose Nationality&gt;</option>
	<?php
	$qryNtnltyCdTC = mysql_query("SELECT * FROM country");
	while($ntnltyIdFldTC=mysql_fetch_array($qryNtnltyCdTC)){
		if($ntnltyIdFldTC['country_iso'] == 'ID'){
			$slctdOpt = 'selected = "selected"';
		}else{
			$slctdOpt = '';
		}
	?>
	<option value="<?php echo $ntnltyIdFldTC['country_iso']; ?>"  ><?php echo $ntnltyIdFldTC['country_name']; ?></option>
	<?php	
	}
	?>
	</select></td>
	</tr>
</table>
<!-- ========================traveler contact info start================= -->

<!-- ==================adult traveler start============= -->
<script>
$(document).ready(function(){
	//$('.dobAdult').datepicker({
<?php 

$childDobYearMinLimit = $currentYear - $childAgeTo ;
$childDobYearMaxLimit = $currentYear - $childAgeFrom ;
for($k=0;$k<=$totAdult;$k++){
	
?>		
	$('#txtDobAdult_<?php echo $k; ?>').datepicker({
    onSelect: function(value, ui) {
        var todayAdult = new Date(),
            dobAdult = new Date(value),
            ageAdult = new Date(todayAdult - dobAdult).getFullYear() - 1969;

        $('#txtAgeAdult_<?php echo $k; ?>').val(ageAdult);
    },
    maxDate: '+0d',
    yearRange: '1940:2014',
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd'
	});
	
	$('#txtDobChild_<?php echo $k; ?>').datepicker({
    onSelect: function(value, ui) {
        var todayChild = new Date(),
            dobChild = new Date(value),
            ageChild = new Date(todayChild - dobChild).getFullYear() - 1969;
            

        $('#txtAgeChild_<?php echo $k; ?>').val(ageChild);
    },
    maxDate: '+0d',
    yearRange: '<?php echo $childDobYearMinLimit; ?>:<?php echo $childDobYearMaxLimit + 1; ?>',
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd'
	});
<?php   } ?>	
	
})
</script>
<?php 

for($i=1;$i<=$totAdult;$i++){
$qryGetNtnlty = mysql_query("SELECT * FROM country");
?>

<input type="hidden" name="travelerTypeAdult[]" id="travelerTypeAdult[]" value="32">
<table border="0" style="width:100%;">
	<tr>
		<td colspan="2" style="background:#4682B4"><h2>Adult Traveler Info <?php echo $i; ?></h2></td>
	</tr>
	<tr>
		<td width="200">Salutation</td>
		<td>
			<select name="salutationAdult[]" id="salutationAdult[]" style="width:100px" >
				<option value="">&lt;Choose Salutation&gt;</option>
				<option value="None" selected>None</option>
				<option value="Mr">Mr</option>
				<option value="Mrs">Mrs</option>
				<option value="Mdm">Mdm</option>
				<option value="Mdm">Mdm</option>
				<option value="Miss">Miss</option>
				<option value="Dr">Dr</option>
			</select></td>
	</tr>
	<tr>
		<td>First Name</td>
		<td><?php echo form_error('txtFrstNmeAdult[]','<div style="color:red">','</div>'); ?>
			<input type="text" name="txtFrstNmeAdult[]" id="txtFrstNmeAdult[]" />
		</td>
	</tr>
	<tr>
		<td>Last Name</td>
		<td><?php echo form_error('txtLstNmeAdult[]','<div style="color:red">','</div>'); ?>
			<input type="text" name="txtLstNmeAdult[]" id="txtLstNmeAdult[]" />
		</td>
	</tr>
	<tr>
		<td>Day Of Birth</td>
		<td><?php echo form_error('txtDobAdult[]', '<div style="color:red">', '</div>'); ?>
			<input type="text" id="txtDobAdult_<?php echo $i; ?>" name="txtDobAdult[]"  /></td>
	</tr>
	<tr>
		<td>Age</td>
		<td><?php echo form_error('txtAgeAdult[]','<div style="color:red">','</div>'); ?>
			<input type="text" id="txtAgeAdult_<?php echo $i; ?>" name="txtAgeAdult[]" style="width:50px;" maxlength="2" readonly /> Years Old</td>
	</tr>
	<tr>
		<td>Passport Number</td>
		<td><?php echo form_error('txtPssprtNmbrAdult[]', '<div style="color:red">', '</div>'); ?>
			<input type="text" name="txtPssprtNmbrAdult[]" id="txtPssprtNmbrAdult[]" /></td>
	</tr>
	
	<tr>
		<td>Passport Expiry Date</td>
		<td><?php echo form_error('txtPssprtExpryDteAdult[]', '<div style="color:red">', '</div>'); ?>
			<input type="text" name="txtPssprtExpryDteAdult[]"  class="passportexpiry" /></td>
	</tr>
	<tr>
		<td>Passport Issuance Country</td>
		<td><?php echo form_error('txtPssprtIssncCntryAdult[]', '<div style="color:red">', '</div>'); ?>
			<select name="txtPssprtIssncCntryAdult[]" id="txtPssprtIssncCntryAdult[]"  >
				<option value="">&lt;Choose Issuance Country&gt;</option>
				<?php
				$qryGetAdltIssncCntry[$i] = mysql_query("SELECT * FROM country");
				while($fldAdltIssncCntry= mysql_fetch_array($qryGetAdltIssncCntry[$i])){
				?>
				<option value="<?php echo $fldAdltIssncCntry['country_iso']; ?>"><?php echo $fldAdltIssncCntry['country_name']; ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr><td>Nationality ID</td><td><?php echo form_error('ntnlityIdAdult[]', '<div style="color:red">', '</div>'); ?>
		<select name="ntnlityIdAdult[]" id="ntnlityIdAdult[]" >
			<option value="">&lt;Choose Nationality&gt;</option>
			<?php
			$qryGetAdltNtnlty[$i] = mysql_query("SELECT * FROM country");
			while($fldAdltNtnlty= mysql_fetch_array($qryGetAdltNtnlty[$i])){
			?>
			<option value="<?php echo $fldAdltNtnlty['country_iso']; ?>"><?php echo $fldAdltNtnlty['country_name']; ?></option>
			<?php } ?>
		</select>
		</td>
	</tr>
</table>
<?php } ?>

<!-- ==================adult traveler end============= -->

<!-- ==================child traveler start============= -->

<?php
for($j=1;$j<=$totChild;$j++){
?>
<input type="hidden" name="salutationChild[]" id="salutationChild[]" value="None">
<input type="hidden" name="travelerTypeChild[]" id="travelerTypeChild[]" value="33">
<table border="0" width="100%">
	<tr>
		<td colspan="2" style="background:#4682B4"><h2>Child Traveler Info <?php echo $j; ?></h2></td>
	</tr>
	<tr><td width="200">First Name</td><td><?php echo form_error('txtFrstNmeChild[]', '<div style="color:red">', '</div>'); ?>
		<input type="text" name="txtFrstNmeChild[]" id="txtFrstNmeChild[]" /></td>
	</tr>
	<tr>
		<td>Last Name</td><td><?php echo form_error('txtLstNmeChild[]', '<div style="color:red">', '</div>'); ?>
			<input type="text" name="txtLstNmeChild[]" id="txtLstNmeChild[]" /></td>
	</tr>
	<tr>
		<td>Day Of Birth</td>
		<td><?php echo form_error('txtDobChild[]', '<div style="color:red">', '</div>'); ?>
			<input type="text" id="txtDobChild_<?php echo $j; ?>" name="txtDobChild[]"  /></td>
	</tr>
	<tr>
		<td>Age</td><td><?php echo form_error('txtAgeChild[]', '<div style="color:red">', '</div>'); ?>
			<input type="text" id="txtAgeChild_<?php echo $j; ?>" name="txtAgeChild[]" style="width:50px;" maxlength="2" readonly /> Years Old (<?php echo $childAgeFrom; ?> - <?php echo $childAgeTo; ?>)</td>
	</tr>
	<tr>
		<td>Passport Number</td><td><?php echo form_error('txtPssprtNmbrChild[]', '<div style="color:red">', '</div>'); ?>
			<input type="text" name="txtPssprtNmbrChild[]" /></td>
	</tr>
	
	<tr>
		<td>Passport Expiry Date</td>
		<td><?php echo form_error('txtPssprtExpryDteChild[]', '<div style="color:red">', '</div>'); ?>
		<input type="text" name="txtPssprtExpryDteChild[]" class="passportexpiry" /></td>
	</tr>
	<tr>
		<td>Passport Issuance Country</td><td><?php echo form_error('txtPssprtIssnceCntryChild[]', '<div style="color:red">', '</div>'); ?>
			
			<select name="txtPssprtIssnceCntryChild[]" >
				<option value="">&lt;Choose Issuance Country&gt;</option>
				<?php
				$qryGetChldIssncCntry[$i] = mysql_query("SELECT * FROM country");
				while($fldChldIssncCntry= mysql_fetch_array($qryGetChldIssncCntry[$i])){
				?>
				<option value="<?php echo $fldChldIssncCntry['country_iso']; ?>"><?php echo $fldChldIssncCntry['country_name']; ?></option>
				<?php } ?>
			</select>
	</tr>
	<tr>
		<td>Nationality</td><td><?php echo form_error('ntnalityIdChild[]', '<div style="color:red">', '</div>'); ?>
			<select name="ntnalityIdChild[]" >
				<option value="">&lt;Choose Nationality&gt;</option>
				<?php
				$qryGetChldNtnlty[$i] = mysql_query("SELECT * FROM country");
				while($fldChldNtnlty= mysql_fetch_array($qryGetChldNtnlty[$i])){
				?>
				<option value="<?php echo $fldChldNtnlty['country_iso']; ?>"><?php echo $fldChldNtnlty['country_name']; ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
</table>
<?php } ?>

<!-- ==================child traveler end============= -->

	<table border="0" width=100%>
		<tr>
			<td colspan="2" style="background:#4682B4"><h2>Flight Info</h2></td>
		</tr>
		<tr>
			<td width="200">Arrival Flight Number</td>
			<td><?php echo form_error('txtArrivFlightNum', '<div style="color:red">', '</div>'); ?><input type="text" id="txtArrivFlightNum" name="txtArrivFlightNum" /></td>
		</tr>
		<tr>
			<td>Departure Flight Number</td>
			<td><?php echo form_error('txtDepartFlightNum', '<div style="color:red">', '</div>'); ?><input type="text" id="txtDepartFlightNum" name="txtDepartFlightNum" /></td>
		</tr>
		<tr>
			<td>Arrival Date</td>
			<td><?php echo form_error('txtArrivDate', '<div style="color:red">', '</div>'); ?><input type="text" id="txtArrivDate" name="txtArrivDate" class="datepicker" /></td>
		</tr>
		<tr>
			<td>Departure Date</td>
			<td><?php echo form_error('txtDepartDate', '<div style="color:red">', '</div>'); ?><input type="text" id="txtDepartDate" name="txtDepartDate" class="datepicker" /></td>
		</tr>
		<!--
		<tr>
			<td>Pick Up / Drop Off Hotel</td>
			<td><?php echo form_error('pikupDropoff', '<div style="color:red">', '</div>'); ?>
				<select name="pikupDropoff" >
				<option value="">&lt;Choose Pickup Point&gt;</Choose></option>
				<?php
				$qry = $this->db->query("SELECT * FROM pickup_point WHERE API_packages_id='$bkngPid' ");
				foreach ($qry->result() as $row)
				{
					
				   echo '<option value="'.$row->hotel_code.'">'.$row->hotel_name.'</option>';
				   
				}
				?>
				</select>
			</td>
		</tr>
		-->
	</table>

	<table border="0" width=100% >
		<tr>
			<td colspan="2" style="background:#4682B4"><h2>Payment Method</h2></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<table>
					<tr>
						<td style="padding:5px;"><input type="radio" id="creditCard" name="paymethod" value="1" checked style="float: left"   /><label for="creditCard" style="float: left">Credit Card (Visa, Master Card)</label></td>
						<td style="padding:5px;"><input type="radio" id="transferBCA" name="paymethod" value="2" style="float: left" /><label for="transferBCA" style="float: left">BCA</label></td>
						<td style="padding:5px;"><input type="radio" id="transferBNI" name="paymethod" value="3" style="float: left"  /><label for="transferBNI" style="float: left">BNI</label></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<table border="0" width="100%" >
		<tr>
			<div id="bcaAccInfo" style="display:none;" >
			<div style="background:#4682B4;padding: 5px;"><h2>BCA Account Info</h2></div>
			<div>BCA Account Name</div>
			<div>Account Number</div>
			</div>
			
			<div id="bniAccInfo" style="display:none;" >
			<div style="background:#4682B4;padding:5px;"><h2>BNI Account Info</h2></div>
			<div>BNI Account Name</div>
			<div>Account Number</div>
			</div>
		</tr>
	</table>
	
	
	<table border="0" width="100%" id="cardInfo">
		<tr>
			<td colspan="2" style="background:#4682B4"><h2>Credit Card Info</h2></td>
		</tr>
		
		<tr>
			<td>Card Number</td>
			<td><?php echo form_error('txtCardNumber', '<div style="color:red">', '</div>'); ?><input type="text" id="txtCardNumber" name="txtCardNumber" /></td>
		</tr>
		<tr>
		<tr>
			<td>Security Code</td>
			<td><?php echo form_error('txtCardSecureCode', '<div style="color:red">', '</div>'); ?><input type="text" id="txtCardSecureCode" name="txtCardSecureCode" /></td>
		</tr>
		<tr>	
			<td>Name On Card</td>
			<td><?php echo form_error('txtNameOnCard', '<div style="color:red">', '</div>'); ?><input type="text" id="txtNameOnCard" name="txtNameOnCard" /></td>
		</tr>
		<tr>
			<td>Expiration Date</td>
			<td><?php echo form_error('txtCardExpiryDate', '<div style="color:red">', '</div>'); ?><input type="text" id="txtCardExpiryDate" name="txtCardExpiryDate" class="cardexpiry" /></td>
		</tr>
	</table>
	<table border="0" width=100%>
		<tr>
		<td>&nbsp;</td>
		<td align="right"><input type="submit" name="confirmBook" id="confirmBook" value="Confirm Booking" /></td>
		</tr>
	</table>
</form>
</div>
</div>
<!-- ======================================================== -->
<!--	
		<form name="formpay" action="<?php echo base_url();?>index.php/transaction/saveTCGuest/<?php echo $this->session->userdata('sess_trans_no'); ?>" method="post" />
<div class="editable-input" >

<table border="0" width=100%>
	<tr class="h2">
			<td colspan="3"><h2>Select a Payment Method</h2></td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;Payment Method</td>
			<td>&nbsp;:&nbsp;</td>
			<td style="padding-top: 10px;">
			<?php
			$x=0;
			$query=mysql_query("select * from metode_pembayaran where publish='1'");
			   while($row=mysql_fetch_array($query)){
			   	echo '<h2><input type="radio" name="paymethod" value="'.$row['metode_id'].'" />'.$row['nama_metode'].'</h2>';
			  }
			?>
			</td>
		</tr>

	<br/>

		<tr class="h2">
			<td colspan="3"><h2>Information That Can Be Contacted</h2></td>
		</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Full Name</td>
				<td>&nbsp;:&nbsp;</td>
				<td style="padding-top: 10px;"><input type="text" id="txtname" name="txtname"  /></td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Phone</td>
				<td>&nbsp;:&nbsp;</td>
				<td style="padding-top: 10px;"><input type="text" id="txtphone" name="txtphone"   /></td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Email</td>
				<td>&nbsp;:&nbsp;</td>
				<td style="padding-top: 10px;"><input type="text" id="txtemail" name="txtemail"   /></td>
			</tr>
			
		<tr class="h2">
			<td colspan="3"><h2>Payment Detail</h2></td>
		</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Card Number</td>
				<td>&nbsp;:&nbsp;</td>
				<td style="padding-top: 10px;"><input type="text" name="txtcardnumber"  /></td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Security Code</td>
				<td>&nbsp;:&nbsp;</td>
				<td style="padding-top: 10px;"><input type="text" name="txtsecurity" /></td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Name Card Holder</td>
				<td>&nbsp;:&nbsp;</td>
				<td style="padding-top: 10px;"><input type="text" name="txtnamecard"  /></td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Country</td>
				<td>&nbsp;:&nbsp;</td>
				<td style="padding-top: 10px;"><select name="country" >
				<?php foreach($ar_country as $row) : ?>
					<option value="<?php echo $row->country_iso; ?>"> <?php echo $row->country_name; ?></option>
				<?php endforeach; ?>
					</select></td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Address</td>
				<td>&nbsp;:&nbsp;</td>
				<td style="padding-top: 10px;"><textarea rows="7" cols="25" name="txtaddress"></textarea></td>
			</tr>
			<tr>
				<td colspan=4><input type="button" name="back" style="float: right;margin-right:10px;" value="Back" onClick="history.go(-1)" /> &nbsp; &nbsp; <input type="submit" name="continue" style="float: right;margin-right:10px;" value="Continue" /></td>
			</tr>
		</table>
	</div>
<br/>
		</form>	
<div style="clear:both"/>
	</div>
</div>
-->
<br /><br />