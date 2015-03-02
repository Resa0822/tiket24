<?php 

error_reporting(0);
/*
 $bkngUsid = $this->session->userdata('bookingUSID');
 $bkngPid = $this->session->userdata('bookingPID');
 */

 //$bkngUsid = $this->session->userdata('bookingUSID');
 $bkngUsid = $this->uri->segment(3);
 $this->db->select('*');
 $this->db->from('book_packages');
 $this->db->where('usid', $bkngUsid);
 $qry = $this->db->get();
 foreach($qry->result() as $rowSess){
 	$bkngPid = $rowSess->API_packages_id;
 }


/*
$uriUsid = $this->uri->uri_to_assoc(3);
$bkngUsid = $uriUsid['sid']; 
$uriPid = $this->uri->uri_to_assoc(5);
$bkngPid = $uriPid['pid']; 
*/
$qry = mysql_query("SELECT * FROM book_packages WHERE usid='$bkngUsid' ");
$field = mysql_fetch_array($qry);
$bkngPid = $field['API_packages_id'];
$trnsctnCode = $field['transaction_code'];
$totAdult = $field['adult'];
$totChild = $field['child'];
$totAmount_inIDR = $field['amount_total_sale_price_inIDR'];
$qry = $this->db->query("select * from tours where API_packages_id='$bkngPid' ");
foreach($qry->result() as $data){
	$childAgeFrom = $data->child_age_from;
	$childAgeTo = $data->child_age_to;	
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
	
	$('#MP0001').click(function(){
		$('#bank_MP0001').show("fold", 1000);
		$('#bank_MP0002').hide("fold", 1000);
		$('#bank_MP0003').hide("fold", 1000);
		$('#bank_MP0004').hide("fold", 1000);
	});
	$('#MP0002').click(function(){
		$('#bank_MP0001').hide("fold", 1000);
		$('#bank_MP0002').show("fold", 1000);
		$('#bank_MP0003').hide("fold", 1000);
		$('#bank_MP0004').hide("fold", 1000);
	});
	$('#MP0003').click(function(){
		$('#bank_MP0001').hide("fold", 1000);
		$('#bank_MP0002').hide("fold", 1000);
		$('#bank_MP0003').show("fold", 1000);
		$('#bank_MP0004').hide("fold", 1000);
	});
	$('#MP0004').click(function(){
		$('#bank_MP0001').hide("fold", 1000);
		$('#bank_MP0002').hide("fold", 1000);
		$('#bank_MP0003').hide("fold", 1000);
		$('#bank_MP0004').show("fold", 1000);
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
	
	/*
	 $('#radeemMyPoint').change(function(){
                    if ($('#radeemMyPoint').is(":checked")) {
					 	var tc = <?php /* echo $trnsctnCode.'-735'; */ ?>;	
					 	var cs = 1;
						$.ajax({   
						   url: "<?php /*base_url() */ ?>index.php/ajaxHandler/amountWithRadeem", 
						   async: false,
						   type: "POST", 
						   data: {"tc":tc, "cs":cs}, 
						   dataType: "html", 
						   beforeSend: function () {
									   $('#totalAfterRadeemPoint').append('wait...');
										},
									  
						  success: function(data) {
										$('#totalAfterRadeemPoint').html(data);  
										//$('#txtCityCodeTravCntc').append(data);  
									}
						})
                    }  
                    else {
						var tc = <?php /*echo $trnsctnCode.'-1705';*/ ?>;	
						var cs = 0;
                        
                    }
				
       });

	*/
	
	
	
	
	
	
	
});
</script>
<div class="search_package">

<h2>&nbsp;</h2>
<div style="clear: both;"></div>
	<div id="hotel-content-description"  style="text-align:center;border:10px solid #25497d; margin:auto; padding:35px 35px 35px 35px; border-radius:15px 15px 15px 15px; margin-top: 50px;">
<!-- ======================================================== -->
<?php if($this->session->flashdata('flashMsge')){ ?>
<div>
   <?php echo $this->session->flashdata('flashMsge'); ?>
</div>
<?php } ?>
<?php //echo base_url();index.php/booking/processing?>
<form action="<?php echo base_url();?>index.php/booking/processing " method="post" enctype="multipart/form-data" />
<?php
/* jika login dan point mencukupi radeem point dimunculkan */
if ($this->tank_auth->is_logged_in()) {	
$userRoleID = $this->tank_auth->get_user_role_id();
$userID = $this->tank_auth->get_user_id();
$this->db->select('*');
$this->db->from('users');
$this->db->where('users_id', $userID);
$this->db->where('role_id', $userRoleID);
$qryUsr = $this->db->get();
	foreach($qryUsr->result() as $fldUsr){
		$usrRoleId = $fldUsr->role_id;
		$usrPoint = $fldUsr->total_point;
		$this->db->select('*');
		$this->db->from('adm_transfer');
		$this->db->where('jenis_tr', $usrRoleId);
		$result = $this->db->get();
		$return = array();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row) {
				$return[$row['keterangan']] = $row['content'];
			}
			if($usrRoleId == '2'){
			/* memeber */
				$MinimalBeli = $return['MinimalBeli'];	
				$NominalBeli = $return['NominalBeli'];
				$PointBeli = $return['PointBeli'];
				$MinimalPoint = $return['MinimalPoint'];
				$PointTukar = $return['PointTukar'];
				$NominalBayar = $return['NominalBayar'];
			}
			elseif($usrRoleId == '3'){
			/* reseller */
				$MinimalBeli = $return['MinimalBeliReseller'];
				$NominalBeli = $return['NominalBeliReseller'];
				$PointBeli = $return['PointBeliReseller'];
				$MinimalPoint = $return['MinimalPointReseller'];
				$PointTukar = $return['PointTukarReseller'];
				$NominalBayar = $return['NominalBayarReseller'];
			}
							
		}
		if($usrPoint >= $MinimalPoint){
			$pointToRadeem = $usrPoint; 
			$pointValue = $usrPoint * $NominalBayar; 
			/* convertion currency rate IDR to SGD */
			$this->db->select('*');
			$this->db->from('currencies');
			$this->db->where('currency_from', 'SGD');
			$this->db->where('country_iso_from', 'SG');
			$this->db->where('currency_to', 'IDR');
			$this->db->where('country_iso_to', 'ID');
			$rateValCurr = $this->db->get();
			foreach($rateValCurr->result() as $rowRateFld){
				$valIdrRate = $rowRateFld->konversi;
			}
			$nilNomPerPoint_inSGD = $NominalBayar / $valIdrRate;
			$pntNomValue_inSGD = $usrPoint * $nilNomPerPoint_inSGD;
			$nilTotNomPnt_inIDR = round($usrPoint * $valIdrRate, 2);//Tot. Nil. Nom. Trans. in IDR
			
			$rateIdrToSgd = round($pointValue / $valIdrRate, 2);   
		}
	}
if($MinimalPoint <= $usrPoint){	
?>
<div id="totalAfterRadeemPoint"></div>
<table style="width:100%;">
	<tr>
		<td colspan="2" style="vertical-align:middlel"><label for="radeemMyPoint"><input type="checkbox" name="radeemMyPoint" id="radeemMyPoint" value="1" > Radeem My Point (<?php echo '<b>'.$pointToRadeem.'</b>'; ?>)</label></td>
	</tr>
</table>
<?php
}
}
?>	
<!-- =============traveler leader start==================== -->
<table border="0" style="width:100%;">
	<input type="hidden" name="trvlrTypeTL" value="32">
	<input type="hidden" name="usid" value="<?php echo $bkngUsid; ?>">
	<input type="hidden" name="pid" value="<?php echo $bkngPid; ?>">
	<tr>
		<td colspan="2" style="background:#4682B4"><h2>Traveler Leader</h2></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	<td width="200">Salutation</td>
	<td>
		<select name="salutationTL" style="width:50px" >
			<option selected="selected" value="Mr">Mr</option>
			<option value="Mrs">Mrs</option>
			<option value="Mdm">Mdm</option>
			<option value="Mstr">Mstr</option>
			<option value="Miss">Miss</option>
		</select>
	</td>
	</tr>
	<tr>
	<td>First Name</td>
	<td><?php echo form_error('txtFirstNameTL', '<div style="color:red">', '</div>'); ?><input type="text" name="txtFirstNameTL" /></td>
	</tr>
	<tr>
	<td>Last Name</td>
	<td><?php echo form_error('txtLastNameTL', '<div style="color:red">', '</div>'); ?><input type="text" name="txtLastNameTL" /></td>
	</tr>
    <!--
	<tr>
	<td>Day Of Birth</td>
	<td><?php echo form_error('txtDobTL', '<div style="color:red">', '</div>'); ?><input type="text" id="txtDobTL" name="txtDobTL"   /></td>
	</tr>
    -->
	<!--
	<tr>
	<td>Age</td>
	<td><?php echo form_error('txtAgeTL', '<div style="color:red">', '</div>'); ?><input type="text" id="txtAgeTL" name="txtAgeTL" readonly="readonly" style="width:50px;" maxlength="2" /> Years Old</td>
	</tr>
    -->
	<!--
	<tr>
	<td>Passport Number</td>
	<td><?php echo form_error('txtPssprtNmbrTL', '<div style="color:red">', '</div>'); ?><input type="text" name="txtPssprtNmbrTL" /></td>
	</tr>-->
	<!--<tr>
	<td>Passport Expiry Date</td>
	<td><?php echo form_error('txtPssprtExpryDteTL', '<div style="color:red">', '</div>'); ?><input type="text" name="txtPssprtExpryDteTL" class="passportexpiry" /></td>
	</tr>
	<!--
	<tr>
	<td>Passport Issuance Country</td>
	<td><?php echo form_error('txtPssprtIssuanceCntryTL', '<div style="color:red">', '</div>'); ?>
		<select name="txtPssprtIssuanceCntryTL" >
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
	</tr>-->
	<tr>
	<td>Nationality</td>
	<td><?php echo form_error('nationalityIdTL', '<div style="color:red">', '</div>'); ?><select name="nationalityIdTL" >
	<option value="">&lt; Nationality &gt;</option>
	<?php
	$qryGetNtnltyTL = mysql_query("SELECT * FROM country");
	while($ntnltyFldTL=mysql_fetch_array($qryGetNtnltyTL)){
		if($ntnltyFldTL['country_iso'] == 'ID'){
			$slctdOpt = 'selected = "selected"';
		}else{
			$slctdOpt = '';
		}
	?>
	<option value="<?php echo $ntnltyFldTL['idx'].'-'.$ntnltyFldTL['country_iso']; ?>"  ><?php echo $ntnltyFldTL['country_name']; ?></option>
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
		<td colspan="2" style="background:#4682B4"><h2>Contact Details</h2></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	<td width="200">Salutation</td>
	<td>
		<select name="salutationTravCntc" style="width:50px">
			<option selected="selected" value="Mr">Mr</option>
			<option value="Mrs">Mrs</option>
			<option value="Mdm">Mdm</option>
			<option value="Mstr">Mstr</option>
			<option value="Miss">Miss</option>
		</select>
	</td>
	</tr>
	<tr>
	<td>First Name</td>
	<td><?php echo form_error('txtFirstNameTravCntc', '<div style="color:red">', '</div>'); ?><input type="text" name="txtFirstNameTravCntc" /></td>
	<tr>
	<tr>
	<td>Last Name</td>
	<td><?php echo form_error('txtLastNameTC', '<div style="color:red">', '</div>'); ?><input type="text" name="txtLastNameTC" /></td>
	</tr>
	<tr>
	<td>Email</td>
	<td><?php echo form_error('txtEmailTravCntc_1', '<div style="color:red">', '</div>'); ?><input type="text"  name="txtEmailTravCntc_1" /></td>
	</tr>
	<!--
	<tr>
	<td>Alternate Email</td>
	<td><?php echo form_error('txtEmailTravCntc_2', '<div style="color:red">', '</div>'); ?><input type="text"  name="txtEmailTravCntc_2" /></td>
	</tr>-->
	
	<tr>
	<td>Contact Number</td>
	<td><?php echo form_error('txtPhoneNumberTravCntc', '<div style="color:red">', '</div>'); ?><input type="text"  name="txtPhoneNumberTravCntc" />
	</td>
	</tr>
	<!--
	<tr>
	<td>Mobile Number</td>
	<td><?php echo form_error('txtMobileNumberTravCntc', '<div style="color:red">', '</div>'); ?><input type="text" name="txtMobileNumberTravCntc" /></td>
	</tr>-->
	<!--
	<tr>
	<td>Fax. Number</td>
	<td><?php echo form_error('txtFaxNumberTravCntc', '<div style="color:red">', '</div>'); ?><input type="text" name="txtFaxNumberTravCntc" /></td>
	</tr>-->
	<!--
	<tr>
	<td>Address</td>
	<td><?php echo form_error('txtaddressTravCntc', '<div style="color:red">', '</div>'); ?><textarea rows="7" cols="25" name="txtaddressTravCntc"></textarea></td>
	</tr>-->
	<!--
	<tr>
	<td>Postal Code</td>
	<td><?php echo form_error('txtPostalCodeTravCntc', '<div style="color:red">', '</div>'); ?><input type="text" name="txtPostalCodeTravCntc" /></td>
	</tr>-->
	<!--
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
	</tr>-->
	<!--
	<tr>
	<td>City Code</td>
	<td><?php echo form_error('txtCityCodeTravCntc', '<div style="color:red">', '</div>'); ?>
		<select name="txtCityCodeTravCntc" id="txtCityCodeTravCntc">
			<option value="">&lt;Choose City&gt;</option>
		</select>
		<span id="city_loader"></span>
	</td>
	</tr>-->
	<!--
	<tr>
	<td>Nationality</td>
	<td><?php echo form_error('nationalityCodeTravCntc', '<div style="color:red">', '</div>'); ?><select name="nationalityCodeTravCntc" >
	<option value="">&lt; Nationality &gt;</option>
	<?php
	$qryNtnltyCdTC = mysql_query("SELECT * FROM country");
	while($ntnltyIdFldTC=mysql_fetch_array($qryNtnltyCdTC)){
		if($ntnltyIdFldTC['country_iso'] == 'ID'){
			$slctdOpt = 'selected = "selected"';
		}else{
			$slctdOpt = '';
		}
	?>
	<option value="<?php echo $ntnltyIdFldTC['idx'].'-'.$ntnltyIdFldTC['country_iso']; ?>"  ><?php echo $ntnltyIdFldTC['country_name']; ?></option>
	<?php	
	}
	?>
	</select></td>
	</tr>
	-->
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
<!--
<?php 
$adultEndLoop = $totAdult - 1;
for($i=1;$i<=$adultEndLoop;$i++){
$j=$i+1;
$qryGetNtnlty = mysql_query("SELECT * FROM country");
?>

<input type="hidden" name="travelerTypeAdult[]" value="32">
<table border="0" style="width:100%;">
	<tr>
		<td colspan="2" style="background:#4682B4"><h2>Adult Traveler Info <?php echo $j; ?></h2></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="200">Salutation</td>
		<td>
			<select name="salutationAdult[]" style="width:100px" >
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
			<input type="text" name="txtFrstNmeAdult[]" />
		</td>
	</tr>
	<tr>
		<td>Last Name</td>
		<td><?php echo form_error('txtLstNmeAdult[]','<div style="color:red">','</div>'); ?>
			<input type="text" name="txtLstNmeAdult[]" />
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
			<input type="text" name="txtPssprtNmbrAdult[]" /></td>
	</tr>
	
	<tr>
		<td>Passport Expiry Date</td>
		<td><?php echo form_error('txtPssprtExpryDteAdult[]', '<div style="color:red">', '</div>'); ?>
			<input type="text" name="txtPssprtExpryDteAdult[]" class="passportexpiry" /></td>
	</tr>
	<tr>
		<td>Passport Issuance Country</td>
		<td><?php echo form_error('txtPssprtIssncCntryAdult[]', '<div style="color:red">', '</div>'); ?>
			<select name="txtPssprtIssncCntryAdult[]" >
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
	<tr><td>Nationality</td><td><?php echo form_error('ntnlityIdAdult[]', '<div style="color:red">', '</div>'); ?>
		<select name="ntnlityIdAdult[]" >
			<option value="">&lt;Choose Nationality&gt;</option>
			<?php
			$qryGetAdltNtnlty[$i] = mysql_query("SELECT * FROM country");
			while($fldAdltNtnlty= mysql_fetch_array($qryGetAdltNtnlty[$i])){
			?>
			<option value="<?php echo $fldAdltNtnlty['idx'].'-'.$fldAdltNtnlty['country_iso']; ?>"><?php echo $fldAdltNtnlty['country_name']; ?></option>
			<?php } ?>
		</select>
		</td>
	</tr>
</table>
<?php } ?>
-->
<!-- ==================adult traveler end============= -->

<!-- ==================child traveler start============= -->

<?php
for($j=1;$j<=$totChild;$j++){
?>
<input type="hidden" name="salutationChild[]" value="None"><input type="hidden" name="travelerTypeChild[]" value="33">
<table border="0" width="100%">
	<tr>
		<td colspan="2" style="background:#4682B4"><h2><?php if($j > 1){echo $j;}else{ echo '';}; ?> Child Traveler Details</h2></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr><td width="200">First Name</td><td><?php echo form_error('txtFrstNmeChild[]', '<div style="color:red">', '</div>'); ?>
		<input type="text" name="txtFrstNmeChild[]" /></td>
	</tr>
	<tr>
		<td>Last Name</td><td><?php echo form_error('txtLstNmeChild[]', '<div style="color:red">', '</div>'); ?>
			<input type="text" name="txtLstNmeChild[]" /></td>
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
	<!--
	<tr>
		<td>Passport Number</td><td><?php echo form_error('txtPssprtNmbrChild[]', '<div style="color:red">', '</div>'); ?>
			<input type="text" name="txtPssprtNmbrChild[]" /></td>
	</tr>-->
	<!--
	<tr>
		<td>Passport Expiry Date</td>
		<td><?php echo form_error('txtPssprtExpryDteChild[]', '<div style="color:red">', '</div>'); ?>
		<input type="text" name="txtPssprtExpryDteChild[]" class="passportexpiry" /></td>
	</tr>
	-->
	<!--
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
	</tr>-->
	<!--
	<tr>
		<td>Nationality</td><td><?php echo form_error('ntnalityIdChild[]', '<div style="color:red">', '</div>'); ?>
			<select name="ntnalityIdChild[]" >
				<option value="">&lt; Nationality &gt;</option>
				<?php
				$qryGetChldNtnlty[$i] = mysql_query("SELECT * FROM country");
				while($fldChldNtnlty= mysql_fetch_array($qryGetChldNtnlty[$i])){
				?>
				<option value="<?php echo $fldChldNtnlty['idx'].'-'.$fldChldNtnlty['country_iso']; ?>"><?php echo $fldChldNtnlty['country_name']; ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>-->
</table>
<?php } ?>

<!-- ==================child traveler end============= -->

	<table border="0" width=100%>
		<tr>
			<td colspan="2" style="background:#4682B4"><h2>Tour / Attraction Details</h2></td>
		</tr>
		<tr>
		<td colspan="2">&nbsp;</td>
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
		<?php
		
		$qryTrs = $this->db->get_where('tours', array('API_packages_id'=>$bkngPid));
		foreach($qryTrs->result() as $rowTrs){
			$trNme = $rowTrs->tour_name;
		}
		if(isset($packageTourName)){
			$tourName = $packageTourName;
		}
		else{
			$tourName = $trNme;
		}
	
		?>
		<tr>
		<td colspan="2" style="padding:5px;"><?php echo '<strong>" '.$tourName.' "</strong>'; ?></td>
		</tr>
		<tr>
			<td width="200">Pick Up / Drop Off Hotel</td>
			<td><?php echo form_error('pikupDropoff', '<div style="color:red">', '</div>'); ?>
				<select name="pikupDropoff" >
				<option value="">&lt; please select &gt;</Choose></option>
				<?php
				if(isset($packageAPIid)){
					$idPckgAPI = $packageAPIid;
				}
				else{
					$idPckgAPI = $bkngPid;
				}
				$qry = $this->db->query("SELECT * FROM pickup_point WHERE API_packages_id='$idPckgAPI' ");
				foreach ($qry->result() as $row)
				{
				   echo '<option value="'.$row->hotel_code.'">'.$row->hotel_name.'</option>';
				}
				?>
				
				</select>
			</td>
		</tr>
	</table>

	<table border="0" width=100%>
		<tr>
			<td colspan="2" style="background:#4682B4"><h2>Payment Method</h2></td>
		</tr>
		<tr>
		<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<table>
					<tr>
					<?php
					if(!$this->tank_auth->is_logged_in()){	
							$qry = $this->db->get_where('metode_pembayaran', array('kode !=' => 'MP0004'));
							foreach($qry->result() as $row){
								if($row->nama_metode == 'Credit Card'){
									$nilCheck = 'checked';
								}else{
									$nilCheck = '';
								}
					?>	
						<td style="padding:5px;">
							<label for="<?php echo $row->kode; ?>" style="float: left">
							<input type="radio" id="<?php echo $row->kode; ?>" name="paymethod" value="<?php echo $row->kode; ?>" <?php echo $nilCheck; ?> style="float: left"   /><?php echo $row->deskripsi; ?>
							</label>
						</td>
						<!--<td style="padding:5px;"><input type="radio" id="transferBCA" name="paymethod" value="2" style="float: left" /><label for="transferBCA" style="float: left">BCA</label></td>
						<td style="padding:5px;"><input type="radio" id="transferBNI" name="paymethod" value="3" style="float: left"  /><label for="transferBNI" style="float: left">BNI</label></td>-->
					<?php 
							}
					} 
					else{
						if($this->tank_auth->get_user_role_id() == '3' ){
							$qry = $this->db->get('metode_pembayaran');
							foreach($qry->result() as $row){
								if($row->nama_metode == 'Credit Card'){
									$nilCheck = 'checked';
								}else{
									$nilCheck = '';
								}
							
					?>
							<td style="padding:5px;">
								<label for="<?php echo $row->kode; ?>" style="float: left">
								<input type="radio" id="<?php echo $row->kode; ?>" name="paymethod" value="<?php echo $row->kode; ?>" <?php echo $nilCheck; ?> style="float: left"   /><?php echo $row->deskripsi; ?>
								</label>
							</td>
					<?php		
							}
						} 
						else{
							$qry = $this->db->get_where('metode_pembayaran', array('kode !=' => 'MP0004'));
							foreach($qry->result() as $row){
								if($row->nama_metode == 'Credit Card'){
									$nilCheck = 'checked';
								}else{
									$nilCheck = '';
								}
					?>
								<td style="padding:5px;">
									<label for="<?php echo $row->kode; ?>" style="float: left">
									<input type="radio" id="<?php echo $row->kode; ?>" name="paymethod" value="<?php echo $row->kode; ?>" <?php echo $nilCheck; ?> style="float: left"   /><?php echo $row->deskripsi; ?>
									</label>
								</td>
					<?php			
							}
						}
					}
					
					?>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<table border="0" width="100%" id="bank_MP0001">
		<tr>
			<td colspan="2" style="background:#4682B4"><h2>Credit Card Info</h2></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
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
	<?php
	$this->db->select('*');
	$this->db->from('metode_pembayaran');
	$this->db->where('kode !=', 'MP0001');
	$this->db->where('kode !=', 'MP0004');
	$qryPymntMthd = $this->db->get();
	foreach($qryPymntMthd->result() as $fldPtmntMthd){
		$mtdNme = $fldPtmntMthd->nama_metode;
		$mtdCde = $fldPtmntMthd->kode;
		$accntOwnr = $fldPtmntMthd->accnt_nme_owner;
		$accntNmbr = $fldPtmntMthd->accnt_nmbr;
	
	?>
	<table border="0" width="100%" id="bank_<?php echo $mtdCde; ?>" style="display:none">
		<tr>
			<td colspan="2" style="background:#4682B4"><h2><?php echo $mtdNme; ?></h2></td>
		</tr>
		<tr>
			<td colspan="2" style="font-size:14px; text-align: center;" ><b>Acc. Owner : </b> <?php echo $accntOwnr; ?></td>
		</tr>
		<tr>
			<td colspan="2" style="font-size:14px; text-align: center;" ><b>Acc. Number : </b> <?php echo $accntNmbr; ?></td>
		</tr>
	</table>
	<?php
	}
	if($this->tank_auth->is_logged_in()){
		$usrRoleID = $this->tank_auth->get_user_role_id();
		if($usrRoleID == '3'){
			$usrID = $this->tank_auth->get_user_id(); 	
			$this->db->select('*');
			$this->db->from('metode_pembayaran');
			$this->db->where('kode', 'MP0004');
			$qry = $this->db->get();
			foreach($qry->result() as $row){
				$mtdNme = $row->nama_metode;
				$mtdCde = $row->kode;
				$this->db->select('*');
				$this->db->from('deposit');
				$this->db->join('reseller_profile', 'reseller_profile.id=deposit.id', 'left');
				$this->db->where('users_id', $usrID);
			    $qryDpst = $this->db->get();
				foreach($qryDpst->result() as $rowDpst){
					$usrDeposit  = $rowDpst->nominal;
					$usrName = $rowDpst->first_name.' '.$rowDpst->last_name;
				}
	?>
		<table border="0" width="100%" id="bank_<?php echo $mtdCde; ?>" style="display:none">
			<tr>
				<td colspan="2" style="background:#4682B4"><h2><?php echo $mtdNme; ?></h2></td>
			</tr>
			<tr>
				<td colspan="2" style="font-size:14px; text-align: center;" ><b>User : </b> <?php echo $usrName; ?></td>
			</tr>
			<tr>
				<td colspan="2" style="font-size:14px; text-align: center;" ><b>Deposits Balance : </b> IDR <?php echo number_format($usrDeposit, 2); ?></td>
			</tr>
<tr>
				<td style="color:red; text-align:center;">
					<?php
					$qry = $this->db->get_where('book_packages', array('usid'=>$bkngUsid, 'API_packages_id'=>$bkngPid));
					foreach($qry->result() as $row){
						$trnsCde = $row->transaction_code;
						$pckgPrice_IDR = $row->amount_total_sale_price_inIDR;
					}
					if($usrDeposit < $pckgPrice_IDR){
						echo '<h3>Insufficient Balance !</h3>';
					}
					?>
				</td>
			</tr>
		</table>
	<?php
			}
		}
	}
	?>
	
	<table border="0" width=100%>
		<tr>
		<td align="right"><input type="submit" name="confirmBook" value="Confirm Booking" />&nbsp;</td><?php //<input type="submit" name="confirmBook" value="Confirm Booking" /> ?>
	<!--	<td align="right"><button onclick="test()">Confirm Booking</button>	

<script>
function test() {
    var ask = window.confirm("Your Identity Was Completed?");
    if (ask) {
        window.alert("Booking Has Been Sent");

        document.location.href = "http://tiket24.co.id/index.php";

    }
  }
</script>-->
</td>
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