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
                    $company_id = '';
                    $query_list_options = $this->db->where($query_get_setting_list->Table_primary .'.company_id',$company_id);
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
                $company_id = '';
                $query_list_options = $this->db->where($query_get_setting_list->Table_Join .'.company_id',$company_id);
            }

            if($query_get_setting_list->linked_translation == 1){
                $where_translation  = $query_get_setting_list->Join_fields;
                $query_list_options = $this->db->where($query_get_setting_list->Table_Join .'.'.$where_translation,$lang);
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

}