<?php
$urlAddrss = $this->uri->uri_to_assoc(3);
$trnsctnCode = $urlAddrss['tc'];
$tourPackageID_nonAttraction = $pckgTourID;

$this->db->select('*');
$this->db->from('book_packages');
$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id','left');
$this->db->join('tours', 'tours.API_packages_id=book_packages.API_packages_id','left');
$this->db->join('tour_info', 'tour_info.tour_id=tours.tour_id','left');
$this->db->where('transaction_code', $trnsctnCode);
$this->db->where('tours.tour_id', $tourPackageID_nonAttraction);
$qryPckgs = $this->db->get();
foreach($qryPckgs->result() as $rowFld){
	$tCode = $rowFld->transaction_code;
	$pckgID = $rowFld->API_packages_id;
	$pckgRefNo = $rowFld->API_packages_refno;
	$pckgName = $rowFld->package_name;
	$tourImportantNotes = $rowFld->tour_inportant_notes;
	$cancelationPlicy = $rowFld->cancellation_policy;
	$tourHighlights = $rowFld->tour_highlights;
	$adultPAX = $rowFld->adult;
	$childPAX = $rowFld->child;
	$totalPAX = $adultPAX + $childPAX;
	$gmbrLogo = $rowFld->gambar;
	$pckgInclsv = $rowFld->ket;
	//$visualID = $rowFld->visualID;
	$tourDate = $rowFld->travel_date;
	$tourCategory = $rowFld->tour_category;
	$pickUpTime = $rowFld->pickup_time;
	$tourStartTime = $rowFld->tour_start_time;
	$duration = $rowFld->duration;
	$tour_name = $rowFld->tour_name;
	$cnfrmtnCode = $rowFld->api_confirmation_number;
	
}
//select traveler leader info
	$this->db->select('*');
	$this->db->from('traveler_info');
	$this->db->where('transaction_code', $trnsctnCode);
	$this->db->where('isLeader', '1');
	$qrySlctTL = $this->db->get();
	foreach($qrySlctTL->result() as $fldTL ){
		$namaTL = $fldTL->first_name.' '.$fldTL->last_name;
	}
	
	$this->db->select('*');
	$this->db->from('traveler_info');
	$this->db->where('transaction_code', $trnsctnCode);
	$this->db->where('isContact', '1');
	$qrySlctTC = $this->db->get();
	foreach($qrySlctTC->result() as $fldTC ){
		$namaTC = $fldTC->first_name.' '.$fldTC->last_name;
		$cntctMbleNmbr = $fldTC->mobile_number;
		$cntctEmail = $fldTC->email;
	}
	
?>
 <script>
$(document).ready(function(e) {
    $("#cetakVoucherNonAttraction").bind("click", function(event) {
    	$('#voucherNonAttraction').printArea();
    });
 });
 </script>
 <?php
		$qryTabsCntntTour = $this->db->select('*')
		->from('tours')
		->join('tour_type', 'tour_type.code_type=tours.tour_type', 'left')
		->where('tour_id', $tourPackageID_nonAttraction)
		->get();
		$j=0;
		foreach($qryTabsCntntTour->result() as $fldTbsCntntTour){
			if($j == 0){
				$aktifCntnt = 'class="tab-pane active"';
			}else{
				$aktifCntnt ='class="tab-pane"' ;
			}
			$tourIdCntnt = $fldTbsCntntTour->tour_id;
			$tabsLabelCntnt = $fldTbsCntntTour->label;
			$isWahana = $fldTbsCntntTour->isWahana;
			$j++;
		}
		?>
<div class="container-fluid" style="background-color: #99CCFF; border-top: 2px #fff solid; padding: 3px;">
	<button type="button" class="btn btn-primary pull-right" id="cetakVoucherNonAttraction" title="print <?php echo $tabsLabelCntnt; ?>"><span class="glyphicon glyphicon-print"></span> Print <?php echo $tabsLabelCntnt; ?></button>
</div>
<div class="container" id="voucherNonAttraction">
	<div class="row" style="margin-bottom: 10px;" id="voucherHeader">
		<div class="col-sm-9 col-md-9 col-lg-9" id="vntp_r1c1" align="center" >
			<div>TRAVEL CONFIRMATION VOUCHER</div>
			<div>MASTER BOOKING REFERENCE NUMBER : <?php echo $cnfrmtnCode; ?></div>
			<div><?php echo $tour_name; ?></div>
			<div>( <?php echo $pckgRefNo; ?> )</div>
			
		</div>
		<div class="col-sm-3 col-md-3 col-lg-3" id="vntp_r1c2" ><img src="<?php echo base_url(); ?>asset/theme/Logo.png" class="img-responsive pull-right" /></div>
	</div>
	
	<div>
		<div style="font-weight: bold;">Package Inclusive of :</div>
		<div style="font-size: 10px;"><?php $rmvdBreakPckgInclsv = str_replace("<br>"," ",$pckgInclsv);echo $rmvdBreakPckgInclsv; ?></div>
	</div>
	<div style="font-size: 10px;">
		<table>
			<tr>
				<td style="width: 150px;">Leader Travel Party </td>
				<td>: <?php echo $namaTL; ?></td>
			</tr>
			<tr>
				<td style="width: 150px;">Contact Travel Party </td>
				<td>: <?php echo $namaTC; ?></td>
			</tr>
			<tr>
				<td>Contact Number </td>
				<td> : <?php echo $cntctMbleNmbr; ?></td>
			</tr>
			<tr>
				<td>Email Address </td>
				<td> : <?php echo $cntctEmail; ?></td>
			</tr>
			<tr>
				<td>Total Number of Traveller</td>
				<td> : <?php 
				if(!empty($childPAX)){
					echo $adultPAX.' Adult(s) and '.$childPAX.' Child(s)';	
				}
				else{
					echo $adultPAX.' Adult(s)';	
				}
				 ?></td>
			</tr>
			<tr>
				<td>Pick Up / Drop Off Hotel </td>
				<td> : <?php echo $namaTC; ?></td>
			</tr>
		</table>
	</div>
	<div style="border-bottom:1px #000 solid; width: 100%;">&nbsp;</div>
	<table id="tblNonThemePark" style="font-size: 10px;">
		<tr>
			<td colspan="2" style="padding-bottom: 5px;"><u><b>IMPORTANT NOTES :</b></u></td>
		</tr>
		<tr>
			<td colspan="2"><b><u><?php echo $pckgName; ?></u></b></td>
		</tr>
		<tr>
			<td>Tour Date </td>
			<td>: <?php 
			$date = date_create($tourDate);
			$trDtReform = date_format($date, 'd M Y'); 
			echo $trDtReform; ?>
			</td>
		</tr>
		<?php 
				/* extract pickup time and tour start time */
				switch($tourCategory){
					case '1112' : $pickUpTimeNoWS = str_replace(' ', '', $pickUpTime);//clear whitespace
								  $slicePcupTme = explode("OR", $pickUpTimeNoWS);
								  $pcupTme_1 = $slicePcupTme[0];
								  $pcupTme_1_jam = substr($pcupTme_1, 0, 2);
								  $pcupTme_1_menit = substr($pcupTme_1, 2, 4); 	
								  $pcupTme_1_hrs = substr($pcupTme_1, 4, 7);
								  $pcupTme_1_reform = $pcupTme_1_jam.' : '.$pcupTme_1_menit.' '.$pcupTme_1_hrs.' (Morning)';
								  $pcupTme_2 = $slicePcupTme[1];
								  $pcupTme_2_jam = substr($pcupTme_2, 0, 2);
								  $pcupTme_2_menit = substr($pcupTme_2, 2, 4); 	
								  $pcupTme_2_hrs = substr($pcupTme_2, 4, 7);
								  $pcupTme_2_reform = $pcupTme_2_jam.' : '.$pcupTme_2_menit.' '.$pcupTme_2_hrs;
								  
								  $trStrtTimeNoWS = str_replace(' ', '', $tourStartTime);//clear whitespace
								  $sliceTrStrTme = explode("OR", $trStrtTimeNoWS);
								  $trStrtTime_1 = $sliceTrStrTme[0];
								  $trStrtTime_1_jam = substr($trStrtTime_1, 0, 2);
								  $trStrtTime_1_menit = substr($trStrtTime_1, 2, 4); 	
								  $trStrtTime_1_hrs = substr($trStrtTime_1, 4, 7);
								  $trStrtTime_1_reform = $trStrtTime_1_jam.' : '.$trStrtTime_1_menit.' '.$trStrtTime_1_hrs.' (Morning)';
								  $trStrtTime_2 = $sliceTrStrTme[1];
								  $trStrtTime_2_jam = substr($trStrtTime_2, 0, 2);
								  $trStrtTime_2_menit = substr($trStrtTime_2, 2, 4); 	
								  $trStrtTime_2_hrs = substr($trStrtTime_2, 4, 7);
								  $trStrtTime_2_reform = $trStrtTime_2_jam.' : '.$trStrtTime_2_menit.' '.$trStrtTime_2_hrs;
								  $html = '<tr>
												<td>Pick Up Time </td>
												<td>: '.$pcupTme_1_reform.' or '.$pcupTme_2_reform.'</td>
											</tr>
											<tr>
												<td>Tour Start Time </td>
												<td>: '.$trStrtTime_1_reform.' or '.$trStrtTime_2_reform.'</td>
											</tr>
											<tr>
												<td>Duration </td>
												<td>: '.$duration.'</td>
											</tr>';
								  break;
					case '11' : ;break;
					case '12' : ;break;
					case '13' : ;break;
					case '14' : ;break;
					case '15' : ;break;	
				}
				
			 ?>
		<!-- ========= -->
		<tr>
			<td>Pick Up Time </td>
			<td>: <?php echo $pickUpTime; ?></td>
		</tr>
		<tr>
			<td>Tour Start Time </td>
			<td>: <?php echo $tourStartTime; ?></td>
		</tr>
		<tr>
			<td>Duration </td>
			<td>: <?php echo $duration; ?></td>
		</tr>
		<!-- ========== -->
		<tr>
			<td colspan="2"><b><u>Important Notes : </u></b></td>
		</tr>
		<tr>
			<td colspan="2" style="font-size: 10px; border-bottom: 1px #000 solid;"><?php $rmvdBreakTIN = str_replace("<br>"," ",$tourImportantNotes);echo $rmvdBreakTIN; ?></td>
		</tr>
		<tr>
			<td colspan="2">Cancelation Policy : </td>
		</tr>
		<tr>
			<td colspan="2"><?php echo $cancelationPlicy; ?></td>
		</tr>
	</table>
</div>