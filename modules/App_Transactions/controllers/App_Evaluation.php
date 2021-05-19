<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Evaluation extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'التقييم ';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        exit;
    }
    ###################################################################

    ###################################################################
    public function Dashboard()
    {

        $Transaction_id = $this->uri->segment(4);

        $where_Transactions = array(
            "uuid" => $Transaction_id,
            "company_id" => $this->aauth->get_user()->company_id,
            "location_id" => $this->aauth->get_user()->locations_id,
        );

        $Get_Transactions = Get_Transaction($where_Transactions);

        if ($Get_Transactions->num_rows() > 0) {

            $this->data['Transactions'] = $Get_Transactions->row();
            $this->data['Page_Title'] = ' التقييم  ';

            $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Dashboard'));
            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

            $this->data['PageParent'] = $this->load->view('../../modules/App_Transactions/views/Evaluation/Dashboard', $this->data, true);
            $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
            Layout_Apps($this->data);

        } else {
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

    }
    ###################################################################

    ###################################################################
    public function Add_New_Evaluation()
    {
        $Transaction_id = $this->uri->segment(4);

        $where_Transactions = array(
            "uuid" => $Transaction_id,
            "company_id" => $this->aauth->get_user()->company_id,
            "location_id" => $this->aauth->get_user()->locations_id,
        );
        $Get_Transactions = Get_Transaction($where_Transactions);

        if ($Get_Transactions->num_rows() > 0) {

            $this->data['Transactions'] = $Get_Transactions->row();
            $this->data['Page_Title'] = ' تحديد طريقة التقييم';


            $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Dashboard'));
            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

            $this->data['PageParent'] = $this->load->view('../../modules/App_Transactions/views/Evaluation/Add_New_Evaluation', $this->data, true);
            $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
            Layout_Apps($this->data);

        } else {
            redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/' . $this->uri->segment(4), 'refresh');
        } // if($Get_Transactions->num_rows() == 0)

    }
    ###################################################################

    ###################################################################
    public function Create_Methods_Evaluation()
    {

        $this->form_validation->set_rules('Evaluation_Methods', 'لم يتم تحديد طريقة التقييم', 'required');
        $this->form_validation->set_rules('Evaluation_Methods', 'لم يتم تحديد المعاينة ', 'required');

        if ($this->form_validation->run() == FALSE) {

            $msg_result['key'] = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Evaluation/Add_New_Evaluation/' . $this->uri->segment(4), 'refresh');

        } else {

            $Transaction_id = $this->uri->segment(4);

            $where_Transactions = array(
                "uuid" => $Transaction_id,
                "company_id" => $this->aauth->get_user()->company_id,
                "location_id" => $this->aauth->get_user()->locations_id
            );

            $Get_Transactions = Get_Transaction($where_Transactions);

            if ($Get_Transactions->num_rows() == 0) {
                redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/' . $this->uri->segment(4), 'refresh');
            } else {

                $data_assign['transaction_id'] = $Get_Transactions->row()->transaction_id;
                $data_assign['preview_id'] = $this->input->post('preview_id');
                $data_assign['company_id'] = $this->aauth->get_user()->company_id;
                $data_assign['location_id'] = $this->aauth->get_user()->locations_id;
                $data_assign['evaluation_status'] = 0;
                $data_assign['evaluation_methodid'] = $this->input->post('Evaluation_Methods');
                $data_assign['evaluation_userid'] = $this->aauth->get_user()->id;
                $data_assign['Create_Byid'] = $this->aauth->get_user()->id;
                $data_assign['Create_Date'] = time();

                $Create_assign = $this->db->insert('protal_evaluation_transactions', $data_assign);

                if ($Create_assign) {

                    $msg_result['key'] = 'Success';
                    $msg_result['value'] = 'تم اضافة طريقة التقييم بنجاح';
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/' . $this->uri->segment(4), 'refresh');

                } else {

                    $msg_result['value'] = 'لم تتم الاضافة فضلا حاول مجدداً';
                    $msg_result['key'] = 'Danger';
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Evaluation/Add_New_Evaluation/' . $this->uri->segment(4), 'refresh');

                }

            }

        }

    }
    ###################################################################

    ###################################################################
    public function Evaluation_Transactions()
    {

        $this->data['Page_Title'] = ' التقييم النهائي   ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();


        $Transaction_id = $this->uri->segment(4);
        $Evluation_id   = $this->uri->segment(5);

        $where_Transactions = array(
            "uuid" => $Transaction_id,
            "company_id" => $this->aauth->get_user()->company_id,
            "location_id" => $this->aauth->get_user()->locations_id
        );
        $Get_Transactions = Get_Transaction($where_Transactions);

        if ($Get_Transactions->num_rows() == 0) {
            redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/' . $this->uri->segment(4), 'refresh');

        } else {

            $this->data['Transactions'] = $Get_Transactions->row();

            $get_evaluation = $this->db->where('evaluation_uuid', $Evluation_id);
            $get_evaluation = $this->db->where('transaction_id', $this->data['Transactions']->transaction_id);
            $get_evaluation = $this->db->get('protal_evaluation_transactions');

            $this->data['get_evaluation'] = $get_evaluation->row();

            $query_preview_Visit = app()->db->where('Transactions_id', $this->data['Transactions']->transaction_id);
            $query_preview_Visit = app()->db->where('Coordination_id', $this->data['get_evaluation']->preview_id);
            $query_preview_Visit = app()->db->where('preview_Visit_acceptance', 393);
            $query_preview_Visit = app()->db->get('protal_transaction_coordination');

            $this->data['preview_Visit'] = $query_preview_Visit->row();

            if ($get_evaluation->num_rows() > 0 and $query_preview_Visit->num_rows() > 0) {

                $this->data['preview_data'] = $query_preview_Visit->row();
                $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Evaluation/Form_Evaluation_Cost_Bank', $this->data, true);

            } else {

                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'الزيارة غير معتمد او غير مكتملة ';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Transactions/View_Transaction/'.$this->uri->segment(4), 'refresh');

            } // if($get_evaluation->num_rows()>0)

        }

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Evaluation_Transactions()
    {


        $data_Transaction1 = array();
        $data_Transaction2 = array();

        $Transaction_id = $this->uri->segment(4);
        $Coordinator_id = $this->uri->segment(5);
        $Evaluation_id = $this->uri->segment(6);

        $where_Transactions = array("uuid" => $Transaction_id, "company_id" => $this->aauth->get_user()->company_id, "location_id" => $this->aauth->get_user()->locations_id);
        $Get_Transactions = Get_Transaction($where_Transactions);

        $query_preview_Visit = app()->db->where('Transactions_id', $Get_Transactions->row()->transaction_id);
        $query_preview_Visit = app()->db->where('Coordination_uuid', $Coordinator_id);
        $query_preview_Visit = app()->db->get('protal_transaction_coordination');

        $get_evaluation = $this->db->where('transaction_id', $Get_Transactions->row()->transaction_id);
        $get_evaluation = $this->db->where('preview_id', $query_preview_Visit->row()->Coordination_id);
        $get_evaluation = $this->db->where('evaluation_uuid', $Evaluation_id);
        $get_evaluation = $this->db->get('protal_evaluation_transactions');

        if ($Get_Transactions->num_rows() > 0 and $get_evaluation->num_rows() > 0 and $query_preview_Visit->num_rows() > 0) {


            $POST_Fields = $_POST;

            $data_evaluation = array();
            foreach ($POST_Fields as $key => $value) {

                if ($key == 'Start_Form_Progresses' or $key == 'Transaction_id' or $key == 'Type_Map' or $key == 'preview_id' or $key == 'LIST_PROPERTY_PICTURES' or $key == 'Coordination_id' or $key == 'file_name' or $key == 'Transactions_uuid' or $key == "ci_csrf_token" or $key == "Form_id" or $key == "FILE_Name" or $key == "FILE" or $key == "geo-zoom" or $key == 'Total_Land' or $key == 'Total_Building' or $key == 'CONSUMPTION_RATIO' or $key == 'CONSUMPTION_Total' or $key == 'ESTIMATED_COSTS' or $key == 'PROFIT_RATIO' or $key == 'PROFIT_Total' or $key == 'MARKET_VALUE' or $key == 'MARKET_VALUE_Approximate') {


                } else {

                    $explode_Post = explode("-", $key);
                    $Fields_Components = Query_Fields_Components(array("Forms_id" => $explode_Post[1], "Components_id" => $explode_Post[2], "Fields_key" => $explode_Post[0]));

                    if ($Fields_Components->num_rows() > 0) {

                        $Get_validating_Fields = Get_validating_Fields(array("Forms_id" => $explode_Post[1], "Components_id" => $Fields_Components->row()->Components_id, "company_id" => 0, "Fields_id" => $Fields_Components->row()->Fields_id));

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
                                redirect(APP_NAMESPACE_URL . '/Evaluation/Evaluation_Transactions/' . $Transaction_id . '/' . $Evaluation_id, 'refresh');
                            }

                            if ($this->input->post($key, TRUE) !== '') {
                                $data_Transaction1[] = array(
                                    "data_key" => $explode_Post[0],
                                    "preview_id" => $query_preview_Visit->row()->Coordination_id,
                                    "data_value" => $this->input->post($key, TRUE),
                                    "Forms_id" => $explode_Post[1],
                                    "Components_id" => $explode_Post[2]
                                );
                            }

                        } else {

                            if ($this->input->post($key, TRUE) !== '') {
                                $data_Transaction2[] = array(
                                    "data_key" => $explode_Post[0],
                                    "preview_id" => $query_preview_Visit->row()->Coordination_id,
                                    "data_value" => $this->input->post($key, TRUE),
                                    "Forms_id" => $explode_Post[1],
                                    "Components_id" => $explode_Post[2]
                                );
                            }

                        } // if ($Get_validating_Fields->num_rows() > 0)

                    } // if($Fields_Components->num_rows()>0)

                } // $key == ''

            } // foreach($POST_Fields AS $key => $value)


            $data_Transaction = @array_merge($data_Transaction2, $data_Transaction1);

            $Create_evaluation_data = Create_evaluation_transaction_final_data($Get_Transactions->row()->transaction_id, $data_Transaction);
            $Create_evaluation_data_history = Create_evaluation_transaction_final_data_history($Get_Transactions->row()->transaction_id, $data_Transaction, 'Create');

            ################################################################
            $data_preview_evaluation['preview_id'] = $query_preview_Visit->row()->Coordination_id;
            $data_preview_evaluation['evaluation_methodid'] = $get_evaluation->row()->evaluation_methodid;
            $data_preview_evaluation['transaction_id'] = $Get_Transactions->row()->transaction_id;
            $data_preview_evaluation['Total_Land'] = $this->input->post('Total_Land', TRUE);
            $data_preview_evaluation['Total_Building'] = $this->input->post('Total_Building', TRUE);
            $data_preview_evaluation['CONSUMPTION_RATIO'] = $this->input->post('CONSUMPTION_RATIO', TRUE);
            $data_preview_evaluation['CONSUMPTION_Total'] = $this->input->post('CONSUMPTION_Total', TRUE);
            $data_preview_evaluation['ESTIMATED_COSTS'] = $this->input->post('ESTIMATED_COSTS', TRUE);
            $data_preview_evaluation['PROFIT_RATIO'] = $this->input->post('PROFIT_RATIO', TRUE);
            $data_preview_evaluation['PROFIT_Total'] = $this->input->post('PROFIT_Total', TRUE);
            $data_preview_evaluation['MARKET_VALUE'] = $this->input->post('MARKET_VALUE', TRUE);
            $data_preview_evaluation['MARKET_VALUE_Approximate'] = $this->input->post('MARKET_VALUE_Approximate', TRUE);
            $evaluation_transaction_final_cost_bank = app()->db->insert('protal_evaluation_transaction_final_costbank', $data_preview_evaluation);
            ################################################################


            if ($Create_evaluation_data and $Create_evaluation_data_history and $evaluation_transaction_final_cost_bank) {

                $query = app()->db->where('transaction_id', $Get_Transactions->row()->transaction_id);
                $query = app()->db->set('Transaction_Status_id', '192');
                $query = app()->db->set('Transaction_Stage', 'UNDER_ACCREDITATION');
                $query = app()->db->update('protal_transaction');

                ################################################################
                # Status Stages
                $Data_Status_Stages_Transaction = array(
                    "stages_key" => 'EVALUATION',
                    "stages_type" => 'COMPLETE',
                    "transaction_id" => $Transaction_id,
                    "time_start" => time(),
                    "time_complete" => time()
                );
                Create_Status_Stages_Transaction($Data_Status_Stages_Transaction);
                ################################################################

                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/' . $Transaction_id, 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = validation_errors();
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/' . $Transaction_id, 'refresh');
            }


        } else {
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

    } //  Create_Evaluation_Transactions
    ###################################################################

    ###################################################################
    public function Approval_Evaluation_Transactions()
    {
        $this->data['Page_Title'] = ' التقييم النهائي   ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();


        $Transaction_id = $this->uri->segment(4);
        $Evluation_id   = $this->uri->segment(5);

        $where_Transactions = array("uuid" => $Transaction_id,"company_id" => $this->aauth->get_user()->company_id,"location_id" => $this->aauth->get_user()->locations_id);
        $Get_Transactions   = Get_Transaction($where_Transactions);

        if ($Get_Transactions->num_rows() == 0) {

            redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/' . $this->uri->segment(4), 'refresh');

        } else {

            $this->data['Transactions'] = $Get_Transactions->row();

            $get_evaluation = $this->db->where('evaluation_uuid', $Evluation_id);
            $get_evaluation = $this->db->where('transaction_id', $this->data['Transactions']->transaction_id);
            $get_evaluation = $this->db->get('protal_evaluation_transactions');

            $this->data['get_evaluation'] = $get_evaluation->row();

            $query_preview_Visit         = app()->db->where('Transactions_id', $this->data['Transactions']->transaction_id);
            $query_preview_Visit         = app()->db->where('Coordination_id', $this->data['get_evaluation']->preview_id);
            $query_preview_Visit         = app()->db->where('preview_Visit_acceptance', 393);
            $query_preview_Visit         = app()->db->get('protal_transaction_coordination');
            $this->data['preview_Visit'] = $query_preview_Visit->row();

            if ($get_evaluation->num_rows() > 0 and $query_preview_Visit->num_rows() > 0) {

                $this->data['preview_data'] = $query_preview_Visit->row();
                $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Evaluation/Approval_Evaluation_Cost_Bank', $this->data, true);
                Layout_Apps($this->data);

            } else {

                redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/' . $this->uri->segment(4), 'refresh');

            } // if($get_evaluation->num_rows()>0)

        }

    }
    ###################################################################

    ###################################################################
    public function Submit_Approval_Evaluation_Transactions()
    {
        $Transaction_id = $this->uri->segment(4);
        $Evluation_id   = $this->uri->segment(5);
        $Approval       = $this->uri->segment(6);

        $where_Transactions = array(
            "uuid" => $Transaction_id,
            "company_id" => $this->aauth->get_user()->company_id,
            "location_id" => $this->aauth->get_user()->locations_id
        );
        $Get_Transactions = Get_Transaction($where_Transactions);

        if ($Get_Transactions->num_rows() == 0) {
            redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/' . $this->uri->segment(4), 'refresh');

        } else {

            $Transactions = $Get_Transactions->row();

            $get_evaluation = $this->db->where('evaluation_uuid', $Evluation_id);
            $get_evaluation = $this->db->where('transaction_id', $Transactions->transaction_id);
            $get_evaluation = $this->db->get('protal_evaluation_transactions');



            if ($get_evaluation->num_rows() > 0) {

                $get_evaluation = $get_evaluation->row();
                // 0 = New
                // 1 = Rejected
                // 2 = Approval

                $get_evaluation_table = $this->db->where('transaction_id',$Transactions->transaction_id);
                $get_evaluation_table = $this->db->where('preview_id',$get_evaluation->preview_id);
                $get_evaluation_table = $this->db->get('protal_evaluation_transaction_final_costbank')->row();

                $update_evaluation_transactions  = app()->db->where('transaction_id',$Transactions->transaction_id);
                $update_evaluation_transactions  = app()->db->where('evaluation_uuid',$Evluation_id);
                $update_evaluation_transactions  = app()->db->where('company_id',$this->aauth->get_user()->company_id);
                $update_evaluation_transactions  = app()->db->set('evaluation_status',$Approval);
                $update_evaluation_transactions  = app()->db->set('evaluation_ISApproval',1);
                $update_evaluation_transactions  = app()->db->set('evaluation_Approval_Date',time());
                $update_evaluation_transactions  = app()->db->set('evaluation_Approval_id',$this->aauth->get_user()->id);
                $update_evaluation_transactions  = app()->db->set('MARKET_VALUE',$get_evaluation_table->MARKET_VALUE_Approximate);
                $update_evaluation_transactions  = app()->db->update('protal_evaluation_transactions');

                if($update_evaluation_transactions){

                    $Data_Status_Stages_Transaction = array(
                        "stages_key"     => 'EVALUATION',
                        "stages_type"    => 'COMPLETE',
                        "transaction_id" => $Transactions->transaction_id,
                        "time_start"     => time(),
                        "time_complete"  => time()
                    );
                    Create_Status_Stages_Transaction($Data_Status_Stages_Transaction);

                    $msg_result['key']   = 'Success';
                    $msg_result['value'] = ' تم تعيين حالة التقييم بنجاح';
                    $msg_result_view     = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transactions->uuid, 'refresh');
                }else{
                    $msg_result['key']   = 'Danger';
                    $msg_result['value'] = 'طريقة غير صحيحة ';
                    $msg_result_view     = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transactions->uuid, 'refresh');
                }


            } else {
                redirect(APP_NAMESPACE_URL.'/Transactions/View_Transaction/'.$this->uri->segment(4), 'refresh');
            }

        }

    }
    ###################################################################
}