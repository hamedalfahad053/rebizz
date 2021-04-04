<?php

##############################################################################
if(!function_exists('Create_Permissions'))
{

    function Create_Permissions($data)
    {
        app()->load->database();
        $query = app()->db->insert('portal_auth_permissions',$data);
        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }
    }

}
##############################################################################



##############################################################################
if(!function_exists('Get_Permissions'))
{

    function Get_Permissions($where_extra = '')
    {
        app()->load->database();
        $lang   = get_current_lang();

        $query  = app()->db->select('controllers_translation.item_translation AS controllers_title,functions_translation.item_translation AS functions_title,
        permissions.permissions_id AS permissions_id,area.area_name AS area,controllers.Controllers_Code AS Controllers_Code,functions.function_Code AS function_Code,
        permissions_translation.item_translation AS permissions_title');

        $query  = app()->db->from('portal_auth_permissions                 permissions');
        $query  = app()->db->join('portal_auth_permissions_translation     permissions_translation', 'permissions.permissions_id = permissions_translation.item_id');
        $query  = app()->db->join('portal_system_controllers               controllers', 'permissions.controllers_id = controllers.controllers_id');
        $query  = app()->db->join('portal_system_area                      area', 'controllers.controllers_area = area.area_id');
        $query  = app()->db->join('portal_system_controllers_translation   controllers_translation','controllers_translation.item_id = controllers.controllers_id');
        $query  = app()->db->join('portal_system_functions                 functions', 'functions.function_id = permissions.function_id');
        $query  = app()->db->join('portal_system_functions_translation     functions_translation','functions_translation.item_id = functions.function_id');
        if(!empty($where_extra)){
            foreach ($where_extra AS $key => $value)
            {
                $query = app()->db->where($key,$value);
            }
        }
        $query = app()->db->where('controllers_translation.translation_lang',$lang);
        $query = app()->db->where('functions_translation.translation_lang',$lang);
        $query = app()->db->where('permissions_translation.translation_lang',$lang);
        $query = app()->db->get();
        return $query;
    }
}
##############################################################################


##############################################################################
if(!function_exists('Add_Permissions_To_Group')) {

    function Add_Permissions_To_Group($data)
    {
        app()->load->database();
        $query = app()->db->insert('portal_auth_permissions_to_group',$data);
        if($query){
            return true;
        }else{
            return false;
        }
    }
}
##############################################################################


##############################################################################
if(!function_exists('Check_Permissions_By_Group')) {

    function Check_Permissions_By_Group($perm_id,$Group)
    {
        app()->load->database();

        $return     = false;
        $query      = app()->db->where('perm_id',$perm_id);
        $query      = app()->db->where('group_id',$Group);
        $query      = app()->db->get('portal_auth_permissions_to_group');
        return $query;
    }
}
##############################################################################


##############################################################################
if(!function_exists('Check_Permissions')) {

    function Check_Permissions($perm_id)
    {
        app()->load->database();

        $return     = false;
        $user_id    = app()->aauth->get_user()->id;
        $Group_User = Get_Group_User($user_id);

        $query      = app()->db->where('perm_id',$perm_id);
        $query      = app()->db->where('group_id',$Group_User);
        $query      = app()->db->get('portal_auth_permissions_to_group');

        if($query->num_rows()>0){
            $return = true;
        }else{

            $query_to_user      = app()->db->where('perm_id',$perm_id);
            $query_to_user      = app()->db->where('user_id',$user_id);
            $query_to_user      = app()->db->get('portal_auth_permissions_to_user');

            if($query_to_user->num_rows()>0){
                $return = true;
            }else{
                $return = false;
            }

        }

        return $return;
    }
}
##############################################################################

##############################################################################
if(!function_exists('Delete_All_Permissions_To_Group')) {

    function Delete_All_Permissions_To_Group($group_id)
    {
        app()->load->database();
        $query = app()->db->where('group_id',$group_id);
        $query = app()->db->delete('portal_auth_permissions_to_group');
        if($query){
            return true;
        }else{
            return false;
        }
    }

}
##############################################################################










