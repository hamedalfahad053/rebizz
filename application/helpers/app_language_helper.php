<?php

##############################################################################
if (!function_exists('get_current_lang'))
{
    function get_current_lang()
    {
        return get_cookie('language') ? get_cookie('language') : app()->config->item('language');
    }
}
##############################################################################

##############################################################################
if (!function_exists('dropdown_menu_Language'))
{
    function dropdown_menu_Language()
    {
        $html = '';

        app()->load->database();

        $query_list_language = app()->db->where('languages_status',1);
        $query_list_language = app()->db->get('protal_list_language');

        foreach ($query_list_language->result()  AS $RL)
        {
            $html .= '<li class="navi-item">';
                $html .= '<a href="#" class="navi-link">';
                    $html .= '<span class="symbol symbol-20 mr-3">';
                        $html .= '<img src="'.BASE_ASSET.'media/svg/flags/'.$RL->language_icon.''.'" alt="" />';
                    $html .= '</span>';
                    $html .= '<span class="navi-text">'.$RL->language_native.'</span>';
                $html .= '</a>';
            $html .= '<li class="navi-item">';
        }

        return $html;

    }
}
##############################################################################

##############################################################################
if (!function_exists('flag_Language')) {
    function flag_Language()
    {
        $lang = app()->input->cookie('language');

        app()->load->database();


        $query_list_language = app()->db->like('language_name',$lang);
        $query_list_language = app()->db->get('protal_list_language')->row();

        $html = '<img class="h-20px w-20px rounded-sm" src="'.BASE_ASSET.'media/svg/flags/'.$query_list_language->language_icon.'" alt="" />';

        return $html;
    }
}
##############################################################################

##############################################################################
if(!function_exists('insert_translation_Language_item')) {

    function insert_translation_Language_item($table,$item_id,$item_ar,$item_en)
    {
        $data = array();
        app()->load->database();

        // insert all lang without arabic

        $query_list_language = app()->db->where_not_in('language_name','arabic');
        $query_list_language = app()->db->get('protal_list_language');

        foreach ($query_list_language->result()  AS $RL)
        {
            $data = array(
                "item_id"          => $item_id,
                "item_translation" => $item_en,
                "translation_lang" => $RL->language_name,
            );
            app()->db->insert($table,$data);
        } // foreach ($query_list_language AS $RL)



        // insert arabic
        $data_ar  = array(
            "item_id" => $item_id,
            "item_translation" => $item_ar,
            "translation_lang" => 'arabic',
        );
        app()->db->insert($table,$data_ar);


    } // function insert_translation_Language_item($table,$item_id,$item_ar,$item_en)

}
##############################################################################
