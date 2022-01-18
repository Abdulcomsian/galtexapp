<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends API_Controller_Secure {

    function __construct() {
        parent::__construct();
        $this->load->model('Shop_model');
    }

    /*
      Description:  To like dislike shop products
      URL:          /admin/api/shop/like_dislike_shop_products/
    */
    public function like_dislike_shop_products_post() { 

        /* Shop Products */
        if(empty($this->Post['within_product_guids']) && empty($this->Post['above_product_guids'])){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('select_products');
            exit;
        }

        /* Check Product GUIDS (Within the Budget) */
        if(!empty($this->Post['within_product_guids'])){
            foreach($this->Post['within_product_guids'] as $key => $shop_product){
                list($shop_product_id,$client_status) = explode("-",$shop_product);
                $this->Post['within_shop_products'][] = array('shop_product_id' => $shop_product_id, 'client_status' => $client_status);
            }
        }

        /* Check Product GUIDS (Above the Budget) */
        if(!empty($this->Post['above_product_guids'])){
            foreach($this->Post['above_product_guids'] as $key => $shop_product){
                list($shop_product_id,$client_status) = explode("-",$shop_product);
                $this->Post['above_shop_products'][] = array('shop_product_id' => $shop_product_id, 'client_status' => $client_status);
            }
        }

        /* Check Packages GUIDS */
        if(!empty($this->Post['client_packages'])){
            foreach($this->Post['client_packages'] as $key => $package){
                list($package_guid,$client_status) = explode("@",$package);
                $query = $this->db->query('SELECT package_id FROM tbl_client_packages WHERE package_guid = "'.$package_guid.'" LIMIT 1');
                if($query->num_rows() == 0){
                    $this->Return['status']  = 500;
                    $this->Return['message'] = 'Invalid package.';
                    exit;
                }
                $this->Post['client_package_ids'][] = array('package_id' => $query->row()->package_id, 'client_status' => $client_status);
            }
        }

        /* Set Shop */
        if(!$this->Shop_model->like_dislike_shop_products($this->session_user_id, $this->Post)){
            $this->Return['status'] = 500;
            $this->Return['message'] = lang('error_occured');
        }else{

            $this->Return['status'] = 200;
            $this->Return['message'] = lang('shop_products_selection_successfully_updated');   
        }
    }


  
}