<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Transactions extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'ادارة المعاملات';
    }
    ###################################################################

    # DONE
    ###################################################################
    public function index()
    {

            $this->data['Page_Title']      = 'استعراض الطلبات ';
            $where_Transactions            = array();
            $Transactions                  = array();
            $options_transaction           = array();
            $Create_Options                = array();

            #####################################################################
            # Where departments User
            #####################################################################
            // Permissions = 12 All Transactions For Company
            if(Check_Permissions(12)) {

                $where_Transactions = array(
                    "company_id"             => $this->aauth->get_user()->company_id,
                    "location_id"            => $this->aauth->get_user()->locations_id,
                    "Transaction_Stage !="   => 'END_THE_TRANSACTION',
                );

            }else{

                $user_departments_id  = $this->aauth->get_user()->departments_id;
                $get_departments_info = Get_Departments(array("departments_id" => $user_departments_id))->row();

                $where_Transactions   = array(
                  "company_id"             => $this->aauth->get_user()->company_id,
                  "location_id"            => $this->aauth->get_user()->locations_id,
                  //"Transaction_Stage"      => $get_departments_info->departments_key,
                  "Transaction_Stage !="   => 'END_THE_TRANSACTION',
                );

            }

            $Get_Transactions  = Get_Transaction($where_Transactions);
            //echo $this->db->last_query();
            #####################################################################
            # Where departments Users
            #####################################################################

            if($Get_Transactions->num_rows()>0){

                foreach ($Get_Transactions->result() as $ROW)
                {

                            # Where Transaction Assign Users
                            $where_Transaction_Assign = array(
                                "assign_userid"  => $this->aauth->get_user()->id,
                                "transaction_id" => $ROW->transaction_id,
                                "assign_type"    => 1
                            );
                            $Get_Transaction_Assign   = Get_Transaction_Assign($where_Transaction_Assign);

                            // Assign Users OR Permissions All Transactions
                            if($Get_Transaction_Assign->num_rows()>0 or Check_Permissions(12)){

                                $options_transaction['view'] = array("class"=>'',"id"=>'',"title"=> '',"data-attribute"=>'',"icon"=> '',"href"=> base_url(APP_NAMESPACE_URL.'/Transactions/View_Transaction/'.$ROW->uuid));

                                if(count($options_transaction)>0){
                                    $Create_Options =  Create_Options_Button($options_transaction);
                                }else{
                                    $Create_Options = '';
                                    $options_transaction = '';
                                }

                                $Transactions[] = array(
                                    "transaction_id"            => $ROW->transaction_id,
                                    "transaction_number"        => $ROW->transaction_number,
                                    "transaction_uuid"          => $ROW->uuid,
                                    "Transaction_Stage"         => $ROW->Transaction_Stage,
                                    "Transaction_Status_id"     => $ROW->Transaction_Status_id,
                                    "Create_Transaction_By_id"  => $ROW->Create_Transaction_By_id,
                                    "Create_Transaction_Date"   => $ROW->Create_Transaction_Date,
                                    "transaction_options"       => $Create_Options
                                );

                                $options_transaction = array();

                            } // if($Get_Transaction_Assign->num_rows()>0)

                }
            }else{
                $Transactions = false;
            }

            $this->data['Transactions']  = $Transactions;
            $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
            $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

            $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));

            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
            $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/List_Transactions', $this->data, true);

            Layout_Apps($this->data);
    }
    ###################################################################


    # Start :: View_File_Transaction
    ###################################################################
    public function View_Transaction()
    {

        $this->data['Page_Title']      = 'استعراض المعاملة ';

        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"          => $Transaction_id,
            "company_id"    => $this->aauth->get_user()->company_id,
            "location_id"   => $this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $this->data['Transactions']     = $Get_Transactions->row();
            Create_Logs_User('View_Transaction',$this->data['Transactions']->transaction_id,'Transaction','View');

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/View_Transaction/View_Transactions', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################
    # End :: View_File_Transaction


    #Start :: Edit DATA ENTRANTS
    ###################################################################
    public function Edit_Data_Transaction()
    {
        $this->data['Page_Title']     = 'تعديل بيانات المعاملة';

        $Transaction_id   =  $this->uri->segment(4);
        $Forms_id         =  $this->uri->segment(5);
        $components_id    =  $this->uri->segment(6);
        $Fields_key       =  $this->uri->segment(7);

        $where_Transactions = array(
            "uuid"        => $Transaction_id,
            "company_id"  => $this->aauth->get_user()->company_id,
        );
        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $Where_Fields_Components = array("Forms_id" => $Forms_id, "Components_id" => $components_id, "Fields_key" => $Fields_key);
            $Query_Fields            = Query_Fields_Components($Where_Fields_Components);

            if($Query_Fields->num_rows()>0){
                $this->data['Query_Fields'] = $Query_Fields->row();
                $this->data['Transactions']  = $Get_Transactions->row();
            }else{
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = ' عملية غير صحيحة ';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
            }

            Create_Logs_User('Edit_Data_Transaction','','Transaction','Edit_Data');

            $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

            $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Edit_Data_Transaction', $this->data, true);
            $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
            Layout_Apps($this->data);


        }else{
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = ' عملية غير صحيحة ';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

    }
    ###################################################################


    ###################################################################
    public function Update_Data_Transactions()
    {

        $this->data['Page_Title']     = ' تحديث بيانات الحقل';

        $POST_Fields = $_POST;

        $Transaction_uuid = $this->uri->segment(4);

        $this->form_validation->set_rules('data_uuid','','required');
        $this->form_validation->set_rules('Form_id','','required');
        $this->form_validation->set_rules('Components_id','','required');
        $this->form_validation->set_rules('Transaction_id','','required');
        $this->form_validation->set_rules('Reason_modification','','required');

        foreach($POST_Fields AS $key => $value) {


            //ignore $_POST
            if ($key == 'Form_id' or $key == "ci_csrf_token" or $key == "Components_id" or $key == "Transaction_id" or $key == 'Reason_modification') {

            } else {

                $explode_Post = explode("-", $key);

                $Fields_Components = Query_Fields_Components(array("Forms_id" => $explode_Post[1], "Components_id" => $explode_Post[2], "Fields_key" => $explode_Post[0]));

                if($Fields_Components->num_rows()>0){

                    $data_Transaction_history = array(
                        "Transaction_id"      => $this->input->post('Transaction_id', TRUE),
                        "company_id"          => $this->aauth->get_user()->company_id,
                        "data_key"            => $explode_Post[0],
                        "data_value"          => $this->input->post($key, TRUE),
                        "Forms_id"            => $explode_Post[1],
                        "Components_id"       => $explode_Post[2],
                        "History"             => "Update",
                        "Reason_modification" => $this->input->post('Reason_modification', TRUE),
                        "data_Create_id"      => $this->aauth->get_user()->id,
                        "data_Create_time"    => time(),
                    );

                    $query = app()->db->insert('protal_transaction_data_history',$data_Transaction_history);


                    $update_query  = app()->db->where('Transaction_id',$this->input->post('Transaction_id', TRUE));
                    $update_query  = app()->db->where('Forms_id',$explode_Post[1]);
                    $update_query  = app()->db->where('Components_id',$explode_Post[2]);
                    $update_query  = app()->db->where('company_id',$this->aauth->get_user()->company_id);
                    $update_query  = app()->db->where('data_key',$explode_Post[0]);
                    $update_query  = app()->db->set('data_value',$this->input->post($key, TRUE));
                    $update_query  = app()->db->update('protal_transaction_data');

                    if($update_query) {
                        $msg_result['key']   = 'Success';
                        $msg_result['value'] = 'تم الحذف بنجاح';
                        $msg_result_view     = Create_Status_Alert($msg_result);
                        set_message($msg_result_view);
                        redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transaction_uuid, 'refresh');
                    }else{
                        $msg_result['key']   = 'Danger';
                        $msg_result['value'] = 'طريقة غير صحيحة ';
                        $msg_result_view     = Create_Status_Alert($msg_result);
                        set_message($msg_result_view);
                        redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transaction_uuid, 'refresh');
                    }

                }else{
                    $msg_result['key']   = 'Danger';
                    $msg_result['value'] = 'طريقة غير صحيحة';
                    $msg_result_view     = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transaction_uuid, 'refresh');
                } // if($Fields_Components->num_rows()>0)

            } // if ($key == 'Form_id'

        } // foreach($POST_Fields AS $key => $value)

    }
    ###################################################################
    #End :: Edit DATA ENTRANTS

    #Start :: History
    ###################################################################
    public function History_Data_Transaction()
    {

        $this->data['Page_Title']     = '  سجل بيانات الحقل';


        $Transaction_id   =  $this->uri->segment(4);
        $Forms_id         =  $this->uri->segment(5);
        $components_id    =  $this->uri->segment(6);
        $Fields_key       =  $this->uri->segment(7);

        $where_Transactions = array("uuid" => $Transaction_id,"company_id"=>$this->aauth->get_user()->company_id);

        $Get_Transactions  = Get_Transaction($where_Transactions);
        if($Get_Transactions->num_rows()>0){

            $Where_Fields_Components = array("Forms_id" => $Forms_id, "Components_id" => $components_id, "Fields_key" => $Fields_key);
            $Query_Fields            = Query_Fields_Components($Where_Fields_Components);

            if($Query_Fields->num_rows()>0){


                $this->data['Query_Fields']    = $Query_Fields->row();
                $this->data['Transactions']    = $Get_Transactions->row();

                $History_Fields = app()->db->where('Transaction_id',$this->data['Transactions']->transaction_id);
                $History_Fields = app()->db->where('company_id',$this->aauth->get_user()->company_id);
                $History_Fields = app()->db->where('Forms_id',$Forms_id);
                $History_Fields = app()->db->where('Components_id',$components_id);
                $History_Fields = app()->db->where('data_key',$Fields_key);
                $History_Fields = app()->db->get('protal_transaction_data_history');

                $this->data['History_Fields']  = $History_Fields;

                $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
                $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
                $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

                $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/View_Transaction/History_Data_Transaction', $this->data, true);
                $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
                Layout_Apps($this->data);

            }else{
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = ' عملية غير صحيحة ';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
            }

        }else{
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = ' عملية غير صحيحة ';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }


    }
    ###################################################################
    #End :: History


    #Start :: Notes_Transaction
    ###################################################################
    public function Notes_Transaction()
    {
        $this->data['Page_Title']     = ' ملاحظات ';

        $Transaction_id   =  $this->uri->segment(4);

        $where_Transactions = array();
        $where_Transactions = array("uuid" => $Transaction_id,"company_id"=> $this->aauth->get_user()->company_id);
        $Get_Transactions   = Get_Transaction($where_Transactions);


        if($Get_Transactions->num_rows() == 0){

            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');

        }else{

            $this->data['Transactions']  = $Get_Transactions->row();


            $Get_Note_Transactions = app()->db->where('Transactions_id',$this->data['Transactions']->transaction_id);
            $Get_Note_Transactions = app()->db->where('IsDeleted',0);
            $Get_Note_Transactions = app()->db->get('protal_transaction_notes');

            $this->data['Get_Note_Transactions']  = $Get_Note_Transactions;

            $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));

            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
            $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Notes_Transaction', $this->data, true);
            $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
            Layout_Apps($this->data);

        }

    }
    ###################################################################

    #Start :: Form Notes Transaction
    ###################################################################
    public function Form_Notes_Transaction()
    {
        $this->data['Page_Title']     = ' ملاحظات ';

        $Transaction_id   =  $this->uri->segment(4);

        $where_Transactions = array();
        $where_Transactions = array("uuid" => $Transaction_id,"company_id"=> $this->aauth->get_user()->company_id);
        $Get_Transactions   = Get_Transaction($where_Transactions);


        if($Get_Transactions->num_rows() == 0){

            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');

        }else{

            $this->data['Transactions']  = $Get_Transactions->row();

            $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
            $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));

            $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
            $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Form_Notes_Transaction', $this->data, true);
            $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
            Layout_Apps($this->data);

        }

    }
    ###################################################################

    #Start :: Create Note Transaction
    ###################################################################
    public function Create_Note_Transaction()
    {
        $Transaction_id   =  $this->uri->segment(4);

        $this->form_validation->set_rules('Note_Transaction','لا يوجد ملاحظات للحفظ','required');

        if($this->form_validation->run()==FALSE){

            redirect(APP_NAMESPACE_URL.'/Transactions/Form_Notes_Transaction/'.$this->uri->segment(4), 'refresh');

        }else{

            $where_Transactions = array();
            $where_Transactions = array("uuid" => $Transaction_id,"company_id"=> $this->aauth->get_user()->company_id);
            $Get_Transactions   = Get_Transaction($where_Transactions)->row();

            Create_Logs_User('Notes_Transaction','','Transaction','Create_Note_Transaction');

            $Note_Transaction_Data = array();

            $Note_Transaction_Data['Transactions_id']   = $Get_Transactions->transaction_id;
            $Note_Transaction_Data['Note_Transaction']  = $this->input->post('Note_Transaction');
            $Note_Transaction_Data['createDate']        = time();
            $Note_Transaction_Data['createBy']          = $this->aauth->get_user()->id;

            $create_note = app()->db->insert('protal_transaction_notes',$Note_Transaction_Data);

            if($create_note) {
                $msg_result['key']      = 'Success';
                $msg_result['value']    = 'تم حفظ الملاحظة بنجاح';
                $msg_result_view        = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/Notes_Transaction/'.$this->uri->segment(4), 'refresh');
            } else {
                $msg_result['value']    = 'لم تتم الاضافة فضلا حاول مجدداً';
                $msg_result['key']      = 'Danger';
                $msg_result_view        = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$this->uri->segment(4), 'refresh');
            }



        }

    }
    ###################################################################


    #Start :: stages_self Transaction
    ###################################################################
    public function Stages_Self()
    {

          $this->data['Page_Title']     = ' ادارة مراحل البناء الذاتي  ';

          $Transaction_id     =  $this->uri->segment(4);

          $where_Transactions = array();
          $where_Transactions = array("uuid" => $Transaction_id,"company_id"=> $this->aauth->get_user()->company_id);
          $Get_Transactions   = Get_Transaction($where_Transactions);

          $this->data['Transactions']  = $Get_Transactions->row();

          $Get_Stages_Self = $this->db->where('company_id',$this->aauth->get_user()->company_id);
          $Get_Stages_Self = $this->db->where('transactions_id',$this->data['Transactions']->transaction_id);
          $Get_Stages_Self = $this->db->get('portal_transaction_stages_self_construction');

          $this->data['stages_self_construction']  = $Get_Stages_Self;

          $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
          $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));

          $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
          $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/View_Transaction/stages_self', $this->data, true);
          $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);

          Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Form_Stages_Self()
    {


    }
    ###################################################################

    ###################################################################
    public function Create_Stages_Self()
    {

    }
    ###################################################################

}