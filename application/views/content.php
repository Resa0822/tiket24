<script>
  // You can also use "$(window).load(function() {"
  $(function () {
 $("#slider_head").responsiveSlides({
        auto: true,
        pager: false,
        nav: true,
        speed: 500,
        namespace: "callbacks",
        before: function () {
          $('.events').append("<li>before event fired.</li>");
        },
        after: function () {
          $('.events').append("<li>after event fired.</li>");
        }
      });
  });
</script>
<div class="content">
	<div id="slider">
		<div class="callbacks_container">
		<ul class="rslides" id="slider_head">
		  <li>
		    <img src="<?php echo $this->config->base_url(); ?>asset/slider/photo_1.jpg" alt="">

		  </li>
		  <li>
		    <img src="<?php echo $this->config->base_url(); ?>asset/slider/photo_2.jpg" alt="">

		  </li>
		  <li>
		    <img src="<?php echo $this->config->base_url(); ?>asset/slider/photo_3.jpg" alt="">

		  </li>
		  <li>
		    <img src="<?php echo $this->config->base_url(); ?>asset/slider/photo_4.jpg" alt="">

		  </li>
		  <li>
		    <img src="<?php echo $this->config->base_url(); ?>asset/slider/photo_5.jpg" alt="">

		  </li>
		</ul>
	      </div>
	</div>
	
	<div style="clear:both;"></div> 
	
	<div>
	<h1 style="padding-left:10px;color:red;">Featured Destination</h1>
	</div>
	
	<div id="featured">
		<div>
		<div id="heading" class="white">
			>> Tours & Special Packages
		</div>
		<?php 
			if(!empty($text)) {
				foreach($text as $row)
				{ 
					$photo = $row->gambar;
					if($photo == ''){
						$photo = $this->config->base_url().'asset/uploads/coming-soon.jpg';
					}
		?>
			<ul class="columns">
				<li title="<?php echo $row->nama; ?>">
						<?php
						$isPromo = $row->discount;
						if(!empty($isPromo)){
						?>
						<!-- START RIBBON -->
						<div class="ribbon ribbon-small ribbon-red" style="top:11px;right:12px; z-index:1200;">
							<div class="banner">
							<div class="text">discount <strong style="font-size:12px;"><?php echo $row->discount.' %'; ?></strong></div>
							</div>
						</div>
						<!-- END RIBBON -->
						<?php
						}
						?>
					<a href="<?php echo $this->config->base_url() ?>index.php/home/detail/1/<?php echo $row->packages_id; ?>" >
						<img src="<?php echo $photo; ?>" >
					</a>
					
					<div class="info">
						
						<span style="z-index:1200; position:absolute;bottom:0px; background:#fff;width:90%;"><?php echo $row->nama;?></span>
						<!--<p><?php echo substr($row->desc,0,100)." ...";?></p>-->
					</div>
					
				</li>
			</ul> 
		<?php	} 
		} else { ?> 
				<center><?php  echo "<h1> EMPTY DATA! </h1>"; ?></center> 
		<?php }?>
			<div style="clear:both"> </div>
		</div>
		
	<div>
		<div class="line"></div>
		<div id="heading" class="white">
			>> Country Packages
		</div> 
		<?php 
			if(!empty($text_ctr)) {
				foreach($text_ctr as $row)
				{ 
					$photo = $row->gambar;
					if($photo == ''){
						$photo = $this->config->base_url().'asset/uploads/coming-soon.jpg';
					}
		?>
			<ul class="columns">
				<li>
					<a href="<?php echo $this->config->base_url() ?>index.php/home/detail/2/<?php echo $row->country_iso; ?>" ><img src="<?php echo $photo; ?>" ></a>
					<div class="info">
						<span style="z-index:1200; position:absolute;bottom:0px; background:#fff;width:90%;text-align:center;"><?php echo $row->country_name;?></span>
						<!--<p><?php echo substr($row->desc,0,100)." ...";?></p>-->
					</div>
				</li>
			</ul> 
		<?php	} 
		} else { ?> 
				<center><?php  echo "<h1> EMPTY DATA! </h1>"; ?></center> 
		<?php }?>
		<div style="clear:both"> </div>
	</div>
	
	<div>
		<div class="line"></div>
		<div id="heading" class="white">
			>> City Packages
		</div>
		<?php 
			if(!empty($text_cty)) {
				foreach($text_cty as $row)
				{ 
					$photo = $row->gambar;
					if($photo == ''){
						$photo = $this->config->base_url().'asset/uploads/coming-soon.jpg';
					}
		?>
			<ul class="columns">
				<li>
					<a href="<?php echo $this->config->base_url() ?>index.php/home/detail/3/<?php echo $row->city_iso; ?>" ><img src="<?php echo $photo; ?>" ></a>
					<div class="info">
						<span style="z-index:1200; position:absolute;bottom:0px; background:#fff;width:90%;text-align: center;"><?php echo $row->city_name;?></span>
					</div>
				</li>
				
			</ul> 
		<?php	} 
		} else { ?> 
				<center><?php  echo "<h1> EMPTY DATA! </h1>"; ?></center> 
		<?php }?>
		<div style="clear:both"> </div>
	</div>
	
	<!--	<div class="line"></div>
		<div id="heading" class="white">
			>> Country Packages
		</div> 
		<img src="<?php //echo $this->config->base_url(); ?>asset/images/image1.jpg">
		<img src="<?php //echo $this->config->base_url(); ?>asset/images/image2.jpg">
		<img src="<?php //echo $this->config->base_url(); ?>asset/images/image3.jpg" />
		<div class="line"></div>
		<div id="heading" class="white">
			>> City Packages
		</div>
		<img src="<?php //echo $this->config->base_url(); ?>asset/images/image1.jpg">
		<img src="<?php //echo $this->config->base_url(); ?>asset/images/image2.jpg">
		<img src="<?php //echo $this->config->base_url(); ?>asset/images/image3.jpg">
		<img src="<?php //echo $this->config->base_url(); ?>asset/images/image4.jpg">
		<img src="<?php //echo $this->config->base_url(); ?>asset/images/image5.jpg"> -->
		
		<!-- <div id="" ><a href="#" class="yelow"><h1>More Destination ..</h1></a></div> -->
	</div>
</div>