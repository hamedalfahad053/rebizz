
<?php

    $Company_domain = Get_Company($this->aauth->get_user()->company_id)->companies_Domain;

    $Uploader_path  = './uploads/companies/' . $Company_domain . '/' . FOLDER_FILE_Transaction_COMPANY;


    foreach ($Get_Transaction_files AS $RF)
    {
//       $array_file[] = $Uploader_path.'/'.;
        echo $RF['file_name'];
    }

//    $filename="combine".rand().".pdf";
//
//    $pdf = new Imagick();
//
//    $pdf->setImageFormat('pdf');
//
//    $pdf->writeImages('', true);
//
//    $buffer = file_get_contents('');
//
//    header("Content-Type: application/force-download");
//    header("Content-Type: application/octet-stream");
//    header("Content-Type: application/download");
//
//    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//
//    header("Content-Type: application/octet-stream");
//    header("Content-Transfer-Encoding: binary");
//    header("Content-Length: " . strlen($buffer));
//    header("Content-Disposition: attachment; filename=$filename");
//
//    echo $buffer;
?>