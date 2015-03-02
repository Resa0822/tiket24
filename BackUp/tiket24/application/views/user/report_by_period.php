 <script>
  $(function() {
    $( ".datepicker" ).datepicker({
      numberOfMonths: 2,
      showButtonPanel: true,
       dateFormat: 'yy-mm-dd'
    });
  });
  </script>
<?php //if($this->session->userdata('role_id','1')){ //if session is created then login to members page ?>
<div id="hotel-content-info" class="stylebox">
<div style="clear:both;"></div>
	
	 <br />
	  <form action="<?php echo base_url().'index.php/transaction/report_by_period'; ?>" enctype="multipart/form-data" method="post">
	 Viewed by period : From <input type="text" id="firstPeriod" name="firstPeriod" class="datepicker"  /> to 
	 <input type="text" id="lastPeriod" name="lastPeriod" class="datepicker"  /> 
	 <button id="viewReportByPeriod" name="viewReportByPeriod" > view </button>
	 </form>
<div id="grid" class="k-grid k-widget k-secondary k-reorderable" data-role="grid" style="">
    <div class="k-grouping-header" data-role="droptarget"> &nbsp; Booking History Period <?php echo $periode; ?>
		<span class="k-pager-info k-label">
			<a href="<?php echo base_url()?>index.php/transaction/booking_history_by_period/prd/<?php echo $rprtPrd; ?>" target="_blank"><img style="width:60px;height:30px;"src="<?php echo base_url()?>asset/images/icon/pdf-download.png"/></a>
		</span>
	</div>
    
    <table role="grid" style="height: auto;">
 <!--       <colgroup>
            <col style="width:30px"></col>
            <col style="width:400px"></col>
            <col style="width:50px"></col>           
            <col></col>
			<col style="width:30px"></col>
            <col style="width:150px"></col>
            <col style="width:150px"></col>
        </colgroup> -->
        <thead class="k-grid-header">
            <tr>
                <th class="k-header k-with-icon" data-title="packages Name" data-field="packagess_name" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Transaction No</a>
                </th>
                <th class="k-header k-with-icon" data-title="packages Name" data-field="packagess_name" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Packages Name</a>
                </th>
                <th class="k-header k-with-icon" data-title="Thumb" data-field="packagess_image" role="columnheader" data-role="droptarget">
                    <a class="k-header-column-menu" href="#" tabindex="-1" style="display: none;">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>Thumb
                </th>
                <th class="k-header k-with-icon" data-title="Date" data-field="packagess_date" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Booking Date</a>
                </th>
                <th class="k-header k-with-icon" data-title="Date" data-field="packagess_date" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Total Price</a>
                </th>
                <th class="k-header k-with-icon" data-title="Date" data-field="packagess_date" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Payment Method</a>
                </th>
                <th class="k-header k-with-icon" data-title="Date" data-field="packagess_date" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Voucher</a>
                </th>
         <!--       <th class="k-header k-with-icon" data-title="Action" data-field="common_action" role="columnheader" data-role="droptarget">
                    <a class="k-header-column-menu" href="#" tabindex="-1" style="display: none;">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a> Action
                </th> -->
            </tr>
        </thead>
        <tbody>
		<?php 
		if(!empty($text)) {
		foreach($text as $row)
		{
			$totAmountInIDR = round($row->amount_total_sale_price_inIDR);
			$pymntMthdID = $row->payment_method;
			$pckgID = $row->API_packages_id; 
			$trnstnCode = $row->transaction_code;
			$this->db->select('*');
			$this->db->from('packages');
			$this->db->where('API_packages_id', $pckgID);
			$qryPckgs = $this->db->get();
			foreach($qryPckgs->result() as $fldPckgs){
				$pckgNme = $fldPckgs->nama;
				$pckgImgThmb =  $fldPckgs->gambar;
			} 
			
			$this->db->select('nama_metode');
			$this->db->from('metode_pembayaran');
			$this->db->where('kode', $pymntMthdID);
			$qryPymntMthd = $this->db->get();
			foreach($qryPymntMthd->result() as $fldMthd){
				$nmMthd = $fldMthd->nama_metode;
			}
			
		?>

			<tr class="k-alt" role="row" style="text-align: center;" >

				<td class="highlighted" role="gridcell" ><?php echo $row->transaction_code; ?></td>
				<td class="" role="gridcell" title="<strong><?php echo $pckgNme; ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo $pckgNme; ?></td>
				<td class="highlighted" role="gridcell" style="overflow: visible; text-align:center">
					<!-- <div class="thumb" style="position: relative; z-index: 1;"> -->
						<img alt="Click to zoom" onclick="resizeImg(this)" width="60" height="40" src="<?php echo $pckgImgThmb; ?>" id="image" ></img>
					<!-- </div> -->
				</td>
				<td class="" role="gridcell" title="<strong><?php echo $row->booking_date; ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo $row->booking_date; ?></td>
				<td class="" role="gridcell" title="<strong>IDR <?php echo number_format($totAmountInIDR); ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good">IDR <?php echo number_format($totAmountInIDR); ?></td>
				<td class="" role="gridcell" title="<strong><?php echo $nmMthd; ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo $nmMthd; ?></td>
				<td class="" role="gridcell" title="<strong>cetak voucher</strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good">
				
					<a href="<?php echo base_url().'index.php/voucher/cetak/tc/'.$trnstnCode; ?>" target="_blank">Cetak</a>
					
				</td>
		<!--		<td class="highlighted" align="center" role="gridcell">
					<a href="<?php echo base_url() ?>index.php/packages_country/go/<?php echo $row->idx ; ?>">
						<img border="0" alt="Edit" title="Edit" src="<?php echo $this->config->base_url(); ?>asset/images/icon/edit.png"></img>
					</a>
					<a href="<?php echo base_url() ?>index.php/packages_country/delete/<?php echo $row->idx ; ?>">
						<img border="0" alt="Delete" title="Delete" src="<?php echo $this->config->base_url(); ?>asset/images/icon/delete.png"></img>
					</a>
				</td> -->
			</tr>
		<?php } 
		}else{ 
		?>
			<tr class="k-alt" role="row" style="text-align: center;" >
				<td colspan=10><?php echo "<br/><center><h1>Empty Data !</h1></center><br/>"; }?></td>
			</tr>
		</tbody>
    </table>
    <div class="k-pager-wrap k-grid-pager k-widget" style="list-style: none;" data-role="pager">
	<?php if(!empty($text)) { ?>
		<?php  echo $this->pagination->create_links(); ?>
		<a class="k-pager-refresh k-link" title="Refresh" href="#">
            <span class="k-icon k-i-refresh">Refresh</span>
        </a>
        <span class="k-pager-info k-label">1 - <?php echo $total_rows;?> of <?php echo $total_rows;?> items</span>
	<?php }?>
    </div>
</div>
<br>
<?php /* 
} else {
			echo "<META http-equiv='refresh' content='3;URL=".base_url()."'>";
			echo "<fieldset><br /><center><h1>404 Page Not Found</h1><br/><br/><h2>The page you requested is not found</h2></center><br/></<fieldset>>";
			//redirect('starholiday/home');
		} */	?>