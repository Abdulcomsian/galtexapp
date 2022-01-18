<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as admin shop management
 * @package   CodeIgniter
 * @category  Controller
 * @author    Sorav Garg (soravgarg123@gmail.com/+919074939905)
 */

class Shop extends Admin_Controller_Secure { 

	function __construct() {
        parent::__construct();
        $this->load->model('Products_model');
        $this->load->model('Shop_model');
    }

	/**
	 * Function Name: view
	 * Description:   To view client shop
	*/
	public function view()
	{
		$data['title']  = lang('view_shop');
		$data['module'] = "shop";
		$data['css']   = array(
							'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'
						);
		$data['js']     = array(
							'../../assets/admin/js/custom/shop.js'
						);

		/*  To check user guid */	
		$query = $this->db->query('SELECT user_id,employee_budget FROM tbl_users WHERE user_id = "'.$this->session_user_id.'" LIMIT 1');
		if($query->num_rows() == 0){
			redirect('/admin/dashboard');
		}
		$data['employee_budget'] = $query->row()->employee_budget;

		/* Get Shop Products */
		$data['within_the_budget_products'] = $this->Shop_model->get_shop_products('product_name,category_name,product_main_photo,shop_product_id,client_status,quantity,sold_quantity',array('shop_category' => 'Within Budget', 'client_id' => $this->session_user_id, 'quantity' => 'greater_than_to_zero'),TRUE);
		$data['above_the_budget_products']  = $this->Shop_model->get_shop_products('product_name,category_name,product_main_photo,shop_product_id,above_budget_price,client_status,quantity,sold_quantity',array('shop_category' => 'Above Budget', 'client_id' => $this->session_user_id, 'quantity' => 'greater_than_to_zero'),TRUE);

		/* Get Packages */
		$data['packages'] = $this->Shop_model->get_packages('package_name,quantity,sold_quantity,no_of_products,products,product_ids,client_status',array('client_id' => $this->session_user_id),TRUE);
		$this->template->load('default', 'clients/view-shop',$data);
	}
}

/* End of file Shop.php */
/* Location: ./application/controllers/admin/Shop.php */
