<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Location_manager extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('inventory/mlocation_manager');
		$this->load->model('inventory/minventory');
        $this->load->model('user/mlogin');
    }

    
	public function zone_list(){
		$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
	
		 if ($this->mlogin->get_permission(ZONE_LIST)) {	
		 $data['zone_list'] = $this->mlocation_manager->zone_list();

		 $this->load->view('inventory/zone_list',$data);
	 	 }else{
		
		$this->load->view('no_permission'); 
			  }
		$this->load->view('html_footer');
	}

    public function zone_delete(){
		 if ($this->mlogin->get_permission(ZONE_REMOVE)) {
			$zone_id=$this->input->GET('zone_id');
	
			$data = $this->mlocation_manager->zone_delete($zone_id);
		
			echo $data;
		 }else{
			echo 0;	
		}
	}
        
    public function new_zone(){
        $zone_name=$this->input->GET('zone_name');

		$data = $this->mlocation_manager->new_zone($zone_name);
	
		echo $data;    
            
     }
        
        
    public function zone_edit(){
        $zone_id=$this->input->get_post('zone_id');
        $zone_name=$this->input->get_post('name');


        $data = $this->mlocation_manager->edit_zone($zone_id,$zone_name);
        echo $data;
     }

     public function sub_zone_group_edit(){
		$zone_id=$this->input->get_post('zone_id');
        $zone_name=$this->input->get_post('name');
        $data = $this->mlocation_manager->edit_sub_zone_group($zone_id,$zone_name);
        echo $data;
	
	}
	public function sub_zone_group_zone_edit(){
		$sub_zonegroup_id=$this->input->get_post('zone_id');
        $zone_name=$this->input->get_post('name');
   		
   
        $data = $this->mlocation_manager->edit_sub_zone_group_zone($sub_zonegroup_id,$zone_name);
        echo $data;
	
	}

    public function sz_group_zone_load(){
    
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		if ($this->mlogin->get_permission(SUB_ZONE_GROUP_LIST)) {	
        $data['zone_list'] = $this->mlocation_manager->zone_list();

		$this->load->view('inventory/sub_zone_group',$data);
		}else{
		$this->load->view('no_permission'); 
			  }
		$this->load->view('html_footer');  
	}

    public function sub_zone_group(){
    
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
        $zone_id=$this->input->GET('zone_id');
        $data['zone_list'] = $this->mlocation_manager->zone_list();
        $data['sub_zone_group'] = $this->mlocation_manager->sub_zone_gorup($zone_id);
        $data['select_zone'] = $zone_id;

        $this->load->view('inventory/sub_zone_group',$data);
        $this->load->view('html_footer');   
    }

    public function sub_zone_group_delete(){
	   if ($this->mlogin->get_permission(SUB_ZONE_GROUP_REMOVE)) {	 
			$zone_id=$this->input->GET('sub_zone_group_id');
	
			$data = $this->mlocation_manager->sub_zone_group_delete($zone_id);
		
			echo $data;  
	   }else{
			echo 0;		   
	   }  
    }

    public function sub_zone_group_add(){
    
        $zone_id=$this->input->GET('zone_id');
        $sub_value=$this->input->GET('sub_value');
		$data = $this->mlocation_manager->sub_zone_group_add($zone_id,$sub_value);
	
		echo $data;  
       
    }

    public function sub_zone_load(){
    
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		if ($this->mlogin->get_permission(SUB_ZONE_LIST)) {
        $data['zone_list'] = $this->mlocation_manager->zone_list();
	 
		$zone_id=$this->input->GET('zone_id');	
          $data['select_zone'] = $zone_id;
        if($zone_id!=""){
            
         $data['sub_zone_group'] = $this->mlocation_manager->sub_zone_gorup($zone_id);	   
           $data['sub_zone'] = $this->mlocation_manager->sub_zone($zone_id,$sub_zone_group_id="");
        }
		$this->load->view('inventory/sub_zone',$data);	
		}else{
		
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
	
		$this->load->view('inventory/sub_zone',$data);	
	
		$this->load->view('html_footer');  
    
	}

    public function sub_zone_delete(){
		 if ($this->mlogin->get_permission(SUB_ZONE_REMOVE)) {	 
			$zone_id=$this->input->GET('sub_zone_id');
			$data = $this->mlocation_manager->sub_zone_delete($zone_id);
			echo $data;  
		 }else{
			echo 0	;
		}
	}
    
	public function sub_zone_edit(){
		$zone_id=$this->input->get_post('zone_id');
        $zone_name=$this->input->get_post('name');
        $data = $this->mlocation_manager->edit_sub_zone($zone_id,$zone_name);
        echo $data;
	
    }
	public function sub_zone_zone_group_edit(){
		$zone_id=$this->input->get_post('zone_id');
        $sub_zone_id=$this->input->get_post('name');
        $data = $this->mlocation_manager->edit_sub_group_zone($zone_id,$sub_zone_id);
        echo $data;
	
    }
    
  	public function sub_zone_add(){
    
        $zone_id=$this->input->GET('zone_id');
        $sub_value=$this->input->GET('sub_value');
        $sub_zone_group=$this->input->GET('sub_zone_group');
		$data = $this->mlocation_manager->sub_zone_add($zone_id,$sub_value,$sub_zone_group);
		echo $data;  
       
    }
    
	public function location_load(){
    
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		 if ($this->mlogin->get_permission(LOCATION_LIST)) {
        $data['zone_list'] = $this->mlocation_manager->zone_list();
	 
		$zone_id=$this->input->GET('zone_id');	
        $data['select_zone'] = $zone_id;
      
        $location_type="";
        $sub_zone_id="";   
        $data['sub_zone'] = $this->mlocation_manager->sub_zone_location($zone_id);	     
        $data['location_type'] = $this->mlocation_manager->location_type();	  
	  	$data['location_type'] = $this->mlocation_manager->location_type();	 	
		$this->load->view('inventory/location',$data);	
		 }else{	
		$this->load->view('no_permission'); 
		}
		$this->load->view('html_footer');  
	} 

    public function location_dataload(){
    	$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		$data['zone_list'] = $this->mlocation_manager->zone_list();
	    $zone_id=$this->input->GET('zone_id');	
        $sub_zone_id=$this->input->GET('sub_zone_id');
     	$data['select_zone'] = $zone_id;
        $data['sub_zone_id']= $sub_zone_id;
       if($zone_id!=""){
         $location_type="";
         $data['sub_zone'] = $this->mlocation_manager->sub_zone_location($zone_id);	   
         $data['location'] = $this->mlocation_manager->location($location_type,$sub_zone_id);	   
         $data['location_type'] = $this->mlocation_manager->location_type();	 
	 	}
		$this->load->view('inventory/location',$data);	
		$this->load->view('html_footer');  
    
	}
    public function location_type_edit(){
        $location_id=$this->input->GET('location_id');
        $location_type_id=$this->input->GET('location_type_id');
         $location=$this->input->GET('location');
        if($location_type_id!=""){
        $data = $this->mlocation_manager->location_type_edit( $location_id,$location_type_id);
        }else{
        $data = $this->mlocation_manager->location_edit( $location_id,$location);    
        }
        echo $data;  

    }
	public function location_type_sub_zone_edit(){
        $location_id=$this->input->GET('location_id');
        $subzone_id=$this->input->GET('subzone_id');
        $data = $this->mlocation_manager->location_type_subzone_edit( $location_id, $subzone_id);
        echo $data;  

    }
		
    public function location_add(){
    
        $sub_zone_id=$this->input->GET('sub_zone_id');
        $location_type_id=$this->input->GET('location_type');
        $location=$this->input->GET('location');
		$data = $this->mlocation_manager->location_add($sub_zone_id,$location_type_id, $location);
	
		echo $data;  
       
	 }

    public function location_delete(){
		 if ($this->mlogin->get_permission(LOCATION_REMOVE)) {	 
			$location_id=$this->input->GET('location_id');
			$data = $this->mlocation_manager->location_delete($location_id);
			echo $data;   
		 }else{
			echo 0;
		 }
	}
	
	public function result(){
	
    	$this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
			 if ($this->mlogin->get_permission(SYS_INVENTORY_COUNTING_RESULT)) {
				$date = $this->input->get_post('ds');
				
				$zone_id = $this->input->get_post('zone_id');
				$zone_id= ($zone_id == "" ? $zone_id=1 : $zone_id);	
				
				$date= ($date == "" ? date('Y-m-d') : $date);
				$data['zone_list'] = $this->minventory->zone_list();
				$data['ds'] = $date;
				$data['results'] = $this->mlocation_manager->all_result($date,$confirm=0,$zone_id);	
				$data['zone_id']=$zone_id;
		$this->load->view('inventory/all_result',$data);	
	
			 }else{
				$this->load->view('no_permission'); 	
			}
				$this->load->view('html_footer');  
	}
	
	
	public function result_confirmed(){
		if ($this->mlogin->get_permission(SYS_INVENTORY_CONFIRM_RESULT)) {
			
			$pid = $this->input->get_post('pid');
			$location_id = $this->input->get_post('location_id');
			$count_id = $this->input->get_post('count_id');
			$date = $this->input->get_post('date');
		$con_val = $this->input->get_post('con_val');
			$sub_zone_id = $this->input->get_post('sub_zone_id');
			$data['results'] = $this->mlocation_manager->result_confirmed($pid,$location_id,$count_id,$date,$sub_zone_id,$con_val);
			print_r($data['results']);	
		}else{
			echo 0;
		}	
			
	}
	
	public function recount_result(){
		
		if ($this->mlogin->get_permission(SYS_INVENTORY_SET_RECOUNT)) {
			$location_id = $this->input->get_post('location_id');
			$count_id = $this->input->get_post('count_id');
			$sub_zone_id = $this->input->get_post('sub_zone_id');
			$date = $this->input->get_post('date');
			
			
			$data['results'] = $this->mlocation_manager->recount_result($location_id,$count_id,$sub_zone_id,$date);	
			print_r($data['results']);
		}else{
			echo "0";
		}
	}
	public function confirmed_result(){
		
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		 if ($this->mlogin->get_permission(SYS_INVENTORY_CONFIRMED_RESULT)) {
		$date = $this->input->get_post('ds');
		$date= ($date == "" ? date('Y-m-d') : $date);
		$data['zone_list'] = $this->minventory->zone_list();
		$data['ds'] = $date;
		
		$zone_id = $this->input->get_post('zone_id');
		$zone_id= ($zone_id == "" ? $zone_id=1 : $zone_id);	
		
		
		$scmbos = $this->input->get_post('scmbos');
		$scmbos= ($scmbos == "" ? $scmbos="" : $scmbos);	
		
		$data['scmbos'] = $scmbos;
		
		$data['results'] = $this->mlocation_manager->all_result($date,$confirm=1,$zone_id);	
		
		
		//print_r($data['results']);
		$data['zone_id']=$zone_id;
		$this->load->view('inventory/confirmed_result',$data);	
		
		 }else{
		$this->load->view('no_permission'); 	
		}
		$this->load->view('html_footer');  
		
	}
	
	public function undo_recount_result(){
		if ($this->mlogin->get_permission(SYS_INVENTORY_UNDO_CONFIRMED_RESULT)) {
			$location_id = $this->input->get_post('location_id');
			$product_id = $this->input->get_post('product_id');
			$sub_zone_id = $this->input->get_post('sub_zone_id');
			$date = $this->input->get_post('date');	
			
			$data['results'] = $this->mlocation_manager->undo_recount_result($location_id,$product_id,$sub_zone_id,$date);		
		}else{
			echo "Sorry you do not have permission";
		}
	}
	
	public function download_Excel_result(){
		
		$date = $this->input->get_post('ds');	
		$results = $this->mlocation_manager->all_result($date,$confirm=1,$zone=0);	
		
		$filename="Confirmed-Result.csv";
		 
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
		
		echo "Zone,SZG,Sub Zone,Location,Product ID,Description,Inventory QTY,COUNT 1,COUNT 2,COUNT 3,COUNT 4,COUNT 5,Confirmed Qty".PHP_EOL;
		foreach($results->result() as $rs){
	
		echo $rs->zone.",".$rs->sub_zone_group.",".$rs->sub_zone.",".$rs->location.",".$rs->product_id.",".$rs->description.",".$rs->inventory_quantity.",".$rs->count_1.",".$rs->count_2.",".$rs->count_3.",".$rs->count_4.",".$rs->count_5.",".$rs->quantity_confirmed.PHP_EOL;
		
		}
		
	}
	
	public function download_Excel_result_pid(){
		
		$date = $this->input->get_post('ds');	
		$results = $this->mlocation_manager->download_Excel_result_pid($date,$confirm=1,$zone=0);	
		
		$filename="Confirmed-Result-PID.csv";
		 
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
		
		echo "Product ID,Description,Inventory QTY,COUNT 1,COUNT 2,COUNT 3,COUNT 4,COUNT 5,Confirmed Qty".PHP_EOL;
		foreach($results->result() as $rs){
	
		echo $rs->product_id.",".$rs->description.",".$rs->inventory_quantity.",".$rs->count_1.",".$rs->count_2.",".$rs->count_3.",".$rs->count_4.",".$rs->count_5.",".$rs->quantity_confirmed.PHP_EOL;
		
		}
		
	}
	
	public function count_result(){
		
		$date = $this->input->get_post('ds');	
		$results = $this->mlocation_manager->count_result($date);	
		
		$filename="Counting-Result.csv";
		 
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
		
		echo "Zone,SZG,Sub Zone,Location,Product ID,Description,Inventory QTY,COUNT 1,COUNT 2,COUNT 3,COUNT 4,COUNT 5".PHP_EOL;
		foreach($results->result() as $rs){
	
		echo $rs->zone.",".$rs->sub_zone_group.",".$rs->sub_zone.",".$rs->location.",".$rs->product_id.",".$rs->description.",".$rs->inventory_quantity.",".$rs->count_1.",".$rs->count_2.",".$rs->count_3.",".$rs->count_4.",".$rs->count_5.PHP_EOL;
		
		}
	}
	
	
	public function confirm_all(){
		$data_table  =  $this->input->get_post('tabledata');
	
		
		
		
		$retun_data =array();
		$val =array();
		
		for($x=0;sizeof($data_table)>$x;$x++){
			
			$data =array();
			
			$data = explode('?',$data_table[$x]['confirm_all']);
			$con_val = $data_table[$x]['con_value'];
			
			
			array_push($val, $this->mlocation_manager->result_confirmed($data[2],$data[0],$count_id="",$data[3],$data[1],$con_val));	
			
	
		}
		
	}
	
	public function design_test(){
		
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		$date = $this->input->get_post('ds');
		$date= ($date == "" ? date('Y-m-d') : $date);
		$data['ds'] = $date;
		$data['ref_list'] = $this->mlocation_manager->count_ref_list($date);
		
		$this->load->view('inventory/count_ref_list',$data);
		$this->load->view('html_footer');
	
	}
	
	
}
