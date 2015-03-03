<?php
$trnsctnNumber='TR3432432';
$hotelName= 'Serela Merdeka Bandung';
$from= '16-06-2014';
$to= '17-06-2014';
$roomCtgry='Double Bed';
$totalNight= '2';
$totalAmount= '6000000';
$paymentMethod= 'Credit Card';
$cardNumber='4564564544';
$guestName= 'My Name';
$phone='45345435';
$email='dummy@dummy.com';
$currency='IDR';

$html ='
<table>
<tr><td><img src="starholidaylogokecil.jpg" width="150" /></td></tr>
<tr><td><b>STAR HOLIDAY.</b></td><td>&nbsp;</td></tr>
<tr><td>Jl. Mekar Abadi 1 No. 26</td><td>&nbsp;</td></tr>
<tr><td>Bandung, Indonesia</td><td>&nbsp;</td></tr>
<tr><td>Tel. No. : +6222-92807788</td><td>&nbsp;</td></tr>
<tr><td>Email : contact.starholiday@gmail.com</td><td>Website : http://www.star-holiday.com</td></tr>
</table>
<br /><br /><br />
<table align="center" style="font-size:14pt; font-weight:strong"><tr><td>RESERVATIONS HOTEL ROOM</td></tr></table>

<table>
<tr><td><b>TRANSACTION NUMBER</b></td><td> : '; $html.=$trnsctnNumber; $html.='</td></tr>
<tr><td><b>HOTEL</b></td><td> : '; $html.=$hotelName; $html.='</td></tr>
</table>

<table>
<tr><td><b>GUEST/GROUPS NAMES</b></td><td> : '; $html.=$guestName; $html.='</td></tr>
<tr><td><b>PAYMENT METHOD</b></td><td> : '; $html.=$paymentMethod; $html.='</td></tr>
<tr><td><b>CARD NUMBER</b></td><td> : '; $html.=$cardNumber; $html.='</td></tr>
<tr><td><b>PHONE NUMBER</b></td><td> : '; $html.=$phone; $html.='</td></tr>
<tr><td><b>EMAIL</b></td><td> : '; $html.=$email; $html.='</td></tr>
</table>
<table style="border:1px #000000 solid">
<tr>
<td><b>FROM DATE</b></td><td><b>TO DATE</b></td><td><b>NIGHTS</b></td><td><b>ROOM CATG.</b></td><td><b>TOTAL AMOUNT</b></td></tr>
<tr>
<td>';$html.=$from; $html.='</td><td>';$html.=$to; $html.='</td><td>';$html.=$totalNight; $html.='</td><td>';$html.=$roomCtgry; $html.='</td><td>';$html.=$currency; $html.=' '; $html.=number_format($totalAmount); $html.='</td>
</tr>
</table>
';

/*
$html = '

<table>
<thead>INVOICE</thead>
<tbody>
<tr><td>Hotel</td><td>'; $html.= ' : '.$hotelName; $html.='</td></tr>
<tr><td>From</td><td>'; $html.= ' : '.$from; $html.='</td></tr>
<tr><td>To</td><td>'; $html.= ' : '.$to; $html.='</td></tr>
<tr><td>Total Night</td><td>'; $html.= ' : '.$totalNight; $html.='</td></tr>
<tr><td>Total Amount</td><td>'; $html.= ' : '.$totalAmount; $html.='</td></tr>
<tr><td>Payment Method</td><td>'; $html.= ' : '.$paymentMethod; $html.='</td></tr>
<tr><td>Full Name</td><td>'; $html.= ' : '.$fullName; $html.='</td></tr>
<tr><td>Telephone</td><td>'; $html.= ': '.$phone; $html.='</td></tr>
<tr><td>Email</td><td>'; $html.= ':'.$email; $html.='</td></tr>
</tbody></table>
';
*/
//==============================================================
//==============================================================
//==============================================================
include("mpdf.php");

$mpdf=new mPDF('c','A4','','',10,25,10,25,16,13); 

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