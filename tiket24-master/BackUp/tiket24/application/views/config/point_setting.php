<div id="hotel-content-info" class="stylebox">
<div style="clear:both;"></div>
<br/>
<?php echo form_open($this->uri->uri_string()); ?>
<?php echo validation_errors(); ?>
<fieldset class="fieldset">
<h1>Point Setting</h1>

<?php if ($message) : ?>
     <div class="valid_box">
        <?php echo $message; ?>
     </div>
<?php endif; ?>
<table class="form">
<br>
<b>Member Point</b>
<tr><td colspan="3"><hr></hr></td></tr>
	<?php echo form_hidden('role_id',2); ?>
	<tr>
		<td><?php echo form_label('Minimal Beli :', 'MinimalBeli'); ?></td>
		<td><?php echo 'Rp.'.form_input('MinimalBeli', set_value('MinimalBeli', number_format($MinimalBeli, 2, ',', '.')), "size='10' dir='rtl' style='width:40%'"); ?></td>
<!--		<td><?php //echo form_dropdown('MinimalBeli', $ar_paymethod, $MinimalBeli );?></td>	-->
	</tr>
	<tr>
		<td><?php echo form_label('Nominal Beli :', 'NominalBeli'); ?></td>
		<td><?php echo 'Rp.'.form_input('NominalBeli', set_value('NominalBeli', number_format($NominalBeli, 2, ',', '.')), "size='10' dir='rtl' style='width:40%'"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Point Beli :', 'PointBeli'); ?></td>
		<td><?php echo form_input('PointBeli', set_value('PointBeli', $PointBeli), "size='5' style=width:45%"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Minimal Point :', 'MinimalPoint'); ?></td>
		<td><?php echo form_input('MinimalPoint', set_value('MinimalPoint', $MinimalPoint), "size='10' style=width:40%"); ?></td>	
<!--		<td><?php //echo form_dropdown('MinimalPoint', $ar_countries, $MinimalPoint );?></td> -->
	</tr>
	<tr>
		<td><?php echo form_label('Point Tukar :', 'PointTukar'); ?></td>
		<td><?php echo form_input('PointTukar', set_value('PointTukar', $PointTukar), "size='5' style=width:40%"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('NominalBayar :', 'NominalBayar'); ?></td>
		<td><?php echo 'Rp.'.form_input('NominalBayar', set_value('NominalBayar', number_format($NominalBayar, 2, ',', '.')), "size='10' dir='rtl' style=width:40%"); ?></td>
	</tr>
</table>
<table class="form">
<br/>
<b>Reseller Point</b>
<tr><td colspan="3"><hr></hr></td></tr>
	<?php echo form_hidden('role_id',3); ?>
	<tr>
		<td style="width:42%"><?php echo form_label('Minimal Beli Reseller :', 'MinimalBeliReseller'); ?></td>
		<td><?php echo 'Rp.'.form_input('MinimalBeliReseller', set_value('MinimalBeliReseller', number_format($MinimalBeliReseller, 2, ',', '.')), "size='10' dir='rtl' style=width:40%"); ?></td>
<!--		<td><?php //echo form_dropdown('MinimalBeli', $ar_paymethod, $MinimalBeli );?></td>	-->
	</tr>
	<tr>
		<td><?php echo form_label('Nominal Beli Reseller :', 'NominalBeliReseller'); ?></td>
		<td><?php echo 'Rp.'.form_input('NominalBeliReseller', set_value('NominalBeliReseller', number_format($NominalBeliReseller, 2, ',', '.')), "size='10' dir='rtl' style=width:40%"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Point Beli Reseller :', 'PointBeliReseller'); ?></td>
		<td><?php echo form_input('PointBeliReseller', set_value('PointBeliReseller', $PointBeliReseller), "size='5' width='10%' style=width:40%"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Minimal Point Reseller :', 'MinimalPointReseller'); ?></td>
		<td><?php echo form_input('MinimalPointReseller', set_value('MinimalPointReseller', $MinimalPointReseller), "size='10' style=width:40%"); ?></td>	
<!--		<td><?php //echo form_dropdown('MinimalPoint', $ar_countries, $MinimalPoint );?></td> -->
	</tr>
	<tr>
		<td><?php echo form_label('Point Tukar Reseller :', 'PointTukarReseller'); ?></td>
		<td><?php echo form_input('PointTukarReseller', set_value('PointTukarReseller', $PointTukarReseller), "size='5' style=width:40%"); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Nominal Bayar Reseller :', 'NominalBayarReseller'); ?></td>
		<td><?php echo 'Rp.'.form_input('NominalBayarReseller', set_value('NominalBayarReseller', number_format($NominalBayarReseller, 2, ',', '.')), "size='10' dir='rtl' style=width:40%"); ?></td>
	</tr>
</table>
<br>
	<tr class="submit"><?php echo form_submit('submit', 'Submit'); ?></tr>
</fieldset>
	<br><br>
<?php echo form_close(); ?>
</div>
