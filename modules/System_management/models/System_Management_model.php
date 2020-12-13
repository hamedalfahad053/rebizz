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
    function Get_System_controllers()
    {
        $query = $this->db->get('portal_system_controllers');
        return $query;
    }
    ########################################################################

}
