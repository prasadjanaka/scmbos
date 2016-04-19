<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msuppliers extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
	
	public function get_all ($table) {
		$this->db->select("*");
		$this->db->from($table);
		return $this->db->get();
	}

	public function get_suppliers () {
		$this->db->select("*");
		$this->db->from("vw_supplier");
		$this->db->order_by	("supplier_id");
		return $this->db->get();
	}
	
	public function get_supplier ($edit) {
		$this->db->select	("*");
		$this->db->from		("vw_supplier");
		$this->db->where	("supplier_id = $edit");
		return $this->db->get();
	}
	
	public function add_supplier ($table, $data) {
		$this->db->insert($table, $data);
	}
	
	public function update_supplier ($id, $table, $data) {
		$this->db->where	('supplier_id', $id);
		$this->db->update	($table, $data);
	}

}
?>