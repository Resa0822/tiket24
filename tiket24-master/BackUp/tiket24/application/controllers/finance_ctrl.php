<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Finance_ctrl extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('tank_auth');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('finance');
	}	
	function get_countries() 
	{
		$this->db->select('country_iso, country_name');
		$query = $this->db->get('country');
		 
		$countries = array();
		 
		if ($query -> result()) {
		foreach ($query->result() as $country) {
		$countries[$country->country_iso] = $country->country_name;
		}
			return $countries;
		} else {
			return FALSE;
		}
	}
	function get_paymethod() 
	{
		$this->db->select('metode_id, nama_metode');
		$query = $this->db->get('metode_pembayaran');
		 
		$paymethod = array();
		 
		if ($query -> result()) {
		foreach ($query->result() as $method) {
		$paymethod[$method->metode_id] = $method->nama_metode;
		}
			return $paymethod;
		} else {
			return FALSE;
		}
	}
	function payment_setting() {
		if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } elseif ($this->tank_auth->get_user_role_id() != 1) {
			redirect('');
		} else {
        	$data = array();
        	$data['message'] = '';
        	
        	if ($this->input->post('submit')) {
        		$this->form_validation->set_rules('CardType', 'Card Type', 'required|xss_clean');
        		$this->form_validation->set_rules('CardHolderName', 'Card Holder Name', 'required|xss_clean');
         		$this->form_validation->set_rules('BankName', 'Bank Name', 'required|xss_clean');
         		$this->form_validation->set_rules('CardCountryCode', 'Card Country Code', 'required|xss_clean');
				$this->form_validation->set_rules('CardNumber', 'Card Number', 'required|is_natural|xss_clean');
				$this->form_validation->set_rules('CardSecurityCode', 'Card Security Code', 'required|is_natural|xss_clean');
				$this->form_validation->set_rules('CardExpiryDate', 'Card ExpiryD ate', 'required|xss_clean');
				$this->form_validation->set_rules('CardContactNumber', 'Card Contact Number', 'required|is_natural|xss_clean');
				$this->form_validation->set_rules('CardAddress', 'Card Address', 'required|xss_clean');
				$this->form_validation->set_rules('CardAddressPostalCode', 'Card Address Postal Code', 'required|xss_clean');
				$this->form_validation->set_rules('CardAddressCity', 'Card Address City', 'required|xss_clean');
				$this->form_validation->set_rules('CardAddressCountryCode', 'Card Address Country Code', 'required|xss_clean');
       		
        		if ($this->form_validation->run()) {
        			$this->finance->update_payment('1', array('isi'=>$this->form_validation->set_value('CardType')));
        			$this->finance->update_payment('2', array('isi'=>$this->form_validation->set_value('CardHolderName')));
        			$this->finance->update_payment('3', array('isi'=>$this->form_validation->set_value('BankName')));
        			$this->finance->update_payment('4', array('isi'=>$this->form_validation->set_value('CardCountryCode')));
        			$this->finance->update_payment('5', array('isi'=>$this->form_validation->set_value('CardNumber')));
        			$this->finance->update_payment('6', array('isi'=>$this->form_validation->set_value('CardSecurityCode')));
        			$this->finance->update_payment('7', array('isi'=>$this->form_validation->set_value('CardExpiryDate')));
        			$this->finance->update_payment('8', array('isi'=>$this->form_validation->set_value('CardContactNumber')));
        			$this->finance->update_payment('9', array('isi'=>$this->form_validation->set_value('CardAddress')));
        			$this->finance->update_payment('10', array('isi'=>$this->form_validation->set_value('CardAddressPostalCode')));
        			$this->finance->update_payment('11', array('isi'=>$this->form_validation->set_value('CardAddressCity')));
        			$this->finance->update_payment('12', array('isi'=>$this->form_validation->set_value('CardAddressCountryCode')));
        			
        			$data['message'] = 'Data is successfully saved.';
        			
        		}
        	}
        	
        	$data['CardType'] = $this->finance->get_payment(1);
        	$data['CardHolderName'] = $this->finance->get_payment(2);
        	$data['BankName'] = $this->finance->get_payment(3);
         	$data['CardCountryCode'] = $this->finance->get_payment(4);
         	$data['CardNumber'] = $this->finance->get_payment(5);
         	$data['CardSecurityCode'] = $this->finance->get_payment(6);
         	$data['CardExpiryDate'] = $this->finance->get_payment(7);
         	$data['CardContactNumber'] = $this->finance->get_payment(8);
         	$data['CardAddress'] = $this->finance->get_payment(9);
         	$data['CardAddressPostalCode'] = $this->finance->get_payment(10);
         	$data['CardAddressCity'] = $this->finance->get_payment(11);
         	$data['CardAddressCountryCode'] = $this->finance->get_payment(12);
       	
			$data['ar_countries'] = $this->get_countries();
			$data['ar_paymethod'] = $this->get_paymethod();
           /*  $data_cont['pagecontent'] = $this->load->view("config/payment_setting", $data, true);

            $this->load->view('template', $data_cont); */
			
			$data_cont['pagecontent']='config/payment_setting';
			$this->load->vars($data);
			$this->load->view('template', $data_cont);
		}
	}
	
	function point_setting() {
		if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } elseif ($this->tank_auth->get_user_role_id() != 1) {
			redirect('');
		} else {
        	$data = array();
        	$data['message'] = '';
        	
        	if ($this->input->post('submit')) {
        		$this->form_validation->set_rules('MinimalBeli', 'Minimal Beli', 'required|xss_clean');
        		$this->form_validation->set_rules('NominalBeli', 'Card Holder Name', 'required|xss_clean');
         		$this->form_validation->set_rules('PointBeli', 'Point Beli', 'required|xss_clean');
         		$this->form_validation->set_rules('MinimalPoint', 'Minimal Point', 'required|xss_clean');
				$this->form_validation->set_rules('PointTukar', 'Point Tukar', 'required|xss_clean');
				$this->form_validation->set_rules('NominalBayar', 'Nominal Bayar', 'required|xss_clean');
				$this->form_validation->set_rules('MinimalBeliReseller', 'Minimal Beli Reseller', 'required|xss_clean');
				$this->form_validation->set_rules('NominalBeliReseller', 'Nominal Beli Reseller', 'required|xss_clean');
				$this->form_validation->set_rules('PointBeliReseller', 'Point Beli Reseller', 'required|xss_clean');
				$this->form_validation->set_rules('MinimalPointReseller', 'Minimal Point Reseller', 'required|xss_clean');
				$this->form_validation->set_rules('PointTukarReseller', 'Point Tukar Reseller', 'required|xss_clean');
				$this->form_validation->set_rules('NominalBayarReseller', 'Nominal Bayar Reseller', 'required|xss_clean');
       		echo $this->form_validation->set_value('MinimalBeli');
       		echo str_replace(',', '.', str_replace('.', '', $this->form_validation->set_value('MinimalBeli')));
        		if ($this->form_validation->run()) {
        			$this->finance->update_point('13', array('content'=>str_replace(',', '.', str_replace('.', '', $this->form_validation->set_value('MinimalBeli')))));
        			$this->finance->update_point('14', array('content'=>str_replace(',', '.', str_replace('.', '', $this->form_validation->set_value('NominalBeli')))));
        			$this->finance->update_point('15', array('content'=>$this->form_validation->set_value('PointBeli')));
        			$this->finance->update_point('16', array('content'=>str_replace(',', '.', str_replace('.', '', $this->form_validation->set_value('MinimalPoint')))));
        			$this->finance->update_point('17', array('content'=>$this->form_validation->set_value('PointTukar')));
        			$this->finance->update_point('18', array('content'=>str_replace(',', '.', str_replace('.', '', $this->form_validation->set_value('NominalBayar')))));
        			$this->finance->update_point('19', array('content'=>str_replace(',', '.', str_replace('.', '', $this->form_validation->set_value('MinimalBeliReseller')))));
        			$this->finance->update_point('20', array('content'=>str_replace(',', '.', str_replace('.', '', $this->form_validation->set_value('NominalBeliReseller')))));
        			$this->finance->update_point('21', array('content'=>$this->form_validation->set_value('PointBeliReseller')));
        			$this->finance->update_point('22', array('content'=>str_replace(',', '.', str_replace('.', '', $this->form_validation->set_value('MinimalPointReseller')))));
        			$this->finance->update_point('23', array('content'=>$this->form_validation->set_value('PointTukarReseller')));
        			$this->finance->update_point('24', array('content'=>str_replace(',', '.', str_replace('.', '', $this->form_validation->set_value('NominalBayarReseller')))));
        			
        			$data['message'] = 'Data is successfully saved.';
        			
        		}
        	}
        	
        	$data['MinimalBeli'] = $this->finance->get_point(13);
        	$data['NominalBeli'] = $this->finance->get_point(14);
        	$data['PointBeli'] = $this->finance->get_point(15);
         	$data['MinimalPoint'] = $this->finance->get_point(16);
         	$data['PointTukar'] = $this->finance->get_point(17);
         	$data['NominalBayar'] = $this->finance->get_point(18);
         	$data['MinimalBeliReseller'] = $this->finance->get_point(19);
         	$data['NominalBeliReseller'] = $this->finance->get_point(20);
         	$data['PointBeliReseller'] = $this->finance->get_point(21);
         	$data['MinimalPointReseller'] = $this->finance->get_point(22);
         	$data['PointTukarReseller'] = $this->finance->get_point(23);
         	$data['NominalBayarReseller'] = $this->finance->get_point(24);
       	
		/*	$data['ar_countries'] = $this->get_countries();
			$data['ar_paymethod'] = $this->get_paymethod();
            $data_cont['pagecontent'] = $this->load->view("config/point_setting", $data, true);

            $this->load->view('template', $data_cont); */
			
			$data_cont['pagecontent']='config/point_setting';
			$this->load->vars($data);
			$this->load->view('template', $data_cont);
		}
	}
	
	
	// For Reseller Payment
	
	function reseller_payment()
	{
		if (!$this->tank_auth->is_logged_in()) {
				redirect('/auth/login/');
		} elseif ($this->tank_auth->get_user_role_id() != 3) {
			redirect('');
		} else {
			$data = array();
			$data['message'] = '';
			
			$rows = $this->finance->get_payment_reseller($this->tank_auth->get_user_id());

				
				if ($this->input->post('submit')) {
					$this->form_validation->set_rules('CardType', 'Card Type', 'required|xss_clean');
					$this->form_validation->set_rules('CardHolderName', 'Card Holder Name', 'required|xss_clean');
					$this->form_validation->set_rules('BankName', 'Bank Name', 'required|xss_clean');
					$this->form_validation->set_rules('CardCountryCode', 'Card Country Code', 'required|xss_clean');
					$this->form_validation->set_rules('CardNumber', 'Card Number', 'required|is_natural|xss_clean');
					$this->form_validation->set_rules('CardSecurityCode', 'Card Security Code', 'required|xss_clean');
					$this->form_validation->set_rules('CardExpiryDate', 'Card ExpiryD ate', 'required|xss_clean');
					$this->form_validation->set_rules('CardContactNumber', 'Card Contact Number', 'required|is_natural|xss_clean');
					$this->form_validation->set_rules('CardAddress', 'Card Address', 'required|xss_clean');
					$this->form_validation->set_rules('CardAddressPostalCode', 'Card Address Postal Code', 'required|xss_clean');
					$this->form_validation->set_rules('CardAddressCity', 'Card Address City', 'required|xss_clean');
					$this->form_validation->set_rules('CardAddressCountryCode', 'Card Address Country Code', 'required|xss_clean');
				
					if ($this->form_validation->run()) {
						$datas['cardtype'] = $this->form_validation->set_value('CardType');
						$datas['cardholdername'] = $this->form_validation->set_value('CardHolderName');
						$datas['bankname'] = $this->form_validation->set_value('BankName');
						$datas['cardcountrycode'] = $this->form_validation->set_value('CardCountryCode');
						$datas['cardnumber'] = $this->form_validation->set_value('CardNumber');
						$datas['cardsecuritycode'] = $this->form_validation->set_value('CardSecurityCode');
						$datas['cardexpirydate'] = $this->form_validation->set_value('CardExpiryDate');
						$datas['cardcontactnumber'] = $this->form_validation->set_value('CardContactNumber');
						$datas['cardaddress'] = $this->form_validation->set_value('CardAddress');
						$datas['cardaddresspostalcode'] = $this->form_validation->set_value('CardAddressPostalCode');
						$datas['cardaddresscity'] = $this->form_validation->set_value('CardAddressCity');
						$datas['cardaddresscountrycode'] = $this->form_validation->set_value('CardAddressCountryCode');
						$datas['users_id'] = $this->tank_auth->get_user_id();
					
					if ($rows == null) {
						$data['insert'] = $this->finance->create_payment($datas);
        			}else{
						$data['update'] = $this->finance->update_payment_reseller($this->tank_auth->get_user_id(),$datas);
					}
        			$data['message'] = 'Data is successfully saved.';
        			
					}
				}
			if ($rows != null) {
				$data['CardType'] = $rows->cardtype;
				$data['CardHolderName'] = $rows->cardholdername;
				$data['BankName'] = $rows->bankname;
				$data['CardCountryCode'] = $rows->cardcountrycode;
				$data['CardNumber'] = $rows->cardnumber;
				$data['CardSecurityCode'] = $rows->cardsecuritycode;
				$data['CardExpiryDate'] = $rows->cardexpirydate;
				$data['CardContactNumber'] = $rows->cardcontactnumber;
				$data['CardAddress'] = $rows->cardaddress;
				$data['CardAddressPostalCode'] = $rows->cardaddresspostalcode;
				$data['CardAddressCity'] = $rows->cardaddresscity;
				$data['CardAddressCountryCode'] = $rows->cardaddresscountrycode;
			}else{
				$data['CardType'] = "";
				$data['CardHolderName'] = "";
				$data['BankName'] = "";
				$data['CardCountryCode'] = "ID";
				$data['CardNumber'] = "";
				$data['CardSecurityCode'] = "";
				$data['CardExpiryDate'] = "";
				$data['CardContactNumber'] = "";
				$data['CardAddress'] = "";
				$data['CardAddressPostalCode'] = "";
				$data['CardAddressCity'] = "";
				$data['CardAddressCountryCode'] = "ID";
			}
				
			$data['ar_countries'] = $this->get_countries();
			$data['ar_paymethod'] = $this->get_paymethod();
			$data['pagecontent'] = "admin/add_payment";
			$this->load->vars($data);
			$this->load->view('template');
		}
	}

	function view($success = null)
	{
		//count total rows of payment list
		$config['base_url'] = base_url().'index.php/reseller/view';
		$config['total_rows'] = $this->db->count_all('reseller_profile');
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['num_links'] = 1;
		$config['full_tag_open'] = '<li >';
		$config['full_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li class="k-link k-pager-nav k-state-disabled" title="Go to the previous page">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li class="k-link k-pager-nav k-state-disabled" title="Go to the next page">';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li style="float: left;" class="k-link k-pager-nav k-state-disabled k-state-selected"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="k-link k-pager-nav k-state-disabled k-pager-numbers k-reset">';
		$config['num_tag_close'] = '</li>';
		 
		$config['first_tag_open'] = '<li class="k-link k-pager-nav k-pager-first k-state-disabled" title="Go to the first page">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="k-link k-pager-nav k-pager-last k-state-disabled" title="Go to the last page">';
		$config['last_tag_close'] = '</li>';
		 
		$config['first_link'] = '&lt;&lt;';
		$config['last_link'] = '&gt;&gt;';
		
		$this->pagination->initialize($config);
		if($success == "s"){
			$data['message'] = "Data Saved.";
		} else { $data['message'] = ""; }
		$data['total_rows'] = $config['total_rows'] ;
		$data['title'] = 'List payment';
		$data['text'] = $this->members->view_payment($config['per_page'],$this->uri->segment(3));
		$data['pagecontent'] = "admin/view_payment";
		$this->load->vars($data);
		$this->load->view('template');
		
	}
	function add_payment()
	{
		$config['upload_path'] = './asset/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '1000';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
		
		$this->load->library('upload',$config);
		$this->upload->initialize($config);
		
		if (!$this->upload->do_upload('gambar'))
		{
		
		// return the error message and kill the script
        //echo $this->upload->display_errors(); die();

        //$this->data['error'] = array('error' => $this->upload->display_errors());
         
			$error = array('error' => $this->upload->display_errors());
		//	$this->load->view('add_payment', $error);
			$data['ar_currencies'] = $this->_get_currencies_list();
			$data['pagecontent'] = "admin/add_payment";
			$this->load->vars($data);
		//	$this->load->vars($error);
			$this->load->view('template');
		}
		else
		{
			$doc = $this->upload->data();
			$nama_file = $doc['file_name'];
			$file_path = $doc['full_path'];
			$isi=$this->tank_auth->get_user_role_id();
			$userid='';
			if($isi==3)
			{
				$userid=$this->tank_auth->get_user_id();
			}else
			{
				$userid='';
			}
			$data['insert'] = $this->members->add_payment($userid,$nama_file,$file_path);
			$this->load->vars($data);
			if($isi==1)
			{ 
				redirect('payment/view/s','refresh');
			}elseif($isi==3)
			{
				redirect('payment','refresh');
			} 
			else{	redirect('payment/view/s','refresh'); }
		}
	}
	function go()
	{
		$id = $this->uri->segment(3);
		$data['isi']=$this->members->take_data($id);
		$data['ar_country'] = $this->_get_country_list();
		$data['ar_currencies'] = $this->_get_currencies_list();
		$data['pagecontent']='admin/edit_payment';
		$this->load->vars($data);
		$this->load->view('template');
	}
	function edit()
	{
		if($this->input->post('kode'))
		{
			$data['update']=$this->members->edit_payment();
			$this->load->vars($data);
			$isi=$this->tank_auth->get_user_role_id();
			if($isi==1)
			{ 
				redirect('payment/view','refresh');
			}elseif($isi==3)
			{
				redirect('payment','refresh');
			} 
			else{	redirect('payment/view','refresh'); }
		}
		else
		{
			$data['pagecontent']='admin/edit_payment';			
			$this->load->vars($data);
			$this->load->view('template');
		}
	}
	function delete()
	{
		if($this->uri->segment(3)=='delete success')
		{
			$data['message']='Data Berhasil Di Hapus';
		}
		else
		{
			$data['message']='';
		}
		
		$data['isi']=$this->members->delete();
		$this->load->vars($data);
		$isi=$this->tank_auth->get_user_role_id();
		if($isi==1)
		{ 
			redirect('payment/view','refresh');
		}elseif($isi==3)
		{
			redirect('payment','refresh');
		} 
		else {redirect('payment/view','refresh');}
		
		/* $data['pagecontent']='admin/view_payment';
		$this->load->vars($data);
		$this->load->view('template'); */
	}
	
}
