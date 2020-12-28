<?php

###############################################################################
if(!function_exists('direction_Layout')) {

    function direction_Layout()
    {

    }

}
###############################################################################

###############################################################################
if (!function_exists('Layout_Admin')) {
    function Layout_Admin($data) {
        $Layout_Admin = app()->load->view('../../modules/Layout/Layout_Admin', $data);
        return $Layout_Admin;
    }
}
###############################################################################

###############################################################################
if (!function_exists('Layout_Auth')) {
    function Layout_Auth($data) {
        $Layout_Auth= app()->load->view('../../modules/Auth/views/Layout_Auth', $data);
        return $Layout_Auth;
    }
}
###############################################################################

###############################################################################
if (!function_exists('Layout_Apps')) {
    function Layout_Apps($data) {
        $Layout_Company = app()->load->view('../../modules/Layout/Layout_Company', $data);
        return $Layout_Company;
    }
}
###############################################################################

###############################################################################
if (!function_exists('import_css')) {
    function import_css($path,$direction_Layout) {


        $builder_code = '';

        if($direction_Layout=='rtl'){
            $rtl = '.rtl.css';
        }else{
            $rtl ='.css';
        }

        if(is_array($path)) {
            foreach ($path as $key => $value) {
                $builder_code .= '<link href='.$value.$rtl.'" rel="stylesheet" type="text/css" />';
            }
        }else{
            $builder_code = '<link href="' . $path.$rtl. '" rel="stylesheet" type="text/css" />';
        }
        return $builder_code;
    }
}
###############################################################################

###############################################################################
if (!function_exists('import_js')) {
    function import_js($path,$direction_Layout) {

        $builder_code = '';

        if($direction_Layout=='rtl'){
            $rtl = '.rtl.js';
        }else{
            $rtl ='.js';
        }

        if(is_array($path)) {
            foreach ($path AS $key => $value){
                $builder_code .='<script src="'.$value.$rtl.'"  type="text/javascript"></script>';
            }
        }else{
            $builder_code ='<script src="'.$path.$rtl.'"  type="text/javascript"></script>';
        }
        return $builder_code;
    }
}
###############################################################################

###############################################################################
if(!function_exists('assets_layout_css')) {

    function assets_layout_css($direction_Layout='')
    {
        $builder_code = '';

        if($direction_Layout=='rtl'){
            $rtl = '.rtl';
        }else{
            $rtl ='';
        }

        $assets = array();
        $assets[] = 'plugins/global/plugins.bundle'.$rtl.'.css';
        $assets[] = 'plugins/custom/prismjs/prismjs.bundle.css';
        $assets[] = 'css/style.bundle'.$rtl.'.css';
        $assets[] = 'css/themes/layout/header/base/light'.$rtl.'.css';
        $assets[] = 'css/themes/layout/header/menu/light'.$rtl.'.css';
        $assets[] = 'css/themes/layout/brand/light'.$rtl.'.css';
        $assets[] = 'css/themes/layout/aside/light'.$rtl.'.css';

        if($direction_Layout=='rtl'){
            $assets[] = 'fonts/font_arabic.css';
        }

        foreach ($assets AS $key => $value){
            $builder_code .='<link href="'.BASE_ASSET.$value.'"  rel="stylesheet" />';
        }
        return $builder_code;
    }

}
###############################################################################

###############################################################################
if (!function_exists('assets_layout_js')) {
    function assets_layout_js($direction_Layout='')
    {
        $builder_code = '';

        if($direction_Layout=='rtl'){
            $rtl = '.rtl';
        }else{
            $rtl ='';
        }

        $assets = array();

        $assets[] = 'plugins/global/plugins.bundle.js';
        $assets[] = 'plugins/custom/prismjs/prismjs.bundle.js';
        $assets[] = 'js/scripts.bundle.js';

        foreach ($assets AS $key => $value){
            $builder_code .='<script src="'.BASE_ASSET.$value.'"  type="text/javascript"></script>';
        }
        return $builder_code;
    }
}
###############################################################################

