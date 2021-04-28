<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Print_Evaluation_Reports extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = '';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $this->data['Page_Title']  = 'ادارة نماذج التقارير';

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Print_Evaluation_Reports/views/List_Print_Evaluation_Reports',$this->data,true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Design_Reports()
    {
        $this->data['Page_Title']  = 'تصميم تقرير جديد';
        $this->load->view('../../modules/App_Print_Evaluation_Reports/views/Design_Reports',$this->data);
    }
    ###################################################################

    ###################################################################
    public function Asset_Reports()
    {
        // Get the Template ID posted to the server
        // Template ID and type are configured in your BuilderJS initialization code
        $templateID = $_POST['template_id'];
        $type       = $_POST['type'];

        // Get the directory path of the specified template on the hosting server
        // Path may look like this: /storage/templates/{type}/{ID}/
        $path = BASE_ASSET. "bild/templates/" . $type . "/" . $templateID . "/";

        if ($_POST['assetType'] == 'upload') {
            // Get uploaded file name
            $filename = $_FILES['file']['name'];

            // Escape sensitive characters in file name
            $filename = preg_replace('/[^a-z0-9\._\-]+/i', '_', $filename);

            // Storage path of the uploaded asset:
            // For example: /storage/templates/{type}/{ID}/Uploaded-Image.PNG
            $filepath = "{$path}/{$filename}";

            // Process uploaded file
            move_uploaded_file($_FILES['file']['tmp_name'], $filepath);


        } elseif ($_POST['assetType'] == 'url') {
            // upload file by upload image
            $filename = uniqid();

            // Storage path of the uploaded asset:
            // For example: /storage/templates/{type}/{ID}/604ce5e36d0fa
            $filepath = "{$path}/{$filename}";

            // Download the file's content
            $content = file_get_contents($_POST['url']);

            // Store it:
            file_put_contents($filepath, $content);

        } elseif ($_POST['assetType'] == 'base64') {

            // upload file by upload image
            $filename = uniqid();

            // Storage path of the uploaded asset:
            // For example: /storage/templates/{type}/{ID}/604ce5e36d0fa
            $filepath = "{$path}/{$filename}";

            // Store it
            file_put_contents($filepath, file_get_contents($_POST['url_base64']));
        }

        // Return the relative URL of the asset
        // Set up HTTP header for response
        header('Content-Type: application/json');
        header("HTTP/1.1 200");

        echo json_encode([ 'url' => $filename ]);

    }
    ###################################################################

    ###################################################################
    public function upload_Reports()
    {
        if (isset($_POST) && empty($_FILES['file'])) {
            return json(['error' =>  [ 'file' => 'No file upload' ] ], 404);
        }

        $assetName = uniqid();
        $filename = $_FILES['file']['name'];
        $targetPath = BASE_ASSET . DIRECTORY_SEPARATOR . "bild/tmp/original";
        $uploadPath = BASE_ASSET . DIRECTORY_SEPARATOR . "bild/templates/custom/" . $assetName ."/";
        $movethumbnail = BASE_ASSET . DIRECTORY_SEPARATOR . "bild/templates/custom/";
        $thumbnail = BASE_ASSET . DIRECTORY_SEPARATOR . "bild/assets/image/thumb.png";

        if (isset($_POST) && !empty($_FILES['file'])) {
            $file = $_FILES['file']['tmp_name'];

            move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

            $zip = new ZipArchive();

            $zip->open($targetPath);
            $zip->extractTo($uploadPath);
            $zip->close();

            $files = glob($uploadPath. "/index.html"); /*search index.html in folder*/
            $content = file_get_contents($files[0]);

            copy($thumbnail, $uploadPath. 'thumb.png');
        }

        $tid = $assetName;

        header("HTTP/1.1 200");
        header('Content-Type: application/json');
        echo json_encode([ 'url' => "design.php?id={$tid}&type=custom" ]);

    }
    ###################################################################

    ###################################################################
    public function Save_Reports()
    {
        $templateID = $_POST['template_id'];
        $type = $_POST['type'];

        // Get the directory path of the specified template on the hosting server
        // Path may look like this: /storage/templates/{type}/{ID}/
        // In our sample templates, the HTML content is stored in the "index.html" file
        $path = BASE_URL. "bild/templates/" . $type . "/" . $templateID . "/index.html";

        // Get the HTML content submitted from BuilderJS (when user clicks SAVE)
        $html = $_POST['content'];

        $data['company_id']   = $this->aauth->get_user()->company_id;
        $data['reports_html'] = $_POST['content'];

        $query = app()->db->insert('portal_builder_reports',$data);


        // Check if the file exists. Throw an error otherwise!
        if (!file_exists($path)) {
            header("HTTP/1.1 404");
            echo json_encode([ 'message' => "File not found: $path" ]);
            return;
        }

        // Actually write the updated HTML content to the index.html file
        file_put_contents($path, $html);

        // Return HTTP 200, SUCCESS
        header("HTTP/1.1 200");
        echo json_encode([ 'success' => "Written to file {$path}" ]);
        return;

    }
    ###################################################################

    ###################################################################
    public function Export_Reports()
    {

    }
    ###################################################################



    ###################################################################
    public function Print()
    {

        error_reporting(0);
        ob_start();
        ob_flush();


        $pages = $this->load->view('../../modules/App_Print_Evaluation_Reports/views/Print_Report', $this->data, true);

        $this->load->library('Pdf');

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', true);

        $pdf->SetTitle(' 0 ');
        $pdf->SetAuthor(' 0 ');
        $pdf->SetSubject(' 0 ');
        $pdf->SetKeywords(' ');

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setJPEGQuality(75);

        $pdf->SetDisplayMode('real', 'default');
        $pdf->SetFont('majalla', '', 12);
        $pdf->AddPage();
        $pdf->WriteHTML($pages, false, false, false, false, '');
        $pdf->Output('Print.pdf', 'I');

        ob_end_flush();
        ob_end_clean();

    }
    ###################################################################


}