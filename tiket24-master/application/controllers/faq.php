<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class faq extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('faq_model');
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	}
	
	
	function index()
	{
		
		$data['pagecontent'] = 'admin/add_faq';
		$this->load->view('template', $data);
	}
	function lists()
	{
		$data['aktif']=6;
		$config['base_url'] = base_url().'index.php/faq/lists';
		$config['total_rows'] = $this->db->count_all('faq');
		$config['per_page'] = 10;
		$config['urisegment'] = 3;
		$config['full_tag_open'] = '<div class = "pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		$data['title'] = 'FAQ';
		$data['text'] = $this->faq_model->view_faq($config['per_page'],$this->uri->segment(3));
		$data['pagecontent'] = "faq";
		$this->load->vars($data);
		$this->load->view('template');
		
		
	}
	
	function add_faq()
	{
		$data['insert'] = $this->faq_model->add_faq();
		$this->load->vars($data);
		redirect('faq/view','refresh');
	}
	
	function view()
	{
		$data['aktif'] = 7;
		$config['base_url'] = base_url().'index.php/faq/view';
		$config['total_rows'] = $this->db->count_all('faq');
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
		$data['total_rows'] = $config['total_rows'] ;
		$data['title'] = 'List FAQ';
		$data['text'] = $this->faq_model->view_faq($config['per_page'],$this->uri->segment(3));
		$data['pagecontent'] = 'admin/view_faq';
		$this->load->vars($data);
		$this->load->view('template');

	}
	
	function go()
	{
		$id = $this->uri->segment(3);
		$data['isi']=$this->faq_model->take_data($id);
		$data['aktif']=7;
		$data['pagecontent']='admin/edit_faq';
		$this->load->vars($data);
		$this->load->view('template');
	}
	
	function edit()
	{
		if($this->input->post('kode_faq'))
		{
			$data['aktif'] = 7;
			$data['update']=$this->faq_model->edit_faq();
			$this->load->vars($data);
			redirect('faq/view','refresh');
		}
		else
		{
			$data['aktif'] = 7;
			$data['pagecontent']='admin/edit_faq';
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
		
		$data['isi']=$this->faq_model->delete();
		$this->load->vars($data);
		redirect('faq/view','refresh');
		
		$data['pagecontent']='admin/view_faq';
		$this->load->vars($data);
		$this->load->view('template');
	}
	
	function publish()
	{
		$id=$this->uri->segment(3);
		$data['isi']=$this->faq_model->get_publish($id);
		$this->load->vars($data);
		redirect('faq/view','refresh');
	}
	
	
}
?>