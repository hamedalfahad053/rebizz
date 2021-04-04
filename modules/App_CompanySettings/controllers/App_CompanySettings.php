<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_CompanySettings extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' اعدادت النظام ';


        //require_once '';
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = '   ';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/company_information', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function information()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = ' اعدادت النظام ';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/company_information', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
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

        $Uploader_path = './uploads/companies/' . $LoginUser_Company_domain . '/' . FOLDER_FILE_Company_Logo;

        if (!is_dir($Uploader_path)) {
            mkdir($Uploader_path, 0755, TRUE);
        }
        $config['upload_path'] = realpath($Uploader_path);
        $config['allowed_types'] = 'gif|jpg|png|jpg';
        $config['max_size'] = '1024';
        $config['max_filename'] = 30;
        $config['encrypt_name'] = true;
        $config['remove_spaces'] = true;

        $this->upload->initialize($config);

        $uploader = $this->upload->do_upload('logo_company');

        $upload_data = $this->upload->data();

//        if (count($data_other) > 0) {
//            $upload_data = array_merge($data_other, $upload_data);
//        }
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

}