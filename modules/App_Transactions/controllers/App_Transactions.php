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


    ###################################################################
    public function index()
    {
        $this->data['Page_Title']      = 'استعراض الطلبات ';
        $Transactions                  = array();



        $where_Transactions = array(
            "company_id"               => $this->aauth->get_user()->company_id,
            "location_id"              => $this->aauth->get_user()->locations_id,
            "Create_Transaction_By_id" => $this->aauth->get_user()->id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            foreach ($Get_Transactions->result() as $ROW)
            {
                $Transactions[] = array(
                    "transaction_id"           => $ROW->transaction_id,
                    "transaction_number"       => $ROW->transaction_number,
                    "transaction_uuid"         => $ROW->uuid,
                    "Transaction_Stage"        => $ROW->Transaction_Stage,
                    "Transaction_Status_id"    => $ROW->Transaction_Status_id,
                    "Create_Transaction_By_id" => $ROW->Create_Transaction_By_id,
                    "Create_Transaction_Date"  => $ROW->Create_Transaction_Date
                );
            }

        }else{
            $Transactions = false;
        }

        $this->data['Transactions'] = $Transactions;


        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();


        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/List_Transactions', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_Transaction()
    {
        $this->data['Page_Title']     = 'استلام طلب جديد';

        Create_Logs_User('Create_Transaction','','Transaction','Create');

        $where_user_departments = array(
            "users.departments_id" => ''
        );
        $Get_Company_Users = Get_Company_Users($where_user_departments);
        $emp_departments = '';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Create_Transaction', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Transaction_Submit()
    {

        $POST_Fields         = $_POST;
        $FILE_UPLOAD         = $_FILES;
        $Form_id             = $this->input->post('Form_id');

        if(!$_FILES){
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = 'لا يمكن انشاء معاملة بدون المرفقات المطلوبة';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Transactions/Create_Transaction/', 'refresh');
            exit;
        }

        foreach($POST_Fields AS $key => $value)
        {

            //ignore $_POST
            if($key == 'Assignment_userid'){

            }else {
                $Fields_Components = Query_Fields_Components(array("Fields_key" => $key));

                if ($Fields_Components->num_rows() > 0) {

                    $Get_validating_Fields = Get_validating_Fields(array("Forms_id" => $Form_id,
                        "company_id" => 0,
                        "Fields_id" => $Fields_Components->row()->Fields_id));

                    $Get_validating_Fields_company = Get_validating_Fields(array("Forms_id" => $Form_id,
                        "company_id" => $this->aauth->get_user()->company_id,
                        "Fields_id" => $Fields_Components->row()->Fields_id));

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
                            redirect(APP_NAMESPACE_URL . '/Transactions/Create_Transaction/', 'refresh');
                        }

                        $data_Transaction[$key] = $this->input->post($key, TRUE);

                    } // if ($Get_validating_Fields->num_rows() > 0)

                } // if($Fields_Components->num_rows()>0)

            } // ignore $_POST

        } // foreach ($POST_Fields AS $field)


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
        $data_Transaction_static['Transaction_Status_id']     = '1';
        $data_Transaction_static['Transaction_Stage']         = $Get_Stages->stages_key;
        $data_Transaction_static['Assignment_userid']         = $this->input->post('Assignment_userid');
        $data_Transaction_static['Create_Transaction_By_id']  = $this->aauth->get_user()->id;
        $data_Transaction_static['Create_Transaction_Date']   = time();

        $Create_Transaction              = Create_Transaction($data_Transaction_static);
        $Create_Transaction_data         = Create_Transaction_data($Create_Transaction,$data_Transaction);
        $Create_Transaction_data_history = Create_Transaction_data_history($Create_Transaction,$data_Transaction,'Create');

        # END :: DB Transaction
        ##########################################################################################################################################
        # Uplode File
        $countarray = count($_FILES['FILE']['name']);

        for($i=0;$i<$countarray;$i++)
        {

            $_FILES['file']['name']     = $_FILES['FILE']['name'][$i];
            $_FILES['file']['type']     = $_FILES['FILE']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['FILE']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['FILE']['error'][$i];
            $_FILES['file']['size']     = $_FILES['FILE']['size'][$i];

            $Company_domain = Get_Company($this->aauth->get_user()->company_id)->companies_Domain;
            $Uploader_path = './uploads/companies/'.$Company_domain.'/'.FOLDER_FILE_Transaction_COMPANY;

            if (!is_dir($Uploader_path)) {
                mkdir($Uploader_path, 0755, TRUE);
            }

            $config['upload_path']    = realpath($Uploader_path);
            $config['file_name']      = $_FILES['FILE']['name'][$i];
            $config['allowed_types']  = 'gif|jpg|png|jpeg|pdf';
            $config['max_size']       = 1024*10;
            $config['max_filename']   = 30;
            $config['encrypt_name']   = true;
            $config['remove_spaces']  = true;

            $this->upload->initialize($config);

            $uploader      = $this->upload->do_upload('file');
            $upload_data   = $this->upload->data();

            $data_file = array();

            $data_file['Transaction_id']        = $Create_Transaction;
            $data_file['File_Name_In']          = $_POST['FILE_Name'][$i];
            $data_file["company_id"]            = $this->aauth->get_user()->company_id;
            $data_file["file_name"]             = $upload_data['file_name'];
            $data_file["file_type"]             = $upload_data['file_type'];
            $data_file["file_path"]             = $upload_data['file_path'];
            $data_file["full_path"]             = $upload_data['full_path'];
            $data_file["raw_name"]              = $upload_data['raw_name'];
            $data_file["orig_name"]             = $upload_data['orig_name'];
            $data_file["client_name"]           = $upload_data['client_name'];
            $data_file["file_ext"]              = $upload_data['file_ext'];
            $data_file["is_image"]              = $upload_data['is_image']; // Whether the file is an image or not. 1 = image. 0 = not.
            $data_file["image_type"]            = $upload_data['image_type'];
            $data_file["file_createBy"]         = $this->aauth->get_user()->id;
            $data_file["file_createDate"]       = time();
            $data_file["file_lastModifyDate"]   = 0;
            $data_file["file_isDeleted"]        = 0;
            $data_file["file_DeletedBy"]        = 0;

            $Create_Transaction_files     = Create_Transaction_files($data_file);


        } // for($i=0;$i<$countarray;$i++)
        ##########################################################################################################################################


        if($Create_Transaction and $Create_Transaction_data){

                //$massage_Notifications = lang('Notifications_Assignment_Transaction').'<a >'.$Create_Transaction.'</a>';
                //$Create_Notifications  = Create_Notifications($data_Transaction_static['Assignment_userid'], 'AssignmentTransaction', $massage_Notifications);

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
    public function Check_Instrument_Number_By_Transactions()
    {
        $INSTRUMENT_NUMBER       = $this->input->get('INSTRUMENT_NUMBER');

        $msg = array();

        if($INSTRUMENT_NUMBER !=''){

            $where_Transactions_data = array(
                "company_id"    => $this->aauth->get_user()->company_id,
                "data_key"      => 'INSTRUMENT_NUMBER',
                "data_value"    => $INSTRUMENT_NUMBER,
            );
            $Get_Transaction_data    = Get_Transaction_data($where_Transactions_data);

            if($Get_Transaction_data->num_rows()>0){

                foreach ($Get_Transaction_data->result() AS $R )
                {

                    $Transaction[] = array(
                        "Transaction_id"    => "",
                        "INSTRUMENT_NUMBER" => $R->INSTRUMENT_NUMBER,
                    );

                } // foreach ($where_Transactions_data->result() AS $R )


                $msg['Transaction'] = $Transaction;
                $msg['Type']        = 'result';

            }else{

                $msg['Transaction'] = false;
                $msg['Type']        = 'zero_result';

            } // if($where_Transactions_data->num_rows()>0)

        }else{

        }

        echo json_encode($msg);
    }
    ###################################################################

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


            $this->data['Transactions']      = $Get_Transactions->row();

            # Get  Transactions Data
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
            $this->data['Transactions'] = false;
        }

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transactions', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################



}