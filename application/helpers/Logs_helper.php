<?php


##############################################################################
if(!function_exists('Create_Logs'))
{

    function Create_Logs($Action_text)
    {
        app()->load->database();

        $data = array();

        app()->load->library('user_agent');

        $user = app()->aauth->get_user();


        if(!$user){
            $Type_user = 'Visitor';
            $user_id   = 0;
        }else{
            $Type_user = 'User';
            $user_id   = $user->id;
        }

        if(app()->agent->mobile()==true){
            $mobile = 'true';
        }else{
            $mobile = 'false';
        }

        if(app()->agent->robot()==true){
            $robot = 'true';
        }else{
            $robot = 'false';
        }


        $data['Type_user']       = $Type_user;
        $data['user_id']         = $user_id;
        $data['browser']         = app()->agent->browser();
        $data['browser_version'] = app()->agent->version();
        $data['mobile']          = $mobile;
        $data['robot']           = $robot;
        $data['platform']        = app()->agent->platform();
        $data['referrer']        = app()->agent->referrer();
        $data['agent_string']    = app()->agent->agent_string();
        $data['page_url']        = base_url(uri_string());
        $data['ip_address']      = app()->input->ip_address();
        $data['SERVER_PROTOCOL'] = app()->input->server('SERVER_PROTOCOL');
        $data['REQUEST_URI']     = app()->input->server('REQUEST_URI');
        $data['REQUEST_METHOD']  = app()->input->method();
        $data['Request_Headers'] = app()->input->request_headers();
        $data['Action_text']     = $Action_text;
        $data['Time_Activity']   = time();


    }

}
##############################################################################
















