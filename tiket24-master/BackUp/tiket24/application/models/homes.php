<?php
class Homes extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function view_packages ($perPage,$uri)
	{	
		//to get all data in packages
		$this->db->order_by("orders", "ASC");
		if($uri != NULL){
			$this->db->where('country', $uri);
			$this->db->or_where('city', $uri);
		} 
		$getData = $this->db->get('packages',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function view_main($perPage,$uri,$city)
	{	
		//to get all data in packages
		if($city != NULL){
			$this->db->where('packages.country', $uri);
			$this->db->or_where('packages_city.idy', $uri);
			$this->db->or_where('packages.city', $uri);
		//	$this->db->or_where('packages.packages_id', $uri);
		}
		else{
			$this->db->where('packages.packages_id', $uri);
		}
		
		//to get all data in packages
		$this->db->select('packages.gambar');
		$this->db->from('packages');
		$this->db->join('packages_country', 'packages_country.country_iso = packages.country','LEFT');
		$this->db->join('packages_city', 'packages_city.city_iso = packages.city','LEFT');

		$getData = $this->db->get('',$perPage);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function view_packages_by_country ($perPage,$uri,$iso)
	{
		//to get all data in packages
		$this->db->order_by("orders", "ASC"); 
		$this->db->where(array('country'=>$iso));
		$getData = $this->db->get('packages',$perPage);
		//$getData = $this->db->get('packages',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function view_packages_by_city ($perPage,$uri,$iso)
	{
		//to get all data in packages
		$this->db->order_by("packages.orders", "ASC");
		$this->db->where('idy',$iso);
		$this->db->or_where('city',$iso);

		$this->db->select('*');
		$this->db->from('packages');
		$this->db->join('packages_city', 'packages_city.city_iso = packages.city','LEFT');
		
		$getData = $this->db->get('',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function view_packages_country ($perPage,$uri)
	{
		//to get all data in packages
		$this->db->order_by("orders ASC, country_name ASC");
		$getData = $this->db->get('packages_country',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}

	function view_packages_city ($perPage,$uri)
	{
		$this->db->order_by("packages_country.orders", "ASC");
		if($uri != NULL){
			$this->db->where('packages_country.country_iso', $uri);
		}
		
		//to get all data in packages
		$this->db->select('*');
		$this->db->from('packages_country');
		$this->db->join('packages_city', 'packages_city.country_iso = packages_country.country_iso');
		

		$getData = $this->db->get('',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function detail_packages ($perPage,$uri,$id)
	{
		//to get all data in packages
		$this->db->where(array('packages_id' => $id));
		$getData = $this->db->get('packages',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}

}
?>