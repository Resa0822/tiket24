<?php
class Deposit_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function view_deposit ($perPage,$uri)
	{
		$this->db->select("agency_name, concat(trim(first_name),' ', trim(last_name)) as full_name, roles.role, deposit.*", FALSE);
		$this->db->from('deposit');
		$this->db->join('roles', 'roles.role_id = deposit.role_id and roles.role_id = 3');
		$this->db->join('reseller_profile', 'reseller_profile.id = deposit.id');
		$getData = $this->db->get();
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	
	}
	function add_deposit()
	{
		$role_id = $this->input->post('roles');
		$id = $this->input->post('name');
		$date = date('d/m/y');
		$k = '';
		
		$query = $this->db->query("select * from deposit where deposit_no like '%DP%' order by deposit_no asc");
		foreach ($query->result() as $row)
		{
		  $k = $row->deposit_no;
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
		$kode = 'DP'.$teks.$kd;
		$data = array(
						'deposit_no'=>$kode,
						'role_id'=>$role_id,
						'id'=>$id,
						'nominal'=>$this->input->post('deposit_nominal'),
						'user_add'=>$this->tank_auth->get_username(),
						'date_add'=>$date
		);
		$this->db->insert('deposit',$data);
		
		$profile = 'reseller_profile'; 
		
		$query = $this->db->query("select top_up from ".$profile." where id = '".$id."' ");
		foreach ($query->result() as $row)
		{
		  $nominal = $row->top_up;
		}
		
			$data2 = array(
							'top_up'=>$nominal + $this->input->post('deposit_nominal'),
			);
			$this->db->where('id',$id);
			$this->db->update($profile,$data2);
	}
	function take_data($deposit_no)
	{
		$query = $this->db->get_where('deposit', array('deposit_no'=>$deposit_no));
		return $query->row();
	}
	function edit_deposit($id)
	{
		$reseller_id = $this->input->post('id');
		$query = $this->db->get('deposit');
		$date = date('Y-m-d');
		$profile = 'reseller_profile'; 
		
		$qry = $this->db->query("select nominal from deposit where deposit_no = '".$id."' ");
		foreach ($qry->result() as $row)
		{
		  $nml = $row->nominal;
		}
		$query = $this->db->query("select top_up from ".$profile." where id = '".$reseller_id."' ");
		foreach ($query->result() as $row)
		{
		  $nominal = $row->top_up;
		}
		
			$data1 = array(
								'top_up'=>$nominal - $nml,
				);
				$this->db->where('id',$reseller_id);
				$this->db->update($profile,$data1);
		
			$data = array(
						'nominal'=>$this->input->post('deposit_nominal'),
						'user_ch'=>$this->tank_auth->get_username(),
						'date_ch'=>$date
						);
			$this->db->where('deposit_no',$id);
			$this->db->update('deposit',$data);
		
		
		$query = $this->db->query("select top_up from ".$profile." where id = '".$reseller_id."' ");
		foreach ($query->result() as $row)
		{
		  $nominal2 = $row->top_up;
		}
			$data2 = array(
							'top_up'=>$nominal2 + $this->input->post('deposit_nominal'),
			);
			$this->db->where('id',$reseller_id);
			$this->db->update($profile,$data2);
		
		
	}
		function delete()
		{
			$kk = $this->uri->segment(3);
			$profile = 'reseller_profile'; 
		
			$qry = $this->db->query("select nominal,id from deposit where deposit_no = '".$kk."' ");
			foreach ($qry->result() as $row)
			{
			  $nml = $row->nominal;
			  $reseller_id = $row->id;
			}
			  
			$query = $this->db->query("select top_up from ".$profile." where id = '".$reseller_id."' ");
			foreach ($query->result() as $row)
			{
			  $nominal = $row->top_up;
			}
			
				$data1 = array(
									'top_up'=>$nominal - $nml,
					);
					$this->db->where('id',$reseller_id);
					$this->db->update($profile,$data1);
					
			$this->db->where('deposit_no',$kk);
			$this->db->delete('deposit');
		}
		
		function get_publish($id)
		{
			//$id=$_GET["id"]
			$query = $this->db->query("select publish from deposit where deposit_no='$id'");
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
			
			$query = $this->db->get('deposit');
			$date = date('Y-m-d');
			$data = array(
						'publish'=>$change,
						'date_ch'=>$date
						);
			$this->db->where('kode',$id);
			$this->db->update('deposit',$data);
		}
		
}
?>