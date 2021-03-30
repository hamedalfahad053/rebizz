<?php
defined('BASEPATH') OR exit('No direct script access allowed');

##############################################################################
if(!function_exists('Get_Departments'))
{

    function Get_Departments($where_extra = '')
    {
        app()->load->database();
        $lang   = get_current_lang();
        $query  = app()->db->from('portal_hrm_departments departments');
        $query  = app()->db->join('portal_hrm_departments_translation departments_translation', 'departments_translation.item_id = departments.departments_id');
        if(!empty($where_extra)){

            foreach ($where_extra AS $key => $value)
            {
                $query = app()->db->where($key,$value);
            }
        }
        $query = app()->db->where('departments_translation.translation_lang', $lang);
        $query = app()->db->get();
        return $query;
    }
}
##############################################################################

##############################################################################
if(!function_exists('Create_Departments'))
{

    function Create_Departments($data)
    {
        app()->load->database();
        $query = app()->db->insert('portal_hrm_departments',$data);
        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }
    }

}
##############################################################################

##############################################################################
if(!function_exists('Update_Supervisor_Departments'))
{
    function Update_Supervisor_Departments($id,$company_id,$supervisor)
    {
        app()->load->database();
        $query = app()->db->where('departments_id',$id);
        $query = app()->db->where('company_id',$company_id);
        $query = app()->db->set('departments_lastModifyDate',time());
        $query = app()->db->set('department_supervisor',$supervisor);
        $query = app()->db->update('portal_hrm_departments');

        if($query){
            return true;
        }else{
            return false;
        }

    }
}
##############################################################################


##############################################################################
if(!function_exists('Update_Departments_status'))
{
    function Update_Departments_status($uuid,$company_id,$status)
    {
        app()->load->database();
        $query = app()->db->where('departments_uuid',$uuid);
        $query = app()->db->where('company_id',$company_id);
        $query = app()->db->set('departments_lastModifyDate',time());
        $query = app()->db->set('departments_status',$status);
        $query = app()->db->update('portal_hrm_departments');

        if($query){
            return true;
        }else{
            return false;
        }

    }
}
##############################################################################














