<?php
##############################################################################
if(!function_exists('Create_Stages_Self_Construction')) {

    function Create_Stages_Self_Construction($data)
    {
        $query = app()->db->insert('portal_app_client_stages_of_self_construction',$data);
        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }
    }
}
##############################################################################


##############################################################################
if(!function_exists('Get_Stages_Self_Construction')) {

    function Get_Stages_Self_Construction($where)
    {

        app()->load->database();
        $lang   = get_current_lang();
        $query  = app()->db->from('portal_app_client_stages_of_self_construction stages_self_construction');
        $query  = app()->db->join('portal_app_client_stages_of_self_construction_translation stages_self_construction_translation', 'stages_self_construction.stages_self_id = stages_self_construction_translation.item_id ');


        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $query = app()->db->where($key,$value);
            }
        }
        $query = app()->db->where('stages_self_construction_translation.translation_lang', $lang);
        $query = app()->db->get();
        return  $query;
    }
}
##############################################################################


##############################################################################
if(!function_exists('Update_Stages_Self_Construction')) {

    function Update_Stages_Self_Construction($stages_self_uuid,$clients_id,$status)
    {

        app()->load->database();
        $query = app()->db->where('stages_self_uuid',$stages_self_uuid);
        $query = app()->db->where('clients_id',$clients_id);
        $query = app()->db->where('company_id',app()->aauth->get_user()->company_id);
        $query = app()->db->set('stages_self_status',$status);
        $query = app()->db->set('stages_self_modified_by',app()->aauth->get_user()->id);
        $query = app()->db->set('stages_self_last_modify_date',time());
        $query = app()->db->update('portal_app_client_stages_of_self_construction');
        if($query){
            return true;
        }else{
            return false;
        }

    }

}
##############################################################################