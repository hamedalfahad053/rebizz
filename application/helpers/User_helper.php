<?php


##############################################################################
if(!function_exists('Get_Company_User'))
{

    function Get_Company_User($userid)
    {
        app()->load->database();
        $query = app()->db->where('user_id',$userid);
        $query = app()->db->get('portal_auth_user_to_companies');
        $query = $query->row();

        return $query;
    }

}
##############################################################################


##############################################################################
if(!function_exists('Get_Group_User'))
{
    function Get_Group_User($userid)
    {
        app()->load->database();
        $query = app()->db->where('user_id',$userid);
        $query = app()->db->get('portal_auth_user_to_group');
        $query = $query->row();

        return $query->group_id;
    }

}
##############################################################################














