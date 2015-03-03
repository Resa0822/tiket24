<style>
.hotel-info-on-image-left-bottom{
background: #000;
padding:5px;
color: #fff;
cursor: pointer;
z-index: 3;
bottom: 0px;
left: 0px;
position: absolute;
background: rgb(0, 0, 0); 
background: rgba(0, 0, 0, 0.6); 
filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);  
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);	
}	
.hotel-price-right-bottom{
background: #000;
font-weight: bold;
font-size:16px;
padding:10px;
color: #fff;
cursor: pointer;
z-index: 3;
bottom: 0px;
right: 0px;
position: absolute;
background: rgb(0, 0, 0); 
background: rgba(0, 0, 0, 0.6); 
filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);  
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);	
}
</style>
<?php
$currency = 'IDR';
$hotelName = $hotelDetails['HotelInformationResponse']['HotelSummary']['name'];
$hotelAddress = $hotelDetails['HotelInformationResponse']['HotelSummary']['address1'].', '.$hotelDetails['HotelInformationResponse']['HotelSummary']['city'];
$price = $hotelDetails['HotelInformationResponse']['HotelSummary']['highRate'];
$mainImg = $hotelDetails['HotelInformationResponse']['HotelImages']['HotelImage'][0]['url'];
$numberOfRooms = $hotelDetails['HotelInformationResponse']['HotelDetails']['numberOfRooms'];
$ratings = $hotelDetails['HotelInformationResponse']['HotelSummary']['hotelRating'];
$reviews = $hotelDetails['HotelInformationResponse']['HotelSummary']['tripAdvisorReviewCount'];
?>
<div class="container-fluid">
<!-- image section start -->	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background: url(<?php echo $mainImg; ?>) no-repeat;background-size: 100% 100%; height: 400px" >
			<div class="hotel-info-on-image-left-bottom">
				<div><?php echo $hotelName; ?></div>
				<div><?php echo $hotelAddress; ?></div>
			</div>
			<div class="hotel-price-right-bottom">
				<div>From <?php echo $currency.' '.$price; ?></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="background: #535758;border-top:1px #fff solid;border-bottom:1px #fff solid;border-right:1px #fff solid;" >
        	<div style="padding:10px; width: 100%;margin: 0px;">
        		<span style="color:#fff; font-weight: bold;">Number Of Rooms : </span>
        		<span style="color:#f9eb05; font-weight: bold;"><?php echo $numberOfRooms; ?></span>
        	</div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="background: #535758;border-top:1px #fff solid;border-bottom:1px #fff solid;border-right:1px #fff solid;" >
        	<div style="padding:10px;width: 100%; margin: 0px;">
        		<span style="color:#fff; font-weight: bold;">Hotel Rating : </span>
        		<span style="color:#f9eb05; font-weight: bold;"><?php echo number_format($ratings, 1).' / '.$reviews.' reviews'; ?></span>
        	</div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding: 3px;" >
        	<div><button type="button" class="btn btn-blue btn-block pull-right"><b>Book Now</b></button></div>
        </div>
	</div>
<!-- image section end -->	
<!-- available room list start here -->
<div class="container-fluid" >
	<div class="row" style="background: #1792bc;color:#fff;font-weight: bold;padding:5px;border-bottom:1px #ccc solid;font-size: 18px;">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			Please Choose Your Room
		</div>
	</div>
	
		<?php
		$a=0;
		foreach($hotelDetails['HotelInformationResponse']['RoomTypes']['RoomType'] as $room){
			
			$roomType = $hotelDetails['HotelInformationResponse']['RoomTypes']['RoomType'][$a]['description'];
			$roomDesc = $hotelDetails['HotelInformationResponse']['RoomTypes']['RoomType'][$a]['descriptionLong'];
			$a++;
		?>
		
	<div class="row" style="background: #1792bc;color:#fff;border-bottom:1px #ccc solid;">
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			&nbsp;
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			<div style="font-size: 16px;"><?php echo '<b>'.$roomType.'</b>'; ?></div>
			<div><?php echo $roomDesc; ?></div>
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			&nbsp;
		</div>
	</div>
	<?php
	}
	?>
</div>
<!-- available room list end here -->
<hr style="border: 1px #666a6b solid;" />
<!-- image gallery section start -->
<div class="container-fluid" >	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><span style="padding-left:0px;color:#0a419c; font-size:18px;font-weight: bold;">Photo Gallery</span></div>
	</div>	
	
		<?php
		
		$i=0;
		$j=1;
		foreach($hotelDetails['HotelInformationResponse']['HotelImages']['HotelImage'] as $gmbr){
			$gbrUrl = $hotelDetails['HotelInformationResponse']['HotelImages']['HotelImage'][$i]['url'];
			$imgType  = $hotelDetails['HotelInformationResponse']['HotelImages']['HotelImage'][$i]['caption'];
			if($imgType == 'Featured Image'){
				$imgCaption = 'Hotel';
			}
			else{
				$imgCaption = $imgType;
			}
				if($j == 1 || $j == 5 || $j == 9 || $j == 13 || $j == 17 || $j == 21 || $j == 25){
					
					?>
					<div class="row">
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="padding:5px;">
						<div class="thumbnail" style="text-align: center">
							<div><img src="<?php echo $gbrUrl; ?>" width="200" height="150" class="img-responsive box-shadow"  /></div>
							<div><?php echo $imgCaption; ?></div>
						</div>
					</div>
					<?php
				}
				elseif($j == 4 || $j == 8 || $j == 12 || $j == 16 || $j == 20 || $j == 24 || $j == 28){
					
					?>
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="padding:5px;">
						<div class="thumbnail" style="text-align: center">
							<div><img src="<?php echo $gbrUrl; ?>" width="200" height="150" class="img-responsive box-shadow" /></div>
							<div><?php echo $imgCaption; ?></div>
						</div>
					</div>
					</div>
					<?php
				}
				else{
				?>
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="padding:5px;">
						<div class="thumbnail" style="text-align: center">
							<div><img src="<?php echo $gbrUrl; ?>" width="200" height="150" class="img-responsive box-shadow"  /></div>
							<div><?php echo $imgCaption; ?></div>
						</div>
					</div>
				<?php	
				}
				
		$i++;
		$j++;
		}
		
		?>
	
</div>
<!-- image gallery section end -->	
<!-- hotel facilities info start  -->
<div class="panel-group" id="accordion" style="background: #87cadb">
  <div class="panel panel-default" style="border: none;">
    <div class="panel-heading" style="background:#1792bc; padding: 0px;">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style="text-decoration: none;">
          <div style="padding: 10px; font-weight: bold;color: #fff; font-size: 16px;">Hotel Facilities</div>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" style="background: #87cadb; border:0px;">
      <div class="panel-body" style="border: none;">
      	<div class="row">
      	<?php
      	$b=0;
		foreach($hotelDetails['HotelInformationResponse']['PropertyAmenities']['PropertyAmenity'] as $gmbr){
			$fclty = $hotelDetails['HotelInformationResponse']['PropertyAmenities']['PropertyAmenity'][$b]['amenity'];
		?>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"">
				<?php echo '&#8680; '.$fclty; ?>
			</div>
		<?php
		$b++;
		}
      	?>
        </div>
      </div>
    </div>
  </div>
  <div class="panel panel-default" style="border: none;">
    <div class="panel-heading" style="background:#1792bc; padding: 0px;">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" style="text-decoration: none;">
          <div style="padding: 10px; font-weight: bold;color: #fff; font-size: 16px;">Room Facilities</div>
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" style="background: #87cadb; border:0px;">
      <div class="panel-body" style="border: none;">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="panel panel-default" style="border: none;">
    <div class="panel-heading" style="background:#1792bc; padding: 0px;">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" style="text-decoration: none;">
          <div style="padding: 10px; font-weight: bold;color: #fff; font-size: 16px;">Sport Facilities</div>
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" style="background: #87cadb; border:0px;">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>
<!-- hotel facilities info end  -->
<!-- hotel additional information start -->
<div style="padding: 0px 10px 0px 10px; ">
	<div style="color:#104593;font-size:24px;">Additional Information</div>
	<div>
	<?php
	$areaInformation = $hotelDetails['HotelInformationResponse']['HotelDetails']['propertyDescription'];
	  echo htmlentities($areaInformation).'<br />';
	?>
		<ul style="list-style-image: url(<?php echo base_url(); ?>assets/images/icons/right-double-arrow12px.png);">
		  <li >Dapibus ac facilisis in</li>
		  <li >Cras sit amet nibh libero</li>
		  <li >Porta ac consectetur ac</li>
		  <li >Vestibulum at eros</li>
		</ul>
	</div>
</div>
<!-- hotel additional information end -->

<div style="padding: 0px 10px 0px 10px; "> 
	<div style="color:#104593;font-size:24px;">Hotel Policies & Fees (Not Applicable For Promo)</div>
	<div>
		<ul style="list-style-image: url(<?php echo base_url(); ?>assets/images/icons/right-double-arrow12px.png);">
		  <li >Dapibus ac facilisis in</li>
		  <li >Cras sit amet nibh libero</li>
		  <li >Porta ac consectetur ac</li>
		  <li >Vestibulum at eros</li>
		</ul>
	</div>
</div>
</div>