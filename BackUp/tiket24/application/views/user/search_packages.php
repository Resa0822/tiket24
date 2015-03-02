<script type="text/javascript">

function calculate(){
		var gAdult = document.getElementById("adult").value;
		var gChild = document.getElementById("child").value;

		var kurs = 10000;
		var harga = kurs*<?php echo  $ar_packages->price ?>;
		var charga = kurs*<?php echo  $ar_packages->price_child ?>;
		var tAdult = gAdult*harga;
		var tChild = gChild*charga;
		var total = tAdult + tChild;
		
		var pharga = <?php echo  $ar_packages->price ?>;
		var pcharga = <?php echo  $ar_packages->price_child ?>;
		var tpAdult = gAdult*pharga;
		var tpChild = gChild*pcharga;
		var ptotal = tpAdult + tpChild;
		
		document.getElementById("totalbaru").value = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");;
		document.getElementById("totalprice").value = total.toString();
		document.getElementById("ptotalbaru").value = ptotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");;
		document.getElementById("ptotalprice").value = ptotal.toString();
}


</script>
<style>
.search_package .h2 {
	background: #1e5799; /* Old browsers */
	background: -moz-linear-gradient(top, #1e5799 0%, #2989d8 50%, #207cca 51%, #7db9e8 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#1e5799), color-stop(50%,#2989d8), color-stop(51%,#207cca), color-stop(100%,#7db9e8)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* IE10+ */
	background: linear-gradient(to bottom, #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e5799', endColorstr='#7db9e8',GradientType=0 ); /* IE6-9 */
	
}
.search_package h2{
	margin: 10px;
}
#tourHl{padding:10px;}
#tourHl div{font-size:1px;}
#tourHl div br{line-height:3px}
</style>

<div class="search_package">

<h2> &nbsp; </h2>
	<div id="hotel-content-description"  style="text-align:center;border:10px solid #25497d; margin:auto; padding:35px 35px 35px 35px; border-radius:15px 15px 15px 15px; margin-top: 0px;">
<!-- ================================================================================ -->
<script>
$(document).ready(function(){

 
document.getElementById("txtchildage[0]").disabled = true; 
document.getElementById("txtchildage[1]").disabled = true; 
document.getElementById("txtchildage[2]").disabled = true; 
document.getElementById("txtchildage[3]").disabled = true; 
document.getElementById("txtchildage[4]").disabled = true; 
document.getElementById("txtchildage[5]").disabled = true; 
document.getElementById("txtchildage[6]").disabled = true; 
document.getElementById("txtchildage[7]").disabled = true; 
document.getElementById("txtchildage[8]").disabled = true; 
document.getElementById("txtchildage[9]").disabled = true; 

   
   $('#chldPax').change(function () {
   if($(this).val() == 0){
   $('#cAge_1').css('display','block');
   $('#cAge_2').css('display','none');
   $('#cAge_3').css('display','none');
   $('#cAge_4').css('display','none');
   $('#cAge_5').css('display','none');
   $('#cAge_6').css('display','none');
   $('#cAge_7').css('display','none');
   $('#cAge_8').css('display','none');
   $('#cAge_9').css('display','none');
   $('#cAge_10').css('display','none');
   
   document.getElementById("txtchildage[0]").disabled = true; 
document.getElementById("txtchildage[1]").disabled = true; 
document.getElementById("txtchildage[2]").disabled = true; 
document.getElementById("txtchildage[3]").disabled = true; 
document.getElementById("txtchildage[4]").disabled = true; 
document.getElementById("txtchildage[5]").disabled = true; 
document.getElementById("txtchildage[6]").disabled = true; 
document.getElementById("txtchildage[7]").disabled = true; 
document.getElementById("txtchildage[8]").disabled = true; 
document.getElementById("txtchildage[9]").disabled = true; 

document.getElementById("txtchildage[0]").value = ''; 
document.getElementById("txtchildage[1]").value = ''; 
document.getElementById("txtchildage[2]").value = ''; 
document.getElementById("txtchildage[3]").value = ''; 
document.getElementById("txtchildage[4]").value = ''; 
document.getElementById("txtchildage[5]").value = ''; 
document.getElementById("txtchildage[6]").value = ''; 
document.getElementById("txtchildage[7]").value = ''; 
document.getElementById("txtchildage[8]").value = ''; 
document.getElementById("txtchildage[9]").value = ''; 
   }
   if($(this).val() == 1){
   $('#cAge_1').css('display','block');
   $('#cAge_2').css('display','none');
   $('#cAge_3').css('display','none');
   $('#cAge_4').css('display','none');
   $('#cAge_5').css('display','none');
   $('#cAge_6').css('display','none');
   $('#cAge_7').css('display','none');
   $('#cAge_8').css('display','none');
   $('#cAge_9').css('display','none');
   $('#cAge_10').css('display','none');
   
   document.getElementById("txtchildage[0]").disabled = false; 
document.getElementById("txtchildage[1]").disabled = true; 
document.getElementById("txtchildage[2]").disabled = true; 
document.getElementById("txtchildage[3]").disabled = true; 
document.getElementById("txtchildage[4]").disabled = true; 
document.getElementById("txtchildage[5]").disabled = true; 
document.getElementById("txtchildage[6]").disabled = true; 
document.getElementById("txtchildage[7]").disabled = true; 
document.getElementById("txtchildage[8]").disabled = true; 
document.getElementById("txtchildage[9]").disabled = true; 
   }
   if($(this).val() == 2){
   $('#cAge_1').css('display','block');
   $('#cAge_2').css('display','block');
   $('#cAge_3').css('display','none');
   $('#cAge_4').css('display','none');
   $('#cAge_5').css('display','none');
   $('#cAge_6').css('display','none');
   $('#cAge_7').css('display','none');
   $('#cAge_8').css('display','none');
   $('#cAge_9').css('display','none');
   $('#cAge_10').css('display','none');
   
   document.getElementById("txtchildage[0]").disabled = false; 
document.getElementById("txtchildage[1]").disabled = false; 
document.getElementById("txtchildage[2]").disabled = true; 
document.getElementById("txtchildage[3]").disabled = true; 
document.getElementById("txtchildage[4]").disabled = true; 
document.getElementById("txtchildage[5]").disabled = true; 
document.getElementById("txtchildage[6]").disabled = true; 
document.getElementById("txtchildage[7]").disabled = true; 
document.getElementById("txtchildage[8]").disabled = true; 
document.getElementById("txtchildage[9]").disabled = true; 
   }
   if($(this).val() == 3){
   $('#cAge_1').css('display','block');
   $('#cAge_2').css('display','block');
   $('#cAge_3').css('display','block');
   $('#cAge_4').css('display','none');
   $('#cAge_5').css('display','none');
   $('#cAge_6').css('display','none');
   $('#cAge_7').css('display','none');
   $('#cAge_8').css('display','none');
   $('#cAge_9').css('display','none');
   $('#cAge_10').css('display','none');
   
   document.getElementById("txtchildage[0]").disabled = false; 
document.getElementById("txtchildage[1]").disabled = false; 
document.getElementById("txtchildage[2]").disabled = false; 
document.getElementById("txtchildage[3]").disabled = true; 
document.getElementById("txtchildage[4]").disabled = true; 
document.getElementById("txtchildage[5]").disabled = true; 
document.getElementById("txtchildage[6]").disabled = true; 
document.getElementById("txtchildage[7]").disabled = true; 
document.getElementById("txtchildage[8]").disabled = true; 
document.getElementById("txtchildage[9]").disabled = true; 
   }
   if($(this).val() == 4){
   $('#cAge_1').css('display','block');
   $('#cAge_2').css('display','block');
   $('#cAge_3').css('display','block');
   $('#cAge_4').css('display','block');
   $('#cAge_5').css('display','none');
   $('#cAge_6').css('display','none');
   $('#cAge_7').css('display','none');
   $('#cAge_8').css('display','none');
   $('#cAge_9').css('display','none');
   $('#cAge_10').css('display','none');
   
  document.getElementById("txtchildage[0]").disabled = false; 
document.getElementById("txtchildage[1]").disabled = false; 
document.getElementById("txtchildage[2]").disabled = false; 
document.getElementById("txtchildage[3]").disabled = false; 
document.getElementById("txtchildage[4]").disabled = true; 
document.getElementById("txtchildage[5]").disabled = true; 
document.getElementById("txtchildage[6]").disabled = true; 
document.getElementById("txtchildage[7]").disabled = true; 
document.getElementById("txtchildage[8]").disabled = true; 
document.getElementById("txtchildage[9]").disabled = true; 
   }
   if($(this).val() == 5){
   $('#cAge_1').css('display','block');
   $('#cAge_2').css('display','block');
   $('#cAge_3').css('display','block');
   $('#cAge_4').css('display','block');
   $('#cAge_5').css('display','block');
   $('#cAge_6').css('display','none');
   $('#cAge_7').css('display','none');
   $('#cAge_8').css('display','none');
   $('#cAge_9').css('display','none');
   $('#cAge_10').css('display','none');
   
   document.getElementById("txtchildage[0]").disabled = false; 
document.getElementById("txtchildage[1]").disabled = false; 
document.getElementById("txtchildage[2]").disabled = false; 
document.getElementById("txtchildage[3]").disabled = false; 
document.getElementById("txtchildage[4]").disabled = false; 
document.getElementById("txtchildage[5]").disabled = true; 
document.getElementById("txtchildage[6]").disabled = true; 
document.getElementById("txtchildage[7]").disabled = true; 
document.getElementById("txtchildage[8]").disabled = true; 
document.getElementById("txtchildage[9]").disabled = true; 
   }
   if($(this).val() == 6){
   $('#cAge_1').css('display','block');
   $('#cAge_2').css('display','block');
   $('#cAge_3').css('display','block');
   $('#cAge_4').css('display','block');
   $('#cAge_5').css('display','block');
   $('#cAge_6').css('display','block');
   $('#cAge_7').css('display','none');
   $('#cAge_8').css('display','none');
   $('#cAge_9').css('display','none');
   $('#cAge_10').css('display','none');
   
      
   document.getElementById("txtchildage[0]").disabled = false; 
document.getElementById("txtchildage[1]").disabled = false; 
document.getElementById("txtchildage[2]").disabled = false; 
document.getElementById("txtchildage[3]").disabled = false; 
document.getElementById("txtchildage[4]").disabled = false; 
document.getElementById("txtchildage[5]").disabled = false; 
document.getElementById("txtchildage[6]").disabled = true; 
document.getElementById("txtchildage[7]").disabled = true; 
document.getElementById("txtchildage[8]").disabled = true; 
document.getElementById("txtchildage[9]").disabled = true; 
   }
	if($(this).val() == 7){
   $('#cAge_1').css('display','block');
   $('#cAge_2').css('display','block');
   $('#cAge_3').css('display','block');
   $('#cAge_4').css('display','block');
   $('#cAge_5').css('display','block');
   $('#cAge_6').css('display','block');
   $('#cAge_7').css('display','block');
   $('#cAge_8').css('display','none');
   $('#cAge_9').css('display','none');
   $('#cAge_10').css('display','none');
   
      
   document.getElementById("txtchildage[0]").disabled = false; 
document.getElementById("txtchildage[1]").disabled = false; 
document.getElementById("txtchildage[2]").disabled = false; 
document.getElementById("txtchildage[3]").disabled = false; 
document.getElementById("txtchildage[4]").disabled = false; 
document.getElementById("txtchildage[5]").disabled = false; 
document.getElementById("txtchildage[6]").disabled = false; 
document.getElementById("txtchildage[7]").disabled = true; 
document.getElementById("txtchildage[8]").disabled = true; 
document.getElementById("txtchildage[9]").disabled = true; 
   }
   if($(this).val() == 8){
   $('#cAge_1').css('display','block');
   $('#cAge_2').css('display','block');
   $('#cAge_3').css('display','block');
   $('#cAge_4').css('display','block');
   $('#cAge_5').css('display','block');
   $('#cAge_6').css('display','block');
   $('#cAge_7').css('display','block');
   $('#cAge_8').css('display','block');
   $('#cAge_9').css('display','none');
   $('#cAge_10').css('display','none');
   
      
   document.getElementById("txtchildage[0]").disabled = false; 
document.getElementById("txtchildage[1]").disabled = false; 
document.getElementById("txtchildage[2]").disabled = false; 
document.getElementById("txtchildage[3]").disabled = false; 
document.getElementById("txtchildage[4]").disabled = false; 
document.getElementById("txtchildage[5]").disabled = false; 
document.getElementById("txtchildage[6]").disabled = false; 
document.getElementById("txtchildage[7]").disabled = false; 
document.getElementById("txtchildage[8]").disabled = true; 
document.getElementById("txtchildage[9]").disabled = true; 
   }
   if($(this).val() == 9){
   $('#cAge_1').css('display','block');
   $('#cAge_2').css('display','block');
   $('#cAge_3').css('display','block');
   $('#cAge_4').css('display','block');
   $('#cAge_5').css('display','block');
   $('#cAge_6').css('display','block');
   $('#cAge_7').css('display','block');
   $('#cAge_8').css('display','block');
   $('#cAge_9').css('display','block');
   $('#cAge_10').css('display','none');
   
      
   document.getElementById("txtchildage[0]").disabled = false; 
document.getElementById("txtchildage[1]").disabled = false; 
document.getElementById("txtchildage[2]").disabled = false; 
document.getElementById("txtchildage[3]").disabled = false; 
document.getElementById("txtchildage[4]").disabled = false; 
document.getElementById("txtchildage[5]").disabled = false; 
document.getElementById("txtchildage[6]").disabled = false; 
document.getElementById("txtchildage[7]").disabled = false; 
document.getElementById("txtchildage[8]").disabled = false; 
document.getElementById("txtchildage[9]").disabled = true; 
   }
    if($(this).val() == 10){
   $('#cAge_1').css('display','block');
   $('#cAge_2').css('display','block');
   $('#cAge_3').css('display','block');
   $('#cAge_4').css('display','block');
   $('#cAge_5').css('display','block');
   $('#cAge_6').css('display','block');
   $('#cAge_7').css('display','block');
   $('#cAge_8').css('display','block');
   $('#cAge_9').css('display','block');
   $('#cAge_10').css('display','block');
   
     
   document.getElementById("txtchildage[0]").disabled = false; 
document.getElementById("txtchildage[1]").disabled = false; 
document.getElementById("txtchildage[2]").disabled = false; 
document.getElementById("txtchildage[3]").disabled = false; 
document.getElementById("txtchildage[4]").disabled = false; 
document.getElementById("txtchildage[5]").disabled = false; 
document.getElementById("txtchildage[6]").disabled = false; 
document.getElementById("txtchildage[7]").disabled = false; 
document.getElementById("txtchildage[8]").disabled = false; 
document.getElementById("txtchildage[9]").disabled = false; 
   }
        
	
});


   
   

    //if ($(this).val() === '2') {
    /*var $newDiv = $("<div>Input Box: </div>");
    var $newInput = $("<input type='text'>");
    $newInput
      .attr("name", "fieldName" + counter)
      .addClass("text");
    $newInput.appendTo($newDiv);
	$newDiv.appendTo($("#gnrtdTxbx"));*/
	
	//var $newDiv = $("<div>DUa </div>");
    //$newDiv.appendTo($("#gnrtdTxbx"));
    //}
   
    
  $('#tourDate').datepicker({ dateFormat: 'yy-mm-dd' }); 
});
</script>
<?php
$apiPackagesId = $ar_packages->API_packages_id;
$qry = $this->db->query("select * from tours where API_packages_id='$apiPackagesId' ");
$data= $qry->row(); 
$childAgeFrom = $data->child_age_from;
$childAgeTo = $data->child_age_to;
$bookingBeginPeriod = substr($ar_packages->booking_begin, 0, 10); 
$bookingEndPeriod = substr($ar_packages->booking_end, 0, 10); 
$travelBeginPeriod = substr($ar_packages->periode_begin, 0, 10); 
$travelEndPeriod = substr($ar_packages->periode_end, 0, 10); 
$bpBegin = date("d M Y", strtotime($bookingBeginPeriod));
$bpEnd = date("d M Y", strtotime($bookingEndPeriod));
$tpBegin = date("d M Y", strtotime($travelBeginPeriod));
$tpEnd = date("d M Y", strtotime($travelEndPeriod));
?>	
<!--<script type="text/javascript" src="<?=base_url()?>asset/js/jquery-1.10.2.js"></script>-->
<script>
$(document).ready(function(){

$('#chkPrice').click(function() {

var adult = $("#adltPax").find(":selected").val();	
var child = $("#chldPax").find(":selected").val();	
var childAge = $('input:text.childAge').serializeArray();
var tourdate = $("#tourDate").val();	
var packageId = <?php echo $ar_packages->API_packages_id; ?>;

	   $('#formBookingContainer').show();
		$.ajax({   
	           url: "<?=base_url()?>index.php/ajaxHandler/displayCheckprice_booking_form", 
	           async: false,
	           type: "POST", 
	           data: {"packageID": packageId,"adult": adult, "child": child, "childage": childAge, "travDate":tourdate}, 
	           dataType: "html", 
	           beforeSend: function () {
				 
	                        $("#formBookingContainer").html('<div align="center"><img src="<?=base_url()?>asset/images/icon/ajax-loader.gif" style="display: block; margin-left: auto; margin-right: auto;width:30px" />wait...</div>');
	                        },
	                      
	          success: function(data) {
	                        
	                            $('#formBookingContainer').fadeOut('fast').html(data).fadeIn('slow')
								
	                    }
	     })

});

	$('#bookThisPackage').click(function() {
		var adultPax = $("#adltPax option:selected").val();
		var childPax = $("#chldPax option:selected").val();
		var tourDate = $('input[name="tourDate"]').val();
		var childAge = $('input[name^="txtchildage"]').serializeArray();
		var pckgId = <?php echo $ar_packages->API_packages_id; ?>;
		
		if((adultPax !== 0 && childPax == 0 && childAge == '' && tourDate !== "") || (adultPax !== 0 && childPax !== 0 && childAge !== '' && tourDate !== "")){
			if((adultPax == 0 && childPax == 1 || (adultPax == 1 && childPax == 0))){
				$('#errMsgs').show('slow').html('<div style="color:rgb(255,0,0);font-weight:bold;padding:5px;background:rgb(255,205,248);width:inherit;">Minimum booking is 2 pax</div>');
			}
			else{
				$.ajax({   
           		url: "<?=base_url()?>index.php/ajaxHandler/bookingPackage", 
           		type: "POST", 
           		data: {"packageID": pckgId,"adult": adultPax, "child": childPax, "childage": childAge, "travDate":tourDate}, 
           		dataType: "html", 
           		beforeSend: function () {
			 
                            $("#bookThisPackage").hide('slow');
                           
                            $("#bookThisPackage").before('<img src="<?=base_url()?>asset/images/icon/ajax-loader.gif" style="display: block; margin-left: auto; margin-right: auto;width:30px" />wait..');
                        },
               success: function(data) {
                        
                           $("#bookThisPackage").val('Book Package');
                           $("body").html(data);
							
                    }
          		
     			})
	 
			}
			
		}
		else{
			$('#errMsgs').show('slow').html('<div style="color:rgb(255,0,0);font-weight:bold;padding:5px;background:rgb(255,205,248);width:inherit;">Please fill all form correctly</div>');
		}
	});

});
</script>
<!--<form action="<?php echo base_url();?>index.php/transaction/searchPackages/" method="post" >-->
<form>
<input type="hidden" name="activityId" id="activityId" value="<?php echo $ar_packages->API_packages_id; ?>" />
<table align="center" colspan="0" rowspan="0" >
<tr>
	<td colspan="2" style="padding-left: 20px;"><div><h4><?php echo $ar_packages->nama; ?></h4></div></td>
</tr>	
<tr>
	<td style="width: 200px;vertical-align: top; text-align: center; padding: 0px 10px 0px 10px;">
		<div style="width: 250px; height: 150px; position: relative;">
			<div style="width: 100%;height: 20px; position: absolute; bottom: -50px; left: 0;z-index: 10; background-color: rgba(0,0,0,0.7); color:#fff; padding: 5px 0px 5px 0px; font-size:12px;">Package Code <b><?php echo $ar_packages->API_packages_refno; ?></b></div>
			<div style="width: 100%; height: 100%; position: absolute; top: 0;left: 0;"><img src="<?php echo $ar_packages->gambar; ?>" style="height: 200px; width: 250px; z-index: 0;" /></div>
			
		</div>
		
		<br /><br /><br /><br />
		<div><input type="button" name="bookThisPackage" id="bookThisPackage" value="Book Package" /></div>
	</td>
	<td style="width: 600px;">
		<div id="errMsgs" style="text-align: center; display: none;"></div>
		<div>
			<table cellpadding="0" cellspacing="0" border="0" >
			<tr>
				<td style="padding:5px;font-weight: bold;font-size: 12px;">Adults</td>
				<td style="padding:5px;font-weight: bold;font-size: 12px;">Child(<?php echo $childAgeFrom.' - '.$childAgeTo.' Years old' ?>)</td>
				<td style="padding:5px;font-weight: bold;font-size: 12px;">Tour Date</td>
				<td style="padding:5px; vertical-align: top;">&nbsp;</td>
			</tr>
			<tr>
				<td style="vertical-align: top;padding:5px;" ><select name="adltPax" id="adltPax" style="width:50px;" ><?php	for($i=1;$i<=50;$i++){	echo '<option value="'.$i.'">'.$i.'</option>';	}?>	</select></td>
				<td style="vertical-align: top;padding:5px;" >
					<div style="display:inline-block;vertical-align:top;">
					<select name="chldPax" id="chldPax" style="width:50px;" >
						<?php
						for($i=0;$i<=10;$i++){
							
								echo '<option value="'.$i.'">'.$i.'</option>';
							
						}
						?>			
					</select>
					</div>
				<div style="display:inline-block;font-size: 12px">
					<div id="cAge_1" >&nbsp;&nbsp;Age&nbsp;&nbsp;
					<input type="text" id="txtchildage[0]" class="childAge" name="txtchildage[0]" value="" style="width:40px"  /></div>
					<div id="cAge_2" style="display:none;"  >&nbsp;&nbsp;Age&nbsp;&nbsp;
					<input type="text" id="txtchildage[1]" class="childAge" name="txtchildage[1]" value="" style="width:40px"  /></div>
					<div id="cAge_3" style="display:none;" >&nbsp;&nbsp;Age&nbsp;&nbsp;
					<input type="text" id="txtchildage[2]" class="childAge" name="txtchildage[2]" value="" style="width:40px"  /></div>
					<div id="cAge_4" style="display:none;" >&nbsp;&nbsp;Age&nbsp;&nbsp;
					<input type="text" id="txtchildage[3]" class="childAge" name="txtchildage[3]" value="" style="width:40px"  /></div>
					<div id="cAge_5" style="display:none;" >&nbsp;&nbsp;Age&nbsp;&nbsp;
					<input type="text" id="txtchildage[4]" class="childAge" name="txtchildage[4]" value="" style="width:40px"  /></div>
					<div id="cAge_6" style="display:none;" >&nbsp;&nbsp;Age&nbsp;&nbsp;
					<input type="text" id="txtchildage[5]" class="childAge" name="txtchildage[5]" value="" style="width:40px"  /></div>
					<div id="cAge_7" style="display:none;" >&nbsp;&nbsp;Age&nbsp;&nbsp;
					<input type="text" id="txtchildage[6]" class="childAge" name="txtchildage[6]" value="" style="width:40px"  /></div>
					<div id="cAge_8" style="display:none;" >&nbsp;&nbsp;Age&nbsp;&nbsp;
					<input type="text" id="txtchildage[7]" class="childAge" name="txtchildage[7]" value="" style="width:40px"  /></div>
					<div id="cAge_9" style="display:none;" >&nbsp;&nbsp;Age&nbsp;&nbsp;
					<input type="text" id="txtchildage[8]" class="childAge" name="txtchildage[8]" value="" style="width:40px"  /></div>
					<div id="cAge_10" style="display:none;" >&nbsp;&nbsp;Age&nbsp;&nbsp;
					<input type="text" id="txtchildage[9]" class="childAge" name="txtchildage[9]" value="" style="width:40px"  /></div>
				</div>
				</td>
				<td style="vertical-align: top;padding:5px;">
					<input type="text" id="tourDate" name="tourDate" value="" placeholder="Tour Date" style="width:100px;"  />	
				</td>
				<td style="vertical-align: top;padding:5px;"><input type="button" name="chkPrice" id="chkPrice" value="Check Price" /></td>
			</tr>
		</table>
		</div>
		<div style="padding: 5px;">
			<div style="font-weight: bold; text-decoration: underline;">Booking Period : </div>
			<div><?php echo $bpBegin; ?> <b>-</b> <?php echo $bpEnd; ?></div>
		</div>
		<div style="padding: 5px;">
			<div style="font-weight: bold; text-decoration: underline;">Travel Period : </div>
			<div><?php echo $tpBegin; ?> <b>-</b> <?php echo $tpEnd; ?></div>
		</div>
		<div style="padding: 5px;">
			<div style="font-weight: bold; text-decoration: underline;">Package Inclusive : </div>
			<div><?php echo $ar_packages->ket; ?></div>
		</div>

		<div id="formBookingContainer" style="border:1px #CCCCCC solid; background: #66CCFF; display:none;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;">&nbsp;</div>
		
		
	</td>
</tr>

</table>
</form>

<table>
	<tr>
		<td><h4>Tour Highlights</h4></td>
	</tr>
	<tr>
		<td>
	<?php
	$apiPackagesId = $ar_packages->API_packages_id;
	$qryHighlight = $this->db->query("SELECT * FROM tours WHERE API_packages_id='$apiPackagesId' ");
	foreach ($qryHighlight->result() as $row)
	{
		$tourID = $row->tour_id;
		$qryHL= mysql_query("SELECT * FROM tour_info WHERE tour_id='$tourID' ");
		$pckgHL = mysql_fetch_array($qryHL);
		   
		     
	?>
	
			<table cellpadding="0" cellspacing="0" border="0" width="100%" >
				<tr>
					<td colspan="2" style="background: #B0C4DE;padding-left:10px;"><h5><?php echo $row->tour_name; ?></h5></td>
				</tr>
				<tr>
					<td style="vertical-align: top;background: #7FFFD4"><img src="<?php echo $row->image_path; ?>" style="width: 100px;" /></td>
					<td style="background: #7FFFD4">
						<div id="tourHl"><?php echo $pckgHL['tour_highlights']; ?></div>
					</td>
				</tr>
			</table>
			
			<?php
			if($row->pickup_time !== NULL AND $row->tour_start_time !== NULL AND $row->duration){
			$pickUpTime = explode('/',$row->pickup_time);
			$startTime = explode('/',$row->tour_start_time);	
			
			?>
		    <table cellpadding="0" cellspacing="0" border="0" width="100%" >
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td style="vertical-align: top;background: #7FFFD4;width: 120px;">&nbsp;</td>
					<td style="background: #7FFFD4">
						<div>Pickup Time : <?php echo $pickUpTime[0]; ?></div>
						<div>Tour Start Time : <?php echo $startTime[0]; ?></div>
						<div>Duration : <?php echo $row->duration; ?></div>
					</td>
				</tr>
				
			</table>
	       
	<?php
			}
		
	}
	
	?>
	</td>
	</tr>
	
	
</table>

<!-- ================================================================================ -->	
<!--
		<form name="formpay" action="<?php echo base_url();?>index.php/transaction/save_Tguest/" method="post" />
<div class="editable-input" >


<table border="0" width=100% >

	<tr class="h2">
		<td colspan="6" ><h2>Packages Information</h2></td>
		<input type="hidden" id="txtid" name="txtid" value="<?php echo $ar_packages->packages_id; ?>" />
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;Packages Name</td>
		<td>&nbsp;:&nbsp;</td>
		<td style="padding-top: 10px;"><input type="text" id="txtname" name="txtname" value="<?php echo $ar_packages->nama; ?>" style="width:60%" disabled /></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;Packages</td>
		<td>&nbsp;:&nbsp;</td>
		<td style="padding-top: 10px;"><input type="text" id="txtpackage" name="txtpackage" value="<?php echo $ar_packages->package; ?>" style="width:60%" disabled /></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;Price</td>
		<td>&nbsp;:&nbsp;</td>
		<td style="padding-top: 10px;"><input type="text" id="txtprice1" name="txtprice1" value="<?php echo number_format($ar_packages->price); ?>" style="width:60%" disabled />
		<input type="hidden" id="txtprice" name="txtprice" value="<?php echo $ar_packages->price; ?>" /></td>
	</tr>
	<tr>
		<td style="padding-top:10px;">&nbsp;&nbsp;&nbsp;Adult&nbsp;:&nbsp;
		<select name="adult" id="adult" onChange="calculate()" style="width:100px;" >
			<option value="0">Select</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
		</select></td>
		<td>&nbsp;</td>
		<td style="padding-top:10px;">
		Child &nbsp;:&nbsp;
		<select name="child" id="child" onChange="calculate()" style="width:100px;" >
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;Date <span class="required">*</span></td>
		<td>:</td>
		<td><input type="text" placeholder="Pickup Date" class="datepicker" id="from" font_end_label="Details" title="Enter a News." rows="15" cols="60" name="tanggal" style="height:30%;" /></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;Total Price</td>
		<td>&nbsp;:&nbsp;</td>
		<td><input type="hidden" id="ptotal" name="ptotal" value="" /> <h4><?php echo $ar_packages->currency; ?>
			<input type="text" id="ptotalbaru" name="ptotalbaru" value="" style="border:0; background:none; font-weight:bold;" disabled /> </h4></td>
			<input type="hidden" id="ptotalprice" name="ptotalprice" value="" style="border:0; background:none; font-weight:bold;"  /> 
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;Currency Estimation</td>
		<td>&nbsp;:&nbsp;</td>
		<td><input type="hidden" id="total" name="total" value="" /> <h4>IDR 
			<input type="text" id="totalbaru" name="totalbaru" value="" style="border:0; background:none; font-weight:bold;" disabled /> </h4></td>
			<input type="hidden" id="totalprice" name="totalprice" value="" style="border:0; background:none; font-weight:bold;"  /> 
	</tr>
	<tr>
		<td colspan=4><input type="button" name="back" style="float: right;margin-right:10px;" value="Back" onClick="history.go(-1)" /><input type="submit" name="continue" style="float: right;margin-right:10px;" value="Continue" /></td>
	</tr>
</table>
</div>
<br/>
		</form>	
	-->
<div style="clear:both"/>
	</div>
</div>

<br /><br />