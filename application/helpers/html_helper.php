<?php

#####################################################################################
if(!function_exists('Create_Options_Button')) {
    function Create_Options_Button($options)
    {
        $HTML  = '';

        foreach ($options AS $kay => $value) {

            if ($kay == 'view') {
                $HTML .= '<a class="btn btn-icon btn-sm btn-light-primary mx-2 ' . $value['class'] . ' ' . $value['id'] . '" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="flaticon-eye"></i></a>';
            } elseif ($kay == 'edit') {
                $HTML .= '<a class="btn btn-icon btn-sm btn-light-warning mx-2 ' . $value['class'] . ' ' . $value['id'] . '" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="la la-edit"></i></a>';
            } elseif ($kay == 'active') {
                $HTML .= '<a class="btn btn-icon btn-sm btn-light-success mx-2 ' . $value['class'] . ' ' . $value['id'] . '" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="la la-eye"></i></a>';
            } elseif ($kay == 'disable') {
                $HTML .= '<a  class="btn btn-icon btn-sm btn-light-dark mx-2 ' . $value['class'] . ' ' . $value['id'] . '" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="la la-eye-slash"></i></a>';
            } elseif ($kay == 'deleted') {
                $HTML .= '<a  class="btn btn-icon btn-sm btn-light-danger mx-2 ' . $value['class'] . ' ' . $value['id'] . '" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="la la-times"></i></a>';
            } elseif ($kay == 'print') {
                $HTML .= '<a  class="btn btn-icon btn-sm btn-light-danger mx-2 ' . $value['class'] . ' ' . $value['id'] . '" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="flaticon2-printer"></i></a>';
            } elseif ($kay == 'search') {
                $HTML .= '<a  class="btn btn-icon btn-sm btn-light-danger mx-2 ' . $value['class'] . ' ' . $value['id'] . '" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="flaticon2-magnifier-too"></i></a>';
            } elseif ($kay == 'loges') {
                $HTML .= '<a  class="btn btn-icon btn-sm btn-light-danger mx-2 ' . $value['class'] . ' ' . $value['id'] . '" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="flaticon2-heart-rate-monitor"></i></a>';
            } elseif ($kay == 'Assignment') {
                $HTML .= '<a  class="btn btn-icon btn-sm btn-light-danger mx-2 ' . $value['class'] . ' ' . $value['id'] . '" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="flaticon2-user-1"></i></a>';
            } elseif ($kay == 'back') {
                $HTML .= '<a  class="btn btn-icon btn-sm btn-light-danger mx-2 ' . $value['class'] . ' ' . $value['id'] . '" data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="flaticon2-back"></i></a>';



            }elseif ($kay == 'custom') {
                $HTML .= '<a class="btn btn-icon btn-sm btn-light-' . $value['color'] . ' ' . $value['class'] . ' ' . $value['id'] . ' mx-2 " data-toggle="tooltip" title="' . $value['title'] . '" ' . $value['data-attribute'] . ' href="' . $value['href'] . '"><i class="' . $value['icon'] . '"></i></a>';
            }
        }
        return $HTML;
    }
}
#####################################################################################


#####################################################################################
if(!function_exists('Create_Options_Dropdown')) {
    function Create_Options_Dropdown($title_Dropdown,$icon_Dropdown,$options)
    {
        $HTML  = '';

        $HTML  = '
           <div class="btn-group">
            <button class="btn btn-primary font-weight-bold btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              '.$icon_Dropdown.'  '.$title_Dropdown.'
            </button>
           <div class="dropdown-menu dropdown-menu-md">
        ';

        foreach ($options AS $kay => $value)
        {
            $HTML .= '<a class="dropdown-item' . $value['class'] . '" ' . $value['id'] . '  ' . $value['data-attribute'] . ' href="' . $value['href'] . '">'.$value['icon'].' ' . $value['title'] . '</a>';
        }

        $HTML .= '</div></div>';

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
        $data_class     = '';
        $data_id        = '';

        $color          = 'primary';

        if(isset($Button['color'])) {
            $color = $Button['color'];
        }

        if(isset($Button['data_attribute'])) {
            $data_attribute = $Button['data_attribute'];
        }

        if(isset($Button['id'])) {
            $data_id = $Button['id'];
        }
        if(isset($Button['class'])) {
            $data_class = $Button['class'];
        }

        $HTML .= '<a class="btn btn-' . $color . ' mx-2 '.$data_class.'" '.$data_id.' data-toggle="tooltip" title="' . $Button['title'] . '" ' . $data_attribute . ' href="' . $Button['href'] . '">' . $Button['title']  . '</a>';
        return $HTML;
    }
}
#####################################################################################

#####################################################################################
if(!function_exists('Create_One_Button_Text_Without_tooltip')) {
    function Create_One_Button_Text_Without_tooltip($Button)
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

        $HTML .= '<a class="btn btn-' . $color . ' '.$Button['class'].' mx-2" title="' . $Button['title'] . '" ' . $Button['id'] . ' ' . $data_attribute . ' href="' . $Button['href'] . '">' . $Button['title']  . '</a>';
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