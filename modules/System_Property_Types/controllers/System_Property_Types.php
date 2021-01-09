<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Property_Types extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->load->model('System_Property_Types_Model');
        $this->data['controller_name'] = 'انواع العقارات';
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $this->data['Page_Title']  = 'انواع العقارات';

        $Property_Types = Get_Property_Types()->result();

        foreach ($Property_Types AS $ROW ) {

            if ($ROW->Property_Types_status == 1) {
                $Property_Types_status = Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
            } else {
                $Property_Types_status = Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
            }

            if($ROW->Property_Types_system_status == 1){
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

                if($ROW->Property_Types_system_status == 0) {
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

            $this->data['Property_Types_List'][]  = array(
                "Property_Types_id"           => $ROW->Property_Types_id,
                "CATEGORY_PROPERTY"           => Get_options_List_Translation($ROW->Categories_Property_id)->item_translation,
                "Property_Types_translation"  => $ROW->item_translation,
                "Property_Types_status"       => $Property_Types_status,
                "Property_Types_main_system"  => $List_main_system,
            );

        }

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Property_Types/views/List_Property_Types',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Form_Add_Property_Types()
    {
        $this->data['Page_Title']  = ' اضافة فئة جديدة ';

        $this->data['status']        = array_options_status();
        $this->data['status_system'] = array_options_status_system();


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Property_Types/views/Form_Add_Property_Types',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################


    ###################################################################
    public function Create_Property_Types()
    {

        $this->form_validation->set_rules('title_ar','title_ar','required');
        $this->form_validation->set_rules('title_en','title_en','required');
        $this->form_validation->set_rules('Status','Status','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URLrter.'/Property_Types', 'refresh');

        }else {

            $data_Property_Types['Property_Types_key']            = strtoupper(str_replace(" ", "_", $this->input->post('title_en')));
            $data_Property_Types['Property_Types_status']         = $this->input->post('Status');
            $data_Property_Types['Property_Types_createBy']       = 0;
            $data_Property_Types['Property_Types_system_status']  = 0;
            $data_Property_Types['Property_Types_createDate']     = time();
            $data_Property_Types['Property_Types_lastModifyDate'] = 0;
            $data_Property_Types['Property_Types_isDeleted']      = 0;
            $data_Property_Types['Property_Types_DeletedBy']      = 0;

            $create_Property_Types = $this->System_Property_Types_Model->Create_Property_Types($data_Property_Types);

            if ($create_Property_Types) {

                $item_ar = $this->input->post('title_ar');
                $item_en = $this->input->post('title_en');
                insert_translation_Language_item('portal_list_property_types_translation', $create_Property_Types, $item_ar, $item_en);

                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Property_Types', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Property_Types', 'refresh');
            }

        }

    }
    ###################################################################


    ###################################################################
    public function Property_Types_Components()
    {

        $this->data['Page_Title']  = ' مكونات العقار';


        $this->data['options_status'] = array(
            "1" => lang('Status_Active'),
            "0" => lang('Status_Disabled')
        );

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Property_Types'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Property_Types/views/Property_Components',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Ajax_Property_Types_Sections_Components()
    {

        $html = '';
        $Property_Types = $this->input->get('Property_Types_id');
        $Sections_Types_Property_Components =  Get_Sections_Types_Property_Components($Property_Types)->result();

        foreach ($Sections_Types_Property_Components AS $ROW )
        {
            $html .= '<div class="card card-custom mt-10" data-section-key="'.$ROW->components_key.'" data-section-id="'.$ROW->components_id.'">';

            $html .= '<div class="card-header">';

            $html .= '<div class="card-title">';
            $html .= '<span class="card-icon"><i class="flaticon-squares text-primary"></i></span>';
            $html .= '<h3 class="card-label">'.$ROW->item_translation.'</h3>';
            $html .= '</div>'; // card-title

            $html .= '<div class="card-toolbar">';
            $html .= '<a href="#" class="btn btn-sm btn-primary mr-5 font-weight-bold"> اضافة حقل  </a>';
            $html .= '<a href="#" class="btn btn-sm btn-primary mr-5 font-weight-bold"> اضافة قائمة  </a>';
            $html .= '</div>'; // card-toolbar


            $html .= '</div>'; // card-header

            $html .= '<div class="card-body">';




            $html .= '</div>'; // card-body


            $html .= '</div>'; // card card-custom mt-10

        }

        echo $html;

    }
    ###################################################################


    ###################################################################
    public function Create_Sections_Types_Property_Components()
    {
        $msg['success'] = false;

        if ($this->input->is_ajax_request()) {


            if ($this->input->get('Property_Types_id')=='' or $this->input->get('Sections_title_ar')=='' or $this->input->get('Sections_title_en')=='') {

                $msg['success']        = true;
                $msg['Type_result']    = 'error';
                $msg['Message_result'] = 'جميع الحقول اجبارية';

            } else {

                $data_Sections_Components['components_key']            = strtoupper(str_replace(" ", "_", $this->input->get('Sections_title_en')));
                $data_Sections_Components['property_types_id']         = $this->input->get('Property_Types_id');
                $data_Sections_Components['components_status']         = $this->input->get('Sections_Status');
                $data_Sections_Components['components_company_id']     = 0;
                $data_Sections_Components['components_sort']           = 0;
                $data_Sections_Components['components_createDate']     = time();
                $data_Sections_Components['components_lastModifyDate'] = 0;
                $data_Sections_Components['components_isDeleted']      = 0;
                $data_Sections_Components['components_DeletedBy']      = 0;

                $create_Sections_Components_Property_Types = $this->System_Property_Types_Model->Create_Sections_Types_Property_Components($data_Sections_Components);

                if ($create_Sections_Components_Property_Types) {

                    $item_ar = $this->input->get('Sections_title_ar');
                    $item_en = $this->input->get('Sections_title_en');
                    insert_translation_Language_item('portal_list_property_types_sections_components_translation', $create_Sections_Components_Property_Types, $item_ar, $item_en);

                    $msg['success'] = true;
                    $msg['Type_result'] = 'success';
                    $msg['Message_result'] = 'تم تحديث الاستشارات المقدمة بحسابك بنجاح';

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