<?php



##############################################################################
if(!function_exists('Get_Group'))
{

    function Get_Group($where_extra = '')
    {
        app()->load->database();
        $lang   = get_current_lang();
        $query  = app()->db->from('portal_auth_groups groups');
        $query  = app()->db->join('portal_auth_groups_translation groups_translation', 'groups_translation.item_id = groups.group_id');
        if(!empty($where_extra))
        {
            foreach ($where_extra AS $key => $value)
            {
                $query = app()->db->where($key,$value);
            }
        }
        $query = app()->db->where('groups_translation.translation_lang', $lang);
        $query = app()->db->get();
        return $query;
    }
}
##############################################################################


##############################################################################
if(!function_exists('Get_Group_Translation'))
{
    function Get_Group_Translation($lang,$Group_id)
    {
        app()->load->database();
        $query = app()->db->where('translation_lang',$lang);
        $query = app()->db->where('item_id',$Group_id);
        $query = app()->db->get('portal_auth_groups_translation');
        return $query;
    }
}
##############################################################################


##############################################################################
if(!function_exists('Create_Group_By_Company'))
{

    function Create_Group_By_Company($data)
    {
        app()->load->database();
        $query = app()->db->insert('portal_auth_groups',$data);
        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }
    }

}
##############################################################################

##############################################################################
if(!function_exists('Create_Group_user_company'))
{

    function Create_Group_user_company($data)
    {
        app()->load->database();
        $query = app()->db->insert('portal_auth_user_to_group',$data);
        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }
    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_Company_Group_Users')) {

    function Get_Company_Group_Users($Company_id)
    {
        app()->load->database();
        $lang  = get_current_lang();
        $query = app()->db->from('portal_auth_groups Group');
        $query = app()->db->join('portal_auth_groups_translation  Groups_Translation', 'Group.group_id=Groups_Translation.item_id');
        $query = app()->db->where('Group.company_id',$Company_id);
        $query = app()->db->where('Groups_Translation.translation_lang',$lang);
        $query = app()->db->get();
        return $query;
    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_Userid_Group')) {

    function Get_Userid_Group($user)
    {
        $query =  app()->db->where('user_id',$user);
        $query = app()->db->get('portal_auth_user_to_group');
        return $query;
    }
}
##############################################################################


##############################################################################
if(!function_exists('Get_Company_Users')) {

    function Get_Company_Users($where_extra = '')
    {
        app()->load->database();

        $lang = get_current_lang();

        $query = app()->db->from('portal_auth_users               users');
        $query = app()->db->join('portal_auth_user_to_group       user_to_group', 'user_to_group.user_id = users.id');
        $query = app()->db->join('portal_auth_groups              groups_users', 'groups_users.group_id = user_to_group.group_id');
        $query = app()->db->join('portal_auth_groups_translation  Groups_Translation', 'groups_users.group_id = Groups_Translation.item_id');
        if(!empty($where_extra)){
            foreach ($where_extra AS $key => $value)
            {
                $query =  app()->db->where($key,$value);
            }
        }
        $query = app()->db->where('Groups_Translation.translation_lang',$lang);
        $query = app()->db->get();
        return $query;
    }
}
##############################################################################


########################################################################
if(!function_exists('Update_User')) {

    function Update_User($user_id,$data)
    {
        app()->load->database();
        $query = app()->db->where('user_uuid',$user_id);
        $query = app()->db->where('company_id',app()->aauth->get_user()->company_id);
        $query = app()->db->update('portal_auth_users',$data);
        if($query){
            return true;
        }else{
            return false;
        }

    }
}
########################################################################




##############################################################################
if(!function_exists('Get_Group_User')) {

    function Get_Group_User($users)
    {
        $query = app()->db->where('user_id',$users);
        $query = app()->db->get('portal_auth_user_to_group')->row();
        return $query->group_id;
    }

}
##############################################################################


##############################################################################
if(!function_exists('Deleted_Group_User')) {

    function Deleted_Group_User($users)
    {
        $query = app()->db->where('user_id',$users);
        $query = app()->db->delete('portal_auth_user_to_group');

        if($query){
            return true;
        }else{
            return false;
        }
    }
}
##############################################################################

##############################################################################
if(!function_exists('Get_Group_User')) {

    function Get_Group_User($users)
    {
        $query = $query = app()->db->where('user_id',$users);
        $query = app()->db->get('portal_auth_user_to_group')->row();
        return $query->group_id;
    }

}
##############################################################################

########################################################################
if(!function_exists('deleted_Group_Transaction')) {

    function deleted_Group_Transaction($group_id)
    {
        app()->load->database();
        $query = app()->db->where('item_id',$group_id);
        $query = app()->db->delete('portal_auth_groups_translation');
        if($query){
            return true;
        }else{
            return false;
        }

    }
}
########################################################################

########################################################################
if(!function_exists('Update_Group')) {

    function Update_Group($group_id,$group_status)
    {
        app()->load->database();
        $query = app()->db->where('group_id',$group_id);
        $query = app()->db->set('group_status',$group_status);
        $query = app()->db->update('portal_auth_groups');
        if($query){
            return true;
        }else{
            return false;
        }

    }
}
########################################################################








