<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments_data_entrants extends Apps
{
    ######################################################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'ادارة معاملات قسم الادخال و المراجعة';
    }
    ######################################################################################################

    ######################################################################################################
    public function index()
    {

        $this->data['Page_Title']      = 'استعراض المعاملات ';
        $Transactions                  = array();

        $where_Transaction_Stage = array("stages_key" => 'DATA_ENTRY', "company_id" => $this->aauth->get_user()->company_id);
        $Get_Stages              = Get_Stages_Transaction_Company($where_Transaction_Stage)->row();

        $where_Transactions = array(
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->locations_id,
            "Assignment_userid"        => $this->aauth->get_user()->id,
            "Transaction_Stage"        => $Get_Stages->stages_key
        );
        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            foreach ($Get_Transactions->result() as $ROW)
            {
                $Transactions[] = array(
                    "transaction_id"           => $ROW->transaction_id,
                    "transaction_number"       => $ROW->transaction_number,
                    "transaction_uuid"         => $ROW->uuid,
                    "Transaction_Stage"        => $ROW->Transaction_Stage,
                    "Transaction_Status_id"    => $ROW->Transaction_Status_id,
                    "Create_Transaction_By_id" => $ROW->Create_Transaction_By_id,
                    "Create_Transaction_Date"  => $ROW->Create_Transaction_Date
                );
            }

        }else{
            $Transactions = false;
        }

        $this->data['Transactions'] = $Transactions;


        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();


        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/List_Transactions_departments_data_entrants', $this->data, true);

        Layout_Apps($this->data);

    }
    ######################################################################################################


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
            redirect(APP_NAMESPACE_URL . '/Transactions_d_data_entrants/', 'refresh');
        }

        $this->data['Page_Title']      = 'استكمال البيانات و التدقيق ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Form_Data_Entry_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ######################################################################################################


    ######################################################################################################
    public function Submit_DataEntries()
    {
        $POST_Fields         = $_POST;
        $Transaction_id      = $this->input->post('Transaction_id');
        $Form_id             = $this->input->post('Form_id');


        foreach($POST_Fields AS $key => $value)
        {

            // $_POST
            if($key == 'Assignment_userid' or $key=='Transaction_id' or $key=='Transactions_uuid' or $key=='Form_id'){

            }else{

                $Fields_Components = Query_Fields_Components(array("Fields_key" => $key));

                if ($Fields_Components->num_rows() > 0) {

                    $Get_validating_Fields = Get_validating_Fields(array("Forms_id" => $Form_id,
                        "company_id" => 0,
                        "Fields_id" => $Fields_Components->row()->Fields_id));

                    $Get_validating_Fields_company = Get_validating_Fields(array("Forms_id" => $Form_id,
                        "company_id" => $this->aauth->get_user()->company_id,
                        "Fields_id" => $Fields_Components->row()->Fields_id));

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
                            redirect(APP_NAMESPACE_URL . '/Transactions_DataEntries/Check_DataEntries/', 'refresh');
                        }

                        $data_Transaction[$key] = $this->input->post($key, TRUE);

                    } // if ($Get_validating_Fields->num_rows() > 0)

                } // if($Fields_Components->num_rows()>0)

            } // ignore $_POST

        } // foreach ($POST_Fields AS $field)

        $Create_Transaction_data         = Create_Transaction_data($Transaction_id,$data_Transaction);
        $Create_Transaction_data_history = Create_Transaction_data_history($Transaction_id,$data_Transaction,'Create');


        $where_Transaction_Stage = array(
            "stages_key" => 'COORDINATION_AND_QUALITY',
            "company_id" => $this->aauth->get_user()->company_id
        );
        $Get_Stages            = Get_Stages_Transaction_Company($where_Transaction_Stage)->row();
        $up_Assignment_userid  = $this->input->post('Assignment_userid');

        if($Create_Transaction_data)
        {
            $query = app()->db->where('transaction_id',$Transaction_id);
            $query = app()->db->set('Assignment_userid',$up_Assignment_userid);
            $query = app()->db->set('Transaction_Stage','COORDINATION_AND_QUALITY');
            $query = app()->db->update('protal_transaction');

            $massage_Notifications = '';
            //$Create_Notifications  = Create_Notifications('', 'AssignmentTransaction', $massage_Notifications);
            $msg_result['key']     = 'Success';
            $msg_result['value']   = lang('message_success_insert');
            $msg_result_view       = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions_DataEntries/', 'refresh');

        } else {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions_DataEntries', 'refresh');

        }

    } // Submit_DataEntries()
    ######################################################################################################





}
