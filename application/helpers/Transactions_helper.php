<?php

##############################################################################
if(!function_exists('Get_Transactions_By_Company_id')) {

    function Get_Transactions_By_Company_id($Company_id,$location_id='',$INSTRUMENT_NUMBER)
    {
        $query_Get_Transactions = app()->db->where('company_id',$Company_id);

        if(!empty($location_id)){
            $query_Get_Transactions = app()->db->where('location_id',$location_id);
        }

        $query_Get_Transactions = app()->db->where('INSTRUMENT_NUMBER',$INSTRUMENT_NUMBER);
        $query_Get_Transactions = app()->db->get('protal_transaction');
        return $query_Get_Transactions;

    } // function

} // if(!function_exists('Get_Transactions_By_Company_id'))
##############################################################################

##############################################################################
if(!function_exists('Get_All_Transactions')) {

    function Get_All_Transactions($where)
    {

        foreach ($where AS $key => $value)
        {
            $query_Get_Transactions = app()->db->where($key,$value);
        }

        $query_Get_Transactions = app()->db->get('protal_transaction');

        return $query_Get_Transactions;

    } // function

} // if(!function_exists('Get_Transactions_By_Company_id'))
##############################################################################
