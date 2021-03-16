<?php

##############################################################################
if(!function_exists('Get_Client_Company'))
{

    function Get_Client_Company($where_extra)
    {
        app()->load->database();

        if(!empty($where_extra)){
            foreach ($where_extra AS $key => $value)
            {
                $query = app()->db->where($key,$value);
            }
        }
        $query = app()->db->get('portal_app_client');
        return $query;
    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_Client_Contract_Company'))
{
    function Get_Client_Contract_Company($where_extra)
    {
        app()->load->database();

        if(!empty($where_extra)){
            foreach ($where_extra AS $key => $value)
            {
                $query = app()->db->where('fields.'.$key,$value);
            }
        }
        $query = app()->db->get('portal_app_client_contract');

        return $query;
    }
}
##############################################################################

##############################################################################
if(!function_exists('Get_Client_Logo'))
{
    function Get_Client_Logo($Path_Folder,$Company_id,$Client_id)
    {
        app()->load->database();

        $logo = '';

        $query = app()->db->where('client_id',$Client_id);
        $query = app()->db->where('company_id',$Company_id);
        $query = app()->db->get('portal_app_client');

        //_array_p(app()->db->error());

            if($query->num_rows()>0){

                $query->row();

                if($query->logo == ''){
                    $logo = LOGO_DEFAULT_CLIENT;
                }else{
                    $logo = $Path_Folder.'/'.FOLDER_FILE_Company_client_logo.'/'.$query->logo;
                }

            }else{
                $logo = LOGO_DEFAULT_CLIENT;
            }



        return $logo;
    }
}
##############################################################################
?>