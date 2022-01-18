<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Employee_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
      Description:  Use to add product/package into cart.
    */
    function add_to_cart($Input = array()) {

        $cart_total_items = $this->cart->total_items();
        $employee_budget = $this->session->userdata('webuserdata')['employee_budget'];
        $this->cart->product_name_rules = '\d\D';
        if($Input['type'] == 'package'){

            /* To Get Package Details */
            $package = $this->Shop_model->get_packages('package_name,no_of_products,product_ids,products,package_id',array('package_id' => $Input['package_id']));
            $data = array(
                'id'      => $Input['guid'],
                'qty'     => (empty($Input['quantity'])) ? 1 : $Input['quantity'],
                'price'   => $employee_budget,
                'name'    => $package['package_name'],
                'options' => array('type' => $Input['type'], 'no_of_products' => $package['no_of_products'], 'package_id' => $package['package_id'], 'product_main_photos' => array_column($package['products']['data']['records'], 'product_main_photo'),'shop_category' => 'Within Budget', 'above_budget_price' => 0)
            );
        }else{

            /* To Get Product Details */
            $query = $this->db->query('SELECT P.product_id,P.product_name,P.product_main_photo, CSP.shop_category, CSP.above_budget_price FROM tbl_client_shop_products CSP, tbl_products P WHERE CSP.product_id = P.product_id AND CSP.product_id = '.$Input['product_id'].' AND CSP.client_id = '.$this->session->userdata('webuserdata')['client_id'].' LIMIT 1');
            $data = array(
                'id'      => $Input['guid'],
                'qty'     => (empty($Input['quantity'])) ? 1 : $Input['quantity'],
                'price'   => ($query->row()->shop_category == 'Within Budget') ? $employee_budget : ($employee_budget + $query->row()->above_budget_price),
                'name'    => $query->row()->product_name,
                'options' => array('type' => $Input['type'], 'product_id' => $query->row()->product_id, 'product_main_photo' => $query->row()->product_main_photo,'shop_category' => $query->row()->shop_category, 'above_budget_price' => (int) $query->row()->above_budget_price)
            );
        }
        if($this->cart->insert($data)){
            return TRUE;
        }
        return FALSE;
    }

    /*
      Description:  Use to upload employees.
     */
    function upload_employees($Input = array(),$client_id) {
       /* Set max exceution time */
       ini_set('max_execution_time', 1800); // 30 minutes

       /* Set memory limit */
       ini_set('memory_limit', '1024M'); 

       $error_array = array();
       $total_success_records = 0;
       
       /* Tasks */
       foreach($Input['employees_data'] as $key => $employees){
        /* Check Already Insert */
        if( empty(trim($employees[0]))){
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('employee_first_name_not_empty');
            continue;
        }

        if( empty(trim($employees[1]))){
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('employee_last_name_not_empty');
            continue;
        }

        if( empty(trim($employees[2]))){
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('employee_mobile_number_not_empty');
            continue;
        }

        if( empty(trim($employees[2])) && !is_numeric(trim($employees[2]))){
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('employee_mobile_number_numeric');
            continue;
        }

        if( !empty(trim($employees[2]))){
            $query = $this->db->query('SELECT phone_number FROM tbl_users WHERE phone_number = "'.trim($employees[2]).'" LIMIT 1');
            if($query->num_rows() > 0){
                $error_array[] = lang('row_no').' '.($key+2).' '.lang('phone_number_already_exist');
            continue;
            }
        }

        if( empty(trim($employees[3]))){
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('employee_email_not_empty');
            continue;
        }
        
        if( !empty(trim($employees[3]))){
            $query = $this->db->query('SELECT phone_number FROM tbl_users WHERE phone_number = "'.trim($employees[3]).'" LIMIT 1');
            if($query->num_rows() > 0){
                $error_array[] = lang('row_no').' '.($key+2).' '.lang('email_id_already_exist');
            continue;
            }
        }

        /* Insert Task */
        $insert_array = array_filter(array(
            "first_name" => @ucfirst(strtolower($employees[0])),
            "last_name" => @ucfirst(strtolower($employees[1])),
            "email" => @$employees[3],
            "user_guid" => get_guid(),
            "parent_user_id" => $this->session_user_id,
            "client_id" => $client_id,
            "phone_number" => @$employees[2],
            "user_type_id" => 3,
            "user_status" => 'Verified',
            "created_date" => date('Y-m-d H:i:s')
        ));
        if(!empty(trim($employees[4]))){
            $insert_array['password'] = md5(trim($employees[4]));
        }
        $this->db->insert('tbl_users', $insert_array);

        if($this->db->insert_id()){
          $total_success_records = $total_success_records + 1;
        }else{
            $error_array[] = lang('row_no').' '.($key+2).' '.lang('error_occured');
        }
       }
       return array('is_error' => ((!empty($error_array)) ? 1 : 0), 'is_success' => ((!empty($total_success_records)) ? 1 : 0), 'total_success_records' => $total_success_records ,'error_array' => $error_array);
    }

    /*
      Description:  Use to create order.
     */
    function create_order($Input = array(),$user_id) {

        $this->db->trans_start();

        /* To Get User Credits */
        $user_details = $this->Users_model->get_users('total_credits,first_name,last_name,phone_number,email',array('user_id' => $user_id));
        $order_amount = (array_sum(array_column($Input['cart_data'],'subtotal')) - $this->session->userdata('webuserdata')['employee_budget']);
        $credits_minus = 0;

        /* Insert Order */
        $insert_array = array(
                            'order_guid' => get_guid(),
                            'user_id' => $user_id,
                            'order_amount' => $order_amount,
                            'address_mode' => $Input['address_mode'],
                            'created_date'  => date('Y-m-d H:i:s'),
                            'order_status' => 'Created'
                        );

        if($user_details['total_credits'] > 0 && $order_amount > 0){
            $credits_minus = ($user_details['total_credits'] > $order_amount) ? $order_amount : $user_details['total_credits'];
            $insert_array['used_credits'] = $credits_minus;
        }
        $insert_array['credit_card_amount'] = $order_amount - $credits_minus;

        if($Input['address_mode'] == 'Pickup'){
            $insert_array['pickup_address'] = $Input['pickup_address'];
        }else{
            $insert_array['city'] = $Input['city'];
            $insert_array['apartment'] = @$Input['apartment'];
            $insert_array['street_house'] = $Input['street_house'];
            $insert_array['postal_code'] = @$Input['postal_code'];
        }
        $insert_array['payment_status'] = ($insert_array['credit_card_amount'] > 0) ? 'Pending' : 'Success';
        $this->db->insert('tbl_orders', $insert_array);
        $order_id = $this->db->insert_id();

        /* Update Credit Balance */
        if($credits_minus > 0 && $insert_array['credit_card_amount'] == 0){
            $this->db->where('user_id', $user_id);
            $this->db->where('total_credits >=', $credits_minus);
            $this->db->limit(1);
            $this->db->set('total_credits', 'total_credits-'.$credits_minus, FALSE);
            $this->db->update('tbl_users');
        }

        /* Insert Order Details */
        $i = 1;
        foreach($Input['cart_data'] as $rowid => $value){
            $order_array[] = array(
                                'order_id' => $order_id,
                                'type' => $value['options']['type'],
                                'product_package_id' => ($value['options']['type'] == 'product') ? $value['options']['product_id'] : $value['options']['package_id'],
                                'product_package_name' => $value['name'],
                                'quantity' => $value['qty'],
                                'amount' => $value['price'],
                                'amount' => showCartPrice($i++,$rowid),
                            );
        }
        $this->db->insert_batch('tbl_order_details', $order_array);

        /* Update Products Sold Quantity */
        if($insert_array['credit_card_amount'] == 0){
            foreach($Input['cart_data'] as $rowid => $value){
                if($value['options']['type'] == 'package'){
                    $this->db->where('package_id', $value['options']['package_id']);
                    $this->db->limit(1);
                    $this->db->set('sold_quantity', 'sold_quantity+'.$value['qty'], FALSE);
                    $this->db->update('tbl_client_packages');
                }else{
                    $this->db->where('product_id', $value['options']['product_id']);
                    $this->db->where('client_id', $this->session->userdata('webuserdata')['client_id']);
                    $this->db->limit(1);
                    $this->db->set('sold_quantity', 'sold_quantity+'.$value['qty'], FALSE);
                    $this->db->update('tbl_client_shop_products');
                }
            }
        }
       
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }

        if($insert_array['credit_card_amount'] == 0){

            /* Get Client Details */
            $client_details = $this->db->query('SELECT first_name,last_name,email FROM tbl_users WHERE user_id = '.$this->session->userdata('webuserdata')['client_id'].' LIMIT 1')->row_array();

            /* Generate PDF */
            $pdf_details = $client_details;
            $pdf_details['cart_data'] = $Input['cart_data'];
            $pdf_details['employee_name'] = $user_details['first_name']." ".$user_details['last_name'];
            $pdf_details['employee_email'] = $user_details['email'];
            $pdf_details['phone_number'] = $user_details['phone_number'];
            $pdf_details['address_mode'] = $Input['address_mode'];
            if($Input['address_mode'] == 'Pickup'){
                $pdf_details['pickup_address'] = $Input['pickup_address'];
            }else{
                $pdf_details['city'] = $Input['city'];
                $pdf_details['apartment'] = @$Input['apartment'];
                $pdf_details['street_house'] = $Input['street_house'];
                $pdf_details['postal_code'] = @$Input['postal_code'];
            }
            $pdf_details['order_id'] = $order_id;
            $pdf_details['order_datetime'] = $insert_array['created_date'];
            $pdf_details['company_name'] = $this->session->userdata('webuserdata')['client_configs']['company_name'];
            $pdf_details['contact_name'] = $this->session->userdata('webuserdata')['client_configs']['contact_name'];
            $pdf_details['contact_number'] = $this->session->userdata('webuserdata')['client_configs']['contact_number'];
            $pdf_details['company_logo'] = $this->session->userdata('webuserdata')['client_configs']['company_logo'];
            $pdf_details['theme_color'] = $this->session->userdata('webuserdata')['client_configs']['theme_color'];

            /* Send Email To Client */
            $order_heading = lang('new_order').' ('.$pdf_details['order_id'].') '.lang('generated').' !!';
            send_smtp_mail(
                    $user_details['email'],
                    lang('congratulation_gift')." (".$pdf_details['company_name'].") ".lang('by_galtex'),
                    $this->load->view('front/invoice',array('details' => $pdf_details),true)
                    );

            /* Destroy Cart */
            $this->cart->destroy();
            return array('is_payment' => 0, 'order_id' => $order_id);
        }else{

            /* Payment Gateway Integration */
            // $total_amount_in_cent = $order_amount * 100;
            $total_amount_in_cent = 1 * 100;
            $products_line = '';
            $i = 0;
            foreach($Input['cart_data'] as $rowid => $value){
                if($i == 0){
                    if($value['qty'] > 1){
                        $products_line .= $value['id'].","; // sku
                        $products_line .= urlencode($value['name']).","; // description/product_name
                        $products_line .= number_format($value['options']['above_budget_price'],2).","; // amountPerUnit
                        $products_line .= "1,"; // quantity
                        $products_line .= number_format($value['options']['above_budget_price'],2); // totalAmount

                        $products_line .= '#';
                        $products_line .= $value['id'].","; // sku
                        $products_line .= urlencode($value['name']).","; // description/product_name
                        $products_line .= number_format($value['price'],2).","; // amountPerUnit
                        $products_line .= (int) ($value['qty']-1).","; // quantity
                        $products_line .= number_format((($value['qty']-1) * $value['price']),2); // totalAmount
                    }else{
                        $products_line .= $value['id'].","; // sku
                        $products_line .= urlencode($value['name']).","; // description/product_name
                        $products_line .= number_format($value['options']['above_budget_price'],2).","; // amountPerUnit
                        $products_line .= "1,"; // quantity
                        $products_line .= number_format($value['options']['above_budget_price'],2); // totalAmount
                    }
                }else{
                    $products_line .= '#';
                    $products_line .= $value['id'].","; // sku
                    $products_line .= urlencode($value['name']).","; // description/product_name
                    $products_line .= number_format($value['price'],2).","; // amountPerUnit
                    $products_line .= (int) $value['qty'].","; // quantity
                    $products_line .= number_format($value['subtotal'],2); // totalAmount
                }
                $i++;
            }

            $post_fields = '<?xml version="1.0" encoding="utf-8"?>';
            $post_fields .= '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">';
            $post_fields .= '<soap:Body><SendParamToCredit2000ProProductsLine xmlns="http://tempuri.org/">';
            $post_fields .= '<parametrPro><tz_Number>'.$user_id.'</tz_Number><club>0</club><confirmation_Source>0</confirmation_Source>';
            $post_fields .= '<action_Type>4</action_Type><card_Reader>2</card_Reader><client_Name></client_Name>';
            $post_fields .= '<host>'.base_url().'employees/payment_response'.'</host><company_Key>'.CREDIT2000_COMPANY_KEY.'</company_Key>';
            $post_fields .= '<stars>0</stars><reader_Data></reader_Data><currency>1</currency><total_Pyment>'.$total_amount_in_cent.'</total_Pyment>';
            $post_fields .= '<purchase_Type>1</purchase_Type><uID></uID><vendor_Name>'.CREDIT2000_CUSTOMER_ID.'</vendor_Name>';
            $post_fields .= '<product_Id>'.$order_id.'</product_Id><return_Code>123</return_Code><fixed_Amount>0</fixed_Amount>';
            $post_fields .= '<payments_Number>1</payments_Number><first_Payment>'.$total_amount_in_cent.'</first_Payment><Approve>000</Approve>';
            $post_fields .= '<ValidDate></ValidDate><StyleSheet></StyleSheet><Lang>HE</Lang><product_description></product_description>';
            $post_fields .= '<remarks></remarks><email>'.$this->session->userdata('webuserdata')['email'].'</email><phone></phone><with_invoice>1</with_invoice>';
            $post_fields .= '</parametrPro><ProductsLine>'.$products_line.'</ProductsLine></SendParamToCredit2000ProProductsLine>';
            $post_fields .= '</soap:Body></soap:Envelope>';

            /* Fire Curl */
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => CREDIT2000_HOST."/PCI_EMV_VER1/wcf/wsCredit2000.asmx",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $post_fields,
              CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: text/xml"
              ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if ($err) {
              echo "cURL Error #:" . $err;die;
            } else {
              if($statusCode != 200){

                /* Update Payment Status */
                $this->db->where('order_id', $order_id);
                $this->db->limit(1);
                $this->db->update('tbl_orders',array('payment_status' => 'Failed'));
                return FALSE;
              }else{
                $json_resp = decodeSoapXml($response);
                $payment_url = $json_resp['Body']['SendParamToCredit2000ProProductsLineResponse']['SendParamToCredit2000ProProductsLineResult'];
                $parts = parse_url($payment_url);
                parse_str($parts['query'], $query); 
                
                /* Update Payment ID */
                $this->db->where('order_id', $order_id);
                $this->db->limit(1);
                $this->db->update('tbl_orders',array('payment_id' => $query['params']));
                return array('is_payment' => 1, 'payment_url' => $payment_url);
              }
            }
        }
    }

    /*
      Description:  Use to update order.
     */
    function update_order($payment_id,$user_id) {

        /* Get Order Details */
        $order_details = $this->Orders_model->get_orders('order_id,used_credits,credit_card_amount,order_status,payment_status,order_product_details,created_date,employee_name,employee_phone_number,employee_email,pickup_address,city,apartment,street_house,postal_code,address_mode',array('payment_id' => $payment_id));
        if(!$order_details){
            return array('status' => 0, 'message' => lang('order_details_not_found'));
        }else if($order_details['order_status'] != 'Created'){
            return array('status' => 0, 'message' => lang('error_occured'));
        }else if($order_details['payment_status'] != 'Pending'){
            return array('status' => 0, 'message' => lang('error_occured'));
        }else{

            /* Fire Curl (Get Transaction Details) */
            $post_fields  = '<?xml version="1.0" encoding="utf-8"?>';
            $post_fields .= '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">';
            $post_fields .= '<soap:Body><getTokenAndApproveWithParams xmlns="http://tempuri.org/"><uid>'.$payment_id.'</uid>';
            $post_fields .= '</getTokenAndApproveWithParams></soap:Body></soap:Envelope>';
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => CREDIT2000_HOST."/PCI_EMV_VER1/wcf/wsCredit2000.asmx",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $post_fields,
              CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: text/xml"
              ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if ($err) {
              echo "cURL Error #:" . $err;die;
            } else {
               $json_resp = decodeSoapXml($response);
               $approval_code  = @$json_resp['Body']['getTokenAndApproveWithParamsResponse']['getTokenAndApproveWithParamsResult']['Approve'];
              
                /* Update Failed Order Status */
                if(empty($approval_code) || $approval_code == '000'){
                    $this->db->where('order_id', $order_details['order_id']);
                    $this->db->limit(1);
                    $this->db->update('tbl_orders',array('payment_status' => 'Failed', 'payment_response' => json_encode($json_resp, JSON_UNESCAPED_UNICODE)));
                    return array('status' => 0, 'message' => lang('payment_failed')); 
                }
            }

            $this->db->trans_start();

            /* Update Credit Balance */
            if($order_details['used_credits'] > 0){
                $this->db->where('user_id', $user_id);
                $this->db->where('total_credits >=', $order_details['used_credits']);
                $this->db->limit(1);
                $this->db->set('total_credits', 'total_credits-'.$order_details['used_credits'], FALSE);
                $this->db->update('tbl_users');
            }

            /* Update Order Status */
            $this->db->where('order_id', $order_details['order_id']);
            $this->db->limit(1);
            $this->db->update('tbl_orders',array('payment_status' => 'Success', 'payment_response' => json_encode($json_resp, JSON_UNESCAPED_UNICODE)));

            /* Update Products Sold Quantity */
            foreach($order_details['order_product_details'] as $value){
                if($value['type'] == 'Package'){
                    $this->db->where('package_id', $value['package_id']);
                    $this->db->limit(1);
                    $this->db->set('sold_quantity', 'sold_quantity-'.$value['quantity'], FALSE);
                    $this->db->update('tbl_client_packages');
                }else{
                    $this->db->where('product_id', $value['product_id']);
                    $this->db->where('client_id', $this->session->userdata('webuserdata')['client_id']);
                    $this->db->limit(1);
                    $this->db->set('sold_quantity', 'sold_quantity-'.$value['quantity'], FALSE);
                    $this->db->update('tbl_client_shop_products');
                }
            }

            /* Get Client Details */
            $client_details = $this->db->query('SELECT first_name,last_name,email FROM tbl_users WHERE user_id = '.$this->session->userdata('webuserdata')['client_id'].' LIMIT 1')->row_array();

            /* Generate PDF */
            $pdf_details = $client_details;
            $pdf_details['cart_data'] = $this->cart->contents();
            $pdf_details['employee_name'] = $order_details['employee_name'];
            $pdf_details['employee_email'] = $order_details['employee_email'];
            $pdf_details['phone_number'] = $order_details['employee_phone_number'];
            $pdf_details['address_mode'] = $order_details['address_mode'];
            if($order_details['address_mode'] == 'Pickup'){
                $pdf_details['pickup_address'] = $order_details['pickup_address'];
            }else{
                $pdf_details['city'] = $order_details['city'];
                $pdf_details['apartment'] = $order_details['apartment'];
                $pdf_details['street_house'] = $order_details['street_house'];
                $pdf_details['postal_code'] = $order_details['postal_code'];
            }
            $pdf_details['order_id']  = $order_details['order_id'];
            $pdf_details['order_datetime'] = $order_details['created_date'];
            $pdf_details['company_name'] = $this->session->userdata('webuserdata')['client_configs']['company_name'];
            $pdf_details['contact_name'] = $this->session->userdata('webuserdata')['client_configs']['contact_name'];
            $pdf_details['contact_number'] = $this->session->userdata('webuserdata')['client_configs']['contact_number'];
            $pdf_details['company_logo'] = $this->session->userdata('webuserdata')['client_configs']['company_logo'];
            $pdf_details['theme_color'] = $this->session->userdata('webuserdata')['client_configs']['theme_color'];

            /* Send Email To Client */
            $order_heading = lang('new_order').' ('.$pdf_details['order_id'].') '.lang('generated').' !!';
            send_smtp_mail(
                    $order_details['employee_email'],
                    lang('congratulation_gift')." (".$pdf_details['company_name'].") ".lang('by_galtex'),
                    $this->load->view('front/invoice',array('details' => $pdf_details),true)
                    );

            /* Destroy Cart */
            $this->cart->destroy();

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                return array('status' => 0, 'message' => lang('error_occured'));
            }
            return array('status' => 1, 'message' => lang('thank_you_order_placed'));
        }
    }

    /*
      Description:  Use to cancel order.
     */
    function cancel_order($Input = array()) {

        $this->db->trans_start();

        /* Cancel Order */
        $this->db->where('order_id', $Input['order_id']);
        $this->db->limit(1);
        $this->db->update('tbl_orders', array('order_status' => 'Cancelled', 'cancelled_date' => date('Y-m-d H:i:s')));

        /* Update Credits */
        if($Input['order_amount'] > 0){
            $this->db->where('user_id', $Input['user_id']);
            $this->db->limit(1);
            $this->db->set('total_credits', 'total_credits+'.$Input['order_amount'], FALSE);
            $this->db->update('tbl_users');
        }

        /* Update Products Sold Quantity */
        foreach($Input['order_product_details'] as $value){
            if($value['type'] == 'Package'){
                $this->db->where('package_id', $value['package_id']);
                $this->db->limit(1);
                $this->db->set('sold_quantity', 'sold_quantity-'.$value['quantity'], FALSE);
                $this->db->update('tbl_client_packages');
            }else{
                $this->db->where('product_id', $value['product_id']);
                $this->db->where('client_id', $this->session->userdata('webuserdata')['client_id']);
                $this->db->limit(1);
                $this->db->set('sold_quantity', 'sold_quantity-'.$value['quantity'], FALSE);
                $this->db->update('tbl_client_shop_products');
            }
        }
       
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }
        return TRUE;        
    }
}