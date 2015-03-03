<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<title>Admin Login</title>
		<script src="<?php echo base_url();?>js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo base_url();?>js/global.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo base_url();?>js/modal.js" type="text/javascript" charset="utf-8"></script>

		<script src="<?php echo base_url();?>js/ui/jquery.ui.core.js"></script>
		<script src="<?php echo base_url();?>js/ui/jquery.ui.widget.js"></script>
		<script src="<?php echo base_url();?>js/ui/jquery.ui.datepicker.js"></script>
				
		<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="screen" charset="utf-8" />
	</head>
	<body onload="document.login.login.focus();">
<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 58,
	'class'	=> 'text',
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 58,
	'class'	=> 'text',
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
	'class'	=> 'text',
);
?>
<div style="clear:both;"></div>
		<div id="wrapper_login" align="center" style="margin: 0px auto;">
			<div id="menu">
				<div id="left"></div>
				<div id="right"></div>
				<br /><br />
				<h3><a href="<?php echo base_url() ?>index.php/auth/register">Click here for Sign Up</a></h3>
				<br /><br />
				<h2>Login here !</h2>
				<!--<div class="clear"></div>		-->
			</div>
			<div id="desc">
				<div class="body">
					<div class="col w10 last bottomlast">
						<?php echo form_open($this->uri->uri_string(),'name="login"'); ?>
						<p>
						<table border="0">
						<tr>
							<td style="padding:10px;"><?php echo form_error($login['name']); ?>
							<?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
												
								<?php echo form_label($login_label, $login['id']); ?></td>
							<td style="padding:10px;"><?php echo form_input($login); ?></td>
						</tr>
						<tr>
							<td style="padding:10px;"><?php echo form_error($password['name']); ?>
							<?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
						
								<?php echo form_label('Password', $password['id']); ?></td>
							<td style="padding:10px;"><?php echo form_password($password); ?></td>
						</tr>
						</table>
						</p>							
							
							<?php if ($show_captcha) {
							if ($use_recaptcha) { ?>
							<table>	
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
							</table>
							<?php } else { ?>
							<p>
									Enter the code exactly as it appears:<br>
									<?php echo $captcha_html; ?><br>
							</p>
							<p>
								<?php echo form_label('Confirmation Code', $captcha['id']); ?>
								<?php echo form_input($captcha); ?><br>
								<?php echo form_error($captcha['name']); ?><br>
							</p>
						<?php }
						} ?>
					<table><tr>
						<td><?php echo form_checkbox($remember); ?><td>
						<td style="padding:10px;"><?php echo form_label('Remember me', $remember['id']); ?></td>
						<td style="padding:10px;"><?php echo anchor('/auth/forgot_password/', 'Forgot password'); ?></td> &nbsp;
						<?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); ?>
					</tr></table>

						<p>
							<?php echo form_submit('submit', 'Let me in'); ?> <br/><br/>
							<!-- <a href="" class="button form_submit"><small class="icon play"></small><span>Login</span></a>-->
							<br />
						</p>
							<div class="clear"></div>
						<?php echo form_close(); ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div id="body_footer">
					<div id="bottom_left"><div id="bottom_right"></div></div>
				</div>
			</div>		
		</div>

	</body>
</html>