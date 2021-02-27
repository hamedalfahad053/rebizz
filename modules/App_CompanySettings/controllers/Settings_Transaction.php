<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_Transaction extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' اعداد المعاملات ';


        //require_once '';
    }
    ###################################################################


    ###################################################################
    public function index()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Settings'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title']  = '   ';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/company_information', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################









}