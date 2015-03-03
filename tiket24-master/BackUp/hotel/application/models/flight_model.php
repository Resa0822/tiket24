<?php
class Flight_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_api_secret_key(){
		$qry = $this->db->select('*')
		->from('settings')
		->where('API_provider', 'tiket')
		->where('setting_name', 'flight_api_secret_key')
		->get();
		$secretKey = $qry->row();
		return $secretKey->setting_value;
	}
	function get_api_domain(){
		$qry = $this->db->select('*')
		->from('settings')
		->where('API_provider', 'tiket')
		->where('setting_name', 'api_domain')
		->get();
		$apiDomain = $qry->row();
		return $apiDomain->setting_value;
	}
	function get_airports_groupby_countryid()
	{
		$this->db->select('*');
		$this->db->from('airports');
		$this->db->group_by('country_id');
		$qry = $this->db->get();
		return $qry->result();
	}
	function get_airport_location($airportCode){
		$qry = $this->db->select('location_name')
		->from('airports')
		->where('airport_code', $airportCode)
		->get();
		$row = $qry->row(); 
		 return $row->location_name;
	}
	function get_airport_city_country($airportCode){
		$qry = $this->db->select('*')
		->from('airports')
		->join('countries', 'countries.country_code=airports.country_id', 'left')
		->where('airport_code', $airportCode)
		->get();
		$row = $qry->row(); 
		$html = $row->location_name.', '.$row->country_name.' ('.$row->airport_code.'}';
		 return $html;
	}
	function get_airport_location_with_code($airportCode){
		$qry = $this->db->select('*')
		->from('airports')
		->where('airport_code', $airportCode)
		->get();
		$row = $qry->row(); 
		$html = $row->location_name.' ('.$row->airport_code.')';
		 return $html;
	}
}
?>