<?php
 class Get_Api extends CI_Model
 {
  function Get_Api()
  {
		parent::__construct();
  }
 
  /* Menampilkan Hasil Pencarian */
  function CountryResult($perPage,$uri,$data)
  {		
	$this->API_country();
	/*
		//to get all data in packages
		$this->db->select('*');
		$this->db->from('packages_country');
		$this->db->join('packages_city', 'packages_city.country_iso = packages_country.country_iso');

		$getData = $this->db->get('',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null; 
	*/
  }
  
  /*
  function packageBooking($GuestDetails){
  print_r($GuestDetails);
  }
  */
  
    /*
  function API_bookactivity($GuestDetails){
  
  

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
    'USID' => 'd183e69a-98ea-4dd7-9b1b-9a11f4edcac0',
    'ActivityID' => '736',
    'Adult' => '2', 
	'SeniorCitizen' => '0',
    'Child'=> array(
	                  'Age' => array ('3','7'),     
					),
    'TourDetails' => array(
	                      'Tour' => array(
						                  'TourID' => '401', 
										  'TravelDate' => '2014-07-15', 
										  'TourSession' =>  'MorningTour' 
									)
						 ),
	               
	'Currency' => 'AED',
	'TotalPrice' => '900.9',
	'PickUpDropOffHotel'=> array(
	                            'PickupPointID' => '522',
								'PickupDropOffPoint' => 'YMCA Salisbury Hong Kong Hotel'
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
	'CreditCardInfo'=> array(
	                      'CardType' => 'Visa',
						  'CardHolderName' => 'dsfdsf',
						  'BankName' => 'dfdsf',
						  'CardCountryCode' => '10',
						  'CardNumber' => '45435435',
						  'CardSecurityCode' => '45435',
						  'CardExpiryDate' => '2015-08-20',
						  'CardContactNumber' => 'dfdsfsd',
						  'CardAddress' => 'dsfdsfdsf',
						  'CardAddressPostalCode' => 'dfsdfs',
						  'CardAddressCity' => 'dfsf',
						  'CardAddressCountryCode' => 'sdfdsf'
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

}
  */
  
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


}

function API_packages(){
ini_set( "soap.wsdl_cache_enabled", 0 );
$WSDL1 ="http://ws.asiatravel.net/PartnerPackageWS/ActivityLookUp.asmx?WSDL";
$SOAP1 = new SoapClient($WSDL1, array('trace' => true));
$WSDL2 ="http://ws.asiatravel.net/PartnerPackageWS/ActivityWS.asmx?wsdl";
$SOAP2 = new SoapClient($WSDL2, array('trace' => true));
$authvalues = array(
    'AgentCode'=>'PTADV',
    'PartnerID'=>'adventure_xml',
    'Culture'=>'en-US',
    'Password'=>'adventure1'
    );
$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, false);
$SOAP1->__setSoapHeaders(array($header));
//$Data1 = array('isPackage'=>'1');
$Response1 = $SOAP1->SearchAvailableDestinations();
$string1 = $SOAP1->__getLastResponse();
$xml1 = simplexml_load_string($string1);
$xml1->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
$xml1->registerXPathNamespace('xs', 'http://tempuri.org/');

foreach ($xml1->xpath('//xs:SearchAvailableDestinations1Response/xs:SearchAvailableDestinations1Result/xs:DestinationList/xs:Destination') as $item1)
{
$country_iso = $item1->Country;
$city_iso = $item1->City;
$country_name = $item1->CountryDescription;
$city_name = $item1->CityDescription;
/*
echo '===================<b>'.$item1->CountryDescription.'</b>=====<b>'.$item1->CityDescription.'</b>==========================<br />';*/
/* =============================================================================== */


$SOAP2->__setSoapHeaders(array($header));
     
$Data = array(
    'CountryCode' => $country_iso,
    'CityCode' => $city_iso 	
);
$Response2 = $SOAP2->SearchActivityByDestination($Data );
$string2 = $SOAP2->__getLastResponse();
$xml2 = simplexml_load_string($string2);
$xml2->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
$xml2->registerXPathNamespace('ns', 'http://tempuri.org/');
foreach ($xml2->xpath('//ns:SearchActivityByDestinationResult/ns:Activities/ns:Activity') as $item2)
{
$imagePath = $item2->ImagePath;
$acitvityRefNo = $item2->ActivityRefNo;
$activityId = $item2->ActivityID;
$activityName = $item2->ActivityName;
$activityInclusive = $item2->ActivityInclusive;
$countryCodeISO = $item2->Country;
$cityCodeISO = $item2->City;
$travelValidFrom = $item2->TravelValidFrom;
$travelValidTo = $item2->TravelValidTo;
$currencies = $item2->Currency;
$priceAdult = $item2->PriceAdult;
$priceChild = $item2->PriceChild;
$tourID= $item2->Tours->TourItem->TourID;
$tourName= $item2->Tours->TourItem->TourName;
$tourType= $item2->Tours->TourItem->TourType;
$tourImage= $item2->Tours->TourItem->ImagePath;
$tourChildagefrom= $item2->Tours->TourItem->ChildAgeFrom;
$tourChildageto= $item2->Tours->TourItem->ChildAgeTo;
	
	//start query table packages
	    $qrySlct = mysql_query("select * from packages where API_packages_id='$activityId' AND country ='$country_iso' AND city ='$city_iso'");
		$isAda=mysql_num_rows($qrySlct);
		if($isAda == 0){
		$qryInsrt = mysql_query("INSERT INTO packages(kode,API_packages_id,API_packages_refno,nama,country,city,price,price_adult,price_child,currency,periode_begin,periode_end,gambar,ket,booking_begin,booking_end) VALUES('$acitvityRefNo','$activityId','$acitvityRefNo','$activityName','$countryCodeISO','$cityCodeISO','$priceAdult','$priceAdult','$priceChild','$currencies','$travelValidFrom','$travelValidTo','$imagePath','$activityInclusive','$travelValidFrom','$travelValidTo')");
		}
		else{
		    $field=mysql_fetch_array($qrySlct);
		     $id = $field['packages_id'];
		     
		     $qryUpdt = mysql_query("UPDATE packages SET kode='$acitvityRefNo', API_packages_id = '$activityId', API_packages_refno = '$acitvityRefNo', nama='$activityName',country='$countryCodeISO',city='$cityCodeISO',price='$priceAdult',price_adult='$priceAdult',price_child='$priceChild',currency='$currencies',periode_begin='$travelValidFrom',periode_end='$travelValidTo',gambar='$imagePath',ket='$activityInclusive',booking_begin='$travelValidFrom',booking_end='$travelValidTo' WHERE packages_id = '$id'");
		}
		//start query table packages_city
		$qryslct_pckgs_cty = mysql_query("SELECT * FROM packages_city WHERE country_iso ='$country_iso' AND city_iso ='$city_iso'");
		$isAdaCity=mysql_num_rows($qryslct_pckgs_cty);
		if($isAdaCity == 0){
		$qryInsrt = mysql_query("INSERT INTO packages_city(country_iso,city_iso,city_name,gambar) VALUES('$country_iso','$city_iso','$city_name','$imagePath')");
		}
		else{
		    $field=mysql_fetch_array($qryslct_pckgs_cty);
		     $idy = $field['idy'];
			 $qryUpdt = mysql_query("UPDATE packages_city SET country_iso ='$country_iso',city_iso='$city_iso',city_name='$city_name',gambar='$imagePath'  WHERE idy = '$idy'");
		}
		
		//start query table packages_country
		$qryslct_pckgs_cntry = mysql_query("SELECT * FROM packages_country WHERE country_iso ='$country_iso' ");
		$isAdaCountry=mysql_num_rows($qryslct_pckgs_cntry);
		if($isAdaCountry == 0){
		$qryInsrt = mysql_query("INSERT INTO packages_country(country_iso,country_name,gambar) VALUES('$country_iso','$country_name','$imagePath')");
		}
		else{
		    $field=mysql_fetch_array($qryslct_pckgs_cntry);
		     $idx = $field['idx'];
			 $qryUpdt = mysql_query("UPDATE packages_country SET country_iso ='$country_iso',country_name='$country_name',gambar='$imagePath'  WHERE idx = '$idx'");
		
		}
		
		foreach($item2->Tours->TourItem as $tour){
		   $qryslct = mysql_query("SELECT * FROM tours WHERE tour_id ='$tour->TourID' AND API_packages_id='$activityId' AND API_packages_refno='$acitvityRefNo' ");
		   $isAda=mysql_num_rows($qryslct);
		   if($isAda == 0){
		   $qry = mysql_query("INSERT INTO tours(tour_id,API_packages_id,API_packages_refno,tour_name,tour_type,image_path,child_age_from,child_age_to,tour_category,tour_frequency,transfer_type,pickup_time,tour_start_time,duration) VALUES('$tour->TourID','$activityId','$acitvityRefNo','$tour->TourName','$tour->TourType','$tour->ImagePath','$tour->ChildAgeFrom', '$tour->ChildAgeTo', '$tour->TourCategory', '$tour->TourFrequency', '$tour->TransferType', '$tour->PickupTime', '$tour->TourStartsTime', '$tour->Duration')");
		   }
		   else{
		   $field=mysql_fetch_array($qryslct);
		   $idPointer = $field['id'];
		   $qryUpdt = mysql_query("UPDATE tours SET tour_id ='$tour->TourID',API_packages_id='$activityId',API_packages_refno='$acitvityRefNo',tour_name='$tour->TourName',tour_type='$tour->TourType',image_path='$tour->ImagePath',child_age_from='$tour->ChildAgeFrom',child_age_to='$tour->ChildAgeTo',tour_category='$tour->TourCategory',	tour_frequency='$tour->TourFrequency',transfer_type='$tour->TransferType',pickup_time='$tour->PickupTime',tour_start_time='$tour->TourStartsTime',duration='$tour->Duration' WHERE id = '$idPointer'");
		   }
		}
}
/* =============================================================================== */   
}
} 
    
  
  
  function API_currency(){
  ini_set( "soap.wsdl_cache_enabled", 0 );
  $WSDL ="http://ws.asiatravel.net/HotelB2BAPI/atHotelsService.asmx?WSDL";
$SOAP = new SoapClient($WSDL, array('trace' => true));
$WSDL_wsx ="http://www.webservicex.net/country.asmx?WSDL";
$SOAP_wsx = new SoapClient($WSDL_wsx, array('trace' => true));
$authvalues = array(
    'UserName' => 'adventure_xml',
    'Password' => 'adventure1',
    'Culture' => 'en-US',
    );
$header = new SoapHeader('http://instantroom.com/', "SOAPHeaderAuthentication", $authvalues, false);
$SOAP->__setSoapHeaders(array($header));    
$Response = $SOAP->GetCountryList();
$string = $SOAP->__getLastResponse();
$xml = simplexml_load_string($string);
$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
$xml->registerXPathNamespace('xs', 'http://www.w3.org/2001/XMLSchema');
foreach ($xml->xpath('//Country') as $item)
{
   /*
     echo "<b>Kode :</b>" .$item->CountryISOCode."<br />";
	 echo "<b>Negara:</b>" .$item->CountryName."<br />";*/
     $kdNgraISO = strtolower($item->CountryISOCode);
	 $countryISO = $item->CountryISOCode;



$dtKodneg = array('CountryCode' => $kdNgraISO);
$Response_wsx = $SOAP_wsx->GetCountryByCountryCode($dtKodneg);
$country_wsx = $Response_wsx->GetCountryByCountryCodeResult;
$country_xmlstring = '<?xml version="1.0" encoding="UTF-8"?>'.$country_wsx;
$country_xml = simplexml_load_string($country_xmlstring);
$countryname = $country_xml->Table[0]->name;



$datCurr = array('CountryName' => $countryname);;
$req_curr_code = $SOAP_wsx->GetCurrencyByCountry($datCurr);
$currency = $req_curr_code->GetCurrencyByCountryResult;
$currency_xmlstring = '<?xml version="1.0" encoding="UTF-8"?>'.$currency;
$currency_xml = simplexml_load_string($currency_xmlstring);
$currencycode = $currency_xml->Table[0]->CurrencyCode;
//$currencyname = $currency_xml->Table[0]->Currency;
//$currencycountrycode = strtoupper($currency_xml->Table[0]->CountryCode);
//$currencycountryname = $currency_xml->Table[0]->Name;

/*
echo 'Country Name :'.$currencycountryname.'<br />';
echo 'Country Code :'.$currencycountrycode.'<br />';
echo 'Currency Name :'.$currencyname.'<br />';
echo 'Currency Code :'.$currencycode.'<br />';
echo "<br /><hr /><br />";
*/
$query = mysql_query("select * from currencies where country_iso='$countryISO'");
		$isAda=mysql_num_rows($query);
		if($isAda == 0){
		$qry = mysql_query("INSERT INTO currencies (country_iso,currency) VALUES('$countryISO','$currencycode')");
		}

		else{
		    $field=mysql_fetch_array($query);
		     $id = $field['id'];
		     
		     $qry = mysql_query("UPDATE currencies SET country_iso = '$countryISO', currency = '$currencycode' WHERE id = '$id'");
		    
		}
}

  }
  
  function API_tour_info(){
  $WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityLookUp.asmx?wsdl";
$SOAP = new SoapClient($WSDL, array('trace' => true));

$authvalues = array(
    'AgentCode'=>'PTADV',
    'PartnerID'=>'adventure_xml',
    'Culture'=>'en-US',
    'Password'=>'adventure1'
    );

$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, false);
$SOAP->__setSoapHeaders(array($header));
     
$Data = array(
    'CityCode' => 'DPS' 	 
      );
$Response = $SOAP->GetTourInfoImportantNotes($Data);
$string = $SOAP->__getLastResponse();

$xml = simplexml_load_string($string);
$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
$xml->registerXPathNamespace('ns', 'http://tempuri.org/');
foreach ($xml->xpath('//ns:GetTourInfoImportantNotesResult/ns:TourInfos/ns:TourInfoNotes') as $item)
{
$TourID = $item->TourID;
$TourHighlights = $item->TourHighlights ;
$ImportantNotes = $item->ImportantNotes ;
    
	$qry = mysql_query("SELECT * FROM tour_info WHERE tour_id = '$TourID'");
	$getId = mysql_fetch_array($qry);
	$isAda = mysql_num_rows($qry);
	if($isAda == 0){
		$qry = mysql_query("INSERT INTO tour_info(tour_id,tour_highlights,tour_inportant_notes) VALUES('$TourID','$TourHighlights','$ImportantNotes')");
			
	}
				
	else{
		$qry = mysql_query("UPDATE tour_info SET tour_id='$TourID', tour_highlights ='$TourHighlights', tour_inportant_notes = '$ImportantNotes',  WHERE id = '$getId[id]'");
	}
}
  }
  
  function API_city()
  {
  ini_set( "soap.wsdl_cache_enabled", 0 );
  /*
    echo '<script type="text/javascript">';
  echo 'alery(message successfully sent)';  //not showing an alert box.
  echo '</script>';
	*/
	
	
	$kdN = '$kdNegara[country_iso]';
  	$WSDL ="http://ws.asiatravel.net/HotelB2BAPI/atHotelsService.asmx?WSDL";
	$SOAP = new SoapClient($WSDL, array('trace' => true));
	

	$authvalues = array(
	    'UserName' => 'adventure_xml',
	    'Password' => 'adventure1',
	    'Culture' => 'en-US',
	    );
	    
	$header = new SoapHeader('http://instantroom.com/', "SOAPHeaderAuthentication", $authvalues, false);
	$SOAP->__setSoapHeaders(array($header));
	$qryNegara = mysql_query("select * from country");
	while($kdNegara = mysql_fetch_array($qryNegara))
	{
	
	   $Data = array('CountryCode'=> $kdNegara["country_iso"]);
	   $Response = $SOAP->GetCityListByCountryCode($Data);

	   $string = $SOAP->__getLastResponse();
		 
	    $xml = simplexml_load_string($string);
	    $xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
	    $xml->registerXPathNamespace('xs', 'http://www.w3.org/2001/XMLSchema');
	    $kota = $xml->xpath('//City');
	
	     foreach ($kota as $item)  
	    {
		 
		  $city_iso = $item->CityCode;
		  $city_name = $item->CityName;
		   
			$qryKota = mysql_query("SELECT * FROM city WHERE city_iso = '$city_iso'");
			$getIdy = mysql_fetch_array($qryKota);
			$isAda = mysql_num_rows($qryKota);
				if($isAda == 0){
				$qry = mysql_query("INSERT INTO city (idx,country_iso,city_iso,city_name) VALUES('$kdNegara[idx]','$kdNegara[country_iso]','$city_iso','$city_name')");
				
				}
				
				else{
				$qry = mysql_query("UPDATE city SET idx = '$kdNegara[idx]', country_iso = '$kdNegara[country_iso]', city_iso = '$city_iso', city_name = '$city_name' WHERE city_iso = '$city_iso'");
				}
				
				
		
	    }
		
		
    }
  }
  function API_country()
  {
   ini_set( "soap.wsdl_cache_enabled", 0 );
	$WSDL ="http://ws.asiatravel.net/HotelB2BAPI/atHotelsService.asmx?WSDL";
	$SOAP = new SoapClient($WSDL, array('trace' => true));
	

	$authvalues = array(
	    'UserName' => 'adventure_xml',
	    'Password' => 'adventure1',
	    'Culture' => 'en-US',
	    );
	    
	$header = new SoapHeader('http://instantroom.com/', "SOAPHeaderAuthentication", $authvalues, false);
	$SOAP->__setSoapHeaders(array($header));
		 
	$Response = $SOAP->GetCountryList();

	$string = $SOAP->__getLastResponse();
		 
	$xml = simplexml_load_string($string);
	$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
	$xml->registerXPathNamespace('xs', 'http://www.w3.org/2001/XMLSchema');
	$negara = $xml->xpath('//Country');
	
	foreach ($negara as $item) 
	{
		
		$country_iso = $item->CountryISOCode;
		$country_name = $item->CountryName;
		
		$query = mysql_query("select * from country where country_iso='$country_iso'");
		$isAda=mysql_num_rows($query);
		if($isAda == 0){
		$qry = mysql_query("INSERT INTO country (country_iso,country_name) VALUES('$country_iso','$country_name')");
		}

		else{
		    $field=mysql_fetch_array($query);
		     $id = $field['idx'];
		     
		     $qry = mysql_query("UPDATE country SET country_iso = '$country_iso', country_name = '$country_name' WHERE idx = '$id'");
		    
		}
		
		
	}
   }

  function API_asiatravel($fr,$to,$ct,$cn,$key,$namaAPI)
  {
	$adult = $this->input->post('adult',TRUE);
	$child = $this->input->post('children',TRUE);
	
	$WSDL ="http://ws.asiatravel.net/HotelB2BAPI/atHotelsService.asmx?WSDL";
	$SOAP = new SoapClient($WSDL, array('trace' => true));

	$authvalues = array(
		'UserName' => $namaAPI,
		'Password' => $key,
		'Culture' => 'en-US',
		);
	$header = new SoapHeader('http://instantroom.com/', "SOAPHeaderAuthentication", $authvalues, false);
	$SOAP->__setSoapHeaders(array($header));
		 
	$Data = array(
		'CountryCode'=>$cn,
		'CityCode'=>'SIN',
		'CheckIndate'=>$fr,
		'CheckoutDate'=>$to,
		'NoOfRoom'=>1,
		'NoOfAdult'=>$adult,
		'NoOfChild'=>$child,
		'AllOccupancy'=>1,
		'InstantConfirmationOnly'=>0,
	);
		 
	$Response = $SOAP->SearchHotelsByDest($Data);
	$string = $SOAP->__getLastResponse();
		 
	$xml = simplexml_load_string($string);
	$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
	$xml->registerXPathNamespace('xs', 'http://www.w3.org/2001/XMLSchema');
	foreach ($xml->xpath('//Hotel') as $item)
	{
		$price = $item->AvgPrice;
        $kurs = $item->Room->Currency;
        $requestUrl = "http://www.freecurrencyconverterapi.com/api/convert?q=".$kurs."-IDR&compact=y&callback=?";
        $responseUrl  = file_get_contents($requestUrl);
        $response = str_replace("typeof  === 'function' && ("," ",$responseUrl);
        $response = str_replace(");"," ",$response);
        $responseDecode = json_decode($response, true);
        $currency = $responseDecode[$kurs.'-IDR']['val'];

        $price=(double)$price;
        $currency=(double)$currency;
	
		$rateStar=$item->StarRating;
		$id=$item->HotelCode;
		$hname=$item->HotelName;
		$hadd=$item->Address;
		$hcity=$item->City;
		$rate=substr($rateStar,0,1);
		$hpricefrom=floor($price*$currency);
		$hcurrency='IDR';
		$hdesc=$item->HotelDesc;
		$photo=$item->FrontPgImage;
		 
		$date = date('d/m/y');
		$k = ''; 
		$nmhotel = '';
		
		if($rate)
		{
			if($rate == 1)
			{$G="G1";}
			elseif($rate == 2)
			{$G="G2";}
			elseif($rate == 3)
			{$G="G3";}
			elseif($rate == 4)
			{$G="G4";}
			elseif($rate == 5)
			{$G="G5";}
			elseif($rate == 6)
			{$G="G6";}
			elseif($rate == 7)
			{$G="G7";}
			else
			{$G="G0";}
		}
		
		$query = $this->db->query("select * from hotel where kode like '%$G%' order by kode asc");
		foreach ($query->result() as $row)
		{
		  $k = $row->kode;
		} 
		$kd = substr($k,2,4)+1;
		
		if(($kd>=0)&&($kd<=9))
		{
			$teks = '000';
		}
		elseif(($kd>=10)&&($kd<=99))
		{
			$teks = '00';
		}
		elseif(($kd>=100)&&($kd<=999))
		{
			$teks = '0';
		}
		$kode = $G.$teks.$kd;

		$temu=0;
		$query = mysql_query("select * from hotel");
		while($temu=mysql_fetch_array($query)){
			$namaDB=strtoupper($temu['nama']);
			$namaHA=strtoupper($hname);
			if($namaDB!=$namaHA){
				$dataHotel = array(
						'kode'=>$kode,
						'API_hotel_id'=>$id,
						'nama'=>$hname,
						'grade'=>$rate,					
						'negara'=>$cn,					
						'kota'=>$hcity,
						'alamat'=>$hadd,
						'price_from'=>$hpricefrom,
						'currency'=>$hcurrency,						
						'gambar'=>$photo,
						'ket'=>$hdesc,				
						'date_add'=>$date
				);
				$this->db->insert('hotel',$dataHotel);
			}else{
				$updateHotel = array(
						'nama'=>$hname,
						'grade'=>$rate,					
						'negara'=>$cn,					
						'kota'=>$hcity,
						'alamat'=>$hadd,
						'price_from'=>$hpricefrom,
						'currency'=>$hcurrency,						
						'gambar'=>$photo,
						'ket'=>$hdesc,				
				);
				$this->db->where('API_hotel_id',$id);
				$this->db->update('hotel',$updateHotel);
			}		
		}
	}
  }

}
?>