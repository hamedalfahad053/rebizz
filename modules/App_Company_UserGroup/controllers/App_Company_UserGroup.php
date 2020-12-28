<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_UserGroup extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' ادارة مجموعة المستخدمين ';
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $Group_Users = Get_Company_Group_Users($this->data['UserLogin']['Company_User']);

        foreach ($Group_Users->result() AS $ROW )
        {
            if($ROW->group_status == 1) {
                $group_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $group_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            if($ROW->group_main_system == 1){
                $group_main_system =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Basic_System')));
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

                if($ROW->group_status == 0) {
                    $options['active'] = array(
                        "title" => lang('active_button'),
                        "data-attribute" => '',
                        "href" => "#"
                    );
                }else {
                    $options['disable'] = array(
                        "title" => lang('disable_button'),
                        "data-attribute" => '',
                        "href" => "#"
                    );
                }

                $options['deleted'] = array(
                    "title" => lang('deleted_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );


                $group_main_system =  Create_Options_Button($options);

            } //  if($ROW->group_main_system == 1){

            $this->data['Group_Users'][]  = array(
                "Group_id"          => $ROW->group_id,
                "Group_Name"        => $ROW->name,
                "group_translation" => $ROW->item_translation,
                "Group_Num_Users"   => '',
                "Group_status"      => $group_status,
                "Group_main_system" => $group_main_system,
            );
        }


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Settings'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Page_Title']  = 'ادارة مجموعة المستخدمين ';
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_UserGroup/views/UserGroup', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Form_add_Group()
    {
        $this->data['options_status_group'] = array(
            "1" => lang('Status_Active'),
            "0" => lang('Status_Disabled')
        );

        $this->data['Page_Title']  = lang('add_new_group_button');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_UserGroup/views/Add_Group',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Group()
    {

    }
    ###################################################################



}