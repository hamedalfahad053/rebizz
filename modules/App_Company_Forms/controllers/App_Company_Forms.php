<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_Forms extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Company_Forms_Model','Company_Forms');
        $this->data['controller_name'] = 'ادارة النماذج';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $Get_Forms_By_Company = Get_Forms_By_Company($this->data['UserLogin']['Company_User']);

        if($Get_Forms_By_Company->num_rows()>0){

            foreach ($Get_Forms_By_Company->result() AS $ROW)
            {

                    if($ROW->forms_built_status == 1) {
                        $forms_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
                    }else{
                        $forms_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
                    }


                    $options = array();

                    $options['view'] = array("class"=>"","id"=>"","title" => lang('view_button'), "data-attribute" => '', "href" => base_url(APP_NAMESPACE_URL . '/Company_Forms/Forms_View/'.$ROW->forms_built_id));

                    $options['deleted'] = array("class"=>"","id"=>"","title" => lang('deleted_button'), "data-attribute" => '', "href" => "#");

                    if ($ROW->forms_built_status == 0) {
                        $options['active'] = array("class"=>"","id"=>"","title" => lang('active_button'), "data-attribute" => '', "href" => "#");
                    } else {
                        $options['disable'] = array("class"=>"","id"=>"","title" => lang('disable_button'), "data-attribute" => '', "href" => "#");
                    }

                    if($ROW->forms_built_Client_id == 0) {
                        $forms_Client_id =  Create_Status_badge(array("key"=>"Success","value"=>"عام"));
                    }else{
                        $forms_Client_id =  Create_Status_badge(array("key"=>"Danger","value"=>"اسم العميل"));
                    }

                    $form_options = Create_Options_Button($options);

                    $data_Forms[] = array(
                        "form_id"             => $ROW->forms_built_id,
                        "form_uuid"           => $ROW->forms_built_uuid,
                        "form_title_ar"       => $ROW->forms_built_title_ar,
                        "form_title_en"       => $ROW->forms_built_title_en,
                        "form_Client_id"      => $forms_Client_id,
                        "form_status"         => $forms_status,
                        "form_options"        => $form_options,
                        "form_createBy"       => $ROW->forms_built_createBy,
                        "form_createDate"     => $ROW->forms_built_createDate,
                        "form_lastModifyDate" => $ROW->forms_built_lastModifyDate,
                    );

            } // foreach

            $this->data['List_Forms']  = $data_Forms;

        }else{
            $this->data['List_Forms']  = false;
        }

        $this->data['Page_Title']  = 'ادارة النماذج';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent']   = $this->load->view('../../modules/App_Company_Forms/views/List_Forms', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################


    ###################################################################
    public function Add_New_Forms()
    {

        $this->data['Page_Title']  = ' اضافة نموذج جديد ';
        $this->data['status']      = array_options_status();

        $Client_Company = App_Get_Client_Company($this->data['UserLogin']['Company_User']);


        $Client_Company_data = array();
        foreach ($Client_Company->result() AS $ROW_CLI)
        {
            $Client_Company_data[] = array(
                "Client_id"   =>  $ROW_CLI->client_id,
                "Client_name" =>  $ROW_CLI->name
            );

        }
        $this->data['Client_Company'] = $Client_Company_data;



        $Property_Types_data = array();
        $Property_Types = Get_Property_Types();
        foreach ($Property_Types->result() AS $ROW_PT)
        {
            $Property_Types_data[] = array(
                "Property_Types_id"   =>  $ROW_PT->Property_Types_id,
                "Property_Types_Name" =>  $ROW_PT->item_translation
            );

        }
        $this->data['Property_Types'] = $Property_Types_data;



        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Forms/views/Add_New_Forms', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Forms()
    {

        $this->form_validation->set_rules('title_ar','title_ar','required');
        $this->form_validation->set_rules('title_en','title_en','required');
        $this->form_validation->set_rules('status','status','required');
        $this->form_validation->set_rules('Property_Types_id','Property_Types_id','required');
        $this->form_validation->set_rules('client_id','client_id','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Company_Forms', 'refresh');

        }else {

            $data_forms_built['forms_built_title_ar']               = $this->input->post('title_ar');
            $data_forms_built['forms_built_title_en']               = $this->input->post('title_en');
            $data_forms_built['forms_built_status']                 = $this->input->post('status');
            $data_forms_built['forms_built_client_id']              = $this->input->post('client_id');
            $data_forms_built['forms_built_Property_Types_id']      = $this->input->post('Property_Types_id');
            $data_forms_built['forms_built_Company_id']             = Get_Company_User($this->aauth->get_user()->id)->companies_id;
            $data_forms_built['forms_built_createBy']               = $this->aauth->get_user()->id;
            $data_forms_built['forms_built_createDate']             = time();
            $data_forms_built['forms_built_lastModifyDate']         = time();
            $data_forms_built['forms_built_isDeleted']              = 0;
            $data_forms_built['forms_built_DeletedBy']              = 0;

            $Create_Forms_built = $this->Company_Forms->Create_Forms_built($data_forms_built);






            if($Create_Forms_built){
                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Company_Forms' , 'refresh');
            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Company_Forms', 'refresh');
            }

        } // if($this->form_validation->run()==FALSE)

    }
    ###################################################################


    ###################################################################
    public function Forms_View()
    {

        $this->data['Page_Title']  = ' ادارة النموذج ';





        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Forms/views/Forms_View', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################




}