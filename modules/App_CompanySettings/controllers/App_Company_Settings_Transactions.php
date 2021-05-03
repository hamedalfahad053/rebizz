<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Company_Settings_Transactions extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = ' اعدادت المعاملات ';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $where_Get_Receipt_Emp  = array(
            "company_id" => $this->aauth->get_user()->company_id
        );

        $Get_Receipt_Emp = Get_Receipt_Emp_Permissions($where_Get_Receipt_Emp);

        $this->data['Get_Receipt_Emp'] =  $Get_Receipt_Emp;


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = 'الاعدادات العامة ';
        $this->data['Page_Company'] = '';
        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/Settings_Transaction/List_Receipt_Transactions', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Setting_Receipt_Transactions()
    {
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = 'الاعدادات العامة ';
        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/Settings_Transaction/Setting_Receipt_Transactions', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Form_Add_Receipt_Transactions()
    {

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL . '/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL . '/Company_Settings'));

        $this->data['breadcrumbs']  = $this->mybreadcrumb->render();
        $this->data['Page_Title']   = 'الاعدادات العامة ';
        $this->data['Page_Company'] = '';
        $this->data['PageContent']  = $this->load->view('../../modules/App_CompanySettings/views/Settings_Transaction/Form_Add_Receipt_Transactions', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function Ajax_METHOD_OF_RECEIPT_To_CUSTOMER_CATEGORY()
    {
        header('Content-Type: application/json');

        $lang                  = get_current_lang();
        $options               = array();

        $METHOD_OF_RECEIPT     = $this->input->get('LIST_METHOD_OF_RECEIPT');


        $query_options = app()->db->from('portal_list_options_data  list_options');
        $query_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
        $query_options = $this->db->where("list_options.list_id",16);
        $this->db->where("FIND_IN_SET(".$METHOD_OF_RECEIPT.",list_options.parent_id)");
        $query_options = app()->db->where('options_translation.translation_lang',$lang);
        $query_options = app()->db->where('list_options.options_status',1);
        $query_options = app()->db->order_by('list_options.options_sort', 'ASC');

        $query_options = app()->db->get();

        if($query_options->num_rows() == 0){

            $options[] = '';

        }else{

            foreach ($query_options->result() as $row)
            {

                $options[] = array(
                    "options_id"    => $row->list_options_id,
                    "options_key"   => $row->options_key,
                    "options_type"  => 'options',
                    "options_title" => $row->item_translation,
                );

            }

        } // if($query_options->num_rows() == 0)


        $msg['type']    = true;
        $msg['data']    = $options;
        $msg['success'] = true;

        echo json_encode($msg);

    }
    ###################################################################

    ###################################################################
    public function Create_Receipt_Transactions_Setting()
    {
        $this->form_validation->set_rules('emp_id','الموظف','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL.'/Settings_Transaction/Form_Add_Receipt_Transactions', 'refresh');

        }else{

            $data_Receipt = array();

            if (is_array($this->input->post('LIST_METHOD_OF_RECEIPT'))) {
                $data_Receipt['LIST_METHOD_OF_RECEIPT'] = implode(',', $this->input->post('LIST_METHOD_OF_RECEIPT'));
            } else {
                $data_Receipt['LIST_METHOD_OF_RECEIPT'] = $this->input->post('LIST_METHOD_OF_RECEIPT');
            }

            if (is_array($this->input->post('LIST_CUSTOMER_CATEGORY'))) {
                $data_Receipt['LIST_CUSTOMER_CATEGORY'] = implode(',', $this->input->post('LIST_CUSTOMER_CATEGORY'));
            } else {
                $data_Receipt['LIST_CUSTOMER_CATEGORY'] = $this->input->post('LIST_CUSTOMER_CATEGORY');
            }

            if (is_array($this->input->post('LIST_CLIENT'))) {
                $data_Receipt['LIST_CLIENT'] = implode(',', $this->input->post('LIST_CLIENT'));
            } else {
                $data_Receipt['LIST_CLIENT'] = $this->input->post('LIST_CLIENT');
            }

            $data_Receipt['receipt_emp_userid']  = $this->input->post('emp_id');
            $data_Receipt['company_id']          = $this->aauth->get_user()->company_id;
            $data_Receipt['CreateBy']            = $this->aauth->get_user()->id;
            $data_Receipt['CreateDate']          = time();

            $query_insert = app()->db->insert('protal_transactions_receipt_emp_permissions',$data_Receipt);

            if ($query_insert) {
                $msg_result['key'] = 'Success';
                $msg_result['value'] = lang('message_success_insert');
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL . '/Settings_Transaction/', 'refresh');
            } else {
                $msg_result['key'] = 'Danger';
                $msg_result['value'] = validation_errors();
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(APP_NAMESPACE_URL   . '/Settings_Transaction/', 'refresh');
            }

        } // if($this->form_validation->run()==FALSE)

    }
    ###################################################################

    ###################################################################
    public function Edit_Receipt_Transactions()
    {

    }
    ###################################################################

    ###################################################################
    public function Deleted_Receipt_Transactions()
    {

    }
    ###################################################################



}