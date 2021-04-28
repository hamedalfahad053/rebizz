<?php


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


?>

