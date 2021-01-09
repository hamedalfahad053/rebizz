<?php


##############################################################################
if(!function_exists('App_Get_Client_Company_By_id'))
{

    function App_Get_Client_Company_By_id($Company_id,$Client_id)
    {
        app()->load->database();

        $query = app()->db->where('client_id',$Client_id);
        $query = app()->db->where('company_id',$Company_id);
        $query = app()->db->get('portal_app_client');
        return $query;
    }

}
##############################################################################




?>