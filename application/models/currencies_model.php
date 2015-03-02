<?php
class Currencies_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function search_currencies_records_count($txtSearch){
		$this->db->select('*');
		$this->db->from('currencies');
		$this->db->join('country', 'country.country_iso=currencies.country_iso_from', 'left');
		$this->db->like('country.country_name', $txtSearch); 
		$this->db->or_like('currencies.country_iso_from', $txtSearch);
		$qry = $this->db->get();
		
		return $qry->num_rows();
	}
	
	function search_currency($limit, $start, $txtSearch){
			$this->db->select('*');
		$this->db->from('currencies');
		$this->db->join('country', 'country.country_iso=currencies.country_iso_from', 'left');
		$this->db->like('country.country_name', $txtSearch); 
		$this->db->or_like('currencies.country_iso_from', $txtSearch);
		$qry = $this->db->get();
		
			return $qry->result();
	}
	
	function view_currencies ($perPage,$uri)
	{
		//to get all data in currencies
		$getData = $this->db->get('currencies',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function add_currencies($userid,$nama_file,$file_path)
	{
		$date = date('d/m/y');

		if(!empty($nama_file)){
			$nama_file=base_url().'asset/uploads/'.$nama_file;
		} else {
			$nama_file=base_url().'asset/uploads/coming-soon.jpg';
		}
	
		$data = array(
						'country_iso_from'=>$this->input->post('country_iso_from'),
						'currency_from'=>$this->input->post('currency_from'),
						/* 'country_iso_to'=>$this->input->post('country_iso_to'),
						'currency_to'=>$this->input->post('currency_to'), */
						'konversi'=>$this->input->post('conversion'),
						'date_add'=>$date
		);
		$this->db->insert('currencies',$data);

/* 		$idtypeDB ='';
		$query = $this->db->query("select * from currencies where kode = '".$kode."'");
		foreach ($query->result() as $row)
		{
			$idtypeDB = $row->id;
		} */
	}
	function take_data($id)
	{
		$query = $this->db->get_where('currencies', array('id'=>$id));
		return $query->row();
	}
	function edit_currencies($id)
	{
			$query = $this->db->get('currencies');
			$date = date('Y-m-d');
			$data = array(
						'country_iso_from'=>$this->input->post('country_iso_from'),
						'currency_from'=>$this->input->post('currency_from'),
						/* 'country_iso_to'=>$this->input->post('country_iso_to'),
						'currency_to'=>$this->input->post('currency_to'), */
						'konversi'=>$this->input->post('conversion'),
						'date_ch'=>$date
						);
			$this->db->where('id',$id);
			$this->db->update('currencies',$data);
		
	}
		function delete()
		{
			$kk = $this->uri->segment(3);
			$this->db->where('id',$kk);
			$this->db->delete('currencies');
		}
		
		function get_publish($id)
		{
			//$id=$_GET["id"]
			$query = $this->db->query("select publish from currencies where id='$id'");
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
			
			$query = $this->db->get('currencies');
			$date = date('Y-m-d');
			$data = array(
						'publish'=>$change,
						'date_ch'=>$date
						);
			$this->db->where('kode',$id);
			$this->db->update('currencies',$data);
		}

		//for reseller
		function view_currencies_reseller ($userid,$perPage,$uri)
		{
			//to get all data in currencies
			$getData = $this->db->get_where('currencies', array('user_id'=>$userid, 'status' = 0),$perPage, $uri);
		//	$this->db->order_by('country_iso_to','DESC');
			if($getData->num_rows() > 0)
			return $getData->result();
			else
			return null;
		}
		
}
?>