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

###############################################################################
if (!function_exists('array_options_status_system')) {
    function array_options_status_system() {

        $options_status = '';
        $options_status = array(
            "1" => lang('Basic_System'),
            "0" => lang('Multiple_System')
        );

        return $options_status;
    }
}
###############################################################################

###############################################################################
if (!function_exists('array_options_status')) {
    function array_options_status() {

        $options_status = '';
        $options_status = array(
            "1" => lang('Status_Active'),
            "0" => lang('Status_Disabled')
        );

        return $options_status;
    }
}
###############################################################################


###############################################################################
if (!function_exists('array_options_status_user')) {
    function array_options_status_user() {

        $options_status = '';
        $options_status = array(
            "0" => lang('Status_Active'),
            "1" => lang('Status_Disabled')
        );
        return $options_status;
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

##############################################################################
if(!function_exists('currency_format')) {
    function currency_format($number = '') {
        $thausand_separator = get_option('ecommerce_thausand_separator', '.');
        $decimal_separator = get_option('ecommerce_decimal_separator', ',');
        $decimal_length = get_option('ecommerce_decimal_length', 0);
        $text = 'IDR '.number_format($number, $decimal_length, $decimal_separator,$thausand_separator);

        return $text;
    }
}
##############################################################################

##############################################################################
if(!function_exists('gen_random_string')) {
    function gen_random_string($length = 16)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//length:36
        $final_rand = '';
        for ($i = 0; $i < $length; $i++) {
            $final_rand .= $chars[rand(0, strlen($chars) - 1)];

        }
        return $final_rand;
    }
}
##############################################################################


##############################################################################
if(!function_exists('encryption_data')) {

    function encryption_data($plain_text,$type) {

        app()->load->library('encryption');

        if($type == 'in'){

            $out_plain_text = app()->encryption->encrypt($plain_text);

        }elseif($type == 'out'){

            $out_plain_text = app()->encryption->decrypt($plain_text);

        }

        return $out_plain_text;
    }
}
##############################################################################
if(!function_exists('intPart')) {

    function intPart($float)
    {
        if ($float < -0.0000001)
            return ceil($float - 0.0000001);
        else
            return floor($float + 0.0000001);
    }

}
##############################################################################
if(!function_exists('Hijri2Greg')) {

    function Hijri2Greg($day, $month, $year, $string = false)
    {
        $day = (int)$day;
        $month = (int)$month;
        $year = (int)$year;

        $jd = intPart((11 * $year + 3) / 30) + 354 * $year + 30 * $month - intPart(($month - 1) / 2) + $day + 1948440 - 385;

        if ($jd > 2299160) {
            $l = $jd + 68569;
            $n = intPart((4 * $l) / 146097);
            $l = $l - intPart((146097 * $n + 3) / 4);
            $i = intPart((4000 * ($l + 1)) / 1461001);
            $l = $l - intPart((1461 * $i) / 4) + 31;
            $j = intPart((80 * $l) / 2447);
            $day = $l - intPart((2447 * $j) / 80);
            $l = intPart($j / 11);
            $month = $j + 2 - 12 * $l;
            $year = 100 * ($n - 49) + $i + $l;
        } else {
            $j = $jd + 1402;
            $k = intPart(($j - 1) / 1461);
            $l = $j - 1461 * $k;
            $n = intPart(($l - 1) / 365) - intPart($l / 1461);
            $i = $l - 365 * $n + 30;
            $j = intPart((80 * $i) / 2447);
            $day = $i - intPart((2447 * $j) / 80);
            $i = intPart($j / 11);
            $month = $j + 2 - 12 * $i;
            $year = 4 * $k + $n + $i - 4716;
        }

        $data = array();
        $date['year'] = $year;
        $date['month'] = $month;
        $date['day'] = $day;

        if (!$string)
            return $date;
        else
            return "{$year}-{$month}-{$day}";
    }
}
##############################################################################

##############################################################################
if(!function_exists('IsHijri')) {

    function IsHijri($date,$com='')
    {
        if(empty($com)){
            $com = '-';
        }

        $ep = explode($com,$date);

        if($ep[0] < 1900 ){
            return true;
        }elseif($ep[0] > 1900 ){
            return false;
        }
    }

}
##############################################################################