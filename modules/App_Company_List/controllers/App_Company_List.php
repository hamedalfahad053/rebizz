<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_List extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'ادارة قوائم البيانات';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $this->data['Page_Title']  = 'ادارة قوائم البيانات';


        $where_List = array(
            "list_view"        => '1',
        );
        $Get_List = Get_All_List($where_List);

        if($Get_List->num_rows()>0) {

            foreach ($Get_List->result() as $ROW)
            {

                if ($ROW->list_status == 1) {
                    $List_status = Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
                } else {
                    $List_status = Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
                }

                if ($ROW->list_status == 0) {
                    $List_main_system = Create_Status_badge(array("key" => "Danger", "value" => lang('Basic_System')));
                } else {

                    $options = array();


                    if($ROW->list_main_system == 0)
                    {
                        $options['edit'] = array(
                            'class' => '', 'id' => '', "title" => lang('edit_button'), "data-attribute" => '',
                            "href" => base_url(APP_NAMESPACE_URL . '/List_Data/Form_Edit_List/' . $ROW->list_uuid)
                        );
                        if ($ROW->list_status == 0) {
                            $options['active'] = array(
                                'class' => '', 'id' => '', "title" => lang('active_button'), "data-attribute" => '',
                                "href" => "#"
                            );
                        } else {
                            $options['disable'] = array(
                                'class' => '', 'id' => '', "title" => lang('disable_button'), "data-attribute" => '',
                                "href" => "#"
                            );
                        }
                        $List_main_system = Create_Options_Button($options);
                    }else{
                        $List_main_system = Create_Status_badge(array("key" => "Danger", "value" => lang('Basic_System')));;
                    }

                    if($ROW->list_main_system == 1){
                        $list_createBy = 'النظام';
                    }else{
                        $list_createBy = $this->aauth->get_user($ROW->list_createBy)->full_name.' - '.date('Y-m-d h:i:s a',$ROW->list_createDate);
                    }



                } // if($ROW->list_data_status == 1)

                $where_options = array("options_isDeleted" => 0);
                $Get_options   = query_options_List($ROW->list_id,$where_options)->num_rows();

                $button_options = Create_One_Button_Text(array('title'=> $Get_options ,'href'=>base_url(APP_NAMESPACE_URL.'/List/view_options/'.$ROW->list_uuid)));

                $this->data['List'][] = array(
                    "List_id"          => $ROW->list_id,
                    "List_translation" => $ROW->item_translation,
                    "List_options_sum" => $button_options,
                    "list_createBy"    => $list_createBy,
                    "List_status"      => $List_status,
                    "List_main_system" => $List_main_system,
                );

            } // foreach ($get_all_List->result() AS $ROW )

        }else{
            $this->data['List'] = false;
        }


        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_List/views/List',$this->data,true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function add_List()
    {
        $this->data['Page_Title'] = 'اضافة قائمة جديدة';

        $this->data['List_status']        = array_options_status();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Fields'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_List/views/Form_add_List',$this->data,true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_List()
    {
        $this->form_validation->set_rules('title_ar','عنوان القائمة بالعربية','required');
        $this->form_validation->set_rules('title_en','عنوان القائمة باللغة الانجليزية','required');
        $this->form_validation->set_rules('list_status','حدد حالة القائمة','required');


        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/List', 'refresh');

        } else {

            $data_list  = array();
            $list_key   = 'LIST_'.strtoupper(str_replace(" ","_",$this->input->post('title_en')));

            $data_list['list_key']                      =  $list_key;
            $data_list['list_status']                   =  $this->input->post('list_status');
            $data_list['list_type']                     =  'OPTIONS';
            $data_list['list_company_id']               =  $this->aauth->get_user()->company_id;
            $data_list['list_createBy']                 =  $this->aauth->get_user()->id;
            $data_list['list_createDate']               =  time();
            $data_list['list_lastModifyDate']           =  0;
            $data_list['list_isDeleted']                =  0;
            $data_list['list_DeletedBy']                =  0;

            if(Get_All_List(array("list_key"=>$data_list['list_key']))->num_rows()==0){

                $Create_List = Create_List($data_list);

                if($this->input->post('list_type') == 'OPTIONS')
                {
                    $option_list = $this->input->post('option_list',true);
                    $i = 0;
                    foreach ($option_list as $key => $value)
                    {

                        $option_list_data = array(
                            "list_id"               => $Create_List,
                            "options_sort"          => ++$i,
                            "options_key"           => strtoupper(str_replace(" ","_",$value['option_en'])),
                            "options_company_id"    => $this->aauth->get_user()->company_id,
                            "options_status"        => $value['options_status'],
                            "options_status_system" => $value['options_status_system']
                        );

                        $Create_options  = Create_options($option_list_data);
                        insert_translation_Language_item('portal_list_options_translation',$Create_options,$value['option_ar'],$value['option_en']);
                    }
                }

            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'القائمة مضافة مسبقا';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/List', 'refresh');
            }

        } // if($this->form_validation->run()==FALSE)
    }
    ###################################################################

    ###################################################################
    public function Status_List()
    {

        $List_id =  $this->uri->segment(4);
        $Status    =  $this->uri->segment(5);

        if ($List_id == '' or $Status == '') {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'طريقة غير صحيحة ';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/List/', 'refresh');

        } else {

            $where_List = array(
               "list_uuid"       => $List_id,
               "list_company_id" => $this->aauth->get_user()->company_id
            );
            $Get_List = Get_Fields($where_List);

            if($Get_List->num_rows() >0) {

                $List_uuid       = $List_id;
                $List_company_id = $this->aauth->get_user()->company_id;
                $List_Status    = $Status;

                $Update_Custom_List = Update_Custom_Fields($List_uuid,$List_company_id,$List_Status);

                if($Update_Custom_List)
                {

                    Create_Logs_User('Status_List',$List_uuid,'List','Update');

                    $msg_result['key']   = 'Success';
                    $msg_result['value'] = 'تم التحديث بنجاح';
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/List', 'refresh');
                } else {
                    $msg_result['key'] = 'Danger';
                    $msg_result['value'] = 'لم يتم التحديث يوجد مشكلة حدثت اثناء تحديث القائمة';
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/List', 'refresh');
                }

            }else{

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'طريقة غير صحيحة ';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/List/', 'refresh');

            } // if($Get_List->num_rows() >0){


        } // if ($List_id == '' or $Status == '')

    } // Status_Fields
    ###################################################################

    ###################################################################
    public function view_options()
    {
        $List_id          =  $this->uri->segment(4);
        $option_list_data = array();



        $where_List = array(
            "list_uuid"        => $List_id,
        );
        $this->data['List'] = Get_All_List($where_List)->row();


        $query_All_options = query_All_options_List($this->data['List']->list_id,$where_options = '');

        if($query_All_options->num_rows()>0) {

            //options_status_system;
            //options_createBy
            //options_createDate

            foreach ($query_All_options->result() as $ROW) {

                if($ROW->options_status_system == 1){
                    $options_button     =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Basic_System')));
                    $options_company_id =  'النظام';
                }else{

                    $options_button     = array();

                    if($ROW->options_status == 0) {
                        $options['active'] = array(
                            'class' => '', 'id'    => '', "title" => lang('active_button'), "data-attribute" => '',
                            "href" => base_url(APP_NAMESPACE_URL.'/List/Status_options/'.$ROW->options_uuid.'/1')
                        );
                    }else {
                        $options['disable'] = array(
                            'class' => '', 'id'    => '', "title" => lang('disable_button'), "data-attribute" => '',
                            "href" => base_url(APP_NAMESPACE_URL.'/List/Status_options/'.$ROW->options_uuid.'/0')
                        );
                    }
                    $options_button     =  Create_Options_Button($options);
                    $options_company_id = $this->aauth->get_user($ROW->options_createBy)->full_name.''.date('Y-m-d h:i:s a',$ROW->options_createDate);
                }

                if($ROW->options_status == 1) {
                    $status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
                }else{
                    $status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
                }


                $option_list_data[] = array(
                    "options_uuid"          => $ROW->options_uuid,
                    "options_title"         => $ROW->item_translation,
                    "options_company_id"    => $options_company_id,
                    "options_status"        => $status,
                    "options_button"        => $options_button
                );
            }

            $this->data['option_list_data']  = $option_list_data;

        }else{
            $this->data['option_list_data']  =  false;
        }

        $this->data['Page_Title'] = 'استعراض عناصر القائمة';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Fields'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_List/views/view_options',$this->data,true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function add_options()
    {

        $List_id            = $this->uri->segment(4);
        $where_List         = array("list_uuid" => $List_id,);
        $this->data['List'] = Get_All_List($where_List)->row();

        $this->data['Page_Title'] = 'اضافة عنصر جديد';

        $this->data['options_status']        = array_options_status();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Fields'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_List/views/Form_Add_New_Options.php',$this->data,true);

        Layout_Apps($this->data);


    }
    ###################################################################

    ###################################################################
    public function Create_options()
    {

        $this->form_validation->set_rules('List_id','حدد  القائمة','required');


        if($this->form_validation->run() == FALSE) {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/List/Form_Add_New_List', 'refresh');

        }else {

            $option_list = $this->input->post('option_list', true);

            $i = 0;
            foreach ($option_list as $key => $value) {
                if($value['option_ar']=='' and $value['option_en']=='') {

                }else{

                    $option_list_data = array(
                        "list_id"               => $this->input->post('List_id', true),
                        "options_sort"          => ++$i,
                        "options_key"           => strtoupper(str_replace(" ", "_", $value['option_en'])),
                        "options_company_id"    => $this->aauth->get_user()->company_id,
                        "options_status"        => $value['options_status'],
                        "options_createDate"    => time(),
                        "options_status_system" => 0
                    );
                    $Create_options = Create_options($option_list_data);
                    insert_translation_Language_item('portal_list_options_translation', $Create_options, $value['option_ar'], $value['option_en']);

                } // if == ''
            } // foreach


            if($Create_options){
                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/List' , 'refresh');
            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/List', 'refresh');
            }



        }
    }
    ###################################################################

    ###################################################################
    public function Status_options()
    {
        $options_id            = $this->uri->segment(4);
        $status                = $this->uri->segment(5);

        if($options_id == '' or $status==''){
            redirect(APP_NAMESPACE_URL.'/List' , 'refresh');
        }else{
            $options_company_id    = $this->aauth->get_user()->company_id;
            $Update_options        = Update_Custom_Options($options_id,$options_company_id,$status);
        }

        if($Update_options){
            $msg_result['key']   = 'Success';
            $msg_result['value'] = lang('message_success_insert');
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/List' , 'refresh');
        }else{
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = lang('message_error_insert');
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/List', 'refresh');
        }



    }
    ###################################################################

}