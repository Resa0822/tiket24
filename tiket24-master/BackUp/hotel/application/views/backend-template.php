<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/starholiday.ico">

    <title><?php echo $title; ?></title>

    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/allstyles.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script>
$(document).ready(function(){
 // Setup drop down menu
  $('.dropdown-toggle').dropdown();
 
  // Fix input element click problem
  $('.dropdown input, .dropdown label').click(function(e) {
    e.stopPropagation();
  });
});
</script>
</head>

<body>

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
<?php } ?>
    </div>
</div>
<!-- ===================main container end here============ --> 
<!-- ===================footer container start here============ --> 
<div class="footer">
<?php echo $footercontent; ?>
</div>
<!-- ===================footer container end here============ -->

    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/docs.min.js"></script>
  </body>
</html>
