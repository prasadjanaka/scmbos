<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Colombo");
class Memailler extends CI_Model {

    function __construct() {
        parent::__construct();

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.gsllanka.lk',
			'smtp_port' => 587,
			'smtp_user' => 'noreply@gsllanka.lk',
			'smtp_pass' => 'NoReply365',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
		);		
		$this->load->library('email', $config);			
    }


	public function send_mail($to,$cc,$subject,$body,$reply_to,$reply_to_name){
		$this->email->from("noreply@gsllanka.lk",$reply_to_name);
		$this->email->to($to);
		$this->email->cc($cc);
		$this->email->reply_to($reply_to,$reply_to_name);
		$this->email->subject($subject);
		$this->email->message($body);
		if (!$this->email->send()){
				echo $this->email->print_debugger();	
				die();	
		}
	}
	

	
	
	
}
