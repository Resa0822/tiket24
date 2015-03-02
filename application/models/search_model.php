<?php
class Search_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function record_count($srchFilter, $txtSearch) {
		$srchVal = str_replace('-', ' ', $txtSearch);
		if($srchFilter == 'regular'){
			if(is_numeric($txtSearch)){
				//echo '<h1>ITs NUMERIC</h1>';
				$this->db->select('*');
				$this->db->from('packages');
				//$this->db->like('price', $txtSearch); 
				$this->db->where("price BETWEEN 0 AND $txtSearch", NULL, FALSE);
				$this->db->where('price !=', '0');
				$this->db->order_by('price', 'desc');
	
				$qry = $this->db->get();
				
				return $qry->num_rows();
				
			}
			else{
				$this->db->select('*');
				$this->db->from('packages');
				$this->db->join('packages_country', 'packages_country.country_iso=packages.country', 'left');
				$this->db->join('packages_city', 'packages_city.city_iso=packages.city', 'left');
				$this->db->like('packages.nama', $txtSearch); 
				$this->db->or_like('packages_country.country_name', $txtSearch); 
				$this->db->or_like('packages_city.city_name', $txtSearch); 
				
				
				$this->db->where('packages.price !=', '0');
				
				$qry = $this->db->get();
			
				return $qry->num_rows();
				
			}
		}
		else{
			if(is_numeric($txtSearch)){
				$this->db->select('*');
				$this->db->from('packages');
				$this->db->where("price BETWEEN 0 AND $txtSearch", NULL, FALSE);
				$this->db->where('price !=', '0');
				$this->db->where('discount IS NOT NULL', NULL, FALSE);
				$this->db->order_by('price', 'desc');
				
				$qry = $this->db->get();
				
				return $qry->num_rows();
			}
			else{
				$this->db->select('*');
				$this->db->from('packages');
				$this->db->join('packages_country', 'packages_country.country_iso=packages.country', 'left');
				$this->db->join('packages_city', 'packages_city.country_iso=packages_country.country_iso', 'left');
				$this->db->like('packages.nama', $txtSearch); 
				$this->db->or_like('packages_country.country_name', $txtSearch); 
				$this->db->or_like('packages_city.city_name', $txtSearch); 
				$this->db->where('packages.price !=', '0');
				//$this->db->or_like('packages.price', $txtSearch); 
				$qry = $this->db->get();
		             foreach($qry->result() as $rows){
					 $pckgId = $rows->packages_id;
					 $this->db->select('*');
						$this->db->from('packages');
						$this->db->where('packages_id', $pckgId);
						$this->db->where('discount IS NOT NULL', NULL, FALSE);
						$qrySrch = $this->db->get();
						return $qrySrch->num_rows(); 
							
						
					 }
			}
			
		}
    }
	
	
	function search_byPrice($priceFrom, $priceTo, $limit, $start)
	{
		//$query = $this->db->query('SELECT * FROM packages WHERE price BETWEEN $priceFrom AND $priceTo ORDER BY price desc');
		$this->db->select('*');
		$this->db->from('packages');
		$this->db->where("price BETWEEN $priceFrom AND $priceTo", NULL, FALSE);
		$this->db->where('price !=', '0');
		$this->db->order_by('packages_id', 'asc');
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
	function searching($limit, $start, $srchFilter, $txtSearch){
		$txtSearch = $this->db->escape_like_str($txtSearch);
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
					$this->db->select('*, packages.gambar as pcg_gambar');
					$this->db->from('packages');
					$this->db->join('packages_country', 'packages_country.country_iso=packages.country', 'left');
					$this->db->join('packages_city', 'packages_city.city_iso=packages.city', 'left');
					$this->db->like('packages.nama', $txtSearch, 'both'); 
					$this->db->or_like('packages_country.country_name', $txtSearch, 'both'); 
					$this->db->or_like('packages_city.city_name', $txtSearch, 'both'); 
					$this->db->where('packages.price !=', '0');
				
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
					
					$this->db->select('*, packages.gambar as pcg_gambar');
					$this->db->from('packages');
					$this->db->join('packages_country', 'packages_country.country_iso=packages.country', 'left');
					$this->db->join('packages_city', 'packages_city.country_iso=packages_country.country_iso', 'left');
					$this->db->like('packages.nama', $txtSearch); 
					$this->db->or_like('packages_country.country_name', $txtSearch); 
					$this->db->or_like('packages_city.city_name', $txtSearch); 
					$this->db->where('packages.price !=', '0');
					//$this->db->or_like('packages.price', $txtSearch); 
					$qry = $this->db->get();
			             foreach($qry->result() as $rows){
						 $pckgId = $rows->packages_id;
						 $this->db->select('*');
							$this->db->from('packages');
							$this->db->where('packages_id', $pckgId);
							$this->db->where('discount IS NOT NULL', NULL, FALSE);
							$qrySrch = $this->db->get();
							//return $qrySrch->num_rows(); 
								if ($qrySrch->num_rows() > 0) {
						            return $qrySrch->result();
						        }
						        return false;
							
						 }
				}
				
			}
		
	}
		
}
?>