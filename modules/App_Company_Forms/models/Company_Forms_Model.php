<?php
class Company_Forms_Model extends MY_Model
{

    ########################################################################
    public function __construct()
    {
        parent::__construct();
    }
    ########################################################################


    ########################################################################
    function Create_Forms_built($data)
    {
        $query = $this->db->insert('portal_forms_built',$data);

        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }

    }
    ########################################################################



}