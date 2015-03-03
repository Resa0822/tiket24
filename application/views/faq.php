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
<style>
	.divCorner{
		width:80%;height:auto;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;border:2px solid #5a9cd4;background-color:#67B6FC;
	}
</style>


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
	
	<div id="blue_heading" style="margin-bottom: 10px;">
	<h1 style="margin-left:5%">Frequently Asked Questions (FAQ)</h1>
	</div>
	
	<div class="divCorner" style="margin:0 auto; left:0px right:0px;padding:10px;">
		<?php foreach($text as $row){ ?> 
	<div class="faqtanya" style="border:2px #4496db solid; margin-bottom: 10px; vertical-align: top;">
		<div style="background:#4496db;color:#fff; font-size:1.1em; padding: 8px; font-weight: bold;"><?php echo $row->pertanyaan; ?></div>
		<div class="faqjawab" style="padding: 5px;">
			<?php echo $row->jawaban; ?>
		</div>
	</div> 
	<?php } echo $this->pagination->create_links(); ?>
	</div>
	
	<div style="clear:both; margin-bottom: 10px;"></div>	
	
</div>