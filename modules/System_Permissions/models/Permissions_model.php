<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    ########################################################################
    function Cet_All_Permissions()
    {
        $this->db->from('portal_auth_permissions permissions');
        $this->db->join('portal_auth_permissions_translation  permissions_translation', 'permissions.permissions_id=permissions_translation.item_id');
        $lang   = get_current_lang();
        $this->db->where('permissions_translation.translation_lang',$lang);
        $query = $this->db->get();
        return $query;
    }
    ########################################################################




}