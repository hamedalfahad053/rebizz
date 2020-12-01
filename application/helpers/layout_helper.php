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
if (!function_exists('Layout_Admin_Parse')) {
    function Layout_Admin_Parse($data) {
        $Layout_Admin = app()->parser->parse($data);
        return $Layout_Admin;
    }
}
###############################################################################


###############################################################################
if (!function_exists('import_css')) {
    function import_css($path) {
        $builder_code = '';
        if(is_array($path)) {
            foreach ($path as $key => $value) {
                $builder_code .= '<link href='.$path.'" rel="stylesheet" type="text/css" />';
            }
        }else{
            $builder_code = '<link href="' . $path. '" rel="stylesheet" type="text/css" />';
        }
        return $builder_code;
    }
}
###############################################################################

###############################################################################
if (!function_exists('import_js')) {
    function import_js($path) {
        $builder_code = '';
        if(is_array($path)) {
            foreach ($js AS $key => $value){
                $builder_code .='<script src="'.$path.'"  type="text/javascript"></script>';
            }
        }else{
            $builder_code ='<script src="'.$path.'"  type="text/javascript"></script>';
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
        $assets[] = 'plugins/global/plugins.bundle.css';
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

