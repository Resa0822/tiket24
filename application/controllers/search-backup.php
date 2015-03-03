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
		$searchFilter = $this->input->post('searchFilter');
		$searchFilter = $this->input->post('searchFilter');
		$searchFilter = $this->input->post('searchFilter');
		
		if($searchFilter == 'byPrice'){
			$priceRangeSearch = $this->input->post('priceRangeSearch');
			$priceFrom = 0;
			$priceTo = 100;
			redirect('search/results/'.$searchFilter.'/'.$priceFrom.'/'.$priceTo.'/', 'refresh');
		}
		else{
			$attractionSearch = $this->input->post('attractionSearch');
			echo '<script>alert("by attraction")</script>';
		}
		
		$data['pagecontent'] = 'search_result';
		$this->load->view('template', $data);
	}
	
	function results()
	{
		$searchFilter = $this->uri->segment(3);
		$priceFrom = $this->uri->segment(4);
		$priceTo = $this->uri->segment(5);
		$pge = $this->uri->segment(6);
		$config = array();
        $config["base_url"] = base_url() . 'index.php/search/results/'.$searchFilter.'/'.$priceFrom.'/'.$priceTo.'/';
        $config["total_rows"] = $this->search_model->record_count($priceFrom, $priceTo);
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
        //$page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
		
		if($searchFilter == 'byPrice'){
			$priceRangeSearch = $this->input->get('priceRangeSearch');
			//$searhByPrice = $this->search_model->search_byPrice($priceFrom, $priceTo);
			$data["searchResults"] = $this->search_model->search_byPrice($priceFrom, $priceTo, $config["per_page"], $page);
        	$data["links"] = $this->pagination->create_links();
			//$data['searchResults'] = $searhByPrice;
			$data['pagecontent'] = 'search_result';
			$this->load->view('template', $data);
			/*
			foreach($searhByPrice as $row){
				echo $row->packages_id.' '.$row->price.'<br />';
			}
			*/
		}
		else{
			$attractionSearch = $this->input->get('attractionSearch');
			//echo '<script>alert("by attraction")</script>';
		}
		
		$data['pagecontent'] = 'search_result';
		$this->load->view('template', $data);
	}
	
	
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */