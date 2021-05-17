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

    // Done
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

    // Done
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
    public function QuickActions()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = '   الشعار ';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/QuickActions', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
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



}