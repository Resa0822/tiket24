<?php if($this->session->userdata('role_id','1')){ //if session is created then login to members page ?>       
<a href="<?php echo base_url() ?>index.php/faq"><button class="btn-href">Add New</button></a>
	   <br /><br />
<div id="grid" class="k-grid k-widget k-secondary k-reorderable" data-role="grid" style="">
    <div class="k-grouping-header" data-role="droptarget">Manage Data FAQ</div>
    
	<center>
    <table role="grid" style="width: auto; height: auto; align: center;">
        <!-- <colgroup>
            <col style="width:28px"></col>
            <col style="width:50px"></col>
            <col style="width:190px"></col>
            <col style="width:50px"></col>
            <col></col>
            <col style="width:110px"></col>
            <col style="width:80px"></col>
            <col style="width:80px"></col>
            <col style="width:140px"></col>
        </colgroup> -->
        <thead class="k-grid-header">
            <tr>
               
               
                <th class="k-header k-with-icon" data-title="Category" data-field="category_name" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Pertanyaan</a>
                </th>
                <th class="k-header k-with-icon" data-title="Hotel Name" data-field="hotels_name" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Jawaban</a>
                </th>
                <th class="k-header k-with-icon" data-title="Date" data-field="hotels_date" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#">Date</a>
                </th>
                <th class="k-header k-with-icon" data-title="Publish" data-field="active" role="columnheader" data-role="sortable">
                    <a class="k-header-column-menu" href="#" tabindex="-1">
                        <span class="k-icon k-i-arrowhead-s"></span>
                    </a>
                    <a class="k-link" href="#"> Publish</a>
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
			<tr class="k-alt" role="row" >

				
				<!-- <?php //$type=$row->type_room; echo $tr = json_decode($type); echo $tr[1];?> -->
				
				<td class="" role="gridcell" title="<strong><?php echo $row->pertanyaan; ?></strong><br /> <strong�<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo $row->pertanyaan; ?></td>
				<td class="" role="gridcell" title="<strong><?php echo $row->jawaban; ?></strong><br /> <strong�<strong>Grade : </strong> 3 <strong>Status : </strong> Good"><?php echo $row->jawaban; ?></td>
				<td class="highlighted" align="center" role="gridcell" title="<strong>Date : </strong>&#50;&#48;&#49;&#49;-&#49;&#49;-&#48�ong>Entry By : </strong>info@demo.hotelreservationscript.com"><?php echo $date = date('d/m/Y'); ?></td>
				<td class="highlighted" align="center" role="gridcell">
					<a class="publish_btn" rel="15_Park Regis City Centre Sydney_unpublish" href="<?php echo base_url() ?>index.php/faq/publish/<?php echo $row->faq_id; ?>">
						<img border="0" alt="Click To Un-Publish" title="Click To Un-Publish" src="<?php if($row->publish=='1'){ echo base_url().'asset/images/icon/published.gif'; }else{ echo base_url().'asset/images/icon/unpublished.gif'; } ?>"></img>
					</a>
				</td>
				<td class="highlighted" align="center" role="gridcell">
					<a href="<?php echo base_url() ?>index.php/faq/go/<?php echo $row->faq_id ; ?>">
						<img border="0" alt="Edit" title="Edit" src="<?php echo $this->config->base_url(); ?>asset/images/icon/edit.png">
					</a>
					<a href="<?php echo base_url() ?>index.php/faq/delete/<?php echo $row->faq_id ; ?>">
						<img border="0" alt="Delete" title="Delete" src="<?php echo $this->config->base_url(); ?>asset/images/icon/delete.png"></img>
					</a>
<!-- 					<a class="featured_btn" rel="15_Park Regis City Centre Sydney_featured" href="javascript:void(0);">
						<img border="0" alt="Click To Feature" title="Click To Feature" src="<?php echo base_url() ?>img/icon/featured.gif"></img>
					</a> -->
				</td>
			</tr>
		<?php } 
		}else{ echo "<br/><center><h1>Empty Data !</h1></center><br/>"; }?>
		</tbody>
    </table></center>
    <div class="k-pager-wrap k-grid-pager k-widget" data-role="pager">
		<?php  echo $this->pagination->create_links(); ?>
     <!--  <span class="k-pager-sizes k-label">
            <span class="k-widget k-dropdown k-header" style="" unselectable="on" role="listbox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-owns="" aria-disabled="false" aria-readonly="false" aria-busy="false">
                <span class="k-dropdown-wrap k-state-default" unselectable="on">
                    <span class="k-input" unselectable="on">30</span>
                    <span class="k-select" unselectable="on">
                        <span class="k-icon k-i-arrow-s" unselectable="on">select</span>
                    </span>
                </span>
                <select data-role="dropdownlist" style="display: none;">
                    <option value="1"></option>
                    <option value="5"></option>
                    <option value="10"></option>
                    <option value="15"></option>
                    <option value="30" selected="selected"></option>
                    <option value="100"></option>
                    <option value="500"></option>
                    <option value="1000"></option>
                </select>
            </span>
			items per page
        </span> -->
        <a class="k-pager-refresh k-link" title="Refresh" href="#">
            <span class="k-icon k-i-refresh">Refresh</span>
        </a>
        <span class="k-pager-info k-label">1 - <?php echo $total_rows;?> of <?php echo $total_rows;?> items</span>
    </div>
</div>
<br>
<?php
} else {
			echo "<META http-equiv='refresh' content='3;URL=".base_url()."'>";
			echo "<fieldset><br /><center><h1>404 Page Not Found</h1><br/><br/><h2>The page you requested is not found</h2></center><br/></<fieldset>>";
			//redirect('starholiday/home');
		}	?>