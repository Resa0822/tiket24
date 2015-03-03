<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'class' => 'form-control',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'class' => 'form-control',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'class' => 'form-control',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'class' => 'form-control',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'class' => 'form-control',
	'maxlength'	=> 8,
);
?>
<div class="panel panel-primary costumpanel boxshadow" >
    <div class="panel-heading costum_panel_head" style="background:#1792bc">
        <h3 class="panel-title"><b>Sign Up</b></h3>
    </div>
    <div class="panel-body">
    
  
<?php echo form_open($this->uri->uri_string()); ?>
<table width="100%" border="1" class="tableFormSignup">
	<?php if ($use_username) { ?>
    <tr>
    <td colspan="2"><?php echo form_error($username['name'], '<div class="alert alert-danger" role="alert" style="margin:0px;padding:5px;"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;', '</div>'); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></td>
    </tr>
	<tr>
		<td><?php echo form_label('Username', $username['id']); ?></td>
		<td><?php echo form_input($username); ?></td>
	</tr>
	<?php } ?>
    <tr><td colspan="2"><?php echo form_error($email['name'], '<div class="alert alert-danger" role="alert" style="margin:0px;padding:5px;"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;', '</div>'); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></td>
    </tr>
	<tr>
		<td><?php echo form_label('Email Address', $email['id']); ?></td>
		<td><?php echo form_input($email); ?></td>
	</tr>
    <tr><td colspan="2"><?php echo form_error($password['name'], '<div class="alert alert-danger" role="alert" style="margin:0px;padding:5px;"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;', '</div>'); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></td>
    </tr>
	<tr>
		<td><?php echo form_label('Password', $password['id']); ?></td>
		<td><?php echo form_password($password); ?></td>
		
	</tr>
    <tr><td colspan="2"><?php echo form_error($confirm_password['name'], '<div class="alert alert-danger" role="alert" style="margin:0px;padding:5px;"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;', '</div>'); ?><?php echo isset($errors[$confirm_password['name']])?$errors[$confirm_password['name']]:''; ?></td>
    </tr>
	<tr>
		<td><?php echo form_label('Confirm Password', $confirm_password['id']); ?></td>
		<td><?php echo form_password($confirm_password); ?></td>
	</tr>
    <tr>
		<td>&nbsp;</td>
		<td>
        <?php if ($captcha_registration) {
		if ($use_recaptcha) { ?>
        <table>
        	<tr>
            	<td colspan="2"><div id="recaptcha_image"></div></td>
                <td>
                    <a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
                    <div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
                    <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
                </td>
            </tr>
            <tr><td colspan="2"><?php echo form_error('recaptcha_response_field', '<div class="alert alert-danger" role="alert" style="margin:0px;padding:5px;"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;', '</div>'); ?><?php echo isset($errors['recaptcha_response_field'])?$errors['recaptcha_response_field']:''; ?></td>
    		</tr>
            <tr>
                <td>
                    <div class="recaptcha_only_if_image">Enter the words above</div>
                    <div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
                </td>
                <td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
                <?php echo $recaptcha_html; ?>
			</tr>
        </table>
        <?php } else { ?>
        <table>
             <tr><td ><?php echo form_error($captcha['name'], '<div class="alert alert-danger" role="alert" style="margin:0px;padding:5px;"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;', '</div>'); ?><?php echo isset($errors[$captcha['name']])?$errors[$captcha['name']]:''; ?></td>
            </tr>
        	<tr>
                <td>
                    <div>Enter the code exactly as it appears :</div>
                    <div><?php echo $captcha_html; ?></div>
                    <div><?php echo form_input($captcha); ?></div>
                </td>
            </tr>
        </table>
        <?php }
		} ?>
        </td>
	</tr>
    <tr>
    <td>&nbsp;</td>
    <td><?php echo form_submit('register', 'Register', 'class="btn btn-primary"'); ?></td>
    </tr>
</table>
<?php echo form_close(); ?>


    </div>
</div>
 