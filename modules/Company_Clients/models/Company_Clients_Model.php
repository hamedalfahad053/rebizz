<?php
class App_Company_Clients_Model extends MY_Model
{


    public function __construct()
    {
        parent::__construct();
    }

    function Get_App_Client_List()
    {
        $this->db->from('portal_app_client Clients');
        /*$this->db->join('portal_auth_groups_translation  Groups_Translation', 'Group.group_id=Groups_Translation.item_id');
        $lang   = get_current_lang();
        $this->db->where('Groups_Translation.translation_lang',$lang);*/
        $query = $this->db->get();

        return $query;
    }

    function Get_App_Client()
    {
        
    }

}