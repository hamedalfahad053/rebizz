<?php


##############################################################################
if(!function_exists('Update_Assignment_Map_users_preview')) {

    function Update_Assignment_Map_users_preview($Users_Preview,$Region_id,$City_id,$districts)
    {
        $Update  = app()->db->where('users_preview_id',$Users_Preview);
        $Update  = app()->db->get('protal_users_preview_map');

        if($Update->num_rows()>0){

            $query = app()->db->where('users_preview_id',$Users_Preview);
            $query = app()->db->set('regions_id',$Region_id);
            $query = app()->db->set('city_id',$City_id);
            $query = app()->db->set('districts',$districts);
            $query = app()->db->update('protal_users_preview_map');

        }else{
            $data_Preview = array();
            $data_Preview['users_preview_id']     = $Users_Preview;
            $data_Preview['regions_id']           = $Region_id;
            $data_Preview['city_id']              = $City_id;
            $data_Preview['districts']            = $districts;
            $data_Preview['company_id']           = app()->aauth->get_user()->company_id;
            $query = app()->db->insert('protal_users_preview_map',$data_Preview);
        }

        if($query){
            return true;
        }else{
            return false;
        }

    }
}
##############################################################################

##############################################################################
if(!function_exists('Get_Assignment_Map_users_preview')) {

    function Get_Assignment_Map_users_preview($where)
    {
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $query = app()->db->where($key,$value);
            }
        }

        $query    = app()->db->get('protal_users_preview_map');

        return  $query;

    }
}
##############################################################################

##############################################################################
if(!function_exists('Create_Preview_Visit')) {

    function Create_Preview_Visit($data)
    {
        $query = app()->db->insert('protal_transaction_coordination',$data);
        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }
    }
}
##############################################################################

##############################################################################
if(!function_exists('Get_Preview_Visit')) {

    function Get_Preview_Visit($where)
    {
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $query = app()->db->where($key,$value);
            }
        }
        app()->db->order_by('Coordination_id', 'DESC');
        $query  = app()->db->get('protal_transaction_coordination');
        return  $query;

    }
}
##############################################################################

##############################################################################
if(!function_exists('Create_Preview_Visit_FeedBack')) {

    function Create_Preview_Visit_FeedBack($data)
    {
        $query = app()->db->insert('protal_users_preview_feedback',$data);
        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }
    }
}
##############################################################################


##############################################################################
if(!function_exists('Get_Preview_Visit_FeedBack')) {

    function Get_Preview_Visit_FeedBack($where)
    {
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $query = app()->db->where($key,$value);
            }
        }
        $query  = app()->db->get('protal_users_preview_feedback');
        return  $query;

    }
}
##############################################################################







##############################################################################
if(!function_exists('Create_Transaction_Preview_data')) {
    function Create_Transaction_Preview_data($Transaction_id,$data)
    {
        if(is_array($data)){
            $data_insert = array();
            foreach ($data AS $key)
            {
                if($key['data_value'] !='') {
                    $data_insert = array(
                        "Transaction_id"   => $Transaction_id,
                        "preview_id"       => $key['preview_id'],
                        "Forms_id"         => $key['Forms_id'],
                        "Components_id"    => $key['Components_id'],
                        "data_key"         => $key['data_key'],
                        "data_value"       => $key['data_value'],
                        "company_id"       => app()->aauth->get_user()->company_id,
                        "data_Create_id"   => app()->aauth->get_user()->id,
                        "data_Create_time" => time(),
                    );
                }
                $query = app()->db->insert('protal_transaction_preview_data',$data_insert);
            }
        }
        if($query){
            return true;
        }else{
            return false;
        }
    } // function
} //
##############################################################################

##############################################################################
if(!function_exists('Get_Transaction_Preview_data_by_key')) {

    function Get_Transaction_Preview_data_by_key($transaction_id,$Forms_id,$Components_id,$key)
    {
        $query = app()->db->where('Transaction_id',$transaction_id);
        $query = app()->db->where('Forms_id',$Forms_id);
        $query = app()->db->where('Components_id',$Components_id);
        $query = app()->db->where('data_key',$key);
        $query = app()->db->get('protal_transaction_preview_data');

        if($query->num_rows()>0){
            return $query->row()->data_value;
        }else{
            return false;
        }

    }

} // if(!function_exists('Create_Transaction'))
##############################################################################

##############################################################################
if(!function_exists('Create_Transaction_Preview_history')) {

    function Create_Transaction_Preview_history($Transaction_id,$data,$History)
    {
        if(is_array($data)){
            $data_insert = array();
            foreach ($data AS $key)
            {
                if($key['data_value'] !='') {

                    $data_insert = array(
                        "Transaction_id"   => $Transaction_id,
                        "preview_id"       => $key['preview_id'],
                        "Forms_id"         => $key['Forms_id'],
                        "Components_id"    => $key['Components_id'],
                        "data_key"         => $key['data_key'],
                        "data_value"       => $key['data_value'],
                        "History"          => $History,
                        "company_id"       => app()->aauth->get_user()->company_id,
                        "data_Create_id"   => app()->aauth->get_user()->id,
                        "data_Create_time" => time(),
                    );

                }
                $query = app()->db->insert('protal_transaction_preview_data_history',$data_insert);
            }
        }
        if($query){
            return true;
        }else{
            return false;
        }
    } // function
}
##############################################################################


##############################################################################
if(!function_exists('Create_Comparisons_Land')) {

    function Create_Comparisons_Land($data)
    {
        $query = app()->db->insert('portal_comparisons_info',$data);
        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }
    }

} // if(!function_exists('Create_Transaction'))
##############################################################################

##############################################################################
if(!function_exists('Get_Comparisons_Land')) {

    function Get_Comparisons_Land($where)
    {
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $query = app()->db->where($key,$value);
            }
        }
        $query  = app()->db->get('portal_comparisons_info');
        return  $query;
    }
}
##############################################################################