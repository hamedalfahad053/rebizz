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

        if(!empty($Forms_id)){
            $query = app()->db->where('forms.Forms_Key',$Forms_id);
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

        if(!empty($Forms_id)){
            $query = app()->db->where('sections_components.Forms_id',$Forms_id);
        }

        $query = app()->db->where('sections_components.components_isDeleted',0);

        $query = app()->db->where('sections_components_translation.translation_lang',$lang);
        $query = app()->db->get();
        return $query;
    }
}
##############################################################################

##############################################################################
if(!function_exists('Get_Fields_Components_Default')) {

    function Get_Fields_Components_Default($Forms_id,$Components_id)
    {
        app()->load->database();

        $Fields =  array();
        $List   =  array();
        $lang   = get_current_lang();

        $query = app()->db->where('Forms_id',$Forms_id);
        $query = app()->db->where('Components_id',$Components_id);
        $query = app()->db->get('portal_forms_sections_components_fields')->result();

        foreach ($query AS $RC) {

            if ($RC->Fields_Type === 'Fields') {

                $query_Fields = app()->db->from('portal_fields fields');
                $query_Fields = app()->db->join('portal_fields_translation fields_translation', 'fields_translation.item_id = fields.Fields_id');
                $query_Fields = app()->db->where('fields.Fields_id', $RC->Fields_id);
                $query_Fields = app()->db->where('fields_translation.translation_lang', $lang);
                $query_Fields = app()->db->get()->row();
                $Fields[] = array(
                    'components_id'          => $Components_id,
                    'Fields_id_Components'   => $RC->Components_fields_id,
                    'Fields_id'              => $query_Fields->Fields_id,
                    'Fields_Type_Components' => $RC->Fields_Type,
                    'Fields_Type'            => 'Select',
                    'Fields_Title'           => $query_Fields->item_translation,
                    'Fields_key'             => $query_Fields->Fields_key
                );

            } elseif ($RC->Fields_Type === 'List') {

                $query_Fields = app()->db->from('portal_list_data list');
                $query_Fields = app()->db->join('portal_list_data_translation  list_translation', 'list.list_id=list_translation.item_id');
                $query_Fields = app()->db->where('list.list_id', $RC->Fields_id);
                $query_Fields = app()->db->where('list_translation.translation_lang', $lang);
                $query_Fields = app()->db->get()->row();
                $List[] = array(
                    'components_id'          => $Components_id,
                    'Fields_id_Components'   => $RC->Components_fields_id,
                    'Fields_id'              => $query_Fields->list_id,
                    'Fields_Type_Components' => $RC->Fields_Type,
                    'Fields_Type'            => 'Select',
                    'Fields_Title'           => $query_Fields->item_translation,
                    'Fields_key'             => $query_Fields->list_data_key
                );
            }

        }

        $Fields_all = array_merge($List,$Fields);

        return $Fields_all;

    }
}
##############################################################################









