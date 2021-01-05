<?php
class System_Property_Types_Model extends MY_Model
{

    ########################################################################
    public function __construct()
    {
        parent::__construct();
    }
    ########################################################################

    ########################################################################
    function Get_All_Property_Types($Property_Types='')
    {
        if($Property_Types){
            $this->db->where('Property_Types_id',$Property_Types);
        }
        $query = $this->db->get('portal_list_property_types');
        return $query;
    }
    ########################################################################

    ########################################################################
    function Create_Property_Types($data)
    {
        $query = $this->db->insert('portal_list_property_types',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################

    ########################################################################
    function Create_Sections_Types_Property_Components($data)
    {
        $query = $this->db->insert('portal_list_property_types_sections_components',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################




}