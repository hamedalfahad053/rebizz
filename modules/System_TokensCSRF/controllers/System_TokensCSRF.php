<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_TokensCSRF extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    ###############################################################################################
    public function index()
    {
     die;
    }
    ###############################################################################################

    ###############################################################################################
	public function Get_Tokens_CSRF()
	{
        if($this->input->is_ajax_request()
            and $this->input->server(array('SERVER_PROTOCOL', 'REQUEST_URI'))
            and $this->input->valid_ip($this->input->ip_address())
        ){
            $msg['CSRF_NAME']  = $this->security->get_csrf_token_name();
            $msg['CSRF_CCODE'] = $this->security->get_csrf_hash();
            $msg['success'] = true;
            echo json_encode($msg);
            die();

        }else{
            $msg['success'] = false;
            echo json_encode($msg);
            die();
        }
    }
    ###############################################################################################





}
