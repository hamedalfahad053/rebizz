<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Coordinator extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'ادارة المعاملات';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        exit;
    }
    ###################################################################

    ###################################################################
    public function Dashboard()
    {

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

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');


        $this->data['Page_Title']      = ' متابعة زيارة المعاين ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Coordination/index', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ######################################################################################################
    public function Add_Preview_Visit()
    {

        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"                     => $Transaction_id,
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->locations_id,
        );
        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows() > 0){

            $this->data['Transactions']      = $Get_Transactions->row();

            $transaction_id          = $this->data['Transactions']->transaction_id;

            $regions_id              = Transaction_data_by_key($transaction_id,1,1,'LIST_REGION');
            $city_id                 = Transaction_data_by_key($transaction_id,1,1,'LIST_CITY');
            $districts               = Transaction_data_by_key($transaction_id,1,1,'LIST_DISTRICT');


            $users_preview  = app()->db->from('portal_auth_users         auth_users');
            $users_preview  = app()->db->join('protal_users_preview_map  users_preview_map','auth_users.id = users_preview_map.users_preview_id');
            $users_preview  = app()->db->where('users_preview_map.regions_id',$regions_id);
            $users_preview  = app()->db->where('users_preview_map.city_id',$city_id);
            $users_preview  = app()->db->where('users_preview_map.company_id',$this->aauth->get_user()->company_id);
            $users_preview  = app()->db->where('auth_users.banned',0);
            $users_preview  = app()->db->get();


            if($users_preview->num_rows()>0){
                $this->data['users_preview']  = $users_preview->result();
            }else{
                $this->data['users_preview']  = false;
            }

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }


        $this->data['Page_Title']      = ' اضافة زيارة معاينة ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Coordination/Add_Preview_Visit', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ######################################################################################################

    ######################################################################################################
    public function Create_Preview_Visit()
    {

        $this->form_validation->set_rules('Transaction_id','رقم المعاملة','required');
        $this->form_validation->set_rules('preview_userid','لم يتم تحديد المعاين','required');
        $this->form_validation->set_rules('preview_date','لم يتم تحديد وقت الزيارة ','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Coordinator/Add_Preview_Visit/'.$this->uri->segment(4), 'refresh');

        }else{

            $Transaction_id =  $this->uri->segment(4);

            $where_Transactions = array("uuid"=> $Transaction_id, "company_id"=> $this->aauth->get_user()->company_id,"location_id"=> $this->aauth->get_user()->locations_id);
            $Get_Transactions  = Get_Transaction($where_Transactions);

            if($Get_Transactions->num_rows()>0){
                $Get_Transactions = $Get_Transactions->row();
            }else{
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
            }

            if(IsHijri($this->input->post('preview_date')) == true){
                $preview_date_ex = explode('-',$this->input->post('preview_date'));
                $converted       = Hijri2Greg($preview_date_ex[2], $preview_date_ex[1], $preview_date_ex[0], $string = false);
                $coldata         = $converted['year'].'-'.$converted['month'].'-'.$converted['day'] .date('h').':'.date('i');
                $preview_date    = strtotime($coldata);
            }else{
                $preview_date = strtotime($this->input->post('preview_date'));
            }

            $Preview_Visit['Transactions_id']                  = $this->input->post('Transaction_id');
            $Preview_Visit['preview_userid']                   = $this->input->post('preview_userid');
            $Preview_Visit['preview_date']                     = $preview_date;
            $Preview_Visit['preview_date_assignment']          = $preview_date;
            $Preview_Visit['preview_stauts']                   = 347;
            $Preview_Visit['preview_type']                     = $this->input->post('preview_type');
            $Preview_Visit['preview_stages']                   = $this->input->post('preview_stages');
            $Preview_Visit['company_id']                       = $this->aauth->get_user()->company_id;
            $Preview_Visit['preview_Visit_userid_acceptance']  = 0;
            $Preview_Visit['preview_Visit_date_completed']     = 0;
            $Preview_Visit['createBy']                         = $this->aauth->get_user()->id;

            $Create_Preview_Visit = Create_Preview_Visit($Preview_Visit);

            if($Create_Preview_Visit){

                $query = app()->db->where('transaction_id',$Get_Transactions->transaction_id);
                $query = app()->db->set('Transaction_Status_id','195');
                $query = app()->db->set('Transaction_Stage','COORDINATION_AND_QUALITY');
                $query = app()->db->update('protal_transaction');


                if($this->input->post('SMS') == 1)
                {

                    $SMS   = $this->input->post('preview_SMS_text');
                    $Phone = $this->aauth->get_user($this->input->post('preview_userid'))->phone;
                    Send_Sms($SMS,$Phone);

                } // if($this->input->post('SMS') == 1)


                if($this->input->post('Email') == 1)
                {

                    $Data_Email['subject']  = 'طلب معاينة عقار ';
                    $Data_Email['message']  = $this->input->post('preview_Email_text');
                    $Data_Email['to']       = $this->aauth->get_user($this->input->post('preview_userid'))->email;
                    $Data_Email['from']     = '';

                    if($this->input->post('attach') == 1)
                    {
                        $filename = "Transaction_combine_".date('Ymd',$Get_Transactions->Create_Transaction_Date).''.$Get_Transactions->transaction_id.'.pdf';
                        $Data_Email['attach']  = realpath('uploads/tmp_combine_pdf/'.$filename);
                    }

                    Create_Email_Notifications($Data_Email);

                } // $this->input->post('Email')


                $data_Transaction_Assign = array();
                $data_Transaction_Assign['transaction_id']       = $Get_Transactions->transaction_id;
                $data_Transaction_Assign['assign_userid']        = $this->input->post('preview_userid');
                $data_Transaction_Assign['assign_time']          = time();
                $data_Transaction_Assign['assign_createDate']    = time();
                $data_Transaction_Assign['assign_type']          = 1;
                $Create_Transaction_Assign = Create_Transaction_Assign($data_Transaction_Assign);

                # Status Stages
                $Data_Status_Stages_Transaction = array(
                    "stages_key"     => 'COORDINATION_AND_QUALITY',
                    "stages_type"    => 'COMPLETE',
                    "transaction_id" => $Get_Transactions->transaction_id,
                    "time_start"     => time(),
                    "time_complete"  => time()
                );
                Create_Status_Stages_Transaction($Data_Status_Stages_Transaction);

                $msg_result['key']   = 'Success';
                $msg_result['value'] = 'تم انشاء الزيارة بنجاح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Coordinator/Dashboard/'.$Get_Transactions->uuid , 'refresh');

            }else{

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'حصل خطا ما حاول مجددا';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Coordinator/Add_Preview_Visit/'.$Get_Transactions->uuid, 'refresh');

            }

        } // if($this->form_validation->run()==FALSE)
    }
    ######################################################################################################

    ######################################################################################################
    public function View_Preview_Visit()
    {

        $Transaction_id  =  $this->uri->segment(4);
        $Coordination_id =  $this->uri->segment(5);

        $where_Transactions = array(
            "uuid"=>$Transaction_id,"company_id"=>$this->aauth->get_user()->company_id,"location_id"=>$this->aauth->get_user()->locations_id,
        );
        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $GetTransactions = $Get_Transactions->row();

            $where_Preview_Visit = array(
                "Transactions_id"=> $GetTransactions->transaction_id,"Coordination_uuid"=>$Coordination_id
            );

            $Get_Preview_Visit = Get_Preview_Visit($where_Preview_Visit);
            if($Get_Preview_Visit->num_rows()>0){
                $this->data['Coordination']  = $Get_Preview_Visit->row();
                $this->data['Transactions']  = $Get_Transactions->row();

                $where_Preview_Visit_FeedBack = array("Coordination_id"=>$this->data['Coordination']->Coordination_id);
                $Get_Preview_Visit_FeedBack = Get_Preview_Visit_FeedBack($where_Preview_Visit_FeedBack);
                $this->data['Preview_Visit_FeedBack']  = $Get_Preview_Visit_FeedBack;

            }else{
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
            }

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->data['Page_Title']      = ' متابعة زيارة المعاين ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();



        $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Coordination/View_Preview_Visit', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ######################################################################################################

    ######################################################################################################
    public function Deleted_Preview_Visit()
    {
        $Transaction_id =  $this->uri->segment(4);
        $Preview_Visit   = $this->uri->segment(5);

        $Deleted   = app()->db->where("Coordination_uuid",$Preview_Visit);

        $Deleted   = app()->db->set("isDeleted",1);
        $Deleted   = app()->db->set("DeletedBy",$this->aauth->get_user()->id);
        $Deleted   = app()->db->set("lastModifyDate",time());

        $Deleted   = app()->db->update('protal_transaction_coordination');

        if ($Deleted) {

            $msg_result['key']   = 'Success';
            $msg_result['value'] = 'تم الحذف بنجاح';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Coordinator/Dashboard/'.$Transaction_id, 'refresh');

        } else {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'لم يتم عمل الحذف يرجى المحاولة مجددا';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Coordinator/Dashboard/'.$Transaction_id.'/', 'refresh');

        }

    }
    ######################################################################################################

    ######################################################################################################
    public function Assign_Evaluator()
    {

        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array("uuid" => $Transaction_id, "company_id" => $this->aauth->get_user()->company_id, "location_id" => $this->aauth->get_user()->locations_id);
        $Get_Transactions   = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $this->data['Transactions']      = $Get_Transactions->row();

            $lang  = get_current_lang();

            $Users_Evaluator = app()->db->select('users.id as users_id ,users.user_uuid as user_uuid, users.full_name as full_name', false);
            $Users_Evaluator = app()->db->from('portal_auth_users                 users');
            $Users_Evaluator = app()->db->join('portal_auth_user_to_group         user_to_group', 'user_to_group.user_id = users.id');
            $Users_Evaluator = app()->db->join('portal_auth_groups                groups_users', 'groups_users.group_id = user_to_group.group_id');
            $Users_Evaluator = app()->db->join('portal_auth_groups_translation    Groups_Translation', 'groups_users.group_id = Groups_Translation.item_id');
            $Users_Evaluator = app()->db->join('portal_auth_permissions_to_group  Groups_Permissions', 'Groups_Permissions.group_id = groups_users.group_id', 'left');
            $Users_Evaluator = app()->db->join('portal_auth_permissions_to_user   Users_Permissions', 'Users_Permissions.user_id = users.id', 'left');
            $Users_Evaluator = app()->db->where('users.company_id', $this->aauth->get_user()->company_id);
            $Users_Evaluator = app()->db->where('users.banned', 0);
            $Users_Evaluator = app()->db->where('( Groups_Permissions.perm_id = 37 OR Users_Permissions.perm_id = 37 )');
            $Users_Evaluator = app()->db->where('Groups_Translation.translation_lang', $lang);
            $Users_Evaluator = app()->db->get();

            if($Users_Evaluator->num_rows()>0)
            {
                $this->data['Users_Evaluator'] = $Users_Evaluator;
            }
            else
            {
                $this->data['Users_Evaluator'] = false;
            }

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->data['Page_Title']      = ' تحديد مقيم  ';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();


        $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Coordination/Assign_Evaluator', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
        Layout_Apps($this->data);

    }
    ######################################################################################################

    ######################################################################################################
    public function Create_Assign_Evaluator()
    {
        $this->form_validation->set_rules('Users_Evaluator','لم يتم تحديد المقيم','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Transactions/Assign_Evaluator/'.$this->uri->segment(4), 'refresh');

        }else{

            $Transaction_id     = $this->uri->segment(4);

            $where_Transactions = array(
                "uuid"       => $Transaction_id,
                "company_id" => $this->aauth->get_user()->company_id,
                "location_id" => $this->aauth->get_user()->locations_id
            );
            $Get_Transactions   = Get_Transaction($where_Transactions);

            if($Get_Transactions->num_rows() == 0)
            {
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'المعاملة غير صحيحة';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Transactions/View_Transaction/'.$this->uri->segment(4), 'refresh');

            }else{

                $user_emp_id                            =  $this->input->post('Users_Evaluator', true);
                $data_assign['transaction_id']          =  $Get_Transactions->row()->transaction_id;
                $data_assign['assign_userid']           =  $user_emp_id;
                $data_assign['assign_time']             =  time();
                $data_assign['assign_type']             =  1;
                $data_assign['assign_createDate']       =  time();
                $data_assign['assign_lastModifyDate']   =  0;

                $Create_assign = $this->db->insert('protal_transaction_assign',$data_assign);

                if($Create_assign) {

                    $Assignment_userid   = $this->input->post('Users_Evaluator');
                    $Notifications_title = 'اسناد معاملة ';
                    $Notifications_text  = 'تم اسناد معاملة اليك من خلال النظام ';
                    Create_Notifications_Transaction($Get_Transactions->row()->transaction_id,$Assignment_userid,$Notifications_title,$Notifications_text);

                    $msg_result['key']      = 'Success';
                    $msg_result['value']    = 'تم اضافة المقيم الى فريق العمل';
                    $msg_result_view        = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$this->uri->segment(4), 'refresh');

                } else {

                    $msg_result['value']    = 'لم تتم الاضافة فضلا حاول مجدداً';
                    $msg_result['key']      = 'Danger';
                    $msg_result_view        = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$this->uri->segment(4), 'refresh');

                }

            }

        }

    }
    ######################################################################################################


}
