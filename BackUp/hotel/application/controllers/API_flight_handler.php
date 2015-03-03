<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class API_flight_handler extends CI_Controller {
 
    function __construct() {
        parent::__construct(); 
		$this->load->model('flight_model');
	
     } 
	
	function get_api_domain(){
		$APIdomain = $this->flight_model->get_api_domain();
		return $APIdomain;
	}
 
     function get_token(){
		$APIsecretKey = $this->flight_model->get_api_secret_key();
		$APIdomain = $this->flight_model->get_api_domain();
		$url = 'https://'.$APIdomain.'/apiv1/payexpress?method=getToken&secretkey='.$APIsecretKey.'&output=json';
		$jsonUrl = file_get_contents($url, False);
		$getToken = json_decode($jsonUrl, true);
		$flightApiToken = $getToken['token'];
		return $flightApiToken;
	} 
	
	function collect_country_list(){
		
		$qryCekDt = $this->db->get('countries');
		$isAda = $qryCekDt->num_rows();
		$url = 'https://'.$this->get_api_domain().'/general_api/listCountry?token='.$this->get_token().'&output=json';
		$jsonUrl = file_get_contents($url, false);
		$getCountry = json_decode($jsonUrl, true);
		if($isAda == 0){
			$i = 0;
			foreach($getCountry['listCountry'] as $row){
				$countryCode = strtoupper($getCountry['listCountry'][$i]['country_id']);
				$countryName = $getCountry['listCountry'][$i]['country_name'];
				$countryAreaCode = $getCountry['listCountry'][$i]['country_areacode'];
			
				$arrData = array('country_code' => $countryCode, 'country_name' => $countryName,'country_areacode' => $countryAreaCode);
				$this->db->insert('countries', $arrData); 
				
				$i++;
			}
		}else{
			$i = 0;
			foreach($getCountry['listCountry'] as $row){
				$countryCode = strtoupper($getCountry['listCountry'][$i]['country_id']);
				$countryName = $getCountry['listCountry'][$i]['country_name'];
				$countryAreaCode = $getCountry['listCountry'][$i]['country_areacode'];
				$qrySlctData = $this->db->get('countries');
				foreach($qrySlctData->result() as $row){
					$idRow = $row->id;
					
					
					$arrData = array('country_code' => $countryCode, 'country_name' => $countryName,'country_areacode' => $countryAreaCode);
					$this->db->where('id', $idRow);
					$this->db->where('country_code', $countryCode);
					$this->db->update('countries', $arrData); 
					
				}
				
			$i++;
			}
			
		} 
		
	} 

	function collect_airport_list(){
		$qryCekDt = $this->db->get('airports');
		$isAda = $qryCekDt->num_rows();
		$url = 'https://'.$this->get_api_domain().'/flight_api/all_airport?token='.$this->get_token().'&output=json';
		$jsonUrl = file_get_contents($url, false);
		$getAirport = json_decode($jsonUrl, true);
		if($isAda == 0){
			$i = 0;
			foreach($getAirport['all_airport']['airport'] as $row){
				$airportName = $getAirport['all_airport']['airport'][$i]['airport_name'];
				$airportCode = $getAirport['all_airport']['airport'][$i]['airport_code'];
				$airportLocationName = $getAirport['all_airport']['airport'][$i]['location_name'];
				$airportCountryID = strtoupper($getAirport['all_airport']['airport'][$i]['country_id']);
				/* start inserting to table */
				$arrData = array('airport_name' => $airportName, 'airport_code' => $airportCode,'location_name' => $airportLocationName, 'country_id' => $airportCountryID);
				$this->db->insert('airports', $arrData); 
				
				//echo $airportName.' - '.$airportCode.' - '.$airportLocationName.' - '.$airportCountryID.'<br />';
				$i++;
			}
		}
		else{
			$i = 0;
			foreach($getAirport['all_airport']['airport'] as $row){
				$airportName = $getAirport['all_airport']['airport'][$i]['airport_name'];
				$airportCode = $getAirport['all_airport']['airport'][$i]['airport_code'];
				$airportLocationName = $getAirport['all_airport']['airport'][$i]['location_name'];
				$airportCountryID = strtoupper($getAirport['all_airport']['airport'][$i]['country_id']);
				/* checking data for similarity */
				$qrySlctData = $this->db->get('airports');
				foreach($qrySlctData->result() as $row){
					$idRow = $row->id;
					
					/* start updating to table */
					$arrData = array('airport_name' => $airportName, 'airport_code' => $airportCode,'location_name' => $airportLocationName, 'country_id' => $airportCountryID);
					$this->db->where('id', $idRow);
					$this->db->where('airport_code', $airportCode);
					$this->db->update('airports', $arrData); 
				}
				//echo $airportName.' - '.$airportCode.' - '.$airportLocationName.' - '.$airportCountryID.'<br />';
				$i++;
			}
		}
	}
	
	//function search_flight_list($dprtr,$arrvl,$dprtrDate,$rtrnDate,$adult,$child,$infant){
		function search_flight($dprtrCode = 'CGK', $arrvlCode = 'SRG', $dprtrDate = '2014-09-16', $rtrnDate = '2014-09-30'){
		
		$adult = 1;
		$child = 0;
		$infant = 0;
		
		$searchVersion = 3;
		/* start collect data */
		$url = 'http://'.$this->get_api_domain().'/search/flight?d='.$dprtrCode.'&a='.$arrvlCode.'&date='.$dprtrDate.'&ret_date='.$rtrnDate.'&adult='.$adult.'&child='.$child.'&infant='.$infant.'&token='.$this->get_token().'&v='.$searchVersion.'&output=json';
		$jsonUrl = file_get_contents($url, false);
		$getFlightNfo = json_decode($jsonUrl, true);
		$i=0;
		$hasil = $getFlightNfo['departures']['result'];
		/*
		foreach($getFlightNfo['departures']['result'] as $rowDprtr){
			$departuresFlightId = $getFlightNfo['departures']['result'][$i]['flight_id'];
			
				echo $departuresFlightId.'<br />';
			
		}
		 * */
		/* end collect data */
	}
	
	function collect_flight_list(){
		//$currentDate = date('Y-m-d');
		//$returnDate = date('Y-m-d', strtotime('+30 day' , $currentDate)); 
		$airportCode = $this->db->select('*')->from('airports')->get();
		$arprtCd = array();
		foreach($airportCode->result() as $row){
			$ac = $row->airport_code;
			$arprtCd[] = $ac;
		}
		$jmlDta = count($arprtCd);
		$totHari = 7;
		$x=1;
		for($j=1;$j<=$totHari;$j++){
			$currentDate = date('Y-m-d');
			$rtrnDte = date('Y-m-d', strtotime('+'.$j.' day'. $currentDate)); 
			$i=0;
			foreach($arprtCd as $fld){
			$firstRcrd = $arprtCd[0];
			$dprtrArprtCde = $arprtCd[$i];
			$arrivalAirportCode = $this->db->select('*')->from('airports')->where('airport_code !=', $firstRcrd)->get();
				foreach($arrivalAirportCode->result() as $fld){
					$arrvlArprtCde = $fld->airport_code;
					//echo '('.$x.')'.$dprtrArprtCde.' - '.$arrvlArprtCde.' - '.$rtrnDte.'<br />';
					/* start collect data */
					$departureAirportCode = $dprtrArprtCde;
					$arrivalAirportCode = $arrvlArprtCde;
					$adult = 1;
					$child = 0;
					$infant = 0;
					$searchVersion = 3;
					$url = 'http://'.$this->get_api_domain().'/search/flight?d='.$departureAirportCode.'&a='.$arrivalAirportCode.'&date='.$currentDate.'&ret_date='.$rtrnDte.'&adult='.$adult.'&child='.$child.'&infant='.$infant.'&token='.$this->get_token().'&v='.$searchVersion.'&output=json';
					$jsonUrl = file_get_contents($url, false);
					$getFlightNfo = json_decode($jsonUrl, true);
					$z=0;
					foreach($getFlightNfo['departures']['result'] as $rowDprtr){
						$departuresFlightId = $getFlightNfo['departures']['result'][$z]['flight_id'];
						$isPromo = $getFlightNfo['departures']['result'][$i]['is_promo'];
						if(!empty($departuresFlightId)){
							echo $departuresFlightId.'<br />';
						}
						
					}
					
					/* end collect data */
					
					$x++;
				}
			
			$i++;
		}
			//echo $rtrnDte.'<br />';
		}
		echo '<br />';
				
		/*
		$departureAirportCode = 'CGK';
		$arrivalAirportCode = 'DPS';
		$adult = 1;
		$child = 0;
		$infant = 0;
		$searchVersion = 3;
		$url = 'http://'.$this->get_api_domain().'/search/flight?d='.$departureAirportCode.'&a='.$arrivalAirportCode.'&date='.$currentDate.'&ret_date='.$returnDate.'&adult='.$adult.'&child='.$child.'&infant='.$infant.'&token='.$this->get_token().'&v='.$searchVersion.'&output=json';
		$jsonUrl = file_get_contents($url, false);
		$getFlightNfo = json_decode($jsonUrl, true);
		
		echo $getFlightNfo['search_queries']['from'].'<br />';
		echo $getFlightNfo['ret_det']['formatted_date'].'<br />';
		echo $getFlightNfo['departures']['result'][0]['flight_id'].'<br />';
		echo $getFlightNfo['returns']['result'][0]['flight_id'].'<br />';
		echo $getFlightNfo['nearby_go_date']['nearby'][0]['date'];
		*/
	}
	function test_collect_flight_list(){
		$airportCode = $this->db->select('*')->from('airports')->get();
		$arprtCd = array();
		foreach($airportCode->result() as $row){
			$ac = $row->airport_code;
			$arprtCd[] = $ac;
		}
		$jmlDta = count($arprtCd);
		$totHari = 7;
		$x=1;
		for($j=1;$j<=$totHari;$j++){
			$currentDate = date('Y-m-d');
			$rtrnDte = date('Y-m-d', strtotime('+'.$j.' day'. $currentDate)); 
			$i=0;
			foreach($arprtCd as $fld){
			$firstRcrd = $arprtCd[0];
			$dprtrArprtCde = $arprtCd[$i];
			$arrivalAirportCode = $this->db->select('*')->from('airports')->where('airport_code !=', $firstRcrd)->get();
				foreach($arrivalAirportCode->result() as $fld){
					$arrvlArprtCde = $fld->airport_code;
					echo '('.$x.')'.$dprtrArprtCde.' - '.$arrvlArprtCde.' - '.$rtrnDte.'<br />';
					$x++;
				}
			
			$i++;
		}
			//echo $rtrnDte.'<br />';
		}
		echo '<br />';
	}
 
}
/*
 *****************Search Version on method collect_flight_list**************
1 Flight Sriwijaya, Lion Air, Garuda, Merpati
2 Flight Citilink added. New variable birthdatea1 (birthdate for adult) required for flight Add Order
3 Flight Mandala and Tiger added. New variable dcheckinbaggagea1[$i] (departure baggage for adult) ,dcheckinbaggagec1[$i] (departure baggage for child), rcheckinbaggagea1[$i] (return baggage for child),rcheckinbaggagec1[$i] (return baggage for child),required for flight Add Order
 ***********************************************
 */
?>