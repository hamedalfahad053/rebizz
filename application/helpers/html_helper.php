<?php

#####################################################################################
if(!function_exists('Create_Options_Button')) {
    function Create_Options_Button($options)
    {
        $HTML  = '';

        foreach ($options AS $kay => $value) {
            if ($kay == 'view') {
                $HTML .= '<a class="btn btn-icon btn-light-primary mx-2" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="flaticon-arrows"></i></a>';
            } elseif ($kay == 'edit') {
                $HTML .= '<a class="btn btn-icon btn-light-warning mx-2" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="la la-edit"></i></a>';
            } elseif ($kay == 'active') {
                $HTML .= '<a class="btn btn-icon btn-light-success mx-2" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="la la-eye"></i></a>';
            } elseif ($kay == 'disable') {
                $HTML .= '<a  class="btn btn-icon btn-light-dark mx-2" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="la la-eye-slash"></i></a>';
            } elseif ($kay == 'deleted') {
                $HTML .= '<a  class="btn btn-icon btn-light-danger mx-2" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="la la-times"></i></a>';
            }elseif ($kay == 'custom') {
                $HTML .= '<a class="btn btn-icon btn-light-' . $value['color'] . ' mx-2" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="' . $value['icon'] . '"></i></a>';
            }

        }
        return $HTML;
    }
}
#####################################################################################

#####################################################################################
if(!function_exists('Create_One_Button_Text')) {
    function Create_One_Button_Text($Button)
    {
        $HTML           = '';
        $data_attribute = '';
        $color          = 'primary';

        if(isset($Button['color'])) {
            $color = $Button['color'];
        }

        if(isset($Button['data_attribute'])) {
            $data_attribute = $Button['data_attribute'];
        }

        $HTML .= '<a class="btn btn-' . $color . ' mx-2" data-toggle="tooltip" title="' . $Button['title'] . '" ' . $data_attribute . ' href="' . $Button['href'] . '">' . $Button['title']  . '</a>';
        return $HTML;
    }
}
#####################################################################################


#####################################################################################
if(!function_exists('Create_One_Button_Icon')) {
    function Create_One_Button_Icon($Button)
    {
        $HTML  = '';
        $HTML .= '<a class="btn btn-icon btn-' . $Button['color'] . ' mx-2" data-toggle="tooltip" title="' . $Button['title'] . '" ' . $Button['data-attribute'] . ' href="' . $Button['href'] . '"><i class="' . $Button['icon'] . '"></i></a>';
        return $HTML;
    }
}
#####################################################################################

#####################################################################################
if(!function_exists('Create_One_Button_TextIcon')) {
    function Create_One_Button_TextIcon($Button)
    {
        $HTML  = '';
        $HTML .= '<a class="btn btn-icon btn-' . $Button['color'] . ' mx-2" data-toggle="tooltip" title="' . $Button['title'] . '" ' . $Button['data-attribute'] . ' href="' . $Button['href'] . '"><i class="' . $Button['icon'] . '"></i> '.$Button['title'].' </a>';
        return $HTML;
    }
}
#####################################################################################


#####################################################################################
if(!function_exists('Create_Status_badge')) {
    function Create_Status_badge($options)
    {
        $HTML = '';

        if ($options['key'] == 'Success') {
            $HTML = '<span class="label label-xl label-success label-pill label-inline mr-2">'.$options['value'].'</span>';
        }elseif ($options['key'] == 'warning') {
            $HTML = '<span class="label label-xl label-warning label-pill label-inline mr-2">'.$options['value'].'</span>';
        }elseif ($options['key'] == 'Danger') {
            $HTML = '<span class="label label-xl label-danger label-pill label-inline mr-2">'.$options['value'].'</span>';
        }elseif ($options['key'] == 'Info') {
            $HTML = '<span class="label label-xl label-info label-pill label-inline mr-2">'.$options['value'].'</span>';
        }elseif ($options['key'] == 'Primary') {
            $HTML = '<span class="label label-xl label-primary label-pill label-inline mr-2">'.$options['value'].'</span>';
        }

        return $HTML;
    }

}
#####################################################################################

#####################################################################################
if(!function_exists('Create_Status_Alert')) {
    function Create_Status_Alert($options)
    {
        $HTML = '';
        if ($options['key'] == 'Success') {
            $HTML = '<div class="alert alert-success" role="alert">'.$options['value'].'</div>';
        }elseif ($options['key'] == 'Warning') {
            $HTML = '<div class="alert alert-warning" role="alert">'.$options['value'].'</div>';
        }elseif ($options['key'] == 'Danger') {
            $HTML = '<div class="alert alert-danger" role="alert">'.$options['value'].'</div>';
        }elseif ($options['key'] == 'Info') {
            $HTML = '<div class="alert alert-info" role="alert">'.$options['value'].'</div>';
        }elseif ($options['key'] == 'Primary') {
            $HTML = '<div class="alert alert-primary" role="alert">'.$options['value'].'</div>';
        }

        return $HTML;
    }
}
#####################################################################################

#####################################################################################
if(!function_exists('set_message')) {
    function set_message($message) {
      return  app()->session->set_flashdata('message', $message);
    }
}
#####################################################################################


#####################################################################################
if(!function_exists('get_icon_file')) {
    function get_icon_file($file_name = '') {
        $extension_list = [
            'avi' => ['avi'],
            'css' => ['css'],
            'csv' => ['csv'],
            'eps' => ['eps'],
            'html' => ['html', 'htm'],
            'jpg' => ['jpg', 'jpeg'],
            'mov' => ['mov', 'mp4', '3gp'],
            'mp3' => ['mp3'],
            'pdf' => ['pdf'],
            'png' => ['png'],
            'ppt' => ['ppt', 'pptx'],
            'rar' => ['rar'],
            'raw' => ['raw'],
            'ttf' => ['ttf'],
            'txt' => ['txt'],
            'wav' => ['wav'],
            'xls' => ['xls', 'xlsx'],
            'zip' => ['zip'],
            'doc' => ['docx', 'doc']
        ];

        $file_name_arr = explode('.', $file_name);
        if (is_array($file_name_arr)) {
            foreach ($extension_list as $ext => $list_ext) {
                if (in_array(end($file_name_arr), $list_ext)) {
                    return BASE_ASSET . 'img/icon/' . $ext . '.png';
                }
            }
        }

        return BASE_ASSET. 'media/icon/any.png';
    }
}
#####################################################################################