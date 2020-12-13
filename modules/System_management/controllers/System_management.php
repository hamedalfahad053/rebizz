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

        foreach ($System_Area->result() as $ROW) {

            if ($ROW->area_status == 1) {
                $area_status = Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
            } else {
                $area_status = Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
            }

            if ($ROW->area_modification == 1) {
                $area_modification = Create_Status_badge(array("key" => "Danger", "value" => lang('Basic_System')));
            } else {
                $area_modification = '';
            }

            $this->data['System_Area'][] = array(
                "area_id" => $ROW->area_id,
                "area_name" => $ROW->area_name,
                "area_layout" => $ROW->area_layout,
                "area_status" => $area_status,
                "area_modification" => $area_modification,
            );

        }

        $this->data['Page_Title'] = lang('System_Management_Area');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL . '/System_Management'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent'] = $this->load->view('../../modules/System_Management/views/Area/Area', $this->data, true);

        Layout_Admin($this->data);

    }
    ###################################################################


    ###################################################################
    public function Controllers()
    {

        $System_controllers = $this->System_Management_model->Get_System_controllers();

        if($System_controllers->num_rows()>0){
            foreach ($System_controllers->result() as $ROW) {

                if ($ROW->controllers_status == 1) {
                    $controllers_status = Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
                } else {
                    $controllers_status = Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
                }

                if ($ROW->controllers_modification == 1) {
                    $controllers_modification = Create_Status_badge(array("key" => "Danger", "value" => lang('Basic_System')));
                } else {
                    $controllers_modification = '';
                }

                $Controllers_Functions = Create_One_Button_Text(
                    array('title'=> lang('Controllers_Functions') ,
                          'href'=>base_url(ADMIN_NAMESPACE_URL.'/System_Management/Controllers_Functions/'.$ROW->controllers_id.'')
                    )
                );

                $System_Area = $this->System_Management_model->Get_System_Area_Row($ROW->controllers_area)->row();

                $this->data['System_controllers'][] = array(
                    "controllers_id" => $ROW->controllers_id,
                    "Controllers_Code" => $ROW->Controllers_Code,
                    "Controllers_Functions" => $Controllers_Functions,
                    "controllers_name" => $ROW->item_translation,
                    "controllers_description" => $ROW->controllers_description,
                    "controllers_area" => $System_Area->area_name,
                    "controllers_status" => $controllers_status,
                    "controllers_modification" => $controllers_modification,
                );

            }
        }else{
            $this->data['System_controllers'] = '';
        }

        $this->data['Page_Title'] = lang('System_Management_Controllers');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL . '/System_Management'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent'] = $this->load->view('../../modules/System_Management/views/Controllers/Controllers', $this->data, true);

        Layout_Admin($this->data);
    }
    ###################################################################


    ###################################################################
    public function Form_Add_New_Controllers()
    {

        $System_Area_Active = $this->System_Management_model->Get_System_Area_Active();

        foreach ($System_Area_Active->result() as $ROW) {
            $this->data['System_Area'][] = array(
                "area_id"     => $ROW->area_id,
                "area_name"   => $ROW->area_name,
                "area_layout" => $ROW->area_layout,
            );
        }

        $this->data['status_controller'] = array(
            "1" => lang('Status_Active'),
            "0" => lang('Status_Disabled')
        );

        $this->data['controller_status_system'] = array(
            "1" => lang('Basic_System'),
            "0" => lang('Multiple_System')
        );

        $this->data['Page_Title']  = lang('add_new_System_button');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/System_management/views/Controllers/Form_Add_Controllers',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_New_Controllers()
    {

        $this->form_validation->set_rules('title_ar',lang('Global_form_title_ar'),'required');
        $this->form_validation->set_rules('title_en',lang('Global_form_title_en'),'required');
        $this->form_validation->set_rules('Controllers_Code',lang('Controllers_Code'),'required');
        $this->form_validation->set_rules('Area',lang('System_Area'),'required');
        $this->form_validation->set_rules('status_controller',lang('Table_Status'),'required');
        $this->form_validation->set_rules('status_system',lang('Basic_System'),'required');

        if($this->form_validation->run()==FALSE){
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/System_Management/Form_Add_New_Controllers', 'refresh');
        }else {

            $data_Controllers['Controllers_Code']          = $this->input->post('Controllers_Code');
            $data_Controllers['controllers_area']          = $this->input->post('Area');
            $data_Controllers['controllers_status']        = $this->input->post('status_controller');
            $data_Controllers['controllers_modification']  = $this->input->post('status_system');

            $Create_Controllers  = $this->System_Management_model->Create_Controllers($data_Controllers);

            if($Create_Controllers){

                $item_ar = $this->input->post('title_ar');
                $item_en = $this->input->post('title_en');
                insert_translation_Language_item('portal_system_controllers_translation',$Create_Controllers,$item_ar,$item_en);

                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL.'/System_Management/Controllers' , 'refresh');
            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL.'/System_Management/Form_Add_New_Controllers', 'refresh');
            }


        }

    }
    ###################################################################





}




