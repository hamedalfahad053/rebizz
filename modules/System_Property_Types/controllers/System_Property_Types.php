<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Property_Types extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->load->model('System_Property_Types_Model');
        $this->data['controller_name'] = 'انواع العقارات';
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $this->data['Page_Title']  = 'انواع العقارات';


        $Property_Types = Get_Property_Types()->result();


        foreach ($Property_Types AS $ROW ) {

            if ($ROW->Property_Types_status == 1) {
                $Property_Types_status = Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
            } else {
                $Property_Types_status = Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
            }

            if($ROW->Property_Types_system_status == 1){
                $List_main_system =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Basic_System')));
            }else{

                $options = array();

                $options['view'] = array(
                    "class"=>"","id"=>"",
                    "title" => lang('view_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );

                $options['edit'] = array(
                    "class"=>"","id"=>"",
                    "title" => lang('edit_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );

                if($ROW->Property_Types_system_status == 0) {
                    $options['active'] = array(
                        "class"=>"","id"=>"",
                        "title" => lang('active_button'),
                        "data-attribute" => '',
                        "href" => "#"
                    );
                }else {
                    $options['disable'] = array(
                        "class"=>"","id"=>"",
                        "title" => lang('disable_button'),
                        "data-attribute" => '',
                        "href" => "#"
                    );
                }

                $options['deleted'] = array(
                    "class"=>"","id"=>"",
                    "title" => lang('deleted_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );


                $List_main_system =  Create_Options_Button($options);

            } // if($ROW->list_data_status == 1)

            if($ROW->Evaluation_is_Buildings == true){
                $Evaluation_is_Buildings = Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
            } else {
                $Evaluation_is_Buildings = Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
            }

            if($ROW->Evaluation_is_Lands == true){
                $Evaluation_is_Lands = Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
            } else {
                $Evaluation_is_Lands = Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
            }


            $this->data['Property_Types_List'][]  = array(
                "Property_Types_id"           => $ROW->Property_Types_id,
                "CATEGORY_PROPERTY"           => Get_options_List_Translation($ROW->Categories_Property_id)->item_translation,
                "Property_Types_translation"  => $ROW->item_translation,
                "Evaluation_is_Lands"         => $Evaluation_is_Lands,
                "Evaluation_is_Buildings"     => $Evaluation_is_Buildings,
                "Property_Types_status"       => $Property_Types_status,
                "Property_Types_main_system"  => $List_main_system,
            );

        }

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Property_Types/views/List_Property_Types',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Form_Add_Property_Types()
    {
        $this->data['Page_Title']  = ' اضافة فئة جديدة ';

        $this->data['status']        = array_options_status();
        $this->data['status_system'] = array_options_status_system();


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Property_Types/views/Form_Add_Property_Types',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_Property_Types()
    {

        $this->form_validation->set_rules('title_ar','title_ar','required');
        $this->form_validation->set_rules('title_en','title_en','required');
        $this->form_validation->set_rules('Status','Status','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URLrter.'/Property_Types', 'refresh');

        }else {

            $data_Property_Types['Property_Types_key']            = strtoupper(str_replace(" ", "_", $this->input->post('title_en')));
            $data_Property_Types['Property_Types_status']         = $this->input->post('Status');
            $data_Property_Types['Property_Types_createBy']       = 0;
            $data_Property_Types['Property_Types_system_status']  = 0;
            $data_Property_Types['Property_Types_createDate']     = time();
            $data_Property_Types['Property_Types_lastModifyDate'] = 0;
            $data_Property_Types['Property_Types_isDeleted']      = 0;
            $data_Property_Types['Property_Types_DeletedBy']      = 0;

            $create_Property_Types = $this->System_Property_Types_Model->Create_Property_Types($data_Property_Types);

            if ($create_Property_Types) {

                $item_ar = $this->input->post('title_ar');
                $item_en = $this->input->post('title_en');
                insert_translation_Language_item('portal_list_property_types_translation', $create_Property_Types, $item_ar, $item_en);

                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Property_Types', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Property_Types', 'refresh');
            }

        }

    }
    ###################################################################

    ###################################################################
    public function Form_Edit_Property_Types()
    {

        $this->data['Page_Title']    = ' تعديل نوع العقار ';

        $this->data['status']        = array_options_status();
        $this->data['status_system'] = array_options_status_system();


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Property_Types/views/Form_Add_Property_Types',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Update_Property_Types()
    {

        $this->form_validation->set_rules('title_ar','title_ar','required');
        $this->form_validation->set_rules('title_en','title_en','required');
        $this->form_validation->set_rules('Status','Status','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URLrter.'/Property_Types', 'refresh');

        }else {

            $data_Property_Types['Property_Types_key']            = strtoupper(str_replace(" ", "_", $this->input->post('title_en')));
            $data_Property_Types['Property_Types_status']         = $this->input->post('Status');
            $data_Property_Types['Property_Types_createBy']       = 0;
            $data_Property_Types['Property_Types_system_status']  = 0;
            $data_Property_Types['Property_Types_createDate']     = time();
            $data_Property_Types['Property_Types_lastModifyDate'] = 0;
            $data_Property_Types['Property_Types_isDeleted']      = 0;
            $data_Property_Types['Property_Types_DeletedBy']      = 0;

            $create_Property_Types = $this->System_Property_Types_Model->Create_Property_Types($data_Property_Types);

            if ($create_Property_Types) {

                $item_ar = $this->input->post('title_ar');
                $item_en = $this->input->post('title_en');
                insert_translation_Language_item('portal_list_property_types_translation', $create_Property_Types, $item_ar, $item_en);

                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Property_Types', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Property_Types', 'refresh');
            }

        }

    }
    ###################################################################

}