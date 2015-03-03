<div id="headLogo">&nbsp;</div>
<div style="clear:both; height:5px;">&nbsp;</div>
<!-- =================top nav menu container start============ -->
<div>
<?php
switch($topNavActive){
case 'home': $homeActive = 'class="active"';$hotelActive = '';$flightActive = '';$eventActive = '';$contactusActive = '';$faqActive = '';break;
case 'hotel': $homeActive = '';$hotelActive = 'class="active"';$flightActive = '';$eventActive = '';$contactusActive = '';$faqActive = '';break;
case 'flight': $homeActive = '';$hotelActive = '';$flightActive = 'class="active"';$eventActive = '';$contactusActive = '';$faqActive = '';break;
case 'event': $homeActive = '';$hotelActive = '';$flightActive = '';$eventActive = 'class="active"';$contactusActive = '';$faqActive = '';break;
case 'contactus': $homeActive = '';$hotelActive = '';$flightActive = '';$eventActive = '';$contactusActive = 'class="active"';$faqActive = '';break;
case 'faq': $homeActive = '';$hotelActive = '';$flightActive = '';$eventActive = '';$contactusActive = '';$faqActive = 'class="active"';break;
default: 
 $homeActive = 'class="active"';$hotelActive = '';$flightActive = '';$eventActive = '';$contactusActive = '';$faqActive = '';
}
?>
<ul class="nav nav-pills-custom pull-right">
  <li <?php echo $homeActive; ?> ><a href="<?php echo base_url();?>home">HOME</a></li>
  <li <?php echo $hotelActive; ?> ><a href="<?php echo base_url();?>hotel">HOTEL</a></li>
  <li <?php echo $flightActive; ?> ><a href="<?php echo base_url();?>flight">FLIGHT</a></li>
  <li <?php echo $eventActive; ?> ><a href="<?php echo base_url();?>event">EVENT</a></li>
  <li <?php echo $contactusActive; ?> ><a href="<?php echo base_url();?>contactus">CONTACT US</a></li>
  <li <?php echo $faqActive; ?> ><a href="<?php echo base_url();?>faq">FAQ</a></li>
  <li class="dropdown">
        <a class="dropdown-toggle-custom" role="button" data-toggle="dropdown" href="#" id="loginMenu">Admin <span class="caret"></span></a>
        
<div class="dropdown-menu pull-right" aria-labelledby="loginMenu" id="dropdownContentLogin">
   <div>Logout</div>
</div>
  </li>
  
</ul>
</div>
<!-- =================top nav menu container end============ -->