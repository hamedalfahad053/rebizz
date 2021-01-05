<?php
class Company_Locations_Model extends MY_Model
{


    public function __construct()
    {
        parent::__construct();
    }

    ########################################################################
    function Get_Company_Locations($locations_id = '')
    {
        if(!empty($locations_id)){
            $query = $this->db->where('company_locations_id',$locations_id);
        }
        $query =  $this->db->get('portal_company_locations');

        return $query;
    }
    ########################################################################


    ########################################################################
    function Create_Company_Locations($data)
    {
        $query = $this->db->insert('portal_company_locations',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################



}