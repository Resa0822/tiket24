<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class packages_city extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('packages_city_model');
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	}
	
	private function _get_country_list() 
	{
		$query = $this->db->query('SELECT * FROM packages_country');
		return $query->result();
	}

	function index()
	{
		$data['ar_country'] = $this->_get_country_list();
		$data['pagecontent'] = "admin/add_packages_city";
		$this->load->vars($data);
		$this->load->view('template');
	}
	function searching(){
		$txtSearch = $this->input->post('txtSearch');
		$pecah = explode(" ",$txtSearch);
		$srch = $pecah[0];
		redirect('packages_city/search_result/q/'.$srch, 'resfresh');
	}
	function search_result(){
		
		$txtSearch = $this->uri->segment(4);
		$data['aktif']=2;
		$pge = $this->uri->segment(7);
		//count total rows of packages list
		$config['base_url'] = base_url().'index.php/packages_city/search_result/q/'.$txtSearch;
		$config['total_rows'] = $this->packages_city_model->search_package_city_records_count($txtSearch);
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
		$data['total_rows'] = $config['total_rows'] ;
		$data['title'] = 'List packages';
		$data['text'] = $this->packages_city_model->search_package_city($config["total_rows"],$page,$txtSearch);
		$data['pagecontent'] = "admin/view_packages_city";
		$this->load->vars($data);
		$this->load->view('template');
	}
	function view($success = null)
	{
		$data['aktif']=2;
		//count total rows of packages_city list
		$config['base_url'] = base_url().'index.php/packages_city/view';
		$config['total_rows'] = $this->db->count_all('packages_city');
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
		$data['title'] = 'List packages_city';
		$data['text'] = $this->packages_city_model->view_packages_city($config['per_page'],$this->uri->segment(3));
		$data['pagecontent'] = "admin/view_packages_city";
		$this->load->vars($data);
		$this->load->view('template');
		
	}
	function add_packages_city()
	{
		$config['upload_path'] = './asset/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '1024';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
		
		$this->load->library('upload',$config);
		$this->upload->initialize($config);
		
		
		
/* ========================================================================================== */		
			if (!$this->upload->do_upload('gambar'))
			{
			
			// return the error message and kill the script
	        //echo $this->upload->display_errors(); die();
	
	        //$this->data['error'] = array('error' => $this->upload->display_errors());
	         
				$error = array('error' => $this->upload->display_errors());
			//	$this->load->view('add_packages_city', $error);
				$data['pagecontent'] = "admin/add_packages_city";
				$this->load->vars($data);
			//	$this->load->vars($error);
				$this->load->view('template');
			}
			elseif(empty($_FILES['gambar']['name'])){
					$this->session->set_flashdata('flashMsge_warning', '<strong>Warning !</strong> please insert an image !');
					redirect('packages_city/add_packages_city', 'refresh');
			}
			else
			{
				$doc = $this->upload->data();
				$nama_file = $doc['file_name'];
				$file_path = $doc['full_path'];
				$country_iso = $this->input->post('country_iso');
				$city_iso = $this->input->post('city_iso');
				$city_name = $this->input->post('city_name');
				$isi=$this->tank_auth->get_user_role_id();
				$userid='';
				if($isi==3)
				{
					$userid=$this->tank_auth->get_user_id();
				}else
				{
					$userid='';
				}
				$data['insert'] = $this->packages_city_model->add_packages_city($userid,$nama_file,$file_path,$country_iso,$city_iso,$city_name);
				$this->load->vars($data);
				if($isi==1)
				{ 
					redirect('packages_city/view','refresh');
				}elseif($isi==3)
				{
					redirect('reseller','refresh');
				} 
				else{	redirect('packages_city/view','refresh'); }
			}
/* ========================================================================================== */	
		
	}
	function go()
	{
		$id = $this->uri->segment(3);
		$data['isi']=$this->packages_city_model->take_data($id);
		$data['ar_country'] = $this->_get_country_list();
		$data['pagecontent']='admin/edit_packages_city';
		$this->load->vars($data);
		$this->load->view('template');
	}
	function edit($id)
	{
		if($this->input->post('city_iso'))
		{
			$nama_file = $_FILES['gambar']['name'];//$doc['file_name'];
			if(!empty($_FILES['gambar']['name'])){
				$config['upload_path'] = './asset/uploads/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '1024';
				$config['max_width'] = '1024';
				$config['max_height'] = '768';
				$this->load->library('upload',$config);
				$this->upload->initialize($config);	
				$doc = $this->upload->data();
			}
			
			$data['update']=$this->packages_city_model->edit_packages_city($id,$nama_file);
			$this->load->vars($data);
			$isi=$this->tank_auth->get_user_role_id();
			if($isi==1)
			{ 
				redirect('packages_city/view/s','refresh');
			}elseif($isi==3)
			{
				redirect('reseller','refresh');
			} 
			else{
				redirect('packages_city/view/s','refresh'); 
			}
		}
		else
		{
			$data['isi']=$this->packages_city_model->take_data($id);
			$data['pagecontent']='admin/edit_packages_city';			
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
		
		$data['isi']=$this->packages_city_model->delete();
		$this->load->vars($data);
		$isi=$this->tank_auth->get_user_role_id();
		if($isi==1)
		{ 
			redirect('packages_city/view','refresh');
		}elseif($isi==3)
		{
			redirect('reseller','refresh');
		} 
		else {redirect('packages_city/view','refresh');}
		
		/* $data['pagecontent']='admin/view_packages_city';
		$this->load->vars($data);
		$this->load->view('template'); */
	}
	
	function publish()
	{
		$id=$this->uri->segment(3);
		$data['isi']=$this->packages_city_model->get_publish($id);
		$this->load->vars($data);
		redirect('packages_city/view','refresh');
	}
	
	function order()
	{
		$id=$_POST['id'];
		$tOrder=$_POST['content'];
		$data['isi']=$this->packages_city_model->get_order($id,$tOrder);
		$this->load->vars($data);
		redirect('packages_city/view','refresh');
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
            $pagination['base_url']     = base_url().'index.php/packages_city/search/';
            $pagination['total_rows']   = $this->db->count_all_results('packages_city');
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