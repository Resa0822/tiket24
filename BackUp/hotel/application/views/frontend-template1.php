<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
   
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
   
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
    <script src="j<?php echo base_url(); ?>assets/js/vendor/modernizr-2.6.2.min.js"></script>
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/starholiday.ico">
  
    <title><?php echo $title; ?></title>

    <link href="<?php echo base_url(); ?>assets/css/bootstrap-1.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/custom-theme/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/allstyles.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-select.min.css" rel="stylesheet">
	<!--<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>-->
	
	<script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.bxslider.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.widgets.js"></script>
	<!--[if (gte IE 6)&(lte IE 8)]>
	  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/selectivizr.js"></script>
	  <noscript><link rel="stylesheet" href="[fallback css]" /></noscript>
	<![endif]-->
	 <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
      <!--[if lt IE 8]>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-ie7.css" rel="stylesheet">
<![endif]-->
<script>
$(document).ready(function(){
 // Setup drop down menu
  $('.dropdown-toggle').dropdown();
  // Fix input element click problem
  $('.dropdown input, .dropdown label').click(function(e) {
    e.stopPropagation();
  });
  $('.tablesorter-bootstrap').tablesorter({
		theme : 'bootstrap',
		headerTemplate: '{content} {icon}',
		widgets    : ['zebra','columns', 'uitheme']
	});
});
</script>
</head>

<body>
 <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
<!-- =================header container start============ -->   
<div class="container-fluid" style="background-color:#ffffff; padding:0px;">
<?php echo $headercontent; ?>
</div>
<!-- =================header container end============ --> 
<div style="clear:both; height:5px;">&nbsp;</div>
<!-- ===================image slider container start here============ -->  
<?php
/* check if images slider is shown or not */
if($slidercontent !== 'none'){
?>
<div class="container-fluid" style="padding:0px">
<?php echo $slidercontent; ?>
</div>
<?php } ?>

<!-- ===================image slider container end here============ -->
<div style="clear: both;">&nbsp;</div>
<!-- ===================main container start here============ -->   
<div class="container-fluid">
    <div class="row">
<?php 
if($leftcontent !== 'none'){
?>    
    <!-- ===================left container start here============ --> 
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="border:0px #FF6600 solid; padding:0px;" id="leftContainer">
        <?php echo $leftcontent; ?>
        </div>
    <!-- ===================left container end here============ --> 
    <!-- ===================right container start here============ --> 
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="rightContainer">
         <?php echo $rightcontent; ?>
        </div>
    <!-- ===================right container end here============ --> 
<?php
}else{
?>    
 		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="rightContainer">
         <?php echo $rightcontent; ?>
        </div>
<?php 
}
?>
    </div> 
</div>
<!-- ===================main container end here============ --> 
<!-- ===================footer container start here============ --> 
<div class="footer">
<?php echo $footercontent; ?>
</div>
<!-- ===================footer container end here============ -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="<?php echo base_url(); ?>assets/js/plugins.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
       <script src="<?php echo base_url(); ?>assets/js/docs.min.js"></script>
    
  </body>
</html>
