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
            "input"    => "input",
            "select"   => "select",
            "textarea" => "textarea"
        );

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Fields'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Fields/views/Form_add_Fields',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Type_Fields()
    {
        $tag = '';


        if($tag == 'input' ){

            $this->data['options_Type_Fields'] = array(
                "text"     => "text",
                "checkbox" => "checkbox",
                "color"    => "color",
                "date"     => "date",
                "email"    => "email",
                "file"     => "file",
                "hidden"   => "hidden",
                "number"   => "number",
                "password" => "password",
                "radio"    => "radio",
                "range"    => "range",
                "time"     => "time",
                "url"      => "url",
                "tel"      => "tel",
            );

        }elseif($tag == 'textarea' ){

        }elseif($tag == 'select'){

        }else{

        }



    }
    ###################################################################

    ###################################################################
    public function validating_Fields_Template()
    {
        $Type_Fields = '';
    }
    ###################################################################










}