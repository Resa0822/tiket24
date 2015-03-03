<?php $this->load->view('header'); ?>
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
		    <img src="<?php echo $this->config->base_url(); ?>asset/slider/1.jpg" alt="">
		    <p class="caption">This is a caption</p>
		  </li>
		  <li>
		    <img src="<?php echo $this->config->base_url(); ?>asset/slider/2.jpg" alt="">
		    <p class="caption">This is another caption</p>
		  </li>
		</ul>
	      </div>
	</div>
	<div id="blue_heading">
	<h1>Featured Destination</h1>
	</div>
	<div id="featured">
		<div id="heading" class="white">
			>> Fuel Day to Koh Angkong Marine Nation
		</div>
		<ul class="columns">
			<li>
				<a href="<?php echo $this->config->base_url() ?>detail" ><img src="<?php echo $this->config->base_url(); ?>asset/images/image1.jpg" ></a>
				<div class="info">
					<h2>Singapore 1</h2>
					<p>Nostrud nostrud quidne pneum imputo, capio quis. Feugiat valetudo praemitto molior abdo. </p>
				</div>

			</li>
			<li>
				<a href="<?php echo $this->config->base_url() ?>detail" ><img src="<?php echo $this->config->base_url(); ?>asset/images/image2.jpg"></a>
				<div class="info">
					<h2>Singapore 1</h2>
					<p>Nostrud nostrud quidne pneum imputo, capio quis. Feugiat valetudo praemitto molior abdo. </p>
				</div>
			</li>
			<li>
				<a href="<?php echo $this->config->base_url() ?>detail" ><img src="<?php echo $this->config->base_url(); ?>asset/images/image3.jpg"></a>
				<div class="info">
					<h2>Singapore 1</h2>
					<p>Nostrud nostrud quidne pneum imputo, capio quis. Feugiat valetudo praemitto molior abdo. </p>
				</div>
			</li>
			<li>
				<a hhref="<?php echo $this->config->base_url() ?>detail" ><img src="<?php echo $this->config->base_url(); ?>asset/images/image4.jpg"></a>
				<div class="info">
					<h2>Singapore 1</h2>	
					<p>Nostrud nostrud quidne pneum imputo, capio quis. Feugiat valetudo praemitto molior abdo. </p>
				</div>
			</li>
			<li>
				<a href="<?php echo $this->config->base_url() ?>detail"><img src="<?php echo $this->config->base_url(); ?>asset/images/image5.jpg"></a>
				<div class="info">
					<h2>Singapore 1</h2>
					<p>Nostrud nostrud quidne pneum imputo, capio quis. Feugiat valetudo praemitto molior abdo. </p>
				</div>
			</li>
			<li>
				<a href="<?php echo $this->config->base_url() ?>detail" >
				<div class="info">
					<h2>Singapore 1</h2>
					<p>Nostrud nostrud quidne pneum imputo, capio quis. Feugiat valetudo praemitto molior abdo. </p>
				</div>
			</li>
		</ul>
		<div id="line"></div>
		<div id="heading" class="white">
			Singapore Flyer E-Ticket  - Early Bird Spesial
		</div>
		<img src="<?php echo $this->config->base_url(); ?>asset/images/image1.jpg">
		<img src="<?php echo $this->config->base_url(); ?>asset/images/image2.jpg">
		<img src="<?php echo $this->config->base_url(); ?>asset/images/image3.jpg" />
		<div id="line"></div>
		<div id="heading" class="white">
			Singapore Flyer E-Ticket  - Early Bird Spesial
		</div>
		<img src="<?php echo $this->config->base_url(); ?>asset/images/image1.jpg">
		<img src="<?php echo $this->config->base_url(); ?>asset/images/image2.jpg">
		<img src="<?php echo $this->config->base_url(); ?>asset/images/image3.jpg">
		<img src="<?php echo $this->config->base_url(); ?>asset/images/image4.jpg">
		<img src="<?php echo $this->config->base_url(); ?>asset/images/image5.jpg">
		
		<div id="" ><a href="#" class="yelow"><h1>More Destination ..</h1></a></div>
	</div>
</div>
<?php $this->load->view('footer'); ?>