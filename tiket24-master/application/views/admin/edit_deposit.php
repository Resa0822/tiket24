<?php echo form_open_multipart('deposit/nominal_added_to_balace');?>
<div style="clear:both;"></div>
<div id="hotel-content-info" class="stylebox">
<h2>&nbsp; </h2><!--
 <script type="text/javascript">// <![CDATA[
 $(document).ready(function(){
 $('#roles').change(function(){ //any select change on the dropdown with id roles trigger this code
 $("#names > option").remove(); //first of all clear select items
 var role_id = $('#roles').val(); // here we are taking roles id of the selected one.
 $.ajax({
 type: "POST",
 url: "<?php echo base_url();?>index.php/deposit/names/"+role_id, //here we are calling our user controller and get_names method with the roles_id
 
 success: function(names) //we're calling the response json array 'names'
 {
 $.each(names,function(id,name) //here we're doing a foeach loop round each name with id as the key and name as the value
 {
 var opt = $('<option />'); // here we're creating a new select option with for each name
 opt.val(id);
 opt.text(name);
 $('#names').append(opt); //here we will append these new select options to a dropdown with the id 'names'
 });
 }
 
 });
 
 });
 });
 // ]]>
</script>-->
<fieldset class="fieldset">
<?php 
$dpstID = $this->uri->segment(3);
?>
<input type="hidden" name="dpstID" value="<?php echo $dpstID; ?>" />
<legend class="legend">General Information</legend>
<?php if($this->session->flashdata('flashMsge_warning')){ ?>
<div class="alert alert-warning fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert">
    	<span aria-hidden="true">&times;</span>
    </button>
	<span><?php echo $this->session->flashdata('flashMsge_warning'); ?></span>
</div>
<?php } ?>
<table class="form">  
	<tr class="form-row">
        <td ><strong>Current Balance</strong>	:
            
        </td>
        <td class="field">
            <strong><?php echo 'IDR '.number_format($balance,2); ?></strong>
		</td>
	</tr>	
	<tr><td colspan="2">&nbsp;</td></tr> 
	<tr class="form-row">
        <td >Koreksi No	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="deposit_no" type="text" readonly size="50" value="<?php echo $isi->deposit_no; ?>" name="deposit_no" style="width:30%; height:30%;"></input>
		</td>
	</tr>	
	<tr class="form-row">
		<td >Roles	:	</td>
		<td class="field">
            <input id="roles" type="text" readonly size="50" value="<?php echo $roles[$isi->role_id]; ?>" name="roles" style="width:30%; height:30%;"></input>
		</td>
		<?php echo form_hidden('role_id',$isi->role_id); ?>
		<?php //var_dump($roles);
		/*echo $roles[$isi->role_id].'<br/>'.$isi->role_id;
		if(!empty($roles[$isi->role_id])) {
		$roles['#'] = $roles[$isi->role_id]; }
		else{
		$roles['#'] = 'Please Select';
		}*/
		?>
<!--		<td class="field">
			<?php //echo form_dropdown('roles', $roles, '#', 'id="roles"', 'disabled="disabled"'); ?>
		</td>-->
	</tr>
	<tr class="form-row">
		<td >Name	: 	</td>
		<td class="field">
            <input id="names" type="text" readonly size="50" value="<?php echo $names[$isi->id]; ?>" name="name" style="width:30%; height:30%;"></input>
			<?php echo form_hidden('id',$isi->id)?>
		</td>
		<?php // $names['#'] = $isi->id; 
		//var_dump($names);
		/*echo $names->id_iso.'<br/>'.$isi->id;
		if(!empty($names[$isi->id])) {
		$names['#'] = $names[$isi->id]; }
		else{
	 	$names['#'] = 'Please Select';
	 	}*/?>
<!--		<td class="field">
			<?php //echo form_dropdown('name', $names, '#', 'id="names"'); ?>
		</td> -->
	</tr> 
	<tr class="form-row">
        <td >Nominal to Added	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="deposit_nominal" type="text" title="Enter Point." size="50"  name="deposit_nominal" dir="rtl" style="width:30%; height:30%;"></input>&nbsp(in IDR)
		</td>
	</tr>		
</table>
	<div class="button-container" style="float:right;"><input type="submit" name="Save" value="Save"/>&nbsp;<input type="reset" name="Cancel"/>&nbsp;<input type="button" onClick="history.go(-1)" value="Back" />&nbsp;</div>
</div>
</fieldset>

	<br><br>
<?php echo form_close(); ?>