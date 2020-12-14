<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Permissions extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->load->model('../../modules/System_management/models/System_Management_model');
        $this->data['controller_name'] = lang('Management_Permissions');
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $this->data['Page_Title']  = lang('Management_Permissions');




        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Permissions'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/System_Permissions/views/List_Permissions',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_Add_Permissions()
    {

        $System_Area_Active = $this->System_Management_model->Get_System_Area_Active();

        foreach ($System_Area_Active->result() as $ROW) {
            $this->data['System_Area'][] = array(
                "area_id"     => $ROW->area_id,
                "area_name"   => $ROW->area_name,
                "area_layout" => $ROW->area_layout,
            );
        }

        $System_controllers = $this->System_Management_model->Get_System_controllers();

        foreach ($System_controllers->result() as $ROW) {
            $this->data['System_controllers'][] = array(
                "controllers_id" => $ROW->controllers_id,
                "Controllers_Code" => $ROW->Controllers_Code,
                "controllers_name" => $ROW->item_translation,
            );
        }


        $this->data['status_Permissions'] = array(
            "1" => lang('Status_Active'),
            "0" => lang('Status_Disabled')
        );

        $this->data['Permissions_status_system'] = array(
            "1" => lang('Basic_System'),
            "0" => lang('Multiple_System')
        );


        $this->data['Page_Title']  = lang('add_new_Permissions_button');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Permissions'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/System_Permissions/views/Form_Add_Permissions',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################


}