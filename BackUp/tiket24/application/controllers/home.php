<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('homes');
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	$this->load->model('get_api');
	}
	
	private function _get_main($perPage,$uri)
	{
		//to get all data in packages
		if($uri != NULL){
			$this->db->where('country', $uri);
			$this->db->or_where('idy', $uri);
		} 
		
		//to get all data in packages
		$this->db->select('packages_country.country_name,packages_city.city_name,packages.desc');
		$this->db->from('packages');
		$this->db->join('packages_country', 'packages_country.country_iso = packages.country','LEFT');
		$this->db->join('packages_city', 'packages_city.city_iso = packages.city','LEFT');

		$getData = $this->db->get('',$perPage);
		if($getData->num_rows() > 0)
			return $getData->row();
		else
			return null;
	}
	
	public function index()
	{
		$config['base_url'] = base_url().'index.php/home/package';
		$config['total_rows'] = $this->db->count_all('packages');
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['num_links'] = 1;
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
		$data['total_rows'] = $config['total_rows'] ;
		$data['text'] = $this->homes->view_packages($config['per_page'],$this->uri->segment(3));
		$data['text_ctr'] = $this->homes->view_packages_country($config['per_page'],0);
		$data['text_cty'] = $this->homes->view_packages_city($config['per_page'],0);
		
           	//$this->get_api->API_country();
		//$this->get_api->API_city();
		//$this->get_api->API_currency();
		//$this->get_api->API_tour_info();
		//$this->get_api->API_packages();
		
		$data['pagecontent'] = 'content';
		$this->load->view('template', $data);	
	}
	
	function detail()
	{
	    if($this->uri->segment(3) == 1){
		$this->db->where(array('packages_id' => $this->uri->segment(4)));
		$this->db->from('packages');
	    }elseif($this->uri->segment(3) == 2){
	    	$this->db->where(array('country'=>$this->uri->segment(4)));
		$this->db->from('packages');
	    }else{
	    	$this->db->where('idy',$this->uri->segment(4));
		$this->db->or_where('city',$this->uri->segment(4));
		$this->db->from('packages');
		$this->db->join('packages_city', 'packages_city.city_iso = packages.city','LEFT');$this->db->count_all_results();
	    }
	
		$config['base_url'] = base_url().'index.php/home/detail/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/';
		$config['total_rows'] = $this->db->count_all_results();
		$config['per_page'] = 10;
		$config['uri_segment'] = 4;
		$config['num_links'] = 1;
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
		$data['tanda'] = $this->uri->segment(3);
		$data['total_rows'] = $config['total_rows'] ;
		$data['text'] = $this->homes->detail_packages($config['per_page'],0,$this->uri->segment(4));
		$data['text_ctr'] = $this->homes->view_packages_by_country($config['per_page'],0,$this->uri->segment(4));
		$data['text_cty'] = $this->homes->view_packages_by_city($config['per_page'],0,$this->uri->segment(4));
		$data['city'] = $this->_get_main(5,$this->uri->segment(4),$this->uri->segment(3));
		$data['main'] = $this->homes->view_main(5,$this->uri->segment(4),$this->uri->segment(3));

		$data['pagecontent'] = 'detail';
		$this->load->view('template', $data);
	}
	
	public function package()
	{
		$config['base_url'] = base_url().'index.php/home/package';
		$config['total_rows'] = $this->db->count_all('packages');
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['num_links'] = 1;
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
		$data['total_rows'] = $config['total_rows'] ;
		$data['text'] = $this->homes->view_packages($config['per_page'],$this->uri->segment(3));
		
		$data['pagecontent'] = 'content';
		$this->load->view('template', $data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */