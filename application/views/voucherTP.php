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
 <script>
$(document).ready(function(e) {
    $("#cetakVoucher").bind("click", function(event) {
    	$('#voucher').printArea();
    });
 });
 </script>
</head>
  </head>

<body>
<?php
$trnsctnCode = $trnsctnCode;
$this->db->select('*');
$this->db->from('book_packages');
$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id','left');
$this->db->join('tours', 'tours.API_packages_id=book_packages.API_packages_id','left');
$this->db->join('tour_info', 'tour_info.tour_id=tours.tour_id','left');
$this->db->where('transaction_code', $trnsctnCode);
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
	$tourDate = $rowFld->travel_date;
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
		$qryTabsTour = $this->db->select('*')
		->from('tours')
		->join('tour_type', 'tour_type.code_type=tours.tour_type', 'left')
		->where('API_packages_id', $pckgID)
		->get();
		$i=0;
		foreach($qryTabsTour->result() as $fldTbsTour){
		if($i == 0){
			$aktif = 'class="active"';
		}else{
			$aktif ='' ;
		} 
		$tourId = $fldTbsTour->tour_id;
		$tabsLabel = $fldTbsTour->label;
		$i++;
		?>
		 <li <?php echo $aktif; ?>><a href="#tab_<?php echo $tourId; ?>" data-toggle="tab"><?php echo $tabsLabel; ?></a></li>
		<?php	
		} 
		?>
	</ul>
	<div class="tab-content">
		<?php
		$qryTabsCntntTour = $this->db->select('*')
		->from('tours')
		->join('tour_type', 'tour_type.code_type=tours.tour_type', 'left')
		->where('API_packages_id', $pckgID)
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
			$j++;
		?>
			<div <?php echo $aktifCntnt; ?> id="tab_<?php echo $tourIdCntnt; ?>">
				<div class="container-fluid" style="background-color: #99CCFF; border-top: 2px #fff solid; padding: 3px;">
					<button type="button" class="btn btn-primary pull-right" id="cetakVoucher" title="print <?php echo $tabsLabelCntnt; ?>"><span class="glyphicon glyphicon-print"></span> Print <?php echo $tabsLabelCntnt; ?></button>
				</div>
		           <?php echo $voucherTemplate; ?>
		           
		    </div>
	    <?php	
		} 
		?>
	        
	       
	</div>
</div>

<div class="container" id="voucher">
	<div class="row" style="border-bottom: 2px #000 solid; margin-bottom: 10px;" id="voucherHeader">
		<div class="col-sm-3 col-md-3 col-lg-3" id="hdrCol1"><img src="<?php echo base_url(); ?>asset/theme/Logo.png" class="img-responsive" /></div>
		<div class="col-sm-6 col-md-6 col-lg-6" id="hdrCol2">&nbsp;</div>
		<div class="col-sm-3 col-md-3 col-lg-3" id="hdrCol3"><img src="<?php echo $gmbrLogo; ?>" class="img-responsive" /></div>
	</div>
	<div class="rounded" style="padding: 10px;">
		<div class="row" >
			<div id="r1c1" class="col-sm-9 col-md-9 col-lg-9" style="padding: 10px; vertical-align: top; font-weight: bold;"><?php echo $pckgName; ?></div>
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
					<div id="adult" align="right" ><?php echo $adultPAX; ?> Adult</div>
					<div id="child" align="right" ><?php echo $childPAX; ?> Child</div>
					<div id="totPax" align="right" ><?php echo $totalPAX; ?> PAX</div>
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
						<div style="font-size: 18px; font-weight: bold;">Fulan Bin Fulan</div>
					</div>
				</div>
			</div>
			<div id="r3c1" class="col-sm-4 col-md-4 col-lg-4" >
				<div>
					<div style="border-bottom:2px #000 dashed;">Booking Ref. No.</div>
					<div style="font-size: 24px;"><b>ashdjkhasdkhask</b></div>
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
			<td style="padding: 5px;" ><?php $rmvdBreakTH = str_replace("<br>"," ",$tourHighlights);echo $rmvdBreakTH; ?></td>
		</tr>
		<tr>
			<td style="background-color: #000000; color: #ffffff; padding: 5px; font-size: 14px; font-weight: bold;">Important Notes</td>
		</tr>
		<tr>
			<td style="padding: 5px;" ><?php $rmvdBreakTH = str_replace("<br>"," ",$tourHighlights);echo $rmvdBreakTH; ?>
	     <div>
	  		<div style="text-decoration: underline;"><b>Cancelation Policy</b></div>
	  		<div> <?php echo $cancelationPlicy; ?></div>
	  	</div></td>
		</tr>
	</table>
	
	
	
	
	
	
</div>


  </body>
</html>
