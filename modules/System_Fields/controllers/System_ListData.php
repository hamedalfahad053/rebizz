<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_ListData extends Admin
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('ListData_model');

        $this->data['controller_name'] = lang('Management_List_Data');
    }


    ###################################################################
    public function index()
    {


        $this->data['Page_Title']  = lang('Management_List_Data');

        $get_all_List  = $this->ListData_model->Cet_All_List();

        foreach ($get_all_List->result() AS $ROW )
        {

            if($ROW->list_data_status == 1) {
                $List_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $List_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            if($ROW->list_data_status == 1){
                $List_main_system =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Basic_System')));
            }else{

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

                if($ROW->list_data_status == 0) {
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


                $List_main_system =  Create_Options_Button($options);

            } // if($ROW->list_data_status == 1)

            $get_options_By_List  = $this->ListData_model->Cet_options_By_List($ROW->list_id)->num_rows();


            $this->data['List'][]  = array(
                "List_id"           => $ROW->list_id,
                "List_translation"  => $ROW->item_translation,
                "List_options_num"  => $get_options_By_List,
                "List_status"       => $List_status,
                "List_main_system"  => $List_main_system,
            );

        } // foreach ($get_all_List->result() AS $ROW )



        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Fields/views/List_Data/List_Data',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################


    ###################################################################
    public function Form_Add_New_List()
    {

        $this->data['Page_Title']  = lang('List_Data_add_button');

        $this->data['List_status'] = array(
            "1" => lang('Status_Active'),
            "0" => lang('Status_Disabled')
        );

        $this->data['List_status_system'] = array(
            "1" => lang('Basic_System'),
            "2" => lang('Multiple_Entry_Users'),
            "3" => lang('Multiple_System')
        );

        $this->data['options_status'] = array(
            "0" => lang('Multiple_System'),
            "1" => lang('Basic_System')
        );

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add(lang('Management_List_Data'),base_url(ADMIN_NAMESPACE_URL.'/List_Data'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');


        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Fields/views/List_Data/Form_Add_New_List',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_List_Data()
    {
        $this->form_validation->set_rules('title_ar',lang('Global_form_title_ar'),'required');
        $this->form_validation->set_rules('title_en',lang('Global_form_title_en'),'required');
        $this->form_validation->set_rules('Status',lang('Status'),'required');
        $this->form_validation->set_rules('main_system',lang('Basic_System'),'required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/List_Data/Form_Add_New_List', 'refresh');

        }else{

            $data_list        = array();

            $list_key = 'LIST_'.strtoupper(str_replace(" ","_",$this->input->post('title_en')));

            $data_list['list_data_status']       = $this->input->post('Status');
            $data_list['list_data_main_system']  = $this->input->post('main_system');
            $data_list['list_owner_id']          = 0;
            $data_list['list_data_key']          = $list_key;


            $option_list = $this->input->post('option_list');



            //Attributes

            $Create_List  = $this->ListData_model->Create_List($data_list);






            if($option_list){
                foreach ($option_list AS $key => $value )
                {
                    $i = 0;
                    $option_list_data = array(
                       "list_id"               => $Create_List,
                       "options_sort"          => ++$i,
                       "options_owner_id"      => 0,
                       "options_status"        => $value['options_status'],
                       "options_status_system" => $value['options_status_system']
                    );
                    $Create_options  = $this->ListData_model->Create_options_List($option_list_data);
                    insert_translation_Language_item('portal_list_options_translation',$Create_options,$value['option_ar'],$value['option_en']);
                }
            } // if(array_count_values($option_list)>0){

            if($Create_List){

                $item_ar = $this->input->post('title_ar');
                $item_en = $this->input->post('title_en');
                insert_translation_Language_item('portal_list_data_translation',$Create_List,$item_ar,$item_en);

                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL.'/List_Data' , 'refresh');

            }else{

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL.'/List_Data', 'refresh');

            }
        }

    }
    ###################################################################





}