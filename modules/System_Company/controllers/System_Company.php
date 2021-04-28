<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Company extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Companies_model');
        $this->load->model('../../modules/System_GroupUsers/models/Users_Group_Model');


        $this->data['controller_name'] = lang('Management_companies_offices');
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $Get_All_Companies = $this->Companies_model->Get_All_Companies();

        foreach ($Get_All_Companies->result() AS $ROW )
        {

            if($ROW->companies_Status == 1) {
                $Companies_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $Companies_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            $options = array();
            $options['view']    = array("class"=>"","id"=>"","title" => lang('view_button'), "data-attribute" => '', "href" => base_url(ADMIN_NAMESPACE_URL.'/Company/Company_Profile/'.$ROW->company_id.''));
            $options['edit']    = array("class"=>"","id"=>"","title" => lang('edit_button'), "data-attribute" => '', "href" => "#");
            $options['deleted'] = array("class"=>"","id"=>"","title" => lang('deleted_button'), "data-attribute" => '', "href" => "#");

            if($ROW->companies_Status == 0) {
                $options['active'] = array("class"=>"","id"=>"","title" => lang('active_button'), "data-attribute" => '', "href" => "#");
            }else {
                $options['disable'] = array("class"=>"","id"=>"","title" => lang('disable_button'), "data-attribute" => '', "href" => "#");
            }

            $Companies_options =  Create_Options_Button($options);

            $this->data['companies'][]  = array(
                "company_id"           => $ROW->company_id,
                "companies_BUSINESS_CATEGORIES"  => Get_options_List_Translation($ROW->LIST_BUSINESS_CATEGORIES)->item_translation,
                "companies_Trade_Name" => $ROW->companies_Trade_Name,
                "companies_status"     => $Companies_status,
                "companies_options"    => $Companies_options,
            );


        } // foreach ($Get_All_Companies->result() AS $ROW )

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page_Title']  = lang('Management_companies_offices');
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/System_Company/views/List_company',$this->data,true);
        Layout_Admin($this->data);

    }
    ###################################################################


    ###################################################################
    public function Form_Add_Company()
    {

        $this->data['Page_Title']  = lang('Management_Add_companies_offices');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent'] = $this->load->view('../../modules/System_Company/views/Form_Add_Company',$this->data,true);
        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Company()
    {
        $this->form_validation->set_rules('LIST_BUSINESS_CATEGORIES',lang('companies_Category'),'required');
        $this->form_validation->set_rules('companies_Trade_Name',lang('companies_Trade_Name'),'required');
        $this->form_validation->set_rules('companies_Commercial_Registration_No',lang('companies_Commercial_Registration_No'),'required');
        $this->form_validation->set_rules('companies_Unified_record_number',lang('companies_Unified_record_number'),'required');
        $this->form_validation->set_rules('Registration_Date',lang('Global_Registration_Date'),'required');
        $this->form_validation->set_rules('Expiry_Date',lang('Global_Expiry_Date'),'required');
        $this->form_validation->set_rules('companies_commercial_activities',lang('companies_commercial_activities'),'required');
        $this->form_validation->set_rules('companies_owner_name',lang('companies_owner_name'),'required');

        $this->form_validation->set_rules('owner_Nationality_id',lang('Global_Nationality'),'required');
        $this->form_validation->set_rules('owner_Identification_Number',lang('Global_Identification_Number'),'required');
        $this->form_validation->set_rules('owner_Identification_Issued_Date',lang('Global_Issued_Date'),'required');
        $this->form_validation->set_rules('owner_Identification_Expiry_Date',lang('Global_Expiry_Date'),'required');
        $this->form_validation->set_rules('owner_Identification_Issued_by',lang('Global_Issued_by'),'required');
        $this->form_validation->set_rules('owner_Mobile',lang('Global_Mobile'),'required');
        $this->form_validation->set_rules('owner_telephone',lang('Global_telephone'),'required');
        $this->form_validation->set_rules('owner_address',lang('Global_address'),'required');

        $this->form_validation->set_rules('companies_telephone',lang('Global_telephone'),'required');
        $this->form_validation->set_rules('companies_Mobile',lang('Global_Mobile'),'required');
        $this->form_validation->set_rules('companies_email',lang('Global_email'),'required');
        $this->form_validation->set_rules('companies_postbox',lang('Global_postbox'),'required');
        $this->form_validation->set_rules('companies_Postal_code',lang('Global_Postal_code'),'required');

        $this->form_validation->set_rules('companies_Country_id',lang('Global_Country'),'required');
        $this->form_validation->set_rules('companies_Region_id',lang('Global_Region_province'),'required');
        $this->form_validation->set_rules('companies_City_id',lang('Global_City'),'required');
        $this->form_validation->set_rules('companies_District_id',lang('Global_District'),'required');
        $this->form_validation->set_rules('companies_street',lang('Global_street'),'required');
        $this->form_validation->set_rules('companies_building_number',lang('Global_building_number'),'required');
        $this->form_validation->set_rules('companies_address_details',lang('Global_details'),'required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/Company/Form_Add_Company', 'refresh');

        }else{


            $data_companies['LIST_BUSINESS_CATEGORIES']             = $this->input->post('LIST_BUSINESS_CATEGORIES');
            $data_companies['companies_Trade_Name']                 = $this->input->post('companies_Trade_Name');
            $data_companies['companies_Commercial_Registration_No'] = $this->input->post('companies_Commercial_Registration_No');
            $data_companies['companies_Unified_record_number']      = $this->input->post('companies_Unified_record_number');
            $data_companies['Registration_Date']                    = strtotime($this->input->post('Registration_Date'));
            $data_companies['Expiry_Date']                          = strtotime($this->input->post('Expiry_Date'));
            $data_companies['companies_commercial_activities']      = $this->input->post('companies_commercial_activities');
            $data_companies['companies_owner_name']                 = $this->input->post('companies_owner_name');

            $data_companies['owner_Nationality_id']                 = $this->input->post('owner_Nationality_id');
            $data_companies['owner_Identification_Number']          = $this->input->post('owner_Identification_Number');
            $data_companies['owner_Identification_Issued_Date']     = strtotime($this->input->post('owner_Identification_Issued_Date'));
            $data_companies['owner_Identification_Expiry_Date']     = strtotime($this->input->post('owner_Identification_Expiry_Date'));
            $data_companies['owner_Identification_Issued_by']       = $this->input->post('owner_Identification_Issued_by');
            $data_companies['owner_Mobile']                         = $this->input->post('owner_Mobile');
            $data_companies['owner_telephone']                      = $this->input->post('owner_telephone');
            $data_companies['owner_address']                        = $this->input->post('owner_address');

            $data_companies['companies_telephone']                  = $this->input->post('companies_telephone');
            $data_companies['companies_Mobile']                     = $this->input->post('companies_Mobile');
            $data_companies['companies_email']                      = $this->input->post('companies_email');
            $data_companies['companies_website']                    = $this->input->post('companies_website');
            $data_companies['companies_postbox']                    = $this->input->post('companies_postbox');
            $data_companies['companies_Postal_code']                = $this->input->post('companies_Postal_code');
            $data_companies['companies_Country_id']                 = $this->input->post('companies_Country_id');
            $data_companies['companies_Region_id']                  = $this->input->post('companies_Region_id');
            $data_companies['companies_City_id']                    = $this->input->post('companies_City_id');
            $data_companies['companies_District_id']                = $this->input->post('companies_District_id');
            $data_companies['companies_street']                     = $this->input->post('companies_street');
            $data_companies['companies_building_number']            = $this->input->post('companies_building_number');
            $data_companies['companies_address_details']            = $this->input->post('companies_address_details');
            $data_companies['companies_Location_on_Google']         = $this->input->post('companies_Location_on_Google');


            $data_companies['companies_Status']           =  0;
            $data_companies['companies_createBy']         =  $this->aauth->get_user()->id;
            $data_companies['companies_createDate']       =  time();
            $data_companies['companies_lastModifyDate']   =  time();
            $data_companies['companies_isDeleted']        =  0;
            $data_companies['companies_DeletedBy']        =  0;


            $Get_Company = $this->Companies_model->Get_Company_Profile($data_companies['companies_Commercial_Registration_No']);

            if($Get_Company !== false){

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('message_error_Duplicate');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL.'/Company', 'refresh');

            }else{

                    $Create_companies = $this->Companies_model->Create_Company($data_companies);

//                    $group_A = array(
//                        "group_owner"=>$Create_companies,
//                        "name"=>'System administrator',
//                        "group_status"=>1,
//                        "group_main_system"=>1
//                    );
//                    $Create_Group_A = $this->Users_Group_Model->Create_Group($group_A);
//                    insert_translation_Language_item('portal_auth_groups_translation',$Create_Group_A,'مدير النظام','System administrator');
//
//                    $group_B = array(
//                        "group_owner"=>$Create_companies,
//                        "name"=>'data entry',
//                        "group_status"=>1,
//                        "group_main_system"=>1
//                    );
//                    $Create_Group_B = $this->Users_Group_Model->Create_Group($group_B);
//                    insert_translation_Language_item('portal_auth_groups_translation',$Create_Group_B,'مدخل البيانات','data entry');
//
//                    $group_C = array(
//                        "group_owner"=>$Create_companies,
//                        "name"=>'Evaluation Manager',
//                        "group_status"=>1,
//                        "group_main_system"=>1
//                    );
//                    $Create_Group_C = $this->Users_Group_Model->Create_Group($group_C);
//                    insert_translation_Language_item('portal_auth_groups_translation',$Create_Group_C,'مدير التقييم','Evaluation Manager');
//
//                    $group_D = array(
//                        "group_owner"=>$Create_companies,
//                        "name"=>'Coordinator',
//                        "group_status"=>1,
//                        "group_main_system"=>1
//                    );
//                    $Create_Group_D = $this->Users_Group_Model->Create_Group($group_D);
//                    insert_translation_Language_item('portal_auth_groups_translation',$Create_Group_D,'المنسق','Coordinator');
//
//                    $group_F = array(
//                        "group_owner"=>$Create_companies,
//                        "name"=>'Inspector',
//                        "group_status"=>1,
//                        "group_main_system"=>1
//                    );
//                    $Create_Group_F = $this->Users_Group_Model->Create_Group($group_F);
//                    insert_translation_Language_item('portal_auth_groups_translation',$Create_Group_F,'المعاين','Inspector');
//

                    if($Create_companies){
                        $msg_result['key']   = 'Success';
                        $msg_result['value'] = lang('message_success_insert');
                        $msg_result_view = Create_Status_Alert($msg_result);
                        set_message($msg_result_view);
                        redirect(ADMIN_NAMESPACE_URL.'/Company' , 'refresh');
                    }else{
                        $msg_result['key']   = 'Danger';
                        $msg_result['value'] = lang('message_error_insert');
                        $msg_result_view = Create_Status_Alert($msg_result);
                        set_message($msg_result_view);
                        redirect(ADMIN_NAMESPACE_URL.'/Company', 'refresh');
                    }
            }


        } // if($this->form_validation->run()==FALSE){

    }
    ###################################################################


    ###################################################################
    public function Company_Profile()
    {
        $Company_id =  $this->uri->segment(4);

        if(empty($Company_id) or isset_number_value($Company_id)==false){
            redirect(ADMIN_NAMESPACE_URL.'/Company', 'refresh');
        }else{

            $this->data['Company'] = $this->Companies_model->Get_Company_Profile($Company_id)->row();

            if($this->data['Company']->companies_Status == 1) {
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }
            $this->data['Page_Title']  = lang('Management_companies_offices');
            $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
            $this->mybreadcrumb->add($this->data['Page_Title'],'#');
            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
            $this->data['Page_Company'] = $this->load->view('../../modules/System_Company/views/Company_Info',$this->data,true);
            $this->data['PageContent']  = $this->load->view('../../modules/System_Company/views/Company_Profile',$this->data,true);
            Layout_Admin($this->data);
        } // if(empty($Company_id) or isset_number_value($Company_id))

    }
    ###################################################################


    ###################################################################
    public function Company_Group_Users()
    {
        $Company_id =  $this->uri->segment(4);

        if(empty($Company_id) or isset_number_value($Company_id)==false){
            redirect(ADMIN_NAMESPACE_URL.'/Company', 'refresh');
        }else{

            $this->data['Company'] = $this->Companies_model->Get_Company_Profile($Company_id)->row();

            if($this->data['Company']->companies_Status == 1) {
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            $this->data['Page_Title']  = 'ادارة مجموعة المستخدمين';

            $Group_Users = Get_Company_Group_Users($Company_id)->result();
            foreach ($Group_Users AS $row)
            {
                if($row->group_status == 1) {
                    $group_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
                }else{
                    $group_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
                }

                $this->data['Group_Users'][]  = array(
                    "Group_id"          => $row->group_id,
                    "group_translation" => $row->item_translation,
                    "Group_status"      => $group_status,
                    "Group_options"     => '',
                );
            }

            $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
            $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

            $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
            $this->mybreadcrumb->add($this->data['Page_Title'],'#');

            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

            $this->data['Page_Company'] = $this->load->view('../../modules/System_Company/views/Company_Group_Users',$this->data,true);
            $this->data['PageContent']  = $this->load->view('../../modules/System_Company/views/Company_Profile',$this->data,true);

            Layout_Admin($this->data);

        } // if(empty($Company_id) or isset_number_value($Company_id))
    }
    ###################################################################


    ###################################################################
    public function Company_Users()
    {
        $Company_id =  $this->uri->segment(4);

        if(empty($Company_id) or isset_number_value($Company_id)==false){
            redirect(ADMIN_NAMESPACE_URL.'/Company', 'refresh');
        }else{

            $this->data['Company'] = $this->Companies_model->Get_Company_Profile($Company_id)->row();

            if($this->data['Company']->companies_Status == 1) {
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            $Company_Users = Get_Company_Users($Company_id)->result();
            foreach ($Company_Users AS $row)
            {
                if($row->banned == 0) {
                    $User_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
                }else{
                    $User_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
                }

                $this->data['Users'][]  = array(
                    "User_id"          => $row->id,
                    "User_Name_Ar"     => $row->full_name_ar,
                    "User_Name_En"     => $row->full_name,
                    "User_Email"       => $row->email,
                    "User_Group"       => $row->item_translation,
                    "User_status"      => $User_status,
                    "User_options"     => '',
                );
            }


            $this->data['Page_Title']  = 'ادارة المستخدمين';

            $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
            $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

            $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
            $this->mybreadcrumb->add($this->data['Page_Title'],'#');

            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

            $this->data['Page_Company'] = $this->load->view('../../modules/System_Company/views/Company_Users',$this->data,true);
            $this->data['PageContent']  = $this->load->view('../../modules/System_Company/views/Company_Profile',$this->data,true);

            Layout_Admin($this->data);

        } // if(empty($Company_id) or isset_number_value($Company_id))
    }
    ###################################################################

    ###################################################################
    public function Company_Fields()
    {
        $Company_id =  $this->uri->segment(4);

        if(empty($Company_id) or isset_number_value($Company_id)==false){
            redirect(ADMIN_NAMESPACE_URL.'/Company', 'refresh');
        }else{

            $this->data['Company'] = $this->Companies_model->Get_Company_Profile($Company_id)->row();

            if($this->data['Company']->companies_Status == 1) {
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            $this->data['Page_Title']  = lang('Management_companies_offices');
            $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
            $this->mybreadcrumb->add($this->data['Page_Title'],'#');

            $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
            $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

            $this->data['Page_Company'] = $this->load->view('../../modules/System_Company/views/Company_Fields',$this->data,true);
            $this->data['PageContent']  = $this->load->view('../../modules/System_Company/views/Company_Profile',$this->data,true);

            Layout_Admin($this->data);

        } // if(empty($Company_id) or isset_number_value($Company_id))
    }
    ###################################################################

    ###################################################################
    public function Company_Forms()
    {
        $Company_id =  $this->uri->segment(4);

        if(empty($Company_id) or isset_number_value($Company_id)==false){
            redirect(ADMIN_NAMESPACE_URL.'/Company', 'refresh');
        }else{

            $this->data['Company'] = $this->Companies_model->Get_Company_Profile($Company_id)->row();

            if($this->data['Company']->companies_Status == 1) {
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
            $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

            $this->data['Page_Title']  = lang('Management_companies_offices');
            $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
            $this->mybreadcrumb->add($this->data['Page_Title'],'#');

            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

            $this->data['Page_Company'] = $this->load->view('../../modules/System_Company/views/Company_Forms',$this->data,true);
            $this->data['PageContent']  = $this->load->view('../../modules/System_Company/views/Company_Profile',$this->data,true);

            Layout_Admin($this->data);

        } // if(empty($Company_id) or isset_number_value($Company_id))
    }
    ###################################################################

    ###################################################################
    public function Company_Contracts()
    {
        $Company_id =  $this->uri->segment(4);

        if(empty($Company_id) or isset_number_value($Company_id)==false){
            redirect(ADMIN_NAMESPACE_URL.'/Company', 'refresh');
        }else{

            $this->data['Company'] = $this->Companies_model->Get_Company_Profile($Company_id)->row();

            if($this->data['Company']->companies_Status == 1) {
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            $this->data['Page_Title']  = lang('Management_companies_offices');
            $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
            $this->mybreadcrumb->add($this->data['Page_Title'],'#');

            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

            $this->data['Page_Company'] = $this->load->view('../../modules/System_Company/views/Company_Contracts',$this->data,true);
            $this->data['PageContent']  = $this->load->view('../../modules/System_Company/views/Company_Profile',$this->data,true);

            Layout_Admin($this->data);

        } // if(empty($Company_id) or isset_number_value($Company_id))
    }
    ###################################################################

    ###################################################################
    public function Company_Customers()
    {
        $Company_id =  $this->uri->segment(4);

        if(empty($Company_id) or isset_number_value($Company_id)==false){
            redirect(ADMIN_NAMESPACE_URL.'/Company', 'refresh');
        }else{

            $this->data['Company'] = $this->Companies_model->Get_Company_Profile($Company_id)->row();

            if($this->data['Company']->companies_Status == 1) {
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $this->data['Companies_status_badge'] =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }

            $this->data['Page_Title']  = lang('Management_companies_offices');
            $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
            $this->mybreadcrumb->add($this->data['Page_Title'],'#');

            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

            $this->data['Page_Company'] = $this->load->view('../../modules/System_Company/views/Company_Customers',$this->data,true);
            $this->data['PageContent']  = $this->load->view('../../modules/System_Company/views/Company_Profile',$this->data,true);

            Layout_Admin($this->data);

        } // if(empty($Company_id) or isset_number_value($Company_id))
    }
    ###################################################################

}