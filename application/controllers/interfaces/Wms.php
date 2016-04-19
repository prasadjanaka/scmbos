<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wms extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('interfaces/mwms');
		$this->load->model('Mbarcode');
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.gsllanka.lk',
			'smtp_port' => 587,
			'smtp_user' => 'thusitha.bodaragama@gsllanka.lk',
			'smtp_pass' => '*#oiZmT4',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
		);
		$this->load->library('email', $config);			
	}	
	
	public function index()
	{

	}


	public function print_wms_inventory_barcodes_for_new_arrivals(){
		
		$datetime = $this->input->get_post('datetime');
		$datetime = ($datetime==''?date("Y-m-d h:I:s"):$datetime);
		
		$this->mwms->generate_wms_inventory_barcodes_for_new_arrivals($datetime);


		// identify the batch to print
			$batch_count = 1;
			$this->db->select("new_arrival_pallet_code_printer_count");
			$this->db->from("wms_parameters");
			$result_batch_count = $this->db->get();		
			if($result_batch_count->num_rows()>0){
				$batch_count = $result_batch_count->row()->new_arrival_pallet_code_printer_count;
			}
		//


		$data['pallet_code'] = $this->Mbarcode->get_pallet_number($batch_count,"wms_parameters");
		$data['the_content'] = "";
		
		$html =  $this->load->view('inv_barcode', $data, true);

		$pdfFilePath = "application/downloads/new_arrivals_as_at_".date('Y_m_d_h_i_A').".pdf";

		$this->load->library('m_pdf');

		$pdf = $this->m_pdf->load();
		$mpdf = new mPDF('utf-8', array(150, 100));
		$mpdf->SetMargins("", "", 8);
		$pdf = $mpdf;
		$pdf->WriteHTML($html);

		$pdf->Output($pdfFilePath, "F");

		$subject = 'New Arrivals as at '.date('Y-m-d-h-i-A');
		$filename = $pdfFilePath;
		
		$this->email->from('thusitha.bodaragama@gsllanka.lk', 'Thusitha Bodaragama');
		$this->email->to('bodaragama@gmail.com');
//		$this->email->to('pradeep.gamage@gsllanka.lk');
//		$cc = array('jeewana.prasad@gsllanka.lk','ruchira.abeygunawardena@gsllanka.lk','aranthi.fernando@gsllanka.lk','thilan.pigera@gsllanka.lk');
//		$this->email->cc($cc);
		
		$this->email->attach($filename);
		$this->email->subject($subject);
		$this->email->message($subject);
		$this->email->send();
//		echo $this->email->print_debugger();			



		unlink($pdfFilePath);
	}





	public function print_wms_inventory_barcodes(){
		
		$sub_zone_group_id = $this->input->get_post('sub_zone_group_id');

		$this->mwms->generate_wms_inventory_barcodes($sub_zone_group_id);

        if ($this->mlogin->get_permission(SYS_INVENTORY_PRINT_BARCODE_VIEW)) {
            $data['pallet_code'] =  $this->Mbarcode->get_pallet_number($sub_zone_group_id,"sub_zone_group");
            $data['the_content'] = "";

            $html = $this->load->view('inv_barcode', $data, true);

            $pdfFilePath = "$sub_zone_group_id.pdf";

            $this->load->library('m_pdf');

            $pdf = $this->m_pdf->load();
            $mpdf = new mPDF('utf-8', array(150, 100));
            $mpdf->SetMargins("", "", 8);
            $pdf = $mpdf;
            $pdf->WriteHTML($html);

            $pdf->Output($pdfFilePath, "I");
        } else {
            echo 'Sorry you are not authorized to print barcodes';
        }




	}


	public function import_inventory_from_wms(){
		if($this->mlogin->get_permission(EXT_SYS_IMPORT_INVENTORY_FROM_WMS)){
			$this->mwms->import_inventory_from_wms();
			redirect (base_url().'index.php/inventory/dashboard/current_inventory');
		}else{
			echo('Sorry you are not authorized');	
		}
		
	}

	public function import_pid_inventory_from_wms(){
		if($this->mlogin->get_permission(EXT_SYS_IMPORT_INVENTORY_FROM_WMS)){
			$product_id = $this->input->get_post('product_id');
			if($product_id!="") $this->mwms->import_inventory_from_wms($product_id);
		}else{
			echo('Sorry you are not authorized');	
		}
	}	

}
