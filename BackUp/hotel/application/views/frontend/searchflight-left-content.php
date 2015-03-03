<!-- ===================tabs container start here============ --> 
<script>
$(document).ready(function(){
	$('#returnDate').attr('disabled','disabled');
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
    	$('#returnDate').removeAttr('disabled');
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
      <li <?php echo $tabsSearchHotelActive; ?>><a href="#hotel" role="tab" data-toggle="tab">HOTEL</a></li>
      <li <?php echo $tabsSearchFlightActive; ?>><a href="#flight" role="tab" data-toggle="tab">FLIGHT</a></li>
</ul>
    <div id="hotelFlightContent" class="tab-content" style="background:#60d9ec; border-bottom:2px #1792bc solid;border-left:2px #1792bc solid;border-right:2px #1792bc solid; padding:3px;">
      <div <?php echo $tabsCntntHotelActive; ?> id="hotel">
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
      <div <?php echo $tabsCntntFlightActive; ?> id="flight">
<?php /* form search flight form start */ ?>      
      	<form role="form" action="<?php echo base_url().'searchflight'; ?>" method="get" name="searchFlight"  id="searchFlight" enctype="multipart/form-data" >
      	<div class="row">	
	      	<div class="col-xs-3 col-sm-3 col-md-12 col-lg-12">	
	      	  <div class="form-group" >
	           <label class="radio-inline" for="onewayTrip"> <input type="radio" name="flightTrip" id="onewayTrip" value="1" checked> One Way </label>
	           <label class="radio-inline" for="roundTrip"> <input type="radio" name="flightTrip" id="roundTrip" value="2"> Round Trip </label>
			  </div>		
			 </div> 
		 </div>
		 
		 <div class="row">
		 <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> 
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
		 </div>
		 <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> 
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
		 </div>
		 
		 <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> 
		 	 <div class="form-group">
			  	<div class="row">
			  		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="departDate">
			  			<?php
			  			$currentDate = date('Y-m-d');
						$nextDay = date('Y-m-d', strtotime('+1 day'. $currentDate)); 
			  			?>
			  			<div class="form-group">
						    <label for="exampleInputPassword1">Departing</label>
						    <input type="text" class="form-control"  name="departingDate" id="departingDate" value="<?php echo $nextDay; ?>">
						</div>
			  		</div>
			    	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="returnDate" style="display: none;">
			    		<div class="form-group">
						    <label for="exampleInputPassword1">Returning</label>
						    <input type="text" class="form-control" name="returningDate" id="returningDate">
						</div>
					</div>
			  	</div>
			  </div>
		 </div> 
		 </div>
		 
		 <div class="row">
		 <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> 
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
