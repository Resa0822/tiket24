<?php //if($this->session->userdata('role_id','1')){ //if session is created then login to members page ?>
<div id="hotel-content-info" class="stylebox">
	<a href="<?php echo base_url() ?>index.php/packages_city"><button class="btn-href">Add New</button></a>
	 <br /><br />
	 <?php if ($message) : ?>
     <div class="valid_box">
        <?php echo $message; ?>
     </div>
	 <?php endif; ?>  
	 <br />
<div id="grid" class="k-grid k-widget k-secondary k-reorderable" data-role="grid" style="">
    <div class="k-grouping-header" data-role="droptarget"> Manage Data city</div>
    
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
        <!--    <th class="k-header k-with-icon" data-title="ID" data-field="id" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">ID</a>
                </th>-->
                <th class="k-header k-with-icon" data-title="city Name" data-field="citys_name" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Country Name</a>
                </th>
                <th class="k-header k-with-icon" data-title="city Name" data-field="citys_name" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">City Iso</a>
                </th>
                <th class="k-header k-with-icon" data-title="city Name" data-field="citys_name" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">City Name</a>
                </th>
                <th class="k-header k-with-icon" data-title="Thumb" data-field="citys_image" role="columnheader" data-role="droptarget">
                    <a class="k-header-column-menu" href="#" tabindex="-1" style="display: none;">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>Thumb
                </th>
                <th class="k-header k-with-icon" data-title="Order" data-field="hotels_order" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="javascript:void(0)" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="javascript:void(0)">Order  
                    <!--    <a class="all_order_btn" href="javascript: void(0);">
                            <img border="0" src="application/modules/Administrator/layouts/scripts/images/tools/save.png"></img>
                        </a> -->
                    </a>
                </th>
                <th class="k-header k-with-icon" data-title="Date" data-field="citys_date" role="columnheader" data-role="sortable">
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
	<!--	<div id="results"> Results are displayed here </div>
		<div id="fade"></div>
		<div id="modal">
			<img id="loader" src="<?php echo base_url() ?>asset/images/icon/ajax-loader.gif" />
		</div> -->
		<script>
		function openModal() {
			document.getElementById('modal').style.display = 'block';
			document.getElementById('fade').style.display = 'block';
		}

		function closeModal() {
			document.getElementById('modal').style.display = 'none';
			document.getElementById('fade').style.display = 'none';
		}
		function loadAjax() {
			document.getElementById('results').innerHTML = '';
			//openModal();
			var xhr = false;
			if (window.XMLHttpRequest) {
				xhr = new XMLHttpRequest();
			}
			else {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			if (xhr) {
				xhr.onreadystatechange = function () {
					if (xhr.readyState == 4 && xhr.status == 200) {
						closeModal();
					//	document.getElementById("results").innerHTML = xhr.responseText;
					}
				}
				xhr.open("GET", "load-ajax-data.php", true);
				xhr.send(null);
			}
		}
		function fndown_btn(id) {
			 var cars = document.getElementById('down_btn');
			 cars.onclick = changeHandler(id);
			 function changeHandler(id){
				 var idt = "pcx" + id;
				 var newQty = +(document.getElementById(idt).value) + 1;
					document.getElementById(idt).value = newQty; 
			
				 var platform_id = id;
				 var tOrder = document.getElementById(idt).value; 
				 $.ajax({
					type: "POST",
					url: "<?php echo site_url('packages_city/order'); ?>",
					data: {id : platform_id, content : tOrder},
					success: function(){ 
				//		loadAjax();
				//		alert("success"); 
					},
				 });
			//	alert("You changed to "+platform_id+" = "+tOrder);
				}
		}
		function fnup_btn(id) {
		     var cars = document.getElementById('up_btn');
			 cars.onclick = changeHandler(id);
			 function changeHandler(id){
				 var idt = "pcx" + id;
				 var newQty = (document.getElementById(idt).value) - 1;
					if(newQty < 1){
						newQty = 1;
						alert("You can't changed up to 1");
					}else{
						newQty = newQty;
					}
					document.getElementById(idt).value = newQty; 		
			
				 var platform_id = id;
				 var tOrder = document.getElementById(idt).value; 
				 $.ajax({
					type: "POST",
					url: "<?php echo site_url('packages_city/order'); ?>",
					data: {id : platform_id, content : tOrder},
					success: function(){ 
				//		loadAjax();
				//		alert("success"); 
					},
				 });
			//	alert("You changed to "+platform_id+" = "+tOrder);
				}
		}
		function fnchange(id) {
			 var idt = "pcx" + id;
		     var cars = document.getElementById(idt);
			 cars.onclick = changeHandler(id);
			 function changeHandler(id){
				 var idt = "pcx" + id;
				 var newQty = +(document.getElementById(idt).value) ;
					document.getElementById(idt).value = newQty; 
				if(newQty < 1){
					newQty = 1;
					alert("You can't changed up to 1");
				}else{
					newQty = newQty;
				}
					document.getElementById(idt).value = newQty; 		
				 var platform_id = id;
				 var tOrder = document.getElementById(idt).value; 
				 $.ajax({
					type: "POST",
					url: "<?php echo site_url('packages_city/order'); ?>",
					data: {id : platform_id, content : tOrder},
					success: function(){ 
				//		loadAjax();
						alert("success"); 
					},
				 });
			//	alert("You changed to "+platform_id+" = "+tOrder);
				}
		}																				
		</script>
<script type="text/javascript">
window.onload = fnup_btn;
window.onload = fndown_btn;
</script>
			<tr class="k-alt" role="row" style="text-align: center;" >

				<td class="highlighted" role="gridcell">
					<input class="check_btn" type="checkbox" value="15"></input>
				</td>
				<!-- <?php $type=$row->type_room; echo $tr = json_decode($type); echo $tr[1];?> 
				<td class="highlighted" role="gridcell"><?php echo $row->idy; ?></td>-->
				<td class="" role="gridcell" title="<strong><?php echo $row->country_name; ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo $row->country_name; ?></td>
				<td class="" role="gridcell" title="<strong><?php echo $row->city_iso; ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo $row->city_iso; ?></td>
				<td class="" role="gridcell" title="<strong><?php echo $row->city_name; ?></strong><br /> <strong…<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo $row->city_name; ?></td>
				<td class="highlighted" role="gridcell" style="overflow: visible; text-align:center">
					<!-- <div class="thumb" style="position: relative; z-index: 1;"> -->
						<img alt="Click to zoom" onclick="resizeImg(this)" width="60" height="40" src="<?php echo $row->gambar; ?>" id="image" ></img>
					<!-- </div> -->
				</td>
				<td class="highlighted" align="center" role="gridcell">
					<input id="pcx<?php echo $row->idy; ?>" onChange="fnchange(<?php echo $row->idy; ?>)" class="order_text" type="text" value="<?php echo $row->orders; ?>" name="<?php echo "order".$row->idy; ?>" size="1" style="width:15%;height:20px;"></input>
					<a class="up_btn" id="up_btn" rel="15" href="javascript: void(0);" onclick="fnup_btn(<?php echo $row->idy; ?>)">
						<img border="0" src="<?php echo base_url() ?>asset/images/icon/up-arrow.gif"></img>
					</a>
					<a class="down_btn" rel="15" href="javascript: void(0);" onclick="fndown_btn(<?php echo $row->idy; ?>)">
						<img border="0" src="<?php echo base_url() ?>asset/images/icon/down-arrow.gif"></img>
					</a>
				</td>
				<td class="highlighted" align="center" role="gridcell" title="<strong>Date : </strong>&#50;&#48;&#49;&#49;-&#49;&#49;-&#48…ong>Entry By : </strong>info@demo.cityreservationscript.com"><?php echo $date = date('d/m/Y'); ?></td>
				<td class="highlighted" align="center" role="gridcell">
					<a href="<?php echo base_url() ?>index.php/packages_city/go/<?php echo $row->idy ; ?>">
						<img border="0" alt="Edit" title="Edit" src="<?php echo $this->config->base_url(); ?>asset/images/icon/edit.png"></img>
					</a>
					<a href="<?php echo base_url() ?>index.php/packages_city/delete/<?php echo $row->idy ; ?>">
						<img border="0" alt="Delete" title="Delete" src="<?php echo $this->config->base_url(); ?>asset/images/icon/delete.png"></img>
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