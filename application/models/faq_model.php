<?php
class faq_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function view_faq ($perPage,$uri)
	{
		$getData = $this->db->get('faq',$perPage, $uri);
		if($getData->num_rows() > 0)
			return $getData->result();
		else
			return null;
	}
	function add_faq()
	{
		$date = date('d/m/y');
		$k='';
		$query = $this->db->query("select * from faq");
		foreach ($query->result() as $row)
		{
		  $k = $row->kode_faq;
		} 
		$kd = substr($k,3,4)+1;
		
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
		$kode = 'FAQ'.$teks.$kd;
		
		$data = array(
						'kode_faq'=>$kode,
						'pertanyaan'=>$this->input->post('pertanyaan'),
						'jawaban'=>$this->input->post('jawaban'),
						'publish'=>'1',
						'date_add'=>$date
		);
		$this->db->insert('faq',$data);
	}
	
	function take_data($idfaq)
	{
		$query = $this->db->get_where('faq', array('faq_id'=>$idfaq));
		return $query->row();
	}
	
	function edit_faq()
	{
			$query = $this->db->get('faq');
			$kode = $this->input->post('kode_faq');
			$date = date('Y-m-d');
			$data = array(
						'pertanyaan'=>$this->input->post('pertanyaan'),
						'jawaban'=>$this->input->post('jawaban'),
						'date_ch'=>$date
						);
			$this->db->where('kode_faq',$kode);
			$this->db->update('faq',$data);
		
	}
	
	function delete()
	{
			$id = $this->uri->segment(3);
			$this->db->where('faq_id',$id);
			$this->db->delete('faq');
	}
	
	function get_publish($id)
		{
			$query = $this->db->query("select publish from faq where faq_id='$id'");
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
			
			$query = $this->db->get('faq');
			$date = date('Y-m-d');
			$data = array(
						'publish'=>$change,
						'date_ch'=>$date
						);
			$this->db->where('faq_id',$id);
			$this->db->update('faq',$data);
		}
}
?>