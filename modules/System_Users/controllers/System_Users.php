<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Users extends Admin
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Users_Model');
        $this->load->model('../../modules/System_GroupUsers/models/Users_Group_Model');

        $this->data['controller_name'] = lang('List_user');
    }


    ###################################################################
    public function index()
    {

        $this->data['Page_Title'] = lang('List_user');

        $User_Options = '';

        $get_all_user  = $this->Users_Model->Get_All_Users();


        foreach ($get_all_user->result() AS $Row)
        {

            if($Row->banned == 0) {
                $User_Status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $User_Status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            if($Row->main_system == 1){
                $User_Options =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Basic_System')));
            }else{

                $options = array();

                $options['view'] = array(
                    "class"=>"","id"=>"",
                    "title" => lang('view_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );

                $options['edit'] = array(
                    "class"=>"","id"=>"",
                    "title" => lang('edit_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );

                if($Row->banned == 0) {
                    $options['active'] = array(
                        "class"=>"","id"=>"",
                        "title" => lang('active_button'),
                        "data-attribute" => '',
                        "href" => "#"
                    );
                }else {
                    $options['disable'] = array(
                        "class"=>"","id"=>"",
                        "title" => lang('disable_button'),
                        "data-attribute" => '',
                        "href" => "#"
                    );
                }

                $options['deleted'] = array(
                    "class"=>"","id"=>"",
                    "title" => lang('deleted_button'),
                    "data-attribute" => '',
                    "href" => "#"
                );


                $User_Options =  Create_Options_Button($options);

            } // if($Row->main_system == 1)


            $this->data['Users'][]  = array(
                "User_id"       => $Row->id,
                "User_Name"     => $Row->full_name,
                "User_Email"    => $Row->email,
                "User_Group_id" => $Row->group_id,
                "User_Group"    => $Row->item_translation,
                "User_Status"   => $User_Status,
                "User_Options"  => $User_Options
            );

        } // foreach ($get_all_user AS $Row)

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Users/views/List_Users',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Form_add_User()
    {

        $this->data['Page_Title'] = lang('add_new_user_button');

        $Groups_System = $this->Users_Group_Model->Get_Groups_System();

        foreach ($Groups_System->result() AS $ROW ) {
            $this->data['Groups_System'][] = array(
                "Group_id" => $ROW->group_id,
                "Group_Name" => $ROW->name,
                "group_translation" => $ROW->item_translation
            );
        }


        $this->data['user_status'] = array(
            "0" => lang('Status_Active'),
            "1" => lang('Status_Disabled')
        );

        $this->data['status_system'] = array(
            "1" => lang('Basic_System'),
            "0" => lang('Multiple_System')
        );


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Users/views/Form_add_User',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################

}