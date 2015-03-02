<?php
class packages_country_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function search_package_country_records_count($txtSearch){
		$this->db->select('*');
		$this->db->from('packages_country');
		$this->db->like('country_name', $txtSearch); 
		$this->db->or_like('country_iso', $txtSearch); 
		$qry = $this->db->get();
		
		return $qry->num_rows();
		
	}
	
	function search_package_country($limit, $start, $txtSearch){
		
			$this->db->select('*');
			$this->db->from('packages_country');
			$this->db->like('country_name', $txtSearch); 
			$this->db->or_like('country_iso', $txtSearch); 
			$this->db->limit($limit, $start);
			$qry = $this->db->get();
			return $qry->result();
	
		
		
		
	}
	function view_packages_country ($perPage,$uri)
	{
		//to get all data in packages_country
		$getData = $this->db->get('packages_country',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function add_packages_country($userid,$nama_file,$file_path,$country_iso,$country_name)
	{
		$date = date('d/m/y');

		if(!empty($nama_file)){
			$nama_file=base_url().'asset/uploads/'.$nama_file;
		} else {
			$nama_file=base_url().'asset/uploads/coming-soon.jpg';
		}
	
		$data = array(
						'country_iso'=> strtoupper($country_iso),
						'country_name'=> ucwords($country_name),
						'gambar'=>$nama_file,
						'date_add'=>$date
		);
		$this->db->insert('packages_country',$data);

/* 		$idtypeDB ='';
		$query = $this->db->query("select * from packages_country where kode = '".$kode."'");
		foreach ($query->result() as $row)
		{
			$idtypeDB = $row->idx;
		} */
	}
	function take_data($id)
	{
		$query = $this->db->get_where('packages_country', array('idx'=>$id));
		return $query->row();
	}
	function edit_packages_country($id, $nama_file)
	{
		$photo = $_FILES['gambar']['name'];
		$qryCntryImg = $this->db->get_where('packages_country', array('idx'=>$id));
		foreach($qryCntryImg->result() as $rows){
			$imgPath = $rows->gambar;
		}
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
			$filestring_new = 'asset/uploads/'.$img_name;
			unlink($filestring);
			//unlink($filestring_new);
			/* $filestring_new = 'asset/uploads/'.$img_name;
			if(unlink($filestring) == true){
				unlink($filestring);
			}else{
				unlink($filestring_new);
			} */
		}
		
		if ($photo)
		{
			$tujuan = "asset/uploads/".$_FILES['gambar']['name'];
			$asal = $_FILES['gambar']['tmp_name'];
			$upload = move_uploaded_file($asal,$tujuan);

		}
		
			$query = $this->db->get('packages_country');
			$date = date('Y-m-d');
			$data = array(
						'country_iso'=> strtoupper($this->input->post('country_iso')),
						'country_name'=> ucwords($this->input->post('country_name')),
						'gambar'=>$urlGmbr,
						'date_ch'=>$date
						);
			$this->db->where('idx',$id);
			$this->db->update('packages_country',$data);
			
		
	}
		function delete()
		{
			$kk = $this->uri->segment(3);
			$this->db->where('idx',$kk);
			$this->db->delete('packages_country');
		}
		
		function get_publish($id)
		{
			//$id=$_GET["id"]
			$query = $this->db->query("select publish from packages_country where idx='$id'");
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
			
			$query = $this->db->get('packages_country');
			$date = date('Y-m-d');
			$data = array(
						'publish'=>$change,
						'date_ch'=>$date
						);
			$this->db->where('kode',$id);
			$this->db->update('packages_country',$data);
		}
		function get_order($id,$tOrder)
		{
			$query = $this->db->get('packages_country');
			$date = date('Y-m-d');
			$data = array(
						'orders'=>$tOrder,
						'date_ch'=>$date
						);
			$this->db->where('idx',$id);
			$this->db->update('packages_country',$data);
		}


		//for reseller
		function view_packages_country_reseller ($userid,$perPage,$uri)
		{
			//to get all data in packages_country
			$getData = $this->db->get_where('packages_country', array('user_id'=>$userid),$perPage, $uri);
			if($getData->num_rows() > 0)
			return $getData->result();
			else
			return null;
		}
		
}
?>