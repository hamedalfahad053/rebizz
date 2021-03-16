<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/Jwt/BeforeValidException.php';
require_once APPPATH . '/libraries/Jwt/ExpiredException.php';
require_once APPPATH . '/libraries/Jwt/SignatureInvalidException.php';
require_once APPPATH . '/libraries/Jwt/JWT.php';
require_once APPPATH . '/libraries/REST_Controller.php';

use \Firebase\JWT\JWT;

class MY_Controller extends MX_Controller  {

    public $data = [];
    public $response = [];

    public function __construct()
    {
        parent::__construct();

        $this->load->library('parser');
        $this->load->library('Mybreadcrumb');
        $this->load->library('form_validation');
        $this->load->helper(['cookie']);

        //if(!$this->input->cookie('language')){
            $lang = $this->config->set_item('language', 'arabic');
            $cookie = array(
                'name'   => 'language',
                'value'  => 'arabic',
                'expire' => 360*30*24*60,
                'secure' => TRUE
            );
            $this->input->set_cookie($cookie);

//        }else{
//            $lang = $this->input->cookie('language');
//            $lang = $this->config->set_item('language',$lang);
//        }

        $this->lang->load(['web', 'form_validation', 'upload', 'db',], $lang);

        if(get_current_lang()=='arabic'){
            $this->data['direction']   = 'rtl';
            $this->data['dir']         = 'rtl';
        }else{
            $this->data['direction']   = '';
            $this->data['dir']         = '';
        }

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Access-Control-Allow-Origin: *");

        $this->data['PageContent']   = '';
        $this->data['Lode_file_Css'] = '';
        $this->data['Lode_file_Js']  = '';


//        trigger_error("User error via trigger.", E_USER_ERROR);
//        trigger_error("Warning error via trigger.", E_USER_WARNING);
//        trigger_error("Notice error via trigger.", E_USER_NOTICE);

    }
}

/**
 * Auth controller
 */
class Authorization extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

#=
        if($this->aauth->is_loggedin()){
            if($this->aauth->is_member('Admin')){
                redirect(ADMIN_NAMESPACE_URL.'/Dashboard', 'refresh');
            }else{
                redirect(APP_NAMESPACE_URL.'/Dashboard', 'refresh');
            }
        }

    } // public function __construct()
}
/**
 * End Auth controller
 */



/**
* Admin controller
*/
class Admin extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // if($this->aauth->is_loggedin()){
        //     if($this->aauth->is_member('Admin')){

        //     }else{
        //         redirect('Auth', 'refresh');
        //     }
        // }

    }


}

/**
 * Apps controller
 */
class Apps extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

         if(!$this->aauth->is_loggedin()){
             redirect('Auth', 'refresh');
         }

        $this->data['UserLogin']                     = $this->session->userdata('UserCompany');
        $this->data['LoginUser_Company']             = $this->data['UserLogin']['Company_User'];
        $this->data['LoginUser_location']            = $this->data['UserLogin']['Company_Locations'];
        $this->data['LoginUser_Company_domain']      = Get_Company($this->data['UserLogin']['Company_User'])->companies_Domain;
        $this->data['LoginUser_Company_Path_Folder'] = BASE_URL.'uploads/companies/' . $this->data['LoginUser_Company_domain'].'';

        $this->data['Widgets_Company_Header']     = $this->load->view('../../modules/Layout/Widgets_Company/Header',$this->data,true);
        $this->data['Widgets_Company_Footer']     = $this->load->view('../../modules/Layout/Widgets_Company/Footer',$this->data,true);
        $this->data['Widgets_Company_UserPanel']  = $this->load->view('../../modules/Layout/Widgets_Company/UserPanel',$this->data,true);

    }
}
/**
 * End Apps controller
 */

/**
 * Site controller
 */
class Front extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
}

/**
 * Ajax controller
 */
class Base_Ajax extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['UserLogin']                  = $this->session->userdata('UserCompany');
    }
}
/**
 * End Ajax controller
 */




/**
 * API controller
 */
class API extends REST_Controller
{
    public $limit_page = 10;
    
    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file My_Controller.php */
/* Location: ./application/core/My_Controller.php */