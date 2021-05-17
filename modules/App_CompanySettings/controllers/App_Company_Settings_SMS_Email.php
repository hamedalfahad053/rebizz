<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_Settings_SMS_Email extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' اعدادت النظام ';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        exit;
    }
    ###################################################################

    ###################################################################
    public function Setting_SMS_Messages()
    {

        $where_extra_    = array(
            "company_id"    => $this->aauth->get_user()->company_id,
            "messages_type" => 'SMS',
            "isDeleted"     => 0
        );
        $Get_Sms_Email_Messages = Get_Sms_Email_Messages($where_extra_);

        if($Get_Sms_Email_Messages->num_rows()>0){
            $this->data['Sms_Email_Messages'] = $Get_Sms_Email_Messages;
        }else{
            $this->data['Sms_Email_Messages'] = false;
        }

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'اعداد الرسائل النصية';

        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Settings_SMS_Email/Setting_SMS_Messages', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Setting_Email_Messages()
    {

        $where_extra_    = array(
            "company_id"    => $this->aauth->get_user()->company_id,
            "messages_type" => 'Email',
            "isDeleted"     => 0
        );
        $Get_Sms_Email_Messages = Get_Sms_Email_Messages($where_extra_);

        if($Get_Sms_Email_Messages->num_rows()>0){
            $this->data['Sms_Email_Messages'] = $Get_Sms_Email_Messages;
        }else{
            $this->data['Sms_Email_Messages'] = false;
        }

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'اعداد الرسائل البريد الالكتروني';

        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Settings_SMS_Email/Setting_Email_Messages', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_SMS_Messages()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'اضافة رسالة جديدة';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Settings_SMS_Email/Setting_SMS_Messages_Form_Add', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_Email_Messages()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'اضافة رسالة جديدة';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Settings_SMS_Email/Setting_Email_Messages_Form_Add', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_SMS_Messages()
    {
        $this->form_validation->set_rules('messages_title','عنوان الرسالة','required');
        $this->form_validation->set_rules('messages_text','نص الرسالة ','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Settings_SMS_Email/Form_SMS_Messages', 'refresh');

        } else {

            $data_Messages['messages_title']  = $this->input->post('messages_title');
            $data_Messages['messages_type']   = 'SMS';
            $data_Messages['messages_text']   = $this->input->post('messages_text');
            $data_Messages['company_id']      = $this->aauth->get_user()->company_id;
            $data_Messages['createBy']        = $this->aauth->get_user()->id;
            $data_Messages['createDate']      = time();
            $data_Messages['lastModifyDate']  = 0;
            $data_Messages['isDeleted']       = 0;
            $data_Messages['DeletedBy']       = 0;

            $Create_Sms_Email_Messages = Create_Sms_Email_Messages($data_Messages);

            if ($Create_Sms_Email_Messages) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_SMS_Email/Setting_SMS_Messages', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_SMS_Email/Setting_SMS_Messages', 'refresh');
            }

        }
    }
    ###################################################################

    ###################################################################
    public function Create_Email_Messages()
    {
        $this->form_validation->set_rules('messages_title','عنوان الرسالة','required');
        $this->form_validation->set_rules('messages_text','نص الرسالة ','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Settings_SMS_Email/Form_Email_Messages', 'refresh');

        } else {

            $data_Messages['messages_title']  = $this->input->post('messages_title');
            $data_Messages['messages_type']   = 'Email';
            $data_Messages['messages_text']   = $this->input->post('messages_text');
            $data_Messages['company_id']      = $this->aauth->get_user()->company_id;
            $data_Messages['createBy']        = $this->aauth->get_user()->id;
            $data_Messages['createDate']      = time();
            $data_Messages['lastModifyDate']  = 0;
            $data_Messages['isDeleted']       = 0;
            $data_Messages['DeletedBy']       = 0;

            $Create_Sms_Email_Messages = Create_Sms_Email_Messages($data_Messages);

            if ($Create_Sms_Email_Messages) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_SMS_Email/Setting_Email_Messages', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_SMS_Email/Setting_Email_Messages', 'refresh');
            }

        }
    }
    ###################################################################

    ###################################################################
    public function Deleted_Messages()
    {
        $Messages_id =  $this->uri->segment(4);

        if($Messages_id == ''){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'خطا اثناء عملية الحذف يرجى المحاولة مره اخرى';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Settings_SMS_Email/Setting_Email_Messages', 'refresh');

        } else {


            $Deleted_Messages = app()->db->where('messages_uuid',$Messages_id);
            $Deleted_Messages = app()->db->where('company_id',$this->aauth->get_user()->company_id);
            $Deleted_Messages = app()->db->set('DeletedBy',$this->aauth->get_user()->id);
            $Deleted_Messages = app()->db->set('isDeleted',1);
            $Deleted_Messages = app()->db->update('protal_mail_sms_messages');


            if ($Deleted_Messages) {
                $msg_result['key']   = 'Success';
                $msg_result['value'] = 'تمت عملية الحذف بنجاح';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_SMS_Email/Setting_Email_Messages', 'refresh');
            } else {
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'خطا اثناء عملية الحذف يرجى المحاولة مره اخرى';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_SMS_Email/Setting_Email_Messages', 'refresh');
            }

        }
    }
    ###################################################################

}