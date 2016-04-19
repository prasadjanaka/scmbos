<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lp extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('lp/mlp');
		$this->load->model('user/mlogin');
		$this->load->model('inventory/minventory');
		$this->load->model('interfaces/mwms');
		$this->load->model('interfaces/msap');
		$this->load->library('excel');
		$this->load->model('transport/mtransport');	
	}	
	
	public function index()
	{

		$this->load->model('transport/mtransport');	
		$this->mtransport->send_container_request_to_forwarder("thusitha.bodaragama@gsllanka.lk","","your report","Please find attached doc","info@lankaedirectory.com","Thusitha Bodaragama");


	}

	public function lp_detail(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		$lp_number = $this->input->get_post('lp_number');		

		if($this->mlogin->get_permission(LP_LIST)){
			$data_history['ref_type'] = 'lp';
			$data_history['ref'] = $lp_number;
			$data['history'] = $this->mlogin->read_history($data_history);		
			
			$data['lp_number'] = $lp_number;
			$data['lp'] = $this->mlp->get_lp_detail($lp_number);
			$data['lp_lines'] = $this->mlp->get_lp_detail_line($lp_number);
			foreach($data['lp_lines']->result() as $row){
				$row->lp_qty = $this->mwms->get_lp_qty($row->lp_number,$row->product_id);	
			}
			$data['to_be_loaded'] = $this->mwms->get_unloaded_lp_lines($lp_number);
			$data['loadings'] = $this->mlp->get_loading_history($lp_number);
			$this->load->view('lp/lp_detail',$data);
		}else{
			$this->load->view('no_permission');	
		}
		
		$this->load->view('html_footer');		
	}

	public function lp_list_detail(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		$lp_number = $this->input->get_post('lp_number');		

		if($this->mlogin->get_permission(LP_LIST)){
			$data_history['ref_type'] = 'lp';
			$data_history['ref'] = $lp_number;
			$data['history'] = $this->mlogin->read_history($data_history);		
			
			$data['lp_number'] = $lp_number;
			$data['lp'] = $this->mlp->get_lp_detail($lp_number);
			$data['lp_lines'] = $this->mlp->get_lp_detail_line($lp_number);
			foreach($data['lp_lines']->result() as $row){
				$row->lp_qty = $this->mwms->get_lp_qty($row->lp_number,$row->product_id);	
			}
			$data['to_be_loaded'] = $this->mwms->get_unloaded_lp_lines($lp_number);
			$data['loadings'] = $this->mlp->get_loading_history($lp_number);
			$this->load->view('lp/lp_list_detail',$data);
		}else{
			$this->load->view('no_permission');	
		}
		
		$this->load->view('html_footer');		
	}



	public function lp_load_detail(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		$lp_number = $this->input->get_post('lp_number');		

		if($this->mlogin->get_permission(LP_LIST)){
			$data_history['ref_type'] = 'lp';
			$data_history['ref'] = $lp_number;
			$data['history'] = $this->mlogin->read_history($data_history);		
			
			$data['lp_number'] = $lp_number;
			$data['lp'] = $this->mlp->get_lp_detail($lp_number);
			$data['lp_lines'] = $this->mlp->get_lp_detail_line($lp_number);
			$data['lp_excess'] = $this->mlp->get_lp_detail_excess($lp_number);
			$data['lp_viwe'] = $this->mlp->lp_viwe($lp_number);	
			
			$data['loadings'] = $this->mlp->get_loading_history($lp_number);
			$this->load->view('lp/lp_load_detail',$data);
		}else{
			$this->load->view('no_permission');	
		}
		
		$this->load->view('html_footer');		
	}
	
	public function lp_list_t(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		if($this->mlogin->get_permission(LP_LIST)){
			$data['bay_list'] = $this->mlp->get_bay_list();
			$data['scanners'] = $this->minventory->get_scanning_clearks();
			$data['supervisors'] = $this->minventory->get_supervisor();
			$data['tallys'] = $this->minventory->get_tally_clearks();
			$data['manpowers'] = $this->mlp->get_manpower_list();			
			$data['lps'] = $this->mlp->get_new_lps();
			$data['bay_list'] = $this->mlp->get_bay_list();
			$this->load->view('lp/lp_list_t',$data);
		}else{
			$this->load->view('no_permission');	
		}
		
		$this->load->view('html_footer');
	}
	
	public function lp_list(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		if($this->mlogin->get_permission(LP_LIST)){
			$data['bay_list'] = $this->mlp->get_bay_list();
			$data['scanners'] = $this->minventory->get_scanning_clearks();
			$data['supervisors'] = $this->minventory->get_supervisor();
			$data['tallys'] = $this->minventory->get_tally_clearks();
			$data['manpowers'] = $this->mlp->get_manpower_list();			
			$data['lps'] = $this->mlp->get_new_lps();
			$data['bay_list'] = $this->mlp->get_bay_list();
			$this->load->view('lp/lp_list',$data);
		}else{
			$this->load->view('no_permission');	
		}
		
		$this->load->view('html_footer');
	}
	public function lp_loading(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		if($this->mlogin->get_permission(LP_LIST)){
			$data['bay_list'] = $this->mlp->get_bay_list();
			$data['scanners'] = $this->minventory->get_scanning_clearks();
			$data['supervisors'] = $this->minventory->get_supervisor();
			$data['tallys'] = $this->minventory->get_tally_clearks();
			$data['manpowers'] = $this->mlp->get_manpower_list();			
			$data['lps'] = $this->mlp->get_lp_list_for_loading_activities();
			$this->load->view('lp/lp_loading',$data);
		}else{
			$this->load->view('no_permission');	
		}
		
		$this->load->view('html_footer');		
	}
	
	public function lp_schedule(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		if($this->mlogin->get_permission(LP_LIST)){
			$data['supervisors'] = $this->minventory->get_supervisor();
			$data['lps'] = $this->mlp->get_scheduled_lps();
			$this->load->view('lp/lp_schedule_loading',$data);
		}else{
			$this->load->view('no_permission');	
		}
		
		$this->load->view('html_footer');		
	}
	
	public function update_lp(){
		$lp_number = $this->input->get_post('lp_number');
		$field = $this->input->get_post('field');
		$value = $this->input->get_post('value');
		$text = $this->input->get_post('text');
		$message = "";
		
		if($lp_number!='' and $field!=''){
			$data['lp_number'] = $lp_number;
			$data['field'] = $field;
			$data['value'] = $value ;
			$permission = false;
			switch ($field){
				case "bay_id":
					$permission = $this->mlogin->get_permission(LP_SET_BAY);
					$status_id = LP_BAY_ASSIGNED;
				break;
				case "user_id_load":
					$permission = $this->mlogin->get_permission(LP_SET_SCANNER);
					$status_id = LP_SCANNER_ASSIGNED;
				break;
				case "supervisor_id":
					$permission = $this->mlogin->get_permission(LP_SET_SUPERVISOR);
					$status_id = LP_SUPERVISOR_ASSIGNED;
				break;
				case "tally_id":
					$permission = $this->mlogin->get_permission(LP_SET_TALLY);
					$status_id = LP_TALLY_ASSIGNED;
				break;
				case "manpower_team_id":
					$permission = $this->mlogin->get_permission(LP_SET_MANPOWER);
					$status_id = LP_MANPOWER_TEAM_ASSIGNED;
				break;
				case "reciept_number":
					$permission = $this->mlogin->get_permission(LP_SET_RECEITPT_NUMBER);
					$status_id = LP_RECEIPT_ASSIGNED;
				break;
			}
			
			if($permission){
				$this->mlp->update_lp($data);
				$history = array('status_id' => $status_id,'ref_type' => 'lp','ref' => $lp_number,
								 'field' => $field,'field_id' => $value,'text' => $text);
				$this->mlogin->write_history($history);
			}else{
				$message = 'Sorry, you are not authorized';
			}
				
		}else{
			$message = 'eroor';	
		}
		
		echo '{"field":"'.$field.'","value":"'.$value.'","lp_number":"'.$lp_number.'","message":"'.$message.'" }';		
	}
	
	public function add_lp(){
		if($this->mlogin->get_permission(LP_ADD)){
			$message = '';
			$data['lp_number'] = $this->input->get_post('lp_number');	
			$ret_val = $this->mlp->add_lp($data);	
			$this->mwms->get_lp_info($data['lp_number']);
			if ($ret_val){
				echo '{"lp_number":"'.$data['lp_number'].'","message":"" }';	
				$history = array('status_id' => LP_NEW,'ref_type' => 'lp','ref' => $data['lp_number'],
								 'field' => 'lp_number','field_id' => $data['lp_number'],'text' => $data['lp_number']);
				$this->mlogin->write_history($history);				
			}else{
				echo '{"lp_number":"'.$data['lp_number'].'","message":"Error" }';		
			}
		}else{
			echo '{"lp_number":"","message":"Sorry, you are not authorized to add LPs" }';		
		}
	}

	public function park_out_bay(){
		if($this->mlogin->get_permission(LP_CHANGE_LOADING_STATUS)){
			$message = '';
			$lp_number = $this->input->get_post('lp_number');	
			$this->mlp->park_out_bay($lp_number);	
			echo '{"lp_number":"'.$lp_number.'","message":""}';		
		}else{
			echo '{"lp_number":"","message":"Sorry, you are not authorized" }';		
		}
	}


	public function re_open_container(){
		if($this->mlogin->get_permission(LP_CHANGE_LOADING_STATUS)){
			$message = '';
			$lp_number = $this->input->get_post('lp_number');	
			$this->mlp->re_open_container($lp_number);	
			echo '{"lp_number":"'.$lp_number.'","message":""}';		
		}else{
			echo '{"lp_number":"","message":"Sorry, you are not authorized" }';		
		}
	}


	public function release_container(){
		if($this->mlogin->get_permission(LP_CHANGE_LOADING_STATUS)){
			$message = '';
			$lp_number = $this->input->get_post('lp_number');	
			$this->mlp->release_container($lp_number);	
			echo '{"lp_number":"'.$lp_number.'","message":""}';		
		}else{
			echo '{"lp_number":"","message":"Sorry, you are not authorized" }';		
		}
	}

	public function close_container(){
		if($this->mlogin->get_permission(LP_CHANGE_LOADING_STATUS)){
			$message = '';
			$lp_number = $this->input->get_post('lp_number');	
			$this->mlp->close_container($lp_number);	
			echo '{"lp_number":"'.$lp_number.'","message":""}';		
		}else{
			echo '{"lp_number":"","message":"Sorry, you are not authorized" }';		
		}
	}
	public function stop_loading(){
		if($this->mlogin->get_permission(LP_CHANGE_LOADING_STATUS)){
			$message = '';
			$lp_number = $this->input->get_post('lp_number');	
			$this->mlp->stop_loading($lp_number);	
			echo '{"lp_number":"'.$lp_number.'","message":""}';		
		}else{
			echo '{"lp_number":"","message":"Sorry, you are not authorized" }';		
		}
	}	

	
	public function release_to_load(){
		if($this->mlogin->get_permission(LP_CHANGE_LOADING_STATUS)){
			
			$message = '';
			$lp_number = $this->input->get_post('lp_number');	
			$ret_val = $this->mlp->release_to_load($lp_number);	

			echo '{"lp_number":"'.$lp_number.'","message":""}';		
		}else{
			echo '{"lp_number":"","message":"Sorry, you are not authorized" }';		
		}
	}	
	
	
	
	
	public function test(){
		
		$result = $this->db->query("SELECT 0 as mynum, lp_load.* FROM lp_load");
		foreach($result->result() as $x){
			$x->mynum = rand(100,2000);
			echo $x->mynum." , ";	
		}
	}
	
	public function lp_upload (){
	 if (file_exists($_FILES["new_lp"]['tmp_name'])) {
			$file = $_FILES["new_lp"]['tmp_name'];
			  $objPHPExcel = PHPExcel_IOFactory::load($file);
			  $value = $objPHPExcel->getActiveSheet()->getCell("A1")->getValue();
			  $value1 = $objPHPExcel->getActiveSheet()->getCell("R1")->getValue();
			  $loop = 2;
			  $end = 0;
			  $lp_number ="";
			  $lp_numbers = array();
               if ($value == "LP No." && $value1=="Operations Text" ) {
					while ($loop != "exit") {
						$lp_number = $objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue();
						array_push($lp_numbers,$lp_number);
						
                        $loop++;
                        if ($objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue() == "") {
							$loop = "exit";					
							$end = $loop - 1;
						}
					}
					$lp_numbers = array_unique($lp_numbers);
					$this->msap->import_lp_numbers_from_excel_dump($lp_numbers);
					$this->msap->import_lp_detail_from_excel_dump($objPHPExcel,2);
					echo 'LPs Uploaded';
				}else{	
					echo 'Invalid file';
				}
				
	 }else{
	 	echo 'File uploaded Unsuccessful';
	 }
	
	
	}
	
	public function lp_scheduled_update(){

		$lp_number = $this->input->get_post('lp_number');
		$field = $this->input->get_post('field');
		$value = $this->input->get_post('value');
		$text = $this->input->get_post('text');	
	
	if($lp_number!='' and $field!=''){
			
			$data['lp_number'] = $lp_number;
			$data['field'] = $field;
			$data['value'] = $value ;
			$status_id='';
			$permission = false;
			
					$permission = $this->mlogin->get_permission(LP_SET_SCHEDULE);
					$status_id = LP_SCHEDULED;
	
			$data['status_id']=$status_id;
			if($permission){
				$this->mlp->lp_scheduled_update($data);
				$history = array('status_id' => $status_id,'ref_type' => 'lp','ref' => $lp_number,
								 'field' => $field,'field_id' => $value,'text' => $text);
				$this->mlogin->write_history($history);
			}else{
				$message = 'Sorry, you are not authorized';
				echo $message;
			}
		}
	
	}
	
	public function lp_detail_view(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		$lp_number= $this->input->get_post('lp_number');	
		
		$data['lp_viwe'] = $this->mlp->lp_viwe($lp_number);	
		$data['lp_details_viwe'] = $this->mlp->lp_details_viwe($lp_number);	
		$data['lp_history'] = $this->mlp->get_lp_history($lp_number);
			
		
		$this->load->view('lp/lp_detail',$data);
		$this->load->view('html_footer');

	}
	
	public function pick_and_loading_update(){
		$lp_number = $this->input->get_post('lp_number');
		$field = $this->input->get_post('field');
		$value = $this->input->get_post('value');
		$text = $this->input->get_post('text');	
		
		if($lp_number!='' and $field!=''){
			
			$data['lp_number'] = $lp_number;
			$data['field'] = $field;
			$data['value'] = $value ;
			$status_id='';
			$permission = false;
			
			switch ($field){
				case "bay_id":
					$permission = $this->mlogin->get_permission(LP_SET_BAY);
					$status_id = LP_BAY_ASSIGNED;
				break;
				case "pick_start":
					$permission = $this->mlogin->get_permission(LP_SET_PICK_START_AND_END_DATETIME);
					$status_id = LP_PICK_START_DATE_ASSIGNED;
				break;
				case "pick_end":
					$permission = $this->mlogin->get_permission(LP_SET_PICK_START_AND_END_DATETIME);
					$status_id = LP_PICK_END_DATE_ASSIGNED;
				break;
				case "loading_start":
					$permission = $this->mlogin->get_permission(LP_SET_LOADING_START_AND_END_DATETIME);
					$status_id = LP_LOADING_START_DATE_ASSIGNED;
				break;
				case "loading_end":
					$permission = $this->mlogin->get_permission(LP_SET_LOADING_START_AND_END_DATETIME);
					$status_id = LP_LOADING_END_DATE_ASSIGNED;
				break;
				
			}
		
			if($permission){
				if($field=="bay_id"){
					$this->mlp->pick_and_loading_bay_update($data);
					$history = array('status_id' => $status_id,'ref_type' => 'lp','ref' => $lp_number,
								 'field' => $field,'field_id' => $value,'text' => $text);
					$this->mlogin->write_history($history);
				}else{
					$this->mlp->pick_and_loading_update($data);
					$history = array('status_id' => $status_id,'ref_type' => 'lp','ref' => $lp_number,
									 'field' => $field,'field_id' => $value,'text' => $text);
					$this->mlogin->write_history($history);
				}
			}else{
				$message = 'Sorry, you are not authorized';
				echo $message;
			}
		}
	}
	
	public function lp_request_container_info(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		$lp_number= $this->input->get_post('lp_number');	
		$data['lp_number']=$lp_number;
		$data['lp_details'] = $this->mlp->lp_details_list($lp_number);	
		$data['forwarded'] = $this->mlp->forwarded_list();	
		$data['container_size'] = $this->mlp->container_size();	
	
		$this->load->view('lp/request_container',$data);
		$this->load->view('html_footer');
	
	}
	
	public function request_container(){
	
		$data['ref']= $this->input->get_post('lp_number');
		$data['container_size_id']= $this->input->get_post('container_id');
		$data['forward_id']= $this->input->get_post('forward_id');
		$data['forward_name']= $this->input->get_post('forward_name');
		$data['expected_datetime']= $this->input->get_post('ex_datetime');
		$data['message']= $this->input->get_post('msg');
		echo $this->mlp->request_container($data);		
		
	}
	
	public function pick_loading_lps(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
			if($this->mlogin->get_permission(LP_PICK_AND_LOADING_LIST)){
				
				$data['schedule_lp_list']=$this->mlp->get_scheduled_lps();
				$data['bay_list'] = $this->mlp->get_bay_list();
				$this->load->view('lp/pick_and_loading',$data);	
				
			}else{
				
				$this->load->view('no_permission');	
			}
		$this->load->view('html_footer');
	}
	
	
	public function lp_hundred_precent(){
		$lp_number= $this->input->get_post('lp_number');
		$hp_datetime= $this->input->get_post('hp_datetime');
		$condition= $this->input->get_post('condition');
	
			if($condition=='true'){
			
				$data = array(
				   'hundred_percent_available' => 1,
				   'hundred_percent_available_datetime' => $hp_datetime
            	);
				
				$this->mlp->lp_hundred_precent($lp_number,$data);
				$status_id = LP_HUNDRED_PERCENT_MARKED;
				$history = array('status_id' => $status_id,'ref_type' => 'lp','ref' => $lp_number,
									 'field' => 'lp_number','field_id' => $lp_number,'text' => 'Hundred Percent Marked');
				$this->mlogin->write_history($history);
			}else{
			
				$data = array(
				   'hundred_percent_available' => 0,
				   'hundred_percent_available_datetime' => ''
            	);
				$this->mlp->lp_hundred_precent($lp_number,$data);
				$status_id = LP_HUNDRED_PERCENT_MARKED_REMOVED;
				$history = array('status_id' => $status_id,'ref_type' => 'lp','ref' => $lp_number,
									 'field' => 'lp_number','field_id' => $lp_number,'text' => 'Remove Hundred Percent Marked');
				$this->mlogin->write_history($history);
			}

	}
	
	public function lp_details_export_to_excel(){
	
		$lp_number=$this->input->get_post('lp_number');
		
		$data['lp_viwe'] = $this->mlp->lp_viwe($lp_number);	
		$data['lp_details_viwe'] = $this->mlp->lp_details_viwe($lp_number);	
		$data['lp_history'] = $this->mlp->get_lp_history($lp_number);
		$path=$this->create_barcode($lp_number);
		$html = $this->load->view('lp/lp_details_html.html', $data,true);
		$pdfFilePath = "LP-Details.pdf";
		$this->load->library('m_pdf');
		$pdf = $this->m_pdf->load();
		$mpdf = new mPDF('utf-8');		
		$mpdf->SetFont("times new roman");	
	    $mpdf->SetHeader("<table align='center'  width='1200' border='0'>
            <tr>
                <td width='200' height='47'> <img src='web/logo.png' width='200' height='85'></td>
                <td style='padding-left:100px' align='left' width='700'><div style='font-size:55px;font-weight:bold;'>Loading Proposal</div></td> 
				<td ><img src='".$path."' style='width:400px;height:60px'></td>	 
				
            </tr>  
        	</table>");

	    date_default_timezone_set("Asia/Colombo");
		$mpdf->setFooter("Global Star Logistics (PVT) Ltd <br>No:719/17,
        Liyanagemulla,
        Seeduwa,
        <br>Sri Lanka.|Page {PAGENO} of {nb}| Date: {DATE j-m-Y } Time: {DATE h:i:sa} <br/>Printed by : ".$this->session->userdata('username')."  <br>");
		$mpdf->SetMargins("", "", 28);
		$pdf = $mpdf;
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, "I");
		
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
	
	public function released_lp_list(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
			if($this->mlogin->get_permission(RELEASED_LP_LIST)){
				
				$data['released_lp_list']=$this->mlp->get_released_lp_list();
				$this->load->view('lp/lp_released_list',$data);	
				
			}else{
				
				$this->load->view('no_permission');	
			}
		$this->load->view('html_footer');
		
	}
	
}
