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
        $Get_All_Transactions        = '';


        $Transactions = false;



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

        $validating_building = array();
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

           $Fields_Components     =  Query_Fields_Components(array("Fields_key" => $key));

           if($Fields_Components->num_rows()>0){

               $Get_validating_Fields         = Get_validating_Fields(array("Forms_id" => $Form_id,
                                                                            "company_id"=>0,
                                                                            "Fields_id" => $Fields_Components->row()->Fields_id));

               $Get_validating_Fields_company = Get_validating_Fields(array("Forms_id"   => $Form_id,
                                                                            "company_id" => $this->aauth->get_user()->company_id,
                                                                            "Fields_id"  => $Fields_Components->row()->Fields_id));
               if ($Get_validating_Fields->num_rows() > 0)
               {
                   if ($Fields_Components->row()->Fields_Type == 'Fields') {

                       $Get_Fields = Get_Fields(array("Fields_id" => $Fields_Components->row()->Fields_id))->row();
                       Building_form_validation($key,$Get_Fields->item_translation,$Get_validating_Fields->row()->validating_rules);

                   } elseif ($Fields_Components->row()->Fields_Type == 'List') {

                       $Get_List   = Get_All_List(array("list_id" => $Fields_Components->row()->Fields_id))->row();
                       Building_form_validation($key,$Get_List->item_translation,$Get_validating_Fields->row()->validating_rules);

                   }

                   if ($this->form_validation->run() == FALSE) {
                       $msg_result['key'] = 'Danger';
                       $msg_result['value'] = validation_errors();
                       $msg_result_view = Create_Status_Alert($msg_result);
                       set_message($msg_result_view);
                       redirect(APP_NAMESPACE_URL . '/Transactions/Create_Transaction/', 'refresh');
                   }

                   $data_Transaction[$key] = $this->input->post($key,TRUE);

               } // if ($Get_validating_Fields->num_rows() > 0)

           } // if($Fields_Components->num_rows()>0)

        } // foreach ($POST_Fields AS $field)


        ##########################################################################################################################################
        # START :: INSERT DB Transaction
        $data_Transaction_static['transaction_number']        = date('Ymd');
        $data_Transaction_static['company_id']                = $this->aauth->get_user()->company_id;
        $data_Transaction_static['location_id']               = $this->aauth->get_user()->locations_id;
        $data_Transaction_static['Transaction_Status_id']     = '1';
        $data_Transaction_static['Create_Transaction_By_id']  = $this->aauth->get_user()->id;
        $data_Transaction_static['Create_Transaction_Date']   = time();

        $this->db->trans_start(TRUE);

        $Create_Transaction      = Create_Transaction($data_Transaction_static);
        $Create_Transaction_data = Create_Transaction_data($Create_Transaction,$data_Transaction);

        $this->db->trans_complete();


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






}