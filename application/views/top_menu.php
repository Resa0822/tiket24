<div id='cssmenu'>
<?php if ($this->tank_auth->is_logged_in()) {	
		if($this->tank_auth->get_user_role_id() == 1 ) { 
$IDusr = $this->tank_auth->get_user_id(); 
$roleID = $this->tank_auth->get_user_role_id();
$this->db->select('username');
$this->db->from('users');
$this->db->where('users_id', $IDusr);
$this->db->where('role_id', $roleID);
$query = $this->db->get();
foreach($query->result() as $rowPnt){
	
	$usrNme = $rowPnt->username;
}
?>
<ul>
<li><a href='<?php echo $this->config->base_url();?>index.php/auth/logout/'><span>Sign Out ( <?php echo $usrNme; ?> )</span></a></li>
   <li><a href='<?php echo $this->config->base_url();?>index.php/faq/view'><span>FAQs</span></a></li>
   <li class='last'><a href='<?php echo $this->config->base_url();?>index.php/contactus/'><span>Contact US</span></a></li>
   <li class='has-sub'><a href='#'><span>Settings</span></a>
      <ul>
         <li class='has-sub'><a href='#'><span>User Management</span></a>
            <ul>
            <li><a href='<?php echo $this->config->base_url();?>index.php/reseller/view'><span>Activate Reseller</span></a></li>
            <li><a href='<?php echo $this->config->base_url();?>index.php/deposit/view'><span>Deposit Reseller</span></a></li>
         <!--      <li><a href='<?php echo $this->config->base_url();?>index.php/auth/add_users/'><span>Add User</span></a></li>
               <li class='last'><a href='#'><span>View Users</span></a></li> -->
            </ul>
         </li>
         <li class='has-sub'><a href='<?php echo $this->config->base_url();?>index.php/margin/view'><span>Margin Management</span></a>
			<ul>
               <!--<li><a href='<?php echo $this->config->base_url();?>index.php/margin/'><span>Add Margin</span></a></li>
               <li class='last'><a href='<?php echo $this->config->base_url();?>index.php/margin/view'><span>View Margin</span></a></li>  -->
            </ul>
         </li>
         <li class='has-sub'><a href='#'><span>Point Management</span></a>
			<ul>
               <li><a href='<?php echo $this->config->base_url();?>index.php/finance_ctrl/point_setting/'><span>Setting Point</span></a></li>
               <li class='last'><a href='<?php echo $this->config->base_url();?>index.php/koreksi/view/'><span>Koreksi Point</span></a></li>
            </ul>
         </li>
         <li><a href='<?php echo $this->config->base_url();?>index.php/finance_ctrl/payment_setting/'><span>Payment Management</span></a></li>
         
       </ul>
   </li>
   <li><a href='<?php echo $this->config->base_url();?>index.php/transaction/point/'><span>Point History</span></a></li>
   <li><a href='<?php echo $this->config->base_url();?>index.php/transaction/view/'><span>Booking History</span></a></li>
   <li class='has-sub'><a href='#'><span>Master</span></a>
      <ul>
      	<!--<li><a href='<?php echo $this->config->base_url();?>index.php/booking/master'><span>Booking</span></a>-->
         <li class='has-sub'><a href='<?php echo $this->config->base_url();?>index.php/packages/view'><span>Packages</span></a>
<!--           <ul>
               <li><a href='<?php echo $this->config->base_url();?>index.php/packages/'><span>Add Packages</span></a></li>
               <li class='last'><a href='<?php echo $this->config->base_url();?>index.php/packages/view'><span>View Packages</span></a></li>
            </ul> -->
         </li>
         <li class='has-sub'><a href='<?php echo $this->config->base_url();?>index.php/packages_country/view'><span>Countries</span></a>
<!--            <ul>
               <li><a href='<?php echo $this->config->base_url();?>index.php/packages_country/'><span>Add Countries</span></a></li>
               <li class='last'><a href='<?php echo $this->config->base_url();?>index.php/packages_country/view'><span>View Countries</span></a></li>
            </ul>  -->
         </li>
         <li class='has-sub'><a href='<?php echo $this->config->base_url();?>index.php/packages_city/view'><span>Cities</span></a>
<!--            <ul>
               <li><a href='<?php echo $this->config->base_url();?>index.php/packages_city/'><span>Add Cities</span></a></li>
               <li class='last'><a href='<?php echo $this->config->base_url();?>index.php/packages_city/view'><span>View Cities</span></a></li>
            </ul>  -->
         </li>
         <li class='has-sub'><a href='<?php echo $this->config->base_url();?>index.php/currencies/view'><span>Currencies</span></a>
<!--            <ul>
               <li><a href='<?php echo $this->config->base_url();?>index.php/currencies/'><span>Add Currencies</span></a></li>
               <li class='last'><a href='<?php echo $this->config->base_url();?>index.php/currencies/view'><span>View Currencies</span></a></li>
            </ul>  -->
         </li>
      </ul>
   </li>
   
</ul>

<?php } if($this->tank_auth->get_user_role_id() == 2 ) {
$IDusr = $this->tank_auth->get_user_id(); 
$roleID = $this->tank_auth->get_user_role_id();
$this->db->select('total_point, username');
$this->db->from('users');
$this->db->where('users_id', $IDusr);
$this->db->where('role_id', $roleID);
$query = $this->db->get();
foreach($query->result() as $rowPnt){
	$totPoint = $rowPnt->total_point;
	$usrNme = $rowPnt->username;
}	
?>
<ul>
<li><a href='<?php echo $this->config->base_url();?>index.php/auth/logout/'><span>Sign Out ( <?php echo $usrNme; ?> )</span></a></li>
<!--   <li><a href='<?php echo $this->config->base_url();?>index.php/faq/view'><span>FAQs</span></a></li>
   <li class='last'><a href='#'><span>Contact US</span></a></li> -->
   <li><a href='<?php echo $this->config->base_url();?>index.php/transaction/view/'><span>My Booking</span></a></li>
   <li><a href='<?php echo $this->config->base_url();?>index.php/transaction/point/'><span>My Point ( <?php echo $totPoint; ?> )</span></a></li>
   
</ul>
<?php } if($this->tank_auth->get_user_role_id() == 3 ) { 
$IDusr = $this->tank_auth->get_user_id(); 
$roleID = $this->tank_auth->get_user_role_id();
$this->db->select('total_point, username');
$this->db->from('users');
$this->db->where('users_id', $IDusr);
$this->db->where('role_id', $roleID);
$query = $this->db->get();
foreach($query->result() as $rowPnt){
	$totPoint = $rowPnt->total_point;
	$usrNme = $rowPnt->username;
}		
$this->db->select('*');
$this->db->from('deposit');
$this->db->join('reseller_profile', 'reseller_profile.id=deposit.id', 'left');
$this->db->where('users_id', $IDusr);
$qryDpst = $this->db->get();
foreach($qryDpst->result() as $rowDpst){
	$usrDeposit  = $rowDpst->nominal;
	//$usrName = $rowDpst->first_name.' '.$rowDpst->last_name;
}
?>
<ul>
<li><a href='<?php echo $this->config->base_url();?>index.php/auth/logout/'><span>Sign Out ( <?php echo $usrNme; ?> )</span></a></li>
<!--   <li><a href='<?php echo $this->config->base_url();?>index.php/faq/view'><span>FAQs</span></a></li>
   <li class='last'><a href='#'><span>Contact US</span></a></li> -->
   <li class='has-sub'><a href='#'><span>Settings</span></a>
      <ul>
         <li class='has-sub'><a href='#'><span>Margin Management</span></a>
			<ul>
               <li><a href='<?php echo $this->config->base_url();?>index.php/margin/'><span>Add Margin</span></a></li>
               <li class='last'><a href='<?php echo $this->config->base_url();?>index.php/margin/view'><span>View Margin</span></a></li>
            </ul>
         </li>
         <li><a href='<?php echo $this->config->base_url();?>index.php/finance_ctrl/reseller_payment/'><span>Payment Management</span></a></li>
      </ul>
   </li>
   <li><a href='<?php echo $this->config->base_url();?>index.php/transaction/view/'><span>My Booking</span></a></li>
   <li><a href='<?php echo $this->config->base_url();?>index.php/transaction/point/'><span>My Point ( <?php echo $totPoint; ?> )</span></a></li>
   <?php
   if(isset($usrDeposit) && $usrDeposit !== '0'){
   	?>
   	<li><a href='#'><span>Balance ( IDR <?php echo number_format($usrDeposit, 2); ?> )</span></a></li>
   	<?php
   }
   else{
   ?>
   <li><a href='#'><span>Balance ( IDR 0 )</span></a></li>
   <?php
   }
   ?>
  
</ul>
<?php }
} else { ?>
<ul>
   <li><a href='<?php echo $this->config->base_url();?>index.php/faq/lists'><span>FAQs</span></a></li>
   <li class='last'><a href='<?php echo $this->config->base_url();?>index.php/contactus/'><span>Contact US</span></a></li>
   <li><a href='<?php echo $this->config->base_url();?>index.php/auth/login/'><span>Sign In</span></a></li>
</ul>
<?php } ?>
</div>
<div style="clear:both;"></div>