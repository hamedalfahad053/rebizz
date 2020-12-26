<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Ajax extends Apps
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


        Layout_Apps($this->data);
    }
    ###################################################################

    ###############################################################################################
    public function Change_language()
    {
        $lang_new = $this->uri->segment(3);

        echo $lang_new;

    }
    ###############################################################################################



}