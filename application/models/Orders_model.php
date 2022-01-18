<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Orders_model extends CI_Model {

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

    function get_orders($Field = '', $Where = array(), $multiRecords = FALSE, $PageNo = 1, $PageSize = 150) {
        /* Additional fields to select */
        $Params = array();
        if (!empty($Field)) {
            $Params = array_map('trim', explode(',', $Field));
            $Field = '';
            $FieldArray = array(
                'created_date'  => 'DATE_FORMAT(O.created_date, "' . DATE_FORMAT . '") created_date',
                'cancelled_date' => 'IF(O.cancelled_date IS NULL,"",DATE_FORMAT(O.cancelled_date, "' . DATE_FORMAT . '")) cancelled_date',
                'order_id'   => 'O.order_id',
                'user_id'   => 'O.user_id',
                'amount'    => 'O.order_amount',
                'used_credits'    => 'O.used_credits',
                'order_status'    => 'O.order_status',
                'payment_status'    => 'O.payment_status',
                'credit_card_amount'    => 'O.credit_card_amount',
                'employee_name'    => 'concat(E.first_name," ",E.last_name) as employee_name',
                'employee_email'    => 'E.email employee_email',
                'employee_phone_number'    => 'E.phone_number employee_phone_number',
                'client_name'    => 'concat(C.first_name," ",C.last_name) as client_name',
                'product_count' => '(select count(order_id) from tbl_order_details where order_id = (O.order_id)) as product_count',
                // 'order_address' => 'O.order_address',
                'pickup_address' => 'O.pickup_address',
                'city' => 'O.city',
                'apartment' => 'O.apartment',
                'street_house' => 'O.street_house',
                'postal_code' => 'O.postal_code',
                'address_mode' => 'O.address_mode'
            );
            
            foreach ($Params as $Param) {
                $Field .= (!empty($FieldArray[$Param]) ? ',' . $FieldArray[$Param] : '');
            }
        }
        $this->db->select('O.order_guid');
        if (!empty($Field)) $this->db->select($Field, FALSE);
        $this->db->from('tbl_orders O');
        $this->db->join('tbl_users E', 'E.user_id = O.user_id');
        $this->db->join('tbl_users C', 'E.client_id = C.user_id','left');
        if (!empty($Where['keyword'])) {
            $Where['keyword'] = trim($Where['keyword']);
            $this->db->group_start();
            $this->db->group_end();
        }
        if (!empty($Where['order_guid'])) {
            $this->db->where("O.order_guid", $Where['order_guid']);
        }

        if (!empty($Where['order_id'])) {
            $this->db->where("O.order_id", $Where['order_id']);
        }

        if (!empty($Where['user_id'])) {
            $this->db->where("O.user_id", $Where['user_id']);
        }

        if (!empty($Where['payment_id'])) {
            $this->db->where("O.payment_id", $Where['payment_id']);
        }

        if (!empty($Where['client_id'])) {
            $this->db->where("O.user_id IN (SELECT user_id FROM tbl_users WHERE user_type_id = 3 AND client_id = ".$Where['client_id'].")", null, false);
        }

        if (!empty($Where['payment_status'])) {
            $this->db->where_in("O.payment_status", $Where['payment_status']);
        }

        if (!empty($Where['order_status'])) {
            $this->db->where_in("O.order_status", $Where['order_status']);
        }
        
        if (array_keys_exist($Params, array('client_first_name','client_last_name','client_guid'))) {
            $this->db->join('tbl_users C', 'C.user_id = U.client_id', 'left');
        }

        if (!empty($Where['order_by']) && !empty($Where['sequence']) && in_array($Where['sequence'], array('ASC', 'DESC'))) {
            $this->db->order_by($Where['order_by'], $Where['sequence']);
        } else {
            $this->db->order_by('O.order_id', 'DESC');
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
                    if (in_array('order_product_details', $Params)) {
                        $query = $this->db->query('SELECT * FROM tbl_order_details WHERE order_id = '.$Record['order_id']);
                        if($query->num_rows() > 0){
                            $Records[$key]['order_product_details'] = array();
                            foreach($query->result_array() as $value){
                                $row = array(
                                            'type' => $value['type'], 
                                            'product_package_name' => $value['product_package_name'],
                                            'quantity' => $value['quantity'],
                                            'amount' => $value['amount']
                                        );
                                if($value['type'] == 'Package'){
                                    $row = array_merge($row,$this->Shop_model->get_packages('products,product_ids,package_id',array('package_id' => $value['product_package_id'])));
                                }else{ // Product
                                    $row = array_merge($row,$this->Products_model->get_products('category_name,product_descprition,product_main_photo,product_id',array('product_id' => $value['product_package_id'])));
                                }
                                array_push($Records[$key]['order_product_details'],$row);
                            }
                        }
                    }
                }
                $Return['data']['records'] = $Records;
                return $Return;
            } else {
                $Record = $Query->row_array();
                if (in_array('order_product_details', $Params)) {
                    $query = $this->db->query('SELECT * FROM tbl_order_details WHERE order_id = '.$Record['order_id']);
                    if($query->num_rows() > 0){
                        $Record['order_product_details'] = array();
                        foreach($query->result_array() as $value){
                            $row = array(
                                        'type' => $value['type'], 
                                        'product_package_name' => $value['product_package_name'],
                                        'quantity' => $value['quantity'],
                                        'amount' => $value['amount']
                                    );
                            if($value['type'] == 'Package'){
                                $row = array_merge($row,$this->Shop_model->get_packages('products,product_ids,package_id',array('package_id' => $value['product_package_id'])));
                            }else{ // Product
                                $row = array_merge($row,$this->Products_model->get_products('category_name,product_descprition,product_main_photo,product_id',array('product_id' => $value['product_package_id'])));
                            }
                            array_push($Record['order_product_details'],$row);
                        }
                    }
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
      Description:  to get order details.
    */
    function get_order_details($order_id) {
        $this->db->where('order_id',$order_id);
        $this->db->select('*');
        $this->db->from('tbl_order_details');
        $Query = $this->db->get();
        if($Query->num_rows() > 0){
            $Record = $Query->result_array();
            return $Record;
        }
        return [];
    }
    
}
