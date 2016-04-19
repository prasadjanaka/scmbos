<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.gsllanka.lk',
			'smtp_port' => 587,
			'smtp_user' => 'noreply@gsllanka.lk',
			'smtp_pass' => 'NoReply365',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
		);
		$this->load->library('email', $config);	
		$this->load->library('excel');

		$this->load->model('interfaces/mwms');

	}	

	public function email_completed_replenishments(){
		$subject = 'Completed Replenishments as at '.date('Y-m-d h').':15 '.date('A');

		$filename='application/downloads/completed_replenishments.xls';
		
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Completed Replenishments');
		
		$sql = "SELECT * from vw_replenishment WHERE rep_status='COMPLETED'  and HOUR(TIMEDIFF(datetime_replenished, now()))<=1.5";

		$query = $this->db->query($sql);
		$i = 1 ;
		$this->excel->getActiveSheet()->setCellValue('A'.$i, 'Date Time');
		$this->excel->getActiveSheet()->setCellValue('B'.$i, 'Zone');		
		$this->excel->getActiveSheet()->setCellValue('C'.$i, 'Sub Zone');		
		$this->excel->getActiveSheet()->setCellValue('D'.$i, 'Location');		
		$this->excel->getActiveSheet()->setCellValue('E'.$i, 'Product ID');	
		$this->excel->getActiveSheet()->setCellValue('F'.$i, 'Description');
		$this->excel->getActiveSheet()->setCellValue('G'.$i, 'Qty Replenished');
		$this->excel->getActiveSheet()->setCellValue('H'.$i, 'DateTime Replenished');
		$this->excel->getActiveSheet()->setCellValue('I'.$i, 'Location Replenished From');

		
		foreach($query->result() as $record){
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A'.$i, $record->datetime_created);
			$this->excel->getActiveSheet()->setCellValue('B'.$i, $record->zone);		
			$this->excel->getActiveSheet()->setCellValue('C'.$i, $record->sub_zone);		
			$this->excel->getActiveSheet()->setCellValue('D'.$i, $record->location);		
			$this->excel->getActiveSheet()->setCellValue('E'.$i, $record->product_id);	
			$this->excel->getActiveSheet()->setCellValue('F'.$i, $record->description);
			$this->excel->getActiveSheet()->setCellValue('G'.$i, $record->quantity_replenished);	
			$this->excel->getActiveSheet()->setCellValue('H'.$i, $record->datetime_replenished);	
			$this->excel->getActiveSheet()->setCellValue('I'.$i, $record->replenished_from_location);	
			
		}



		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save($filename);


		$this->email->from('thusitha.bodaragama@gsllanka.lk', 'Thusitha Bodaragama');
		$this->email->to('pradeep.gamage@gsllanka.lk');
		$cc = array('jeewana.prasad@gsllanka.lk','ruchira.abeygunawardena@gsllanka.lk','aranthi.fernando@gsllanka.lk','thilan.pigera@gsllanka.lk');
		$this->email->cc($cc);
		
		$this->email->attach($filename);
		$this->email->subject($subject);
		$this->email->message($subject);
		$this->email->send();
		//echo $this->email->print_debugger();			
	
	}
	

	
	public function email_pending_replenishments(){
		$subject = 'Pending Replenishments as at '.date('Y-m-d h:i A');

		$filename='application/downloads/pending_replenishments.xls';
		
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Pending Replenishments');
		

		$sql = "SELECT * from vw_replenishment WHERE rep_status='PENDING' AND current_inventory>0";
		$query = $this->db->query($sql);
		$i = 1 ;
		$this->excel->getActiveSheet()->setCellValue('A'.$i, 'Date Time');
		$this->excel->getActiveSheet()->setCellValue('B'.$i, 'Zone');		
		$this->excel->getActiveSheet()->setCellValue('C'.$i, 'Sub Zone');		
		$this->excel->getActiveSheet()->setCellValue('D'.$i, 'Location');		
		$this->excel->getActiveSheet()->setCellValue('E'.$i, 'Product ID');	
		$this->excel->getActiveSheet()->setCellValue('F'.$i, 'Description');
		$this->excel->getActiveSheet()->setCellValue('G'.$i, 'ROL');
		$this->excel->getActiveSheet()->setCellValue('H'.$i, 'Inv in Location');
		$this->excel->getActiveSheet()->setCellValue('I'.$i, 'Available Inv');
		$this->excel->getActiveSheet()->setCellValue('J'.$i, 'Qty to Replenish');	

		
		foreach($query->result() as $record){
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A'.$i, $record->datetime_created);
			$this->excel->getActiveSheet()->setCellValue('B'.$i, $record->zone);		
			$this->excel->getActiveSheet()->setCellValue('C'.$i, $record->sub_zone);		
			$this->excel->getActiveSheet()->setCellValue('D'.$i, $record->location);		
			$this->excel->getActiveSheet()->setCellValue('E'.$i, $record->product_id);	
			$this->excel->getActiveSheet()->setCellValue('F'.$i, $record->description);
			$this->excel->getActiveSheet()->setCellValue('G'.$i, $record->min_reorder_level);	
			$this->excel->getActiveSheet()->setCellValue('H'.$i, $record->current_inventory_in_location);	
			$this->excel->getActiveSheet()->setCellValue('I'.$i, $record->current_inventory);	
			$this->excel->getActiveSheet()->setCellValue('J'.$i, $record->quantity_required);				
		}
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save($filename);


		$this->email->from('thusitha.bodaragama@gsllanka.lk', 'Thusitha Bodaragama');
		$this->email->to('pradeep.gamage@gsllanka.lk');
		$cc = array('jeewana.prasad@gsllanka.lk','ruchira.abeygunawardena@gsllanka.lk','aranthi.fernando@gsllanka.lk','thilan.pigera@gsllanka.lk');
		$this->email->cc($cc);
		
		$this->email->attach($filename);
		$this->email->subject($subject);
		$this->email->message($subject);
		$this->email->send();
		//echo $this->email->print_debugger();			
	
	}
	
	public function today_asns(){
		$wms_db = $this->load->database("gtl",true);	
		
		$this->email->from('thusitha.bodaragama@gsllanka.lk', 'Thusitha Bodaragama');
		//$this->email->to('bodaragama@gmail.com');
		$this->email->to('sri.kamalachelvan@gsllanka.lk');
		$cc = array('thusitha.bodaragama@gsllanka.lk');
		$this->email->cc($cc);

		$date_from = date_create(date("d-M-Y"));
		$date_to   =  date_create(date("d-M-Y"));

		date_add($date_from,date_interval_create_from_date_string("-1 days"));

		$date_from = date_format($date_from,"d-M-Y")." 07:00";
		$date_to   = date_format($date_to,"d-M-Y")." 07:00";
		
		$sql = "SELECT ManufacturerCode,ManufacturerDesc,COUNT(*) AS number_of_asns from ms_po_header  where po_type='W' 
				 AND (DateLastAmended BETWEEN '$date_from' AND '$date_to') GROUP BY ManufacturerCode,ManufacturerDesc ";
		$query = $wms_db->query($sql);

		$subject = 'ASNs Came in from '.$date_from. ' AM to '.$date_to. ' AM';
		$this->email->subject($subject);

//creating excel
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('ASNs');
		$filename='application/downloads/today_asns.xls';

		$i = 1;

		$this->excel->getActiveSheet()->setCellValue('A'.$i, 'Manufacturer Code');
		$this->excel->getActiveSheet()->setCellValue('B'.$i, 'Manufacturer');		
		$this->excel->getActiveSheet()->setCellValue('C'.$i, 'ASN_Count');	

		foreach($query->result() as $record){
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A'.$i, $record->ManufacturerCode);
			$this->excel->getActiveSheet()->setCellValue('B'.$i, "'".$record->ManufacturerDesc);		
			$this->excel->getActiveSheet()->setCellValue('C'.$i, $record->number_of_asns);	
		}


		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save($filename);

	
		$this->email->attach($filename);

		$this->email->message($subject);
		
		$this->email->send();
		
		echo $this->email->print_debugger();
		
	}	
	
	public function pick_face_adherence(){
		$wms_db = $this->load->database("gtl",true);	
		
		$this->email->from('thusitha.bodaragama@gsllanka.lk', 'Thusitha Bodaragama');
		//$this->email->to('bodaragama@gmail.com');
		$this->email->to('thilan.pigera@gsllanka.lk');
		$cc = array('pradeep.gamage@gsllanka.lk','jeewana.prasad@gsllanka.lk','thusitha.bodaragama@gsllanka.lk','aranthi.fernando@gsllanka.lk','thusitha.bodaragama@gsllanka.lk');
		$this->email->cc($cc);

		$date_from = date_create(date("d-M-Y"));
		$date_to   =  date_create(date("d-M-Y"));

		date_add($date_from,date_interval_create_from_date_string("-1 days"));

		$date_from = date_format($date_from,"d-M-Y")." 07:00";
		$date_to   = date_format($date_to,"d-M-Y")." 07:00";
		
//		$date_from = date_format(date_create("01-Feb-2016"),"d-M-Y")." 00:00";
//		$date_to   = date_format(date_create("19-Feb-2016"),"d-M-Y")." 00:00";
				
		$sql = "SELECT * FROM vw_pick_history WHERE (DateScanned BETWEEN '$date_from' AND '$date_to') ORDER BY DateScanned";

		$query = $wms_db->query($sql);


		$subject = 'Pick Face Adherence from '.$date_from. ' AM to '.$date_to. ' AM';
		$this->email->subject($subject);

//creating excel
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Pick Face Adherence');
		$filename='application/downloads/pick_face_adherence.xls';

		$i = 1;

		$this->excel->getActiveSheet()->setCellValue('A'.$i, 'Product ID');
		$this->excel->getActiveSheet()->setCellValue('B'.$i, 'Location');		
		$this->excel->getActiveSheet()->setCellValue('C'.$i, 'Qty');	
		$this->excel->getActiveSheet()->setCellValue('D'.$i, 'DateTimeScanned');	
		$this->excel->getActiveSheet()->setCellValue('E'.$i, 'Location Type');	
		$this->excel->getActiveSheet()->setCellValue('F'.$i, 'Is Pick Face');	

		foreach($query->result() as $record){
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A'.$i, $record->ProductID);
			$this->excel->getActiveSheet()->setCellValue('B'.$i, "'".$record->LocationFromID);		
			$this->excel->getActiveSheet()->setCellValue('C'.$i, $record->Quantity);	
			$this->excel->getActiveSheet()->setCellValue('D'.$i,date('Y-m-d h:i A',strtotime( $record->DateScanned)));		
			$this->excel->getActiveSheet()->setCellValue('E'.$i, $record->vType);	
			$this->excel->getActiveSheet()->setCellValue('F'.$i, ($record->PF_Location==''?'No':'Yes'));	
		}


		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save($filename);

	
		$this->email->attach($filename);

		$this->email->message($subject);
		
		$this->email->send();
		
		echo $this->email->print_debugger();
		
	}
	
	public function location_moment_report()
	{
		$wms_db = $this->load->database("gtl",true);	
		
		$this->email->from('thusitha.bodaragama@gsllanka.lk', 'Thusitha Bodaragama');
		$this->email->to('thilan.pigera@gsllanka.lk');
		$cc = array('jeewana.prasad@gsllanka.lk','thusitha.bodaragama@gsllanka.lk','ruchira.abeygunawardena@gsllanka.lk','aranthi.fernando@gsllanka.lk',);
		$this->email->cc($cc);

		$date_from = date_create(date("d-M-Y"));
		$date_to   =  date_create(date("d-M-Y"));

		date_add($date_from,date_interval_create_from_date_string("-1 days"));

		$date_from = date_format($date_from,"d-M-Y")." 07:00";
		$date_to   = date_format($date_to,"d-M-Y")." 07:00";
		
		$sql = "select * from DailyMovement('".$date_from."','".$date_to."') order by time";
		$query = $wms_db->query($sql);


		$subject = 'Location Movement Report from '.$date_from. ' AM to '.$date_to. ' AM';
		$this->email->subject($subject);

//creating excel
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Location Movements');
		$filename='application/downloads/location_movements.xls';

		$i = 1;

		$this->excel->getActiveSheet()->setCellValue('A'.$i, 'Product ID');
		$this->excel->getActiveSheet()->setCellValue('B'.$i, 'Date Time');		
		$this->excel->getActiveSheet()->setCellValue('C'.$i, 'Location');		
		$this->excel->getActiveSheet()->setCellValue('D'.$i, 'User ID');		
		$this->excel->getActiveSheet()->setCellValue('E'.$i, 'Movement PO');	
		$this->excel->getActiveSheet()->setCellValue('F'.$i, 'Ref');
		$this->excel->getActiveSheet()->setCellValue('G'.$i, 'Qty');	

		foreach($query->result() as $record){
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A'.$i, $record->UPC);
			$this->excel->getActiveSheet()->setCellValue('B'.$i, $record->Time);		
			$this->excel->getActiveSheet()->setCellValue('C'.$i, $record->Location);		
			$this->excel->getActiveSheet()->setCellValue('D'.$i, $record->UserID);		
			$this->excel->getActiveSheet()->setCellValue('E'.$i, $record->MovementPO);	
			$this->excel->getActiveSheet()->setCellValue('F'.$i, $record->Ref_No);
			$this->excel->getActiveSheet()->setCellValue('G'.$i, $record->QTY);				
		}


		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save($filename);

	
		$this->email->attach($filename);

		$this->email->message($subject);
		
		$this->email->send();
		
		echo $this->email->print_debugger();

	}
	
	public function import_wms_inventory(){
		$this->mwms->import_inventory_from_wms();		
	}
	
}
