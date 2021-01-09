<?php

##############################################################################
if(!function_exists('Get_Info_evaluation_methods'))
{

    function Get_Evaluation_Types($Evaluation_Types_id='')
    {
        app()->load->database();

        $lang   = get_current_lang();
        $query = app()->db->from('portal_evaluation_types evaluation_types');
        $query = app()->db->join('portal_evaluation_types_translation  evaluation_types_translation',
            'evaluation_types.evaluation_types_id = evaluation_types_translation.item_id');

        if(!empty($evaluation_methods_id)){
            $query = app()->db->where('evaluation_types.evaluation_types_id',$Evaluation_Types_id);
            $query = app()->db->or_where('evaluation_types.evaluation_types_Key',$Evaluation_Types_id);
        }

        $query = app()->db->where('evaluation_types_translation.translation_lang',$lang);
        $query = app()->db->get();
        return $query;
    }

}
##############################################################################




##############################################################################
if(!function_exists('Get_Info_evaluation_methods'))
{

    function Get_Info_evaluation_methods($evaluation_methods_id='')
    {
        app()->load->database();

        $lang   = get_current_lang();

        $query = app()->db->from('portal_evaluation_methods evaluation_methods');

        $query = app()->db->join('portal_evaluation_methods_translation  evaluation_methods_translation',
                                      'evaluation_methods.evaluation_methods_id = evaluation_methods_translation.item_id');

        if(!empty($evaluation_methods_id)){

            $query = app()->db->where('evaluation_methods.evaluation_methods_id',$evaluation_methods_id);
            $query = app()->db->or_where('evaluation_methods.evaluation_methods_Key',$evaluation_methods_id);

        }

        $query = app()->db->where('evaluation_methods_translation.translation_lang',$lang);
        $query = app()->db->get();

        return $query;
    }

}
##############################################################################




?>