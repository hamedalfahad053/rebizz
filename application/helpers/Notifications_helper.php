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












