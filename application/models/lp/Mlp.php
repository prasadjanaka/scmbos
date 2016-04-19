<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlp extends CI_Model {
    function __construct()
    {
        parent::__construct();
		$this->load->model('user/mlogin');
		$this->load->model('transport/mtransport');	
    }

	public function park_out_bay($lp_number=''){
		$this->change_lp_current_status($lp_number,LP_PARK_OUT_BAY,'Container Parked Out Bay');
	}

	public function re_open_container($lp_number=''){
		$this->change_lp_current_status($lp_number,LP_RE_OPEN_CONTAINER,'Container Re-Opned');
	}

	public function release_container($lp_number=''){
		$this->change_lp_current_status($lp_number,LP_RELEASE_CONTAINER,'Container Released');
	}

	public function close_container($lp_number=''){
		$this->change_lp_current_status($lp_number,LP_CLOSE_CONTAINER,'Container Closed');
	}

	public function stop_loading($lp_number=''){
		$this->change_lp_current_status($lp_number,LP_STOPED_LOADING,'Loading Stoped');
	}
	
	public function release_to_load($lp_number=''){
		$this->change_lp_current_status($lp_number,LP_RELEASED_FOR_LOADING,'Released to Load');
	}

	private function change_lp_current_status($lp_number='',$status_id=0,$status_text=''){
		$data['current_status_id'] = $status_id;
		$this->db->where('lp_number',$lp_number);
		$this->db->update('lp', $data); 		
		
		$history = array('status_id' => $status_id,'ref_type' => 'lp','ref' => $lp_number,
				 'field' => 'current_status_id','field_id' => $status_id,'text' => $status_text);
		$this->mlogin->write_history($history);	
	}


	public function get_lp_detail($lp_number=''){
		$this->db->where('lp_number',$lp_number);
		$this->db->from('vw_lp'); 	
			
		return $this->db->get(); 
		
	}


	public function get_lp_detail_excess($lp_number=''){
		$sql = "SELECT * FROM lp_load WHERE lp_number = '$lp_number'
					AND product_id NOT IN (SELECT DISTINCT product_id FROM lp_detail WHERE lp_number = '$lp_number')";
		$result =  $this->db->query($sql); 
		return $result;
	}


	public function get_lp_detail_line($lp_number=''){
		$this->db->select('*,product.description,0 as quantity_loaded');
		$this->db->where('lp_number',$lp_number);
		$this->db->from('lp_detail'); 	
		$this->db->join('product','product.product_id = lp_detail.product_id'); 	
		$result =  $this->db->get(); 
		
		foreach($result->result() as $row){
			$sql = "";
			$sql = "SELECT SUM(IF(direction='IN', quantity, -quantity)) AS `quantity` FROM `lp_load` 
						WHERE `lp_number` = '".$row->lp_number."' AND `product_id` = '".$row->product_id."'";
			$loaded =  $this->db->query($sql); 
//			echo $this->db->last_query(); 
//			die();			
				if($loaded->num_rows()>0){
					$row->quantity_loaded = $loaded->row()->quantity;			
				}
			
		}
		
		return $result;
	}
	
	public function get_excess_loadings($lp_number=''){
		
	}
	
	
	public function get_loading_history($lp_number=''){
		$this->db->select('lp_load.*,sys_user.username');
		$this->db->where('lp_number',$lp_number);
		$this->db->from('lp_load'); 
		$this->db->join('sys_user','sys_user.user_id = lp_load.user_id','Left'); 	
		$this->db->order_by('lp_load.datetime','desc'); 	


		return $this->db->get(); 
		
	}
	/*
	SELECT *,sys_user.username
FROM
lp_load
Inner Join sys_user ON sys_user.user_id = lp_load.user_id
	*/

	public function update_lp($data){
		$lp_number = $data['lp_number'] ;
		$field = $data['field'] ;
		$value = $data['value'] ; 
		$data = array($field =>  $value);
		$this->db->where('lp_number',$lp_number);
		$this->db->update('lp', $data); 
	}
    
	public function get_manpower_list(){
		$this->db->select('*');
		$this->db->from('vw_manpower_list');
		return $this->db->get();
	}

	public function get_bay_list(){
		$this->db->select('*');
		$this->db->from('vw_bay_list');
		return $this->db->get();
	}



	public function get_all_lps(){
		return $this->get_lp_list();	
	}
	
	public function get_new_lps(){
		return $this->get_lp_list(LP_NEW);	
	}

	public function get_scheduled_lps(){
		return $this->get_lp_list(LP_SCHEDULED);	
	}	
	
	private function get_lp_list($status_id=""){
		$this->db->select('*');
		if($status_id <> "") $this->db->where('current_status_id',$status_id);
		$this->db->from('vw_lp');
		return $this->db->get();
	}

	public function get_lp_list_for_loading_activities(){
		$this->db->select('*');
		$this->db->where_in('hundred_percent_available',1);
		$this->db->where_in('current_status_id',array(LP_CLOSE_CONTAINER,LP_CONTAINNER_RE_OPENED,LP_LOADING_FINISHED,LP_LOADING_STARTED,LP_PARK_OUT_BAY,
													  LP_PLANNED,LP_RELEASED_FOR_LOADING,LP_SCHEDULED,LP_STOPED_LOADING));
		$this->db->from('vw_lp');
		$result = $this->db->get();
		return $result;
		
	}

	public function get_released_lp_list(){
		$this->db->distinct();
		$this->db->select('history.ref,history.datetime,lp.client_code,lp.country,lp.tmp_destination,history.status_id,lp.delivery_block_removed_date,
lp.cargo_ready_date,lp.vessel_closing_date');
		$this->db->where('history.status_id',LP_RELEASE_CONTAINER);
		$this->db->where('ref_type ','lp');
		$this->db->from('history');
		$this->db->join('lp','lp.lp_number = history.ref');
		$this->db->order_by('history.datetime', 'DESC');
		$result = $this->db->get();
		return $result;
		
	}


	
	public function add_lp($data){
		$this->db->select('lp_number');
		$this->db->from('lp');
		$this->db->where('lp_number',$data['lp_number']);
		$result = $this->db->get();
		if($result->num_rows()>0) {
			return false;
		}else{
			$this->db->set('datetime_created', 'NOW()', FALSE);
			$this->db->insert('lp',$data);
			return true;
		}
	}	
	
	public function lp_viwe($lp_number){
		$this->db->select('*');
		$this->db->where('lp_number',$lp_number);
		$this->db->from('lp');
		return $this->db->get();
	
	}
	public function lp_details_list($lp_number){
		$this->db->select('*');
		$this->db->where('lp_number',$lp_number);
		$this->db->from('lp');
		return $this->db->get();
	
	}
	
	
	public function lp_details_viwe($lp_number){
		$this->db->select('product.description,lp_detail.quantity,lp_detail.sub_customer,lp_detail.product_id,lp_detail.lp_number,lp_detail.original_product_id');
		$this->db->from('lp_detail');
		$this->db->join('product','lp_detail.product_id = product.product_id');		
		$this->db->where('lp_detail.lp_number',$lp_number);
		return $this->db->get();	

	}
	
	
	public function lp_scheduled_update($data){
		$date = date('Y-m-d H:i:s ', strtotime(str_replace('-', '-', $data['value'])));
		$lp_number = $data['lp_number'] ;
		$field = $data['field'] ;
		$value = $date ; 
		$data = array($field =>  $value,'current_status_id'=> $data['status_id']);
		$this->db->where('lp_number',$lp_number);
		$this->db->update('lp', $data); 
	
	}
	
	 public function get_lp_history($lp_number){
		 $this->db->select("*");
		 $this->db->from("vw_history_list");
		 $this->db->where("ref_type","lp");
		 $this->db->where("ref",$lp_number);
		 $this->db->order_by("datetime","DESC");
		 $result = $this->db->get();
		 return $result->result();
	 }
	 
	 public function forwarded_list(){
		 $this->db->select("*");
		 $this->db->from("sp_supplier");
		 $this->db->where("supplier_type_id",15);
		 return $this->db->get();
	 }
	 
	 public function container_size(){
	 	 $this->db->select("*");
		 $this->db->from("container_size");
		 return $this->db->get();
	 }
	 
	 public function pick_and_loading_update($data){
		$date = date('Y-m-d H:i:s ', strtotime(str_replace('-', '-', $data['value'])));
		$lp_number = $data['lp_number'] ;
		$field = $data['field'] ;
		$value = $date ; 
		$data = array($field =>  $value);
		$this->db->where('lp_number',$lp_number);
		$this->db->update('lp', $data); 
	
	}
	 public function pick_and_loading_bay_update($data){
		$lp_number = $data['lp_number'] ;
		$field = $data['field'] ;
		$data = array($field =>  $data['value']);
		$this->db->where('lp_number',$lp_number);
		$this->db->update('lp', $data); 
	
	}
	 
	 public function request_container($data){
	 	$user_id = $this->session->userdata('user_id');	
		
		if($user_id!=""){
			$data['ref_type']="lp";
			$data['user_id']=$user_id;
			$this->db->select('*');
			$this->db->from('sys_user');
			$this->db->where('user_id',$user_id);
			$query=$this->db->get();
				
				foreach($query->result() as $row){
					$data['email']=$row->email;
					$data['name']=$row->name;
				}
				
					$this->db->select('*');
					$this->db->from('sp_supplier');
					$this->db->where('supplier_id',$data['forward_id']);
					$query1=$this->db->get();
					
					foreach($query1->result() as $row1){
						$data['forward_email']=$row1->email;
						$data['forward_name']=$row1->contact_person;
					}
					$this->mtransport->new_container_request($data);	
			
		}
	 
	 }
	 
	 public function lp_hundred_precent($lp_number,$data){
		$this->db->where('lp_number', $lp_number);
		$this->db->update('lp',$data); 
	
	 }
	
}
