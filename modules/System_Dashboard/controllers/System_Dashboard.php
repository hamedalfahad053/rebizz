<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Dashboard extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();


        $this->data['controller_name'] = lang('Dashboard');
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        Layout_Admin($this->data);
    }
    ###################################################################



}