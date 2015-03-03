<!--<script type="text/javascript" src="<?=base_url()?>asset/js/jquery-1.10.2.js"></script>-->
<script>
$(document).ready(function(){
	$('.validateBooking').each(function(index) {
    	$(this).click( function() {
    		var trnsCode = $(this).attr('data');
    
 				$( "#dialogContainer" ).dialog({
					modal: true,		
					buttons: {
								Close: function() {
										$( this ).dialog( "close" );
										}
					}
				});
		});
	});
	 $( ".datepicker" ).datepicker({
      numberOfMonths: 2,
      showButtonPanel: true,
       dateFormat: 'yy-mm-dd'
    });
});	
</script>

<div id="dialogContainer"></div>
<!-- ========================================================= -->
<?php //if($this->session->userdata('role_id','1')){ //if session is created then login to members page ?>
<div id="hotel-content-info" class="stylebox">
	<div style="clear: both;"></div>

	   <br />
	   
<div id="grid" class="k-grid k-widget k-secondary k-reorderable" data-role="grid" style="">
    <div class="k-grouping-header" data-role="droptarget">&nbsp;&nbsp;&nbsp;Packages Booking</div>
    
    <table role="grid" style="height: auto;">

        <thead class="k-grid-header">
            <tr>
                 <th class="k-header k-with-icon" role="columnheader">
                    <a class="k-link" href="#"  style="text-align: center;">Transaction Number</a>
                </th>
                <th class="k-header k-with-icon" role="columnheader">
                    <a class="k-link" href="#"  style="text-align: center;">Package Name</a>
                </th>
                <th class="k-header k-with-icon" role="columnheader" style="text-align: right;">
                    
                    <a class="k-link" href="#">Total Amount</a>
                </th>
                <th class="k-header k-with-icon" role="columnheader" style="text-align: center;">
                   
                    <a class="k-link" href="#">Booking Date</a>
                </th>
                <th class="k-header k-with-icon" role="columnheader" style="text-align: center;">
                   
                    <a class="k-link" href="#">User</a>
                </th>
                <th class="k-header k-with-icon" role="columnheader" style="text-align: center;">
                    
                    <a class="k-link" href="#">Status</a>
                </th>
             
                <th class="k-header k-with-icon" role="columnheader" style="text-align: center;">
         
                     <a class="k-link" href="#">Action</a>
                </th>
            </tr>
        </thead>
        <tbody>
		<?php 
		if(!empty($text)) {
		foreach($text as $row)
		{
			$pckgID = $row->API_packages_id;
			$qrySlctPckge = mysql_query("SELECT * FROM packages WHERE API_packages_id='$pckgID' ");
			$fieldPckge = mysql_fetch_array($qrySlctPckge);
			$user = $row->user_role;
			$qrySlctUsr = mysql_query("SELECT * FROM roles WHERE role_id='$user' ");
			$fieldUsr = mysql_fetch_array($qrySlctUsr);
			switch ($row->validated) {
				case 0 : $bookingStatus ='Pending';break;
				case 1 : $bookingStatus ='Validated';break;
				default:
					
					break;
			}
		?>
		<script>
																			
		</script>

			<tr class="k-alt" role="row"  >
				<td class="" role="gridcell" ><?php echo $row->transaction_code; ?></td>
				<td class="" role="gridcell" ><?php echo $fieldPckge['nama']; ?></td>
				<td class="highlighted" align="center" role="gridcell" title="<strong>Date : </strong>&#50;&#48;&#49;&#49;-&#49;&#49;-&#48¡Kong>Entry By : </strong>info@demo.packagesreservationscript.com"><?php echo $row->currency_code.' '.$row->total_sale_price_amount; ?></td>
				<td class="highlighted" align="center" role="gridcell" title="<strong>Date : </strong>&#50;&#48;&#49;&#49;-&#49;&#49;-&#48¡Kong>Entry By : </strong>info@demo.packagesreservationscript.com"><?php echo $row->booking_date; ?></td>
				<td class="highlighted" align="center" role="gridcell" title="<strong>Date : </strong>&#50;&#48;&#49;&#49;-&#49;&#49;-&#48¡Kong>Entry By : </strong>info@demo.packagesreservationscript.com"><?php echo $fieldUsr['role']; ?></td>
				<td class="highlighted" align="center" role="gridcell"><?php echo $bookingStatus; ?></td>
				<td class="highlighted" align="center" role="gridcell">
					
					<table>
						<tr>
							<td><a href="<?php echo base_url().'index.php/booking/detail/tc/'.$row->transaction_code ; ?>" >Validate</a></td>
							<td><a href="<?php echo base_url().'index.php/booking/voucher/tc/'.$row->transaction_code ; ?>" >Voucher</a></td>
						</tr>
					</table>
								
					
				</td>
			</tr>
		<?php } 
		}else{ echo "<br/><center><h1>Empty Data !</h1></center><br/>"; }?>
		</tbody>
    </table>
    <div class="k-pager-wrap k-grid-pager k-widget" style="list-style: none;" data-role="pager">
		<?php  echo $this->pagination->create_links(); ?>
		<a class="k-pager-refresh k-link" title="Refresh" href="#">
            <span class="k-icon k-i-refresh">Refresh</span>
        </a>
        <span class="k-pager-info k-label">1 - <?php echo $total_rows;?> of <?php echo $total_rows;?> items</span>
    </div>
</div>
<br>
<?php /* 
} else {
			echo "<META http-equiv='refresh' content='3;URL=".base_url()."'>";
			echo "<fieldset><br /><center><h1>404 Page Not Found</h1><br/><br/><h2>The page you requested is not found</h2></center><br/></<fieldset>>";
			//redirect('starholiday/home');
		} */	?>
