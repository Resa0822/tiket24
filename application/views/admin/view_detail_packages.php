<?php //if($this->session->userdata('role_id','1')){ //if session is created then login to members page ?>
<div style="clear:both;"></div>
<div id="hotel-content-info" class="stylebox">
<a href="<?php echo base_url() ?>index.php/packages/view"><button class="btn-href">Back</button></a>
<br /><br />
<div id="grid" class="k-grid k-widget k-secondary k-reorderable" data-role="grid" style="">
    <div class="k-grouping-header" data-role="droptarget"> 
    	<div style="padding-left:10px;">Package Details</div>   
    </div>
    <div style="clear:both;"></div>
<?php
foreach($listsPckgByID as $row){
	$img = $row->gambar;
	$pckgID = $row->API_packages_id;
	$pckgRefNo = $row->API_packages_refno;
	$pckgName = $row->nama;
	$price = $row->price;
	$crrncy = $row->currency;
	$cityCde = $row->city;
	$countryCde = $row->country;
	$pckgInclsv = $row->ket;
	$trvlPrdBgn = $row->periode_begin;
	$trvlPrdEnd = $row->periode_end;
	$bkngPrdBgn = $row->booking_begin;
	$bkngPrdEnd = $row->booking_end;
	
	$this->db->from('packages_country');
	$this->db->join('packages_city', 'packages_city.country_iso=packages_country.country_iso','left');
	$this->db->where('packages_country.country_iso',$countryCde);
	$this->db->where('packages_city.city_iso',$cityCde );
	$qry = $this->db->get();
	foreach($qry->result() as $rowFld){
		$city = $rowFld->city_name;
		$country = $rowFld->country_name;
	}
	
}
?>    
<table>
    <tr>
    	<td style="width:200px;">Picture</td>
        <td><img  src="<?php echo $img; ?>" width="100" /></td>
    </tr>
    <tr>
    	<td style="width:200px;">Package ID</td>
        <td><?php echo $pckgID; ?></td>
    </tr>
    <tr>
    	<td style="width:200px;">Package Ref. Number</td>
        <td><?php echo $pckgRefNo; ?></td>
    </tr>
    <tr>
    	<td style="width:200px;">Price</td>
        <td><?php echo '<b>'.$crrncy.'</b> '.$price; ?>&nbsp;/&nbsp;person (Adult)</td>
    </tr>
    <tr>
    	<td style="width:200px;">Package Name</td>
        <td><?php echo $pckgName; ?></td>
    </tr>
    <tr>
    	<td style="width:200px;">Country</td>
        <td><?php echo $country; ?></td>
    </tr>
    <tr>
    	<td style="width:200px;">City</td>
        <td><?php echo $city; ?></td>
    </tr>
    <tr>
    	<td style="width:200px;">Package Inclusive</td>
        <td><?php echo $pckgInclsv; ?></td>
    </tr>
    <tr>
    	<td style="width:200px;">Travel Period</td>
        <td><?php echo $trvlPrdBgn.' &nbsp;&nbsp;<b>To</b>&nbsp;&nbsp; '.$trvlPrdEnd; ?></td>
    </tr>
     <tr>
    	<td style="width:200px;">Booking Period</td>
        <td><?php echo $bkngPrdBgn.' &nbsp;&nbsp;<b>To</b>&nbsp;&nbsp; '.$bkngPrdEnd; ?></td>
    </tr>
    <tr>
    	<td style="width:200px;">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
    </div>
</div>
<br>
