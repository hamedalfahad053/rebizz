<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Preview_RealEstate  extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'الزيارات';
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $this->data['Page_Title']  = 'استعراض الزيارات الجديدة';

        $this->mybreadcrumb->add(lang('Dashboard'), '');
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_RealEstate_Preview/views/Preview_List', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################


    ###################################################################
    public function Preview_View_Request()
    {

        $this->data['Page_Title']  = 'عرض الزيارة';

        $this->mybreadcrumb->add(lang('Dashboard'), '');
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css']  = import_css("https://unpkg.com/leaflet@1.7.1/dist/leaflet","");
        $this->data['Lode_file_Js']   = import_js(BASE_ASSET.'plugins/custom/leaflet/leaflet.bundle','');

        $this->data['PageContent'] = $this->load->view('../../modules/App_RealEstate_Preview/views//Preview_View_Request', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Preview_Completed()
    {

        $this->data['Page_Title']  = 'الزيارات السابقة';

        $this->mybreadcrumb->add(lang('Dashboard'), '');
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_RealEstate_Preview/views/Preview_Completed', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################



}