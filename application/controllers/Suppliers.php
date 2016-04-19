<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Msuppliers');
	}
	
// Suppliers
	public function suppliers () {
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		$supplier_data['query']	= $this->Msuppliers->get_suppliers();
		$this->load->view('suppliers', $supplier_data);
		
		$this->load->view('html_footer');
	}
	
// Edit supplier
	public function new_supplier () {
		$edit		= $_GET['edit'];
		$new_data['edit']	= $edit;
		
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');

		//Emptying all fields
		$new_data['supplier_type_id']	= '';
		$new_data['supplier']			= '';
		$new_data['contact_number']		= '';
		$new_data['contact_person']		= '';
		$new_data['address']			= '';
		$new_data['email']				= '';
		$new_data['fax_number']			= '';
		$new_data['credit_period']		= '';
		$new_data['payment_term_id']	= '';
		
		$query_supplier	= $this->Msuppliers->get_supplier($edit);
		$query_type		= $this->Msuppliers->get_all("sp_supplier_type");
		$query_term		= $this->Msuppliers->get_all("sp_payment_term");
		
		$new_data['query_type']	= $query_type;
		$new_data['query_term']	= $query_term;
		
		//if supplier already exits...
		if($edit!=0) {
			$sup = $query_supplier->row();
			
			$new_data['supplier_type']	= $sup->supplier_type;
			$new_data['supplier']		= $sup->supplier;
			$new_data['contact_number']	= $sup->contact_number;
			$new_data['contact_person']	= $sup->contact_person;
			$new_data['address']		= $sup->address;
			$new_data['email']			= $sup->email;
			$new_data['fax_number']		= $sup->fax_number;
			$new_data['credit_period']	= $sup->credit_period;
			$new_data['payment_term']	= $sup->payment_term;
		}
		$this->load->view('new_supplier', $new_data);
		$this->load->view('html_footer');
	}
	
// Save supplier
	public function save_supplier () {
		$edit	= $_POST['edit'];
		
		$save_data['supplier_type_id']	= $_POST['supplier_type_id'];
		$save_data['supplier']			= $_POST['supplier'];
		$save_data['contact_number']	= $_POST['contact_number'];
		$save_data['contact_person']	= $_POST['contact_person'];
		$save_data['address']			= $_POST['address'];
		$save_data['email']				= $_POST['email'];
		$save_data['fax_number']		= $_POST['fax_number'];
		$save_data['credit_period']		= $_POST['credit_period'];
		$save_data['payment_term_id']	= $_POST['payment_term_id'];
		if($edit != 0) {
			$this->Msuppliers->update_supplier($edit, 'sp_supplier', $save_data);
		} else {
			$this->Msuppliers->add_supplier('sp_supplier', $save_data);
		}
		
		$this->suppliers();
	}
}