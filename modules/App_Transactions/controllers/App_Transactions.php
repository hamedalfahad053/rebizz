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
    public function List_Index_Transactions()
    {

        $this->data['Page_Title']  = 'استعراض الطلبات ';

        $where_Transactions               = array(
            "company_id"=>$this->data['UserLogin']['Company_User']
        );

        $Get_All_Transactions = Get_All_Transactions($where_Transactions);

        foreach ($Get_All_Transactions->result() AS $Row)
        {
            $Transactions[] = array(
                "transaction_id"           => $Row->transaction_id,
                "INSTRUMENT_NUMBER"        => $Row->INSTRUMENT_NUMBER,
                "LIST_METHOD_OF_RECEIPT"   => $Row->LIST_METHOD_OF_RECEIPT,
                "LIST_CUSTOMER_CATEGORY"   => $Row->LIST_CUSTOMER_CATEGORY,
                "Client_id"                => $Row->Client_id,
                "Property_Types_id"        => $Row->Property_Types_id,
                "Region_id"                => $Row->Region_id,
                "City_id"                  => $Row->City_id,
                "District_id"              => $Row->District_id,
                "Transaction_Stage"        => $Row->Transaction_Stage,
                "Create_Transaction_By_id" => $Row->Create_Transaction_By_id,
                "Create_Transaction_Date"  => $Row->Create_Transaction_Date
            );
        }

        $this->data['Transactions'] = $Transactions;


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/List_Index_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function Index_Transactions()
    {
        $this->data['Page_Title']  = 'استلام طلب جديد';

        $this->data['Property_Types'] = Get_Property_Types()->result();

        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'js/pages/crud/forms/editors/summernote','');


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Index_Transactions', $this->data, true);
        Layout_Apps($this->data);

    }
    ###################################################################


    ###################################################################
    public function Create_Transaction()
    {
        $this->form_validation->set_rules('LIST_METHOD_OF_RECEIPT','LIST_METHOD_OF_RECEIPT','required');
        $this->form_validation->set_rules('LIST_CUSTOMER_CATEGORY','LIST_CUSTOMER_CATEGORY','required');
        $this->form_validation->set_rules('Client_id','Client_id','required');
        $this->form_validation->set_rules('Property_Types_id','Property_Types_id','required');
        $this->form_validation->set_rules('INSTRUMENT_NUMBER','INSTRUMENT_NUMBER','required');

        $this->form_validation->set_rules('Country_id','Country_id','required');
        $this->form_validation->set_rules('Region_id','Region_id','required');
        $this->form_validation->set_rules('City_id','City_id','required');
        $this->form_validation->set_rules('District_id','District_id','required');

        $this->form_validation->set_rules('start_time_entry','start_time_entry','required');
        $this->form_validation->set_rules('LIST_TRANSFER_THE_TRANSACTION_TO','LIST_TRANSFER_THE_TRANSACTION_TO','required');


        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/Index_Transactions', 'refresh');

        }else{




            $Data_Transaction['LIST_METHOD_OF_RECEIPT']     = $this->input->post('LIST_METHOD_OF_RECEIPT');
            $Data_Transaction['LIST_CUSTOMER_CATEGORY']     = $this->input->post('LIST_CUSTOMER_CATEGORY');
            $Data_Transaction['Client_id']                  = $this->input->post('Client_id');
            $Data_Transaction['Property_Types_id']          = $this->input->post('Property_Types_id');
            $Data_Transaction['INSTRUMENT_NUMBER']          = $this->input->post('INSTRUMENT_NUMBER');
            $Data_Transaction['company_id']                 = $this->data['UserLogin']['Company_User'];
            $Data_Transaction['location_id']                = $this->data['UserLogin']['Company_Locations'];

            $Data_Transaction['Country_id']                 = $this->input->post('Country_id');
            $Data_Transaction['Region_id']                  = $this->input->post('Region_id');
            $Data_Transaction['City_id']                    = $this->input->post('City_id');
            $Data_Transaction['District_id']                = $this->input->post('District_id');

            $Data_Transaction['start_time_entry']           = $this->input->post('start_time_entry');
            $Data_Transaction['end_entry_time_submit']      = time();
            $Data_Transaction['Create_Transaction_By_id']   = $this->aauth->get_user()->id;

            $Data_Transaction['Create_Transaction_Date']    = time();
            $Data_Transaction['Transaction_Stage']          = $this->input->post('LIST_TRANSFER_THE_TRANSACTION_TO');

            $Create_Transaction = $this->Transaction_model->Transaction_Insert($Data_Transaction);

            if($Create_Transaction){

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


        } //if($this->form_validation->run()==FALSE)



    }
    ###################################################################





    ###################################################################
    public function Check_Instrument_Number_By_Transactions()
    {

        if ($this->input->is_ajax_request()) {

            $INSTRUMENT_NUMBER = $this->input->get('INSTRUMENT_NUMBER');
            $Company_id        = $this->data['UserLogin']['Company_User'];

            $Get_Transactions = Get_Transactions_By_Company_id($Company_id,$location_id='',$INSTRUMENT_NUMBER);

            if($Get_Transactions->num_rows()>0)
            {

                $row_Transactions = $Get_Transactions->row();
                $Transaction_id   = $row_Transactions->transaction_id;
                $Transaction_Date = $row_Transactions->Create_Transaction_Date;

                $mass = 'يوجد معاملة مسجلة برقم -'.$Transaction_id.' - بتاريخ '.date('Y-m-d',$Transaction_Date);
                $msg  =  Create_Status_badge(array("key"=>"Success","value"=>$mass));

            }else{
                $msg =  Create_Status_badge(array("key"=>"danger","value"=>'المعاملة جديدة فضلا اكمل البيانات'));
            }


            echo $msg;

        }


    } // Check_Instrument_Number_By_Transactions()
    ###################################################################


    ###################################################################
    public function Data_Transactions()
    {

        $this->data['Page_Title']  = 'المعاملات الجديدة';


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Data_Transactions', $this->data, true);
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