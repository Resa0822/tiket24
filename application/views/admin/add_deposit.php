<div style="clear:both;"></div>
<?php echo form_open_multipart('deposit/add_deposit');?>
<div id="hotel-content-info" class="stylebox">
<h2>&nbsp; </h2>
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
</script>
<fieldset class="fieldset">
<legend class="legend">General Information</legend>
<table class="form">   
	<tr class="form-row">
		<td >Roles	:	</td>
		<?php $roles['#'] = 'Please Select'; ?>
		<td class="field">
			<?php echo form_input('role_id', $roles[3], ' readonly id="role_id" '); ?>
			<?php echo form_hidden('roles', 3, ' id="roles" '); ?>
		</td>
	</tr>
	<tr class="form-row">
		<td >Name	: 	</td>
		 <?php $names['#'] = 'Please Select'; ?>
		<td class="field">
			<?php echo form_dropdown('name', $names, '#', 'id="names"'); ?>
		</td>
	</tr> 
	<tr class="form-row">
        <td >Deposit Nominal	:
            <span class="required">*</span>
        </td>
        <td class="field">
            <input id="deposit_nominal" type="text" title="Enter Point." size="50" value="" name="deposit_nominal" dir="rtl" style="width:30%; height:30%;"></input>
		</td>
	</tr>		
</table>
	<div class="button-container" style="float:right;"><input type="submit" name="Save" value="Save"/>&nbsp;<input type="reset" name="Cancel"/>&nbsp;<input type="button" onClick="history.go(-1)" value="Back" />&nbsp;</div>
</div>
</fieldset>
	<br><br>
<?php echo form_close(); ?>