<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mtransport extends CI_Model {
    function __construct()
    {
        parent::__construct();
		$this->load->model('user/mlogin');
		$this->load->model('emailler/memailler');
    }
	public $error_code = "";
	public $error_desc = "";
	public $container_request_id = 0;
	
	public function new_container_request($data){
		if($this->add_new_request_container($data)){
			return $this->send_container_request_to_forwarder($data);
		}else{
			return false;
		}	
	}
	
	public function re_send_container_request_to_forwarder(){
		$this->send_container_request_to_forwarder();
	}
	
	

	public function get_container_request($where=NULL){

		$this->db->select('container_request.*,container_size.container_size');
		$this->db->from('container_request');
		$this->db->join('container_size','container_size.container_size_id = container_request.container_size_id');	
		if(is_string($where)) $this->db->where($where); 
		if(is_array($where)) $this->db->where($where); 
	
		$result = $this->db->get();

		return $result;
	}


	public function send_container_request_to_forwarder(){
		$ret_val = true;
		$body = file_get_contents("templates/lp/container_request.html");
		$cr = $this->get_container_request("container_request_id = ".$this->container_request_id);
		if($cr->num_rows()>0){
			$cr = $cr->row();
			$body = str_replace("#forward_name#",$cr->forward_name,$body);
			$body = str_replace("#message#",nl2br($cr->message),$body);
			$body = str_replace("#ref#",$cr->ref,$body);
			$body = str_replace("#container_size#",$cr->container_size,$body);
			$body = str_replace("#expected_datetime#",$cr->expected_datetime,$body);
			$body = str_replace("#name#",$cr->name,$body);
			
			
			$to = $cr->forward_email;
			$cc = array();
			$subject = "New container request";
			$this->memailler->send_mail($to,$cc,$subject,$body,$cr->email,$cr->name);	
			
			$status_id = LP_SEND_EMAIL_TO_FORWARDER;
				$history = array('status_id' => $status_id,'ref_type' => 'lp','ref' => $cr->ref,
									 'field' => 'lp_number','field_id' => $cr->ref,'text' => 'Lp Send Email to Forwarder');
				$this->mlogin->write_history($history);
						
		}else{
			$ret_val = false;
			$this->error_code = "MTRNS_SENDEMAIL";	
			$this->error_desc = "Sorry No Records found to send email";				
		}
		return $ret_val;
	}
	
	
	private function add_new_request_container($data){
		$ret_val = true;
		/* data variables 
			`container_request_id` int(11) NOT NULL AUTO_INCREMENT,
			`user_id` int(11) NOT NULL,
			`email` varchar(200) DEFAULT NULL,
			`name` varchar(150) DEFAULT NULL,
			`ref_type` varchar(20) DEFAULT NULL,
			`ref` varchar(25) DEFAULT NULL,
			`forward_id` int(11) NOT NULL,
			`forward_email` varchar(200) DEFAULT NULL,
			`forward_name` varchar(150) DEFAULT NULL,
			`expected_datetime` datetime DEFAULT NULL,
			`container_size_id` int(11) NOT NULL,
			`message` varchar(255) DEFAULT NULL,		
		*/
		
		// validate data variable here
		$user_id = $this->session->userdata('user_id');	
		if ($user_id == ""){
			$ret_val = false;
			$this->error_code = "MTRNS_RC_001";	
			$this->error_desc = "Invalid user_id";	
		}else{
			$data['user_id'] = $user_id;
		}

		if ($data["email"] == ""){
			$ret_val = false;
			$this->error_code = "MTRNS_RC_002";	
			$this->error_desc = "Invalid email";	
		}

		if($ret_val==true) {
			$this->db->insert('container_request',$data);
			$this->container_request_id = $this->db->insert_id();
			$this->error_code = "";	
			$this->error_desc = "";				
		}
		
		return $ret_val;
	}

}
