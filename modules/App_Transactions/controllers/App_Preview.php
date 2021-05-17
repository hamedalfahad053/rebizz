<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Preview extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'ادارة المعاملات';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
       exit;
    }
    ###################################################################

    ###################################################################
    public function Dashboard()
    {

        $Transaction_id  =  $this->uri->segment(4);

        $where_Transactions = array(
            "uuid"=>$Transaction_id,
            "company_id"=>$this->aauth->get_user()->company_id,
            "location_id"=>$this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $this->data['Transactions']  = $Get_Transactions->row();

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }


        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');



        $this->data['Page_Title']      = ' المعاينة ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();


        $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Previewer/index', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ###################################################################

    ######################################################################################################
    public function Form_Preview_Feedback()
    {

        $Transaction_id  =  $this->uri->segment(4);
        $Coordination_id =  $this->uri->segment(5);

        $where_Transactions = array(
            "uuid"=>$Transaction_id,"company_id"=>$this->aauth->get_user()->company_id,"location_id"=>$this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $GetTransactions = $Get_Transactions->row();

            $where_Preview_Visit = array("Transactions_id"=> $GetTransactions->transaction_id,"Coordination_uuid"=>$Coordination_id);
            $Get_Preview_Visit = Get_Preview_Visit($where_Preview_Visit);

            if($Get_Preview_Visit->num_rows()>0){
                $this->data['Coordination']  = $Get_Preview_Visit->row();
                $this->data['Transactions']  = $Get_Transactions->row();
            }else{
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
            }

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

        $this->data['Page_Title']      = ' اضافة افادة  ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageParent']  = $this->load->view('../../modules/App_Transactions/views/Previewer/Form_Previewer_Feedback_Transactions', $this->data, true);
        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/View_Transaction/Layout_View_Transactions', $this->data, true);
        Layout_Apps($this->data);
    }
    ######################################################################################################

    ######################################################################################################
    public function Create_Preview_FeedBack()
    {

        $Transaction_id  =  $this->uri->segment(4);
        $Coordination_id =  $this->uri->segment(5);

        $where_Transactions = array(
            "uuid"=>$Transaction_id,"company_id"=>$this->aauth->get_user()->company_id,"location_id"=>$this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $GetTransactions = $Get_Transactions->row();
            $where_Preview_Visit = array("Transactions_id"=> $GetTransactions->transaction_id,"Coordination_uuid"=>$Coordination_id);

            $Get_Preview_Visit = Get_Preview_Visit($where_Preview_Visit);

            if($Get_Preview_Visit->num_rows()>0){

                $this->data['Coordination']  = $Get_Preview_Visit->row();
                $this->data['Transactions']  = $Get_Transactions->row();


                $this->form_validation->set_rules('LIST_VISITING_STATUS','حالة الافادة','required');
                $this->form_validation->set_rules('note_visit','ملاحظات','required');

                if($this->input->post('LIST_VISITING_STATUS') == 298){
                    $this->form_validation->set_rules('Date_visit','تاريخ الزيارة','required');
                    $this->form_validation->set_rules('Time_visit','وقت الزيارة','required');
                }

                if($this->form_validation->run()==FALSE){
                    $msg_result['key']   = 'Danger';
                    $msg_result['value'] = validation_errors();
                    $msg_result_view     = Create_Status_Alert($msg_result);
                    set_message($msg_result_view);
                    redirect(APP_NAMESPACE_URL.'/Preview/Form_Preview_Feedback/'.$Transaction_id.'/'.$Coordination_id, 'refresh');
                } else {

                    if(IsHijri($this->input->post('Date_visit')) == true){
                        $preview_date_ex = explode('-',$this->input->post('Date_visit'));
                        $converted       = Hijri2Greg($preview_date_ex[2], $preview_date_ex[1], $preview_date_ex[0], $string = false);
                        $coldata         = $converted['year'].'-'.$converted['month'].'-'.$converted['day'];
                        $preview_date    = strtotime($coldata);
                    }else{
                        $preview_date = strtotime($this->input->post('Date_visit'));
                    }

                    $data_Preview_Visit['Coordination_id']  = $this->data['Coordination']->Coordination_id;
                    $data_Preview_Visit['VISITING_STATUS']  = $this->input->post('LIST_VISITING_STATUS');
                    $data_Preview_Visit['Date_visit']       = $preview_date;
                    $data_Preview_Visit['feedback_userid']  = $this->aauth->get_user()->id;
                    $data_Preview_Visit['Time_visit']       = $this->input->post('Time_visit');
                    $data_Preview_Visit['feedback_text']    = $this->input->post('note_visit');
                    $data_Preview_Visit['CreateDate']       = time();
                    $data_Preview_Visit['createBy']         = $this->aauth->get_user()->id;


                    app()->db->where('Coordination_id',$this->data['Coordination']->createBy);
                    app()->db->set('preview_stauts',$this->input->post('LIST_VISITING_STATUS'));
                    app()->db->update('protal_transaction_coordination');

                    $create_Preview_Visit_FeedBack = Create_Preview_Visit_FeedBack($data_Preview_Visit);

                    ##########################################################################################################################################
                    # Time Progresses
                    Create_Logs_User('',$this->data['Transactions']->transaction_id,'Transaction','Preview_FeedBack');
                    ##########################################################################################################################################
                    $Assignment_userid   = $this->data['Coordination']->Coordination_id;
                    $Notifications_title = 'افادة المعاين  ';
                    $Notifications_text  = 'تم اضافة افادة من المعاين على الزيارة  ';
                    Create_Notifications_Transaction($Transaction_id,$Assignment_userid,$Notifications_title,$Notifications_text);
                    ##########################################################################################################################################

                    if ($create_Preview_Visit_FeedBack) {
                        $msg_result['key'] = 'Success';
                        $msg_result['value'] = lang('message_success_insert');
                        $msg_result_view = Create_Status_Alert($msg_result);
                        set_message($msg_result_view);
                        redirect(APP_NAMESPACE_URL . '/Preview/Dashboard/'.$Transaction_id, 'refresh');
                    } else {
                        $msg_result['key'] = 'Danger';
                        $msg_result['value'] = lang('message_error_insert');
                        $msg_result_view = Create_Status_Alert($msg_result);
                        set_message($msg_result_view);
                        redirect(APP_NAMESPACE_URL . '/Preview/Dashboard/'.$Transaction_id.'/'.$Coordination_id, 'refresh');
                    }

                } // if($this->form_validation->run()==FALSE)

            }else{
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
            }


        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }

    }
    ######################################################################################################

    ######################################################################################################
    public function Dashboard_Preview_Property()
    {

        $Transaction_id  =  $this->uri->segment(4);
        $Coordination_id =  $this->uri->segment(5);

        $where_Transactions = array(
            "uuid"=>$Transaction_id,"company_id"=>$this->aauth->get_user()->company_id,"location_id"=>$this->aauth->get_user()->locations_id,
        );

        $Get_Transactions  = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $GetTransactions = $Get_Transactions->row();

            $where_Preview_Visit = array(
                "Transactions_id"=> $GetTransactions->transaction_id,"Coordination_uuid"=>$Coordination_id
            );

            $Get_Preview_Visit = Get_Preview_Visit($where_Preview_Visit);

            if($Get_Preview_Visit->num_rows()>0){

                $this->data['Coordination']  = $Get_Preview_Visit->row();
                $this->data['Transactions']  = $Get_Transactions->row();

            }else{
                redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
            }

        }else{
            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');
        }


        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['Page_Title']      = ' لوحة معاينة العقار  ';
        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Previewer/Dashboard_Preview_Property', $this->data, true);
        Layout_Apps($this->data);
    }
    ######################################################################################################

    ######################################################################################################
    public function Create_Preview_Property()
    {
        $Transaction_uuid  =  $this->uri->segment(4);
        $Coordination_uuid =  $this->uri->segment(5);



        $POST_Fields         = $_POST;
        $Transaction_id      = $this->input->post('Transaction_id');
        $Coordination_id     = $this->input->post('Coordination_id');

        $data_Transaction2   = array();
        $data_Transaction1   = array();
        $data_Transaction    = array();


        if ($this->input->post('Total_Land', TRUE)  == '' or
            $this->input->post('LATITUDE-15-37', TRUE)  == '' or
            $this->input->post('LONGITUDE-15-37', TRUE) == ''
        ) {
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transaction_uuid.'/'.$Coordination_uuid, 'refresh');
        }

        foreach($POST_Fields AS $key => $value)
        {

            // $_POST
            if($key == 'Start_Form_Progresses' or $key=='Transaction_id' or $key =='files_preview_ids' or $key == 'Type_Map' or $key=='preview_id' or $key =='LIST_PROPERTY_PICTURES' or $key == 'Coordination_id' or $key =='file_name' or $key =='Transactions_uuid' or $key =="ci_csrf_token" or $key =="Form_id" or $key =="FILE_Name" or $key =="FILE" or $key =="geo-zoom" or $key =='Total_Land' or $key =='Total_Building' or $key =='CONSUMPTION_RATIO' or $key =='CONSUMPTION_Total' or $key =='ESTIMATED_COSTS' or $key =='PROFIT_RATIO' or $key =='PROFIT_Total' or $key =='MARKET_VALUE' or $key =='MARKET_VALUE_Approximate' ){

            }else{

                $explode_Post = explode("-",$key);

                $Fields_Components = Query_Fields_Components(array("Forms_id"=> $explode_Post[1], "Components_id" => $explode_Post[2],"Fields_key" => $explode_Post[0]));



                if ($Fields_Components->num_rows() > 0) {

                    $Get_validating_Fields         = Get_validating_Fields(array("Forms_id" => $explode_Post[1],"Components_id" => $Fields_Components->row()->Components_id, "company_id" => 0, "Fields_id" => $Fields_Components->row()->Fields_id));

                    if ($Get_validating_Fields->num_rows() > 0) {

                        if ($Fields_Components->row()->Fields_Type == 'Fields') {
                            $Get_Fields = Get_Fields(array("Fields_id" => $Fields_Components->row()->Fields_id))->row();
                            Building_form_validation($key, $Get_Fields->item_translation, $Get_validating_Fields->row()->validating_rules);
                        } elseif ($Fields_Components->row()->Fields_Type == 'List') {
                            $Get_List = Get_All_List(array("list_id" => $Fields_Components->row()->Fields_id))->row();
                            Building_form_validation($key, $Get_List->item_translation, $Get_validating_Fields->row()->validating_rules);
                        }

                        if ($this->form_validation->run() == FALSE) {
                            $msg_result['key'] = 'Danger';
                            $msg_result['value'] = validation_errors();
                            $msg_result_view = Create_Status_Alert($msg_result);
                            set_message($msg_result_view);
                            redirect(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transaction_uuid.'/'.$Coordination_uuid, 'refresh');
                        }

                        if($this->input->post($key, TRUE) !==''){
                            $data_Transaction1[] = array(
                                "data_key"      => $explode_Post[0],
                                "preview_id"    => $Coordination_id,
                                "data_value"    => $this->input->post($key, TRUE),
                                "Forms_id"      => $explode_Post[1],
                                "Components_id" => $explode_Post[2]
                            );
                        }

                    }else{

                        if($this->input->post($key, TRUE) !=='') {
                            $data_Transaction2[] = array(
                                "data_key"      => $explode_Post[0],
                                "preview_id"    => $Coordination_id,
                                "data_value"    => $this->input->post($key, TRUE),
                                "Forms_id"      => $explode_Post[1],
                                "Components_id" => $explode_Post[2]
                            );
                        }

                    } // if ($Get_validating_Fields->num_rows() > 0)

                } // if($Fields_Components->num_rows()>0)

            } // ignore $_POST

        } // foreach ($POST_Fields AS $field)

        $data_Transaction = @array_merge($data_Transaction2,$data_Transaction1);

        $Create_Transaction_data         = Create_Transaction_Preview_data($Transaction_id,$data_Transaction);
        $Create_Transaction_data_history = Create_Transaction_Preview_history($Transaction_id,$data_Transaction,'Create');


        ################################################################
        $data_preview_evaluation['preview_id']               = $Coordination_id;
        $data_preview_evaluation['transaction_id']           = $Transaction_id;
        $data_preview_evaluation['Total_Land']               = $this->input->post('Total_Land', TRUE);
        $data_preview_evaluation['Total_Building']           = $this->input->post('Total_Building', TRUE);
        $data_preview_evaluation['CONSUMPTION_RATIO']        = $this->input->post('CONSUMPTION_RATIO', TRUE);
        $data_preview_evaluation['CONSUMPTION_Total']        = $this->input->post('CONSUMPTION_Total', TRUE);
        $data_preview_evaluation['ESTIMATED_COSTS']          = $this->input->post('ESTIMATED_COSTS', TRUE);
        $data_preview_evaluation['PROFIT_RATIO']             = $this->input->post('PROFIT_RATIO', TRUE);
        $data_preview_evaluation['PROFIT_Total']             = $this->input->post('PROFIT_Total', TRUE);
        $data_preview_evaluation['MARKET_VALUE']             = $this->input->post('MARKET_VALUE', TRUE);
        $data_preview_evaluation['MARKET_VALUE_Approximate'] = $this->input->post('MARKET_VALUE_Approximate', TRUE);
        app()->db->insert('protal_transaction_preview_evaluation',$data_preview_evaluation);
        ################################################################




        $where_Transaction_Stage = array(
            "stages_key" => 'COORDINATION_AND_QUALITY',
            "company_id" => $this->aauth->get_user()->company_id
        );
        $Get_Stages = Get_Stages_Transaction_Company($where_Transaction_Stage)->row();

        $data_Transaction_Assign = array();
        $data_Transaction_Assign['transaction_id'] = $Transaction_id;
        $data_Transaction_Assign['assign_userid']  = '1';
        $data_Transaction_Assign['assign_time']    = time();
        $data_Transaction_Assign['assign_type']    = 1;
        $Create_Transaction_Assign = Create_Transaction_Assign($data_Transaction_Assign);


        ################################################################
        # Status Stages
        $Data_Status_Stages_Transaction = array(
            "stages_key"     => 'PREVIEW',
            "stages_type"    => 'COMPLETE',
            "transaction_id" => $Transaction_id,
            "time_start"     => $this->input->post('Start_Form_Progresses'),
            "time_complete"  => time()
        );
        Create_Status_Stages_Transaction($Data_Status_Stages_Transaction);
        ################################################################

        $query = app()->db->where('transaction_id',$Transaction_id);
        $query = app()->db->set('Transaction_Status_id','350');
        $query = app()->db->set('Transaction_Stage','PROPERTY_HAS_A_PREVIEW');
        $query = app()->db->update('protal_transaction');



        if($Create_Transaction_data) {
            $msg_result['key']     = 'Success';
            $msg_result['value']   = lang('message_success_insert');
            $msg_result_view       = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transaction_uuid.'/'.$Coordination_uuid, 'refresh');
        } else {
            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transaction_uuid.'/'.$Coordination_uuid, 'refresh');
        }


    }
    ######################################################################################################

    ######################################################################################################
    public function Ajax_Comparisons_Land_Comparisons()
    {
        $HTML              = '';
        $Transaction_id    = $this->input->get('Transactions_id');
        $Coordination_id   = $this->input->get('Coordination_id');

        if($Transaction_id == '' or $Coordination_id == ''){

        }else{

            $where_Comparisons = array(
                "Transaction_id"  => $Transaction_id,
                "Coordination_id" => $Coordination_id
            );
            $Get_Comparisons =  Get_Comparisons_Land($where_Comparisons);

            if($Get_Comparisons->num_rows()>0){
                $i = 0;
                foreach ($Get_Comparisons->result() AS $Ro)
                {

                    $where_Property_Types = array("property_types_id"=>$Ro->property_types_id);
                    $Get_Property_Types   = Get_Property_Types($where_Property_Types)->row();
                    $Comparisons_type = Get_options_List_Translation($Ro->Comparisons_type);
                    $options['deleted'] = array(
                        "class" => "deleted_Comparisons",
                        "id" => "",
                        "title" => lang('deleted_button'),
                        "data-attribute" => 'data-uuid="'.$Ro->Comparisons_uuid.'"',
                        "href" => "#"
                    );

                    $Forms_Options_Button = Create_Options_Button($options);
                    $HTML .= '<tr>';
                    $HTML .= '<td class="text-center">' . ++$i.'</td>';
                    $HTML .= '<td class="text-center">' . $Comparisons_type->item_translation. '</td>';
                    $HTML .= '<td class="text-center">' . $Get_Property_Types->item_translation . '</td>';
                    $HTML .= '<td class="text-center">' . $Ro->Land_area . '</td>';
                    $HTML .= '<td class="text-center">' . $Ro->Price_per_square_meter. '</td>';
                    $HTML .= '<td class="text-center">' . $Ro->total_value_property . '</td>';
                    $HTML .= '<td class="text-center">' . $Ro->office . '</td>';
                    $HTML .= '<td class="text-center">' . $Ro->office_tel . '</td>';
                    $HTML .= '<td class="text-center">'.$Forms_Options_Button.' </td>';
                    $HTML .= '</tr>';
                }
                echo $HTML;
            }

        } // if($Transaction_id == '' or $Coordination_id == '')

    }
    ######################################################################################################

    ######################################################################################################
    public function Create_Ajax_Comparisons_Comparisons()
    {
        $Transaction_id    = $this->input->get('Transactions_id');
        $Coordination_id   = $this->input->get('Coordination_id');

        if($Transaction_id == '' or $Coordination_id == ''
            or $this->input->get('LATITUDE_Comparisons')== ''
            or $this->input->get('LONGITUDE_Comparisons')== ''
            or $this->input->get('LIST_OPERATION_TYPE')== ''
            or $this->input->get('Comparisons_type')== '' or $this->input->get('property_types_id')==''
            or $this->input->get('Land_area') == '' or $this->input->get('Price_per_square_meter') ==''
            or $this->input->get('total_value_property') =='' or $this->input->get('office')=='' or $this->input->get('office_tel') ==''){

            $msg['success']        = true;
            $msg['Type_result']    = 'error';
            $msg['Message_result'] = 'حقول اجبارية';

        }else{

            $Comparisons_data['Transaction_id']          = $Transaction_id;
            $Comparisons_data['Coordination_id']         = $Coordination_id;
            $Comparisons_data['company_id']              = app()->aauth->get_user()->company_id;
            $Comparisons_data['Comparisons_type']        = $this->input->get('Comparisons_type');
            $Comparisons_data['property_types_id']       = $this->input->get('property_types_id');

            $Comparisons_data['LATITUDE']                = $this->input->get('LATITUDE_Comparisons');
            $Comparisons_data['LONGITUDE']               = $this->input->get('LONGITUDE_Comparisons');
            $Comparisons_data['LIST_OPERATION_TYPE']     = $this->input->get('LIST_OPERATION_TYPE');

            $Comparisons_data['Land_area']               = $this->input->get('Land_area');
            $Comparisons_data['Price_per_square_meter']  = $this->input->get('Price_per_square_meter');
            $Comparisons_data['total_value_property']    = $this->input->get('total_value_property');
            $Comparisons_data['office']                  = $this->input->get('office');
            $Comparisons_data['office_tel']              = $this->input->get('office_tel');

            $Comparisons_data['Create_by']   = app()->aauth->get_user()->id;
            $Comparisons_data['Create_date'] = time();

            $Create_Comparisons_Land = Create_Comparisons_Land($Comparisons_data);

            if($Create_Comparisons_Land){
                $msg['success']        = true;
                $msg['Type_result']    = 'success';
                $msg['Message_result'] = 'تمت الاضافة بنجاح';
            }else{
                $msg['success']        = true;
                $msg['Type_result']    = 'error';
                $msg['Message_result'] = 'خطا اثناء اضافة البيانات';

            }

        } // if($Transaction_id == '' or $Coordination_id == '')

        echo json_encode($msg);

    }
    ######################################################################################################

    ######################################################################################################
    public function Deleted_Ajax_Comparisons_Land_Comparisons()
    {
        $Comparisons_uuid   = $this->input->get('Comparisons_uuid');

        $Deleted   = app()->db->where("Comparisons_uuid",$Comparisons_uuid);
        $Deleted   = app()->db->delete('portal_comparisons_info');

        if($Deleted){

            $msg['success']        = true;
            $msg['Type_result']    = 'success';
            $msg['Message_result'] = 'تمت الاضافة بنجاح';

        }else{

            $msg['success']        = true;
            $msg['Type_result']    = 'error';
            $msg['Message_result'] = 'خطا اثناء اضافة البيانات';

        }

        echo json_encode($msg);

    }
    ######################################################################################################

    ###################################################################
    public function View_Preview()
    {
        $Transaction_id  =  $this->uri->segment(4);
        $Coordination_id =  $this->uri->segment(5);


        $where_Transactions = array("uuid"=>$Transaction_id,"company_id"=> $this->aauth->get_user()->company_id,"location_id"=>$this->aauth->get_user()->locations_id);
        $Get_Transactions   = Get_Transaction($where_Transactions);

        if($Get_Transactions->num_rows()>0){

            $this->data['Transactions']   = $Get_Transactions->row();

            $where_Preview_Visit = array(
                "Transactions_id"=> $Get_Transactions->row()->transaction_id,"Coordination_uuid"=>$Coordination_id
            );
            $Get_Preview_Visit            = Get_Preview_Visit($where_Preview_Visit);
            $this->data['Coordination']   = $Get_Preview_Visit->row();

        }else{

            redirect(APP_NAMESPACE_URL . '/Transactions/', 'refresh');

        }

        $this->data['Page_Title']      = ' بيانات معاينة العقار  ';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Dashboard'));

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data['PageContent'] = $this->load->view('../../modules/App_Transactions/views/Previewer/View_Preview_Property', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################


}
?>