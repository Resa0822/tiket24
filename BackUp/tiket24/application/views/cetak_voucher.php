<?php
$urlAddrss_voucher = $this->uri->uri_to_assoc(3);
$trnsctnCode_voucher = $urlAddrss_voucher['tc'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
<style>
body{ 
		font-family: Arial, Helvetica, sans-serif; font-size:12px;
	
}
#hdrTitle{width: 100%; background-color: #3366CC; padding:10px 10px 10px 5px; color: #fff; font-weight: bold;}
.rounded{
-webkit-border-radius: 20px;
-moz-border-radius: 20px;
border-radius: 20px;
border:1px #000 solid;
}
#printBar {
-webkit-box-shadow: 0px 5px 10px 0px rgba(50, 50, 50, 0.75);
-moz-box-shadow:    0px 5px 10px 0px rgba(50, 50, 50, 0.75);
box-shadow:         0px 5px 10px 0px rgba(50, 50, 50, 0.75);
background-color: #000; padding: 5px; position:relative; width: 100%; top: 0px; z-index:500	
}
#r1c1{font-size: 26px}
#pnlHdrTrHghLght{background: #000;color:#fff; font-size: 18px; font-weight:bold;}
#pnlBdyTrHghLght{font-size:12px;}
#pnlHdrImprtntNts{background: #000;color:#fff; font-size: 18px;font-weight:bold;}
#pnlBdyImprtntNts{font-size:12px;}

#adult{font-size:24px; font-weight: bold; padding-right: 10px;}
#child{font-size:24px; font-weight: bold; padding-right: 10px;}
#totPax{font-size:24px; font-weight: bold; padding-right: 10px; border-top: 2px #000 dashed}


</style>
    <title>Voucher</title>
<script src="<?php echo base_url(); ?>asset/js/jquery-1.10.2.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" media="all">
<!-- Optional theme -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/printarea.css" media="print">
<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/jquery.PrintArea.js"></script>

</head>
  </head>

<body>
<?php
$trnsctnCode_voucher = $trnsctnCode_voucher;
$this->db->select('*');
$this->db->from('book_packages');
$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id','left');
$this->db->join('tours', 'tours.API_packages_id=book_packages.API_packages_id','left');
$this->db->join('tour_info', 'tour_info.tour_id=tours.tour_id','left');
$this->db->where('transaction_code', $trnsctnCode_voucher);
$qryPckgs_voucher = $this->db->get();
foreach($qryPckgs_voucher->result() as $rowFld_voucher){
	$tCode_voucher = $rowFld_voucher->transaction_code;
	$pckgID_voucher = $rowFld_voucher->API_packages_id;
	$pckgRefNo_voucher = $rowFld_voucher->API_packages_refno;
	$pckgName_voucher = $rowFld_voucher->package_name;
	$tourImportantNotes_voucher = $rowFld_voucher->tour_inportant_notes;
	$cancelationPlicy_voucher = $rowFld_voucher->cancellation_policy;
	$tourHighlights_voucher = $rowFld_voucher->tour_highlights;
	$adultPAX_voucher = $rowFld_voucher->adult;
	$childPAX_voucher = $rowFld_voucher->child;
	$totalPAX_voucher = $adultPAX_voucher + $childPAX_voucher;
	$gmbrLogo_voucher = $rowFld_voucher->gambar;
	$tourDate_voucher = $rowFld_voucher->travel_date;
	//$visualID = $rowFld->visualID;
	$kode = '7544975';
}

?>
<!--
<div class="container-fluid" id="printBar">
	<button type="button" onclick="javascript:window.open('','_self').close();" class="btn btn-primary pull-left" id="closeCetakVoucher" title="close"><span class="glyphicon glyphicon-remove-circle"></span> Close</button>
	<button type="button" class="btn btn-primary pull-right" id="cetakVoucher" title="print voucher"><span class="glyphicon glyphicon-print"></span> Print Voucher</button>
</div>
<br /><br />
-->
<br />
<div id="content">
	<ul class="nav nav-tabs">
		<?php
		$qryTabsTour_voucher = $this->db->select('*')
		->from('tours')
		->join('tour_type', 'tour_type.code_type=tours.tour_type', 'left')
		->where('API_packages_id', $pckgID_voucher)
		->get();
		$i_voucher=0;
		foreach($qryTabsTour_voucher->result() as $fldTbsTour_voucher){
		if($i_voucher == 0){
			$aktif_voucher = 'class="active"';
		}else{
			$aktif_voucher ='' ;
		} 
		$tourId_voucher = $fldTbsTour_voucher->tour_id;
		$tabsLabel_voucher = $fldTbsTour_voucher->label;
		$i_voucher++;
		?>
		 <li <?php echo $aktif_voucher; ?>><a href="#tab_<?php echo $tourId_voucher; ?>" data-toggle="tab"><b><?php echo $tabsLabel_voucher; ?></b></a></li>
		<?php	
		} 
		?>
	</ul>
	<div class="tab-content">
		<?php
		$qryTabsCntntTour_voucher = $this->db->select('*')
		->from('tours')
		->join('tour_type', 'tour_type.code_type=tours.tour_type', 'left')
		->where('API_packages_id', $pckgID_voucher)
		->get();
		$j_voucher=0;
		foreach($qryTabsCntntTour_voucher->result() as $fldTbsCntntTour_voucher){
			if($j_voucher == 0){
				$aktifCntnt_voucher = 'class="tab-pane active"';
			}else{
				$aktifCntnt_voucher ='class="tab-pane"' ;
			}
			$tourIdCntnt_voucher = $fldTbsCntntTour_voucher->tour_id;
			$tabsLabelCntnt_voucher = $fldTbsCntntTour_voucher->label;
			$isWahana_voucher = $fldTbsCntntTour_voucher->isWahana;
			$j_voucher++;
		?>
			<div <?php echo $aktifCntnt_voucher; ?> id="tab_<?php echo $tourIdCntnt_voucher; ?>">
				
				<?php
				if ($isWahana_voucher == 1) {
					//echo 'wahana';
					$data['pckgTourID'] = $tourIdCntnt_voucher;
					$this->load->view('voucher_attraction', $data);	
				}
				else{
					//echo 'non wahana';
					$data['pckgTourID'] = $tourIdCntnt_voucher;
					$this->load->view('voucher_non_attraction', $data);	
				}
				?>
		        
		           
		    </div>
	    <?php	
		} 
		?>
	        
	       
	</div>
</div>



  </body>
</html>
