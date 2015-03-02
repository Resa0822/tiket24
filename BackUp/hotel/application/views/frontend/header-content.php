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
        <a class="dropdown-toggle-custom" role="button" data-toggle="dropdown" href="#" id="loginMenu">LOGIN <span class="caret"></span></a>
        
<div class="dropdown-menu pull-right" aria-labelledby="loginMenu" id="dropdownContentLogin">
    <div class="control-group">
      <label class="control-label" for="username">Username</label>
      <div class="controls">
        <input id="username" name="username" class="form-control" type="text">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="password">Password</label>
      <div class="controls">
        <input id="password" name="password" class="form-control" type="password">
      </div>
    </div>
    <div class="control-group">
        <label class="checkbox inline" for="rememberMe">
        <input name="rememberMe" id="rememberMe" value="1" type="checkbox">
              Remember Me
        </label>
    </div>
    <div class="control-group">
      <div class="controls">
        <button id="singlebutton" name="singlebutton" class="btn btn-primary">Sign In</button>
        <a href="<?php echo base_url();?>signup" style="color:#FF0000; margin-left:5px;">Sign Up</a>
      </div>
    </div>
    <div align="center" style="padding:5px;"><a href="#" >Forget Password</a></div>
</div>
  </li>
  
</ul>
</div>
<!-- =================top nav menu container end============ -->