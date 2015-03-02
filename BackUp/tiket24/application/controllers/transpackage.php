<?php
class Transpackage extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
	}
    function API_asiatravel_ActivityWS(){
	/* for method  
	 * BookActivity, GetPickupPointList, GetUSSBlockoutDateByYear, SearchActivityByDestination, SearchActivityPrice
	*/
		$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityWS.asmx?wsdl";
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
		$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityLookUp.asmx?wsdl";
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
/* ActivityLookUp method group start here */	
	function API_asiatravel_SearchAvailableDestinations(){
	$SOAP = $this->API_asiatravel_ActivityLookUp();
	$Data = array('isPackage'=>'0');
	$hasil = array();
		$Response = $SOAP->SearchAvailableDestinations($Data);
		$string = $SOAP->__getLastResponse();
		$xml = simplexml_load_string($string);
		$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xml->registerXPathNamespace('xs', 'http://tempuri.org/');
		$i=0;
		foreach($xml->xpath('//xs:SearchAvailableDestinations1Response/xs:SearchAvailableDestinations1Result/xs:DestinationList/xs:Destination') as $item)
		{
			$hasil[] = array($i => array(
										'countryCode' => $item->Country,
										'countryName' => $item->CountryDescription,
										'cityCode' => $item->City,
										'cityName' => $item->CityDescription
										),
								);
		$i++;
		}
		//return $hasil;
			
			$j=0;
			foreach($hasil as $row){
				echo $row[$j]['cityName'].' - '.$row[$j]['countryName'].'<br />';
			$j++;
			}
		
	}
	function API_asiatravel_GetTourInfoImportantNotes_byCity($cityCode){
	$SOAP_byCity = $this->API_asiatravel_ActivityLookUp();
	$Data_byCity = array('CityCode'=>$cityCode);
	$hasil = array();
		$Response_byCity = $SOAP_byCity->GetTourInfoImportantNotes($Data_byCity);
		$string_byCity = $SOAP_byCity->__getLastResponse();
		$xml_byCity = simplexml_load_string($string_byCity);
		$xml_byCity->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xml_byCity->registerXPathNamespace('ns', 'http://tempuri.org/');
		$i=0;
		foreach($xml_byCity->xpath('//ns:GetTourInfoImportantNotesResult/ns:TourInfos/ns:TourInfoNotes') as $item_byCity)
		{
			$hasil[] = array($i => array(
										 'cityCode' => $cityCode,
										 'TourID' => $item_byCity->TourID,
									   	 'TourHighlights' => $item_byCity->TourHighlights,
									     'ImportantNotes' => $item_byCity->ImportantNotes
										),
								);
		$i++;
		}
		//return $hasil_byCity;
			
			$j=0;
			foreach($hasil as $row){
				echo $row[$j]['cityCode'].' - '.$row[$j]['TourID'].' - '.$row[$j]['TourHighlights'].'<br />';
			$j++;
			}
		
	}
	function API_asiatravel_GetTourInfoImportantNotes_allCity(){
	$cityList = $this->API_asiatravel_SearchAvailableDestinations();
		if(!empty($cityList)){
			$j=0;
			foreach($cityList as $row){
				$cityCode = $row[$j]['cityCode'];
				//echo $cityCode.'<br />';
				$getTourInfoImportantNotes_byCity = $this->API_asiatravel_GetTourInfoImportantNotes_byCity($cityCode);
				$i=0;
				foreach($getTourInfoImportantNotes_byCity as $items){
					echo $items[$i]['cityCode'].' - '.$items[$i]['TourID'].' - '.$items[$i]['TourHighlights'].'<br />';
				$i++;
				}
			$j++;
			}
			/*
			$k=0;
			foreach($hasil as $rw){
				echo $rw[$k]['cityCode'].' - '.$rw[$k]['TourID'].' - '.$rw[$k]['TourHighlights'].'<br />';
			$k++;
			}
			*/
		}
	}
/* ActivityLookUp method group end here */	

/* ActivityWS method group start here */		
	function API_asiatravel_packagesearch($pckgID,$adultPAX,$arrChildAge,$arrTours,$travelDate){
	$SOAP = $this->API_asiatravel_ActivityWS();
		$i=0;
		$arrChildAge = array();
		$chldAge = array();
		foreach($arrChildAge as $chldAge){
			$chldAge[$i] = $chldAge;
		$i++;
		}
		$arrChildAge = array('Age' => $chldAge);
		foreach ($qryGetDetailsTour->result() as $row)
		{
			$trid= $row->tour_id;
			$trtp= $row->tour_type;
			$tourDet[] = array('TourID' => $trid, 'TravelDate' => $travelDate, 'TourType' =>  $trtp);
		}	
		$Data = array('RequestParam' => array(
				'ActivityID' => "$pckgID",
				'Adult' => "$adultPAX",
				'SeniorCitizen' => '0', 
				'Child'=> $arrChildAge,
				'Currency' => 'SGD',
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
			$i=0;		
			foreach ($xml->xpath('//ns:SearchActivityPriceResult/ns:ActivitiePrice') as $item)
			{
				$hasil[] = array($i => array(
										 'USID' => $item->USID,
										 'ActivityID' => $item->ActivityID,
									   	 'ActivityName' => $item->ActivityName,
									     'BookURL' => $item->BookURL,
										 'Adult' => $item->Adult,
										 'Child' => $item->Child,
										 'Country' => $item->Country,
										 'City' => $item->City,
										 'Currency' => $item->Currency,
										 'PriceAdult' => $item->PriceAdult,
										 'PriceChild' => $item->PriceChild,
										 'PriceSeniorCitizen' => $item->PriceSeniorCitizen,
										 'TotalAmount' => $item->TotalAmount,
										),
								);
			$i++;
			}
			return $hasil;
	}
	function asiatravel_SearchActivityByDestination($country_iso, $city_iso){
	$SOAP = $this->API_asiatravel_ActivityWS();
		$Data = array(
			'CountryCode' => $country_iso,
			'CityCode' => $city_iso 	
		);
		$Response = $SOAP->SearchActivityByDestination($Data);
		$string = $SOAP->__getLastResponse();
		$xml = simplexml_load_string($string);
		$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xml->registerXPathNamespace('ns', 'http://tempuri.org/');
		$i=0;
		foreach($xml->xpath('//ns:SearchActivityByDestinationResult/ns:Activities/ns:Activity') as $item)
		{
			$pckgImagePath = $item->ImagePath;
			$ActivityRefNo = $item->ActivityRefNo;
			$hasil[] = array($i => array(
										'pckgImagePath' => $item->USID,
										'ActivityRefNo' => $item->ActivityRefNo,
									   	'ActivityID' => $item->ActivityID,
										'ActivityName' => $item->ActivityName,
										'ActivityInclusive' => $item->ActivityInclusive,
										'Country' => $item->Country,
										'City' => $item->City,
										'MinPax' => $item->MinPax,
										'MaxPax' => $item->MaxPax,
										'AdvancePurchasePeriod' => $item->AdvancePurchasePeriod,
										'TravelValidFrom' => $item->TravelValidFrom,
										'TravelValidTo' => $item->TravelValidTo,
										'Currency' => $item->Currency,
										'PriceAdult' => $item->PriceAdult,
										'PriceChild' => $item->PriceChild,
										'PriceSeniorCitizen' => $item->PriceSeniorCitizen,
										'BookingType' => $item->BookingType
										
										),
								);
			$i++;
			
			foreach($item->Tours->TourItem as $tour){
			echo '<img src="'.$tour->ImagePath.'" /><br />';
			 echo "<b>TourID :</b> " .$tour->TourID."<br />";
			 echo "<b>TourName :</b> " .$tour->TourName."<br />";
			 echo "<b>ImagePath :</b> " .$tour->ImagePath."<br />";
			 echo "<b>TravelDateRequired :</b> " .$tour->TravelDateRequired."<br />";
			 echo "<b>TourType :</b> " .$tour->TourType."<br />";
			 echo "<b>TourCategory :</b> " .$tour->TourCategory."<br />";
			 echo "<b>TourFrequency :</b> " .$tour->TourFrequency."<br />";
			 echo "<b>TransferType :</b> " .$tour->TransferType."<br />";
			 echo "<b>ChildAgeFrom :</b> " .$tour->ChildAgeFrom."<br />";
			 echo "<b>ChildAgeTo :</b> " .$tour->ChildAgeTo."<br />";
			  echo "<b>FerryName :</b> " .$tour->FerryName."<br />";
			  echo "<b>FerryTime :</b> " .$tour->FerryTime."<br />";
			   echo "<b>PickupTime :</b> " .$tour->PickupTime."<br />";
			   echo "<b>TourStartsTime :</b> " .$tour->TourStartsTime."<br />";
			   echo "<b>Duration :</b> " .$tour->Duration."<br />";
			}
			 echo "<br /><hr /><br />";
		}
	}
	
	function API_asiatravel_BookActivity($ActivityID, $adultPax, $childPaxAge, $arrToursList, $currency, $travelDate){
		$SOAP = $this->API_asiatravel_ActivityWS();
		
		$i=0;
		$arrChildAge = array();
		$chldAge = array();
		foreach($childPaxAge as $chldAge){
			$chldAge[$i] = $chldAge;
			$i++;
		}
		$arrChildAge = array('Age' => $chldAge);
		
		$qryGetDetailsTour = $this->db->get_where('tours', array('API_packages_id' => $ActivityID));
		foreach ($qryGetDetailsTour->result() as $row)
		{
			$trid= $row->tour_id;
			$trtp= $row->tour_type;
			$tourDet[] = array('TourID' => $trid, 'TravelDate' => $travelDate, 'TourType' =>  $trtp);
		}	
		
		$Data = array(
		   'RequestParam' => array(
			'ActivityID' => $ActivityID,
			'Adult' => $adultPax,
			'SeniorCitizen' => '0', 
			'Child'=> $arrChildAge,
			'Currency' => $currency,
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
		
			$qryGetDetailsTourBooking = $this->db->get_where('tours', array('API_packages_id' => $ActivityID));
			foreach ($qryGetDetailsTourBooking->result() as $fldBking)
			{
				$tridBkng = $fldBking->tour_id;
				$tourCtgry = $fldBking->tour_category;
				$qryTurCtgry = $this->db->get_where('tour_category', array('category_id' => $tourCtgry));
				foreach($qryTurCtgry->result() as $fldTurCtgry){
					$ctgryName = $fldTurCtgry->category_name;
				}
				if($tourCtgry == '1112'){
					$tourCtgryName = 'MorningTour';
				}else{
					$tourCtgryName = $ctgryName;
				}
				$tourDetBkng[] = array('TourID' => $tridBkng, 'TravelDate' => $travelDate, 'TourSession' =>  $tourCtgryName);
			}
		
		$dataBooking = array(
			'RequestParam' => array(
			'USID' => $USID,
			'ActivityID' => $ActivityID,
			'Adult' =>  $adultPax, 
			'SeniorCitizen' => '0',
			'Child'=> $arrChildAge,
			'TourDetails' => array(
								  'Tour' => $tourDetBkng
								 ),
			'Currency' => $currency,
			'TotalPrice' => $TotalAmount,
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
							
				'LeadTravelerInfo' => $travelerLeader,
				'ContactInfo' => $arrTravelerContact,
				'PickUpDropOffHotel' => $arrPickupPoint,
				'FlightInfo' => $arrFlightInfo,
				'CreditCardInfo' => $arrCreditCardInfo,
				),
		);
		
				$Response = $SOAP->BookActivity($dataBooking);
				$stringBooking = $SOAP->__getLastResponse();
				$xmlBooking = simplexml_load_string($stringBooking);
				$xmlBooking->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
				$xmlBooking->registerXPathNamespace('ns', 'http://tempuri.org/');
				foreach ($xmlBooking->xpath('//ns:BookActivityResult') as $itemBooking)
				{
					 echo "<b>USID : </b>".$itemBooking->USID.'<br />';
					 echo "<b>ActivityID : </b>".$itemBooking->ActivityID.'<br />';
					 echo "<b>BookingStatus : </b>".$itemBooking->BookingStatus.'<br />';
					 echo "<b>ConfirmationNumber : </b>".$itemBooking->ConfirmationNumber.'<br />';
					 echo "<b>Currency : </b>".$itemBooking->Currency.'<br />';
					 echo "<b>TotalPrice : </b>".$itemBooking->TotalPrice.'<br />';
					 
					 echo "<br /><hr /><br />";
				}
		
		}
	}
/* ActivityWS method group end here */
}
