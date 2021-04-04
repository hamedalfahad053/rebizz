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
        $query = app()->db->order_by('transaction_id', 'DESC');
        $query = app()->db->get('protal_transaction');
        return $query;

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
        $query = app()->db->get('protal_transaction_files');

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

    function Transaction_data_by_key($transaction_id,$Forms_id,$Components_id,$key)
    {
        $query = app()->db->where('Transaction_id',$transaction_id);
        $query = app()->db->where('Forms_id',$Forms_id);
        $query = app()->db->where('Components_id',$Components_id);
        $query = app()->db->where('data_key',$key);
        $query = app()->db->get('protal_transaction_data');
        if($query->num_rows()>0){
            return $query->row()->data_value;
        }else{
            return false;
        }

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


            foreach ($data AS $key)
            {
                if($key['data_value'] !='') {
                    $data_insert = array(
                        "Transaction_id"   => $Transaction_id,
                        "Forms_id"         => $key['Forms_id'],
                        "Components_id"    => $key['Components_id'],
                        "data_key"         => $key['data_key'],
                        "data_value"       => $key['data_value'],
                        "company_id"       => app()->aauth->get_user()->company_id,
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
if(!function_exists('Create_Transaction_data_history')) {

    function Create_Transaction_data_history($Transaction_id,$data,$History)
    {
        if(is_array($data)){
            $data_insert = array();
            foreach ($data AS $key)
            {
                if($key['data_value'] !='') {
                    $data_insert = array(
                        "Transaction_id"   => $Transaction_id,
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
                $query = app()->db->insert('protal_transaction_data_history',$data_insert);
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

########################################################################
if(!function_exists('Create_Transaction_Assign')) {

    function Create_Transaction_Assign($data)
    {
        $query = app()->db->insert('protal_transaction_assign',$data);

        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }
    }

}
########################################################################

########################################################################
if(!function_exists('Get_Transaction_Assign')) {

    function Get_Transaction_Assign($where)
    {
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $query = app()->db->where($key,$value);
            }
        }
        $query= app()->db->get('protal_transaction_assign');
        return $query;
    }

}
########################################################################

##############################################################################
if(!function_exists('Get_Stages_Transaction_Company')) {

    function Get_Stages_Transaction_Company($where)
    {
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $query = app()->db->where($key,$value);
            }
        }

        $query= app()->db->get('protal_stages_transaction');
        return $query;
    }

} // Get_Stages_Transaction_Company($where)
##############################################################################


########################################################################
if(!function_exists('insert_Stages_Transaction')) {

    function insert_Stages_Transaction($company_id,$stages_key,$Departments_To,$attribution_method)
    {
        app()->load->database();

        $data_Stages['company_id']         = $company_id;
        $data_Stages['stages_key']         = $stages_key;
        $data_Stages['Departments_To']     = $Departments_To;
        $data_Stages['attribution_method'] = $attribution_method;
        $data_Stages['stages_createBy']    = app()->aauth->get_user()->id;
        $data_Stages['stages_createDate']  = time();
        $query = app()->db->insert('protal_stages_transaction',$data_Stages);
        if($query){
            return true;
        }else{
            return false;
        }

    }
}
########################################################################

########################################################################
if(!function_exists('clear_Stages_Transaction')) {

    function clear_Stages_Transaction($company_id, $stages_key)
    {
        app()->load->database();
        $query = app()->db->where('stages_key',$stages_key);
        $query = app()->db->where('company_id',$company_id);
        $query = app()->db->delete('protal_stages_transaction');
        if($query){
            return true;
        }else{
            return false;
        }

    }
}
########################################################################

########################################################################
if(!function_exists('Update_Stages_Transaction')) {

    function Update_Stages_Transaction($company_id,$stages_key,$Departments_To,$attribution_method)
    {
        app()->load->database();
        $query = app()->db->where('stages_key',$stages_key);
        $query = app()->db->where('company_id',$company_id);
        $query = app()->db->set('Departments_To',$Departments_To);
        $query = app()->db->set('attribution_method',$attribution_method);
        $query = app()->db->set('stages_lastModifyDate',time());
        $query = app()->db->update('protal_stages_transaction');
        if($query){
            return true;
        }else{
            return false;
        }

    }
}
########################################################################


##############################################################################
if(!function_exists('Assignment_Transaction_Departments_To')) {

    function Assignment_Transaction_Departments_To($where)
    {

        $Assignment_to = array();

        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $stages_t = app()->db->where($key,$value);
            }
        }
        $stages_t      = app()->db->get('protal_stages_transaction')->row();

        if($stages_t->attribution_method == 1){

            $Departments_Where = array("company_id"=> app()->aauth->get_user()->company_id , "departments_id"=>$stages_t->Departments_To);
            $Departments       = app()->db->get('portal_hrm_departments',$Departments_Where);

            if($Departments->num_rows()>0){
                $Departments = $Departments->row();
                if($Departments->department_supervisor != NULL or $Departments->department_supervisor !=0){
                    $Assignment_to = array(
                        "userid"   => app()->aauth->get_user($Departments->department_supervisor)->id,
                        "full_name" => app()->aauth->get_user($Departments->department_supervisor)->id,
                    );
                }else{
                    $Assignment_to = false;
                }
            }

        }elseif ($stages_t->attribution_method == 2){

            $Departments_Where = array("company_id"=> app()->aauth->get_user()->company_id , "departments_id"=>$stages_t->Departments_To);
            $Departments       = app()->db->get('portal_hrm_departments',$Departments_Where);

            $where_emp_Departments  = array("users.company_id"=> app()->aauth->get_user()->company_id ,"users.departments_id"=>$stages_t->Departments_To,"banned"=>0);
            $emp_Departments        = Get_Company_Users($where_emp_Departments);

            if($emp_Departments->num_rows()>0)
            {
                foreach ($emp_Departments->result() as $user)
                {
                    $where_Get_Assignment_Num = array(
                      "Transaction_Stage"     => $stages_t->stages_key,
                      "Transaction_Status_id" => 1,
                      "Assignment_userid"     => $user->id,
                    );
                    $Get_Assignment_Num = Get_Transaction($where_Get_Assignment_Num)->num_rows();
                    $Assignment_to[] = array(
                        "userid"          => $user->id,
                        "full_name"       => $user->full_name,
                        "Assignment_Num"  => $Get_Assignment_Num
                    );
                }

            }else{
                $Assignment_to = false;
            }


        } // attribution_method


        return $Assignment_to;
    }

} // Get_Stages_Transaction_Company($where)
##############################################################################


