<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Searchhotel extends CI_Controller {
 
    function __construct() {
        parent::__construct(); 
		$this->load->helper('form');
		$this->load->model('ean_model');
     } 
 
     public function index() {
     	
     	
		$hdrCntntDta['topNavActive'] = 'hotel';
		$lftCntntDta['tabsSearchFlightActive'] = '';
		$lftCntntDta['tabsSearchHotelActive'] = 'class="active"';
		$lftCntntDta['tabsCntntFlightActive'] = 'class="tab-pane fade"';
		$lftCntntDta['tabsCntntHotelActive'] = 'class="tab-pane fade in active"';
		$rghtCntntDta = '';
		$data['footercontent'] = $this->load->view('frontend/footer-content','',true);
		$data['headercontent'] = $this->load->view('frontend/header-content',$hdrCntntDta,true);
		$data['slidercontent'] =  'none';
		$data['rightcontent'] = $this->load->view('frontend/searchhotel-right-content',$rghtCntntDta,true);
		$data['leftcontent'] = $this->load->view('frontend/home-left-content',$lftCntntDta,true);
	    $data['title'] = "Starholiday | Search Hotel";
        $this->load->view('frontend-template', $data);
		
    }
    
	
 
}
