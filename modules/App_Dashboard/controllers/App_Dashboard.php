<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Dashboard extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'لوحة المعلومات';
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        // تحديد معاين
        $where_Transactions_WAITING_ASSIGN_PREVIEW = array(
          "company_id"        => $this->aauth->get_user()->company_id,
          "Transaction_Stage" => 'WAITING_ASSIGN_PREVIEW',
        );
        $Get_Transactions_WAITING_ASSIGN_PREVIEW  = Get_Transaction($where_Transactions_WAITING_ASSIGN_PREVIEW);

        // بانتظار افادة المعاين
        $where_Transactions_PENDING_FEEDBAKE_PREVIEW = array(
            "company_id"        => $this->aauth->get_user()->company_id,
            "Transaction_Stage" => 'PENDING_FEEDBAKE_PREVIEW',
        );
        $Get_Transactions_PENDING_FEEDBAKE_PREVIEW  = Get_Transaction($where_Transactions_PENDING_FEEDBAKE_PREVIEW);

        // التقييم النهائي
        $where_Transactions_FINAL_EVALUATION = array(
            "company_id"        => $this->aauth->get_user()->company_id,
            "Transaction_Stage" => 'FINAL_EVALUATION',
        );
        $Get_Transactions_FINAL_EVALUATION  = Get_Transaction($where_Transactions_FINAL_EVALUATION);

        // تحت الاعتماد
        $where_Transactions_UNDER_ACCREDITATION = array(
            "company_id"        => $this->aauth->get_user()->company_id,
            "Transaction_Stage" => 'UNDER_ACCREDITATION',
        );
        $Get_Transactions_UNDER_ACCREDITATION  = Get_Transaction($where_Transactions_UNDER_ACCREDITATION);

        // تحت المراجعة
        $where_Transactions_UNDER_REVISION = array(
            "company_id"        => $this->aauth->get_user()->company_id,
            "Transaction_Stage" => 'UNDER_REVISION',
        );
        $Get_Transactions_UNDER_REVISION  = Get_Transaction($where_Transactions_UNDER_REVISION);

        // تمت معاينة العقار
        $where_Transactions_PROPERTY_HAS_A_PREVIEW = array(
            "company_id"        => $this->aauth->get_user()->company_id,
            "Transaction_Stage" => 'PROPERTY_HAS_A_PREVIEW',
        );
        $Get_Transactions_PROPERTY_HAS_A_PREVIEW  = Get_Transaction($where_Transactions_PROPERTY_HAS_A_PREVIEW);


        $this->data['Page_Title']  = 'لوحة المعلومات';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));

        $this->data['breadcrumbs']   = $this->mybreadcrumb->render();
        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent'] = $this->load->view('../../modules/App_Dashboard/views/Dashboard', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ##################################################################################
    public function logout()
    {
        $this->aauth->logout();
        redirect('Auth', 'refresh');
    }
    ##################################################################################




}