<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mwms extends CI_Model {
    function __construct()
    {
        parent::__construct();
		$this->load->model('user/mlogin');
		date_default_timezone_set('Asia/Colombo');
		
    }
	
	public function asn_mark_as_completed($asn_number=""){
		
		$date_scanned = date("Y-m-d H:i:s");
		$from_location = 'R.DOCK';
		$to_location = "";
		$temp_location = "";
		$unique_id = "";
		$moment_PO = "R TO L";
		$username = "";
		
		$wms_db = $this->load->database("gtl",true);	
		
		$this->db->select("asn.asn_number,lm_location.location,asn_sto.sto_number,asn_sto_detail.product_id,
							Sum(asn_sto_detail.unloaded_quantity) AS unloaded_quantity");
		$this->db->from("asn");
		$this->db->join("lm_location","lm_location.location_id = asn.bay_id");
		$this->db->join("asn_sto","asn.asn_number = asn_sto.asn_number");
		$this->db->join("asn_sto_detail","asn_sto.sto_number = asn_sto_detail.sto_number");
		$this->db->where("asn.asn_number",$asn_number);
		$this->db->group_by("asn.asn_number,lm_location.location,asn_sto.sto_number,asn_sto_detail.product_id");		
	
		$result = $this->db->get();		
		
		$date =  date("ymdHis");
		$loop = 0;		
		
		$wms_db->trans_start();

		foreach($result->result() as $row){
			$loop++;
			$to_location = $row->location;
			$username = $this->session->userdata('username');	
			$product_id = $row->product_id ;
			$sto_number = $row->sto_number;
			$unloaded_qty = $row->unloaded_quantity;
			$unique_id = $date.str_pad($loop,2,"0",STR_PAD_LEFT);
/*		Prem's SQL
		UPDATE ScanData SET DateScanned="yyyy-MM-dd HH:mm:ss",LocationFromID='R.DOCK',LocationToID="BayID", TempLocationID=User_id
		WHERE ScanType='R' AND DateScanned IS NULL AND ProductID="" AND USERID="" AND DocumentNo = ""
*/			
			$sql = "UPDATE TOP($unloaded_qty) ScanData
						SET DateScanned='$date_scanned',LocationFromID='$from_location',LocationToID='$to_location',TempLocationID='$username'
							WHERE ScanType='R' AND DateScanned IS NULL AND ProductID='$product_id' 
								AND USERID='$username' AND DocumentNo = '$sto_number'";
			$wms_db->query($sql);


/*		Prem's SQL
		INSERT INTO MS_Storage (UPC,Quantity,Date_In,MotherPO,MovementPO,Location,UniqueID,PutawayComplete,UserID) 
		VALUES ('',,"yyyy-MM-dd HH:mm:ss",'','R TO L','BayID','UniqueID','2','UserID')
*/			
			$sql = "INSERT INTO MS_Storage (UPC,Quantity,Date_In,MotherPO,MovementPO,Location,UniqueID,PutawayComplete,UserID) 
						VALUES ('$product_id',$unloaded_qty,'$date_scanned','$sto_number','$moment_PO','$to_location','$unique_id','2','$username')";

			$wms_db->query($sql);
//			echo $sql. ';<br/>';
/*		Prem's SQL
		UPDATE ScanData SET Dropped="",TempLocationID='BayID'
		WHERE ScanType='R' AND TempLocationID='UserID' AND ProductID='' AND USERID='' AND DocumentNo =''		
*/
			$sql = "UPDATE ScanData SET Dropped='$date_scanned',TempLocationID='$to_location'
						WHERE ScanType='R' AND TempLocationID='$username' AND ProductID='$product_id' AND USERID='$username' AND DocumentNo ='$sto_number'";
			$wms_db->query($sql);
			
		}
		
		$wms_db->trans_complete();
	}

	public function generate_wms_inventory_barcodes_for_new_arrivals($datetime='2015-10-19 00:00:00'){




		$wms_db = $this->load->database("gtl",true);
		$sql = "select location as Location,upc as UPC, sum(quantity) as Avl,0 as booked,
					0 as pallet_count,'' as stack_type,0 as location_id,0 as zone_id,'' as zone,max(date_in)as last_date from ms_storage
						where date_in >= '".$datetime."' AND location not in 
							(select distinct location from pick_face) AND len(location)=6 AND location not like ('BAY%')
								group by location,upc order by location,upc";
								die($sql);
		$result = $wms_db->query($sql );

		// print counter to identify the batch
			$batch_count = 0;
			$this->db->select("new_arrival_pallet_code_printer_count");
			$this->db->from("wms_parameters");
			$result_batch_count = $this->db->get();		
			if($result_batch_count->num_rows()>0){
				$batch_count = $result_batch_count->row()->new_arrival_pallet_code_printer_count;
				$batch_count = $batch_count + 1;
				$this->db->set("new_arrival_pallet_code_printer_count",$batch_count);
				$this->db->update("wms_parameters");
			}else{
				$batch_count = 1;
				$this->db->set("new_arrival_pallet_code_printer_count",$batch_count);
				$this->db->insert("wms_parameters");
			}
		
		$this->db->where("table","wms_parameters");
		$this->db->where("field_value",$batch_count);
		$this->db->where("transaction",$batch_count);
		$this->db->delete("pallet_barcode");		
		
		//
		
		foreach($result->result() as $row){
		// getting IDs for location IDs and last updated date of the location
			$this->db->select("*");
			$this->db->from("vw_location_map");
			$this->db->where("location",$row->Location);
			$result_location_ids = $this->db->get();

				if($result_location_ids->num_rows() > 0){
					$row->location_id = $result_location_ids->row()->location_id;		
					$row->zone_id = $result_location_ids->row()->zone_id;
					$row->zone = $result_location_ids->row()->zone;	
				}
		// getting stacking type
			$this->db->select("product_stack_norm.handling_quantity,product_stack_type.product_stack_type");
			$this->db->from("product_stack_norm");
			$this->db->join("product_stack_type","product_stack_type.product_stack_type_id = product_stack_norm.product_stack_type_id");
			$this->db->where("product_id",$row->UPC);
			$result_st = $this->db->get();
				if($result_st->num_rows() > 0){

					$row->stack_type = strtoupper(substr($result_st->row()->product_stack_type,0,1));	
					$row->pallet_count = ceil(($row->Avl+$row->booked)/$result_st->row()->handling_quantity);	
				}		
		


		}
		
		// generating actual barcodes;
		foreach($result->result() as $row){

				for($loop=0 ; $loop < ($row->pallet_count==0?1:$row->pallet_count) ;$loop++){
					
					$check_digit = 0;
					$barcode = $row->stack_type;
					$this->db->select_max('check_digit');
					$this->db->from('pallet_barcode');
					$this->db->where('date(datetime)', "date('".$row->last_date."')", false);
					$result_cd = $this->db->get();
						if ($result_cd->num_rows() > 0) $check_digit = $result_cd->row()->check_digit + 1;
	
					$barcode .= date("y",strtotime($row->last_date)) . date("m",strtotime($row->last_date)) . date("d",strtotime($row->last_date)) . 
								sprintf("%04d", $check_digit) . "0000";
					
					//echo $row->Location. " " .$row->UPC. " " .$barcode,"<br/>";
					
	
					
					$data = array("pallet_code" => $barcode, "wms_user" => "bo", "user_id" => 1, "check_digit" => $check_digit);
					
					$this->db->set('datetime', "'".$row->last_date."'", false);
					$this->db->set('transaction',$batch_count);
					$this->db->set('table', 'wms_parameters');
					$this->db->set('field', 'new_arrival_pallet_code_printer_count');
					$this->db->set('field_value', $batch_count);
					$this->db->set('product_id', $row->UPC);
					$this->db->set('quantity', $row->Avl+$row->booked);
					$this->db->set('zone_id', $row->zone_id);
					$this->db->set('location_id', $row->location_id);
	
					$this->db->insert("pallet_barcode", $data);


				}
				
				
		
		}
		
	}


	
	public function generate_wms_inventory_barcodes($sub_zone_group_id=0){
		
		$locations = array();
		
//		$this->db->select("location");
//		$this->db->from("vw_location_map");
//		$this->db->where("sub_zone_group_id",$sub_zone_group_id);		
		$sql = "SELECT * FROM vw_location_map WHERE sub_zone_group_id = ".$sub_zone_group_id." AND location_id NOT IN (SELECT location_id FROM lm_pick_face ORDER BY sub_zone ASC,location ASC)";
		
		$result = $this->db->query($sql);
			foreach($result->result() as $row){
				array_push($locations,$row->location);	
			}		
		
		
		
		if(sizeof($locations)>2){
			for($loop=1 ; $loop <= (sizeof($locations)-2);$loop++){
				$locations[$loop] = "'".$locations[$loop]."'";
			}
		}

		if(sizeof($locations)>1){
			$locations[0] = "'".$locations[0]."'";
			$locations[sizeof($locations)-1] = "'".$locations[sizeof($locations)-1]."'";
		}


		$wms_db = $this->load->database("gtl",true);
//		
//		$wms_db->select('*,0 as pallet_count,"" as stack_type,0 as location_id,0 as zone_id,"" as zone,"" as last_date');	
//		$wms_db->from("current_inventory");	
//		$wms_db->where_in("location", implode(",",$locations));	

		$sql = "SELECT *,0 as pallet_count,'' as stack_type,0 as location_id,0 as zone_id,'' as zone,'' as last_date 
					FROM current_inventory WHERE location IN (".implode(",",$locations).")";
		$result = $wms_db->query($sql);
		
		foreach($result->result() as $row){
		// getting IDs for location IDs and last updated date of the location
			$this->db->select("*");
			$this->db->from("vw_location_map");
			$this->db->where("location",$row->Location);
			$result_location_ids = $this->db->get();

				if($result_location_ids->num_rows() > 0){
					$row->location_id = $result_location_ids->row()->location_id;		
					$row->zone_id = $result_location_ids->row()->zone_id;
					$row->zone = $result_location_ids->row()->zone;	
				}
		// getting stacking type
			$this->db->select("product_stack_norm.handling_quantity,product_stack_type.product_stack_type");
			$this->db->from("product_stack_norm");
			$this->db->join("product_stack_type","product_stack_type.product_stack_type_id = product_stack_norm.product_stack_type_id");
			$this->db->where("product_id",$row->UPC);
			$result_st = $this->db->get();
				if($result_st->num_rows() > 0){

					$row->stack_type = strtoupper(substr($result_st->row()->product_stack_type,0,1));	
					$row->pallet_count = ceil(($row->Avl+$row->booked)/$result_st->row()->handling_quantity);	
				}		
		

			
		// last date of location activity	
			$wms_db->select("MAX(Date_IN) AS last_date");
			$wms_db->from("MS_Storage");
			$wms_db->where("location",$row->Location);
			$wms_db->where("UPC ",$row->UPC);
			$wms_db->where("Quantity >",0);
			$result_last_date = $wms_db->get();
				if($result_last_date->num_rows() > 0){
					$row->last_date = $result_last_date->row()->last_date;		
				}
		}
		
		// generating actual barcodes;
		foreach($result->result() as $row){
				$this->db->where("location_id",$row->location_id);
				$this->db->where("product_id",$row->UPC);
				$this->db->delete("pallet_barcode");
				
				for($loop=0 ; $loop < ($row->pallet_count==0?1:$row->pallet_count) ;$loop++){
					
					$check_digit = 0;
					$barcode = $row->stack_type;
					$this->db->select_max('check_digit');
					$this->db->from('pallet_barcode');
					$this->db->where('date(datetime)', "date('".date('Y-m-d',strtotime($row->last_date))."')", false);
					$result_cd = $this->db->get();
					//die($this->db->last_query());
						if ($result_cd->num_rows() > 0) $check_digit = $result_cd->row()->check_digit + 1;
	
					$barcode .= date("y",strtotime($row->last_date)) . date("m",strtotime($row->last_date)) . date("d",strtotime($row->last_date)) . 
								sprintf("%04d", $check_digit) . "0000";
					
					//echo $row->Location. " " .$row->UPC. " " .$barcode,"<br/>";
					
	
					
					$data = array("pallet_code" => $barcode, "wms_user" => "bo", "user_id" => 1, "check_digit" => $check_digit);
					
					$this->db->set('datetime', "'".date('Y-m-d H:m:i',strtotime($row->last_date))."'", false);
					$this->db->set('transaction', $sub_zone_group_id);
					$this->db->set('table', 'sub_zone_group');
					$this->db->set('field', 'sub_zone_group_id');
					$this->db->set('field_value', $sub_zone_group_id);
					$this->db->set('product_id', $row->UPC);
					$this->db->set('quantity', $row->Avl+$row->booked);
					$this->db->set('zone_id', $row->zone_id);
					$this->db->set('location_id', $row->location_id);
	
					$this->db->insert("pallet_barcode", $data);
//die($this->db->last_query());

				}
				
				
		
		}
		
	}
	
	public function clean_replenishments(){
		
	}
	
	public function sync_all_replenishments(){
		// get all locations to be replenished from WMS
		$wms_db = $this->load->database("gtl",true);
		$wms_db->select("*");	
		$wms_db->from("pick_face");	
		$result = $wms_db->get();		

		$pre_zone_id = 0;
		
		foreach($result->result() as $row){
			$data = array();

			$product_id = $row->product_id;
			$location = $row->location;
			$username = 'bo'; $user_id = 1 ; // these are temps
			$zone_id = $row->zone_id;
			$min_reorder_level = $row->min_reorder_level;
			
//			$quantity_required = ($row->pallet_count * $row->pps)-($row->pallet_count>1 ? $min_reorder_level:0);
// modified by bodara to prevent 0 required qty on 09-12-2015
			///$quantity_required = ($row->pallet_count * $row->pps);
// modified by bodara on request from Jeewana on 16-Mar-2015			
			//$quantity_required = ($row->pallet_count * $row->pps)-$min_reorder_level;
			$total_capacity = ($row->pallet_count * $row->pps);
			$quantity_required =  ($row->pallet_count>1 ? ($total_capacity/2):$row->pps);


			$sort_order = 0;
			$location_id = $row->location_id;
			
			// get current inventory for PID
			$inv_of_pid = 0;
			$wms_db->select("SUM(Avl) AS Avl, SUM(booked) AS booked");	
			$wms_db->from("current_inventory");	
			$wms_db->where("UPC",$product_id);	
			$wms_db->where("location <> ",$location);	
			
			$not_in_location = array('E22');
			$wms_db->where_not_in("location",$not_in_location);	
			
			$result_wms = $wms_db->get();
		
			if ($result_wms->num_rows()>0){
				$inv_of_pid = ($result_wms->row()->Avl==""?0:$result_wms->row()->Avl);
			}	
			
			// get current inventory for PID of the location
			$inv_of_pid_in_location = 0;
			$wms_db->select("SUM(Avl) AS Avl, SUM(booked) AS booked");	
			$wms_db->from("current_inventory");	
			$wms_db->where("UPC",$product_id);	
			$wms_db->where("location",$location);	

			$result_wms = $wms_db->get();
		
			if ($result_wms->num_rows()>0){
				$inv_of_pid_in_location = ($result_wms->row()->Avl==""?0:$result_wms->row()->Avl);
			}

			// get PPQ

			$ppq = 0;	

			$wms_db = $this->load->database("gtl",true);
			$wms_db->select("SUM(Quantity) AS quanity");		
			$wms_db->from("ScanData");	
			$wms_db->where("ScanType","B");	
			$wms_db->where("productid",$row->product_id);	
			$wms_result = $wms_db->get();			
			if($wms_result->num_rows()>0){
				$ppq = ($wms_result->row()->quanity==""?0:$wms_result->row()->quanity);		
			}
			//	echo $wms_db->last_query()."<br/>";

			// get pending replenishmets for the product and location
			$this->db->select("*");		
			$this->db->from("replenishment");	
			$this->db->where("product_id",$product_id);	
			$this->db->where("location",$location);	
			$this->db->where("location_id_replenished_from",0);				
			$result_d = $this->db->get();
			// echo $location." ".$product_id." ".$ppq." ".$inv_of_pid_in_location."<br/>";
			// if there is no replenishment for this pickface		
			if($result_d->num_rows()<=0){
				// check if the inventory is less than min-reorder level
				if($inv_of_pid_in_location <= $min_reorder_level){
					$data['datetime_created'] = date("Y-m-d h:i:s");
					$data['user_id_created'] =  $user_id;
					$data['location'] =  $location; 	
					$data['location_id'] =  $location_id; 
					$data['product_id'] =  $product_id; 
					$data['quantity_required'] =  $quantity_required; 
					$data['sort_order'] =  $sort_order; 
					$data['ppq'] =  $ppq; 
					$data['current_inventory'] =  $inv_of_pid ; 
					$data['current_inventory_in_location'] =  $inv_of_pid_in_location ; 
					$data['min_reorder_level'] =  $min_reorder_level ; 
					$this->db->insert('replenishment', $data); 
				}
			// when there is a replenishment
			}else{
				if($inv_of_pid_in_location > $min_reorder_level){
					$this->db->where("product_id",$product_id);	
					$this->db->where("location_id",$location_id);	
					$this->db->where("location_id_replenished_from",0);
					$this->db->delete('replenishment'); 	
				}else{
					$data = array('current_inventory' => $inv_of_pid,'quantity_required' => $quantity_required,
								  'current_inventory_in_location'=>$inv_of_pid_in_location,'min_reorder_level'=>$min_reorder_level);
					$this->db->where("product_id",$product_id);	
					$this->db->where("location_id",$location_id);	
					$this->db->where("location_id_replenished_from",0);		
					$this->db->update('replenishment', $data); 			
				}
			}
			// echo $this->db->last_query()."<br/>";
		}

	}
	
	public function sync_replenishments(){

	}


	public function get_lp_qty($lp_number='',$product_id=''){
		$wms_db = $this->load->database("gtl",true);
		$wms_db->select("*");		
		$wms_db->where("po_number",$lp_number);		
		$wms_db->where("UPC",$product_id);		
		$wms_db->from("MS_Order");	
		$result = $wms_db->get();		
		
		$ret_val = 0;

		foreach($result->result() as $row){
			$ret_val += $row->OrderQuantity;
		}
		
	
		return $ret_val;
	}
	
	public function get_unloaded_lp_lines($lp_number=''){
		$this->db->select("product_id");		
		$this->db->where("lp_number",$lp_number);	
		$this->db->where("direction","IN");		
		$this->db->from("vw_lp_load_detail");	
		$lps = $this->db->get();				
		$exclude = array('');
		
		foreach($lps->result() as $lp){
			array_push($exclude,$lp->product_id);		
		}
		
		$wms_db = $this->load->database("gtl",true);
		$wms_db->select("*");		
		$wms_db->where("po_number",$lp_number);		
		$wms_db->where_not_in("UPC",$exclude);		
		$wms_db->from("MS_PO_Detail");	
		$wms_lp = $wms_db->get();				
		
		return $wms_lp;
	}


	public function get_lp_info($lp_number=''){
		$wms_db = $this->load->database("gtl",true);
		$wms_db->select("*");		
		$wms_db->where("po_number",$lp_number);		
		$wms_db->from("MS_PO_Header");	
		$result = $wms_db->get();		
		
		if($result->num_rows()>0){
			$row = $result->row();
			$data['tmp_destination'] = 	$row->FCADestination;
			$data['tmp_datetime_created'] = $row->DateLastAmended;
			
			$this->db->where("lp_number",$lp_number);
			$this->db->update("lp",$data);
		}
	}
	
	public function get_last_inventory_imported_date(){
		$this->db->select("last_inventory_import");
		$this->db->from("wms_parameters");
		$query = $this->db->get();	
		if ($query->num_rows() == 1){
			$row = $query->row();
			$ret_val = $row->last_inventory_import;	   
		}else{
			$ret_val = "";	
		}
		return $ret_val;
	}
	
	
	public function import_inventory_from_wms($product_id=""){
			$wms_db = $this->load->database("gtl",true);
			$wms_db->select("UPC,Location,Avl,booked,Scanned");
		
			if($product_id!="") $wms_db->where("UPC",$product_id);
			
			$wms_db->from("current_inventory");
			$query = $wms_db->get();
			
			if($product_id==""){
				$this->db->empty_table('location_inventory');
			}else{
				$this->db->where('product_id',$product_id);	
				$this->db->delete('location_inventory');	
			}
			
			
			foreach($query->result() as $record){
				$data = array();
				$data['product_id'] = $record->UPC;
				$data['customer_id'] = 1;
				$data['wms_location'] = $record->Location;
				$data['quantity'] = $record->Avl + $record->booked - $record->Scanned;
				$data['booked'] = $record->booked;
				$data['scanned'] = $record->Scanned;
				$this->db->insert('location_inventory',$data);
			}
	
		// map wms locations
			$sql = "UPDATE location_inventory Inner Join lm_location ON lm_location.location = location_inventory.wms_location
						SET location_inventory.location_id = lm_location.location_id";
			$this->db->query($sql);
			
		if($product_id==""){			
		// update wms inventory importation info
			$sql = "UPDATE wms_parameters SET last_inventory_import = NOW()";
			$this->db->query($sql);
		}else{
		// line level updated date time			
			$sql = "UPDATE location_inventory SET last_inventory_import = NOW()WHERE product_id='$product_id'";
			$this->db->query($sql);			
		}

	}

	
}

