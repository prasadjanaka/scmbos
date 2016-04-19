<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sap extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('interfaces/msap');
		$this->load->model('common/mcommon');
	}	
	
	public function import_inventory()
	{
		$this->msap->import_inventory();

	}
	
	public function download_data_files_from_ftp_server(){
		//$this->msap->download_a_folder("BillOfMaterials");
		//$this->msap->import_material_masters();
		
	}


	public function import_loading_proposal(){
		$this->msap->import_loading_proposal();
	}
		
	public function import_material_masters(){
		$this->msap->import_material_masters();
	}	
	
	public function import_material_boms(){
		$this->msap->import_material_boms();	
	}
	
	public function import_goods_issue(){
		$this->msap->import_goods_issue();
	
	}

}
