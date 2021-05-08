<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Email extends Apps
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

        $query = $this->db->order_by('id', 'DESC');
        $query = $this->db->where('receiver_id',$this->aauth->get_user()->id);

        $query = $this->db->get('portal_auth_private_messages');
        $this->data['Inbox'] = $query;

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page']        = $this->load->view('../../modules/App_Company_Email/views/Inbox', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Email/views/Layout_Email', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################


    // Done
    ###################################################################
    public function New_Message()
    {
        $kau_id = $this->uri->segment(4);

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
            redirect(APP_NAMESPACE_URL . '/Dashboard', 'refresh');
        }else{
            $this->data['Student'] = $query_2->row();
        }

        $this->data['Page_Title']  = 'انشاء رسالة جديدة';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Email/views/New_Message', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    // Done
    ###################################################################
    public function New_Message_Group()
    {
        $this->data['Page_Title']  = 'انشاء رسالة جديدة';


//        $this->db->select('*');
//        $this->db->from('student_profile    student_profile');
//        $this->db->join('portal_auth_users  auth_users', 'student_profile.userid = auth_users.id');
//        if(!$this->aauth->is_admin()){
//            $this->db->where_in('auth_users.department_id', $this->aauth->get_user()->department_id);
//            $this->db->where_in('auth_users.Specialization_id', $this->aauth->get_user()->Specialization_id);
//        }
        $this->data['users'] = '';//$this->db->get();


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page']        = $this->load->view('../../modules/App_Company_Email/views/New_Message_Group', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Email/views/Layout_Email', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################



    // Done
    ###################################################################
    public function Send_Message()
    {
        $this->form_validation->set_rules('title','عنوان الرسالة','required');
        $this->form_validation->set_rules('message','نص الرسالة','required');
        $this->form_validation->set_rules('student_id','الطالب','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Email/New_Message', 'refresh');

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


            $data_massage['name']         = $this->aauth->get_user()->full_name;
            $data_massage['massge']       = $message;
            $data_massage['timedate']     = time();
            $message_email = '';//$this->load->view('../../modules/Layout/Alert_Private_Messages_Student',$data_massage, true);

            $this->email->clear();
            $this->email->to($get_user->email);
            $this->email->from('stu@fcit-kau.com');
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
            $this->email->set_crlf("\r\n");
            $this->email->subject('    ');
            $this->email->message($message_email);
            $this->email->send();


            if ($Send_Message) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = 'تم ارسال رسالتك بنجاح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Email/New_Message', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'حصل خطا اثناء ارسال الرسالة الخاصة بك يرجى المحاولة مره اخرى';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Email/New_Message', 'refresh');
            }

        }

    }
    ###################################################################

    // Done
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
            redirect(APP_NAMESPACE_URL.'/Email/New_Message_Group', 'refresh');

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


                $data_massage['name']         = $this->aauth->get_user()->full_name;
                $data_massage['massge']       = $message;
                $data_massage['timedate']     = time();
                $message_email = $this->load->view('../../modules/Layout/Alert_Private_Messages_Student',$data_massage, true);

                $this->email->clear();
                $this->email->to($get_user->email);
                $this->email->from('stu@fcit-kau.com');
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");
                $this->email->set_crlf("\r\n");
                $this->email->subject('     ');
                $this->email->message($message_email);
                $this->email->send();

            }

            if ($Send_Message) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = 'تم ارسال رسالتك بنجاح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Email/New_Message_Group', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'حصل خطا اثناء ارسال الرسالة الخاصة بك يرجى المحاولة مره اخرى';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Email/New_Message_Group', 'refresh');
            }

        }
    }
    ###################################################################

    // Done
    ###################################################################
    public function Outbox()
    {
        $query = $this->db->order_by('id', 'DESC');
        $query = $this->db->where('sender_id',$this->aauth->get_user()->id);
        $query = $this->db->get('portal_auth_private_messages');

        $this->data['Student_Inbox'] = $query;

        $this->data['Page_Title']  ='البريد الصادر';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page']        = $this->load->view('../../modules/App_Company_Email/views/Outbox', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Email/views/Layout_Email', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################


    // Done
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
            redirect(APP_NAMESPACE_URL.'/Dashboard', 'refresh');

        }else{

            $this->data['Message'] = $Message->row();
            if($Message->row()->receiver_id == $this->aauth->get_user()->id) {
                $this->db->where('uuid',$Message_id);
                $this->db->set('date_read',date('Y-m-d h:i:s a'));
                $this->db->update('portal_auth_private_messages');
            }

            $this->db->where('messages_id',$Message->row()->id);
            $Message_reply = $this->db->get('portal_auth_private_reply_messages');

            if($Message_reply->num_rows()>0){
                $this->data['Message_reply'] = $Message_reply;
            }else{
                $this->data['Message_reply'] = false;
            }

        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page']        = $this->load->view('../../modules/App_Company_Email/views/View_Message_Outbox', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Email/views/Layout_Email', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    // Done
    ###################################################################
    public function View_Message_Inbox()
    {
        $this->data['Page_Title']  = 'عرض الرسالة';

        $Message_id = $this->uri->segment(4);

        $Message =$this->db->where('uuid',$Message_id);
        $Message =$this->db->where('receiver_id',$this->aauth->get_user()->id);
        $Message = $this->db->get('portal_auth_private_messages');

        if($Message->num_rows() == 0){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Email', 'refresh');

        }else{

            $this->data['Message'] = $Message->row();

            if($Message->row()->receiver_id == $this->aauth->get_user()->id) {
                $this->db->where('uuid',$Message_id);
                $this->db->set('date_read',date('Y-m-d h:i:s a'));
                $this->db->update('portal_auth_private_messages');
            }

            $this->db->where('messages_id',$Message->row()->id);
            $Message_reply = $this->db->get('portal_auth_private_reply_messages');

            if($Message_reply->num_rows()>0){
                $this->data['Message_reply'] = $Message_reply;
            }else{
                $this->data['Message_reply'] = false;
            }

        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page']        = $this->load->view('../../modules/System_Email/views/View_Message_Inbox', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/System_Email/views/Layout_Email', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    // Done
    ###################################################################
    public function archive_Message()
    {
        $query = $this->db->where('pm_deleted_receiver',$this->aauth->get_user()->id);
        $query = $this->db->or_where('pm_deleted_sender',$this->aauth->get_user()->id);
        $query = $this->db->get('portal_auth_private_messages');

        $this->data['Student_Inbox'] = $query;

        $this->data['Page_Title']  ='ارشيف البريد';


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page']        = $this->load->view('../../modules/System_Email/views/archive_Message', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/System_Email/views/Layout_Email', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    // Done
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
            redirect(APP_NAMESPACE_URL.'/Email', 'refresh');
        }else{

            $this->db->where('messages_id',$Message->row()->id);
            $Message_reply = $this->db->get('portal_auth_private_reply_messages');

            if($Message_reply->num_rows()>0){
                $this->data['Message_reply'] = $Message_reply;
            }else{
                $this->data['Message_reply'] = false;
            }

            $this->data['Message'] = $Message->row();
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Email'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Page']        = $this->load->view('../../modules/System_Email/views/View_Message_Inbox', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/System_Email/views/Layout_Email', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    // Done
    ###################################################################
    public function Transfer_archive_Message()
    {
        $Message_id   = $this->uri->segment(4);
        $Type_Message = $this->uri->segment(5);

        $Update_Message = $this->db->where("uuid",$Message_id);

        if($Type_Message=='Inbox'){
            $Update_Message = $this->db->set("pm_deleted_receiver",$this->aauth->get_user()->id);
        }elseif($Type_Message=='Outbox'){
            $Update_Message = $this->db->set("pm_deleted_sender",$this->aauth->get_user()->id);
        }
        $Update_Message = $this->db->update("portal_auth_private_messages");

        if ($Update_Message) {
            $msg_result['key'] = 'Success';
            $msg_result['value'] = 'تم ارشفة الرسالة بنجاح';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Email/', 'refresh');
        } else {
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'حصل خطا اثناء ارشفة الرسالة الخاصة بك يرجى المحاولة مره اخرى';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Email/', 'refresh');
        }

        redirect(APP_NAMESPACE_URL . '/Email/', 'refresh');
    }
    ###################################################################

    // Done
    ###################################################################
    public function Reply_Message()
    {
        $this->form_validation->set_rules('message','نص الرد','required');

        $message_id  = $this->input->post('message_id', true);
        $message     = $this->input->post('message', true);

        $this->db->where('id',$message_id);
        $Message = $this->db->get('portal_auth_private_messages')->row();


        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Email/View_Message_Inbox/'.$Message->uuid, 'refresh');

        }else {

            $messages = array(
                "messages_id"   => $message_id,
                "reply_text"    => $message,
                "reply_date"    => time(),
                "reply_userid"  => $this->aauth->get_user()->id,
            );

            $Send_Message    = $this->db->insert('portal_auth_private_reply_messages',$messages);

            $data_massage['name']         = $this->aauth->get_user()->full_name;
            $data_massage['massge']       = $this->input->post('message', true);
            $data_massage['timedate']     = time();
            $message_email = $this->load->view('../../modules/Layout/Alert_Reply_Messages_Student',$data_massage, true);



            $this->email->clear();
            $this->email->to();
            $this->email->from('stu@fcit-kau.com');
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
            $this->email->set_crlf("\r\n");
            $this->email->subject(' رد على رسالة  ');
            $this->email->message($message_email);
            $this->email->send();



            if ($Send_Message) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = 'تم ارسال ردك  بنجاح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Email/View_Message_Inbox/'.$Message->uuid, 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'حصل خطا اثناء ارسال الرسالة الخاصة بك يرجى المحاولة مره اخرى';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Email/View_Message_Inbox/'.$Message->uuid, 'refresh');
            }

        }

    }
    ###################################################################

}