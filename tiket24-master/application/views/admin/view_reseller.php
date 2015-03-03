<?php //if($this->session->userdata('role_id','1')){ //if session is created then login to members page ?>
<div id="hotel-content-info" class="stylebox">

	<!-- <a href="<?php echo base_url() ?>index.php/reseller"><button class="btn-href">Add New</button></a> -->
	
	<div style="clear:both;">&nbsp;</div>
	 <?php if ($message) : ?>
     <div class="valid_box">
        <?php echo $message; ?>
     </div>
	 <?php endif; ?>  
	 <br />
<div id="grid" class="k-grid k-widget k-secondary k-reorderable" data-role="grid" style="">
    <div class="k-grouping-header" data-role="droptarget"> Manage Data reseller</div>
    
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
                <th class="k-header k-with-icon" data-field="checkAll" role="columnheader" data-role="droptarget">
                    <a class="k-header-column-menu" href="#" tabindex="-1" style="display: none;">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <input id="checkAll" class="checkAll_btn" type="checkbox" name="checkAll"></input>
                </th>
                <th class="k-header k-with-icon" data-title="ID" data-field="id" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">ID</a>
                </th>
                <th class="k-header k-with-icon" data-title="reseller Name" data-field="agency_name" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Agency Name</a>
                </th>
                <th class="k-header k-with-icon" data-title="agency Name" data-field="resellers_name" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Reseller Name</a>
                </th>
                <th class="k-header k-with-icon" data-title="Date" data-field="resellers_date" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Date</a>
                </th>
                <th class="k-header k-with-icon" data-title="Action" data-field="common_action" role="columnheader" data-role="droptarget">
                    <a class="k-header-column-menu" href="#" tabindex="-1" style="display: none;">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a> Action
                </th>
            </tr>
        </thead>
        <tbody>
		<?php 
		if(!empty($text)) {
		foreach($text as $row)
		{ ?>
		
		<script>
		function fnacv_btn(id) {
			 var cars = document.getElementById('active');
			 cars.onclick = changeHandler(id);
			 function changeHandler(id){
				 var platform_id = id;
				 $.ajax({
					type: "POST",
					url: "<?php echo site_url('reseller/activated'); ?>",
					data: {id : platform_id},
					success: function(){ 
						window.location.reload();
			//			alert("success"); 
					},
				 });
			//	alert("You changed to "+platform_id);
				
			 }
		}																				
		</script>
<script type="text/javascript">
/* window.onload = fnacv_btn; */
</script>
			<tr class="k-alt" role="row" style="text-align: center;" >

				<td class="highlighted" role="gridcell">
					<input class="check_btn" type="checkbox" value="15"></input>
				</td>
				<!-- <?php $type=$row->type_room; echo $tr = json_decode($type); echo $tr[1];?> -->
				<td class="highlighted" role="gridcell"><?php echo $row->id; ?></td>
				<td class="" role="gridcell" title="<strong><?php echo $row->agency_name; ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo $row->agency_name; ?></td>
				<td class="" role="gridcell" title="<strong><?php echo $row->first_name.$row->last_name; ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo $row->first_name.$row->last_name; ?></td>
				<td class="highlighted" align="center" role="gridcell" title="<strong>Date : </strong>&#50;&#48;&#49;&#49;-&#49;&#49;-&#48…ong>Entry By : </strong>info@demo.resellerreservationscript.com"><?php echo $date = date('d/m/Y'); ?></td>
				<td class="highlighted" align="center" role="gridcell">
				<a href="<?php echo $this->config->base_url(); ?>index.php/reseller/details/id/<?php echo $row->users_id; ?>"><img border="0" title="Details" src="<?php echo $this->config->base_url(); ?>asset/images/icon/view.gif"></img></a>&nbsp;
					<a class="active" id="active" rel="15" href="javascript: void(0);" onclick="fnacv_btn(<?php echo $row->users_id; ?>)">
					<?php if($row->activated ==1) { ?>
						<img border="0" alt="Deactivate" title="Deactivate" src="<?php echo $this->config->base_url(); ?>asset/images/icon/published.gif"></img>
					<?php }else{ ?>
						<img border="0" alt="Activate" title="Activate" src="<?php echo $this->config->base_url(); ?>asset/images/icon/unpublished.gif"></img>
					<?php } ?>
					</a>
<!-- 					<a class="featured_btn" rel="15_Park Regis City Centre Sydney_featured" href="javascript:void(0);">
						<img border="0" alt="Click To Feature" title="Click To Feature" src="<?php echo base_url() ?>img/icon/featured.gif"></img>
					</a> -->
				</td>
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