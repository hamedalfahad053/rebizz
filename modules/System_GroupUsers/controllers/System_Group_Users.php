<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Group_Users extends Admin
{

    private $table_name           = 'portal_auth_groups';

    public function __construct()
    {
        parent::__construct();
    }


    ###################################################################
    public function index()
    {
        $this->data['Page_Title'] = ' ادارة مجموعة المستخدمين ';

        Layout_Admin($this->data);
    }
    ###################################################################



}