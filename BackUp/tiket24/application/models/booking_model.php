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
	
	
		
		
		

	
		
	
		
}
?>