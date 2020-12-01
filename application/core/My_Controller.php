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

        $this->data['PageContent']   = '';
        $this->data['Lode_file_Css'] = '';
        $this->data['Lode_file_Js']  = '';

    }
}

/**
* Admin controller
*/
class Admin extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

    }
}

/**
 * Front controller
 */

class Front extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

    }
}


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