<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company_ProfileUser extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = '';
    }
    ###################################################################

    ###################################################################
    public function index()
    {


        $this->data['Lode_file_Css'] = import_css(BASE_ASSET . 'plugins/custom/datatables/datatables.bundle', $this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET . 'plugins/custom/datatables/datatables.bundle', '');

        $this->data['Page_Title']    = lang('Management_Clients');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'], '#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_ProfileUser/views/ProfileUser', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Notifications()
    {

    }
    ###################################################################


    ###################################################################
    public function Ajax_Read_Notifications()
    {

        $query = app()->db->where('userid',$this->aauth->get_user()->id);
        $query = app()->db->set('type_read','1');
        $query = app()->db->set('date_read',time());
        $query = app()->db->update('portal_user_notifications');


        if($query){

            Create_Logs_User('Read_Notifications','','Notifications','Read');

            $msg['success']        = true;
            $msg['Type_result']    = 'success';
            $msg['Message_result'] = 'تم تعليم جميع الاشعارات كمقرؤة بنجاح';
        }else{
            $msg['success']        = true;
            $msg['Type_result']    = 'error';
            $msg['Message_result'] = 'حصل خطا اثناء التحديث يرجى المحاولة مجددا';

        }

        echo json_encode($msg);

    }
    ###################################################################

    ###################################################################
    public function Logs()
    {

    }
    ###################################################################

}
