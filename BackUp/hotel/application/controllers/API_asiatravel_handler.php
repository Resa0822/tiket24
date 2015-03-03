<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class API_asiatravel_handler extends CI_Controller {
 
    function __construct() {
        parent::__construct(); 	
		$this->load->model('asiatravel_model');
    } 
	function ActivityLookUp(){
		$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityLookUp.asmx?WSDL";
		$SOAP = new SoapClient($WSDL, array('trace' => true));
		$authvalues = array(
						    'AgentCode' => $this->asiatravel_model->get_agent_code(),
						    'PartnerID' => $this->asiatravel_model->get_partner_id(),
						    'Culture' => $this->asiatravel_model->get_culture(),
						    'Password' => $this->asiatravel_model->get_password()
	    );
		$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, false);
		$SOAP->__setSoapHeaders(array($header));
		
		return $SOAP;
	}
	
	function ActivityWS(){
		$WSDL ="http://ws.asiatravel.net/PartnerPackageWS/ActivityWS.asmx?wsdl";
		$SOAP = new SoapClient($WSDL, array('trace' => true));
		$authvalues = array(
						    'AgentCode' => $this->asiatravel_model->get_agent_code(),
						    'PartnerID' => $this->asiatravel_model->get_partner_id(),
						    'Culture' => $this->asiatravel_model->get_culture(),
						    'Password' => $this->asiatravel_model->get_password()
	    );
		$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, false);
		$SOAP->__setSoapHeaders(array($header));
		
		return $SOAP;
	}
	
	function SearchActivityByDestination($country_iso = 'KH', $city_iso = 'PNH'){
		$getConn = $this->ActivityWS();
		$activitiesDestination = array();
		$j = 0;
		$Data = array(
					    'CountryCode' => $country_iso,
					    'CityCode' => $city_iso 	
		);
		$Response = $getConn->SearchActivityByDestination($Data);
		$string = $getConn->__getLastResponse();
		$xml = simplexml_load_string($string);
		$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xml->registerXPathNamespace('ns', 'http://tempuri.org/');
		foreach($xml->xpath('//ns:SearchActivityByDestinationResult/ns:Activities/ns:Activity') as $item)
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
			
			foreach($item->Tours->TourItem as $tour){
				$TourID = $tour->TourID;
				$TourName = $tour->TourName;
				$ImagePath = $tour->ImagePath;
				$TravelDateRequired = $tour->TravelDateRequired;
				$TourType = $tour->TourType;
				$TourCategory = $tour->TourCategory;
				$TourFrequency = $tour->TourFrequency;
				$TransferType = $tour->TransferType;
				$ChildAgeFrom = $tour->ChildAgeFrom;
				$ChildAgeTo = $tour->ChildAgeTo;
				$FerryName = $tour->FerryName;
				$FerryTime = $tour->FerryTime;
				$PickupTime = $tour->PickupTime;
				$TourStartsTime = $tour->TourStartsTime;
				$Duration = $tour->Duration;
				
			}
			$activitiesDestination[$j]['ActivityRefNo'][$j] = $ActivityRefNo;
			
			
			//$activitiesDestination[$j]['country_name'][$j] = $country_name;
			//$activitiesDestination[$j]['city_iso'][$j] = $city_iso;
			//$activitiesDestination[$j]['city_name'][$j] = $city_name;
			
			$j++;
		}
		echo json_encode($activitiesDestination);
	}
	
	function SearchAvailableDestinations($country_iso, $city_iso){
		$getConn = $this->ActivityLookUp();
		$countryCity = array();
		$j = 0;
		$Response = $getConn->SearchAvailableDestinations();
		$string = $getConn->__getLastResponse();
		$xml = simplexml_load_string($string);
		$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xml->registerXPathNamespace('xs', 'http://tempuri.org/');
		foreach ($xml->xpath('//xs:SearchAvailableDestinations1Response/xs:SearchAvailableDestinations1Result/xs:DestinationList/xs:Destination') as $item)
		{
			$country_iso = $item->Country;
			$city_iso = $item->City;
			$country_name = $item->CountryDescription;
			$city_name = $item->CityDescription;
			
			$countryCity[$j]['country_iso'][$j] = $country_iso;
			$countryCity[$j]['country_name'][$j] = $country_name;
			$countryCity[$j]['city_iso'][$j] = $city_iso;
			$countryCity[$j]['city_name'][$j] = $city_name;
			
			$j++;
		}
		return $countryCity;
	}
	
	function save_country_city(){
		$getCountryCity = $this->SearchAvailableDestinations();
		$i=0;
		foreach($getCountryCity as $row){
			$country_iso = $row['country_iso'][$i];
			$country_name = $row['country_name'][$i];
			$city_iso = $row['city_iso'][$i];
			$city_name = $row['city_name'][$i];
			$arrData = array(
							'country_iso' => "$country_iso",
							'country_name' => "$country_name",
							'city_iso' => "$city_iso",
							'city_name' => "$city_name"
						);
			$this->asiatravel_model->save_country_city($arrData);
			//echo $row['country_iso'][$i].' - '.$row['country_name'][$i].' - '.$row['city_iso'][$i].' - '.$row['city_name'][$i].'<br />';
		$i++;
		}
		
	}
	
	function country_city(){
		$getCountryCity = $this->get_country_city();
		$i=0;
		foreach($getCountryCity as $row){
			echo $row['country_iso'][$i].' - '.$row['country_name'][$i].' - '.$row['city_iso'][$i].' - '.$row['city_name'][$i].'<br />';
		$i++;
		}
	}
	
}	