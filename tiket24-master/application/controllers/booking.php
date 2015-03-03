<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Booking extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('pagination');
		$this->load->helper(array('form','url'));
		$this->load->library('form_validation');
		$this->load->model('booking_model');
		$this->load->model('finance');
		$this->load->model('errorlog_model');
		$mailconfig = Array(
					//‘protocol’ => ‘smtp’,
					//‘smtp_host’ => ‘http://example.com’,
					//‘smtp_port’ => 25,
					//‘smtp_user’ => ‘info@example.com’,
					//‘smtp_pass’ => ‘xxxxxx’,
					'mailtype'  => 'html',
					//‘charset’  => ‘iso-8859-1’
				);
		$this->load->library('email', $mailconfig);
	}
	
	function validate(){
	$defaultDate = date('Y-m-d');
	$defaultAge = '32';
		$urlTC = $this->uri->uri_to_assoc(2);
		$transCode = $urlTC['validate'];
		$SOAP = $this->API_asiatravel_ActivityWS();
		//echo $transCode;
/* =================================booking validation process start here============================= */	
			$this->db->select('*');
				$this->db->from('book_packages');
				$this->db->where('transaction_code', $transCode);
				$qrySlctBkng = $this->db->get();
				foreach($qrySlctBkng->result() as $rowsBkng){
					$bkngPckgId = $rowsBkng->API_packages_id;
					$adult = $rowsBkng->adult;
					$child = $rowsBkng->child;
					$currencyBkng = $rowsBkng->currency_code;
					$childBkngAges = $rowsBkng->child_ages;
					$travelDate = $rowsBkng->travel_date;
					$totAmount = $rowsBkng->total_amount;
					$transCode = $rowsBkng->transaction_code;
					$pickupDropoff = $rowsBkng->pickup_dropoff;
					$arrivalFlightNumber = $rowsBkng->arrive_flight_number;
					$departFlightNumber = $rowsBkng->departure_flight_number;
					$arrivalDate = $rowsBkng->arrive_flight_date;
					$departDate = $rowsBkng->departure_flight_date;
					$totSaleAmount = $rowsBkng->total_sale_price_amount;
					$usrID = $rowsBkng->user_id;
					$tmpPendingPnt = $rowsBkng->pending_point;
					$isRadeemPnt = $rowsBkng->isRadeemPoint;
					$rdmdPnt = $rowsBkng->pointRadeem;
					
				}
				$actvtyID = $bkngPckgId;
				$adultPax = $adult;
				$childPax = $child;
				$travelDate = $travelDate;
				$crrncy = $currencyBkng;
				$childPaxAge = unserialize($childBkngAges);
				$adultLoopEnd = $adult - 1;
				$childLoopEnd = $child - 1; 
		
		/* input activity search price end here */	
		//$pckUpPnt = array();
		if(!empty($pickupDropoff)){
			$qryPickDrop = $this->db->get_where('pickup_point', array('API_packages_id' => $actvtyID, 'hotel_code' => $pickupDropoff));
			foreach($qryPickDrop->result() as $rowPUDO){
				$pckUpPnt_name = $rowPUDO->hotel_name;
				$pckUpPnt_id = $rowPUDO->hotel_code;
			}
		}
		else{
			$pckUpPnt_name = '-1';
			$pckUpPnt_id = 'none';
		}
		//$arrDtaPckUpPnt = array($pckUpPnt);
		
		$trvlLdr = $this->db->get_where('traveler_info', array('transaction_code'=>$transCode,'isLeader'=>'1'));
		$dataTrvlLdr = array();
		foreach($trvlLdr->result() as $row){
			$TrvlLdr_Title = $row->title;
			$TrvlLdr_FirstName = $row->first_name;
			$TrvlLdr_LastName = $row->last_name;
			$TrvlLdr_PassengerType = $row->traveler_type;
			$TrvlLdr_Age = $row->age;
			$TrvlLdr_PassportNumber = $row->passport_number;
			$TrvlLdr_DOB = $row->dob;
			$TrvlLdr_PassportExpiryDate = $row->passport_expired_date;
			$TrvlLdr_PassportIssuanceCountry = $row->passport_issuance_country;
			$TrvlLdr_NationalityID = $row->nationality_id;
			
			$dataTrvlLdr['Title'] = "$TrvlLdr_Title";
			$dataTrvlLdr['FirstName'] = "$TrvlLdr_FirstName";
			$dataTrvlLdr['LastName'] = "$TrvlLdr_LastName";
			$dataTrvlLdr['PassengerType'] = "$TrvlLdr_PassengerType";
			$dataTrvlLdr['Age'] = "$TrvlLdr_DOB";
			$dataTrvlLdr['PassportNumber'] = "$TrvlLdr_PassportNumber";
			$dataTrvlLdr['DOB'] = "$TrvlLdr_DOB";
			$dataTrvlLdr['PassportExpiryDate'] = "$TrvlLdr_PassportExpiryDate";
			$dataTrvlLdr['PassportIssuanceCountry'] = "$TrvlLdr_PassportIssuanceCountry";
			$dataTrvlLdr['NationalityID'] = "$TrvlLdr_NationalityID";
		}
		$arrDtaTrvlLdr = array($dataTrvlLdr);
		

		$trvlCntct = $this->db->get_where('traveler_info', array('transaction_code'=>$transCode,'isContact'=>'1'));
		$datatrvlCntct = array();
		foreach($trvlCntct->result() as $row){
			$trvlCntct_Salutation = $row->title;
			$trvlCntct_FirstName = $row->first_name;
			$trvlCntct_LastName = $row->last_name;
			$trvlCntct_Email = $row->email;
			$trvlCntct_Email2 = $row->alternate_email;
			$trvlCntct_ContactNumber = $row->contact_number;
			$trvlCntct_MobileNumber = $row->mobile_number;
			$trvlCntct_FaxNumber = $row->fax_number;
			$trvlCntct_Address = $row->address;
			$trvlCntct_PostalCode = $row->postal_code;
			$trvlCntct_City = $row->city_code;
			$trvlCntct_CountryCode = $row->country_code;
			$trvlCntct_NationalityID = $row->nationality_id;
			$trvlCntct_NationalityCode = $row->nationality_code;
			
			$datatrvlCntct['Salutation'] = "$trvlCntct_Salutation";
			$datatrvlCntct['FirstName'] = "$trvlCntct_FirstName";
			$datatrvlCntct['LastName'] = "$trvlCntct_LastName";
			$datatrvlCntct['Email'] = "$trvlCntct_Email";
			$datatrvlCntct['Email2'] = "$trvlCntct_Email2";
			$datatrvlCntct['ContactNumber'] = "$trvlCntct_ContactNumber";
			$datatrvlCntct['MobileNumber'] = "$trvlCntct_MobileNumber";
			$datatrvlCntct['FaxNumber'] = "$trvlCntct_FaxNumber";
			$datatrvlCntct['Address'] = "$trvlCntct_Address";
			$datatrvlCntct['PostalCode'] = "$trvlCntct_PostalCode";
			$datatrvlCntct['City'] = "$trvlCntct_City";
			$datatrvlCntct['CountryCode'] = "$trvlCntct_CountryCode";
			$datatrvlCntct['NationalityID'] = "$trvlCntct_NationalityID";
			$datatrvlCntct['NationalityCode'] = "$trvlCntct_NationalityCode";
		}
		$arrDtaTrvlCntct = array($datatrvlCntct);
		
		
		$i=1;
		$trvlAdlt = $this->db->get_where('traveler_info', array('transaction_code'=>$transCode,'isAdult'=>'1','isLeader'=>'0'));
		foreach($trvlAdlt->result() as $row){
		$j = $i-1;
		$adlt_Title = $row->title; 
		$adlt_FirstName =$row->first_name;
		$adlt_LastName = $row->last_name;
		$adlt_PassengerType = $row->traveler_type;
		$adlt_Age = $row->age;
		$adlt_PassportNumber = $row->passport_number;
		$adlt_DOB = $row->dob;
		$adlt_PassportExpiryDate = $row->passport_expired_date;
		$adlt_PassportIssuanceCountry =  $row->passport_issuance_country;
		$adlt_NationalityID = $row->nationality_id;
			
			$adultGuest[$j] = array('Title' => "$adlt_Title", 
							   'FirstName' => "$adlt_FirstName", 
							   'LastName' => "$adlt_LastName",
							   'PassengerType' => "$adlt_PassengerType",
							   'Age' => $defaultAge,//"$adlt_Age",
							  //'PassportNumber' => "$adlt_PassportNumber",
							   'DOB' => $defaultDate,//"$adlt_DOB",
							   'PassportExpiryDate' => $defaultDate,//"$adlt_PassportExpiryDate",
							   //'PassportIssuanceCountry' =>  "$adlt_PassportIssuanceCountry",
							   'NationalityID' => "$adlt_NationalityID"
							   
							   
							   );
							   
		 $i++;
		}
		
		if(!empty($childPax)){
			
			$this->db->select('*');
			$this->db->from('traveler_info');
			$this->db->where('transaction_code', $transCode);
			$this->db->where('isChild', '1');
			$this->db->order_by('id', 'asc');
			$trvlChld = $this->db->get();
			foreach($trvlChld->result() as $row){
			$j = $i-1;
			$chld_Title = $row->title;
			$chld_FirstName = $row->first_name;
			$chld_LastName = $row->last_name;
			$chld_PassengerType = $row->traveler_type;
			$chld_Age = $row->age;
			$chld_PassportNumber = $row->passport_number;
			$chld_DOB = $row->dob;
			$chld_PassportExpiryDate = $row->passport_expired_date;
			$chld_PassportIssuanceCountry =  $row->passport_issuance_country;
			$chld_NationalityID = $row->nationality_id;
				
				$childGuest[$j] = array('Title' => "$chld_Title", 
							   'FirstName' => "$chld_FirstName", 
							   'LastName' => "$chld_PassengerType",
							   'PassengerType' => $chld_PassengerType,
							   'Age' => $chld_Age,
							   //'PassportNumber' => "$chld_PassportNumber",
							   'DOB' => "$chld_DOB",
							   'PassportExpiryDate' => $defaultDate,//"$chld_PassportExpiryDate",
							   //'PassportIssuanceCountry' =>  "$chld_PassportIssuanceCountry",
							   'NationalityID' => "$chld_NationalityID"
							   
							   );
					
			$i++;
			}
		}
		
		if(!empty($childPax)){
			$arrDtaTrvlr = array_merge($adultGuest, $childGuest);
			$arrTravelers = array('Guest' => $arrDtaTrvlr);
		}
		else{
			$arrTravelers = array('Guest' => $adultGuest);
		}
		
		
		$arrChldAges = array('Age' => $childPaxAge);
		$arrTours = $this->get_tours_details_forSearhPrice($travelDate,$actvtyID);
		$Data = array(
		   'RequestParam' => array(
		    'ActivityID' => $actvtyID,
		    'Adult' => $adultPax,
		    'SeniorCitizen' => '0', 
		    'Child'=> $arrChldAges,
			'Currency' => $currencyBkng,
		    'TourDetails' => $arrTours
			)
		
		);
		
		
		$ResponsePS = $SOAP->SearchActivityPrice($Data);
		$stringPS = $SOAP->__getLastResponse();
		$xmlPS = simplexml_load_string($stringPS);
		$xmlPS->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xmlPS->registerXPathNamespace('ns', 'http://tempuri.org/');
		foreach ($xmlPS->xpath('//ns:SearchActivityPriceResult/ns:ActivitiePrice') as $itemPS)
		{
			$USID = $itemPS->USID;
			$ActivityID = $itemPS->ActivityID;
			$ActivityName = $itemPS->ActivityName;
			$BookURL = $itemPS->BookURL;
			$Adult = $itemPS->Adult;
			$Child = $itemPS->Child;
			$Country = $itemPS->Country;
			$City = $itemPS->City;
			$Currency = $itemPS->Currency;
			$PriceAdult = $itemPS->PriceAdult;
			$PriceChild = $itemPS->PriceChild;
			$PriceSeniorCitizen = $itemPS->PriceSeniorCitizen;
			$TotalAmount = $itemPS->TotalAmount;
		
		}
		 
		$dataBooking = array(
		    'RequestParam' => array(
		    'USID' => "$USID",
		    'ActivityID' => "$ActivityID",
		    'Adult' => $adultPax, 
			'SeniorCitizen' => '0',
		    'Child'=> $arrChldAges,
		    'TourDetails' => $this->get_tours_details_forBooking($travelDate, $actvtyID),
			               
			'Currency' => "$crrncy",
			'TotalPrice' => $totAmount,
			'PickUpDropOffHotel' => array('PickupPointID' => $pckUpPnt_id,'PickupDropOffPoint' => $pckUpPnt_name),
			'LeadTravelerInfo' => array(	
			                           'Title' => $TrvlLdr_Title,
										'FirstName' => $TrvlLdr_FirstName,
										'LastName' => $TrvlLdr_LastName,
										'PassengerType' => $TrvlLdr_PassengerType,
										'Age' => $defaultAge,//$TrvlLdr_Age,
										//'PassportNumber' => $TrvlLdr_PassportNumber,
										'DOB' => $defaultDate,//$TrvlLdr_DOB,
										'PassportExpiryDate' => $defaultDate,//$TrvlLdr_PassportExpiryDate,
										//'PassportIssuanceCountry' => $TrvlLdr_PassportIssuanceCountry,
										'NationalityID' => $TrvlLdr_NationalityID
							            ),
		
			
		    'GuestDetails' => $arrTravelers,
			/*                
		    'FlightInfo'=> array(
			                     'ArrivalFlightNumber' => $arrivalFlightNumber,
								  'DepartureFlightNumber' => $departFlightNumber,
								  'ArrivalDate' => $arrivalDate,
								  'DepartureDate' => $departDate
							  ),
			*/				  
			'ContactInfo' => array(
			
			
			                      'Salutation' => $trvlCntct_Salutation,
								  'FirstName' => $trvlCntct_FirstName,
								  'LastName' => $trvlCntct_LastName,
								  'Email' => $trvlCntct_Email,
								  //'Email2' => $trvlCntct_Email2,
								  'ContactNumber' => $trvlCntct_ContactNumber,
								  //'MobileNumber' => $trvlCntct_MobileNumber,
								  //'FaxNumber' => $trvlCntct_FaxNumber,
								  //'Address' => $trvlCntct_Address,
								  //'PostalCode' => $trvlCntct_PostalCode,
								  //'City' => $trvlCntct_City,
								  //'CountryCode' => $trvlCntct_CountryCode,
								  'NationalityID' => $TrvlLdr_NationalityID,
								  //'NationalityCode' => $trvlCntct_NationalityCode
							  ),
			'CreditCardInfo'=> $this->get_credit_card_info(),
					  ),
		);
		/*====================================Insert to API
		$Response = $SOAP->BookActivity($dataBooking);
		$stringBooking = $SOAP->__getLastResponse();
		
		
		$xmlBooking = simplexml_load_string($stringBooking);
		$xmlBooking->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xmlBooking->registerXPathNamespace('ns', 'http://tempuri.org/');
		R-20150126 ========================================*/
		
		//echo '====================<b>Booking Activity Output</b>====================<br />';
		foreach ($xmlBooking->xpath('//ns:BookActivityResult') as $itemBooking)
		{			
			/*
			$bkngUSID = $itemBooking->USID;
			$bkngActivityID = $itemBooking->ActivityID;
			$bkngConfirmNumber = $itemBooking->ConfirmationNumber;
			$bkngStatus = $itemBooking->BookingStatus;
			$bkngTotPrice = $itemBooking->TotalPrice;
			$USSVisId = $itemBooking->USS->VisualID;
			$DisneyVisId = $itemBooking->Disney->VisualID;
			$SunwayLagoonVisId = $itemBooking->SunwayLagoon->VisualID;
			$TourAttractionVisId = $itemBooking->TourAttraction->VisualID;
				if(!empty($USSVisId)){
					$bkngVisualID = $itemBooking->USS->VisualID;
					$bkngTicketType = $itemBooking->USS->TicketType;
					$bkngTravelDate = $itemBooking->USS->TravelDate;
				}
				if(!empty($DisneyVisId)){
					$bkngVisualID = $itemBooking->Disney->VisualID;
					$bkngVisualIDExpiryDate = $itemBooking->Disney->VisualIDExpiryDate;
					$bkngTicketType = $itemBooking->Disney->TicketType;
					$bkngTravelDate = $itemBooking->Disney->TravelDate;
				}
				if(!empty($SunwayLagoonVisId)){
					$bkngVisualID = $itemBooking->SunwayLagoon->VisualID;
					$bkngVisualIDExpiryDate = $itemBooking->SunwayLagoon->VisualIDExpiryDate;
					$bkngTicketType = $itemBooking->SunwayLagoon->TicketType;
	
	
					$bkngTravelDate = $itemBooking->SunwayLagoon->TravelDate;
				}
				if(!empty($TourAttractionVisId)){
					$bkngVisualID = $itemBooking->TourAttraction->VisualID;
					$bkngVisualIDExpiryDate = $itemBooking->TourAttraction->VisualIDExpiryDate;
					$bkngTravelDate = $itemBooking->TourAttraction->TravelDate;
				}
				
					if(!empty($bkngVisualID) && !empty($bkngVisualIDExpiryDate)){
						$visID = $bkngVisualID;
						$visIDExpiry = $bkngVisualIDExpiryDate;
					}
					else{
						$visID = '';
						$visIDExpiry = '';
					}
				*/
				
				/* APIv2.0 booking response */
			 $bkngUSID = $itemBooking->USID;
			 $bkngActivityID = $itemBooking->ActivityID;
			 $bkngStatus = $itemBooking->BookingStatus;
			 $bkngConfirmNumber = $itemBooking->ConfirmationNumber;
			 $pckgeCurrency = $itemBooking->Currency;
			 $voucherUrl = $itemBooking->TourAttraction->VoucherURLS->VoucherURL;
			 $bkngTotPrice = $itemBooking->TotalPrice;
			 /* catch error to DB start here */
				$ErrorCode = $itemBooking->Errors->ErrorCode;
				$ErrorMessage = $itemBooking->Errors->ErrorMessage;
				if(isset($ErrorCode)){
					$errMethod = 'BookActivity';
					$errPckgRefNo = $this->errorlog_model->get_package_refno($bkngActivityID);
					$errPckgID = $bkngActivityID;
					$usrAgent = $this->agent->browser().' at '.$this->input->ip_address();
					$errValue = 'Error from API Server, ErrCode='.$ErrorCode.', ErrMsg='.$ErrorMessage;
					$this->errorlog_model->save_error_toDB($errMethod, $errPckgRefNo, $errPckgID, $errValue, $usrAgent);
				}
			 /* catch error to DB end here */
				if($usrID !== '0'){
					$slctUsr = $this->db->get_where('users', array('users_id' => $usrID));
					foreach($slctUsr->result() as $rowUsr){
						$usrExstngPnt = $rowUsr->total_point;
					}
					$totUsrPnt = $tmpPendingPnt + $usrExstngPnt;
					if($isRadeemPnt == '0'){
						$usrFnalPnt = $totUsrPnt - $rdmdPnt; 
						$dtaUpdtUsr = array('total_point' => $usrFnalPnt);
					}
					else{
						$dtaUpdtUsr = array('total_point' => $totUsrPnt);
					}
				
					$updtUsr = $this->db->where('users_id', $usrID);
					$updtUsr = $this->db->update('users', $dtaUpdtUsr); 
				}
		        $dataUpdt = array(
						               'usid' => "$bkngUSID",
						               'validated' => "1",
						               'api_booking_status' => $itemBooking->BookingStatus,
						               'api_confirmation_number' => "$itemBooking->ConfirmationNumber",
						               //'visual_id' => "$visID",
						               //'visual_id_expiry' => "$visIDExpiry",
						               'booking_expiry' => '',
						               'pending_point' => 0,
									    'voucher_url' => htmlspecialchars_decode($voucherUrl)
				            	);
				$this->db->where('transaction_code', $transCode);
				$this->db->update('book_packages', $dataUpdt); 
				
				
				$trvlDta = array('usid' => "$bkngUSID");
				$updtTrvlrDta = $this->db->where('transaction_code', $transCode);
				$updtTrvlrDta = $this->db->update('traveler_info', $trvlDta); 
				/* save data booking and traveler to database end here */	
				
				$this->sending_email_confirm_payByCC($transCode,$trvlCntct_Email,$trvlCntct_Salutation,$trvlCntct_FirstName,$trvlCntct_LastName,$voucherUrl);
				redirect('/transaction/view/', 'refresh');
			}		
		
/* =================================booking validation process end here============================= */	
	}
	
	function delete(){
		$urlTC = $this->uri->uri_to_assoc(2);
		$transCode = $urlTC['delete'];
		 
		$this->db->delete('traveler_info', array('transaction_code' => $transCode)); 
		$this->db->delete('book_packages', array('transaction_code' => $transCode)); 
		redirect('/transaction/view/', 'refresh');
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
/* ===============================================booking processing request start here==================================== */
function processing(){
	$defaultDate = date('Y-m-d');
	$defaultAge = '32';
	
	$SOAP = $this->API_asiatravel_ActivityWS();
	$bkngUsid = $this->uri->segment(3);
	$salutationTL = $this->input->post('salutationTL');	
	$firstNameTL = $this->input->post('txtFirstNameTL');
	$lastNameTL = $this->input->post('txtLastNameTL');
	$ageTL = $this->input->post('txtAgeTL');
	//$passportNumberTL = $this->input->post('txtPssprtNmbrTL');
	$dayOfBirthTL = $this->input->post('txtDobTL');
	$passportExpiredDateTL = $this->input->post('txtPssprtExpryDteTL');
	//$passportIssuanceCountryTL = $this->input->post('txtPssprtIssuanceCntryTL');
	$nationalityTL = $this->input->post('nationalityIdTL');
	
	$salutationTC = $this->input->post('salutationTravCntc');
	$firstNameTC = $this->input->post('txtFirstNameTravCntc');
	$lastNameTC = $this->input->post('txtLastNameTC');
	$emailTC = $this->input->post('txtEmailTravCntc_1');
	//$alternateEmailTC = $this->input->post('txtEmailTravCntc_2');
	$phoneNumberTC = $this->input->post('txtPhoneNumberTravCntc');
	//$mobileNumberTC = $this->input->post('txtMobileNumberTravCntc');
	//$faxNumberTC = $this->input->post('txtFaxNumberTravCntc');
	//$addressTC = $this->input->post('txtaddressTravCntc');
	//$postalCodeTC = $this->input->post('txtPostalCodeTravCntc');
	//$countryTC = $this->input->post('txtCntryCodeTravCntc');
	//$cityTC = $this->input->post('txtCityCodeTravCntc');
	//$nationalityIdTC = $this->input->post('nationalityIdTravCntc');
	//$nationalityCodeTC = $this->input->post('nationalityCodeTravCntc');
	
	$arrivalFlightNumber = $this->input->post('txtArrivFlightNum');
	$departFlightNumber = $this->input->post('txtDepartFlightNum');
	$arrivalDate = $this->input->post('txtArrivDate');
	$departDate = $this->input->post('txtDepartDate');
	$pickupDropoff = $this->input->post('pikupDropoff');
	
	$cardNumber = $this->input->post('txtCardNumber');
	$cardSecureCode = $this->input->post('txtCardSecureCode');
	$cardHolderName = $this->input->post('txtNameOnCard');
	$cardExpiryDate = $this->input->post('txtCardExpiryDate');
	
	//$adultTravelerType = $this->input->post('travelerTypeAdult');
	//$adultSalutation = $this->input->post('salutationAdult');
	//$adultFirstName = $this->input->post('txtFrstNmeAdult');
	//$adultLastName = $this->input->post('txtLstNmeAdult');
	//$adultAge = $this->input->post('txtAgeAdult');
	//$adultPassportNumber = $this->input->post('txtPssprtNmbrAdult');
	//$adultDOB = $this->input->post('txtDobAdult');
	//$adultPassportExpiredDate = $this->input->post('txtPssprtExpryDteAdult');
	//$adultPassportIssuanceCountry = $this->input->post('txtPssprtIssncCntryAdult');
	//$adultNationality = $this->input->post('ntnlityIdAdult');
	
	$childTravelerType = $this->input->post('travelerTypeChild');
	$childSalutation = $this->input->post('salutationChild');
	$childFirstName = $this->input->post('txtFrstNmeChild');
	$childLastName = $this->input->post('txtLstNmeChild');
	$childAge = $this->input->post('txtAgeChild');
	//$childPassportNumber = $this->input->post('txtPssprtNmbrChild');
	$childDOB = $this->input->post('txtDobChild');
	$childPassportExpiredDate = $this->input->post('txtPssprtExpryDteChild');
	//$childPassportIssuanceCountry  = $this->input->post('txtPssprtIssnceCntryChild');
	//$childNationality = $this->input->post('ntnalityIdChild');
	
			//	echo $paymentMethod = $this->input->post('paymethod');	
	
	$config = array(
			   array('field'   => 'salutationTL', 'label'   => 'Last Name', 'rules'   => 'required'),
               array('field'   => 'txtFirstNameTL', 'label'   => 'First Name', 'rules'   => 'required|xss_clean'),
			   array('field'   => 'txtLastNameTL', 'label'   => 'Last Name', 'rules'   => 'required'),
			  // array('field'   => 'txtAgeTL', 'label'   => 'Age', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtNmbrTL', 'label'   => 'Passport Number', 'rules'   => 'required'),
			   //array('field'   => 'txtDobTL', 'label'   => 'Date of Birth', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtExpryDteTL', 'label'   => 'Passport Expired Date', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtIssuanceCntryTL', 'label'   => 'Passport Issuance Country', 'rules'   => 'required'),
			   array('field'   => 'nationalityIdTL', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
			   array('field'   => 'txtFirstNameTravCntc', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtLastNameTC', 'label'   => 'Last Name', 'rules'   => 'required'),
			   array('field'   => 'txtEmailTravCntc_1', 'label'   => 'Email', 'rules'   => 'required'),
			   //array('field'   => 'txtEmailTravCntc_2', 'label'   => 'Alternate Email', 'rules'   => 'required'),
			   array('field'   => 'txtPhoneNumberTravCntc', 'label'   => 'Phone Number', 'rules'   => 'required'),
			   //array('field'   => 'txtMobileNumberTravCntc', 'label'   => 'Mobile Number', 'rules'   => 'required'),
			   //array('field'   => 'txtFaxNumberTravCntc', 'label'   => 'Fax. Number', 'rules'   => 'required'),
			   //array('field'   => 'txtaddressTravCntc', 'label'   => 'Address', 'rules'   => 'required'),
			   //array('field'   => 'txtPostalCodeTravCntc', 'label'   => 'Postal Code', 'rules'   => 'required'),
			   //array('field'   => 'txtCntryCodeTravCntc', 'label'   => 'Country', 'rules'   => 'required'),
			   //array('field'   => 'txtCityCodeTravCntc', 'label'   => 'City', 'rules'   => 'required'),
			   //array('field'   => 'nationalityIdTravCntc', 'label'   => 'Nationality', 'rules'   => 'required'),
			   //array('field'   => 'nationalityCodeTravCntc', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
			   array('field'   => 'txtArrivFlightNum', 'label'   => 'Arrival Flight Number', 'rules'   => 'required'),
			   array('field'   => 'txtDepartFlightNum', 'label'   => 'Departure Flight Number', 'rules'   => 'required'),
			   array('field'   => 'txtArrivDate', 'label'   => 'Arrival Date', 'rules'   => 'required'),
			   array('field'   => 'txtDepartDate', 'label'   => 'Departure Date', 'rules'   => 'required'),
			  
			   //array('field'   => 'txtFrstNmeAdult[]', 'label'   => 'First Name', 'rules'   => 'required'),
			   //array('field'   => 'txtLstNmeAdult[]', 'label'   => 'Last Name', 'rules'   => 'required'),
			   //array('field'   => 'txtAgeAdult[]', 'label'   => 'Age', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtNmbrAdult[]', 'label'   => 'Passport Number', 'rules'   => 'required'),
			   //array('field'   => 'txtDobAdult[]', 'label'   => 'Day of Birth', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtExpryDteAdult[]', 'label'   => 'Passport Ewxpired Date', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtIssncCntryAdult[]', 'label'   => 'Passport Issuance Country', 'rules'   => 'required'),
			   //array('field'   => 'ntnlityIdAdult[]', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
			   //array('field'   => 'txtFrstNmeChild[]', 'label'   => 'First Name', 'rules'   => 'required'),
			   //array('field'   => 'txtLstNmeChild[]', 'label'   => 'Last Name', 'rules'   => 'required'),
			   //array('field'   => 'txtAgeChild[]', 'label'   => 'Age', 'rules'   => 'required'),
			  // array('field'   => 'txtPssprtNmbrChild[]', 'label'   => 'Passport Number', 'rules'   => 'required'),
			   //array('field'   => 'txtDobChild[]', 'label'   => 'Day Of Birth', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtExpryDteChild[]', 'label'   => 'Passport Expiry Date', 'rules'   => 'required'),
			  //array('field'   => 'txtPssprtIssnceCntryChild[]', 'label'   => 'Passport Issuance Country', 'rules'   => 'required'),
			   //array('field'   => 'ntnalityIdChild[]', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
            );

		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			
			$pid = $this->input->post('pid');	
			$qry = $this->db->get_where('tours', array('API_packages_id'=>$pid));
			foreach($qry->result() as $row){
				$tourName = $row->tour_name;
			}
			$data['packageTourName'] = "$tourName"; 
			$data['packageAPIid'] = "$pid"; 
			$data['pagecontent'] = 'user/booking';
			$this->load->vars($data);
			$this->load->view('template');
		}
		else
		{
/* ==========================================member & reseller booking start here========================================== */	
			if ($this->tank_auth->is_logged_in()){
				$userRoleID = $this->tank_auth->get_user_role_id();
				$userID = $this->tank_auth->get_user_id();
				$usid = $this->input->post('usid');	
				$pid = $this->input->post('pid');	
				$paymentMethod = $this->input->post('paymethod');	
				$isRadeem = $this->input->post('radeemMyPoint');
/* ======================================booking payment with credit card for member & reseller start here====================================== */		
				if($paymentMethod == 'MP0001'){
/* ===============================validate credit card to payment gateway provider start here============================= */	
				$resultCCvalid = $this->validate_creditCard();
/* ===============================validate credit card to payment gateway provider end here============================= */	
					if($resultCCvalid == TRUE){
/* =================================if credit card is valid start here=================================================== */
/* input activity search price start here */	
				//echo "test!!!";
				$this->db->select('*');
				$this->db->from('book_packages');
				$this->db->where('usid', $usid);
				$qrySlctBkng = $this->db->get();
				foreach($qrySlctBkng->result() as $rowsBkng){
					$bkngPckgId = $rowsBkng->API_packages_id;
					$adult = $rowsBkng->adult;
					$child = $rowsBkng->child;
					$currencyBkng = $rowsBkng->currency_code;
					$childBkngAges = $rowsBkng->child_ages;
					$travelDate = $rowsBkng->travel_date;
					$totAmount = $rowsBkng->total_amount;
					$transCode = $rowsBkng->transaction_code;
					$totSaleAmount = $rowsBkng->total_sale_price_amount;
					$usrID = $rowsBkng->user_id;
				}
				$actvtyID = $bkngPckgId;
				$adultPax = $adult;
				$childPax = $child;
				$travelDate = $travelDate;
				$crrncy = $currencyBkng;
				$childPaxAge = unserialize($childBkngAges);
				$adultLoopEnd = $adult - 1;
				$childLoopEnd = $child - 1; 
				$slctUsr = $this->db->get_where('users', array('users_id' => $usrID));
				foreach($slctUsr->result() as $rowUsr){
					$usrExstngPnt = $rowUsr->total_point;
				}
				$gainedPoint = $this->gained_point($totSaleAmount);
				$totGainedPoint = $usrExstngPnt + $gainedPoint;
		
		/* input activity search price end here */	
		if(!empty($pickupDropoff)){
			$qryPickDrop = $this->db->get_where('pickup_point', array('hotel_code' => $pickupDropoff));
			foreach($qryPickDrop->result() as $row){
				$pckUpPnt_name = $row->hotel_name;
				$pckUpPnt_id = $row->hotel_code;
			}
		}
		else{
			$pckUpPnt_name = 'none';
			$pckUpPnt_id = '-1';
		}
		
		
		$TL_ntnlty = explode('-',$nationalityTL);
		$TL_ntnltyId = $TL_ntnlty[0];
		$TL_ntnltyCode = $TL_ntnlty[1];
		
		//$TC_ntnlty = explode('-',$nationalityCodeTC);
		//$TC_ntnltyId = $TC_ntnlty[0];
		//$TC_ntnltyCode = $TC_ntnlty[1];
		
		for($i=1;$i <= $adultLoopEnd;$i++){
		$j= $i-1;
			//$Adlt_ntnlty = explode('-',$adultNationality[$j]);
			//$Adlt_ntnltyId = $Adlt_ntnlty[0];
			//$Adlt_ntnltyCode = $Adlt_ntnlty[1];
			$adultGuest[$j] = array('Title' => $salutationTL,//$adultSalutation[$j], 
							   'FirstName' => $firstNameTL,//$adultFirstName[$j], 
							   'LastName' => $lastNameTL,//$adultLastName[$j],
							   'PassengerType' => '32',
							   'Age' => $defaultAge,//'32',//$ageTL,//$adultAge[$j],
							   //'PassportNumber' => $adultPassportNumber[$j],
							   'DOB' => $defaultDate,//$adultDOB[$j],
							   'PassportExpiryDate' => $defaultDate,//$adultPassportExpiredDate[$j],
							   //'PassportIssuanceCountry' =>  $adultPassportIssuanceCountry[$j],
							   'NationalityID' => $TL_ntnltyId,//$Adlt_ntnltyId
							   );
							 
		}
		
		if(!empty($child)){
			for($i=1;$i <= $child;$i++){
			$j= $i-1;
				//$Chld_ntnlty = explode('-',$childNationality[$j]);
				//$Chld_ntnltyId = $Chld_ntnlty[0];
				//$Chld_ntnltyCode = $Chld_ntnlty[1];
				$childGuest[$j] = array('Title' => $childSalutation[$j], 
								   'FirstName' => $childFirstName[$j], 
								   'LastName' => $childLastName[$j],
								   'PassengerType' => '33',
								   'Age' => $childAge[$j],
								   //'PassportNumber' => $childPassportNumber[$j],
								   'DOB' => $childDOB[$j],
								   'PassportExpiryDate' => $defaultDate ,//$childPassportExpiredDate[$j],
								   //'PassportIssuanceCountry' =>  $childPassportIssuanceCountry[$j],
								   'NationalityID' =>  $TL_ntnltyId,//$Chld_ntnltyId
								   );
			}
		}
		if(!empty($child)){
			$arrTravelers = array_merge($adultGuest, $childGuest);
		}
		else{
			$arrTravelers = array_merge($adultGuest);
		}
		
		
		$dataBooking = array(
		     'RequestParam' => array(
		    'USID' => $usid,
		    'ActivityID' => $bkngPckgId,
		    'Adult' => $adult , 
			'SeniorCitizen' => '0',
		    'Child'=> $this->get_arrChildAge($childPaxAge),
		    'TourDetails' => $this->get_tours_details_forBooking($travelDate, $pid),
			               
			'Currency' => $currencyBkng,
			'TotalPrice' => $totAmount,
			'PickUpDropOffHotel'=> array(
			                          'PickupPointID' => $pckUpPnt_id,
										'PickupDropOffPoint' => $pckUpPnt_name,
							            ),
										
			'LeadTravelerInfo'=> array(	
			                           'Title' => $salutationTL,
										'FirstName' => $firstNameTL,
										'LastName' => $lastNameTL,
										'PassengerType' => '32',
										'Age' => $defaultAge ,//$ageTL,//$ageTL,
										//'PassportNumber' => $passportNumberTL,
										'DOB' => $defaultDate,//$dayOfBirthTL,
										'PassportExpiryDate' => $defaultDate,//$passportExpiredDateTL,
										//'PassportIssuanceCountry' => $passportIssuanceCountryTL,
										'NationalityID' => $TL_ntnltyId
							            ),
		    'GuestDetails' => $arrTravelers,
			                
		    'FlightInfo'=> array(
			                     'ArrivalFlightNumber' => $arrivalFlightNumber,
								  'DepartureFlightNumber' => $departFlightNumber,
								  'ArrivalDate' => $arrivalDate,
								  'DepartureDate' => $departDate
							  ),
			'ContactInfo'=> array(
			                      'Salutation' => $salutationTC,
								  'FirstName' => $firstNameTC,
								  'LastName' => $lastNameTC,
								  'Email' => $emailTC,
								  //'Email2' => $alternateEmailTC,
								  'ContactNumber' => $phoneNumberTC,
								  //'MobileNumber' => $mobileNumberTC,
								  //'FaxNumber' => $faxNumberTC,
								  //'Address' => $addressTC,
								 //'PostalCode' => $postalCodeTC,
								  //'City' => $cityTC,
								  //'CountryCode' => $countryTC,
								  'NationalityID' => $TL_ntnltyId,//$TC_ntnltyId,
								  //'NationalityCode' => $TC_ntnltyCode
							  ),
			'CreditCardInfo'=> $this->get_credit_card_info()
					  ),
		);
		
		if($isRadeem == '1'){
					$qrySlctUsrPnt = $this->db->get_where('users', array('users_id' => $usrID));
					foreach($qrySlctUsrPnt->result() as $rowUsr){
						$usrTotPnt = $rowUsr->total_point;
						$userRoleID = $rowUsr->role_id;
					}
					if($userRoleID == '2'){
						$MinimalBeli = $this->finance->get_point(13);	
						$NominalBeli = $this->finance->get_point(14);
						$PointBeli = $this->finance->get_point(15);
						$MinimalPoint = $this->finance->get_point(16);
						$PointTukar = $this->finance->get_point(17);
						$NominalBayar = $this->finance->get_point(18);
					}
					elseif($userRoleID == '3'){
						$MinimalBeli = $this->finance->get_point(19);
						$NominalBeli = $this->finance->get_point(20);
						$PointBeli = $this->finance->get_point(21);
						$MinimalPoint = $this->finance->get_point(22);
						$PointTukar = $this->finance->get_point(23);
						$NominalBayar = $this->finance->get_point(24);
					}
					$this->db->select('*');
					$this->db->from('currencies');
					$this->db->where('currency_from', 'SGD');
					$this->db->where('country_iso_from', 'SG');
					$this->db->where('currency_to', 'IDR');
					$this->db->where('country_iso_to', 'ID');
					$rateValCurr = $this->db->get();
					foreach($rateValCurr->result() as $rowRateFld){
						$valIdrRate = $rowRateFld->konversi;
						
					}
					
					$nilNomPerPoint_inSGD = $NominalBayar / $valIdrRate;
					$pntNomValue_inSGD = $usrTotPnt * $nilNomPerPoint_inSGD; 
					$gainedPntToNomValue_inSGD = round($gainedPoint * $nilNomPerPoint_inSGD, 2);
					$usrFnlPnt = round($totGainedPoint - $gainedPoint, 2);	
					$totAmountFnal = round($totSaleAmount - $gainedPntToNomValue_inSGD, 2); 
						
					$dataUpdt = array(
						   'book_step' => '2',
						   'payment_method' => $paymentMethod,
						   'arrive_flight_number' => $arrivalFlightNumber,
						   'departure_flight_number' => $departFlightNumber,
						   'arrive_flight_date' => $arrivalDate,
						   'departure_flight_date' => $departDate,
						   'pickup_dropoff' => $pickupDropoff,
						   'validated' => "1",
						   'api_booking_status' => $itemBooking->BookingStatus,
						   'api_confirmation_number' => "$itemBooking->ConfirmationNumber",
						   //'visual_id' => "$visID",
						   //'visual_id_expiry' => "$visIDExpiry",
						   'voucher_url' => htmlspecialchars_decode($voucherUrl),
						   'point_transaction' => $gainedPoint,
						   'isRadeemPoint' => '1',
						   'pointRadeem' => $gainedPoint,
						   'pointRadeem_value' => $gainedPntToNomValue_inSGD,
						   
						);
						echo "test!!!";
						$this->db->where('usid', $usid);
						$this->db->update('book_packages', $dataUpdt); 
						$fnlUsrPnt = $totGainedPoint - $gainedPoint;
						$dtUpdtUsr = array('total_point' => $fnlUsrPnt);
						$this->db->where('users_id', $usrID);
						$this->db->update('users', $dtUpdtUsr); 
						$this->sending_email_confirm_payByCC($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL, $voucherUrl);
						$data['pagecontent'] = "user/booking_success";
						$this->load->vars($data);
						$this->load->view('template');
					
				}
				else{
						$dataUpdt = array(
								   'book_step' => '2',
								   'payment_method' => $paymentMethod,
								   'arrive_flight_number' => $arrivalFlightNumber,
								   'departure_flight_number' => $departFlightNumber,
								   'arrive_flight_date' => $arrivalDate,
								   'departure_flight_date' => $departDate,
								   'pickup_dropoff' => $pickupDropoff,
								   'validated' => "1",
								   'api_booking_status' => $itemBooking->BookingStatus,
								   'api_confirmation_number' => "$itemBooking->ConfirmationNumber",
								   'voucher_url' => htmlspecialchars_decode($voucherUrl)
								   //'visual_id' => "$visID",
								   //'visual_id_expiry' => "$visIDExpiry"
							);
						echo "!!!test";	
						$this->db->where('usid', $usid);
						$this->db->update('book_packages', $dataUpdt); 
						
						$dtUpdtUsr = array('total_point' => $totGainedPoint);
						$this->db->where('users_id', $usrID);
						$this->db->update('users', $dtUpdtUsr); 
						$this->sending_email_confirm_payByCC($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL, $voucherUrl);
						$data['pagecontent'] = "user/booking_success";
						$this->load->vars($data);
						$this->load->view('template');
				}
	          
		
		/*====================================Insert to API
		$Response = $SOAP->BookActivity($dataBooking);
		$stringBooking = $SOAP->__getLastResponse();
		
		
		$xmlBooking = simplexml_load_string($stringBooking);
		$xmlBooking->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xmlBooking->registerXPathNamespace('ns', 'http://tempuri.org/');
		R-20150126 ========================================*/
		
		//echo '====================<b>Booking Activity Output</b>====================<br />';
		foreach ($xmlBooking->xpath('//ns:BookActivityResult') as $itemBooking)
		{
			/* APIv2.0 booking response */
			 $bkngUSID = $itemBooking->USID;
			 $bkngActivityID = $itemBooking->ActivityID;
			 $bkngStatus = $itemBooking->BookingStatus;
			 $bkngConfirmNumber = $itemBooking->ConfirmationNumber;
			 $pckgeCurrency = $itemBooking->Currency;
			 $voucherUrl = $itemBooking->TourAttraction->VoucherURLS->VoucherURL;
			 $bkngTotPrice = $itemBooking->TotalPrice;
			 /* catch error to DB start here */
				$ErrorCode = $itemBooking->Errors->ErrorCode;
				$ErrorMessage = $itemBooking->Errors->ErrorMessage;
				if(isset($ErrorCode)){
					$errMethod = 'BookActivity';
					$errPckgRefNo = $this->errorlog_model->get_package_refno($bkngActivityID);
					$errPckgID = $bkngActivityID;
					$usrAgent = $this->agent->browser().' at '.$this->input->ip_address();
					$errValue = 'Error from API Server, ErrCode='.$ErrorCode.', ErrMsg='.$ErrorMessage;
					$this->errorlog_model->save_error_toDB($errMethod, $errPckgRefNo, $errPckgID, $errValue, $usrAgent);
				}
			 /* catch error to DB end here */
			 
			/*				
			$bkngUSID = $itemBooking->USID;
			$bkngActivityID = $itemBooking->ActivityID;
			$bkngConfirmNumber = $itemBooking->ConfirmationNumber;
			$bkngStatus = $itemBooking->BookingStatus;
			$bkngTotPrice = $itemBooking->TotalPrice;
			$USSVisId = $itemBooking->USS->VisualID;
			$DisneyVisId = $itemBooking->Disney->VisualID;
			$SunwayLagoonVisId = $itemBooking->SunwayLagoon->VisualID;
			$TourAttractionVisId = $itemBooking->TourAttraction->VisualID;
			
			if(!empty($USSVisId)){
				$bkngVisualID = $itemBooking->USS->VisualID;
				$bkngTicketType = $itemBooking->USS->TicketType;
				$bkngTravelDate = $itemBooking->USS->TravelDate;
			}
			if(!empty($DisneyVisId)){
				$bkngVisualID = $itemBooking->Disney->VisualID;
				$bkngVisualIDExpiryDate = $itemBooking->Disney->VisualIDExpiryDate;
				$bkngTicketType = $itemBooking->Disney->TicketType;
				$bkngTravelDate = $itemBooking->Disney->TravelDate;
			}
			if(!empty($SunwayLagoonVisId)){
				$bkngVisualID = $itemBooking->SunwayLagoon->VisualID;
				$bkngVisualIDExpiryDate = $itemBooking->SunwayLagoon->VisualIDExpiryDate;
				$bkngTicketType = $itemBooking->SunwayLagoon->TicketType;


				$bkngTravelDate = $itemBooking->SunwayLagoon->TravelDate;
			}
			if(!empty($TourAttractionVisId)){
				$bkngVisualID = $itemBooking->TourAttraction->VisualID;
				$bkngVisualIDExpiryDate = $itemBooking->TourAttraction->VisualIDExpiryDate;
				$bkngTravelDate = $itemBooking->TourAttraction->TravelDate;
			}
			
				if(!empty($bkngVisualID) && !empty($bkngVisualIDExpiryDate)){
					$visID = $bkngVisualID;
					$visIDExpiry = $bkngVisualIDExpiryDate;
				}
				else{
					$visID = '';
					$visIDExpiry = '';
				}
			*/	
			
echo "gfmsdf000000000000000000jgnasdfongjasdnfgnasdfngjkndfjka!";
			/* save data booking and traveler to database start here */	                                                                                                                                                              
			$travContactInfoNew = array(
										  'transaction_code' => $transCode,
										  'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngActivityID ,
										  'isLeader' => '0',
										  'isContact' => '1',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTC,
										  'first_name' => $firstNameTC,
										  'last_name' => $lastNameTC,
										  'email' => $emailTC,
										  //'alternate_email' => $alternateEmailTC,
										  'contact_number' => $phoneNumberTC,
										  //'mobile_number' => $mobileNumberTC,
										  //'fax_number' =>  $faxNumberTC,
										  //'address' => $addressTC,
										  //'postal_code' => $postalCodeTC,
										  //'country_code' => $countryTC,
										  //'city_code' => $cityTC,
										  //'nationality_id' => $TC_ntnltyId,
										  //'nationality_code' => $TC_ntnltyCode
										   
										);	
			$this->db->insert('traveler_info', $travContactInfoNew); 
			$travLeaderInfoNew = array(
										  'transaction_code' => $transCode,
										  'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngActivityID ,
										  'isLeader' => '1',
										  'isContact' => '0',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTL,
										  'first_name' => $firstNameTL,
										  'last_name' => $lastNameTL,
										  'traveler_type' => '32',
										  //'age' => $ageTL,
										  //'passport_number' => $passportNumberTL,
										  //'dob' => $dayOfBirthTL,
										  //'passport_expired_date' => $passportExpiredDateTL,
										  //'passport_issuance_country' =>  $passportIssuanceCountryTL,
										  //'nationality_code' => $TL_ntnltyCode,
										  'nationality_id' => $TL_ntnltyId,
										);	
			  $this->db->insert('traveler_info', $travLeaderInfoNew); 
			  
echo "gfmsdf000000000000000000jgnasdfongjasdnfgnasdfngjkndfjka!";
			  for($i=1;$i <= $adultLoopEnd;$i++){
			  $j= $i - 1;
			  	//$adltNtnlty = explode('-',$adultNationality[$j]);
				//$adltNtnltyId = $adltNtnlty[0];
				//$adltNtnltyCode = $adltNtnlty[1];
						$adultInfoNew = array(
											  'transaction_code' => $transCode,
											  'usid' => "$bkngUSID",
											  'API_packages_id' => $bkngActivityID ,
											  'isLeader' => '0',
											  'isContact' => '0',
											  'isAdult' => '1',
											  'isChild' => '0',
											  'title' => $salutationTL,//$adultSalutation[$j],
											  'first_name' => $firstNameTL,//$adultFirstName[$j],
											  'last_name' => $lastNameTL,//$adultLastName[$j],
											  'traveler_type' => '32', //$adultTravelerType[$j],
											 // 'age' => $ageTL,//$adultAge[$j],
											  //'passport_number' => $adultPassportNumber[$j],
											  //'dob' => $dayOfBirthTL,//$adultDOB[$j],
											 // 'passport_expired_date' => $passportExpiredDateTL,//$adultPassportExpiredDate[$j],
											  //'passport_issuance_country' =>  $adultPassportIssuanceCountry[$j],
											  //'nationality_code' => $adltNtnltyCode,
											  'nationality_id' => $TL_ntnltyId,//$adltNtnltyId,
											);	
						
						$this->db->insert('traveler_info', $adultInfoNew); 
				}	
			 	if(!empty($child)){
					for($i=1;$i <= $child;$i++){
					$j = $i-1;
					//$chldNtnlty = explode('-',$childNationality[$j]);
					//$chldNtnltyId = $chldNtnlty[0];
					//$chldNtnltyCode = $chldNtnlty[1];
							$childInfoNew = array(
												  'transaction_code' => $transCode,
												  'usid' => "$bkngUSID",
												  'API_packages_id' => $bkngActivityID ,
												  'isLeader' => '0',
												  'isContact' => '0',
												  'isAdult' => '0',
												  'isChild' => '1',
												  'title' => $childSalutation[$j],
												  'first_name' => $childFirstName[$j],
												  'last_name' => $childLastName[$j],
												  'traveler_type' => $childTravelerType[$j],
												  'age' => $childAge[$j],
												  //'passport_number' => $childPassportNumber[$j],
												  'dob' => $childDOB[$j],
												  'passport_expired_date' => $childPassportExpiredDate[$j],
												  //'passport_issuance_country' =>  $childPassportIssuanceCountry[$j],
												  //'nationality_code' => $chldNtnltyCode,
												  //'nationality_id' => $chldNtnltyId,
												);	
							
							$this->db->insert('traveler_info', $childInfoNew); 
					}	
			 	}
				
				// if($isRadeem == '1'){
					// $qrySlctUsrPnt = $this->db->get_where('users', array('users_id' => $usrID));
					// foreach($qrySlctUsrPnt->result() as $rowUsr){
						// $usrTotPnt = $rowUsr->total_point;
						// $userRoleID = $rowUsr->role_id;
					// }
					// if($userRoleID == '2'){
						// $MinimalBeli = $this->finance->get_point(13);	
						// $NominalBeli = $this->finance->get_point(14);
						// $PointBeli = $this->finance->get_point(15);
						// $MinimalPoint = $this->finance->get_point(16);
						// $PointTukar = $this->finance->get_point(17);
						// $NominalBayar = $this->finance->get_point(18);
					// }
					// elseif($userRoleID == '3'){
						// $MinimalBeli = $this->finance->get_point(19);
						// $NominalBeli = $this->finance->get_point(20);
						// $PointBeli = $this->finance->get_point(21);
						// $MinimalPoint = $this->finance->get_point(22);
						// $PointTukar = $this->finance->get_point(23);
						// $NominalBayar = $this->finance->get_point(24);
					// }
					// $this->db->select('*');
					// $this->db->from('currencies');
					// $this->db->where('currency_from', 'SGD');
					// $this->db->where('country_iso_from', 'SG');
					// $this->db->where('currency_to', 'IDR');
					// $this->db->where('country_iso_to', 'ID');
					// $rateValCurr = $this->db->get();
					// foreach($rateValCurr->result() as $rowRateFld){
						// $valIdrRate = $rowRateFld->konversi;
						
					// }
					
					// $nilNomPerPoint_inSGD = $NominalBayar / $valIdrRate;
					// $pntNomValue_inSGD = $usrTotPnt * $nilNomPerPoint_inSGD; 
					// $gainedPntToNomValue_inSGD = round($gainedPoint * $nilNomPerPoint_inSGD, 2);
					// $usrFnlPnt = round($totGainedPoint - $gainedPoint, 2);	
					// $totAmountFnal = round($totSaleAmount - $gainedPntToNomValue_inSGD, 2); 
						
					// $dataUpdt = array(
						   // 'book_step' => '2',
						   // 'payment_method' => $paymentMethod,
						   // 'arrive_flight_number' => $arrivalFlightNumber,
						   // 'departure_flight_number' => $departFlightNumber,
						   // 'arrive_flight_date' => $arrivalDate,
						   // 'departure_flight_date' => $departDate,
						   // 'pickup_dropoff' => $pickupDropoff,
						   // 'validated' => "1",
						   // 'api_booking_status' => $itemBooking->BookingStatus,
						   // 'api_confirmation_number' => "$itemBooking->ConfirmationNumber",
						   ////'visual_id' => "$visID",
						   ////'visual_id_expiry' => "$visIDExpiry",
						   // 'voucher_url' => htmlspecialchars_decode($voucherUrl),
						   // 'point_transaction' => $gainedPoint,
						   // 'isRadeemPoint' => '1',
						   // 'pointRadeem' => $gainedPoint,
						   // 'pointRadeem_value' => $gainedPntToNomValue_inSGD,
						   
						// );
						// echo "test!!!";
						// $this->db->where('usid', $usid);
						// $this->db->update('book_packages', $dataUpdt); 
						// $fnlUsrPnt = $totGainedPoint - $gainedPoint;
						// $dtUpdtUsr = array('total_point' => $fnlUsrPnt);
						// $this->db->where('users_id', $usrID);
						// $this->db->update('users', $dtUpdtUsr); 
						// $this->sending_email_confirm_payByCC($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL, $voucherUrl);
						// $data['pagecontent'] = "user/booking_success";
						// $this->load->vars($data);
						// $this->load->view('template');
					
				// }
				// else{
						// $dataUpdt = array(
								   // 'book_step' => '2',
								   // 'payment_method' => $paymentMethod,
								   // 'arrive_flight_number' => $arrivalFlightNumber,
								   // 'departure_flight_number' => $departFlightNumber,
								   // 'arrive_flight_date' => $arrivalDate,
								   // 'departure_flight_date' => $departDate,
								   // 'pickup_dropoff' => $pickupDropoff,
								   // 'validated' => "1",
								   // 'api_booking_status' => $itemBooking->BookingStatus,
								   // 'api_confirmation_number' => "$itemBooking->ConfirmationNumber",
								   // 'voucher_url' => htmlspecialchars_decode($voucherUrl)
								   ////'visual_id' => "$visID",
								   ////'visual_id_expiry' => "$visIDExpiry"
							// );
						// echo "!!!test";	
						// $this->db->where('usid', $usid);
						// $this->db->update('book_packages', $dataUpdt); 
						
						// $dtUpdtUsr = array('total_point' => $totGainedPoint);
						// $this->db->where('users_id', $usrID);
						// $this->db->update('users', $dtUpdtUsr); 
						// $this->sending_email_confirm_payByCC($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL, $voucherUrl);
						// $data['pagecontent'] = "user/booking_success";
						// $this->load->vars($data);
						// $this->load->view('template');
				// }
	          
		
		}
		/* =================================if credit card is valid end here =================================================== */						
					}
					
					else{
/* ============================if credit card not valid start here========================================= */	
						$this->session->set_flashdata('flashMsge', 'Your credit card is not valid !');
						redirect('transaction/booking_form', 'refresh');					
/* ============================if credit card not valid end here=========================================== */
					}				
				}	
/* ======================================booking payment with credit card for member & reseller end here======================================== */	

/* ======================================booking payment with deposit balance for reseller start here====================== */ 
elseif($paymentMethod == 'MP0004'){
	$usid = $this->input->post('usid');
	$qryBkPckg = $this->db->get_where('book_packages', array('usid'=>$usid));
	
	foreach($qryBkPckg->result() as $row){
		
		$totAmnt_inIDR = $row->amount_total_sale_price_inIDR;
		
		$usid = $row->usid;
	}
	
	$isEnoughBalance = $this->check_isEnough_user_balance($userID, $totAmnt_inIDR);
	$depositCode = $this->get_user_deposit_code($userID);
	$crrntBlce = $this->get_current_balance($userID);
	if($isEnoughBalance == false){
		$this->session->set_flashdata('flashMsge_warning', '<strong>Warning !</strong> insufficient deposit balance !');
		redirect('transaction/booking_form/'.$usid, 'refresh');
	}
	else{
/* =================================if deposit balance is enough start here ========================================== */				
		$updtdBlncDpst = $crrntBlce - $totAmnt_inIDR;	
		
		$this->db->select('*');
				$this->db->from('book_packages');
				$this->db->where('usid', $usid);
				$qrySlctBkng = $this->db->get();
				foreach($qrySlctBkng->result() as $rowsBkng){
					$bkngPckgId = $rowsBkng->API_packages_id;
					$adult = $rowsBkng->adult;
					$child = $rowsBkng->child;
					$currencyBkng = $rowsBkng->currency_code;
					$childBkngAges = $rowsBkng->child_ages;
					$travelDate = $rowsBkng->travel_date;
					$totAmount = $rowsBkng->total_amount;
					$transCode = $rowsBkng->transaction_code;
					$totSaleAmount = $rowsBkng->total_sale_price_amount;
					$usrID = $rowsBkng->user_id;
				}
				$actvtyID = $bkngPckgId;
				$adultPax = $adult;
				$childPax = $child;
				$travelDate = $travelDate;
				$crrncy = $currencyBkng;
				$childPaxAge = unserialize($childBkngAges);
				$adultLoopEnd = $adult - 1;
				$childLoopEnd = $child - 1; 
				$slctUsr = $this->db->get_where('users', array('users_id' => $usrID));
				foreach($slctUsr->result() as $rowUsr){
					$usrExstngPnt = $rowUsr->total_point;
				}
				$gainedPoint = $this->gained_point($totSaleAmount);
				$totGainedPoint = $usrExstngPnt + $gainedPoint;
		
		/* input activity search price end here */	
		if(!empty($pickupDropoff)){
			$qryPickDrop = $this->db->get_where('pickup_point', array('hotel_code' => $pickupDropoff));
			foreach($qryPickDrop->result() as $row){
				$pckUpPnt_name = $row->hotel_name;
				$pckUpPnt_id = $row->hotel_code;
			}
		}
		else{
			$pckUpPnt_name = 'none';
			$pckUpPnt_id = '-1';
		}
		
		
		$TL_ntnlty = explode('-',$nationalityTL);
		$TL_ntnltyId = $TL_ntnlty[0];
		$TL_ntnltyCode = $TL_ntnlty[1];
		
		//$TC_ntnlty = explode('-',$nationalityCodeTC);
		//$TC_ntnltyId = $TC_ntnlty[0];
		//$TC_ntnltyCode = $TC_ntnlty[1];
		
		for($i=1;$i <= $adultLoopEnd;$i++){
		$j= $i-1;
			//$Adlt_ntnlty = explode('-',$adultNationality[$j]);
			//$Adlt_ntnltyId = $Adlt_ntnlty[0];
			//$Adlt_ntnltyCode = $Adlt_ntnlty[1];
			$adultGuest[$j] = array('Title' => $salutationTL,//$adultSalutation[$j], 
							   'FirstName' => $firstNameTL,//$adultFirstName[$j], 
							   'LastName' => $lastNameTL,//$adultLastName[$j],
							   'PassengerType' => '32',
							   'Age' => $defaultAge,//'32',//$ageTL,//$adultAge[$j],
							   //'PassportNumber' => $adultPassportNumber[$j],
							   'DOB' => $defaultDate,//$adultDOB[$j],
							   'PassportExpiryDate' => $defaultDate,//$adultPassportExpiredDate[$j],
							   //'PassportIssuanceCountry' =>  $adultPassportIssuanceCountry[$j],
							   'NationalityID' => $TL_ntnltyId,//$Adlt_ntnltyId
							   );
							 
		}
		
		if(!empty($child)){
			for($i=1;$i <= $child;$i++){
			$j= $i-1;
				//$Chld_ntnlty = explode('-',$childNationality[$j]);
				//$Chld_ntnltyId = $Chld_ntnlty[0];
				//$Chld_ntnltyCode = $Chld_ntnlty[1];
				$childGuest[$j] = array('Title' => $childSalutation[$j], 
								   'FirstName' => $childFirstName[$j], 
								   'LastName' => $childLastName[$j],
								   'PassengerType' => '33',
								   'Age' => $childAge[$j],
								   //'PassportNumber' => $childPassportNumber[$j],
								   'DOB' => $childDOB[$j],
								   'PassportExpiryDate' => $defaultDate ,//$childPassportExpiredDate[$j],
								   //'PassportIssuanceCountry' =>  $childPassportIssuanceCountry[$j],
								   'NationalityID' =>  $TL_ntnltyId,//$Chld_ntnltyId
								   );
			}
		}
		if(!empty($child)){
			$arrTravelers = array_merge($adultGuest, $childGuest);
		}
		else{
			$arrTravelers = array_merge($adultGuest);
		}
		
		
		$dataBooking = array(
		      'RequestParam' => array(
		    'USID' => $usid,
		    'ActivityID' => $bkngPckgId,
		    'Adult' => $adult , 
			'SeniorCitizen' => '0',
		    'Child'=> $this->get_arrChildAge($childPaxAge),
		    'TourDetails' => $this->get_tours_details_forBooking($travelDate, $pid),
			               
			'Currency' => $currencyBkng,
			'TotalPrice' => $totAmount,
			'PickUpDropOffHotel'=> array(
			                          'PickupPointID' => $pckUpPnt_id,
										'PickupDropOffPoint' => $pckUpPnt_name,
							            ),
										
			'LeadTravelerInfo'=> array(	
			                           'Title' => $salutationTL,
										'FirstName' => $firstNameTL,
										'LastName' => $lastNameTL,
										'PassengerType' => '32',
										'Age' => $defaultAge ,//$ageTL,//$ageTL,
										//'PassportNumber' => $passportNumberTL,
										'DOB' => $defaultDate,//$dayOfBirthTL,
										'PassportExpiryDate' => $defaultDate,//$passportExpiredDateTL,
										//'PassportIssuanceCountry' => $passportIssuanceCountryTL,
										'NationalityID' => $TL_ntnltyId
							            ),
		    'GuestDetails' => $arrTravelers,
			                
		    'FlightInfo'=> array(
			                     'ArrivalFlightNumber' => $arrivalFlightNumber,
								  'DepartureFlightNumber' => $departFlightNumber,
								  'ArrivalDate' => $arrivalDate,
								  'DepartureDate' => $departDate
							  ),
			'ContactInfo'=> array(
			                      'Salutation' => $salutationTC,
								  'FirstName' => $firstNameTC,
								  'LastName' => $lastNameTC,
								  'Email' => $emailTC,
								  //'Email2' => $alternateEmailTC,
								  'ContactNumber' => $phoneNumberTC,
								  //'MobileNumber' => $mobileNumberTC,
								  //'FaxNumber' => $faxNumberTC,
								  //'Address' => $addressTC,
								 //'PostalCode' => $postalCodeTC,
								  //'City' => $cityTC,
								  //'CountryCode' => $countryTC,
								  'NationalityID' => $TL_ntnltyId,//$TC_ntnltyId,
								  //'NationalityCode' => $TC_ntnltyCode
							  ),
			'CreditCardInfo'=> $this->get_credit_card_info()
					  ),
		);
	/*====================================Insert to API
		$Response = $SOAP->BookActivity($dataBooking);
		$stringBooking = $SOAP->__getLastResponse();
		
		
		$xmlBooking = simplexml_load_string($stringBooking);
		$xmlBooking->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xmlBooking->registerXPathNamespace('ns', 'http://tempuri.org/');
	R- 20150126 ====================================*/
	
		//echo '====================<b>Booking Activity Output</b>====================<br />';
		
		foreach ($xmlBooking->xpath('//ns:BookActivityResult') as $itemBooking)
		{
			/* APIv2.0 booking response */
			 $bkngUSID = $itemBooking->USID;
			 $bkngActivityID = $itemBooking->ActivityID;
			 $bkngStatus = $itemBooking->BookingStatus;
			 $bkngConfirmNumber = $itemBooking->ConfirmationNumber;
			 $pckgeCurrency = $itemBooking->Currency;
			 $voucherUrl = $itemBooking->TourAttraction->VoucherURLS->VoucherURL;
			 $bkngTotPrice = $itemBooking->TotalPrice;
			 /* catch error to DB start here */
				$ErrorCode = $itemBooking->Errors->ErrorCode;
				$ErrorMessage = $itemBooking->Errors->ErrorMessage;
				if(isset($ErrorCode)){
					$errMethod = 'BookActivity';
					$errPckgRefNo = $this->errorlog_model->get_package_refno($bkngActivityID);
					$errPckgID = $bkngActivityID;
					$usrAgent = $this->agent->browser().' at '.$this->input->ip_address();
					$errValue = 'Error from API Server, ErrCode='.$ErrorCode.', ErrMsg='.$ErrorMessage;
					$this->errorlog_model->save_error_toDB($errMethod, $errPckgRefNo, $errPckgID, $errValue, $usrAgent);
				}
			 /* catch error to DB end here */
			/*				
			$bkngUSID = $itemBooking->USID;
			$bkngActivityID = $itemBooking->ActivityID;
			$bkngConfirmNumber = $itemBooking->ConfirmationNumber;
			$bkngStatus = $itemBooking->BookingStatus;
			$bkngTotPrice = $itemBooking->TotalPrice;
			$USSVisId = $itemBooking->USS->VisualID;
			$DisneyVisId = $itemBooking->Disney->VisualID;
			$SunwayLagoonVisId = $itemBooking->SunwayLagoon->VisualID;
			$TourAttractionVisId = $itemBooking->TourAttraction->VisualID;
			
			if(!empty($USSVisId)){
				$bkngVisualID = $itemBooking->USS->VisualID;
				$bkngTicketType = $itemBooking->USS->TicketType;
				$bkngTravelDate = $itemBooking->USS->TravelDate;
			}
			if(!empty($DisneyVisId)){
				$bkngVisualID = $itemBooking->Disney->VisualID;
				$bkngVisualIDExpiryDate = $itemBooking->Disney->VisualIDExpiryDate;
				$bkngTicketType = $itemBooking->Disney->TicketType;
				$bkngTravelDate = $itemBooking->Disney->TravelDate;
			}
			if(!empty($SunwayLagoonVisId)){
				$bkngVisualID = $itemBooking->SunwayLagoon->VisualID;
				$bkngVisualIDExpiryDate = $itemBooking->SunwayLagoon->VisualIDExpiryDate;
				$bkngTicketType = $itemBooking->SunwayLagoon->TicketType;


				$bkngTravelDate = $itemBooking->SunwayLagoon->TravelDate;
			}
			if(!empty($TourAttractionVisId)){
				$bkngVisualID = $itemBooking->TourAttraction->VisualID;
				$bkngVisualIDExpiryDate = $itemBooking->TourAttraction->VisualIDExpiryDate;
				$bkngTravelDate = $itemBooking->TourAttraction->TravelDate;
			}
			
				if(!empty($bkngVisualID) && !empty($bkngVisualIDExpiryDate)){
					$visID = $bkngVisualID;
					$visIDExpiry = $bkngVisualIDExpiryDate;
				}
				else{
					$visID = '';
					$visIDExpiry = '';
				}
			*/	
			/* save data booking and traveler to database start here */	                                                                                                                                                              
			$travContactInfoNew = array(
										  'transaction_code' => $transCode,
										  'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngActivityID ,
										  'isLeader' => '0',
										  'isContact' => '1',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTC,
										  'first_name' => $firstNameTC,
										  'last_name' => $lastNameTC,
										  'email' => $emailTC,
										  //'alternate_email' => $alternateEmailTC,
										  'contact_number' => $phoneNumberTC,
										  //'mobile_number' => $mobileNumberTC,
										  //'fax_number' =>  $faxNumberTC,
										  //'address' => $addressTC,
										  //'postal_code' => $postalCodeTC,
										  //'country_code' => $countryTC,
										  //'city_code' => $cityTC,
										  //'nationality_id' => $TC_ntnltyId,
										  //'nationality_code' => $TC_ntnltyCode
										   
										);	
			$this->db->insert('traveler_info', $travContactInfoNew); 
			$travLeaderInfoNew = array(
										  'transaction_code' => $transCode,
										  'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngActivityID ,
										  'isLeader' => '1',
										  'isContact' => '0',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTL,
										  'first_name' => $firstNameTL,
										  'last_name' => $lastNameTL,
										  'traveler_type' => '32',
										  //'age' => $ageTL,
										  //'passport_number' => $passportNumberTL,
										  //'dob' => $dayOfBirthTL,
										  //'passport_expired_date' => $passportExpiredDateTL,
										  //'passport_issuance_country' =>  $passportIssuanceCountryTL,
										  //'nationality_code' => $TL_ntnltyCode,
										  'nationality_id' => $TL_ntnltyId,
										);	
			  $this->db->insert('traveler_info', $travLeaderInfoNew); 
			  
			  for($i=1;$i <= $adultLoopEnd;$i++){
			  $j= $i - 1;
			  	//$adltNtnlty = explode('-',$adultNationality[$j]);
				//$adltNtnltyId = $adltNtnlty[0];
				//$adltNtnltyCode = $adltNtnlty[1];
						$adultInfoNew = array(
											  'transaction_code' => $transCode,
											  'usid' => "$bkngUSID",
											  'API_packages_id' => $bkngActivityID ,
											  'isLeader' => '0',
											  'isContact' => '0',
											  'isAdult' => '1',
											  'isChild' => '0',
											  'title' => $salutationTL,//$adultSalutation[$j],
											  'first_name' => $firstNameTL,//$adultFirstName[$j],
											  'last_name' => $lastNameTL,//$adultLastName[$j],
											  'traveler_type' => '32', //$adultTravelerType[$j],
											  //'age' => $ageTL,//$adultAge[$j],
											  //'passport_number' => $adultPassportNumber[$j],
											  //'dob' => $dayOfBirthTL,//$adultDOB[$j],
											  //'passport_expired_date' => $passportExpiredDateTL,//$adultPassportExpiredDate[$j],
											  //'passport_issuance_country' =>  $adultPassportIssuanceCountry[$j],
											  //'nationality_code' => $adltNtnltyCode,
											  'nationality_id' => $TL_ntnltyId,//$adltNtnltyId,
											);	
						
						$this->db->insert('traveler_info', $adultInfoNew); 
			  }	
			 	if(!empty($child)){
					for($i=1;$i <= $child;$i++){
					$j = $i-1;
					//$chldNtnlty = explode('-',$childNationality[$j]);
					//$chldNtnltyId = $chldNtnlty[0];
					//$chldNtnltyCode = $chldNtnlty[1];
							$childInfoNew = array(
												  'transaction_code' => $transCode,
												  'usid' => "$bkngUSID",
												  'API_packages_id' => $bkngActivityID ,
												  'isLeader' => '0',
												  'isContact' => '0',
												  'isAdult' => '0',
												  'isChild' => '1',
												  'title' => $childSalutation[$j],
												  'first_name' => $childFirstName[$j],
												  'last_name' => $childLastName[$j],
												  'traveler_type' => $childTravelerType[$j],
												  'age' => $childAge[$j],
												  //'passport_number' => $childPassportNumber[$j],
												  'dob' => $childDOB[$j],
												  'passport_expired_date' => $childPassportExpiredDate[$j],
												  //'passport_issuance_country' =>  $childPassportIssuanceCountry[$j],
												  //'nationality_code' => $chldNtnltyCode,
												  //'nationality_id' => $chldNtnltyId,
												);	
							
							$this->db->insert('traveler_info', $childInfoNew); 
					}	
			 	}
				
				if($isRadeem == '1'){
					$qrySlctUsrPnt = $this->db->get_where('users', array('users_id' => $usrID));
					foreach($qrySlctUsrPnt->result() as $rowUsr){
						$usrTotPnt = $rowUsr->total_point;
						$userRoleID = $rowUsr->role_id;
					}
					if($userRoleID == '2'){
						$MinimalBeli = $this->finance->get_point(13);	
						$NominalBeli = $this->finance->get_point(14);
						$PointBeli = $this->finance->get_point(15);
						$MinimalPoint = $this->finance->get_point(16);
						$PointTukar = $this->finance->get_point(17);
						$NominalBayar = $this->finance->get_point(18);
					}
					elseif($userRoleID == '3'){
						$MinimalBeli = $this->finance->get_point(19);
						$NominalBeli = $this->finance->get_point(20);
						$PointBeli = $this->finance->get_point(21);
						$MinimalPoint = $this->finance->get_point(22);
						$PointTukar = $this->finance->get_point(23);
						$NominalBayar = $this->finance->get_point(24);
					}
					$this->db->select('*');
					$this->db->from('currencies');
					$this->db->where('currency_from', 'SGD');
					$this->db->where('country_iso_from', 'SG');
					$this->db->where('currency_to', 'IDR');
					$this->db->where('country_iso_to', 'ID');
					$rateValCurr = $this->db->get();
					foreach($rateValCurr->result() as $rowRateFld){
						$valIdrRate = $rowRateFld->konversi;
						
					}
					
					$nilNomPerPoint_inSGD = $NominalBayar / $valIdrRate;
					$pntNomValue_inSGD = $usrTotPnt * $nilNomPerPoint_inSGD; 
					$gainedPntToNomValue_inSGD = round($gainedPoint * $nilNomPerPoint_inSGD, 2);
					$usrFnlPnt = round($totGainedPoint - $gainedPoint, 2);	
					$totAmountFnal = round($totSaleAmount - $gainedPntToNomValue_inSGD, 2); 
						
					$dataUpdt = array(
						   'book_step' => '2',
						   'payment_method' => $paymentMethod,
						   'arrive_flight_number' => $arrivalFlightNumber,
						   'departure_flight_number' => $departFlightNumber,
						   'arrive_flight_date' => $arrivalDate,
						   'departure_flight_date' => $departDate,
						   'pickup_dropoff' => $pickupDropoff,
						   'validated' => "1",
						   'api_booking_status' => $itemBooking->BookingStatus,
						   'api_confirmation_number' => "$itemBooking->ConfirmationNumber",
						   //'visual_id' => "$visID",
						   //'visual_id_expiry' => "$visIDExpiry",
						   'voucher_url' => htmlspecialchars_decode($voucherUrl),
						   'point_transaction' => $gainedPoint,
						   'isRadeemPoint' => '1',
						   'pointRadeem' => $gainedPoint,
						   'pointRadeem_value' => $gainedPntToNomValue_inSGD,
						   
						);
						
						$this->db->where('usid', $usid);
						$this->db->update('book_packages', $dataUpdt); 
						$fnlUsrPnt = $totGainedPoint - $gainedPoint;
						$dtUpdtUsr = array('total_point' => $fnlUsrPnt);
						$this->db->where('users_id', $usrID);
						$this->db->update('users', $dtUpdtUsr); 
						$this->sending_email_confirm_payByCC($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL, $voucherUrl);
						$data['pagecontent'] = "user/booking_success";
						$this->load->vars($data);
						$this->load->view('template');
					
				}
				else{
						$dataUpdt = array(
								   'book_step' => '2',
								   'payment_method' => $paymentMethod,
								   'arrive_flight_number' => $arrivalFlightNumber,
								   'departure_flight_number' => $departFlightNumber,
								   'arrive_flight_date' => $arrivalDate,
								   'departure_flight_date' => $departDate,
								   'pickup_dropoff' => $pickupDropoff,
								   'validated' => "1",
								   'api_booking_status' => $itemBooking->BookingStatus,
								   'api_confirmation_number' => "$itemBooking->ConfirmationNumber",
								   'voucher_url' => htmlspecialchars_decode($voucherUrl),
								   'payWithDeposit' => '1',
								   //'visual_id' => "$visID",
								   //'visual_id_expiry' => "$visIDExpiry"
							);
						$this->db->where('usid', $usid);
						$this->db->update('book_packages', $dataUpdt); 
						
						$updtBlncDpst = $this->update_deposit_nominal($depositCode, $updtdBlncDpst);
						
						$dtUpdtUsr = array('total_point' => $totGainedPoint);
						$this->db->where('users_id', $usrID);
						$this->db->update('users', $dtUpdtUsr); 
						$this->sending_email_confirm_payByCC($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL, $voucherUrl);
						$data['pagecontent'] = "user/booking_success";
						$this->load->vars($data);
						$this->load->view('template');
				}
	          
		
		}
		
/* =================================if deposit balance is enough end here ========================================== */		
	}
}
/* ======================================booking payment with deposit balance for reseller end here====================== */ 
 
 
 /* =====================================booking payment with bank transfer for member & reseller start here==================================== */
				else
				{
					$this->db->select('*');
					$this->db->from('book_packages');
					$this->db->where('usid', $usid);
					$qrySlctBkng = $this->db->get();
					foreach($qrySlctBkng->result() as $rowsBkng){
						$bkngPckgId = $rowsBkng->API_packages_id;
						$transCode = $rowsBkng->transaction_code;
						$adult = $rowsBkng->adult;
						$child = $rowsBkng->child;
						$currencyBkng = $rowsBkng->currency_code;
						$childBkngAges = $rowsBkng->child_ages;
						$travelDate = $rowsBkng->travel_date;
						$totAmount = $rowsBkng->total_amount;
						$transCode = $rowsBkng->transaction_code;
						$bkngUSID = $rowsBkng->usid;
						$totSaleAmount = $rowsBkng->total_sale_price_amount;
						$usrID = $rowsBkng->user_id;
					}
					$slctUsr = $this->db->get_where('users', array('users_id' => $usrID));
					foreach($slctUsr->result() as $rowUsr){
						$usrExstngPnt = $rowUsr->total_point;
					}
					$gainedPoint = $this->gained_point($totSaleAmount);
					$totGainedPoint = $usrExstngPnt + $gainedPoint;
					
					$TL_ntnlty = explode('-',$nationalityTL);
					$TL_ntnltyId = $TL_ntnlty[0];
					$TL_ntnltyCode = $TL_ntnlty[1];
					
					//$TC_ntnlty = explode('-',$nationalityCodeTC);
					//$TC_ntnltyId = $TC_ntnlty[0];
					//$TC_ntnltyCode = $TC_ntnlty[1];
					
					$adultLoopEnd = $adult - 1;
					$childLoopEnd = $child - 1; 
					
					$travContactInfoNew = array(
										  'transaction_code' => $transCode,
										  'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngPckgId,
										  'isLeader' => '0',
										  'isContact' => '1',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTC,
										  'first_name' => $firstNameTC,
										  'last_name' => $lastNameTC,
										  'email' => $emailTC,
										  //'alternate_email' => $alternateEmailTC,
										  'contact_number' => $phoneNumberTC,
										  //'mobile_number' => $mobileNumberTC,
										  //'fax_number' =>  $faxNumberTC,
										  //'address' => $addressTC,
										  //'postal_code' => $postalCodeTC,
										  //'country_code' => $countryTC,
										  //'city_code' => $cityTC,
										  'nationality_id' => $TL_ntnltyId,//$TC_ntnltyId,
										  //'nationality_code' => $TC_ntnltyCode
										   
										);	
					$this->db->insert('traveler_info', $travContactInfoNew); 
					$travLeaderInfoNew = array(
										  'transaction_code' => $transCode,
										  'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngPckgId ,
										  'isLeader' => '1',
										  'isContact' => '0',
										  'isAdult' => '1',
										  'isChild' => '0',
										  'title' => $salutationTL,
										  'first_name' => $firstNameTL,
										  'last_name' => $lastNameTL,
										  'traveler_type' => '32',
										  //'age' => $ageTL,
										  //'passport_number' => $passportNumberTL,
										 // 'dob' => $dayOfBirthTL,
										  //'passport_expired_date' => $passportExpiredDateTL,
										  //'passport_issuance_country' =>  $passportIssuanceCountryTL,
										  //'nationality_code' => $TL_ntnltyCode,
										  'nationality_id' => $TL_ntnltyId,
												);	
					  $this->db->insert('traveler_info', $travLeaderInfoNew); 
					  
					  for($i=1;$i <= $adultLoopEnd;$i++){
					  $j= $i - 1;
						//$adltNtnlty = explode('-',$adultNationality[$j]);
						//$adltNtnltyId = $adltNtnlty[0];
						//$adltNtnltyCode = $adltNtnlty[1];
								$adultInfoNew = array(
											  'transaction_code' => $transCode,
											  'usid' => "$bkngUSID",
											  'API_packages_id' => $bkngPckgId ,
											  'isLeader' => '0',
											  'isContact' => '0',
											  'isAdult' => '1',
											  'isChild' => '0',
											  'title' => $salutationTL,//$adultSalutation[$j],
											  'first_name' => $firstNameTL,//$adultFirstName[$j],
											  'last_name' => $lastNameTL,//$adultLastName[$j],
											  'traveler_type' => '32',//$adultTravelerType[$j],
											  //'age' => $ageTL,//$adultAge[$j],
											  //'passport_number' => $adultPassportNumber[$j],
											  //'dob' => $dayOfBirthTL,//$adultDOB[$j],
											  //'passport_expired_date' => $passportExpiredDateTL,//$adultPassportExpiredDate[$j],
											  //'passport_issuance_country' =>  $adultPassportIssuanceCountry[$j],
											  //'nationality_code' => $adltNtnltyCode,
											  'nationality_id' => $TL_ntnltyId,//$adltNtnltyId,
											);	
						
								$this->db->insert('traveler_info', $adultInfoNew); 
					  }	
					  if(!empty($child)){
						 	for($i=1;$i <= $child;$i++){
						 	$j = $i-1;
							//$chldNtnlty = explode('-',$childNationality[$j]);
							//$chldNtnltyId = $chldNtnlty[0];
							//$chldNtnltyCode = $chldNtnlty[1];
									$childInfoNew = array(
												  'transaction_code' => $transCode,
												  'usid' => "$bkngUSID",
												  'API_packages_id' => $bkngPckgId ,
												  'isLeader' => '0',
												  'isContact' => '0',
												  'isAdult' => '0',
												  'isChild' => '1',
												  'title' => $childSalutation[$j],
												  'first_name' => $childFirstName[$j],
												  'last_name' => $childLastName[$j],
												  'traveler_type' => $childTravelerType[$j],
												  'age' => $childAge[$j],
												  //'passport_number' => $childPassportNumber[$j],
												  'dob' => $childDOB[$j],
												  //'passport_expired_date' => $childPassportExpiredDate[$j],
												  //'passport_issuance_country' =>  $childPassportIssuanceCountry[$j],
												  //'nationality_code' => $chldNtnltyCode,
												  'nationality_id' => $TL_ntnltyId,//$chldNtnltyId,
												);	
							
							$this->db->insert('traveler_info', $childInfoNew); 
							}	
			 			}
						
						if($isRadeem == 1){
							$qrySlctUsrPnt = $this->db->get_where('users', array('users_id' => $usrID));
							foreach($qrySlctUsrPnt->result() as $rowUsr){
								$usrTotPnt = $rowUsr->total_point;
								$userRoleID = $rowUsr->role_id;
							}
							if($userRoleID == '2'){
								$MinimalBeli = $this->finance->get_point(13);	
								$NominalBeli = $this->finance->get_point(14);
								$PointBeli = $this->finance->get_point(15);
								$MinimalPoint = $this->finance->get_point(16);
								$PointTukar = $this->finance->get_point(17);
								$NominalBayar = $this->finance->get_point(18);
							}
							elseif($userRoleID == '3'){
								$MinimalBeli = $this->finance->get_point(19);
								$NominalBeli = $this->finance->get_point(20);
								$PointBeli = $this->finance->get_point(21);
								$MinimalPoint = $this->finance->get_point(22);
								$PointTukar = $this->finance->get_point(23);
								$NominalBayar = $this->finance->get_point(24);
							}
							$this->db->select('*');
							$this->db->from('currencies');
							$this->db->where('currency_from', 'SGD');
							$this->db->where('country_iso_from', 'SG');
							$this->db->where('currency_to', 'IDR');
							$this->db->where('country_iso_to', 'ID');
							$rateValCurr = $this->db->get();
							foreach($rateValCurr->result() as $rowRateFld){
								$valIdrRate = $rowRateFld->konversi;
								
							}
							$nilNomPerPoint_inSGD = $NominalBayar / $valIdrRate;
							$pntNomValue_inSGD = round($usrTotPnt * $nilNomPerPoint_inSGD, 2); 
							$nilTotNom_toPoint = round($totSaleAmount / $nilNomPerPoint_inSGD, 2);
												
							$radeemedPoint = round($usrTotPnt - $nilTotNom_toPoint, 2);
							$usrLastPnt = round($usrTotPnt - $radeemedPoint, 2);
							$dataUpdt = array(
								  'book_step' => '2',
								   'payment_method' => $paymentMethod,
								   'arrive_flight_number' => $arrivalFlightNumber,
								   'departure_flight_number' => $departFlightNumber,
								   'arrive_flight_date' => $arrivalDate,
								   'departure_flight_date' => $departDate,
								   'pickup_dropoff' => $pickupDropoff,
								   'validated' => "0",
								   'booking_expiry' => $bkngVldUntl,
								   'pending_point' => $gainedPoint,
								   'isRadeemPoint' => '1',
								   'pointRadeem' => $radeemedPoint,
								   'pointRadeem_value' => $gainedPntToNomValue_inSGD,
								   'point_transaction' => $gainedPoint
								  
								);
								$this->db->where('usid', $usid);
								$this->db->update('book_packages', $dataUpdt); 
								
								$fnlUsrPnt = $totGainedPoint - $gainedPoint;
								$dtUpdtUsr = array('total_point' => $fnlUsrPnt);
								$this->db->where('users_id', $usrID);
								$this->db->update('users', $dtUpdtUsr); 
								
								$this->sending_email_confirm_payByCC($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL,$voucherUrl);
								$data['pagecontent'] = "user/booking_success";
								$this->load->vars($data);
								$this->load->view('template');
						
						}
						else{
							date_default_timezone_set('Asia/Jakarta');
							$bkngVldUntl = date('Y-m-d H:i:s', strtotime('+6 hours'));
						  	$dataUpdt = array(
								   'book_step' => '2',
								   'payment_method' => $paymentMethod,
								   'arrive_flight_number' => $arrivalFlightNumber,
								   'departure_flight_number' => $departFlightNumber,
								   'arrive_flight_date' => $arrivalDate,
								   'departure_flight_date' => $departDate,
								   'pickup_dropoff' => $pickupDropoff,
								   'validated' => "0",
								   'booking_expiry' => $bkngVldUntl,
								   'pending_point' => $gainedPoint
								  
							);
							$this->db->where('usid', $usid);
							$this->db->update('book_packages', $dataUpdt); 
							$this->sending_email_confirm_payByBT($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL);
							$data['pagecontent'] = "user/booking_success";
				 			$this->load->vars($data);
				 			$this->load->view('template');
						}
						
						
				}
/* =====================================booking payment with bank transfer for member & reseller end here==================================== */
			}
/* ==========================================member & reseller booking end here========================================== */			

/* ==========================================guest booking start here======================================================= */	
			else{
				$usid = $this->input->post('usid');	
				$pid = $this->input->post('pid');	
				$paymentMethod = $this->input->post('paymethod');	
				$isRadeem = $this->input->post('radeemMyPoint');
/* ======================================booking payment with credit card for guest start here====================================== */		
				if($paymentMethod == 'MP0001'){
/* ===============================validate credit card to payment gateway provider start here============================= */	
				$resultCCvalid = $this->validate_creditCard();
/* ===============================validate credit card to payment gateway provider end here============================= */	
					if($resultCCvalid == TRUE){
/* =================================if credit card is valid start here=================================================== */
/* input activity search price start here */	
	
				$this->db->select('*');
				$this->db->from('book_packages');
				$this->db->where('usid', $usid);
				$qrySlctBkng = $this->db->get();
				foreach($qrySlctBkng->result() as $rowsBkng){
					$bkngPckgId = $rowsBkng->API_packages_id;
					$adult = $rowsBkng->adult;
					$child = $rowsBkng->child;
					$currencyBkng = $rowsBkng->currency_code;
					$childBkngAges = $rowsBkng->child_ages;
					$travelDate = $rowsBkng->travel_date;
					$totAmount = $rowsBkng->total_amount;
					$transCode = $rowsBkng->transaction_code;
				}
				$actvtyID = $bkngPckgId;
				$adultPax = $adult;
				$childPax = $child;
				$travelDate = $travelDate;
				$crrncy = $currencyBkng;
				$childPaxAge = unserialize($childBkngAges);
				$adultLoopEnd = $adult - 1;
				$childLoopEnd = $child - 1; 
		
		/* input activity search price end here */	
		if(!empty($pickupDropoff)){
			$qryPickDrop = $this->db->get_where('pickup_point', array('hotel_code' => $pickupDropoff));
			foreach($qryPickDrop->result() as $row){
				$pckUpPnt_name = $row->hotel_name;
				$pckUpPnt_id = $row->hotel_code;
			}
		}
		else{
			$pckUpPnt_name = 'none';
			$pckUpPnt_id = '-1';
		}
		
		
		$TL_ntnlty = explode('-',$nationalityTL);
		$TL_ntnltyId = $TL_ntnlty[0];
		$TL_ntnltyCode = $TL_ntnlty[1];
		
		//$TC_ntnlty = explode('-',$nationalityCodeTC);
		//$TC_ntnltyId = $TC_ntnlty[0];
		//$TC_ntnltyCode = $TC_ntnlty[1];
		
		for($i=1;$i <= $adultLoopEnd;$i++){
		$j= $i-1;
			//$Adlt_ntnlty = explode('-',$adultNationality[$j]);
			//$Adlt_ntnltyId = $Adlt_ntnlty[0];
			//$Adlt_ntnltyCode = $Adlt_ntnlty[1];
			$adultGuest[$j] = array('Title' => $salutationTL,//$adultSalutation[$j], 
							   'FirstName' => $firstNameTL,//$adultFirstName[$j], 
							   'LastName' => $lastNameTL,//$adultLastName[$j],
							   'PassengerType' => '32',
							   'Age' => $defaultAge,//'32',//$ageTL,//$adultAge[$j],
							   //'PassportNumber' => $adultPassportNumber[$j],
							   'DOB' => $defaultDate,//$adultDOB[$j],
							   'PassportExpiryDate' => $defaultDate,//$adultPassportExpiredDate[$j],
							   //'PassportIssuanceCountry' =>  $adultPassportIssuanceCountry[$j],
							   'NationalityID' => $TL_ntnltyId,//$Adlt_ntnltyId
							   );
							 
		}
		
		if(!empty($child)){
			for($i=1;$i <= $child;$i++){
			$j= $i-1;
				//$Chld_ntnlty = explode('-',$childNationality[$j]);
				//$Chld_ntnltyId = $Chld_ntnlty[0];
				//$Chld_ntnltyCode = $Chld_ntnlty[1];
				$childGuest[$j] = array('Title' => $childSalutation[$j], 
								   'FirstName' => $childFirstName[$j], 
								   'LastName' => $childLastName[$j],
								   'PassengerType' => '33',
								   'Age' => $childAge[$j],
								   //'PassportNumber' => $childPassportNumber[$j],
								   'DOB' => $childDOB[$j],
								   'PassportExpiryDate' => $defaultDate ,//$childPassportExpiredDate[$j],
								   //'PassportIssuanceCountry' =>  $childPassportIssuanceCountry[$j],
								   'NationalityID' =>  $TL_ntnltyId,//$Chld_ntnltyId
								   );
			}
		}
		if(!empty($child)){
			$arrTravelers = array_merge($adultGuest, $childGuest);
		}
		else{
			$arrTravelers = array_merge($adultGuest);
		}
		
		
		$dataBooking = array(
		    'RequestParam' => array(
		    'USID' => $usid,
		    'ActivityID' => $bkngPckgId,
		    'Adult' => $adult , 
			'SeniorCitizen' => '0',
		    'Child'=> $this->get_arrChildAge($childPaxAge),
		    'TourDetails' => $this->get_tours_details_forBooking($travelDate, $pid),
			               
			'Currency' => $currencyBkng,
			'TotalPrice' => $totAmount,
			'PickUpDropOffHotel'=> array(
			                          'PickupPointID' => $pckUpPnt_id,
										'PickupDropOffPoint' => $pckUpPnt_name,
							            ),
										
			'LeadTravelerInfo'=> array(	
			                           'Title' => $salutationTL,
										'FirstName' => $firstNameTL,
										'LastName' => $lastNameTL,
										'PassengerType' => '32',
										'Age' => $defaultAge ,//$ageTL,//$ageTL,
										//'PassportNumber' => $passportNumberTL,
										'DOB' => $defaultDate,//$dayOfBirthTL,
										'PassportExpiryDate' => $defaultDate,//$passportExpiredDateTL,
										//'PassportIssuanceCountry' => $passportIssuanceCountryTL,
										'NationalityID' => $TL_ntnltyId
							            ),
		    'GuestDetails' => $arrTravelers,
			                
		    'FlightInfo'=> array(
			                     'ArrivalFlightNumber' => $arrivalFlightNumber,
								  'DepartureFlightNumber' => $departFlightNumber,
								  'ArrivalDate' => $arrivalDate,
								  'DepartureDate' => $departDate
							  ),
			'ContactInfo'=> array(
			                      'Salutation' => $salutationTC,
								  'FirstName' => $firstNameTC,
								  'LastName' => $lastNameTC,
								  'Email' => $emailTC,
								  //'Email2' => $alternateEmailTC,
								  'ContactNumber' => $phoneNumberTC,
								  //'MobileNumber' => $mobileNumberTC,
								  //'FaxNumber' => $faxNumberTC,
								  //'Address' => $addressTC,
								 //'PostalCode' => $postalCodeTC,
								  //'City' => $cityTC,
								  //'CountryCode' => $countryTC,
								  'NationalityID' => $TL_ntnltyId,//$TC_ntnltyId,
								  //'NationalityCode' => $TC_ntnltyCode
							  ),
			'CreditCardInfo'=> $this->get_credit_card_info()
					  ),
		);
		/*====================================Insert to API
		$Response = $SOAP->BookActivity($dataBooking);
		$stringBooking = $SOAP->__getLastResponse();
		
		
		$xmlBooking = simplexml_load_string($stringBooking);
		$xmlBooking->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xmlBooking->registerXPathNamespace('ns', 'http://tempuri.org/');
		R-20150126 ========================================*/
		
		//echo '====================<b>Booking Activity Output</b>====================<br />';
		foreach ($xmlBooking->xpath('//ns:BookActivityResult') as $itemBooking)
		{
			/* APIv2.0 booking response */
			 $bkngUSID = $itemBooking->USID;
			 $bkngActivityID = $itemBooking->ActivityID;
			 $bkngStatus = $itemBooking->BookingStatus;
			 $bkngConfirmNumber = $itemBooking->ConfirmationNumber;
			 $pckgeCurrency = $itemBooking->Currency;
			 $voucherUrl = $itemBooking->TourAttraction->VoucherURLS->VoucherURL;
			 $bkngTotPrice = $itemBooking->TotalPrice;
			 
			 /* catch error to DB start here */
				$ErrorCode = $itemBooking->Errors->ErrorCode;
				$ErrorMessage = $itemBooking->Errors->ErrorMessage;
				if(isset($ErrorCode)){
					$errMethod = 'BookActivity';
					$errPckgRefNo = $this->errorlog_model->get_package_refno($bkngActivityID);
					$errPckgID = $bkngActivityID;
					$usrAgent = $this->agent->browser().' at '.$this->input->ip_address();
					$errValue = 'Error from API Server, ErrCode='.$ErrorCode.', ErrMsg='.$ErrorMessage;
					$this->errorlog_model->save_error_toDB($errMethod, $errPckgRefNo, $errPckgID, $errValue, $usrAgent);
				}
			 /* catch error to DB end here */
			 
			/*				
			$bkngUSID = $itemBooking->USID;
			$bkngActivityID = $itemBooking->ActivityID;
			$bkngConfirmNumber = $itemBooking->ConfirmationNumber;
			$bkngStatus = $itemBooking->BookingStatus;
			$bkngTotPrice = $itemBooking->TotalPrice;
			$USSVisId = $itemBooking->USS->VisualID;
			$DisneyVisId = $itemBooking->Disney->VisualID;
			$SunwayLagoonVisId = $itemBooking->SunwayLagoon->VisualID;
			$TourAttractionVisId = $itemBooking->TourAttraction->VisualID;
			
			if(!empty($USSVisId)){
				$bkngVisualID = $itemBooking->USS->VisualID;
				$bkngTicketType = $itemBooking->USS->TicketType;
				$bkngTravelDate = $itemBooking->USS->TravelDate;
			}
			if(!empty($DisneyVisId)){
				$bkngVisualID = $itemBooking->Disney->VisualID;
				$bkngVisualIDExpiryDate = $itemBooking->Disney->VisualIDExpiryDate;
				$bkngTicketType = $itemBooking->Disney->TicketType;
				$bkngTravelDate = $itemBooking->Disney->TravelDate;
			}
			if(!empty($SunwayLagoonVisId)){
				$bkngVisualID = $itemBooking->SunwayLagoon->VisualID;
				$bkngVisualIDExpiryDate = $itemBooking->SunwayLagoon->VisualIDExpiryDate;
				$bkngTicketType = $itemBooking->SunwayLagoon->TicketType;


				$bkngTravelDate = $itemBooking->SunwayLagoon->TravelDate;
			}
			if(!empty($TourAttractionVisId)){
				$bkngVisualID = $itemBooking->TourAttraction->VisualID;
				$bkngVisualIDExpiryDate = $itemBooking->TourAttraction->VisualIDExpiryDate;
				$bkngTravelDate = $itemBooking->TourAttraction->TravelDate;
			}
			
				if(!empty($bkngVisualID) && !empty($bkngVisualIDExpiryDate)){
					$visID = $bkngVisualID;
					$visIDExpiry = $bkngVisualIDExpiryDate;
				}
				else{
					$visID = '';
					$visIDExpiry = '';
				}
			/*	
			/* save data booking and traveler to database start here */	                                                                                                                                                              
			$travContactInfoNew = array(
										  'transaction_code' => $transCode,
										  'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngActivityID ,
										  'isLeader' => '0',
										  'isContact' => '1',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTC,
										  'first_name' => $firstNameTC,
										  'last_name' => $lastNameTC,
										  'email' => $emailTC,
										  //'alternate_email' => $alternateEmailTC,
										  'contact_number' => $phoneNumberTC,
										  //'mobile_number' => $mobileNumberTC,
										  //'fax_number' =>  $faxNumberTC,
										  //'address' => $addressTC,
										  //'postal_code' => $postalCodeTC,
										  //'country_code' => $countryTC,
										  //'city_code' => $cityTC,
										  //'nationality_id' => $TC_ntnltyId,
										  //'nationality_code' => $TC_ntnltyCode
										   
										);	
			$this->db->insert('traveler_info', $travContactInfoNew); 
			$travLeaderInfoNew = array(
										  'transaction_code' => $transCode,
										  'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngActivityID ,
										  'isLeader' => '1',
										  'isContact' => '0',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTL,
										  'first_name' => $firstNameTL,
										  'last_name' => $lastNameTL,
										  'traveler_type' => '32',
										  //'age' => $ageTL,
										  //'passport_number' => $passportNumberTL,
										  //'dob' => $dayOfBirthTL,
										  //'passport_expired_date' => $passportExpiredDateTL,
										  //'passport_issuance_country' =>  $passportIssuanceCountryTL,
										  //'nationality_code' => $TL_ntnltyCode,
										  'nationality_id' => $TL_ntnltyId,
										);	
			  $this->db->insert('traveler_info', $travLeaderInfoNew); 
			  
			  for($i=1;$i <= $adultLoopEnd;$i++){
			  $j= $i - 1;
			  	//$adltNtnlty = explode('-',$adultNationality[$j]);
				//$adltNtnltyId = $adltNtnlty[0];
				//$adltNtnltyCode = $adltNtnlty[1];
						$adultInfoNew = array(
											  'transaction_code' => $transCode,
											  'usid' => "$bkngUSID",
											  'API_packages_id' => $bkngActivityID ,
											  'isLeader' => '0',
											  'isContact' => '0',
											  'isAdult' => '1',
											  'isChild' => '0',
											  'title' => $salutationTL,//$adultSalutation[$j],
											  'first_name' => $firstNameTL,//$adultFirstName[$j],
											  'last_name' => $lastNameTL,//$adultLastName[$j],
											  'traveler_type' => '32',//$adultTravelerType[$j],
											  //'age' => $ageTL,//$adultAge[$j],
											  //'passport_number' => $adultPassportNumber[$j],
											  //'dob' => $dayOfBirthTL,//$adultDOB[$j],
											  //'passport_expired_date' => $passportExpiredDateTL,//$adultPassportExpiredDate[$j],
											  //'passport_issuance_country' =>  $adultPassportIssuanceCountry[$j],
											  //'nationality_code' => $adltNtnltyCode,
											  //'nationality_id' => $adltNtnltyId,
											);	
						
						$this->db->insert('traveler_info', $adultInfoNew); 
			  }	
			 	if(!empty($child)){
					for($i=1;$i <= $child;$i++){
					$j = $i-1;
					//$chldNtnlty = explode('-',$childNationality[$j]);
					//$chldNtnltyId = $chldNtnlty[0];
					//$chldNtnltyCode = $chldNtnlty[1];
							$childInfoNew = array(
												  'transaction_code' => $transCode,
												  'usid' => "$bkngUSID",
												  'API_packages_id' => $bkngActivityID ,
												  'isLeader' => '0',
												  'isContact' => '0',
												  'isAdult' => '0',
												  'isChild' => '1',
												  'title' => $childSalutation[$j],
												  'first_name' => $childFirstName[$j],
												  'last_name' => $childLastName[$j],
												  'traveler_type' => $childTravelerType[$j],
												  'age' => $childAge[$j],
												  //'passport_number' => $childPassportNumber[$j],
												  'dob' => $childDOB[$j],
												  //'passport_expired_date' => $childPassportExpiredDate[$j],
												  //'passport_issuance_country' =>  $childPassportIssuanceCountry[$j],
												  //'nationality_code' => $chldNtnltyCode,
												  //'nationality_id' => $chldNtnltyId,
												);	
							
							$this->db->insert('traveler_info', $childInfoNew); 
					}	
			 	}
	          $dataUpdt = array(
               'book_step' => '2',
               'payment_method' => $paymentMethod,
               'arrive_flight_number' => $arrivalFlightNumber,
               'departure_flight_number' => $departFlightNumber,
               'arrive_flight_date' => $arrivalDate,
               'departure_flight_date' => $departDate,
               'pickup_dropoff' => $pickupDropoff,
               'validated' => "1",
               'api_booking_status' => $itemBooking->BookingStatus,
               'api_confirmation_number' => "$itemBooking->ConfirmationNumber",
               'voucher_url' => htmlspecialchars_decode($voucherUrl)
               //'visual_id' => "$visID",
               //'visual_id_expiry' => "$visIDExpiry"
            );
			$this->db->where('usid', $usid);
			$this->db->update('book_packages', $dataUpdt); 
			/* save data booking and traveler to database end here */	
			$this->sending_email_confirm_payByCC($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL,$voucherUrl);
			/*
		     echo "<b>USID : </b>".$itemBooking->USID.'<br />';
			 echo "<b>ActivityID : </b>".$itemBooking->ActivityID.'<br />';
			 echo "<b>BookingStatus : </b>".$itemBooking->BookingStatus.'<br />';
			 echo "<b>ConfirmationNumber : </b>".$itemBooking->ConfirmationNumber.'<br />';
			 echo "<b>Currency : </b>".$itemBooking->Currency.'<br />';
			 echo "<b>TotalPrice : </b>".$itemBooking->TotalPrice.'<br />';
			 echo "<b>Visual ID : </b>".$visID.'<br />';
			echo "<b>Visual ID Expiry : </b>".$visIDExpiry.'<br />';
			*/
			$this->session->unset_userdata('bookingUSID');
			 $data['pagecontent'] = "user/booking_success";
			 $this->load->vars($data);
			 $this->load->view('template');
		
		}
/* =================================if credit card is valid end here =================================================== */						
					}
					else{
/* ============================if credit card not valid start here========================================= */	
						$this->session->set_flashdata('flashMsge', 'Your credit card is not valid !');
						redirect('transaction/booking_form', 'refresh');					
/* ============================if credit card not valid end here=========================================== */
					}				
				}	
/* ======================================booking payment with credit card for guest end here======================================== */	
/* =====================================booking payment with bank transfer for guest start here==================================== */
				else
				{
					$this->db->select('*');
					$this->db->from('book_packages');
					$this->db->where('usid', $usid);
					$qrySlctBkng = $this->db->get();
					foreach($qrySlctBkng->result() as $rowsBkng){
						$bkngPckgId = $rowsBkng->API_packages_id;
						$transCode = $rowsBkng->transaction_code;
						$adult = $rowsBkng->adult;
						$child = $rowsBkng->child;
						$currencyBkng = $rowsBkng->currency_code;
						$childBkngAges = $rowsBkng->child_ages;
						$travelDate = $rowsBkng->travel_date;
						$totAmount = $rowsBkng->total_amount;
						$transCode = $rowsBkng->transaction_code;
						$bkngUSID = $rowsBkng->usid;
					}
					$TL_ntnlty = explode('-',$nationalityTL);
					$TL_ntnltyId = $TL_ntnlty[0];
					$TL_ntnltyCode = $TL_ntnlty[1];
					
					//$TC_ntnlty = explode('-',$nationalityCodeTC);
					//$TC_ntnltyId = $TC_ntnlty[0];
					//$TC_ntnltyCode = $TC_ntnlty[1];
					
					$adultLoopEnd = $adult - 1;
					$childLoopEnd = $child - 1; 
					
					$travContactInfoNew = array(
										  'transaction_code' => $transCode,
										  'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngPckgId,
										  'isLeader' => '0',
										  'isContact' => '1',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTC,
										  'first_name' => $firstNameTC,
										  'last_name' => $lastNameTC,
										  'email' => $emailTC,
										  //'alternate_email' => $alternateEmailTC,
										  'contact_number' => $phoneNumberTC,
										  //'mobile_number' => $mobileNumberTC,
										  //'fax_number' =>  $faxNumberTC,
										  //'address' => $addressTC,
										  //'postal_code' => $postalCodeTC,
										 // 'country_code' => $countryTC,
										 // 'city_code' => $cityTC,
										  'nationality_id' => $TL_ntnltyId,//$TC_ntnltyId,
										  //'nationality_code' => $TC_ntnltyCode
										   
										);	
					$this->db->insert('traveler_info', $travContactInfoNew); 
					$travLeaderInfoNew = array(
										  'transaction_code' => $transCode,
										  'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngPckgId ,
										  'isLeader' => '1',
										  'isContact' => '0',
										  'isAdult' => '1',
										  'isChild' => '0',
										  'title' => $salutationTL,
										  'first_name' => $firstNameTL,
										  'last_name' => $lastNameTL,
										  'traveler_type' => '32',
										  //'age' => $ageTL,
										  //'passport_number' => $passportNumberTL,
										  //'dob' => $dayOfBirthTL,
										  //'passport_expired_date' => $passportExpiredDateTL,
										  //'passport_issuance_country' =>  $passportIssuanceCountryTL,
										  //'nationality_code' => $TL_ntnltyCode,
										  'nationality_id' => $TL_ntnltyId,
												);	
					  $this->db->insert('traveler_info', $travLeaderInfoNew); 
					  
					  for($i=1;$i <= $adultLoopEnd;$i++){
					  $j= $i - 1;
						//$adltNtnlty = explode('-',$adultNationality[$j]);
						//$adltNtnltyId = $adltNtnlty[0];
						//$adltNtnltyCode = $adltNtnlty[1];
								$adultInfoNew = array(
											  'transaction_code' => $transCode,
											  'usid' => "$bkngUSID",
											  'API_packages_id' => $bkngPckgId ,
											  'isLeader' => '0',
											  'isContact' => '0',
											  'isAdult' => '1',
											  'isChild' => '0',
											  'title' => $salutationTL,//$adultSalutation[$j],
											  'first_name' => $firstNameTL,//$adultFirstName[$j],
											  'last_name' => $lastNameTL,//$adultLastName[$j],
											  'traveler_type' => '32',//$adultTravelerType[$j],
											  //'age' => $ageTL,//$adultAge[$j],
											  //'passport_number' => $adultPassportNumber[$j],
											  //'dob' => $defaultDate,//$adultDOB[$j],
											  //'passport_expired_date' => $defaultDate,//$adultPassportExpiredDate[$j],
											  //'passport_issuance_country' =>  $adultPassportIssuanceCountry[$j],
											  //'nationality_code' => $adltNtnltyCode,
											  'nationality_id' => $TL_ntnltyId//$adltNtnltyId,
											);	
						
								$this->db->insert('traveler_info', $adultInfoNew); 
					  }	
					  if(!empty($child)){
						 	for($i=1;$i <= $child;$i++){
						 	$j = $i-1;
							//$chldNtnlty = explode('-',$childNationality[$j]);
							//$chldNtnltyId = $chldNtnlty[0];
							//$chldNtnltyCode = $chldNtnlty[1];
									$childInfoNew = array(
												  'transaction_code' => $transCode,
												  'usid' => "$bkngUSID",
												  'API_packages_id' => $bkngPckgId ,
												  'isLeader' => '0',
												  'isContact' => '0',
												  'isAdult' => '0',
												  'isChild' => '1',
												  'title' => $childSalutation[$j],
												  'first_name' => $childFirstName[$j],
												  'last_name' => $childLastName[$j],
												  'traveler_type' => $childTravelerType[$j],
												  'age' => $childAge[$j],
												  //'passport_number' => $childPassportNumber[$j],
												  'dob' => $childDOB[$j],
												  //'passport_expired_date' => $childPassportExpiredDate[$j],
												  //'passport_issuance_country' =>  $childPassportIssuanceCountry[$j],
												  //'nationality_code' => $chldNtnltyCode,
												  'nationality_id' => $TL_ntnltyId,//$chldNtnltyId,
												);	
							
							$this->db->insert('traveler_info', $childInfoNew); 
							}	
			 			}
						
						date_default_timezone_set('Asia/Jakarta');
						$bkngVldUntl = date('Y-m-d H:i:s', strtotime('+6 hours'));
						
					  	$dataUpdt = array(
							   'book_step' => '2',
							   'payment_method' => $paymentMethod,
							   'arrive_flight_number' => $arrivalFlightNumber,
							   'departure_flight_number' => $departFlightNumber,
							   'arrive_flight_date' => $arrivalDate,
							   'departure_flight_date' => $departDate,
							   'pickup_dropoff' => $pickupDropoff,
							   'validated' => "0",
							   'booking_expiry' => $bkngVldUntl
							  
						);
						$this->db->where('usid', $usid);
						$this->db->update('book_packages', $dataUpdt); 
					$this->sending_email_confirm_payByBT($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL);
					$data['pagecontent'] = "user/booking_success";
			 		$this->load->vars($data);
			 		$this->load->view('template');
				}
/* =====================================booking payment with bank transfer for guest end here==================================== */		
			}	
/* ==========================================guest booking end here======================================================= */		
		}
}
/* ==========================================booking processing request end here============================================ */
function sending_email_confirm_payByBT($transCode,$email,$salutationTL,$firstNameTL,$lastNameTL){
$this->db->select('*');
$this->db->from('book_packages');
$this->db->join('packages','packages.API_packages_id=book_packages.API_packages_id','left');
$this->db->where('transaction_code', $transCode);
$qry = $this->db->get();
foreach($qry->result() as $rows){
	$trnsCode = $rows->transaction_code;
	$pckgRefCode = $rows->API_packages_refno;
	$pckgName = $rows->nama;
	$totAmount = $rows->total_sale_price_amount;
	$crrncy = $rows->currency_code;
	$bkngDate = $rows->booking_date;
	$trvlDate = $rows->travel_date;
	$cntryCode = $rows->country_code;
	$adlPx = $rows->adult;
	$chldPx = $rows->child;
	$pymntMthd = $rows->payment_method;
	$slctCntry = $this->db->get_where('packages_country', array('country_iso' => $cntryCode));
	foreach($slctCntry->result() as $fldCntry){
		$cntryName = $fldCntry->country_name;
	}
	$slctPymntMtd = $this->db->get_where('metode_pembayaran', array('kode' => $pymntMthd));
	foreach($slctPymntMtd->result() as $fldPymnt){
		$pymntName = $fldPymnt->nama_metode;
	}
	
	
}
if(!empty($chldPx)){
	$childPAX = $chldPx;
}
else{
	$childPAX = '0';
}
$body='
		<div style="width:100%;"><img src="'.base_url().'asset/theme/Logo.png" style="width:150px" /></div>
		<div id="content">
			<div><h3>Booking Confirmation</h3></div>
			<div style="height:30px;">&nbsp;</div>
			<div>Dear '.$salutationTL.' '.ucwords($firstNameTL).' '.ucwords($lastNameTL).', </div>
			<div>Thank you for choosing our service, It is our pleasure to confirm your booking details. Your booking will expired for next 6 hours, please confirm your payment to us as soon as possible for processing your booking. Please do not hestitate to contact us with any questions. </div>
			<div style="height:30px;">&nbsp;</div>
			<div><strong>Booking Details</strong></div>
			<div>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr><td>Transaction Number</td><td> : <strong>'.$trnsCode.'</strong></td></tr>
					<tr><td>Package Name</td><td> : '.$pckgName.' ('.$pckgRefCode.')</td></tr>
					<tr><td>Country</td><td> : '.$cntryName.'</td></tr>
					<tr><td>Booking Date</td><td> : '.$bkngDate.'</td></tr>
					<tr><td>Travel Date</td><td> : '.$trvlDate.'</td></tr>
					<tr><td>Adult PAX</td><td> : '.$adlPx.'</td></tr>
					<tr><td>Child PAX</td><td> : '.$childPAX.'</td></tr>
					<tr><td>Payment Method</td><td> : '.$pymntName.'</td></tr>
					<tr><td>Tot. Amount</td><td> : <strong>'.$crrncy.' '.$totAmount.'</strong></td></tr>
				</table>
			</div>
			<div style="height:30px;">&nbsp;</div>
			<div>All Regards</div>
			<div>Tiket24.co.id</div>
		</div>
		';
			$this->email->to($email);
			$this->email->from('noreply@tiket24.co.id');
			$this->email->subject('Booking Confirmation');
			$this->email->message($body);
			$this->email->send();
}

function sending_email_confirm_payByCC($transCode,$email,$salutationTL,$firstNameTL,$lastNameTL,$vchrUrl){
$this->db->select('*');
$this->db->from('book_packages');
$this->db->join('packages','packages.API_packages_id=book_packages.API_packages_id','left');
$this->db->where('transaction_code', $transCode);
$qry = $this->db->get();
foreach($qry->result() as $rows){
	$trnsCode = $rows->transaction_code;
	$pckgRefCode = $rows->API_packages_refno;
	$pckgName = $rows->nama;
	$totAmount = $rows->total_sale_price_amount;
	$crrncy = $rows->currency_code;
	$bkngDate = $rows->booking_date;
	$trvlDate = $rows->travel_date;
	$cntryCode = $rows->country_code;
	$adlPx = $rows->adult;
	$chldPx = $rows->child;
	$pymntMthd = $rows->payment_method;
	$slctCntry = $this->db->get_where('packages_country', array('country_iso' => $cntryCode));
	foreach($slctCntry->result() as $fldCntry){
		$cntryName = $fldCntry->country_name;
	}
	$slctPymntMtd = $this->db->get_where('metode_pembayaran', array('kode' => $pymntMthd));
	foreach($slctPymntMtd->result() as $fldPymnt){
		$pymntName = $fldPymnt->nama_metode;
	}
	
	
}
if(!empty($chldPx)){
	$childPAX = $chldPx;
}
else{
	$childPAX = '0';
}

$qryTrvlrTL = $this->db->get_where('traveler_info', array('transaction_code' => $trnsCode, 'isContact' => '1'));
foreach($qryTrvlrTL->result() as $rowTrvlrTL){
	$emailTL = $rowTrvlrTL->email;
	$cntctNmbrTL = $rowTrvlrTL->contact_number;
}

$body='
		<div style="width:100%;"><img src="'.base_url().'asset/theme/Logo.png" style="width:150px" /></div>
		<div id="content">
			<div><h2>Booking Confirmation</h3></div>
			<div style="height:30px;">&nbsp;</div>
			<div>Dear '.$salutationTL.' '.ucwords($firstNameTL).' '.ucwords($lastNameTL).', </div>
			<div>Thank you for choosing our service, It is our pleasure to confirm your booking details. Please do not hestitate to contact us with any questions. </div>
			<div style="height:30px;">&nbsp;</div>
			<div><h3>Booking Details</h3></div>
			
			<div>
				<div style="font-weight:bold;"><strong>Tour/Attraction Details</strong></div>
				<div><hr style="border:1px #2b4e75 solid" /></div>
			</div>
			<div>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr><td style="width:200px;">Transaction Number</td><td> : <strong>'.$trnsCode.'</strong></td></tr>
					<tr><td>Package Name</td><td> : '.$pckgName.' ('.$pckgRefCode.')</td></tr>
					<tr><td>Country</td><td> : '.$cntryName.'</td></tr>
					<tr><td>Booking Date</td><td> : '.$bkngDate.'</td></tr>
					<tr><td>Travel Date</td><td> : '.$trvlDate.'</td></tr>
				</table>
			</div>
			<br />
			<div>
				<div style="font-weight:bold;"><strong>Traveler Details</strong></div>
				<div><hr style="border:1px #2b4e75 solid" /></div>
			</div>
			<div>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr><td style="width:200px;">Traveler Leader</td><td> : <strong>'.$salutationTL.' '.ucwords($firstNameTL).' '.ucwords($lastNameTL).'</strong></td></tr>
					<tr><td>Contact Number</td><td> : '.$cntctNmbrTL.'</td></tr>
					<tr><td>Email</td><td> : '.$emailTL.'</td></tr>
					<tr><td>Adult(s)</td><td> : '.$adlPx.'</td></tr>
					<tr><td>Child(s)</td><td> : '.$childPAX.'</td></tr>
				</table>
			</div>
			<div>
				<div><hr style="border:1px #2b4e75 solid" /></div>
			</div>
			<div>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr><td style="width:200px;">Payment Method</td><td> : '.$pymntName.'</td></tr>
					<tr><td>Tot. Amount</td><td> : <strong>'.$crrncy.' '.$totAmount.'</strong></td></tr>
					<tr><td>Voucher </td><td> : '.htmlspecialchars_decode($vchrUrl).'</td></tr>
				</table>
			</div>
			
			
			<br />
			<div style="height:30px;">&nbsp;</div>
			<div>All Regards</div>
			<div>Tiket24.co.id</div>
		</div>
		';
			$this->email->to($email);
			$this->email->from('noreply@tiket24.co.id');
			$this->email->subject('Booking Confirmation');
			$this->email->message($body);
			$this->email->send();
}

function sending_email_confirm_payByCC_pckgeMnl($transCode,$email,$salutationTL,$firstNameTL,$lastNameTL,$vchrUrl){
$this->db->select('*');
$this->db->from('book_packages');
$this->db->join('packages','packages.API_packages_id=book_packages.API_packages_id','left');
$this->db->where('transaction_code', $transCode);
$qry = $this->db->get();
foreach($qry->result() as $rows){
	$trnsCode = $rows->transaction_code;
	$pckgRefCode = $rows->kode;
	$pckgName = $rows->nama;
	$totAmount = $rows->total_sale_price_amount;
	$crrncy = $rows->currency_code;
	$bkngDate = $rows->booking_date;
	$trvlDate = $rows->travel_date;
	$cntryCode = $rows->country_code;
	$adlPx = $rows->adult;
	$chldPx = $rows->child;
	$pymntMthd = $rows->payment_method;
	$slctCntry = $this->db->get_where('packages_country', array('country_iso' => $cntryCode));
	foreach($slctCntry->result() as $fldCntry){
		$cntryName = $fldCntry->country_name;
	}
	$slctPymntMtd = $this->db->get_where('metode_pembayaran', array('kode' => $pymntMthd));
	foreach($slctPymntMtd->result() as $fldPymnt){
		$pymntName = $fldPymnt->nama_metode;
	}
	
	
}
if(!empty($chldPx)){
	$childPAX = $chldPx;
}
else{
	$childPAX = '0';
}

$qryTrvlrTL = $this->db->get_where('traveler_info', array('transaction_code' => $trnsCode, 'isContact' => '1'));
foreach($qryTrvlrTL->result() as $rowTrvlrTL){
	$emailTL = $rowTrvlrTL->email;
	$cntctNmbrTL = $rowTrvlrTL->contact_number;
}

$body='
		<div style="width:100%;"><img src="'.base_url().'asset/theme/Logo.png" style="width:150px" /></div>
		<div id="content">
			<div><h2>Booking Confirmation</h3></div>
			<div style="height:30px;">&nbsp;</div>
			<div>Dear '.$salutationTL.' '.ucwords($firstNameTL).' '.ucwords($lastNameTL).', </div>
			<div>Thank you for choosing our service, It is our pleasure to confirm your booking details. Please do not hestitate to contact us with any questions. </div>
			<div style="height:30px;">&nbsp;</div>
			<div><h3>Booking Details</h3></div>
			
			<div>
				<div style="font-weight:bold;"><strong>Tour/Attraction Details</strong></div>
				<div><hr style="border:1px #2b4e75 solid" /></div>
			</div>
			<div>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr><td style="width:200px;">Transaction Number</td><td> : <strong>'.$trnsCode.'</strong></td></tr>
					<tr><td>Package Name</td><td> : '.$pckgName.' ('.$pckgRefCode.')</td></tr>
					<tr><td>Country</td><td> : '.$cntryName.'</td></tr>
					<tr><td>Booking Date</td><td> : '.$bkngDate.'</td></tr>
					<tr><td>Travel Date</td><td> : '.$trvlDate.'</td></tr>
				</table>
			</div>
			<br />
			<div>
				<div style="font-weight:bold;"><strong>Traveler Details</strong></div>
				<div><hr style="border:1px #2b4e75 solid" /></div>
			</div>
			<div>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr><td style="width:200px;">Traveler Leader</td><td> : <strong>'.$salutationTL.' '.ucwords($firstNameTL).' '.ucwords($lastNameTL).'</strong></td></tr>
					<tr><td>Contact Number</td><td> : '.$cntctNmbrTL.'</td></tr>
					<tr><td>Email</td><td> : '.$emailTL.'</td></tr>
					<tr><td>Adult(s)</td><td> : '.$adlPx.'</td></tr>
					<tr><td>Child(s)</td><td> : '.$childPAX.'</td></tr>
				</table>
			</div>
			<div>
				<div><hr style="border:1px #2b4e75 solid" /></div>
			</div>
			<div>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr><td style="width:200px;">Payment Method</td><td> : '.$pymntName.'</td></tr>
					<tr><td>Tot. Amount</td><td> : <strong>'.$crrncy.' '.number_format($totAmount,2).'</strong></td></tr>
					<tr><td>Voucher </td><td> : '."$vchrUrl".'</td></tr>
				</table>
			</div>
			
			
			<br />
			<div style="height:30px;">&nbsp;</div>
			<div>All Regards</div>
			<div>Tiket24.co.id</div>
		</div>
		';
			$this->email->to($email);
			$this->email->from('noreply@tiket24.co.id');
			$this->email->subject('Booking Confirmation');
			$this->email->message($body);
			$this->email->send();
}


function validate_creditCard(){	
	$cardNumber = $this->input->post('txtCardNumber');
	$cardSecureCode = $this->input->post('txtCardSecureCode');
	$cardHolderName = $this->input->post('txtNameOnCard');
	$cardExpiry = $this->input->post('txtCardExpiryDate');
/* validate result from payment gateway provider */	
	return TRUE;
}


/* booking processing start here */	
	function proceed(){
	/* input activity search price start here */	
	$actvtyID = 736;
	$adultPax = 2;
	$childPax = 2;
	$travelDate = '2014-10-15';
	$crrncy = 'SGD';
	$childPaxAge = array('3', '7');
	
		
		/* input activity search price end here */	
		$SOAP = $this->API_asiatravel_ActivityWS();
		$Data = array(
		   'RequestParam' => array(
		    'ActivityID' => $actvtyID,
		    'Adult' => $adultPax,
		    'SeniorCitizen' => '0', 
		    'Child'=> $this->get_arrChildAge($childPaxAge),
			'Currency' => $crrncy,
		    'TourDetails' => $this->get_tours_details_forSearhPrice($travelDate,$actvtyID)
			)
		
		);
		
		$Response = $SOAP->SearchActivityPrice($Data);
		$string = $SOAP->__getLastResponse();
		
		$xml = simplexml_load_string($string);
		$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xml->registerXPathNamespace('ns', 'http://tempuri.org/');
		foreach ($xml->xpath('//ns:SearchActivityPriceResult/ns:ActivitiePrice') as $item)
		{
		$USID = $item->USID;
		$ActivityID = $item->ActivityID;
		$ActivityName = $item->ActivityName;
		$BookURL = $item->BookURL;
		$Adult = $item->Adult;
		$Child = $item->Child;
		$Country = $item->Country;
		$City = $item->City;
		$Currency = $item->Currency;
		$PriceAdult = $item->PriceAdult;
		$PriceChild = $item->PriceChild;
		$PriceSeniorCitizen = $item->PriceSeniorCitizen;
		$TotalAmount = $item->TotalAmount;
		/* ===================================== */
		 echo "<b>USID : </b>".$USID.'<br />';
			 echo "<b>ActivityID : </b>".$ActivityID.'<br />';
			 echo "<b>ActivityName : </b>".$ActivityName.'<br />';
			 echo "<b>BookURL : </b>".$BookURL.'<br />';
			 echo "<b>Adult : </b>".$Adult.'<br />';
			 echo "<b>Child : </b>".$Child.'<br />';
			 echo "<b>Country : </b>".$Country.'<br />';
			 echo "<b>City : </b>".$City.'<br />';
			 echo "<b>Currency : </b>".$Currency.'<br />';
			 echo "<b>PriceAdult : </b>".$PriceAdult.'<br />';
			 echo "<b>PriceChild : </b>".$PriceChild.'<br />';
			 echo "<b>PriceSeniorCitizen : </b>".$PriceSeniorCitizen.'<br />';
			 echo "<b>TotalAmount : </b>".$TotalAmount.'<br />';
			 
			 
			 
		     echo "<br /><hr /><br />";
		
		$dataBooking = array(
		    'RequestParam' => array(
		    'USID' => $USID,
		    'ActivityID' => $ActivityID,
		    'Adult' => $Adult , 
			'SeniorCitizen' => '0',
		    'Child'=> $this->get_arrChildAge($childAge),
		    'TourDetails' => $this->get_tours_details_forBooking($travelDate, $actvtyID),
			               
			'Currency' => $Currency,
			'TotalPrice' => $TotalAmount,
			'PickUpDropOffHotel'=> array(
			                            'PickupPointID' => '412',
										'PickupDropOffPoint' => 'YAnne Black - YWCA'
							            ),
			'LeadTravelerInfo'=> array(
			                            'Title' => 'Mr',
										'FirstName' => 'William',
										'LastName' => 'Strong',
										'PassengerType' => '32',
										'Age' => '38',
										'PassportNumber' => '6456456',
										'DOB' => '1980-09-12',
										'PassportExpiryDate' => '2015-09-25',
										'PassportIssuanceCountry' => 'America',
										'NationalityID' => '10'
							            ),
		    'GuestDetails' => array(
			                     
			                      '_' => array(
								                  'Title' => 'Mr', 
												  'FirstName' => 'John', 
												  'LastName' =>  'Coed',
												  'PassengerType' =>  '32',
												  'Age' =>  '35',
												  'PassportNumber' =>  '23123123',
												  'DOB' =>  '1979-05-28',
												  'PassportExpiryDate' =>  '2015-05-15',
												  'PassportIssuanceCountry' =>  'america',
												  'NationalityID' =>  '10'
												),
												
								   '_' => array(
								                  'Title' => 'None', 
												  'FirstName' => 'boby', 
												  'LastName' =>  'boob',
												  'PassengerType' =>  '33',
												  'Age' =>  '3',
												  'PassportNumber' =>  '23123123',
												  'DOB' =>  '2012-05-28',
												  'PassportExpiryDate' =>  '2015-05-15',
												  'PassportIssuanceCountry' =>  'america',
												  'NationalityID' =>  '10'
												),
									'_' => array(
								                  'Title' => 'None', 
												  'FirstName' => 'sally', 
												  'LastName' =>  'boob',
												  'PassengerType' =>  '33',
												  'Age' =>  '7',
												  'PassportNumber' =>  '23123123',
												  'DOB' =>  '2008-05-28',
												  'PassportExpiryDate' =>  '2015-05-15',
												  'PassportIssuanceCountry' =>  'america',
												  'NationalityID' =>  '10'
												)	
		                            										
								 ),
			                
		    'FlightInfo'=> array(
			                      'ArrivalFlightNumber' => 'fgdfg',
								  'DepartureFlightNumber' => 'dfgdfg',
								  'ArrivalDate' => '2014-07-15',
								  'DepartureDate' => '2014-07-20'
							  ),
			'ContactInfo'=> array(
			                      'Salutation' => 'Mr',
								  'FirstName' => 'William',
								  'LastName' => 'Strong',
								  'Email' => 'sdasdasd',
								  'Email2' => 'sdasd',
								  'ContactNumber' => '34324324',
								  'MobileNumber' => '432424',
								  'FaxNumber' => '4324324',
								  'Address' => 'dsfdsfsdfsdf',
								  'PostalCode' => '3434',
								  'City' => 'fdsfdsff',
								  'CountryCode' => 'US',
								  'NationalityID' => '10',
								  'NationalityCode' => '1rtre0'
							  ),
			'CreditCardInfo'=> $this->get_credit_card_info()
					  ),
		);
		
		/*====================================Insert to API
		$Response = $SOAP->BookActivity($dataBooking);
		$stringBooking = $SOAP->__getLastResponse();
		
		
		$xmlBooking = simplexml_load_string($stringBooking);
		$xmlBooking->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xmlBooking->registerXPathNamespace('ns', 'http://tempuri.org/');
		R-20150126 ========================================*/
		
		echo '====================<b>Booking Activity Output</b>====================<br />';
		foreach ($xmlBooking->xpath('//ns:BookActivityResult') as $itemBooking)
		{
			$bkngUSID = $itemBooking->USID;
			$bkngActivityID = $itemBooking->ActivityID;
			$bkngConfirmNumber = $itemBooking->ConfirmationNumber;
			$bkngStatus = $itemBooking->BookingStatus;
			$bkngTotPrice = $itemBooking->TotalPrice;
			$USSVisId = $itemBooking->USS->VisualID;
			$DisneyVisId = $itemBooking->Disney->VisualID;
			$SunwayLagoonVisId = $itemBooking->SunwayLagoon->VisualID;
			$TourAttractionVisId = $itemBooking->TourAttraction->VisualID;
			
			if(!empty($USSVisId)){
				$bkngVisualID = $itemBooking->USS->VisualID;
				$bkngTicketType = $itemBooking->USS->TicketType;
				$bkngTravelDate = $itemBooking->USS->TravelDate;
			}
			if(!empty($DisneyVisId)){
				$bkngVisualID = $itemBooking->Disney->VisualID;
				$bkngVisualIDExpiryDate = $itemBooking->Disney->VisualIDExpiryDate;
				$bkngTicketType = $itemBooking->Disney->TicketType;
				$bkngTravelDate = $itemBooking->Disney->TravelDate;
			}
			if(!empty($SunwayLagoonVisId)){
				$bkngVisualID = $itemBooking->SunwayLagoon->VisualID;
				$bkngVisualIDExpiryDate = $itemBooking->SunwayLagoon->VisualIDExpiryDate;
				$bkngTicketType = $itemBooking->SunwayLagoon->TicketType;
				$bkngTravelDate = $itemBooking->SunwayLagoon->TravelDate;
			}
			if(!empty($TourAttractionVisId)){
				$bkngVisualID = $itemBooking->TourAttraction->VisualID;
				$bkngVisualIDExpiryDate = $itemBooking->TourAttraction->VisualIDExpiryDate;
				$bkngTravelDate = $itemBooking->TourAttraction->TravelDate;
			}
			
			
			
		     echo "<b>USID : </b>".$itemBooking->USID.'<br />';
			 echo "<b>ActivityID : </b>".$itemBooking->ActivityID.'<br />';
			 echo "<b>BookingStatus : </b>".$itemBooking->BookingStatus.'<br />';
			 echo "<b>ConfirmationNumber : </b>".$itemBooking->ConfirmationNumber.'<br />';
			 echo "<b>Currency : </b>".$itemBooking->Currency.'<br />';
			 echo "<b>TotalPrice : </b>".$itemBooking->TotalPrice.'<br />';
			 
			
			
		     echo "<br /><hr /><br />";
		}
		 
			 
		/* ===================================== */	 
		     echo "<br /><hr /><br />";
		}
	}
	function get_arr_PickUpDropOffHotel($ActivityID){
		$qry = $this->db->get_where('pickup_point', array('API_packages_id', $ActivityID));
		foreach($qry->result() as $row ){
			$PickupPointID = $row->hotel_code;
			$PickupDropOffPoint = $row->hotel_name;
		}
		$data = array('PickupPointID' => $PickupPointID,	'PickupDropOffPoint' => $PickupDropOffPoint);
		return $data;
	}
	function get_credit_card_info(){
		$id = $this->finance->get_creditcard(1);
		$qry = $this->db->get_where('card_type', array('id' => $id));
		foreach($qry->result() as $row){
			$crdType = $row->type_name;
		}
		
		$creditCard = array( 'CardType' => $this->finance->get_creditcard(1),
								  'CardHolderName' => $this->finance->get_creditcard(2),
								  'BankName' => $this->finance->get_creditcard(3),
								  'CardCountryCode' => $this->finance->get_creditcard(4),
								  'CardNumber' => $this->finance->get_creditcard(5),
								  'CardSecurityCode' => $this->finance->get_creditcard(6),
								  'CardExpiryDate' => $this->finance->get_creditcard(7),
								  'CardContactNumber' => $this->finance->get_creditcard(8),
								  'CardAddress' => $this->finance->get_creditcard(9),
								  'CardAddressPostalCode' => $this->finance->get_creditcard(10),
								  'CardAddressCity' => $this->finance->get_creditcard(11),
								  'CardAddressCountryCode' => $this->finance->get_creditcard(12),
								 );
		return $creditCard;
	}
	function get_tours_details_forBooking($travelDate, $actvtyID){
		//$tourDet = array();
		$this->db->select('*');
		$this->db->from('tours');
		$this->db->where('API_packages_id', $actvtyID);
		$qryGetDetailsTour = $this->db->get();
		foreach($qryGetDetailsTour->result() as $rowTour)
		{
			$trCtgry = $rowTour->tour_category;	
			switch($trCtgry){
				case 11 : $tourSessn = 'MorningTour'; break;
				case 12 : $tourSessn = 'EveningTour'; break;
				case 13 : $tourSessn = 'AfternoonTour'; break;
				case 14 : $tourSessn = 'FullDayTour'; break;
				case 15 : $tourSessn = 'None'; break;
			}	
			
			$trid= $rowTour->tour_id;
			$tourDet['Tour'][] = array('TourID' => "$trid", 'TravelDate' => "$travelDate", 'TourSession' => $tourSessn);
			
		}	
		return $tourDet;
	}

	function get_tours_details_forSearhPrice($travelDate, $actvtyID){
		//$tourDet = array();
		$this->db->select('*');
		$this->db->from('tours');
		$this->db->where('API_packages_id', $actvtyID);
		$qryGetDetailsTour = $this->db->get();
		foreach($qryGetDetailsTour->result() as $rowTour)
		{
			$trid= $rowTour->tour_id;
			$trtp= $rowTour->tour_type;
			$tourDet['Tours'][] = array('TourID' => "$trid", 'TravelDate' => "$travelDate", 'TourType' => "$trtp");
			
		}	
		return $tourDet;
	}
	
	function get_arrChildAge($childPaxArrAge){
		$i=0;
		$arrChildAge = array();
		$chldAge = array();
		foreach($childPaxArrAge as $age){
			$chldAge[$i] = $age;
			$i++;
		}
		$arrChildAge = array('Age' => $chldAge);
		return $arrChildAge;
	}
	function API_asiatravel_ActivityWS(){
	/* for method  
	 * BookActivity, GetPickupPointList, GetUSSBlockoutDateByYear, SearchActivityByDestination, SearchActivityPrice
	*/
		$WSDL ="http://ws.asiatravel.net/PartnerPackageWSv2/ActivityWS.asmx?wsdl";
		//$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityWS.asmx?wsdl";
		$SOAP = new SoapClient($WSDL, array("trace" => 1, "exception" => 0));
		$authvalues = array(
				'AgentCode'=>'PTADV',
				'PartnerID'=>'adventure_xml',
				'Culture'=>'en-US',
				'Password'=>'adventure1'
				);
		$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, 0);
		$SOAP->__setSoapHeaders(array($header));
		
		return $SOAP;
	}
	function API_asiatravel_ActivityLookUp(){
	/* for method  
	 * GetTourInfoImportantNotes, SearchAvailableDestinations 
	*/
		$WSDL ="http://ws.asiatravel.net/PartnerPackageWSv2/ActivityLookUp.asmx?wsdl";
		//$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityLookUp.asmx?wsdl";
		$SOAP = new SoapClient($WSDL, array("trace" => 1, "exception" => 0));
		$authvalues = array(
				'AgentCode'=>'PTADV',
				'PartnerID'=>'adventure_xml',
				'Culture'=>'en-US',
				'Password'=>'adventure1'
				);
		$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, 0);
		$SOAP->__setSoapHeaders(array($header));
		
		return $SOAP;
	}
/* booking processing end here */	
	function mpdf(){
		$html ='<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td>
    <center><strong>
    <div>TRAVEL CONFIRMATION VOUCHER</div>
    <div>MASTER BOOKING REFERENCE NUMBER : KH91PNHFP0000308</div>
    <div>Half Day Phnom Penh Mini Angkor Tour
    ( PK00866PNH91 )</div></strong></center>
    </td>
    <td><img src="'.base_url().'asset/theme/Logo.png" width="100" /></td>
</tr>
</table>';

$html .='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:10px;">
<tr>
    <td colspan="2">
        <div>
            <div style="font-weight: bold;">Package Inclusive of :</div>
            <div>
                <ul>
                    <li>Half Day Phnom Penh Mini Angkor Tour with English speaking Tour Guide (Include Lunch) </li>
                    <li>Pick up &amp; drop off service from hotel</li>
                </ul>
            </div>
        </div>
    </td>
</tr>
</table>';

$html .='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:11px;">
<tr>
    <td width="180">Leader Travel Party</td>
    <td>: jajang ceper</td>
</tr>
<tr>
    <td width="180">Contact Travel Party</td>
    <td>: jajang ceper</td>
</tr>
<tr>
    <td width="180">Contact Number</td>
    <td>: 45345345345</td>
</tr>
<tr>
    <td width="180">Email Address </td>
    <td>: example@example.com</td>
</tr>
<tr>
    <td width="180">Total Number of Travellery</td>
    <td>: 2 Adult(s) and 2 Child(s)</td>
</tr>
<tr>
    <td width="180">Pick Up / Drop Off Hotel </td>
    <td>: dsfsdfsdf</td>
</tr>
</table>
<hr width="100%" color="#CCCCCC" />';

$html .='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:11px;">
<tr>
    <td colspan="2">
        <div><strong><u>Half Day Phnom Penh Mini Angkor Tour With Lunch</u></strong></div>
    </td>
</tr>
<tr>
    <td width="180">Tour Date</td>
    <td>: 12 Oct 2014 </td>
</tr>
<tr>
    <td width="180">Pick Up Time </td>
    <td>: 0730Hrs OR 1230Hrs</td>
</tr>
<tr>
    <td width="180">Tour Start Time </td>
    <td>: 0800HRS OR 1300Hrs </td>
</tr>
<tr>
    <td width="180">Duration </td>
    <td>: 5Hrs</td>
</tr>
</table>';

$html .='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9px;">
<tr>
    <td>
    	<div><strong><u>Important Notes :</u></strong></div>
        <div><P>Kindly wait at hotel lobby at least 10 minutes before the tour pick up time. Please present your tour confirmation voucher to the Tour Guide whom will be waiting for you at the hotel lobby, holding a signboard with your name written. Tour voucher must be presented to the Tour Guide for verification before tour commencement.</P>
<P><BR>All tours are confirmed and paid. Unutilized tour component are non-refundable. Tour timings are inclusive of traveling time to tour coordination point.Subject to change due to weather/road conditions and/or Tour Guide discretion. Tipping is at passenger own discretion.</P>
<P><BR>For emergency assistance, please call following number:</P>
<P><BR></P>
<P>Ms Bony : +855 1754 5832<BR><BR>Mr Kim Long : +855 1195 9999</P></div>
    </td>
</tr>
</table>

<hr width="100%" color="#CCCCCC" />';

$html .='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9px;">
<tr>
    <td>
        <div><strong><u>Cancelation Policy :</u></strong></div>
        <div><strong><ul><strong><li><strong>Notification of amendment or cancellation must reach us at least 3 working day (s) (not including non-working days and Public Holiday) prior to&nbsp;tour date to avoid a penalty charge.<br></strong></li><li><strong>This same penalty charge is also applicable if you do not turn up as reserved.</strong></li></strong></ul></strong></div>
    </td>
</tr>
</table>
		';

		include("mpdf57/mpdf.php");
		$mpdf=new mPDF('utf-8', 'A5', 0, '', 5, 5, 10, 5, 5, 5, 'P');
		//$mpdf->SetDisplayMode('fullpage');

		$footer ='
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:6pt">
		  <tr>
			<td style="text-align:right;">This document is System Generated hence No Signatured is Required.</td>
		  </tr>
		</table>
		';

		$mpdf->SetHTMLFooter($footer);
		$mpdf->SetTitle('Package Voucher');
		$mpdf->SetAuthor('www.tiket24.star-holiday.com');
		$mpdf->SetCreator('www.tiket24.star-holiday.com');

		// LOAD a stylesheet
		$stylesheet = file_get_contents('mpdf57/examples/mpdfstyletables.css');
		$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
		$mpdf->WriteHTML($html);
		$mpdf->WriteHTML('<tocentry content="Letter landscape" />');

		$mpdf->Output('file/packagevoucher.pdf', 'F');//save into file
	}

	function testbook(){
		$SOAP = $this->API_asiatravel_ActivityWS();
		$transCode = 'TG20141013082247BD1063PC';
				$this->db->select('*');
				$this->db->from('book_packages');
				$this->db->where('transaction_code', $transCode);
				$qrySlctBkng = $this->db->get();
				foreach($qrySlctBkng->result() as $rowsBkng){
					$bkngPckgId = $rowsBkng->API_packages_id;
					$adult = $rowsBkng->adult;
					$child = $rowsBkng->child;
					$currencyBkng = $rowsBkng->currency_code;
					$childBkngAges = $rowsBkng->child_ages;
					$travelDate = $rowsBkng->travel_date;
					$totAmount = $rowsBkng->total_amount;
					$transCode = $rowsBkng->transaction_code;
					$pickupDropoff = $rowsBkng->pickup_dropoff;
					$arrivalFlightNumber = $rowsBkng->arrive_flight_number;
					$departFlightNumber = $rowsBkng->departure_flight_number;
					$arrivalDate = $rowsBkng->arrive_flight_date;
					$departDate = $rowsBkng->departure_flight_date;
					$usid = $rowsBkng->usid;
					
				}
				$childPaxAge = unserialize($childBkngAges);
				$arrChldAges = array('Age' => $childPaxAge);
				$arrTours = $this->get_tours_details_forSearhPrice($travelDate,$bkngPckgId);
				
		$Data = array(
		   'RequestParam' => array(
		    'ActivityID' => $bkngPckgId,
		    'Adult' => $adult,
		    'SeniorCitizen' => '0', 
		    'Child'=> $arrChldAges,
			'Currency' => $currencyBkng,
		    'TourDetails' => $arrTours
			)
		
		);
		
		
		$ResponsePS = $SOAP->SearchActivityPrice($Data);
		$stringPS = $SOAP->__getLastResponse();
		$xmlPS = simplexml_load_string($stringPS);
		$xmlPS->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xmlPS->registerXPathNamespace('ns', 'http://tempuri.org/');
		foreach ($xmlPS->xpath('//ns:SearchActivityPriceResult/ns:ActivitiePrice') as $itemPS)
		{
			$USID = $itemPS->USID;
			$ActivityID = $itemPS->ActivityID;
			$ActivityName = $itemPS->ActivityName;
			$BookURL = $itemPS->BookURL;
			$Adult = $itemPS->Adult;
			$Child = $itemPS->Child;
			$Country = $itemPS->Country;
			$City = $itemPS->City;
			$Currency = $itemPS->Currency;
			$PriceAdult = $itemPS->PriceAdult;
			$PriceChild = $itemPS->PriceChild;
			$PriceSeniorCitizen = $itemPS->PriceSeniorCitizen;
			$TotalAmount = $itemPS->TotalAmount;
			echo 'USID :'.$USID.'<br />';
			echo 'ActivityID :'.$ActivityID.'<br />';
			echo 'ActivityName :'.$ActivityName.'<br />';
			echo 'Adult :'.$Adult.'<br />';
			echo 'Child :'.$Child.'<br />';
			echo 'Country :'.$Country.'<br />';
			echo 'City :'.$City.'<br />';
			echo 'Currency :'.$Currency.'<br />';
			echo 'PriceAdult :'.$PriceAdult.'<br />';
			echo 'PriceChild :'.$PriceChild.'<br />';
			echo 'PriceSeniorCitizen :'.$PriceSeniorCitizen.'<br />';
			echo 'TotalAmount :'.$TotalAmount.'<br />';
			echo '<br />';	
		}
		/* ========================================================================= */
		if(!empty($pickupDropoff)){
			$qryPickDrop = $this->db->get_where('pickup_point', array('API_packages_id' => $bkngPckgId, 'hotel_code' => $pickupDropoff));
			foreach($qryPickDrop->result() as $rowPUDO){
				$pckUpPnt_name = $rowPUDO->hotel_name;
				$pckUpPnt_id = $rowPUDO->hotel_code;
			}
		}
		else{
			$pckUpPnt_name = 'empty';
			$pckUpPnt_id = '000';
		}
		$trvlLdr = $this->db->get_where('traveler_info', array('transaction_code'=>$transCode,'isLeader'=>'1'));
		foreach($trvlLdr->result() as $rowTL){
			$TrvlLdr_Title = $rowTL->title;
			$TrvlLdr_FirstName = $rowTL->first_name;
			$TrvlLdr_LastName = $rowTL->last_name;
			$TrvlLdr_PassengerType = $rowTL->traveler_type;
			$TrvlLdr_Age = $rowTL->age;
			$TrvlLdr_PassportNumber = $rowTL->passport_number;
			$TrvlLdr_DOB = $rowTL->dob;
			$TrvlLdr_PassportExpiryDate = $rowTL->passport_expired_date;
			$TrvlLdr_PassportIssuanceCountry = $rowTL->passport_issuance_country;
			$TrvlLdr_NationalityID = $rowTL->nationality_id;
			
		}
		$trvlCntct = $this->db->get_where('traveler_info', array('transaction_code'=>$transCode,'isContact'=>'1'));
		foreach($trvlCntct->result() as $rowTC){
			$trvlCntct_Salutation = $rowTC->title;
			$trvlCntct_FirstName = $rowTC->first_name;
			$trvlCntct_LastName = $rowTC->last_name;
			$trvlCntct_Email = $rowTC->email;
			$trvlCntct_Email2 = $rowTC->alternate_email;
			$trvlCntct_ContactNumber = $rowTC->contact_number;
			$trvlCntct_MobileNumber = $rowTC->mobile_number;
			$trvlCntct_FaxNumber = $rowTC->fax_number;
			$trvlCntct_Address = $rowTC->address;
			$trvlCntct_PostalCode = $rowTC->postal_code;
			$trvlCntct_City = $rowTC->city_code;
			$trvlCntct_CountryCode = $rowTC->country_code;
			$trvlCntct_NationalityID = $rowTC->nationality_id;
			$trvlCntct_NationalityCode = $rowTC->nationality_code;
		}
		
		$i=1;
		$trvlAdlt = $this->db->get_where('traveler_info', array('transaction_code'=>$transCode,'isAdult'=>'1','isLeader'=>'0'));
		foreach($trvlAdlt->result() as $rowTA){
		$j = $i-1;
		$adlt_Title = $rowTA->title; 
		$adlt_FirstName =$rowTA->first_name;
		$adlt_LastName = $rowTA->last_name;
		$adlt_PassengerType = $rowTA->traveler_type;
		$adlt_Age = $rowTA->age;
		$adlt_PassportNumber = $rowTA->passport_number;
		$adlt_DOB = $rowTA->dob;
		$adlt_PassportExpiryDate = $rowTA->passport_expired_date;
		$adlt_PassportIssuanceCountry =  $rowTA->passport_issuance_country;
		$adlt_NationalityID = $rowTA->nationality_id;
			
			$adultGuest[$j] = array('Title' => "$adlt_Title", 
							   'FirstName' => "$adlt_FirstName", 
							   'LastName' => "$adlt_LastName",
							   'PassengerType' => "$adlt_PassengerType",
							   'Age' => "$adlt_Age",
							   'PassportNumber' => "$adlt_PassportNumber",
							   'DOB' => "$adlt_DOB",
							   'PassportExpiryDate' => "$adlt_PassportExpiryDate",
							   'PassportIssuanceCountry' =>  "$adlt_PassportIssuanceCountry",
							   'NationalityID' => "$adlt_NationalityID"
							   );
							   
		 $i++;
		}
		
		if(!empty($child)){
			
			$this->db->select('*');
			$this->db->from('traveler_info');
			$this->db->where('transaction_code', $transCode);
			$this->db->where('isChild', '1');
			$this->db->order_by('id', 'asc');
			$trvlChld = $this->db->get();
			foreach($trvlChld->result() as $row){
			$j = $i-1;
			$chld_Title = $row->title;
			$chld_FirstName = $row->first_name;
			$chld_LastName = $row->last_name;
			$chld_PassengerType = $row->traveler_type;
			$chld_Age = $row->age;
			$chld_PassportNumber = $row->passport_number;
			$chld_DOB = $row->dob;
			$chld_PassportExpiryDate = $row->passport_expired_date;
			$chld_PassportIssuanceCountry =  $row->passport_issuance_country;
			$chld_NationalityID = $row->nationality_id;
				
				$childGuest[$j] = array('Title' => "$chld_Title", 
							   'FirstName' => "$chld_FirstName", 
							   'LastName' => "$chld_PassengerType",
							   'PassengerType' => $chld_PassengerType,
							   'Age' => $chld_Age,
							   'PassportNumber' => "$chld_PassportNumber",
							   'DOB' => "$chld_DOB",
							   'PassportExpiryDate' => "$chld_PassportExpiryDate",
							   'PassportIssuanceCountry' =>  "$chld_PassportIssuanceCountry",
							   'NationalityID' => "$chld_NationalityID"
							   );
					
			$i++;
			}
		}
		
		if(!empty($child)){
			$arrDtaTrvlr = array_merge($adultGuest, $childGuest);
			$arrTravelers = $arrDtaTrvlr;
		}
		else{
			$arrTravelers = $adultGuest;
		}
		$trvlrsList = $this->get_tours_details_forBooking($travelDate, $bkngPckgId);
		$dataBooking = array(
		    'RequestParam' => array(
		    'USID' => "$USID",
		    'ActivityID' => "$bkngPckgId",
		    'Adult' => $adult, 
			'SeniorCitizen' => '0',
		    'Child'=> $arrChldAges,
		    'TourDetails' => $trvlrsList,
			               
			'Currency' => "$currencyBkng",
			'TotalPrice' => $totAmount,
			'PickUpDropOffHotel' => array('PickupPointID' => $pckUpPnt_id,'PickupDropOffPoint' => $pckUpPnt_name),
			'LeadTravelerInfo' => array(	
			                           'Title' => $TrvlLdr_Title,
										'FirstName' => $TrvlLdr_FirstName,
										'LastName' => $TrvlLdr_LastName,
										'PassengerType' => $TrvlLdr_PassengerType,
										'Age' => $TrvlLdr_Age,
										'PassportNumber' => $TrvlLdr_PassportNumber,
										'DOB' => $TrvlLdr_DOB,
										'PassportExpiryDate' => $TrvlLdr_PassportExpiryDate,
										'PassportIssuanceCountry' => $TrvlLdr_PassportIssuanceCountry,
										'NationalityID' => $TrvlLdr_NationalityID
							            ),
		    'GuestDetails' => $arrTravelers,
			                
		    'FlightInfo'=> array(
			                     'ArrivalFlightNumber' => $arrivalFlightNumber,
								  'DepartureFlightNumber' => $departFlightNumber,
								  'ArrivalDate' => $arrivalDate,
								  'DepartureDate' => $departDate
							  ),
			'ContactInfo' => array(
			
			
			                      'Salutation' => $trvlCntct_Salutation,
								  'FirstName' => $trvlCntct_FirstName,
								  'LastName' => $trvlCntct_LastName,
								  'Email' => $trvlCntct_Email,
								  'Email2' => $trvlCntct_Email2,
								  'ContactNumber' => $trvlCntct_ContactNumber,
								  'MobileNumber' => $trvlCntct_MobileNumber,
								  'FaxNumber' => $trvlCntct_FaxNumber,
								  'Address' => $trvlCntct_Address,
								  'PostalCode' => $trvlCntct_PostalCode,
								  'City' => $trvlCntct_City,
								  'CountryCode' => $trvlCntct_CountryCode,
								  'NationalityID' => $trvlCntct_NationalityID,
								  'NationalityCode' => $trvlCntct_NationalityCode
							  ),
			'CreditCardInfo'=> $this->get_credit_card_info(),
					  ),
		);
		print_r($dataBooking);
		/*====================================Insert to API
		$Response = $SOAP->BookActivity($dataBooking);
		$stringBooking = $SOAP->__getLastResponse();
		
		$xmlBooking = simplexml_load_string($stringBooking);
		$xmlBooking->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xmlBooking->registerXPathNamespace('ns', 'http://tempuri.org/');
		R-20150126 ========================================*/
		
		//echo '====================<b>Booking Activity Output</b>====================<br />';
		foreach ($xmlBooking->xpath('//ns:BookActivityResult') as $itemBooking)
		{			
			$bkngUSID = $itemBooking->USID;
			$bkngActivityID = $itemBooking->ActivityID;
			$bkngConfirmNumber = $itemBooking->ConfirmationNumber;
			$bkngStatus = $itemBooking->BookingStatus;
			$bkngTotPrice = $itemBooking->TotalPrice;
			$USSVisId = $itemBooking->USS->VisualID;
			$DisneyVisId = $itemBooking->Disney->VisualID;
			$SunwayLagoonVisId = $itemBooking->SunwayLagoon->VisualID;
			$TourAttractionVisId = $itemBooking->TourAttraction->VisualID;
			
				if(!empty($USSVisId)){
					$bkngVisualID = $itemBooking->USS->VisualID;
					$bkngTicketType = $itemBooking->USS->TicketType;
					$bkngTravelDate = $itemBooking->USS->TravelDate;
				}
				if(!empty($DisneyVisId)){
					$bkngVisualID = $itemBooking->Disney->VisualID;
					$bkngVisualIDExpiryDate = $itemBooking->Disney->VisualIDExpiryDate;
					$bkngTicketType = $itemBooking->Disney->TicketType;
					$bkngTravelDate = $itemBooking->Disney->TravelDate;
				}
				if(!empty($SunwayLagoonVisId)){
					$bkngVisualID = $itemBooking->SunwayLagoon->VisualID;
					$bkngVisualIDExpiryDate = $itemBooking->SunwayLagoon->VisualIDExpiryDate;
					$bkngTicketType = $itemBooking->SunwayLagoon->TicketType;
	
	
					$bkngTravelDate = $itemBooking->SunwayLagoon->TravelDate;
				}
				if(!empty($TourAttractionVisId)){
					$bkngVisualID = $itemBooking->TourAttraction->VisualID;
					$bkngVisualIDExpiryDate = $itemBooking->TourAttraction->VisualIDExpiryDate;
					$bkngTravelDate = $itemBooking->TourAttraction->TravelDate;
				}
				
					if(!empty($bkngVisualID) && !empty($bkngVisualIDExpiryDate)){
						$visID = $bkngVisualID;
						$visIDExpiry = $bkngVisualIDExpiryDate;
					}
					else{
						$visID = '';
						$visIDExpiry = '';
					}
				
				echo '<br />USID :'.$bkngUSID.'<br />';
				echo 'ActivityID :'.$bkngActivityID.'<br />';
				echo 'Booking Statu = '.$bkngStatus.'<br />';
				echo 'Confirmation Number  = '.$bkngConfirmNumber.'<br />';
				echo 'Tot Amount  = '.$bkngTotPrice.'<br />';
			
			}		
		/* ========================================================================= */

	}
	function gained_point($nilTotNom){
		$userRoleID = $this->tank_auth->get_user_role_id();
		$userID = $this->tank_auth->get_user_id();
		if($userRoleID == '2'){
			$MinimalBeli = $this->finance->get_point(13);	
			$NominalBeli = $this->finance->get_point(14);
			$PointBeli = $this->finance->get_point(15);
			$MinimalPoint = $this->finance->get_point(16);
			$PointTukar = $this->finance->get_point(17);
			$NominalBayar = $this->finance->get_point(18);
		}
		elseif($userRoleID == '3'){
			$MinimalBeli = $this->finance->get_point(19);
			$NominalBeli = $this->finance->get_point(20);
			$PointBeli = $this->finance->get_point(21);
			$MinimalPoint = $this->finance->get_point(22);
			$PointTukar = $this->finance->get_point(23);
			$NominalBayar = $this->finance->get_point(24);
		}
		$this->db->select('*');
		$this->db->from('currencies');
		$this->db->where('currency_from', 'SGD');
		$this->db->where('country_iso_from', 'SG');
		$this->db->where('currency_to', 'IDR');
		$this->db->where('country_iso_to', 'ID');
		$rateValCurr = $this->db->get();
		foreach($rateValCurr->result() as $rowRateFld){
				$valIdrRate = $rowRateFld->konversi;
		}
		$nilNomPerPoint_inSGD = $NominalBayar / $valIdrRate;
		$nilTotNom_toPoint = round($nilTotNom / $nilNomPerPoint_inSGD, 2);
	
		return $nilTotNom_toPoint;
	}
	
	/* ==========================booking processing request for package manual input start here============================= */
function process(){
	$tid = $this->input->post('tid');	
	$pid = $this->input->post('pid');	
	
	$salutationTL = $this->input->post('salutationTL');	
	$firstNameTL = $this->input->post('txtFirstNameTL');
	$lastNameTL = $this->input->post('txtLastNameTL');
	$ageTL = $this->input->post('txtAgeTL');
	//$passportNumberTL = $this->input->post('txtPssprtNmbrTL');
	$dayOfBirthTL = $this->input->post('txtDobTL');
	$passportExpiredDateTL = $this->input->post('txtPssprtExpryDteTL');
	//$passportIssuanceCountryTL = $this->input->post('txtPssprtIssuanceCntryTL');
	$nationalityTL = $this->input->post('nationalityIdTL');
	
	$salutationTC = $this->input->post('salutationTravCntc');
	$firstNameTC = $this->input->post('txtFirstNameTravCntc');
	$lastNameTC = $this->input->post('txtLastNameTC');
	$emailTC = $this->input->post('txtEmailTravCntc_1');
	//$alternateEmailTC = $this->input->post('txtEmailTravCntc_2');
	$phoneNumberTC = $this->input->post('txtPhoneNumberTravCntc');
	//$mobileNumberTC = $this->input->post('txtMobileNumberTravCntc');
	//$faxNumberTC = $this->input->post('txtFaxNumberTravCntc');
	//$addressTC = $this->input->post('txtaddressTravCntc');
	//$postalCodeTC = $this->input->post('txtPostalCodeTravCntc');
	//$countryTC = $this->input->post('txtCntryCodeTravCntc');
	//$cityTC = $this->input->post('txtCityCodeTravCntc');
	//$nationalityIdTC = $this->input->post('nationalityIdTravCntc');
	//$nationalityCodeTC = $this->input->post('nationalityCodeTravCntc');
	
	//$arrivalFlightNumber = $this->input->post('txtArrivFlightNum');
	//$departFlightNumber = $this->input->post('txtDepartFlightNum');
	//$arrivalDate = $this->input->post('txtArrivDate');
	//$departDate = $this->input->post('txtDepartDate');
	$pickupDropoff = $this->input->post('pikupDropoff');
	
	$cardNumber = $this->input->post('txtCardNumber');
	$cardSecureCode = $this->input->post('txtCardSecureCode');
	$cardHolderName = $this->input->post('txtNameOnCard');
	$cardExpiryDate = $this->input->post('txtCardExpiryDate');
	
	//$adultTravelerType = $this->input->post('travelerTypeAdult');
	//$adultSalutation = $this->input->post('salutationAdult');
	//$adultFirstName = $this->input->post('txtFrstNmeAdult');
	//$adultLastName = $this->input->post('txtLstNmeAdult');
	//$adultAge = $this->input->post('txtAgeAdult');
	//$adultPassportNumber = $this->input->post('txtPssprtNmbrAdult');
	//$adultDOB = $this->input->post('txtDobAdult');
	//$adultPassportExpiredDate = $this->input->post('txtPssprtExpryDteAdult');
	//$adultPassportIssuanceCountry = $this->input->post('txtPssprtIssncCntryAdult');
	//$adultNationality = $this->input->post('ntnlityIdAdult');
	
	$childTravelerType = $this->input->post('travelerTypeChild');
	$childSalutation = $this->input->post('salutationChild');
	$childFirstName = $this->input->post('txtFrstNmeChild');
	$childLastName = $this->input->post('txtLstNmeChild');
	$childAge = $this->input->post('txtAgeChild');
	//$childPassportNumber = $this->input->post('txtPssprtNmbrChild');
	$childDOB = $this->input->post('txtDobChild');
	$childPassportExpiredDate = $this->input->post('txtPssprtExpryDteChild');
	//$childPassportIssuanceCountry  = $this->input->post('txtPssprtIssnceCntryChild');
	//$childNationality = $this->input->post('ntnalityIdChild');
	
	$config = array(
			   array('field'   => 'salutationTL', 'label'   => 'Last Name', 'rules'   => 'required'),
               array('field'   => 'txtFirstNameTL', 'label'   => 'First Name', 'rules'   => 'required|xss_clean'),
			   array('field'   => 'txtLastNameTL', 'label'   => 'Last Name', 'rules'   => 'required'),
			  // array('field'   => 'txtAgeTL', 'label'   => 'Age', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtNmbrTL', 'label'   => 'Passport Number', 'rules'   => 'required'),
			   array('field'   => 'txtDobTL', 'label'   => 'Date of Birth', 'rules'   => 'required'),
			   array('field'   => 'txtPssprtExpryDteTL', 'label'   => 'Passport Expired Date', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtIssuanceCntryTL', 'label'   => 'Passport Issuance Country', 'rules'   => 'required'),
			   array('field'   => 'nationalityIdTL', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
			   array('field'   => 'txtFirstNameTravCntc', 'label'   => 'First Name', 'rules'   => 'required'),
			   array('field'   => 'txtLastNameTC', 'label'   => 'Last Name', 'rules'   => 'required'),
			   array('field'   => 'txtEmailTravCntc_1', 'label'   => 'Email', 'rules'   => 'required'),
			   //array('field'   => 'txtEmailTravCntc_2', 'label'   => 'Alternate Email', 'rules'   => 'required'),
			   array('field'   => 'txtPhoneNumberTravCntc', 'label'   => 'Phone Number', 'rules'   => 'required'),
			   //array('field'   => 'txtMobileNumberTravCntc', 'label'   => 'Mobile Number', 'rules'   => 'required'),
			   //array('field'   => 'txtFaxNumberTravCntc', 'label'   => 'Fax. Number', 'rules'   => 'required'),
			   //array('field'   => 'txtaddressTravCntc', 'label'   => 'Address', 'rules'   => 'required'),
			   //array('field'   => 'txtPostalCodeTravCntc', 'label'   => 'Postal Code', 'rules'   => 'required'),
			   //array('field'   => 'txtCntryCodeTravCntc', 'label'   => 'Country', 'rules'   => 'required'),
			   //array('field'   => 'txtCityCodeTravCntc', 'label'   => 'City', 'rules'   => 'required'),
			   //array('field'   => 'nationalityIdTravCntc', 'label'   => 'Nationality', 'rules'   => 'required'),
			   //array('field'   => 'nationalityCodeTravCntc', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
			   //array('field'   => 'txtArrivFlightNum', 'label'   => 'First Name', 'rules'   => 'required'),
			   //array('field'   => 'txtDepartFlightNum', 'label'   => 'First Name', 'rules'   => 'required'),
			   //array('field'   => 'txtArrivDate', 'label'   => 'First Name', 'rules'   => 'required'),
			   //array('field'   => 'txtDepartDate', 'label'   => 'First Name', 'rules'   => 'required'),
			  
			   //array('field'   => 'txtFrstNmeAdult[]', 'label'   => 'First Name', 'rules'   => 'required'),
			   //array('field'   => 'txtLstNmeAdult[]', 'label'   => 'Last Name', 'rules'   => 'required'),
			   //array('field'   => 'txtAgeAdult[]', 'label'   => 'Age', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtNmbrAdult[]', 'label'   => 'Passport Number', 'rules'   => 'required'),
			   //array('field'   => 'txtDobAdult[]', 'label'   => 'Day of Birth', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtExpryDteAdult[]', 'label'   => 'Passport Ewxpired Date', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtIssncCntryAdult[]', 'label'   => 'Passport Issuance Country', 'rules'   => 'required'),
			   //array('field'   => 'ntnlityIdAdult[]', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
			   //array('field'   => 'txtFrstNmeChild[]', 'label'   => 'First Name', 'rules'   => 'required'),
			   //array('field'   => 'txtLstNmeChild[]', 'label'   => 'Last Name', 'rules'   => 'required'),
			   //array('field'   => 'txtAgeChild[]', 'label'   => 'Age', 'rules'   => 'required'),
			  // array('field'   => 'txtPssprtNmbrChild[]', 'label'   => 'Passport Number', 'rules'   => 'required'),
			   //array('field'   => 'txtDobChild[]', 'label'   => 'Day Of Birth', 'rules'   => 'required'),
			   //array('field'   => 'txtPssprtExpryDteChild[]', 'label'   => 'Passport Expiry Date', 'rules'   => 'required'),
			  //array('field'   => 'txtPssprtIssnceCntryChild[]', 'label'   => 'Passport Issuance Country', 'rules'   => 'required'),
			   //array('field'   => 'ntnalityIdChild[]', 'label'   => 'Nationality', 'rules'   => 'required'),
			   
            );

		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			
			$data['tid'] = $tid; 
			$data['pid'] = $pid; 
			$data['pagecontent'] = 'user/form_booking_package_manual';
			$data['pagecontent'] = 'user/form_booking_package_manual';
			$this->load->vars($data);
			$this->load->view('template');
		}
		else
		{
/* ==========================================member & reseller booking start here========================================== */	
			if ($this->tank_auth->is_logged_in()){
				$userRoleID = $this->tank_auth->get_user_role_id();
				$userID = $this->tank_auth->get_user_id();
				$tid = $this->input->post('tid');	
				$pid = $this->input->post('pid');	
				$paymentMethod = $this->input->post('paymethod');	
				$isRadeem = $this->input->post('radeemMyPoint');
/* ======================================booking payment with credit card for member & reseller start here====================================== */		
				if($paymentMethod == 'MP0001'){
/* ===============================validate credit card to payment gateway provider start here============================= */	
				$resultCCvalid = $this->validate_creditCard();
/* ===============================validate credit card to payment gateway provider end here============================= */	
					if($resultCCvalid == TRUE){
/* =================================if credit card is valid start here=================================================== */
/* input activity search price start here */	
	
				$this->db->select('*');
				$this->db->from('book_packages');
				$this->db->where('transaction_code', $tid);
				$qrySlctBkng = $this->db->get();
				foreach($qrySlctBkng->result() as $rowsBkng){
					$bkngPckgId = $rowsBkng->API_packages_id;
					$adult = $rowsBkng->adult;
					$child = $rowsBkng->child;
					$currencyBkng = $rowsBkng->currency_code;
					$childBkngAges = $rowsBkng->child_ages;
					$travelDate = $rowsBkng->travel_date;
					$totAmount = $rowsBkng->total_amount;
					$transCode = $rowsBkng->transaction_code;
					$totSaleAmount = $rowsBkng->total_sale_price_amount;
					$usrID = $rowsBkng->user_id;
				}
				$actvtyID = $bkngPckgId;
				$adultPax = $adult;
				$childPax = $child;
				$travelDate = $travelDate;
				$crrncy = $currencyBkng;
				$childPaxAge = unserialize($childBkngAges);
				$adultLoopEnd = $adult - 1;
				$childLoopEnd = $child - 1; 
				$slctUsr = $this->db->get_where('users', array('users_id' => $usrID));
				foreach($slctUsr->result() as $rowUsr){
					$usrExstngPnt = $rowUsr->total_point;
				}
				$gainedPoint = $this->gained_point($totSaleAmount);
				$totGainedPoint = $usrExstngPnt + $gainedPoint;
		
		/* input activity search price end here */	
		
		
		
		$TL_ntnlty = explode('-',$nationalityTL);
		$TL_ntnltyId = $TL_ntnlty[0];
		$TL_ntnltyCode = $TL_ntnlty[1];
		
		/*$TC_ntnlty = explode('-',$nationalityCodeTC);
		$TC_ntnltyId = $TC_ntnlty[0];
		$TC_ntnltyCode = $TC_ntnlty[1];*/
		
		
			/* save data booking and traveler to database start here */	                                                                                                                                                              
			$travContactInfoNew = array(
										  'transaction_code' => $transCode,
										  'API_packages_id' => $bkngActivityID ,
										  'isLeader' => '0',
										  'isContact' => '1',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTC,
										  'first_name' => $firstNameTC,
										  'last_name' => $lastNameTC,
										  'email' => $emailTC,
										  'contact_number' => $phoneNumberTC,
										);	
			$this->db->insert('traveler_info', $travContactInfoNew); 
			$travLeaderInfoNew = array(
										  'transaction_code' => $transCode,
										  'API_packages_id' => $bkngActivityID ,
										  'isLeader' => '1',
										  'isContact' => '0',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTL,
										  'first_name' => $firstNameTL,
										  'last_name' => $lastNameTL,
										  'traveler_type' => '32',
										  'age' => $ageTL,
										  'dob' => $dayOfBirthTL,
										  'passport_expired_date' => $passportExpiredDateTL,
										  'nationality_id' => $TL_ntnltyId,
										);	
			  $this->db->insert('traveler_info', $travLeaderInfoNew); 
			  
			  for($i=1;$i <= $adultLoopEnd;$i++){
			  $j= $i - 1;
			  	$adltNtnlty = explode('-',$adultNationality[$j]);
				$adltNtnltyId = $adltNtnlty[0];
				$adltNtnltyCode = $adltNtnlty[1];
						$adultInfoNew = array(
											  'transaction_code' => $transCode,
											  'API_packages_id' => $bkngActivityID ,
											  'isLeader' => '0',
											  'isContact' => '0',
											  'isAdult' => '1',
											  'isChild' => '0',
											  'title' => $salutationTL,//$adultSalutation[$j],
											  'first_name' => $firstNameTL,//$adultFirstName[$j],
											  'last_name' => $lastNameTL,//$adultLastName[$j],
											  'traveler_type' => '32', //$adultTravelerType[$j],
											  'age' => $ageTL,//$adultAge[$j],
											  'dob' => $dayOfBirthTL,//$adultDOB[$j],
											  'passport_expired_date' => $passportExpiredDateTL,//$adultPassportExpiredDate[$j],
											);	
						
						$this->db->insert('traveler_info', $adultInfoNew); 
			  }	
			 	if(!empty($child)){
					for($i=1;$i <= $child;$i++){
					$j = $i-1;
					$chldNtnlty = explode('-',$childNationality[$j]);
					$chldNtnltyId = $chldNtnlty[0];
					$chldNtnltyCode = $chldNtnlty[1];
							$childInfoNew = array(
												  'transaction_code' => $transCode,
												  'API_packages_id' => $bkngActivityID ,
												  'isLeader' => '0',
												  'isContact' => '0',
												  'isAdult' => '0',
												  'isChild' => '1',
												  'title' => $childSalutation[$j],
												  'first_name' => $childFirstName[$j],
												  'last_name' => $childLastName[$j],
												  'traveler_type' => $childTravelerType[$j],
												  'age' => $childAge[$j],
												  'dob' => $childDOB[$j],
												  'passport_expired_date' => $childPassportExpiredDate[$j],
												);	
							
							$this->db->insert('traveler_info', $childInfoNew); 
					}	
			 	}
				
				if($isRadeem == '1'){
					$qrySlctUsrPnt = $this->db->get_where('users', array('users_id' => $usrID));
					foreach($qrySlctUsrPnt->result() as $rowUsr){
						$usrTotPnt = $rowUsr->total_point;
						$userRoleID = $rowUsr->role_id;
					}
					if($userRoleID == '2'){
						$MinimalBeli = $this->finance->get_point(13);	
						$NominalBeli = $this->finance->get_point(14);
						$PointBeli = $this->finance->get_point(15);
						$MinimalPoint = $this->finance->get_point(16);
						$PointTukar = $this->finance->get_point(17);
						$NominalBayar = $this->finance->get_point(18);
					}
					elseif($userRoleID == '3'){
						$MinimalBeli = $this->finance->get_point(19);
						$NominalBeli = $this->finance->get_point(20);
						$PointBeli = $this->finance->get_point(21);
						$MinimalPoint = $this->finance->get_point(22);
						$PointTukar = $this->finance->get_point(23);
						$NominalBayar = $this->finance->get_point(24);
					}
					$this->db->select('*');
					$this->db->from('currencies');
					$this->db->where('currency_from', 'SGD');
					$this->db->where('country_iso_from', 'SG');
					$this->db->where('currency_to', 'IDR');
					$this->db->where('country_iso_to', 'ID');
					$rateValCurr = $this->db->get();
					foreach($rateValCurr->result() as $rowRateFld){
						$valIdrRate = $rowRateFld->konversi;
						
					}
					
					$nilNomPerPoint_inSGD = $NominalBayar / $valIdrRate;
					$pntNomValue_inSGD = $usrTotPnt * $nilNomPerPoint_inSGD; 
					$gainedPntToNomValue_inSGD = round($gainedPoint * $nilNomPerPoint_inSGD, 2);
					$usrFnlPnt = round($totGainedPoint - $gainedPoint, 2);	
					$totAmountFnal = round($totSaleAmount - $gainedPntToNomValue_inSGD, 2); 
					
					$myConfirmNmbr = 'VTK'.date('YmdHis');
					$voucher_url = base_url().'index.php/voucher/cetak/tc/'.$transCode;
					$dataUpdt = array(
						   'book_step' => '2',
						   'payment_method' => $paymentMethod,
						   'pickup_dropoff' => $pickupDropoff,
						   'validated' => "1",
						   'api_booking_status' => '1',
						   'api_confirmation_number' => $myConfirmNmbr,
						   'voucher_url' => $voucher_url,
						   'point_transaction' => $gainedPoint,
						   'isRadeemPoint' => '1',
						   'pointRadeem' => $gainedPoint,
						   'pointRadeem_value' => $gainedPntToNomValue_inSGD,
						   
						);
						
						$this->db->where('transaction_code', $tid);
						$this->db->update('book_packages', $dataUpdt); 
						$fnlUsrPnt = $totGainedPoint - $gainedPoint;
						$dtUpdtUsr = array('total_point' => $fnlUsrPnt);
						$this->db->where('users_id', $usrID);
						$this->db->update('users', $dtUpdtUsr); 
						$this->sending_email_confirm_payByCC_pckgeMnl($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL,$voucher_url);
						$data['pagecontent'] = "user/booking_success";
						$this->load->vars($data);
						$this->load->view('template');
					
				}
				else{
						$myConfirmNmbr = 'VTK'.date('YmdHis');
						$dataUpdt = array(
								   'book_step' => '2',
								   'payment_method' => $paymentMethod,
								   //'arrive_flight_number' => $arrivalFlightNumber,
								   //'departure_flight_number' => $departFlightNumber,
								   //'arrive_flight_date' => $arrivalDate,
								  // 'departure_flight_date' => $departDate,
								  // 'pickup_dropoff' => $pickupDropoff,
								   'validated' => '1',
								   'api_booking_status' => '1',
								   'api_confirmation_number' => $myConfirmNmbr,
								   //'voucher_url' => htmlspecialchars_decode($voucherUrl)
								   //'visual_id' => "$visID",
								   //'visual_id_expiry' => "$visIDExpiry"
							);
						$this->db->where('transaction_code', $tid);
						$this->db->update('book_packages', $dataUpdt); 
						
						$dtUpdtUsr = array('total_point' => $totGainedPoint);
						$this->db->where('users_id', $usrID);
						$this->db->update('users', $dtUpdtUsr); 
						$this->sending_email_confirm_payByCC_pckgeMnl($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL,$voucher_url);
						$data['pagecontent'] = "user/booking_success";
						$this->load->vars($data);
						$this->load->view('template');
				}
	          
	
/* =================================if credit card is valid end here =================================================== */						
					}
					else{
/* ============================if credit card not valid start here========================================= */	
						$this->session->set_flashdata('flashMsge', 'Your credit card is not valid !');
						redirect('transaction/booking_form2', 'refresh');					
/* ============================if credit card not valid end here=========================================== */
					}				
				}	
/* ======================================booking payment with credit card for member & reseller end here======================================== */	


 
 /* =====================================booking payment with bank transfer for member & reseller start here==================================== */
				else
				{
					$this->db->select('*');
					$this->db->from('book_packages');
					$this->db->where('transaction_code', $tid);
					$qrySlctBkng = $this->db->get();
					foreach($qrySlctBkng->result() as $rowsBkng){
						$bkngPckgId = $rowsBkng->API_packages_id;
						$transCode = $rowsBkng->transaction_code;
						$adult = $rowsBkng->adult;
						$child = $rowsBkng->child;
						$currencyBkng = $rowsBkng->currency_code;
						$childBkngAges = $rowsBkng->child_ages;
						$travelDate = $rowsBkng->travel_date;
						$totAmount = $rowsBkng->total_amount;
						$transCode = $rowsBkng->transaction_code;
						$bkngUSID = $rowsBkng->usid;
						$totSaleAmount = $rowsBkng->total_sale_price_amount;
						$usrID = $rowsBkng->user_id;
					}
					$slctUsr = $this->db->get_where('users', array('users_id' => $usrID));
					foreach($slctUsr->result() as $rowUsr){
						$usrExstngPnt = $rowUsr->total_point;
					}
					$gainedPoint = $this->gained_point($totSaleAmount);
					$totGainedPoint = $usrExstngPnt + $gainedPoint;
					
					$TL_ntnlty = explode('-',$nationalityTL);
					$TL_ntnltyId = $TL_ntnlty[0];
					$TL_ntnltyCode = $TL_ntnlty[1];
					
					/*$TC_ntnlty = explode('-',$nationalityCodeTC);
					$TC_ntnltyId = $TC_ntnlty[0];
					$TC_ntnltyCode = $TC_ntnlty[1];*/
					
					$adultLoopEnd = $adult - 1;
					$childLoopEnd = $child - 1; 
					
					$travContactInfoNew = array(
										  'transaction_code' => $transCode,
										  //'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngPckgId,
										  'isLeader' => '0',
										  'isContact' => '1',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTC,
										  'first_name' => $firstNameTC,
										  'last_name' => $lastNameTC,
										  'email' => $emailTC,
										  //'alternate_email' => $alternateEmailTC,
										  'contact_number' => $phoneNumberTC,
										  //'mobile_number' => $mobileNumberTC,
										  //'fax_number' =>  $faxNumberTC,
										  //'address' => $addressTC,
										  //'postal_code' => $postalCodeTC,
										  //'country_code' => $countryTC,
										  //'city_code' => $cityTC,
										  //'nationality_id' => $TC_ntnltyId,
										  //'nationality_code' => $TC_ntnltyCode
										   
										);	
					$this->db->insert('traveler_info', $travContactInfoNew); 
					$travLeaderInfoNew = array(
										  'transaction_code' => $transCode,
										  //'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngPckgId ,
										  'isLeader' => '1',
										  'isContact' => '0',
										  'isAdult' => '1',
										  'isChild' => '0',
										  'title' => $salutationTL,
										  'first_name' => $firstNameTL,
										  'last_name' => $lastNameTL,
										  'traveler_type' => '32',
										  'age' => $ageTL,
										  //'passport_number' => $passportNumberTL,
										  'dob' => $dayOfBirthTL,
										  'passport_expired_date' => $passportExpiredDateTL,
										  //'passport_issuance_country' =>  $passportIssuanceCountryTL,
										  //'nationality_code' => $TL_ntnltyCode,
										  'nationality_id' => $TL_ntnltyId,
												);	
					  $this->db->insert('traveler_info', $travLeaderInfoNew); 
					  
					  for($i=1;$i <= $adultLoopEnd;$i++){
					  $j= $i - 1;
						$adltNtnlty = explode('-',$adultNationality[$j]);
						$adltNtnltyId = $adltNtnlty[0];
						$adltNtnltyCode = $adltNtnlty[1];
								$adultInfoNew = array(
											  'transaction_code' => $transCode,
											  //'usid' => "$bkngUSID",
											  'API_packages_id' => $bkngPckgId ,
											  'isLeader' => '0',
											  'isContact' => '0',
											  'isAdult' => '1',
											  'isChild' => '0',
											  'title' => $salutationTL,//$adultSalutation[$j],
											  'first_name' => $firstNameTL,//$adultFirstName[$j],
											  'last_name' => $lastNameTL,//$adultLastName[$j],
											  'traveler_type' => '32',//$adultTravelerType[$j],
											  'age' => $ageTL,//$adultAge[$j],
											  //'passport_number' => $adultPassportNumber[$j],
											  'dob' => $dayOfBirthTL,//$adultDOB[$j],
											  'passport_expired_date' => $passportExpiredDateTL,//$adultPassportExpiredDate[$j],
											  //'passport_issuance_country' =>  $adultPassportIssuanceCountry[$j],
											  //'nationality_code' => $adltNtnltyCode,
											  //'nationality_id' => $TL_ntnltyId,//$adltNtnltyId,
											);	
						
								$this->db->insert('traveler_info', $adultInfoNew); 
					  }	
					  if(!empty($child)){
						 	for($i=1;$i <= $child;$i++){
						 	$j = $i-1;
							$chldNtnlty = explode('-',$childNationality[$j]);
							$chldNtnltyId = $chldNtnlty[0];
							$chldNtnltyCode = $chldNtnlty[1];
									$childInfoNew = array(
												  'transaction_code' => $transCode,
												  //'usid' => "$bkngUSID",
												  'API_packages_id' => $bkngPckgId ,
												  'isLeader' => '0',
												  'isContact' => '0',
												  'isAdult' => '0',
												  'isChild' => '1',
												  'title' => $childSalutation[$j],
												  'first_name' => $childFirstName[$j],
												  'last_name' => $childLastName[$j],
												  'traveler_type' => $childTravelerType[$j],
												  'age' => $childAge[$j],
												  //'passport_number' => $childPassportNumber[$j],
												  'dob' => $childDOB[$j],
												  'passport_expired_date' => $childPassportExpiredDate[$j],
												  //'passport_issuance_country' =>  $childPassportIssuanceCountry[$j],
												  //'nationality_code' => $chldNtnltyCode,
												  //'nationality_id' => $chldNtnltyId,
												);	
							
							$this->db->insert('traveler_info', $childInfoNew); 
							}	
			 			}
						
						if($isRadeem == 1){
							$qrySlctUsrPnt = $this->db->get_where('users', array('users_id' => $usrID));
							foreach($qrySlctUsrPnt->result() as $rowUsr){
								$usrTotPnt = $rowUsr->total_point;
								$userRoleID = $rowUsr->role_id;
							}
							if($userRoleID == '2'){
								$MinimalBeli = $this->finance->get_point(13);	
								$NominalBeli = $this->finance->get_point(14);
								$PointBeli = $this->finance->get_point(15);
								$MinimalPoint = $this->finance->get_point(16);
								$PointTukar = $this->finance->get_point(17);
								$NominalBayar = $this->finance->get_point(18);
							}
							elseif($userRoleID == '3'){
								$MinimalBeli = $this->finance->get_point(19);
								$NominalBeli = $this->finance->get_point(20);
								$PointBeli = $this->finance->get_point(21);
								$MinimalPoint = $this->finance->get_point(22);
								$PointTukar = $this->finance->get_point(23);
								$NominalBayar = $this->finance->get_point(24);
							}
							$this->db->select('*');
							$this->db->from('currencies');
							$this->db->where('currency_from', 'SGD');
							$this->db->where('country_iso_from', 'SG');
							$this->db->where('currency_to', 'IDR');
							$this->db->where('country_iso_to', 'ID');
							$rateValCurr = $this->db->get();
							foreach($rateValCurr->result() as $rowRateFld){
								$valIdrRate = $rowRateFld->konversi;
								
							}
							$nilNomPerPoint_inSGD = $NominalBayar / $valIdrRate;
							$pntNomValue_inSGD = round($usrTotPnt * $nilNomPerPoint_inSGD, 2); 
							$nilTotNom_toPoint = round($totSaleAmount / $nilNomPerPoint_inSGD, 2);
												
							$radeemedPoint = round($usrTotPnt - $nilTotNom_toPoint, 2);
							$usrLastPnt = round($usrTotPnt - $radeemedPoint, 2);
							$dataUpdt = array(
								  'book_step' => '2',
								   'payment_method' => $paymentMethod,
								   //'arrive_flight_number' => $arrivalFlightNumber,
								   //'departure_flight_number' => $departFlightNumber,
								   //'arrive_flight_date' => $arrivalDate,
								   //'departure_flight_date' => $departDate,
								   //'pickup_dropoff' => $pickupDropoff,
								   'validated' => "0",
								   'booking_expiry' => $bkngVldUntl,
								   'pending_point' => $gainedPoint,
								   'isRadeemPoint' => '1',
								   'pointRadeem' => $radeemedPoint,
								   'pointRadeem_value' => $gainedPntToNomValue_inSGD,
								   'point_transaction' => $gainedPoint
								  
								);
								$this->db->where('transaction_code', $tid);
								$this->db->update('book_packages', $dataUpdt); 
								
								$fnlUsrPnt = $totGainedPoint - $gainedPoint;
								$dtUpdtUsr = array('total_point' => $fnlUsrPnt);
								$this->db->where('users_id', $usrID);
								$this->db->update('users', $dtUpdtUsr); 
								
								$this->sending_email_confirm_payByCC_pckgeMnl($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL,$voucherUrl);
								$data['pagecontent'] = "user/booking_success";
								$this->load->vars($data);
								$this->load->view('template');
						
						}
						else{
							date_default_timezone_set('Asia/Jakarta');
							$bkngVldUntl = date('Y-m-d H:i:s', strtotime('+6 hours'));
						  	$dataUpdt = array(
								   'book_step' => '2',
								   'payment_method' => $paymentMethod,
								   //'arrive_flight_number' => $arrivalFlightNumber,
								   //'departure_flight_number' => $departFlightNumber,
								   //'arrive_flight_date' => $arrivalDate,
								   //'departure_flight_date' => $departDate,
								   //'pickup_dropoff' => $pickupDropoff,
								   'validated' => "0",
								   'booking_expiry' => $bkngVldUntl,
								   'pending_point' => $gainedPoint
								  
							);
							$this->db->where('transaction_code', $tid);
							$this->db->update('book_packages', $dataUpdt); 
							$this->sending_email_confirm_payByBT($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL);
							$data['pagecontent'] = "user/booking_success";
				 			$this->load->vars($data);
				 			$this->load->view('template');
						}
						
						
				}
/* =====================================booking payment with bank transfer for member & reseller end here==================================== */
			}
/* ==========================================member & reseller booking end here========================================== */			

/* ==========================================guest booking start here======================================================= */	
			else{
				$tid = $this->input->post('tid');	
				$pid = $this->input->post('pid');	
				$paymentMethod = $this->input->post('paymethod');	
				$isRadeem = $this->input->post('radeemMyPoint');
/* ======================================booking payment with credit card for guest start here====================================== */		
				if($paymentMethod == 'MP0001'){
/* ===============================validate credit card to payment gateway provider start here============================= */	
				$resultCCvalid = $this->validate_creditCard();
/* ===============================validate credit card to payment gateway provider end here============================= */	
					if($resultCCvalid == TRUE){
/* =================================if credit card is valid start here=================================================== */
/* input activity search price start here */	
	
				$this->db->select('*');
				$this->db->from('book_packages');
				$this->db->where('transaction_code', $tid);
				$qrySlctBkng = $this->db->get();
				foreach($qrySlctBkng->result() as $rowsBkng){
					$bkngPckgId = $rowsBkng->API_packages_id;
					$adult = $rowsBkng->adult;
					$child = $rowsBkng->child;
					$currencyBkng = $rowsBkng->currency_code;
					$childBkngAges = $rowsBkng->child_ages;
					$travelDate = $rowsBkng->travel_date;
					$totAmount = $rowsBkng->total_amount;
					$transCode = $rowsBkng->transaction_code;
				}
				$actvtyID = $bkngPckgId;
				$adultPax = $adult;
				$childPax = $child;
				$travelDate = $travelDate;
				$crrncy = $currencyBkng;
				$childPaxAge = unserialize($childBkngAges);
				$adultLoopEnd = $adult - 1;
				$childLoopEnd = $child - 1; 
		
		/* input activity search price end here */	
			
		
		$TL_ntnlty = explode('-',$nationalityTL);
		$TL_ntnltyId = $TL_ntnlty[0];
		$TL_ntnltyCode = $TL_ntnlty[1];
		
		//$TC_ntnlty = explode('-',$nationalityCodeTC);
		//$TC_ntnltyId = $TC_ntnlty[0];
		//$TC_ntnltyCode = $TC_ntnlty[1];
		
		
			/* save data booking and traveler to database start here */	                                                                                                                                                              
			$travContactInfoNew = array(
										  'transaction_code' => $transCode,
										 //'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngPckgId ,
										  'isLeader' => '0',
										  'isContact' => '1',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTC,
										  'first_name' => $firstNameTC,
										  'last_name' => $lastNameTC,
										  'email' => $emailTC,
										  //'alternate_email' => $alternateEmailTC,
										  'contact_number' => $phoneNumberTC,
										  //'mobile_number' => $mobileNumberTC,
										  //'fax_number' =>  $faxNumberTC,
										  //'address' => $addressTC,
										  //'postal_code' => $postalCodeTC,
										  //'country_code' => $countryTC,
										  //'city_code' => $cityTC,
										  //'nationality_id' => $TC_ntnltyId,
										  //'nationality_code' => $TC_ntnltyCode
										   
										);	
			$this->db->insert('traveler_info', $travContactInfoNew); 
			$travLeaderInfoNew = array(
										  'transaction_code' => $transCode,
										  //'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngPckgId ,
										  'isLeader' => '1',
										  'isContact' => '0',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTL,
										  'first_name' => $firstNameTL,
										  'last_name' => $lastNameTL,
										  'traveler_type' => '32',
										  'age' => $ageTL,
										  //'passport_number' => $passportNumberTL,
										  'dob' => $dayOfBirthTL,
										  'passport_expired_date' => $passportExpiredDateTL,
										  //'passport_issuance_country' =>  $passportIssuanceCountryTL,
										  //'nationality_code' => $TL_ntnltyCode,
										  'nationality_id' => $TL_ntnltyId,
										);	
			  $this->db->insert('traveler_info', $travLeaderInfoNew); 
			  
			  for($i=1;$i <= $adultLoopEnd;$i++){
			  $j= $i - 1;
			  	//$adltNtnlty = explode('-',$adultNationality[$j]);
				//$adltNtnltyId = $adltNtnlty[0];
				//$adltNtnltyCode = $adltNtnlty[1];
						$adultInfoNew = array(
											  'transaction_code' => $transCode,
											  //'usid' => "$bkngUSID",
											  'API_packages_id' => $bkngPckgId ,
											  'isLeader' => '0',
											  'isContact' => '0',
											  'isAdult' => '1',
											  'isChild' => '0',
											  'title' => $salutationTL,//$adultSalutation[$j],
											  'first_name' => $firstNameTL,//$adultFirstName[$j],
											  'last_name' => $lastNameTL,//$adultLastName[$j],
											  'traveler_type' => '32',//$adultTravelerType[$j],
											  'age' => $ageTL,//$adultAge[$j],
											  //'passport_number' => $adultPassportNumber[$j],
											  'dob' => $dayOfBirthTL,//$adultDOB[$j],
											  'passport_expired_date' => $passportExpiredDateTL,//$adultPassportExpiredDate[$j],
											  //'passport_issuance_country' =>  $adultPassportIssuanceCountry[$j],
											  //'nationality_code' => $adltNtnltyCode,
											  //'nationality_id' => $adltNtnltyId,
											);	
						
						$this->db->insert('traveler_info', $adultInfoNew); 
			  }	
			 	if(!empty($child)){
					for($i=1;$i <= $child;$i++){
					$j = $i-1;
					//$chldNtnlty = explode('-',$childNationality[$j]);
					//$chldNtnltyId = $chldNtnlty[0];
					//$chldNtnltyCode = $chldNtnlty[1];
							$childInfoNew = array(
												  'transaction_code' => $transCode,
												  //'usid' => "$bkngUSID",
												  'API_packages_id' => $bkngPckgId ,
												  'isLeader' => '0',
												  'isContact' => '0',
												  'isAdult' => '0',
												  'isChild' => '1',
												  'title' => $childSalutation[$j],
												  'first_name' => $childFirstName[$j],
												  'last_name' => $childLastName[$j],
												  'traveler_type' => $childTravelerType[$j],
												  'age' => $childAge[$j],
												  //'passport_number' => $childPassportNumber[$j],
												  'dob' => $childDOB[$j],
												  'passport_expired_date' => $childPassportExpiredDate[$j],
												  //'passport_issuance_country' =>  $childPassportIssuanceCountry[$j],
												  //'nationality_code' => $chldNtnltyCode,
												  //'nationality_id' => $chldNtnltyId,
												);	
							
							$this->db->insert('traveler_info', $childInfoNew); 
					}	
			 	}
			  $myConfirmNmbr = 'VTK'.date('YmdHis');
			  $voucher_url = base_url().'index.php/voucher/cetak/tc/'.$transCode;
	          $dataUpdt = array(
               'book_step' => '2',
               'payment_method' => $paymentMethod,
               //'arrive_flight_number' => $arrivalFlightNumber,
               //'departure_flight_number' => $departFlightNumber,
               //'arrive_flight_date' => $arrivalDate,
               //'departure_flight_date' => $departDate,
               //'pickup_dropoff' => $pickupDropoff,
               'validated' => "1",
               'api_booking_status' => $myConfirmNmbr,
               'api_confirmation_number' => $myConfirmNmbr,
               'voucher_url' => $voucher_url,
               //'visual_id' => "$visID",
               //'visual_id_expiry' => "$visIDExpiry"
            );
			$this->db->where('transaction_code', $tid);
			$this->db->update('book_packages', $dataUpdt); 
			/* save data booking and traveler to database end here */	
			$this->sending_email_confirm_payByCC_pckgeMnl($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL,$voucher_url);
			/*
		     echo "<b>USID : </b>".$itemBooking->USID.'<br />';
			 echo "<b>ActivityID : </b>".$itemBooking->ActivityID.'<br />';
			 echo "<b>BookingStatus : </b>".$itemBooking->BookingStatus.'<br />';
			 echo "<b>ConfirmationNumber : </b>".$itemBooking->ConfirmationNumber.'<br />';
			 echo "<b>Currency : </b>".$itemBooking->Currency.'<br />';
			 echo "<b>TotalPrice : </b>".$itemBooking->TotalPrice.'<br />';
			 echo "<b>Visual ID : </b>".$visID.'<br />';
			echo "<b>Visual ID Expiry : </b>".$visIDExpiry.'<br />';
			*/
			//$this->session->unset_userdata('bookingUSID');
			 $data['pagecontent'] = "user/booking_success";
			 $this->load->vars($data);
			 $this->load->view('template');
		
		
 /* =================================if credit card is valid end here =================================================== */						
					}
					else{
/* ============================if credit card not valid start here========================================= */	
						$this->session->set_flashdata('flashMsge', 'Your credit card is not valid !');
						redirect('transaction/booking_form2', 'refresh');					
/* ============================if credit card not valid end here=========================================== */
					}				
				}	
/* ======================================booking payment with credit card for guest end here======================================== */	
/* =====================================booking payment with bank transfer for guest start here==================================== */
				else
				{
					$this->db->select('*');
					$this->db->from('book_packages');
					$this->db->where('transaction_code', $tid);
					$qrySlctBkng = $this->db->get();
					foreach($qrySlctBkng->result() as $rowsBkng){
						$bkngPckgId = $rowsBkng->API_packages_id;
						$transCode = $rowsBkng->transaction_code;
						$adult = $rowsBkng->adult;
						$child = $rowsBkng->child;
						$currencyBkng = $rowsBkng->currency_code;
						$childBkngAges = $rowsBkng->child_ages;
						$travelDate = $rowsBkng->travel_date;
						$totAmount = $rowsBkng->total_amount;
						$transCode = $rowsBkng->transaction_code;
						$bkngUSID = $rowsBkng->usid;
					}
					$TL_ntnlty = explode('-',$nationalityTL);
					$TL_ntnltyId = $TL_ntnlty[0];
					$TL_ntnltyCode = $TL_ntnlty[1];
					
					/*$TC_ntnlty = explode('-',$nationalityCodeTC);
					$TC_ntnltyId = $TC_ntnlty[0];
					$TC_ntnltyCode = $TC_ntnlty[1];*/
					
					$adultLoopEnd = $adult - 1;
					$childLoopEnd = $child - 1; 
					
					$travContactInfoNew = array(
										  'transaction_code' => $transCode,
										  //'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngPckgId,
										  'isLeader' => '0',
										  'isContact' => '1',
										  'isAdult' => '0',
										  'isChild' => '0',
										  'title' => $salutationTC,
										  'first_name' => $firstNameTC,
										  'last_name' => $lastNameTC,
										  'email' => $emailTC,
										  //'alternate_email' => $alternateEmailTC,
										  'contact_number' => $phoneNumberTC,
										  //'mobile_number' => $mobileNumberTC,
										  //'fax_number' =>  $faxNumberTC,
										  //'address' => $addressTC,
										  //'postal_code' => $postalCodeTC,
										 // 'country_code' => $countryTC,
										 // 'city_code' => $cityTC,
										  'nationality_id' => $TC_ntnltyId,
										  //'nationality_code' => $TC_ntnltyCode
										   
										);	
					$this->db->insert('traveler_info', $travContactInfoNew); 
					$travLeaderInfoNew = array(
										  'transaction_code' => $transCode,
										  //'usid' => "$bkngUSID",
										  'API_packages_id' => $bkngPckgId ,
										  'isLeader' => '1',
										  'isContact' => '0',
										  'isAdult' => '1',
										  'isChild' => '0',
										  'title' => $salutationTL,
										  'first_name' => $firstNameTL,
										  'last_name' => $lastNameTL,
										  'traveler_type' => '32',
										  'age' => $ageTL,
										  //'passport_number' => $passportNumberTL,
										  'dob' => $dayOfBirthTL,
										  'passport_expired_date' => $passportExpiredDateTL,
										  //'passport_issuance_country' =>  $passportIssuanceCountryTL,
										  //'nationality_code' => $TL_ntnltyCode,
										  'nationality_id' => $TL_ntnltyId,
												);	
					  $this->db->insert('traveler_info', $travLeaderInfoNew); 
					  
					  for($i=1;$i <= $adultLoopEnd;$i++){
					  $j= $i - 1;
						$adltNtnlty = explode('-',$adultNationality[$j]);
						$adltNtnltyId = $adltNtnlty[0];
						$adltNtnltyCode = $adltNtnlty[1];
								$adultInfoNew = array(
											  'transaction_code' => $transCode,
											  //'usid' => "$bkngUSID",
											  'API_packages_id' => $bkngPckgId ,
											  'isLeader' => '0',
											  'isContact' => '0',
											  'isAdult' => '1',
											  'isChild' => '0',
											  'title' => $salutationTL,//$adultSalutation[$j],
											  'first_name' => $firstNameTL,//$adultFirstName[$j],
											  'last_name' => $lastNameTL,//$adultLastName[$j],
											  'traveler_type' => '32',//$adultTravelerType[$j],
											  'age' => $ageTL,//$adultAge[$j],
											  //'passport_number' => $adultPassportNumber[$j],
											  'dob' => $dayOfBirthTL,//$adultDOB[$j],
											  'passport_expired_date' => $passportExpiredDateTL,//$adultPassportExpiredDate[$j],
											  //'passport_issuance_country' =>  $adultPassportIssuanceCountry[$j],
											  //'nationality_code' => $adltNtnltyCode,
											  'nationality_id' => $TL_ntnltyId//$adltNtnltyId,
											);	
						
								$this->db->insert('traveler_info', $adultInfoNew); 
					  }	
					  if(!empty($child)){
						 	for($i=1;$i <= $child;$i++){
						 	$j = $i-1;
							$chldNtnlty = explode('-',$childNationality[$j]);
							$chldNtnltyId = $chldNtnlty[0];
							$chldNtnltyCode = $chldNtnlty[1];
									$childInfoNew = array(
												  'transaction_code' => $transCode,
												  //'usid' => "$bkngUSID",
												  'API_packages_id' => $bkngPckgId ,
												  'isLeader' => '0',
												  'isContact' => '0',
												  'isAdult' => '0',
												  'isChild' => '1',
												  'title' => $childSalutation[$j],
												  'first_name' => $childFirstName[$j],
												  'last_name' => $childLastName[$j],
												  'traveler_type' => $childTravelerType[$j],
												  'age' => $childAge[$j],
												  //'passport_number' => $childPassportNumber[$j],
												  'dob' => $childDOB[$j],
												  'passport_expired_date' => $childPassportExpiredDate[$j],
												  //'passport_issuance_country' =>  $childPassportIssuanceCountry[$j],
												  //'nationality_code' => $chldNtnltyCode,
												  //'nationality_id' => $chldNtnltyId,
												);	
							
							$this->db->insert('traveler_info', $childInfoNew); 
							}	
			 			}
						
						date_default_timezone_set('Asia/Jakarta');
						$bkngVldUntl = date('Y-m-d H:i:s', strtotime('+6 hours'));
						
					  	$dataUpdt = array(
							   'book_step' => '2',
							   'payment_method' => $paymentMethod,
							   //'arrive_flight_number' => $arrivalFlightNumber,
							   //'departure_flight_number' => $departFlightNumber,
							   //'arrive_flight_date' => $arrivalDate,
							  // 'departure_flight_date' => $departDate,
							   //'pickup_dropoff' => $pickupDropoff,
							   'validated' => "0",
							   'booking_expiry' => $bkngVldUntl
							  
						);
						$this->db->where('transaction_code', $tid);
						$this->db->update('book_packages', $dataUpdt); 
					$this->sending_email_confirm_payByBT($transCode,$emailTC,$salutationTL,$firstNameTL,$lastNameTL);
					$data['pagecontent'] = "user/booking_success";
			 		$this->load->vars($data);
			 		$this->load->view('template');
				}
/* =====================================booking payment with bank transfer for guest end here==================================== */		
			}	
/* ==========================================guest booking end here======================================================= */		
		}
}

/* ==========================booking processing request for package manual input end here============================= */

	function check_isEnough_user_balance($userID, $totAmnt_inIDR){
		$crrntBlnc = $this->booking_model->check_isEnough_balance_byUSID($userID);
		if($crrntBlnc < $totAmnt_inIDR){
			return false;
		}
		else{
			return true;
		}
	}
	
	function get_user_deposit_code($userID){
			$this->db->select('*');
			$this->db->from('reseller_profile');
			$this->db->join('deposit', 'deposit.id=reseller_profile.id');
			$this->db->where('reseller_profile.users_id', $userID);
			$qry = $this->db->get();
			foreach($qry->result() as $row){
				$depositCode = $row->deposit_no;
			}
			return $depositCode;
	}
	function get_current_balance($userID){
		$this->db->select('*');
		$this->db->from('reseller_profile');
		$this->db->join('deposit', 'deposit.id=reseller_profile.id');
		$this->db->where('reseller_profile.users_id', $userID);
		$qry = $this->db->get();
		foreach($qry->result() as $row){
			$balance = $row->nominal;
		}
		return $balance;
	}
	function update_deposit_nominal($depositCode, $newValDeposit){
		$qry = $this->db->get_where('deposit', array('deposit_no'=>$depositCode));
		foreach($qry->result() as $row){
			$crrntNmnl = $row->nominal;
		}
		
		$dt = array('nominal'=>$newValDeposit);
		$this->db->where('deposit_no', $depositCode);
		$this->db->update('deposit', $dt);
	}

}
