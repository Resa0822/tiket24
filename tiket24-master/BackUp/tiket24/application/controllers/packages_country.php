<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class packages_country extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('packages_country_model');
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	}

	function index()
	{
		$data['pagecontent'] = "admin/add_packages_country";
		$this->load->vars($data);
		$this->load->view('template');
	}

	function view($success = null)
	{
		$data['aktif']=2;
		//count total rows of packages_country list
		$config['base_url'] = base_url().'index.php/packages_country/view';
		$config['total_rows'] = $this->db->count_all('packages_country');
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
		$data['title'] = 'List packages_country';
		$data['text'] = $this->packages_country_model->view_packages_country($config['per_page'],$this->uri->segment(3));
		$data['pagecontent'] = "admin/view_packages_country";
		$this->load->vars($data);
		$this->load->view('template');
		
	}
	function add_packages_country()
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
		//	$this->load->view('add_packages_country', $error);
			$data['pagecontent'] = "admin/add_packages_country";
			$this->load->vars($data);
		//	$this->load->vars($error);
			$this->load->view('template');
		}
		else
		{
			$doc = $this->upload->data();
			$country_iso = $this->input->post('country_iso');
		        $country_name = $this->input->post('country_name');
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
			$data['insert'] = $this->packages_country_model->add_packages_country($userid,$nama_file,$file_path,$country_iso,$country_name);
			$this->load->vars($data);
			if($isi==1)
			{ 
				redirect('packages_country/view','refresh');
			}elseif($isi==3)
			{
				redirect('reseller','refresh');
			} 
			else{	redirect('packages_country/view','refresh'); }
		}
	}
	function go()
	{
		$id = $this->uri->segment(3);
		$data['isi']=$this->packages_country_model->take_data($id);
		$data['pagecontent']='admin/edit_packages_country';
		$this->load->vars($data);
		$this->load->view('template');
	}
	function edit($id)
	{
		if($this->input->post('country_iso'))
		{
			$data['update']=$this->packages_country_model->edit_packages_country($id);
			$this->load->vars($data);
			$isi=$this->tank_auth->get_user_role_id();
			if($isi==1)
			{ 
				redirect('packages_country/view/s','refresh');
			}elseif($isi==3)
			{
				redirect('reseller','refresh');
			} 
			else{	redirect('packages_country/view/s','refresh'); }
		}
		else
		{
			$data['isi']=$this->packages_country_model->take_data($id);
			$data['pagecontent']='admin/edit_packages_country';			
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
		
		$data['isi']=$this->packages_country_model->delete();
		$this->load->vars($data);
		$isi=$this->tank_auth->get_user_role_id();
		if($isi==1)
		{ 
			redirect('packages_country/view','refresh');
		}elseif($isi==3)
		{
			redirect('reseller','refresh');
		} 
		else {redirect('packages_country/view','refresh');}
		
		/* $data['pagecontent']='admin/view_packages_country';
		$this->load->vars($data);
		$this->load->view('template'); */
	}
	
	function publish()
	{
		$id=$this->uri->segment(3);
		$data['isi']=$this->packages_country_model->get_publish($id);
		$this->load->vars($data);
		redirect('packages_country/view','refresh');
	}	
	function order()
	{
		$id=$_POST['id'];
		$tOrder=$_POST['content'];
		$data['isi']=$this->packages_country_model->get_order($id,$tOrder);
		$this->load->vars($data);
		redirect('packages_country/view','refresh');
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
            $pagination['base_url']     = base_url().'index.php/packages_country/search/';
            $pagination['total_rows']   = $this->db->count_all_results('packages_country');
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