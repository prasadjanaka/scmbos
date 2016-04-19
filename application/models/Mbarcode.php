<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mbarcode extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_pallet_number($transaction,$table) {
        $this->db->select("pallet_barcode.*,lm_location.location,product_stack_norm.pps,product_stack_norm.handling_quantity");
        $this->db->from('pallet_barcode');
		$this->db->join("lm_location","lm_location.location_id = pallet_barcode.location_id","left outer");
		$this->db->join("product_stack_norm","product_stack_norm.product_id = pallet_barcode.product_id","left outer");
        $this->db->where("transaction",$transaction);
		$this->db->where("table",$table);
		$this->db->order_by("location");
        $query = $this->db->get();
	
        return $query->result();
    }

}
?>