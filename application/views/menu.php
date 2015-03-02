<script>
$(document).ready(function(){ 
$("#Currencies_id").change(function(e) {
	window.location.href = '<?php echo $this->config->base_url();?>index.php/home/change_currency/' + $(this).val()
}); 

});
</script>
<?php
	//print_r($this->session->all_userdata());
	if($this->session->userdata('sess_conversi') != 0){	
		if($this->session->userdata('sess_currency') != ''){
			if($this->session->userdata('sess_currency') != null){
				$conv = $this->session->userdata('sess_conversi'); 
				$curr = $this->session->userdata('sess_currency');
			}else{	
				$conv = 1; 
				$curr = 'SGD'; 
			}
		}else{	
				$conv = 1; 
				$curr = 'SGD'; 
		}
	}else{	
				$conv = 1; 
				$curr = 'SGD'; 
	}
	$conv_sgd = $this->session->userdata('sess_conv_sgd');
	//$curr_data = $this->session->userdata('sess_curr_data');
	//echo "<script type='text/javascript'>alert(' $curr ');</script>";
	//echo "<script type='text/javascript'>alert(' $curr - $conv');</script>"; 

?>
<div id="parent_menu" style="width:100%" >
	<a href="<?php echo $this->config->base_url();?>index.php/home/">Home</a>
	<a href="<?php echo $this->config->base_url();?>index.php/attractions/">Attractions</a>
	<a href="<?php echo $this->config->base_url();?>index.php/attractions/hot_deal/">Hot Deals</a>
	<div id="language"> <form action="" method="post">
							<select name="language">
								<option value="us">English (US)</option>
							</select>
						</form>
	</div>	
	<div id="language"  > <form action="" method="post">
						
						<?php
							$this->db->select('*');
							$this->db->from('currencies');
							$this->db->order_by('currency_from');
							$qry = $this->db->get();
							foreach($qry->result_array() as $row){
								$ar_currencies[$row['currency_from']] = $row['currency_from'];
							}
							//print_r($curr_data);
							//print_r($curr);
							//print_r($ar_currencies);
							if(!empty($curr)) {
								$ar_currencies[$curr] = $curr; 
							}else{
								$ar_currencies['SGD'] = 'SGD';
							}
							echo form_dropdown('currencies', $ar_currencies, $curr, 'id="Currencies_id" name="currencies" style="width:100%"'); 
								
							?>		
						</form>
	</div>
</div>