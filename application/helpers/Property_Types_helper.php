<?php


##############################################################################
if(!function_exists('Get_Property_Types'))
{

    function Get_Property_Types($Property_Types='')
    {
        app()->load->database();

        $lang   = get_current_lang();

        $query_list = app()->db->from('portal_list_property_types property_types');
        $query_list = app()->db->join('portal_list_property_types_translation  property_types_translation', 'property_types.Property_Types_id=property_types_translation.item_id');

        if(!empty($Property_Types)){
            $query_list = app()->db->where('property_types.Property_Types_id',$Property_Types);
            $query_list = app()->db->or_where('property_types.Property_Types_key',$Property_Types);
        }

        $query_list = app()->db->where('property_types_translation.translation_lang',$lang);
        $query_list = app()->db->get();
        return $query_list;
    }

}
##############################################################################




##############################################################################
if(!function_exists('Get_Sections_Types_Property_Components')) {

    function Get_Sections_Types_Property_Components($Property_Types='')
    {
        $query = app()->db->from('portal_list_property_types_sections_components  sections_components');
        $query = app()->db->join('portal_list_property_types_sections_components_translation   sections_components_translation', 'sections_components.components_id = sections_components_translation.item_id');

        $lang   = get_current_lang();

        if(empty($Property_Types)){
            $query = app()->db->where('sections_components.components_id',$Property_Types);
            $query = app()->db->or_where('sections_components.components_key',$Property_Types);
        }

        $query = app()->db->where('sections_components_translation.translation_lang',$lang);
        $query = app()->db->get();

        return $query;
    }

}
##############################################################################











