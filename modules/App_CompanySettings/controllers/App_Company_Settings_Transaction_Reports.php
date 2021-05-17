<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_Settings_Transaction_Reports extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' تقارير التقييم ';


        //$fileExt = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $where_Transaction_Reports  = array(
            "company_id" => $this->aauth->get_user()->company_id
        );


        $Get_Reports = app()->db->where('company_id',$this->aauth->get_user()->company_id);
        $Get_Reports = app()->db->get('portal_build_reports_transaction');


        $this->data['Get_Reports'] = $Get_Reports;

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = 'تقارير التقييم ';

        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/Settings_Transaction_Reports/List_Transaction_Reports', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################


    ###################################################################
    public function Form_Add_Transaction_Reports()
    {

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = ' انشاء تقرير جديد ';
        $this->data['Page_Company'] = '';
        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/Settings_Transaction_Reports/Form_Add_Transaction_Reports', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################


    ###################################################################
    public function Create_Transaction_Reports()
    {

        $this->form_validation->set_rules('title_ar','title_ar','required');
        $this->form_validation->set_rules('title_en','title_en','required');
        //$this->form_validation->set_rules('LIST_TYPES_OF_REAL_ESTATE_APPRAISAL','Type_Fields','required');
        //$this->form_validation->set_rules('Type_Reports','Type_Reports','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Settings_Transaction_Reports/Form_Add_Transaction_Reports', 'refresh');

        } else {

            $Reports_key = strtoupper(str_replace(" ", "_", $this->input->post('title_en')));

            $data_Reports['Reports_key']            = strtoupper(str_replace(" ", "_", $this->input->post('title_en')));
            $data_Reports['Reports_title_ar']       = $this->input->post('title_ar');
            $data_Reports['Reports_title_en']       = $this->input->post('title_en');
            $data_Reports['Reports_TYPES']          = 0;//$this->input->post('LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
            $data_Reports['Reports_Clint']          = 0;//$this->input->post('Type_Reports');
            $data_Reports['company_id']             = $this->aauth->get_user()->company_id;
            $data_Reports['Reports_createBy']       = $this->aauth->get_user()->id;
            $data_Reports['Reports_Status']         = 1;
            $data_Reports['Reports_createDate']     = time();
            $data_Reports['Reports_lastModifyDate'] = 0;
            $data_Reports['Reports_isDeleted']      = 0;
            $data_Reports['Reports_DeletedBy']      = 0;


            $create_Reports = app()->db->insert('portal_build_reports_transaction',$data_Reports);

            if ($create_Reports) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_Transaction_Reports/index', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_Transaction_Reports/Form_Add_Transaction_Reports', 'refresh');
            }



        } // if($this->form_validation->run()==FALSE)

    }
    ###################################################################


    ###################################################################
    public function Editor_Transaction_Reports()
    {

        $Transaction_Reports_id     =  $this->uri->segment(4);

        $Get_Reports = app()->db->where('build_reports_uuid',$Transaction_Reports_id);
        $Get_Reports = app()->db->where('company_id',$this->aauth->get_user()->company_id);
        $Get_Reports = app()->db->get('portal_build_reports_transaction');

        $this->data['Get_Reports'] = $Get_Reports->row();


        $Get_All_Form = app()->db->distinct('Forms_id');
        $Get_All_Form = app()->db->get('portal_forms_components_fields');



        $this->data['Tag_Clint_info']   = '';



        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = ' تحرير التقرير ';

        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/Settings_Transaction_Reports/Editor_Transaction_Reports', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################


    ###################################################################
    public function Update_Transaction_Reports()
    {

        $this->form_validation->set_rules('Transaction_Reports_uuid','معرف التقرير','required');
        $this->form_validation->set_rules('Reports_content','محتوى التقرير','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Settings_Transaction_Reports/Editor_Transaction_Reports', 'refresh');

        } else {

            $Reports_uuid = $this->input->post('Transaction_Reports_uuid');


            $Update_Transaction_Reports = app()->db->where('build_reports_uuid',$this->input->post('Transaction_Reports_uuid'));
            $Update_Transaction_Reports = app()->db->set('Reports_content',$this->input->post('Reports_content',false));
            $Update_Transaction_Reports = app()->db->update('portal_build_reports_transaction');

        }

        if($Update_Transaction_Reports){
            $msg_result['key']   = 'Success';
            $msg_result['value'] = 'تم التحديث بنجاح';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Settings_Transaction_Reports/Editor_Transaction_Reports/'.$Reports_uuid, 'refresh');
        } else {
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'يوجد خطا في تحديث البيانات';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Settings_Transaction_Reports/Editor_Transaction_Reports/'.$Reports_uuid, 'refresh');
        }

    }
    ###################################################################




    ###################################################################
    public function List_Text_Static_Transaction_Reports()
    {

        $Get_Reports = app()->db->where('company_id',$this->aauth->get_user()->company_id);
        $Get_Reports = app()->db->get('protal_text_static_transaction_reports');


        $this->data['text_static'] = $Get_Reports;

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = ' نصوص التقارير  ';

        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/Settings_Transaction_Reports/List_Text_Static_Transaction_Reports', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Form_Text_Static_Transaction_Reports()
    {


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));
        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = '  تعريف نص جديد للتقارير  ';

        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/Settings_Transaction_Reports/Form_Text_Static_Transaction_Reports', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Text_Static_Transaction_Reports()
    {
        $this->form_validation->set_rules('title_ar','العنوان بالعربية','required');
        $this->form_validation->set_rules('title_ar','العنوان بالانجليزية','required');
        $this->form_validation->set_rules('text_ar','النص بالعربية','required');
        $this->form_validation->set_rules('text_en','النص بالانجليزية','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Settings_Transaction_Reports/Form_Text_Static_Transaction_Reports', 'refresh');

        } else {


            $data_Reports['title_ar']               = $this->input->post('title_ar');
            $data_Reports['title_en']               = $this->input->post('title_en');
            $data_Reports['text_ar']                = $this->input->post('text_ar');
            $data_Reports['text_en']                = $this->input->post('text_en');
            $data_Reports['company_id']             = $this->aauth->get_user()->company_id;
            $data_Reports['createBy']               = $this->aauth->get_user()->id;
            $data_Reports['createDate']             = time();
            $data_Reports['lastModifyBy']           = 0;
            $data_Reports['lastModifyDate']         = 0;

            $create_Reports = app()->db->insert('protal_text_static_transaction_reports',$data_Reports);

            if ($create_Reports) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_Transaction_Reports/List_Text_Static_Transaction_Reports', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_Transaction_Reports/Form_Text_Static_Transaction_Reports', 'refresh');
            }

        } // if($this->form_validation->run()==FALSE)


    }
    ###################################################################

    ###################################################################
    public function Edit_Form_Text_Static_Transaction_Reports()
    {

        $text_static_uuid = $this->uri->segment(4);

        $Get_text_static                = app()->db->where('text_uuid',$text_static_uuid);
        $Get_text_static                = app()->db->where('company_id',$this->aauth->get_user()->company_id);
        $Get_text_static                = app()->db->get('protal_text_static_transaction_reports');
        $this->data['text_static']      = $Get_text_static->row();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));
        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = '  تعديل نص  للتقارير  ';

        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/Settings_Transaction_Reports/Edit_Form_Text_Static_Transaction_Reports', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Update_Text_Static_Transaction_Reports()
    {
        $this->form_validation->set_rules('text_uuid','معرف النص','required');
        $this->form_validation->set_rules('title_ar','العنوان بالعربية','required');
        $this->form_validation->set_rules('title_ar','العنوان بالانجليزية','required');
        $this->form_validation->set_rules('text_ar','النص بالعربية','required');
        $this->form_validation->set_rules('text_en','النص بالانجليزية','required');


        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Settings_Transaction_Reports/Edit_Form_Text_Static_Transaction_Reports/'.$this->uri->segment(4), 'refresh');

        } else {

            $Update_Reports = app()->db->where('text_uuid',$this->input->post('text_uuid'));
            $Update_Reports = app()->db->set('title_ar',$this->input->post('title_ar'));
            $Update_Reports = app()->db->set('title_en',$this->input->post('title_en'));
            $Update_Reports = app()->db->set('text_ar',$this->input->post('text_ar'));
            $Update_Reports = app()->db->set('text_en',$this->input->post('text_en'));
            $Update_Reports = app()->db->set('lastModifyBy',$this->aauth->get_user()->id);
            $Update_Reports = app()->db->set('lastModifyDate',time());
            $Update_Reports = app()->db->update('protal_text_static_transaction_reports');

            if ($Update_Reports) {
                $msg_result['key']      = 'Success';
                $msg_result['value']    = 'تم التحديث بنجاح';
                $msg_result_view        = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_Transaction_Reports/List_Text_Static_Transaction_Reports', 'refresh');
            } else {
                $msg_result['key']      = 'Danger';
                $msg_result['value']    = 'حصل خطا اثناء التحديث يرجى المحاولة مره اخرى';
                $msg_result_view        = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_Transaction_Reports/List_Text_Static_Transaction_Reports', 'refresh');
            }

        } // if($this->form_validation->run()==FALSE)
    }
    ###################################################################



}