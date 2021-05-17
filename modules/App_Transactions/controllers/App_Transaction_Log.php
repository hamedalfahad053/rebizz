<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Transaction_Log extends Apps
{

    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' المراجعة و التدقيق';
    }
    ###################################################################



    ###################################################################
    public function index()
    {
      exit;
    }
    ###################################################################

    ###################################################################
    public function log()
    {
        $Transaction_id     = $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"          => $Transaction_id,
            "company_id"    => $this->aauth->get_user()->company_id,
            "location_id"   => $this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){
            $this->data['Transactions']      = $Get_Transactions->row();

            $log_query_Transactions = app()->db->where('Action_ID',$this->data['Transactions']->transaction_id);
            $log_query_Transactions = app()->db->where('Action_Section','Transaction');
            $log_query_Transactions = app()->db->get('protal_log_system');

            if($log_query_Transactions->num_rows()>0){
                $this->data['log_Transactions'] = $log_query_Transactions->result();
            }

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }


        $this->data['Page_Title']      = ' سجل المعاملة ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();


        $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Transaction_Log/index', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################



}