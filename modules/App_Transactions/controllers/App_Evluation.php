<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Evluation extends Apps
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
    public function Add_New_Evluation()
    {
        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array("uuid"=> $Transaction_id, "company_id"=> $this->aauth->get_user()->company_id);
        $Get_Transactions   = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows() == 0)
        {
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'دخول غير صحيح يرجى التحقق من العملية';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Transactions/', 'refresh');
            exit;
        }


        $this->data['Page_Title'] = 'اضافة طريقة تقييم ';


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Evluation/Add_New_Evluation', $this->data, true);


        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_New_Evluation()
    {

    }
    ###################################################################


}