<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_CompanySettings extends Apps
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

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = 'الاعدادات العامة ';
        $this->data['Page_Company'] = '';
        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function information()
    {

        $Get_Company = Get_Company($this->aauth->get_user()->company_id);

        $this->data['Company_Profile'] = $Get_Company;

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = ' معلومات المنشأة ';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/company_information', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Update_information()
    {

        $this->form_validation->set_rules('companies_Trade_Name',lang('companies_Trade_Name'),'required');
        $this->form_validation->set_rules('companies_Commercial_Registration_No',lang('companies_Commercial_Registration_No'),'required');
        $this->form_validation->set_rules('companies_Unified_record_number',lang('companies_Unified_record_number'),'required');
        $this->form_validation->set_rules('Registration_Date',lang('Global_Registration_Date'),'required');
        $this->form_validation->set_rules('Expiry_Date',lang('Global_Expiry_Date'),'required');
        $this->form_validation->set_rules('companies_commercial_activities',lang('companies_commercial_activities'),'required');

        $this->form_validation->set_rules('companies_owner_name',lang('companies_owner_name'),'required');
        $this->form_validation->set_rules('owner_Nationality_id',lang('Global_Nationality'),'required');
        $this->form_validation->set_rules('owner_Identification_Number',lang('Global_Identification_Number'),'required');
        $this->form_validation->set_rules('owner_Identification_Issued_Date',lang('Global_Issued_Date'),'required');
        $this->form_validation->set_rules('owner_Identification_Expiry_Date',lang('Global_Expiry_Date'),'required');
        $this->form_validation->set_rules('owner_Identification_Issued_by',lang('Global_Issued_by'),'required');
        $this->form_validation->set_rules('owner_Mobile',lang('Global_Mobile'),'required');
        $this->form_validation->set_rules('owner_telephone',lang('Global_telephone'),'required');
        $this->form_validation->set_rules('owner_address',lang('Global_address'),'required');

        $this->form_validation->set_rules('companies_telephone',lang('Global_telephone'),'required');
        $this->form_validation->set_rules('companies_Mobile',lang('Global_Mobile'),'required');
        $this->form_validation->set_rules('companies_email',lang('Global_email'),'required');
        $this->form_validation->set_rules('companies_postbox',lang('Global_postbox'),'required');
        $this->form_validation->set_rules('companies_Postal_code',lang('Global_Postal_code'),'required');

        $this->form_validation->set_rules('companies_Region_id',lang('Global_Region_province'),'required');
        $this->form_validation->set_rules('companies_City_id',lang('Global_City'),'required');
        $this->form_validation->set_rules('companies_District_id',lang('Global_District'),'required');
        $this->form_validation->set_rules('companies_street',lang('Global_street'),'required');
        $this->form_validation->set_rules('companies_building_number',lang('Global_building_number'),'required');
        $this->form_validation->set_rules('companies_address_details',lang('Global_details'),'required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Settings/information', 'refresh');

        }else{


            $data_companies['companies_Trade_Name']                 = $this->input->post('companies_Trade_Name');
            $data_companies['companies_Commercial_Registration_No'] = $this->input->post('companies_Commercial_Registration_No');
            $data_companies['companies_Unified_record_number']      = $this->input->post('companies_Unified_record_number');
            $data_companies['Registration_Date']                    = strtotime($this->input->post('Registration_Date'));
            $data_companies['Expiry_Date']                          = strtotime($this->input->post('Expiry_Date'));
            $data_companies['companies_commercial_activities']      = $this->input->post('companies_commercial_activities');
            $data_companies['companies_owner_name']                 = $this->input->post('companies_owner_name');

            $data_companies['owner_Nationality_id']                 = $this->input->post('owner_Nationality_id');
            $data_companies['owner_Identification_Number']          = $this->input->post('owner_Identification_Number');
            $data_companies['owner_Identification_Issued_Date']     = strtotime($this->input->post('owner_Identification_Issued_Date'));
            $data_companies['owner_Identification_Expiry_Date']     = strtotime($this->input->post('owner_Identification_Expiry_Date'));
            $data_companies['owner_Identification_Issued_by']       = $this->input->post('owner_Identification_Issued_by');
            $data_companies['owner_Mobile']                         = $this->input->post('owner_Mobile');
            $data_companies['owner_telephone']                      = $this->input->post('owner_telephone');
            $data_companies['owner_address']                        = $this->input->post('owner_address');

            $data_companies['companies_telephone']                  = $this->input->post('companies_telephone');
            $data_companies['companies_Mobile']                     = $this->input->post('companies_Mobile');
            $data_companies['companies_email']                      = $this->input->post('companies_email');
            $data_companies['companies_website']                    = $this->input->post('companies_website');
            $data_companies['companies_postbox']                    = $this->input->post('companies_postbox');
            $data_companies['companies_Postal_code']                = $this->input->post('companies_Postal_code');
            $data_companies['companies_Country_id']                 = $this->input->post('companies_Country_id');
            $data_companies['companies_Region_id']                  = $this->input->post('companies_Region_id');
            $data_companies['companies_City_id']                    = $this->input->post('companies_City_id');
            $data_companies['companies_District_id']                = $this->input->post('companies_District_id');
            $data_companies['companies_street']                     = $this->input->post('companies_street');
            $data_companies['companies_building_number']            = $this->input->post('companies_building_number');
            $data_companies['companies_address_details']            = $this->input->post('companies_address_details');
            $data_companies['companies_Location_on_Google']         = $this->input->post('companies_Location_on_Google');

            $Update_companies      = $this->db->where('company_id',$this->aauth->get_user()->company_id);
            $Update_companies      = $this->db->update('portal_company',$data_companies);

            if($Update_companies){
                $msg_result['key']   = 'Success';
                $msg_result['value'] = 'تم تحديث معلومات المنشأة بنجاح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Settings/' , 'refresh');
            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'حصل خطا اثناء التحديث يرجى المحاولة مره اخرى';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Settings/', 'refresh');
            }


        } // if($this->form_validation->run()==FALSE)


    }
    ###################################################################

    ###################################################################
    public function Logo()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = '   الشعار ';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Logo', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Update_Logo()
    {

        $Uploader_path = './uploads/companies/' . $this->data['LoginUser_Company_domain'] . '/' . FOLDER_FILE_Company_Logo;

        if (!is_dir($Uploader_path)) {
            mkdir($Uploader_path, 0755, TRUE);
        }

        $config['upload_path']    = realpath($Uploader_path);
        $config['allowed_types']  = 'gif|jpg|png|jpg';
        $config['max_size']       = '1024';
        $config['max_filename']   = 30;
        $config['encrypt_name']   = true;
        $config['remove_spaces']  = true;

        $this->upload->initialize($config);

        $uploader = $this->upload->do_upload('logo_company');

        if($uploader){

            $upload_data = $this->upload->data();

            $update      = $this->db->where('company_id',$this->aauth->get_user()->company_id);
            $update      = $this->db->set('Company_Logo', $upload_data['file_name']);
            $update      = $this->db->update('portal_company');

            if($update){
                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings/Logo', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = validation_errors();
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings/Logo', 'refresh');
            }

        }else{

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'خطا اثناء تحميل الملف';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Settings/Logo', 'refresh');

        }
    }
    ###################################################################

    ###################################################################
    public function Setting_Notifications()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'اعداد عرض بيانات الجداول';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_Notifications', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function Setting_Date_Time()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'اعداد عرض بيانات الجداول';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_Date_Time', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function SettingEmailServer()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'اعداد عرض بيانات الجداول';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_Email_Server', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function Setting_Table_Data()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'اعداد عرض بيانات الجداول';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_Table_Data', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Update_Setting_Table_Data()
    {

    }
    ###################################################################


    ###################################################################
    public function stages_transaction()
    {

        $stages = query_All_options_List('29');

        foreach ($stages->result() as $R) {
            $this->data['stages'][] = array(
                "stages_id" => $R->list_options_id,
                "stages_title" => $R->item_translation,
                "stages_key" => $R->options_key,
            );
        }

        $Get_Departments = Get_Departments(array("company_id" => $this->aauth->get_user()->company_id, "departments_isDeleted" => 0));
        if ($Get_Departments->num_rows() > 0) {
            foreach ($Get_Departments->result() as $ROW) {
                $this->data['Departments'][] = array(
                    "departments_id" => $ROW->departments_id,
                    "departments_title" => $ROW->item_translation,
                );
            }
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = ' اعداد سير المعاملة ';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_Stages_Transaction', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function Update_Stages()
    {

        $Departments_To = $this->input->post('Departments_To');
        $attribution_method = $this->input->post('attribution_method');
        $stages_key = $this->input->post('stages_key');

        $countarray = count($this->input->post('stages_key'));

        for ($i = 0; $i < $countarray; $i++) {
            $company_id = $this->aauth->get_user()->company_id;
            $Clear_Stages = clear_Stages_Transaction($company_id, $stages_key[$i]);
            $insert_Stages = insert_Stages_Transaction($company_id, $stages_key[$i], $Departments_To[$i], $attribution_method[$i]);
        }

        if ($insert_Stages) {
            $msg_result['key'] = 'Success';
            $msg_result['value'] = lang('message_success_insert');
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Settings/stages_transaction', 'refresh');
        } else {
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = lang('message_error_insert');
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Settings/stages_transaction', 'refresh');
        }


    }
    ###################################################################

    ###################################################################
    public function Setting_Users_Preview()
    {

        $lang = get_current_lang();

        $this->db->select('users.id as users_id , users.full_name as full_name', false);

        $query = app()->db->from('portal_auth_users                 users');
        $query = app()->db->join('portal_auth_user_to_group         user_to_group', 'user_to_group.user_id = users.id');
        $query = app()->db->join('portal_auth_groups                groups_users', 'groups_users.group_id = user_to_group.group_id');
        $query = app()->db->join('portal_auth_groups_translation    Groups_Translation', 'groups_users.group_id = Groups_Translation.item_id');
        $query = app()->db->join('portal_auth_permissions_to_group  Groups_Permissions', 'Groups_Permissions.group_id = groups_users.group_id', 'left');
        $query = app()->db->join('portal_auth_permissions_to_user   Users_Permissions', 'Users_Permissions.user_id = users.id', 'left');
        $query = app()->db->where('users.company_id', $this->aauth->get_user()->company_id);
        $query = app()->db->where('( Groups_Permissions.perm_id = 11 OR Users_Permissions.perm_id = 11 )');
        $query = app()->db->where('Groups_Translation.translation_lang', $lang);
        $query = app()->db->get();

        if ($query->num_rows() > 0) {
            $this->data['Users_Preview'] = $query->result();
        } else {
            $this->data['Users_Preview'] = false;
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'توزيع المعاينين على المناطق الجغرافية';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_Users_Preview_Map', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_Set_CRD_Users_Preview()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'توزيع المعاينين على المناطق الجغرافية';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Form_Set_CRD_Users_Preview', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Update_Set_CRD_Users_Preview()
    {
        $this->form_validation->set_rules('Users_Preview', 'المعاين', 'required');
        $this->form_validation->set_rules('Region_id', lang('Global_Region_province'), 'required');
        $this->form_validation->set_rules('City_id', lang('Global_City'), 'required');

        if ($this->form_validation->run() == FALSE) {

            $msg_result['key'] = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ِAPP_NAMESPACE_URL . '/Settings/Setting_Users_Preview', 'refresh');

        } else {

            $Users_Preview = $this->input->post('Users_Preview');
            $Region_id     = $this->input->post('Region_id');
            $City_id       = $this->input->post('City_id');

            if (is_array($this->input->post('District_id'))) {
                $districts = @implode(',', $this->input->post('District_id'));
            } else {
                $districts = $this->input->post('District_id');
            }

            $Update_Assignment_Map = Update_Assignment_Map_users_preview($Users_Preview,$Region_id,$City_id,$districts);

            if($Update_Assignment_Map){
                $msg_result['key']   = 'Success';
                $msg_result['value'] = 'تم تحديث المنطقة الجغرافية للمعاين';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings/Setting_Users_Preview', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'حصل خطا اثناء التحديث';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings/Setting_Users_Preview', 'refresh');
            }

        } // if ($this->form_validation->run() == FALSE)

    }
    ###################################################################


    ###################################################################
    public function Setting_SMS_Messages()
    {

        $where_extra_ = array(
            "company_id" => $this->aauth->get_user()->company_id,
            "isDeleted"  => 0
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

        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_SMS_Messages', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_SMS_Email_Messages()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'اضافة رسالة جديدة';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_SMS_Messages_Form_Add', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_SMS_Email_Messages()
    {
        $this->form_validation->set_rules('messages_type','نوع الرسالة','required');
        $this->form_validation->set_rules('messages_text','نص الرسالة ','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Settings/Form_SMS_Email_Messages', 'refresh');

        } else {

            $data_Messages['messages_title']  = $this->input->post('messages_title');
            $data_Messages['messages_type']  = $this->input->post('messages_type');
            $data_Messages['messages_text']  = $this->input->post('messages_text');
            $data_Messages['company_id']     = $this->aauth->get_user()->company_id;
            $data_Messages['createBy']       = $this->aauth->get_user()->id;
            $data_Messages['createDate']     = time();
            $data_Messages['lastModifyDate'] = 0;
            $data_Messages['isDeleted']      = 0;
            $data_Messages['DeletedBy']      = 0;

            $Create_Sms_Email_Messages = Create_Sms_Email_Messages($data_Messages);

            if ($Create_Sms_Email_Messages) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings/Setting_SMS_Messages', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings/Setting_SMS_Messages', 'refresh');
            }

        }
    }
    ###################################################################

}