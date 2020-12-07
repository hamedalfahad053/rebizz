<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Fields extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();


        $this->data['controller_name'] = lang('Dashboard');
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $this->data['Page_Title']  = lang('Dashboard');
        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_add_Fields()
    {

        $this->data['Page_Title'] = lang('add_new_user_button');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Fields/views/Form_add_Fields',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################

}