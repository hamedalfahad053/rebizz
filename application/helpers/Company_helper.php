<?php


##############################################################################
if(!function_exists('Get_All_Company'))
{

    function Get_All_Company($where_extra)
    {
        app()->load->database();

        if(!empty($where_extra)){
            foreach ($where_extra AS $key => $value)
            {
                $query = app()->db->where($key,$value);
            }
        }
        $query = app()->db->get('portal_company');
        return $query;
    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_Company'))
{

    function Get_Company($Company_id)
    {
        app()->load->database();
        $query = app()->db->where('company_id',$Company_id);
        $query = app()->db->get('portal_company')->row();
        return $query;
    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_Locations'))
{

    function Get_Locations($where_extra)
    {
        app()->load->database();

        if(!empty($where_extra)){
            foreach ($where_extra AS $key => $value)
            {
                $query = app()->db->where($key,$value);
            }
        }
        $query = app()->db->get('portal_company_locations')->row();
        return $query;
    }

}
##############################################################################


##############################################################################
if(!function_exists('company_settings_system'))
{
    function company_settings_system($Company_id,$settings_key)
    {
        app()->load->database();
        $query = app()->db->where('company_id',$Company_id);
        $query = app()->db->where('settings_key',$settings_key);
        $query = app()->db->get('portal_company_settings_system')->row();
        return $query->settings_value;
    }
}
##############################################################################





























