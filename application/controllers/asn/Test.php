<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/mlogin');
		$this->load->model('asn/masn');
		$this->load->model('inventory/Mcount_ref');		
		$this->load->library('excel');
	}	
	public function index(){
//		$data['reference'] = '201603110003';
//		$data['scanner_id'] = 25;
//		$this->Mcount_ref->update_reference($data);
		//$this->Mcount_ref->generate_new_reference('2016-03-10');
		$this->Mcount_ref->release('201603100004');		
		echo $this->Mcount_ref->error;	
	}
	
	public function print_asn($asn_number=""){
        $data['the_content'] = "";
        $html = 'THIS IS A TEST';
        $pdfFilePath = "$asn_number.pdf";

//load mPDF library
        $this->load->library('m_pdf',"A4");
//actually, you can pass mPDF parameter on this load() function
        $pdf = $this->m_pdf->load();
//generate the PDF! 
        //mm 
        $mpdf = new mPDF('utf-8');
        $pdf = $mpdf;

        $pdf->WriteHTML($html);

//offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $pdf->Output($pdfFilePath, "I");

		
	}

}



//2015-08-19 19:31:34
//$datetime_post = $objPHPExcel->getActiveSheet()->getCell("G$loop")->getValue();
//$datetime_post = PHPExcel_Shared_Date::ExcelToPHP($datetime_post);
//$datetime_post = " ".$objPHPExcel->getActiveSheet()->getCell("H$loop")->getValue();
//$cell = $objPHPExcel->getActiveSheet()->getCell('G' . $loop);
//$InvDate = $cell->getValue();
//if(PHPExcel_Shared_Date::isDateTime($cell)) {
//	 $InvDate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($InvDate)); 
//	 echo $InvDate."<br/>";;
//}