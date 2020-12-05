<?php
class Users_Model extends MY_Model
{

    ########################################################################
    public function __construct()
    {
        parent::__construct();
    }
    ########################################################################


    ########################################################################
    function Get_All_Users_Active()
    {
        $this->db->where('banned',0);

        $query = $this->db->get('portal_auth_users');

        return $query;
    }
    ########################################################################





}