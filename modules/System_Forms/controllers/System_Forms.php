<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Forms extends Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('System_Forms_Model');
        $this->data['controller_name'] = 'ادارة النماذج';

    }


    ###################################################################
    public function index()
    {
        $this->data['Page_Title'] = ' ادارة النماذج ';


        $Get_All_Forms = Get_All_Forms();

        if($Get_All_Forms->num_rows()>0){
            foreach ($Get_All_Forms->result() AS $ROW )
            {

                if ($ROW->Forms_Status == 1) {
                    $Forms_Status = Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
                } else {
                    $Forms_Status = Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
                }

                if($ROW->Forms_status_system == 1){
                    $Forms_status_system  =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Basic_System')));
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

                    if($ROW->Forms_Status == 0) {
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

                    $Forms_status_system =  Create_Options_Button($options);

                } // if($ROW->list_data_status == 1)



                $this->data['Forms_List'][]  = array(
                    "Forms_id"            => $ROW->Forms_id,
                    "Forms_key"           => $ROW->Forms_Key,
                    "Forms_translation"   => $ROW->item_translation,
                    "Forms_Status"        => $Forms_Status,
                    "Forms_main_system"   => $Forms_status_system,
                );

            } // foreach ($Get_Fields AS $ROW )
        }else{
            $this->data['Forms_List'] = false;
        }

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/System_Forms/views/List_Forms',$this->data,true);
        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_add_Forms()
    {

        $this->data['Page_Title'] = 'اضافة نموذج ';

        $this->data['status']        = array_options_status();
        $this->data['status_system'] = array_options_status_system();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Forms/views/Form_add_Forms',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_Forms()
    {

        $this->form_validation->set_rules('title_ar','title_ar','required');
        $this->form_validation->set_rules('title_en','title_en','required');
        $this->form_validation->set_rules('Status','status_Fields','required');
        $this->form_validation->set_rules('status_system','status_system','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/Forms', 'refresh');

        } else {

            $Forms_Key           = strtoupper(str_replace(" ", "_", $this->input->post('title_en')));

            if(Get_All_Forms($Forms_Key)->num_rows()>0){

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'الحقل مضاف مسبقا';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Forms', 'refresh');

            }else {

                $data_Forms['Forms_Key']            = $Forms_Key;
                $data_Forms['Forms_Status']         = $this->input->post('Status');
                $data_Forms['Forms_status_system']  = $this->input->post('status_system');
                $data_Forms['Forms_createDate']     = time();
                $data_Forms['Forms_lastModifyDate'] = 0;
                $data_Forms['Forms_isDeleted']      = 0;
                $data_Forms['Forms_DeletedBy']      = 0;

                $create_forms = $this->System_Forms_Model->Create_Forms($data_Forms);

                if ($create_forms) {

                    $item_ar = $this->input->post('title_ar');
                    $item_en = $this->input->post('title_en');
                    insert_translation_Language_item('portal_forms_translation', $create_forms, $item_ar, $item_en);

                    $msg_result['key'] = 'Success';
                    $msg_result['value'] = lang('message_success_insert');
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(ADMIN_NAMESPACE_URL . '/Forms', 'refresh');
                } else {
                    $msg_result['key'] = 'Danger';
                    $msg_result['value'] = lang('message_error_insert');
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(ADMIN_NAMESPACE_URL . '/Forms', 'refresh');
                }

            } // if(Get_Fields($Forms_Key)->num_rows()>0)


        } // if($this->form_validation->run()==FALSE)
    }
    ###################################################################

    ###################################################################
    public function Form_Components()
    {
        $this->data['Page_Title']      = ' مكونات النموذج ';

        $form_id                       = $this->uri->segment(4);
        $this->data['Form_Components'] = Get_Form_Components($form_id);

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET . 'plugins/custom/datatables/datatables.bundle', $this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET . 'plugins/custom/datatables/datatables.bundle', '');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Forms/views/Form_Components',$this->data,true);
        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_Add_Components()
    {
        $this->data['Page_Title'] = 'اضافة قسم جديد ';

        $this->data['status']        = array_options_status();
        $this->data['status_system'] = array_options_status_system();


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Forms/views/Form_Add_Components',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_Components()
    {

        $this->form_validation->set_rules('Forms_id','Forms_id', 'required');
        $this->form_validation->set_rules('Sections_Status','Sections_Status', 'required');
        $this->form_validation->set_rules('Sections_title_ar','Sections_title_ar', 'required');
        $this->form_validation->set_rules('Sections_title_en','Sections_title_en', 'required');

        $Forms_id      = $this->input->post('Forms_id');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL . '/Forms/Form_Components/'.$Forms_id, 'refresh');

        }else{

            $data_Sections_Components['components_key']            = strtoupper(str_replace(" ", "_", $this->input->post('Sections_title_en')));
            $data_Sections_Components['Forms_id']                  = $this->input->post('Forms_id');
            $data_Sections_Components['components_status']         = $this->input->post('Sections_Status');
            $data_Sections_Components['components_company_id']     = 0;
            $data_Sections_Components['components_sort']           = 0;
            $data_Sections_Components['components_createDate']     = time();
            $data_Sections_Components['components_lastModifyDate'] = 0;
            $data_Sections_Components['components_isDeleted']      = 0;
            $data_Sections_Components['components_DeletedBy']      = 0;

            $create_Sections_Form_Components = $this->System_Forms_Model->Create_Forms_Components($data_Sections_Components);

            if ($create_Sections_Form_Components)
            {
                $item_ar = $this->input->post('Sections_title_ar');
                $item_en = $this->input->post('Sections_title_en');
                insert_translation_Language_item('portal_forms_components_translation', $create_Sections_Form_Components, $item_ar, $item_en);

                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Forms/Form_Components/'.$Forms_id, 'refresh');

            } else {

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = validation_errors();
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Forms/Form_Components/'.$Forms_id, 'refresh');

            }
        }
    }
    ###################################################################

    ###################################################################
    public function Form_Add_Fields_Components()
    {
        $this->data['Page_Title']      = ' اضافة حقل للمكون  ';

        $this->data['Components_id']   = $this->uri->segment(4);
        $this->data['Fields_All_Data'] = Get_Fields()->result();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Forms/views/Form_Add_Fields_Components',$this->data,true);
        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_Fields_Components()
    {

        $this->form_validation->set_rules('Form_id','Form_id', 'required');
        $this->form_validation->set_rules('Components_id','Fields_Components_id', 'required');
        $this->form_validation->set_rules('Fields_Add','Fields_Add', 'required');

        $Form_id            = $this->input->post('Form_id');
        $Components_id      = $this->input->post('Components_id');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL . '/Forms/Form_Components/'.$Form_id.'/'.$Components_id, 'refresh');

        }else{



            $data_Sections_Components['Forms_id']           = $this->input->post('Form_id');
            $data_Sections_Components['Components_id']      = $this->input->post('Components_id');
            $data_Sections_Components['Fields_id']          = $this->input->post('Fields_Add');

            if($this->input->post('All_CUSTOMER_CATEGORY') == 1){
                $data_Sections_Components['With_Type_CUSTOMER'] = 'All';
            }else{
                if(is_array($this->input->post('CUSTOMER_CATEGORY'))){
                    $data_Sections_Components['With_Type_CUSTOMER'] = implode(',',$this->input->post('CUSTOMER_CATEGORY'));
                }else{
                    $data_Sections_Components['With_Type_CUSTOMER'] = $this->input->post('CUSTOMER_CATEGORY');
                }
            }

            if($this->input->post('All_Property_Types') == 1){
                $data_Sections_Components['With_Type_Property'] = 'All';
            }else{
                if(is_array($this->input->post('Property_Types'))){
                    $data_Sections_Components['With_Type_Property'] = implode(',',$this->input->post('Property_Types'));
                }else{
                    $data_Sections_Components['With_Type_Property'] = $this->input->post('Property_Types');
                }
            }

            if($this->input->post('All_TYPES_APPRAISAL') == 1){
                $data_Sections_Components['With_TYPES_APPRAISAL'] = 'All';
            }else{
                if(is_array($this->input->post('TYPES_APPRAISAL'))){
                    $data_Sections_Components['With_TYPES_APPRAISAL'] = implode(',',$this->input->post('TYPES_APPRAISAL'));
                }else{
                    $data_Sections_Components['With_TYPES_APPRAISAL'] = $this->input->post('TYPES_APPRAISAL');
                }
            }

            if($this->input->post('All_evaluation_methods') == 1){
                $data_Sections_Components['With_Type_evaluation_methods'] = 'All';
            }else{
                if(is_array($this->input->post('evaluation_methods'))){
                    $data_Sections_Components['With_Type_evaluation_methods'] = implode(',',$this->input->post('evaluation_methods'));
                }else{
                    $data_Sections_Components['With_Type_evaluation_methods'] = $this->input->post('evaluation_methods');
                }
            }

            $data_Sections_Components['Fields_Type']        = 'Fields';

            $Create_Fields = $this->System_Forms_Model->Create_Fields_Form_Components($data_Sections_Components);

            if ($Create_Fields) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Forms/Form_Components/'.$Form_id.'/'.$Components_id, 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Forms/Form_Components/'.$Form_id.'/'.$Components_id, 'refresh');
            } // if

        }
    }
    ###################################################################

    ###################################################################
    public function Form_Add_List_Components()
    {
        $this->data['Page_Title']      = ' اضافة قائمة للمكون  ';

        $this->data['Components_id']   = $this->uri->segment(4);

        $this->data['Get_All_List']    = Get_All_List()->result();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Forms/views/Form_Add_List',$this->data,true);
        Layout_Admin($this->data);
    }
    ###################################################################


    ###################################################################
    public function Ajax_Setting_List()
    {

        $html             = '';
        $lang             = get_current_lang();
        $Fields_data      = $this->input->get('Fields_data');
        $List_id          = $this->input->get('List_id');




        if($this->input->get('Fields_data')  and $this->input->get('List_id')) {

            $query_list = app()->db->where('list_id', $List_id);
            $query_list = app()->db->get('portal_list_data')->row();

            if($query_list->list_type == 'TABLE' and $Fields_data=='options') {

                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'نوع القائمة و القائمة لا يمكن الارتباط بهم فضلا التحقق من الاختيار لتتمكن من الربط بطريقة صحيحة';
                echo Create_Status_Alert($msg_result);

            }elseif ($query_list->list_type == 'TABLE' and $Fields_data=='options_to_options_ajax') {

                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'نوع القائمة و القائمة لا يمكن الارتباط بهم فضلا التحقق من الاختيار لتتمكن من الربط بطريقة صحيحة';
                echo Create_Status_Alert($msg_result);



            }else{

                if ($Fields_data == 'options') {

                    $query_list_options = app()->db->from('portal_list_options_data         list_options');
                    $query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
                    $query_list_options = app()->db->where('list_options.list_id', $List_id);
                    $query_list_options = app()->db->where('options_translation.translation_lang', $lang);
                    $query_list_options = app()->db->order_by('list_options.options_sort', 'ASC');
                    $query_list_options = app()->db->get();

                    $this->data['list_options'] = $query_list_options;
                    $this->load->view('../../modules/System_Forms/views/Setting_List_Options', $this->data);

                } elseif ($Fields_data == 'options_table') {

                    $this->load->database();
                    $this->data['tables_db'] = $this->db->list_tables();
                    $this->load->view('../../modules/System_Forms/views/Setting_List_Table', $this->data);

                } elseif ($Fields_data == 'options_to_options_ajax') {

                    $query_list_options = app()->db->from('portal_list_options_data         list_options');
                    $query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
                    $query_list_options = app()->db->where('list_options.list_id', $List_id);
                    $query_list_options = app()->db->where('options_translation.translation_lang', $lang);
                    $query_list_options = app()->db->order_by('list_options.options_sort', 'ASC');
                    $query_list_options = app()->db->get();

                    $this->data['list_options'] = $query_list_options;
                    $this->load->view('../../modules/System_Forms/views/Setting_List_Options_To_Options_Ajax', $this->data);

                } elseif ($Fields_data == 'options_to_table_ajax') {

                    $this->load->database();
                    $this->data['tables_db'] = $this->db->list_tables();
                    $this->load->view('../../modules/System_Forms/views/Setting_List_Options_To_Table_Ajax', $this->data);

                } elseif ($Fields_data == 'table_to_table_ajax') {

                    $this->load->database();
                    $this->data['tables_db'] = $this->db->list_tables();
                    $this->load->view('../../modules/System_Forms/views/Setting_List_Table_To_Table_Ajax', $this->data);
                }




            }

        }

    }
    ###################################################################


    ###################################################################
    public function Create_List_Components()
    {

        $this->form_validation->set_rules('Form_id','Form_id', 'required');
        $this->form_validation->set_rules('Components_id','Fields_Components_id', 'required');
        $this->form_validation->set_rules('List_id','List_id', 'required');

        $Form_id            = $this->input->post('Form_id');
        $Components_id      = $this->input->post('Components_id');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL . '/Forms/Form_Components/'.$Form_id.'/'.$Components_id, 'refresh');

        }else{


            $data_Sections_Components['Forms_id']           = $this->input->post('Form_id');
            $data_Sections_Components['Components_id']      = $this->input->post('Components_id');
            $data_Sections_Components['Fields_id']          = $this->input->post('List_id');
            $data_Sections_Components['Fields_data']        = $this->input->post('Fields_data');

            if($this->input->post('All_CUSTOMER_CATEGORY') == 1){
                $data_Sections_Components['With_Type_CUSTOMER'] = 'All';
            }else{
                if(is_array($this->input->post('CUSTOMER_CATEGORY'))){
                    $data_Sections_Components['With_Type_CUSTOMER'] = implode(',',$this->input->post('CUSTOMER_CATEGORY'));
                }else{
                    $data_Sections_Components['With_Type_CUSTOMER'] = $this->input->post('CUSTOMER_CATEGORY');
                }
            }

            if($this->input->post('All_Property_Types') == 1){
                $data_Sections_Components['With_Type_Property'] = 'All';
            }else{
                if(is_array($this->input->post('Property_Types'))){
                    $data_Sections_Components['With_Type_Property'] = implode(',',$this->input->post('Property_Types'));
                }else{
                    $data_Sections_Components['With_Type_Property'] = $this->input->post('Property_Types');
                }
            }

            if($this->input->post('All_TYPES_APPRAISAL') == 1){
                $data_Sections_Components['With_TYPES_APPRAISAL'] = 'All';
            }else{
                if(is_array($this->input->post('TYPES_APPRAISAL'))){
                    $data_Sections_Components['With_TYPES_APPRAISAL'] = implode(',',$this->input->post('TYPES_APPRAISAL'));
                }else{
                    $data_Sections_Components['With_TYPES_APPRAISAL'] = $this->input->post('TYPES_APPRAISAL');
                }
            }

            if($this->input->post('All_evaluation_methods') == 1){
                $data_Sections_Components['With_Type_evaluation_methods'] = 'All';
            }else{
                if(is_array($this->input->post('evaluation_methods'))){
                    $data_Sections_Components['With_Type_evaluation_methods'] = implode(',',$this->input->post('evaluation_methods'));
                }else{
                    $data_Sections_Components['With_Type_evaluation_methods'] = $this->input->post('evaluation_methods');
                }
            }

            ##########################################################################################################
            if($this->input->post('Fields_data') == 'options') {


            }elseif($this->input->post('Fields_data') == 'options_table') {

                $data_Sections_Components['Table_primary']                    = $this->input->post('Table_primary');
                $data_Sections_Components['primary_fields']                   = $this->input->post('primary_fields');
                $data_Sections_Components['join_table']                       = $this->input->post('join_table');
                $data_Sections_Components['Table_Join']                       = $this->input->post('Table_Join');
                $data_Sections_Components['Join_fields']                      = $this->input->post('Join_fields');
                $data_Sections_Components['primary_joining_fields']           = $this->input->post('primary_joining_fields');
                $data_Sections_Components['Join_joining_fields']              = $this->input->post('Join_joining_fields');


            }elseif($this->input->post('Fields_data') == 'options_to_options_ajax'){

                $data_Sections_Components['List_Target'] = $this->input->post('List_Target');


                foreach ($_POST['options_id'] AS $key => $value )
                {
                    if(is_array($_POST['parent_id'][$value])){
                        $parent_id                = implode(',',$_POST['parent_id'][$value]);
                        $data_parent['parent_id'] = $parent_id;
                    }else{
                        $parent_id = $_POST['parent_id'][$value];
                        $data_parent['parent_id'] = $parent_id;
                    }
                    $update_List_Target = $this->db->where('list_options_id',$value);
                    $update_List_Target = $this->db->update('portal_list_options_data',$data_parent);
                }


            }elseif($this->input->post('Fields_data') == 'options_to_table_ajax' or $this->input->post('Fields_data') == 'table_to_table_ajax' or
            $this->input->post('Fields_data') == 'table_to_table_ajax' ){

                $data_Sections_Components['List_Target']                      = $this->input->post('List_Target');

                $data_Sections_Components['Table_primary']                    = $this->input->post('Table_primary');
                $data_Sections_Components['primary_fields']                   = $this->input->post('Table_primary_fields');
                $data_Sections_Components['join_table']                       = $this->input->post('Linking_table');
                $data_Sections_Components['Table_Join']                       = $this->input->post('Table_Join');
                $data_Sections_Components['Join_fields']                      = $this->input->post('Table_Join_fields');
                $data_Sections_Components['primary_joining_fields']           = $this->input->post('Table_primary_joining_fields');
                $data_Sections_Components['Join_joining_fields']              = $this->input->post('Table_Join_joining_fields');

                $data_Sections_Components['primary_fields_link_to_options']   = $this->input->post('primary_fields_link_to_options');

                $data_Sections_Components['linked_company_id']                = $this->input->post('linked_company_id');
                $data_Sections_Components['linked_translation']               = $this->input->post('linked_translation');

            }
            ##########################################################################################################

            $data_Sections_Components['Fields_Type']        = 'List';

            //_array_p($_POST);
            //die;


            $Create_Fields = $this->System_Forms_Model->Create_Fields_Form_Components($data_Sections_Components);

            if ($Create_Fields) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Forms/Form_Components/'.$Form_id.'/'.$Components_id, 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Forms/Form_Components/'.$Form_id.'/'.$Components_id, 'refresh');
            } // if

        }
    }
    ###################################################################





}