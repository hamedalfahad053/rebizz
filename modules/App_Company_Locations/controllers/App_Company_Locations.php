<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_Locations extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' ادارة الفروع  ';
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $Get_All_Company_Locations = Get_Company_Locations(array("company_id"=>2));


        if($Get_All_Company_Locations->num_rows() > 0)
        {

            foreach ($Get_All_Company_Locations->result() as $ROW) {

                if ($ROW->Locations_Status == 1) {
                    $Locations_Status = Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
                } else {
                    $Locations_Status = Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
                }

                $options = array();

                $options['view'] = array("class" => "", "id" => "", "title" => lang('view_button'), "data-attribute" => '', "href" => "#");
                $options['edit'] = array("class" => "", "id" => "", "title" => lang('edit_button'), "data-attribute" => '', "href" => "#");
                $options['deleted'] = array("class" => "", "id" => "", "title" => lang('deleted_button'), "data-attribute" => '', "href" => "#");

                if ($ROW->Locations_Status == 0) {
                    $options['active'] = array("class" => "", "id" => "", "title" => lang('active_button'), "data-attribute" => '',
                        "href" => base_url("Status_Locations/"));
                } else {
                    $options['disable'] = array("class" => "", "id" => "", "title" => lang('disable_button'), "data-attribute" => '',
                        "href" => base_url("Status_Locations/"));
                }

                $Locations_options = Create_Options_Button($options);

                if (get_current_lang() == 'arabic') {
                    $Locations_Name = $ROW->Locations_ar;
                } else {
                    $Locations_Name = $ROW->Locations_en;
                }

                $this->data['Locations'][] = array(
                    "Locations_id"      => $ROW->company_locations_id,
                    "Locations_Name"    => $Locations_Name,
                    "Locations_Status"  => $Locations_Status,
                    "Locations_options" => $Locations_options,
                );

            } // foreach ($Get_All_Companies->result() AS $ROW )

        }else{
            $this->data['Locations'] = false;
        }


        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');


        $this->data['Page_Title']  = 'ادارة الفروع';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Locations'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Locations/views/List_Locations', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################


    ###################################################################
    public function add_Locations()
    {

        $this->data['options_status'] = array(
            "1" => lang('Status_Active'),
            "0" => lang('Status_Disabled')
        );


        $this->data['Page_Title']  = ' اضافة فرع جديد ';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Company_Locations'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Locations/views/Form_add_Locations', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Locations()
    {

        $this->form_validation->set_rules('Locations_ar','Locations_ar','required');
        $this->form_validation->set_rules('Locations_en','Locations_en','required');
        $this->form_validation->set_rules('Locations_Commercial_Registration_No','Locations_Commercial_Registration_No','required');
        $this->form_validation->set_rules('Locations_Unified_record_number','Locations_Unified_record_number','required');
        $this->form_validation->set_rules('Locations_Registration_Date','Locations_Registration_Date','required');
        $this->form_validation->set_rules('Locations_Expiry_Date','Locations_Expiry_Date','required');
        $this->form_validation->set_rules('Locations_Region_id','Locations_Region_id','required');
        $this->form_validation->set_rules('Locations_City_id','Locations_City_id','required');
        $this->form_validation->set_rules('Locations_District_id','Locations_District_id','required');


        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Locations', 'refresh');

        }else{

            $data_Locations['Locations_ar']                         = $this->input->post('Locations_ar');
            $data_Locations['Locations_en']                         = $this->input->post('Locations_en');

            $data_Locations['company_id']                           = $this->data['UserLogin']['Company_User'];

            $data_Locations['Locations_Commercial_Registration_No'] = $this->input->post('Locations_Commercial_Registration_No');
            $data_Locations['Locations_Unified_record_number']      = $this->input->post('Locations_Unified_record_number');
            $data_Locations['Locations_Registration_Date']          = strtotime($this->input->post('Locations_Registration_Date'));
            $data_Locations['Locations_Expiry_Date']                = strtotime($this->input->post('Locations_Expiry_Date'));
            $data_Locations['Locations_Country_id']                 = 194;
            $data_Locations['Locations_Region_id']                  = $this->input->post('Locations_Region_id');
            $data_Locations['Locations_City_id']                    = $this->input->post('Locations_City_id');
            $data_Locations['Locations_District_id']                = $this->input->post('Locations_District_id');
            $data_Locations['Locations_Status']                     = $this->input->post('Locations_Status');
            $data_Locations['Locations_createBy']                   = $this->aauth->get_user()->id;
            $data_Locations['Locations_createDate']                 = time();
            $data_Locations['Locations_lastModifyDate']             = 0;
            $data_Locations['Locations_modifiedBy']                 = 0;
            $data_Locations['Locations_isDeleted']                  = 0;
            $data_Locations['Locations_DeletedBy']                  = 0;

            $Create_Locations  = $this->Company_Locations_Model->Create_Company_Locations($data_Locations);

            if($Create_Locations){
                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Locations' , 'refresh');
            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Locations', 'refresh');
            }

        } // if($this->form_validation->run()==FALSE)
    }
    ###################################################################


    ###################################################################
    public function Status_Locations()
    {

    }
    ###################################################################
}