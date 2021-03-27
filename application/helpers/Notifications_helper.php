<?php


##############################################################################
if(!function_exists('Create_Notifications'))
{

    function Create_Notifications($userid, $action, $massage)
    {
        app()->load->database();

        $data['userid']    = $userid;
        $data['action']    = $action;
        $data['massage']   = $massage;
        $data['time']      = time();
        $data['type_read'] = 0;
        $data['date_read'] = 0;

        app()->db->insert('portal_user_notifications',$data);

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

        app()->db->where('Notification_id',$Notification_id);
        app()->db->update('portal_user_notifications');

    }

}
##############################################################################












