<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class API_ean_handler extends CI_Controller {
 
    function __construct() {
        parent::__construct(); 	
		$this->load->model('ean_model');
    } 
	
	function connect_hotel_list(){
		$xmlVar = rawurlencode('<HotelListRequest>
			    <city>Bandung</city>
			    <stateProvinceCode></stateProvinceCode>
			    <countryCode>ID</countryCode>
			    <arrivalDate>10/23/2014</arrivalDate>
			    <departureDate>10/25/2014</departureDate>
			    <RoomGroup>
			        <Room>
			            <numberOfAdults>2</numberOfAdults>
			            <numberOfChildren>1</numberOfChildren>
			        </Room>
			    </RoomGroup>
			    <numberOfResults>4</numberOfResults>
			</HotelListRequest>');	
			
		$link = 'https://'.$this->get_api_domain().'/ean-services/rs/hotel/v3/list?cid='.$this->get_api_cid().'&minorRev=99&apiKey='.$this->get_api_key().'&locale=en_US&currencyCode=IDR&xml='.$xmlVar;
		
		$obj = json_decode(file_get_contents($link),true);
		$html = '<table>';
		foreach($obj['HotelListResponse']['HotelList']['HotelSummary'] as $hotel)
		{
			$html .= '<tr><td>'.$hotel['name'].'</td></tr>';
			$html .= '<tr><td>'.$hotel['address1'].'</td></tr>';
			$html .= '<tr><td>From '.$hotel['highRate'].'</td></tr>';
			$html .= '<tr><td><img src="http://images.travelnow.com'.$hotel['thumbNailUrl'].'" /></td></tr>';
			/*
			echo $hotel['hotelId'].'<br />';
			echo $hotel['name'].'<br />';
			echo $hotel['rateCurrencyCode'].'<br />';
			echo $hotel['highRate'].'<br />';
			echo '<hr />';*/
		}
		$html .= '</table>';
		echo $html;
	}
	function get_api_domain(){
		$rslt = $this->ean_model->get_api_domain();
		return $rslt;
	}
	function get_api_cid(){
		$rslt = $this->ean_model->get_api_cid();
		return $rslt;
	}
	function get_api_key(){
		$rslt = $this->ean_model->get_api_key();
		return $rslt;
	}
}	