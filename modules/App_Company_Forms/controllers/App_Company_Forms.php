<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_Forms extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $this->data['Page_Title']  = lang('Management_Permissions');
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/Dashboard', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################




}