<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Fields extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();


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
        $this->data['PageContent'] = $this->load->view('../../modules/System_Fields/views//List_Fields',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################


    ###################################################################
    public function List_Fields_Type()
    {

        $this->data['Page_Title']  = lang('Management_Type_Fields');


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Fields/views//List_Fields_Type',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################





    ###################################################################
    public function Form_add_Fields()
    {

        $this->data['Page_Title'] = lang('Add_New_Fields_button');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Fields'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Fields/views/Form_add_Fields',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################




}