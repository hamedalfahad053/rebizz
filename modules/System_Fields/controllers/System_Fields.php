<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Fields extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Fields_model');

        $this->data['controller_name'] = lang('Management_Fields');
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $this->data['Page_Title']  = lang('Management_Fields');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Fields/views/List_Fields',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_add_Fields()
    {

        $this->data['Page_Title'] = lang('Add_New_Fields_button');

        $get_all_Fields_Type  = $this->Fields_model->Get_Fields_Type();

        $this->data['options_Type_Tag_Fields'] = array(
            "input"    => "حقل",
            "select"   => "قائمة اختيارات",
            "checkbox" => "اختيار متعدد",
            "radio"    => "اختر خيار واحد فقط",
            "textarea" => "حقل نصي كبير"
        );

        $this->data['options_Type_Fields'] = '';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Fields'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Fields/views/Form_add_Fields',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function options_Type_Fields()
    {
           $Type_Tag_Fields = $this->input->get('Type_Fields');
           $options_Type_Fields = '';

            if($Type_Tag_Fields == 'input'){

                $options_Type_Fields = array(
                    "text"     => "حقل نصي",
                    "date"     => "تاريخ",
                    "email"    => "بريد الكتروني",
                    "file"     => "تحميل ملف",
                    "number"   => "ارقام",
                    "time"     => "وقت",
                    "url"      => "رابط",
                    "tel"      => "رقم هاتف",
                );

            }elseif($Type_Tag_Fields == 'select' or $Type_Tag_Fields == 'checkbox' or $Type_Tag_Fields == 'radio' ){

                $options_Type_Fields = array(
                    "table_db"     => "قائمة معرفة",
                    "Create_list"  => "قائمة جديدة",
                );

            }elseif($Type_Tag_Fields == 'textarea'){


            }


            $msg['success'] = true;
            $msg['data'] = $options_Type_Fields;
            echo json_encode($msg);

    }
    ###################################################################

    /*
    validating_Fields_matches_Fields();
    validating_regex_match()
    validating_Fields_is_unique()
    validating_Fields_min_length()
    validating_Fields_max_length()
    validating_Fields_exact_length()
    validating_Fields_greater_than()
    validating_Fields_greater_than_equal_to()
    validating_Fields_less_than()
    validating_Fields_less_than_equal_to()
    validating_Fields_numeric()
    validating_Fields_integer()
    validating_Fields_decimal()
    validating_Fields_is_natural()
    validating_Fields_is_natural_no_zero()
    validating_Fields_valid_url() ?>
    validating_Fields_valid_email()
    */

    ###################################################################
    public function validating_Fields_Template()
    {
        $Type_Fields = $this->input->get('options_Type_Fields');

        $Type_Fields_html_view = '';

        $Type_Fields_html_view .= validating_Fields_required();

        if($Type_Fields == 'text') {

            $Type_Fields_html_view .= validating_Fields_min_length();
            $Type_Fields_html_view .= validating_Fields_max_length();
            $Type_Fields_html_view .= validating_Fields_matches_Fields();

        } elseif ($Type_Fields == 'date') {


        } elseif ($Type_Fields == 'email') {

            $Type_Fields_html_view .= validating_Fields_valid_email();

        } elseif ($Type_Fields == 'url') {

            $Type_Fields_html_view .= validating_Fields_valid_url() ;

        } elseif ($Type_Fields=='number') {

            $Type_Fields_html_view .= validating_Fields_numeric();
            $Type_Fields_html_view .= validating_Fields_integer();
            $Type_Fields_html_view .= validating_Fields_decimal();
            $Type_Fields_html_view .= validating_Fields_is_natural();
            $Type_Fields_html_view .= validating_Fields_is_natural_no_zero();

        } elseif ($Type_Fields=='select' or $Type_Fields=='checkbox' or $Type_Fields=='radio'){

        } elseif ($Type_Fields=='textarea') {

        }

        echo $Type_Fields_html_view;
    }
    ###################################################################










}