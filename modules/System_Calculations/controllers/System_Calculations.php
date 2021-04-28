<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Calculations extends Admin
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
        $this->data['Page_Title']  = '';

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Calculations/views/List_Calculations',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Add_Calculations()
    {
        $this->data['Page_Title']       = 'اضافة عملية حسابية جديدة';

        $this->data['Fields_All_Data'] = Get_Fields()->result();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Fields_Calculations'));

        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/System_Calculations/views/Add_Calculations.php',$this->data,true);

        Layout_Admin($this->data);
    }
    ###################################################################

    ###################################################################
    public function Create_Calculations()
    {

        $this->form_validation->set_rules('Fields_A', 'الحقل الاول', 'required');
        $this->form_validation->set_rules('Fields_B', 'Fields_Components_id', 'required');
        $this->form_validation->set_rules('Fields_C', 'Fields_Add', 'required');
        $this->form_validation->set_rules('Calculations_type', 'Form_id', 'required');

        if ($this->form_validation->run() == FALSE) {

            $msg_result['key'] = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL . '/Calculations/Add_Calculations/', 'refresh');

        } else {


            $where_Get_Calculations = array(
                "Field_A_id" => $this->input->post('Fields_A'),
                "Field_B_id" => $this->input->post('Fields_B'),
                "Field_C_id" => $this->input->post('Fields_C'),
                "Calculations_type" => $this->input->post('Calculations_type')
            );
            $Get_Calculations = Get_Calculations($where_Get_Calculations);

            if ($Get_Calculations->num_rows() > 0) {

                $msg_result['key'] = 'Danger';
                $msg_result['value'] = 'العملية مضافة مسبقا ';
                $msg_result_view = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect(ADMIN_NAMESPACE_URL . '/Calculations/Add_Calculations/', 'refresh');

            } else {

                $data_Calculations['Field_A_id']        = $this->input->post('Fields_A');
                $data_Calculations['Field_A_key']       = Get_Fields(array("Fields_id"=>$this->input->post('Fields_A')))->row()->Fields_key;

                $data_Calculations['Field_B_id']        = $this->input->post('Fields_B');
                $data_Calculations['Field_B_key']       = Get_Fields(array("Fields_id"=>$this->input->post('Fields_B')))->row()->Fields_key;

                $data_Calculations['Field_C_id']        = $this->input->post('Fields_C');
                $data_Calculations['Field_C_key']       = Get_Fields(array("Fields_id"=>$this->input->post('Fields_C')))->row()->Fields_key;

                $data_Calculations['ratio']             = $this->input->post('ratio');
                $data_Calculations['Calculations_type'] = $this->input->post('Calculations_type');

                $Create_Calculations = Create_Calculations($data_Calculations);

                if ($Create_Calculations) {

                    $msg_result['key']   = 'Success';
                    $msg_result['value'] = lang('message_success_insert');
                    $msg_result_view     = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(ADMIN_NAMESPACE_URL . '/Calculations/', 'refresh');

                } else {

                    $msg_result['key']    = 'Danger';
                    $msg_result['value']  = lang('message_error_insert');
                    $msg_result_view      = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(ADMIN_NAMESPACE_URL . '/Calculations/', 'refresh');

                } // if


            } // if($Get_Calculations->num_rows()>0)

        } // if ($this->form_validation->run() == FALSE)

    }
    ###################################################################


}