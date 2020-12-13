<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_management extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();

        $this->data['controller_name'] = lang('System_management');

        $this->load->model('System_Management_model');
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $this->data['Page_Title'] = lang('System_management');


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL . '/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/System_Company/views/List_company', $this->data, true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Area()
    {

        $System_Area = $this->System_Management_model->Get_System_Area();

        foreach ($System_Area->result() AS $ROW)
        {

            if($ROW->area_status == 1) {
                $area_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $area_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            if($ROW->area_modification == 1){
                $area_modification =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Basic_System')));
            }else{
                $area_modification = '';
            }

            $this->data['System_Area'][] = array(
                "area_id"           =>  $ROW->area_id,
                "area_name"         =>  $ROW->area_name,
                "area_layout"       =>  $ROW->area_layout,
                "area_status"       =>  $area_status,
                "area_modification" =>  $area_modification,
            );

        }

        $this->data['Page_Title'] = lang('System_Management_Area');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL . '/System_Management'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/System_Management/views/Area/Area', $this->data, true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Controllers()
    {

        $System_Area = $this->System_Management_model->Get_System_controllers();

        foreach ($System_Area->result() AS $ROW)
        {

            if($ROW->controllers_status == 1) {
                $controllers_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $controllers_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            if($ROW->controllers_modification == 1){
                $controllers_modification =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Basic_System')));
            }else{
                $controllers_modification = '';
            }

            $this->data['System_controllers'][] = array(
                "controllers_id"           =>  $ROW->controllers_id,
                "controllers_name"         =>  $ROW->controllers_name,
                "controllers_description"  =>  $ROW->controllers_description,
                "controllers_area"         =>  $ROW->controllers_area,
                "controllers_status"       =>  $controllers_status,
                "controllers_modification" =>  $controllers_modification,
            );

        }

        $this->data['Page_Title'] = lang('System_Management_Controllers');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL . '/System_Management'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/System_Management/views/Controllers/Controllers', $this->data, true);

        Layout_Admin($this->data);


    }
    ###################################################################


}




