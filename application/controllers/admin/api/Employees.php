<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends API_Controller_Secure {

    function __construct() {
        parent::__construct();
        $this->load->model('Employee_model');
    }

    /*
      Description:  To add new employee
      URL:          /admin/api/employees/add/
    */
    public function add_post() {

        /* Validation section */
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email|is_unique[tbl_users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|is_unique[tbl_users.phone_number]');
        $this->form_validation->set_rules('client_guid', 'Client GUID', 'trim|required|callback_validate_guid[tbl_users.user_guid.user_id]');
        $this->form_validation->set_message('is_unique', '{field} '.lang('field_already_exist'));
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        if(!$this->Users_model->add_user(array_merge($this->Post,array('user_type_id' => 3, 'user_status' => 'Verified', 'parent_user_id' => $this->session_user_id, 'client_id' => $this->user_id)))){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{

            $this->Return['status'] = 200;
            $this->Return['message'] = lang('employee_added');   
        }
    }

     /*
      Description:  To edit employee
      URL:          /admin/api/employees/edit/
    */
    public function edit_post() { 

        /* Validation section */
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('user_guid', 'User GUID', 'trim|required|callback_validate_guid[tbl_users.user_guid.user_id]');
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required');
        $this->form_validation->set_rules('user_status', 'Status', 'trim|required|in_list[Pending,Verified,Blocked]');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        /* Validate Unique Email ID */
        $query = $this->db->query('SELECT 1 FROM tbl_users WHERE email = "'.$this->Post['email'].'" AND user_id != '.$this->user_id.' LIMIT 1');
        if($query->num_rows() > 0){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('email_id_already_exist');
            exit;
        }

        /* Validate Unique Phone Number */
        $query = $this->db->query('SELECT 1 FROM tbl_users WHERE phone_number = "'.$this->Post['phone_number'].'" AND user_id != '.$this->user_id.' LIMIT 1');
        if($query->num_rows() > 0){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('phone_number_already_exist');
            exit;
        }
        
        if(!$this->Users_model->update_user($this->user_id,array_merge($this->Post,array()))){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{
            $this->Return['status']  = 200;
            $this->Return['message'] = lang('employee_updated');   
        }
    }

     /*
      Description:  To view employee details
      URL:          /admin/api/employees/details/
    */
    public function details_post() { 

        /* Validation section */
        $this->form_validation->set_rules('user_guid', 'User GUID', 'trim|required|callback_validate_guid[tbl_users.user_guid.user_id]');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */
       
        /* To Get User Details */
        $details = $this->Users_model->get_users('first_name,last_name,email,phone_number,user_status,client_first_name,client_last_name,created_date',array('user_id' => $this->user_id));
        if(!empty($this->Post['data_type']) && $this->Post['data_type'] == 'html'){
            $this->load->view('admin/employees/view-details',array('details' => $details));
        }else{
            $this->Return['data'] = $details;
        }
    }

    /*
      Description:  To upload employees (using csv file)
      URL:          /admin/api/employees/upload/
    */
    public function upload_post() {
        
        /* Validation section */
        $this->form_validation->set_rules('user_guid', 'User GUID', 'trim|required|callback_validate_guid[tbl_users.user_guid.user_id]');
        $this->form_validation->set_rules('employees_csv', 'Employee CSV', 'trim|callback_validate_employees_csv_file');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        /* Insert Data */
        $this->Return['data'] = $this->Employee_model->upload_employees($this->Post,$this->user_id);
    }

    /**
     * Function Name: validate_employees_csv_file  
     * Description:   To validate employees csv file
     */
    public function validate_employees_csv_file() {

        /* Validate Tasks CSV */
        if(!empty($_FILES['employees_csv']['name'])){

            /* Read CSV file */
            $tasks_csv_data = array_map('str_getcsv', file($_FILES['employees_csv']['tmp_name']));
            if(empty($tasks_csv_data)){
                $this->form_validation->set_message('validate_employees_csv_file', lang('employee_csv_empty'));
                return FALSE;
            }
            unset($tasks_csv_data[0]);
            $this->Post['employees_data'] = array_values($tasks_csv_data);
        }else{
            $this->form_validation->set_message('validate_employees_csv_file', lang('require_employee_csv_file'));
            return FALSE;
        }
        return TRUE;
    }
  
}