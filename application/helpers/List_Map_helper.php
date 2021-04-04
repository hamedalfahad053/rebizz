<?php

##############################################################################
if(!function_exists('Get_Countries')) {

    function Get_Countries($countries_id='')
    {
        app()->load->database();

        if(!empty($countries_id)){
            $query = app()->db->where('countries_id',$countries_id);
            $query = app()->db->or_where('country_code',$countries_id);
        }

        $query = app()->db->get('portal_map_countries');
        return $query;
    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_Regions')) {

    function Get_Regions($countries_id,$Regions_id='')
    {

        $where = '';

        app()->load->database();

        if(!empty($Regions_id)){
            $where  = " and `region_id` = (".$Regions_id.") ";
        }

        $query = app()->db->query('SELECT astext(center) AS Point,code,name_ar,name_en,capital_city_id,region_id From `portal_map_regions` where `countries_id` = '.$countries_id.' '.$where.' ');

        return $query;
    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_City')) {

    function Get_City($countries_id,$Regions_id,$cites_id='')
    {
        app()->load->database();

        if(!empty($cites_id)){
            $query = app()->db->where('city_id',$cites_id);
        }

        $query = app()->db->where('countries_id',$countries_id);
        $query = app()->db->where('region_id',$Regions_id);

        $query = app()->db->get('portal_map_cities');
        return $query;
    }

}
##############################################################################


##############################################################################
if(!function_exists('Get_Districts')) {

    function Get_Districts($countries_id,$Regions_id,$cites_id,$district_id='')
    {
        app()->load->database();

        $where = '';

        if(!empty($district_id)){
            $where  = " and `district_id` = (".$district_id.") ";
        }


        $query = app()->db->query('SELECT astext(boundaries) AS Point,district_id,city_id,region_id,countries_id,name_ar,name_en From `portal_map_districts` where `countries_id` = '.$countries_id.'  
         and `region_id` = '.$Regions_id.' and `city_id` = '.$cites_id.'   '.$where.' ');

        return $query;
    }

}
##############################################################################


##############################################################################
if(!function_exists('Get_Districts')) {

    function Get_Districts($countries_id,$Regions_id,$cites_id,$district_id='')
    {
        app()->load->database();

        $where = '';

        if(!empty($district_id)){
            $where  = " and `district_id` = (".$district_id.") ";
        }


        $query = app()->db->query('SELECT astext(boundaries) AS Point,district_id,city_id,region_id,countries_id,name_ar,name_en From `portal_map_districts` where `countries_id` = '.$countries_id.'  
         and `region_id` = '.$Regions_id.' and `city_id` = '.$cites_id.'   '.$where.' ');

        return $query;
    }

}
##############################################################################
