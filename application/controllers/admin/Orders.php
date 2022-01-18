<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as admin products management
 * @package   CodeIgniter
 * @category  Controller
 * @author    Sorav Garg (soravgarg123@gmail.com/+919074939905)
 */

class Orders extends Admin_Controller_Secure { 

	function __construct() {
        parent::__construct();    
        $this->load->model('Categories_model');
        $this->load->model('Orders_model');
        $this->load->model('Shop_model');
        $this->load->model('Products_model');
    }

	/**
	 * Function Name: list
	 * Description:   To view orders list
	*/
	public function list()
	{
		if($this->user_type_id != 1){
        	$this->session->set_flashdata('error',lang('access_denied'));
        	redirect('admin/dashboard');
        }
		$data['title'] = lang('orders');
		$data['module']= "orders";
		$data['css']   = array(
							'../../assets/admin/css/dataTables.bootstrap.min.css'
						);
		$data['js']    = array(
							'../../assets/admin/js/jquery.dataTables.min.js',
							'../../assets/admin/js/dataTables.bootstrap.min.js',
							'../../assets/admin/js/custom/order.js'
						);

		/* Get Orders */
		$data['orders'] = $this->Orders_model->get_orders('created_date,employee_name,amount,client_name,used_credits,credit_card_amount,address_mode,order_status,payment_status',array('payment_status' => array('Success', 'Failed')),TRUE);
		$this->template->load('default', 'orders/list',$data);
	}

	/**
	 * Function Name: details
	 * Description:   To view orders details
	*/
	public function details($order_guid) 
	{
		if($this->user_type_id != 1){
        	$this->session->set_flashdata('error',lang('access_denied'));
        	redirect('admin/dashboard');
        }

		$data['title']  = lang('view_order_details');
		$data['module'] = "orders";

		/*  To check order guid */	
		$query = $this->db->query('SELECT order_id FROM tbl_orders WHERE order_guid = "'.$order_guid.'" LIMIT 1');
		if($query->num_rows() == 0){
			redirect('/admin/orders/list');
		}
		$order_id = $query->row()->order_id;

		/* To Get Order Details */
        $data['details'] = $this->Orders_model->get_orders('order_id,created_date,employee_name,client_name,amount,used_credits,credit_card_amount,address_mode,pickup_address,city,apartment,street_house,postal_code,order_status,payment_status,cancelled_date,order_product_details',array('order_id' => $order_id));
        $this->template->load('default', 'orders/view-details',$data);
	}
}

/* End of file Products.php */
/* Location: ./application/controllers/admin/Products.php */
