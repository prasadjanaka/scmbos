<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mreport extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function product_vs_lp() {
		$wms_db = $this->load->database("gtl",true);
	
        $wms_db->select("UPC AS product_id,Description as description,SUM(Avl) AS quantity,SUM(booked) AS booked_quantity,
						(SELECT  SUM( MS_Order.OrderQuantity) 
							FROM MS_PO_Header INNER JOIN MS_Order ON MS_PO_Header.PO_Number = MS_Order.PO_Number
								WHERE MS_PO_Header.Status IS NULL AND MS_Order.UPC = current_inventory.UPC GROUP BY MS_Order.UPC) as lp_quantity");
        $wms_db->from('current_inventory');
		$wms_db->group_by('UPC,Description');
        $query = $wms_db->get();

		
		foreach($query->result() as $row){
			$row->lp_quantity = $row->lp_quantity;	
		}
		return $query;	
    }
	public function list_events($user_id){
		$this->db->select('*');
		$this->db->from('calendar_events');
		$this->db->where('user_id',$user_id);
		$query=$this->db->get();
		return $query->result();
	}
	public function add_events($data){
		$this->db->insert('calendar_events',$data);
		print_r("ok");
		
	}
	public function add_calendar_event_schedule($data){
		$this->db->insert('calendar_event_schedule',$data);
		print_r("OK");
	}
	public function list_schedule_events($user_id){
		$this->db->select('*');
		$this->db->from('vw_calendar_event_schedule');
		$this->db->where('user_id',$user_id);
		$query=$this->db->get();
		return $query->result();
	}
	public function remove_event_schedule($id){
		
	
		$this->db->query('delete from calendar_event_schedule where calendar_event_schedule_id='.$id.'');
		print_r('OK');
	}
	public function update_event($id,$data){
		
		
		$this->db->where('calendar_event_schedule_id',$id);
		$this->db->update('calendar_event_schedule',$data);
		print_r("OK");
	}
	public function remove_event($id){
		$this->db->query('delete from calendar_events where calendar_event_id='.$id.'');
		print_r('OK');
	}
	public function list_pallet_movement(){
	
		$this->db->select('a.*,c.location as from_location,d.location as to_location,pallet_movement_type.movement_type,pallet_movement_type.movement_sign,sys_user.user_id,sys_user.username,sys_user.epf_number');
		$this->db->from('pallet_movement as a');
		$this->db->join('lm_location c',' c.location_id = a.from_location_id','left outer');
		$this->db->join('lm_location d',' d.location_id = a.to_location_id','left outer');
		$this->db->join('pallet_movement_type',' a.movement_type_id = pallet_movement_type.movement_type_id');		
		$this->db->join('sys_user',' a.user_id = sys_user.user_id','left outer');	
		$query=$this->db->get();						
		return $query->result();
	
	}
	public function search_data($from,$to){
		
		$this->db->select('a.*,c.location as from_location,d.location as to_location,pallet_movement_type.movement_type,pallet_movement_type.movement_sign,sys_user.user_id,sys_user.username,sys_user.epf_number');
		if($to==""){
				$this->db->where('a.datetime >=',$from);
			}else if($from==""){
				$this->db->where('a.datetime <=',$to);
			}else{
			$this->db->where('a.datetime >=',$from);
			$this->db->where('a.datetime <=',$to);
			}
		$this->db->from('pallet_movement as a');
		$this->db->join('lm_location c',' c.location_id = a.from_location_id','left outer');
		$this->db->join('lm_location d',' d.location_id = a.to_location_id','left outer');
		$this->db->join('pallet_movement_type',' a.movement_type_id = pallet_movement_type.movement_type_id');		
		$this->db->join('sys_user',' a.user_id = sys_user.user_id','left outer');	
		$query = $this->db->get();
		return $query->result();	
		
	}
 


	public function chart_details_by_date($from,$to){
	
		$this->db->select('*');
		$this->db->from('pallet_movement');
		$this->db->group_by('MONTH(datetime), YEAR(datetime), DAY(datetime)');
		$this->db->where('datetime >=',$from);
		$this->db->where('datetime <=',$to);
		$query=$this->db->get();
		$data[]=array();
		//$data['pallet_count']=array();
			$x=0;
			foreach($query->result() as $row){
				$x++;
				$newDate = date("Y-m-d", strtotime($row->datetime));
				$data[$x]= $newDate ;
				$this->db->select('*');
				$this->db->from('pallet_movement');
					$this->db->where('date(datetime)',$newDate);
				$query=$this->db->get();
				$data[$x]= $data[$x].'/'.$query->num_rows();
				
			}
		return 	$data;
	}
	
		public function chart_details_by_user($from,$to){
	//
		$this->db->select('pallet_movement.*,sys_user.epf_number');
		$this->db->from('pallet_movement');
		$this->db->join('sys_user','sys_user.user_id = pallet_movement.user_id','left outer');
		$this->db->where('pallet_movement.datetime >=',$from);
		$this->db->where('pallet_movement.datetime <=',$to);
		$this->db->group_by('user_id');
		$query=$this->db->get();
		$data[]=array();
		//$data['pallet_count']=array();
			$x=0;
			foreach($query->result() as $row){
				if($row->user_id!=0){
					$x++;
					$newuser = $row->epf_number;
					$data[$x]= $newuser ;
					$this->db->select('*');
					$this->db->from('pallet_movement');
					//$this->db->join('sys_user','sys_user.user_id = pallet_movement.user_id');
					
				
					$this->db->where('user_id',$row->user_id);//before
					$query=$this->db->get();
					$data[$x]= $data[$x].'/'.$query->num_rows();
				}
			}
		return 	$data;
	}
	

	
	public function line_chart($date,$user_id){
		$this->db->select('pallet_movement.*,sys_user.epf_number');
		$this->db->from('pallet_movement');
		$this->db->join('sys_user','sys_user.user_id = pallet_movement.user_id');
		$this->db->where('date(pallet_movement.datetime)',$date);
		$this->db->where('sys_user.epf_number',$user_id);
		$query=$this->db->get();
		return $query->num_rows();
	}

   
	public function user_load(){
		$this->db->select('sys_user.epf_number');
		$this->db->from('pallet_movement');
		$this->db->join('sys_user','sys_user.user_id = pallet_movement.user_id');
		$this->db->group_by('pallet_movement.user_id');
		$query=$this->db->get();
		return $query;
	}

   }
	
?>