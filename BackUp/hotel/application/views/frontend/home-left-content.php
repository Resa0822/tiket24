<!-- ===================tabs container start here============ --> 
<script>
$(document).ready(function(){
  	$("#departingDate, #returningDate").datepicker({
		numberOfMonths: 2,
		showButtonPanel: false,
		dateFormat: 'yy-mm-dd'
	});
	$("#checkIn, #checkOut").datepicker({
		numberOfMonths: 2,
		showButtonPanel: false,
		dateFormat: 'yy-mm-dd'
	});
	$( "#adultSPax, #childsPax, #nights, #rooms" ).spinner({ min: 0 });
	$('input[name="flightTrip"]').change(function() {
		var flightType = $(this).val();
       if(flightType == 2){
		//$('#departDate').show();
    	$('#returnDate').show();
		}
		else{
			//$('#departDate').show();
	    	$('#returnDate').hide();
		}
    });
	
    
});
</script>
<div class="boxshadow">
<ul id="tabsHotelFlight" class="nav nav-tabs nav-tabs-custom" role="tablist" style="border-top:2px #1792bc solid;border-left:2px #1792bc solid;border-right:2px #1792bc solid; padding-top:2px ">
      <li class="active"><a href="#hotel" role="tab" data-toggle="tab">HOTEL</a></li>
      <li><a href="#flight" role="tab" data-toggle="tab">FLIGHT</a></li>
</ul>
    <div id="hotelFlightContent" class="tab-content" style="background:#60d9ec; border-bottom:2px #1792bc solid;border-left:2px #1792bc solid;border-right:2px #1792bc solid; padding:3px;">
      <div class="tab-pane fade in active" id="hotel">
<?php /* form search hotel form start */ ?>  
       <form role="form">
      	  <div class="form-group" >
            <label for="exampleInputPassword1">Location / Hotel</label>
			<input type="text" class="form-control" id="hotelLocation" name="hotelLocation">
		  </div>
		  <div class="form-group">
		  	<div class="row">
		  		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		  			<div class="form-group has-feedback">
					    <label for="exampleInputPassword1">Check In</label>					   
						<input type="text" class="form-control" id="checkIn" name="checkIn">
						<span class="glyphicon glyphicon-calendar form-control-feedback"></span>    
					</div>
		  		</div>
		    	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		    		<div class="form-group has-feedback">
					    <label for="exampleInputPassword1">Check Out</label>
					    <input type="text" class="form-control" id="checkOut" name="checkOut">
					    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>   
					</div>
				</div>
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="row">
		  		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		  			<div class="form-group">
					    <label for="exampleInputPassword1">Adults</label>
					    <input type="text" class="form-control" id="adultSPax" name="adultSPax" value="1">
					</div>
		  		</div>
		    	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		    		<div class="form-group">
					    <label for="exampleInputPassword1">Childs</label>
					    <input type="text" class="form-control" id="childsPax" name="childsPax" value="0">
					</div>
				</div>
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="row">
		  		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		  			<div class="form-group">
					    <label for="exampleInputPassword1">Nights</label>
					    <input type="text" class="form-control" id="nights" name="nights" value="1" >
					</div>
		  		</div>
		    	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		    		<div class="form-group">
					    <label for="exampleInputPassword1">Rooms</label>
					    <input type="text" class="form-control" id="rooms" name="rooms" value="1">
					</div>
				</div>
		  	</div>
		  </div>
		  <div class="form-group" align="right">
		  <button type="submit" class="btn btn-blue btn-lg">Search</button>
		 </div>
	   </form>
<?php /* form search hotel form end */ ?> 
      </div>
      <div class="tab-pane fade" id="flight">
<?php /* form search flight form start */ ?>      
      	<form role="form" action="<?php echo base_url().'searchflight'; ?>" method="get" name="searchFlight"  id="searchFlight">
      
	      	 <div class="form-group" >
	           <label class="radio-inline" for="onewayTrip"> <input type="radio" name="flightTrip" id="onewayTrip" value="1" checked> One Way </label>
	           <label class="radio-inline" for="roundTrip"> <input type="radio" name="flightTrip" id="roundTrip" value="2"> Round Trip </label>
			 </div>		
			
		 
		 	<div class="form-group">
			    <label for="exampleInputEmail1">Origin</label>
			   	<select id="departures" name="departures" class="form-control selectpicker show-tick " data-size="5" data-style="btn-default"  data-live-search="false" title="Departure Location">
				<?php
		      	$arrCntry = array();
		      	foreach($departuresSelect as $row){
		      		$country_code = $row->country_id;
					$this->db->select('*');
					$this->db->from('countries');
					$this->db->where('country_code', $country_code);
					$qryCntry = $this->db->get();
					$cntry = $qryCntry->row();
					$cntryNmae = $cntry ->country_name;
					
				?>
				<optgroup label="<?php echo $cntryNmae; ?>" >
				<?php	
					$this->db->select('*');
					$this->db->from('airports');
					$this->db->where('country_id', $country_code);
					$qryAirport = $this->db->get();
					foreach($qryAirport->result() as $fld){
					$fld->airport_code == 'DPS' ? $slctd = 'selected' : $slctd = '';
				?>
				<option value="<?php echo $fld->airport_code; ?>" <?php echo $slctd; ?> ><?php echo $fld->location_name.' - '.$fld->airport_code; ?></option>
				<?php
					}
				?>
				</optgroup>
				<?php
		      	}
	      		?>
				   
				 </select>
		 </div>
		
		 <div class="form-group">
		    <label for="exampleInputEmail1">Destination</label>
		   	<select id="arrivals" name="arrivals" class="form-control selectpicker show-tick " data-size="5" data-style="btn-default"  data-live-search="false" title="Departure Location">
			<?php
	      	$arrCntry = array();
	      	foreach($arrivalsSelect as $row){
	      		$country_code = $row->country_id;
				$this->db->select('*');
				$this->db->from('countries');
				$this->db->where('country_code', $country_code);
				$qryCntry = $this->db->get();
				$cntry = $qryCntry->row();
				$cntryNmae = $cntry ->country_name;
				
			?>
			<optgroup label="<?php echo $cntryNmae; ?>" >
			<?php	
				$this->db->select('*');
				$this->db->from('airports');
				$this->db->where('country_id', $country_code);
				$qryAirport = $this->db->get();
				foreach($qryAirport->result() as $fld){
				$fld->airport_code == 'CGK' ? $slctd = 'selected' : $slctd = '';
			?>
			<option value="<?php echo $fld->airport_code; ?>" <?php echo $slctd; ?> ><?php echo $fld->location_name.' - '.$fld->airport_code; ?></option>
			<?php
				}
			?>
			</optgroup>
			<?php
	      	}
      		?>
			   
			 </select>
		
		 </div>
		 
		
		 <div class="form-group">
			  	<div class="row">
			  		<div class="col-xs-2 col-sm-2 col-md-6 col-lg-6" id="departDate">
			  			<?php
			  			$currentDate = date('Y-m-d');
						$nextDay = date('Y-m-d', strtotime('+1 day'. $currentDate)); 
			  			?>
			  			<div class="form-group">
						    <label for="exampleInputPassword1">Departing</label>
						    <input type="text" class="form-control" name="departingDate" id="departingDate" value="<?php echo $nextDay; ?>">
						</div>
			  		</div>
			    	<div class="col-xs-2 col-sm-2 col-md-6 col-lg-6" id="returnDate" style="display: none;">
			    		<div class="form-group">
						    <label for="exampleInputPassword1">Returning</label>
						    <input type="text" class="form-control" name="returningDate" id="returningDate">
						</div>
					</div>
			  	</div>
			 
		 </div> 
		
		 <div class="form-group">
			  	<div class="row">
			  		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			  			<label for="exampleInputPassword1">Adults</label>
			    		<input type="text" class="form-control" name="adults" id="adults" value="1">
			  		</div>
			  		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			  			<label for="exampleInputPassword1">Childs</label>
			    		<input type="text" class="form-control" name="childs" id="childs" value="0">
			  		</div>
			  		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			  			<label for="exampleInputPassword1">Infants</label>
			    		<input type="text" class="form-control" name="infants" id="infants" value="0">
			  		</div>
			  	</div>
			
		 </div>  
		  
		 
		  
		  
		 <div class="form-group" align="right">
		  <button type="submit" class="btn btn-blue btn-lg">Search</button>
		 </div>
		 
		</form>
<?php /* form search flight form end */ ?>     		
      </div>
      
    </div>
</div>
<!-- ===================tabs container end here============ -->    
<div style="clear:both;">&nbsp;</div>
<!-- =======Cheapest flight fare section start======= -->
  <div class="panel panel-primary costumpanel visible-md visible-lg boxshadow" id="flightfarebox" >
      <div class="panel-heading costum_panel_head" style="background:#1792bc">
        <h3 class="panel-title" id="cheapest_flight_flare-header-panel-font" ><b>Cheapest Flight Fare</b></h3>
      </div>
      <div class="panel-body">
      	<?php
      	 if(!empty($fCgkToDps['departures']['result'])){
      	$i = 0;
			foreach($fCgkToDps['departures']['result'] as $row){
			$currency = $fCgkToDps['diagnostic']['currency'];	
			$imageUrl = $fCgkToDps['departures']['result'][$i]['image'];	
			$priceValue = $fCgkToDps['departures']['result'][$i]['price_value'];
			$routeFlight = $fCgkToDps['departures']['result'][$i]['departure_city_name'].'('.$fCgkToDps['departures']['result'][$i]['departure_city'].')'.' - '.$fCgkToDps['departures']['result'][$i]['arrival_city_name'].'('.$fCgkToDps['departures']['result'][$i]['arrival_city'].')';
			$flightNumber = $fCgkToDps['departures']['result'][$i]['flight_number'];
			$isPromo = $fCgkToDps['departures']['result'][$i]['is_promo'];	
					//echo $cheapFlight['departures']['result'][$i]['airlines_name'].'<br />';
					//echo $cheapFlight['departures']['result'][$i]['is_promo'].'<br />';
			if($priceValue == $fCgkToDps_lowestprice){
		?>
		<div style="margin-bottom:5px;">
        <div style="display:table-cell; height:60px; width:60px; background: #ccc url(<?php echo $imageUrl; ?>) no-repeat;-moz-background-size:100% 100%;-webkit-background-size:100% 100%;background-size:100% 100%;"><div style="text-align:center;font-weight:bold;position: relative; bottom: -45px; left: 0;z-index: 10;"><?php echo $flightNumber; ?></div></div>
        <div style="display:table-cell; padding-left:3px; vertical-align:middle;"><div style="font-weight:bold;"><?php echo $routeFlight; ?></div><div>From <?php echo $currency.' '.number_format($priceValue); ?></div></div>
        </div>
		<?php		
			}	
			$i++;
			}
		}
      	?>
        
        <?php
          if(!empty($fDpsToCgk['departures']['result'])){
      	$i = 0;
			foreach($fDpsToCgk['departures']['result'] as $row){
			$currency = $fDpsToCgk['diagnostic']['currency'];	
			$imageUrl = $fDpsToCgk['departures']['result'][$i]['image'];	
			$priceValue = $fDpsToCgk['departures']['result'][$i]['price_value'];
			$routeFlight = $fDpsToCgk['departures']['result'][$i]['departure_city_name'].'('.$fDpsToCgk['departures']['result'][$i]['departure_city'].')'.' - '.$fDpsToCgk['departures']['result'][$i]['arrival_city_name'].'('.$fDpsToCgk['departures']['result'][$i]['arrival_city'].')';
			$flightNumber = $fDpsToCgk['departures']['result'][$i]['flight_number'];
			$isPromo = $fDpsToCgk['departures']['result'][$i]['is_promo'];	
					//echo $cheapFlight['departures']['result'][$i]['airlines_name'].'<br />';
					//echo $cheapFlight['departures']['result'][$i]['is_promo'].'<br />';
			if($priceValue == $fDpsToCgk_lowestprice){
		?>
		<div style="margin-bottom:5px;">
        <div style="display:table-cell; height:60px; width:60px; background: #ccc url(<?php echo $imageUrl; ?>) no-repeat;-moz-background-size:100% 100%;-webkit-background-size:100% 100%;background-size:100% 100%;"><div style="text-align:center;font-weight:bold;position: relative; bottom: -45px; left: 0;z-index: 10;"><?php echo $flightNumber; ?></div></div>
        <div style="display:table-cell; padding-left:3px; vertical-align:middle;"><div style="font-weight:bold;"><?php echo $routeFlight; ?></div><div>From <?php echo $currency.' '.number_format($priceValue); ?></div></div>
        </div>
		<?php		
			}	
			$i++;
			}
		}
      	?>
      	
      	 <?php
      	  if(!empty($fCgkToJog['departures']['result'])){
      	$i = 0;
			foreach($fCgkToJog['departures']['result'] as $row){
			$currency = $fCgkToJog['diagnostic']['currency'];	
			$imageUrl = $fCgkToJog['departures']['result'][$i]['image'];	
			$priceValue = $fCgkToJog['departures']['result'][$i]['price_value'];
			$routeFlight = $fCgkToJog['departures']['result'][$i]['departure_city_name'].'('.$fCgkToJog['departures']['result'][$i]['departure_city'].')'.' - '.$fCgkToJog['departures']['result'][$i]['arrival_city_name'].'('.$fCgkToJog['departures']['result'][$i]['arrival_city'].')';
			$flightNumber = $fCgkToJog['departures']['result'][$i]['flight_number'];
			$isPromo = $fCgkToJog['departures']['result'][$i]['is_promo'];	
					//echo $cheapFlight['departures']['result'][$i]['airlines_name'].'<br />';
					//echo $cheapFlight['departures']['result'][$i]['is_promo'].'<br />';
			if($priceValue == $fCgkToJog_lowestprice){
		?>
		<div style="margin-bottom:5px;">
        <div style="display:table-cell; height:60px; width:60px; background: #ccc url(<?php echo $imageUrl; ?>) no-repeat;-moz-background-size:100% 100%;-webkit-background-size:100% 100%;background-size:100% 100%;"><div style="text-align:center;font-weight:bold;position: relative; bottom: -45px; left: 0;z-index: 10;"><?php echo $flightNumber; ?></div></div>
        <div style="display:table-cell; padding-left:3px; vertical-align:middle;"><div style="font-weight:bold;"><?php echo $routeFlight; ?></div><div>From <?php echo $currency.' '.number_format($priceValue); ?></div></div>
        </div>
		<?php		
			}	
			$i++;
			}
		}
      	?>
      	
      	<?php
      	 if(!empty($fJogToCgk['departures']['result'])){
      	$i = 0;
			foreach($fJogToCgk['departures']['result'] as $row){
			$currency = $fJogToCgk['diagnostic']['currency'];	
			$imageUrl = $fJogToCgk['departures']['result'][$i]['image'];	
			$priceValue = $fJogToCgk['departures']['result'][$i]['price_value'];
			$routeFlight = $fJogToCgk['departures']['result'][$i]['departure_city_name'].'('.$fJogToCgk['departures']['result'][$i]['departure_city'].')'.' - '.$fJogToCgk['departures']['result'][$i]['arrival_city_name'].'('.$fJogToCgk['departures']['result'][$i]['arrival_city'].')';
			$flightNumber = $fJogToCgk['departures']['result'][$i]['flight_number'];
			$isPromo = $fJogToCgk['departures']['result'][$i]['is_promo'];	
					//echo $cheapFlight['departures']['result'][$i]['airlines_name'].'<br />';
					//echo $cheapFlight['departures']['result'][$i]['is_promo'].'<br />';
			if($priceValue == $fJogToCgk_lowestprice){
		?>
		<div style="margin-bottom:5px;">
        <div style="display:table-cell; height:60px; width:60px; background: #ccc url(<?php echo $imageUrl; ?>) no-repeat;-moz-background-size:100% 100%;-webkit-background-size:100% 100%;background-size:100% 100%;"><div style="text-align:center;font-weight:bold;position: relative; bottom: -45px; left: 0;z-index: 10;"><?php echo $flightNumber; ?></div></div>
        <div style="display:table-cell; padding-left:3px; vertical-align:middle;"><div style="font-weight:bold;"><?php echo $routeFlight; ?></div><div>From <?php echo $currency.' '.number_format($priceValue); ?></div></div>
        </div>
		<?php		
			}	
			$i++;
			}
		}
      	?>
        
         <?php
		 if(!empty($fCgkToSub['departures']['result'])){
      	$i = 0;
			foreach($fCgkToSub['departures']['result'] as $row){
			$currency = $fCgkToSub['diagnostic']['currency'];	
			$imageUrl = $fCgkToSub['departures']['result'][$i]['image'];	
			$priceValue = $fCgkToSub['departures']['result'][$i]['price_value'];
			$routeFlight = $fCgkToSub['departures']['result'][$i]['departure_city_name'].'('.$fCgkToSub['departures']['result'][$i]['departure_city'].')'.' - '.$fCgkToSub['departures']['result'][$i]['arrival_city_name'].'('.$fCgkToSub['departures']['result'][$i]['arrival_city'].')';
			$flightNumber = $fCgkToSub['departures']['result'][$i]['flight_number'];
			$isPromo = $fCgkToSub['departures']['result'][$i]['is_promo'];	
					//echo $cheapFlight['departures']['result'][$i]['airlines_name'].'<br />';
					//echo $cheapFlight['departures']['result'][$i]['is_promo'].'<br />';
			if($priceValue == $fCgkToSub_lowestprice){
		?>
		<div style="margin-bottom:5px;">
        <div style="display:table-cell; height:60px; width:60px; background: #ccc url(<?php echo $imageUrl; ?>) no-repeat;-moz-background-size:100% 100%;-webkit-background-size:100% 100%;background-size:100% 100%;"><div style="text-align:center;font-weight:bold;position: relative; bottom: -45px; left: 0;z-index: 10;"><?php echo $flightNumber; ?></div></div>
        <div style="display:table-cell; padding-left:3px; vertical-align:middle;"><div style="font-weight:bold;"><?php echo $routeFlight; ?></div><div>From <?php echo $currency.' '.number_format($priceValue); ?></div></div>
        </div>
		<?php		
			}	
			$i++;
			}
		}
      	?>
      	
      	<?php
      	if(!empty($fSubToCgk['departures']['result'])){
      	$i = 0;
			foreach($fSubToCgk['departures']['result'] as $row){
			$currency = $fSubToCgk['diagnostic']['currency'];	
			$imageUrl = $fSubToCgk['departures']['result'][$i]['image'];	
			$priceValue = $fSubToCgk['departures']['result'][$i]['price_value'];
			$routeFlight = $fSubToCgk['departures']['result'][$i]['departure_city_name'].'('.$fSubToCgk['departures']['result'][$i]['departure_city'].')'.' - '.$fSubToCgk['departures']['result'][$i]['arrival_city_name'].'('.$fSubToCgk['departures']['result'][$i]['arrival_city'].')';
			$flightNumber = $fSubToCgk['departures']['result'][$i]['flight_number'];
			$isPromo = $fSubToCgk['departures']['result'][$i]['is_promo'];	
					//echo $cheapFlight['departures']['result'][$i]['airlines_name'].'<br />';
					//echo $cheapFlight['departures']['result'][$i]['is_promo'].'<br />';
			if($priceValue == $fSubToCgk_lowestprice){
		?>
		<div style="margin-bottom:5px;">
        <div style="display:table-cell; height:60px; width:60px; background: #ccc url(<?php echo $imageUrl; ?>) no-repeat;-moz-background-size:100% 100%;-webkit-background-size:100% 100%;background-size:100% 100%;"><div style="text-align:center;font-weight:bold;position: relative; bottom: -45px; left: 0;z-index: 10;"><?php echo $flightNumber; ?></div></div>
        <div style="display:table-cell; padding-left:3px; vertical-align:middle;"><div style="font-weight:bold;"><?php echo $routeFlight; ?></div><div>From <?php echo $currency.' '.number_format($priceValue); ?></div></div>
        </div>
		<?php		
			}	
			$i++;
			}
		}
      	?>
      	
      	 <?php
      		if(!empty($fCgkToSin['departures']['result'])){
      	$i = 0;
			foreach($fCgkToSin['departures']['result'] as $row){
			$currency = $fCgkToSin['diagnostic']['currency'];	
			$imageUrl = $fCgkToSin['departures']['result'][$i]['image'];	
			$priceValue = $fCgkToSin['departures']['result'][$i]['price_value'];
			$routeFlight = $fCgkToSin['departures']['result'][$i]['departure_city_name'].'('.$fCgkToSin['departures']['result'][$i]['departure_city'].')'.' - '.$fCgkToSin['departures']['result'][$i]['arrival_city_name'].'('.$fCgkToSin['departures']['result'][$i]['arrival_city'].')';
			$flightNumber = $fCgkToSin['departures']['result'][$i]['flight_number'];
			$isPromo = $fCgkToSin['departures']['result'][$i]['is_promo'];	
					//echo $cheapFlight['departures']['result'][$i]['airlines_name'].'<br />';
					//echo $cheapFlight['departures']['result'][$i]['is_promo'].'<br />';
			if($priceValue == $fCgkToSin_lowestprice){
		?>
		<div style="margin-bottom:5px;">
        <div style="display:table-cell; height:60px; width:60px; background: #ccc url(<?php echo $imageUrl; ?>) no-repeat;-moz-background-size:100% 100%;-webkit-background-size:100% 100%;background-size:100% 100%;"><div style="text-align:center;font-weight:bold;position: relative; bottom: -45px; left: 0;z-index: 10;"><?php echo $flightNumber; ?></div></div>
        <div style="display:table-cell; padding-left:3px; vertical-align:middle;"><div style="font-weight:bold;"><?php echo $routeFlight; ?></div><div>From <?php echo $currency.' '.number_format($priceValue); ?></div></div>
        </div>
		<?php		
			}	
			$i++;
			}
		}
      	?>
      	
      	<?php
      	if(!empty($fCgkToKul['departures']['result'])){
      	$i = 0;
			foreach($fCgkToKul['departures']['result'] as $row){
			$currency = $fCgkToKul['diagnostic']['currency'];	
			$imageUrl = $fCgkToKul['departures']['result'][$i]['image'];	
			$priceValue = $fCgkToKul['departures']['result'][$i]['price_value'];
			$routeFlight = $fCgkToKul['departures']['result'][$i]['departure_city_name'].'('.$fCgkToKul['departures']['result'][$i]['departure_city'].')'.' - '.$fCgkToKul['departures']['result'][$i]['arrival_city_name'].'('.$fCgkToKul['departures']['result'][$i]['arrival_city'].')';
			$flightNumber = $fCgkToKul['departures']['result'][$i]['flight_number'];
			$isPromo = $fCgkToKul['departures']['result'][$i]['is_promo'];	
					//echo $cheapFlight['departures']['result'][$i]['airlines_name'].'<br />';
					//echo $cheapFlight['departures']['result'][$i]['is_promo'].'<br />';
			if($priceValue == $fCgkToKul_lowestprice){
		?>
		<div style="margin-bottom:5px;">
        <div style="display:table-cell; height:60px; width:60px; background: #ccc url(<?php echo $imageUrl; ?>) no-repeat;-moz-background-size:100% 100%;-webkit-background-size:100% 100%;background-size:100% 100%;"><div style="text-align:center;font-weight:bold;position: relative; bottom: -45px; left: 0;z-index: 10;"><?php echo $flightNumber; ?></div></div>
        <div style="display:table-cell; padding-left:3px; vertical-align:middle;"><div style="font-weight:bold;"><?php echo $routeFlight; ?></div><div>From <?php echo $currency.' '.number_format($priceValue); ?></div></div>
        </div>
		<?php		
			}	
			$i++;
			}
		}
      	?>
        
        <div align="left" style="padding:5px">
		<button type="button" class="btn btn-darkgrey"><b>More Deals</b></button>
		</div>
      </div>
  </div>
<!-- =======Cheapest flight fare section end======= -->