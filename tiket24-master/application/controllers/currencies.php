<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Currencies extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('currencies_model');
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	}

	private function _get_country_list() 
	{
		$query = $this->db->query('SELECT * FROM country');
		return $query->result();
	}

	function index()
	{
		$data['ar_country'] = $this->_get_country_list();
		$data['pagecontent'] = "admin/add_currencies";
		$this->load->vars($data);
		$this->load->view('template');
	}
	function searching(){
		$txtSearch = $this->input->post('txtSearch');
		$pecah = explode(" ",$txtSearch);
		$srch = $pecah[0];
		redirect('currencies/search_result/q/'.$srch, 'resfresh');
	}
	function search_result(){
		
		$txtSearch = $this->uri->segment(4);
		$data['aktif']=2;
		$pge = $this->uri->segment(7);
		//count total rows of packages list
		$config['base_url'] = base_url().'index.php/currencies/search_result/q/'.$txtSearch;
		$config['total_rows'] = $this->currencies_model->search_currencies_records_count($txtSearch);
		$config['per_page'] = 10;
		$config['uri_segment'] = 7;
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
		
		if(!empty($pge)){
			$page = $pge;
		}else{
			$page = 0;
		}	 
		$this->pagination->initialize($config);
		$data['message'] = '';
		$data['total_rows'] = $config['total_rows'];
		$data['title'] = 'List packages';
		$data['text'] = $this->currencies_model->search_currency($config["total_rows"],$page,$txtSearch);
		$data['pagecontent'] = "admin/view_currencies";
		$this->load->vars($data);
		$this->load->view('template');
	}
	function view($success = null)
	{
		$data['aktif']=2;
		//count total rows of currencies list
		$config['base_url'] = base_url().'index.php/currencies/view';
		$config['total_rows'] = $this->db->count_all('currencies');
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
		$data['title'] = 'List currencies';
		$data['text'] = $this->currencies_model->view_currencies($config['per_page'],$this->uri->segment(3));
		$data['pagecontent'] = "admin/view_currencies";
		$this->load->vars($data);
		$this->load->view('template');
		
	}
	function add_currencies()
	{
		$config['upload_path'] = './asset/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '1000';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
		
		$this->load->library('upload',$config);
		$this->upload->initialize($config);
		
		if ($this->upload->do_upload('gambar'))
		{
		
		// return the error message and kill the script
        //echo $this->upload->display_errors(); die();

        //$this->data['error'] = array('error' => $this->upload->display_errors());
         
			$error = array('error' => $this->upload->display_errors());
		//	$this->load->view('add_currencies', $error);
			$data['pagecontent'] = "admin/add_currencies";
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
			$data['insert'] = $this->currencies_model->add_currencies($userid,$nama_file,$file_path);
			$this->load->vars($data);
			if($isi==1)
			{ 
				redirect('currencies/view','refresh');
			}elseif($isi==3)
			{
				redirect('reseller','refresh');
			} 
			else{	redirect('currencies/view','refresh'); }
		}
	}
	function go()
	{
		$id = $this->uri->segment(3);
		$data['isi'] =$this->currencies_model->take_data($id);
		$data['ar_country'] = $this->_get_country_list();
		$data['pagecontent']='admin/edit_currencies';
		$this->load->vars($data);
		$this->load->view('template');
	}
	function edit($id)
	{
		if($this->input->post('country_iso'))
		{
			$data['update']=$this->currencies_model->edit_currencies($id);
			$this->load->vars($data);
			$isi=$this->tank_auth->get_user_role_id();
			if($isi==1)
			{ 
				redirect('currencies/view/s','refresh');
			}elseif($isi==3)
			{
				redirect('reseller','refresh');
			} 
			else{	redirect('currencies/view/s','refresh'); }
		}
		else
		{
			$data['isi']=$this->currencies_model->take_data($id);
			$data['pagecontent']='admin/edit_currencies';			
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
		
		$data['isi']=$this->currencies_model->delete();
		$this->load->vars($data);
		$isi=$this->tank_auth->get_user_role_id();
		if($isi==1)
		{ 
			redirect('currencies/view','refresh');
		}elseif($isi==3)
		{
			redirect('reseller','refresh');
		} 
		else {redirect('currencies/view','refresh');}
		
		/* $data['pagecontent']='admin/view_currencies';
		$this->load->vars($data);
		$this->load->view('template'); */
	}
	
	function publish()
	{
		$id=$this->uri->segment(3);
		$data['isi']=$this->currencies_model->get_publish($id);
		$this->load->vars($data);
		redirect('currencies/view','refresh');
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
            $pagination['base_url']     = base_url().'index.php/currencies/search/';
            $pagination['total_rows']   = $this->db->count_all_results('currencies');
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