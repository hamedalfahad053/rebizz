<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Language extends Admin {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Language_Model');
        $this->data['controller_name'] = lang('Manage_Language');

    }

    ###############################################################################################
    public function index()
    {

        $get_all_Language  = $this->Language_Model->Get_All_Language();

        foreach ($get_all_Language->result() AS $ROW )
        {

            if($ROW->languages_status == 1) {
                $languages_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $languages_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            if($ROW->languages_system == 1){
                $languages_main_system =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Basic_System')));
            }else{

                $options = array();

                $options['view'] = array(
                    "title" => lang('view_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );

                $options['edit'] = array(
                    "title" => lang('edit_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );

                $options['active'] = array(
                    "title" => lang('active_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );

                /*
                $options['deleted'] = array(
                    "title" => lang('deleted_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );
                */

                $languages_main_system =  Create_Options_Button($options);

            } //  if($ROW->languages_status == 1){

            $this->data['Language'][]  = array(
                "language_id"           => $ROW->language_id,
                "languages_comments"    => $ROW->languages_comments,
                "language_native"         => $ROW->language_native,
                "languages_status"      => $languages_status,
                "languages_system"      => $languages_main_system
            );

        } // foreach ($get_all_Language->result() AS $ROW )

        $this->data['Page_Title']  = lang('Manage_Language');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Language/views/List',$this->data,true);

        Layout_Admin($this->data);

    }
    ###############################################################################################


    ###############################################################################################
    public function Change_language(){

    }
    ###############################################################################################






}
