<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
      Description:  Use to add product.
     */
    function add_product($Input = array()) {

        $insert_array = array_filter(array(
            "product_guid" => get_guid(),
            "product_name" => @ucfirst(strtolower($Input['product_name'])),
            "product_category_id" => $Input['product_category_id'],
            "min_price" => $Input['min_price'],
            "max_price" => $Input['max_price'],
            "warranty" => @$Input['warranty'],
            "product_descprition" => $Input['product_descprition'],
            "product_main_photo" => $Input['product_main_photo'],
            "product_gallery_images" => (!empty($Input['product_gallery_images'])) ? json_encode($Input['product_gallery_images']) : NULL,
            "created_date" => date('Y-m-d H:i:s')
        ));
        $this->db->insert('tbl_products', $insert_array);
        if (!$this->db->insert_id()) {
            return FALSE;
        }
        return TRUE;
    }

    /*
      Description:  Use to edit product.
     */
    function edit_product($product_id, $Input = array()) {

        $this->db->trans_start();

        $update_array = array_filter(array(
            "product_name" => @ucfirst(strtolower($Input['product_name'])),
            "product_category_id" => $Input['product_category_id'],
            "min_price" => $Input['min_price'],
            "max_price" => $Input['max_price'],
            "warranty" => @$Input['warranty'],
            "product_descprition" => $Input['product_descprition'],
            "product_main_photo" => @$Input['product_main_photo'],
            "modified_date" => date('Y-m-d H:i:s')
        ));

        /* Update Gallery Images */
        if(!empty($Input['product_gallery_images']) || !empty($Input['removed_product_gallery_images'])){
        
            /* Fetch Old Gallery Images */
            $old_gallery_images = json_decode($this->db->query('SELECT product_gallery_images FROM tbl_products WHERE product_id = '.$product_id.' LIMIT 1')->row()->product_gallery_images,TRUE);
            if(!empty($Input['removed_product_gallery_images'])){
                $old_gallery_images = array_values(array_diff($old_gallery_images,$Input['removed_product_gallery_images']));
            }
            $update_array['product_gallery_images']  = json_encode(array_merge($old_gallery_images,(!empty($Input['product_gallery_images']) ? $Input['product_gallery_images'] : array())));
        }
        $this->db->where('product_id', $product_id);
        $this->db->limit(1);
        $this->db->update('tbl_products', $update_array);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }

        /* Delete Images From Directory */
        if(!empty($Input['removed_product_gallery_images'])){
            foreach($Input['removed_product_gallery_images'] as $image){
                unlink(FCPATH.'uploads/products/'.$image);
            }
        }
        return TRUE;
    }

    /*
      Description: 	Use to get products
     */

    function get_products($Field = '', $Where = array(), $multiRecords = FALSE, $PageNo = 1, $PageSize = 150) {
        /* Additional fields to select */
        $Params = array();
        if (!empty($Field)) {
            $Params = array_map('trim', explode(',', $Field));
            $Field = '';
            $FieldArray = array(
                'created_date'  => 'DATE_FORMAT(P.created_date, "' . DATE_FORMAT . '") created_date',
                'product_id'   => 'P.product_id',
                'product_category_id'   => 'P.product_category_id',
                'product_name' => 'P.product_name',
                'min_price'    => 'P.min_price',
                'max_price'    => 'P.max_price',
                'warranty'     => 'P.warranty',
                'product_descprition'   => 'P.product_descprition',
                'product_gallery_images'   => 'P.product_gallery_images',
                'product_main_photo_file'   => 'P.product_main_photo product_main_photo_file',
                'product_main_photo' => 'IF(P.product_main_photo IS NULL,CONCAT("' . BASE_URL . '","uploads/products/","default-product.jpg"),CONCAT("' . BASE_URL . '","uploads/products/",P.product_main_photo)) AS product_main_photo',
                'category_name' => 'C.category_name',
                'category_guid' => 'C.category_guid'
            );
            
            foreach ($Params as $Param) {
                $Field .= (!empty($FieldArray[$Param]) ? ',' . $FieldArray[$Param] : '');
            }
        }
        $this->db->select('P.product_guid');
        if (!empty($Field)) $this->db->select($Field, FALSE);
        $this->db->from('tbl_products P');
        if (array_keys_exist($Params, array('category_name','category_guid'))) {
            $this->db->join('tbl_categories C', 'C.category_id = P.product_category_id', 'left');
        }
        if (!empty($Where['keyword'])) {
            $Where['keyword'] = trim($Where['keyword']);
            $this->db->group_start();
            $this->db->like("C.category_name", $Where['keyword']);
            $this->db->or_like("P.product_name", $Where['keyword']);
            $this->db->group_end();
        }
        if (!empty($Where['product_guid'])) {
            $this->db->where("P.product_guid", $Where['product_guid']);
        }
        if (!empty($Where['product_brand'])) {
            $this->db->where("P.product_brand", $Where['product_brand']);
        }
        if (!empty($Where['product_category_id'])) {
            $this->db->where("P.product_category_id", $Where['product_category_id']);
        }
        if (!empty($Where['product_id'])) {
            $this->db->where("P.product_id", $Where['product_id']);
        }
        if (!empty($Where['product_ids'])) {
            $this->db->where_in("P.product_id", $Where['product_ids']);
        }
        if (!empty($Where['shop_category'])) {
            if($Where['shop_category'] == 'Under'){
                $this->db->where("P.max_price <", $Where['employee_budget']);
            }else if($Where['shop_category'] == 'Within'){
                $this->db->where("P.min_price <=", $Where['employee_budget']);
                $this->db->where("P.max_price >=", $Where['employee_budget']);
            }else if($Where['shop_category'] == 'Above'){
                $this->db->where("P.min_price >", $Where['employee_budget']);
            }
        }
        if (!empty($Where['order_by']) && !empty($Where['sequence']) && in_array($Where['sequence'], array('ASC', 'DESC'))) {
            $this->db->order_by($Where['order_by'], $Where['sequence']);
        } else {
            $this->db->order_by('P.product_id', 'DESC');
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
                    if (in_array('product_gallery_images', $Params)) {
                        $Records[$key]['product_gallery_images'] = (!empty($Record['product_gallery_images'])) ? json_decode($Record['product_gallery_images'], TRUE) : array();
                    }
                    if (in_array('shop_product_info', $Params)) {
                        $query = $this->db->query('SELECT shop_product_id,above_budget_price,client_status,quantity FROM tbl_client_shop_products WHERE client_id = '.$Where['client_id'].' AND product_id = '.$Record['product_id'].' LIMIT 1');
                        $Records[$key]['shop_product_info'] = ($query->num_rows() > 0) ? $query->row_array() : array();
                    }
                }
                $Return['data']['records'] = $Records;
                return $Return;
            } else {
                $Record = $Query->row_array();
                if (in_array('product_gallery_images', $Params)) {
                    $Record['product_gallery_images'] = (!empty($Record['product_gallery_images'])) ? json_decode($Record['product_gallery_images'], TRUE) : array();
                }
                if (in_array('shop_product_info', $Params)) {
                    $query = $this->db->query('SELECT shop_product_id,above_budget_price,client_status,quantity FROM tbl_client_shop_products WHERE client_id = '.$Where['client_id'].' AND product_id = '.$Record['product_id'].' LIMIT 1');
                    $Record['shop_product_info'] = ($query->num_rows() > 0) ? $query->row_array() : array();
                }
                return $Record;
            }
        }
        return FALSE;
    }
    
    /*
      Description:  Use to delete product.
    */
    function delete_product($product_guid) {
        $this->db->where('product_guid',$product_guid);
        $this->db->limit(1);
        $this->db->delete('tbl_products');
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        return FALSE;
    }

    /*
      Description:  Use to upload products.
     */
    function upload_products($Input = array()) {
       /* Set max exceution time */
       ini_set('max_execution_time', 1800); // 30 minutes

       /* Set memory limit */
       ini_set('memory_limit', '1024M'); 

       $error_array = array();
       $total_success_records = 0;
       
       /* Tasks */
       foreach($Input['products_data'] as $key => $product){
        /* Check Already Insert */
        if( empty(trim($product[0]))){
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('product_name_not_empty');
            continue;
        }

        if( empty(trim($product[1]))){
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('product_category_not_empty');
            continue;
        }

        if( empty(trim($product[2]))){
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('product_min_price_not_empty');
            continue;
        }

        if( empty(trim($product[3]))){
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('product_max_price_not_empty');
            continue;
        }
        
        if((float) trim($product[2]) >= (float) trim($product[3])){
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('product_max_price_should_not_less_to_min_price');
            continue;
        }

        if( !empty(trim($product[1]))){
            $query = $this->db->query('SELECT category_id FROM tbl_categories WHERE category_name = "'.$product[1].'" LIMIT 1');
            if($query->num_rows() > 0){
                $product_category_id = $query->result_array()[0]['category_id'];
            } else {
                $insert_array = array_filter(array(
                    "category_guid" => get_guid(),
                    "category_name" => @ucfirst(strtolower($product[1])),
                    "created_date" => date('Y-m-d H:i:s')
                ));
                $this->db->insert('tbl_categories', $insert_array);
                $product_category_id = $this->db->insert_id();
            }
        }

        $mainImage = $product[6];
        
        if(!empty(trim($mainImage))){
            $main_photo = save_file_from_server($mainImage,'products');
        } else {
            $main_photo = "default-product.jpg";
        }
        $gallary_image = [];
        if(isset($product[7]) && !empty($product[7])) {
            $gallary_image[] = save_file_from_server($product[7],'products');
        }
        if(isset($product[8]) && !empty($product[8])) {
            $gallary_image[] = save_file_from_server($product[8],'products');
        }
        if(isset($product[9]) && !empty($product[9])) {
            $gallary_image[] = save_file_from_server($product[9],'products');
        }
        if(isset($product[10]) && !empty($product[10])) {
            $gallary_image[] = $gallary_image_1 = save_file_from_server($product[10],'products');; 
        }
        if(isset($product[11]) && !empty($product[11])) {
            $gallary_image[] = save_file_from_server($product[11],'products');
        }
        if(isset($product[12]) && !empty($product[12])) {
            $gallary_image[] = save_file_from_server($product[12],'products');
        }
        if(isset($product[13]) && !empty($product[13])) {
            $gallary_image[] = save_file_from_server($product[13],'products');
        }
        if(isset($product[14]) && !empty($product[14])) {
            $gallary_image[] = save_file_from_server($product[14],'products');
        }
        if(isset($product[15]) && !empty($product[15])) {
            $gallary_image[] = save_file_from_server($product[15],'products'); 
        }

        if(count($gallary_image) > 10) {
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('product_gallery_images_10_limit');
            continue;
        }

        $gallary_image = array_filter($gallary_image);     

        /* Insert Task */
        $insert_array = array_filter(array(
            "product_guid" => get_guid(),
            "product_category_id" => $product_category_id,
            "product_name" => $product[0],
            "product_descprition" => $product[5],
            "product_main_photo" => $main_photo,
            "min_price" => $product[2],
            "max_price" => $product[3],
            "warranty" => $product[4],
            "product_gallery_images" => json_encode($gallary_image, true),
            "created_date" => date('Y-m-d H:i:s')
        ));
        $this->db->insert('tbl_products', $insert_array);
        if($this->db->insert_id()){
          $total_success_records = $total_success_records + 1;
        }else{
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('error_occured');
        }
       }
       return array('is_error' => ((!empty($error_array)) ? 1 : 0), 'is_success' => ((!empty($total_success_records)) ? 1 : 0), 'total_success_records' => $total_success_records ,'error_array' => $error_array);
    }
}
