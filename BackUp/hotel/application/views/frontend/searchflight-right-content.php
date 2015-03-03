
<script src="<?php echo base_url(); ?>assets/js/jquery.tinysort.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.tinysort.charorder.js"></script>
<script>
$(document).ready(function(){
var aAsc = [];
	function sortTable(e) {
	var nr = $(e.currentTarget).index();
	aAsc[nr] = aAsc[nr]=='asc'?'desc':'asc';
	$('#flight_schedule>tbody>tr').tsort('td:eq('+nr+')[abbr]',{order:aAsc[nr]});
	}
$('#flight_schedule').find('thead th:last').siblings().on('click',sortTable);
});
</script>



<!-- =========================================== -->
<style>
.prevSlideFlight{
position:relative; background-color:#60d9ec; padding:25px 10px 25px 10px; vertical-align:middle; margin:0px; cursor: pointer; color:#1792bc; font-weight: bold; font-size:16px; display:inline-block;
}
.prevSlideFlight:hover{
position:relative; background-color:#1792bc; padding:25px 10px 25px 10px; vertical-align:middle; margin:0px; cursor: pointer; color:#ffffff; font-weight: bold; font-size:16px; display:inline-block;
}
.nextSlideFlight{
position:relative; background-color:#60d9ec; padding:25px 10px 25px 10px; vertical-align:middle; margin:0px; cursor: pointer; color:#1792bc; font-weight:bold; font-size:16px;display:inline-block;
}
.nextSlideFlight:hover{
position:relative; background-color:#1792bc; padding:25px 10px 25px 10px; vertical-align:middle; margin:0px; cursor: pointer; color:#ffffff; font-weight:bold; font-size:16px;display:inline-block;
}
.bxslider li a{ text-decoration:none; padding:0px; margin:0px;}
.bxslider li{ background-color:#60d9ec; height:70px;margin:0px; padding:0px; vertical-align:middle; position:relative;}
.bxslider li:hover { background-color: #90f0fe; height:70px;margin:0px; padding:0px; position:relative;  }

.bxslider li a div{ padding:0px; margin:0px; font-weight:bold; color:#FF6600;height:70px; padding-top:15px;border-left:1px #999999 solid;border-right:1px #999999 solid;}
.bxslider li a div:hover{ padding:0px; margin:0px; font-weight:bold; color:#FF6600;height:70px; padding-top:15px;border-left:1px #999999 solid;border-right:1px #999999 solid; }
.bxslider li a div:hover h5{ padding-bottom:5px; margin:0px; font-weight:bold; color: #db283e;}
.bxslider li div h5 { padding-bottom:5px; margin:0px; font-weight:bold; color: #116291;}
.bxslider li div em{ padding:0px; margin:0px; font-weight: normal; color:#000;}
.bxslider li div span{ padding:0px; margin:0px; font-weight: bold; color:#000;}

li.slideSelected{ padding:0px; margin:0px; font-weight:bold; color:#FF6600;height:70px; border:3px #FF6600 solid; border-collapse:collapse; position:absolute; z-index:500; background-color:#90f0fe}
li.slideSelected div h5{color:#db283e;}
li.slideSelected:hover{height:70px;}
</style>
<script>
$(document).ready(function(){

var slider = $('.bxslider').bxSlider({
		    minSlides: 5,
            maxSlides: 5,
            slideWidth: 164,
            slideMargin: 0,
			moveSlides : 1,
            pager:false,
			controls : false,
			adaptiveHeight : false,
			responsive : false,
			onSliderLoad: function(currentIndex){
        					$("#bxSliderContainer").css("visibility", "visible");
							
      					}
		
	});
	slider.goToSlide(3);
	/*
	onSliderLoad : function(currentIndex){
	slider.goToSlide(6);
	});*/
	
	$('#flightNextSlide').click(function(){
      slider.goToNextSlide();
      return false;
    });

    $('#flightPrevSlide').click(function(){
      slider.goToPrevSlide();
      return false;
    });

});
</script>



<div class="panel panel-primary costumpanel boxshadow" >
      <div class="panel-heading costum_panel_head" style="background:#1792bc">
        <h3 class="panel-title"><b>Flight Search Results</b></h3>
      </div>
      <div class="panel-body">
      	<div style="margin:10px; padding: 0px 0px 5px 10px; border-bottom: 1px #CCC solid; color: #003399">
      		Search for Tikets of <?php echo '<b>'.$dprtrCity.'</b> to <b>'.$arrvlCity.'</b> on <b>'.date('d M Y',strtotime($dprtngDate)).'</b> at star-holiday.com';  ?>
      	</div>
      	<div style="margin:10px; padding: 0px 0px 5px 10px;">
      		Choosen Depart Flight &nbsp;
      		<span style="color:#2b4e75;font-weight: bold;"><?php echo $dprtrCityCountry; ?></span> &nbsp;
      		<img src="<?php echo base_url().'assets/images/icons/icon-flight.png' ?>" />&nbsp;
      		<span style="color:#2b4e75;font-weight: bold;"><?php echo $arrvlCityCountry; ?></span>
      	</div>
      	
      	<div style="padding:0px; background: #60d9ec; width:100%; visibility:hidden" align="center" id="bxSliderContainer">

    <span id="flightPrevSlide" class="prevSlideFlight" title="previous"><</span>

<div style="padding:0px; margin:0px; vertical-align:middle; display:inline-block;">
    <ul class="bxslider" style="padding:0px; margin:0px;">
<?php  
$searchResultSlider = $tableSearchResult;
$searchResultContent = $tableSearchResult;
$currency = $searchResultContent['diagnostic']['currency'];
if(!empty($searchResultSlider['nearby_go_date']['nearby'])){
	$i=0;
	foreach($searchResultSlider['nearby_go_date']['nearby'] as $rowFld){
	$tgl = $searchResultSlider['nearby_go_date']['nearby'][$i]['date'];
	if($tgl == $dprtngDate){
		$slctActv = 'class="slideSelected"';
	}
	else{
		$slctActv = '';
	}	
	$tanggal = date('D, d M Y', strtotime($tgl))	
?>
	  <li <?php echo $slctActv; ?>>
	  	 <a href="<?php echo base_url(); ?>searchflight?flightTrip=1&departures=<?php echo $dprtngArprtCode; ?>&arrivals=<?php echo $arrvlArprtCode; ?>&departingDate=<?php echo $tgl; ?>&returningDate=&adults=1&childs=0&infants=0" title="<?php echo $tanggal; ?>" target="_parent">							
          <div>
          <h5><?php echo $tanggal; ?></h5>
          <em>from</em> <span><?php echo $currency.' '.$searchResultSlider['nearby_go_date']['nearby'][$i]['price']; ?></span>
          </div>
      </a>
      </li>
<?php
	$i++;
	} 	
}
?>   	

    </ul>
</div>

    <span id="flightNextSlide" class="nextSlideFlight" title="next">></span>
   
</div>
<!-- =========================================== -->
 <div style="clear:both;">&nbsp;</div>     	
      	<table border="0" cellpadding="0" cellspacing="0" class="table" id="flight_schedule">
			<thead>
				<tr>
					<th class="flights"><a>Flight</a></th>
					<th class="depart" ><a>Depart</a></th>
					<th class="arrival" ><a>Arrival</a></th>
					<th class="transit" ><a>Transit</a></th>
					<th class="allowance" ><a>Allowance</a></th>
					<th class="price" ><a>Price</a></th>
					<th class="action">&nbsp;</th>
				</tr>
			</thead>
			
			<tbody>
				
				<?php 
				if(!empty($searchResultContent['departures']['result'])){
					//$currency = $searchResultContent['diagnostic']['currency'];
					$i=0;
					foreach($searchResultContent['departures']['result'] as $row){
						$isPromo = $searchResultContent['departures']['result'][$i]['is_promo'];
						$image = $searchResultContent['departures']['result'][$i]['image'];
						$airlinesName = $searchResultContent['departures']['result'][$i]['airlines_name'];
						$flightNumber = $searchResultContent['departures']['result'][$i]['flight_number'];
						$dprtrTime = $searchResultContent['departures']['result'][$i]['simple_departure_time'];
						$arrvlTime = $searchResultContent['departures']['result'][$i]['simple_arrival_time'];
						$fclty = $searchResultContent['departures']['result'][$i]['stop'];
						$price = $searchResultContent['departures']['result'][$i]['price_value'];
						$html = '<tr>';
						$html .= '<td abbr="'.$airlinesName.'" style="font-size:10px;text-align:center;">
								<div style="border:1px #ccc solid;"><img src="'.$image.'"  width="50" /></div>
								<div>'.$flightNumber.'</div><div>'.$airlinesName.'</div></td>';
						$html .= '<td abbr="'.$dprtrTime.'" style="vertical-align:middle;">
									<div>'.$dprtrTime.'</div>
									<div style="font-size:9px;">'.$dprtArprtCtynCode.'</div>
								  </td>';
						$html .= '<td abbr="'.$arrvlTime.'" style="vertical-align:middle;">
									<div>'.$arrvlTime.'</div>
									<div style="font-size:9px;">'.$arrvlArprtCtynCode.'</div>
								  </td>';						
						$html .= '<td abbr="'.$fclty.'" style="vertical-align:middle;">'.$fclty.'</td>';
						$html .= '<td style="vertical-align:middle;">kg</td>';
						$html .= '<td abbr="'.$price.'" style="vertical-align:middle;"><div style="background: #666; padding: 5px; color: #fff; font-weight: bold;">
									<div style="text-decoration: line-through; text-align: right;">'.$currency.' '.number_format($price).'</div>
									<div style="text-align: right;"><span style="font-size: 24px;text-align: right; ">'.$currency.' '.number_format($price).'</span> &nbsp;/&nbsp; <span style="font-size: 11px;">person</span></div>
									<div style="text-align: right;">TOTAL SAVINGS IDR 50.000</div>
								</div></td>';
						
						$html .= '<td style="vertical-align:middle;"><center><button type="button" class="btn btn-orange"><b>BOOK !</b></button></center></td>';
						$html .= '</tr>';
						echo $html;
					$i++;	
					}
			}
			else{
				echo '<tr><td colspan="7"><center><h2>No Flight Schedule</h2></center></td></tr>';
			}
					
			?>
			</tbody>
		</table>
      	
      	
      
      	</div>
      </div>
</div>
      