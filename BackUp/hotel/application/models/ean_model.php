<?php
class Ean_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_api_cid(){
		$qry = $this->db->select('*')
		->from('settings')
		->where('API_provider', 'ean')
		->where('setting_name', 'ean_cid')
		->get();
		$rslt = $qry->row();
		return $rslt->setting_value;
	}
	function get_api_key(){
		$qry = $this->db->select('*')
		->from('settings')
		->where('API_provider', 'ean')
		->where('setting_name', 'ean_api_key')
		->get();
		$rslt = $qry->row();
		return $rslt->setting_value;
	}
	function get_api_domain(){
		$qry = $this->db->select('*')
		->from('settings')
		->where('API_provider', 'ean')
		->where('setting_name', 'ean_api_domain')
		->get();
		$rslt = $qry->row();
		return $rslt->setting_value;
	}
	
}
?>