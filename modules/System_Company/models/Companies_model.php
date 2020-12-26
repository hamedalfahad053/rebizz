<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Companies_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    ########################################################################
    function Get_All_Companies($company_status='')
    {
        if(!empty($company_status)){
            $query = $this->db->where('companies_Status',$company_status);
        }

        $query =  $this->db->get('portal_company');
        return $query;
    }
    ########################################################################

    ########################################################################
    function Get_Company_Profile($profile_id)
    {
        $query = $this->db->where('company_id',$profile_id);
        $query = $this->db->or_where('companies_Commercial_Registration_No',$profile_id);
        $query =  $this->db->get('portal_company');

            if($query->num_rows()>0){
                return $query;
            }else{
                return false;
            }
    }
    ########################################################################

    ########################################################################
    function Create_Company($data)
    {
        $query = $this->db->insert('portal_company',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################

}
