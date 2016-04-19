<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Colombo");
class MInventory extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

	public function change_replenishment_order($replenishment_id=0,$action="",$zone_id=0){
		$this->db->select('*');
		$this->db->from('vw_replenishment');
		$this->db->where('replenishment_id',$replenishment_id);
		$this->db->where('zone_id',$zone_id);
		$result = $this->db->get();		
		
		if($result->num_rows()>0){
			$row = $result->row();
			$sort_order = $row->sort_order;			
		
			if($action=="move_up"){
				$data['sort_order'] = $sort_order;
				$this->db->where('sort_order',$sort_order-1);
				$this->db->where('zone_id',$zone_id);
				$this->db->update('vw_replenishment',$data);						

				$data['sort_order'] = $sort_order - 1;
				$this->db->where('replenishment_id',$replenishment_id);
				$this->db->update('replenishment',$data);
				
				$history = array('status_id' => PF_REPLENISHMENT_MOVE_UP,'ref_type' => 'replenishment','ref' => $replenishment_id,
								 'field' => 'sort_order','field_id' => $sort_order,'text' => $action);
				$this->mlogin->write_history($history);						
			}	
			if($action=="move_down"){
				$data['sort_order'] = $sort_order;
				$this->db->where('sort_order',$sort_order+1);
				$this->db->where('zone_id',$zone_id);
				$this->db->update('vw_replenishment',$data);					

				$data['sort_order'] = $sort_order + 1;
				$this->db->where('replenishment_id',$replenishment_id);
				$this->db->update('replenishment',$data);		

				
				$history = array('status_id' => PF_REPLENISHMENT_MOVE_DOWN,'ref_type' => 'replenishment','ref' => $replenishment_id,
								 'field' => 'sort_order','field_id' => $sort_order,'text' => $action);
				$this->mlogin->write_history($history);										
			}	
			if($action=="move_top"){
				$this->db->select('MIN(sort_order) AS min_sort');
				$this->db->where('zone_id',$zone_id);
				$this->db->from('vw_replenishment');					

				$min_sort = $this->db->get()->row()->min_sort;		
				$min_sort = ($min_sort==''? 0 : $min_sort);
				$min_sort--;
				 			
				$data['sort_order'] = $min_sort;
				$this->db->where('replenishment_id',$replenishment_id);
				$this->db->update('replenishment',$data);		
				
				$this->db->query('UPDATE vw_replenishment SET sort_order = sort_order -1 WHERE sort_order >='.$sort_order .' AND zone_id='.$zone_id);
				
				$history = array('status_id' => PF_REPLENISHMENT_MOVE_TOP,'ref_type' => 'replenishment','ref' => $replenishment_id,
								 'field' => 'sort_order','field_id' => $min_sort,'text' => $action);
				$this->mlogin->write_history($history);			

			}	
			if($action=="move_bottom"){
				$this->db->select('MAX(sort_order) AS max_sort');
				$this->db->where('zone_id',$zone_id);
				$this->db->from('vw_replenishment');	
				
				$max_sort = $this->db->get()->row()->max_sort;		
				$max_sort = ($max_sort==''? 0 : $max_sort);
				$max_sort++;
				 			
				$data['sort_order'] = $max_sort;
				$this->db->where('replenishment_id',$replenishment_id);
				$this->db->update('replenishment',$data);		
				
				$this->db->query('UPDATE vw_replenishment SET sort_order = sort_order +1 WHERE sort_order <='.$sort_order.' AND zone_id='.$zone_id);
				
				$history = array('status_id' => PF_REPLENISHMENT_MOVE_BOTTOM,'ref_type' => 'replenishment','ref' => $replenishment_id,
								 'field' => 'sort_order','field_id' => $max_sort,'text' => $action);
				$this->mlogin->write_history($history);			
			}	
						
		}
		
		
	}

	public function get_replenishments($rep_status="",$in_zone_id=0)
	{
		$zone_id = 0;
		$this->db->select('*');
		$this->db->from('sys_user');
		$this->db->where('user_id',$this->session->userdata("user_id"));
		$result = $this->db->get();
		if($result->num_rows()>0){
			$zone_id = $result->row()->zone_id;	
		}

		if($in_zone_id>0){
			$zone_id = $in_zone_id;	
		}
		
		$wms_db = $this->load->database("gtl",true);

		$this->db->select('*');
		$this->db->from('vw_replenishment');
		
		if($rep_status!="") $this->db->where('rep_status',$rep_status);	
		if(strtoupper($rep_status)== "PENDING"){ 
			//$this->db->where('ppq > ',0);
			$this->db->where('current_inventory > ',0);			
		}
		
		if($zone_id>0) $this->db->where('zone_id',$zone_id);

		$this->db->order_by('zone','ASC');
		$this->db->order_by('sub_zone','ASC');
		$this->db->order_by('ppq','DESC');
		$result = $this->db->get();
		
		return $result;
		
	}

	public function get_filtered_locations_list()
	{
		$this->db->select('*');
		$this->db->from('vw_location_map');
		$this->db->where('zone_id', 8);
		return $this->db->get();
		
	}

    
	public function get_filtered_product_list($product_ids,$client_code="")
	{
		$this->db->select('*');
		$this->db->from('product');
		$this->db->or_where_in('product_id', $product_ids);

		return $this->db->get();
		
	}

	
	public function get_stacking_norms()
	{
		$this->db->select('product.product_id,product.description,product_stack_norm.lps,product_stack_norm.ppl,product_stack_norm.zone,product_stack_norm.pps,product_stack_norm.product_stack_type_id,product_stack_norm.zone_id,product_stack_norm.handling_quantity');
		$this->db->limit(500,0);
		$this->db->from('product_stack_norm');
		$this->db->join('product','product.product_id = product_stack_norm.product_id');
		//$this->db->order_by("product_id", "asc");
         
							 
               return $this->db->get();
	}

	public function get_product_stack_type()
	{
		$this->db->select('product_stack_type.*');
		$this->db->from('product_stack_type');
		return $this->db->get();
		
		
		
		
		
	}
	
	public function update_product_stack($data)
	{
		$product_id = $data['product_id'];
		$delete = $data['delete'];
		unset($data['product_id'],$data['delete']);

		$this->db->where('product_id',$product_id);		
		if($delete==1)
			$this->db->delete('product_stack_norm',$data);
		else
			$this->db->update('product_stack_norm',$data);
	}




	public function add_product_stack($data)
	{
		$this->db->insert('product_stack_norm',$data);
	}

	
	public function get_current_inventory()
	{
		$this->db->select('vw_location_inventory.*');
		$this->db->from('vw_location_inventory');

		return $this->db->get();		
	}
	public function current_inventory_pid()
	{
		$this->db->select('vw_current_inventory_pid.*');
		$this->db->from('vw_current_inventory_pid');

		return $this->db->get();		
	}		
	
	
	public function get_stacking_norm_adherence()
	{
		$this->db->select('vw_staking_norm_adherence.*');
		$this->db->from('vw_staking_norm_adherence');
		return $this->db->get();		
	}

	public function get_sub_zone_list($zone_id,$zones_group_id,$sub_zone_id)
	{
		$this->db->select('vw_sub_zone.*');
		$this->db->from('vw_sub_zone');
		if($zone_id!=0){	
			if($zone_id!=""){
				$this->db->where('zone_id',$zone_id);
			}
		
			if($zones_group_id!=""){
				$this->db->where('sub_zone_group_id',$zones_group_id);
			}	
			if($sub_zone_id !=""){
				$this->db->where('sub_zone_id',$sub_zone_id);
			}
		}
		return $this->db->get();		
	}
	
////////////////////////////////////////////////////////////////////
/*  		transactional function for count tables					  */
////////////////////////////////////////////////////////////////////	

	public function get_pid_count_quick_info($product_id='',$date=''){
		$this->db->select('vw_pid_count_quick_info.*');
		$this->db->where('product_id',$product_id);
		$this->db->where('date',$date);
		$this->db->from('vw_pid_count_quick_info');
		return $this->db->get();	
	}	

	public function get_pid_count_list($date_start='',$date_end=''){
		$this->db->select('product_id,date');
		$this->db->where('date >=',$date_start);
		$this->db->where('date <=',$date_end);
		$this->db->from('inventory_product_id_count');
		return $this->db->get();	
	}


	public function delete_pid_record($count_id=0){
		$this->db->where('count_id',$count_id);	
		$this->db->delete('inventory_product_id_count');	
	}	

	public function add_pid_record($data){
		$data['status_id'] = 1;
		$data['counting_type_id'] = 2;
		$this->db->insert('inventory_product_id_count',$data);	
		return $this->db->insert_id();
	}	


	public function add_location_count($data){
		$data['counting_type_id'] = 1;
		return $this->add_count_record($data);
	}	
	
	public function get_location_count_quick_info($sub_zone_id=0,$date=''){
		$this->db->select('vw_location_count_quick_info.*');
		$this->db->where('sub_zone_id',$sub_zone_id);
		$this->db->where('date',$date);
		$this->db->from('vw_location_count_quick_info');
		return $this->db->get();	
	}	


	public function get_location_count_list($date_start='',$date_end=''){
		$this->db->select('sub_zone_id,date');
		$this->db->where('date >=',$date_start);
		$this->db->where('date <=',$date_end);
		$this->db->from('vw_location_count_quick_info');
		return $this->db->get();	
	}	
	
////////////////////////////////////////////////////////////////////
/*  		master function for count tables					  */
////////////////////////////////////////////////////////////////////	

	private function add_count_record($data){
		$data['status_id'] = 1;
		$this->db->insert('inventory_count',$data);	
		return $this->db->insert_id();
	}
			
	public function delete_count_record($count_id=0){
		$this->db->where('inventory_count.count_id',$count_id);	
		$this->db->delete('inventory_count');	
	}
	
	public function get_inventory_count_status(){
		$this->db->select('*');
		$this->db->from('inventory_count_status');		
		return $this->db->get();	
	}

	public function get_scanning_clearks(){
		$this->db->select('user_id,epf_number,username,name,team');
		$this->db->from('sys_user');
		$this->db->join('sys_user_group','sys_user_group.user_group_id = sys_user.user_group_id');		
		$this->db->where('sys_user_group.const','SCANNER');
		$this->db->order_by('sys_user.epf_number');
		return $this->db->get();	
	}

	public function get_supervisor(){
		$this->db->select('user_id,epf_number,username,name');
		$this->db->from('sys_user');
		$this->db->join('sys_user_group','sys_user_group.user_group_id = sys_user.user_group_id');		
		$this->db->where('sys_user_group.const','SUPERVISOR');
		$this->db->order_by('sys_user.epf_number');
		return $this->db->get();	
	}

	public function get_tally_clearks(){
		$this->db->select('user_id,epf_number,username,name');
		$this->db->from('sys_user');
		$this->db->join('sys_user_group','sys_user_group.user_group_id = sys_user.user_group_id');		
		$this->db->where('sys_user_group.const','TALLY');
		$this->db->order_by('sys_user.epf_number');		
		return $this->db->get();	
	}
	
	public function get_count_info($count_id=0){
		$this->db->select('*');
		$this->db->from('inventory_count_info');	
		$this->db->where('count_id',$count_id);		
		return $this->db->get();	
	}	

	
/* -----------------------------------------------------------------*/
	public function get_sub_zones_to_set_scanners($date,$inventory_count_type_id=0){
	
		
		$this->db->select('inventory_count.*,lm_sub_zone.sub_zone,lm_sub_zone.zone_id,lm_zone.zone,inventory_count_type,sub_zone_group,count_status');
		$this->db->from('inventory_count');		
		$this->db->join('lm_sub_zone','lm_sub_zone.sub_zone_id = inventory_count.sub_zone_id');	
		$this->db->join('lm_zone','lm_zone.zone_id = lm_sub_zone.zone_id');	
		$this->db->join('inventory_count_type','inventory_count_type.inventory_count_type_id = inventory_count.counting_type_id');	
		$this->db->join('inventory_count_status','inventory_count_status.count_status_id = inventory_count.status_id');			
		$this->db->join('lm_sub_zone_group','lm_sub_zone_group.sub_zone_group_id = lm_sub_zone.sub_zone_group_id');			
		$this->db->where('inventory_count.date',$date);		
		$this->db->where('inventory_count.counting_type_id',$inventory_count_type_id);		
		return $this->db->get();	
		
	}

	public function import_pid_count_sub_zones($date = ""){
			$date = ($date==""?date("Y-m-d"):$date);	
			$this->db->select('*');
			$this->db->from('inventory_product_id_count');	
			$this->db->where('inventory_product_id_count.date',$date);	
			$this->db->where('inventory_product_id_count.status_id',1);	
			
			$pids_to_count = $this->db->get();
			foreach($pids_to_count->result()  as $record){
			
			$count_id = $record->count_id;
			$product_id = $record->product_id;
			$counting_type_id = $record->counting_type_id;
			$user_created = $record->user_created;
			$status_id = $record->status_id;
			
			$this->db->select('lm_location.sub_zone_id');
			$this->db->distinct();
			$this->db->from('location_inventory');	
			$this->db->join('lm_location','lm_location.location_id = location_inventory.location_id');	
			$this->db->where('location_inventory.product_id',$product_id);	
			$sub_zones_to_count = $this->db->get();
			if($sub_zones_to_count->num_rows() >0 ){
			$data = array();
			foreach($sub_zones_to_count->result()  as $sub_zone){
			$data = array('product_id' => $product_id,'user_assigned' =>0,'counting_type_id' =>$counting_type_id,
			'date' => $date,'user_created' => $user_created,'status_id' => $status_id,'sub_zone_id' => $sub_zone->sub_zone_id,
			'pid_count_id' => $count_id,'user_created' =>$user_created,);		
			$this->db->insert('inventory_count', $data); 	
			
			$data = array();
			$data = array('status_id' => 2,'user_assigned' => 0);	
			$this->db->where('count_id', $count_id);
			$this->db->update('inventory_product_id_count', $data); 
			}
			}else{
			$data = array();
			$data = array('status_id' => 5,'user_assigned' => 0);	
			$this->db->where('count_id', $count_id);
			$this->db->update('inventory_product_id_count', $data); 
			}
			
			}	
	}
	
	public function set_scanning_clearks($data){
			$count_id = $data['count_id'];
			$status_id = $data['status_id'];
			$sub_zone_id = $data['sub_zone_id'];
			$counting_type_id = $data['counting_type_id'];
			$product_id = $data['product_id'];
			$ret_val = '';
			
			unset($data['count_id']);
			unset($data['pid_count_id']);
			
			$this->db->where('count_id', $count_id);
			$this->db->update('inventory_count', $data); 
			
			$this->db->where('count_id', $count_id);
			$this->db->delete('inventory_count_detail'); 		
			
			
			if($status_id==2){
			$this->db->select('location_inventory.location_id,product_id,quantity');
			$this->db->from('location_inventory');
			$this->db->join('lm_location','lm_location.location_id = location_inventory.location_id');
			$this->db->where('lm_location.sub_zone_id',$sub_zone_id);
			
			if($counting_type_id==2) $this->db->where('location_inventory.product_id',$product_id);
			
			$details = $this->db->get();
			
			foreach($details->result() as $detail){
			$new_detail = array();
			if($detail->quantity>0){				
			$new_detail['count_id'] = $count_id;
			$new_detail['product_id'] = $detail->product_id;
			$new_detail['location_id'] = $detail->location_id;
			$new_detail['qty_inventory'] = $detail->quantity;
			
			$this->db->insert('inventory_count_detail',$new_detail);
			}
			}
			}
	}
	
	public function target_set_scanning_clearks($data){
		$count_id = $data['count_id'];
		$status_id = $data['status_id'];
		$sub_zone_id = $data['sub_zone_id'];
		$counting_type_id = $data['counting_type_id'];
		$product_id = $data['product_id'];
	
		$ret_val = '';
		unset($data['count_id']);
		unset($data['pid_count_id']);

		$this->db->select('*');
		$this->db->from('inventory_count_detail');
		$this->db->where('count_id',$count_id);	
		
		if($this->db->get()->num_rows()>0){
			$this->db->where('count_id', $count_id);
			$this->db->update('inventory_count', $data); 
		}else{ 
			$this->db->where('count_id', $count_id);
			$this->db->update('inventory_count', $data); 
			
			$this->db->where('count_id', $count_id);
			$this->db->delete('inventory_count_detail'); 		
	
			if($status_id==2){
				$this->db->select('*');
				$this->db->from('lm_location');
				$this->db->where('sub_zone_id',$sub_zone_id);			
				$details = $this->db->get();
				
				foreach($details->result() as $detail){
					$new_detail = array();
					$new_detail['count_id'] = $count_id;
					$new_detail['product_id'] = $product_id;
					$new_detail['location_id'] = $detail->location_id;
					$new_detail['qty_inventory'] = 0;	
					$this->db->insert('inventory_count_detail',$new_detail);
				}
			}
		}
	}
        
        public function update_stack_norms($update_data){
			$update_id=$update_data['update_id'] ;
			
			$pieces = explode("/",  $update_id);
			$pieces[0]; // piece1
			$pieces[1]; //   
			$update_value=$update_data['update_value'] ;
			$this->db->set($pieces[0], $update_value );
			$this->db->where('product_id', $pieces[1]);
			$this->db->update('product_stack_norm');   
			
			return 'OK';
			
			}
			public function get_zone(){
			
			$this->db->select("*");
			$this->db->from("lm_zone");
			return $this->db->get();
        }
		
		
	public function advance_search($product_ids,$zone,$sto)
	{
            
			$this->db->select(				'product.product_id,product.description,product_stack_norm.lps,product_stack_norm.ppl,product_stack_norm.zone,product_stack_norm.pps,product_stack_norm.product_stack_type_id,product_stack_norm.zone_id,product_stack_norm.handling_quantity');
			
			$this->db->from('product_stack_norm');
			$this->db->join('product','product.product_id = product_stack_norm.product_id');
			//$this->db->order_by("product_id", "asc");
			if($zone>0){ 
			$this->db->where('product_stack_norm.zone_id', $zone);  
			} 
			if($sto>0){  
			$this->db->where('product_stack_norm.product_stack_type_id', $sto);   
			}
			
			if(count($product_ids)>0){
			$this->db->where_in('product_stack_norm.product_id', $product_ids);
			}
			
			return $this->db->get();
         
	}     
	
	public function row_count($product_ids,$zone,$sto)
	{
            
			$this->db->select(				
			'product.product_id,product.description,product_stack_norm.lps,
			product_stack_norm.ppl,product_stack_norm.zone,product_stack_norm.pps,
			product_stack_norm.product_stack_type_id,product_stack_norm.zone_id,product_stack_norm.handling_quantity');
		
			$this->db->from('product_stack_norm');
			$this->db->join('product','product.product_id = product_stack_norm.product_id');
	
                 if($zone>0){ 
					$this->db->where('product_stack_norm.zone_id', $zone);  
				  } 
                 if($sto>0){  
				 	$this->db->where('product_stack_norm.product_stack_type_id', $sto);   
				  }
             	
				 if(count($product_ids)>0){
					$this->db->where_in('product_stack_norm.product_id', $product_ids);
				}
					$query=$this->db->get();
					$row_count=$query->num_rows();
               		return $row_count;
         
	}     
	
	
	public function pid_check($pid){
		$this->db->select('product_id');
		$this->db->where('product_id',$pid);
		$this->db->from('product_stack_norm');
		$query=$this->db->get();
		$row_count=$query->num_rows();
        return $row_count;
		
		
		}
	public function add_record($data_stack,$data_product){
			$this->db->insert('product_stack_norm',$data_stack);
			$this->db->insert('product',$data_product);
			
			return 1;
			
	}
	
	public function get_location(){
		$this->db->select('*');
		$this->db->from('lm_location');
		$query=$this->db->get();
		return $query->result();	
		
		
	}	
	
	
	public function set_target_count($sub_zone_id,$day_count,$number_count){
		$this->db->set('sub_zone_id',$sub_zone_id);
		$this->db->set('date',$day_count);
		$this->db->set('user_assigned',0);
		$this->db->set('user_created',$this->session->userdata("user_id"));
		$this->db->set('status_id',1);
		$this->db->set('counting_type_id',3);
		$this->db->set('product_id');
		$this->db->set('pid_count_id',0);
		$this->db->set('count_number',$number_count);
		$this->db->insert('inventory_count');	
		return $this->db->insert_id();
	
	}
	
	public function delete_target_count($count_id){
		$this->db->select("user_assigned");
		$this->db->from('inventory_count');
		$this->db->where('count_id',$count_id);
		$query = $this->db->get();
		$row = $query->row();
			if($row->user_assigned==0){
					
				$this->db->where('count_id', $count_id);
				$this->db->delete('inventory_count'); 
				$this->db->where('count_id', $count_id);
				$this->db->delete('inventory_count_detail'); 				
				return;
			}else{
				return 0;
			}
	}
	
	public function pid_popup_data($date,$zone_id,$sub_zone_group_id,$sub_zone_id){

    	$query=$this->db->query("CALL sp_target_count_column_summary('$date',$zone_id,$sub_zone_group_id,$sub_zone_id)"); 	
		return  $query;

	}

	public function set_target_shedual($date,$count_number){
		$this->db->select("*");
			if($count_number>0){
		$this->db->where ('count_number',$count_number);	
			}else{
		$this->db->where ('count_number!=',0);
			}
		$this->db->where ('date',$date);
		$this->db->from('vw_target_count_quick_info');
		$query=$this->db->get();
		return $query->result();	
	
	}
	public function get_sub_zones_to_set_scanners_to_target($date,$inventory_count_type_id=3){
		$this->db->select('inventory_count.*,inventory_count_type.inventory_count_type_id,lm_sub_zone.sub_zone,lm_sub_zone.zone_id,lm_zone.zone,inventory_count_type,sub_zone_group,count_status,sort_order');
		$this->db->from('inventory_count');		
		$this->db->join('lm_sub_zone','lm_sub_zone.sub_zone_id = inventory_count.sub_zone_id');	
		$this->db->join('lm_zone','lm_zone.zone_id = lm_sub_zone.zone_id');	
		$this->db->join('inventory_count_type','inventory_count_type.inventory_count_type_id = inventory_count.counting_type_id');	
		$this->db->join('inventory_count_status','inventory_count_status.count_status_id = inventory_count.status_id');			
		$this->db->join('lm_sub_zone_group','lm_sub_zone_group.sub_zone_group_id = lm_sub_zone.sub_zone_group_id');			
		$this->db->where('inventory_count.date',$date);		
		///$this->db->where('inventory_count.counting_type_id',$inventory_count_type_id);		
		return $this->db->get();	
		
	}
	
	public function target_location_excel($c_number,$s_date){
		$this->db->select("*");
		$this->db->from("vw_target_location_excel");	
		$this->db->where("date",$s_date);
		$this->db->where("counting_type_id",3);
		$this->db->where("is_counted",2);
		$query=$this->db->get();


		return $query->result();
	
	}
	public function target_location_excel1($c_number,$s_date){
		$this->db->select("*");
		$this->db->from("vw_target_location_excel");	
		$this->db->where("date",$s_date);
		$this->db->where("counting_type_id",3);
		$this->db->where("is_counted",1);
		$query=$this->db->get();
		return $query->result();
	
	}
	
	public function client_inventory(){
	$this->db->select('*');
	$this->db->from("vw_client_inventory");	
	$query=$this->db->get();
	return $query->result();
	
	}
	
	public function add_client_data($data_sto){
		  $this->db->select('*');
          $this->db->where('product_id', $data_sto['product_id']);
          $this->db->from('client_inventory');
       if($this->db->get()->num_rows() > 0) {
          $this->db->set('quantity', $data_sto['quantity']);
		  $this->db->where('product_id', $data_sto['product_id']);
          $this->db->set('datetime', 'NOW()', FALSE);
          $this->db->update('client_inventory');
     }else{
		  $this->db->set('product_id', $data_sto['product_id']);
		  $this->db->set('quantity', $data_sto['quantity']);
		  $this->db->set('datetime', 'NOW()', FALSE);
		  $this->db->insert('client_inventory');
		 }
	  
	
	}
	
	public function add_c_cat_data($data_sto){
			$this->db->reconnect();
			$this->db->select('product_id');
        	$this->db->where('product_id', $data_sto['product_id']);
        	$this->db->from('product');
       if ($this->db->get()->num_rows() > 0) {
		   $this->db->reconnect();
			$this->db->set('volume', $data_sto['volume']);
			$this->db->set('weight', $data_sto['weight']);
			$this->db->set('client_status', $data_sto['client_status']);
			$this->db->where('product_id', $data_sto['product_id']);
			$this->db->set('description', $data_sto['description']);
		    $this->db->update('product');
     }else{
		 $this->db->reconnect();
		 	$this->db->set('description', $data_sto['description']);
			$this->db->set('volume', $data_sto['volume']);
			$this->db->set('weight', $data_sto['weight']);
			$this->db->set('client_status', $data_sto['client_status']);
			$this->db->set('product_id', $data_sto['product_id']);
		 	$this->db->insert('product');
		
		 }
	  
	}
	
	public function target_recount($current_number,$sub_zone_id,$select_date,$location_id,$product_id){
		$db_insert_id;
		$this->db->select('*');
      	$this->db->where('sub_zone_id', $sub_zone_id);
		$this->db->where('count_number', $current_number);
		$this->db->where('date', $select_date);
		$this->db->where('counting_type_id',3);
		$this->db->where('status_id>',3);
		$this->db->from('inventory_count');
		if($this->db->get()->num_rows() > 0){
		$this->db->select('*');
      	$this->db->where('sub_zone_id', $sub_zone_id);
		//$this->db->where('count_number', $current_number);
		$this->db->where('date', $select_date);	
		$this->db->where('counting_type_id',3);
		$this->db->from('inventory_count');	
		$this->db->order_by('count_number','desc');	
		$query=$this->db->get();	
		foreach($query->result() as $querys){
		$db_insert_id=$querys->count_id;	
		
				//insert inventory_count
			if($querys->status_id>1){
			$this->db->set('sub_zone_id',$sub_zone_id);
			$this->db->set('date',$select_date);
			$this->db->set('user_assigned',0);
			$this->db->set('user_created',1);
			$this->db->set('status_id',1);
			$this->db->set('counting_type_id',3);
			$this->db->set('product_id','');
			$this->db->set('pid_count_id',0);
			$this->db->set('count_number',$querys->count_number+1);
			$this->db->insert('inventory_count');
			$db_insert_id=$this->db->insert_id();
			
			//insert inventory_count_details
			
			$this->db->select('*');
      		$this->db->where('location_id', $location_id);
			$this->db->where('product_id', $product_id);
			$this->db->from('location_inventory');
			$query=$this->db->get();
			foreach($query->result() as $location_inven){
			
			$this->db->set('count_id',$db_insert_id);
			$this->db->set('location_id',$location_id);
			$this->db->set('product_id',$location_inven->product_id);
			$this->db->set('qty_inventory',$location_inven->quantity);
			$this->db->set('qty_booked',0);
			$this->db->set('qty_counted',0);
			$this->db->set('date_time_inventory','');
			$this->db->set('date_time_counted','');
			$this->db->set('pallet_code','');
			$this->db->set('is_counted',0);
			$this->db->insert('inventory_count_detail');

			}
			return 1;
				}else{
		
		$this->db->select('*');
      	$this->db->where('count_id', $db_insert_id);
		$this->db->where('location_id', $location_id);	
		$this->db->where('product_id', $product_id);		
		$this->db->from('inventory_count_detail');
		if($this->db->get()->num_rows() > 0){	
					
					}else{
			$this->db->select('*');
      		$this->db->where('location_id', $location_id);
			$this->db->where('product_id', $product_id);
			$this->db->from('location_inventory');
			$query=$this->db->get();
			foreach($query->result() as $location_inven){
			
			$this->db->set('count_id',$db_insert_id);
			$this->db->set('location_id',$location_id);
			$this->db->set('product_id',$location_inven->product_id);
			$this->db->set('qty_inventory',$location_inven->quantity);
			$this->db->set('qty_booked',0);
			$this->db->set('qty_counted',0);
			$this->db->set('date_time_inventory','');
			$this->db->set('date_time_counted','');
			$this->db->set('pallet_code','');
			$this->db->set('is_counted',0);
			$this->db->insert('inventory_count_detail');

			}			
			return 2;			
			}	
			}	
			
			}
		
		}else{
		return 4;	
		}
		
		
		
			//return 1;
	}
	
	public function add_stacking_norm_non_pid($product_ids1){
		
		//array_push($product_ids1,"0");
		$p_size=sizeof($product_ids1);
		for($x=0;$p_size>$x;$x++){
			$this->db->select('*');
			$this->db->where('product_id',$product_ids1[$x]);
			$this->db->from('product_stack_norm');
			if($this->db->get()->num_rows() > 0) {
			
			
			}else{
				$this->db->select('*');
				$this->db->where('product_id',$product_ids1[$x]);
				$this->db->from('product');	
			if($this->db->get()->num_rows() > 0) {
			
				$this->db->set('product_id',$product_ids1[$x]);
				$this->db->set('product_stack_type_id','');
				$this->db->set('ppl','');
				$this->db->set('lps','');
				$this->db->set('pps','');
				$this->db->set('zone','');
				$this->db->set('zone_id','');
				$this->db->set('handling_quantity','');
				$this->db->insert('product_stack_norm');
				
			}else{}
				}
		
		}
	}
	
	public function error_record (){
		$this->db->select('product.product_id,product.description,product_stack_norm.lps,product_stack_norm.ppl,product_stack_norm.zone,product_stack_norm.pps,product_stack_norm.product_stack_type_id,product_stack_norm.zone_id,product_stack_norm.handling_quantity');
		$this->db->limit(200,0);
		$this->db->from('product_stack_norm');
		$this->db->join('product','product.product_id = product_stack_norm.product_id');
		$this->db->where('product_stack_norm.handling_quantity',0);	
		$this->db->or_where('product_stack_norm.zone_id', 0); 
		$this->db->or_where('product_stack_norm.product_stack_type_id', 0); 
		$query=$this->db->get();
		return $query->result();	
	
	}
	public function error_record_count (){
		$this->db->select('*');
		$this->db->where('handling_quantity',0);	
		$this->db->or_where('zone_id', 0); 
		$this->db->or_where('product_stack_type_id', 0); 
		$this->db->from('product_stack_norm');	
		return $this->db->get()->num_rows() ;
		
	
	}
	
	public function pid_count_excel($date){
		$this->db->select('*');
		$this->db->where('date',$date);	
		$this->db->where('counting_type_id',2);	
		$this->db->where('is_counted',2);
		$this->db->from('vw_target_location_excel');	
		$query=$this->db->get() ;
		return $query->result();
	
	}
	public function pid_count_excel_error($date){
		$this->db->select('*');
		$this->db->where('date',$date);	
		$this->db->where('counting_type_id',2);	
		$this->db->from('vw_target_location_excel');	
		$query=$this->db->get() ;
		return $query->result();
	
	}
	
	
	public function locatoin_to_excel($date){
		$this->db->select('*');
		$this->db->where('date',$date);	
		$this->db->where('counting_type_id',1);	
		$this->db->where('is_counted',2);
		$this->db->from('vw_target_location_excel');	
		$query=$this->db->get() ;
		return $query->result();
	
	}
	public function locatoin_to_excel_error($date){
		$this->db->select('*');
		$this->db->where('date',$date);	
		$this->db->where('counting_type_id',1);	
		$this->db->from('vw_target_location_excel');	
		$query=$this->db->get() ;
		return $query->result();
	
	}
	
	public function locaiton_popup_data($tc,$date){
		$this->db->select('*');
		$this->db->where('sub_zone_id',$tc);
		$this->db->where('date',$date);
		$this->db->where('is_counted',2);
		$this->db->from('vw_location_popup');
		$this->db->order_by("sub_zone","ASC");
		$this->db->order_by("location","ASC");
	    $this->db->order_by("product_id","ASC");
		
		$query=$this->db->get();
		return $query->result();		
	}
		public function test(){
			$this->db->select('*');
			$this->db->from('vw_target_count_quick_info');
			return $query=$this->db->get();
		
		}
		
		public function print_bar($pallet_corde_id){
			$this->db->select("pallet_barcode.*,lm_location.location,product_stack_norm.pps,product_stack_norm.handling_quantity");
			$this->db->from('pallet_barcode');
			$this->db->join("lm_location","lm_location.location_id = pallet_barcode.location_id","left outer");
			$this->db->join("product_stack_norm","product_stack_norm.product_id = pallet_barcode.product_id","left outer");
			$this->db->where_in('pallet_code',$pallet_corde_id);
			$query = $this->db->get();  
			return $query->result();
			
		}
		
		public function disable_master_count($condition,$date){
			$this->db->set('is_disabled',$condition);
			$this->db->where('date',$date);
			$this->db->where('counting_type_id',3);
			$this->db->update('inventory_count');
			return 1;	
		
		}	
	
		public function disable_child_count($condition,$date,$sub_zone_id){
			$this->db->set('is_disabled',$condition);
			$this->db->where('date',$date);
			$this->db->where('counting_type_id',3);
			$this->db->where('sub_zone_id',$sub_zone_id);
			$this->db->update('inventory_count');
			return 1;	
		
		}		
		
		public function master_disabled_load($date){
			$this->db->select('*');
			$this->db->where('date',$date);
			$this->db->where('counting_type_id',3);
			$this->db->where('is_disabled',1);
			$this->db->from('inventory_count');
			$query=$this->db->get();
			return $query->result();	
		
		
		}
	
		public function print_advance_barcode($option,$zone_id,$asn_number){
		
			$this->db->select('pallet_barcode.product_id,
								pallet_barcode.pallet_code,
								pallet_barcode.wms_user,
								pallet_barcode.user_id,
								pallet_barcode.datetime,
								pallet_barcode.transaction,
								pallet_barcode.check_digit,
								pallet_barcode.table,
								pallet_barcode.field,
								pallet_barcode.field_value,
								pallet_barcode.quantity,
								pallet_barcode.zone_id,
								pallet_barcode.location_id,
								product_stack_norm.handling_quantity');
			$this->db->from('pallet_barcode');
			$this->db->join('product_stack_norm','product_stack_norm.product_id=pallet_barcode.product_id');
			$this->db->where('transaction',$asn_number);	
			
			if($option=='f'){
				$this->db->where('pallet_barcode.quantity = product_stack_norm.handling_quantity');	
				$this->db->where('pallet_barcode.product_id = product_stack_norm.product_id');
			
			}else if($option=='p'){	
				$this->db->where('pallet_barcode.quantity <> product_stack_norm.handling_quantity');	
				$this->db->where('pallet_barcode.product_id = product_stack_norm.product_id');
			}
			
			if(sizeof($zone_id)>0){
				if($zone_id[0]!=''){	
					$this->db->where_in('pallet_barcode.zone_id',$zone_id);	
				}
			}

			$query = $this->db->get();  
			return $query->result();
		}
	
	
	public function product_count_list($date){
	
		$this->db->select('*');
		$this->db->from('vw_product_count');
		$this->db->where('date',$date);
		$this->db->where('counting_type_id',2);
		return $this->db->get();
		
	
	}
	
	public function product_count_list_add_search($date,$pid){
	
		if($pid==""){
			$this->db->select('*');
		
			$this->db->from('vw_product_count');
			$this->db->where('date',$date);
			$this->db->where('counting_type_id',2);
			$this->db->group_by('sub_zone');
			$this->db->group_by('product_id');
			return $this->db->get();
		}else{
			$this->db->select('*');
			$this->db->from('vw_product_count');
			$this->db->where('product_id',$pid);
			$this->db->where('counting_type_id',2);
			$this->db->group_by('sub_zone');
			$this->db->group_by('product_id');
			$result=$this->db->get();
			
				if($result->num_rows()>0){
					return $result;
				}else{

					$this->db->select('lm_sub_zone.sub_zone,lm_location.sub_zone_id,location_inventory.product_id,Sum(location_inventory.quantity) AS quantity');
					$this->db->from('location_inventory');
					$this->db->join('lm_location','lm_location.location_id = location_inventory.location_id');	
					$this->db->join('lm_sub_zone','lm_sub_zone.sub_zone_id = lm_location.sub_zone_id');		
					$this->db->where('product_id',$pid);
					$this->db->group_by('lm_location.sub_zone_id');
					$result=$this->db->get();	
				
						if($result->num_rows()>0){
							
							foreach($result->result() as $results){
								
								$this->db->set('sub_zone_id',$results->sub_zone_id);
								$this->db->set('date',$date);
								$this->db->set('user_assigned',0);
								$this->db->set('user_created',$this->session->userdata("user_id"));
								$this->db->set('status_id',1);
								$this->db->set('counting_type_id',2);
								$this->db->set('product_id',$results->product_id);
								$this->db->set('pid_count_id',0);
								$this->db->set('count_number',1);
								$this->db->insert('inventory_count');
								
							}
						
									$this->db->select('*');
									$this->db->from('vw_product_count');
									$this->db->where('date',$date);
									$this->db->where('product_id',$pid);
									$this->db->where('counting_type_id',2);
									
									return $this->db->get();
								
						}
				}
		}
	}



	public function zone_list(){
		$this->db->select('*');
		$this->db->from('lm_zone');
				
		return $this->db->get();
	
	}
	
	public function sub_zone_group_list($zones_id){
		$this->db->select('*');
		$this->db->from('lm_sub_zone_group');
		$this->db->where('zone_id',$zones_id);		
		return $this->db->get();
	
	}
	
	
	public function sub_zone_list($zones_group_id){
		$this->db->select('*');
		$this->db->from('lm_sub_zone');
		$this->db->where('sub_zone_group_id',$zones_group_id);		
		return $this->db->get();
	
	}

	public function add_count_location($date,$pid,$value,$field_name){
		
					$this->db->select('location_inventory.product_id,location_inventory.quantity,lm_location.location_id,lm_location.location,lm_sub_zone.sub_zone_id,lm_sub_zone.sub_zone,lm_sub_zone_group.sub_zone_group_id,lm_sub_zone_group.sub_zone_group,lm_zone.zone_id,lm_zone.zone');
					$this->db->from('location_inventory');
					$this->db->join('lm_location','location_inventory.location_id = lm_location.location_id');	
					$this->db->join('lm_sub_zone','lm_location.sub_zone_id = lm_sub_zone.sub_zone_id');	
					$this->db->join('lm_sub_zone_group','lm_sub_zone.sub_zone_group_id = lm_sub_zone_group.sub_zone_group_id');	
					$this->db->join('lm_zone','lm_zone.zone_id= lm_sub_zone_group.zone_id');		
					
					$this->db->where($field_name,$value);
					$this->db->group_by('lm_sub_zone.sub_zone_id');
					$result=$this->db->get();
				
					if($result->num_rows()>0){
						foreach($result->result() as $results){
								
							
								$this->db->select('*');
								$this->db->from('inventory_count');
								$this->db->where('product_id',$pid);
								$this->db->where('sub_zone_id',$results->sub_zone_id);
								$this->db->where('status_id>',1);
								$this->db->where('counting_type_id',2);				
								$this->db->order_by('count_number','DESC');
								$query=$this->db->get();
								
								
								if($query->num_rows()>0){
									$row=$query->row();
					
									$this->db->set('sub_zone_id',$results->sub_zone_id);
									$this->db->set('date',$date);
									$this->db->set('user_assigned',0);
									$this->db->set('user_created',$this->session->userdata("user_id"));
									$this->db->set('status_id',1);
									$this->db->set('counting_type_id',2);
									$this->db->set('product_id',$pid);
									$this->db->set('pid_count_id',0);
									$this->db->set('count_number',$row->count_number+1);
									$this->db->set('count_all_location',0);
									$this->db->insert('inventory_count');						
							
								}else{
								
									$this->db->select('*');
									$this->db->from('inventory_count');
									$this->db->where('product_id',$pid);
									$this->db->where('sub_zone_id',$results->sub_zone_id);
									$this->db->where('counting_type_id',2);		
									$query=$this->db->get();
										if($query->num_rows()>0){
											
											
										}else{
									
											$this->db->set('sub_zone_id',$results->sub_zone_id);
											$this->db->set('date',$date);
											$this->db->set('user_assigned',0);
											$this->db->set('user_created',$this->session->userdata("user_id"));
											$this->db->set('status_id',1);
											$this->db->set('counting_type_id',2);
											$this->db->set('product_id',$pid);
											$this->db->set('pid_count_id',0);
											$this->db->set('count_number',1);
											$this->db->set('count_all_location',0);
											$this->db->insert('inventory_count');
										}
									}								
							}	
					
					}else{
						return "No Recodes";
					}
				
	}
	
	public function product_count_row_delete($date,$condition,$count_id){
	
		$this->db->select('*');
		$this->db->from('inventory_count_detail');
		$this->db->where('count_id',$count_id);
		$query=$this->db->get();
			if($query->num_rows()>0){
				$this->db->where('count_id', $count_id);
				$this->db->delete('inventory_count_detail'); 		
			}
		
		$this->db->where('count_id', $count_id);
		$this->db->delete('inventory_count'); 
	
	}
	
	public function count_all_location($date,$condition,$count_id){
	
		$this->db->select('*');
		$this->db->from('inventory_count');
		$this->db->where('count_id',$count_id);
		$query=$this->db->get();
			if($query->num_rows()>0){
				$this->db->set('count_all_location',$condition);
				$this->db->where('count_id', $count_id);
				$this->db->where('date', $date);
				$this->db->update('inventory_count'); 		
			}
	
	}
	
	public function target_set_scanning_clearks_with_inventory($data){
		$count_id = $data['count_id'];
		$status_id = $data['status_id'];
		$sub_zone_id = $data['sub_zone_id'];
		$counting_type_id = $data['counting_type_id'];
		$product_id = $data['product_id'];
	
		$ret_val = '';
		unset($data['count_id']);
		unset($data['pid_count_id']);

		$this->db->select('*');
		$this->db->from('inventory_count_detail');
		$this->db->where('count_id',$count_id);	
		
		if($this->db->get()->num_rows()>0){
			$this->db->where('count_id', $count_id);
			$this->db->update('inventory_count', $data); 
		}else{ 
			$this->db->where('count_id', $count_id);
			$this->db->update('inventory_count', $data); 
			
			$this->db->where('count_id', $count_id);
			$this->db->delete('inventory_count_detail'); 		
	
			if($status_id==2){
				$this->db->select('lm_location.sub_zone_id,lm_sub_zone.sub_zone,location_inventory.location_id,location_inventory.product_id');
				$this->db->join('lm_location','lm_location.location_id = location_inventory.location_id');
				$this->db->join('lm_sub_zone','lm_sub_zone.sub_zone_id = lm_location.sub_zone_id');
				$this->db->from('location_inventory');
				$this->db->where('product_id',$product_id);		
				$this->db->where('lm_location.sub_zone_id',$sub_zone_id);			
				
				$details = $this->db->get();
			
				foreach($details->result() as $detail){
					$new_detail = array();
					$new_detail['count_id'] = $count_id;
					$new_detail['product_id'] = $product_id;
					$new_detail['location_id'] = $detail->location_id;
					$new_detail['qty_inventory'] = 0;	
					$this->db->insert('inventory_count_detail',$new_detail);
				}
			}
		}
	
	}
	
	public function pid_validate($pid){
		$this->db->select('product_id');
		$this->db->from('product_stack_norm');
		$this->db->where('product_id',$pid);	
		
		if($this->db->get()->num_rows()>0){
			return 1;
		}else{
			return 0;
		}

	
	}
	
	public function pid_popup_detail($ds,$zone_id,$sub_zone_group_id,$sub_zone_id){
	$query=$this->db->query("CALL sp_pid_count_summary('$ds',$zone_id,$sub_zone_group_id,$sub_zone_id)"); 	
		return  $query;
	
	}
	
	public function pid_location_excel($s_date){
		$this->db->select("*");
		$this->db->from("vw_target_location_excel");	
		$this->db->where("date",$s_date);
		$this->db->where("counting_type_id",2);
		$this->db->where("is_counted",2);
		$query=$this->db->get();
		return $query->result();
	
	}
	
	public function check_count_info($location_name){
				
		$this->db->select("location,sub_zone_id,location_id");
		$this->db->from("lm_location");	
		$this->db->where("location",$location_name);
		$query=$this->db->get();
			
			if($query->num_rows()>0){
				$row = $query->row();
				return $row->sub_zone_id."?".$row->location_id;
			}else{
				return "1?1";
			}
	}
	
	public function new_location_assign($data){
		
		$this->db->select("*");
		$this->db->from("inventory_count");	
		$this->db->where("sub_zone_id",$data['sub_zone_id']);
		$this->db->where("date",$data['date']);
		$this->db->where("counting_type_id",$data['counting_type']);
		$this->db->where("reference",$data['ref_val']);
		$this->db->order_by('count_number','desc');
		$query=$this->db->get();
		
			if($query->num_rows()>0){
				$row = $query->row();
				$this->db->select("*");
				$this->db->from("inventory_count_detail");	
				$this->db->where("location_id",$data['location_id']);
				$this->db->where("count_id",$row->count_id);
				$query1=$this->db->get();
					
					if($query1->num_rows()>0){
						return "Already Counted please initiate recount";
					}else{
			
						$this->db->set("status_id","2");
						//$this->db->set("reference",$data['ref_val']);
						$this->db->where("count_id",$row->count_id);
						$this->db->update('inventory_count');
				
						
					$data_inventory_detail = array(
						"count_id"=>$row->count_id, 
						"location_id"=>$data['location_id'], 
						"product_id"=>$data['pid'],
						"qty_inventory"=>0,
						"qty_booked"=>0,
						"qty_scanned"=>"0",
						"qty_counted"=>"0",
						"date_time_inventory"=>"",
						"date_time_counted"=>"",
						"pallet_code"=>"",
						"is_counted"=>0,
						);	
						
						$this->db->insert('inventory_count_detail',$data_inventory_detail);	
						return 1;
					}
				
			}else{
				
				
				$data_inventory = array(
						"sub_zone_id"=>$data['sub_zone_id'], 
						"date"=>$data['date'], 
						"user_assigned"=>'',
						"user_created"=>$this->session->userdata("user_id"),
						"status_id"=>2,
						"counting_type_id"=>$data['counting_type'],
						"product_id"=>$data['pid'],
						"pid_count_id"=>'',
						"count_number"=>1,
						"is_disabled"=>'',
						"count_all_location"=>'',
						"reference"=>$data['ref_val'],
						);	
					$this->db->insert('inventory_count',$data_inventory);
					$inser_id = $this->db->insert_id() ;
				
				$data_inventory_detail = array(
						"count_id"=>$inser_id, 
						"location_id"=>$data['location_id'], 
						"product_id"=>$data['pid'],
						"qty_inventory"=>0,
						"qty_booked"=>0,
						"qty_scanned"=>"0",
						"qty_counted"=>"0",
						"date_time_inventory"=>"",
						"date_time_counted"=>"",
						"pallet_code"=>"",
						"is_counted"=>0,
						);	
						
						$this->db->insert('inventory_count_detail',$data_inventory_detail);	
						return 1;
			}
	}
	
	public function location_assign_list($date){
		$this->db->select('*');
		$this->db->from('vw_location_assigner');
		$this->db->where('date',$date);
		return $this->db->get();
	
	}
	
	public function pick_list($pick_number){
		$this->db->select('*');
		
		if($pick_number!=0){
			$this->db->where('pick_number',$pick_number);	
		}
		$this->db->from('vw_pick_list');
		return $this->db->get();	
		
	}
	public function pick_details($pick_number,$zone_id){
		$this->db->select('*');
		$this->db->where('pick_number',$pick_number);	
		if($zone_id>0){
			$this->db->where('zone_id',$zone_id);	
		}
		$this->db->from('vw_pick_details');
		$this->db->order_by('sort_order','asc');
		return $this->db->get();	
			
	}
	public function set_sort_order($pick_detail_id,$sort_val){
	
		$this->db->set('sort_order',$sort_val);
		$this->db->where('pick_detail_id',$pick_detail_id);
		$this->db->update('pick_detail');
	
	}
	
	public function pick_ticket_zone_list ($pick_number){
		
		$this->db->select('zone,zone_id');
		$this->db->where('pick_number',$pick_number);	
		$this->db->from('vw_pick_details');
		$this->db->group_by('zone_id');
		return $this->db->get();		
	}
	
	public function set_scanner_sort_order($count_id,$sort_value){
		
		$this->db->set('sort_order',$sort_value);
		$this->db->where('count_id',$count_id);
		$this->db->update('inventory_count');
	}
	
	public function job_list($job_number){
		
		$this->db->select('*');
		$this->db->from('vw_job_list');
		if($job_number!=0){
			$this->db->where('job_id',$job_number);	
		}
		return $this->db->get();		
	
	}
	public function assembly_job($job_id){
		
		$this->db->select('*');
		$this->db->from('assembly_job');
		
			$this->db->where_in('job_id',$job_id);	
	
		return $this->db->get();		
	
	}
	
	public function assembly_job_id($job_id){
		
		$this->db->select('assembly_job_id');
		$this->db->from('assembly_job');
		
			$this->db->where_in('job_id',$job_id);	
	
		return $this->db->get();		
	
	}
	public function assembly_job_details($assembly_job_id){
		
		$this->db->select('*');
		$this->db->from('assembly_job_detail');
		
			$this->db->where_in('assembly_job_id',$assembly_job_id);	
	
		return $this->db->get();		
	
	}
	
	public function set_scanner_location_sort_order($locatoin_sort_value,$count_id ){
		
		$this->db->set('location_sort_order',$locatoin_sort_value);
		$this->db->where('count_id',$count_id);
		$this->db->update('inventory_count');
	}
	
	public function load_scanning_clearks($sub_zone_id,$date){
		
		$scanner_ids = array();
		
		$this->db->select('user_assigned,sub_zone_id,date');
		$this->db->from('inventory_count');
		$this->db->where('counting_type_id',3);
		$this->db->where('status_id>','2');
		$this->db->where('sub_zone_id',$sub_zone_id);
		$this->db->where('date',$date);
		$query = $this->db->get();	
		
		foreach($query->result() as $row ){
			array_push($scanner_ids,$row->user_assigned);
		}
		
		$this->db->select('user_id,epf_number,username,name,sys_user_group.user_group_id');
		$this->db->from('sys_user');
		$this->db->join('sys_user_group','sys_user_group.user_group_id = sys_user.user_group_id');		
		$this->db->where_in('user_id',$scanner_ids);
		$this->db->where('sys_user_group.const','SCANNER');
		$this->db->order_by('sys_user.epf_number');
		return $this->db->get();	//
	}
	
	public function ex_summary($zone_id,$date){
		$query=$this->db->query("CALL sp_count_location_status('$date',$zone_id)"); 	
		return  $query;	
		
	}
	
	public function count_report($dc){
	
		$query=$this->db->query("CALL sp_count_report('$dc')"); 	
		return  $query;	
			
	}
	public function sap_inventory($pid){
		$this->db->select('*');
		$this->db->from('client_inventory');
		$this->db->where('product_id',$pid);
		$query = $this->db->get();
		$row = $query->row();
		return $row->quantity;
	}
	
	public function ex_summary_sub_zone($date){

		$query=$this->db->query("CALL sp_count_sub_zone_status('$date')"); 	
		return  $query;
 	
	}
	
	public function ex_summary_sub_zone_group($date){

		$this->db->select('lm_sub_zone_group.sub_zone_group_id,lm_sub_zone_group.sub_zone_group,lm_sub_zone.sub_zone_id,lm_sub_zone.gsl_sub_zone,lm_sub_zone.sub_zone,lm_sub_zone.zone_id');
		$this->db->from('lm_sub_zone_group');
		$this->db->join('lm_sub_zone','lm_sub_zone_group.sub_zone_group_id = lm_sub_zone.sub_zone_group_id');
		$this->db->group_by('lm_sub_zone.zone_id,lm_sub_zone_group.sub_zone_group');
		$query = $this->db->get();
		return $query;
	}
	
	public function scanner_allocation($ds){
		$query=$this->db->query("CALL sp_scanner_allocation('$ds')"); 	
		return  $query;	
		
	
	}
	
	public function save_ref($count_id,$ref_val){
	
		$this->db->set('reference',$ref_val);
		$this->db->where('count_id',$count_id);
		$this->db->update('inventory_count');
		
	}
	public function ref_distribution($date,$epf,$ref){
		$this->db->reconnect();
		$query = $this->db->query("CALL sp_ref_distributor('$date','$epf','$ref')"); 	
		mysqli_next_result( $this->db->conn_id );
		return  $query;	
	
	}
	
	public function ref_details($date,$epf_number,$ref){
		$query=$this->db->query("CALL sp_ref_details('$date','$epf_number','$ref')"); 	
		return  $query;	
	
	
	}
	public function ref_distribution_head($date,$epf_number,$ref){
		$this->db->select('inventory_count.date,inventory_count.reference,sys_user.epf_number,inventory_count.count_id,,lm_sub_zone.sub_zone');
		$this->db->from('inventory_count');
		$this->db->join('inventory_count_detail','inventory_count_detail.count_id = inventory_count.count_id');
		$this->db->join('sys_user','sys_user.user_id = inventory_count.user_assigned');
		$this->db->join('lm_location','lm_location.location_id = inventory_count_detail.location_id');
		$this->db->join('lm_sub_zone','inventory_count.sub_zone_id = lm_sub_zone.sub_zone_id');
		$this->db->where('inventory_count.count_id',$count_id);
		$this->db->where('inventory_count.date',$date);
		$this->db->group_by('inventory_count.count_id');
		$query = $this->db->get();
		return $query;
	
	}
	
	public function  remove_recode_count_details($count_details_id){


		$this->db->select('*');
		$this->db->from ('inventory_count_detail');
		$this->db->where('count_detail_id', $count_details_id);
		$query = $this->db->get();
			if($query->num_rows() > 0){
				$row = $query->row();
				$count_id = $row->count_id;
				$location_id = $row->location_id;
					$this->db->select('inventory_count_detail.*,inventory_count.status_id');
					$this->db->from('inventory_count');
					$this->db->join('inventory_count_detail','inventory_count.count_id = inventory_count_detail.count_id');
					$this->db->where('inventory_count_detail.count_id', $count_id);
					$this->db->where('inventory_count_detail.location_id', $location_id);
					$cd = $this->db->get();
						if($cd->num_rows() == 1){
							if($cd->row()->is_counted == 2){
								$this->db->set('delete_epf',$this->session->userdata("epf_number"));
								$this->db->set('delete_date',date('Y-m-d h:i:sa'));
								$this->db->set('delete_name',$this->session->userdata("name"));
								$this->db->insert('inventory_count_detail_remove',$row);
								
								$this->db->set('product_id',"");
								$this->db->set('qty_inventory',0);
								$this->db->set('qty_booked',0);
								$this->db->set('qty_counted',0);	
								$this->db->set('qty_scanned',0);	
								$this->db->set('date_time_counted',NULL);
								$this->db->set('date_time_inventory',NULL);	
								$this->db->set('is_counted',0);
								$this->db->set('ip_address',NULL);																			
								$this->db->set('host_name',NULL);		
								$this->db->set('date_time_started',NULL);	
					
								$this->db->where('count_detail_id', $count_details_id);
								$this->db->update('inventory_count_detail');
								
								$this->db->set('status_id', 2);
								$this->db->where('count_id', $count_id);
								$this->db->update('inventory_count');								
								
																
							}else{
								echo 'Please make sure this count is marked as finished';	
							}
						}elseif($cd->num_rows() > 1){
							if($cd->row()->is_counted == 2){
								$this->db->set('delete_epf',$this->session->userdata("epf_number"));
								$this->db->set('delete_date',date('Y-m-d h:i:sa'));
								$this->db->set('delete_name',$this->session->userdata("name"));
								$this->db->insert('inventory_count_detail_remove',$row);							
								$this->db->where('count_detail_id', $count_details_id);
								$this->db->delete('inventory_count_detail'); 	
								
							}else{
								echo 'Please make sure this count is marked as finished';	
							}				
						}else{

						}
			}
	}
	public function get_open_reference($date){
		
		$this->db->select('*');
		$this->db->from ('inventory_count_reference');
		$this->db->where('is_released', 0);
		$this->db->where('date', $date);
		$query = $this->db->get();
		return $query;
	}
	
	public function reference_valide($ref_val){
		$this->db->select('*');
		$this->db->from ('inventory_count_reference');	
		$this->db->where('reference_number', $ref_val);
		$query = $this->db->get();
		$row = $query->row();
			if($row->is_released==0){
			return ""	;
			}else{
			return "Not Valide"	;
			}
		
	}
	
}
