<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Reseller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('members');
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	}
	
	private function _get_currencies_list() 
	{
		$query = $this->db->query('SELECT * FROM currencies');
		return $query->result();
	}
	
	function get_cities($country = null)
	{
		$this->db->select('city_iso, city_name');
		 
		if($country != NULL){
			$this->db->where('country_iso', $country);
		}
		 
		$query = $this->db->get('city');
		 
		$cities = array();
		 
		if($query->result()){
		foreach ($query->result() as $city) {
		$cities[$city->city_iso] = $city->city_name;
		}
			return $cities;
		}else{
			return FALSE;
		}
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
			
	function index()
	{
		$data['ar_currencies'] = $this->_get_currencies_list();
		$data['ar_countries'] = $this->get_countries();
		$data['pagecontent'] = "admin/add_reseller";
		$this->load->vars($data);
		$this->load->view('template');
	}

	function view($success = null)
	{
		//count total rows of reseller list
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
		$data['title'] = 'List reseller';
		$data['text'] = $this->members->view_reseller($config['per_page'],$this->uri->segment(3));
		$data['pagecontent'] = "admin/view_reseller";
		$this->load->vars($data);
		$this->load->view('template');
		
	}
	function details(){
			$data['ar_country'] = $this->_get_country_list();
			$data['pagecontent'] = "admin/view_reseller_detail";
			$this->load->vars($data);
			$this->load->view('template');
	}
    function update(){
    	$getIdUri = $this->uri->uri_to_assoc(3);
		$resellerID = $getIdUri['id']; 
    	//$resellerID = $this->input->post('rsllrID');
    	$agencyName = $this->input->post('agencyName');
		
    	$name = $this->input->post('name');
		$firstName = $this->input->post('firstName');
		$lastName = $this->input->post('lastName');
		$address = $this->input->post('address');
		$address2 = $this->input->post('address2');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$postcode = $this->input->post('postcode');
		$country_iso = $this->input->post('country_iso');
		$website = $this->input->post('website');
		$phone = $this->input->post('phone');
		$mobile = $this->input->post('mobile');
		$fax = $this->input->post('fax');
		$iata = $this->input->post('iata');
		$company_type = $this->input->post('company_type');
		$business_type = $this->input->post('business_type');
		$year_oo = $this->input->post('year_oo');
		$employess = $this->input->post('employess');
		$payment_mode= $this->input->post('payment_mode');
		$title = $this->input->post('salutation');
		
		
		$arrData = array(
			'agency_name' => $agencyName,
			
			'legal_name' => $name,
			'title' => $title,
			'first_name' => $firstName,
			'last_name' => $lastName,
			'address' => $address,
			'address2' => $address2,
			'city' => $city,
			'country' => $country_iso,
			'state' => $state,
			'postcode' => $postcode,
			'website' => $website,
			'phone' => $phone,
			'mobile' => $mobile,
			'fax' => $fax,
			'iata' => $iata,
			'company_type' => $company_type,
			'business_type' => $business_type,
			'year_oo' => $year_oo,
			'employess' => $employess,
			'payment_mode' => $payment_mode,
			 
		);
		
		$this->db->where('users_id', $resellerID);
    	$this->db->update('reseller_profile', $arrData);
		
		redirect('reseller/view/', 'refresh');
    }
	private function _get_country_list()
	{
		$query = $this->db->query('SELECT * FROM country');
		return $query->result();
	}
	function add_reseller()
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
		//	$this->load->view('add_reseller', $error);
			$data['ar_currencies'] = $this->_get_currencies_list();
			$data['pagecontent'] = "admin/add_reseller";
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
			$data['insert'] = $this->members->add_reseller($userid,$nama_file,$file_path);
			$this->load->vars($data);
			if($isi==1)
			{ 
				redirect('reseller/view/s','refresh');
			}elseif($isi==3)
			{
				redirect('reseller','refresh');
			} 
			else{	redirect('reseller/view/s','refresh'); }
		}
	}
	function go()
	{
		$id = $this->uri->segment(3);
		$data['isi']=$this->members->take_data($id);
		$data['ar_country'] = $this->_get_country_list();
		$data['ar_currencies'] = $this->_get_currencies_list();
		$data['pagecontent']='admin/edit_reseller';
		$this->load->vars($data);
		$this->load->view('template');
	}
	function edit()
	{
		if($this->input->post('kode'))
		{
			$data['update']=$this->members->edit_reseller();
			$this->load->vars($data);
			$isi=$this->tank_auth->get_user_role_id();
			if($isi==1)
			{ 
				redirect('reseller/view','refresh');
			}elseif($isi==3)
			{
				redirect('reseller','refresh');
			} 
			else{	redirect('reseller/view','refresh'); }
		}
		else
		{
			$data['pagecontent']='admin/edit_reseller';			
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
			redirect('reseller/view','refresh');
		}elseif($isi==3)
		{
			redirect('reseller','refresh');
		} 
		else {redirect('reseller/view','refresh');}
		
		/* $data['pagecontent']='admin/view_reseller';
		$this->load->vars($data);
		$this->load->view('template'); */
	}

	function activated()
	{
		$id=$_POST['id'];
		$data['isi']=$this->members->activated($id);
		$this->load->vars($data);
		redirect('reseller/view','refresh');
	}
}
?>