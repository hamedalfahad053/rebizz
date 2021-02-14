<?php
if(!function_exists('Uploader_Insert_Data'))
{
    function Uploader_Insert_Data($data)
    {
        $query = app()->db->insert('protal_file_uplode',$data);

        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }

    }
}
##############################################################################



##############################################################################
if(!function_exists('Uploader_File_Companies'))
{
    #$date = str_replace( ':', '', $date);
    #if (!is_dir('uploads/'.$date)) {
    #    mkdir('./uploads/' . $date, 0777, TRUE);
    #}
    #date('Y-m-d H.i.s')

    function Uploader_File_Companies($file, $domain, $folder)
    {
        app()->load->database();
        app()->load->library('upload');

        $Uploader_path = BASEPATH.'uploads/companies/'.$domain.'/'.$folder;
        if (!is_dir($Uploader_path)) {
            mkdir($Uploader_path, 0755, TRUE);
        }
        $config['upload_path']    = $Uploader_path;
        $config['allowed_types']  = 'gif|jpg|png|pdf|jpg';
        $config['max_size']       = '100000';
        $config['max_filename']   = 30;
        $config['encrypt_name']   = true;
        $config['remove_spaces']  = true;
        app()->upload->initialize($config);
        $uploader = app()->upload->do_upload($file);

        $upload_data   = app()->upload->data($file);

        if($uploader){

            $upload_data               = app()->upload->data($file);

            $data_file["file_name"]    = $upload_data['file_name'];
            $data_file["file_type"]    = $upload_data['file_type'];
            $data_file["file_path"]    = $upload_data['file_path'];
            $data_file["full_path"]    = $upload_data['full_path'];
            $data_file["raw_name"]     = $upload_data['raw_name'];
            $data_file["orig_name"]    = $upload_data['orig_name'];
            $data_file["client_name"]  = $upload_data['client_name'];
            $data_file["file_ext"]     = $upload_data['file_ext'];
            $data_file["file_size"]    = $upload_data['file_size'];
            $data_file["is_image"]     = $upload_data['is_image']; // Whether the file is an image or not. 1 = image. 0 = not.
            $data_file["image_type"]   = $upload_data['image_type'];

            $Message['type']    = true;
            $Message['Message'] = 'Upload Done';
            $Message['File']    = $data_file;
            return $Message;

        }else{
            $Message['type']    = false;
            $Message['Message'] = app()->upload->display_errors('<p>', '</p>');
            return $Message;
        }


    }

}
##############################################################################