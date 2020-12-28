<?php


##############################################################################
if(!function_exists('Create_Notifications'))
{

    function Create_Notifications($userid)
    {
        app()->load->database();
        $query = app()->db->where('user_id',$userid);
        $query = app()->db->get('portal_auth_user_to_companies');
        $query = $query->row();

        return $query->companies_id;
    }

}
##############################################################################
















