<script>
$(document).ready(function(){
  $('#attractionSearch').attr('disabled', 'disabled');
  $('#byPrice').attr('checked', 'checked');
  var slctdRadio = $('input[name=searchFilter]:radio:checked').val();
  $("input[name=searchFilter]:radio").click(function(){
    if($('input[name=searchFilter]:radio:checked').val() == "byPrice"){
        
        $('#priceRangeSearch').prop('disabled', false);
        $('#attractionSearch').attr('disabled', 'disabled');
    }
    else{
    	
    	$('#priceRangeSearch').attr('disabled', 'disabled');
    	$('#attractionSearch').prop('disabled', false);
    }
});

$("#logo_image").click(function(){
 window.location.assign("http://tiket24.co.id")
});

});
</script>

<style>
.box_shadow{
	-webkit-box-shadow: 3px 3px 26px 0px rgba(0,0,0,0.75);
-moz-box-shadow: 3px 3px 26px 0px rgba(0,0,0,0.75);
box-shadow: 3px 3px 26px 0px rgba(0,0,0,0.75);
}	
</style>
<?php if($this->session->flashdata('search_warning_message')){ ?>
<div class="alert alert-danger alert-dismissible box_shadow" role="alert" style="position:relative;top:0px; z-index: 1000; width:inherit;">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
	<?php echo $this->session->flashdata('search_warning_message'); ?>
</div>
<?php } ?>

<div class="header">
	
	<div id="Logo">
		<div id="logo_image" style="z-index:5000;position:relative;cursor:pointer;" title="Tiket24"></div>
		<div id="logo_slider" >
		
			<div>
				<div style="width:100%; height:100%; background:url('<?php echo $this->config->base_url(); ?>asset/theme/img_head.png'); background-size:100% 100%; *behavior: url(../asset/css/PIE.htc);"></div>
				
		
			</div>
		</div>
		<!-- search form start -->
		<!--
		<div style="clear: both;"></div>
		<div>
			<form action="<?php echo base_url().'index.php/search'; ?>" method="post" >
			<table class="pull-right" style="margin-right: 10px;">
				<tr>
					<td style="padding-left: 10px;padding-right: 10px;"><label><input type="radio" name="searchFilter" id="byPrice" value="byPrice" /> by Price (SGD)</label></td>
					<td style="padding-left: 10px;padding-right: 10px;">
						<select name="priceRangeSearch" id="priceRangeSearch" class="form-control" >
			      			<option value="">- price range -</option>
			      			<option value="<100"> 0 - 100 </option>
			      			<option value="100>300"> 100 - 300 </option>
			      			<option value=">300"> > 300 </option>
			      		</select>
			      	</td>
					<td style="padding-left: 10px;padding-right: 10px;"><label><input type="radio" name="searchFilter" id="byAttraction" value="byAttraction" /> by Attraction</label></td>
					<td><input type="text" name="attractionSearch" id="attractionSearch" placeholder="Search by attraction" ></td>
					<td style="vertical-align: middle; padding-bottom: 10px; padding-left: 10px;"><input type="submit" value="Search" /></td>
				</tr>
			</table>
			</form>
		</div>
    	<div style="clear: both;"></div>
    -->
    	<!-- search form end -->
    	<div id="user_menu" style="text-align:right;">
					<?php echo $this->load->view('top_menu');?>
		</div>
		<div id="parent_menu">
			<?php echo $this->load->view('menu');?>
		</div>
		
		<div>
				<div id="search_head_red">&nbsp;</div>
				<div id="search_head_black" >
					<center>
						<form action="<?php echo base_url().'index.php/search'; ?>" method="post" style="margin-top:20px;">
									
									<input type="radio" name="srchFilter" id="isRegular" value="regular" checked="checked" >&nbsp;Regular
									&nbsp;<input type="radio" name="srchFilter" id="isPromo" value="promo">&nbsp;Promo
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Search :&nbsp;
									<input type="text" name="txtSearch" id="txtSearch" placeholder="Search" >
									&nbsp;&nbsp;&nbsp;<input type="submit" name="searchNow" value="Search Now" id="btn_sAvailability" style="margin-bottom: 5px;" >
							</form>
					</center>
				</div>
				<!-- <img src="<?php //echo $this->config->base_url(); ?>asset/theme/Search.gif"> -->
		</div>
	</div>
</div>