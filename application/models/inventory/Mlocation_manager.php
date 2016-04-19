<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlocation_manager extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

	public function zone_list(){
		
		$this->db->select('*');
		$this->db->from('lm_zone');
		$query=$this->db->get();
		return $query->result();		
	}

	public function zone_delete($zone_id){
		
			$this->db->where('zone_id', $zone_id);
			$this->db->delete('lm_zone'); 
			
			$this->db->where('zone_id', $zone_id);
			$this->db->delete('lm_sub_zone'); 
			
			$this->db->where('zone_id', $zone_id);
			$this->db->delete('lm_sub_zone_group'); 
			return  'OK';
	}
                        
        	
	public function new_zone($zone_name){
		
			$this->db->set('zone', $zone_name);
			$this->db->set('warehouse_id', "1");
			$this->db->insert('lm_zone'); 
			return  'OK';
		}       
                        
	public function edit_zone($id,$name){
	
		$this->db->where('zone_id', $id);
		$this->db->set('zone',$name);
		$this->db->update('lm_zone');    
		return "OK";
	}
           
		public function edit_sub_zone_group($id,$name){
		
			$this->db->set('sub_zone_group',$name);
			$this->db->where('sub_zone_group_id', $id);
		   
			$this->db->update('lm_sub_zone_group');    
			return "OK";
		}
		public function edit_sub_zone_group_zone($id,$name){
		
			
			$this->db->set('zone_id',$name);
			$this->db->where('sub_zone_group_id', $id);
		   
			$this->db->update('lm_sub_zone_group');    
			return "OK";
		}
		
		public function sub_zone_gorup($zone_id){
			
			$this->db->select ('*');
			$this->db->where("zone_id",$zone_id);
			$this->db->from ('lm_sub_zone_group');
			$query=$this->db->get();
			return $query->result();
			
		}
		
		public function sub_zone_group_delete($zone_id){
	
			$this->db->where('sub_zone_group_id', $zone_id);
			$this->db->delete('lm_sub_zone'); 
			
			$this->db->where('sub_zone_group_id', $zone_id);
			$this->db->delete('lm_sub_zone_group'); 	
		
	   
		return  'OK';
	}
				
		public function sub_zone_group_add($zone_id,$sub_value){
			$this->db->set("sub_zone_group",$sub_value);
			$this->db->set("zone_id",$zone_id);
			$this->db->insert("lm_sub_zone_group");
			return "OK";
		}
	public function sub_zone($zone_id,$sub_zone_group_id){
                    
                $this->db->select ('*');
                $this->db->where("zone_id",$zone_id);
                if($sub_zone_group_id!=""){
                $this->db->where("sub_zone_group_id",$sub_zone_group_id);
                }
                $this->db->from ('lm_sub_zone');
		$query=$this->db->get();
		return $query->result();
		            
                }
                   public function sub_zone_delete($zone_id){
			
                $this->db->where('sub_zone_id', $zone_id);
                $this->db->delete('lm_sub_zone'); 
				
		$this->db->where('sub_zone_id', $zone_id);
                $this->db->delete('lm_location'); 
                
               
                return  'OK';
			}
                        
                public function edit_sub_zone($id,$name){
                
   		$this->db->set('sub_zone',$name);
                $this->db->where('sub_zone_id', $id);
               
                $this->db->update('lm_sub_zone');    
                return "OK";
                }
                   public function edit_sub_group_zone($id,$name){
                
   				$this->db->set('sub_zone_group_id',$name);
                $this->db->where('sub_zone_id', $id);
               
                $this->db->update('lm_sub_zone');    
                return "OK";
                } 
                         
                public function sub_zone_add($zone_id,$sub_value,$sub_zone_group){
                    $this->db->set("sub_zone_group_id",$sub_zone_group);
                    $this->db->set("zone_id",$zone_id);
                    $this->db->set("sub_zone",$sub_value);
                      $this->db->set("gsl_sub_zone",$sub_value);
                    $this->db->insert("lm_sub_zone");
                    return "OK";
                }
                
                 public function sub_zone_location($zone_id){
                    
                $this->db->select ('sub_zone,sub_zone_id');
                $this->db->where("zone_id",$zone_id);
		$this->db->from ('lm_sub_zone');
                
		$query=$this->db->get();
		return $query->result();
		            
                }
             public function location($zone_type,$sub_zone_id){
                    
                $this->db->select ('*');
                if($zone_type!=""){
                    
                     $this->db->where("location_type_id",$zone_type); 
                }
               if($sub_zone_id!=""){
                $this->db->where("sub_zone_id",$sub_zone_id);
               }
                $this->db->from ('vw_location_type');//lm_location
                
		$query=$this->db->get();
		return $query->result();
		            
                }    
                
         	public function location_type(){
		
		$this->db->select ('*');
		$this->db->from ('lm_location_type');
		$query=$this->db->get();
		return $query->result();
		         
		
		}       
	  public function location_type_edit($location_id,$location_type_id){
	  	$this->db->set('location_type_id',$location_type_id);
		$this->db->where('location_id', $location_id);
	   
		$this->db->update('lm_location');    
		return "OK";    
		  
	  }
	   public function location_type_subzone_edit($location_id,$sub_zone_id){
	 	 $this->db->set('sub_zone_id',$sub_zone_id);
		$this->db->where('location_id', $location_id);
	   
		$this->db->update('lm_location');    
		return "OK";    
		  
	  }
	public function location_edit($location_id,$location){
		$this->db->set('location',$location);
		$this->db->where('location_id', $location_id);
	   
		$this->db->update('lm_location');    
		return "OK";    
		  
	  }
	public function location_add($sub_zone_id,$location_type,$location){
		
		$this->db->set("sub_zone_id",$sub_zone_id);
		$this->db->set("location_type_id",$location_type);
		$this->db->set("location",$location);
		
		$this->db->insert("lm_location");
	   
		return "OK";
	}
                
	public function location_delete($location_id){

		$this->db->where('location_id', $location_id);
		$this->db->delete('lm_location'); 
		return  'OK';
			}
		
	public function all_result($date,$confirmed,$zone_id){
	
		$query=$this->db->query("CALL sp_result('$date','$confirmed','$zone_id')"); 	
		return  $query;
	}	
	public function count_result($date){
	
		$query=$this->db->query("CALL sp_counting_all_result('$date')"); 	
		return  $query;
	}	
	
	
	public function download_Excel_result_pid($date,$confirmed,$zone_id){
	
		$query=$this->db->query("CALL sp_result_pid('$date','$confirmed','$zone_id')"); 	
		return  $query;
	}
	
	
	
	public function result_confirmed($pid,$location_id,$count_id,$date,$sub_zone_id,$con_value){
		//return $con_value;
		$this->db->select('count_id');
		$this->db->where('date',$date);
		$this->db->where('sub_zone_id',$sub_zone_id);
		$this->db->where('status_id<',3);
		$this->db->from('inventory_count');
		$query = $this->db->get();
		
			if($query->num_rows()>0){
				
				foreach($query->result() as $rows ){
					
					$this->db->select('count_id');
					$this->db->where('count_id',$rows->count_id);
					$this->db->where('location_id',$location_id);
					$this->db->from('inventory_count_detail');
					$query1 = $this->db->get();
						if($query1->num_rows()>0){
							return "msg";	
						
						}else{
	
							$this->db->select('inventory_count_detail.product_id,
												inventory_count_detail.location_id,
												inventory_count_detail.count_detail_id,
												inventory_count.date,
												inventory_count.status_id,
												inventory_count_detail.count_id');
							$this->db->join('inventory_count_detail','inventory_count.count_id = inventory_count_detail.count_id');
							$this->db->from('inventory_count');
							$this->db->where('inventory_count_detail.product_id',$pid);		
							$this->db->where('inventory_count.date',$date);			
							$this->db->where('inventory_count_detail.location_id',$location_id);	
							$this->db->order_by("inventory_count_detail.count_id", "desc"); 
							$details = $this->db->get();
		
								if($details->num_rows()>0){
									
									foreach($details->result() as $rows){
		
										$this->db->set('date_time_confirmed', 'NOW()', FALSE);
										$this->db->set('user_id_confirmed',$this->session->userdata("user_id"));
										$this->db->set('quantity_confirmed',$con_value);
										$this->db->where('count_detail_id',$rows->count_detail_id);
										$this->db->update('inventory_count_detail');
								
											$this->db->select ('count_id');
											$this->db->where('count_id',$rows->count_id);
											$this->db->where('user_id_confirmed',0);
											$this->db->from ('inventory_count_detail');
											$query = $this->db->get();
							
												if($query->num_rows()>0){
												}else{
													$this->db->set('status_id', 5);
													$this->db->where('count_id',$rows->count_id);
													$this->db->update('inventory_count');
												}
					
								}
									}
	
		   }
		  }
		}else{

		$this->db->select('inventory_count_detail.product_id,
							inventory_count_detail.location_id,
							inventory_count_detail.count_detail_id,
							inventory_count.date,
							inventory_count.status_id,
							inventory_count_detail.count_id');
		$this->db->join('inventory_count_detail','inventory_count.count_id = inventory_count_detail.count_id');
		$this->db->from('inventory_count');
		$this->db->where('inventory_count_detail.product_id',$pid);		
		$this->db->where('inventory_count.date',$date);			
		$this->db->where('inventory_count_detail.location_id',$location_id);	
		$this->db->order_by("inventory_count_detail.count_id", "desc"); 
		$details = $this->db->get();
		
			if($details->num_rows()>0){
	
				foreach($details->result() as $rows){

					$this->db->set('date_time_confirmed', 'NOW()', FALSE);
					$this->db->set('user_id_confirmed', $this->session->userdata("user_id"));
					$this->db->set('quantity_confirmed',$con_value);
					$this->db->where('count_detail_id',$rows->count_detail_id);
					$this->db->update('inventory_count_detail');
			
						$this->db->select ('count_id');
						$this->db->where('count_id',$rows->count_id);
						$this->db->where('user_id_confirmed',0);
						$this->db->from ('inventory_count_detail');
						$query = $this->db->get();
							
							if($query->num_rows()>0){
							}else{
								$this->db->set('status_id', 5);
								$this->db->where('count_id',$rows->count_id);
								$this->db->update('inventory_count');
							}
				}
			}
		}
	}
	

	public function recount_result($location_id,$count_id,$sub_zone_id,$date){
		$max_count_number=0;
		$this->db->select('count_id');
		$this->db->where('date',$date);
		$this->db->where('sub_zone_id',$sub_zone_id);
		$this->db->where('status_id<',3);
		$this->db->from('inventory_count');
		$query = $this->db->get();
			if($query->num_rows()>0){
				foreach($query->result() as $rows ){
					
					$this->db->select('count_id');
					$this->db->where('count_id',$rows->count_id);
					$this->db->where('location_id',$location_id);
					$this->db->from('inventory_count_detail');
					$query1 = $this->db->get();
						if($query1->num_rows()>0){
							return "msg";	
						
						}else{
					
							$data_inventory_detail = array(
									"count_id"=>$rows->count_id, 
									"location_id"=>$location_id, 
									"product_id"=>'',
									"qty_inventory"=>0,
									"qty_booked"=>0,
									"qty_scanned"=>"0",
									"qty_counted"=>"0",
									"date_time_inventory"=>"",
									"date_time_counted"=>"",
									"pallet_code"=>"",
									"is_counted"=>0,
									"date_time_confirmed"=>'',
									"user_id_confirmed"=>0,
									);	
									
							$this->db->insert('inventory_count_detail',$data_inventory_detail);	
						}
				}
				
			}else{
				
				$this->db->select_max('count_number');
				$this->db->where('date',$date);
				$this->db->where('sub_zone_id',$sub_zone_id);
				$this->db->from('inventory_count');
				$query = $this->db->get();
		
				if($query->num_rows()>0){
					foreach($query->result() as $row ){
						$max_count_number =  $row->count_number;
					}	
					
					$data_inventory = array(
						"sub_zone_id"=>$sub_zone_id, 
						"date"=>$date, 
						"user_assigned"=>'',
						"user_created"=>$this->session->userdata("user_id"),
						"status_id"=>1,
						"counting_type_id"=>3,
						"product_id"=>'',
						"pid_count_id"=>'',
						"count_number"=>$max_count_number +1,
						"is_disabled"=>'',
						"count_all_location"=>'',
						);	
					$this->db->insert('inventory_count',$data_inventory);
					$inser_id = $this->db->insert_id() ;
					
					$data_inventory_detail = array(
						"count_id"=>$inser_id, 
						"location_id"=>$location_id, 
						"product_id"=>'',
						"qty_inventory"=>0,
						"qty_booked"=>0,
						"qty_scanned"=>"0",
						"qty_counted"=>"0",
						"date_time_inventory"=>"",
						"date_time_counted"=>"",
						"pallet_code"=>"",
						"is_counted"=>0,
						"date_time_confirmed"=>'',
						"user_id_confirmed"=>0,
						);	
						
				$this->db->insert('inventory_count_detail',$data_inventory_detail);		
			}
		}
	
	}
	
	public function undo_recount_result($location_id,$product_id,$sub_zone_id,$date){
	
		$this->db->select('inventory_count_detail.product_id,
								inventory_count_detail.location_id,
								inventory_count_detail.count_detail_id,
								inventory_count.date,
								inventory_count.sub_zone_id,
								inventory_count_detail.count_id');
			$this->db->join('inventory_count_detail','inventory_count.count_id = inventory_count_detail.count_id');
			$this->db->from('inventory_count');
			$this->db->where('inventory_count_detail.product_id',$product_id);		
			$this->db->where('inventory_count.date',$date);			
			$this->db->where('inventory_count_detail.location_id',$location_id);	
			$this->db->where('inventory_count.sub_zone_id',$sub_zone_id);	
			$this->db->order_by("inventory_count_detail.count_id", "desc"); 
			$details = $this->db->get();
			
				if($details->num_rows()>0){
					
					
					foreach($details->result() as $rows){
						$this->db->set('date_time_confirmed','');
						$this->db->set('user_id_confirmed',0);
						$this->db->set('quantity_confirmed',0);
						$this->db->where('count_detail_id',$rows->count_detail_id);
						$this->db->update('inventory_count_detail');
					
							$this->db->set('status_id', 4);
							$this->db->where('count_id',$rows->count_id);
							$this->db->update('inventory_count');
							
					
					}
				}
	}
	
	public function load_set_location($date){
		$this->db->select('*');
		$this->db->from('vw_ref_set_scanner_load');
		$this->db->where('date',$date);
		$this->db->where('status_id',1);
		$query=$this->db->get();
		return $query;
		
	}
	
	public function count_ref_list($date){
		
		$query=$this->db->query("CALL sp_count_ref_list('$date')"); 	
		return  $query;
		
	}
}
