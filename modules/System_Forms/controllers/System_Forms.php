<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Forms extends Admin
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('System_Forms_Model');

        $this->data['controller_name'] = lang('List_user');
    }


    ###################################################################
    public function index()
    {

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Users/views/List_Users',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Form_add_User()
    {

        $this->data['Page_Title'] = lang('add_new_user_button');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Users/views/Form_add_User',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################

}