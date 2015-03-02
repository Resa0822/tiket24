<?php
class Homes extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function hotdeals_record_count(){
		$this->db->select('*');
		$this->db->from('packages');
		$this->db->where('price !=', '0');
		$this->db->where('discount !=', '');
		$this->db->order_by('price', 'desc');
		$qry = $this->db->get();
		return $qry->num_rows();
	}
	function hot_deals($limit, $start){
		$this->db->select('*');
		$this->db->from('packages');
		$this->db->where('price !=', '0');
		$this->db->where('discount !=', '');
		$this->db->order_by('price', 'desc');
		$this->db->limit($limit, $start);
		$qry = $this->db->get();
		
		if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $row) {
                $data[] = $row;
            }
            return $qry->result();
        }
        return false;
	}
	function view_packages ($perPage,$uri)
	{	
		//to get all data in packages
		$this->db->order_by("orders DESC,nama ASC");
			$this->db->where('publish', 1);
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
			$this->db->where('publish', 1);

		$getData = $this->db->get('',$perPage);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function view_packages_by_country ($limit,$start,$iso)
	{
		//to get all data in packages
		$this->db->order_by("orders", "ASC"); 
		$this->db->where(array('country'=>$iso, 'publish'=>'1'));
		$this->db->limit($limit, $start);
		$getData = $this->db->get('packages');
		//$getData = $this->db->get('packages',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function view_packages_by_city($limit, $start, $cityCode)
	{
		$this->db->from('packages');
		$this->db->where('city', $cityCode);
			$this->db->where('publish', 1);
		$this->db->order_by('packages_id', 'asc');
		$this->db->limit($limit, $start);
		$qry = $this->db->get();
		return $qry->result();
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
		$this->db->order_by("packages_country.orders ASC, packages_city.city_name ");
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
		$this->db->where(array('packages_id' => $id, 'publish' => '1'));
		$getData = $this->db->get('packages',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function get_count_package_by_cityCode($cityCode){
		$this->db->from('packages');
		$this->db->where('city', $cityCode);
			$this->db->where('publish', 1);
		$qry = $this->db->get();
		return $qry->num_rows();
	}
	function get_city_by_cityCode($cityCode){
		$qry = $this->db->get_where('packages_city', array('city_iso'=>$cityCode));
		foreach($qry->result() as $row){
			return $row->city_name;
		}
		
	}
	function get_country_by_countryCode($countryCode){
		$qry = $this->db->get_where('packages_country', array('country_iso'=>$countryCode));
		foreach($qry->result() as $row){
			return $row->country_name;
		}
		
	}
	function get_package_name_by_id($packageID){
		$qry = $this->db->get_where('packages', array('packages_id'=>$packageID));
		foreach($qry->result() as $row){
			return $row->nama;
		}
		
	}
	function get_city_by_package_tblID($packageID){
		$this->db->select('*');
		$this->db->from('packages');
		$this->db->join('packages_city', 'packages_city.city_iso=packages.city');
		$this->db->where('packages.packages_id', $packageID);
		$qry = $this->db->get();
		foreach($qry->result() as $row){
			return $row->city_name;
		}
		
	}
	function get_conversi($currencyCode){
		$qry = $this->db->get_where('currencies', array('currency_from'=>$currencyCode));
		if($qry->num_rows() > 0)
			foreach($qry->result() as $row){
			return $row->konversi;
		}
		else
			return 0;
		
	}
	function get_currencies()
	{
		$this->db->select('*');
		$this->db->from('currencies');
		$this->db->where('status','0');
		$this->db->order_by('currency_from');
		$qry = $this->db->get();
	//	$qry = $this->db->query('Select currency_from from currencies order by currency_from ASC');
		if($qry->num_rows() > 0)
			return $qry->result();
		else
			return null;
	}

}
?>