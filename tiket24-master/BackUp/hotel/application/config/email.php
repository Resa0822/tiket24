<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'localhost';
$config['smtp_port'] = '25';
$config['smtp_user'] = 'webmaster@localhost.com'; // your email
$config['smtp_pass'] = 'webmaster';  // your password
$config['mailtype'] = 'html';
$config['charset'] = 'iso-8859-1';

/*
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_port'] = '25';
$config['smtp_user'] = 'webmaster@localhost.com'; // your email
$config['smtp_pass'] = 'webmaster';  // your password
$config['mailtype'] = 'html';
$config['charset'] = 'iso-8859-1';
*/
/*
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
*/
//$config['charset'] = 'utf-8';$config['charset'] = 'iso-8859-1';

/* End of file email.php */
/* Location: ./application/config/email.php */