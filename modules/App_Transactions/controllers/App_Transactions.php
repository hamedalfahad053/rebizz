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
                            "transaction_id" => $R->transaction_id,
                            "transaction_number" => $R->transaction_number,
                            "transaction_uuid" => $R->uuid,
                            "Transaction_Stage" => $R->Transaction_Stage,
                            "Transaction_Status_id" => $R->Transaction_Status_id,
                            "Create_Transaction_By_id" => $R->Create_Transaction_By_id,
                            "Assignment_userid" => $R->Assignment_userid,
                            "Create_Transaction_Date" => $R->Create_Transaction_Date
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

                    $Transaction_Table .= $this->load->view("../../modules/App_Transactions/views/Checking_Transaction/Button_Create_Transaction",'', true);
                    $msg['success']    = true;
                    $msg['Transaction_Table'] = $Transaction_Table;

                }

            } else {
                $Transaction_Table  = Create_Status_Alert(array("key" => "Success", "value" => "لا يوجد معاملات مضافة  متطابقة مع المدخلات يمكنك الاستمرار "));
                $Transaction_Table .= $this->load->view("../../modules/App_Transactions/views/Checking_Transaction/Button_Create_Transaction",'', true);

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


        $files_Transaction_ids = $_POST['files_Transaction_ids'];

        if($files_Transaction_ids){

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
            or $key=='files_Transaction_ids'){

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
                  "notifications_to_user"  =>  $this->input->post('Assignment_userid'),
                  "notifications_type"     => "TRANSACTION",
                  "notifications_title"    => lang('Notifications_Assignment_Transaction_title'),
                  "notifications_text"     => lang('Notifications_Assignment_Transaction_text')
                );
                Create_Notifications($Assignment_Notifications);

                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
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

        $this->form_validation->set_rules('Form_id','','required');
        $this->form_validation->set_rules('Components_id','','required');
        $this->form_validation->set_rules('Transaction_id','','required');

        $key          = $this->input->post('Form_id');
        $explode_Post = explode("-",$key);

        $Fields_Components = Query_Fields_Components(
            array("Forms_id"=> $explode_Post[1], "Components_id" => $explode_Post[2],"Fields_key" => $explode_Post[0])
        );




    }
    ###################################################################

    /*
     * End :: Department DATA_ENTRANTS
     */


    /*
     * All Department View Transaction
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
    /*
     * All Department View Transaction
     */



    /*
     * All Department Assign Transaction
     */
    ###################################################################
    public function Assign_Transaction()
    {
        $this->data['Page_Title']      = ' تسكين المعاملة الى موظف  ';

        $Transaction_id =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"                     => $Transaction_id,
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->locations_id,
        );
        $Get_Transactions  = Get_Transaction($where_Transactions)->row();



        # Where Transaction Assign Users
        $where_Transaction_Assign = array("assign_userid"=> $this->aauth->get_user()->id,"transaction_id"=>$Get_Transactions->transaction_id);
        $Get_Transaction_Assign   = Get_Transaction_Assign($where_Transaction_Assign);
        if($Get_Transaction_Assign->num_rows()>0){
            $Assign = array();
            foreach ($Get_Transaction_Assign->result() AS $RAS)
            {
                $Assign[] = array(
                    "assign_userid" => $this->aauth->get_user($RAS->assign_userid)->full_name,
                    "Department"    => '',
                    "Job_title"     => '',
                    "assign_status" => '',
                    "assign_time"   => date('Y-m-d h:i:s a',$RAS->assign_time)
                );
            }
            $this->data['assign'] = $Assign;

        }else{
            $this->data['assign'] = false;
        } // if($Get_Transaction_Assign->num_rows()>0)

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Template/Assignment_Transaction', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################
    /*
     * All Department Assign Transaction
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

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Form_Data_Entry_Transactions', $this->data, true);
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
        $Get_Stages            = Get_Stages_Transaction_Company($where_Transaction_Stage)->row();


        $data_Transaction_Assign = array();
        $data_Transaction_Assign['transaction_id'] = $Transaction_id;
        $data_Transaction_Assign['assign_userid']  = $this->input->post('Assignment_userid');
        $data_Transaction_Assign['assign_time']    = time();
        $data_Transaction_Assign['assign_type']    = 1;
        $Create_Transaction_Assign = Create_Transaction_Assign($data_Transaction_Assign);

        if($Create_Transaction_data)
        {


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

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Template/Add_Preview_Visit', $this->data, true);
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

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Form_Previewer_Feedback_Transactions', $this->data, true);
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

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Dashboard_Preview_Property', $this->data, true);
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
        $data_Transaction2   = array();
        $data_Transaction1   = array();
        $data_Transaction    = array();

        _array_p($_POST);

//        foreach($POST_Fields AS $key => $value)
//        {
//
//            // $_POST
//            if($key == 'Assignment_userid' or  $key=='Transaction_id' or $key=='Transactions_uuid' or $key =="ci_csrf_token" or $key =="Form_id" or $key =="FILE_Name" or $key =="FILE" or $key =="geo-zoom"){
//
//            }else{
//
//                $explode_Post = explode("-",$key);
//
//                $Fields_Components = Query_Fields_Components(array("Forms_id"=> $explode_Post[1], "Components_id" => $explode_Post[2],"Fields_key" => $explode_Post[0]));
//
//                if ($Fields_Components->num_rows() > 0) {
//
//                    $Get_validating_Fields         = Get_validating_Fields(array("Forms_id" => $Form_id,"Components_id" => $Fields_Components->row()->Components_id, "company_id" => 0, "Fields_id" => $Fields_Components->row()->Fields_id));
//
//                    if ($Get_validating_Fields->num_rows() > 0) {
//
//                        if ($Fields_Components->row()->Fields_Type == 'Fields') {
//                            $Get_Fields = Get_Fields(array("Fields_id" => $Fields_Components->row()->Fields_id))->row();
//                            Building_form_validation($key, $Get_Fields->item_translation, $Get_validating_Fields->row()->validating_rules);
//                        } elseif ($Fields_Components->row()->Fields_Type == 'List') {
//                            $Get_List = Get_All_List(array("list_id" => $Fields_Components->row()->Fields_id))->row();
//                            Building_form_validation($key, $Get_List->item_translation, $Get_validating_Fields->row()->validating_rules);
//                        }
//
//                        if ($this->form_validation->run() == FALSE) {
//                            $msg_result['key'] = 'Danger';
//                            $msg_result['value'] = validation_errors();
//                            $msg_result_view = Create_Status_Alert($msg_result);
//                            set_message($msg_result_view);
//                            redirect(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transaction_uuid.'/'.$Coordination_uuid, 'refresh');
//                        }
//
//                        if($this->input->post($key, TRUE) !==''){
//                            $data_Transaction1[] = array(
//                                "data_key"      => $explode_Post[0],
//                                "data_value"    => $this->input->post($key, TRUE),
//                                "Forms_id"      => $Form_id,
//                                "Components_id" => $explode_Post[2]
//                            );
//                        }
//
//
//                    }else{
//                        if($this->input->post($key, TRUE) !=='') {
//                            $data_Transaction2[] = array(
//                                "data_key" => $explode_Post[0],
//                                "data_value" => $this->input->post($key, TRUE),
//                                "Forms_id" => $Form_id,
//                                "Components_id" => $explode_Post[2]
//                            );
//                        }
//                    } // if ($Get_validating_Fields->num_rows() > 0)
//
//                } // if($Fields_Components->num_rows()>0)
//
//            } // ignore $_POST
//
//        } // foreach ($POST_Fields AS $field)
//
//        $data_Transaction = @array_merge($data_Transaction2,$data_Transaction1);
//
//        $Create_Transaction_data         = Create_Transaction_Preview_data($Transaction_id,$data_Transaction);
//        $Create_Transaction_data_history = Create_Transaction_Preview_history($Transaction_id,$data_Transaction,'Create');
//
//        if($Create_Transaction_data) {
//            $msg_result['key']     = 'Success';
//            $msg_result['value']   = lang('message_success_insert');
//            $msg_result_view       = Create_Status_Alert($msg_result);
//            set_message($msg_result_view);
//            redirect(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transaction_uuid.'/'.$Coordination_uuid, 'refresh');
//        } else {
//            $msg_result['key']   = 'Danger';
//            $msg_result['value'] = validation_errors();
//            $msg_result_view     = Create_Status_Alert($msg_result);
//            set_message($msg_result_view);
//            redirect(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transaction_uuid.'/'.$Coordination_uuid, 'refresh');
//        }


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

        if($Transaction_id == '' or $Coordination_id == ''){

            $msg['success']        = true;
            $msg['Type_result']    = 'error';
            $msg['Message_result'] = 'يوجد خطا بالبيانات';

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