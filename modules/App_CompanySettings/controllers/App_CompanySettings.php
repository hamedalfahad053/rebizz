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
        $this->data['Page_Title']  = ' اعدادت النظام ';
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
        $Company_domain = Get_Company($this->data['UserLogin']['Company_User'])->companies_Domain;


        $Uploader_path = './uploads/companies/'.$Company_domain.'/'.FOLDER_FILE_Company_Logo;

        if (!is_dir($Uploader_path)) {
            mkdir($Uploader_path, 0755, TRUE);
        }

        $data_other = array();
        $data_other = [''];

        $config['upload_path']    = realpath($Uploader_path);
        $config['allowed_types']  = 'gif|jpg|png|jpg';
        $config['max_size']       = '1024';
        $config['max_filename']   = 30;
        $config['encrypt_name']   = true;
        $config['remove_spaces']  = true;

        $this->upload->initialize($config);

        $uploader = $this->upload->do_upload('logo_company');

        $upload_data   = $this->upload->data();

        if (count($data_other) > 0) {
            $upload_data = array_merge($data_other, $upload_data);
        }

        _array_p($upload_data);

    }
    ###################################################################

}