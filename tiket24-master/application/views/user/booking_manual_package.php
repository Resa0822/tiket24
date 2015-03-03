<?php 
//$this->session->unset_userdata('bookingUSID');
//$bkngPckgID = $pckgId;
$currentYear = date("Y");
$pssprtExpryYear = $currentYear + 6;
$idTblPckg = $this->uri->segment(3);

if($this->tank_auth->is_logged_in()){
	$userRoleID = $this->tank_auth->get_user_role_id();
	$userID = $this->tank_auth->get_user_id();
	$qryUsrMrgnPrc = $this->db->get_where('margin', array('role_id'=>$userRoleID));
	foreach($qryUsrMrgnPrc->result() as $rowUsrMrgn){
		$usrMrgnPrc_Prcnt = $rowUsrMrgn->margin_pr;
		$usrMrgnPrc_Nmnl = $rowUsrMrgn->margin_rp;
	}
}
else{
	$qryUsrMrgnPrc = $this->db->get_where('margin', array('role_id'=>'4'));
	foreach($qryUsrMrgnPrc->result() as $rowUsrMrgn){
		$usrMrgnPrc_Prcnt = $rowUsrMrgn->margin_pr;
		$usrMrgnPrc_Nmnl = $rowUsrMrgn->margin_rp;
	}
}

/*
$qryGetPckg = mysql_query("SELECT * FROM packages WHERE packages_id='$idTblPckg' AND isFromAPI='0' ");
$fldPckg = mysql_fetch_array($qryGetPckg);
$PriceAdult = $fldPckg['price_adult']; 
$PriceChild = $fldPckg['price_child'];
$currency = $fldPckg['currency'];
$pckgID = $fldPckg['API_packages_id'];
 * */

$qry = $this->db->get_where('packages', array('packages_id'=>"$idTblPckg", 'isFromAPI'=>'0'));
foreach($qry->result() as $rows){
	$PriceAdult = $rows->price_adult; 
	$PriceChild = $rows->price_child;
	$currency = $rows->currency;
	$pckgID = $rows->API_packages_id;
	$gambar = $rows->gambar;
	$pckgNme = $rows->nama;
	$booking_begin = $rows->booking_begin;  
	$booking_end = $rows->booking_end;  
	$periode_begin = $rows->periode_begin; 
	$periode_end = $rows->periode_end; 
	$pckgInclsv = $rows->ket;
	$pckgsCode = $rows->kode;
	$mrgnPrc_prcnt = $rows->margin_pr;
	$mrgnPrc_nmnl = $rows->margin_rp;
	$discount = $rows->discount;
	$pckgDscrptn = $rows->desc;
}

$qryCrrncyRte = $this->db->get_where('currencies', array('currency_from'=>'SGD', 'currency_to'=>'IDR'));
foreach($qryCrrncyRte->result() as $rowCrrncyRte){
	$crrncRte_SGDtoIDR = $rowCrrncyRte->konversi;
}

$discPrcnt = $discount / 100;

if(!empty($usrMrgnPrc_Nmnl)){
	$totMrgn_nmnl_inIDR = $mrgnPrc_nmnl + $usrMrgnPrc_Nmnl;
	$totMrgn_nmnl_inSGD = $totMrgn_nmnl_inIDR / $crrncRte_SGDtoIDR;
	switch($currency){
		case 'IDR' : $priceMargin = $totMrgn_nmnl_inIDR;break;
		case 'SGD' : $priceMargin = $totMrgn_nmnl_inSGD;break;
	}
	
	$adultPrice_withMargin = $PriceAdult + $priceMargin;
	$childPrice_withMargin = $PriceChild + $priceMargin;
	
	if(!empty($discount)){

		$adultPriceDiscMargin = $adultPrice_withMargin * $discPrcnt;
		$childPriceDiscMargin = $childPrice_withMargin * $discPrcnt;
		
		$adultPrice_DiscPrice = $adultPrice_withMargin + $adultPriceDiscMargin;
		$childPrice_DiscPrice = $childPrice_withMargin + $childPriceDiscMargin;
	}
	
	
	
}
else{
	$totMrgn_prcnt = ($usrMrgnPrc_Prcnt + $mrgnPrc_prcnt) / 100;
	$priceMargin = $totMrgn_prcnt*$PriceAdult;
	$adultPrice_withMargin = $PriceAdult + $priceMargin;
	$childPrice_withMargin = $PriceChild + $priceMargin;
	
	if(!empty($discount)){

		$adultPriceDiscMargin = $adultPrice_withMargin * $discPrcnt;
		$childPriceDiscMargin = $childPrice_withMargin * $discPrcnt;
		
		$adultPrice_DiscPrice = $adultPrice_withMargin + $adultPriceDiscMargin;
		$childPrice_DiscPrice = $childPrice_withMargin + $childPriceDiscMargin;
	}
	
}


//echo '<div style="clear:both;"></div>';
//echo $totMrgn_nmnl_inIDR.'<br />'.'Tot. in SGD : '.$totMrgn_nmnl_inSGD;
//echo '<br /> Adult margin price'.$currency.' '.$priceMargin;
//echo '<br /> Adult price'.$currency.' '.$PriceAdult;
//echo '<br /> Adult price with margin'.$currency.' '.$adultPrice_withMargin;
//echo '<br /> Child price with margin'.$currency.' '.$childPrice_withMargin;
/* price with profit */
		 
      			/* margin and package profit price */
                if ($this->tank_auth->is_logged_in()) {	
					switch($this->tank_auth->get_user_role_id()) {
						case 1 : $userRoleID = '1'; break;
						case 2 : $userRoleID = '2'; break;
						case 3 : $userRoleID = '3'; break;
					}
					
				} 
				else{
					$userRoleID = '4';
				}
				
                
                $qrySlctMrgn = mysql_query("SELECT * FROM margin WHERE role_id='$userRoleID' ");
                $mrgnFld = mysql_fetch_array($qrySlctMrgn);
				$crrncy = $mrgnFld['currency'];
                $prcntMrgn = $mrgnFld['margin_pr'] / 100;/* hitung persentase margin profit */
				$profitAdultPrice = $PriceAdult * $prcntMrgn; 
				$profitChildPrice = $PriceChild * $prcntMrgn; 
				
				$salePriceAdult = round($PriceAdult + $profitAdultPrice, 2);
				$salePriceChild = round($PriceChild + $profitChildPrice, 2);

	        //$totalAdultSalePrice = round($Adult * $salePriceAdult, 2);
	        //$totalChildSalePrice = round($Child * $salePriceChild, 2);
			//$totalPackageSalePrice = round($totalAdultSalePrice + $totalChildSalePrice, 2);
?>
<!--<script src="<?php echo base_url(); ?>asset/js/jquery-1.10.2.js"></script>-->
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#tourDate').datepicker({ dateFormat: 'yy-mm-dd' });
	$('#creditCard').click(function(){
		$('#cardInfo').show("fold", 1000);
		$('#bcaAccInfo').hide("fold", 1000);
		$('#bniAccInfo').hide("fold", 1000);
	});
	$('#transferBCA').click(function(){
		$('#cardInfo').hide("fold", 1000);
		$('#bcaAccInfo').show("fold", 1000);
		$('#bniAccInfo').hide("fold", 1000);
	});
	$('#transferBNI').click(function(){
		$('#cardInfo').hide("fold", 1000);
		$('#bcaAccInfo').hide("fold", 1000);
		$('#bniAccInfo').show("fold", 1000);
	});
	
	$('#totAmount').html("Total Amount : <b><?php echo $currency; ?></b> 0");
	$('#adultPax').change(function() {
		//parseInt(num, 10)
		var totAdult = $("#adultPax").find(":selected").val();	
		var adultPrice = <?php echo $adultPrice_withMargin; ?>;
		var totAdultPrice = totAdult * adultPrice;
		var totalAdultPrice = $("#adltTotPrc").val(totAdultPrice.toFixed(2));
		var totChildPrice = Math.floor($("#chldTotPrc").val());
		var totAmount = totAdultPrice + totChildPrice;
		//$('.totAmnt').number(); 
		$('#totAmount').html("Total Amount : <b><?php echo $currency; ?></b> " + totAmount.toFixed(2) );
	});
	$('#childPax').change(function() {
		var totChild = $("#childPax").find(":selected").val();	
		var childPrice = <?php echo $childPrice_withMargin; ?>;
		var totChildPrice = totChild * childPrice;
		var totalChildPrice = $("#chldTotPrc").val(totChildPrice.toFixed(2));
		var totAdultPrice = Math.floor($("#adltTotPrc").val());
		var totAmount = totAdultPrice + totChildPrice;
		
		//$('.totAmnt').number(); 
		//$('.totAmnt').number( totAmount, 2 )
		$('#totAmount').html("Total Amount : <b><?php echo $currency; ?></b> " + totAmount.toFixed(2) );
	});
	
	/* ajax country city start */
	
	
	
});
</script>
<style>
.roundedBox{-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;}
</style>
<div class="search_package">
<h2 style="padding-left: 10px;">Booking Package</h2>
	<div id="hotel-content-description"  style="text-align:center;border:10px solid #25497d; margin:auto; padding:35px 35px 35px 35px; border-radius:15px 15px 15px 15px; margin-top: 10px;;">
<!-- ======================================================== -->


<?php if($this->session->flashdata('flashMsge_warning')){ ?>
<div class="alert alert-warning fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert">
    	<span aria-hidden="true">&times;</span>
    </button>
	<?php echo $this->session->flashdata('flashMsge_warning'); ?>
</div>
<?php } ?>
<form action="<?php echo base_url();?>index.php/ajaxHandler/bookingPackageManual" method="post" />
<input type="hidden" name="id" value="<?php echo $idTblPckg; ?>"  >
<!-- =============traveler leader start==================== -->
<table width="100%;" style="border: 2px #6e91ac solid;">
	<tr>
		<td colspan="2" style="background: #6e91ac;padding-left:10px;color:#ffffff"><h5><?php echo $pckgNme; ?></h5></td>
	</tr>
	<tr>
		<td style="vertical-align: top; width: 280px; color:#688194">
			<div class="roundedBox" style="margin: 10px 0px 0px 10px;border:2px solid #7abcef;background-color:#b2dbfb;">
				<div style="padding: 5px;position: relative; top: 0;left: 0;">
				<?php
				$qry = $this->db->get_where('packages',array('packages_id'=>"$idTblPckg"));
				foreach($qry->result() as $row){
					$isDiscnt = $row->discount;  
				}
            	if(!empty($isDiscnt)){
            	?>
				<!-- START RIBBON -->
				<div class="ribbon ribbon-large ribbon-red" style="z-index: 5000; right:3px;" >
				<div class="banner">
				<div class="text">discount <strong style="font-size:34px;"><?php echo $row->discount.' %'; ?></strong></div>
				</div>
				</div>
				<!-- END RIBBON -->
				<?php } ?>
					<img src="<?php echo $gambar; ?>" />	
				</div>
				<div style="padding: 5px; text-align: right; font-weight: bold;">
					<span>Adult @ </span><?php echo $currency.' '.number_format($adultPrice_withMargin).',-'; ?>
				</div>
				<div style="padding: 5px; text-align: right; font-weight: bold;">
					<span>Child @ </span><?php echo $currency.' '.number_format($childPrice_withMargin).',-'; ?>
				</div>
			</div>
		</td>
		<td style="padding: 10px;">
			<!--<form> -->
				
			<div class="roundedBox" style=";border:1px #6e91ac solid; background: #b2dbfb; padding: 5px;">	
			<table width="100%" >
				<tr>
					<td style="text-align: right;padding: 5px;">Adult PAX 
						<?php echo form_error('adultPax', '<div style="color:red">', '</div>'); ?>
						<select name="adultPax" id="adultPax" style="width:50px;" >
						<?php
						for($i=0;$i<=10;$i++){
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>			
					</select> 
					<!--<span> @ <b>SGD</b> <?php echo $salePriceAdult; ?></span>-->
					<input type="hidden" id="adltTotPrc" value=""  >
					</td>
					<td style="text-align: right;padding: 5px;">Child PAX 
						<?php echo form_error('childPax', '<div style="color:red">', '</div>'); ?>
							<select name="childPax" id="childPax" style="width:50px;" >
							<?php
							for($i=0;$i<=10;$i++){
									echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>			
						</select> 
						<!--<span> @ <b>SGD</b> <?php echo $salePriceChild; ?></span>-->
						<input type="hidden" id="chldTotPrc" value="" >
					</td>
					<td style="text-align: right;padding: 5px;">
						Travel Date 
						<?php echo form_error('tourDate', '<div style="color:red">', '</div>'); ?>
						<input type="text" id="tourDate" name="tourDate" value="" placeholder="Tour Date" style="width:100px;"  />
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: right;padding: 5px; text-decoration: underline;">
						<span id="totAmount" style="padding-left: 3px;">&nbsp;</span>
					</td>
				</tr>
				<tr>
					<td colspan="3">
					<?php
					$bookingStart = substr($booking_begin, 0, 10);  
					$bookingEnd = substr($booking_end, 0, 10);  
					$periodStart = substr($periode_begin, 0, 10); 
					$periodEnd = substr($periode_end, 0, 10); 
					?>
					<div><b>Booking Periode</b></div>
					<div><?php echo $bookingStart.' - '.$bookingEnd; ?></div>
					<div><b>Travel Periode</b></div>
					<div><?php echo $periodStart.' - '.$periodEnd; ?></div>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<div><b>Package Inclusive</b></div>
						<div><?php echo $pckgInclsv; ?></div>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: right;padding: 5px;">
						<input type="submit" name="cnfrmBkng" id="cnfrmBkng" style="padding: 5px;" value="Booking" >
						<span id="bkngLdr" style="position: relative; float: left;"></span>
					</td>
				</tr>
			</table>
			</div>
		 
		  
 		</td>
	</tr>
	<tr>
		<td colspan="2">
			<!--<h3>Tour Highlights</h3>-->
		<?php
	//$apiPackagesId = $fldPckg['API_packages_id'];
	//$qryHighlight = $this->db->query("SELECT * FROM tours WHERE API_packages_id='$apiPackagesId' ");
	//$qryTours = $this->db->get_where('tour_info',array('mnl_package_code'=>$pckgsCode));
	//foreach ($qryTours->result() as $rowFld)
	//{
		//$tourID = $row->tour_id;
		//$qryHL= mysql_query("SELECT * FROM tour_info WHERE tour_id='$tourID' ");
		//$pckgHL = mysql_fetch_array($qryHL);
		//$tourHL = $rowFld->tour_highlights;
		//$tourIN = $rowFld->tour_inportant_notes;
		     
	?>
	
			<table cellpadding="0" cellspacing="0" border="0" width="100%" >
				<tr>
					<td colspan="2" style="background: #588ab0;padding-left:10px;color:#fff;"><h4>Tour Highlights</h4><!--<h5><?php echo $row->tour_name; ?></h5>--></td>
				</tr>
				<tr>
					<td style="vertical-align: top;background: #b8ddf9"><!--<img src="<?php echo $row->image_path; ?>" style="width: 100px;" />--></td>
					<td style="background: #b8ddf9">
						<div id="tourHl" style="padding: 5px;"><?php echo $pckgDscrptn; ?></div>
					</td>
				</tr>
			</table>
			
			<?php
			/*if($row->pickup_time !== NULL AND $row->tour_start_time !== NULL AND $row->duration){
			$pickUpTime = explode('/',$row->pickup_time);
			$startTime = explode('/',$row->tour_start_time);	
			*/
			?>
			<!--
		    <table cellpadding="0" cellspacing="0" border="0" width="100%" >
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td style="vertical-align: top;background: #7FFFD4;width: 120px;">&nbsp;</td>
					<td style="background: #7FFFD4">
						<div>Pickup Time : <?php echo $pickUpTime[0]; ?></div>
						<div>Tour Start Time : <?php echo $startTime[0]; ?></div>
						<div>Duration : <?php echo $row->duration; ?></div>
					</td>
				</tr>
				
			</table>-->
	       
	<?php
	/*
			}
		
	}
	*/
	?>
		</td>
	</tr>
</table>



 </form>
</div>
</div>

<br /><br />