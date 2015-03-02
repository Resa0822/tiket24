<?php
class transaction_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function saveTGuest($idtypehotel)
	{
		$date = date('Y-m-d');
		$k='';
		$query = $this->db->query("select trans_no from book_packages order by trans_no asc");
		foreach ($query->result() as $row)
		{
		  $k = $row->trans_no;
		} 
		$kd = substr($k,2,4)+1;
		
		if(($kd>=0)&&($kd<=9))
		{
			$teks = '000';
		}
		elseif(($kd>=10)&&($kd<=99))
		{
			$teks = '00';
		}
		elseif(($kd>=100)&&($kd<=999))
		{
			$teks = '0';
		}
		$kode = 'TG'.$teks.$kd;
	
	/* 	$data = array(
						'trans_no'=>$kode,
						'packages_id'=>$this->input->post('txtid'),
						'price'=>$this->input->post('txtprice'),
						'adult'=>$this->input->post('adult'),
						'child'=>$this->input->post('child'),
						'date'=>$this->input->post('tanggal'),
						'total'=>$this->input->post('totalprice'),
						'total_price'=>$this->input->post('totalbaru'),
						'metode_id'=>$this->input->post('paymethod'),
						'from_date'=>$this->input->post('from'),
						'to_date'=>$this->input->post('to'),
						'total_night'=>$this->input->post('totalN'),
						'fullname'=>$this->input->post('txtname'),
						'phone'=>$this->input->post('txtphone'),
						'email'=>$this->input->post('txtemail'),
						'card_member'=>$this->input->post('txtcardnumber'),
						'name_card_holder'=>$this->input->post('txtnamecard'),
						'security_code'=>$this->input->post('txtsecurity'),
						'country'=>$this->input->post('country'),
						'address'=>$this->input->post('txtaddress'),
						'date_add'=>$date
		);
		$this->db->insert('book_packages',$data);
		 */
		 
		$packages_id = $this->input->post('txtid');
		$packages_name = $this->input->post('txtname');
		$price = $this->input->post('txtprice');
		$adult = $this->input->post('adult');
		$child = $this->input->post('child');
		$date = $this->input->post('tanggal');
		$total = $this->input->post('totalprice');
		$total_price = $this->input->post('ptotalprice');
		
		$this->session->unset_userdata('sess_trans_no');
		$this->session->set_userdata('sess_trans_no', $kode);
		$this->session->unset_userdata('sess_packages_id');
		$this->session->set_userdata('sess_packages_id', $packages_id);
		$this->session->unset_userdata('sess_packages_name');
		$this->session->set_userdata('sess_packages_name', $packages_name);
		$this->session->unset_userdata('sess_price');
		$this->session->set_userdata('sess_price', $price);
		$this->session->unset_userdata('sess_adult');
		$this->session->set_userdata('sess_adult', $adult);
		$this->session->unset_userdata('sess_child');
		$this->session->set_userdata('sess_child', $child);
		$this->session->unset_userdata('sess_date');
		$this->session->set_userdata('sess_date', $date);
		$this->session->unset_userdata('sess_total');
		$this->session->set_userdata('sess_total', $total);
		$this->session->unset_userdata('sess_total_price');
		$this->session->set_userdata('sess_total_price', $total_price);
	}
	function saveTCGuest($trans_no)
	{
		$date = date('Y-m-d');
		$data = array(
						'trans_no'=>$this->session->userdata('sess_trans_no'),
						'packages_id'=>$this->session->userdata('sess_packages_id'),
						'price'=>$this->session->userdata('sess_price'),
						'adult'=>$this->session->userdata('sess_adult'),
						'child'=>$this->session->userdata('sess_child'),
						'date'=>$this->session->userdata('sess_date'),
						'total'=>$this->session->userdata('sess_total'),
						'metode_id'=>$this->input->post('paymethod'),
						'from_date'=>$this->input->post('from'),
						'to_date'=>$this->input->post('to'),
						'total_night'=>$this->input->post('totalN'),
						'fullname'=>$this->input->post('txtname'),
						'phone'=>$this->input->post('txtphone'),
						'email'=>$this->input->post('txtemail'),
						'card_member'=>$this->input->post('txtcardnumber'),
						'name_card_holder'=>$this->input->post('txtnamecard'),
						'security_code'=>$this->input->post('txtsecurity'),
						'country'=>$this->input->post('country'),
						'address'=>$this->input->post('txtaddress'),
						'date_add'=>$date
		);
		$this->db->insert('book_packages',$data);
/* 		$this->db->where(array('trans_no' => $trans_no)); 	
		$this->db->update('book_packages',$data); */

	}
	function point_report_by_period($perPage,$uri,$users,$firstPeriod,$lastPeriod){
		
		 $this->db->select('*');
		 $this->db->where('user_id', $users);
		
		 $this->db->where('booking_date >=', $firstPeriod);
		 $this->db->where('booking_date <=', $lastPeriod);
		 $this->db->order_by('booking_date', 'asc');
		 $getData = $this->db->get('book_packages',$perPage, $uri);
		if($getData->num_rows() > 0){
			return $getData->result();
		}			
		else{
			return null;
		}
			
	}
	function all_booking_report_by_period($perPage,$uri,$users,$firstPeriod,$lastPeriod){
		
		 $this->db->select('*');
		 //$this->db->where('user_id', $users);
		
		 $this->db->where('booking_date >=', $firstPeriod);
		 $this->db->where('booking_date <=', $lastPeriod);
		 $this->db->order_by('booking_date', 'asc');
		 $getData = $this->db->get('book_packages',$perPage, $uri);
		if($getData->num_rows() > 0){
			return $getData->result();
		}			
		else{
			return null;
		}
			
	}
	function booking_report_by_period($perPage,$uri,$users,$firstPeriod,$lastPeriod){
		  $this->db->select('*');
		 $this->db->where('user_id', $users);
		
		 $this->db->where('booking_date >=', $firstPeriod);
		 $this->db->where('booking_date <=', $lastPeriod);
		 $this->db->order_by('booking_date', 'asc');
		 $getData = $this->db->get('book_packages',$perPage, $uri);
		if($getData->num_rows() > 0){
			return $getData->result();
		}			
		else{
			return null;
		}
	}
	 function point_transaction($perPage,$uri,$users){
    	//to get all data in transaction packages
		if(!empty($users) or $users !== null){
		
			 $this->db->select('*');
			 $this->db->from('book_packages');
			 $this->db->join('users', 'users.users_id=book_packages.user_id', 'left');
			 $this->db->where('user_id', $users);
		
		}else{
			
			  $this->db->select('*');
			 $this->db->from('book_packages');
			  $this->db->join('users', 'users.users_id=book_packages.user_id', 'left');
			
		}
		$getData = $this->db->get('',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
    	}
	function view_transaction ($perPage,$uri,$users)
	{
		//to get all data in transaction packages
		if(!empty($users) or $users !== null){
		/*
			$this->db->where(array("mt.user_id" => $users));
			$this->db->select("mt.transaction_code, dt.nama, dt.gambar, mt.adult, mt.child, date_format( mt.travel_date, '%Y-%m-%d' ) as date, mt.total_sale_price_amount, m.nama_metode ", FALSE);
			$this->db->from('book_packages mt ');
			$this->db->join('packages dt ', 'mt.API_packages_id = dt.packages_id ', 'left');
			$this->db->join('users u ', 'mt.user_id = u.users_id ', 'left');
			$this->db->join('metode_pembayaran m ', 'mt.payment_method = m.metode_id ', 'left');
		 * */
			
			 $this->db->select('*');
			 $this->db->from('book_packages');
			 //$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id','left');
			 //$this->db->join('metode_pembayaran', 'metode_pembayaran.metode_id=book_packages.payment_method','left');
			 $this->db->where('user_id', $users);
			
			
			
		}else{
			/*
			$this->db->where(array("mt.user_id" => $users));
			$this->db->select("mt.transaction_code, dt.nama, dt.gambar, mt.adult, mt.child, date_format( mt.travel_date, '%Y-%m-%d' ) as date, mt.total_sale_price_amount, m.nama_metode ", FALSE);
			$this->db->from('book_packages mt ');
			$this->db->join('packages dt ', 'mt.API_packages_id = dt.packages_id ', 'left');
			$this->db->join('metode_pembayaran m ', 'mt.payment_method = m.metode_id ', 'left');
			 * */
			  $this->db->select('*');
			 $this->db->from('book_packages');
			 //$this->db->join('packages', 'packages.API_packages_id=book_packages.API_packages_id','left');
			 //$this->db->join('metode_pembayaran', 'metode_pembayaran.metode_id=book_packages.payment_method','left');
			
			 
		}
		$getData = $this->db->get('',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function add_packages($userid,$nama_file,$file_path)
	{
		$date = date('d/m/y');
		$k = '';
/* 		$grade = $this->input->post('grade');
		if($grade)
		{
			if($grade = 1)
			{$G="G1";}
			elseif($grade = 2)
			{$G="G2";}
			elseif($grade = 3)
			{$G="G3";}
			elseif($grade = 4)
			{$G="G4";}
			else
			{$G="G5";}
		} */
		
		$query = $this->db->query("select * from packages where kode like '%PK%' order by kode asc");
		foreach ($query->result() as $row)
		{
		  $k = $row->kode;
		} 
		$kd = substr($k,2,4)+1;
		
		if(($kd>=0)&&($kd<=9))
		{
			$teks = '000';
		}
		elseif(($kd>=10)&&($kd<=99))
		{
			$teks = '00';
		}
		elseif(($kd>=100)&&($kd<=999))
		{
			$teks = '0';
		}
		$kode = 'PK'.$teks.$kd;

		if(!empty($nama_file)){
			$nama_file=base_url().'asset/uploads/'.$nama_file;
		} else {
			$nama_file=base_url().'asset/uploads/coming-soon.jpg';
		}
	
		$data = array(
						'kode'=>$kode,
						'API_packages_id'=>$kode,
						'country'=>$this->input->post('country'),
						'city'=>$this->input->post('city'),
						'gambar'=>$nama_file,
						'nama'=>$this->input->post('nama'),
						'package'=>$this->input->post('package'),
						'ket'=>$this->input->post('ket'),
						'periode_begin'=>$this->input->post('periode_begin'),
						'periode_end'=>$this->input->post('periode_end'),
						'price'=>$this->input->post('price'),
						'desc'=>$this->input->post('desc'),
						'date_add'=>$date
		);
		$this->db->insert('packages',$data);

/* 		$idtypeDB ='';
		$query = $this->db->query("select * from packages where kode = '".$kode."'");
		foreach ($query->result() as $row)
		{
			$idtypeDB = $row->packages_id;
		} */
	}
	function take_data($idpackages)
	{
		$query = $this->db->get_where('packages', array('packages_id'=>$idpackages));
		return $query->row();
	}
	function edit_packages()
	{
		$photo = $_FILES['gambar']['name'];
		if(EMPTY($photo))
		{
			$photo = $this->input->post('gambar_lama');
		}
		else
		{
			$photo = $_FILES['gambar']['name'];
		}
		if ($photo)
		{
			$tujuan = "asset/uploads/".$_FILES['gambar']['name'];
			$asal = $_FILES['gambar']['tmp_name'];
			$upload = move_uploaded_file($asal,$tujuan);

		}
		$p = $this->input->post('price');
		if (empty($p))
		{	$price = 0.00;	}
		else{	$price = $this->input->post('price'); }
		
			$query = $this->db->get('packages');
			$kode = $this->input->post('kode');
			$date = date('Y-m-d');
			$data = array(
						'kode'=>$kode,
						'API_packages_id'=>$kode,
						'country'=>$this->input->post('country'),
						'city'=>$this->input->post('city'),
						'gambar'=>$photo,
						'nama'=>$this->input->post('nama'),
						'package'=>$this->input->post('package'),
						'ket'=>$this->input->post('ket'),
						'periode_begin'=>$this->input->post('periode_begin'),
						'periode_end'=>$this->input->post('periode_end'),
						'price'=>$price,
						'desc'=>$this->input->post('desc'),
						'date_add'=>$date
						);
			$this->db->where('kode',$kode);
			$this->db->update('packages',$data);
		
	}
		function delete()
		{
			$kk = $this->uri->segment(3);
			$this->db->where('packages_id',$kk);
			$this->db->delete('packages');
		}

		//for reseller
		function view_packages_reseller ($userid,$perPage,$uri)
		{
			//to get all data in packages
			$getData = $this->db->get_where('packages', array('user_id'=>$userid),$perPage, $uri);
			if($getData->num_rows() > 0)
			return $getData->result();
			else
			return null;
		}
}
?>