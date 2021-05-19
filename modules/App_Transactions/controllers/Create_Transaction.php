<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_Transaction extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = '';
    }
    ###################################################################


    # Done :: Checking Transaction
    ###################################################################
    public function index()
    {
        $this->data['Page_Title']     = 'الاستعلام ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Transactions'));




        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Checking_Transaction/Checking_Transaction', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    # Done
    ###################################################################
    public function Query_Ajax_Transaction()
    {

        $INSTRUMENT_NUMBER                = $this->input->get('INSTRUMENT_NUMBER',true);
        $COMMISSIONING_NUMBER             = $this->input->get('COMMISSIONING_NUMBER',true);
        $OWNER_APPLICANT_IDENTITY_NUMBER  = $this->input->get('OWNER_APPLICANT_IDENTITY_NUMBER',true);

        $company_id = $this->aauth->get_user()->company_id;

        $Transaction_data   = array();
        $msg                = array();


        $send_data_button = array(
            "INSTRUMENT_NUMBER"    => $INSTRUMENT_NUMBER,
            "COMMISSIONING_NUMBER" => $COMMISSIONING_NUMBER
        );


        if(!empty($INSTRUMENT_NUMBER) or !empty($COMMISSIONING_NUMBER) or !empty($OWNER_APPLICANT_IDENTITY_NUMBER)) {

            if ($INSTRUMENT_NUMBER) {
                $Get_Transaction_data = $this->db->where(" ( FIND_IN_SET('INSTRUMENT_NUMBER',data_key) AND FIND_IN_SET(" . $INSTRUMENT_NUMBER . ",data_value) AND `company_id` = (" . $this->aauth->get_user()->company_id . ")  ) ");
            }

            if ($COMMISSIONING_NUMBER) {
                $Get_Transaction_data = $this->db->or_where(" ( FIND_IN_SET('COMMISSIONING_NUMBER',data_key) AND FIND_IN_SET(" . $COMMISSIONING_NUMBER . ",data_value) AND `company_id` = (" . $this->aauth->get_user()->company_id . ")  ) ");
            }

            if ($OWNER_APPLICANT_IDENTITY_NUMBER) {
                $Get_Transaction_data = $this->db->or_where(" ( FIND_IN_SET('OWNER_APPLICANT_IDENTITY_NUMBER',data_key) AND FIND_IN_SET(" . $OWNER_APPLICANT_IDENTITY_NUMBER . ",data_value) AND `company_id` = (" . $this->aauth->get_user()->company_id . ")  ) ");
            }

            $Get_Transaction_data = $this->db->get('protal_transaction_data');

            if ($Get_Transaction_data->num_rows() > 0) {

                $where_Transactions = array(
                    "company_id" => $this->aauth->get_user()->company_id,
                    "transaction_id" => $Get_Transaction_data->row()->Transaction_id
                );

                $Get_Transactions = Get_Transaction($where_Transactions);

                if ($Get_Transactions->num_rows() > 0) {

                    foreach ($Get_Transactions->result() as $R) {

                        $Transaction_data[] = array(
                            "transaction_id"            => $R->transaction_id,
                            "transaction_number"        => $R->transaction_number,
                            "transaction_uuid"          => $R->uuid,
                            "Transaction_Stage"         => $R->Transaction_Stage,
                            "Transaction_Status_id"     => $R->Transaction_Status_id,
                            "Create_Transaction_By_id"  => $R->Create_Transaction_By_id,
                            "Assignment_userid"         => $R->Assignment_userid,
                            "Create_Transaction_Date"   => $R->Create_Transaction_Date
                        );

                    } // foreach ($where_Transactions_data->result() AS $R )

                    $data_x['Transaction_data'] = $Transaction_data;

                    $msg['success'] = true;
                    $msg['Transaction_Table'] = $this->load->view("../../modules/App_Transactions/views/Checking_Transaction/Template_Instrument_Number_By_Transactions", $data_x, true);

                } else {

                    // Permissions Create Transaction
                    if(Check_Permissions(12) or Check_Permissions(9)) {
                        $Transaction_Table = Create_Status_Alert(array("key" => "Success", "value" => "لا يوجد معاملات مضافة  متطابقة مع المدخلات يمكنك الاستمرار "));
                    }

                    $Transaction_Table .= $this->load->view("../../modules/App_Transactions/views/Checking_Transaction/Button_Create_Transaction",$send_data_button, true);
                    $msg['success']    = true;
                    $msg['Transaction_Table'] = $Transaction_Table;

                }

            } else {
                $Transaction_Table  = Create_Status_Alert(array("key" => "Success", "value" => "لا يوجد معاملات مضافة  متطابقة مع المدخلات يمكنك الاستمرار "));
                $Transaction_Table .= $this->load->view("../../modules/App_Transactions/views/Checking_Transaction/Button_Create_Transaction",$send_data_button, true);

                $msg['success']           = true;
                $msg['Transaction_Table'] = $Transaction_Table;

            } // if($where_Transactions_data->num_rows()>0)
        }
        $msg['success'] = true;

        Create_Logs_User(implode(",",$_GET),'','Transaction','Query_Transaction');

        echo json_encode($msg);

    }
    ###################################################################
    # End :: Checking Transaction

    # DONE Create Transaction
    ###################################################################
    public function Create()
    {

        if(!Check_Permissions(12) or !Check_Permissions(9)) {

        }

        $this->data['Page_Title']     = 'استلام طلب جديد';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Transactions'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Create_Transaction/Create_Transaction', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    # DONE Create Transaction Submit
    ###################################################################
    public function Create_Submit()
    {

        $POST_Fields           = $_POST;
        $Form_id               = $this->input->post('Form_id');
        $data_Transaction      = array();
        $data_Transaction2     = array();
        $data_Transaction1     = array();
        $files_Transaction_ids = array();


        $files_Transaction_ids = @$_POST['files_Transaction_ids'];

        if(@$files_Transaction_ids){

        }else{
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'لا يمكن انشاء معاملة بدون مرفقات';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/Create_Transaction/Create', 'refresh');
            exit;
        }

        foreach($POST_Fields AS $key => $value)
        {

            //ignore $_POST
            if($key == 'Start_Form_Progresses' or $key == 'Assignment_userid' or $key =="ci_csrf_token" or $key =="Form_id" or $key =="FILE_Name" or $key =="FILE" or $key=='file_name' or $key=='LIST_TRANSACTION_DOCUMENTS'
                or $key =='files_Transaction_ids'){

            }else {

                $explode_Post = explode("-",$key);

                $Fields_Components = Query_Fields_Components(
                    array("Forms_id"=> $explode_Post[1], "Components_id" => $explode_Post[2],"Fields_key" => $explode_Post[0])
                );

                if ($Fields_Components->num_rows() > 0) {

                    $Get_validating_Fields         = Get_validating_Fields(array("Forms_id" => $Form_id,"Components_id" => $Fields_Components->row()->Components_id, "company_id" => 0, "Fields_id" => $Fields_Components->row()->Fields_id));


                    if ($Get_validating_Fields->num_rows() > 0) {

                        if($Fields_Components->row()->Fields_Type == 'Fields') {
                            $Get_Fields = Get_Fields(array("Fields_id" => $Fields_Components->row()->Fields_id))->row();
                            Building_form_validation($key, $Get_Fields->item_translation, $Get_validating_Fields->row()->validating_rules);
                        }elseif($Fields_Components->row()->Fields_Type == 'List') {
                            $Get_List = Get_All_List(array("list_id" => $Fields_Components->row()->Fields_id))->row();
                            Building_form_validation($key, $Get_List->item_translation, $Get_validating_Fields->row()->validating_rules);
                        }

                        if ($this->form_validation->run() == FALSE) {
                            $msg_result['key'] = 'Danger';
                            $msg_result['value'] = validation_errors();
                            $msg_result_view = Create_Status_Alert($msg_result);
                            set_message($msg_result_view);
                            redirect(APP_NAMESPACE_URL . '/Transactions/Create_Transaction/Create', 'refresh');
                        }else {
                            $data_Transaction1[] = array(
                                "data_key"      => $explode_Post[0],
                                "data_value"    => $this->input->post($key, TRUE),
                                "Forms_id"      => $Form_id,
                                "Components_id" => $explode_Post[2]
                            );
                        }

                    }else{
                        $data_Transaction2[] = array(
                            "data_key"      => $explode_Post[0],
                            "data_value"    => $this->input->post($key, TRUE),
                            "Forms_id"      => $Form_id,
                            "Components_id" => $explode_Post[2]
                        );
                    } // if ($Get_validating_Fields->num_rows() > 0)

                } // if($Fields_Components->num_rows()>0)

            } // ignore $_POST

        } // foreach ($POST_Fields AS $field)


        $data_Transaction = array_merge($data_Transaction1,$data_Transaction2);
        ##########################################################################################################################################
        # START :: INSERT DB Transaction

        #-> Get Stages
        $where_Transaction_Stage = array("stages_key" => 'DATA_ENTRY', "company_id" => $this->aauth->get_user()->company_id);
        $Get_Stages              = Get_Stages_Transaction_Company($where_Transaction_Stage)->row();

        $data_Transaction_static['transaction_number']        = date('Ymd');
        $data_Transaction_static['company_id']                = $this->aauth->get_user()->company_id;
        $data_Transaction_static['location_id']               = $this->aauth->get_user()->locations_id;
        $data_Transaction_static['Transaction_Status_id']     = '194';
        $data_Transaction_static['Transaction_Stage']         = $Get_Stages->stages_key;
        $data_Transaction_static['Create_Transaction_By_id']  = $this->aauth->get_user()->id;
        $data_Transaction_static['Create_Transaction_Date']   = time();

        $Create_Transaction              = Create_Transaction($data_Transaction_static);
        $Create_Transaction_data         = Create_Transaction_data($Create_Transaction,$data_Transaction);
        $Create_Transaction_data_history = Create_Transaction_data_history($Create_Transaction,$data_Transaction,'Create');

        ##########################################################################################################################################
        # -> Assignment users
        $data_Transaction_Assign = array();
        $data_Transaction_Assign['transaction_id'] = $Create_Transaction;
        $data_Transaction_Assign['assign_userid']  = $this->input->post('Assignment_userid');
        $data_Transaction_Assign['assign_time']    = time();
        $data_Transaction_Assign['assign_type']    = 1;
        $Create_Transaction_Assign = Create_Transaction_Assign($data_Transaction_Assign);
        # END :: DB Transaction
        ##########################################################################################################################################

        // update file
        ##########################################################################################################################################
        if($Create_Transaction and $Create_Transaction_data){

            $files_Transaction_ids = $_POST['files_Transaction_ids'];
            foreach ($files_Transaction_ids AS $row_uuid)
            {
                app()->db->where('uuid',$row_uuid);
                app()->db->set('Transaction_id',$Create_Transaction);
                app()->db->update('protal_transaction_files');
            }


            if($this->input->post('LIST_TYPES_OF_REAL_ESTATE_APPRAISAL-1-1'))
            {
                $Get_clients_id        = $this->input->post('LIST_CLIENT-1-1');
                $where_Get_Stages_Self = array("clients_id" => $Get_clients_id, "company_id" => $this->aauth->get_user()->company_id);
                $Get_Stages_Self       = Get_Stages_Self_Construction($where_Get_Stages_Self);

                if($Get_Stages_Self->num_rows()>0){

                    $data_Stages_Self_Transaction = array();

                    foreach ($Get_Stages_Self->result() AS $GSS)
                    {
                        $data_Stages_Self_Transaction['transactions_id']     = $Create_Transaction;
                        $data_Stages_Self_Transaction['stages_self_number']  = $GSS->stages_self_id;
                        $data_Stages_Self_Transaction['stages_self_text']    = $GSS->stages_self_number;
                        $data_Stages_Self_Transaction['stages_self_rate']    = $GSS->stages_self_number;
                        $data_Stages_Self_Transaction['Completion_rate']     = $GSS->stages_self_Percentage;
                        $data_Stages_Self_Transaction['Previous_stage']      = 0;
                        app()->db->insert('portal_transaction_stages_self_construction',$data_Stages_Self_Transaction);
                    }
                }

            }


            $Assignment_userid   = $this->input->post('Assignment_userid');
            $Notifications_title = 'اسناد معاملة ';
            $Notifications_text  = 'تم اسناد معاملة اليك من خلال النظام ';
            Create_Notifications_Transaction($Create_Transaction,$Assignment_userid,$Notifications_title,$Notifications_text);

            Create_Logs_User('Create_Transaction',$Create_Transaction,'Transaction','Create');

            # Time Progresses
            $start_form       = $this->input->post('Start_Form_Progresses');
            $ending_form      = time();
            $timer_Progresses = $start_form.','.$ending_form;
            Create_Logs_User($timer_Progresses,$Create_Transaction,'Transaction','Progresses_Create');

            # Status Stages
            $Data_Status_Stages_Transaction = array(
                "stages_key"     => 'CREATE_A_TRANSACTION',
                "stages_type"    => 'COMPLETE',
                "transaction_id" => $Create_Transaction,
                "time_start"     => $this->input->post('Start_Form_Progresses'),
                "time_complete"  => time()
            );
            Create_Status_Stages_Transaction($Data_Status_Stages_Transaction);

            $msg_result['key']   = 'Success';
            $msg_result['value'] = lang('message_success_insert');
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');

        } else {
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions', 'refresh');
        }

    }
    ###################################################################
    # End :: Transaction Submit

    #:: Department of Data Entries
    ######################################################################################################
    public function Check_DataEntries()
    {
        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"                     => $Transaction_id,
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){
            $this->data['Transactions']      = $Get_Transactions->row();
        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->data['Page_Title']      = 'استكمال البيانات و التدقيق ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Data_Entry/Form_Data_Entry_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ######################################################################################################

    ######################################################################################################
    public function Submit_DataEntries()
    {
        $POST_Fields         = $_POST;
        $Transaction_id      = $this->input->post('Transaction_id');
        $Form_id             = $this->input->post('Form_id');
        $data_Transaction2   = array();
        $data_Transaction1   = array();
        $data_Transaction    = array();

        foreach($POST_Fields AS $key => $value)
        {

            // $_POST
            if($key == 'Start_Form_Progresses' or $key == 'Assignment_userid' or  $key=='Transaction_id' or $key=='Transactions_uuid' or $key =="ci_csrf_token" or $key =="Form_id" or $key =="FILE_Name" or $key =="FILE"){

            }else{

                $explode_Post = explode("-",$key);

                $Fields_Components = Query_Fields_Components(
                    array("Forms_id"=> $explode_Post[1], "Components_id" => $explode_Post[2],"Fields_key" => $explode_Post[0])
                );


                if ($Fields_Components->num_rows() > 0) {

                    $Get_validating_Fields         = Get_validating_Fields(array("Forms_id" => $Form_id,"Components_id" => $Fields_Components->row()->Components_id, "company_id" => 0, "Fields_id" => $Fields_Components->row()->Fields_id));


                    if ($Get_validating_Fields->num_rows() > 0) {

                        if ($Fields_Components->row()->Fields_Type == 'Fields') {
                            $Get_Fields = Get_Fields(array("Fields_id" => $Fields_Components->row()->Fields_id))->row();
                            Building_form_validation($key, $Get_Fields->item_translation, $Get_validating_Fields->row()->validating_rules);
                        } elseif ($Fields_Components->row()->Fields_Type == 'List') {
                            $Get_List = Get_All_List(array("list_id" => $Fields_Components->row()->Fields_id))->row();
                            Building_form_validation($key, $Get_List->item_translation, $Get_validating_Fields->row()->validating_rules);
                        }

                        if ($this->form_validation->run() == FALSE) {
                            $msg_result['key'] = 'Danger';
                            $msg_result['value'] = validation_errors();
                            $msg_result_view = Create_Status_Alert($msg_result);
                            set_message($msg_result_view);
                            redirect(APP_NAMESPACE_URL . '/Transactions/Check_DataEntries/'.$this->uri->segment(4), 'refresh');
                        }

                        $data_Transaction1[] = array(
                            "data_key"      => $explode_Post[0],
                            "data_value"    => $this->input->post($key, TRUE),
                            "Forms_id"      => $Form_id,
                            "Components_id" => $explode_Post[2]
                        );

                    }else{
                        $data_Transaction2[] = array(
                            "data_key"      => $explode_Post[0],
                            "data_value"    => $this->input->post($key, TRUE),
                            "Forms_id"      => $Form_id,
                            "Components_id" => $explode_Post[2]
                        );
                    } // if ($Get_validating_Fields->num_rows() > 0)

                } // if($Fields_Components->num_rows()>0)

            } // ignore $_POST

        } // foreach ($POST_Fields AS $field)

        $data_Transaction = @array_merge($data_Transaction2,$data_Transaction1);

        $Create_Transaction_data         = Create_Transaction_data($Transaction_id,$data_Transaction);
        $Create_Transaction_data_history = Create_Transaction_data_history($Transaction_id,$data_Transaction,'Create');


        if($Create_Transaction_data)
        {

            $where_Transaction_Stage = array(
                "stages_key" => 'COORDINATION_AND_QUALITY',
                "company_id" => $this->aauth->get_user()->company_id
            );
            $Get_Stages = Get_Stages_Transaction_Company($where_Transaction_Stage)->row();

            $data_Transaction_Assign = array();
            $data_Transaction_Assign['transaction_id'] = $Transaction_id;
            $data_Transaction_Assign['assign_userid']  = $this->input->post('Assignment_userid');
            $data_Transaction_Assign['assign_time']    = time();
            $data_Transaction_Assign['assign_type']    = 1;
            $Create_Transaction_Assign = Create_Transaction_Assign($data_Transaction_Assign);

            # Status Stages
            $Data_Status_Stages_Transaction = array(
                "stages_key"     => 'DATA_ENTRY',
                "stages_type"    => 'COMPLETE',
                "transaction_id" => $Transaction_id,
                "time_start"     => $this->input->post('Start_Form_Progresses'),
                "time_complete"  => time()
            );
            Create_Status_Stages_Transaction($Data_Status_Stages_Transaction);

            $query = app()->db->where('transaction_id',$Transaction_id);
            $query = app()->db->set('Transaction_Status_id','193');
            $query = app()->db->set('Transaction_Stage','COORDINATION_AND_QUALITY');
            $query = app()->db->update('protal_transaction');

            $msg_result['key']     = 'Success';
            $msg_result['value']   = lang('message_success_insert');
            $msg_result_view       = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');

        } else {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');

        }

    } // Submit_DataEntries()
    ######################################################################################################
    #End :: Department of Data Entries




}