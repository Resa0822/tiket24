<?php
if($this->tank_auth->get_user_role_id() !== 1){
$qryUsrs = $this->db->select('*')
->from('users')
->join('roles', 'roles.role_id=users.role_id', 'left')
->where('users_id', $userID)
->get();
	foreach($qryUsrs->result() as $fldUsrs){
		$usrNm = $fldUsrs->username;
		$usrTpe = $fldUsrs->role;
		$currPnt = $fldUsrs->total_point;
	}
}
$currency='IDR';
$html = '
<!-- <h1>mPDF</h1>
<h2>Tables</h2>
<h3>CSS Styles</h3>
<p>The CSS properties for tables and cells is increased over that in html2fpdf. It includes recognition of THEAD, TFOOT and TH.<br />See below for other facilities such as autosizing, and rotation.</p>-->
<div id="grid" class="k-grid k-widget k-secondary k-reorderable" data-role="grid" style="">
<div ><h3> Point History </h3></div>';

if($this->tank_auth->get_user_role_id() !== 1){
	$html .='
<table border="0" cellpading="0" cellspacing="0">
<tr>
<td>Username </td>
<td> : '.$usrNm.'</td>
</tr>
<tr>
<td>Type </td>
<td> : '.ucwords($usrTpe).'</td>
</tr>
<tr>
<td>Current Point </td>
<td> : '.$currPnt.'</td>
</tr>
</table>';
}

$html .='
<table border="1" cellpading="0" cellspacing="0">
<thead>
<tr>
    <th>Transaction No</th>
    <th>Packages Name</th>
    <th>Booking Date</th>
    <th>Total Amount</th>
    <th>Point Earned</th>
    <th>Point Radeemed</th>
</tr>
</thead>
<tbody>'; 
if(!empty($text)) {
	foreach($text as $row)
	{
		$date = date_create($row->booking_date);
		$trDtReform = date_format($date, 'd M Y'); 
		$totAmnt = round($row->amount_total_sale_price_inIDR);
		$totAmount = 'IDR '.number_format($totAmnt);
		$this->db->select('nama_metode');
		$this->db->from('metode_pembayaran');
		$this->db->where('metode_id', $row->payment_method);
		$qryPymntMthd = $this->db->get();
		foreach($qryPymntMthd->result() as $fldPymntMthd){
			$pymntMthd = $fldPymntMthd->nama_metode;
		}
		$pointGained = $row->point_transaction;
		$pointRadeemed = $row->pointRadeem;
		
		$qryPoint = $this->db->select('*')
		->from('users')
		->where('users_id', $row->user_id)
		->get();
		foreach($qryPoint->result() as $fldBkngPoint){
			$pointTotal = $fldBkngPoint->total_point;
			
		}
$html .= '
	<tr class="k-alt" role="row" style="text-align: center;" >
		<td class="highlighted" role="gridcell" >';
$html .= $row->transaction_code; 
$html .= '
		</td>
		<td class="highlighted" role="gridcell" >';
$html .= $row->nama; 
$html .= '
		</td>
		<td class="highlighted" role="gridcell" >';
$html .= $trDtReform; 
$html .= '
		</td>
		<td class="highlighted" role="gridcell" >';
$html .= $totAmount; 
$html .= '
		</td>
		<td class="highlighted" role="gridcell" >';
$html .= $pointGained; 
$html .= '
		</td>
		<td class="highlighted" role="gridcell" >';
$html .= $pointRadeemed; 
$html .= '
		</td>
	</tr>';
} 
}else{ 

$html .= '
<tr class="k-alt" role="row" style="text-align: center;" >
<td colspan=10>';
$html .= '<br/><center><h1>Empty Data !</h1></center><br/> 
';
}
$html .= '
</td>
</tr>			
</tbody></table>
</div>
';
//==============================================================
//==============================================================
//==============================================================
include("mpdf57/mpdf.php");

$mpdf=new mPDF('c','A4-L','','',10,15,10,15,13,13); 

$mpdf->SetDisplayMode('fullpage');


// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);

$mpdf->Output('mpdf.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>