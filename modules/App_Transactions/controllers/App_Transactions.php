<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Transactions extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'ادارة المعاملات';
    }
    ###################################################################


    ###################################################################
    public function index()
    {
        $this->data['Page_Title']      = 'استعراض الطلبات ';

        $where_Transactions = array(
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->location_id,
            "Create_Transaction_By_id" => $this->aauth->get_user()->id,
        );
        $Get_All_Transactions          = Get_All_Transactions($where_Transactions);

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/List_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_Transaction()
    {
        $this->data['Page_Title']     = 'استلام طلب جديد';

        Create_Logs_User('Create_Transaction','','Transaction','Create');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Create_Transaction', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################


    ###################################################################
    public function Create_Transaction_Submit()
    {

        _array_p($_POST);
    }
    ###################################################################






}