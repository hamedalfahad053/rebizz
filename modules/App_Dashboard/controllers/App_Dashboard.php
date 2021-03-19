<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Dashboard extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'لوحة المعلومات';
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $this->data['Page_Title']  = 'لوحة المعلومات';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));

        $this->data['breadcrumbs']   = $this->mybreadcrumb->render();
        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent'] = $this->load->view('../../modules/App_Dashboard/views/Dashboard', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ##################################################################################
    public function logout()
    {
        $this->aauth->logout();
        redirect('Auth', 'refresh');
    }
    ##################################################################################




}