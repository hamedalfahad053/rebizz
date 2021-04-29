<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Ajax extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
    }
    ###################################################################

    ###################################################################
    public function index()
    {



    }
    ###################################################################

    ###############################################################################################
    public function Ajax_Uploaded_File_Transaction()
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

                    $Image_Processing->setResolution(300, 300);
                    $Image_Processing->setImageFormat( 'png' );
                    $Image_Processing->thumbnailImage($size_page[0], $size_page[1]);

                    $file_name = uniqid().md5(time());

                    $uploader = $Image_Processing->writeImage(FCPATH.'uploads/companies/' . $Company_domain . '/' . FOLDER_FILE_Transaction_COMPANY.'/'.$file_name.'_'.$x."_image.png");


                    $data_file['Transaction_id']        = '0';
                    $data_file['File_Name_In']          = $_POST['file_name'];
                    $data_file['LIST_TRANSACTION_DOCUMENTS']          = $_POST['LIST_TRANSACTION_DOCUMENTS'];
                    $data_file['Transaction_id']        = 0;
                    $data_file["company_id"]            = $this->aauth->get_user()->company_id;
                    $data_file["file_name"]             = $file_name.$x."_image.png";
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
                $data_file   = array();

                $data_file['Transaction_id']        = '0';
                $data_file['File_Name_In']          = $_POST['file_name'];
                $data_file['LIST_TRANSACTION_DOCUMENTS']          = $_POST['LIST_TRANSACTION_DOCUMENTS'];
                $data_file['Transaction_id']        = 0;
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

                if($uploader)
                {
                    $Create_Transaction_files = Create_Transaction_files($data_file);
                    $Get_Transaction_files    = Get_Transaction_files(array("file_uplode_id"=>$Create_Transaction_files))->row();
                }

                $uuid_file .=  '<input name="files_Transaction_ids[]" type="hidden" value="'.$Get_Transaction_files->uuid.'">';

            }
            ###################################################################################################################

        echo json_encode($uuid_file);

    }
    ###############################################################################################

    ###############################################################################################
    public function Ajax_Uploaded_File_Previewer()
    {

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

            $this->upload->initialize($config);

            $uploader = $this->upload->do_upload('file_att');
            $upload_data = $this->upload->data();

            $data_file = array();

            $data_file['Transaction_id']        = '0';
            $data_file['File_Name_In']          = $_POST['file_name'];
            $data_file['preview_id']            = $_POST['preview_id'];
            $data_file['Transaction_id']        = $_POST['Transaction_id'];
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


            if($uploader){
                $Create_Transaction_files = Create_Transaction_files($data_file);
                $Get_Transaction_files    = Get_Transaction_files(array("file_uplode_id"=>$Create_Transaction_files))->row();
            }

            $msg['uuid_file'] =  $Get_Transaction_files->uuid;

            echo json_encode($msg);

    }
    ###############################################################################################

    ###############################################################################################
    public function Ajax_Components()
    {
            $lang          = get_current_lang();
            $form_id       = trim($this->input->get('form_id'));

            $CUSTOMER_CATEGORY                 = trim($this->input->get('CUSTOMER_CATEGORY'));
            $TYPE_OF_PROPERTY                  = trim($this->input->get('TYPE_OF_PROPERTY'));
            $TYPES_OF_REAL_ESTATE_APPRAISAL    = trim($this->input->get('TYPES_OF_REAL_ESTATE_APPRAISAL'));
            $LIST_CLIENT                       = trim($this->input->get('LIST_CLIENT'));
            $this->db->distinct('With_Type_CUSTOMER,With_Type_Property,With_TYPES_APPRAISAL,With_CLIENT,translation_lang');
            $this->db->from('portal_forms_components  components');
            $this->db->join('portal_forms_components_translation   components_translation', 'components.components_id = components_translation.item_id');

            if (!empty($CUSTOMER_CATEGORY)){
                $this->db->where("(FIND_IN_SET(".$CUSTOMER_CATEGORY.",components.With_Type_CUSTOMER) != 0 OR components.With_Type_CUSTOMER = 'All')");
            }

            if ($TYPE_OF_PROPERTY){
                $this->db->where("( FIND_IN_SET(".$TYPE_OF_PROPERTY.",components.With_Type_Property) !=0 OR components.With_Type_Property= 'All' )");
            }

            if ($TYPES_OF_REAL_ESTATE_APPRAISAL){
                $this->db->where("( FIND_IN_SET(".$TYPES_OF_REAL_ESTATE_APPRAISAL.",components.With_TYPES_APPRAISAL) != 0 OR components.With_TYPES_APPRAISAL = 'All')");
            }

            if ($LIST_CLIENT) {
                $this->db->where("(FIND_IN_SET(" . $LIST_CLIENT . ",components.With_CLIENT) !=0 OR components.With_CLIENT = 'All')");
            }

            $this->db->where(" (components.company_id = ".$this->aauth->get_user()->company_id." OR (components.company_id = 0 AND ( components.With_Type_CUSTOMER != 'All' OR components.With_Type_Property != 'All' OR components.With_TYPES_APPRAISAL  != 'All' OR components.With_CLIENT != 'All' )) ) ");
            $this->db->where('components.Forms_id',$form_id);

            $this->db->where('components_translation.translation_lang',$lang);
            $query = $this->db->get();

            if($query->num_rows()>0) {
                $data['query'] = $query;
                $this->load->view('../../modules/App_Ajax/Tamplet_Components_Ajax',$data);
            }
    }
    ###############################################################################################



    ###############################################################################################
    public function Ajax_LIST()
    {
        header('Content-Type: application/json');

        $lang                  = get_current_lang();
        $options               = array();


        $form_id               = trim($this->input->get('form_id'));
        $components_id         = trim($this->input->get('components_id'));
        $components_fields_id  = trim($this->input->get('components_fields_id'));
        $Fields_Type           = trim($this->input->get('Fields_Type'));
        $Fields_id             = trim($this->input->get('Fields_id'));
        $list_id               = trim($this->input->get('list_id'));
        $List_Target_id        = trim($this->input->get('List_Target_id'));
        $option_id             = trim($this->input->get('option_id'));


        $query_get_setting_list  = $this->db->where('Forms_id',$form_id);
        $query_get_setting_list  = $this->db->where('Components_id',$components_id);
        $query_get_setting_list  = $this->db->where('Components_fields_id',$components_fields_id);
        $query_get_setting_list  = $this->db->get('portal_forms_components_fields')->row();

        //_array_p($query_get_setting_list);


        $query_receipt_emp_permissions = app()->db->where('receipt_emp_userid',app()->aauth->get_user()->id);
        $query_receipt_emp_permissions = app()->db->where('company_id',app()->aauth->get_user()->company_id);
        $query_receipt_emp_permissions = app()->db->get('protal_transactions_receipt_emp_permissions');

        $array_receipt_emp_permissions_mr = @explode(',', $query_receipt_emp_permissions->row()->LIST_METHOD_OF_RECEIPT);
        $array_receipt_emp_permissions_cc = @explode(',', $query_receipt_emp_permissions->row()->LIST_CUSTOMER_CATEGORY);
        $array_receipt_emp_permissions_cl = @explode(',', $query_receipt_emp_permissions->row()->LIST_CLIENT);


        ############################################################################################################################################
        if($Fields_Type == 'options_to_options_ajax'){



            $option_query  = $this->db->where('list_options_id',$option_id);
            $option_query  = $this->db->get('portal_list_options_data')->row();

            $query_options = app()->db->from('portal_list_options_data  list_options');
            $query_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
            $query_options = app()->db->where('list_options.list_id',$List_Target_id);
            $query_options = app()->db->where_in('list_options.list_options_id',$option_query->parent_id,false);
            $query_options = app()->db->where('options_translation.translation_lang',$lang);
            $query_options = app()->db->where('list_options.options_status',1);
            $query_options = app()->db->order_by('list_options.options_sort', 'ASC');
            $query_options = app()->db->get();

            if($query_options->num_rows() == 0){
                $options[] = '';
            }else{





                foreach ($query_options->result() as $row)
                {

                    if($list_id == 6) {


                        if ($query_receipt_emp_permissions->num_rows() > 0) {

                            if (in_array($row->list_options_id,$array_receipt_emp_permissions_mr)) {
                                $options[] = array(
                                    "options_id"    => $row->list_options_id,
                                    "options_key"   => $row->options_key,
                                    "options_type"  => 'options',
                                    "options_title" => $row->item_translation
                                );
                            }

                        } // if($query_receipt_emp_permissions->num_rows()>0)

                    }elseif ($list_id == 16){

                        if ($query_receipt_emp_permissions->num_rows() > 0) {

                            if (in_array($row->list_options_id, $array_receipt_emp_permissions_cc)) {
                                $options[] = array(
                                    "options_id" => $row->list_options_id,
                                    "options_key" => $row->options_key,
                                    "options_type" => 'options',
                                    "options_title" => $row->item_translation
                                );
                            }

                        } // if($query_receipt_emp_permissions->num_rows()>0)

                    }else{

                        $options[] = array(
                            "options_id" => $row->list_options_id,
                            "options_key" => $row->options_key,
                            "options_type" => 'options',
                            "options_title" => $row->item_translation
                        );

                    }

                } // foreach ($query_options->result() as $row)


            } // if($query_options->num_rows() == 0)

        }
        ############################################################################################################################################

        ############################################################################################################################################
        if($Fields_Type == 'options_to_table_ajax') {

            if($query_get_setting_list->join_table == NULL){

                $query_list_options = $this->db->where($query_get_setting_list->primary_fields_link_to_options,$option_id);
                $query_list_options = $this->db->get($query_get_setting_list->Table_primary);


                foreach ($query_list_options->result() as $row)
                {
                    $primary_fields           = $query_get_setting_list->primary_fields;
                    $Join_fields              = $query_get_setting_list->Join_fields;


                    if($list_id == 6) {



                        if ($query_receipt_emp_permissions->num_rows() > 0) {

                            if (in_array($row->$primary_fields, $array_receipt_emp_permissions_cl)) {

                                    $options[] = array(
                                        "options_id"    => $row->$primary_fields,
                                        "options_key"   => '',
                                        "options_type"  => 'table',
                                        "options_title" => $row->$Join_fields,
                                    );

                            }

                        } // if($query_receipt_emp_permissions->num_rows()>0)

                    }elseif ($list_id == 16){

                        if ($query_receipt_emp_permissions->num_rows() > 0) {
                            if (in_array($row->$primary_fields, $array_receipt_emp_permissions_cl)) {
                                $options[] = array(
                                    "options_id"    => $row->$primary_fields,
                                    "options_key"   => '',
                                    "options_type"  => 'table',
                                    "options_title" => $row->$Join_fields,
                                );
                            }
                        } // if($query_receipt_emp_permissions->num_rows()>0)

                    }elseif ($list_id == 20){

                        if ($query_receipt_emp_permissions->num_rows() > 0) {
                            if (in_array($row->$primary_fields, $array_receipt_emp_permissions_cl)) {
                                $options[] = array(
                                    "options_id"    => $row->$primary_fields,
                                    "options_key"   => '',
                                    "options_type"  => 'table',
                                    "options_title" => $row->$Join_fields,
                                );
                            }
                        } // if($query_receipt_emp_permissions->num_rows()>0)

                    }else{

                        $options[] = array(
                            "options_id"    => $row->$primary_fields,
                            "options_key"   => '',
                            "options_type"  => 'table',
                            "options_title" => $row->$Join_fields,
                        );

                    }



                } // foreach ($query_list_options->result() as $row)

            }else {

                $query_list_options = $this->db->from($query_get_setting_list->Table_primary . ' Table_Primary');
                $query_list_options = $this->db->join($query_get_setting_list->Table_Join . '    Table_Join', 'Table_Primary.' . $query_get_setting_list->primary_joining_fields . ' = Table_Join.' . $query_get_setting_list->Join_joining_fields . '');
                $query_list_options = $this->db->where('Table_Primary.'.$query_get_setting_list->primary_fields_link_to_options,$option_id);

                if($query_get_setting_list->linked_company_id == 1){
                    $query_list_options = $this->db->where('(Table_Primary.company_id',$this->aauth->get_user()->company_id);
                }

                if($query_get_setting_list->linked_translation == 1){
                    $query_list_options = $this->db->where('Table_Join.translation_lang',$lang);
                }

                $query_list_options = $this->db->get();

                foreach ($query_list_options->result() as $row) {

                    $Table_primary_fields = $query_get_setting_list->primary_fields;
                    $Table_Join_fields    = $query_get_setting_list->Join_fields;

                    if($list_id == 6) {

                        if ($query_receipt_emp_permissions->num_rows() > 0) {


                            if (in_array($row->list_options_id, $array_receipt_emp_permissions_mr)) {

                                $options[] = array(
                                    "options_id"    => $row->$primary_fields,
                                    "options_key"   => '',
                                    "options_type"  => 'table',
                                    "options_title" => $row->$Join_fields,
                                );

                            }

                        } // if($query_receipt_emp_permissions->num_rows()>0)

                    }elseif ($list_id == 16){

                        if ($query_receipt_emp_permissions->num_rows() > 0) {

                            if (in_array($row->list_options_id, $array_receipt_emp_permissions_cc)) {

                                $options[] = array(
                                    "options_id"    => $row->$primary_fields,
                                    "options_key"   => '',
                                    "options_type"  => 'table',
                                    "options_title" => $row->$Join_fields,
                                );
                            }

                        } // if($query_receipt_emp_permissions->num_rows()>0)

                    }else {
                        $options[] = array(
                            "options_id" => $row->$Table_primary_fields,
                            "options_key" => '',
                            "options_type" => 'table',
                            "options_title" => $row->$Table_Join_fields,
                        );
                    }
                }

            }


        }
        ############################################################################################################################################

        ############################################################################################################################################
        if($Fields_Type == 'table_to_table_ajax') {


            $query_list_options = $this->db->where($query_get_setting_list->primary_fields_link_to_options,$option_id);
            $query_list_options = $this->db->get($query_get_setting_list->Table_Join);

            if($query_get_setting_list->linked_company_id == 1){
                $query_list_options = $this->db->where('(Table_Primary.company_id',$this->aauth->get_user()->company_id);
            }

            if($query_get_setting_list->linked_translation == 1){
                $where_translation  = $query_get_setting_list->Join_fields;
                $query_list_options = $this->db->where($query_get_setting_list->Table_Join .'.'.$where_translation,$lang);
            }

            if($query_get_setting_list->linked_company_id == 1){
                $query_list_options = $this->db->where('(Table_Primary.company_id',$this->aauth->get_user()->company_id);
            }


            foreach ($query_list_options->result() as $row) {

                $Table_primary_fields = $query_get_setting_list->Join_joining_fields;
                $Table_Join_fields    = $query_get_setting_list->Join_fields;

                $options[] = array(
                    "options_id"    => $row->$Table_primary_fields,
                    "options_key"   => '',
                    "options_type"  => 'table',
                    "options_title" => $row->$Table_Join_fields,
                );

            }

        }
        ############################################################################################################################################



        $msg['type']    = true;
        $msg['data']    = $options;
        $msg['success'] = true;

        echo json_encode($msg);
    }
    ###############################################################################################




    ###############################################################################################
    public function Ajax_List_Client_by_type()
    {

        $company_id  = $this->aauth->get_user()->company_id;
        $Client_type = $this->input->get('CUSTOMER_CATEGORY');

        $query = $this->db->where('company_id', $company_id);
        $query = $this->db->where('is_active', 1);
        $query = $this->db->where_in('type_id', $Client_type);
        $query = $this->db->get('portal_app_client');

        if($query->num_rows()>0){

            foreach ($query->result() as $row) {
                $options[] = array(
                    "options_id"    => $row->client_id,
                    "options_title" => $row->name,
                );
            }

        }else{
            $options = '';
        }

        $msg['type']    = true;
        $msg['data']    = $options;
        $msg['success'] = true;

        echo json_encode($msg);

    }
    ###############################################################################################


    ###############################################################################################
    public function Ajax_mail_sms_messages()
    {

        $company_id  = $this->aauth->get_user()->company_id;
        $query = $this->db->where('company_id', $company_id);
        $query = $this->db->where('isDeleted', 0);
        $query = $this->db->get('protal_mail_sms_messages');

        if($query->num_rows()>0){

            foreach ($query->result() as $row) {
                $options[] = array(
                    "options_id"    => $row->messages_id,
                    "options_title" => $row->messages_title,
                );
            }
        }else{
            $options = '';
        }

        $msg['type']    = true;
        $msg['data']    = $options;
        $msg['success'] = true;
        echo json_encode($msg);
    }
    ###############################################################################################

    ###############################################################################################
    public function Ajax_text_p_mail_sms_messages()
    {

        $messages_id = trim($this->input->get('messages_id'));

        $company_id  = $this->aauth->get_user()->company_id;
        $query = $this->db->where('company_id', $company_id);
        $query = $this->db->where('messages_id',$messages_id);
        $query = $this->db->where('isDeleted', 0);
        $query = $this->db->get('protal_mail_sms_messages');

        if($query->num_rows()>0){
            $text = $query->row()->messages_text;
        }else{
            $text = '';
        }

        $msg['type']    = true;
        $msg['data']    = $text;
        $msg['success'] = true;
        echo json_encode($msg);

    }
    ###############################################################################################



}