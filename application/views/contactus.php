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
<!--	
	<div id="blue_heading">
	<h1 style="margin-left:5%">Contact Us</h1>
	</div>
	
	<div style="height:90px"></div>
	<center>
	<br />
	<strong><table border="0">
		<tr>
			<td width="60px">Telp</td>
			<td width="20px">:</td>
			<td>022(92807788)</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>:</td>
			<td>contact.starholiday@gmail.com</td>
		</tr>
	</table></strong></center>
	<br /><br />
	<div style="height:90px"></div>
-->
<div style="clear:both;"/>
<div class="container">
<center>
	<div class="col-xs-12 col-md-7">
    	<strong style="padding: 5px;margin: 5px;">PLEASE FIND OUR CONTACT DETAILS BELOW</strong>
    	<dl class="dl-horizontal">
        	<dt><span class="glyphicon glyphicon-map-marker"></span> Adderss: </dt>
         	<dd style="text-align: left;">Company Office Address</dd>
            
            <dt><span class="glyphicon glyphicon-phone-alt"></span> Telephone No: </dt>
         	<dd style="text-align: left;">000 00 00</dd>
            
            <dt><span class="glyphicon glyphicon-print"></span> Fax No: </dt>
         	<dd style="text-align: left;">000 00 00</dd>
            
            <dt><span class="glyphicon glyphicon-phone"></span> Hotline: </dt>
         	<dd style="text-align: left;">000 0000 00</dd>
            
            <dt><span class="glyphicon glyphicon-envelope"></span> E-mail: </dt>
         	<dd style="text-align: left;">
            	Support : <a href="mailto:you@yourdomain.com">you@yourdomain.com</a><br>
                Sales: <a href="mailto:you@yourdomain.com">you@yourdomain.com</a>
            </dd>
            
            <dt><span class="glyphicon glyphicon-link"></span> Website URL: </dt>
           	<dd style="text-align: left;">
            	<a href="#" target="blank">http://www.yourdomain.com</a>
            </dd>
        </dl>
        <div class="alert alert-info" style="width: 50%">
       		<div class="glyphicon glyphicon-info-sign"></div> Our Office Hours Monday to Friday from 10:00A.M to 6:00 P.M
        </div>
    </div>
    
    <div class="col-xs-12 col-md-5" style="width: 50%">
    	<span class="glyphicon glyphicon-globe"></span> View our Location Map<br><br>
    	<iframe src="http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=Flick+Media+Ltd+Suite+110,+Queens+Way+House+275-285+High+Street+Stratford,+London+%E2%80%93+E15+2TF&sll=37.0625,-95.677068&sspn=34.038806,56.513672&ie=UTF8&hq=Flick+Media+Ltd+Suite+110,+Queens+Way+House+275-285+High+Street&hnear=London+E15+2TF,+UK&view=map&ei=i-w-S6vQJ5CojAeE7ZSWCQ&attrid=&ll=51.544253,0.000601&spn=0.007101,0.013797&z=14&iwloc=A&cid=2785574160978382141&output=embed" width="100%" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
    </div>
    <div style="clear:both;"></div>
    <br />
</center>
</div>
</div>