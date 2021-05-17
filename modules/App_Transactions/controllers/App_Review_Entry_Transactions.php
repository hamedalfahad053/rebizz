<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Review_Entry_Transactions extends Apps
{

    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' المراجعة و التدقيق';
    }
    ###################################################################

    public function index()
    {
        exit;
    }

    #Start :: Department of Data Entries
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


        $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Data_Entry/Form_Data_Entry_Transactions', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ######################################################################################################

    ######################################################################################################
    public function Submit_DataEntries()
    {
        $Transaction_uuid = $this->uri->segment(4);

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
                            redirect(APP_NAMESPACE_URL . '/Review_Entry_Transactions/Check_DataEntries/'.$Transaction_uuid, 'refresh');
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


            $old_Assign = app()->db->where("assign_userid",$this->input->post('Assignment_userid'));
            $old_Assign = app()->db->where("transaction_id",$Transaction_id);
            $old_Assign = app()->db->get('protal_transaction_assign');

            if($old_Assign->num_rows() == 0){
                $data_Transaction_Assign = array();
                $data_Transaction_Assign['transaction_id'] = $Transaction_id;
                $data_Transaction_Assign['assign_userid']  = $this->input->post('Assignment_userid');
                $data_Transaction_Assign['assign_time']    = time();
                $data_Transaction_Assign['assign_type']    = 1;
                $Create_Transaction_Assign = Create_Transaction_Assign($data_Transaction_Assign);
            }

            # Status Stages
            $Data_Status_Stages_Transaction = array(
                "stages_key"     => 'DATA_ENTRY',
                "stages_type"    => 'COMPLETE',
                "transaction_id" => $Transaction_id,
                "time_start"     => $this->input->post('Start_Form_Progresses'),
                "time_complete"  => time()
            );
            Create_Status_Stages_Transaction($Data_Status_Stages_Transaction);


            $Assignment_userid   = $this->input->post('Assignment_userid');
            $Notifications_title = 'اسناد معاملة ';
            $Notifications_text  = 'تم اسناد معاملة اليك من خلال النظام ';
            Create_Notifications_Transaction($Transaction_id,$Assignment_userid,$Notifications_title,$Notifications_text);


            $query = app()->db->where('transaction_id',$Transaction_id);
            $query = app()->db->set('Transaction_Status_id','193');
            $query = app()->db->set('Transaction_Stage','COORDINATION_AND_QUALITY');
            $query = app()->db->update('protal_transaction');


            ##########################################################################################################################################
            # Time Progresses
            $start_form       = $this->input->post('Start_Form_Progresses');
            $ending_form      = time();
            $timer_Progresses = $start_form.','.$ending_form;
            Create_Logs_User($timer_Progresses,$Transaction_id,'Transaction','Progresses_DataEntries');
            ##########################################################################################################################################



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

    }
    ######################################################################################################
    #End :: Department of Data Entries








}