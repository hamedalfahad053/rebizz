<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_Online_Users extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' المستخدمين النشطين  ';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $Get_All_Online = Get_online_current_user(array("company_id"=>app()->aauth->get_user()->company_id));

        if($Get_All_Online->num_rows() > 0)
        {
            foreach ($Get_All_Online->result() as $ROW) {

                $this->data['Online'][] = array(
                    "browser"           => $ROW->browser,
                    "browser_version"   => $ROW->browser_version,
                    "platform"          => $ROW->platform,
                    "mobile"            => $ROW->mobile,
                    "Time_Activity"     => $ROW->Time_Activity,
                    "Locations_text"    => $ROW->Locations_text,
                    "Userid"            => $ROW->Userid,
                    "ip_address"        => $ROW->ip_address
                );

            } // foreach ($Get_All_Companies->result() AS $ROW )

        }else{
            $this->data['Online'] = false;
        }



        $this->data['Page_Title']  = 'المتصلون الان ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Locations'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Online_Users/views/List_Online', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

}