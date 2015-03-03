<?php
class Members extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	private function _get_country_list() 
	{
		$query = $this->db->query('SELECT * FROM country');
		return $query->result();
	}
	function view_member_profile ($perPage,$uri)
	{
		//to get all data in member_profile
		$getData = $this->db->get('member_profile',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function view_member_user ($user_id)
	{
		//to get all data in member_profile
		$getData = $this->db->query('select users_id from users where username = "'.$user_id.'"');
		if($getData->num_rows() > 0){
			foreach($getData->result() as $row){
				$user_id = $row->users_id; }
			return $user_id;
		} else {
			return null;
		}
	}
	function add_member_profile($user_id)
	{
		$date = date('d/m/y');
		$k="";
		
		$data = array(
						'users_id'=>$user_id,
						'salutation'=>$this->input->post('salutation'),
						'country'=>$this->input->post('country'),
						'city'=>$this->input->post('city'),
						'first_name'=>$this->input->post('first_name'),
						'last_name'=>$this->input->post('last_name'),
						'address'=>$this->input->post('address'),
						'postcode'=>$this->input->post('postcode'),
						'dob'=>$this->input->post('dob'),
						'phone'=>$this->input->post('phone'),
						'mobile'=>$this->input->post('mobile'),
						'date_add'=>$date,
		);
		$this->db->insert('member_profile',$data);
	}
	function take_data($idmember_profile)
	{
		$query = $this->db->get_where('member_profile', array('member_profile_id'=>$idmember_profile));
		return $query->row();
	}
	function edit_member_profile()
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
			$tujuan = "uploads/".$_FILES['gambar']['name'];
			$asal = $_FILES['gambar']['tmp_name'];
			$upload = move_uploaded_file($asal,$tujuan);

		}
		$p = $this->input->post('price');
		if (empty($p))
		{	$price = 0.00;	}
		else{	$price = $this->input->post('price'); }
		
			$query = $this->db->get('member_profile');
			$kode = $this->input->post('kode');
			$date = date('Y-m-d');
			$data = array(
						'users_id'=>$user_id,
						'salutation'=>$this->input->post('salutation'),
						'country'=>$this->input->post('country'),
						'city'=>$this->input->post('city'),
						'first_name'=>$this->input->post('first_name'),
						'last_name'=>$this->input->post('last_name'),
						'address'=>$this->input->post('address'),
						'postcode'=>$this->input->post('postcode'),
						'dob'=>$this->input->post('dob'),
						'phone'=>$this->input->post('phone'),
						'mobile'=>$this->input->post('mobile'),
						'date_add'=>$date,
						);
			$this->db->where('kode',$kode);
			$this->db->update('member_profile',$data);
		
	}
		function delete()
		{
			$kk = $this->uri->segment(3);
			$this->db->where('member_profile_id',$kk);
			$this->db->delete('member_profile');
		}
		
		function get_publish($id)
		{
			//$id=$_GET["id"]
			$query = $this->db->query("select publish from member_profile where member_profile_id='$id'");
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
			
			$query = $this->db->get('member_profile');
			$date = date('Y-m-d');
			$data = array(
						'publish'=>$change,
						'date_ch'=>$date
						);
			$this->db->where('kode',$id);
			$this->db->update('member_profile',$data);
		}

		//for reseller
	function view_reseller ($perPage,$uri)
	{
		//to get all data in reseller_profile
		$this->db->where(array('users.role_id'=>3));
		$this->db->join('user_profiles', 'user_profiles.user_id = reseller_profile.users_id', 'left');
		$this->db->join('users', 'user_profiles.user_id = users.users_id', 'left');
		$getData = $this->db->get('reseller_profile',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
		function view_member_profile_reseller ($userid,$perPage,$uri)
		{
			//to get all data in member_profile
			$getData = $this->db->get_where('member_profile', array('user_id'=>$userid),$perPage, $uri);
			if($getData->num_rows() > 0)
			return $getData->result();
			else
			return null;
		}
		
	function add_member_profile_reseller($user_id,$nama_file)
	{
	
		if(!empty($nama_file)){
			$nama_file=base_url().'asset/uploads/'.$nama_file;
		} else {
			$nama_file=base_url().'asset/uploads/coming-soon.jpg';
		}
		
		$date = date('d/m/y');
		
		$data = array(
						'users_id'=>$user_id,
						'agency_name'=>$this->input->post('name'),
						'legal_name'=>$this->input->post('legal_name'),
						'title'=>$this->input->post('salutation'),
						'first_name'=>$this->input->post('first_name'),
						'last_name'=>$this->input->post('last_name'),
						'address'=>$this->input->post('address'),
						'address2'=>$this->input->post('address2'),
						'city'=>$this->input->post('city'),
						'state'=>$this->input->post('state'),
						'postcode'=>$this->input->post('postcode'),
						'country'=>$this->input->post('country_iso'),
						'website'=>$this->input->post('website'),
						'phone'=>$this->input->post('phone'),
						'mobile'=>$this->input->post('mobile'),
						'fax'=>$this->input->post('fax'),
						'iata'=>$this->input->post('iata'),
						'company_type'=>$this->input->post('company_type'),
						'business_type'=>$this->input->post('business_type'),
						'year_oo'=>$this->input->post('year_oo'),
						'employess'=>$this->input->post('employess'),
						'trc'=>$nama_file,
						'payment_mode'=>$this->input->post('payment_mode'),
						'date_add'=>$date,
		);
		$this->db->insert('reseller_profile',$data);
	}
	function take_data_reseller($idmember_profile)
	{
		$query = $this->db->get_where('reseller_profile', array('id'=>$idmember_profile));
		return $query->row();
	}
	function edit_member_profile_reseller()
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
			$tujuan = "uploads/".$_FILES['gambar']['name'];
			$asal = $_FILES['gambar']['tmp_name'];
			$upload = move_uploaded_file($asal,$tujuan);

		}
		$p = $this->input->post('price');
		if (empty($p))
		{	$price = 0.00;	}
		else{	$price = $this->input->post('price'); }
		
			$query = $this->db->get('reseller_profile');
			$kode = $this->input->post('kode');
			$date = date('Y-m-d');
			$data = array(
						'users_id'=>$user_id,
						'agency_name'=>$this->input->post('name'),
						'legal_name'=>$this->input->post('legal_name'),
						'title'=>$this->input->post('salutation'),
						'first_name'=>$this->input->post('first_name'),
						'last_name'=>$this->input->post('last_name'),
						'address'=>$this->input->post('address'),
						'address2'=>$this->input->post('address2'),
						'city'=>$this->input->post('city'),
						'state'=>$this->input->post('state'),
						'postcode'=>$this->input->post('postcode'),
						'country'=>$this->input->post('country_iso'),
						'website'=>$this->input->post('website'),
						'phone'=>$this->input->post('phone'),
						'mobile'=>$this->input->post('mobile'),
						'fax'=>$this->input->post('fax'),
						'iata'=>$this->input->post('iata'),
						'company_type'=>$this->input->post('company_type'),
						'business_type'=>$this->input->post('business_type'),
						'year_oo'=>$this->input->post('year_oo'),
						'employess'=>$this->input->post('employess'),
						'trc'=>$nama_file,
						'payment_mode'=>$this->input->post('payment_mode'),
						'date_add'=>$date,
						);
			$this->db->where('kode',$kode);
			$this->db->update('reseller_profile',$data);
		
	}
	function delete_reseller()
	{
		$kk = $this->uri->segment(3);
		$this->db->where('id',$kk);
		$this->db->delete('reseller_profile');
	}
	function activated($id)
	{
		$k = '';
		$query = $this->db->query("select activated from users where users_id='$id'");
		foreach ($query->result() as $row)
		{
			$k = $row->activated;
		} 
		
		if($k=='1')
		{
			$change='0';
		}
		else
		{
			$change='1';
		}
		
		$date = date('Y-m-d');
		$data = array(
					'activated'=>$change,
					'date_ch'=>$date
					);
		$this->db->where('users_id',$id);
		$this->db->update('users',$data);
	}
		
}
?>