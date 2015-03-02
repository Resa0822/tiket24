<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class attractions extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('homes');
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	}
	
	
	private function _get_city($perPage,$uri)
	{
		//to get all data in packages
		if($uri != NULL){
			$this->db->where('packages.city', $uri);
			$this->db->or_where('packages.packages_id', $uri);
		}
		
		//to get all data in packages
		$this->db->select('packages_city.city_name');
		$this->db->from('packages');
		$this->db->join('packages_city', 'packages_city.city_iso = packages.city');

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
		$config['total_ctr'] = $this->db->count_all('packages_country');
		$config['total_cty'] = $this->db->count_all('packages_city');
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
		$data['text_ctr'] = $this->homes->view_packages_city($config['total_cty'],$this->uri->segment(3));
		$data['text'] = $this->homes->view_packages_country($config['total_ctr'],0);
		
		
		$data['pagecontent'] = 'attractions';
		$this->load->view('template', $data);		
	}
	
	function packages()
	{
		$data['pagecontent'] = 'packages';
		$this->load->view('template', $data);	
	}
	
	function attraction_list()
	{
		$config['base_url'] = base_url().'index.php/attractions/package';
		$config['total_rows'] = $this->db->count_all('packages');
		$config['per_page'] = $this->db->count_all('packages');
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
	//	$data['text_ctr'] = $this->homes->view_packages_country($config['per_page'],0);
		
		$data['pagecontent'] = 'list_attractions_name';
		$this->load->view('template', $data);	
	}
	
	function attraction_list_city()
	{
		$config['base_url'] = base_url().'index.php/attractions/packages';
		$config['total_rows'] = $this->db->count_all('packages_city');
		$config['per_page'] = $this->db->count_all('packages_city');
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
		$data['text'] = $this->homes->view_packages_city($config['per_page'],$this->uri->segment(3));
	//	$data['text_ctr'] = $this->homes->view_packages_country($config['per_page'],0);
		
		$data['pagecontent'] = 'list_city_name';
		$this->load->view('template', $data);	
	}
	
	function detail()
	{
		$config['base_url'] = base_url().'index.php/attractions/detail';
		$config['total_rows'] = $this->db->count_all('packages');
		$config['per_page'] = 5;
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
		$kode = $this->uri->segment(3);
		$data['jdlSatu'] = 'City Packages';
		$data['jdlDua'] = $this->homes->get_city_by_package_tblID($kode);
		$data['tanda'] = $this->uri->segment(3);
		$data['total_rows'] = $config['total_rows'] ;
		$data['text'] = $this->homes->detail_packages($config['per_page'],0,$this->uri->segment(3));
		$data['text_ctr'] = $this->homes->view_packages_by_country($config['per_page'],0,$this->uri->segment(3));
		$data['city'] = $this->_get_city(5,$this->uri->segment(3),$this->uri->segment(4));
		$data['main'] = $this->homes->view_main(5,$this->uri->segment(3),$this->uri->segment(4));
		
		$data['pagecontent'] = 'detail';
		$this->load->view('template', $data);	
	}

	function detail_by_city()
	{
		$cityCode = $this->uri->segment(3);
		$pge = $this->uri->segment(4);
		$config['base_url'] = base_url().'index.php/attractions/detail_by_city/'.$cityCode;
		$config['total_rows'] = $this->homes->get_count_package_by_cityCode($cityCode);
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
		
		if(!empty($pge)){
			$page = $pge;
		}else{
			$page = 0;
		}	 
		$kode = $this->uri->segment(3);
		$data['jdlSatu'] = 'City Packages';
		$data['jdlDua'] = $this->homes->get_city_by_cityCode($kode);
		$data['tanda'] = $this->uri->segment(3);
		$data['total_rows'] = $config['total_rows'] ;
		$data['text'] = $this->homes->view_packages_by_city($config['per_page'],$page,$this->uri->segment(3));
		$data['city'] = $this->_get_city(5,$this->uri->segment(3),$this->uri->segment(4));
		$data['main'] = $this->homes->view_main(5,$this->uri->segment(3),$this->uri->segment(4));
		
		$data['pagecontent'] = 'detail';
		$this->load->view('template', $data);	
	}
		
	function hot_deal()
	{
		$pge = $this->uri->segment(3);
		$config = array();
        $config["base_url"] = base_url() . 'index.php/attractions/hot_deal/';
        $config["total_rows"] = $this->homes->hotdeals_record_count();
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
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
		$data["hotDealResults"] = $this->homes->hot_deals($config["per_page"],$page);
		$data['pagecontent'] = 'hot_deal';
		$this->load->view('template', $data);	
	}

}

/* End of file attractions.php */
/* Location: ./application/controllers/attractions.php */