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

        $Transaction_id  =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"=>$Transaction_id,
            "company_id"=>$this->aauth->get_user()->company_id,
            "location_id"=>$this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $this->data['Transactions']  = $Get_Transactions->row();
            $this->data['Page_Title']    = ' التقييم  ';

            $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

            $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Evaluation/Dashboard', $this->data, true);
            $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
            Layout_Apps($this->data);

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

    }
    ###################################################################


    ###################################################################
    public function Add_New_Evaluation()
    {
        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"                     => $Transaction_id,
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->locations_id,
        );
        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows() > 0){

            $this->data['Transactions']   = $Get_Transactions->row();
            $this->data['Page_Title']     = ' تحديد طريقة التقييم  ';

            $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

            $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Evaluation/Add_New_Evaluation', $this->data, true);
            $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
            Layout_Apps($this->data);

        }else{

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'المعاملة غير صحيحة';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Transactions/View_Transaction/'.$this->uri->segment(4), 'refresh');

        } // if($Get_Transactions->num_rows() == 0)

    }
    ###################################################################

    ###################################################################
    public function Create_Methods_Evaluation()
    {

        $this->form_validation->set_rules('Evaluation_Methods','لم يتم تحديد طريقة التقييم','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Evaluation/Add_New_Evaluation/'.$this->uri->segment(4), 'refresh');

        }else{

            $Transaction_id     = $this->uri->segment(4);

            $where_Transactions = array(
                "uuid"        => $Transaction_id,
                "company_id"  => $this->aauth->get_user()->company_id,
                "location_id" => $this->aauth->get_user()->locations_id
            );
            $Get_Transactions   = Get_Transaction($where_Transactions);

            if($Get_Transactions->num_rows() == 0)
            {
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'المعاملة غير صحيحة';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Transactions/View_Transaction/'.$this->uri->segment(4), 'refresh');

            }else{

                $data_assign['transaction_id']        =  $Get_Transactions->row()->transaction_id;
                $data_assign['company_id']            =  $this->aauth->get_user()->company_id;
                $data_assign['location_id']           =  $this->aauth->get_user()->locations_id;
                $data_assign['evaluation_status']     =  0;
                $data_assign['evaluation_methodid']   =  $this->input->post('Evaluation_Methods');
                $data_assign['evaluation_userid']     =  $this->aauth->get_user()->id;
                $data_assign['Create_Byid']           =  $this->aauth->get_user()->id;
                $data_assign['Create_Date']           =  time();

                $Create_assign = $this->db->insert('protal_evaluation_transactions',$data_assign);

                if($Create_assign) {

                    $msg_result['key']      = 'Success';
                    $msg_result['value']    = 'تم اضافة طريقة التقييم بنجاح';
                    $msg_result_view        = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$this->uri->segment(4), 'refresh');

                } else {

                    $msg_result['value']    = 'لم تتم الاضافة فضلا حاول مجدداً';
                    $msg_result['key']      = 'Danger';
                    $msg_result_view        = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Evaluation/Add_New_Evaluation/'.$this->uri->segment(4), 'refresh');

                }

            }

        }

    }
    ###################################################################

    ###################################################################
    public function Evaluation_Transactions()
    {

        $this->data['Page_Title']   = ' تحديد طريقة التقييم  ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();


        $Transaction_id     = $this->uri->segment(4);
        $Evluation_id       = $this->uri->segment(5);

        $where_Transactions = array(
            "uuid"        => $Transaction_id,
            "company_id"  => $this->aauth->get_user()->company_id,
            "location_id" => $this->aauth->get_user()->locations_id
        );
        $Get_Transactions   = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows() == 0)
        {
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'المعاملة غير صحيحة';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Transactions/View_Transaction/'.$this->uri->segment(4), 'refresh');

        }else{

            $this->data['Transactions'] = $Get_Transactions->row();

            $get_evaluation = $this->db->where('evaluation_uuid',$Evluation_id);
            $get_evaluation = $this->db->get('protal_evaluation_transactions');

            if($get_evaluation->num_rows()>0){

                $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Evaluation/Form_Evaluation_Cost_Bank', $this->data, true);

            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'المعاملة غير صحيحة';
                $msg_result_view     = Create_Status_Alert($msg_result);
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

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Coordinator/Add_Preview_Visit/'.$this->uri->segment(4), 'refresh');

        }else{

            $Transaction_id =  $this->uri->segment(4);

            $where_Transactions = array("uuid"=> $Transaction_id, "company_id"=> $this->aauth->get_user()->company_id,"location_id"=> $this->aauth->get_user()->locations_id);
            $Get_Transactions  = Get_Transaction($where_Transactions);

            if($Get_Transactions->num_rows()>0){
                $Get_Transactions = $Get_Transactions->row();
            }else{
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
            }




            # Status Stages
            $Data_Status_Stages_Transaction = array(
                "stages_key"     => 'EVALUATION',
                "stages_type"    => 'COMPLETE',
                "transaction_id" => $Transaction_id,
                "time_start"     => time(),
                "time_complete"  => time()
            );
            Create_Status_Stages_Transaction($Data_Status_Stages_Transaction);



        } // if($this->form_validation->run()==FALSE)

    } //  Create_Evaluation_Transactions
    ###################################################################


}