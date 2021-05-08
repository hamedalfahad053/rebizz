<?php


##############################################################################
if(!function_exists('Get_Property_Types'))
{

    function Get_Property_Types($where_extra='')
    {
        app()->load->database();

        $lang   = get_current_lang();

        $query_list = app()->db->from('portal_list_property_types property_types');
        $query_list = app()->db->join('portal_list_property_types_translation  property_types_translation', 'property_types.Property_Types_id=property_types_translation.item_id');

        if(!empty($where_extra)){
            foreach ($where_extra AS $key => $value)
            {
                $query_list = app()->db->where($key,$value);
            }
        }

        $query_list = app()->db->where('property_types_translation.translation_lang',$lang);
        $query_list = app()->db->get();
        return $query_list;
    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_Select_Property_Types')) {

    function Get_Select_Property_Types($type_list, $where_options='',$multiple = 0, $plugins ='',$name_field,$js='')
    {
        app()->load->database();

        $lang   = get_current_lang();

        $html   = '';

        $query_list = app()->db->from('portal_list_property_types property_types');
        $query_list = app()->db->join('portal_list_property_types_translation  property_types_translation', 'property_types.Property_Types_id=property_types_translation.item_id');

        $query_list = app()->db->where('property_types.Property_Types_isDeleted',0);
        $query_list = app()->db->where('property_types_translation.translation_lang',$lang);


        if(!empty($where_options)){
            foreach ($where_options as $key => $value){
                $query_list = app()->db->where('property_types.'.$key.'',$value);
            }
        }

        $query_list = app()->db->get();


        $plugins_ = '  ';
        if (is_array($plugins)) {
            foreach ($plugins as $c) {
                $plugins_ .= ' ' . $c;
            }
        }

        if($multiple   = 1){
            $multiple  = ' multiple data-actions-box="true"';
            $name_form = 'Property_Types[]';
        }else{
            $name_form = $name_field;
            $multiple  = '';
        }



        if(!empty($js)){
            $js_ = 'onclick="'.$js.'"';
        }else{
            $js_ = '';
        }

        if($type_list=='select')
        {
            $html .= '<select name="'.$name_form.'" id="Property_Types" title="' . lang('Select_noneSelectedText') . '" class="form-control ' . $plugins_ . '" ' . $multiple . '
             data-live-search="true">';

            foreach ($query_list->result() as $row) {
                $html .= '<option value="' . $row->Property_Types_id . '">' . $row->item_translation . '</option>';
            }

            $html .= '</select>';
        }

            return $html;


    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_Property_Types_Of_Categories'))
{
    function Get_Property_Types_Of_Categories($Categories_Property_id)
    {
        app()->load->database();
        $lang   = get_current_lang();
        $query_list = app()->db->from('portal_list_property_types property_types');
        $query_list = app()->db->join('portal_list_property_types_translation  property_types_translation', 'property_types.Property_Types_id=property_types_translation.item_id');
        $query_list = app()->db->where_in('property_types.Categories_Property_id',$Categories_Property_id);
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











