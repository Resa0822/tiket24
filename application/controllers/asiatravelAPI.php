<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class AsiatravelAPI extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function API_asiatravel_ActivityWS(){
	/* for method  
	 * BookActivity, GetPickupPointList, GetUSSBlockoutDateByYear, SearchActivityByDestination, SearchActivityPrice
	*/
		$WSDL ="http://packages.asiatravel.com/PackagePartnerWSv2/ActivityWS.asmx?wsdl";
		///$WSDL ="http://ws.asiatravel.net/PartnerPackageWSv2/ActivityWS.asmx?wsdl";
		//$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityWS.asmx?wsdl";
		$SOAP = new SoapClient($WSDL, array("trace" => 1, "exception" => 0));
		$authvalues = array(
				'AgentCode'=>'PT Adventure Tour',
				'PartnerID'=>'adventure_xml',
				'Culture'=>'en-US',
				'Password'=>'sales*889'
				);
		$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, 0);
		$SOAP->__setSoapHeaders(array($header));
		
		return $SOAP;
	}
	function API_asiatravel_ActivityLookUp(){
	/* for method  
	 * GetTourInfoImportantNotes, SearchAvailableDestinations 
	*/
		$WSDL ="http://packages.asiatravel.com/PackagePartnerWSv2/ActivityLookUp.asmx?wsdl";
		///$WSDL ="http://ws.asiatravel.net/PartnerPackageWSv2/ActivityLookUp.asmx?wsdl";
		//$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityLookUp.asmx?wsdl";
		$SOAP = new SoapClient($WSDL, array("trace" => 1, "exception" => 0));
		$authvalues = array(
				'AgentCode'=>'PT Adventure Tour',
				'PartnerID'=>'adventure_xml',
				'Culture'=>'en-US',
				'Password'=>'sales*889'
				);
		$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, 0);
		$SOAP->__setSoapHeaders(array($header));
		
		return $SOAP;
	}

	function SearchAvailableDestinations(){
		$SOAP = $this->API_asiatravel_ActivityLookUp();	
		$Response = $SOAP->SearchAvailableDestinations();
		$string = $SOAP->__getLastResponse();
		$xml = simplexml_load_string($string);
		$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xml->registerXPathNamespace('xs', 'http://tempuri.org/');
		$i=0;
		$arrDta = array();
		foreach ($xml->xpath('//xs:SearchAvailableDestinations1Response/xs:SearchAvailableDestinations1Result/xs:DestinationList/xs:Destination') as $item)
		{
			$country_iso = $item->Country;
			$city_iso = $item->City;
			$country_name = $item->CountryDescription;
			$city_name = $item->CityDescription;
			
			$dtaRspnse[$i] = array('CountryISO'=>$country_iso, 'Country'=>$country_name, 'CityISO'=>$city_iso, 'City'=>$city_name);
						
			$i++;
		}
	
		$arrDta = array($dtaRspnse);
		return $dtaRspnse;	
	}
	
	function SearchActivityByDestination($country_iso,$city_iso){
		$SOAP = $this->API_asiatravel_ActivityWS();	
		$Data = array(
    			'CountryCode' => $country_iso,
    			'CityCode' => $city_iso 	
				);
		$Response = $SOAP->SearchActivityByDestination($Data );
		$string = $SOAP->__getLastResponse();
		$i=0;
		$arrDta = array();
		$xml = simplexml_load_string($string);
		$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xml->registerXPathNamespace('ns', 'http://tempuri.org/');
		foreach ($xml->xpath('//ns:SearchActivityByDestinationResult/ns:Activities/ns:Activity') as $item)
		{
			$ActivityRefNo = $item->ActivityRefNo;
			$ActivityID = $item->ActivityID; 
			$ActivityName = $item->ActivityName; 
			$ImagePath = $item->ImagePath; 
			$ActivityInclusive = $item->ActivityInclusive; 
			$Country = $item->Country; 
			$City = $item->City; 
			$MinPax = $item->MinPax; 
			$MaxPax = $item->MaxPax; 
			$AdvancePurchasePeriod = $item->AdvancePurchasePeriod; 
			$TravelValidFrom = $item->TravelValidFrom; 
			$TravelValidTo = $item->TravelValidTo; 
			$Currency = $item->Currency; 
			$PriceAdult = $item->PriceAdult; 
			$PriceChild = $item->PriceChild; 
			$PriceSeniorCitizen = $item->PriceSeniorCitizen; 
			$CancellationPolicy = $item->CancellationPolicy; 
			$BookingType = $item->BookingType; 
				
			
			
			$dtaRspnse[$i] = array(
			'ActivityRefNo' => $ActivityRefNo, 
			'ActivityID' => $ActivityID, 
			'ActivityName' => $ActivityName, 
			'ImagePath' => $ImagePath,
			'ActivityInclusive' => $ActivityInclusive,
			'Country' => $Country,
			'City' => $City,
			'MinPax' => $MinPax,
			'MaxPax' => $MaxPax,
			'AdvancePurchasePeriod' => $AdvancePurchasePeriod,
			'TravelValidFrom' => $TravelValidFrom,
			'TravelValidTo' => $TravelValidTo,
			'Currency' => $Currency,
			'PriceAdult' => $PriceAdult,
			'PriceChild' => $PriceChild,
			'PriceSeniorCitizen' => $PriceSeniorCitizen,
			'CancellationPolicy' => $CancellationPolicy,
			'BookingType' => $BookingType
			);
			
			$i++;
		}
	
		//$arrDta = array($dtaRspnse);
		if(!empty($dtaRspnse)){
			return $dtaRspnse;	
		}
		else{
			return false;
		}
		
	}
	
	
	function SearchActivityByDestination_response(){
		$dta = $this->SearchAvailableDestinations();
		foreach($dta as $row){
			$dtaSABD = $this->SearchActivityByDestination($row['CountryISO'],$row['CityISO']);
			if($dtaSABD !== false){
				foreach($dtaSABD as $rowSABD){
				
					$ActivityRefNo = $rowSABD['ActivityRefNo'];
					$ActivityID = $rowSABD['ActivityID'];
					$ActivityName = $rowSABD['ActivityName'];
					$ImagePath = $rowSABD['ImagePath'];
					$ActivityInclusive = $rowSABD['ActivityInclusive'];
					$Country = $rowSABD['Country'];
					$City = $rowSABD['City'];
					$MinPax = $rowSABD['MinPax'];
					$MaxPax = $rowSABD['MaxPax'];
					$AdvancePurchasePeriod = $rowSABD['AdvancePurchasePeriod'];
					$TravelValidFrom = $rowSABD['TravelValidFrom'];
					$TravelValidTo = $rowSABD['TravelValidTo'];
					$Currency = $rowSABD['Currency'];
					$PriceAdult = $rowSABD['PriceAdult'];
					$PriceChild = $rowSABD['PriceChild'];
					$PriceSeniorCitizen = $rowSABD['PriceSeniorCitizen'];
					$CancellationPolicy = $rowSABD['CancellationPolicy'];
					$BookingType = $rowSABD['BookingType'];
					
					$CountryISO = $row['CountryISO'];
					$CountryName = $row['Country'];
					$CityISO = $row['CityISO'];
					$CityName = $row['City'];
					
					/*
					$dtCntry = array(
					   'country_iso' => "$CountryISO",
					   'country_name' => "$CountryName",
					   'gambar' => "$ImagePath"
						);
					$this->db->insert('packages_country', $dtCntry); 
					
					$dtCty = array(
					   'country_iso' => "$CountryISO",
					   'city_iso' => "$CityISO",
					   'city_name' => "$CityName",
					   'gambar' => "$ImagePath"
					);
					$this->db->insert('packages_city', $dtCty); 
					*/
					
				$qryPckge = $this->db->get_where('packages', array('API_packages_refno'=>"$ActivityRefNo", 'API_packages_id'=>"$ActivityID"));
				$publ = array(
						'publish' => '0'
					);
					$this->db->where_in(array('isFromAPI' => '1', 'API_packages_refno' => "$ActivityRefNo",'API_packages_id' => "$ActivityID",'kode' => "$ActivityRefNo"));
					$this->db->update('packages',$publ);
					
				if($qryPckge->num_rows() == '0'){	
					
					$dtPckge = array(
					   'API_packages_refno' => "$ActivityRefNo",
					   'API_packages_id' => "$ActivityID",
					   'kode' => "$ActivityRefNo",
					   'nama' => "$ActivityName",
					   'gambar' => "$ImagePath",
					   'ket' => "$ActivityInclusive",
					   'country' => "$Country",
					   'city' => "$City",
					   'price' => "$PriceAdult",
					   'price_adult' => "$PriceAdult",
					   'price_child' => "$PriceChild",
					   'currency' => "$Currency",
					   'periode_begin' => "$TravelValidFrom",
					   'periode_end' => "$TravelValidTo",
					   'booking_begin' => "$TravelValidFrom",
					   'booking_end' => "$TravelValidTo",
					   'minPax' => "$MinPax",
					   'maxPax' => "$MaxPax",
					   'advanced_purchase_period' => "$AdvancePurchasePeriod",
					   'cancellation_policy' => "$CancellationPolicy",
					   'booking_type' => "$BookingType",
					   'publish' => '1',
					   'isFromAPI' => '1',
					);
					
					$this->db->insert('packages', $dtPckge); 
				//	echo "insert <br/> ";
				}else{
					
					$dtPckge = array(
					   'nama' => "$ActivityName",
					   'gambar' => "$ImagePath",
					   'ket' => "$ActivityInclusive",
					   'country' => "$Country",
					   'city' => "$City",
					   'price' => "$PriceAdult",
					   'price_adult' => "$PriceAdult",
					   'price_child' => "$PriceChild",
					   'currency' => "$Currency",
					   'periode_begin' => "$TravelValidFrom",
					   'periode_end' => "$TravelValidTo",
					   'booking_begin' => "$TravelValidFrom",
					   'booking_end' => "$TravelValidTo",
					   'minPax' => "$MinPax",
					   'maxPax' => "$MaxPax",
					   'advanced_purchase_period' => "$AdvancePurchasePeriod",
					   'cancellation_policy' => "$CancellationPolicy",
					   'booking_type' => "$BookingType",
					   'publish' => '1',
					   'isFromAPI' => '1',
					   
					);
					
				//	echo "update <br/> $ActivityRefNo - $ActivityID - $ActivityRefNo <br/>";
					
					$this->db->where(array('API_packages_refno' => "$ActivityRefNo",'API_packages_id' => "$ActivityID",'kode' => "$ActivityRefNo"));
					$this->db->update('packages',$dtPckge);
				
				}
				/*	
					echo $row['CountryISO'].' - '.$row['CityISO'].' => ';
					echo $rowSABD['ActivityRefNo'].' - '.$rowSABD['ActivityID'].' - '.$rowSABD['ActivityName'].' - '.$rowSABD['ImagePath'].'<br />';
				*/
				}
			}
		}
	}

	
	function SearchAvailableDestinations_response(){
		$dta = $this->SearchAvailableDestinations();
		foreach($dta as $row){
			//echo $row['CountryISO'].' - '.$row['Country'].' - '.$row['CityISO'].' - '.$row['City'].'<br />';
			$CountryISO = $row['CountryISO'];
			$Country = $row['Country'];
			$CityISO = $row['CityISO'];
			$City = $row['City'];
			
			$qryCty = $this->db->get_where('packages_city', array('country_iso'=>"$CountryISO", 'city_iso'=>"$CityISO"));
			if($qryCty->num_rows() == '0'){
				$dtCty = array(
					   'country_iso' => "$CountryISO",
					   'city_iso' => "$CityISO",
					   'city_name' => "$City",
					   //'gambar' => "$ImagePath"
					);
				$this->db->insert('packages_city', $dtCty); 
			}
			
			$qryCntry = $this->db->get_where('packages_country', array('country_iso'=>"$CountryISO"));
			if($qryCntry->num_rows() == '0'){
			$dtCntry = array(
					   'country_iso' => "$CountryISO",
					   'country_name' => "$Country",
					  // 'gambar' => "$ImagePath"
						);
			$this->db->insert('packages_country', $dtCntry); 
			}
		}
	}


}