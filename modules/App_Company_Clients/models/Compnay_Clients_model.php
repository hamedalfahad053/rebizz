<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Compnay_Clients_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    ########################################################################
    function Get_All_Clients()
    {
        $query =  $this->db->get('portal_app_client');
        return $query;
    }
    ########################################################################

}
