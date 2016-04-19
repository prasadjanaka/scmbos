		<?php
        defined('BASEPATH') OR exit('No direct script access allowed');
        
        class dashboard extends CI_Controller {
        public function __construct()
        {
        parent::__construct();
        $this->load->model('hr/Memployee');
            
        }	
            
        public function list_employee(){
        
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');	
        
        $this->data['posts'] = $this->Memployee->get_employeer_list(); 
        $this->load->view('hr/employee_list', $this->data);
        $this->load->view('html_footer');
        }
       
        
        public function addnew_employee(){
			
        $data_load['epf']="";
		$data_load['name']="";
		$data_load['date_joined']="";
		$data_load['address']="";
		$data_load['email']="";
		$data_load['contact']="";
		$data_load['designation']="";
		$data_load['gender']="";
		$data_load['jobcategory']="";
		$data_load['photo']="";
		$data_load['section']="";
		$data_load['status']="";
		    	
		$edit_epf_number=$this->input->GET('epf_number');	
		if($edit_epf_number!=0){
			
		$number1=$this->Memployee->edit_employee($edit_epf_number);
			
		foreach($number1 as $number2){
			
			
			
 		$data_load['epf']=$number2->epf_number;
		$data_load['name']=$number2->name;
		$data_load['date_joined']=$number2->date_joined;
		$data_load['address']=$number2->address;
		$data_load['email']=$number2->email;
		$data_load['contact']=$number2->contact_number;
		$data_load['designation']=$number2->designation;
		$data_load['gender']=$number2->gender;
		$data_load['jobcategory']=$number2->job_category;
		$data_load['photo']=$number2->photo_path;
		$data_load['all_section']=$number2->section_name;
		$data_load['status']=$number2->status;
		    	
	
		
		
		}
		
		$data['genders_load']=$this->Memployee->get_gender();
        $data['section_load']=$this->Memployee->get_section();
        $data['category_load']=$this->Memployee->get_category();
        $data['designation_load']=$this->Memployee->get_designation();
			
	    $this->load->view('html_header');
      	$this->load->view('main_header_menu');
     	$this->load->view('main_left_menu');

		$this->load->view('hr/addnew_employee',array_merge($data_load,$data));
			
		$emp_details['epf_number'] = $this->input->get_post('epf_number');	
	
		}else{	
			
			
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');	
    
        $data['genders_load']=$this->Memployee->get_gender();
        $data['section_load']=$this->Memployee->get_section();
        $data['category_load']=$this->Memployee->get_category();
        $data['designation_load']=$this->Memployee->get_designation();
		
			
		
		if($this->input->get_post('epf_number')!=NULL){
		$condition=$this->Memployee->epf_exsist($this->input->get_post('epf_number'));	
		
		if($condition==1){
			
			
			
		}else{
		$image_upload=$_FILES["photo"]["tmp_name"];
				
			
					
		$image_id=$this->Memployee->upload_image($image_upload,$this->input->get_post('epf_number'));
		
					
						
				
 		 $emp_details['epf_number'] = $this->input->get_post('epf_number');
		 $emp_details['photo_id'] = $image_id;
		 $emp_details['name']=$this->input->get_post('name');
		 $emp_details['address']=$this->input->get_post('address');
		 $emp_details['date_joined']=$this->input->get_post('date_joined');
		 $emp_details['gender_id']=$this->input->get_post('gender');
		 $emp_details['email']=$this->input->get_post('email');
		 $emp_details['contact_number']=$this->input->get_post('contact');
		 $emp_details['section_id']=$this->input->get_post('section');
		 $emp_details['job_catagory_id']=$this->input->get_post('category');
		 $emp_details['designation_id']=$this->input->get_post('designation');
		 $emp_details['status_id']="1";
		
		$result= $this->Memployee->add_emp($emp_details);
		
		}	
		}
			
		
		
		$this->load->view('hr/addnew_employee',array_merge($data, $data_load));
		$this->load->view('html_footer');    
        
		}
		}
		 public function edit_employee_ajax(){
		//$edit_epf_number=$this->input->GET('epf_number');		
		 $epf=$this->input->get_post('epf_number');		
		 $emp_details['epf_number']=$this->input->get_post('epf_number');	
		 $image_path = "application/uploads/EMPLOYEE/images/" .$epf . ".jpg";
		 $emp_details['name']=$this->input->get_post('name');
		 $emp_details['address']=$this->input->get_post('address');
		 $emp_details['date_joined']=$this->input->get_post('date_joined');
		 $emp_details['email']=$this->input->get_post('email');
		 $emp_details['contact_number']=$this->input->get_post('contact');
		 $emp_details['section_id']=$this->input->get_post('section');
		 $emp_details['job_catagory_id']=$this->input->get_post('category');
		 $emp_details['designation_id']=$this->input->get_post('designation');
		 $emp_details['gender_id']=$this->input->get_post('gender');
		 $condi=$this->input->get_post('con');
		// echo $condi;
		 
		 if($condi==""){
		$result= $this->Memployee->edit_emp($epf,$emp_details);	
		echo $result;
		 }else{
		$image_upload=$_FILES["photo"]["tmp_name"];
		$this->Memployee->edit_upload_image($image_upload,$this->input->get_post('epf_number'));
		$result= $this->Memployee->edit_emp($epf,$emp_details);	
		echo $result;
		 }
			//print_r($image_upload);
		
		}
		//
		function edit_employee(){
				
		 $epf=$this->input->get_post('epf_number');
		 $image_path = "application/uploads/EMPLOYEE/images/" .$epf . ".jpg";				
		 $emp_details['epf_number'] = $this->input->get_post('epf_number');		
		 $emp_details['name']=$this->input->get_post('name');
		 $emp_details['date_joined']=$this->input->get_post('date_joined');
		 $emp_details['address']=$this->input->get_post('address');
		 $emp_details['email']=$this->input->get_post('email');
		 $emp_details['contact_number']=$this->input->get_post('contact');
		 $emp_details['designation_id']=$this->input->get_post('designation');
		 $emp_details['gender_id']=$this->input->get_post('gender');
		 $emp_details['job_catagory_id']=$this->input->get_post('category');
		 $emp_details['section_id']=$this->input->get_post('section');
		
		
	     $image_upload=$_FILES["photo"]["tmp_name"];
	  
	   		
		
		 $this->Memployee->edit_upload_image($image_upload,$this->input->get_post('epf_number'));
		 $result= $this->Memployee->edit_emp($epf,$emp_details);
		 $this->addnew_employee();
			
		 }
		 public function epf_ex(){
		 $epf=$this->input->get_post('epf');
	 	 $result= $this->Memployee->epf_ex($epf);

		 echo($result);
	
		 }
		 
		public function view_profile(){
		$this->load->library('m_pdf');
		$pdf = $this->m_pdf->load();
		$mpdf = new mPDF('utf-8');
		$epf=$this->input->get_post('epf_number');
		$data['result']=$this->Memployee->edit_employee($epf);
		$result=$this->Memployee->edit_employee($epf);
		$name="";
		foreach($result as $results){
		$name=$results->name;
		}
		
		$mpdf->SetFont("times new roman");	
		$mpdf->SetHeader("<table align='center'  width='1200' border='0'>
		<tr>
		<td style='padding-left:140px' width='200' height='47'><img src='../../../WEB/logo.png' width='200' height='85'></td>
		<td style='padding-left:80px' width='1000'><div style='font-size:55px;font-weight:bold;width:1000;'>".
		
			
				$name.
				 
				
			"</div></td>
            </tr>  
            </table>");
		 $mpdf->setFooter("Global Star Logistics (PVT) Ltd <br>No:719/17,
        Liyanagemulla,
        Seeduwa,
        <br>Sri Lanka.|Page {PAGENO} of {nb}| Date: {DATE j-m-Y } Time: {DATE h:i:sa} <br/>Printed by : ".$this->session->userdata('username')."  <br>");
		 $mpdf->SetMargins("", "", 28);
         $pdf = $mpdf;	
			 
		
			
			
		 $html = $this->load->view('hr/view_profile',$data,true);
         $pdfFilePath = "asn_number.pdf";
         $this->load->library('m_pdf');
		 $pdf->WriteHTML($html);
		 $pdf->Output($pdfFilePath, "I");
		 }

	public function test_desing(){
			
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');	
		$this->load->view('test_design');	
		
		
		$this->load->view('html_footer');    
	}



		 }
	?>