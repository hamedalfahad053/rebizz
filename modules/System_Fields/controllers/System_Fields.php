<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Fields extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Fields_model');

        $this->data['controller_name'] = lang('Management_Fields');
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $this->data['Page_Title']  = lang('Management_Fields');

        $Get_Fields = Get_Fields()->result();

        foreach ($Get_Fields AS $ROW )
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

                $options['view'] = array(
                    "class"=>"","id"=>"", "title" => lang('view_button'), "data-attribute" => '', "href" => "#"
                );

                $options['edit'] = array(
                    "class"=>"","id"=>"", "title" => lang('edit_button'), "data-attribute" => '', "href" => "#"
                );

                if($ROW->Fields_status_Fields == 0) {
                    $options['active'] = array(
                        "class"=>"","id"=>"", "title" => lang('active_button'), "data-attribute" => '', "href" => "#"
                    );
                }else {
                    $options['disable'] = array(
                        "class"=>"","id"=>"", "title" => lang('disable_button'), "data-attribute" => '', "href" => "#"
                    );
                }

                $options['deleted'] = array(
                    "class"=>"","id"=>"", "title" => lang('deleted_button'), "data-attribute" => '', "href" => "#"
                );

                $Fields_status_system =  Create_Options_Button($options);

            } // if($ROW->list_data_status == 1)

            if($ROW->Fields_company_id==0){
                $Fields_company_id = 'النظام';
            }else{
                $Fields_company_id = $ROW->Fields_company_id;
            }

            $this->data['Fields_List'][]  = array(
                "Fields_id"           => $ROW->Fields_id,
                "Fields_key"          => $ROW->Fields_key,
                "Fields_type"         => $ROW->Fields_Type_Fields,
                "Fields_view_company" => $ROW->Fields_view_company,
                "Fields_FORM_TYPE"    => Get_options_List_Translation($ROW->Fields_FORM_TYPE)->item_translation,
                "Fields_company_id"   => $Fields_company_id,
                "Fields_translation"  => $ROW->item_translation,
                "Fields_status"       => $Fields_status,
                "Fields_main_system"  => $Fields_status_system,
            );

        } // foreach ($Get_Fields AS $ROW )


        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Fields/views/List_Fields',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_add_Fields()
    {
        $this->data['Page_Title'] = lang('Add_New_Fields_button');

        $this->data['Fields_Type']      = array_Type_Fields();
        $this->data['status']           = array_options_status();
        $this->data['status_is_system'] = array_options_status_system();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Fields'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Fields/views/Form_add_Fields',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_Fields()
    {
        $this->form_validation->set_rules('title_ar','title_ar','required');
        $this->form_validation->set_rules('title_en','title_en','required');
        $this->form_validation->set_rules('Type_Fields','Type_Fields','required');
        $this->form_validation->set_rules('status_Fields','status_Fields','required');
        $this->form_validation->set_rules('status_system','status_system','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/Property_Types', 'refresh');

        } else {

            $Fields_key = strtoupper(str_replace(" ", "_", $this->input->post('title_en')));

            if(Get_Fields(array("Fields_key"=>$Fields_key))->num_rows()>0){

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'الحقل مضاف مسبقا';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Fields', 'refresh');

            }else {

                $data_Fields['Fields_key']            = strtoupper(str_replace(" ", "_", $this->input->post('title_en')));
                $data_Fields['Fields_Type_Fields']    = $this->input->post('Type_Fields');
                $data_Fields['Fields_status_Fields']  = $this->input->post('status_Fields');
                $data_Fields['Fields_status_system']  = $this->input->post('status_system');
                $data_Fields['Fields_FORM_TYPE']      = $this->input->post('Fields_FORM_TYPE');
                $data_Fields['Fields_view_company']   = $this->input->post('Fields_view_company');
                $data_Fields['Fields_company_id']     = 0;
                $data_Fields['Fields_createDate']     = time();
                $data_Fields['Fields_lastModifyDate'] = 0;
                $data_Fields['Fields_isDeleted']      = 0;
                $data_Fields['Fields_DeletedBy']      = 0;

                $create_Fields = $this->Fields_model->Create_Fields($data_Fields);

                if ($create_Fields) {

                    $item_ar = $this->input->post('title_ar');
                    $item_en = $this->input->post('title_en');
                    insert_translation_Language_item('portal_fields_translation', $create_Fields, $item_ar, $item_en);

                    $msg_result['key'] = 'Success';
                    $msg_result['value'] = lang('message_success_insert');
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(ADMIN_NAMESPACE_URL . '/Fields', 'refresh');

                } else {

                    $msg_result['key'] = 'Danger';
                    $msg_result['value'] = lang('message_error_insert');
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(ADMIN_NAMESPACE_URL . '/Fields', 'refresh');

                }
            } // if(Get_Fields($Fields_key))

        } // if($this->form_validation->run()==FALSE)
    }
    ###################################################################




    ###################################################################
    public function validating_Fields_Template()
    {
        $Type_Fields = $this->input->get('options_Type_Fields');

        $Type_Fields_html_view = '';

        $Type_Fields_html_view .= validating_Fields_required();

        if($Type_Fields == 'text') {

            $Type_Fields_html_view .= validating_Fields_min_length();
            $Type_Fields_html_view .= validating_Fields_max_length();
            $Type_Fields_html_view .= validating_Fields_matches_Fields();

        } elseif ($Type_Fields == 'date') {


        } elseif ($Type_Fields == 'email') {

            $Type_Fields_html_view .= validating_Fields_valid_email();

        } elseif ($Type_Fields == 'url') {

            $Type_Fields_html_view .= validating_Fields_valid_url() ;

        } elseif ($Type_Fields=='number') {

            $Type_Fields_html_view .= validating_Fields_numeric();
            $Type_Fields_html_view .= validating_Fields_integer();
            $Type_Fields_html_view .= validating_Fields_decimal();
            $Type_Fields_html_view .= validating_Fields_is_natural();
            $Type_Fields_html_view .= validating_Fields_is_natural_no_zero();

        } elseif ($Type_Fields=='select' or $Type_Fields=='checkbox' or $Type_Fields=='radio'){

        } elseif ($Type_Fields=='textarea') {

        }

        echo $Type_Fields_html_view;
    }
    ###################################################################










}