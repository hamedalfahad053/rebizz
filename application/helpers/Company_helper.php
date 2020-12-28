<?php




##############################################################################
if(!function_exists('Get_Company'))
{

    function Get_Company($Company_id)
    {
        app()->load->database();
        $query = app()->db->where('company_id',$Company_id);
        $query = app()->db->get('portal_company');
        return $query->row();
    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_Company_Group_Users')) {

    function Get_Company_Group_Users($Company_id)
    {
        app()->load->database();

        $lang = get_current_lang();

        $query = app()->db->from('portal_auth_groups Group');
        $query = app()->db->join('portal_auth_groups_translation  Groups_Translation', 'Group.group_id=Groups_Translation.item_id');
        $query = app()->db->where('Group.group_owner',$Company_id);
        $query = app()->db->where('Groups_Translation.translation_lang',$lang);

        $query = app()->db->get();

        return $query;

    }

}
##############################################################################


##############################################################################
if(!function_exists('Get_Company_Users')) {

    function Get_Company_Users($Company_id)
    {
        app()->load->database();

        $lang = get_current_lang();

        $query = app()->db->from('portal_auth_user_to_companies   user_to_companies');
        $query = app()->db->join('portal_auth_users               users', 'user_to_companies.user_id =  users.id');
        $query = app()->db->join('portal_auth_user_to_group       user_to_group', 'user_to_group.user_id = users.id');
        $query = app()->db->join('portal_auth_groups              groups_users', 'groups_users.group_id = user_to_group.group_id');
        $query = app()->db->join('portal_auth_groups_translation  Groups_Translation', 'groups_users.group_id = Groups_Translation.item_id');

        $query = app()->db->where('user_to_companies.companies_id',$Company_id);
        $query = app()->db->where('Groups_Translation.translation_lang',$lang);

        $query = app()->db->get();

        return $query;

    }

}
##############################################################################



##############################################################################
if(!function_exists('Get_Company_One_Users')) {

    function Get_Company_One_Users($User_id)
    {
        app()->load->database();

        $lang = get_current_lang();

        $query = app()->db->from('portal_auth_user_to_companies   user_to_companies');
        $query = app()->db->join('portal_auth_users               users', 'user_to_companies.user_id =  users.id');
        $query = app()->db->join('portal_auth_user_to_group       user_to_group', 'user_to_group.user_id = users.id');
        $query = app()->db->join('portal_auth_groups              groups_users', 'groups_users.group_id = user_to_group.group_id');
        $query = app()->db->join('portal_auth_groups_translation  Groups_Translation', 'groups_users.group_id = Groups_Translation.item_id');

        $query = app()->db->where('users.id',$User_id);
        $query = app()->db->where('Groups_Translation.translation_lang',$lang);

        $query = app()->db->get();

        return $query;

    }

}
##############################################################################












