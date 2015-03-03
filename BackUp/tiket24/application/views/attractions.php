<div id="hotel-content-info" class="stylebox">
				<div>
					<h2 style="margin-left:5%;">Attractions</h2>
					<div id="hotel-content-description" >
						<link href="/common/style/packages.css" rel="stylesheet" type="text/css">
<!--
<table align="center" border="1" cellpadding="0" cellspacing="0" width="783">
	<tbody>
		<tr>
			<td colspan="2">
				<table align="center" cellpadding="0" cellspacing="0" width="783">
					<tbody>
						<tr>
							<td colspan="2">
								<img alt=" " src="/common/media/images/global/animated-banner.jpg" border="0" height="82" width="781"></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
-->
<div class="table" >
<?php 
	if(!empty($text)) {
		foreach($text as $rows)
		{ 
			$photo = $rows->gambar;
			if($photo == ''){
				$photo = $this->config->base_url().'asset/uploads/coming-soon.jpg';
			}
			
			
?> <!-- style="border:1px solid red; min-height: 50px;" --> 
	<div id="table_list">
		<div id="table_image">
			<img src="<?php echo $photo ; ?>" />
			<span><a style="color: black; position: relative; z-index:2;  " href="<?php echo $this->config->base_url(); ?>index.php/attractions/attraction_list_city/<?php echo $rows->country_iso; ?>"><?php echo $rows->country_name; ?></a></span>
		</div>
		<table>
		<?php 
			if(!empty($text_ctr)) {
				$i=0;
				foreach($text_ctr as $row )
				{ 
					$item = $row->city_iso;
					if($row->country_iso == $rows->country_iso){
		?>
			<tr>
				<td>
					<a href="<?php echo $this->config->base_url(); ?>index.php/attractions/attraction_list/<?php echo $row->city_iso; ?>"><?php echo $row->city_name; ?></a></td>
			</tr>
			
		<?php			
				$i++;	
			if($i >= 3){
			echo"<tr>
					<td><a href='".$this->config->base_url()."index.php/attractions/attraction_list_city/".$rows->country_iso."'>More...</a></td>
				</tr>";
				}
				if($i==3) break;
				
					}
			}
			
		 } else { ?> 
				<center style="height:10px;" ><?php  echo "<h1> EMPTY DATA! </h1>"; ?></center> 
		<?php }?>	
		</table>
	</div>
	
<?php	} 
	} else { ?> 
		<center><?php  echo "<h1> EMPTY DATA! </h1>"; ?></center> 
<?php }?>


<!------------------------->
<div style="clear:both;"> </div>

</div>

				</div>	                        
				<div id="hotel-content-value">				
					<!-- <div id=""style="margin-left: 2%"><a href="#" class="yelow"><h1>More Destination ..</h1></a></div>	-->			
				</div>				
</div>
</div>