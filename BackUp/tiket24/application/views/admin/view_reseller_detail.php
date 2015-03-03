<?php

$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$role_id = array(
	'name'	=> 'role_id',
	'id'	=> 'role_id',
	'value'	=> 3,
	'maxlength'	=> 80,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
$first_name = array(
	'name'	=> 'first_name',
	'id'	=> 'first_name',
	'value'	=> set_value('first_name'),
	'maxlength'	=> 80,
	'size'	=> 20,
	'style'	=> 'width:20%',
	'placeholder'	=>	'First Name' 
);
$last_name = array(
	'name'	=> 'last_name',
	'id'	=> 'last_name',
	'value'	=> set_value('last_name'),
	'maxlength'	=> 80,
	'size'	=> 320,
	'style'	=> 'width:20%',
	'placeholder'	=>	'Last Name' 
);
$name = array(
	'name'	=> 'name',
	'id'	=> 'name',
	'value'	=> set_value('name'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$legal_name = array(
	'name'	=> 'legal_name',
	'id'	=> 'legal_name',
	'value'	=> set_value('legal_name'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$yoo = array(
	'name'	=> 'yoo',
	'id'	=> 'yoo',
	'style'	=> 'width:10%',
);
?>
<script>
	function showT(c,f){
	sliderValue.style.visibility="hidden"}
</script>

<?php
$getIdUri = $this->uri->uri_to_assoc(3);
$resellerID = $getIdUri['id']; 


$qryReseller = $this->db->get_where('reseller_profile', array('users_id' => $resellerID));
foreach($qryReseller->result() as $rows){
	$agencyName = $rows->agency_name;
	$legalName = $rows->legal_name;	
	$title = $rows->title;	
	$firstName = $rows->first_name;
	$lastName = $rows->last_name;	
	$addrss1 = $rows->address;
	$addrss2 = $rows->address2;
	$city = $rows->city;
	$state = $rows->state;
	$pstalCode= $rows->postcode;
	$country = 	$rows->country;
	$web = 	$rows->website;
	$phoneNum = $rows->phone;
	$mobile = $rows->mobile;
	$fax = $rows->fax;
	$iata = $rows->iata;
	$coType = $rows->company_type;
	$bizType = $rows->business_type;
	$yearOo = $rows->year_oo;
	$employees = $rows->employess;
	$paymentMode = $rows->payment_mode;
}

?>
<?php echo form_open_multipart("reseller/update/id/$resellerID"); 
form_hidden('rsllrID', $resellerID);
?>

<div style="margin:0px 5%;">
<br/>
<center>
<table>

<tr><td><h1 style="font-size:120%;">Registration</h1></td></tr>
<tr><td colspan="3"><hr></hr></td></tr>
<tr><td colspan="3"><p>To register as a new member travel partner, just complate the information required below . Your submition  will be processed for at least 2 business working days upon reciept of this request.</p></td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td><p style="font-style:italic;"><font color="red">* required field</font></p></td></tr>
<?php

$agncNm = array('name' => 'agencyName' , 'value' => $agencyName);
$lglNm =  array('name' => 'name' , 'value' => $legalName);
$first_name = array('name' => 'firstName' , 'value' => $firstName);
$last_name = array('name' => 'lastName' , 'value' => $lastName);
$addrss = array('name' => 'address' , 'value' => $addrss1);
?>
	<tr>
		<td><?php echo form_label('Name of Agency : * ', 'name'); ?></td>
		<td><?php echo form_input($agncNm); ?></td>
		<td style="color: red;"><?php echo form_error($name['name']); ?><?php echo isset($errors[$name['name']])?$errors[$name['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Legal Name of Agency : *', 'legal_name'); ?></td>
		<td><?php echo form_input($lglNm); ?></td>
		<td style="color: red;"><?php echo form_error($legal_name['name']); ?><?php echo isset($errors[$legal_name['name']])?$errors[$legal_name['name']]:''; ?></td>
	</tr>

<tr><td colspan="2"><h1 style="font-size:120%;">Main Contact</h1></td><td colspan="2">
<tr><td colspan="3"><hr></hr></td></tr>

	<tr>
		<td>Title & First/Last Name	: <span style="color: red;" class="required">*</span></td>
		<td colspan="2">
			<select id="salutation" class="salutation" title="Select Salutation" size="1" name="salutation" style="width:8%">
				<?php 
				if($title == 'Mr'){
				?>	
				<option value="Mr" selected="selected">Mr</option>
				<option value="Ms">Ms</option>
				<?php	
				}else{
				?>
				<option value="Mr">Mr</option>
				<option value="Ms" selected="selected" >Ms</option>
				<?php	
				}				
				?>
				
			</select>
			<?php echo form_input($first_name); ?>
			<?php echo form_error($first_name['name']); ?><?php echo isset($errors[$first_name['name']])?$errors[$first_name['name']]:''; ?>
			<?php echo form_input($last_name); ?>
			<?php echo form_error($last_name['name']); ?><?php echo isset($errors[$last_name['name']])?$errors[$last_name['name']]:''; ?>
		</td>
	</tr>
	<tr>
		<td>Address 1	: <span style="color: red;" class="required">*</span></td>
		<td colspan="2">
			<textarea id="address1" font_end_label="Details" title="Enter a Address." rows="10" cols="60" name="address" style="width:40%; height:100px;"><?php echo $addrss1; ?></textarea>
		</td>
	</tr>
	<tr>
		<td>Address 2	: </td>
		<td colspan="2">
			<textarea id="address2" font_end_label="Details" title="Enter a Address." rows="10" cols="60" name="address2" style="width:40%; height:100px;"><?php echo $addrss2; ?></textarea>
		</td>
	</tr>
	<tr>
		<td>City	: <span style="color: red;" class="required">*</span></td>
		<td colspan="2">
			<input type="text" id="city" font_end_label="Details" title="Enter a City." rows="10" cols="60" name="city" style="width:40%; height:30px;" value="<?php echo $city; ?>" />
		</td>
	</tr>
		<td>State/Province	: </td>
		<td colspan="2">
			<input type="text" id="state" font_end_label="Details" title="Enter a State." rows="10" cols="60" name="state" style="width:40%; height:30px;" value="<?php echo $state; ?>" />
		</td>
	</tr>
	<tr>
		<td>Zip Code/ Postal Code	: <span style="color: red;" class="required">*</span></td>
		<td colspan="2">
			<input type="text" id="postcode" font_end_label="Details" title="Enter a Zip Code/ Postal Code." rows="10" cols="60" name="postcode" style="width:40%; height:30px;" value="<?php echo $pstalCode; ?>" />
		</td>
	</tr>
	<tr>
		<td>Country	:	<span style="color: red;" class="required">*</span></td>
		<td>
		<select id="country_id" title="Select Country" size="1" name="country_iso" style="width:40%">
			<option value="">Select Country</option>
			<?php foreach($ar_country as $row) : ?>
				<option value="<?php echo $row->country_iso; ?>" <?php if($row->country_iso == "ID"){echo'selected="selected"';} ?>> <?php echo $row->country_name; ?></option>
			<?php endforeach; ?>
		</select> 
		</td>
	</tr>
	<tr>
		<td>Website	: <span style="color: red;" class="required">*</span></td>
		<td colspan="2">
			<input type="text" id="website" font_end_label="Details" title="Enter a Website." rows="10" cols="60" name="website" style="width:40%; height:30px;" value="<?php echo $web; ?>" />
		</td>
	</tr>
	<tr>
		<td>Phone Number	: </td>
		<td colspan="2">
		<input type="text" id="phone" font_end_label="Details" title="Enter a Phone." rows="10" cols="60" name="phone" maxlength="9" style="width:30%; height:30px;" value="<?php echo $phoneNum; ?>" />
		</td>
	</tr>
	<tr>
		<td>Mobile Number	: </td>
		<td colspan="2">
			<input type="text" id="mobile" font_end_label="Details" title="Enter a Mobile." rows="10" cols="60" name="mobile" maxlength="9" style="width:30%; height:30px;" value="<?php echo $mobile; ?>" />
		</td>
	</tr>
	<tr>
		<td>Fax Number	: </td>
		<td colspan="2">
			<input type="text" id="fax" font_end_label="Details" title="Enter a Fax." rows="10" cols="60" name="fax" maxlength="9" style="width:30%; height:30px;" value="<?php echo $fax; ?>"  />
		</td>
	</tr>
<br/>
<tr><td colspan="3"><h1 style="font-size:120%;">Business Details</h1></td></tr>
<tr><td colspan="3"><hr></hr></td></tr>	
	
	<tr>
		<td>IATA Number	: </td>
		<td colspan="2">
			<input type="text" id="iata" font_end_label="Details" title="Enter a IATA." rows="10" cols="60" name="iata" style="width:40%; height:30px;"  value="<?php echo $iata; ?>"/>
		</td>
	</tr>
	<tr>
	<tr>
		<td>Type of Company	: </td>
		<td colspan="2" style="height:30px;">
			<?php
			switch($coType){
				case 'Sole Proprietor' : $r1 = 'checked="checked"'; $r2 = ''; $r3 = '';break;
				case 'Partnership' : $r1 = ''; $r2 = 'checked="checked"'; $r3 = '';break;
				case 'Corporation' : $r1 = ''; $r2 = ''; $r3 = 'checked="checked"';break;
			}
			 ?>
			<input type="radio" name="company_type" value="Sole Proprietor" rows="10" cols="60" <?php echo $r1; ?> >Sole Proprietor</input>
			<input type="radio" name="company_type" value="Partnership" rows="10" cols="60" <?php echo $r2; ?> >Partnership</input>
			<input type="radio" name="company_type" value="Corporation" rows="10" cols="60" <?php echo $r3; ?> >Corporation</input>
			
		</td>
	</tr>
	<tr>
		<td>Business Type	: </td>
		<td colspan="2" style="height:30px;">
			<?php
			switch($bizType){
				case 'Home-Based' : $p1 = 'checked="checked"'; $p2 = ''; $p3 = '';break;
				case 'Retail' : $p1 = ''; $p2 = 'checked="checked"'; $p3 = '';break;
				case 'Other' : $p1 = ''; $p2 = ''; $p3 = 'checked="checked"';break;
			}
			 ?>
			<input type="radio" name="business_type" value="Home-Based" <?php echo $p1; ?> >Home-Based</input>
			<input type="radio" name="business_type" value="Retail" <?php echo $p2; ?> >Retail</input>
			<input type="radio" name="business_type" value="Other" <?php echo $p3; ?> >Other</input>
		</td>
	</tr>
	<tr>
		<td><?php echo form_label('Years of Operation : '); ?></td>
		<td colspan="2">
			<?php
		
				$options = array(
						  '0'  => 'Select Please',
						  '1'    => '<1',
						  '2'   => '1-2',
						  '3' => '2-5',
						);
				echo form_dropdown('year_oo', $options, $yearOo);
			?>
		</td>
	</tr>
	<tr>
		<td><?php echo form_label('Number of Employess : '); ?></td>
		<td colspan="2">
			<?php
				$options = array(
						  '0'  => 'Select Please',
						  '1'    => '1-10',
						  '2'   => '10-50',
						  '3' => '50-100',
						);
				echo form_dropdown('employess', $options, $employees);
			?>
		</td>
	</tr>
	<tr class="form-row">
		<td >Trade Reg Certificate	: 
        </td>
		<td colspan="2" class="field">
			<input id="Picture" type="file" multiple="multiple" title="Enter Picture of trc." value="" name="trc"></input>
		</td>
	</tr> 
	<tr>
		<td><?php echo form_label('Preferred Payment Mode : '); ?></td>
		<td colspan="2">
			<?php
				$options = array(
						  '0'  => 'Select Please',
						  '1'    => 'Cash',
						  '2'   => 'Credit Card',
						  '3' => 'Visa',
						  '4' => 'Master Card',
						);
				echo form_dropdown('payment_mode', $options, $paymentMode);
			?>
		</td>
	</tr>
	<tr><td colspan="3"><hr></hr></td></tr>
</table>
<center>
<div style="float:right;margin-right:40%;"><?php echo form_submit('register', 'Save'); ?></div>
<br/><br/>
</div><br/>
<?php echo form_close(); ?>