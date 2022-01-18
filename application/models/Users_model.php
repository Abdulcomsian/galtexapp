<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

     /*
      Description:  Use to add user.
     */
    function add_user($Input = array()) {

        $this->db->trans_start();

        $insert_array = array_filter(array(
            "name" => @ucfirst(strtolower($Input['name'])),
            "first_name" => @ucfirst(strtolower($Input['first_name'])),
            "last_name" => @ucfirst(strtolower($Input['last_name'])),
            "email" => @$Input['email'],
            "user_guid" => get_guid(),
            "phone_number" => @$Input['phone_number'],
            "user_type_id" => @$Input['user_type_id'],
            "password" => (!empty($Input['password'])) ? md5($Input['password']) : '',
            "address" => @$Input['address'],
            "country_id" => @$Input['country_id'],
            "client_id" => @$Input['client_id'],
            "parent_user_id" => @$Input['parent_user_id'],
            "state_id" => @$Input['state_id'],
            "city_id" => @$Input['city_id'],
            "age" => @$Input['age'],
            "gender" => @$Input['gender'],
            "employee_budget" => @$Input['employee_budget'],
            "delivery_method" => @$Input['delivery_method'],
            "client_configs" => (!empty($Input['client_configs'])) ? json_encode($Input['client_configs']) : NULL,
            "user_status" => @$Input['user_status'],
            "created_date" => date('Y-m-d H:i:s'),
            "deadline" => @$Input['deadline']
        ));

        $this->db->insert('tbl_users', $insert_array);
        $user_id = $this->db->insert_id();

        /* Insert Pickup Address */
        if(!empty($this->Post['delivery_method']) && ($this->Post['delivery_method'] == 'Pickup' || $this->Post['delivery_method'] == 'Both')){
            $pickup_addresses = array_values(array_unique(array_filter($this->Post['pickup_addresses'])));
            if(count($pickup_addresses) > 0){
                for ($i=0; $i < count($pickup_addresses); $i++) { 
                    $pickup_addresses_array[] = array('client_id' => $user_id, 'pickup_address' => $pickup_addresses[$i]);
                }
                $this->db->insert_batch('tbl_client_pickup_address', $pickup_addresses_array);
            }
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    /*
      Description: 	Use to get single user info or list of users.
      Note:			$Field should be comma seprated and as per selected tables alias.
     */

    function get_users($Field = '', $Where = array(), $multiRecords = FALSE, $PageNo = 1, $PageSize = 150) {
        
        /* Additional fields to select */
        $Params = array();
        if (!empty($Field)) {
            $Params = array_map('trim', explode(',', $Field));
            $Field = '';
            $FieldArray = array(
                'created_date'  => 'DATE_FORMAT(U.created_date, "' . DATE_FORMAT . '") created_date',
                'last_login'    => 'DATE_FORMAT(U.last_login, "' . DATE_FORMAT . '") last_login',
                'last_activity' => 'DATE_FORMAT(U.last_activity, "' . DATE_FORMAT . '") last_activity',
                'user_type_name' => 'UT.user_type_name',
                'is_admin' => 'UT.is_admin',
                'user_type_guid' => 'UT.user_type_guid',
                'user_id' => 'U.user_id',
                'user_type_id' => 'U.user_type_id',
                'name' => 'U.name',
                'first_name' => 'U.first_name',
                'last_name' => 'U.last_name',
                'phone_number' => 'U.phone_number',
                'user_image' => 'IF(U.user_image IS NULL,CONCAT("' . BASE_URL . '","uploads/users/","default-148.png"),CONCAT("' . BASE_URL . '","uploads/users/",U.user_image)) AS user_image',
                'email' => 'U.email',
                'address' => 'U.address',
                'country_id' => 'U.country_id',
                'state_id' => 'U.state_id',
                'city_id' => 'U.city_id',
                'age' => 'U.age',
                'gender' => 'U.gender',
                'parent_user_id' => 'U.parent_user_id',
                'login_session_key' => 'U.login_session_key',
                'user_token' => 'U.user_token',
                'employee_budget' => 'U.employee_budget',
                'delivery_method' => 'U.delivery_method',
                'client_configs' => 'U.client_configs',
                'user_status' => 'U.user_status',
                'country_code' => 'C.code country_code',
                'country_name' => 'C.name country_name',
                'client_id' => 'U.client_id',
                'state_name' => 'S.name state_name',
                'city_name' => 'CT.name city_name',
                'client_first_name' => 'C.first_name client_first_name',
                'client_last_name' => 'C.last_name client_last_name',
                'client_deadline' => 'C.deadline client_deadline',
                'client_guid' => 'C.user_guid client_guid',
                'deadline' => 'U.deadline',
                'total_credits' => 'U.total_credits'
            );
            
            foreach ($Params as $Param) {
                $Field .= (!empty($FieldArray[$Param]) ? ',' . $FieldArray[$Param] : '');
            }
        }
        $this->db->select('U.user_guid');
        if (!empty($Field)) $this->db->select($Field, FALSE);
        $this->db->from('tbl_users U');
        if (array_keys_exist($Params, array('user_type_name', 'is_admin','user_type_guid'))) {
            $this->db->from('tbl_user_types UT');
            $this->db->where("UT.id", "U.user_type_id", FALSE);
        }
        if (array_keys_exist($Params, array('client_first_name','client_last_name','client_guid','client_deadline'))) {
            $this->db->join('tbl_users C', 'C.user_id = U.client_id', 'left');
        }
        if (array_keys_exist($Params, array('country_code','country_name'))) {
            $this->db->join('set_countries C', 'U.country_id = C.id', 'left');
        }
         if (array_keys_exist($Params, array('state_name'))) {
            $this->db->join('set_states S', 'S.id = U.state_id', 'left');
        }
         if (array_keys_exist($Params, array('city_name'))) {
            $this->db->join('set_cities CT', 'CT.id = U.city_id', 'left');
        }
        if (!empty($Where['keyword'])) {
            $Where['keyword'] = trim($Where['keyword']);
            $this->db->group_start();
            $this->db->like("U.name", $Where['keyword']);
            $this->db->or_like("U.email", $Where['keyword']);
            $this->db->or_like("U.user_status", $Where['keyword']);
            $this->db->group_end();
        }
        if (!empty($Where['user_type_id'])) {
            $this->db->where_in("U.user_type_id", $Where['user_type_id']);
        }
        if (!empty($Where['user_id'])) {
            $this->db->where("U.user_id", $Where['user_id']);
        }
        if (!empty($Where['user_guid'])) {
            $this->db->where("U.user_guid", $Where['user_guid']);
        }
        if (!empty($Where['email'])) {
            $this->db->where("U.email", $Where['email']);
        }
        if (!empty($Where['phone_number'])) {
            $this->db->where("U.phone_number", $Where['phone_number']);
        }
        if (!empty($Where['client_id'])) {
            $this->db->where("U.client_id", $Where['client_id']);
        }
        if (!empty($Where['user_guid_not_in'])) {
            $this->db->where_not_in("U.user_guid", $Where['user_guid_not_in']); 
        }

        if (!empty($Where['login_keyword'])) {
            $this->db->group_start();
            $this->db->where("U.email", $Where['login_keyword']);
            $this->db->or_where("U.phone_number", $Where['login_keyword']);
            $this->db->group_end();
        }
        if (!empty($Where['password'])) {
            $this->db->where("U.password", md5($Where['password']));
        }
        if (!empty($Where['is_admin'])) {
            $this->db->where("UT.is_admin", $Where['is_admin']);
        }
        if (!empty($Where['user_status'])) {
            $this->db->where("U.user_status", $Where['user_status']);
        }
        if (!empty($Where['order_by']) && !empty($Where['sequence']) && in_array($Where['sequence'], array('ASC', 'DESC'))) {
            $this->db->order_by($Where['order_by'], $Where['sequence']);
        } else {
            $this->db->order_by('U.user_id', 'DESC');
        }

        /* Total records count only if want to get multiple records */
        if ($multiRecords) {
            $TempOBJ = clone $this->db;
            $TempQ = $TempOBJ->get();
            $Return['data']['total_records'] = $TempQ->num_rows();
            $this->db->limit($PageSize, paginationOffset($PageNo, $PageSize)); /* for pagination */
        } else {
            $this->db->limit(1);
        }

        $Query = $this->db->get();
        if ($Query->num_rows() > 0) {
            if ($multiRecords) {
                $Records = array();
                foreach ($Query->result_array() as $key => $Record) {
                    $Records[] = $Record;
                    if (in_array('client_configs', $Params)) {
                        $Records[$key]['client_configs'] = (!empty($Record['client_configs'])) ? json_decode($Record['client_configs'], TRUE) : array();
                    }
                }
                $Return['data']['records'] = $Records;
                return $Return;
            } else {
                $Record = $Query->row_array();
                if (in_array('client_configs', $Params)) {
                    $Record['client_configs'] = (!empty($Record['client_configs'])) ? json_decode($Record['client_configs'], TRUE) : array();
                }
                if (in_array('client_addresses', $Params)) {
                    $query = $this->db->query('SELECT pickup_address FROM tbl_client_pickup_address WHERE client_id = '.$Where['user_id']);
                    $Record['client_addresses'] = ($query->num_rows() > 0) ? array_column($query->result_array(),'pickup_address') : array();
                }
                return $Record;
            }
        }
        return FALSE;
    }

    /*
      Description:  Use to update user profile info.
     */
    function update_user($user_id, $Input = array()) { 

        $this->db->trans_start();

        $update_array = array_filter(array(
            "first_name" => @ucfirst(strtolower($Input['first_name'])),
            "last_name" => @ucfirst(strtolower($Input['last_name'])),
            "email" => @$Input['email'],
            "phone_number" => @$Input['phone_number'],
            "user_type_id" => @$Input['user_type_id'],
            "password" => (!empty($Input['password'])) ? md5($Input['password']) : '',
            "address" => @$Input['address'],
            "country_id" => @$Input['country_id'],
            "state_id" => @$Input['state_id'],
            "city_id" => @$Input['city_id'],
            "age" => @$Input['age'],
            "gender" => @$Input['gender'],
            "login_session_key" => @$Input['login_session_key'],  
            "user_image" => @$Input['user_image'],  
            "user_token" => @$Input['user_token'],  
            "user_status" => @$Input['user_status'],  
            // "employee_budget" => @$Input['employee_budget'],
            "delivery_method" => @$Input['delivery_method'],
            "client_configs" => (!empty($Input['client_configs'])) ? json_encode($Input['client_configs']) : NULL,
            "last_login" => @$Input['last_login'],  
            "last_activity" => @$Input['last_activity'],
            "deadline" => @$Input['deadline']
        ));

        if (isset($Input['name']) && $Input['name'] == '') {
            $update_array['name'] = null;
        }
        if (isset($Input['email']) && $Input['email'] == '') {
            $update_array['email'] = null;
        }
        if (isset($Input['phone_number']) && $Input['phone_number'] == '') {
            $update_array['phone_number'] = null;
        }
        if (isset($Input['user_type_id']) && $Input['user_type_id'] == '') {
            $update_array['user_type_id'] = null;
        }
        if (isset($Input['address']) && $Input['address'] == '') {
            $update_array['address'] = null;
        }
        if (isset($Input['age']) && $Input['age'] == '') {
            $update_array['age'] = null;
        }
        if (isset($Input['gender']) && $Input['gender'] == '') {
            $update_array['gender'] = null;
        }
        if (isset($Input['user_image']) && $Input['user_image'] == '') {
            $update_array['user_image'] = null;
        }
        if (isset($Input['user_token']) && $Input['user_token'] == '') {
            $update_array['user_token'] = null;
        }
        if (isset($Input['last_login']) && $Input['last_login'] == '') {
            $update_array['last_login'] = null;
        }
        if (isset($Input['last_activity']) && $Input['last_activity'] == '') {
            $update_array['last_activity'] = null;
        }
        if (isset($Input['deadline']) && $Input['deadline'] == '') {
            $update_array['deadline'] = null;
        }
        
        /* Update User details to users table. */
        if (!empty($update_array)) {
            $this->db->where('user_id', $user_id);
            $this->db->limit(1);
            $this->db->update('tbl_users', $update_array);
        }

        /* Insert Pickup Address */
        if(!empty($this->Post['delivery_method']) && ($this->Post['delivery_method'] == 'Pickup' || $this->Post['delivery_method'] == 'Both')){
            $pickup_addresses = array_values(array_unique(array_filter($this->Post['pickup_addresses'])));
            if(count($pickup_addresses) > 0){
                for ($i=0; $i < count($pickup_addresses); $i++) { 
                    $pickup_addresses_array[] = array('client_id' => $user_id, 'pickup_address' => $pickup_addresses[$i]);
                }

                /* Delete Old */
                $this->db->where('client_id',$user_id);
                $this->db->delete('tbl_client_pickup_address');

                /* Insert New */
                $this->db->insert_batch('tbl_client_pickup_address', $pickup_addresses_array);
            }
        }

        /* Delete Pickup Addresses (If Delivery Method is Door to Door) */
        if(!empty($this->Post['delivery_method']) && ($this->Post['delivery_method'] == 'Door to Door')){
            $this->db->where('client_id',$user_id);
            $this->db->delete('tbl_client_pickup_address');
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    /*
      Description:  Use to delete user.
    */
    function delete_user($user_guid) {
        $this->db->where('user_guid',$user_guid);
        $this->db->where_not_in('user_type_id',1);
        $this->db->limit(1);
        $this->db->delete('tbl_users');
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        return FALSE;
    }

    /*
      Description:    Use to get User login Sources.
     */

    function get_user_role_type($user_id) {
        $this->db->select('user_type_id');
        $this->db->from('tbl_users');
        $this->db->where("user_id", $user_id);
        $Query = $this->db->get();
        if($Query->num_rows() == 0){
            return FALSE;
        }
        return $Query->row_array();

    }

    /*
      Description: 	Use to delete Session.
    */
    function delete_session($session_key) {
        $this->db->where("login_session_key", $session_key);
        $this->db->limit(1);
        $this->db->update('tbl_users', array('login_session_key' => NULL, 'last_activity' => NULL));
        return TRUE;
    }

    /*
      Description:  Use to change password.
    */
    function change_password($user_id,$password) {
        $this->db->where("user_id", $user_id);
        $this->db->limit(1);
        $this->db->update('tbl_users', array('password' => md5($password)));
        return TRUE;
    }

    /*
      Description:  Use to update last activity.
    */
    function update_last_activity($user_id) {
        $this->db->where("user_id", $user_id);
        $this->db->limit(1);
        $this->db->update('tbl_users', array('last_activity' => date('Y-m-d H:i:s')));
        return TRUE;
    }

    /*
    Description:    Use to get User Types
    */
    function get_user_types($Field='', $where=array(), $multiRecords=FALSE){
        $Params = array();
        if(!empty($Field)){
            $Params = array_map('trim',explode(',',$Field));
        }
        $this->db->select($Field,false);
        $this->db->from('tbl_user_types');
        if(!empty($where['is_admin'])){
            $this->db->where("is_admin",$where['is_admin']);
        }
        $this->db->where("is_permitted",'Yes');
        $this->db->order_by('user_type_name','ASC');
        $Query = $this->db->get();
        if($Query->num_rows() > 0){
            foreach($Query->result_array() as $key => $Record){
                if(!$multiRecords){
                    return $Record;
                }
                $Records[] = $Record;
            }
            $Return['data']['records'] = $Records;
            return $Return;
        }
        return FALSE;       
    }

    /*
      Description:  Use to send forgot password mail
    */
    function forgot_password($email,$input = array()) {

        $reset_password_link = base_url();
        $user_token = encoding($email."-".$input['user_id']."-".time());
        if(in_array($input['user_type_id'], array(1,2))){ // Admin
            $reset_password_link .= 'admin/reset-password?email='.$email.'&token='.$user_token;
        }else{ // Web
            $reset_password_link .= 'user/reset-password?email='.$email.'&token='.$user_token;
        }

        /* Update User Token */
        $this->db->where("user_id", $input['user_id']);
        $this->db->limit(1);
        $this->db->update('tbl_users', array('user_token' => $user_token));

        /* Send Email To User */
        $status = php_mailer($email,$input['user_full_name'],'['.SITE_NAME.'] Forgot Password Request !!',emailTemplate($this->load->view('emailer/forgotPassword', array('user_full_name' => $this->Post['user_full_name'],'reset_password_link' => $reset_password_link), true)));
        if($status){
            return TRUE;
        }
        return FALSE;
    }

    /*
      Description:  Use to reset password
    */
    function reset_password($user_id,$input = array()) {

        /* Update User Password */
        $this->db->where("user_id", $user_id);
        $this->db->limit(1);
        $this->db->update('tbl_users', array('user_token' => NULL, 'password' => md5($input['new_password'])));
        if($this->db->affected_rows() > 0){

            $login_link = base_url();
            if(in_array($input['user_type_id'], array(1,2))){ // Admin
                $login_link .= 'admin/login';
            }
            
            /* Send Email To User */
            php_mailer($input['user_email'],$input['user_full_name'],'['.SITE_NAME.'] Password Changed Successfully !!',emailTemplate($this->load->view('emailer/changePassword', array('user_full_name' => $this->Post['user_full_name'],'login_link' => $login_link), true)));

            return TRUE;
        }
        return FALSE;
    }

    /*
      Description:  Use to send OTP
    */
    function send_otp($user_id, $login_type, $phone_number) {

        $six_digit_random_number = random_int(100000, 999999);

        /* Update User Password */
        $this->db->where("user_id", $user_id);
        $this->db->limit(1);
        $this->db->update('tbl_users', array('user_token' => $six_digit_random_number));
        if($this->db->affected_rows() > 0){

            if(ENVIRONMENT == 'local'){
                return TRUE;
            }

            /* Send OTP (Twilio) */
            if($login_type == 'OTP'){
               $fields = array(
                    'From' => urlencode('+972526935016'),
                    'Body' => urlencode(SITE_NAME.' '.lang('login_otp_is').' '.$six_digit_random_number),
                    'To'   => urlencode('+972'.$phone_number)
                );
                $api_url = "https://api.twilio.com/2010-04-01/Accounts/AC7a03b4ae0ba61105c2af5ce6b5d176df/Messages.json";
                
            }else if($login_type == 'Phone'){

                $xml = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                $xml .= '<Say>This is an automated call providing you your OTP from the Galtex app.</Say>';
                $xml .= '<Say>Your one time password is</Say>';
                foreach(str_split($six_digit_random_number) as $number){
                    $xml .= '<Pause>0.2</Pause>';
                    $xml .= '<Say>'.$number.'</Say>';
                }
                $xml .= '<Say>GoodBye</Say></Response>';
                $filename = "voicecall".$phone_number.".xml";
                file_put_contents($filename, $xml);
                $fields = array(
                    'From' => urlencode('+972526935016'),
                    'Url'  => urlencode(BASE_URL.$filename),
                    'To'   => urlencode('+972'.$phone_number)
                );
                $api_url = "https://api.twilio.com/2010-04-01/Accounts/AC7a03b4ae0ba61105c2af5ce6b5d176df/Calls.json";
            }

            //url-ify the data for the POST
            foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string, '&');

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $api_url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $fields_string,
              CURLOPT_HTTPHEADER => array(
                "authorization: Basic QUM3YTAzYjRhZTBiYTYxMTA1YzJhZjVjZTZiNWQxNzZkZjo1MTk2NzMzM2JlNDI4ZTBiNjgyMjUxNjcwM2NkNzVlYw==",
                "content-type: application/x-www-form-urlencoded"
              ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              echo "cURL Error #:" . $err;die;
            } 
            return TRUE;
        }
        return FALSE;
    }

    /*
      Description:  Use to send user message
    */
    function send_enquiry($message) {
        if(send_smtp_mail(SUPPORT_EMAIL,SITE_NAME." ".lang('having_trobule'),$message)){
            return TRUE;
        }
        return FALSE;
    }


}
