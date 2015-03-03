<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Margin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('margin_model');
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	}
	
	private function _get_role_list() 
	{
		$roles = $this->tank_auth->get_user_role_id();
		if($roles == 1){
			$query = $this->db->query("SELECT * FROM roles WHERE role_id NOT IN (".$roles.")");
		} elseif($roles == 3) {
			$query = $this->db->query("SELECT * FROM roles WHERE role_id NOT IN (1,4,".$roles.")");
		}
		else{
			$query = $this->db->query("SELECT * FROM roles WHERE role_id = 4 ");
		}
		return $query->result();
	}
	private function _get_currencies_list() 
	{
		$query = $this->db->query('SELECT * FROM currencies ORDER BY currency_from ASC');
		return $query->result();
	}
	
	function index()
	{
		$data['ar_role'] = $this->_get_role_list();
		$data['ar_currencies'] = $this->_get_currencies_list();
		$data['pagecontent'] = "admin/add_margin";
		$this->load->vars($data);
		$this->load->view('template');
	}
	
	function view($success = null)
	{
		// redirect setelah login 
		if (!$this->tank_auth->is_logged_in()) {									// logged in
			redirect('');

		} else {
		
		$data['aktif']=2;
		//count total rows of margin list
		$config['base_url'] = base_url().'index.php/margin/view';
		$config['total_rows'] = $this->db->count_all('margin');
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
		$data['title'] = 'List margin';
		$data['ar_role'] = $this->_get_role_list();
		$data['text'] = $this->margin_model->view_margin($config['per_page'],$this->uri->segment(3),$this->tank_auth->get_user_role_id());
		$data['pagecontent'] = "admin/view_margin";
		$this->load->vars($data);
		$this->load->view('template');
		
		}
		
	}
	function add_margin()
	{
			$data['insert'] = $this->margin_model->add_margin();
			$this->load->vars($data);
			$isi=$this->tank_auth->get_user_role_id();
			if($isi==1)
			{ 
				redirect('margin/view/s','refresh');
			}elseif($isi==3)
			{
				redirect('margin/view/s','refresh');
			} 
			else{	redirect('margin/view/s','refresh'); }
		
	}
	function go()
	{
		$id = $this->uri->segment(3);
		$data['isi']=$this->margin_model->take_data($id);
		$data['ar_currencies'] = $this->_get_currencies_list();
		$data['ar_role'] = $this->_get_role_list();
		$data['pagecontent']='admin/edit_margin';
		$this->load->vars($data);
		$this->load->view('template');
	}
	function edit($id)
	{
		if($this->input->post('role_id'))
		{
			$data['update']=$this->margin_model->edit_margin($id);
			$this->load->vars($data);
			$isi=$this->tank_auth->get_user_role_id();
			if($isi==1)
			{ 
				redirect('margin/view/s','refresh');
			}elseif($isi==3)
			{
				redirect('margin/view/s','refresh');
			} 
			else{	redirect('margin/view/s','refresh'); }
		}
		else
		{
			$data['isi']=$this->margin_model->take_data($id);
			$data['pagecontent']='admin/edit_margin';			
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
		
		$data['isi']=$this->margin_model->delete();
		$this->load->vars($data);
		$isi=$this->tank_auth->get_user_role_id();
		if($isi==1)
		{ 
			redirect('margin/view','refresh');
		}elseif($isi==3)
		{
			redirect('margin/view','refresh');
		} 
		else {redirect('margin/view','refresh');}
		
		/* $data['pagecontent']='admin/view_margin';
		$this->load->vars($data);
		$this->load->view('template'); */
	}
	
	function publish()
	{
		$id=$this->uri->segment(3);
		$data['isi']=$this->margin_model->get_publish($id);
		$this->load->vars($data);
		redirect('margin/view','refresh');
	}	
	function order()
	{
		$id=$_POST['id'];
		$tOrder=$_POST['content'];
		$data['isi']=$this->margin_model->get_order($id,$tOrder);
		$this->load->vars($data);
		redirect('margin/view','refresh');
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
            $pagination['base_url']     = base_url().'index.php/margin/search/';
            $pagination['total_rows']   = $this->db->count_all_results('margin');
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
					
            $data['title'] = 'Search packages country';
            $data['listsearch'] = $this->search_model->SearchResult($pagination['per_page'],$this->uri->segment(3),$data); 
			$data['aktif'] = 2;
			$data['pagecontent'] = 'search';
            $this->load->vars($data);
            $this->load->view('template');
        }	
}
?>