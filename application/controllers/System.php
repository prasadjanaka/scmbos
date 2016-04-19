<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class System extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/Mlogin');
        $this->load->model('Msystem');  // MySQL
        //$this->load->model('Gtlsystem');	// ODBC (MS SQL)
    }

// User list
    public function user_list($banner = "") {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        $user_list_data['banner'] = $banner;

        // permission
        if ($this->Mlogin->get_permission(USR_USER_VIEW)) {
            $user_list_data['list_query'] = $this->Msystem->get_all_order("vw_sys_user", "username");
            $this->load->view('user_list', $user_list_data);
        } else {
            $this->load->view('no_permission');
        }

        $this->load->view('html_footer');
    }

    // User (edit)
    public function user() {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        $user_id = $_GET['user_id'];
        $user_data['user_id'] = $user_id;

        // edit
        $user_data['user_group_query'] = $this->Msystem->get_all("sys_user_group");
        $user_data['zone_query'] = $this->Msystem->get_all("lm_zone");

        $user_data['username'] = "";
//		$user_data['password']		= "";
        $user_data['user_group_id'] = "";
        $user_data['epf_number'] = "";
        $user_data['customer_id'] = "0";
        $user_data['status_id'] = "1";
        $user_data['name'] = "";
        $user_data['zone_id'] = "";

        if ($user_id != 0) {
            if ($this->Mlogin->get_permission(USR_USER_EDIT)) {
                $user_query = $this->Msystem->get_where("*", "sys_user", "user_id", $user_id);
                $user_record = $user_query->row();

                $user_data['status_id'] = $user_record->status_id;
                $user_data['username'] = $user_record->username;
//				$user_data['password']		= $user_record->password;
                $user_data['user_group_id'] = $user_record->user_group_id;
                $user_data['epf_number'] = $user_record->epf_number;
                $user_data['customer_id'] = $user_record->customer_id;
                $user_data['name'] = $user_record->name;
                $user_data['zone_id'] = $user_record->zone_id;

                $this->load->view('user', $user_data);
            } else {
                $this->load->view('no_permission');
            }
        } else {
            if ($this->Mlogin->get_permission(USR_USER_ADD)) {
                $this->load->view('user', $user_data);
            } else {
                $this->load->view('no_permission');
            }
        }
        $this->load->view('html_footer');
    }

    //save user
    public function save_user() {
        $user_id = $_POST['user_id'];

        $save_user_data['username'] = $_POST['username'];
        $save_user_data['user_group_id'] = $_POST['user_group_id'];
        $save_user_data['epf_number'] = $_POST['epf_number'];
        $save_user_data['customer_id'] = $_POST['customer_id'];
        $save_user_data['status_id'] = $_POST['status_id'];
        $save_user_data['name'] = $_POST['name'];
        $save_user_data['zone_id'] = $_POST['zone_id'];

//		$user_query	= $this->Msystem->get_where("user_id", "sys_user", "username", $save_user_data['username']);

        if ($user_id != 0) {
            $this->Msystem->update('user_id', $user_id, 'sys_user', $save_user_data);
            $banner = "edit";
        } else {
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $user_query = $this->Msystem->get_where("user_id", "sys_user", "username", $save_user_data['username']);
            if ($user_query->num_rows() == 0) {
                if ($password == $password_confirm) {
//					$query = $this->Msystem->mike_delta_5($password);
//					$row = $query->row();
                    $encryption = md5($password);
                    $save_user_data['password'] = $encryption; //$row->password;

                    $this->Msystem->insert("sys_user", $save_user_data);
                    $banner = "add";
                } else {
                    $banner = "no_match";
                }
            } else {
                $banner = "exist";
            }
        }
        // $banner_data['banner']	= $banner;
        $this->user_list($banner);
    }

// User group list
    public function user_group_list($group_added = FALSE) {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        $group_data['group_added'] = $group_added;
        // permission
        if ($this->Mlogin->get_permission(USR_USER_GROUP_VIEW)) {
            $group_data['query'] = $this->Msystem->get_all_order("vw_user_count_group", "user_group");
            $this->load->view('user_group_list', $group_data);
        } else {
            $this->load->view('no_permission');
        }

        $this->load->view('html_footer');
    }

    // Set permission
    public function user_group() {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');
        // permission
        if ($this->Mlogin->get_permission(USR_USER_GROUP_SET_PERMISSION)) {
            $edit = $_GET['edit'];
            $new_data['edit'] = $edit;

            $new_data['user_group_name'] = $this->Msystem->get_where("user_group", "sys_user_group", "user_group_id", $edit);
            $new_data['query_parent'] = $this->Msystem->get_where("module, module_id, parent_module_id", "sys_module", "parent_module_id", "0");
            $new_data['query_module'] = $this->Msystem->get_all("sys_module");
            $new_data['query_check'] = $this->Msystem->get_where("module, module_id", "vw_user_group_module", "user_group_id", $edit);

            $this->load->view('user_group', $new_data);
        } else {
            $this->load->view('no_permission');
        }

        $this->load->view('html_footer');
    }

    // Save user group
    public function save_user_group() {
        // permission
        $group_id = $_POST['edit'];
        $group_name = $_POST['user_group_name'];
        $prev_group_name = $_POST['prev_group_name'];

        $group_data['user_group'] = $group_name;
        $group_data['company_id'] = "1";

        if ($group_id != 0) {
            if ($this->Mlogin->get_permission(USR_USER_GROUP_EDIT)) {
                $group_data['sys_user_group_id'] = $group_id;
                $group_data['user_group_id'] = $group_id;

//				$query	= $this->Msystem->get_where("user_group_id", "sys_user_group", "user_group", $group_data['user_group']);
//				if ($query->num_rows() == 0) {
//					$this->Msystem->delete_where("sys_user_group_module", "user_group_id", $group_id);
//					$this->Msystem->update("user_group_id", $group_id, "sys_user_group", $group_data);
//					$bool	= TRUE;
//				} else {
//					$bool	= FALSE;
//				}

                if ($group_name == $prev_group_name) {
                    $this->Msystem->delete_where("sys_user_group_module", "user_group_id", $group_id);
                    $this->Msystem->update("user_group_id", $group_id, "sys_user_group", $group_data);
                    $bool = TRUE;
                } else {
                    $query = $this->Msystem->get_where("user_group", "sys_user_group", "user_group", $group_data['user_group']);
                    if ($query->num_rows() == 0) {
                        $this->Msystem->delete_where("sys_user_group_module", "user_group_id", $group_id);
                        $this->Msystem->update("user_group_id", $group_id, "sys_user_group", $group_data);
                        $bool = TRUE;
                    } else {
                        $bool = FALSE;
                    }
                }
            } else {
                $this->load->view('html_header');
                $this->load->view('main_header_menu');
                $this->load->view('main_left_menu');

                $this->load->view('no_permission');

                $this->load->view('html_footer');
            }
        } else {
            if ($this->Mlogin->get_permission(USR_USER_GROUP_ADD)) {

                $query = $this->Msystem->get_where("user_group_id", "sys_user_group", "user_group", $group_data['user_group']);
                if ($query->num_rows() == 0) {
                    $this->Msystem->insert("sys_user_group", $group_data);
                    $bool = TRUE;
                } else {
                    $bool = FALSE;
                }
            } else {
                $this->load->view('html_header');
                $this->load->view('main_header_menu');
                $this->load->view('main_left_menu');

                $this->load->view('no_permission');

                $this->load->view('html_footer');
            }
        }

        $checked_modules = array_keys($_POST, 'on');
        foreach ($checked_modules as $module_id) {
            $group_module_data['module_id'] = $module_id;
            $group_module_data['user_group_id'] = $group_id;
            $this->Msystem->insert("sys_user_group_module", $group_module_data);
        }

        // Explicit permission for the dashboard:
        $dashboard_query = $this->Msystem->get_where_2("*", "sys_user_group_module", "user_group_id", $group_id, "module_id", "6");
        if ($dashboard_query->num_rows() == 0) {
            $dash_data['module_id'] = 6;
            $dash_data['user_group_id'] = $group_id;
            $this->Msystem->insert("sys_user_group_module", $dash_data);
        }

        $this->user_group_list($bool);
    }

// Dashboard date	
    public function dashboard_date($date_added = FALSE) {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        $date_data['date_added'] = $date_added;

        // permission
        if ($this->Mlogin->get_permission(DSH_DASHBOARD_DATE)) {
            $this->load->view('sys_dashboard_date', $date_data);
        } else {
            $this->load->view('no_permission');
        }

        $this->load->view('html_footer');
    }

    // Dashboard	
    public function dashboard() {
        // permission
        $this->load->model('Gtlsystem');
        if ($this->Mlogin->get_permission(DSH_DASHBOARD_EDIT)) {
            $dsh_date = $_POST['dsh_date'];
            $date_data['system_date'] = $dsh_date;

            $query = $this->Gtlsystem->get_date_row("*", "sys_dashboard", "system_date", $dsh_date);
            if ($query->num_rows() > 0) {
                $dsh_data['row_query'] = $query;
                $row = $query->row();

                $this->load->view('html_header');
                $this->load->view('main_header_menu');
                $this->load->view('main_left_menu');

                if ($row->system_date == '0000-00-00') {
                    $this->load->view('no_permission');
                } else {
                    $this->load->view('sys_dashboard', $dsh_data);
                }
            } else {
                $this->Gtlsystem->insert("sys_dashboard", $date_data);
                $this->dashboard_date(TRUE);
            }
        } else {
            $this->load->view('html_header');
            $this->load->view('main_header_menu');
            $this->load->view('main_left_menu');

            $this->load->view('no_permission');
        }

        $this->load->view('html_footer');
    }

    // Save dashboard
    public function save_dashboard() {
        $this->load->model('Gtlsystem');
        $system_date = $_POST['dsh_date'];

        $dsh_update['block_stock'] = $_POST['block_stock'];
        $dsh_update['stock_in_transit'] = $_POST['stock_in_transit'];
        $dsh_update['wms_sap_quantity'] = $_POST['wms_sap_quantity'];
        $dsh_update['wms_sap_pids'] = $_POST['wms_sap_pids'];
        $dsh_update['lps_amend_gsl'] = $_POST['lps_amend_gsl'];
        $dsh_update['lps_amend_ls'] = $_POST['lps_amend_ls'];
        $dsh_update['containers_requested'] = $_POST['containers_requested'];
        $dsh_update['containers_arrived'] = $_POST['containers_arrived'];
        $dsh_update['lps_three_days'] = $_POST['lps_three_days'];

        $this->Gtlsystem->update("system_date", $system_date, "sys_dashboard", $dsh_update);

        $this->dashboard_date();
    }

    public function change_password($banner = "") {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        $banner_data['banner'] = $banner;
        $this->load->view('change_password', $banner_data);

        $this->load->view('html_footer');
    }

    public function save_password() {
        $current_user_id = $this->session->userdata('user_id');
        $user_query = $this->Msystem->get_where("password", "sys_user", "user_id", $current_user_id);
        $row = $user_query->row();

        $old_password = md5($_POST['current_password']);
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($row->password == $old_password) {
            if ($new_password == $confirm_password) {
                $password_data['password'] = md5($new_password);
                $this->Msystem->update("user_id", $current_user_id, "sys_user", $password_data);

                $banner = "match";
            } else {
                $banner = "confirm";
            }
        } else {
            $banner = "old";
        }
        $this->change_password($banner);
    }

    public function my_function() {
        $this->load->view('html_header');
        $this->load->view('main_header_menu');
        $this->load->view('main_left_menu');

        $this->load->view("my_view");

        $this->load->view('html_footer');
    }

}
