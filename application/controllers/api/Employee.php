<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends API_Controller_Secure {

    function __construct() {
        parent::__construct();
        $this->load->model('Employee_model');
        $this->load->model('Shop_model');
        $this->load->model('Products_model');
        $this->load->model('Orders_model');
    }

    /*
      Description:  To add products into cart
      URL:          /api/employee/add_to_cart/
    */
    public function add_to_cart_post() {

        /* Validation section */
        $this->form_validation->set_rules('type', 'Type', 'trim|required|in_list[package,product]');
        if($this->Post['type'] == 'package'){
            $this->form_validation->set_rules('guid', 'GUID', 'trim|required|callback_validate_guid[tbl_client_packages.package_guid.package_id]');
        }else{
           $this->form_validation->set_rules('guid', 'GUID', 'trim|required|callback_validate_guid[tbl_products.product_guid.product_id]'); 
        }
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        if(!$this->Employee_model->add_to_cart(array_merge($this->Post,array('package_id' => @$this->package_id, 'product_id' => @$this->product_id)))){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{

            $this->Return['status'] = 200;
            $this->Return['data'] = array('cart_total_items' => count($this->cart->contents()));
            $this->Return['message'] = lang($this->Post['type'])." ".lang('added_into_cart');   
        }
    }

    /*
      Description:  To checkout order
      URL:          /api/employee/checkout/
    */
    public function checkout_post() {

        /* Validation section */
        $this->form_validation->set_rules('address_mode', 'Address Mode', 'trim|required|in_list[Door to Door,Pickup]');
        if($this->Post['address_mode'] == 'Pickup'){
            $this->form_validation->set_rules('pickup_address', 'Pickup Address', 'trim|required');
        }else{
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('apartment', 'Apartment', 'trim');
            $this->form_validation->set_rules('street_house', 'Street House', 'trim|required');
            // $this->form_validation->set_rules('postal_code', 'Postal Code', 'trim|required');
        }
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        /* To Check Cart Items */
        if($this->cart->total_items() == 0){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('cart_empty');
            exit;
        }

        /* Check Already Created Order */
        $order = $this->db->query('SELECT 1 FROM tbl_orders WHERE user_id = '.$this->session_user_id.' AND order_status = "Created" AND payment_status = "Success" LIMIT 1');
        if($order->num_rows() > 0){
            $this->cart->destroy();
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('you_already_placed_order');
            exit;
        }

        $response = $this->Employee_model->create_order(array_merge($this->Post,array('cart_data' => $this->cart->contents())),$this->session_user_id);
        if(!$response){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{
            $this->Return['data'] = $response;
            $this->Return['status'] = 200;
            $this->Return['message'] = lang('thank_you_order_placed');   
        }
    }

    /*
      Description:  To cancel user order
      URL:          /api/employee/cancel_order/
    */
    public function cancel_order_post() {

        /* Validation section */
        $this->form_validation->set_rules('order_guid', 'Order GUID', 'trim|required|callback_validate_cancel_order');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        if(!$this->Employee_model->cancel_order($this->Post)){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{

            $this->Return['status'] = 200;
            $this->Return['message'] = lang('order_cancelled');   
        }
    }

    /**
     * Function Name: validate_cancel_order
     * Description:   To validate cancel order
     */
    public function validate_cancel_order($order_guid){
        $order_details = $this->Orders_model->get_orders('order_id,user_id,order_status,amount,order_product_details',array('order_guid' => $order_guid));
        if (empty($order_details)) {
            $this->form_validation->set_message('validate_cancel_order', 'Invalid {field}.');
            return FALSE;
        }
        if($order_details['order_status'] == 'Cancelled'){
            $this->form_validation->set_message('validate_cancel_order', lang('order_already_cancelled'));
            return FALSE;
        }
        if($order_details['user_id'] != $this->session_user_id){
            $this->form_validation->set_message('validate_cancel_order', lang('you_cant_cancel_order'));
            return FALSE;
        }
        $this->Post['order_id'] = $order_details['order_id'];
        $this->Post['order_amount'] = $order_details['order_amount'];
        $this->Post['user_id'] = $order_details['user_id'];
        $this->Post['order_product_details'] = $order_details['order_product_details'];
        return TRUE;
    }



  
}