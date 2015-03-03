<?php
class Booking_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function view_bookings($perPage,$uri)
	{
		//to get all data in packages
		$getData = $this->db->get('book_packages',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function get_arrData_tours_searchPrice($ActivityID, $travelDate){
		$qryGetDetailsTour = $this->db->get_where('tours', array('API_packages_id' => $ActivityID));
		$i=0;
		$topItem = array();
		foreach($qryGetDetailsTour->result() as $row)
		{
			$trid= $row->tour_id;
			$trtp= $row->tour_type;
			$topItem['Tours'] = array('TourID' => $trid, 'TravelDate' => $travelDate, 'TourType' =>  $trtp);
			//return $topItem;
			$i++;
		}	
		return json_encode($topItem);
	}
	function check_isEnough_balance_byUSID($userID){
		$this->db->select('*');
		$this->db->from('reseller_profile');
		$this->db->join('deposit', 'deposit.id=reseller_profile.id');
		$this->db->where('reseller_profile.users_id', $userID);
		$qry = $this->db->get();
		foreach($qry->result() as $row){
			$currentBalance = $row->nominal;
		}
		return $currentBalance;
	}	
		
		
		

	
		
	
		
}
?>