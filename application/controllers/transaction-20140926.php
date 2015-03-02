<?php
class Transaction extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->model('transaction_model');
		$this->load->model('get_api');
                $this->load->model('finance');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$mailconfig = Array(
					//‘protocol’ => ‘smtp’,
					//‘smtp_host’ => ‘http://example.com’,
					//‘smtp_port’ => 25,
					//‘smtp_user’ => ‘info@example.com’,
					//‘smtp_pass’ => ‘xxxxxx’,
					'mailtype'  => 'html',
					//‘charset’  => ‘iso-8859-1’
				);
		$this->load->library('email', $mailconfig);
	}
	private function _get_users_id() 
	{
		$users = $this->tank_auth->get_username();
		$query = $this->db->query("SELECT users_id FROM users WHERE username = '".$users."'");
		$rows = $query->row();
		if($query->num_rows() > 0)
			return $rows->users_id;
		else
			return null;
		
	}
	private function _get_country_list() 
	{
		$query = $this->db->query('SELECT * FROM country');
		return $query->result();
	}
	private function _get_packages_by_id($id) 
	{
		$query = $this->db->query("SELECT * FROM packages WHERE packages_id = '".$id."'");
		return $query->row();
	}
	
	function point_by_period(){
		if ($this->tank_auth->is_logged_in()) {
		$users = $this->_get_users_id();
	    $firstPeriod =$this->input->post('firstPeriod');
		$lastPeriod = $this->input->post('lastPeriod');
		
			//count total rows of transaction list
			
			 $this->db->select('*');
			 $this->db->where('user_id', $users);
			 $this->db->where('booking_date >=', $firstPeriod);
			 $this->db->where('booking_date <=', $lastPeriod);
			 $this->db->order_by('booking_date', 'asc');
			 $qryGetJmldta = $this->db->get('book_packages');
		    //$this->db->limit(10);
			$config['base_url'] = base_url().'index.php/transaction/view';
			$config['total_rows'] =  $qryGetJmldta->num_rows();
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
		//	$data['pagination'] = $this->pagination->create_links();
			
			$data['total_rows'] = $config['total_rows'] ;
			$data['title'] = 'Point History By Period';
			$data['rprtPrd'] = $firstPeriod.'to'.$lastPeriod;
			$data['periode'] = ' <b>From </b>'.$firstPeriod.' <b>to</b> '.$lastPeriod;
			$data['text'] = $this->transaction_model->point_report_by_period($config['per_page'],$this->uri->segment(3),$users,$firstPeriod,$lastPeriod);
			$data['pagecontent'] = "user/point_by_period";
			$this->load->vars($data);
			$this->load->view('template');
		}
		else{
			$url = base_url();
			redirect($url, 'refresh');
		}
	}
	function all_report_by_period(){
		if ($this->tank_auth->is_logged_in()) {
		$users = $this->_get_users_id();
	    $firstPeriod =$this->input->post('firstPeriod');
		$lastPeriod = $this->input->post('lastPeriod');
		
			//count total rows of transaction list
			
			 $this->db->select('*');
			 //$this->db->where('user_id', $users);
			
			 $this->db->where('booking_date >=', $firstPeriod);
			 $this->db->where('booking_date <=', $lastPeriod);
			 $this->db->order_by('booking_date', 'asc');
			 $qryGetJmldta = $this->db->get('book_packages');
		    //$this->db->limit(10);
			$config['base_url'] = base_url().'index.php/transaction/view';
			$config['total_rows'] =  $qryGetJmldta->num_rows();
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
		//	$data['pagination'] = $this->pagination->create_links();
			
			$data['total_rows'] = $config['total_rows'] ;
			$data['title'] = 'Booking History By Period';
			$data['rprtPrd'] = $firstPeriod.'to'.$lastPeriod;
			$data['periode'] = ' <b>From </b>'.$firstPeriod.' <b>to</b> '.$lastPeriod;
			$data['text'] = $this->transaction_model->all_booking_report_by_period($config['per_page'],$this->uri->segment(3),$users,$firstPeriod,$lastPeriod);
			$data['pagecontent'] = "admin/all_report_by_period";
			$this->load->vars($data);
			$this->load->view('template');
		}
		else{
			$url = base_url();
			redirect($url, 'refresh');
		}
	}
	function report_by_period(){
		if ($this->tank_auth->is_logged_in()) {
		$users = $this->_get_users_id();
	    $firstPeriod =$this->input->post('firstPeriod');
		$lastPeriod = $this->input->post('lastPeriod');
		
			//count total rows of transaction list
			
			 $this->db->select('*');
			 $this->db->where('user_id', $users);
			
			 $this->db->where('booking_date >=', $firstPeriod);
			 $this->db->where('booking_date <=', $lastPeriod);
			 $this->db->order_by('booking_date', 'asc');
			 $qryGetJmldta = $this->db->get('book_packages');
		    //$this->db->limit(10);
			$config['base_url'] = base_url().'index.php/transaction/view';
			$config['total_rows'] =  $qryGetJmldta->num_rows();
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
		//	$data['pagination'] = $this->pagination->create_links();
			
			$data['total_rows'] = $config['total_rows'] ;
			$data['title'] = 'Booking History By Period';
			$data['rprtPrd'] = $firstPeriod.'to'.$lastPeriod;
			$data['periode'] = ' <b>From </b>'.$firstPeriod.' <b>to</b> '.$lastPeriod;
			$data['text'] = $this->transaction_model->booking_report_by_period($config['per_page'],$this->uri->segment(3),$users,$firstPeriod,$lastPeriod);
			$data['pagecontent'] = "user/report_by_period";
			$this->load->vars($data);
			$this->load->view('template');
		}
		else{
			$url = base_url();
			redirect($url, 'refresh');
		}
	}
	
	function point(){
		if ($this->tank_auth->is_logged_in()) {
			if($this->tank_auth->get_user_role_id() == 1){
				$users = null;
				$qryGetBkngNfo = $this->db->select('*')
				->from('book_packages')
				->get();
				$jmlDta = $qryGetBkngNfo->num_rows();
			}else{
				$users = $this->_get_users_id();
				$qryGetBkngNfo = $this->db->select('*')
				->from('book_packages')
				->where('user_id',$users)
				->get();
				$jmlDta = $qryGetBkngNfo->num_rows();
				
			}
			//count total rows of transaction list
			
		//	$this->db->limit(10);
			$config['base_url'] = base_url().'index.php/transaction/view';
			$config['total_rows'] = $jmlDta;
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
		//	$data['pagination'] = $this->pagination->create_links();
			
			$data['total_rows'] = $config['total_rows'] ;
			$data['title'] = 'List transaction';
			$data['text'] = $this->transaction_model->point_transaction($config['per_page'],$this->uri->segment(3),$users);
			$data['pagecontent'] = "user/point";
			$this->load->vars($data);
			$this->load->view('template');
		}
		else{
			$urlAddrss = base_usrl().'index.php';
			redirect($urlAddrss, 'refresh');
		}
	}
	function point_history_by_period(){
		$urlPrd = $this->uri->uri_to_assoc(3);
		$filterPeriod = $urlPrd['prd'];
		$slice = explode("to", $filterPeriod);
		$firstPeriod = $slice[0]; 
		$lastPeriod = $slice[1];
		
		if($this->tank_auth->get_user_role_id() == 1){
			$users = null;
		}else{
			$users = $this->_get_users_id();
		}
		$this->db->select('*');
		$this->db->from('book_packages');
		$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id', 'left');
		 $this->db->where('user_id', $users);
		 $this->db->where('booking_date >=', $firstPeriod);
		 $this->db->where('booking_date <=', $lastPeriod);
		 $this->db->order_by('booking_date', 'asc');
		 $qryBkngPkg = $this->db->get();
		
		$data['text'] = $qryBkngPkg->result();
		$data['userID'] = $users;
		$data['period'] = $firstPeriod.' - '.$lastPeriod;
		$this->load->vars($data);
		$this->load->view('point_history_by_period');
	}
	function all_point_history()
	{
		if($this->tank_auth->get_user_role_id() == 1){
			$users = null;
			$this->db->select('*');
			$this->db->from('book_packages');
			$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id', 'left');
			$qryBkngPkg = $this->db->get();
		}else{
			$users = $this->_get_users_id();
			$this->db->select('*');
			$this->db->from('book_packages');
			$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id', 'left');
			$this->db->where('user_id', $users);
			$qryBkngPkg = $this->db->get();
		}
		
		
		$data['text'] = $qryBkngPkg->result();
		$data['userID'] = $users;
		$data['userRoleID'] = $this->tank_auth->get_user_role_id();
		$this->load->vars($data);
		$this->load->view('all_point_history');
	}
	function point_history()
	{
		if($this->tank_auth->get_user_role_id() == 1){
			$users = null;
			$this->db->select('*');
			$this->db->from('book_packages');
			$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id', 'left');
			$qryBkngPkg = $this->db->get();
		}else{
			$users = $this->_get_users_id();
			$this->db->select('*');
			$this->db->from('book_packages');
			$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id', 'left');
			$this->db->where('user_id', $users);
			$qryBkngPkg = $this->db->get();
		}
		
		
		
		
			$data['text'] = $qryBkngPkg->result();
			$data['userID'] = $users;
			$data['userRoleID'] = $this->tank_auth->get_user_role_id();
			$this->load->vars($data);
		      $this->load->view('point_history');
		
	}
function all_booking_history_by_period(){
		$urlPrd = $this->uri->uri_to_assoc(3);
		$filterPeriod = $urlPrd['prd'];
		$slice = explode("to", $filterPeriod);
		$firstPeriod = $slice[0]; 
		$lastPeriod = $slice[1];
		
		if($this->tank_auth->get_user_role_id() == 1){
			$users = null;
		}else{
			$users = $this->_get_users_id();
		}
		$this->db->select('*');
		$this->db->from('book_packages');
		$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id', 'left');
		 //$this->db->where('user_id', $users);
		 $this->db->where('booking_date >=', $firstPeriod);
		 $this->db->where('booking_date <=', $lastPeriod);
		 $this->db->order_by('booking_date', 'asc');
		 $qryBkngPkg = $this->db->get();
		
		$data['text'] = $qryBkngPkg->result();
		$data['userID'] = $users;
		$data['period'] = $firstPeriod.' to '.$lastPeriod;
		$this->load->vars($data);
		$this->load->view('admin/all_booking_history_by_period');
	}
        function booking_history_by_period(){
		$urlPrd = $this->uri->uri_to_assoc(3);
		$filterPeriod = $urlPrd['prd'];
		$slice = explode("to", $filterPeriod);
		$firstPeriod = $slice[0]; 
		$lastPeriod = $slice[1];
		
		if($this->tank_auth->get_user_role_id() == 1){
			$users = null;
		}else{
			$users = $this->_get_users_id();
		}
		$this->db->select('*');
		$this->db->from('book_packages');
		$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id', 'left');
		 $this->db->where('user_id', $users);
		 $this->db->where('booking_date >=', $firstPeriod);
		 $this->db->where('booking_date <=', $lastPeriod);
		 $this->db->order_by('booking_date', 'asc');
		 $qryBkngPkg = $this->db->get();
		
		$data['text'] = $qryBkngPkg->result();
		$data['userID'] = $users;
		$data['period'] = $firstPeriod.' - '.$lastPeriod;
		$this->load->vars($data);
		$this->load->view('booking_history_by_period');
	}
        function all_booking_history(){
		if($this->tank_auth->get_user_role_id() == 1){
			$users = null;
		}else{
			$users = $this->_get_users_id();
		}
		$this->db->select('*');
		$this->db->from('book_packages');
		$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id', 'left');
		//$this->db->where('user_id',$users);
		$qryBkngPkg = $this->db->get();
		//count total rows of transaction list
		//$this->db->where('user_id',$users);
		//$this->db->from('book_packages');
        /*
		$config['base_url'] = base_url().'index.php/transaction/view';
		$config['total_rows'] = $this->db->count_all_results();
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		*/
		//$data['text'] = $this->transaction_model->view_transaction(null,null,$users);
		$data['text'] = $qryBkngPkg->result();
		$data['userID'] = $users;
		$this->load->vars($data);
		$this->load->view('admin/all_booking_history');
	}
	function booking_history(){
	       if($this->tank_auth->get_user_role_id() == 1){
			$users = null;
		}else{
			$users = $this->_get_users_id();
		}
		$this->db->select('*');
		$this->db->from('book_packages');
		$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id', 'left');
		$this->db->where('user_id',$users);
		$qryBkngPkg = $this->db->get();
		//count total rows of transaction list
		//$this->db->where('user_id',$users);
		//$this->db->from('book_packages');
        /*
		$config['base_url'] = base_url().'index.php/transaction/view';
		$config['total_rows'] = $this->db->count_all_results();
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		*/
		//$data['text'] = $this->transaction_model->view_transaction(null,null,$users);
		$data['text'] = $qryBkngPkg->result();
		$data['userID'] = $users;
		$this->load->vars($data);
		$this->load->view('booking_history');
	}
	function booking_form(){
	$data['pagecontent'] = "user/booking";
	$this->load->vars($data);
	$this->load->view('template');
	}
	
	function guestUserSaveBooking(){
	$actvtyID = $this->input->post('packageID');
	$adltPax = $this->input->post('adultPax');
	$snrCtznPax = $this->input->post('sniorCtzn');
	$currency = $this->input->post('currency');
	$chldPax = $this->input->post('childPax');
	$toursDetail = $this->input->post('tours');
	echo '<script>alert("'.$chldPax.'")</script>';
    $data['pagecontent'] = "user/booking";
	$this->load->vars($data);
	$this->load->view('template');
	}
	
	function userGuestBooking(){
	$usid = $this->input->post('usid');	
	$pid = $this->input->post('pid');	
	$paymentMethod = $this->input->post('paymethod');	
	$isRadeem = $this->input->post('radeemMyPoint');
	/* if radeem point is checked start */
	if ($this->tank_auth->is_logged_in()){
		
		$userRoleID = $this->tank_auth->get_user_role_id();
		$userID = $this->tank_auth->get_user_id();
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('users_id', $userID);
		$this->db->where('role_id', $userRoleID);
		$qryUsr = $this->db->get();
			foreach($qryUsr->result() as $fldUsr){
				$usrRoleId = $fldUsr->role_id;
				$usrPoint = $fldUsr->total_point;
						
						if($userRoleID == '2'){
							$MinimalBeli = $this->finance->get_point(13);	
							$NominalBeli = $this->finance->get_point(14);
							$PointBeli = $this->finance->get_point(15);
							$MinimalPoint = $this->finance->get_point(16);
							$PointTukar = $this->finance->get_point(17);
							$NominalBayar = $this->finance->get_point(18);
						}
						elseif($userRoleID == '3'){
						
							$MinimalBeli = $this->finance->get_point(19);
							$NominalBeli = $this->finance->get_point(20);
							$PointBeli = $this->finance->get_point(21);
							$MinimalPoint = $this->finance->get_point(22);
							$PointTukar = $this->finance->get_point(23);
							$NominalBayar = $this->finance->get_point(24);
						}
						 
				/* get currency rate from SGD to IDR */
					$this->db->select('*');
					$this->db->from('currencies');
					$this->db->where('currency_from', 'SGD');
					$this->db->where('country_iso_from', 'SG');
					$this->db->where('currency_to', 'IDR');
					$this->db->where('country_iso_to', 'ID');
					$rateValCurr = $this->db->get();
					foreach($rateValCurr->result() as $rowRateFld){
						$valIdrRate = $rowRateFld->konversi;
						
					}
					$nilNomPerPoint_inSGD = $NominalBayar / $valIdrRate;
					$pntNomValue_inSGD = $usrPoint * $nilNomPerPoint_inSGD; 
										
					/* get current transaction info from book_packages */
					$bkngUsid = $this->session->userdata('bookingUSID');
					$this->db->select('*');
					$this->db->from('book_packages');
					$this->db->where('usid', $bkngUsid);
					$qryTrnsctnNfo = $this->db->get();
					foreach($qryTrnsctnNfo->result() as $fldTnsctnNfo){
						$nilTotNom = $fldTnsctnNfo->total_sale_price_amount;//Tot. Nil. Nom. Trans. in SGD
						$nilTotNom_inIDR = $nilTotNom * $valIdrRate;//Tot. Nil. Nom. Trans. in IDR
						
						if($nilTotNom_inIDR >= $MinimalBeli){
							$nilTotNom_toPoint = round($nilTotNom / $nilNomPerPoint_inSGD, 2);//Konv. ke Point
							$gainedPoint = round($usrPoint + $nilTotNom_toPoint, 2);//point yg didapatkan	
							$arrDtUpdtUsr = array(
													'total_point' => $gainedPoint,
														);
							$this->db->where('users_id', $userID);
							$this->db->update('users', $arrDtUpdtUsr);	
						}
						else{
							$nilTotNom_toPoint = 0;
						}
						
						$trnsctnIDtble = $fldTnsctnNfo->id;
						//if($nilTotNom <= $pntNomValue_inSGD){
						$sisa_nom_point_inSGD = $pntNomValue_inSGD - $nilTotNom; 
						
							
							if($isRadeem == 1){
								$radeemedPoint = round($usrPoint - $nilTotNom_toPoint, 2);//point yg diradeem	
								$arrDtUpdtTrnctn = array(
															'isRadeemPoint' => '1',
															'pointRadeem' => $nilTotNom_toPoint,
															'pointRadeem_value' => $nilTotNom,
															'point_transaction' => $nilTotNom_toPoint
														);
								$this->db->where('id', $trnsctnIDtble);
								$this->db->update('book_packages', $arrDtUpdtTrnctn);
								
								/* update to new total_point */
								//$qryUpdtUsrs = mysql_query("UPDATE users SET total_point='$radeemedPoint' WHERE users_id='$userID' ");
								
								$arrDtUpdtUsr = array(
												'total_point' => $radeemedPoint,
													);
								$this->db->where('users_id', $userID);
								$this->db->update('users', $arrDtUpdtUsr);	
							}else{
								
								$arrDtUpdtTrnctn = array(
															'point_transaction' => $nilTotNom_toPoint
														);
								$this->db->where('id', $trnsctnIDtble);
								$this->db->update('book_packages', $arrDtUpdtTrnctn);
								
								/* update to new total_point */
								//$qryUpdtUsrs = mysql_query("UPDATE users SET total_point='$radeemedPoint' WHERE users_id='$userID' ");
								
								
							}
						//}
						
							
						
					}
			
			
		
		}	
	}
	/* if radeem point is checked end */	
	$salutationTL = $this->input->post('salutationTL');	
	$firstNameTL = $this->input->post('txtFirstNameTL');
	$lastNameTL = $this->input->post('txtLastNameTL');
	$ageTL = $this->input->post('txtAgeTL');
	$passportNumberTL = $this->input->post('txtPssprtNmbrTL');
	$dayOfBirthTL = $this->input->post('txtDobTL');
	$passportExpiredDateTL = $this->input->post('txtPssprtExpryDteTL');
	$passportIssuanceCountryTL = $this->input->post('txtPssprtIssuanceCntryTL');
	$nationalityTL = $this->input->post('nationalityIdTL');
	
	
	$salutationTC = $this->input->post('salutationTravCntc');
	$firstNameTC = $this->input->post('txtFirstNameTravCntc');
	$lastNameTC = $this->input->post('txtLastNameTC');
	$emailTC = $this->input->post('txtEmailTravCntc_1');
	$alternateEmailTC = $this->input->post('txtEmailTravCntc_2');
	$phoneNumberTC = $this->input->post('txtPhoneNumberTravCntc');
	$mobileNumberTC = $this->input->post('txtMobileNumberTravCntc');
	$faxNumberTC = $this->input->post('txtFaxNumberTravCntc');
	$addressTC = $this->input->post('txtaddressTravCntc');
	$postalCodeTC = $this->input->post('txtPostalCodeTravCntc');
	$countryTC = $this->input->post('txtCntryCodeTravCntc');
	$cityTC = $this->input->post('txtCityCodeTravCntc');
	$nationalityIdTC = $this->input->post('nationalityIdTravCntc');
	$nationalityCodeTC = $this->input->post('nationalityCodeTravCntc');
	
	
	$arrivalFlightNumber = $this->input->post('txtArrivFlightNum');
	$departFlightNumber = $this->input->post('txtDepartFlightNum');
	$arrivalDate = $this->input->post('txtArrivDate');
	$departDate = $this->input->post('txtDepartDate');
	$pickupDropoff = $this->input->post('pikupDropoff');
	
	
	$cardNumber = $this->input->post('txtCardNumber');
	$cardSecureCode = $this->input->post('txtCardSecureCode');
	$cardHolderName = $this->input->post('txtNameOnCard');
	$cardExpiryDate = $this->input->post('txtCardExpiryDate');
	
	
	$adultTravelerType = $this->input->post('travelerTypeAdult');
	$adultSalutation = $this->input->post('salutationAdult');
	$adultFirstName = $this->input->post('txtFrstNmeAdult');
	$adultLastName = $this->input->post('txtLstNmeAdult');
	$adultAge = $this->input->post('txtAgeAdult');
	$adultPassportNumber = $this->input->post('txtPssprtNmbrAdult');
	$adultDOB = $this->input->post('txtDobAdult');
	$adultPassportExpiredDate = $this->input->post('txtPssprtExpryDteAdult');
	$adultPassportIssuanceCountry = $this->input->post('txtPssprtIssncCntryAdult');
	$adultNationality = $this->input->post('ntnlityIdAdult');
	
	
	$childTravelerType = $this->input->post('travelerTypeChild');
	$childSalutation = $this->input->post('salutationChild');
	$childFirstName = $this->input->post('txtFrstNmeChild');
	$childLastName = $this->input->post('txtLstNmeChild');
	$childAge = $this->input->post('txtAgeChild');
	$childPassportNumber = $this->input->post('txtPssprtNmbrChild');
	$childDOB = $this->input->post('txtDobChild');
	$childPassportExpiredDate = $this->input->post('txtPssprtExpryDteChild');
	$childPassportIssuanceCountry  = $this->input->post('txtPssprtIssnceCntryChild');
	$childNationality = $this->input->post('ntnalityIdChild');
	
	
	$config = array(
				
			   array('field'   => 'salutationTL', 'label'   => 'Last Name', 'rules'   => 'required'),
               array('field'   => 'txtFirstNameTL', 'label'   => 'First Name', 'rules'   => 'required|xss_clean'),
			   array('field'   => 'txtLastNameTL', 'label'   => 'Last Name', 'rules'   => 'required'),
			   array('field'   => 'txtAgeTL', 'label'   => 'Age', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtNmbrTL', 'label'   => 'Passport Number', 'rules'   => 'required'),
			   array('field'   => 'txtDobTL', 'label'   => 'Date of Birth', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtExpryDteTL', 'label'   => 'Passport Expired Date', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtIssuanceCntryTL', 'label'   => 'Passport Issuance Country', 'rules'   => 'required'),
			   array('field'   => 'nationalityIdTL', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
			   array('field'   => 'txtFirstNameTravCntc', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtLastNameTC', 'label'   => 'Last Name', 'rules'   => 'required'),
			   array('field'   => 'txtEmailTravCntc_1', 'label'   => 'Email', 'rules'   => 'required'),
			   array('field'   => 'txtEmailTravCntc_2', 'label'   => 'Alternate Email', 'rules'   => 'required'),
			   array('field'   => 'txtPhoneNumberTravCntc', 'label'   => 'Phone Number', 'rules'   => 'required'),
			   array('field'   => 'txtMobileNumberTravCntc', 'label'   => 'Mobile Number', 'rules'   => 'required'),
			   array('field'   => 'txtFaxNumberTravCntc', 'label'   => 'Fax. Number', 'rules'   => 'required'),
			   array('field'   => 'txtaddressTravCntc', 'label'   => 'Address', 'rules'   => 'required'),
			   array('field'   => 'txtPostalCodeTravCntc', 'label'   => 'Postal Code', 'rules'   => 'required'),
			   array('field'   => 'txtCntryCodeTravCntc', 'label'   => 'Country', 'rules'   => 'required'),
			   array('field'   => 'txtCityCodeTravCntc', 'label'   => 'City', 'rules'   => 'required'),
			   array('field'   => 'nationalityIdTravCntc', 'label'   => 'Nationality', 'rules'   => 'required'),
			   array('field'   => 'nationalityCodeTravCntc', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
			   array('field'   => 'txtArrivFlightNum', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtDepartFlightNum', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtArrivDate', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtDepartDate', 'label'   => 'First Name', 'rules'   => 'required'),
			   //array('field'   => 'pikupDropoff', 'label'   => 'First Name', 'rules'   => 'required'),
			   
			 	
			   //array('field'   => 'txtCardNumber', 'label'   => 'Card Number', 'rules'   => 'required'),
			   //array('field'   => 'txtCardSecureCode', 'label'   => 'Card Security Code', 'rules'   => 'required'),
			   //array('field'   => 'txtNameOnCard', 'label'   => 'Name On Card', 'rules'   => 'required'),
			   //array('field'   => 'txtCardExpiryDate', 'label'   => 'Card Expiry Date', 'rules'   => 'required'),
			   
			   
			   array('field'   => 'txtFrstNmeAdult[]', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtLstNmeAdult[]', 'label'   => 'Last Name', 'rules'   => 'required'),
			   array('field'   => 'txtAgeAdult[]', 'label'   => 'Age', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtNmbrAdult[]', 'label'   => 'Passport Number', 'rules'   => 'required'),
			   array('field'   => 'txtDobAdult[]', 'label'   => 'Day of Birth', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtExpryDteAdult[]', 'label'   => 'Passport Ewxpired Date', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtIssncCntryAdult[]', 'label'   => 'Passport Issuance Country', 'rules'   => 'required'),
			   array('field'   => 'ntnlityIdAdult[]', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
			   array('field'   => 'txtFrstNmeChild[]', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtLstNmeChild[]', 'label'   => 'Last Name', 'rules'   => 'required'),
			   array('field'   => 'txtAgeChild[]', 'label'   => 'Age', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtNmbrChild[]', 'label'   => 'Passport Number', 'rules'   => 'required'),
			   array('field'   => 'txtDobChild[]', 'label'   => 'Day Of Birth', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtExpryDteChild[]', 'label'   => 'Passport Expiry Date', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtIssnceCntryChild[]', 'label'   => 'Passport Issuance Country', 'rules'   => 'required'),
			   array('field'   => 'ntnalityIdChild[]', 'label'   => 'Nationality', 'rules'   => 'required'),
			  
			   
			   
            );

		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			
			/*$this->load->view('myform');*/
			$data['pagecontent'] = "user/booking";
			$this->load->vars($data);
			$this->load->view('template');
			
			 //$dt = $this->load->vars($data);
			 //$this->session->set_flashdata($dt);
			 //redirect('/transaction/booking_form/sid/'.$usid.'/pid/'.$pid);
		}
		else
		{
			/*$this->load->view('formsuccess');*/
			$qrySlct = mysql_query("SELECT * FROM book_packages WHERE usid='$usid' ");
			$flds = mysql_fetch_array($qrySlct);
			$adultTot = $flds['adult'];
			$childTot = $flds['child'];
			$packageID = $flds['API_packages_id'];
			$adultLoopEnd = $adultTot - 1;
			$childLoopEnd = $childTot - 1; 
			/* create transaction code */ 
			$transCode = $flds['transaction_code'];
			
			/* ===========insert adult traveler contact info=============== */
			$travContactInfoNew = array(
								  'transaction_code' => $transCode,
								  'usid' => $usid,
								  'API_packages_id' => $packageID ,
								  'isLeader' => '0',
								  'isContact' => '1',
								  'isAdult' => '0',
								  'isChild' => '0',
								  'title' => $salutationTC,
								  'first_name' => $firstNameTC,
								  'last_name' => $lastNameTC,
								  'email' => $emailTC,
								  'alternate_email' => $alternateEmailTC,
								  'contact_number' => $phoneNumberTC,
								  'mobile_number' => $mobileNumberTC,
								  'fax_number' =>  $faxNumberTC,
								  'address' => $addressTC,
								  'postal_code' => $postalCodeTC,
								  'country_code' => $countryTC,
								  'city_code' => $cityTC,
								  'nationality_id' => $nationalityIdTC,
								  'nationality_code' => $nationalityCodeTC
								   
								);	
			$this->db->insert('traveler_info', $travContactInfoNew); 
			/* ===========insert adult traveler leader info=============== */
			$travLeaderInfoNew = array(
								  'transaction_code' => $transCode,
								  'usid' =>$usid,
								  'API_packages_id' => $packageID ,
								  'isLeader' => '1',
								  'isContact' => '0',
								  'isAdult' => '0',
								  'isChild' => '0',
								  'title' => $salutationTL,
								  'first_name' => $firstNameTL,
								  'last_name' => $lastNameTL,
								  'traveler_type' => '32',
								  'age' => $ageTL,
								  'passport_number' => $passportNumberTL,
								  'dob' => $dayOfBirthTL,
								  'passport_expired_date' => $passportExpiredDateTL,
								  'passport_issuance_country' =>  $passportIssuanceCountryTL,
								  'nationality_code' => $nationalityTL,
								);	
			$this->db->insert('traveler_info', $travLeaderInfoNew); 
			/* ===========insert adult traveler info=============== */
			for($i=0;$i <= $adultLoopEnd;$i++){
			$adultInfoNew = array(
								  'transaction_code' => $transCode,
								  'usid' =>$usid,
								  'API_packages_id' => $packageID ,
								  'isLeader' => '0',
								  'isContact' => '0',
								  'isAdult' => '1',
								  'isChild' => '0',
								  'title' => $adultSalutation[$i],
								  'first_name' => $adultFirstName[$i],
								  'last_name' => $adultLastName[$i],
								  'traveler_type' => $adultTravelerType[$i],
								  'age' => $adultAge[$i],
								  'passport_number' => $adultPassportNumber[$i],
								  'dob' => $adultDOB[$i],
								  'passport_expired_date' => $adultPassportExpiredDate[$i],
								  'passport_issuance_country' =>  $adultPassportIssuanceCountry[$i],
								  'nationality_code' => $adultNationality[$i],
								);	
			
			$this->db->insert('traveler_info', $adultInfoNew); 
			}	
			/* ==========insert child traveler info============= */
			for($i=0;$i <= $childLoopEnd;$i++){
			$childInfoNew = array(
								  'transaction_code' => $transCode,
								  'usid' =>$usid,
								  'API_packages_id' => $packageID ,
								  'isLeader' => '0',
								  'isContact' => '0',
								  'isAdult' => '0',
								  'isChild' => '1',
								  'title' => $childSalutation[$i],
								  'first_name' => $childFirstName[$i],
								  'last_name' => $childLastName[$i],
								  'traveler_type' => $childTravelerType[$i],
								  'age' => $childAge[$i],
								  'passport_number' => $childPassportNumber[$i],
								  'dob' => $childDOB[$i],
								  'passport_expired_date' => $childPassportExpiredDate[$i],
								  'passport_issuance_country' =>  $childPassportIssuanceCountry[$i],
								  'nationality_code' => $childNationality[$i],
								);	
			
			$this->db->insert('traveler_info', $childInfoNew); 
			}	
      
		    $dataUpdt = array(
               'book_step' => '2',
               'payment_method' => $paymentMethod,
               'credit_card_number' => $cardNumber,
               'card_secure_code' => $cardSecureCode,
               'name_on_card' => $cardHolderName,
               'card_expiry' => $cardExpiryDate,
               'arrive_flight_number' => $arrivalFlightNumber,
               'departure_flight_number' => $departFlightNumber,
               'arrive_flight_date' => $arrivalDate,
               'departure_flight_date' => $departDate,
               'pickup_dropoff' => $pickupDropoff,
               
            );

			$this->db->where('usid', $usid);
			$this->db->update('book_packages', $dataUpdt); 
		  /* unset/remove session bookingUSID*/
         $this->session->unset_userdata('bookingUSID');
		 /*redirect(base_url(),'refresh');*/
		 $data['pagecontent'] = "user/booking_success";
		 $this->load->vars($data);
		 $this->load->view('template');
		}
		/*
	$usid =;
	$activityID=;
	$adultTot=;
	$seniorCitizenTot= 0;
	$childAge=;
	$tourDetails=;
	$currency= 'SGD';
	$totalPrice= ;
	*/
	/* ==============Traveler Leader============ */
	/*
	$travelerTypTL = $this->input->post("etrvlrTypeTL");
	$salutationTL = $this->input->post("salutationTL");
	$firstNameTl = $this->input->post("txtFirstNameTL");
	$lastName = $this->input->post("txtLastNameTL");
	$ageTL = $this->input->post("txtAgeTL");
	$pssprtNmbrTL= $this->input->post("txtPssprtNmbrTL");
	$dobTL =  $this->input->post("txtDobTL");
	$pssprtExpiryDteTL =  $this->input->post("txtPssprtExpryDteTL");
	$pssprtIssuanceCntryTL =  $this->input->post("txtPssprtIssuanceCntryTL");
	$nationalityTl = $this->input->post("nationalityIdTL");
	*/
	/* =============traveler contact========= */
	/*
	$salutationTC = $this->input->post("salutationTravCntc");
	$firstNameTC = $this->input->post("txtFirstNameTravCntc"); 
	$lastName = $this->input->post("txtLastNameTC");
	$emailTC =  $this->input->post("txtEmailTravCntc_1");
	$email2TC = $this->input->post("txtEmailTravCntc_2");
	$phoneNmbrTC = $this->input->post("txtPhoneNumberTravCntc");
	$mobileNmbrTC = $this->input->post("txtMobileNumberTravCntc");
	$faxNmbrTC = $this->input->post("txtFaxNumberTravCntc");
	$addressTC = $this->input->post("txtaddressTravCntc");
	$postalCodeTC = $this->input->post("txtPostalCodeTravCntc");
	$cntryCodeTC = $this->input->post("txtCntryCodeTravCntc");
	$cityCodeTC = $this->input->post("txtCityCodeTravCntc");
	$nationalityIdTC = $this->input->post("nationalityIdTravCntc");
	$nationalityCodeTC =  $this->input->post("nationalityCodeTravCntc");
	*/
	/* =============flight info========= */
	/*
	$arriveFlightNum = $this->input->post("txtArriveFlightNum");
	$departFlightNum = $this->input->post("txtDepartFlightNum");
	$arrivalDate = $this->input->post("txtArriveDate");
	$deaprtDate = $this->input->post("txtDepartDate"); 
	*/
	/* ===============Pick Up/Dro Off Hotel============= */
	/*$pickUpPointID = $this->input->post("pikupDropoff"); */
	/* ===============Credit Card Info============= */
	/*
	$cardType = $this->input->post("cardType");
	$holderName = $this->input->post("txtCardHldrName");
	$bankName = $this->input->post("txtCardBankName");
	$countryCode = $this->input->post("txtCardCntryCode");
	$bcardNumber = $this->input->post("txtCardNum");
	$cardSecureCode = $this->input->post("txtCardSecuCode");
	$expiredDate = $this->input->post("txtCardExpDate");
	$cardContactNumber = $this->input->post("txtCardContNum");
	$holderAddress = $this->input->post("txtCardHldrAddrss");
	$holderPosCode = $this->input->post("txtCardHldrPosCode");
	$holderCntryCode = $this->input->post("txtCardHldrCntryCode");
	$holderCity = $this->input->post("txtCardHldrCity");
	*/
	/* ===========Adult Traveler========= */
	/*
	$adltTrvlrType = $this->input->post("travelerTypeAdult");
	$adltTrvlrSalutation =  $this->input->post("salutationAdult");
	$adltFrstNm = $this->input->post("txtFrstNmeAdult");
	$adltLastNm = $this->input->post("txtLstNmeAdult");
	$adltAge = $this->input->post("txtAgeAdult");
	$adltPssprtNmbr = $this->input->post("txtPssprtNmbrAdult");
	$adltDob = $this->input->post("txtDobAdult");
	$adltPssprtExpryDte = $this->input->post("txtPssprtExpryDteAdult"); 
	$adltPssprtIssuanceCntry = $this->input->post("txtPssprtIssncCntryAdult");
	$adltNtnlty = $this->input->post("ntnlityIdAdult");
	*/
	/* =============Child Traveler============= */
	/*
	$chldSalutation = $this->input->post("salutationChild");
	$chldTrvlrType = $this->input->post("travelerTypeChild");
	$chldTrvlrFrstNme = $this->input->post("txtFrstNmeChild");
	$chldTrvlrLstNme = $this->input->post("txtLstNmeChild"); 
	$chldTrvlrAge = $this->input->post("txtAgeChild");
	$chldPssprtNmbr = $this->input->post("txtPssprtNmbrChild");
	$chldDob = $this->input->post("txtDobChild"); 
	$chldPssprtExpryDte = $this->input->post("txtPssprtExpryDteChild");
	$chldPssprtIssnceCntry = $this->input->post("txtPssprtIssnceCntryChild");
	$chldNtnlty = $this->input->post("ntnalityIdChild");
	
	$trvlrLeader = array(
	                        'Title' => $travelerTypTL,
							'FirstName' => $salutationTL, 
							'LastName' =>  $lastName,
							'PassengerType' =>  $travelerTypTL,
							'Age' =>  $ageTL,
							'PassportNumber' =>  $pssprtNmbrTL,
							'DOB' =>  $dobTL,
							'PassportExpiryDate' =>  $pssprtExpiryDteTL,
							'PassportIssuanceCountry' =>  $pssprtIssuanceCntryTL,
							'NationalityID' =>  $nationalityTl
	                     );
	$trvlrContact = array(
	                      'Salutation' => $salutationTC,
						  'FirstName' => $firstNameTC,
						  'LastName' => $lastName,
						  'Email' => $emailTC,
						  'Email2' => $email2TC,
						  'ContactNumber' => $phoneNmbrTC,
						  'MobileNumber' => $mobileNmbrTC,
						  'FaxNumber' => $faxNmbrTC,
						  'Address' => $addressTC,
						  'PostalCode' => $postalCodeTC ,
						  'City' => $cityCodeTC,
						  'CountryCode' => $cntryCodeTC,
						  'NationalityID' => $nationalityIdTC,
						  'NationalityCode' => $nationalityCodeTC
	                     );
	$trvlrFlight = array(
	                      'ArrivalFlightNumber' => $arriveFlightNum,
						  'DepartureFlightNumber' => $departFlightNum,
						  'ArrivalDate' => $arrivalDate,
						  'DepartureDate' => $deaprtDate
						 );
					
	$creditCardInfo = array(
						  'CardType' => $cardType,
						  'CardHolderName' => $holderName,
						  'BankName' => $bankName,
						  'CardCountryCode' => $countryCode,
						  'CardNumber' => $bcardNumber,
						  'CardSecurityCode' => $cardSecureCode,
						  'CardExpiryDate' => $expiredDate,
						  'CardContactNumber' => $cardContactNumber,
						  'CardAddress' => $holderAddress,
						  'CardAddressPostalCode' => $holderPosCode,
						  'CardAddressCity' => $holderCity,
						  'CardAddressCountryCode' => $holderCntryCode
							);
	
	$qry = $this->db->query("SELECT * FROM pickup_point WHERE API_packages_id='$pickUpPointID' ");
	$field = $qry->row();
	$picpupPointName = $field->hotel_name;
	$pickUpDropOffPoint = array(
	                          'PickupPointID' => $pickUpPointID,
	                          'PickupDropOffPoint' => $picpupPointName
	                            );
	 
	$jmlAdult = count($adltTrvlrType) - 1;
	$jmlChild = count($chldTrvlrType) - 1;
	for($i = 0;$i <= $jmlAdult;$i++){
	$adultTrvlr[] = array(               
	                                      'Title' => $adltTrvlrSalutation[$i],
										  'FirstName' => $adltFrstNm[$i], 
										  'LastName' =>  $adltLastNm[$i],
										  'PassengerType' =>  $adltTrvlrType[$i],
										  'Age' =>  $adltAge[$i],
										  'PassportNumber' =>  $adltPssprtNmbr[$i],
										  'DOB' =>  $adltDob[$i],
										  'PassportExpiryDate' =>  $adltPssprtExpryDte[$i],
										  'PassportIssuanceCountry' =>  $adltPssprtIssuanceCntry[$i],
										  'NationalityID' =>  $adltNtnlty[$i]
	                                
	                  );
	}
	for($i = 0;$i <= $jmlChild;$i++){
	$childTrvlr[] = array(
	                                      'Title' => $chldSalutation[$i],
										  'FirstName' => $chldTrvlrFrstNme[$i], 
										  'LastName' =>  $chldTrvlrLstNme[$i],
										  'PassengerType' =>  $chldTrvlrType[$i],
										  'Age' =>  $chldTrvlrAge[$i],
										  'PassportNumber' =>  $chldPssprtNmbr[$i],
										  'DOB' =>  $chldDob[$i],
										  'PassportExpiryDate' =>  $chldPssprtExpryDte[$i],
										  'PassportIssuanceCountry' =>  $chldPssprtIssnceCntry[$i],
										  'NationalityID' =>  $chldNtnlty[$i]
	                                
	                  );
	}
	$guestDetails = array_merge($adultTrvlr,$childTrvlr);
	
	    $data['insert'] = $this->get_api->packageBooking($guestDetails,$pickUpDropOffPoint,$creditCardInfo,$trvlrContact,$trvlrFlight,$trvlrLeader);
	    $data['pagecontent'] = "user/booking_output_test";
		$this->load->vars($data);
		$this->load->view('template');
		*/
	}
	function searchPackages()
	{
	$actId = $this->input->post("activityId");
	$adlt = $this->input->post("adltPax");
	$childAge = $this->input->post("txtchildage");
	$trdate = $this->input->post("tourDate");
	/*echo '<script>alert("'.$actId.'");</script>';*/
	    $data['adultPax']= $adlt;
		$data['childPax']= count($childAge);
		$data['childages']= $childAge;
		$data['insert'] = $this->get_api->API_searchprice($actId,$adlt,$childAge,$trdate);
		$data['pagecontent'] = "user/booking?usid=".$data['insert']->$USID;
		$this->load->vars($data);
		$this->load->view('template');
		
	}
	function save_Tguest()
	{
		$data['insert'] = $this->transaction_model->saveTGuest($this->uri->segment(3));
		$data['aktif']=1;
		$data['ar_country'] = $this->_get_country_list();
		$data['pagecontent'] = "user/booking";
		$this->load->vars($data);
		$this->load->view('template');
		/* $this->load->vars($data);
		redirect('detail/detail'); */
	}
	function saveTCGuest()
	{
		$newFrom = '2014-06-22';
	//	$newFrom = date_create_from_format('m-d-Y', $newFrom);
	//	$newFrom = date_format($newFrom, 'Y-m-d');
		/* 
		$newTo = $this->input->post('to');
		$newTo = date_create_from_format('m-d-Y', $newTo);
		$newTo = date_format($newTo, 'Y-m-d'); 
		*/
		
		$data['insert'] = $this->transaction_model->saveTCGuest($this->uri->segment(3));
		$data['aktif']=1;
		$this->load->vars($data);
	
	//===================
		//pdf file generated
		$query = $this->db->query("
			SELECT packages.packages_id, packages.nama, packages_country.country_name, packages.price
			FROM packages
			LEFT JOIN packages_country ON packages_country.idx = packages.packages_id
			WHERE packages.packages_id = '".$this->session->userdata('sess_packages_id')."'");
			foreach ($query->result() as $row)
			{
			  $nm = $row->nama;
			  $rtype = $row->country_name;
			} 
		$qry = $this->db->query(" select nama_metode from metode_pembayaran where metode_id = '".$this->input->post('paymethod')."'");
			foreach ($qry->result() as $row)
				{
				  $nmp = $row->nama_metode;
				} 
		$dd= date('d');
		$mm= date('m');
		$yy= date('Y');
		$tglSkrng = $dd.'-'.$mm.'-'.$yy;
		$kdtransaksi = $this->session->userdata('sess_trans_no');
		$html ='
		<table style="font-size:8pt">
		<tr><td><img src="';$html.= base_url().'img/starholidaylogokecil.jpg" width="150" /></td></tr>
		<tr><td><b>TIKET24.</b></td><td>&nbsp;</td></tr>
		<tr><td>Jl. Mekar Abadi 1 No. 26</td><td>&nbsp;</td></tr>
		<tr><td>Bandung, Indonesia</td><td>&nbsp;</td></tr>
		<tr><td>Tel. No. : +6222-92807788</td><td>&nbsp;</td></tr>
		<tr><td>Email : contact.starholiday@gmail.com</td><td>&nbsp;</td></tr>
		<tr><td>Website : http://www.star-holiday.com</td><td>&nbsp;</td></tr>
		</table>
		<table align="center" style="font-size:14pt; font-weight:strong"><tr><td><b>HOTEL VOUCHER</b></td></tr></table>

		<table style="font-size:8pt">
		<tr><td><b>TRANS. NUMBER</b></td><td> : '; $html.=$this->session->userdata('sess_trans_no'); $html.='</td><td><b>ISSUED BY</b></td><td> : SYSTEM</td></tr>
		<tr><td><b>HOTEL</b></td><td> : '; $html.=$nm; $html.='</td><td><b>ISSUED DATE</b></td><td> : ';$html.=$tglSkrng; $html.='</td></tr>
		</table>

		<table style="font-size:8pt">
		<tr><td><b>GUEST/GROUPS NAMES</b></td><td> : '; $html.= $this->input->post('txtname'); $html.='</td></tr>
		<tr><td><b>PAYMENT METHOD</b></td><td> : '; $html.=$nmp; $html.='</td></tr>
		<tr><td><b>CARD NUMBER</b></td><td> : '; $html.=$this->input->post('txtcardnumber'); $html.='</td></tr>
		<tr><td><b>PHONE NUMBER</b></td><td> : '; $html.=$this->input->post('txtphone'); $html.='</td></tr>
		<tr><td><b>EMAIL</b></td><td> : '; $html.=$this->input->post('txtemail'); $html.='</td></tr>
		</table>

		<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:8pt">
		<tr>
		<td align="center" width="40px"><b>DATE</b></td><td align="center" width="40px"><b>COUNTRY</b></td><td align="center" width="200px"><b>PACKAGE NAME</b></td><td align="center" width="70px"><b>TOTAL AMOUNT</b></td></tr>
		<tr>
		<td align="center">';$html.=$newFrom; $html.='</td><td align="center">';$html.=$this->input->post('country'); $html.='</td><td style="padding:2px;text-align:center"><div>';$html.=$rtype; $html.='</div></td><td align="center" > IDR ';$html.= number_format($this->input->post('totalbaru')); $html.='</td>
		</tr>
		</table>
		';

		include("mpdf57/mpdf.php");
		$mpdf=new mPDF('utf-8', 'A5', 0, '', 5, 5, 10, 5, 5, 5, 'P');
		//$mpdf->SetDisplayMode('fullpage');

		$footer ='
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:6pt">
		  <tr>
			<td>This document is System Generated hence No Signatured is Required.</td>
			<td>&nbsp;</td>
		  </tr>
		 
		</table>
		';

		$mpdf->SetHTMLFooter($footer);
		$mpdf->SetTitle('Package Voucher');
		$mpdf->SetAuthor('www.tiket24.star-holiday.com');
		$mpdf->SetCreator('www.tiket24.star-holiday.com');

		// LOAD a stylesheet
		$stylesheet = file_get_contents('mpdf57/examples/mpdfstyletables.css');
		$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
		$mpdf->WriteHTML($html);
		$mpdf->WriteHTML('<tocentry content="Letter landscape" />');

		$mpdf->Output('file/packagevoucher'.$kdtransaksi.'.pdf', 'F');//save into file
		/*
		$mpdf->Output('testpdf.pdf', 'D');//force browser to download the file
		*/
		//$mpdf->Output();
		$body='
		<div><img src="http://tiket24.star-holiday.com/img/starholidaylogokecil.jpg" /></div>
		<div id="content">
		<div>Reservation Confirmation</div>
		<div>Dear '.$this->input->post('txtname').' </div>
		<div>Thank you forr choosing our service, It is our pleasure to confirm your reservation. Please do not hestitate to contact us with any changes </div>
		<div>Reservation Details</div>
		<div>
		<table>
		<tr><td>Transaction Number</td><td> : </td></tr>
		<tr>
		<td>Name</td><td> : '.$this->input->post('txtname').'</td></tr>
		<tr><td>Country</td><td> : '.$this->input->post('country').'</td></tr>
		<tr><td>Package Name</td><td> : '.$this->session->userdata('sess_packages_name').'</td></tr>
		<tr><td>Payment Method</td><td> : '.$this->input->post('paymethod').'</td></tr>
		</table>
		</div>
		</div>
		';
		$address = $this->input->post('txtemail');
			$this->email->to($address);
			$this->email->from('noreply@star-holiday.com');
			$this->email->subject('Package Booking Confirmation');
			//$this->email->message('Dear '.$this->input->post('txtname').' Here is the info you requested.');
			$this->email->message($body);
			$this->email->attach('file/packagevoucher'.$kdtransaksi.'.pdf');
			$this->email->send();
			
			
		$path_to_file = 'file/packagevoucher'.$kdtransaksi.'.pdf';
		unlink($path_to_file);	
		redirect('transaction/booking_success');
		exit;
		
		//==================
		
		/* $this->load->vars($data);
		redirect('detail/detail'); */
	}
	function booking_success(){
		$data['pagecontent'] = "user/booking_success";
		$this->load->vars($data);
		$this->load->view('template');
	}
	
	function view($success = null)
	{
		
		if($this->tank_auth->get_user_role_id() == 1){
			$users = null;
		}else{
			$users = $this->_get_users_id();
		}
		//count total rows of transaction list
		$this->db->where('user_id',$users);
		$this->db->from('book_packages');
	//	$this->db->limit(10);
		$config['base_url'] = base_url().'index.php/transaction/view';
		$config['total_rows'] = $this->db->count_all_results();
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
	//	$data['pagination'] = $this->pagination->create_links();
		if($success == "s"){
			$data['message'] = "Data Saved.";
		} else { $data['message'] = ""; }
		$data['total_rows'] = $config['total_rows'] ;
		$data['title'] = 'List transaction';
		$data['text'] = $this->transaction_model->view_transaction($config['per_page'],$this->uri->segment(3),$users);
		$data['pagecontent'] = "admin/view_transaction";
		$this->load->vars($data);
		$this->load->view('template');
		
	}
	function add_transaction()
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
         echo $this->upload->display_errors(); die();

         $this->data['error'] = array('error' => $this->upload->display_errors());
         
		//	$error = array('error' => $this->upload->display_errors());
		//	$this->load->view('add_transaction', $error);
			$data['pagecontent'] = "admin/add_transaction";
			$this->load->vars($data);
			$this->load->vars($error);
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
			$data['insert'] = $this->transactions->add_transaction($userid,$nama_file,$file_path);
			$this->load->vars($data);
			if($isi==1)
			{ 
				redirect('transaction/view','refresh');
			}elseif($isi==3)
			{
				redirect('reseller','refresh');
			} 
			else{	redirect('transaction/view','refresh'); }
		}
	}
	function go()
	{
		$id = $this->uri->segment(3);
		$data['isi']=$this->transactions->take_data($id);
		$data['aktif']=2;
		$data['pagecontent']='admin/edit_transaction';
		$this->load->vars($data);
		$this->load->view('template');
	}
	function edit()
	{
		if($this->input->post('kode'))
		{
			$data['update']=$this->transactions->edit_transaction();
			$this->load->vars($data);
			$isi=$this->tank_auth->get_user_role_id();
			if($isi==1)
			{ 
				redirect('transaction/view','refresh');
			}elseif($isi==3)
			{
				redirect('reseller','refresh');
			} 
			else{	redirect('transaction/view','refresh'); }
		}
		else
		{
			$data['pagecontent']='admin/edit_transaction';			
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
		
		$data['isi']=$this->transactions->delete();
		$this->load->vars($data);
		$isi=$this->tank_auth->get_user_role_id();
		if($isi==1)
		{ 
			redirect('transaction/view','refresh');
		}elseif($isi==3)
		{
			redirect('reseller','refresh');
		} 
		else {redirect('transaction/view','refresh');}
		
		/* $data['pagecontent']='admin/view_transaction';
		$this->load->vars($data);
		$this->load->view('template'); */
	}

	function search()
    {
	    $city = $this->input->post('city',TRUE);
	    $pos = strpos($city,',');
	    $city = substr($city,0,$pos);
	    $data['pax_password'] = $this->input->post('pax_password',TRUE);
            $data['country'] = $this->input->post('country',TRUE);
            $data['city'] = $city;
            $data['from'] = $this->input->post('from',TRUE);
            $data['to'] = $this->input->post('to',TRUE);
            $data['adult'] = $this->input->post('adult',TRUE);
            $data['children'] = $this->input->post('children',TRUE);
            $data['bed_type'] = $this->input->post('bed_type',TRUE);
            $data['available'] = $this->input->post('chkavailable',TRUE);
            $data['request'] = $this->input->post('chkrequest',TRUE);
	    $data['cari'] = $this->input->post('cari',TRUE);
				
            $this->session->set_userdata('sess_pax_password', $data['pax_password']);
	    $this->session->set_userdata('sess_country', $data['country']);
            $this->session->set_userdata('sess_city', $data['city']);
            $this->session->set_userdata('sess_from', $data['from']);
            $this->session->set_userdata('sess_to', $data['to']);
            $this->session->set_userdata('sess_adult', $data['adult']);
            $this->session->set_userdata('sess_children', $data['children']);
            $this->session->set_userdata('sess_bed_type', $data['bed_type']);
            $this->session->set_userdata('sess_available', $data['available']);
            $this->session->set_userdata('sess_request', $data['request']);
           
 
            //Pagination init
            $pagination['base_url']     = base_url().'index.php/transaction/search/';
            $pagination['total_rows']   = $this->db->count_all_results('transaction');
            $pagination['full_tag_open'] = "<p><div class=\"pagination\">";
            $pagination['full_tag_close'] = "</div></p>";
            $pagination['cur_tag_open'] = "<span class=\"current\">";
            $pagination['cur_tag_close'] = "</span>";
            $pagination['num_tag_open'] = "<span class=\"disabled\">";
            $pagination['num_tag_close'] = "</span>";
            $pagination['per_page']     = "10";
            $pagination['uri_segment'] = 3;
            $pagination['num_links']    = 1;
 
            $this->pagination->initialize($pagination); 
					
            $data['title'] = 'Search transaction';
            $data['listsearch'] = $this->search_model->SearchResult($pagination['per_page'],$this->uri->segment(3),$data); 
			$data['aktif'] = 2;
			$data['pagecontent'] = 'search';
            $this->load->vars($data);
            $this->load->view('template');
    }	
		
}
?>