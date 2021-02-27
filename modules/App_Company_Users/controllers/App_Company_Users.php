<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_Users extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Company_Users_Model');
        $this->data['controller_name'] = 'ادارة المستخدمين';
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $Company_Users = Get_Company_Users($this->data['UserLogin']['Company_User'])->result();

        foreach ($Company_Users AS $Row)
        {
            if(get_current_lang() == 'arabic' ){
                $locations  = Get_Locations($Row->locations_id)->row()->Locations_ar;
                $full_name  = $Row->full_name_ar;
            }else{
                $full_name  = $Row->full_name;
                $locations  = Get_Locations($Row->locations_id)->row()->Locations_en;
            }

            if($Row->banned == 0) {
                $user_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $user_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            $options = array();

            $options['view']    = array("class"=>"","id"=>"","title" => lang('view_button'), "data-attribute" => '', "href" => "#");
            $options['edit']    = array("class"=>"","id"=>"","title" => lang('edit_button'), "data-attribute" => '', "href" => "#");
            $options['deleted'] = array("class"=>"","id"=>"","title" => lang('deleted_button'), "data-attribute" => '', "href" => "#");

            if($Row->banned == 1) {
                $options['active'] = array("class"=>"","id"=>"","title" => lang('active_button'), "data-attribute" => '', "href" => "#");
            }else {
                $options['disable'] = array("class"=>"","id"=>"","title" => lang('disable_button'), "data-attribute" => '', "href" => "#");
            }

            $user_options =  Create_Options_Button($options);

            $this->data['Company_Users'][] = array(
                "user_id"      => $Row->user_id,
                "locations"    => $locations,
                "email"        => $Row->email,
                "phone"        => $Row->phone,
                "full_name"    => $full_name,
                "date_created" => $Row->date_created,
                "user_status"  => $user_status,
                "group_user"   => $Row->item_translation,
                "user_options" => $user_options,
            );
        }


        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page_Title']  = 'ادارة المستخدمين';

        $this->mybreadcrumb->add(lang('Dashboard'), '');
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Users/views/List_Company_Users', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################


    ###################################################################
    public function Form_add_Users()
    {
        $Company_Group_Users = Get_Company_Group_Users($this->data['UserLogin']['Company_User']);
        $Company_Locations   = Get_Company_Locations($this->data['UserLogin']['Company_User']);


        foreach ($Company_Group_Users->result()  AS $R_Group_Users)
        {
            $this->data['Company_Group_Users'][] = array(
                "group_id"    => $R_Group_Users->group_id,
                "group_title" => $R_Group_Users->item_translation
            );
        }

        foreach ($Company_Locations->result()  AS $R_Locations)
        {
            if(get_current_lang()=='arabic'){
                $Locations_Name = $R_Locations->Locations_ar;
            }else{
                $Locations_Name = $R_Locations->Locations_en;
            }

            $this->data['Company_Locations_Users'][] = array(
                "locations_id"    => $R_Locations->company_locations_id,
                "locations_Name"  => $Locations_Name
            );

        }

        $this->data['user_status'] = array_options_status();
        $this->data['Page_Title']  = ' اضافة مستخدم  ';

        $this->mybreadcrumb->add(lang('Dashboard'), '');
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Users/views/Form_add_Users', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Users()
    {
        $this->form_validation->set_rules('full_name_ar','full_name_ar','required');
        $this->form_validation->set_rules('full_name','full_name','required');
        $this->form_validation->set_rules('email','email','required');
        $this->form_validation->set_rules('password','password','required');
        $this->form_validation->set_rules('confirm_password','confirm_password','required');
        $this->form_validation->set_rules('Locations_Users','Locations_Users','required');
        $this->form_validation->set_rules('user_group','user_group','required');
        $this->form_validation->set_rules('user_Status','user_Status','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Company_Users', 'refresh');

        }else{

            $data_Users['full_name_ar'] = $this->input->post('full_name_ar');
            $data_Users['full_name']    = $this->input->post('full_name');
            $data_Users['banned']       = $this->input->post('user_Status');

            $email             = $this->input->post('email');
            $password          = $this->input->post('password');
            $Locations_Users   = $this->input->post('Locations_Users');
            $user_group        = $this->input->post('user_group');

            $create_user = $this->aauth->create_user($email, $password,'',$data_Users);

            $Company_id = $this->data['UserLogin']['Company_User'];

            Create_Group_user($create_user,$user_group);

            Create_Locations_and_Company_user($create_user,$Locations_Users,$Company_id);

            if($create_user){
                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Company_Users' , 'refresh');
            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Company_Users', 'refresh');
            }

        } // if($this->form_validation->run()==FALSE)


    }
    ###################################################################





}