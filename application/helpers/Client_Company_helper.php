<?php

##############################################################################
if(!function_exists('App_Get_Client_Company'))
{

    function App_Get_Client_Company($Company_id)
    {
        app()->load->database();
        $query = app()->db->where('company_id',$Company_id);
        $query = app()->db->get('portal_app_client');
        return $query;
    }

}
##############################################################################

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

##############################################################################
if(!function_exists('App_Get_Client_Company_By_CATEGORY'))
{

    function App_Get_Client_Company_By_CATEGORY($Company_id,$CATEGORY_id)
    {
        app()->load->database();
        $query = app()->db->where('type_id',$CATEGORY_id);
        $query = app()->db->where('company_id',$Company_id);
        $query = app()->db->where('is_deleted',0);
        $query = app()->db->get('portal_app_client');
        return $query;
    }

}
##############################################################################



##############################################################################
if(!function_exists('App_Client_Contract_Company'))
{

    function App_Client_Contract_Company($Company_id,$Client_id)
    {
        app()->load->database();

        $query = app()->db->where('Clients_id',$Client_id);
        $query = app()->db->where('Company_id',$Company_id);
        $query = app()->db->get('portal_app_client_contract');
        return $query;
    }

}
##############################################################################

##############################################################################
if(!function_exists('GET_Client_Contract_Company'))
{
    function GET_Client_Contract_Company($Company_id,$Client_id,$contract_id)
    {
        app()->load->database();
        $query = app()->db->where('Clients_id',$Client_id);
        $query = app()->db->where('Company_id',$Company_id);
        $query = app()->db->where('contract_id',$contract_id);
        $query = app()->db->get('portal_app_client_contract');
        return $query;
    }
}
##############################################################################






?>