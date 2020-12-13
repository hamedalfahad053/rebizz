<?php
class Users_Group_Model extends MY_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    ########################################################################
    function Get_Groups_System()
    {
        $this->db->from('portal_auth_groups Group');
        $this->db->join('portal_auth_groups_translation  Groups_Translation', 'Group.group_id=Groups_Translation.item_id');
        $this->db->join('portal_auth_users  Users', 'Users.id=Group.group_owner');

        $lang   = get_current_lang();

        $this->db->where_in('Group.group_id',array(1,2));

        $this->db->where('Groups_Translation.translation_lang',$lang);

        $query = $this->db->get();

        return $query;
    }
    ########################################################################


    ########################################################################
    function Get_Groups()
    {
        $this->db->from('portal_auth_groups Group');
        $this->db->join('portal_auth_groups_translation  Groups_Translation', 'Group.group_id=Groups_Translation.item_id');
        $this->db->join('portal_auth_users  Users', 'Users.id=Group.group_owner');

        $lang   = get_current_lang();

        $this->db->where('Groups_Translation.translation_lang',$lang);

        $query = $this->db->get();

        return $query;
    }
    ########################################################################


    ########################################################################
    function Get_Num_User_of_Groups($group_id)
    {
        $this->db->where('group_id',$group_id);
        $query = $this->db->get('portal_auth_user_to_group');

        return $query->num_rows();
    }
    ########################################################################


    ########################################################################
    function Create_Group($data)
    {
        $query = $this->db->insert('portal_auth_groups',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################





}