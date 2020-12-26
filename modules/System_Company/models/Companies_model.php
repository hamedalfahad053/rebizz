<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Companies_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    ########################################################################
    function Get_Companies()
    {

    }
    ########################################################################

    ########################################################################
    function Get_Company_Profile($profile_id)
    {
        $query = $this->db->where('company_profile_id',$profile_id);
        $query = $this->db->or_where('companies_Commercial_Registration_No',$profile_id);
        $query =  $this->db->get('portal_company_profile');

            if($this->db->num_rows()>0){
                return $query;
            }else{
                return false;
            }
    }
    ########################################################################


    ########################################################################
    function Create_Company()
    {


    }
    ########################################################################

}
