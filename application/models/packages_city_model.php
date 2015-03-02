<?php
class packages_city_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function search_package_city_records_count($txtSearch){
		$this->db->select('*');
		$this->db->from('packages_city');
		$this->db->join('packages_country', 'packages_country.country_iso=packages_city.country_iso', 'left');
		$this->db->like('packages_city.city_name', $txtSearch); 
		$this->db->or_like('packages_city.city_iso', $txtSearch);
		$this->db->or_like('packages_country.country_name', $txtSearch); 
		$this->db->or_like('packages_country.country_iso', $txtSearch); 
		$qry = $this->db->get();
		
		return $qry->num_rows();
	}
	
	function search_package_city($limit, $start, $txtSearch){
			$this->db->select('*');
			$this->db->from('packages_city');
			$this->db->join('packages_country', 'packages_country.country_iso=packages_city.country_iso', 'refresh');
			$this->db->like('packages_city.city_name', $txtSearch); 
			$this->db->or_like('packages_city.city_iso', $txtSearch);
			$this->db->or_like('packages_country.country_name', $txtSearch); 
			$this->db->or_like('packages_country.country_iso', $txtSearch); 
			$this->db->limit($limit, $start);
			$qry = $this->db->get();
			return $qry->result();
	}
	
	function view_packages_city ($perPage,$uri)
	{
		//to get all data in packages_city
		$this->db->select('packages_country.country_name, packages_city.*');
		$this->db->from('packages_city');
		$this->db->join('packages_country', 'packages_country.country_iso = packages_city.country_iso', 'left');

		$getData = $this->db->get('',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	
	function check_city_isExist($city_iso,$city_name){
		
		$this->db->select('*');
		$this->db->from('packages_city');
		$this->db->where('city_iso', $city_iso);
		$this->db->or_where('city_name', $city_name);
		$qry = $this->db->get();
		if($qry->num_rows > 0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	function add_packages_city($userid,$nama_file,$file_path,$country_iso,$city_iso,$city_name)
	{
		$cityIsExist = $this->check_city_isExist($city_iso,$city_name);
		if($cityIsExist == FALSE){
			$date = date('d/m/y');
			if(!empty($nama_file)){
				$nama_file=base_url().'asset/uploads/'.$nama_file;
			} else {
				$nama_file=base_url().'asset/uploads/coming-soon.jpg';
			}
		
			$data = array(
							'country_iso'=> strtoupper($country_iso),
							'city_iso'=> strtoupper($city_iso),
							'city_name'=> ucwords($city_name),
							'gambar'=> $nama_file,
							'date_add'=> $date
			);
			$this->db->insert('packages_city',$data);
		}
		else{
			$this->session->set_flashdata('flashMsge_warning', '<strong>Warning !</strong> data with value <strong>'.$city_iso.'</strong> or <strong>'.$city_name.'</strong> is already exist !');
			redirect('packages_city', 'refresh');
		}
	}
	function take_data($idpackages_city)
	{
		$query = $this->db->get_where('packages_city', array('idy'=>$idpackages_city));
		return $query->row();
	}
	function edit_packages_city($id,$nama_file)
	{
		$photo = $_FILES['gambar']['name'];
		$qryCtyImg = $this->db->get_where('packages_city', array('idy'=>$id));
		foreach($qryCtyImg->result() as $rows){
			$imgPath = $rows->gambar;
		}
		//echo '<script>alert("'.$nama_file.'")</script>';
		if(empty($photo))
		{
			$photo = $imgPath;//$this->input->post('gambar_lama');
			$urlGmbr = $imgPath;
		}
		else
		{
			$photo = $_FILES['gambar']['name'];
			$urlGmbr = base_url().'asset/uploads/'.$nama_file;
			$img_name = basename($imgPath);
			$filestring = APPPATH.'../asset/uploads/'.$img_name;
			unlink($filestring); 
		}
		
		if($photo)
		{
			$tujuan = "asset/uploads/".$_FILES['gambar']['name'];
			$asal = $_FILES['gambar']['tmp_name'];
			$upload = move_uploaded_file($asal,$tujuan);

		}
		
			$query = $this->db->get('packages_city');
			$date = date('Y-m-d');
			$data = array(
						'country_iso' => strtoupper($this->input->post('country_iso')),
						'city_iso' => strtoupper($this->input->post('city_iso')),
						'city_name' => ucwords($this->input->post('city_name')),
						'gambar'=>$urlGmbr,
						'date_ch'=>$date
						);
			$this->db->where('idy',$id);
			$this->db->update('packages_city',$data);
			
		
	}
		function delete()
		{
			$kk = $this->uri->segment(3);
			$this->db->where('idy',$kk);
			$this->db->delete('packages_city');
		}
		
		function get_publish($id)
		{
			//$id=$_GET["id"]
			$query = $this->db->query("select publish from packages_city where idy='$id'");
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
			
			$query = $this->db->get('packages_city');
			$date = date('Y-m-d');
			$data = array(
						'publish'=>$change,
						'date_ch'=>$date
						);
			$this->db->where('kode',$id);
			$this->db->update('packages_city',$data);
		}

		function get_order($id,$tOrder)
		{
			$query = $this->db->get('packages_city');
			$date = date('Y-m-d');
			$data = array(
						'orders'=>$tOrder,
						'date_ch'=>$date
						);
			$this->db->where('idy',$id);
			$this->db->update('packages_city',$data);
		}

		//for reseller
		function view_packages_city_reseller ($userid,$perPage,$uri)
		{
			//to get all data in packages_city
			$getData = $this->db->get_where('packages_city', array('user_id'=>$userid),$perPage, $uri);
			if($getData->num_rows() > 0)
			return $getData->result();
			else
			return null;
		}
		
}
?>