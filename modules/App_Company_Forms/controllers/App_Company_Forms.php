<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_Forms extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();

        $this->data['controller_name'] = 'ادارة النماذج';
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $this->data['Page_Title']  = 'ادارة النماذج';


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent']   = $this->load->view('../../modules/App_Company_Forms/views/List_Forms', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################


    ###################################################################
    public function Add_New_Forms()
    {

        $this->data['Page_Title']  = ' اضافة نموذج جديد ';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Forms/views/Add_New_Forms', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################




}