 <script>
  $(function() {
    $( ".datepicker" ).datepicker({
      numberOfMonths: 1,
      showButtonPanel: false,
       dateFormat: 'yy-mm-dd'
    });
  });
  </script>

<?php //if($this->session->userdata('role_id','1')){ //if session is created then login to members page ?>

<div id="hotel-content-info" class="stylebox">
<div style="clear:both;"></div>
	 <?php if ($message) : ?>
     <div class="valid_box">
        <?php echo $message; ?>
     </div>
	 <?php endif; ?>  
	 <br />
	 
	  <form action="<?php echo base_url().'index.php/transaction/all_report_by_period'; ?>" enctype="multipart/form-data" method="post">
	 Viewed by period : From <input type="text" id="firstPeriod" name="firstPeriod" class="datepicker"  /> to 
	 <input type="text" id="lastPeriod" name="lastPeriod" class="datepicker"  /> 
	 <button id="viewReportByPeriod" name="viewReportByPeriod" > view </button>
	 </form>
	 
<div id="grid" class="k-grid k-widget k-secondary k-reorderable" data-role="grid" style="">
    <div class="k-grouping-header" data-role="droptarget"> &nbsp; Booking History 
		<span class="k-pager-info k-label">
			<a href="<?php echo base_url()?>index.php/transaction/all_booking_history/" target="_blank"><img style="width:60px;height:30px;"src="<?php echo base_url()?>asset/images/icon/pdf-download.png"/></a>
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
                    <a class="k-link" href="#">Booking</a>
                </th>
                <th class="k-header k-with-icon" data-title="Date" data-field="packagess_date" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Travel</a>
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
                    <a class="k-link" href="#">User</a>
                </th>
                <th class="k-header k-with-icon" data-title="Date" data-field="packagess_date" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">&nbsp;</a>
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
			$usrID = $row->user_id; 
			$vldtd = $row->validated;
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

				<td class="highlighted" role="gridcell" >
					<?php 
					$tCode = $row->transaction_code;
					$vldtd = $row->validated;
					if($pymntMthdID == 'MP0001'){
						echo '<div style="font-size:11px;">'.$tCode.'</div>'; 
					}
					else{
						if($vldtd == '0'){
							date_default_timezone_set('Asia/Jakarta');
							$bkngExpryDte = $row->booking_expiry;
							$now = date('Y-m-d H:i:s');
							$expryDate = date('Y-m-d H:i:s', strtotime("$bkngExpryDte"));
							
							if($now < $expryDate){
								echo '<div style="font-size:11px;">'.$row->transaction_code.'</div>'.'<br />';
								echo '<div style="font-size:9px;">Expired at <b>'.$row->booking_expiry.'</b></div>'; 
							}
							else{
								echo '<div style="font-size:11px;">'.$row->transaction_code.'</div>';
								echo '<div style="font-size:12px; font-weight:bold;color:#FF0000"><b>BOOKING EXPIRED !</b></div>'; 
							}
						}
						else{
							echo '<div style="font-size:11px;">'.$tCode.'</div>'; 
						}
						
					}
					?>
					
					</td>
				<td class="" role="gridcell" title="<strong><?php echo $pckgNme; ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo '<div style="font-size:11px;">'.$pckgNme.'</div>'; ?></td>
				<td class="highlighted" role="gridcell" style="overflow: visible; text-align:center">
					<!-- <div class="thumb" style="position: relative; z-index: 1;"> -->
						<img alt="Click to zoom" onclick="resizeImg(this)" width="60" height="40" src="<?php echo $pckgImgThmb; ?>" id="image" ></img>
					<!-- </div> -->
				</td>
				<td class="" role="gridcell" title="<strong><?php echo $row->booking_date; ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo '<div style="font-size:11px;">'.$row->booking_date.'</div>'; ?></td>
				<td class="" role="gridcell" title="<strong><?php echo $row->travel_date; ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo '<div style="font-size:11px;">'.$row->travel_date.'</div>'; ?></td>
				<td class="" role="gridcell" title="<strong>IDR <?php echo number_format($totAmountInIDR); ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><div style="font-size:11px;">IDR <?php echo number_format($totAmountInIDR); ?></div></td>
				<td class="" role="gridcell" title="<strong><?php echo $nmMthd; ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good">
				<?php
				if($usrID !== '0'){
					$qry = $this->db->get_where('users', array('users_id' => $usrID));
					foreach($qry->result() as $rows){
					  $usrNme = $rows->username;
					  
					}
				}
				else{
					$usrNme = 'Guest';
				}
				?>
				<?php echo '<div style="font-size:11px;">'.$usrNme.'</div>'; ?>
				</td>
				<td class="" role="gridcell" title="<strong>cetak voucher</strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good">
				<?php
				if($pymntMthdID == 'MP0001'){
				?>
					<div style="font-size:11px;"><a href="<?php echo base_url().'index.php/voucher/cetak/tc/'.$trnstnCode; ?>" target="_blank">Cetak</a></div>
				<?php
				}
				elseif($pymntMthdID !== 'MP0001' && $vldtd == 0){
					date_default_timezone_set('Asia/Jakarta');
					$bkngExpryDte = $row->booking_expiry;
					$now = date('Y-m-d H:i:s');
					$expryDate = date('Y-m-d H:i:s', strtotime("$bkngExpryDte"));
						
					if($now < $expryDate){
				?>		
						<div style="font-size:12px;"><a href="<?php echo base_url().'index.php/booking/detail/tc/'.$trnstnCode; ?>" >Validate</a></div> 
				<?php	
					}
					else{
				?>		
							
						<div style="font-size:12px; font-weight:bold;color:color:#FF0000"><a href="<?php echo base_url().'index.php/booking/delete/'.$trnstnCode; ?>" >Delete</a></div>
				<?php	
					}
				?>	
					
				<?php
				}
				elseif($pymntMthdID !== 'MP0001' && $vldtd == 1){
				?>	
				<div style="font-size:11px;"><a href="<?php echo base_url().'index.php/voucher/cetak/tc/'.$trnstnCode; ?>" target="_blank">Cetak</a></div>
				<?php
				}
				?>
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