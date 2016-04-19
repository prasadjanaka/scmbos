<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gtlsystem extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->gtl_db = $this->load->database('gtl_db',TRUE);
	}

	public function get_all($table) {
		$this->gtl_db->select("*");
		$this->gtl_db->from($table);
		return $this->gtl_db->get();
	}
	
	public function get_date_row($column, $table, $common, $id) {
		$this->gtl_db->select($column);
		$this->gtl_db->from($table);
		$this->gtl_db->where($common." BETWEEN '".$id."' AND '".$id." 23:59:59'");
		return $this->gtl_db->get();
	}
	
	public function insert ($table, $data) {
		$this->gtl_db->insert($table, $data);
	}
	
	public function update ($column, $id, $table, $data) {
		$this->gtl_db->where($column, $id);
		$this->gtl_db->update($table, $data);
	}

}