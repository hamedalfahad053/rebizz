<?php
class Company_Users_Model extends MY_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    ########################################################################
    function Create_Group($data)
    {
        $query = $this->db->insert('portal_auth_groups',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################



}