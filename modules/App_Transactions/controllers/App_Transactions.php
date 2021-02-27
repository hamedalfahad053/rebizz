<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Transactions extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'ادارة المعاملات';

        $this->load->model('Transaction_model');

        error_reporting(0);
        $this->load->add_package_path( APPPATH . 'third_party/fpdf');
        $this->load->library('pdf');


    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $this->data['Page_Title']  = 'ادارة المعاملات';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['PageContent'] = $this->load->view('../../modules/App_Dashboard/views/Dashboard', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function Index_Transactions()
    {
        $this->data['Page_Title']  = 'استلام طلب جديد';

        $this->data['Property_Types'] = Get_Property_Types()->result();

        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'js/pages/crud/forms/editors/summernote','');


        $Transaction_Numbering = Create_Transaction_Numbering();
        $this->session->set_userdata('Create_Transaction_Numbering',$Transaction_Numbering);
        $this->data['Transaction_Numbering'] = $this->session->userdata('Create_Transaction_Numbering');


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Create_Transaction', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function List_Index_Transactions()
    {
        $this->data['Page_Title']  = 'استعراض الطلبات ';

        $where_Transactions = array(
            "company_id"               => $this->data['UserLogin']['Company_User'],
            "location_id"              => $this->data['UserLogin']['Company_Locations'],
            "Create_Transaction_By_id" => $this->aauth->get_user()->id,
            "Transaction_Status_id !=" => 55
        );

        $Get_All_Transactions = Get_All_Transactions($where_Transactions);

        if($Get_All_Transactions->num_rows() == 0 ){
            $this->data['Transactions'] = false;
        }else {


            foreach ($Get_All_Transactions->result() as $Row) {

                $METHOD_OF_RECEIPT = Get_options_List_Translation($Row->LIST_METHOD_OF_RECEIPT)->item_translation;
                $CUSTOMER_CATEGORY = Get_options_List_Translation($Row->LIST_CUSTOMER_CATEGORY)->item_translation;
                $Client_id         = App_Get_Client_Company_By_id($this->data['UserLogin']['Company_User'],$Row->Client_id)->name;
                $Property_Types_id = Get_Property_Types($Row->Property_Types_id)->item_translation;

                // Count location Property
                $Region_id   = Get_Regions(194,$Row->Region_id)->row()->name_ar;
                $City_id     = Get_City(194,$Row->Region_id,$Row->City_id)->row()->name_ar;
                if($Row->District_id == 0 ){
                    $District_id = '';
                }else{
                    $District_id = Get_Districts(194,$Row->Region_id,$Row->City_id,$Row->District_id)->row()->name_ar;
                }
                $location_Property = '  '.$Region_id.' -  '.$City_id.' - '.$District_id;


                $Transactions[] = array(
                    "transaction_id"           => $Row->transaction_id,
                    "transaction_number"       => $Row->transaction_number,
                    "INSTRUMENT_NUMBER"        => $Row->INSTRUMENT_NUMBER,
                    "LIST_METHOD_OF_RECEIPT"   => $METHOD_OF_RECEIPT,
                    "LIST_CUSTOMER_CATEGORY"   => $CUSTOMER_CATEGORY,
                    "Client_id"                => $Client_id,
                    "Property_Types_id"        => $Property_Types_id,
                    "location_Property"        => $location_Property,
                    "Region_id"                => $Row->Region_id,
                    "City_id"                  => $Row->City_id,
                    "District_id"              => $Row->District_id,
                    "Transaction_Stage"        => $Row->Transaction_Stage,
                    "Create_Transaction_By_id" => $this->aauth->get_user($Row->Create_Transaction_By_id)->full_name,
                    "Create_Transaction_Date"  => date('Y-m-d h:i:s a',$Row->Create_Transaction_Date),
                    "Options_Transaction"      => ''
                );
            }


            $this->data['Transactions'] = $Transactions;
        }


        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/List_Index_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function Cancel_Create_Transaction()
    {
        if($this->session->userdata('Create_Transaction_Numbering')) {

            $Transaction_Numbering = $this->session->userdata('Create_Transaction_Numbering');

            $this->db->where('transaction_id',$Transaction_Numbering->transaction_id);
            $this->db->where('Transaction_Status_id', 46);
            $this->db->where('Create_Transaction_By_id', $this->aauth->get_user()->id);
            $this->db->where('company_id', $this->data['UserLogin']['Company_User']);
            $this->db->where('location_id', $this->data['UserLogin']['Company_Locations']);

            $Cancel_Create_Transaction = $this->db->update('protal_transaction',array("Transaction_Status_id"=>55));

            if ($Cancel_Create_Transaction) {

                Create_Logs_User('Cancel_Create_Transaction',$Transaction_Numbering->transaction_id,'Transaction','Cancel');

                $this->session->unset_userdata('Create_Transaction_Numbering');

                $msg_result['key'] = 'Success';
                $msg_result['value'] = 'تم الغاء طلب انشاء المعاملة';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/List_Index_Transactions', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'حدث خطا اثناء طلب انشاء المعاملة';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Transactions/List_Index_Transactions', 'refresh');
            }

        }else{
            $msg_result['key'] = 'Danger';
            $msg_result['value'] = 'لا يوجد معاملة قيد الانشاء لالغائها ';
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/List_Index_Transactions', 'refresh');
        }

    }
    ###################################################################



    ###################################################################
    public function Create_Transaction()
    {
        $this->form_validation->set_rules('Transaction_Numbering', 'رقم المعاملة غير صحيح', 'required');
        $this->form_validation->set_rules('LIST_METHOD_OF_RECEIPT', 'فضلا حدد طريقة الاستلام', 'required');
        $this->form_validation->set_rules('LIST_CUSTOMER_CATEGORY', 'فضلا حدد فئة العميل', 'required');
        $this->form_validation->set_rules('Client_id', 'فضلا حدد العميل ', 'required');
        $this->form_validation->set_rules('Property_Types_id', 'فضلا حدد فئة العقار ', 'required');
        $this->form_validation->set_rules('INSTRUMENT_NUMBER', 'فضلا ادخل رقم الصك', 'required');
        $this->form_validation->set_rules('Region_id', 'فضلا حدد المنطقة ', 'required');
        $this->form_validation->set_rules('City_id', 'فضلا حدد المدينة', 'required');
        $this->form_validation->set_rules('District_id', 'فضلا حدد الحي ', 'required');

        if ($this->form_validation->run() == FALSE) {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Transactions/Index_Transactions', 'refresh');

        }else{

            $Transaction_Numbering  = $this->input->post('Transaction_Numbering');
            $query_Get_Transactions = $this->db->where('transaction_id', $Transaction_Numbering);
            $query_Get_Transactions = $this->db->get('protal_transaction');

            if($query_Get_Transactions->num_rows()>0)
            {

                if($_FILES){
                    $cont = 0;

                    foreach($_FILES['File_Transactions'] AS $k => $v){
                        foreach( $v AS $v2){

                            $attach_file[$cont][$k] = $v2['attachment_file'];
                            $Company_domain = Get_Company($this->data['UserLogin']['Company_User'])->companies_Domain;
                            $Uploader_path = './uploads/companies/'.$Company_domain.'/'.FOLDER_FILE_Transaction_COMPANY;
                            if (!is_dir($Uploader_path)) {
                                mkdir($Uploader_path, 0755, TRUE);
                            }
                            $config['upload_path']    = realpath($Uploader_path);
                            $config['allowed_types']  = 'gif|jpg|png|jpeg|pdf';
                            $config['max_size']       = 1024*3;
                            $config['max_filename']   = 30;
                            $config['encrypt_name']   = true;
                            $config['remove_spaces']  = true;

                            $this->upload->initialize($config);
                            $uploader      = $this->upload->do_upload($attach_file[$cont][$k]);
                            $upload_data   = $this->upload->data();
                        }
                    }

                }else{ // if(array_count_values($option_list)>0)
                    $msg_result['key']   = 'Danger';
                    $msg_result['value'] = 'لا يمكن انشاء معاملة بدون المرفقات المطلوبة';
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL.'/Transactions/Index_Transactions', 'refresh');
                    exit;
                }

                $Data_Transaction['LIST_METHOD_OF_RECEIPT']     = $this->input->post('LIST_METHOD_OF_RECEIPT');
                $Data_Transaction['LIST_CUSTOMER_CATEGORY']     = $this->input->post('LIST_CUSTOMER_CATEGORY');
                $Data_Transaction['LIST_TYPES_OF_REAL_ESTATE_APPRAISAL']     = $this->input->post('LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

                $Data_Transaction['Client_id']                  = $this->input->post('Client_id');
                $Data_Transaction['Property_Types_id']          = $this->input->post('Property_Types_id');
                $Data_Transaction['INSTRUMENT_NUMBER']          = $this->input->post('INSTRUMENT_NUMBER');

                $Data_Transaction['Country_id']                 = $this->input->post('Country_id');
                $Data_Transaction['Region_id']                  = $this->input->post('Region_id');
                $Data_Transaction['City_id']                    = $this->input->post('City_id');
                $Data_Transaction['District_id']                = $this->input->post('District_id');

                $this->db->where('transaction_id', $Transaction_Numbering);
                $Update_Transaction = $this->db->update('protal_transaction',$Data_Transaction);

                if($Update_Transaction){
                    $this->session->unset_userdata('Create_Transaction_Numbering');
                    $msg_result['key']   = 'Success';
                    $msg_result['value'] = lang('message_success_insert');
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL.'/Transactions/List_Index_Transactions' , 'refresh');
                }else{
                    $msg_result['key']   = 'Danger';
                    $msg_result['value'] = lang('message_error_insert');
                    $msg_result_view = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL.'/Transactions/List_Index_Transactions' , 'refresh');
                } // if

            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'رقم المعاملة غير صحيح';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL.'/Transactions/List_Index_Transactions' , 'refresh');
            }

        } // if ($this->form_validation->run() == FALSE

        ob_end_flush();
        ob_end_clean();

    }

    ###################################################################


    ###################################################################
    public function Check_Instrument_Number_By_Transactions()
    {
        if ($this->input->is_ajax_request()) {

            $INSTRUMENT_NUMBER = $this->input->get('INSTRUMENT_NUMBER');
            $Company_id        = $this->data['UserLogin']['Company_User'];

            $Get_Transactions = Get_Transactions_By_Company_id($Company_id,$location_id='',$INSTRUMENT_NUMBER);
            if($Get_Transactions->num_rows()>0) {
                $msg = '';
                $msg .= '<table class="data_table table table-bordered table-hover display nowrap" width="100%">';
                $msg .= '<tr>';
                    $msg .= '<td>رقم المعاملة</td>';
                    $msg .= '<td>العميل</td>';
                    $msg .= '<td>تاريخ المعاملة</td>';
                    $msg .= '<td>بواسطة</td>';
                    $msg .= '<td>حالة المعاملة</td>';
                    $msg .= '<td>نوع الطلب</td>';
                    $msg .= '<td>استعراض</td>';
                $msg .= '<tr>';
                foreach ($Get_Transactions->result() AS $TR)
                {
                    $msg .= '<tr>';
                        $msg .= '<td>'.$TR->transaction_id.'</td>';
                        $msg .= '<td>'.$TR->Client_id.'</td>';
                        $msg .= '<td>'.$TR->Create_Transaction_Date.'</td>';
                        $msg .= '<td>'.$TR->Create_Transaction_By_id.'</td>';
                        $msg .= '<td>'.$TR->Transaction_Status_id.'</td>';
                        $msg .= '<td>'.$TR->LIST_TYPES_OF_REAL_ESTATE_APPRAISAL.'</td>';
                        $msg .= '<td>'.$TR->transaction_id.'</td>';
                    $msg .= '<tr>';
                }
                $msg .= '</table>';
            }else{
                $msg_result['key']   = 'Success';
                $msg_result['value'] = 'نوع المعاملة جديدة يرجى اكمل البيانات ';
                $msg = Create_Status_Alert($msg_result);
            }

            echo $msg;
        } // if($Get_Transactions->num_rows()>0)
    } // Check_Instrument_Number_By_Transactions()
    ###################################################################


    ###################################################################
    public function Data_Transactions()
    {
        $this->data['Page_Title']  = 'المعاملات الجديدة';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/List_Data_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function View_Transactions()
    {

        $this->data['Page_Title']  = ' استعراض معاملة -  ';


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'],base_url(APP_NAMESPACE_URL.'/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transactions', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################






    ###################################################################
    public function XXXX()
    {

        $post_var_input_form = $_POST;
        $post_var_files_form = $_FILES;


        #############################################
        # Start :: Checking all the input fields
        #############################################
        if(!empty($post_var_input_form)){

            foreach ($post_var_input_form AS $key => $value)
            {
              echo $key.' = '.$value;

            } // foreach
        }
        #############################################
        # End :: Checking all the input fields
        #############################################



        #############################################
        # Start :: Checking all the input Files
        #############################################
        if(!empty($post_var_files_form)){

            foreach ($post_var_files_form AS $key => $value)
            {

                echo $key.' = '.$value;


            } // foreach

        } // if(!empty($post_var_files_form)){
        #############################################
        # End :: Checking all the input Files
        #############################################


    }
    ###################################################################

}