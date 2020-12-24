<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Maps extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();


        $this->data['controller_name'] = lang('Management_companies_offices');
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $this->data['Page_Title']  = lang('Management_companies_offices');


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Company/views/List_company',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################




}