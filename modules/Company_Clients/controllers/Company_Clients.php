<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Clinets extends App
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Company_Clients_Model');

        //$this->data['controller_name'] = lang('List_group_user');

    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $get_all_company_client  = $this->Users_Group_Model->Get_Groups();
        
        
        foreach ($get_all_company_client->result() AS $Row)
        {
            $options = array();

            $options['view'] = array(
                "title" => lang('view_button'),
                "data-attribute" => '',
                "href" => "#"
            );

            $options['edit'] = array(
                "title" => lang('edit_button'),
                "data-attribute" => '',
                "href" => "#"
            );

            if($Row->group_status == 0) {
                $options['active'] = array(
                    "title" => lang('active_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );
            }else {
                $options['disable'] = array(
                    "title" => lang('disable_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );
            }

            $options['deleted'] = array(
                "title" => lang('deleted_button'),
                "data-attribute" => '',
                "href" => "#"
            );


            $Company_Clinet_Options =  Create_Options_Button($options);



            $this->data['Users'][]  = array(
                "Client_Id"       => $Row->id,
                "Client_Name"    => $Row->name,
                "Client_type"    => $Row->type_id,
                "Client_Company" => $Row->company_id,
                "Client_Options"  => $Company_Clinet_Options
            );


        }

        $this->data['Page_Title']  = lang('List_group_user');

        $this->mybreadcrumb->add(lang('Dashboard'), '');
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/Company_Clients/views/Client_List',$this->data,true);
        
        Layout_Apps($this->data);
    }
    ###################################################################


}