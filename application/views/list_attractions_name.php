<div style="clear:both;"/>
<div id="hotel-content-info" class="stylebox">

				<div>
				<div style="clear:both;"/>
					<h2>Tiket24 &amp; Special Packages</h2>
					<hr />
					<br />
					<div id="hotel-content-description" >
						<div style="clear:both"></div>
						<link href="/common/style/packages.css" rel="stylesheet" type="text/css">
						<div class="attraction_list" >
					    
						<?php 
							if(!empty($text)) {
								foreach($text as $row)
								{
									$isPromo = $row->discount; 
									$photo = $row->gambar;
									if($photo == ''){
										$photo = $this->config->base_url().'asset/uploads/coming-soon.jpg';
									}
						?>
						
							<div class="sub2" >
								<div style="position:relative;">
								<?php
								if(!empty($isPromo)){
								?>	
								<!-- START RIBBON -->
								<div class="ribbon ribbon-small ribbon-red" style="top:4px;right:0px;">
									<div class="banner">
									<div class="text">discount <strong style="font-size:12px;"><?php echo $isPromo.' %'; ?></strong></div>
									</div>
								</div>
								<!-- END RIBBON -->
								<?php
								}
								?>
									<a href="<?php echo $this->config->base_url(); ?>index.php/attractions/detail/<?php echo $row->packages_id; ?>">
										
										<img src="<?php echo $photo; ?>"><span><?php echo $row->nama; ?></span>
									</a>
								</div>
							</div>
						<?php	} 
						} else { ?> 
								<center><?php  echo "<h1> EMPTY DATA! </h1>"; ?></center> 
						<?php }?>
						</div>
						<div style="clear:both"></div>
					</div>	
</div>
</div>
<h2>&nbsp;</h2>

