<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Email extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();


        $this->data['controller_name'] = lang('Dashboard');
    }
    ###################################################################

    // DONE
    ###################################################################
    public function index()
    {
        $this->data['Page_Title']  = ' بريد الوارد ';

        $this->db->select('*');
        $this->db->where('receiver_id',$this->aauth->get_user()->id);
        $query = $this->db->get('portal_auth_private_messages');

        $this->data['Student_Inbox'] = $query;

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page']        = $this->load->view('../../modules/System_Email/views/Inbox', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/System_Email/views/Layout_Email', $this->data, true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Send_Message()
    {
        $this->form_validation->set_rules('title','عنوان الرسالة','required');
        $this->form_validation->set_rules('message','نص الرسالة','required');
        $this->form_validation->set_rules('student_id','الطالب','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/Dashboard/New_Message', 'refresh');

        }else {

            $title      = $this->input->post('title', true);
            $message    = $this->input->post('message', true);
            $student_id = $this->input->post('student_id', true);

            if($_FILES['file'])
            {

                $Uploader_path = './uploads/Message/';

                $config['upload_path']    = realpath($Uploader_path);
                $config['file_name']      = $_FILES['file']['name'];
                $config['allowed_types']  = 'gif|jpg|png|jpeg|pdf|doc|docx|xlsx|csv|xls';
                $config['max_size']       = 1024*3;
                $config['max_filename']   = 30;
                $config['encrypt_name']   = true;
                $config['remove_spaces']  = true;

                $this->upload->initialize($config);

                $uploader      = $this->upload->do_upload('file');
                $upload_data   = $this->upload->data();

                $messages = array(
                    "sender_id"   => $this->aauth->get_user()->id,
                    "receiver_id" => $student_id,
                    "title"       => $title,
                    "message"     => $message,
                    "date_sent"   => date('Y-m-d H:i:s'),
                    "file_att"   => $upload_data['file_name']
                );

                $Send_Message    = $this->db->insert('portal_auth_private_messages',$messages);

            }else{
                $messages        = array("sender_id"   => $this->aauth->get_user()->id, "receiver_id" => $student_id, "title"       => $title, "date_sent"   => date('Y-m-d H:i:s'), "message"     => $message);
                $Send_Message    = $this->db->insert('portal_auth_private_messages',$messages);
            }


            $get_user = $this->aauth->get_user($student_id);

            $message_email  = '';
            $message_email .= 'تنبية برسالة جديدة وصلت لحسابك من المشرف ';
            $this->email->clear();
            $this->email->to($get_user->email);
            $this->email->from('stu@fcit-kau.com');
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
            $this->email->set_crlf("\r\n");
            $this->email->subject('  تنبية رسالة جديدة - التدريب الصيفي كلية الحاسبات وتقنية المعلومات   ');
            $this->email->message($message_email);
            $this->email->send();

            if ($Send_Message) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = 'تم ارسال رسالتك بنجاح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Dashboard/New_Message', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'حصل خطا اثناء ارسال الرسالة الخاصة بك يرجى المحاولة مره اخرى';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Dashboard/New_Message', 'refresh');
            }

        }

    }
    ###################################################################

    ###################################################################
    public function  Send_Message_Group()
    {
        $this->form_validation->set_rules('title','عنوان الرسالة','required');
        $this->form_validation->set_rules('message','نص الرسالة','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/Dashboard/New_Message_Group', 'refresh');

        }else {

            foreach ($this->input->post('student_ids', true) AS $value)
            {
                $title        = $this->input->post('title', true);
                $message      = $this->input->post('message', true);

                if($_FILES['file'])
                {

                    $Uploader_path = './uploads/Message/';

                    $config['upload_path']    = realpath($Uploader_path);
                    $config['file_name']      = $_FILES['file']['name'];
                    $config['allowed_types']  = 'gif|jpg|png|jpeg|pdf|doc|docx|xlsx|csv|xls';
                    $config['max_size']       = 1024*3;
                    $config['max_filename']   = 30;
                    $config['encrypt_name']   = true;
                    $config['remove_spaces']  = true;

                    $this->upload->initialize($config);

                    $uploader      = $this->upload->do_upload('file');
                    $upload_data   = $this->upload->data();

                    $messages = array(
                        "sender_id"   => $this->aauth->get_user()->id,
                        "receiver_id" => $value,
                        "title"       => $title,
                        "message"     => $message,
                        "date_sent"   => date('Y-m-d H:i:s'),
                        "file_att"   => $upload_data['file_name']
                    );

                    $Send_Message    = $this->db->insert('portal_auth_private_messages',$messages);

                }else{
                    $messages = array(
                        "sender_id"   => $this->aauth->get_user()->id,
                        "receiver_id" => $value,
                        "title"       => $title,
                        "date_sent"   => date('Y-m-d H:i:s'),
                        "message"     => $message
                    );
                    $Send_Message    = $this->db->insert('portal_auth_private_messages',$messages);
                }

                $get_user       = $this->aauth->get_user($value);
                $message_email = '';
                $message_email .= 'تنبية برسالة جديدة وصلت لحسابك من المشرف ';
                $this->email->clear();
                $this->email->to($get_user->email);
                $this->email->from('stu@fcit-kau.com');
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");
                $this->email->set_crlf("\r\n");
                $this->email->subject('  تنبية رسالة جديدة - التدريب الصيفي كلية الحاسبات وتقنية المعلومات   ');
                $this->email->message($message_email);
                $this->email->send();

            }

            if ($Send_Message) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = 'تم ارسال رسالتك بنجاح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Dashboard/New_Message_Group', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'حصل خطا اثناء ارسال الرسالة الخاصة بك يرجى المحاولة مره اخرى';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Dashboard/New_Message_Group', 'refresh');
            }

        }
    }
    ###################################################################

    ###################################################################
    public function Outbox()
    {
        $query = $this->db->where('sender_id',$this->aauth->get_user()->id);
        $query = $this->db->get('portal_auth_private_messages');

        $this->data['Student_Inbox'] = $query;

        $this->data['Page_Title']  ='البريد الصادر';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page']        = $this->load->view('../../modules/System_Email/views/Outbox', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/System_Email/views/Layout_Email', $this->data, true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function New_Message()
    {
        $kau_id = $this->uri->segment(4);

        if (!$this->aauth->is_member('Admin')) {
            $this->db->where_in('auth_users.department_id', $this->aauth->get_user()->department_id);
            $this->db->where_in('auth_users.Specialization_id', $this->aauth->get_user()->Specialization_id);
        }

        $this->db->select('*');
        $this->db->from('student_profile    student_profile');
        $this->db->join('portal_auth_users  auth_users', 'student_profile.userid = auth_users.id');
        $this->db->where('auth_users.id',$kau_id);
        $query_2 = $this->db->get();


        if($query_2->num_rows() == 0){
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'غير  مصرح بمراسلة الطالب لا ينتمي الى الشطر او القسم الخاص بك';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL . '/Dashboard', 'refresh');
        }else{
            $this->data['Student'] = $query_2->row();
        }

        $this->data['Page_Title']  = 'انشاء رسالة جديدة';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Dashboard/views/New_Message', $this->data, true);
        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function New_Message_Group()
    {
        $this->data['Page_Title']  = 'انشاء رسالة جديدة';


        $this->db->select('*');
        $this->db->from('student_profile    student_profile');
        $this->db->join('portal_auth_users  auth_users', 'student_profile.userid = auth_users.id');
        if(!$this->aauth->is_admin()){
            $this->db->where_in('auth_users.department_id', $this->aauth->get_user()->department_id);
            $this->db->where_in('auth_users.Specialization_id', $this->aauth->get_user()->Specialization_id);
        }
        $this->data['users'] = $this->db->get();


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page']        = $this->load->view('../../modules/System_Email/views/New_Message_Group', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/System_Email/views/Layout_Email', $this->data, true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function View_Message_Outbox()
    {
        $this->data['Page_Title']  = 'عرض الرسالة';

        $Message_id = $this->uri->segment(4);

        $this->db->where('uuid',$Message_id);
        $this->db->where('sender_id',$this->aauth->get_user()->id);
        $Message = $this->db->get('portal_auth_private_messages');

        if($Message->num_rows() == 0){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/Dashboard', 'refresh');

        }else{

            $this->data['Message'] = $Message->row();
            if($Message->row()->receiver_id == $this->aauth->get_user()->id) {
                $this->db->where('id',$Message_id);
                $this->db->update('portal_auth_private_messages',array("date_read" => date('Y-m-d h:i:s a')));
            }

        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page']        = $this->load->view('../../modules/System_Email/views/View_Message_Outbox', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/System_Email/views/Layout_Email', $this->data, true);
        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function View_Message_Inbox()
    {
        $this->data['Page_Title']  = 'عرض الرسالة';

        $Message_id = $this->uri->segment(4);

        $this->db->where('uuid',$Message_id);
        $this->db->where('receiver_id',$this->aauth->get_user()->id);
        $Message = $this->db->get('portal_auth_private_messages');

        if($Message->num_rows() == 0){
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/Dashboard', 'refresh');
        }else{
            $this->data['Message'] = $Message->row();
            if($Message->row()->receiver_id == $this->aauth->get_user()->id) {
                $this->db->where('id',$Message_id);
                $this->db->update('portal_auth_private_messages',array("date_read" => date('Y-m-d h:i:s a')));
            }
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Page']        = $this->load->view('../../modules/System_Email/views/View_Message_Inbox', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/System_Email/views/Layout_Email', $this->data, true);


        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function archive_Message()
    {
        $query = $this->db->where('pm_deleted_receiver',$this->aauth->get_user()->id);
        $query = $this->db->or_where('pm_deleted_sender',$this->aauth->get_user()->id);
        $query = $this->db->get('portal_auth_private_messages');

        $this->data['Student_Inbox'] = $query;

        $this->data['Page_Title']  ='ارشيف البريد';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page']        = $this->load->view('../../modules/System_Email/views/archive_Message', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/System_Email/views/Layout_Email', $this->data, true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function views_archive_Message()
    {
        $this->data['Page_Title']  = 'عرض الرسالة';

        $Message_id = $this->uri->segment(4);

        $this->db->where('uuid',$Message_id);
        $this->db->where('( receiver_id = '.$this->aauth->get_user()->id.' OR  sender_id = '.$this->aauth->get_user()->id.' ) ');
        $Message = $this->db->get('portal_auth_private_messages');

        if($Message->num_rows() == 0){
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/Dashboard', 'refresh');
        }else{
            $this->data['Message'] = $Message->row();
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL . '/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Page']        = $this->load->view('../../modules/System_Email/views/View_Message_Inbox', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/System_Email/views/Layout_Email', $this->data, true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Transfer_archive_Message()
    {
        $Message_id   = $this->uri->segment(4);
        $Type_Message = $this->uri->segment(5);

        if($Type_Message=='Inbox'){

            $Update_Message = $this->db->set("pm_deleted_receiver",$this->aauth->get_user()->id);
        }elseif($Type_Message=='Outbox'){
            $Update_Message = $this->db->set("pm_deleted_sender",$this->aauth->get_user()->id);
        }
        $Update_Message = $this->db->where("id",$Message_id);
        $Update_Message = $this->db->update("portal_auth_private_messages");

        if ($Update_Message) {
            $msg_result['key'] = 'Success';
            $msg_result['value'] = 'تم ارشفة الرسالة بنجاح';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL . '/Dashboard/'.$Type_Message.'', 'refresh');
        } else {
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'حصل خطا اثناء ارشفة الرسالة الخاصة بك يرجى المحاولة مره اخرى';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL . '/Dashboard/'.$Type_Message.'', 'refresh');
        }

        redirect(ADMIN_NAMESPACE_URL . '/Dashboard/'.$Type_Message.'', 'refresh');
    }
    ###################################################################
}