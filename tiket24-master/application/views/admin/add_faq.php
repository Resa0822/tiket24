<?php if($this->session->userdata('role_id','1')){ //if session is created then login to members page
 echo form_open_multipart('faq/add_faq');?>
<div id="hotel-content-info" class="stylebox">
<h2>&nbsp; </h2>
<fieldset class="fieldset">
<legend class="legend">FAQ</legend>
<table class="form">   
	<tr class="form-row">
        <td >Questions	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <textarea id="pertanyaan" font_end_label="Details" title="Enter a News." rows="5" name="pertanyaan" style="width: 100%;"></textarea>
		</td>
	</tr>
	<tr class="form-row">
        <td >Answer	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <textarea id="jawaban" font_end_label="Details" title="Enter a News." rows="5" name="jawaban" style="width: 100%;"></textarea>
		</td>
	</tr>	
</table>
	<div class="button-container" style="float:right;"><input type="submit" name="Save" value="Save"/>&nbsp;<input type="reset" name="Cancel"/>&nbsp;<input type="button" onClick="history.go(-1)" value="Back" />&nbsp;</div>
</div>
</fieldset>
	<br><br>
<?php echo form_close(); ?>
<?php
} else {
			echo "<META http-equiv='refresh' content='3;URL=".base_url()."'>";
			echo "<fieldset><br /><center><h1>404 Page Not Found</h1><br/><br/><h2>The page you requested is not found</h2></center><br/></<fieldset>>";
			//redirect('starholiday/home');
		}	?>
		

