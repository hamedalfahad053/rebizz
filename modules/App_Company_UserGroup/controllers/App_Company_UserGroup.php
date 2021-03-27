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



        $where_extra_Group = array(
            "company_id" => app()->aauth->get_user()->company_id
        );
        $Group_Users = Get_Group($where_extra_Group);

         //$this->db->last_query();

        if($Group_Users->num_rows() >0){

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
                        "class"=>"","id"=>"", "title" => lang('view_button'), "data-attribute" => '',
                        "href" => "#"
                    );

                    $options['edit'] = array(
                        "class"=>"","id"=>"", "title" => lang('edit_button'), "data-attribute" => '',
                        "href" => "#"
                    );

                    if($ROW->group_status == 0) {
                        $options['active'] = array(
                            "class"=>"","id"=>"", "title" => lang('active_button'), "data-attribute" => '', "href" => "#"
                        );
                    }else {
                        $options['disable'] = array(
                            "class"=>"","id"=>"", "title" => lang('disable_button'), "data-attribute" => '',
                            "href" => "#"
                        );
                    }

                    $options['deleted'] = array(
                        "class"=>"","id"=>"", "title" => lang('deleted_button'), "data-attribute" => '',
                        "href" => "#"
                    );


                    $group_main_system =  Create_Options_Button($options);

                } //  if($ROW->group_main_system == 1){


                $Get_Company_Group_Users = Get_Company_Group_Users(app()->aauth->get_user()->company_id)->num_rows();

                $this->data['Group_Users'][]  = array(
                    "Group_id"          => $ROW->group_id,
                    "Group_Name"        => $ROW->name,
                    "group_translation" => $ROW->item_translation,
                    "Group_Num_Users"   => $Get_Company_Group_Users,
                    "Group_status"      => $group_status,
                    "Group_main_system" => $group_main_system,
                );
            }
        }else{
            $this->data['Group_Users'] = false;
        }



        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Settings'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Page_Title']  = 'ادارة مجموعة المستخدمين ';
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_UserGroup/views/UserGroup', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function add_Group()
    {

        $Controllers = array();

        $this->data['options_status_group'] = array(
            "1" => lang('Status_Active'),
            "0" => lang('Status_Disabled')
        );

        $Get_Controllers = Get_Controllers(3);


        foreach ($Get_Controllers->result() AS $Row_Controllers)
        {
            $Controllers[] = array(
                "Controllers_id"          => $Row_Controllers->controllers_id,
                "Controllers_title"       => $Row_Controllers->item_translation,
            );

        }

        $this->data['Controllers_Permissions'] = $Controllers;

        $this->data['Page_Title']  = lang('add_new_group_button');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_UserGroup/views/Add_Group',$this->data,true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Group()
    {

        $data_Permissions = array();

        $this->form_validation->set_rules('name_group_ar',lang('name_group_ar'),'required');
        $this->form_validation->set_rules('name_group_en',lang('name_group_en'),'required');

        if($this->form_validation->run()==FALSE){
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/User_Group', 'refresh');
        }else{

            $data_group['name']              = $this->input->post('name_group_en');
            $data_group['definition']        = $this->input->post('name_group_ar');
            $data_group['company_id']        = app()->aauth->get_user()->company_id;
            $data_group['group_status']      = $this->input->post('Status_group');
            $data_group['group_main_system'] = 0;


            $Create_Group  = Create_Group_By_Company($data_group);

            if($this->input->post('permissions'))
            {
               $permissions = $this->input->post('permissions');
               foreach ($permissions AS $value)
               {
                   $data_Permissions = array("group_id"=>$Create_Group,"perm_id"=>$value);
                   Add_Permissions_To_Group($data_Permissions);
               }
            } // if($this->input->post('permissions'))

            if($Create_Group){

                $item_ar = $this->input->post('name_group_ar');
                $item_en = $this->input->post('name_group_en');
                insert_translation_Language_item('portal_auth_groups_translation',$Create_Group,$item_ar,$item_en);

                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/User_Group' , 'refresh');

            }else{

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/User_Group', 'refresh');

            }

        } // if($this->form_validation->run()==FALSE)
    }
    ###################################################################



}