<?php
class ajaxHandler extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		//$this->load->model('APIhandler_model');
		$this->load->library('session');
		$this->load->helper(array('form','url','html'));
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->model('finance');
		$this->load->model('errorlog_model');
	}
	function amountWithRadeem(){
	echo 'bla....bla...';
	/*
		if ($this->tank_auth->is_logged_in()) {	
		$userRoleID = $this->tank_auth->get_user_role_id();
		$userID = $this->tank_auth->get_user_id();
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('users_id', $userID);
		$this->db->where('role_id', $userRoleID);
		$qryUsr = $this->db->get();
			foreach($qryUsr->result() as $fldUsr){
				$usrRoleId = $fldUsr->role_id;
				$usrPoint = $fldUsr->total_point;
				$this->db->select('*');
				$this->db->from('adm_transfer');
				$this->db->where('jenis_tr', $usrRoleId);
				$result = $this->db->get();
				$return = array();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row) {
						$return[$row['keterangan']] = $row['content'];
					}
					if($usrRoleId == '2'){
					
						$MinimalBeli = $return['MinimalBeli'];	
						$NominalBeli = $return['NominalBeli'];
						$PointBeli = $return['PointBeli'];
						$MinimalPoint = $return['MinimalPoint'];
						$PointTukar = $return['PointTukar'];
						$NominalBayar = $return['NominalBayar'];
					}
					elseif($usrRoleId == '3'){
					
						$MinimalBeli = $return['MinimalBeliReseller'];
						$NominalBeli = $return['NominalBeliReseller'];
						$PointBeli = $return['PointBeliReseller'];
						$MinimalPoint = $return['MinimalPointReseller'];
						$PointTukar = $return['PointTukarReseller'];
						$NominalBayar = $return['NominalBayarReseller'];
					}
									
				}
				if($usrPoint >= $MinimalPoint){
					$pointToRadeem = $usrPoint; 
					$pointValue = $usrPoint * $NominalBayar; 
				
					$this->db->select('*');
					$this->db->from('currencies');
					$this->db->where('currency', 'IDR');
					$this->db->where('country_iso', 'ID');
					$rateValCurr = $this->db->get();
					foreach($rateValCurr->result() as $rowRateFld){
						$valIdrRate = $rowRateFld->konversi;
					}
					$rateIdrToSgd = round($pointValue / $valIdrRate, 2);   
				}
			}
			$trnsctnCode = $this->input->post('tc');
			$chckdStts = $this->input->post('cs');
			$splitCode = explode("-", $trnsctnCode);
			$scrtCode = $splitCode[1];
			$cdTrnsctn = $splitCode[0];
			if($scrtCode == '735' && $chckdStts == 1){
				$this->db->select('*');
				$this->db->from('book_packages');
				$this->db->where('transaction_code', $cdTrnsctn);
				$qryTrnsctn = $this->db->get();
				foreach($qryTrnsctn->result() as $colTrnsctn){
					$totAmnt = $colTrnsctn->total_sale_price_amount;
				}
				$totPay = round($totAmnt - $rateIdrToSgd, 2);
				$arrUpdtDta = array(
									'isRadeemPoint' => '1',
									'amountWithRadeem' => $totPay  
									);
				$this->db->update('book_packages', $arrUpdtDta);					
				echo '<b>SGD</b> '.$totPay;					
			}
			elseif($scrtCode == '1705' && $chckdStts == 0)
			{
				$arrUpdtDta = array(
									'isRadeemPoint' => '0',
									'amountWithRadeem' => '0'  
									);
				$this->db->update('book_packages', $arrUpdtDta);					
				echo '&nbsp;';		
			}
		}
		*/
	}
	
	function countryLoadCity(){
		sleep(3);
		$cntryIsoCode = $this->input->post('cntryCode');
		$qryCntryName = mysql_query("SELECT country_name FROM country WHERE country_iso='$cntryIsoCode' ");
		$getFldCntryNme = mysql_fetch_array($qryCntryName);
		$res=mysql_query("SELECT city_iso,city_name from city where country_iso='$cntryIsoCode' order by city_name asc");
		$check=mysql_num_rows($res);
		if($check > 0){
			$HTML = '<option value="">&lt;Cities of '.$getFldCntryNme['country_name'].'&gt;</option>';
			while($row=mysql_fetch_array($res)){
				$HTML.= '<option value="'.$row['city_iso'].'">'.$row['city_name'].'</option>';
			}
			echo $HTML;
		}
	}
	
	function validateBooking(){
	//sleep(5);
	/* ===============booking start========== */
	$trnsctnCode = $this->input->post('trnsctnCode');
	
	$qrySlctBkng = mysql_query("SELECT * FROM book_packages WHERE transaction_code='$trnsctnCode' ");
	$fldBkng = mysql_fetch_array($qrySlctBkng);
	$i = 0;
	$arrChildAge = array();
	$qrySlctTrvlrChldAge = mysql_query("SELECT age FROM traveler_info WHERE transaction_code='$trnsctnCode' AND isChild='1' AND traveler_type='33' ");
	while ($fldTrvlrChldAge = mysql_fetch_array($qrySlctTrvlrChldAge)){
		$chldAge[$i] = $fldTrvlrChldAge['age'];
		$i++;
	}
	$arrChildAge = array('Age'=>$chldAge);
	
	$adult = $fldBkng['adult']; 
	$child = $fldBkng['child']; 
	$travDate = $fldBkng['travel_date']; 
	$packageID = $fldBkng['API_packages_id']; 
	$totAmount = $fldBkng['total_amount'];
	$arrvFlghtNmbr = $fldBkng['arrive_flight_number'];
	$dprtrFlghtNmbr = $fldBkng['departure_flight_number'];
    $arrvFlghtDate = $fldBkng['arrive_flight_date'];
	$dprtrFlghtDate = $fldBkng['departure_flight_date'];
	
	/* ==========================SOAP Request Process Start Here======================= */
	$snrCtzn= 0;
	$crrncy='SGD';
	
	$qryGetDetailsTour= $this->db->query("SELECT * FROM tours WHERE API_packages_id='$packageID' ");
	$jmlDta = $qryGetDetailsTour->num_rows();
	foreach ($qryGetDetailsTour->result() as $row)
	{
		$trid= $row->tour_id;
		$trtp= $row->tour_type;
		$tourDet[] = array('TourID' => $trid, 'TravelDate' => $travDate, 'TourType' =>  $trtp);
	}	
	
	//$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityWS.asmx?wsdl";
	$WSDL ="http://ws.asiatravel.net/PartnerPackageWSv2/ActivityWS.asmx?wsdl";
	$SOAP = new SoapClient($WSDL, array('trace' => 1));
	$authvalues = array(
		'AgentCode'=>'PTADV',
		'PartnerID'=>'adventure_xml',
		'Culture'=>'en-US',
		'Password'=>'adventure1'
		);
	$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, 0);
	$SOAP->__setSoapHeaders(array($header));
	$Data = array(
	   'RequestParam' => array(
		'ActivityID' => $packageID,
		'Adult' => $adult,
		'SeniorCitizen' => $snrCtzn, 
		'Child'=> $arrChildAge,     
		'Currency' => $crrncy,
		'TourDetails' => array(		
								  'Tours' => $tourDet						  
					 			)
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
		//$BookURL = $item->BookURL;
		$Adult = $item->Adult;
		$Child = $item->Child;
		$Country = $item->Country;
		$City = $item->City;
		$Currency = $item->Currency;
		$PriceAdult = $item->PriceAdult;
		$PriceChild = $item->PriceChild;
		$PriceSeniorCitizen = $item->PriceSeniorCitizen;
		$TotalAmount = $item->TotalAmount;
/* =========================proceed booking to API start============== */
/*
$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityWS.asmx?wsdl";
$SOAP = new SoapClient($WSDL, array('trace' => 1));

$authvalues = array(
    'AgentCode'=>'PTADV',
    'PartnerID'=>'adventure_xml',
    'Culture'=>'en-US',
    'Password'=>'adventure1'
    );

$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, 0);
$SOAP->__setSoapHeaders(array($header));
*/

$qryGetDetailsTourBooking = $this->db->select('*')->from('tours')->where('API_packages_id', $packageID)->get();
	foreach ($qryGetDetailsTourBooking->result() as $fldBking)
	{
		$tridBkng = $fldBking->tour_id;
		$tourCtgry = $fldBking->tour_category;
		$qryTurCtgry = $this->db->select('*')
		->from('tour_category')
		->where('category_id', $tourCtgry)
		->get();
		foreach($qryTurCtgry->result() as $fldTurCtgry){
			$ctgryName = $fldTurCtgry->category_name;
		}
		if($tourCtgry == '1112'){
			$tourCtgryName = 'MorningTour';
		}else{
			$tourCtgryName = $ctgryName;
		}
		$tourDetBkng[] = array('TourID' => $tridBkng, 'TravelDate' => $travDate, 'TourSession' =>  $tourCtgryName);
	}	
	$qrySlctDrpOff = $this->db->select('*')->from('pickup_point')->where('API_packages_id', $packageID)->get();	
	foreach($qrySlctDrpOff->result() as $fldPckupPnt){
		$pckUpPntID = $fldPckupPnt->hotel_code;
		$pckPnt = $fldPckupPnt->hotel_name;
	}
	$qryTrvlrLdr = $this->db->select('*')
	->from('traveler_info')
	->join('country', 'country.country_iso=traveler_info.country_code', 'left')
	->where('transaction_code', $trnsctnCode)
	->where('isLeader', '1')
	->get();
	foreach($qryTrvlrLdr->result() as $fldTrvlrNfo ){
		$salut = $fldTrvlrNfo->title;
		$firstName = $fldTrvlrNfo->first_name;
		$lastName = $fldTrvlrNfo->last_name;
		$age = $fldTrvlrNfo->age;
		$pssprtNmbr = $fldTrvlrNfo->passport_number;
		$dob = $fldTrvlrNfo->dob;
		$pssprtExpryDte = $fldTrvlrNfo->passport_expired_date;
		$pssprtIssncCntry = $fldTrvlrNfo->passport_issuance_country;
		$ntnltyID = $fldTrvlrNfo->nationality_id;
		$cntryID = $fldTrvlrNfo->idx;
	}
	$qryTrvlrCntct = $this->db->select('*')
	->from('traveler_info')
	->join('country', 'country.country_iso=traveler_info.country_code', 'left')
	->join('city', 'city.country_iso=country.country_code', 'left')
	->where('transaction_code', $trnsctnCode)
	->where('isContact', '1')
	->get();
	foreach($qryTrvlrCntct->result() as $fldTrvlCntct){
		$salutTC = $fldTrvlCntct->salutaion;
		$firstNameTC = $fldTrvlCntct->first_name;
		$lastNameTC = $fldTrvlCntct->last_name;
		$email1TC = $fldTrvlCntct->email;
		$email2TC = $fldTrvlCntct->alternate_email;
		$cntctNmbrTC = $fldTrvlCntct->contact_number;
		$mblNmbrTC = $fldTrvlCntct->mobile_number;
		$faxNmbrTC = $fldTrvlCntct->fax_number;
		$addrssTC = $fldTrvlCntct->address;
		$pstlCodeTC = $fldTrvlCntct->postal_code;
		$cityTC = $fldTrvlCntct->city_iso;
		$cntryCodeTC = $fldTrvlCntct->country_iso;
		$cntryIDTC = $fldTrvlCntct->idx;
 	}
	$CardType = $this->finance->get_creditcard(1);	
	$CardHolderName = $this->finance->get_creditcard(2);
	$BankName = $this->finance->get_creditcard(3);
	$CardCountryCode = $this->finance->get_creditcard(4);
	$CardNumber = $this->finance->get_creditcard(5);
	$CardSecurityCode = $this->finance->get_creditcard(6);
	$CardExpiryDate = $this->finance->get_creditcard(7);
	$CardContactNumber = $this->finance->get_creditcard(8);
	$CardAddress = $this->finance->get_creditcard(9);
	$CardAddressPostalCode = $this->finance->get_creditcard(10);
	$CardAddressCity = $this->finance->get_creditcard(11);
	$CardAddressCountryCode = $this->finance->get_creditcard(12);
	
	$qryCrdTyp = $this->db->select('*')
	->from('card_type')
	->where('id', $CardType)
	->get();
	foreach($qryCrdTyp->result() as $fldCrdTyp){
		$crdTypName = $fldCrdTyp->type_name;
	}
$Data = array(
    'RequestParam' => array(
    'USID' => $USID,
    'ActivityID' => '736',
    'Adult' => '2', 
	'SeniorCitizen' => '0',
    'Child'=> $arrChildAge, 
    'TourDetails' => array(
	                      'Tour' => $tourDetBkng
						 ),
	               
	'Currency' => 'SGD',
	'TotalPrice' => $totAmount,
	'PickUpDropOffHotel'=> array(
	                            'PickupPointID' => $pckUpPntID,
								'PickupDropOffPoint' => $pckPnt
					            ),
	'LeadTravelerInfo'=> array(
	                            'Title' => $salut,
								'FirstName' => $firstName,
								'LastName' => $lastName,
								'PassengerType' => '32',
								'Age' => $age,
								'PassportNumber' => $pssprtNmbr,
								'DOB' => $dob,
								'PassportExpiryDate' => $pssprtExpryDte,
								'PassportIssuanceCountry' => $pssprtIssncCntry,
								'NationalityID' => $cntryID
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
	                      'ArrivalFlightNumber' => $arrvFlghtNmbr,
						  'DepartureFlightNumber' => $dprtrFlghtNmbr,
						  'ArrivalDate' => $arrvFlghtDate,
						  'DepartureDate' => $dprtrFlghtDate
					  ),
	'ContactInfo'=> array(
	                      'Salutation' => $salutTC,
						  'FirstName' => $firstNameTC,
						  'LastName' => $lastNameTC,
						  'Email' => $email1TC,
						  'Email2' => $email2TC,
						  'ContactNumber' => $cntctNmbrTC,
						  'MobileNumber' => $mblNmbrTC,
						  'FaxNumber' => $faxNmbrTC,
						  'Address' => $addrssTC,
						  'PostalCode' => $pstlCodeTC,
						  'City' => $cityTC,
						  'CountryCode' => $cntryCodeTC,
						  'NationalityID' => $cntryIDTC,
						  'NationalityCode' => $cntryCodeTC
					  ),
					
	'CreditCardInfo'=> array(
	                      'CardType' => $crdTypName,
						  'CardHolderName' => $CardHolderName,
						  'BankName' => $BankName,
						  'CardCountryCode' => $CardCountryCode,
						  'CardNumber' => $CardNumber,
						  'CardSecurityCode' => $CardSecurityCode,
						  'CardExpiryDate' => $CardExpiryDate,
						  'CardContactNumber' => $CardContactNumber,
						  'CardAddress' => $CardAddress,
						  'CardAddressPostalCode' => $CardAddressPostalCode,
						  'CardAddressCity' => $CardAddressCity,
						  'CardAddressCountryCode' => $CardAddressCountryCode
					  ),
		),
);

$Response = $SOAP->BookActivity($Data);
$string = $SOAP->__getLastResponse();


$xml = simplexml_load_string($string);
$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
$xml->registerXPathNamespace('ns', 'http://tempuri.org/');

foreach ($xml->xpath('//ns:BookActivityResult') as $item)
{
$USID = $item->USID;
$ActivityID = $item->ActivityID;
$BookingStatus = $item->BookingStatus;
$ConfirmationNumber = $item->ConfirmationNumber;
$Currency = $item->Currency;
$TotalPrice = $item->TotalPrice;
     
}
/* =========================proceed booking to API end================ */	
		}
	/* ===============booking end============ */
	$dtUpdtBkng = array(
               'validated' => '1',
               'api_booking_status' => $BookingStatus ,
               'api_confirmation_number' => $ConfirmationNumber 
            );

	$this->db->where('transaction_code', $trnsctnCode);
	$this->db->update('book_packages', $dtUpdtBkng); 			
	
	
	$msgs = '<div style="background-color:#228B22; color:#fff; font-weight:bold;padding:10px;">Transaction '.$trnsctnCode.' - '.$USID.' - '.$ActivityID.' is success validated</div>';
	echo $msgs;
	
	
	}

	function bookingPackageManual(){
		//$pckgsID = $this->input->post('pckgId');
		$adltPax = $this->input->post('adultPax');
		$chldPax = $this->input->post('childPax');
		$travelDate = $this->input->post('tourDate');
		$id = $this->input->post('id');
			
		$arrVldtnDta = array(
			   array('field'=> 'adultPax', 'label'=> 'Adult PAX', 'rules'=> 'required'),
               array('field'=> 'childPax', 'label'=> 'Child PAX', 'rules'=> 'required'),
			   array('field'=> 'tourDate', 'label'=> 'Travel Date', 'rules'=> 'required'),
            );

		$this->form_validation->set_rules($arrVldtnDta);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('flashMsge_warning', '<strong>Warning !</strong> please fill in the required form !');
			redirect('detail/book/'.$id,'refresh');
			 
			/*	
			$data['pagecontent'] = "user/booking_manual_package";
			$this->load->vars($data);
			$this->load->view('template');
			*/
		}
		else{
			
			$qry = mysql_query("SELECT * FROM packages WHERE packages_id='$id' ");
			while($fldPckgs = mysql_fetch_array($qry)){
				$Adult = $adltPax;
				$Child = $chldPax;
				$PriceAdult = $fldPckgs['price_adult'];
				$PriceChild = $fldPckgs['price_child'];
				$totPriceAdult = $Adult * $PriceAdult;
				$totPriceChild = $Child * $PriceChild;
				$totPrc = $totPriceAdult + $totPriceChild;
				$ctyCode = $fldPckgs['city'];
				$ctyCntry = $fldPckgs['country'];
				$pckgNme = $fldPckgs['nama'];
							/* margin and package profit price */
			                if ($this->tank_auth->is_logged_in()) {	
								switch($this->tank_auth->get_user_role_id()) {
									case 1 : $userRoleID = '1'; break;
									case 2 : $userRoleID = '2'; break;
									case 3 : $userRoleID = '3'; break;
								}
								
							} 
							else{
								$userRoleID = '4';
							}
							
			                $qrySlctMrgn = mysql_query("SELECT * FROM margin WHERE role_id='$userRoleID' ");
			                $mrgnFld = mysql_fetch_array($qrySlctMrgn);
							$crrncy = $mrgnFld['currency'];
			                $prcntMrgn = $mrgnFld['margin_pr'] / 100;/* hitung persentase margin profit */
							$profitAdultPrice = $PriceAdult * $prcntMrgn; 
							$profitChildPrice = $PriceChild * $prcntMrgn; 
							
							$salePriceAdult = round($PriceAdult + $profitAdultPrice, 2);
							$salePriceChild = round($PriceChild + $profitChildPrice, 2);
			
				        $totalAdultSalePrice = round($Adult * $salePriceAdult, 2);
				        $totalChildSalePrice = round($Child * $salePriceChild, 2);
						$totalPackageSalePrice = round($totalAdultSalePrice + $totalChildSalePrice, 2);
				
						$trnsCode = 'TM'.date('YmdHis').'BD'.$fldPckgs['API_packages_id'].'PC';
						$today = date('Y-m-d');
						$mnlPckgID = $fldPckgs['API_packages_id'];
						$crrncy = $fldPckgs['currency'];
						$dtArrPckgs = array(
						  'transaction_code' => "$trnsCode",
						  'user_role' => "$userRoleID",
						  'user_id' => '0',
						  'booking_date' => "$today",
						  'travel_date' => "$travelDate",
						  'API_packages_id' => "$mnlPckgID",
						  'adult' => "$Adult",
						  'child' => "$Child",
						  'currency_code' => "$crrncy",
						  'price_adult' => "$PriceAdult",
						  'price_child' => "$PriceChild",
						  'total_amount' => "$totPrc",
						  'country_code' => "$ctyCntry",
						  'city_code' => "$ctyCode",
						  'adult_sale_price' => "$salePriceAdult",
						  'child_sale_price' => "$salePriceChild",
						  'total_sale_price_amount' => "$totalPackageSalePrice",
						  'book_step' => '1',
						  'package_name' => "$pckgNme",
						  'validated' => '0'
						   
						);
						$this->db->insert('book_packages', $dtArrPckgs);
						//redirect('booking/form/bid/'.$trnsCode,'refresh');
						$this->session->set_userdata('bookingID', $trnsCode);
						
						$data['idPckgMnl'] = $mnlPckgID;
						$data['pagecontent'] = 'user/form_booking_package_manual';
						$this->load->view('template', $data);	
						
			}
			$qrySlctTCde = mysql_query("SELECT transaction_code FROM book_packages WHERE transaction_code='$trnsCode' ");
			$getDataTCde = mysql_fetch_array($qrySlctTCde);
			$this->session->set_userdata('bookingTCde', $getDataTCde['transaction_code']);		
			echo '<script>window.location = "'.base_url().'index.php/transaction/booking_form2/'.$getDataTCde['transaction_code'].'"</script>';
		}
		
		
		
	}

	function bookingPackage(){
	/* guest booking package */
			
	$bookingDate = date("Y-m-d");         
	$adult = $this->input->post('adult');
	$child = $this->input->post('child');
	$childage = $this->input->post('childage');
	$travDate = $this->input->post('travDate');
	$packageID = $this->input->post('packageID');
	$endLoop = $child - 1;
	$arrChildAge = array();
	
	
	
	/* ============check is package from API========= */
	$qurySlct = mysql_query("SELECT * FROM packages WHERE API_packages_id='$packageID' ");
	$field = mysql_fetch_array($qurySlct);
	$isPckgeAPI = $field['isFromAPI'];
	$chldAge = array();
			if($child != 0){
				for($i=0;$i<=$endLoop;$i++){
				$chldAge[$i] = $childage[$i]['value'];
		    	}
				$arrChildAge = array('Age'=>$chldAge);
				$childAgesForDB = serialize($chldAge);
			}else{
				$arrChildAge = '';
				$childAgesForDB ='';
			}
			
			$childAgesForDB = serialize($chldAge);
	
		/* ==========================SOAP Request Process Start Here======================= */
			$snrCtzn= 0;
			$crrncy='SGD';
			
			$qryGetDetailsTour= $this->db->query("select * from tours where API_packages_id='$packageID' ");
			$jmlDta = $qryGetDetailsTour->num_rows();
			foreach ($qryGetDetailsTour->result() as $row)
			{
				$trid= $row->tour_id;
				$trtp= $row->tour_type;
				$tourDet[] = array('TourID' => $trid, 'TravelDate' => $travDate, 'TourType' =>  $trtp);
			}
	
	
	//$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityWS.asmx?wsdl";
	$WSDL ="http://ws.asiatravel.net/PartnerPackageWSv2/ActivityWS.asmx?wsdl";
	$SOAP = new SoapClient($WSDL, array('trace' => 1));
	$authvalues = array(
		'AgentCode'=>'PTADV',
		'PartnerID'=>'adventure_xml',
		'Culture'=>'en-US',
		'Password'=>'adventure1'
		);
	$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, 0);
	$SOAP->__setSoapHeaders(array($header));
		$Data = array(
		   'RequestParam' => array(
			'ActivityID' => $packageID,
			'Adult' => $adult,
			'SeniorCitizen' => $snrCtzn, 
			'Child'=> $arrChildAge,   
							  //'Age' => $chldAge,   
							  //'Age' => array ('3','7'),   
							
			'Currency' => $crrncy,
			'TourDetails' => array(
										
									  'Tours' => $tourDet
													  /*
													  'TourID' => '603', 
													  'TravelDate' => $trdate, 
													  'TourType' =>  '18'),
													  */
										  
								
								 )
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
			//$BookURL = $item->BookURL;
			$Adult = $item->Adult;
			$Child = $item->Child;
			$Country = $item->Country;
			$City = $item->City;
			$Currency = $item->Currency;
			$PriceAdult = $item->PriceAdult;
			$PriceChild = $item->PriceChild;
			$PriceSeniorCitizen = $item->PriceSeniorCitizen;
			$TotalAmount = $item->TotalAmount;
			
			 /*
				$totalAdultPrice = $adult * floatval($PriceAdult);
		        $totalChildPrice = $child * floatval($PriceChild);
				$totalPackagePrice = $totalAdultPrice + $totalChildPrice;
			  */
			/* create transaction code */ 
			$bookingDate = date("YmdHis");  
			$transCode = 'TG'.$bookingDate.'BD'.$ActivityID.'PC';
			
			if ($this->tank_auth->is_logged_in()) {	
				switch($this->tank_auth->get_user_role_id()) {
					case 1 : $userRoleID = '1'; break;
					case 2 : $userRoleID = '2'; break;
					case 3 : $userRoleID = '3'; break;
				}
				$userID = $this->tank_auth->get_user_id();
				
				
				
			} else {
				$userRoleID = '4';
				$userID = 0;
			}
			
				/* get currency rate IDR to SGD */
				$this->db->select('konversi');
				$this->db->from('currencies');
				$this->db->where('country_iso_from','SG');
				$this->db->where('currency_from','SGD');
				$this->db->where('country_iso_to','ID');
				$this->db->where('currency_to','IDR');
				$qrySgd = $this->db->get();
				foreach($qrySgd->result() as $row){
					$rateIDR = $row->konversi;
				}
				
				$this->db->select('konversi');
				$this->db->from('currencies');
				$this->db->where('country_iso_from','SG');
				$this->db->where('currency_from','SGD');
				$this->db->where('country_iso_to','US');
				$this->db->where('currency_to','USD');
				$qryUsd = $this->db->get();
				foreach($qryUsd->result() as $row){
					$rateUSD = $row->konversi;
				}
				
			
			$qrySlctMrgn = mysql_query("SELECT * FROM margin WHERE role_id='$userRoleID' ");
            $mrgnFld = mysql_fetch_array($qrySlctMrgn);
			$mrgnCrrncy = $mrgnFld['currency'];
            $prcntMrgn = $mrgnFld['margin_pr'] / 100;/* hitung persentase margin profit */
			$profitAdultPrice = $PriceAdult * $prcntMrgn; 
			$profitChildPrice = $PriceChild * $prcntMrgn; 
				
			$salePriceAdult = round($PriceAdult + $profitAdultPrice, 2);
			$salePriceChild = round($PriceChild + $profitChildPrice, 2);
		
	        $totalAdultSalePrice = round($adult * $salePriceAdult, 2);
	        $totalChildSalePrice = round($child * $salePriceChild, 2);
			$totalPackageSalePrice = round($totalAdultSalePrice + $totalChildSalePrice, 2);
			/* convert currency rate from SGD to IDR and USD */
			$amountTotalSale_SGDtoIDR = round($rateIDR * (($adult * ($PriceAdult + $profitAdultPrice)) + ($child * ($PriceChild + $profitChildPrice))), 2);  
			$amountTotalSale_SGDtoUSD = round($rateUSD * (($adult * ($PriceAdult + $profitAdultPrice)) + ($child * ($PriceChild + $profitChildPrice))), 2);  
			
			if ($this->tank_auth->is_logged_in()) {
				
				/* get point param in adm_transfer start */
				$this->db->select('*');
				$this->db->from('adm_transfer');
				$result = $this->db->get();
				$return = array();
				if($result->num_rows() > 0) {
						foreach($result->result_array() as $row) {
							$return[$row['keterangan']] = $row['content'];
						}
						if($userRoleID == '2'){
							/* memeber */
							$MinimalBeli = $return['MinimalBeli'];	
							$NominalBeli = $return['NominalBeli'];
							$PointBeli = $return['PointBeli'];
							$MinimalPoint = $return['MinimalPoint'];
							$PointTukar = $return['PointTukar'];
							$NominalBayar = $return['NominalBayar'];
						}
						elseif($userRoleID == '3'){
							/* reseller */
							$MinimalBeli = $return['MinimalBeliReseller'];
							$NominalBeli = $return['NominalBeliReseller'];
							$PointBeli = $return['PointBeliReseller'];
							$MinimalPoint = $return['MinimalPointReseller'];
							$PointTukar = $return['PointTukarReseller'];
							$NominalBayar = $return['NominalBayarReseller'];
						}
						
				}
					if($amountTotalSale_SGDtoIDR >= $MinimalBeli){
						$this->db->select('total_point');
						$this->db->from('users');
						$this->db->where('users_id', $userID);
						$this->db->where('role_id', $userRoleID);
						$qrySlctGetUsrs = $this->db->get();
						foreach($qrySlctGetUsrs->result() as $fldUsrs){
							$totPoint = $fldUsrs->total_point;
						}
						$point = $amountTotalSale_SGDtoIDR / $NominalBayar;
						$valUpdtPoint = $totPoint + $point; 
					}; 
					/*
					$arrDta = array('total_point' => $valUpdtPoint);
					$this->db->where('users_id', $userID);	
					$this->db->where('role_id', $userRoleID);
					$this->db->update('users', $arrDta);
					*/
				/* get point param in adm_transfer end */	
				/*
				$this->db->select('*');
				$this->db->from('users');
				$this->db->where('users_id', $userID);
				$this->db->where('role_id', $userRoleID);
				$qrySlctGetUsrs = $this->db->get();
				foreach($qrySlctGetUsrs->result() as $fldUsrs){
					$usrType = $fldUsrs->role_id;
					$usrIdTbl = $fldUsrs->users_id;
					$totPoint = $fldUsrs->total_point;
					
					if($usrType ==  $userRoleID && $usrIdTbl == $userID){
						switch($usrType){
						case 2 : if($amountTotalSale_SGDtoIDR >= $MinimalBeli){
									$point = $amountTotalSale_SGDtoIDR / $NominalBayar;
									$valUpdtPoint = $totPoint + $point; 
									}; 
									$arrDta = array('total_point' => $valUpdtPoint);
									$this->db->update('users', $arrDta);
									$this->db->where('users_id', $usrIdTbl);	
									$this->db->where('role_id', $usrType);
									break;
						case 3 : if($amountTotalSale_SGDtoIDR >= $MinimalBeliReseller){
									$point = $amountTotalSale_SGDtoIDR / $NominalBayarReseller;
									$valUpdtPoint = $totPoint + $point; 
									}; 
									$arrDta = array('total_point' => $valUpdtPoint);
									$this->db->update('users', $arrDta);
									$this->db->where('users_id', $usrIdTbl);	
									$this->db->where('role_id', $usrType);
									break;
						}
					}
					
					
											 		
				}
				 * */
					
					
				
				
				/*
				$this->db->select('*');
				$this->db->from('users');
				$this->db->join('adm_transfer.jenis_tr=users.role_id', 'LEFT');
				$qryPoint = $this->db->get();
					foreach($qryPoint as $row){
						$label = $row->keterangan;
						$minNomGetPoint = $row->content;
						$roleID = $row->jenis_tr;
						$usrId = $row->users_id ;
						
							switch($label){
								
								case 'MinimalBeli' : 
													$this->db->select('*'); 
													$this->db->from('adm_transfer');
													$this->db->where('keterangan', 'MinimalBeli');
													$this->db->where('jenis_tr', $usrId);
													$qry1 = $this->db->get();
													foreach($qry1->result() as $row1){
														$MinimalBeli = $row1->content;
													};													
													break;
								case 'NominalBeli' : $this->db->select('*'); 
													$this->db->from('adm_transfer');
													$this->db->where('keterangan', 'NominalBeli');
													$this->db->where('jenis_tr', $usrId);
													$qry2 = $this->db->get();
													foreach($qry2->result() as $row2){
														$NominalBeli = $row2->content;
													}; break;
								case 'PointBeli' : $this->db->select('*'); 
													$this->db->from('adm_transfer');
													$this->db->where('keterangan', 'PointBeli');
													$this->db->where('jenis_tr', $usrId);
													$qry2 = $this->db->get();
													foreach($qry2->result() as $row2){
														$PointBeli = $row2->content;
													}; break;
								case 'MinimalPoint' :  $this->db->select('*'); 
													$this->db->from('adm_transfer');
													$this->db->where('keterangan', 'MinimalPoint');
													$this->db->where('jenis_tr', $usrId);
													$qry3 = $this->db->get();
													foreach($qry3->result() as $row3){
														$minBuyToGetPoint = $row3->content;
													}; break;
								case 'PointTukar' :  $this->db->select('*'); 
													$this->db->from('adm_transfer');
													$this->db->where('keterangan', 'PointTukar');
													$this->db->where('jenis_tr', $usrId);
													$qry4 = $this->db->get();
													foreach($qry4->result() as $row4){
														$minBuyToGetPoint = $row4->content;
													}; break;
								case 'NominalBayar' :  $this->db->select('*'); 
													$this->db->from('adm_transfer');
													$this->db->where('keterangan', 'PointBeli');
													$this->db->where('jenis_tr', $usrId);
													$qry5 = $this->db->get();
													foreach($qry5->result() as $row5){
														$NominalBayar = $row5->content;
													}; break;
							
								case 'MinimalBeliReseller' :  $this->db->select('*'); 
													$this->db->from('adm_transfer');
													$this->db->where('keterangan', 'MinimalBeliReseller');
													$this->db->where('jenis_tr', $usrId);
													$qry6 = $this->db->get();
													foreach($qry6->result() as $row6){
														$MinimalBeliReseller = $row6->content;
													}; break;
								case 'NominalBeliReseller' :  $this->db->select('*'); 
													$this->db->from('adm_transfer');
													$this->db->where('keterangan', 'NominalBeliReseller');
													$this->db->where('jenis_tr', $usrId);
													$qry7 = $this->db->get();
													foreach($qry7->result() as $row7){
														$NominalBeliReseller = $row7->content;
													}; break;
								case 'PointBeliReseller' :  $this->db->select('*'); 
													$this->db->from('adm_transfer');
													$this->db->where('keterangan', 'PointBeli');
													$this->db->where('jenis_tr', $usrId);
													$qry8 = $this->db->get();
													foreach($qry8->result() as $row8){
														$PointBeliReseller = $row8->content;
													}; break;
								case 'MinimalPointReseller' :  $this->db->select('*'); 
													$this->db->from('adm_transfer');
													$this->db->where('keterangan', 'MinimalPointReseller');
													$this->db->where('jenis_tr', $usrId);
													$qry8 = $this->db->get();
													foreach($qry8->result() as $row8){
														$MinimalPointReseller = $row8->content;
													}; break;
								case 'PointTukarReseller' :  $this->db->select('*'); 
													$this->db->from('adm_transfer');
													$this->db->where('keterangan', 'PointTukarReseller');
													$this->db->where('jenis_tr', $usrId);
													$qry9 = $this->db->get();
													foreach($qry9->result() as $row9){
														$PointTukarReseller = $row9->content;
													}; break;
								case 'NominalBayarReseller' :  $this->db->select('*'); 
													$this->db->from('adm_transfer');
													$this->db->where('keterangan', 'NominalBayarReseller');
													$this->db->where('jenis_tr', $usrId);
													$qry10 = $this->db->get();
													foreach($qry10->result() as $row10){
														$NominalBayarReseller = $row10->content;
													}; break;
							}
						
					}
			
					if($userRoleID == 2){
						
						if($minBuyToGetPoint <= $totalPackageSalePrice){
							$jmlPointMmbr = $totalPackageSalePrice / $NominalBeli;
							$this->db->select('*');
							$this->db->from('users');
							$this->db->where('users_id', $IDusr);
							$this->db->where('role_id', $userRoleID);
							$query = $this->db->get();
							foreach($query->result() as $row){
								$arrDta = array(
										'total_point' => "$jmlPointMmbr"
									);
								$this->db->update('users', $arrDta);
							}
						}
											
					} elseif($userRoleID == 3) {
						if($NominalBeliReseller <= $totalPackageSalePrice){
							$jmlPointRsllr = $totalPackageSalePrice / $NominalBeliReseller;
							$this->db->select('*');
							$this->db->from('users');
							$this->db->where('users_id', $IDusr);
							$this->db->where('role_id', $userRoleID);
							$query = $this->db->get();
							foreach($query->result() as $row){
								$arrDta = array(
										'total_point' => "$jmlPointRsllr"
									);
								$this->db->update('users', $arrDta);
							}
						}
					}
					
				
			*/
				
			}	
			
			
			$qryInsrt = $this->db->query("INSERT INTO book_packages(transaction_code,booking_date,user_role,user_id,travel_date,usid,API_packages_id,package_name,adult,child,country_code,city_code,currency_code,price_adult,price_child,price_seniorcitizen,total_amount,adult_sale_price,child_sale_price,total_sale_price_amount,book_step,validated, amount_total_sale_price_inIDR, amount_total_sale_price_inUSD,child_ages) VALUES('$transCode','$bookingDate','$userRoleID','$userID','$travDate','$USID','$ActivityID','$ActivityName','$Adult','$Child','$Country','$City','$Currency','$PriceAdult','$PriceChild','$PriceSeniorCitizen','$TotalAmount','$salePriceAdult','$salePriceChild','$totalPackageSalePrice','1','0','$amountTotalSale_SGDtoIDR','$amountTotalSale_SGDtoUSD','$childAgesForDB')");
			
			
		}
$qrySlctUSID = mysql_query("SELECT usid FROM book_packages WHERE usid='$USID' ");
$getDataUSID = mysql_fetch_array($qrySlctUSID);
/*
$newSessData = array(
                   'bookingUSID'  => $getDataUSID['usid'],
                   'bookingPID'     => $ActivityID,
               );
 * */
$this->session->set_userdata('bookingUSID', $getDataUSID['usid']);


 //echo '<script>window.location = "'.base_url().'index.php/transaction/booking_form/sid/'.$getDataUSID['usid'].'/pid/'.$packageID.'"</script>';	
		echo '<script>window.location = "'.base_url().'index.php/transaction/booking_form/'.$getDataUSID['usid'].'"</script>';	
}
/* ========================================================================================================= */
/* ========================================================================================================= */	
	function displayCheckprice_booking_form(){
	//sleep(2);
	$adult = $this->input->post('adult');
	$child = $this->input->post('child');
	$childage = $this->input->post('childage');
	$travDate = $this->input->post('travDate');
	$packageID = $this->input->post('packageID');
	$endLoop = $child - 1;
	$arrChildAge = array();
	/* ============check is package from API========= */
	$qurySlct = mysql_query("SELECT * FROM packages WHERE API_packages_id='$packageID' ");
	$field = mysql_fetch_array($qurySlct);
	$isPckgeAPI = $field['isFromAPI'];
	
	$minDateBooking = date('Y-m-d', strtotime("+4 days"));
	$format = 'Y-m-d';
	$date1  = DateTime::createFromFormat($format, $travDate);
	$date2  = DateTime::createFromFormat($format, $minDateBooking);
	
	//var_dump($date1 > $date2);
	
	if($isPckgeAPI == 1){
/* ==================package from API start here========================= */	
    
	if(($adult == 1 && $child == 0) || ($adult == 0 && $child == 1)){
		$errMsg = 'Minimum booking is 2 pax';
	}
	elseif($date1 < $date2){
    		$errMsg = 'Tour date is starting at '.$minDateBooking;
    	}
	else
	{
	if(($child !== 0 && !empty($childage) && !empty($travDate)) || ($child == 0 && empty($childage) && !empty($travDate)) || ($child !== 0 && empty($childage) && !empty($travDate))){
		
		
		if($child != 0 && !empty($childage)){
			for($i=0;$i<=$endLoop;$i++){
			$chldAge[$i] = $childage[$i]['value'];
			
	    	}
			$arrChildAge = array('Age'=>$chldAge);
		}
		elseif($child = 0 && empty($childage)){
			$arrChildAge = array('Age'=>NULL);
		}
		
		//$errMsg = 'Success '.json_encode($usiaAnak);
		//$errMsg = 'Success ';
		$errMsg = '';
		/* ==========================SOAP Request Process Start Here======================= */
	$snrCtzn= '0';
	$crrncy='SGD';
	/*echo "<script>alert(".json_encode($childAge).");</script>";*/
	/*echo "<script>alert(".print_r($usiaAnak).");</script>";*/
	$qryGetDetailsTour= $this->db->query("select * from tours where API_packages_id='$packageID' ");
	$jmlDta = $qryGetDetailsTour->num_rows();
	foreach ($qryGetDetailsTour->result() as $row)
	{
		$trid= $row->tour_id;
		$trtp= $row->tour_type;
		$tourDet[] = array('TourID' => $trid, 'TravelDate' => $travDate, 'TourType' =>  $trtp);
	}
	/*	
	$myTour['TourDetails'] = array('Tours' => $tourDet);
	echo '<div style="z-index:5000;position:absolute;top:100px;background:#fff;border:1px red solid;">'.print_r($tourDet).'</div>';
	*/	
	
	//$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityWS.asmx?wsdl";
	$WSDL ="http://ws.asiatravel.net/PartnerPackageWSv2/ActivityWS.asmx?wsdl";
	$SOAP = new SoapClient($WSDL, array('trace' => 1));
	$authvalues = array(
		'AgentCode'=>'PTADV',
		'PartnerID'=>'adventure_xml',
		'Culture'=>'en-US',
		'Password'=>'adventure1'
		);
	$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, 0);
	$SOAP->__setSoapHeaders(array($header));
	$Data = array(
	   'RequestParam' => array(
		'ActivityID' => $packageID,
		'Adult' => $adult,
		'SeniorCitizen' => $snrCtzn, 
		'Child'=> $arrChildAge,   
						  //'Age' => $chldAge,   
						  //'Age' => array ('3','7'),   
						
		'Currency' => $crrncy,
		'TourDetails' => array(
									
								  'Tours' => $tourDet
												  /*
												  'TourID' => '603', 
												  'TravelDate' => $trdate, 
												  'TourType' =>  '18'),
												  */
									  
							
							 )
		)
	
	);
	
	$Response = $SOAP->SearchActivityPrice($Data);
	$string = $SOAP->__getLastResponse();
	
	$xml = simplexml_load_string($string);
	$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
	$xml->registerXPathNamespace('ns', 'http://tempuri.org/');
		foreach ($xml->xpath('//ns:SearchActivityPriceResult/ns:Errors') as $items)
		{
			$ErrorCode = $items->ErrorCode;
			$ErrorMessage = $items->ErrorMessage;
		}
		foreach ($xml->xpath('//ns:SearchActivityPriceResult/ns:ActivitiePrice') as $item)
		{
		$USID = $item->USID;
		$ActivityID = $item->ActivityID;
		$ActivityName = $item->ActivityName;
		//$BookURL = $item->BookURL;
		$Adult = $item->Adult;
		$Child = $item->Child;
		$Country = $item->Country;
		$City = $item->City;
		$Currency = $item->Currency;
		$PriceAdult = $item->PriceAdult;
		$PriceChild = $item->PriceChild;
		$PriceSeniorCitizen = $item->PriceSeniorCitizen;
		$TotalAmount = $item->TotalAmount;
		/* price with profit */
		 
      			/* margin and package profit price */
                if ($this->tank_auth->is_logged_in()) {	
					switch($this->tank_auth->get_user_role_id()) {
						case 1 : $userRoleID = '1'; break;
						case 2 : $userRoleID = '2'; break;
						case 3 : $userRoleID = '3'; break;
					}
					
				} 
				else{
					$userRoleID = '4';
				}
				
				/* cek kesamaan data value antara database dg API asiatravel  */
                $this->db->select('*');
				$this->db->from('packages');
				$this->db->where('API_packages_id', $ActivityID);
				$qry = $this->db->get();
				foreach($qry->result() as $dsknRow){
					$diskon = $dsknRow->discount; 
					switch($userRoleID){
						case 2 : $mrgn_pr = $dsknRow->member_margin_pr;break;
						case 3 : $mrgn_pr = $dsknRow->reseller_margin_pr;break;
						case 4 : $mrgn_pr = $dsknRow->guest_margin_pr;break;	
					}
				}
				$qrySlctMrgn = mysql_query("SELECT * FROM margin WHERE role_id='$userRoleID' ");
	            $mrgnFld = mysql_fetch_array($qrySlctMrgn);
				$crrncy = $mrgnFld['currency'];
				if($diskon == 0){
					$prcntMrgn = $mrgnFld['margin_pr'] / 100;/* hitung persentase margin profit */
					$profitAdultPrice = $PriceAdult * $prcntMrgn; 
					$profitChildPrice = $PriceChild * $prcntMrgn; 
					
					$salePriceAdult = round($PriceAdult + $profitAdultPrice, 2);
					$salePriceChild = round($PriceChild + $profitChildPrice, 2);
					
				    //$qryInsrt = $this->db->query("INSERT INTO book_packages(travel_date,usid,API_packages_id,package_name,adult,child,country_code,city_code,currency_code,price_adult,price_child,price_seniorcitizen,total_amount) VALUES('$trdate','$USID','$ActivityID','$ActivityName','$Adult','$Child','$Country','$City','$Currency','$PriceAdult','$PriceChild','$PriceSeniorCitizen','$TotalAmount')");
					/* $totalAdultPrice = $adult * floatval($PriceAdult);
			        $totalChildPrice = $child * floatval($PriceChild); */
			        $totalAdultSalePrice = round($Adult * $salePriceAdult, 2);
			        $totalChildSalePrice = round($Child * $salePriceChild, 2);
					$totalPackageSalePrice = round($totalAdultSalePrice + $totalChildSalePrice, 2);
				}
				else{
					//$prcntMrgn = $mrgn_pr / 100;
					$prcntMrgn = $mrgnFld['margin_pr'] / 100;/* hitung persentase margin profit */
					$profitAdultPrice = $PriceAdult * $prcntMrgn; 
					$profitChildPrice = $PriceChild * $prcntMrgn; 
					
					$salePriceAdult = round($PriceAdult + $profitAdultPrice, 2);
					$salePriceChild = round($PriceChild + $profitChildPrice, 2);
					
				    //$qryInsrt = $this->db->query("INSERT INTO book_packages(travel_date,usid,API_packages_id,package_name,adult,child,country_code,city_code,currency_code,price_adult,price_child,price_seniorcitizen,total_amount) VALUES('$trdate','$USID','$ActivityID','$ActivityName','$Adult','$Child','$Country','$City','$Currency','$PriceAdult','$PriceChild','$PriceSeniorCitizen','$TotalAmount')");
					/* $totalAdultPrice = $adult * floatval($PriceAdult);
			        $totalChildPrice = $child * floatval($PriceChild); */
			        $totalAdultSalePrice = round($Adult * $salePriceAdult, 2);
			        $totalChildSalePrice = round($Child * $salePriceChild, 2);
					$totalPackageSalePrice = round($totalAdultSalePrice + $totalChildSalePrice, 2);/*
					  $prcntMrgn = $mrgn_pr / 100;
						$profit = $pckgsPrice * $prcntMrgn; 
						$hrgPckage = $pckgsPrice + $profit;
						$nomDisc = $hrgPckage + ($hrgPckage * ($diskon / 100));
						$priceMarkup = round($nomDisc, 2);
					 * */
				
					
				    //$qryInsrt = $this->db->query("INSERT INTO book_packages(travel_date,usid,API_packages_id,package_name,adult,child,country_code,city_code,currency_code,price_adult,price_child,price_seniorcitizen,total_amount) VALUES('$trdate','$USID','$ActivityID','$ActivityName','$Adult','$Child','$Country','$City','$Currency','$PriceAdult','$PriceChild','$PriceSeniorCitizen','$TotalAmount')");
					/* $totalAdultPrice = $adult * floatval($PriceAdult);
			        $totalChildPrice = $child * floatval($PriceChild); */
			        /*
			        $totalAdultSalePrice = round($Adult * $salePriceAdult, 2);
			        $totalChildSalePrice = round($Child * $salePriceChild, 2);
					$totalPackageSalePrice = round($totalAdultSalePrice + $totalChildSalePrice, 2);
					 * */
				}
                
	
		}
/* ==========================SOAP Request Process End Here======================= */
/*
 <input type"hidden" name="packageID" value="'.$ActivityID.'" >
	<input type"hidden" name="packageID" value="'.$ActivityID.'" >
	<input type"hidden" name="adultPax" value="'.$Adult.'" >
	<input type"hidden" name="sniorCtzn" value="0" >
	<input type"hidden" name="currency" value="SGD" >
	<input type"hidden" name="childPax" value="'.json_encode($arrChildAge).'" >
	<input type"hidden" name="tours" value="'.json_encode($tourDet).'" >
  */
	if(!empty($USID)){
	$myHtml = '
	<div style="padding: 5px;">
			<div style="font-weight: bold; text-decoration: underline;padding-left:10px;">Package Price Details : </div>
			<div style="padding: 5px;">
				
				<table>
					<tr>
						<td width="80"> '.$adult.' x Adult </td>
						<td width="100" align="left"> @ <b>'.$Currency.'</b>&nbsp;'.$salePriceAdult.' </td>
						<td width="200">  = <b>'.$Currency.'</b>&nbsp;'.$totalAdultSalePrice.' </td>
					</tr>';
					if($child != 0){
					$myHtml .= '
					<tr>
						<td>'.$child.' x Child </td>
						<td align="left"> @ <b>'.$Currency.'</b>&nbsp;'.$salePriceChild.' </td>
						<td> = <b>'.$Currency.'</b>&nbsp;'.$totalChildSalePrice.' </td>
					</tr>';
					}
					$myHtml .= '
					<tr>
						<td colspan="2" style="font-weight: bold;width:250px;"> Total Price </td>
						<td>&nbsp;&nbsp;&nbsp;<b>'.$Currency.'</b>&nbsp;'.$totalPackageSalePrice.'</td>
					</tr>
					
				</table>
				
			</div>
		
		</div>';
		echo '<script>$("#bookThisPackage").prop("disabled", false);</script>';
		echo $myHtml;
		}
		else{
			if(isset($ErrorCode)){
				$errMsg = 'Can\'t connect to the server, please try again later';
			/* ==============catch error for method SearchActivityPrice start============= */
				$errMethod = 'SearchActivityPrice';
				$errPckgRefNo = $this->errorlog_model->get_package_refno($packageID);
				$errPckgID = $packageID;
				$usrAgent = $this->agent->browser().' at '.$this->input->ip_address();
				$errValue = 'Error from API Server, ErrCode='.$ErrorCode.', ErrMsg='.$ErrorMessage;
				$this->errorlog_model->save_error_toDB($errMethod, $errPckgRefNo, $errPckgID, $errValue, $usrAgent);
			/* ==============catch error for method SearchActivityPrice end============= */
			}
			else{
				$errMsg = 'Can\'t connect to the server, please try again later';
				/* ==============catch error for method SearchActivityPrice start============= */
					$errMethod = 'SearchActivityPrice';
					$errPckgRefNo = $this->errorlog_model->get_package_refno($packageID);
					$errPckgID = $packageID;
					$usrAgent = $this->agent->browser().' at '.$this->input->ip_address();
					$errValue = 'Empty Return Value From API Server';
					$this->errorlog_model->save_error_toDB($errMethod, $errPckgRefNo, $errPckgID, $errValue, $usrAgent);
				/* ==============catch error for method SearchActivityPrice end============= */
			}
		}
	
		
	}
	else{
		//$usiaAnak = array(NULL);
		$errMsg = 'Please fill all the field correctly';
	}
	
	}
	
	
	
echo '
 	<div>
		<div style="display: block; margin-left: auto; margin-right: auto; text-align:center;width:100%;padding:3px;font-weight:bold;color:#FF0000">'.$errMsg.'</div>	
	</div>';



	}
	
	function API_searchprice($actId,$adlt,$childAge,$trdate){
	$snrCtzn= 0;
	$chldAge = json_encode($childAge);
	$crrncy='SGD';
	/*echo "<script>alert(".json_encode($childAge).");</script>";*/
	
	$qryGetDetailsTour= $this->db->query("select * from tours where API_packages_id='$actId' ");
	$jmlDta = $qryGetDetailsTour->num_rows();
	foreach ($qryGetDetailsTour->result() as $row)
	{
	$trid= $row->tour_id;
	$trtp= $row->tour_type;
	$tourDet[] = array('TourID' => $trid, 'TravelDate' => $trdate, 'TourType' =>  $trtp);
	}
	/*	
	$myTour['TourDetails'] = array('Tours' => $tourDet);
	echo '<div style="z-index:5000;position:absolute;top:100px;background:#fff;border:1px red solid;">'.print_r($tourDet).'</div>';
	*/	
	
	$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityWS.asmx?wsdl";
	$SOAP = new SoapClient($WSDL, array('trace' => 1));
	
	$authvalues = array(
		'AgentCode'=>'PTADV',
		'PartnerID'=>'adventure_xml',
		'Culture'=>'en-US',
		'Password'=>'adventure1'
		);
	
	$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, 0);
	$SOAP->__setSoapHeaders(array($header));
	 
	$Data = array(
	   'RequestParam' => array(
		'ActivityID' => $actId,
		'Adult' => $adlt,
		'SeniorCitizen' => $snrCtzn, 
		'Child'=> array(
						  'Age' => $childAge,   
						  //'Age' => array ('3','7'),   
						),
		'Currency' => $crrncy,
		'TourDetails' => array(
							  'Tours' => $tourDet
											  /*
											  'TourID' => '603', 
											  'TravelDate' => $trdate, 
											  'TourType' =>  '18'),
											  */
											  
							
							 )
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
		//$BookURL = $item->BookURL;
		$Adult = $item->Adult;
		$Child = $item->Child;
		$Country = $item->Country;
		$City = $item->City;
		$Currency = $item->Currency;
		$PriceAdult = $item->PriceAdult;
		$PriceChild = $item->PriceChild;
		$PriceSeniorCitizen = $item->PriceSeniorCitizen;
		$TotalAmount = $item->TotalAmount;
		
		 $qryInsrt = $this->db->query("INSERT INTO book_packages(travel_date,usid,API_packages_id,package_name,adult,child,country_code,city_code,currency_code,price_adult,price_child,price_seniorcitizen,total_amount) VALUES('$trdate','$USID','$ActivityID','$ActivityName','$Adult','$Child','$Country','$City','$Currency','$PriceAdult','$PriceChild','$PriceSeniorCitizen','$TotalAmount')");
		}
/* ==================package from API end here========================= */		
}
/* ==================package from manual input start here========================= */
/* else{} */

	}
		
}
?>