<?php
$WSDL1 ="http://ws.asiatravel.net/PartnerPackageWS/ActivityLookUp.asmx?WSDL";
		$SOAP1 = new SoapClient($WSDL1, array('trace' => true));
	
		$authvalues = array(
	    	'AgentCode'=>'PTADV',
	    	'PartnerID'=>'adventure_xml',
	    	'Culture'=>'en-US',
	    	'Password'=>'adventure1'
	    );
		$header = new SoapHeader('http://tempuri.org/', "SOAPHeaderAuth", $authvalues, false);
		$SOAP1->__setSoapHeaders(array($header));
		$Data1 = array('isPackage'=>'1');
		$Response1 = $SOAP1->SearchAvailableDestinations($Data1);
		$string1 = $SOAP1->__getLastResponse();
		$xml1 = simplexml_load_string($string1);
		$xml1->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
		$xml1->registerXPathNamespace('xs', 'http://tempuri.org/');
	
		foreach ($xml1->xpath('//xs:SearchAvailableDestinations1Response/xs:SearchAvailableDestinations1Result/xs:DestinationList/xs:Destination') as $item1)
		{
			$country_iso = $item1->Country;
			$city_iso = $item1->City;
			
		//if($country_iso !== 'AU')
		//{	
			$WSDL2 ="http://ws.asiatravel.net/PartnerPackageWS/ActivityWS.asmx?wsdl";
			$SOAP2 = new SoapClient($WSDL2, array('trace' => true));
			
			$SOAP2->__setSoapHeaders(array($header));
			     
			$Data = array(
			    'CountryCode' => $country_iso,
			    'CityCode' => $city_iso 	
			);
			$Response2 = $SOAP2->SearchActivityByDestination($Data);
			$string2 = $SOAP2->__getLastResponse();
			$xml2 = simplexml_load_string($string2);
			$xml2->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
			$xml2->registerXPathNamespace('ns', 'http://tempuri.org/');
				foreach ($xml2->xpath('//ns:SearchActivityByDestinationResult/ns:Activities/ns:Activity') as $item2)
				{
					$acttvtyID = $item2->ActivityID;
					
					foreach($item2->Tours->TourItem as $tour){
						$tourTime = $tour->PickupTime;
						if($tourTime !== NULL){
							$DataPickUpPoint = array(
						                             'ActivityID' => $acttvtyID,
						                            );
							$Response3 = $SOAP2->GetPickupPointList($DataPickUpPoint);
						    $string3 = $SOAP2->__getLastResponse();
							$xml3 = simplexml_load_string($string3);
						    $xml3->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
						    $xml3->registerXPathNamespace('ns', 'http://tempuri.org/');
							
						    	foreach ($xml3->xpath('//ns:GetPickupPointListResult/ns:PickUpPointList/ns:PickUpPoint') as $item3)
						    	{
						    		$hotelCode = $item3->HotelCode;
									$hotelName = $item3->HotelName;
									$nmHotel = str_replace("'"," ",$hotelName);
						    		//get model						
						    
			$qry = $this->db->query("INSERT INTO pickup_point(API_packages_id,hotel_code,hotel_name) VALUES('$acttvtyID','$hotelCode','$nmHotel')");
		
						    	}
						}	
					}
				    
				}
		//}	
		}
?>