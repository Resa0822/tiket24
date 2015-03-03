<?php
class Errorlog_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function save_error_toDB($errMethod, $errPckgRefNo, $errPckgID, $errValue, $usrAgent){
		$dateNow = date('Y-m-d H:i:s');
		$data = array(
		   'err_method' => $errMethod,
		   'package_refno' => $errPckgRefNo,
		   'package_id' => $errPckgID,
		   'err_value' => $errValue,
		   'user_agent' => $usrAgent,
		   'date_added' => $dateNow
		);
		$this->db->insert('my_error_logs', $data); 
	}		
	function get_package_refno($packageID){
		$qry = $this->db->get_where('packages', array('API_packages_id'=>$packageID));
		foreach($qry->result() as $row){
			$pckgRefNo = $row->API_packages_refno;
		}
		return $pckgRefNo; 
	}
}
?>