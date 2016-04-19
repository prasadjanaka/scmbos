<?php
class Mit_inventory extends CI_Model {
    function __construct()
    {
        parent::__construct();
		
    }

	public function list_device(){
		$this->db->select('*');
		$this->db->from('device_details');
		$query=$this->db->get();
		return $query->result();
		
	}
	
	public function add_device($data){
		
		$this->db->insert("device_details",$data);
		return "OK";
	}
	public function edit_details($id){
		$this->db->select('*');
		$this->db->from('device_details');
		$this->db->where('device_details_id',$id);
		$query=$this->db->get();
		return $query->result();
	}
	
	public function edit($details,$device_details_id){
		
		$this->db->where('device_details_id',$device_details_id);
		$this->db->update('device_details',$details);
		return "OK";
		

	}
	public function data_excel(){
		$this->db->select('*');
		$this->db->from('device_details');
		$query=$this->db->get();
		return $query->result();
	}
	public function list_department(){
		$this->db->select('*');
		$this->db->from('department');
		$query=$this->db->get();
		return $query->result();
	}
	public function list_birthday($date_birth){
	$date= explode("-", $date_birth);	
	$this->db->select('*');
	$this->db->from('sys_user');
	$this->db->where("DATE_FORMAT(birthday,'%m')", $date[1]);
    $this->db->where("DATE_FORMAT(birthday,'%d')", $date[2]);
	return $this->db->get();	
	}
}

 ?>