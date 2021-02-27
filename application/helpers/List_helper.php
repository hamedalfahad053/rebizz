<?php

##############################################################################
if(!function_exists('Get_Data_List')) {

    function Get_Data_List($type_list, $key_list, $where_options='', $plugins ='')
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

        if(!empty($where_options)){
            foreach ($where_options as $key => $value){
                $query_list_options = app()->db->where('list_options.'.$key.'',$value);
            }
        }

        $query_list_options = app()->db->where('options_translation.translation_lang',$lang);
        $query_list_options = app()->db->order_by('list_options.options_sort','ASC');
        $query_list_options = app()->db->get();


        if($plugins == 'none'){
            $plugins_ = '';
        }else{
            $plugins_ = 'selectpicker';
        }

        if($type_list=='select'){

            $html .= '<select name="'.$query_list->list_data_key.'" title="'.lang('Select_noneSelectedText').'" id="'.$query_list->list_data_key.'" class="form-control '.$plugins_.'" data-live-search="true">';

            foreach ($query_list_options->result() AS $row  )
            {
                $html .= '<option value="'.$row->list_options_id.'">'.$row->item_translation.'</option>';
            }

            $html .= '</select>';

        }elseif($type_list=='checkbox') {

            $html .= '<input type="checkbox" name="'.$query_list->list_data_key.'[]" value="'.$row->list_options_id.'" id="'.$query_list->list_data_key.'">'.$row->item_translation.'  ';


        }elseif($type_list=='radio'){

            foreach ($query_list_options->result() AS $row  )
            {
                $html .= '<input type="radio" name="'.$query_list->list_data_key.'[]" value="'.$row->list_options_id.'" id="'.$query_list->list_data_key.'">'.$row->item_translation.'  ';
            }

        }else{
            $html = false;
        }

        return $html;

    } // function Get_Data_List($type_list,$key_list)

}
##############################################################################



##############################################################################
if(!function_exists('Get_All_List')) {

    function Get_All_List($list_id='')
    {
        app()->load->database();

        $lang   = get_current_lang();

        $query_list = app()->db->from('portal_list_data list');
        $query_list = app()->db->join('portal_list_data_translation  list_translation', 'list.list_id=list_translation.item_id');

        if(!empty($list_id)){
            $query_list = app()->db->where('list.list_data_key',$list_id);
            $query_list = app()->db->or_where('list.list_id',$list_id);
        }

        $query_list = app()->db->where('list_translation.translation_lang',$lang);
        $query_list = app()->db->get();

        return $query_list;

    } // function Get_Data_List($type_list,$key_list)

}
##############################################################################

##############################################################################
if(!function_exists('Get_All_List_By_Status')) {

    function Get_All_List_By_Status($list_id='')
    {
        app()->load->database();

        $lang   = get_current_lang();

        $query_list = app()->db->from('portal_list_data list');
        $query_list = app()->db->join('portal_list_data_translation  list_translation', 'list.list_id=list_translation.item_id');

        if(!empty($list_id)){
            $query_list = app()->db->where('list.list_data_key',$list_id);
            $query_list = app()->db->or_where('list.list_id',$list_id);
        }

        $query_list = app()->db->where('list.list_data_status',1);

        $query_list = app()->db->where('list_translation.translation_lang',$lang);
        $query_list = app()->db->get();

        return $query_list;

    } // function Get_Data_List($type_list,$key_list)

}
##############################################################################


##############################################################################
if(!function_exists('Get_All_options_List_by_id')) {

    function Get_All_options_List_by_id($list_id)
    {
        app()->load->database();
        $lang = get_current_lang();
        $query_list_options = app()->db->from('portal_list_options_data list_options');
        $query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
        $query_list_options = app()->db->where('list_options.list_id',$list_id);
        $query_list_options = app()->db->where('options_translation.translation_lang',$lang);
        $query_list_options = app()->db->get();
        return $query_list_options;
    }

}
##############################################################################


##############################################################################
if(!function_exists('Get_options_List_Translation')) {

    function Get_options_List_Translation($item_id)
    {
        app()->load->database();

        $lang = get_current_lang();

        $query_list_options = app()->db->where('item_id',$item_id);
        $query_list_options = app()->db->where('translation_lang',$lang);
        $query_list_options = app()->db->get('portal_list_options_translation');

        return $query_list_options->row();
    }

}
##############################################################################






