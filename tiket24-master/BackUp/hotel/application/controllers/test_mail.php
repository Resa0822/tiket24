<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Test_Mail extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		
    }

    function index()
    {
			// get config data
			$from = $this->config->item('email_address', 'email');
			$from_name = $this->config->item('email_name', 'email');
			$to = 'penerima@localhost.com';
			$to_name = "penerima";
			// we load the email library and send a mail
			$this->load->library('email');
			$this->email->from($from, $from_name);
			$this->email->to($to, $to_name);
			$this->email->subject('Coba email');
			$this->email->message('ini isi coba kiirm imal local');
			$this->email->send();
			//to debug we can use print_debugger()
			echo $this->email->print_debugger();
    }
}
