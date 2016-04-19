<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mproduct extends CI_Model {
    function __construct()
    {
        parent::__construct();
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
	public function list_pick_face(){
	
	$this->db->select('lm_pick_face.customer_id,
	lm_pick_face.client_code,
	product.description,
	lm_pick_face.priority,
	lm_pick_face.pallet_count,
	lm_pick_face.min_reorder_level,
	lm_pick_face.is_enable,
	lm_pick_face.product_id,	
	lm_location.location,
	lm_location.location_id
	');    
	$this->db->from('lm_pick_face');
	$this->db->join('product', 'lm_pick_face.product_id=product.product_id');
	$this->db->join('lm_location', 'lm_location.location_id = lm_pick_face.location_id');
  	$query=$this->db->get();
    return $query->result();

	}
	public function update_pick_data($data){
	$product_id =$data['update_id'];
	$col_id=$data['update_col'];
	$update_value=$data['update_value'];
	
	if($col_id == "location_id"){
		$this->db->select('lm_location.location_id');
	$this->db->from('lm_location');
	$this->db->where('location',$update_value);
	$query=$this->db->get();
	if ($query->num_rows() > 0){
		 foreach($query->result() as $querys){
			
		    $id=$querys->location_id;
			$this->db->select("*");
			$this->db->from('lm_pick_face');
			$this->db->where('location_id',$id);
			$query1=$this->db->get();
			if ($query1->num_rows() > 0){
			return "Location Already Exist";
			}else{
			$this->db->set($col_id,$id);
			$this->db->where('product_id',$product_id);
			$this->db->update('lm_pick_face');
			}
		 }
		}else{
			return "Invalied Location";
		}

	}else{
		$this->db->set($col_id,$update_value);
		$this->db->where('product_id',$product_id);
		$this->db->update('lm_pick_face');
	}
	
	
	
	
	}
	
	
	public function add_pick($data){
	
	$lid=$data['location_id'];

	$this->db->select("*");
	$this->db->from('lm_location');
	$this->db->where('location',$lid);	
	$query=$this->db->get();
	
		foreach($query->result() as $querys){
		$id=$querys->location_id;
		
		$data['location_id']=$id;		
		$this->db->insert("lm_pick_face",$data);
			return "ok";	
		}	

		

	}
	public function delete_pick_data($data){
	$this->db->where('product_id',$data);	
	$this->db->delete('lm_pick_face');	
	
	return "Deleted";
	}
	public function set_status($pid,$status){
		//echo $status;
		if($status=="status-1"){
	$this->db->set('is_enable',0);
	$this->db->where('product_id',$pid);
	$this->db->update('lm_pick_face');
	return "OK";	
		}else{
	$this->db->set('is_enable',1);
	$this->db->where('product_id',$pid);
	$this->db->update('lm_pick_face');
	return "OK";	
	}
		
	}
	public function check_product_id($pid2){
	$this->db->select('product.product_id');
	$this->db->from('product');
	$this->db->where('product_id',$pid2);
	$query1=$this->db->get();
		
	if ($query1->num_rows() > 0){
		
	  $this->db->select("*");
      $this->db->from('lm_pick_face');
      $this->db->where('product_id',$pid2);
      $query = $this->db->get();
		 if ($query->num_rows() > 0){
	  return "PID Allready Exsist";
	  }else{
		  
	  }
		 
	}else{
		
     return "Invalied PID";
	}
		
	  
		//return $pid;
	}
	public function check_location_name($location){
		$this->db->select("*");
		$this->db->from('lm_location');
		$this->db->where('location',$location);	
		$query=$this->db->get();
		if ($query->num_rows() > 0){
		 foreach($query->result() as $querys){
			
		 $id=$querys->location_id;
			$this->db->select("*");
			$this->db->from('lm_pick_face');
			$this->db->where('location_id',$id);
			$query1=$this->db->get();
			if ($query1->num_rows() > 0){
			return "Location Already Exist";
			}else{
				
			}
		 }
		}else{
			return "Invalied Location";
		}

	}

	public function get_product_details($product_id){
		
		$this->db->select('*');
		$this->db->from('product');
		$this->db->where('product_id',$product_id);
		return $this->db->get();
			
	}
	
	public function add_new_product($product_id,$discription,$net_val,$height_val,$volume_val){
	
		$this->db->set('product_id',$product_id);
		$this->db->set('description',$discription);
		$this->db->set('weight_net',$net_val);
		$this->db->set('height',$height_val);
		$this->db->set('volume',$volume_val);
		$this->db->set('client_status',"Active");
		$this->db->set('scm_status',1);
		$this->db->set('client_code',0);
		$this->db->insert('product');
		return 1;
	
	}
	public function update_product($product_id,$discription,$net_val,$height_val,$volume_val){
	
		$this->db->set('description',$discription);
		$this->db->set('weight_net',$net_val);
		$this->db->set('height',$height_val);
		$this->db->set('volume',$volume_val);
		$this->db->where('product_id',$product_id);
		$this->db->update('product');
		return 1;
	
	}
}
