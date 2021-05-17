<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_Fields extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'ادارة الحقول';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $this->data['Page_Title']  = lang('Management_Fields');


        $where_Fields = array(
            "Fields_company_id" => $this->aauth->get_user()->company_id
        );

        $Get_Fields = Get_Fields($where_Fields);

        if($Get_Fields->num_rows() >0){
            foreach ($Get_Fields->result() AS $ROW )
            {

                if ($ROW->Fields_status_Fields == 1) {
                    $Fields_status = Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
                } else {
                    $Fields_status = Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
                }

                if($ROW->Fields_status_system == 1){
                    $Fields_status_system  =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Basic_System')));
                }else{

                    $options = array();

                    $options['edit'] = array(
                        "class"=>"","id"=>"", "title" => lang('edit_button'), "data-attribute" => '', "href" => "#"
                    );

                    if($ROW->Fields_status_Fields == 0) {
                        $options['active'] = array(
                            "class"=>"","id"=>"", "title" => lang('active_button'), "data-attribute" => '',
                            "href" => base_url(APP_NAMESPACE_URL."/Fields/Status_Fields/".$ROW->Fields_uuid."/1")
                        );
                    }else {
                        $options['disable'] = array(
                            "class"=>"","id"=>"", "title" => lang('disable_button'), "data-attribute" => '',
                            "href" => base_url(APP_NAMESPACE_URL."/Fields/Status_Fields/".$ROW->Fields_uuid."/0")
                        );
                    }

                    $Fields_status_system =  Create_Options_Button($options);

                } // if($ROW->list_data_status == 1)

                if($ROW->Fields_company_id == 0){
                    $Fields_company_id = 'النظام';
                }else{
                    $Fields_company_id = Get_Company($ROW->Fields_company_id)->companies_Trade_Name;
                }

                $this->data['Fields_List'][]  = array(
                    "Fields_id"           => $ROW->Fields_id,
                    "Fields_key"          => $ROW->Fields_key,
                    "Fields_type"         => $ROW->Fields_Type_Fields,
                    "Fields_view_company" => $ROW->Fields_view_company,
                    "Fields_FORM_TYPE"    => Get_options_List_Translation($ROW->Fields_FORM_TYPE)->item_translation,
                    "Fields_createBy"     => $this->aauth->get_user($ROW->Fields_createBy)->full_name.' - '.date("Y-m-d h:i:s a",$ROW->Fields_createDate),
                    "Fields_translation"  => $ROW->item_translation,
                    "Fields_status"       => $Fields_status,
                    "Fields_main_system"  => $Fields_status_system,
                );

            } // foreach ($Get_Fields AS $ROW )
        }else{
            $this->data['Fields_List'] = false;
        }

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Fields/views/List_Fields',$this->data,true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function add_Fields()
    {
        $this->data['Page_Title'] = lang('Add_New_Fields_button');

        $this->data['Fields_Type']      = array_Type_Fields();
        $this->data['status']           = array_options_status();
        $this->data['status_is_system'] = array_options_status_system();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Fields'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Fields/views/Form_add_Fields',$this->data,true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_Fields()
    {
        $this->form_validation->set_rules('title_ar','title_ar','required');
        $this->form_validation->set_rules('title_en','title_en','required');
        $this->form_validation->set_rules('Type_Fields','Type_Fields','required');
        $this->form_validation->set_rules('status_Fields','status_Fields','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Fields', 'refresh');

        } else {

            $Fields_key = strtoupper(str_replace(" ", "_", $this->input->post('title_en')));

            if(Get_Fields(array("Fields_key"=>$Fields_key))->num_rows()>0){

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'الحقل مضاف مسبقا';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/modules/App_Company_Fields/views/Form_add_Fields', 'refresh');

            }else {

                $data_Fields['Fields_key']            = strtoupper(str_replace(" ", "_", $this->input->post('title_en')));
                $data_Fields['Fields_Type_Fields']    = $this->input->post('Type_Fields');
                $data_Fields['Fields_status_Fields']  = $this->input->post('status_Fields');
                $data_Fields['Fields_status_system']  = 0;
                $data_Fields['Fields_FORM_TYPE']      = 65;
                $data_Fields['Fields_view_company']   = 1;
                $data_Fields['Fields_company_id']     = $this->aauth->get_user()->company_id;
                $data_Fields['Fields_createBy']       = $this->aauth->get_user()->id;
                $data_Fields['Fields_createDate']     = time();
                $data_Fields['Fields_lastModifyDate'] = 0;
                $data_Fields['Fields_isDeleted']      = 0;
                $data_Fields['Fields_DeletedBy']      = 0;

                $create_Fields = Create_Fields($data_Fields);

                if ($create_Fields) {

                    $item_ar = $this->input->post('title_ar');
                    $item_en = $this->input->post('title_en');
                    insert_translation_Language_item('portal_fields_translation', $create_Fields, $item_ar, $item_en);

                    $msg_result['key'] = 'Success';
                    $msg_result['value'] = lang('message_success_insert');
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Fields', 'refresh');

                } else {

                    $msg_result['key'] = 'Danger';
                    $msg_result['value'] = lang('message_error_insert');
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Fields', 'refresh');

                }
            } // if(Get_Fields($Fields_key))

        } // if($this->form_validation->run()==FALSE)
    }
    ###################################################################

    ###################################################################
    public function Form_Edit_Fields()
    {
        $this->data['Page_Title'] = lang('Add_New_Fields_button');

        $this->data['Fields_Type']      = array_Type_Fields();
        $this->data['status']           = array_options_status();
        $this->data['status_is_system'] = array_options_status_system();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Fields'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Fields/views/Form_add_Fields',$this->data,true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Status_Fields()
    {

        $Fields_id =  $this->uri->segment(4);
        $Status    =  $this->uri->segment(5);

        if ($Fields_id == '' or $Status == '') {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'طريقة غير صحيحة ';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Fields/', 'refresh');

        } else {

            $where_Fields = array(
               "Fields_uuid"       => $Fields_id,
               "Fields_company_id" => $this->aauth->get_user()->company_id
            );
            $Get_Fields = Get_Fields($where_Fields);

            if($Get_Fields->num_rows() >0) {

                $Fields_uuid       = $Fields_id;
                $Fields_company_id = $this->aauth->get_user()->company_id;
                $Fields_Status    = $Status;

                $Update_Custom_Fields = Update_Custom_Fields($Fields_uuid,$Fields_company_id,$Fields_Status);

                if($Update_Custom_Fields)
                {

                    Create_Logs_User('Status_Fields',$Fields_id,'Fields','Update');

                    $msg_result['key']   = 'Success';
                    $msg_result['value'] = 'تم التحديث بنجاح';
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Fields', 'refresh');
                } else {
                    $msg_result['key'] = 'Danger';
                    $msg_result['value'] = 'لم يتم التحديث يوجد مشكلة حدثت اثناء تحديث الحقل';
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Fields', 'refresh');
                }

            }else{

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'طريقة غير صحيحة ';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Fields/', 'refresh');

            } // if($Get_Fields->num_rows() >0){


        } // if ($Fields_id == '' or $Status == '')

    }
    ###################################################################

}