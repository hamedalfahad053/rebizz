<?php

##############################################################################
if(!function_exists('Get_Data_List')) {

    function Get_Data_List($type_list,$key_list)
    {
        app()->load->database();

        $html   = '';
        $lang   = get_current_lang();

        $query_list = app()->db->from('portal_list_data list');
        $query_list = app()->db->join('portal_list_data_translation  list_translation', 'list.list_id=list_translation.item_id');
        $query_list = app()->db->where('list.list_data_key',$key_list);
        $query_list = app()->db->where('list_translation.translation_lang',$lang);
        $query_list = app()->db->get()->row();


        $query_list_options = app()->db->from('portal_list_options_data list_options');
        $query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
        $query_list_options = app()->db->where('list_options.list_id',$query_list->list_id);
        $query_list_options = app()->db->where('list_options.options_status',1);
        $query_list_options = app()->db->where('options_translation.translation_lang',$lang);
        $query_list_options = app()->db->order_by('list_options.options_sort','ASC');
        $query_list_options = app()->db->get();


        if($type_list=='select'){

            $html .= '<select name="'.$query_list->list_data_key.'" class="form-control selectpicker" data-live-search="true">';

            foreach ($query_list_options->result() AS $row  )
            {
                $html .= '<option value="'.$row->list_options_id.'">'.$row->item_translation.'</option>';
            }

            $html .= '</select>';

        }elseif($type_list=='checkbox') {


        }elseif($type_list=='radio'){


        }else{
            $html = false;
        }

        return $html;

    } // function Get_Data_List($type_list,$key_list)

}
##############################################################################





