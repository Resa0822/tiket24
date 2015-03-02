<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Event extends CI_Controller {
 
    function __construct() {
        parent::__construct(); 
		$this->load->model('flight_model');
     } 
 
     public function index() {
     	/* jakarta to denpasar  */ 
		$fCgkToDps = $this->get_cheapest_flight_fare_leftmenu('CGK', 'DPS');
		$fCgkToDps_lowestprice = $this->get_lowest_price('CGK', 'DPS');
		$lftCntntDta['fCgkToDps'] = $fCgkToDps;
		$lftCntntDta['fCgkToDps_lowestprice'] = $fCgkToDps_lowestprice;
		/* denpasar to jakarta  */ 
		$fDpsToCgk = $this->get_cheapest_flight_fare_leftmenu('DPS', 'CGK');
		$fDpsToCgk_lowestprice = $this->get_lowest_price('DPS', 'CGK');
		$lftCntntDta['fDpsToCgk'] = $fDpsToCgk;
		$lftCntntDta['fDpsToCgk_lowestprice'] = $fDpsToCgk_lowestprice;
		/* jakarta to yogyakarta  */ 
		$fCgkToJog = $this->get_cheapest_flight_fare_leftmenu('CGK', 'JOG');
		$fCgkToJog_lowestprice = $this->get_lowest_price('CGK', 'JOG');
		$lftCntntDta['fCgkToJog'] = $fCgkToJog;
		$lftCntntDta['fCgkToJog_lowestprice'] = $fCgkToJog_lowestprice;
		/* yogyakarta to jakarta  */ 
		$fJogToCgk = $this->get_cheapest_flight_fare_leftmenu('JOG', 'CGK');
		$fJogToCgk_lowestprice = $this->get_lowest_price('JOG', 'CGK');
		$lftCntntDta['fJogToCgk'] = $fJogToCgk;
		$lftCntntDta['fJogToCgk_lowestprice'] = $fJogToCgk_lowestprice;
		/* jakarta to surabaya  */ 
		$fCgkToSub = $this->get_cheapest_flight_fare_leftmenu('CGK', 'SUB');
		$fCgkToSub_lowestprice = $this->get_lowest_price('CGK', 'SUB');
		$lftCntntDta['fCgkToSub'] = $fCgkToSub;
		$lftCntntDta['fCgkToSub_lowestprice'] = $fCgkToSub_lowestprice;
		/* surabaya to jakarta  */ 
		$fSubToCgk = $this->get_cheapest_flight_fare_leftmenu('SUB', 'CGK');
		$fSubToCgk_lowestprice = $this->get_lowest_price('SUB', 'CGK');
		$lftCntntDta['fSubToCgk'] = $fSubToCgk;
		$lftCntntDta['fSubToCgk_lowestprice'] = $fSubToCgk_lowestprice;
		/* jakarta to singapore  */ 
		$fCgkToSin = $this->get_cheapest_flight_fare_leftmenu('CGK', 'SIN');
		$fCgkToSin_lowestprice = $this->get_lowest_price('CGK', 'SIN');
		$lftCntntDta['fCgkToSin'] = $fCgkToSin;
		$lftCntntDta['fCgkToSin_lowestprice'] = $fCgkToSin_lowestprice;
		/* jakarta to kuala lumpur  */ 
		$fCgkToKul = $this->get_cheapest_flight_fare_leftmenu('CGK', 'KUL');
		$fCgkToKul_lowestprice = $this->get_lowest_price('CGK', 'KUL');
		$lftCntntDta['fCgkToKul'] = $fCgkToKul;
		$lftCntntDta['fCgkToKul_lowestprice'] = $fCgkToKul_lowestprice;
		
		$lftCntntDta['departuresSelect'] = $this->flight_model->get_airports_groupby_countryid();
		$lftCntntDta['arrivalsSelect'] = $this->flight_model->get_airports_groupby_countryid();
		$hdrCntntDta['topNavActive'] = 'event';
		$data['footercontent'] = $this->load->view('frontend/footer-content','',true);
		$data['headercontent'] = $this->load->view('frontend/header-content',$hdrCntntDta,true);
		$data['slidercontent'] = 'none';
		$data['rightcontent'] = $this->load->view('frontend/event/event-right-content','',true);
		$data['leftcontent'] = $this->load->view('frontend/home-left-content',$lftCntntDta,true);
	    $data['title'] = "Starholiday | Events";
        $this->load->view('frontend-template', $data);
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
		if(!empty($getFlightNfo)){
			return $getFlightNfo;
		}
		else{
			return null;
		}
		
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
		if(!empty($getFlightNfo['departures']['result'])){
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
		else{
			return null;
		}
		
	}

	function test($dprtr='CGK', $rtrn='DPS'){
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
		
		echo $jml;

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
?>