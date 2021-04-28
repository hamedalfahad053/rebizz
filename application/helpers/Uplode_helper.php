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




##############################################################################
if(!function_exists('Tiff_Splitter_Uploaded'))
{

    function Tiff_Splitter_Uploaded($file)
    {
        $image = new Imagick($file);

        $count = $image->getNumberImages();

        $x =0;

        foreach ( $image as $image ) {
            $x++;
            $image->setImageFormat( 'png' );
            $image->thumbnailImage(700, 500);
            $image_array[] = $image;
            //$image->writeImage( APPPATH.'../uploads/Page_'.$x."_image.png" );
        }

        //<img id='" . $x . "' src='data:image/png;base64,".base64_encode($image)."' />

        return $image_array;
    }

}
##############################################################################


##############################################################################
//if(!function_exists('readImageBlob')) {
//    function readImageBlob()
//    {
//        $base64 = "iVBORw0KGgoAAAANSUhEUgAAAM0AAAD
        // NCAMAAAAsYgRbAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5c
        // cllPAAAABJQTFRF3NSmzMewPxIG//ncJEJsldTou1jHgAAAARBJREFUeNrs2EEK
        // gCAQBVDLuv+V20dENbMY831wKz4Y/VHb/5RGQ0NDQ0NDQ0NDQ0NDQ0NDQ
        // 0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0PzMWtyaGhoaGhoaGhoaGhoaGhoxtb0QGho
        // aGhoaGhoaGhoaGhoaMbRLEvv50VTQ9OTQ5OpyZ01GpM2g0bfmDQaL7S+ofFC6x
        // v3ZpxJiywakzbvd9r3RWPS9I2+MWk0+kbf0Hih9Y17U0nTHibrDDQ0NDQ0NDQ0
        // NDQ0NDQ0NTXbRSL/AK72o6GhoaGhoRlL8951vwsNDQ0NDQ1NDc0WyHtDTEhD
        // Q0NDQ0NTS5MdGhoaGhoaGhoaGhoaGhoaGhoaGhoaGposzSHAAErMwwQ2HwRQ
        // AAAAAElFTkSuQmCC";
//
//        $imageBlob = base64_decode($base64);
//
//        $imagick = new Imagick();
//        $imagick->readImageBlob($imageBlob);
//
//        header("Content-Type: image/png");
//        echo $imagick;
//    }
//
//
//}
##############################################################################


//$file = realpath('uploads/ex.pdf');
//        $im = new imagick();
//        $im->setResolution(300, 300);
//        $im->readImage($file);
//        $im->setImageFormat('jpeg');
//        $im->setImageCompression(imagick::COMPRESSION_JPEG);
//        $im->setImageCompressionQuality(100);
//// -flatten option, this is necessary for images with transparency, it will produce white background for transparent regions
//        $im = $im->flattenImages();
//        $im->writeImage(APPPATH.'../uploads/' . str_replace('pdf', 'jpeg', $file));
//        $im->clear();
//        $im->destroy();
// $im->resizeImage(1200, 0,  imagick::FILTER_LANCZOS, 1);
//
//        $im = new imagick($file);
//
//        // convert to jpg
//        $im->setImageColorspace(255);
//        $im->setCompression(Imagick::COMPRESSION_JPEG);
//        $im->setCompressionQuality(60);
//        $im->setImageFormat('jpeg');
//
//        //resize
//        $im->resizeImage(290, 375, imagick::FILTER_LANCZOS, 1);
//
//        //write image on server
//        $im->writeImage('thumb.jpg');
//        $im->clear();
//        $im->destroy();

//        $image = new Imagick();
//        echo  $image->getFormat();
//        echo $count = $image->getNumberImages();
//
//        $x =0;

// foreach ( $image as $image ) {

//           $image->readimage($file.'[0]');
//           $image->setImageCompression(imagick::COMPRESSION_JPEG);
//           $image->setImageCompressionQuality(100);
////            $x++;
//       $image->setResolution(300,300);
//            $image->setImageFormat( 'png' );
//            $image->thumbnailImage(700, 500);
//
//            $image_array[] = $image;
//            echo '<br>';
//            echo $image->getCopyright();
//            echo '<br>';
//            //$image->readimage($file.'[0]');
//            //echo print_r($image->getImageProfiles());
//            echo '<br>';
//            //echo print_r($image->getImageGeometry());
//            echo '<br>';
//            echo $image->getCompressionQuality();
//            echo '<br>';
//            echo $image->writeImage( APPPATH.'../uploads/Page_'.$x."_image.png" );
//
//            $exifArray = $image->getImageProperties("*");
//            foreach ($exifArray as $name => $property)
//            {
//                echo "{$name} => {$property}<br />\n";
//            }
//
//
//      }
//            $image->readImageFile($file);
//            echo $image->getFormat($file);
//
//            echo '<br>';
//
//
//            $exifArray = $image->getImageProperties("*", FALSE);
//            foreach ($exifArray as $name => $property)
//            {
//                echo "{$name} => {$property}<br />\n";
//            }
//            $image->clear();
//            $image->destroy();
//
//


//       $Tiff_Splitter =  Tiff_Splitter_Uploaded($file);
//
//       _array_p($Tiff_Splitter);