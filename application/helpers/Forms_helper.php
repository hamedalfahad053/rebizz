<?php


##############################################################################
if(!function_exists('Get_All_Forms'))
{

    function Get_All_Forms($Forms_id='')
    {
        app()->load->database();

        $lang   = get_current_lang();

        $query_Forms = app()->db->from('portal_forms  forms');
        $query_Forms = app()->db->join('portal_forms_translation  forms_translation', 'forms.Forms_id=forms_translation.item_id');

        if(!empty($Fields_id)){
            $query_Forms = app()->db->where('forms.Forms_id',$Forms_id);
            $query_Forms = app()->db->or_where('forms.Forms_Key',$Forms_id);
        }

        $query_Forms = app()->db->where('forms_translation.translation_lang',$lang);
        $query_Forms = app()->db->get();
        return $query_Forms;
    }

}
##############################################################################


##############################################################################
if(!function_exists('Get_Sections_Form_Components')) {

    function Get_Sections_Form_Components($Forms_id='')
    {
        app()->load->database();

        $query = app()->db->from('portal_forms_sections_components  sections_components');
        $query = app()->db->join('portal_forms_sections_components_translation   sections_components_translation', 'sections_components.components_id = sections_components_translation.item_id');

        $lang   = get_current_lang();

        if(empty($Forms_id)){
            $query = app()->db->where('sections_components.Forms_id',$Forms_id);
        }
        $query = app()->db->where('sections_components_translation.translation_lang',$lang);
        $query = app()->db->get();

        return $query;
    }
}
##############################################################################

##############################################################################
if(!function_exists('Get_Fields_components')) {

    function Get_Fields_components($Forms_id,$Components_id)
    {
        app()->load->database();

        $lang   = get_current_lang();

        $query = app()->db->from('portal_forms_sections_components_fields  components_fields');
        $query = app()->db->join('portal_fields fields', 'components_fields.Fields_id = fields.Fields_id');
        $query = app()->db->join('portal_fields_translation fields_translation', 'fields_translation.item_id = fields.Fields_id');

        $query = app()->db->where('components_fields.Forms_id',$Forms_id);
        $query = app()->db->where('components_fields.Components_id',$Components_id);
        $query = app()->db->where('fields_translation.translation_lang',$lang);


        $query = app()->db->get();

        return $query;

    }
}
##############################################################################

##############################################################################
if(!function_exists('Get_Data_Fields_without_old_add_components')) {

    function Get_Data_Fields_without_old_add_components($Forms_id = '')
    {
        app()->load->database();
        $lang   = get_current_lang();


    }
}
##############################################################################