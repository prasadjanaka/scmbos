<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('it/Mit_inventory');
		$this->load->model('user/mlogin');
	}	
	
	
	public function add_device_details(){
		$data['device_category']=$this->input->get_post('category');
		$data['device_name']=$this->input->get_post('name');
		$data['model']=$this->input->get_post('model');
		$data['serial_number']=$this->input->get_post('serial');
		$data['purchase_date']=$this->input->get_post('purchace');
		$data['location']=$this->input->get_post('location');
		$data['current_user']=$this->input->get_post('user');
		$data['user_name']=$this->input->get_post('user_name');
		$data['password']=$this->input->get_post('password');
		$data['vender']=$this->input->get_post('vender');
		$data['status']=$this->input->get_post('status');
		$data['other']=$this->input->get_post('other');
	
	if($this->mlogin->get_permission(ADD_IT_INVENTORY)){
			 $return=$this->Mit_inventory->add_device($data);
			 echo $return;
		}else{
			$this->load->view('html_header');
			$this->load->view('main_header_menu');
			$this->load->view('main_left_menu');
			$this->load->view('no_permission');
			$this->load->view('html_footer');
		}
	
		
		
		
	}
	public function edit_device_details(){
	
	$edit_id=$this->input->get_post('id');	
	$edit_detail=$this->Mit_inventory->edit_details($edit_id);
	foreach($edit_detail as $edit_details){
	$name=$edit_details->device_name;
	$model=$edit_details->model;
	$serial=$edit_details->serial_number;
	$date=$edit_details->purchase_date;
	$user=$edit_details->current_user;
	$u_name=$edit_details->user_name;
	$password=$edit_details->password;
	$vender=$edit_details->vender;
	$other=$edit_details->other;
	$id=$edit_details->device_details_id;
	$location=$edit_details->location;
	$category=$edit_details->device_category;
	$status=$edit_details->status;
	echo "//".$name."//".$model."//".$serial."//".$date."//".$user."//".$u_name."//".$password."//".$vender."//".$other.
	"//".$id."//".$location."//".$category."//".$status;
	}
	}
	public function edit_details(){
	   $details['device_category']=$this->input->get_post('edit_category');
	   $details['device_name']=$this->input->get_post('edit_name');
	   $details['model']=$this->input->get_post('edit_model');
	   $details['serial_number']=$this->input->get_post('edit_serial');
	   $details['purchase_date']=$this->input->get_post('edit_date');
	   $details['current_user']=$this->input->get_post('edit_user');
	   $details['user_name']=$this->input->get_post('edit_user_name');
	   $details['password']=$this->input->get_post('edit_password');
	   $details['vender']=$this->input->get_post('edit_vender');
	   $details['status']=$this->input->get_post('edit_status');
	   $details['other']=$this->input->get_post('edit_other');
	   $details['location']=$this->input->get_post('edit_department');
	   $details['status']=$this->input->get_post('edit_status');
	   $device_details_id=$this->input->get_post('edit_id');
	  
	
		if($this->mlogin->get_permission(EDIT_IT_INVENTORY)){
			  $details=$this->Mit_inventory->edit($details,$device_details_id);
			  echo $details;
		}else{
			$this->load->view('html_header');
			$this->load->view('main_header_menu');
			$this->load->view('main_left_menu');
			$this->load->view('no_permission');
			$this->load->view('html_footer');
		}
	
	
		
	}
	public function download_Excel(){
		if($this->mlogin->get_permission(IT_ENVENTORY_EXPORT_TO_EXCEL)){
			$result=$this->Mit_inventory->data_excel(); 
			$filename="IT-Device-List.csv";	
			echo "Device_Category,Device_name,Model,Serial_Number,Purchase_Date,Location,Current_User,User_Name,Password,Vender,Status,Other".PHP_EOL;	
				foreach($result as $results){
					 echo $results->device_category.",".$results->device_name.",".$results->model.",".$results->serial_number.",".$results->purchase_date.","
					.$results->location.",".$results->current_user.",".$results->user_name.",".$results->password.",".$results->vender.",".$results->status.",".$results->other.PHP_EOL;
				}	
			header('Content-type: text/csv');
			header('Content-disposition: attachment;filename='.$filename);
		}else{
			$this->load->view('html_header');
			$this->load->view('main_header_menu');
			$this->load->view('main_left_menu');
			$this->load->view('no_permission');
			$this->load->view('html_footer');
		}
		
		
		
	}
	public function list_birthday(){
		    $this->load->view('html_header');
			$this->load->view('main_header_menu');
			$this->load->view('main_left_menu');
			$this->load->view('it/birthday');
			$this->load->view('html_footer');
		
	}
	public function birthday_reminder(){
		$date_birth=date("Y-m-d");
		$return=$this->Mit_inventory->list_birthday($date_birth);
		
		
		
		 $email="a.darshanajayarathna@gmail.com";
		
		 $ci = get_instance();
		 $ci->load->library('email');
		 $config['protocol'] = "smtp";
		 $config['smtp_host'] = "ssl://smtp.gmail.com";
		 $config['smtp_port'] = "465";
		 $config['smtp_user'] = "janakadunusingha9@gmail.com"; 
		 $config['smtp_pass'] = "kalpitha123456";
		 $config['charset'] = "utf-8";
		 $config['mailtype'] = "html";
		 $config['newline'] = "\r\n";
		 
		 $ci->email->initialize($config);
		 
		 $ci->email->from('janakadunusingha9@gmail.com', 'Global Star Logistic');
		 $list = array($email);
		 $ci->email->to($list);
	
		 $ci->email->subject('Birthday Reminder');
		 $name ="";
		 $epf="";
		 foreach($return->result() as $user){
			 $name= $name.$user->epf_number."-".$user->name.'<br>';
			 //$epf= $epf.'/'.$user->epf_number;
	 		
			
	 
	 
		}
		//$epf_number=$epf;
		 $name;
		$ci->email->message("<table><tr><td>Today's Birthdays</td></tr></table>".$name);
	   
	     $ci->email->send();
		
	}
	
}
	?>