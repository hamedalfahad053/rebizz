<?php

##############################################################################
if(!function_exists('Cleaning_Transaction_Numbering')) {

    function Cleaning_Transaction_Numbering()
    {
        $time_space = time()+1*60;

//        app()->db->where('Transaction_Status_id',46);
//        app()->db->where('Create_Transaction_Date',$time_space);
//        $query2 = app()->db->delete('protal_transaction');
    }

}
##############################################################################

##############################################################################
if(!function_exists('Create_Transaction_Numbering')) {

    function Create_Transaction_Numbering()
    {

        $data_Transaction = array();

        $data_Transaction['transaction_number']        = date('Ymd');
        $data_Transaction['Create_Transaction_Date']   = time();
        $data_Transaction['Create_Transaction_By_id']  = app()->aauth->get_user()->id;
        $data_Transaction['company_id']                = Get_Company_User(app()->aauth->get_user()->id)->companies_id;
        $data_Transaction['location_id']               = Get_Company_User(app()->aauth->get_user()->id)->locations_id;
        $data_Transaction['Transaction_Status_id']     = 46;

        $query     = app()->db->insert('protal_transaction',$data_Transaction);
        $insert_id = app()->db->insert_id();

        if($insert_id){

            $query2 = app()->db->get('protal_transaction',array('transaction_id',$insert_id))->row();
            app()->db->where('transaction_id',$insert_id);

            $transaction_number_ = $query2->transaction_number.'-'.$insert_id;

            $query3 = app()->db->update('protal_transaction',array("transaction_number" => $transaction_number_ ));
        }

        $query4 = app()->db->get('protal_transaction',array('transaction_id',$insert_id))->row();



        return $query4;
    }
}
##############################################################################

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
