<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as admin employees management
 * @package   CodeIgniter
 * @category  Controller
 * @author    Sorav Garg (soravgarg123@gmail.com/+919074939905)
 */

class Employees extends Admin_Controller_Secure { 

	function __construct() {
        parent::__construct();   
    }

	/**
	 * Function Name: list
	 * Description:   To view employees list
	*/
	public function list()
	{
		$data['title'] = lang('employees');
		$data['module']= "employees";
		$data['css']   = array(
							'../../assets/admin/css/dataTables.bootstrap.min.css',
							'../../assets/admin/vendors/chosen_v1.4.2/chosen.min.css'
						);
		$data['js']    = array(
							'../../assets/admin/js/jquery.dataTables.min.js',
							'../../assets/admin/js/dataTables.bootstrap.min.js',
							'../../assets/admin/vendors/chosen_v1.4.2/chosen.jquery.min.js',
							'../../assets/admin/js/custom/employees.js'
						);	

		/* Get Employees */
		if($this->user_type_id == 2){
		$data['members'] = $this->Users_model->get_users('first_name,last_name,email,phone_number,pricelist_name,pricelist_brand,user_status,client_first_name,client_last_name,created_date',array('order_by' => 'first_name', 'sequence' => 'ASC', 'user_type_id' => '3','client_id' => $this->session_user_id),TRUE);
	    }else{
	    	$data['members'] = $this->Users_model->get_users('first_name,last_name,email,phone_number,pricelist_name,pricelist_brand,user_status,client_first_name,client_last_name,created_date',array('order_by' => 'first_name', 'sequence' => 'ASC', 'user_type_id' => 3),TRUE);	
	    }

	    /* Get Clients */
		$data['clients'] = $this->Users_model->get_users('first_name,last_name,email',array('order_by' => 'first_name', 'sequence' => 'ASC', 'user_type_id' => 2),TRUE);
		$this->template->load('default', 'employees/list',$data);
	}

	/**
	 * Function Name: add_new
	 * Description:   To add new employee
	*/
	public function add_new()
	{
		$data['title']  = lang('add_new_employee');
		$data['module'] = "employees";

		$data['css']   = array(
							'../../assets/admin/vendors/chosen_v1.4.2/chosen.min.css'
						);
		$data['js']     = array(
							'../../assets/admin/vendors/chosen_v1.4.2/chosen.jquery.min.js',
							'../../assets/admin/js/custom/employees.js'
						);

		/* Get Clients */
		$data['clients'] = $this->Users_model->get_users('first_name,last_name,email',array('order_by' => 'first_name', 'sequence' => 'ASC', 'user_type_id' => 2, 'user_status' => 'Verified'),TRUE);
		$this->template->load('default', 'employees/add-new',$data);
	}

	/**
	 * Function Name: edit
	 * Description:   To edit employee
	*/
	public function edit($user_guid) 
	{
		$data['title']  = lang('edit_employee');
		$data['module'] = "employees";
		$data['css']    = array(
							'../../../assets/admin/vendors/chosen_v1.4.2/chosen.min.css'
						);
		$data['js']     = array(
							'../../../assets/admin/vendors/chosen_v1.4.2/chosen.jquery.min.js',
							'../../../assets/admin/js/custom/employees.js'
						);


		/*  To check user guid */	
		$query = $this->db->query('SELECT user_id FROM tbl_users WHERE user_guid = "'.$user_guid.'" LIMIT 1');
		if($query->num_rows() == 0){
			redirect('/admin/employees/list');
		}
		$user_id = $query->row()->user_id;

		/* To Get Employee Details */
        $data['details'] = $this->Users_model->get_users('first_name,last_name,email,phone_number,gender,user_status,client_guid',array('user_id' => $user_id));

        /* Get Clients */
		$data['clients'] = $this->Users_model->get_users('first_name,last_name,email',array('order_by' => 'first_name', 'sequence' => 'ASC', 'user_type_id' => 2, 'user_status' => 'Verified', 'user_guid' => $data['details']['client_guid']),TRUE);
		$this->template->load('default', 'employees/edit',$data);
	}

	/**
	 * Function Name: delete
	 * Description:   To delete employee
	*/
	public function delete($user_guid)
	{
		if(!$this->Users_model->delete_user($user_guid)){
			$this->session->set_flashdata('error',lang('error_occured'));
		}else{
			$this->session->set_flashdata('success',lang('employee_deleted'));
		}
		redirect('admin/employees/list');
	}


	/**
	 * Function Name: upload
	 * Description:   To upload employees via csv
	*/
	public function upload()
	{
		if($this->user_type_id != 1){
        	$this->session->set_flashdata('error',lang('access_denied'));
        	redirect('admin/dashboard');
        }
        
		/*  To check product guid */	
		$query = $this->db->query('SELECT user_id FROM tbl_users WHERE user_guid = "'.$user_guid.'" LIMIT 1');
		if($query->num_rows() == 0){
			redirect('/admin/employees/list');
		}
		$user_id = $query->row()->user_id;

		/* To Get employee Details */
        $details = $this->Users_model->get_users('first_name, last_name, email, phone_number',array('user_id' => $user_id));

		/* delete images also */
		if(!$this->Users_model->delete_user($user_guid)){
			$this->session->set_flashdata('error',lang('error_occured'));
		}else{
			$this->session->set_flashdata('success',lang('product_deleted'));
		}
		redirect('admin/employees/list');
	}
}

/* End of file Employees.php */
/* Location: ./application/controllers/admin/Employees.php */
