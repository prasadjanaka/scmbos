<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/mlogin');
        $this->load->model('asn/masn');
		$this->load->model('interfaces/mwms');
        $this->load->library('excel');
        $this->load->model('Mbarcode');
    }

    public function index() {

        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        if ($this->mlogin->get_permission(SYS_MAIN_DASHBOARD)) {
            $this->load->view('dashboard');
        } else {
            $this->load->view('no_permission');
        }
        $this->load->view('html_footer');
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
	private function make_doc($doc_name=""){
		
		
		$pdfFilePath = "$doc_name.pdf";

        $this->load->library('m_pdf');
 
        $pdf = $this->m_pdf->load();
        $mpdf = new mPDF('utf-8');		
		$mpdf->SetFont("times new roman");	
		$asn_number = $this->input->get_post('asn_number');
		$path=$this->create_barcode($asn_number);
		//$path = 'barcode_image/a.png';
        $mpdf->SetHeader("<table align='center'  width='1200' border='0'>
            <tr>
                <td width='200' height='47'><img src='../../../WEB/logo.png' width='200' height='85'></td>
                <td align='center' width='750'><div style='font-size:55px;font-weight:bold'>UNLODING SHEET</div></td> 
				<td ><img src='".$path."' style='width:400px;height:60px'></td>	 
            </tr>  
        </table>");
        
	 
	    date_default_timezone_set("Asia/Colombo");
       
	       $data_para['asn_number'] = $asn_number;
            $data["asn_barcodes_summary"] = $this->masn->get_asn_barcode_summary($asn_number);
            $data["asn_barcodes"] = $this->masn->get_asn_barcode($asn_number);
            $data["stos"] = $this->masn->get_sto_list($data_para);
            $data["sto_details"] = $this->masn->get_sto_detail($data_para);
            $data["asn"] = $this->masn->get_asn($data_para);
		
		 $this->load->view('asn/unload_sheet', $data );
	   
	   
	   
	    $mpdf->setFooter("Global Star Logistics (PVT) Ltd <br>No:719/17,
        Liyanagemulla,
        Seeduwa,
        <br>Sri Lanka.|Page {PAGENO} of {nb}| Date: {DATE j-m-Y } Time: {DATE h:i:sa} <br/>Printed by : ".$this->session->userdata('username')."  <br>");
		$mpdf->SetMargins("", "", 28);
        $pdf = $mpdf;	
		
		return $pdf;	
	}

    public function print_asn() {

        $asn_number = $this->input->get_post('asn_number');
		$pdf = $this->make_doc($asn_number);
		
		$pdfFilePath = "$doc_name.pdf";
		
        //array_merge($asn_barcodes_summary,$asn_barcodes));
	 $data1['the_content'] = "";
	 $html = $this->load->view('asn/unload_sheet', $data1, true);
	
	 $pdf->WriteHTML($html);
      
	$pdf->Output($pdfFilePath, "I");
    }

    public function print_asn_pallet_lables() {
        //define("ASN_PRINT_BARCODES", 201); // update module table & delete this line
        if ($this->mlogin->get_permission(ASN_PRINT_BARCODES)) {
			 $asn_number = $this->input->get_post('asn_number');
						
			$history = array('status_id' => ASN_BARCODE_PRINTED, 'ref_type' => 'asn', 'ref' => $asn_number,
				'field' => 'asn_number', 'field_id' => $asn_number, 'text' => ' Pallet Lables Printed');
			$this->mlogin->write_history($history);				
			

            $this->pallet_code['pallet_code'] = $this->Mbarcode->get_pallet_number($asn_number,"asn_barcode");
            $this->load->view('barcode', $this->pallet_code);

            $data['the_content'] = "";

            $html = $this->load->view('barcode', $data, true);

            $pdfFilePath = "$asn_number.pdf";

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

    public function generate_asn_barcodes() {
       // define("ASN_GENERATE_BARCODES", 201); // update module table & delete this line
        if ($this->mlogin->get_permission(ASN_GENERATE_BARCODES)) {
            $asn_number = $this->input->get_post('asn_number');
            if(!$this->masn->generate_asn_barcodes($asn_number)) {
				echo 'You have items without handling quantities. Cannot generate barcodes';
			}else{
				 $history = array('status_id' => ASN_BARCODE_GENERATED, 'ref_type' => 'asn', 'ref' => $asn_number,
                'field' => 'asn_number', 'field_id' => $asn_number, 'text' => 'Barcode Generated');
	            $this->mlogin->write_history($history);	
			}
        } else {
            echo 'Sorry you are not authorized to generate barcodes';
        }
    }

    public function add_asn() {
        //define("ASN_ADD", 201); // update module table & delete this line
        if ($this->mlogin->get_permission(ASN_ADD)) {
            $asn_type_id = $this->input->get_post('asn_type_id');
            $asn_number = $this->masn->add_asn($asn_type_id);

            $history = array('status_id' => ASN_NEW, 'ref_type' => 'asn', 'ref' => $asn_number,
                'field' => 'asn_number', 'field_id' => $asn_number, 'text' => 'new ASN added');
            $this->mlogin->write_history($history);

            echo '{"asn_number":"' . $asn_number . '","message":"" }';
        } else {
            echo '{"asn_number":"","message":"Sorry you are not authorized to add ASNs" }';
        }
    }

    public function asn() {
		
        $asn_number = $this->input->get_post('asn_number');
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        if ($this->mlogin->get_permission(ASN_VIEW)) {
        	$new_data['container_info']= $this->masn->get_container_size();
            $data_para['asn_number'] = $asn_number;
            $data["asn_barcodes_summary"] = $this->masn->get_asn_barcode_summary($asn_number);
            $data["asn_barcodes"] = $this->masn->get_asn_barcode($asn_number);
            $data["stos"] = $this->masn->get_sto_list($data_para);
            $data["sto_details"] = $this->masn->get_sto_detail($data_para);
            $data["asn"] = $this->masn->get_asn($data_para);
			$data["exceptions"] = $this->masn->get_asn_exception($asn_number);
			$data["history_list"] = $this->masn->get_asn_history($asn_number);
			
            //$this->load->view('asn/asn', $data,$new_data);
          if($vehicle_info_fill=''){
              
          }else{
            $this->load->view('asn/asn',  array_merge($data,$new_data));
          }
        } else {
            $this->load->view('no_permission');
        }

        $this->load->view('html_footer');
    }

    public function asn_list() {
        //define("ASN_LIST", 201); // update module table & delete this line

        $data_para = array();

        $data_para["asn_type_id"] = $this->input->get_post('type');
        $data_para["top"] = $this->input->get_post('top');

        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        if ($this->mlogin->get_permission(ASN_LIST)) {
          
            $data["asns"] = $this->masn->get_asn_list($data_para);
            if ($data_para["asn_type_id"] == 1)
                $data["asn_type"] = "General ASNs";
            if ($data_para["asn_type_id"] == 2)
                $data["asn_type"] = "Shuttle ASNs";
            if ($data_para["asn_type_id"] == "")
                $data["asn_type"] = "All ASNs";

            if ($data_para["top"] > 0)
                $data["count_title"] = "Most Recent ";
            else
                $data["count_title"] = "";

            $this->load->view('asn/asn_list', $data);
        }else {
            $this->load->view('no_permission');
        }
        $this->load->view('html_footer');
    }

    public function sto_upload() {
          if ($this->mlogin->get_permission(ASN_STO_UPLOAD)) {
	    $file = $_FILES["new_sto"]['tmp_name'];
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $data['asn_number'] = $this->input->get_post('asn_number');

        $asn = $this->masn->get_asn($data);

        if ($asn->num_rows() > 0) {
            $asn_type_id = $asn->row()->asn_type_id;
            if ($asn_type_id == 1) {
                $value = $objPHPExcel->getActiveSheet()->getCell("L1")->getValue();
                if ($value == "Debit/Credit Ind.") {
                    $this->db->trans_start();
                    $this->general_sto_upload($data['asn_number']);
                    $this->db->trans_complete();
                } else {
                    echo 'Invalid file';
                }
            } elseif ($asn_type_id == 2) {
                $value = $objPHPExcel->getActiveSheet()->getCell("F1")->getValue();
                if ($value == "PGI Date") {
                    $this->db->trans_start();
                    $this->shuttle_sto_upload($data['asn_number']);
                    $this->db->trans_complete();
                } else {
                    echo 'Invalid file';
                }
            }
        } else {
            echo 'Invalid file';
        }
		  }else {
            echo 'Sorry you are not authorized to upload STOs';
        }
    }

    public function shuttle_sto_upload($asn_number) {
       // define("ASN_STO_UPLOAD", 201); // update module table & delete this line
        if ($this->mlogin->get_permission(ASN_STO_UPLOAD)) {
            if (file_exists($_FILES["new_sto"]['tmp_name'])) {
                $file = $_FILES["new_sto"]['tmp_name'];
                    $data_line_start = 2;
                    $objPHPExcel = PHPExcel_IOFactory::load($file);

                    $loop = $data_line_start;
                    $pre_sto_number = "";
                    while ($loop != "exit") {
						$sto_number = trim($objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue());
						$sto_number = str_pad($sto_number,10,"0",STR_PAD_LEFT);
						
                        $data_sto['asn_number'] = $asn_number;
                        $data_sto['item_number'] = $objPHPExcel->getActiveSheet()->getCell("B$loop")->getValue();
                        $data_sto['product_id'] = $objPHPExcel->getActiveSheet()->getCell("C$loop")->getValue();
                        $data_sto['quantity'] = $objPHPExcel->getActiveSheet()->getCell("E$loop")->getValue();
                        $data_sto['quantity'] = abs($data_sto['quantity']);
                        $data_sto['plant_code'] = 0;
                        $data_sto['sto_number'] = $sto_number;
                        $data_sto['po_number'] = $data_sto['sto_number'];
                        $data_sto['material_doc_item'] = '';


                        if ($loop == 2 or $data_sto['sto_number'] != $pre_sto_number){
							$this->masn->add_sto($data_sto);
							$history = array('status_id' => ASN_STO_UPLOADED, 'ref_type' => 'asn', 'ref' => $asn_number,
								'field' => 'asn_number', 'field_id' => $asn_number, 'text' => $data_sto['sto_number'] . ' STO Uploaded');
							$this->mlogin->write_history($history);	
						}
                            

                        $this->masn->add_sto_detail($data_sto);

                        $pre_sto_number = $data_sto['sto_number'];

                        $loop++;
                        if ($objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue() == "")
                            $loop = "exit";
                    }
					
					$this->masn->populate_asn_barcode($asn_number);
                    echo 'File uploaded';
					
            }
        } else {
            echo 'Sorry you are not authorized to upload STOs';
        }
    }

    public function general_sto_upload($asn_number) {
       // define("ASN_STO_UPLOAD", 201); // update module table & delete this line
        if ($this->mlogin->get_permission(ASN_STO_UPLOAD)) {
            if (file_exists($_FILES["new_sto"]['tmp_name'])) {
                $file = $_FILES["new_sto"]['tmp_name'];
				
                    $data_line_start = 2;
                    $objPHPExcel = PHPExcel_IOFactory::load($file);

                    $loop = $data_line_start;
                    $pre_sto_number = "";
                    while ($loop != "exit") {
						$sto_number = trim($objPHPExcel->getActiveSheet()->getCell("J$loop")->getValue());
						$sto_number = str_pad($sto_number,10,"0",STR_PAD_LEFT);
						
                        $data_sto['asn_number'] = $asn_number;
                        $data_sto['item_number'] = $objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue();
                        $data_sto['product_id'] = $objPHPExcel->getActiveSheet()->getCell("B$loop")->getValue();
                        $data_sto['quantity'] = $objPHPExcel->getActiveSheet()->getCell("D$loop")->getValue();
                        $data_sto['quantity'] = abs($data_sto['quantity']);
                        $data_sto['plant_code'] = $objPHPExcel->getActiveSheet()->getCell("E$loop")->getValue();
                        $data_sto['sto_number'] = $sto_number;
                        $data_sto['po_number'] = $objPHPExcel->getActiveSheet()->getCell("I$loop")->getValue();
                        $data_sto['material_doc_item'] = $objPHPExcel->getActiveSheet()->getCell("K$loop")->getValue();


                        if ($loop == 2 or $data_sto['sto_number'] != $pre_sto_number){
							$history = array('status_id' => ASN_STO_UPLOADED, 'ref_type' => 'asn', 'ref' => $asn_number,
								'field' => 'asn_number', 'field_id' => $asn_number, 'text' => $data_sto['sto_number'] . ' STO Uploaded');
							$this->mlogin->write_history($history);								
							$this->masn->add_sto($data_sto);
						}
                            

                        $this->masn->add_sto_detail($data_sto);

                        $pre_sto_number = $data_sto['sto_number'];


                        $loop++;
                        if ($objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue() == "")
                            $loop = "exit";
                    }
					$this->masn->populate_asn_barcode($asn_number);
                    echo 'File uploaded';
                
            }
        } else {
            echo 'Sorry you are not authorized to upload STOs';
        }
    }

    public function sto_delete() {
       // define("ASN_STO_DELETE", 201); // update module table & delete this line
        if ($this->mlogin->get_permission(ASN_STO_DELETE)) {
            $sto_number = $this->input->get_post('sto_number');
			$asn_number = $this->input->get_post('asn_number');
			
            $this->db->trans_start();
            $this->masn->sto_delete($sto_number);
			
            $this->db->trans_complete();
			$history = array('status_id' => ASN_STO_DELETED,'ref_type' => 'asn','ref' => $asn_number,
							 'field' => "status_id",'field_id' => ASN_STO_DELETED,'text' => $sto_number." STO Deleted");
			$this->mlogin->write_history($history);					
			
        } else {
            echo 'Sorry you are not authorized to upload STOs';
        }
    }

	public function vehicle_information_update() {
		$asn_number=$this->input->get_post('asn_number');
		$vehicle_number = $this->input->get_post('vehicle_number');
		$contact_person = $this->input->get_post('contact_person');
		$phone_number = $this->input->get_post('phone_number');
		$container_number = $this->input->get_post('container_number');
		$container_size = $this->input->get_post('container_size');
	   
	  $vehicle_data = array(
			'asn_number' => $asn_number,
			'vehicle_number'=>$vehicle_number,
			'contact_person'=>$contact_person,
			'phone_number'=>$phone_number,
			'container_number'=>$container_number,
			'container_size'=>$container_size
		);
		  
		$this->masn->update_vehicle_information($vehicle_data);
			$history = array('status_id' => ASN_HEADER_INFO_UPDATED,'ref_type' => 'asn','ref' => $asn_number,
							 'field' => "status_id",'field_id' => ASN_HEADER_INFO_UPDATED,'text' => " ASN Header information updated");
			$this->mlogin->write_history($history);				
	}
	
	public function asn_release_for_adjustments(){
		if ($this->mlogin->get_permission(ASN_RELEASE_FOR_ADJUSTMENTS)) {
			$asn_number = $this->input->get_post('asn_number');

			$this->db->trans_start();
			$data = array("asn_number"=>$asn_number,"status_id"=>ASN_UNLOADING_STARTED);
			$this->mwms->asn_mark_as_completed($asn_number); // this function to be commented on WMS SHUTDOWN
			$this->masn->change_asn_status($data);
			
			$history = array('status_id' => ASN_RELEASED_FOR_CORRECTIONS,'ref_type' => 'asn','ref' => $asn_number,
							 'field' => "status_id",'field_id' => ASN_RELEASED_FOR_CORRECTIONS,'text' => "Release for adjustments");
			$this->mlogin->write_history($history);				
			$this->db->trans_complete();
		} else {
			echo 'Sorry you are not authorized to Release ASN for adjustments';
		}			
	}

	public function mark_as_completed(){
		if ($this->mlogin->get_permission(ASN_MARK_AS_COMPLETED)) {
			$asn_number = $this->input->get_post('asn_number');

			$this->db->trans_start();
			$data = array("asn_number"=>$asn_number,"status_id"=>ASN_COMPLETED);
			$this->masn->change_asn_status($data);
			$this->masn->allocate_unloaded_quantity_to_sto($asn_number);
			$this->mwms->asn_mark_as_completed($asn_number);// interface
			
			$history = array('status_id' => ASN_COMPLETED,'ref_type' => 'asn','ref' => $asn_number,
							 'field' => "status_id",'field_id' => ASN_COMPLETED,'text' => "Marked as Completed");
			$this->mlogin->write_history($history);				
			$this->db->trans_complete();
		} else {
			echo 'Sorry you are not authorized to Release ASN for adjustments';
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

	public function list_shuttles(){
		
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
		$limit= $this->input->get_post('top');	
			if ($this->mlogin->get_permission(SHUTTLE_LIST)) {
				
				$data['list_detail']=$this->masn->list_shuttles($limit);
				$this->load->view('asn/shuttles_list',$data);
			}else{
			    $this->load->view('no_permission');
			}
	    $this->load->view('html_footer');
	}
	
	public function shuttle_detail(){
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		$shuttle_number= $this->input->get_post('shuttle_number');	
	
		if ($this->mlogin->get_permission(SHUTTLE_DETAILS)) {
			$data['shuttle_details'] = $this->masn->shuttle_details($shuttle_number);	
			$data['shuttle_product_details'] = $this->masn->shuttle_product_details($shuttle_number);	
			$data['shuttle_history'] = $this->masn->shuttle_history($shuttle_number);
		
			$this->load->view('asn/shuttle_details',$data);
		
		}else{
			$this->load->view('no_permission');
		}
		$this->load->view('html_footer');

	}
	
	public function shuttle_date_scheduled(){
		$data['schedule_date']=$this->input->get_post('date');
		$shuttle_number=$this->input->get_post('shuttle_number');
			if ($this->mlogin->get_permission(SHUTTLE_DETAILS)) {
				$return=$this->masn->save_schedule_date($data,$shuttle_number);
				
				$status_id=SHUTTLE_SCHEDULED;
				
				$history = array('status_id' => $status_id,'ref_type' => 'shuttle','ref' => $shuttle_number,
				'field' => 'Shuttle Number','field_id' => $shuttle_number,'text' => "Shuttle Date Scheduled");
				$this->mlogin->write_history($history);
			}else{
			
				echo 'Sorry you are not authorized to Schedule Shuttle Date';
			}
	}
	
	
	public function shuttle_upload (){
	 if (file_exists($_FILES["new_shuttle"]['tmp_name'])) {
			$file = $_FILES["new_shuttle"]['tmp_name'];
			  $objPHPExcel = PHPExcel_IOFactory::load($file);
			  $value = $objPHPExcel->getActiveSheet()->getCell("A1")->getValue();
			  $value1 = $objPHPExcel->getActiveSheet()->getCell("R1")->getValue();
			  $loop = 2;
			  $end = 0;
			  $lp_number ="";
			  $lp_numbers = array();
              if ($value == "LP No." && $value1=="Operations Text" ) {
//					while ($loop != "exit") {
//						$lp_number = $objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue();
//						array_push($lp_numbers,$lp_number);
//						
//                        $loop++;
//                        if ($objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue() == "") {
//							$loop = "exit";					
//							$end = $loop - 1;
//						}
//					}
//					$lp_numbers = array_unique($lp_numbers);
//					$this->msap->import_lp_numbers_from_excel_dump($lp_numbers);
//					$this->msap->import_lp_detail_from_excel_dump($objPHPExcel,2);
					echo 'LPs Uploaded';
				}else{	
					echo 'Invalid file';
				}
				
	 }else{
	 	echo 'File uploaded Unsuccessful';
	 }
	
	
	}
	public function print_asn_refdoc(){
	
	
		$this->load->library('m_pdf');
		$pdf = $this->m_pdf->load();
		
		$mpdf = new mPDF('utf-8', array(210, 148));
		$mpdf->SetFont("times new roman");	
		$asn_number = $this->input->get_post('asn_number');
		$path=$this->create_barcode($asn_number);
		//$path = 'barcode_image/a.png';
        $mpdf->SetHeader("<table align='center'  width='1200' border='0'>
            <tr>
                <td width='200' height='47'><img src='web/logo.png' width='200' height='85'></td>
                <td align='center' width='750'><div style='font-size:55px;font-weight:bold'>ASN REFERENCE DOC</div></td> 
				<td ><img src='".$path."' style='width:400px;height:60px'></td>	 
            </tr>  
        </table>");
		 $data["asn_detail"] = $this->masn->get_vw_asn($asn_number);
		  $data["path"]=$path;
		 $this->load->view('asn/asn_refdoc', $data);
		//$mpdf->setFooter("|| Date: {DATE j-m-Y } Time: {DATE h:i:sa} <br/>Printed by : ".$this->session->userdata('user_name')."  <br>");
		
		$mpdf->setFooter("Global Star Logistics (PVT) Ltd <br>No:719/17,
        Liyanagemulla,Seeduwa,<br> Sri Lanka. 
       || Date: {DATE j-m-Y } Time: {DATE h:i:sa} <br/>Printed by : ".$this->session->userdata('username')."  <br>");
		
		
		$mpdf->SetMargins("", "", 25);
		$pdf = $mpdf;	
		//	
		$html = $this->load->view('asn/asn_refdoc', $data, true);
		
		$pdfFilePath = "estimate.pdf";
		
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, "I");
			
			
	}
	
}