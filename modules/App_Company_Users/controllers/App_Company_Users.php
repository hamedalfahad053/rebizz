<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_Users extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'ادارة المستخدمين';
    }
    ###################################################################

    // DONE
    ###################################################################
    public function index()
    {

        $Company_Users = Get_Company_Users(
            array(
                "users.company_id" => $this->aauth->get_user()->company_id,
            )
        );

        if($Company_Users->num_rows()>0){
            foreach ($Company_Users->result() AS $Row)
            {
                if($Row->banned == 0) {
                    $user_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
                }else{
                    $user_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
                }
                $options = array();

                $options['view']    = array("class"=>"","id"=>"","title" => lang('view_button'), "data-attribute" => '',
                    "href" => base_url(APP_NAMESPACE_URL.'/Users/'.$Row->user_uuid) );
                $options['edit']    = array("class"=>"","id"=>"","title" => lang('edit_button'), "data-attribute" => '',
                    "href" => base_url(APP_NAMESPACE_URL.'/Users/Edit_User/'.$Row->user_uuid));


                $options['Update_Password'] = array(
                    "class"=>"","id"=>"",
                    "title" => 'استعادة كلمة المرور',
                    "data-attribute" => '',
                    'color' => 'danger',
                    'icon'=> 'flaticon2-shield',
                    "href" => base_url(APP_NAMESPACE_URL.'/Users/Update_Password/'.$Row->user_uuid)
                );


                $options['custom'] = array(
                    "class"=>"","id"=>"",
                    "title" => 'تسجيل دخول بالحساب',
                    "data-attribute" => '',
                    'color' => 'danger',
                    'icon'=> 'flaticon-logout',
                    "href" => base_url(APP_NAMESPACE_URL.'/Users/Login_As/'.$Row->id)
                );


                if($Row->banned == 1) {
                    $options['active'] = array("class"=>"","id"=>"","title" => lang('active_button'), "data-attribute" => '',
                        "href" => base_url(APP_NAMESPACE_URL.'/Users/Status_User/'.$Row->user_uuid.'/0') );
                }else {
                    $options['disable'] = array("class"=>"","id"=>"","title" => lang('disable_button'), "data-attribute" => '',
                        "href" => base_url(APP_NAMESPACE_URL.'/Users/Status_User/'.$Row->user_uuid.'/1'));
                }


                $user_options =  Create_Options_Button($options);

                if(get_current_lang() == 'arabic'){
                    $Locations = Get_Locations(array("company_locations_id"=>$Row->locations_id,"company_id"=>$this->aauth->get_user()->company_id))->Locations_ar;
                }else{
                    $Locations = Get_Locations(array("company_locations_id"=>$Row->locations_id,"company_id"=>$this->aauth->get_user()->company_id))->Locations_en;
                }

                $this->data['Company_Users'][] = array(
                    "user_id"      => $Row->user_id,
                    "email"        => $Row->email,
                    "phone"        => $Row->phone,
                    "full_name"    => $Row->full_name,
                    "locations"    => $Locations,
                    "date_created" => $Row->date_created,
                    "user_status"  => $user_status,
                    "group_user"   => $Row->item_translation,
                    "user_options" => $user_options,
                );

            }
        }else{
            $this->data['Company_Users'] = false;
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

    // DONE
    ###################################################################
    public function add_Users()
    {
        $Company_Group       = Get_Group(
            array(
            "company_id"   => $this->aauth->get_user()->company_id,
            "group_status" => 1
            )
        );

        $Company_Locations   = Get_Company_Locations(
            array(
                "company_id"       => $this->aauth->get_user()->company_id,
                "Locations_Status" => 1
            )
        );

        $Company_departments   = Get_Departments(
            array(
                "departments.company_id"            => $this->aauth->get_user()->company_id,
                "departments.departments_status"    => 1,
                "departments.departments_isDeleted" => 0
            )
        );

        foreach ($Company_departments->result()  AS $departments)
        {
            $this->data['departments'][] = array(
                "departments_id"    => $departments->departments_id,
                "departments_title" => $departments->item_translation
            );
        }

        foreach ($Company_Group->result()  AS $R_Group_Users)
        {
            $this->data['Group_Users'][] = array(
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
            $this->data['Locations_Users'][] = array(
                "locations_id"    => $R_Locations->company_locations_id,
                "locations_Name"  => $Locations_Name
            );
        }

        $this->data['user_status'] = array(
            0=>"مفعل",
            1=>"معطل");
        $this->data['Page_Title']  = ' اضافة مستخدم  ';

        $this->mybreadcrumb->add(lang('Dashboard'), '');
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Users/views/Form_add_Users', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    // DONE
    ###################################################################
    public function Create_Users()
    {
        $this->form_validation->set_rules('full_name_ar','اسم المستخدم باللغة العربية','required');
        $this->form_validation->set_rules('full_name','اسم المستخدم باللغة الانجليزية','required');
        $this->form_validation->set_rules('email','البريد الالكتروني','required');
        $this->form_validation->set_rules('password','كلمة المرور','required');
        $this->form_validation->set_rules('confirm_password','تأكيد كلمة المرور','required');
        $this->form_validation->set_rules('Locations_Users','الفرع ','required');
        $this->form_validation->set_rules('user_group','مجموعة المستخدم','required');
        $this->form_validation->set_rules('user_Status','حالة المستخدم','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            $this->add_Users();

        }else{

            $data_Users['full_name_ar']    = $this->input->post('full_name_ar',true);
            $data_Users['full_name']       = $this->input->post('full_name',true);
            $data_Users['locations_id']    = $this->input->post('Locations_Users',true);
            $data_Users['phone ']          = $this->input->post('mobile',true);
            $data_Users['company_id']      = $this->aauth->get_user()->company_id;
            $data_Users['departments_id']  = $this->input->post('departments_id',true);
            $data_Users['banned']          = $this->input->post('user_Status',true);

            $email                         = $this->input->post('email',true);
            $password                      = $this->input->post('password',true);
            $user_group                    = $this->input->post('user_group',true);

            $create_user                   = $this->aauth->create_user($email, $password,false,$data_Users);

            if($create_user){
                Create_Group_user_company(array("user_id"=>$create_user,"group_id"=>$user_group));
                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Users' , 'refresh');
            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Users', 'refresh');
            }

        } // if($this->form_validation->run()==FALSE)


    }
    ###################################################################

    // DONE
    ###################################################################
    public function Edit_User()
    {

        $this->data['Page_Title']  = 'تعديل بيانات مستخدم';
        $User_id =  $this->uri->segment(4);

        $Company_Users = Get_Company_Users(
            array(
                "users.company_id" => $this->aauth->get_user()->company_id,
                "users.user_uuid"  => $User_id
            )
        );

        if($User_id =='' or $Company_Users->num_rows() == 0) {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'المستخدم غير صحيح';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Users/', 'refresh');

        }else{

            $this->data['Users'] = $Company_Users->row();

            $Company_Locations   = Get_Company_Locations(
                array("company_id" => $this->aauth->get_user()->company_id, "Locations_Status" => 1)
            );

            $Company_departments   = Get_Departments(
                array("departments.company_id" => $this->aauth->get_user()->company_id, "departments.departments_status" =>1, "departments.departments_isDeleted" => 0)
            );

            foreach ($Company_departments->result()  AS $departments)
            {
                $this->data['departments'][] = array("departments_id" => $departments->departments_id, "departments_title" => $departments->item_translation);
            }

            $Company_Group = Get_Group(array("company_id"   => $this->aauth->get_user()->company_id, "group_status" => 1));
            foreach ($Company_Group->result()  AS $R_Group_Users)
            {
                $this->data['Group_Users'][] = array("group_id"    => $R_Group_Users->group_id, "group_title" => $R_Group_Users->item_translation);
            }

            foreach ($Company_Locations->result()  AS $R_Locations)
            {
                if(get_current_lang()=='arabic'){
                    $Locations_Name = $R_Locations->Locations_ar;
                }else{
                    $Locations_Name = $R_Locations->Locations_en;
                }
                $this->data['Locations_Users'][] = array("locations_id" => $R_Locations->company_locations_id, "locations_Name"  => $Locations_Name);
            }

            $this->data['user_status'] = array_options_status_user();

            $this->mybreadcrumb->add(lang('Dashboard'), '');
            $this->mybreadcrumb->add($this->data['Page_Title'],'#');

            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
            $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Users/views/Form_Edit_Users', $this->data, true);

            Layout_Apps($this->data);


        } // if($User_id =='' or $Company_Users->num_rows() == 0)


    }
    ###################################################################

    // DONE
    ###################################################################
    public function Update_User()
    {

        $User_id = $this->uri->segment(4);

        $this->form_validation->set_rules('full_name_ar','اسم المستخدم باللغة العربية','required');
        $this->form_validation->set_rules('full_name','اسم المستخدم باللغة الانجليزية','required');
        $this->form_validation->set_rules('email','البريد الالكتروني','required');
        $this->form_validation->set_rules('Locations_Users','الفرع ','required');
        $this->form_validation->set_rules('user_group','مجموعة المستخدم','required');
        $this->form_validation->set_rules('user_Status','حالة المستخدم','required');

        $Company_Users = Get_Company_Users(
            array(
                "users.company_id" => $this->aauth->get_user()->company_id,
                "users.user_uuid"  => $User_id
            )
        );

        if ($User_id == '' or $Company_Users->num_rows() == 0) {
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'المستخدم غير صحيح';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Users/', 'refresh');
        } else {

            $data_Users = $Company_Users->row();

            $data_Update['full_name_ar']    = $this->input->post('full_name_ar',true);
            $data_Update['full_name']       = $this->input->post('full_name',true);
            $data_Update['email']           = $this->input->post('email',true);
            $data_Update['locations_id']    = $this->input->post('Locations_Users',true);
            $data_Update['phone ']          = $this->input->post('mobile',true);
            $data_Update['departments_id']  = $this->input->post('departments_id',true);
            $data_Update['banned']          = $this->input->post('user_Status',true);
            $user_group                     = $this->input->post('user_group',true);

            Deleted_Group_User($data_Users->id);
            Create_Group_user_company(array("user_id"=>$data_Users->id,"group_id"=>$user_group));

            $Update_User           = Update_User($User_id,$data_Update);

            if($Update_User){
                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view     = 'تم تحديث المستخدم بنجاح';
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Users' , 'refresh');
            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'يوجد خطا حدث اثناء تحديث بيانات المستخدم';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Users', 'refresh');
            }

        }

    }
    ###################################################################

    // DONE
    ###################################################################
    public function Status_User()
    {
        $User_id = $this->uri->segment(4);
        $banned  = $this->uri->segment(5);


        $Company_Users = Get_Company_Users(
            array(
                "users.company_id" => $this->aauth->get_user()->company_id,
                "users.user_uuid" => 0
            )
        );

        if ($User_id == '' or $Company_Users->num_rows() == 0) {

            $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'المستخدم غير صحيح';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Users/', 'refresh');

        } else {

            $data_Update['banned'] = $banned;
            $Update_User           = Update_User($User_id,$data_Update);

            if($Update_User){
                $msg_result['key']   = 'Success';
                $msg_result['value'] = 'تم التحديث بنجاح';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Users' , 'refresh');
            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'يوجد خطا بالتحديث من فضلك حاول مجددا';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Users', 'refresh');
            }

        }

    }
    ###################################################################

    // Template Email
    ###################################################################
    public function Update_Password()
    {
        $user_id  = $this->uri->segment(4);


        if (!$user_id) {
            redirect(base_url(APP_NAMESPACE_URL."/Users/"));
        } else {

            $Company_Users = Get_Company_Users(array("users.company_id" => $this->aauth->get_user()->company_id, "users.user_uuid"  => $user_id));

            if($Company_Users->num_rows()==0){
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'المستخدم غير صحيح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Users/', 'refresh');
            }else{

                $Company_Users_data = $Company_Users->row();

                $new_pass        = time();
                $Update_Password = $this->aauth->update_user($Company_Users_data->id,"",$new_pass,"");


                $message_email = $this->load->view('../../modules/Template_Email/Transactions/Password_Mail', $this->data, true);

                $config = array('mailtype'  => 'html', 'charset'   => 'utf-8', 'wordwrap'  => TRUE);
                $this->load->library('email',$config);
                $this->email->clear();
                $this->email->to($Company_Users_data->email);
                $this->email->from('');
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");
                $this->email->set_crlf("\r\n");
                $this->email->subject('  طلب استعادة كلمة المرور  ');
                $this->email->message($message_email);
                $this->email->send();

                if($Update_Password){
                    $msg_result['key']   = 'Success';
                    $msg_result['value'] = 'تم ارسال كلمة المرور الجديدة الى المستخدم';
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL."/Users/", 'refresh');
                } else {
                    $msg_result['key']   = 'Danger';
                    $msg_result['value'] = 'خطا في ارسال كلمةالمرور الجديدة';
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL."/Users/", 'refresh');
                }

            } // if($Company_Users->num_rows()==0)




        }

    }
    ###################################################################

    ###################################################################
    public function Login_As()
    {
        $id       = $this->uri->segment(4);

        $query_group = $this->db->where('user_id',$this->aauth->get_user($id)->id);
        $query_group = $this->db->get('portal_auth_user_to_group')->row();


        $this->aauth->login_fast($id);
        redirect(APP_NAMESPACE_URL.'/Dashboard', 'refresh');
    }
    ###################################################################

    ###################################################################
    public function Custom_Permissions()
    {
        $Company_Users = Get_Company_Users(
            array(
                "users.company_id" => $this->aauth->get_user()->company_id,
                "users.banned"     => 0
            )
        );

        if($Company_Users->num_rows()>0){
            foreach ($Company_Users->result() AS $Row)
            {
                if($Row->banned == 0) {
                    $user_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
                }else{
                    $user_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
                }
                $options = array();

                $options['custom'] = array(
                    "class"=>"","id"=>"",
                    "title" => ' صلاحيات مخصصة للمستخدم ',
                    "data-attribute" => '',
                    'color' => 'danger',
                    'icon'=> 'flaticon-multimedia-5',
                    "href" => base_url(APP_NAMESPACE_URL.'/Users/Permissions_User/'.$Row->user_uuid)
                );


                $user_options =  Create_Options_Button($options);

                if(get_current_lang() == 'arabic'){
                    $Locations = Get_Locations(array("company_locations_id"=>$Row->locations_id,"company_id"=>$this->aauth->get_user()->company_id))->Locations_ar;
                }else{
                    $Locations = Get_Locations(array("company_locations_id"=>$Row->locations_id,"company_id"=>$this->aauth->get_user()->company_id))->Locations_en;
                }

                $this->data['Company_Users'][] = array(
                    "user_id"      => $Row->user_id,
                    "email"        => $Row->email,
                    "phone"        => $Row->phone,
                    "full_name"    => $Row->full_name,
                    "locations"    => $Locations,
                    "date_created" => $Row->date_created,
                    "user_status"  => $user_status,
                    "group_user"   => $Row->item_translation,
                    "user_options" => $user_options,
                );

            }
        }else{
            $this->data['Company_Users'] = false;
        }

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page_Title']  = 'ادارة المستخدمين';

        $this->mybreadcrumb->add(lang('Dashboard'), '');
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Users/views/List_Users_Permissions', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Permissions_User()
    {

        $User_id =  $this->uri->segment(4);

        $Company_Users = Get_Company_Users(array("users.company_id" => $this->aauth->get_user()->company_id,"users.user_uuid"  => $User_id));

        if ($User_id == '' or $Company_Users->num_rows() == 0) {
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'المستخدم غير صحيح';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Users/', 'refresh');
        } else {

            $this->data['Page_Title']  = 'صلاحيات مخصصة للمستخدم';
            $this->data['User_data']   = $Company_Users->row();

            $Controllers     = array();
            $Get_Controllers = Get_Controllers(3);
            foreach ($Get_Controllers->result() AS $Row_Controllers)
            {
                $Controllers[] = array(
                    "Controllers_id"          => $Row_Controllers->controllers_id,
                    "Controllers_title"       => $Row_Controllers->item_translation,
                );

            }
            $this->data['Controllers_Permissions'] = $Controllers;


            $this->mybreadcrumb->add(lang('Dashboard'), '');
            $this->mybreadcrumb->add($this->data['Page_Title'],'#');
            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

            $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Users/views/Users_Permissions', $this->data, true);
            Layout_Apps($this->data);

        }

    }
    ###################################################################


    ###################################################################
    public function Update_Permissions_User()
    {

        $User_id =  $this->uri->segment(4);

        $Company_Users = Get_Company_Users(array("users.company_id" => $this->aauth->get_user()->company_id,"users.user_uuid"  => $User_id));

        if ($User_id == '' or $Company_Users->num_rows() == 0) {
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'المستخدم غير صحيح';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Users/', 'refresh');
        } else {


            if($this->input->post('permissions'))
            {
                $permissions = $this->input->post('permissions');

                Delete_All_Permissions_To_Users($Company_Users->row()->id);

                foreach ($permissions AS $value)
                {
                    $data_Permissions   = array("user_id" => $Company_Users->row()->id,"perm_id" => $value);
                    $Update_Permissions = Add_Permissions_To_User($data_Permissions);
                }

            } // if($this->input->post('permissions'))

            if($Update_Permissions){
                $msg_result['key']   = 'Success';
                $msg_result['value'] = 'تم التحديث بنجاح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Users/Permissions_User/'.$User_id, 'refresh');

            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'يوجد خطا اثناء التحديث ';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Users/Permissions_User/'.$User_id, 'refresh');
            }
        }

    }
    ###################################################################



}