<?php
class Contactus extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	function index() 
	{
	
		$data['pagecontent'] = 'contactus';
		$this->load->view('template', $data);	
	}
	
}

