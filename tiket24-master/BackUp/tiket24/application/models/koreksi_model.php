<?php
class koreksi_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function view_koreksi ($perPage,$uri)
	{
	/* 	if($role_id == 2){$profile = 'member_profile'; }
		if($role_id == 3){ $profile = 'reseller_profile'; }
		
		//to get all data in koreksi
		$this->db->select("concat(trim(first_name),' ', trim(last_name)) as full_name, roles.role, koreksi.*", FALSE);
		$this->db->from('koreksi');
		$this->db->join('roles', 'roles.role_id = koreksi.role_id', 'left');
		$this->db->join($profile, ''.$profile.'.id = koreksi.id', 'left');
	*/
		$this->db->select("concat(trim(first_name),' ', trim(last_name)) as full_name, roles.role, koreksi.*", FALSE);
		$this->db->from('koreksi');
		$this->db->join('roles', 'roles.role_id = koreksi.role_id and roles.role_id = 2');
		$this->db->join('member_profile', 'member_profile.id = koreksi.id');
		$query1 = $this->db->get();
		
		$this->db->select("concat(trim(first_name),' ', trim(last_name)) as full_name, roles.role, koreksi.*", FALSE);
		$this->db->from('koreksi');
		$this->db->join('roles', 'roles.role_id = koreksi.role_id and roles.role_id = 3');
		$this->db->join('reseller_profile', 'reseller_profile.id = koreksi.id');
		$query2 = $this->db->get();
		
		$q1 = $query1->result();
		$q2 = $query2->result();
		$getData = array_merge($q1, $q2);
		if($query1->num_rows() > 0 or $query2->num_rows() > 0)
			return $getData;
		else
			return null;
	
		/* $getData = $this->db->get('',$perPage); 
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;*/
	}
	function add_koreksi()
	{
		$role_id = $this->input->post('roles');
		$id = $this->input->post('name');
		$date = date('d/m/y');
		$k = '';
		
		$query = $this->db->query("select * from koreksi where koreksi_no like '%KP%' order by koreksi_no asc");
		foreach ($query->result() as $row)
		{
		  $k = $row->koreksi_no;
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
		$kode = 'KP'.$teks.$kd;
		$data = array(
						'koreksi_no'=>$kode,
						'role_id'=>$role_id,
						'id'=>$id,
						'point'=>$this->input->post('koreksi_point'),
						'user_add'=>$this->tank_auth->get_username(),
						'date_add'=>$date
		);
		$this->db->insert('koreksi',$data);
		
		if($role_id == 2){$profile = 'member_profile'; }
		if($role_id == 3){ $profile = 'reseller_profile'; }
		
		$query = $this->db->query("select point from ".$profile." where id = '".$id."' ");
		foreach ($query->result() as $row)
		{
		  $point = $row->point;
		}
		
			$data2 = array(
							'point'=>$point + $this->input->post('koreksi_point'),
			);
			$this->db->where('id',$id);
			$this->db->update($profile,$data2);
		
		
/* 		$idtypeDB ='';
		$query = $this->db->query("select * from koreksi where kode = '".$kode."'");
		foreach ($query->result() as $row)
		{
			$idtypeDB = $row->koreksi_no;
		} */
	}
	function take_data($koreksi_no)
	{
		$query = $this->db->get_where('koreksi', array('koreksi_no'=>$koreksi_no));
		return $query->row();
	}
	function edit_koreksi($id)
	{
		$query = $this->db->get('koreksi');
		$date = date('Y-m-d');
		$data = array(
					'point'=>$this->input->post('koreksi_point'),
					'user_ch'=>$this->tank_auth->get_username(),
					'date_ch'=>$date
					);
		$this->db->where('koreksi_no',$id);
		$this->db->update('koreksi',$data);
		
	}
		function delete()
		{
			$kk = $this->uri->segment(3);
			$this->db->where('koreksi_no',$kk);
			$this->db->delete('koreksi');
		}
		
		function get_publish($id)
		{
			//$id=$_GET["id"]
			$query = $this->db->query("select publish from koreksi where koreksi_no='$id'");
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
			
			$query = $this->db->get('koreksi');
			$date = date('Y-m-d');
			$data = array(
						'publish'=>$change,
						'date_ch'=>$date
						);
			$this->db->where('kode',$id);
			$this->db->update('koreksi',$data);
		}

		//for reseller
		function view_koreksi_reseller ($userid,$perPage,$uri)
		{
			//to get all data in koreksi
			$getData = $this->db->get_where('koreksi', array('user_id'=>$userid),$perPage, $uri);
			if($getData->num_rows() > 0)
			return $getData->result();
			else
			return null;
		}
		
}
?>