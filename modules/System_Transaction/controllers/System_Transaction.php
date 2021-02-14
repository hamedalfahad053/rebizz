<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Transaction extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaction_model');
        $this->data['controller_name'] = 'اعداد المعاملات';
    }
    ###################################################################

    ###################################################################
    public function index()
    {

    }
    ###################################################################

    ###################################################################
    public function Stages_Transaction()
    {
        $get_all_group_user  = $this->Users_Group_Model->Get_Groups();

        foreach ($get_all_group_user->result() AS $ROW )
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
                   "class"=>"","id"=>"",
                   "title" => lang('view_button'),
                   "data-attribute" => '',
                   "href" => "#"
               );

               $options['edit'] = array(
                   "class"=>"","id"=>"",
                   "title" => lang('edit_button'),
                   "data-attribute" => '',
                   "href" => "#"
               );

               if($ROW->group_status == 0) {
                   $options['active'] = array(
                       "class"=>"","id"=>"",
                       "title" => lang('active_button'),
                       "data-attribute" => '',
                       "href" => "#"
                   );
               }else {
                   $options['disable'] = array(
                       "class"=>"","id"=>"",
                       "title" => lang('disable_button'),
                       "data-attribute" => '',
                       "href" => "#"
                   );
               }

               $options['deleted'] = array(
                   "class"=>"","id"=>"",
                   "title" => lang('deleted_button'),
                   "data-attribute" => '',
                   "href" => "#"
               );


               $group_main_system =  Create_Options_Button($options);

           } //  if($ROW->group_main_system == 1){

           if($ROW->group_owner == 0){
              $Group_owner = 'النظام';
           } else{
               $Group_owner = Get_Company($ROW->group_owner)->companies_Trade_Name;
           }

           $this->data['Group_Users'][]  = array(
               "Group_id"          => $ROW->group_id,
               "Group_Name"        => $ROW->name,
               "group_translation" => $ROW->item_translation,
               "Group_owner"       => $Group_owner,
               "Group_Num_Users"   => '',
               "Group_status"      => $group_status,
               "Group_main_system" => $group_main_system,
           );

            $group_status      = '';
            $options           = '';
            $group_main_system = '';
            $Group_Num_Users   = '';

        } // foreach ($get_all_group_user->result() AS $ROW )

        $this->data['Page_Title']  = lang('List_group_user');

        $this->mybreadcrumb->add(lang('Dashboard'), '');
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_GroupUsers/views/List',$this->data,true);

        //_array_p($get_all_group_user);
        Layout_Admin($this->data);
    }
    ###################################################################


    ###################################################################
    public function Form_add_Group()
    {

        $Get_All_Company_Active = $this->Companies_model->Get_All_Companies();

        foreach ($Get_All_Company_Active->result() AS $RU)
        {
            $this->data['company'][]  = array(
                "company_id"     => $RU->company_id,
                "companies_Name" => $RU->companies_Trade_Name,
            );
        }

        $this->data['options_status_group']  = array_options_status();
        $this->data['options_status_system'] = array_options_status_system();

        $this->data['Page_Title']  = lang('add_new_group_button');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/System_GroupUsers/views/Add_Group',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Group()
    {

        $this->form_validation->set_rules('name_group_ar',lang('name_group_ar'),'required');
        $this->form_validation->set_rules('name_group_en',lang('name_group_en'),'required');
        $this->form_validation->set_rules('owner_group',lang('owner_group'),'required');
        $this->form_validation->set_rules('Status_group',lang('Status_group'),'required');
        $this->form_validation->set_rules('group_main_system',lang('group_main_system'),'required');


        if($this->form_validation->run()==FALSE){
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/Group_Users', 'refresh');
        }else{

            $data_group['name']          = $this->input->post('name_group_en');
            $data_group['definition']    = $this->input->post('name_group_ar');
            $data_group['group_owner']   = $this->input->post('owner_group');
            $data_group['group_status']  = $this->input->post('Status_group');
            $data_group['group_main_system'] = $this->input->post('group_main_system');


            $Create_Group  = $this->Users_Group_Model->Create_Group($data_group);

            if($Create_Group){

                $item_ar = $this->input->post('name_group_ar');
                $item_en = $this->input->post('name_group_en');
                insert_translation_Language_item('portal_auth_groups_translation',$Create_Group,$item_ar,$item_en);

                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL.'/Group_Users' , 'refresh');

            }else{

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL.'/Group_Users', 'refresh');

            }

        } // if($this->form_validation->run()==FALSE)

    }
    ###################################################################






}