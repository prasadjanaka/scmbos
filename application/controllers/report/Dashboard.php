<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('report/mreport');
		$this->load->model('user/mlogin');
	}	
	
	public function product_vs_lp(){
	if ($this->mlogin->get_permission(SYS_INVENTORY_PRODUCT_VS_LIST)) {
		
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		$data['pro_vs_lp']=$this->mreport->product_vs_lp();
		
		$this->load->view('report/product_vs_lp',$data);
	} else {
			$this->load->view('no_permission'); 		
	}
		$this->load->view('html_footer');
		
	}
	
	public function download_Excel(){
		$avalibale_qty=0;
		$booked_qty=0;
		$lp_qty=0;
		$diff=0;
		$filename="Product-VS-Lp.csv";
		
		$result=$this->mreport->product_vs_lp();
		 
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
	   
	    echo "PRODUCT ID,DESCRIPTION ,AVAILABLE QTY,LP QTY,DEFERENCE".PHP_EOL;
	    foreach($result->result() as $pro_vs_lps){
		$difference=$pro_vs_lps->quantity-$pro_vs_lps->lp_quantity;
		echo $pro_vs_lps->product_id.",".$pro_vs_lps->description.",".$pro_vs_lps->quantity.",".$pro_vs_lps->lp_quantity.",".$difference.PHP_EOL;
	
		}	
   		
		
		
	}

	public function view_calendar(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		$user_id=$this->session->userdata("user_id");
		$result['event']=$this->mreport->list_events($user_id);
		$result['event_schedule']=$this->mreport->list_schedule_events($user_id);	
		$this->load->view('report/calendar',$result);	
		$this->load->view('html_footer');
		
	}
	public function add_event(){
		$data['event_name']=$this->input->get_post('new_event_name');
		//$data['event_date']=date("Y/m/d");
		$data['color']=$this->input->get_post('event_color');
		$data['user_id']=$this->session->userdata("user_id");
		$return=$this->mreport->add_events($data);
		echo $return;
	}
	public function add_new_schedule(){
		$date['schedule_date']=$this->input->get_post('schedule_date');
		$date['calendar_event_id']=$this->input->get_post('schedule_event_id');
		$return=$this->mreport->add_calendar_event_schedule($date);
		echo $return;
		
	}
	public function remove_event_schedule(){
		$id=$this->input->get_post('id');
		$return=$this->mreport->remove_event_schedule($id);
		echo $return;
	}
	public function update_schedule(){
		$calendar_event_schedule_id=$this->input->get_post('id');
		$data['schedule_date']=$this->input->get_post('date');
		$return=$this->mreport->update_event($calendar_event_schedule_id,$data);
		echo $return;
	}
	public function remove_event(){
		$id=$this->input->get_post('event_id');
		$return=$this->mreport->remove_event($id);
		echo $return;
	}
	
	public function pallet_tracker(){
		$from=$this->input->get_post('from');
		$to=$this->input->get_post('to');

		if($from==""&&$to==""){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		$return['movement']=$this->mreport->list_pallet_movement();
		$return['date_from'] ="";
		$return['date_to'] =date('Y-m-d');
		$this->load->view('report/pallet_tracker',$return);	
		$this->load->view('html_footer');	
			
		}else{
		
		
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		$return['movement']=$this->mreport->search_data($from,$to);
		$return['date_from'] =$from;
		$return['date_to'] =$to;
		$this->load->view('report/pallet_tracker',$return);	
		$this->load->view('html_footer');	
		
		}
		
		
	}
	public function download_Excel_movement(){
		$filename="Pallet Movement Summary.csv";
		$from=$this->input->get_post('from');
		$to=$this->input->get_post('to');
		
		if($from==""&&$to==""){
			
		
		
		$result=$this->mreport->list_pallet_movement();
		
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
	   
	    echo "Pallet Code,Product ID,Quantity,From,To,Datetime,Movement Type,EPF Number,User Name,IP Address,Host Name,Status".PHP_EOL;
	    	foreach($result as $results){
				if($results->user_id==0){
					echo $results->pallet_code.",".$results->product_id.",".$results->movement_sign.$results->quantity.",".$results->from_location.",".$results->to_location.",".
					$results->datetime.",".$results->movement_type.",".$results->epf_number.",".$results->username.",".$results->ip_address.",".$results->host_name
					.","."In Transit".PHP_EOL;	
				}else{
					echo $results->pallet_code.",".$results->product_id.",".$results->movement_sign.$results->quantity.",".$results->from_location.",".$results->to_location.",".
					$results->datetime.",".$results->movement_type.",".$results->epf_number.",".$results->username.",".$results->ip_address.",".$results->host_name
					.","."Completed".PHP_EOL;	
				}
		
	
			}
		}else{
		$result=$this->mreport->search_data($from,$to);
		
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename='.$filename);
	   
	    echo "Pallet Code,Product ID,Quantity,From,To,Datetime,Movement Type,EPF Number,User Name,IP Address,Host Name,Status".PHP_EOL;
	    	foreach($result as $results){
				if($results->user_id==0){
					echo $results->pallet_code.",".$results->product_id.",".$results->movement_sign.$results->quantity.",".$results->from_location.",".$results->to_location.",".
					$results->datetime.",".$results->movement_type.",".$results->epf_number.",".$results->username.",".$results->ip_address.",".$results->host_name
					.","."In Transit".PHP_EOL;	
				}else{
					echo $results->pallet_code.",".$results->product_id.",".$results->movement_sign.$results->quantity.",".$results->from_location.",".$results->to_location.",".
					$results->datetime.",".$results->movement_type.",".$results->epf_number.",".$results->username.",".$results->ip_address.",".$results->host_name
					.","."Completed".PHP_EOL;	
				}
		
	
			}	
		}
	}
	
	
	
	public function pallet_track_chart(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		$this->load->view('report/pallet_tracker_chart');	
		$this->load->view('html_footer');
	}
	
	public function pallet_track_chart_data_load(){
		$from=$this->input->get_post('from');
		$to=$this->input->get_post('to');
		$from = ($from == null ? date('Y-m-d') : $from);		
		$to = ($to == null ? date('Y-m-d', strtotime('+7 days')) : $to);

				$data=$this->mreport->chart_details_by_date($from,$to);
					for($i=1;sizeof($data)>$i;$i++){
						echo "_".$data[$i];
					}
				
	}
	
	public function pallet_track_chart_data_load_users(){
		$from=$this->input->get_post('from');
		$to=$this->input->get_post('to');
		$from = ($from == null ? date('Y-m-d') : $from);		
		$to = ($to == null ? date('Y-m-d', strtotime('+7 days')) : $to);
		
				$data=$this->mreport->chart_details_by_user($from,$to);
			
					for($i=1;sizeof($data)>$i;$i++){
						echo "_".$data[$i];
					}
			
	}
	
	public function line_chart(){
		$date=$this->input->get_post('date');
		$user_id=$this->input->get_post('user_id');
		
		
		$data=$this->mreport->line_chart($date,$user_id);
		
					echo $data;
		
	
	}
 public function print_chart(){
	$user_id=array();
	if($this->input->get_post('user_id')!=""){
		
		$user_id=explode("\n", $this->input->get_post('user_id'));
	
	}else{
		
		$result=$this->mreport->user_load();
		
		foreach($result->result() as $row){
			array_push($user_id,$row->epf_number);	
		}
		
		
	}
	$data_array=array();

	$bind_data="";
	for($x=0;sizeof($user_id)>$x;$x++){

		$current_date=date('Y-m-d');
		$past_date=date('Y-m-d', strtotime('-6 days'));
		$begin = new DateTime( $past_date );
		$end   = new DateTime( $current_date );
			for($i = $begin; $begin <= $end; $i->modify('+1 day')){
				$d_format=$i->format("Y-m-d");
				
				$data=$this->mreport->line_chart($d_format,$user_id[$x]);
				
				$bind_data=$bind_data."_".$data;
	
			}
			$bind_data=$bind_data."/".$user_id[$x]."?";
				
	}
		print_r($bind_data);
 }

public function print_barcode_direct(){

		$this->load->library('m_pdf');
		$pdf = $this->m_pdf->load();
		$mpdf = new mPDF('utf-8');
		
		 $mpdf->SetMargins("", "", 25);
         $pdf = $mpdf;	
		$data['pallet_code']="";
		 $html = $this->load->view('inventory/gen_barcode',$data,true);
         $pdfFilePath = "asn_number.pdf";
       
		 $pdf->WriteHTML($html);

	

$handle = printer_open();
	     if($handle)
	          echo "connected";
	     else
	          echo "not connected";   
	printer_set_option($handle, PRINTER_MODE, "raw");
	printer_write($handle,$pdfFilePath);
	printer_close($handle);

		
}
}
