<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');
class Count_ref_manager extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('inventory/mcount_ref');
		$this->load->model('inventory/mlocation_manager');
		$this->load->model('inventory/minventory');//get_scanning_clearks
		$this->load->model('user/mlogin');
    }
	
	
	public function index(){
	
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		if ($this->mlogin->get_permission(SYS_REF_SET_SCANNER)) {
		$date = $this->input->get_post('ds');
		$reference = $this->input->get_post('reference');
		
		
		$result = $this->mcount_ref->get_reference_detail($reference);
		if($result->num_rows()>0){
			if($result->row()->is_released == 1){
				die('Abnormal Try')	;
			}else{
				$data['reference_sub_zones'] = $this->mcount_ref->get_reference_sub_zones($reference);				
			}
		}else{
			$data['reference_sub_zones'] = $this->mcount_ref->get_reference_sub_zones('noxxx');		
		}
		
		if($result->num_rows() > 0 )
			$data['scanner_id'] = $result->row()->scanner_id ;
		else
			$data['scanner_id'] = 0 ;

	 	$data['date'] = $date;
		$data['reference'] = $reference ; 
		$data['result'] = $this->mlocation_manager->load_set_location($date);
	 	$data['zone_list'] = $this->mlocation_manager->zone_list();
		$data['scanning_clearks'] = $this->minventory->get_scanning_clearks();


		$data['sub_zones_to_count'] = $this->mcount_ref->get_sub_zones_to_count($date,$data['scanner_id']);		

		
		$this->load->view('inventory/count_ref_set_scanner',$data);
		}else {
            $this->load->view('no_permission');
        }
		$this->load->view('html_footer');
	
	}
	
	public function change_reference_number(){
		if ($this->mlogin->get_permission(SYS_REF_CHANGE_REFERENCE)) {
			$this->mcount_ref->change_reference_number($this->input->get_post('reference'),$this->input->get_post('pre_reference'));	

				
			echo $this->mcount_ref->error;			
		}else{
			echo "Sorry you do not have permission";
		}			
	}
	
	public function clear_counts(){
		if ($this->mlogin->get_permission(SYS_REF_CLEAR_COUNT)) {
			$this->mcount_ref->clear_counts($this->input->get_post('reference'));		
			echo $this->mcount_ref->error;			
		}else{
			echo "Sorry you do not have permission";
		}
	}	
	
	
	
	public function release(){
		if ($this->mlogin->get_permission(SYS_REF_RELEASE_COUNT)) {
		$this->mcount_ref->release($this->input->get_post('reference'));		
		echo $this->mcount_ref->error;	
		}else{
			echo "Sorry you do not have permission";
		}		
	}	
	
	public function update_scanner_id(){
		if ($this->mlogin->get_permission(SYS_REF_UPDATE_SCANNER)) {
			$data['reference'] = $this->input->get_post('reference');	
			$data['scanner_id'] = $this->input->get_post('scanner_id');
			if($this->mcount_ref->can_scanner_remove($data['reference'])){
				$this->mcount_ref->update_reference($data);		
			}
		echo $this->mcount_ref->error;	
		}else{
			echo "Sorry you do not have permission";
		}					
		
	}


	public function remove_count_reference(){
		if ($this->mlogin->get_permission(SYS_REF_REMOVE_REFERENCE)) {
			$count_id = $this->input->get_post('count_id');	
			$this->mcount_ref->remove_count_reference($count_id);
			echo $this->mcount_ref->error;		
		}else{
			echo "Sorry you do not have permission";
		}		
	}

	public function check_reference_number(){
		$reference = $this->input->get_post('reference');	
		$date = $this->input->get_post('date');
		$this->mcount_ref->check_reference_number($reference,$date);		
		echo $this->mcount_ref->error;			
	}


	
	public function set_count_reference(){
		$count_id = $this->input->get_post('count_id');	
		$reference = $this->input->get_post('reference');	
		$this->mcount_ref->set_count_reference($count_id,$reference);
		echo $this->mcount_ref->error;	
	}

	public function check_count_reference(){
		$count_id = $this->input->get_post('count_id');	
		$this->mcount_ref->check_count_reference($count_id);
		echo $this->mcount_ref->error;	
	}


	public function load_set_location(){
		
	
	}

	
	public function count_ref_list(){
		
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		
		if ($this->mlogin->get_permission(SYS_REF_COUNT_LIST)) {
			$date = $this->input->get_post('ds');
			$date= ($date == "" ? date('Y-m-d') : $date);
			$data['ds'] = $date;
			$data['ref_list'] = $this->mcount_ref->count_ref_list($date);
			
			$this->load->view('inventory/count_ref_list',$data);
		}else {
            $this->load->view('no_permission');
        }
		$this->load->view('html_footer');
	
	}
	
	public function modify_ref(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		if ($this->mlogin->get_permission(SYS_REF_MODIFY)) {
		
			$data['ref_val'] = $this->input->get_post('ref_val');
			$row = $this->mcount_ref->get_ref_details($data['ref_val']);	
			$data['date'] = $row->date;
			$data['scanner_name'] = $row->epf_number.'-'.$row->name;
			$data['ref_list'] = $this->mcount_ref->modify_ref_list($data['date'],$data['ref_val']);
			
			$this->load->view('inventory/modify_ref',$data);
		}else{
		 $this->load->view('no_permission');
		}
		$this->load->view('html_footer');
	}


	public function move_reference(){
		$count_id = $this->input->get_post('count_id');
		$target_reference = $this->input->get_post('target_reference');
		
		$this->mcount_ref->move_reference($count_id,$target_reference);
		echo $this->mcount_ref->error;
	}	
	
	public function icmdb_load(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		$inaction_ref=0;   
		
		$date = $this->input->get_post('ds');
		$date= ($date == "" ? date('Y-m-d') : $date);
		$total_scanners = $this->mcount_ref->total_scanners($date);
		
		$data['zone_summery'] = $this->mcount_ref->load_zone_counting_summery($date);
		$data['acc_inv'] = $this->mcount_ref->acc_inv($date);
	
		$ref = $this->mcount_ref->in_action($date);
	
			
		$data['inaction_ref'] = $ref->inaction ;	
		$data['total_scanners'] = $total_scanners ;
		$data['ds'] = $date ;
		$this->load->view('inventory/icmdb',$data);
		
		
		$this->load->view('html_footer');
	}
	
	public function icmdb_load_bar_chart(){
	$date = $this->input->get_post('ds');
	$date= ($date == "" ? date('Y-m-d') : $date);
	$parent_row="";
	$ref = $this->minventory->ref_distribution($date,$epf="",$ref="");
	
	foreach($ref->result() as $row){ 
	   $child_row="";
       $pre = number_format( ($row->counted_locations /$row->locations_to_count ) *100,0, '.', '' ) ;
	   if($pre!=100){
		
		 $child_row  = $row->reference."-".$row->name."!".$pre;  
		 $parent_row = $parent_row."%".$child_row;
		
		}

	}
	echo $parent_row;
	}
	
	
	public function icmdb_load_bar_chart_inv_vs_count(){
		
	$date = $this->input->get_post('ds');
	$date= ($date == "" ? date('Y-m-d') : $date);
	$inv_vs_count = $this->mcount_ref->icmdb_load_bar_chart_inv_vs_count($date);
		foreach($inv_vs_count->result() as $invs ){
		
		echo $invs->inv_location_count."!".$invs->counted_locations."!".$invs->inv_pid_count."!".$invs->counted_pids;
		
		}
	}
	
	public function icmdb_load_pie_chart(){
	$parent_row="";	
	$date = $this->input->get_post('ds');
	$date= ($date == "" ? date('Y-m-d') : $date);
	$pie_chart = $this->mcount_ref->icmdb_load_pie_chart($date);
		foreach($pie_chart->result() as $pie ){
		 $child_row="";
		 $child_row  = $pie->count_number."!". $pie->count_count;  
		 $parent_row = $parent_row."%".$child_row;
		
	}
	echo $parent_row;
}

}