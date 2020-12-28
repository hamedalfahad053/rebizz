<?php

###############################################################################
/*
 *  get_instance
 */
if(!function_exists('app')) {
    function app() {
        return get_instance();
    }
}
###############################################################################



###############################################################################
if (!function_exists('get_setting')) {
    function get_setting($key = "") {
        return app()->config->item($key);
    }
}
###############################################################################


##############################################################################
if(!function_exists('Get_Controllers'))
{
    function Get_Controllers($area_id)
    {
        app()->load->database();

        $lang = get_current_lang();

        $query = app()->db->from('portal_system_controllers              controllers');
        $query = app()->db->join('portal_system_controllers_translation  controllers_translation','controllers.controllers_id = controllers_translation.item_id');

        $query = app()->db->where('controllers_area',$area_id);
        $query = app()->db->where('controllers_translation.translation_lang',$lang);

        $query = app()->db->get();
        return $query;
    }

}
##############################################################################

###########################################################################
if(!function_exists('Get_functions_Controller'))
{
    function Get_functions_Controller($Controller_id) {

        app()->load->database();

        $lang = get_current_lang();

        $query = app()->db->from('portal_system_functions   functions');
        $query = app()->db->join('portal_system_functions_translation  functions_translation','functions.function_id = functions_translation.item_id');

        $query = app()->db->where("function_Controllers_id",$Controller_id);
        $query = app()->db->where('functions_translation.translation_lang',$lang);

        $query = app()->db->get();

        return $query;
    }
}
###########################################################################



/*   End Tools input and output     */

###############################################################################
if(!function_exists('_array_p')) {
    function _array_p($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
}
###############################################################################

##############################################################################
/*
 *  only number value
 */
if(!function_exists('isset_number_value')) {

    function isset_number_value($value){
        $expr = '/^[1-9][0-9]*$/';
        // $expr = '/^[1-9][0-9\.]{0,15}$/'; // is float numbers
        if (preg_match($expr, $value) and  filter_var($value, FILTER_VALIDATE_INT) and is_numeric($value) and intval($value)) {
            return true;
        } else {
            return false;
        }
    }
}
##############################################################################

##############################################################################
/*
 * only string value
 */
if(!function_exists('isset_string_value')) {
    function isset_string_value($value)
    {
        if (preg_match('/^[A-Z][a-z]$/i',$value)) {
            return true;
        } else {
            return false;
        }
    }
}
##############################################################################

##############################################################################
if(!function_exists('CSFT_Form')) {

    function CSFT_Form(){

        $data = '';

        $csrf = array(
            'name' => app()->security->get_csrf_token_name(),
            'hash' => app()->security->get_csrf_hash()
        );
        $data = '<input type="hidden" name="'.$csrf['name'].'" value="'.$csrf['hash'].'" />';
        return $data;
    }
}
##############################################################################


##############################################################################
if(!function_exists('General_filtering_protection')) {

    function General_filtering_protection($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = html_escape($data);
        $data = app()->security->xss_clean($data);
        return $data;
    }
}
##############################################################################
/*   End Tools input and output     */



##############################################################################
if (!function_exists('get_real_ip')) {

    function get_real_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}
##############################################################################