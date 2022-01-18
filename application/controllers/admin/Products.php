<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as admin products management
 * @package   CodeIgniter
 * @category  Controller
 * @author    Sorav Garg (soravgarg123@gmail.com/+919074939905)
 */

class Products extends Admin_Controller_Secure { 

	function __construct() {
        parent::__construct();    
        $this->load->model('Categories_model');
        $this->load->model('Products_model');
    }

	/**
	 * Function Name: list
	 * Description:   To view products list
	*/
	public function list()
	{
		if($this->user_type_id != 1){
        	$this->session->set_flashdata('error',lang('access_denied'));
        	redirect('admin/dashboard');
        }
		$data['title'] = lang('products');
		$data['module']= "products";
		$data['css']   = array(
							'../../assets/admin/css/dataTables.bootstrap.min.css'
						);
		$data['js']    = array(
							'../../assets/admin/js/jquery.dataTables.min.js',
							'../../assets/admin/js/dataTables.bootstrap.min.js',
							'../../assets/admin/js/custom/products.js'
						);

		/* Get Products */
		$data['products'] = $this->Products_model->get_products('product_name,category_name,min_price,max_price,product_main_photo,created_date',array(),TRUE);
		$this->template->load('default', 'products/list',$data);
	}

	/**
	 * Function Name: add_new
	 * Description:   To add new product
	*/
	public function add_new()
	{
		if($this->user_type_id != 1){
        	$this->session->set_flashdata('error',lang('access_denied'));
        	redirect('admin/dashboard');
        }
		$data['title']  = lang('add_new_product');
		$data['module'] = "products";

		$data['css']   = array(
							'../../assets/admin/vendors/chosen_v1.4.2/chosen.min.css',
							'../../assets/admin/css/dropzone.css'
						);
		$data['js']     = array(
							'../../assets/admin/vendors/chosen_v1.4.2/chosen.jquery.min.js',
							'../../assets/admin/vendors/fileinput/fileinput.min.js',
							'../../assets/admin/js/dropzone.js',
							'../../assets/admin/js/custom/products.js'
						);

		/* Get Categories */
		$data['categories'] = $this->Categories_model->get_categories('category_name',array('order_by' => 'category_name', 'sequence' => 'ASC'),TRUE);
		$this->template->load('default', 'products/add-new',$data);
	}

	/**
	 * Function Name: edit
	 * Description:   To edit product
	*/
	public function edit($product_guid) 
	{
		if($this->user_type_id != 1){
        	$this->session->set_flashdata('error',lang('access_denied'));
        	redirect('admin/dashboard');
        }
		$data['title']  = lang('edit_product');
		$data['module'] = "products";
		$data['css']   = array(
							'../../../assets/admin/vendors/chosen_v1.4.2/chosen.min.css',
							'../../../assets/admin/css/dropzone.css'
						);
		$data['js']     = array(
							'../../../assets/admin/vendors/chosen_v1.4.2/chosen.jquery.min.js',
							'../../../assets/admin/vendors/fileinput/fileinput.min.js',
							'../../../assets/admin/js/dropzone.js',
							'../../../assets/admin/js/custom/products.js'
						);


		/*  To check product guid */	
		$query = $this->db->query('SELECT product_id FROM tbl_products WHERE product_guid = "'.$product_guid.'" LIMIT 1');
		if($query->num_rows() == 0){
			redirect('/admin/products/list');
		}
		$product_id = $query->row()->product_id;

		/* Get Categories */
		$data['categories'] = $this->Categories_model->get_categories('category_name',array('order_by' => 'category_name', 'sequence' => 'ASC'),TRUE);

		/* To Get Product Details */
        $data['details'] = $this->Products_model->get_products('product_name,product_category_id,product_descprition,category_guid,min_price,max_price,warranty,product_main_photo,product_gallery_images',array('product_id' => $product_id));

        /* Manage Gallery Images For Dropzone */
        $product_gallery_images = array();
        if(!empty($data['details']['product_gallery_images'])){
        	foreach($data['details']['product_gallery_images'] as $image){
        		$product_gallery_images[] = array(
        										'name' => $image,
        										'path' => '../../../uploads/products/'.$image,
        										'size' => filesize(FCPATH.'uploads/products/'.$image)
        									);
        	}
        }
        $data['details']['product_gallery_images'] = $product_gallery_images;
		$this->template->load('default', 'products/edit',$data);
	}

	/**
	 * Function Name: details
	 * Description:   To view product details
	*/
	public function details($product_guid) 
	{
		if($this->user_type_id != 1){
        	$this->session->set_flashdata('error',lang('access_denied'));
        	redirect('admin/dashboard');
        }
		$data['title']  = lang('view_product_details');
		$data['module'] = "products";
		$data['css']   = array(
							'../../../assets/admin/vendors/bower_components/lightgallery/src/css/lightgallery.css'
						);
		$data['js']     = array(
							'../../../assets/admin/vendors/bower_components/lightgallery/src/js/lightgallery.js',
							'../../../assets/admin/js/custom/products.js'
						);

		/*  To check product guid */	
		$query = $this->db->query('SELECT product_id FROM tbl_products WHERE product_guid = "'.$product_guid.'" LIMIT 1');
		if($query->num_rows() == 0){
			redirect('/admin/products/list');
		}
		$product_id = $query->row()->product_id;

		/* To Get Product Details */
        $data['details'] = $this->Products_model->get_products('product_name,product_descprition,category_name,min_price,max_price,warranty,product_main_photo,product_gallery_images,created_date',array('product_id' => $product_id));
		$this->template->load('default', 'products/view-details',$data);
	}

	/**
	 * Function Name: delete
	 * Description:   To delete product
	*/
	public function delete($product_guid)
	{
		if($this->user_type_id != 1){
        	$this->session->set_flashdata('error',lang('access_denied'));
        	redirect('admin/dashboard');
        }
        
		/*  To check product guid */	
		$query = $this->db->query('SELECT product_id FROM tbl_products WHERE product_guid = "'.$product_guid.'" LIMIT 1');
		if($query->num_rows() == 0){
			redirect('/admin/products/list');
		}
		$product_id = $query->row()->product_id;

		/* To Get Product Details */
        $details = $this->Products_model->get_products('product_main_photo_file,product_gallery_images',array('product_id' => $product_id));

		/* delete images also */
		if(!$this->Products_model->delete_product($product_guid)){
			$this->session->set_flashdata('error',lang('error_occured'));
		}else{

			/* Remove product main photo */
        	unlink(FCPATH.'uploads/products/'.$details['product_main_photo_file']);

        	/* Remove Gallery Images */
        	if(!empty($details['product_gallery_images'])){
        		foreach($details['product_gallery_images'] as $gallery_image){
        			unlink(FCPATH.'uploads/products/'.$gallery_image);
        		}
        	}
			$this->session->set_flashdata('success',lang('product_deleted'));
		}
		redirect('admin/products/list');
	}

	/**
	 * Function Name: upload
	 * Description:   To upload products via csv
	*/
	public function upload()
	{
		if($this->user_type_id != 1){
        	$this->session->set_flashdata('error',lang('access_denied'));
        	redirect('admin/dashboard');
        }
        
		/*  To check product guid */	
		$query = $this->db->query('SELECT product_id FROM tbl_products WHERE product_guid = "'.$product_guid.'" LIMIT 1');
		if($query->num_rows() == 0){
			redirect('/admin/products/list');
		}
		$product_id = $query->row()->product_id;

		/* To Get Product Details */
        $details = $this->Products_model->get_products('product_main_photo_file,product_gallery_images',array('product_id' => $product_id));

		/* delete images also */
		if(!$this->Products_model->delete_product($product_guid)){
			$this->session->set_flashdata('error',lang('error_occured'));
		}else{

			/* Remove product main photo */
        	unlink(FCPATH.'uploads/products/'.$details['product_main_photo_file']);

        	/* Remove Gallery Images */
        	if(!empty($details['product_gallery_images'])){
        		foreach($details['product_gallery_images'] as $gallery_image){
        			unlink(FCPATH.'uploads/products/'.$gallery_image);
        		}
        	}
			$this->session->set_flashdata('success',lang('product_deleted'));
		}
		redirect('admin/products/list');
	}

}

/* End of file Products.php */
/* Location: ./application/controllers/admin/Products.php */
