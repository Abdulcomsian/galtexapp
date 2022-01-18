<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends API_Controller {

    function __construct() {
        parent::__construct();
    }

    /*
      Description: 	Verify login and activate session
      URL: 			/api/login/
     */

    public function index_post() { 
        /* Validation section */
        $this->form_validation->set_rules('login_type', 'Login Type', 'trim|required|in_list[OTP,Phone,Password]');
        $this->form_validation->set_rules('phone_number', lang('mobile_number'), 'trim|required|callback_validate_user_phone');
        if($this->Post['login_type'] == 'OTP' || $this->Post['login_type'] == 'Phone'){
            $this->form_validation->set_rules('otp', 'OTP', 'trim|required|numeric|callback_verify_otp');
        }else{
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
        }
        $this->form_validation->set_rules('is_remember', 'Is Remember', 'trim');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        if($this->Post['login_type'] == 'OTP' || $this->Post['login_type'] == 'Phone'){
            $user_data = $this->Users_model->get_users('user_id,is_admin,user_status,user_type_guid,user_type_id,user_image,first_name,last_name,client_id,client_deadline,email', array('user_id' => $this->Post['user_id']));
        }else{
             $user_data = $this->Users_model->get_users('user_id,is_admin,user_status,user_type_guid,user_type_id,user_image,first_name,last_name,client_id,client_deadline,email', array('phone_number' => $this->Post['phone_number'], 'password' => $this->Post['password']));
        }
        if (!$user_data) {
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('invalid_credentials');
        } elseif ($user_data && $user_data['user_status'] == 'Pending') {
            $this->Return['status'] = 501;
            $this->Return['message'] = lang('account_pending');
        }elseif ($user_data && $user_data['user_status'] == 'Blocked') {
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('account_blocked');
        }elseif ($user_data && $user_data['user_status'] == 'Order Placed') {
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('order_placed');
        }elseif ($user_data && !empty($user_data['client_deadline']) && (strtotime(datetime('Y-m-d')) > strtotime($user_data['client_deadline']))) {
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('client_deadline_passed');
        }elseif ($user_data && $user_data['is_admin'] == 'Yes') {
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('access_denied');
        } else {

            /* Update Data */
            $login_session_key = get_guid();

            $update_arr = array();
            $update_arr['login_session_key'] = $login_session_key;
            $update_arr['last_login']    = date('Y-m-d H:i:s');
            $update_arr['last_activity'] = date('Y-m-d H:i:s');
            $this->Users_model->update_user($user_data['user_id'],$update_arr);

            /* Manage Response Data */
            $response_data = array();
            $response_data['login_session_key'] = $login_session_key;
            $response_data['user_id']           = $user_data['user_id'];
            $response_data['user_guid']         = $user_data['user_guid'];
            $response_data['email']             = $user_data['email'];
            $response_data['user_type_guid']    = $user_data['user_type_guid'];
            $response_data['user_type_id']      = $user_data['user_type_id'];
            $response_data['last_login']        = $update_arr['last_login'];
            $response_data['first_name']        = $user_data['first_name'];
            $response_data['last_name']         = $user_data['last_name'];
            $response_data['user_image']        = $user_data['user_image'];

            /* Get Client Configs */
            $query = $this->db->query('SELECT client_configs,employee_budget FROM tbl_users WHERE user_id = '.$user_data['client_id'].' LIMIT 1');

            /* Set PHP Session */
            $this->session->set_userdata('webuserdata',array_merge($response_data,array('client_id' => $user_data['client_id'], 'client_configs' => json_decode($query->row()->client_configs, TRUE), 'employee_budget' => $query->row()->employee_budget)));

            /* Set Cookies */
            if(@$this->Post['is_remember'] == 'yes'){
                set_cookie("phone_number", $this->Post['phone_number'], time()+ (365 * 24 * 60 * 60));  
            }else{
                set_cookie("phone_number",""); 
            }

            $response_data['redirect_uri'] = BASE_URL.'employees/products';
            unset($response_data['user_id']);
            $this->Return['data'] = $response_data;
            $this->Return['message'] = lang('logged_in');
        }
    }

    /*
      Description:  To send otp on user phone number or phone call
      URL:          /api/login/send_otp_phone_call/
     */
    public function send_otp_phone_call_post() { 
        /* Validation section */
        $this->form_validation->set_rules('login_type', 'Login Type', 'trim|required|in_list[OTP,Phone]');
        $this->form_validation->set_rules('phone_number', lang('mobile_number'), 'trim|required|callback_validate_user_phone');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        if(!$this->Users_model->send_otp($this->Post['user_id'], $this->Post['login_type'], $this->Post['phone_number'])){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{
            $this->Return['status']  = 200;
            $this->Return['message'] = lang('otp_sent');   
        }
    }

    /*
      Description:  To set user language
      URL:          /api/login/set_language/
    */
    public function set_language_post()
    {
        /* Validation section */
        $this->form_validation->set_rules('lang', 'Language', 'trim|required|in_list[en,he]');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        /* Set Language */
        $this->session->set_userdata('language',$this->Post['lang']);
        $this->Return['status']  = 200;
        $this->Return['message'] = lang('success');  
    }

    /*
      Description:  To send customer enquiry
      URL:          /api/login/send_enquiry/
     */
    public function send_enquiry_post() { 
        /* Validation section */
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        if(!$this->Users_model->send_enquiry($this->Post['message'])){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{
            $this->Return['status']  = 200;
            $this->Return['message'] = lang('your_help_message_sent');   
        }
    }

    /**
     * Function Name: validate_user_phone
     * Description:   To validate user phone number
     */
    public function validate_user_phone($phone_number){
        $Query = $this->db->query('SELECT user_id, user_status FROM `tbl_users` WHERE phone_number = "'.$phone_number.'" AND user_type_id = 3 LIMIT 1');
        if ($Query->num_rows() == 0) {
            $this->form_validation->set_message('validate_user_phone', 'Invalid {field}.');
            return FALSE;
        }
        if($Query->row()->user_status != 'Verified'){
            $this->form_validation->set_message('validate_user_phone', lang('account_blocked_pending'));
            return FALSE;
        }
        $this->Post['user_id'] = $Query->row()->user_id;
        return TRUE;
    }

    /**
     * Function Name: verify_otp
     * Description:   To verify user otp
     */
    public function verify_otp($otp){
        if(empty($this->Post['user_id'])){
            $this->form_validation->set_message('verify_otp', lang('error_occured'));
            return FALSE;
        }
        $Query = $this->db->query('SELECT user_id FROM `tbl_users` WHERE user_token = "'.$otp.'" AND user_id = '.$this->Post['user_id'].' LIMIT 1');
        if ($Query->num_rows() == 0) {
            $this->form_validation->set_message('verify_otp', 'Invalid {field}.');
            return FALSE;
        }
        return TRUE;
    }



}
