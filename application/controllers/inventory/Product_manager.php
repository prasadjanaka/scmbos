<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_manager extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('inventory/mproduct');
        $this->load->model('user/mlogin');
		$this->load->library('excel');
    }

    public function client_inventory(){
	   $this->load->view('html_header');
       $this->load->view('main_header_menu');
       $this->load->view('main_left_menu');
	    if ($this->mlogin->get_permission(SYS_INVENTORY_CLIENT_INVENTORY)) {
	   $data['client']=$this->mproduct->client_inventory();
	   $this->load->view('inventory/client_inventory',$data);
		}else{
		$this->load->view('no_permission'); 	
			}
       $this->load->view('html_footer');	
	}
	
	  public function general_client_inventory_upload() {
       if ($this->mlogin->get_permission(SYS_INVENTORY_UPLOAD_CLIENT_INVENTORY)) {
          
		    if (file_exists($_FILES["new_inventory"]['tmp_name'])) {
                $file = $_FILES["new_inventory"]['tmp_name'];
                   $this->db->trans_start();
				   $data_line_start = 2;
                   $objPHPExcel = PHPExcel_IOFactory::load($file);

                    $loop = $data_line_start;
                    $pre_sto_number = "";
                    while ($loop != "exit") {   
                      $data_sto['product_id'] = $objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue();
                      $data_sto['quantity'] = $objPHPExcel->getActiveSheet()->getCell("B$loop")->getValue();
         			  $this->mproduct->add_client_data($data_sto);

                       $loop++;
                       if ($objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue() == "")
                       $loop = "exit";
                   }
			
               	echo 'File uploaded';
                $this->db->trans_complete(); 
            	}else{
			    echo 'File uploaded Unsuccessful';
				}
			 
        	} else {
           	 echo 'Sorry you are not authorized to upload Client Inventory';
       		}
    }
	
	
	 public function general_c_cat_upload() {
      
       if ($this->mlogin->get_permission(SYS_INVENTORY_C_CAT)) {
          
		    if (file_exists($_FILES["c_cat"]['tmp_name'])) {
                $file = $_FILES["c_cat"]['tmp_name'];
           		$c_cat_path = "application/uploads/C-cat.XLSX";
				move_uploaded_file( $file, $c_cat_path);
				 	echo 'File uploaded';	
               		
            	}else{
			  		echo 'File uploaded Unsuccessful';
				}
			 
       		} else {
           		echo 'Sorry you are not authorized to upload C-Cat File';
      			}
    		}
			
			
	public function c_cat_find(){
	
	        $this->db->trans_start();
			$c_cat_path = "application/uploads/C-cat.XLSX";
					$data_line_start = 2;
                    $objPHPExcel = PHPExcel_IOFactory::load($c_cat_path);

                    $loop = $data_line_start;
                    $pre_sto_number = "";
                    while ($loop != "exit") {  
                      $data_sto['product_id'] = $objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue();
                      $data_sto['description'] = $objPHPExcel->getActiveSheet()->getCell("B$loop")->getValue();
					  $data_sto['client_status'] = $objPHPExcel->getActiveSheet()->getCell("C$loop")->getValue();
					  $data_sto['weight'] = $objPHPExcel->getActiveSheet()->getCell("D$loop")->getValue();
					  $data_sto['volume'] = $objPHPExcel->getActiveSheet()->getCell("E$loop")->getValue();
         			  $this->mproduct->add_c_cat_data($data_sto);

                      $loop++;
                      if ($objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue() == "")
                       $loop = "exit";
                  	 }
			$this->db->trans_complete(); 
	
	}
	
	public function list_pick_face(){
	   
	   $this->load->view('html_header');
       $this->load->view('main_header_menu');
       $this->load->view('main_left_menu');
	   
	  if ($this->mlogin->get_permission(SYS_INVENTORY_LIST_PICK_FACE)) {
	   $data['pick_list']=$this->mproduct->list_pick_face();
	   
	   $this->load->view('inventory/pick_face',$data);
	  } else {
			$this->load->view('no_permission'); 		
	  }
	   
	   $this->load->view('html_footer');		   
	   
	}
	public function update_pick_face(){
		$update_data['update_id'] = $this->input->get_post('update_id');
		$update_data['update_col'] = $this->input->get_post('update_col_name');
        $update_data['update_value'] = $this->input->get_post('update_value');
		//$update_data['status']=$this->input->get_post('sta');
		
		
		//echo $update_data['update_id']."-".$update_data['update_col']."-".$update_data['update_value'];
		$return=$this->mproduct->update_pick_data($update_data);
			echo $return;
	//	if($return == 0){
//			echo 0;
//		}else{
//			foreach($return as $returns){
//				echo $returns->location_id."/".$returns->location;
//			}
//		}
	
	}
	public function add_pick_face(){
		$add_data['client_code']=$this->input->get_post('client_code');
		$add_data['product_id']=$this->input->get_post('product_id');
		$add_data['location_id']=$this->input->get_post('lid');
		$add_data['priority']=$this->input->get_post('priority');
		$add_data['pallet_count']=$this->input->get_post('count');
		$add_data['min_reorder_level']=$this->input->get_post('level');
		
		//echo $client.$pid.$lid.$priority.$count.$level;
		$return=$this->mproduct->add_pick($add_data);
		echo $return;
	}
	public function delete_pick_face(){
		$add_data['product_id']=$this->input->get_post('product_id');
		$return=$this->mproduct->delete_pick_data($add_data['product_id']);
		echo $return;
	}
	public function status_pick_face(){
		$pid=$this->input->get_post('product_id');
		$status=$this->input->get_post('status');
		
		$return=$this->mproduct->set_status($pid,$status);
		echo $return;
	}
	public function check_pid(){
		$pid1=$this->input->get_post('pro_id');
		$return=$this->mproduct->check_product_id($pid1);
		echo $return;
	}
	public function check_location(){
		$location=$this->input->get_post('location');
		$return=$this->mproduct->check_location_name($location);
		echo $return;
	}
	
	public function add_new_product(){
			$this->load->view('html_header');
		    $this->load->view('main_header_menu');
		    $this->load->view('main_left_menu');
		 if ($this->mlogin->get_permission(SYS_INVENTORY_ADD_NEW_PRODUCT_LIST)) {
		    $this->load->view('inventory/product_add');

		} else {
			$this->load->view('no_permission'); 		
		}

	   	$this->load->view('html_footer');		   	
	}
	
	public function get_product_details(){
	
		$product_id=$this->input->get_post('product_id');
		$return=$this->mproduct->get_product_details($product_id);
		
		if($return->num_rows()>0){
		foreach($return->result() as $row ){
			echo $row->description."??".$row->weight_net."??".$row->height."??".$row->volume."??".$row->client_status."??".$row->scm_status."??".$row->client_code;	
		}
		}else{
			echo 0;
		}
	}
	
	public function add_product(){
		 if ($this->mlogin->get_permission(SYS_INVENTORY_ADD_NEW_PRODUCT)) {
			$product_id=$this->input->get_post('product_id');
			$discription=$this->input->get_post('discription');
			$net_val=$this->input->get_post('net_val');
			$height_val=$this->input->get_post('height_val');
			$volume_val=$this->input->get_post('volume_val');
		
			
			$return=$this->mproduct->add_new_product($product_id,$discription,$net_val,$height_val,$volume_val);	
			
			echo $return;
		} else {
			echo "0";	
		}
	}
	
	public function update_product(){
		
	 if ($this->mlogin->get_permission(SYS_INVENTORY_UPDATE_PRODUCT)) {
		 
		$product_id=$this->input->get_post('product_id');
		$discription=$this->input->get_post('discription');
		$net_val=$this->input->get_post('net_val');
		$height_val=$this->input->get_post('height_val');
		$volume_val=$this->input->get_post('volume_val');

		
		$return=$this->mproduct->update_product($product_id,$discription,$net_val,$height_val,$volume_val);	
		
		echo $return;
	} else {
			echo "0";	
		}
	}
	
	 public function client_inventory_to_excel(){
		$filename="Client-inventory.csv";
	   //if ($this->mlogin->get_permission(SYS_INVENTORY_CLIENT_INVENTORY)) {
	   $client = $this->mproduct->client_inventory();
	  	
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
	   
	    echo "Product ID,Description,Quantity".PHP_EOL;
	    foreach($client as $rs){
		
		echo $rs->product_id.",".$rs->description.",".$rs->quantity.PHP_EOL;
	
		}	
		//}else{
	
			//}
	}
	
	
	
}
