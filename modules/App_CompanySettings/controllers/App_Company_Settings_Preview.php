<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_Settings_Preview extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' اعداد نظام المعاينة ';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = ' اعداد المعاينين ';
        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/Settings_Users_Preview/index', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Setting_Fees_Preview()
    {
        $lang  = get_current_lang();

        $query = app()->db->select('users.id as users_id ,users.user_uuid as user_uuid, users.full_name as full_name', false);
        $query = app()->db->from('portal_auth_users                 users');
        $query = app()->db->join('portal_auth_user_to_group         user_to_group', 'user_to_group.user_id = users.id');
        $query = app()->db->join('portal_auth_groups                groups_users', 'groups_users.group_id = user_to_group.group_id');
        $query = app()->db->join('portal_auth_groups_translation    Groups_Translation', 'groups_users.group_id = Groups_Translation.item_id');
        $query = app()->db->join('portal_auth_permissions_to_group  Groups_Permissions', 'Groups_Permissions.group_id = groups_users.group_id', 'left');
        $query = app()->db->join('portal_auth_permissions_to_user   Users_Permissions', 'Users_Permissions.user_id = users.id', 'left');
        $query = app()->db->where('users.company_id', $this->aauth->get_user()->company_id);
        $query = app()->db->where('users.banned', 0);
        $query = app()->db->where('( Groups_Permissions.perm_id = 11 OR Users_Permissions.perm_id = 11 )');
        $query = app()->db->where('Groups_Translation.translation_lang', $lang);
        $query = app()->db->get();

        if ($query->num_rows() > 0) {
            $this->data['Users_Preview'] = $query->result();
        } else {
            $this->data['Users_Preview'] = false;
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = ' اعداد المعاينين ';
        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/Settings_Users_Preview/Setting_Fees_Preview', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_Set_Fees_Preview()
    {

        $Preview_userid               = $this->uri->segment(4);

        $where_Property_Types         = array("Property_Types_DeletedBy" => 0);
        $this->data['Property_Types'] = Get_Property_Types($where_Property_Types)->result();

        $query_Users_Preview          = app()->db->where("user_uuid",$Preview_userid);
        $query_Users_Preview          = app()->db->where("banned",0);
        $query_Users_Preview          = app()->db->get("portal_auth_users");
        $this->data['Users_Preview']  = $query_Users_Preview->row();


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = ' اعداد المعاينين ';
        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/Settings_Users_Preview/Form_Set_Fees_Preview', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function Update_Set_Fees_Preview()
    {

        $this->form_validation->set_rules('Users_Preview_id','المعاين','required');
        $this->form_validation->set_rules('Property_Types_id[]','نوع العقار','required');
        $this->form_validation->set_rules('Amount_Preview[]','مبلغ الزيارة ','required');


        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Settings_Preview/Setting_Fees_Preview/', 'refresh');

        }else{


            $Users_Preview_id  = $this->input->post('Users_Preview_id');
            $Property_Types_id = $this->input->post('Property_Types_id');
            $Amount_Preview    = $this->input->post('Amount_Preview');


            $query_Users_Preview          = app()->db->where("user_uuid",$Users_Preview_id);
            $query_Users_Preview          = app()->db->where("banned",0);
            $query_Users_Preview          = app()->db->get("portal_auth_users");
            $Users_Preview                = $query_Users_Preview->row();

            $countarray = count($this->input->post('Property_Types_id'));



            for ($i = 0; $i < $countarray; $i++)
            {

                $Where_Get_Property_Types = array("Property_Types_uuid"=>$Property_Types_id[$i]);
                $Get_Property_Types       = Get_Property_Types($Where_Get_Property_Types)->row();


                $query_preview_fees = app()->db->where('company_id',$this->aauth->get_user()->company_id);
                $query_preview_fees = app()->db->where('preview_fees_userid',$Users_Preview->id);
                $query_preview_fees = app()->db->where('preview_fees_property_types_id',$Get_Property_Types->Property_Types_id);
                $query_preview_fees = app()->db->get('protal_users_preview_fees');

                if($query_preview_fees->num_rows()>0){

                    $query = app()->db->where('company_id',$this->aauth->get_user()->company_id);
                    $query = app()->db->where('preview_fees_userid',$Users_Preview->id);
                    $query = app()->db->where('preview_fees_property_types_id',$Get_Property_Types->Property_Types_id);
                    $query = app()->db->set('lastModifyBy',$this->aauth->get_user()->id);
                    $query = app()->db->set('lastModifyDate',time());
                    $query = app()->db->set('preview_fees_amount',$Amount_Preview[$i]);
                    $query = app()->db->update('protal_users_preview_fees');

                }else{

                    $data_preview_fees['preview_fees_property_types_id']    = $Get_Property_Types->Property_Types_id;
                    $data_preview_fees['preview_fees_userid']               = $Users_Preview->id;
                    $data_preview_fees['preview_fees_amount']               = $Amount_Preview[$i];
                    $data_preview_fees['company_id']                        = $this->aauth->get_user()->company_id;
                    $data_preview_fees['createBy']                          = $this->aauth->get_user()->id;
                    $data_preview_fees['createDate']                        = time();
                    $data_preview_fees['lastModifyBy']                      = 0;
                    $data_preview_fees['lastModifyDate']                    = 0;

                    if($data_preview_fees['preview_fees_amount'] != 0) {
                        $query = app()->db->insert('protal_users_preview_fees', $data_preview_fees);
                    }
                }

            }

            if($query) {
                $msg_result['key']   = 'Success';
                $msg_result['value'] = 'تم التحديث بنجاح';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_Preview/Form_Set_Fees_Preview/'.$Users_Preview_id, 'refresh');
            } else {
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'حصل خطا ما اثناء التحديث ';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_Preview/Form_Set_Fees_Preview/'.$Users_Preview_id, 'refresh');
            }

        } // if($this->form_validation->run()==FALSE)
    }
    ###################################################################

    ###################################################################
    public function Users_Preview_Map()
    {

        $lang = get_current_lang();
        $query = app()->db->select('users.id as users_id , users.full_name as full_name', false);
        $query = app()->db->from('portal_auth_users                 users');
        $query = app()->db->join('portal_auth_user_to_group         user_to_group', 'user_to_group.user_id = users.id');
        $query = app()->db->join('portal_auth_groups                groups_users', 'groups_users.group_id = user_to_group.group_id');
        $query = app()->db->join('portal_auth_groups_translation    Groups_Translation', 'groups_users.group_id = Groups_Translation.item_id');
        $query = app()->db->join('portal_auth_permissions_to_group  Groups_Permissions', 'Groups_Permissions.group_id = groups_users.group_id', 'left');
        $query = app()->db->join('portal_auth_permissions_to_user   Users_Permissions', 'Users_Permissions.user_id = users.id', 'left');
        $query = app()->db->where('users.company_id', $this->aauth->get_user()->company_id);
        $query = app()->db->where('users.banned', 0);
        $query = app()->db->where('( Groups_Permissions.perm_id = 11 OR Users_Permissions.perm_id = 11 )');
        $query = app()->db->where('Groups_Translation.translation_lang', $lang);
        $query = app()->db->get();

        if ($query->num_rows() > 0) {
            $this->data['Users_Preview'] = $query->result();
        } else {
            $this->data['Users_Preview'] = false;
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'توزيع المعاينين على المناطق الجغرافية';
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/Settings_Users_Preview/Setting_Users_Preview_Map', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Form_Set_Users_Preview_Map()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['Page_Title'] = 'توزيع المعاينين على المناطق الجغرافية';
        $this->data['PageContent'] = $this->load->view('../../modules/App_CompanySettings/views/Settings_Users_Preview/Form_Set_Users_Preview_Map', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Update_Set_Users_Preview_Map()
    {

        $this->form_validation->set_rules('Users_Preview', 'المعاين', 'required');
        $this->form_validation->set_rules('Region_id', lang('Global_Region_province'), 'required');
        $this->form_validation->set_rules('City_id', lang('Global_City'), 'required');

        if ($this->form_validation->run() == FALSE) {

            $msg_result['key'] = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Settings/Users_Preview_Map', 'refresh');

        } else {

            $Users_Preview = $this->input->post('Users_Preview');
            $Region_id     = $this->input->post('Region_id');
            $City_id       = $this->input->post('City_id');

//            if (is_array($this->input->post('District_id'))) {
//                $districts = @implode(',', $this->input->post('District_id'));
//            } else {
//                $districts = $this->input->post('District_id');
//            }
            $districts = '';

            $Update_Assignment_Map = Update_Assignment_Map_users_preview($Users_Preview,$Region_id,$City_id,$districts);

            if($Update_Assignment_Map){
                $msg_result['key']   = 'Success';
                $msg_result['value'] = 'تم تحديث المنطقة الجغرافية للمعاين';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_Preview/Users_Preview_Map', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'حصل خطا اثناء التحديث';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_Preview/Users_Preview_Map', 'refresh');
            }

        } // if ($this->form_validation->run() == FALSE)

    }
    ###################################################################



}