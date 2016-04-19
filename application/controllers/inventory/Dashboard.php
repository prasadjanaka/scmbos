<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('inventory/minventory');
        $this->load->model('interfaces/mwms');
        $this->load->model('user/mlogin');
		$this->load->model('inventory/mlocation_manager');
		$this->load->library('excel');
    }

    public function remove_replenishments() {
        $this->mwms->remove_replenishments();
    }

    public function sync_replenishments() {
        $this->mwms->sync_replenishments();
    }

    public function sync_all_replenishments() {
        $this->mwms->sync_all_replenishments();
    }

    public function index() {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        if ($this->mlogin->get_permission(SYS_INVENTORY_DASHBORD)) {
            $this->load->view('inventory/dashboard');
        } else {
            $this->load->view('no_permission');
        }

        $this->load->view('html_footer');
    }

    public function change_replenishment_order() {
        $replenishment_id = $this->input->get_post('replenishment_id');
        $action = $this->input->get_post('action');
        $zone_id = $this->input->get_post('zone_id');
        echo $this->minventory->change_replenishment_order($replenishment_id, $action, $zone_id);
    }

    public function replenishment_list_excel() {
        $this->load->view('excel_header');
        $replenishment_status = $this->input->get_post('rep_status');
        $zone_id = $this->input->get_post('zone_id');
        $zone = ($zone_id > 0 ? "Zone " . $zone_id : "All Zones");

        if ($this->mlogin->get_permission(PF_REPLENISHMENT_LIST)) {
            $data['replenishments'] = $this->minventory->get_replenishments($replenishment_status, $zone_id);
            $data['title'] = strtoupper($replenishment_status . " Replenishments");
            $data['rep_status'] = $replenishment_status;
            $data['zone'] = $zone;
            $this->load->view('inventory/excel_replenishment_list', $data);
        }
    }

    public function replenishment_list() {
        $replenishment_status = $this->input->get_post('rep_status');
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        if ($this->mlogin->get_permission(PF_REPLENISHMENT_LIST)) {
            //$this->mwms->sync_replenishments();
            $data['replenishments'] = $this->minventory->get_replenishments($replenishment_status);
            $data['title'] = strtoupper($replenishment_status . " Replenishments");
            $data['rep_status'] = $replenishment_status;
            $this->load->view('inventory/replenishment_list', $data);
        } else {
            $this->load->view('no_permission');
        }

        $this->load->view('html_footer');
    }

    public function stacking_norms() {
		
       $product_ids = array();
     $product_ids1 = array();
        if ( $this->input->get_post('product_ids')!="" or $this->input->get_post('sto')!="" or $this->input->get_post('zone')!="" ) {
       
            $this->load->view('html_header');
            $this->load->view('main_header_menu');
            $this->load->view('main_left_menu');
         
         if ($this->mlogin->get_permission(SYS_INVENTORY_STACKING_NORM_VIEW)){  
             $zone1=$this->input->get_post('zone');
             $sto=$this->input->get_post('sto');
           if($this->input->get_post('product_ids')!=""){
			   $product_ids = explode("\r\n", $this->input->get_post('product_ids'));
			   $product_ids1=$product_ids;
			   }
        		$abc=$this->minventory->add_stacking_norm_non_pid( $product_ids1);
				
				//echo $abc;
				
			
				
			$data['stacking_norms'] = $this->minventory->advance_search(
			$product_ids,$zone1,$sto);
			$data['error_record_count'] = $this->minventory->error_record_count();
			$data['product_stack_types'] = $this->minventory->get_product_stack_type();
			$data['product_id_list'] = $this->input->get_post('product_ids');
			$data['zone'] = $this->input->get_post('zone');
			$data['st'] = $this->input->get_post('sto');
			$zone['get_zone'] = $this->minventory->get_zone();
			$data['error_record'] ="";
			$this->load->view('inventory/stacking_norms', array_merge($data, $zone));	
					
					
				//}
			
          
     
            $this->load->view('html_footer');
		 }
        } else {

            if ($_POST) {
           
                if ($this->mlogin->get_permission(SYS_INVENTORY_STACKING_NORM_EDIT)) {

                    $changed_data = array();

                    $new_product_id = $this->input->get_post('new_product_id');
                    $new_product_id = ($new_product_id == "" ? 0 : $new_product_id);

                    $new_product_stack_type_id = $this->input->get_post('new_product_stack_type_id');
                    $new_product_stack_type_id = ($new_product_stack_type_id == "" ? 0 : $new_product_stack_type_id);

                    $new_pps = $this->input->get_post('new_pps');
                    $new_pps = ($new_pps == "" ? 0 : $new_pps);


                    if ($new_product_id > 0 and $new_product_stack_type_id > 0 and $new_pps > 0) {
                        $changed_data = array('product_id' => $new_product_id,
                            'product_stack_type_id' => $new_product_stack_type_id,
                            'pps' => $new_pps);
                        $this->minventory->add_product_stack($changed_data);
                    }



                    $product_ids = $this->input->get_post('product_ids');
                    foreach ($product_ids as $product_id) {
                        $changed_data = array();
                        $product_id_for_var = str_replace(".", "_", $product_id);
                        $pps = $this->input->get_post('pps_' . $product_id_for_var);
                        $pps = ($pps == "" ? 0 : $pps);
                        $product_stack_type_id = $this->input->get_post('product_stack_type_id_' . $product_id_for_var);
                        $product_stack_type_id = ($product_stack_type_id == "" ? 0 : $product_stack_type_id);
                        $delete = $this->input->get_post('del_' . $product_id_for_var);
                        $delete = ($delete == "" ? 0 : $delete);

                        $changed_data = array('product_id' => $product_id,
                            'delete' => $delete,
                            'product_stack_type_id' => $product_stack_type_id,
                            'pps' => $pps);
                        $this->minventory->update_product_stack($changed_data);
                    }
                    redirect(base_url() . "index.php/inventory/dashboard/stacking_norms");
                }
            } else {
             
               // $start_count = 0;
                //$start_count = $this->input->GET('st_count');
               // $tmp = $this->input->get_post('product_ids');
        		$this->load->view('html_header');
                $this->load->view('main_header_menu');
                $this->load->view('main_left_menu');
                if ($this->mlogin->get_permission(SYS_INVENTORY_STACKING_NORM_VIEW)) {
            

                     	
			
						$data['error_record_count'] = $this->minventory->error_record_count();
					  
					    $data['zone'] = $this->input->get_post('zone');
                        $data['st'] = $this->input->get_post('sto');
                        $data['product_id_list'] = $this->input->get_post('product_ids');
						if($this->input->get_post('err')==1){
						$data['error_record'] = $this->minventory->error_record();	
						}else{
                        $data['stacking_norms'] = $this->minventory->get_stacking_norms();
						$data['error_record'] ="";
						}
						
                        $data['product_stack_types'] = $this->minventory->get_product_stack_type();

                        $zone['get_zone'] = $this->minventory->get_zone();

                        $this->load->view('inventory/stacking_norms', array_merge($data, $zone));
                    
                } else {
                    $this->load->view('no_permission');
                }

                $this->load->view('html_footer');
            }
        }
    }

    public function stacking_norms_adherence() {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
        if ($this->mlogin->get_permission(SYS_INVENTORY_STACKING_NORM_ADHERENCE_VIEW)) {
            $data['last_inventory_import'] = $this->mwms->get_last_inventory_imported_date();
            $data['stacking_norm_adherences'] = $this->minventory->get_stacking_norm_adherence();
            $this->load->view('inventory/stacking_norms_adherence', $data);
        } else {
            $this->load->view('no_permission');
        }
        $this->load->view('html_footer');
    }

    public function current_inventory() {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        if ($this->mlogin->get_permission(SYS_INVENTORY_CURRENT_INVENTORY_VIEW)) {
            $data['last_inventory_import'] = $this->mwms->get_last_inventory_imported_date();
            $data['current_inventory'] = $this->minventory->get_current_inventory();
            $this->load->view('inventory/current_inventory', $data);
        } else {
            $this->load->view('no_permission');
        }
        $this->load->view('html_footer');
    }

    public function location_count_set_to_zone() {
        $color_code = "";
        $status_id = 0;
        $count_id = $this->input->get_post('count_id');
        $count_id = ($count_id == "" ? 0 : $count_id);
        $message = "";
        $data = array();
        $data['user_created'] = 1; // get the logged in user
        $data['sub_zone_id'] = $this->input->get_post('sub_zone_id');

        $data['date'] = $this->input->get_post('date');
        $today = date("Y-m-d");

        if (strtotime($data['date']) < strtotime($today)) {
            $message = "Sorry you cannot set counts for today or past dates";
        } else {
            if ($this->mlogin->get_permission(SYS_INVENTORY_LOCATION_COUNT_PLAN_UPDATE)) {
                if ($this->input->get_post('status_id') == 0) {
                    $count_id = $this->minventory->add_location_count($data);
                    $status_id = 1;
                    $color_code = "#FC0";
                }
                if ($this->input->get_post('status_id') == 1) {
                    $count_id = $this->minventory->delete_count_record($count_id);
                    $count_id = 0;
                    $status_id = 0;
                    $color_code = "";
                }
            } else {
                $message = "Sorry you do not have permission to change the values here";
            }
        }
        echo '{"count_id":' . $count_id . ',"status_id": ' . $status_id . ',"color_code":"' . $color_code . '","scanner_name":"","message":"' . $message . '" }';
    }

    public function location_count_set() {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        $date_start = $this->input->get_post('ds');
        $day_count = $this->input->get_post('dc');

        $date_start = ($date_start == "" ? date('Y-m-d') : date('Y-m-d', strtotime($date_start)));

        $day_count = ($day_count == "" ? 21 : $day_count);
        $day_count = ($day_count < 14 ? 14 : $day_count);

        $date_end = date('Y-m-d', strtotime("+" . $day_count . " days", strtotime($date_start)));

        $data['date_start'] = $date_start;
        $data['date_end'] = $date_end;
        $data['day_count'] = $day_count;
        if ($this->mlogin->get_permission(SYS_INVENTORY_LOCATION_COUNT_PLAN_VIEW)) {
            $data['sub_zone_list'] = $this->minventory->get_sub_zone_list();
            $data['count_status_list'] = $this->minventory->get_inventory_count_status();
            $this->load->view('inventory/location_count_set', $data);
        } else {
            $this->load->view('no_permission');
        }
        $this->load->view('html_footer');
    }

    public function get_location_count_quick_info() {
        $date = $this->input->get_post('date');
        $sub_zone_id = $this->input->get_post('sub_zone_id');
        $query = $this->minventory->get_location_count_quick_info($sub_zone_id, $date);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $cell_title = $row->count_status;
            if ($row->status_id > 1)
                $cell_title .= '\n' . $row->username . '(' . $row->epf_number . ')';

            echo '{"count_id":' . $row->count_id . ',"status_id":' . $row->status_id . ',
					"color_code":"' . $row->color_code . '","cell_title":"' . $cell_title . '"}';
        }else {
            echo '{"count_id":0,"status_id":0,"color_code":"","cell_title":""}';
        }
    }

    public function get_location_count_list() {
        $date_start = $this->input->get_post('date_start');
        $date_end = $this->input->get_post('date_end');
        $query = $this->minventory->get_location_count_list($date_start, $date_end);
        $ret_val = "[";
        foreach ($query->result() as $row) {
            $ret_val .= '"' . $row->sub_zone_id . $row->date . '",';
        }
        $ret_val .= "]";
        echo $ret_val;
    }

    public function annual_count_set() {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        $count_start = 1;
        $count_end = 15;


        $data['count_start'] = $count_start;
        $data['count_end'] = $count_end;


        if ($this->mlogin->get_permission(SYS_INVENTORY_LOCATION_COUNT_PLAN_VIEW)) {
            $data['action'] = base_url() . "index.php/inventory/dashboard/annual_count_set";
            $data['count_status_list'] = $this->minventory->get_inventory_count_status();
            $data['location_list'] = $this->minventory->get_filtered_locations_list();
            $this->load->view('inventory/annual_count_set', $data);
        } else {
            $this->load->view('no_permission');
        }



        $this->load->view('html_footer');
    }

    public function pid_count_set() {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        $date_start = $this->input->get_post('ds');
        $day_count = $this->input->get_post('dc');

        $date_start = ($date_start == "" ? date('Y-m-d') : date('Y-m-d', strtotime($date_start)));

        $day_count = ($day_count == "" ? 21 : $day_count);
        $day_count = ($day_count < 14 ? 14 : $day_count);

        $date_end = date('Y-m-d', strtotime("+" . $day_count . " days", strtotime($date_start)));

        $product_ids = array();

        //if($_POST){
        $product_ids = explode("\r\n", $this->input->get_post('product_ids'));
        //}else{
        $pids_to_count = $this->minventory->get_pid_count_list($date_start, $date_end);

        foreach ($pids_to_count->result() as $pid_to_count) {
            array_push($product_ids, $pid_to_count->product_id);
        }
        //}

        $data['date_start'] = $date_start;
        $data['date_end'] = $date_end;
        $data['day_count'] = $day_count;

        if ($this->mlogin->get_permission(SYS_INVENTORY_LOCATION_COUNT_PLAN_VIEW)) {
            $data['action'] = base_url() . "index.php/inventory/dashboard/get_pid_list";
            $data['product_list'] = $this->minventory->get_filtered_product_list($product_ids);
            $data['product_id_list'] = $this->input->get_post('product_ids');
            $data['count_status_list'] = $this->minventory->get_inventory_count_status();
            $this->load->view('inventory/pid_count_set', $data);
        } else {
            $this->load->view('no_permission');
        }



        $this->load->view('html_footer');
    }

    public function pid_count_set_to_date() {
        $color_code = "";
        $status_id = 0;
        $count_id = 0;
        $message = "";
        $data = array();

        $data['user_created'] = 1;
        $data['product_id'] = $this->input->get_post('product_id');
        $data['date'] = $this->input->get_post('date');
        $today = date("Y-m-d");

        if (strtotime($data['date']) < strtotime($today)) {
            $message = "Sorry you cannot set counts for today or past dates";
        } else {

            if ($this->mlogin->get_permission(SYS_INVENTORY_LOCATION_COUNT_PLAN_UPDATE)) {
                if ($this->input->get_post('status_id') == 0) {
                    $count_id = $this->minventory->add_pid_record($data);

                    $status_id = 1;
                    $color_code = "#FC0";
                };
                if ($this->input->get_post('status_id') == 1) {
                    $count_id = $this->minventory->delete_pid_record($this->input->get_post('count_id'));
                    $count_id = 0;
                    $status_id = 0;
                    $color_code = "";
                }
            } else {
                $message = "Sorry you do not have permission to change the values here";
            }
        }
        echo '{"count_id":' . $count_id . ',"status_id": ' . $status_id . ',"color_code":"' . $color_code . '","scanner_name":"","message":"' . $message . '" }';
    }

    public function get_pid_count_list() {
        $date_start = $this->input->get_post('date_start');
        $date_end = $this->input->get_post('date_end');
        $query = $this->minventory->get_pid_count_list($date_start, $date_end);
        $ret_val = "[";
        foreach ($query->result() as $row) {
            $ret_val .= '"' . $row->product_id . $row->date . '",';
        }
        $ret_val .= "]";
        echo $ret_val;
    }

    public function get_pid_count_quick_info() {
        $date = $this->input->get_post('date');
        $product_id = $this->input->get_post('product_id');
        $query = $this->minventory->get_pid_count_quick_info($product_id, $date);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $cell_title = $row->count_status;
            if ($row->status_id > 1)
                $cell_title; //.= '\n'.$row->username.'('.$row->epf_number.')';

            echo '{"count_id":' . $row->count_id . ',"status_id":' . $row->status_id . ',
					"color_code":"' . $row->color_code . '","cell_title":"' . $cell_title . '"}';
        }else {
            echo '{"count_id":0,"status_id":0,"color_code":"","cell_title":""}';
        }
    }

    public function location_set_scanning_clearks() {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
        $date = $this->input->get_post('date');
        $date = ($date == "" ? date("Y-m-d") : $date);

        $continue = $this->input->get_post('continue');
        $continue = ($continue == "" ? 0 : $continue);

		$data['zone_list'] = $this->minventory->zone_list();
        $data['last_inventory_import'] = $this->mwms->get_last_inventory_imported_date();
        $data['continue'] = $continue;
        $data['date'] = $date;

        if ($continue == 1) {
            $data['scanners'] = $this->minventory->get_scanning_clearks();
            $data['sub_zones'] = $this->minventory->get_sub_zones_to_set_scanners($date, 1);
        }


        $this->load->view('inventory/location_set_scanning_cleark', $data);
        $this->load->view('html_footer');
    }

    public function pid_set_scanning_clearks() {

        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
        $date = $this->input->get_post('date');
        $date = ($date == "" ? date("Y-m-d") : $date);

        $continue = $this->input->get_post('continue');
        $continue = ($continue == "" ? 0 : $continue);


        $data['last_inventory_import'] = $this->mwms->get_last_inventory_imported_date();
        $data['continue'] = $continue;
        $data['date'] = $date;

        if ($continue == 1) {
            $this->minventory->import_pid_count_sub_zones($date);
            $data['scanners'] = $this->minventory->get_scanning_clearks();
            $data['sub_zones'] = $this->minventory->get_sub_zones_to_set_scanners($date, 2);
        }

        $this->load->view('inventory/pid_set_scanning_cleark', $data);
        $this->load->view('html_footer');
    }

	public function target_set_scanning_clearks_group(){
	
		$user_id = $this->input->get_post('user_id');
		$sub_zone_group_id= $this->input->get_post('sub_zone_group_id');
		$data['sub_zone_group_id']=$sub_zone_group_id;
		$data['user_assigned']=$user_id;
		$data['user_created']=$this->session->userdata("user_id");
		$data['status_id']=0;
		$date= $this->input->get_post('ds');
		$date= ($date == "" ? date('Y-m-d') : $date);
		$data['zone_list'] = $this->minventory->zone_list();
		$data['ds'] = $date;
		$data['date']=$date;
		$count_info = $this->minventory->get_count_info_group($data);
	
		$row_count=$count_info->num_rows();
			
			if($row_count>0){
				foreach($count_info->result() as $count_infos){
					
					$this->set_scanning_clearks($user_id,$count_infos->count_id,1);	
				
				}
			}
		echo $row_count;	
	}
	
    public function set_scanning_clearks($pass_user_id=0,$pass_count_id=0,$condition=0) {
		
		/* to be done: 
		1. check status before releasing user from assignment
		2. set data for count detail table.
		
		*/
		
		if($condition==1){
			$user_id=$pass_user_id;
			$count_id=$pass_count_id;
		}else{
				$user_id = $this->input->get_post('user_id');
				$user_id = ($user_id == "" ? 0 : $user_id);
				
				$count_id = $this->input->get_post('count_id');
				$count_id = ($count_id == "" ? 0 : $count_id);
		}
		$status_id = 0;
		$counting_type_id = 0;
		$sub_zone_id = 0;
		
		$count_info = $this->minventory->get_count_info($count_id);
		if ($count_info->num_rows() > 0) {
			$count = $count_info->row();
			$user_assigned = $count->user_assigned;
			$count_status = $count->count_status;
			$counting_type_id = $count->counting_type_id;
			$sub_zone_id = $count->sub_zone_id;
			$product_id = $count->product_id;
		} else {
			$status_id = 1;
		}
		
		if ($status_id <= 2) {
		$status_id = ($user_id == 0 ? 1 : 2);
		$data = array("user_assigned" => $user_id, "count_id" => $count_id,
		"status_id" => $status_id, "counting_type_id" => $counting_type_id,
		"sub_zone_id" => $sub_zone_id, "product_id" => $product_id);
		$message = $this->minventory->set_scanning_clearks($data);
		} else {
		$user_id = $user_assigned;
		$message = 'Sorry cannot change the user, Reason: ' . $count_status;
		}
		
    }

   

   

	public function print_barcode(){
			$zone_id = $this->input->GET('zone_id');	
			
			$this->load->view('html_header');
			$this->load->view('main_header_menu');
			$this->load->view('main_left_menu');
			if ($this->mlogin->get_permission(SYS_INVENTORY_PRINT_BARCODE_VIEW)) {
			$data['zone_list'] = $this->mlocation_manager->zone_list();
			
			if($zone_id > 0) {
			$data['sub_zone_group'] = $this->mlocation_manager->sub_zone_gorup($zone_id);	
			$data['zone_id'] = $zone_id;
			}
			$this->load->view('inventory/print_barcode',$data);
			} else {
			$this->load->view('no_permission');
			}
			
			$this->load->view('html_footer');

	}
	
		
		public function sub_zone_dataload(){
			
    	$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		
        $data['zone_list'] = $this->mlocation_manager->zone_list();
	 
        $zone_id=$this->input->GET('zone_id');	
        $sub_zone_group_id=$this->input->GET('sub_zone_group_id');
                
        $data['select_zone'] = $zone_id;
        $data['sub_zone_group_id']= $sub_zone_group_id;
        if($zone_id!=""){
           $data['sub_zone_group'] = $this->mlocation_manager->sub_zone_gorup($zone_id);  
         $data['sub_zone'] = $this->mlocation_manager->sub_zone($zone_id,$sub_zone_group_id);	   
        }
	
		
		$this->load->view('inventory/print_barcode',$data);	
	
		$this->load->view('html_footer');  
    
}

	public function stacking_result_count(){
		 if ($this->mlogin->get_permission(SYS_INVENTORY_STACKING_NORM_SEARCH_STACKING_NORM)) {
		$product_ids = array();
		$product_ids1 = array();
		
		if ( $this->input->get_post('product_ids')!="" or $this->input->get_post('sto')!="" or $this->input->get_post('zone')!=""
		) {
		
		$zone1=$this->input->get_post('zone');
		$sto=$this->input->get_post('sto');
		$product_ids = explode("\n", $this->input->get_post('product_ids')); 
		if($product_ids[0]!=""){
					$row_count= $this->minventory->row_count($product_ids,$zone1,$sto);

			}else{
			$row_count= $this->minventory->row_count($product_ids1,$zone1,$sto);	
			}
		
			
		echo ($row_count);
		//echo(count($product_ids));
				
		}
		 }else{
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		$this->load->view('no_permission'); 
		$this->load->view('html_footer');   
			  }
			}
			
	public function pid_check(){
		
		$pid=$this->input->get_post('pid');
		$row_count= $this->minventory->pid_check($pid);
		echo($row_count);
		 
	}
	
	public function add_record(){
	
		  if ($this->mlogin->get_permission(SYS_INVENTORY_STACKING_NORM_ADD_NEW_PID)) {
		$pid=$this->input->get_post('pid');
		$zone_id=$this->input->get_post('zone_id');
		$sto_id=$this->input->get_post('sto_id');
		
		$data_stack_norm = array(
		"product_id"=>$pid, 
		"st"=>"", 
		"product_stack_type_id"=>$sto_id,
		"ppl"=>"0",
		"lps"=>"0",
		"pps"=>"0",
		"zone"=>"ZONE".$zone_id,
		"zone_Id"=>$zone_id,
		"handling_quantity"=>"0",  
		    
		);
		$data_product = array(
		"client_code"=>0, 
		"product_id"=>$pid, 
		"description"=>"", 
	    
		);
		$recode= $this->minventory->add_record($data_stack_norm,$data_product );
		echo 1;
	
		
		 }else{
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		$this->load->view('no_permission'); 
		$this->load->view('html_footer');   
			  }
		
		}
	 public function update_stack_norms() {
        
	  if ($this->mlogin->get_permission(SYS_INVENTORY_STACKING_NORM_CHANGE_VALUES)) {	
		$update_data['update_id'] = $this->input->get_post('update_id');
        $update_data['update_value'] = $this->input->get_post('update_value');
        $message = $this->minventory->update_stack_norms($update_data);
		echo 1;
     }else{
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		$this->load->view('no_permission'); 
		$this->load->view('html_footer');   
			  }
    }
	
	
	public function target_count(){
		
		$this->load->view('html_header');
      	$this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		if ($this->mlogin->get_permission(SYS_INVENTORY_TARGET_COUNT)) {
		$zone_id=$this->input->get_post('zone_id');	
		$zone_id= ($zone_id == "" ? $zone_id=1 : $zone_id);	
			
		$data['zone_list']=$this->minventory->zone_list();
		
		$data['sub_zone_group_list']=$this->minventory->sub_zone_group_list($zone_id);

		$zones_group_id=$this->input->get_post('zones_group_id');
		
		if($zones_group_id !=""){
			$data['sub_zone_list_location']=$this->minventory->sub_zone_list($zones_group_id);
		}
		
		$sub_zone_id=$this->input->get_post('sub_zone_id');

		
		$data['sub_zone_list'] = $this->minventory->get_sub_zone_list($zone_id,$zones_group_id,$sub_zone_id);
		
		$data['zone_id_selected'] = $zone_id;
		$data['sub_zone_group_id_selected'] = $zones_group_id;
		$data['sub_zone_id_selected'] = $sub_zone_id;
		
		$date=$this->input->get_post('ds');
		$date= ($date == "" ? date('Y-m-d') : $date);
		$data['disabled_master']=$this->minventory->master_disabled_load($date);
		
		$data['count_number']=$this->input->get_post('count_number_select');
		$day_count=$this->input->get_post('dc');
		$day_count = ($day_count == "" ? 20 : $day_count);
		$data['count']=$day_count;
		
		$data['count_status_list'] = $this->minventory->get_inventory_count_status();
		$data['ds'] =$this->input->get_post('ds');	
		
		$data['zone_list']=$this->minventory->zone_list();
		
		$this->load->view('inventory/target_count',$data);
		$this->load->view('html_footer');   		
		 }else{
		
		$this->load->view('no_permission'); 
		
			  }
		$this->load->view('html_footer');   
	}
	
	public function target_count_set(){
		

		$day_count=$this->input->get_post('select_date');	
		$sub_zone_id=$this->input->get_post('sub_zone_id');
		$count_id=$this->input->get_post('count_id');
		$number_count=$this->input->get_post('number_count');
		if ($this->mlogin->get_permission(SYS_INVENTORY_PLAN_TARGET_COUT)) {
	
		if($count_id==0){
	
			$result=$this->minventory->set_target_count($sub_zone_id,$day_count,$number_count);	
			echo "#FFCC00_".$result;
		}else if($count_id>0){
			$result=$this->minventory->delete_target_count($count_id);
			echo $result;
		}
		}else{
			echo 1;
		}
	}
	
	public function pid_popup_data(){
		$tc=$this->input->get_post('tc');
		$date=$this->input->get_post('date');	
		$result=$this->minventory->pid_popup_data($tc,$date);		
		foreach($result as $rs){
	
		echo '<tr><td>'.$rs->product_id.'</td><td>'.$rs->description.'</td><td style="text-align:center">'.$rs->qty_inventory.'</td><td style="text-align:center">'.$rs->qty_booked.'</td><td style="text-align:center">'.$rs->qty_counted.'</td></tr>';
		
		}
	}
	
	public function load_shedual(){
		$date = $this->input->get_post('ds');
		$count_number = $this->input->get_post('count_number');	
		
			
			
		$result=$this->minventory->set_target_shedual($date,$count_number);
		foreach($result as $rs){
			echo "/".$rs->color_code."_".$rs->sub_zone_id."?".$rs->count_number."_".$rs->count_id."_".$rs->status_id."_".$rs->count_number;
		}	
		
	}
	
	 public function target_set_scanning_cleark() {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		
	 if ($this->mlogin->get_permission(SYS_INVENTORY_SET_SCANING_CLEARK)) {
        $date = $this->input->get_post('date');
		$sub_zone_group = $this->input->get_post('sub_zone_group');
		$page_change = $this->input->get_post('page');
        $date = ($date == "" ? date("Y-m-d") : $date);

        $continue = $this->input->get_post('continue');
        $continue = ($continue == "" ? 0 : $continue);

		$data['zone_list'] = $this->minventory->zone_list();
        $data['last_inventory_import'] = $this->mwms->get_last_inventory_imported_date();
        $data['continue'] = $continue;
        $data['date'] = $date;

     
            $data['scanners'] = $this->minventory->get_scanning_clearks();
          
   

			if($page_change==1){
				
				$data['sub_zones'] = $this->minventory->get_sub_zones_group_to_set_scanners_to_target($date, 3);
				$this->load->view('inventory/target_set_scanning_cleark_group', $data);
			
			}else{
				$data['sub_zone_group']=$sub_zone_group;
			    $data['sub_zones'] = $this->minventory->get_sub_zones_to_set_scanners_to_target($date, 3);
        		$this->load->view('inventory/target_set_scanning_cleark', $data);
			}
		
		} else {
			$this->load->view('no_permission'); 		
		}
        $this->load->view('html_footer');
    }
	
	public function download_Excel(){
		$filename="Target-Count-Result.csv";
		$c_number=$this->input->get_post('c_number');
		$s_date=$this->input->get_post('s_date');
		
		$result=$this->minventory->target_location_excel($c_number,$s_date);


		//$result2=$this->minventory->target_location_excel1($c_number,$s_date);
		 
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
	   
	    echo "Zone,Sub zone group,Sub Zone,Location,Product id,Description,Inventory Qty,Counted Qty,Confirmed Qty,Scanned Qty,Booked Qty,Date Time Counted,Date Time Inventory,Counted User Name,Count Number".PHP_EOL;
	    foreach($result as $rs){
		
		echo $rs->zone.",".$rs->sub_zone_group.",".$rs->sub_zone.",".$rs->location.",".$rs->product_id.",".$rs->description.",".$rs->qty_inventory.",".$rs->qty_counted.",".$rs->quantity_confirmed.",".$rs->qty_scanned.",".$rs->qty_booked.",".$rs->date_time_counted.",".$rs->date_time_inventory.",".$rs->name.",".$rs->count_number.PHP_EOL;
	
		}	
		echo "".PHP_EOL;
		
		//echo ""."Error Records".PHP_EOL;
//		 echo "Zone,Sub zone group,Sub Zone,Location,Product id,Description,Inventory Qty,Counted Qty,Scanned Qty,Booked Qty,Date Time Counted,Date Time Inventory,Counted User Name,Count Number".PHP_EOL;
//		  foreach($result2 as $rs){
//		
//		echo $rs->zone.",".$rs->sub_zone_group.",".$rs->sub_zone.",".$rs->location.",".$rs->product_id.",".$rs->description.",".$rs->qty_inventory.",".$rs->qty_counted.",".$rs->qty_scanned.",".$rs->qty_booked.",".$rs->date_time_counted.",".$rs->date_time_inventory.",".$rs->name.",".$rs->count_number.PHP_EOL;
//	
//		}	
   		
		
		
	}

	
	public function counting_finished_popup(){
		$zone_id=$this->input->get_post('zone_id');
		
		$sub_zone_group_id=$this->input->get_post('sub_zone_group_id');
		$sub_zone_id=$this->input->get_post('sub_zone_id');
		$date=$this->input->get_post('date');	
		$result=$this->minventory->pid_popup_data($date,$zone_id,$sub_zone_group_id,$sub_zone_id);	
		foreach($result->result() as $rs){
		
				
		echo '<tr><td>'.$rs->sub_zone.'-'.$rs->location.'</td><td style="text-align:center">'.$rs->product_id.'</td><td style="text-align:left">'.$rs->description.'</td><td style="text-align:center">'.$rs->inventory_quantity.'</td><td style="text-align:center">'.$rs->count_1.'</td><td style="text-align:center">'.$rs->count_2.'</td><td style="text-align:center">'.$rs->count_3.'</td><td style="text-align:center">'.$rs->count_4.'</td><td style="text-align:center">'.$rs->count_5.'</td><td style="display:none;text-align:center"><input id="'.$rs->current_count_number."-".$rs->sub_zone_id."-".$rs->location_id."-".$rs->product_id.'" onclick="re_count(this.id)" type="button" value="R(Location)"/></td><td style="display:none;text-align:center"><input id="'.$rs->current_count_number."-".$rs->sub_zone_id."-".$rs->location_id."-".$rs->product_id.'" onclick="re_count_location(this.id)" type="button" value="R(Level)"/></td></tr>';
			
		}
	
	}
	
//	public function target_recount(){
//		
//		$current_number = $this->input->get_post('current_number');
//		$sub_zone_id = $this->input->get_post('sub_zone_id');
//		$acction = $this->input->get_post('acction');
//		$select_date=$this->input->get_post('select_date');
//		$location_id=$this->input->get_post('location_id');
//		$product_id=$this->input->get_post('product_id');
//		if($acction=='true'){
//		$result=$this->minventory->target_recount($current_number,$sub_zone_id,$select_date,$location_id,$product_id);	
//		echo $result;
//	
//		}else{
//		
//		}
//		
//	}
//	
//	public function target_recount_location(){
//		
//		$current_number = $this->input->get_post('current_number');
//		$sub_zone_id = $this->input->get_post('sub_zone_id');
//		$acction = $this->input->get_post('acction');
//		$select_date=$this->input->get_post('select_date');
//		$location_id=$this->input->get_post('location_id');
//		$product_id=$this->input->get_post('product_id');
//		
//		$result=$this->minventory->target_recount_location($current_number,$sub_zone_id,$select_date,$location_id,$product_id);	
//		echo $result;
//		if($acction=='true'){
//		
//	
//		}else{
//		
//		}
//
//	
//	}
	
	public function pid_count_to_Excel(){
		$pid_count_date = $this->input->get_post('pid_count_date');
		$filename="PID-Count-Result.csv";		
		$result=$this->minventory->pid_count_excel($pid_count_date);
		$result2=$this->minventory->pid_count_excel1($pid_count_date);
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
	   
	     
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
	   
	    echo "Zone,Sub zone group,Sub Zone,Location,Product id,Description,Inventory Qty,Counted Qty,Date Time Counted,Date Time Inventory,Counted User Name".PHP_EOL;
	    foreach($result as $rs){
		
		echo $rs->zone.",".$rs->sub_zone_group.",".$rs->sub_zone.",".$rs->location.",".$rs->product_id.",".$rs->description.",".$rs->qty_inventory.",".$rs->qty_counted.",".$rs->date_time_counted.",".$rs->date_time_inventory.",".$rs->name.",".PHP_EOL;
	
		}	
		echo "".PHP_EOL;
		
		echo ""."Error Records".PHP_EOL;
		 echo "Zone,Sub zone group,Sub Zone,Location,Product id,Description,Inventory Qty,Counted Qty,Date Time Counted,Date Time Inventory,Counted User Name".PHP_EOL;
		  foreach($result2 as $rs){
		
		echo $rs->zone.",".$rs->sub_zone_group.",".$rs->sub_zone.",".$rs->location.",".$rs->product_id.",".$rs->description.",".$rs->qty_inventory.",".$rs->qty_counted.",".$rs->date_time_counted.",".$rs->date_time_inventory.",".$rs->name.",".PHP_EOL;
	
		}	
   		
	
	}
	
	
	public function location_to_Excel(){
		$pid_count_date = $this->input->get_post('location_date');
		$filename="Location-Count-Result.csv";		
		$result=$this->minventory->locatoin_to_excel($pid_count_date);
		$result2=$this->minventory->locatoin_to_excel1($pid_count_date);
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
	   
	     
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
	   
	    echo "Zone,Sub zone group,Sub Zone,Location,Product id,Description,Inventory Qty,Counted Qty,Date Time Counted,Date Time Inventory,Counted User Name".PHP_EOL;
	    foreach($result as $rs){
		
		echo $rs->zone.",".$rs->sub_zone_group.",".$rs->sub_zone.",".$rs->location.",".$rs->product_id.",".$rs->description.",".$rs->qty_inventory.",".$rs->qty_counted.",".$rs->date_time_counted.",".$rs->date_time_inventory.",".$rs->name.",".PHP_EOL;
	
		}	
		echo "".PHP_EOL;
		
		echo ""."Error Records".PHP_EOL;
		 echo "Zone,Sub zone group,Sub Zone,Location,Product id,Description,Inventory Qty,Counted Qty,Date Time Counted,Date Time Inventory,Counted User Name".PHP_EOL;
		  foreach($result2 as $rs){
		
		echo $rs->zone.",".$rs->sub_zone_group.",".$rs->sub_zone.",".$rs->location.",".$rs->product_id.",".$rs->description.",".$rs->qty_inventory.",".$rs->qty_counted.",".$rs->date_time_counted.",".$rs->date_time_inventory.",".$rs->name.",".PHP_EOL;
	
		}	
   		
	
	}
	
	
	public function location_popup(){
		$tc=$this->input->get_post('tc');
		$date=$this->input->get_post('date');	
		$result=$this->minventory->locaiton_popup_data($tc,$date);	
		foreach($result as $rs){
	
		echo '<tr><td>'.$rs->sub_zone.'-'.$rs->location.'</td><td style="text-align:left">00000000000</td><td style="">'.$rs->product_id.'</td><td style="text-align:left">'.$rs->description.'</td><td style="text-align:center">'.$rs->qty_inventory.'</td><td style="text-align:center">'.$rs->qty_counted.'</td></tr>';
		
		}
	
	}
	public function target_set_scanning_clearks() {
	
		$status_id = 0;
		$user_id = $this->input->get_post('user_id');
		$user_id = ($user_id == "" ? 0 : $user_id);
		
		$count_id = $this->input->get_post('count_id');
		$count_id = ($count_id == "" ? 0 : $count_id);
		
		$counting_type_id = 0;
		$sub_zone_id = 0;

		$count_info = $this->minventory->get_count_info($count_id);
		if ($count_info->num_rows() > 0) {
		$count = $count_info->row();
		$user_assigned = $count->user_assigned;
		$count_status = $count->count_status;
		$counting_type_id = $count->counting_type_id;
		$sub_zone_id = $count->sub_zone_id;
		$product_id = $count->product_id;
		} else {
		$status_id = 1;
		}
		
		if ($status_id <= 2) {
				
			if($counting_type_id==2){
				if($count->count_all_location==1){
				
					$status_id = ($user_id == 0 ? 1 : 2);
					$data = array("user_assigned" => $user_id, "count_id" => $count_id,
					"status_id" => $status_id, "counting_type_id" => $counting_type_id,
					"sub_zone_id" => $sub_zone_id, "product_id" => $product_id);
					$message = $this->minventory->target_set_scanning_clearks($data);
				
				}else{	
					$status_id = ($user_id == 0 ? 1 : 2);
					$data = array("user_assigned" => $user_id, "count_id" => $count_id,
					"status_id" => $status_id, "counting_type_id" => $counting_type_id,
					"sub_zone_id" => $sub_zone_id, "product_id" => $product_id);
				
					$result =$this->minventory->target_set_scanning_clearks_with_inventory($data);	
				}
			}else if($counting_type_id==3){
					$status_id = ($user_id == 0 ? 1 : 2);
					$data = array("user_assigned" => $user_id, "count_id" => $count_id,
					"status_id" => $status_id, "counting_type_id" => $counting_type_id,
					"sub_zone_id" => $sub_zone_id, "product_id" => $product_id);
					$message = $this->minventory->target_set_scanning_clearks($data);
			}
				} else {
				$user_id = $user_assigned;
				$message = 'Sorry cannot change the user, Reason: ' . $count_status;
				}
		 }

   public function print_pallet_id(){
		$pallet_code=array();
		
		$pallet_code= explode("\r\n", $this->input->get_post('product_ids'));
		
		//
		$data['pallet_code']=$this->minventory->print_bar($pallet_code);
		
		if($data['pallet_code']== null ){
			
		$pdfFilePath = "asn_number.pdf";
		
		$this->load->library('m_pdf');
		
		$pdf = $this->m_pdf->load();
		$mpdf = new mPDF('utf-8', array(150, 100));
		$mpdf->SetMargins("", "", 8);
		$pdf = $mpdf;
		$pdf->WriteHTML('<div style=" text-align:center;font-size:40px;color:red">Invalid pallet code</div><br>
		<div align="center"><img src=application/uploads/EMPLOYEE/images/sad_face.jpeg width="100" height="100"/></div>');

		$pdf->Output($pdfFilePath, "I");	
		}else{
		
		$html = $this->load->view('inventory/gen_barcode', $data, true);
		
		
		$pdfFilePath = "asn_number.pdf";
		
		$this->load->library('m_pdf');
		
		$pdf = $this->m_pdf->load();
		$mpdf = new mPDF('utf-8', array(150, 100));
		$mpdf->SetMargins("", "", 8);
		$pdf = $mpdf;
		$pdf->WriteHTML($html);
		
		$pdf->Output($pdfFilePath, "I");

		}
	 
   }
   
   
   public function disable_master_count(){
		$condition = $this->input->get_post('condition');
		$date = $this->input->get_post('date');
		$message = $this->minventory->disable_master_count($condition,$date);
		echo $message;
   }
   
    public function disable_child_count(){
		$condition = $this->input->get_post('condition');
		$date = $this->input->get_post('date');
		$sub_zone_id = $this->input->get_post('sub_zone_id');
		$message = $this->minventory->disable_child_count($condition,$date,$sub_zone_id);
		echo $message;
   }
	

	public function print_advance_inventory_barcodes(){
	$split_options=array();
		
		$split_options=explode(",",$this->input->get_post('option') );
		$split_zone_id=explode(",",$this->input->get_post('zone_id'));	
		$asn_number=$this->input->get_post('asn_number');
	
	$data['pallet_code']='';
		if(sizeof($split_options)==1){
			
					if($split_options[0]== 'full_p'){
							
						$data['pallet_code']=$this->minventory->print_advance_barcode('f',$split_zone_id,$asn_number);
					
								
					}else if($split_options[0]== 'part_p'){
						$data['pallet_code']=$this->minventory->print_advance_barcode('p',$split_zone_id,$asn_number);	
					
					}else{
					
						$data['pallet_code']=$this->minventory->print_advance_barcode('n',$split_zone_id,$asn_number);	
					}
				
		}else if(sizeof($split_options)==2){
					
			$data['pallet_code']=$this->minventory->print_advance_barcode('a',$split_zone_id,$asn_number);
			
		}else{
					
		}

		if($data['pallet_code']== null ){
			
		$pdfFilePath = "asn_number.pdf";
		
		$this->load->library('m_pdf');
		
		$pdf = $this->m_pdf->load();
		$mpdf = new mPDF('utf-8', array(150, 100));
		$mpdf->SetMargins("", "", 8);
		$pdf = $mpdf;
		$pdf->WriteHTML('<div style=" text-align:center;font-size:40px;color:red">?</div><br>
		<div align="center"><img src=application/uploads/EMPLOYEE/images/sad_face.jpeg width="100" height="100"/></div>');

		$pdf->Output($pdfFilePath, "I");	
		}else{//
		
		$html = $this->load->view('inventory/gen_barcode', $data, true);
		
		
		$pdfFilePath = "asn_number.pdf";
		
		$this->load->library('m_pdf');
		
		$pdf = $this->m_pdf->load();
		$mpdf = new mPDF('utf-8', array(150, 100));
		$mpdf->SetMargins("", "", 8);
		$pdf = $mpdf;
		$pdf->WriteHTML($html);
		
		$pdf->Output($pdfFilePath, "I");

		}

	
	}	 
	
	public function product_count(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
	 if ($this->mlogin->get_permission(SYS_INVENTORY_PID_COUNT)) {
		$date=$this->input->get_post('ds');
		$pid=$this->input->get_post('pid');
		
		$date= ($date == "" ? date('Y-m-d') : $date);
		$pid= ($pid == "" ? $pid="": $pid);
		
		$data['product_count_list']=$this->minventory->product_count_list_add_search($date,$pid);
		$data['zone_list']=$this->minventory->zone_list();
	
		$data['date']=$date;
		$data['pid']=$pid;
		
	
		$this->load->view('inventory/product_count',$data);
	} else {
			$this->load->view('no_permission'); 		
	}
		$this->load->view('html_footer');   	
		
	}
	
	public function load_sub_zone_group(){
		
		$zones_id=$this->input->get_post('zones_id');
		$result=$this->minventory->sub_zone_group_list($zones_id);
		echo '<option selected="selected" value=""></option>';
		foreach($result->result() as $results){
			
			echo '<option value="'.$results->sub_zone_group_id.'">'.$results->sub_zone_group.'</option>'	;
		}
                    	
                   
	}
	public function load_sub_zone(){
		
		$zones_group_id=$this->input->get_post('zones_group_id');
		$result=$this->minventory->sub_zone_list($zones_group_id);
		echo '<option selected="selected" value=""></option>';
		foreach($result->result() as $results){
			
			echo '<option value="'.$results->sub_zone_id.'">'.$results->sub_zone.'</option>'	;
		}
                    	
                   
	}
	
	public function add_count_location(){
	
		$date=$this->input->get_post('date');
		$pid=$this->input->get_post('pid');
		$value=$this->input->get_post('value');
		$field_name=$this->input->get_post('field_name');

		$result=$this->minventory->add_count_location($date,$pid,$value,$field_name);	
		echo $result;
		
		
	}
	
			
		
	public function load_product_count_result(){
		
		$date=$this->input->get_post('ds');
	
		$result=$this->minventory->product_count_list($date);	
			foreach($result->result() as $rs){
				echo "/".$rs->color_code."_".$rs->sub_zone_id.$rs->count_number.$rs->count_id."_".$rs->sub_zone_id."_".$rs->count_number."_".$rs->product_id."_".$rs->count_id."_".$rs->count_all_location;
		
			}
		
	}
	
	public function delete_product_count_row(){
		
		$date=$this->input->get_post('ds');
		$condition=$this->input->get_post('condition');
		$count_id=$this->input->get_post('count_id');
		$result=$this->minventory->product_count_row_delete($date,$condition,$count_id);	
		
	}
	public function count_all_location(){
		
		$date=$this->input->get_post('ds');
		$condition=$this->input->get_post('condition');
		$count_id=$this->input->get_post('count_id');
	
		$result=$this->minventory->count_all_location($date,$condition,$count_id);	
		
	}
	
	public function pid_validate(){
		
		$pid=$this->input->get_post('pid');
		$result=$this->minventory->pid_validate($pid);	
		
		echo $result;
	}
	
	public function pid_popup_detail(){
	
		$field=$this->input->get_post('field');
		$value=$this->input->get_post('value');
		$ds=$this->input->get_post('ds');
		
		$zone_id=0;
		$sub_zone_group_id=0;
		$sub_zone_id=0;
		
			if($field=="zone_id"){
				$zone_id=$value;
			}else if($field=="sub_zone_group_id"){
				$sub_zone_group_id=$value;
			}else if($field=="sub_zone_id"){
				$sub_zone_id=$value;
			}
	
		$result=$this->minventory->pid_popup_detail($ds,$zone_id,$sub_zone_group_id,$sub_zone_id);	
		
		foreach($result->result() as $rs){
		
				
		echo '<tr><td>'.$rs->sub_zone.'-'.$rs->location.'</td><td style="text-align:center">'.$rs->product_id.'</td><td style="text-align:left">'.$rs->description.'</td><td style="text-align:center">'.$rs->inventory_quantity.'</td><td style="text-align:center">'.$rs->count_1.'</td><td style="text-align:center">'.$rs->count_2.'</td><td style="text-align:center">'.$rs->count_3.'</td><td style="text-align:center">'.$rs->count_4.'</td><td style="text-align:center">'.$rs->count_5.'</td></tr>';
			
		}
		
	}
	
	public function download_Excel_pid(){
		$s_date=$this->input->get_post('s_date');
		$result=$this->minventory->pid_location_excel($s_date);
		$filename = "PID-Count.csv";
		 
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
	   
	    echo "Zone,Sub zone group,Sub Zone,Location,Product id,Description,Inventory Qty,Counted Qty,Scanned Qty,Booked Qty,Date Time Counted,Date Time Inventory,Counted User Name,Count Number".PHP_EOL;
	    foreach($result as $rs){
		
		echo $rs->zone.",".$rs->sub_zone_group.",".$rs->sub_zone.",".$rs->location.",".$rs->product_id.",".$rs->description.",".$rs->qty_inventory.",".$rs->qty_counted.",".$rs->qty_scanned.",".$rs->qty_booked.",".$rs->date_time_counted.",".$rs->date_time_inventory.",".$rs->name.",".$rs->count_number.PHP_EOL;
	
		}
	
	}
	
	public function pick_list(){
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
	if ($this->mlogin->get_permission(SYS_INVENTORY_PICK_LIST)) {
	  	
		
		$data['pick_list'] = $this->minventory->pick_list($pick_number=0);
		
		$this->load->view('inventory/pick_list',$data);
	} else {
		$this->load->view('no_permission'); 	
     }
		
 		$this->load->view('html_footer');	
	
	}
	
	
	public function location_assign(){
		
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		
		$date=$this->input->get_post('ds');
		$date= ($date == "" ? date('Y-m-d') : $date);
		
		$data['open_reference'] = $this->minventory->get_open_reference($date);
		$data['assign_list'] = $this->minventory->location_assign_list($date);
		$data['ds'] = $date;	
		$this->load->view('inventory/location_assign',$data);
 		$this->load->view('html_footer');
		
	}
	
	public function check_count_info(){
		
		$location=$this->input->get_post('location');
		$return = $this->minventory->check_count_info($location);
		echo $return;
	}
	
	public function new_location_assign(){
	
		$data['sub_zone_id']=$this->input->get_post('sub_zone_id');
		$data['pid']=$this->input->get_post('pid');
		$data['ref_val']=$this->input->get_post('ref_val');
		$data['location_id']=$this->input->get_post('location_id');
		$data['date']=$this->input->get_post('date');
			if($this->input->get_post('pid')==""){
				$data['counting_type']=3;
			}else{
				$data['counting_type']=2;
			}	

		$return = $this->minventory->new_location_assign($data);
		print_r( $return);
	}
	
	
	public function pick_details(){
		
		$pick_number  =  $this->input->get_post('pick_number');
			$this->load->view('html_header');
			$this->load->view('main_header_menu');
			$this->load->view('main_left_menu');
		if ($this->mlogin->get_permission(SYS_INVENTORY_PICK_DETAILS)) {
	
			$data['pick_number'] = $pick_number;
			
			$data['pick_list'] = $this->minventory->pick_list($pick_number);
			$data['pick_details'] = $this->minventory->pick_details($pick_number,$zone_id=0);
			$data['zone_list'] = $this->minventory->pick_ticket_zone_list($pick_number);
			
			$this->load->view('inventory/pick_details',$data);
		} else {
			$this->load->view('no_permission'); 	
      	}
			
			$this->load->view('html_footer');	
	} 
	
	public function set_sort_order(){
		
		$pick_detail_id = $this->input->get_post('pick_detail_id');
		$sort_val = $this->input->get_post('sort_val');
		
		$return = $this->minventory->set_sort_order($pick_detail_id,$sort_val);

	}
	public function print_pick_tickets(){
		
		$pick_number  =  $this->input->get_post('pick_number');
		$zone_id  =  $this->input->get_post('zone_id');
		$data['zone']  =  $this->input->get_post('zone');
		
		$data['pick_list'] = $this->minventory->pick_list($pick_number);
		$data['pick_details'] = $this->minventory->pick_details($pick_number,$zone_id);
	
		
		$this->load->library('m_pdf');
		$pdf = $this->m_pdf->load();
		
		$mpdf = new mPDF('utf-8');	
	    $mpdf->SetFont("times new roman");	
	    $mpdf->SetHeader("<table align='center'  width='1200' border='0'>
            <tr>
                <td width='200' height='47'><img src='web/logo.png' width='200' height='85'></td>
                <td  align='center' width='750'><div style='font-size:55px;font-weight:bold'>PICK TICKET</div></td> 
           		<td width='200'></td>
		    </tr>  
        </table>");
		
		$mpdf->setFooter("|| Date: {DATE j-m-Y } Time: {DATE h:i:sa} <br/>Printed by : ".$this->session->userdata('username')."  <br>");
		
		 $mpdf->SetMargins("", "", 25);
         $pdf = $mpdf;	
		 
		 $html = $this->load->view('inventory/pick_details_to_pdf',$data,true);
         $pdfFilePath = "Pick Ticket.pdf";
		
		 $pdf->WriteHTML($html);
	
	 	$pdf->Output($pdfFilePath, "I");
	}
	
	public function set_scanner_sort_order(){
		
		$count_id  =  $this->input->get_post('count_id');
		$sort_value  =  $this->input->get_post('sort_value');
		
		$return = $this->minventory->set_scanner_sort_order($count_id,$sort_value);
	
	}
	
	public function job_list(){
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
			//if ($this->mlogin->get_permission(SYS_INVENTORY_JOB_LIST)) {
				
				
				$data['job_list'] = $this->minventory->job_list($job_number=0);
				
				$this->load->view('inventory/job_list',$data);
			//} else {
				//$this->load->view('no_permission'); 	
			// }
		
 		$this->load->view('html_footer');	
	
		
	}
	public function job_details(){
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		$job_number  =  $this->input->get_post('job_id');
		$assembly_job_array =  array();
			//if ($this->mlogin->get_permission(SYS_INVENTORY_JOB_DETAILS)) {
				
				
				$data['job_list'] = $this->minventory->job_list($job_number);
				$data['assembly_job'] = $this->minventory->assembly_job($job_number );
				
				$data['assembly_job_ids'] = $this->minventory->assembly_job_id($job_number );
	
				foreach($data['assembly_job_ids']->result() as $row ){
					array_push($assembly_job_array,$row->assembly_job_id);
				
				}
				$data['assembly_job_details'] = $this->minventory->assembly_job_details($assembly_job_array);
				$data['job_number'] =$job_number;
				
				$this->load->view('inventory/job_details',$data);
			//} else {
				//$this->load->view('no_permission'); 	
			// }
		
 		$this->load->view('html_footer');	
	
		
	}
	public function create_barcode($asn_number){
		$files = glob('barcode_image/*'); // get all file names
			foreach($files as $file){ // iterate files
	  			if(is_file($file))	    unlink($file); // delete file
			}
	date_default_timezone_set("Asia/Colombo"); 


	$q= $asn_number; 

    $text = $q; 
    $size = (isset($_GET["size"]) ? $_GET["size"] : "40");
    $orientation = (isset($_GET["orientation"]) ? $_GET["orientation"] : "horizontal"); 
    $code_type = (isset($_GET["codetype"]) ? $_GET["codetype"] : "Code128"); 
    $code_string = "";

    if (strtolower($code_type) == "code128") {
        $chksum = 104;
        $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ($X = 1; $X <= strlen($text); $X++) {
            $activeKey = substr($text, ($X - 1), 1);
            $code_string .= $code_array[$activeKey];
            $chksum = ($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
        $code_string = "211214" . $code_string . "2331112";
    }
// Pad the edges of the barcode
    $code_length = 20;
    for ($i = 1; $i <= strlen($code_string); $i++)
        $code_length = $code_length + (integer) (substr($code_string, ($i - 1), 1));
    if (strtolower($orientation) == "horizontal") {
        $img_width = $code_length;
        $img_height = $size;
    } else {
        $img_width = $size;
        $img_height = $code_length;
    }
    $image = imagecreate($img_width, $img_height);
    $black = imagecolorallocate($image, 0, 0, 0);
    $white = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $white);
    $location = 10;
    for ($position = 1; $position <= strlen($code_string); $position++) {
        $cur_size = $location + ( substr($code_string, ($position - 1), 1) );
        if (strtolower($orientation) == "horizontal")
            imagefilledrectangle($image, $location, 0, $cur_size, $img_height, ($position % 2 == 0 ? $white : $black));
        else
            imagefilledrectangle($image, 0, $location, $img_width, $cur_size, ($position % 2 == 0 ? $white : $black));
        $location = $cur_size;
    }

    $path = 'barcode_image/';
	$image_file_name = $path . $q . '.png';
    imagepng($image, $path . $q . '.png');

	
	
	return $image_file_name;
		
		
	}
	public function print_job_details(){
		
		 $job_number  =  $this->input->get_post('job_id');
		 $assembly_job_array =  array();
		
				
				
				$data['job_list'] = $this->minventory->job_list($job_number);
				
					$rows = $data['job_list']->row();
					$ref_number = $rows->reference_number;
				$data['assembly_job'] = $this->minventory->assembly_job($job_number );
				
				$data['assembly_job_ids'] = $this->minventory->assembly_job_id($job_number );
	
				foreach($data['assembly_job_ids']->result() as $row ){
					array_push($assembly_job_array,$row->assembly_job_id);
				
				}
				$data['assembly_job_details'] = $this->minventory->assembly_job_details($assembly_job_array);
				
		$path=$this->create_barcode($ref_number);
		
		$this->load->library('m_pdf');
		$pdf = $this->m_pdf->load();
		
		$mpdf = new mPDF('utf-8');	
	    $mpdf->SetFont("times new roman");	
	    $mpdf->SetHeader("<table align='center'  width='1200' border='0'>
            <tr>
                <td width='200' height='47'><img src='web/logo.png' width='200' height='85'></td>
                <td  align='center' width='750'><div style='font-size:55px;font-weight:bold'>JOB</div></td> 
           		<td ><img src='".$path."' style='width:400px;height:60px'></td>	 
		    </tr>  
        </table>");
		
		$mpdf->setFooter("|| Date: {DATE j-m-Y } Time: {DATE h:i:sa} <br/>Printed by : ".$this->session->userdata('username')."  <br>");
		
		 $mpdf->SetMargins("", "", 25);
         $pdf = $mpdf;	
		 
		 
		
		 
		 $html = $this->load->view('inventory/job_details_print',$data,true);
         $pdfFilePath = "Job Details.pdf";
		
		 $pdf->WriteHTML($html);
	
	 	$pdf->Output($pdfFilePath, "I");
		
	}
	
	public function set_scanner_location_sort_order(){
		$locatoin_sort_value  =  $this->input->get_post('location_sort_val');
		$count_id  =  $this->input->get_post('count_id');
		
		
		$this->minventory->set_scanner_location_sort_order($locatoin_sort_value,$count_id );
	}
	
	public function load_scanner(){
		
		$sub_zone_id  =  $this->input->get_post('sub_zone_id');
		$user_assine_id  =  $this->input->get_post('user_assine_id');
		$date  =  $this->input->get_post('date');
		$result = $this->minventory->load_scanning_clearks($sub_zone_id,$date);
		$sperate="";
	
		foreach($result->result() as $scanner ){
			
			echo $sperate.$scanner->epf_number." - ".$scanner->name;
			$sperate=" / ";
		}
	}
	
	public function ex_summary(){
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		
		$zone_id  =  $this->input->get_post('zones');
		$zone_id = ($zone_id == "" ? 1 : $zone_id);
		
		$zone_name  =  $this->input->get_post('zone_name');
		$zone_name = ($zone_name == "" ? "ZONE1" : $zone_name);
		
		$date  =  $this->input->get_post('ds');
		 $date = ($date == "" ? date("Y-m-d") : $date);
		
			if ($this->mlogin->get_permission(SYS_INVENTORY_EXECUTIVE_SUMMARY)) {
				$data['zone_id']=$zone_id ;
				$data['ds']=$date ;
				$data['zone_name']=$zone_name ;
			$data['zone_list']=$this->minventory->zone_list();	
			$data['location_list'] = $this->minventory->ex_summary($zone_id,$date);	
			
			
			
			$this->load->view('inventory/executive_summary',$data);
		} else {
			$this->load->view('no_permission'); 	
      	}
			
			$this->load->view('html_footer');
	
		
	}
	
	public function count_report(){
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		
		$ds  =  $this->input->get_post('ds');
		$ds = ($ds == "" ? date("Y-m-d") : $ds);
		
			if ($this->mlogin->get_permission(SYS_INVENTORY_COUNTING_REPORT)) {
			$data['ds'] = $ds;
			$data['result'] = $this->minventory->count_report($ds);	
			
			
			$this->load->view('inventory/count_report',$data);
		} else {
			$this->load->view('no_permission'); 	
      	}
			
			$this->load->view('html_footer');
	}
	
	public function count_report_to_excel(){
	
	$dc  =  $this->input->get_post('ds');
	$dc = ($dc == "" ? date("Y-m-d") : $dc);
	
	
	$pid="";
	$count1=0;
	$count2=0;
	$count3=0;
	$count4=0;
	$count5=0;
	$totwms=0;
	$sap_inventory=0;
	$filename="Target-Count-Report.csv";
	$result = $this->minventory->count_report($dc);	
	 
	header('Content-type: text/csv');
	header('Content-disposition: attachment;filename='.$filename);
	  if($result->num_rows()>0){
	echo "Product ID,Description,Zone,Sub Zone,Location,Count1,Count2,Count3,Count4,Count5,WMS,SAP".PHP_EOL;  
		$i=0;
		foreach($result->result() as $rows ){
		$i++;
	
		 if($rows->product_id == $pid){
			 
			echo "".","."".",".$rows->zone.",".$rows->sub_zone.",".$rows->location.",".$rows->count_1.",".$rows->count_2.",".$rows->count_3.",".$rows->count_4.",".$rows->count_5.",".$rows->inventory_quantity.","."".PHP_EOL;
			$count1=$count1 + $rows->count_1;
			$count2=$count2 + $rows->count_2;
			$count3=$count3 + $rows->count_3;
			$count4=$count4 + $rows->count_4;
			$count5=$count5 + $rows->count_5;
			$totwms = $totwms + $rows->inventory_quantity;
			}else{	
				
			
				if($pid!=""){
				echo "".","."".","."".",".""."Total".","."".",".$count1.",".$count2.",".$count3.",".$count4.",".$count5.",".$totwms.",".$sap_inventory.PHP_EOL;
			if($rows->sap_qty==""){
				$sap_inventory =0;
			}else{
				$sap_inventory = $rows->sap_qty;
			}
				}
				echo "".","."".","."".",".""."".","."".","."".","."".","."".","."".","."".","."".","."".PHP_EOL;
				$count1=0;
				$count2=0;
				$count3=0;
				$count4=0;
				$count5=0;
				$totwms=0;
				$count1=$count1 + $rows->count_1;
				$count2=$count2 + $rows->count_2;
				$count3=$count3 + $rows->count_3;
				$count4=$count4 + $rows->count_4;
				$count5=$count5 + $rows->count_5;
				$totwms = $totwms + $rows->inventory_quantity;
				echo $rows->product_id.",".$rows->description.",".$rows->zone.",".$rows->sub_zone.",".$rows->location.",".$rows->count_1.",".$rows->count_2.",".$rows->count_3.",".$rows->count_4.",".$rows->count_5.",".$rows->inventory_quantity.","."".PHP_EOL;
			
			
				}
			
	
		$pid = 	$rows->product_id;
		}
		if($result->num_rows()==$i){
				echo "".","."".","."".",".""."Total".","."".",".$count1.",".$count2.",".$count3.",".$count4.",".$count5.",".$totwms.",".$sap_inventory.PHP_EOL;
				echo "".","."".","."".",".""."".","."".","."".","."".","."".","."".","."".","."".","."".PHP_EOL;
				}
	  }
	}
	
	public function ex_summary_sub_zone(){
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		
		$zone_id  =  $this->input->get_post('zones');
		$zone_id = ($zone_id == "" ? 1 : $zone_id);
		
		$zone_name  =  $this->input->get_post('zone_name');
		$zone_name = ($zone_name == "" ? "ZONE1" : $zone_name);
		
		$date  =  $this->input->get_post('ds');
		 $date = ($date == "" ? date("Y-m-d") : $date);
		
		if ($this->mlogin->get_permission(SYS_INVENTORY_EXECUTIVE_SUMMARY_SUB_ZONE)) {
			$data['zone_id']=$zone_id ;
			$data['ds']=$date ;
			$data['zone_name']=$zone_name ;
			$data['zone_list']=$this->minventory->zone_list();	
			$data['sub_zone_group_list'] = $this->minventory->ex_summary_sub_zone_group($date);
			$data['sub_zone_list'] = $this->minventory->ex_summary_sub_zone($date);	
			$data['ds'] =$date;
			$this->load->view('inventory/executive_summary_subzone',$data);
		} else {
			$this->load->view('no_permission'); 	
      	}
			
			$this->load->view('html_footer');

	}
	public function current_inventory_to_excel(){
		$filename="Current-inventory.csv";
	   //if ($this->mlogin->get_permission(SYS_INVENTORY_CURRENT_INVENTORY_TO_EXCEL)) {
	    $current_inventory  = $this->minventory->get_current_inventory();
	  	
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);

			
	    echo "Product ID,Description,Zone,Sub Zone Group,Sub Zone,Type,Location,Quantity".PHP_EOL;
	    foreach($current_inventory->result() as $rs ){
		
		echo $rs->product_id.",".$rs->description.",".$rs->zone.",".$rs->sub_zone_group.",".$rs->sub_zone.",".$rs->location_type.",".$rs->location.",".$rs->quantity.PHP_EOL;
	
		}	
		//}else{
	
			//}
	}
	
	public function current_inventory__pid_to_excel(){
		$filename="Current-inventory-ProducID.csv";
	   //if ($this->mlogin->get_permission(SYS_INVENTORY_CURRENT_INVENTORY_PID_TO_EXCEL)) {
	    $current_inventory  = $this->minventory->current_inventory_pid();
	  	
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);

			
	    echo "Product ID,Description,Quantity".PHP_EOL;
	    foreach($current_inventory->result() as $rs ){
		
		echo $rs->product_id.",".$rs->description.",".$rs->quantity.PHP_EOL;
	
		}	
		//}else{
	
			//}
	}
	
	public function scanner_allocation(){
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');	
		
		 $date  =  $this->input->get_post('ds');
		 $date = ($date == "" ? date("Y-m-d") : $date);
	 if ($this->mlogin->get_permission(SYS_INVENTORY_SCANNER_ALLOCATION)) {
		 	$data['ds'] = $date;
			$data['scanner_allocation'] = $this->minventory->scanner_allocation($date);	
			
			$this->load->view('inventory/scanner_allocation',$data);	
			 
	}else{
		$this->load->view('no_permission'); 	
      }
			
	    $this->load->view('html_footer');
		
	}

	public function download_Excel_team_distribution(){
	 $date  =  $this->input->get_post('ds');
	 $scanner_allocation = $this->minventory->scanner_allocation($date);	
	 $filename="Team-Distribution.csv";
	
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);

			
	    echo "EPF Number,Total location allocated to count,Total Counted,Progress".PHP_EOL;
	    foreach($scanner_allocation->result() as $rows ){

		echo $rows->epf_number.",".$rows->allocated_to_count.",".$rows->total_counted .",".number_format( ($rows->total_counted /$rows->allocated_to_count ) *100,0, '.', '' )."%".PHP_EOL;
	
		}	

	}
	
	public function save_ref(){
		
	 $count_id  =  $this->input->get_post('count_id');
	 $ref_val   =  $this->input->get_post('ref_val');
	 
	 	$this->minventory->save_ref($count_id,$ref_val);		
		
	}
	
	public function ref_distribution(){
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');	
		
		$date  =  $this->input->get_post('ds');
		$date = ($date == "" ? date("Y-m-d") : $date);
		$data['ds'] = $date;
		
		 
		if ($this->mlogin->get_permission(SYS_INVENTORY_REF_DISTRIBUTION)) {
			
			$data['ref'] = $this->minventory->ref_distribution($date,$epf="",$ref="");		 
			$this->load->view('inventory/ref_distribution',$data);	 
		}else{
		$this->load->view('no_permission'); 	
        }
			
	    $this->load->view('html_footer');

	}
	
	public function ref_details(){
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');	
		
		if ($this->mlogin->get_permission(SYS_INVENTORY_REF_DISTRIBUTION)) {
			$date  =  $this->input->get_post('ds');
			$ref  =  $this->input->get_post('ref');
			$epf_number  =  $this->input->get_post('epf_number');
			$data['ds']= $date;
			
			$data['ref'] = $this->minventory->ref_distribution($date,$epf_number,$ref);
			$data['ref_details'] = $this->minventory->ref_details($date,$epf_number,$ref);
			
			$this->load->view('inventory/ref_details',$data);	 
		}else{
			$this->load->view('no_permission'); 	
       }
			
	    $this->load->view('html_footer');
	}

	public function download_ref_detiails(){
			$date  =  $this->input->get_post('ds');
			$ref  =  $this->input->get_post('ref');
			$pid_tot  =  $this->input->get_post('pid_tot');
			$tot_qty  =  $this->input->get_post('tot_qty');
			$epf_number  =  $this->input->get_post('epf_number');
			$counted_location  =  $this->input->get_post('counted_location');
			$location_to_count  =  $this->input->get_post('location_to_count');

			$ref_details = $this->minventory->ref_details($date,$epf_number,$ref);		
		
		 $filename="Reference-Details.csv";
	
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);

		echo "Date".",".$date.PHP_EOL;
		echo "Site".","."Global Park Logistics (pvt) Ltd".PHP_EOL;
		echo "Count No.".",".$ref.PHP_EOL;
		echo "Team Number".",".$epf_number.PHP_EOL;
		echo "Total Product IDs".",".$pid_tot.PHP_EOL;
		echo "Total Qty".",".$tot_qty.PHP_EOL;
		echo "Counted Location".",".$counted_location.PHP_EOL;
		echo "Location to Count".",".$location_to_count.PHP_EOL;
		echo PHP_EOL;
		 echo "Location,Product ID,Description,Inventory Qty,Counted Qty,Remarks".PHP_EOL;	
		foreach($ref_details->result() as $rows_list ){

		echo $rows_list->location.",".$rows_list->product_id.",".$rows_list->description.",".$rows_list->qty_inventory.",".$rows_list->qty_counted.","."".PHP_EOL;

		}
	}
	
	public function ref_distribution_Excel(){
		$date  =  $this->input->get_post('ds');
		$ref = $this->minventory->ref_distribution($date,$epf="",$ref_val="");	
		$filename="Reference-Distribution.csv";
	
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
		
 	echo "Ref,Scanner,Location to Count,Location Counted,Progress,Count #,Total PID,Total Qty".PHP_EOL;	
		foreach($ref->result() as $row ){

		echo $row->reference .",".$row->epf_number.",".$row->locations_to_count.",".$row->counted_locations.",".number_format( ($row->counted_locations /$row->locations_to_count ) *100,0, '.', '' )."%".",".$row->count_number.",".$row->pid_counted.",".$row->qty_counted.PHP_EOL;

		}	 	
	}
	
	public function current_inventory_pid() {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

       // if ($this->mlogin->get_permission(SYS_INVENTORY_CURRENT_INVENTORY_PIDVIEW)) {
            $data['last_inventory_import'] = $this->mwms->get_last_inventory_imported_date();
            $data['current_inventory'] = $this->minventory->current_inventory_pid();
            $this->load->view('inventory/current_inventory_pid', $data);
        //} else {
          //  $this->load->view('no_permission');
        //}
        $this->load->view('html_footer');
    }
	
	public function remove_recode_count_details(){
		if ($this->mlogin->get_permission(SYS_INVENTORY_REMOVE_COUNT_RECORD)) {
			
			$count_details_id  =  $this->input->get_post('count_detail_id');	
			$result = $this->minventory->remove_recode_count_details($count_details_id);	
	
		}else {
      		echo "Sorry you do not have permission";
        }
	}
	
	public function reference_valide(){
	
		$ref_val  =  $this->input->get_post('ref_val');
		$result = $this->minventory->reference_valide($ref_val);
		echo $result;
	}
	
}	
