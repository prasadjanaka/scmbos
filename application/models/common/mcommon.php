<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcommon extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }
	
	public function get_data_array($key_field,$data_field,$from){
		// this function returns a single diamentional array of data of given 2 fields from the given table.
		// $container_sizes = ($this->mcommon->get_data_array("container_size_id","container_size","container_size"));
		// $container_size = "20 FT";
		// $container_size_id = array_search($container_size,$container_sizes);
		// $container_size_id = ($container_size_id==false?0:$container_size_id);		
	
		$this->db->select("$key_field,$data_field");
		$this->db->from("$from");
		$container_sizes = $this->db->get();
		$data_array = array();
		foreach($container_sizes->result() as $row){
			$data_array[$row->$key_field] = $row->$data_field;
		}
		return($data_array);			
	}

	public function get_code_from_text($value,$from,$return_field,$search_field){
		$ret_val = "";
		
		$value = strtolower($value);
		$value = str_replace(' ','',$value);
		$this->db->select("$return_field");
		$this->db->from("$from");
		$this->db->where("replace(lower($search_field),' ','')='$value'");
		$result = $this->db->get();
		
		if($result->num_rows()>0){
			$ret_val = $result->row()->$return_field;	
		}
		return $ret_val;
	}
	
	public function get_column_value($value,$from,$return_field,$search_field){
		$ret_val = "";
		$this->db->select("$return_field");
		$this->db->from("$from");
		$this->db->where("$search_field",$value);
		$result = $this->db->get();
		
		if($result->num_rows()>0){
			$ret_val = $result->row()->$return_field;	
		}
		return $ret_val;
	}	
	
}