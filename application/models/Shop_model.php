<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shop_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
      Description:  Use to create package.
     */
    function create_package($client_id, $Input = array()) {

        $this->db->trans_start();

        $insert_array = array_filter(array(
            "client_id" => $client_id,
            "package_name" => @$Input['package_name'],
            "quantity" => @$Input['quantity'],
            "package_guid" => get_guid(),
            "no_of_products" => count($Input['product_ids']),
            "created_date" => date('Y-m-d H:i:s')
        ));

        $this->db->insert('tbl_client_packages', $insert_array);
        $package_id = $this->db->insert_id();

        /* Insert Package Products */
        if(!empty($this->Post['product_ids'])){
            for ($i=0; $i < count($this->Post['product_ids']); $i++) { 
                $client_package_products_array[] = array('package_id' => $package_id, 'product_id' => $this->Post['product_ids'][$i]);
            }
            $this->db->insert_batch('tbl_client_package_products', $client_package_products_array);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    /*
      Description:  Use to get packages
     */

    function get_packages($Field = '', $Where = array(), $multiRecords = FALSE, $PageNo = 1, $PageSize = 150) {
        /* Additional fields to select */
        $Params = array();
        if (!empty($Field)) {
            $Params = array_map('trim', explode(',', $Field));
            $Field = '';
            $FieldArray = array(
                'created_date'   => 'DATE_FORMAT(P.created_date, "' . DATE_FORMAT . '") created_date',
                'no_of_products' => 'P.no_of_products',
                'client_status'  => 'P.client_status',
                'package_name'   => 'P.package_name',
                'quantity'       => 'P.quantity',
                'sold_quantity'  => 'P.sold_quantity',
                'remaining_quantity' => '(P.quantity - P.sold_quantity) remaining_quantity',
                'package_id'     => 'P.package_id',
                'product_ids'    => '(SELECT GROUP_CONCAT(product_id) FROM tbl_client_package_products WHERE package_id = P.package_id) AS product_ids',
            );
            
            foreach ($Params as $Param) {
                $Field .= (!empty($FieldArray[$Param]) ? ',' . $FieldArray[$Param] : '');
            }
        }
        $this->db->select('P.package_guid');
        if (!empty($Field)) $this->db->select($Field, FALSE);
        $this->db->from('tbl_client_packages P');
        if (!empty($Where['keyword'])) {
            $Where['keyword'] = trim($Where['keyword']);
            $this->db->group_start();
            $this->db->like("P.package_name", $Where['keyword']);
            $this->db->group_end();
        }
        if (!empty($Where['package_id'])) {
            $this->db->where("P.package_id", $Where['package_id']);
        }
        if (!empty($Where['package_guid'])) {
            $this->db->where("P.package_guid", $Where['package_guid']);
        }
        if (!empty($Where['client_id'])) {
            $this->db->where("P.client_id", $Where['client_id']);
        }
        if (!empty($Where['client_status'])) {
            $this->db->where("P.client_status", $Where['client_status']);
        }
        if (!empty($Where['remaining_quantity']) && $Where['remaining_quantity'] == 'greater_than_to_zero') {
            $this->db->having("remaining_quantity > ", 0);
        }
        if (!empty($Where['order_by']) && !empty($Where['sequence']) && in_array($Where['sequence'], array('ASC', 'DESC'))) {
            $this->db->order_by($Where['order_by'], $Where['sequence']);
        } else {
            $this->db->order_by('P.package_id', 'DESC');
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
                    if (in_array('products', $Params)) {
                        $Records[$key]['products'] = $this->Products_model->get_products('product_name,min_price,max_price,product_main_photo',array('product_ids' => explode(",",$Record['product_ids'])),TRUE);                    
                        unset($Records[$key]['product_ids']);
                    }
                }
                $Return['data']['records'] = $Records;
                return $Return;
            } else {
                $Record = $Query->row_array();
                if (in_array('products', $Params)) {
                    $Record['products'] = $this->Products_model->get_products('product_name,min_price,max_price,product_main_photo,category_name,product_descprition,product_gallery_images,warranty',array('product_ids' => explode(",",$Record['product_ids'])),TRUE);                    
                    unset($Record['product_ids']);
                }
                return $Record;
            }
        }
        return FALSE;
    }

    /*
      Description:  Use to get shop products
    */
    function get_shop_products($Field = '', $Where = array(), $multiRecords = FALSE, $PageNo = 1, $PageSize = 150) {
        /* Additional fields to select */
        $Params = array();
        if (!empty($Field)) {
            $Params = array_map('trim', explode(',', $Field));
            $Field = '';
            $FieldArray = array(
                'created_date'   => 'DATE_FORMAT(SP.created_date, "' . DATE_FORMAT . '") created_date',
                'product_guid'   => 'P.product_guid',
                'product_gallery_images'   => 'P.product_gallery_images',
                'warranty'   => 'P.warranty',
                'product_descprition'   => 'P.product_descprition',
                'product_name'   => 'P.product_name',
                'category_name'  => 'C.category_name',
                'min_price'      => 'P.min_price',
                'max_price'      => 'P.max_price',
                'product_main_photo' => 'IF(P.product_main_photo IS NULL,CONCAT("' . BASE_URL . '","uploads/products/","default-product.jpg"),CONCAT("' . BASE_URL . '","uploads/products/",P.product_main_photo)) AS product_main_photo',
                'client_status'   => 'SP.client_status',
                'above_budget_price' => 'SP.above_budget_price',
                'quantity' => 'SP.quantity',
                'sold_quantity' => 'SP.sold_quantity',
                'remaining_quantity' => '(SP.quantity - SP.sold_quantity) remaining_quantity'
            );
            
            foreach ($Params as $Param) {
                $Field .= (!empty($FieldArray[$Param]) ? ',' . $FieldArray[$Param] : '');
            }
        }
        $this->db->select('SP.shop_product_id');
        if (!empty($Field)) $this->db->select($Field, FALSE);
        $this->db->from('tbl_client_shop_products SP');
        if (array_keys_exist($Params, array('product_guid', 'product_name','min_price','max_price','product_main_photo','product_gallery_images'))) {
            $this->db->from('tbl_products P');
            $this->db->where("P.product_id", "SP.product_id", FALSE);
        }
        if (array_keys_exist($Params, array('category_name', 'category_guid'))) {
            $this->db->from('tbl_categories C');
            $this->db->where("C.category_id", "P.product_category_id", FALSE);
        }
        if (!empty($Where['keyword'])) {
            $Where['keyword'] = trim($Where['keyword']);
            $this->db->group_start();
            $this->db->like("P.product_name", $Where['keyword']);
            $this->db->or_like("C.category_name", $Where['keyword']);
            $this->db->group_end();
        }
        if (!empty($Where['client_id'])) {
            $this->db->where("SP.client_id", $Where['client_id']);
        }
        if (!empty($Where['product_guid'])) {
            $this->db->where("P.product_guid", $Where['product_guid']);
        }
        if (!empty($Where['main_categories'])) {
            $this->db->where_in("C.category_guid", $Where['main_categories']);
        }
        if (!empty($Where['client_status'])) {
            $this->db->where("SP.client_status", $Where['client_status']);
        }
        if (!empty($Where['quantity']) && $Where['quantity'] == 'greater_than_to_zero') {
            $this->db->where("SP.quantity > ", 0);
        }
        if (!empty($Where['remaining_quantity']) && $Where['remaining_quantity'] == 'greater_than_to_zero') {
            $this->db->having("remaining_quantity > ", 0);
        }
        if (!empty($Where['shop_category'])) {
            $this->db->where("SP.shop_category", $Where['shop_category']);
        }
        if (!empty($Where['order_by']) && !empty($Where['sequence']) && in_array($Where['sequence'], array('ASC', 'DESC','RANDOM'))) {
            $this->db->order_by($Where['order_by'], $Where['sequence']);
        } else {
            $this->db->order_by('SP.shop_product_id', 'DESC');
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
                    if (in_array('products', $Params)) {
                        $Records[$key]['products'] = $this->Products_model->get_products('product_name,min_price,max_price,product_main_photo',array('product_ids' => explode(",",$Record['product_ids'])),TRUE);                    
                        unset($Records[$key]['product_ids']);
                    }
                    if (in_array('product_gallery_images', $Params)) {
                        $Records[$key]['product_gallery_images'] = (!empty($Record['product_gallery_images'])) ? json_decode($Record['product_gallery_images'], TRUE) : array();
                    }
                }
                $Return['data']['records'] = $Records;
                return $Return;
            } else {
                $Record = $Query->row_array();
                if (in_array('products', $Params)) {
                    $Record['products'] = $this->Products_model->get_products('product_name,min_price,max_price,product_main_photo',array('product_ids' => explode(",",$Record['product_ids'])),TRUE);                    
                    unset($Record['product_ids']);
                }
                if (in_array('product_gallery_images', $Params)) {
                    $Record['product_gallery_images'] = (!empty($Record['product_gallery_images'])) ? json_decode($Record['product_gallery_images'], TRUE) : array();
                }
                return $Record;
            }
        }
        return FALSE;
    }

    /*
      Description:  Use to set shop products.
     */
    function set_shop($client_id, $Input = array()) {

        $this->db->trans_start();

        /* Delete Old Selection */
        $this->db->where('client_id',$client_id);
        $this->db->delete('tbl_client_shop_products');

        /* Insert Within the Budget Products */
        if(!empty($this->Post['within_product_ids'])){
            for ($i=0; $i < count($this->Post['within_product_ids']); $i++) { 
                $client_shop_products_array[] = array(
                                                'client_id' => $client_id, 
                                                'product_id' => $this->Post['within_product_ids'][$i],
                                                'quantity' => @$this->Post['within_budget_product_quantities'][$i],
                                                'above_budget_price' => NULL,
                                                'shop_category' => 'Within Budget',
                                                'created_date' => date('Y-m-d H:i:s')
                                            );
            }
        }

        /* Insert Above the Budget Products */
        if(!empty($this->Post['above_product_ids'])){
            for ($i=0; $i < count($this->Post['above_product_ids']); $i++) { 
                $client_shop_products_array[] = array(
                                                'client_id' => $client_id, 
                                                'product_id' => $this->Post['above_product_ids'][$i],
                                                'quantity' => @$this->Post['above_budget_product_quantities'][$i],
                                                'above_budget_price' => $this->Post['above_product_additional_prices'][$i],
                                                'shop_category' => 'Above Budget',
                                                'created_date' => date('Y-m-d H:i:s')
                                            );
            }
        }
        $this->db->insert_batch('tbl_client_shop_products', $client_shop_products_array);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    /*
      Description:  Use to set like dislike shop products.
     */
    function like_dislike_shop_products($client_id, $Input = array()) {

        $this->db->trans_start();

        /* Update Packages */
        if(!empty($this->Post['client_package_ids'])){
            for ($i=0; $i < count($this->Post['client_package_ids']); $i++) { 
                $client_packages[] = array(
                                      'package_id' => $this->Post['client_package_ids'][$i]['package_id'],
                                      'client_status' => $this->Post['client_package_ids'][$i]['client_status']
                                    );
            }
            $this->db->update_batch('tbl_client_packages',$client_packages, 'package_id'); 
        }

        /* Insert Within the Budget Products */
        if(!empty($this->Post['within_shop_products'])){
            for ($i=0; $i < count($this->Post['within_shop_products']); $i++) { 
                $client_products[] = array(
                                      'shop_product_id' => $this->Post['within_shop_products'][$i]['shop_product_id'],
                                      'client_status' => $this->Post['within_shop_products'][$i]['client_status']
                                    );
            }
        }

        /* Insert Above the Budget Products */
        if(!empty($this->Post['above_shop_products'])){
            for ($i=0; $i < count($this->Post['above_shop_products']); $i++) { 
                $client_products[] = array(
                                      'shop_product_id' => $this->Post['above_shop_products'][$i]['shop_product_id'],
                                      'client_status' => $this->Post['above_shop_products'][$i]['client_status']
                                    );
            }
        }

        /* Update Shop Products */
        if(!empty($client_products)){
            $this->db->update_batch('tbl_client_shop_products',$client_products, 'shop_product_id'); 
        }
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    /*
      Description:  Use to delete package.
    */
    function delete_package($package_guid) {
        $this->db->where('package_guid',$package_guid);
        $this->db->limit(1);
        $this->db->delete('tbl_client_packages');
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        return FALSE;
    }

}