<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Deposit extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('deposit_model');
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->load->library('form_validation');
		$this->lang->load('tank_auth');
	}
	
	function get_names($id = null)
	{
		$this->db->select("id, concat(trim(first_name),' ', trim(last_name)) as full_name", FALSE);
		/*  
		if($role != NULL){
				$this->db->where('role_id', $role);
		} 
		*/
		$query = $this->db->get('reseller_profile');
		$names = array();
		 
		if($query->result()){
		foreach ($query->result() as $name) {
		$names[$name->id] = $name->full_name;
		}
			return $names;
		}else{
			return FALSE;
		}
	}

	function get_roles() 
	{
		$this->db->where('role_id',3);
		$this->db->select('role_id, role');
		$query = $this->db->get('roles');
		 
		$roles = array();
		 
		if ($query -> result()) {
		foreach ($query->result() as $role) {
		$roles[$role->role_id] = $role->role;
		}
			return $roles;
		} else {
			return FALSE;
		}
	}
 
	function names($role)
	{
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($this->get_names($role)));
	} 

	function index()
	{
		$data['roles'] = $this->get_roles();
		$data['names'] = $this->get_names();
		$data['pagecontent'] = "admin/add_deposit";
		$this->load->vars($data);
		$this->load->view('template');
	}

	function view($success = null)
	{
		$data['aktif']=2;
		//count total rows of deposit list
		$config['base_url'] = base_url().'index.php/deposit/view';
		$config['total_rows'] = $this->db->count_all('deposit');
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
		$data['title'] = 'List deposit';
		$data['text'] = $this->deposit_model->view_deposit($config['per_page'],$this->uri->segment(3));
		$data['pagecontent'] = "admin/view_deposit";
		$this->load->vars($data);
		$this->load->view('template');
		
	}
	function add_deposit()
	{
		$id = $this->input->post('roles');
		$data['insert'] = $this->deposit_model->add_deposit();
		$this->load->vars($data);
		redirect('deposit/view/'.$id.'','refresh');

	}
	function nominal_added_to_balace(){
		$depositID = $this->input->post('dpstID');
		$deposit_nominal = $this->input->post('deposit_nominal');
		
		$config = array(
			   array('field'   => 'deposit_nominal', 'label'   => 'Deposit Nominal', 'rules'   => 'required'),
            );

		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('flashMsge_warning', '<strong>Warning !</strong> please fill in Nominal Deposit field !');
			redirect('deposit/go/'.$depositID, 'refresh');
			
		}
		else{
			$qry = $this->db->get_where('deposit', array('deposit_no'=>$depositID));
			foreach($qry->result() as $row){
				$currentBalance = $row->nominal;
			}
			$updtdDpst = $currentBalance + $deposit_nominal;
			$dt = array('nominal'=>$updtdDpst);
			$this->db->update('deposit', $dt);
			
			redirect('deposit/go/'.$depositID, 'refresh');
		}
		
		
	}
	function go()
	{
		$id = $this->uri->segment(3);
		$data['balance']=$this->deposit_model->get_deposit_balance($id);
		$data['isi']=$this->deposit_model->take_data($id);
		$data['roles'] = $this->get_roles();
		$data['names'] = $this->get_names();
		$data['pagecontent']='admin/edit_deposit';
		$this->load->vars($data);
		$this->load->view('template');
	}
	function edit($id)
	{
		if($this->input->post('name'))
		{
			$data['update']=$this->deposit_model->edit_deposit($id);
			$this->load->vars($data);
			$isi=$this->tank_auth->get_user_role_id();
			if($isi==1)
			{ 
				redirect('deposit/view/s','refresh');
			}elseif($isi==3)
			{
				redirect('reseller','refresh');
			} 
			else{	redirect('deposit/view/s','refresh'); }
		}
		else
		{
			$data['isi']=$this->deposit_model->take_data($id);
			$data['pagecontent']='admin/edit_deposit';			
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
		
		$data['isi']=$this->deposit_model->delete();
		$this->load->vars($data);
		$isi=$this->tank_auth->get_user_role_id();
		redirect('deposit/view','refresh');
		
		/* $data['pagecontent']='admin/view_deposit';
		$this->load->vars($data);
		$this->load->view('template'); */
	}
	
	function publish()
	{
		$id=$this->uri->segment(3);
		$data['isi']=$this->deposit_model->get_publish($id);
		$this->load->vars($data);
		redirect('deposit/view','refresh');
	}
	
	function order()
	{
		$id=$_POST['id'];
		$tOrder=$_POST['content'];
		$data['isi']=$this->deposit_model->get_order($id,$tOrder);
		$this->load->vars($data);
		redirect('deposit/view','refresh');
	}

	function search()
        {
	    $city = $this->input->post('city',TRUE);
	    $pos = strpos($city,',');
	    $city = substr($city,0,$pos);
	    $data['pax_password'] = $this->input->post('pax_password',TRUE);
            $data['city'] = $this->input->post('city',TRUE);
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
	    $this->session->set_userdata('sess_city', $data['city']);
            $this->session->set_userdata('sess_city', $data['city']);
            $this->session->set_userdata('sess_from', $data['from']);
            $this->session->set_userdata('sess_to', $data['to']);
            $this->session->set_userdata('sess_adult', $data['adult']);
            $this->session->set_userdata('sess_children', $data['children']);
            $this->session->set_userdata('sess_bed_type', $data['bed_type']);
            $this->session->set_userdata('sess_available', $data['available']);
            $this->session->set_userdata('sess_request', $data['request']);
           
 
            //Pagination init
            $pagination['base_url']     = base_url().'index.php/deposit/search/';
            $pagination['total_rows']   = $this->db->count_all_results('deposit');
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
					
            $data['title'] = 'Search packages city';
            $data['listsearch'] = $this->search_model->SearchResult($pagination['per_page'],$this->uri->segment(3),$data); 
			$data['aktif'] = 2;
			$data['pagecontent'] = 'search';
            $this->load->vars($data);
            $this->load->view('template');
        }	
}
?>