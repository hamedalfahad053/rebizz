<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_Transaction extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' مرفقات المعاملات';
    }
    ###################################################################


    ###################################################################
    public function index(){

    }
    ###################################################################

    ###################################################################
    public function Assign_Transaction()
    {
        $this->data['Page_Title']      = ' فريق العمل ';

        $Transaction_id     = $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"          => $Transaction_id,
            "company_id"    => $this->aauth->get_user()->company_id,
            "location_id"   => $this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){
            $this->data['Transactions']      = $Get_Transactions->row();
        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        # Where Transaction Assign Users
        $where_Transaction_Assign = array("transaction_id"=>$this->data['Transactions']->transaction_id);
        $Get_Transaction_Assign   = Get_Transaction_Assign($where_Transaction_Assign);
        if($Get_Transaction_Assign->num_rows()>0){
            $Assign = array();
            foreach ($Get_Transaction_Assign->result() AS $RAS)
            {
                $Assign[] = array(
                    "uuid" => $RAS->uuid,
                    "assign_userid" => $this->aauth->get_user($RAS->assign_userid)->full_name,
                    "Department"    => Get_Departments(array("departments_id"=>$this->aauth->get_user($RAS->assign_userid)->departments_id))->row()->item_translation,
                    "assign_type"   => $RAS->assign_type,
                    "assign_time"   => date('Y-m-d h:i:s a',$RAS->assign_time)
                );
            }
            $this->data['assign'] = $Assign;
        }else{
            $this->data['assign'] = false;
        } // if($Get_Transaction_Assign->num_rows()>0)

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');


        $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Assignment_Transaction/Assignment_Transaction', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function New_Assign_Transaction()
    {
        $this->data['Page_Title']      = ' اضافة موظف للمعاملة ';

        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"                     => $Transaction_id,
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->locations_id,
        );

        $this->data['Transactions'] = Get_Transaction($where_Transactions)->row();

        $Company_Users = Get_Company_Users(array("users.company_id"=>$this->aauth->get_user()->company_id,"users.banned"=>0));

        foreach ($Company_Users->result() AS $Row) {

            $Company_Users_a[] = array(
                "user_id"   => $Row->user_id,
                "email"     => $Row->email,
                "full_name" => $Row->full_name,
            );

            $this->data['Company_Users'] = $Company_Users_a;

        } // foreach ($Company_Users->result() AS $Row)

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();



        $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Assignment_Transaction/New_Assignment_User_Transaction', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
        Layout_Apps($this->data);


    }
    ###################################################################

    ###################################################################
    public function Submit_Assign_Transaction()
    {

        $this->form_validation->set_rules('user_emp_id','لم يتم تحديد موظف على الاقل','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Work_Team/New_Assign_Transaction/'.$this->uri->segment(4), 'refresh');

        } else {

            $Transaction_id =  $this->uri->segment(4);

            $where_Transactions = array(
                "uuid"                     => $Transaction_id,
                "company_id"               => $this->aauth->get_user()->company_id,
            );
            $Get_Transactions  = Get_Transaction($where_Transactions)->row();


            $user_emp_id    =  $this->input->post('user_emp_id', true);

            $data_assign['transaction_id']          =  $Get_Transactions->transaction_id;
            $data_assign['assign_userid']           =  $user_emp_id;
            $data_assign['assign_time']             =  time();
            $data_assign['assign_type']             =  1;
            $data_assign['assign_createDate']       =  time();
            $data_assign['assign_lastModifyDate']   =  0;

            $Create_assign = app()->db->insert('protal_transaction_assign',$data_assign);

            if($Create_assign) {



                $Assignment_userid   = $this->input->post('Assignment_userid');
                $Notifications_title = 'اسناد معاملة ';
                $Notifications_text  = 'تم اسناد معاملة اليك من خلال النظام ';
                Create_Notifications_Transaction($Get_Transactions->transaction_id,$user_emp_id,$Notifications_title,$Notifications_text);

                $Data_Email['to']      = $this->aauth->get_user($user_emp_id)->email;
                $Data_Email['from']    = '';
                $Data_Email['subject'] = 'تم اسناد معاملة ';
                $Data_Email['message'] = $this->load->view('../../modules/Template_Email/Transactions/Assignment_Transaction_User',$Data_Email, true);
                Create_Email_Notifications($Data_Email);


                $msg_result['key']  = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Work_Team/Assign_Transaction/'.$this->uri->segment(4), 'refresh');

            } else {

                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Work_Team/Assign_Transaction/'.$this->uri->segment(4), 'refresh');

            }

        }

    }
    ###################################################################

    ###################################################################
    public function Unset_Assign_Transaction()
    {
        $uuid = $this->uri->segment(4);
        $Transaction_uuid = $this->uri->segment(5);
        $query = app()->db->where('uuid',$uuid);
        $query = app()->db->set('assign_type','0');
        $query = app()->db->update('protal_transaction_assign');

        if($query) {
            $msg_result['key']  = 'Success';
            $msg_result['value'] = 'تم الغاء التنشيط بنجاح';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Work_Team/Assign_Transaction/'.$Transaction_uuid, 'refresh');
        } else {
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'حدث خطا ما يرجى المحاولة لاحقا';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Work_Team/Assign_Transaction/'.$Transaction_uuid, 'refresh');
        }
    }
    ###################################################################

    ###################################################################
    public function Reset_Assign_Transaction()
    {
        $uuid = $this->uri->segment(4);
        $Transaction_uuid = $this->uri->segment(5);
        $query = app()->db->where('uuid',$uuid);
        $query = app()->db->set('assign_type','1');
        $query = app()->db->update('protal_transaction_assign');

        if($query) {
            $msg_result['key']  = 'Success';
            $msg_result['value'] = 'تم التنشيط بنجاح';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Work_Team/Assign_Transaction/'.$Transaction_uuid, 'refresh');
        } else {
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'حدث خطا ما يرجى المحاولة لاحقا';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Work_Team/Assign_Transaction/'.$Transaction_uuid, 'refresh');
        }
    }
    ###################################################################
}