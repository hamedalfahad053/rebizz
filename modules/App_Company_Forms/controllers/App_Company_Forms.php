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

    }
    ###################################################################

    ###################################################################
    public function Forms_Transaction()
    {

        $this->data['Page_Title']  = 'ادارة نماذج المعاملات';

        $forms = array();

        $where_forms = array(
             "forms.LIST_FORM_TYPE"   => 65,
             "forms.company_view"     => 1,
             "forms.Forms_Status"     => 1
        );
        $Get_All_Forms = Get_All_Forms($where_forms);

        foreach ($Get_All_Forms->result() AS $RF)
        {

            if($RF->Forms_Status == 1) {
                $Forms_Status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $Forms_Status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            $forms[] = array(
                  "Forms_id"     => $RF->Forms_id,
                  "Forms_uuid"   => $RF->Forms_uuid,
                  "Forms_Key"    => $RF->Forms_Key,
                  "Forms_title"  => $RF->item_translation,
                  "Forms_Status" => $Forms_Status
            );

        }

        $this->data['Forms'] = $forms;

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent']   = $this->load->view('../../modules/App_Company_Forms/views/List_Forms', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Manage_Forms_Transaction()
    {


        $Forms_id =  $this->uri->segment(4);

        $where_forms = array(
            "forms.Forms_uuid"   =>$Forms_id,
        );

        $this->data['Forms']           = Get_All_Forms($where_forms)->row();
        $this->data['Form_Components'] = Get_Form_Components($this->data['Forms']->Forms_id);


        $this->data['Page_Title']      = ' ادارة نموذج :'.$this->data['Forms']->item_translation;

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent']   = $this->load->view('../../modules/App_Company_Forms/views/Manage_Forms_Transaction', $this->data, true);

        Layout_Apps($this->data);

        
    }
    ###################################################################

    ###################################################################
    public function Add_Components_Forms_Transaction()
    {

        $Forms_id =  $this->uri->segment(4);

        $where_forms = array(
            "forms.Forms_uuid"   =>$Forms_id,
        );
        $this->data['Forms']           = Get_All_Forms($where_forms)->row();

        $this->data['status']          = array_options_status();

        $this->data['Page_Title']      = ' اضافة قسم جديد :'.$this->data['Forms']->item_translation;

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent']   = $this->load->view('../../modules/App_Company_Forms/views/Add_Components_Forms_Transaction', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Components_Forms_Transaction()
    {

        $this->form_validation->set_rules('Forms_id', 'Forms_id', 'required');
        $this->form_validation->set_rules('Sections_Status', 'Sections_Status', 'required');
        $this->form_validation->set_rules('Sections_title_ar', 'Sections_title_ar', 'required');
        $this->form_validation->set_rules('Sections_title_en', 'Sections_title_en', 'required');


        $where_forms = array(
            "forms.Forms_uuid"   => $this->input->post('Forms_id'),
        );
        $Forms           = Get_All_Forms($where_forms)->row();

        if ($this->form_validation->run() == FALSE) {

            $msg_result['key'] = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Forms/Manage_Forms_Transaction/' . $Forms->Forms_uuid, 'refresh');

        } else {

            $data_Sections_Components['components_key']            = strtoupper(str_replace(" ", "_", $this->input->post('Sections_title_en')));
            $data_Sections_Components['Forms_id']                  = $this->input->post('Forms_id');
            $data_Sections_Components['components_status']         = $this->input->post('Sections_Status');
            $data_Sections_Components['company_id']                = $this->aauth->get_user()->company_id;
            $data_Sections_Components['components_sort']           = 0;

            $data_Sections_Components['components_createDate']     = time();
            $data_Sections_Components['components_lastModifyDate'] = 0;
            $data_Sections_Components['components_isDeleted']      = 0;
            $data_Sections_Components['components_DeletedBy']      = 0;

            if ($this->input->post('All_CUSTOMER_CATEGORY') == 1) {
                $data_Sections_Components['With_Type_CUSTOMER'] = 'All';
            } else {
                if (is_array($this->input->post('LIST_CUSTOMER_CATEGORY'))) {

                    $data_Sections_Components['With_Type_CUSTOMER'] = @implode(',', $this->input->post('LIST_CUSTOMER_CATEGORY'));
                    $data_Sections_Components['With_CLIENT']        = @implode(',', $this->input->post('LIST_Client'));

                } else {
                    $data_Sections_Components['With_Type_CUSTOMER'] = $this->input->post('LIST_CUSTOMER_CATEGORY');
                }
            }

            if ($this->input->post('All_Property_Types') == 1) {
                $data_Sections_Components['With_Type_Property'] = 'All';
            } else {
                if (is_array($this->input->post('Property_Types'))) {
                    $data_Sections_Components['With_Type_Property'] = @implode(',', $this->input->post('Property_Types'));
                } else {
                    $data_Sections_Components['With_Type_Property'] = $this->input->post('Property_Types');
                }
            }

            if ($this->input->post('All_TYPES_APPRAISAL') == 1) {
                $data_Sections_Components['With_TYPES_APPRAISAL'] = 'All';
            } else {
                if (is_array($this->input->post('LIST_TYPES_OF_REAL_ESTATE_APPRAISAL'))) {
                    $data_Sections_Components['With_TYPES_APPRAISAL'] = @implode(',', $this->input->post('LIST_TYPES_OF_REAL_ESTATE_APPRAISAL'));
                } else {
                    $data_Sections_Components['With_TYPES_APPRAISAL'] = $this->input->post('LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
                }
            }

            if ($this->input->post('All_evaluation_methods') == 1) {
                $data_Sections_Components['With_Type_evaluation_methods'] = 'All';
            } else {
                if (is_array($this->input->post('evaluation_methods'))) {
                    $data_Sections_Components['With_Type_evaluation_methods'] = @implode(',', $this->input->post('evaluation_methods'));
                } else {
                    $data_Sections_Components['With_Type_evaluation_methods'] = $this->input->post('evaluation_methods');
                }
            }

            $Create_Forms_Components = Create_Forms_Components($data_Sections_Components);

            if($Create_Forms_Components){

                $item_ar = $this->input->post('Sections_title_ar');
                $item_en = $this->input->post('Sections_title_en');
                insert_translation_Language_item('portal_forms_components_translation', $Create_Forms_Components, $item_ar, $item_en);

                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'Forms/Form_Components/' . $Forms->Forms_uuid , 'refresh');

            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Forms/Form_Components/' . $Forms->Forms_uuid , 'refresh');
            } // if($Create_Forms_Components)

        }


    }
    ###################################################################

    ###################################################################
    public function Add_Fields_Components()
    {

        $form_id       = $this->uri->segment(4);
        $Components_id = $this->uri->segment(5);

        $Fields_data   = array();

        if($form_id == '' or $Components_id=='') {

            $msg_result['key'] = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Forms','refresh');

        }else{

            $Query_Forms      = Get_All_Forms(array("Forms_uuid"=>$form_id))->row();
            $Query_Components = Get_Form_Components($Query_Forms->Forms_id,array("components.components_uuid"=>$Components_id))->row();

            $this->data['Query_Forms']      = $Query_Forms;
            $this->data['Query_Components'] = $Query_Components;

            $lang         = get_current_lang();
            $query_Fields = app()->db->from('portal_fields  fields');
            $query_Fields = app()->db->join('portal_fields_translation  fields_translation', 'fields.Fields_id=fields_translation.item_id');
            $query_Fields = app()->db->where('( `Fields_company_id` = 0 or `Fields_company_id` = '.$this->aauth->get_user()->company_id.')');
            $query_Fields = app()->db->where('fields.Fields_FORM_TYPE',65);
            $query_Fields = app()->db->where('fields.Fields_view_company',1);
            $query_Fields = app()->db->where('fields.Fields_status_Fields',1);
            $query_Fields = app()->db->where('fields_translation.translation_lang',$lang);
            $query_Fields = app()->db->get();

            foreach ($query_Fields->result() as $Row) {

                $filter = Query_Fields_Components(array("Fields_id" => $Row->Fields_id,"Fields_Type"=>'Fields'))->num_rows();

                if($filter == 0){
                    $Fields_data[] = array(
                        "Fields_id"    => $Row->Fields_id,
                        "Fields_title" => $Row->item_translation
                    );
                }

            } // foreach ($Fields->result() as $Row)


            $this->data['Fields_data'] = $Fields_data;

            $this->data['Page_Title'] = ' اضافة حقل للمكون  ';
            $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
            $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Forms/views/Form_Add_Fields_Components', $this->data, true);
            Layout_Apps($this->data);

        } // if($form_id == '' or $Components_id=='')


    }
    ###################################################################

    ###################################################################
    public function Create_Fields_Components()
    {

        $this->form_validation->set_rules('Form_id', 'Form_id', 'required');
        $this->form_validation->set_rules('Components_id', 'Fields_Components_id', 'required');
        $this->form_validation->set_rules('Fields_Add', 'Fields_Add', 'required');

        $Form_id       = $this->input->post('Form_id');
        $Components_id = $this->input->post('Components_id');

        if ($this->form_validation->run() == FALSE) {

            $msg_result['key'] = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Forms/Manage_Forms_Transaction/' . $Form_id ,'refresh');

        } else {


            $data_Sections_Components['Forms_id']         = $this->input->post('Form_id');
            $data_Sections_Components['Components_id']    = $this->input->post('Components_id');
            $data_Sections_Components['Fields_id']        = $this->input->post('Fields_Add');
            $data_Sections_Components['Fields_key']       = Get_Fields(array("Fields_id"=>$this->input->post('Fields_Add')))->row()->Fields_key;

            if ($this->input->post('All_CUSTOMER_CATEGORY') == 1) {
                $data_Sections_Components['With_CLIENT']        = 'All';
                $data_Sections_Components['With_Type_CUSTOMER'] = 'All';
            } else {
                $data_Sections_Components['With_CLIENT']        = implode(',', $this->input->post('LIST_Client'));
                $data_Sections_Components['With_Type_CUSTOMER'] = implode(',', $this->input->post('LIST_CUSTOMER_CATEGORY'));
            }



            if ($this->input->post('All_Property_Types') == 1) {
                $data_Sections_Components['With_Type_Property'] = 'All';
            } else {
                $data_Sections_Components['With_Type_Property'] = implode(',', $this->input->post('Property_Types'));
            }

            if ($this->input->post('All_TYPES_APPRAISAL') == 1) {
                $data_Sections_Components['With_TYPES_APPRAISAL'] = 'All';
            } else {
                $data_Sections_Components['With_TYPES_APPRAISAL'] = implode(',', $this->input->post('LIST_TYPES_OF_REAL_ESTATE_APPRAISAL'));
            }

            if ($this->input->post('All_evaluation_methods') == 1) {
                $data_Sections_Components['With_Type_evaluation_methods'] = 'All';
            } else {
                $data_Sections_Components['With_Type_evaluation_methods'] = implode(',', $this->input->post('evaluation_methods'));
            }



            $data_Sections_Components['Fields_Type']  = 'Fields';
            $data_Sections_Components['company_id']   = $this->aauth->get_user()->company_id;

            $Create_Fields = Create_Fields_Form_Components($data_Sections_Components);

            if ($Create_Fields) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Forms/Manage_Forms_Transaction/' . $Form_id , 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Forms/Manage_Forms_Transaction/' . $Form_id , 'refresh');
            } // if

        }
    }
    ###################################################################

    ###################################################################
    public function Add_List_Components()
    {
        $this->data['Page_Title'] = ' اضافة قائمة   ';

        $this->data['Components_id'] = $this->uri->segment(4);



        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Forms/views/Form_Add_List', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

}