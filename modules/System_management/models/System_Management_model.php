<?php defined('BASEPATH') OR exit('No direct script access allowed');

class System_Management_model extends CI_Model
{


    ########################################################################
    function Get_System_Area()
    {
        $query = $this->db->get('portal_system_area');
        return $query;
    }
    ########################################################################

    ########################################################################
    function Get_System_Area_Active()
    {
        $this->db->where('area_status',1);
        $query = $this->db->get('portal_system_area');
        return $query;
    }
    ########################################################################

    ########################################################################
    function Get_System_Area_Row($area_id)
    {
        $this->db->where('area_id',$area_id);
        $query = $this->db->get('portal_system_area');
        return $query;
    }
    ########################################################################

    ########################################################################
    function Get_System_controllers()
    {
        $this->db->from('portal_system_controllers controllers');
        $this->db->join('portal_system_controllers_translation  controllers_translation', 'controllers.controllers_id=controllers_translation.item_id');
        $lang   = get_current_lang();
        $this->db->where('controllers_translation.translation_lang',$lang);
        $query = $this->db->get();

        return $query;
    }
    ########################################################################

    ########################################################################
    function Create_Controllers($data)
    {
        $query = $this->db->insert('portal_system_controllers',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################


}
