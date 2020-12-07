<?php
class System_Forms_Model extends MY_Model
{

    ########################################################################
    public function __construct()
    {
        parent::__construct();
    }
    ########################################################################


    ########################################################################
    function Get_All_Users()
    {
        $this->db->from('portal_auth_users  Users');
        $this->db->join('portal_auth_user_to_group Groups_Users', 'Users.id=Groups_Users.user_id');
        $this->db->join('portal_auth_groups_translation  Groups_Translation', 'Groups_Users.group_id=Groups_Translation.item_id');

        $lang   = get_current_lang();
        $this->db->where('Groups_Translation.translation_lang',$lang);

        $query = $this->db->get();

        return $query;
    }
    ########################################################################





}