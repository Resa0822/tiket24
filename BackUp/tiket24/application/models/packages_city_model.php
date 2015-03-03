<?php
class packages_city_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
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
	function add_packages_city($userid,$nama_file,$file_path,$country_iso,$city_iso,$city_name)
	{
		$date = date('d/m/y');

		if(!empty($nama_file)){
			$nama_file=base_url().'asset/uploads/'.$nama_file;
		} else {
			$nama_file=base_url().'asset/uploads/coming-soon.jpg';
		}
	
		$data = array(
						'country_iso'=> $country_iso,
						'city_iso'=> $city_iso,
						'city_name'=> $city_name,
						'gambar'=> $nama_file,
						'date_add'=> $date
		);
		$this->db->insert('packages_city',$data);

/* 		$idtypeDB ='';
		$query = $this->db->query("select * from packages_city where kode = '".$kode."'");
		foreach ($query->result() as $row)
		{
			$idtypeDB = $row->idy;
		} */
	}
	function take_data($idpackages_city)
	{
		$query = $this->db->get_where('packages_city', array('idy'=>$idpackages_city));
		return $query->row();
	}
	function edit_packages_city($id)
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
		
			$query = $this->db->get('packages_city');
			$date = date('Y-m-d');
			$data = array(
						'country_iso'=>$this->input->post('country_iso'),
						'city_iso'=>$this->input->post('city_iso'),
						'city_name'=>$this->input->post('city_name'),
						'gambar'=>$photo,
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