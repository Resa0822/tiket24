<div id="hotel-content-info" class="stylebox">
<div style="clear:both;"></div>
<br/>
<?php echo form_open($this->uri->uri_string()); ?>
<?php echo validation_errors(); ?>
<fieldset class="fieldset">
<h1>Payment Setting</h1>
<br>
<table class="form">
<?php if ($message) : ?>
     <div class="valid_box">
        <?php echo $message; ?>
     </div>
<?php endif; ?>
	<tr>
		<td><?php echo form_label('Card Type :', 'CardType'); ?></td>
<!--		<td><?php// echo form_input('CardType', set_value('CardType', $CardType), "size='10'"); ?></td>	-->
		<td><?php echo form_dropdown('CardType', $ar_paymethod, $CardType );?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Card Holder Name :', 'CardHolderName'); ?></td>
		<td><?php echo form_input('CardHolderName', set_value('CardHolderName', $CardHolderName), "size='10'"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Bank Name :', 'BankName'); ?></td>
		<td><?php echo form_input('BankName', set_value('BankName', $BankName), "size='10'"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Card Country Code :', 'CardCountryCode'); ?></td>
<!--		<td><?php //echo form_input('CardCountryCode', set_value('CardCountryCode', $CardCountryCode), "size='10'"); ?></td>	-->
		<td><?php echo form_dropdown('CardCountryCode', $ar_countries, $CardCountryCode );?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Card Number :', 'CardNumber'); ?></td>
		<td><?php echo form_input('CardNumber', set_value('CardNumber', $CardNumber), "size='10'"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Card Security Code :', 'CardSecurityCode'); ?></td>
		<td><?php echo form_input('CardSecurityCode', set_value('CardSecurityCode', $CardSecurityCode), "size='10'"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Card Expiry Date :', 'CardExpiryDate'); ?></td>
		<td><?php echo form_input('CardExpiryDate', set_value('CardExpiryDate', $CardExpiryDate), 'placeholder="Pickup Date" class="datepicker" id="dob" '); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Card Contact Number :', 'CardContactNumber'); ?></td>
		<td><?php echo form_input('CardContactNumber', set_value('CardContactNumber', $CardContactNumber), "size='10'"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Card Address :', 'CardAddress'); ?></td>
		<td><?php echo form_input('CardAddress', set_value('CardAddress', $CardAddress), "size='10'"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Card Address Postal Code :', 'CardAddressPostalCode'); ?></td>
		<td><?php echo form_input('CardAddressPostalCode', set_value('CardAddressPostalCode', $CardAddressPostalCode), "size='10'"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Card Address City :', 'CardAddressCity'); ?></td>
		<td><?php echo form_input('CardAddressCity', set_value('CardAddressCity', $CardAddressCity), "size='10'"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Card Address Country Code :', 'CardAddressCountryCode'); ?></td>
<!--		<td><?php// echo form_input('CardAddressCountryCode', set_value('CardAddressCountryCode', $CardAddressCountryCode), "size='10'"); ?></td>	-->
		<td><?php echo form_dropdown('CardAddressCountryCode', $ar_countries, $CardAddressCountryCode ); ?></td>
	</tr>
</table>
<br>
	<tr class="submit"><?php echo form_submit('submit', 'Submit'); ?></tr>
</fieldset>
	<br><br>
<?php echo form_close(); ?>
</div>
