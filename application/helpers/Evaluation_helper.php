<?php

##############################################################################
if(!function_exists('Get_Evaluation_Types'))
{

    function Get_Evaluation_Types($Evaluation_Types_id='')
    {
        app()->load->database();

        $lang   = get_current_lang();
        $query = app()->db->from('portal_evaluation_types evaluation_types');
        $query = app()->db->join('portal_evaluation_types_translation  evaluation_types_translation','evaluation_types.evaluation_types_id = evaluation_types_translation.item_id');

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
if(!function_exists('Get_Select_Evaluation_Types')) {

    function Get_Select_Evaluation_Types($type_list, $where_options='',$multiple = '', $plugins ='',$name_field,$js='')
    {
        app()->load->database();

        $lang   = get_current_lang();

        $html   = '';

        $query = app()->db->from('portal_evaluation_types evaluation_types');
        $query = app()->db->join('portal_evaluation_types_translation  evaluation_types_translation','evaluation_types.evaluation_types_id = evaluation_types_translation.item_id');
        $query = app()->db->where('evaluation_types_translation.translation_lang',$lang);


        if(!empty($where_options)){
            foreach ($where_options as $key => $value){
                $query = app()->db->where('evaluation_types.'.$key.'',$value);
            }
        }

        $query = app()->db->get();


        $plugins_ = '  ';
        if (is_array($plugins)) {
            foreach ($plugins as $c) {
                $plugins_ .= ' ' . $c;
            }
        }else{
            $plugins_ .= ' ' . $plugins_;
        }

        print_r($plugins);

        if($multiple   = 1){
            $multiple  = ' multiple data-actions-box="true"';

        }else{
            $multiple  = '';
        }

        if($name_field == ''){
            $name_form = 'evaluation_types';
        }else{
            $name_form = $name_field;
        }

        if(!empty($js)){
            $js_ = 'onclick="'.$js.'"';
        }else{
            $js_ = '';
        }


        if($type_list=='select')
        {
            $html .= '<select name="'.$name_form.'" id="evaluation_types" title="' . lang('Select_noneSelectedText') . '" class="' . $plugins_ . '" ' . $multiple . '
             '.$js_.' data-live-search="true">';

            foreach ($query->result() as $row) {
                $html .= '<option value="' . $row->evaluation_types_id . '">' . $row->item_translation . '</option>';
            }

            $html .= '</select>';
        }

        return $html;


    }

}
##############################################################################






##############################################################################
if(!function_exists('Get_Evaluation_Methods'))
{

    function Get_Evaluation_Methods($where_extra = '')
    {
        app()->load->database();

        $lang   = get_current_lang();


        $query = app()->db->from('portal_evaluation_methods              evaluation_methods');
        $query = app()->db->join('portal_evaluation_methods_translation  evaluation_methods_translation',' evaluation_methods_translation.item_id = evaluation_methods.evaluation_methods_id');

        if(isset($where_extra)){

            foreach ($where_extra as $key => $value){
                $query = app()->db->where('evaluation_methods.'.$key,$value);
            }

        }
        $query = app()->db->where('evaluation_methods_translation.translation_lang',$lang);


        $query = app()->db->get();

        // app()->db->last_query();

        return $query;
    }

}
##############################################################################


##############################################################################
if(!function_exists('Get_Select_evaluation_methods')) {

    function Get_Select_evaluation_methods($type_list, $where_options='',$multiple = '', $plugins ='',$name_field)
    {
        app()->load->database();

        $lang   = get_current_lang();

        $html   = '';

        $query = app()->db->from('portal_evaluation_methods evaluation_methods');
        $query = app()->db->join('portal_evaluation_methods_translation  evaluation_methods_translation','evaluation_methods.evaluation_methods_id = evaluation_methods_translation.item_id');
        $query = app()->db->where('evaluation_methods_translation.translation_lang',$lang);


        if(!empty($where_options)){
            foreach ($where_options as $key => $value){
                $query = app()->db->where('evaluation_methods.'.$key.'',$value);
            }
        }

        $query = app()->db->get();


        $plugins_ = '  ';
        if (is_array($plugins)) {
            foreach ($plugins as $c) {
                $plugins_ .= ' ' . $c;
            }
        }else{
            $plugins_ .= ' ' . $plugins_;
        }

        if($multiple   = 1)
        {
            $multiple  = ' multiple data-actions-box="true"';

            if($name_field == '')
            {
                $name_form = 'evaluation_methods[]';
            }else{
                $name_form = ''.$name_field.'[]';
            }

        }else{

            $multiple  = '';
            $name_form = $name_field;

        }




        if($type_list=='select')
        {
            $html .= '<select name="'.$name_form.'" id="evaluation_methods" title="' . lang('Select_noneSelectedText') . '" class="form-control ' . $plugins_ . '" ' . $multiple . ' data-live-search="true">';

            foreach ($query->result() as $row) {
                $html .= '<option value="' . $row->evaluation_methods_id . '">' . $row->item_translation . '</option>';
            }

            $html .= '</select>';
        }

        return $html;


    }

}
##############################################################################

?>