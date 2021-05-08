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
            $Transactions                  = array();
            $options_transaction           = array();
            $Create_Options                = array();



            #####################################################################
            # Where departments User
            #####################################################################
            $user_departments_id  = $this->aauth->get_user()->departments_id;
            $get_departments_info = Get_Departments(array("departments_id"=>$user_departments_id))->row();

            // Permissions = 12 All Transactions For Company
            if(Check_Permissions(12)) {

                $where_Transactions = array("company_id" => $this->aauth->get_user()->company_id);

            }else{

                if($get_departments_info->department_supervisor == $this->aauth->get_user()->id){
                    $where_Transactions = array(
                        "company_id"        => $this->aauth->get_user()->company_id,
                        "location_id"       => $this->aauth->get_user()->locations_id,
                        "Transaction_Stage" => $get_departments_info->departments_key,
                    );
                }

            }

            $Get_Transactions  = Get_Transaction($where_Transactions);
            #####################################################################
            # Where departments Users
            #####################################################################



            if($Get_Transactions->num_rows()>0){

                foreach ($Get_Transactions->result() as $ROW)
                {

                            # Where Transaction Assign Users
                            $where_Transaction_Assign = array("assign_userid"=> $this->aauth->get_user()->id,"transaction_id"=> $ROW->transaction_id);
                            $Get_Transaction_Assign   = Get_Transaction_Assign($where_Transaction_Assign);

                            if($Get_Transaction_Assign->num_rows()>0){
                                $Assign = array();
                                foreach ($Get_Transaction_Assign->result() AS $RAS)
                                {
                                   $Assign[] = array("assign_userid" => $RAS->assign_userid, "assign_time"   => $RAS->assign_time);
                                }
                            }else{
                                $Assign = false;
                            }

                            $options_transaction['view'] = array("class"=>'',"id"=>'',"title"=> '',"data-attribute"=>'',"icon"=> '',"href"=> base_url(APP_NAMESPACE_URL.'/Transactions/View_Transaction/'.$ROW->uuid));

                            // DATA_ENTRY
                            if($ROW->Transaction_Stage == 'DATA_ENTRY' and Check_Permissions(13)) {
                              $options_transaction['edit'] = array("class" => '',"id" => '',"title" => 'استكمال البيانات و المراجعة',"data-attribute" => '',"icon"  => '',"href"  => base_url(APP_NAMESPACE_URL . '/Transactions/Check_DataEntries/' . $ROW->uuid));
                            }

                            // Coordination
                            if($ROW->Transaction_Stage == 'COORDINATION_AND_QUALITY') {
                                $options_Preview['Feedback'] = array("class" => '', "id" => '', "title" => 'افادة المعاين', "data-attribute" => '', "icon" => '', "href" => "#");
                            }

                            if(Check_Permissions(14)){
                                $options_transaction['Assignment'] = array("class"=> '',"id"=> '',"title"=> 'اسناد المعاملة لموظف اخر',"data-attribute" => '',"icon"=> '',"href" => base_url(APP_NAMESPACE_URL.'/Transactions/Assign_Transaction/'.$ROW->uuid));
                            }

                            if(count($options_transaction)>0){
                                $Create_Options =  Create_Options_Button($options_transaction);
                            }else{
                                $Create_Options = '';
                                $options_transaction = '';
                            }

                                $Transactions[] = array(
                                    "transaction_id" => $ROW->transaction_id,
                                    "transaction_number" => $ROW->transaction_number,
                                    "transaction_uuid" => $ROW->uuid,
                                    "Transaction_Stage" => $ROW->Transaction_Stage,
                                    "Transaction_Status_id" => $ROW->Transaction_Status_id,
                                    "Create_Transaction_By_id" => $ROW->Create_Transaction_By_id,
                                    "Create_Transaction_Date" => $ROW->Create_Transaction_Date,
                                    "transaction_options" => $Create_Options
                                );

                            $options_transaction = array();
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


    # Start :: Checking Transaction
    # Done
    ###################################################################
    public function Checking_Transaction()
    {
        $this->data['Page_Title']     = 'الاستعلام ';

        Create_Logs_User('Query_Transaction','','Transaction','Query');


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Transactions'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Checking_Transaction/Checking_Transaction', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################
    # Done
    ###################################################################
    public function Check_Ajax_Transactions()
    {

        $INSTRUMENT_NUMBER                = $this->input->get('INSTRUMENT_NUMBER',true);
        $COMMISSIONING_NUMBER             = $this->input->get('COMMISSIONING_NUMBER',true);
        $OWNER_APPLICANT_IDENTITY_NUMBER  = $this->input->get('OWNER_APPLICANT_IDENTITY_NUMBER',true);

        $company_id = $this->aauth->get_user()->company_id;

        $Transaction_data   = array();
        $msg                = array();


        $send_data_button = array(
            "INSTRUMENT_NUMBER"    => $INSTRUMENT_NUMBER,
            "COMMISSIONING_NUMBER" => $COMMISSIONING_NUMBER
        );


        if(!empty($INSTRUMENT_NUMBER) or !empty($COMMISSIONING_NUMBER) or !empty($OWNER_APPLICANT_IDENTITY_NUMBER)) {

            if ($INSTRUMENT_NUMBER) {
                $Get_Transaction_data = $this->db->where(" ( FIND_IN_SET('INSTRUMENT_NUMBER',data_key) AND FIND_IN_SET(" . $INSTRUMENT_NUMBER . ",data_value) AND `company_id` = (" . $this->aauth->get_user()->company_id . ")  ) ");
            }

            if ($COMMISSIONING_NUMBER) {
                $Get_Transaction_data = $this->db->or_where(" ( FIND_IN_SET('COMMISSIONING_NUMBER',data_key) AND FIND_IN_SET(" . $COMMISSIONING_NUMBER . ",data_value) AND `company_id` = (" . $this->aauth->get_user()->company_id . ")  ) ");
            }

            if ($OWNER_APPLICANT_IDENTITY_NUMBER) {
                $Get_Transaction_data = $this->db->or_where(" ( FIND_IN_SET('OWNER_APPLICANT_IDENTITY_NUMBER',data_key) AND FIND_IN_SET(" . $OWNER_APPLICANT_IDENTITY_NUMBER . ",data_value) AND `company_id` = (" . $this->aauth->get_user()->company_id . ")  ) ");
            }

            $Get_Transaction_data = $this->db->get('protal_transaction_data');

            if ($Get_Transaction_data->num_rows() > 0) {

                $where_Transactions = array(
                    "company_id" => $this->aauth->get_user()->company_id,
                    "transaction_id" => $Get_Transaction_data->row()->Transaction_id
                );

                $Get_Transactions = Get_Transaction($where_Transactions);

                if ($Get_Transactions->num_rows() > 0) {

                    foreach ($Get_Transactions->result() as $R) {

                        $Transaction_data[] = array(
                            "transaction_id"            => $R->transaction_id,
                            "transaction_number"        => $R->transaction_number,
                            "transaction_uuid"          => $R->uuid,
                            "Transaction_Stage"         => $R->Transaction_Stage,
                            "Transaction_Status_id"     => $R->Transaction_Status_id,
                            "Create_Transaction_By_id"  => $R->Create_Transaction_By_id,
                            "Assignment_userid"         => $R->Assignment_userid,
                            "Create_Transaction_Date"   => $R->Create_Transaction_Date
                        );

                    } // foreach ($where_Transactions_data->result() AS $R )

                    $data_x['Transaction_data'] = $Transaction_data;

                    $msg['success'] = true;
                    $msg['Transaction_Table'] = $this->load->view("../../modules/App_Transactions/views/Checking_Transaction/Template_Instrument_Number_By_Transactions", $data_x, true);

                } else {

                    // Permissions Create Transaction
                    if(Check_Permissions(12) or Check_Permissions(9)) {
                        $Transaction_Table = Create_Status_Alert(array("key" => "Success", "value" => "لا يوجد معاملات مضافة  متطابقة مع المدخلات يمكنك الاستمرار "));
                    }

                    $Transaction_Table .= $this->load->view("../../modules/App_Transactions/views/Checking_Transaction/Button_Create_Transaction",$send_data_button, true);
                    $msg['success']    = true;
                    $msg['Transaction_Table'] = $Transaction_Table;

                }

            } else {
                $Transaction_Table  = Create_Status_Alert(array("key" => "Success", "value" => "لا يوجد معاملات مضافة  متطابقة مع المدخلات يمكنك الاستمرار "));
                $Transaction_Table .= $this->load->view("../../modules/App_Transactions/views/Checking_Transaction/Button_Create_Transaction",$send_data_button, true);

                $msg['success']           = true;
                $msg['Transaction_Table'] = $Transaction_Table;

            } // if($where_Transactions_data->num_rows()>0)
        }
        $msg['success'] = true;

        echo json_encode($msg);

    }
    ###################################################################
    # End :: Checking Transaction



    # DONE
    ###################################################################
    public function Create_Transaction()
    {

        if(!Check_Permissions(12) or !Check_Permissions(9)) {


        }

        $this->data['Page_Title']     = 'استلام طلب جديد';

        Create_Logs_User('Create_Transaction','','Transaction','Create');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Transactions'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Create_Transaction/Create_Transaction', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################


    // DONE
    ###################################################################
    public function Create_Transaction_Submit()
    {

        $POST_Fields           = $_POST;
        $Form_id               = $this->input->post('Form_id');
        $data_Transaction      = array();
        $data_Transaction2     = array();
        $data_Transaction1     = array();
        $files_Transaction_ids = array();


        $files_Transaction_ids = @$_POST['files_Transaction_ids'];

        if(@$files_Transaction_ids){

        }else{
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'لا يمكن انشاء معاملة بدون مرفقات';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/Create_Transaction', 'refresh');
            exit;
        }

        foreach($POST_Fields AS $key => $value)
        {

            //ignore $_POST
            if($key == 'Assignment_userid' or $key =="ci_csrf_token" or $key =="Form_id" or $key =="FILE_Name" or $key =="FILE" or $key=='file_name' or $key=='LIST_TRANSACTION_DOCUMENTS'
            or $key =='files_Transaction_ids'){

            }else {

                $explode_Post = explode("-",$key);

                $Fields_Components = Query_Fields_Components(
                    array("Forms_id"=> $explode_Post[1], "Components_id" => $explode_Post[2],"Fields_key" => $explode_Post[0])
                );

                if ($Fields_Components->num_rows() > 0) {

                    $Get_validating_Fields         = Get_validating_Fields(array("Forms_id" => $Form_id,"Components_id" => $Fields_Components->row()->Components_id, "company_id" => 0, "Fields_id" => $Fields_Components->row()->Fields_id));


                    if ($Get_validating_Fields->num_rows() > 0) {

                        if($Fields_Components->row()->Fields_Type == 'Fields') {
                            $Get_Fields = Get_Fields(array("Fields_id" => $Fields_Components->row()->Fields_id))->row();
                            Building_form_validation($key, $Get_Fields->item_translation, $Get_validating_Fields->row()->validating_rules);
                        }elseif($Fields_Components->row()->Fields_Type == 'List') {
                            $Get_List = Get_All_List(array("list_id" => $Fields_Components->row()->Fields_id))->row();
                            Building_form_validation($key, $Get_List->item_translation, $Get_validating_Fields->row()->validating_rules);
                        }

                        if ($this->form_validation->run() == FALSE) {
                            $msg_result['key'] = 'Danger';
                            $msg_result['value'] = validation_errors();
                            $msg_result_view = Create_Status_Alert($msg_result);
                            set_message($msg_result_view);
                            redirect(APP_NAMESPACE_URL . '/Transactions/Create_Transaction/', 'refresh');
                        }else {
                            $data_Transaction1[] = array(
                                "data_key"      => $explode_Post[0],
                                "data_value"    => $this->input->post($key, TRUE),
                                "Forms_id"      => $Form_id,
                                "Components_id" => $explode_Post[2]
                            );
                        }

                    }else{
                        $data_Transaction2[] = array(
                            "data_key"      => $explode_Post[0],
                            "data_value"    => $this->input->post($key, TRUE),
                            "Forms_id"      => $Form_id,
                            "Components_id" => $explode_Post[2]
                        );
                    } // if ($Get_validating_Fields->num_rows() > 0)

                } // if($Fields_Components->num_rows()>0)

            } // ignore $_POST

        } // foreach ($POST_Fields AS $field)


        $data_Transaction = array_merge($data_Transaction1,$data_Transaction2);
        ##########################################################################################################################################
        # START :: INSERT DB Transaction

        $where_Transaction_Stage = array(
            "stages_key" => 'DATA_ENTRY',
            "company_id" => $this->aauth->get_user()->company_id
        );

        $Get_Stages = Get_Stages_Transaction_Company($where_Transaction_Stage)->row();

        $data_Transaction_static['transaction_number']        = date('Ymd');
        $data_Transaction_static['company_id']                = $this->aauth->get_user()->company_id;
        $data_Transaction_static['location_id']               = $this->aauth->get_user()->locations_id;
        $data_Transaction_static['Transaction_Status_id']     = '194';
        $data_Transaction_static['Transaction_Stage']         = $Get_Stages->stages_key;
        $data_Transaction_static['Create_Transaction_By_id']  = $this->aauth->get_user()->id;
        $data_Transaction_static['Create_Transaction_Date']   = time();

        $Create_Transaction              = Create_Transaction($data_Transaction_static);
        $Create_Transaction_data         = Create_Transaction_data($Create_Transaction,$data_Transaction);
        $Create_Transaction_data_history = Create_Transaction_data_history($Create_Transaction,$data_Transaction,'Create');

        $data_Transaction_Assign = array();
        $data_Transaction_Assign['transaction_id'] = $Create_Transaction;
        $data_Transaction_Assign['assign_userid']  = $this->input->post('Assignment_userid');
        $data_Transaction_Assign['assign_time']    = time();
        $data_Transaction_Assign['assign_type']    = 1;
        $Create_Transaction_Assign                 = Create_Transaction_Assign($data_Transaction_Assign);

        # END :: DB Transaction
        ##########################################################################################################################################


        // update file
        ##########################################################################################################################################
        if($Create_Transaction and $Create_Transaction_data){

                $files_Transaction_ids = $_POST['files_Transaction_ids'];
                foreach ($files_Transaction_ids AS $row_uuid)
                {
                    app()->db->where('uuid',$row_uuid);
                    app()->db->set('Transaction_id',$Create_Transaction);
                    app()->db->update('protal_transaction_files');
                }


                $Assignment_Notifications = array(
                  "notifications_to_user"  => $this->input->post('Assignment_userid'),
                  "notifications_type"     => "TRANSACTION",
                  "notifications_title"    => lang('Notifications_Assignment_Transaction_title'),
                  "notifications_text"     => lang('Notifications_Assignment_Transaction_text')
                );
                Create_Notifications($Assignment_Notifications);


                Create_Logs_User('Create_Transaction',$Create_Transaction,'Transaction','Create');

                $Data_Email['to']      = $this->aauth->get_user($this->input->post('Assignment_userid'))->email;
                $Data_Email['from']    = '';
                $Data_Email['subject'] = 'تم اسناد معاملة ';
                $Data_Email['message'] = $this->load->view('../../modules/Template_Email/Transactions/Assignment_Transaction_User',$Data_Email, true);
                Create_Email_Notifications($Data_Email);

                $msg_result['key']   = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');

        } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = validation_errors();
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions', 'refresh');
        }

    }
    ###################################################################



    /*
     * Start :: Edit DATA ENTRANTS
     */
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
            $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Edit_Data_Transaction', $this->data, true);
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

    } // public function Update_Data_Transactions()
    ###################################################################

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
                $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Data_Entry/History_Data_Transaction', $this->data, true);
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
    /*
     * End :: Edit DATA ENTRANTS
     */


    /*
     *  View_File_Transaction
     */
    ###################################################################
    public function View_Transaction()
    {

        $this->data['Page_Title']      = 'استعراض المعاملة ';

        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"                     => $Transaction_id,
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $this->data['Transactions']   = $Get_Transactions->row();

            $where_Transactions_data = array("Transaction_id" => $this->data['Transactions']->transaction_id);

            $Transactions_data       = Get_Transaction_data($where_Transactions_data)->result();

            foreach ($Transactions_data AS $RTD)
            {
                $this->data['data_transactions'][$RTD->data_key] = array(
                    "data_value"       => $RTD->data_value,
                    "data_Create_id"   => $RTD->data_Create_id,
                    "data_Create_time" => $RTD->data_Create_time
                );
		    }

            Create_Logs_User('View_Transaction',$this->data['Transactions']->transaction_id,'Transaction','View');

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/View_Transactions', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function View_File_Transaction()
    {

        $Transaction_id     =  $this->uri->segment(4);

        $where_Transactions = array("uuid"=> $Transaction_id, "company_id"  => $this->aauth->get_user()->company_id);
        $Get_Transactions   = Get_Transaction($where_Transactions)->row();

        $query = $this->db->where('transaction_id',$Get_Transactions->transaction_id);
        $query = $this->db->order_by('files_sort','ASC');
        $query = $this->db->where('file_isDeleted !=',1);
        $query = $this->db->get('protal_transaction_files');

        $Company_domain         = Get_Company($this->aauth->get_user()->company_id)->companies_Domain;
        $Uploader_path          = FCPATH.'uploads/companies/' . $Company_domain . '/' . FOLDER_FILE_Transaction_COMPANY.'/';
        $Uploader_path_combine  = FCPATH.'uploads/tmp_combine_pdf/';

        foreach ($query->result() AS $RF)
        {
            if($RF->watermark == 0)
            {

                $this->load->library('Arabic',array());

                $wm_text_text_Transaction        = $this->arabic->utf8Glyphs('رقم المعاملة:');
                $wm_text_number_Transaction      = date('Ymd',$Get_Transactions->Create_Transaction_Date).$Get_Transactions->transaction_id;
                $wm_text_date_text_Transaction   = $this->arabic->utf8Glyphs('التاريخ:');
                $wm_text_date_number_Transaction = date('Y-m-d',$Get_Transactions->Create_Transaction_Date);
                $wm_text_time_Transaction        = $this->arabic->utf8Glyphs('الوقت:');
                $wm_text_time_number_Transaction = date('h:s:i a',$Get_Transactions->Create_Transaction_Date);

                $wm_text = $wm_text_time_number_Transaction.' '.$wm_text_time_Transaction.' '.$wm_text_date_number_Transaction.' '.$wm_text_date_text_Transaction.' '.$wm_text_number_Transaction.' '.$wm_text_text_Transaction;

                $imgConfig['source_image']      = $Uploader_path.$RF->file_name;
                $imgConfig['wm_text']           = $wm_text;
                $imgConfig['wm_type']           = 'text';
                $imgConfig['wm_font_size']      = '24';
                $imgConfig['quality']           = '100';
                $imgConfig['wm_font_path']      = FCPATH.'Assets/fonts/arial.ttf';
                $imgConfig['wm_font_color']     = 'ff0309';
                $imgConfig['wm_shadow_color']   = '000';
                $imgConfig['wm_shadow_color']   = '1';
                $imgConfig['wm_vrt_alignment']  = 'top';
                $imgConfig['wm_hor_alignment']  = 'center';
                $imgConfig['wm_padding']        = '1';

                $this->load->library('image_lib', $imgConfig);
                $this->image_lib->initialize($imgConfig);
                $this->image_lib->watermark();

                app()->db->where('file_uplode_id ',$RF->file_uplode_id);
                app()->db->set('watermark ',1);
                app()->db->update('protal_transaction_files');

            }
            $array_file[] = $Uploader_path.$RF->file_name;
        }

        $filename = "Transaction_combine_".date('Ymd',$Get_Transactions->Create_Transaction_Date).''.$Get_Transactions->transaction_id.'.pdf';

        if(!is_dir(realpath('uploads/tmp_combine_pdf/'.$filename))){

            $pdf  = new Imagick($array_file);
            $pdf->setResolution(150, 150);
            $pdf->setImageFormat('pdf');
            $pdf->writeImages($Uploader_path_combine.$filename, true);

        }

        $buffer = file_get_contents(realpath('uploads/tmp_combine_pdf/'.$filename));

        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$filename.'.pdf"');

        echo $buffer;

        exit;

    }
    ###################################################################

    ###################################################################
    public function Upload_File_Transaction()
    {

        $this->data['Page_Title']      = ' اضافة مرفقات اضافية للمعاملة  ';

        $Transaction_id =  $this->uri->segment(4);
        $where_Transactions = array("uuid" => $Transaction_id, "company_id" => $this->aauth->get_user()->company_id,);
        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){
            $this->data['Transactions'] = $Get_Transactions->row();
        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Upload_File_Transaction', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Submit_Upload_File_Transaction()
    {

        $uuid_file = '';

        header('Content-Type: application/json');

        $Company_domain = Get_Company($this->aauth->get_user()->company_id)->companies_Domain;
        $Uploader_path = './uploads/companies/' . $Company_domain . '/' . FOLDER_FILE_Transaction_COMPANY;

        if (!is_dir($Uploader_path)) {
            mkdir($Uploader_path, 0755, TRUE);
        }

        $config['upload_path']    = realpath($Uploader_path);
        $config['allowed_types']  = 'gif|jpg|png|jpeg|pdf|tif|tiff';
        $config['max_size']       = 1024 * 10;
        $config['max_filename']   = 30;
        $config['encrypt_name']   = true;
        $config['remove_spaces']  = true;
        ###################################################################################################################
        if($_FILES['file_att']['type'] == 'image/tiff' OR $_FILES['file_att']['type'] =='image/tiff'){

            $config_temp = array();

            $upload_path_temp = 'uploads/tmp';

            $config_temp['upload_path']    = realpath($upload_path_temp);
            $config_temp['allowed_types']  = 'gif|jpg|png|jpeg|pdf|tif|tiff';
            $config_temp['max_size']       = 1024 * 10;
            $config_temp['max_filename']   = 30;
            $config_temp['encrypt_name']   = true;
            $config_temp['remove_spaces']  = true;

            $this->upload->initialize($config_temp);

            $uploader_temp    = $this->upload->do_upload('file_att');
            $upload_data_temp = $this->upload->data();

            $get_file_temp = realpath('uploads/tmp/'.$upload_data_temp['file_name']);

            $Image_Processing = new Imagick($get_file_temp);
            $Count_tiff       = $Image_Processing->getNumberImages();
            $x = 0;
            ###################################################################################################################
            foreach ( $Image_Processing as $Image_Processing )
            {

                $x++;

                $size_page = getimagesize($get_file_temp);

                $Image_Processing->setResolution(150, 150);
                $Image_Processing->setImageFormat( 'png');
                $Image_Processing->thumbnailImage($size_page[0], $size_page[1]);

                $file_name = uniqid().time();

                $uploader = $Image_Processing->writeImage(FCPATH.'uploads/companies/' . $Company_domain . '/' . FOLDER_FILE_Transaction_COMPANY.'/'.$file_name.'_'.$x."_image.png");

                ###################################################################
                # Start resize
                ###################################################################
                $configer_resize =  array(
                    'image_library'   => 'GD2',
                    'source_image'    =>  realpath('uploads/companies/'.$Company_domain.'/'.FOLDER_FILE_Transaction_COMPANY.'/'.$file_name.'_'.$x."_image.png"),
                    'new_image'       =>  realpath('uploads/companies/'.$Company_domain.'/'.FOLDER_FILE_Transaction_COMPANY.'/'),
                    'maintain_ratio'  =>  TRUE,
                    'width'           =>  1240,
                );
                $this->load->library('image_lib');
                $this->image_lib->clear();
                $this->image_lib->initialize($configer_resize);
                $this->image_lib->resize();
                ###################################################################
                # End resize
                ###################################################################


                $data_file['Transaction_id']        = '0';
                $data_file['File_Name_In']          = $_POST['file_name'];
                $data_file['LIST_TRANSACTION_DOCUMENTS']          = $_POST['LIST_TRANSACTION_DOCUMENTS'];
                $data_file['Transaction_id']        = $_POST['transaction_id'];
                $data_file["company_id"]            = $this->aauth->get_user()->company_id;
                $data_file["file_name"]             = $file_name."_".$x."_image.png";
                $data_file["file_type"]             = 'image/png';
                $data_file["file_path"]             = FCPATH.'uploads/companies/' . $Company_domain . '/' . FOLDER_FILE_Transaction_COMPANY.'/'.$file_name.'_'.$x."_image.png";
                $data_file["full_path"]             = FCPATH.'uploads/companies/' . $Company_domain . '/' . FOLDER_FILE_Transaction_COMPANY.'/'.$file_name.'_'.$x."_image.png";
                $data_file["raw_name"]              = $_POST['file_name'];
                $data_file["orig_name"]             = $_POST['file_name'];
                $data_file["client_name"]           = $_POST['file_name'];
                $data_file["file_ext"]              = '.png';
                $data_file["is_image"]              = '1';
                $data_file["image_type"]            = 'png';
                $data_file["file_createBy"]         = $this->aauth->get_user()->id;
                $data_file["file_createDate"]       = time();
                $data_file["file_lastModifyDate"]   = 0;
                $data_file["file_isDeleted"]        = 0;
                $data_file["file_DeletedBy"]        = 0;
                $data_file["files_sort"]            = time();

                if($uploader)
                {
                    $Create_Transaction_files = Create_Transaction_files($data_file);
                    $Get_Transaction_files    = Get_Transaction_files(array("file_uplode_id"=>$Create_Transaction_files))->row();
                }

                $uuid_file .=  '<input name="files_Transaction_ids[]" type="hidden" value="'.$Get_Transaction_files->uuid.'">';

            }
            ###################################################################################################################

        }else{

            $this->upload->initialize($config);

            $uploader    = $this->upload->do_upload('file_att');
            $upload_data = $this->upload->data();

            ###################################################################
            # Start resize
            ###################################################################
            $configer_resize =  array(
                'image_library'   => 'GD2',
                'source_image'    =>  realpath('uploads/companies/'.$Company_domain.'/'.FOLDER_FILE_Transaction_COMPANY.'/'.$upload_data['file_name']),
                'new_image'       =>  realpath('uploads/companies/'.$Company_domain.'/'.FOLDER_FILE_Transaction_COMPANY.'/'),
                'maintain_ratio'  =>  TRUE,
                'width'           =>  1240,
            );
            $this->load->library('image_lib');
            $this->image_lib->clear();
            $this->image_lib->initialize($configer_resize);
            $this->image_lib->resize();
            ###################################################################
            # End resize
            ###################################################################

            $data_file   = array();

            $data_file['Transaction_id']                = '0';
            $data_file['File_Name_In']                  = $_POST['file_name'];
            $data_file['LIST_TRANSACTION_DOCUMENTS']    = $_POST['LIST_TRANSACTION_DOCUMENTS'];
            $data_file['Transaction_id']                = $_POST['transaction_id'];
            $data_file["company_id"]                    = $this->aauth->get_user()->company_id;
            $data_file["file_name"]                     = $upload_data['file_name'];
            $data_file["file_type"]                     = $upload_data['file_type'];
            $data_file["file_path"]                     = $upload_data['file_path'];
            $data_file["full_path"]                     = $upload_data['full_path'];
            $data_file["raw_name"]                      = $upload_data['raw_name'];
            $data_file["orig_name"]                     = $upload_data['orig_name'];
            $data_file["client_name"]                   = $upload_data['client_name'];
            $data_file["file_ext"]                      = $upload_data['file_ext'];
            $data_file["is_image"]                      = $upload_data['is_image']; // Whether the file is an image or not. 1 = image. 0 = not.
            $data_file["image_type"]                    = $upload_data['image_type'];
            $data_file["file_createBy"]                 = $this->aauth->get_user()->id;
            $data_file["file_createDate"]               = time();
            $data_file["file_lastModifyDate"]           = 0;
            $data_file["file_isDeleted"]                = 0;
            $data_file["file_DeletedBy"]                = 0;
            $data_file["files_sort"]                    = time();

            if($uploader)
            {
                $Create_Transaction_files = Create_Transaction_files($data_file);
                $Get_Transaction_files    = Get_Transaction_files(array("file_uplode_id"=>$Create_Transaction_files))->row();
            }

            $uuid_file .=  '<input name="files_Transaction_ids[]" type="hidden" value="'.$Get_Transaction_files->uuid.'">';

            echo json_encode($uuid_file);
        }
        ###################################################################################################################

    }
    ###################################################################

    ###################################################################
    public function Download_File_Transaction()
    {
        $Transaction_id     = $this->uri->segment(4);
        $uuid_file          = $this->uri->segment(5);

        $Company_domain = Get_Company($this->aauth->get_user()->company_id)->companies_Domain;
        $Uploader_path = './uploads/companies/' . $Company_domain . '/' . FOLDER_FILE_Transaction_COMPANY;

        if (!is_dir($Uploader_path)) {
            mkdir($Uploader_path, 0755, TRUE);
        }


        $query = app()->db->where('uuid',$uuid_file);
        $query = app()->db->get('protal_transaction_files');

        if($query->num_rows()>0){

            $this->load->helper('download');
            $query_file = $query->row();
            force_download($Uploader_path.'/'.$query_file->file_name, NULL);

        }else{

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'طريقة غير صحيحة ';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions', 'refresh');

        }


    }
    ###################################################################

    ###################################################################
    public function Edit_File_Transaction()
    {
        $Transaction_id     = $this->uri->segment(4);

        $this->data['Page_Title']      = ' تعديل  ملف المعاملة ';

        $Transaction_id     = $this->uri->segment(4);
        $where_Transactions = array("uuid"=> $Transaction_id,"company_id"=>$this->aauth->get_user()->company_id,"location_id" =>$this->aauth->get_user()->locations_id);

        $Get_Transactions   = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0)
        {
            $this->data['Transactions']      = $Get_Transactions->row();

            $File_Transaction = $this->db->where('transaction_id',$this->data['Transactions']->transaction_id);
            $File_Transaction = $this->db->order_by('files_sort','ASC');
            $File_Transaction = $this->db->where('file_isDeleted !=',1);
            $File_Transaction = $this->db->get('protal_transaction_files');

            $this->data['File_Transaction']  = $File_Transaction;

            Create_Logs_User('Edit_File_Transaction',$this->data['Transactions']->transaction_id,'Transaction','Edit');

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/File_Transaction/Sort_File_Transaction', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Delete_File_Transaction()
    {
        $Transaction_id     = $this->uri->segment(4);
        $uuid_file          = $this->uri->segment(5);


        $Company_domain = Get_Company($this->aauth->get_user()->company_id)->companies_Domain;
        $Uploader_path = './uploads/companies/' . $Company_domain . '/' . FOLDER_FILE_Transaction_COMPANY;

        $query = app()->db->where('uuid',$uuid_file);
        $query = app()->db->get('protal_transaction_files');

        if($query->num_rows()>0){


            $where_Transactions = array(
                "uuid"        => $Transaction_id,
                "company_id"  => $this->aauth->get_user()->company_id,
            );
            $Get_Transactions  = Get_Transaction($where_Transactions)->row();

            $this->load->helper('download');

            $query_file    = $query->row();
            //$delete_unlink = unlink($Uploader_path.'/'.$query_file->file_name);
            $delete_query  = app()->db->where('uuid',$uuid_file);
            $delete_query  = app()->db->set('file_isDeleted',1);
            $delete_query  = app()->db->set('file_DeletedBy',$this->aauth->get_user()->id);
            $delete_query  = app()->db->update('protal_transaction_files');

            if($delete_query){
                $filename   = "Transaction_combine_".date('Ymd',$Get_Transactions->Create_Transaction_Date).''.$Get_Transactions->transaction_id.'.pdf';
                $delete_pdf = @unlink('uploads/tmp_combine_pdf/'.$filename);
            }

            $msg_result['key']   = 'Success';
            $msg_result['value'] = 'تم الحذف بنجاح';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transaction_id, 'refresh');



        }else{

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'طريقة غير صحيحة ';
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions', 'refresh');

        }


    }
    ###################################################################

    ###################################################################
    public function Sort_File_Transaction()
    {
        $Transaction_id     = $this->uri->segment(4);

        $this->data['Page_Title']      = ' تعديل وترتيب ملفات المعاملة ';

        $Transaction_id     = $this->uri->segment(4);
        $where_Transactions = array("uuid"=> $Transaction_id,"company_id"=>$this->aauth->get_user()->company_id,"location_id" =>$this->aauth->get_user()->locations_id);

        $Get_Transactions   = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0)
        {
            $this->data['Transactions']      = $Get_Transactions->row();

            $File_Transaction = $this->db->where('transaction_id',$this->data['Transactions']->transaction_id);
            $File_Transaction = $this->db->order_by('files_sort','ASC');
            $File_Transaction = $this->db->where('file_isDeleted !=',1);
            $File_Transaction = $this->db->get('protal_transaction_files');

            $this->data['File_Transaction']  = $File_Transaction;

            Create_Logs_User('Sort_File_Transaction',$this->data['Transactions']->transaction_id,'Transaction','View');

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->data['Lode_file_Js'] = import_js(array(BASE_ASSET . 'plugins/jquery-ui', BASE_ASSET . 'plugins/Sortable/src/Sortable'), '');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/File_Transaction/Sort_File_Transaction', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Update_Sort_File_Transaction()
    {
        $this->form_validation->set_rules('Transactions_id', 'رقم المعاملة غير صحيح', 'required');
        $this->form_validation->set_rules('File_Transaction', 'لم يتم تعديل ترتيب الملفات', 'required');


        $Transactions_uuid = $this->uri->segment(4);

        if ($this->form_validation->run() == FALSE) {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/Sort_File_Transaction/'.$Transactions_uuid, 'refresh');

        } else {

            $Transaction_id        = $this->input->post('Transactions_id');
            $File_Transaction_sort = explode(",",$this->input->post('File_Transaction'));

            $Sort = 0;
            $i    = 0;

            foreach ($File_Transaction_sort AS $R)
            {
                $Sort = ++$i;

                @$Update_Sort = app()->db->where('Transaction_id',$Transaction_id);
                @$Update_Sort = app()->db->where('uuid',$File_Transaction_sort[$Sort]);
                @$Update_Sort = app()->db->set('files_sort',$Sort);
                @$Update_Sort = app()->db->update('protal_transaction_files');
            }


            if ($Update_Sort) {

                $msg_result['key']   = 'Success';
                $msg_result['value'] = 'تم تحديث ترتيب الاقسام';
                $msg_result_view     = Create_Status_Alert($msg_result);

                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/Sort_File_Transaction/'.$Transactions_uuid, 'refresh');

            } else {

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'لم يتم التحديث يوجد خطا ما ';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/Sort_File_Transaction/'.$Transactions_uuid, 'refresh');

            }

        }

    }
    ###################################################################
    /*
     *  View_File_Transaction
     */



    /*
     *  Assign Transaction
     */
    ###################################################################
    public function Assign_Transaction()
    {
        $this->data['Page_Title']      = ' فريق العمل ';

        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"                     => $Transaction_id,
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->locations_id,
        );
        $Get_Transactions  = Get_Transaction($where_Transactions)->row();



        # Where Transaction Assign Users
        $where_Transaction_Assign = array("transaction_id"=>$Get_Transactions->transaction_id);
        $Get_Transaction_Assign   = Get_Transaction_Assign($where_Transaction_Assign);

        if($Get_Transaction_Assign->num_rows()>0){

            $Assign = array();

            foreach ($Get_Transaction_Assign->result() AS $RAS)
            {

                $Assign[] = array(
                    "uuid" => $RAS->uuid,
                    "assign_userid" => $this->aauth->get_user($RAS->assign_userid)->full_name,
                    "Department"    => Get_Departments(array("departments_id"=>$this->aauth->get_user($RAS->assign_userid)->departments_id))->row()->item_translation,
                    "assign_type"   => $RAS->assign_type,
                    "assign_time"   => date('Y-m-d h:i:s a',$RAS->assign_time)
                );
            }
            $this->data['assign'] = $Assign;

        }else{

            $this->data['assign'] = false;

        } // if($Get_Transaction_Assign->num_rows()>0)

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');


        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Assignment_Transaction/Assignment_Transaction', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function New_Assign_Transaction()
    {
        $this->data['Page_Title']      = ' اضافة موظف للمعاملة ';

        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"                     => $Transaction_id,
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->locations_id,
        );
        $Get_Transactions  = Get_Transaction($where_Transactions)->row();

        $Company_Users = Get_Company_Users(array("users.company_id"=>$this->aauth->get_user()->company_id,"users.banned"=>0));
        foreach ($Company_Users->result() AS $Row) {


           $Company_Users_a[] = array(
              "user_id"   => $Row->user_id,
              "email"     => $Row->email,
              "full_name" => $Row->full_name,
           );

           $this->data['Company_Users'] = $Company_Users_a;

        } // foreach ($Company_Users->result() AS $Row)

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Assignment_Transaction/New_Assignment_User_Transaction', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Submit_Assign_Transaction()
    {

        $this->form_validation->set_rules('user_emp_id','لم يتم تحديد موظف على الاقل','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Transactions/New_Assign_Transaction/'.$this->uri->segment(4), 'refresh');

        } else {

            $Transaction_id =  $this->uri->segment(4);

            $where_Transactions = array(
                "uuid"                     => $Transaction_id,
                "company_id"               => $this->aauth->get_user()->company_id,
            );
            $Get_Transactions  = Get_Transaction($where_Transactions)->row();


            $user_emp_id    =  $this->input->post('user_emp_id', true);

            $data_assign['transaction_id']          =  $Get_Transactions->transaction_id;
            $data_assign['assign_userid']           =  $user_emp_id;
            $data_assign['assign_time']             =  time();
            $data_assign['assign_type']             =  1;
            $data_assign['assign_createDate']       =  time();
            $data_assign['assign_lastModifyDate']   =  0;

            $Create_assign = app()->db->insert('protal_transaction_assign',$data_assign);

            if($Create_assign) {

                $Assignment_Notifications = array(

                    "notifications_to_user"  => $user_emp_id,
                    "notifications_type"     => "TRANSACTION",
                    "notifications_title"    => lang('Notifications_Assignment_Transaction_title'),
                    "notifications_text"     => lang('Notifications_Assignment_Transaction_text')
                );
                Create_Notifications($Assignment_Notifications);

                $Data_Email['to']      = $this->aauth->get_user($user_emp_id)->email;
                $Data_Email['from']    = '';
                $Data_Email['subject'] = 'تم اسناد معاملة ';
                $Data_Email['message'] = $this->load->view('../../modules/Template_Email/Transactions/Assignment_Transaction_User',$Data_Email, true);
                Create_Email_Notifications($Data_Email);


                $msg_result['key']  = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/Assign_Transaction/'.$this->uri->segment(4), 'refresh');

            } else {

                $msg_result['key'] = 'Danger';
                $msg_result['value'] = lang('message_error_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/Assign_Transaction/'.$this->uri->segment(4), 'refresh');

            }

        }

    }
    ###################################################################

    ###################################################################
    public function Unset_Assign_Transaction()
    {
        $uuid = $this->uri->segment(4);
        $Transaction_uuid = $this->uri->segment(5);
        $query = app()->db->where('uuid',$uuid);
        $query = app()->db->set('assign_type','0');
        $query = app()->db->update('protal_transaction_assign');

        if($query) {
                $msg_result['key']  = 'Success';
                $msg_result['value'] = 'تم الغاء التنشيط بنجاح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/Assign_Transaction/'.$Transaction_uuid, 'refresh');
        } else {
                $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'حدث خطا ما يرجى المحاولة لاحقا';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/Assign_Transaction/'.$Transaction_uuid, 'refresh');
        }
    }
    ###################################################################

    ###################################################################
    public function Reset_Assign_Transaction()
    {
        $uuid = $this->uri->segment(4);
        $Transaction_uuid = $this->uri->segment(5);
        $query = app()->db->where('uuid',$uuid);
        $query = app()->db->set('assign_type','1');
        $query = app()->db->update('protal_transaction_assign');

        if($query) {
            $msg_result['key']  = 'Success';
            $msg_result['value'] = 'تم التنشيط بنجاح';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/Assign_Transaction/'.$Transaction_uuid, 'refresh');
        } else {
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'حدث خطا ما يرجى المحاولة لاحقا';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/Assign_Transaction/'.$Transaction_uuid, 'refresh');
        }
    }
    ###################################################################
    /*
     *  Assign Transaction
     */




    /*
     * Start :: Department of Data Entries
     */
    ######################################################################################################
    public function Check_DataEntries()
    {
        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"                     => $Transaction_id,
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){
            $this->data['Transactions']      = $Get_Transactions->row();
        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->data['Page_Title']      = 'استكمال البيانات و التدقيق ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Data_Entry/Form_Data_Entry_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ######################################################################################################

    ######################################################################################################
    public function Submit_DataEntries()
    {
        $POST_Fields         = $_POST;
        $Transaction_id      = $this->input->post('Transaction_id');
        $Form_id             = $this->input->post('Form_id');
        $data_Transaction2   = array();
        $data_Transaction1   = array();
        $data_Transaction    = array();

        foreach($POST_Fields AS $key => $value)
        {

            // $_POST
            if($key == 'Assignment_userid' or  $key=='Transaction_id' or $key=='Transactions_uuid' or $key =="ci_csrf_token" or $key =="Form_id" or $key =="FILE_Name" or $key =="FILE"){

            }else{

                    $explode_Post = explode("-",$key);

                    $Fields_Components = Query_Fields_Components(
                        array("Forms_id"=> $explode_Post[1], "Components_id" => $explode_Post[2],"Fields_key" => $explode_Post[0])
                    );


                    if ($Fields_Components->num_rows() > 0) {

                        $Get_validating_Fields         = Get_validating_Fields(array("Forms_id" => $Form_id,"Components_id" => $Fields_Components->row()->Components_id, "company_id" => 0, "Fields_id" => $Fields_Components->row()->Fields_id));


                    if ($Get_validating_Fields->num_rows() > 0) {

                        if ($Fields_Components->row()->Fields_Type == 'Fields') {
                            $Get_Fields = Get_Fields(array("Fields_id" => $Fields_Components->row()->Fields_id))->row();
                            Building_form_validation($key, $Get_Fields->item_translation, $Get_validating_Fields->row()->validating_rules);
                        } elseif ($Fields_Components->row()->Fields_Type == 'List') {
                            $Get_List = Get_All_List(array("list_id" => $Fields_Components->row()->Fields_id))->row();
                            Building_form_validation($key, $Get_List->item_translation, $Get_validating_Fields->row()->validating_rules);
                        }

                        if ($this->form_validation->run() == FALSE) {
                            $msg_result['key'] = 'Danger';
                            $msg_result['value'] = validation_errors();
                            $msg_result_view = Create_Status_Alert($msg_result);
                            set_message($msg_result_view);
                            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
                        }

                        $data_Transaction1[] = array(
                            "data_key"      => $explode_Post[0],
                            "data_value"    => $this->input->post($key, TRUE),
                            "Forms_id"      => $Form_id,
                            "Components_id" => $explode_Post[2]
                        );

                    }else{
                        $data_Transaction2[] = array(
                            "data_key"      => $explode_Post[0],
                            "data_value"    => $this->input->post($key, TRUE),
                            "Forms_id"      => $Form_id,
                            "Components_id" => $explode_Post[2]
                        );
                    } // if ($Get_validating_Fields->num_rows() > 0)

                } // if($Fields_Components->num_rows()>0)

            } // ignore $_POST

        } // foreach ($POST_Fields AS $field)

        $data_Transaction = @array_merge($data_Transaction2,$data_Transaction1);

        $Create_Transaction_data         = Create_Transaction_data($Transaction_id,$data_Transaction);
        $Create_Transaction_data_history = Create_Transaction_data_history($Transaction_id,$data_Transaction,'Create');


        $where_Transaction_Stage = array(
            "stages_key" => 'COORDINATION_AND_QUALITY',
            "company_id" => $this->aauth->get_user()->company_id
        );
        $Get_Stages = Get_Stages_Transaction_Company($where_Transaction_Stage)->row();

        $data_Transaction_Assign = array();
        $data_Transaction_Assign['transaction_id'] = $Transaction_id;
        $data_Transaction_Assign['assign_userid']  = $this->input->post('Assignment_userid');
        $data_Transaction_Assign['assign_time']    = time();
        $data_Transaction_Assign['assign_type']    = 1;
        $Create_Transaction_Assign = Create_Transaction_Assign($data_Transaction_Assign);


        $Assignment_Notifications = array(
            "notifications_to_user"  => $this->input->post('Assignment_userid'),
            "notifications_type"     => "TRANSACTION",
            "notifications_title"    => lang('Notifications_Assignment_Transaction_title'),
            "notifications_text"     => lang('Notifications_Assignment_Transaction_text')
        );
        Create_Notifications($Assignment_Notifications);

        $query = app()->db->where('transaction_id',$Transaction_id);
        $query = app()->db->set('Transaction_Status_id','193');
        $query = app()->db->set('Transaction_Stage','COORDINATION_AND_QUALITY');
        $query = app()->db->update('protal_transaction');



        if($Create_Transaction_data)
        {

            $msg_result['key']     = 'Success';
            $msg_result['value']   = lang('message_success_insert');
            $msg_result_view       = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');

        } else {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');

        }

    } // Submit_DataEntries()
    ######################################################################################################
    /*
     *  End :: Department of Data Entries
     */



    /*
     *  Start :: Department of Quality and Coordination
     */
    ######################################################################################################
    public function Add_Preview_Visit()
    {

        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"                     => $Transaction_id,
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->locations_id,
        );
        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $this->data['Transactions']      = $Get_Transactions->row();

            $transaction_id          = $this->data['Transactions']->transaction_id;

            $regions_id              = Transaction_data_by_key($transaction_id,1,1,'LIST_REGION');
            $city_id                 = Transaction_data_by_key($transaction_id,1,1,'LIST_CITY');
            $districts               = Transaction_data_by_key($transaction_id,1,1,'LIST_DISTRICT');


            $users_preview           = app()->db->where('regions_id',$regions_id);
            $users_preview           = app()->db->where('city_id',$city_id);
            if($districts !=0 ){
                $users_preview       = app()->db->where('FIND_IN_SET('.$districts.',districts) !=0');
            }
            $users_preview           = app()->db->where('company_id',$this->aauth->get_user()->company_id);
            $users_preview           = app()->db->get('protal_users_preview_map');

            if($users_preview->num_rows()>0){
                $this->data['users_preview']  = $users_preview->result();
            }else{
                $this->data['users_preview']  = false;
            }

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }


        $this->data['Page_Title']      = ' اضافة زيارة معاينة ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Previewer/Add_Preview_Visit', $this->data, true);
        Layout_Apps($this->data);


    }
    ######################################################################################################

    ######################################################################################################
    public function View_Coordination()
    {

        $Transaction_id  =  $this->uri->segment(4);
        $Coordination_id =  $this->uri->segment(5);

        $where_Transactions = array(
            "uuid"=>$Transaction_id,"company_id"=>$this->aauth->get_user()->company_id,"location_id"=>$this->aauth->get_user()->locations_id,
        );
        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $GetTransactions = $Get_Transactions->row();

            $where_Preview_Visit = array(
                "Transactions_id"=> $GetTransactions->transaction_id,"Coordination_uuid"=>$Coordination_id
            );

            $Get_Preview_Visit = Get_Preview_Visit($where_Preview_Visit);
            if($Get_Preview_Visit->num_rows()>0){
                $this->data['Coordination']  = $Get_Preview_Visit->row();
                $this->data['Transactions']  = $Get_Transactions->row();

                $where_Preview_Visit_FeedBack = array("Coordination_id"=>$this->data['Coordination']->Coordination_id);
                $Get_Preview_Visit_FeedBack = Get_Preview_Visit_FeedBack($where_Preview_Visit_FeedBack);
                $this->data['Preview_Visit_FeedBack']  = $Get_Preview_Visit_FeedBack;

            }else{
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
            }

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->data['Page_Title']      = ' متابعة زيارة المعاين ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Coordination', $this->data, true);
        Layout_Apps($this->data);


    }
    ######################################################################################################

    ######################################################################################################
    public function Create_Preview_Visit()
    {

        $this->form_validation->set_rules('Transaction_id','رقم المعاملة','required');
        $this->form_validation->set_rules('preview_userid','لم يتم تحديد المعاين','required');
        $this->form_validation->set_rules('preview_date','لم يتم تحديد وقت الزيارة ','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Transactions/', 'refresh');

        }else{

            $Preview_Visit['Transactions_id']                  = $this->input->post('Transaction_id');
            $Preview_Visit['preview_userid']                   = $this->input->post('preview_userid');
            $Preview_Visit['preview_date']                     = strtotime($this->input->post('preview_date'));
            $Preview_Visit['preview_date_assignment']          = strtotime($this->input->post('preview_date'));
            $Preview_Visit['preview_stauts']                   = 347;
            $Preview_Visit['preview_stages']                   = $this->input->post('preview_stages');

            $Preview_Visit['company_id']                       = $this->aauth->get_user()->company_id;
            $Preview_Visit['preview_Visit_userid_acceptance']  = 0;
            $Preview_Visit['preview_Visit_date_completed']     = 0;
            $Preview_Visit['createBy']                         = $this->aauth->get_user()->id;

            $Create_Preview_Visit = Create_Preview_Visit($Preview_Visit);

            $where_Transactions = array(
                "transaction_id"  => $this->input->post('Transaction_id',true),
                "company_id"      => $this->aauth->get_user()->company_id,
            );
            $Get_Transactions   = Get_Transaction($where_Transactions)->row();

            $query = app()->db->where('transaction_id',$Get_Transactions->transaction_id);
            $query = app()->db->set('Transaction_Status_id','195');
            $query = app()->db->set('Transaction_Stage','COORDINATION_AND_QUALITY');
            $query = app()->db->update('protal_transaction');

            if($Create_Preview_Visit){
                $msg_result['key']   = 'Success';
                $msg_result['value'] = 'تم انشاء الزيارة بنجاح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Transactions/View_Transaction/'.$Get_Transactions->uuid , 'refresh');
            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'حصل خطا ما حاول مجددا';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Transactions/Add_Preview_Visit/'.$Get_Transactions->uuid, 'refresh');
            }

        } // if($this->form_validation->run()==FALSE)
    }
    ######################################################################################################

    ######################################################################################################
    public function Form_Preview_Feedback()
    {

        $Transaction_id  =  $this->uri->segment(4);
        $Coordination_id =  $this->uri->segment(5);

        $where_Transactions = array(
            "uuid"=>$Transaction_id,"company_id"=>$this->aauth->get_user()->company_id,"location_id"=>$this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $GetTransactions = $Get_Transactions->row();

            $where_Preview_Visit = array(
                "Transactions_id"=> $GetTransactions->transaction_id,"Coordination_uuid"=>$Coordination_id
            );

            $Get_Preview_Visit = Get_Preview_Visit($where_Preview_Visit);

            if($Get_Preview_Visit->num_rows()>0){
                $this->data['Coordination']  = $Get_Preview_Visit->row();
                $this->data['Transactions']  = $Get_Transactions->row();
            }else{
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
            }

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->data['Page_Title']      = ' اضافة افادة  ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Previewer/Form_Previewer_Feedback_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ######################################################################################################

    ######################################################################################################
    public function Create_Preview_FeedBack()
    {

        $Transaction_id  =  $this->uri->segment(4);
        $Coordination_id =  $this->uri->segment(5);

        $where_Transactions = array(
            "uuid"=>$Transaction_id,"company_id"=>$this->aauth->get_user()->company_id,"location_id"=>$this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $GetTransactions = $Get_Transactions->row();

            $where_Preview_Visit = array(
                "Transactions_id"=> $GetTransactions->transaction_id,"Coordination_uuid"=>$Coordination_id
            );

            $Get_Preview_Visit = Get_Preview_Visit($where_Preview_Visit);

            if($Get_Preview_Visit->num_rows()>0){

                $this->data['Coordination']  = $Get_Preview_Visit->row();
                $this->data['Transactions']  = $Get_Transactions->row();


                $this->form_validation->set_rules('LIST_VISITING_STATUS','حالة الافادة','required');
                $this->form_validation->set_rules('note_visit','ملاحظات','required');

                if($this->input->post('LIST_VISITING_STATUS') == 298){
                    $this->form_validation->set_rules('Date_visit','تاريخ الزيارة','required');
                    $this->form_validation->set_rules('Time_visit','وقت الزيارة','required');
                }

                if($this->form_validation->run()==FALSE){
                    $msg_result['key']   = 'Danger';
                    $msg_result['value'] = validation_errors();
                    $msg_result_view     = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL.'/Transactions/Form_Preview_Feedback/'.$Transaction_id.'/'.$Coordination_id, 'refresh');
                } else {

                    $data_Preview_Visit['Coordination_id']  = $this->data['Coordination']->Coordination_id;
                    $data_Preview_Visit['VISITING_STATUS']  = $this->input->post('LIST_VISITING_STATUS');
                    $data_Preview_Visit['Date_visit']       = strtotime($this->input->post('Date_visit'));
                    $data_Preview_Visit['feedback_userid']  = $this->aauth->get_user()->id;
                    $data_Preview_Visit['Time_visit']       = $this->input->post('Time_visit');
                    $data_Preview_Visit['feedback_text']    = $this->input->post('note_visit');
                    $data_Preview_Visit['CreateDate']       = time();
                    $data_Preview_Visit['createBy']         = $this->aauth->get_user()->id;


                    app()->db->where('Coordination_id',$this->data['Coordination']->Coordination_id);
                    app()->db->set('preview_stauts',$this->input->post('LIST_VISITING_STATUS'));
                    app()->db->update('protal_transaction_coordination');


                    $create_Preview_Visit_FeedBack = Create_Preview_Visit_FeedBack($data_Preview_Visit);

                    if ($create_Preview_Visit_FeedBack) {
                        $msg_result['key'] = 'Success';
                        $msg_result['value'] = lang('message_success_insert');
                        $msg_result_view = Create_Status_Alert($msg_result);
                        set_message($msg_result_view);
                        redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transaction_id, 'refresh');
                    } else {
                        $msg_result['key'] = 'Danger';
                        $msg_result['value'] = lang('message_error_insert');
                        $msg_result_view = Create_Status_Alert($msg_result);
                        set_message($msg_result_view);
                        redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transaction_id.'/'.$Coordination_id, 'refresh');
                    }

                } // if($this->form_validation->run()==FALSE)

            }else{
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
            }


        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

    }
    ######################################################################################################

    ######################################################################################################
    public function Dashboard_Preview_Property()
    {

        $Transaction_id  =  $this->uri->segment(4);
        $Coordination_id =  $this->uri->segment(5);

        $where_Transactions = array(
            "uuid"=>$Transaction_id,"company_id"=>$this->aauth->get_user()->company_id,"location_id"=>$this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $GetTransactions = $Get_Transactions->row();

            $where_Preview_Visit = array(
                "Transactions_id"=> $GetTransactions->transaction_id,"Coordination_uuid"=>$Coordination_id
            );

            $Get_Preview_Visit = Get_Preview_Visit($where_Preview_Visit);

            if($Get_Preview_Visit->num_rows()>0){

                $this->data['Coordination']  = $Get_Preview_Visit->row();
                $this->data['Transactions']  = $Get_Transactions->row();

            }else{
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
            }

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }


        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page_Title']      = ' لوحة معاينة العقار  ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Previewer/Dashboard_Preview_Property', $this->data, true);
        Layout_Apps($this->data);
    }
    ######################################################################################################

    ######################################################################################################
    public function Create_Preview_Property()
    {
        $Transaction_uuid  =  $this->uri->segment(4);
        $Coordination_uuid =  $this->uri->segment(5);



        $POST_Fields         = $_POST;
        $Transaction_id      = $this->input->post('Transaction_id');
        $Coordination_id     = $this->input->post('Coordination_id');

        $data_Transaction2   = array();
        $data_Transaction1   = array();
        $data_Transaction    = array();


        die;


        if ($this->input->post('Total_Land', TRUE)  == '' or
        $this->input->post('LATITUDE-15-37', TRUE)  == '' or
        $this->input->post('LONGITUDE-15-37', TRUE) == ''
        ) {
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transaction_uuid.'/'.$Coordination_uuid, 'refresh');
        }

        foreach($POST_Fields AS $key => $value)
        {

            // $_POST
            if($key=='Transaction_id'
                or $key == 'Coordination_id'
                or $key=='Transactions_uuid'
                or $key =="ci_csrf_token"
                or $key =="Form_id"
                or $key =="FILE_Name"
                or $key =="FILE"
                or $key =="geo-zoom"
                or $key =='Total_Land'
                or $key =='Total_Building'
                or $key =='CONSUMPTION_RATIO'
                or $key =='CONSUMPTION_Total'
                or $key =='ESTIMATED_COSTS'
                or $key =='PROFIT_RATIO'
                or $key =='PROFIT_Total'
                or $key =='MARKET_VALUE'
                or $key =='MARKET_VALUE_Approximate' ){

            }else{

                $explode_Post = explode("-",$key);

                $Fields_Components = Query_Fields_Components(array("Forms_id"=> $explode_Post[1], "Components_id" => $explode_Post[2],"Fields_key" => $explode_Post[0]));

                if ($Fields_Components->num_rows() > 0) {

                    $Get_validating_Fields         = Get_validating_Fields(array("Forms_id" => $explode_Post[1],"Components_id" => $Fields_Components->row()->Components_id, "company_id" => 0, "Fields_id" => $Fields_Components->row()->Fields_id));

                    if ($Get_validating_Fields->num_rows() > 0) {

                        if ($Fields_Components->row()->Fields_Type == 'Fields') {
                            $Get_Fields = Get_Fields(array("Fields_id" => $Fields_Components->row()->Fields_id))->row();
                            Building_form_validation($key, $Get_Fields->item_translation, $Get_validating_Fields->row()->validating_rules);
                        } elseif ($Fields_Components->row()->Fields_Type == 'List') {
                            $Get_List = Get_All_List(array("list_id" => $Fields_Components->row()->Fields_id))->row();
                            Building_form_validation($key, $Get_List->item_translation, $Get_validating_Fields->row()->validating_rules);
                        }

                        if ($this->form_validation->run() == FALSE) {
                            $msg_result['key'] = 'Danger';
                            $msg_result['value'] = validation_errors();
                            $msg_result_view = Create_Status_Alert($msg_result);
                            set_message($msg_result_view);
                            redirect(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transaction_uuid.'/'.$Coordination_uuid, 'refresh');
                        }

                        if($this->input->post($key, TRUE) !==''){
                            $data_Transaction1[] = array(
                                "data_key"      => $explode_Post[0],
                                "preview_id"    => $Coordination_id,
                                "data_value"    => $this->input->post($key, TRUE),
                                "Forms_id"      => $explode_Post[1],
                                "Components_id" => $explode_Post[2]
                            );
                        }

                    }else{

                        if($this->input->post($key, TRUE) !=='') {
                            $data_Transaction2[] = array(
                                "data_key"      => $explode_Post[0],
                                "preview_id"    => $Coordination_id,
                                "data_value"    => $this->input->post($key, TRUE),
                                "Forms_id"      => $explode_Post[1],
                                "Components_id" => $explode_Post[2]
                            );
                        }

                    } // if ($Get_validating_Fields->num_rows() > 0)

                } // if($Fields_Components->num_rows()>0)

            } // ignore $_POST

        } // foreach ($POST_Fields AS $field)

        $data_Transaction = @array_merge($data_Transaction2,$data_Transaction1);

        $Create_Transaction_data         = Create_Transaction_Preview_data($Transaction_id,$data_Transaction);
        $Create_Transaction_data_history = Create_Transaction_Preview_history($Transaction_id,$data_Transaction,'Create');


        ################################################################
        $data_preview_evaluation['preview_id']               = $Coordination_id;
        $data_preview_evaluation['transaction_id']           = $Transaction_id;
        $data_preview_evaluation['Total_Land']               = $this->input->post('Total_Land', TRUE);
        $data_preview_evaluation['Total_Building']           = $this->input->post('Total_Building', TRUE);
        $data_preview_evaluation['CONSUMPTION_RATIO']        = $this->input->post('CONSUMPTION_RATIO', TRUE);
        $data_preview_evaluation['CONSUMPTION_Total']        = $this->input->post('CONSUMPTION_Total', TRUE);
        $data_preview_evaluation['ESTIMATED_COSTS']          = $this->input->post('ESTIMATED_COSTS', TRUE);
        $data_preview_evaluation['PROFIT_RATIO']             = $this->input->post('PROFIT_RATIO', TRUE);
        $data_preview_evaluation['PROFIT_Total']             = $this->input->post('PROFIT_Total', TRUE);
        $data_preview_evaluation['MARKET_VALUE']             = $this->input->post('MARKET_VALUE', TRUE);
        $data_preview_evaluation['MARKET_VALUE_Approximate'] = $this->input->post('MARKET_VALUE_Approximate', TRUE);
        app()->db->insert('protal_transaction_preview_evaluation',$data_preview_evaluation);
        ################################################################

        $where_Transaction_Stage = array(
            "stages_key" => 'COORDINATION_AND_QUALITY',
            "company_id" => $this->aauth->get_user()->company_id
        );
        $Get_Stages = Get_Stages_Transaction_Company($where_Transaction_Stage)->row();

        $data_Transaction_Assign = array();
        $data_Transaction_Assign['transaction_id'] = $Transaction_id;
        $data_Transaction_Assign['assign_userid']  = $this->input->post('Assignment_userid');
        $data_Transaction_Assign['assign_time']    = time();
        $data_Transaction_Assign['assign_type']    = 1;
        $Create_Transaction_Assign = Create_Transaction_Assign($data_Transaction_Assign);

        $Assignment_Notifications = array(
            "notifications_to_user"  => $this->input->post('Assignment_userid'),
            "notifications_type"     => "TRANSACTION",
            "notifications_title"    => lang('Notifications_Assignment_Transaction_title'),
            "notifications_text"     => lang('Notifications_Assignment_Transaction_text')
        );
        Create_Notifications($Assignment_Notifications);

        $query = app()->db->where('transaction_id',$Transaction_id);
        $query = app()->db->set('Transaction_Status_id','350');
        $query = app()->db->set('Transaction_Stage','PROPERTY_HAS_A_PREVIEW');
        $query = app()->db->update('protal_transaction');



        if($Create_Transaction_data) {
            $msg_result['key']     = 'Success';
            $msg_result['value']   = lang('message_success_insert');
            $msg_result_view       = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transaction_uuid.'/'.$Coordination_uuid, 'refresh');
        } else {
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transaction_uuid.'/'.$Coordination_uuid, 'refresh');
        }


    }
    ######################################################################################################

    ######################################################################################################
    public function Ajax_Comparisons_Land_Comparisons()
    {
        $HTML              = '';
        $Transaction_id    = $this->input->get('Transactions_id');
        $Coordination_id   = $this->input->get('Coordination_id');

        if($Transaction_id == '' or $Coordination_id == ''){

        }else{

            $where_Comparisons = array(
               "Transaction_id"  => $Transaction_id,
               "Coordination_id" => $Coordination_id
            );
            $Get_Comparisons =  Get_Comparisons_Land($where_Comparisons);

            if($Get_Comparisons->num_rows()>0){
                $i = 0;
                foreach ($Get_Comparisons->result() AS $Ro)
                {
                    $HTML .= '<tr>';
                    $HTML .= '<td class="text-center">' . ++$i.'</td>';
                    $HTML .= '<td class="text-center">' . $Ro->Comparisons_type. '</td>';
                    $HTML .= '<td class="text-center">' . $Ro->property_types_id . '</td>';
                    $HTML .= '<td class="text-center">' . $Ro->Land_area . '</td>';
                    $HTML .= '<td class="text-center">' . $Ro->Price_per_square_meter. '</td>';
                    $HTML .= '<td class="text-center">' . $Ro->total_value_property . '</td>';
                    $HTML .= '<td class="text-center">' . $Ro->office . '</td>';
                    $HTML .= '<td class="text-center">' . $Ro->office_tel . '</td>';
                    $HTML .= '<td class="text-center"></td>';
                    $HTML .= '</tr>';
                }
                echo $HTML;
            }

        } // if($Transaction_id == '' or $Coordination_id == '')

    }
    ######################################################################################################

    ######################################################################################################
    public function Create_Ajax_Comparisons_Comparisons()
    {
        $Transaction_id    = $this->input->get('Transactions_id');
        $Coordination_id   = $this->input->get('Coordination_id');

        if($Transaction_id == '' or $Coordination_id == ''
        or $this->input->get('Comparisons_type')== '' or $this->input->get('property_types_id')==''
        or $this->input->get('Land_area') == '' or $this->input->get('Price_per_square_meter') ==''
        or $this->input->get('total_value_property') =='' or $this->input->get('office')=='' or $this->input->get('office_tel') ==''){

            $msg['success']        = true;
            $msg['Type_result']    = 'error';
            $msg['Message_result'] = 'حقول اجبارية';

        }else{

            $Comparisons_data['Transaction_id']          = $Transaction_id;
            $Comparisons_data['Coordination_id']         = $Coordination_id;
            $Comparisons_data['company_id']              = app()->aauth->get_user()->company_id;
            $Comparisons_data['Comparisons_type']        = $this->input->get('Comparisons_type');
            $Comparisons_data['property_types_id']       = $this->input->get('property_types_id');
            $Comparisons_data['Land_area']               = $this->input->get('Land_area');
            $Comparisons_data['Price_per_square_meter']  = $this->input->get('Price_per_square_meter');
            $Comparisons_data['total_value_property']    = $this->input->get('total_value_property');
            $Comparisons_data['office']                  = $this->input->get('office');
            $Comparisons_data['office_tel']              = $this->input->get('office_tel');

            $Comparisons_data['Create_by']   = app()->aauth->get_user()->id;
            $Comparisons_data['Create_date'] = time();

            $Create_Comparisons_Land = Create_Comparisons_Land($Comparisons_data);

            if($Create_Comparisons_Land){
                $msg['success']        = true;
                $msg['Type_result']    = 'success';
                $msg['Message_result'] = 'تمت الاضافة بنجاح';
            }else{
                $msg['success']        = true;
                $msg['Type_result']    = 'error';
                $msg['Message_result'] = 'خطا اثناء اضافة البيانات';

            }

        } // if($Transaction_id == '' or $Coordination_id == '')

        echo json_encode($msg);

    }
    ######################################################################################################

    ######################################################################################################
    public function Print_Transactions()
    {

            $Transaction_id  =  $this->uri->segment(4);

            $where_Transactions = array(
                "uuid"=>$Transaction_id,"company_id"=>$this->aauth->get_user()->company_id,"location_id"=>$this->aauth->get_user()->locations_id,
            );

            $Get_Transactions            = Get_Transaction($where_Transactions);

            $this->data['Transactions']  = $Get_Transactions->row();

            $this->data['Page_Title']      = ' طباعة ';

            $this->load->view('../../modules/App_Print_Evaluation_Reports/views/Print_Report', $this->data);

    }
    ######################################################################################################
    /*
     * End :: Department of Quality and Coordination
     */



}