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
if(!function_exists('Get_Form_Components')) {

    function Get_Form_Components($form_id,$where_extra = '')
    {
        app()->load->database();
        $lang   = get_current_lang();


        $query = app()->db->from('portal_forms_components  components');
        $query = app()->db->join('portal_forms_components_translation   components_translation', 'components.components_id = components_translation.item_id');

        $query = app()->db->where('components_translation.translation_lang',$lang);
        $query = app()->db->order_by('components.components_sort','ASC');
        $query = app()->db->where('components.Forms_id',$form_id);

        if(!empty($where_extra)){

            foreach ($where_extra AS $key => $value)
            {
                $query = app()->db->where($key,$value);
            }
        }

        $query = app()->db->get();
        return $query;
    }
}
##############################################################################


##############################################################################
if(!function_exists('Update_Sort_Form_Components')) {

    function Update_Sort_Form_Components($Forms_id,$Components_id,$Sort)
    {
        app()->load->database();
        $lang   = get_current_lang();

        $query = app()->db->where('Forms_id',$Forms_id);
        $query = app()->db->where('Components_id',$Components_id);
        $query = app()->db->set('components_sort',$Sort);
        $query = app()->db->update('portal_forms_components');

        if(app()->db->affected_rows()){
            return true;
        }else{
            return false;
        }

    }
}
##############################################################################


##############################################################################
if(!function_exists('Update_Sort_Fields_Components')) {

    function Update_Sort_Fields_Components($Forms_id,$Components_id,$Fields_id,$Sort)
    {
        app()->load->database();
        $lang   = get_current_lang();

        $query = app()->db->where('Forms_id',$Forms_id);
        $query = app()->db->where('Components_id',$Components_id);
        $query = app()->db->where('Fields_id',$Fields_id);
        $query = app()->db->set('Fields_Sort',$Sort);
        $query = app()->db->update('portal_forms_components_fields');

        if(app()->db->affected_rows()){
            return true;
        }else{
            return false;
        }

    }
}
##############################################################################


##############################################################################

if(!function_exists('Query_Fields_Components')) {

    function Query_Fields_Components($where_extra)
    {
        if(!empty($where_extra))
        {
            foreach ($where_extra AS $key => $value)
            {
                $query = app()->db->where($key,$value);
            }
        }

        $query = app()->db->get('portal_forms_components_fields');
        return $query;
    }
}
##############################################################################


##############################################################################
if(!function_exists('Get_Fields_Components')) {

    function Get_Fields_Components($Forms_id,$Components_id,$where_extra='')
    {
        app()->load->database();

        $Fields =  array();
        $List   =  array();
        $lang   = get_current_lang();

        $query = app()->db->where('Forms_id',$Forms_id);
        $query = app()->db->where('Components_id',$Components_id);

        if(!empty($where_extra))
        {
            foreach ($where_extra AS $key => $value)
            {
                $query = app()->db->where($key,$value);
            }
        }
        $query = app()->db->get('portal_forms_components_fields')->result();

        foreach ($query AS $RC) {


            if($RC->With_Type_CUSTOMER == 'All'){
                $Fields_With_Type_CUSTOMER = lang('All_Components_Filed');
            }else{

                $Fields_With_Type_CUSTOMER = array();
                $array_Type_CUSTOMER       = explode(",",$RC->With_Type_CUSTOMER);

                foreach ($array_Type_CUSTOMER AS $key_WTC)
                {
                    $Fields_With_Type_CUSTOMER[] =  Get_options_List_Translation($key_WTC)->item_translation;
                }

            }

            if($RC->With_Type_Property == 'All'){
                $Fields_With_Type_Property = lang('All_Components_Filed');
            }else{

                $Fields_With_Type_Property = array();
                $array_Type_Property       = explode(",",$RC->With_Type_Property);

                foreach ($array_Type_Property AS $key_TP)
                {
                    $Fields_With_Type_Property[] = Get_Property_Types(array("Property_Types_id"=>$key_TP))->row()->item_translation;
                }

            }

            if($RC->With_TYPES_APPRAISAL == 'All'){
                $Fields_With_TYPES_APPRAISAL = lang('All_Components_Filed');
            }else{

                $Fields_With_TYPES_APPRAISAL = array();
                $array_TYPES_APPRAISAL       = explode(",",$RC->With_TYPES_APPRAISAL);

                foreach ($array_TYPES_APPRAISAL AS $key_WTA)
                {
                    $Fields_With_TYPES_APPRAISAL[] =  Get_options_List_Translation($key_WTA)->item_translation;
                }
            }

            if($RC->With_Type_evaluation_methods == 'All'){
                $Fields_With_Type_evaluation_methods = lang('All_Components_Filed');
            }else{

                $Fields_With_Type_evaluation_methods = array();
                $array_Type_evaluation_methods       = explode(",",$RC->With_Type_evaluation_methods);

                foreach ($array_Type_evaluation_methods AS $key_TEM)
                {
                    $Fields_With_Type_evaluation_methods[] =  Get_Evaluation_Methods(array("evaluation_methods_id"=>$key_TEM))->row()->item_translation;
                }
            }


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
                    'Fields_Type'            => 'Field',

                    'Fields_With_Type_CUSTOMER'            => $Fields_With_Type_CUSTOMER,
                    'Fields_With_Type_Property'            => $Fields_With_Type_Property,
                    'Fields_With_TYPES_APPRAISAL'          => $Fields_With_TYPES_APPRAISAL,
                    'Fields_With_Type_evaluation_methods'  => $Fields_With_Type_evaluation_methods,

                    'Fields_Title'                         => $query_Fields->item_translation,
                    'Fields_key'                           => $query_Fields->Fields_key
                );

            } elseif ($RC->Fields_Type === 'List') {



                $query_Fields = app()->db->from('portal_list_data list');
                $query_Fields = app()->db->join('portal_list_data_translation  list_translation', 'list.list_id=list_translation.item_id');
                $query_Fields = app()->db->where('list.list_id', $RC->Fields_id);
                $query_Fields = app()->db->where('list_translation.translation_lang', $lang);
                $query_Fields = app()->db->get()->row();

                $List[] = array(
                    'components_id'                        => $Components_id,
                    'Fields_id_Components'                 => $RC->Components_fields_id,
                    'Fields_id'                            => $query_Fields->list_id,
                    'Fields_Type_Components'               => $RC->Fields_Type,
                    'Fields_Type'                          => 'Select',
                    'Fields_With_Type_CUSTOMER'            => $Fields_With_Type_CUSTOMER,
                    'Fields_With_Type_Property'            => $Fields_With_Type_Property,
                    'Fields_With_TYPES_APPRAISAL'          => $Fields_With_TYPES_APPRAISAL,
                    'Fields_With_Type_evaluation_methods'  => $Fields_With_Type_evaluation_methods,
                    'Fields_Title'                         => $query_Fields->item_translation,
                    'Fields_key'                           => $query_Fields->list_key
                );

            }

        }

        $Fields_all = array_merge($List,$Fields);

        return $Fields_all;
    }
}
##############################################################################



##############################################################################
if(!function_exists('Building_Fields_Components_Forms')) {

    function Building_Fields_Components_Forms($Forms_id, $Components_id,$Type_CUSTOMER,$Type_Property,$TYPES_APPRAISAL,$evaluation_methods)
    {

        app()->load->database();
        $lang   = get_current_lang();

        $Build      = false;
        $Fields     = array();
        $List       = array();
        $Fields_all = array();


        $query = app()->db->where('Forms_id', $Forms_id);
        $query = app()->db->where('Components_id', $Components_id);
        $query = app()->db->order_by('Fields_Sort','ASC');
        $query = app()->db->get('portal_forms_components_fields');

        foreach ($query->result() as $RC) {


                $array_CUSTOMER   = explode(',',$RC->With_Type_CUSTOMER);
                $array_Property   = explode(',',$RC->With_Type_Property);
                $array_APPRAISAL  = explode(',',$RC->With_TYPES_APPRAISAL);
                $array_evaluation = explode(',',$RC->With_Type_evaluation_methods);

                if(in_array($Type_CUSTOMER,$array_CUSTOMER)        or $RC->With_Type_CUSTOMER == 'All')                 { $Build = true;  }
                if(in_array($Type_Property,$array_Property)        or $RC->With_TYPES_APPRAISAL == 'All')               { $Build = true;  }
                if(in_array($TYPES_APPRAISAL,$array_APPRAISAL)     or $RC->With_Type_Property == 'All')                 { $Build = true;  }
                if(in_array($evaluation_methods,$array_evaluation) or $RC->With_Type_evaluation_methods == 'All')       { $Build = true;  }

                if($Build == true){

                    if($RC->Fields_Type == 'Fields'){

                        $query_Fields = app()->db->from('portal_fields fields');
                        $query_Fields = app()->db->join('portal_fields_translation fields_translation', 'fields_translation.item_id = fields.Fields_id');
                        $query_Fields = app()->db->where('fields.Fields_id', $RC->Fields_id);
                        $query_Fields = app()->db->where('fields_translation.translation_lang', $lang);

                        # Custom Company and Clint id
                        //if(){

                        //}

                        $query_Fields = app()->db->get()->row();
                        $Fields[] = array(
                            'components_id'          => $Components_id,
                            'Fields_id_Components'   => $RC->Components_fields_id,
                            'Fields_id'              => $query_Fields->Fields_id,
                            'Fields_Type_Components' => $RC->Fields_Type,
                            'Fields_Type'            => 'Fields',
                            'Fields_Title'           => $query_Fields->item_translation,
                            'Fields_key'             => $query_Fields->Fields_key,
                            'Fields_data'            => $RC->Fields_data
                        );

                    } elseif ($RC->Fields_Type == 'List') {

                        $query_Fields = app()->db->from('portal_list_data list');
                        $query_Fields = app()->db->join('portal_list_data_translation  list_translation', 'list.list_id=list_translation.item_id');
                        $query_Fields = app()->db->where('list.list_id', $RC->Fields_id);
                        $query_Fields = app()->db->where('list_translation.translation_lang', $lang);
                        $query_Fields = app()->db->get()->row();

                        $List[] = array(
                            'components_id'               => $Components_id,
                            'Fields_id_Components'        => $RC->Components_fields_id,
                            'Fields_id'                   => $query_Fields->list_id,
                            'Fields_Type_Components'      => $RC->Fields_Type,
                            'Fields_Type'                 => 'Select',
                            'Fields_Title'                => $query_Fields->item_translation,
                            'Fields_key'                  => $query_Fields->list_key,
                            'Fields_data'                 => $RC->Fields_data,
                            'List_Target'                 => $RC->List_Target,
                        );
                    }

                    $Build = false;
                } // if($Build == 1)





        } // end foreach

        $Fields_all = array_merge($List,$Fields);
        return $Fields_all;
    } // end function

}
##############################################################################



##############################################################################
if(!function_exists('Building_List_Forms')) {

    function Building_List_Forms($Forms_id,$Components_id,$list_id,$multiple = '',$selected='',$style='',$id='',$class='',$disabled='',$label='',$js='')
    {

        app()->load->database();

        $form_dropdown = '';
        $extra_options = array();
        $options_list = array();
        $options = [];
        $lang = get_current_lang();


        $query_get_setting_list = app()->db->where('Forms_id', $Forms_id);
        $query_get_setting_list = app()->db->where('Components_id', $Components_id);
        $query_get_setting_list = app()->db->where('Fields_id', $list_id);
        $query_get_setting_list = app()->db->get('portal_forms_components_fields')->row();

        //_array_p($query_get_setting_list);

        $query_list = app()->db->from('portal_list_data list');
        $query_list = app()->db->join('portal_list_data_translation  list_translation', 'list.list_id=list_translation.item_id');
        $query_list = app()->db->where('list.list_id', $list_id);
        $query_list = app()->db->where('list_translation.translation_lang', $lang);
        $query_list = app()->db->get()->row();



        ###########################################################################################################
        # List Type
        ###########################################################################################################
        if($query_get_setting_list->Fields_data == 'options'){

            $query_list_options = app()->db->from('portal_list_options_data list_options');
            $query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
            $query_list_options = app()->db->where('list_options.list_id', $query_get_setting_list->Fields_id);
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

        }elseif ($query_get_setting_list->Fields_data == 'options_table'){

            if($query_get_setting_list->join_table == NULL){

                $query_list_options = app()->db->get($query_get_setting_list->Table_primary);

                foreach ($query_list_options->result() as $row)
                {
                    $Table_primary_fields = $query_get_setting_list->primary_fields;
                    $Table_Join_fields    = $query_get_setting_list->Join_fields;

                    $options[] = array(
                        "options_id"    => $row->$Table_primary_fields,
                        "options_key"   => '',
                        "options_type"  => 'table',
                        "options_title" => $row->$Table_Join_fields,
                    );
                }

            }else {

                $query_list_options = app()->db->from($query_get_setting_list->Table_primary . ' Table_Primary');
                $query_list_options = app()->db->join($query_get_setting_list->Table_Join . '    Table_Join', 'Table_Primary.' . $query_get_setting_list->primary_joining_fields . ' = Table_Join.' . $query_get_setting_list->Join_joining_fields . '');
                $query_list_options = app()->db->get();

                foreach ($query_list_options->result() as $row) {

                    $Table_primary_fields = $query_get_setting_list->primary_fields;
                    $Table_Join_fields    = $query_get_setting_list->Join_fields;

                    $options[] = array(
                        "options_id"    => $row->$Table_primary_fields,
                        "options_key"   => '',
                        "options_type"  => 'table',
                        "options_title" => $row->$Table_Join_fields,
                    );

                }

            }

        }elseif ($query_get_setting_list->Fields_data == 'options_to_options_ajax'){


            $query_list_options = app()->db->from('portal_list_options_data list_options');
            $query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
            $query_list_options = app()->db->where('list_options.list_id', $query_get_setting_list->Fields_id);
            $query_list_options = app()->db->where('options_translation.translation_lang', $lang);
            $query_list_options = app()->db->order_by('list_options.options_sort', 'ASC');
            $query_list_options = app()->db->get();

            foreach ($query_list_options->result() as $row)
            {
                $options[] = array(
                    "options_id"    => $row->list_options_id,
                    "options_key"   => $row->options_key,
                    "options_type"  => 'options',
                    "options_title" => $row->item_translation
                );
            }

        }elseif ($query_get_setting_list->Fields_data == 'options_to_table_ajax'){

            $query_list_options = app()->db->from('portal_list_options_data list_options');
            $query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
            $query_list_options = app()->db->where('list_options.list_id', $query_get_setting_list->Fields_id);
            $query_list_options = app()->db->where('options_translation.translation_lang', $lang);
            $query_list_options = app()->db->order_by('list_options.options_sort', 'ASC');
            $query_list_options = app()->db->get();

            foreach ($query_list_options->result() as $row)
            {
                $options[] = array(
                    "options_id"    => $row->list_options_id,
                    "options_key"   => $row->options_key,
                    "options_type"  => 'options',
                    "options_title" => $row->item_translation
                );
            }



        }elseif ($query_get_setting_list->Fields_data == 'table_to_table_ajax'){

            $query_list_options = app()->db->get($query_get_setting_list->Table_primary);


            foreach ($query_list_options->result() as $row) {

                $Table_primary_fields = $query_get_setting_list->primary_fields;
                $Table_Join_fields    = $query_get_setting_list->Join_fields;

                $options[] = array(
                    "options_id"    => $row->$Table_primary_fields,
                    "options_key"   => '',
                    "options_type"  => 'table',
                    "options_title" => $row->$Table_Join_fields,
                );
            }

        }elseif ($query_get_setting_list->Fields_data == 'ajax'){



        }
        ###########################################################################################################
        # List Type
        ###########################################################################################################


        # Start Building Select

        $class_output = ' form-control ';
        if (is_array($class)) {
            foreach ($class as $c) {
                $class_output .= $class_output . ' ' . $c;
            }
        }

        if(empty($id)){
            $id_ = $query_list->list_key;
        }else{
            $id_ = $id;
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
            $label_ = '<label>'.$label.'</label>';
        }else{
            $label_ = '<label>'.$query_list->item_translation.' <span class="text-danger">*</span></label>';
        }

        if(!empty($multiple)){
            $multiple_ = 'multiple="multiple"';
        }else{
            $multiple_ = '';
        }

        if(!empty($js)){
            $js_ = 'onClick="'.$js.'"';
        }else{
            $js_ = '';
        }

        echo $label_;

        $form_dropdown .= '';


        $title_ = 'title="'.lang("Select_noneSelectedText").'"';

        if($query_get_setting_list->Fields_data == 'options_to_options_ajax' or $query_get_setting_list->Fields_data == 'options_to_table_ajax'
        or $query_get_setting_list->Fields_data == 'options_to_options_ajax' or $query_get_setting_list->Fields_data == 'table_to_table_ajax'){

            $query_list_target = app()->db->where('list_id',$query_get_setting_list->List_Target);
            $query_list_target = app()->db->get('portal_list_data')->row();
            $data_attr_id_list_target = 'data-List-Target-div="#'.$query_list_target->list_key.'"';

        }else{
            $data_attr_id_list_target = '';
        }

        $form_dropdown .= '<select name="'.$query_list->list_key.'" 
                            data-list-key-div = "#'.$query_list->list_key.'"
                            data-list-key-id  = "'.$query_list->list_id.'"
                            data-components-fields-id="'.$query_get_setting_list->Components_fields_id.'" 
                            data-form-id="'.$query_get_setting_list->Forms_id.'" 
                            data-components-id="'.$query_get_setting_list->Components_id.'" 
                            data-Fields-Type="'.$query_get_setting_list->Fields_data.'" 
                            data-Fields-id="'.$query_get_setting_list->Fields_id.'" 
                            data-List-Target-id="'.$query_get_setting_list->List_Target.'" 
                            '.$data_attr_id_list_target.'
                            onchange="ajax_list(this);" 
                            class="'.$class_output.'" id="'.$id_.'" '.$style_.' '.$disabled_.'  '.$title_.' '.$multiple_.' '.$js_.' data-live-search="true" data-size="5">';

            foreach ($options as $op)
            {
                $form_dropdown .= '<option value="'.$op['options_id'].'" data-key="'.$op['options_key'].'" data-type="'.$op['options_type'].'">'.$op['options_title'].'</option>';
            }

        $form_dropdown .= '</select>';

        echo $form_dropdown;

    } // end Building_List_Forms

}
##############################################################################


##############################################################################

if(!function_exists('Building_form_validation')) {

    function Building_form_validation($key,$text,$validating_rules)
    {
        $Building = app()->form_validation->set_rules($key,$text,$validating_rules);
        return $Building;
    }
}
##############################################################################



