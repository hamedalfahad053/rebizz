<?php


##############################################################################
if(!function_exists('Create_Logs_User'))
{

    function Create_Logs_User($Action_text,$Action_ID='',$Action_Section,$Action_Type)
    {
        app()->load->database();

        app()->load->library('user_agent');

        if(app()->agent->mobile()==true){
            $mobile = '1';
        }else{
            $mobile = '0';
        }

        if(app()->agent->robot()==true){
            $robot = '1';
        }else{
            $robot = '0';
        }

        $data = array(
            'browser'               => app()->agent->browser(),
            'browser_version'       => app()->agent->version(),
            'mobile'                => $mobile,
            'robot'                 => $robot,
            'platform'              => app()->agent->platform(),
            'referrer'              => app()->agent->referrer(),
            'agent_string'          => app()->agent->agent_string(),
            'page_url'              => base_url(uri_string()),
            'ip_address'            => app()->input->ip_address(),
            'SERVER_PROTOCOL'       => app()->input->server('SERVER_PROTOCOL'),
            'REQUEST_URI'           => app()->input->server('REQUEST_URI'),
            'REQUEST_METHOD'        => app()->input->method(),
            'Action_Section'        => $Action_Section,
            'Action_ID'             => $Action_ID,
            'Action_Userid'         => app()->aauth->get_user()->id,
            'Action_Type'           => $Action_Type,
            'Action_text'           => $Action_text,
            'Time_Activity'         => time()
        );

        app()->db->insert('protal_log_system',$data);

    }

}
##############################################################################
















