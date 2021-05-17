<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Report_Transaction extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'تقارير المعاملات ';
    }
    ###################################################################


    ###################################################################
    public function index()
    {

        $this->data['Page_Title']      = ' تقارير المعاملات  ';



    }
    ###################################################################

    ###################################################################
    public function Settings()
    {



        $Transaction_id  =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"          =>  $Transaction_id,
            "company_id"    =>  $this->aauth->get_user()->company_id,
            "location_id"   =>  $this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $this->data['Transactions']  = $Get_Transactions->row();

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->data['Page_Title']      = ' اعداد التقرير  ';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Report_Transaction/Report_Settings', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################


    ###################################################################
    public function Report_Forms()
    {

    }
    ###################################################################

    ###################################################################
    public function Report_HTML()
    {
        $Transaction_id         = $this->uri->segment(4);
        $Transaction_Reports_id = '4bb1830a-a9e3-11eb-a685-309c2316b02a'; //$this->uri->segment(5);

        $where_Transactions = array(
            "uuid"       => $Transaction_id,
            "company_id" => app()->aauth->get_user()->company_id
        );
        $Get_Transactions = Get_Transaction($where_Transactions)->row();

        $Get_Reports = app()->db->where('company_id', $this->aauth->get_user()->company_id);
        $Get_Reports = app()->db->where('build_reports_uuid', $Transaction_Reports_id);
        $Get_Reports = app()->db->get('portal_build_reports_transaction')->row();


        $where_Transactions = array(
            "uuid"       => $Transaction_id,
            "company_id" => app()->aauth->get_user()->company_id
        );
        $Get_Transactions = Get_Transaction($where_Transactions)->row();

        $Get_All_Data_Transaction = app()->db->where('company_id', app()->aauth->get_user()->company_id);
        $Get_All_Data_Transaction = app()->db->where('Transaction_id', $Get_Transactions->transaction_id);
        $Get_All_Data_Transaction = app()->db->get('protal_transaction_data');

        foreach ($Get_All_Data_Transaction->result() as $R_D) {

            $Fields_Components = Query_Fields_Components(
                array("Forms_id"      => $R_D->Forms_id,
                      "Components_id" => $R_D->Components_id,
                      "Fields_key"    => $R_D->data_key)
                )->row();

            if ($Fields_Components->Fields_Type == 'Fields') {

                $data_array_Data_Transaction_A['{Value_TD_' . $R_D->data_key . '}'] = $R_D->data_value;

            } elseif ($Fields_Components->Fields_Type == 'List') {

                $data_q    = Transaction_data_by_key($Get_Transactions->transaction_id, $R_D->Forms_id, $R_D->Components_id, $R_D->data_key);
                $data_list = get_data_options_List_view($Fields_Components->Fields_id, $data_q);

                $data_array_Data_Transaction_B['{Value_TD_' . $R_D->data_key . '}'] = $data_list;

            }

        } // foreach ($Get_All_Data_Transaction->result() AS $R_D)






        $pages = $Get_Reports->Reports_content;

        $array_mirge = array_merge($data_array_Data_Transaction_A, $data_array_Data_Transaction_B);

        //_array_p($arra_mirge);

        _array_p($array_mirge);
        
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();


        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $pages);

        $xpath = new DOMXPath($dom);

        foreach($xpath->query('//text()') as $node)
        {


            $nodeValue = $node->nodeValue;

            $string = str_replace(array("{","}"),'',$nodeValue);

            # File
            if($string == 'TRANSACTION_ATTACHMENTS'){

            }else{


                $string_explode = explode('_',$string);

                _array_p($string_explode);

                ##################################################################################################
                # @ $string_explode[0] == All Data List OR Value
                # @ $string_explode[1] == TD OR TP OR MAP OR PHOTO OR
                # @ $string_explode[2] == Fields_key  After Clear explode (0,1)  table (forms_components_fields)
                ##################################################################################################

                ##################################################################################################
                # List All and Chek
                if($string_explode[0] == "All"){

                    $type           = 'All';
                    $table_data     = $string_explode[1];
                    $list_key       = str_replace("All_TD_",'', $string);
                    echo $list_key;

                    if($string_explode[1] == 'TD')
                    {




                    }


                ##################################################################################################
                # List and Field == value
                }elseif($string_explode[0] == "Value"){

                        $type     = 'Value';
                        $list_key = str_replace("Value_",'', $string);


                        $Fields_Components = app()->db->where('Fields_key',$list_key);
                        $Fields_Components = app()->db->get('portal_forms_components_fields');

                        if($Fields_Components->num_rows()>0){

                            $Fields_Components = $Fields_Components->row();

                            if ($Fields_Components->Fields_Type == 'Fields') {


                            } elseif ($Fields_Components->Fields_Type == 'List') {


                            }

                        }

                }
                ##################################################################################################


            }


            $replaced = strtr($node->wholeText, $array_mirge);
            $newNode  = $dom->createDocumentFragment();
            $newNode->appendXML($replaced);

            $node->parentNode->replaceChild($newNode, $node);
            /* echo preg_replace("#<h1.*?>.*?</h1>#", "", $str);*/
        }

        $replacedHTML = $dom->saveXML($xpath->query('//body')->item(0));
        print $replacedHTML;

    }
    ###################################################################


    ###################################################################
    public function Report_PDF()
    {

        error_reporting(0);
        ob_start();
        ob_flush();

        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', true);

        $pdf->SetTitle('تقرير');
        $pdf->SetAuthor('تقرير');
        $pdf->SetSubject('تقرير');
        $pdf->SetKeywords('تقرير');


        $Transaction_id             =  $this->uri->segment(4);
        $Transaction_Reports_id     =  '4bb1830a-a9e3-11eb-a685-309c2316b02a'; //$this->uri->segment(5);

        $Get_Reports = app()->db->where('company_id',$this->aauth->get_user()->company_id);
        $Get_Reports = app()->db->where('build_reports_uuid',$Transaction_Reports_id );
        $Get_Reports = app()->db->get('portal_build_reports_transaction')->row();

        $pages =  $Get_Reports->Reports_content;


        $lg = Array();
        $lg['a_meta_charset']  = 'UTF-8';
        $lg['a_meta_dir']      = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page']          = 'page';
        $pdf->setLanguageArray($lg);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setJPEGQuality(75);

        $pdf->SetDisplayMode('real', 'default');
        $pdf->SetFont('majalla', '', 12);
        $pdf->AddPage();
        $pdf->WriteHTML($pages, false, false, false, false, '');
        $pdf->Output('Report_Preview.pdf', 'I');

        ob_end_flush();
        ob_end_clean();
    }
    ###################################################################






}