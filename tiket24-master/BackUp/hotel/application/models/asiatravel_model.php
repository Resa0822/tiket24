<?php
class Asiatravel_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_agent_code(){
		$qry = $this->db->select('*')
		->from('settings')
		->where('API_provider', 'asiatravel')
		->where('setting_name', 'agent_code_attraction')
		->get();
		$sttngValue = $qry->row();
		return $sttngValue->setting_value;
	}
	function get_partner_id(){
		$qry = $this->db->select('*')
		->from('settings')
		->where('API_provider', 'asiatravel')
		->where('setting_name', 'partner_id_attraction')
		->get();
		$sttngValue = $qry->row();
		return $sttngValue->setting_value;
	}
	function get_culture(){
		$qry = $this->db->select('*')
		->from('settings')
		->where('API_provider', 'asiatravel')
		->where('setting_name', 'culture_attraction')
		->get();
		$sttngValue = $qry->row();
		return $sttngValue->setting_value;
	}
	function get_password(){
		$qry = $this->db->select('*')
		->from('settings')
		->where('API_provider', 'asiatravel')
		->where('setting_name', 'password_attraction')
		->get();
		$sttngValue = $qry->row();
		return $sttngValue->setting_value;
	}
	function save_country_city($arrData){
		$this->db->insert('asiatravel_available_destinations', $arrData);
	}
	function save_activities($arrData){
		$this->db->insert('asiatravel_available_avtivities', $arrData);
	}
	function save_tours($arrData){
		$this->db->insert('asiatravel_available_tours', $arrData);
	}
	
}
?>