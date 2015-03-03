<?php
class margin_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function view_margin ($perPage,$uri,$keys)
	{
		//to get all data in margin
		$getData = $this->db->get_where('margin', array('keys'=> $keys),$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function add_margin()
	{
		if($this->tank_auth->is_logged_in()){
			$usrRoleID = $this->tank_auth->get_user_role_id();
			$usrID = $this->tank_auth->get_user_id(); 	
		}
		$date = date('d/m/y');
		switch($usrRoleID){
			case 1 : $data = array(
						'role_id' => $this->input->post('role_id'),
						'user_id' => $usrID,
						'margin_pr'=>$this->input->post('margin_pr'),
						'margin_rp'=>$this->input->post('margin_rp'),
						'currency'=>'IDR',
						'keys'=>$this->tank_auth->get_user_role_id(),
						'user_add'=>$this->tank_auth->get_username(),
						'date_add'=>$date
					);
					$this->db->insert('margin',$data);break;
			case 3 : $data = array(
						'role_id' => $usrRoleID,
						'user_id' => $usrID,
						'margin_pr'=>$this->input->post('margin_pr'),
						'margin_rp'=>$this->input->post('margin_rp'),
						'currency'=>'IDR',
						'keys'=>$this->tank_auth->get_user_role_id(),
						'user_add'=>$this->tank_auth->get_username(),
						'date_add'=>$date
					);
					$this->db->insert('margin',$data);break;
		}

/* 		$idtypeDB ='';
		$query = $this->db->query("select * from margin where kode = '".$kode."'");
		foreach ($query->result() as $row)
		{
			$idtypeDB = $row->mid;
		} */
	}
	function take_data($id)
	{
		$query = $this->db->get_where('margin', array('mid'=>$id));
		return $query->row();
	}
	function edit_margin($id)
	{
			$query = $this->db->get('margin');
			$date = date('Y-m-d');
			$data = array(
					//	'role_id'=>$this->input->post('role_id'),
						'margin_pr'=>$this->input->post('margin_pr'),
						'margin_rp'=>$this->input->post('margin_rp'),
						'currency'=>$this->input->post('currency'),
						'user_ch'=>$this->tank_auth->get_username(),
						'date_ch'=>$date
						);
			$this->db->where('mid',$id);
			$this->db->update('margin',$data);
		
	}
		function delete()
		{
			$kk = $this->uri->segment(3);
			$this->db->where('mid',$kk);
			$this->db->delete('margin');
		}
		
		function get_publish($id)
		{
			//$id=$_GET["id"]
			$query = $this->db->query("select publish from margin where mid='$id'");
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
			
			$query = $this->db->get('margin');
			$date = date('Y-m-d');
			$data = array(
						'publish'=>$change,
						'date_ch'=>$date
						);
			$this->db->where('kode',$id);
			$this->db->update('margin',$data);
		}
		function get_order($id,$tOrder)
		{
			$query = $this->db->get('margin');
			$date = date('Y-m-d');
			$data = array(
						'orders'=>$tOrder,
						'date_ch'=>$date
						);
			$this->db->where('mid',$id);
			$this->db->update('margin',$data);
		}

		//for reseller
		function view_margin_reseller ($perPage,$uri)
		{
			//to get all data in margin
			$getData = $this->db->get_where('margin', array('keys'=>3),$perPage, $uri);
			if($getData->num_rows() > 0)
			return $getData->result();
			else
			return null;
		}
		
}
?>