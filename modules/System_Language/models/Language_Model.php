<?php
class Language_Model extends MY_Model
{

    ########################################################################
    public function __construct()
    {
        parent::__construct();
    }
    ########################################################################


    ########################################################################
    function Get_All_Language()
    {
        $query = $this->db->get('protal_list_language');
        return $query;
    }
    ########################################################################


    ########################################################################
    function _Language()
    {
        $this->db->select('language_name,');
        $query = $this->db->get('protal_list_language');
        return $query;
    }
    ########################################################################



}