<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsiveslides.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/themes.css">
<script src="<?php echo base_url(); ?>assets/js/responsiveslides.min.js"></script>
<script>
$(function () {
// Slideshow 1
      $("#slider").responsiveSlides({
	  /*
        auto: false,
        pager: true,
        nav: true,
        speed: 500,
        maxwidth: 800,
        namespace: "centered-btns"
		*/
		
		auto: true,             // Boolean: Animate automatically, true or false
  speed: 1000,            // Integer: Speed of the transition, in milliseconds
  //timeout: 1000,          // Integer: Time between slide transitions, in milliseconds
  pager: true,           // Boolean: Show pager, true or false
  nav: true,             // Boolean: Show navigation, true or false
  //random: false,          // Boolean: Randomize the order of the slides, true or false
  //pause: false,           // Boolean: Pause on hover, true or false
  //pauseControls: true,    // Boolean: Pause when hovering controls, true or false
  //prevText: "Previous",   // String: Text for the "previous" button
  //nextText: "Next",       // String: Text for the "next" button
  maxwidth: "4800",           // Integer: Max-width of the slideshow, in pixels
  navContainer: "#navCntnr",       // Selector: Where controls should be appended to, default is after the 'ul'
  //manualControls: "#rslides-pager",     // Selector: Declare custom pager navigation
  namespace: "centered-btns",   // String: Change the default namespace used
  //before: function(){},   // Function: Before callback
  //after: function(){}     // Function: After callback
      });

   

});
</script>
<div style="height:10px; background:#1792bc;">&nbsp;</div>
<div id="slider-wrapper">
    <div class="rslides_container">
      <ul class="rslides" id="slider">
        <li><img src="<?php echo base_url(); ?>assets/images/uploads/slide-images/slide1.jpg" alt=""></li>
        <li><img src="<?php echo base_url(); ?>assets/images/uploads/slide-images/slide2.jpg" alt=""></li>
        <li><img src="<?php echo base_url(); ?>assets/images/uploads/slide-images/slide3.jpg" alt=""></li>
        <li><img src="<?php echo base_url(); ?>assets/images/uploads/slide-images/slide4.jpg" alt=""></li>
        <li><img src="<?php echo base_url(); ?>assets/images/uploads/slide-images/slide5.jpg" alt=""></li>
        <li><img src="<?php echo base_url(); ?>assets/images/uploads/slide-images/slide6.jpg" alt=""></li>
      </ul>
      <div style="height:10px; background:#1792bc;">&nbsp;</div>
      <div id="navCntnr" style="background:#1bb9d2; vertical-align:middle; height:43px; margin:0px; padding:0px;" align="center">&nbsp;</div>
      <div id="rslides-pager"></div>
    </div>
</div>