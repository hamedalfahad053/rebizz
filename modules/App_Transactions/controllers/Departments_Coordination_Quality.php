<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments_Coordination_Quality extends Apps
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

        $where_Transaction_Stage = array("stages_key" => 'COORDINATION_AND_QUALITY', "company_id" => $this->aauth->get_user()->company_id);
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


        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/List_Transactions_Departments_Coordination_Quality', $this->data, true);

        Layout_Apps($this->data);

    }
    ######################################################################################################


    ######################################################################################################
    public function View_Transactions()
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
            redirect(APP_NAMESPACE_URL . '/Transactions_Coordination_Quality/', 'refresh');
        }

        $this->data['Page_Title']      = ' عرض المعاملة ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transactions_Coordination_Quality', $this->data, true);
        Layout_Apps($this->data);
    }
    ######################################################################################################






}
