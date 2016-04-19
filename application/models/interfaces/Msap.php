<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msap extends CI_Model {
	private	$after_process_folder = "sap_data/processed/";
	private	$local_folder = "sap_data/to_be_processed/";
	private	$ftp_server = "data.gtllanka.com";
	private	$ftp_user = "Loadstar";
	private	$ftp_password = "ETJi7x9xfL";
	private	$ftp_remote_dir = "SCMBOS/PI_FILES/DEV/";
	
	// ********* folder name ******************** //
	private	$data_folders =  array("BillOfMaterials","GoodsIssue","GoodsTransfer","Loading Proposal","Materials","PurchaseOrders","Shipment") ;		
		
	private	$material_folder = "Materials";
	private	$material_bom_folder = "BillOfMaterials";
	private	$goods_issue_folder = "GoodsIssue";
	private	$loading_proposal_folder = "Loading Proposal";
	// ***************************************** //
	
	
    function __construct()
    {
        parent::__construct();
		$this->load->model('user/mlogin');
		$this->load->model('common/mcommon');
		$this->load->model('mfm/mproduct');
		$this->load->model('asn/masn');
		
		$this->load->library('excel');
		
    }
	
	public function import_loading_proposal(){
		//$this->download_a_folder($this->loading_proposal_folder);	
		$data_files = glob($this->local_folder.$this->loading_proposal_folder."/loading proposal*");
		foreach($data_files as $data_file){
			$this->import_loading_proposal_from_xml_file($data_file);
//			if(copy($data_file,$this->after_process_folder.$this->goods_issue_folder."/".basename($data_file))){
//				$conn_id = ftp_connect($this->ftp_server);
//				$login_result = ftp_login($conn_id, $this->ftp_user , $this->ftp_password );
//				ftp_delete($conn_id,$this->ftp_remote_dir.$this->goods_issue_folder."/".basename($data_file));
//				unlink($data_file);						
//			}

		}		
	}
	
	
	private function import_loading_proposal_from_xml_file($data_file){
		$xml = file_get_contents($data_file);
		$xml = new SimpleXMLElement($xml);



				
				if (array_key_exists("LPNumber",$xml)){
					$data["lp_number"] = ltrim($xml->LPNumber,"0");
					$data["client_code"] = ltrim(trim($xml->CustomerCode),"0");	
					$data["destination_code"] = trim($xml->DestinationCode);
					$data["destination"] = 'get from SAP';//trim($xml->DestinationCode);
					$data["tmp_destination"] = 'get from SAP';//trim($xml->DestinationCode);
					$data["container_size_id"] = $this->mcommon->get_code_from_text(trim($xml->ContainerSize),'container_size','container_size_id','container_size');	
					$data["freight_type_id"] = $this->mcommon->get_code_from_text(trim($xml->ShipMethod),'freight_type','freight_type_id','freight_type');	

					$header_texts = $xml->HeaderText;
					$data["header_texts"] = "";
					foreach($header_texts as $header_text){
						$data["header_texts"] .= "<b>".$this->mcommon->get_column_value($header_text->Id,"sap_code","sap_value","sap_code")."</b> : ";	
						//$data["header_texts"] .= "----------------------------------------------------------<br/>";	
						$data["header_texts"] .= $header_text->Text->TextLine."<br/>";	
					}
					var_dump($data);
					echo $data["header_texts"];
				die();	
						$data = array(
							"client_code" => 1,
							"master_product_id" => "",
							"product_id" => "",
							"quantity" => 0,
							"unit" => "");
							
						$data["master_product_id"] = $master_data->MaterialNumber;
						$this->mproduct->delete_product_bom($data["master_product_id"]);
						for($i=0 ; $i < sizeof($items) ; $i++){
							$data["product_id"] = $items[$i]->BOMComponent ;
							$data["quantity"] = $items[$i]->Quantity ;
							$data["unit"] = $items[$i]->UOM ;	
							$this->mproduct->update_product_bom($data);
						}
					
				}

	}	
	
	
	public function import_goods_issue(){
		$this->download_a_folder($this->goods_issue_folder);
		$data_files = glob($this->local_folder.$this->goods_issue_folder."/goodsissue*");
	
		foreach($data_files as $data_file){
			$this->import_goods_issue_from_xml_file($data_file);
			if(copy($data_file,$this->after_process_folder.$this->goods_issue_folder."/".basename($data_file))){
				$conn_id = ftp_connect($this->ftp_server);
				$login_result = ftp_login($conn_id, $this->ftp_user , $this->ftp_password );
				ftp_delete($conn_id,$this->ftp_remote_dir.$this->goods_issue_folder."/".basename($data_file));
				unlink($data_file);						
			}

		}		
	
	}
	
	private function import_goods_issue_from_xml_file($data_file){
		$xml = file_get_contents($data_file);
		$xml = new SimpleXMLElement($xml);

		if (array_key_exists("MBGMCR03",$xml)){
			if (sizeof($xml->MBGMCR03)>0){
				$master_data = $xml->MBGMCR03[0];
				if (array_key_exists("YourReference",$master_data)){
					$asn_number = trim($master_data->YourReference);
					$sap_asn_number = trim($master_data->ASNNumber);
					if (array_key_exists("Items",$master_data)){
						$items = $master_data->Items;
						$asn_stos = array();
						$asn_sto_numbers  = array();
						$asn_sto_details  = array();
						for($i=0 ; $i < sizeof($items) ; $i++){
							$data  = array();
							$data["asn_number"] = $asn_number ;
							$data["sto_number"] = trim($items[$i]->STONumber) ;
							$data["plant_code"] = trim($items[$i]->SupplyStorageLocation) ;
							$data["product_id"] = trim($items[$i]->MaterialNumber) ;
							$data["po_number"] = trim($items[$i]->SalesOrderNumber) ;
							$data["item_number"] = trim($items[$i]->ItemNumber) ;
							$data["material_doc_item"] = trim($items[$i]->STOLineItemNumber) ;
							$data["plant_code"] = trim($items[$i]->SupplyPlant) ;
							$data["datetime_post"] = date("Y-m-d H:i:s",strtotime(trim($master_data->LSPostingDate))) ;
							$data["quantity"] =  trim($items[$i]->Quantity) ;
							$data["xml_file"] = basename($data_file);
							$data["sap_asn_number"] = $sap_asn_number;							
							array_push($asn_sto_details,$data);	

							if(!in_array($data["sto_number"],$asn_sto_numbers)){
								array_push($asn_sto_numbers, $data["sto_number"]);
								$asn_sto_data = array();
								$asn_sto_data["sto_number"] = $data["sto_number"];
								$asn_sto_data["asn_number"] = $data["asn_number"];
								$asn_sto_data["plant_code"] = $data["plant_code"];
								$asn_sto_data["datetime_post"] = $data["datetime_post"];
								$asn_sto_data["xml_file"] = basename($data_file);
								array_push($asn_stos,$asn_sto_data);							
							}
						}						
							
					}

					$this->db->select("status_id");
					$this->db->from("asn");
					$this->db->where("asn_number",$asn_number);
					$result = $this->db->get();					
					if($result->num_rows() > 0){
						if($result->row()->status_id==ASN_NEW){
							for($i= 0 ; $i < sizeof($asn_stos) ; $i++){
								$this->masn->add_sto($asn_stos[$i]);
							}
		
							foreach($asn_sto_details as $asn_sto_detail){
								$this->masn->add_sto_detail($asn_sto_detail);
							}
							$this->masn->populate_asn_barcode($asn_number);				
						}	
					}					
					
				}
			}
		}		
	}
	
	
	public function import_material_boms(){
		$this->download_a_folder($this->material_bom_folder);
		$data_files = glob($this->local_folder.$this->material_bom_folder."/BillOfMaterials*");
	
		foreach($data_files as $data_file){
			$this->import_material_bom_from_xml_file($data_file);
			if(copy($data_file,$this->after_process_folder.$this->material_bom_folder."/".basename($data_file))){
				$conn_id = ftp_connect($this->ftp_server);
				$login_result = ftp_login($conn_id, $this->ftp_user , $this->ftp_password );
				ftp_delete($conn_id,$this->ftp_remote_dir.$this->material_bom_folder."/".basename($data_file));
				unlink($data_file);						
			}

		}		
		
	}
	

	
	private function import_material_bom_from_xml_file($data_file){
		$xml = file_get_contents($data_file);
		$xml = new SimpleXMLElement($xml);

		if (array_key_exists("BOMMAT04",$xml)){
			if (sizeof($xml->BOMMAT04)>0){
				$master_data = $xml->BOMMAT04[0];	
				if (array_key_exists("MaterialNumber",$master_data)){
					
					if (array_key_exists("LineItems",$master_data)){
						$items = $master_data->LineItems;
						$data = array(
							"client_code" => 1,
							"master_product_id" => "",
							"product_id" => "",
							"quantity" => 0,
							"unit" => "");
							
						$data["master_product_id"] = $master_data->MaterialNumber;
						$this->mproduct->delete_product_bom($data["master_product_id"]);
						for($i=0 ; $i < sizeof($items) ; $i++){
							$data["product_id"] = $items[$i]->BOMComponent ;
							$data["quantity"] = $items[$i]->Quantity ;
							$data["unit"] = $items[$i]->UOM ;	
							$this->mproduct->update_product_bom($data);
						}
					}
				}
			}
		}
	}
	
	
	public function import_material_masters(){
		$this->download_a_folder($this->material_folder);
		$data_files = glob($this->local_folder.$this->material_folder."/MaterialMaster*");

		foreach($data_files as $data_file){
			$this->import_material_master_from_xml_file($data_file);
			if(copy($data_file,$this->after_process_folder.$this->material_folder."/".basename($data_file))){
				$conn_id = ftp_connect($this->ftp_server);
				$login_result = ftp_login($conn_id, $this->ftp_user , $this->ftp_password );
				ftp_delete($conn_id,$this->ftp_remote_dir.$this->material_folder."/".basename($data_file));
				unlink($data_file);						
			}

		}
	}
	
	public function download_a_folder($folder_name=""){
		$conn_id = ftp_connect($this->ftp_server);
			if(ftp_login($conn_id, $this->ftp_user , $this->ftp_password )){
				
				if(!file_exists($this->after_process_folder.$folder_name)){
					mkdir($this->after_process_folder.$folder_name);
				}
				if(!file_exists($this->local_folder.$folder_name)){
					mkdir($this->local_folder.$folder_name);
				}	
	
				$files = ftp_nlist($conn_id, $this->ftp_remote_dir.$folder_name."/");

				for($i = 0 ; $i < sizeof($files) ; $i++){
					$local_file =  $this->local_folder.$folder_name."/".basename($files[$i]) ;
					$server_file = $files[$i] ;

					if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
	
					}
				}
			}
		
	}
	
	private function import_material_master_from_xml_file($data_file){
		$data = array(
					"client_code" => 1,
					"product_id" => "",
					"description" => "",
					"long_description" => "",
					"size" => "",
					"weight_net" => 0,
					"weight_gross" => 0,
					"volume" => 0,
					"material_type" => "",
					"material_group" => "",
					"ext_material_group" => "",
					"client_status" => "Active",
					"scm_status" => 1);
		$xml = file_get_contents($data_file);
		$xml = new SimpleXMLElement($xml);
		if (array_key_exists("MATMAS05",$xml)){
			if (sizeof($xml->MATMAS05)>0){
				$master_data = $xml->MATMAS05[0];	
				if (array_key_exists("MaterialCode",$master_data)){
					$data["product_id"] = $master_data->MaterialCode;
				}
				if (array_key_exists("Description",$master_data)){
					$data["description"] = $master_data->Description;
				}
				if (array_key_exists("LongText",$master_data)){
					$data["long_description"] = $master_data->LongText;
				}	
				if (array_key_exists("Size",$master_data)){
					$data["size"] = $master_data->Size;
				}
				if (array_key_exists("NetWeight",$master_data)){
					$data["weight_net"] = $master_data->NetWeight;
				}
				if (array_key_exists("GrossWeight",$master_data)){
					$data["weight_gross"] = $master_data->GrossWeight;
				}
				if (array_key_exists("Volume",$master_data)){
					$data["volume"] = $master_data->Volume;
				}
				if (array_key_exists("Height",$master_data)){
					$data["height"] = $master_data->Height;
				}
				if (array_key_exists("MaterialType",$master_data)){
					$data["material_type"] = $master_data->MaterialType;
				}
				if (array_key_exists("MaterialGroup",$master_data)){
					$data["material_group"] = $master_data->MaterialGroup;
				}
				if (array_key_exists("ExtMaterialGroup",$master_data)){
					$data["ext_material_group"] = $master_data->ExtMaterialGroup;
				}
			}
		}
		$this->mproduct->update_product($data);
	}
	
	public function download_data_files_from_ftp_server(){
		$local_folder = $this->local_folder;
		$ftp_server = $this->ftp_server ;
		$ftp_user = $this->ftp_user;
		$ftp_password = $this->ftp_password;
		$ftp_remote_dir = $this->ftp_remote_dir;
		
		$data_folders =  $this->data_folders;
		
		
		for($i = 0 ; $i < sizeof($data_folders) ; $i++){
			$data_folder = $local_folder.$data_folders[$i];
			$data_folder_processed = $this->after_process_folder.$data_folders[$i];
			if(!file_exists($data_folder)){
				mkdir($data_folder);
			}
			if(!file_exists($data_folder_processed)){
				mkdir($data_folder_processed);
			}			
		}
		
		
		$conn_id = ftp_connect($ftp_server);
		$login_result = ftp_login($conn_id, $ftp_user , $ftp_password );
		
		for($j = 0 ; $j < sizeof($data_folders) ; $j++){
			$files = ftp_nlist($conn_id, $ftp_remote_dir.$data_folders[$j]."/");
			for($i = 0 ; $i < sizeof($files) ; $i++){
				$local_file =  $local_folder.$data_folders[$j]."/".basename($files[$i]) ;
				$server_file = $files[$i] ;
				if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {

				}
			}
		}
		
		ftp_close($conn_id);
	}
	
	public function import_inventory(){
		$file = "application/uploads/client_inventory/sap_inventory.xls";
		$data_line_start = 2;
        $objPHPExcel = PHPExcel_IOFactory::load($file);

		$loop = $data_line_start;
		
		$this->db->trans_start();
		
		$this->db->truncate('client_inventory');
		
		while ($loop != "exit") {
			$data['product_id'] = $objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue();
			$data['quantity'] = $objPHPExcel->getActiveSheet()->getCell("E$loop")->getValue();
			
			$this->db->where("product_id",$data['product_id']);
			$result = $this->db->get('client_inventory');

			
			if($result->num_rows()>0){
				$total_qty = $result->row()->quantity + $data['quantity'];
				$this->db->set("quantity",$total_qty);
				$this->db->where("product_id",$data['product_id']);
				$this->db->update('client_inventory');	
			}else{
				$this->db->insert('client_inventory',$data);	
			}
			

			$loop++;
			if ($objPHPExcel->getActiveSheet()->getCell("A$loop")->getValue() == "") $loop = "exit";		
		}				
		
		$this->db->trans_complete();
	}
	
	public function import_ccat(){
		
	}	
	

	
	public function import_lp_numbers_from_excel_dump($lp_numbers){
		$updated_lp_numbers = array();

		foreach($lp_numbers as $lp_number){
			$this->db->select("lp_number");
			$this->db->from("lp");
			$this->db->where("lp_number",$lp_number);
			if($this->db->get()->num_rows()<=0){
				$this->db->set("lp_number",$lp_number);
				$this->db->set("current_status_id",LP_NEW);
				$this->db->set('datetime_created', 'NOW()', FALSE);
				$this->db->insert("lp");
			}
		}
	}
	
	private function get_oem_pid($client_code="",$product_id="",$sub_customer=""){
		$this->db->select("*");
		$this->db->from("product_oem");
		$this->db->where("product_id",$product_id);
		$this->db->where("client_code",$client_code);
		$this->db->where("sub_customer",$sub_customer);		
		$result = $this->db->get();		
		if($result->num_rows()>0){
			$product_id = $result->row()->product_id_oem;	
		}
		return $product_id;
	}
	
	public function import_lp_detail_from_excel_dump($objPHPExcel,$start){
		$updated_lp_numbers = array();
		
		$container_sizes = ($this->mcommon->get_data_array("container_size_id","container_size","container_size"));
		$freight_types = ($this->mcommon->get_data_array("freight_type_id","freight_type","freight_type"));

		while ($start != "exit") {
			$lp_number = trim($objPHPExcel->getActiveSheet()->getCell("A$start")->getValue());
			$data["client_code"] = $objPHPExcel->getActiveSheet()->getCell("C$start")->getValue();
			$data["country"] = $objPHPExcel->getActiveSheet()->getCell("D$start")->getValue();
			$data["destination_code"] = $objPHPExcel->getActiveSheet()->getCell("E$start")->getValue();
			$data["tmp_destination"] = $objPHPExcel->getActiveSheet()->getCell("F$start")->getValue();
			$freight_type = $objPHPExcel->getActiveSheet()->getCell("L$start")->getValue();
			$cargo_ready_date = $objPHPExcel->getActiveSheet()->getCell("N$start")->getValue();

				$data_detail = array();
				$data_detail["lp_number"] = $lp_number ;
				$data_detail["product_id"] = $objPHPExcel->getActiveSheet()->getCell("G$start")->getValue();
				$data_detail["quantity"] = $objPHPExcel->getActiveSheet()->getCell("I$start")->getValue();
				$data_detail["sub_customer"] = $objPHPExcel->getActiveSheet()->getCell("M$start")->getValue();			
				
				if($data_detail["sub_customer"]<>""){
					$data_detail["original_product_id"] = $data_detail["product_id"];
					$data_detail["product_id"] = $this->get_oem_pid($data["client_code"],$data_detail["product_id"],$data_detail["sub_customer"]);
					
				}
				
				
				if(!in_array($lp_number,$updated_lp_numbers)){
					$date = $objPHPExcel->getActiveSheet()->getCell("N$start")->getValue();
					if($date=="") $data["cargo_ready_date"] = NULL;
						else $data["cargo_ready_date"] = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
					
					$date = $objPHPExcel->getActiveSheet()->getCell("O$start")->getValue();
					if($date=="") $data["delivery_block_removed_date"] = NULL;
						else $data["delivery_block_removed_date"] = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
				
					$date = $objPHPExcel->getActiveSheet()->getCell("P$start")->getValue();
					if($date=="") $data["vessel_closing_date"] = NULL;
						else $data["vessel_closing_date"] = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));


					$container_size = trim($objPHPExcel->getActiveSheet()->getCell("K$start")->getValue());
					$container_size_id = array_search($container_size,$container_sizes);
					$container_size_id = ($container_size_id==false?0:$container_size_id);

					$freight_type = trim($objPHPExcel->getActiveSheet()->getCell("L$start")->getValue());
					$freight_type_id = array_search($freight_type,$freight_types);
					$freight_type_id = ($freight_type_id==false?0:$freight_type_id);

					$this->db->set('freight_type_id', $freight_type_id);
					$this->db->set('container_size_id', $container_size_id);
					$this->db->set('datetime_created', 'NOW()', FALSE);
					$this->db->where("lp_number",$lp_number);
					$this->db->update('lp',$data);			
					
					$this->db->where("lp_number",$lp_number);
					$this->db->delete('lp_detail');				
	
					array_push($updated_lp_numbers,$lp_number);
					
					// write to history
					$history = array('status_id' => LP_IMPORTED_FROM_EXCEL, 'ref_type' => 'lp', 'ref' => $lp_number,
						'field' => 'lp_number', 'field_id' => $lp_number, 'text' => 'LP Imported from Excel');
					$this->mlogin->write_history($history);									
				}
				
				$this->db->select("*");
				$this->db->from("lp_detail");
				$this->db->where("lp_number",$lp_number);
				$this->db->where("product_id",$data_detail["product_id"]);
				$this->db->where("sub_customer",$data_detail["sub_customer"]);
				$result = $this->db->get();
					if($result->num_rows()>0){
						$lp_detail_id = $result->row()->lp_detail_id;
						$quantity = $data_detail["quantity"] + $result->row()->quantity;
						$this->db->where("lp_detail_id",$lp_detail_id);
						$this->db->set('quantity',$quantity);
						$this->db->update('lp_detail');
					}else{
						$this->db->insert('lp_detail',$data_detail);	
					}
			
			$start++;
			if ($objPHPExcel->getActiveSheet()->getCell("A$start")->getValue() == ""){
				$start = "exit";					
			}
			
		}		
	}	
	
	
}

