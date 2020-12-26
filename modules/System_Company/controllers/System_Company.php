<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Company extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();


        $this->data['controller_name'] = lang('Management_companies_offices');
    }
    ###################################################################

    ###################################################################
    public function index()
    {

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

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

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
        $data_companies['companies_createBy']         =  0;
        $data_companies['companies_createDate']       =  time();
        $data_companies['companies_lastModifyDate']   =  time();
        $data_companies['companies_isDeleted']        =  0;
        $data_companies['companies_DeletedBy']        =  0;







    }
    ###################################################################

}