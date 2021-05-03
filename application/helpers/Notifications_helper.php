<?php


##############################################################################
if(!function_exists('Create_Notifications'))
{

    function Create_Notifications($notifications)
    {
        app()->load->database();

        $data['userid']                  = $notifications['notifications_to_user'];
        $data['notifications_type']      = $notifications['notifications_type'];
        $data['notifications_title']     = $notifications['notifications_title'];
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

    function _Notifications($Notification_id, $userid)
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
        $send = app()->email->send();

        if($send){
            return true;
        }else{
            return false;
        }

    }

}
##############################################################################








