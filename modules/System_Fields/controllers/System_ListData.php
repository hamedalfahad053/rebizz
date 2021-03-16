<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_ListData extends Admin
{

    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = lang('Management_List_Data');
        $this->load->database();
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $this->data['Page_Title']  = lang('Management_List_Data');

        $Get_All_List = Get_All_List();

        foreach ($Get_All_List->result() AS $ROW )
        {
            if($ROW->list_status == 1) {
                $List_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $List_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            if($ROW->list_status == 0){
                $List_main_system =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Basic_System')));
            }else{

                $options = array();

                $options['view'] = array(
                    'class' => '', 'id'    => '', "title" => lang('view_button'), "data-attribute" => '',
                    "href" => "#"
                );

                $options['edit'] = array(
                    'class' => '', 'id'    => '', "title" => lang('edit_button'), "data-attribute" => '',
                    "href" => base_url(ADMIN_NAMESPACE_URL.'/List_Data/Form_Edit_List/'.$ROW->list_id)
                );

                if($ROW->list_status == 0) {
                    $options['active'] = array(
                        'class' => '', 'id'    => '', "title" => lang('active_button'), "data-attribute" => '',
                        "href" => "#"
                    );
                }else {
                    $options['disable'] = array(
                        'class' => '', 'id'    => '', "title" => lang('disable_button'), "data-attribute" => '',
                        "href" => "#"
                    );
                }

                $options['deleted'] = array(
                    'class' => '', 'id'    => '', "title" => lang('deleted_button'), "data-attribute" => '',
                    "href" => "#"
                );
                $List_main_system =  Create_Options_Button($options);

            } // if($ROW->list_data_status == 1)

            $this->data['List'][]  = array(
                "List_id"           => $ROW->list_id,
                "List_key"          => $ROW->list_key,
                "List_translation"  => $ROW->item_translation,
                "List_type"         => $ROW->list_type,
                "List_view"         => $ROW->list_view,
                "List_status"       => $List_status,
                "List_main_system"  => $List_main_system,
            );

        } // foreach ($get_all_List->result() AS $ROW )

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');
        $this->data['PageContent']   = $this->load->view('../../modules/System_Fields/views/List_Data/List_Data',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_Add_New_List()
    {

        $this->data['Page_Title']  = lang('List_Data_add_button');

        $this->data['List_status']        = array_options_status();
        $this->data['List_status_system'] = array_options_status_system();

        $this->data['tables_db']          = $this->db->list_tables();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add(lang('Management_List_Data'),base_url(ADMIN_NAMESPACE_URL.'/List_Data'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Fields/views/List_Data/Form_Add_New_List',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Ajax_fields_Table_Database()
    {
        header('Content-Type: application/json');
        $Table = $this->input->get('table_data');
        $field_data = $this->db->field_data($Table);
        foreach ($field_data as $row)
        {
            $data[] = array(
                "id"        => $row->name,
                "Name"      => $row->name,
            );
        }
        echo json_encode($data);
    }
    ###################################################################


    ###################################################################
    public function Ajax_options_List()
    {
        header('Content-Type: application/json');

        $list_id = $this->input->get('List_id');
        $lang    = get_current_lang();;

        $query_list_options = app()->db->from('portal_list_options_data list_options');
        $query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
        $query_list_options = app()->db->where('list_options.list_id', $list_id);
        $query_list_options = app()->db->where('options_translation.translation_lang', $lang);
        $query_list_options = app()->db->order_by('list_options.options_sort', 'ASC');
        $query_list_options = app()->db->get();

        //print_r($query_list_options->result());

        foreach ($query_list_options->result() as $row)
        {
            $options[] = array(
                "options_id"    => $row->list_options_id,
                "options_key"   => $row->options_key,
                "options_type"  => 'options',
                "options_title" => $row->item_translation
            );
        }

        echo json_encode($options);
    }
    ###################################################################


    ###################################################################
    public function Create_List_Data()
    {
        $this->form_validation->set_rules('title_ar','عنوان القائمة بالعربية','required');
        $this->form_validation->set_rules('title_en','عنوان القائمة باللغة الانجليزية','required');

        $this->form_validation->set_rules('list_type','نوع القائمة غير محدد','required');
        $this->form_validation->set_rules('list_view','حدد حالة العرض للقائمة','required');
        $this->form_validation->set_rules('list_status','حدد حالة القائمة','required');

        if($this->input->post('list_type') == 'OPTIONS') {
            $this->form_validation->set_rules('option_list',' لا يوجد خيارات بالقائمة ','required');
        }elseif($this->input->post('list_type') == 'TABLE') {
            $this->form_validation->set_rules('Table_primary','حدد حالة القائمة','required');
            $this->form_validation->set_rules('Table_primary_fields','حدد حالة القائمة','required');
        }

        if($this->form_validation->run() == FALSE) {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/List_Data/Form_Add_New_List', 'refresh');

        }else{

            $data_list  = array();
            $list_key   = 'LIST_'.strtoupper(str_replace(" ","_",$this->input->post('title_en')));

            $data_list['list_key']                      =  $list_key;
            $data_list['list_status']                   =  $this->input->post('list_status');
            $data_list['list_type']                     =  $this->input->post('list_type');
            $data_list['list_view']                     =  $this->input->post('list_view');

            $data_list['Table_primary']                 =  $this->input->post('Table_primary',true);
            $data_list['Table_primary_fields']          =  $this->input->post('Table_primary_fields',true);
            $data_list['Linking_table']                 =  $this->input->post('Linking_table',true);

            $data_list['Table_Join']                    =  $this->input->post('Table_Join',true);
            $data_list['Table_Join_fields']             =  $this->input->post('Table_Join_fields',true);
            $data_list['Table_primary_joining_fields']  =  $this->input->post('Table_primary_joining_fields',true);
            $data_list['Table_Join_joining_fields']     =  $this->input->post('Table_Join_joining_fields',true);

            $data_list['list_company_id']               =  0;
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
                            "options_company_id"    => 0,
                            "options_status"        => $value['options_status'],
                            "options_status_system" => $value['options_status_system']
                        );
                        $Create_options  = Create_options_List($option_list_data);
                        insert_translation_Language_item('portal_list_options_translation',$Create_options,$value['option_ar'],$value['option_en']);
                    }
                }

            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'القائمة مضافة مسبقا';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL.'/List_Data/Form_Add_New_List', 'refresh');
            }

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

        } // form_validation->run()
        
    }
    ###################################################################


}