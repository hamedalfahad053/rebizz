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

        $this->data['Page_Title'] = ' مكونات النموذج ';

        $this->data['status']          = array_options_status();
        $this->data['status_system']   = array_options_status_system();

        $this->data['Fields_All_Data'] = Get_Fields_By_Status()->result();
        $this->data['Get_All_List']    = Get_All_List()->result();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Forms/views/Form_Components',$this->data,true);
        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Ajax_Sections_Components()
    {
        $html = '';
        $Forms_id = $this->input->get('Forms_id');

        $Sections_Components_data =  Get_Sections_Form_Components($Forms_id)->result();

        foreach ($Sections_Components_data AS $ROW )
        {

            $html .= '<div class="card card-custom mt-10" id="'.$ROW->components_key.'" data-section-key="'.$ROW->components_key.'" data-section-id="'.$ROW->components_id.'">';

            $Button_Model_List   = Create_One_Button_Text_Without_tooltip(array('id'=>'','class'=>'ModelFormAddFields','title' => 'اضافة حقل', 'data_attribute' => ' data-components-id="'.$ROW->components_id.'"  data-toggle="modal" data-target="#Model_FormAddFields"', 'href' => "javascript:void(0);"));
            $Button_Model_Fields = Create_One_Button_Text_Without_tooltip(array('id'=>'','class'=>'ModelFormCreateList','title' => 'اضافة قائمة', 'data_attribute' => ' data-components-id="'.$ROW->components_id.'" data-toggle="modal" data-target="#Model_FormCreateList"', 'href' => "javascript:void(0);"));

            $options_Components['deleted'] = array(
                                                "title"          => lang('deleted_button'),
                                                "data-attribute" => ' 
                                                 data-components-id="'.$ROW->components_id.'" ',
                                                "class"          => "Deleted_Sections_Components",
                                                "id"             => "",
                                                "href"           => "#"
                                                );

            $Button_Components = Create_Options_Button($options_Components);


            $html .= '<div class="card-header">';

                        $html .= '<div class="card-title">';
                        $html .= '<span class="card-icon"><i class="flaticon-squares text-primary"></i></span>';
                        $html .= '<h3 class="card-label">'.$ROW->item_translation.'</h3>';
                        $html .= '</div>'; // card-title

                        $html .= '<div class="card-toolbar">';
                        $html .= $Button_Model_List;
                        $html .= $Button_Model_Fields;
                        $html .= $Button_Components;
                        $html .= '</div>'; // card-toolbar

                $html .= '</div>'; // card-header

            $html .= '<div class="card-body">';

            $html .= '<table class="data_table table table-bordered table-hover display nowrap" width="100%">';

                $html .= '<thead>';
                    $html .= '<tr>';
                    $html .= '<th class="text-center">#</th>';
                    $html .= '<th class="text-center">اسم الحقل</th>';
                    $html .= '<th class="text-center">نوع الحقل</th>';
                    $html .= '<th class="text-center">Key</th>';
                    $html .= '<th class="text-center"></th>';
                    $html .= '<tr>';
                $html .= '</thead>';

                $Get_Fields_components = Get_Fields_Components_Default($Forms_id,$ROW->components_id);

                _array_p($Get_Fields_components);
//                $html .= '<tbody>';
//
//                $i_c = 0;
//
//                    foreach ($Get_Fields_components AS $ROW_C )
//                    {
//                        $options = array();
//                        $options['view']    = array("class"=>"","id"=>"","title" => lang('view_button'), "data-attribute" => '', "href" => "#");
//                        $options['deleted'] = array("title"=> lang('deleted_button'),
//                                                    "data-attribute" => '
//                                                     data-components-id="'.$ROW['components_id'].'"
//                                                     data-Fields-id="'.$ROW_C['Fields_id'].'" ',
//                                                     "class"=>"DeletedFieldsSections","id"=>"",
//                                                     "href"=> "#");
//
//                        $Fields_components_options =  Create_Options_Button($options);
//
//
//                        $html .= '<tr>';
//                        $html .= '<td class="text-center">'.++$i_c.'</td>';
//                        $html .= '<td class="text-center">'.$ROW_C['Fields_Title'].'</td>';
//                        $html .= '<td class="text-center">'.$ROW_C['Fields_Type'].'</td>';
//                        $html .= '<td class="text-center"></td>';
//                        $html .= '<td class="text-center">'.$Fields_components_options.'</td>';
//                        $html .= '</tr>';
//                    }
//
//
//
//
//                $html .= '<tbody>';
//
//            $html .= '</table>';

            $html .= '</div>'; // card-body


            $html .= '</div>'; // card card-custom mt-10
        }

        echo $html;
    }
    ###################################################################


    ###################################################################
    public function Create_Sections_Form_Components()
    {
        $msg['success'] = false;

        if ($this->input->is_ajax_request()) {

            if ($this->input->get('Forms_id')=='' or $this->input->get('Sections_title_ar')=='' or $this->input->get('Sections_title_en')=='') {

                $msg['success']        = true;
                $msg['Type_result']    = 'error';
                $msg['Message_result'] = 'جميع الحقول اجبارية';

            } else {

                $data_Sections_Components['components_key']            = strtoupper(str_replace(" ", "_", $this->input->get('Sections_title_en')));
                $data_Sections_Components['Forms_id']                  = $this->input->get('Forms_id');
                $data_Sections_Components['components_status']         = $this->input->get('Sections_Status');
                $data_Sections_Components['components_company_id']     = 0;
                $data_Sections_Components['components_sort']           = 0;
                $data_Sections_Components['components_createDate']     = time();
                $data_Sections_Components['components_lastModifyDate'] = 0;
                $data_Sections_Components['components_isDeleted']      = 0;
                $data_Sections_Components['components_DeletedBy']      = 0;

                $create_Sections_Form_Components = $this->System_Forms_Model->Create_Sections_Forms_Components($data_Sections_Components);

                if ($create_Sections_Form_Components) {

                    $item_ar = $this->input->get('Sections_title_ar');
                    $item_en = $this->input->get('Sections_title_en');
                    insert_translation_Language_item('portal_forms_sections_components_translation', $create_Sections_Form_Components, $item_ar, $item_en);

                    $msg['success'] = true;
                    $msg['Type_result'] = 'success';
                    $msg['Message_result'] = 'تم اضافة المكون بنجاح';
                } else {
                    $msg['success'] = true;
                    $msg['Type_result'] = 'error';
                    $msg['Message_result'] = 'عفوا حدث خطا اثناء الاضافة حاول مجدد او تواصل مع الدعم الفني';
                }

            } // if ($this->form_validation->run() == FALSE)

        } // if ($this->input->is_ajax_request())

        echo json_encode($msg);
    }
    ###################################################################

    ###################################################################
    public function Deleted_Sections_Form_Components()
    {
        $msg['success'] = false;

        if ($this->input->is_ajax_request()) {

            if ($this->input->get('Forms_id')=='' or $this->input->get('Sections_Components_id')=='') {
                $msg['success']        = true;
                $msg['Type_result']    = 'error';
                $msg['Message_result'] = 'جميع الحقول اجبارية';
            } else {

                $Forms_id      = $this->input->get('Forms_id');
                $Components_id = $this->input->get('Sections_Components_id');

                $Deleted_Sections_Components = $this->System_Forms_Model->Deleted_Sections_Forms_Components($Forms_id,$Components_id);
                if ($Deleted_Sections_Components) {
                    $msg['success'] = true;
                    $msg['Type_result'] = 'success';
                    $msg['Message_result'] = 'تم حذف المكون بنجاح';
                } else {
                    $msg['success'] = true;
                    $msg['Type_result'] = 'error';
                    $msg['Message_result'] = 'عفوا حدث خطا اثناء الاضافة حاول مجدد او تواصل مع الدعم الفني';
                }

            }
        }

        echo json_encode($msg);

    }
    ###################################################################

    ###################################################################
    public function Create_Fields_To_Sections_Form_Components()
    {
        $msg['success'] = false;

        if ($this->input->is_ajax_request()) {

            if ($this->input->get('Forms_id')=='' or $this->input->get('Components_id')=='' or $this->input->get('Fields_id')=='') {
                $msg['success']        = true;
                $msg['Type_result']    = 'error';
                $msg['Message_result'] = 'جميع الحقول اجبارية';
            } else {


                    $data_Sections_Components['Forms_id']        = $this->input->get('Forms_id');
                    $data_Sections_Components['Components_id']   = $this->input->get('Components_id');
                    $data_Sections_Components['Fields_id']       = $this->input->get('Fields_id');
                    $data_Sections_Components['Fields_Type']     = 'Fields';

                    $Create_Fields_To_Sections_Form_Components = $this->System_Forms_Model->Create_Fields_To_Sections_Form_Components($data_Sections_Components);

                    if ($Create_Fields_To_Sections_Form_Components) {
                        $msg['success'] = true;
                        $msg['Type_result'] = 'success';
                        $msg['Message_result'] = 'تم اضافة المكون بنجاح';
                    } else {
                        $msg['success'] = true;
                        $msg['Type_result'] = 'error';
                        $msg['Message_result'] = 'عفوا حدث خطا اثناء الاضافة حاول مجدد او تواصل مع الدعم الفني';
                    }


            } // if ($this->form_validation->run() == FALSE)

        } // if ($this->input->is_ajax_request())

        echo json_encode($msg);

    }
    ###################################################################

    ###################################################################
    public function Deleted_Fields_To_Sections_Form_Components()
    {
        $msg['success'] = false;

        if ($this->input->is_ajax_request()) {

            if ($this->input->get('Forms_id')=='' or $this->input->get('Components_id')=='' or $this->input->get('Fields_id')=='') {
                $msg['success']        = true;
                $msg['Type_result']    = 'error';
                $msg['Message_result'] = 'جميع الحقول اجبارية';
            } else {


                $data_Sections_Components['Forms_id']      = $this->input->get('Forms_id');
                $data_Sections_Components['Components_id'] = $this->input->get('Components_id');
                $data_Sections_Components['Fields_id']     = $this->input->get('Fields_id');

                $Create_Fields_To_Sections_Form_Components = $this->System_Forms_Model->Deleted_Fields_To_Sections_Form_Components($data_Sections_Components);

                if($Create_Fields_To_Sections_Form_Components)
                {
                    $msg['success'] = true;
                    $msg['Type_result'] = 'success';
                    $msg['Message_result'] = 'تم الحذف بنجاح';
                } else {
                    $msg['success'] = true;
                    $msg['Type_result'] = 'error';
                    $msg['Message_result'] = 'عفوا حدث خطا اثناء الحذف حاول مجدد او تواصل مع الدعم الفني';
                }

            } // if ($this->form_validation->run() == FALSE)

        } // if ($this->input->is_ajax_request())

        echo json_encode($msg);

    }
    ###################################################################




    ###################################################################
    public function Create_List_To_Sections_Form_Components()
    {
        $msg['success'] = false;

        if ($this->input->is_ajax_request()) {

            if ($this->input->get('Forms_id')=='' or $this->input->get('List_Components_id')=='' or $this->input->get('List_id')=='') {

                $msg['success']        = true;
                $msg['Type_result']    = 'error';
                $msg['Message_result'] = 'جميع الحقول اجبارية';

            } else {

                $data_Sections_Components['Forms_id']        = $this->input->get('Forms_id');
                $data_Sections_Components['Components_id']   = $this->input->get('List_Components_id');
                $data_Sections_Components['Fields_id']       = $this->input->get('List_id');
                $data_Sections_Components['Fields_Type']     = 'List';

                $Create_List_To_Sections_Form_Components = $this->System_Forms_Model->Create_Fields_To_Sections_Form_Components($data_Sections_Components);

                if ($Create_List_To_Sections_Form_Components) {
                    $msg['success'] = true;
                    $msg['Type_result'] = 'success';
                    $msg['Message_result'] = 'تم اضافة المكون بنجاح';
                } else {
                    $msg['success'] = true;
                    $msg['Type_result'] = 'error';
                    $msg['Message_result'] = 'عفوا حدث خطا اثناء الاضافة حاول مجدد او تواصل مع الدعم الفني';
                }

            } // if ($this->form_validation->run() == FALSE)
        } // if ($this->input->is_ajax_request())

        echo json_encode($msg);
    }
    ###################################################################



}