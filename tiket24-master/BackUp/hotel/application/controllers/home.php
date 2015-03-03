<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Home extends CI_Controller {
 
    function __construct() {
        parent::__construct(); 
		$this->load->helper('form');
		$this->load->model('flight_model');
		$this->load->model('ean_model');
     } 
 
     public function index() {
     	//$this->db->select('*');
		//$this->db->from('airports');
		//$this->db->group_by('country_id');
		//$qry = $this->db->get();
     	/* collect cheap flight list start*/
     	/*
     	$currentDate = date('Y-m-d');
		$lastDate = date('Y-m-d', strtotime('+30 day' . $currentDate)); 
		$departureAirportCode = 'CGK';
		$arrivalAirportCode = 'DPS';
		$adult = 1;
		$child = 0;
		$infant = 0;
		$searchVersion = 3;
		$url = 'http://'.$this->get_api_domain().'/search/flight?d='.$departureAirportCode.'&a='.$arrivalAirportCode.'&date='.$currentDate.'&ret_date='.$lastDate.'&adult='.$adult.'&child='.$child.'&infant='.$infant.'&token='.$this->get_token().'&v='.$searchVersion.'&output=json';
		$jsonUrl = file_get_contents($url, false);
		$getFlightNfo = json_decode($jsonUrl, true);
		 * */
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
		$rghtCntntDta['hotelEanList'] = $this->get_hotel_list();
     	/* collect cheap flight list end */
		$hdrCntntDta['topNavActive'] = 'home';
		$data['footercontent'] = $this->load->view('frontend/footer-content','',true);
		$data['headercontent'] = $this->load->view('frontend/header-content',$hdrCntntDta,true);
		$data['slidercontent'] = $this->load->view('frontend/images-slider-content','',true);
		$data['rightcontent'] = $this->load->view('frontend/home-right-content',$rghtCntntDta,true);
		$data['leftcontent'] = $this->load->view('frontend/home-left-content',$lftCntntDta,true);
	    $data['title'] = "Starholiday | Home";
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
/* hotel section start here */
	function get_hotel_list(){
		
		$city = 'bandung';
		$countryCode = 'id';
		$dt = date("m/d/Y");
		$checkInDate = date("m/d/Y", strtotime("$dt +30 day"));
		$checkOutDate = date("m/d/Y", strtotime("$checkInDate +3 day"));
		$adults = 1;
		$childs = 0;
		$currency = 'IDR';
		$xmlVar = rawurlencode('<HotelListRequest><city>'.$city.'</city><stateProvinceCode></stateProvinceCode><countryCode>'.$countryCode.'</countryCode><arrivalDate>'.$checkInDate.'</arrivalDate><departureDate>'.$checkOutDate.'</departureDate><RoomGroup><Room><numberOfAdults>'.$adults.'</numberOfAdults></Room></RoomGroup><numberOfResults></numberOfResults></HotelListRequest>');	
			
		$link = 'https://'.$this->get_api_ean_domain().'/ean-services/rs/hotel/v3/list?cid='.$this->get_api_ean_cid().'&minorRev=99&apiKey='.$this->get_api_ean_key().'&locale=en_US&currencyCode='.$currency.'&xml='.$xmlVar;
		
		$obj = json_decode(file_get_contents($link),true);
		
		$i=0;
		$html = '<div class="row">';
		foreach($obj['HotelListResponse']['HotelList']['HotelSummary'] as $hotel)
		{
		if($i <= 3){	
			$hotelID = $obj['HotelListResponse']['HotelList']['HotelSummary'][$i]['hotelId'];
			$price = $obj['HotelListResponse']['HotelList']['HotelSummary'][$i]['highRate'];
			$city = $obj['HotelListResponse']['HotelList']['HotelSummary'][$i]['city'];
			
			$xmlVar2 = '<HotelInformationRequest><hotelId>'.$obj['HotelListResponse']['HotelList']['HotelSummary'][$i]['hotelId'].'</hotelId><options>HOTEL_IMAGES</options></HotelInformationRequest>';
			$link2 = 'https://'.$this->get_api_ean_domain().'/ean-services/rs/hotel/v3/info?cid='.$this->get_api_ean_cid().'&minorRev=99&apiKey='.$this->get_api_ean_key().'&locale=en_US&currencyCode='.$currency.'&xml='.$xmlVar2;
			$obj2 = json_decode(file_get_contents($link2),true);
			$j=0;
			foreach($obj2['HotelInformationResponse']['HotelImages'] as $htl){
				if(!empty($htl)){
					
					if($j == 0){
						$gambar = '<img src="'.$obj2['HotelInformationResponse']['HotelImages']['HotelImage'][$j]['url'].'" class="img-responsive box-shadow" />';
					}
				}
				else{
						$gambar = '<img class="img-responsive" src="'.base_url().'assets/images/hotel-no-image.jpg" class="img-responsive box-shadow" />';
					}
				
			 $j++;
			}
			
			
			$html .= ' <div class="col-xs-6 col-sm-6 col-md-6" style="border-top:0px #CCCCCC solid; border-bottom:0px #CCCCCC solid;border-right:0px #CCCCCC solid;" >
				        	<div style="padding:5px;" class="thumbnail">
					            <div style="color:#0d468b;font-weight:bold;"><a href="'.base_url().'hotel/details/'.$hotelID.'" >'.$obj['HotelListResponse']['HotelList']['HotelSummary'][$i]['name'].'</a></div>
					            <div>'.$obj['HotelListResponse']['HotelList']['HotelSummary'][$i]['address1'].', '.$city.'</div>
					            <div>From '.$currency.' '.number_format($price).'</div>
					            <div align="center">'.$gambar.'</div>
				            </div>
				        </div>';
		}
		$i++;
		}
		$html .= '</div>';
		
		
			return $html;
		
		
	
	} 
	function get_api_ean_domain(){
		$rslt = $this->ean_model->get_api_domain();
		return $rslt;
	}
	function get_api_ean_cid(){
		$rslt = $this->ean_model->get_api_cid();
		return $rslt;
	}
	function get_api_ean_key(){
		$rslt = $this->ean_model->get_api_key();
		return $rslt;
	}
}
