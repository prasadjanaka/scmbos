<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Colombo");
class Mcount_ref extends CI_Model {
	public $reference_number = "";
	public $error = "";
	
    function __construct()
    {
        parent::__construct();
    }
	
	public function release($reference=""){
		$count_ids = array();
		$scanner_id = 0 ;
		
		$this->error = "";

		$this->db->select("*");
		$this->db->from("inventory_count_reference");
		$this->db->where("reference_number",$reference);
		$this->db->where("is_released",0);
		$result_ref = $this->db->get();
			if($result_ref->num_rows()>0){
				$scanner_id = $result_ref->row()->scanner_id;
				if($scanner_id > 0){
					$this->db->select("*");
					$this->db->from("inventory_count");
					$this->db->where("reference",$reference);
					$result = $this->db->get();
						if($result->num_rows()>0){
							foreach($result->result() as $row){
								array_push($count_ids,$row->count_id);
							}
							
							$this->db->trans_start();
							
							$this->db->set('user_assigned', $scanner_id);
							$this->db->set('status_id', 2);
							$this->db->where("count_id IN (". implode(",",$count_ids) .")" );
							$this->db->update("inventory_count");	
							
							//echo $this->db->last_query()."<br/>";	
							
							$sql = "INSERT INTO inventory_count_detail (count_id,location_id,product_id)
									SELECT inventory_count.count_id, lm_location.location_id, '' AS product_id 
									FROM inventory_count
									Inner Join lm_sub_zone ON lm_sub_zone.sub_zone_id = inventory_count.sub_zone_id
									Inner Join lm_location ON lm_sub_zone.sub_zone_id = lm_location.sub_zone_id
										WHERE inventory_count.`count_id` IN (". implode(",",$count_ids) .") AND count_number = 1";
							$this->db->query($sql);
							//echo $this->db->last_query()."<br/>";	
							
							$this->db->set('is_released', 1);
							$this->db->where("reference_number",$reference);
							$this->db->update("inventory_count_reference");								
							//echo $this->db->last_query()."<br/>";								
							$this->db->trans_complete();							
														
						}else{
							$this->error = "No Locations found for this reference";
						}
				}else{
					$this->error = "Invalid Scanner ";
				}

			}else{
				$this->error = "Invalid Reference";
			}
	}


	public function change_reference_number($reference="",$pre_reference=""){
		$this->error = "";
		$this->db->select("*");
		$this->db->from("inventory_count_reference");
		$this->db->where("reference_number",$reference);	
		$result = $this->db->get();	
		if($result->num_rows() > 0){
			$this->error = $reference." is already in use";
			return false;
		}else{
			$this->db->set("reference",$reference);
			$this->db->where("reference",$pre_reference);	
			$this->db->update("inventory_count");
			
			$this->db->set("reference_number",$reference);
			$this->db->where("reference_number",$pre_reference);	
			$this->db->update("inventory_count_reference");			
						
		}
	}


	public function clear_counts($reference=""){
		$this->error = "";
		$this->db->set("reference",NULL);
		$this->db->set("user_assigned",0);
		$this->db->where("reference",$reference);	
		$this->db->update("inventory_count");
	}
	

	public function can_scanner_remove($reference=""){
		$this->error = "";
		$this->db->select("*");
		$this->db->from("inventory_count");
		$this->db->where("reference",$reference);	
		$result = $this->db->get();	
		if($result->num_rows() > 0){
			$this->error = "Sorry you cannot change the scanner. Remove locations and try again";
			return false;
		}else{
			return true;	
		}
	}
	
	public function check_count_reference($count_id=0){
		$this->error = "";
		$this->db->select("*");
		$this->db->from("inventory_count");
		$this->db->where("count_id",$count_id);	
		$result = $this->db->get();	
		if($result->num_rows() > 0){
			if($result->row()->reference <> ''){
				$this->error = "This level has been assigned to ".$result->row()->reference;
				return false;
			}
		}
		return true;		
	}


	public function check_reference_number($reference="",$date=""){
		$this->error = "";
		$this->db->select("*");
		$this->db->from("inventory_count_reference");
		$this->db->where("reference_number",$reference);	
		$result = $this->db->get();	
		if($result->num_rows() > 0){
			$this->error = "$reference is already been used";
		}else{
			$this->db->set("reference_number", $reference );
			$this->db->set("date", $date);
			$this->db->set('datetime_created', 'NOW()', FALSE);
			$this->db->set("user_id_created", $this->session->userdata("user_id"));
			$this->db->insert("inventory_count_reference");	
		}	
	}
	
	public function get_reference_detail($reference=""){
		$this->db->select("*");
		$this->db->from("inventory_count_reference");
		$this->db->where("reference_number",$reference);
		$result = $this->db->get();		
		return $result;	
	}

	public function get_sub_zones_to_count($date,$scanner_id=0){
		$result = $this->db->query("call sp_get_sub_zones_to_count('".$date."',".$scanner_id.")");		
		return $result;	
	}


	public function get_reference_sub_zones($reference=""){
		$this->db->select("inventory_count.count_id,inventory_count.count_number,count_id,lm_sub_zone.zone_id,lm_sub_zone.sub_zone");
		$this->db->from("inventory_count");
		$this->db->join("lm_sub_zone","lm_sub_zone.sub_zone_id = inventory_count.sub_zone_id");
		$this->db->where("inventory_count.reference",$reference);
		$this->db->order_by("inventory_count.`date`,inventory_count.count_number,inventory_count.sort_order,lm_sub_zone.sub_zone");
		$result = $this->db->get();		
		return $result;	
	}

	public function set_count_reference($count_id=0,$reference=""){
		$this->db->set('reference', $reference);
		$this->db->where("count_id", $count_id );
		$this->db->update("inventory_count");	
		
	}

	public function remove_count_reference($count_id=0){
		$this->db->select('*');
		$this->db->from('inventory_count');
		$this->db->where("count_id", $count_id );
		$result = $this->db->get();	
			if($result->num_rows() > 0){
				if($result->row()->status_id <= 2){
					$this->db->set('reference',NULL);
					$this->db->set('user_assigned',0);
					$this->db->set('status_id',1);
					$this->db->where("count_id", $count_id );
					$this->db->update("inventory_count");
				}else{
					$this->error = "Sorry, You cannot remove this record";	
				}	
			}else{
				$this->error = "Invalid count record";	
			}
		
	}
		
	public function update_reference($data){
		$reference = $data['reference'];
		unset($data['reference']);
		
		$this->db->where("reference_number", $reference );
		$this->db->update("inventory_count_reference",$data);	
	}
	
	public function generate_new_reference($date=""){
		$date = date("Y-m-d",strtotime($date));
		$counter = 1;
		$this->db->select("*");
		$this->db->from("inventory_count_reference");
		$this->db->where("date",$date);
		$result = $this->db->get();
			if($result->num_rows()>0){
				$counter = $result->num_rows() + 1;
			}

		$counter = sprintf('%04d', $counter);
		$this->reference_number = date("Ymd",strtotime($date)).$counter;	
		
		$this->db->set("reference_number", $this->reference_number );
		$this->db->set("date", $date);
		$this->db->set('datetime_created', 'NOW()', FALSE);
		$this->db->set("user_id_created", $this->session->userdata("user_id"));
		$this->db->insert("inventory_count_reference");
		
		return true;
		
	}
	public function count_ref_list($date){
		
		$query=$this->db->query("CALL sp_count_ref_list('$date')"); 	
		return  $query;
		
	}
	public function modify_ref_list($date,$ref_val){
		
		$this->db->select('*,lm_sub_zone.sub_zone,inventory_count_status.count_status as status');
		$this->db->from('inventory_count');
		$this->db->join('lm_sub_zone','lm_sub_zone.sub_zone_id = inventory_count.sub_zone_id');
		$this->db->join('inventory_count_status','inventory_count_status.count_status_id = inventory_count.status_id');
		$this->db->where('reference',$ref_val);
		$this->db->where('date',$date);
		return $this->db->get();
	
	}
	
	public function get_ref_details($ref_number){
		
		$this->db->select('inventory_count_reference.date,inventory_count_reference.reference_number,sys_user.epf_number,sys_user.name');
		$this->db->from('inventory_count_reference');
		$this->db->join('sys_user','sys_user.user_id = inventory_count_reference.scanner_id');
		$this->db->where('inventory_count_reference.reference_number',$ref_number);
		$query = $this->db->get();
		return $query->row();
	}

	
	
	public function move_reference($count_id=0,$target_reference){
		$this->error = "";
		$this->db->select("*");
		$this->db->from("inventory_count_reference");
		$this->db->where("reference_number",$target_reference);	
		$result = $this->db->get();	
		if($result->num_rows() > 0){
			$this->db->select("*");
			$this->db->from("inventory_count");
			$this->db->where("count_id",$count_id);	
			$result_count = $this->db->get();				
				if($result_count->row()->status_id == 1 or $result_count->row()->status_id == 2 ){
					$this->db->set("user_assigned",$result_count->row()->user_assigned );
					$this->db->set("reference",$target_reference);
					$this->db->where("count_id",$count_id);
					$this->db->update("inventory_count");						
					$this->error = "Record moved successfully";
				}else{
					$this->error = "You cannot move this record as it is counting already started";
					return false;					
				}
		}else{
			$this->error = "Invalid Target Reference";
			return false;				
		}
		return true;		
	}
	
	public function load_zone_counting_summery($date){
	
		$result = $this->db->query("call sp_inventory_count_report_zone_summary('".$date."')");		
		return $result;	
	}	
	
	public function total_scanners($date){
	$result = $this->db->query("select count(distinct scanner_id) AS total_scanners from inventory_count_reference where date='$date'");
	 return $result->row();
	}
	
	public function in_action($date){
		$this->db->reconnect();
	$result = $this->db->query("SELECT COUNT(DISTINCT inventory_count.user_assigned) as inaction FROM inventory_count
WHERE inventory_count.`date`='$date' AND (inventory_count.status_id =3 or inventory_count.status_id=2)");
	 return $result->row();
	}
	
	public function icmdb_load_bar_chart_inv_vs_count($date){
	
		$result = $this->db->query("call sp_inv_vs_count('".$date."')");		
		return $result;	
	}
	
	public function icmdb_load_pie_chart($date){
		
		$this->db->select('inventory_count.count_number,COUNT(inventory_count.count_id) AS count_count');
		$this->db->from('inventory_count');
		$this->db->where('date',$date);
		$this->db->where('status_id>',2);
		$this->db->group_by('count_number');
		return $this->db->get();
	}
	
	public function acc_inv($date){
	$this->db->reconnect();
	$result = $this->db->query("SELECT ROUND((SUM(vw_inv_count_accuracy.qty_inventory = vw_inv_count_accuracy.quantity_confirmed) / COUNT(*))*100,2) AS location_accuracy,ROUND(SUM(inventory_accuracy)/COUNT(*),2) as inventory_accuracy FROM vw_inv_count_accuracy WHERE `date`='$date'");

	return $result;
	
	
	}
}