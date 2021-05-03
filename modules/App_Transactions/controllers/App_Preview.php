<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Preview extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'ادارة المعاملات';
    }
    ###################################################################



}
?>