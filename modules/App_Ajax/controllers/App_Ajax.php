<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Ajax extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
    }
    ###################################################################

    ###################################################################
    public function index()
    {

    }
    ###################################################################

    ###############################################################################################
    public function Ajax_Components()
    {
            $lang          = get_current_lang();
            $form_id       = trim($this->input->get('form_id'));

            $CUSTOMER_CATEGORY                 = trim($this->input->get('CUSTOMER_CATEGORY'));
            $TYPE_OF_PROPERTY                  = trim($this->input->get('TYPE_OF_PROPERTY'));
            $TYPES_OF_REAL_ESTATE_APPRAISAL    = trim($this->input->get('TYPES_OF_REAL_ESTATE_APPRAISAL'));
            $LIST_CLIENT                       = trim($this->input->get('LIST_CLIENT'));
            $this->db->distinct('With_Type_CUSTOMER,With_Type_Property,With_TYPES_APPRAISAL,With_CLIENT,translation_lang');
            $this->db->from('portal_forms_components  components');
            $this->db->join('portal_forms_components_translation   components_translation', 'components.components_id = components_translation.item_id');

            if (!empty($CUSTOMER_CATEGORY)){
                $this->db->where("(FIND_IN_SET(".$CUSTOMER_CATEGORY.",components.With_Type_CUSTOMER) != 0 OR components.With_Type_CUSTOMER = 'All')");
            }

            if ($TYPE_OF_PROPERTY){
                $this->db->where("( FIND_IN_SET(".$TYPE_OF_PROPERTY.",components.With_Type_Property) !=0 OR components.With_Type_Property= 'All' )");
            }

            if ($TYPES_OF_REAL_ESTATE_APPRAISAL){
                $this->db->where("( FIND_IN_SET(".$TYPES_OF_REAL_ESTATE_APPRAISAL.",components.With_TYPES_APPRAISAL) != 0 OR components.With_TYPES_APPRAISAL = 'All')");
            }

            if ($LIST_CLIENT) {
                $this->db->where("(FIND_IN_SET(" . $LIST_CLIENT . ",components.With_CLIENT) !=0 OR components.With_CLIENT = 'All')");
            }

            $this->db->where(" (components.company_id = ".$this->aauth->get_user()->company_id." OR (components.company_id = 0 AND ( components.With_Type_CUSTOMER != 'All' OR components.With_Type_Property != 'All' OR components.With_TYPES_APPRAISAL  != 'All' OR components.With_CLIENT != 'All' )) ) ");
            $this->db->where('components.Forms_id',$form_id);

            $this->db->where('components_translation.translation_lang',$lang);
            $query = $this->db->get();

            if($query->num_rows()>0) {
                $data['query'] = $query;
                $this->load->view('../../modules/App_Ajax/Tamplet_Components_Ajax',$data);
            }
    }
    ###############################################################################################

    ###############################################################################################
    public function Ajax_LIST()
    {
        header('Content-Type: application/json');

        $lang                  = get_current_lang();
        $options               = array();


        $form_id               = trim($this->input->get('form_id'));
        $components_id         = trim($this->input->get('components_id'));
        $components_fields_id  = trim($this->input->get('components_fields_id'));
        $Fields_Type           = trim($this->input->get('Fields_Type'));
        $Fields_id             = trim($this->input->get('Fields_id'));
        $list_id               = trim($this->input->get('list_id'));
        $List_Target_id        = trim($this->input->get('List_Target_id'));
        $option_id             = trim($this->input->get('option_id'));


        $query_get_setting_list  = $this->db->where('Forms_id',$form_id);
        $query_get_setting_list  = $this->db->where('Components_id',$components_id);
        $query_get_setting_list  = $this->db->where('Components_fields_id',$components_fields_id);
        $query_get_setting_list  = $this->db->get('portal_forms_components_fields')->row();

        //_array_p($query_get_setting_list);

        ############################################################################################################################################
        if($Fields_Type == 'options_to_options_ajax'){

            $option_query  = $this->db->where('list_options_id',$option_id);
            $option_query  = $this->db->get('portal_list_options_data')->row();

            $query_options = app()->db->from('portal_list_options_data  list_options');
            $query_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
            $query_options = app()->db->where('list_options.list_id',$List_Target_id);
            $query_options = app()->db->where_in('list_options.list_options_id',$option_query->parent_id,false);
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

        }
        ############################################################################################################################################


        ############################################################################################################################################
        if($Fields_Type == 'options_to_table_ajax') {

            if($query_get_setting_list->join_table == NULL){

                $query_list_options = $this->db->where($query_get_setting_list->primary_fields_link_to_options,$option_id);
                $query_list_options = $this->db->get($query_get_setting_list->Table_primary);

                foreach ($query_list_options->result() as $row)
                {
                    $primary_fields           = $query_get_setting_list->primary_fields;
                    $Join_fields              = $query_get_setting_list->Join_fields;

                    $options[] = array(
                        "options_id"    => $row->$primary_fields,
                        "options_key"   => '',
                        "options_type"  => 'table',
                        "options_title" => $row->$Join_fields,
                    );
                }

            }else {

                $query_list_options = $this->db->from($query_get_setting_list->Table_primary . ' Table_Primary');
                $query_list_options = $this->db->join($query_get_setting_list->Table_Join . '    Table_Join', 'Table_Primary.' . $query_get_setting_list->primary_joining_fields . ' = Table_Join.' . $query_get_setting_list->Join_joining_fields . '');
                $query_list_options = $this->db->where('Table_Primary.'.$query_get_setting_list->primary_fields_link_to_options,$option_id);

                if($query_get_setting_list->linked_company_id == 1){
                    $query_list_options = $this->db->where('(Table_Primary.company_id',$this->aauth->get_user()->company_id);
                }

                if($query_get_setting_list->linked_translation == 1){
                    $query_list_options = $this->db->where('Table_Join.translation_lang',$lang);
                }

                $query_list_options = $this->db->get();

                foreach ($query_list_options->result() as $row) {

                    $Table_primary_fields = $query_get_setting_list->primary_fields;
                    $Table_Join_fields    = $query_get_setting_list->Join_fields;

                    $options[] = array(
                        "options_id"    => $row->$Table_primary_fields,
                        "options_key"   => '',
                        "options_type"  => 'table',
                        "options_title" => $row->$Table_Join_fields,
                    );

                }

            }


        }
        ############################################################################################################################################

        ############################################################################################################################################
        if($Fields_Type == 'table_to_table_ajax') {


            $query_list_options = $this->db->where($query_get_setting_list->primary_fields_link_to_options,$option_id);
            $query_list_options = $this->db->get($query_get_setting_list->Table_Join);

            if($query_get_setting_list->linked_company_id == 1){
                $query_list_options = $this->db->where('(Table_Primary.company_id',$this->aauth->get_user()->company_id);
            }

            if($query_get_setting_list->linked_translation == 1){
                $where_translation  = $query_get_setting_list->Join_fields;
                $query_list_options = $this->db->where($query_get_setting_list->Table_Join .'.'.$where_translation,$lang);
            }

            if($query_get_setting_list->linked_company_id == 1){
                $query_list_options = $this->db->where('(Table_Primary.company_id',$this->aauth->get_user()->company_id);
            }


            foreach ($query_list_options->result() as $row) {

                $Table_primary_fields = $query_get_setting_list->Join_joining_fields;
                $Table_Join_fields    = $query_get_setting_list->Join_fields;

                $options[] = array(
                    "options_id"    => $row->$Table_primary_fields,
                    "options_key"   => '',
                    "options_type"  => 'table',
                    "options_title" => $row->$Table_Join_fields,
                );

            }

        }
        ############################################################################################################################################



        $msg['type']    = true;
        $msg['data']    = $options;
        $msg['success'] = true;

        echo json_encode($msg);
    }
    ###############################################################################################

    ###############################################################################################
    public function Ajax_List_Client_by_type()
    {

        $company_id  = $this->aauth->get_user()->company_id;
        $Client_type = $this->input->get('CUSTOMER_CATEGORY');

        $query = $this->db->where('company_id', $company_id);
        $query = $this->db->where('is_active', 1);
        $query = $this->db->where_in('type_id', $Client_type);
        $query = $this->db->get('portal_app_client');

        if($query->num_rows()>0){

            foreach ($query->result() as $row) {
                $options[] = array(
                    "options_id"    => $row->client_id,
                    "options_title" => $row->name,
                );
            }

        }else{
            $options = '';
        }


        $msg['type']    = true;
        $msg['data']    = $options;
        $msg['success'] = true;

        echo json_encode($msg);

    }
    ###############################################################################################

}