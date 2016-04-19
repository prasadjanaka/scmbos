<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mmhe extends CI_Model {

    function __construct() {
        parent::__construct();
      
    }

	public function mhe_list(){
	
	$this->db->select("*");
	$this->db->from("vw_mhe_list");
	$query=$this->db->get();
	return $query->result(); 
	
	}
	public function unit_list(){
	
	$this->db->select("*");
	$this->db->from("unit");
	$query=$this->db->get();
	return $query->result(); 
	
	}
	
	public function get_category(){
	$this->db->select("*");
	$this->db->from("mhe_category");
	$query=$this->db->get();
	return $query->result();	
		
	}
	public function get_brand(){
	$this->db->select("*");
	$this->db->from("mhe_brand");
	$query=$this->db->get();
	return $query->result();	
		
	}
	public function get_model(){
	$this->db->select("*");
	$this->db->from("mhe_model");
	$query=$this->db->get();
	return $query->result();	
		
	
	
	}
	public function get_fuel(){
	$this->db->select("*");
	$this->db->from("mhe_fuel_type");
	$query=$this->db->get();
	return $query->result();	
		
	}
	public function get_unit(){
	$this->db->select("*");
	$this->db->from("unit");
	$query=$this->db->get();
	return $query->result();	
		
	}
	public function get_payment(){
	$this->db->select("*");
	$this->db->from("mhe_payment_term");
	$query=$this->db->get();
	return $query->result();	
		
	}
	public function get_status(){
	$this->db->select('*');	
	$this->db->like('status_const','MHES_','after');
	$this->db->from("status");
	$query = $this->db->get();
	return  $query->result();	
	}
	
	public function get_supplier(){
	$this->db->select("*");
	$this->db->from("sp_supplier");
	$query=$this->db->get();
	return $query->result();	
		
	}
	
	public function add_new_mhe($data){
			
	$this->db->insert("mhe_master",$data);
	return "OK";	
		
	}

	
	public function edit_mhe_details($mhe_number){
	$this->db->select("*");
	$this->db->from("vw_mhe_list");
	$this->db->where("master_id",$mhe_number);
	$query = $this->db->get();
    return $query->result();
		
	}
	
	public function edit_mhe($data_edit,$mhe){
				
	$this->db->where('master_id',$mhe);			
	$this->db->update('mhe_master',$data_edit); 	
	return "Updated";
	}
		
		
	public function get_lastrow_mhe(){
	$maxid=$this->db->query("SELECT master_id FROM mhe_master WHERE  master_id=(SELECT MAX(master_id) FROM mhe_master)");
	return $maxid->result();
		
	}
		
		
	public function mhe_vw_list(){
		
	$this->db->select('master_id,category_name,mhe_number');
	$this->db->from('vw_mhe_list');
	$query = $this->db->get();
       	
	return $query->result();
	
	}
	public function addnew_model($data){
	
	$this->db->insert("mhe_model",$data);
	return "1";	
	}
		
	public function select_brand($bid){
			
		$this->db->select('*');
		$this->db->from('mhe_model');
		$this->db->where('brand_id',$bid);
		$query = $this->db->get();
       	
		return $query->result();	
			
			
	}
		
	public function mhe_schedule_delete($master_id,$she_date,$status_id,$user_name){
		if($she_date==""){
			$date_start =date('Y-m-d');
		}
		
		$day_count=6;
        $date_start = ($she_date == "" ? date('Y-m-d') : date('Y-m-d', strtotime($she_date)));

        $day_count = ($day_count == "" ? 6 : $day_count);
       

        $date_end = date('Y-m-d', strtotime("+" . $day_count . " days", strtotime($date_start)));
		
		while (strtotime($date_start) <= strtotime($date_end)) {
		$this->db->where('she_date', $date_start);
		$this->db->where('master_id', $master_id);
		$this->db->delete('mhe_availability'); 		
		$date_start = date('Y-m-d', strtotime("+1 days",strtotime($date_start)));
		}
		
		
		$this->mhe_schedule_add($master_id,$she_date,$status_id,$user_name,$date_end,$date_start);
		$this->update_after_7_day($master_id,$she_date,$status_id,$user_name,$date_end);		
	 	return 1;		
	}
	public function update_after_7_day($master_id,$she_date,$status_id,$user_name,$date_end){
		$this->db->set('status_id', $status_id);
		$this->db->set('user', $user_name);
		$this->db->set('date_time', date("Y-m-d")." ".date("h:i"));
		$this->db->where('she_date>', $date_end);
		$this->db->where('master_id', $master_id);
		$this->db->update('mhe_availability'); 		
		
		
		
		}
	public function mhe_schedule_add($master_id,$she_date,$status_id,$user_name,$date_end,$date_start){
		if($she_date==""){
		$date_start =date('Y-m-d');
		}
		$day_count=6;
       $date_start = ($she_date == "" ? date('Y-m-d') : date('Y-m-d', strtotime($she_date)));

        $day_count = ($day_count == "" ? 6 : $day_count);
       

        $date_end = date('Y-m-d', strtotime("+" . $day_count . " days", strtotime($date_start)));
		while (strtotime($date_start) <= strtotime($date_end)) {
		
		$this->db->set('master_id',$master_id);
		$this->db->set('she_date',$date_start);
		$this->db->set('status_id',$status_id);
		$this->db->set('user',$user_name);
		$this->db->set('date_time',date("Y-m-d")." ".date("h:i"));
		$this->db->insert('mhe_availability');	
		$date_start = date('Y-m-d', strtotime("+1 days",strtotime($date_start)));
		}		
		
	}
	
	public function mhe_today($date_start,$date_end){
	
		$this->db->select('*');
		$this->db->where('she_date >=',$date_start);
		$this->db->where('she_date <=',$date_end);
		$this->db->from("vw_mhe_availability_list");
		$query = $this->db->get();
		return  $query->result();	
			
	}
		
	public function mhe_status(){
		$this->db->select('*');	
		$this->db->like('status_const','MHES_','after');
		$this->db->from("status");
		$query = $this->db->get();
		return  $query->result();	
		
		
	}
	public function data_excel($date_start,$date_end){
		$this->db->select('*');
		$this->db->where('she_date >=',$date_start);
		$this->db->where('she_date <=',$date_end);
		$this->db->from("vw_mhe_availability_list");
		$result= $this->db->get();
		return $result->result();
		
		}	
	public function mhe_ext($mhe_num){
	  $this->db->select("mhe_number");
      $this->db->from('mhe_master');
      $this->db->where('mhe_number', $mhe_num);
      $query = $this->db->get();
      $condition = $query->num_rows();
	  return $condition;
		
	}
	public function add_lp_asn(){
		$this->db->select('*');
		$this->db->from('lp_asn_schedule');
		$query=$this->db->get();
		return $query->result();
		
	}
	public function remove_li_asn($number){
		
		$this->db->where('lp_asn_id', $number);
		$this->db->delete('lp_asn_schedule'); 
		return "ok";		
	}
	public function update_lp_asn($number,$bay,$s_date,$e_date){
		$this->db->set('lp_asn_id', $number);
		$this->db->set('bay_id', $bay);
		$this->db->set('start_time',$s_date);
		$this->db->set('end_time', $e_date);
		$this->db->where('lp_asn_id',$number);
		$this->db->update('lp_asn_schedule'); 		
	}
	
	public function resize_lp_asn($data,$id){
		$this->db->where('lp_asn_id',$id);
		$this->db->update('lp_asn_schedule',$data);
		print_r("ok");
	}
	public function search($date){
		$this->db->select('*');
		$this->db->from('lp_asn_schedule');
		$this->db->where('lp_asn_schedule');
		
	}
	
	public function runing_chart($master_id,$date,$r_start,$r_end,$epf){

		$user_date=$this->session->userdata('user_id');
		$data['master_id']=$master_id;
		$data['date']=$date;
		$data['recoding_start']=$r_start;
		$data['recoding_end']=$r_end;
		$data['user_id']=$user_date;
		$data['date_time']=date("Y-m-d")." ".date("h:i");
		$data['epf_number']=$epf;
		$this->db->insert('mhe_runing_chart',$data);
		echo 1;	

	}
	
	
	public function runing_chart_schedule(){
		$this->db->select('*');
		$this->db->from('mhe_runing_chart');
		$query=$this->db->get();
		return $query->result();
	
	
	}
	
	public function runing_chart_excel($date){
		$this->db->select('*');
		$this->db->from('vw_mhe_runing_chart');
		$this->db->where('date',$date);
		$query=$this->db->get();
		return $query->result();
	
	
	}
	public function delete_runing_chart_data($id){
		$this->db->where('runing_chart_id',$id);	
		$this->db->delete('mhe_runing_chart');
		print_r("OK");
	}
	
}
