<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->ci =& get_instance();
$this->ci->load->database();


/* SYSTEM MODULES */
$query = $this->ci->db->get('sys_module');

foreach ($query->result() as $row)
{
    define($row->module_const,$row->module_id);
}

/* STATUSES */
$query = $this->ci->db->get('status');

foreach ($query->result() as $row)
{
    define($row->status_const,$row->status_id);
}


/* SYSTEM DEFAULTS */
/* COMPANY DEFAULTS ?????*/
$query = $this->ci->db->get('sys_default');

foreach ($query->result() as $row)
{
    define($row->sys_default_const,$row->sys_default_value);
}



/* SYSTEM USER GROUPS */
define("SYS_ROOT_GROUP",1);
define("SYS_ADMIN_GROUP",2);
define("ADMIN_USER_GROUP",3);
		