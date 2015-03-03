<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Voucher extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		
		$this->load->helper('url');
		$this->load->model('booking_model');
		$this->load->database();
	}
	
	function cetak(){
		$urlAddrss = $this->uri->uri_to_assoc(3);
		$trnsctnCode = $urlAddrss['tc'];
		
		$this->db->select('*');
		$this->db->from('book_packages');
		$this->db->join('tours', 'tours.API_packages_id=book_packages.API_packages_id', 'left');
		$this->db->join('tour_type', 'tour_type.code_type=tours.tour_type', 'left');
		$this->db->where('book_packages.transaction_code', $trnsctnCode);
		$qryBkng = $this->db->get();
		$isWahana = array();
		foreach($qryBkng->result() as $fldBkng){
			$pckgID = $fldBkng->API_packages_id;
			$tourType = $fldBkng->tour_type;
			$tCode = $fldBkng->transaction_code;
			$isWahana[] = $fldBkng->isWahana;
		}
	 
		/* cek tour type untuk cetak vocher berdasar tour type 
		 * 141 -> universal studio
		 * 211 -> sunway lagoon
		 * */
	/*
		if (in_array("1", $isWahana)) {
	        $dta['trnsctnCode'] = $tCode;
			$data['voucherTemplate'] = $this->load->view('voucher_attraction', $dta);	
			$this->load->view('cetak_voucher', $data);	
		}
		else{
		
			*/
			 
			$this->load->view('cetak_voucher');	
		
		
	}
	
	function themepark(){
		$this->load->view('voucherTP');
	}
	function nonthemepark(){
		$this->load->view('voucherNTP');
	}
	
	function generateBarcode($kode){
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		$test = Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());
		//var_dump($test);
		$gmbrBarcode = imagejpeg($test, 'barcode.jpg', 100);
		//$barcode = '<img src="'.base_url().'voucher/generateBarcode/'.$kode.'" />';
	}
	
	
}
?>