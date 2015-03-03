<html>
<title>Tiket24</title>
<head>
<!--<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" /> -->
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>asset/slider/responsiveslides.css">
<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>asset/js/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>asset/js/bootstrap/css/bootstrap-responsive.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>asset/css/PackageBaseBody.CMS.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>asset/css/main.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>asset/css/hover_detail.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>asset/css/packages.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>asset/css/kendo.uniform.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>asset/css/kendo.common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>asset/css/3d-corner-ribbons.css" />
<script src="<?php echo base_url();?>asset/js/jquery-1.8.2.min.js"></script>
<script src="<?php echo base_url();?>asset/js/bootstrap/js/bootstrap.min.js"></script>
<!--<script src="<?php echo $this->config->base_url(); ?>asset/slider/jquery.min.js"></script>-->
<script src="<?php echo $this->config->base_url(); ?>asset/slider/responsiveslides.min.js"></script>
<!-- menu top -->
<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
<link rel='stylesheet' type='text/css' href='<?php echo $this->config->base_url(); ?>asset/css/styles.css' />
<script type='text/javascript' src='<?php echo $this->config->base_url(); ?>asset/js/menu_jquery.js'></script>
<!--
<script src="<?php //echo $this->config->base_url(); ?>jqueryCalendar/jquery-1.6.2.min.js"></script>
<script src="<?php //echo $this->config->base_url(); ?>jqueryCalendar/jquery-ui-1.8.15.custom.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>jqueryCalendar/jquery/jqueryCalendar.css">
<script>
                jQuery(function() {
                                jQuery( "#inf_custom_RemovalDate" ).datepicker();
                });
                </script> 
				
		<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>asset/css/jquery-ui.css">
		<script src="<?php echo $this->config->base_url(); ?>asset/js/jquery-1.10.2.js"></script>
		<script src="<?php echo $this->config->base_url(); ?>asset/js/jquery-ui.js"></script>
		-->
		<link href="<?php echo $this->config->base_url(); ?>asset/css/jquery-ui-1.10.4.custom.css" rel="stylesheet">
		<script src="<?php echo $this->config->base_url(); ?>asset/js/jquery-ui-1.10.4.custom.js"></script>
		
		<script>
		$(function() {
		$( "#from" ).datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
		$( "#to" ).datepicker( "option", "minDate", selectedDate );
		}
		});
		$( "#to" ).datepicker({
		dateFormat: "yy-mm-dd",
		appendText: "(yyyy-mm-dd)",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
		$( "#from" ).datepicker( "option", "maxDate", selectedDate );
		}
		});
		});
		
		
		$(function() {
		var today = new Date();
		var yyyy = today.getFullYear();
		$( "#dob" ).datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+1w", 
		changeMonth: true,
		changeYear: true,
		yearRange: '1910:yyyy',
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
		$( "#to" ).datepicker( "option", "minDate", selectedDate );
		}
		});
		
		});
		</script>
<!--
	<link rel="stylesheet" type="text/css" href="../../asset/datepicker/dhtmlxcalendar.css">
	<link rel="stylesheet" type="text/css" href="../../asset/datepicker/skins/dhtmlxcalendar_dhx_skyblue.css">
	<script src="../../asset/datepicker/dhtmlxcalendar.js"></script>
	<style>
		input#date_from, input#date_to {
			font-family: Tahoma;
			font-size: 12px;
			background-color: #fafafa;
			border: #c0c0c0 1px solid;
			width: 100px;
		}
		span.label {
			font-family: Tahoma;
			font-size: 12px;
		}
	</style>
	<script>
		var myCalendar;
		function doOnLoad() {
			myCalendar = new dhtmlXCalendarObject(["date_from","date_to"]);
			myCalendar.setDate("2013-03-10");
			myCalendar.hideTime();
			// init values
			var t = new Date();
			byId("date_from").value = "2013-03-05";
			byId("date_to").value = "2013-03-15";
		}
		
		function setSens(id, k) {
			// update range
			if (k == "min") {
				myCalendar.setSensitiveRange(byId(id).value, null);
			} else {
				myCalendar.setSensitiveRange(null, byId(id).value);
			}
		}
		function byId(id) {
			return document.getElementById(id);
		}
	</script>
-->

<!--
<link rel="stylesheet" type="text/css" href="<?php //echo $this->config->base_url(); ?>asset/css/jquery.ui.all.css">
<script src="<?php //echo $this->config->base_url(); ?>asset/js/datepicker/jquery-1.10.2.js"></script>
<script src="<?php //echo $this->config->base_url(); ?>asset/js/datepicker/jquery.ui.core.js"></script>
<script src="<?php //echo $this->config->base_url(); ?>asset/js/datepicker/jquery.ui.widget.js"></script>
<script src="<?php //echo $this->config->base_url(); ?>asset/js/datepicker/jquery.ui.datepicker.js"></script>	

	<script>
	$(function() {
		$( "#from" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
	</script>
-->
</head>
<body>
<div class="wrapper">
<?php
echo '<div>';
	$this->load->view('header');
//	echo '<div style="clear:both;"></div>';
echo '</div>';

	$this->load->view($pagecontent);

	$this->load->view('footer'); 
?>
</div>
</body>
</html>