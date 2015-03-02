<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('search_model');
	}
	
	function index(){
		$srchFilter = $this->input->post('srchFilter');
		$txtSearch = $this->input->post('txtSearch');
		$srchVal = str_replace(' ', '-', $txtSearch);
		if(!empty($txtSearch)){
			//redirect('search/results/'.$srchFilter.'/q/'.urlencode(base64_encode($txtSearch)).'/', 'refresh');
			redirect('search/results/'.$srchFilter.'/q/'.rawurlencode($txtSearch).'/', 'refresh');
		}
		else{
			$this->session->set_flashdata('search_warning_message', '<strong>Warning !</strong> please fill the search field !');
			redirect('', 'refresh');
		}
		
		
	}
	
	function results()
	{
		$qKey = $this->uri->segment(5);//$_GET['q'];
		$srchFilter = $this->uri->segment(3);
		$txtSearch = rawurldecode($qKey);//urldecode(base64_decode($qKey));//urldecode($qKey);
		//$txtSearch = urldecode($this->uri->segment(4));
		$srchVal = str_replace(' ', '-', $txtSearch);
		$pge = $this->uri->segment(6);
		$config = array();
	        $config["base_url"] = base_url() . 'index.php/search/results/'.$srchFilter.'/q/'.$qKey.'/';
	        $config["total_rows"] = $this->search_model->record_count($srchFilter, $txtSearch);
	        $config["per_page"] = 20;
	        $config["uri_segment"] = 6;
		$choice = $config["total_rows"] / $config["per_page"];
 		$config["num_links"] = 5;
		$config['full_tag_open'] = '<li>';
		$config['full_tag_close'] = '</li>';
		$config['prev_link'] = '&lt; &nbsp;';
		$config['prev_tag_open'] = '<li title="Go to the previous page">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&gt; &nbsp;';
		$config['next_tag_open'] = '<li style="float:left" title="Go to the next page">';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li style="float:left"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li style="float:left">';
		$config['num_tag_close'] = '</li>';
		 
		$config['first_tag_open'] = '<li style="float:left" title="Go to the first page">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li style="float:left" title="Go to the last page">';
		$config['last_tag_close'] = '</li>';
		 
		$config['first_link'] = '&lt;&lt;';
		$config['last_link'] = '&gt;&gt;';
        $this->pagination->initialize($config);
		
		if(!empty($pge)){
			$page = $pge;
		}else{
			$page = 0;
		}	 
       
			$data["searchResults"] = $this->search_model->searching($config["per_page"],$page,$srchFilter,$txtSearch);
        	$data["links"] = $this->pagination->create_links();
			$data['pagecontent'] = 'search_result';
			$this->load->view('template', $data);
			
	}
	
	
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */