<?php

##############################################################################
if(!function_exists('Create_List')) {

    function Create_List($data)
    {

        $query = app()->db->insert('portal_list_data',$data);

        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }

    }
}
##############################################################################

##############################################################################
if(!function_exists('Get_All_List')) {

    function Get_All_List($where_extra = '')
    {
        app()->load->database();

        $lang       = get_current_lang();
        $query_list = app()->db->from('portal_list_data list');
        $query_list = app()->db->join('portal_list_data_translation  list_translation', 'list.list_id=list_translation.item_id');

        if(!empty($where_extra)){
            foreach ($where_extra AS $key => $value)
            {
                $query_list = app()->db->where('list.'.$key,$value);
            }
        }

        $query_list = app()->db->where('list_translation.translation_lang',$lang);
        $query_list = app()->db->get();
        return $query_list;
    } // function Get_Data_List($type_list,$key_list)
}
##############################################################################

##############################################################################
if(!function_exists('Creation_List_HTML')) {

    function Creation_List_HTML($type='',$key_list,$where_list ='',$where_options ='',$type_list='',$multiple = '',$selected='',$style='',$id='',$class='',$disabled='',$label='',$js='')
    {
        app()->load->database();

        $form_dropdown = '';
        $extra_options = array();
        $options_list  = array();
        $options       = [];
        $lang          = get_current_lang();


        $query_list = app()->db->from('portal_list_data list');
        $query_list = app()->db->join('portal_list_data_translation  list_translation', 'list.list_id=list_translation.item_id');
        $query_list = app()->db->where('list.list_key', $key_list);
        $query_list = app()->db->where('list_translation.translation_lang', $lang);

        if (!empty($where_list)) {
            foreach ($where_list as $key => $value) {
                $query_list = app()->db->where('list.' . $key . '', $value);
            }
        }

        $query_list = app()->db->get()->row();

        ###########################################################################################################
        # List Type
        ###########################################################################################################
        if($query_list->list_type == 'OPTIONS'){

               $query_list_options = app()->db->from('portal_list_options_data list_options');
               $query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
               $query_list_options = app()->db->where('list_options.list_id', $query_list->list_id);

               if (!empty($where_options)) {
                   foreach ($where_options as $key => $value) {
                       $query_list_options = app()->db->where('list_options.' . $key . '', $value);
                   }
               }

               $query_list_options = app()->db->where('options_translation.translation_lang', $lang);
               $query_list_options = app()->db->order_by('list_options.options_sort', 'ASC');
               $query_list_options = app()->db->get();

               //print_r($query_list_options->result());

               foreach ($query_list_options->result() as $row)
               {
                   $options[] = array(
                       "options_id"    => $row->list_options_id,
                       "options_key"   => $row->options_key,
                       "options_type"  => 'options',
                       "options_title" => $row->item_translation
                   );
               }


        }elseif($query_list->list_type == 'TABLE'){


            if($query_list->Linking_table_Join == NULL){

                $query_list_options = app()->db->get($query_list->Table_primary);

                foreach ($query_list_options->result() as $row)
                {
                    $Table_primary_fields                 = $query_list->Table_primary_fields;
                    $Table_Join_fields                    = $query_list->Table_Join_fields;

                    $options[] = array(
                        "options_id"    => $Table_primary_fields,
                        "options_key"   => '',
                        "options_type"  => 'table',
                        "options_title" => $query_list->Table_Join_fields,
                    );
                }

            }else{

                $query_list_options = app()->db->from($query_list->Table_primary.' Table_Primary');
                $query_list_options = app()->db->join($query_list->Table_Join.'    Table_Join', 'Table_Primary.'.$query_list->Table_primary_fields.' = Table_Join.'.$query_list->Table_Join_fields.'');
                $query_list_options = app()->db->get();

                foreach ($query_list_options->result() as $row)
                {
                    $Table_primary_fields = $query_list->Table_primary_fields;
                    $Table_Join_fields    = $query_list->Table_Join_fields;

                    $options[] = array(
                        "options_id"    => $Table_primary_fields,
                        "options_key"   => '',
                        "options_type"  => 'table',
                        "options_title" => $Table_Join_fields,
                    );

                }

            } //if($query_list->Linking_table_Join == NULL)

        }
        ###########################################################################################################
        # List Type
        ###########################################################################################################

            $class_output = ' form-control ';
            if (is_array($class)) {
                foreach ($class as $c) {
                    $class_output .= $class_output . ' ' . $c;
                }
            }

            if(empty($id)){
                $id_ = 'id="'.$query_list->list_key.'"';
            }else{
                $id_ = 'id="'.$id.'"';
            }

            if(!empty($style)){
                $style_ = 'style="'.$style.'"';
            }else{
                $style_ = '';
            }

            if(!empty($disabled)){
                $disabled_ = "disabled ='disabled' ";
            }else{
                $disabled_ = '';
            }

            if(!empty($label)){
                $label_ = '';
            }else{
                $label_ = '';
            }

            if(!empty($multiple)){
                $multiple_ = 'multiple="multiple"';
                $name      = 'name="'.$query_list->list_key.'[]"';
            }else{
                $multiple_ = '';
                $name = 'name="'.$query_list->list_key.'"';
            }

            if(!empty($js)){
                $js_ = 'onClick="'.$js.'"';
            }else{
                $js_ = '';
            }

            $title_ = 'title="'.lang("Select_noneSelectedText").'"';

            $form_dropdown .= '<select data-live-search="true" data-size="5" '.$name.' class="'.$class_output.'" '.$id_.' '.$style_.' '.$disabled_.'  '.$title_.' '.$multiple_.' '.$js_.'>';

            if($type_list == 'options' or $type_list == 'options_ajax'){
                foreach ($options as $op)
                {
                    $form_dropdown .= '<option value="'.$op['options_id'].'" data-key="'.$op['options_key'].'" data-type="'.$op['options_type'].'">'.$op['options_title'].'</option>';
                }
            }

            $form_dropdown .= '</select>';

        return $form_dropdown;

    }
}
##############################################################################





##############################################################################
if(!function_exists('Create_options')) {

    function Create_options($data)
    {
        $query = app()->db->insert('portal_list_options_data',$data);
        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }
    }
}
##############################################################################


##############################################################################
if(!function_exists('Get_options_List')) {

    function Get_options_List($list_id,$where_options = '')
    {
        $lang          = get_current_lang();
        $options       = array();

        $query_list_options = app()->db->from('portal_list_options_data list_options');
        $query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
        $query_list_options = app()->db->where('list_options.list_id', $list_id);
        $query_list_options = app()->db->where('list_options.options_status', 1);

        if (!empty($where_options)) {
            foreach ($where_options as $key => $value) {
                $query_list_options = app()->db->where('list_options.' . $key . '', $value);
            }
        }

        $query_list_options = app()->db->where('options_translation.translation_lang', $lang);
        $query_list_options = app()->db->order_by('list_options.options_sort', 'ASC');
        $query_list_options = app()->db->get();

        if($query_list_options->num_rows() >0 ) {
            foreach ($query_list_options->result() as $row) {

                $options[$row->list_options_id] = $row->item_translation;
                $attr[$row->list_options_id] = array(
                    "type-item" => 'options',
                    "data-Table" => "options",
                    'data-id' => $row->list_options_id,
                    'data-key' => $row->options_key
                );
            }
        }else{
            $options = false;
        }

        return $options;
    }
}
##############################################################################

##############################################################################
if(!function_exists('query_options_List')) {

    function query_options_List($list_id, $where_options = '')
    {
        if (!empty($where_options)) {
            foreach ($where_options as $key => $value) {
                $query_list_options = app()->db->where($key,$value);
            }
        }
        $query_list_options = app()->db->where('list_id',$list_id);
        $query_list_options = app()->db->get('portal_list_options_data');

        return $query_list_options;
    }
}
##############################################################################

##############################################################################
if(!function_exists('query_All_options_List')) {

    function query_All_options_List($list_id,$where_options = '')
    {
        $lang          = get_current_lang();
        $options       = array();

        $query_list_options = app()->db->from('portal_list_options_data list_options');
        $query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
        $query_list_options = app()->db->where('list_options.list_id', $list_id);

        if (!empty($where_options)) {
            foreach ($where_options as $key => $value) {
                $query_list_options = app()->db->where('list_options.' . $key . '', $value);
            }
        }

        $query_list_options = app()->db->where('options_translation.translation_lang', $lang);
        $query_list_options = app()->db->order_by('list_options.options_sort', 'ASC');
        $query_list_options = app()->db->get();

        return $query_list_options;
    }
}
##############################################################################


##############################################################################
if(!function_exists('Update_Custom_Options'))
{
    function Update_Custom_Options($options_uuid,$options_company_id,$options_Status)
    {
        app()->load->database();

        $Update_Options = app()->db->where('options_uuid',$options_uuid);
        $Update_Options = app()->db->where('options_company_id',$options_company_id);
        $Update_Options = app()->db->set('options_lastModifyDate',time());
        $Update_Options = app()->db->set('options_status',$options_Status);
        $Update_Options = app()->db->update('portal_list_options_data');

        if($Update_Options){
            return true;
        }else{
            return false;
        }
    }
}
##############################################################################


##############################################################################
if(!function_exists('Get_options_List_Translation')) {

    function Get_options_List_Translation($options_id,$where_options='')
    {
        $lang          = get_current_lang();

        if (!empty($where_options)) {
            foreach ($where_options as $key => $value) {
                $query_list_options = app()->db->where( $key,$value);
            }
        }

        $query_list_options = app()->db->where('item_id', $options_id);
        $query_list_options = app()->db->where('translation_lang', $lang);
        $query_list_options = app()->db->get('portal_list_options_translation')->row();

        return $query_list_options;
    }
}
##############################################################################








