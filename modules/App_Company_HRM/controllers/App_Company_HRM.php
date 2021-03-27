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
                    $department_supervisor = $ROW->department_supervisor;
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

    } //public function Create_Departments()
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

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_HRM/views/List_Employees', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################



}