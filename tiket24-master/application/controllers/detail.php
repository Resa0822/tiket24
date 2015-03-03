<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Detail extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('packages_model');
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	}
	public function index()
	{
		$uri = $this->uri->segment(3);
		$this->detail($uri);
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
	function detail()
	{
		$data['tanda'] = $this->uri->segment(3);
		$data['pagecontent'] = 'detail';
		$this->load->view('template', $data);	
	}
	function book()
	{
	
         
         
		/* 	$this->form_validation->set_error_delimiters('<p class="red">', '</p>');
			$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('remember', 'Remember me', 'integer');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->login(
						$this->form_validation->set_value('login'),
						$this->form_validation->set_value('password'),
						$this->form_validation->set_value('remember'),
						$data['login_by_username'],
						$data['login_by_email'])) {								// success

					redirect('');

				} else {
					$errors = $this->tank_auth->get_error_message();
					if (isset($errors['banned'])) {								// banned user
						$this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);

					} elseif (isset($errors['not_activated'])) {				// not activated user
						redirect('/auth/send_again/');

					} else {													// fail
						foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					}
				}
			} */
			
	      	  $pckdsID = $this->uri->segment(3);
	          $qry = mysql_query("SELECT * FROM packages WHERE packages_id='$pckdsID' ");
	          $fldPckgs = mysql_fetch_array($qry);
        
		if($fldPckgs['isFromAPI'] == '1'){
			$data['ar_country'] = $this->_get_country_list();
			$data['ar_packages'] = $this->_get_packages_by_id($this->uri->segment(3));
			$data['tanda'] = $this->uri->segment(3);
			$data['pagecontent'] = 'user/search_packages';
			$this->load->view('template', $data);	
		}         
		else {
			//$data['ar_country'] = $this->_get_country_list();
			//$data['ar_packages'] = $this->_get_packages_by_id($this->uri->segment(3));
			$data['pckgId'] = $this->uri->segment(3);
			$data['pagecontent'] = 'user/booking_manual_package';
			$this->load->view('template', $data);	
		}
               
		
	}
}

/* End of file detail.php */
/* Location: ./application/controllers/detail.php */