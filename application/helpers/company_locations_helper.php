<?php

##############################################################################
if(!function_exists('Get_Company_Locations'))
{
    function Get_Company_Locations($where_extra='')
    {
        app()->load->database();
        if(!empty($where_extra)) {
            foreach ($where_extra AS $key => $value)
            {
              $query = app()->db->where($key,$value);
            }
        }
        $query = app()->db->get('portal_company_locations');
        return $query;
    }
}
##############################################################################



















