<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/mlogin');
		$this->load->model('it/Mit_inventory');
		$this->load->model('user/mlogin');
	}	
	
	public function index()
	{

		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');
		
		if($this->mlogin->get_permission(SYS_MAIN_DASHBOARD)){
			//$this->load->view('dashboard');
			$this->load->view('dashboard_old');
		}else{
			$this->load->view('no_permission');	
		}
		$this->load->view('html_footer');
	}
	
	public function header(){
		$this->load->view('html_header');
		$this->load->view('header_menu');
		$this->load->view('main_left_menu');
		
		
		$this->load->view('dashboard');
		$this->load->view('html_footer');
	}
	public function it_inventory(){
		
		$this->load->view('html_header');
		$this->load->view('main_header_menu');
		$this->load->view('main_left_menu');	
	
		if($this->mlogin->get_permission(IT_INVENTORY)){
			$return['department_list']=$this->Mit_inventory->list_department();
			$return['device_list']=$this->Mit_inventory->list_device();	
			$this->load->view('it/it_inventory',$return);
		}else{
			$this->load->view('no_permission');	
		}
		$this->load->view('html_footer');
		
		
	}	

}
