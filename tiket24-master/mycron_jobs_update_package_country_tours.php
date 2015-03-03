<?php

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
		$acitvityRefNo = $item2->ActivityRefNo;
		$activityId = $item2->ActivityID;
		$activityName = $item2->ActivityName;
		$imagePath = $item2->ImagePath;
		$activityInclusive = $item2->ActivityInclusive;
		$countryCodeISO = $item2->Country;
		$cityCodeISO = $item2->City;
		$travelValidFrom = $item2->TravelValidFrom;
		$travelValidTo = $item2->TravelValidTo;
		$currencies = $item2->Currency;
		$priceAdult = $item2->PriceAdult;
		$priceChild = $item2->PriceChild;
		
		$trvlrMinPAX = $item2->MinPax;
		$trvlrMaxPAX = $item2->MaxPax;
		$advncPrchsPrde = $item2->AdvancePurchasePeriod;
		$cnclltnPlcy = $item2->CancellationPolicy;
		$bkngType = $item2->BookingType;
		
			//start query table packages
			    $qrySlctPckgs = mysql_query("select * from packages where API_packages_id='$activityId' AND country ='$country_iso' AND city ='$city_iso'");
				$isAda=mysql_num_rows($qrySlctPckgs);
				$fieldPckgs=mysql_fetch_array($qrySlctPckgs);
				$idPckgs = $fieldPckgs['packages_id'];
			    $cntryCodePckgs = $fieldPckgs['country'];
				$ctyCodePckgs = $fieldPckgs['city'];
				if($isAda == 0){
					$data = array(
					   'API_packages_refno' => "$acitvityRefNo",
					   'API_packages_id' => "$activityId",
					   'kode' => "$acitvityRefNo",
					   'nama' => "$activityName",
					   'gambar' => "$imagePath",
					   'ket' => "$activityInclusive",
					   'country' => "$countryCodeISO",
					   'city' => "$cityCodeISO",
					   'price' => "$priceAdult",
					   'price_adult' => "$priceAdult",
					   'price_child' => "$priceChild",
					   'currency' => "$currencies",
					   'periode_begin' => "$travelValidFrom",
					   'periode_end' => "$travelValidTo",
					   'booking_begin' => "$travelValidFrom",
					   'booking_end' => "$travelValidTo",
					   'minPax' => "$trvlrMinPAX",
					   'maxPax' => "$trvlrMaxPAX",
					   'advanced_purchase_period' => "$advncPrchsPrde",
					   'cancellation_policy' => "$cnclltnPlcy",
					   'booking_type' => "$bkngType",
					   
					   'isFromAPI' => '1',/*
					   'package' => '',
					   'discount' => '0',
					   'margin_rp' => '0',
					   'margin_pr' => '0',
					   'file_path' => '',
					   'telepon1' => '',
					   'telepon2' => '',
					   'fax' => '',
					   'email' => '',
					   'desc' => '',
					   'orders' => '1',
					   'publish' => '1',
					   'fasilitas' => '1',
					   'sar' => '1',
					   'google_map' => '1',
					   'user_add' => '',
					   'user_ch' => '',
					   'date_add' => '',
					   'date_ch' => '',*/
					);
					
					$this->db->insert('packages', $data); 
				//$qryInsrt = mysql_query("INSERT INTO packages(isFromAPI,kode,API_packages_id,API_packages_refno,nama,country,city,price,price_adult,price_child,currency,periode_begin,periode_end,gambar,ket,booking_begin,booking_end) VALUES('1','$acitvityRefNo','$activityId','$acitvityRefNo','$activityName','$countryCodeISO','$cityCodeISO','$priceAdult','$priceAdult','$priceChild','$currencies','$travelValidFrom','$travelValidTo','$imagePath','$activityInclusive','$travelValidFrom','$travelValidTo')");
				}
				/*
				elseif(($country_iso !== $cntryCodePckgs) && ($city_iso !== $ctyCodePckgs)){
				   $qryDel = mysql_query("DELETE FROM packages WHERE packages_id='$idPckgs'");
				}
				*/
				else{
					$data = array(
					   'API_packages_refno' => "$acitvityRefNo",
					   'API_packages_id' => "$activityId",
					   'kode' => "$acitvityRefNo",
					   'nama' => "$activityName",
					   'gambar' => "$imagePath",
					   'ket' => "$activityInclusive",
					   'country' => "$countryCodeISO",
					   'city' => "$cityCodeISO",
					   'price' => "$priceAdult",
					   'price_adult' => "$priceAdult",
					   'price_child' => "$priceChild",
					   'currency' => "$currencies",
					   'periode_begin' => "$travelValidFrom",
					   'periode_end' => "$travelValidTo",
					   'booking_begin' => "$travelValidFrom",
					   'booking_end' => "$travelValidTo",
					   'minPax' => "$trvlrMinPAX",
					   'maxPax' => "$trvlrMaxPAX",
					   'advanced_purchase_period' => "$advncPrchsPrde",
					   'cancellation_policy' => "$cnclltnPlcy",
					   'booking_type' => "$bkngType",
					);
		
					$this->db->where('packages_id', $idPckgs);
					$this->db->update('packages', $data); 
				    
					//$qryUpdt = mysql_query("UPDATE packages SET kode='$acitvityRefNo', API_packages_id = '$activityId', API_packages_refno = '$acitvityRefNo', nama='$activityName',country='$countryCodeISO',city='$cityCodeISO',price='$priceAdult',price_adult='$priceAdult',price_child='$priceChild',currency='$currencies',periode_begin='$travelValidFrom',periode_end='$travelValidTo',gambar='$imagePath',ket='$activityInclusive',booking_begin='$travelValidFrom',booking_end='$travelValidTo' WHERE packages_id = '$idPckgs'");
					
				     
				}
				//start query table packages_city
				$qryslct_pckgs_cty = mysql_query("SELECT * FROM packages_city WHERE country_iso ='$country_iso' AND city_iso ='$city_iso'");
				$isAdaCity=mysql_num_rows($qryslct_pckgs_cty);
				$fieldCty=mysql_fetch_array($qryslct_pckgs_cty);
				$idyCty = $fieldCty['idy'];
				$cntryCodeCty = $fieldCty['country_iso'];
				$ctyCodeCty = $fieldCty['city_iso'];
				if($isAdaCity == 0){
					$data = array(
					   'country_iso' => "$country_iso",
					   'city_iso' => "$city_iso",
					   'city_name' => "$city_name",
					   'gambar' => "$imagePath",
					);
					$this->db->insert('packages_city', $data); 
				//$qryInsrt = mysql_query("INSERT INTO packages_city(country_iso,city_iso,city_name,gambar) VALUES('$country_iso','$city_iso','$city_name','$imagePath')");
				}
				/*
				elseif(($country_iso !== $cntryCodeCty) && ($city_iso !== $ctyCodeCty)){
					$qryDel = mysql_query("DELETE FROM packages_city WHERE idy='$idyCty'");
				
				}
				*/
				else{
				  	$data = array(
					   'country_iso' => "$country_iso",
					   'city_iso' => "$city_iso",
					   'city_name' => "$city_name",
					   'gambar' => "$imagePath",
					);
					$this->db->where('idy', $idyCty);
					$this->db->update('packages_city', $data); 
					  //$qryUpdt = mysql_query("UPDATE packages_city SET country_iso ='$country_iso',city_iso='$city_iso',city_name='$city_name',gambar='$imagePath'  WHERE idy = '$idyCty'");
					
					
				}
				
				//start query table packages_country
				$qryslct_pckgs_cntry = mysql_query("SELECT * FROM packages_country WHERE country_iso ='$country_iso' ");
				$isAdaCountry=mysql_num_rows($qryslct_pckgs_cntry);
				$fieldCntry =mysql_fetch_array($qryslct_pckgs_cntry);
				$idxCntry = $fieldCntry['idx'];
			    $cntryCodeCntry = $fieldCntry['country_iso'];
				if($isAdaCountry == 0){
					$data = array(
					   'country_iso' => "$country_iso",
					   'country_name' => "$country_name",
					   'gambar' => "$imagePath",
					);
					$this->db->insert('packages_country', $data); 
				//$qryInsrt = mysql_query("INSERT INTO packages_country(country_iso,country_name,gambar) VALUES('$country_iso','$country_name','$imagePath')");
				}
				/*
				elseif($country_iso !== $cntryCodeCntry){
					  $qryDel = mysql_query("DELETE FROM packages_country WHERE idx='$idxCntry'");
				}
				*/
				else{
				   $data = array(
					   'country_iso' => "$country_iso",
					   'country_name' => "$country_name",
					   'gambar' => "$imagePath",
					);
					$this->db->where('idx', $idxCntry);
					$this->db->update('packages_country', $data); 
					 //$qryUpdt = mysql_query("UPDATE packages_country SET country_iso ='$country_iso',country_name='$country_name',gambar='$imagePath'  WHERE idx = '$idxCntry'");
					
				}
				
				foreach($item2->Tours->TourItem as $tour){
				$tourID= $tour->TourID;
				$tourName= $tour->TourName;
				$tourImage= $tour->ImagePath;
				$trvlDteReqrd= $tour->TravelDateRequired;
				$tourType= $tour->TourType;
				$tourCategory= $tour->TourCategory;
				$tourFrequency= $tour->TourFrequency;
				$transferType= $tour->TransferType;
				$tourChildagefrom= $tour->ChildAgeFrom;
				$tourChildageto= $tour->ChildAgeTo;
				$pickUpTime= $tour->PickupTime;
				$tourStartTime= $tour->TourStartsTime;
				$tourDuration= $tour->Duration;
					
				   $qryslct = mysql_query("SELECT * FROM tours WHERE tour_id ='$tour->TourID' AND API_packages_id='$activityId' AND API_packages_refno='$acitvityRefNo' ");
				   $isAda=mysql_num_rows($qryslct);
				   $fieldTours=mysql_fetch_array($qryslct);
				   $idPointerTours = $fieldTours['id'];
				   $idTour = $fieldTours['tour_id'];
				   if($isAda == 0){
				   	$data = array(
					   'tour_id' => "$tourID",
					   'API_packages_id' => "$activityId",
					   'API_packages_refno' => "$acitvityRefNo",
					   'tour_name' => "$tourName",
					   'tour_type' => "$tourType",
					   'image_path' => "$tourImage",
					   'child_age_from' => "$tourChildagefrom",
					   'child_age_to' => "$tourChildageto",
					   'tour_category' => "$tourCategory",
					   'tour_frequency' => "$tourFrequency",
					   'transfer_type' => "$transferType",
					   'pickup_time' => "$pickUpTime",
					   'tour_start_time' => "$tourStartTime",
					   'duration' => "$tourDuration",
					);
					$this->db->insert('tours', $data); 
				   //$qry = mysql_query("INSERT INTO tours(tour_id,API_packages_id,API_packages_refno,tour_name,tour_type,image_path,child_age_from,child_age_to,tour_category,tour_frequency,transfer_type,pickup_time,tour_start_time,duration) VALUES('$tour->TourID','$activityId','$acitvityRefNo','$tour->TourName','$tour->TourType','$tour->ImagePath','$tour->ChildAgeFrom', '$tour->ChildAgeTo', '$tour->TourCategory', '$tour->TourFrequency', '$tour->TransferType', '$tour->PickupTime', '$tour->TourStartsTime', '$tour->Duration')");
				   }
				   /*
				   elseif($idTour !== $tour->TourID){
				   		$qryDel = mysql_query("DELETE FROM tours WHERE id='$idPointerTours'");
				   }
				   */
				   else{
				  		$data = array(
					   'tour_id' => "$tourID",
					   'API_packages_id' => "$activityId",
					   'API_packages_refno' => "$acitvityRefNo",
					   'tour_name' => "$tourName",
					   'tour_type' => "$tourType",
					   'image_path' => "$tourImage",
					   'child_age_from' => "$tourChildagefrom",
					   'child_age_to' => "$tourChildageto",
					   'tour_category' => "$tourCategory",
					   'tour_frequency' => "$tourFrequency",
					   'transfer_type' => "$transferType",
					   'pickup_time' => "$pickUpTime",
					   'tour_start_time' => "$tourStartTime",
					   'duration' => "$tourDuration",
					);
					$this->db->where('id', $idPointerTours);
					$this->db->update('tours', $data); 
				  	 	//$qryUpdt = mysql_query("UPDATE tours SET tour_id ='$tour->TourID',API_packages_id='$activityId',API_packages_refno='$acitvityRefNo',tour_name='$tour->TourName',tour_type='$tour->TourType',image_path='$tour->ImagePath',child_age_from='$tour->ChildAgeFrom',child_age_to='$tour->ChildAgeTo',tour_category='$tour->TourCategory',	tour_frequency='$tour->TourFrequency',transfer_type='$tour->TransferType',pickup_time='$tour->PickupTime',tour_start_time='$tour->TourStartsTime',duration='$tour->Duration' WHERE id = '$idPointerTours'");
						
				   }
				}
		}
		/* =============================================================================== */   
		}
?>