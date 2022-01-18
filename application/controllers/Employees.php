<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as employees management
 * @package   CodeIgniter
 * @category  Controller
 * @author    Sorav Garg (soravgarg123@gmail.com/+919074939905)
 */

class Employees extends Web_Controller_Secure {

	function __construct() {
        parent::__construct();
        $this->load->model('Categories_model');    
        $this->load->model('Products_model');
        $this->load->model('Shop_model');
        $this->load->model('Employee_model');
        $this->load->model('Orders_model');
    }

	/**
     * Function Name: products
     * Description:   To show shop products
     */
	public function products()
	{
		$data['title'] = lang('products');

        /* Get Categories */
        $data['categories'] = $this->Categories_model->get_categories('category_name',array('order_by' => 'category_name', 'sequence' => 'ASC'),TRUE);

        /* Filter Budget Categories */
        $data['budget_categories'] = array('within','above');
        if(!empty($this->input->get('budget_categories'))){
            $data['budget_categories'] = explode(",", $this->input->get('budget_categories'));
        }

        /* Filter Main Categories */
        $data['main_categories'] = array();
        if(!empty($this->input->get('main_categories'))){
            $data['main_categories'] = explode(",", $this->input->get('main_categories'));
        }

        /* Get Shop Products */
        $data['within_the_budget_products'] = $data['above_the_budget_products'] = $data['packages'] = array();
        if(in_array('within',$data['budget_categories'])){
            $data['within_the_budget_products'] = $this->Shop_model->get_shop_products('product_name,category_name,product_main_photo,product_guid,remaining_quantity',array('shop_category' => 'Within Budget', 'client_id' => $this->client_id, 'client_status' => 'Liked', 'main_categories' => $data['main_categories']),TRUE);

            /* Get Packages */
            $data['packages'] = $this->Shop_model->get_packages('package_name,no_of_products,products,product_ids,remaining_quantity',array('client_id' => $this->client_id, 'client_status' => 'Liked'),TRUE);
        }

        if(in_array('above',$data['budget_categories'])){
            $data['above_the_budget_products'] = $this->Shop_model->get_shop_products('product_name,category_name,product_main_photo,product_guid,above_budget_price,remaining_quantity',array('shop_category' => 'Above Budget', 'client_id' => $this->client_id, 'client_status' => 'Liked', 'main_categories' => $data['main_categories'], 'order_by' => 'shop_product_id', 'sequence' => 'RANDOM'),TRUE);
        }
		$this->layout->load('default','front/employee/products',$data);
	} 

    /**
     * Function Name: profile
     * Description:   To edit employees profile
     */
    public function profile()
    {
        $data['title'] = lang('view_profile');

        /* To Get User Details */
        $data['details'] = $this->Users_model->get_users('first_name,last_name,phone_number,total_credits',array('user_id' => $this->session_user_id));

        /* Get Latest Order Details */
        $data['order_details'] = $this->Orders_model->get_orders('amount,order_status,created_date,cancelled_date,order_id,order_product_details',array('user_id' => $this->session_user_id, 'payment_status' => 'Success', 'order_by' => 'order_id', 'sequence' => 'DESC'));
        $this->layout->load('default','front/employee/edit-profile',$data);
    } 

    /**
     * Function Name: product_details
     * Description:   To get product details
     */
    public function product_details($product_guid)
    {
        /* Get Products Details */
        $data['details'] = $this->Shop_model->get_shop_products('product_name,category_name,product_main_photo,product_guid,product_gallery_images,warranty,product_descprition,above_budget_price,remaining_quantity',array('product_guid' => $product_guid));

        $data['title'] = lang('product').' :: '.$data['details']['product_name'];
        $this->layout->load('default','front/employee/product_details',array_merge($data,is_product_into_cart($product_guid)));
    } 

    /**
     * Function Name: packgae_details
     * Description:   To get package details
     */
    public function packgae_details($package_guid)
    {
        /* Get Package Details */
        $data['details'] = $this->Shop_model->get_packages('package_name,no_of_products,products,product_ids,remaining_quantity',array('package_guid' => $package_guid));

        $data['title'] = lang('package').' :: '.$data['details']['package_name'];

        $this->layout->load('default','front/employee/packgae_details',array_merge($data,is_product_into_cart($package_guid)));
    } 

    /**
     * Function Name: cart
     * Description:   To view cart
     */
    public function cart()
    {
        if(!empty($this->input->post('quantities'))){
            foreach($this->input->post('quantities') as $rowid => $item){
                $this->cart->update(array('rowid' => $rowid, 'qty' => $item));
            }
            redirect('employees/cart');
        }else{
            $data['title'] = lang('cart_details');
            $data['cart']  = $this->cart->contents();

            /* To Get User Credits */
            $data['user_details'] = $this->Users_model->get_users('total_credits',array('user_id' => $this->session_user_id));
            $this->layout->load('default','front/employee/cart',$data);
        }
    } 

    /**
     * Function Name: remove_from_cart
     * Description:   To remove item from cart
     */
    public function remove_from_cart($row_id)
    {
        if(!$this->cart->remove($row_id)){
            $this->session->set_flashdata('error',lang('error_occured'));
        }else{
            $this->session->set_flashdata('success',lang('product_removed_from_cart'));
        }
        redirect('employees/cart');
    } 

    /**
     * Function Name: checkout
     * Description:   To checkout cart
     */
    public function checkout()
    {
        $data['title'] = lang('checkout');

        /* To Get User Details */
        $data['details'] = $this->Users_model->get_users('first_name,last_name,phone_number',array('user_id' => $this->session_user_id));
        $data['cart']    = $this->cart->contents();

        /* To Get User Credits */
        $data['user_details'] = $this->Users_model->get_users('total_credits',array('user_id' => $this->session_user_id));

        /* Get Client Details */
        $data['client_details'] = $this->Users_model->get_users('delivery_method,client_addresses',array('user_id' => $this->session->userdata('webuserdata')['client_id']));
        $this->layout->load('default','front/employee/checkout',$data);
    } 

    /**
     * Function Name: payment_response
     * Description:   To redirect on payment response
     */
    public function payment_response()
    {
        if(!empty($_GET['params'])){
          $response = $this->Employee_model->update_order($_GET['params'],$this->session_user_id);
          if($response['status'] == 0){
            $this->session->set_flashdata('error',$response['message']);
            redirect('employees/cart');
          }else{
            $this->session->set_flashdata('success',$response['message']);
            redirect('employees/profile#myOrder');
          }
        }else{
          $this->session->set_flashdata('error',lang('payment_failed'));
          redirect('employees/cart');
        }
    }
}

/* End of file Employees.php */
/* Location: ./application/controllers/Employees.php */