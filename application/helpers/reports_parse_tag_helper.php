<?php

##############################################################################
if(!function_exists('Replace_Tags_Reports_data_Transaction')) {

    function Replace_Tags_Reports_data_Transaction($Transaction_id)
    {
        app()->load->database();



    }

}
##############################################################################



/*
 *         $where_Transactions = array(
            "uuid"       => $Transaction_id,
            "company_id" => app()->aauth->get_user()->company_id
        );
        $Get_Transactions = Get_Transaction($where_Transactions)->row();


        $Get_All_Data_Transaction = app()->db->where('company_id', app()->aauth->get_user()->company_id);
        $Get_All_Data_Transaction = app()->db->where('Transaction_id', $Get_Transactions->transaction_id);
        $Get_All_Data_Transaction = app()->db->get('protal_transaction_data');

        foreach ($Get_All_Data_Transaction->result() as $R_D) {

            $Fields_Components = Query_Fields_Components(
                array("Forms_id"      => $R_D->Forms_id,
                      "Components_id" => $R_D->Components_id,
                      "Fields_key"    => $R_D->data_key)
                )->row();

            if ($Fields_Components->Fields_Type == 'Fields') {

                $data_array_Data_Transaction_A['{' . $R_D->data_key . '}'] = $R_D->data_value;

            } elseif ($Fields_Components->Fields_Type == 'List') {

                $data_q    = Transaction_data_by_key($Get_Transactions->transaction_id, $R_D->Forms_id, $R_D->Components_id, $R_D->data_key);
                $data_list = get_data_options_List_view($Fields_Components->Fields_id, $data_q);

                $data_array_Data_Transaction_B['{' . $R_D->data_key . '}'] = $data_list;

            }

        } // foreach ($Get_All_Data_Transaction->result() AS $R_D)



 */