<?php


##############################################################################
if(!function_exists('Create_Locations_and_Company_user'))
{

    function Create_Group_user($user_id,$group_id)
    {
        app()->load->database();

        $data['user_id']  = $user_id;
        $data['group_id'] = $group_id;

        $query = app()->db->insert('portal_auth_user_to_group',$data);

        return $query;
    }

}
##############################################################################

##############################################################################
if(!function_exists('Create_Locations_and_Company_user'))
{

    function Create_Locations_and_Company_user($user_id,$Locations_id,$Company_id)
    {
        app()->load->database();

        $data['user_id']      = $user_id;
        $data['companies_id'] = $Company_id;
        $data['locations_id'] = $Locations_id;

        $query = app()->db->insert('portal_auth_user_to_companies',$data);

        return $query;
    }

}
##############################################################################


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














