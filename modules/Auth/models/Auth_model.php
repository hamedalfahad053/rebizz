<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    ########################################################################
    function Auth_Company_User($userid)
    {
        $query = $this->db->where('user_id',$userid);
        $query = $this->db->get('portal_auth_user_profile');

        return $query;
    }
    ########################################################################

}