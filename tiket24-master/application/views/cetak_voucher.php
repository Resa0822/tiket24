<?php
$urlAddrss_attrctn = $this->uri->uri_to_assoc(3);
$trnsctnCode_attrctn = $urlAddrss_attrctn['tc'];
$tourPackageID_attraction = $pckgTourID;

$this->db->select('*');
$this->db->from('book_packages');
$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id','left');
$this->db->join('tours', 'tours.API_packages_id=book_packages.API_packages_id','left');
$this->db->join('tour_info', 'tour_info.tour_id=tours.tour_id','left');
$this->db->where('transaction_code', $trnsctnCode_attrctn);
$this->db->where('tours.tour_id', $tourPackageID_attraction);
$qryPckgs_attrctn = $this->db->get();
foreach($qryPckgs_attrctn->result() as $rowFld_attrctn){
	$tCode_attrctn = $rowFld_attrctn->transaction_code;
	$pckgID_attrctn = $rowFld_attrctn->API_packages_id;
	$pckgRefNo_attrctn = $rowFld_attrctn->API_packages_refno;
	$pckgName_attrctn = $rowFld_attrctn->package_name;
	$tourImportantNotes_attrctn = $rowFld_attrctn->tour_inportant_notes;
	$cancelationPlicy_attrctn = $rowFld_attrctn->cancellation_policy;
	$tourHighlights_attrctn = $rowFld_attrctn->tour_highlights;
	$adultPAX_attrctn = $rowFld_attrctn->adult;
	$childPAX_attrctn = $rowFld_attrctn->child;
	$totalPAX_attrctn = $adultPAX_attrctn + $childPAX_attrctn;
	$gmbrLogo_attrctn = $rowFld_attrctn->gambar;
	$tourDate_attrctn = $rowFld_attrctn->travel_date;
	$tour_name_attrctn = $rowFld_attrctn->tour_name;
	$bkngCnfrmtnCode = $rowFld_attrctn->api_confirmation_number;
	//$visualID = $rowFld->visualID;
	$kode = '7544975';
}
//select traveler leader info
	$this->db->select('*');
	$this->db->from('traveler_info');
	$this->db->where('transaction_code', $trnsctnCode_attrctn);
	$this->db->where('isLeader', '1');
	$qrySlctTL_attrctn = $this->db->get();
	foreach($qrySlctTL_attrctn->result() as $fldTL_attrctn ){
		$namaTL_attrctn = $fldTL_attrctn->first_name.' '.$fldTL_attrctn->last_name;
	}
?>
 <script>
$(document).ready(function(e) {
    $("#cetakVoucherAttraction").bind("click", function(event) {
    	$('#voucherAttraction').printArea();
    });
 });
 </script>
 <?php
		$this->db->select('*');
		$this->db->from('tours');
		$this->db->join('tour_type', 'tour_type.code_type=tours.tour_type', 'left');
		$this->db->where('tour_id', $tourPackageID_attraction);
		$qryTabsCntntTour_attrctn = $this->db->get();
		
		foreach($qryTabsCntntTour_attrctn->result() as $fldTour_attrctn){
			
			$tabsLabelCntnt_attrctn = $fldTour_attrctn->label;
			
		}
		echo $tourPackageID_attraction;
		?>
 <div class="container-fluid" style="background-color: #99CCFF; border-top: 2px #fff solid; padding: 3px;">
	<button type="button" class="btn btn-primary pull-right" id="cetakVoucherAttraction" title="print <?php echo $tabsLabelCntnt_attrctn; ?>">
		<span class="glyphicon glyphicon-print"></span> Print <?php echo $tabsLabelCntnt_attrctn; ?>
		</button>
</div>
<div class="container" id="voucherAttraction">
	<div class="row" style="border-bottom: 2px #000 solid; margin-bottom: 10px;" id="voucherHeader">
		<div class="col-sm-3 col-md-3 col-lg-3" id="hdrCol1"><img src="<?php echo base_url(); ?>asset/theme/Logo.png" class="img-responsive" /></div>
		<div class="col-sm-6 col-md-6 col-lg-6" id="hdrCol2">&nbsp;</div>
		<div class="col-sm-3 col-md-3 col-lg-3" id="hdrCol3"><img src="<?php echo $gmbrLogo_attrctn; ?>" class="img-responsive" /></div>
	</div>
	<div class="rounded" style="padding: 10px;">
		<div class="row" >
			<div id="r1c1" class="col-sm-9 col-md-9 col-lg-9" style="padding: 10px; vertical-align: top; font-weight: bold;"><?php echo $tour_name_attrctn; ?></div>
			<div id="r1c2" class="col-sm-3 col-md-3 col-lg-3" style="vertical-align: middle;">
				<div class="pull-right" style="vertical-align: middle; text-align: center;">
					<div style="padding: 5px 5px 5px 5px;">Date of Visit</div>
					<div style="padding: 0px 5px 5px 5px; font-size: 18px; border-top:2px #000 dashed;"><b>01 Jun 2014</b></div>
				</div>
			</div>
		</div>
		<div class="row" >
			<div id="r2c1" class="col-sm-3 col-md-3 col-lg-3" >
				<div>
					<div align="left">No. of Ticket(s)</div>
					<div id="adult" align="right" ><?php echo $adultPAX_attrctn; ?> Adult</div>
					<div id="child" align="right" ><?php echo $childPAX_attrctn; ?> Child</div>
					<div id="totPax" align="right" ><?php echo $totalPAX_attrctn; ?> PAX</div>
				</div>		
			</div>
			<div id="r2c2" class="col-sm-5 col-md-5 col-lg-5" >
				<div>
					<div>
						<div style="border-bottom:2px #000 dashed;">Purchased by</div>
						<div style="font-size: 18px; font-weight: bold;">Fulan Bin Fulan</div>
					</div>
					<div>
						<div style="border-bottom:2px #000 dashed;">Traveler Name</div>
						<div style="font-size: 18px; font-weight: bold;"><?php echo $namaTL_attrctn; ?></div>
					</div>
				</div>
			</div>
			<div id="r3c1" class="col-sm-4 col-md-4 col-lg-4" >
				<div>
					<div style="border-bottom:2px #000 dashed;">Booking Ref. No.</div>
					<div style="font-size: 24px;"><b><?php echo $bkngCnfrmtnCode; ?></b></div>
				</div>
			</div>
		</div>
	</div>
	<!-- ===================================== -->
		
	<table style="margin:5px 0px 5px 0px;">
		<tr>
			<td style="font-size: 24px; font-weight: bold; width: 530px;">REDEMPTION VOUCHER</td>
			<td>
				<?php
					//echo site_url('voucher/generateBarcode/'.$kode);
					/*echo '<img src="'.site_url('voucher/generateBarcode/'.$kode).'" height="50"  />';*/
				?>
			</td>
		</tr>
	</table>
	
	
	<table cellpadding="0" cellspacing="0" border="1" width="100%" style="font-size: 10px;"  >
		<tr>
			<td style="background-color: #000000; color: #ffffff; padding: 5px; font-size: 14px; font-weight: bold;" >Tour Highlights</td>
		</tr>
		<tr>
			<td style="padding: 5px;" ><?php $rmvdBreakTH_attrctn = str_replace("<br>"," ",$tourHighlights_attrctn);echo $rmvdBreakTH_attrctn; ?></td>
		</tr>
		<tr>
			<td style="background-color: #000000; color: #ffffff; padding: 5px; font-size: 14px; font-weight: bold;">Important Notes</td>
		</tr>
		<tr>
			<td style="padding: 5px;" ><?php $rmvdBreakTH_attrctn = str_replace("<br>"," ",$tourHighlights_attrctn);echo $rmvdBreakTH_attrctn; ?>
	     <div>
	  		<div style="text-decoration: underline;"><b>Cancelation Policy</b></div>
	  		<div> <?php echo $cancelationPlicy_attrctn; ?></div>
	  	</div></td>
		</tr>
	</table>
	
	
	
	
	
	
</div>
