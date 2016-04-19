<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Colombo");		
class dashboard extends CI_Controller {
	public function __construct(){
		
		parent::__construct();
		 $this->load->model('mhe/Mmhe');
		 $this->load->model('user/mlogin');
	}
		
	public function mhe_list(){
			
	    $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');	
      if ($this->mlogin->get_permission(MHE_LIST)) {	
		$data['mhe_list']=$this->Mmhe->mhe_list();
	    $data['unit_list']=$this->Mmhe->unit_list();
        $this->load->view('mhe/mhe_list',$data);	
	  }else{
		$this->load->view('no_permission'); 	
		}
        $this->load->view('html_footer');
			
		
			
	}
		
		
	public function mhe(){
			
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');	
		if ($this->mlogin->get_permission(MHE_ADD_NEW)) {	
			
		$edit_mhe_number=$this->input->get_post('mhe_number');
		
		if($edit_mhe_number>0){
			
		$edit_detail=$this->Mmhe->edit_mhe_details($edit_mhe_number);
			
	    foreach($edit_detail as $edit_details){	
		
 		$data_load['mhe_num']=$edit_details->master_id;
		$data_load['capacity_count']=$edit_details->capacity;
		$data_load['mast']=$edit_details->mast;
		$data_load['capacity_unit']=$edit_details->capacity_unit_id;
		$data_load['mast_unit']=$edit_details->mast_unit_id;
		$data_load['rotation']=$edit_details->rotation;
		$data_load['rotation_unit']=$edit_details->rotation_unit_id;
		$data_load['tilt']=$edit_details->tilt_angle;
		$data_load['tilt_unit']=$edit_details->tilt_angle_unit_id;
		$data_load['model_name']=$edit_details->model_name;
		$data_load['brand_n']=$edit_details->brand_name;
		$data_load['category_name']=$edit_details->category_name;
		$data_load['fuel_type']=$edit_details->fuel_type_name;
		$data_load['supplier_name']=$edit_details->supplier;
		$data_load['contact']=$edit_details->contact_number;
		$data_load['status_type']=$edit_details->status; 
		$data_load['payment_term']=$edit_details->payment_term_type;
		$data_load['number']=$edit_details->mhe_number;  	
	
		
		
		}
		
		$data['category']=$this->Mmhe->get_category();
		$data['brand']=$this->Mmhe->get_brand();
		$data['model']=$this->Mmhe->get_model();
		$data['fuel']=$this->Mmhe->get_fuel();
		$data['unit']=$this->Mmhe->get_unit();
		$data['supplier']=$this->Mmhe->get_supplier();
		$data['payment']=$this->Mmhe->get_payment();
		$data['status']=$this->Mmhe->get_status();
		
		$mhe_details['capacity']=$this->input->get_post('capacity');
		$mhe_details['capacity_unit_id']=$this->input->get_post('capacity_id');
		$mhe_details['mast']=$this->input->get_post('mast');
		$mhe_details['mast_unit_id']=$this->input->get_post('mast_id');
		$mhe_details['rotation']=$this->input->get_post('rotation');
		$mhe_details['rotation_unit_id']=$this->input->get_post('rotation_id');
		$mhe_details['tilt_angle']=$this->input->get_post('tilt');
		$mhe_details['tilt_angle_unit_id']=$this->input->get_post('tilt_id');
		$mhe_details['model_id']=$this->input->get_post('model_id');
		$mhe_details['category_id'] = $this->input->get_post('category_id');
		$mhe_details['fuel_type_id']=$this->input->get_post('fuel_id');
		$mhe_details['supplier_id']=$this->input->get_post('supplier_id');
	    $mhe_details['payment_term_id']=$this->input->get_post('payment_id');
		$mhe_details['status_id']=$this->input->get_post('status_id');
		$mhe_details['mhe_number']=$this->input->get_post('mhe_client_number');

		$file="";
		if($this->input->get_post('condition')!=""){
		
		$file = $_FILES["photo"]['tmp_name'];
		print_r($file);
		
		 }
  
		
		
		
		$image_path = "application/uploads/MHE/images/".$edit_mhe_number.".jpg";			
						
		move_uploaded_file( $file, $image_path);
					
		if($this->input->get_post('capacity')!=""){
		$result=$this->Mmhe->edit_mhe($mhe_details,$edit_mhe_number);
		
	
		echo $result;
		}
		$this->load->view('mhe/mhe',array_merge($data_load,$data));	
		$this->load->view('html_footer');	
	
		}else {
		
		
		
		$data_load['mhe_num']="";
		$data_load['capacity_count']="";  
		$data_load['mast']="";  
		$data_load['mast_unit']="";  
		$data_load['rotation']="";  
		$data_load['rotation_unit']="";  
		$data_load['tilt']=""; 
		$data_load['tilt_unit']="";
		$data_load['model_name']="";  
		$data_load['brand_n']="";  
	    $data_load['category_name']="";  
		$data_load['fuel_type']=""; 
		$data_load['supplier_name']=""; 
		$data_load['contact']="";   
		$data_load['status_type']=""; 
		$data_load['payment_term']="";
		$data_load['number']="";                   	
		
		
		
		$data['category']=$this->Mmhe->get_category();
		$data['brand']=$this->Mmhe->get_brand();
		$data['model']=$this->Mmhe->get_model();
		$data['fuel']=$this->Mmhe->get_fuel();
		$data['unit']=$this->Mmhe->get_unit();
		$data['supplier']=$this->Mmhe->get_supplier();
		$data['payment']=$this->Mmhe->get_payment();
		$data['status']=$this->Mmhe->get_status();
		
		
	 
		
		
		
	   
		
		$mhe_details['capacity']=$this->input->get_post('capacity');
		$mhe_details['capacity_unit_id']=$this->input->get_post('capacity_id');
		$mhe_details['mast']=$this->input->get_post('mast');
		$mhe_details['mast_unit_id']=$this->input->get_post('mast_id');
		$mhe_details['rotation']=$this->input->get_post('rotation');
		$mhe_details['rotation_unit_id']=$this->input->get_post('rotation_id');
		$mhe_details['tilt_angle']=$this->input->get_post('tilt');
		$mhe_details['tilt_angle_unit_id']=$this->input->get_post('tilt_id');
		$mhe_details['model_id']=$this->input->get_post('model_id');
		$mhe_details['category_id'] = $this->input->get_post('category_id');
		$mhe_details['fuel_type_id']=$this->input->get_post('fuel_id');
		$mhe_details['supplier_id']=$this->input->get_post('supplier_id');
	    $mhe_details['payment_term_id']=$this->input->get_post('payment_id');
		$mhe_details['status_id']=$this->input->get_post('status_id');
	
		$mhe_details['mhe_number']=$this->input->get_post('mhe_client_number');
	
		 
	    if($this->input->get_post('capacity')!=""){
			
		$result= $this->Mmhe->add_new_mhe($mhe_details);
		
	    }
		
		
		$file="";
		if($this->input->get_post('condition')!=""){
		
		$file = $_FILES["photo"]['tmp_name'];
		$id=$this->Mmhe->get_lastrow_mhe();
		$max_id;
		
			foreach($id as $ids){
			$max_id=$ids->master_id;
			print_r($max_id);
		
			}
		
		
		$image_path = "application/uploads/MHE/images/".strval($max_id).".jpg";			
								
	    move_uploaded_file( $file, $image_path);
		}
		 
   		
	
		
		$this->load->view('mhe/mhe',array_merge($data_load,$data));	
		$this->load->view('html_footer');
		
		}
		}else{
		$this->load->view('no_permission'); 	
		}
	}
		
	
	
	public function select_model(){
	 	$data = $this->input->get_post('brand_id');	
	  
	    $brand=$this->Mmhe->select_brand($data);
	  
	   		 foreach($brand as $brands){
		  
		 	 $name=$brands->model_name;
		     $id=$brands->model_id;
		     echo "/".$id.",".$name;
		
	   		}
	  
	}
	public function add_new_model(){
	if ($this->mlogin->get_permission(MHE_ADD_MODEL)) {	
	
	$newmodel['model_name']=$this->input->get_post('new_model');
	$newmodel['brand_id']=$this->input->get_post('newbrand_id');

	$result=$this->Mmhe->addnew_model($newmodel);
		echo 1;
	
	}else{
		$this->load->view('html_header');
      	$this->load->view('main_header_menu');
       	$this->load->view('main_left_menu');
		$this->load->view('no_permission'); 	
		}
		
	}

   	public function mhe_ava_list() {
		
      	 $this->load->view('html_header');
      	 $this->load->view('main_header_menu');
       	 $this->load->view('main_left_menu');
 		 	if ($this->mlogin->get_permission(MHE_AVAILABILITY)) {
        	$date_start = $this->input->get_post('ds');
        	$day_count = $this->input->get_post('dc');

       		$date_start = ($date_start == "" ? date('Y-m-d') : date('Y-m-d', strtotime($date_start)));

            $day_count = ($day_count == "" ? 7 : $day_count);
            $day_count = ($day_count < 7 ?14 : $day_count);

            $date_end = date('Y-m-d', strtotime("+" . $day_count . " days", strtotime($date_start)));

     
            $data['date_start'] = $date_start;
            $data['date_end'] = $date_end;
            $data['day_count'] = $day_count;
		    $data['mhe_list']=$this->Mmhe->mhe_vw_list(); 
		    $data['mhe_status']=$this->Mmhe->mhe_status(); 
		    $data['result']="";
		
	
	
		    $this->load->view('mhe/mhe_ availability', $data);

            }else{
	        $this->load->view('no_permission'); 
	        }
       	   $this->load->view('html_footer');
   	 }
	
	public function mhe_schedule_change(){
			
		if ($this->mlogin->get_permission(MHE_CHANGE_STATUS)) {
 
		$data_mhe=$this->input->get_post('mhe_data');
		$status_data=$this->input->get_post('ava');
		$mhe_save= explode("_",$data_mhe);
	
		$mhe_id= $mhe_save[1];
	
		$user_date=$this->session->userdata('username');
		
		$result=$this->Mmhe->mhe_schedule_delete($mhe_id,$mhe_save[2],$status_data,$user_date); 
		echo $result;
		}else{
 		$this->load->view('html_header');
       	$this->load->view('main_header_menu');
       	$this->load->view('main_left_menu');
		$this->load->view('no_permission');  
		}
	}
	
	public function set_schedule(){
		$date_start = $this->input->get_post('date_start');
        $day_count = $this->input->get_post('date_count');
        $date_start = ($date_start == "" ? date('Y-m-d') : date('Y-m-d', strtotime($date_start)));

        $day_count = ($day_count == "" ? 7 : $day_count);
        $day_count = ($day_count < 7 ?14 : $day_count);

        $date_end = date('Y-m-d', strtotime("+" . $day_count . " days", strtotime($date_start)));		
		$mhe_today=$this->Mmhe->mhe_today($date_start,$date_end); 
		
		foreach($mhe_today as $todays){
		echo "_".$todays->color_code."/".$todays->she_date."/".$todays->master_id."/".$todays->status;	
		}
	}	

	public function download_Excel(){
		if ($this->mlogin->get_permission(MHE_DOWNLOAD_EXCEL)) {		
		$date_start = $this->input->get_post('date_start');
        $day_count = $this->input->get_post('date_count');

        $date_start = ($date_start == "" ? date('Y-m-d') : date('Y-m-d', strtotime($date_start)));

        $day_count = ($day_count == "" ? 7 : $day_count);
        $day_count = ($day_count < 7 ?14 : $day_count);

        $date_end = date('Y-m-d', strtotime("+" . $day_count . " days", strtotime($date_start)));	

		$result=$this->Mmhe->data_excel($date_start,$date_end); 
		$filename="MHE-Availability-List.csv";
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
		
		echo "MHE_CATEGORY,MHE ID,DATA ,STATUS,SUPPLIER_NAME".PHP_EOL;
	
		
	    foreach($result as $results){
		echo $results->category_name.",".$results->mhe_number.",".$results->she_date.",".$results->status.",".$results->supplier.PHP_EOL;
		}	
   		
		}else{
			 $this->load->view('html_header');
       		 $this->load->view('main_header_menu');
       		 $this->load->view('main_left_menu');
			 $this->load->view('no_permission');   
		}
		
	}	
	public function mhe_profile(){
	
		$mhe_number = $this->input->get_post('mhe_master_id');
		$mhe_list=$this->Mmhe->edit_mhe_details($mhe_number );
		
		foreach($mhe_list as $mhe_lists){
			
			echo $mhe_lists->mhe_number."_".$mhe_lists->category_name."_".$mhe_lists->fuel_type_name."_".$mhe_lists->supplier."_".$mhe_lists->contact_number;
			
			}
	


     
	 
	 
	 
	}
	public function mhe_ex(){
		 $num=$this->input->get_post('mhe_num');
	 	 $result= $this->Mmhe->mhe_ext($num);
		 echo($result);
	
	
	}

	public function lp_schedule(){
		 $this->load->view('html_header');
       	 $this->load->view('main_header_menu');
       	 $this->load->view('main_left_menu');
		
		 
		  date_default_timezone_set("Asia/Colombo");
 		  $today['sdate'] = date("Y-m-d");
 
  		  $this->load->view('mhe/schedule',$today);
	}
	
	public function lp_schedule_load(){
						
		$result=$this->Mmhe->add_lp_asn();		
		foreach($result as $results){ 
		echo "_".$results->lp_asn_id."/".$results->start_time."/".$results->end_time."/".$results->bay_id;	
		}
	}
	public function lp_schedule_search(){
		 $this->load->view('html_header');
       	 $this->load->view('main_header_menu');
       	 $this->load->view('main_left_menu');
		 $date['sdate']=$this->input->get_post('date_start');
	 	 $this->load->view('mhe/schedule',$date);
		
	}
	
	
	
	public function remove_event(){
		
		$number=$this->input->get_post('event_name');		
		$result=$this->Mmhe->remove_li_asn($number);
		
	}
	public function update_bay(){
		$number=$this->input->get_post('event_name');
		$bay=$this->input->get_post('bay_name');
		$st_date=$this->input->get_post('bay_start');
		$en_date=$this->input->get_post('bay_end');		
		$result=$this->Mmhe->update_lp_asn($number,$bay,$st_date,$en_date);
		
	}
	
	
	public function update_schedule(){
		$event_id=$this->input->get_post('event_name');
		$data['end_time']=$this->input->get_post('update_hour');
		// $data['start_time']=$this->input->get_post('start_time');
		//echo $update.$event_name.$end_hour;
		$result=$this->Mmhe->resize_lp_asn($data,$event_id);
		echo $result;
	
			
	}
	
	public function mhe_runing_chart(){
	 	 $this->load->view('html_header');
      	 $this->load->view('main_header_menu');
       	 $this->load->view('main_left_menu');
 		 	if ($this->mlogin->get_permission(MHE_AVAILABILITY)) {
        	$date_start = $this->input->get_post('ds');
        	$day_count = $this->input->get_post('dc');
			
		 	$day_count=4;
			$date_start = ($date_start == "" ? date('Y-m-d') : date('Y-m-d', strtotime($date_start)));
		
            $day_count = ($day_count == "" ? 4 : $day_count);
          //  $day_count = ($day_count < 7 ?14 : $day_count);

            $date_end = date('Y-m-d', strtotime("+" . $day_count . " days", strtotime($date_start)));

     
            $data['date_start'] = $date_start;
            $data['date_end'] = $date_end;
            $data['day_count'] = $day_count;
		    $data['mhe_list']=$this->Mmhe->mhe_vw_list(); 
		    $data['mhe_status']=$this->Mmhe->mhe_status(); 
		    $data['result']="";
		
	
	
		    $this->load->view('mhe/mhe_runing_chart', $data);
                                  
            }else{
	        $this->load->view('no_permission'); 
	        }
       	    $this->load->view('html_footer');
		
	}
	
	public function runing_chart_save(){
		$master_id = $this->input->get_post('master_id');
        $date = $this->input->get_post('date');		
		$r_start = $this->input->get_post('r_start');
        $r_end = $this->input->get_post('r_end');	
		$epf=$this->input->get_post('epf_number');		
		$result=$this->Mmhe->runing_chart($master_id,$date,$r_start,$r_end,$epf);
		echo $result;
	
	}
	
	public function set_schedule_runing_chart(){
		$result=$this->Mmhe->runing_chart_schedule();
			foreach($result as $results){
			echo "_".$results->master_id."/".$results->date."/".$results->recoding_start."/".$results->recoding_end."/".$results->epf_number."/".
			$results->runing_chart_id;
			}
	
	}
	
	public function download_Excel_runing_chart(){
		$filename="MHE-Runing_chart.csv";
		$date=$this->input->get_post('date');
		
		$result=$this->Mmhe->runing_chart_excel($date);

		 
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
	   
	    echo "MHE Name,Date,Record Start,Record End,Deference".PHP_EOL;
	    foreach($result as $rs){
		
		echo $rs->category_name." ".$rs->mhe_number.",".$rs->date.",".$rs->recoding_start.",".$rs->recoding_end.",".$rs->deference.PHP_EOL;
	
		}	
	}
	
	public function delete_status_data(){
	$status_id=$this->input->get_post('status_id');
	$return=$this->Mmhe->delete_runing_chart_data($status_id);
	echo $return;
		
	}
		
	
	
}

