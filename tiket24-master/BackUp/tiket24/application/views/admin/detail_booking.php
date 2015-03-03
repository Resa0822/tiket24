<?php
$getURL = $this->uri->uri_to_assoc(3);
$transCode = $getURL['tc'];
$qrySlctBkng = mysql_query("SELECT * FROM book_packages WHERE transaction_code='$transCode'");
$fld = mysql_fetch_array($qrySlctBkng);
?>
<!--<script type="text/javascript" src="<?=base_url()?>asset/js/jquery-1.10.2.js"></script>-->


<script>
$(document).ready(function(){
var kode = "<?php echo $fld['transaction_code']; ?>";	
	
	
	$('#validateBooking').click(function(){
		 
       $.ajax({   
           url: "<?=base_url()?>index.php/ajaxHandler/validateBooking", 
           async: false,
           type: "POST", 
           data: {"trnsctnCode": kode}, 
           dataType: "html", 
           beforeSend: function () {
			 
                        //$("#ajaxContainer").html('<div align="center"><img src="<?=base_url()?>asset/images/icon/ajax-loader.gif" style="display: block; margin-left: auto; margin-right: auto;width:30px" />wait...</div>');
                       $('#validateBooking').hide();
                       $('#imgLoadr').show('slow');
                       $('#imgLoadr').html('<img src="<?php echo base_url(); ?>asset/images/icon/ajax-loader.gif" style="width:30px;"  /> Please wait...');
                        //$('#imgLoader').effect("bounce", { times: 20 }, "slow");
                        //$('#validateBooking').val('please wait, processing...');
    			        //$('#validateBooking').attr('disabled','disabled');
                        },
                      
          success: function(data) {
                        
                    $('#validateBooking').val('Validated');
    			    $('#validateBooking').attr('disabled','disabled');
    			    $('#imgLoadr').hide('slow');
					$('#validateBooking').show('bounce', { times: 3 }, 'slow');
					$('#pesan').show('slow');
					$('#pesan').html( data );
                        //$('#validateBooking').val('please wait, processing...');
    			   
                   },
         
      })
                            
                     
	});
	
});	
</script>


<!-- ========================================================= -->
<?php //if($this->session->userdata('role_id','1')){ //if session is created then login to members page ?>
<div id="hotel-content-info" class="stylebox">
	<div style="clear: both;"></div>
	<h2>Detail Package Booking</h2>
	  
<?php 

$qrySlctBkng = mysql_query("SELECT * FROM book_packages WHERE transaction_code='$transCode'");
$fld = mysql_fetch_array($qrySlctBkng);
$usrRole = $fld['user_role'];

$user = mysql_query("SELECT * FROM roles WHERE role_id='$usrRole' ");
$getUsr = mysql_fetch_array($user);
$pckgID = $fld['API_packages_id'];
$qryPckg = mysql_query("SELECT * FROm packages WHERE API_packages_id='$pckgID' ");
$getPckgFld = mysql_fetch_array($qryPckg);  
$qryTrvlrLeader = mysql_query("SELECT * FROM traveler_info WHERE transaction_code='$transCode' AND API_packages_id='$pckgID' AND isLeader='1' ");
$getTrvlrLdr = mysql_fetch_array($qryTrvlrLeader);
$qryTrvlrCntct = mysql_query("SELECT * FROM traveler_info WHERE transaction_code='$transCode' AND API_packages_id='$pckgID' AND isContact='1' ");
$getTrvlrCntct = mysql_fetch_array($qryTrvlrCntct);
$pickupDropoffPoint = $fld['pickup_dropoff'];
$qryPckupDropoff = mysql_query("SELECT * FROM pickup_point WHERE API_packages_id='$pckgID' AND hotel_code='$pickupDropoffPoint' ");
$getPckupDropoff = mysql_fetch_array($qryPckupDropoff);

$qryAdltTrvlr = mysql_query("SELECT * FROM traveler_info WHERE transaction_code='$transCode' AND API_packages_id='$pckgID' AND isAdult='1' ");
$qryChldTrvlr = mysql_query("SELECT * FROM traveler_info WHERE transaction_code='$transCode' AND API_packages_id='$pckgID' AND isChild='1' ");
$totAdltTrvlr = mysql_num_rows($qryAdltTrvlr);
$totChldTrvlr = mysql_num_rows($qryChldTrvlr);
$qryTours = mysql_query("SELECT * FROM tours WHERE API_packages_id='$pckgID' ");

$statusBooking = $fld['validated'];
switch($statusBooking){
	case 0 : $bkngStts = '<span style="color:#FF0000;font-weight:bold;">Waiting for validate</span>';break;
	case 1 : $bkngStts = '<span style="color:#006600;font-weight:bold;">It\'s Validated</span>';break;
}
$pymntMthd = $fld['payment_method'];
switch($pymntMthd){
	case 'MP0001' : $paymentMethod = 'Credit Card';break;
	case 'MP0002' : $paymentMethod = 'BCA Bank Transfer';break;
	case 'MP0003' : $paymentMethod = 'BNI Bank Transfer';break;
}
$newDate = date("d M Y", strtotime($fld['booking_date']));
 ?>
	
		
<div id="grid" class="k-grid k-widget k-secondary k-reorderable" data-role="grid" style="">

<div style="width:100%; ;padding:10px;">
<?php
if($fld['validated'] == '0'){
	$bttnVldtVal = 'Validate Booking';
	$bttnVldtDsbld = '';
	
}
else{
	$bttnVldtVal = 'Validated';
	$bttnVldtDsbld = 'disabled = "disabled"';
}
?>
<div style="padding: 10px; display: inline-block;"><a href="<?php echo base_url(); ?>index.php/booking/master"><input type="button" name="back" id="back" value="Back"  /></a></div>
<div style="padding: 10px; display: inline-block;"><input type="button" name="validateBooking" id="validateBooking" value="<?php echo $bttnVldtVal; ?>" <?php echo $bttnVldtDsbld; ?>  />
	<div id="imgLoadr"></div>
</div>	
<div id="pesan" style="display: inline-block;"></div>	
	
	
</div>
	
 <table>
 	
 	<tr>
 		<td style="width:150px;">Transaction Number </td>
 		<td style="border-bottom: 1px #ccc solid;border-top: 1px #ccc solid;">: <?php echo '<b>'.$transCode.'</b>'; ?></td>
 	</tr>
 	<tr>
 		<td>Booking Date </td>
 		<td style="border-bottom: 1px #ccc solid;">: <?php echo $newDate; ?></td>
 	</tr>
 	<tr>
 		<td>Booking Status</td>
 		<td style="border-bottom: 1px #ccc solid;">: <?php echo $bkngStts; ?></td>
 	</tr>
 	<tr>
 		<td>User Type</td>
 		<td style="border-bottom: 1px #ccc solid;">: <?php echo ucfirst($getUsr['role']); ?></td>
 	</tr>
 	<?php
 	$usrRoleID = $fld['user_role'];
 	if($usrRoleID !== '4'){
 		$bookingUserID = $fld['user_id'];
		$qrySlctUsers = mysql_query("SELECT * FROM users WHERE users_id='$bookingUserID' ");
		$getFldUsrs = mysql_fetch_array($qrySlctUsers);
		
	?>
	 
	 <tr>
	 	<td>Username</td>
	 	<td style="border-bottom: 1px #ccc solid;">: <?php echo $getFldUsrs['username']; ?></td>
	 </tr>
	<?php   }	?>	
 	
 	
 	<tr>
 		<td>Pick Up / Drop Off Point</td>
 		<td style="border-bottom: 1px #ccc solid;">: <?php echo $getPckupDropoff['hotel_name']; ?></td>
 	</tr>
 	<tr>
 		<td style="vertical-align: top">Payment Info</td>
 		<td>
 			<table>
			<tr>
 				<td colspan="2" style="border-bottom: 1px #999 solid; background: #ccc; font-weight:bold; text-decoration: underline;">Payment Details</td>
  			</tr>
  			<tr>
 				<td style="width: 200px;border-bottom: 1px #ccc solid;">Total Adult Price</td>
	 			<td style="border-bottom: 1px #ccc solid;">: <?php $totAdultPrice= $totAdltTrvlr * $fld['adult_sale_price']; echo $totAdltTrvlr.'&nbsp;x&nbsp;<b>'.$fld['currency_code'].'</b>&nbsp;'.$fld['adult_sale_price'].',-&nbsp;&nbsp;=&nbsp;<b>'.$fld['currency_code'].'</b>&nbsp;'.$totAdultPrice.',-'; ?></td>
  			</tr>
  			<?php
  			if($totChldTrvlr !== 0 || !empty($totChldTrvlr)){
  				$totChildPrice= $totChldTrvlr * $fld['child_sale_price'];
  			?>
  			<tr>
 				<td style="width: 200px;border-bottom: 1px #ccc solid;">Total Child Price</td>
	 			<td style="border-bottom: 1px #ccc solid;">: <?php echo $totChldTrvlr.'&nbsp;x&nbsp;<b>'.$fld['currency_code'].'</b>&nbsp;'.$fld['child_sale_price'].',-&nbsp;&nbsp;=&nbsp;<b>'.$fld['currency_code'].'</b>&nbsp;'.$totChildPrice.',-'; ?></td>
  			</tr>
  			<?php } ?>
  			<tr>
 				<td style="width: 200px;border-bottom: 1px #ccc solid;">Total Amount</td>
	 			<td style="border-bottom: 1px #ccc solid;">: <?php echo '<b>'.$fld['currency_code'].'</b>&nbsp;'.$fld['total_amount'].',-'; ?></td>
  			</tr>
			<tr>
	 			<td style="width: 200px;border-bottom: 1px #ccc solid;">Payment Method</td>
	 			<td style="border-bottom: 1px #ccc solid;">: <?php echo $paymentMethod; ?></td>
	 		</tr>
	 		</table>
	 		<?php 
 			if($pymntMthd == 1){
 			?>
	 		<table>
			<tr>
 				<td colspan="2" style="border-bottom: 1px #999 solid; background: #ccc;font-weight:bold;text-decoration: underline;">Credit Card Details</td>
  			</tr>
			<tr>
	 			<td style="width: 200px;border-bottom: 1px #ccc solid;">Name On Card</td>
	 			<td style="border-bottom: 1px #ccc solid;">: <?php echo $fld['name_on_card']; ?></td>
	 		</tr>
		 	<tr>
		 		<td style="width: 200px;border-bottom: 1px #ccc solid;">Card Number</td>
		 		<td style="border-bottom: 1px #ccc solid;">: <?php echo $fld['credit_card_number']; ?></td>
		 	</tr>
		 	<tr>
		 		<td style="width: 200px;border-bottom: 1px #ccc solid;">Security Code</td>
		 		<td style="border-bottom: 1px #ccc solid;">: <?php echo $fld['card_secure_code']; ?></td>
		 	</tr>
		 	<tr>
		 		<td style="width: 200px;border-bottom: 1px #ccc solid;">Card Expiry</td>
		 		<td style="border-bottom: 1px #ccc solid;">: <?php  echo $fld['card_expiry']; ?></td>
		 	</tr>
		</table>
	 	<?php		
 			}
 		?>
		</td>
 	</tr>
 	 	
 
 	<tr>
 		<td style="width:150px; vertical-align: top;">Flight Info </td>
 		<td>
 			<table>
				<tr><td colspan="2" style="border-bottom: 1px #999 solid; background: #ccc;font-weight:bold;text-decoration: underline;">Flight Details</td></tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Arrive Flight Number</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $fld['arrive_flight_number']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Departure Flight Number</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $fld['departure_flight_number']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Arrive Flight Date</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php $arrvFlghtDte = date("d M Y", strtotime($fld['arrive_flight_date'])); echo $arrvFlghtDte; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Departure Flight Date</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php $dprtrFlghtDte = date("d M Y", strtotime($fld['departure_flight_date'])); echo $dprtrFlghtDte; ?></td>
				</tr>
			</table>
 		</td>
 	</tr>
 	<tr>
 		<td style="width:150px; vertical-align: top;">Package Info </td>
 		<td> 
 			<table>
				<tr><td colspan="2" style="border-bottom: 1px #999 solid; background: #ccc;font-weight:bold;text-decoration: underline;">Package Details</td></tr>
				<tr>
					<td style="width: 200px; border-bottom: 1px #ccc solid;">Package Name</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getPckgFld['nama']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;vertical-align: top">Tours</td>
					<td><ol>
						<?php 
						while($getTours=mysql_fetch_array($qryTours)){
							echo '<li>'.$getTours['tour_name'].'</li>';
						}
						?>
						</ol>
					</td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Adult Price (* from API)</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo '<b>'.$fld['currency_code'].'</b>'.'&nbsp;'.$fld['price_adult'],' ,-'; ?></td>
				</tr><tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Child Price (* from API)</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo '<b>'.$fld['currency_code'].'</b>'.'&nbsp;'.$fld['price_child'].' ,-'; ?></td>
				</tr>
				
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Adult Price<br />(* sale price)</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo '<b>'.$fld['currency_code'].'</b>'.'&nbsp;'.$fld['adult_sale_price'],' ,-'; ?></td>
				</tr><tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Child Price<br />(* sale price)</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo '<b>'.$fld['currency_code'].'</b>'.'&nbsp;'.$fld['child_sale_price'].' ,-'; ?></td>
				</tr>
			</table>
 		</td>
 	</tr>
 	
 	<tr>
 		<td style="vertical-align: top;">Traveler Info</td>
 		<td>
			<table>
				<?php 
				$countryCodeTL = $getTrvlrLdr['passport_issuance_country'];
				$qryIssncCntryTL = mysql_query("SELECT * FROM country WHERE country_iso='$countryCodeTL' ") ;
				$getIssncCntryFldTL = mysql_fetch_array($qryIssncCntryTL);
				
				$ntnltyTL = $getTrvlrLdr['nationality_code'];
				$qryNtnltyTL = mysql_query("SELECT * FROM country WHERE country_iso='$ntnltyTL' ") ;
				$getNtnltyFldTL = mysql_fetch_array($qryNtnltyTL);
				
				$cntryCodeTC = $getTrvlrCntct['country_code'];
				$qryCountryTC = mysql_query("SELECT * FROM country WHERE country_iso='$cntryCodeTC' ") ;
				$getCntryFldTC = mysql_fetch_array($qryCountryTC);
				
				$ctyCodeTC = $getTrvlrCntct['city_code'];
				$qryCityTC = mysql_query("SELECT * FROM city WHERE city_iso='$ctyCodeTC' ") ;
				$getCtyFldTC = mysql_fetch_array($qryCityTC);
				
				$cntryNtnltyTC = $getTrvlrCntct['nationality_code'];
				$qryNtnltyTC = mysql_query("SELECT * FROM country WHERE country_iso='$cntryNtnltyTC' ") ;
				$getNtnltyFldTC = mysql_fetch_array($qryNtnltyTC);
				
				?>
				<!-- traveler leader info -->
				<tr><td colspan="2" style="border-bottom: 1px #999 solid; background: #ccc;font-weight:bold;text-decoration: underline;">Traveler Leader Details</td></tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Full Name</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getTrvlrLdr['title'].'&nbsp;'.ucwords($getTrvlrLdr['first_name']).'&nbsp;'.ucwords($getTrvlrLdr['last_name']); ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Day of Birth</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php $trvlrDOB = date("d M Y", strtotime($getTrvlrLdr['dob'])); echo $trvlrDOB; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Age</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getTrvlrLdr['age']; ?> Years Old</td>
				</tr>
				<tr>
					<td>Passport Number</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getTrvlrLdr['passport_number']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Passport Expiry Date</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getTrvlrLdr['passport_expired_date']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Passport Issuance Country</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getIssncCntryFldTL['country_name']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Nationality</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getNtnltyFldTL['country_name']; ?></td>
				</tr>
				<!-- traveler contact info -->
				<tr><td colspan="2" style="border-bottom: 1px #999 solid; background: #ccc;font-weight:bold;text-decoration: underline;">Traveler Contact Details</td></tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Full Name</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getTrvlrCntct['title'].'&nbsp;'.ucwords($getTrvlrCntct['first_name']).'&nbsp;'.ucwords($getTrvlrCntct['last_name']); ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Contact Number</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getTrvlrCntct['contact_number']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Mobile Number</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getTrvlrCntct['mobile_number']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Fax Number</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php $getTrvlrCntct['fax_number'] !== '' ? $faxNum = $getTrvlrCntct['fax_number'] : $faxNum = '-'; echo $faxNum;  ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Email</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getTrvlrCntct['email']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Alternate Email</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php $getTrvlrCntct['email'] !== '' ? $altrntEmail = $getTrvlrCntct['email'] : $altrntEmail = '-'; echo $altrntEmail;  ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Address</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getTrvlrCntct['address']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Postal Code</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getTrvlrCntct['postal_code']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Country</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getCntryFldTC['country_name']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">City</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo  $getCtyFldTC['city_name']; ?></td>
				</tr>
				<tr>
					<td>Nationality</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getNtnltyFldTC['country_name']; ?></td>
				</tr>
				<?php 
				$i = 1;
				while($getAdltTrvlr = mysql_fetch_array($qryAdltTrvlr)){
					$adltIssncCntry = $getAdltTrvlr['passport_issuance_country'];
					$qryGetIssncCntryAdlt = mysql_query("SELECT * FROM country WHERE country_iso='$adltIssncCntry' ");
					$nmCntryIssncCntryAdlt = mysql_fetch_array($qryGetIssncCntryAdlt);
					
					$adltNtnltyCntry = $getAdltTrvlr['nationality_code'];
					$qryGetNtnltyAdlt = mysql_query("SELECT * FROM country WHERE country_iso='$adltNtnltyCntry' ");
					$nmCntryNtnltyCntryAdlt = mysql_fetch_array($qryGetNtnltyAdlt);
					
					
				?>
				<tr><td colspan="2" style="border-bottom: 1px #999 solid; background: #ccc;font-weight:bold;text-decoration: underline;">(<?php echo $i; ?>) Adult Traveler</td></tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Full Name</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getAdltTrvlr['title'].'&nbsp;'.ucwords($getAdltTrvlr['first_name']).'&nbsp;'.ucwords($getAdltTrvlr['last_name']); ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Day of Birth</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php $adultTrvlrDOB = date("d M Y", strtotime($getAdltTrvlr['dob'])); echo $adultTrvlrDOB; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Age</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getAdltTrvlr['age']; ?> Years Old</td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Passport Number</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getAdltTrvlr['passport_number']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Passport Expiry Date</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getAdltTrvlr['passport_expired_date']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Passport Issuance Country</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $nmCntryIssncCntryAdlt['country_name']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Nationality</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $nmCntryNtnltyCntryAdlt['country_name']; ?></td>
				</tr>
				<?php	
				$i++;
				}
				?>
				
				<?php 
				$j = 1;
				while($getChldTrvlr = mysql_fetch_array($qryChldTrvlr)){
					$chldIssncCntry = $getChldTrvlr['passport_issuance_country'];
					$qryGetIssncCntryChld = mysql_query("SELECT * FROM country WHERE country_iso='$adltIssncCntry' ");
					$nmCntryIssncCntryChld = mysql_fetch_array($qryGetIssncCntryChld);
					
					$chldNtnltyCntry = $getChldTrvlr['nationality_code'];
					$qryGetNtnltyChld = mysql_query("SELECT * FROM country WHERE country_iso='$chldNtnltyCntry' ");
					$nmCntryNtnltyCntryChld = mysql_fetch_array($qryGetNtnltyChld);
				?>
				<tr><td colspan="2" style="border-bottom: 1px #999 solid; background: #ccc;font-weight:bold;text-decoration: underline;">(<?php echo $j; ?>) Child Traveler</td></tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Full Name</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo ucwords($getChldTrvlr['first_name']).'&nbsp;'.ucwords($getChldTrvlr['last_name']); ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Day of Birth</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php $childTrvlrDOB = date("d M Y", strtotime($getChldTrvlr['dob']));  echo $childTrvlrDOB; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Age</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getChldTrvlr['age']; ?> Years Old</td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Passport Number</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getChldTrvlr['passport_number']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Passport Expiry Date</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $getChldTrvlr['passport_expired_date']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Passport Issuance Country</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $nmCntryIssncCntryChld['country_name']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px;border-bottom: 1px #ccc solid;">Nationality</td>
					<td style="border-bottom: 1px #ccc solid;">: <?php echo $nmCntryNtnltyCntryChld['country_name']; ?></td>
				</tr>
				<?php	
				$j++;
				}
				?>
				
			</table>
		</td>
 	</tr>
 </table>  
   
  
    
</div>
<br>

