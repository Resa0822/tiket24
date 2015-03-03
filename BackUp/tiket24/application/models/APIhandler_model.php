<?php
 class APIhandler_model extends CI_Model
 {
    function __construct()
	{
		parent::__construct();
				
	}
	
	function update_pickuppoints($acttvtyID,$hotelCode,$nmHotel){
		
		$qryChk = $this->db->query("SELECT * FROM pickup_point WHERE API_packages_id='$acttvtyID' ");
		$isAda = $qryChk->num_rows();
		$getField = mysql_fetch_array($qryChk);
		$getID = $getField['id'];
		if($isAda == 0){
			$qry = $this->db->query("INSERT INTO pickup_point(API_packages_id,hotel_code,hotel_name) VALUES('$acttvtyID','$hotelCode','$nmHotel')");
		}
		else{
			$qry = $this->db->query("UPDATE pickup_point SET API_packages_id='$acttvtyID', hotel_code='$hotelCode', hotel_name='$nmHotel' WHERE id='$getID' ");
	   }
		  
	}
 

}
?>