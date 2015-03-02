<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Searchflight extends CI_Controller {
 
    function __construct() {
        parent::__construct(); 
		$this->load->helper('form');
		$this->load->model('flight_model');
     } 
 
     public function index() {
     	$flightTrip = $this->input->get('flightTrip');
		$departures = $this->input->get('departures');
		$arrivals = $this->input->get('arrivals');
		$departingDate = $this->input->get('departingDate');
		$returningDate = $this->input->get('returningDate');
		$adults = $this->input->get('adults');
		$childs = $this->input->get('childs');
		$infants = $this->input->get('infants');
		
		$lftCntntDta['departuresSelect'] = $this->flight_model->get_airports_groupby_countryid();
		$lftCntntDta['arrivalsSelect'] = $this->flight_model->get_airports_groupby_countryid();
		$rghtCntntDta['tableSearchResult'] = $this->search_flight($flightTrip,$departures,$arrivals,$departingDate,$returningDate,$adults,$childs,$infants);
		$rghtCntntDta['dprtrCity'] = $this->flight_model->get_airport_location($departures);
		$rghtCntntDta['arrvlCity'] = $this->flight_model->get_airport_location($arrivals);
		$rghtCntntDta['dprtrCityCountry'] = $this->flight_model->get_airport_city_country($departures);
		$rghtCntntDta['arrvlCityCountry'] = $this->flight_model->get_airport_city_country($arrivals);
		$rghtCntntDta['dprtrArprtLctnCde'] = $this->flight_model->get_airport_location_with_code($departures);
		$rghtCntntDta['arrvlArprtLctnCde'] = $this->flight_model->get_airport_location_with_code($arrivals);
		$rghtCntntDta['dprtArprtCtynCode'] = $this->airport_depart_city_and_code($flightTrip,$departures,$arrivals,$departingDate,$returningDate,$adults,$childs,$infants);
		$rghtCntntDta['arrvlArprtCtynCode'] = $this->airport_arrival_city_and_code($flightTrip,$departures,$arrivals,$departingDate,$returningDate,$adults,$childs,$infants);
		$rghtCntntDta['dprtngArprtCode'] = $departures;
		$rghtCntntDta['arrvlArprtCode'] = $arrivals;
		$rghtCntntDta['dprtngDate'] = $departingDate;
     	
		$hdrCntntDta['topNavActive'] = 'flight';
		$lftCntntDta['tabsSearchFlightActive'] = 'class="active"';
		$lftCntntDta['tabsSearchHotelActive'] = '';
		$lftCntntDta['tabsCntntFlightActive'] = 'class="tab-pane fade in active"';
		$lftCntntDta['tabsCntntHotelActive'] = 'class="tab-pane fade"';
		
		$data['footercontent'] = $this->load->view('frontend/footer-content','',true);
		$data['headercontent'] = $this->load->view('frontend/header-content',$hdrCntntDta,true);
		$data['slidercontent'] =  'none';
		$data['rightcontent'] = $this->load->view('frontend/searchflight-right-content',$rghtCntntDta,true);
		$data['leftcontent'] = $this->load->view('frontend/searchflight-left-content',$lftCntntDta,true);
	    $data['title'] = "Starholiday | Home";
        $this->load->view('frontend-template', $data);
		
    }
    
	function airport_depart_city_and_code($flightTrip,$departures,$arrivals,$departingDate,$returningDate,$adults,$childs,$infants){
		$flightTrip = $this->input->get('flightTrip');
		$departures = $this->input->get('departures');
		$arrivals = $this->input->get('arrivals');
		$departingDate = $this->input->get('departingDate');
		$returningDate = $this->input->get('returningDate');
		$adults = $this->input->get('adults');
		$childs = $this->input->get('childs');
		$infants = $this->input->get('infants');
		
		//echo $flightTrip.' - '.$departures.' - '.$arrivals.' - '.$departingDate.' - '.$returningDate.' - '.$adults.' - '.$childs.' - '.$infants;
		
		$currentDate = $departingDate;
		$lastDate = $returningDate;//date('Y-m-d', strtotime('+1 day' . $currentDate)); 
		$departureAirportCode = $departures;
		$arrivalAirportCode = $arrivals;
		$adult = $adults;
		$child = $childs;
		$infant = $infants;
		$searchVersion = 3;
		$language = 'en';
		$url = 'http://'.$this->get_api_domain().'/search/flight?d='.$departureAirportCode.'&a='.$arrivalAirportCode.'&date='.$currentDate.'&ret_date='.$lastDate.'&adult='.$adult.'&child='.$child.'&infant='.$infant.'&token='.$this->get_token().'&lang='.$language.'&v='.$searchVersion.'&output=json';
		$jsonUrl = file_get_contents($url, false);
		$getFlightNfo = json_decode($jsonUrl, true);
		if(!empty($getFlightNfo['go_det']['dep_airport']['short_name']) && !empty($getFlightNfo['go_det']['dep_airport']['airport_code'])){
			$cityAirportName = $getFlightNfo['go_det']['dep_airport']['short_name'];
			$cityAirportCode = $getFlightNfo['go_det']['dep_airport']['airport_code'];
			$html = $cityAirportName.' ('.$cityAirportCode.')';
			
			return $html;
		}
		else{
			return null;
		}
		
	}
    function airport_arrival_city_and_code($flightTrip,$departures,$arrivals,$departingDate,$returningDate,$adults,$childs,$infants){
		$flightTrip = $this->input->get('flightTrip');
		$departures = $this->input->get('departures');
		$arrivals = $this->input->get('arrivals');
		$departingDate = $this->input->get('departingDate');
		$returningDate = $this->input->get('returningDate');
		$adults = $this->input->get('adults');
		$childs = $this->input->get('childs');
		$infants = $this->input->get('infants');
		
		//echo $flightTrip.' - '.$departures.' - '.$arrivals.' - '.$departingDate.' - '.$returningDate.' - '.$adults.' - '.$childs.' - '.$infants;
		
		$currentDate = $departingDate;
		$lastDate = $returningDate;//date('Y-m-d', strtotime('+1 day' . $currentDate)); 
		$departureAirportCode = $departures;
		$arrivalAirportCode = $arrivals;
		$adult = $adults;
		$child = $childs;
		$infant = $infants;
		$searchVersion = 3;
		$language = 'en';
		$url = 'http://'.$this->get_api_domain().'/search/flight?d='.$departureAirportCode.'&a='.$arrivalAirportCode.'&date='.$currentDate.'&ret_date='.$lastDate.'&adult='.$adult.'&child='.$child.'&infant='.$infant.'&token='.$this->get_token().'&lang='.$language.'&v='.$searchVersion.'&output=json';
		$jsonUrl = file_get_contents($url, false);
		$getFlightNfo = json_decode($jsonUrl, true);
		if(!empty($getFlightNfo['go_det']['arr_airport']['short_name']) && !empty($getFlightNfo['go_det']['arr_airport']['airport_code'])){
			$cityAirportName = $getFlightNfo['go_det']['arr_airport']['short_name'];
			$cityAirportCode = $getFlightNfo['go_det']['arr_airport']['airport_code'];
			$html = $cityAirportName.' ('.$cityAirportCode.')';
			
			return $html;
		}
		else{
			return null;
		}
		
	}
	
	function search_flight($flightTrip,$departures,$arrivals,$departingDate,$returningDate,$adults,$childs,$infants){
		$flightTrip = $this->input->get('flightTrip');
		$departures = $this->input->get('departures');
		$arrivals = $this->input->get('arrivals');
		$departingDate = $this->input->get('departingDate');
		$returningDate = $this->input->get('returningDate');
		$adults = $this->input->post('adults');
		$childs = $this->input->get('childs');
		$infants = $this->input->get('infants');
		
		//echo $flightTrip.' - '.$departures.' - '.$arrivals.' - '.$departingDate.' - '.$returningDate.' - '.$adults.' - '.$childs.' - '.$infants;
		
		$currentDate = $departingDate;
		$lastDate = $returningDate;//date('Y-m-d', strtotime('+1 day' . $currentDate)); 
		$departureAirportCode = $departures;
		$arrivalAirportCode = $arrivals;
		$adult = $adults;
		$child = $childs;
		$infant = $infants;
		$searchVersion = 3;
		$language = 'en';
		$url = 'http://'.$this->get_api_domain().'/search/flight?d='.$departureAirportCode.'&a='.$arrivalAirportCode.'&date='.$currentDate.'&ret_date='.$lastDate.'&adult='.$adult.'&child='.$child.'&infant='.$infant.'&token='.$this->get_token().'&lang='.$language.'&v='.$searchVersion.'&output=json';
		$jsonUrl = file_get_contents($url, false);
		$getFlightNfo = json_decode($jsonUrl, true);
		return $getFlightNfo;
		/*
		$currency = $getFlightNfo['diagnostic']['currency'];
		$i=0;
		foreach($getFlightNfo['departures']['result'] as $row){
			$isPromo = $getFlightNfo['departures']['result'][$i]['is_promo'];
			$image = $getFlightNfo['departures']['result'][$i]['image'];
			$airlinesName = $getFlightNfo['departures']['result'][$i]['airlines_name'];
			$flightNumber = $getFlightNfo['departures']['result'][$i]['flight_number'];
			$dprtrTime = $getFlightNfo['departures']['result'][$i]['simple_departure_time'];
			$arrvlTime = $getFlightNfo['departures']['result'][$i]['simple_arrival_time'];
			$fclty = $getFlightNfo['departures']['result'][$i]['stop'];
			$price = $getFlightNfo['departures']['result'][$i]['price_value'];
			$html = '<tr>';
			$html .= '<td><div><img src="'.$image.'" /></div><div>'.$flightNumber.'</div><div>'.$airlinesName.'</div></td>';
			$html .= '<td>'.$dprtrTime.'</td>';
			$html .= '<td>'.$arrvlTime.'</td>';
			$html .= '<td>'.$fclty.'</td>';
			$html .= '<td>'.$currency.' '.number_format($price).'</td>';
			$html .= '</tr>';
			echo $html;
		$i++;	
		}
		*/
	}

	function get_cheapest_flight_fare_leftmenu($dprtr, $rtrn){
		
		$currentDate = date('Y-m-d');
		$lastDate = '';//date('Y-m-d', strtotime('+1 day' . $currentDate)); 
		$departureAirportCode = $dprtr;
		$arrivalAirportCode = $rtrn;
		$adult = 1;
		$child = 0;
		$infant = 0;
		$searchVersion = 3;
		$url = 'http://'.$this->get_api_domain().'/search/flight?d='.$departureAirportCode.'&a='.$arrivalAirportCode.'&date='.$currentDate.'&ret_date='.$lastDate.'&adult='.$adult.'&child='.$child.'&infant='.$infant.'&token='.$this->get_token().'&v='.$searchVersion.'&output=json';
		$jsonUrl = file_get_contents($url, false);
		$getFlightNfo = json_decode($jsonUrl, true);
		
		return $getFlightNfo;
	}
	
	function get_lowest_price($dprtr, $rtrn){
		$currentDate = date('Y-m-d');
		$lastDate = '';//date('Y-m-d', strtotime('+1 day' . $currentDate)); 
		$departureAirportCode = $dprtr;
		$arrivalAirportCode = $rtrn;
		$adult = 1;
		$child = 0;
		$infant = 0;
		$searchVersion = 3;
		$url = 'http://'.$this->get_api_domain().'/search/flight?d='.$departureAirportCode.'&a='.$arrivalAirportCode.'&date='.$currentDate.'&ret_date='.$lastDate.'&adult='.$adult.'&child='.$child.'&infant='.$infant.'&token='.$this->get_token().'&v='.$searchVersion.'&output=json';
		$jsonUrl = file_get_contents($url, false);
		$getFlightNfo = json_decode($jsonUrl, true);
		$i=0;
		$priceValue = array();
		$jml = count($getFlightNfo['departures']['result']);
		foreach($getFlightNfo['departures']['result'] as $row){
			$isPromo = $getFlightNfo['departures']['result'][$i]['is_promo'];
			$price = $getFlightNfo['departures']['result'][$i]['price_value'];
			//if($isPromo == 1){
				$priceValue[$i] = $price;
			//}
			
		$i++;
		}
		$lowestPrice = min($priceValue);
		return $lowestPrice;
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
 
}
