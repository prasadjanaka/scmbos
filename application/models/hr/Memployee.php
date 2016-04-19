	<?php

	if (!defined('BASEPATH'))
    exit('No direct script access allowed');

	class Memployee extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_employeer_list() {
        $this->db->select("*");
        $this->db->from('vw_employee_list');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_gender() {

        $this->db->select("*");
        $this->db->from('employee_gender');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_section() {
        $this->db->select("*");
        $this->db->from('employee_section');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_category() {
        $this->db->select("*");
        $this->db->from('employee_job_category');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_designation() {
        $this->db->select("*");
        $this->db->from('employee_designation');
        $query = $this->db->get();
        return $query->result();
    }

 
    public function epf_exsist($epf_number){
	
	  $this->db->select("epf_number");
      $this->db->from('employee');
      $this->db->where('epf_number', $epf_number);
      $query = $this->db->get();
      $condition = $query->num_rows();
	  return $condition;
	
	
	}
	
	
	public function upload_image($photo,$epf_number){
		
		
	if($photo==""){
		$default_photo_path="../../../skin/images/default_photo.jpeg";
		$this->db->set("photo_path",$default_photo_path);
		$this->db->insert('employee_photo');
    	return $this->db->insert_id();
		
	}else{
		$image_path = "application/uploads/EMPLOYEE/images/" . $epf_number . ".jpg";			
						
		move_uploaded_file($photo, $image_path);
		$this->db->set("photo_path", $image_path);
		$this->db->insert('employee_photo');
   		return $this->db->insert_id();
	}	
				
	}
	public function edit_upload_image($photo,$epf_number){
		$image_path = "application/uploads/EMPLOYEE/images/" . $epf_number . ".jpg";			
						
		move_uploaded_file($photo, $image_path);
		
		 $this->db->select("photo_id");
         $this->db->from('employee');
		 $this->db->where('epf_number',$epf_number);
		 $query = $this->db->get();
		 $con=$query->result();
		 foreach($con as $con1){
	     $id=$con1->photo_id;
		 $this->db->set('photo_path',$image_path)
         ->where('photo_id',$id)
         ->update('employee_photo');
		
		 }
		
	
		
	}
		
		
	public function add_emp($data){
			
			
	$this->db->insert("employee",$data);
	return "OK";
	}
		
	public function edit_employee($editepf_number){
		$this->db->select("*");
		$this->db->from("vw_employee_list");
		$this->db->where("epf_number",$editepf_number);
		$query = $this->db->get();
        return $query->result();
		
	}
	public function edit_emp($epf,$data){
			
	
	$this->db->where('epf_number',$epf);
			
	$this->db->update('employee',$data); 	
	return "Updated";
		}

	public function epf_ex($epf){
		$this->db->select("*");
		$this->db->from("employee");
		$this->db->where("epf_number",$epf);
		
        $query = $this->db->get();
        $condition = $query->num_rows();	
	    return $condition;	
				}
		
		
			
			}
	
	

?>