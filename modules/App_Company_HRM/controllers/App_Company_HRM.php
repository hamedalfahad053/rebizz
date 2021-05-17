<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_HRM extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'ادراة شؤون الموظفين';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $this->data['Page_Title']  = 'ادراة شؤون الموظفين';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent'] = $this->load->view('../../modules/App_Coordination/views/List_Coordination', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Departments()
    {

        $this->data['Page_Title']  = 'ادارة الاقسام الوظيفية';

        $Get_Departments = Get_Departments(array("company_id"=>$this->aauth->get_user()->company_id,"departments_isDeleted"=>0));

        if($Get_Departments->num_rows()>0){

            foreach ($Get_Departments->result() AS $ROW )
            {

                if ($ROW->departments_status == 1) {
                    $departments_status = Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
                } else {
                    $departments_status = Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
                }

                $options['custom'] = array(
                    "class"=>"","id"=>"", "title" => "تحديث رئيس القسم", "data-attribute" => '',"color" => "success",
                    "icon" => "flaticon-settings",
                    "href" => base_url(APP_NAMESPACE_URL."/HRM/Set_Supervisor_Departments/".$ROW->departments_uuid)
                );


                $options['edit'] = array(
                    "class"=>"","id"=>"", "title" => lang('edit_button'), "data-attribute" => '', "href" => "#"
                );
                if($ROW->departments_status == 0) {
                    $options['active'] = array(
                        "class"=>"","id"=>"", "title" => lang('active_button'), "data-attribute" => '',
                        "href" => base_url(APP_NAMESPACE_URL."/HRM/Status_Departments/".$ROW->departments_uuid."/1")
                    );
                }else {
                    $options['disable'] = array(
                        "class"=>"","id"=>"", "title" => lang('disable_button'), "data-attribute" => '',
                        "href" => base_url(APP_NAMESPACE_URL."/HRM/Status_Departments/".$ROW->departments_uuid."/0")
                    );
                }


                if($ROW->department_supervisor == 0){
                    $department_supervisor = Create_Status_badge(array("key" => "Danger", "value" => 'لم يحدد رئيس للقسم'));
                }else{

                    $department_supervisor = @$this->aauth->get_user($ROW->department_supervisor)->full_name;
                    if($department_supervisor){

                    }else{
                        $department_supervisor = Create_Status_badge(array("key" => "Danger", "value" => 'لم يحدد رئيس للقسم'));
                    }
                }


                $departments_options =  Create_Options_Button($options);
                $this->data['Departments'][] = array(
                    "departments_uuid"      => $ROW->departments_uuid,
                    "departments_key"       => $ROW->departments_key,
                    "departments_title"     => $ROW->item_translation,
                    "department_supervisor" => $department_supervisor,
                    "departments_status"    => $departments_status,
                    "departments_createBy"  => $this->aauth->get_user($ROW->departments_createBy)->full_name.' - '.date("Y-m-d h:i:s a",$ROW->departments_createDate),
                    "departments_options"   => $departments_options
                );
            }

        }else{

            $this->data['Departments']  = false;

        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_HRM/views/List_Departments', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function add_Departments()
    {
        $this->data['Page_Title']  = ' اضافة قسم جديد ';


        $this->data['status']        = array_options_status();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_HRM/views/Form_add_Departments', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Departments()
    {
        $this->form_validation->set_rules('title_ar','العنوان باللغة العربية','required');
        $this->form_validation->set_rules('title_ar','العنوان باللغة الانجليزية','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/HRM/Departments', 'refresh');

        } else {

            $departments_key             =  strtoupper(str_replace(" ", "_", $this->input->post('title_en')));

            if(Get_Departments(array("departments_key"=>$departments_key,"company_id"=>$this->aauth->get_user()->company_id))->num_rows()>0){

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'القسم مضاف مسبقا';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/modules/HRM/add_Departments', 'refresh');

            }else {

                $data_departments = array();

                $data_departments['departments_key']              =  $departments_key;
                $data_departments['departments_status']           =  $this->input->post('departments_status');
                $data_departments['company_id']                   =  $this->aauth->get_user()->company_id;
                $data_departments['departments_createBy']         =  $this->aauth->get_user()->id;
                $data_departments['departments_createDate']       =  time();
                $data_departments['departments_lastModifyDate']   =  0;
                $data_departments['departments_isDeleted']        =  0;
                $data_departments['departments_DeletedBy']        =  0;

                $Create_Departments = Create_Departments($data_departments);

                Create_Logs_User('Create_Departments',$Create_Departments,'HRM','Create');


                if ($Create_Departments)
                {
                    $item_ar = $this->input->post('title_ar');
                    $item_en = $this->input->post('title_en');
                    insert_translation_Language_item('portal_hrm_departments_translation', $Create_Departments, $item_ar, $item_en);
                    $msg_result['key'] = 'Success';
                    $msg_result['value'] = lang('message_success_insert');
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/HRM/Departments', 'refresh');
                } else {
                    $msg_result['key'] = 'Danger';
                    $msg_result['value'] = lang('message_error_insert');
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/HRM/Departments', 'refresh');
                }

            } // if(num_rows()>0)

        } // if($this->form_validation->run()==FALSE)

    }
    ###################################################################

    ###################################################################
    public function Edit_Departments()
    {
        $this->data['Page_Title']  = ' تعديل قسم  ';



        $this->data['status']        = array_options_status();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_HRM/views/Form_Edit_Departments', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Set_Supervisor_Departments()
    {

        $uuid       =  $this->uri->segment(4);

        $this->data['Page_Title']  = '  تعيين رئيس قسم  ';

        if ($uuid == '') {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'طريقة غير صحيحة ';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/HRM/Departments/', 'refresh');

        } else {

            $Get_Departments           = Get_Departments(array("company_id"=>$this->aauth->get_user()->company_id,"departments.departments_uuid"=>$uuid))->row();
            $this->data['Departments'] = $Get_Departments;

            $Company_Users   = Get_Company_Users(array("users.company_id" => $this->aauth->get_user()->company_id,"users.banned"=>0));

            if ($Company_Users->num_rows() > 0) {

                foreach ($Company_Users->result() as $Row) {

                    if($Row->position_id != NULL){
                        $Position =  Get_options_List_Translation($Row->position_id)->item_translation;
                    }else{
                        $Position = 'غير محدد';
                    }

                    $this->data['Company_Users'][] = array(
                        "user_id"   => $Row->user_id,
                        "full_name" => $Row->full_name,
                        "position"  => $Position
                    );

                } // foreach

            } else {
                $this->data['Company_Users'] = false;
            } // if ($Company_Users->num_rows() > 0)
        } // if ($uuid == '')


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_HRM/views/Form_Set_Supervisor_Departments', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Update_Supervisor_Departments()
    {

        $this->form_validation->set_rules('departments_id','لم تحدد القسم','required');
        $this->form_validation->set_rules('Supervisor','لم تحدد رئيس القسم','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/HRM/Departments', 'refresh');

        } else {

            $departments_id               =  $this->input->post('departments_id');
            $Supervisor                   =  $this->input->post('Supervisor');
            $company_id                   =  $this->aauth->get_user()->company_id;

            $Update_Supervisor_Departments = Update_Supervisor_Departments($departments_id,$company_id,$Supervisor);

            if ($Update_Supervisor_Departments)
            {

                Create_Logs_User('Update_Supervisor_Departments',$departments_id,'Departments','Update');

                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/HRM/Departments', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/HRM/Departments', 'refresh');
            }

        }

    }
    ###################################################################

    ###################################################################
    public function Status_Departments()
    {

        $uuid       =  $this->uri->segment(4);
        $status     =  $this->uri->segment(5);
        $company_id =  $this->aauth->get_user()->company_id;

        if ($uuid == '' or $status == '') {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'طريقة غير صحيحة ';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/HRM/Departments/', 'refresh');

        } else {

            $Update_Departments_status = Update_Departments_status($uuid,$company_id,$status);

            if($Update_Departments_status)
            {
                Create_Logs_User('Update_Departments_status',$uuid,'HRM','Update');

                $msg_result['key']   = 'Success';
                $msg_result['value'] = 'تم التحديث بنجاح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/HRM/Departments', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'لم يتم التحديث يوجد مشكلة حدثت اثناء تحديث الحقل';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/HRM/Departments', 'refresh');
            }

        }



    }
    ###################################################################

    ###################################################################
    public function Position()
    {

        $Position =  query_All_options_List('28');
        foreach ($Position->result()  AS $R)
        {
            $this->data['Position'][] = array(
                "Position_id"       => $R->list_options_id,
                "Position_uuid"     => $R->options_uuid,
                "Position_title"    => $R->item_translation,
                "Position_createBy" => $R->options_createBy,
                "Position_status"   => $R->options_status,
                "Position_option"   => $R->options_status
            );
        }

        $this->data['Page_Title']  = 'ادارة المسميات الوظيفية';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs']   = $this->mybreadcrumb->render();
        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_HRM/views/List_Position', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function add_Position()
    {

        $this->data['Page_Title']  = 'اضافة مسمى وظيفي';


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs']   = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Coordination/views/List_Position', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Employees()
    {

        $this->data['Page_Title']  = 'ادراة الموظفين';

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

                $options['view']    = array("class"=>"","id"=>"","title" => lang('view_button'), "data-attribute" => '',
                    "href" => base_url(APP_NAMESPACE_URL."/HRM/View_Employees/".$Row->user_uuid));
                $options['edit']    = array("class"=>"","id"=>"","title" => lang('edit_button'), "data-attribute" => '',
                    "href" => base_url(APP_NAMESPACE_URL."/HRM/Edit_Employees/".$Row->user_uuid));

                if($Row->position_id != NULL){
                    $Position =  Get_options_List_Translation($Row->position_id)->item_translation;

                }else{
                    $Position = 'غير محدد';
                }

                if($Row->departments_id == NULL or $Row->departments_id == 0)
                {
                    $Departments_name = 'غير محدد';
                    $supervisor       = 'غير محدد';
                }else{

                    $Departments      = Get_Departments(array("company_id" =>$this->aauth->get_user()->company_id,"departments.departments_id"=>$Row->departments_id))->row();
                    $Departments_name = $Departments->item_translation;
                    $supervisor       = @$this->aauth->get_user($Departments->department_supervisor)->full_name;
                    if($supervisor){

                    }else{
                        $supervisor       = 'غير محدد';
                    }
                }

                $user_options =  Create_Options_Button($options);

                $this->data['Company_Users'][] = array(
                    "user_id"                => $Row->user_id,
                    "email"                  => $Row->email,
                    "phone"                  => $Row->phone,
                    "Position"               => $Position,
                    "departments"            => $Departments_name,
                    "department_supervisor"  => $supervisor,
                    "full_name"              => $Row->full_name,
                    "user_status"            => $user_status,
                    "group_user"             => $Row->item_translation,
                    "user_options"           => $user_options,
                );
            }
        }else{
            $this->data['Company_Users'] = false;
        }


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_HRM/views/List_Employees', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function View_Employees()
    {
        $this->data['Page_Title']  = '  ملف موظف ';

        $Employees_id  =  $this->uri->segment(4);
        $Company_Users = Get_Company_Users(
            array(
                "users.company_id" => $this->aauth->get_user()->company_id,
                "users.user_uuid"  => $Employees_id
            )
        );

        if($Employees_id =='' or $Company_Users->num_rows() == 0)
        {
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'طريقة غير صحيحة ';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/HRM/', 'refresh');
        }else{

            $this->data['Users'] = $Company_Users->row();

        } // if($Employees_id =='' or $Company_Users->num_rows() == 0)

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageParent']  = $this->load->view('../../modules/App_Company_HRM/views/View_Employees', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_HRM/views/Layout_Employees', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Edit_Employees()
    {

        $this->data['Page_Title']  = ' تعديل ملف موظف ';

        $Employees_id  =  $this->uri->segment(4);
        $Company_Users = Get_Company_Users(
            array(
                "users.company_id" => $this->aauth->get_user()->company_id,
                "users.user_uuid"  => $Employees_id
            )
        );

        if($Employees_id =='' or $Company_Users->num_rows() == 0)
        {
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'طريقة غير صحيحة ';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/HRM/', 'refresh');
        }else{

            $this->data['Users'] = $Company_Users->row();

        } // if($Employees_id =='' or $Company_Users->num_rows() == 0)

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageParent']  = $this->load->view('../../modules/App_Company_HRM/views/Edit_Employees', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_HRM/views/Layout_Employees', $this->data, true);
        Layout_Apps($this->data);


    }
    ###################################################################


    ###################################################################
    public function Update_Employees()
    {

        $User_id = $this->uri->segment(4);

        $this->form_validation->set_rules('full_name_ar','اسم الموظف باللغة العربية','required');
        $this->form_validation->set_rules('full_name','اسم الموظف باللغة الانجليزية','required');
        $this->form_validation->set_rules('email','البريد الالكتروني','required');

        $Company_Users = Get_Company_Users(array("users.company_id" => $this->aauth->get_user()->company_id, "users.user_uuid"  => $User_id));

        if ($User_id == '' or $Company_Users->num_rows() == 0) {
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'المستخدم غير صحيح';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Users/', 'refresh');
        } else {

            $data_Update['full_name_ar']                      = $this->input->post('full_name_ar',true);
            $data_Update['full_name']                         = $this->input->post('full_name',true);
            $data_Update['email']                             = $this->input->post('email',true);
            $data_Update['phone ']                            = $this->input->post('mobile',true);
            $data_Update['Authority_membership_No']           = $this->input->post('Authority_membership_No',true);

            if($_FILES['Signature']) {

                $Uploader_path = './uploads/companies/' . $this->data['LoginUser_Company_domain'] . '/' . FOLDER_Company_Signature;
                if (!is_dir($Uploader_path)) {
                    mkdir($Uploader_path, 0755, TRUE);
                }
                $config['upload_path']   = realpath($Uploader_path);
                $config['allowed_types'] = 'gif|jpg|png|jpg';
                $config['max_size']      = '1024';
                $config['max_filename']  = 30;
                $config['encrypt_name']  = true;
                $config['remove_spaces'] = true;
                $this->upload->initialize($config);
                $uploader    = $this->upload->do_upload('Signature');
                $upload_data = $this->upload->data();
                $data_Update['Signature'] = $upload_data['file_name'];
            }

            $Update_User           = Update_User($User_id,$data_Update);

            if($Update_User){
                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view     = 'تم تحديث بيانات الموظف بنجاح';
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/HRM/Employees' , 'refresh');
            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'يوجد خطا حدث اثناء تحديث بيانات الموظف';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/HRM/Employees', 'refresh');
            }
        }


    }
    ###################################################################

}