<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends API_Controller_Secure {

    function __construct() {
        parent::__construct();
        if($this->user_type_id != 1){
            $this->Return['status']  = 500;
            $this->Return['message'] = lang('access_denied');
            exit;
        }
        $this->load->model('Shop_model');
    }

    /*
      Description: 	To add new client
      URL: 			/admin/api/clients/add/
    */
    public function add_post() {

        /* Validation section */
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('contact_name', 'Contact Name', 'trim|required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required');
        $this->form_validation->set_rules('employee_budget', 'Employee Budget', 'trim|required|numeric|greater_than_equal_to[1]');
        $this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required');
        $this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required');
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email|is_unique[tbl_users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('shop_title', 'Shop Title', 'trim|required');
        $this->form_validation->set_rules('theme_color', 'Theme Color', 'trim|required');
        $this->form_validation->set_rules('delivery_method', 'Delivery Method', 'trim|required');
        $this->form_validation->set_rules('pickup_addresses[]', lang('pickup_addresses'), 'trim');
        $this->form_validation->set_message('is_unique', '{field} '.lang('field_already_exist'));
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        /* Upload company logo */
        if(!empty($_FILES['company_logo']['name'])){
            $image_data = fileUploading('company_logo','company','jpg|jpeg|png|gif');
            if(!empty($image_data['error'])){
                $this->Return['status'] = 500;
                $this->Return['message'] = lang('company_logo').' - '.$image_data['error'];
                exit;
            }
            $this->Post['company_logo'] = $image_data['upload_data']['file_name'];
        }else{
            $this->Return['status']  = 500;
            $this->Return['message'] = lang('require_company_logo');
            exit;
        }

        /* Check Pickup Addresses */
        if(($this->Post['delivery_method'] == 'Pickup' || $this->Post['delivery_method'] == 'Both') && empty($this->Post['pickup_addresses'])){
            $this->Return['status']  = 500;
            $this->Return['message'] = lang('require_pickup_addresses');
            exit;
        }

        /* Make Configs */
        $this->Post['client_configs'] = array();
        $this->Post['client_configs']['company_name'] = $this->Post['company_name'];
        $this->Post['client_configs']['contact_name'] = $this->Post['contact_name'];
        $this->Post['client_configs']['contact_number'] = $this->Post['contact_number'];
        $this->Post['client_configs']['shop_title'] = $this->Post['shop_title'];
        $this->Post['client_configs']['theme_color'] = $this->Post['theme_color'];
        $this->Post['client_configs']['company_logo'] = $this->Post['company_logo'];

        if(!$this->Users_model->add_user(array_merge($this->Post,array('user_type_id' => 2, 'user_status' => 'Verified', 'parent_user_id' => $this->session_user_id)))){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{

            $this->Return['status'] = 200;
            $this->Return['message'] = lang('client_added');   
        }
    }

     /*
      Description:  To edit client
      URL:          /admin/api/clients/edit/
    */
    public function edit_post() { 
        /* Validation section */
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('contact_name', 'Contact Name', 'trim|required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('user_guid', 'User GUID', 'trim|required|callback_validate_guid[tbl_users.user_guid.user_id]');
        $this->form_validation->set_rules('user_status', 'Status', 'trim|required|in_list[Pending,Verified,Blocked]');
        $this->form_validation->set_rules('shop_title', 'Shop Title', 'trim|required');
        $this->form_validation->set_rules('theme_color', 'Theme Color', 'trim|required');
        $this->form_validation->set_rules('delivery_method', 'Delivery Method', 'trim|required');
        $this->form_validation->set_rules('pickup_addresses[]', lang('pickup_addresses'), 'trim');
        $this->form_validation->set_rules('deadline', lang('deadline'), 'trim');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        /* Upload company logo */
        if(!empty($_FILES['company_logo']['name'])){
            $image_data = fileUploading('company_logo','company','jpg|jpeg|png|gif');
            if(!empty($image_data['error'])){
                $this->Return['status'] = 500;
                $this->Return['message'] = lang('company_logo').' - '.$image_data['error'];
                exit;
            }
            $this->Post['company_logo'] = $image_data['upload_data']['file_name'];
        }

        /* Check Pickup Addresses */
        if(($this->Post['delivery_method'] == 'Pickup' || $this->Post['delivery_method'] == 'Both') && empty($this->Post['pickup_addresses'])){
            $this->Return['status']  = 500;
            $this->Return['message'] = lang('require_pickup_addresses');
            exit;
        }

        /* Make Configs */
        $this->Post['client_configs'] = array();
        $this->Post['client_configs']['company_name'] = $this->Post['company_name'];
        $this->Post['client_configs']['contact_name'] = $this->Post['contact_name'];
        $this->Post['client_configs']['contact_number'] = $this->Post['contact_number'];
        $this->Post['client_configs']['shop_title'] = $this->Post['shop_title'];
        $this->Post['client_configs']['theme_color'] = $this->Post['theme_color'];
        $this->Post['client_configs']['company_logo'] = (!empty($this->Post['company_logo'])) ? $this->Post['company_logo'] : $this->Post['old_company_logo'];
        if(!$this->Users_model->update_user($this->user_id,$this->Post)){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{
            $this->Return['status']  = 200;
            $this->Return['message'] = lang('client_updated');   
        }
    }

     /*
      Description:  To view client details
      URL:          /admin/api/clients/details/
    */
    public function details_post() { 

        /* Validation section */
        $this->form_validation->set_rules('user_guid', 'User GUID', 'trim|required|callback_validate_guid[tbl_users.user_guid.user_id]');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */
       
        /* To Get User Details */
        $details = $this->Users_model->get_users('first_name,last_name,email,user_status,employee_budget,delivery_method,client_configs,created_date,deadline',array('user_id' => $this->user_id));
        if(!empty($this->Post['data_type']) && $this->Post['data_type'] == 'html'){
            $this->load->view('admin/clients/view-details',array('details' => $details));
        }else{
            $this->Return['data'] = $details;
        }
    }

     /*
      Description:  To view client pick up addresses
      URL:          /admin/api/clients/pickup_addresses/
    */
    public function pickup_addresses_post() { 

        /* Validation section */
        $this->form_validation->set_rules('user_guid', 'User GUID', 'trim|required|callback_validate_guid[tbl_users.user_guid.user_id]');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */
        
        /* To Get User Details */
        $details = $this->Users_model->get_users('client_configs',array('user_id' => $this->user_id));

        /* To Get Pick Up Address */
        $query = $this->db->query('SELECT pickup_address FROM tbl_client_pickup_address WHERE client_id = '.$this->user_id);
        if(!empty($this->Post['data_type']) && $this->Post['data_type'] == 'html'){
            $this->load->view('admin/clients/view-pickup-address',array('details' => $details, 'address' => $query->result_array()));
        }else{
            $this->Return['data'] = $details;
        }
    }

    /*
      Description:  To create package
      URL:          /admin/api/clients/create_package/
    */
    public function create_package_post() { 

        /* Validation section */
        $this->form_validation->set_rules('package_name', 'Package Name', 'trim|required');
        $this->form_validation->set_rules('quantity', 'Package Quantity', 'trim|required|numeric|greater_than_equal_to[1]');
        $this->form_validation->set_rules('user_guid', 'User GUID', 'trim|required|callback_validate_guid[tbl_users.user_guid.user_id]');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        /* Check Product GUIDS */
        if(!empty($this->Post['product_guids'])){
            foreach($this->Post['product_guids'] as $key => $product_guid){
                $query = $this->db->query('SELECT product_id FROM tbl_products WHERE product_guid = "'.$product_guid.'" LIMIT 1');
                if($query->num_rows() == 0){
                    $this->Return['status']  = 500;
                    $this->Return['message'] = 'Invalid product.';
                    exit;
                }
                $this->Post['product_ids'][] = $query->row()->product_id;
            }
        }else{
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('select_products');
            exit;
        }
        
        /* Create Package */
        if(!$this->Shop_model->create_package($this->user_id, $this->Post)){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{

            $this->Return['status'] = 200;
            $this->Return['message'] = lang('package_created');   
        }
    }

    /*
      Description:  To set shop
      URL:          /admin/api/clients/set_shop/
    */
    public function set_shop_post() { 

        /* Validation section */
        $this->form_validation->set_rules('user_guid', 'User GUID', 'trim|required|callback_validate_guid[tbl_users.user_guid.user_id]');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        if(empty($this->Post['within_product_guids']) && empty($this->Post['above_product_guids'])){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('select_products');
            exit;
        }

        /* Check Product GUIDS (Within the Budget) */
        if(!empty($this->Post['within_product_guids'])){
            foreach($this->Post['within_product_guids'] as $key => $product_guid){
                $query = $this->db->query('SELECT product_id FROM tbl_products WHERE product_guid = "'.$product_guid.'" LIMIT 1');
                if($query->num_rows() == 0){
                    $this->Return['status']  = 500;
                    $this->Return['message'] = 'Invalid product.';
                    exit;
                }
                $this->Post['within_product_ids'][] = $query->row()->product_id;
            }
        }

        /* Check Product GUIDS (Above the Budget) */
        if(!empty($this->Post['above_product_guids'])){
            foreach($this->Post['above_product_guids'] as $key => $product_guid){
                $query = $this->db->query('SELECT product_id FROM tbl_products WHERE product_guid = "'.$product_guid.'" LIMIT 1');
                if($query->num_rows() == 0){
                    $this->Return['status']  = 500;
                    $this->Return['message'] = 'Invalid product.';
                    exit;
                }
                $this->Post['above_product_ids'][] = $query->row()->product_id;
            }

            /* Check product prices */
            if(empty($this->Post['above_product_additional_prices']) || (count($this->Post['above_product_guids']) != count($this->Post['above_product_additional_prices']))){
                $this->Return['status']  = 500;
                $this->Return['message'] = lang('add_selected_product_prices');
                exit;
            }

            foreach($this->Post['above_product_additional_prices'] as $key => $price){
                if($price <= 0){
                    $this->Return['status']  = 500;
                    $this->Return['message'] = lang('above_budget_price_should_be_greater_than_to_zero');
                    exit;
                }
            }
        }

        /* Set Shop */
        if(!$this->Shop_model->set_shop($this->user_id, $this->Post)){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{

            $this->Return['status'] = 200;
            $this->Return['message'] = lang('shop_products_successfully_added');   
        }
    }


  
}