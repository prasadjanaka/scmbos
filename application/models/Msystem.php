<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msystem extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }
	
	public function get_all($table) {
		return $this->db->get($table);
	}
	
	public function get_all_order($table, $order) {
		$this->db->order_by($order);
		return $this->db->get($table);
	}
	
	public function get_where($column, $table, $common, $id) {
		$this->db->select($column);
		$this->db->from($table);
		$this->db->where($common, $id);
		return $this->db->get();
	}
	
	public function get_where_2($column, $table, $common, $id, $common_2, $id_2) {
		$this->db->select($column);
		$this->db->from($table);
		$this->db->where($common, $id);
		$this->db->where($common_2, $id_2);
		return $this->db->get();
	}
	
	public function delete_where ($table, $column, $value) {
		$this->db->where($column, $value);
		$this->db->delete($table);
	}
	
	public function insert ($table, $data) {
		$this->db->insert($table, $data);
	}
	
	public function update ($column, $id, $table, $data) {
		$this->db->where($column, $id);
		$this->db->update($table, $data);
	}
	
	public function mike_delta_5 ($password) {
		$this->db->select('MD5("'.$password.'")"password";');
		return $this->db->get();
	}
	
}