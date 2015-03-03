<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Finance
 *
 */
class Finance extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_payment($payment_id) {
		//Get payment
		$res = $this->db->get_where('adm_transfer', array('id'=>$payment_id));
		$payment = $res->row()->isi;
		return $payment;		
	}
	
	function update_payment($id, $data) {		
		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update('adm_transfer');
	}	
	function get_payment_reseller($users_id) {
		//Get payment reseller
		$res = $this->db->get_where('aturan', array('users_id'=>$users_id));
		if($res->num_rows() > 0)
			return $res->row();
		else
			return null;	
	}
	
	function create_payment($data) {		
		$this->db->insert('aturan',$data);
	}
	
	function update_payment_reseller($id, $data) {		
		$this->db->set($data);
		$this->db->where('users_id', $id);
		$this->db->update('aturan');
	}
	
	function get_point($point_id) {
		//Get point
		$res = $this->db->get_where('adm_transfer', array('id'=>$point_id));
		$point = $res->row()->content;
		return $point;		
	}
	function get_creditcard($point_id) {
		//Get point
		$res = $this->db->get_where('adm_transfer', array('id'=>$point_id));
		$point = $res->row()->isi;
		return $point;		
	}
	
	function update_point($id, $data) {		
		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update('adm_transfer');
	}
	
}