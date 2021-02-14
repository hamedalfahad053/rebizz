<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Evaluation_Methods extends Admin
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Evaluation_Methods_model');


        $this->data['controller_name'] = 'ادارة طرق التقييم';
    }
    ###################################################################

    ###################################################################
    public function index()
    {

        $Get_All_Evaluation_Methods = $this->Evaluation_Methods_model->Get_All_Evaluation_Methods();

        foreach ($Get_All_Evaluation_Methods->result() AS $ROW )
        {

            if($ROW->evaluation_methods_Status == 1) {
                $Evaluation_methods_status =  Create_Status_badge(array("key"=>"Success","value"=>lang('Status_Active')));
            }else{
                $Evaluation_methods_status =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Status_Disabled')));
            }


            if($ROW->evaluation_methods_status_system == 1){
                $Evaluation_methods_options =  Create_Status_badge(array("key"=>"Danger","value"=>lang('Basic_System')));
            }else {
                $options = array();
                $options['view'] = array("class"=>"","id"=>"","title" => lang('view_button'), "data-attribute" => '', "href" => base_url(ADMIN_NAMESPACE_URL . '/Evaluation_Types/'));
                $options['edit'] = array("class"=>"","id"=>"","title" => lang('edit_button'), "data-attribute" => '', "href" => "#");
                $options['deleted'] = array("class"=>"","id"=>"","title" => lang('deleted_button'), "data-attribute" => '', "href" => "#");

                if ($ROW->evaluation_methods_Status == 0) {
                    $options['active'] = array("class"=>"","id"=>"","title" => lang('active_button'), "data-attribute" => '', "href" => "#");
                } else {
                    $options['disable'] = array("class"=>"","id"=>"","title" => lang('disable_button'), "data-attribute" => '', "href" => "#");
                }
                $Evaluation_methods_options = Create_Options_Button($options);
            }

            $this->data['Evaluation_Methods'][]  = array(
                "evaluation_methods_id"            => $ROW->evaluation_methods_id,
                "evaluation_methods_technique"     => Get_options_List_Translation($ROW->evaluation_methods_technique_id)->item_translation,
                "evaluation_methods_Key"           => $ROW->evaluation_methods_Key,
                "evaluation_methods_name"          => $ROW->item_translation,
                "Evaluation_methods_status"        => $Evaluation_methods_status,
                "Evaluation_methods_options"       => $Evaluation_methods_options,
            );



        } // foreach (->result() AS $ROW )


        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page_Title']    = 'ادارة اساليب التقييم';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/System_Evaluation_Methods/views/Evaluation_Methods_List',$this->data,true);

        Layout_Admin($this->data);

    }
    ###################################################################


    ###################################################################
    public function Form_Add_Evaluation_Methods()
    {

        $this->data['Page_Title']  = 'اضافة طريقة تقييم';

        $this->data['TECHNIQUE_OF_EVALUATION']        = Get_Data_List('select','LIST_TECHNIQUE_OF_EVALUATION');
        $this->data['status']                         = array_options_status();
        $this->data['status_system']                  = array_options_status_system();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(ADMIN_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(ADMIN_NAMESPACE_URL.'/Group_Users'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/System_Evaluation_Methods/views/Form_Add_Evaluation_Methods',$this->data,true);
        Layout_Admin($this->data);

    }
    ###################################################################

    ###################################################################
    public function Create_Evaluation_Methods()
    {
        $this->form_validation->set_rules('title_ar','title_ar','required');
        $this->form_validation->set_rules('title_en','title_en','required');
        $this->form_validation->set_rules('LIST_TECHNIQUE_OF_EVALUATION','LIST_TECHNIQUE_OF_EVALUATION','required');
        $this->form_validation->set_rules('status','status','required');
        $this->form_validation->set_rules('status_system','status_system','required');

        if($this->form_validation->run()==FALSE){

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(ADMIN_NAMESPACE_URL.'/Evaluation_Types/Form_Add_Evaluation_Methods', 'refresh');

        }else{

                    $data_Evaluation_Types['evaluation_methods_Key']            = strtoupper(str_replace(" ", "_", $this->input->post('title_en')));
                    $data_Evaluation_Types['evaluation_methods_Status']         =  $this->input->post('status');
                    $data_Evaluation_Types['evaluation_methods_technique_id']   =  $this->input->post('LIST_TECHNIQUE_OF_EVALUATION');
                    $data_Evaluation_Types['evaluation_methods_status_system']  =  $this->input->post('status_system');

                    $data_Evaluation_Types['evaluation_methods_createBy']         =  0;
                    $data_Evaluation_Types['evaluation_methods_createDate']       =  time();
                    $data_Evaluation_Types['evaluation_methods_lastModifyDate']   =  time();
                    $data_Evaluation_Types['evaluation_methods_isDeleted']        =  0;
                    $data_Evaluation_Types['evaluation_methods_DeletedBy']        =  0;

                    $Get_Evaluation_Methods = $this->Evaluation_Methods_model->Create_Evaluation_Methods($data_Evaluation_Types);

                    if($Get_Evaluation_Methods){

                        $item_ar = $this->input->post('title_ar');
                        $item_en = $this->input->post('title_en');
                        insert_translation_Language_item('portal_evaluation_methods_translation', $Get_Evaluation_Methods, $item_ar, $item_en);

                        $msg_result['key']   = 'Success';
                        $msg_result['value'] = lang('message_success_insert');
                        $msg_result_view = Create_Status_Alert($msg_result);
                        set_message($msg_result_view);
                        redirect(ADMIN_NAMESPACE_URL.'/Evaluation_Methods' , 'refresh');
                    }else{
                        $msg_result['key']   = 'Danger';
                        $msg_result['value'] = lang('message_error_insert');
                        $msg_result_view = Create_Status_Alert($msg_result);
                        set_message($msg_result_view);
                        redirect(ADMIN_NAMESPACE_URL.'/Evaluation_Methods', 'refresh');
                    }

        } // if($this->form_validation->run()==FALSE){

    }
    ###################################################################











}