<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
}
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
	'value'	=> 2,
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
	'size'	=> 30,
);
$last_name = array(
	'name'	=> 'last_name',
	'id'	=> 'last_name',
	'value'	=> set_value('last_name'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
?>
<script>
	function showT(c,f){
	sliderValue.style.visibility="hidden"}
</script>
<?php echo form_open($this->uri->uri_string()); ?>
<div>
<br/>
<div style="clear:both;"/>
<center>
<table>
<tr><td><h2>Login Detail</h2></td></tr>
<tr><td colspan="2"><hr></hr></td></tr>

	<?php if ($use_username) { ?>
	<tr>
		<td><?php echo form_label('Username : * &nbsp;', $username['id']); ?></td>
		<td><?php echo form_input($username); ?></td>
		<td style="color: red;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td><?php echo form_label('Email Address : * &nbsp;', $email['id']); ?></td>
		<td><?php echo form_input($email); ?></td>
		<td style="color: red;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Password : * &nbsp;', $password['id']); ?></td>
		<td><?php echo form_password($password); ?></td>
		<td style="color: red;"><?php echo form_error($password['name']); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Confirm Password : * &nbsp;', $confirm_password['id']); ?></td>
		<td><?php echo form_password($confirm_password); ?></td>
		<td style="color: red;"><?php echo form_error($confirm_password['name']); ?></td>
	</tr>
	<?php echo form_hidden('role_id',2); ?>

	<?php if ($captcha_registration) {
		if ($use_recaptcha) { ?>
	<tr>
		<td colspan="2">
			<div id="recaptcha_image"></div>
		</td>
		<td>
			<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
			<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="recaptcha_only_if_image">Enter the words above</div>
			<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
		</td>
		<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
		<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
		<?php echo $recaptcha_html; ?>
	</tr>
	<?php } else { ?>
	<tr>
		<td colspan="2">
			<p>Enter the code exactly as it appears:</p>
			<?php echo $captcha_html; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
		<td><?php echo form_input($captcha); ?></td>
		<td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
	</tr>
	<?php }
	} ?>
<br/>
<tr><td><h2>Contact Detail</h2></td></tr>
<tr><td colspan="2"><hr></hr></td></tr>

	<tr>
		<td>Salutation	:	</td>
		<td>
		<select id="salutation" class="salutation" title="Select Salutation" size="1" name="salutation" style="width:20%">
			<option value="Mr">Mr</option>
			<option value="Ms">Ms</option>
		</select>
		</td>
	</tr>
	<tr>
		<td><?php echo form_label('First Name : *', 'first_name'); ?></td>
		<td><?php echo form_input('first_name'); ?></td>
		<td style="color: red;"><?php echo form_error($first_name['name']); ?><?php echo isset($errors[$first_name['name']])?$errors[$first_name['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Last Name : *', 'last_name'); ?></td>
		<td><?php echo form_input('last_name'); ?></td>
		<td style="color: red;"><?php echo form_error($last_name['name']); ?><?php echo isset($errors[$last_name['name']])?$errors[$last_name['name']]:''; ?></td>
	</tr>
	<tr>
		<td>Nationality	:	<span class="required">*</span></td>
		<td>
		<select id="nationality_id" class="nationality_id" title="Select Nationality" size="1" name="nationality" style="width:50%">
			<?php foreach($ar_country as $row) : ?>
				<option value="<?php echo $row->country_iso; ?>" <?php if($row->country_iso == "ID"){echo'selected="selected"';} ?>> <?php echo $row->country_name; ?></option>
			<?php endforeach; ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Date of Birth	: </td>
		<td>
			<input type="text" placeholder="Pickup Date" class="datepicker" id="dob" font_end_label="Details" title="Enter a Date of Birth." rows="15" cols="60" name="dob" style="width:50%; height:30%;" />
		</td>
	</tr>
	<tr>
		<td>Address	: </td>
		<td>
			<textarea id="address" font_end_label="Details" title="Enter a Address." rows="10" cols="60" name="address" style="width:80%; height:100px;"></textarea>
		</td>
	</tr>
	<tr>
		<td>City	: </td>
		<td>
			<input type="text" id="city" font_end_label="Details" title="Enter a City." rows="10" cols="60" name="city" style="width:80%; height:30%;" />
		</td>
	</tr>
	<tr>
		<td>Zip Code/ Postal Code	: &nbsp;</td>
		<td>
			<input type="text" id="postcode" font_end_label="Details" title="Enter a Zip Code/ Postal Code." rows="10" cols="60" name="postcode" style="width:80%; height:30%;" />
		</td>
	</tr>
	<tr>
		<td>Country	:	<span class="required">*</span></td>
		<td>
		<select id="country_id" class="country_id" title="Select Country" size="1" name="negara" style="width:50%">
			<?php foreach($ar_country as $row) : ?>
				<option value="<?php echo $row->country_iso; ?>" <?php if($row->country_iso == "ID"){echo'selected="selected"';} ?>> <?php echo $row->country_name; ?></option>
			<?php endforeach; ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Phone	: <span class="required">*</span></td>
		<td>
			<input type="text" id="phone" font_end_label="Details" title="Enter a Phone." rows="10" cols="60" name="phone" style="width:80%; height:30%;" />
		</td>
	</tr>
	<tr>
		<td>Mobile	: </td>
		<td>
			<input type="text" id="mobile" font_end_label="Details" title="Enter a Mobile." rows="10" cols="60" name="mobile" style="width:80%; height:30%;" />
		</td>
	</tr>
	<tr><td colspan="2"><hr></hr></td></tr>
	<tr>
        <td colspan="2" align="center">
            <input name="conditions" type="checkbox">
			<span>I accept the tiket24.com Membership</span>  
				<a href="#" onclick="popNewWindow('../Member/TermsNConditionsWindow.aspx?trck=hp,&amp;sid=1000')">
			<span>Terms and Conditions</span></a>                          
            <span class="errMsg"> *</span>
			<span class="errMsg" style="color:Red;visibility:hidden;">Please click the Terms and Conditions check box.</span>                            
        </td>
    </tr>
</table>
<center>
<div style="float:right;margin-right:30%;"><?php echo form_submit('register', 'Register'); ?></div>
<br/><br/>
</div><br/>
<?php echo form_close(); ?>