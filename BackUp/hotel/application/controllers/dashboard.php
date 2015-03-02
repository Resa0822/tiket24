<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Dashboard extends CI_Controller {
 
    function __construct() {
        parent::__construct(); 
     } 
 
     public function index() {
		$hdrCntntDta['topNavActive'] = 'home';
		$data['footercontent'] = $this->load->view('backend/footer-content','',true);
		$data['headercontent'] = $this->load->view('backend/admin/admin-header-content',$hdrCntntDta,true);
		$data['slidercontent'] = 'none';
		$data['rightcontent'] = $this->load->view('backend/admin/admin-right-content','',true);
		$data['leftcontent'] = $this->load->view('backend/admin/admin-left-content','',true);
	    $data['title'] = "Starholiday | Administrator";
        $this->load->view('backend-template', $data);
    }
	
 
}
?>