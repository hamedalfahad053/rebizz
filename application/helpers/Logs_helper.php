<?php

##############################################################################
if(!function_exists('insert_online_current_user')) {

    function insert_online_current_user($Locations_text)
    {
            app()->load->database();
            app()->load->library('user_agent');

            app()->db->where('Userid', app()->aauth->get_user()->id);
            app()->db->delete('protal_online_users_system');

            if(app()->agent->mobile()==true){
                $mobile = '1';
            }else{
                $mobile = '0';
            }


            $data = array(
                'mobile'                => $mobile,
                'browser'               => app()->agent->browser(),
                'browser_version'       => app()->agent->version(),
                'platform'              => app()->agent->platform(),
                'ip_address'            => app()->input->ip_address(),
                'SERVER_PROTOCOL'       => app()->input->server('SERVER_PROTOCOL'),
                'REQUEST_URI'           => app()->input->server('REQUEST_URI'),
                'REQUEST_METHOD'        => app()->input->method(),
                'Userid'                => app()->aauth->get_user()->id,
                'Company_id'            => app()->aauth->get_user()->company_id,
                'Locations_text'        => $Locations_text,
                'Time_Activity'         => time()
            );

            app()->db->insert('protal_online_users_system',$data);
    }

}
##############################################################################

##############################################################################
if(!function_exists('time_elapsed_string')) {

    function time_elapsed_string($ptime)
    {
        $etime = time() - $ptime;

        if ($etime < 1)
        {
            return '0 seconds';
        }

        $a = array( 365 * 24 * 60 * 60  =>  'year',
            30 * 24 * 60 * 60  =>  'month',
            24 * 60 * 60  =>  'day',
            60 * 60  =>  'hour',
            60  =>  'minute',
            1  =>  'second'
        );
        $a_plural = array( 'year'   => 'years',
            'month'  => 'months',
            'day'    => 'days',
            'hour'   => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        );

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }
    }
}
##############################################################################

##############################################################################
if(!function_exists('Get_online_current_user')) {

    function Get_online_current_user($where_extra = '')
    {
        app()->load->database();
        if(!empty($where_extra)) {
            foreach ($where_extra AS $key => $value)
            {
                $query = app()->db->where($key,$value);
            }
        }
        $query = app()->db->get('protal_online_users_system');
        return $query;
    }
}
##############################################################################


##############################################################################
if(!function_exists('Get_Logs_User')) {

    function Get_Logs_User($Action_Userid)
    {


    }

}
##############################################################################

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
















