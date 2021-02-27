<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company_Clients extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Compnay_Clients_model');
        $this->data['controller_name'] = lang('Management_Clients');




    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $Get_All_Clients = $this->Compnay_Clients_model->Get_All_Clients();

        if ($Get_All_Clients->num_rows() > 0) {

            foreach ($Get_All_Clients->result() as $ROW) {

                if ($ROW->is_deleted == false) {
                    $Companies_status =  Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
                } else {
                    $Companies_status =  Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
                }

                $options = array();
                
                $options['view']        = array("class"=>"","id"=>"","title" => 'ملف العميل', "data-attribute" => '', "href" => base_url(APP_NAMESPACE_URL.'/Clients/Profile_Client/'.$ROW->client_id.''));
                $options['edit']        = array("class"=>"","id"=>"","title" => lang('edit_button'), "data-attribute" => '', "href" => "#");
                $options['deleted']     = array("class"=>"","id"=>"","title" => lang('deleted_button'), "data-attribute" => '', "href" => "#");

                if ($ROW->is_active == true) {
                    $options['active'] = array("class"=>"","id"=>"","title" => lang('active_button'), "data-attribute" => '', "href" => "#");
                } else {
                    $options['disable'] = array("class"=>"","id"=>"","title" => lang('disable_button'), "data-attribute" => '', "href" => "#");
                }


                $Clients_options =  Create_Options_Button($options);

                $type_Client = Get_options_List_Translation($ROW->type_id);

                if($ROW->logo == ''){
                    $logo = LOGO_DEFAULT_CLIENT;
                }else{
                    $logo = $this->data['LoginUser_Company_Path_Folder'].'/'.FOLDER_FILE_Company_client_logo.'/'.$ROW->logo;
                }


                $this->data['ClientList'][]  = array(
                    "Client_id"           => $ROW->client_id,
                    "Client_logo"         => $logo,
                    "Client_name"         => $ROW->name,
                    "type_id"             => $type_Client->item_translation,
                    "company_id"          => $ROW->company_id,
                    "is_active"           => $ROW->is_active,
                    "options"             => $Clients_options,
                    "status"              => $Companies_status
                );

            } // foreach ($Get_All_Clients->result() as $ROW)
        }
        else{
            $this->data['ClientList'] = false;
        }

        $this->data['List_status'] = array_options_status();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET . 'plugins/custom/datatables/datatables.bundle', $this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET . 'plugins/custom/datatables/datatables.bundle', '');
        $this->data['Page_Title']    = lang('Management_Clients');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Clients/views/Client_List', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_New_Client()
    {

        $this->data['List_status']   = array_options_status();
        $this->data['Page_Title']    = lang('Management_Clients');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Clients/views/Create_New_Client', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################



    ###################################################################
    public function Create_Client()
    {
        $this->form_validation->set_rules('name',lang('client_name'),'required');
        $this->form_validation->set_rules('LIST_CUSTOMER_CATEGORY',lang('client_type'),'required');
        $this->form_validation->set_rules('is_active',lang('Status_add_System'),'required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Clients', 'refresh');

        }else{

            $data_client['name']          = $this->input->post('name',true);
            $data_client['type_id']       = $this->input->post('LIST_CUSTOMER_CATEGORY',true);
            $data_client['email']         = $this->input->post('email',true);
            $data_client['phone']         = $this->input->post('Phone',true);
            $data_client['company_id']    = $this->data['LoginUser_Company'];
            $data_client['is_active']     = $this->input->post('is_active',true);
            $data_client['created_By']    = $this->aauth->get_user()->id;
            $data_client['created_date']  = time();


                $Uploader_path = './uploads/companies/' . $this->data['LoginUser_Company_domain']. '/' . FOLDER_FILE_Company_client_logo;
                if (!is_dir($Uploader_path)) {
                    mkdir($Uploader_path, 0755, TRUE);
                }

                $config['upload_path']   = realpath($Uploader_path);
                $config['allowed_types'] = 'png';
                $config['max_size']      = '500';
                $config['max_filename']  = 30;
                $config['encrypt_name']  = true;
                $config['remove_spaces'] = true;
                $this->upload->initialize($config);
                if($this->upload->do_upload('logo_client'))
                {
                    $upload_data = $this->upload->data();
                    $data_client['logo']  = $upload_data['file_name'];
                }

                $Create_Client  = $this->Compnay_Clients_model->Create_Client($data_client);

                if($Create_Client){
                    $msg_result['key']   = 'Success';
                    $msg_result['value'] = lang('message_success_insert');
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL.'/Clients' , 'refresh');

                }else{
                    $msg_result['key']   = 'Danger';
                    $msg_result['value'] = lang('message_error_insert');
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL.'/Clients' , 'refresh');
                } // if($Create_Client)

        } //  if($this->form_validation->run()==FALSE){
    }
    ###################################################################




    ###################################################################
    public function Profile_Client()
    {
        $this->data['Page_Title']  = 'ادارة ملف العميل';

        $Client_id =  $this->uri->segment(4);

        $this->data['Client_Info']     = App_Get_Client_Company_By_id($this->data['LoginUser_Company'],$Client_id)->row();


        if($this->data['Client_Info']->is_active == 1) {
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
        }else{
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
        }

        $this->data['options_status']  = array_options_status_system();
        $this->data['List_auto_renew'] = array_options_status();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Clients'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET . 'plugins/custom/datatables/datatables.bundle', $this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET . 'plugins/custom/datatables/datatables.bundle', '');

        $this->data['Clients_Company_Page'] = $this->load->view('../../modules/App_Company_Clients/views/Client_Dashboard', $this->data, true);
        $this->data['PageContent']          = $this->load->view('../../modules/App_Company_Clients/views/Client_Profile', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function Information()
    {
        $Client_id =  $this->uri->segment(4);
        $this->data['Client_Info']     = App_Get_Client_Company_By_id($this->data['UserLogin']['Company_User'],$Client_id)->row();
        if($this->data['Client_Info']->is_active == 1) {
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
        }else{
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
        }

        $this->data['Page_Title']  = 'معلومات العميل';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Clients'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Clients_Company_Page'] = $this->load->view('../../modules/App_Company_Clients/views/Client_Info_Account', $this->data, true);
        $this->data['PageContent']          = $this->load->view('../../modules/App_Company_Clients/views/Client_Profile', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Contracts()
    {
        $Client_id =  $this->uri->segment(4);

        $this->data['Client_Info']     = App_Get_Client_Company_By_id($this->data['UserLogin']['Company_User'],$Client_id)->row();

        if($this->data['Client_Info']->is_active == 1) {
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
        }else{
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
        }

        $Contracts_Client =  App_Client_Contract_Company($this->data['UserLogin']['Company_User'],$Client_id);


        if ($Contracts_Client->num_rows() > 0) {

            foreach ($Contracts_Client->result() as $ROW) {

                if ($ROW->Contracts_isDeleted == false) {
                    $Contracts_status =  Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
                } else {
                    $Contracts_status =  Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
                }

                $options = array();

                $options['view']        = array("class"=>"","id"=>"","title" => ' تفاصيل العقد ', "data-attribute" => '', "href" => base_url(APP_NAMESPACE_URL.'/Clients/Contracts_View/'.$ROW->Clients_id.'/'.$ROW->contract_id));
                $options['edit']        = array("class"=>"","id"=>"","title" => lang('edit_button'), "data-attribute" => '', "href" => "#");
                $options['deleted']     = array("class"=>"","id"=>"","title" => lang('deleted_button'), "data-attribute" => '', "href" => "#");


                if ($ROW->is_auto_renew == 1) {
                    $is_auto_renew =  Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
                } else {
                    $is_auto_renew =  Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
                }

                $Contracts_options =  Create_Options_Button($options);

                $this->data['Contracts_Client'][]  = array(
                    "contract_id"            => $ROW->contract_id,
                    "Clients_id"             => $ROW->Clients_id,
                    "Contracts_name"         => $ROW->Contracts_name,
                    "Contracts_start_date"   => $ROW->Contracts_start_date,
                    "Contracts_end_date"     => $ROW->Contracts_end_date,
                    "is_auto_renew"          => $is_auto_renew,
                    "Contracts_status"       => $Contracts_status,
                    "Contracts_options"      => $Contracts_options
                );

            } // foreach ($Get_All_Clients->result() as $ROW)
        }
        else{
            $this->data['Contracts_Client'] = false;
        }


        $this->data['Page_Title']  = ' ادارة العقود';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Clients'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Clients_Company_Page'] = $this->load->view('../../modules/App_Company_Clients/views/Client_Contract', $this->data, true);
        $this->data['PageContent']          = $this->load->view('../../modules/App_Company_Clients/views/Client_Profile', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_add_Contracts()
    {
        $Client_id =  $this->uri->segment(4);

        $this->data['Client_Info']     = App_Get_Client_Company_By_id($this->data['UserLogin']['Company_User'],$Client_id)->row();

        if($this->data['Client_Info']->is_active == 1) {
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
        }else{
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
        }

        $this->data['Contracts_is_auto_renew'] = array_options_status();

        $this->data['Page_Title']  = ' اضافة عقد جديد ';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Clients'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Clients_Company_Page'] = $this->load->view('../../modules/App_Company_Clients/views/Form_add_Contracts', $this->data, true);
        $this->data['PageContent']          = $this->load->view('../../modules/App_Company_Clients/views/Client_Profile', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_Contracts()
    {


        $this->form_validation->set_rules('Clients_id','Clients_id','required');
        $this->form_validation->set_rules('Contracts_name','Contracts_name','required');
        $this->form_validation->set_rules('Contracts_description','Contracts_description','required');
        $this->form_validation->set_rules('Contracts_start_date','Contracts_start_date','required');
        $this->form_validation->set_rules('Contracts_end_date','Contracts_end_date','required');
        $this->form_validation->set_rules('Code_Transaction','Code_Transaction','required');
        $this->form_validation->set_rules('is_auto_renew','is_auto_renew','required');

        $Clients_id                =  $this->input->post('Clients_id');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Clients/Form_add_Contracts/'.$Clients_id.'', 'refresh');

        }else{

            $data_Contracts['Company_id']                =  $this->data['UserLogin']['Company_User'];
            $data_Contracts['Clients_id']                =  $this->input->post('Clients_id');
            $data_Contracts['Contracts_name']            =  $this->input->post('Contracts_name');
            $data_Contracts['Contracts_description']     =  $this->input->post('Contracts_description');
            $data_Contracts['Contracts_start_date']      =  strtotime($this->input->post('Contracts_start_date'));
            $data_Contracts['Contracts_end_date']        =  strtotime($this->input->post('Contracts_end_date'));
            $data_Contracts['Code_Transaction']          =  $this->input->post('Code_Transaction');
            $data_Contracts['is_auto_renew']             =  $this->input->post('is_auto_renew');

            $data_Contracts['Contracts_createBy']         =  0;
            $data_Contracts['Contracts_createDate']       =  time();
            $data_Contracts['Contracts_lastModifyDate']   =  time();
            $data_Contracts['Contracts_isDeleted']        =  0;
            $data_Contracts['Contracts_DeletedBy']        =  0;



            $Create_Contracts = $this->Compnay_Clients_model->Create_Contracts($data_Contracts);

            if($Create_Contracts){


                /* Uploaded File */
                $Company_domain = Get_Company($this->data['UserLogin']['Company_User'])->companies_Domain;
                $Uploader_path  = './uploads/companies/'.$Company_domain.'/'.FOLDER_FILE_CONTRACT_COMPANY;

                if (!is_dir($Uploader_path)) {
                    mkdir($Uploader_path, 0755, TRUE);
                }

                $data_other_uploaded = array();
                $data_other_uploaded['file_type_item']        =  'Contracts';
                $data_other_uploaded['file_item_id']          =  $Create_Contracts;
                $data_other_uploaded['company_id']            =  $Company_domain;
                $data_other_uploaded['file_createBy']         =  0;
                $data_other_uploaded['file_createDate']       =  time();
                $data_other_uploaded['file_lastModifyDate']   =  time();
                $data_other_uploaded['file_isDeleted']        =  0;
                $data_other_uploaded['file_DeletedBy']        =  0;

                $config['upload_path']                        = realpath($Uploader_path);
                $config['allowed_types']                      = 'gif|jpg|png|jpg|pdf';
                $config['max_size']                           = '1024';
                $config['max_filename']                       = 30;
                $config['encrypt_name']                       = true;
                $config['remove_spaces']                      = true;

                $this->upload->initialize($config);

                $uploader       = $this->upload->do_upload('contract_file');
                $upload_data    = $this->upload->data();

                if (count($data_other_uploaded) > 0) {
                    $upload_data = array_merge($data_other_uploaded, $upload_data);
                }

                Uploader_Insert_Data($upload_data);
                /* Uploaded File */


                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Clients/Contracts/'.$Clients_id.'', 'refresh');

            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Clients/Contracts/'.$Clients_id.'', 'refresh');
            }



        } // if($this->form_validation->run()==FALSE)


    }
    ###################################################################

    ###################################################################
    public function Contracts_View()
    {
        $Client_id    =  $this->uri->segment(4);
        $Contracts_id =  $this->uri->segment(5);

        $this->data['Client_Info']     = App_Get_Client_Company_By_id($this->data['LoginUser_Company'],$Client_id)->row();

        if($this->data['Client_Info']->is_active == 1) {
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
        }else{
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
        }


        $this->data['Client_Contract'] = GET_Client_Contract_Company($this->data['LoginUser_Company'],$Client_id,$Contracts_id)->row();
        $this->data['Page_Title']      = ' استعراض معلومات العقد ';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Clients'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Clients_Company_Page'] = $this->load->view('../../modules/App_Company_Clients/views/View_Contracts', $this->data, true);
        $this->data['PageContent']          = $this->load->view('../../modules/App_Company_Clients/views/Client_Profile', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Properties()
    {
        $Client_id =  $this->uri->segment(4);

        $this->data['Client_Info']     = App_Get_Client_Company_By_id($this->data['UserLogin']['Company_User'],$Client_id)->row();

        if($this->data['Client_Info']->is_active == 1) {
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
        }else{
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
        }

        $this->data['Page_Title']  = ' الممتلكات';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Clients'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Clients_Company_Page'] = $this->load->view('../../modules/App_Company_Clients/views/Client_Properties', $this->data, true);
        $this->data['PageContent']          = $this->load->view('../../modules/App_Company_Clients/views/Client_Profile', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function Transactions()
    {
        $Client_id =  $this->uri->segment(4);
        $this->data['Client_Info']     = App_Get_Client_Company_By_id($this->data['UserLogin']['Company_User'],$Client_id)->row();

        if($this->data['Client_Info']->is_active == 1) {
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
        }else{
            $this->data['Client_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
        }

        $this->data['Page_Title']  = ' المعاملات';


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Clients'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Clients_Company_Page'] = $this->load->view('../../modules/App_Company_Clients/views/Client_Transactions', $this->data, true);
        $this->data['PageContent']          = $this->load->view('../../modules/App_Company_Clients/views/Client_Profile', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################




}
