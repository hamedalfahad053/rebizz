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


if (!function_exists('get_current_lang'))
{
    function get_current_lang()
    {
        $ci =& get_instance();
        return get_cookie('language') ? get_cookie('language') : $ci->config->item('language');
    }
}