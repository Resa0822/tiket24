<?php
class Packages_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_packages_by_tbl_id($pckgTbleID){
		$qry = $this->db->get_where('packages', array('packages_id'=>$pckgTbleID));
		return $qry->result(); 
	}
	
	function search_package_records_count($srchFilter, $txtSearch){
		if($srchFilter == 'byPrice'){
			if(is_numeric($txtSearch)){
				$srchFrmt = number_format($txtSearch,2);
				$this->db->select('*');
				$this->db->from('packages');
				$this->db->where("price BETWEEN 0 AND $txtSearch", NULL, FALSE);
				$this->db->where('price !=', '0');
				$qry = $this->db->get();
				return $qry->num_rows();
			}
			else{
				return false;
			}
		}
		else{
				$this->db->select('*');
				$this->db->from('packages');
				$this->db->like('nama', $txtSearch); 
				$this->db->where('price !=', '0');
				$qry = $this->db->get();
				return $qry->num_rows();
		}
	}
	
	function search_package($limit, $start, $srchFilter, $txtSearch){
		if($srchFilter == 'byPrice'){
				if(is_numeric($txtSearch)){
					$srchFrmt = $txtSearch - 1;
					
					$this->db->select('*');
					$this->db->from('packages');
					$this->db->where("price BETWEEN $srchFrmt AND $txtSearch", NULL, FALSE);
					//$this->db->where('price !=', '0');
					$this->db->order_by('price', 'desc');
					$this->db->limit($limit, $start);
					$qry = $this->db->get();
					return $qry->result();
				}
				else{
					return false;
				}
		}elseif($srchFilter == 'byPackage'){
				$this->db->select('*');
				$this->db->from('packages');
				$this->db->like('nama', $txtSearch); 
				$this->db->where('price !=', '0');
				$this->db->limit($limit, $start);
				$qry = $this->db->get();
				return $qry->result();
		}elseif($srchFilter == 'byCountry'){
				$this->db->select('packages.*');
				$this->db->from('packages');
				$this->db->join('packages_country','packages.country = packages_country.country_iso','LEFT');
				$this->db->like('packages_country.country_name', $txtSearch, 'both'); 
				$this->db->where('price !=', '0');
				$this->db->limit($limit, $start);
			//	$this->db->limit(10, 1);
				$qry = $this->db->get();
				return $qry->result();
		}
	}
	
	function view_packages ($perPage,$uri)
	{
		//to get all data in packages
		$getData = $this->db->get('packages',$perPage, $uri);
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
						'booking_begin'=>$this->input->post('periode_begin'),
						'booking_end'=>$this->input->post('periode_end'),
						'currency'=>$this->input->post('currency'),
						'price'=>$this->input->post('price_adult'),
						'price_adult'=>$this->input->post('price_adult'),
						'price_child'=>$this->input->post('price_child'),
						'discount'=>$this->input->post('discount'),
						'margin_pr'=>$this->input->post('margin_pr'),
						'margin_rp'=>$this->input->post('margin_rp'),
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
		$photo = base_url().'asset/uploads/'.$_FILES['gambar']['name'];
		$photo_name = $_FILES['gambar']['name'];
		if(EMPTY($photo_name))
		{
			$photo = $this->input->post('gambar_lama');
		}
		else
		{
			$photo = base_url().'asset/uploads/'.$_FILES['gambar']['name'];
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
						'booking_begin'=>$this->input->post('periode_begin'),
						'booking_end'=>$this->input->post('periode_end'),
						'currency'=>$this->input->post('currency'),
						'price'=>$this->input->post('price_adult'),
						'price_adult'=>$this->input->post('price_adult'),
						'price_child'=>$this->input->post('price_child'),
						'discount'=>$this->input->post('discount'),
						'margin_pr'=>$this->input->post('margin_pr'),
						'margin_rp'=>$this->input->post('margin_rp'),
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
		
		function get_publish($id)
		{
			//$id=$_GET["id"]
			$k= '';
			$query = $this->db->query("select publish from packages where packages_id='$id'");
			foreach ($query->result() as $row)
			{
				$k = $row->publish;
			} 
			
			if($k=='1')
			{
				$change='0';
			}
			else
			{
				$change='1';
			}

			$query = $this->db->get('packages');
			$date = date('Y-m-d');
			$data = array(
						'publish'=>$change,
						'date_ch'=>$date
						);
			$this->db->where('packages_id',$id);
			$this->db->update('packages',$data);
		}

		function get_order($id,$tOrder)
		{
			$query = $this->db->get('packages');
			$date = date('Y-m-d');
			$data = array(
						'orders'=>$tOrder,
						'date_ch'=>$date
						);
			$this->db->where('packages_id',$id);
			$this->db->update('packages',$data);
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
		
	function searching($limit, $start, $srchFilter, $txtSearch){
		if($srchFilter == 'regular'){
			if(is_numeric($txtSearch)){
				//echo '<h1>ITs NUMERIC</h1>';
				$this->db->select('*');
				$this->db->from('packages');
				//$this->db->like('price', $txtSearch); 
				$this->db->where("price BETWEEN 0 AND $txtSearch", NULL, FALSE);
				$this->db->where('price !=', '0');
				$this->db->order_by('price', 'desc');
				$this->db->limit($limit, $start);
				$qry = $this->db->get();
				
				if ($qry->num_rows() > 0) {
		            foreach ($qry->result() as $row) {
		                $data[] = $row;
		            }
		            return $qry->result();
		        }
		        return false;
			}
			else{
				$this->db->select('*');
				$this->db->from('packages');
				$this->db->like('nama', $txtSearch); 
				
				$this->db->where('price !=', '0');
				$this->db->limit($limit, $start);
				$qry = $this->db->get();
			
				if ($qry->num_rows() > 0) {
		            foreach ($qry->result() as $row) {
		                $data[] = $row;
		            }
		            return $qry->result();
		        }
		        return false;
			}
		}
		else{
			if(is_numeric($txtSearch)){
				$this->db->select('*');
				$this->db->from('packages');
				$this->db->where("price BETWEEN 0 AND $txtSearch", NULL, FALSE);
				$this->db->where('price !=', '0');
				$this->db->where('discount !=', '');
				$this->db->order_by('price', 'desc');
				$this->db->limit($limit, $start);
				$qry = $this->db->get();
				
				if ($qry->num_rows() > 0) {
		            foreach ($qry->result() as $row) {
		                $data[] = $row;
		            }
		            return $qry->result();
		        }
		        return false;
			}
			else{
				$this->db->select('*');
				$this->db->from('packages');
				$this->db->like('nama', $txtSearch); 
				$this->db->or_like('price', $txtSearch); 
				$this->db->where('price !=', '0');
				$this->db->where('discount !=', '');
				$this->db->limit($limit, $start);
				$qry = $this->db->get();
			
				if ($qry->num_rows() > 0) {
		            foreach ($qry->result() as $row) {
		                $data[] = $row;
		            }
		            return $qry->result();
		        }
		        return false;
			}
			
		}
	}
	function reset_order()
	{
		$query = $this->db->get('packages');
		$order = $this->input->post('txtOrder');
		$date = date('Y-m-d');
		$data = array(
					'orders'=>$order
					);
		$this->db->update('packages',$data);
		
	}
		
}
?>