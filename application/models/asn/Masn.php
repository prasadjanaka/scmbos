<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Masn extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('user/mlogin');
         $this->load->model('asn/masn');
    }

    public function generate_asn_barcodes($asn_number = '') {
        $this->db->trans_start();
        $this->db->select('*');
        $this->db->from('vw_asn_barcode');
        $this->db->where('asn_number', $asn_number);
        //$this->db->where('full_stack >', 0);
        $result = $this->db->get();

        $this->db->where('transaction', $asn_number);
        $this->db->where('table', 'asn_barcode');
        $this->db->delete('pallet_barcode');

		$has_no_hqs  = false;
		
		foreach ($result->result() as $row) {
			if($row->handling_quantity==0) $has_no_hqs = true;
		}
		
		if($has_no_hqs){
			return false;
		}else{
			foreach ($result->result() as $row) {
				$pallet_count = $row->full_stack + $row->part_stack;
				$pallet_count = ($pallet_count==""?0:$pallet_count);
				
				for ($loop = 1; $loop <= $pallet_count; $loop++) {
					
					$rq = 0;
					if($loop < $pallet_count){ 
						$rq = $row->handling_quantity;
					}else{
						if($row->part_stack_quantity>0) 
							$rq = $row->part_stack_quantity;
						else
							$rq = $row->handling_quantity;
					}
					
	
					$check_digit = 1;
					$barcode = strtoupper(substr($row->product_stack_type,0,1));
					$this->db->select_max('check_digit');
					$this->db->from('pallet_barcode');
					$this->db->where('date(datetime)', 'date(NOW())', false);
					$result_cd = $this->db->get();
	
					if ($result_cd->num_rows() > 0)
						$check_digit = $result_cd->row()->check_digit + 1;
	
					$barcode .= date("y") . date("m") . date("d") . sprintf("%04d", $check_digit) . "0000";
	
					$data = array("pallet_code" => $barcode, "wms_user" => "bo", "user_id" => 1, "check_digit" => $check_digit);
					$this->db->set('datetime', 'NOW()', false);
					$this->db->set('table', 'asn_barcode');
					$this->db->set('field', 'asn_barcode_id');
					$this->db->set('field_value', $row->asn_barcode_id);
					$this->db->set('transaction', $asn_number);
					$this->db->set('product_id', $row->product_id);
					$this->db->set('quantity', $rq);
					$this->db->set('zone_id', $row->zone_id);
	
					$this->db->insert("pallet_barcode", $data);
	
					$data = array("status_id" => ASN_BARCODE_GENERATED);
					$this->db->where("asn_number", $asn_number);
					$this->db->update("asn", $data);
				}
			}
			$this->db->trans_complete();
			return true;			
		}

    }

    public function get_asn_barcode_summary($asn_number) {
        $this->db->where('asn_number', $asn_number);
        $this->db->select('*');
        $this->db->from('vw_asn_barcode_summary');

        return $this->db->get();
    }

    public function get_asn_barcode($asn_number) {
        $this->db->where('asn_number', $asn_number);
        $this->db->select('*');
        $this->db->from('vw_asn_barcode');

		//$get_asn_barcode = $this->db->get();
                //return $get_asn_barcode->result();
				//$this->db->get();
				//die($this->db->last_query());
        return $this->db->get();
    }

    public function sto_delete($sto_number) {
        $this->db->where('sto_number', $sto_number);
        $this->db->from('vw_asn_sto_detail');
        $sto_details = $this->db->get();
        foreach ($sto_details->result() as $sto_detail) {
            $this->db->select('*');
            $this->db->where('asn_number', $sto_detail->asn_number);
            $this->db->where('product_id', $sto_detail->product_id);
            $this->db->from('asn_barcode');
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                $barcode_quantity = $result->row()->quantity;
                $balance = abs($barcode_quantity - $sto_detail->quantity);
                if ($balance == 0) {
                    $this->db->where('asn_barcode_id', $result->row()->asn_barcode_id);
                    $this->db->delete('asn_barcode');
                } else {
                    $data_tmp = array("quantity" => $balance);

                    $this->db->where('asn_barcode_id', $result->row()->asn_barcode_id);
                    $this->db->update('asn_barcode', $data_tmp);
                }
            }
        }

        $this->db->where('sto_number', $sto_number);
        $this->db->delete('asn_sto_detail');

        $this->db->where('sto_number', $sto_number);
        $this->db->delete('asn_sto');
    }

    public function add_sto($data) {
        $this->db->where('sto_number', $data['sto_number']);
        $this->db->delete('asn_sto_detail');

        $this->db->select('*');
        $this->db->where('sto_number', $data['sto_number']);
        $this->db->from('asn_sto');
		$result = $this->db->get();
        if ($result->num_rows() <= 0) {
            $this->db->set('sto_number', $data['sto_number']);
            $this->db->set('asn_number', $data['asn_number']);
            $this->db->set('plant_code', $data['plant_code']);
			if (array_key_exists("xml_file",$data)) $this->db->set('xml_file', $data['xml_file']);

            $this->db->set('datetime_post', 'NOW()', FALSE);
            $this->db->insert('asn_sto');
        }else{
			$amendment = 0;
			$amendment = ($result->row()->amendment + 1);
            $this->db->set('amendment', $amendment);
			$this->db->set('plant_code', $data['plant_code']);
			if (array_key_exists("xml_file",$data)) $this->db->set('xml_file', $data['xml_file']);
            $this->db->set('datetime_post', 'NOW()', FALSE);
			$this->db->where('sto_number', $data['sto_number']);
            $this->db->update('asn_sto');				
		}
    }

    public function add_sto_detail($data) {
        $this->db->select('*');
        $this->db->where('sto_number', $data['sto_number']);
        $this->db->where('product_id', $data['product_id']);
        $this->db->where('po_number', $data['po_number']);
        $this->db->from('asn_sto_detail');
		$result = $this->db->get();
        if ($result->num_rows() <= 0) {
            $this->db->set('sto_number', $data['sto_number']);
            $this->db->set('product_id', $data['product_id']);
            $this->db->set('quantity', $data['quantity']);
            $this->db->set('po_number', $data['po_number']);
            $this->db->set('item_number', $data['item_number']);
            $this->db->set('material_doc_item', $data['material_doc_item']);
			if (array_key_exists("xml_file",$data)) $this->db->set('xml_file', $data['xml_file']);
			if (array_key_exists("sap_asn_number",$data)) $this->db->set('sap_asn_number', $data['sap_asn_number']);			
			
            $this->db->insert('asn_sto_detail');

        }else{
			$cur_quantity = $result->row()->quantity;
			$sto_detail_id = $result->row()->sto_detail_id;
	
			$data_tmp = array("quantity" => ($data['quantity'] + $cur_quantity));		
			if (array_key_exists("xml_file",$data)) $this->db->set('xml_file', $data['xml_file']);
			
			$this->db->where('sto_detail_id', $sto_detail_id);
            $this->db->update('asn_sto_detail', $data_tmp);		
			
		}


    }

	public function populate_asn_barcode($asn_number=""){

		$this->db->where('asn_number', $asn_number);
		$this->db->delete('asn_barcode');

		$this->db->select('product_id');
		$this->db->select('SUM(asn_sto_detail.quantity) AS quantity');
		$this->db->where('asn_number', $asn_number);
		$this->db->group_by('product_id');
		$this->db->from('asn_sto');
		$this->db->join('asn_sto_detail','asn_sto.sto_number = asn_sto_detail.sto_number');
				
		$result = $this->db->get();
		foreach($result->result() as $row){
			$this->db->set('asn_number', $asn_number);
			$this->db->set('product_id', $row->product_id);
			$this->db->set('quantity', $row->quantity);
			$this->db->insert('asn_barcode');				
		}
	
	}

    public function get_sto_master($sto_number) {
        $this->db->where('sto_number', $sto_number);
        $this->db->select('*');
        $this->db->from('vw_asn_sto');

        return $this->db->get();
    }

    public function get_sto_detail($data) {
        if ($data["asn_number"] != "")
            $this->db->where('asn_number', $data["asn_number"]);
        $this->db->select('*');
        $this->db->from('vw_asn_sto_detail');

        return $this->db->get();
    }

    public function get_sto_list($data) {
        if ($data["asn_number"] != "")
            $this->db->where('asn_number', $data["asn_number"]);
        $this->db->select('*');
        $this->db->from('vw_asn_sto');

        return $this->db->get();
    }

    public function get_asn($data) {
        if ($data["asn_number"] != "")
            $this->db->where('asn_number', $data["asn_number"]);
        $this->db->select('*');
        $this->db->from('vw_asn');

        return $this->db->get();
    }

    public function get_asn_list($data) {
        if ($data["asn_type_id"] > 0)
            $this->db->where('asn_type_id', $data["asn_type_id"]);
        if ($data["top"] > 0)
            $this->db->limit($data["top"]);

        $this->db->select('*,"" as sto_numbers');
        $this->db->from('vw_asn');
        $result = $this->db->get();
        foreach ($result->result() as $row) {
            if ($row->sto_count > 0) {
                $this->db->select('*');
                $this->db->from('asn_sto');
                $this->db->where('asn_number', $row->asn_number);
                $result_stos = $this->db->get();
                foreach ($result_stos->result() as $sto) {
                    $row->sto_numbers .= $sto->sto_number . ", ";
                }
                $row->sto_numbers = substr($row->sto_numbers, 0, strlen($row->sto_numbers) - 2);
            }
        }

        return $result;
    }

    public function add_asn($asn_type_id = 1) {
        $asn_number = date("Ymd");
        $this->db->select('*');
        $this->db->from('asn');
        $this->db->where('date(datetime_created)', date("Y-m-d"));
        $result = $this->db->get();
        $asn_count = $result->num_rows() + 1;
        $asn_number .= str_pad($asn_count, 4, "0", STR_PAD_LEFT);

        $this->db->set('asn_type_id', $asn_type_id);
        $this->db->set('user_id_created', $this->session->userdata("user_id"));
        $this->db->set('asn_number', $asn_number);
        $this->db->set('status_id', ASN_NEW);
        $this->db->set('datetime_created', 'NOW()', FALSE);
        $this->db->insert('asn');


        return $asn_number;
    }

    public function update_vehicle_information($data_vehicle) {
 		$this->db->set('asn_number',$data_vehicle['asn_number']);
		$this->db->set('vehicle_number', $data_vehicle['vehicle_number']);
		$this->db->set('contact_person', $data_vehicle['contact_person']);
		$this->db->set('phone', $data_vehicle['phone_number']);
		$this->db->set('container_number', $data_vehicle['container_number']);
		$this->db->set('container_size_id', $data_vehicle['container_size']);
		$this->db->where	('asn_number', $data_vehicle['asn_number']);
		$this->db->update('asn');
    }
	
    public function get_container_size(){
        $this->db->select("*");
		$this->db->from("container_size");
		$container_info = $this->db->get();
        return $container_info->result();
		
    }
	
    public function change_asn_status($data) {
 		$this->db->set('status_id',$data['status_id']);
		$this->db->where('asn_number', $data['asn_number']);
		$this->db->update('asn');
    }
	
	public function allocate_unloaded_quantity_to_sto($asn_number){
		$sql = "UPDATE asn_sto Inner Join asn_sto_detail ON asn_sto.sto_number = asn_sto_detail.sto_number
					SET asn_sto_detail.unloaded_quantity = 0 WHERE asn_sto.asn_number='".$asn_number."'";
		$this->db->query($sql);

        $this->db->select("asn_unload.asn_number,asn_unload.product_id,asn_unload.user_id,SUM(asn_unload.quantity) AS quantity");
		$this->db->from("asn_unload");
		$this->db->where("asn_number",$asn_number);
		$this->db->group_by("asn_unload.asn_number,asn_unload.product_id,asn_unload.user_id");
		
		$asn_unlods = $this->db->get();
		
		foreach ($asn_unlods->result() as $asn_unlod) {
			$product_id = $asn_unlod->product_id;
			$total_unloaded_qty = $asn_unlod->quantity;
			$balance = $total_unloaded_qty;
	        $this->db->select("asn_sto.asn_number,asn_sto_detail.product_id,asn_sto.sto_number,asn_sto_detail.quantity,asn_sto_detail.sto_detail_id");
			$this->db->from("asn_sto");
			$this->db->join("asn_sto_detail","asn_sto.sto_number = asn_sto_detail.sto_number");
			$this->db->where("asn_sto.asn_number",$asn_number);
			$this->db->where("asn_sto_detail.product_id",$product_id);
			$this->db->order_by("asn_sto_detail.product_id ASC, asn_sto_detail.sto_number ASC, asn_sto_detail.quantity DESC");
			$sto_unlods = $this->db->get();
			foreach ($sto_unlods->result() as $sto_unlod) {
				$unloaded_qty = 0;
				$balance = ($balance < 0?0:$balance);
				if($balance >= $sto_unlod->quantity){
					$unloaded_qty = ($sto_unlod->quantity <= 0?$balance:$sto_unlod->quantity );
				}else{
					$unloaded_qty = $balance;	
				}
				$balance = 	$balance - $unloaded_qty;				
				$this->db->set('unloaded_quantity', $unloaded_qty);
				$this->db->where('sto_detail_id', $sto_unlod->sto_detail_id);
				$this->db->update('asn_sto_detail');				
			}
		}
	}
	
	 public function get_asn_history($asn_number){
		 $this->db->select("*");
		 $this->db->from("vw_history_list");
		 $this->db->where("ref_type","ASN");
		 $this->db->where("ref",$asn_number);
		 $this->db->order_by("datetime","DESC");
		 $result = $this->db->get();
		 return $result->result();
	 }
	
	public function get_asn_exception($asn_number){
		 $this->db->select("asn_unload_exception.product_id,product.description,asn_unload_exception.quantity");
		 $this->db->from("asn_unload_exception");
		 $this->db->join("product","product.product_id = asn_unload_exception.product_id");
		 $this->db->where("asn_unload_exception.asn_number",$asn_number);
		 $result = $this->db->get();
		 return $result;
	}
	public function list_shuttles($limit){
		 if ($limit > 0)
          	$this->db->limit($limit);
			$this->db->select('*');
			$this->db->from('shuttle');
			$query=$this->db->get();
			return $query->result();
	}
	public function save_schedule_date($data,$id){
	
		$this->db->where('shuttle_number',$id);			
		$this->db->update('shuttle',$data); 	
		//return "Updated";
	}
	
	public function shuttle_details($shuttle_number){
		
			$this->db->select ('*');
			$this->db->from('shuttle');	
			$this->db->where('shuttle_number',$shuttle_number);
			return $this->db->get();
	
	}

	public function shuttle_product_details($shuttle_number){
		$this->db->select ('*');
		$this->db->from('vw_shuttle');	
		$this->db->where('shuttle_number',$shuttle_number);
		return $this->db->get();
	
	}	
	
	public function shuttle_history($shuttle_number){
		$this->db->select('*');
		$this->db->where('ref',$shuttle_number);
		$this->db->where('ref_type','shuttle');
		$this->db->from('vw_history_list'); 
		$this->db->order_by("datetime","DESC");
		return $this->db->get();
	}
	public function get_vw_asn($data){
		$this->db->select('*');
		$this->db->from('vw_asn');
		$this->db->where('asn_number',$data);
		return $this->db->get();
	}
	
	
}
