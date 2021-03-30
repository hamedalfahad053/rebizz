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

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Settings'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title']  = '   ';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/company_information', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function information()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Settings'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title']  = ' اعدادت النظام ';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/company_information', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Logo()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title']  = '   الشعار ';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Logo', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Update_Logo()
    {

        $Uploader_path = './uploads/companies/'.$LoginUser_Company_domain.'/'.FOLDER_FILE_Company_Logo;

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

        $upload_data   = $this->upload->data();

//        if (count($data_other) > 0) {
//            $upload_data = array_merge($data_other, $upload_data);
//        }
    }
    ###################################################################

    ###################################################################
    public function Setting_Notifications()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = 'اعداد عرض بيانات الجداول';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_Notifications', $this->data, true);
        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Setting_Date_Time()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = 'اعداد عرض بيانات الجداول';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_Date_Time', $this->data, true);
        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################



    ###################################################################
    public function SettingEmailServer()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = 'اعداد عرض بيانات الجداول';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_Email_Server', $this->data, true);
        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function Setting_Table_Data()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = 'اعداد عرض بيانات الجداول';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_Table_Data', $this->data, true);
        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
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

        $stages =  query_All_options_List('29');

        foreach ($stages->result()  AS $R)
        {
            $this->data['stages'][] = array(
                "stages_id"     => $R->list_options_id,
                "stages_title"  => $R->item_translation,
                "stages_key"    => $R->options_key,
            );
        }

        $Get_Departments = Get_Departments(array("company_id"=>$this->aauth->get_user()->company_id,"departments_isDeleted"=>0));
        if($Get_Departments->num_rows()>0)
        {
            foreach ($Get_Departments->result() AS $ROW )
            {
                $this->data['Departments'][] = array(
                    "departments_id"      => $ROW->departments_id,
                    "departments_title"   => $ROW->item_translation,
                );
            }
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title']  = ' اعداد سير المعاملة ';
        $this->data['Page_Company'] = $this->load->view('../../modules/App_CompanySettings/views/Setting_Stages_Transaction', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/CompanySettings', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function Update_Stages()
    {

        $Departments_To          = $this->input->post('Departments_To');
        $attribution_method      = $this->input->post('attribution_method');
        $stages_key              = $this->input->post('stages_key');

        $countarray = count($this->input->post('stages_key'));

        for($i=0;$i<$countarray;$i++)
        {
            $company_id    = $this->aauth->get_user()->company_id;
            $Clear_Stages  = clear_Stages_Transaction($company_id, $stages_key[$i]);
            $insert_Stages = insert_Stages_Transaction($company_id,$stages_key[$i],$Departments_To[$i],$attribution_method[$i]);
        }

        if($insert_Stages){
            $msg_result['key']   = 'Success';
            $msg_result['value'] = lang('message_success_insert');
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Settings/stages_transaction' , 'refresh');
        }else{
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = lang('message_error_insert');
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Settings/stages_transaction', 'refresh');
        }


    }
    ###################################################################



}