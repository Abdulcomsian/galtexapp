<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends API_Controller_Secure {

    function __construct() {
        parent::__construct();
        $this->load->model('Products_model');
        if($this->user_type_id != 1){
            $this->Return['status']  = 500;
            $this->Return['message'] = lang('access_denied');
            exit;
        }
    }

    /*
      Description: 	To add new product
      URL: 			/admin/api/products/add/
    */
    public function add_post() {

        /* Validation section */
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('product_category_id', 'Product Category', 'trim|required|callback_validate_guid[tbl_categories.category_guid.category_id]');
        $this->form_validation->set_rules('min_price', 'Min Price', 'trim|required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('max_price', 'Max Price', 'trim|required|numeric|greater_than_equal_to['.$this->Post['min_price'].']');
        $this->form_validation->set_rules('product_main_photo', 'Product Main Photo', 'trim');
        $this->form_validation->set_rules('product_gallery_images[]', 'Product Gallery Images', 'trim|required');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        /* Upload main photo */
        if(!empty($_FILES['product_main_photo']['name'])){
            $image_data = fileUploading('product_main_photo','products','jpg|jpeg|png|gif');
            if(!empty($image_data['error'])){
                $this->Return['status'] = 500;
                $this->Return['message'] = lang('product_main_photo').' - '.$image_data['error'];
                exit;
            }
            $this->Post['product_main_photo'] = $image_data['upload_data']['file_name'];
        }else{
            $this->Return['status']  = 500;
            $this->Return['message'] = lang('require_product_main_photo');
            exit;
        }

        if(!$this->Products_model->add_product(array_merge($this->Post,array('product_category_id' => $this->category_id)))){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{

            $this->Return['status'] = 200;
            $this->Return['message'] = lang('product_added');   
        }
    }

    /*
      Description:  To edit product
      URL:          /admin/api/products/edit/
    */
    public function edit_post() {

        /* Validation section */
        $this->form_validation->set_rules('product_guid', 'Product GUID', 'trim|required|callback_validate_guid[tbl_products.product_guid.product_id]');
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('product_category_id', 'Product Category', 'trim|required|callback_validate_guid[tbl_categories.category_guid.category_id]');
        $this->form_validation->set_rules('min_price', 'Min Price', 'trim|required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('max_price', 'Max Price', 'trim|required|numeric|greater_than_equal_to['.$this->Post['min_price'].']');
        $this->form_validation->set_rules('product_main_photo', 'Product Main Photo', 'trim');
        $this->form_validation->set_rules('product_gallery_images[]', 'Product Gallery Images', 'trim');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        /* Upload main photo */
        if(!empty($_FILES['product_main_photo']['name'])){
            $image_data = fileUploading('product_main_photo','products','jpg|jpeg|png|gif');
            if(!empty($image_data['error'])){
                $this->Return['status'] = 500;
                $this->Return['message'] = lang('product_main_photo').' - '.$image_data['error'];
                exit;
            }
            $this->Post['product_main_photo'] = $image_data['upload_data']['file_name'];
        }

        if(!$this->Products_model->edit_product($this->product_id,array_merge($this->Post,array('product_category_id' => $this->category_id)))){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{

            $this->Return['status'] = 200;
            $this->Return['message'] = lang('product_updated');   
        }
    }

    /*
      Description:  To upload products (using csv file)
      URL:          /admin/api/products/upload/
    */
    public function upload_post() {

        /* Validation section */
        $this->form_validation->set_rules('products_csv', 'Product CSV', 'trim|callback_validate_products_csv_file');
        $this->form_validation->validation($this);  /* Run validation */
        /* Validation - ends */

        /* Insert Data */
        $this->Return['data'] = $this->Products_model->upload_products($this->Post);
    }

    /**
     * Function Name: validate_products_csv_file  
     * Description:   To validate products csv file
     */
    public function validate_products_csv_file() {

        /* Validate Tasks CSV */
        if(!empty($_FILES['products_csv']['name'])){

            /* Read CSV file */
            $tasks_csv_data = array_map('str_getcsv', file($_FILES['products_csv']['tmp_name']));
            if(empty($tasks_csv_data)){
                $this->form_validation->set_message('validate_products_csv_file', lang('product_csv_empty'));
                return FALSE;
            }
            unset($tasks_csv_data[0]);
            $this->Post['products_data'] = array_values($tasks_csv_data);
        }else{
            $this->form_validation->set_message('validate_products_csv_file', lang('require_product_csv_file'));
            return FALSE;
        }
        return TRUE;
    }
}