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
    public function HTML()
    {

    }
    ###################################################################

    ###################################################################
    public function Print()
    {

        error_reporting(0);
        ob_start();
        ob_flush();



        $pages = '';

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