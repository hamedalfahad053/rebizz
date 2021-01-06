<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

        $Get_All_Companies = $this->Compnay_Clients_model->Get_All_Clients();

        if($Get_All_Companies->num_rows()>0){
            foreach ($Get_All_Companies->result() AS $ROW )
            {

                if($ROW->is_deleted == false) {
                    $Companies_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
                }else{
                    $Companies_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
                }

                $options = array();
                $options['view']    = array("title" => lang('view_button'), "data-attribute" => '', "href" => base_url(ADMIN_NAMESPACE_URL.'/Cleints/Company_Profile/'.$ROW->company_id.''));
                $options['edit']    = array("title" => lang('edit_button'), "data-attribute" => '', "href" => "#");
                $options['deleted'] = array("title" => lang('deleted_button'), "data-attribute" => '', "href" => "#");

                if($ROW->is_active == true) {
                    $options['active'] = array("title" => lang('active_button'), "data-attribute" => '', "href" => "#");
                }else {
                    $options['disable'] = array("title" => lang('disable_button'), "data-attribute" => '', "href" => "#");
                }

                $Clients_options =  Create_Options_Button($options);

                $this->data['clients'][]  = array(

                    "Client_id"           => $ROW->id,
                    "Client_name"         =>  $ROW->name,    //Get_options_Data($ROW->LIST_BUSINESS_CATEGORIES)->item_translation,
                    "type_id"             => $ROW->type_id,
                    "company_id"          => $ROW->company_id,
                    "is_active"           => $ROW->is_active,
                    "options"             => $Clients_options,
                    "status"              => $Companies_status

                );

            } // foreach ($Get_All_Companies->result() AS $ROW )

        }else{
            $this->data['clients'] = false;
        }

        $this->data['List_status'] = array(
            "1" => lang('Status_Active'),
            "0" => lang('Status_Disabled')
        );

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page_Title']  = lang('Management_Clients');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        //$this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Clients'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Clients/views/Client_List',$this->data,true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Form_Add_Contract()
    {
        $this->data['Page_Title']  = lang('Management_Add_companies_offices');


        $this->data['options_status'] = array(
            "0" => lang('Multiple_System'),
            "1" => lang('Basic_System')
        );

        $this->data['List_auto_renew'] = array(
            "1" => lang('Status_Active'),
            "0" => lang('Status_Disabled')
        );

        $this->data['Page_Title']  = lang('add_new_Client_title');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Clients'));
         $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Clients/views/Form_add_Contract',$this->data,true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_Client()
    {

    }
    ###################################################################



}
