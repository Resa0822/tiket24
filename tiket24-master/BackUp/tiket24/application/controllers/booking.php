<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Booking extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->model('booking_model');
		$this->load->library('form_validation');
	}
	
	function detail(){
		
	
		$data['pagecontent'] = "admin/detail_booking";
		$this->load->vars($data);
		$this->load->view('template');
	}
	
	function userGuestBooking(){
	$tid = $this->input->post('tid');	
	$this->db->select('*');
	$this->db->from('book_packages');
	$this->db->where('transaction_code',$tid);
	$query = $this->db->get();
	foreach($query->result() as $row){
		$transCode = $row->transaction_code;
	}
	$idt = $transCode; 	
	$paymentMethod = $this->input->post('paymethod');	
		
	
	$salutationTL = $this->input->post('salutationTL');	
	$firstNameTL = $this->input->post('txtFirstNameTL');
	$lastNameTL = $this->input->post('txtLastNameTL');
	$ageTL = $this->input->post('txtAgeTL');
	$passportNumberTL = $this->input->post('txtPssprtNmbrTL');
	$dayOfBirthTL = $this->input->post('txtDobTL');
	$passportExpiredDateTL = $this->input->post('txtPssprtExpryDteTL');
	$passportIssuanceCountryTL = $this->input->post('txtPssprtIssuanceCntryTL');
	$nationalityTL = $this->input->post('nationalityIdTL');
	
	$salutationTC = $this->input->post('salutationTravCntc');
	$firstNameTC = $this->input->post('txtFirstNameTravCntc');
	$lastNameTC = $this->input->post('txtLastNameTC');
	$emailTC = $this->input->post('txtEmailTravCntc_1');
	$alternateEmailTC = $this->input->post('txtEmailTravCntc_2');
	$phoneNumberTC = $this->input->post('txtPhoneNumberTravCntc');
	$mobileNumberTC = $this->input->post('txtMobileNumberTravCntc');
	$faxNumberTC = $this->input->post('txtFaxNumberTravCntc');
	$addressTC = $this->input->post('txtaddressTravCntc');
	$postalCodeTC = $this->input->post('txtPostalCodeTravCntc');
	$countryTC = $this->input->post('txtCntryCodeTravCntc');
	$cityTC = $this->input->post('txtCityCodeTravCntc');
	$nationalityIdTC = $this->input->post('nationalityIdTravCntc');
	$nationalityCodeTC = $this->input->post('nationalityCodeTravCntc');
	
	
	$arrivalFlightNumber = $this->input->post('txtArrivFlightNum');
	$departFlightNumber = $this->input->post('txtDepartFlightNum');
	$arrivalDate = $this->input->post('txtArrivDate');
	$departDate = $this->input->post('txtDepartDate');
	/*$pickupDropoff = $this->input->post('pikupDropoff');*/
	
	
	$cardNumber = $this->input->post('txtCardNumber');
	$cardSecureCode = $this->input->post('txtCardSecureCode');
	$cardHolderName = $this->input->post('txtNameOnCard');
	$cardExpiryDate = $this->input->post('txtCardExpiryDate');
	

	$adultTravelerType = $this->input->post('travelerTypeAdult');
	$adultSalutation = $this->input->post('salutationAdult');
	$adultFirstName = $this->input->post('txtFrstNmeAdult');
	$adultLastName = $this->input->post('txtLstNmeAdult');
	$adultAge = $this->input->post('txtAgeAdult');
	$adultPassportNumber = $this->input->post('txtPssprtNmbrAdult');
	$adultDOB = $this->input->post('txtDobAdult');
	$adultPassportExpiredDate = $this->input->post('txtPssprtExpryDteAdult');
	$adultPassportIssuanceCountry = $this->input->post('txtPssprtIssncCntryAdult');
	$adultNationality = $this->input->post('ntnlityIdAdult');
	 
	$childTravelerType = $this->input->post('travelerTypeChild');
	$childSalutation = $this->input->post('salutationChild');
	$childFirstName = $this->input->post('txtFrstNmeChild');
	$childLastName = $this->input->post('txtLstNmeChild');
	$childAge = $this->input->post('txtAgeChild');
	$childPassportNumber = $this->input->post('txtPssprtNmbrChild');
	$childDOB = $this->input->post('txtDobChild');
	$childPassportExpiredDate = $this->input->post('txtPssprtExpryDteChild');
	$childPassportIssuanceCountry  = $this->input->post('txtPssprtIssnceCntryChild');
	$childNationality = $this->input->post('ntnalityIdChild');
	
	
	$config = array(
				
			   array('field'   => 'salutationTL', 'label'   => 'Last Name', 'rules'   => 'required'),
               array('field'   => 'txtFirstNameTL', 'label'   => 'First Name', 'rules'   => 'required|xss_clean'),
			   array('field'   => 'txtLastNameTL', 'label'   => 'Last Name', 'rules'   => 'required'),
			   array('field'   => 'txtAgeTL', 'label'   => 'Age', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtNmbrTL', 'label'   => 'Passport Number', 'rules'   => 'required'),
			   array('field'   => 'txtDobTL', 'label'   => 'Date of Birth', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtExpryDteTL', 'label'   => 'Passport Expired Date', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtIssuanceCntryTL', 'label'   => 'Passport Issuance Country', 'rules'   => 'required'),
			   array('field'   => 'nationalityIdTL', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
			   array('field'   => 'txtFirstNameTravCntc', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtLastNameTC', 'label'   => 'Last Name', 'rules'   => 'required'),
			   array('field'   => 'txtEmailTravCntc_1', 'label'   => 'Email', 'rules'   => 'required'),
			   array('field'   => 'txtEmailTravCntc_2', 'label'   => 'Alternate Email', 'rules'   => 'required'),
			   array('field'   => 'txtPhoneNumberTravCntc', 'label'   => 'Phone Number', 'rules'   => 'required'),
			   array('field'   => 'txtMobileNumberTravCntc', 'label'   => 'Mobile Number', 'rules'   => 'required'),
			   array('field'   => 'txtFaxNumberTravCntc', 'label'   => 'Fax. Number', 'rules'   => 'required'),
			   array('field'   => 'txtaddressTravCntc', 'label'   => 'Address', 'rules'   => 'required'),
			   array('field'   => 'txtPostalCodeTravCntc', 'label'   => 'Postal Code', 'rules'   => 'required'),
			   array('field'   => 'txtCntryCodeTravCntc', 'label'   => 'Country', 'rules'   => 'required'),
			   array('field'   => 'txtCityCodeTravCntc', 'label'   => 'City', 'rules'   => 'required'),
			   array('field'   => 'nationalityIdTravCntc', 'label'   => 'Nationality', 'rules'   => 'required'),
			   array('field'   => 'nationalityCodeTravCntc', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
			   array('field'   => 'txtArrivFlightNum', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtDepartFlightNum', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtArrivDate', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtDepartDate', 'label'   => 'First Name', 'rules'   => 'required'),
			   /*array('field'   => 'pikupDropoff', 'label'   => 'First Name', 'rules'   => 'required'),*/
			   
			 			   
			   array('field'   => 'txtCardNumber', 'label'   => 'Card Number', 'rules'   => 'required'),
			   array('field'   => 'txtCardSecureCode', 'label'   => 'Card Security Code', 'rules'   => 'required'),
			   array('field'   => 'txtNameOnCard', 'label'   => 'Name On Card', 'rules'   => 'required'),
			   array('field'   => 'txtCardExpiryDate', 'label'   => 'Card Expiry Date', 'rules'   => 'required'),
			   
			   
			   array('field'   => 'txtFrstNmeAdult[]', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtLstNmeAdult[]', 'label'   => 'Last Name', 'rules'   => 'required'),
			   array('field'   => 'txtAgeAdult[]', 'label'   => 'Age', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtNmbrAdult[]', 'label'   => 'Passport Number', 'rules'   => 'required'),
			   array('field'   => 'txtDobAdult[]', 'label'   => 'Day of Birth', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtExpryDteAdult[]', 'label'   => 'Passport Ewxpired Date', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtIssncCntryAdult[]', 'label'   => 'Passport Issuance Country', 'rules'   => 'required'),
			   array('field'   => 'ntnlityIdAdult[]', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
			   array('field'   => 'txtFrstNmeChild[]', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtLstNmeChild[]', 'label'   => 'Last Name', 'rules'   => 'required'),
			   array('field'   => 'txtAgeChild[]', 'label'   => 'Age', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtNmbrChild[]', 'label'   => 'Passport Number', 'rules'   => 'required'),
			   array('field'   => 'txtDobChild[]', 'label'   => 'Day Of Birth', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtExpryDteChild[]', 'label'   => 'Passport Expiry Date', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtIssnceCntryChild[]', 'label'   => 'Passport Issuance Country', 'rules'   => 'required'),
			   array('field'   => 'ntnalityIdChild[]', 'label'   => 'Nationality', 'rules'   => 'required'),
			  
			   
			   
            );

		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			//redirect('booking/form/bid/'.$idt,'refresh');
			/*$this->load->view('myform');*/
			$data['pagecontent'] = "user/form_booking_package_manual";
			$this->load->vars($data);
			$this->load->view('template');
			
			 //$dt = $this->load->vars($data);
			 //$this->session->set_flashdata($dt);
			 //redirect('/transaction/booking_form/sid/'.$usid.'/pid/'.$pid);
		}
		else
		{
			/*$this->load->view('formsuccess');*/
			$qrySlct = mysql_query("SELECT * FROM book_packages WHERE transaction_code='$idt' ");
			$flds = mysql_fetch_array($qrySlct);
			$adultTot = $flds['adult'];
			$childTot = $flds['child'];
			$packageID = $flds['API_packages_id'];
			$adultLoopEnd = $adultTot - 1;
			$childLoopEnd = $childTot - 1; 
			/* create transaction code */ 
			$transCode = $flds['transaction_code'];
			
			/* ===========insert adult traveler contact info=============== */
			$travContactInfoNew = array(
								  'transaction_code' => $transCode,
								  'usid' => '',
								  'API_packages_id' => $packageID ,
								  'isLeader' => '0',
								  'isContact' => '1',
								  'isAdult' => '0',
								  'isChild' => '0',
								  'title' => $salutationTC,
								  'first_name' => $firstNameTC,
								  'last_name' => $lastNameTC,
								  'email' => $emailTC,
								  'alternate_email' => $alternateEmailTC,
								  'contact_number' => $phoneNumberTC,
								  'mobile_number' => $mobileNumberTC,
								  'fax_number' =>  $faxNumberTC,
								  'address' => $addressTC,
								  'postal_code' => $postalCodeTC,
								  'country_code' => $countryTC,
								  'city_code' => $cityTC,
								  'nationality_id' => $nationalityIdTC,
								  'nationality_code' => $nationalityCodeTC
								   
								);	
			$this->db->insert('traveler_info', $travContactInfoNew); 
			/* ===========insert adult traveler leader info=============== */
			$travLeaderInfoNew = array(
								  'transaction_code' => $transCode,
								  'usid' =>'',
								  'API_packages_id' => $packageID ,
								  'isLeader' => '1',
								  'isContact' => '0',
								  'isAdult' => '0',
								  'isChild' => '0',
								  'title' => $salutationTL,
								  'first_name' => $firstNameTL,
								  'last_name' => $lastNameTL,
								  'traveler_type' => '32',
								  'age' => $ageTL,
								  'passport_number' => $passportNumberTL,
								  'dob' => $dayOfBirthTL,
								  'passport_expired_date' => $passportExpiredDateTL,
								  'passport_issuance_country' =>  $passportIssuanceCountryTL,
								  'nationality_code' => $nationalityTL,
								);	
			$this->db->insert('traveler_info', $travLeaderInfoNew); 
			/* ===========insert adult traveler info=============== */
			for($i=0;$i <= $adultLoopEnd;$i++){
			$adultInfoNew = array(
								  'transaction_code' => $transCode,
								  'usid' =>'',
								  'API_packages_id' => $packageID ,
								  'isLeader' => '0',
								  'isContact' => '0',
								  'isAdult' => '1',
								  'isChild' => '0',
								  'title' => $adultSalutation[$i],
								  'first_name' => $adultFirstName[$i],
								  'last_name' => $adultLastName[$i],
								  'traveler_type' => $adultTravelerType[$i],
								  'age' => $adultAge[$i],
								  'passport_number' => $adultPassportNumber[$i],
								  'dob' => $adultDOB[$i],
								  'passport_expired_date' => $adultPassportExpiredDate[$i],
								  'passport_issuance_country' =>  $adultPassportIssuanceCountry[$i],
								  'nationality_code' => $adultNationality[$i],
								);	
			
			$this->db->insert('traveler_info', $adultInfoNew); 
			}	
			/* ==========insert child traveler info============= */
			for($i=0;$i <= $childLoopEnd;$i++){
			$childInfoNew = array(
								  'transaction_code' => $transCode,
								  'usid' =>'',
								  'API_packages_id' => $packageID ,
								  'isLeader' => '0',
								  'isContact' => '0',
								  'isAdult' => '0',
								  'isChild' => '1',
								  'title' => $childSalutation[$i],
								  'first_name' => $childFirstName[$i],
								  'last_name' => $childLastName[$i],
								  'traveler_type' => $childTravelerType[$i],
								  'age' => $childAge[$i],
								  'passport_number' => $childPassportNumber[$i],
								  'dob' => $childDOB[$i],
								  'passport_expired_date' => $childPassportExpiredDate[$i],
								  'passport_issuance_country' =>  $childPassportIssuanceCountry[$i],
								  'nationality_code' => $childNationality[$i],
								);	
			
			$this->db->insert('traveler_info', $childInfoNew); 
			}	
      
		    $dataUpdt = array(
               'book_step' => '2',
               'payment_method' => $paymentMethod,
               'credit_card_number' => $cardNumber,
               'card_secure_code' => $cardSecureCode,
               'name_on_card' => $cardHolderName,
               'card_expiry' => $cardExpiryDate,
               'arrive_flight_number' => $arrivalFlightNumber,
               'departure_flight_number' => $departFlightNumber,
               'arrive_flight_date' => $arrivalDate,
               'departure_flight_date' => $departDate,
               /*'pickup_dropoff' => $pickupDropoff,*/
               
            );

			$this->db->where('transaction_code', $transCode);
			$this->db->update('book_packages', $dataUpdt); 
		  /* unset/remove session bookingUSID*/
         $this->session->unset_userdata('bookingID');
		 /*redirect(base_url(),'refresh');*/
		 $data['pagecontent'] = "user/booking_success";
		 $this->load->vars($data);
		 $this->load->view('template');
		}
		
	}
	
	function form(){
		$uriUsid = $this->uri->uri_to_assoc(3);
		$bkngUsid = $uriUsid['bid']; 	
		
		$data['idBkng'] = $bkngUsid;
		$data['pagecontent'] = 'user/form_booking_package_manual';
		$this->load->view('template', $data);
	}
	
	
	function master(){
		
	
		$data['aktif']=2;
		//count total rows of packages list
		$config['base_url'] = base_url().'index.php/booking/master';
		$config['total_rows'] = $this->db->count_all('book_packages');
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['num_links'] = 1;
		$config['full_tag_open'] = '<li >';
		$config['full_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li class="k-link k-pager-nav k-state-disabled" title="Go to the previous page">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li class="k-link k-pager-nav k-state-disabled" title="Go to the next page">';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li style="float: left;" class="k-link k-pager-nav k-state-disabled k-state-selected"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="k-link k-pager-nav k-state-disabled k-pager-numbers k-reset">';
		$config['num_tag_close'] = '</li>';
		 
		$config['first_tag_open'] = '<li class="k-link k-pager-nav k-pager-first k-state-disabled" title="Go to the first page">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="k-link k-pager-nav k-pager-last k-state-disabled" title="Go to the last page">';
		$config['last_tag_close'] = '</li>';
		 
		$config['first_link'] = '&lt;&lt;';
		$config['last_link'] = '&gt;&gt;';
		
		$this->pagination->initialize($config);
		$data['total_rows'] = $config['total_rows'] ;
		$data['title'] = 'List packages';
		$data['text'] = $this->booking_model->view_bookings($config['per_page'],$this->uri->segment(3));
		$data['pagecontent'] = "admin/booking_master";
		$this->load->vars($data);
		$this->load->view('template');
	}
	
}
?>