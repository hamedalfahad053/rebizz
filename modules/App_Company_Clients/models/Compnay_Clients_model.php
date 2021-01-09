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

     ########################################################################
     function Create_Client($data)
     {
         $query = $this->db->insert('portal_app_client',$data);
         if($query){
             return $this->db->insert_id();
         }else{
             return false;
         }
     }
     ########################################################################

    ########################################################################
    function Create_Contracts($data)
    {
        $query = $this->db->insert('portal_app_client_contract',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################
}
