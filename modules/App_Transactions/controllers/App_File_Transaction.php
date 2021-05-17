<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_File_Transaction extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' مرفقات المعاملات';
    }
    ###################################################################

    # Done
    ###################################################################
    public function index()
    {
      exit;
    }
    ###################################################################

    # Done
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

    # Done
    ###################################################################
    public function Upload_File_Transaction()
    {

        if(!Check_Permissions(44)) {
            exit;
        }

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
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/File_Transaction/Upload_File_Transaction', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    # Done
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

    # Done
    ###################################################################
    public function Download_File_Transaction()
    {
        $Transaction_id     = $this->uri->segment(4);
        $uuid_file          = $this->uri->segment(5);

        $Company_domain = Get_Company($this->aauth->get_user()->company_id)->companies_Domain;
        $Uploader_path = './uploads/companies/' . $Company_domain . '/' . FOLDER_FILE_Transaction_COMPANY;


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

    # Done
    ###################################################################
    public function Edit_File_Transaction()
    {
        if(!Check_Permissions(46)) {
            exit;
        }

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
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/File_Transaction/Edit_File_Transaction', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    # Done
    ###################################################################
    public function Delete_File_Transaction()
    {
        if(!Check_Permissions(47)) {
            exit;
        }

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

    # Done
    ###################################################################
    public function Sort_File_Transaction()
    {
        if(!Check_Permissions(45)) {
            exit;
        }


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

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/File_Transaction/Sort_File_Transaction', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    # Done
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
            redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transactions_uuid, 'refresh');

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
                redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transactions_uuid, 'refresh');

            } else {

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'لم يتم التحديث يوجد خطا ما ';
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transactions_uuid, 'refresh');

            }

        }

    }
    ###################################################################
}
?>