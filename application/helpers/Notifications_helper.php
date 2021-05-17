<?php

##############################################################################
if(!function_exists('Create_Notifications_Transaction'))
{

    function Create_Notifications_Transaction($Transaction_id,$to_user,$title,$text)
    {
        app()->load->database();

        $where_Transactions = array(
            "transaction_id"  => $Transaction_id,
            "company_id"      => app()->aauth->get_user()->company_id,
            "location_id"     => app()->aauth->get_user()->locations_id,
        );
        $Get_Transactions   = Get_Transaction($where_Transactions)->row();

        $data['userid']                  = $to_user;
        $data['notifications_type']      = 'TRANSACTION';
        $data['notifications_title']     = $title;
        $data['notifications_url']       = base_url(APP_NAMESPACE_URL.'/Transactions/View_Transaction/'.$Get_Transactions->uuid);
        $data['notifications_text']      = $text;
        $data['time']                    = time();
        $data['type_read']               = 0;
        $data['date_read']               = 0;

        app()->db->insert('portal_user_notifications',$data);

        $Data_Email['to']      = app()->aauth->get_user($to_user)->email;
        $Data_Email['from']    = '';
        $Data_Email['subject'] = $title;
        $Data_Email['message'] = app()->load->view('../../modules/Template_Email/Transactions/Notifications_Transaction_User',$Data_Email, true);
        Create_Email_Notifications($Data_Email);

    }
}
##############################################################################


##############################################################################
if(!function_exists('Create_Notifications'))
{

    function Create_Notifications($notifications)
    {
        app()->load->database();

        $data['userid']                  = $notifications['notifications_to_user'];
        $data['notifications_type']      = $notifications['notifications_type'];
        $data['notifications_title']     = $notifications['notifications_title'];
        $data['notifications_url']       = $notifications['notifications_url'];
        $data['notifications_text']      = $notifications['notifications_text'];
        $data['time']                    = time();
        $data['type_read']               = 0;
        $data['date_read']               = 0;

        app()->db->insert('portal_user_notifications',$data);

    }

}
##############################################################################


##############################################################################
if(!function_exists('Get_Notifications'))
{

    function Get_Notifications($notifications)
    {
        app()->load->database();

        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $query = app()->db->where($key,$value);
            }
        }

        app()->db->get('portal_user_notifications');
        return $query;
    }

}
##############################################################################


##############################################################################
if(!function_exists('Read_Notifications'))
{

    function Read_Notifications($Notification_id, $userid)
    {
        app()->load->database();

        $data['userid']    = $userid;
        $data['type_read'] = 1;
        $data['date_read'] = time();

        app()->db->where('notifications_id',$Notification_id);
        app()->db->update('portal_user_notifications');

    }

}
##############################################################################


##############################################################################
if(!function_exists('Create_Email_Notifications'))
{

    function Create_Email_Notifications($Data_Email)
    {
        $localhosts = array(
            '::1',
            '127.0.0.1',
            'localhost'
        );

        $protocol = 'mail';

        if (in_array($_SERVER['REMOTE_ADDR'], $localhosts)) {
            $protocol = 'smtp';
        }

        $config = array(
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'wordwrap'  => TRUE,
            'protocol'  => $protocol,
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smpt_timeout' => '30',
            'smtp_user' => 'hamedalfahad@gmail.com',
            'smtp_pass' => 'hamedSAAD@202020',
            'starttls'  => true,
            'newline'   => "\r\n",
        );

        app()->load->library('email',$config);

        app()->email->clear();
        app()->email->to($Data_Email['to']);
        app()->email->from($Data_Email['from']);
        app()->email->set_mailtype("html");
        app()->email->set_newline("\r\n");
        app()->email->set_crlf("\r\n");
        app()->email->subject($Data_Email['subject']);
        app()->email->message($Data_Email['message']);

        if(isset($Data_Email['attach']))
        {
            app()->email->attach($Data_Email['attach']);
        }

        $send = app()->email->send();

        if($send){

            $data_send['company_id']  = app()->aauth->get_user()->company_id;
            $data_send['Send_Type']   = 'Email';
            $data_send['Send_Time']   = time();
            $data_send['Send_Text']   = $Data_Email['message'];
            $data_send['Send_Byid']   = app()->aauth->get_user()->id;
            $data_send['Send_Status'] = 'Done';
            app()->db->insert('protal_send_mail_sms_messages',$data_send);

            return true;
        }else{
            return false;
        }

    }

}
##############################################################################




##############################################################################
if(!function_exists('Get_Sms_Email_Messages')) {

    function Get_Sms_Email_Messages($where_extra = '')
    {

        if(isset($where_extra)){
            foreach ($where_extra as $key => $value){
                $query = app()->db->where($key,$value);
            }
        }

        $query = app()->db->get('protal_mail_sms_messages');

        return $query;

    }

}
##############################################################################

##############################################################################
if(!function_exists('Create_Sms_Email_Messages')) {

    function Create_Sms_Email_Messages($data)
    {

        $query = app()->db->insert('protal_mail_sms_messages',$data);

        if($query){
            return true;
        }else{
            return false;
        }

    }

}
##############################################################################


##############################################################################
if(!function_exists('Send_Sms')) {

    function Send_Sms($Messages,$phone)
    {
        $data_send['company_id']  = app()->aauth->get_user()->company_id;
        $data_send['Send_Type']   = 'SMS';
        $data_send['Send_Time']   = time();
        $data_send['Send_Text']   = $Messages;
        $data_send['Send_Byid']   = app()->aauth->get_user()->id;
        $data_send['Send_Status'] = 'Done';
        $query = app()->db->insert('protal_send_mail_sms_messages',$data_send);

        if($query){
            return true;
        }else{
            return false;
        }
    }

}
##############################################################################
