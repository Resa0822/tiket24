<?php
error_reporting(0);
?>
<style>
::selection { background: #a4dcec; }
::-moz-selection { background: #a4dcec; }
::-webkit-selection { background: #a4dcec; }
::-webkit-input-placeholder { /* WebKit browsers */
  color: #ccc;
  font-style: italic;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
  color: #ccc;
  font-style: italic;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
  color: #ccc;
  font-style: italic;
}
:-ms-input-placeholder { /* Internet Explorer 10+ */
  color: #ccc !important;
  font-style: italic;  
}
#topbar {
  background: #4f4a41;
  padding: 10px 0 10px 0;
  text-align: center;
  height: 36px;
  overflow: hidden;
}
#topbar a {
  color: #fff;
  font-size:1.3em;
  line-height: 1.25em;
  text-decoration: none;
  opacity: 0.5;
  font-weight: bold;
}
#topbar a:hover {
  opacity: 1;
}
.center { display: block; text-align: center; }
/** page structure **/
#w {
  display: block;
  width: 750px;
  margin: 0 auto;
  padding-top: 30px;
  padding-bottom: 45px;
}
.paginate {
  display: block;
  width: 100%;
  font-size: 1.2em;
}
/** 1st pagination **/
.paginate.pag1 { /* first page styles */ }
.paginate.pag1 li { font-weight: bold;}
.paginate.pag1 li a {
  display: block;
  float: left;
  color: #717171;
  background: #e9e9e9;
  text-decoration: none;
  padding: 5px 7px;
  margin-right: 6px;
  border-radius: 3px;
  border: solid 1px #c0c0c0;
  box-shadow: inset 0px 1px 0px rgba(255,255,255, .7), 0px 1px 3px rgba(0,0,0, .1);
  text-shadow: 1px 1px 0px rgba(255,255,255, 0.7);
}
.paginate.pag1 li a:hover {
  background: #eee;
  color: #555;
}
.paginate.pag1 li a:active {
  -webkit-box-shadow: inset -1px 2px 5px rgba(0,0,0,0.25);
  -moz-box-shadow: inset -1px 2px 5px rgba(0,0,0,0.25);
  box-shadow: inset -1px 2px 5px rgba(0,0,0,0.25);
}
.paginate.pag1 li.single, .paginate.pag1 li.current {
  display: block;
  float: left;
  border: solid 1px #c0c0c0;
  padding: 5px 7px;
  margin-right: 6px;
  border-radius: 3px;
  color: #444;
}
/** 2nd pagination **/
/* resource: http://pixelsdaily.com/resources/photoshop/psds/minimal-pagination/ */
.paginate.pag2 { /* second page styles */ }
.paginate.pag2 li { font-weight: bold; list-style: none;}
.paginate.pag2 li a {
  display: block;
  float: left;
  color: #585858;
  text-decoration: none;
  padding: 6px 11px;
  margin-right: 6px;
  border-radius: 3px;
  border: 1px solid #ddd;
  background-color: #eee;
  background-image: -webkit-gradient(linear, left top, left bottom, from(#f7f7f7), to(#eee));
  background-image: -webkit-linear-gradient(top, #f7f7f7, #eee);
  background-image: -moz-linear-gradient(top, #f7f7f7, #eee);
  background-image: -ms-linear-gradient(top, #f7f7f7, #eee);
  background-image: -o-linear-gradient(top, #f7f7f7, #eee);
  background-image: linear-gradient(top, #f7f7f7, #eee);
  -webkit-box-shadow: 2px 2px 4px -1px rgba(0,0,0, .55);
  -moz-box-shadow: 2px 2px 4px -1px rgba(0,0,0, .55);
  box-shadow: 2px 2px 4px -1px rgba(0,0,0, .55);
}
.paginate.pag2 li a:hover {
  color: #3280dc;
}
.paginate.pag2 li a:active {
  position: relative;
  top: 1px;
  -webkit-box-shadow: 1px 1px 3px -1px rgba(0,0,0, .55);
  -moz-box-shadow: 1px 1px 3px -1px rgba(0,0,0, .55);
  box-shadow: 1px 1px 3px -1px rgba(0,0,0, .55);
}
.paginate.pag2 li.single, .paginate.pag2 li.current {
  display: block;
  float: left;
  padding: 6px 11px;
  padding-top: 8px;
  margin-right: 6px;
  border-radius: 3px;
  color: #676767;
}
/** 3rd pagination **/
/* resource: http://pixelsdaily.com/resources/photoshop/psds/psd-slick-pagination-links/ */
.paginate.pag3 { /* third page styles */ }
.paginate.pag3 li { font-weight: bold; }
.paginate.pag3 li a {
  display: block;
  float: left;
  text-decoration: none;
  padding: 6px 11px;
  margin-right: 6px;
  border-radius: 3px;
  color: #fff;
  text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.5);
  border: 1px solid #43505e;
  background: #556270;
  background: -moz-linear-gradient(top, #556270 0%, #444d57 100%);
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#556270), color-stop(100%,#444d57));
  background: -webkit-linear-gradient(top, #556270 0%,#444d57 100%);
  background: -o-linear-gradient(top, #556270 0%,#444d57 100%);
  background: -ms-linear-gradient(top, #556270 0%,#444d57 100%);
  background: linear-gradient(to bottom, #556270 0%,#444d57 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#556270', endColorstr='#444d57',GradientType=0 );
  -moz-box-shadow: inset 0 3px 0px -2px rgba(255, 255, 255, .3);
  -webkit-box-shadow: inset 0 3px 0px -2px rgba(255, 255, 255, .3);
  box-shadow: inset 0 3px 0px -2px rgba(255, 255, 255, .3);
}
.paginate.pag3 li a:hover {
  background: #556270;
  background: -moz-linear-gradient(top, #556270 0%, #5b6774 100%);
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#556270), color-stop(100%,#5b6774));
  background: -webkit-linear-gradient(top, #556270 0%,#5b6774 100%);
  background: -o-linear-gradient(top, #556270 0%,#5b6774 100%);
  background: -ms-linear-gradient(top, #556270 0%,#5b6774 100%);
  background: linear-gradient(to bottom, #556270 0%,#5b6774 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#556270', endColorstr='#5b6774',GradientType=0 );
}
.paginate.pag3 li a:active {
  background: #414952;
  background: -moz-linear-gradient(top, #414952 0%, #555e68 100%);
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#414952), color-stop(100%,#555e68));
  background: -webkit-linear-gradient(top, #414952 0%,#555e68 100%);
  background: -o-linear-gradient(top, #414952 0%,#555e68 100%);
  background: -ms-linear-gradient(top, #414952 0%,#555e68 100%);
  background: linear-gradient(to bottom, #414952 0%,#555e68 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#414952', endColorstr='#555e68',GradientType=0 );
}
.paginate.pag3 li.single, .paginate.pag3 li.current {
  display: block;
  float: left;
  text-decoration: none;
  padding: 6px 11px;
  margin-right: 6px;
  border-radius: 3px;
  color: #fff;
  text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.5);
  border: 1px solid #616c78;
  background: #838d98;
  -moz-box-shadow: inset 0 3px 0px -2px rgba(255, 255, 255, .3);
  -webkit-box-shadow: inset 0 3px 0px -2px rgba(255, 255, 255, .3);
  box-shadow: inset 0 3px 0px -2px rgba(255, 255, 255, .3);
}
/** 4th pagination **/
/* resource: http://pixelsdaily.com/resources/photoshop/psds/flat-pagination-interface/ */
.paginate.pag4 { /* fourth page styles */ 
  font-size: 1.4em;
}
.paginate.pag4 li { font-weight: bold; }
.paginate.pag4 li a {
  display: block;
  float: left;
  color: #a2c49e;
  text-decoration: none;
  padding: 9px 12px;
  margin-right: 6px;
  border-radius: 16px;
  background: #363842;
  -webkit-transition: all 0.3s linear;
  -moz-transition: all 0.3s linear;
  transition: all 0.3s linear;
}
.paginate.pag4 li a:hover {
  color: #fff;
}
.paginate.pag4 li a:active {
  -webkit-box-shadow: 1px 1px 3px -1px rgba(0,0,0, .55);
  -moz-box-shadow: 1px 1px 3px -1px rgba(0,0,0, .55);
  box-shadow: 1px 1px 3px -1px rgba(0,0,0, .55);
}
.paginate.pag4 li.navpage a {
  padding: 9px 13px;
  background: #607c5d;
  color: #fff;
}
.paginate.pag4 li.navpage a:hover {
  background: #486f43;
}
.paginate.pag4 li.single, .paginate.pag4 li.current {
  display: block;
  float: left;
  padding: 9px 12px;
  margin-right: 6px;
  border-radius: 16px;
  color: #607c5d;
  background: #d0dfcf;
}
/** 5th pagination (dark) **/
.paginate.pag5 { /* fifth page styles */ 
  font-size: 1.4em;
  padding: 9px 8px;
  background: #373943;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
}
.paginate.pag5 li { font-weight: bold; }
.paginate.pag5 li a {
  display: block;
  float: left;
  color: #5ea25a;
  text-decoration: none;
  padding: 9px 12px;
  margin-right: 6px;
  border-radius: 16px;
  background: #fff;
  -webkit-transition: all 0.3s linear;
  -moz-transition: all 0.3s linear;
  transition: all 0.3s linear;
}
.paginate.pag5 li a:hover {
  color: #4f664e;
  background: #c9dec8;
}
.paginate.pag5 li a:active {
  -webkit-box-shadow: 1px 1px 3px -1px rgba(0,0,0, .55);
  -moz-box-shadow: 1px 1px 3px -1px rgba(0,0,0, .55);
  box-shadow: 1px 1px 3px -1px rgba(0,0,0, .55);
}
.paginate.pag5 li.navpage a {
  padding: 9px 13px;
  background: #c8eac6;
  color: #4f664e;
}
.paginate.pag5 li.navpage a:hover {
  color: #414e40;
  background: #a4c6a2;
}
.paginate.pag5 li.current { background: #505362; }
.paginate.pag5 li.single, .paginate.pag5 li.current {
  display: block;
  float: left;
  padding: 9px 12px;
  margin-right: 6px;
  border-radius: 16px;
  color: #fff;
}
/** clearfix **/
.clearfix:after { content: "."; display: block; clear: both; visibility: hidden; line-height: 0; height: 0; }
.clearfix { display: inline-block; }
html[xmlns] .clearfix { display: block; }
* html .clearfix { height: 1%; }
</style>
<div class="content detail_hd">
<div style="clear:both;"/>
	<!--
    <h1 class="white" style="font-size: 26px;margin-left: 30px;">Hot Deal</h1>
    <div class="detail_hd">
        <ul class="detail_image">
            <li><img src="<?php echo $this->config->base_url(); ?>asset/images/image1.jpg"></li>
            <li><img src="<?php echo $this->config->base_url(); ?>asset/images/image2.jpg"></li>
            <li><img src="<?php echo $this->config->base_url(); ?>asset/images/image3.jpg"></li>
            <li><img src="<?php echo $this->config->base_url(); ?>asset/images/image4.jpg"></li>
            <li><img src="<?php echo $this->config->base_url(); ?>asset/images/image5.jpg"></li>
        </ul>
        <div class="desc">
            <div id="doted">Visitor Info</div>
            Nostrud nostrud quidne pneum imputo, capio quis. Feugiat valetudo praemitto molior abdo. 
		</div>
    </div>
   -->
    <?php
if($hotDealResults != FALSE){
	
foreach($hotDealResults as $row)
{
	$isDiscnt = $row->discount;  
	$crrncy = $row->currency;
	$photo = $row->gambar;
	if($photo == ''){
		$photo = $this->config->base_url().'asset/uploads/coming-soon.jpg';
	} 
?> 
	<div id="package">
        <div id="package_list">
            <div id="package_info">		
			<div style="clear:both;"></div>
                <h1 class="red">
                	<?php echo " >> ".$row->nama; 
                	if(!empty($row->discount)){
						if($row->discount > 0){
					?>
				<?php
						}
					} 
				?>
				</h1>
                <table>
                    <tr>
                        <td valign="top">Package Inclusive</td>
                        <td valign="top">:</td>
                        <td style="vertical-align:top;">
                        <?php echo $row->ket; ?>
                        </td>
                    </tr>
                    <tr>
					<?php 
					if(!empty($row->desc)){ 
						echo '<td colspan="3" class="red"><p><strong>***Note : </strong>'.$row->desc.'**</p></span></td>';
					} 
					?>
                    </tr>
                    <tr>
                        <td valign="top">Booking Period</td>
                        <td valign="top">:</td>
                        <td><?php echo date("d M Y", strtotime($row->booking_begin))." to ".date("d M Y", strtotime($row->booking_end)); ?></td>
                    </tr>
                    <tr>
                        <td valign="top">Travel Period</td>
                        <td valign="top">:</td>
                        <td><?php echo date("d M Y", strtotime($row->periode_begin))." to ".date("d M Y", strtotime($row->periode_end)); ?></td>
                    </tr>
                </table><br/>
                <?php   
                /* margin and package profit price */
                if ($this->tank_auth->is_logged_in()) {	
					switch($this->tank_auth->get_user_role_id()) {
						case 1 : $userRoleID = '1'; break;
						case 2 : $userRoleID = '2'; break;
						case 3 : $userRoleID = '3'; break;
					}
					
				} 
				else{
					$userRoleID = '4';
				}
				
                $pckgsPrice = $row->price;
				$pckgCode = $row->API_packages_id;
                
				/* cek package jika ada diskon */
				$this->db->select('discount, guest_margin_rp, guest_margin_pr, member_margin_rp, member_margin_pr, reseller_margin_rp, reseller_margin_pr');
				$this->db->from('packages');
				$this->db->where('API_packages_id', "$pckgCode");
				$qryCekDskn = $this->db->get();
				foreach($qryCekDskn->result() as $dsknRow){
					$diskon = $dsknRow->discount; 
					switch($userRoleID){
						case 2 : $mrgn_pr = $dsknRow->member_margin_pr;break;
						case 3 : $mrgn_pr = $dsknRow->reseller_margin_pr;break;
						case 4 : $mrgn_pr = $dsknRow->guest_margin_pr;break;	
					}
					
				}
					if($diskon == 0){
						$qrySlctMrgn = mysql_query("SELECT * FROM margin WHERE role_id='$userRoleID' ");
		                $mrgnFld = mysql_fetch_array($qrySlctMrgn);
						
		                $prcntMrgn = $mrgnFld['margin_pr'] / 100;
						$profit = $pckgsPrice * $prcntMrgn;  
						$salePrice = round($pckgsPrice + $profit, 2);
						$tmplHarga = 'from'.' '.'SGD'.' '.$salePrice.' / Person';
					}
					else{
						
						$qrySlctMrgn = mysql_query("SELECT * FROM margin WHERE role_id='$userRoleID' ");
		                $mrgnFld = mysql_fetch_array($qrySlctMrgn);
						
		                $prcntMrgn = $mrgn_pr / 100;
						$profit = $pckgsPrice * $prcntMrgn; 
						$hrgPckage = $pckgsPrice + $profit;
						$nomDisc = $hrgPckage + ($hrgPckage * ($diskon / 100));
						$priceMarkup = round($nomDisc, 2);
						$salePrice = round($pckgsPrice + $profit, 2);
						$tmplHarga = '<del>from'.' '.$crrncy.' '.number_format($priceMarkup,2).' / Person</del><br /><b>from'.' '.$crrncy.' '.number_format($salePrice,2).' / Person</b>';
					}
				/*<div id="price"><?php echo "fr. ".$row->currency." ".number_format($row->price, 2, '.', ''); ?> / Person </div><div class="button"><a href="<?php echo $this->config->base_url();?>index.php/detail/book/<?php echo $row->packages_id; ?>">Book now</a></div>*/
                ?>
                <div id="price">
                	<?php echo $tmplHarga; ?>  
                </div>
                <div class="button">
                	<a href="<?php echo $this->config->base_url();?>index.php/detail/book/<?php echo $row->packages_id; ?>">Book now</a>
                </div>
            </div>
            <div id="package_image" style="position:relative; top:50px;">
            	
            	<?php
            	if(!empty($isDiscnt)){
            	?>
            	<!-- START RIBBON -->
				<div class="ribbon ribbon-large ribbon-red" style="z-index: 5000;right:3px;">
				<div class="banner">
				<div class="text">discount <strong style="font-size:34px;"><?php echo $row->discount.' %'; ?></strong></div>
				</div>
				</div>
				<!-- END RIBBON -->
            	<?php	
            	}
            	?>
				
                 <img src="<?php echo $photo; ?>" style="height:170px;">
                <span>Packag Code : <?php echo $row->kode; ?></span><br/>
            </div>
			<div style="clear:both;"></div><br/>
        </div>
    </div>
	<br/>
<?php
}
}
else{
?>
<div id="package">
	<div id="package_list">
	<center><?php  echo "<h1> EMPTY DATA! </h1>"; ?></center>
	</div>
</div>
<?php
}
?>
	<ul class="paginate pag2 clearfix">
	 	<?php echo $this->pagination->create_links(); ?>
	</ul>
	
</div>
