<?php

##############################################################################
if(!function_exists('Get_Transaction')) {

    function Get_Transaction($where)
    {

        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $query = app()->db->where($key,$value);
            }
        }

        $query= app()->db->get('protal_transaction');

        return $query;

    }

} // if(!function_exists('Create_Transaction'))
##############################################################################

##############################################################################
if(!function_exists('Get_Transaction_data')) {

    function Get_Transaction_data($where)
    {

        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $query = app()->db->where($key,$value);
            }
        }

        $query= app()->db->get('protal_transaction_data');

        return $query;

    }

} // if(!function_exists('Create_Transaction'))
##############################################################################

##############################################################################
if(!function_exists('Transaction_data_by_key')) {

    function Transaction_data_by_key($transaction_id,$key)
    {
        $query = app()->db->where('Transaction_id',$transaction_id);
        $query = app()->db->where('data_key',$key);
        $query = app()->db->get('protal_transaction_data')->row();
        return $query->data_value;
    }

} // if(!function_exists('Create_Transaction'))
##############################################################################

##############################################################################
if(!function_exists('Get_Transaction_files')) {

    function Get_Transaction_files($where)
    {
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $query = app()->db->where($key,$value);
            }
        }
        $query= app()->db->get('protal_transaction_files');
        return $query;
    }

} // if(!function_exists('Create_Transaction'))
##############################################################################

##############################################################################
if(!function_exists('Create_Transaction')) {

    function Create_Transaction($data)
    {
        $query = app()->db->insert('protal_transaction',$data);
        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }
    }

} // if(!function_exists('Create_Transaction'))
##############################################################################


##############################################################################
if(!function_exists('Create_Transaction_data')) {

    function Create_Transaction_data($Transaction_id,$data)
    {
        if(is_array($data)){
            $data_insert = array();
            foreach ($data AS $key => $value)
            {
                if($value !='') {
                    $data_insert = array(
                        "Transaction_id"   => $Transaction_id,
                        "data_key"         => $key,
                        "data_value"       => $value,
                        "data_Create_id"   => app()->aauth->get_user()->id,
                        "data_Create_time" => time(),
                    );
                }
                $query = app()->db->insert('protal_transaction_data',$data_insert);
            }
        }

        if($query){
            return true;
        }else{
            return false;
        }

    } // function

} // if(!function_exists('Create_Transaction_data'))
##############################################################################

##############################################################################
if(!function_exists('Create_Transaction_files')) {

    function Create_Transaction_files($data)
    {
        $query = app()->db->insert('protal_transaction_files',$data);

        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }

    }

} // if(!function_exists('Create_Transaction'))
##############################################################################


##############################################################################
if(!function_exists('Create_Transaction')) {

    function Create_Transaction_files($data)
    {
        $query = app()->db->insert('protal_transaction_files',$data);



    }

} // if(!function_exists('Create_Transaction'))
##############################################################################
