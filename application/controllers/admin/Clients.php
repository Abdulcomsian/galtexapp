<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as admin clients management
 * @package   CodeIgniter
 * @category  Controller
 * @author    Sorav Garg (soravgarg123@gmail.com/+919074939905)
 */

class Clients extends Admin_Controller_Secure { 

	function __construct() {
        parent::__construct();    
        if($this->user_type_id != 1){
        	$this->session->set_flashdata('error',lang('access_denied'));
        	redirect('admin/dashboard');
        }
        $this->load->model('Orders_model');
        $this->load->model('Shop_model');
        $this->load->model('Products_model');
    }

	/**
	 * Function Name: list
	 * Description:   To view clients list
	*/
	public function list()
	{
		$data['title'] = lang('clients');
		$data['module']= "clients";
		$data['css']   = array(
							'../../assets/admin/css/dataTables.bootstrap.min.css'
						);
		$data['js']    = array(
							'../../assets/admin/js/jquery.dataTables.min.js',
							'../../assets/admin/js/dataTables.bootstrap.min.js',
							'../../assets/admin/js/custom/clients.js'
						);	

		/* Get Clients */
		$data['members'] = $this->Users_model->get_users('user_id,client_configs,email,employee_budget,delivery_method,user_status,created_date',array('order_by' => 'first_name', 'sequence' => 'ASC', 'user_type_id' => 2),TRUE);
		$this->template->load('default', 'clients/list',$data);
	}

	/**
	 * Function Name: add_new
	 * Description:   To add new client
	*/
	public function add_new()
	{
		$data['title']  = lang('add_new_client');
		$data['module'] = "clients";

		$data['css']   = array(
							'../../assets/admin/vendors/chosen_v1.4.2/chosen.min.css'
						);
		$data['js']     = array(
							'../../assets/admin/vendors/chosen_v1.4.2/chosen.jquery.min.js',
							'../../assets/admin/vendors/fileinput/fileinput.min.js',
							'../../assets/admin/js/custom/clients.js'
						);
		$this->template->load('default', 'clients/add-new',$data);
	}

	/**
	 * Function Name: edit
	 * Description:   To edit client
	*/
	public function edit($user_guid) 
	{
		$data['title']  = lang('edit_client');
		$data['module'] = "clients";
		$data['css']   = array(
							'../../../assets/admin/vendors/chosen_v1.4.2/chosen.min.css'
						);
		$data['js']     = array(
							'../../../assets/admin/vendors/chosen_v1.4.2/chosen.jquery.min.js',
							'../../../assets/admin/vendors/fileinput/fileinput.min.js',
							'../../../assets/admin/js/custom/clients.js'
						);


		/*  To check user guid */	
		$query = $this->db->query('SELECT user_id FROM tbl_users WHERE user_guid = "'.$user_guid.'" LIMIT 1');
		if($query->num_rows() == 0){
			redirect('/admin/clients/list');
		}
		$user_id = $query->row()->user_id;

		/* To Get Client Details */
        $data['details'] = $this->Users_model->get_users('client_configs,employee_budget,delivery_method,  first_name,last_name,email,user_status,deadline',array('user_id' => $user_id));
        
        /* Get Pickup Address */
        if($data['details']['delivery_method'] == 'Pickup' || $data['details']['delivery_method'] == 'Both'){
        	$query = $this->db->query('SELECT pickup_address FROM tbl_client_pickup_address WHERE client_id = '.$user_id);
        	if($query->num_rows() > 0){
        		$data['details']['pickup_addresses'] = $query->result_array();
        	}
        }
		$this->template->load('default', 'clients/edit',$data);
	}

	/**
	 * Function Name: delete
	 * Description:   To delete client
	*/
	public function delete($user_guid)
	{
		if(!$this->Users_model->delete_user($user_guid)){
			$this->session->set_flashdata('error',lang('error_occured'));
		}else{
			$this->session->set_flashdata('success',lang('client_deleted'));
		}
		redirect('admin/clients/list');
	}

	/**
	 * Function Name: shop
	 * Description:   To set client shop
	*/
	public function shop($user_guid)
	{
		$data['title']  = lang('set_shop');
		$data['module'] = "clients";
		$data['css']   = array(
							'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'
						);
		$data['js']     = array(
							'../../../assets/admin/js/custom/clients.js'
						);

		/*  To check user guid */	
		$query = $this->db->query('SELECT user_id,first_name,last_name,employee_budget FROM tbl_users WHERE user_guid = "'.$user_guid.'" LIMIT 1');
		if($query->num_rows() == 0){
			redirect('/admin/clients/list');
		}
		$data['client_name'] = $query->row()->first_name." ".$query->row()->last_name;
		$data['employee_budget'] = $query->row()->employee_budget;
		$data['user_guid'] = $user_guid;
		$client_id = $query->row()->user_id;

		/* Get Products */
		$data['under_the_budget_products']  = $this->Products_model->get_products('product_name,category_name,min_price,max_price,product_main_photo',array('shop_category' => 'Under', 'employee_budget' => $query->row()->employee_budget),TRUE);
		$data['within_the_budget_products'] = $this->Products_model->get_products('product_name,category_name,min_price,max_price,product_main_photo,product_id,shop_product_info',array('shop_category' => 'Within', 'employee_budget' => $query->row()->employee_budget, 'client_id' => $client_id),TRUE);
		$data['above_the_budget_products']  = $this->Products_model->get_products('product_name,category_name,min_price,max_price,product_main_photo,product_id,shop_product_info',array('shop_category' => 'Above', 'employee_budget' => $query->row()->employee_budget, 'client_id' => $client_id),TRUE);

		/* Get Packages */
		$data['packages'] = $this->Shop_model->get_packages('package_name,quantity,no_of_products,products,product_ids,client_status',array('client_id' => $client_id),TRUE);
		$this->template->load('default', 'clients/set-shop',$data);
	}

	/**
	 * Function Name: export_employees_orders
	 * Description:   To export employees orders
	*/
	public function export_employees_orders()
	{
		if($this->user_type_id != 1){
        	$this->session->set_flashdata('error',lang('access_denied'));
        	redirect('admin/dashboard');
        }
		
		/* Get Employees Orders */
		$data['orders'] = $this->Orders_model->get_orders('created_date,order_id,amount,employee_name,employee_email,employee_phone_number,address_mode,order_product_details,pickup_address,city,apartment,street_house,postal_code',array('payment_status' => array('Success'), 'order_status' => 'Created', 'client_id' => $this->input->get('client_id')),TRUE);
		if(empty($data['orders']['data']['records'])){
			$this->session->set_flashdata('error',lang('order_details_not_found'));
			redirect('admin/clients/list');
		}
			

		$order_arr = array();
		foreach($data['orders']['data']['records'] as $value){
			$picked_products = array_column($value['order_product_details'],'product_package_name');

			$order_arr[] = array(
					'employee_name' => $value['employee_name'],
					'employee_email' => $value['employee_email'],
					'employee_phone_number' => $value['employee_phone_number'],
					'picked_products' => implode("\n", $picked_products), 
					'address' => ($value['address_mode'] == 'Pickup') ? $value['pickup_address'] : ($value['apartment'].$value['street_house'].",".$value['city']." ".$value['postal_code']), 
					'order_amount' => $value['order_amount'], 
					'created_date' => convertDateTime($value['created_date'])
				);
		}
		$filename = "employees-orders--".date('d-F-Y-h-i-A').".csv";
        $fp = fopen('php://output', 'w');
        // header('Content-type: application/csv');
        header('Content-Encoding: UTF-8');
		header('Content-type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, array(lang('employee_name'),lang('employee_email'),lang('employee_phone_number'),lang('picked_products'),lang('order_address'),lang('amount'),lang('created_date')));
        foreach ($order_arr as $row) {
            fputcsv($fp, $row);
        }
	}

	/**
	 * Function Name: export_products_orders
	 * Description:   To export products orders
	*/
	public function export_products_orders()
	{
		if($this->user_type_id != 1){
        	$this->session->set_flashdata('error',lang('access_denied'));
        	redirect('admin/dashboard');
        }
		
		/* Get Products Orders */
		$client_id = $this->input->get('client_id');

		/* Get Shop Products */
		$data['products'] = $this->Shop_model->get_shop_products('product_name,sold_quantity',array('client_id' => $client_id, 'client_status' => 'Liked'),TRUE);

		/* Get Packages */
		$data['packages'] = $this->Shop_model->get_packages('package_name,sold_quantity',array('client_id' => $client_id, 'client_status' => 'Liked'),TRUE);
		if(empty($data['products']['data']['records']) && empty($data['packages']['data']['records'])){
			$this->session->set_flashdata('error',lang('order_details_not_found'));
			redirect('admin/clients/list');
		}

		$order_arr = array();
		foreach($data['products']['data']['records'] as $value){
			$order_arr[] = array(
					'product_package_name' => $value['product_name'],
					'type' => lang('product'),
					'sold_quantity' => $value['sold_quantity']
				);
		}
		foreach($data['packages']['data']['records'] as $value){
			$order_arr[] = array(
					'product_package_name' => $value['package_name'],
					'type' => lang('package'),
					'sold_quantity' => $value['sold_quantity']
				);
		}
		$filename = "products-orders--".date('d-F-Y-h-i-A').".csv";
        $fp = fopen('php://output', 'w');
        // header('Content-type: application/csv');
        header('Content-Encoding: UTF-8');
		header('Content-type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, array(lang('product_package_name'),lang('type'),lang('sold_quantity')));
        foreach ($order_arr as $row) {
            fputcsv($fp, $row);
        }
	}

	/**
	 * Function Name: delete_package
	 * Description:   To delete package
	*/
	public function delete_package($package_guid)
	{
		if(!$this->Shop_model->delete_package($package_guid)){
			$this->session->set_flashdata('error',lang('error_occured'));
		}else{
			$this->session->set_flashdata('success',lang('package_deleted'));
		}
		redirect($_SERVER['HTTP_REFERER'].'#within');
	}
}

/* End of file Clients.php */
/* Location: ./application/controllers/admin/Clients.php */
